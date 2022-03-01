<?php
require_once '../../App/Escalafon/Models/Area.php';
require_once '../../App/Config/control.php';

class AreaController extends Area
{
//=======================================================================================
// FUNCIONES LOGICA
//=======================================================================================
	public function fncListarRegistros($id = -1)
	{
		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosBD($id);
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
				$model = array();
				$model['id_area'] = $listado->idArea;
				$model['id_padre'] = $listado->idPadre;
				$model['id_tipo_area'] = $listado->idTipoArea;
				$model['nombre_area'] = $listado->nombreArea;
				$model['sigla'] = $listado->sigla;
				$model['nivel'] = $listado->nivel;
				$model['descripcion'] = $listado->descripcion;
				$model['estado'] = $listado->estado;
				array_push($dtReturn, $model);
				unset($model);
			}
		}
		return $dtReturn;
	}

	public function fncListarRegistrosDesplazamiento($id = -1)
	{
		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosBD($id);
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
				$model = array();
				$model['idArea'] = $listado->idArea;
				$model['idAadre'] = $listado->idPadre;
				$model['idTipoArea'] = $listado->idTipoArea;
				$model['nombreArea'] = $listado->nombreArea;
				$model['sigla'] = $listado->sigla;
				$model['nivel'] = $listado->nivel;
				$model['descripcion'] = $listado->descripcion;
				$model['estado'] = $listado->estado;
				array_push($dtReturn, $model);
				unset($model);
			}
		}
		return $dtReturn;
	}


	public function fncListarRegistrosActivos($id = -1)
	{
		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosActivosBD($id);
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
				$model = array();
				$model['id_area'] = $listado->idArea;
				$model['id_padre'] = $listado->idPadre;
				$model['id_tipo_area'] = $listado->idTipoArea;
				$model['nombre_area'] = $listado->nombreArea;
				$model['sigla'] = $listado->sigla;
				$model['nivel'] = $listado->nivel;
				$model['descripcion'] = $listado->descripcion;
				array_push($dtReturn, $model);
				unset($model);
			}
		}
		return $dtReturn;
	}

	public function fncListarRegistrosParaInspeccion($id = -1)
	{
		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosParaInspeccionBD($id);
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
				$model = array();
				$model['id_area'] = $listado->idArea;
				$model['id_padre'] = $listado->idPadre;
				$model['id_tipo_area'] = $listado->idTipoArea;
				$model['nombre_area'] = $listado->nombreArea;
				$model['sigla'] = $listado->sigla;
				$model['nivel'] = $listado->nivel;
				$model['descripcion'] = $listado->descripcion;
				array_push($dtReturn, $model);
				unset($model);
			}
		}
		return $dtReturn;
	}

	public function fncListarRegistrosMP()
	{
		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosMPBD();
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
				$model = array();
				$model['idArea'] = $listado->idArea;
				$model['nombreArea'] = $listado->nombreArea;
				//$model['descripcionDireccion'] = $listado->descripcionDireccion;
				//$model['estado'] = $listado->estado;
				//$model['fechaCreacion'] = fncValidarFormatearFecha($listado->fechaCreacion);
				array_push($dtReturn, $model);
				unset($model);
			}
		}
		return $dtReturn;
	}

	public function fncListarRegistrosMC($id)
	{
		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosMCBD($id);
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
				$model = array();
				$model['idArea'] = $listado->idArea;
				$model['nombreArea'] = $listado->nombreArea;
				//$model['descripcionDireccion'] = $listado->descripcionDireccion;
				//$model['estado'] = $listado->estado;
				//$model['fechaCreacion'] = fncValidarFormatearFecha($listado->fechaCreacion);
				array_push($dtReturn, $model);
				unset($model);
			}
		}
		return $dtReturn;
	}
//=======================================================================================
// FUNCIONES BASE DE DATOS
//=======================================================================================
	private function fncListarRegistrosBD( $id = -1 )
	{
		$sql = cls_control::get_instancia();
		$query = "SELECT * FROM escalafon.area WHERE (:id_area = -1 OR id_area = :id_area)";
		$statement = $sql->preparar( $query );
		$arrayReturn = array();
		if( $statement!=false ){
			$statement->bindParam('id_area', $id);
			$sql->ejecutar();
			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
				$temp = new Area;
				$temp->idArea = $datos['id_area'];
				$temp->idPadre = $datos['id_padre'];
				$temp->idTipoArea = $datos['id_tipo_area'];
				$temp->nombreArea = $datos['nombre_area'];
				$temp->sigla = $datos['sigla'];
				$temp->nivel = $datos['nivel'];
				$temp->descripcion = $datos['descripcion'];
				$temp->estado	= $datos['estado'];
				array_push( $arrayReturn, $temp );
				unset($temp);
			}
		}
		return $arrayReturn;
	}

	private function fncListarRegistrosActivosBD( $id = -1 )
	{
		$sql = cls_control::get_instancia();
		$query = "SELECT * FROM escalafon.area WHERE estado='A' AND id_area<>2 AND (:id_area = -1 OR id_area = :id_area) ORDER BY id_area ASC";
		$statement = $sql->preparar( $query );
		$arrayReturn = array();
		if( $statement!=false ){
			$statement->bindParam('id_area', $id);
			$sql->ejecutar();
			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
				$temp = new Area;
				$temp->idArea = $datos['id_area'];
				$temp->idPadre = $datos['id_padre'];
				$temp->idTipoArea = $datos['id_tipo_area'];
				$temp->nombreArea = $datos['nombre_area'];
				$temp->sigla = $datos['sigla'];
				$temp->nivel = $datos['nivel'];
				$temp->descripcion = $datos['descripcion'];
				array_push( $arrayReturn, $temp );
				unset($temp);
			}
		}
		return $arrayReturn;
	}

	private function fncListarRegistrosParaInspeccionBD( $id = -1 )
	{
		$sql = cls_control::get_instancia();
		$query = "SELECT * FROM escalafon.area WHERE estado='A' AND (id_area>=16 AND id_area<=22) AND (:id_area = -1 OR id_area = :id_area) ORDER BY id_area ASC";
		$statement = $sql->preparar( $query );
		$arrayReturn = array();
		if( $statement!=false ){
			$statement->bindParam('id_area', $id);
			$sql->ejecutar();
			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
				$temp = new Area;
				$temp->idArea = $datos['id_area'];
				$temp->idPadre = $datos['id_padre'];
				$temp->idTipoArea = $datos['id_tipo_area'];
				$temp->nombreArea = $datos['nombre_area'];
				$temp->sigla = $datos['sigla'];
				$temp->nivel = $datos['nivel'];
				$temp->descripcion = $datos['descripcion'];
				array_push( $arrayReturn, $temp );
				unset($temp);
			}
		}
		return $arrayReturn;
	}

	private function fncListarRegistrosMPBD()
	{
		/*$query = 'SELECT 
		id_area,
		nombre_area,
		estado,
		fecha_creacion
		FROM escalafon.area 
		WHERE (:id_area = -1 OR id_area = :id_area)';*/
		$sql = cls_control::get_instancia();		
		$query = "SELECT 
								id_area,
								id_padre,
								id_tipo_area,
								nombre_area
							FROM escalafon.area 
							WHERE id_padre=1 AND (id_tipo_area=4 OR id_tipo_area=3 OR id_tipo_area=5)";
		$statement = $sql->preparar( $query );
		$arrayReturn = array();
		if( $statement!=false ){
			$sql->ejecutar();
			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
				$temp = new Area;
				$temp->idArea = $datos['id_area'];
				$temp->nombreArea = $datos['nombre_area'];
				array_push( $arrayReturn, $temp );
				unset($temp);
			}
		}
		return $arrayReturn;
	}
	
	private function fncListarRegistrosMCBD($id)
	{
		/*$query = 'SELECT 
		id_area,
		nombre_area,
		estado,
		fecha_creacion
		FROM escalafon.area 
		WHERE (:id_area = -1 OR id_area = :id_area)';*/
		$sql = cls_control::get_instancia();
		$query = "SELECT 
								id_area,
								id_padre,
								id_tipo_area,
								nombre_area
							FROM escalafon.area 
							WHERE id_padre = :idPadre";
		$statement = $sql->preparar( $query );
		$arrayReturn = array();
		if( $statement!=false ){
			$statement->bindParam('idPadre',$id);
			$sql->ejecutar();
			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
				$temp = new Area;
				$temp->idArea = $datos['id_area'];
				$temp->nombreArea = $datos['nombre_area'];
				array_push( $arrayReturn, $temp );
				unset($temp);
			}
		}
		return $arrayReturn;
	}
}