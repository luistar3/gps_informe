<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>GPSTEL DEL SUR</title>
    <!-- HTML5 Shim and Respond.js IE9 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Phoenixcoded">
    <meta name="keywords" content=", Flat ui, Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="Phoenixcoded">
    <!-- Favicon icon -->

    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <!-- Google font-->
    
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="<?php $_SERVER["DOCUMENT_ROOT"]; ?>/gps/public/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="<?php $_SERVER["DOCUMENT_ROOT"]; ?>/gps/public/assets/icon/themify-icons/themify-icons.css">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="<?php $_SERVER["DOCUMENT_ROOT"]; ?>/gps/public/assets/icon/icofont/css/icofont.css">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="<?php $_SERVER["DOCUMENT_ROOT"]; ?>/gps/public/assets/css/style.css">
    <!--color css-->
    <link rel="stylesheet" type="text/css" href="<?php $_SERVER["DOCUMENT_ROOT"]; ?>/gps/public/assets/css/color/color-1.css" id="color" />
</head>

<body class="menu-static">
    <section class="login p-fixed d-flex text-center bg-primary common-img-bg">
        <!-- Container-fluid starts -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Authentication card start -->
                    <div class="login-card card-block auth-body">
                        <form class="md-float-material">
                            <div class="text-center">
                                <img src="http://www.gpsteldelsur.net/images/gpsteldelsur.png" alt="logo.png">
                            </div>
                            <div class="auth-box">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <h3 class="text-left txt-primary">Iniciar Sesión</h3>
                                    </div>
                                </div>
                                <hr />
                                <div class="input-group">
                                    <input type="text" class="form-control only-numeric"  value="admin" id="idUserInput" placeholder="Nro Documento">
                                    <span class="md-line"></span>
                                </div>
                                <div class="input-group">
                                    <input type="password" class="form-control" value="rasmuslerdorf" id="idPaswwordInput" placeholder="Contaseña">
                                    <span class="md-line"></span>
                                </div>
                                <div class="row m-t-25 text-left">
                                    <div class="col-sm-7 col-xs-12">
                                        <div class="checkbox-fade fade-in-primary">
                                            <!-- <label>
                                                <input type="checkbox" value="">
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span class="text-inverse">Remember me</span>
                                            </label> -->
                                        </div>
                                    </div>
                                    <div class="col-sm-5 col-xs-12 forgot-phone text-right">
                                        <a href="forgot-password.html" class="text-right f-w-600 text-inverse"> Olvidaste tu contraseña?</a>
                                    </div>
                                </div>
                                <div class="row m-t-30">
                                    <div class="col-md-12">
                                        <button type="button" id="idBtnIngresar" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Ingresar</button>
                                    </div>
                                </div>
                                <hr />

                            </div>
                        </form>
                        <!-- end of form -->
                    </div>
                    <!-- Authentication card end -->
                </div>
                <!-- end of col-sm-12 -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container-fluid -->
    </section>

    <!-- Warning Section Ends -->
    <!-- Required Jquery -->
    <script type="text/javascript" src="<?php $_SERVER["DOCUMENT_ROOT"]; ?>/gps/public/bower_components/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="<?php $_SERVER["DOCUMENT_ROOT"]; ?>/gps/public/bower_components/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?php $_SERVER["DOCUMENT_ROOT"]; ?>/gps/public/bower_components/tether/dist/js/tether.min.js"></script>
    <script type="text/javascript" src="<?php $_SERVER["DOCUMENT_ROOT"]; ?>/gps/public/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="<?php $_SERVER["DOCUMENT_ROOT"]; ?>/gps/public/bower_components/jquery-slimscroll/jquery.slimscroll.js"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="<?php $_SERVER["DOCUMENT_ROOT"]; ?>/gps/public/bower_components/modernizr/modernizr.js"></script>
    <script type="text/javascript" src="<?php $_SERVER["DOCUMENT_ROOT"]; ?>/gps/public/bower_components/modernizr/feature-detects/css-scrollbars.js"></script>
    <!-- i18next.min.js -->
    <script type="text/javascript" src="<?php $_SERVER["DOCUMENT_ROOT"]; ?>/gps/public/bower_components/i18next/i18next.min.js"></script>
    <script type="text/javascript" src="<?php $_SERVER["DOCUMENT_ROOT"]; ?>/gps/public/bower_components/i18next-xhr-backend/i18nextXHRBackend.min.js"></script>
    <script type="text/javascript" src="<?php $_SERVER["DOCUMENT_ROOT"]; ?>/gps/public/bower_components/i18next-browser-languagedetector/i18nextBrowserLanguageDetector.min.js"></script>
    <script type="text/javascript" src="<?php $_SERVER["DOCUMENT_ROOT"]; ?>/gps/public/bower_components/jquery-i18next/jquery-i18next.min.js"></script>
    <!-- Custom js -->
    <script type="text/javascript" src="<?php $_SERVER["DOCUMENT_ROOT"]; ?>/gps/public/assets/js/script.js"></script>
    <!--color js-->
    <script type="text/javascript" src="<?php $_SERVER["DOCUMENT_ROOT"]; ?>/gps/public/assets/js/common-pages.js"></script>
</body>

</html>

<script>
    function fncGetDataAuth() {
        var user = $('#idUserInput').val();
        var password = $('#idPaswwordInput').val();
        var data = {
            "user":user,
            "password":password
        }
        return data;
    }
    function fncComprobarUsuario() {
        $.ajax({
            type: "POST",
            url: "/gps/src/public/auth.php",
            data: fncGetDataAuth(),
            success: function(response) {
                var result = JSON.parse(response);
                if (result.data.auth == false) {
                    alert(result.data.authMensaje);
                }else{
                    $(location).prop('href', '/gps/src/private/views/viewInicial/clienteView.php')
                }
            }
        });
    }

    $("#idBtnIngresar").click(function (e) { 
        fncComprobarUsuario();
        
    });

    // $(document).ready(function() {
    //   $(".only-numeric").bind("keypress", function (e) {
    //       var keyCode = e.which ? e.which : e.keyCode
               
    //       if (!(keyCode >= 48 && keyCode <= 57)) {
    //         $(".error").css("display", "inline");
    //         return false;
    //       }else{
    //         $(".error").css("display", "none");
    //       }
    //   });
    // });
</script>