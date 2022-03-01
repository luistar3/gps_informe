<?php
class TipoArea implements \JsonSerializable
{
    protected $idTipoArea;
    protected $nombre;
    protected $estado;
    protected $fechaCreacion;

//_Constructor
	public function __construct() {	}

//_Devolver Valores (Getters)
    public function getIdTipoArea() { return $this->idTipoArea; }
    public function getNombre(){ return $this->nombre; }
    public function getEstado() { return $this->estado; }
    public function getFechaCreacion() { return $this->fechaCreacion; }

//_Asignar Valores (Setters)
    public function setIdTipoArea($val) { $this->idTipoArea = $val; }
    public function setNombre($val) { $this->nombre = $val; }
    public function setEstado($val) { $this->estado = $val; }
    public function setFechaCreacion($val) { $this->fechaCreacion = $val; }

//_Devuelve un Vector (array) de Propiedades del Objeto
    public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
    }  
}
?>