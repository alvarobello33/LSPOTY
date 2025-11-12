<?php

namespace App\Entities;

class Track
{
    public $id;
    public $name;
    public $cover;
    public $artist_name;
    public $artist_id;
    public $album_name;
    public $album_id;
    public $duration;
    public $player_url;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function getFormattedDuration()
    {
        $minutes = floor($this->duration / 60000);
        $seconds = floor(($this->duration % 60000) / 1000);
        return sprintf('%d:%02d', $minutes, $seconds);
    }
}