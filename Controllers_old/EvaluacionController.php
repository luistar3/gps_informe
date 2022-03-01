<?php

require_once '../../App/Config/control.php';
require_once '../../App/Public/archivo.php';
require_once '../../App/Public/rutas.php';
require_once '../../App/Escalafon/Controllers/AuditoriaController.php';
require_once '../../App/Escalafon/Models/Evaluacion.php';
require_once '../../App/Escalafon/Models/AuditoriaArchivo.php';

class EvaluacionController extends Evaluacion
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
		$evaluaciones = $this->fncListarBD($id_trabajador);

		foreach ($evaluaciones as $evaluacion)
		{
			$evaluacion = $this->fncObtenerDatosRegistroBD($evaluacion);
		}

		$auditoriaController = new AuditoriaController;
		$auditoria = $auditoriaController->fncGuardar(4, 'evaluacion');

		return $evaluaciones;
	}

	public function fncObtener($id_trabajador, $id_evaluacion)
	{
		if (!$evaluacion = $this->fncObtenerBD($id_trabajador, $id_evaluacion))
		{
			return false;
		}

		$evaluacion = $this->fncObtenerDatosRegistroBD($evaluacion);

		$auditoriaController = new AuditoriaController;
		$auditoria = $auditoriaController->fncGuardar(4, 'evaluacion', 'id_evaluacion', $evaluacion->id_evaluacion);

		return $evaluacion;
	}

	public function fncGuardar($inputs, $files)
	{
		$evaluacion = new Evaluacion;

		$evaluacion->id_trabajador = $inputs->id_trabajador;
		$evaluacion->fecha = isset($inputs->fecha)? $inputs->fecha : null;
		$evaluacion->periodo = isset($inputs->periodo)? $inputs->periodo : null;
		$evaluacion->numero = isset($inputs->numero)? $inputs->numero : null;
		$evaluacion->nombre_evaluador = isset($inputs->nombre_evaluador)? $inputs->nombre_evaluador : null;
		$evaluacion->desempeno_conducta_laboral = isset($inputs->desempeno_conducta_laboral)? $inputs->desempeno_conducta_laboral : null;
		$evaluacion->asistencia = isset($inputs->asistencia)? $inputs->asistencia : null;
		$evaluacion->puntualidad = isset($inputs->puntualidad)? $inputs->puntualidad : null;
		$evaluacion->capacidad = isset($inputs->capacidad)? $inputs->capacidad : null;
		$evaluacion->total = isset($inputs->total)? $inputs->total : null;
		$evaluacion->rango_evaluacion = isset($inputs->rango_evaluacion)? $inputs->rango_evaluacion : null;

		$evaluacion->archivo = null;
		$aud_archivo = null;

		if (isset($files->archivo) && $files->archivo->name != '')
		{
			$ruta =  cls_rutas::get('evaluacionPdf');
			$archivo = new archivo((array) $files->archivo, $ruta, "pdf_", 0, 1);
			if ($archivo->subir())
			{
				$evaluacion->archivo = $ruta.$archivo->get_nombre_archivo();

				$aud_archivo = new AuditoriaArchivo;
				$aud_archivo->setNombre($archivo->get_nombre_archivo());
				$aud_archivo->setNombreOriginal($files->archivo->name);
				$aud_archivo->setRuta($evaluacion->archivo);
				$aud_archivo->setTamano($files->archivo->size);
			}
		}

		if (!$evaluacion = $this->fncGuardarBD($evaluacion))
		{
			return false;
		}

		$auditoriaController = new AuditoriaController;
		$aud_evaluacion = clone $evaluacion;
		$aud_evaluacion->archivo = $aud_archivo;
		$auditoria = $auditoriaController->fncGuardar(1, 'evaluacion', 'id_evaluacion', $aud_evaluacion->id_evaluacion, json_encode($aud_evaluacion));

		$evaluacion->fecha_registro = $auditoria->getFecha();
		$evaluacion->hora_registro = $auditoria->getHora();
		$evaluacion->usuario_registro = $auditoria->getUsuario();

		return $evaluacion;
	}

	public function fncActualizar($inputs, $files)
	{
		if (!$evaluacion = $this->fncObtenerBD($inputs->id_trabajador, $inputs->id_evaluacion))
		{
			return false;
		}

		$evaluacion = $this->fncObtenerDatosRegistroBD($evaluacion);

		$evaluacion->fecha = isset($inputs->fecha)? $inputs->fecha : null;
		$evaluacion->periodo = isset($inputs->periodo)? $inputs->periodo : null;
		$evaluacion->numero = isset($inputs->numero)? $inputs->numero : null;
		$evaluacion->nombre_evaluador = isset($inputs->nombre_evaluador)? $inputs->nombre_evaluador : null;
		$evaluacion->desempeno_conducta_laboral = isset($inputs->desempeno_conducta_laboral)? $inputs->desempeno_conducta_laboral : null;
		$evaluacion->asistencia = isset($inputs->asistencia)? $inputs->asistencia : null;
		$evaluacion->puntualidad = isset($inputs->puntualidad)? $inputs->puntualidad : null;
		$evaluacion->capacidad = isset($inputs->capacidad)? $inputs->capacidad : null;
		$evaluacion->total = isset($inputs->total)? $inputs->total : null;
		$evaluacion->rango_evaluacion = isset($inputs->rango_evaluacion)? $inputs->rango_evaluacion : null;

		$aud_archivo = $evaluacion->archivo;

		if (isset($files->archivo) && $files->archivo->name != '')
		{
			$ruta =  cls_rutas::get('evaluacionPdf');
			$archivo = new archivo((array) $files->archivo, $ruta, "pdf_", 0, 1);
			if ($archivo->subir())
			{
				if(file_exists($evaluacion->archivo)) { unlink($evaluacion->archivo); }

				$evaluacion->archivo = $ruta.$archivo->get_nombre_archivo();

				$aud_archivo = new AuditoriaArchivo;
				$aud_archivo->setNombre($archivo->get_nombre_archivo());
				$aud_archivo->setNombreOriginal($files->archivo->name);
				$aud_archivo->setRuta($evaluacion->archivo);
				$aud_archivo->setTamano($files->archivo->size);
			}
		}

		$evaluacion = $this->fncActualizarBD($evaluacion);


		$auditoriaController = new AuditoriaController;
		$aud_evaluacion = clone $evaluacion;
		$aud_evaluacion->archivo = $aud_archivo;
		$auditoria = $auditoriaController->fncGuardar(2, 'evaluacion', 'id_evaluacion', $aud_evaluacion->id_evaluacion, json_encode($aud_evaluacion));

		return $evaluacion;
	}

	public function fncEliminar($id_trabajador, $id_evaluacion)
	{
		if (!$evaluacion = $this->fncObtenerBD($id_trabajador, $id_evaluacion))
		{
			return false;
		}

		$aud_evaluacion = clone $evaluacion;

		$evaluacion = $this->fncEliminarBD($evaluacion->id_evaluacion);

		if(file_exists($aud_evaluacion->archivo)) { unlink($aud_evaluacion->archivo); }

		$auditoriaController = new AuditoriaController;
		$auditoria = $auditoriaController->fncGuardar(3, 'evaluacion', 'id_evaluacion', $id_evaluacion);

		return $evaluacion;
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
			e.id_evaluacion,
			e.id_trabajador,
			e.fecha,
			e.periodo,
			e.numero,
			e.nombre_evaluador,
			e.desempeno_conducta_laboral,
			e.asistencia,
			e.puntualidad,
			e.capacidad,
			e.total,
			e.rango_evaluacion,
			e.archivo
		FROM escalafon.evaluacion e
		WHERE
			e.id_trabajador = :id_trabajador AND
			e.eliminado = 0
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
				$evaluacion = new Evaluacion;

				$evaluacion->id_evaluacion				= $registro["id_evaluacion"];
				$evaluacion->id_trabajador				= $registro["id_trabajador"];
				$evaluacion->fecha						= $registro["fecha"];
				$evaluacion->periodo					= $registro["periodo"];
				$evaluacion->numero						= $registro["numero"];
				$evaluacion->nombre_evaluador			= $registro["nombre_evaluador"];
				$evaluacion->desempeno_conducta_laboral	= $registro["desempeno_conducta_laboral"];
				$evaluacion->asistencia					= $registro["asistencia"];
				$evaluacion->puntualidad				= $registro["puntualidad"];
				$evaluacion->capacidad					= $registro["capacidad"];
				$evaluacion->total						= $registro["total"];
				$evaluacion->rango_evaluacion			= $registro["rango_evaluacion"];
				$evaluacion->archivo					= $registro["archivo"];

				$data[] = $evaluacion;
			}
		}

		return $data;
	}

	private function fncObtenerBD($id_trabajador, $id_evaluacion)
	{
		$sql = cls_control::get_instancia();

		$query = '
		SELECT
			e.id_evaluacion,
			e.id_trabajador,
			e.fecha,
			e.periodo,
			e.numero,
			e.nombre_evaluador,
			e.desempeno_conducta_laboral,
			e.asistencia,
			e.puntualidad,
			e.capacidad,
			e.total,
			e.rango_evaluacion,
			e.archivo
		FROM escalafon.evaluacion e
		WHERE
			e.id_trabajador = :id_trabajador AND
			e.id_evaluacion = :id_evaluacion AND
			e.eliminado = 0
		';

		$statement = $sql->preparar($query);
		$evaluacion = new Evaluacion;

		if ($statement)
		{
			$statement->bindParam("id_evaluacion", $id_evaluacion);
			$statement->bindParam("id_trabajador", $id_trabajador);

			$sql->ejecutar();
			$sql->cerrar();

			if(!$registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				return false;
			}

			$evaluacion->id_evaluacion				= $registro["id_evaluacion"];
			$evaluacion->id_trabajador				= $registro["id_trabajador"];
			$evaluacion->fecha						= $registro["fecha"];
			$evaluacion->periodo					= $registro["periodo"];
			$evaluacion->numero						= $registro["numero"];
			$evaluacion->nombre_evaluador			= $registro["nombre_evaluador"];
			$evaluacion->desempeno_conducta_laboral	= $registro["desempeno_conducta_laboral"];
			$evaluacion->asistencia					= $registro["asistencia"];
			$evaluacion->puntualidad				= $registro["puntualidad"];
			$evaluacion->capacidad					= $registro["capacidad"];
			$evaluacion->total						= $registro["total"];
			$evaluacion->rango_evaluacion			= $registro["rango_evaluacion"];
			$evaluacion->archivo					= $registro["archivo"];
		}

		return $evaluacion;
	}

	private function fncObtenerDatosRegistroBD(Evaluacion $evaluacion)
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
			a.tabla = \'evaluacion\' AND
			a.objeto_id_valor = :id_evaluacion AND
			a.id_operacion = 1
		';

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_evaluacion", $evaluacion->id_evaluacion);

			$sql->ejecutar();
			$sql->cerrar();

			if($registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$evaluacion->fecha_registro		= $registro["fecha_registro"];
				$evaluacion->hora_registro		= $registro["hora_registro"];
				$evaluacion->usuario_registro	= $registro["usuario_registro"];
			}
		}

		return $evaluacion;
	}

	private function fncGuardarBD(Evaluacion $evaluacion)
	{
		$sql = cls_control::get_instancia();

		$query = '
		INSERT INTO escalafon.evaluacion(
			id_trabajador,
			fecha,
			periodo,
			numero,
			nombre_evaluador,
			desempeno_conducta_laboral,
			asistencia,
			puntualidad,
			capacidad,
			total,
			rango_evaluacion,
			archivo,
			eliminado)
		VALUES (
			:id_trabajador,
			:fecha,
			:periodo,
			:numero,
			:nombre_evaluador,
			:desempeno_conducta_laboral,
			:asistencia,
			:puntualidad,
			:capacidad,
			:total,
			:rango_evaluacion,
			:archivo,
			0
		)
		RETURNING
			id_evaluacion,
			id_trabajador,
			fecha,
			periodo,
			numero,
			nombre_evaluador,
			desempeno_conducta_laboral,
			asistencia,
			puntualidad,
			capacidad,
			total,
			rango_evaluacion,
			archivo
		';

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_trabajador", $evaluacion->id_trabajador);
			$statement->bindParam("fecha", $evaluacion->fecha);
			$statement->bindParam("periodo", $evaluacion->periodo);
			$statement->bindParam("numero", $evaluacion->numero);
			$statement->bindParam("nombre_evaluador", $evaluacion->nombre_evaluador);
			$statement->bindParam("desempeno_conducta_laboral", $evaluacion->desempeno_conducta_laboral);
			$statement->bindParam("asistencia", $evaluacion->asistencia);
			$statement->bindParam("puntualidad", $evaluacion->puntualidad);
			$statement->bindParam("capacidad", $evaluacion->capacidad);
			$statement->bindParam("total", $evaluacion->total);
			$statement->bindParam("rango_evaluacion", $evaluacion->rango_evaluacion);
			$statement->bindParam("archivo", $evaluacion->archivo);

			$sql->ejecutar();
			$sql->cerrar();

			if($registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$evaluacion->id_evaluacion = $registro["id_evaluacion"];
				$evaluacion->fecha = $registro["fecha"];
			}
			else
			{
				return false;
			}
		}

		return $evaluacion;
	}

	private function fncActualizarBD(Evaluacion $evaluacion)
	{
		$sql = cls_control::get_instancia();

		$query = "
		UPDATE escalafon.evaluacion SET
			fecha=:fecha,
			periodo=:periodo,
			numero=:numero,
			nombre_evaluador=:nombre_evaluador,
			desempeno_conducta_laboral=:desempeno_conducta_laboral,
			asistencia=:asistencia,
			puntualidad=:puntualidad,
			capacidad=:capacidad,
			total=:total,
			rango_evaluacion=:rango_evaluacion,
			archivo=:archivo
		WHERE id_evaluacion = :id_evaluacion
		RETURNING
			id_evaluacion,
			id_trabajador,
			fecha,
			periodo,
			numero,
			nombre_evaluador,
			desempeno_conducta_laboral,
			asistencia,
			puntualidad,
			capacidad,
			total,
			rango_evaluacion,
			archivo
		";

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_evaluacion", $evaluacion->id_evaluacion);
			$statement->bindParam("fecha", $evaluacion->fecha);
			$statement->bindParam("periodo", $evaluacion->periodo);
			$statement->bindParam("numero", $evaluacion->numero);
			$statement->bindParam("nombre_evaluador", $evaluacion->nombre_evaluador);
			$statement->bindParam("desempeno_conducta_laboral", $evaluacion->desempeno_conducta_laboral);
			$statement->bindParam("asistencia", $evaluacion->asistencia);
			$statement->bindParam("puntualidad", $evaluacion->puntualidad);
			$statement->bindParam("capacidad", $evaluacion->capacidad);
			$statement->bindParam("total", $evaluacion->total);
			$statement->bindParam("rango_evaluacion", $evaluacion->rango_evaluacion);
			$statement->bindParam("archivo", $evaluacion->archivo);

			$sql->ejecutar();
			$sql->cerrar();

			if($registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$evaluacion->fecha = $registro["fecha"];
			}
			else
			{
				return false;
			}
		}

		return $evaluacion;
	}

	private function fncEliminarBD($id_evaluacion)
	{
		$sql = cls_control::get_instancia();

		$query = "
		UPDATE escalafon.evaluacion SET
			eliminado=1
		WHERE id_evaluacion = :id_evaluacion
		RETURNING
			id_evaluacion
		";

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_evaluacion", $id_evaluacion);

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
