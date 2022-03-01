<?php
class TipoRegimenPension implements \JsonSerializable
{
    protected $idTipoRegimenPension;
    protected $tipoRegimenPension;
    
//_Constructor
	public function __construct(){ }

//_Devolver Valores (Getters)
    public function getIdTipoRegimenPension() {  return $this->idTipoRegimenPension;  }
    public function getTipoRegimenPension() {  return $this->tipoRegimenPension;  }

//_Asignar Valores (Setters)
    public function setIdTipoRegimenPension($idTipoRegimenPension) { $this->idTipoRegimenPension = $idTipoRegimenPension; }
    public function setTipoRegimenPension($tipoRegimenPension) { $this->tipoRegimenPension = $tipoRegimenPension; }

//_Devuelve un Vector (array) de Propiedades del Objeto
	public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
	}


    
}

?>
