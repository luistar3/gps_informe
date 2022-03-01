<?php

class ProcesoAdministrativoDisciplinario implements \JsonSerializable
{
	protected $id_proceso_administrativo_disciplinario;
	protected $id_trabajador;
	protected $id_tipo_documento;
	protected $motivo;
	protected $fecha_comision_hechos;
	protected $fecha_conocimiento_degdrrhh;
	protected $precalificacion;
	protected $fecha_precalificacion;
	protected $inicio;
	protected $fecha_inicio;
	protected $fin;
	protected $fecha_fin;
	protected $resolucion_administrativa;
	protected $sentencia;
	protected $total_dias_sancion;
	protected $estado;

	protected $fecha_registro;
	protected $hora_registro;
	protected $usuario_registro;

	public function getIdProcesoAdministrativoDisciplinario() { return $this->id_proceso_administrativo_disciplinario; }
	public function getIdTrabajador() { return $this->id_trabajador; }
	public function getIdTipoDocumento() { return $this->id_tipo_documento; }
	public function getMotivo() { return $this->motivo; }
	public function getFechaComisionHechos() { return $this->fecha_comision_hechos; }
	public function getFechaConocimientoDEGDRRHH() { return $this->fecha_conocimiento_degdrrhh; }
	public function getPrecalificacion() { return $this->precalificacion; }
	public function getFechaPrecalificacion() { return $this->fecha_precalificacion; }
	public function getInicio() { return $this->inicio; }
	public function getFechaInicio() { return $this->fecha_inicio; }
	public function getFin() { return $this->fin; }
	public function getFechaFin() { return $this->fecha_fin; }
	public function getResolucionAdministrativa() { return $this->resolucion_administrativa; }
	public function getSentencia() { return $this->sentencia; }
	public function getTotalDiasSancion() { return $this->total_dias_sancion; }
	public function getEstado() { return $this->estado; }

	public function setIdProcesoAdministrativoDisciplinario($val) { $this->id_proceso_administrativo_disciplinario = $val; }
	public function setIdTrabajador($val) { $this->id_trabajador = $val; }
	public function setIdTipoDocumento($val) { $this->id_tipo_documento = $val; }
	public function setMotivo($val) { $this->motivo = $val; }
	public function setFechaComisionHechos($val) { $this->fecha_comision_hechos = $val; }
	public function setFechaConocimientoDEGDRRHH($val) { $this->fecha_conocimiento_degdrrhh = $val; }
	public function setPrecalificacion($val) { $this->precalificacion = $val; }
	public function setFechaPrecalificacion($val) { $this->fecha_precalificacion = $val; }
	public function setInicio($val) { $this->inicio = $val; }
	public function setFechaInicio($val) { $this->fecha_inicio = $val; }
	public function setFin($val) { $this->fin = $val; }
	public function setFechaFin($val) { $this->fecha_fin = $val; }
	public function setResolucionAdministrativa($val) { $this->resolucion_administrativa = $val; }
	public function setSentencia($val) { $this->sentencia = $val; }
	public function setTotalDiasSancion($val) { $this->total_dias_sancion = $val; }
	public function setEstado($val) { $this->estado = $val; }
	
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
