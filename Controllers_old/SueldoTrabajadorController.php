<?php

require_once '../../App/Config/control.php';
require_once '../../App/Escalafon/Controllers/AuditoriaController.php';
require_once '../../App/Escalafon/Models/SueldoTrabajador.php';

class SueldoTrabajadorController extends SueldoTrabajador
{
	private $auditoriaController;

	public function __construct()
	{
		date_default_timezone_set('America/Lima');

		$this->auditoriaController = new AuditoriaController;
	}

	/*
	|--------------------------------------------------------------------------
	| Funciones de lógica
	|--------------------------------------------------------------------------
	*/

	public function fncListar($id_trabajador)
	{
		$sueldos = $this->fncListarBD($id_trabajador);

		foreach ($sueldos as $sueldo)
		{
			$sueldo = $this->fncObtenerDatosRegistroBD($sueldo);
		}

		$auditoria = $this->auditoriaController->fncGuardar(4, 'sueldo_trabajador');

		return $sueldos;
	}

	public function fncObtener($id_trabajador, $id_sueldo)
	{
		if (!$sueldo = $this->fncObtenerBD($id_sueldo, $id_trabajador)) { return false; }

		$sueldo = $this->fncObtenerDatosRegistroBD($sueldo);

		$auditoria = $this->auditoriaController->fncGuardar(4, 'sueldo_trabajador', 'id_sueldo', $sueldo->id_sueldo);

		return $sueldo;
	}

	public function fncObtenerActual($id_trabajador)
	{
		if (!$sueldo = $this->fncObtenerActualBD($id_trabajador)) { return false; }

		$sueldo = $this->fncObtenerDatosRegistroBD($sueldo);

		$auditoria = $this->auditoriaController->fncGuardar(4, 'sueldo_trabajador', 'id_sueldo', $sueldo->id_sueldo);

		return $sueldo;
	}

	public function fncGuardar($inputs)
	{
		$sueldo = new SueldoTrabajador;

		$sueldo->id_trabajador = $inputs->id_trabajador;
		$sueldo->sueldo = $inputs->sueldo;
		$sueldo->actual = 1;

		$this->fncDesactivarSueldosBD($inputs->id_trabajador);

		if (!$sueldo = $this->fncGuardarBD($sueldo)) { return false; }

		$auditoria = $this->auditoriaController->fncGuardar(1, 'sueldo_trabajador', 'id_sueldo', $sueldo->id_sueldo, json_encode($sueldo));

		$sueldo->fecha_registro = $auditoria->getFecha();
		$sueldo->hora_registro = $auditoria->getHora();
		$sueldo->usuario_registro = $auditoria->getUsuario();

		return $sueldo;
	}

	public function fncActualizar($inputs)
	{
		if (!$sueldo = $this->fncObtenerBD($inputs->id_sueldo, $inputs->id_trabajador)) { return false; }

		$sueldo->sueldo = $inputs->sueldo;
		$sueldo->actual = 1;

		$this->fncDesactivarSueldosBD($inputs->id_trabajador);

		if (!$sueldo = $this->fncActualizarBD($sueldo)) { return false; }

		$auditoria = $this->auditoriaController->fncGuardar(2, 'sueldo_trabajador', 'id_sueldo', $sueldo->id_sueldo, json_encode($sueldo));

		$sueldo = $this->fncObtenerDatosRegistroBD($sueldo);

		return $sueldo;
	}

	public function fncEliminar($id_sueldo)
	{
		if (!$sueldo = $this->fncObtenerBD($id_sueldo)) { return false; }

		if ($sueldo->actual == 1) { return 1; }

		$sueldo = $this->fncEliminarBD($sueldo->id_sueldo);

		$auditoria = $this->auditoriaController->fncGuardar(3, 'sueldo_trabajador', 'id_sueldo', $id_sueldo);

		return $sueldo;
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
			st.id_sueldo,
			st.id_trabajador,
			st.sueldo,
			st.actual,
			st.fecha_creacion
		FROM escalafon.sueldo_trabajador st
		WHERE
			st.id_trabajador = :id_trabajador
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
				$sueldo = new SueldoTrabajador;

				$sueldo->id_sueldo		= $registro["id_sueldo"];
				$sueldo->id_trabajador	= $registro["id_trabajador"];
				$sueldo->sueldo			= $registro["sueldo"];
				$sueldo->actual			= $registro["actual"];
				$sueldo->fecha_creacion	= $registro["fecha_creacion"];

				$data[] = $sueldo;
			}
		}

		return $data;
	}

	private function fncObtenerBD($id_sueldo, $id_trabajador = -1)
	{
		$sql = cls_control::get_instancia();

		$query = '
		SELECT
			st.id_sueldo,
			st.id_trabajador,
			st.sueldo,
			st.actual,
			st.fecha_creacion
		FROM escalafon.sueldo_trabajador st
		WHERE
			(st.id_trabajador = :id_trabajador OR :id_trabajador = -1) AND
			st.id_sueldo = :id_sueldo
		';

		$statement = $sql->preparar($query);
		$sueldo = new SueldoTrabajador;

		if ($statement)
		{
			$statement->bindParam("id_sueldo", $id_sueldo);
			$statement->bindParam("id_trabajador", $id_trabajador);

			$sql->ejecutar();
			$sql->cerrar();

			if(!$registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				return false;
			}

			$sueldo->id_sueldo		= $registro["id_sueldo"];
			$sueldo->id_trabajador	= $registro["id_trabajador"];
			$sueldo->sueldo			= $registro["sueldo"];
			$sueldo->actual			= $registro["actual"];
			$sueldo->fecha_creacion	= $registro["fecha_creacion"];
		}

		return $sueldo;
	}

	private function fncObtenerActualBD($id_trabajador)
	{
		$sql = cls_control::get_instancia();

		$query = '
		SELECT
			st.id_sueldo,
			st.id_trabajador,
			st.sueldo,
			st.actual,
			st.fecha_creacion
		FROM escalafon.sueldo_trabajador st
		WHERE
			st.id_trabajador = :id_trabajador AND
			st.actual = 1
		';

		$statement = $sql->preparar($query);
		$sueldo = new SueldoTrabajador;

		if ($statement)
		{
			$statement->bindParam("id_trabajador", $id_trabajador);

			$sql->ejecutar();
			$sql->cerrar();

			if(!$registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				return false;
			}

			$sueldo->id_sueldo		= $registro["id_sueldo"];
			$sueldo->id_trabajador	= $registro["id_trabajador"];
			$sueldo->sueldo			= $registro["sueldo"];
			$sueldo->actual			= $registro["actual"];
			$sueldo->fecha_creacion	= $registro["fecha_creacion"];
		}

		return $sueldo;
	}

	private function fncGuardarBD(SueldoTrabajador $sueldo)
	{
		$sql = cls_control::get_instancia();

		$query = '
		INSERT INTO escalafon.sueldo_trabajador(
			id_trabajador,
			sueldo,
			actual)
		VALUES (
			:id_trabajador,
			:sueldo,
			:actual
		)
		RETURNING
			id_sueldo,
			id_trabajador,
			sueldo,
			actual,
			fecha_creacion
		';

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_trabajador", $sueldo->id_trabajador);
			$statement->bindParam("sueldo", $sueldo->sueldo);
			$statement->bindParam("actual", $sueldo->actual);

			$sql->ejecutar();
			$sql->cerrar();

			if($registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$sueldo->id_sueldo = $registro["id_sueldo"];
				$sueldo->fecha_creacion = $registro["fecha_creacion"];
			}
			else
			{
				return false;
			}
		}

		return $sueldo;
	}

	private function fncActualizarBD(SueldoTrabajador $sueldo)
	{
		$sql = cls_control::get_instancia();

		$query = "
		UPDATE escalafon.sueldo_trabajador SET
			sueldo=:sueldo,
			actual=:actual
		WHERE
			id_sueldo = :id_sueldo AND
			id_trabajador = :id_trabajador
		RETURNING
			id_sueldo,
			id_trabajador,
			sueldo,
			actual,
			fecha_creacion
		";

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_sueldo", $sueldo->id_sueldo);
			$statement->bindParam("id_trabajador", $sueldo->id_trabajador);
			$statement->bindParam("sueldo", $sueldo->sueldo);
			$statement->bindParam("actual", $sueldo->actual);

			$sql->ejecutar();
			$sql->cerrar();

			if($registro = $statement->fetch(PDO::FETCH_ASSOC))
			{

			}
			else
			{
				return false;
			}
		}

		return $sueldo;
	}

	private function fncEliminarBD($id_sueldo)
	{
		$sql = cls_control::get_instancia();

		$query = "
		DELETE FROM escalafon.sueldo_trabajador
		WHERE id_sueldo = :id_sueldo
		";

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_sueldo", $id_sueldo);

			$sql->ejecutar();
			$sql->cerrar();

			return true;
		}
	}

	private function fncDesactivarSueldosBD($id_trabajador)
	{
		$sql = cls_control::get_instancia();

		$query = "
		UPDATE escalafon.sueldo_trabajador SET
			actual=0
		WHERE id_trabajador = :id_trabajador
		";

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_trabajador", $id_trabajador);

			$sql->ejecutar();
			$sql->cerrar();

			return true;
		}
	}

	private function fncObtenerDatosRegistroBD(SueldoTrabajador $sueldo)
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
			a.tabla = \'sueldo_trabajador\' AND
			a.objeto_id_valor = :id_sueldo AND
			a.id_operacion = 1
		';

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_sueldo", $sueldo->id_sueldo);

			$sql->ejecutar();
			$sql->cerrar();

			if($registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$sueldo->fecha_registro		= $registro["fecha_registro"];
				$sueldo->hora_registro		= $registro["hora_registro"];
				$sueldo->usuario_registro	= $registro["usuario_registro"];
			}
		}

		return $sueldo;
	}
}
