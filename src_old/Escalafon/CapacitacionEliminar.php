<?php

$Header_allowedMethods = ['DELETE'];

include '../../src/api/header.php';
require_once("../../App/Escalafon/Controllers/CapacitacionController.php");

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
$capacitacionController = new CapacitacionController;

if ($Api_id_get_first == -1)
{
	http_response_code(400);
	$arrayReturn["mensaje"]	= "Error en envío de datos";
	$arrayReturn["error"]	= true;

	echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
	exit;
}

try
{
	if ($eliminado = $capacitacionController->fncEliminarRegistro($Api_id_get_first))
	{
		http_response_code(200);
		$arrayReturn["mensaje"]	= "Registro eliminado con éxito";
		$arrayReturn["error"]	= false;
	}
	else
	{
		http_response_code(500);
		$arrayReturn['mensaje']	= 'Error al eliminar el registro';
		$arrayReturn['error']	= true;
	}
}
catch (Exception $e)
{
	http_response_code(500);
	$arrayReturn["mensaje"]	= $e->getMessage();
	$arrayReturn["error"]	= true;
}

echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);