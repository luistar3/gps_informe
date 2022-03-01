<?php
class TipoNivelEducativo implements \JsonSerializable
{
    protected $idTipoNivelEducativo;
    protected $tipoNivelEducativo;
        
//_Constructor
	public function __construct() { }
    
//_Devolver Valores (Getters)
    public function getIdTipoNivelEducativo() {    return $this->idTipoNivelEducativo;  }
    public function getTipoNivelEducativo() {    return $this->tipoNivelEducativo;  }

//_Asignar Valores (Setters)
    public function setIdTipoNivelEducativo($idTipoNivelEducativo) {  $this->idTipoNivelEducativo = $idTipoNivelEducativo;  }
    public function setTipoNivelEducativo($tipoNivelEducativo) {  $this->tipoNivelEducativo = $tipoNivelEducativo;  }

//_Devuelve un Vector (array) de Propiedades del Objeto
    public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
	}

    
}

?>