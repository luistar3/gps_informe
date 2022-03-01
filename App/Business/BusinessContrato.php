<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/gps/App/Config/coneccion.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/gps/App/Models/Contrato.php');


class BusinessContrato extends Contrato
{
	public function fncListarRegistrosBD($contratoDesde, $contratoHasta, $estadoContrato)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		$sqlEstado = "";
		if ($estadoContrato !== '') {
			$sqlEstado = 'gc.estado = ' . $estadoContrato . ' AND ';
		}
		$sqlFechas = 'gc.fechaInicio >= \'' . $contratoDesde . '\' AND gc.fechaInicio<=\'' . $contratoHasta . '\'';
		if ($connectionstatus) {

			$sql = '			
			SELECT
				gc.idContrato,
				gc.idCliente,
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
								on j.idJuridico = c.idJuridico ) AS cli WHERE cli.idCliente = gc.idCliente)AS nombre,
				gc.fechaInicio,
				gc.fechaFin,
				gc.mensualidad,
				gc.contrato,
				gc.estado,
				gc.created_at,
				gc.updated_at,				
				(	
				SELECT
					case 
						when gcc.idPersona is not null then \'natural\' 
						else \'juridica\' 
					end as cliente		
				FROM
					gps_cliente AS gcc WHERE gcc.idCliente = gc.idCliente) AS tipoCliente
			FROM
				gps_contrato AS gc
				WHERE 
				' . $sqlEstado . '
				' . $sqlFechas;
			$statement = $connectionstatus->prepare($sql);
			$arrayReturn = array();
			//$result = mysqli_query($connectionstatus, $sql);

			if ($statement != false) {
				$statement->execute();
				while ($datos = $datos = $statement->fetch(PDO::FETCH_ASSOC)) {
					$temp = new Contrato;
					$temp->idContrato		= $datos['idContrato'];
					$temp->idCliente	= $datos["idCliente"];
					$temp->nombre	= $datos["nombre"];
					$temp->fechaInicio		= $datos["fechaInicio"];
					$temp->fechaFin		= $datos["fechaFin"];
					$temp->mensualidad			= $datos["mensualidad"];
					$temp->contrato	= $datos["contrato"];
					$temp->estado		= $datos["estado"];
					$temp->createdAt	= $datos["created_at"];
					$temp->updatedAt	= $datos["updated_at"];
					$temp->tipoCliente	= $datos["tipoCliente"];
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


	public function fncObtenerRegistroBD($idContrato)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {

			$sql = '			
			SELECT
				gc.idContrato,
				gc.idCliente,
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
								on j.idJuridico = c.idJuridico ) AS cli WHERE cli.idCliente = gc.idCliente)AS nombre,
				gc.fechaInicio,
				gc.fechaFin,
				gc.mensualidad,
				gc.contrato,
				gc.estado,
				gc.created_at,
				gc.updated_at,				
				(	
				SELECT
					case 
						when gcc.idPersona is not null then \'natural\' 
						else \'juridica\' 
					end as cliente		
				FROM
					gps_cliente AS gcc WHERE gcc.idCliente = gc.idCliente) AS tipoCliente
			FROM
				gps_contrato AS gc
			WHERE gc.idContrato = :idContrato
			';
			$statement = $connectionstatus->prepare($sql);
			$temp = new \stdClass;

			if ($statement != false) {
				$statement->bindParam('idContrato', $idContrato);
				$statement->execute();
				if ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
					$temp->idContrato		= $datos['idContrato'];
					$temp->idCliente	= $datos["idCliente"];
					$temp->nombre	= $datos["nombre"];
					$temp->fechaInicio		= $datos["fechaInicio"];
					$temp->fechaFin		= $datos["fechaFin"];
					$temp->mensualidad			= $datos["mensualidad"];
					$temp->contrato	= $datos["contrato"];
					$temp->estado		= $datos["estado"];
					$temp->createdAt	= $datos["created_at"];
					$temp->updatedAt	= $datos["updated_at"];
					$temp->tipoCliente	= $datos["tipoCliente"];
				}
				return $temp;
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


	public function fncListarTipoPagoBD($id = -1)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {

			$sql = '				
			SELECT
				gtp.idTipoPago,
				gtp.tipoPago
			FROM
				gps_tipo_pago AS gtp
			';
			$statement = $connectionstatus->prepare($sql);
			$arrayReturn = array();
			//$result = mysqli_query($connectionstatus, $sql);

			if ($statement != false) {
				$statement->execute();
				while ($datos = $datos = $statement->fetch(PDO::FETCH_ASSOC)) {
					$temp = new \stdClass;
					$temp->idTipoPago		= $datos['idTipoPago'];
					$temp->tipoPago	= $datos["tipoPago"];
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



	public function fncListarcontratoVehiculoBD($id)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {

			$sql = '			
			SELECT
				gcv.idContratoVehiculo,
				gcv.idContrato,
				gcv.idVehiculo,
				gcv.montoPago,
				gv.idMarcaVehiculo,
				gv.modelo,
				gv.anio,
				gv.gps,
				gv.imei,
				gmv.marca,
				gcv.frecuenciaPago,
				gcv.fechaInstalacion,				
				IFNULL(gcv.fechaTermino,\'--\') as fechaTermino,
				gv.placa,
				gv.imei,
				IFNULL((SELECT	
				max(gp.created_at) AS ultimoPago
				FROM
					gps_pago AS gp
				WHERE gp.estado =1 AND 
					gp.idContratoVehiculo = gcv.idContratoVehiculo),\'--\')AS ultimoPago
			FROM
				gps_contrato_vehiculo AS gcv
				INNER JOIN gps_vehiculo AS gv
						ON gv.idVehiculo = gcv.idVehiculo
						INNER JOIN gps_marca_vehiculo AS gmv
				          ON gmv.idMarcaVehiculo = gv.idMarcaVehiculo
			WHERE gcv.idContrato = :idContrato 
			AND gcv.estado = 1			
			';
			$statement = $connectionstatus->prepare($sql);
			$arrayReturn = array();
			//$result = mysqli_query($connectionstatus, $sql);

			if ($statement != false) {
				$statement->bindParam("idContrato", $id);
				$statement->execute();
				while ($datos = $datos = $statement->fetch(PDO::FETCH_ASSOC)) {
					$temp = new \stdClass;

					$temp->idContratoVehiculo		= $datos['idContratoVehiculo'];
					$temp->idContrato		= $datos['idContrato'];
					$temp->idVehiculo		= $datos['idVehiculo'];
					$temp->montoPago	= $datos["montoPago"];
					$temp->frecuenciaPago	= $datos["frecuenciaPago"];
					$temp->fechaInstalacion		= $datos["fechaInstalacion"];
					$temp->fechaTermino		= $datos["fechaTermino"];
					$temp->placa			= $datos["placa"];
					$temp->marca			= $datos["marca"];
					$temp->idMarcaVehiculo			= $datos["idMarcaVehiculo"];
					$temp->modelo			= $datos["modelo"];
					$temp->anio			= $datos["anio"];
					$temp->gps			= $datos["gps"];
					$temp->imei			= $datos["imei"];
					$temp->ultimoPago			= $datos["ultimoPago"];



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


	public function fncGuardarBD(Contrato $contrato)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {
			$sql = "INSERT INTO gps_contrato
			(
				idCliente,
				fechaInicio,
				fechaFin,
				mensualidad
				
			)
			VALUES
			(
				:idCliente,
				:fechaInicio,
				:fechaFin,
				:mensualidad
			)
			";

			$statement = $connectionstatus->prepare($sql);

			if ($statement != false) {
				$statement->bindParam("idCliente", $contrato->idCliente);
				$statement->bindParam("fechaInicio", $contrato->fechaInicio);
				$statement->bindParam("fechaFin", $contrato->fechaFin);
				$statement->bindParam("mensualidad", $contrato->mensualidad);
				$statement->execute();
				$connection->closeConnection($connectionstatus);
				$id = $connectionstatus->lastInsertId();
				$contrato->idContrato = $id;
				return $contrato;
			}
		} else {
			unset($connectionstatus);
			unset($connection);
			return false;
		}
	}

	public function fncActualizarBD(Contrato $contrato)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		$scriptArchivo = '';
		if ($contrato->contrato != '') {
			$scriptArchivo = ', contrato = :contrato';
		}
		if ($connectionstatus) {
			$sql = ' 
			
			UPDATE gps_contrato
			SET				
				fechaInicio = :fechaInicio,
				fechaFin = :fechaFin,
				mensualidad = :mensualidad	
				'.$scriptArchivo.'		
				,updated_at = now()			
			WHERE idContrato = :idContrato
		
		';
			//$asd = 11;
			$statement = $connectionstatus->prepare($sql);


			if ($statement != false) {
				$statement->bindParam("idContrato", $contrato->idContrato);
				$statement->bindParam("mensualidad", $contrato->mensualidad);
				$statement->bindParam("fechaInicio", $contrato->fechaInicio);
				$statement->bindParam("fechaFin", $contrato->fechaFin);	
				
				if ($contrato->contrato != '') {
					$statement->bindParam("contrato", $contrato->contrato);
				}
					
				
				$statement->execute();
				$error = ($statement->errorInfo());
				$connection->closeConnection($connectionstatus);
				
				if (($statement->rowCount()) == 0 || $error[1] !== null) {
					return false;
				}
			}
			return $contrato;
		} else {
			unset($connectionstatus);
			unset($connection);
			return false;
		}
	}
}
