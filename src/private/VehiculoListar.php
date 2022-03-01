<?php
require_once('../../App/Controllers/VehiculoController.php');
$Header_allowedMethods = ['GET'];
$Header_requestMethod  = strtoupper( $_SERVER['REQUEST_METHOD'] );
if(!in_array($Header_requestMethod, $Header_allowedMethods))
{
	http_response_code(405);
	$arrayReturn["mensaje"] = "Método no permitido";
	echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
	exit;
}
$arrayParametrosInput = json_decode(json_encode($_GET));


//$arrayParametrosInput = json_decode(json_encode($_POST));

$ClsVehiculoController = new VehiculoController();

try{
	$dtListarRegistros = $ClsVehiculoController->fncListarRegistros();
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

http_response_code();
echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);

?>