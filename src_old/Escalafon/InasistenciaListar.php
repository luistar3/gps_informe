<?php

$Header_allowedMethods = ['GET'];

include '../../src/api/header.php';
require_once("../../App/Escalafon/Controllers/InasistenciaController.php");

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
$inasistenciaController = new InasistenciaController;

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
	if ($Api_id_get_first != -1 && $Api_id_get_second == -1)
	{
		$inasistencias = $inasistenciaController->fncListar($Api_id_get_first);

		if(fncGeneralValidarDataArray($inasistencias))
		{
			$arrayReturn["mensaje"] = "Registros listados con éxito";
		}
		else
		{
			$arrayReturn["mensaje"] = "No existen registros";
		}

		http_response_code(200);
		$arrayReturn["error"]	= false;
		$arrayReturn["data"]	= $inasistencias;

	}
	else if ($Api_id_get_first != -1 && $Api_id_get_second != -1)
	{
		$inasistencia = $inasistenciaController->fncObtener($Api_id_get_first, $Api_id_get_second);

		if($inasistencia)
		{
			http_response_code(200);
			$arrayReturn["mensaje"] = "Registro listado con éxito";
			$arrayReturn["error"]	= false;
			$arrayReturn["data"]	= $inasistencia;
		}
		else
		{
			http_response_code(422);
			$arrayReturn["mensaje"] = "No existe el registro";
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
