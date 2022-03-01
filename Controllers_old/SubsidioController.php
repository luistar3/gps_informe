<?php

require_once '../../App/Config/control.php';
require_once '../../App/Public/archivo.php';
require_once '../../App/Public/rutas.php';
require_once '../../App/Escalafon/Controllers/AuditoriaController.php';
require_once '../../App/Escalafon/Models/Subsidio.php';
require_once '../../App/Escalafon/Models/AuditoriaArchivo.php';

class SubsidioController extends Subsidio
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

	public function fncListar($id_trabajador)
	{
		$subsidios = $this->fncListarBD($id_trabajador);

		foreach ($subsidios as $subsidio)
		{
			$subsidio = $this->fncObtenerDatosRegistroBD($subsidio);
		}

		$auditoriaController = new AuditoriaController;
		$auditoria = $auditoriaController->fncGuardar(4, 'subsidio');

		return $subsidios;
	}

	public function fncObtener($id_trabajador, $id_subsidio)
	{
		if (!$subsidio = $this->fncObtenerBD($id_trabajador, $id_subsidio))
		{
			return false;
		}

		$subsidio = $this->fncObtenerDatosRegistroBD($subsidio);

		$auditoriaController = new AuditoriaController;
		$auditoria = $auditoriaController->fncGuardar(4, 'subsidio', 'id_subsidio', $subsidio->id_subsidio);

		return $subsidio;
	}

	public function fncGuardar($inputs, $files)
	{
		$subsidio = new Subsidio;

		$subsidio->id_trabajador = $inputs->id_trabajador;
		$subsidio->id_tipo_accion = $inputs->id_tipo_accion;
		$subsidio->id_tipo_documento = $inputs->id_tipo_documento;
		$subsidio->id_tipo_resolucion = isset($inputs->id_tipo_resolucion)? $inputs->id_tipo_resolucion : null;
		$subsidio->numero_documento = isset($inputs->numero_documento)? $inputs->numero_documento : null;
		$subsidio->fecha_documento = isset($inputs->fecha_documento)? $inputs->fecha_documento : null;
		$subsidio->asunto = isset($inputs->asunto)? $inputs->asunto : null;
		$subsidio->numero_resolucion = isset($inputs->numero_resolucion)? $inputs->numero_resolucion : null;
		$subsidio->fecha = isset($inputs->fecha)? $inputs->fecha : null;
		$subsidio->observacion = isset($inputs->observacion)? $inputs->observacion : null;

		$subsidio->archivo = null;
		$aud_archivo = null;

		if (isset($files->archivo) && $files->archivo->name != '')
		{
			$ruta =  cls_rutas::get('subsidioPdf');
			$archivo = new archivo((array) $files->archivo, $ruta, "pdf_", 0, 1);
			if ($archivo->subir())
			{
				$subsidio->archivo = $ruta.$archivo->get_nombre_archivo();

				$aud_archivo = new AuditoriaArchivo;
				$aud_archivo->setNombre($archivo->get_nombre_archivo());
				$aud_archivo->setNombreOriginal($files->archivo->name);
				$aud_archivo->setRuta($subsidio->archivo);
				$aud_archivo->setTamano($files->archivo->size);
			}
		}

		if (!$subsidio = $this->fncGuardarBD($subsidio))
		{
			return false;
		}

		$auditoriaController = new AuditoriaController;
		$aud_subsidio = clone $subsidio;
		$aud_subsidio->archivo = $aud_archivo;
		$auditoria = $auditoriaController->fncGuardar(1, 'subsidio', 'id_subsidio', $aud_subsidio->id_subsidio, json_encode($aud_subsidio));

		$subsidio->fecha_registro = $auditoria->getFecha();
		$subsidio->hora_registro = $auditoria->getHora();
		$subsidio->usuario_registro = $auditoria->getUsuario();

		return $subsidio;
	}

	public function fncActualizar($inputs, $files)
	{
		if (!$subsidio = $this->fncObtenerBD($inputs->id_trabajador, $inputs->id_subsidio))
		{
			return false;
		}

		$subsidio = $this->fncObtenerDatosRegistroBD($subsidio);

		$subsidio->id_tipo_accion = $inputs->id_tipo_accion;
		$subsidio->id_tipo_documento = $inputs->id_tipo_documento;
		$subsidio->id_tipo_resolucion = isset($inputs->id_tipo_resolucion)? $inputs->id_tipo_resolucion : null;
		$subsidio->numero_documento = isset($inputs->numero_documento)? $inputs->numero_documento : null;
		$subsidio->fecha_documento = isset($inputs->fecha_documento)? $inputs->fecha_documento : null;
		$subsidio->asunto = isset($inputs->asunto)? $inputs->asunto : null;
		$subsidio->numero_resolucion = isset($inputs->numero_resolucion)? $inputs->numero_resolucion : null;
		$subsidio->fecha = isset($inputs->fecha)? $inputs->fecha : null;
		$subsidio->observacion = isset($inputs->observacion)? $inputs->observacion : null;

		$aud_archivo = $subsidio->archivo;

		if (isset($files->archivo) && $files->archivo->name != '')
		{
			$ruta =  cls_rutas::get('subsidioPdf');
			$archivo = new archivo((array) $files->archivo, $ruta, "pdf_", 0, 1);
			if ($archivo->subir())
			{
				if(file_exists($subsidio->archivo)) { unlink($subsidio->archivo); }

				$subsidio->archivo = $ruta.$archivo->get_nombre_archivo();

				$aud_archivo = new AuditoriaArchivo;
				$aud_archivo->setNombre($archivo->get_nombre_archivo());
				$aud_archivo->setNombreOriginal($files->archivo->name);
				$aud_archivo->setRuta($subsidio->archivo);
				$aud_archivo->setTamano($files->archivo->size);
			}
		}

		$subsidio = $this->fncActualizarBD($subsidio);


		$auditoriaController = new AuditoriaController;
		$aud_subsidio = clone $subsidio;
		$aud_subsidio->archivo = $aud_archivo;
		$auditoria = $auditoriaController->fncGuardar(2, 'subsidio', 'id_subsidio', $aud_subsidio->id_subsidio, json_encode($aud_subsidio));

		return $subsidio;
	}

	public function fncEliminar($id_trabajador, $id_subsidio)
	{
		if (!$subsidio = $this->fncObtenerBD($id_trabajador, $id_subsidio))
		{
			return false;
		}

		$aux_subsidio = clone $subsidio;

		$subsidio = $this->fncEliminarBD($subsidio->id_subsidio);

		if(file_exists($aux_subsidio->archivo)) { unlink($aux_subsidio->archivo); }

		$auditoriaController = new AuditoriaController;
		$auditoria = $auditoriaController->fncGuardar(3, 'subsidio', 'id_subsidio', $id_subsidio);

		return $subsidio;
	}

	/*
	|--------------------------------------------------------------------------
	| Funciones de consulta a la base de datos
	|--------------------------------------------------------------------------
	*/

	private function fncListarBD($id_trabajador)
	{
		$sql = cls_control::get_instancia();

		$query = '
		SELECT
			s.id_subsidio,
			s.id_trabajador,
			s.id_tipo_accion,
			s.id_tipo_documento,
			s.id_tipo_resolucion,
			s.numero_documento,
			s.fecha_documento,
			s.asunto,
			s.numero_resolucion,
			s.fecha,
			s.observacion,
			s.archivo
		FROM escalafon.subsidio s
		WHERE
			s.id_trabajador = :id_trabajador AND
			s.eliminado = 0
		';

		$statement = $sql->preparar($query);
		$data = [];

		if ($statement)
		{
			$statement->bindParam("id_trabajador", $id_trabajador);

			$sql->ejecutar();
			$sql->cerrar();

			while($registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$subsidio = new Subsidio;

				$subsidio->id_subsidio			= $registro["id_subsidio"];
				$subsidio->id_trabajador		= $registro["id_trabajador"];
				$subsidio->id_tipo_accion		= $registro["id_tipo_accion"];
				$subsidio->id_tipo_documento	= $registro["id_tipo_documento"];
				$subsidio->id_tipo_resolucion	= $registro["id_tipo_resolucion"];
				$subsidio->numero_documento		= $registro["numero_documento"];
				$subsidio->fecha_documento		= $registro["fecha_documento"];
				$subsidio->asunto				= $registro["asunto"];
				$subsidio->numero_resolucion	= $registro["numero_resolucion"];
				$subsidio->fecha				= $registro["fecha"];
				$subsidio->observacion			= $registro["observacion"];
				$subsidio->archivo				= $registro["archivo"];

				$data[] = $subsidio;
			}
		}

		return $data;
	}

	private function fncObtenerBD($id_trabajador, $id_subsidio)
	{
		$sql = cls_control::get_instancia();

		$query = '
		SELECT
			s.id_subsidio,
			s.id_trabajador,
			s.id_tipo_accion,
			s.id_tipo_documento,
			s.id_tipo_resolucion,
			s.numero_documento,
			s.fecha_documento,
			s.asunto,
			s.numero_resolucion,
			s.fecha,
			s.observacion,
			s.archivo
		FROM escalafon.subsidio s
		WHERE
			s.id_trabajador = :id_trabajador AND
			s.id_subsidio = :id_subsidio AND
			s.eliminado = 0
		';

		$statement = $sql->preparar($query);
		$subsidio = new Subsidio;

		if ($statement)
		{
			$statement->bindParam("id_subsidio", $id_subsidio);
			$statement->bindParam("id_trabajador", $id_trabajador);

			$sql->ejecutar();
			$sql->cerrar();

			if(!$registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				return false;
			}

			$subsidio->id_subsidio			= $registro["id_subsidio"];
			$subsidio->id_trabajador		= $registro["id_trabajador"];
			$subsidio->id_tipo_accion		= $registro["id_tipo_accion"];
			$subsidio->id_tipo_documento	= $registro["id_tipo_documento"];
			$subsidio->id_tipo_resolucion	= $registro["id_tipo_resolucion"];
			$subsidio->numero_documento		= $registro["numero_documento"];
			$subsidio->fecha_documento		= $registro["fecha_documento"];
			$subsidio->asunto				= $registro["asunto"];
			$subsidio->numero_resolucion	= $registro["numero_resolucion"];
			$subsidio->fecha				= $registro["fecha"];
			$subsidio->observacion			= $registro["observacion"];
			$subsidio->archivo				= $registro["archivo"];
		}

		return $subsidio;
	}

	private function fncObtenerDatosRegistroBD(Subsidio $subsidio)
	{
		$sql = cls_control::get_instancia();

		$query = '
		SELECT
			a.fecha_hora::date AS fecha_registro,
			a.fecha_hora::time AS hora_registro,
			pn.nombres || \' \' || pn.apellidos AS usuario_registro
		FROM escalafon.auditoria a
		LEFT JOIN adm.usuario u ON u.id_usuario = a.id_usuario
		LEFT JOIN public.persona_natural pn ON pn.id_persona = u.id_persona
		WHERE
			a.tabla = \'subsidio\' AND
			a.objeto_id_valor = :id_subsidio AND
			a.id_operacion = 1
		';

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_subsidio", $subsidio->id_subsidio);

			$sql->ejecutar();
			$sql->cerrar();

			if($registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$subsidio->fecha_registro	= $registro["fecha_registro"];
				$subsidio->hora_registro	= $registro["hora_registro"];
				$subsidio->usuario_registro	= $registro["usuario_registro"];
			}
		}

		return $subsidio;
	}

	private function fncGuardarBD(Subsidio $subsidio)
	{
		$sql = cls_control::get_instancia();

		$query = '
		INSERT INTO escalafon.subsidio(
			id_trabajador,
			id_tipo_accion,
			id_tipo_documento,
			id_tipo_resolucion,
			numero_documento,
			fecha_documento,
			asunto,
			numero_resolucion,
			fecha,
			observacion,
			archivo,
			eliminado)
		VALUES (
			:id_trabajador,
			:id_tipo_accion,
			:id_tipo_documento,
			:id_tipo_resolucion,
			:numero_documento,
			:fecha_documento,
			:asunto,
			:numero_resolucion,
			:fecha,
			:observacion,
			:archivo,
			0
		)
		RETURNING
			id_subsidio,
			id_trabajador,
			id_tipo_accion,
			id_tipo_documento,
			id_tipo_resolucion,
			numero_documento,
			fecha_documento,
			asunto,
			numero_resolucion,
			fecha,
			observacion,
			archivo
		';

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_trabajador", $subsidio->id_trabajador);
			$statement->bindParam("id_tipo_accion", $subsidio->id_tipo_accion);
			$statement->bindParam("id_tipo_documento", $subsidio->id_tipo_documento);
			$statement->bindParam("id_tipo_resolucion", $subsidio->id_tipo_resolucion);
			$statement->bindParam("numero_documento", $subsidio->numero_documento);
			$statement->bindParam("fecha_documento", $subsidio->fecha_documento);
			$statement->bindParam("asunto", $subsidio->asunto);
			$statement->bindParam("numero_resolucion", $subsidio->numero_resolucion);
			$statement->bindParam("fecha", $subsidio->fecha);
			$statement->bindParam("observacion", $subsidio->observacion);
			$statement->bindParam("archivo", $subsidio->archivo);

			$sql->ejecutar();
			$sql->cerrar();

			if($registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$subsidio->id_subsidio = $registro["id_subsidio"];
				$subsidio->fecha_documento = $registro["fecha_documento"];
				$subsidio->fecha = $registro["fecha"];
			}
			else
			{
				return false;
			}
		}

		return $subsidio;
	}

	private function fncActualizarBD(Subsidio $subsidio)
	{
		$sql = cls_control::get_instancia();

		$query = "
		UPDATE escalafon.subsidio SET
			id_tipo_accion=:id_tipo_accion,
			id_tipo_documento=:id_tipo_documento,
			id_tipo_resolucion=:id_tipo_resolucion,
			numero_documento=:numero_documento,
			fecha_documento=:fecha_documento,
			asunto=:asunto,
			numero_resolucion=:numero_resolucion,
			fecha=:fecha,
			observacion=:observacion,
			archivo=:archivo
		WHERE id_subsidio = :id_subsidio
		RETURNING
			id_subsidio,
			id_trabajador,
			id_tipo_accion,
			id_tipo_documento,
			id_tipo_resolucion,
			numero_documento,
			fecha_documento,
			asunto,
			numero_resolucion,
			fecha,
			observacion,
			archivo
		";

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_subsidio", $subsidio->id_subsidio);
			$statement->bindParam("id_tipo_accion", $subsidio->id_tipo_accion);
			$statement->bindParam("id_tipo_documento", $subsidio->id_tipo_documento);
			$statement->bindParam("id_tipo_resolucion", $subsidio->id_tipo_resolucion);
			$statement->bindParam("numero_documento", $subsidio->numero_documento);
			$statement->bindParam("fecha_documento", $subsidio->fecha_documento);
			$statement->bindParam("asunto", $subsidio->asunto);
			$statement->bindParam("numero_resolucion", $subsidio->numero_resolucion);
			$statement->bindParam("fecha", $subsidio->fecha);
			$statement->bindParam("observacion", $subsidio->observacion);
			$statement->bindParam("archivo", $subsidio->archivo);

			$sql->ejecutar();
			$sql->cerrar();

			if($registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$subsidio->fecha_documento = $registro["fecha_documento"];
				$subsidio->fecha = $registro["fecha"];
			}
			else
			{
				return false;
			}
		}

		return $subsidio;
	}

	private function fncEliminarBD($id_subsidio)
	{
		$sql = cls_control::get_instancia();

		$query = "
		UPDATE escalafon.subsidio SET
			eliminado=1
		WHERE id_subsidio = :id_subsidio
		RETURNING
			id_subsidio
		";

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_subsidio", $id_subsidio);

			$sql->ejecutar();
			$sql->cerrar();

			if($registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
}