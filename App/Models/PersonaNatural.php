<?php
class PersonaNatural implements \JsonSerializable
{
    protected $idPersona;
    protected $nombres;
    protected $apellidos;
    protected $telefono;
    protected $dni;
    protected $direccion;
    protected $correo;
    protected $created_at;
    protected $updated_at;
    
    public function __construct()
    {
    }   
    public function getIdPersona(){return $this->idPersona;}
    public function getNombres(){return $this->nombres;}
    public function getApellidos(){return $this->apellidos;}
    public function getTelefono(){return $this->telefono;}
    public function getDni(){return $this->dni;}
    public function getDireccion(){return $this->direccion;}
    public function getCorreo(){return $this->correo;}
    public function getCreated_at(){return $this->created_at;}
    public function getUpdated_at(){return $this->updated_at;}


    public function setIdPersona($idPersona){$this->idPersona = $idPersona;}
    public function setNombres($nombres){$this->nombres = $nombres;}
    public function setApellidos($apellidos){$this->apellidos = $apellidos;}
    public function setTelefono($telefono){$this->telefono = $telefono;}
    public function setDni($dni){$this->dni = $dni;}
    public function setDireccion($direccion){$this->direccion = $direccion;}
    public function setCorreo($correo){$this->correo = $correo;}
    public function setCreated_at($created_at){$this->created_at = $created_at;}
    public function setUpdated_at($updated_at){$this->updated_at = $updated_at;}

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
   
}
