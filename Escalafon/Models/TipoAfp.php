<?php
class TipoAfp implements \JsonSerializable
{
    protected $idTipoAfp;
    protected $tipoAfp;
    
//_Constructor
	public function __construct() {	}

//_Devolver Valores (Getters)
    public function getIdTipoAfp() { return $this->idTipoAfp; }
    public function getTipoAfp() { return $this->tipoAfp; }

//_Asignar Valores (Setters)
    public function setIdTipoAfp($idTipoAfp) { $this->idTipoAfp = $idTipoAfp; }
    public function setTipoAfp($tipoAfp) { $this->tipoAfp = $tipoAfp; }

//_Devuelve un Vector (array) de Propiedades del Objeto
	public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
    }
    


}

?>