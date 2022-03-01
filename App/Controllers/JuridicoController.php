<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Models/Juridico.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Business/BusinessJuridico.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Public/funciones.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Controllers/PersonaNaturalController.php');

class JuridicoController extends Juridico
{	
	public function fncListarRegistros($id = -1)
	{
		/*$dtReturn = array();
        $personaNatural = new BusinessPersonaNatural();
		$dtListado = $personaNatural->fncListarRegistrosBD($id);
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
				$model = array();
				$model['nombres'] 	= $listado->nombres;
				$model['apellidos'] = $listado->apellidos;
				$model['telefono'] 	= $listado->telefono;
				$model['apellidos'] = $listado->apellidos;
				$model['dni'] 		= $listado->dni;
				$model['correo'] 	= $listado->correo;
				$model['createdAt'] = $listado->createdAt;
				$model['updatedAt'] = $listado->updatedAt;			
				array_push($dtReturn, $model);
				unset($model);
			}
		}
		return $dtReturn;*/
	}
	public function fncObtenerRegistroRuc($inputs)
	{
		$dtReturn = array();
        $personaJuridica = new BusinessJuridico();
		$dtListado = $personaJuridica->fncObtenerRegistroRucBD($inputs->ruc);
		if( fncGeneralValidarDataArray($dtListado) ){
			
				$model = array();
				$model['idJuridico'] 	= $dtListado->idJuridico;
				$model['contratos'] = $dtListado->contratos;
				$model['razonSocial'] 	= $dtListado->razonSocial;
				$model['ruc'] = $dtListado->ruc;
				$model['correo'] 		= $dtListado->correo;
				$model['idRepresentanteLegal'] 	= $dtListado->idRepresentanteLegal;
				$model['nombreRepresentanteLegal'] 	= $dtListado->nombreRepresentanteLegal;
				$model['createdAt'] = $dtListado->createdAt;
				$model['updatedAt'] = $dtListado->updatedAt;			
				
				$dtReturn = $model;
			
		}
		return $dtReturn;
	}
	public function fncListarRegistros2()
	{
		$dtReturn = array();
        $personaJuridica = new BusinessJuridico();
		$dtListado = $personaJuridica->fncListarRegistros2BD();
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
				$model = array();
				$model['idJuridico'] 	= $listado->idJuridico;
				$model['contratos'] = $listado->contratos;
				$model['razonSocial'] 	= $listado->razonSocial;
				$model['ruc'] = $listado->ruc;
				$model['correo'] 		= $listado->correo;
				$model['idRepresentanteLegal'] 	= $listado->idRepresentanteLegal;
				$model['nombreRepresentanteLegal'] 	= $listado->nombreRepresentanteLegal;
				$model['createdAt'] = $listado->createdAt;
				$model['updatedAt'] = $listado->updatedAt;			
				array_push($dtReturn, $model);
				unset($model);
			}
		}
		return $dtReturn;
	}

	public function fncListarRegistros2ParaCliente()
	{
		$dtReturn = array();
        $personaJuridica = new BusinessJuridico();
		$dtListado = $personaJuridica->fncListarRegistros2ParaClienteBD();
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
				$model = array();
				$model['idJuridico'] 	= $listado->idJuridico;
				$model['contratos'] = $listado->contratos;
				$model['razonSocial'] 	= $listado->razonSocial;
				$model['ruc'] = $listado->ruc;
				$model['correo'] 		= $listado->correo;
				$model['idRepresentanteLegal'] 	= $listado->idRepresentanteLegal;
				$model['nombreRepresentanteLegal'] 	= $listado->nombreRepresentanteLegal;
				$model['createdAt'] = $listado->createdAt;
				$model['updatedAt'] = $listado->updatedAt;			
				array_push($dtReturn, $model);
				unset($model);
			}
		}
		return $dtReturn;
	}
	public function fncGuardar($inputs)
	{
		$juridico = new Juridico();
		$personaNaturalController = new PersonaNaturalController();
		$dataPersonaNatural = $personaNaturalController ->fncGuardar($inputs);
		$idRepresentanteLegal = $dataPersonaNatural->getIdPersona();
		$ruc = $inputs->ruc;
		$businessJuridico = new BusinessJuridico();
		$dataPersonaJuridica= $businessJuridico->fncObtenerRegistroRucBD($ruc);		
		if (!($dataPersonaJuridica)) {
			$juridico->razonSocial =isset($inputs->razonSocial) ? $inputs->razonSocial : null;
			$juridico->correo =isset($inputs->correoJuridico) ? $inputs->correoJuridico : null;
			$juridico->ruc =isset($inputs->ruc) ? $inputs->ruc : null;
			$juridico->idRepresentanteLegal =$idRepresentanteLegal;			
		}else{
			return $dataPersonaJuridica;
		}
		$nuevoJuridico = $businessJuridico->fncGuardarBD($juridico);
		if (!($nuevoJuridico)) {
			return false;
		}
		return $nuevoJuridico;
	}

	public function fncGuardar2($inputs)
	{
		$juridico = new Juridico();
		
		$ruc = $inputs->ruc;
		$businessJuridico = new BusinessJuridico();
		$dataPersonaJuridica= $businessJuridico->fncObtenerRegistroRucBD($ruc);		
		if (!($dataPersonaJuridica)) {
			$juridico->razonSocial =isset($inputs->razonSocial) ? strtoupper($inputs->razonSocial) : null;
			$juridico->correo =isset($inputs->correo) ? $inputs->correo : null;
			$juridico->ruc =isset($inputs->ruc) ? $inputs->ruc : null;
			$juridico->idRepresentanteLegal =isset($inputs->idRepresentanteLegal) ? $inputs->idRepresentanteLegal : null;		
		}else{
			return $dataPersonaJuridica;
		}
		$nuevoJuridico = $businessJuridico->fncGuardarBD($juridico);
		if (!($nuevoJuridico)) {
			return false;
		}
		return $nuevoJuridico;
	}

	public function fncActualizar($inputs)
	{

		$juridico = new Juridico();
		$businessPersonaNatural = new BusinessJuridico();
		$juridico->idJuridico = (int)$inputs->idJuridico;
		$juridico->correo =isset($inputs->correo) ? $inputs->correo : null;
		$juridico->idRepresentanteLegal =isset($inputs->idRepresentanteLegal) ? $inputs->idRepresentanteLegal : null;

		$actualizarPersonaJuridica= $businessPersonaNatural->fncActualizarBD($juridico);
		if (!($actualizarPersonaJuridica)) {
			return false;
		}
		return $actualizarPersonaJuridica;
	}


}
?>