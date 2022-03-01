<?php

class RemuneracionPersonal implements \JsonSerializable
{
	protected $id_remuneracion_personal;
	protected $id_trabajador;
	protected $id_tipo_accion;
	protected $id_tipo_documento;
	protected $numero_documento;
	protected $fecha_documento;
	protected $se_resuelve;
	protected $expediente_judicial;

	protected $fecha_registro;
	protected $hora_registro;
	protected $usuario_registro;

	public function getIdRemuneracionPersonal() { return $this->id_remuneracion_personal; }
	public function getIdTrabajador() { return $this->id_trabajador; }
	public function getIdTipoAccion() { return $this->id_tipo_accion; }
	public function getIdTipoDocumento() { return $this->id_tipo_documento; }
	public function getNumeroDocumento() { return $this->numero_documento; }
	public function getFechaDocumento() { return $this->fecha_documento; }
	public function getSeResuelve() { return $this->se_resuelve; }
	public function getExpedienteJudicial() { return $this->expediente_judicial; }

	public function setIdRemuneracionPersonal($val) { $this->id_remuneracion_personal = $val; }
	public function setIdTrabajador($val) { $this->id_trabajador = $val; }
	public function setIdTipoAccion($val) { $this->id_tipo_accion = $val; }
	public function setIdTipoDocumento($val) { $this->id_tipo_documento = $val; }
	public function setNumeroDocumento($val) { $this->numero_documento = $val; }
	public function setFechaDocumento($val) { $this->fecha_documento = $val; }
	public function setSeResuelve($val) { $this->se_resuelve = $val; }
	public function setExpedienteJudicial($val) { $this->expediente_judicial = $val; }
	

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
