<?= $this->extend('base') ?>

<?= $this->section('title') ?>
<?= lang('app.profileTitle') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <section class="page-section text-center" style="background: #20c997; color: white;">
        <div class="container">
            <h1 class="text-uppercase font-weight-bold"><?= lang('app.profileMy') ?></h1>
            <div class="divider-custom">
                <div class="divider-custom-line" style="background: white;"></div>
                <div class="divider-custom-icon" style="color: white;"><i class="fas fa-user"></i></div>
                <div class="divider-custom-line" style="background: white;"></div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow my-4" style="border-radius: 15px; border: none;">
                        <div class="card-body p-5">
                            <div class="row align-items-center">
                                <div class="col-md-4 text-center mb-4 mb-md-0">
                                    <?php if ($user['profile_pic']): ?>
                                        <img src="<?= base_url($user['profile_pic']) ?>" alt="<?= lang('app.profilePicture') ?>"
                                        class="img-fluid rounded-circle mb-3 shadow"
                                             style="width: 180px; height: 180px; object-fit: cover; border: 5px solid white;">
                                    <?php else: ?>
                                        <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 shadow"
                                             style="width: 180px; height: 180px; background: #20c997; border: 5px solid white; margin: 0 auto;">
                                            <i class="fas fa-user text-white" style="font-size: 4rem;"></i>
                                        </div>
                                    <?php endif; ?>
                                    <a href="<?= site_url('profile/edit') ?>" class="btn btn-outline-dark btn-lg rounded-pill px-4 shadow-sm mt-3">
                                        <i class="fas fa-edit me-2"></i><?= lang('app.profileEdit') ?>
                                    </a>
                                </div>
                                <div class="col-md-8 text-start">
                                    <div class="profile-info">
                                        <h2 class="fw-bold mb-5 text-dark" style="margin-top: 1.5rem;"><?= esc($user['username']) ?></h2>

                                        <div class="mb-4">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-envelope me-3" style="font-size: 1.5rem; color: #20c997;"></i>
                                                <div>
                                                    <h5 class="mb-2 fw-bold text-dark"><?= lang('app.profileMail') ?></h5>
                                                    <p class="mb-0 text-dark"><?= esc($user['email']) ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <?php if ($user['age']): ?>
                                            <div class="mb-4">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-birthday-cake me-3" style="font-size: 1.5rem; color: #20c997;"></i>
                                                    <div>
                                                        <h5 class="mb-2 fw-bold text-dark"> <?=lang('app.profileAge')?></h5>
                                                        <p class="mb-0 text-dark"><?= esc($user['age']) ?>  <?=lang('app.profileAgeNum')?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <div class="mb-4">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-calendar-alt me-3" style="font-size: 1.5rem; color: #20c997;"></i>
                                                <div>
                                                    <h5 class="mb-2 fw-bold text-dark"> <?=lang('app.profileMemberSince')?></h5>
                                                    <p class="mb-0 text-dark"><?= date('d/m/Y', strtotime($user['created_at'])) ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?= $this->endSection() ?>