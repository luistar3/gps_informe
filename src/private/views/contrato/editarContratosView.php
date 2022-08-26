<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Controllers/ContratoController.php');

$Header_allowedMethods = ['POST'];
$Header_requestMethod  = strtoupper( $_SERVER['REQUEST_METHOD'] );
if(!in_array($Header_requestMethod, $Header_allowedMethods))
{
	http_response_code(405);
	$arrayReturn["mensaje"] = "Método no permitido";
	echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
	exit;
}
include_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Controllers/UsuarioController.php');
// codigo de logeo
$clsUsuarioController = new UsuarioController();
if (!$clsUsuarioController->fncValidarPermisoVista('CONTRATO')) {
    header('Location: /gps/src/private/views/viewInicial/clienteView.php');
}
$clsContratoVehiculoController = new ContratoVehiculoController;

$input = json_decode(json_encode($_POST));

$clsContrato = new ContratoController();
$clsContrato->fncEditarContratoView($input);

?>