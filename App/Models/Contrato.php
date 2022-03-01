<?php
class Contrato implements \JsonSerializable
{     
    protected $idContrato;
    protected $idCliente;
    protected $fechaInicio;
    protected $fechaFin;
    protected $mensualidad;
    protected $contrato;
    protected $estado;
    protected $created_at;
    protected $updated_at;

    public function __construct()
    {
    }  

    public function getIdContrato(){return $this->idContrato;}
    public function getIdCliente(){return $this->idCliente;}
    public function getFechaInicio(){return $this->fechaInicio;}
    public function getFechaFin(){return $this->fechaFin;}
    public function getMensualidad(){return $this->mensualidad;}
    public function getContrato(){return $this->contrato;}
    public function getEstado(){return $this->estado;}
    public function getCreated_at(){return $this->created_at;}
    public function getUpdated_at(){return $this->updated_at;}
    
    public function setIdContrato($idContrato){$this->idContrato = $idContrato;}
    public function setIdCliente($idCliente){$this->idCliente = $idCliente;}
    public function setFechaInicio($fechaInicio){$this->fechaInicio = $fechaInicio;}
    public function setFechaFin($fechaFin){$this->fechaFin = $fechaFin;}
    public function setMensualidad($mensualidad){$this->mensualidad = $mensualidad;}
    public function setContrato($contrato){$this->contrato = $contrato;}
    public function setEstado($estado){$this->estado = $estado;}
    public function setCreated_at($created_at){$this->created_at = $created_at;}
    public function setUpdated_at($updated_at){$this->updated_at = $updated_at;}

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }


    
}
