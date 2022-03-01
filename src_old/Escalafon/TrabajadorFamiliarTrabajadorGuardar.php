<?php
$Header_allowedMethods = array( 'POST', 'PUT' );
include '../../src/api/header.php';
require_once('../../App/Escalafon/Controllers/TrabajadorFamiliarController.php');


$arrayReturn = $Api_arrayReturn;

if( !in_array($Header_requestMethod, $Header_allowedMethods) ){
	http_response_code(405);
	$arrayReturn['mensaje'] = 'Método no permitido';
	echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
	exit;
}
$clsTrabajadorFamiliarController = new TrabajadorFamiliarController();
//$clsPersona = new PersonaController();

$arrayParametrosInput = json_decode(file_get_contents('php://input'));
//$parametroImagen = $_FILES['imagen'];
if(fncGeneralValidarDataArray($arrayParametrosInput)){
	try{
		$dtGuardar = $clsTrabajadorFamiliarController->fncGuardarFamiliarTrabajadorFamiliar($arrayParametrosInput);

		if( fncGeneralValidarDataArray($dtGuardar[0]) ){
			$arrayReturn['mensaje'] = 'Registro guardado con éxito';
			$arrayReturn['error']   = false;
			$arrayReturn['data']   = $dtGuardar[0];
			http_response_code(200);
		} else {
			$arrayReturn['mensaje'] = $dtGuardar[1];
			$arrayReturn['error']   = true;
			$arrayReturn['data']   = [];
			http_response_code(500);
		}
	} catch ( Exception $e ){
		$arrayReturn['mensaje'] = $e->getMessage();
		$arrayReturn['error']   = true;
		http_response_code(400);
	}
} else {
	$arrayReturn['mensaje'] = 'Error en envio de datos';
	$arrayReturn['error']   = true;
	http_response_code(400);
}

echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
	
?>