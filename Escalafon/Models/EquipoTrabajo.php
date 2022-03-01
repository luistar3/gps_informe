<?php
class EquipoTrabajo implements \JsonSerializable {
	protected $idEquipoTrabajo;
	protected $nombreEquipoTrabajo;
	protected $descripcionEquipoTrabajo;
	protected $estado;
	protected $fechaCreacion;

//_Constructor
	public function __construct() {}

//_Devolver Valores (Getters)
	public function getIdEquipoTrabajo() {
		return $this->idEquipoTrabajo;
	}
	public function getNombreEquipoTrabajo() {
		return $this->nombreEquipoTrabajo;
	}
	public function getDescripcionEquipoTrabajo() {
		return $this->descripcionEquipoTrabajo;
	}
	public function getEstado() {
		return $this->estado;
	}
	public function getFechaCreacion() {
		return $this->fechaCreacion;
	}
	
//_Asignar Valores (Setters)
	public function setIdEquipoTrabajo($val) {
		$this->idEquipoTrabajo = $val;
	}
	public function setNombreEquipoTrabajo($val) {
		$this->nombreEquipoTrabajo = $val;
	}
	public function setDescripcionEquipoTrabajo($val) {
		$this->descripcionEquipoTrabajo = $val;
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