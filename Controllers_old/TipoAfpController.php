<?php
require_once '../../App/Escalafon/Models/TipoAfp.php';
require_once '../../App/Config/control.php';

class TipoAfpController extends TipoAfp
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
				
				$model['idTipoAfp'] = $listado->idTipoAfp;
				$model['tipoAfp'] =$listado->tipoAfp;
				
	
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
		SELECT * FROM escalafon.tipo_afp
		WHERE (:id_tipo_afp = -1 OR id_tipo_afp = :id_tipo_afp)
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_tipo_afp', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new TipoAfp;
			$temp->idTipoAfp 	        = $datos['id_tipo_afp'];
			$temp->tipoAfp 		= $datos['tipo_afp'];
		
	


			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}


} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom

?>