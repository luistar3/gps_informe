<?php

$Header_allowedMethods = ['POST', 'PUT'];

include '../../src/api/header.php';
require_once("../../App/Escalafon/Controllers/SubsidioController.php");

// Array que llega desde api.php
$arrayReturn = $Api_arrayReturn;

if(!in_array($Header_requestMethod, $Header_allowedMethods))
{
	http_response_code(405);
	$arrayReturn["mensaje"] = "Método no permitido";

	echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
	exit;
}

// Controllers
$subsidioController = new SubsidioController;

// Parametros de la solicitud
$input = json_decode(json_encode($_POST));

// // Archivos de la solicitud
$files = json_decode(json_encode($_FILES));

if (
	(
		!isset(
			$input->id_trabajador,
			$input->id_tipo_accion,
			$input->id_tipo_documento
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

if(isset($files->archivo) && fncValidarArchivoPDF($files->archivo->name) == 0)
{
	$arrayReturn['mensaje'] = 'El archivo tiene una extension no permitida';
	$arrayReturn['error']   = true;
	http_response_code(400);

	echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
	exit;
}

if(isset($files->archivo) && fncValidarMalicioso($files->archivo->name) == 1)
{
	http_response_code(400);
	$arrayReturn['mensaje'] = 'El archivo tiene una extension no permitida';
	$arrayReturn['error']   = true;

	echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
	exit;
}

try
{
	if (!isset($input->id_subsidio))
	{
		$subsidio = $subsidioController->fncGuardar($input, $files);

		if($subsidio)
		{
			http_response_code(201);
			$arrayReturn["mensaje"]	= "Datos guardados con éxito";
			$arrayReturn["error"]	= false;
			$arrayReturn["data"]	= $subsidio;
		}
		else
		{
			http_response_code(500);
			$arrayReturn["mensaje"]	= "Error al guardar los datos";
			$arrayReturn["error"]	= true;
		}
	}
	else if (isset($input->id_subsidio) && !empty($input->id_subsidio))
	{
		$subsidio = $subsidioController->fncActualizar($input, $files);

		if($subsidio)
		{
			http_response_code(200);
			$arrayReturn["mensaje"] = "Datos actualizados con éxito";
			$arrayReturn["error"]	= false;
			$arrayReturn["data"]	= $subsidio;
		}
		else
		{
			http_response_code(422);
			$arrayReturn["mensaje"] = "No existe registro";
			$arrayReturn["error"]	= true;
		}
	}
}
catch (Exception $e)
{
	http_response_code(500);
	$arrayReturn["mensaje"]	= $e->getMessage();
	$arrayReturn["error"]	= true;
}

echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);