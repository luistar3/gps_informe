<?php
class Merito implements \JsonSerializable
{
    protected $idMerito;
    protected $idTipoDocumentoMerito;
    protected $idTrabajador;
    protected $fechaDocumento;
    protected $motivo;
    protected $dias;
    protected $documento;
    protected $fechaEvento;
    protected $archivo;
    protected $eliminado;

    
//_Constructor
	public function __construct() {	}

//_Devolver Valores (Getters)
    public function getIdMerito() { return $this->idMerito; }
    public function getIdTipoDocumentoMerito() { return $this->idTipoDocumentoMerito; }
    public function getIdTrabajador() { return $this->idTrabajador; }
    public function getFechaDocumento() { return $this->fechaDocumento; }
    public function getMotivo() {  return $this->motivo;  }
    public function getDias() { return $this->dias; }
    public function getDocumento() { return $this->documento; }
    public function getFechaEvento() { return $this->fechaEvento; }
    public function getArchivo() { return $this->archivo; }
    public function getEliminado() { return $this->eliminado; }

//_Asignar Valores (Setters)
    public function setIdMerito($idMerito) {  $this->idMerito = $idMerito; }
    public function setIdTipoDocumentoMerito($idTipoDocumentoMerito) { $this->idTipoDocumentoMerito = $idTipoDocumentoMerito; }
    public function setIdTrabajador($idTrabajador) { $this->idTrabajador = $idTrabajador; }
    public function setFechaDocumento($fechaDocumento) { $this->fechaDocumento = $fechaDocumento; }
    public function setMotivo($motivo)  {  $this->motivo = $motivo;  }
    public function setDias($dias) { $this->dias = $dias; }
    public function setDocumento($documento) { $this->documento = $documento; }
    public function setFechaEvento($fechaEvento) { $this->fechaEvento = $fechaEvento; }
    public function setArchivo($archivo) { $this->archivo = $archivo; }
    public function setEliminado($eliminado) { $this->eliminado = $eliminado; }


//_Devuelve un Vector (array) de Propiedades del Objeto
    public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
    }


    
}

?>