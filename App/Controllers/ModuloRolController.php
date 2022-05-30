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
	public function fncListarRegistrosModuloRol($id = -1)
	{
		$dtReturn = array();
        $moduloRol = new BusinessModuloRol();
		$dtListado = $moduloRol->fncListarRegistrosModuloRolBD($id);

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

	public function fncModificarModuloRol($input){
		$dtReturn= array();
		$idRol= (int)$input->idRol;
		$modulos = $input->modulos;
		$businessModuloRol = new BusinessModuloRol();
		$moduloRol = new ModuloRol();
		foreach ($modulos as $key => $modulo) {			
			if ($modulo->varlorCheck =='true' && (int)$modulo->idModulo>0) {
				$moduloRol->idModulo = (int)$modulo->idModulo;
				$moduloRol->idRol = (int)$idRol;				
				if ($businessModuloRol->fncObtenerPorIdRolIdModuloBD($moduloRol)) {
					$moduloRol->estado = 1;
					$businessModuloRol->fncModificarModuloRolBD($moduloRol);
				}else{					
					$moduloRol->estado = 1;
					$businessModuloRol->fncGuardarBD($moduloRol);
				}
				
			}else{
				$moduloRol->idModulo = (int)$modulo->idModulo;
				$moduloRol->idRol = (int)$idRol;
				$moduloRol->estado = 0;
				$businessModuloRol->fncModificarModuloRolBD($moduloRol);
			}
		}
		$dtReturn = $this->fncListarRegistros();
		return $dtReturn;
	}


}
?>