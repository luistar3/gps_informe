<?php
require_once '../../App/Escalafon/Models/TipoModalidad.php';
require_once '../../App/Config/control.php';

class TipoModalidadController extends TipoModalidad
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
				
				$model['idTipoModalidad'] = $listado->idTipoModalidad;
				$model['tipoModalidad'] 	=$listado->tipoModalidad;
	
	
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
			tm.id_tipo_modalidad,
			tm.tipo_modalidad
		FROM
			escalafon.tipo_modalidad AS tm
		WHERE (:id_tipo_modalidad = -1 OR id_tipo_modalidad = :id_tipo_modalidad)
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_tipo_modalidad', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new TipoModalidad;
			$temp->idTipoModalidad 	        = $datos['id_tipo_modalidad'];
			$temp->tipoModalidad 		= $datos['tipo_modalidad'];
	
			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}


} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom

?>