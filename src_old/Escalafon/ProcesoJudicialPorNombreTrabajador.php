<?php
$Header_allowedMethods = array( 'GET' );
include '../../src/api/header.php';
require_once("../../App/Escalafon/Controllers/ProcesoJudicialController.php");

$arrayReturn = $Api_arrayReturn;

if( !in_array($Header_requestMethod, $Header_allowedMethods) ){
	http_response_code(405);
	$arrayReturn['mensaje'] = 'Método no permitido';
	echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
	exit;
}
$clsProcesoJudicialController = new ProcesoJudicialController;

try
{
    $dtListarRegistros = $clsProcesoJudicialController->fncObtenerRegistroPorNombreTrabajador($Api_id_get_first);

    if(fncGeneralValidarDataArray($dtListarRegistros)){
        $arrayReturn['mensaje'] = 'Registros obtenidos con éxito';
        $arrayReturn['error']   = false;
        http_response_code(200);
    } else {
        $arrayReturn['mensaje'] = 'No existen registro';
    }
    $arrayReturn['error']   = false;
    $arrayReturn['data']    = $dtListarRegistros;
    http_response_code(200);
}
catch (Exception $e)
{
    http_response_code(500);
    $arrayReturn["mensaje"]	= $e->getMessage();
    $arrayReturn["error"]	= true;
}

echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
