<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Models/ModuloRol.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Business/BusinessModuloRol.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Public/funciones.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Controllers/RolController.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Controllers/ModuloController.php');

class ModuloRolController extends ModuloRol
{	
	public function fncListarRegistros($id = -1)
	{
		$dtReturn = array();
        $moduloRol = new BusinessModuloRol();
		$dtListado = $moduloRol->fncListarRegistrosBD($id);

		$clsRol = new RolController();
		$clsModulo = new ModuloController();

		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
				$model = array();
				$model['idModuloRol'] 	= $listado->idModuloRol;
				$model['idModulo'] 		= $listado->idModulo;
				$model['modulo'] 		=  array_shift($clsModulo->fncListarRegistros($listado->idModulo));
				$model['idRol'] 		= $listado->idRol;
				$model['rol'] 			=  array_shift($clsRol->fncListarRegistros($listado->idModulo));
				$model['estado'] 		= $listado->estado;
				$model['createdAt'] 	= $listado->createdAt;
				$model['updatedAt'] 	= $listado->updatedAt;
					
				array_push($dtReturn, $model);
				unset($model);
			}
		}
		return $dtReturn;
	}
	public function fncListarRegistrosPermisosMenu($id = -1)
	{
		$dtReturn = array();
        $moduloRol = new BusinessModuloRol();
		$dtListado = $moduloRol->fncListarRegistrosPermisosMenuBD($id);
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){					
				array_push($dtReturn, $listado->modulo);				
			}
		}
		return $dtReturn;
	}


}
?>