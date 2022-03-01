<?php

class RemuneracionQuintil implements \JsonSerializable
{
	protected $id_remuneracion_quintil;
	protected $id_trabajador;
	protected $id_tipo_documento;
	protected $numero_documento;
	protected $fecha_documento;
	protected $porcentaje;
	protected $fecha_apertura;
	protected $fecha_termino;
	protected $fecha_posterior;
	protected $informe_quintil;
	protected $fecha_quintil;

	protected $fecha_registro;
	protected $hora_registro;
	protected $usuario_registro;

	public function getIdRemuneracionQuintil() { return $this->id_remuneracion_quintil; }
	public function getIdTrabajador() { return $this->id_trabajador; }
	public function getTipoDocumento() { return $this->id_tipo_documento; }
	public function getNumeroDocumento() { return $this->numero_documento; }
	public function getFechaDocumento() { return $this->fecha_documento; }
	public function getPorcentaje() { return $this->porcentaje; }
	public function getFechaApertura() { return $this->fecha_apertura; }
	public function getFechaTermino() { return $this->fecha_termino; }
	public function getFechaPosterior() { return $this->fecha_posterior; }
	public function getInformeQuintil() { return $this->informe_quintil; }
	public function getFechaQuintil() { return $this->fecha_quintil; }

	public function setIdRemuneracionQuintil($val) { $this->id_remuneracion_quintil = $val; }
	public function setIdTrabajador($val) { $this->id_trabajador = $val; }
	public function setIdTipoDocumento($val) { $this->id_tipo_documento = $val; }
	public function setNumeroDocumento($val) { $this->numero_documento = $val; }
	public function setFechaDocumento($val) { $this->fecha_documento = $val; }
	public function setPorcentaje($val) { $this->porcentaje = $val; }
	public function setFechaApertura($val) { $this->fecha_apertura = $val; }
	public function setFechaTermino($val) { $this->fecha_termino = $val; }
	public function setFechaPosterior($val) { $this->fecha_posterior = $val; }
	public function setInformeQuintil($val) { $this->informe_quintil = $val; }
	public function setFechaQuintil($val) { $this->fecha_quintil = $val; }
	

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
