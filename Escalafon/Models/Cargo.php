<?php
class Cargo implements \JsonSerializable
{
    protected $idCargo;
    protected $nombreCargo;
    protected $salarioMinimo;
    protected $salarioMaximo;

//_Constructor
	public function __construct() {	}

//_Devolver Valores (Getters)
    public function getIdCargo() { return $this->idCargo; }
    public function getNombreCargo() { return $this->nombreCargo; }
    public function getSalarioMinimo() { return $this->salarioMinimo; }
    public function getSalarioMaximo() { return $this->salarioMaximo; }

//_Asignar Valores (Setters)
    public function setIdCargo($idCargo) { $this->idCargo = $idCargo; }
    public function setNombreCargo($nombreCargo) { $this->nombreCargo = $nombreCargo; }
    public function setSalarioMinimo($salarioMinimo) { $this->salarioMinimo = $salarioMinimo; }
    public function setSalarioMaximo($salarioMaximo) { $this->salarioMaximo = $salarioMaximo; }

//_Devuelve un Vector (array) de Propiedades del Objeto
	public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
	}

}


?>