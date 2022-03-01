<?php
class TipoCondicionNivelEducativo implements \JsonSerializable
{
    protected $idTipoCondicionNivelEducativo;
    protected $TipoCondicionNivelEducativo;
        
//_Constructor
	public function __construct() { }
    
//_Devolver Valores (Getters)
    public function getIdTipoCondicionNivelEducativo() { return $this->idTipoCondicionNivelEducativo;}
    public function getTipoCondicionNivelEducativo() { return $this->TipoCondicionNivelEducativo;}

//_Asignar Valores (Setters)
    public function setIdTipoCondicionNivelEducativo($idTipoCondicionNivelEducativo) {  $this->idTipoCondicionNivelEducativo = $idTipoCondicionNivelEducativo; }
    public function setTipoCondicionNivelEducativo($TipoCondicionNivelEducativo) {  $this->TipoCondicionNivelEducativo = $TipoCondicionNivelEducativo; }

//_Devuelve un Vector (array) de Propiedades del Objeto
    public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
	}

    
}

?>