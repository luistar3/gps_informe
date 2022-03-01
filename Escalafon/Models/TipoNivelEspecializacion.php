<?php
class TipoNivelEspecializacion implements \JsonSerializable
{
    protected $idTipoNivelEspecializacion;
    protected $tipoNivelEspecializacion;
        
//_Constructor
	public function __construct() { }
    
//_Devolver Valores (Getters)
    public function getIdTipoNivelEspecializacion() {  return $this->idTipoNivelEspecializacion; }
    public function getTipoNivelEspecializacion() {  return $this->tipoNivelEspecializacion; }

//_Asignar Valores (Setters)
    public function setIdTipoNivelEspecializacion($idTipoNivelEspecializacion) {   $this->idTipoNivelEspecializacion = $idTipoNivelEspecializacion;   }
    public function setTipoNivelEspecializacion($tipoNivelEspecializacion) {   $this->tipoNivelEspecializacion = $tipoNivelEspecializacion;   }

//_Devuelve un Vector (array) de Propiedades del Objeto
    public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
	}

    
}

?>