<?php

class ConstanciaHaberes implements \JsonSerializable
{
	protected $id_constancia_haberes;
	protected $id_trabajador;
	protected $id_tipo_accion;
	protected $id_tipo_documento;
	protected $numero_documento;
	protected $fecha_documento;
	protected $lugar;
	protected $nivel;
	protected $cargo;
	protected $anios;
	protected $meses;
	protected $dias;
	protected $fecha_retiro;
	protected $fecha_inicio;
	protected $fecha_termino;
	protected $devengado;
	protected $reintegro;
	protected $total;
	protected $observacion;
	protected $archivo;

	protected $fecha_registro;
	protected $hora_registro;
	protected $usuario_registro;

	public function getIdConstanciaHaberes() { return $this->id_constancia_haberes; }
	public function getIdTrabajador() { return $this->id_trabajador; }
	public function getIdTipoAccion() { return $this->id_tipo_accion; }
	public function getIdTipoDocumento() { return $this->id_tipo_documento; }
	public function getNumeroDocumento() { return $this->numero_documento; }
	public function getFechaDocumento() { return $this->fecha_documento; }
	public function getLugar() { return $this->lugar; }
	public function getNivel() { return $this->nivel; }
	public function getCargo() { return $this->cargo; }
	public function getAnios() { return $this->anios; }
	public function getMeses() { return $this->meses; }
	public function getDias() { return $this->dias; }
	public function getFechaRetiro() { return $this->fecha_retiro; }
	public function getFechaInicio() { return $this->fecha_inicio; }
	public function getFechaTermino() { return $this->fecha_termino; }
	public function getDevengado() { return $this->devengado; }
	public function getReintegro() { return $this->reintegro; }
	public function getTotal() { return $this->total; }
	public function getObservacion() { return $this->observacion; }
	public function getArchivo() { return $this->archivo; }

	public function setIdConstanciaHaberes($val) { $this->id_constancia_haberes = $val; }
	public function setIdTrabajador($val) { $this->id_trabajador = $val; }
	public function setIdTipoAccion($val) { $this->id_tipo_accion = $val; }
	public function setIdTipoDocumento($val) { $this->id_tipo_documento = $val; }
	public function setNumeroDocumento($val) { $this->numero_documento = $val; }
	public function setFechaDocumento($val) { $this->fecha_documento = $val; }
	public function setLugar($val) { $this->lugar = $val; }
	public function setNivel($val) { $this->nivel = $val; }
	public function setCargo($val) { $this->cargo = $val; }
	public function setAnios($val) { $this->anios = $val; }
	public function setMeses($val) { $this->meses = $val; }
	public function setDias($val) { $this->dias = $val; }
	public function setFechaRetiro($val) { $this->fecha_retiro = $val; }
	public function setFechaInicio($val) { $this->fecha_inicio = $val; }
	public function setFechaTermino($val) { $this->fecha_termino = $val; }
	public function setDevengado($val) { $this->devengado = $val; }
	public function setReintegrp($val) { $this->reintegro = $val; }
	public function setTotal($val) { $this->total = $val; }
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
