<?php
require_once '../../App/Escalafon/Models/EquipoTrabajo.php';
require_once '../../App/Config/control.php';

class EquipoTrabajoController extends EquipoTrabajo {
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
				$model['idEquipoTrabajo'] = $listado->idEquipoTrabajo;
				$model['nombreEquipoTrabajo'] = $listado->nombreEquipoTrabajo;
				$model['descripcionEquipoTrabajo'] = $listado->descripcionEquipoTrabajo;
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
            		id_equipo_trabajo,
            		nombre_equipo_trabajo,
            		descripcion_equipo_trabajo,
            		estado,
            		fecha_creacion
        		  FROM escalafon.equipo_trabajo 
        		  WHERE (:id_equipo_trabajo = -1 OR  id_equipo_trabajo = :id_equipo_trabajo)';
		$statement = $sql->preparar( $query );
		$arrayReturn = array();
		if( $statement!=false ){
			$statement->bindParam('id_equipo_trabajo', $id);
			$sql->ejecutar();
			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
    			$temp = new EquipoTrabajo;
    			$temp->idEquipoTrabajo = $datos['id_equipo_trabajo'];
    			$temp->nombreEquipoTrabajo = $datos['nombre_equipo_trabajo'];
    			$temp->descripcionEquipoTrabajo = $datos['descripcion_equipo_trabajo'];
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