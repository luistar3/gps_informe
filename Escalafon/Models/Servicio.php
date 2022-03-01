<?php
class Servicio implements \JsonSerializable
{
    protected $idServicio;
    protected $servicio;
    

//_Constructor
	public function __construct() {	}

//_Devolver Valores (Getters)

    public function getIdServicio()   { return $this->idServicio;}
    public function getServicio()   { return $this->servicio;}
//_Asignar Valores (Setters)
    public function setIdServicio($idServicio) {     $this->idServicio = $idServicio;  }
    public function setServicio($servicio) {     $this->servicio = $servicio;  }

//_Devuelve un Vector (array) de Propiedades del Objeto
    public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
    }

}

?>