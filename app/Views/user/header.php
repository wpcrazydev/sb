<!DOCTYPE html>
<html lang="zxx">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="robots" content="noindex, nofollow">
  <meta name="description" content="" />
  <meta name="keyword" content="" />
  <meta name="author" content="flexilecode" />
  <!--! BEGIN: Apps Title-->
  <title><?= $title ?> || <?= env('app.name') ?></title>
  <!--! END:  Apps Title-->
  <!--! BEGIN: Favicon-->
  <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>public/logo/<?= env('favicon')?>" />
  <!--! END: Favicon-->
  <!--! BEGIN: Bootstrap CSS-->
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/user/css/bootstrap.min.css" />
  <!--! END: Bootstrap CSS-->
  <!--! BEGIN: Vendors CSS-->
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/user/vendors/css/vendors.min.css" />
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/user/vendors/css/daterangepicker.min.css" />
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/user/vendors/css/jquery-jvectormap.min.css">
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/user/vendors/css/select2.min.css">
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/user/vendors/css/select2-theme.min.css">
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/user/vendors/css/jquery.time-to.min.css">
  <!--! END: Vendors CSS-->
  <!--! BEGIN: Custom CSS-->
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>public/assets/user/css/theme.min.css" />

  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script> -->

  <!--! END: Custom CSS-->
  <!--! HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries !-->
  <!--! WARNING: Respond.js doesn"t work if you view the page via file: !-->
  <!--[if lt IE 9]>
      <script src="https:oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https:oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  <style>
    .nxl-content {
      height: 100vh !important;
    }

    .main-content {
      padding-bottom: 65px !important;
    }

    footer {
      position: fixed;
      bottom: 0;
      width: 100%;
      z-index: 1000;
    }

    .nav-uname {
      font-size: 15px;
      font-weight: 600;
    }

    .nav-rank {
      font-size: 11px;
      margin-bottom: 0px;
      font-weight: 500;
    }

    .ls-btn {
      background: #f22049 !important;
      color: #fff !important;
      border-radius: 20px !important;
      box-shadow: 3px 3px 0px 0px #050d36;
    }

    .nxl-navigation .navbar-content .nxl-navbar>.nxl-item.active>.nxl-link, .nxl-navigation .navbar-content .nxl-navbar>.nxl-item:hover>.nxl-link {
        color: #fff;
        background-color: #f22049;
        transition: all .3s ease;
    }
    .nxl-navigation .navbar-content .nxl-item.active>.nxl-link .nxl-micon i, .nxl-navigation .navbar-content .nxl-item:hover>.nxl-link .nxl-micon i {
        color: #fff;
        transition: all .3s ease;
    }

    .ls-btn:hover {
      background: #241442 !important;
    }

    .ls-btn:active {
      background: #241442 !important;
    }

    .ls-btn:focus {
      background: #241442 !important;
    }

    .ls-td {
      padding: 8px 10px !important;
    }

    .card {
      border-radius: 15px !important;
    }

    .main-content h2 {
      font-size: 22px;
    }

    @media (max-width: 767px) {
      .main-content h2 {
        font-size: 18px;
        text-align: center;
      }
    }

    input.form-control {
      border-radius: 15px !important;
    }

    .dash-guide {
      width: 100%;
      border-radius: 10px;
      height: 255px;
    }

    @media (max-width: 767px) {
      .dash-guide {
        height: 155px;
      }
    }

    .nxl-navigation .navbar-content .nxl-link {
      display: block;
      line-height: 1.2;
      padding: 10px 15px;
      font-size: 13px;
      color: #dadada;
      font-weight: 600;
      transition: all .3s ease;
    }

    .nxl-navigation .m-header {
      z-index: 1;
      overflow: hidden;
      position: relative;
      display: flex;
      padding: 15px 30px;
      align-items: center;
      height: 80px;
      background: #fff;
      border-right: none;
      border-bottom: 1px solid #5b3aee;
    }
  </style>
</head>

<body>
  <!--! ================================================================ !-->
  <!--! [Start] Navigation Manu !-->
  <!--! ================================================================ !-->
  <nav class="nxl-navigation">
    <div class="navbar-wrapper" style="background:#0b083d;">
      <div class="m-header" style="background:#0b083d;">
        <a href="/" class="b-brand">
          <!-- ========   change your logo hear   ============ -->
          <img src="<?=base_url()?>public/logo/<?= env('light_logo') ?>" alt="" class="logo logo-lg w-100" />
          <img src="<?=base_url()?>public/logo/<?= env('dark_logo') ?>" alt="" class="logo logo-sm w-100" />
        </a>
      </div>
      <div class="navbar-content">
        <?php if (session()->has('adminSessionData')) : ?>
        <a href="<?= base_url('user/goToAdmin') ?>" class="btn btn-danger"><i class="feather-log-out"> Go Back To Admin</i></a>
        <?php endif; ?>
        <ul class="nxl-navbar">
          <li class="nxl-item nxl-hasmenu">
            <a href="dashboard" class="nxl-link">
              <span class="nxl-micon"><i class="feather-airplay"></i></span>
              <span class="nxl-mtext">Dashboard</span>
            </a>
          </li>
          <li class="nxl-item nxl-hasmenu">
            <a href="profile" class="nxl-link">
              <span class="nxl-micon"><i class="feather-user"></i></span>
              <span class="nxl-mtext">My Profile</span>
            </a>
          </li>
          <li class="nxl-item nxl-hasmenu">
            <a href="courses" class="nxl-link">
              <span class="nxl-micon"><i class="feather-book"></i></span>
              <span class="nxl-mtext">My Courses</span>
            </a>
          </li>
          <li class="nxl-item nxl-hasmenu">
            <a href="certificates" class="nxl-link">
              <span class="nxl-micon"><i class="feather-check-circle"></i></span>
              <span class="nxl-mtext">Certificates</span>
            </a>
          </li>
          <li class="nxl-item nxl-hasmenu">
            <a href="upgrade" class="nxl-link">
              <span class="nxl-micon"><i class="feather-trending-up"></i></span>
              <span class="nxl-mtext">Upgrade</span>
            </a>
          </li>
          <li class="nxl-item nxl-hasmenu">
            <a href="leaderboard" class="nxl-link">
              <span class="nxl-micon"><i class="feather-bar-chart-2"></i></span>
              <span class="nxl-mtext">Leaderboard</span>
            </a>
          </li>
          <li class="nxl-item nxl-hasmenu">
            <a href="affiliate-links" class="nxl-link">
              <span class="nxl-micon"><i class="feather-link"></i></span>
              <span class="nxl-mtext">Affiliate Link</span>
            </a>
          </li>
          <li class="nxl-item nxl-hasmenu">
            <a href="my-team" class="nxl-link">
              <span class="nxl-micon"><i class="feather-users"></i></span>
              <span class="nxl-mtext">My Team</span>
            </a>
          </li>
          <li class="nxl-item nxl-hasmenu">
            <a href="javascript:void(0);" class="nxl-link">
              <span class="nxl-micon"><i class="feather-file-text"></i></span>
              <span class="nxl-mtext">Reports</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
            </a>
            <ul class="nxl-submenu">
              <li class="nxl-item"><a class="nxl-link" href="referrals">My Referrals</a></li>
              <li class="nxl-item"><a class="nxl-link" href="payouts">Payout History</a></li>
              <li class="nxl-item"><a class="nxl-link" href="wallet-history">Wallet History</a></li>
            </ul>
          </li>

          <!--<li class="nxl-item nxl-hasmenu">-->
          <!--  <a href="marketing-contents" class="nxl-link">-->
          <!--    <span class="nxl-micon"><i class="feather-download"></i></span>-->
          <!--    <span class="nxl-mtext">Content Material</span>-->
          <!--  </a>-->
          <!--</li>-->

          <!-- <li class="nxl-item nxl-hasmenu">
            <a href="upgrade" class="nxl-link">
              <span class="nxl-micon"><i class="feather-arrow-up-circle"></i></span>
              <span class="nxl-mtext">Upgrade</span>
            </a>
          </li> -->

          <li class="nxl-item nxl-hasmenu">
            <a href="trainings" class="nxl-link">
              <span class="nxl-micon"><i class="feather-video"></i></span>
              <span class="nxl-mtext">Training</span>
            </a>
          </li>

          <li class="nxl-item nxl-hasmenu">
            <a href="webinars" class="nxl-link">
              <span class="nxl-micon"><i class="feather-video"></i></span>
              <span class="nxl-mtext">Webinars</span>
            </a>
          </li>

          <li class="nxl-item nxl-hasmenu">
            <a href="offers" class="nxl-link">
              <span class="nxl-micon"><i class="feather-target"></i></span>
              <span class="nxl-mtext">Offers</span>
            </a>
          </li>

          <li class="nxl-item nxl-hasmenu">
            <a href="community" class="nxl-link">
              <span class="nxl-micon"><i class="feather-link"></i></span>
              <span class="nxl-mtext">Community Links</span>
            </a>
          </li>
        </ul>
        <!-- <div class="card text-center">
          <div class="card-body">
            <i class="feather-box fs-4 text-dark"></i>
            <h6 class="mt-4 text-dark fw-bolder">Resources & Tools</h6>
            <p class="fs-11 my-3 text-dark">Get access free or paid resource and tools which will help you in your
              marketing journey.</p>
            <a href="resources" class="btn ls-btn text-dark w-100">Access Now</a>
          </div>
        </div> -->
      </div>
    </div>
  </nav>
  <!--! ================================================================ !-->
  <!--! [End]  Navigation Manu !-->
  <!--! ================================================================ !-->
  <!--! ================================================================ !-->
  <!--! [Start] Header !-->
  <!--! ================================================================ !-->
  <header class="nxl-header">
    <div class="header-wrapper" style="background:#0b083d;">
      <!--! [Start] Header Left !-->
      <div class="header-left d-flex align-items-center w-50">
        <!--! [Start] nxl-head-mobile-toggler !-->
        <img src="<?=base_url()?>public/logo/<?= env('light_logo') ?>" alt="" class="d-md-none" style="width:100%;">
      </div>

      <div class="header-right ms-auto">
        <div class="d-flex justify-content-end align-items-center">
          <div class="dropdown nxl-h-item">
            <a href="javascript:void(0);" data-bs-toggle="dropdown" role="button" data-bs-auto-close="outside">
              <img src="<?= base_url('public/uploads/profiles/' . $userData['image']) ?>" alt="user-image" class="rounded-circle img-fluid user-avtar me-0" style="width:40px; height:40px; onerror=this.onerror=null;this.src='https://pub-c25ed683585349ca9c61e528f07dacde.r2.dev" />
            </a>
            <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown nxl-user-dropdown" style="border-radius:15px;">
              <div class="dropdown-header">
                <div class="d-flex align-items-center">
                  <img src="<?= base_url('public/uploads/profiles/' . $userData['image']) ?>" alt="user-image" class="img-fluid user-avtar" style="width:55px; height:55px;" />
                  <div>
                    <h6 class="text-dark mb-0"><?php $firstName = explode(' ', $userData['name']);
                    $finalFirstName = $firstName[0];
                    echo $finalFirstName; ?><span class="badge bg-soft-success text-success ms-1">Online</span></h6>
                    <span class="fs-12 fw-medium text-muted"><?= $userData['email'] ?></span>
                  </div>
                </div>
              </div>
              <div class="dropdown">
                <a href="javascript:void(0);" class="dropdown-item" data-bs-toggle="dropdown">
                  <span class="hstack">
                    <i class="wd-10 ht-10 border border-2 border-gray-1 bg-success rounded-circle me-2"></i>
                    <span><?= empty($packageName) || $packageName == 0 ? 'Na' : $packageName ?></span>
                  </span>
                  <!-- <i class="feather-chevron-right ms-auto me-0"></i> -->
                </a>
              </div>
              <div class="dropdown-divider"></div>

              <a href="profile" class="dropdown-item">
                <i class="feather-user"></i>
                <span>Profile Details</span>
              </a>
              <!-- <a href="javascript:void(0);" class="dropdown-item">
                <i class="feather-dollar-sign"></i>
                <span>Puchase Invoices</span>
              </a> -->
              <a href="<?= base_url('user/profile?tab=security') ?>" class="dropdown-item">
                <i class="feather-shield"></i>
                <span>Security Setting</span>
              </a>
              <div class="dropdown-divider"></div>
              <a href="<?=base_url('user/logout')?>" class="dropdown-item ls-btn mt-3">
                <i class="feather-log-out"></i>
                <span>Logout</span>
              </a>
            </div>
          </div>

          <a href="javascript:void(0);" class="nxl-head-mobile-toggler" id="mobile-collapse"
            style="margin-left:10px; font-size: 22px;">
            <i class="feather-menu" style="font-size:28px; color:#fff;"></i>
          </a>

        </div>
      </div>
      <!--! [End] Header Right !-->
    </div>
  </header>
  <!--! ================================================================ !-->
  <!--! [End] Header !-->
  <!--! ================================================================ !-->

  <div class="modal fade" id="dashboardGuide" tabindex="-1" aria-labelledby="dashboardGuideLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title" id="dashboardGuideLabel" style="font-size:16px;">Dahboard Guide Video</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-3">
          <iframe class="dash-guide" src="https://www.youtube.com/embed/xgg3kICRRDE?si=5lHIQPTK7rPSqFBj"
            title="YouTube video player" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="comingSoon" tabindex="-1" aria-labelledby="comingSoonLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <!-- <div class="modal-header">
          <h1 class="modal-title" id="comingSoonLabel" style="font-size:16px;">Dahboard Guide Video</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div> -->
        <div class="modal-body p-3">
          <div class="d-flex justify-content-center align-items-center">
            <i class="feather-thumbs-up mb-3" style="font-size: 90px; color: #06b006;"></i>
          </div>
          <h2 class="text-center">Coming Soon</h2>
          <p class="text-center" style="font-size:13px;">Thank you for showing your intrest for this feature. We are
            working on it will make it live soon.
          </p>
        </div>
      </div>
    </div>
  </div>