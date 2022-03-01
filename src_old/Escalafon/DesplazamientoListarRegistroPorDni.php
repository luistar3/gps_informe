<?php
$Header_allowedMethods = array( 'POST' );
include '../../src/api/header.php';
require_once('../../App/Escalafon/Controllers/DesplazamientoController.php');

$arrayReturn = $Api_arrayReturn;

if( !in_array($Header_requestMethod, $Header_allowedMethods) ){
	http_response_code(405);
	$arrayReturn['mensaje'] = 'Método no permitido';
	echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
	exit;
}
$clsDesplazamientoController = new DesplazamientoController();
$arrayParametrosInput = json_decode(file_get_contents('php://input'));
try{
	$dtListarRegistros = $clsDesplazamientoController->fncListarRegistrosPorDni($arrayParametrosInput);

	if(fncGeneralValidarDataArray($dtListarRegistros[0])){
		$arrayReturn['mensaje'] = $dtListarRegistros[1];
		$arrayReturn['error']   = $dtListarRegistros[2];
		http_response_code(200);
	} else {
		$arrayReturn['mensaje'] = $dtListarRegistros[1];
	}
	$arrayReturn['error']   = $dtListarRegistros[2];
	$arrayReturn['data']    = $dtListarRegistros[0];
	http_response_code(200);
} catch ( Exception $e ){
	$arrayReturn['mensaje'] = $e->getMessage();
	$arrayReturn['error']   = true;
	http_response_code(400);
}

echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);

?>