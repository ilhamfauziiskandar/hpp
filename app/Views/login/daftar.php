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
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= base_url(); ?>/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- jQuery -->
    <script src="<?= base_url(); ?>/plugins/jquery/jquery.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="<?= base_url(); ?>/plugins/sweetalert2/sweetalert2.min.js"></script>
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
                <p class="login-box-msg">Daftar Akun Baru</p>

                <?= form_open('login/registration', ['class' => 'formdaftar']); ?>
                <?= csrf_field(); ?>
                <div class="input-group mb-3">
                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Lengkap">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user-circle"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback errornama">

                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="username" id="username" class="form-control" placeholder="Username">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback errorusername">

                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback errorpassword">

                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password1" id="password1" class="form-control" placeholder="Retype password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback errorpassword1">

                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <a href="<?= base_url('/login') ?>" class="text-center">Saya sudah memiliki akun</a>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block btnsimpan">Daftar</button>
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
            $('.formdaftar').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: "json",
                    beforeSend: function() {
                        $('.btnsimpan').prop('disabled', true);
                        $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i>');
                    },
                    complete: function() {
                        $('.btnsimpan').prop('disabled', false);
                        $('.btnsimpan').html('Login');
                    },
                    success: function(response) {
                        if (response.error) {
                            if (response.error.nama) {
                                $('#nama').addClass('is-invalid');
                                $('.errornama').html(response.error.nama);
                            } else {
                                $('#nama').removeClass('is-invalid');
                                $('.errornama').html('');
                            }

                            if (response.error.username) {
                                $('#username').addClass('is-invalid');
                                $('.errorusername').html(response.error.username);
                            } else {
                                $('#username').removeClass('is-invalid');
                                $('.errorusername').html('');
                            }

                            if (response.error.password) {
                                $('#password').addClass('is-invalid');
                                $('.errorpassword').html(response.error.password);
                            } else {
                                $('#password').removeClass('is-invalid');
                                $('.errorpassword').html('');
                            }

                            if (response.error.password1) {
                                $('#password1').addClass('is-invalid');
                                $('.errorpassword1').html(response.error.password1);
                            } else {
                                $('#password1').removeClass('is-invalid');
                                $('.errorpassword1').html('');
                            }
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'berhasil',
                                text: response.sukses
                            });

                        };

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