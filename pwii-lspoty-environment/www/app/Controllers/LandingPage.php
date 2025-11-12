<?php
namespace App\Controllers;

class LandingPage extends BaseController
{
    public function index()
    {
        //Si l'usuari te sessio actova el redirigim a la homepage (/home)
        if (session()->has('user')) {
            return redirect()->to(route_to('home-view'));
        }

        //Si no hi ha sessió activa mostrem la landing page
        return view('landing-page');
    }
}
