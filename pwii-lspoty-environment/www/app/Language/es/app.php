<?php

//Idioma Castellà per a les vistes

return [

    //Footer
    'finalProject'      => 'Proyecto Final',
    'subject'           => 'Proyectos Web II',
    'university'        => 'La Salle, Universidad Ramon Llull',

    //Landing Page
    'welcomeTitle'     => 'Bienvenido a LSpoty!',
    'welcomeTitle2'     => 'Bienvenido,  {0} !',
    'welcomeMessage'   => 'Por favor, considere Iniciar Sesión o Registrarse para obtener una mejor experiencia.',
    'accessMessage'     => 'Acceder',
    'signIn'           => 'Iniciar Sesión',
    'signUp'           => 'Registro',

    //Landing Page Caracteristiques
    'feature1Title'   => 'Descubre música',
    'feature1Desc'    => 'Explora millones de canciones de artistas de todo el mundo.',
    'feature2Title'   => 'Escucha en cualquier sitio.',
    'feature2Desc'    => 'Disfruta de tus canciones favoritas en línea des de cualquier dispositivo.',
    'feature3Title'   => 'Crea tus propias Playlists',
    'feature3Desc'    => 'Construye las mejores listas de reproducción de forma rápida y sencilla.',

    //Errors validació registre
    'errEmailRequired'    => 'La dirección de correo electrónica es obligatoria.',
    'errEmailDomain'   => 'Solo se aceptan correos de los dominios @students.salle.url.edu, @ext.salle.url.edu o @salle.url.edu.',
    'errEmailValid'    => 'La dirección de correo electrónico no es válida.',
    'errEmailUnique'   => 'La dirección de correo electrónico ya está registrada.',
    'errPassRequired'   => 'La contraseña es obligatoria.',
    'errPassLength'     => 'La contraseña debe tener al menos 8 caracteres.',
    'errPassStrength'   => 'La contraseña debe contener mayúsculas, minúsculas y números.',
    'errPassMatch'      => 'Las contraseñas no coinciden.',
    'errUsernameType'   => 'El nombre de usuario no es válido.',

    //Errors Validació Login
    'errEmailNotExist'      => 'No existe ningún usuario con este correo electrónico.',
    'errPassIncorrect'      => 'Correo electrónico y/o contraseña incorrectos.',

    //SignUp Page
    'signUpHeader'        => 'Crea Tu Cuenta',
    'usernameLabel'       => 'Nombre de Usuario (opcional)',
    'profilePictureLabel' => 'Imagen de Perfil (opcional)',
    'emailLabel'          => 'Dirección de correo electrónico *',
    'passwordLabel'       => 'Contraseña *',
    'repeatPasswordLabel' => 'Repetir Contraseña *',

    //SignIn Page
    'signInHeader'        => 'Inicia Sesión en tu Cuenta',

    //HomePage
    'navMyPlaylists'      => 'Mis Listas de Reproducción',
    'navProfile'          => 'Perfil',
    'navLogout'           => 'Desconectar',
    'searchHeader'        => 'Buscar Música',
    'searchPlaceholder'   => '¿Qué quieres buscar?',
    'searchTypeTracks'    => 'Canciones',
    'searchTypeAlbums'    => 'Álbumes',
    'searchTypeArtists'   => 'Artistas',
    'searchTypePlaylists' => 'Listas de Reproducción',
    'searchButton'        => 'Buscar',
    'searchResults'       => 'Resultados de búsqueda:',
    'menuInfo'            => 'Menú:',
    'searchError'         => 'Error de búsqueda:',
    'popularTracksHeader' => 'Canciones Populares De Esta Semana:',
    'loadingPlaylist'       => 'Cargando Playlist...',


    //Album Details
    'releaseAlbumDate'   => 'Fecha de lanzamiento:',
    'artistName'        => 'Artista:',
    'songsList'         => 'Canciones:',
    'totalDuration'     => 'Duración Total:',

    //Artist Details
    'joinDate'      => 'Fecha de unión:',
    'artistAlbums'  => 'Álbumes:',

    //Playlist Details
    'songsPlaylist' => 'Canciones:',

    //Player Bar
    'playerBarSong' => 'Ninguna canción seleccionada',


    // Profile
    'profileUpdateSuccess' => 'Perfil actualizado correctamente',
    'profileUpdateError' => 'Error al actualizar el perfil',

    'errAgeNumeric' => 'La edad debe ser un número',
    'errAgeMin' => 'La edad mínima permitida es 1 años',
    'errAgeMax' => 'La edad máxima permitida es 120 años',

    //Flash Messages
    'fmRegisterSuccess' => 'Usuario registrado correctamente. Ahora puedes iniciar sesión.',

    //Error Guzzle
    'errorGuzzle' => 'Error intentando conectar con la API de Jamendo: ',

    //Error Status Code
    'errorStatusCode400'    => 'Solicitud incorrecta (400): los parámetros de la petición son inválidos.',
    'errorStatusCode401'    => 'No autorizado (401): credenciales inválidas o token caducado.',
    'errorStatusCode403'    => 'Prohibido (403): no tienes permiso para acceder a este recurso.',
    'errorStatusCode404'    => 'No encontrado (404): el recurso solicitado no existe.',
    'errorStatusCode429'    => 'Demasiadas peticiones (429): has superado el límite de solicitudes.',
    'errorStatusCode500'    => 'Error interno del servidor (500): por favor, inténtalo más tarde.',
    'errorStatusCode502'    => 'Puerta de enlace incorrecta (502): error en el servicio en cascada.',
    'errorStatusCode503'    => 'Servicio no disponible (503): el servicio está temporalmente fuera de servicio.',
    'errorStatusCode504'    => 'Tiempo de espera agotado (504): el servicio no respondió a tiempo.',
    'errorStatusCodeDefault'     => 'Error HTTP inesperado ({0}).',
    'errorNoSpecified'  => 'Por favor, vuelve al inicio o inténtalo de nuevo más tarde.',

    //Playlist
    //Create
    'playlistTitle'             => 'Crear Playlist - LSPoty',
    'playlistCreate'            => 'Crear nueva Playlist',
    'playlistName'              => 'Nombre de la Playlist',
    'playlistCover'             => 'Imagen de portada (opcional)',
    'playlistCancel'            => 'Cancelar',
    'playlistCreateConfirm'     => 'Crear Playlist',
    // Index
    'playlistTitleMyPlaylists'  => 'Mis Playlists - LSPoty',
    'playlistMyPlaylist'        => 'Mis Playlists',
    'playlistCreateNew'         => 'Crear nueva Playlist',
    'playlistTracks'            => 'Canciones',
    'playlistPlay'              => 'Reproducir',
    'playlistEdit'              => 'Editar',
    'playlistDelete'            => 'Eliminar',
    'playlistEdit2'             => 'Editar Playlist',
    'playlistName2'             => 'Nombre',
    'playlistSaveChanges'       => 'Guardar cambios',
    'playlistDetails'           => 'Detalles de la Playlist',
    'playlistPlay2'             => 'Reproducir Playlist',
    'playlistTitleTable'        => 'Título',
    'playlistArtistTable'       => 'Artista',
    'playlistAlbumTable'        => 'Álbum',
    'playlistDurationTable'     => 'Duración',
    'playlistActionsTable'      => 'Acciones',
    'playlistClose'             => 'Cerrar',
        //js
    'delete_confirm' => '¿Estás seguro de que quieres eliminar esta lista de reproducción?',
    'delete_error' => 'Error al eliminar la lista',
    'update_error' => 'Error al actualizar la lista',
    'load_error' => 'Error al cargar la lista',
    'details_error' => 'Error al cargar los detalles',
    'no_tracks' => 'No hay canciones en esta lista',
    'remove_track_confirm' => '¿Estás seguro de que quieres quitar esta canción de la lista?',
    'remove_track_error' => 'Error al eliminar la canción',

    //Home
    'playlistsLoading' => 'Cargando Playlists...',
    'noPlaylists' => 'No tienes ninguna playlist aún.',
    'errorLoadingPlaylists' => 'Error cargando las playlists',
    'trackAdded' => 'Canción añadida a la playlist!',
    'unknownError' => 'Error desconocido ocurrido',
    'addTrackError' => 'Error añadiendo canción a la playlist',

    //Perfil
    //Index
    'profileTitle'         => 'Perfil de usuario - LSPoty',
    'profileMy'            => 'Mi perfil',
    'profilePicture'       => 'Foto de perfil',
    'profileEdit'          => 'Editar perfil',
    'profileMail'          => 'Correo electrónico',
    'profileAge'           => 'Edad',
    'profileAgeNum'        => 'años',
    'profileMemberSince'   => 'Miembro desde',
    // Edit
    'profileEditTitle'     => 'Editar perfil - LSPoty',
    'profileChangePicture' => 'Cambiar foto',
    'profileChangePass'    => 'Cambiar contraseña',
    'profileChange2'       => 'Modificar',
    'profileNewPassword'   => 'Nueva contraseña',
    'profileUsername'      => 'Nombre de usuario',
    'profilePass8Change'   => 'Mínimo 8 caracteres',
    'profileRepeatPass'    => 'Repite la nueva contraseña',
    'profileAgeRange'      => 'De 1 a 120 años',
    'profileCancelEdit'    => 'Cancelar',
    'profileSaveChanges'   => 'Guardar cambios',
];
