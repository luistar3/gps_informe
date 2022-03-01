<?php
require_once '../../App/Escalafon/Models/TipoNivelEspecializacion.php';
require_once '../../App/Config/control.php';

class TipoNivelEspecializacionController extends TipoNivelEspecializacion
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
				
				$model['idTipoNivelEspecializacion'] = $listado->idTipoNivelEspecializacion;
				$model['tipoNivelEspecializacion'] =$listado->tipoNivelEspecializacion;
		
	
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
			tne.id_tipo_nivel_especializacion,
			tne.tipo_nivel_especializacion
		FROM
			escalafon.tipo_nivel_especializacion AS tne
		WHERE (:id_tipo_nivel_especializacion = -1 OR id_tipo_nivel_especializacion = :id_tipo_nivel_especializacion)
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_tipo_nivel_especializacion', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new TipoNivelEspecializacion;
				$temp->idTipoNivelEspecializacion 	= $datos['id_tipo_nivel_especializacion'];
				$temp->tipoNivelEspecializacion 		= $datos['tipo_nivel_especializacion'];
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}


} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom

?>