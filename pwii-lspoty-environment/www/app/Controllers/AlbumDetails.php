<?php

namespace App\Controllers;

use App\Libraries\JamendoAPI;

//https://codeigniter.com/user_guide/general/errors.html
use CodeIgniter\Exceptions\PageNotFoundException;

class AlbumDetails extends BaseController
{
    public function showDetails(int $id)
    {
        //Si no hi ha sessió activa redirigim a la landing page
        if (! session()->has('user')) {
            return redirect()->to(route_to('landing-page-view'));
        }

        //Creem el client de jamendo
        $api = new JamendoAPI();

        try {
            //obtenim l'album fent la crida a l'api amb l'id corresponent
            $album = $api->getAlbum($id);
        } catch (\RunTimeException $e) {
            //Si no el trobem dirigim al Page Not Found
            throw PageNotFoundException::forPageNotFound();
        }

        //Si l'album està buit dirigim al Page Not Found
        if (empty($album)) {
            throw PageNotFoundException::forPageNotFound();
        }

        //carreguem les cançons de l'album
        $album['tracks'] = $api->getAlbumTracks($id);

        //Ordenem el llistat de cançons segons la seva posicio dins l'album
        usort($album['tracks'], function ($a, $b) {
            return $a['position'] <=> $b['position'];
        });

        //calculem la durada total de les cançons
        $album['total_duration'] = array_sum(array_column($album['tracks'], 'duration'));

        //Passem els detalls de l'album a la vista
        return view('album-details-view', ['album' => $album]);

    }
}
