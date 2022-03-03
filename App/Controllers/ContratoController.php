<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Models/Contrato.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Business/BusinessContrato.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Public/funciones.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Public/archivo.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Controllers/ModuloRolController.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Controllers/ContratoVehiculoController.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Controllers/VehiculoController.php');

class ContratoController extends Contrato
{	

	public function fncListarTipoPago($id = -1)
	{
		$dtReturn = array();
        $businessContrato = new BusinessContrato();
		$dtListado = $businessContrato->fncListarTipoPagoBD($id);
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
				$model = array();
				$model['idTipoPago'] 	= $listado->idTipoPago;
				$model['tipoPago'] = $listado->tipoPago;	
				array_push($dtReturn, $model);
				unset($model);
			}
		}
		return $dtReturn;
	}
    public function fncIndexView()
    {
	
		$idUsuarioSet= $_SESSION['sesionIdUsuario'];
		$clsModuloRolController = new ModuloRolController();
		$menuModulosPermisos =  $clsModuloRolController->fncListarRegistrosPermisosMenu($idUsuarioSet);	
		$moduloActual = 'CONTRATO';
		$menuActivo		= 'NUEVOCONTRATO';
		
        include('../../../../resources/views/includes/appHead.php');
        include('../../../../resources/views/content/contrato/index.php');
        include('../../../../resources/views/includes/appFooter.php');
		echo ('<script type="text/javascript" src="../../../../resources/js/contrato/scriptContrato.js"></script>');
    }

	public function fncListadoContratoView()
    {
		
		$idUsuarioSet= (int)$_SESSION["sesionIdUsuario"];
		$clsModuloRolController = new ModuloRolController();
		$menuModulosPermisos =  $clsModuloRolController->fncListarRegistrosPermisosMenu($idUsuarioSet);	
		
		$moduloActual = 'CONTRATO';
		$menuActivo		= 'LISTADOCONTRATO';
		
        include('../../../../resources/views/includes/appHead.php');
        include('../../../../resources/views/content/contrato/listadoContratos.php');
        include('../../../../resources/views/includes/appFooter.php');
		echo ('<script type="text/javascript" src="../../../../resources/js/contrato/scriptListadoContrato.js"></script>');
    }

	public function fncEditarContratoView($inputs)
    {
	
		$idUsuarioSet= $_SESSION['sesionIdUsuario'];
		$clsModuloRolController = new ModuloRolController();
		$menuModulosPermisos =  $clsModuloRolController->fncListarRegistrosPermisosMenu($idUsuarioSet);	
		$moduloActual = 'CONTRATO';
		$menuActivo		= 'LISTADOCONTRATO';

		$constatesJs ='<script type="text/javascript">';		
		$constatesJs .='const idContrato = '.$inputs->idContrato.';';		
		$constatesJs .=' </script>';
		
		
        include('../../../../resources/views/includes/appHead.php');
        include('../../../../resources/views/content/contrato/editarContratos.php');
        include('../../../../resources/views/includes/appFooter.php');
		echo ($constatesJs);
		echo ('<script type="text/javascript" src="../../../../resources/js/contrato/scriptEditarContrato.js"></script>');
    }
	public function fncListarRegistros($inputs)
	{
		$dtReturn = array();
        $businessContrato = new BusinessContrato();
		$contratoDesde = $inputs->contratoFechaInicioDesde;
		$contratoHasta = $inputs->contratoFechaInicioHasta;
		$estadoContrato = $inputs->contratoEstado;
		$dtListado = $businessContrato->fncListarRegistrosBD($contratoDesde,$contratoHasta,$estadoContrato);
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
				$model = array();
				$model['idContrato'] 	= $listado->idContrato;
				$model['idCliente'] = $listado->idCliente;
				$model['nombre'] 	= $listado->nombre;
				$model['fechaInicio'] = $listado->fechaInicio;
				$model['fechaFin'] = $listado->fechaFin;
				$model['mensualidad'] 		= $listado->mensualidad;
				$model['contrato'] 	= $listado->contrato;
				$model['estado'] = $listado->estado;
				$model['createdAt'] = $listado->createdAt;	
				$model['updatedAt'] = $listado->updatedAt;
				$model['tipoCliente'] = $listado->tipoCliente;	
				array_push($dtReturn, $model);
				unset($model);
			}
		}
		return $dtReturn;
	}
	public function fncObtenerRegistro($id)
	{
		$dtReturn = array();
        $businessContrato = new BusinessContrato();
		$dtListado = $businessContrato->fncObtenerRegistroBD($id);
		if( fncGeneralValidarDataArray($dtListado) ){
		$dtReturn =$dtListado;
		}
		return $dtReturn;
	}

	public function fncListarContratoVehiculo($inputs)
	{
		$dtReturn = array();
		$businessContrato = new BusinessContrato();
		$dtListado = $businessContrato->fncListarContratoVehiculoBD($inputs->idContrato);
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
				$model = array();				
				$model['idContratoVehiculo'] 	= $listado->idContratoVehiculo;
				$model['idContrato'] 	= $listado->idContrato;
				$model['idVehiculo'] 	= $listado->idVehiculo;
				$model['montoPago'] 	= $listado->montoPago;
				$model['frecuenciaPago'] 		= $listado->frecuenciaPago;
				$model['fechaInstalacion'] 	= $listado->fechaInstalacion;
				$model['fechaTermino'] 		= $listado->fechaTermino;
				$model['placa']	= $listado->placa;
				$model['marca']	= $listado->marca;
				$model['idMarcaVehiculo']	= $listado->idMarcaVehiculo;
				$model['modelo']	= $listado->modelo;
				$model['anio']	= $listado->anio;
				$model['gps']	= $listado->gps;			
				$model['imei'] 		= $listado->imei;	
				$model['ultimoPago'] 		= $listado->ultimoPago;
				array_push($dtReturn, $model);
				unset($model);
			}
		}
		
		return $dtReturn;
	}
	public function fncGuardar($inputs)
	{
	
		
		$contrato = new Contrato;
		$businessContrato = new BusinessContrato();
		$contrato->idCliente = $inputs->idCliente;
		$contrato->mensualidad = $inputs->mensualidadContrato;
		$contrato->fechaInicio = $inputs->fechaInicioContrato;
		$contrato->fechaFin = $inputs->fechaFinContrato;
		//echo("entro");
		$contrato=$businessContrato->fncGuardarBD($contrato);
		if ($contrato!=false) {			
			$vehiculoController = new VehiculoController();
			$pagoContrato = json_decode($inputs->pagoContrato);
			$pagoFrecuencia = json_decode($inputs->pagoFrecuencia);
			$idMarcaVehiculo = json_decode($inputs->marcaVehiculo);
			$modelo = json_decode($inputs->modelo);
			$placa = json_decode($inputs->placa);
			$anio = json_decode($inputs->anio);			
			$gps = json_decode($inputs->gps);
			$imei = json_decode($inputs->imei);
			$fechaInstalacion = json_decode($inputs->fechaInstalacion);
					
			
			if (is_array(json_decode($inputs->placa))) {
				$idVehiculo = array();
				for ($i=0; $i < count(json_decode($inputs->placa)) ; $i++) { 
					if (!empty($placa[$i])) {					
						$vehiculo = new \stdClass; 
						$vehiculo->placa=$placa[$i];
						$vehiculo->idMarcaVehiculo=$idMarcaVehiculo[$i];
						$vehiculo->modelo=$modelo[$i];
						$vehiculo->anio=$anio[$i];
						$vehiculo->gps=$gps[$i];
						$vehiculo->imei=$imei[$i];	
						//var_dump($vehiculo);
						$vehiculo = $vehiculoController->fncGuardar($vehiculo);
						if ($vehiculo) {
							$contratoVehiculo = new \stdClass; 
							$contratoVehiculo->idContrato=$contrato->idContrato;
							$contratoVehiculo->idVehiculo=$vehiculo->getIdVehiculo();
							$contratoVehiculo->montoPago = $pagoContrato[$i];
							$contratoVehiculo->frecuenciaPago = $pagoFrecuencia[$i];
							$contratoVehiculo->fechaInstalacion = $fechaInstalacion[$i];
							array_push($idVehiculo,$contratoVehiculo);
						}
						
					}
		
				}
				$arrayContratoVehiculo = array();
				foreach ($idVehiculo as $key => $value) {
					$contratoVehiculo = new ContratoVehiculoController();
					array_push($arrayContratoVehiculo,$contratoVehiculo->fncGuardar($value));
				}

			
			}

		}
		

		return $contrato;
		
	}

	public function fncActualizar($inputs,$archivo)
	{
		$contrato = new Contrato;
		$businessContrato = new BusinessContrato();
		$contrato->idContrato = (int)$inputs->idContrato;
		$contrato->mensualidad = $inputs->mensualidadContrato;
		$contrato->fechaInicio = $inputs->fechaInicio;
		$contrato->fechaFin = $inputs->fechaFin;
		$contrato->contrato = '';
		$dtReturn = array();
		if ($archivo) {
			$ruta = '../../archivos/contratos/';
			$nombreArchivo = ($archivo['name']) . '_' . uniqid() . '_';
			$obj_arc = new archivo($archivo,$ruta , "pdf_" . $nombreArchivo, 0,1);//1 tipo pdf
			if ($obj_arc->subir()) {
			$optArchivo = $obj_arc->get_nombre_archivo();
			$contrato->contrato =($ruta.$obj_arc->get_nombre_archivo());
			}
		}
		$contrato=$businessContrato->fncActualizarBD($contrato);

		return $dtReturn = $contrato;
	}

}

   
?>