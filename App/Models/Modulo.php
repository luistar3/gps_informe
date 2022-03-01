<?php
class Modulo implements \JsonSerializable
{  
    protected $idModulo;
    protected $modulo;
    protected $descripcion;
    protected $estado;
    protected $created_at;
    protected $updated_at;

    public function __construct()
    {
    }  

    public function getIdModulo(){ return $this->idModulo;}
    public function getModulo(){ return $this->modulo;}
    public function getDescripcion(){ return $this->descripcion;}
    public function getEstado(){ return $this->estado;}
    public function getCreated_at(){ return $this->created_at;}
    public function getUpdated_at(){ return $this->updated_at;}

    public function setIdModulo($idModulo){$this->idModulo = $idModulo;}
    public function setModulo($modulo){$this->modulo = $modulo;}
    public function setDescripcion($descripcion){$this->descripcion = $descripcion;}
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