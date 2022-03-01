<?php

class SueldoTrabajador implements \JsonSerializable
{
	protected $id_sueldo;
	protected $id_trabajador;
	protected $sueldo;
	protected $actual;
	protected $fecha_creacion;

	public function getIdSueldo() { return $this->id_sueldo; }
	public function getIdTrabajador() { return $this->id_trabajador; }
	public function getSueldo() { return $this->sueldo; }
	public function getActual() { return $this->actual; }
	public function getFechaCreacion() { return $this->fecha_creacion; }

	public function setIdSueldo($val) { $this->id_sueldo = $val; }
	public function setIdTrabajador($val) { $this->id_trabajador = $val; }
	public function setSueldo($val) { $this->sueldo = $val; }
	public function setActual($val) { $this->actual = $val; }
	public function setFechaCreacion($val) { $this->fecha_creacion = $val; }

	public function jsonSerialize() {
		$vars = get_object_vars($this);
		return $vars;
	}
}
