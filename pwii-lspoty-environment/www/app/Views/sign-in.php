<?= $this->extend('base') ?>

<?= $this->section('title') ?>
Sign In - LSpoty
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="page-section text-center" style="background: #20c997; color: white; padding: 120px 0 80px 0;">
    <div class="container">
        <h1 class="text-uppercase font-weight-bold"><?= lang('app.signIn') ?></h1>
        <div class="divider-custom">
            <div class="divider-custom-line" style="background: white;"></div>
            <div class="divider-custom-icon" style="color: white;"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line" style="background: white;"></div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <!-- Flash Message d'èxit en el registre -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <!-- Error Credencials -->
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= esc($error) ?>
                    </div>
                <?php endif; ?>

                <!-- Missatge flash d'error si ve d'un filtre -->
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= route_to('sign-in-post') ?>" method="post">

                    <?= csrf_field() ?>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label fs-4 fw-bold">
                            <?= lang('app.emailLabel') ?>
                        </label>
                        <!-- Si hi ha error de login, tornema  posar els valors antics (old) a value -->
                        <input type="email"
                               name="email"
                               id="email"
                               class="form-control <?= isset($validation) && $validation->hasError('email') ? 'is-invalid' : '' ?>"
                               value="<?= esc($old['email'] ?? '') ?>">
                        <?php if(isset($validation)): ?>
                            <div class="invalid-feedback fs-5 fw-bold">
                                <?= $validation->getError('email') ?>
                            </div>
                        <?php endif ?>
                    </div>

                    <!-- contraseña -->
                    <div class="mb-3">
                        <label for="password" class="form-label fs-4 fw-bold">
                            <?= lang('app.passwordLabel') ?>
                        </label>
                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control <?= isset($validation) && $validation->hasError('password') ? 'is-invalid' : '' ?>">
                        <?php if(isset($validation)): ?>
                            <div class="invalid-feedback fs-5 fw-bold">
                                <?= $validation->getError('password') ?>
                            </div>
                        <?php endif ?>
                    </div>


                    <div class="d-grid">
                        <button id="sign-Button" class="btn btn-xl btn-outline-light shadow-sm rounded" type="submit">
                            <?= lang('app.signIn')?> <i class="fas fa-sign-in-alt"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
