<?php
class DocumentoDesplazamiento implements \JsonSerializable
{
    protected $idDocumentoDesplazamiento;
    protected $idDocumento;
    protected $idTipoDocumentoDesplazamiento;
    protected $idDesplazamiento;
    protected $eliminado;

//_Constructor
	public function __construct(){ }

//_Devolver Valores (Getters)
    public function getIdDocumentoDesplazamiento() {  return $this->idDocumentoDesplazamiento; }
    public function getIdDocumento() {   return $this->idDocumento; }
    public function getIdDesplazamiento() {  return $this->idDesplazamiento; }
    public function getEliminado() {   return $this->eliminado; }
    public function getIdTipoDocumentoDesplazamiento() {  return $this->idTipoDocumentoDesplazamiento; }

//_Asignar Valores (Setters)
    public function setIdDocumentoDesplazamiento($idDocumentoDesplazamiento)  {  $this->idDocumentoDesplazamiento = $idDocumentoDesplazamiento; }
    public function setIdDocumento($idDocumento) { $this->idDocumento = $idDocumento;  }
    public function setIdDesplazamiento($idDesplazamiento)  {  $this->idDesplazamiento = $idDesplazamiento;  }
    public function setEliminado($eliminado) { $this->eliminado = $eliminado;    }
    public function setIdTipoDocumentoDesplazamiento($idTipoDocumentoDesplazamiento) {  $this->idTipoDocumentoDesplazamiento = $idTipoDocumentoDesplazamiento;}

//_Devuelve un Vector (array) de Propiedades del Objeto
    public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
    }
    

}

?>