<?php
require_once '../../App/Escalafon/Models/TipoRegimenPension.php';
require_once '../../App/Config/control.php';

class TipoRegimenPensionController extends TipoRegimenPension
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
				$model['idTipoRegimenPension'] = $listado->idTipoRegimenPension;
				$model['tipoRegimenPension'] = $listado->tipoRegimenPension;


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

		$query = 'SELECT * FROM escalafon.tipo_regimen_pension
		WHERE (:id_tipo_regimen_pension = -1 OR id_tipo_regimen_pension = :id_tipo_regimen_pension)
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_tipo_regimen_pension', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new TipoRegimenPension;
			$temp->idTipoRegimenPension = $datos['id_tipo_regimen_pension'];
			$temp->tipoRegimenPension 	= $datos['tipo_regimen_pension'];
		

			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;


		






	}


} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom

?>