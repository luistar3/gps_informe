<?php

class Inasistencia implements \JsonSerializable
{
	protected $id_inasistencia;
	protected $id_trabajador;
	protected $id_tipo_documento;
	protected $id_area;
	protected $numero_documento;
	protected $numero_dias;
	protected $fecha;
	protected $archivo;

	protected $fecha_registro;
	protected $hora_registro;
	protected $usuario_registro;

	public function getIdInasistencia() { return $this->id_inasistencia; }
	public function getIdTrabajador() { return $this->id_trabajador; }
	public function getIdTipoDocumento() { return $this->id_tipo_documento; }
	public function getIdArea() { return $this->id_area; }
	public function getNumeroDocumento() { return $this->numero_documento; }
	public function getNumeroDias() { return $this->numero_dias; }
	public function getFecha() { return $this->fecha; }
	public function getArchivo() { return $this->archivo; }

	public function setIdInasistencia($val) { $this->id_inasistencia = $val; }
	public function setIdTrabajador($val) { $this->id_trabajador = $val; }
	public function setIdTipoDocumento($val) { $this->id_tipo_documento = $val; }
	public function setArea($val) { $this->id_area = $val; }
	public function setNumeroDocumento($val) { $this->numero_documento = $val; }
	public function setNumeroDias($val) { $this->numero_dias = $val; }
	public function setFecha($val) { $this->fecha = $val; }
	public function setArchivo($val) { $this->archivo = $val; }
	
	public function getFechaRegistro() { return $this->fecha_registro; }
	public function getHoraRegistro() { return $this->hora_registro; }
	public function getUsuarioRegistro() { return $this->usuario_registro; }

	public function setFechaRegistro($val) { $this->fecha_registro = $val; }
	public function setHoraRegistro($val) { $this->hora_registro = $val; }
	public function setUsuarioRegistro($val) { $this->usuario_registro = $val; }

	public function jsonSerialize() {
		$vars = get_object_vars($this);
		return $vars;
	}
}
