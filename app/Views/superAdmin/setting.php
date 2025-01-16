<?= $this->include('superAdmin/header') ?>
<?= $this->include('alert') ?>
<main class="page-content">
    <div class="row">
        <div class="col-12 col-lg-4 d-flex">
            <div class="card rounded-4 w-100">
                <div class="card-body p-0">
                    <div class="p-3 rounded">
                        <h6 class="mb-0 text-uppercase">Branding</h6>
                        <hr>
                        <h6 class="mb-3 text-uppercase text-decoration-underline">Website Logo</h6>
                        <form action="<?= base_url(env('app.superAdminURL') . '/branding-update') ?>" method="POST" enctype="multipart/form-data" class="row g-3">
                            <?= csrf_field() ?>
                            <div class="col-md-12 col-12">
                                <label for="favicon">Favicon</label>
                                <input type="file" name="favicon" class="form-control" required>
                            </div>
                            <div class="col-md-12 col-12">
                                <label for="light_logo">Light Logo</label>
                                <input type="file" name="light_logo" class="form-control" required>
                            </div>
                            <div class="col-md-12 col-12">
                                <label for="dark_logo">Dark Logo</label>
                                <input type="file" name="dark_logo" class="form-control" required>
                            </div>
                            <div class="col-3">
                                <div class="d-grid">
                                    <input type="submit" class="btn btn-primary" value="Save Changes">
                                </div>
                            </div>
                        </form>
                        <h6 class="mt-5 mb-3 text-uppercase text-decoration-underline">Website Name & Url's</h6>
                        <form action="<?= base_url(env('app.superAdminURL') . '/nameUrl-update') ?>" method="POST" class="row g-3">
                            <?= csrf_field() ?>
                            <div class="col-md-12 col-12">
                                <label for="website_name">Website Name</label>
                                <input type="text" name="website_name" class="form-control" value="<?= env('app.name') ?>" required>
                            </div>
                            <div class="col-md-12 col-12">
                                <label for="website_tagline">Website Tagline</label>
                                <input type="text" name="website_tagline" class="form-control" value="<?= env('app.slogan') ?>" required>
                            </div>
                            <div class="col-md-12 col-12">
                                <label for="website_url">Website Url - <span class="text-danger" style="font-size: 12px;">Do not change url if not required</span></label>
                                <input type="text" name="website_url" class="form-control" value="<?= env('app.baseURL') ?>" required>
                            </div>
                            <div class="col-md-12 col-12">
                                <label for="admin_url">Admin Url</label>
                                <input type="text" name="admin_url" class="form-control" value="<?= env('app.adminURL') ?>" required>
                            </div>
                            <div class="col-md-12 col-12">
                                <label for="super_admin_url">Super Admin Url</label>
                                <input type="text" name="super_admin_url" class="form-control" value="<?= env('app.superAdminURL') ?>" required>
                            </div>
                            <div class="col-md-12 col-12">
                                <label for="refcode_prefix">Ref Code Prefix</label>
                                <input type="text" name="refcode_prefix" class="form-control" value="<?= env('REFCODE_PREFIX') ?>" required>
                            </div>
                            <div class="col-3">
                                <div class="d-grid">
                                    <input type="submit" class="btn btn-primary" value="Save Changes">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4 d-flex">
            <div class="card rounded-4 w-100">
                <div class="card-body p-0">
                    <div class="p-3 rounded">
                        <h6 class="mb-0 text-uppercase">Gateway Credentials</h6>
                        <hr>
                        <h6 class="mb-3 text-uppercase text-decoration-underline">Razorpay Credentials</h6>
                        <form action="<?= base_url(env('app.superAdminURL') . '/gateway-update') ?>" method="POST"
                            class="row g-3">
                            <?= csrf_field() ?>
                            <input type="hidden" name="gateway" value="razorpay">
                            <div class="col-md-12 col-12">
                                <input type="text" name="merchant_key" class="form-control"
                                    value="<?= $gateWays['gateways'][0]['data']['merchant_key'] ?? '' ?>" required
                                    placeholder="MERCHANT KEY">
                            </div>
                            <div class="col-md-12 col-12">
                                <input type="text" name="merchant_salt" class="form-control"
                                    value="<?= $gateWays['gateways'][0]['data']['merchant_salt'] ?? '' ?>" required
                                    placeholder="MERCHANT SALT">
                            </div>
                            <div class="col-md-12 col-12">
                                <input type="text" name="razorpay_status" class="form-control"
                                    value="<?= $gateWays['gateways'][0]['data']['razorpay_status'] ?? '' ?>" required
                                    placeholder="MERCHANT STATUS">
                            </div>
                            <div class="col-3">
                                <div class="d-grid">
                                    <input type="submit" class="btn btn-primary" value="Save Changes">
                                </div>
                            </div>
                        </form>
                        <h6 class="mb-3 mt-5 text-uppercase text-decoration-underline">Phonepe Credentials</h6>
                        <form action="<?= base_url(env('app.superAdminURL') . '/gateway-update') ?>" method="POST"
                            class="row g-3">
                            <?= csrf_field() ?>
                            <input type="hidden" name="gateway" value="phonepe">
                            <div class="col-md-12 col-12">
                                <input type="text" name="merchant_id" class="form-control"
                                    value="<?= $gateWays['gateways'][1]['data']['merchant_id'] ?? '' ?>" required
                                    placeholder="MERCHANT ID">
                            </div>
                            <div class="col-md-12 col-12">
                                <input type="text" name="merchant_index" class="form-control"
                                    value="<?= $gateWays['gateways'][1]['data']['merchant_index'] ?? '' ?>" required
                                    placeholder="MERCHANT INDEX">
                            </div>
                            <div class="col-md-12 col-12">
                                <input type="text" name="merchant_salt" class="form-control"
                                    value="<?= $gateWays['gateways'][1]['data']['merchant_salt'] ?? '' ?>" required
                                    placeholder="MERCHANT SALT">
                            </div>
                            <div class="col-md-12 col-12">
                                <input type="text" name="phonepe_status" class="form-control"
                                    value="<?= $gateWays['gateways'][1]['data']['phonepe_status'] ?? '' ?>" required
                                    placeholder="MERCHANT STATUS">
                            </div>
                            <div class="col-3">
                                <div class="d-grid">
                                    <input type="submit" class="btn btn-primary" value="Save Changes">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12 col-lg-4 d-flex">
            <div class="card rounded-4 w-100">
                <div class="card-body p-0">
                    <div class="p-3 rounded">
                        <h6 class="mb-0 text-uppercase">Other Credentials</h6>
                        <hr>
                        <h6 class="mb-3 text-uppercase text-decoration-underline">Email Credentials</h6>
                        <form action="<?= base_url(env('app.superAdminURL') . '/email-update') ?>" method="POST"
                            class="row g-3">
                            <?= csrf_field() ?>
                            <div class="col-md-12 col-12">
                                <input type="text" name="from_name" class="form-control" value="<?= env('email.fromName') ?>" required placeholder="FROM NAME">
                            </div>
                            <div class="col-md-12 col-12">
                                <input type="text" name="from_email" class="form-control" value="<?= env('email.fromEmail') ?>" required placeholder="FROM EMAIL">
                            </div>
                            <div class="col-md-12 col-12">
                                <input type="text" name="smtp_host" class="form-control" value="<?= env('email.SMTPHost') ?>" required placeholder="SMTP HOST">
                            </div>
                            <div class="col-md-12 col-12">
                                <input type="text" name="smtp_username" class="form-control" value="<?= env('email.SMTPUser') ?>" required placeholder="SMTP USERNAME">
                            </div>
                            <div class="col-md-12 col-12">
                                <input type="text" name="smtp_password" class="form-control" value="<?= env('email.SMTPPass') ?>" required placeholder="SMTP PASSWORD">
                            </div>
                            <div class="col-md-12 col-12">
                                <input type="text" name="smtp_port" class="form-control" value="<?= env('email.SMTPPort') ?>" required placeholder="SMTP PORT">
                            </div>
                            <div class="col-md-12 col-12">
                                <input type="text" name="smtp_encryption" class="form-control" value="<?= env('email.SMTPCrypto') ?>" required placeholder="SMTP ENCRYPTION">
                            </div>
                            <div class="col-3">
                                <div class="d-grid">
                                    <input type="submit" class="btn btn-primary" value="Save Changes">
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