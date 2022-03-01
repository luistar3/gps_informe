<?php
class UnidadEjecutora implements \JsonSerializable
{
    protected $idUnidadEjecutora;
    protected $unidadEjecutora;
    
//_Constructor
	public function __construct(){ }

//_Devolver Valores (Getters)
    public function getIdUnidadEjecutora() { return $this->idUnidadEjecutora; }
    public function getUnidadEjecutora() { return $this->unidadEjecutora; }

//_Asignar Valores (Setters)
    public function setIdUnidadEjecutora($idUnidadEjecutora) {  $this->idUnidadEjecutora = $idUnidadEjecutora; }
    public function setUnidadEjecutora($unidadEjecutora) {  $this->unidadEjecutora = $unidadEjecutora; }

//_Devuelve un Vector (array) de Propiedades del Objeto
	public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
	}

    
}

?>
