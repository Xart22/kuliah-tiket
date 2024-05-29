<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Custom fonts for this template-->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body>

    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card o-hidden border-0 shadow-lg my-5" style="width: 50%;">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image">
                        <img src="assets/img/banner-auth.png" alt="register" style="width: 100%; height: 100%;">
                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                            </div>
                            <!-- Menampilkan pesan error jika ada -->

                            <form action="/login" method="post">
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" placeholder="Email Address" required name="email">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user" placeholder="Password" required name="password" id="password">
                                </div>
                                <?php if (!empty($error)) : ?>
                                    <div class="alert alert-danger">
                                        <?= htmlspecialchars($error) ?>
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <!-- Show error -->
                                    <div class="alert alert-danger" id="error" style="display: none;"></div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block" id="loginButton">
                                    Login
                                </button>
                                <hr>
                                <a href="index.html" class="btn btn-google btn-user btn-block">
                                    <i class="fab fa-google fa-fw"></i> Login with Google
                                </a>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="/register">Create an Account!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="assets/js/sb-admin-2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#loginButton').prop('disabled', true);
            $('#password').on('input', function() {
                if ($(this).val().length < 8) {
                    $('#error').show();
                    $('#password').addClass('is-invalid');
                    $('#error').text('Password must be at least 8 characters');
                } else {
                    $('#loginButton').prop('disabled', false);
                    $('#password').removeClass('is-invalid');
                    $('#error').hide();
                }
            });


        });
    </script>

</body>

</html>