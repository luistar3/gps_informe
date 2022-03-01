<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Models/ContratoVehiculo.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Business/BusinessContratoVehiculo.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Controllers/ModuloRolController.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Public/funciones.php');

class ContratoVehiculoController extends ContratoVehiculo
{	
	public function fncContratoVehiculoDetalleView($inputs){

		$idUsuarioSet= 1;
		$clsModuloRolController = new ModuloRolController();
		$menuModulosPermisos =  $clsModuloRolController->fncListarRegistrosPermisosMenu($idUsuarioSet);	
		$moduloActual = 'CONTRATO';
		$menuActivo		= 'NUEVACONTRATO';
		$constatesJs ='<script type="text/javascript">';
		$constatesJs .='const idContratoVehiculo = '.$inputs->idContratoVehiculo.';';
		$constatesJs .='const idContrato = '.$inputs->idContrato.';';
		$constatesJs .='const idVehiculo = '.$inputs->idVehiculo.';';
		$constatesJs .='var placaSeleccionada = "'.$inputs->placaVehiculo.'";';
		$constatesJs .=' </script>';	
		
        include('../../../../resources/views/includes/appHead.php');
        include('../../../../resources/views/content/contratoVehiculo/index.php');
        include('../../../../resources/views/includes/appFooter.php');
		echo ($constatesJs);
		echo ('<script type="text/javascript" src="../../../../resources/js/contratoVehiculo/scriptContratoVehiculo.js"></script>');
	}
	public function fncListarRegistros($id = -1)
	{
		$dtReturn = array();
        $businessContratoVehiculo = new BusinessContratoVehiculo();
		$dtListado = $businessContratoVehiculo->fncListarRegistrosBD($id);
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){			
				$model = array();
				$model['idRol'] 		= $listado->idRol;
				$model['nombre'] 		= $listado->nombre;
				$model['estado'] 		= $listado->estado;
				$model['createdAt'] 	= $listado->createdAt;
				$model['updatedAt'] 	= $listado->updatedAt;
					
				array_push($dtReturn, $model);
				unset($model);
			}
		}
		return $dtReturn;
	}

	public function fncObtenerContratoVehiculo($inputs)
	{
		$contratoVehiculo = new ContratoVehiculo;
		$contratoVehiculo->idContratoVehiculo = $inputs->idContratoVehiculo;
		$dtReturn = array();
        $businessContratoVehiculo = new BusinessContratoVehiculo();
		$dtListado = $businessContratoVehiculo->fncObtenerContratoVehiculoBD($contratoVehiculo);
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){			
				$model = array();
				$model['idContratoVehiculo'] 		= $listado->idContratoVehiculo;
				$model['idContrato'] 		= $listado->idContrato;
				$model['idVehiculo'] 		= $listado->idVehiculo;
				$model['montoPago'] 		= $listado->montoPago;
				$model['frecuenciaPago'] 		= $listado->frecuenciaPago;
				$model['fechaInstalacion'] 		= $listado->fechaInstalacion;
				$model['createdAt'] 	= $listado->createdAt;
				$model['updatedAt'] 	= $listado->updatedAt;
					
				array_push($dtReturn, $model);
				unset($model);
			}
		}
		return $dtReturn;
	}
	public function fncListadoPlacasDisponibles($inputs)
	{
		$contratoVehiculo = new ContratoVehiculo;
		$dtReturn = array();
        $businessContratoVehiculo = new BusinessContratoVehiculo();
		$dtListado = $businessContratoVehiculo->fncListadoPlacasDisponiblesBD((int)$inputs->idContrato,$inputs->placa);
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){			
				$model = array();
				$model['idVehiculo'] 		= $listado->idVehiculo;
				$model['idMarcaVehiculo'] 		= $listado->idMarcaVehiculo;
				$model['marca'] 		= $listado->marca;
				$model['placa'] 		= $listado->placa;
				$model['otrosContratos'] 		= $listado->otrosContratos;
				$model['nombres'] 		= $listado->nombres;
				$model['modelo'] 	= $listado->modelo;
				$model['anio'] 	= $listado->anio;
				$model['gps'] 	= $listado->gps;
				$model['imei'] 	= $listado->imei;
				array_push($dtReturn, $model);
				unset($model);
			}
		}
		return $dtReturn;
	}
	public function fncListadoPlacasDisponibles2($inputs)
	{
		
		$dtReturn = array();
        $businessContratoVehiculo = new BusinessContratoVehiculo();
		$dtListado = $businessContratoVehiculo->fncListadoPlacasDisponibles2BD((int)$inputs->idContrato);
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){			
				$model = array();
				$model['idVehiculo'] 		= $listado->idVehiculo;
				$model['idMarcaVehiculo'] 		= $listado->idMarcaVehiculo;
				$model['marca'] 		= $listado->marca;
				$model['placa'] 		= $listado->placa;
				$model['otrosContratos'] 		= $listado->otrosContratos;
				$model['modelo'] 	= $listado->modelo;
				$model['anio'] 	= $listado->anio;
				$model['gps'] 	= $listado->gps;
				$model['imei'] 	= $listado->imei;
				array_push($dtReturn, $model);
				unset($model);
			}
		}
		return $dtReturn;
	}

	public function fncGuardar($inputs){

		$contratoVehiculo = new ContratoVehiculo;
		$businessContratoVehiculo = new BusinessContratoVehiculo();
		$contratoVehiculo->idContrato=$inputs->idContrato;
		$contratoVehiculo->idVehiculo=$inputs->idVehiculo;

		$data = $businessContratoVehiculo->fncObtenerIdContratoIdVehiculoBD($contratoVehiculo);
		
		if (empty($data)) {
			$contratoVehiculo->montoPago = $inputs->montoPago;
			$contratoVehiculo->frecuenciaPago = $inputs->frecuenciaPago;
			$contratoVehiculo->fechaInstalacion = $inputs->fechaInstalacion;
			if (isset($inputs->fechaTermino)){
				$contratoVehiculo->fechaTermino = $inputs->fechaTermino;
			}else{
				$contratoVehiculo->fechaTermino ='';
			}
			$contratoVehiculo= $businessContratoVehiculo->fncGuardarBD($contratoVehiculo);

		}		
		
		return $contratoVehiculo;

	}

	public function fncActualizar($inputs)
	{
		$contratoVehiculo = new ContratoVehiculo;
		$businessContratoVehiculo = new BusinessContratoVehiculo();
		$dataReturn = array();

		$contratoVehiculo->montoPago = $inputs->montoPago;
		$contratoVehiculo->idContratoVehiculo = $inputs->idContratoVehiculo;
		$contratoVehiculo->fechaTermino = $inputs->fechaTermino;
		$dataReturn = $businessContratoVehiculo->fncActualizarBD($contratoVehiculo);
		return $dataReturn;
	}

	public function fncEliminar($inputs)
	{
		$contratoVehiculo = new ContratoVehiculo;
		$businessContratoVehiculo = new BusinessContratoVehiculo();
		$dataReturn = array();

	
		$contratoVehiculo->idContratoVehiculo = $inputs->idContratoVehiculo;
		
		$dataReturn = $businessContratoVehiculo->fncEliminarBD($contratoVehiculo);
		return $dataReturn;
	}


}
?>