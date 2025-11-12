<?php

namespace App\Models;

use CodeIgniter\Model;

class TrackModel extends Model
{
    protected $table = 'tracks';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'api_id',
        'name',
        'cover',
        'artist_id',
        'artist_name',
        'album_id',
        'album_name',
        'duration',
        'player_url',
        'playlist_id',

    ];

    protected $validationRules = [
        'name'        => 'required',
        'artist_id'   => 'required',
        'artist_name' => 'required',
        'duration'    => 'required|numeric',
        'player_url'  => 'required|valid_url',
        'playlist_id' => 'required|integer|is_not_unique[playlists.id]',
    ];

    protected $useSoftDeletes = false;

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $dateFormat = 'datetime';

    /**
     * Obtiene todas las canciones de una playlist
     */
    public function getTracksByPlaylist($playlistId)
    {
        return $this->where('playlist_id', $playlistId)->findAll();
    }

    /**
     * Añade una nueva canción a la playlist
     */
    public function addTrackToPlaylist(array $trackData)
    {
        return $this->insert($trackData);
    }

    /**
     * Elimina una canción de la playlist
     */
    public function removeTrackFromPlaylist($trackId)
    {
        return $this->delete($trackId);
    }

    /**
     * Busca canciones por nombre o artista
     */
    public function searchTracks($query)
    {
        return $this->like('name', $query)
            ->orLike('artist_name', $query)
            ->findAll();
    }
}