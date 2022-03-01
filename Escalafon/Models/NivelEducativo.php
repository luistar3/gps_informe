<?php
class NivelEducativo implements \JsonSerializable
{

    protected $idNivelEducativo;
	protected $idTrabajador;
	protected $nombreCentroEstudios;
	protected $tituloObtenido;

	protected $fecha;
	protected $archivo;
	protected $eliminado;

	protected $idTipoCondicionNivelEducativo;
	protected $idTipoNivelEducativo;
	protected $idTipoCentroEstudio;


//_Constructor
	public function __construct(){ }

//_Devolver Valores (Getters)
    public function getIdNivelEducativo()  { return $this->idNivelEducativo;  }
	public function getIdIrabajador() { return $this->idTrabajador;	}
	public function getNombreCentroEstudios() { return $this->nombreCentroEstudios;	}
	public function getTituloObtenido()	{ return $this->tituloObtenido;	}

	public function getFecha()	{ return $this->fecha;	}
	public function getEliminado()	{ return $this->eliminado;	}
	public function getArchivo() { return $this->archivo;	}


	public function getIdTipoCondicionNivelEducativo(){return $this->idTipoCondicionNivelEducativo;}
	public function getIdTipoNivelEducativo(){return $this->idTipoNivelEducativo;}
	public function getIdTipoCentroEstudio(){return $this->idTipoCentroEstudio;}
  
//_Asignar Valores (Setters)
    public function setIdNivelEducativo($idNivelEducativo)  {  $this->idNivelEducativo = $idNivelEducativo;  }
	public function setIdTrabajador($idTrabajador) {	$this->idTrabajador = $idTrabajador; }
	public function setNombreCentroEstudios($nombreCentroEstudios) {	$this->nombreCentroEstudios = $nombreCentroEstudios; }
	public function setTituloObtenido($tituloObtenido) {	$this->tituloObtenido = $tituloObtenido; }

	public function setFecha($fecha) {	$this->fecha = $fecha; }
	public function setEliminado($eliminado) {	$this->eliminado = $eliminado; }
	public function setArchivo($archivo) {	$this->archivo = $archivo; }


	public function setIdTipoCondicionNivelEducativo($idTipoCondicionNivelEducativo){	$this->idTipoCondicionNivelEducativo = $idTipoCondicionNivelEducativo;	}
	public function setIdTipoNivelEducativo($idTipoNivelEducativo){	$this->idTipoNivelEducativo = $idTipoNivelEducativo;	}
	public function setIdTipoCentroEstudio($idTipoCentroEstudio){	$this->idTipoCentroEstudio = $idTipoCentroEstudio;	}
	
//_Devuelve un Vector (array) de Propiedades del Objeto
	public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
	}


}

?>