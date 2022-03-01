<?php
class Capacitacion implements \JsonSerializable
{
    protected $idCapacitacion;
    protected $idTrabajador;
    protected $idTipoModalidad;
    protected $idTipoActividadEducativa;
    protected $idTipoCategoria;
    protected $idCurso;
    protected $tomo;
    protected $folio;
    protected $nroRegistro;
    protected $organiza;
    protected $curso;
    protected $fechaInicio;
    protected $fechaTermino;
    protected $horas;
    protected $creditos;
    protected $nota;
    protected $archivo;
    protected $activo;
  
//_Constructor
    public function __construct() { }
    
//_Devolver Valores (Getters)
    public function getIdCapacitacion() { return $this->idCapacitacion; }
    public function getIdTrabajador() { return $this->idTrabajador; }
    public function getIdTipoModalidad() { return $this->idTipoModalidad; }
    public function getIdTipoActividadEducativa() { return $this->idTipoActividadEducativa; }
    public function getIdTipoCategoria() { return $this->idTipoCategoria; }
    public function getIdCurso() { return $this->idCurso; }
    public function getFolio() { return $this->folio; }
    public function getNroRegistro() { return $this->nroRegistro; }
    public function getOrganiza() { return $this->organiza; }
    public function getCurso() { return $this->curso; }
    public function getHoras() { return $this->horas; }
    public function getFechaInicio() { return $this->fechaInicio; }
    public function getFechaTermino() { return $this->fechaTermino; }
    public function getCreditos() { return $this->creditos; }
    public function getNota() { return $this->nota; }
    public function getArchivo() { return $this->archivo; }
    public function getActivo() { return $this->activo; }
    public function getTomo() { return $this->tomo; }

//_Asignar Valores (Setters)
    public function setIdCapacitacion($idCapacitacion) { $this->idCapacitacion = $idCapacitacion; }
    public function setIdTrabajador($idTrabajador) { $this->idTrabajador = $idTrabajador; }
    public function setIdTipoModalidad($idTipoModalidad) { $this->idTipoModalidad = $idTipoModalidad; }
    public function setIdTipoActividadEducativa($idTipoActividadEducativa) { $this->idTipoActividadEducativa = $idTipoActividadEducativa; }
    public function setIdTipoCategoria($idTipoCategoria) { $this->idTipoCategoria = $idTipoCategoria; }
    public function setIdCurso($idCurso) { $this->idCurso = $idCurso; }
    public function setFolio($folio) { $this->folio = $folio; }
    public function setNroRegistro($nroRegistro) { $this->nroRegistro = $nroRegistro; }
    public function setOrganiza($organiza) { $this->organiza = $organiza; }
    public function setCurso($curso) { $this->curso = $curso; }
    public function setFechaInicio($fechaInicio) { $this->fechaInicio = $fechaInicio; }
    public function setFechaTermino($fechaTermino) { $this->fechaTermino = $fechaTermino; }
    public function setHoras($horas) { $this->horas = $horas; }
    public function setCreditos($creditos) { $this->creditos = $creditos; }
    public function setNota($nota) { $this->nota = $nota; }
    public function setArchivo($archivo) { $this->archivo = $archivo; }
    public function setActivo($activo) { $this->activo = $activo; }
    public function setTomo($tomo) { $this->tomo = $tomo; }
   
//_Devuelve un Vector (array) de Propiedades del Objeto
    public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
	}
    


}

?>