<?php
require_once '../../App/Escalafon/Models/TipoCategoria.php';
require_once '../../App/Config/control.php';

class TipoCategoriaController extends TipoCategoria
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
				
				$model['idTipoCategoria'] = $listado->idTipoCategoria;
				$model['tipoCategoria'] 	=$listado->tipoCategoria;
			
		
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
			tc.id_tipo_categoria,
			tc.tipo_categoria
		FROM  escalafon.tipo_categoria AS tc
		WHERE (:id_tipo_categoria = -1 OR id_tipo_categoria = :id_tipo_categoria)
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_tipo_categoria', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new TipoCategoria;
			$temp->idTipoCategoria 	= $datos['id_tipo_categoria'];
			$temp->tipoCategoria 		= $datos['tipo_categoria'];
		
	


			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}


} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom

?>