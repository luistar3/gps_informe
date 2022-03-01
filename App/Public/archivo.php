<?php
class archivo{
	private $obj_archivo;				 	//-> Objeto FILE que contiene el archivo que vamos a subir
	private $str_destino;					//-> Carpeta en donde se almacenara el archivo
	private $str_prefijo="arch_";	//-> Prefijo del archivo
	private $int_peso_maximo;			//-> Para limitar el peso del archivo a subir (si es 0 no limitara el peso del archivo)
	private $int_tipo;						//-> Para definir a que tipo pertenece el archivo a subir
	private $str_extension;				//-> Extension del archivo a subir
	private $str_nombre="";			 	//-> Nombre final del archivo en el servidor
//_Constructor de la clase
	public function __construct($archivo,$carpeta,$prefijo="arch_",$peso_maximo=0,$tipo=1){
		$this->obj_archivo=$archivo;
		$this->str_destino=$carpeta;
		$this->str_prefijo=$prefijo;
		$this->int_peso_maximo=$peso_maximo;
		$this->int_tipo=$tipo;
		if(substr($this->str_destino, -1, 1)<>"/"){ $this->str_destino.="/"; }
	}
//_Para permitir la subida de archivos multiples
	public function set_archivo($archivo){
		$this->obj_archivo = $archivo;
	}
//_Para verificar la extension del archivo a subir
	private function fnc_verificar_ext(){
		switch($this->int_tipo){
			case 1: $ext_permitidas=array("pdf"); break; //-> Archivos PDF
			case 2: $ext_permitidas=array("xls","xlsx","csv"); break; //-> Archivos EXCEL
			case 3: $ext_permitidas=array("doc","docx"); break; //-> Archivos WORD
			case 4: $ext_permitidas=array("rtf"); break; //-> Archivos RTF
			case 5: $ext_permitidas=array("mp3","wav","aac","wma","ogg","au","aif"); break; //-> Archivos de AUDIO
			case 6: $ext_permitidas=array("webm","mp4","avi","mov","ogg","oggm","asf","wmv","mpg","mpeg","mpeg1"); break; //-> Archivos de Video
			case 7: $ext_permitidas=array("tar","zip","rar","gzip"); break; //-> Archivos COMPRIMIDOS
			case 8: $ext_permitidas=array("pdf","doc","docx","rtf","xls","xlsx","csv"); break; //-> Recursos (PDF, EXCEL,WORD)
			case 9: $ext_permitidas=array("png","jpg","jpeg"); break; //-> Recursos (IMAGENES)
			default: $ext_permitidas=array(); break;
		}
		$this->str_extension = strtolower(pathinfo($this->obj_archivo["name"],PATHINFO_EXTENSION));
		if(in_array(strtolower($this->str_extension),$ext_permitidas)){
			return true;
		}else{
			return false;
		}
	}
//_Para generar el nombre del archivo a subir al servidor
	private function fnc_generar_nombre(){
		do{
			$this->str_nombre = $this->str_prefijo.rand(1,9999).".".$this->str_extension;
		}while(file_exists($this->str_destino.$this->str_nombre));
		return $this->str_nombre;
	}
//_Para subir el archivo
	public function subir(){
		$rpt = false; // flat
		if($this->obj_archivo["name"]!=""){
			if($this->fnc_verificar_ext()==true){
				if($this->int_peso_maximo==0 || $this->int_peso_maximo<=$this->obj_archivo["size"]){
					if(is_dir($this->str_destino)){
						if(move_uploaded_file($this->obj_archivo["tmp_name"], $this->str_destino.$this->fnc_generar_nombre())){
							if(file_exists($this->str_destino.$this->str_nombre)){
								$rpt = true;
							}else{
								$this->str_nombre="";
							}
						}else{
							$this->str_nombre="";
						}
					}
				}
			}
		}
		return $rpt;
	}
//_Para eliminar el archivo generado
	private function fnc_eliminar_archivo(){
		if(file_exists($this->str_destino.$this->str_nombre)){ unlink($this->str_destino.$this->str_nombre); }
	}
//_Para DEVOLDER el nombre del archivo subido al servidor
	public function get_nombre_archivo(){ return $this->str_nombre; }
//_Para DEVOLVER la extension del archivo subido al servidor
	public function get_extension_archivo(){ return $this->str_extension; }
}
?>