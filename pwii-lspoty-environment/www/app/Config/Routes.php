<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//Landing Page (Pagina Inici si no estas logejat)
$routes->get('/', 'LandingPage::index', ['as' => 'landing-page-view']);

//Home Page (Pàgina d'inici si estas logejat)
$routes->get('/home', 'Home::index', ['filter' => 'auth', 'as' => 'home-view']);

//Detalls album
$routes->get('album/(:num)', 'AlbumDetails::showDetails/$1', ['filter' => 'auth', 'as' => 'album-details-view']);

//Detalls artista
$routes->get('artist/(:num)', 'ArtistDetails::showDetails/$1', ['filter' => 'auth', 'as' => 'artist-details-view']);

//Detalls playlist
$routes->get('playlist/(:num)', 'PlaylistDetails::showDetails/$1', ['filter' => 'auth', 'as' => 'playlist-details-view']);


//Pàgina Registre
$routes->get('/sign-up', 'Authentication::signUp', ['as' => 'sign-up-view']);
$routes->post('/sign-up', 'Authentication::register', ['as' => 'sign-up-post']);

//Pàgina Login
$routes->get('/sign-in', 'Authentication::signIn', ['as' => 'sign-in-view']);
$routes->post('/sign-in', 'Authentication::login', ['as' => 'sign-in-post']);

//Logout
$routes->get('/sign-out', 'Authentication::logout', ['filter' => 'auth', 'as' => 'sign-out-view']);

// Profile
$routes->group('/profile', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Profile::index');
    $routes->get('edit', 'Profile::edit');
    $routes->post('update', 'Profile::update');
});

//Playlists

$routes->group('create-playlist', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Playlist::create');
    $routes->post('/', 'Playlist::store');
});

$routes->group('my-playlists', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Playlist::index');
    $routes->get('(:num)', 'Playlist::show/$1');

    $routes->put('(:num)', 'Playlist::update/$1');
    $routes->delete('(:num)', 'Playlist::delete/$1');
    $routes->put('(:num)/track/(:num)', 'Playlist::addTrack/$1/$2');
    $routes->delete('(:num)/track/(:num)', 'Playlist::removeTrack/$1/$2');
});