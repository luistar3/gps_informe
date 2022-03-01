<?php
class TipoAtencion implements \JsonSerializable
{
    protected $idTipoAtencion;
    protected $tipoAtencion;
    

//_Constructor
	public function __construct() {	}

//_Devolver Valores (Getters)
    public function getIdTipoAtencion() { return $this->idTipoAtencion;  }
    public function getTipoAtencion() { return $this->tipoAtencion;  }
//_Asignar Valores (Setters)
    public function setIdTipoAtencion($idTipoAtencion) {  $this->idTipoAtencion = $idTipoAtencion;  }
    public function setTipoAtencion($tipoAtencion) {  $this->tipoAtencion = $tipoAtencion;  }

//_Devuelve un Vector (array) de Propiedades del Objeto
    public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
    }

    
}

?>