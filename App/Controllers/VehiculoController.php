<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Models/Vehiculo.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Business/BusinessVehiculo.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Public/funciones.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Controllers/ModuloRolController.php');

class VehiculoController extends Vehiculo
{	

	public function fncIndexView()
    {
	
		$idUsuarioSet= $_SESSION['sesionIdUsuario'];
		$clsModuloRolController = new ModuloRolController();
		$menuModulosPermisos =  $clsModuloRolController->fncListarRegistrosPermisosMenu($idUsuarioSet);	
		$moduloActual = 'VEHICULO';
		$menuActivo		= 'GESTIONVEHICULO';
		
        include('../../../../resources/views/includes/appHead.php');
        include('../../../../resources/views/content/vehiculo/index.php');
        include('../../../../resources/views/includes/appFooter.php');
		echo ('<script type="text/javascript" src="../../../../resources/js/vehiculo/scriptVehiculo.js"></script>');
    }

	
	public function fncReporteView()
    {
	
		$idUsuarioSet= $_SESSION['sesionIdUsuario'];
		$clsModuloRolController = new ModuloRolController();
		$menuModulosPermisos =  $clsModuloRolController->fncListarRegistrosPermisosMenu($idUsuarioSet);	
		$moduloActual = 'VEHICULO';
		$menuActivo		= 'REPORTEVEHICULO';
		
        include('../../../../resources/views/includes/appHead.php');
        include('../../../../resources/views/content/vehiculo/reporte.php');
        include('../../../../resources/views/includes/appFooter.php');
		//echo ('<script type="text/javascript" src="../../../../resources/js/contrato/scriptContrato.js"></script>');
    }



	public function fncListarRegistros()
	{
		$dtReturn = array();
        $vehiculo = new BusinessVehiculo();
		$dtListado = $vehiculo->fncListarRegistrosBD();
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
				$model = array();
				$model['idVehiculo'] 		= $listado->idVehiculo;
				$model['idMarcaVehiculo'] 		= $listado->idMarcaVehiculo;
				$model['marca'] 	= $listado->marca;
				$model['placa'] 		= $listado->placa;
				$model['modelo'] 	= $listado->modelo;
				$model['anio'] 	= $listado->anio;
				$model['gps'] 	= $listado->gps;
				$model['imei'] 	= $listado->imei;
				$model['estado'] 	= $listado->estado;
				$model['createdAt'] 	= $listado->createdAt;
				
				array_push($dtReturn, $model);
				unset($model);
			}
		}
		return $dtReturn;
	}
	
	public function fncGuardar ($inputs):Vehiculo{

		$vehiculo = new Vehiculo;
		$businessVehiculo = new BusinessVehiculo();
		$vehiculo->idMarcaVehiculo= (int)$inputs->idMarcaVehiculo;
		$vehiculo->placa=strtoupper($inputs->placa);
		$vehiculo->modelo=strtoupper($inputs->modelo);
		$vehiculo->anio=strtoupper($inputs->anio);
		$vehiculo->gps=strtoupper($inputs->gps);
		$vehiculo->imei=strtoupper($inputs->imei);
		$vehiculo->fechaInstalacion=$inputs->fechaInstalacion;

		if(!$vehiculo=$businessVehiculo->fncGuardarBD($vehiculo)){
			return false;
		}
		return $vehiculo;
		
	}

	public function fncActualizarBD($inputs):Vehiculo
	{
		$vehiculo = new Vehiculo();
		$businessVehiculo = new BusinessVehiculo();
		$vehiculo->idMarcaVehiculo= (int)$inputs->idMarcaVehiculo;
		$vehiculo->placa=strtoupper($inputs->placa);
		$vehiculo->modelo=strtoupper($inputs->modelo);
		$vehiculo->anio=strtoupper($inputs->anio);
		$vehiculo->gps=strtoupper($inputs->gps);
		$vehiculo->imei=strtoupper($inputs->imei);
		$vehiculo->idVehiculo = (int)$inputs->idVehiculo;
		if(!$vehiculo=$businessVehiculo->fncActualizarBD($vehiculo)){
			return false;
		}
		return $vehiculo;
	}

	public function fncDeshabilitar($inputs):Vehiculo
	{
		$vehiculo = new Vehiculo();
		$businessVehiculo = new BusinessVehiculo();		
		if ((int)$inputs->estado==0 || $inputs->estado=="") {
			$vehiculo->estado = 1;
		}else{
			$vehiculo->estado = 0;
		}	
		$vehiculo->idVehiculo = (int)$inputs->idVehiculo;
		if(!$vehiculo=$businessVehiculo->fncDeshabilitarBD($vehiculo)){
			return false;
		}
		return $vehiculo;
	}

}
?>