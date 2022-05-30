<?php
require_once('../../App/Public/comprobarSession.php');
require_once('../../App/Controllers/ModuloRolController.php');
$Header_allowedMethods = ['POST'];
$Header_requestMethod  = strtoupper($_SERVER['REQUEST_METHOD']);
if (!in_array($Header_requestMethod, $Header_allowedMethods)) {
	http_response_code(405);
	$arrayReturn["mensaje"] = "Método no permitido";
	echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
	exit;
}
// Controllers
$ClsModuloRolController = new ModuloRolController;

// Parametros de la solicitud
$input = json_decode(json_encode($_POST));

// // Archivos de la solicitud
//$files = json_decode(json_encode($_FILES));
//$archivo = $_FILES["archivo"];

if (
	(!isset(
		$input->idRol
	)
	)
) {
	http_response_code(400);
	$arrayReturn["mensaje"]	= "Error en envío de datos";
	$arrayReturn["error"]	= true;

	echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
	exit;
}

// if(isset($files->archivo) && fncValidarArchivo($files->archivo->name) == 0)
// {
// 	$arrayReturn['mensaje'] = 'El archivo tiene una extension no permitida';
// 	$arrayReturn['error']   = true;
// 	http_response_code(400);

// 	echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
// 	exit;
// }

http_response_code(500);



try {
	$dtListarRegistros = $ClsModuloRolController->fncModificarModuloRol($input);
	if ($dtListarRegistros) {
		$arrayReturn['mensaje'] = 'Registros listados con éxito';
		$arrayReturn['data'] = $dtListarRegistros;
		$arrayReturn['error']   = false;
		http_response_code(200);
	} else {
		$arrayReturn['mensaje'] = $e->getMessage();
		$arrayReturn['error']   = true;
		http_response_code(400);
	}
} catch (Exception $e) {
	$arrayReturn['mensaje'] = $e->getMessage();
	$arrayReturn['error']   = true;
	http_response_code(400);
}

http_response_code();
echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
