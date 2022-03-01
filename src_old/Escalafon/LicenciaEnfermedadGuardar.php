<?php

$Header_allowedMethods = ['POST', 'PUT'];

include '../../src/api/header.php';
require_once("../../App/Escalafon/Controllers/LicenciaEnfermedadController.php");

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
$licenciaEnfermedadController = new LicenciaEnfermedadController;

// Parametros de la solicitud
$arrayParametrosInput = json_decode(json_encode($_POST));
$parametroArchivo = $_FILES['archivo'];


if (!isset($arrayParametrosInput->idTrabajador)) // datos importante para el proceso de datos
{
	http_response_code(400);
	$arrayReturn["mensaje"]	= "Error en envío de datos";
	$arrayReturn["error"]	= true;

	echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
	exit;
}

try
{
	$archivoPermitido = "si";
	if(!empty($parametroArchivo["name"])){
		if(fncValidarArchivoPDF($parametroArchivo["name"])==0){ $archivoPermitido="no"; }
	}
	if($archivoPermitido=="si"){

		$idLicenciaEnfermedad = (Int)$arrayParametrosInput->idLicenciaEnfermedad;

		if ((Int)$arrayParametrosInput->idLicenciaEnfermedad == 0)
		{

			$licenciaEnfermedad = $licenciaEnfermedadController->fncGuardar($arrayParametrosInput,$parametroArchivo);

			if($licenciaEnfermedad)
			{
				http_response_code(201);
				$arrayReturn["mensaje"]	= "Datos guardados con éxito";
				$arrayReturn["error"]	= false;
				$arrayReturn["data"]	= $licenciaEnfermedad;
			}
			else
			{
				http_response_code(500);
				$arrayReturn["mensaje"]	= "Error al guardar los datos";
				$arrayReturn["error"]	= true;
			}

			
		}
		else if ((Int)$arrayParametrosInput->idLicenciaEnfermedad != 0)
		{
			$licenciaEnfermedad = $licenciaEnfermedadController->fncGuardar($arrayParametrosInput,$parametroArchivo);

			if($licenciaEnfermedad)
			{
				http_response_code(200);
				$arrayReturn["mensaje"] = "Datos actualizados con éxito";
				$arrayReturn["error"]	= false;
				$arrayReturn["data"]	= $licenciaEnfermedad;
			}
			else
			{
				http_response_code(422);
				$arrayReturn["mensaje"] = "No existe el registro";
				$arrayReturn["error"]	= true;
			}
		}

		else{
			$arrayReturn['mensaje'] = 'El archivo tiene una extension no permitida';
			$arrayReturn['error']   = true;
			http_response_code(400);
		}
	}else{
		$arrayReturn['mensaje'] = 'El archivo tiene una extension no permitida';
		$arrayReturn['error']   = true;
		http_response_code(400);
	}
	

}
catch (Exception $e)
{
	http_response_code(500);
	$arrayReturn["mensaje"]	= $e->getMessage();
	$arrayReturn["error"]	= true;
}

echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);