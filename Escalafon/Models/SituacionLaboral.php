<?php
class SituacionLaboral implements \JsonSerializable
{
    protected $idSituacionLaboral;
    protected $situacionLaboral;

//_Constructor
	public function __construct() {	}

//_Devolver Valores (Getters)
    public function getIdSituacionLaboral() {  return $this->idSituacionLaboral; }
    public function getSituacionLaboral() {  return $this->situacionLaboral; }

//_Asignar Valores (Setters)
    public function setIdSituacionLaboral($idSituacionLaboral) {   $this->idSituacionLaboral = $idSituacionLaboral; }
    public function setSituacionLaboral($situacionLaboral) {   $this->situacionLaboral = $situacionLaboral; }  

//_Devuelve un Vector (array) de Propiedades del Objeto
    public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
    }
    
}

?>