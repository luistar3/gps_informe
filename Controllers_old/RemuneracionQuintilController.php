<?php

require_once '../../App/Config/control.php';
require_once '../../App/Escalafon/Controllers/AuditoriaController.php';
require_once '../../App/Escalafon/Models/RemuneracionQuintil.php';

class RemuneracionQuintilController extends RemuneracionQuintil
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
		$auditoria = $auditoriaController->fncGuardar(4, 'remuneracion_quintil');

		return $remuneraciones;
	}

	public function fncObtener($id_trabajador, $id_remuneracion_quintil)
	{
		if (!$remuneracion = $this->fncObtenerBD($id_trabajador, $id_remuneracion_quintil))
		{
			return false;
		}

		$remuneracion = $this->fncObtenerDatosRegistroBD($remuneracion);

		$auditoriaController = new AuditoriaController;
		$auditoria = $auditoriaController->fncGuardar(4, 'remuneracion_quintil', 'id_remuneracion_quintil', $remuneracion->id_remuneracion_quintil);

		return $remuneracion;
	}

	public function fncGuardar($inputs)
	{
		$remuneracion = new RemuneracionQuintil;

		$remuneracion->id_trabajador = $inputs->id_trabajador;
		$remuneracion->id_tipo_documento = $inputs->id_tipo_documento;
		$remuneracion->numero_documento = isset($inputs->numero_documento)? $inputs->numero_documento : null;
		$remuneracion->fecha_documento = isset($inputs->fecha_documento)? $inputs->fecha_documento : null;
		$remuneracion->porcentaje = isset($inputs->porcentaje)? $inputs->porcentaje : null;
		$remuneracion->fecha_apertura = isset($inputs->fecha_apertura)? $inputs->fecha_apertura : null;
		$remuneracion->fecha_termino = isset($inputs->fecha_termino)? $inputs->fecha_termino : null;
		$remuneracion->fecha_posterior = isset($inputs->fecha_posterior)? $inputs->fecha_posterior : null;
		$remuneracion->informe_quintil = isset($inputs->informe_quintil)? $inputs->informe_quintil : null;
		$remuneracion->fecha_quintil = isset($inputs->fecha_quintil)? $inputs->fecha_quintil : null;

		if (!$remuneracion = $this->fncGuardarBD($remuneracion))
		{
			return false;
		}

		$auditoriaController = new AuditoriaController;
		$auditoria = $auditoriaController->fncGuardar(1, 'remuneracion_quintil', 'id_remuneracion_quintil', $remuneracion->id_remuneracion_quintil, json_encode($remuneracion));

		$remuneracion->fecha_registro = $auditoria->getFecha();
		$remuneracion->hora_registro = $auditoria->getHora();
		$remuneracion->usuario_registro = $auditoria->getUsuario();

		return $remuneracion;
	}

	public function fncActualizar($inputs)
	{
		if (!$remuneracion = $this->fncObtenerBD($inputs->id_trabajador, $inputs->id_remuneracion_quintil))
		{
			return false;
		}

		$remuneracion = $this->fncObtenerDatosRegistroBD($remuneracion);

		$remuneracion->id_tipo_documento = $inputs->id_tipo_documento;
		$remuneracion->numero_documento = isset($inputs->numero_documento)? $inputs->numero_documento : null;
		$remuneracion->fecha_documento = isset($inputs->fecha_documento)? $inputs->fecha_documento : null;
		$remuneracion->porcentaje = isset($inputs->porcentaje)? $inputs->porcentaje : null;
		$remuneracion->fecha_apertura = isset($inputs->fecha_apertura)? $inputs->fecha_apertura : null;
		$remuneracion->fecha_termino = isset($inputs->fecha_termino)? $inputs->fecha_termino : null;
		$remuneracion->fecha_posterior = isset($inputs->fecha_posterior)? $inputs->fecha_posterior : null;
		$remuneracion->informe_quintil = isset($inputs->informe_quintil)? $inputs->informe_quintil : null;
		$remuneracion->fecha_quintil = isset($inputs->fecha_quintil)? $inputs->fecha_quintil : null;

		$remuneracion = $this->fncActualizarBD($remuneracion);

		$auditoriaController = new AuditoriaController;
		$auditoria = $auditoriaController->fncGuardar(2, 'remuneracion_quintil', 'id_remuneracion_quintil', $remuneracion->id_remuneracion_quintil, json_encode($remuneracion));

		return $remuneracion;
	}

	public function fncEliminar($id_trabajador, $id_remuneracion_quintil)
	{
		if (!$remuneracion = $this->fncObtenerBD($id_trabajador, $id_remuneracion_quintil))
		{
			return false;
		}

		$remuneracion = $this->fncEliminarBD($remuneracion->id_remuneracion_quintil);

		$auditoriaController = new AuditoriaController;
		$auditoria = $auditoriaController->fncGuardar(3, 'remuneracion_quintil', 'id_remuneracion_quintil', $id_remuneracion_quintil);

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
			rq.id_remuneracion_quintil,
			rq.id_trabajador,
			rq.id_tipo_documento,
			rq.numero_documento,
			rq.fecha_documento,
			rq.porcentaje,
			rq.fecha_apertura,
			rq.fecha_termino,
			rq.fecha_posterior,
			rq.informe_quintil,
			rq.fecha_quintil
		FROM escalafon.remuneracion_quintil rq
		WHERE
			rq.id_trabajador = :id_trabajador AND
			rq.eliminado = 0
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
				$remuneracion = new RemuneracionQuintil;
				
				$remuneracion->id_remuneracion_quintil	= $registro["id_remuneracion_quintil"];
				$remuneracion->id_trabajador			= $registro["id_trabajador"];
				$remuneracion->id_tipo_documento		= $registro["id_tipo_documento"];
				$remuneracion->numero_documento			= $registro["numero_documento"];
				$remuneracion->fecha_documento			= $registro["fecha_documento"];
				$remuneracion->porcentaje				= $registro["porcentaje"];
				$remuneracion->fecha_apertura			= $registro["fecha_apertura"];
				$remuneracion->fecha_termino			= $registro["fecha_termino"];
				$remuneracion->fecha_posterior			= $registro["fecha_posterior"];
				$remuneracion->informe_quintil			= $registro["informe_quintil"];
				$remuneracion->fecha_quintil			= $registro["fecha_quintil"];

				$data[] = $remuneracion;
			}
		}

		return $data;
	}

	private function fncObtenerBD($id_trabajador, $id_remuneracion_quintil)
	{
		$sql = cls_control::get_instancia();

		$query = '
		SELECT
			rq.id_remuneracion_quintil,
			rq.id_trabajador,
			rq.id_tipo_documento,
			rq.numero_documento,
			rq.fecha_documento,
			rq.porcentaje,
			rq.fecha_apertura,
			rq.fecha_termino,
			rq.fecha_posterior,
			rq.informe_quintil,
			rq.fecha_quintil
		FROM escalafon.remuneracion_quintil rq
		WHERE
			rq.id_trabajador = :id_trabajador AND
			rq.id_remuneracion_quintil = :id_remuneracion_quintil AND
			rq.eliminado = 0
		';

		$statement = $sql->preparar($query);
		$remuneracion = new RemuneracionQuintil;

		if ($statement)
		{
			$statement->bindParam("id_remuneracion_quintil", $id_remuneracion_quintil);
			$statement->bindParam("id_trabajador", $id_trabajador);

			$sql->ejecutar();
			$sql->cerrar();

			if(!$registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				return false;
			}

			$remuneracion->id_remuneracion_quintil	= $registro["id_remuneracion_quintil"];
			$remuneracion->id_trabajador			= $registro["id_trabajador"];
			$remuneracion->id_tipo_documento		= $registro["id_tipo_documento"];
			$remuneracion->numero_documento			= $registro["numero_documento"];
			$remuneracion->fecha_documento			= $registro["fecha_documento"];
			$remuneracion->porcentaje				= $registro["porcentaje"];
			$remuneracion->fecha_apertura			= $registro["fecha_apertura"];
			$remuneracion->fecha_termino			= $registro["fecha_termino"];
			$remuneracion->fecha_posterior			= $registro["fecha_posterior"];
			$remuneracion->informe_quintil			= $registro["informe_quintil"];
			$remuneracion->fecha_quintil			= $registro["fecha_quintil"];
		}

		return $remuneracion;
	}

	private function fncObtenerDatosRegistroBD(RemuneracionQuintil $remuneracion)
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
			a.tabla = \'remuneracion_quintil\' AND
			a.objeto_id_valor = :id_remuneracion_quintil AND
			a.id_operacion = 1
		';

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_remuneracion_quintil", $remuneracion->id_remuneracion_quintil);

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

	private function fncGuardarBD(RemuneracionQuintil $remuneracion)
	{
		$sql = cls_control::get_instancia();

		$query = '
		INSERT INTO escalafon.remuneracion_quintil(
			id_trabajador,
			id_tipo_documento,
			numero_documento,
			fecha_documento,
			porcentaje,
			fecha_apertura,
			fecha_termino,
			fecha_posterior,
			informe_quintil,
			fecha_quintil,
			eliminado)
		VALUES (
			:id_trabajador,
			:id_tipo_documento,
			:numero_documento,
			:fecha_documento,
			:porcentaje,
			:fecha_apertura,
			:fecha_termino,
			:fecha_posterior,
			:informe_quintil,
			:fecha_quintil,
			0
		)
		RETURNING
			id_remuneracion_quintil,
			id_trabajador,
			id_tipo_documento,
			numero_documento,
			fecha_documento,
			porcentaje,
			fecha_apertura,
			fecha_termino,
			fecha_posterior,
			informe_quintil,
			fecha_quintil
		';

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_trabajador", $remuneracion->id_trabajador);
			$statement->bindParam("id_tipo_documento", $remuneracion->id_tipo_documento);
			$statement->bindParam("numero_documento", $remuneracion->numero_documento);
			$statement->bindParam("fecha_documento", $remuneracion->fecha_documento);
			$statement->bindParam("porcentaje", $remuneracion->porcentaje);
			$statement->bindParam("fecha_apertura", $remuneracion->fecha_apertura);
			$statement->bindParam("fecha_termino", $remuneracion->fecha_termino);
			$statement->bindParam("fecha_posterior", $remuneracion->fecha_posterior);
			$statement->bindParam("informe_quintil", $remuneracion->informe_quintil);
			$statement->bindParam("fecha_quintil", $remuneracion->fecha_quintil);

			$sql->ejecutar();
			$sql->cerrar();

			if($registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$remuneracion->id_remuneracion_quintil = $registro["id_remuneracion_quintil"];
				$remuneracion->fecha_documento = $registro["fecha_documento"];
				$remuneracion->fecha_apertura = $registro["fecha_apertura"];
				$remuneracion->fecha_termino = $registro["fecha_termino"];
				$remuneracion->fecha_posterior = $registro["fecha_posterior"];
				$remuneracion->fecha_quintil = $registro["fecha_quintil"];
			}
			else
			{
				return false;
			}
		}

		return $remuneracion;
	}

	private function fncActualizarBD(RemuneracionQuintil $remuneracion)
	{
		$sql = cls_control::get_instancia();

		$query = "
		UPDATE escalafon.remuneracion_quintil SET
			id_tipo_documento=:id_tipo_documento,
			numero_documento=:numero_documento,
			fecha_documento=:fecha_documento,
			porcentaje=:porcentaje,
			fecha_apertura=:fecha_apertura,
			fecha_termino=:fecha_termino,
			fecha_posterior=:fecha_posterior,
			informe_quintil=:informe_quintil,
			fecha_quintil=:fecha_quintil
		WHERE id_remuneracion_quintil = :id_remuneracion_quintil
		RETURNING
			id_remuneracion_quintil,
			id_trabajador,
			id_tipo_documento,
			numero_documento,
			fecha_documento,
			porcentaje,
			fecha_apertura,
			fecha_termino,
			fecha_posterior,
			informe_quintil,
			fecha_quintil
		";

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_remuneracion_quintil", $remuneracion->id_remuneracion_quintil);
			$statement->bindParam("id_tipo_documento", $remuneracion->id_tipo_documento);
			$statement->bindParam("numero_documento", $remuneracion->numero_documento);
			$statement->bindParam("fecha_documento", $remuneracion->fecha_documento);
			$statement->bindParam("porcentaje", $remuneracion->porcentaje);
			$statement->bindParam("fecha_apertura", $remuneracion->fecha_apertura);
			$statement->bindParam("fecha_termino", $remuneracion->fecha_termino);
			$statement->bindParam("fecha_posterior", $remuneracion->fecha_posterior);
			$statement->bindParam("informe_quintil", $remuneracion->informe_quintil);
			$statement->bindParam("fecha_quintil", $remuneracion->fecha_quintil);

			$sql->ejecutar();
			$sql->cerrar();

			if($registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$remuneracion->fecha_documento = $registro["fecha_documento"];
				$remuneracion->fecha_apertura = $registro["fecha_apertura"];
				$remuneracion->fecha_termino = $registro["fecha_termino"];
				$remuneracion->fecha_posterior = $registro["fecha_posterior"];
				$remuneracion->fecha_quintil = $registro["fecha_quintil"];
			}
			else
			{
				return false;
			}
		}

		return $remuneracion;
	}

	private function fncEliminarBD($id_remuneracion_quintil)
	{
		$sql = cls_control::get_instancia();

		$query = "
		UPDATE escalafon.remuneracion_quintil SET
			eliminado=1
		WHERE id_remuneracion_quintil = :id_remuneracion_quintil
		RETURNING
			id_remuneracion_quintil
		";

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_remuneracion_quintil", $id_remuneracion_quintil);

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