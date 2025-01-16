  <!--Footer Start-->
  <section class="main-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-logo-content">
                        <a href="/"><img src="<?= base_url() ?>public/logo/<?= env('light_logo') ?>" alt="Educater"></a>
                        <p>Our platform empowers learners to enhance their skills and knowledge through accessible and comprehensive learning resources.</p>
                        <ul>
                            <li><a href="https://www.instagram.com/skillsbazzar?igshid=YmMyMTA2M2Y" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                            <li><a href="https://www.youtube.com/@SkillsBazzar07" target="_blank"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="footer-our-link">
                        <h3 class="h3-title">Quick Links</h3>
                        <ul>
                            <li><a href="/">Home</a></li>
                            <li><a href="about-us">About Us</a></li>
                            <li><a href="contact-us">Contact Us</a></li>
                            <li><a href="login">Login</a></li>
                            <li><a href="register">Register</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="footer-other-link">
                        <h3 class="h3-title">Other Links</h3>
                        <ul>
                            <li><a href="disclaimer">Disclaimer</a></li>
                            <li><a href="privacy-policy">Privacy Policy</a></li>
                            <li><a href="refund-policy">Refund Policy</a></li>
                            <li><a href="terms-conditions">Terms & Conditions</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-copyright-bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <span class="copyright-text">Copyright &copy; <?= date('Y'); ?> <a href="/">Skillsbazzar.</a> All rights reserved.</span>
                        <?php $watermark ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Footer End-->

     <!-- Scroll To Top Start -->
	<a href="#main-banner" class="scroll-top" id="scroll-to-top">
		<i class="fa fa-arrow-up" aria-hidden="true"></i>
	</a>
	<!-- Scroll To Top End-->

    <!-- Bubbles Animation Start -->
	<div class="bubbles_wrap">
		<div class="bubble x1"></div>
		<div class="bubble x2"></div>
		<div class="bubble x3"></div>
		<div class="bubble x4"></div>
		<div class="bubble x5"></div>
		<div class="bubble x6"></div>
		<div class="bubble x7"></div>
		<div class="bubble x8"></div>
		<div class="bubble x9"></div>
		<div class="bubble x10"></div>
	</div>
	<!-- Bubbles Animation End-->
    
<!-- Jquery JS Link -->
<script src="<?= base_url() ?>public/assets/site/js/jquery.min.js"></script>

<!-- Bootstrap JS Link -->
<script src="<?= base_url() ?>public/assets/site/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>public/assets/site/js/popper.min.js"></script>

<!-- Custom JS Link -->
<script src="<?= base_url() ?>public/assets/site/js/custom.js"></script>

<!-- Slick Slider JS Link -->
<script src="<?= base_url() ?>public/assets/site/js/slick.min.js"></script>

<!-- Wow Animation JS -->
<script src="<?= base_url() ?>public/assets/site/js/wow.min.js"></script>

<!--Banner Bg Animation JS-->
<script src="<?= base_url() ?>public/assets/site/js/bg-moving.js"></script>

<!--Magnific Popup JS-->
<script src="<?= base_url() ?>public/assets/site/js/magnific-popup.js"></script>
<script src="<?= base_url() ?>public/assets/site/js/custom-magnific-popup.js"></script>

</body>
</html>