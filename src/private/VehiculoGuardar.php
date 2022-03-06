<?php
require_once('../../App/Controllers/VehiculoController.php');
$Header_allowedMethods = ['POST'];
$Header_requestMethod  = strtoupper( $_SERVER['REQUEST_METHOD'] );
if(!in_array($Header_requestMethod, $Header_allowedMethods))
{
	http_response_code(405);
	$arrayReturn["mensaje"] = "Método no permitido";
	echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
	exit;
}
// Controllers
$ClsVehiculoController = new VehiculoController;

// Parametros de la solicitud
$input = json_decode(json_encode($_POST));

// // Archivos de la solicitud
//$files = json_decode(json_encode($_FILES));
//$archivo = $_FILES["archivo"];

if (
	(
		!isset(
			$input->placa
		)
	) 
)
{
	http_response_code(400);
	$arrayReturn["mensaje"]	= "Error en envío de datos";
	$arrayReturn["error"]	= true;

	echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
	exit;
}
if (
	(
		isset(
			$input->contrasena
		)
	) 
)
{
	if(strlen($input->contrasena) < 8){
		http_response_code(400);
		$arrayReturn["mensaje"]	= "Error en envío de datos password length";
		$arrayReturn["error"]	= true;
	
		echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
		exit;
	}
	
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
try
{
	if (!isset($input->idVehiculo))
	{
		$vehiculo = $ClsVehiculoController->fncGuardar($input);

		if($vehiculo)
		{
			http_response_code(201);
			$arrayReturn["mensaje"]	= "Datos guardados con éxito";
			$arrayReturn["error"]	= false;
			$arrayReturn["data"]	= $vehiculo;
		}
		else
		{
			http_response_code(500);
			$arrayReturn["mensaje"]	= "Error al guardar los datos";
			$arrayReturn["error"]	= true;
		}
	}
	else if (isset($input->idVehiculo))
	{
		$vehiculo = $ClsVehiculoController->fncActualizarBD($input);

		if($vehiculo)
		{
			http_response_code(200);
			$arrayReturn["mensaje"] = "Datos actualizados con éxito";
			$arrayReturn["error"]	= false;
			$arrayReturn["data"]	= $vehiculo;
		}
		else
		{
			http_response_code(422);
			$arrayReturn["mensaje"] = "No existe registro";
			$arrayReturn["error"]	= true;
		}
	}
}
catch (\throwable  $e)
{
	http_response_code(500);
	$arrayReturn["mensaje"]	= $e->getMessage();
	$arrayReturn["error"]	= true;
}

echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);