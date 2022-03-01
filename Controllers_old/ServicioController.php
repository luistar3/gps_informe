<?php
require_once '../../App/Escalafon/Models/Servicio.php';
require_once '../../App/Config/control.php';

class ServicioController extends Servicio
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

				$model['idServicio'] = $listado->idServicio;
				$model['servicio'] = $listado->servicio;
			


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
		SELECT * FROM escalafon.servicio
		WHERE (:id_servicio = -1 OR id_servicio = :id_servicio)
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_servicio', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new Servicio;
				$temp->idServicio 	    = $datos['id_servicio'];
				$temp->servicio 		= $datos['servicio'];
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}


} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom
