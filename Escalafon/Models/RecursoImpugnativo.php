<?php

class RecursoImpugnativo implements \JsonSerializable
{
	protected $id_recurso_impugnativo;
	protected $id_proceso_administrativo_disciplinario;
	protected $id_tipo_recurso_impugnativo;
	protected $documento;
	protected $fecha_documento;
	protected $archivo;
	protected $detalle;

	protected $fecha_registro;
	protected $hora_registro;
	protected $usuario_registro;

	public function getIdRecursoImpugnativo() { return $this->id_recurso_impugnativo; }
	public function getIdProcesoAdministrativoDisciplinario() { return $this->id_proceso_administrativo_disciplinario; }
	public function getIdTipoRecursoImpugnativo() { return $this->id_tipo_recurso_impugnativo; }
	public function getDocumento() { return $this->documento; }
	public function getFechaDocumento() { return $this->fecha_documento; }
	public function getArchivo() { return $this->archivo; }
	public function getDetalle() { return $this->detalle; }

	public function setIdRecursoImpugnativo($val) { $this->id_recurso_impugnativo = $val; }
	public function setIdProcesoAdministrativoDisciplinario($val) { $this->id_proceso_administrativo_disciplinario = $val; }
	public function setIdTipoRecursoImpugnativo($val) { $this->id_tipo_recurso_impugnativo = $val; }
	public function setDocumento($val) { $this->documento = $val; }
	public function setFechaDocumento($val) { $this->fecha_documento = $val; }
	public function setArchivo($val) { $this->archivo = $val; }
	public function setDetalle($val) { $this->detalle = $val; }
	
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
