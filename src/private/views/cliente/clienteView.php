<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Controllers/ClienteController.php');
// codigo de logeo
$clsClientelController = new ClienteController();
$clsClientelController->fncIndexView();

?>