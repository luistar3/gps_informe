<?php
class DocumentoTrabajador implements \JsonSerializable
{
    protected $idDocumentoTrabajador;
    protected $idTipoDocumentoTrabajador;
    protected $idTrabajador;
    protected $descripcion;
    protected $ruta;
    protected $eliminado;
    
//_Constructor
	public function __construct() {	 $this->eliminado=0; }

    //_Devolver Valores (Getters)
    public function getIdDocumentoTrabajador() { return $this->idDocumentoTrabajador; }
    public function getIdTipoDocumentoTrabajador() { return $this->idTipoDocumentoTrabajador; }
    public function getIdTrabajador() { return $this->idTrabajador; }
    public function getDescripcion() { return $this->descripcion; }
    public function getRuta() { return $this->ruta; }
    public function getEliminado()    { return $this->eliminado; }

//_Asignar Valores (Setters)
    public function setIdDocumentoTrabajador($idDocumentoTrabajador) { $this->idDocumentoTrabajador = $idDocumentoTrabajador; }
    public function setIdTipoDocumentoTrabajador($idTipoDocumentoTrabajador) { $this->idTipoDocumentoTrabajador = $idTipoDocumentoTrabajador; }
    public function setIdTrabajador($idTrabajador) { $this->idTrabajador = $idTrabajador; }
    public function setDescripcion($descripcion)  { $this->descripcion = $descripcion; }
    public function setRuta($ruta) { $this->ruta = $ruta; }
    public function setEliminado($eliminado)  {  $this->eliminado = $eliminado; }

//_Devuelve un Vector (array) de Propiedades del Objeto
    public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
	}

}

?>