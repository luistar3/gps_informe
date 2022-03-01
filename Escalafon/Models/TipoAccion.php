<?php
class TipoAccion implements \JsonSerializable
{
    protected $idTipoAccion;
    protected $tipo;
    protected $categoria;

//_Constructor
	public function __construct() {	}

//_Devolver Valores (Getters)
    public function getIdTipoAccion() { return $this->idTipoAccion; }
    public function getTipo() { return $this->tipo; }
    public function getCategoria() { return $this->categoria; }

//_Asignar Valores (Setters)
    public function setIdTipoAccion($idTipoAccion) { $this->idTipoAccion = $idTipoAccion; }
    public function setTipo($tipo) { $this->tipo = $tipo; }
    public function setCategoria($categoria) { $this->categoria = $categoria; }

//_Devuelve un Vector (array) de Propiedades del Objeto
    public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
    }
    
        

}

?>