<?php
class TipoDocumentoDesplazamiento implements \JsonSerializable
{
    protected $idTipoDocumentoDesplazamiento;
    protected $tipoDocumentoDesplazamiento;
    
//_Constructor
	public function __construct() {	}

//_Devolver Valores (Getters)
    public function getIdTipoDocumentoDesplazamiento() { return $this->idTipoDocumentoDesplazamiento; }
    public function getTipoDocumentoDesplazamiento() { return $this->tipoDocumentoDesplazamiento; }

//_Asignar Valores (Setters)
    public function setIdTipoDocumentoDesplazamiento($idTipoDocumentoDesplazamiento) { $this->idTipoDocumentoDesplazamiento = $idTipoDocumentoDesplazamiento; }
    public function setTipoDocumentoDesplazamiento($tipoDocumentoDesplazamiento) { $this->tipoDocumentoDesplazamiento = $tipoDocumentoDesplazamiento; }

//_Devuelve un Vector (array) de Propiedades del Objeto
    public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
	}
  


    
}

?>