<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>OneStopPolos | <?= session('title'); ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url(); ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url(); ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url(); ?>/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="../../index2.html"><b>OneStop</b>Polos</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Perhitungan Harga Penjualan Produk</p>

                <?= form_open('login/cekuser', ['class' => 'formlogin']); ?>
                <?= csrf_field(); ?>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Username" name="userid" id="userid" autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback errorUserId">
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password" name="pass" id="pass">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback errorPassword">
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <a href="<?= base_url('login/daftar'); ?>" class="text-center">Daftar Akun</a>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block btnlogin">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
                <?= form_close(); ?>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?= base_url(); ?>/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url(); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url(); ?>/dist/js/adminlte.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.formlogin').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: "json",
                    beforeSend: function() {
                        $('.btnlogin').prop('disabled', true);
                        $('.btnlogin').html('<i class="fa fa-spin fa-spinner"></i>');
                    },
                    complete: function() {
                        $('.btnlogin').prop('disabled', false);
                        $('.btnlogin').html('Login');
                    },
                    success: function(response) {
                        if (response.error) {
                            if (response.error.userid) {
                                $('#userid').addClass('is-invalid');
                                $('.errorUserId').html(response.error.userid);
                            } else {
                                $('#userid').removeClass('is-invalid');
                                $('.errorUserId').html('');
                            }

                            if (response.error.password) {
                                $('#pass').addClass('is-invalid');
                                $('.errorPassword').html(response.error.password);
                            } else {
                                $('#pass').removeClass('is-invalid');
                                $('.errorPassword').html('');
                            }
                        }

                        if (response.sukses) {
                            window.location = response.sukses.link;
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
                return false;
            });
        });
    </script>

</body>

</html>