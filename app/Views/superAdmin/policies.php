<?= $this->include('superAdmin/header') ?>
<?= $this->include('alert') ?>
<main class="page-content">
    <div class="row">
        <div class="col-12 col-lg-12 d-flex">
            <div class="card rounded-4 w-100">
                <div class="card-body p-0">
                    <div class="p-3 rounded">
                        <h6 class="mb-0 text-uppercase">Disclaimer</h6>
                        <hr>
                        <form action="<?= base_url(env('app.superAdminURL') . '/policies') ?>" method="POST" class="row g-3">
                            <?= csrf_field() ?>
                            <input type="hidden" name="policy" value="disclaimer">
                            <div class="col-md-12 col-12">
                                <textarea name="content" rows="8" class="form-control"><?= $policies[0]['data']['content'] ?? 'Write your disclaimer here..' ?></textarea>
                            </div>
                            <div class="col-md-1 col-12">
                                <div class="d-grid">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-12 d-flex">
            <div class="card rounded-4 w-100">
                <div class="card-body p-0">
                    <div class="p-3 rounded">
                        <h6 class="mb-0 text-uppercase">Privacy Policy</h6>
                        <hr>
                        <form action="<?= base_url(env('app.superAdminURL') . '/policies') ?>" method="POST" class="row g-3">
                            <?= csrf_field() ?>
                            <input type="hidden" name="policy" value="privacy_policy">
                            <div class="col-md-12 col-12">
                                <textarea name="content" rows="8" class="form-control"><?= $policies[1]['data']['content'] ?? 'Write your privacy policy here..' ?></textarea>
                            </div>
                            <div class="col-md-1 col-12">
                                <div class="d-grid">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-12 d-flex">
            <div class="card rounded-4 w-100">
                <div class="card-body p-0">
                    <div class="p-3 rounded">
                        <h6 class="mb-0 text-uppercase">Refund Policy</h6>
                        <hr>
                        <form action="<?= base_url(env('app.superAdminURL') . '/policies') ?>" method="POST" class="row g-3">
                            <?= csrf_field() ?>
                            <input type="hidden" name="policy" value="refund_policy">
                            <div class="col-md-12 col-12">
                                <textarea name="content" rows="8" class="form-control"><?= $policies[2]['data']['content'] ?? 'Write your refund policy here..' ?></textarea>
                            </div>
                            <div class="col-md-1 col-12">
                                <div class="d-grid">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-12 d-flex">
            <div class="card rounded-4 w-100">
                <div class="card-body p-0">
                    <div class="p-3 rounded">
                        <h6 class="mb-0 text-uppercase">Terms & Conditions</h6>
                        <hr>
                        <form action="<?= base_url(env('app.superAdminURL') . '/policies') ?>" method="POST" class="row g-3">
                            <?= csrf_field() ?>
                            <input type="hidden" name="policy" value="terms_and_conditions">
                            <div class="col-md-12 col-12">
                                <textarea name="content" rows="8" class="form-control"><?= $policies[3]['data']['content'] ?? 'Write your terms and conditions here..' ?></textarea>
                            </div>
                            <div class="col-md-1 col-12">
                                <div class="d-grid">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end row-->
</main>
<?= $this->include('superAdmin/footer') ?>