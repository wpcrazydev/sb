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
        color: #fff;
        font-size: 12px !important;
        font-weight: 400;
        text-transform: capitalize;
    }

    /* Pagination container */
    .pagination {
        display: flex;
        justify-content: flex-end;
        gap: 5px;
        margin-top: 20px;
    }

    /* Individual page links */
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

    /* Active page */
    .pagination li.active span {
        background-color: #0d6efd;
        color: white;
    }

    /* Hover effect for non-active links */
    .pagination li:not(.active) a:hover {
        background-color: #f0f0f0;
    }

    /* Disabled links (like prev/next when not available) */
    .pagination li.disabled span {
        color: #6c757d;
        pointer-events: none;
        background-color: transparent;
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
                                    <?= $superAdminData['name'] ?>
                                </p>
                                <small class="mb-0 dropdown-user-designation">Super Admin</small>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="profile">
                                <div class="d-flex align-items-center">
                                    <div class=""><i class="bi bi-person-fill"></i></div>
                                    <div class="ms-3"><span>Profile</span></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url(env('app.superAdminURL') . '/logout') ?>">
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
                <li>
                    <a href="dashboard" class="has-arrow">
                        <div class="parent-icon"><i class="bi bi-house-fill"></i>
                        </div>
                        <div class="menu-title">Dashboard</div>
                    </a>
                </li>
                <li>
                    <a href="agency" class="has-arrow">
                        <div class="parent-icon"><i class="bi bi-person-lines-fill"></i>
                        </div>
                        <div class="menu-title">Agency Area</div>
                    </a>
                </li>

                <li class="menu-label">Content</li>
                <li>
                    <a href="faq" class="has-arrow">
                        <div class="parent-icon"><i class="bi bi-question-circle-fill"></i>
                        </div>
                        <div class="menu-title">Faq's</div>
                    </a>
                </li>

                <li>
                    <a href="policies" class="has-arrow">
                        <div class="parent-icon"><i class="bi bi-file-earmark-check-fill"></i>
                        </div>
                        <div class="menu-title">Policies</div>
                    </a>
                </li>

                <li>
                    <a href="customizer" class="has-arrow">
                        <div class="parent-icon"><i class="bi bi-tags-fill"></i>
                        </div>
                        <div class="menu-title">Customizer</div>
                    </a>
                </li>

                <li class="menu-label">Others</li>
                <li>
                    <a href="admins" class="has-arrow">
                        <div class="parent-icon"><i class="bi bi-person-lines-fill"></i>
                        </div>
                        <div class="menu-title">Admin Area</div>
                    </a>
                </li>

                <li>
                    <a href="wp-migration" class="has-arrow">
                        <div class="parent-icon"><i class="bi bi-upload"></i>
                        </div>
                        <div class="menu-title">WP Migration</div>
                    </a>
                </li>

                <li>
                    <a href="setting" class="has-arrow">
                        <div class="parent-icon"><i class="bi bi-gear-fill"></i>
                        </div>
                        <div class="menu-title">Default Settings</div>
                    </a>
                </li>
            </ul>
            <!--end navigation-->
        </aside>
        <!--end sidebar -->