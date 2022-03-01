<?php
class TipoEstadoCivil implements \JsonSerializable
{
    protected $idTipoEstadoCivil;
    protected $tipoEstadoCivil;
    
//_Constructor
	public function __construct(){ }

//_Devolver Valores (Getters)
    public function getIdTipoEstadoCivil() { return $this->idTipoEstadoCivil; }
    public function getTipoEstadoCivil() { return $this->tipoEstadoCivil; }

//_Asignar Valores (Setters)
    public function setIdTipoEstadoCivil($idTipoEstadoCivil) {  $this->idTipoEstadoCivil = $idTipoEstadoCivil; }
    public function setTipoEstadoCivil($tipoEstadoCivil) {  $this->tipoEstadoCivil = $tipoEstadoCivil; }

//_Devuelve un Vector (array) de Propiedades del Objeto
    public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
	}


}

?>