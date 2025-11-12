<?= $this->extend('base') ?>
<!-- Dependència pels temps -->
<?php use Carbon\Carbon; ?>
<?php use Carbon\CarbonInterval; ?>

<?= $this->section('title') ?>
    <?= esc($album['name']) ?>
<?= $this->endSection() ?>

<!-- Flash Message pels errors -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="container mt-4">
        <div class="alert alert-warning">
            <?= session()->getFlashdata('error') ?>
        </div>
    </div>
<?php endif; ?>

<?= $this->section('content') ?>
<header class="masthead bg-primary">
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row align-items-center mb-4">

                <!-- Cover de l'album -->
                <div class="col-md-4 text-center">
                    <img src="<?= $album['cover'] ?>" alt="<?= $album['name'] ?>" class="img-fluid rounded shadow">
                </div>

                <!-- Nom de lalbum -->
                <div class="col-md-8">
                    <h1 class="display-5"><?= $album['name'] ?></h1>
                    <br>

                    <!-- Nom Artista -->
                    <p class="fs-4">
                        <strong><?= lang('app.artistName') ?></strong>
                        <a href="<?= route_to('artist-details-view', $album['artist']['id']) ?>"
                           class="text-white text-decoration-none">
                            <?= $album['artist']['name'] ?>
                        </a>
                    </p>

                    <!-- Data publicació -->
                    <p class="fs-4">
                        <strong><?= lang('app.releaseAlbumDate') ?></strong>
                        <!-- Format Data "any-mes-dia"-->
                        <?= Carbon::parse($album['release_date'])->toDateString()?>
                    </p>

                    <!-- Duració Total -->
                    <p class="fs-4">
                        <strong><?= lang('app.totalDuration') ?></strong>
                        <!-- Retornem el temps total amb Carbon Interval-->
                        <!-- https://coderflex.com/blog/convert-seconds-to-minutes-hours-using-carbon-laravel-the-easy-way -->
                        <?php
                            $totalSeconds = $album['total_duration'];
                            $secondsResult = CarbonInterval::seconds($totalSeconds);
                        ?>
                        <?= $secondsResult->cascade()->forHumans(['short' => true]) ?>
                    </p>
                </div>
            </div>

            <br>
            <br>
            <!-- Titol Cançons -->
            <h2 class="mb-3"><?= lang('app.songsList') ?></h2>

            <!-- Llistat de Cançons -->
            <ul class="list-group list-group-flush">
                <?php foreach ($album['tracks'] as $track): ?>
                    <li class="list-group-item bg-primary text-white d-flex justify-content-between align-items-center ">

                        <!-- Cançons (Posicio + Nom) i enllaç -->
                        <a href="#"
                           class="play-track text-white fs-4 text-decoration-none"
                           data-audio="<?= $track['audio'] ?>"
                           data-title="<?= $track['name'] ?>"
                           data-artist="<?= $album['artist']['name'] ?>">
                            <?= $track['position'] ?>. <?= $track['name'] ?>
                        </a>

                        <!-- Boto pel reproductor global -->
                        <button class="btn btn-light btn-sm play-track"
                                data-audio="<?= esc($track['audio']) ?>"
                                data-title="<?= esc($track['name']) ?>"
                                data-artist="<?= esc($album['artist']['name']) ?>">

                            <!-- Icona de play -->
                            <i class="fas fa-play"></i>
                        </button>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>
</header>

<?= $this->endSection() ?>
