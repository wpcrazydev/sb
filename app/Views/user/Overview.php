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
    .minimenu .nxl-container {
        margin-left: 0;
    }
    .nxl-container {
        position: relative;
        top: 80px;
        margin-left: 0px;
        min-height: calc(100vh - 80px);
        transition: all .3s ease;
    }

    .main-content {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        padding: 30px 30px 5px !important;
    }

    .sb-profile-card {
      width: 70% !important;
    }

    @media (max-width: 767px) {
      .sb-profile-card {
        width: 100% !important;
      }
    }
  </style>
</head>
<body>
<main class="nxl-container">
    <div class="nxl-content">
        <div class="main-content">
            <!-- profile card -->
            <div class="card radius-10 sb-profile-card" style="border: 2px solid #fff">
                <div class="card-body profile-bg">
                    <div class="d-flex align-items-center">
                        <img src="<?= base_url('public/uploads/profiles/' . $userData['image']) ?>" class="rounded-circle u-img" alt="user-image" width="90" height="90">
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mt-0 dash-uname"><?= $userData['name'] ?></h5>
                            <p class="mb-0 rank"><?= $packageName ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card radius-10" style="border: 2px solid #fff">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h5 class="mt-0 dash-uname">Welcome to <?= env('app.name') ?> Dashboard</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

    <script src="<?=base_url()?>public/assets/user/vendors/js/vendors.min.js"></script>
    <!-- vendors.min.js {always must need to be top} -->
    <script src="<?=base_url()?>public/assets/user/vendors/js/daterangepicker.min.js"></script>
    <script src="<?=base_url()?>public/assets/user/vendors/js/apexcharts.min.js"></script>
    <script src="<?=base_url()?>public/assets/user/vendors/js/jquery.time-to.min.js "></script>
    <script src="<?=base_url()?>public/assets/user/vendors/js/circle-progress.min.js"></script>
    <!--! END: Vendors JS !-->
    <!--! BEGIN: Apps Init  !-->
    <script src="<?=base_url()?>public/assets/user/js/common-init.min.js"></script>
    <script src="<?=base_url()?>public/assets/user/js/dashboard-init.min.js"></script>
    <script src="<?=base_url()?>public/assets/user/js/analytics-init.min.js"></script>
    <!--! END: Apps Init !-->
    <!--! BEGIN: Theme Customizer  !-->
    <script src="<?=base_url()?>public/assets/user/js/theme-customizer-init.min.js"></script>
    <!--! END: Theme Customizer !-->
</body>
</html>