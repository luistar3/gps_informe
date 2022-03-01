<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Config/coneccion.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Models/Juridico.php');


class BusinessJuridico extends Juridico
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
			gps_persona_natural AS gpn WHERE (:id = -1 OR idPersona = :id)";
		
		//$connectionstatus->prepare($sql);
		//$arrayReturn = array();
		$statement = $connectionstatus->prepare($sql);
		$arrayReturn = array();
			//$result = mysqli_query($connectionstatus, $sql);

			if ($statement != false){
				$statement->bindParam('id', $id);
				//var_dump($statement);
				$statement->execute();
				while ($datos = $datos = $statement->fetch(PDO::FETCH_ASSOC)) {
					$temp = new PersonaNatural;
					$temp->nombres		= $datos['nombres'];
					$temp->apellidos	= $datos["apellidos"];
					$temp->telefono		= $datos["telefono"];
					$temp->dni			= $datos["direccion"];
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


	public function fncListarRegistros2BD()
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {

			$sql = '
			SELECT
				gj.idJuridico,
				(		      
						SELECT
						count(1)
						FROM
							gps_contrato AS gc
						WHERE gc.idCliente = ( SELECT
							gca.idCliente	          
						FROM
							gps_cliente AS gca
							
						WHERE gca.idJuridico = gj.idJuridico) AND gc.estado = 1
					
				)AS contratos,
				gj.razonSocial,
				gj.ruc,
				gj.correo,
				gj.idRepresentanteLegal,
				UPPER(concat(gpn.nombres,\' \',gpn.apellidos)) AS nombreRepresentanteLegal,
				gj.created_at,
				gj.updated_at
			FROM
				gps_juridico AS gj
				INNER JOIN gps_persona_natural AS gpn
						ON gpn.idPersona = gj.idRepresentanteLegal	          
	         
	    
			';
		$statement = $connectionstatus->prepare($sql);
		$arrayReturn = array();

			if ($statement != false){
				$statement->execute();
				while ($datos = $datos = $statement->fetch(PDO::FETCH_ASSOC)) {
					$temp = new Juridico;
					$temp->idJuridico		= $datos['idJuridico'];
					$temp->contratos		= $datos['contratos'];
					$temp->razonSocial	= $datos["razonSocial"];
					$temp->ruc		= $datos["ruc"];
					$temp->correo			= $datos["correo"];
					$temp->idRepresentanteLegal	= $datos["idRepresentanteLegal"];
					$temp->nombreRepresentanteLegal		= $datos["nombreRepresentanteLegal"];
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
			return false;
		}
	}


	public function fncListarRegistros2ParaClienteBD()
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {

			$sql = '
			SELECT
				gj.idJuridico,
				(		      
						SELECT
						count(1)
						FROM
							gps_contrato AS gc
						WHERE gc.idCliente = ( SELECT
							gca.idCliente	          
						FROM
							gps_cliente AS gca
							
						WHERE gca.idJuridico = gj.idJuridico) AND gc.estado = 1
					
				)AS contratos,
				gj.razonSocial,
				gj.ruc,
				gj.correo,
				gj.idRepresentanteLegal,
				UPPER(concat(gpn.nombres,\' \',gpn.apellidos)) AS nombreRepresentanteLegal,
				gj.created_at,
				gj.updated_at
			FROM
				gps_juridico AS gj
				INNER JOIN gps_persona_natural AS gpn
						ON gpn.idPersona = gj.idRepresentanteLegal	          
						WHERE gj.idJuridico NOT IN (
							SELECT
							
							gc.idJuridico
							FROM
							gps_cliente AS gc WHERE gc.idJuridico is NOT NULL and gc.estado = 1 
							)
	    
			';
		$statement = $connectionstatus->prepare($sql);
		$arrayReturn = array();

			if ($statement != false){
				$statement->execute();
				while ($datos = $datos = $statement->fetch(PDO::FETCH_ASSOC)) {
					$temp = new Juridico;
					$temp->idJuridico		= $datos['idJuridico'];
					$temp->contratos		= $datos['contratos'];
					$temp->razonSocial	= $datos["razonSocial"];
					$temp->ruc		= $datos["ruc"];
					$temp->correo			= $datos["correo"];
					$temp->idRepresentanteLegal	= $datos["idRepresentanteLegal"];
					$temp->nombreRepresentanteLegal		= $datos["nombreRepresentanteLegal"];
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
			return false;
		}
	}

	


	public function fncObtenerRegistroRucBD($ruc)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {

			$sql = "
			SELECT
				gj.idJuridico,
				gj.razonSocial,
				gj.ruc,
				gj.correo,
				gj.idRepresentanteLegal,
				gj.created_at,
				gj.updated_at
			FROM
				gps_juridico AS gj
				
			WHERE gj.ruc = :ruc";

			//$connectionstatus->prepare($sql);
			//$arrayReturn = array();
			$statement = $connectionstatus->prepare($sql);
			$arrayReturn = array();
			//$result = mysqli_query($connectionstatus, $sql);
			$juridico = new Juridico;
			if ($statement != false) {
				$statement->bindParam('ruc', $ruc);
				$statement->execute();

				if (!$registro = $statement->fetch(PDO::FETCH_ASSOC)) {
					return false;
				}
				$juridico->idJuridico		= $registro['idJuridico'];
				$juridico->razonSocial		= $registro['razonSocial'];
				$juridico->ruc	= $registro["ruc"];
				$juridico->correo		= $registro["correo"];
				$juridico->idRepresentanteLegal			= $registro["idRepresentanteLegal"];
				$juridico->created_at	= $registro["created_at"];
				$juridico->updated_at		= $registro["updated_at"];

				return $juridico;
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

	
	public function fncGuardarBD(Juridico $juridico)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {
			$sql = "
			INSERT INTO gps_juridico
			(	
				razonSocial,
				ruc,
				correo,
				idRepresentanteLegal
			)
			VALUES
			(
				:razonSocial,
				:ruc,
				:correo,
				:idRepresentanteLegal
			)
			";
			
			$statement = $connectionstatus->prepare($sql);

			if ($statement != false) {
				$statement->bindParam("razonSocial", $juridico->razonSocial);
				$statement->bindParam("ruc", $juridico->ruc);
				$statement->bindParam("correo", $juridico->correo);
				$statement->bindParam("idRepresentanteLegal", $juridico->idRepresentanteLegal);

				$statement->execute();
				$error = ($statement->errorInfo());
				$connection->closeConnection($connectionstatus);
				$id=$connectionstatus->lastInsertId();
				$juridico->idJuridico=$id;				
				return $juridico;
			}
		} else {
			unset($connectionstatus);
			unset($connection);
			return false;
		}
	}

	public function fncActualizarBD(Juridico $juridico)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		$bolReturn = false;
		if ($connectionstatus) {
			$sql = ' 
			UPDATE gps_juridico
			SET
				
				correo = :correo,
				idRepresentanteLegal = :idRepresentanteLegal,
			
				updated_at = now()
			WHERE idJuridico = :idJuridico
		
		';
			$statement = $connectionstatus->prepare($sql);

			if ($statement != false) {		
				$statement->bindParam("idJuridico", $juridico->idJuridico);		
				$statement->bindParam("correo", $juridico->correo);
				$statement->bindParam("idRepresentanteLegal", $juridico->idRepresentanteLegal);
				$statement->execute();
				$error = ($statement->errorInfo());
				$connection->closeConnection($connectionstatus);
				if (($statement->rowCount()) != 0) {
					return $juridico;
				}
			}
		}
		return $bolReturn;
	}

}
