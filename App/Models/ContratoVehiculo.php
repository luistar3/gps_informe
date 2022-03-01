<?php
class ContratoVehiculo implements \JsonSerializable
{  

    protected $idContratoVehiculo;
    protected $idContrato;
    protected $idVehiculo;
    protected $montoPago;
    protected $frecuenciaPago;
    protected $fechaInstalacion;
    protected $fechaTermino;
    protected $estado;
    protected $created_at;
    protected $updated_at;

    public function __construct()
    {
    }  

    public function getIdContratoVehiculo(){return $this->idContratoVehiculo;}
    public function getIdContrato(){return $this->idContrato;}
    public function getIdVehiculo(){return $this->idVehiculo;}
    public function getMontoPago(){return $this->montoPago;}
    public function getFrecuenciaPago(){return $this->frecuenciaPago;}
    public function getFechaInstalacion(){return $this->fechaInstalacion;}
    public function getFechaTermino(){return $this->fechaTermino;}
    public function getEstado(){return $this->estado; }
    public function getCreated_at(){return $this->created_at;}
    public function getUpdated_at(){return $this->updated_at;}

    public function setIdContratoVehiculo($idContratoVehiculo){$this->idContratoVehiculo = $idContratoVehiculo;}
    public function setIdContrato($idContrato){$this->idContrato = $idContrato;}
    public function setIdVehiculo($idVehiculo){$this->idVehiculo = $idVehiculo;}
    public function setMontoPago($montoPago){$this->montoPago = $montoPago;}
    public function setFrecuenciaPago($frecuenciaPago){$this->frecuenciaPago = $frecuenciaPago;}
    public function setFechaInstalacion($fechaInstalacion){$this->fechaInstalacion = $fechaInstalacion;}
    public function setFechaTermino($fechaTermino){$this->fechaTermino = $fechaTermino;}
    public function setEstado($estado){$this->estado = $estado;}
    public function setCreated_at($created_at){$this->created_at = $created_at;}
    public function setUpdated_at($updated_at){$this->updated_at = $updated_at;}


    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
  
}
?>



