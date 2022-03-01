<?php
class TipoCasa implements \JsonSerializable
{
    protected $idTipoCasa;
    protected $tipoCasa;
        
//_Constructor
	public function __construct() { }
    
//_Devolver Valores (Getters)
    public function getIdTipoCasa() { return $this->idTipoCasa; }
    public function getTipoCasa() { return $this->tipoCasa; }

//_Asignar Valores (Setters)
    public function setIdTipoCasa($idTipoCasa) {  $this->idTipoCasa = $idTipoCasa; }
    public function setTipoCasa($tipoCasa) {  $this->tipoCasa = $tipoCasa; }

//_Devuelve un Vector (array) de Propiedades del Objeto
    public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
	}

    
}

?>