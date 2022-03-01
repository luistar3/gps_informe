<?php
class TipoCondicion implements \JsonSerializable
{
    protected $idTipoCondicion;
    protected $tipoCondicion;
    
//_Constructor
	public function __construct() {	}

//_Devolver Valores (Getters)
    public function getIdTipoCondicion() { return $this->idTipoCondicion; }
    public function getTipoCondicion() { return $this->tipoCondicion; }

//_Asignar Valores (Setters)
    public function setIdTipoCondicion($idTipoCondicion)  {  $this->idTipoCondicion = $idTipoCondicion; }
    public function setTipoCondicion($tipoCondicion)  {  $this->tipoCondicion = $tipoCondicion; }

//_Devuelve un Vector (array) de Propiedades del Objeto
	public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
	}


    
}

?>