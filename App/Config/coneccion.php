<?php
class connection
{

	// $status -> El estatus de la conexión
	// $server -> La IP o dirección del servidor de la base de datos SQL Server
	// $database -> El nombre de la base de datos que vamos a tomar como predeterminada
	// $userid -> El nombre de usuario a conectarse a la base de datos
	// $passwd -> La contraseña de la base de datos a conectarse

	private $server;
	private $database;
	private $userid;
	private $passwd;

	function __construct()
	{
		$this->server = '192.185.94.10';
		$this->database = 'gpstelde_gpstel';
		$this->userid = 'gpstelde_root';
		$this->passwd = 'clave*2020';
	}


	// La función que iniciará la conexión con la base de datos

	public function openConnection()
	{
		$status = null;


		//mysql:host=localhost;dbname=prueba', $usuario, $contraseña

		if (!isset($status))
		{
			//$status = mysqli_connect($this -> server, $this -> userid, $this -> passwd,$this->database);
			
			
		$opciones = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::MYSQL_ATTR_FOUND_ROWS => true,
			PDO::MYSQL_ATTR_SSL_CA => '/path/to/ssl-cert.pem',
			PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false
        );
 
        $status = new PDO(
            'mysql:host=' . $this->server . ';dbname=' . $this->database,
            $this->userid,
            $this->passwd,
            $opciones
        );

			if (!$status)
			{
				die('Error fatal. No se puede conectar a la base de datos.');
			}
			return $status;
		}
		else
		{
			return $status;
		}
	}

	public function closeConnection($status)
	{
		$status=null;
	}
}

?>
