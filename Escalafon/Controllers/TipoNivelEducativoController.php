<?php
require_once '../../App/Escalafon/Models/TipoNivelEducativo.php';
require_once '../../App/Config/control.php';

class TipoNivelEducativoController extends TipoNivelEducativo
{
	//=======================================================================================
	//FUNCIONES LOGICA
	//=======================================================================================

	public function fncListarRegistros($id=0)
	{
		//$inputIdTrabajador = (Int) fncObtenerValorArray( $arrayInputs, 'idTipoCasa', true);
		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosBD($id);

		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
		
				$model = array();
				
				$model['idTipoNivelEducativo'] = $listado->idTipoNivelEducativo;
				$model['tipoNivelEducativo'] =$listado->tipoNivelEducativo;
		
	
				array_push($dtReturn, $model);
			}
		}
		return $dtReturn;
	}

	//=======================================================================================
	//FUNCIONES BASE DE DATOS
	//=======================================================================================

	private function fncListarRegistrosBD($id = -1)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			tne.id_tipo_nivel_educativo,
			tne.tipo_nivel_educativo
		FROM
			escalafon.tipo_nivel_educativo AS tne
		WHERE (:id_tipo_nivel_educativo = -1 OR id_tipo_nivel_educativo = :id_tipo_nivel_educativo)
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_tipo_nivel_educativo', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new TipoNivelEducativo;
				$temp->idTipoNivelEducativo 	= $datos['id_tipo_nivel_educativo'];
				$temp->tipoNivelEducativo 		= $datos['tipo_nivel_educativo'];
		



				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}


} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom

?>