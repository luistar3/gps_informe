<?php
class TipoRegimenLaboral implements \JsonSerializable
{
    protected $idTipoRegimenLaboral;
    protected $tipoRegimenLaboral;

//_Constructor
	public function __construct(){  }

//_Devolver Valores (Getters)
    public function getIdTipoRegimenLaboral() { return $this->idTipoRegimenLaboral; }
    public function getTipoRegimenLaboral() { return $this->tipoRegimenLaboral; }

//_Asignar Valores (Setters)
    public function setIdTipoRegimenLaboral($idTipoRegimenLaboral) { $this->idTipoRegimenLaboral = $idTipoRegimenLaboral;  }
    public function setTipoRegimenLaboral($tipoRegimenLaboral) { $this->tipoRegimenLaboral = $tipoRegimenLaboral;  }

//_Devuelve un Vector (array) de Propiedades del Objeto
	public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
	}


    
}

?>



    
