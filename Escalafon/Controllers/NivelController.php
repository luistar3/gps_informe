<?php
require_once '../../App/Escalafon/Models/Nivel.php';
require_once '../../App/Config/control.php';

class NivelController extends Nivel
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

				$model['idNivel'] 	= $listado->idNivel;
				$model['denom'] 	= $listado->denom;
				$model['remniv'] 	= $listado->remniv;
				$model['selniv'] 	= $listado->selniv;
				$model['orden'] 	= $listado->orden;
				$model['tiptrrab']	= $listado->tiptrrap;

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
		SELECT * FROM escalafon.nivel
		WHERE (:id_nivel = -1 OR id_nivel = :id_nivel)
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_nivel', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new Nivel;
				$temp->idNivel 	= $datos['id_nivel'];
				$temp->denom 		= $datos['denom'];
				$temp->remniv 	= $datos['remniv'];
				$temp->selniv	= $datos['selniv'];
				$temp->orden	= $datos['orden'];
				$temp->tiptrrap	= $datos['tiptrrab'];



				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}


} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom

?>