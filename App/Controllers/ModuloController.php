<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Models/Modulo.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Business/BusinessModulo.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Public/funciones.php');

class ModuloController extends Modulo
{	
	public function fncListarRegistros($id = -1)
	{
		$dtReturn = array();
        $modulo = new BusinessModulo();
		$dtListado = $modulo->fncListarRegistrosBD($id);
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
				$model = array();
				$model['idModulo'] 		= $listado->idModulo;
				$model['modulo'] 		= $listado->modulo;
				$model['descripcion'] 	= $listado->descripcion;
				$model['estado'] 		= $listado->estado;
				$model['createdAt'] 	= $listado->createdAt;
				$model['updatedAt'] 	= $listado->updatedAt;
				
				array_push($dtReturn, $model);
				unset($model);
			}
		}
		return $dtReturn;
	}


}
?>