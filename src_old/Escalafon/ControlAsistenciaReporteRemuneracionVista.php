<?php
$Header_allowedMethods = array( 'POST', 'PUT' );
include '../../src/api/header.php';
require_once('../../App/Escalafon/Controllers/ControlAsistenciaController.php');


$arrayReturn = $Api_arrayReturn;

if( !in_array($Header_requestMethod, $Header_allowedMethods) ){
	http_response_code(405);
	$arrayReturn['mensaje'] = 'Método no permitido';
	echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
	exit;
}
$clsControlAsistenciaController = new ControlAsistenciaController();
//$clsPersona = new PersonaController();

$arrayParametrosInput = json_decode(file_get_contents('php://input'));
//$parametroImagen = $_FILES['archivo'];
if(fncGeneralValidarDataArray($arrayParametrosInput)){
	try{
		$dtGuardar = $clsControlAsistenciaController->fncGenerarReporteInformeRemuneracionVista($arrayParametrosInput);

		if( fncGeneralValidarDataArray($dtGuardar) ){
			$arrayReturn['mensaje'] = 'Registro listado con éxito';
			$arrayReturn['error']   = false;
			$arrayReturn['data']   = $dtGuardar;
			http_response_code(200);
		} else {
			$arrayReturn['mensaje'] = 'Error en Listar los datos';
			$arrayReturn['error']   = true;
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