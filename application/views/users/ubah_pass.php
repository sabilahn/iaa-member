<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>IAA Investment | Ubah Password</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/stisla/vendors/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/stisla/vendors/fontawesome/css/all.min.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/stisla/vendors/bootstrap-social/bootstrap-social.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/stisla/build/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/stisla/build/css/components.css">
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

    <style>
        body {
            background-image: url('<?= base_url('assets/stisla/images/bg-lg.png') ?>');
            background-size: cover;
        }
    </style>
    <!-- /END GA -->
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <h2 class="text-center" style="color: #116754;"><i class="fa fa-key" style="color: rgba(0, 0, 0, 0.4)"></i> Ubah Password</h2><br>

                        <div class="card card-primary">
                            <div class="card-body">
                                <?php if ($this->session->flashdata('error')) : ?>
                                    <div class="alert alert-danger alert-dismissible show fade">
                                        <div class="alert-body">
                                            <button class="close" data-dismiss="alert">
                                                <span>&times;</span>
                                            </button>
                                            <?= $this->session->flashdata('error'); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if ($this->session->flashdata('error1')) : ?>
                                    <div class="alert alert-danger alert-dismissible show fade">
                                        <div class="alert-body">
                                            <button class="close" data-dismiss="alert">
                                                <span>&times;</span>
                                            </button>
                                            <?= $this->session->flashdata('error1'); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <form action="<?= site_url() ?>auth/update_password" method="POST">
                                    <div class="form-group">
                                        <label for="o_userpass">Password</label>
                                        <input name="o_userpass" id="o_userpass" type="password" class="form-control pwstrength" data-indicator="pwindicator" name="n-userpass" tabindex="2" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="n_userpass">Password Baru</label>
                                        <input name="n_userpass" id="n_userpass" type="password" class="form-control pwstrength" data-indicator="pwindicator" name="n-userpass" tabindex="2" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="c_userpass">Konfirmasi Password</label>
                                        <input name="c_userpass" id="c_userpass" type="password" class="form-control" name="c-userpass" tabindex="2" required>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4" id="ubah_password">
                                            Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="simple-footer">
                            Copyright &copy; Stisla 2018
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- General JS Scripts -->
    <script src="<?php echo base_url() ?>assets/stisla/vendors/modules/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>assets/stisla/vendors/modules/popper.js"></script>
    <script src="<?php echo base_url() ?>assets/stisla/vendors/modules/tooltip.js"></script>
    <script src="<?php echo base_url() ?>assets/stisla/vendors/modules/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>assets/stisla/vendors/modules/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="<?php echo base_url() ?>assets/stisla/vendors/modules/moment.min.js"></script>
    <script src="<?php echo base_url() ?>assets/stisla/build/js/stisla.js"></script>

    <!-- JS Libraies -->

    <!-- Page Specific JS File -->

    <!-- Template JS File -->
    <script src="assets/stisla/build/js/scripts.js"></script>
    <script src="assets/stisla/build/js/custom.js"></script>


    <!-- basic scripts -->

    <!--[if !IE]> -->
    <script src="<?php echo base_url() ?>assets/stisla/vendors/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>assets/stisla/vendors/bootstrap/js/bootstrap.min.js"></script>

    <!-- <![endif]-->


</body>

</html>