<?php
class TipoCentroEstudio implements \JsonSerializable
{
    protected $idTipoCentroEstudio;
    protected $tipoCentroEstudio;
        
//_Constructor
	public function __construct() { }
    
//_Devolver Valores (Getters)
    public function getIdTipoCentroEstudio() {  return $this->idTipoCentroEstudio; }
    public function getTipoCentroEstudio() {  return $this->tipoCentroEstudio; }

//_Asignar Valores (Setters)
    public function setIdTipoCentroEstudio($idTipoCentroEstudio)  { $this->idTipoCentroEstudio = $idTipoCentroEstudio; }
    public function setTipoCentroEstudio($tipoCentroEstudio)  { $this->tipoCentroEstudio = $tipoCentroEstudio; }

//_Devuelve un Vector (array) de Propiedades del Objeto
    public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
	}


    
}

?>