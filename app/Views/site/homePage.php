<?= $this->include('site/header.php'); ?>
<style>
    .sbfaq {
        padding-left: 65px;
    }
    
    @media (max-width: 768px) {
        .sbfaq {
            padding-top: 25px;
            padding-left: 0px;
        }
    }
</style>
<?php if ($siteAdminToken['home_banner'] == 'active') : ?>
    <!--Banner Start-->
    <div id="carouselExample" class="carousel slide sbanner" style="margin-bottom: -90px;">
        <div class="carousel-inner">
            <?php foreach ($banners as $key => $banner) : ?>
            <div class="carousel-item <?= ($key === 0) ? 'active' : '' ?>">
               <img src="<?= base_url('public/uploads/others/' . $banner['image']) ?>" class="d-block w-100" alt="...">
            </div>
            <?php endforeach; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!--Banner End-->
<?php endif; ?>
<section class="main-banner">
    <span class="shape-1 animate-this" style="transform: translateX(20px) translateY(-9.99981px);">
        <img src="<?= base_url() ?>public/assets/site/images/shape-1.png" alt="shape">
    </span>
    <span class="shape-2 animate-this" style="transform: translateX(20px) translateY(-9.99981px);">
        <img src="<?= base_url() ?>public/assets/site/images/shape-2.png" alt="shape">
    </span>
    <span class="shape-3 animate-this" style="transform: translateX(20px) translateY(-9.99981px);">
        <img src="<?= base_url() ?>public/assets/site/images/shape-3.png" alt="shape">
    </span>
    <span class="shape-4 animate-this" style="transform: translateX(20px) translateY(-9.99981px);">
        <img src="<?= base_url() ?>public/assets/site/images/shape-4.png" alt="shape">
    </span>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="banner-content">
                    <h2 class="h2-subtitle wow fadeInUp  animated" data-wow-delay=".4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">Welcome To <?= env('app.name') ?></h2>
                    <h1 class="h1-title wow fadeInUp  animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInUp;">Discover Skills That Build Your <span>Career <img src="<?= base_url() ?>public/assets/site/images/banner-line.png" alt="line"></span></h1>
                    <p class="wow fadeInUp  animated" data-wow-delay=".6s" style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInUp;">Unleash your potential with skills designed to shape and elevate your career. Explore practical, in-demand knowledge tailored to meet industry standards, empowering you to achieve professional success and lasting growth.</p>
                    <div class="banner-btn wow fadeInUp  animated" data-wow-delay=".7s" style="visibility: visible; animation-delay: 0.7s; animation-name: fadeInUp;">
                        <a href="#packages" class="sb-btn">Explore Courses</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="banner-img-box wow fadeInRight  animated" data-wow-delay=".4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                    <div class="aliment-1">
                        <div class="aliment-icon-red">
                            <img src="<?= base_url() ?>public/assets/site/images/banner-aliment-icon-1.png" alt="icon">
                        </div>
                        <div class="aliment-content">
                            <h3 class="h3-title">Valuable Courses</h3>
                        </div>
                    </div>
                    <div class="aliment-2">
                        <div class="aliment-icon-purple">
                            <img src="<?= base_url() ?>public/assets/site/images/banner-aliment-icon-2.png" alt="icon">
                        </div>
                        <div class="aliment-content">
                            <h3 class="h3-title">Fastest Growing Platform In India</h3>
                        </div>
                    </div>
                    <div class="aliment-3">
                        <div class="aliment-icon-green">
                            <img src="<?= base_url() ?>public/assets/site/images/banner-aliment-icon-3.png" alt="icon">
                        </div>
                        <div class="aliment-content">
                            <h3 class="h3-title">1Lakh+ Students Enrolled</h3>
                        </div>
                    </div>
                    <div class="aliment-4">
                        <img src="<?= base_url() ?>public/assets/site/images/banner-aliment-icon-4.png" alt="icon">
                    </div>
                    <div class="banner-img">
                        <img src="<?= base_url() ?>public/assets/site/images/banner-img.png" alt="banner">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!--Course Category Start-->
    <section class="main-course-category">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="course-category-title">
                        <h2 class="h2-subtitle">Course Category</h2>
                        <h2 class="h2-title">Explore Popular Courses</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="course-category-box">
                        <div class="course-category-icon">
                            <img class="dis-yes" src="<?= base_url() ?>public/assets/site/images/course-category-icon-1.png" alt="icon">
                            <img class="dis-no" src="<?= base_url() ?>public/assets/site/images/course-category-icon-1-w.png" alt="icon">
                        </div>
                        <div class="course-category-content">
                            <a href="courses.html"><h3 class="h3-title">Quality Courses</h3></a>
                            <p>Data is Everything</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="course-category-box">
                        <div class="course-category-icon">
                            <img class="dis-yes" src="<?= base_url() ?>public/assets/site/images/course-category-icon-5.png" alt="icon">
                            <img class="dis-no" src="<?= base_url() ?>public/assets/site/images/course-category-icon-5-w.png" alt="icon">
                        </div>
                        <div class="course-category-content">
                            <a href="courses.html"><h3 class="h3-title">Expert Mentors</h3></a>
                            <p>Improve your business</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="course-category-box">
                        <div class="course-category-icon">
                            <img class="dis-yes" src="<?= base_url() ?>public/assets/site/images/course-category-icon-3.png" alt="icon">
                            <img class="dis-no" src="<?= base_url() ?>public/assets/site/images/course-category-icon-3-w.png" alt="icon">
                        </div>
                        <div class="course-category-content">
                            <a href="courses.html"><h3 class="h3-title">Lifetime Access</h3></a>
                            <p>Fun & Challenging</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Course Category End-->

    <!--About Us Start-->
    <section class="main-about-us">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="instructor-title">
                        <h2 class="h2-subtitle">Courses</h2>
                        <h2 class="h2-title">Our Best Courses</h2>
                    </div>
                </div>
            </div>
            <div class="row instructor-slider">
                <?php foreach ($featuredCourses as $course) : ?>
                <div class="col-lg-3">
                    <div class="instructor-box sbcourse">
                        <div class="instructor-img">
                            <div class="shine-img">
                                <img src="<?= base_url('public/uploads/courses/' . $course['image']) ?>" alt="Instructor">
                            </div>
                        </div>
                        <a href="javascript:void(0);"><h3 class="h3-title"><?= $course['name'] ?></h3></a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <!--About Us End-->

    <!--Online Courses Start-->
    <section class="main-online-courses" id="packages">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="online-courses-title">
                        <h2 class="h2-subtitle">Our Online Courses</h2>
                        <h2 class="h2-title">Pick A Course To Get Started</h2>
                    </div>
                </div>
            </div>
            <div class="row">
               <?php foreach ($packages as $package) : ?> 
                <div class="col-lg-4">
                    <div class="course-box sbpkgbox">
                        <div class="course-img">
                            <img src="<?= base_url('public/uploads/packages/' . $package['image']) ?>" alt="course">
                        </div>
                        <div class="course-content">
                            <a href="#">
                                <h3 class="h3-title sbcoursetitle"><?= $package['name'] ?></h3>
                            </a>
                            <div class="course-instructor-review">
                                <div class="course-price-box">
                                    <span>₹ <?= $package['price'] ?>/-</span>
                                </div>
                                <div class="course-review-box">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <p>5.0 (2k)</p>
                                </div>
                            </div>
                            <div class="course-line"></div>
                            <ul class="course-content-list">
                                <li><i class="bi bi-person-workspace"></i> 10k+ Students Enrolled</li>
                                <li><i class="bi bi-book"></i> 14+ Online Courses</li>
                                <li><i class="bi bi-clock"></i> 2h 30m Course Duration</li>
                            </ul>
                            <!-- <div class="course-line"></div> -->
                            <div class="course-price-student-box" style="margin-top: 30px;">
                                <div class="course-price-box" style="width: 100%;">
                                    <a href="<?= base_url('checkout?pkg=').$package['id'] ?>" class="sb-btn" style="width: 100%; text-align: center;"> Enroll Now <i class="bi bi-chevron-double-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <!--Online Courses End-->

    <!-- <div class="fun-facts-container">
        <div class="fun-fact-item">
            <h3><span class="counter" data-target="45">0</span>K+</h3>
            <p>Active Students</p>
        </div>
        <div class="fun-fact-item">
            <h3><span class="counter" data-target="89">0</span>+</h3>
            <p>Faculty Courses</p>
        </div>
        <div class="fun-fact-item">
            <h3><span class="counter" data-target="156">0</span>K</h3>
            <p>Best Professors</p>
        </div>
        <div class="fun-fact-item">
            <h3><span class="counter" data-target="42">0</span>K</h3>
            <p>Award Achieved</p>
        </div>
    </div> -->

    <section class="main-event">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-5">
                    <div class="event-img-box wow fadeInLeft  animated" data-wow-delay=".4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInLeft;">
                        <div class="event-img">
                            <img src="<?= base_url('public/assets/site/images/event-img.jpg') ?>" alt="event">
                        </div>
                        <div class="event-video-play-box">
                            <div class="event-play-btn">
                                <a href="https://www.youtube.com/watch?v=-lQ1dNicM3k" class="event-play-icon popup-youtube" title="Play Video"><span><i class="fa fa-play" aria-hidden="true"></i></span></a>
                            </div>
                            <div class="event-video-content">
                                <h3 class="h3-title">Learn More !</h3>
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-7">
                    <div class="event-content-box">
                        <div class="event-title">
                            <h2 class="h2-subtitle">Achievements</h2>
                            <h2 class="h2-title">We Are in Numbers</h2>
                        </div>
                        <div class="event-box">
                            <div class="event-date-day">
                                <div class="event-date">
                                    <p>1L+</p>
                                </div>
                            </div>
                            <div class="event-text-line"></div>
                            <div class="event-content-text">
                                <a href="javascript:void(0);"><h3 class="h3-title">Students Enrolled On Our Platform</h3></a>
                                <p>Join our community now and unlock a world of opportunities</p>
                            </div>
                        </div>
                        <div class="event-box">
                            <div class="event-date-day">
                                <div class="event-date">
                                    <p>70+</p>
                                </div>
                            </div>
                            <div class="event-text-line"></div>
                            <div class="event-content-text">
                                <a href="javascript:void(0);"><h3 class="h3-title">Valuable Video Courses</h3></a>
                                <p>We offer a wide range of valuable video courses</p>
                            </div>
                        </div>
                        <div class="event-box">
                            <div class="event-date-day">
                                <div class="event-date">
                                    <p>28+</p>
                                </div>
                            </div>
                            <div class="event-text-line"></div>
                            <div class="event-content-text">
                                <a href="javascript:void(0);"><h3 class="h3-title">Expert Mentors</h3></a>
                                <p>We have expert mentors who guide you every step of the way</p>
                            </div>
                        </div>
                        <div class="event-box mb-0">
                            <div class="event-date-day">
                                <div class="event-date">
                                    <p>100+</p>
                                </div>
                            </div>
                            <div class="event-text-line"></div>
                            <div class="event-content-text">
                                <a href="javascript:void(0);"><h3 class="h3-title">Award Achieved</h3></a>
                                <p>We have achieved many awards that proves our excellence</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--About Us Start-->
    <section class="main-about-us sbvips">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="instructor-title">
                        <h2 class="h2-subtitle">Vip's</h2>
                        <h2 class="h2-title">Vip Members</h2>
                    </div>
                </div>
            </div>
            <div class="row instructor-slider">
                <?php foreach ($vipMembers as $member) : ?>
                <div class="col-lg-3">
                    <div class="instructor-box sbcourse">
                        <div class="instructor-img">
                            <div class="shine-img">
                                <img src="<?= base_url('public/uploads/others/' . $member['image']) ?>" alt="Instructor">
                            </div>
                        </div>
                        <a href="javascript:void(0);"><h3 class="h3-title"><?= $member['name'] ?></h3></a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <!--About Us End-->

    <!--Core Features Start-->
    <section class="main-core-features">
        <div class="core-features-img" style="background-image: url(https://www.old.skillsbazzar.com/upload/banner_image/66102508524bf.jpg);"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="core-features-content">
                        <div class="core-features-title">
                            <h2 class="h2-subtitle">Founder & CEO</h2>
                            <h2 class="h2-title">Mr. Prince Rajput</h2>
                        </div>
                        <div class="core-features-box">
                            <p style="text-align: justify; color: #d7d7d7;">Prince Rajput is the Founder & CEO of Skillsbazzar, a top e-learning platform focused on digital skills courses. With a massive following of over 200k+ on Instagram and a significant presence on YouTube, he's a key influencer with over 4 years of experience in Digital Marketing feild. Prince's goal is to empower people with digital knowledge, bridging education and industry needs. He envisions a community of thriving entrepreneurs through Skillsbazzar, making him a leader in digital education.</p>
                        </div>
                        <a href="javascript:void(0);" class="sb-btn">Get Started</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Core Features End-->

    <!--Testimonial Start-->
    <section class="main-testimonial">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="testimonial-title">
                        <h2 class="h2-subtitle">Testimonial</h2>
                        <h2 class="h2-title">Words From Our Students</h2>
                        <p>Proin et lacus eu odio tempor porttitor id vel augue. Vivamus volutpat vehicula sem, et imperdiet enim tempor id. Phasellus lobortis efficitur nisl eget vehicula. Donec viverra blandit nunc, nec tempor ligula ullamcorper venenatis.</p>
                    </div>
                </div>
                <div class="col-lg-6 p-0">
                    <div class="testimonial-slider">
                        <div class="testimonial-box sbbox">
                            <p>&quot;Proin feugiat tortor non neque eleifend, at fermentum est elementum. Ut mollis leo odio vulputate rutrum. Nunc sagittis sit amet ligula ut eleifend. Mauris consequat mauris sit amet turpis commodo fermentum. Quisque consequat tortor ut nisl finibus&quot;.</p>
                            <div class="testimonial-client">
                                <div class="testimonial-client-img-box">
                                    <div class="testimonial-img">
                                        <img src="<?= base_url() ?>public/assets/site/images/client-1.jpg" alt="client">
                                    </div>
                                </div>
                                <div class="testimonial-client-name">
                                    <h3 class="h3-title">Christine Rose</h3>
                                    <span>Customer</span>
                                </div>
                            </div>
                            <div class="testimonial-quote">
                                <img src="<?= base_url() ?>public/assets/site/images/quote.png" alt="quote">
                            </div>
                        </div>
                        <div class="testimonial-box sbbox">
                            <p>&quot;Proin feugiat tortor non neque eleifend, at fermentum est elementum. Ut mollis leo odio vulputate rutrum. Nunc sagittis sit amet ligula ut eleifend. Mauris consequat mauris sit amet turpis commodo fermentum. Quisque consequat tortor ut nisl finibus&quot;.</p>
                            <div class="testimonial-client">
                                <div class="testimonial-client-img-box">
                                    <div class="testimonial-img">
                                        <img src="<?= base_url() ?>public/assets/site/images/client-2.jpg" alt="client">
                                    </div>
                                </div>
                                <div class="testimonial-client-name">
                                    <h3 class="h3-title">Christine Rose</h3>
                                    <span>Customer</span>
                                </div>
                            </div>
                            <div class="testimonial-quote">
                                <img src="<?= base_url() ?>public/assets/site/images/quote.png" alt="quote">
                            </div>
                        </div>
                        <div class="testimonial-box sbbox">
                            <p>&quot;Proin feugiat tortor non neque eleifend, at fermentum est elementum. Ut mollis leo odio vulputate rutrum. Nunc sagittis sit amet ligula ut eleifend. Mauris consequat mauris sit amet turpis commodo fermentum. Quisque consequat tortor ut nisl finibus&quot;.</p>
                            <div class="testimonial-client">
                                <div class="testimonial-client-img-box">
                                    <div class="testimonial-img">
                                        <img src="<?= base_url() ?>public/assets/site/images/client-3.jpg" alt="client">
                                    </div>
                                </div>
                                <div class="testimonial-client-name">
                                    <h3 class="h3-title">Christine Rose</h3>
                                    <span>Customer</span>
                                </div>
                            </div>
                            <div class="testimonial-quote">
                                <img src="<?= base_url() ?>public/assets/site/images/quote.png" alt="quote">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Testimonial End-->

    <section class="main-faq-in">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="faq-title">
                        <h2 class="h2-subtitle">Our FAQ</h2>
                        <h2 class="h2-title">Frequently Asked Questions</h2>
                    </div>
                </div>
            </div>
            <div id="accordionExample">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="submit-ticket-img-box wow fadeInUp  animated" data-wow-delay=".4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
                        <div class="submit-ticket-img">
                            <img src="https://shivaaythemes.in/educater-demo/assets/images/contact-us-img.png" alt="submit ticket">
                        </div>
                    </div>
                    </div>
                    <div class="col-lg-8 d-flex align-items-center sbfaq">
                        <div class="accordion part-1 faq-box">
                            <?php foreach($faqs as $faq) : ?>
                            <div class="accordion-item faq-bg">
                              <h3 class="accordion-header h3-title" id="headingOne">
                                <button class="accordion-button faq-btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                <?= $faq['question'] ?><span class="icon"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
                                </button>
                              </h3>
                              <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                  <p><?= $faq['answer'] ?></p>
                                </div>
                              </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<script>
    const counters = document.querySelectorAll('.counter');
    let started = false;
    function startCount() {
        if (started) return;
        const counterSection = document.querySelector('.fun-facts-container');
        const sectionTop = counterSection.offsetTop;
        const sectionHeight = counterSection.offsetHeight;
        const windowHeight = window.innerHeight;
        const scrollY = window.scrollY;
        if (scrollY > (sectionTop - windowHeight + sectionHeight / 2)) {
            started = true;
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target'));
                const duration = 2000;
                const steps = 50;
                const increment = target / steps;
                let current = 0;
                const updateCount = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        counter.textContent = target;
                        clearInterval(updateCount);
                    } else {
                        counter.textContent = Math.floor(current);
                    }
                }, duration / steps);
            });
        }
    }
    window.addEventListener('scroll', startCount);
    window.addEventListener('load', startCount);
</script>
<?= $this->include('site/footer.php'); ?>