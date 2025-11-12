<?= $this->extend('base') ?>

<?= $this->section('title') ?>
    <?=lang('app.playlistTitleMyPlaylists')?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <section class="page-section text-center" style="background: #20c997; color: white;">
        <div class="container">
            <h1 class="text-uppercase font-weight-bold"><?=lang('app.playlistMyPlaylist')?>
            </h1>
            <div class="divider-custom">
                <div class="divider-custom-line" style="background: white;"></div>
                <div class="divider-custom-icon" style="color: white;"><i class="fas fa-music"></i></div>
                <div class="divider-custom-line" style="background: white;"></div>
            </div>

            <!-- Botón para crear nueva playlist -->
            <div class="text-end mb-4">
                <a href="<?= site_url('create-playlist') ?>" class="btn btn-dark rounded-pill px-4">
                    <i class="fas fa-plus me-2"></i><?=lang('app.playlistCreateNew')?>
                </a>
            </div>

            <div class="row" id="playlists-container">
                <?php foreach ($playlists as $playlist): ?>
                    <div class="col-md-6 col-lg-4 mb-4 playlist-card" data-id="<?= $playlist['id'] ?>">
                        <!-- Card de cada playlist -->
                        <div class="card h-100 shadow" style="border-radius: 15px; border: none; cursor: pointer;" onclick="showPlaylistDetails(<?= $playlist['id'] ?>)">
                            <!-- Imagen de portada -->
                            <img src="<?= $playlist['cover'] ? base_url($playlist['cover']) : base_url('assets/img/default-playlist.jpg') ?>"
                                 class="card-img-top"
                                 style="height: 200px; object-fit: cover; border-top-left-radius: 15px; border-top-right-radius: 15px;"
                                 alt="<?= esc($playlist['name']) ?>">

                            <!-- Contenido de la tarjeta -->
                            <div class="card-body">
                                <h5 class="card-title"><?= esc($playlist['name']) ?></h5>
                                <p class="text-muted small">
                                    <?= $playlist['track_count'] ?>  <?=lang('app.playlistTracks')?>
                                </p>
                            </div>

                            <!-- Pie de tarjeta con acciones -->
                            <div class="card-footer bg-transparent border-top-0">
                                <button class="btn btn-outline-dark rounded-pill btn-sm"
                                        type="button"
                                        onclick="playPlaylistFromTrack(<?= $playlist['id'] ?>, 0)">
                                    <i class="fas fa-play me-1"></i> <?=lang('app.playlistPlay')?>
                                </button>

                                <!-- Menú desplegable de opciones -->
                                <div class="dropdown float-end">
                                    <button class="btn btn-outline-secondary rounded-pill btn-sm dropdown-toggle"
                                            type="button"
                                            data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item edit-playlist" data-id="<?= $playlist['id'] ?>"><?=lang('app.playlistEdit')?></a></li>
                                        <li><a class="dropdown-item delete-playlist" data-id="<?= $playlist['id'] ?>"><?=lang('app.playlistDelete')?></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Edit Playlist Modal -->
    <div class="modal fade" id="editPlaylistModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Cabecera -->
                <div class="modal-header">
                    <h5 class="modal-title"><?=lang('app.playlistEdit2')?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Formulario -->
                <div class="modal-body">
                    <form id="editPlaylistForm">
                        <input type="hidden" id="edit_playlist_id" name="id">
                        <div class="mb-3">
                            <label for="edit_playlist_name" class="form-label"><?=lang('app.playlistName2')?></label>
                            <input type="text" class="form-control" id="edit_playlist_name" name="name" required>
                        </div>
                    </form>
                </div>

                <!-- Botones de acción (en footer) -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=lang('app.playlistCancel')?></button>
                    <button type="button" class="btn btn-primary" id="save-playlist-changes"><?=lang('app.playlistSaveChanges')?></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Playlist Details Modal -->
    <div class="modal fade" id="playlistDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="playlistDetailsTitle"><?=lang('app.playlistDetails')?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="text-center mb-4">
                        <img id="playlistDetailsCover" src="" class="img-fluid rounded" style="max-height: 200px;" alt="Playlist Cover">
                        <h3 id="playlistDetailsName" class="mt-3"></h3>
                        <button id="playPlaylistBtn" class="btn btn-success rounded-pill px-4 mt-2">
                            <i class="fas fa-play me-2"></i> <?=lang('app.playlistPlay2')?>
                        </button>
                    </div>

                    <!-- Tabla de tracks -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?=lang('app.playlistTitleTable')?></th>
                                <th><?=lang('app.playlistArtistTable')?></th>
                                <th><?=lang('app.playlistAlbumTable')?></th>
                                <th><?=lang('app.playlistDurationTable')?></th>
                                <th><?=lang('app.playlistActionsTable')?></th>
                            </tr>
                            </thead>
                            <tbody id="playlistTracksList">
                            <!-- Tracks se insertan dinámicamente con JS -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Botón cerrar -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=lang('app.playlistClose')?></button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        window.BASE_URL = '<?= base_url() ?>';
        window.DEFAULT_PLAYLIST_IMG = `<?= base_url('assets/img/default-playlist.png') ?>`;
    </script>

    <script>
        window.translations = {
            delete_confirm: '<?= lang("app.delete_confirm") ?>',
            delete_error: '<?= lang("app.delete_error") ?>',
            update_error: '<?= lang("app.update_error") ?>',
            load_error: '<?= lang("app.load_error") ?>',
            details_error: '<?= lang("app.details_error") ?>',
            no_tracks: '<?= lang("app.no_tracks") ?>',
            remove_track_confirm: '<?= lang("app.remove_track_confirm") ?>',
            remove_track_error: '<?= lang("app.remove_track_error") ?>'
        };
    </script>

    <!-- Script para manejar playlist -->
    <script src="<?= base_url('assets/js/myPlaylists.js.php') ?>"></script>

<?= $this->endSection() ?>