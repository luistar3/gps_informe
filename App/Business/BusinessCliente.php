<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Config/coneccion.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Models/Cliente.php');


class BusinessCliente extends Cliente
{
	public function fncListarRegistrosBD($id = -1)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {
			$sql = "
			SELECT
				gc.idCliente,
				gc.idPersona,
				gc.idJuridico,
				gc.ultimoPago,
				gc.estado,
				gc.created_at,
				gc.updated_at
			FROM
				gps_cliente AS gc WHERE (:id = -1 OR idCliente = :id)";
		
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
					$temp->nombres		= $datos['idCliente'];
					$temp->apellidos	= $datos["idPersona"];
					$temp->telefono		= $datos["idJuridico"];
					$temp->dni			= $datos["ultimoPago"];
					$temp->direccion	= $datos["estado"];
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
			case 
		when gc.idPersona is not null then (SELECT dni from gps_persona_natural WHERE idPersona = gc.idPersona )
		else (SELECT ruc from gps_juridico WHERE idJuridico = gc.idJuridico )
		end as documentoCliente,
			case 
		when gc.idPersona is not null then (SELECT CONCAT(nombres,\' \', apellidos)from gps_persona_natural WHERE idPersona = gc.idPersona )
		else (SELECT razonSocial from gps_juridico WHERE idJuridico = gc.idJuridico )
		end as nombreCliente,
		case 
		when gc.idPersona is not null then (SELECT correo from gps_persona_natural WHERE idPersona = gc.idPersona )
		else (SELECT correo from gps_juridico WHERE idJuridico = gc.idJuridico )
		end as correo,
		case 
		when gc.idPersona is not null then \'NATURAL\'
		else \'JURIDICA\'
		end as tipoCliente,
			gc.idCliente,
			gc.idPersona,
			gc.idJuridico,
			gc.ultimoPago,
			gc.estado,
			gc.created_at,
			gc.updated_at
		FROM
			gps_cliente AS gc
	   
			';
		
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
					$temp = new Cliente;
					$temp->documentoCliente = $datos["documentoCliente"];
					$temp->nombreCliente = $datos["nombreCliente"];
					$temp->tipoCliente = $datos["tipoCliente"];
					$temp->idCliente		= $datos['idCliente'];
					$temp->idPersona	= $datos["idPersona"];
					$temp->idJuridico		= $datos["idJuridico"];
					$temp->ultimoPago			= $datos["ultimoPago"];
					$temp->estado	= $datos["estado"];
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
	public function fncListarRegistrosIdPersonaNaturalBD($id = -1)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {
			$sql = "
			SELECT
				gc.idCliente,
				gc.idPersona,
				gc.idJuridico,
				gc.ultimoPago,
			
				gc.estado,
				gc.created_at,
				gc.updated_at
			FROM
				gps_cliente AS gc WHERE (:idPersona = -1 OR idPersona = :idPersona)";
		
		//$connectionstatus->prepare($sql);
		//$arrayReturn = array();
		$statement = $connectionstatus->prepare($sql);
		$arrayReturn = array();
			//$result = mysqli_query($connectionstatus, $sql);
			if ($statement != false){
				$statement->bindParam('idPersona', $id);
				//var_dump($statement);
				$statement->execute();
				while ($datos = $datos = $statement->fetch(PDO::FETCH_ASSOC)) {
					$temp = new Cliente;
					$temp->idCliente		= $datos['idCliente'];
					$temp->idPersona	= $datos["idPersona"];
					$temp->idJuridico		= $datos["idJuridico"];
					$temp->ultimoPago			= $datos["ultimoPago"];
					$temp->estado	= $datos["estado"];
					
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
	public function fncListarRegistrosIdJuridicolBD($id = -1)
	{

		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {
			$sql = "
			SELECT
				gc.idCliente,
				gc.idPersona,
				gc.idJuridico,
				gc.ultimoPago,
			
				gc.estado,
				gc.created_at,
				gc.updated_at
			FROM
				gps_cliente AS gc WHERE (:idJuridico = -1 OR idJuridico = :idJuridico)";
		
		//$connectionstatus->prepare($sql);
		//$arrayReturn = array();
		
		$statement = $connectionstatus->prepare($sql);
		$arrayReturn = array();
			//$result = mysqli_query($connectionstatus, $sql);
			if ($statement != false){
				$statement->bindParam('idJuridico', $id);
				//var_dump($statement);
				$statement->execute();
				while ($datos = $datos = $statement->fetch(PDO::FETCH_ASSOC)) {
					$temp = new Cliente;
					$temp->idCliente		= $datos['idCliente'];
					$temp->idPersona	= $datos["idPersona"];
					$temp->idJuridico		= $datos["idJuridico"];
					$temp->ultimoPago			= $datos["ultimoPago"];
					$temp->estado	= $datos["estado"];
					
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
	public function fncListarRegistrosPorNombresBD($parametro)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {
			$sql = '
			SELECT * FROM( 
						select case when p.idPersona is not null then \'PERSONA\' else \'JURIDICO\' end as tipoCliente,
						c.ultimoPago,
						c.idCliente,
					   	c.estado,
					   	p.nombres,
						p.apellidos,
						p.telefono,
						p.dni,
						p.direccion,
						p.correo,
					   	j.razonSocial,
						j.ruc,
						j.correoEmpresa,
						j.idRepresentanteLegal
				  from gps_cliente c
				  left join gps_persona_natural p
					on p.idPersona = c.idPersona
				  left join (select j.idJuridico,
									j.razonSocial,
									j.ruc,
									j.correo AS correoEmpresa,
									j.idRepresentanteLegal as idRepresentanteLegal,
									p.telefono as numeroRepresentanteLegal,
									p.dni as dniRepresentanteLegal,                    
									p.direccion as direccionRepresentanteLegal
							   from gps_juridico j
							   join gps_persona_natural p
								 on j.idRepresentanteLegal = p.idPersona) j
					on j.idJuridico = c.idJuridico) AS cli
					
				WHERE (cli.nombres LIKE \'%'.''.$parametro.''.'%\' OR cli.apellidos LIKE \'%'.''.$parametro.''.'%\'OR cli.razonSocial LIKE \'%'.''.$parametro.''.'%\') AND cli.estado = 1';

				//echo ($sql);
		
		//$connectionstatus->prepare($sql);
		//$arrayReturn = array();
		$statement = $connectionstatus->prepare($sql);
		$arrayReturn = array();
			//$result = mysqli_query($connectionstatus, $sql);
			if ($statement != false){
				//$statement->bindParam('parametro', $parametro);
				//var_dump($statement);
				$statement->execute();
				$error = ($statement->errorInfo());
				while ($datos = $datos = $statement->fetch(PDO::FETCH_ASSOC)) {

					//var_dump($datos);
					$temp = new Cliente;
					$temp->tipoCliente		= $datos['tipoCliente'];
					$temp->idCliente		= $datos['idCliente'];
					$temp->ultimoPago		= $datos['ultimoPago'];
					$temp->idPersona	= $datos["idPersona"];
					$temp->nombres		= $datos["nombres"];
					$temp->apellidos			= $datos["apellidos"];
					$temp->telefono	= $datos["telefono"];
					$temp->dni		= $datos["dni"];
					$temp->direccion	= $datos["direccion"];
					$temp->correo	= $datos["correo"];

					$temp->idJuridico	= $datos["idJuridico"];
					$temp->razonSocial	= $datos["razonSocial"];
					$temp->ruc	= $datos["ruc"];
					$temp->correoEmpresa	= $datos["correoEmpresa"];
					$temp->idRepresentanteLegal	= $datos["idRepresentanteLegal"];
					$temp->numeroRepresentanteLegal	= $datos["numeroRepresentanteLegal"];
					$temp->dniRepresentanteLegal	= $datos["dniRepresentanteLegal"];
					$temp->direccionRepresentanteLegal	= $datos["direccionRepresentanteLegal"];
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

	public function fncGuardarPersonaNaturalBD(Cliente $cliente)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {
			$sql = "
			INSERT INTO gps_cliente
			(				
				idPersona					
			)
			VALUES
			(
				:idPersona			
			)
			";
			
			$statement = $connectionstatus->prepare($sql);

			if ($statement != false) {
				$statement->bindParam("idPersona", $cliente->idPersona);				

				$statement->execute();
				$error = ($statement->errorInfo());
				$connection->closeConnection($connectionstatus);
				$id=$connectionstatus->lastInsertId();
				$cliente->idCliente=$id;				
				return $cliente;
			}
		} else {
			unset($connectionstatus);
			unset($connection);
			return false;
		}
	}
	public function fncGuardarJuridicoBD(Cliente $cliente)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {
			$sql = "
			INSERT INTO gps_cliente
			(				
				idJuridico				
			)
			VALUES
			(
				:idJuridico			
			)
			";
			
			$statement = $connectionstatus->prepare($sql);

			if ($statement != false) {
				$statement->bindParam("idJuridico", $cliente->idJuridico);				

				$statement->execute();
				$error = ($statement->errorInfo());
				$connection->closeConnection($connectionstatus);
				$id=$connectionstatus->lastInsertId();
				$cliente->idCliente=$id;				
				return $cliente;
			}
		} else {
			unset($connectionstatus);
			unset($connection);
			return false;
		}
	}


	public function fncObtenerRegistroBD($id)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {

			$sql = "
			SELECT
				gc.idCliente,
				gc.idPersona,
				gc.idJuridico,
				gc.ultimoPago,
				gc.estado,
				gc.created_at,
				gc.updated_at
			FROM
				gps_cliente AS gc WHERE gc.idCliente = :idCliente";

			$statement = $connectionstatus->prepare($sql);

			$cliente = new Cliente;
			if ($statement != false) {
				$statement->bindParam('idCliente', $id);
				$statement->execute();

				if (!$registro = $statement->fetch(PDO::FETCH_ASSOC)) {
					return false;
				}
				$cliente->idCliente		= $registro['idCliente'];
				$cliente->idPersona		= $registro['idPersona'];
				$cliente->idJuridico	= $registro["idJuridico"];
				$cliente->ultimoPago	= $registro["ultimoPago"];
				$cliente->estado		= $registro["estado"];
				$cliente->createdAt	= $registro["created_at"];
				$cliente->deletedAt	= $registro["updated_at"];

				return $cliente;
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

	public function fncObtenerPorTipoPersonaBD($tipoPersona,$id)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		$queryTipo = '';
		if ($tipoPersona == 'natural') {
			$queryTipo = 'gc.idPersona = :idPersona';
		}else{
			$queryTipo = 'gc.idJuridico = :idJuridico';
		}
		if ($connectionstatus) {

			$sql = "
			SELECT
				gc.idCliente,
				gc.idPersona,
				gc.idJuridico,
				gc.ultimoPago,
				gc.estado,
				gc.created_at,
				gc.updated_at
			FROM
				gps_cliente AS gc 
				WHERE 
				".$queryTipo."
				
				";

			$statement = $connectionstatus->prepare($sql);

			$cliente = new Cliente;
			if ($statement != false) {
				
				if ($tipoPersona == 'natural') {
					$statement->bindParam('idPersona', $id);
				}else{
					$statement->bindParam('idJuridico', $id);
				}
				$statement->execute();

				if (!$registro = $statement->fetch(PDO::FETCH_ASSOC)) {
					return false;
				}
				$cliente->idCliente		= $registro['idCliente'];
				$cliente->idPersona		= $registro['idPersona'];
				$cliente->idJuridico	= $registro["idJuridico"];
				$cliente->ultimoPago	= $registro["ultimoPago"];
				$cliente->estado		= $registro["estado"];
				$cliente->createdAt	= $registro["created_at"];
				$cliente->deletedAt	= $registro["updated_at"];

				return $cliente;
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


	
}
