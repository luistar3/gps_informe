<?php
class Condicion implements \JsonSerializable
{
    protected $idCondicion;
    protected $condicion;
        
//_Constructor
	public function __construct() { }
    
//_Devolver Valores (Getters)
    public function getIdCondicion() { return $this->idCondicion; }
    public function getCondicion() { return $this->condicion; }

//_Asignar Valores (Setters)
    public function setIdCondicion($idCondicion) {  $this->idCondicion = $idCondicion; }
    public function setCondicion($condicion) {  $this->condicion = $condicion; }

//_Devuelve un Vector (array) de Propiedades del Objeto
    public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
	}

    
}

?>