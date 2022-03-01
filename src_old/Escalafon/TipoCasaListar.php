<?php
$Header_allowedMethods = array( 'GET' );
include '../../src/api/header.php';
require_once('../../App/Escalafon/Controllers/TipoCasaController.php');

$arrayReturn = $Api_arrayReturn;

if( !in_array($Header_requestMethod, $Header_allowedMethods) ){
	http_response_code(405);
	$arrayReturn['mensaje'] = 'Método no permitido';
	echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
	exit;
}
$ClsTipoCasaController = new TipoCasaController();

//$arrayParametrosInput = json_decode(file_get_contents('php://input'));
try{
	$dtListarRegistros = $ClsTipoCasaController->fncListarRegistros($Api_id_get_first);

	if(fncGeneralValidarDataArray($dtListarRegistros)){
		$arrayReturn['mensaje'] = 'Registros listados con éxito';
		$arrayReturn['error']   = false;
		http_response_code(200);
	} else {
		$arrayReturn['mensaje'] = 'No existen registro';
	}
	$arrayReturn['error']   = false;
	$arrayReturn['data']    = $dtListarRegistros;
	http_response_code(200);
} catch ( Exception $e ){
	$arrayReturn['mensaje'] = $e->getMessage();
	$arrayReturn['error']   = true;
	http_response_code(400);
}

echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);

?>