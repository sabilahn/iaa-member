<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>IAA Investment | Login Page</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/stisla/vendors/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/stisla/vendors/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/stisla/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/stisla/vendors/jquery-ui/jquery-ui.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/stisla/vendors/datatables/Select-1.2.4/css/select.bootstrap4.min.css">

  <link rel="stylesheet" href="<?= base_url() ?>assets/stisla/vendors/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/stisla/vendors/jquery-selectric/selectric.css">

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

  <style>
    body {
      background-image: url('<?= base_url('assets/stisla/images/bg-lg.png') ?>');
      background-size: cover;
    }
  </style>
  <!-- /END GA -->
</head>
<!-- JQuery -->

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">

            <h2 class="text-center" style="color: #116754;"><i class="fa fa-lock" style="color: rgba(0, 0, 0, 0.4)"></i> IAA Investment</h2>
            </h5><br>

            <div class="card card-primary col-md-12">
              <div class="card-header">
                <h4>Login</h4>
              </div>
              <div class="card-body">
                <div id="error" name="error">

                </div>
                <div class="form-group">
                  <label>Username</label>
                  <!--<select name="username" id="username" class="form-control select2" style="width: 100%">-->

                  <!--</select>-->
                  <input id="username" type="text" class="form-control" name="username" tabindex="2" required="">
                </div>

                <div class="form-group">
                  <!-- <div class="d-block"> -->
                  <label>Password</label>
                  <!-- </div> -->
                  <input id="userpass" type="password" class="form-control" name="userpass" tabindex="2" required="">
                </div>
                <div class="form-group">
                  <label>Captcha:</label><br>
                  <div id="captcha_img" name="captcha_img">

                  </div>
                  <button class="btn btn-info mt-3 offset-md-6" onclick="getCaptcha()">Refresh Captcha</button>
                </div>
                <div class="form-group mt-3">
                  <input id="captcha" type="text" placeholder="Masukkan captcha sesuai gambar di atas!" class="form-control" tabindex="2" required="">
                </div>
                <div class="form-group">
                  <button onclick="login()" class="btn btn-primary btn-lg btn-block" tabindex="4"><i class="fas fa-key"></i>
                    Login
                  </button>
                </div>
              </div>
            </div>
            <div class="simple-footer">
              Copyright &copy; True Tech Solution
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>


  <!-- General JS Scripts -->
  <script src="<?= base_url() ?>assets/stisla/vendors/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?= base_url() ?>assets/stisla/build/js/stisla.js"></script>

  <!-- JS Libraies -->
  <script src="<?= base_url() ?>assets/stisla/vendors/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
  <script src="<?= base_url() ?>assets/stisla/vendors/jquery-ui/jquery-ui.min.js"></script>

  <!-- Page Specific JS File -->
  <script src="<?= base_url() ?>assets/stisla/build/js/page/index-0.js"></script>
  <script src="<?= base_url() ?>assets/stisla/build/js/page/bootstrap-modal.js"></script>

  <!-- Template JS File -->
  <script src="<?= base_url() ?>assets/stisla/build/js/scripts.js"></script>
  <script src="<?= base_url() ?>assets/stisla/build/js/custom.js"></script>

  <!-- JS input Libraies -->
  <script src="<?= base_url() ?>assets/stisla/vendors/jquery-pwstrength/jquery.pwstrength.min.js"></script>
  <script src="<?= base_url() ?>assets/stisla/vendors/select2/dist/js/select2.full.min.js"></script>
  <script src="<?= base_url() ?>assets/stisla/vendors/jquery-selectric/jquery.selectric.min.js"></script>

</body>

</html>

<script>
  $(document).ready(function() {
    // getUsers();
    getCaptcha();
  });

  function getUsers() {
    var path = 'users';

    $.ajax({
      type: 'POST',
      url: '<?= base_url('curl/curlGetRequest') ?>',
      data:'path=' + path,
      success: function(response) {
        var user_list = '<option value="" selected disabled>-- Pilih Username --</option>';
        var data = JSON.parse(response);

        // console.log(typeof(data));

        var user_list = '<option value="" selected disabled>-- Pilih Username --</option>';
        $.each(data, function(i, item) {
          if (item.name == "") {
            user_list += '<option value="' + item.username+ '">' + item.username + '</option>';
          } else {
            user_list += '<option value="' + item.username + '|' + item.name + '">' + item.username + ' | ' + item.name + '</option>';
          }
        });

        $('#username').html(user_list);
      }
    });
  }

  function getCaptcha() {
    var html = '<img src="<?= base_url('auth/captcha') ?>" alt="">';
    $('#captcha_img').html(html);

  }

  function login() {
    var username = $("#username").val();
    // var name = $("#username").val().split("|")[1];
    var userpass = $("#userpass").val();
    var captcha = $("#captcha").val();

    console.log(captcha);

    $.ajax({
      type: 'POST',
      data: 'username=' + username + '&userpass=' + userpass + '&captcha=' + captcha,
      url: '<?= base_url('auth/login') ?>',
      dataType: 'json',
      success: function(data) {
        var html = '';
        if (data.error == "pass") {
          html += '<div class="alert alert-danger alert-dismissible show fade">' +
            '<div class="alert-body">' +
            '<button class="close" data-dismiss="alert">' +
            '<span>&times;</span>' +
            '</button>' +
            'Gagal! Password yang dimasukkan salah.' +
            '</div>' +
            '</div>';
        } else if (data.error == "captcha") {
          html += '<div class="alert alert-danger alert-dismissible show fade">' +
            '<div class="alert-body">' +
            '<button class="close" data-dismiss="alert">' +
            '<span>&times;</span>' +
            '</button>' +
            'Gagal! Captcha yang dimasukkan salah.' +
            '</div>' +
            '</div>';
        } else {
          window.location.replace(data.success);
        }
        $("#error").html(html);
      }
    });

  }
</script>