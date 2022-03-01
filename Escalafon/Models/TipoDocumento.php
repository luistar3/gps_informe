<?php
class TipoDocumento implements \JsonSerializable
{
    protected $idTipoDocumento;
    protected $tipoDocumento;
    protected $categoriaDocumento;


//_Constructor
	public function __construct(){ }
    
//_Devolver Valores (Getters)
    public function getIdTipoDocumento() { return $this->idTipoDocumento; }
    public function getTipoDocumento() { return $this->tipoDocumento; }
    public function getCategoriaDocumento() { return $this->categoriaDocumento; }

//_Asignar Valores (Setters)
    public function setIdTipoDocumento($idTipoDocumento)  { $this->idTipoDocumento = $idTipoDocumento; }
    public function setTipoDocumento($tipoDocumento)  { $this->tipoDocumento = $tipoDocumento; }
    public function setCategoriaDocumento($categoriaDocumento)  { $this->categoriaDocumento = $categoriaDocumento; }

//_Devuelve un Vector (array) de Propiedades del Objeto
    public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
    }
   


}

?>