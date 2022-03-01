<?php
require_once '../../App/Escalafon/Models/Cargo.php';
require_once '../../App/Config/control.php';

class CargoController extends Cargo
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

				$model['idCargo'] = $listado->idCargo;
				$model['nombreCargo'] = $listado->nombreCargo;
				$model['salarioMinimo'] = $listado->salarioMinimo;
				$model['salarioMaximo'] = $listado->salarioMaximo;


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
		SELECT * FROM escalafon.cargo
		WHERE (:id_cargo = -1 OR id_cargo = :id_cargo)
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_cargo', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new Cargo;
				$temp->idCargo 	        = $datos['id_cargo'];
				$temp->nombreCargo 		= $datos['nombre_cargo'];
				$temp->salarioMinimo 	= $datos['salario_minimo'];
				$temp->salarioMaximo	= $datos['salario_maximo'];




				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}


} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom
