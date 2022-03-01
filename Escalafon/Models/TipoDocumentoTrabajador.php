<?php
class TipoDocumentoTrabajador implements \JsonSerializable
{
    protected $idTipoDocumentoTrabajador;
    protected $tipoDocumento;
    
//_Constructor
	public function __construct(){	}

//_Devolver Valores (Getters)
    public function getIdTipoDocumentoTrabajador() { return $this->idTipoDocumentoTrabajador;  }
    public function getTipoDocumento() { return $this->tipoDocumento;  }

//_Asignar Valores (Setters)
    public function setIdTipoDocumentoTrabajador($idTipoDocumentoTrabajador) { $this->idTipoDocumentoTrabajador = $idTipoDocumentoTrabajador; }
    public function setTipoDocumento($tipoDocumento) { $this->tipoDocumento = $tipoDocumento; }

//_Devuelve un Vector (array) de Propiedades del Objeto
    public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
	}

}

?>