<?php
require_once('../../App/Public/comprobarSession.php');
require_once('../../App/Controllers/ContratoVehiculoController.php');
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
$clsContratoVehiculoController = new ContratoVehiculoController;

// Parametros de la solicitud
$input = json_decode(json_encode($_POST));
//$input = json_decode(file_get_contents('php://input')); 


if (
	(
		!isset(
			$input->idContratoVehiculo
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
	if ((Int)$input->idContratoVehiculo!=0)
	{
		$contratoVehiculo = $clsContratoVehiculoController->fncEliminar($input);

		if($contratoVehiculo)
		{
			http_response_code(200);
			$arrayReturn["mensaje"] = "Dato Eliminado con éxito";
			$arrayReturn["error"]	= false;
			$arrayReturn["data"]	= $contratoVehiculo;
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