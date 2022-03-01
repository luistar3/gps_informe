<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/gps/App/Config/coneccion.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/gps/App/Models/Usuario.php');


class BusinessUsuario extends Usuario
{
	public function fncListarRegistrosBD($id = -1)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {
			$sql = "
			SELECT
				gu.idUsuario,
				gu.idPersona,
				gu.idRol,
				gu.usuario,
				gu.contrasena,
				gu.estado,
				gu.created_at,
				gu.updated_at
			FROM
				gps_usuario AS gu
				
			WHERE gu.estado = 1 AND (:idUsuario = -1 OR gu.idUsuario = :idUsuario)";

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
					$temp = new Usuario;
					$temp->idUsuario	= $datos['idUsuario'];
					$temp->idPersona	= $datos["idPersona"];
					$temp->idRol		= $datos["idRol"];
					$temp->usuario		= $datos["usuario"];
					$temp->contrasena	= $datos["contrasena"];
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

	public function fncObtenerAuthBD($user)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {

			$sql = "
			SELECT
				gu.idUsuario,
				gu.idPersona,
				gu.idRol,
				upper(gu.usuario) as usuario,
				gu.contrasena,
				gu.estado,
				gu.created_at,
				gu.updated_at
			FROM
				gps_usuario AS gu WHERE gu.usuario = :usuario";

			$statement = $connectionstatus->prepare($sql);

			$usuario = new Usuario;
			if ($statement != false) {
				$statement->bindParam('usuario', $user);
				$statement->execute();

				if (!$registro = $statement->fetch(PDO::FETCH_ASSOC)) {
					return false;
				}
				$usuario->idUsuario		= $registro['idUsuario'];
				$usuario->idPersona		= $registro['idPersona'];
				$usuario->idRol			= $registro["idRol"];
				$usuario->usuario	= $registro["usuario"];
				$usuario->contrasena		= $registro["contrasena"];
				$usuario->estado	= $registro["estado"];
				$usuario->createdAt	= $registro["created_at"];
				$usuario->updatedAt	= $registro["updated_at"];

				return $usuario;
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

	public function fncObtenerPermisosModulosBD($user)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {

			$sql = '
			SELECT 
			gpn.nombres,
			gpn.apellidos,
			gpn.telefono,
			gpn.dni,
			gpn.direccion,
			gpn.correo,
			gu.idUsuario,
			gu.estado AS estadoUsuario,
			gu.idPersona,
			gu.usuario,
			gr.nombre as nombreRol,
			gm.idModulo,
			concat(\'[\',GROUP_CONCAT(CONCAT(\'{"\',gm.idModulo,\'":"\', IFNULL(gm.modulo,0), \'"}\')),\']\') as accesoModulos
			FROM gps_usuario AS gu 
			INNER JOIN gps_rol AS gr ON gr.idRol = gu.idRol
			LEFT JOIN gps_modulo_rol AS gmr ON gmr.idRol = gr.idRol
			INNER JOIN gps_modulo AS gm ON gm.idModulo = gmr.idModulo
			LEFT JOIN gps_persona_natural AS gpn ON gpn.idPersona = gu.idPersona
			WHERE gu.usuario = :usuario';

			$statement = $connectionstatus->prepare($sql);

			$usuario = new stdClass;
			if ($statement != false) {
				$statement->bindParam('usuario', $user);
				$statement->execute();
				$error = ($statement->errorInfo());
				if (!$registro = $statement->fetch(PDO::FETCH_ASSOC)) {
					return false;
				}
				$usuario->nombres		= $registro['nombres'];
				$usuario->apellidos		= $registro['apellidos'];
				$usuario->telefono		= $registro["telefono"];
				$usuario->dni			= $registro["dni"];
				$usuario->direccion		= $registro["direccion"];
				$usuario->correo		= $registro["correo"];
				$usuario->idUsuario		= $registro["idUsuario"];
				$usuario->estadoUsuario	= $registro["estadoUsuario"];
				$usuario->idPersona		= $registro["idPersona"];
				$usuario->usuario		= $registro["usuario"];
				$usuario->nombreRol		= $registro["nombreRol"];
				$usuario->idModulo		= $registro["idModulo"];
				$usuario->accesoModulos	= $registro["accesoModulos"];
				return $usuario;
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
