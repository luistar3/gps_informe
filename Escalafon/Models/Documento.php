<?php
class Documento implements \JsonSerializable
{
    protected $idDocumento;
	protected $ruta;
	protected $fechaCreacion;
        
//_Constructor
	public function __construct(){	}
  
//_Devolver Valores (Getters)
    public function getIdDocumento() {  return $this->idDocumento;  }
	public function getRuta() {	return $this->ruta;	}
	public function getFechaCreacion()	{	return $this->fechaCreacion; }
 
//_Asignar Valores (Setters)
	public function setIdDocumento($idDocumento)  {  $this->idDocumento = $idDocumento;  }
	public function setRuta($ruta)	{ $this->ruta = $ruta;	}
	public function setFechaCreacion($fechaCreacion) { $this->fechaCreacion = $fechaCreacion;	}

//_Devuelve un Vector (array) de Propiedades del Objeto
	public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
	}


	
}

?>