<?php

namespace App\Controllers;

use App\Models\PlaylistModel;
use App\Models\TrackModel;
use App\Entities\Track;
use App\Libraries\JamendoAPI;

class Playlist extends BaseController
{
    protected $playlistModel;
    protected $trackModel;

    public function __construct()
    {
        $this->playlistModel = new PlaylistModel();
        $this->trackModel = new TrackModel();
        helper(['form', 'url']);
    }

    // GET /my-playlists
    public function index()
    {
        $user = session()->get('user');
        $playlists = $this->playlistModel->getUserPlaylists($user['id']);

        // Pre-cargar el conteo de tracks para cada playlist
        foreach ($playlists as &$playlist) {
            $playlist['track_count'] = $this->playlistModel->getTrackCount($playlist['id']);
        }

        // Si es una solicitud AJAX (para el dropdown), devolver JSON
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'playlists' => $playlists
            ]);
        }

        $data = [
            'title' => 'My Playlists',
            'playlists' => $playlists
        ];

        return view('playlist/index', $data);
    }

    // GET /create-playlist
    public function create()
    {
        return view('playlist/create', ['title' => 'Create Playlist']);
    }

    // POST /create-playlist
    public function store()
    {
        $rules = [
            'name' => 'required|min_length[1]|max_length[255]',
            'cover' => [
                'permit_empty',
                'uploaded[cover]',
                'is_image[profile_picture]',
                'mime_in[cover,image/jpg,image/jpeg,image/png]',
                'max_size[cover,2048]',
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user = session()->get('user');
        $coverFile = $this->request->getFile('cover');

        $data = [
            'name' => $this->request->getPost('name'),
            'user_id' => $user['id']
        ];

        if ($coverFile->isValid() && !$coverFile->hasMoved()) {
            $newName = $coverFile->getRandomName();
            $coverFile->move(ROOTPATH . 'public/uploads/playlists', $newName);
            $data['cover'] = 'uploads/playlists/' . $newName;
        } else {
            $data['cover'] = 'assets/img/default-playlist.png';
        }

        $playlistId = $this->playlistModel->insert($data);

        return redirect()->to('/my-playlists')->with('success', 'Playlist created successfully');
    }

    // AJAX PUT /my-playlists/{id}
    public function update($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(405)->setJSON(['error' => 'Method Not Allowed']);
        }

        $user = session()->get('user');
        $playlist = $this->playlistModel->find($id);

        if (!$playlist || $playlist['user_id'] != $user['id']) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Forbidden']);
        }

        $rules = [
            'name' => 'required|min_length[3]|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setStatusCode(400)->setJSON(['errors' => $this->validator->getErrors()]);
        }

        $this->playlistModel->update($id, [
            'name' => $this->request->getJSON()->name
        ]);

        return $this->response->setJSON(['success' => true]);
    }

    // AJAX DELETE /my-playlists/{id}
    public function delete($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(405)->setJSON(['error' => 'Method Not Allowed']);
        }

        try {
            $user = session()->get('user');

            $playlist = $this->playlistModel->find($id);
            if (!$playlist) {
                return $this->response->setStatusCode(404)->setJSON(['error' => 'Playlist not found']);
            }

            if ($playlist['user_id'] != $user['id']) {
                return $this->response->setStatusCode(403)->setJSON(['error' => 'Forbidden']);
            }

            // Primero eliminamos los tracks asociados
            $this->trackModel->where('playlist_id', $id)->delete();

            // Luego eliminamos la playlist
            $deleted = $this->playlistModel->delete($id);

            if (!$deleted) {
                return $this->response->setStatusCode(500)->setJSON(['error' => 'Failed to delete playlist']);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Playlist deleted successfully'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error deleting playlist: '.$e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Internal Server Error']);
        }
    }

    // AJAX PUT /my-playlists/{id}/track/{trackId}
    public function addTrack($playlistId, $trackId)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(405)->setJSON(['error' => 'Method Not Allowed']);
        }

        try {
            $user = session()->get('user');

            $playlist = $this->playlistModel->find($playlistId);
            if (!$playlist) {
                return $this->response->setStatusCode(404)->setJSON(['error' => 'Playlist not found']);
            }

            // Comprobar que se intenta añadir a una playlist del usuario que envía la petición
            if ($playlist['user_id'] != $user['id']) {
                return $this->response->setStatusCode(403)->setJSON(['error' => 'Forbidden']);
            }

            // Obtener datos del track desde la API
            $api = new JamendoAPI();
            $apiTrack = $api->getTrack($trackId);
            if (!$apiTrack) {
                return $this->response->setStatusCode(404)->setJSON(['error' => 'Track not found in external service']);
            }
            $track = new Track($apiTrack);

            // Verificar si el track ya existe en la playlist
            $existingTrack = $this->trackModel
                ->where('playlist_id', $playlistId)
                ->where('artist_id', $track->artist_id)
                ->where('name', $track->name)
                ->first();

            if ($existingTrack) {
                return $this->response->setStatusCode(409)->setJSON(['error' => 'Track already exists in playlist']);
            }

            $trackData = [
                'api_id' => $track->id,     // Lo formateamos debido a que el id en la bbdd se guardará como api_id
                'name' => $track->name,
                'cover' => $track->cover ?? null,
                'artist_id' => $track->artist_id,
                'artist_name' => $track->artist_name,
                'album_id' => $track->album_id ?? null,
                'album_name' => $track->album_name ?? null,
                'duration' => $track->duration,
                'player_url' => $track->player_url,
                'playlist_id' => $playlistId,
            ];

            // Insertar en base de datos
            $inserted = $this->trackModel->insert($trackData);
            if (!$inserted) {
                $error = $this->trackModel->errors();
                $db = \Config\Database::connect();
                $dbError = $db->error();

                log_message('error', 'DB Error: ' . print_r($dbError, true));
                log_message('error', 'Failed to insert track: ' . print_r($error, true));

                return $this->response->setStatusCode(500)->setJSON(['success' => false, 'error' => 'Failed to add track: '. print_r($error, true)]);
            }

            return $this->response->setJSON([
                'success' => true,
                'track' => $trackData,
                'message' => 'Track added successfully'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error adding track: '.$e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['error' => $e->getMessage()]);
        }
    }

    // AJAX DELETE /my-playlists/{id}/track/{trackId}
    public function removeTrack($playlistId, $trackId)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(405)->setJSON(['error' => 'Method Not Allowed']);
        }

        try {
            $user = session()->get('user');

            $playlist = $this->playlistModel->find($playlistId);
            if (!$playlist) {
                return $this->response->setStatusCode(404)->setJSON(['error' => 'Playlist not found']);
            }

            if ($playlist['user_id'] != $user['id']) {
                return $this->response->setStatusCode(403)->setJSON(['error' => 'Forbidden']);
            }

            $track = $this->trackModel
                ->where('playlist_id', $playlistId)
                ->where('id', $trackId)
                ->first();

            if (!$track) {
                return $this->response->setStatusCode(404)->setJSON(['error' => 'Track not found in playlist']);
            }

            $deleted = $this->trackModel
                ->where('playlist_id', $playlistId)
                ->where('id', $trackId)
                ->delete();

            if (!$deleted) {
                return $this->response->setStatusCode(500)->setJSON(['error' => 'Failed to remove track']);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Track removed successfully'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error removing track: '.$e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Internal Server Error']);
        }
    }

    // Muestra los detalles de una canción
    public function show($id)
    {
        $user = session()->get('user');
        $playlist = $this->playlistModel->find($id);

        if (!$playlist) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Playlist not found']);
        }

        if ($playlist['user_id'] != $user['id']) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Forbidden']);
        }

        // Obtener tracks
        $playlist['tracks'] = $this->trackModel->getTracksByPlaylist($id);

        // Para debug
        //log_message('debug', 'Playlist data: '.print_r($playlist, true));

        return $this->response->setJSON([
            'success' => true,
            'playlist' => $playlist
        ]);
    }
}