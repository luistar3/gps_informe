<?php

require_once '../../App/General/Models/PersonaNatural.php';
class Trabajador extends PersonaNatural implements \JsonSerializable 
{
    protected $idTrabajador;  
    protected $idTipoRegimenPension;
    protected $idTipoAfp;
    protected $idTipoRegimenLaboral;
    protected $idTipoTrabajador;
    protected $idUnidadEjecutora;
    protected $idTipoCondicion;
    protected $idNivel;
    protected $libretaMilitar;
    protected $nroBrevete;
    protected $codigoUnico;
    protected $estadoCivil;
    protected $casa;
    protected $idTipoBrevete;
    protected $suspendido;

    protected $idSituacionLaboral;
    protected $grupoSanguineo;
    protected $ubigeo;
    protected $pais;
    protected $codigoPlaza;

    protected $numeroContratoCas;
    protected $inicioContrato;
    protected $terminoContrato;
    protected $metaPeriodo;
    protected $numeroConvocatoria;


//_Constructor
	public function __construct(){$this->foto='default.jpg';}

//_Devolver Valores (Getters)
	public function getIdTrabajador() { return $this->idTrabajador;  }
    public function getIdTipoRegimenPension() { return $this->idTipoRegimenPension;  }
    public function getIdTipoAfp() { return $this->idTipoAfp;  }
    public function getIdTipoRegimenLaboral() { return $this->idTipoRegimenLaboral;  }
    public function getIdTipoTrabajador() { return $this->idTipoTrabajador;  }
    public function getIdUnidadEjecutora() { return $this->idUnidadEjecutora;  }
    public function getIdTipoCondicion() { return $this->idTipoCondicion;  }
    public function getIdNivel() { return $this->idNivel;  }
    public function getLibretaMilitar() { return $this->libretaMilitar;  }
    public function getNroBrevete() { return $this->nroBrevete;  }
    public function getCodigoUnico() { return $this->codigoUnico;  }
    public function getEstadoCivil() { return $this->estadoCivil;  }
    public function getCasa() { return $this->casa;  }
    public function getSuspendido() { return $this->suspendido;  }
    public function getIdTipoBrevete() { return $this->idTipoBrevete;  }


    public function getIdSituacionLaboral() { return $this->idSituacionLaboral; }
    public function getGrupoSanguineo() { return $this->grupoSanguineo; }
    public function getUbigeo() { return $this->ubigeo; }
    public function getPais() { return $this->pais; }
    public function getCodigoPlaza() { return $this->codigoPlaza; }

    public function getNumeroContratoCas()  {  return $this->numeroContratoCas;   }
    public function getInicioContrato()  {  return $this->inicioContrato;   }
    public function getTerminoContrato()  {  return $this->terminoContrato;   }
    public function getMetaPeriodo()  {  return $this->metaPeriodo;   }
    public function getNumeroConvocatoria()  {  return $this->numeroConvocatoria;   }


//_Asignar Valores (Setters)
    public function setIdTrabajador($idTrabajador) {  $this->idTrabajador = $idTrabajador; }
    public function setIdTipoRegimenPension($idTipoRegimenPension) {  $this->idTipoRegimenPension = $idTipoRegimenPension; }
    public function setIdTipoAfp($idTipoAfp) {  $this->idTipoAfp = $idTipoAfp; }
    public function setIdTipoRegimenLaboral($idTipoRegimenLaboral) {  $this->idTipoRegimenLaboral = $idTipoRegimenLaboral; }
    public function setIdTipoTrabajador($idTipoTrabajador) {  $this->idTipoTrabajador = $idTipoTrabajador; }
    public function setIdUnidadEjecutora($idUnidadEjecutora) {  $this->idUnidadEjecutora = $idUnidadEjecutora; }
    public function setIdTipoCondicion($idTipoCondicion) {  $this->idTipoCondicion = $idTipoCondicion; }
    public function setIdNivel($idNivel) {  $this->idNivel = $idNivel; }
    public function setLibretaMilitar($libretaMilitar) {  $this->libretaMilitar = $libretaMilitar; }
    public function setNroBrevete($nroBrevete) {  $this->nroBrevete = $nroBrevete; }
    public function setCodigoUnico($codigoUnico) {  $this->codigoUnico = $codigoUnico; }
    public function setEstadoCivil($estadoCivil) {  $this->estadoCivil = $estadoCivil; }
    public function setCasa($casa) {  $this->casa = $casa; }
    public function setSuspendido($suspendido) {  $this->suspendido = $suspendido; }
    public function setIdTipoBrevete($idTipoBrevete) {  $this->idTipoBrevete = $idTipoBrevete; }


    public function setIdSituacionLaboral($idSituacionLaboral)  { $this->idSituacionLaboral = $idSituacionLaboral;}
    public function setGrupoSanguineo($grupoSanguineo)  { $this->grupoSanguineo = $grupoSanguineo;}
    public function setUbigeo($ubigeo)  { $this->ubigeo = $ubigeo;}
    public function setPais($pais)  { $this->pais = $pais;}
    public function setCodigoPlaza($codigoPlaza)   {   $this->codigoPlaza = $codigoPlaza;   }

    public function setNumeroContratoCas($numeroContratoCas)  {   $this->numeroContratoCas = $numeroContratoCas;   }
    public function setInicioContrato($inicioContrato)  {   $this->inicioContrato = $inicioContrato;   }
    public function setTerminoContrato($terminoContrato)  {   $this->terminoContrato = $terminoContrato;   }
    public function setMetaPeriodo($metaPeriodo)  {   $this->metaPeriodo = $metaPeriodo;   }
    public function setNumeroConvocatoria($numeroConvocatoria)  {   $this->numeroConvocatoria = $numeroConvocatoria;   }

//_Devuelve un Vector (array) de Propiedades del Objeto
	public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
	}

    
    
}

?>

