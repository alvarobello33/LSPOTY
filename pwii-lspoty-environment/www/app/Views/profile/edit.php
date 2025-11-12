<?= $this->extend('base') ?>

<?= $this->section('title') ?>
<?=lang('app.profileEditTitle')?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <section class="page-section text-center" style="background: #20c997; color: white;">
        <div class="container">
            <!-- Mensajes Flash -->
            <?php if (session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="max-width: 600px; margin: 0 auto 30px;">
                    <?= session('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="max-width: 600px; margin: 0 auto 30px;">
                    <?= session('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Mostrar errores de validación -->
            <?php if (session('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="max-width: 600px; margin: 0 auto 30px;">
                    <ul class="mb-0">
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Contenido -->
            <h1 class="text-uppercase font-weight-bold"><?=lang('app.profileEdit')?></h1>
            <div class="divider-custom">
                <div class="divider-custom-line" style="background: white;"></div>
                <div class="divider-custom-icon" style="color: white;"><i class="fas fa-user-edit"></i></div>
                <div class="divider-custom-line" style="background: white;"></div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow my-4" style="border-radius: 15px; border: none;">
                        <div class="card-body p-5">
                            <form action="<?= site_url('profile/update') ?>" method="post" enctype="multipart/form-data">
                                <?= csrf_field() ?>

                                <div class="row">
                                    <div class="col-md-4 text-center mb-4 mb-md-0">
                                        <?php if ($user['profile_pic']): ?>
                                            <img src="<?= base_url($user['profile_pic']) ?>" alt="<?=lang('app.profilePicture')?>"
                                                 class="img-fluid rounded-circle mb-3 shadow"
                                                 style="width: 180px; height: 180px; object-fit: cover; border: 5px solid white;"
                                                 id="profile-pic-preview">
                                        <?php else: ?>
                                            <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 shadow"
                                                 style="width: 180px; height: 180px; background: #20c997; border: 5px solid white; margin: 0 auto;">
                                                <i class="fas fa-user text-white" style="font-size: 4rem;"></i>
                                            </div>
                                        <?php endif; ?>

                                        <div class="custom-file mt-3">
                                            <input type="file" class="custom-file-input <?= session('errors.profile_pic') ? 'is-invalid' : '' ?>"
                                                   id="profile_pic" name="profile_pic"
                                                   onchange="previewProfilePic(this)">
                                            <label class="custom-file-label btn btn-outline-dark rounded-pill px-4 shadow-sm"
                                                   for="profile_pic">
                                                <i class="fas fa-camera me-2"></i><?=lang('app.profileChangePicture')?>
                                            </label>
                                            <?php if (session('errors.profile_pic')): ?>
                                                <div class="invalid-feedback d-block">
                                                    <?= session('errors.profile_pic') ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="col-md-8 text-start">
                                        <div class="mb-4">
                                            <label for="username" class="form-label fw-bold text-dark h5">
                                                <i class="fas fa-user me-2" style="color: #20c997;"></i><?=lang('app.profileUsername')?>
                                            </label>
                                            <input type="text" class="form-control form-control-lg <?= session('errors.username') ? 'is-invalid' : '' ?>"
                                                   id="username" name="username" value="<?= old('username', $user['username']) ?>">
                                            <?php if (session('errors.username')): ?>
                                                <div class="invalid-feedback">
                                                    <?= session('errors.username') ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Sección para cambiar contraseña -->
                                        <div class="mb-4 password-change-section">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <label class="form-label fw-bold text-dark h5 mb-0">
                                                    <i class="fas fa-lock me-2" style="color: #20c997;"></i><?=lang('app.profileChangePass')?>
                                                </label>
                                                <button type="button" class="btn btn-sm btn-outline-secondary toggle-password-fields">
                                                    <i class="fas fa-edit me-1"></i><?=lang('app.profileChange2')?>
                                                </button>
                                            </div>

                                            <div class="password-fields" style="display: none;">
                                                <div class="mb-3">
                                                    <label for="new_password" class="form-label"><?=lang('app.profileNewPassword')?></label>
                                                    <input type="password" class="form-control <?= session('errors.new_password') ? 'is-invalid' : '' ?>"
                                                           id="new_password" name="new_password">
                                                    <?php if (session('errors.new_password')): ?>
                                                        <div class="invalid-feedback">
                                                            <?= session('errors.new_password') ?>
                                                        </div>
                                                    <?php endif; ?>
                                                    <small class="text-muted"><?=lang('app.profilePass8Change')?></small>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="repeat_password" class="form-label"><?=lang('app.profileRepeatPass')?></label>
                                                    <input type="password" class="form-control <?= session('errors.repeat_password') ? 'is-invalid' : '' ?>"
                                                           id="repeat_password" name="repeat_password">
                                                    <?php if (session('errors.repeat_password')): ?>
                                                        <div class="invalid-feedback">
                                                            <?= session('errors.repeat_password') ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label for="age" class="form-label fw-bold text-dark h5">
                                                <i class="fas fa-birthday-cake me-2" style="color: #20c997;"></i><?=lang('app.profileAge')?>
                                            </label>
                                            <input type="number" class="form-control form-control-lg <?= session('errors.age') ? 'is-invalid' : '' ?>"
                                                   id="age" name="age" value="<?= old('age', $user['age']) ?>"
                                                   min="1" max="120">
                                            <?php if (session('errors.age')): ?>
                                                <div class="invalid-feedback">
                                                    <?= session('errors.age') ?>
                                                </div>
                                            <?php endif; ?>
                                            <small class="text-muted"><?=lang('app.profileAgeRange')?></small>
                                        </div>

                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                            <a href="<?= site_url('profile') ?>" class="btn btn-outline-dark btn-lg rounded-pill px-4 shadow-sm me-md-2">
                                                <i class="fas fa-times me-2"></i><?=lang('app.profileCancelEdit')?>
                                            </a>
                                            <button type="submit" class="btn btn-dark btn-lg rounded-pill px-4 shadow-sm">
                                                <i class="fas fa-save me-2"></i><?=lang('app.profileSaveChanges')?>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
    </script>
    <script>
        // Función para inicializar todos los tooltips
        $(document).ready(function(){
            // Cerrar alertas automáticamente después de 5 segundos
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);

            function previewProfilePic(input) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        let preview = document.getElementById('profile-pic-preview');
                        if (!preview) {
                            const placeholder = document.querySelector('.rounded-circle i');
                            if (placeholder) {
                                placeholder.parentElement.innerHTML = '<img id="profile-pic-preview" class="img-fluid rounded-circle shadow" style="width: 180px; height: 180px; object-fit: cover; border: 5px solid white;">';
                                preview = document.getElementById('profile-pic-preview');
                            }
                        }
                        preview.src = e.target.result;
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            // Toggle para campos de contraseña
            document.querySelector('.toggle-password-fields').addEventListener('click', function() {
                const fields = document.querySelector('.password-fields');
                const button = this;

                if (fields.style.display === 'none') {
                    fields.style.display = 'block';
                    button.innerHTML = '<i class="fas fa-times me-1"></i>Cancelar';
                    button.classList.remove('btn-outline-secondary');
                    button.classList.add('btn-outline-danger');
                } else {
                    fields.style.display = 'none';
                    button.innerHTML = '<i class="fas fa-edit me-1"></i>Cambiar';
                    button.classList.remove('btn-outline-danger');
                    button.classList.add('btn-outline-secondary');
                    // Limpiar campos al cancelar
                    document.getElementById('new_password').value = '';
                    document.getElementById('repeat_password').value = '';
                }
            });

            // Mostrar nombre del archivo seleccionado
            document.querySelector('.custom-file-input').addEventListener('change', function(e) {
                const fileName = e.target.files[0] ? e.target.files[0].name : 'Seleccionar archivo';
                const label = e.target.nextElementSibling;
                label.innerHTML = `<i class="fas fa-camera me-2"></i>${fileName}`;
            });
        });
    </script>

    <style>
        .custom-file-input {
            opacity: 0;
            position: absolute;
            z-index: -1;
        }
        .custom-file-label {
            cursor: pointer;
            display: inline-block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .password-fields {
            transition: all 0.3s ease;
        }
        .is-invalid {
            border-color: #dc3545;
        }
        .invalid-feedback {
            color: #dc3545;
            display: block;
            margin-top: 0.25rem;
            font-size: 0.875em;
        }
    </style>
<?= $this->endSection() ?>