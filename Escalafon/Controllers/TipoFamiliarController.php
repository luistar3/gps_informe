<?php
require_once '../../App/Escalafon/Models/TipoFamiliar.php';
require_once '../../App/Config/control.php';

class TipoFamiliarController extends TipoFamiliar
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
				
				$model['idTipoFamiliar'] = $listado->idTipoFamiliar;
				$model['tipoFamiliar'] =$listado->tipoFamiliar;

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
			tf.id_tipo_familiar,
			tf.tipo_familiar
		FROM
			escalafon.tipo_familiar AS tf
		WHERE (:id_tipo_familiar = -1 OR id_tipo_familiar = :id_tipo_familiar)
		
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_tipo_familiar', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new TipoFamiliar;
			$temp->idTipoFamiliar 		= $datos['id_tipo_familiar'];
			$temp->tipoFamiliar 		= $datos['tipo_familiar'];
		

			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}



	


} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom

?>