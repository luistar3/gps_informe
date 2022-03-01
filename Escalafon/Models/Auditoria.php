<?php

class Auditoria implements \JsonSerializable
{
	protected $id_auditoria;
	protected $id_usuario;
	protected $fecha_hora;
	protected $ip;
	protected $tabla;
	protected $objeto_id_nombre;
	protected $objeto_id_valor;
	protected $objeto;
	protected $id_operacion;
	protected $uri;
	protected $fecha;
	protected $hora;
	protected $usuario;

//_Devolver Valores (Getters)
	public function getIdAuditoria() { return $this->id_auditoria; }
	public function getIdUsuario() { return $this->id_usuario; }
	public function getFechaHora() { return $this->fecha_hora; }
	public function getIP() { return $this->ip; }
	public function getTabla() { return $this->tabla; }
	public function getObjetoIdNombre() { return $this->objeto_id_nombre; }
	public function getObjetoIdValor() { return $this->objeto_id_valor; }
	public function getObjeto() { return $this->objeto; }
	public function getIdOperacion() { return $this->id_operacion; }
	public function getURI() { return $this->uri; }
	public function getFecha() { return $this->fecha; }
	public function getHora() { return $this->hora; }
	public function getUsuario() { return $this->usuario; }

//_Asignar Valores (Setters)
	public function setIdAuditoria($val) { $this->id_auditoria = $val; }
	public function setIdUsuario($val) { $this->id_usuario = $val; }
	public function setFechaHora($val) { $this->fecha_hora = $val; }
	public function setIP($val) { $this->ip = $val; }
	public function setTabla($val) { $this->tabla = $val; }
	public function setObjetoIdNombre($val) { $this->objeto_id_nombre = $val; }
	public function setObjetoIdValor($val) { $this->objeto_id_valor = $val; }
	public function setObjeto($val) { $this->objeto = $val; }
	public function setIdOperacion($val) { $this->id_operacion = $val; }
	public function setURI($val) { $this->uri = $val; }
	public function setFecha($val) { $this->fecha = $val; }
	public function setHora($val) { $this->hora = $val; }
	public function setUsuario($val) { $this->usuario = $val; }

//_Devuelve un Vector (array) de Propiedades del Objeto
	public function jsonSerialize() {
		$vars = get_object_vars($this);
		return $vars;
	}


}
