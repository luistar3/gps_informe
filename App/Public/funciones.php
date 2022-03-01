<?php
//_Para convertir tipo de datos
if (!function_exists("GetSQLValueString")) {
	function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
	{
	  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
	
	  switch ($theType) {
		case "text":
		  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
		  break;    
		case "long":
		case "int":
		  $theValue = ($theValue != "") ? intval($theValue) : "NULL";
		  break;
		case "double":
		  $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
		  break;
		case "date":
		  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
		  break;
		case "defined":
		  $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
		  break;
	  }
	  return $theValue;
	}
}
//_Para codificar el texto malicioso
function codificarTextoMalicioso($texto){
   $textoCodificado = $texto;
    // Caracteres especiales
   $textoCodificado = preg_replace('/<(.*)?>/is','', $textoCodificado);
   if(preg_match("/drop/",$textoCodificado)){ $textoCodificado = str_replace("drop","",$textoCodificado); }
   if(preg_match("/delete/",$textoCodificado)){ $textoCodificado = str_replace("delete","",$textoCodificado); }
   if(preg_match("/insert/",$textoCodificado)){ $textoCodificado = str_replace("insert","",$textoCodificado); }
   if(preg_match("/update/",$textoCodificado)){ $textoCodificado = str_replace("update","",$textoCodificado); }
   if(preg_match("/select/",$textoCodificado)){ $textoCodificado = str_replace("select","",$textoCodificado); }   
   if(preg_match("/and/",$textoCodificado)){ $textoCodificado = str_replace("and","",$textoCodificado); } 
   //if(preg_match("/(/",$textoCodificado)){ $textoCodificado = str_replace("(","",$textoCodificado); } 
   if(preg_match("/)/",$textoCodificado)){ $textoCodificado = str_replace(")","",$textoCodificado); }   
   //if(preg_match("/&/",$textoCodificado)){ $textoCodificado = str_replace("&","",$textoCodificado); }
   if(preg_match("/</",$textoCodificado)){ $textoCodificado = str_replace("<","",$textoCodificado); }
   if(preg_match("/>/",$textoCodificado)){ $textoCodificado = str_replace(">","",$textoCodificado); }
   if(preg_match("/",$textoCodificado)){ $textoCodificado = str_replace("/","",$textoCodificado); }
   //if(preg_match("/\\/",$textoCodificado)){ $textoCodificado = str_replace("\\","",$textoCodificado); }
   if(preg_match("/#/",$textoCodificado)){ $textoCodificado = str_replace("#","",$textoCodificado); }
   //if(preg_match(";",$textoCodificado)){ $textoCodificado = str_replace(";","",$textoCodificado); }
   if(preg_match("/('/",$textoCodificado)){ $textoCodificado = str_replace("'","",$textoCodificado); }
   if(preg_match("/%/",$textoCodificado)){ $textoCodificado = str_replace("%","",$textoCodificado); }
   //if(preg_match("[",$textoCodificado)){ $textoCodificado = str_replace("[","",$textoCodificado); }
   if(preg_match("/]/",$textoCodificado)){ $textoCodificado = str_replace("]","",$textoCodificado); }
   return htmlentities(htmlspecialchars(trim(stripslashes($textoCodificado))));
}
//_Para verificar el ID de peticion
function fncVerificarID($id=""){
	if(trim($id)<>""){
		$valido=1;
		if($id<1){ $valido=0; }
		if(!is_numeric($id)){ $valido=0; }
	}else{
		$valido=0;
	}
	return $valido;
}
//_Para verificar el ID y forma el menu
function fncVerificarIdMenu($id=""){
	if(trim($id)<>""){
		$valido='1';
		if($id<0){ $valido='0'; }
		if(!is_numeric($id)){ $valido='0'; }
	}else{
		$valido='0';
	}
	return $valido;
}
//_Para validar ENTERO que se almacene en BD
function fncValidarEnteroBD($num=""){
	if(fncVerificarID($num)==1){
		$num="'".fncCodificar($num)."'";
	}else{ 
		$num="NULL";
	}
	return $num;
}
//_Para validar CADENA que se almacene en BD
function fncValidarCadenaBD($cadena=""){
	if(trim($cadena)<>""){ 
		$cadena="'".fncCodificar($cadena)."'";
	}else{ 
		$cadena="NULL";
	}
	return $cadena;
}
//_Para validar DECIMAL que se almacene en BD
function fncValidarDecimalBD($valor=""){
	if(trim($valor)<>""){ 
		$valor_buscado = strpos($valor, ",");
		if($valor_buscado !== FALSE){ $valor=str_replace(",","",$valor); }
		$valor="'".fncCodificar($valor)."'";
	}else{ 
		$valor="NULL";
	}
	return $valor;
}
//_Para imprimir CADENA en un PDF
function fncImprimirCadenaPDF($cadena="",$tipo=""){
	if(trim($cadena)<>""){
		if($tipo=="fecha"){
			$cadena=fncFormatearFecha($cadena);
		}else{
			$cadena=utf8_decode(fncTraducirEntidadHTML($cadena));
		}
	}else{ 
		$cadena="";
	}
	return $cadena;
}
//_Para que devuelve la parte entera de un numero
function fncEntero($Numero){
	return (int)$Numero;
}
//_Para convertir a cadena
function fncString($valor){
	return (string)$valor;
}
//_Reemplaza todos los acentos por sus equivalentes sin ellos
function fncReemplazarCaracteresEspeciales($text=""){
	if(trim($text)<>""){
		$text = htmlentities($text, ENT_QUOTES, 'UTF-8');
		$patron = array(
		//_Espacios, puntos y comas por guion
			'/[\., ]+/' => ' ',
		//_Vocales
			'/&agrave;/' => 'a',
			'/&egrave;/' => 'e',
			'/&igrave;/' => 'i',
			'/&ograve;/' => 'o',
			'/&ugrave;/' => 'u',
	
			'/&aacute;/' => 'a',
			'/&eacute;/' => 'e',
			'/&iacute;/' => 'i',
			'/&oacute;/' => 'o',
			'/&uacute;/' => 'u',
	
			'/&Aacute;/' => 'A',
			'/&Eacute;/' => 'E',
			'/&Iacute;/' => 'I',
			'/&Oacute;/' => 'O',
			'/&Uacute;/' => 'U',
	
			'/&acirc;/' => 'a',
			'/&ecirc;/' => 'e',
			'/&icirc;/' => 'i',
			'/&ocirc;/' => 'o',
			'/&ucirc;/' => 'u',
	
			'/&atilde;/' => 'a',
			'/&amp;etilde;/' => 'e',
			'/&amp;itilde;/' => 'i',
			'/&otilde;/' => 'o',
			'/&amp;utilde;/' => 'u',
	
			'/&auml;/' => 'a',
			'/&euml;/' => 'e',
			'/&iuml;/' => 'i',
			'/&ouml;/' => 'o',
			'/&uuml;/' => 'u',	
		//_Otras letras y caracteres especiales
			'/&aring;/' => 'a'
		//_Agregar aqui mas caracteres si es necesario
		);
		/*'/&ntilde;/' => '�', '/&Ntilde;/' => '�', */
		$text = preg_replace(array_keys($patron),array_values($patron),$text);
	}
	return $text;
}
//_Para codificar el texto de salida (convierte los caracteres especiales a entidades HTML) Ejm. � -> $aacute;
function codificarTexto($texto){
	//$texto = utf8_decode($texto);
	return htmlentities($texto,ENT_QUOTES,'utf-8');
}
//_Para corregir el registro de texto
function fncCodificar($texto=""){
	if($texto<>""){
		return codificarTexto(fncSeguridad($texto));
	}else{ return $texto; }
}
//_Para la seguridad de los registros
function fncSeguridad($texto=""){
	//$texto = preg_replace("/\s+/"," ",$texto);
	if(trim($texto)<>""){
		return htmlspecialchars(trim(stripslashes($texto)));
	}else{ return $texto; }
}
//_LimpiarTexto Injection SQL
function fncLimpiarInput($input_str)
{
	$return_str = str_replace( array('<',';','|','&','>',"'",'"',')','('), array('&lt;','&#58;','&#124;','&#38;','&gt;','&apos;','&#x22;','&#x29;','&#x28;'), $input_str );
	$return_str = str_ireplace( '%3Cscript', '', $return_str );
	return $return_str;
}

//_Para DECODIFICAR TEXTO (TRADUCIR ENTIDADES HTML)
function fncTraducirEntidadHTML($texto=""){
	if(trim($texto)<>""){
		//return utf8_encode(html_entity_decode($texto));
		return html_entity_decode(html_entity_decode($texto));
	}else{ return $texto; }	
}
//_Para Comprobar entrada VACIA de TEXTOS
function fncComprobarEntradaTexto($texto,$limit="",$sufix=""){
	if(fncTraducirEntidadHTML($texto)<>""){
		if($limit==""){ 
			$devolver = fncTraducirEntidadHTML($texto);
		}else{
			$devolver = substr($texto,0,$limit);
			if(strlen(trim($texto))>$limit){ $devolver.=" ..."; }
		}
	}else{ 
		if($sufix==""){ $sufix="-"; } 
		$devolver=$sufix; 
	}
	return $devolver;
}
//_Generacion del texto aleatorio
function fncTextoAleatorio($length=5){
	$key = "";
	$pattern = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	for($i=0;$i<$length;$i++) {
		$key .= $pattern{rand(0,35)};
	}
	return $key;
}
//_Para INSERTAR una marca de agua
function fncInsertarMarcaAgua($imagen,$marcadeagua,$margen){
	//Se supone que la marca de agua tiene menor tama�o que la imagen
	//$imagen es la ruta de la imagen. Ej.: "carpeta/imagen.jpg"
	//&marcadeagua es la ruta de la imagen marca de agua. Ej.: "marca.png"
	//$margen determina el margen que quedar� entre la marca y los bordes de la imagen
	
	//Averiguamos la extensi�n del archivo de imagen
	$trozos_nombre_imagen=explode(".",$imagen);
	$extension_imagen=$trozos_nombre_imagen[count($trozos_nombre_imagen)-1];

	//Creamos la imagen seg�n la extensi�n le�da en el nombre del archivo
	if(preg_match('/jpg|jpeg|JPG|JPEG/',$extension_imagen)) $img=imagecreatefromjpeg($imagen); 
	if(preg_match('/png|PNG/',$extension_imagen)) $img=imagecreatefrompng($imagen); 
	if(preg_match('/gif|GIF/',$extension_imagen)) $img=imagecreatefromgif($imagen); 
	
	//declaramos el fondo como transparente	
	imagealphablending($img, true);
		
	//Ahora creamos la imagen de la marca de agua
	$marcadeagua = imagecreatefrompng($marcadeagua);
	
	//Hallamos las dimensiones de ambas im�genes para alinearlas
	$Xmarcadeagua = imagesx($marcadeagua);
	$Ymarcadeagua = imagesy($marcadeagua);
	$Ximagen = imagesx($img);
	$Yimagen = imagesy($img);
	
	//Copiamos la marca de agua encima de la imagen (alineada abajo a la derecha)
	imagecopy($img, $marcadeagua, $Ximagen-$Xmarcadeagua-$margen, $Yimagen-$Ymarcadeagua-$margen, 0, 0, $Xmarcadeagua, $Ymarcadeagua); // Abajo
	//imagecopy($img, $marcadeagua, $margen, $margen, 0, 0, $Xmarcadeagua, $Ymarcadeagua); // Arriba
	
	//Guardamos la imagen sustituyendo a la original, en este caso con calidad 100
	imagejpeg($img,$imagen,100);
	
	//Eliminamos de memoria las im�genes que hab�amos creado
	imagedestroy($img);
	imagedestroy($marcadeagua);
}
//_Para validar una fecha
function fncValidarFecha($fecha=""){ //-> $fecha = dd-mm-YYYY or dd/mm/YYYY
	if(trim($fecha)<>""){
		if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
		  $arrayFecha=explode("/", $fecha);

		if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
			$arrayFecha=explode("-",$fecha);

		if(strlen($arrayFecha[2])==4){
			if(checkdate($arrayFecha[1], $arrayFecha[0], $arrayFecha[2])){ // MES - DIA - ANIO
				return 1;
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}else{
		return 0;
	}
}
//_Para validar una fecha antes de ser enviada a la BD
function fncValidarFechaBD($fecha=""){ //-> $fecha = dd-mm-YYYY
	$rpt = "NULL";
	if(trim($fecha)<>""){
		if(fncValidarFecha($fecha)==1){ $rpt="'".fncFormatearFecha($fecha,"-")."'"; }
	}
	return $rpt;
}

//_Para darle formato a la fecha y enviar a la BD
function fncFormatearFecha($fecha="",$separador="-"){
	if(trim($fecha)<>""){
		if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
			  $arrayFecha=explode("/", $fecha);
	
		if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
			  $arrayFecha=explode("-",$fecha);
	
		return $arrayFecha[2].$separador.$arrayFecha[1].$separador.$arrayFecha[0];
	}else{
		return "&nbsp;";	
	}
}
//_Para darle formato a la fecha y enviar al formulario (YYYY-mm-dd)
function fncFormatearFechaFrm($fecha="",$separador="-"){
	$rpt = "";
	if(trim($fecha)<>""){
		$new_fecha = fncFormatearFecha($fecha,$separador);
		if(fncValidarFecha($new_fecha)==1){ $rpt=$new_fecha; }
	}
	return $rpt;
}
//_Para el formato de fechas (Mes A�o: Julio 2015)
function fncFechaMesAnio($fecha=""){ //-> $fecha = dd-mm-YYYY
	$rpt = "";
	if(trim($fecha)<>""){
		if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
		  $arrayFecha=explode("/", $fecha);

		if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
			  $arrayFecha=explode("-",$fecha);

		if(checkdate($arrayFecha[1], $arrayFecha[0], $arrayFecha[2])){ // MES - DIA - ANIO
			$rpt = nombre_mes($arrayFecha[1])." ".$arrayFecha[2];
		}
	}
	return $rpt;
}
//_Para limitar la cantidad de palabras
function fncLimitarPalabras($cadena, $longitud, $elipsis = "...") {  
	$palabras = explode(' ', $cadena);  
	if(count($palabras) > $longitud){  
		return implode(' ', array_slice($palabras, 0, $longitud)).$elipsis;  
	}else{  
		return $cadena;  
	}  
}
//_Para limitar la cantidad de caracteres
function fncLimitarCaracteres($cadena, $longitud, $elipsis = "...") {  
	$caracteres = strlen($cadena);
	if($caracteres>$longitud){
		return substr($cadena, 0, $longitud).$elipsis;
	}else{
		return $cadena;
	}  
}
//_Para obtener el THUMBNAIL de un video de youtube
function fncObtenerUrlThumbYoutube($video_url, $quality=0){
	$video_id = fncYoutubeId($video_url);
	return 'http://img.youtube.com/vi/' . $video_id . '/' . $quality . '.jpg';
}
//_Para obtener el ID de un video de youtube
function fncYoutubeId($url){
	$query_string = array();
	parse_str(parse_url($url, PHP_URL_QUERY), $query_string);
	$id = $query_string["v"];
	return $id;
}
//_Para emitir el Nombre en Espa�ol del mes ingresado
function nombre_mes($mes){
	$meses = array(1=>"Enero",2=>"Febrero",3=>"Marzo",4=>"Abril",5=>"Mayo",6=>"Junio",7=>"Julio",8=>"Agosto",9=>"Septiembre",10=>"Octubre",11=>"Noviembre",12=>"Diciembre");
	return $meses[GetSQLValueString($mes, "int")];
}
function nombre_mes_corto($mes){
	$meses = array(1=>"Ene",2=>"Feb",3=>"Mar",4=>"Abr",5=>"May",6=>"Jun",7=>"Jul",8=>"Ago",9=>"Sep",10=>"Oct",11=>"Nov",12=>"Dic");
	return $meses[GetSQLValueString($mes, "int")];
}
//_Para que imprime el nombre del dia
function dia($fecha){ // dd-mm-YYYY
	$fechats = strtotime($fecha);
	switch (date('w', $fechats)){
		case 0: $diaTexto = "Domingo"; break;
		case 1: $diaTexto = "Lunes"; break;
		case 2: $diaTexto = "Martes"; break;
		case 3: $diaTexto = "Miercoles"; break;
		case 4: $diaTexto = "Jueves"; break;
		case 5: $diaTexto = "Viernes"; break;
		case 6: $diaTexto = "Sabado"; break;
	} 
	return $diaTexto;
}
//_Para que imprime el nombre CORTO del dia
function fncNombreDiaCorto($fecha){ // dd-mm-YYYY
	$fechats = strtotime($fecha);
	switch (date('w', $fechats)){
		case 0: $diaTexto = "Dom"; break;
		case 1: $diaTexto = "Lun"; break;
		case 2: $diaTexto = "Mar"; break;
		case 3: $diaTexto = "Mier"; break;
		case 4: $diaTexto = "Jue"; break;
		case 5: $diaTexto = "Vie"; break;
		case 6: $diaTexto = "Sab"; break;
	} 
	return $diaTexto;
}
function fecha_not($fec=""){
	if(trim($fec)==""){ $fec=date("Y-m-d"); }
	list($anio,$mes,$dia) = explode("-",$fec);
	$fec = "TACNA, ".$dia." de ".strtoupper(nombre_mes($mes))." del ".$anio;
	return $fec;
}
//_Para imprimir la fecha corta
function fecha_letrasCorta($fecha=""){ // d-m-Y
	if(trim($fecha)<>""){
		if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
		  $arrayFecha=explode("/", $fecha);

		if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
			  $arrayFecha=explode("-",$fecha);
		
		$meses = array(1=>"Ene",2=>"Feb",3=>"Mar",4=>"Abr",5=>"May",6=>"Jun",7=>"Jul",8=>"Ago",9=>"Sept",10=>"Oct",11=>"Nov",12=>"Dic");
		$ret = $meses[GetSQLValueString($arrayFecha[1], "int")].", ".$arrayFecha[0];
		return $ret;
	}else{ return ""; }
}
//_Para imprimir la fecha para las noticias
function fecha_letrasNoticia($fecha=""){ // d-m-Y
	if(trim($fecha)<>""){
		if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
		  $arrayFecha=explode("/", $fecha);

		if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
			  $arrayFecha=explode("-",$fecha);
		
		//$meses = array(1=>"Ene",2=>"Feb",3=>"Mar",4=>"Abr",5=>"May",6=>"Jun",7=>"Jul",8=>"Ago",9=>"Sept",10=>"Oct",11=>"Nov",12=>"Dic");
		$meses = array(1=>"Enero",2=>"Febrero",3=>"Marzo",4=>"Abril",5=>"Mayo",6=>"Junio",7=>"Julio",8=>"Agosto",9=>"Septiembre",10=>"Octubre",11=>"Noviembre",12=>"Diciembre");
		$ret = $arrayFecha[0]." / ".$meses[GetSQLValueString($arrayFecha[1], "int")]." / ".$arrayFecha[2];
		return $ret;
	}else{ return ""; }
}
function fecha_letrasCompacto($fec=""){// date("Y-m-d")
	if(trim($fec)==""){ $fec=date("d-m-Y"); }
	list($dia,$mes,$anio) = explode("-",$fec);
	$fec = dia($dia."-".$mes."-".$anio)." ".$dia." de ".nombre_mes($mes)." del ".$anio;
	return $fec;
}
function fecha_datetime($fecha, $formato='%d-%m-%Y %H:%i:%s'){
	if(trim($fecha)<>""){
		$timestamp = strtotime($fecha);
		return strftime($formato,$timestamp);
	}else{ return ""; }	
}
//_Para emitir la Fecha completa
function fecha_letras($fecha=""){ //dd-mm-YYYY
	if(trim($fecha)<>""){
		if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
		  $arrayFecha=explode("/", $fecha);

		if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
			  $arrayFecha=explode("-",$fecha);

		$fec = $arrayFecha[0]." de ".nombre_mes(GetSQLValueString($arrayFecha[1], "int"))." del ".$arrayFecha[2];
		return $fec;
	}else{ return ""; }
}
//_Para emitir la Fecha completa
function fecha(){
	$fec = date("d")." de ".nombre_mes(GetSQLValueString(date("m"), "int"))." del ".date("Y");
	return $fec;
}
//_Para emitir la Fecha Sin Dia
function fechaSinDia(){
	$fec = "Tacna, ".nombre_mes(GetSQLValueString(date("m"), "int"))." del ".date("Y");
	return $fec;
}
//_Para recuperar la fecha del sistema
function fecha_corta(){
	$fec = date("d/m/Y");
	return $fec;
}
//_Para recuperar la Hora del sistema
function hora_corta(){
	$hor = date("h:i:s");
	return $hor;
}
//_Para validar una hora con formato: HH:MM
function fncValidarHoraCorta($hora=""){
	if($hora<>""){
		$arrayHora = explode(":",$hora);
		if(count($arrayHora)<2){ return false; }
		$h = $arrayHora[0];
		$m = $arrayHora[1];
		if(is_numeric($h) && is_numeric($m)){
			if($h<0 || $h>23){ return false; }
			if($m<0 || $m>59){ return false; }
			return true;
		}else{ return false; }
	}else{ return false; }
}
//_Para obtener un nuevo ID con ceros delante
function fncRellenarCeros($nro,$numCeros=3){
	$cero = "";
	for($i=strlen($nro); $i<$numCeros; $i++){
		$cero.= "0";
	}
	return $cero.$nro;
}
//_Para reemlazar NUMERO por IMAGEN (imagen con el mismo nombre del numero)
function fncNumeroImagen($numero="",$rutaImagen="",$extensionImagen=""){
	if($numero<>"" && $rutaImagen<>"" && $extensionImagen<>""){
		$numeroImagen = preg_replace("/\d/","<img src=\"".$rutaImagen."\\0".$extensionImagen."\" border=\"0\" />",$numero);
		return $numeroImagen;
	}else{
		return $numero;
	}
}
//_Para calcular el peso de un archivo
function tamano_archivo($peso , $decimales = 2 ) {
	$clase = array(" Bytes", " KB", " MB", " GB", " TB"); return
	round($peso/pow(1024,($i = floor(log($peso, 1024)))),$decimales ).$clase[$i]; 
}
//_Para obtener el PRIMER y ULTIMO dia de una semana X
function primerUltimoDiaSemana($semana,$dia="primero"){
	// Primera semana del a�o:
	$anio = date('Y', time());
	$inicio = strtotime("$anio-01-01 12:00am");
	// Obtenemos el timestamp del lunes para la primera semana
	$inicio += (1-4) * 86400;
	// Agregamos el total de semanas dadas por el usuario:
	$inicio += ($semana - 1) * 7 * 86400;
	// Agregamos 6 dias y obtenemos el timestamp del fin de semana
	$fin = $inicio + (6 * 86400);
	
	if($dia=="primero"){ return date("d/m/Y",$inicio); }
	else{ return date("d/m/Y",$fin); }
}
//_Para Verificar si una fecha est� dentro de un rango de fechas
function fncVerificarFechaRango($start_date, $end_date, $evaluame){ //--> YYYY-mm-dd (todas las fechas)
	$start_ts = strtotime($start_date); 
	$end_ts = strtotime($end_date); 
	$user_ts = strtotime($evaluame); 
	return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
}
//_Para sumar dias a una fecha
function sumaDiasFecha($fecha,$ndias,$separador=""){
  if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
		  list($dia,$mes,$anio)=explode("/", $fecha);

  if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
		  list($dia,$mes,$anio)=explode("-",$fecha);
	
	$nueva = mktime(0,0,0, $mes,$dia,$anio) + $ndias * 24 * 60 * 60;
	if($separador=="") $separador="-";
	$nuevafecha = date("d".$separador."m".$separador."Y",$nueva);

  return ($nuevafecha);  
}
// Funcion pata validar EMAIL
function comprobar_email($email){
    $mail_correcto = 0;
    //compruebo unas cosas primeras
    if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
       if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
          //miro si tiene caracter .
          if (substr_count($email,".")>= 1){
             //obtengo la terminacion del dominio
             $term_dom = substr(strrchr ($email, '.'),1);
             //compruebo que la terminaci�n del dominio sea correcta
             if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
                //compruebo que lo de antes del dominio sea correcto
                $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
                $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
                if ($caracter_ult != "@" && $caracter_ult != "."){
                   $mail_correcto = 1;
                }
             }
          }
       }
    }
    if($mail_correcto){ return 1; }
    else{ return 0; }
}
//_Para validar IMAGEN a insertar
function fncValidarImagen($foto=""){
	$permitida = 0;
	if(trim($foto)<>""){
		$ext_perm = array(0=>"gif",1=>"jpg",2=>"jpe",3=>"png");
		//$arr_foto = explode(".", $foto);
		//$ext = strtolower(end($arr_foto));
		$ext = strtolower(pathinfo($foto,PATHINFO_EXTENSION));
		for($j=0; $j<count($ext_perm); $j++){ 
			if($ext_perm[$j] == $ext){
				$permitida = 1; 
				break; 
			}
		}
	}
	return $permitida;
}
//_Para validar ARCHIVO a insertar
function fncValidarArchivo($archivo,$video=""){
	if($video=="" || $video=="no"){ $ext_perm = array(0=>"gif",1=>"jpg",2=>"jpe",3=>"png",4=>"swf"); }
	else{ $ext_perm = array(0=>"gif",1=>"jpg",2=>"jpe",3=>"png",4=>"mpg",5=>"mpe",6=>"avi"); }
	//$ext = strtolower(end(explode(".", $archivo)));
	$ext = strtolower(pathinfo($archivo,PATHINFO_EXTENSION));
	$permitida = 0;
	for ($j=0; $j<count($ext_perm); $j++){ 
		if ($ext_perm[$j] == $ext){
			$permitida = 1; 
			break; 
		}
	}
	return $permitida;
}
//_Para validar un archivo PDF
function fncValidarArchivoPDF($pdf=""){
	if(trim($pdf)<>""){
		$ext_perm = array(0=>"pdf");
		//$ext = strtolower(end(explode(".", $pdf)));
		$ext = strtolower(pathinfo($pdf,PATHINFO_EXTENSION));
		$permitida = 0;
		for ($j=0; $j<count($ext_perm); $j++){ 
			if ($ext_perm[$j] == $ext){
				$permitida = 1; 
				break; 
			}
		}
		return $permitida;
	}else{ return 0; }
}
//_Para validar un archivo EXCEL
function fncValidarArchivoEXCEL($excel=""){
	if(trim($excel)<>""){
		$ext_perm = array(0=>"xls",1=>"xlsx",2=>"csv");
		//$ext = strtolower(end(explode(".", $excel)));
		$ext = strtolower(pathinfo($excel,PATHINFO_EXTENSION));
		$permitida = 0;
		for ($j=0; $j<count($ext_perm); $j++){ 
			if ($ext_perm[$j] == $ext){
				$permitida = 1; 
				break; 
			}
		}
		return $permitida;
	}else{ return 0; }
}
//_Para validar un archivo WORD
function fncValidarArchivoWORD($word=""){
	if(trim($word)<>""){
		$ext_perm = array(0=>"doc",1=>"docx");
		//$ext = strtolower(end(explode(".", $word)));
		$ext = strtolower(pathinfo($word,PATHINFO_EXTENSION));
		$permitida = 0;
		for ($j=0; $j<count($ext_perm); $j++){ 
			if ($ext_perm[$j] == $ext){
				$permitida = 1; 
				break; 
			}
		}
		return $permitida;
	}else{ return 0; }
}
//_Para validar un RECURSO
function fncValidarRecurso($recurso=""){ //-> pdf, word, excel
	if(trim($recurso)<>""){
		$ext_perm = array(0=>"pdf", 1=>"doc",2=>"docx",3=>"rtf", 4=>"xls",5=>"xlsx",6=>"csv");
		//$ext = strtolower(end(explode(".", $recurso)));
		$ext = strtolower(pathinfo($recurso,PATHINFO_EXTENSION));
		$permitida = 0;
		for ($j=0; $j<count($ext_perm); $j++){ 
			if ($ext_perm[$j] == $ext){
				$permitida = 1; 
				break; 
			}
		}
		return $permitida;
	}else{ return 0; }
}
//_Para CONTROLAR la subida de archivos maliciosos
function fncValidarMalicioso($archivo=""){ // Compatible para cualquier subida de archivos (nombre del artchivo)
	if(trim($archivo)<>""){
		$ext_perm = array(0=>"php",1=>"asp",2=>"net",3=>"jsp",4=>"js",5=>"xml",6=>"perl",7=>"python",8=>"ruby");
		$malicioso = 1;
		for ($j=0; $j<count($ext_perm); $j++){ 
			$ext = ".".$ext_perm[$j]."."; // Ejem: imagen.php.jpg
			if(preg_match("/".$ext."/",$archivo)){
				$malicioso = 1; // Esta INFECTADO
				break;
			}else{
				$malicioso = 0; // Esta LIMPIO
			}
		}
	}else{ $malicioso = 0; } // Esta LIMPIO
	return $malicioso;
}

// Para obtener el URl completo
function fncAveriguaUrl() {
	$protocolo = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http'; // Se extrae el protocolo (http o https)
	return $protocolo.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; // Se devuelve la URL completa
}
// Para obtener el URL sin variables
function fncAveriguaUrlSinVars() {
	$protocolo = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http'; // Se extrae el protocolo (http o https)
	return $protocolo.'://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
}
// Para obtener el URl completo
function fncAveriguaUrlRaiz() {
	$protocolo = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http'; // Se extrae el protocolo (http o https)
	$url = $protocolo.'://'.$_SERVER['HTTP_HOST'];
	$ultimo_caracter = substr($url, -1);
	if($ultimo_caracter <> "/"){ $url=$url."/"; }
	return $url; // Se devuelve la URL raiz
}
// Para generar la ruta ABSOLUTA para imagenes y otros
function fncGenerarUrlAbsoluta($recurso="") {
	$tempUrl = '';
	if(!empty($recurso)){
		$tempUrl = str_replace("../../","",$recurso);
		if(fncRealIP()=="::1") {
			$tempUrl = fncAveriguaUrlRaiz()."py_diresa/BACKEND/".$tempUrl;
		} else {
			$tempUrl = fncAveriguaUrlRaiz().$tempUrl;
		}
	}
	return $tempUrl;
}

/* FUNCIONES PROPIAS DEL SISTEMA */
// Saber si un dia ingresado es domingo o no
function fncEsDomingo($fecha=""){ // fecha -> DIA - MES - A�O
	if(trim($fecha)<>""){
		if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha)){ list($dia,$mes,$anio) = explode("/", $fecha); }
	    if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha)){ list($dia,$mes,$anio) = explode("-",$fecha); }
		$timestamp = mktime(0,0,0,$mes,$dia,$anio); 
		$diaDeLaSemana = strftime("%A",$timestamp); //Obtenemos el nombre del d�a de la semana en espa�ol
		if($diaDeLaSemana == "domingo"){
			$finDeSemana = true; 
		}else{
			$finDeSemana = false;
		}
		return $finDeSemana;
	}
}
// Cantidad de dias a sumar dependiendo el periodo ingresado
function fncDiasASumar($periodo){
	switch($periodo){
		case "Diario": $dias=1; break;
		case "Semanal": $dias=7; break;
		case "Quincenal": $dias=15; break;
		case "Mensual": $dias=30; break;
		case "Bimestral": $dias=60; break;
		case "Trimestral": $dias=90; break;
	}
	return $dias;
}
// Sumar dias a una fecha
function fncSumaDiasFecha($fecha="",$dia_=0){ // fecha -> DIA - MES - A�O
	if(trim($fecha)<>""){
		if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha)){ list($dia,$mes,$anio) = explode("/", $fecha); }
	  if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha)){ list($dia,$mes,$anio) = explode("-",$fecha); }
		return date('d-m-Y',mktime(0,0,0,$mes,$dia+$dia_,$anio));
	}
}
// Restar dias a una fecha
function fncRestarDiasFecha($fecha="", $dias=0, $formato="d-m-Y"){
	$fecha_return = "";
	if(trim($fecha)<>"" && fncVerificarID($dias)==1){
		$fecha = trim($fecha);
		$fecha = str_replace('/', '-', $fecha);
		$IsDate = strtotime($fecha);
		if( $IsDate !== false ){
			$resta = strtotime ('-'.$dias.' day', $IsDate);
			$fecha_return = date($formato, $resta);
		}
	}
	return $fecha_return;
}
//_Para restar Fechas - Devuelve resultado en DIAS --> dd/mm/yyyy o dd-mm-yyyy
function fncRestaFechas($dFecIni, $dFecFin)
{
	$dFecIni = str_replace("-","",$dFecIni);
	$dFecIni = str_replace("/","",$dFecIni);
	$dFecFin = str_replace("-","",$dFecFin);
	$dFecFin = str_replace("/","",$dFecFin);

	preg_match( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecIni, $aFecIni);
	preg_match( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecFin, $aFecFin);

	$date1 = mktime(0,0,0,$aFecIni[2], $aFecIni[1], $aFecIni[3]);
	$date2 = mktime(0,0,0,$aFecFin[2], $aFecFin[1], $aFecFin[3]);

	return round(($date2 - $date1) / (60 * 60 * 24));
}
function fncRestarFechas($fecha1, $fecha2) // YYYY-MM-DD
{
	if(trim($fecha1)<>"" && trim($fecha2)<>""){
		$date1 = new DateTime($fecha1);
		$date2 = new DateTime($fecha2);
		$diff = $date1->diff($date2);
		if(($diff->invert == 1)){
			return -1;
		} else {
			return $diff->days;
		}
	} else {
		return "mal";
	}
}
// Obtener el listado de meses en un rango de fechas
function fncMesesEnUnRangoFechas($a){ // YYYY-MM-DD
	try{
		$f1 = new DateTime( $a[0] );
		$f2 = new DateTime( $a[1] );

		$diferencia = $f1->diff($f2);
		//$cant_meses = $diferencia->format('%m'); // devuelve el numero de meses entre ambas fechas.
		$cant_meses = ( $diferencia->y * 12 ) + $diferencia->m;
		$listaMeses = array($f1->format('d-m-Y'));

		for($i = 1; $i <= $cant_meses; $i++) {
			$ultimaFecha = end($listaMeses);
			$ultimaFecha = new DateTime($ultimaFecha);
			$nuevaFecha = $ultimaFecha->add(new DateInterval("P1M"));
			$nuevaFecha = $nuevaFecha->format('d-m-Y');
			array_push($listaMeses, $nuevaFecha);
		}
	} catch (Exception $e) {
			/*echo $e->getMessage();
			exit(1);*/
			$listaMeses = "";
	}
	return $listaMeses;
}
// Para convertir un numero entero a romano
function fncNumToRomano($num) {
	$rnum="";
	if ($num <0 || $num >9999) {return -1;}
	$r_ones = array(1=>"I", 2=>"II", 3=>"III", 4=>"IV", 5=>"V", 6=>"VI", 7=>"VII", 8=>"VIII", 9=>"IX");
	$r_tens = array(1=>"X", 2=>"XX", 3=>"XXX", 4=>"XL", 5=>"L", 6=>"LX", 7=>"LXX", 8=>"LXXX", 9=>"XC");
	$r_hund = array(1=>"C", 2=>"CC", 3=>"CCC", 4=>"CD", 5=>"D", 6=>"DC", 7=>"DCC", 8=>"DCCC", 9=>"CM");
	$r_thou = array(1=>"M", 2=>"MM", 3=>"MMM", 4=>"MMMM", 5=>"MMMMM", 6=>"MMMMMM", 7=>"MMMMMMM", 8=>"MMMMMMMM", 9=>"MMMMMMMMM");
	$ones = $num % 10;
	$tens = ($num - $ones) % 100;
	$hundreds = ($num - $tens - $ones) % 1000;
	$thou = ($num - $hundreds - $tens - $ones) % 10000;
	$tens = $tens / 10;
	$hundreds = $hundreds / 100;
	$thou = $thou / 1000;
	if ($thou) {$rnum .= $r_thou[$thou];} 
	if ($hundreds) {$rnum .= $r_hund[$hundreds];} 
	if ($tens) {$rnum .= $r_tens[$tens];} 
	if ($ones) {$rnum .= $r_ones[$ones];} 
	return $rnum;
}
// Para contar las palabras de una cadena
function fncTotalPalabras($cadena=""){
	if(trim($cadena)<>""){
		$totalPalabras = sizeof(explode(" ", $cadena));
	}else{
		$totalPalabras = 0;
	}
	return $totalPalabras;
}
// Para OBTENER el IP del usuario entrante
function obtenerIP() {
   if( $_SERVER['HTTP_X_FORWARDED_FOR'] != '' )
   {
      $client_ip = ( !empty($_SERVER['REMOTE_ADDR']) ) ? $_SERVER['REMOTE_ADDR'] : ( ( !empty($_ENV['REMOTE_ADDR']) ) ? $_ENV['REMOTE_ADDR'] : "unknown" );

      $entries = explode('[, ]', $_SERVER['HTTP_X_FORWARDED_FOR']);
      reset($entries);
      while (list(, $entry) = each($entries))
      {
         $entry = trim($entry);
         if ( preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $entry, $ip_list) )
         {
            $private_ip = array(
                  '/^0\./',
                  '/^127\.0\.0\.1/',
                  '/^192\.168\..*/',
                  '/^172\.((1[6-9])|(2[0-9])|(3[0-1]))\..*/',
                  '/^10\..*/');
   
            $found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);
   
            if ($client_ip != $found_ip)
            {
               $client_ip = $found_ip;
               break;
            }
         }
      }
   }
   else
   {
      $client_ip = ( !empty($_SERVER['REMOTE_ADDR']) ) ? $_SERVER['REMOTE_ADDR'] : ( ( !empty($_ENV['REMOTE_ADDR']) ) ? $_ENV['REMOTE_ADDR'] : "unknown" );
   }
   
   return $client_ip;
}
function fncRealIP(){
	if(isset($_SERVER)){
		if(isset($_SERVER["HTTP_CLIENT_IP"])){
			return $_SERVER["HTTP_CLIENT_IP"];
		}elseif(isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
			return $_SERVER["HTTP_X_FORWARDED_FOR"];
		}elseif(isset($_SERVER["HTTP_X_FORWARDED"])){
			return $_SERVER["HTTP_X_FORWARDED"];
		}elseif(isset($_SERVER["HTTP_FORWARDED_FOR"])){
			return $_SERVER["HTTP_FORWARDED_FOR"];
		}elseif(isset($_SERVER["HTTP_FORWARDED"])){
			return $_SERVER["HTTP_FORWARDED"];
		}else{
			return $_SERVER["REMOTE_ADDR"];
		}
	}else{
		if(isset($GLOBALS['HTTP_SERVER_VARS']['HTTP_X_FORWARDER_FOR'])){
			return $GLOBALS['HTTP_SERVER_VARS']['HTTP_X_FORWARDED_FOR'];
		}else{
			return $GLOBALS['HTTP_SERVER_VARS']['REMOTE_ADDR'];
		}
  }
}
//_Para obtener una URL amigable
function fncUrlAmigable($string){
	$string = trim($string);
	$string = fncReemplazarCaracteresEspeciales($string);
	//condici�n para que las palabras de 3 o menos caracteres no aparezcan en la url y las sustituimos por espacios
	//$string = preg_replace('/\b.{1,3}\b/', ' ', $string);
	$string = preg_replace("/[^a-zA-Z0-9_-]+/", "-", $string);
	//eliminanos los espacios de la anterior sustituci�n
	$string = preg_replace('/\s\s+/', '-', $string);
	//eliminamos los espacios al principio y final
	$string = strtolower(str_replace(" ","-", $string));
	return $string;
}
//_Para la redireccion
function fncRedirect($filename){
	if(trim($filename)<>""){
		if(!headers_sent())
			header('Location: '.$filename);
		else{
			echo '<script type="text/javascript">';
			echo 'window.location.href="'.$filename.'";';
			echo '</script>';
			echo '<noscript>';
			echo '<meta http-equiv="refresh" content="0;url='.$filename.'" />';
			echo '</noscript>';
		}
	}
}
//_Para obtener el navegador del usuario
function fncObtenerNavegador() {
	$agente = $_SERVER['HTTP_USER_AGENT'];
	$navegador = 'Unknown';
	$platforma = 'Unknown';
	#_Obtenemos la Plataforma
	if (preg_match('/linux/i', $agente)) 
	{
		$platforma = 'linux';
	} elseif (preg_match('/macintosh|mac os x/i', $agente)) {
		$platforma = 'mac';
	} elseif (preg_match('/windows|win32/i', $agente)) {
		$platforma = 'windows';
	} elseif (preg_match('/windows|win64/i', $agente)) {
		$platforma = 'windows';
	}
	#_Obtener el UserAgente
	if(preg_match('/MSIE/i',$agente) && !preg_match('/Opera/i',$agente))
	{
		$navegador = 'Internet Explorer';
		$navegador_corto = "MSIE";
	} elseif (preg_match('/Firefox/i',$agente)) {
		$navegador = 'Mozilla Firefox';
		$navegador_corto = "Firefox";
	} elseif (preg_match('/Chrome/i',$agente)) {
		$navegador = 'Google Chrome';
		$navegador_corto = "Chrome";
	} elseif (preg_match('/Safari/i',$agente)) {
		$navegador = 'Apple Safari';
		$navegador_corto = "Safari";
	} elseif (preg_match('/Opera/i',$agente)) {
		$navegador = 'Opera';
		$navegador_corto = "Opera";
	} elseif (preg_match('/Netscape/i',$agente)) {
		$navegador = 'Netscape';
		$navegador_corto = "Netscape";
	}
	#_Resultado final del Navegador Web que Utilizamos
	return array(
		'agente' 		=> $agente,
		'nombre'    => $navegador,
		'platforma' => $platforma
	);
}

// =======================================================================================================================================

//_Validar cadena JSON
function fncValidarJSON($string)
{
    // decode the JSON data
    $result = json_decode($string);

    // switch and check possible JSON errors
    switch (json_last_error()) {
        case JSON_ERROR_NONE:
            $error = ''; // JSON is valid // No error has occurred
            break;
        case JSON_ERROR_DEPTH:
            $error = 'The maximum stack depth has been exceeded.';
            break;
        case JSON_ERROR_STATE_MISMATCH:
            $error = 'Invalid or malformed JSON.';
            break;
        case JSON_ERROR_CTRL_CHAR:
            $error = 'Control character error, possibly incorrectly encoded.';
            break;
        case JSON_ERROR_SYNTAX:
            $error = 'Syntax error, malformed JSON.';
            break;
        // PHP >= 5.3.3
        case JSON_ERROR_UTF8:
            $error = 'Malformed UTF-8 characters, possibly incorrectly encoded.';
            break;
        // PHP >= 5.5.0
        case JSON_ERROR_RECURSION:
            $error = 'One or more recursive references in the value to be encoded.';
            break;
        // PHP >= 5.5.0
        case JSON_ERROR_INF_OR_NAN:
            $error = 'One or more NAN or INF values in the value to be encoded.';
            break;
        case JSON_ERROR_UNSUPPORTED_TYPE:
            $error = 'A value of a type that cannot be encoded was given.';
            break;
        default:
            $error = 'Unknown JSON error occured.';
            break;
    }

    if ($error !== '') {
        // throw the Exception or exit // or whatever :)
        exit($error);
    }

    // everything is OK
    return $result;
}

function fncGeneralEliminarTildesCaracteresRaros($cadena){

	//Codificamos la cadena en formato utf8 en caso de que nos de errores
	// $cadena = utf8_encode($cadena);

	//Ahora reemplazamos las letras
	$cadena = str_replace(
			array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
			array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
			$cadena
	);

	$cadena = str_replace(
			array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
			array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
			$cadena );

	$cadena = str_replace(
			array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
			array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
			$cadena );

	$cadena = str_replace(
			array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
			array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
			$cadena );

	$cadena = str_replace(
			array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
			array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
			$cadena );

	$cadena = str_replace(
			array('ñ', 'Ñ', 'ç', 'Ç'),
			array('n', 'N', 'c', 'C'),
			$cadena
	);

	// $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ';
	// $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyyby';
	// $cadena = utf8_decode($cadena);
	// $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
	// $cadena = utf8_encode($cadena);

	return $cadena;
}

//_Para validar y formatear una fecha
function fncValidarFormatearFecha($fecha="", $formato="d-m-Y H:i:s") //-> $fecha = dd-mm-YYYY
{
	$rpt = null;
	if(trim($fecha) <> ""){
		$fecha = trim($fecha);
		$fecha = str_replace('/', '-', $fecha);
		$IsDate = strtotime($fecha);
		if( $IsDate !== false ){ 
			//$date = date_create($fecha);
			//$rpt = date_format($date, $formato);
			$rpt = date($formato, $IsDate);
		}
	}
	return $rpt;
}

//_Funcion para convertir un ARRAY a OBJETO
function fncConvertirArrayToObject($Array) {
	if(is_array($Array)) {
		$object = new stdClass(); //-------------> Creamos un objeto: new stdClass
		foreach ($Array as $key => $value) { //--> Use el bucle FOREACH para convertir la matriz en un objeto stdClass
			if (is_array($value)) { 
				$value = fncConvertirArrayToObject($value); 
			} 
			$object->$key = $value;
		}
		return $object; 
	}else{
		return $Array;
	}
}

//_Funcion para DISMINUIR la profundidad a un ARRAY
function fncDisminuirProfundidadArray($Array) {
	$arrayReturn = array();
	if(is_array($Array)) {
		$profundidad = count($Array) - 1;
		if($profundidad>=0){
			$arrayReturn = $Array[$profundidad];
		}else{
			$arrayReturn = $Array;
		}
	} else {
		$arrayReturn = $Array;
	}
	return $arrayReturn;
}

//_Funcion para AGREGAR un elemento (índice y valor) a un ARRAY
function fncAgregarElementoArrayBidimensional($array, $indice, $valor){
	$arrayReturn = array();
	if(is_array($array) && trim($indice) && trim($valor)) {
		foreach ($array as $key_1=>$valor_1) {
			$arrayReturn[$key_1] = $valor_1;
			foreach ($valor_1 as $key_2=>$valor_2) {
				$arrayReturn[$key_1][$key_2] = $valor_2;
			}
			if(array_key_exists($indice,$arrayReturn[$key_1])==false){
				$arrayReturn[$key_1][$indice] = $valor;
			}
		}
	} else {
		$arrayReturn = $array;
	}
	return $arrayReturn;
}

//_ Funcion para obtener el valor de acuerdo a un key de un array
function fncObtenerValorArray($dtRow = [], $strCampo = '', $isOnlyObject = false)
{
	$valorReturn = null;
	$count = is_array($dtRow) ? count($dtRow) : 1;
	if( $count >= 1 ){	
		if( $isOnlyObject ){ 
			$objJSON = json_encode($dtRow); //-------------> Representación JSON
		}else{
			$objJSON = json_encode($dtRow[0]); //----------> Representación JSON
		}
		$objectToArray = json_decode($objJSON, true); //-> Cuando es TRUE, los object devueltos serán convertidos a array asociativos.
		if(is_array($objectToArray)) {
			if( count($objectToArray) > 0 ) {
				$arrayKeys = array_keys($objectToArray);
				if( count($arrayKeys) > 0 ){ 
					foreach ($arrayKeys as $keys ) {
						if( trim($keys) == $strCampo ){
							$valorReturn = $objectToArray[$strCampo];
							break;
						}
					}
				}
			}
		}
	}
	return $valorReturn;
}

function fncGeneralValidarDataArray($dtArray = [])
{
	$bolReturn = true;
	$count = 0;
	//$count = is_array($dtArray) ? count($dtArray) : 1;
	if(is_array($dtArray)){
		$count = count($dtArray);
	}elseif(is_object($dtArray)){
		$count = 1;
	}elseif(is_bool($dtArray)){
		if($dtArray == true){ $count=1; }
	}
	if( $count == 0 ){
		$bolReturn = false;
	}
	return $bolReturn;
}

function fncGeneralVerificarEsNumerico($valor)
{
	if(is_numeric($valor) /*&& $valor > 0 && $valor == round($valor, 0)*/){
		return true;
	}else{
		return false;
	}
}

function fncGenerarCadenaAleatoria($length = 10) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
} 

function fncEncriptarContrasenia($strContrasenia){
	$strContrasenia = password_hash( trim( $strContrasenia ), PASSWORD_DEFAULT, [15] );
	return $strContrasenia;
}

function fncVerificarContraseniaEncriptada($strContrasenia, $strHash){
	return (Int) password_verify($strContrasenia, $strHash);
}

function  fncGetBearerToken() {
	$headers = fncGetAuthorizationHeader();
	// HEADER: Get the access token from the header
	if (!empty($headers)) {
		if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
			if($matches[1]==""){
				$matches[1]=$_REQUEST["token"];
			}
			return $matches[1];
		} else {
			if(isset($_REQUEST["token"])){
				return $_REQUEST["token"];
			}
		}
	}else{
		if(isset($_REQUEST["token"])){
			return $_REQUEST["token"];
		}
	}
	return null;
}

function fncGetAuthorizationHeader(){
	$headers = null;
	if (isset($_SERVER['Authorization'])) {
			$headers = trim($_SERVER["Authorization"]);
	} elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
			$headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
	} elseif (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
			$headers = trim($_SERVER["REDIRECT_HTTP_AUTHORIZATION"]);
	} elseif (function_exists('apache_request_headers')) {
			$requestHeaders = apache_request_headers();
			//print_r($requestHeaders);
			// Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
			$requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
			if (isset($requestHeaders['Authorization'])) {
				$headers = trim($requestHeaders['Authorization']);
			} else {
				$headers = $requestHeaders; //SE AGREGO YA QUE EL SERVIDOR NO ACEPTA EL PARAMETRO AUTHORIZATION
			}
			//$headers = ($requestHeaders);
	}
	return $headers;
}

function fncRandomizarArray($array)
{
    // Get array length
    $count = count($array);
    // Create a range of indicies
    $indi = range(0,$count-1);
    // Randomize indicies array
    shuffle($indi);
    // Initialize new array
    $newarray = array($count);
    // Holds current index
    $i = 0;
    // Shuffle multidimensional array
    foreach ($indi as $index)
    {
        $newarray[$i] = $array[$index];
        $i++;
    }
    return $newarray;
}

//=======================================================================================
// Funcion para la configuracion del  Status e impresion del Mensaje
//=======================================================================================
function fncEvaluarRespuestaToken($respuesta){
    if($respuesta=="token" || $respuesta=="acceso"){
        if($respuesta=="token"){
            $rpt_mensaje = "Error al validar el token";
            $rpt_codigo = 400;
        }else{
            $rpt_mensaje = "";
            $rpt_codigo = 401;
        }
        $arrayReturn["mensaje"] = $rpt_mensaje;
        $arrayReturn["error"] = true;
        $arrayReturn["data"] = [];
        //http_response_code($rpt_codigo);
        //echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
    	exit();
    }
}
if (!function_exists('http_response_code'))
{
	function http_response_code($code = NULL) {
		if ($code !== NULL) {
			switch ($code) {
				case 100: $text = 'Continue'; break;
				case 101: $text = 'Switching Protocols'; break;
				case 200: $text = 'OK'; break;
				case 201: $text = 'Created'; break;
				case 202: $text = 'Accepted'; break;
				case 203: $text = 'Non-Authoritative Information'; break;
				case 204: $text = 'No Content'; break;
				case 205: $text = 'Reset Content'; break;
				case 206: $text = 'Partial Content'; break;
				case 300: $text = 'Multiple Choices'; break;
				case 301: $text = 'Moved Permanently'; break;
				case 302: $text = 'Moved Temporarily'; break;
				case 303: $text = 'See Other'; break;
				case 304: $text = 'Not Modified'; break;
				case 305: $text = 'Use Proxy'; break;
				case 400: $text = 'Bad Request'; break;
				case 401: $text = 'Unauthorized'; break;
				case 402: $text = 'Payment Required'; break;
				case 403: $text = 'Forbidden'; break;
				case 404: $text = 'Not Found'; break;
				case 405: $text = 'Method Not Allowed'; break;
				case 406: $text = 'Not Acceptable'; break;
				case 407: $text = 'Proxy Authentication Required'; break;
				case 408: $text = 'Request Time-out'; break;
				case 409: $text = 'Conflict'; break;
				case 410: $text = 'Gone'; break;
				case 411: $text = 'Length Required'; break;
				case 412: $text = 'Precondition Failed'; break;
				case 413: $text = 'Request Entity Too Large'; break;
				case 414: $text = 'Request-URI Too Large'; break;
				case 415: $text = 'Unsupported Media Type'; break;
				case 500: $text = 'Internal Server Error'; break;
				case 501: $text = 'Not Implemented'; break;
				case 502: $text = 'Bad Gateway'; break;
				case 503: $text = 'Service Unavailable'; break;
				case 504: $text = 'Gateway Time-out'; break;
				case 505: $text = 'HTTP Version not supported'; break;
				default:
					exit('Unknown http status code "' . htmlentities($code) . '"');
					break;
			}
			$protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
			header($protocol . ' ' . $code . ' ' . $text);
			$GLOBALS['http_response_code'] = $code;
		} else {
			$code = (isset($GLOBALS['http_response_code']) ? $GLOBALS['http_response_code'] : 200);
		}
		return $code;
	}
}
?>