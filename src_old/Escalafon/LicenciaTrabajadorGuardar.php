<?php
$Header_allowedMethods = array( 'POST', 'PUT' );
include '../../src/api/header.php';
require_once('../../App/Escalafon/Controllers/LicenciaTrabajadorController.php');


$arrayReturn = $Api_arrayReturn;

if( !in_array($Header_requestMethod, $Header_allowedMethods) ){
	http_response_code(405);
	$arrayReturn['mensaje'] = 'Método no permitido';
	echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
	exit;
}
$clsLicenciaTrabajadorController = new LicenciaTrabajadorController();


$arrayParametrosInput = json_decode(json_encode($_POST));
$parametroArchivo = $_FILES['archivo'];
if(fncGeneralValidarDataArray($arrayParametrosInput)){
	$archivoPermitido = "si";
	if(!empty($parametroArchivo["name"])){
		if(fncValidarArchivoPDF($parametroArchivo["name"])==0){ $archivoPermitido="no"; }
	}
	if($archivoPermitido=="si"){
		if(fncValidarMalicioso($parametroArchivo["name"])==0){
			try{
				$dtGuardar = $clsLicenciaTrabajadorController->fncGuardar($arrayParametrosInput,$parametroArchivo);

				if( fncGeneralValidarDataArray($dtGuardar) ){
					$arrayReturn['mensaje'] = 'Registro guardado con éxito';
					$arrayReturn['error']   = false;
					$arrayReturn['data']   = $dtGuardar;
					http_response_code(200);
				} else {
					$arrayReturn['mensaje'] = 'Error en guardar los datos';
					$arrayReturn['error']   = true;
					http_response_code(500);
				}
			} catch ( Exception $e ){
				$arrayReturn['mensaje'] = $e->getMessage();
				$arrayReturn['error']   = true;
				http_response_code(400);
			}
		}else{
			$arrayReturn['mensaje'] = 'El archivo esta infectado';
			$arrayReturn['error']   = true;
			http_response_code(400);
		}
	}else{
		$arrayReturn['mensaje'] = 'El archivo tiene una extension no permitida';
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