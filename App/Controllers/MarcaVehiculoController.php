<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Models/Contrato.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Business/BusinessMarcaVehiculo.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Public/funciones.php');

class MarcaVehiculoController extends MarcaVehiculo
{	
   	public function fncListarRegistros($id = -1)
	{
		$dtReturn = array();
        $personaMarcaVehiculo = new BusinessMarcaVehiculo();
		$dtListado = $personaMarcaVehiculo->fncListarRegistrosBD($id);
		
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
				$model = array();
				$model['idMarcaVehiculo'] 	= $listado->idMarcaVehiculo;
				$model['marca'] = $listado->marca;
				$model['createdAt'] = $listado->createdAt;
				$model['updatedAt'] = $listado->updatedAt;			
				array_push($dtReturn, $model);
				unset($model);
			}
		}
		return $dtReturn;
	}

}

   
?>