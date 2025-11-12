<?= $this->extend('base') ?>

<!-- Dependència pels temps -->
<?php use Carbon\Carbon; ?>
<?php use Carbon\CarbonInterval; ?>

<?= $this->section('title') ?>
    <?= esc($playlist['name']) ?>
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
                <div class="col-md-4 text-center">
                    <!-- Cover Playlist -->
                    <img src="<?= $playlist['cover'] ?>" alt="<?= $playlist['name'] ?>">
                </div>

                <!-- Nom Playlist -->
                <div class="col-md-8">
                    <h1 class="display-5"><?= $playlist['name'] ?></h1>
                    <br>
                    <!-- Duració total de la playlist -->
                    <p class="fs-4">
                        <strong><?= lang('app.totalDuration') ?></strong>
                        <!-- Retornem el temps total amb Carbon Interval-->
                        <?php
                        $totalSeconds = $playlist['total_duration'];
                        $secondsResult = CarbonInterval::seconds($totalSeconds);
                        ?>
                        <?= $secondsResult->cascade()->forHumans(['short' => true]) ?>
                    </p>
                </div>
            </div>

            <br>
            <!-- Titol Cançons -->
            <h2 class="mb-3"><?= lang('app.songsList') ?></h2>

            <!-- Llista cançons -->
            <ul class="list-group list-group-flush">
                <?php foreach ($playlist['tracks'] as $track): ?>
                    <li class="list-group-item bg-primary text-white d-flex justify-content-between align-items-center">

                        <!-- Nom de la cançó i enllaç al seu àlbum -->
                        <a href="<?= route_to('album-details-view', $track['album_id']) ?>" class="text-white text-decoration-none fs-4">
                            <?= $track['position'] ?>. <?= $track['name'] ?>
                        </a>

                        <!-- Botó Play enllaç al reproductor global-->
                        <button
                                class="btn btn-light btn-sm play-track"
                                data-audio  = "<?= $track['audio'] ?>"
                                data-title  = "<?= $track['name'] ?>"
                                data-artist = "<?= ($track['artist_name'] ?? '') ?>">

                            <!-- Icona play -->
                            <i class="fas fa-play"></i>
                        </button>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>
</header>

<?= $this->endSection() ?>
