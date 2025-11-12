<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Projectes Web II - LSpoty" />
    <meta name="author" content="Nil Bagaria Nofre i Alvaro Bello Garrido" />
    <title><?= $this->renderSection('title') ?></title>

    <!-- Favicon-->
    <!-- <link rel="icon" type="image/x-icon" href="/assets/favicon.ico" /> -->

    <!-- Font Awesome icons -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />

    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css') ?>">
</head>

<body id="page-top">
<!-- Menú Navegació -->
<nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
    <div class="container">
        <!-- Títol Barra Navegació -->
        <a class="navbar-brand" href="<?= route_to('home-view') ?>">LSpoty</a>
        <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <!-- Referències barra navegació -->
            <ul class="navbar-nav ms-auto">

                <!-- Si NO hi ha sessió mostrem Sign UP i Sign IN a la barra del menú -->

                <?php if (! session()->has('user')): ?>

                <!-- SIGN IN -->
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded" href="<?= route_to('sign-in-view') ?>">
                            <?= lang('app.signIn') ?></a>
                    </li>
                    <!-- SIGN UP -->
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded" href="<?= route_to('sign-up-view') ?>">
                            <?= lang('app.signUp') ?></a>
                    </li>

                <?php else: ?>
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded" href="<?= route_to('my-playlists') ?>">
                            <?= lang('app.navMyPlaylists') ?>
                        </a>
                    </li>
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded" href="<?= route_to('profile') ?>">
                            <?= lang('app.navProfile') ?>
                        </a>
                    </li>
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded" href="<?= route_to('sign-out-view') ?>">
                            <?= lang('app.navLogout') ?>
                        </a>
                    </li>
                <?php endif ?>


            </ul>
        </div>
    </div>
</nav>

<!-- Contingut del main -->
<?= $this->renderSection('content') ?>

<!-- Footer -->
<footer class="footer text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-5 mb-lg-0">
                <h4 class="text-uppercase mb-4"><?= lang('app.finalProject') ?></h4>
            </div>
            <div class="col-lg-4 mb-5 mb-lg-0">
                <h4 class="text-uppercase mb-4"><?= lang('app.subject') ?></h4>
                <p class="lead mb-0"><?= lang('app.university') ?></p>
            </div>
            <div class="col-lg-4">
                <h4 class="text-uppercase mb-4">Nil Bagaria Nofre <br> Alvaro Bello Garrido</h4>
            </div>
        </div>
    </div>
</footer>

<div class="copyright py-4 text-center text-white">
    <div class="container"><small>Copyright &copy; LSpoty - 2025</small></div>
</div>

<!-- Reproductor -->
<!-- Només el mostrem si hi ha sessió iniciada -->
<?php if (session()->has('user')): ?>
    <?= view('player-bar') ?>
    <!-- Script del reproductor -->
    <script src="<?= base_url('assets/js/playerBar.js') ?>"></script>
<?php endif ?>

</body>
</html>
