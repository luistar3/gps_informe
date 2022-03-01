<?php

$Header_allowedMethods = ['POST', 'PUT'];

include '../../src/api/header.php';
require_once("../../App/Escalafon/Controllers/RemuneracionPersonalController.php");

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
$remuneracionController = new RemuneracionPersonalController;

// Parametros de la solicitud
$input = json_decode(file_get_contents("php://input"));

if (
	(
		$Header_requestMethod == 'POST' &&
		!isset(
			$input->id_trabajador,
			$input->id_tipo_accion,
			$input->id_tipo_documento
		)
	) ||
	(
		$Header_requestMethod == 'PUT' &&
		!isset(
			$input->id_remuneracion_personal,
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

try
{
	if ($Header_requestMethod == 'POST')
	{
		$remuneracion = $remuneracionController->fncGuardar($input);

		if($remuneracion)
		{
			http_response_code(201);
			$arrayReturn["mensaje"]	= "Datos guardados con éxito";
			$arrayReturn["error"]	= false;
			$arrayReturn["data"]	= $remuneracion;
		}
		else
		{
			http_response_code(500);
			$arrayReturn["mensaje"]	= "Error al guardar los datos";
			$arrayReturn["error"]	= true;
		}
	}
	else if ($Header_requestMethod == 'PUT')
	{
		$remuneracion = $remuneracionController->fncActualizar($input);

		if($remuneracion)
		{
			http_response_code(200);
			$arrayReturn["mensaje"] = "Datos actualizados con éxito";
			$arrayReturn["error"]	= false;
			$arrayReturn["data"]	= $remuneracion;
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