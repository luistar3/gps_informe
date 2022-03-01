<?php
class ProgramacionVacaciones implements \JsonSerializable
{
    protected $idProgramacionVacaciones;
    protected $idTrabajador;
   // protected $idArea;
    protected $condicion;
    protected $anio;
    protected $mesProgramacion;
    protected $mesEfectividad;
    protected $archivo;
    protected $observacion;
    protected $eliminado;

//_Constructor
	public function __construct() {	}

//_Devolver Valores (Getters)
    public function getIdProgramacionVacaciones() { return $this->idProgramacionVacaciones; }
    public function getIdTrabajador() { return $this->idTrabajador; }
    //public function getIdArea() { return $this->idArea; }
    public function getCondicion() {  return $this->condicion; }
    public function getAnio() { return $this->anio; }
    public function getMesProgramacion() { return $this->mesProgramacion; }
    public function getMesEfectividad() { return $this->mesEfectividad; }
    public function getArchivo() { return $this->archivo; }
    public function getObservacion() { return $this->observacion; }
    public function getEliminado() { return $this->eliminado; }

//_Asignar Valores (Setters)
    public function setIdProgramacionVacaciones($idProgramacionVacaciones) {  $this->idProgramacionVacaciones = $idProgramacionVacaciones; }
    public function setIdTrabajador($idTrabajador) {  $this->idTrabajador = $idTrabajador; }
    //public function setIdArea($idArea) {  $this->idArea = $idArea; }
    public function setCondicion($condicion) { $this->condicion = $condicion; }
    public function setAnio($anio) {  $this->anio = $anio; }
    public function setMesProgramacion($mesProgramacion) {  $this->mesProgramacion = $mesProgramacion; }
    public function setMesEfectividad($mesEfectividad) {  $this->mesEfectividad = $mesEfectividad; }
    public function setArchivo($archivo) {  $this->archivo = $archivo; }
    public function setObservacion($observacion) {  $this->observacion = $observacion; }
    public function setEliminado($eliminado) {  $this->eliminado = $eliminado; }

//_Devuelve un Vector (array) de Propiedades del Objeto
    public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
    }


    
}

?>