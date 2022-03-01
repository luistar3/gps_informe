<?php
class Rol implements \JsonSerializable
{  
    protected $idRol;
    protected $nombre;
    protected $estado;
    protected $created_at;
    protected $updated_at;

    public function __construct()
    {
    }  

    public function getIdRol(){return $this->idRol;}
    public function getNombre(){return $this->nombre;}
    public function getEstado(){return $this->estado;}
    public function getCreated_at(){return $this->created_at;}
    public function getUpdated_at(){return $this->updated_at;}

    public function setIdRol($idRol){$this->idRol = $idRol;}
    public function setNombre($nombre){$this->nombre = $nombre;}
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