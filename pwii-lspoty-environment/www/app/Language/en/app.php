<?php

//Idioma Anglès per a les vistes

return [

    //Footer
    'finalProject'      => 'Final Project',
    'subject'           => 'Web Project II',
    'university'        => 'La Salle, Ramon Llull University',

    //Landing Page
    'welcomeTitle'      => 'Welcome to LSpoty!',
    'welcomeTitle2'     => 'Welcome back,  {0} !',
    'welcomeMessage'    => 'Please consider logging in or registering to get the best experience.',
    'accessMessage'     => 'Access',
    'signIn'            => 'Sign In',
    'signUp'            => 'Sign Up',

    //Landing Page Caracteristiques
    'feature1Title' => 'Discover Music',
    'feature1Desc'  => 'Explore millions of tracks from artists around the world.',
    'feature2Title' => 'Listen Anywhere',
    'feature2Desc'  => 'Enjoy your favorite songs online from any device.',
    'feature3Title' => 'Create Your Own Playlists',
    'feature3Desc'  => 'Build the best playlists quickly and easily.',

    //Errors Validació Registre
    'errEmailRequired'    => 'The email address is required.',
    'errEmailDomain'     => 'Only emails from @students.salle.url.edu, @ext.salle.url.edu or @salle.url.edu are accepted.',
    'errEmailValid'      => 'The email address is not valid.',
    'errEmailUnique'     => 'The email address is already registered.',
    'errPassRequired'   => 'The password is required.',
    'errPassLength'       => 'The password must contain at least 8 characters.',
    'errPassStrength'     => 'The password must contain both upper and lower case letters and numbers.',
    'errPassMatch'        => 'Passwords do not match.',
    'errUsernameType'   => 'The username is not valid.',

    //Errors Validació Login
    'errEmailNotExist'   => 'User with this email address does not exist.',
    'errPassIncorrect'  => 'Your email and/or password are incorrect.',

    //SignUp Page
    'signUpHeader'        => 'Create Your Account',
    'usernameLabel'       => 'Username (optional)',
    'profilePictureLabel' => 'Profile Picture (optional)',
    'emailLabel'          => 'Email Address *',
    'passwordLabel'       => 'Password *',
    'repeatPasswordLabel' => 'Repeat Password *',

    //SignIn Page
    'signInTitle'         => 'Sign In – LSpoty',
    'signInHeader'        => 'Sign In to Your Account',

    //HomePage
    'navMyPlaylists'      => 'My Playlists',
    'navProfile'          => 'Profile',
    'navLogout'           => 'Log Out',
    'searchHeader'        => 'Search Music',
    'searchPlaceholder'   => 'What do you want to find?',
    'searchTypeTracks'    => 'Tracks',
    'searchTypeAlbums'    => 'Albums',
    'searchTypeArtists'   => 'Artists',
    'searchTypePlaylists' => 'Playlists',
    'searchButton'        => 'Search',
    'searchResults'       => 'Search Results:',
    'menuInfo'            => 'Menu:',
    'searchError'         => 'Search Error:',
    'popularTracksHeader' => 'Popular Tracks Of The Week:',
    'loadingPlaylist'       => 'Loading Playlist...',

    //Album Details
    'releaseAlbumDate'   => 'Release Album Date:',
    'artistName'        => 'Artist:',
    'songsList'         => 'Songs:',
    'totalDuration'     => 'Total Duration:',

    //Artist Details
    'joinDate'      => 'Join Date:',
    'artistAlbums'  => 'Albums:',

    //Playlist Details
    'songsPlaylist' => 'Songs:',

    //Player Bar
    'playerBarSong' => 'No song selected',

    // Profile
    'profileUpdateSuccess' => 'Profile updated successfully',
    'profileUpdateError' => 'Error updating profile',
    'errAgeNumeric' => 'Age must be a number',
    'errAgeMin' => 'Minimum allowed age is 1',
    'errAgeMax' => 'Maximum allowed age is 120',

    //Flash Messages
    'fmRegisterSuccess' => 'User registered successfully! Now you can log in.',

    //Error Guzzle
    'errorGuzzle' => 'Error trying to connect to Jamendo API: ',

    //Errors Status Code
    'errorStatusCode400'    => 'Bad Request (400): the request parameters are invalid.',
    'errorStatusCode401'    => 'Unauthorized (401): invalid credentials or expired token.',
    'errorStatusCode403'    => 'Forbidden (403): you do not have permission to access this resource.',
    'errorStatusCode404'    => 'Not Found (404): the requested resource was not found.',
    'errorStatusCode429'    => 'Too Many Requests (429): you have exceeded the request limit.',
    'errorStatusCode500'    => 'Internal Server Error (500): please try again later.',
    'errorStatusCode502'    => 'Bad Gateway (502): upstream service error.',
    'errorStatusCode503'    => 'Service Unavailable (503): the service is temporarily unavailable.',
    'errorStatusCode504'    => 'Gateway Timeout (504): the service did not respond in time.',
    'errorStatusCodeDefault'    => 'Unexpected HTTP error ({0}).',
    'errorNoSpecified'  => 'Please go back home or try again later.',

    //Playlist
    //Create
    'playlistTitle' => 'Create Playlist - LSPoty',
    'playlistCreate'    => 'Create New Playlist',
    'playlistName'      => 'Playlist Name',
    'playlistCover' => 'Cover Image (Optional)',
    'playlistCancel'    => 'Cancel',
    'playlistCreateConfirm' => 'Create Playlist',
    //Index
    'playlistTitleMyPlaylists' => 'My Playlists - LSPoty',
    'playlistMyPlaylist'  => 'My Playlists',
    'playlistCreateNew' => 'Create New Playlist',
    'playlistTracks'    => 'Tracks',
    'playlistPlay'  => 'Play',
    'playlistEdit'  => 'Edit',
    'playlistDelete'  => 'Delete',
    'playlistEdit2'  => 'Edit Playlist',
    'playlistName2'  => 'Name',
    'playlistSaveChanges'  => 'Save Changes',
    'playlistDetails'   => 'Playlist Details',
    'playlistPlay2'  => 'Play Playlist',
    'playlistTitleTable' => 'Title',
    'playlistArtistTable' => 'Artist',
    'playlistAlbumTable' => 'Album',
    'playlistDurationTable' => 'Duration',
    'playlistActionsTable' => 'Actions',
    'playlistClose' => 'Close',
        //js
    'delete_confirm' => 'Are you sure you want to delete this playlist?',
    'delete_error' => 'Error deleting playlist',
    'update_error' => 'Error updating playlist',
    'load_error' => 'Error loading playlist',
    'details_error' => 'Error loading playlist details',
    'no_tracks' => 'No tracks in this playlist',
    'remove_track_confirm' => 'Are you sure you want to remove this track from the playlist?',
    'remove_track_error' => 'Error removing track',
    //Home
    'playlistsLoading' => 'Loading Playlists...',
    'noPlaylists' => 'You don\'t have any playlists yet.',
    'errorLoadingPlaylists' => 'Error loading playlists',
    'trackAdded' => 'Track added to playlist!',
    'unknownError' => 'Unknown error occurred',
    'addTrackError' => 'Error adding track to playlist',

    //Perfil
    //Index
    'profileTitle' => 'User Profile - LSPoty',
    'profileMy' => 'My Profile',
    'profilePicture'    => 'Profile Picture',
    'profileEdit'     => 'Edit Profile',
    'profileMail'   => 'Email',
    'profileAge'    => 'Age',
    'profileAgeNum' => 'years old',
    'profileMemberSince' => 'Member since',
    //Edit
    'profileEditTitle' => 'Edit Profile - LSPoty',
    'profileChangePicture'  => 'Change Picture',
    'profileChangePass'  => 'Change Password',
    'profileChange2'    => 'Modify',
    'profileNewPassword'  => 'New Password',
    'profileUsername'  => 'Username',
    'profilePass8Change'  => 'Minimum 8 characters',
    'profileRepeatPass'  => 'Repeat New Password',
    'profileAgeRange'   => 'From 1 to 120 years old',
    'profileCancelEdit' => 'Cancel',
    'profileSaveChanges'  => 'Save Changes',















];
