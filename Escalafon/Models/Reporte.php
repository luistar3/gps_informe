<?php
class Reporte implements \JsonSerializable
{
    protected $titulo;
    protected $url;
    protected $tipoArchivo;



    public function jsonSerialize()	{
      $vars = get_object_vars($this);
      return $vars;
    }
}    
?>