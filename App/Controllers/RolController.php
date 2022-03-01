<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Models/Rol.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Business/BusinessRol.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Public/funciones.php');

class RolController extends Rol
{	
	public function fncListarRegistros($id = -1)
	{
		$dtReturn = array();
        $rol = new BusinessRol();
		$dtListado = $rol->fncListarRegistrosBD($id);
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


}
?>