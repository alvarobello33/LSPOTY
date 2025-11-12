<?= $this->extend('base') ?>

<?= $this->section('title') ?>
    HomePage – LSpoty
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Flash Message pels errors -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="container mt-4">
        <div class="alert alert-warning">
            <?= session()->getFlashdata('error') ?>
        </div>
    </div>
<?php endif; ?>

    <header class="masthead bg-primary text-white text-center">

        <!-- Mostrem el Welcome de la LandPage -->
        <h3 class="masthead-heading mb-0"> <?= lang('app.welcomeTitle2', [$username]) ?></h3>

            <!-- Secció de cerca -->
            <section id="search" class="py-5 bg-primary">
                <div class="container">
                    <h2 class="text-white mb-4 text-center"><?= lang('app.searchHeader') ?></h2>
                    <form action="<?= route_to('home-view') ?>" method="get" class="row g-2 justify-content-center">

                        <!-- Fem un escape (esc) al 'value' per evitar XSS a la barra de cerca // Si no hi ha valor deixem el camp en blanc -->
                        <div class="col-md-6">
                            <input
                                    type="text"
                                    name="searchText"
                                    value="<?= esc($searchText ?? '') ?>"
                                    class="form-control"
                                    placeholder="<?= lang('app.searchPlaceholder') ?>"
                                    required
                            >
                        </div>

                        <!-- Categories Barra Cerca -->
                        <div class="col-md-3">
                            <select name="type" class="form-select">
                                <option value="tracks"   <?= ($type==='tracks')   ? 'selected' : '' ?>><?= lang('app.searchTypeTracks') ?></option>
                                <option value="albums"   <?= ($type==='albums')   ? 'selected' : '' ?>><?= lang('app.searchTypeAlbums') ?></option>
                                <option value="artists"  <?= ($type==='artists')  ? 'selected' : '' ?>><?= lang('app.searchTypeArtists') ?></option>
                                <option value="playlists"<?= ($type==='playlists')? 'selected' : '' ?>><?= lang('app.searchTypePlaylists') ?></option>
                            </select>
                        </div>

                        <!-- Botó per Buscar -->
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-secondary w-100">
                                <?= lang('app.searchButton') ?>
                            </button>
                        </div>
                    </form>
                </div>
            </section>

        <div class="divider-custom divider-light">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-music fa-2x"></i></div>
            <div class="divider-custom-line"></div>
        </div>

    </header>


    <!-- Secció Cançons Populars -->
    <?php if (! empty($popularTracks)): ?>
        <section class="py-4 bg-primary">
            <div class="container">

                <!-- Titol de la secció -->
                <h1 class="mb-3 text-white">
                    <?= lang('app.popularTracksHeader') ?>
                </h1>
                <br>

                <!--
                Generem el grid
                row = agrupa columnes en una fila horitzontal
                gy-4 = espaiat vertical entre les files (eix y)
                -->
                <div class="row gy-4">
                    <!-- Recorrem totes les cançons populars -->
                    <?php foreach ($popularTracks as $track): ?>

                        <!-- Dividim la secció
                        col-6 pantalles petites 6/12
                        col-md-4 pantalles mitjanes 4/12
                        col-lg-l3 pantalles grans 3/12
                        -->
                        <div class="col-6 col-md-4 col-lg-3">

                                <!-- Creem les tarjetes on apareixeran les cançons -->
                                <div class="card h-100">
                                    <?php if (! empty($track->cover)): ?>
                                        <img src="<?= ($track->cover) ?>" class="card-img-top" alt="<?= ($track->name) ?>">
                                    <?php endif; ?>

                                    <!-- Info de la canço -->
                                    <div class="card-body d-flex flex-column">
                                        <!-- Nom de la cançó -->
                                        <h5 class="card-title">
                                            <a href="<?= route_to('album-details-view', $track->album_id) ?>">
                                            <?= ($track->name) ?></h5>
                                        <p class="card-text">
                                            <!-- Enllaç a la vista de detalls de l'artista -->
                                            <a href="<?= route_to('artist-details-view', $track->artist_id) ?>">
                                                <?= (($track->artist_name) ?? '') ?>
                                            </a>
                                        </p>
                                        <!-- Boto Play pel player global -->
                                        <div class="mt-auto text-center">
                                            <button
                                                    class="btn btn-link play-track"
                                                    data-audio  = "<?= ($track->player_url) ?>"
                                                    data-title  = "<?= ($track->name) ?>"
                                                    data-artist = "<?= ($track->artist_name) ?>">
                                                <i class="fas fa-play fa-2x"></i>
                                            </button>

                                            <!-- Botón con menú desplegable -->
                                            <div class="dropdown">
                                                <button class="btn btn-link dropdown-toggle add-to-playlist"
                                                        type="button"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false"
                                                        data-track-id="<?= ($track->id) ?>">
                                                    <i class="fas fa-plus fa-2x"></i>
                                                </button>
                                                <ul class="dropdown-menu playlist-dropdown">
                                                    <!-- Las playlists se cargarán aquí dinámicamente -->
                                                    <li><a class="dropdown-item disabled" href="#"><?= lang('app.loadingPlaylist')?></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Secció de Resultats de Cerca -->
    <?php if (! empty($results)): ?>
        <section id="search-results" class="py-5 bg-primary">
            <div class="container">

                <!-- Titol de la secció -->
                <h1 class="mb-3 text-white">
                    <?= lang('app.searchResults') ?>
                </h1>
                <br>

                <!--
                Generem el grid
                row = agrupa columnes en una fila horitzontal
                gy-4 = espaiat vertical entre les files (eix y)
                -->
                <div class="row gy-4">

                    <!-- Recorrem cada item del resultat de cerca -->
                    <?php foreach ($results as $item): ?>

                        <!-- Dividim la secció per mantenir la mateixa estetica de la seccio anterior -->
                        <div class="col-sm-6 col-md-4 col-lg-3">

                            <!-- Tarjeta amb el resultat -->
                            <div class="card h-100">

                                <?php
                                    //Determinem si la imatge pertany a canço, o altres (album, artista, etc)
                                    if($type === 'tracks'){
                                        //Si és una canço, ho fem amb objecte Track
                                        $cover = $item->cover;
                                        $alt = $item->name;
                                    } else{
                                        //Si no es una canço
                                        $cover = $item['image'] ?? '';
                                        $alt = $item['name'] ?? '';
                                    }
                                ?>

                                <!-- Nomes mostrem la imatge si n'hi ha -->
                                <?php if (! empty($cover)): ?>
                                    <img src="<?= ($cover) ?>" class="card-img-top" alt="<?= $alt ?>">
                                <?php endif; ?>

                                <!-- INFO de la tarjeta amb el resultat -->
                                <div class="card-body d-flex flex-column">

                                    <!-- Cançons -->
                                    <?php if ($type === 'tracks'): ?>
                                    <div>
                                        <h5 class="card-title">

                                            <!-- Nom Canço amb enllaç a la vista de l'album de la canço -->
                                            <a href="<?= route_to('album-details-view',  $item->album_id) ?>">
                                                <?= ($item->name) ?>
                                            </a>
                                        </h5>

                                        <!-- Nom de l'artista amb enllaç als seus detalls -->
                                        <p class="card-text">
                                            <a href="<?= route_to('artist-details-view', $item->artist_id) ?>">
                                                <?= (($item->artist_name) ?? '') ?>
                                            </a>
                                        </p>
                                    </div>

                                        <!-- Boto Play pel player global -->
                                        <div class="mt-auto text-center">
                                            <button
                                                    class="btn btn-link play-track"
                                                    data-audio  = "<?= ($item->player_url) ?>"
                                                    data-title  = "<?= ($item->name) ?>"
                                                    data-artist = "<?= ($item->artist_name) ?>">
                                                <i class="fas fa-play fa-2x"></i>
                                            </button>

                                            <!-- Botón con menú desplegable -->
                                            <div class="dropdown">
                                                <button class="btn btn-link dropdown-toggle add-to-playlist"
                                                        type="button"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false"
                                                        data-track-id="<?= ($item->id) ?>">
                                                    <i class="fas fa-plus fa-2x"></i>
                                                </button>
                                                <ul class="dropdown-menu playlist-dropdown">
                                                    <!-- Las playlists se cargarán aquí dinámicamente -->
                                                    <li><a class="dropdown-item disabled" href="#"><?= lang('app.playlistsLoading')?></a></li>
                                                </ul>
                                            </div>
                                        </div>

                                    <!-- Albums -->
                                    <?php elseif ($type === 'albums'): ?>
                                        <h5 class="card-title">
                                            <!-- Enllaç als detalls de l'album -->
                                            <a href="<?= route_to('album-details-view', $item['id']) ?>">
                                                <?= $item['name'] ?>
                                            </a>
                                        </h5>

                                    <!-- Artistes -->
                                    <?php elseif ($type === 'artists'): ?>
                                        <h5 class="card-title">
                                            <!-- Enllaç als detalls de l'artista -->
                                            <a href="<?= route_to('artist-details-view', $item['id']) ?>">
                                                <?= $item['name'] ?>
                                            </a>
                                        </h5>

                                    <!-- Playlists -->
                                    <?php else:?>
                                        <h5 class="card-title">
                                            <!-- Enllaç als detalls de la playlist -->
                                            <a href="<?= route_to('playlist-details-view', $item['id']) ?>">
                                                <?= $item['name'] ?>
                                            </a>
                                        </h5>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>


<!-- Script per desplaçar la pantalla quan es faci una cerca -->
<?php if (! empty($searchText)): ?>
    <script src="<?= base_url('assets/js/windowScroll.js') ?>"></script>
<?php endif; ?>

<!-- Scripts utilizados por homePage.js -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Pasamos las traducciones desde PHP a JavaScript (y rutra my-playlists)
    window.translations  = {
        noPlaylists: '<?= lang("app.js.noPlaylists") ?>',
        errorLoadingPlaylists: '<?= lang("app.js.errorLoadingPlaylists") ?>',
        trackAdded: '<?= lang("app.js.trackAdded") ?>',
        unknownError: '<?= lang("app.js.unknownError") ?>',
        addTrackError: '<?= lang("app.js.addTrackError") ?>',

        routeMyPlaylists: '<?= route_to("my-playlists") ?>'
    };
</script>

<!-- Script para reproducir tracks, y añadir tracks a playlist -->
<script src="<?= base_url('assets/js/homePage.js.php') ?>"></script>

<?= $this->endSection() ?>


