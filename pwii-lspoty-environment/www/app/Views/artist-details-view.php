<?= $this->extend('base') ?>
<!-- Dependència pels temps -->
<?php use Carbon\Carbon; ?>

<?= $this->section('title') ?>
    <?= esc($artist['name']) ?>
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

<header class="masthead bg-primary">
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row align-items-center mb-4">
                <!-- Imatge Artista -->
                <div class="col-md-4 text-center">
                    <img src="<?= $artist['image'] ?>" alt="<?= $artist['name'] ?>" class="img-fluid rounded shadow">
                </div>

                <!-- Nom Artista -->
                <div class="col-md-8">
                    <h1 class="display-5"><?= $artist['name'] ?></h1>
                    <br>
                    <!-- Data unío Artista -->
                    <p class="fs-4"><strong><?= lang('app.joinDate') ?></strong>
                        <?= Carbon::parse($artist['join_date'])->toDateString()?>
                    </p>
                </div>
            </div>
            <br>
            <br>

            <!-- Titol Albums -->
            <h2 class="mb-3"><?= lang('app.artistAlbums') ?></h2>
            <br>

            <!-- Llista Albums -->
            <div class="row gx-3 gy-4">
                <?php foreach ($artist['albums'] as $album): ?>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="card bg-primary text-white h-100 border-0">
                            <!-- Enllaç a l'album -->
                            <a href="<?= route_to('album-details-view', $album['id']) ?>"
                               class="text-white text-decoration-none">

                                <!-- Imatge de l'album -->
                                <img src="<?= $album['image'] ?>"
                                     class="card-img-top rounded"
                                     alt="<?= $album['name'] ?>">

                                <!-- Nom de l'album i Data Publicacaió-->
                                <div class="card-body p-2">
                                    <h4 class="card-title mb-0"><?= $album['name'] ?></h4>
                                    <h5 class="text-dark"><?= Carbon::parse($album['release_date'])->toDateString()?></h5>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</header>

<?= $this->endSection() ?>
