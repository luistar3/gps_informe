<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/gps/App/Models/PersonaNatural.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/gps/App/Business/BusinessPersonaNatural.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/gps/App/Public/funciones.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/gps/App/Controllers/ModuloRolController.php');

class PersonaNaturalController extends PersonaNatural
{

	public function fncNaturalJuridicaView()
	{

		$idUsuarioSet = 1;
		$clsModuloRolController = new ModuloRolController();
		$menuModulosPermisos =  $clsModuloRolController->fncListarRegistrosPermisosMenu($idUsuarioSet);
		$moduloActual = 'PERSONA';
		$menuActivo		= 'PERSONANATURALJURIDICA';

		include('../../../../resources/views/includes/appHead.php');
		include('../../../../resources/views/content/persona/naturalJuridicaIndex.php');
		include('../../../../resources/views/includes/appFooter.php');
		echo ('<script type="text/javascript" src="../../../../resources/js/persona/scriptNaturalJuridica.js"></script>');
	}

	public function fncListarRegistros($id = -1)
	{
		$dtReturn = array();
		$personaNatural = new BusinessPersonaNatural();
		$dtListado = $personaNatural->fncListarRegistrosBD($id);
		if (fncGeneralValidarDataArray($dtListado)) {
			foreach ($dtListado as $listado) {
				$model = array();
				$model['idPersona'] = $listado->idPersona;
				$model['nombres'] 	= strtoupper($listado->nombres);
				$model['apellidos'] = $listado->apellidos;
				$model['telefono'] 	= $listado->telefono;
				$model['apellidos'] = strtoupper($listado->apellidos);
				$model['direccion'] = $listado->direccion;
				$model['dni'] 		= $listado->dni;
				$model['correo'] 	= $listado->correo;
				$model['createdAt'] = $listado->createdAt;
				$model['updatedAt'] = $listado->updatedAt;
				array_push($dtReturn, $model);
				unset($model);
			}
		}
		return $dtReturn;
	}
	public function fncListarRegistrosParaCliente()
	{
		$dtReturn = array();
		$personaNatural = new BusinessPersonaNatural();
		$dtListado = $personaNatural->fncListarRegistrosParaClienteBD();
		if (fncGeneralValidarDataArray($dtListado)) {
			foreach ($dtListado as $listado) {
				$model = array();
				$model['idPersona'] = $listado->idPersona;
				$model['nombres'] 	= strtoupper($listado->nombres);
				$model['apellidos'] = $listado->apellidos;
				$model['telefono'] 	= $listado->telefono;
				$model['apellidos'] = strtoupper($listado->apellidos);
				$model['direccion'] = $listado->direccion;
				$model['dni'] 		= $listado->dni;
				$model['correo'] 	= $listado->correo;
				$model['createdAt'] = $listado->createdAt;
				$model['updatedAt'] = $listado->updatedAt;
				array_push($dtReturn, $model);
				unset($model);
			}
		}
		return $dtReturn;
	}


	public function fncObtenerRegistroDni($inputs)
	{
		$dtReturn = array();
		$personaNatural = new BusinessPersonaNatural();
		$dni = $inputs->dni;
		$dtListado = $personaNatural->fncObtenerRegistroDniBD(str_replace(' ', '', $dni));
		if (fncGeneralValidarDataArray($dtListado)) {

			$model = array();
			$dtReturn['idPersona'] = $dtListado->idPersona;
			$dtReturn['nombres'] 	= $dtListado->nombres;
			$dtReturn['apellidos'] = $dtListado->apellidos;
			$dtReturn['telefono'] 	= $dtListado->telefono;
			$dtReturn['direccion'] = $dtListado->direccion;
			$dtReturn['dni'] 		= $dtListado->dni;
			$dtReturn['correo'] 	= $dtListado->correo;
			$dtReturn['createdAt'] = $dtListado->createdAt;
			$dtReturn['updatedAt'] = $dtListado->updatedAt;
		}
		return $dtReturn;
	}

	public function fncGuardar($inputs)
	{

		$personaNatural = new PersonaNatural();
		$businessPersonaNatural = new BusinessPersonaNatural();
		$dataPersonaNatural = 	$businessPersonaNatural->fncObtenerRegistroDniBD($inputs->dni);
		if (!($dataPersonaNatural)) {
			$personaNatural->dni = isset($inputs->dni) ? $inputs->dni : null;
			$personaNatural->nombres = strtoupper(isset($inputs->nombres) ? $inputs->nombres : null);
			$personaNatural->apellidos = strtoupper(isset($inputs->apellidos) ? $inputs->apellidos : null);
			$personaNatural->correo = strtoupper(isset($inputs->correo) ? $inputs->correo : null);
			$personaNatural->telefono = isset($inputs->telefono) ? $inputs->telefono : null;
			$personaNatural->direccion = strtoupper(isset($inputs->direccion) ? $inputs->direccion : null);
		} else {
			return $dataPersonaNatural;
		}
		$nuevaPerosnaNatural = $businessPersonaNatural->fncGuardarBD($personaNatural);
		if (!($nuevaPerosnaNatural)) {
			return false;
		}
		return $nuevaPerosnaNatural;
	}

	public function fncActualizar($inputs)
	{

		$personaNatural = new PersonaNatural();
		$businessPersonaNatural = new BusinessPersonaNatural();
		$personaNatural->idPersona = (int)$inputs->idPersona;
		$personaNatural->dni = isset($inputs->dni) ? $inputs->dni : null;
		$personaNatural->nombres = strtoupper(isset($inputs->nombres) ? $inputs->nombres : null);
		$personaNatural->apellidos = strtoupper(isset($inputs->apellidos) ? $inputs->apellidos : null);
		$personaNatural->correo = strtoupper(isset($inputs->correo) ? $inputs->correo : null);
		$personaNatural->telefono = isset($inputs->telefono) ? $inputs->telefono : null;
		$personaNatural->direccion = strtoupper(isset($inputs->direccion) ? $inputs->direccion : null);

		$nuevaPerosnaNatural = $businessPersonaNatural->fncActualizarBD($personaNatural);
		if (!($nuevaPerosnaNatural)) {
			return false;
		}
		return $nuevaPerosnaNatural;
	}
}
