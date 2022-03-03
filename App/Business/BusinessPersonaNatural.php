<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/gps/App/Config/coneccion.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/gps/App/Models/PersonaNatural.php');


class BusinessPersonaNatural extends PersonaNatural
{
	public function fncListarRegistrosBD($id = -1)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {

			$sql = "
			SELECT
				gpn.idPersona,
				gpn.nombres,
				gpn.apellidos,
				gpn.telefono,
				gpn.dni,
				gpn.direccion,
				gpn.correo,
				gpn.created_at,
				gpn.updated_at
			FROM
				gps_persona_natural AS gpn WHERE (:idPersona = -1 OR gpn.idPersona = :idPersona)";

			//$connectionstatus->prepare($sql);
			//$arrayReturn = array();
			$statement = $connectionstatus->prepare($sql);
			$arrayReturn = array();
			//$result = mysqli_query($connectionstatus, $sql);

			if ($statement != false) {
				$statement->bindParam('idPersona', $id);
				$statement->execute();
				while ($datos = $datos = $statement->fetch(PDO::FETCH_ASSOC)) {
					$temp = new PersonaNatural;
					$temp->idPersona		= $datos['idPersona'];
					$temp->nombres		= $datos['nombres'];
					$temp->apellidos	= $datos["apellidos"];
					$temp->telefono		= $datos["telefono"];
					$temp->dni			= $datos["dni"];
					$temp->direccion	= $datos["direccion"];
					$temp->correo		= $datos["correo"];
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


	public function fncListarRegistrosParaClienteBD()
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {

			$sql = "
			SELECT
				gpn.idPersona,
				gpn.nombres,
				gpn.apellidos,
				gpn.telefono,
				gpn.dni,
				gpn.direccion,
				gpn.correo,
				gpn.created_at,
				gpn.updated_at
		FROM
				gps_persona_natural AS gpn WHERE gpn.idPersona NOT IN (SELECT
			
			gc.idPersona
		FROM
			gps_cliente AS gc WHERE gc.idPersona is NOT NULL and gc.estado = 1 )";

			//$connectionstatus->prepare($sql);
			//$arrayReturn = array();
			$statement = $connectionstatus->prepare($sql);
			$arrayReturn = array();
			//$result = mysqli_query($connectionstatus, $sql);

			if ($statement != false) {
				$statement->bindParam('idPersona', $id);
				$statement->execute();
				while ($datos = $datos = $statement->fetch(PDO::FETCH_ASSOC)) {
					$temp = new PersonaNatural;
					$temp->idPersona		= $datos['idPersona'];
					$temp->nombres		= $datos['nombres'];
					$temp->apellidos	= $datos["apellidos"];
					$temp->telefono		= $datos["telefono"];
					$temp->dni			= $datos["dni"];
					$temp->direccion	= $datos["direccion"];
					$temp->correo		= $datos["correo"];
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

	
	public function fncListarRegistrosParaAgregarUsuarioBD()
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {

			$sql = "					
			SELECT
			gpn.idPersona,
			upper(gpn.nombres) as 'nombres',
			upper(gpn.apellidos) as 'apellidos',
			gpn.telefono,
			gpn.dni,
			upper(gpn.direccion) as 'direccion',
			gpn.correo,
			gpn.created_at,
			gpn.updated_at
			FROM
			gps_persona_natural AS gpn
			WHERE gpn.idPersona NOT IN (SELECT gu.idUsuario FROM gps_usuario AS gu )";

			//$connectionstatus->prepare($sql);
			//$arrayReturn = array();
			$statement = $connectionstatus->prepare($sql);
			$arrayReturn = array();
			//$result = mysqli_query($connectionstatus, $sql);

			if ($statement != false) {
				$statement->execute();
				while ($datos = $datos = $statement->fetch(PDO::FETCH_ASSOC)) {
					$temp = new PersonaNatural;
					$temp->idPersona		= $datos['idPersona'];
					$temp->nombres		= $datos['nombres'];
					$temp->apellidos	= $datos["apellidos"];
					$temp->telefono		= $datos["telefono"];
					$temp->dni			= $datos["dni"];
					$temp->direccion	= $datos["direccion"];
					$temp->correo		= $datos["correo"];
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



	public function fncObtenerRegistroDniBD($dni)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {

			$sql = "
			SELECT
				gpn.idPersona,
				gpn.nombres,
				gpn.apellidos,
				gpn.telefono,
				gpn.dni,
				gpn.direccion,
				gpn.correo,
				gpn.created_at,
				gpn.updated_at
			FROM
				gps_persona_natural AS gpn WHERE gpn.dni = :dni";

			//$connectionstatus->prepare($sql);
			//$arrayReturn = array();
			$statement = $connectionstatus->prepare($sql);
			$arrayReturn = array();
			//$result = mysqli_query($connectionstatus, $sql);
			$personaNatural = new PersonaNatural;
			if ($statement != false) {
				$statement->bindParam('dni', $dni);
				$statement->execute();

				if (!$registro = $statement->fetch(PDO::FETCH_ASSOC)) {
					return false;
				}
				$personaNatural->idPersona		= $registro['idPersona'];
				$personaNatural->nombres		= $registro['nombres'];
				$personaNatural->apellidos	= $registro["apellidos"];
				$personaNatural->telefono		= $registro["telefono"];
				$personaNatural->dni			= $registro["dni"];
				$personaNatural->direccion	= $registro["direccion"];
				$personaNatural->correo		= $registro["correo"];
				$personaNatural->createdAt	= $registro["created_at"];
				$personaNatural->updatedAt	= $registro["updated_at"];
				return $personaNatural;
				$connection->closeConnection($connectionstatus);
			} else {

				return false;
			}
		} else {
			unset($connectionstatus);
			unset($connection);
			return false;
		}
	}

	public function fncGuardarBD(PersonaNatural $personaNatural)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {
			$sql = "
			INSERT INTO gps_persona_natural
			(
				
				nombres,
				apellidos,
				telefono,
				dni,
				direccion,
				correo
			)
			VALUES
			(
				:nombres ,
				:apellidos ,
				:telefono ,
				:dni ,
				:direccion ,
				:correo 
			
			)
			";
			
			$statement = $connectionstatus->prepare($sql);

			if ($statement != false) {
				$statement->bindParam("nombres", $personaNatural->nombres);
				$statement->bindParam("apellidos", $personaNatural->apellidos);
				$statement->bindParam("telefono", $personaNatural->telefono);
				$statement->bindParam("dni", $personaNatural->dni);
				$statement->bindParam("direccion", $personaNatural->direccion);
				$statement->bindParam("correo", $personaNatural->correo);

				$statement->execute();
				$connection->closeConnection($connectionstatus);
				$id=$connectionstatus->lastInsertId();
				$personaNatural->idPersona=$id;				
				return $personaNatural;
			}
		} else {
			unset($connectionstatus);
			unset($connection);
			return false;
		}
	}

	public function fncActualizarBD(PersonaNatural $personaNatural)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		$bolReturn = false;
		if ($connectionstatus) {
			$sql = ' 
			UPDATE gps_persona_natural
			SET
				
				nombres = :nombres,
				apellidos = :apellidos,
				telefono = :telefono,			
				direccion = :direccion,
				correo = :correo,
				updated_at = now()
			WHERE idPersona = :idPersona
		
		';
			$statement = $connectionstatus->prepare($sql);

			if ($statement != false) {
				$statement->bindParam("idPersona", $personaNatural->idPersona);
				$statement->bindParam("nombres", $personaNatural->nombres);
				$statement->bindParam("apellidos", $personaNatural->apellidos);	
				$statement->bindParam("telefono", $personaNatural->telefono);					
				$statement->bindParam("direccion", $personaNatural->direccion);	
				$statement->bindParam("correo", $personaNatural->correo);	
				$statement->execute();
				$error = ($statement->errorInfo());
				$connection->closeConnection($connectionstatus);
				if (($statement->rowCount()) != 0) {
					return $personaNatural;
				}
			}
		}
		return $bolReturn;
	}
}
