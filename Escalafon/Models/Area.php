<?php
class Area implements \JsonSerializable
{
    protected $idArea;
    protected $idPadre;
    protected $idTipoArea;
    protected $nombreArea;
    protected $sigla;
    protected $nivel;
    protected $descripcion;
    protected $estado;
    protected $fechaCreacion;
    protected $fechaModificacion;

//_Constructor
	public function __construct() {	}

//_Devolver Valores (Getters)
    public function getIdArea() { return $this->idArea; }
    public function getIdPadre() { return $this->idPadre; }
    public function getIdTipoArea() { return $this->idTipoArea; }
    public function getNombreArea(){ return $this->nombreArea; }
    public function getSigla() { return $this->idSigla; }
    public function getIdNivel() { return $this->idNivel; }
    public function getDescripcion() { return $this->descripcion; }
    public function getEstado() { return $this->estado; }
    public function getFechaCreacion() { return $this->fechaCreacion; }
    public function getFechaModificacion() { return $this->fechaModificacion; }

//_Asignar Valores (Setters)
    public function setIdArea($val) { $this->idArea = $val; }
    public function setIdPadre($val) { $this->idPadre = $val; }
    public function setIdTipoArea($val) { $this->idTipoArea = $val; }
    public function setNombreArea($val) { $this->nombreArea = $val; }
    public function setSigla($val) { $this->idSigla = $val; }
    public function setIdNivel($val) { $this->idNivel = $val; }
    public function setDescripcion($val) { $this->descripcion = $val; }
    public function setEstado($val) { $this->estado = $val; }
    public function setFechaCreacion($val) { $this->fechaCreacion = $val; }
    public function setFechaModificacion($val) { $this->fechaModificacion = $val; }

//_Devuelve un Vector (array) de Propiedades del Objeto
    public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
    }  
}
?>