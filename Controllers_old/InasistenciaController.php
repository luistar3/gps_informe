<?php

require_once '../../App/Config/control.php';
require_once '../../App/Public/archivo.php';
require_once '../../App/Public/rutas.php';
require_once '../../App/Escalafon/Controllers/AuditoriaController.php';
require_once '../../App/Escalafon/Models/Inasistencia.php';
require_once '../../App/Escalafon/Models/AuditoriaArchivo.php';

class InasistenciaController extends Inasistencia
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
		$inasistencias = $this->fncListarBD($id_trabajador);

		foreach ($inasistencias as $inasistencia)
		{
			$inasistencia = $this->fncObtenerDatosRegistroBD($inasistencia);
		}

		$auditoriaController = new AuditoriaController;
		$auditoria = $auditoriaController->fncGuardar(4, 'inasistencia');

		return $inasistencias;
	}

	public function fncObtener($id_trabajador, $id_inasistencia)
	{
		if (!$inasistencia = $this->fncObtenerBD($id_trabajador, $id_inasistencia))
		{
			return false;
		}

		$inasistencia = $this->fncObtenerDatosRegistroBD($inasistencia);

		$auditoriaController = new AuditoriaController;
		$auditoria = $auditoriaController->fncGuardar(4, 'inasistencia', 'id_inasistencia', $inasistencia->id_inasistencia);

		return $inasistencia;
	}

	public function fncGuardar($inputs, $files)
	{
		$inasistencia = new Inasistencia;

		$inasistencia->id_trabajador = $inputs->id_trabajador;
		$inasistencia->id_tipo_documento = $inputs->id_tipo_documento;
		$inasistencia->id_area = $inputs->id_area;
		$inasistencia->numero_documento = isset($inputs->numero_documento)? $inputs->numero_documento : null;
		$inasistencia->numero_dias = isset($inputs->numero_dias)? $inputs->numero_dias : null;
		$inasistencia->fecha = isset($inputs->fecha)? $inputs->fecha : null;

		$inasistencia->archivo = null;
		$aud_archivo = null;

		if (isset($files->archivo) && $files->archivo->name != '')
		{
			$ruta =  cls_rutas::get('inasistenciaPdf');
			$archivo = new archivo((array) $files->archivo, $ruta, "pdf_", 0, 1);
			if ($archivo->subir())
			{
				$inasistencia->archivo = $ruta.$archivo->get_nombre_archivo();

				$aud_archivo = new AuditoriaArchivo;
				$aud_archivo->setNombre($archivo->get_nombre_archivo());
				$aud_archivo->setNombreOriginal($files->archivo->name);
				$aud_archivo->setRuta($inasistencia->archivo);
				$aud_archivo->setTamano($files->archivo->size);
			}
		}

		if (!$inasistencia = $this->fncGuardarBD($inasistencia))
		{
			return false;
		}

		$auditoriaController = new AuditoriaController;
		$aud_inasistencia = clone $inasistencia;
		$aud_inasistencia->archivo = $aud_archivo;
		$auditoria = $auditoriaController->fncGuardar(1, 'inasistencia', 'id_inasistencia', $aud_inasistencia->id_inasistencia, json_encode($aud_inasistencia));

		$inasistencia->fecha_registro = $auditoria->getFecha();
		$inasistencia->hora_registro = $auditoria->getHora();
		$inasistencia->usuario_registro = $auditoria->getUsuario();

		return $inasistencia;
	}

	public function fncActualizar($inputs, $files)
	{
		if (!$inasistencia = $this->fncObtenerBD($inputs->id_trabajador, $inputs->id_inasistencia))
		{
			return false;
		}

		$inasistencia = $this->fncObtenerDatosRegistroBD($inasistencia);

		$inasistencia->id_tipo_documento = $inputs->id_tipo_documento;
		$inasistencia->id_area = $inputs->id_area;
		$inasistencia->numero_documento = isset($inputs->numero_documento)? $inputs->numero_documento : null;
		$inasistencia->numero_dias = isset($inputs->numero_dias)? $inputs->numero_dias : null;
		$inasistencia->fecha = isset($inputs->fecha)? $inputs->fecha : null;

		$aud_archivo = $inasistencia->archivo;

		if (isset($files->archivo) && $files->archivo->name != '')
		{
			$ruta =  cls_rutas::get('inasistenciaPdf');
			$archivo = new archivo((array) $files->archivo, $ruta, "pdf_", 0, 1);
			if ($archivo->subir())
			{
				if(file_exists($inasistencia->archivo)) { unlink($inasistencia->archivo); }

				$inasistencia->archivo = $ruta.$archivo->get_nombre_archivo();

				$aud_archivo = new AuditoriaArchivo;
				$aud_archivo->setNombre($archivo->get_nombre_archivo());
				$aud_archivo->setNombreOriginal($files->archivo->name);
				$aud_archivo->setRuta($inasistencia->archivo);
				$aud_archivo->setTamano($files->archivo->size);
			}
		}

		$inasistencia = $this->fncActualizarBD($inasistencia);


		$auditoriaController = new AuditoriaController;
		$aud_inasistencia = clone $inasistencia;
		$aud_inasistencia->archivo = $aud_archivo;
		$auditoria = $auditoriaController->fncGuardar(2, 'inasistencia', 'id_inasistencia', $aud_inasistencia->id_inasistencia, json_encode($aud_inasistencia));

		return $inasistencia;
	}

	public function fncEliminar($id_trabajador, $id_inasistencia)
	{
		if (!$inasistencia = $this->fncObtenerBD($id_trabajador, $id_inasistencia))
		{
			return false;
		}

		$aud_inasistencia = clone $inasistencia;

		$inasistencia = $this->fncEliminarBD($inasistencia->id_inasistencia);

		if(file_exists($aud_inasistencia->archivo)) { unlink($aud_inasistencia->archivo); }

		$auditoriaController = new AuditoriaController;
		$auditoria = $auditoriaController->fncGuardar(3, 'inasistencia', 'id_inasistencia', $id_inasistencia);

		return $inasistencia;
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
			i.id_inasistencia,
			i.id_trabajador,
			i.id_tipo_documento,
			i.id_area,
			i.numero_documento,
			i.numero_dias,
			i.fecha,
			i.archivo
		FROM escalafon.inasistencia i
		WHERE
			i.id_trabajador = :id_trabajador AND
			i.eliminado = 0
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
				$inasistencia = new Inasistencia;

				$inasistencia->id_inasistencia		= $registro["id_inasistencia"];
				$inasistencia->id_trabajador		= $registro["id_trabajador"];
				$inasistencia->id_tipo_documento	= $registro["id_tipo_documento"];
				$inasistencia->id_area				= $registro["id_area"];
				$inasistencia->numero_documento		= $registro["numero_documento"];
				$inasistencia->numero_dias			= $registro["numero_dias"];
				$inasistencia->fecha				= $registro["fecha"];
				$inasistencia->archivo				= $registro["archivo"];

				$data[] = $inasistencia;
			}
		}

		return $data;
	}

	private function fncObtenerBD($id_trabajador, $id_inasistencia)
	{
		$sql = cls_control::get_instancia();

		$query = '
		SELECT
			i.id_inasistencia,
			i.id_trabajador,
			i.id_tipo_documento,
			i.id_area,
			i.numero_documento,
			i.numero_dias,
			i.fecha,
			i.archivo
		FROM escalafon.inasistencia i
		WHERE
			i.id_trabajador = :id_trabajador AND
			i.id_inasistencia = :id_inasistencia AND
			i.eliminado = 0
		';

		$statement = $sql->preparar($query);
		$inasistencia = new Inasistencia;

		if ($statement)
		{
			$statement->bindParam("id_inasistencia", $id_inasistencia);
			$statement->bindParam("id_trabajador", $id_trabajador);

			$sql->ejecutar();
			$sql->cerrar();

			if(!$registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				return false;
			}

			$inasistencia->id_inasistencia		= $registro["id_inasistencia"];
			$inasistencia->id_trabajador		= $registro["id_trabajador"];
			$inasistencia->id_tipo_documento	= $registro["id_tipo_documento"];
			$inasistencia->id_area				= $registro["id_area"];
			$inasistencia->numero_documento		= $registro["numero_documento"];
			$inasistencia->numero_dias			= $registro["numero_dias"];
			$inasistencia->fecha				= $registro["fecha"];
			$inasistencia->archivo				= $registro["archivo"];
		}

		return $inasistencia;
	}

	private function fncObtenerDatosRegistroBD(Inasistencia $inasistencia)
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
			a.tabla = \'inasistencia\' AND
			a.objeto_id_valor = :id_inasistencia AND
			a.id_operacion = 1
		';

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_inasistencia", $inasistencia->id_inasistencia);

			$sql->ejecutar();
			$sql->cerrar();

			if($registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$inasistencia->fecha_registro	= $registro["fecha_registro"];
				$inasistencia->hora_registro	= $registro["hora_registro"];
				$inasistencia->usuario_registro	= $registro["usuario_registro"];
			}
		}

		return $inasistencia;
	}

	private function fncGuardarBD(Inasistencia $inasistencia)
	{
		$sql = cls_control::get_instancia();

		$query = '
		INSERT INTO escalafon.inasistencia(
			id_trabajador,
			id_tipo_documento,
			id_area,
			numero_documento,
			numero_dias,
			fecha,
			archivo,
			eliminado)
		VALUES (
			:id_trabajador,
			:id_tipo_documento,
			:id_area,
			:numero_documento,
			:numero_dias,
			:fecha,
			:archivo,
			0
		)
		RETURNING
			id_inasistencia,
			id_trabajador,
			id_tipo_documento,
			id_area,
			numero_documento,
			numero_dias,
			fecha,
			archivo
		';

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_trabajador", $inasistencia->id_trabajador);
			$statement->bindParam("id_tipo_documento", $inasistencia->id_tipo_documento);
			$statement->bindParam("id_area", $inasistencia->id_area);
			$statement->bindParam("numero_documento", $inasistencia->numero_documento);
			$statement->bindParam("numero_dias", $inasistencia->numero_dias);
			$statement->bindParam("fecha", $inasistencia->fecha);
			$statement->bindParam("archivo", $inasistencia->archivo);

			$sql->ejecutar();
			$sql->cerrar();

			if($registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$inasistencia->id_inasistencia = $registro["id_inasistencia"];
				$inasistencia->fecha = $registro["fecha"];
			}
			else
			{
				return false;
			}
		}

		return $inasistencia;
	}

	private function fncActualizarBD(Inasistencia $inasistencia)
	{
		$sql = cls_control::get_instancia();

		$query = "
		UPDATE escalafon.inasistencia SET
			id_tipo_documento=:id_tipo_documento,
			id_area=:id_area,
			numero_documento=:numero_documento,
			numero_dias=:numero_dias,
			fecha=:fecha,
			archivo=:archivo
		WHERE id_inasistencia = :id_inasistencia
		RETURNING
			id_inasistencia,
			id_trabajador,
			id_tipo_documento,
			id_area,
			numero_documento,
			numero_dias,
			fecha,
			archivo
		";

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_inasistencia", $inasistencia->id_inasistencia);
			$statement->bindParam("id_tipo_documento", $inasistencia->id_tipo_documento);
			$statement->bindParam("id_area", $inasistencia->id_area);
			$statement->bindParam("numero_documento", $inasistencia->numero_documento);
			$statement->bindParam("numero_dias", $inasistencia->numero_dias);
			$statement->bindParam("fecha", $inasistencia->fecha);
			$statement->bindParam("archivo", $inasistencia->archivo);

			$sql->ejecutar();
			$sql->cerrar();

			if($registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$inasistencia->fecha = $registro["fecha"];
			}
			else
			{
				return false;
			}
		}

		return $inasistencia;
	}

	private function fncEliminarBD($id_inasistencia)
	{
		$sql = cls_control::get_instancia();

		$query = "
		UPDATE escalafon.inasistencia SET
			eliminado=1
		WHERE id_inasistencia = :id_inasistencia
		RETURNING
			id_inasistencia
		";

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_inasistencia", $id_inasistencia);

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
