<?php
require_once '../../App/Escalafon/Models/TipoDocumentoDesplazamiento.php';
require_once '../../App/Config/control.php';

class TipoDocumentoDesplazamientoController extends TipoDocumentoDesplazamiento
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
				
				$model['idTipoDocumentoDesplazamiento'] 	= $listado->idTipoDocumentoDesplazamiento;
				$model['tipoDocumentoDesplazamiento'] 	=$listado->tipoDocumentoDesplazamiento;
		
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
			tdd.id_tipo_documento_desplazamiento,
			tdd.tipo_documento_desplazamiento
		FROM
			escalafon.tipo_documento_desplazamiento AS tdd
		WHERE (:id_tipo_documento_desplazamiento = -1 OR tdd.id_tipo_documento_desplazamiento = :id_tipo_documento_desplazamiento)
		ORDER BY tdd.id_tipo_documento_desplazamiento
		
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_tipo_documento_desplazamiento', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new TipoDocumentoDesplazamiento;
			$temp->idTipoDocumentoDesplazamiento 	= $datos['id_tipo_documento_desplazamiento'];
			$temp->tipoDocumentoDesplazamiento 	= $datos['tipo_documento_desplazamiento'];

			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}


} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom

?>