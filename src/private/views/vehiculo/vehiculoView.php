<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Controllers/VehiculoController.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Controllers/UsuarioController.php');
// codigo de logeo
$clsUsuarioController = new UsuarioController();
if (!$clsUsuarioController->fncValidarPermisoVista('VEHICULO')) {
    header('Location: /gps/src/private/views/viewInicial/clienteView.php');
}
$clsContrato = new VehiculoController();
$clsContrato->fncIndexView();

?>