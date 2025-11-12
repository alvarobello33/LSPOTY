$(document).ready(function() {

    // Manejar la apertura del menú desplegable
    $('.add-to-playlist').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        const dropdown = $(this).next('.playlist-dropdown');
        const trackId = $(this).data('track-id');

        // Solo cargar las playlists una vez
        if (!dropdown.data('loaded')) {
            $.ajax({
                url: window.translations.routeMyPlaylists,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    dropdown.empty();

                    if (response.playlists && response.playlists.length > 0) {
                        response.playlists.forEach(function(playlist) {
                            // guardamos ids para petición si se quiere añadir track a playlist
                            dropdown.append(`
                                <li>
                                    <a class="dropdown-item playlist-item"
                                       href="#"
                                       data-playlist-id="${playlist.id}"
                                       data-track-id="${trackId}">
                                        ${playlist.name} (${playlist.track_count} tracks)
                                    </a>
                                </li>
                            `);
                        });
                    } else {
                        dropdown.append(`
                            <li><a class="dropdown-item disabled" href="#">
                                ${window.translations.noPlaylists}
                            </a></li>
                        `);
                    }

                    dropdown.data('loaded', true);
                },
                error: function(xhr) {
                    console.error('Error loading playlists:', xhr.responseText);
                    dropdown.empty().append(`
                        <li><a class="dropdown-item disabled" href="#">
                            ${window.translations.errorLoadingPlaylists}
                        </a></li>
                    `);
                }
            });
        }
    });

    // Manejar selección de una playlist
    $(document).on('click', '.playlist-item', function(e) { // No se puede usar handler directo, debido a que los elementos '.playlist-item' han sido creados dinámicamente
        e.preventDefault();
        e.stopPropagation();

        const playlistId = $(this).data('playlist-id');
        const trackId = $(this).data('track-id');

        $.ajax({
            url: `/my-playlists/${playlistId}/track/${trackId}`,
            type: 'PUT',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Mostrar notificación de éxito más elegante
                    showToast('success', response.message || window.translations.trackAdded);
                } else {
                    showToast('error', response.error || window.translations.unknownError);
                }
            },
            error: function(xhr) {
                // Captura errores para debugging
                console.log("Error en AJAX:", xhr.responseText, error);
                let errorMsg = window.translations.addTrackError;
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMsg = xhr.responseJSON.error;
                }
                showToast('error', errorMsg);
            }
        });
    });

    // Event listener para los botones de play
    $(document).on('click', '.play-track', function(e) {
        e.preventDefault();
        e.stopPropagation();

        const audioUrl = $(this).data('audio');
        const title = $(this).data('title');
        const artist = $(this).data('artist');

        console.log('Reproduciendo:', title, 'de', artist, 'URL:', audioUrl); // Debug

        // Llama a la función global del reproductor
        playSingleTrack(audioUrl, title, artist);
    });

    function showToast(type, message) {
        const toast = `
            <div class="position-fixed top-0 end-0 p-3" style="z-index: 1100">
                <div class="toast show align-items-center text-white bg-${type}" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">${message}</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            </div>`;

        $('body').append(toast);
        setTimeout(() => $('.toast').remove(), 3000);
    }

});
