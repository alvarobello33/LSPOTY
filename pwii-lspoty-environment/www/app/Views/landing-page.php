<?= $this->extend('base') ?>

<?= $this->section('title') ?>
Landing Page - LSpoty
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Secció Main-->

<header class="masthead bg-primary text-white text-center">
    <div class="container d-flex align-items-center flex-column">
        <i class="fas fa-music fa-10x mb-5"></i>

        <!-- Mostrem el Welcome de la LandPage -->
        <h1 class="masthead-heading text-uppercase mb-0"> <?= lang('app.welcomeTitle') ?></h1>

        <div class="divider-custom divider-light">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>

        <!-- Missatge d'inici -->
        <p class="masthead-subheading font-weight-light mb-0">
            <?= lang('app.welcomeMessage') ?>
        </p>

    </div>
</header>

<!-- Secció de Característiques -->
<section id="features" class="page-section bg-primary text-white">
    <div class="container">

        <div class="row">
            <!-- Lupa -->
            <div class="col text-center">
                <!-- Tamany icona x4 i margin-bottom x5 -->
                <i class="fas fa-search fa-4x mb-5"></i>
                <h4><?= lang('app.feature1Title') ?></h4>
                <p class="text-light fs-5"><?= lang('app.feature1Desc') ?></p>
            </div>

            <!-- Auriculars -->
            <div class="col text-center">
                <i class="fas fa-headphones fa-4x mb-5"></i>
                <h4><?= lang('app.feature2Title') ?></h4>
                <p class="text-light fs-5"><?= lang('app.feature2Desc') ?></p>
            </div>

            <!-- Llista -->
            <div class="col text-center">
                <i class="fas fa-list fa-4x mb-5"></i>
                <h4><?= lang('app.feature3Title') ?></h4>
                <p class="text-light fs-5"><?= lang('app.feature3Desc') ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Secció Accés -->
<section class="page-section bg-primary text-white mb-0" id="about">
    <div class="container">

        <!-- Subtitol d'Acces -->
        <h4 class="page-section-heading text-center text-uppercase text-white">
            <?= lang('app.accessMessage') ?>
        </h4>

        <div class="divider-custom divider-light">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>

        <!-- Botons SignIn - Sign UP  -->
        <div class="text-center mt-4">
            <!-- Usuari NO Logejat mostrem botons Sign In i Sign Up -->
            <a href="<?= route_to('sign-in-view') ?>" class="btn btn-xl btn-footer-color shadow-sm rounded"> <?= lang('app.signIn') ?> <i class="fa-solid fa-right-to-bracket"></i></a>
            <a href="<?= route_to('sign-up-view') ?>" class="btn btn-xl btn-footer-color shadow-sm rounded"> <?= lang('app.signUp') ?> <i class="fa-solid fa-user-plus"></i></a>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
