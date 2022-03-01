<?php
$Header_allowedMethods = array( 'POST');
include '../../src/api/header.php';
require_once('../../App/Escalafon/Controllers/ReportesController.php');

$arrayReturn = $Api_arrayReturn;

if( !in_array($Header_requestMethod, $Header_allowedMethods) ){
	http_response_code(405);
	$arrayReturn['mensaje'] = 'Método no permitido';
	echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
	exit;
}
$clsReporte = new ReportesController();

//$arrayParametrosInput = json_decode(file_get_contents('php://input'));
$arrayParametrosInput = json_decode(json_encode($_POST));

try{
    $dtReporte = $clsReporte->fncListarPersonal($arrayParametrosInput);

    if( fncGeneralValidarDataArray($dtReporte) ){
        $arrayReturn['mensaje'] = 'Reporte generado con éxito';
        $arrayReturn['error']   = false;
        $arrayReturn['data']   = $dtReporte;
        http_response_code(200);
    } else {
        $arrayReturn['mensaje'] = 'Error en reportar los datos';
        $arrayReturn['error']   = true;
        http_response_code(500);
    }
} catch ( Exception $e ){
    $arrayReturn['mensaje'] = $e->getMessage();
    $arrayReturn['error']   = true;
    http_response_code(400);
}

echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
	
?>