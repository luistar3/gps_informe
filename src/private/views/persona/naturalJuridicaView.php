<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Controllers/PersonaNaturalController.php');
// codigo de logeo
$clsPerosonaNaturalController = new PersonaNaturalController();
$clsPerosonaNaturalController->fncNaturalJuridicaView();

?>