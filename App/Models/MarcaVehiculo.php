<?php
class MarcaVehiculo implements \JsonSerializable
{  
    protected $idMarcaVehiculo;
    protected $marca;
    protected $created_at;
    protected $updated_at;

    public function __construct()
    {
    }  

    public function getIdMarcaVehiculo(){return $this->idMarcaVehiculo;}
    public function getMarca(){return $this->marca;}
    public function getCreated_at(){return $this->created_at;}
    public function getUpdated_at(){return $this->updated_at;}

    public function setIdMarcaVehiculo($idMarcaVehiculo){$this->idMarcaVehiculo = $idMarcaVehiculo;}
    public function setMarca($marca){$this->marca = $marca;}
    public function setCreated_at($created_at){$this->created_at = $created_at;}
    public function setUpdated_at($updated_at){$this->updated_at = $updated_at;}

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }

    
}
?>