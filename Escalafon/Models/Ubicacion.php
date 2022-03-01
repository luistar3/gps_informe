<?php
class Ubicacion implements \JsonSerializable
{
    protected $idUbicacion;
    protected $nombreUbicacion;
    protected $aliasUbicacion;
    
//_Constructor
	public function __construct(){	}

//_Devolver Valores (Getters)
    public function getIdUbicacion() { return $this->idUbicacion; }
    public function getNombreUbicacion() { return $this->nombreUbicacion; }
    public function getAliasUbicacion() { return $this->aliasUbicacion; }

//_Asignar Valores (Setters)
    public function setIdUbicacion($idUbicacion) {  $this->idUbicacion = $idUbicacion; }
    public function setNombreUbicacion($nombreUbicacion) {  $this->nombreUbicacion = $nombreUbicacion; }
    public function setAliasUbicacion($aliasUbicacion) {  $this->aliasUbicacion = $aliasUbicacion; }

//_Devuelve un Vector (array) de Propiedades del Objeto
	public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
	}


    
}

?>

