<?php

class RemuneracionFamiliar implements \JsonSerializable
{
	protected $id_remuneracion_familiar;
	protected $id_trabajador;
	protected $id_familiar;
	protected $asunto;
	protected $numero_documento;
	protected $fecha_documento;
	protected $archivo;

	protected $familiar_nombre_completo;
	protected $familiar_parentesco;

	protected $fecha_registro;
	protected $hora_registro;
	protected $usuario_registro;

	public function getIdRemuneracionFamiliar() { return $this->id_remuneracion_familiar; }
	public function getIdTrabajador() { return $this->id_trabajador; }
	public function getIdFamiliar() { return $this->id_familiar; }
	public function getAsunto() { return $this->asunto; }
	public function getNumeroDocumento() { return $this->numero_documento; }
	public function getFechaDocumento() { return $this->fecha_documento; }
	public function getArchivo() { return $this->archivo; }

	public function setIdRemuneracionFamiliar($val) { $this->id_remuneracion_familiar = $val; }
	public function setIdTrabajador($val) { $this->id_trabajador = $val; }
	public function setIdFamiliar($val) { $this->id_familiar = $val; }
	public function setAsunto($val) { $this->asunto = $val; }
	public function setNumeroDocumento($val) { $this->numero_documento = $val; }
	public function setFechaDocumento($val) { $this->fecha_documento = $val; }
	public function setArchivo($val) { $this->archivo = $val; }

	public function getFamiliarNombreCompleto() { return $this->familiar_nombre_completo; }
	public function getFamiliarParentesco() { return $this->familiar_parentesco; }

	public function setFamiliarNombreCompleto($val) { $this->familiar_nombre_completo = $val; }
	public function setFamiliarParentesco($val) { $this->familiar_parentesco = $val; }
	
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
