<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Config/coneccion.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/gps/App/Models/MarcaVehiculo.php');


class BusinessMarcaVehiculo extends MarcaVehiculo
{
	public function fncListarRegistrosBD($id = -1)
	{
		$connection = new connection();
		$connectionstatus = $connection->openConnection();
		if ($connectionstatus) {
			$sql = "
			SELECT
			gmv.idMarcaVehiculo,
			gmv.marca,
			gmv.created_at,
			gmv.updated_at
		FROM
			gps_marca_vehiculo AS gmv WHERE (:idMarcaVehiculo = -1 OR idMarcaVehiculo = :idMarcaVehiculo)
			order by gmv.marca";
		
		//$connectionstatus->prepare($sql);
		//$arrayReturn = array();
		$statement = $connectionstatus->prepare($sql);
		$arrayReturn = array();
			//$result = mysqli_query($connectionstatus, $sql);
			if ($statement != false){
				$statement->bindParam('idMarcaVehiculo', $id);
				//var_dump($statement);
				$statement->execute();
				while ($datos = $datos = $statement->fetch(PDO::FETCH_ASSOC)) {
					$temp = new MarcaVehiculo;
					$temp->idMarcaVehiculo		= $datos['idMarcaVehiculo'];
					$temp->marca		= $datos["marca"];	
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
			//return ('Tenemos un problema' . (mysqli_error($connectionstatus)));
			return false;
		}
	}

}
