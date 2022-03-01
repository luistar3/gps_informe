<?php
class TipoFamiliar implements \JsonSerializable
{
    protected $idTipoFamiliar;
    protected $tipoFamiliar;

//_Constructor
	public function __construct(){ }

//_Devolver Valores (Getters)
    public function getIdTipoFamiliar() { return $this->idTipoFamiliar; }
    public function getTipoFamiliar() { return $this->tipoFamiliar; }

//_Asignar Valores (Setters)
    public function setIdTipoFamiliar($idTipoFamiliar) { $this->idTipoFamiliar = $idTipoFamiliar; }
    public function setTipoFamiliar($tipoFamiliar) { $this->tipoFamiliar = $tipoFamiliar; }

//_Devuelve un Vector (array) de Propiedades del Objeto
    public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
	}

    
}

?>