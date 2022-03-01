<?php
require_once '../../App/Escalafon/Models/UnidadEjecutora.php';
require_once '../../App/Config/control.php';

class UnidadEjecutoraController extends UnidadEjecutora
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
				
				$model['idUnidadEjecutora'] = $listado->idUnidadEjecutora;
				$model['unidadEjecutora'] =$listado->unidadEjecutora;
			
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
		SELECT * FROM escalafon.unidad_ejecutora
		WHERE (:id_unidad_ejecutora = -1 OR id_unidad_ejecutora = :id_unidad_ejecutora)
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_unidad_ejecutora', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new UnidadEjecutora;
			$temp->idUnidadEjecutora 	= $datos['id_unidad_ejecutora'];
			$temp->unidadEjecutora 		= $datos['unidad_ejecutora'];
		

			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}


} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom

?>