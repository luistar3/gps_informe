<?php
require_once '../../App/Escalafon/Models/TipoRegimenLaboral.php';
require_once '../../App/Config/control.php';

class TipoRegimenLaboralController extends TipoRegimenLaboral
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
				$model['idTipoRegimenLaboral'] = $listado->idTipoRegimenLaboral;
				$model['tipoRegimenLaboral'] = $listado->tipoRegimenLaboral;


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
			trl.id_tipo_regimen_laboral,
			trl.tipo_regimen_laboral
		FROM escalafon.tipo_regimen_laboral AS trl
		WHERE (:id_tipo_regimen_laboral = -1 OR trl.id_tipo_regimen_laboral = :id_tipo_regimen_laboral)
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_tipo_regimen_laboral', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new TipoRegimenLaboral;
			$temp->idTipoRegimenLaboral = $datos['id_tipo_regimen_laboral'];
			$temp->tipoRegimenLaboral = $datos['tipo_regimen_laboral'];
		

			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;


		






	}


} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom

?>