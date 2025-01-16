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
    width: 40%;
    margin: 0 auto;
    padding: 20px !important;
}
@media (max-width: 767px) {
    .get-touch-box {
        width: 100%;
    }
}
</style>

<?= $this->include('site/header') ?>
<?= $this->include('alert') ?>
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
                        <h1 class="h1-title">Login</h1>
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
                            <li><a href="login">Login</a></li>
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
                            <h2 class="h2-subtitle">Login Account</h2>
                            <h2 class="h2-title">Welcome Back! 🤩</h2>
                        </div>
                        <div class="get-touch-form">
                            <form action="<?= base_url('login') ?>" method="POST">
                                <?= csrf_field() ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-box">
                                            <input type="email" name="email" class="form-input" placeholder="Email Address" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-box">
                                            <input type="password" name="password" id="password" class="form-input" placeholder="Password" required>
                                            <span class="password-toggle" onclick="togglePasswordVisibility()">
                                                <p id="togglePassword" style="cursor: pointer; margin-bottom: 0px;"><i class="bi bi-eye-slash-fill"></i></p>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="single-method mt-2 mb-2">
                                            <input type="checkbox" id="remember_me" name="remember_me" value="1">
                                            <label for="remember_me">&nbsp;Remember Me</label>
                                        </div>
                                        <div class="single-method mt-2 mb-2">
                                            <a href="<?= base_url('forgot-password') ?>" class="forgot-password-link">Forgot Password?</a>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="form-box mb-0">
                                            <button type="submit" class="sb-btn w-100 mb-3"><span>Login Account</span></button>
                                            <p class="text-center">Don't have an account? <a href="<?= base_url('checkout') ?>">Click Here</a></p>
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