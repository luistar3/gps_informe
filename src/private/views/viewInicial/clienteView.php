<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Controllers/UsuarioController.php');
// codigo de logeo
$clsUsuarioController = new UsuarioController();
$clsUsuarioController->fncIndexViewPanel();

?>