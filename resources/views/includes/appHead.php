<?php 
session_start();
if (!isset($_SESSION['sesion']))  header('location: /gps/');
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php include('metaHead.php'); ?> 
</head>
<body class="menu-static">
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="ball-scale">
            <div></div>
        </div>
    </div>
    <!-- Pre-loader end -->
    <!-- Menu header start -->
    <?php @include('header.php');?>
    <!-- Menu header end -->
    <!-- Menu aside start -->
    <div class="main-menu">
        <div class="main-menu-header">
            <img class="img-40" src="/gps/public/assets/images/user.png" alt="User-Profile-Image">
            <div class="user-details">
                <span><?php echo ($_SESSION['sesionNombres']) ?> </span>
                <span id="more-details"><?php echo( $_SESSION['sesionNombreRol']) ?><i class="ti-angle-down"></i></span>
            </div>
        </div>
        <?php @include('mainMenu.php');?>
    </div>
    <!-- Menu aside end -->
    <?php @include('chat.php');?>