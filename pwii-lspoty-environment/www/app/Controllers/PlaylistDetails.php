<?php

namespace App\Controllers;

use App\Libraries\JamendoAPI;
use CodeIgniter\Exceptions\PageNotFoundException;

class PlaylistDetails extends BaseController
{
    public function showDetails(int $id)
    {
        //Si no hi ha sessió activa redirigim a la landing page
        if (! session()->has('user')) {
            return redirect()->to(route_to('landing-page-view'));
        }

        //Creem el client de jamendo
        $api = new JamendoAPI();

        try{
            //obtenim la playlist fent la crida a l'api amb l'id corresponent
            $playlist = $api->getPlaylist($id);
        } catch (\RuntimeException $e) {
            //Si la playlist esta buiad dirigim al Page Not Found
            throw PageNotFoundException::forPageNotFound();
        }

        //Si no existeix retornem un error
        if (empty($playlist)) {
            throw PageNotFoundException::forPageNotFound();
        }

        //carreguem les cançons de la playlist
        $playlist['tracks'] = $api->getPlaylistTracks($id);

        //Ordenem el llistat de cançons segons la seva posicio dins la playlist
        usort($playlist['tracks'], function ($a, $b) {
            return $a['position'] <=> $b['position'];
        });

        //calculem la durada total de les cançons
        $playlist['total_duration'] = array_sum(array_column($playlist['tracks'], 'duration'));

        //Passem els detalls de la playlist a la vista
        return view('playlist-details-view', ['playlist' => $playlist]);

    }
}
