<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Config/coneccion.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Models/Rol.php');


class BusinessRol extends Rol
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
			if ($statement != false){
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
}
