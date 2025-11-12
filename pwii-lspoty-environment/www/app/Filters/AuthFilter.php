<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    // Comprobar si el usuario ha iniciado sesión
    public function before(RequestInterface $request, $arguments = null)
    {
        //Si no hi ha sessió iniciada, redirigim al landing page
        if (! session()->has('user')) {
            return redirect()->to(route_to('landing-page-view'));
        }
        //Si hi ha sessió iniciada, deixem continuar
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //No cal fer res per after
    }
}