<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Config/coneccion.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Models/Modulo.php');


class BusinessModulo extends Modulo
{
	public function fncListarRegistrosBD($id = -1)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {
			$sql = "
			SELECT
				gm.idModulo,
				gm.modulo,
				gm.descripcion,
				gm.estado,
				gm.created_at,
				gm.updated_at
			FROM
				gps_modulo AS gm WHERE (:idModulo = -1 OR idModulo = :idModulo)";
		
		//$connectionstatus->prepare($sql);
		//$arrayReturn = array();
		$statement = $connectionstatus->prepare($sql);
		$arrayReturn = array();
			//$result = mysqli_query($connectionstatus, $sql);
			if ($statement != false){
				$statement->bindParam('idModulo', $id);
				//var_dump($statement);
				$statement->execute();
				while ($datos = $datos = $statement->fetch(PDO::FETCH_ASSOC)) {
					$temp = new Modulo;
					$temp->idModulo		= $datos['idModulo'];
					$temp->modulo		= $datos["modulo"];
					$temp->descripcion		= $datos["descripcion"];
					$temp->estado			= $datos["estado"];
					$temp->createdAt	= $datos["created_at"];
					$temp->updatedAt		= $datos["updated_at"];
				
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
