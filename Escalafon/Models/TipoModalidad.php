<?php
class TipoModalidad implements \JsonSerializable
{
    protected $idTipoModalidad;
    protected $tipoModalidad;

//_Constructor
	public function __construct(){ }

//_Devolver Valores (Getters)
    public function getIdTipoModalidad() { return $this->idTipoModalidad; }
    public function getTipoModalidad() { return $this->tipoModalidad; }

//_Asignar Valores (Setters)
    public function setIdTipoModalidad($idTipoModalidad) { $this->idTipoModalidad = $idTipoModalidad; }
    public function setTipoModalidad($tipoModalidad) { $this->tipoModalidad = $tipoModalidad; }

//_Devuelve un Vector (array) de Propiedades del Objeto
    public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
	}

    
}

?>
