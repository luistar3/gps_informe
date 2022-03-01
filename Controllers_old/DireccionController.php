<?php
require_once '../../App/Escalafon/Models/Direccion.php';
require_once '../../App/Config/control.php';

class DireccionController extends Direccion {
//=======================================================================================
//FUNCIONES LOGICAS
//=======================================================================================
	public function fncListarRegistros($id = -1)
	{
		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosBD($id);
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
				$model = array();
				$model['idDireccion'] = $listado->idDireccion;
				$model['nombreDireccion'] = $listado->nombreDireccion;
				$model['descripcionDireccion'] = $listado->descripcionDireccion;
				$model['estado'] = $listado->estado;
				$model['fechaCreacion'] = fncValidarFormatearFecha($listado->fechaCreacion);
				array_push($dtReturn, $model);
				unset($model);
			}
		}
		return $dtReturn;
	}

//=======================================================================================
//FUNCIONES BASE DE DATOS
//=======================================================================================
	private function fncListarRegistrosBD( $id = -1 )
	{
		$sql = cls_control::get_instancia();
		$query = 'SELECT 
            		id_direccion,
            		nombre_direccion,
            		descripcion_direccion,
            		estado,
            		fecha_creacion
        		  FROM escalafon.direccion 
        		  WHERE (:id_direccion = -1 OR  id_direccion = :id_direccion)';
		$statement = $sql->preparar( $query );
		$arrayReturn = array();
		if( $statement!=false ){
			$statement->bindParam('id_direccion', $id);
			$sql->ejecutar();
			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
    			$temp = new Direccion;
    			$temp->idDireccion = $datos['id_direccion'];
    			$temp->nombreDireccion = $datos['nombre_direccion'];
    			$temp->descripcionDireccion = $datos['descripcion_direccion'];
    			$temp->estado = $datos['estado'];
    			$temp->fechaCreacion = $datos['fecha_creacion'];
    			array_push( $arrayReturn, $temp );
    			unset($temp);
			}
		}
		return $arrayReturn;
	}
	
} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom

?>