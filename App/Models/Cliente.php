<?php
class Cliente implements \JsonSerializable
{  
    protected $idCliente;
    protected $idPersona;
    protected $idJuridico;
    protected $ultimoPago;
  
    protected $estado;
    protected $created_at;
    protected $updated_at;

    public function __construct()
    {
    }  

    public function getIdCliente(){ return $this->idCliente; }
    public function getIdPersona(){ return $this->idPersona; }
    public function getIdJuridico(){ return $this->idJuridico; }
    public function getUltimoPago(){ return $this->ultimoPago; }
    public function getEstado(){ return $this->estado; }
    public function getCreated_at(){ return $this->created_at; }
    public function getUpdated_at(){ return $this->updated_at; }



    public function setIdCliente($idCliente){$this->idCliente = $idCliente;}
    public function setIdPersona($idPersona){$this->idPersona = $idPersona;}
    public function setIdJuridico($idJuridico){$this->idJuridico = $idJuridico;}
    public function setUltimoPago($ultimoPago){$this->ultimoPago = $ultimoPago;}
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