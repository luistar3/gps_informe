<?php
require_once '../../App/Escalafon/Models/TipoCondicion.php';
require_once '../../App/Config/control.php';

class TipoCondicionController extends TipoCondicion
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
				
				$model['idTipoCondicion'] = $listado->idTipoCondicion;
				$model['tipoCondicion'] =$listado->tipoCondicion;
			
	
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
		SELECT * FROM escalafon.tipo_condicion
		WHERE (:id_tipo_condicion = -1 OR id_tipo_condicion = :id_tipo_condicion)
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_tipo_condicion', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new TipoCondicion;
			$temp->idTipoCondicion 	        = $datos['id_tipo_condicion'];
			$temp->tipoCondicion 		= $datos['tipo_condicion'];
	
			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}


} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom

?>