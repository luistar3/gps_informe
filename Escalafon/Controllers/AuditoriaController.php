<?php

require_once '../../App/Config/control.php';
require_once '../../App/Escalafon/Models/Auditoria.php';
require_once '../../App/Auth/token.php';

class AuditoriaController extends Auditoria
{
	public function __construct()
	{
		date_default_timezone_set('America/Lima');
	}

	/*
	|--------------------------------------------------------------------------
	| Funciones de lógica
	|--------------------------------------------------------------------------
	*/

	public function fncGuardar($id_operacion, $tabla = null, $objeto_id_nombre = null, $objeto_id_valor = null, $objeto = null)
	{
		$auditoria = new Auditoria;

		$auditoria->id_usuario = $this->fncObtenerIdUsuario();
		$auditoria->fecha_hora = date('Y-m-d H:i:s');
		$auditoria->ip = $this->fncObtenerIP();
		$auditoria->tabla = $tabla;
		$auditoria->objeto_id_nombre = $objeto_id_nombre;
		$auditoria->objeto_id_valor = $objeto_id_valor;
		$auditoria->objeto = $objeto;
		$auditoria->id_operacion = $id_operacion;
		$auditoria->uri = $this->fncObtenerURI();

		$auditoria = $this->fncGuardarBD($auditoria);

		$auditoria->fecha = explode(' ', $auditoria->fecha_hora)[0];
		$auditoria->hora = explode(' ', $auditoria->fecha_hora)[1];
		$auditoria->usuario = $this->fncObtenerNombreCompletoUsuarioBD($auditoria->id_usuario);

		return $auditoria;
	}


	public function fncBuscarCampoAuditoria($tabla, $objetoIdNombre, $objetoIdValo)  //Agregar al proyecto
	{

		$dtReturn = array();
		$dtListado = $this->fncBuscarCampoAuditoriaBD($tabla, $objetoIdNombre, $objetoIdValo);

		if (fncGeneralValidarDataArray($dtListado)) {
			foreach ($dtListado as $listado) {

				$model = array();

				$model['id_auditoria'] 		= $listado->id_auditoria;
				$model['id_usuario'] 		= $listado->id_usuario;
				$model['id_operacion'] 		= $listado->id_operacion;
				$model['fecha_hora'] 		= $listado->fecha_hora;
				$model['usuario'] 			= $this->fncObtenerNombreCompletoUsuarioBD($listado->id_usuario);



				array_push($dtReturn, $model);
			}
		}
		return $dtReturn;
	}

	private function fncObtenerIP() {
		if (!empty($_SERVER['HTTP_CLIENT_IP']))
			return $_SERVER['HTTP_CLIENT_IP'];

		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
			return $_SERVER['HTTP_X_FORWARDED_FOR'];

		return $_SERVER['REMOTE_ADDR'];
	}

	private function fncObtenerURI()
	{
		return $_SERVER['REQUEST_URI'];
	}

	private function fncObtenerIdUsuario()
	{
		return $GLOBALS["tokenDatosIdUsuario"];
	}

	/*
	|--------------------------------------------------------------------------
	| Funciones de consulta a la base de datos
	|--------------------------------------------------------------------------
	*/

	private function fncGuardarBD(Auditoria $auditoria)
	{
		$sql = cls_control::get_instancia();

		$query = '
		INSERT INTO escalafon.auditoria(
			id_usuario,
			fecha_hora,
			ip,
			tabla,
			objeto_id_nombre,
			objeto_id_valor,
			objeto,
			id_operacion,
			uri)
		VALUES (
			:id_usuario,
			:fecha_hora,
			:ip,
			:tabla,
			:objeto_id_nombre,
			:objeto_id_valor,
			:objeto,
			:id_operacion,
			:uri
		)
		RETURNING
			id_auditoria,
			id_usuario,
			fecha_hora,
			ip,
			tabla,
			objeto_id_nombre,
			objeto_id_valor,
			objeto,
			id_operacion,
			uri
		';

		$statement = $sql->preparar($query);

		if ($statement) {
			$statement->bindParam("id_usuario", $auditoria->id_usuario);
			$statement->bindParam("fecha_hora", $auditoria->fecha_hora);
			$statement->bindParam("ip", $auditoria->ip);
			$statement->bindParam("tabla", $auditoria->tabla);
			$statement->bindParam("objeto_id_nombre", $auditoria->objeto_id_nombre);
			$statement->bindParam("objeto_id_valor", $auditoria->objeto_id_valor);
			$statement->bindParam("objeto", $auditoria->objeto);
			$statement->bindParam("id_operacion", $auditoria->id_operacion);
			$statement->bindParam("uri", $auditoria->uri);

			$sql->ejecutar();

			if ($registro = $statement->fetch(PDO::FETCH_ASSOC)) {
				$auditoria->id_auditoria = $registro["id_auditoria"];

				$sql->cerrar();
			} else {
				$sql->cerrar();
				return false;
			}
		}

		return $auditoria;
	}

	private function fncObtenerNombreCompletoUsuarioBD($id_usuario)
	{
		$sql = cls_control::get_instancia();

		$query = '
		SELECT
			pn.nombres || \' \' || pn.apellidos AS nombre_completo
		FROM adm.usuario u
		LEFT JOIN public.persona_natural pn ON pn.id_persona = u.id_persona
		WHERE u.id_usuario = :id_usuario
		';

		$statement = $sql->preparar($query);
		$nombre_completo = "";

		if ($statement) {
			$statement->bindParam("id_usuario", $id_usuario);
			$sql->ejecutar();

			$registro = $statement->fetch(PDO::FETCH_ASSOC);

			$nombre_completo = $registro["nombre_completo"];
		}

		return $nombre_completo;
	}


	private function fncBuscarCampoAuditoriaBD($tabla, $objetoIdNombre, $objetoIdValor) //agregar al proyecto
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			a.id_auditoria,
			a.id_usuario,
			a.id_operacion,
			a.fecha_hora,
			a.ip,
			a.tabla,
			a.objeto_id_nombre,
			a.objeto_id_valor,
			a.objeto,
			a.uri
		FROM
			escalafon.auditoria AS a
		WHERE ( a.id_operacion = 1 OR a.id_operacion = 2 ) AND a.tabla = :tabla AND a.objeto_id_nombre = :objeto_id_nombre AND a.objeto_id_valor = :objeto_id_valor
		ORDER BY a.id_auditoria DESC LIMIT 1
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {

			$statement->bindParam('tabla', $tabla);
			$statement->bindParam('objeto_id_nombre', $objetoIdNombre);
			$statement->bindParam('objeto_id_valor', $objetoIdValor);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new Auditoria;
				$temp->id_auditoria 	= $datos['id_auditoria'];
				$temp->id_usuario 	    = $datos['id_usuario'];
				$temp->id_operacion 	= $datos['id_operacion'];
				$temp->fecha_hora 		= $datos['fecha_hora'];


				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}




}