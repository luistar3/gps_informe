<?php
class TipoActividadEducativa implements \JsonSerializable
{
    protected $idTipoActividadEducativa;
    protected $tipoActividadEducativa;

//_Constructor
	public function __construct() {	}

//_Devolver Valores (Getters)
    public function getIdTipoActividadEducativa() { return $this->idTipoActividadEducativa; }
    public function getTipoActividadEducativa() { return $this->tipoActividadEducativa; }
    
//_Asignar Valores (Setters)
    public function setIdTipoActividadEducativa($idTipoActividadEducativa) { $this->idTipoActividadEducativa = $idTipoActividadEducativa; }
    public function setTipoActividadEducativa($tipoActividadEducativa) { $this->tipoActividadEducativa = $tipoActividadEducativa; }
   
//_Devuelve un Vector (array) de Propiedades del Objeto
    public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
    }

}

?>