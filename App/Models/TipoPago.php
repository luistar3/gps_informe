<?php
class Cliente implements \JsonSerializable
{  
    protected $idTipoPago;
    protected $tipoPago;
   
    public function __construct()
    {
    }  


    public function getIdTipoPago(){return $this->idTipoPago;}
    public function getTipoPago(){return $this->pago;}

    public function setIdTipoPago($idTipoPago){$this->idTipoPago = $idTipoPago;}
    public function setTipoPago($pago){$this->pago = $pago;}
    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }

    
}
?>