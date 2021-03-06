<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/gps/App/Config/coneccion.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/gps/App/Models/ModuloRol.php');


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
			if ($statement != false) {
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

	public function fncObtenerPorIdRolIdModuloBD(ModuloRol $moduloRol)
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
						
			WHERE gmr.idModulo = :idModulo AND gmr.idRol = :idRol";

			$statement = $connectionstatus->prepare($sql);

			//$moduloRol = new ModuloRol;
			if ($statement != false) {
				$statement->bindParam('idModulo', $moduloRol->idModulo);
				$statement->bindParam('idRol', $moduloRol->idRol);
				//var_dump($statement);
				$statement->execute();
				if (!$registro = $statement->fetch(PDO::FETCH_ASSOC)) {
					return false;
				}
				$moduloRol->idCliente		= $registro['idCliente'];
				$moduloRol->idPersona		= $registro['idModuloRol'];
				$moduloRol->idJuridico	= $registro["idModulo"];
				$moduloRol->ultimoPago	= $registro["idRol"];
				$moduloRol->estado		= $registro["estado"];
				$moduloRol->createdAt		= $registro["created_at"];
				$moduloRol->deletedAt		= $registro["updated_at"];
				$connection->closeConnection($connectionstatus);
				return $moduloRol;
				
			} else {

				return false;
			}
		} else {
			unset($connectionstatus);
			unset($connection);
			return false;
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
			if ($statement != false) {
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
			if ($statement != false) {
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

	public function fncModificarModuloRolBD(ModuloRol $moduloRol)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		$bolReturn = false;
		if ($connectionstatus) {
			$sql = ' 
			UPDATE gps_modulo_rol
			SET								
				estado = :estado,
				updated_at = now()				
			WHERE idRol = :idRol AND idModulo = :idModulo
					
		';
			$statement = $connectionstatus->prepare($sql);

			if ($statement != false) {
				$statement->bindParam("idRol", $moduloRol->idRol);
				$statement->bindParam("idModulo", $moduloRol->idModulo);
				$statement->bindParam("estado", $moduloRol->estado);
				$statement->execute();
				$connection->closeConnection($connectionstatus);
				$error = ($statement->errorInfo());
				$rowCount = ($statement->rowCount());
				if (($statement->rowCount()) != 0) {
					return $moduloRol;
				}
			}
		}
		return $bolReturn;
	}

	public function fncGuardarBD(ModuloRol $moduloRol)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {
			$sql = "
			INSERT INTO gps_modulo_rol
			(
				idModulo,
				idRol,
				estado,
				created_at
			)
			VALUES
			(
				:idModulo,
				:idRol,
				:estado,
				now()
			)
			";

			$statement = $connectionstatus->prepare($sql);

			if ($statement != false) {
				$statement->bindParam("idRol", $moduloRol->idRol);
				$statement->bindParam("idModulo", $moduloRol->idModulo);
				$statement->bindParam("estado", $moduloRol->estado);
				$statement->execute();
				$connection->closeConnection($connectionstatus);
				$error = ($statement->errorInfo());
				$id = $connectionstatus->lastInsertId();
				if ($id == 0) {
					return false;
				}
				$moduloRol->idModuloRol = $id;
				return $moduloRol;
			}
		} else {
			unset($connectionstatus);
			unset($connection);
			return false;
		}
	}
}
