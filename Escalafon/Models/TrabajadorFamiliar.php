<?php
class TrabajadorFamiliar implements \JsonSerializable
{
    protected $idTrabajadorFamiliar;
    protected $idTrabajador;
    protected $idTipoFamiliar;
    protected $idFamiliar;
    protected $eliminado;

//_Constructor
	public function __construct(){ }


//_Devolver Valores (Getters)
    public function getIdTrabajadorFamiliar() { return $this->idTrabajadorFamiliar; }
    public function getIdTrabajador() { return $this->idTrabajador; }
    public function getIdTipoFamiliar() { return $this->idTipoFamiliar; }
    public function getIdFamiliar() { return $this->idFamiliar; }
    public function getEliminado() { return $this->eliminado; }


//_Asignar Valores (Setters)
    public function setIdTrabajadorFamiliar($idTrabajadorFamiliar) { $this->idTrabajadorFamiliar = $idTrabajadorFamiliar; }
    public function setIdTrabajador($idTrabajador) { $this->idTrabajador = $idTrabajador; }
    public function setIdTipoFamiliar($idTipoFamiliar) { $this->idTipoFamiliar = $idTipoFamiliar; }
    public function setIdFamiliar($idFamiliar) { $this->idFamiliar = $idFamiliar; }
    public function setEliminado($eliminado) { $this->eliminado = $eliminado; }

//_Devuelve un Vector (array) de Propiedades del Objeto
    public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
	}

    
}

?>

