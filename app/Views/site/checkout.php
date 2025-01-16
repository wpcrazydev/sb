<?= $this->include('site/header') ?>
<?= $this->include('alert') ?>
<style>
.apply-form-inner .form-submit {
    margin-top: 30px;
}

.apply-form-inner .part {
    margin-bottom: 30px;
}

.password-toggle {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #666;
    z-index: 10;
    display: inline-block;
    pointer-events: auto;
}

.get-touch-box {
    width: 50%;
    margin: 0 auto;
    padding: 20px !important;
}
@media (max-width: 767px) {
    .get-touch-box {
        width: 100%;
    }
}
</style>
 <!--Banner Start-->
    <section class="main-banner-in">
            <span class="shape-1 animate-this">
                <img src="<?= base_url() ?>public/assets/site/images/shape-1.png" alt="shape">
            </span>
            <span class="shape-2 animate-this">
                <img src="<?= base_url() ?>public/assets/site/images/shape-2.png" alt="shape">
            </span>
            <span class="shape-3 animate-this">
                <img src="<?= base_url() ?>public/assets/site/images/shape-3.png" alt="shape">
            </span>
            <span class="shape-4 animate-this">
                <img src="<?= base_url() ?>public/assets/site/images/shape-4.png" alt="shape">
            </span>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="h1-title">Register</h1>
                    </div>
                </div>
            </div>
    </section>
    <!--Banner End-->

    <!--Banner Breadcrum Start-->
    <div class="main-banner-breadcrum">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="banner-breadcrum">
                        <ul>
                            <li><a href="/">Home</a></li>
                            <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
                            <li><a href="checkout">Register</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Banner Breadcrum End-->

    <!--Contact Us Start-->
    <section class="main-contact-page-in">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="get-touch-box sb-box">
                        <div class="get-touch-title">
                            <h2 class="h2-subtitle">Billing Details</h2>
                            <h2 class="h2-title">Register Your Account</h2>
                        </div>
                        <div class="get-touch-form">
                            <form action="<?= base_url('checkout') ?>" method="POST">
                                <?= csrf_field() ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-box">
                                            <?php if (!empty($refByParam)) : ?>
                                            <p><?= get_dynamic_data('users', 'name', ['ref_code' => $refByParam]) ?></p>
                                            <?php endif; ?>
                                            <input type="text" name="ref_by" value="<?= old('ref_by', $refByParam ?? '') ?>" class="form-input" placeholder="Referral Code <?= $siteAdminToken['referal_code_compulsory'] === 'active' ? '*' : '' ?>" style="margin-bottom: 0px;" <?= $refByParam ? 'readonly' : '' ?> <?= $siteAdminToken['referal_code_compulsory'] === 'active' ? 'required' : '' ?>>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-box">
                                            <select name="package_id" class="form-input">
                                                <option value="0" disabled <?= old('package_id') === null ? 'selected' : '' ?>>Select Package</option>
                                                <?php foreach ($packages as $package) : ?>
                                                    <option value="<?= $package['id'] ?>" 
                                                        <?= old('package_id', $pkgParam) == $package['id'] ? 'selected' : '' ?>>
                                                        <?= $package['name'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-box">
                                            <input type="text" name="name" value="<?= old('name') ?>" class="form-input" placeholder="Name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-box">
                                            <input type="number" name="phone" value="<?= old('phone') ?>" class="form-input" placeholder="Phone" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-box">
                                            <input type="email" name="email" value="<?= old('email') ?>" class="form-input" placeholder="Email Address" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-box">
                                            <input type="password" name="password" value="<?= old('password') ?>" id="password" class="form-input" placeholder="Password" required>
                                            <span class="password-toggle" onclick="togglePasswordVisibility()">
                                                <p id="togglePassword" style="cursor: pointer; margin-bottom: 0px;"><i class="bi bi-eye-slash-fill"></i></p>
                                            </span>
                                        </div>
                                    </div>

                                    <h4 style="margin-top: 20px; font-size: 20px; font-weight: 600;">Select Payment Method</h4>
                                    <?php if ($siteAdminToken['razorpay'] == 'active') : ?>
                                    <div class="single-method mb-2">
                                        <input type="radio" id="payment_razorpay" name="gateway" value="razorpay">
                                        <label for="payment_razorpay">&nbsp;Razorpay</label>
                                    </div>
                                    <?php endif; ?>

                                    <?php if ($siteAdminToken['phonepe'] == 'active') : ?>
                                    <div class="single-method mb-2">
                                        <input type="radio" id="payment_phonepe" name="gateway" value="phonepe">
                                        <label for="payment_phonepe">&nbsp;Phonepe</label>
                                    </div>
                                    <?php endif; ?>

                                    <?php if ($siteAdminToken['upi_qr'] == 'active') : ?>
                                    <div class="single-method mb-2">
                                        <input type="radio" id="payment_upi_qr" name="gateway" value="upi_qr">
                                        <label for="payment_upi_qr">&nbsp;UPI QR</label>
                                    </div>
                                    <?php endif; ?>

                                    <?php if ($siteAdminToken['wallet'] == 'active') : ?>
                                    <div class="single-method mb-2">
                                        <input type="radio" id="payment_wallet" name="gateway" value="wallet">
                                        <label for="payment_wallet">&nbsp;SB Wallet</label>
                                    </div>
                                    <?php endif; ?>

                                    <?php if ($siteAdminToken['cosmofeed'] == 'active') : ?>
                                    <div class="single-method mb-2">
                                        <input type="radio" id="payment_cosmofeed" name="gateway" value="cosmofeed">
                                        <label for="payment_cosmofeed">&nbsp;Cosmofeed</label>
                                    </div>
                                    <?php endif; ?>

                                    <div class="single-method mt-2 mb-2">
                                        <input type="checkbox" id="terms" name="terms">
                                        <label for="terms">&nbsp;I Accept the <a href="<?= base_url('privacy') ?>">Privacy Policy</a> and <a href="<?= base_url('terms') ?>">Terms & Conditions</a></label>
                                    </div>

                                    <div class="col-12 mt-2">
                                        <div class="form-box mb-0">
                                            <button type="submit" class="sb-btn"><span>Register Account</span></button>
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
    <!--Contact Us End-->

<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        const togglePassword = document.getElementById('togglePassword');
        togglePassword.innerHTML = type === 'password' ? '<i class="bi bi-eye-slash-fill"></i>' : '<i class="bi bi-eye"></i>';
    }
</script>
<?= $this->include('site/footer') ?>