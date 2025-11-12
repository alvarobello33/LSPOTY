<?= $this->extend('base') ?>

<?= $this->section('title') ?>
Sign Up - LSpoty
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="page-section text-center" style="background: #20c997; color: white; padding: 120px 0 80px 0;">
    <div class="container">
        <h1 class="text-uppercase font-weight-bold"><?= lang('app.signUp') ?></h1>
        <div class="divider-custom">
            <div class="divider-custom-line" style="background: white;"></div>
            <div class="divider-custom-icon" style="color: white;"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line" style="background: white;"></div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <form action="<?= route_to('sign-up-post') ?>" method="post" enctype="multipart/form-data">

                    <!-- CSRF protection -->
                    <?= csrf_field() ?>

                    <!-- Username -->
                    <div class="mb-4">
                        <label for="username" class="form-label fs-4 fw-bold">
                            <?= lang('app.usernameLabel') ?>
                        </label>

                        <!-- A value si hi ha error carreguem el valor antic (old)-->
                        <input type="text"
                               name="username"
                               id="username"
                               class="form-control <?= isset($validation) && $validation->hasError('username') ? 'is-invalid' : '' ?>"
                               value="<?= esc($old['username'] ?? '') ?>">
                        <?php if(isset($validation)): ?>

                        <!-- Mostrem missatge d'error -->
                            <div class="invalid-feedback fs-5 fw-bold">
                                <?= $validation->getError('username') ?>
                            </div>
                        <?php endif ?>
                    </div>

                    <!-- Foto perfil -->
                    <div class="mb-4">
                        <label for="profile_picture" class="form-label fs-4 fw-bold">
                            <?= lang('app.profilePictureLabel') ?>
                        </label>
                        <input type="file"
                               name="profile_pic"
                               id="profile_pic"
                               class="form-control <?= isset($validation) && $validation->hasError('profile_picture') ? 'is-invalid' : '' ?>">
                        <?php if(isset($validation)): ?>

                            <!-- Mostrem missatge d'error -->
                            <div class="invalid-feedback fs-5 fw-bold">
                                <?= $validation->getError('profile_picture') ?>
                            </div>
                        <?php endif ?>
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="form-label fs-4 fw-bold">
                            <?= lang('app.emailLabel') ?>
                        </label>

                        <!-- A value si hi ha error carreguem el valor antic -->
                        <input type="email"
                               name="email"
                               id="email"
                               class="form-control <?= isset($validation) && $validation->hasError('email') ? 'is-invalid' : '' ?>"
                               value="<?= esc($old['email'] ?? '') ?>">

                        <!-- Mostrem missatge d'error -->
                        <?php if(isset($validation)): ?>
                            <div class="invalid-feedback fs-5 fw-bold">
                                <?= $validation->getError('email') ?>
                            </div>
                        <?php endif ?>
                    </div>

                    <!-- contraseña -->
                    <div class="mb-4">
                        <label for="password" class="form-label fs-4 fw-bold">
                            <?= lang('app.passwordLabel') ?>
                        </label>
                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control <?= isset($validation) && $validation->hasError('password') ? 'is-invalid' : '' ?>">

                        <!-- Mostrem missatge d'error -->
                        <?php if(isset($validation)): ?>
                            <div class="invalid-feedback fs-5 fw-bold">
                                <?= $validation->getError('password') ?>
                            </div>
                        <?php endif ?>
                    </div>

                    <!-- Repetir contraseña -->
                    <div class="mb-4">
                        <label for="repeat_password" class="form-label fs-4 fw-bold">
                            <?= lang('app.repeatPasswordLabel') ?>
                        </label>
                        <input type="password"
                               name="repeat_password"
                               id="repeat_password"
                               class="form-control <?= isset($validation) && $validation->hasError('repeat_password') ? 'is-invalid' : '' ?>">
                        <?php if(isset($validation)): ?>

                            <!-- Mostrem missatge d'error -->
                            <div class="invalid-feedback fs-5 fw-bold">
                                <?= $validation->getError('repeat_password') ?>
                            </div>
                        <?php endif ?>
                    </div>

                    <div class="d-grid">
                        <button id="sign-Button" class="btn btn-xl btn-outline-light shadow-sm rounded" type="submit">
                            <?= lang('app.signUp') ?> <i class="fas fa-user-plus"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
