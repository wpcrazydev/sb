<!doctype html>
<html lang="en" class="semi-dark">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="NOINDEX,NOFOLLOW">

    <link rel="icon" type="image/png" href="<?= base_url('public/icon.png') ?>">
    <!--plugins-->
    <link href="<?= base_url('public/assets/admin/plugins/vectormap/jquery-jvectormap-2.0.2.css') ?>"
        rel="stylesheet" />
    <link href="<?= base_url('public/assets/admin/plugins/simplebar/css/simplebar.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('public/assets/admin/plugins/perfect-scrollbar/css/perfect-scrollbar.css') ?>"
        rel="stylesheet" />
    <link href="<?= base_url('public/assets/admin/plugins/metismenu/css/metisMenu.min.css') ?>" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="<?= base_url('public/assets/admin/css/bootstrap.min.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('public/assets/admin/css/bootstrap-extended.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('public/assets/admin/plugins/datatable/css/dataTables.bootstrap5.min.css') ?>"
        rel="stylesheet" />
    <link href="<?= base_url('public/assets/admin/css/style.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('public/assets/admin/css/icons.css') ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- loader-->
    <link href="<?= base_url('public/assets/admin/css/pace.min.css') ?>" rel="stylesheet" />

    <!--Theme Styles-->
    <link href="<?= base_url('public/assets/admin/css/dark-theme.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('public/assets/admin/css/light-theme.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('public/assets/admin/css/semi-dark.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('public/assets/admin/css/header-colors.css') ?>" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title><?= $title ?> - <?= env('app.name') ?></title>

    <style>
    .biz-disabled {
        opacity: 0.8;
        pointer-events: none;
        filter: blur(1.5px);
    }

    .premium-badge {
        background-color: #5b7efbf5;
        border: none;
        color: #fff;
        font-size: 12px !important;
        font-weight: 400;
        text-transform: capitalize;
    }

    .pagination {
        display: flex;
        justify-content: flex-end;
        gap: 5px;
        margin-top: 20px;
    }

    .pagination li {
        list-style: none;
    }

    .pagination li a,
    .pagination li span {
        padding: 8px 12px;
        border-radius: 4px;
        text-decoration: none;
        color: #000;
        background-color: #efefef;
    }

    .pagination li.active span {
        background-color: #0d6efd;
        color: white;
    }

    .pagination li:not(.active) a:hover {
        background-color: #f0f0f0;
    }

    .pagination li.disabled span {
        color: #6c757d;
        pointer-events: none;
        background-color: transparent;
    }

    .btn {
        font-size: 0.8rem;
    }

    .badge {
        font-size: 0.7rem;
        font-weight: 400;
        padding: 5px 10px;
    }
    </style>
</head>

<body>

    <!--start wrapper-->
    <div class="wrapper">
        <!--start top header-->
        <header class="top-header">
            <nav class="navbar navbar-expand gap-3">
                <div class="mobile-toggle-icon fs-3 d-flex d-lg-none">
                    <i class="bi bi-list"></i>
                </div>
                <div class="top-navbar-right ms-auto">
                </div>
                <div class="dropdown dropdown-user-setting">
                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                        <div class="user-setting d-flex align-items-center gap-3">
                            <img src="<?= base_url('public/assets/admin/images/avatars/avatar-1.png') ?>"
                                class="user-img" alt="">
                            <div class="d-none d-sm-block">
                                <p class="user-name mb-0">
                                    <?= $adminData['name'] ?>
                                </p>
                                <small class="mb-0 dropdown-user-designation">Admin</small>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="<?= base_url(env('app.adminURL') . '/profile') ?>">
                                <div class="d-flex align-items-center">
                                    <div class=""><i class="bi bi-person-fill"></i></div>
                                    <div class="ms-3"><span>Profile</span></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url(env('app.adminURL') . '/setting') ?>">
                                <div class="d-flex align-items-center">
                                    <div class=""><i class="bi bi-gear-fill"></i></div>
                                    <div class="ms-3"><span>Setting</span></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url(env('app.adminURL') . '/logout') ?>">
                                <div class="d-flex align-items-center">
                                    <div class="text-danger"><i class="bi bi-lock"></i></div>
                                    <div class="ms-3 text-danger"><span>Logout</span></div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!--end top header-->

        <!--start sidebar -->
        <aside class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <div>
                    <h4 class="logo-text"><?= env('app.name') ?></h4>
                </div>
                <div class="toggle-icon ms-auto"> <i class="bi bi-list"></i>
                </div>
            </div>
            <!--navigation-->
            <ul class="metismenu" id="menu">
                <?php if (session()->has('superAdminSessionData')) : ?>
                <a href="<?= base_url(env('app.adminURL') . '/goToSuperAdmin') ?>" class="btn btn-danger text-white mb-3 p-3"><i class="feather-log-out"> Go Back To Super Admin</i></a>
                <?php endif; ?>
                <li>
                    <a href="<?= base_url(env('app.adminURL') . '/dashboard') ?>" class="has-arrow">
                        <div class="parent-icon"><i class="bi bi-house-fill"></i>
                        </div>
                        <div class="menu-title">Dashboard</div>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url(env('app.adminURL') . '/packages') ?>" class="has-arrow">
                        <div class="parent-icon"><i class="bi bi-tags-fill"></i>
                        </div>
                        <div class="menu-title">Packages</div>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url(env('app.adminURL') . '/upgrade-packages') ?>" class="has-arrow">
                        <div class="parent-icon"><i class="bi bi-tags-fill"></i>
                        </div>
                        <div class="menu-title">Upgrade Packages</div>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url(env('app.adminURL') . '/users') ?>" class="has-arrow">
                        <div class="parent-icon"><i class="bi bi-person-lines-fill"></i>
                        </div>
                        <div class="menu-title">All Users</div>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url(env('app.adminURL') . '/cosmo-link') ?>" class="has-arrow">
                        <div class="parent-icon"><i class="bi bi-link"></i>
                        </div>
                        <div class="menu-title">Cosmofeed Links</div>
                    </a>
                </li>

                <li class="menu-label">Requests</li>
                <li>
                    <a href="<?= base_url(env('app.adminURL') . '/kyc-request') ?>" class="has-arrow">
                        <div class="parent-icon"><i class="bi bi-file-earmark-text-fill"></i>
                        </div>
                        <div class="menu-title">Kyc Request <?php if (getKycCount() > 0) echo '<span class="badge border border-danger">' . getKycCount() . '</span>'; ?></div>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url(env('app.adminURL') . '/payout-request') ?>" class="has-arrow">
                        <div class="parent-icon"><i class="bi bi-wallet"></i>
                        </div>
                        <div class="menu-title">Payout Request <?php if (getPayoutCount() > 0) echo '<span class="badge border border-danger">' . getPayoutCount() . '</span>'; ?></div>
                    </a>
                </li>


                <li class="menu-label">Dynamic Offers</li>
                <li>
                    <a href="<?= base_url(env('app.adminURL') . '/auto-upgrade') ?>" class="has-arrow">
                        <div class="parent-icon"><i class="bi bi-sort-up"></i>
                        </div>
                        <div class="menu-title">Auto Upgrade</div>
                    </a>
                </li>

                <li class="menu-label">Reports</li>
                <li>
                    <a href="<?= base_url(env('app.adminURL') . '/orders') ?>" class="has-arrow">
                        <div class="parent-icon"><i class="bi bi-basket2-fill"></i>
                        </div>
                        <div class="menu-title">All Orders <?php if (getOrderCount() > 0) echo '<span class="badge border border-danger">' . getOrderCount() . '</span>'; ?></div>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url(env('app.adminURL') . '/wallet-log') ?>" class="has-arrow">
                        <div class="parent-icon"><i class="bi bi-person-lines-fill"></i>
                        </div>
                        <div class="menu-title">Wallet Log</div>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url(env('app.adminURL') . '/payouts') ?>" class="has-arrow">
                        <div class="parent-icon"><i class="bi bi-person-lines-fill"></i>
                        </div>
                        <div class="menu-title">Payout Log</div>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url(env('app.adminURL') . '/referrals') ?>" class="has-arrow">
                        <div class="parent-icon"><i class="bi bi-diagram-3-fill"></i>
                        </div>
                        <div class="menu-title">Referral Log</div>
                    </a>
                </li>

                <li class="menu-label">Course Area</li>
                <li>
                    <a href="<?= base_url(env('app.adminURL') . '/courses') ?>" class="has-arrow">
                        <div class="parent-icon"><i class="bi bi-collection-play-fill"></i>
                        </div>
                        <div class="menu-title">Courses</div>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url(env('app.adminURL') . '/course-links') ?>" class="has-arrow">
                        <div class="parent-icon"><i class="bi bi-basket2-fill"></i>
                        </div>
                        <div class="menu-title">Course Links</div>
                    </a>
                </li>

                <li class="menu-label">Leads Data</li>
                <li>
                    <a href="<?= base_url(env('app.adminURL') . '/contact-form') ?>" class="has-arrow">
                        <div class="parent-icon"><i class="bi bi-pin-angle-fill"></i>
                        </div>
                        <div class="menu-title">Conact Form</div>
                    </a>
                </li>

                <li class="menu-label">Others</li>
                <li>
                    <a class="has-arrow" href="<?= base_url(env('app.adminURL') . '/testimonials') ?>">
                        <div class="parent-icon"><i class="bi bi-file-earmark-text-fill"></i>
                        </div>
                        <div class="menu-title">Testimonials</div>
                    </a>
                </li>
                <li>
                    <a class="has-arrow" href="<?= base_url(env('app.adminURL') . '/banners') ?>">
                        <div class="parent-icon"><i class="bi bi-image"></i>
                        </div>
                        <div class="menu-title">Banners</div>
                    </a>
                </li>
                <li>
                    <a class="has-arrow" href="<?= base_url(env('app.adminURL') . '/webinars') ?>">
                        <div class="parent-icon"><i class="bi bi-collection-play-fill"></i>
                        </div>
                        <div class="menu-title">Webinars</div>
                    </a>
                </li>
                <li>
                    <a class="has-arrow" href="offers">
                        <div class="parent-icon"><i class="bi bi-megaphone-fill"></i>
                        </div>
                        <div class="menu-title">Live Offers</div>
                    </a>
                </li>
                <li>
                    <a class="has-arrow" href="<?= base_url(env('app.adminURL') . '/trainings') ?>">
                        <div class="parent-icon"><i class="bi bi-collection-play-fill"></i>
                        </div>
                        <div class="menu-title">Trainings</div>
                    </a>
                </li>
                <li>
                    <a class="has-arrow" href="<?= base_url(env('app.adminURL') . '/legal-certificates') ?>">
                        <div class="parent-icon"><i class="bi bi-patch-check-fill"></i>
                        </div>
                        <div class="menu-title">Certificates</div>
                    </a>
                </li>
                <li>
                    <a class="has-arrow" href="<?= base_url(env('app.adminURL') . '/instructors') ?>">
                        <div class="parent-icon"><i class="bi bi-people-fill"></i>
                        </div>
                        <div class="menu-title">Instructors</div>
                    </a>
                </li>
                <li>
                    <a class="has-arrow" href="<?= base_url(env('app.adminURL') . '/community-links') ?>">
                        <div class="parent-icon"><i class="bi bi-box-arrow-up-right"></i>
                        </div>
                        <div class="menu-title">Community Links</div>
                    </a>
                </li>
            </ul>
            <!--end navigation-->
        </aside>
        <!--end sidebar -->