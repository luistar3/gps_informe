<?php

class AuditoriaArchivo implements \JsonSerializable
{
	protected $nombre;
	protected $nombre_original;
	protected $ruta;
	protected $tamano;

//_Devolver Valores (Getters)
	public function getNombre() { return $this->nombre; }
	public function getNombreOriginal() { return $this->nombre_original; }
	public function getRuta() { return $this->ruta; }
	public function getTamano() { return $this->tamano; }

//_Asignar Valores (Setters)
	public function setNombre($val) { $this->nombre = $val; }
	public function setNombreOriginal($val) { $this->nombre_original = $val; }
	public function setRuta($val) { $this->ruta = $val; }
	public function setTamano($val) { $this->tamano = $val; }

//_Devuelve un Vector (array) de Propiedades del Objeto
	public function jsonSerialize() {
		$vars = get_object_vars($this);
		return $vars;
	}




}
