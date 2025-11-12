<?php

namespace App\Models;

use CodeIgniter\Model;

class PlaylistModel extends Model
{
    protected $table = 'playlists';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name',
        'cover',
        'user_id',
        'created_at',
        'updated_at'
    ];

    protected $useAutoIncrement = true;
    protected $useSoftDeletes = false;
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $dateFormat = 'datetime';

    /**
     * Obtiene todas las playlists de un usuario
     */
    public function getUserPlaylists($userId)
    {
        return $this->where('user_id', $userId)->findAll();
    }

    /**
     * Crea una nueva playlist
     */
    public function createPlaylist(array $playlistData)
    {
        return $this->insert($playlistData);
    }

    /**
     * Actualiza una playlist existente
     */
    public function updatePlaylist($id, array $playlistData)
    {
        return $this->update($id, $playlistData);
    }

    /**
     * Elimina una playlist y todas sus canciones
     */
    public function deletePlaylist($id)
    {
        // Primero eliminamos las canciones asociadas
        $trackModel = new \App\Models\TrackModel();
        $trackModel->where('playlist_id', $id)->delete();

        // Luego eliminamos la playlist
        return $this->delete($id);
    }

    /**
     * Obtiene una playlist con todas sus canciones
     */
    public function getPlaylistWithTracks($id)
    {
        $playlist = $this->find($id);
        if ($playlist) {
            $trackModel = new \App\Models\TrackModel();
            $playlist['tracks'] = $trackModel->getTracksByPlaylist($id);
        }
        return $playlist;
    }

    /**
     * Obtiene el número de tracks en una playlist
     *
     * @param int $playlistId
     * @return int
     */
    public function getTrackCount($playlistId)
    {
        return $this->db->table('tracks')
            ->where('playlist_id', $playlistId)
            ->countAllResults();
    }
}