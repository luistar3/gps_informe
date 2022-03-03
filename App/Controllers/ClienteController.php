<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/gps/App/Models/Cliente.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/gps/App/Business/BusinessCliente.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/gps/App/Controllers/JuridicoController.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/gps/App/Public/funciones.php');

class ClienteController extends Cliente
{
	public function fncListarRegistros()
	{
		$dtReturn = array();
        $cliente = new BusinessCliente();
		$dtListado = $cliente->fncListarRegistros2BD();
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
				$model = array();
				$model['documentoCliente'] 	= $listado->documentoCliente;
				$model['nombreCliente'] = strtoupper($listado->nombreCliente);
				$model['tipoCliente'] 	= $listado->tipoCliente;
				$model['idCliente'] = $listado->idCliente;
				$model['idPersona'] 		= $listado->idPersona;
				$model['idJuridico'] 	= $listado->idJuridico;
				$model['ultimoPago'] = $listado->ultimoPago;
				$model['estado'] = $listado->estado;
				$model['correo'] = strtoupper($listado->correo);
				$model['createdAt'] = $listado->createdAt;
				$model['updatedAt'] = $listado->updatedAt;			
				array_push($dtReturn, $model);
				unset($model);
			}
		}
		return $dtReturn;
	}
	public function fncObtenerPorTipoPersona($inputs)
	{
		$dtReturn = array();
        $cliente = new BusinessCliente();
		$tipoPersona = $inputs->tipoPersona;
		$idNaturalJuridica = '';
		if ($tipoPersona == "natural") {
			$idNaturalJuridica=(int)$inputs->idPersona;
		}else{
			$idNaturalJuridica=(int)$inputs->idJuridico;
		}
		$dtCliente = $cliente->fncObtenerPorTipoPersonaBD($tipoPersona,$idNaturalJuridica);
		if( fncGeneralValidarDataArray($dtCliente) ){
			
				$model = array();
				$model['idCliente'] 	= $dtCliente->idCliente;		
				$model['idPersona'] 		= $dtCliente->idPersona;
				$model['idJuridico'] 	= $dtCliente->idJuridico;
				$model['ultimoPago'] = $dtCliente->ultimoPago;
				$model['estado'] = $dtCliente->estado;
				$model['createdAt'] = $dtCliente->createdAt;
				$model['updatedAt'] = $dtCliente->updatedAt;				
				$dtReturn = $model;
		}
		return $dtReturn;
	}
	public function fncIndexView()
    {
	
		$idUsuarioSet= $_SESSION['sesionIdUsuario'];
		$clsModuloRolController = new ModuloRolController();
		$menuModulosPermisos =  $clsModuloRolController->fncListarRegistrosPermisosMenu($idUsuarioSet);	
		$moduloActual = 'CLIENTE';
		$menuActivo		= 'GESTIONCLIENTE';
		
        include('../../../../resources/views/includes/appHead.php');
        include('../../../../resources/views/content/cliente/index.php');
        include('../../../../resources/views/includes/appFooter.php');
		echo ('<script type="text/javascript" src="../../../../resources/js/cliente/scriptCliente.js"></script>');
    }
	public function fncListarRegistrosPorBusquedaDatos($arrayInputs)
	{
		$parametroBusqueda = fncObtenerValorArray($arrayInputs, 'q', true); //7:00
		$dtReturn = array();
		$cliente = new BusinessCliente();

		$dtListado = $cliente->fncListarRegistrosPorNombresBD($parametroBusqueda);

		//var_dump($dtListado);
		if (fncGeneralValidarDataArray($dtListado)) {
			foreach ($dtListado as $listado) {
				$model = array();
				//$model['tipoCliente'] 	= $listado->tipoCliente;
				$model['id'] = $listado->idCliente;
				if ($listado->tipoCliente == 'PERSONA') {
					$model['text'] = $listado->nombres . ' ' . $listado->apellidos . ' / ' . $listado->tipoCliente . ' - ' . $listado->dni;
				} else {
					$model['text'] = $listado->razonSocial . ' / ' . $listado->tipoCliente . ' / ' . $listado->ruc;
				}
				array_push($dtReturn, $model);
				unset($model);
			}
		}
		return $dtReturn;
	}

	public function fncGuardar($inputs)
	{

		$cliente = new Cliente;
		$businessCliente = new BusinessCliente();
		$idPersonaNatural = 0;
		if (isset($inputs->tipoPersona) && $inputs->tipoPersona == 'personaNatural') {
			$personaNaturalController = new PersonaNaturalController();
			$dataPersonaNatural = $personaNaturalController->fncGuardar($inputs);
			$idPersonaNatural = $dataPersonaNatural->getIdPersona();
			$dataCliente = 	$businessCliente->fncListarRegistrosIdPersonaNaturalBD($idPersonaNatural);			
			if (!($dataCliente[0])) {			
				$cliente->idPersona = $idPersonaNatural;
				$cliente = $businessCliente->fncGuardarPersonaNaturalBD($cliente);
				$dataReturn = $businessCliente->fncObtenerRegistroBD($cliente->idCliente);
				return ($dataReturn);
			} else {
				return $dataCliente[0];
			}
		}
		if (isset($inputs->tipoPersona) && $inputs->tipoPersona == 'personaJuridica'){
			$juridicoController = new JuridicoController();
			$dataJuridico = $juridicoController->fncGuardar($inputs);
			$dataCliente = 	$businessCliente->fncListarRegistrosIdJuridicolBD($dataJuridico->getIdJuridico());				
			if (!($dataCliente[0])) {								
				$cliente->idJuridico = $dataJuridico->getIdJuridico();				
				$cliente = $businessCliente->fncGuardarJuridicoBD($cliente);
				$dataReturn = $businessCliente->fncObtenerRegistroBD($cliente->idCliente);
				return ($dataReturn);
			}else{
				return $dataCliente[0];				
			}
		}

		// $auditoriaController = new AuditoriaController;
		// $aud_subsidio = clone $subsidio;
		// $aud_subsidio->archivo = $aud_archivo;
		// $auditoria = $auditoriaController->fncGuardar(1, 'subsidio', 'id_subsidio', $aud_subsidio->id_subsidio, json_encode($aud_subsidio));

		// $subsidio->fecha_registro = $auditoria->getFecha();
		// $subsidio->hora_registro = $auditoria->getHora();
		// $subsidio->usuario_registro = $auditoria->getUsuario();

		//return $cliente;
	}

	
	public function fncGuardarSolo($inputs)
	{
		$cliente = new Cliente;
		$businessCliente = new BusinessCliente();
		if (isset($inputs->idPersona)) {
			$cliente->idPersona = (int)$inputs->idPersona;
		}else{
			$cliente->idJuridico= (int)$inputs->idJuridico;
		}
		if (isset($inputs->idPersona)) {
			$dtCliente = $businessCliente->fncGuardarPersonaNaturalBD($cliente);
		}else{
			$dtCliente = $businessCliente->fncGuardarJuridicoBD($cliente);
		}

		return $dtCliente;
		
	}

}


