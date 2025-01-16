<?= $this->include('site/header') ?>
<?= $this->include('alert') ?>
<style>
.apply-form-inner .form-submit {
    margin-top: 30px;
}

.apply-form-inner .part {
    margin-bottom: 30px;
}

.password-container {
    position: relative;
    display: flex;
    align-items: center;
}

.toggle-password {
    margin-left: -30px;
    cursor: pointer;
}

.password-input {
    padding-right: 30px;
    /* Space for the eye icon */
}
</style>
<main class="rbt-main-wrapper">
    <div class="rbt-elements-area rbt-section-gap pt--60" style="background: #c6c2fc5c;">
        <div class="container">
            <div class="row gy-5 row--30 justify-content-center">
                <div class="col-lg-7">
                    <div class="rbt-contact-form contact-form-style-1 max-width-auto">
                        <h3 class="title text-center">Register to <?= env('app.name') ?></h3>
                        <form class="max-width-auto row" action="" method="POST">
                            <?= csrf_field() ?>
                            <div class="form-group col-lg-12">
                                <select name="package_id" class="form-control">
                                    <option value="">Select Package</option>
                                    <?php foreach ($packages as $package) : ?>
                                        <option value="<?= $package['id'] ?>"><?= $package['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-12">
                                <input name="name" type="text">
                                <label>Full Name *</label>
                                <span class="focus-border"></span>
                            </div>
                            <div class="form-group col-lg-6">
                                <input name="phone" type="text" onblur="validatePhoneInput(event)" maxlength="10">
                                <label>Phone Number *</label>
                                <span class="focus-border"></span>
                            </div>
                            <div class="form-group col-lg-6">
                                <input name="email" type="text" />
                                <label>Email Address *</label>
                                <span class="focus-border"></span>
                            </div>
                            <div class="form-group col-lg-12">
                                <input name="password" type="password" id="password">
                                <span class="toggle-password"
                                    onclick="togglePasswordVisibility('password', this)">👁️</span>
                                <label>Password *</label>
                                <span class="focus-border"></span>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <div class="rbt-checkbox">
                                    <input type="checkbox" id="tandc" name="tandc">
                                    <label for="tandc">I Accept the <a href="<?= base_url('terms') ?>">Terms &
                                            Conditions</a> and <a href="<?= base_url('privacy') ?>">Privacy Policy</a></label>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <h4>Choose Payment Gateway</h4>
                                <input type="radio" name="gateway" value="razorpay"> Razorpay
                                <br><br>
                                <input type="radio" name="gateway" value="cosmofeed"> Cosmofeed
                                <br><br>
                                <input type="radio" name="gateway" value="phonepe"> PhonePe
                                <br><br>
                                <input type="radio" name="gateway" value="upiqr"> UpiQr
                                <br><br>
                                <input type="radio" name="gateway" value="wallet"> Wallet
                            </div>
                            <div class="form-submit-group col-lg-12">
                                <button type="submit" class="rbt-btn btn-md btn-gradient hover-icon-reverse w-100">
                                    <span class="icon-reverse-wrapper">
                                        <span class="btn-text">Register</span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </span>
                                </button>
                            </div>

                            <div class="col-lg-12 mt-4 text-center mt-3">
                                <p>Already have an account? <a href="<?= base_url('login') ?>" class="loginBtn">Login Here</a>
                                </p>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    // $(document).ready(function() {
    //     $('#s_code').on('input', function() {
    //         var s_code = $(this).val();
    //         if (s_code.length > 0) {
    //             $.ajax({
    //                 url: 'app/controllers/fetch_sponsor.php',
    //                 type: 'POST',
    //                 data: {
    //                     ref_code: s_code
    //                 },
    //                 success: function(response) {
    //                     $('#referralName').html(response);
    //                 },
    //                 error: function() {
    //                     $('#referralName').html(
    //                         '<p class="text-danger">An error occurred while fetching the name.</p>'
    //                     );
    //                 }
    //             });
    //         } else {
    //             $('#referralName').html('');
    //         }
    //     });
    // });

    function validatePhoneInput(event) {
        var input = event.target;
        var value = input.value;
        value = value.replace(/\D/g, '');

        if (value.length !== 10) {
            input.value = '';
            alert('Phone number must be exactly 10 digits.');
        } else {
            input.value = value;
        }
    }

    function checkSponsorCode() {
        var sponsorCode = document.getElementById('s_code').value;
        if (sponsorCode.trim() === "") {
            var confirmation = confirm("Are you sure you want to register without a sponsor code?");
            if (!confirmation) {
                window.location.href = "register";
                return false;
            }
        }
        return true;
    }

    function togglePasswordVisibility(inputId, toggleElement) {
        const passwordInput = document.getElementById(inputId);
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        toggleElement.textContent = type === 'password' ? '👁️' : '👁️‍🗨️';
    }
    </script>
    <?= $this->include('site/footer') ?>