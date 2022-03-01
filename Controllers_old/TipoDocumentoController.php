<?php
require_once '../../App/Escalafon/Models/TipoDocumento.php';
require_once '../../App/Config/control.php';

class TipoDocumentoController extends TipoDocumento
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
				
				$model['id_tipoDocumento']		=$listado->idTipoDocumento;
				$model['tipoDocumento'] 		=$listado->tipoDocumento;
				$model['categoriaDocumento'] 	=$listado->categoriaDocumento;


				array_push($dtReturn, $model);
			}
		}
		return $dtReturn;
	}

	public function fncListarRegistrosDes($id = -1)
	{

		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosBD($id);

		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
		
				$model = array();
				
				$model['idTipoDocumento']		=$listado->idTipoDocumento;
				$model['tipoDocumento'] 		=$listado->tipoDocumento;
				$model['categoriaDocumento'] 	=$listado->categoriaDocumento;


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
			td.id_tipo_documento,
			td.tipo_documento,
			td.categoria_documento
		FROM
			escalafon.tipo_documento AS td
		WHERE (:id_tipo_documento = -1 OR id_tipo_documento = :id_tipo_documento)
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_tipo_documento', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new TipoDocumento;
			$temp->idTipoDocumento 		= $datos['id_tipo_documento'];
			$temp->tipoDocumento 		= $datos['tipo_documento'];
			$temp->categoriaDocumento 	= $datos['categoria_documento'];


			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}


} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom

?>