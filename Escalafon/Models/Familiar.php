<?php
class Familiar implements \JsonSerializable
{
    protected $idFamiliar;
    protected $sexo;
    protected $dni;
    protected $primerNombre;
    protected $segundoNombre;
    protected $apellidoPaterno;
    protected $apellidoMaterno;
    protected $fechaNacimiento;

    protected $ubigeoNacimiento;

    protected $paisNacimiento;
    protected $nroCertificadoMedico;
    protected $gradoInstruccion;
    protected $domicilio;
    protected $ubigeoResidencia;

    protected $pais;
    protected $telefono;
    protected $celular;
    protected $fechaMatrimonio;
    protected $nroPartida;
    protected $situacion;

//_Constructor
	public function __construct(){ }


//_Devolver Valores (Getters)
    public function getIdFamiliar() { return $this->idFamiliar; }
    public function getSexo() { return $this->sexo; }
    public function getDni() { return $this->dni; }
    public function getPrimerNombre() { return $this->primerNombre; }
    public function getSegundoNombre() {  return $this->segundoNombre; }
    public function getApellidoPaterno() {  return $this->apellidoPaterno; }
    public function getApellidoMaterno() {  return $this->apellidoMaterno; }
    public function getFechaNacimiento() {  return $this->fechaNacimiento; }
    public function getDistritoNacimiento() {  return $this->distritoNacimiento; }
    public function getPaisNacimiento() {  return $this->paisNacimiento; }
    public function getNroCertificadoMedico() {  return $this->nroCertificadoMedico; }
    public function getGradoInstruccion() {  return $this->gradoInstruccion; }
    public function getDomicilio() {  return $this->domicilio; }

    public function getUbigeoNacimiento() {  return $this->ubigeoNacimiento;}
    public function getUbigeoResidencia() {  return $this->ubigeoResidencia;}

    public function getPais() {  return $this->pais; }
    public function getTelefono() {  return $this->telefono; }
    public function getCelular() { return $this->celular; }
    public function getFechaMatrimonio()    {        return $this->fechaMatrimonio;    }
    public function getNroPartida() { return $this->nroPartida; }
    public function getSituacion() { return $this->situacion; }
   
//_Asignar Valores (Setters)
    public function setIdFamiliar($idFamiliar) {   $this->idFamiliar = $idFamiliar; }
    public function setSexo($sexo) {   $this->sexo = $sexo; }
    public function setDni($dni) {   $this->dni = $dni; }  
    public function setPrimerNombre($primerNombre) {   $this->primerNombre = $primerNombre; }
    public function setSegundoNombre($segundoNombre) {   $this->segundoNombre = $segundoNombre; }
    public function setApellidoPaterno($apellidoPaterno) {   $this->apellidoPaterno = $apellidoPaterno; }
    public function setApellidoMaterno($apellidoMaterno) {   $this->apellidoMaterno = $apellidoMaterno; }
    public function setFechaNacimiento($fechaNacimiento) {   $this->fechaNacimiento = $fechaNacimiento; }
    public function setDistritoNacimiento($distritoNacimiento) {   $this->distritoNacimiento = $distritoNacimiento; }
    public function setPaisNacimiento($paisNacimiento) {   $this->paisNacimiento = $paisNacimiento; }
    public function setNroCertificadoMedico($nroCertificadoMedico) {   $this->nroCertificadoMedico = $nroCertificadoMedico; }
    public function setGradoInstruccion($gradoInstruccion) {   $this->gradoInstruccion = $gradoInstruccion; }
    public function setDomicilio($domicilio) {   $this->domicilio = $domicilio; }

    public function setUbigeoNacimiento($ubigeoNacimiento)  { $this->ubigeoNacimiento = $ubigeoNacimiento; }
    public function setUbigeoResidencia($ubigeoResidencia)  { $this->ubigeoResidencia = $ubigeoResidencia; }

    public function setPais($pais) {   $this->pais = $pais; }
    public function setTelefono($telefono) {   $this->telefono = $telefono; }
    public function setCelular($celular) {  $this->celular = $celular; }
    public function setFechaMatrimonio($fechaMatrimonio) {  $this->fechaMatrimonio = $fechaMatrimonio; }
    public function setNroPartida($nroPartida) {  $this->nroPartida = $nroPartida; }
    public function setSituacion($situacion) {  $this->situacion = $situacion; }

//_Devuelve un Vector (array) de Propiedades del Objeto
    public function jsonSerialize()	{
		$vars = get_object_vars($this);
		return $vars;
    }


    
}

?>