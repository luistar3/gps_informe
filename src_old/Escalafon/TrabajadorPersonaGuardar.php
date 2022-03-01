<?php
//error_reporting(0);
$Header_allowedMethods = array( 'POST', 'PUT' );
include '../../src/api/header.php';
require_once('../../App/Escalafon/Controllers/TrabajadorController.php');
require_once('../../App/General/Controllers/PersonaController.php');

$arrayReturn = $Api_arrayReturn;

if( !in_array($Header_requestMethod, $Header_allowedMethods) ){
	http_response_code(405);
	$arrayReturn['mensaje'] = 'Método no permitido';
	echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
	exit;
}
$clsTrabajador = new TrabajadorController();
$clsPersona = new PersonaController();

$arrayParametrosInput = json_decode(file_get_contents('php://input'));
$parametroImagen = $_FILES['imagen'];
if(fncGeneralValidarDataArray($arrayParametrosInput)){
	$imagenPermitida = "si";
	if(!empty($parametroImagen["name"])){
		if(fncValidarImagen($parametroImagen["name"])==0){ $imagenPermitida="no"; }
	}
	if($imagenPermitida=="si"){
		if(fncValidarMalicioso($parametroImagen["name"])==0){
			try{
				$arrayParametrosInput->tipo='N';
				$evaluarGuardarTrabajafor = 0;
				
				$evaluarEditar = 1; //1 guardar  y 2 editar
				$dtGuardar = array();
				$dtGuardarTrabajador = array();
				$dtMensaje = array();
				//$dtGuardar = $clsPersona->fncGuardar($arrayParametrosInput,$parametroImagen);
				//$dtGuardarTrabajador = $clsTrabajador->fncGuardar($arrayParametrosInput,$dtGuardar[0]);

				if ($arrayParametrosInput->idTrabajador!= 0) {$evaluarEditar = 2;}else{$evaluarEditar = 1;}

				if ($evaluarEditar==1) {  //agregar datos de nuevo persona y trabajador
					$dataEvaluar = $clsTrabajador->fncValidarDatosGuardar($arrayParametrosInput);
					
					$guardaraTrabajador = 1;
					for ($i=0; $i < count($dataEvaluar); $i++) { 
						if($dataEvaluar[$i]['existe']==1){$guardaraTrabajador=0;}
					
					}
					
					if($dataEvaluar[0]['existe']==1){
						$model=array();
						$model['documentoIdentidad'] = 'El documento de identidad ya existe';
						array_push($dtMensaje , $model);
						//$unset($model);
					}
					if($dataEvaluar[1]['existe']==1){
						$model=array();
						$model['correElectronico'] = 'El correo ya existe';
						array_push($dtMensaje , $model);
						//$unset($model);
					}
					if($dataEvaluar[2]['existe']==1){
						$model=array();
						$model['nroBrevete'] = 'El nro de brevete ya existe';
						array_push($dtMensaje , $model);
						//$unset($model);
					}

					if ($guardaraTrabajador==1) {
						$dtGuardar = $clsPersona->fncGuardar($arrayParametrosInput,$parametroImagen);
					
						if( fncGeneralValidarDataArray($dtGuardar) ){
							$dtGuardarTrabajador = $clsTrabajador->fncGuardar($arrayParametrosInput,$dtGuardar[0]);
							if( fncGeneralValidarDataArray($dtGuardarTrabajador[0]) ){
								$arrayReturn['mensaje'] = 'Registro guardado con éxito';
								$arrayReturn['error']   = false;
								$arrayReturn['data']   = $dtGuardarTrabajador[0];
								http_response_code(200);
							}else {
								$arrayReturn['mensaje'] = 'Error en guardar los datos';
								$arrayReturn['error']   = true;
								$arrayReturn['data']   = $dtGuardarTrabajador[1];
								http_response_code(500);
							}
						}else{
							$arrayReturn['mensaje'] = 'Error en guardar los datos';
							$arrayReturn['error']   = true;
							$arrayReturn['data']   = $dtMensaje;
							http_response_code(500);
						}
					} else {
							$arrayReturn['mensaje'] = 'Error en guardar los datos';
							$arrayReturn['error']   = true;
							$arrayReturn['data']   = $dtMensaje;
							http_response_code(500);
					}

					
				}else{ //modificar data
					$dataEvaluar = $clsTrabajador->fncValidarDatosGuardar($arrayParametrosInput);
					if($dataEvaluar[0]['existe']==1){
						$model=array();
						$model['documentoIdentidad'] = 'El documento de identidad ya existe';
						array_push($dtMensaje , $model);
						//$unset($model);
					}
					if($dataEvaluar[1]['existe']==1){
						$model=array();
						$model['correElectronico'] = 'El correo ya existe';
						array_push($dtMensaje , $model);
						//$unset($model);
					}
					if($dataEvaluar[2]['existe']==1){
						$model=array();
						$model['nroBrevete'] = 'El nro de brevete ya existe';
						array_push($dtMensaje , $model);
						//$unset($model);
					}
					$modificarTrabajador = 1;
					for ($i=0; $i < count($dataEvaluar); $i++) { 
						if($dataEvaluar[$i]['existe']==1){$modificarTrabajador=0;}
					}
					if ($modificarTrabajador==1) {
						$arrayParametrosInput->idPersona=$arrayParametrosInput->idTrabajador;
						$dtGuardar = $clsPersona->fncGuardar($arrayParametrosInput,$parametroImagen);
						if( fncGeneralValidarDataArray($dtGuardar) ){
							$dtGuardarTrabajador = $clsTrabajador->fncGuardar($arrayParametrosInput,$dtGuardar[0]);
							if( fncGeneralValidarDataArray($dtGuardarTrabajador[0]) ){
								$arrayReturn['mensaje'] = 'Registro modificado con éxito';
								$arrayReturn['error']   = false;
								$arrayReturn['data']   = $dtGuardarTrabajador[0];
								http_response_code(200);
							}else {
								$arrayReturn['mensaje'] = 'Error en modificar los datos';
								$arrayReturn['error']   = true;
								$arrayReturn['data']   = $dtGuardarTrabajador[1];
								http_response_code(400);
							}
						}else{
							$arrayReturn['mensaje'] = 'Error en modificar los datos';
							$arrayReturn['error']   = true;
							$arrayReturn['data']   = $dtGuardarTrabajador[1];
							http_response_code(400);
						}

					} else {
						$arrayReturn['mensaje'] = 'Error en modificar los datos';
						$arrayReturn['error']   = true;
						$arrayReturn['data']   = $dtMensaje;
						http_response_code(400);
					}

					

				}



			} catch ( Exception $e ){
				$arrayReturn['mensaje'] = $e->getMessage();
				$arrayReturn['error']   = true;
				http_response_code(400);
			}
		}else{
			$arrayReturn['mensaje'] = 'El archivo esta infectado';
			$arrayReturn['error']   = true;
			http_response_code(400);
		}
	}else{
		$arrayReturn['mensaje'] = 'La foto tiene una extension no permitida';
		$arrayReturn['error']   = true;
		http_response_code(400);
	}
} else {
	$arrayReturn['mensaje'] = 'Error en envio de datos';
	$arrayReturn['error']   = true;
	http_response_code(400);
}

$asd = http_response_code();
echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
	
?>