<?php
$Header_allowedMethods = array( 'POST', 'PUT' );
include '../../src/api/header.php';
require_once('../../App/Escalafon/Controllers/DocumentoDesplazamientoController.php');


$arrayReturn = $Api_arrayReturn;

if( !in_array($Header_requestMethod, $Header_allowedMethods) ){
	http_response_code(405);
	$arrayReturn['mensaje'] = 'Método no permitido';
	echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
	exit;
}
$clsDocumentoDesplazamientoController = new DocumentoDesplazamientoController();



$arrayParametrosInput = json_decode(json_encode($_POST));
$archivo = $_FILES['archivo'];


//$parametroImagen = $_FILES['imagen'];
//var_dump($archivo);
//exit();
if(fncGeneralValidarDataArray($arrayParametrosInput)){
	try{
		$dtGuardar = $clsDocumentoDesplazamientoController->fncGuardarSoloDocumentoAlDesplazamiento($arrayParametrosInput,$archivo);

		if( fncGeneralValidarDataArray($dtGuardar[0]) ){
			$arrayReturn['mensaje'] = 'Registro guardado con éxito';
			$arrayReturn['error']   = false;
			$arrayReturn['data']   = $dtGuardar[0];
			http_response_code(200);
		} else {
			$arrayReturn['mensaje'] = 'Error en guardar los datos';
			$arrayReturn['error']   = true;
			$arrayReturn['data']   = $dtGuardar[1];
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
