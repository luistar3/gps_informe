<?php
class NivelEspecializacion implements \JsonSerializable
{
    protected $idNivelEspecializacion;
    protected $idTrabajador;
    protected $idTipoNivelEspecializacion;
    protected $anio;
    protected $nombreEspecializacion;
    protected $procedencia;
    protected $archivo;
    protected $eliminado;

    
//_Constructor
	public function __construct(){	}

//_Devolver Valores (Getters)
    public function getIdNivelEspecializacion() { return $this->idNivelEspecializacion; }
    public function getIdTrabajador() { return $this->idTrabajador; }
    public function getIdTipoNivelEspecializacion()  {    return $this->idTipoNivelEspecializacion; }
    public function getAnio() { return $this->anio; }
    public function getNombreEspecializacion() { return $this->nombreEspecializacion; }
    public function getProcedencia() { return $this->procedencia; }
    public function getEliminado() { return $this->eliminado; }
    public function getArchivo() { return $this->archivo; }

    
//_Asignar Valores (Setters)
    public function setIdNivelEspecializacion($idNivelEspecializacion) {  $this->idNivelEspecializacion = $idNivelEspecializacion; }
    public function setIdTrabajador($idTrabajador) {  $this->idTrabajador = $idTrabajador; }
    public function setIdTipoNivelEspecializacion($idTipoNivelEspecializacion)  {   $this->idTipoNivelEspecializacion = $idTipoNivelEspecializacion;  }
    public function setAnio($anio) {  $this->anio = $anio; }
    public function setNombreEspecializacion($nombreEspecializacion) {  $this->nombreEspecializacion = $nombreEspecializacion; }
    public function setProcedencia($procedencia) {  $this->procedencia = $procedencia; }
    public function setEliminado($eliminado) {  $this->eliminado = $eliminado; }
    public function setArchivo($archivo) {  $this->archivo = $archivo; }

//_Devuelve un Vector (array) de Propiedades del Objeto
    public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
	}

    
}

?>