<?php
class HorarioTrabajador implements \JsonSerializable
{
   
    protected $idHorarioTrabajador;
    protected $idTrabajador;
    protected $idTrabajadorReloj;
    protected $horaIngreso;
    protected $horaSalida;
    protected $eliminado;
    protected $actual;





//_Constructor
	public function __construct() {	}

//_Devolver Valores (Getters)

    public function getIdHorarioTrabajador() { return $this->idHorarioTrabajador; }
    public function getIdTrabajador() { return $this->idTrabajador; }
    public function getIdTrabajadorReloj() { return $this->idTrabajadorReloj; }
    public function getHoraIngreso() { return $this->horaIngreso; }
    public function getHoraSalida() { return $this->horaSalida; }
    public function getEliminado() { return $this->eliminado; }
    public function getActual()  {   return $this->actual; }

//_Asignar Valores (Setters)

    public function setIdHorarioTrabajador($idHorarioTrabajador) {    $this->idHorarioTrabajador = $idHorarioTrabajador; }
    public function setIdTrabajador($idTrabajador) {    $this->idTrabajador = $idTrabajador; }
    public function setIdTrabajadorReloj($idTrabajadorReloj) {    $this->idTrabajadorReloj = $idTrabajadorReloj; }
    public function setHoraIngreso($horaIngreso) {    $this->horaIngreso = $horaIngreso; }
    public function setHoraSalida($horaSalida) {    $this->horaSalida = $horaSalida; }
    public function setEliminado($eliminado) {    $this->eliminado = $eliminado; }
    public function setActual($actual) {   $this->actual = $actual;  }

//_Devuelve un Vector (array) de Propiedades del Objeto
    public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
    }



}

?>