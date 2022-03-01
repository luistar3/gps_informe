<?php
class ControlAsistencia implements \JsonSerializable
{
    protected $idControlAsistencia;
    protected $idTrabajador;
    protected $idTrabajadorReloj;
    protected $fecha;
    protected $horaIngreso;
    protected $horaSalida;


//_Constructor
	public function __construct() {	}

//_Devolver Valores (Getters)
    public function getIdControlAsistencia() { return $this->idControlAsistencia; }
    public function getIdTrabajador() { return $this->idTrabajador; }
    public function getIdtrabajadorReloj() { return $this->idTrabajadorReloj; }
    public function getFecha() { return $this->fecha; }
    public function getHoraIngreso() { return $this->horaIngreso; }
    public function getHoraSalida() { return $this->horaSalida; }

//_Asignar Valores (Setters)
    public function setIdControlAsistencia($idControlAsistencia) { $this->idControlAsistencia = $idControlAsistencia; }
    public function setIdTrabajador($idTrabajador) { $this->idTrabajador = $idTrabajador; }
    public function setIdtrabajadorReloj($idTrabajadorReloj) { $this->idTrabajadorReloj = $idTrabajadorReloj; }
    public function setFecha($fecha) { $this->fecha = $fecha; }
    public function setHoraIngreso($horaIngreso) { $this->horaIngreso = $horaIngreso; }
    public function setHoraSalida($horaSalida) { $this->horaSalida = $horaSalida; }

//_Devuelve un Vector (array) de Propiedades del Objeto
	public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
	}

    
}


?>