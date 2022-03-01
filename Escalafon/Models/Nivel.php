<?php
class Nivel implements \JsonSerializable
{
    protected $idNivel;
    protected $denom;
    protected $remniv;
    protected $selniv;
    protected $orden;
    protected $tiptrrap;
 
//_Constructor
	public function __construct() {	}

//_Devolver Valores (Getters)
    public function getIdNivel() { return $this->idNivel; }
    public function getDenom() { return $this->denom; }
    public function getRemniv() { return $this->remniv; }
    public function getSelniv() { return $this->selniv; }
    public function getOrden() { return $this->orden; }
    public function getTiptrrap() { return $this->tiptrrap; }
   
//_Asignar Valores (Setters)
    public function setIdNivel($idNivel) { $this->idNivel = $idNivel; }
    public function setDenom($denom) { $this->denom = $denom; }
    public function setRemniv($remniv) { $this->remniv = $remniv; }
    public function setSelniv($selniv) { $this->selniv = $selniv; }
    public function setOrden($orden) { $this->orden = $orden; }
    public function setTiptrrap($tiptrrap) { $this->tiptrrap = $tiptrrap; }

//_Devuelve un Vector (array) de Propiedades del Objeto
    public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
	}

}

?>