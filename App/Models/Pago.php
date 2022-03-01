<?php
class Pago implements \JsonSerializable
{  
    protected $idPago;
    protected $idContratoVehiculo;
    protected $fechaPago;
    protected $montoPago;
    protected $montoPagoContratoVehiculo;
    protected $idTipoPago;
    protected $observacion;
    protected $archivo;
    protected $created_at;
    protected $updated_at;

    public function __construct()
    {
    }  

    public function getIdPago(){return $this->idPago;}
    public function getIdContratoVehiculo(){return $this->idContratoVehiculo;}
    public function getFechaPago(){return $this->fechaPago;}
    public function getMontoPago(){return $this->montoPago;}
    public function getMontoPagoContratoVehiculo(){return $this->montoPagoContratoVehiculo;}
    public function getIdTipoPago(){return $this->tipoPago;}
    public function getObservacion(){return $this->observacion;}
    public function getArchivo(){return $this->archivo;}
    public function getCreated_at(){return $this->created_at;}
    public function getUpdated_at(){return $this->updated_at;}

    public function setIdPago($idPago){$this->idPago = $idPago;}
    public function setIdContratoVehiculo($idContratoVehiculo){$this->idContratoVehiculo = $idContratoVehiculo;}
    public function setFechaPago($fechaPago){$this->fechaPago = $fechaPago;}
    public function setMontoPago($montoPago){$this->montoPago = $montoPago;}
    public function setMontoPagoContratoVehiculo($montoPagoContratoVehiculo){$this->montoPagoContratoVehiculo = $montoPagoContratoVehiculo;}
    public function setIdTipoPago($tipoPago){$this->tipoPago = $tipoPago;}
    public function setObservacion($observacion){$this->observacion = $observacion;}
    public function setArchivo($archivo){$this->archivo = $archivo;}
    public function setCreated_at($created_at){$this->created_at = $created_at;}
    public function setUpdated_at($updated_at){$this->updated_at = $updated_at;}


    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }

    
}
?>