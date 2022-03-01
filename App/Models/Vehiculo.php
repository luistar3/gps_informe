<?php
class Vehiculo implements \JsonSerializable
{  

    protected $idVehiculo;
    protected $idMarcaVehiculo;
 
    protected $placa;
    protected $modelo;
    protected $anio;
    protected $gps;
    protected $imei;
    
    protected $estado;
    protected $created_at;
    protected $updated_at;

    public function __construct()
    {
    }  

    public function getIdVehiculo(){return $this->idVehiculo;}
    public function getIdMarcaVehiculo(){return $this->idMarcaVehiculo;}
    public function getPlaca(){return $this->placa;}
    public function getModelo(){return $this->modelo;}
    public function getAnio(){return $this->anio;}
    public function getGps(){return $this->gps;}
    public function getImei(){return $this->imei;}
    
    public function getCreated_at(){return $this->created_at;}
    public function getEstado(){return $this->estado;}
    public function getUpdated_at(){return $this->updated_at;}

    public function setIdVehiculo($idVehiculo){$this->idVehiculo = $idVehiculo;}
    public function setIdMarcaVehiculo($idMarcaVehiculo){$this->idMarcaVehiculo = $idMarcaVehiculo;}
    public function setPlaca($placa){$this->placa = $placa;}
    public function setModelo($modelo){$this->modelo = $modelo;}
    public function setAnio($anio){$this->anio = $anio;}
    public function setGps($gps){$this->gps = $gps;}
    public function setImei($imei){$this->imei = $imei;}
    
    public function setCreated_at($created_at){$this->created_at = $created_at;}
    public function setEstado($estado){$this->estado = $estado;}
    public function setUpdated_at($updated_at){$this->updated_at = $updated_at;}

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
    
}
?>