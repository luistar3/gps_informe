<?php

class Evaluacion implements \JsonSerializable
{
	protected $id_evaluacion;
	protected $id_trabajador;
	protected $fecha;
	protected $periodo;
	protected $numero;
	protected $nombre_evaluador;
	protected $desempeno_conducta_laboral;
	protected $asistencia;
	protected $puntualidad;
	protected $capacidad;
	protected $total;
	protected $rango_evaluacion;
	protected $archivo;

	protected $fecha_registro;
	protected $hora_registro;
	protected $usuario_registro;

	public function getIdEvaluacion() { return $this->id_evaluacion; }
	public function getIdTrabajador() { return $this->id_trabajador; }
	public function getFecha() { return $this->fecha; }
	public function getPeriodo() { return $this->periodo; }
	public function getNumero() { return $this->numero; }
	public function getNombreEvaluador() { return $this->nombre_evaluador; }
	public function getDesempenoConductaLaboral() { return $this->desempeno_conducta_laboral; }
	public function getAsistencia() { return $this->asistencia; }
	public function getPuntualidad() { return $this->puntualidad; }
	public function getCapacidad() { return $this->capacidad; }
	public function getTotal() { return $this->total; }
	public function getRangoEvaluacion() { return $this->rango_evaluacion; }
	public function getArchivo() { return $this->archivo; }

	public function setIdEvaluacion($val) { $this->id_evaluacion = $val; }
	public function setIdTrabajador($val) { $this->id_trabajador = $val; }
	public function setFecha($val) { $this->fecha = $val; }
	public function setPeriodo($val) { $this->periodo = $val; }
	public function setNumero($val) { $this->numero = $val; }
	public function setNombreEvaluador($val) { $this->nombre_evaluador = $val; }
	public function setDesempenoConductaLaboral($val) { $this->desempeno_conducta_laboral = $val; }
	public function setAsistencia($val) { $this->asistencia = $val; }
	public function setPuntualidad($val) { $this->puntualidad = $val; }
	public function setCapacidad($val) { $this->capacidad = $val; }
	public function setTotal($val) { $this->total = $val; }
	public function setRangoEvaluacion($val) { $this->rango_evaluacion = $val; }
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
