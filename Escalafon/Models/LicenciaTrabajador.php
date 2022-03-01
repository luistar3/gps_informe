<?php
class LicenciaTrabajador implements \JsonSerializable
{
    protected $idLicenciaTrabajador;
    protected $idTrabajador;
    protected $idTipoAccion;
    protected $tipoAccion;
    protected $idTipoDocumento;
    protected $tipoDocumento;
    protected $idTipoLicencia;
    protected $documento;
    protected $resolucion;
    protected $fechaInicio;
    protected $fechaTermino;
    protected $dias;
    protected $archivo;
    protected $eliminado;

//_Constructor
	public function __construct() {	}

//_Devolver Valores (Getters)
    public function getIdLicenciaTrabajador() {  return $this->idLicenciaTrabajador; }
    public function getIdTrabajador() { return $this->idTrabajador; }
    public function getIdTipoAccion() {  return $this->idTipoAccion; }
    public function getTipoAccion() {  return $this->tipoAccion; }
    public function getIdTipoDocumento() {  return $this->idTipoDocumento; }
    public function getTipoDocumento() {  return $this->tipoDocumento; }
    public function getIdTipoLicencia() {  return $this->idTipoLicencia; }
    public function getDocumento() {  return $this->documento; }
    public function getResolucion() {  return $this->resolucion; }
    public function getFechaInicio() {  return $this->fechaInicio; }
    public function getFechaTermino() {  return $this->fechaTermino; }
    public function getDias() {  return $this->dias; }
    public function getArchivo() {  return $this->archivo; }
    public function getEliminado() {  return $this->eliminado; }

//_Asignar Valores (Setters)
    public function setIdLicenciaTrabajador($idLicenciaTrabajador) { $this->idLicenciaTrabajador = $idLicenciaTrabajador; }
    public function setIdTrabajador($idTrabajador) { $this->idTrabajador = $idTrabajador; }
    public function setIdTipoAccion($idTipoAccion) { $this->idTipoAccion = $idTipoAccion; }
    public function setTipoAccion($tipoAccion) { $this->tipoAccion = $tipoAccion; }
    public function setIdTipoDocumento($idTipoDocumento) { $this->idTipoDocumento = $idTipoDocumento; }
    public function setTipoDocumento($tipoDocumento) { $this->tipoDocumento = $tipoDocumento; }
    public function setIdTipoLicencia($idTipoLicencia) { $this->idTipoLicencia = $idTipoLicencia; }
    public function setDocumento($documento) { $this->documento = $documento; }
    public function setResolucion($resolucion) { $this->resolucion = $resolucion; }
    public function setFechaInicio($fechaInicio) { $this->fechaInicio = $fechaInicio; }
    public function setFechaTermino($fechaTermino) { $this->fechaTermino = $fechaTermino; }
    public function setDias($dias) { $this->dias = $dias; }
    public function setArchivo($archivo) { $this->archivo = $archivo; }
    public function setEliminado($eliminado) { $this->eliminado = $eliminado; }

//_Devuelve un Vector (array) de Propiedades del Objeto
    public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
    }

    
}

?>