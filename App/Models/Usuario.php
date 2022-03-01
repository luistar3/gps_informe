<?php
class Usuario implements \JsonSerializable
{  
    protected $idUsuario;
    protected $idPersona;
    protected $idRol;
    protected $usuario;
    protected $contrasena;
    protected $estado;
    protected $created_at;
    protected $updated_at;

    public function __construct()
    {
    }  
    public function getIdUsuario(){return $this->idUsuario;}
    public function getIdPersona(){return $this->idPersona;}
    public function getIdRol(){return $this->idRol;}
    public function getUsuario(){return $this->usuario;}
    public function getContrasena(){return $this->contrasena;}
    public function getEstado(){return $this->estado;}
    public function getCreated_at(){return $this->created_at;}
    public function getUpdated_at(){return $this->updated_at;}
    
    public function setIdUsuario($idUsuario){$this->idUsuario = $idUsuario;}
    public function setIdPersona($idPersona){$this->idPersona = $idPersona;}
    public function setIdRol($idRol){$this->idRol = $idRol;}
    public function setUsuario($usuario){$this->usuario = $usuario;}
    public function setContrasena($contrasena){$this->contrasena = $contrasena;}
    public function setEstado($estado){$this->estado = $estado;}
    public function setCreated_at($created_at){$this->created_at = $created_at;}
    public function setUpdated_at($updated_at){$this->updated_at = $updated_at;}
   
    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }

}
