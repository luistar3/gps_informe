<?php
require_once '../../App/Escalafon/Models/TipoTrabajador.php';
require_once '../../App/Config/control.php';

class TipoTrabajadorController extends TipoTrabajador
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
				
				$model['idTipoTrabajador'] = $listado->idTipoTrabajador;
				$model['tipoTrabajador'] =$listado->tipoTrabajador;

	
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
		$query = '
		SELECT * FROM escalafon.tipo_trabajador
		WHERE (:id_tipo_trabajador = -1 OR id_tipo_trabajador = :id_tipo_trabajador)
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_tipo_trabajador', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new TipoTrabajador;
			$temp->idTipoTrabajador 	        = $datos['id_tipo_trabajador'];
			$temp->tipoTrabajador 		= $datos['tipo_trabajador'];
		


			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}


} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom

?>