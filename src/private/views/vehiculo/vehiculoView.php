<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Controllers/VehiculoController.php');
// codigo de logeo
$clsContrato = new VehiculoController();
$clsContrato->fncIndexView();

?>