<?php
require_once '../../App/Escalafon/Models/TipoArea.php';
require_once '../../App/Config/control.php';

class AreaController extends Area
{
//=======================================================================================
// FUNCIONES LOGICA
//=======================================================================================
	public function fncListarRegistros($id = -1)
	{
		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosBD($id);
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
				$model = array();
				$model['id_tipo_area'] = $listado->idTipoArea;
				$model['nombre'] = $listado->nombre;
				$model['estado'] = $listado->estado;
				array_push($dtReturn, $model);
				unset($model);
			}
		}
		return $dtReturn;
	}

//=======================================================================================
// FUNCIONES BASE DE DATOS
//=======================================================================================
	private function fncListarRegistrosBD( $id = -1 )
	{
		$sql = cls_control::get_instancia();
		$query = "SELECT * FROM escalafon.tipo_area WHERE (:id_tipo_area = -1 OR id_tipo_area = :id_tipo_area)";
		$statement = $sql->preparar( $query );
		$arrayReturn = array();
		if( $statement!=false ){
			$statement->bindParam('id_tipo_area', $id);
			$sql->ejecutar();
			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
				$temp = new TipoArea;
				$temp->idTipoArea = $datos['id_tipo_area'];
				$temp->nombre = $datos['nombre'];
				$temp->estado	= $datos['estado'];
				array_push( $arrayReturn, $temp );
				unset($temp);
			}
		}
		return $arrayReturn;
	}
}