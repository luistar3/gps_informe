<?php
class TipoBrevete implements \JsonSerializable
{
    protected $idTipoBrevete;
    protected $nombre;
    protected $fechaCreacion;

//_Constructor
	public function __construct() {	}

//_Devolver Valores (Getters)
    public function getIdTipoBrevete() {  return $this->idTipoBrevete; }
    public function getNombre() {  return $this->nombre; }
    public function getFechaCreacion() {  return $this->fechaCreacion; }

//_Asignar Valores (Setters)
    public function setIdTipoBrevete($idTipoBrevete) {  $this->idTipoBrevete = $idTipoBrevete; }
    public function setNombre($nombre) {  $this->nombre = $nombre; }
    public function setFechaCreacion($fechaCreacion) {  $this->fechaCreacion = $fechaCreacion; }

//_Devuelve un Vector (array) de Propiedades del Objeto
	public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
	}

            

}

?>