<?php
require_once '../../App/Escalafon/Models/SituacionLaboral.php';
require_once '../../App/Config/control.php';

class situacionLaboralController extends SituacionLaboral
{
	//=======================================================================================
	//FUNCIONES LOGICA
	//=======================================================================================

	public function fncListarRegistros($id = -1)
	{

		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosBD($id);

		if (fncGeneralValidarDataArray($dtListado)) {
			foreach ($dtListado as $listado) {

				$model = array();

				$model['idSituacionLaboral'] 	= $listado->idSituacionLaboral;
				$model['situacionLaboral'] 	= $listado->situacionLaboral;

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
			sl.id_situacion_laboral,
			sl.situacion_laboral
		FROM
			escalafon.situacion_laboral AS sl
		WHERE (:id_situacion_laboral = -1 OR id_situacion_laboral = :id_situacion_laboral)
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_situacion_laboral', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new SituacionLaboral;
				$temp->idSituacionLaboral 	= $datos['id_situacion_laboral'];
				$temp->situacionLaboral 	= $datos['situacion_laboral'];
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}


} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom

?>