<?php
class Direccion implements \JsonSerializable {
	protected $idDireccion;
	protected $nombreDireccion;
	protected $descripcionDireccion;
	protected $estado;
	protected $fechaCreacion;

//_Constructor
	public function __construct() {}

//_Devolver Valores (Getters)
	public function getIdDireccion() {
		return $this->idDireccion;
	}
	public function getNombreDireccion() {
		return $this->nombreDireccion;
	}
	public function getDescripcionDireccion() {
		return $this->descripcionDireccion;
	}
	public function getEstado() {
		return $this->estado;
	}
	public function getFechaCreacion() {
		return $this->fechaCreacion;
	}
	
//_Asignar Valores (Setters)
	public function setIdDireccion($val) {
		$this->idDireccion = $val;
	}
	public function setNombreDireccion($val) {
		$this->nombreDireccion = $val;
	}
	public function setDescripcionDireccion($val) {
		$this->descripcionDireccion = $val;
	}
	public function setEstado($val) {
		$this->estado = $val;
	}
	public function setFechaCreacion($val) {
		$this->fechaCreacion = $val;
	}

//_Devuelve un Vector (array) de Propiedades del Objeto
	public function jsonSerialize() {
		$vars = get_object_vars($this);
		return $vars;
	}
}
?>