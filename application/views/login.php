<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--===============================================================================================-->
        <!--<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>-->
        <!--===============================================================================================-->
        <link href="<?= $themes ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= $themes ?>/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= $themes ?>/dist/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!--<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">-->
        <!--<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">-->
        <link rel="stylesheet" type="text/css" href="<?= $themes ?>/dist/css/animate.css">
        <!--<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">-->
        <!--<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">-->
        <link rel="stylesheet" type="text/css" href="<?= $themes ?>/dist/css/util.css">
        <link rel="stylesheet" type="text/css" href="<?= $themes ?>/dist/css/main.css">
    </head>
    <body>

        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100 p-t-20 p-b-30" style="padding-top:0px">

                    <div class="login100-form-avatar" style="width:40%;height:auto;">
                    </div>
                    <span class="login100-form-title p-t-20 p-b-10" style="color:#114E91;font-size:20px;font-family:helvetica">
                        <!--Digital Standard Documents and Product Evaluation-->
                    </span>
                    <div class="col-md-12 alert alert-error hide">
                        <button class="close" data-dismiss="alert"></button>
                        <span class="message"></span>
                    </div>
                    <form class="login100-form validate-form" action="#" id="form_login">
                        <div class="wrap-input100 validate-input m-b-10" data-validate = "Username is required">
                            <input class="input100" type="text" id="username" name="username" placeholder="Username">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-user"></i>
                            </span>
                        </div>

                        <div class="wrap-input100 validate-input m-b-10" data-validate = "Password is required">
                            <input class="input100" type="password" id="password" name="password" placeholder="Password">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-lock"></i>
                            </span>
                        </div>
                        <div class="container-login100-form-btn p-t-10">
                            <button type="button" class="login100-form-btn" onclick="submit_form()">
                                Login
                            </button>
                        </div>
                    </form>
                    <div class="text-center w-full p-t-5 p-b-50">
                        <!-- <a href="#" class="txt1">
                            Forgot Username / Password?
                        </a> -->
                    </div>
<!--                    <div class="wrap-input100">
                        <div style="background-color:	#696969;text-align: center;font-size:15px;border-radius:5px;height: auto;color:white">
                            Hubungi Kami : <br>
                            <span>
                                <div><i class="fa fa-phone fa-fw"></i>&nbsp; Ext. 4126 / 4136</div>
                                <div><i class="fa fa-envelope fa-fw"></i>&nbsp; seksi.standarisasi@peruri.co.id</div>
                            </span>
                        </div>
                    </div>-->
                    <!-- <div class="text-center w-full">
                        <a class="txt1" href="#">
                            Create new account
                            <i class="fa fa-long-arrow-right"></i>
                        </a>
                    </div> -->

                </div>
            </div>
        </div>
        <!--===============================================================================================-->
        <script src="<?= $themes ?>/plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
        <!--===============================================================================================-->
        <!--<script src="vendor/bootstrap/js/popper.js"></script>-->
        <script src="<?= $themes ?>/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <!--===============================================================================================-->
        <!--===============================================================================================-->
        <!--<script src="js/main.js"></script>-->
        <script type="text/javascript">
                                var base_url = "<?= base_url(); ?>";
                                $(document).keypress(function (e) {
                                    if (e.which === 13) {
//                                submit_form();
                                        $(".login100-form-btn").click();
                                    }
                                });
                                function submit_form() {
                                    $('.alert').addClass('hide');
                                    var username = $('#username').val();
                                    var password = $('#password').val();
                                    if (username != '' && password != '') {
                                        $.ajax({
                                            type: "POST",
                                            url: base_url + "login/process_login",
                                            data: $('#form_login').serialize(),
                                            datatype: "json",
                                            success: function (data) {
                                                if (data['reset']) {
                                                    $('.alert').removeClass('hide');
                                                    $('.message').html('Anda tidak memiliki akses, silahkan hubungi administrator.');
                                                } else {
                                                    if (data['success']) {
                                                        if (data['login']) {
                                                            $('.alert').removeClass('hide');
                                                            $('.message').html('User sedang login.');
                                                        } else {
                                                            window.location = base_url + 'index';
                                                        }
                                                    } else if (!data['success']) {
                                                        $("#attempt").val(data['attempt']);
                                                        $('.alert').removeClass('hide');
                                                        $('.message').html('Username dan password salah.');

                                                    }
                                                }
                                            }
                                        });
                                    } else {
                                        $('.alert').removeClass('hide');
                                        $('.message').html('Mohon isi semua data.');
                                    }
                                }
        </script>
    </body>
</html>
