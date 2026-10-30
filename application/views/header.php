<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title><?= $title ?></title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/stisla/vendors/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/stisla/vendors/fontawesome/css/all.min.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/stisla/vendors/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/stisla/vendors/jquery-ui/jquery-ui.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/stisla/vendors/prism/prism.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/stisla/vendors/summernote/summernote-bs4.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/stisla/vendors/owlcarousel2/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/stisla/vendors/owlcarousel2/dist/assets/owl.theme.default.min.css">

    <link rel="stylesheet" href="<?= base_url() ?>assets/stisla/vendors/datatables/datatables.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/stisla/vendors/datatables/DataTables/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/stisla/vendors/datatables/Select-1.2.4/css/select.bootstrap4.min.css">

    <link rel="stylesheet" href="<?= base_url() ?>assets/stisla/vendors/bootstrap-daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/stisla/vendors/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/stisla/vendors/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/stisla/vendors/jquery-selectric/selectric.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/stisla/vendors/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/stisla/vendors/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">

    <!-- JQUERY -->
    <script src="<?= base_url() ?>assets/stisla/vendors/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/stisla/vendors/select2/dist/js/select2.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/stisla/vendors/bootstrap/js/bootstrap.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/stisla/vendors/jquery-ui/jquery-ui.js" type="text/javascript"></script>

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/stisla/build/css/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/stisla/build/css/components.css">
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA -->
</head>
<!-- JQuery -->

<body style="background-color: rgba(0, 0, 0, 0.03)">
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                    </ul>
                </form>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="<?= base_url() ?>assets/stisla/images/iaa-logo2.png" class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block"><?= $this->session->userdata('username'); ?></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="<?= site_url('auth/ubah_password') ?>" class="dropdown-item has-icon">
                                <i class="fas fa-edit"></i> Ubah Password
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="<?= site_url('auth/logout') ?>" class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>