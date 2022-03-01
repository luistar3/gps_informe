<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/gps/App/Config/coneccion.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/gps/App/Models/Vehiculo.php');


class BusinessVehiculo extends Vehiculo
{
	public function fncListarRegistrosBD()
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {

			$sql = "
			SELECT
				gv.idVehiculo,
				gv.idMarcaVehiculo,
				gmv.marca,
				gv.placa,
				gv.modelo,			
				gv.estado,
				gv.anio,
				gv.gps,
				gv.imei,
				gv.created_at
				
			FROM
				gps_vehiculo AS gv
				INNER JOIN gps_marca_vehiculo AS gmv
						ON gmv.idMarcaVehiculo = gv.idMarcaVehiculo";


			$statement = $connectionstatus->prepare($sql);
			$arrayReturn = array();
			if ($statement != false) {
				$statement->execute();
				while ($datos = $datos = $statement->fetch(PDO::FETCH_ASSOC)) {
					$temp = new Vehiculo;
					$temp->idVehiculo		= $datos['idVehiculo'];
					$temp->idMarcaVehiculo	= $datos["idMarcaVehiculo"];
					$temp->marca		= $datos["marca"];
					$temp->placa			= $datos["placa"];
					$temp->modelo	= $datos["modelo"];
					$temp->anio		= $datos["anio"];
					$temp->gps	= $datos["gps"];
					$temp->imei	= $datos["imei"];
					$temp->estado	= $datos["estado"];
					$temp->createdAt	= $datos["created_at"];
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
			return false;
		}
	}


	// public function fncObtenerRegistroRucBD($ruc)
	// {
	// 	$connection = new connection();
	// 	$connectionstatus = $connection->openConnection();
	// 	if ($connectionstatus) {

	// 		$sql = "
	// 		SELECT
	// 			gj.idJuridico,
	// 			gj.razonSocial,
	// 			gj.ruc,
	// 			gj.correo,
	// 			gj.idRepresentanteLegal,
	// 			gj.created_at,
	// 			gj.updated_at
	// 		FROM
	// 			gps_juridico AS gj

	// 		WHERE gj.ruc = :ruc";

	// 		//$connectionstatus->prepare($sql);
	// 		//$arrayReturn = array();
	// 		$statement = $connectionstatus->prepare($sql);
	// 		$arrayReturn = array();
	// 		//$result = mysqli_query($connectionstatus, $sql);
	// 		$juridico = new Juridico;
	// 		if ($statement != false) {
	// 			$statement->bindParam('ruc', $ruc);
	// 			$statement->execute();

	// 			if (!$registro = $statement->fetch(PDO::FETCH_ASSOC)) {
	// 				return false;
	// 			}
	// 			$juridico->idJuridico		= $registro['idJuridico'];
	// 			$juridico->razonSocial		= $registro['razonSocial'];
	// 			$juridico->ruc	= $registro["ruc"];
	// 			$juridico->correo		= $registro["correo"];
	// 			$juridico->idRepresentanteLegal			= $registro["idRepresentanteLegal"];
	// 			$juridico->created_at	= $registro["created_at"];
	// 			$juridico->updated_at		= $registro["updated_at"];

	// 			return $juridico;
	// 			$connection->closeConnection($connectionstatus);
	// 		} else {

	// 			return false;
	// 		}
	// 	} else {
	// 		unset($connectionstatus);
	// 		unset($connection);
	// 		return false;
	// 	}
	// }


	public function fncGuardarBD(Vehiculo $vehiculo)
	{
		//var_dump($vehiculo);
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {
			$sql = "
			INSERT INTO gps_vehiculo
			(			
				idMarcaVehiculo,
				placa,
				modelo,
				anio,
				gps,
				imei
			
			)
			VALUES
			(
				:idMarcaVehiculo,
				:placa,
				:modelo,
				:anio,
				:gps,
				:imei
			
			)
			ON DUPLICATE KEY  UPDATE idVehiculo=LAST_INSERT_ID(idVehiculo), estado = 1 ,updated_at = now();
			alter table gps_vehiculo AUTO_INCREMENT = 0;
			";

			$statement = $connectionstatus->prepare($sql);

			if ($statement != false) {
				$statement->bindParam("idMarcaVehiculo", $vehiculo->idMarcaVehiculo);
				$statement->bindParam("placa", $vehiculo->placa);
				$statement->bindParam("modelo", $vehiculo->modelo);
				$statement->bindParam("anio", $vehiculo->anio);
				$statement->bindParam("gps", $vehiculo->gps);
				$statement->bindParam("imei", $vehiculo->imei);

				$alerta = $statement->execute();
				$connection->closeConnection($connectionstatus);
				$id = $connectionstatus->lastInsertId();
				$vehiculo->idVehiculo = $id;
				return $vehiculo;
			}
		} else {
			unset($connectionstatus);
			unset($connection);
			return false;
		}
	}


	public function fncActualizarBD(Vehiculo $vehiculo)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		$bolReturn = false;
		if ($connectionstatus) {
			$sql = ' 
			UPDATE gps_vehiculo
			SET
				
				idMarcaVehiculo = :idMarcaVehiculo,
				modelo = :modelo,
				anio = :anio,
				gps = :gps,
				imei = :imei,
				updated_at = now()
				
			WHERE idVehiculo = 	:idVehiculo
					
		';
			$statement = $connectionstatus->prepare($sql);

			if ($statement != false) {
				$statement->bindParam("idVehiculo", $vehiculo->idVehiculo);
				$statement->bindParam("idMarcaVehiculo", $vehiculo->idMarcaVehiculo);
				$statement->bindParam("anio", $vehiculo->anio);
				$statement->bindParam("modelo", $vehiculo->modelo);
				$statement->bindParam("gps", $vehiculo->gps);
				$statement->bindParam("imei", $vehiculo->imei);
				$statement->execute();
				$connection->closeConnection($connectionstatus);
				if (($statement->rowCount()) != 0) {
					return $vehiculo;
				}
			}
		}
		return $bolReturn;
	}
	public function fncDeshabilitarBD(Vehiculo $vehiculo)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		$bolReturn = false;
		if ($connectionstatus) {
			$sql = ' 
			UPDATE gps_vehiculo
			SET								
				estado = :estado,
				updated_at = now()				
			WHERE idVehiculo = 	:idVehiculo
					
		';
			$statement = $connectionstatus->prepare($sql);

			if ($statement != false) {
				$statement->bindParam("idVehiculo", $vehiculo->idVehiculo);
				$statement->bindParam("estado", $vehiculo->estado);
				$statement->execute();
				$connection->closeConnection($connectionstatus);
				if (($statement->rowCount()) != 0) {
					return $vehiculo;
				}
			}
		}
		return $bolReturn;
	}
}
