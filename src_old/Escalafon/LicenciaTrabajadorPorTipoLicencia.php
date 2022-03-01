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
$clsLicenciaTrabajador = new LicenciaTrabajadorController();


$arrayParametrosInput = json_decode(json_encode($_POST));

try{
    $dtListar = $clsLicenciaTrabajador->fncListarLicenciasPorTrabajadorTipoLicencia($arrayParametrosInput);

    if( fncGeneralValidarDataArray($dtListar) ){
        $arrayReturn['mensaje'] = 'Registros Listados con éxito';
        $arrayReturn['error']   = false;
        $arrayReturn['data']   = $dtListar;
        http_response_code(200);
    } else {
        $arrayReturn['mensaje'] = 'Error en Listar los datos';
        $arrayReturn['error']   = true;
        $arrayReturn['data']   = $dtListar;
        http_response_code(500);
    }
    
} catch ( Exception $e ){
    $arrayReturn['mensaje'] = $e->getMessage();
    $arrayReturn['error']   = true; 
    http_response_code(400);
}

echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
?>