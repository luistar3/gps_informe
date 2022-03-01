<?php
class Desplazamiento implements \JsonSerializable
{
    protected $idDesplazamiento;
//	protected $idEquipoTrabajo;
	protected $idTipoAccion;
	protected $idTipoDocumento;
	protected $idCargo;
	protected $idArea;
	protected $idTrabajador;
	protected $numeroDocumento;
	protected $direccionOficina;
	protected $oficina;
	protected $division;
	protected $denominacionCargo;
	protected $fechaInicio;
	protected $fechaTermino;
	protected $fechaEfectividad;
	protected $observacion;
	protected $expedienteJudicial;
	protected $actual;
	protected $anulado;
	protected $eliminado;

	protected $numeroResolucionInicio;
	protected $numeroResolucionTermino;
	protected $tipoVinculoLaboral;
	protected $renuncia;
	protected $inicioRenovacionCas;
	protected $terminoRenovacionCas;
	protected $metaPeriodo;
	protected $numeroConvocatoria;
	protected $idFteFto;
   
//_Constructor
	public function __construct(){	}

//_Devolver Valores (Getters)
	public function getIdDesplazamiento() {  return $this->idDesplazamiento; }
	//public function getIdEquipoTrabajo() { return $this->idEquipoTrabajo;}
	public function getIdTipoAccion() { return $this->idTipoAccion;}
	public function getIdTipoDocumento() { return $this->idTipoDocumento;}
	public function getIdCargo() { return $this->idCargo; }
	public function getIdArea() { return $this->idArea; }
	public function getIdTrabajador() { return $this->idTrabajador; }
	public function getNumeroDocumento() { return $this->numeroDocumento; }
	public function getDireccionOficina() { return $this->direccionOficina; }
	public function getOficina() { return $this->oficina; }
	public function getDivision() { return $this->division; }
	public function getDenominacionCargo() { return $this->denominacionCargo; }
	public function getFechaInicio() { return $this->fechaInicio; }
	public function getFechaTermino() { return $this->fechaTermino; }
	public function getFechaEfectividad() { return $this->fechaEfectividad; }
	public function getObservacion() { return $this->observacion; }
	public function getExpedienteJudicial() { return $this->expedienteJudicial; }
	public function getActual() { return $this->actual; }
	public function getAnulado() { return $this->anulado; }
	public function getEliminado() { return $this->eliminado; }

	public function getNumeroResolucionInicio(){return $this->numeroResolucionInicio;}
	public function getNumeroResolucionTermino(){return $this->numeroResolucionTermino;}
	public function getTipoVinculoLaboral(){return $this->tipoVinculoLaboral;}
	public function getRenuncia(){return $this->renuncia;}
	public function getInicioRenovacionCas(){return $this->inicioRenovacionCas;}
	public function getTerminoRenovacionCas(){return $this->terminoRenovacionCas;}
	public function getMetaPeriodo(){return $this->metaPeriodo;}
	public function getNumeroConvocatoria(){return $this->numeroConvocatoria;}
	public function getIdFteFto(){	return $this->idFteFto;	}

//_Asignar Valores (Setters)
    public function setIdDesplazamiento($idDesplazamiento) { $this->idDesplazamiento = $idDesplazamiento; }
	//public function setIdEquipoTrabajo($idEquipoTrabajo) { $this->idEquipoTrabajo = $idEquipoTrabajo; }
	public function setIdTipoAccion($idTipoAccion) { $this->idTipoAccion = $idTipoAccion; }
	public function setIdTipoDocumento($idTipoDocumento) { $this->idTipoDocumento = $idTipoDocumento; }
	public function setIdCargo($idCargo) { 	$this->idCargo = $idCargo; }
	public function setIdArea($idArea)	{ $this->idArea = $idArea; }
	public function setIdTrabajador($idTrabajador)	{ $this->idTrabajador = $idTrabajador; }
	public function setNumeroDocumento($numeroDocumento)  {	$this->numeroDocumento = $numeroDocumento;	}
	public function setDireccionOficina($direccionOficina)	{ $this->direccionOficina = $direccionOficina;	}
	public function setOficina($oficina) {	$this->oficina = $oficina;	} 
	public function setDivision($division) { $this->division = $division; }
	public function setDenominacionCargo($denominacionCargo) {	$this->denominacionCargo = $denominacionCargo;	}
	public function setFechaInicio($fechaInicio) { $this->fechaInicio = $fechaInicio;	}
	public function setFechaTermino($fechaTermino)	{ $this->fechaTermino = $fechaTermino; }
	public function setFechaEfectividad($fechaEfectividad)	{ $this->fechaEfectividad = $fechaEfectividad;	}
	public function setObservacion($observacion) {	$this->observacion = $observacion;	}
	public function setExpedienteJudicial($expedienteJudicial)	{ $this->expedienteJudicial = $expedienteJudicial; }
	public function setActual($actual)	{	$this->actual = $actual; }
	public function setAnulado($anulado) { $this->anulado = $anulado;	}
	public function setEliminado($eliminado) { $this->eliminado = $eliminado; }

	public function setNumeroResolucionInicio($numeroResolucionInicio)	{	$this->numeroResolucionInicio = $numeroResolucionInicio;	}
	public function setNumeroResolucionTermino($numeroResolucionTermino)	{	$this->numeroResolucionTermino = $numeroResolucionTermino;	}
	public function setTipoVinculoLaboral($tipoVinculoLaboral)	{	$this->tipoVinculoLaboral = $tipoVinculoLaboral;	}
	public function setRenuncia($renuncia)	{	$this->renuncia = $renuncia;	}
	public function setInicioRenovacionCas($inicioRenovacionCas)	{	$this->inicioRenovacionCas = $inicioRenovacionCas;	}
	public function setTerminoRenovacionCas($terminoRenovacionCas)	{	$this->terminoRenovacionCas = $terminoRenovacionCas;	}
	public function setMetaPeriodo($metaPeriodo)	{	$this->metaPeriodo = $metaPeriodo;	}
	public function setNumeroConvocatoria($numeroConvocatoria)	{	$this->numeroConvocatoria = $numeroConvocatoria;	}
	public function setIdFteFto($idFteFto)	{	$this->idFteFto = $idFteFto;}

//_Devuelve un Vector (array) de Propiedades del Objeto
	public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
	}


	

	/**
	 * Get the value of idFteFto
	 */ 
	

	/**
	 * Set the value of idFteFto
	 *
	 * @return  self
	 */ 
	
}

?>