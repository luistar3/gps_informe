<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Controllers/ContratoController.php');
// codigo de logeo
$clsContrato = new ContratoController();
$clsContrato->fncListadoContratoView();

?>