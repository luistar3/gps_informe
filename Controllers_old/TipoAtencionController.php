<?php
require_once '../../App/Escalafon/Models/TipoAtencion.php';
require_once '../../App/Config/control.php';

class TipoAtencionController extends TipoAtencion
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

				$model['idTipoAtencion'] = $listado->idTipoAtencion;
				$model['tipoAtencion'] = $listado->tipoAtencion;
			


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
		SELECT * FROM escalafon.tipo_atencion
		WHERE (:id_tipo_atencion = -1 OR id_tipo_atencion = :id_tipo_atencion)
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_tipo_atencion', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new TipoAtencion;
				$temp->idTipoAtencion 	    = $datos['id_tipo_atencion'];
				$temp->tipoAtencion 		= $datos['tipo_atencion'];
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}


} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom
