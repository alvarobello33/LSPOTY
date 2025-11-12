//Script pel reproductor de musica
//Font:
//https://webdesign.tutsplus.com/build-a-custom-html-music-player-using-javascript-and-the-web-audio-api--cms-93300t

document.addEventListener('DOMContentLoaded', function() {
    const player = document.getElementById('playerBar-audio');
    const titleElement = document.getElementById('playerBar-title');
    const artistElement = document.getElementById('playerBar-artist');
    const playPauseBtn = document.querySelector('#playerBar-audio');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const loopBtn = document.getElementById('loopBtn');

    let currentPlaylist = [];
    let currentTrackIndex = 0;
    let isLooping = false;

    // Función para cargar y reproducir una canción
    function playTrack(audioUrl, title, artist) {
        player.src = audioUrl;
        titleElement.textContent = title;
        artistElement.textContent = ' - ' + artist;
        player.currentTime = 0;
        player.play();
        updatePlayPauseIcon();
    }

    // Función para cargar una playlist completa
    function loadPlaylist(playlist, startIndex = 0) {
        currentPlaylist = playlist;
        currentTrackIndex = startIndex;
        if (currentPlaylist.length > 0 && currentTrackIndex < currentPlaylist.length) {
            const track = currentPlaylist[startIndex];
            playTrack(track.audio, track.name, track.artist_name);
        }
    }

    // Función para reproducir la canción actual
    function playCurrentTrack() {
        if (currentPlaylist.length === 0) return;

        const track = currentPlaylist[currentTrackIndex];
        playTrack(track.audio, track.name, track.artist_name);
    }

    // Función para ir a la siguiente canción
    function nextTrack() {
        if (currentPlaylist.length === 0) return;

        currentTrackIndex++;
        if (currentTrackIndex >= currentPlaylist.length) {
            if (isLooping) {
                currentTrackIndex = 0;
            } else {
                currentTrackIndex = currentPlaylist.length - 1;
                return;
            }
        }
        playCurrentTrack();
    }

    // Función para ir a la canción anterior
    function prevTrack() {
        if (currentPlaylist.length === 0) return;

        currentTrackIndex--;
        if (currentTrackIndex < 0) {
            if (isLooping) {
                currentTrackIndex = currentPlaylist.length - 1;
            } else {
                currentTrackIndex = 0;
                return;
            }
        }
        playCurrentTrack();
    }

    // Función para actualizar el icono de play/pause
    function updatePlayPauseIcon() {
        const icon = player.paused ? 'fa-play' : 'fa-pause';
        playPauseBtn.innerHTML = `<i class="fas ${icon}"></i>`;
    }

    // Event listeners para los botones
    playPauseBtn.addEventListener('click', function() {
        if (player.paused) {
            if (player.src) {
                player.play();
            } else if (currentPlaylist.length > 0) {
                playCurrentTrack();
            }
        } else {
            player.pause();
        }
        updatePlayPauseIcon();
    });

    // Cuando termina una canción, pasar a la siguiente
    player.addEventListener('ended', nextTrack);
    nextBtn.addEventListener('click', nextTrack);
    prevBtn.addEventListener('click', prevTrack);

    loopBtn.addEventListener('click', function() {
        isLooping = !isLooping;
        loopBtn.classList.toggle('active', isLooping);
    });

    // Actualizar el icono cuando cambia el estado de reproducción
    player.addEventListener('play', updatePlayPauseIcon);
    player.addEventListener('pause', updatePlayPauseIcon);

    // Función global para ser llamada desde otras partes
    window.playPlaylist = function(playlist, startIndex = 0) {
        loadPlaylist(playlist, startIndex);
    };

    // Función global para reproducir una sola canción
    window.playSingleTrack = function(audioUrl, title, artist) {
        loadPlaylist([{
            audio: audioUrl,
            name: title,
            artist_name: artist
        }]);
    };

    // Escuchar clicks en los botones de reproducción
    document.body.addEventListener('click', function(event) {
        const button = event.target.closest('.play-track');
        if (!button) return;
        event.preventDefault();

        // Si el botón tiene data-playlist, cargamos la playlist completa
        const playlistData = button.getAttribute('data-playlist');
        if (playlistData) {
            try {
                const playlist = JSON.parse(playlistData);
                loadPlaylist(playlist);
            } catch (e) {
                console.error('Error parsing playlist data', e);
            }
        } else {
            // Reproducir solo esta canción (creamos una playlist de un solo elemento)
            const track = {
                audio: button.getAttribute('data-audio'),
                name: button.getAttribute('data-title'),
                artist_name: button.getAttribute('data-artist')
            };
            loadPlaylist([track]);
        }
    });

});