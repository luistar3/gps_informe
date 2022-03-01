<?php
require_once('../../App/Controllers/PersonaNaturalController.php');
$Header_allowedMethods = ['POST'];
$Header_requestMethod  = strtoupper($_SERVER['REQUEST_METHOD']);
if (!in_array($Header_requestMethod, $Header_allowedMethods)) {
	http_response_code(405);
	$arrayReturn["mensaje"] = "Método no permitido";
	echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
	exit;
}
// Controllers
$ClsPersonaNaturalController = new PersonaNaturalController;

// Parametros de la solicitud
$input = json_decode(json_encode($_POST));

// // Archivos de la solicitud
//$files = json_decode(json_encode($_FILES));
//$archivo = $_FILES["archivo"];

if (
	(!isset(
			$input->dni
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
	$dniExitente = $ClsPersonaNaturalController->fncObtenerRegistroDni($input);
	if (!empty($dniExitente) && !isset($input->idPersona)) {
		http_response_code(422);
		$arrayReturn["mensaje"] = "Dni ya registrado en el Sistema";
		$arrayReturn["error"]	= true;
		echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
		exit;
	}
	if (!isset($input->idPersona)) {
		$persona = $ClsPersonaNaturalController->fncGuardar($input);

		if ($persona) {
			http_response_code(201);
			$arrayReturn["mensaje"]	= "Datos guardados con éxito";
			$arrayReturn["error"]	= false;
			$arrayReturn["data"]	= $persona;
		} else {
			http_response_code(500);
			$arrayReturn["mensaje"]	= "Error al guardar los datos";
			$arrayReturn["error"]	= true;
		}
	} else if (isset($input->idPersona)) {
		$persona = $ClsPersonaNaturalController->fncActualizar($input);

		if ($persona) {
			http_response_code(200);
			$arrayReturn["mensaje"] = "Datos actualizados con éxito";
			$arrayReturn["error"]	= false;
			$arrayReturn["data"]	= $persona;
		} else {
			http_response_code(422);
			$arrayReturn["mensaje"] = "No existe registro";
			$arrayReturn["error"]	= true;
		}
	}
} catch (\throwable  $e) {
	http_response_code(500);
	$arrayReturn["mensaje"]	= $e->getMessage();
	$arrayReturn["error"]	= true;
}

echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
