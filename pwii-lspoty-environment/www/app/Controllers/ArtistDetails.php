<?php

namespace App\Controllers;

use App\Libraries\JamendoAPI;
use CodeIgniter\Exceptions\PageNotFoundException;

class ArtistDetails extends BaseController
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
            //obtenim l'artista fent la crida a l'api
            $artist = $api->getArtist($id);
        } catch (\RuntimeException $e) {
            //Si no el trobem dirigim al Page Not Found
            throw PageNotFoundException::forPageNotFound();
        }


        //Si l'artista esta buit dirigim al Page Not Found
        if (empty($artist)) {
            throw PageNotFoundException::forPageNotFound();
        }

        //agafem els albums d l'artista
        $artist['albums'] = $api->getArtistAlbums($id);

        //Si existeix passem els detalls de l'artista a la vista
        return view('artist-details-view', ['artist' => $artist]);

    }
}
