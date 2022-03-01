<?php
class TipoCategoria implements \JsonSerializable
{
    protected $idTipoCategoria;
    protected $tipoCategoria;

//_Constructor
	public function __construct() {  }
 
//_Devolver Valores (Getters)
    public function getIdTipoCategoria() { return $this->idTipoCategoria; }
    public function getTipoCategoria() { return $this->tipoCategoria; }

//_Asignar Valores (Setters)
    public function setIdTipoCategoria($idTipoCategoria) {  $this->idTipoCategoria = $idTipoCategoria; }
    public function setTipoCategoria($tipoCategoria) {  $this->tipoCategoria = $tipoCategoria; }

//_Devuelve un Vector (array) de Propiedades del Objeto
    public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
    }

    
}

?>