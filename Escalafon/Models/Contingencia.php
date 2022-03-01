<?php
class Contingencia implements \JsonSerializable
{
    protected $idContingencia;
    protected $contingencia;
    

//_Constructor
	public function __construct() {	}

//_Devolver Valores (Getters)

    public function getIdContingencia() { return $this->idContingencia;  }
    public function getContingencia() { return $this->contingencia;  }
//_Asignar Valores (Setters)
    public function setIdContingencia($idContingencia) { $this->idContingencia = $idContingencia;  }
    public function setContingencia($contingencia) { $this->contingencia = $contingencia;  }

//_Devuelve un Vector (array) de Propiedades del Objeto
    public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
    }

    
}

?>