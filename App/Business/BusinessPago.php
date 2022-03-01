<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/gps/App/Config/coneccion.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/gps/App/Models/Pago.php');


class BusinessPago extends Pago
{

	public function fncListarRegistrosBD($fechaInicio, $fechaFin, $tipoPago, $idContratoVehiculo, $idVehiculo)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		$sqlTipoPago = '';
		$contratoIdVehiculo = '';
		if ($tipoPago != 0) {
			$sqlTipoPago = ' gtp.idTipoPago = ' . $tipoPago . ' AND	';
		}
		if ($idContratoVehiculo != 0) {
			$contratoIdVehiculo = ' gcv.idContratoVehiculo = ' . $idContratoVehiculo . ' AND	';
		} else {
			$contratoIdVehiculo = ' gcv.idVehiculo = ' . $idVehiculo . ' AND	';
		}
		if ($connectionstatus) {
			$sql = '
			SELECT
			gp.idPago,
			gp.fechaPago,
			gp.montoPago,
			gp.archivo,
			gp.montoPagoContratoVehiculo,
			gp.observacion,
			gp.estado,
			gp.created_at,
			gp.updated_at,
			gtp.idTipoPago,
			gtp.tipoPago AS tipoPago,
			gcv.idContrato,
			gcv.idVehiculo,
			gcv.idContratoVehiculo,
			(	SELECT
				(SELECT cli.cliente FROM( 
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
								on j.idJuridico = c.idJuridico ) AS cli WHERE cli.idCliente = gc.idCliente)AS nombre
				
			FROM
				gps_contrato AS gc				
			WHERE gc.idContrato = gcv.idContrato
			) AS nombreCliente
		FROM
			gps_pago AS gp
			INNER JOIN gps_tipo_pago AS gtp ON gtp.idTipoPago = gp.idTipoPago
			INNER JOIN gps_contrato_vehiculo AS gcv
					ON gcv.idContratoVehiculo = gp.idContratoVehiculo
		WHERE 
			gp.estado = 1 AND
			' . $sqlTipoPago . '
			' . $contratoIdVehiculo . '
			( str_to_date( gp.fechaPago,\'%Y-%m-%d\') >= \'' . $fechaInicio . '\' AND str_to_date( gp.fechaPago,\'%Y-%m-%d\') <= \'' . $fechaFin . '\')
		ORDER BY gp.fechaPago DESC
			';


			$statement = $connectionstatus->prepare($sql);
			$arrayReturn = array();

			if ($statement != false) {
				//$statement->bindParam('fechaIncio', $fechaInicio);
				//$statement->bindParam('fechaFin', $fechaFin);
				//var_dump($statement);
				$statement->execute();
				while ($datos = $datos = $statement->fetch(PDO::FETCH_ASSOC)) {

					//var_dump($datos);
					$temp = new Pago;
					$temp->idPago		= $datos['idPago'];
					$temp->fechaPago		= $datos['fechaPago'];
					$temp->montoPago	= $datos["montoPago"];
					$temp->montoPagoContratoVehiculo		= $datos["montoPagoContratoVehiculo"];
					$temp->observacion			= $datos["observacion"];
					$temp->createdAt	= $datos["created_at"];
					$temp->updated_at		= $datos["updated_at"];
					$temp->idTipoPago	= $datos["idTipoPago"];
					$temp->tipoPago	= $datos["tipoPago"];
					$temp->idContrato	= $datos["idContrato"];
					$temp->idVehiculo	= $datos["idVehiculo"];
					$temp->idContratoVehiculo	= $datos["idContratoVehiculo"];
					$temp->nombreCliente	= $datos["nombreCliente"];
					$temp->archivo	= $datos["archivo"];

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

	public function fncListarPagosAniosBD($id)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();

		if ($connectionstatus) {
			$sql = '
			SELECT
				YEAR(now()) AS anio,
				MONTH( gp.fechaPago) AS mes,
				sum(gp.montoPago) AS sumaPago,				
				count(MONTH(gp.fechaPago)) AS cantidadMes
			FROM
				gps_pago AS gp
				INNER JOIN gps_tipo_pago AS gtp ON gtp.idTipoPago = gp.idTipoPago				
			WHERE  gp.estado = 1 AND
			gp.idContratoVehiculo = :idContratoVehiculo AND
			year(gp.fechaPago)=YEAR(now())
			GROUP BY MONTH( gp.fechaPago)
			UNION 
			SELECT
				year(DATE_SUB(now(), INTERVAL 1 YEAR)) AS anio,				
				MONTH( gp.fechaPago) AS mes,
				sum(gp.montoPago) AS sumaPago,				
				count(MONTH(gp.fechaPago)) AS cantidadMes
			FROM
				gps_pago AS gp
				INNER JOIN gps_tipo_pago AS gtp ON gtp.idTipoPago = gp.idTipoPago				
			WHERE  gp.estado = 1 AND
			gp.idContratoVehiculo = :idContratoVehiculo AND
			year(gp.fechaPago)=year(DATE_SUB(now(), INTERVAL 1 YEAR))
			GROUP BY MONTH( gp.fechaPago)
			';


			$statement = $connectionstatus->prepare($sql);
			$arrayReturn = array();

			if ($statement != false) {
				$statement->bindParam('idContratoVehiculo', $id);
				//$statement->bindParam('fechaFin', $fechaFin);
				//var_dump($statement);
				$statement->execute();
				while ($datos = $datos = $statement->fetch(PDO::FETCH_ASSOC)) {

					//var_dump($datos);
					$temp = new \stdClass;
					$temp->anio		= $datos['anio'];
					$temp->mes		= $datos['mes'];
					$temp->sumaPago	= $datos["sumaPago"];
					$temp->cantidadMes		= $datos["cantidadMes"];

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


	public function fncGuardarBD(Pago $pago)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {
			$sql = "
			
			INSERT INTO gps_pago
			(
				
				idContratoVehiculo,
				fechaPago,
				montoPago,
				montoPagoContratoVehiculo,
				idTipoPago,
				observacion,
				archivo
			)
			VALUES
			(
				:idContratoVehiculo,
				:fechaPago,
				:montoPago,
				(SELECT
				gc.mensualidad
				FROM
					gps_contrato AS gc 
					INNER JOIN gps_contrato_vehiculo AS gcv
							  ON gcv.idContrato = gc.idContrato							  
				WHERE gcv.idContratoVehiculo = :idContratoVehiculo ),
				:idTipoPago,
				:observacion,
				:archivo
				
			)
			";

			$statement = $connectionstatus->prepare($sql);

			if ($statement != false) {
				$statement->bindParam("idContratoVehiculo", $pago->idContratoVehiculo);
				$statement->bindParam("fechaPago", $pago->fechaPago);
				$statement->bindParam("montoPago", $pago->montoPago);
				$statement->bindParam("idTipoPago", $pago->idTipoPago);
				$statement->bindParam("observacion", $pago->observacion);
				$statement->bindParam("archivo", $pago->archivo);
				$statement->execute();
				$connection->closeConnection($connectionstatus);
				$id = $connectionstatus->lastInsertId();
				if ($id == 0) {
					return false;
				}
				$pago->idPago = $id;
				return $pago;
			}
		} else {
			unset($connectionstatus);
			unset($connection);
			return false;
		}
	}

	public function fncEditarBD(Pago $pago)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		$scriptArchivo = '';
		if ($pago->archivo != '') {
			$scriptArchivo = ',archivo = :archivo';
		}
		if ($connectionstatus) {
			$sql = ' 
			UPDATE gps_pago
			SET						
				idTipoPago = :idTipoPago,
				observacion = :observacion
				' . $scriptArchivo . '
				,updated_at = now()
			WHERE idPago = :idPago	
		
		';
			$asd = 11;
			$statement = $connectionstatus->prepare($sql);

			if ($statement != false) {
				$statement->bindParam("idPago", $pago->idPago);
				$statement->bindParam("idTipoPago", $pago->idTipoPago);
				$statement->bindParam("observacion", $pago->observacion);
				if ($pago->archivo != '') {
					$statement->bindParam("archivo", $pago->archivo);
				}
				$statement->execute();
				$connection->closeConnection($connectionstatus);
				if (($statement->rowCount()) == 0) {
					return false;
				}
			}
			return $pago;
		} else {
			unset($connectionstatus);
			unset($connection);
			return false;
		}
	}

	public function fncEliminarBD(Pago $pago)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		$bolReturn = false;
		if ($connectionstatus) {
			$sql = ' 
			UPDATE gps_pago
			SET						
			estado = 0,
			updated_at = now()
			WHERE idPago = :idPago	
		
		';
			$statement = $connectionstatus->prepare($sql);

			if ($statement != false) {
				$statement->bindParam("idPago", $pago->idPago);				
				$statement->execute();
				$connection->closeConnection($connectionstatus);
				if (($statement->rowCount()) != 0) {
					return true;
				}
			}
		}
		return $bolReturn;
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
				$connection->closeConnection($connectionstatus);
				$id = $connectionstatus->lastInsertId();
				$cliente->idCliente = $id;
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
}
