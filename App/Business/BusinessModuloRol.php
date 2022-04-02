<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Config/coneccion.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Models/ModuloRol.php');


class BusinessModuloRol extends ModuloRol
{
	
	public function fncListarRegistrosBD($id = -1)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {
			$sql = "
			SELECT
				gmr.idModuloRol,
				gmr.idModulo,
				gmr.idRol,
				gmr.estado,
				gmr.created_at,
				gmr.updated_at		
			FROM
				gps_modulo_rol AS gmr
						
			WHERE gmr.estado = 1 AND (:idModuloRol = -1 OR gmr.idModuloRol = :idModuloRol)";
		
		//$connectionstatus->prepare($sql);
		//$arrayReturn = array();
		$statement = $connectionstatus->prepare($sql);
		$arrayReturn = array();
			//$result = mysqli_query($connectionstatus, $sql);
			if ($statement != false){
				$statement->bindParam('idModuloRol', $id);
				//var_dump($statement);
				$statement->execute();
				while ($datos = $datos = $statement->fetch(PDO::FETCH_ASSOC)) {
					$temp = new ModuloRol;
					$temp->idModuloRol	= $datos['idModuloRol'];
					$temp->idModulo		= $datos["idModulo"];
					$temp->idRol		= $datos["idRol"];
					$temp->estado		= $datos["estado"];					
					$temp->createdAt	= $datos["created_at"];	
					$temp->updatedAt	= $datos["updated_at"];	
					array_push($arrayReturn, $temp);
					unset($temp);
				}
				return $arrayReturn;
				$connection->closeConnection($connectionstatus);
			} else {

				return false;
			}
		} else {
			unset($connectionstatus);
			unset($connection);
			return ('Tenemos un problema' . (mysqli_error($connectionstatus)));
		}
	}

	public function fncListarRegistrosPermisosMenuBD($id = -1)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {
			$sql = "
			SELECT
				gmr.idModuloRol,
				gmr.idRol,
				gmr.estado,
				gm.idModulo,
				gm.modulo,
				gm.descripcion,
				gm.estado
			FROM
				gps_modulo_rol AS gmr
				INNER JOIN gps_modulo AS gm
						ON gm.idModulo = gmr.idModulo
			WHERE (gmr.estado = 1 AND gm.estado =1) AND 
					gmr.idRol = (SELECT idRol FROM gps_usuario AS gu 
								WHERE gu.idUsuario = :idUsuario)";
		
		//$connectionstatus->prepare($sql);
		//$arrayReturn = array();
		$statement = $connectionstatus->prepare($sql);
		$arrayReturn = array();
			//$result = mysqli_query($connectionstatus, $sql);
			if ($statement != false){
				$statement->bindParam('idUsuario', $id);
				//var_dump($statement);
				$statement->execute();
				while ($datos = $datos = $statement->fetch(PDO::FETCH_ASSOC)) {
					$temp = new ModuloRol;
					$temp->idModuloRol	= $datos['idModuloRol'];	
					$temp->idRol		= $datos["idRol"];
					$temp->estado		= $datos["estado"];	
					$temp->idModulo		= $datos["idModulo"];
					$temp->modulo		= $datos["modulo"];
					$temp->descripcion	= $datos["descripcion"];
					array_push($arrayReturn, $temp);
					unset($temp);
				}
				return $arrayReturn;
				$connection->closeConnection($connectionstatus);
			} else {

				return false;
			}
		} else {
			unset($connectionstatus);
			unset($connection);
			return ('Tenemos un problema' . (mysqli_error($connectionstatus)));
		}
	}

	public function fncListarRegistrosModuloRolBD($id = -1)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {
			$sql = "
			SELECT
				gmr.idModuloRol,
				gmr.idModulo,
				gmr.idRol,
				gmr.estado,
				gmr.created_at,
				gmr.updated_at		
			FROM
				gps_modulo_rol AS gmr
						
			WHERE (:idRol = -1 OR gmr.idRol = :idRol)";
		
		//$connectionstatus->prepare($sql);
		//$arrayReturn = array();
		$statement = $connectionstatus->prepare($sql);
		$arrayReturn = array();
			//$result = mysqli_query($connectionstatus, $sql);
			if ($statement != false){
				$statement->bindParam('idRol', $id);
				//var_dump($statement);
				$statement->execute();
				while ($datos = $datos = $statement->fetch(PDO::FETCH_ASSOC)) {
					$temp = new ModuloRol;
					$temp->idModuloRol	= $datos['idModuloRol'];
					$temp->idModulo		= $datos["idModulo"];
					$temp->idRol		= $datos["idRol"];
					$temp->estado		= $datos["estado"];					
					$temp->createdAt	= $datos["created_at"];	
					$temp->updatedAt	= $datos["updated_at"];	
					array_push($arrayReturn, $temp);
					unset($temp);
				}
				return $arrayReturn;
				$connection->closeConnection($connectionstatus);
			} else {

				return false;
			}
		} else {
			unset($connectionstatus);
			unset($connection);
			return ('Tenemos un problema' . (mysqli_error($connectionstatus)));
		}
	}

}
