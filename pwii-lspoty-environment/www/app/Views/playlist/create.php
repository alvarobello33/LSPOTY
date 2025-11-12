<?= $this->extend('base') ?>

<?= $this->section('title') ?>
    <?=lang('app.playlistTitle')?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <section class="page-section text-center" style="background: #20c997; color: white;">
        <div class="container">
            <h1 class="text-uppercase font-weight-bold"><?=lang('app.playlistCreate')?></h1>
            <div class="divider-custom">
                <div class="divider-custom-line" style="background: white;"></div>
                <div class="divider-custom-icon" style="color: white;"><i class="fas fa-plus-circle"></i></div>
                <div class="divider-custom-line" style="background: white;"></div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <?php if (session('errors')): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <ul class="mb-0">
                                <?php foreach (session('errors') as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= site_url('create-playlist') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold h5"><?=lang('app.playlistName')?></label>
                            <input type="text" class="form-control form-control-lg" id="name" name="name" required>
                        </div>

                        <div class="mb-4">
                            <label for="cover" class="form-label fw-bold h5"><?=lang('app.playlistCover')?></label>
                            <input type="file" class="form-control" id="cover" name="cover" accept="image/*">
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="<?= site_url('my-playlists') ?>" class="btn btn-outline-dark btn-lg rounded-pill px-4 shadow-sm me-md-2">
                                <i class="fas fa-times me-2"></i><?=lang('app.playlistCancel')?>
                            </a>
                            <button type="submit" class="btn btn-dark btn-lg rounded-pill px-4 shadow-sm">
                                <i class="fas fa-save me-2"></i><?=lang('app.playlistCreateConfirm')?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?= $this->endSection() ?>