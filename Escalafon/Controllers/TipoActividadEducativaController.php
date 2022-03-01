<?php
require_once '../../App/Escalafon/Models/TipoActividadEducativa.php';
require_once '../../App/Config/control.php';

class TipoActividadEducativaController extends TipoActividadEducativa
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
				
				$model['idTipoActividadEducativa'] 	= $listado->idTipoActividadEducativa;
				$model['tipoActividadEducativa'] 		=$listado->tipoActividadEducativa;
	
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
			tae.id_tipo_actividad_educativa,
			tae.tipo_actividad_educativa
		FROM
			escalafon.tipo_actividad_educativa AS tae
		WHERE (:id_tipo_actividad_educativa = -1 OR tae.id_tipo_actividad_educativa = :id_tipo_actividad_educativa)
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_tipo_actividad_educativa', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new TipoActividadEducativa;
			$temp->idTipoActividadEducativa 	= $datos['id_tipo_actividad_educativa'];
			$temp->tipoActividadEducativa 	= $datos['tipo_actividad_educativa'];
			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}


} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom

?>