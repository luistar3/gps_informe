<?php
class ProcesoJudicial implements \JsonSerializable
{
    protected $idProcesoJudicial;
    protected $idTrabajador;
    protected $idTipoAccion;
    protected $idTipoDocumento;
    protected $asunto;
    protected $observacion;
    protected $archivo;
    protected $eliminado;

//_Constructor
	public function __construct() {	}

//_Devolver Valores (Getters)
  
    public function getIdProcesoJudicial() { return $this->idProcesoJudicial; }
    public function getIdTrabajador() { return $this->idTrabajador; }
    public function getIdTipoAccion() { return $this->idTipoAccion; }
    public function getIdTipoDocumento() { return $this->idTipoDocumento; }
    public function getAsunto() { return $this->asunto; }
    public function getObservacion() { return $this->observacion; }
    public function getArchivo() { return $this->archivo; }
    public function getEliminado() { return $this->eliminado; }

//_Asignar Valores (Setters)
    public function setIdProcesoJudicial($idProcesoJudicial)   {   $this->idProcesoJudicial = $idProcesoJudicial;    }
    public function setIdTrabajador($idTrabajador)   {   $this->idTrabajador = $idTrabajador;    }
    public function setIdTipoAccion($idTipoAccion)   {   $this->idTipoAccion = $idTipoAccion;    }
    public function setIdTipoDocumento($idTipoDocumento)   {   $this->idTipoDocumento = $idTipoDocumento;    }
    public function setAsunto($asunto)   {   $this->asunto = $asunto;    }
    public function setObservacion($observacion)   {   $this->observacion = $observacion;    }
    public function setArchivo($archivo)   {   $this->archivo = $archivo;    }
    public function setEliminado($eliminado)   {   $this->eliminado = $eliminado;    }

//_Devuelve un Vector (array) de Propiedades del Objeto
    public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
    }


}

?>