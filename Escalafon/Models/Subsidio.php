<?php

class Subsidio implements \JsonSerializable
{
	protected $id_subsidio;
	protected $id_trabajador;
	protected $id_tipo_accion;
	protected $id_tipo_documento;
	protected $id_tipo_resolucion;
	protected $numero_documento;
	protected $fecha_documento;
	protected $asunto;
	protected $numero_resolucion;
	protected $fecha;
	protected $observacion;
	protected $archivo;

	protected $fecha_registro;
	protected $hora_registro;
	protected $usuario_registro;

	public function getIdSubsidio() { return $this->id_subsidio; }
	public function getIdTrabajador() { return $this->id_trabajador; }
	public function getIdTipoAccion() { return $this->id_tipo_accion; }
	public function getIdTipoDocumento() { return $this->id_tipo_documento; }
	public function getIdTipoResolucion() { return $this->id_tipo_resolucion; }
	public function getNumeroDocumento() { return $this->numero_documento; }
	public function getFechaDocumento() { return $this->fecha_documento; }
	public function getAsunto() { return $this->asunto; }
	public function getNumeroResolucion() { return $this->numero_resolucion; }
	public function getFecha() { return $this->fecha; }
	public function getObservacion() { return $this->observacion; }
	public function getArchivo() { return $this->archivo; }

	public function setIdSubsidio($val) { $this->id_subsidio = $val; }
	public function setIdTrabajador($val) { $this->id_trabajador = $val; }
	public function setIdTipoAccion($val) { $this->id_tipo_accion = $val; }
	public function setIdTipoDocumento($val) { $this->id_tipo_documento = $val; }
	public function setIdResolucion($val) { $this->id_tipo_resolucion = $val; }
	public function setNumeroDocumento($val) { $this->numero_documento = $val; }
	public function setFechaDocumento($val) { $this->fecha_documento = $val; }
	public function setAsunto($val) { $this->asunto = $val; }
	public function setNumeroResolucion($val) { $this->numero_resolucion = $val; }
	public function setFecha($val) { $this->fecha = $val; }
	public function setObservacion($val) { $this->observacion = $val; }
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
