<?php
require_once '../../App/Escalafon/Models/Contingencia.php';
require_once '../../App/Config/control.php';

class ContingenciaController extends Contingencia
{
	//=======================================================================================
	//FUNCIONES LOGICA
	//=======================================================================================

	public function fncListarRegistros($id = -1)
	{

		$dtReturn = array();
		if ($id=='') { $id=-1; }
		$dtListado = $this->fncListarRegistrosBD($id);

		if (fncGeneralValidarDataArray($dtListado)) {
			foreach ($dtListado as $listado) {

				$model = array();

				$model['idContingencia'] = $listado->idContingencia;
				$model['contingencia'] = $listado->contingencia;
			


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
		SELECT * FROM escalafon.contingencia
		WHERE (:id_contigencia = -1 OR id_contigencia = :id_contigencia)
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_contigencia', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new Contingencia;
				$temp->idContingencia 	    = $datos['id_contigencia'];
				$temp->contingencia 		= $datos['contingencia'];
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}


} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom
