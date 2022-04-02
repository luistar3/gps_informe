<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/gps/App/Config/coneccion.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/gps/App/Models/ContratoVehiculo.php');


class BusinessContratoVehiculo extends ContratoVehiculo
{
	public function fncListarRegistrosBD($id = -1)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {
			$sql = "
			SELECT
				gr.idRol,
				gr.nombre,
				gr.estado,
				gr.created_at,
				gr.updated_at
			FROM
				gps_rol AS gr WHERE (:idRol = -1 OR idRol = :idRol)";

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
					$temp = new Rol;
					$temp->idRol		= $datos['idRol'];
					$temp->nombre		= $datos["nombre"];
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

	public function fncObtenerIdContratoIdVehiculoBD(ContratoVehiculo $contratoVehiculo)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {
			$sql = "
			SELECT
				gcv.idContratoVehiculo,
				gcv.idContrato,
				gcv.idVehiculo,
				gcv.montoPago,
				gcv.frecuenciaPago,
				gcv.fechaInstalacion,
				gcv.created_at,
				gcv.updated_at
			FROM
				gps_contrato_vehiculo AS gcv
			WHERE 
				gcv.idContrato = :idContrato AND
				gcv.idVehiculo = :idVehiculo AND
				gcv.estado = 1
				";
			$statement = $connectionstatus->prepare($sql);
			$arrayReturn = array();

			if ($statement != false) {
				$statement->bindParam('idContrato', $contratoVehiculo->idContrato);
				$statement->bindParam('idVehiculo', $contratoVehiculo->idVehiculo);

				$statement->execute();
				if ($registro = $statement->fetch(PDO::FETCH_ASSOC)) {
					$contratoVehiculo->idContratoVehiculo = $registro["idContratoVehiculo"];
					$contratoVehiculo->montoPago = $registro["montoPago"];
					$contratoVehiculo->frecuenciaPago = $registro["frecuenciaPago"];
					$contratoVehiculo->fechaInstalacion = $registro["fechaInstalacion"];
					$contratoVehiculo->createdAt = $registro["created_at"];
					$contratoVehiculo->updatedAt = $registro["updated_at"];
				}
				return $arrayReturn;
				$connection->closeConnection($connectionstatus);
			}
		}
		return $contratoVehiculo;
	}

	public function fncListadoPlacasDisponiblesBD($idContrato , $placa)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {
			$sql = '
			SELECT
			gv.idVehiculo,
			gv.idMarcaVehiculo,
			gmv.marca,
			gv.placa,
			(
			SELECT
				count(*)
			FROM
				gps_contrato_vehiculo AS gcv
				INNER JOIN gps_vehiculo AS gvs
						ON gv.idVehiculo = gcv.idVehiculo		          
			WHERE gv.estado = 1 AND gvs.placa = gv.placa AND gcv.idContrato NOT IN ( :idContrato )

				)AS otrosContratos,
				IFNULL((
			SELECT
				GROUP_CONCAT((SELECT cli.cliente FROM( 
									select case 
										when p.idPersona is not null then CONCAT(p.nombres,\' \',p.apellidos,\' (\',p.dni,\')\') 
										else CONCAT(j.razonSocial,\' (\',j.ruc,\')\') 
									end as cliente,
									c.idCliente
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
										on j.idJuridico = c.idJuridico ) AS cli WHERE cli.idCliente = gc.idCliente)SEPARATOR \',\' )AS nombre
			FROM
				gps_contrato_vehiculo AS gcv
				INNER JOIN gps_vehiculo AS gvs
						ON gvs.idVehiculo = gcv.idVehiculo	
						INNER JOIN gps_contrato AS gc
									ON gc.idContrato = gcv.idContrato	 
						
			WHERE gv.estado = 1 AND gcv.idVehiculo = gv.idVehiculo AND gcv.idContrato NOT IN ( :idContrato )

		),\' N/A \')AS nombres,
			gv.modelo,
			gv.anio,
			gv.gps,
			gv.imei
		FROM
			gps_vehiculo AS gv
			INNER JOIN gps_marca_vehiculo AS gmv
					ON gmv.idMarcaVehiculo = gv.idMarcaVehiculo
		WHERE gv.placa not IN (SELECT
			gv.placa
		FROM
			gps_contrato_vehiculo AS gcv
			INNER JOIN gps_vehiculo AS gv
			ON gv.idVehiculo = gcv.idVehiculo
					
		WHERE gcv.idContrato = :idContrato AND gv.estado = 1) AND gv.estado = 1 AND gv.placa = :placa

				';
			$statement = $connectionstatus->prepare($sql);
			$arrayReturn = array();
			

			if ($statement != false) {
				$statement->bindParam('idContrato', $idContrato);
				$statement->bindParam('placa', $placa);
				$statement->execute();
				$error = ($statement->errorInfo());
				if ($registro = $statement->fetch(PDO::FETCH_ASSOC)) {
					$temp = new \stdClass;
					$temp->idVehiculo = $registro["idVehiculo"];
					$temp->idMarcaVehiculo = $registro["idMarcaVehiculo"];
					$temp->marca = $registro["marca"];
					$temp->placa = $registro["placa"];
					$temp->otrosContratos = $registro["otrosContratos"];
					$temp->nombres = $registro["nombres"];
					$temp->modelo = $registro["modelo"];
					$temp->anio = $registro["anio"];
					$temp->gps = $registro["gps"];
					$temp->imei = $registro["imei"];
					array_push($arrayReturn,$temp);
				}
				return $arrayReturn;
				$connection->closeConnection($connectionstatus);
			}
		}
		return $arrayReturn;
	}


	public function fncListadoPlacasDisponibles2BD($idContrato)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {
			$sql = '
			SELECT
			gv.idVehiculo,
			gv.idMarcaVehiculo,
			gmv.marca,
			gv.placa,
			(
			SELECT
				count(*)
			FROM
				gps_contrato_vehiculo AS gcv
				INNER JOIN gps_vehiculo AS gvs
						ON gvs.idVehiculo = gcv.idVehiculo		          
			WHERE gv.estado = 1 AND gvs.placa = gv.placa AND gcv.idContrato NOT IN ( :idContrato )
				)AS otrosContratos,
			gv.modelo,
			gv.anio,
			gv.gps,
			gv.imei,
			gv.estado,
			gv.created_at,
			gv.updated_at
		FROM
			gps_vehiculo AS gv
			INNER JOIN gps_marca_vehiculo AS gmv
					ON gmv.idMarcaVehiculo = gv.idMarcaVehiculo
		WHERE gv.placa not IN (SELECT
			gv.placa
		FROM
			gps_contrato_vehiculo AS gcv
			INNER JOIN gps_vehiculo AS gv
			ON gv.idVehiculo = gcv.idVehiculo					
		WHERE gcv.idContrato = :idContrato AND gcv.estado = 1) AND gv.estado = 1 
	

				';
			$statement = $connectionstatus->prepare($sql);
			$arrayReturn = array();
			

			if ($statement != false) {
				$statement->bindParam('idContrato', $idContrato);
				$statement->execute();
				$error = ($statement->errorInfo());
				while ($registro = $registro =$statement->fetch(PDO::FETCH_ASSOC)) {
					$temp = new \stdClass;
					$temp->idVehiculo = $registro["idVehiculo"];
					$temp->idMarcaVehiculo = $registro["idMarcaVehiculo"];
					$temp->marca = $registro["marca"];
					$temp->placa = $registro["placa"];
					$temp->otrosContratos = $registro["otrosContratos"];
					$temp->modelo = $registro["modelo"];
					$temp->anio = $registro["anio"];
					$temp->gps = $registro["gps"];
					$temp->imei = $registro["imei"];
					array_push($arrayReturn,$temp);
				}
				return $arrayReturn;
				$connection->closeConnection($connectionstatus);
			}
		}
		return $arrayReturn;
	}

	public function fncObtenerContratoVehiculoBD(ContratoVehiculo $contratoVehiculo)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {
			$sql = "
			SELECT
				gcv.idContratoVehiculo,
				gcv.idContrato,
				gcv.idVehiculo,
				gcv.montoPago,
				gcv.frecuenciaPago,
				gcv.fechaInstalacion,
				gcv.created_at,
				gcv.updated_at
			FROM
				gps_contrato_vehiculo AS gcv
			WHERE 
				gcv.idContratoVehiculo = :idContratoVehiculo  ";
			$statement = $connectionstatus->prepare($sql);
			$arrayReturn = array();

			if ($statement != false) {
				$statement->bindParam('idContratoVehiculo', $contratoVehiculo->idContratoVehiculo);
				$statement->execute();
				if ($registro = $statement->fetch(PDO::FETCH_ASSOC)) {
					$contratoVehiculo->idContratoVehiculo = $registro["idContratoVehiculo"];
					$contratoVehiculo->idContrato = $registro["idContrato"];
					$contratoVehiculo->idVehiculo = $registro["idVehiculo"];
					$contratoVehiculo->montoPago = $registro["montoPago"];
					$contratoVehiculo->frecuenciaPago = $registro["frecuenciaPago"];
					$contratoVehiculo->fechaInstalacion = $registro["fechaInstalacion"];
					$contratoVehiculo->createdAt = $registro["created_at"];
					$contratoVehiculo->updatedAt = $registro["updated_at"];
				}
				return $arrayReturn;
				$connection->closeConnection($connectionstatus);
			}
		}
		return $contratoVehiculo;
	}


	public function fncGuardarBD(ContratoVehiculo $contratoVehiculo)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {
			$sql = "			
			INSERT INTO gps_contrato_vehiculo
			(
				
				idContrato,
				idVehiculo,
				montoPago,
				frecuenciaPago,
				fechaInstalacion,
				fechaTermino
			)
			VALUES
			(
				:idContrato,
				:idVehiculo,
				:montoPago,
				:frecuenciaPago,
				:fechaInstalacion,
				:fechaTermino
			)
			";

			$statement = $connectionstatus->prepare($sql);

			if ($statement != false) {
				$statement->bindParam("idContrato", $contratoVehiculo->idContrato);
				$statement->bindParam("idVehiculo", $contratoVehiculo->idVehiculo);
				$statement->bindParam("montoPago", $contratoVehiculo->montoPago);
				$statement->bindParam("frecuenciaPago", $contratoVehiculo->frecuenciaPago);
				$statement->bindParam("fechaInstalacion", $contratoVehiculo->fechaInstalacion);
				$statement->bindParam("fechaTermino", $contratoVehiculo->fechaTermino);
				$statement->execute();
				$connection->closeConnection($connectionstatus);
				$id = $connectionstatus->lastInsertId();
				if ($id==0) {
					return false;
				}
				$contratoVehiculo->idContratoVehiculo = $id;
				return $contratoVehiculo;
			} else {
				return false;
			}
		} else {
			return false;
		}

		unset($connectionstatus);
		unset($connection);
		return $contratoVehiculo;
	}


	public function fncActualizarBD(ContratoVehiculo $contratoVehiculo)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		
		if ($connectionstatus) {
			$sql = ' 
			
			UPDATE gps_contrato_vehiculo
			SET			
				montoPago = :montoPago,
				fechaTermino = :fechaTermino,				
				updated_at = now()
			WHERE idContratoVehiculo = :idContratoVehiculo
		
		';
			//$asd = 11;
			$statement = $connectionstatus->prepare($sql);


			if ($statement != false) {
				$statement->bindParam("idContratoVehiculo", $contratoVehiculo->idContratoVehiculo);
				$statement->bindParam("montoPago", $contratoVehiculo->montoPago);
				$statement->bindParam("fechaTermino", $contratoVehiculo->fechaTermino);
				$statement->execute();
				$error = ($statement->errorInfo());
				$connection->closeConnection($connectionstatus);
				
				if (($statement->rowCount()) == 0 || $error[1] !== null) {
					return false;
				}
			}
			return $contratoVehiculo;
		} else {
			unset($connectionstatus);
			unset($connection);
			return false;
		}
	}

	public function fncEliminarBD(ContratoVehiculo $contratoVehiculo)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		$bolReturn = false;
		if ($connectionstatus) {
			$sql = ' 
			UPDATE gps_contrato_vehiculo
			SET				
				estado = 0
			WHERE idContratoVehiculo = :idContratoVehiculo
		
		';
			$statement = $connectionstatus->prepare($sql);

			if ($statement != false) {
				$statement->bindParam("idContratoVehiculo", $contratoVehiculo->idContratoVehiculo);				
				$statement->execute();
				$connection->closeConnection($connectionstatus);
				if (($statement->rowCount()) != 0) {
					return true;
				}
			}
		}
		return $bolReturn;
	}

}
