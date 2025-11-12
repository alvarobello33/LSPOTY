// Cuando carque la página
$(document).ready(function() {

    $('.btn').click(function(e) {
        e.stopPropagation(); // Esto evita que al pulsar un botón que se encuentre dentro de otro se activen los dos
    });

    // Editar playlist
    $('.edit-playlist').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        const playlistId = $(this).data('id');
        const playlistName = $(this).closest('.playlist-card').find('.card-title').text();

        $('#edit_playlist_id').val(playlistId);
        $('#edit_playlist_name').val(playlistName);
        $('#editPlaylistModal').modal('show');
    });

    // Guardar cambios Playlist
    $('#save-playlist-changes').click(function() {
        const playlistId = $('#edit_playlist_id').val();
        const playlistName = $('#edit_playlist_name').val();

        $.ajax({
            url: `/my-playlists/${playlistId}`,
            type: 'PUT',
            contentType: 'application/json',
            data: JSON.stringify({ name: playlistName }),
            success: function(response) {
                if (response.success) {
                    $(`[data-id="${playlistId}"] .card-title`).text(playlistName);
                    $('#editPlaylistModal').modal('hide');
                }
            },
            error: function(xhr) {
                alert(window.translations.update_error);
            }
        });
    });

    // Delete Playlist
    $('.delete-playlist').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        if (confirm(window.translations.delete_confirm)) {
            const playlistId = $(this).data('id');

            $.ajax({
                url: `/my-playlists/${playlistId}`,
                type: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        $(`[data-id="${playlistId}"]`).remove();
                    }
                },
                error: function(xhr) {
                    alert(window.translations.delete_error);
                }
            });
        }
    });
});

function showPlaylistDetails(playlistId) {
    $.ajax({
        url: `/my-playlists/${playlistId}`, // Usando la ruta correcta
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Set playlist info
                $('#playlistDetailsTitle').text(response.playlist.name);
                $('#playlistDetailsName').text(response.playlist.name);

                // Manejar la imagen de portada
                const coverPath = response.playlist.cover
                    ? BASE_URL + response.playlist.cover
                    : DEFAULT_PLAYLIST_IMG;

                $('#playlistDetailsCover').attr('src', coverPath);

                // Configurar botón de play playlist para reproducir desde el inicio
                $('#playPlaylistBtn').on('click').click(function() {
                    const tracks = response.playlist.tracks.map(track => ({
                        audio: track.player_url,
                        name: track.name,
                        artist_name: track.artist_name
                    }));
                    playPlaylist(tracks, 0); // Empieza desde el índice 0
                });

                // Load tracks
                const tracksList = $('#playlistTracksList');
                tracksList.empty();

                if (response.playlist.tracks && response.playlist.tracks.length > 0) {
                    response.playlist.tracks.forEach((track, index) => {
                        const duration = formatDuration(track.duration);
                        tracksList.append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${track.name}</td>
                                <td>${track.artist_name}</td>
                                <td>${track.album_name}</td>
                                <td>${duration}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary" onclick="playPlaylistFromTrack(${playlistId}, ${index})">
                                        <i class="fas fa-play"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" onclick="removeTrack(${playlistId}, '${track.id}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `);
                    });
                } else {
                    tracksList.append(`
                        <tr>
                            <td colspan="6" class="text-center text-muted">${window.translations.no_tracks}</td>
                        </tr>
                    `);
                }

                $('#playlistDetailsModal').modal('show');
            } else {
                alert(response.error || window.translations.load_error);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
            console.log('Response:', xhr.responseText);
            alert(window.translations.details_error);
        }
    });
}

// Función para reproducir desde un track específico
function playPlaylistFromTrack(playlistId, trackIndex) {
    $.ajax({
        url: `/my-playlists/${playlistId}`,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success && response.playlist.tracks) {
                const tracks = response.playlist.tracks.map(track => ({
                    audio: track.player_url,
                    name: track.name,
                    artist_name: track.artist_name
                }));
                playPlaylist(tracks, trackIndex);
            }
        },
        error: function() {
            alert(window.translations.load_error);
        }
    });
}

function removeTrack(playlistId, trackId) {
    if (confirm(window.translations.remove_track_confirm)) {
        $.ajax({
            url: `/my-playlists/${playlistId}/track/${trackId}`,
            type: 'DELETE',
            success: function(response) {
                if (response.success) {
                    showPlaylistDetails(playlistId); // Refresh the list
                }
            },
            error: function(xhr) {
                alert(window.translations.remove_track_error);
            }
        });
    }
}

function formatDuration(ms) {
    // Convert milliseconds to minutes:seconds format
    const minutes = Math.floor(ms / 60000);
    const seconds = ((ms % 60000) / 1000).toFixed(0);
    return `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
}