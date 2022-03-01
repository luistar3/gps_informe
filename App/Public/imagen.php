<?php
class imagen{
//_Para la imagen grande
	private $obj_imagen;				 		     //-> Objeto FILE que contiene la imagen que vamos a subir
	private $img_str_destino;						 //-> Carpeta en donde se almacenara la imagen
	private $img_str_prefijo="img_";		 //-> Prefijo de la imagen
	private $img_int_peso_maximo;				 //-> Para limitar el peso del archivo a subir (si es 0 no limitara el peso del archivo)
	private $img_str_tipo_ajuste=0;		   //-> Tipo de redimension de la imagen (0=Nada; 1=Ancho; 2=Alto; 3=Cuadrado)
	private $img_int_dimension;	 				 //-> Nueva dimension de la imagen grande (para ajustar tamaño)
	private $img_str_extension;					 //-> Extension de la imagen a subir
	private $img_str_nombre="";			 		 //-> Nombre final de la imagen en el servidor
//_Para las miniaturas (thumbnail)
	private $thumb_bool_miniatura=false; //-> Genera o NO una imagen pequeña (thumbnail)
	private $thumb_int_tipo=1;				   //-> Tipo de tumbnail a generar (1=Cuadrado perfecto, 2=Solo reduce ANCHO, 3=Solo reduce ALTO)
	private $thumb_int_dimension=85;     //-> Dimension de la imagen pequeña (para ajustar tamaño)
	private $thumb_str_nombre="";		     //-> Nombre de la imagen pequeña
//_Constructor de la clase
	public function __construct($imagen,$carpeta,$prefijo="img_",$peso_maximo=0){
		$this->obj_imagen=$imagen;
		$this->img_str_destino=$carpeta;
		$this->img_str_prefijo=$prefijo;
		$this->img_int_peso_maximo=$peso_maximo;
		if(substr($this->img_str_destino, -1, 1)<>"/"){ $this->img_str_destino.="/"; }
	}
//_Para permitir la subida de imagenes multiples
	public function set_imagen($imagen=""){
		$this->obj_imagen=$imagen;
	}
//_Para indicar el tipo de ajuste a aplicar y la nueva dimension de la imagen
	public function set_ajuste($ajuste=0,$dimension=0){
		$this->img_str_tipo_ajuste=$ajuste;
		$this->img_int_dimension=$dimension;
	}
//_Para configurar los parametros del thumbnail
	public function set_thumbnail($miniatura=false,$tipo=1,$dimension=0){ // TIPO: 1=Cuadrado; 2=Ancho, 3=Alto
		$this->thumb_bool_miniatura=$miniatura;
		$this->thumb_int_tipo=$tipo;
		$this->thumb_int_dimension=$dimension;
	}
//_Para verificar la extension de la imagen a subir
	private function fnc_verificar_ext(){
		$ext_permitidas = array("gif","jpg","jpeg","pjpeg","png");
		$this->img_str_extension = strtolower(pathinfo($this->obj_imagen["name"],PATHINFO_EXTENSION));
		if(in_array($this->img_str_extension,$ext_permitidas)){
			return true;
		}else{
			return false;
		}
	}
//_Para generar el nombre de la imagen a subir al servidor
	private function fnc_generar_nombre(){
		do{
			$img_subir_no_ext = $this->img_str_prefijo.rand(1,9999);
			$this->img_str_nombre = $img_subir_no_ext.".".$this->img_str_extension;
			if($this->thumb_bool_miniatura==true){ 
				$this->thumb_str_nombre = $img_subir_no_ext."_tmp.".$this->img_str_extension;
			}else{
				$this->thumb_str_nombre = "";
			}
		}while(file_exists($this->img_str_destino.$this->img_str_nombre));
		return $this->img_str_nombre;
	}
//_Para verificar si la imagen fue subida al servidor
	private function fnc_verificar_subir(){
		$rpt = false;
		if(is_dir($this->img_str_destino)){
			if(move_uploaded_file($this->obj_imagen["tmp_name"], $this->img_str_destino.$this->fnc_generar_nombre())){
				if($this->fnc_ajustar_tamanio()==true){
					return true;
				}
			}
		}
		return $rpt;
	}
//_Para ajustar las dimensiones de la imagen segun lo estipulado en el constructor
	private function fnc_ajustar_tamanio(){
		$info = getimagesize($this->img_str_destino.$this->img_str_nombre);
		$imgD = $this->img_int_dimension;
		if($this->img_str_tipo_ajuste==1){ //------> Redimensiona dependiendo el ANCHO
			if($info[0]==$info[1]){
				if($imgD>=$info[0]){ $ancho=$info[0]; $alto=$info[1]; }
				else{ $ancho=$imgD; $alto=$imgD; }
			}else{
				if($info[0]<=$imgD && $info[1]<=$imgD){
					$ancho = $info[0];
					$alto = $info[1];
				}else{
					if($info[0]<=$imgD){
						$ancho = $info[0];
						$alto = $info[1];
					}elseif($info[1]<=$imgD){
						$ancho = $imgD;
						$alto = ceil(($info[1]/$info[0])*$imgD);
					}else{
						$ancho = $imgD;
						$alto = ceil(($info[1]/$info[0])*$imgD);
					}
				}
			}
		}elseif($this->img_str_tipo_ajuste==2){ //-> Redimensiona dependiendo el ALTO
			if($info[0]==$info[1]){
				if($imgD>=$info[0]){ $ancho=$info[0]; $alto=$info[1]; }
				else{ $ancho=$imgD; $alto=$imgD; }
			}else{
				if($info[0]<=$imgD && $info[1]<=$imgD){
					$ancho = $info[0];
					$alto = $info[1];
				}else{
					if($info[0]<=$imgD){
						$ancho = ceil(($info[0]/$info[1])*$imgD);
						$alto = $imgD;
					}elseif($info[1]<=$imgD){
						$ancho = $info[0];
						$alto = $info[1];
					}else{
						$ancho = ceil(($info[0]/$info[1])*$imgD);
						$alto = $imgD;
					}
				}
			}
		}elseif($this->img_str_tipo_ajuste==3){ //-> Cuadrado perfecto
			if($info[0]==$info[1]){ $xpos=0; $ypos=0; $ancho=$info[0]; $alto=$info[1]; }
			else{
				if($info[0]<=$imgD && $info[1]<=$imgD){
					$xpos=0; $ypos=0; $ancho=$info[0]; $alto=$info[1];
				}else{
					if($info[0]<=$imgD || $info[1]<=$imgD){ //-> Si el ancho o el alto de la imagen es menor que el que se desea tener
						$xpos=0; $ypos=0;
						if($info[0]<=$imgD){
							$ancho = $imgD;
							$alto = $info[1];
						}elseif($info[1]<=$imgD){
							$ancho = $info[0];
							$alto = $imgD;
						}
					}else{
						if($info[0]>$info[1]){ //-> Imagen horizontal					
							$xpos = ceil(($info[0] - $info[1]) /2);
							$ypos = 0;
							$ancho = $info[1];
							$alto = $info[1];
						}else{ //-----------------> Imagen vertical
							$ypos = ceil(($info[1] - $info[0]) /2);
							$xpos = 0;
							$ancho = $info[0];
							$alto = $info[0];
						}
					}
				}
			}
		}else{
			$ancho=$info[0]; $alto=$info[1];
		}
	//_Dependiendo del mime type, creamos una imagen a partir del archivo original:
		if($info[2]==1){ $image=@imagecreatefromgif($this->img_str_destino.$this->img_str_nombre); }  //-> Para GIF
		if($info[2]==2){ $image=@imagecreatefromjpeg($this->img_str_destino.$this->img_str_nombre); } //-> Para JPG
		if($info[2]==3){ $image=@imagecreatefrompng($this->img_str_destino.$this->img_str_nombre); }  //-> Para PNG
	//_Procedemos a la redimension
		if($this->img_str_tipo_ajuste==3){
			if($info[0]<=$imgD || $info[1]<=$imgD){
				$image_new = imagecreatetruecolor($ancho,$alto);
				if($info[2]==3){
					$colorBlanco = imagecolorallocate($image_new,255,255,255);
					$colorTransparancia = imagecolortransparent($image_new,$colorBlanco);
					if($colorTransparancia!=-1){
						$colorTransparente = imagecolorsforindex($image_new, $colorTransparancia);
						$idColorTransparente = imagecolorallocatealpha($image_new, $colorTransparente['red'], $colorTransparente['green'], $colorTransparente['blue'],$colorTransparente['alpha']);
						imagefill($image_new, 0, 0, $idColorTransparente);
						imagecolortransparent($image_new, $idColorTransparente);
					}
				}
				imagecopyresampled($image_new, $image, 0, 0, $xpos, $ypos, $ancho, $alto, $ancho, $alto);
			}else{
				$image_new = imagecreatetruecolor($imgD,$imgD);
				if($info[2]==3){
					$colorBlanco = imagecolorallocate($image_new,255,255,255);
					$colorTransparancia = imagecolortransparent($image_new,$colorBlanco);
					if($colorTransparancia!=-1){
						$colorTransparente = imagecolorsforindex($image_new, $colorTransparancia);
						$idColorTransparente = imagecolorallocatealpha($image_new, $colorTransparente['red'], $colorTransparente['green'], $colorTransparente['blue'],$colorTransparente['alpha']);
						imagefill($image_new, 0, 0, $idColorTransparente);
						imagecolortransparent($image_new, $idColorTransparente);
					}
				}
				imagecopyresampled($image_new, $image, 0, 0, $xpos, $ypos, $imgD, $imgD, $ancho, $alto);
			}
		}else{
			$image_new = imagecreatetruecolor($ancho,$alto);
			if($info[2]==3){
				$colorBlanco = imagecolorallocate($image_new,255,255,255);
				$colorTransparancia = imagecolortransparent($image_new,$colorBlanco);
				if($colorTransparancia!=-1){
					$colorTransparente = imagecolorsforindex($image_new, $colorTransparancia);
					$idColorTransparente = imagecolorallocatealpha($image_new, $colorTransparente['red'], $colorTransparente['green'], $colorTransparente['blue'],$colorTransparente['alpha']);
					imagefill($image_new, 0, 0, $idColorTransparente);
					imagecolortransparent($image_new, $idColorTransparente);
				}
			}
			imagecopyresampled($image_new, $image, 0, 0, 0, 0, $ancho, $alto, $info[0], $info[1]);
		}
	//_Dependiendo del tipo de imagen se imprime en un archivo (salida)
		$rpt = false;
		if($info[2]==1){ $rpt=imagegif($image_new, $this->img_str_destino.$this->img_str_nombre); }       //-> Para GIF
		if($info[2]==2){ $rpt=imagejpeg($image_new, $this->img_str_destino.$this->img_str_nombre, 100); } //-> Para JPG
		if($info[2]==3){ $rpt=imagepng($image_new, $this->img_str_destino.$this->img_str_nombre); }       //-> Para PNG
		return $rpt;
	}
//_Para subir la imagen
	public function subir(){
		$rpt = false;
		if($this->obj_imagen["name"]!=""){
			if($this->fnc_verificar_ext()==true){
				if($this->img_int_peso_maximo==0 || $this->img_int_peso_maximo<=$this->obj_imagen["size"]){
					if($this->fnc_verificar_subir()==true){
						if($this->thumb_bool_miniatura==true){
							if($this->fnc_thumbnail()==true){
								$rpt = true;
							}
						}else{
							$rpt = true;
						}
					}else{
						$this->img_str_nombre="";
						$this->thumb_str_nombre="";
					}
				}
			}
		}
		if($rpt==false){ $this->fnc_eliminar_imagenes(); }
		return $rpt;
	}
//_Para generar el THUMBNAIL de una imagen subida al servidor
	private function fnc_thumbnail(){
		$info = getimagesize($this->img_str_destino.$this->img_str_nombre);
	//_Evaluamos el tipo de thumbnail a generar (1=Cuadrado perfecto, 2=Solo reduce ANCHO, 3=Solo reduce ALTO)
		$generar_thumb = "no";
		$ancho = $alto = 0;
		$thumbD = $this->thumb_int_dimension;
		if($this->thumb_int_tipo==1){ //------> Cuadrado perfecto
			$generar_thumb = "si";
		//_Si el ancho es igual al alto, la imagen ya es cuadrada, por lo que podemos ahorrarnos unos pasos:		
			if($info[0]==$info[1]){ $xpos=0; $ypos=0; $ancho=$info[0]; $alto=$info[1]; }
		//_Si la imagen no es cuadrada, hay que hacer un par de averiguaciones:
			else{
				if($info[0]<=$thumbD && $info[1]<=$thumbD){
					$xpos=0; $ypos=0; $ancho=$info[0]; $alto=$info[1];
				}else{
					if($info[0]<=$thumbD || $info[1]<=$thumbD){ //-> Si el ancho o el alto de la imagen es menor que el que se desea tener
						$xpos=0; $ypos=0;
						if($info[0]<=$thumbD){
							$ancho = $thumbD;
							$alto = $info[1];
						}elseif($info[1]<=$thumbD){
							$ancho = $info[0];
							$alto = $thumbD;
						}
					}else{
						if($info[0]>$info[1]){ //-> Imagen horizontal					
							$xpos = ceil(($info[0] - $info[1]) /2);
							$ypos = 0;
							$ancho = $info[1];
							$alto = $info[1];
						}else{ //-----------------> Imagen vertical
							$ypos = ceil(($info[1] - $info[0]) /2);
							$xpos = 0;
							$ancho = $info[0];
							$alto = $info[0];
						}
					}
				}
			}
		}elseif($this->thumb_int_tipo==2){ //-> Solo reduce ANCHO y el ALTO es proporcional
			$xpos=0; $ypos=0; $generar_thumb="si";
			if($info[0]==$info[1]){ 
				if($thumbD>=$info[0]){ $ancho=$info[0]; $alto=$info[1]; }
				else{ $ancho=$thumbD; $alto=$thumbD; }
			}else{
				if($info[0]<=$thumbD && $info[1]<=$thumbD){
					$ancho = $info[0];
					$alto = $info[1];
				}else{
					if($info[0]<=$thumbD){
						$ancho = $info[0];
						$alto = $info[1];
					}elseif($info[1]<=$thumbD){
						$ancho = $thumbD;
						$alto = ceil(($info[1]/$info[0])*$thumbD);
					}else{
						$ancho = $thumbD;
						$alto = ceil(($info[1]/$info[0])*$thumbD);
					}
				}
			}
		}elseif($this->thumb_int_tipo==3){ //-> Solo reduce ALTO y el ANCHO es proporcional
			$xpos=0; $ypos=0; $generar_thumb="si";
			if($info[0]==$info[1]){
				if($thumbD>=$info[0]){ $ancho=$info[0]; $alto=$info[1]; }
				else{ $ancho=$thumbD; $alto=$thumbD; }
			}else{
				if($info[0]<=$thumbD && $info[1]<=$thumbD){
					$ancho = $info[0];
					$alto = $info[1];
				}else{
					if($info[0]<=$thumbD){
						$ancho = ceil(($info[0]/$info[1])*$thumbD);
						$alto = $thumbD;
					}elseif($info[1]<=$thumbD){
						$ancho = $info[0];
						$alto = $info[1];
					}else{
						$ancho = ceil(($info[0]/$info[1])*$thumbD);
						$alto = $thumbD;
					}
				}
			}
		}
		$rpt = false;
		if($generar_thumb=="si"){
		//_Dependiendo del mime type, creamos una imagen a partir del archivo original:
			if($info[2]==1){ $image=@imagecreatefromgif($this->img_str_destino.$this->img_str_nombre); }  //-> Para GIF
			if($info[2]==2){ $image=@imagecreatefromjpeg($this->img_str_destino.$this->img_str_nombre); } //-> Para JPG
			if($info[2]==3){ $image=@imagecreatefrompng($this->img_str_destino.$this->img_str_nombre); }  //-> Para PNG
		//_Redimensionamos dependiendo del tipo de ajuste
			if($this->thumb_int_tipo==1){
				if($info[0]<=$thumbD || $info[1]<=$thumbD){
					$image_new = imagecreatetruecolor($ancho,$alto);
					if($info[2]==3){
						$colorBlanco = imagecolorallocate($image_new,255,255,255);
						$colorTransparancia = imagecolortransparent($image_new,$colorBlanco);
						if($colorTransparancia!=-1){
							$colorTransparente = imagecolorsforindex($image_new, $colorTransparancia);
							$idColorTransparente = imagecolorallocatealpha($image_new, $colorTransparente['red'], $colorTransparente['green'], $colorTransparente['blue'],$colorTransparente['alpha']);
							imagefill($image_new, 0, 0, $idColorTransparente);
							imagecolortransparent($image_new, $idColorTransparente);
						}
					}
					imagecopyresampled($image_new, $image, 0, 0, $xpos, $ypos, $ancho, $alto, $ancho, $alto);
				}else{
					$image_new = imagecreatetruecolor($thumbD,$thumbD);
					if($info[2]==3){
						$colorBlanco = imagecolorallocate($image_new,255,255,255);
						$colorTransparancia = imagecolortransparent($image_new,$colorBlanco);
						if($colorTransparancia!=-1){
							$colorTransparente = imagecolorsforindex($image_new, $colorTransparancia);
							$idColorTransparente = imagecolorallocatealpha($image_new, $colorTransparente['red'], $colorTransparente['green'], $colorTransparente['blue'],$colorTransparente['alpha']);
							imagefill($image_new, 0, 0, $idColorTransparente);
							imagecolortransparent($image_new, $idColorTransparente);
						}
					}
					imagecopyresampled($image_new, $image, 0, 0, $xpos, $ypos, $thumbD, $thumbD, $ancho, $alto);
				}
			}else{
				$image_new = imagecreatetruecolor($ancho,$alto);
				if($info[2]==3){
					$colorBlanco = imagecolorallocate($image_new,255,255,255);
					$colorTransparancia = imagecolortransparent($image_new,$colorBlanco);
					if($colorTransparancia!=-1){
						$colorTransparente = imagecolorsforindex($image_new, $colorTransparancia);
						$idColorTransparente = imagecolorallocatealpha($image_new, $colorTransparente['red'], $colorTransparente['green'], $colorTransparente['blue'],$colorTransparente['alpha']);
						imagefill($image_new, 0, 0, $idColorTransparente);
						imagecolortransparent($image_new, $idColorTransparente);
					}
				}
				imagecopyresampled($image_new, $image, 0, 0, $xpos, $ypos, $ancho, $alto, $info[0], $info[1]);
			}
		//_Guardamos la nueva imagen
			if($info[2]==1){ $rpt=imagegif($image_new, $this->img_str_destino.$this->thumb_str_nombre); }       //-> Para GIF
			if($info[2]==2){ $rpt=imagejpeg($image_new, $this->img_str_destino.$this->thumb_str_nombre, 100); } //-> Para JPG
			if($info[2]==3){ $rpt=imagepng($image_new, $this->img_str_destino.$this->thumb_str_nombre); }       //-> Para PNG
		}
		return $rpt;		
	}
//_Para eliminar las imagenes generadas
	private function fnc_eliminar_imagenes(){
		if(file_exists($this->img_str_destino.$this->img_str_nombre)){ unlink($this->img_str_destino.$this->img_str_nombre); }
		if(file_exists($this->img_str_destino.$this->thumb_str_nombre)){ unlink($this->img_str_destino.$this->thumb_str_nombre); }
	}
//_Para DEVOLDER el nombre de la imagen subida al servidor
	public function get_nombre_img(){ return $this->img_str_nombre; }
	public function get_nombre_thumb(){ return $this->thumb_str_nombre; }
}
?>