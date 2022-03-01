<?php
require_once '../../App/Escalafon/Models/TipoAccion.php';
require_once '../../App/Config/control.php';

class TipoAccionController extends TipoAccion
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
				
				$model['idTipoAccion']	=$listado->idTipoAccion;
				$model['tipo'] 				=$listado->tipo;
				$model['categoria'] 		=$listado->categoria;

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
			ta.id_tipo_accion,
			ta.tipo,
			ta.categoria
		FROM
			escalafon.tipo_accion AS ta
		WHERE (:id_tipo_accion = -1 OR id_tipo_accion = :id_tipo_accion)
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_tipo_accion', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new TipoAccion;
			$temp->idTipoAccion 	        = $datos['id_tipo_accion'];
			$temp->tipo 					= $datos['tipo'];
			$temp->categoria 				= $datos['categoria'];
		
	


			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}


} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom

?>