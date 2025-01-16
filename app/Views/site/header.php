<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home - Skillsbazzar</title>
    <meta name="robots" content="index, follow">
    <meta name="keywords" content="Skillsbazzar" />
    <meta name="description" content="Skillsbazzar" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- FavIcon CSS -->
    <link rel="icon" href="<?= base_url() ?>public/assets/site/images/favicon.png" type="image/gif" sizes="16x16">

    <!--Bootstrap CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/assets/site/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!--Google Fonts CSS-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <!--Font Awesome Icon CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/assets/site/css/font-awesome.min.css">

    <!-- Slick Slider CSS -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/assets/site/css/slick.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/assets/site/css/slick-theme.css">

    <!-- Wow Animation CSS -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/assets/site/css/animate.min.css">

    <!--Magnific Popup CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/assets/site/css/magnific-popup.min.css">

    <!-- Main Style CSS  -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/assets/site/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/assets/site/css/custom.css">
</head>
<body>

     <!-- Loader Start -->
	<div class="loader-box">
        <div class="loader">
            <div class="image-circle">
                <img src="<?= base_url() ?>public/logo/<?= env('favicon') ?>" alt="<?= env('app.name') ?>" style="border-radius: 100%;">
            </div>
        </div>
	</div>
	<!-- Loader End -->

     <!-- Header Start -->
     <header class="site-header">
        <!--Navbar Start  -->
        <div class="header-bottom" style="background-color: #050d36;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 sb-logo">
                        <!-- Sit Logo Start -->
                        <div class="site-branding">
                            <a href="/" title="Skillsbazzar">
                                <img src="<?= base_url() ?>public/logo/<?= env('light_logo') ?>" alt="Logo">
                            </a>
                        </div>
                        <!-- Sit Logo End -->
                    </div>
                    <div class="col-lg-9">
                        <div class="header-menu">
                            <nav class="main-navigation">
                                <button class="toggle-button" style="margin-top: 5px; margin-right: -10px;">
                                    <span></span>
                                    <span class="toggle-width"></span>
                                    <span></span>
                                </button>
                               <ul class="menu">
                                   <li class="active"><a href="/">Home</a></li>
                                   <li><a href="about">About Us</a></li>
                                   <li class="sub-items">
                                    <a href="javascript:void(0);" title="Courses">Courses</a>
                                    <ul class="sub-menu">
                                        <?php foreach($packages as $package) : ?>
                                            <li><a href="<?= base_url('checkout?pkg=' . $package['id']) ?>" title="Courses"><?= $package['name'] ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                    </li>
                                   <li><a href="contact">Contact Us</a></li>
                                   <li><a href="login" class="menu-login-btn sb-btn">Login/Register</a></li>
                               </ul>
                            </nav>
                            <div class="black-shadow"></div>
                            <div class="header-btn">
                                <a href="login" class="sb-btn"><i class="bi bi-person-circle"></i> Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Navbar End  -->
    </header>
    <!-- Header End -->