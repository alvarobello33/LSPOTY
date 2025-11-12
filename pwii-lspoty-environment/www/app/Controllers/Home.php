<?php
namespace App\Controllers;

use App\Libraries\JamendoAPI;
use App\Entities\Track;

class Home extends BaseController
{
    //Mètode pel homepage i la barra de cerca
    public function index()
    {
        //Agafem les dades de l'usuari per la vista
        $user     = session()->get('user');
        $username = $user['username'];

        //Creem el client de jamendo
        $api = new JamendoAPI();

        //Try-Catch per mostrar un error si no es troben les popular tracks
        try{
            //obtenim les cançons populars per omplir el homepage inicialment
            $arrayPopularTracks = $api->getPopularTracks(10);
        } catch (\RuntimeException $e) {
            //Fem un missatge flash amb l'error de status code (definit a JamendoAPI)
            session()->setFlashdata('error', $e->getMessage());
            //Retornem l'array buit de popularTracks
            $arrayPopularTracks = [];
        }

        //Convertim cada array de popularTracks en un objecte Track
        $popularTracks = array_map(function(array $track) {
            return new Track([
                'id'            => $track['id'],
                'name'          => $track['name'],
                'cover'         => $track['image'] ?? '',
                'artist_name'   => $track['artist_name'] ?? '',
                'artist_id'     => $track['artist_id'] ?? null,
                'album_name'    => $track['album_name'] ?? '',
                'album_id'      => $track['album_id'] ?? null,
                'duration'      => (int)$track['duration'],
                'player_url'    => $track['audio'] ?? '',
            ]);
        }, $arrayPopularTracks);

        //Agafem els parametres de cerca (text i tipus)
        $searchText = $this->request->getGet('searchText');
        $type = $this->request->getGet('type') ?? 'tracks';

        $results = [];

        //Si hi ha text de cerca, fem la crida a la api Jamendo
        if ($searchText) {
            try{
                $tempResults = $api->search($type, $searchText, 20);

                //Si la cerca és de cançons, convertim a objecte Track
                if ($type === 'tracks') {

                    $results = array_map(function(array $track) {
                        return new Track([
                            'id'            => $track['id'],
                            'name'          => $track['name'],
                            'cover'         => $track['image'] ?? '',
                            'artist_name'   => $track['artist_name'] ?? '',
                            'artist_id'     => $track['artist_id'] ?? null,
                            'album_name'    => $track['album_name'] ?? '',
                            'album_id'      => $track['album_id'] ?? null,
                            'duration'      => (int)$track['duration'],
                            'player_url'    => $track['audio'] ?? '',
                        ]);
                    }, $tempResults);

                } else {

                    //Si la cerca es d'albums, artistes o playlist o deixem igual
                    $results = $tempResults;
                }
            } catch (\RuntimeException $e) {
                //Fem un missatge flash amb l'error de status code (definit a JamendoAPI)
                session()->setFlashdata('error', $e->getMessage());
            }
        }

        //Passem els resultats a la vista de homepage
        return view('home-page', [
            'username' => $username,
            'popularTracks' => $popularTracks,
            'searchText' => $searchText,
            'type' => $type,
            'results' => $results,
        ]);
    }
}
