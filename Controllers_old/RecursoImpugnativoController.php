<?php

require_once '../../App/Config/control.php';
require_once '../../App/Public/archivo.php';
require_once '../../App/Public/rutas.php';
require_once '../../App/Escalafon/Controllers/AuditoriaController.php';
require_once '../../App/Escalafon/Models/RecursoImpugnativo.php';
require_once '../../App/Escalafon/Models/AuditoriaArchivo.php';

class RecursoImpugnativoController extends RecursoImpugnativo
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

	public function fncListar($id_proceso_administrativo_disciplinario)
	{
		$recursos = $this->fncListarBD($id_proceso_administrativo_disciplinario);

		foreach ($recursos as $recurso)
		{
			$recurso = $this->fncObtenerDatosRegistroBD($recurso);
		}

		$auditoriaController = new AuditoriaController;
		$auditoria = $auditoriaController->fncGuardar(4, 'recurso_impugnativo');

		return $recursos;
	}

	public function fncObtener($id_proceso_administrativo_disciplinario, $id_recurso_impugnativo)
	{
		if (!$recurso = $this->fncObtenerBD($id_proceso_administrativo_disciplinario, $id_recurso_impugnativo))
		{
			return false;
		}

		$recurso = $this->fncObtenerDatosRegistroBD($recurso);

		$auditoriaController = new AuditoriaController;
		$auditoria = $auditoriaController->fncGuardar(4, 'recurso_impugnativo', 'id_recurso_impugnativo', $recurso->id_recurso_impugnativo);

		return $recurso;
	}

	public function fncGuardar($inputs, $files)
	{
		$recurso = new RecursoImpugnativo;

		$recurso->id_proceso_administrativo_disciplinario = $inputs->id_proceso_administrativo_disciplinario;
		$recurso->id_tipo_recurso_impugnativo = $inputs->id_tipo_recurso_impugnativo;
		$recurso->documento = isset($inputs->documento)? $inputs->documento : null;
		$recurso->fecha_documento = isset($inputs->fecha_documento)? $inputs->fecha_documento : null;
		$recurso->detalle = isset($inputs->detalle)? $inputs->detalle : null;

		$recurso->archivo = null;
		$aud_archivo = null;

		if (isset($files->archivo) && $files->archivo->name != '')
		{
			$ruta =  cls_rutas::get('recursoImpugnativoPdf');
			$archivo = new archivo((array) $files->archivo, $ruta, "pdf_", 0, 1);
			if ($archivo->subir())
			{
				$recurso->archivo = $ruta.$archivo->get_nombre_archivo();

				$aud_archivo = new AuditoriaArchivo;
				$aud_archivo->setNombre($archivo->get_nombre_archivo());
				$aud_archivo->setNombreOriginal($files->archivo->name);
				$aud_archivo->setRuta($recurso->archivo);
				$aud_archivo->setTamano($files->archivo->size);
			}
		}

		if (!$recurso = $this->fncGuardarBD($recurso))
		{
			return false;
		}

		$auditoriaController = new AuditoriaController;
		$aud_recurso = clone $recurso;
		$aud_recurso->archivo = $aud_archivo;
		$auditoria = $auditoriaController->fncGuardar(1, 'recurso_impugnativo', 'id_recurso_impugnativo', $aud_recurso->id_recurso_impugnativo, json_encode($aud_recurso));

		$recurso->fecha_registro = $auditoria->getFecha();
		$recurso->hora_registro = $auditoria->getHora();
		$recurso->usuario_registro = $auditoria->getUsuario();

		return $recurso;
	}

	public function fncActualizar($inputs, $files)
	{
		if (!$recurso = $this->fncObtenerBD($inputs->id_proceso_administrativo_disciplinario, $inputs->id_recurso_impugnativo))
		{
			return false;
		}

		$recurso = $this->fncObtenerDatosRegistroBD($recurso);

		$recurso->id_tipo_recurso_impugnativo = $inputs->id_tipo_recurso_impugnativo;
		$recurso->documento = isset($inputs->documento)? $inputs->documento : null;
		$recurso->fecha_documento = isset($inputs->fecha_documento)? $inputs->fecha_documento : null;
		$recurso->detalle = isset($inputs->detalle)? $inputs->detalle : null;

		$aud_archivo = $recurso->archivo;

		if (isset($files->archivo) && $files->archivo->name != '')
		{
			$ruta =  cls_rutas::get('recursoImpugnativoPdf');
			$archivo = new archivo((array) $files->archivo, $ruta, "pdf_", 0, 1);
			if ($archivo->subir())
			{
				if(file_exists($recurso->archivo)) { unlink($recurso->archivo); }

				$recurso->archivo = $ruta.$archivo->get_nombre_archivo();

				$aud_archivo = new AuditoriaArchivo;
				$aud_archivo->setNombre($archivo->get_nombre_archivo());
				$aud_archivo->setNombreOriginal($files->archivo->name);
				$aud_archivo->setRuta($recurso->archivo);
				$aud_archivo->setTamano($files->archivo->size);
			}
		}

		$recurso = $this->fncActualizarBD($recurso);


		$auditoriaController = new AuditoriaController;
		$aud_recurso = clone $recurso;
		$aud_recurso->archivo = $aud_archivo;
		$auditoria = $auditoriaController->fncGuardar(2, 'recurso_impugnativo', 'id_recurso_impugnativo', $aud_recurso->id_recurso_impugnativo, json_encode($aud_recurso));

		return $recurso;
	}

	public function fncEliminar($id_proceso_administrativo_disciplinario, $id_recurso_impugnativo)
	{
		if (!$recurso = $this->fncObtenerBD($id_proceso_administrativo_disciplinario, $id_recurso_impugnativo))
		{
			return false;
		}

		$aud_recurso = clone $recurso;

		$recurso = $this->fncEliminarBD($recurso->id_recurso_impugnativo);

		if(file_exists($aud_recurso->archivo)) { unlink($aud_recurso->archivo); }

		$auditoriaController = new AuditoriaController;
		$auditoria = $auditoriaController->fncGuardar(3, 'recurso_impugnativo', 'id_recurso_impugnativo', $id_recurso_impugnativo);

		return $recurso;
	}

	/*
	|--------------------------------------------------------------------------
	| Funciones de consulta a la base de datos
	|--------------------------------------------------------------------------
	*/

	private function fncListarBD($id_proceso_administrativo_disciplinario)
	{
		$sql = cls_control::get_instancia();

		$query = '
		SELECT
			ri.id_recurso_impugnativo,
			ri.id_proceso_administrativo_disciplinario,
			ri.id_tipo_recurso_impugnativo,
			ri.documento,
			ri.fecha_documento,
			ri.archivo,
			ri.detalle
		FROM escalafon.recurso_impugnativo ri
		WHERE
			ri.id_proceso_administrativo_disciplinario = :id_proceso_administrativo_disciplinario AND
			ri.eliminado = 0
		';

		$statement = $sql->preparar($query);
		$data = [];

		if ($statement)
		{
			$statement->bindParam("id_proceso_administrativo_disciplinario", $id_proceso_administrativo_disciplinario);

			$sql->ejecutar();
			$sql->cerrar();

			while($registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$recurso = new RecursoImpugnativo;

				$recurso->id_recurso_impugnativo					= $registro["id_recurso_impugnativo"];
				$recurso->id_proceso_administrativo_disciplinario	= $registro["id_proceso_administrativo_disciplinario"];
				$recurso->id_tipo_recurso_impugnativo				= $registro["id_tipo_recurso_impugnativo"];
				$recurso->documento									= $registro["documento"];
				$recurso->fecha_documento							= $registro["fecha_documento"];
				$recurso->archivo									= $registro["archivo"];
				$recurso->detalle									= $registro["detalle"];

				$data[] = $recurso;
			}
		}

		return $data;
	}

	private function fncObtenerBD($id_proceso_administrativo_disciplinario, $id_recurso_impugnativo)
	{
		$sql = cls_control::get_instancia();

		$query = '
		SELECT
			ri.id_recurso_impugnativo,
			ri.id_proceso_administrativo_disciplinario,
			ri.id_tipo_recurso_impugnativo,
			ri.documento,
			ri.fecha_documento,
			ri.archivo,
			ri.detalle
		FROM escalafon.recurso_impugnativo ri
		WHERE
			ri.id_proceso_administrativo_disciplinario = :id_proceso_administrativo_disciplinario AND
			ri.id_recurso_impugnativo = :id_recurso_impugnativo AND
			ri.eliminado = 0
		';

		$statement = $sql->preparar($query);
		$recurso = new RecursoImpugnativo;

		if ($statement)
		{
			$statement->bindParam("id_recurso_impugnativo", $id_recurso_impugnativo);
			$statement->bindParam("id_proceso_administrativo_disciplinario", $id_proceso_administrativo_disciplinario);

			$sql->ejecutar();
			$sql->cerrar();

			if(!$registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				return false;
			}

			$recurso->id_recurso_impugnativo					= $registro["id_recurso_impugnativo"];
			$recurso->id_proceso_administrativo_disciplinario	= $registro["id_proceso_administrativo_disciplinario"];
			$recurso->id_tipo_recurso_impugnativo				= $registro["id_tipo_recurso_impugnativo"];
			$recurso->documento									= $registro["documento"];
			$recurso->fecha_documento							= $registro["fecha_documento"];
			$recurso->archivo									= $registro["archivo"];
			$recurso->detalle									= $registro["detalle"];
		}

		return $recurso;
	}

	private function fncObtenerDatosRegistroBD(RecursoImpugnativo $recurso)
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
			a.tabla = \'recurso_impugnativo\' AND
			a.objeto_id_valor = :id_recurso_impugnativo AND
			a.id_operacion = 1
		';

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_recurso_impugnativo", $recurso->id_recurso_impugnativo);

			$sql->ejecutar();
			$sql->cerrar();

			if($registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$recurso->fecha_registro	= $registro["fecha_registro"];
				$recurso->hora_registro		= $registro["hora_registro"];
				$recurso->usuario_registro	= $registro["usuario_registro"];
			}
		}

		return $recurso;
	}

	private function fncGuardarBD(RecursoImpugnativo $recurso)
	{
		$sql = cls_control::get_instancia();

		$query = '
		INSERT INTO escalafon.recurso_impugnativo(
			id_proceso_administrativo_disciplinario,
			id_tipo_recurso_impugnativo,
			documento,
			fecha_documento,
			archivo,
			detalle,
			eliminado)
		VALUES (
			:id_proceso_administrativo_disciplinario,
			:id_tipo_recurso_impugnativo,
			:documento,
			:fecha_documento,
			:archivo,
			:detalle,
			0
		)
		RETURNING
			id_recurso_impugnativo,
			id_proceso_administrativo_disciplinario,
			id_tipo_recurso_impugnativo,
			documento,
			fecha_documento,
			archivo,
			detalle
		';

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_proceso_administrativo_disciplinario", $recurso->id_proceso_administrativo_disciplinario);
			$statement->bindParam("id_tipo_recurso_impugnativo", $recurso->id_tipo_recurso_impugnativo);
			$statement->bindParam("documento", $recurso->documento);
			$statement->bindParam("fecha_documento", $recurso->fecha_documento);
			$statement->bindParam("archivo", $recurso->archivo);
			$statement->bindParam("detalle", $recurso->detalle);

			$sql->ejecutar();
			$sql->cerrar();

			if($registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$recurso->id_recurso_impugnativo = $registro["id_recurso_impugnativo"];
				$recurso->fecha_documento = $registro["fecha_documento"];
			}
			else
			{
				return false;
			}
		}

		return $recurso;
	}

	private function fncActualizarBD(RecursoImpugnativo $recurso)
	{
		$sql = cls_control::get_instancia();

		$query = "
		UPDATE escalafon.recurso_impugnativo SET
			id_tipo_recurso_impugnativo=:id_tipo_recurso_impugnativo,
			documento=:documento,
			fecha_documento=:fecha_documento,
			archivo=:archivo,
			detalle=:detalle
		WHERE id_recurso_impugnativo = :id_recurso_impugnativo
		RETURNING
			id_recurso_impugnativo,
			id_proceso_administrativo_disciplinario,
			id_tipo_recurso_impugnativo,
			documento,
			fecha_documento,
			archivo,
			detalle
		";

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_recurso_impugnativo", $recurso->id_recurso_impugnativo);
			$statement->bindParam("id_tipo_recurso_impugnativo", $recurso->id_tipo_recurso_impugnativo);
			$statement->bindParam("documento", $recurso->documento);
			$statement->bindParam("fecha_documento", $recurso->fecha_documento);
			$statement->bindParam("archivo", $recurso->archivo);
			$statement->bindParam("detalle", $recurso->detalle);

			$sql->ejecutar();
			$sql->cerrar();

			if($registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$recurso->fecha_documento = $registro["fecha_documento"];
			}
			else
			{
				return false;
			}
		}

		return $recurso;
	}

	private function fncEliminarBD($id_recurso_impugnativo)
	{
		$sql = cls_control::get_instancia();

		$query = "
		UPDATE escalafon.recurso_impugnativo SET
			eliminado=1
		WHERE id_recurso_impugnativo = :id_recurso_impugnativo
		RETURNING
			id_recurso_impugnativo
		";

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_recurso_impugnativo", $id_recurso_impugnativo);

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
