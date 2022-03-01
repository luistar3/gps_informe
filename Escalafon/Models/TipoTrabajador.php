<?php
class TipoTrabajador implements \JsonSerializable
{
    protected $idTipoTrabajador;
    protected $tipoTrabajador;
	
//_Constructor
	public function __construct(){ }

//_Devolver Valores (Getters)
    public function getIdTipoTrabajador() {  return $this->idTipoTrabajador;  }
    public function getTipoTrabajador() {  return $this->tipoTrabajador;  }

//_Asignar Valores (Setters)
    public function setIdTipoTrabajador($idTipoTrabajador) {  $this->idTipoTrabajador = $idTipoTrabajador; }
    public function setTipoTrabajador($tipoTrabajador) {  $this->tipoTrabajador = $tipoTrabajador; }

//_Devuelve un Vector (array) de Propiedades del Objeto
	public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
	}


    
}

?>

