<?php

require_once '../../App/Config/control.php';
require_once '../../App/Escalafon/Controllers/AuditoriaController.php';
require_once '../../App/Escalafon/Models/RemuneracionPersonal.php';

class RemuneracionPersonalController extends RemuneracionPersonal
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
		$remuneraciones = $this->fncListarBD($id_trabajador);

		foreach ($remuneraciones as $remuneracion)
		{
			$remuneracion = $this->fncObtenerDatosRegistroBD($remuneracion);
		}

		$auditoriaController = new AuditoriaController;
		$auditoria = $auditoriaController->fncGuardar(4, 'remuneracion_personal');

		return $remuneraciones;
	}

	public function fncObtener($id_trabajador, $id_remuneracion_personal)
	{
		if (!$remuneracion = $this->fncObtenerBD($id_trabajador, $id_remuneracion_personal))
		{
			return false;
		}

		$remuneracion = $this->fncObtenerDatosRegistroBD($remuneracion);

		$auditoriaController = new AuditoriaController;
		$auditoria = $auditoriaController->fncGuardar(4, 'remuneracion_personal', 'id_remuneracion_personal', $remuneracion->id_remuneracion_personal);

		return $remuneracion;
	}

	public function fncGuardar($inputs)
	{
		$remuneracion = new RemuneracionPersonal;

		$remuneracion->id_trabajador = $inputs->id_trabajador;
		$remuneracion->id_tipo_accion = $inputs->id_tipo_accion;
		$remuneracion->id_tipo_documento = $inputs->id_tipo_documento;
		$remuneracion->numero_documento = isset($inputs->numero_documento)? $inputs->numero_documento : null;
		$remuneracion->fecha_documento = isset($inputs->fecha_documento)? $inputs->fecha_documento : null;
		$remuneracion->se_resuelve = isset($inputs->se_resuelve)? $inputs->se_resuelve : null;
		$remuneracion->expediente_judicial = isset($inputs->expediente_judicial)? $inputs->expediente_judicial : null;

		if (!$remuneracion = $this->fncGuardarBD($remuneracion))
		{
			return false;
		}

		$auditoriaController = new AuditoriaController;
		$auditoria = $auditoriaController->fncGuardar(1, 'remuneracion_personal', 'id_remuneracion_personal', $remuneracion->id_remuneracion_personal, json_encode($remuneracion));

		$remuneracion->fecha_registro = $auditoria->getFecha();
		$remuneracion->hora_registro = $auditoria->getHora();
		$remuneracion->usuario_registro = $auditoria->getUsuario();

		return $remuneracion;
	}

	public function fncActualizar($inputs)
	{
		if (!$remuneracion = $this->fncObtenerBD($inputs->id_trabajador, $inputs->id_remuneracion_personal))
		{
			return false;
		}

		$remuneracion = $this->fncObtenerDatosRegistroBD($remuneracion);

		$remuneracion->id_tipo_accion = $inputs->id_tipo_accion;
		$remuneracion->id_tipo_documento = $inputs->id_tipo_documento;
		$remuneracion->numero_documento = isset($inputs->numero_documento)? $inputs->numero_documento : null;
		$remuneracion->fecha_documento = isset($inputs->fecha_documento)? $inputs->fecha_documento : null;
		$remuneracion->se_resuelve = isset($inputs->se_resuelve)? $inputs->se_resuelve : null;
		$remuneracion->expediente_judicial = isset($inputs->expediente_judicial)? $inputs->expediente_judicial : null;

		$remuneracion = $this->fncActualizarBD($remuneracion);

		$auditoriaController = new AuditoriaController;
		$auditoria = $auditoriaController->fncGuardar(2, 'remuneracion_personal', 'id_remuneracion_personal', $remuneracion->id_remuneracion_personal, json_encode($remuneracion));

		return $remuneracion;
	}

	public function fncEliminar($id_trabajador, $id_remuneracion_personal)
	{
		if (!$remuneracion = $this->fncObtenerBD($id_trabajador, $id_remuneracion_personal))
		{
			return false;
		}

		$remuneracion = $this->fncEliminarBD($remuneracion->id_remuneracion_personal);

		$auditoriaController = new AuditoriaController;
		$auditoria = $auditoriaController->fncGuardar(3, 'remuneracion_personal', 'id_remuneracion_personal', $id_remuneracion_personal);

		return $remuneracion;
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
			rp.id_remuneracion_personal,
			rp.id_trabajador,
			rp.id_tipo_accion,
			rp.id_tipo_documento,
			rp.numero_documento,
			rp.fecha_documento,
			rp.se_resuelve,
			rp.expediente_judicial
		FROM escalafon.remuneracion_personal rp
		WHERE
			rp.id_trabajador = :id_trabajador AND
			rp.eliminado = 0
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
				$remuneracion = new RemuneracionPersonal;

				$remuneracion->id_remuneracion_personal	= $registro["id_remuneracion_personal"];
				$remuneracion->id_trabajador			= $registro["id_trabajador"];
				$remuneracion->id_tipo_accion			= $registro["id_tipo_accion"];
				$remuneracion->id_tipo_documento		= $registro["id_tipo_documento"];
				$remuneracion->numero_documento			= $registro["numero_documento"];
				$remuneracion->fecha_documento			= $registro["fecha_documento"];
				$remuneracion->se_resuelve				= $registro["se_resuelve"];
				$remuneracion->expediente_judicial		= $registro["expediente_judicial"];

				$data[] = $remuneracion;
			}
		}

		return $data;
	}

	private function fncObtenerBD($id_trabajador, $id_remuneracion_personal)
	{
		$sql = cls_control::get_instancia();

		$query = '
		SELECT
			rp.id_remuneracion_personal,
			rp.id_trabajador,
			rp.id_tipo_accion,
			rp.id_tipo_documento,
			rp.numero_documento,
			rp.fecha_documento,
			rp.se_resuelve,
			rp.expediente_judicial
		FROM escalafon.remuneracion_personal rp
		WHERE
			rp.id_trabajador = :id_trabajador AND
			rp.id_remuneracion_personal = :id_remuneracion_personal AND
			rp.eliminado = 0
		';

		$statement = $sql->preparar($query);
		$remuneracion = new RemuneracionPersonal;

		if ($statement)
		{
			$statement->bindParam("id_remuneracion_personal", $id_remuneracion_personal);
			$statement->bindParam("id_trabajador", $id_trabajador);

			$sql->ejecutar();
			$sql->cerrar();

			if(!$registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				return false;
			}

			$remuneracion->id_remuneracion_personal	= $registro["id_remuneracion_personal"];
			$remuneracion->id_trabajador			= $registro["id_trabajador"];
			$remuneracion->id_tipo_accion			= $registro["id_tipo_accion"];
			$remuneracion->id_tipo_documento		= $registro["id_tipo_documento"];
			$remuneracion->numero_documento			= $registro["numero_documento"];
			$remuneracion->fecha_documento			= $registro["fecha_documento"];
			$remuneracion->se_resuelve				= $registro["se_resuelve"];
			$remuneracion->expediente_judicial		= $registro["expediente_judicial"];
		}

		return $remuneracion;
	}

	private function fncObtenerDatosRegistroBD(RemuneracionPersonal $remuneracion)
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
			a.tabla = \'remuneracion_personal\' AND
			a.objeto_id_valor = :id_remuneracion_personal AND
			a.id_operacion = 1
		';

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_remuneracion_personal", $remuneracion->id_remuneracion_personal);

			$sql->ejecutar();
			$sql->cerrar();

			if($registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$remuneracion->fecha_registro			= $registro["fecha_registro"];
				$remuneracion->hora_registro			= $registro["hora_registro"];
				$remuneracion->usuario_registro			= $registro["usuario_registro"];
			}
		}

		return $remuneracion;
	}

	private function fncGuardarBD(RemuneracionPersonal $remuneracion)
	{
		$sql = cls_control::get_instancia();

		$query = '
		INSERT INTO escalafon.remuneracion_personal(
			id_trabajador,
			id_tipo_accion,
			id_tipo_documento,
			numero_documento,
			fecha_documento,
			se_resuelve,
			expediente_judicial,
			eliminado)
		VALUES (
			:id_trabajador,
			:id_tipo_accion,
			:id_tipo_documento,
			:numero_documento,
			:fecha_documento,
			:se_resuelve,
			:expediente_judicial,
			0
		)
		RETURNING
			id_remuneracion_personal,
			id_trabajador,
			id_tipo_accion,
			id_tipo_documento,
			numero_documento,
			fecha_documento,
			se_resuelve,
			expediente_judicial
		';

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_trabajador", $remuneracion->id_trabajador);
			$statement->bindParam("id_tipo_accion", $remuneracion->id_tipo_accion);
			$statement->bindParam("id_tipo_documento", $remuneracion->id_tipo_documento);
			$statement->bindParam("numero_documento", $remuneracion->numero_documento);
			$statement->bindParam("fecha_documento", $remuneracion->fecha_documento);
			$statement->bindParam("se_resuelve", $remuneracion->se_resuelve);
			$statement->bindParam("expediente_judicial", $remuneracion->expediente_judicial);

			$sql->ejecutar();
			$sql->cerrar();

			if($registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$remuneracion->id_remuneracion_personal = $registro["id_remuneracion_personal"];
				$remuneracion->fecha_documento = $registro["fecha_documento"];
			}
			else
			{
				return false;
			}
		}

		return $remuneracion;
	}

	private function fncActualizarBD(RemuneracionPersonal $remuneracion)
	{
		$sql = cls_control::get_instancia();

		$query = "
		UPDATE escalafon.remuneracion_personal SET
			id_tipo_accion=:id_tipo_accion,
			id_tipo_documento=:id_tipo_documento,
			numero_documento=:numero_documento,
			fecha_documento=:fecha_documento,
			se_resuelve=:se_resuelve,
			expediente_judicial=:expediente_judicial
		WHERE id_remuneracion_personal = :id_remuneracion_personal
		RETURNING
			id_remuneracion_personal,
			id_trabajador,
			id_tipo_accion,
			id_tipo_documento,
			numero_documento,
			fecha_documento,
			se_resuelve,
			expediente_judicial
		";

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_remuneracion_personal", $remuneracion->id_remuneracion_personal);
			$statement->bindParam("id_tipo_accion", $remuneracion->id_tipo_accion);
			$statement->bindParam("id_tipo_documento", $remuneracion->id_tipo_documento);
			$statement->bindParam("numero_documento", $remuneracion->numero_documento);
			$statement->bindParam("fecha_documento", $remuneracion->fecha_documento);
			$statement->bindParam("se_resuelve", $remuneracion->se_resuelve);
			$statement->bindParam("expediente_judicial", $remuneracion->expediente_judicial);

			$sql->ejecutar();
			$sql->cerrar();

			if($registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$remuneracion->fecha_documento = $registro["fecha_documento"];
			}
			else
			{
				return false;
			}
		}

		return $remuneracion;
	}

	private function fncEliminarBD($id_remuneracion_personal)
	{
		$sql = cls_control::get_instancia();

		$query = "
		UPDATE escalafon.remuneracion_personal SET
			eliminado=1
		WHERE id_remuneracion_personal = :id_remuneracion_personal
		RETURNING
			id_remuneracion_personal
		";

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_remuneracion_personal", $id_remuneracion_personal);

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