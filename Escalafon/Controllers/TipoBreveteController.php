<?php
require_once '../../App/Escalafon/Models/TipoBrevete.php';
require_once '../../App/Config/control.php';

class TipoBreveteController extends TipoBrevete
{
	//=======================================================================================
	//FUNCIONES LOGICA
	//=======================================================================================

	public function fncListarRegistros($id = -1)
	{

		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosBD($id);

		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
		
				$model = array();
				
				$model['id_tipo_brevete'] = $listado->idTipoBrevete;
				$model['nombre'] =$listado->nombre;
				$model['fecha_creacion'] =$listado->fechaCreacion;
	
	
				array_push($dtReturn, $model);
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
		$query = '
		SELECT
			tb.id_tipo_brevete,
			tb.nombre,
			tb.fecha_creacion
		FROM
			escalafon.tipo_brevete AS tb
		WHERE (:id_tipo_brevete = -1 OR id_tipo_brevete = :id_tipo_brevete)
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_tipo_brevete', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new TipoBrevete;
			$temp->idTipoBrevete 	    = $datos['id_tipo_brevete'];
			$temp->nombre 				= $datos['nombre'];
			$temp->fechaCreacion 		= $datos['fecha_creacion'];
		
	


			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}


} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom

?>