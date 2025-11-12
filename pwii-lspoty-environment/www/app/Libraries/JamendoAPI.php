<?php


namespace App\Libraries;

use GuzzleHttp\Client;

//Classe per controlar les peticions a l'API de Jamendo

//INFO Llibreries Codeigniter:
//https://codeigniter4.github.io/userguide/concepts/structure.html
//https://codeigniter.com/userguide3/general/creating_libraries.html


//INFO estructura peticions API:
//Albums: https://developer.jamendo.com/v3.0/albums
//Artists: https://developer.jamendo.com/v3.0/artists
//Playlists: https://developer.jamendo.com/v3.0/playlists


class JamendoAPI
{

    private Client $client;

    //ClientID API Jamendo
    private string $clientID = '88faf08d';

    //Constructor per carregar la clauID de Jamendo i configurar el guzzle
    //INFO Guzzle: https://docs.guzzlephp.org/en/stable/quickstart.html
    public function __construct(){

        //Creem un client Guzzle amb la base_uri de Jamendo
        $this->client = new Client([
            'base_uri' => 'https://api.jamendo.com/v3.0/',
            'timeout'  => 10.0,
        ]);
    }

    //Mètode per fer peticions GET i retornar l'array amb els resultats
    private function getData(string $uri, array $query = []): array
    {
        //Fem la peticio request
        try{
            $response = $this->client->request('GET', $uri, [
                'query' => array_merge($query, [
                    'client_id' => $this->clientID,
                    'format' => 'json',
                ]),
            ]);
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            //Error de connexió
            throw new \RuntimeException(lang('app.errorGuzzle') . $e->getMessage());
        }

        //Control dels status codes de la petició a la API
        $status = $response->getStatusCode();
        if ($status != 200) {

            //Comprovem el Code rebut si no és el 200=OK
            switch($status){
                //Errors de Client (Familia 400)
                case 400:
                    throw new \RuntimeException(lang('app.errorStatusCode400'));
                case 401:
                    throw new \RuntimeException(lang('app.errorStatusCode401'));
                case 403:
                    throw new \RuntimeException(lang('app.errorStatusCode403'));
                case 404:
                    throw new \RuntimeException(lang('app.errorStatusCode404'));
                case 429:
                    throw new \RuntimeException(lang('app.errorStatusCode429'));

                //Errors de Servidor (Familia 500)
                case 500:
                    throw new \RuntimeException(lang('app.errorStatusCode500'));
                case 502:
                    throw new \RuntimeException(lang('app.errorStatusCode502'));
                case 503:
                    throw new \RuntimeException(lang('app.errorStatusCode503'));
                case 504:
                    throw new \RuntimeException(lang('app.errorStatusCode504'));

                default:
                    throw new \RuntimeException(lang('app.errorStatusCodeDefault', [$status]));
            }
        }

        //Response CODE 200 = OK

        //Decodifiquem el body de la resposta
        $body = json_decode($response->getBody()->getContents(), true);

        //Retorenm l'array amb el contingut de results o un array buit si no hi ha res
        return $body['results'] ?? [];
    }

    //Mètode per fer una cerca a Jamendo segons tipus (tracks, albums, etc) i una paraula clau i retornar un array amb els resultats
    public function search(string $type, string $searchText, int $limit = 20): array
    {
        //Definim les opcions de cerca valides
        $validSearch = ['tracks', 'albums', 'artists', 'playlists'];

        //Si la cerca és invalida, llencem un error de tipus invalid
        if (!in_array($type, $validSearch, true)) {
            throw new \InvalidArgumentException('Invalid search type:' . $type);
        }

        //Endpoint Jamendo fa servir:
        //name = busca el nom exacte
        //namesearch = busca coincidencies de nom
        //https://developer.jamendo.com/v3.0/albums

        //Si la cerca es correcte, retornem els resultats
        return $this->getData($type, [
            'namesearch' => $searchText,
            'limit' => $limit,
        ]);

    }

    //Mètode per obtenir les dades d'un artista i els seus albums
    public function getArtist(int $id): array
    {
        $artists = $this->getData('artists', [
            'id' => $id,
        ]);

        //Si no hi ha resultats retornem un array buit
        if (empty($artists)) {
            return [];
        }

        //Si la cerca té resultats:

        //Agafem el primer element = artista
        $artistData = $artists[0];

        //Agafem i retornem nomes els camps que volem
        return[
            'id' => $artistData['id'],
            'name' => $artistData['name'],
            'image' => $artistData['image'] ?? '',
            'join_date' => $artistData['joindate'] ?? '',

            //Agafem els valors que ens interessa dels albums
            'albums' => array_map(function ($album) {
                return [
                    'id' => $album['id'],
                    'name' => $album['name'],
                    'release_date' => $album['releasedate'],
                    'image' => $album['image'] ?? '',
                ];
            }, $artistData['albums'] ?? []),
        ];

    }

    //Mètode per obtenir les dades d'un album
    public function getAlbum(int $id): array
    {
        //Fem la crida a albums i incluim tracks i artista
        $albums = $this->getData('albums', [
            'id' => $id,
            'include' => 'tracks+artists',
        ]);

        //Si no hi ha resultats retornem array buit
        if (empty($albums)) {
            return [];
        }

        //Si hi ha resultats:

        //Agafem l'album
        $albumData = $albums[0];

        //Obtenim el total duration de les cançons
        $totalDuration = array_sum(array_column($albumData['tracks'] ?? [], 'duration'));

        //Construim l'array amb les dades que necessitem
        return[
            //Agafem les dades
            'id' => $albumData['id'], //ID album
            'name' => $albumData['name'], //Nom album
            'cover' => $albumData['image'] ?? '', //Cover (imagte) de lalbum
            'artist' => [
                'id' => $albumData['artist_id'], //ID artista
                'name' => $albumData['artist_name'], //Nom artista
            ],
            'release_date' => $albumData['releasedate'] ?? '', //Data publicacio
            'tracks' => array_map(function ($track) {

                //agafem de cada canço les dades que volem
                return [
                    'id' => $track['id'], //id canço
                    'name' => $track['name'], //nom canço
                    'duration' => (int) $track['duration'], //Duracio en segons
                    'audio' => $track['audio'], //URL de l'audio
                    'position' => (int) $track['position'], //posicio dins de lalbum per ordenarles
                ];
            }, $albumData['tracks'] ?? []),

            'total_duration' => (int) $totalDuration, //suma total de la durada en segons de totes les cançons de lalbum
        ];
    }

    //Mètode per obtenir una playlist i les seves cançons
    public function getPlaylist(int $id): array
    {
        //Obtenim la informacio de la playlist
        $playlists = $this->getData('playlists', [
            'id' => $id,
        ]);

        //si no existeix retorenm array buit
        if (empty($playlists)) {
            return [];
        }

        //Si existeix:

        $playlistData = $playlists[0];

        //Obtenim les cançons de la playlist (endpoint API /playlists/tracks)
        $tracksList = $this->getData('playlists/tracks', [
            'playlist_id' => $id,
            'limit' => 200,
        ]);

        //l'api ens retorna un array amb un sol element que conté 'tracks'
        $tracksData = $tracksList[0]['tracks'] ?? [];

        //Agafem la informació que volem de les cançons
        $tracks = array_map(function (array $track) {
            return [
                'id' => $track['id'],
                'name' => $track['name'],
                'duration' => (int)$track['duration'],
                'audio' => $track['audio'] ?? '',
            ];
        }, $tracksData);

        //Calculem la durada total de les cançons de la playlist
        $totalDuration = array_sum(array_column($tracksData, 'duration'));

        //generem l'array final que retornarem
        return [
            'id' => $playlistData['id'],
            'name' => $playlistData['name'],
            'cover' => $playlistData['image'] ?? '',
            'tracks' => $tracks,
            'total_duration' => $totalDuration,
        ];
    }

    //Mètode per obtenir 10 cançons populars per omplir el homepage
    public function getPopularTracks(int $limit = 10): array
    {
        return $this->getData('tracks', [
            'limit' =>$limit,
            'order' => 'popularity_week',
        ]);
    }

    //Mètode per obtenir els albums d'un artista
    public function getArtistAlbums(int $artistId): array
    {
        //obtenim l'array d'artista amb albums de l'endpoint artists/albums
        $artistData = $this->getData('artists/albums', [
            'id' => $artistId,
            'limit' => 200,
        ]);

        //si no hi ha l'artista o no te albums retornem l'array buit
        if (empty($artistData) || ! isset($artistData[0]['albums'])){
            return [];
        }

        //extraiem els albums de l'artista
        $albumsList = $artistData[0]['albums'];

        //mapegem l'array d'albums per retornar la info dels albums de l'artista
        return array_map(function ($album) {
            return [
                'id' => $album['id'],
                'name' => $album['name'],
                'release_date' => $album['releasedate'] ?? '',
                'image' => $album['image'] ?? '',
            ];
        }, $albumsList);
    }

    //Mètode per obtenir les cançons d'un àlbum
    public function getAlbumTracks(int $albumId): array
    {
        //obtenim la info de l'endpoint /albums/tracks
        $albumsData = $this->getData('albums/tracks', [
            'id' => $albumId,
            'limit' => 200,
        ]);

        //si no hi ha l'album o no te cançons retornem l'array buit
        if (empty($albumsData) || ! isset($albumsData[0]['tracks'])){
            return [];
        }

        //extraiem les cançons de l'album
        $tracksList = $albumsData[0]['tracks'];

        //mapegem les cançons per retornar la informacio que volem
        return array_map(function ($track) {
            return [
                'id' => $track['id'],
                'name' => $track['name'],
                'duration' => (int) $track['duration'],
                'position' => (int) $track['position'],
                'audio' => $track['audio'] ?? '',
            ];
        }, $tracksList);
    }

    //Mètode per obtenir les cançons d'una playlist
    public function getPlaylistTracks(int $playlistId): array
    {
        //obtenim la info de l'endpoint /playlists/tracks
        $playlistData = $this->getData('playlists/tracks', [
            'id' => $playlistId,
            'limit' => 200,
        ]);

        //si no hi ha la playlist o no te cançons retornem l'array buit
        if (empty($playlistData) || ! isset($playlistData[0]['tracks'])){
            return [];
        }

        //extraiem les cançons de la playlist
        $tracksList = $playlistData[0]['tracks'];

        //mapegem les cançons de la playlist per retornar el llistat de les cançons amb la informacio que volem
        return array_map(function ($track) {
            return [
                'id'       => $track['id'],
                'name'     => $track['name'],
                'duration' => (int) $track['duration'],
                'position' => (int) $track['position'] ?? 0,
                'audio'    => $track['audio'] ?? '',
                'artist_id' => $track['artist_id'] ?? null,
                'artist_name' => $track['artist_name'] ?? '',
                'album_id'   => $track['album_id']   ?? null,
                'album_name' => $track['album_name'] ?? '',
            ];
        }, $tracksList);
    }

    /**
     * Funcion para obtener los detalles de un track específico por su ID
     *
     * @param int $trackId El ID del track a buscar
     * @return array Los datos del track o array (vacío si no se encuentra)
     */
    public function getTrack(int $trackId): array
    {
        // Hacemos la petición al endpoint de tracks con el ID específico
        $tracks = $this->getData('tracks', [
            'id' => $trackId,

        ]);

        // Si no hay resultados hacemos return de array vacío
        if (empty($tracks)) {
            return [];
        }

        // Tomamos el primer track (debería ser el único con ese ID)
        $trackData = $tracks[0];

        // devolvemos array con los datos que necesitamos
        return [
            'id' => $trackData['id'],
            'name' => $trackData['name'],
            'cover' => $trackData['image'] ?? '',
            'artist_id' => $trackData['artist_id'],
            'artist_name' => $trackData['artist_name'],
            'album_id' => $trackData['album_id'] ?? null,
            'album_name' => $trackData['album_name'] ?? '',
            'duration' => (int)$trackData['duration'],
            'player_url' => $trackData['audio'] ?? '',
        ];
    }
}