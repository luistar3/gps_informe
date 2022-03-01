<?php
class Juridico implements \JsonSerializable
{
    protected $idJuridico;
    protected $razonSocial;
    protected $ruc;
    protected $correo;
    protected $idRepresentanteLegal;
    protected $created_at;
    protected $updated_at;

    public function __construct()
    {
    }  
    public function getIdJuridico(){return $this->idJuridico;}
    public function getRazonSocial(){return $this->razonSocial;}
    public function getRuc(){return $this->ruc;}
    public function getCorreo(){return $this->correo;}
    public function getIdRepresentanteLegal(){return $this->idRepresentanteLegal;}
    public function getCreated_at(){return $this->created_at;}
    public function getUpdated_at(){return $this->updated_at;}


    public function setIdJuridico($idJuridico){$this->idJuridico = $idJuridico;}
    public function setRazonSocial($razonSocial){$this->razonSocial = $razonSocial;}
    public function setRuc($ruc){$this->ruc = $ruc;}
    public function setCorreo($correo){$this->correo = $correo;}
    public function setIdRepresentanteLegal($idRepresentanteLegal){$this->idRepresentanteLegal = $idRepresentanteLegal;}
    public function setCreated_at($created_at){$this->created_at = $created_at;}
    public function setUpdated_at($updated_at){$this->updated_at = $updated_at;}
   
    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
}
?>