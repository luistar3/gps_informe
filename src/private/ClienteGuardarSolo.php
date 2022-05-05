<?php
require_once('../../App/Public/comprobarSession.php');
require_once('../../App/Controllers/ClienteController.php');
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
$clienteController = new ClienteController;

// Parametros de la solicitud
$input = json_decode(json_encode($_POST));

// // Archivos de la solicitud
//$files = json_decode(json_encode($_FILES));

if (
	(
		!isset(
			$input->tipoPersona
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

// if(isset($files->archivo) && fncValidarArchivoPDF($files->archivo->name) == 0)
// {
// 	$arrayReturn['mensaje'] = 'El archivo tiene una extension no permitida';
// 	$arrayReturn['error']   = true;
// 	http_response_code(400);

// 	echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
// 	exit;
// }


try
{	if (!isset($input->idCliente))
	{
		$cliente = $clienteController->fncObtenerPorTipoPersona($input);
		if($cliente)
		{
			http_response_code(202);
			$arrayReturn["mensaje"]	= "Cliente ya existe en el sistema";
			$arrayReturn["error"]	= false;
			$arrayReturn["data"]	= $cliente;
			echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
			exit;
		}
		
	}
	if (!isset($input->idCliente))
	{
		$cliente = $clienteController->fncGuardarSolo($input);

		if($cliente)
		{
			http_response_code(201);
			$arrayReturn["mensaje"]	= "Datos guardados con éxito";
			$arrayReturn["error"]	= false;
			$arrayReturn["data"]	= $cliente;
		}
		else
		{
			http_response_code(500);
			$arrayReturn["mensaje"]	= "Error al guardar los datos";
			$arrayReturn["error"]	= true;
		}
	}
	else if (isset($input->idCliente) && !empty($input->idCliente))
	{
		$cliente = $clienteController->fncActualizar($input);

		if($cliente)
		{
			http_response_code(200);
			$arrayReturn["mensaje"] = "Datos actualizados con éxito";
			$arrayReturn["error"]	= false;
			$arrayReturn["data"]	= $cliente;
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