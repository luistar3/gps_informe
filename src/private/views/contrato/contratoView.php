<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Controllers/ContratoController.php');
// codigo de logeo
include_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Controllers/UsuarioController.php');
// codigo de logeo
$clsUsuarioController = new UsuarioController();
if (!$clsUsuarioController->fncValidarPermisoVista('CONTRATO')) {
    header('Location: /gps/src/private/views/viewInicial/clienteView.php');
}
$clsContrato = new ContratoController();
$clsContrato->fncIndexView();

?>