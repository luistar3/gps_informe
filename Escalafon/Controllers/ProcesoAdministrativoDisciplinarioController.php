<?php

require_once '../../App/Config/control.php';
require_once '../../App/Public/archivo.php';
require_once '../../App/Public/rutas.php';
require_once '../../App/Escalafon/Controllers/AuditoriaController.php';
require_once '../../App/Escalafon/Models/ProcesoAdministrativoDisciplinario.php';
require_once '../../App/Escalafon/Models/AuditoriaArchivo.php';

class ProcesoAdministrativoDisciplinarioController extends ProcesoAdministrativoDisciplinario
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
		$procesos = $this->fncListarBD($id_trabajador);

		foreach ($procesos as $proceso)
		{
			$proceso = $this->fncObtenerDatosRegistroBD($proceso);
		}

		$auditoriaController = new AuditoriaController;
		$auditoria = $auditoriaController->fncGuardar(4, 'proceso_administrativo_disciplinario');

		return $procesos;
	}

	public function fncObtener($id_trabajador, $id_proceso_administrativo_disciplinario)
	{
		if (!$proceso = $this->fncObtenerBD($id_trabajador, $id_proceso_administrativo_disciplinario))
		{
			return false;
		}

		$proceso = $this->fncObtenerDatosRegistroBD($proceso);

		$auditoriaController = new AuditoriaController;
		$auditoria = $auditoriaController->fncGuardar(4, 'proceso_administrativo_disciplinario', 'id_proceso_administrativo_disciplinario', $proceso->id_proceso_administrativo_disciplinario);

		return $proceso;
	}

	public function fncGuardar($inputs, $files)
	{
		$proceso = new ProcesoAdministrativoDisciplinario;

		$proceso->id_trabajador = $inputs->id_trabajador;
		$proceso->id_tipo_documento = $inputs->id_tipo_documento;
		$proceso->motivo = isset($inputs->motivo)? $inputs->motivo : null;
		$proceso->fecha_comision_hechos = isset($inputs->fecha_comision_hechos)? $inputs->fecha_comision_hechos : null;
		$proceso->fecha_conocimiento_degdrrhh = isset($inputs->fecha_conocimiento_degdrrhh)? $inputs->fecha_conocimiento_degdrrhh : null;
		$proceso->precalificacion = isset($inputs->precalificacion)? $inputs->precalificacion : null;
		$proceso->fecha_precalificacion = isset($inputs->fecha_precalificacion)? $inputs->fecha_precalificacion : null;
		$proceso->inicio = isset($inputs->inicio)? $inputs->inicio : null;
		$proceso->fecha_inicio = isset($inputs->fecha_inicio)? $inputs->fecha_inicio : null;
		$proceso->fin = isset($inputs->fin)? $inputs->fin : null;
		$proceso->fecha_fin = isset($inputs->fecha_fin)? $inputs->fecha_fin : null;
		$proceso->sentencia = isset($inputs->sentencia)? $inputs->sentencia : null;
		$proceso->total_dias_sancion = isset($inputs->total_dias_sancion)? $inputs->total_dias_sancion : null;
		$proceso->estado = isset($inputs->estado)? $inputs->estado : null;

		$proceso->resolucion_administrativa = null;
		$aud_archivo = null;

		if (isset($files->resolucion_administrativa) && $files->resolucion_administrativa->name != '')
		{
			$ruta =  cls_rutas::get('procesoAdministrativoDisciplinarioPdf');
			$archivo = new archivo((array) $files->resolucion_administrativa, $ruta, "pdf_", 0, 1);
			if ($archivo->subir())
			{
				$proceso->resolucion_administrativa = $ruta.$archivo->get_nombre_archivo();

				$aud_archivo = new AuditoriaArchivo;
				$aud_archivo->setNombre($archivo->get_nombre_archivo());
				$aud_archivo->setNombreOriginal($files->resolucion_administrativa->name);
				$aud_archivo->setRuta($proceso->resolucion_administrativa);
				$aud_archivo->setTamano($files->resolucion_administrativa->size);
			}
		}

		if (!$proceso = $this->fncGuardarBD($proceso))
		{
			return false;
		}

		$auditoriaController = new AuditoriaController;
		$aud_proceso = clone $proceso;
		$aud_proceso->resolucion_administrativa = $aud_archivo;
		$auditoria = $auditoriaController->fncGuardar(1, 'proceso_administrativo_disciplinario', 'id_proceso_administrativo_disciplinario', $aud_proceso->id_proceso_administrativo_disciplinario, json_encode($aud_proceso));

		$proceso->fecha_registro = $auditoria->getFecha();
		$proceso->hora_registro = $auditoria->getHora();
		$proceso->usuario_registro = $auditoria->getUsuario();

		return $proceso;
	}

	public function fncActualizar($inputs, $files)
	{
		if (!$proceso = $this->fncObtenerBD($inputs->id_trabajador, $inputs->id_proceso_administrativo_disciplinario))
		{
			return false;
		}

		$proceso = $this->fncObtenerDatosRegistroBD($proceso);

		$proceso->id_tipo_documento = $inputs->id_tipo_documento;
		$proceso->motivo = isset($inputs->motivo)? $inputs->motivo : null;
		$proceso->fecha_comision_hechos = isset($inputs->fecha_comision_hechos)? $inputs->fecha_comision_hechos : null;
		$proceso->fecha_conocimiento_degdrrhh = isset($inputs->fecha_conocimiento_degdrrhh)? $inputs->fecha_conocimiento_degdrrhh : null;
		$proceso->precalificacion = isset($inputs->precalificacion)? $inputs->precalificacion : null;
		$proceso->fecha_precalificacion = isset($inputs->fecha_precalificacion)? $inputs->fecha_precalificacion : null;
		$proceso->inicio = isset($inputs->inicio)? $inputs->inicio : null;
		$proceso->fecha_inicio = isset($inputs->fecha_inicio)? $inputs->fecha_inicio : null;
		$proceso->fin = isset($inputs->fin)? $inputs->fin : null;
		$proceso->fecha_fin = isset($inputs->fecha_fin)? $inputs->fecha_fin : null;
		$proceso->sentencia = isset($inputs->sentencia)? $inputs->sentencia : null;
		$proceso->total_dias_sancion = isset($inputs->total_dias_sancion)? $inputs->total_dias_sancion : null;
		$proceso->estado = isset($inputs->estado)? $inputs->estado : null;

		$aud_archivo = $proceso->resolucion_administrativa;

		if (isset($files->resolucion_administrativa) && $files->resolucion_administrativa->name != '')
		{
			$ruta =  cls_rutas::get('procesoAdministrativoDisciplinarioPdf');
			$archivo = new archivo((array) $files->resolucion_administrativa, $ruta, "pdf_", 0, 1);
			if ($archivo->subir())
			{
				if(file_exists($proceso->resolucion_administrativa)) { unlink($proceso->resolucion_administrativa); }

				$proceso->resolucion_administrativa = $ruta.$archivo->get_nombre_archivo();

				$aud_archivo = new AuditoriaArchivo;
				$aud_archivo->setNombre($archivo->get_nombre_archivo());
				$aud_archivo->setNombreOriginal($files->resolucion_administrativa->name);
				$aud_archivo->setRuta($proceso->resolucion_administrativa);
				$aud_archivo->setTamano($files->resolucion_administrativa->size);
			}
		}

		$proceso = $this->fncActualizarBD($proceso);


		$auditoriaController = new AuditoriaController;
		$aud_proceso = clone $proceso;
		$aud_proceso->resolucion_administrativa = $aud_archivo;
		$auditoria = $auditoriaController->fncGuardar(2, 'proceso_administrativo_disciplinario', 'id_proceso_administrativo_disciplinario', $aud_proceso->id_proceso_administrativo_disciplinario, json_encode($aud_proceso));

		return $proceso;
	}

	public function fncEliminar($id_trabajador, $id_proceso_administrativo_disciplinario)
	{
		if (!$proceso = $this->fncObtenerBD($id_trabajador, $id_proceso_administrativo_disciplinario))
		{
			return false;
		}

		$aud_proceso = clone $proceso;

		$proceso = $this->fncEliminarBD($proceso->id_proceso_administrativo_disciplinario);

		if(file_exists($aud_proceso->resolucion_administrativa)) { unlink($aud_proceso->resolucion_administrativa); }

		$auditoriaController = new AuditoriaController;
		$auditoria = $auditoriaController->fncGuardar(3, 'proceso_administrativo_disciplinario', 'id_proceso_administrativo_disciplinario', $id_proceso_administrativo_disciplinario);

		return $proceso;
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
			pad.id_proceso_administrativo_disciplinario,
			pad.id_trabajador,
			pad.id_tipo_documento,
			pad.motivo,
			pad.fecha_comision_hechos,
			pad.fecha_conocimiento_degdrrhh,
			pad.precalificacion,
			pad.fecha_precalificacion,
			pad.inicio,
			pad.fecha_inicio,
			pad.fin,
			pad.fecha_fin,
			pad.resolucion_administrativa,
			pad.sentencia,
			pad.total_dias_sancion,
			pad.estado
		FROM escalafon.proceso_administrativo_disciplinario pad
		WHERE
			pad.id_trabajador = :id_trabajador AND
			pad.eliminado = 0
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
				$proceso = new ProcesoAdministrativoDisciplinario;

				$proceso->id_proceso_administrativo_disciplinario	= $registro["id_proceso_administrativo_disciplinario"];
				$proceso->id_trabajador								= $registro["id_trabajador"];
				$proceso->id_tipo_documento							= $registro["id_tipo_documento"];
				$proceso->motivo									= $registro["motivo"];
				$proceso->fecha_comision_hechos						= $registro["fecha_comision_hechos"];
				$proceso->fecha_conocimiento_degdrrhh				= $registro["fecha_conocimiento_degdrrhh"];
				$proceso->precalificacion							= $registro["precalificacion"];
				$proceso->fecha_precalificacion						= $registro["fecha_precalificacion"];
				$proceso->inicio									= $registro["inicio"];
				$proceso->fecha_inicio								= $registro["fecha_inicio"];
				$proceso->fin										= $registro["fin"];
				$proceso->fecha_fin									= $registro["fecha_fin"];
				$proceso->resolucion_administrativa					= $registro["resolucion_administrativa"];
				$proceso->sentencia									= $registro["sentencia"];
				$proceso->total_dias_sancion						= $registro["total_dias_sancion"];
				$proceso->estado									= $registro["estado"];

				$data[] = $proceso;
			}
		}

		return $data;
	}

	private function fncObtenerBD($id_trabajador, $id_proceso_administrativo_disciplinario)
	{
		$sql = cls_control::get_instancia();

		$query = '
		SELECT
			pad.id_proceso_administrativo_disciplinario,
			pad.id_trabajador,
			pad.id_tipo_documento,
			pad.motivo,
			pad.fecha_comision_hechos,
			pad.fecha_conocimiento_degdrrhh,
			pad.precalificacion,
			pad.fecha_precalificacion,
			pad.inicio,
			pad.fecha_inicio,
			pad.fin,
			pad.fecha_fin,
			pad.resolucion_administrativa,
			pad.sentencia,
			pad.total_dias_sancion,
			pad.estado
		FROM escalafon.proceso_administrativo_disciplinario pad
		WHERE
			pad.id_trabajador = :id_trabajador AND
			pad.id_proceso_administrativo_disciplinario = :id_proceso_administrativo_disciplinario AND
			pad.eliminado = 0
		';

		$statement = $sql->preparar($query);
		$proceso = new ProcesoAdministrativoDisciplinario;

		if ($statement)
		{
			$statement->bindParam("id_proceso_administrativo_disciplinario", $id_proceso_administrativo_disciplinario);
			$statement->bindParam("id_trabajador", $id_trabajador);

			$sql->ejecutar();
			$sql->cerrar();

			if(!$registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				return false;
			}
			$proceso->id_proceso_administrativo_disciplinario	= $registro["id_proceso_administrativo_disciplinario"];
			$proceso->id_trabajador								= $registro["id_trabajador"];
			$proceso->id_tipo_documento							= $registro["id_tipo_documento"];
			$proceso->motivo									= $registro["motivo"];
			$proceso->fecha_comision_hechos						= $registro["fecha_comision_hechos"];
			$proceso->fecha_conocimiento_degdrrhh				= $registro["fecha_conocimiento_degdrrhh"];
			$proceso->precalificacion							= $registro["precalificacion"];
			$proceso->fecha_precalificacion						= $registro["fecha_precalificacion"];
			$proceso->inicio									= $registro["inicio"];
			$proceso->fecha_inicio								= $registro["fecha_inicio"];
			$proceso->fin										= $registro["fin"];
			$proceso->fecha_fin									= $registro["fecha_fin"];
			$proceso->resolucion_administrativa					= $registro["resolucion_administrativa"];
			$proceso->sentencia									= $registro["sentencia"];
			$proceso->total_dias_sancion						= $registro["total_dias_sancion"];
			$proceso->estado									= $registro["estado"];
		}

		return $proceso;
	}

	private function fncObtenerDatosRegistroBD(ProcesoAdministrativoDisciplinario $proceso)
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
			a.tabla = \'proceso_administrativo_disciplinario\' AND
			a.objeto_id_valor = :id_proceso_administrativo_disciplinario AND
			a.id_operacion = 1
		';

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_proceso_administrativo_disciplinario", $proceso->id_proceso_administrativo_disciplinario);

			$sql->ejecutar();
			$sql->cerrar();

			if($registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$proceso->fecha_registro		= $registro["fecha_registro"];
				$proceso->hora_registro		= $registro["hora_registro"];
				$proceso->usuario_registro	= $registro["usuario_registro"];
			}
		}

		return $proceso;
	}

	private function fncGuardarBD(ProcesoAdministrativoDisciplinario $proceso)
	{
		$sql = cls_control::get_instancia();

		$query = '
		INSERT INTO escalafon.proceso_administrativo_disciplinario(
			id_trabajador,
			id_tipo_documento,
			motivo,
			fecha_comision_hechos,
			fecha_conocimiento_degdrrhh,
			precalificacion,
			fecha_precalificacion,
			inicio,
			fecha_inicio,
			fin,
			fecha_fin,
			resolucion_administrativa,
			sentencia,
			total_dias_sancion,
			estado,
			eliminado)
		VALUES (
			:id_trabajador,
			:id_tipo_documento,
			:motivo,
			:fecha_comision_hechos,
			:fecha_conocimiento_degdrrhh,
			:precalificacion,
			:fecha_precalificacion,
			:inicio,
			:fecha_inicio,
			:fin,
			:fecha_fin,
			:resolucion_administrativa,
			:sentencia,
			:total_dias_sancion,
			:estado,
			0
		)
		RETURNING
			id_proceso_administrativo_disciplinario,
			id_trabajador,
			id_tipo_documento,
			motivo,
			fecha_comision_hechos,
			fecha_conocimiento_degdrrhh,
			precalificacion,
			fecha_precalificacion,
			inicio,
			fecha_inicio,
			fin,
			fecha_fin,
			resolucion_administrativa,
			sentencia,
			total_dias_sancion,
			estado
		';

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_trabajador", $proceso->id_trabajador);
			$statement->bindParam("id_tipo_documento", $proceso->id_tipo_documento);
			$statement->bindParam("motivo", $proceso->motivo);
			$statement->bindParam("fecha_comision_hechos", $proceso->fecha_comision_hechos);
			$statement->bindParam("fecha_conocimiento_degdrrhh", $proceso->fecha_conocimiento_degdrrhh);
			$statement->bindParam("precalificacion", $proceso->precalificacion);
			$statement->bindParam("fecha_precalificacion", $proceso->fecha_precalificacion);
			$statement->bindParam("inicio", $proceso->inicio);
			$statement->bindParam("fecha_inicio", $proceso->fecha_inicio);
			$statement->bindParam("fin", $proceso->fin);
			$statement->bindParam("fecha_fin", $proceso->fecha_fin);
			$statement->bindParam("resolucion_administrativa", $proceso->resolucion_administrativa);
			$statement->bindParam("sentencia", $proceso->sentencia);
			$statement->bindParam("total_dias_sancion", $proceso->total_dias_sancion);
			$statement->bindParam("estado", $proceso->estado);

			$sql->ejecutar();
			$sql->cerrar();

			if($registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$proceso->id_proceso_administrativo_disciplinario = $registro["id_proceso_administrativo_disciplinario"];
				$proceso->fecha_comision_hechos = $registro["fecha_comision_hechos"];
				$proceso->fecha_conocimiento_degdrrhh = $registro["fecha_conocimiento_degdrrhh"];
				$proceso->fecha_precalificacion = $registro["fecha_precalificacion"];
				$proceso->fecha_inicio = $registro["fecha_inicio"];
				$proceso->fecha_fin = $registro["fecha_fin"];
			}
			else
			{
				return false;
			}
		}

		return $proceso;
	}

	private function fncActualizarBD(ProcesoAdministrativoDisciplinario $proceso)
	{
		$sql = cls_control::get_instancia();

		$query = "
		UPDATE escalafon.proceso_administrativo_disciplinario SET
			id_tipo_documento=:id_tipo_documento,
			motivo=:motivo,
			fecha_comision_hechos=:fecha_comision_hechos,
			fecha_conocimiento_degdrrhh=:fecha_conocimiento_degdrrhh,
			precalificacion=:precalificacion,
			fecha_precalificacion=:fecha_precalificacion,
			inicio=:inicio,
			fecha_inicio=:fecha_inicio,
			fin=:fin,
			fecha_fin=:fecha_fin,
			resolucion_administrativa=:resolucion_administrativa,
			sentencia=:sentencia,
			total_dias_sancion=:total_dias_sancion,
			estado=:estado
		WHERE id_proceso_administrativo_disciplinario = :id_proceso_administrativo_disciplinario
		RETURNING
			id_proceso_administrativo_disciplinario,
			id_trabajador,
			id_tipo_documento,
			motivo,
			fecha_comision_hechos,
			fecha_conocimiento_degdrrhh,
			precalificacion,
			fecha_precalificacion,
			inicio,
			fecha_inicio,
			fin,
			fecha_fin,
			resolucion_administrativa,
			sentencia,
			total_dias_sancion,
			estado
		";

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_proceso_administrativo_disciplinario", $proceso->id_proceso_administrativo_disciplinario);
			$statement->bindParam("id_tipo_documento", $proceso->id_tipo_documento);
			$statement->bindParam("motivo", $proceso->motivo);
			$statement->bindParam("fecha_comision_hechos", $proceso->fecha_comision_hechos);
			$statement->bindParam("fecha_conocimiento_degdrrhh", $proceso->fecha_conocimiento_degdrrhh);
			$statement->bindParam("precalificacion", $proceso->precalificacion);
			$statement->bindParam("fecha_precalificacion", $proceso->fecha_precalificacion);
			$statement->bindParam("inicio", $proceso->inicio);
			$statement->bindParam("fecha_inicio", $proceso->fecha_inicio);
			$statement->bindParam("fin", $proceso->fin);
			$statement->bindParam("fecha_fin", $proceso->fecha_fin);
			$statement->bindParam("resolucion_administrativa", $proceso->resolucion_administrativa);
			$statement->bindParam("sentencia", $proceso->sentencia);
			$statement->bindParam("total_dias_sancion", $proceso->total_dias_sancion);
			$statement->bindParam("estado", $proceso->estado);

			$sql->ejecutar();
			$sql->cerrar();

			if($registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$proceso->fecha_comision_hechos = $registro["fecha_comision_hechos"];
				$proceso->fecha_conocimiento_degdrrhh = $registro["fecha_conocimiento_degdrrhh"];
				$proceso->fecha_precalificacion = $registro["fecha_precalificacion"];
				$proceso->fecha_inicio = $registro["fecha_inicio"];
				$proceso->fecha_fin = $registro["fecha_fin"];
			}
			else
			{
				return false;
			}
		}

		return $proceso;
	}

	private function fncEliminarBD($id_proceso_administrativo_disciplinario)
	{
		$sql = cls_control::get_instancia();

		$query = "
		UPDATE escalafon.proceso_administrativo_disciplinario SET
			eliminado=1
		WHERE id_proceso_administrativo_disciplinario = :id_proceso_administrativo_disciplinario
		RETURNING
			id_proceso_administrativo_disciplinario
		";

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_proceso_administrativo_disciplinario", $id_proceso_administrativo_disciplinario);

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
