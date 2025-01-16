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
                    <h1 class="h1-title">Contact Us</h1>
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
                            <li><a href="contact-us.html">Contact Us</a></li>
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
                <div class="col-lg-5">
                    <div class="contact-detail-box sbbox" style="background-color: #091c3c;">
                        <h3 class="h3-title">Contact Detail</h3>
                        <p>Give us a call or drop by anytime, we endeavour to answer all enquiries within 24 hours on business days. We will be happy to answer your questions.</p>
                        <ul>
                            <li>
                                <div class="contact-detail-icon">
                                    <img src="<?= base_url() ?>public/assets/site/images/contact-location.png" alt="location">
                                </div>
                                <div class="contact-detail-content">
                                    <p>Our Address:</p>
                                    <h3 class="contact-text">411 University St, Seattle, USA</h3>
                                </div>
                            </li>
                            <li>
                                <div class="contact-detail-icon">
                                    <img src="<?= base_url() ?>public/assets/site/images/contact-mail.png" alt="location">
                                </div>
                                <div class="contact-detail-content">
                                    <p>Our Mailbox:</p>
                                    <h3 class="contact-text">info@educater.com</h3>
                                </div>
                            </li>
                            <li>
                                <div class="contact-detail-icon">
                                    <img src="<?= base_url() ?>public/assets/site/images/contact-call.png" alt="location">
                                </div>
                                <div class="contact-detail-content">
                                    <p>Our Phones:</p>
                                    <h3 class="contact-text">+1 -800-456-478-23</h3>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="get-touch-box">
                        <div class="get-touch-title">
                            <h2 class="h2-subtitle">Get In Touch</h2>
                            <h2 class="h2-title">Ready To Get Started</h2>
                        </div>
                        <div class="get-touch-form">
                            <form>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-box">
                                            <input type="text" name="Full Name" class="form-input" placeholder="Full Name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-box">
                                            <input type="email" name="EmailAddress" class="form-input" placeholder="Email Address" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-box">
                                            <input type="text" name="Phone No" class="form-input" placeholder="Phone No." required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-box">
                                            <textarea class="form-input" placeholder="Message..."></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-box mb-0">
                                            <button type="submit" class="sb-btn"><span>Submit Now</span></button>
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

    <!--Map Start-->
    <div class="main-contact-map-in">
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d58345.8370356026!2d90.39051679999999!3d23.938690100000002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1603517982898!5m2!1sen!2sbd" width="416" height="570" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
    </div>
    <!--Map End-->
<?= $this->include('site/footer') ?>