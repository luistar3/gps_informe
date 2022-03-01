<?php
require_once '../../App/Escalafon/Models/TipoCondicionNivelEducativo.php';
require_once '../../App/Config/control.php';

class TipoCondicionNivelEducativoController extends TipoCondicionNivelEducativo
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
				
				$model['idTipoCondicionNivelEducativo'] = $listado->idTipoCondicionNivelEducativo;
				$model['tipoCondicionNivelEducativo'] =$listado->tipoCondicionNivelEducativo;
		
	
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
		$query = '		SELECT
			tcne.id_tipo_condicion_nivel_educativo,
			tcne.tipo_condicion_nivel_educativo
		FROM
		escalafon.tipo_condicion_nivel_educativo AS tcne
		WHERE (:id_tipo_condicion_nivel_educativo = -1 OR tcne.id_tipo_condicion_nivel_educativo = :id_tipo_condicion_nivel_educativo)
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_tipo_condicion_nivel_educativo', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new TipoCondicionNivelEducativo;
				$temp->idTipoCondicionNivelEducativo 	= $datos['id_tipo_condicion_nivel_educativo'];
				$temp->tipoCondicionNivelEducativo 		= $datos['tipo_condicion_nivel_educativo'];
		



				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}


} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom

?>