<?php
class cls_rutas{
  private static $vars;
  private static $rutaBase;
  private static $_oSelf = null;
//_Para el constructor
	private function __construct(){
    self::$vars = array();
    self::$rutaBase = "/";
	}
//_Para evaluar si la instancia esta abierta
	public static function get_rutas(){
		if( !self::$_oSelf instanceof self ){
			self::$_oSelf = new self();
		}
		return self::$_oSelf;
  }
// ---------------------------------------------------------------------------------------------
// Para todas las variables cargadas
// ---------------------------------------------------------------------------------------------
//_Con SET vamos guardando nuestras variables
  public function set($name,$valor){
    if(!isset(self::$vars[$name])){
      self::$vars[$name]=$valor;
    }
  }
//_Con GET 'nombre_de_la_variable' recuperamos un valor
	public static function get($name){
		if(isset(self::$vars[$name])){
			return self::getRutaBase().self::$vars[$name];
		}
  }
// ---------------------------------------------------------------------------------------------
// Para definir la RUTA BASE
// ---------------------------------------------------------------------------------------------
  public function setRutaBase($val){ self::$rutaBase = $val; }
	public static function getRutaBase(){ return self::$rutaBase; }
}
?>