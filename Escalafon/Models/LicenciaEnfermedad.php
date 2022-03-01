<?php
class LicenciaEnfermedad implements \JsonSerializable
{
    protected $idLicenciaEnfermedad;
    protected $idTrabajador;
    protected $idServicio;
    protected $idTipoAtencion;
    protected $idContingencia;
    protected $citt;
    protected $fechaInicio;
    protected $fechaTermino;
    protected $dias;
    protected $archivo;
    protected $eliminado;

//_Constructor
	public function __construct() {	}

//_Devolver Valores (Getters)
    public function getIdLicenciaEnfermedad() {  return $this->idLicenciaEnfermedad; }
    public function getIdTrabajador() {  return $this->idTrabajador; }
    public function getIdServicio() {  return $this->idServicio; }
    public function getIdTipoAtencion() {  return $this->idTipoAtencion; }
    public function getIdContingencia() {  return $this->idContingencia; }
    public function getCitt() {  return $this->citt; }
    public function getFechaInicio() {  return $this->fechaInicio; }
    public function getFechaTermino() {  return $this->fechaTermino; }
    public function getDias() {  return $this->dias; }
    public function getArchivo() {  return $this->archivo; }
    public function getEliminado() {  return $this->eliminado; }

//_Asignar Valores (Setters)
    public function setIdLicenciaEnfermedad($idLicenciaEnfermedad)  { $this->idLicenciaEnfermedad = $idLicenciaEnfermedad;  }
    public function setIdTrabajador($idTrabajador)  { $this->idTrabajador = $idTrabajador;  }
    public function setIdServicio($idServicio)  { $this->idServicio = $idServicio;  }
    public function setIdTipoAtencion($idTipoAtencion)  { $this->idTipoAtencion = $idTipoAtencion;  }
    public function setIdContingencia($idContingencia)  { $this->idContingencia = $idContingencia;  }
    public function setCitt($citt)  { $this->citt = $citt;  }
    public function setFechaInicio($fechaInicio)  { $this->fechaInicio = $fechaInicio;  }
    public function setFechaTermino($fechaTermino)  { $this->fechaTermino = $fechaTermino;  }
    public function setDias($dias)  { $this->dias = $dias;  }
    public function setArchivo($archivo)  { $this->archivo = $archivo;  }
    public function setEliminado($eliminado)  { $this->eliminado = $eliminado;  }

//_Devuelve un Vector (array) de Propiedades del Objeto
	public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
	}


}


?>