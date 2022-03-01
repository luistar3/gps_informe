<?php

require_once '../../App/Config/control.php';
require_once '../../App/Public/archivo.php';
require_once '../../App/Public/rutas.php';
require_once '../../App/Escalafon/Controllers/AuditoriaController.php';
require_once '../../App/Escalafon/Models/RemuneracionFamiliar.php';
require_once '../../App/Escalafon/Models/AuditoriaArchivo.php';

class RemuneracionFamiliarController extends RemuneracionFamiliar
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
			$remuneracion = $this->fncObtenerDatosFamiliarBD($remuneracion);
		}

		$auditoriaController = new AuditoriaController;
		$auditoria = $auditoriaController->fncGuardar(4, 'remuneracion_familiar');

		return $remuneraciones;
	}

	public function fncObtener($id_trabajador, $id_remuneracion_familiar)
	{
		if (!$remuneracion = $this->fncObtenerBD($id_trabajador, $id_remuneracion_familiar))
		{
			return false;
		}

		$remuneracion = $this->fncObtenerDatosRegistroBD($remuneracion);
		$remuneracion = $this->fncObtenerDatosFamiliarBD($remuneracion);

		$auditoriaController = new AuditoriaController;
		$auditoria = $auditoriaController->fncGuardar(4, 'remuneracion_familiar', 'id_remuneracion_familiar', $remuneracion->id_remuneracion_familiar);

		return $remuneracion;
	}

	public function fncGuardar($inputs, $files)
	{
		$remuneracion = new RemuneracionFamiliar;

		$remuneracion->id_trabajador = $inputs->id_trabajador;
		$remuneracion->id_familiar = $inputs->id_familiar;
		$remuneracion->asunto = isset($inputs->asunto)? $inputs->asunto : null;
		$remuneracion->numero_documento = isset($inputs->numero_documento)? $inputs->numero_documento : null;
		$remuneracion->fecha_documento = isset($inputs->fecha_documento)? $inputs->fecha_documento : null;

		$remuneracion->archivo = null;
		$aud_archivo = null;

		if (isset($files->archivo) && $files->archivo->name != '')
		{
			$ruta =  cls_rutas::get('remuneracionFamiliarPdf');
			$archivo = new archivo((array) $files->archivo, $ruta, "pdf_", 0, 1);
			if ($archivo->subir())
			{
				$remuneracion->archivo = $ruta.$archivo->get_nombre_archivo();

				$aud_archivo = new AuditoriaArchivo;
				$aud_archivo->setNombre($archivo->get_nombre_archivo());
				$aud_archivo->setNombreOriginal($files->archivo->name);
				$aud_archivo->setRuta($remuneracion->archivo);
				$aud_archivo->setTamano($files->archivo->size);
			}
		}

		if (!$remuneracion = $this->fncGuardarBD($remuneracion))
		{
			return false;
		}

		$auditoriaController = new AuditoriaController;
		$aud_remuneracion = clone $remuneracion;
		$aud_remuneracion->archivo = $aud_archivo;
		$auditoria = $auditoriaController->fncGuardar(1, 'remuneracion_familiar', 'id_remuneracion_familiar', $aud_remuneracion->id_remuneracion_familiar, json_encode($aud_remuneracion));

		$remuneracion->fecha_registro = $auditoria->getFecha();
		$remuneracion->hora_registro = $auditoria->getHora();
		$remuneracion->usuario_registro = $auditoria->getUsuario();

		$remuneracion = $this->fncObtenerDatosFamiliarBD($remuneracion);

		return $remuneracion;
	}

	public function fncActualizar($inputs, $files)
	{
		if (!$remuneracion = $this->fncObtenerBD($inputs->id_trabajador, $inputs->id_remuneracion_familiar))
		{
			return false;
		}

		$remuneracion = $this->fncObtenerDatosRegistroBD($remuneracion);
		$remuneracion = $this->fncObtenerDatosFamiliarBD($remuneracion);

		$remuneracion->asunto = isset($inputs->asunto)? $inputs->asunto : null;
		$remuneracion->numero_documento = isset($inputs->numero_documento)? $inputs->numero_documento : null;
		$remuneracion->fecha_documento = isset($inputs->fecha_documento)? $inputs->fecha_documento : null;

		$aud_archivo = $remuneracion->archivo;

		if (isset($files->archivo) && $files->archivo->name != '')
		{
			$ruta =  cls_rutas::get('remuneracionFamiliarPdf');
			$archivo = new archivo((array) $files->archivo, $ruta, "pdf_", 0, 1);
			if ($archivo->subir())
			{
				if(file_exists($remuneracion->archivo)) { unlink($remuneracion->archivo); }

				$remuneracion->archivo = $ruta.$archivo->get_nombre_archivo();

				$aud_archivo = new AuditoriaArchivo;
				$aud_archivo->setNombre($archivo->get_nombre_archivo());
				$aud_archivo->setNombreOriginal($files->archivo->name);
				$aud_archivo->setRuta($remuneracion->archivo);
				$aud_archivo->setTamano($files->archivo->size);
			}
		}

		$remuneracion = $this->fncActualizarBD($remuneracion);


		$auditoriaController = new AuditoriaController;
		$aud_remuneracion = clone $remuneracion;
		$aud_remuneracion->archivo = $aud_archivo;
		$auditoria = $auditoriaController->fncGuardar(2, 'remuneracion_familiar', 'id_remuneracion_familiar', $aud_remuneracion->id_remuneracion_familiar, json_encode($aud_remuneracion));

		return $remuneracion;
	}

	public function fncEliminar($id_trabajador, $id_remuneracion_familiar)
	{
		if (!$remuneracion = $this->fncObtenerBD($id_trabajador, $id_remuneracion_familiar))
		{
			return false;
		}

		$aud_remuneracion = clone $remuneracion;

		$remuneracion = $this->fncEliminarBD($remuneracion->id_remuneracion_familiar);

		if(file_exists($aud_remuneracion->archivo)) { unlink($aud_remuneracion->archivo); }

		$auditoriaController = new AuditoriaController;
		$auditoria = $auditoriaController->fncGuardar(3, 'remuneracion_familiar', 'id_remuneracion_familiar', $id_remuneracion_familiar);

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
			rf.id_remuneracion_familiar,
			rf.id_trabajador,
			rf.id_familiar,
			rf.asunto,
			rf.numero_documento,
			rf.fecha_documento,
			rf.archivo
		FROM escalafon.remuneracion_familiar rf
		WHERE
			rf.id_trabajador = :id_trabajador AND
			rf.eliminado = 0
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
				$remuneracion = new RemuneracionFamiliar;

				$remuneracion->id_remuneracion_familiar	= $registro["id_remuneracion_familiar"];
				$remuneracion->id_trabajador			= $registro["id_trabajador"];
				$remuneracion->id_familiar				= $registro["id_familiar"];
				$remuneracion->asunto					= $registro["asunto"];
				$remuneracion->numero_documento			= $registro["numero_documento"];
				$remuneracion->fecha_documento			= $registro["fecha_documento"];
				$remuneracion->archivo					= $registro["archivo"];

				$data[] = $remuneracion;
			}
		}

		return $data;
	}

	private function fncObtenerBD($id_trabajador, $id_remuneracion_familiar)
	{
		$sql = cls_control::get_instancia();

		$query = '
		SELECT
			rf.id_remuneracion_familiar,
			rf.id_trabajador,
			rf.id_familiar,
			rf.asunto,
			rf.numero_documento,
			rf.fecha_documento,
			rf.archivo
		FROM escalafon.remuneracion_familiar rf
		WHERE
			rf.id_trabajador = :id_trabajador AND
			rf.id_remuneracion_familiar = :id_remuneracion_familiar AND
			rf.eliminado = 0
		';

		$statement = $sql->preparar($query);
		$remuneracion = new RemuneracionFamiliar;

		if ($statement)
		{
			$statement->bindParam("id_remuneracion_familiar", $id_remuneracion_familiar);
			$statement->bindParam("id_trabajador", $id_trabajador);

			$sql->ejecutar();
			$sql->cerrar();

			if(!$registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				return false;
			}

			$remuneracion->id_remuneracion_familiar	= $registro["id_remuneracion_familiar"];
			$remuneracion->id_trabajador			= $registro["id_trabajador"];
			$remuneracion->id_familiar				= $registro["id_familiar"];
			$remuneracion->asunto					= $registro["asunto"];
			$remuneracion->numero_documento			= $registro["numero_documento"];
			$remuneracion->fecha_documento			= $registro["fecha_documento"];
			$remuneracion->archivo					= $registro["archivo"];

			
		}

		return $remuneracion;
	}

	private function fncObtenerDatosRegistroBD(RemuneracionFamiliar $remuneracion)
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
			a.tabla = \'remuneracion_familiar\' AND
			a.objeto_id_valor = :id_remuneracion_familiar AND
			a.id_operacion = 1
		';

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_remuneracion_familiar", $remuneracion->id_remuneracion_familiar);

			$sql->ejecutar();
			$sql->cerrar();

			if($registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$remuneracion->fecha_registro	= $registro["fecha_registro"];
				$remuneracion->hora_registro	= $registro["hora_registro"];
				$remuneracion->usuario_registro	= $registro["usuario_registro"];
			}
		}

		return $remuneracion;
	}

	private function fncObtenerDatosFamiliarBD(RemuneracionFamiliar $remuneracion)
	{
		$sql = cls_control::get_instancia();

		$query = '
		SELECT
			f.primer_nombre || \' \' || f.segundo_nombre || \' \' || f.apellido_paterno || \' \' || f.apellido_materno AS familiar_nombre_completo,
			t.tipo_familiar AS familiar_parentesco
		FROM escalafon.trabajador_familiar tf
		INNER JOIN escalafon.familiar f ON f.id_familiar = tf.id_familiar			
		INNER JOIN escalafon.tipo_familiar t ON t.id_tipo_familiar = tf.id_tipo_familiar
		WHERE
			tf.id_trabajador = :id_trabajador AND
			tf.id_familiar = :id_familiar AND
			tf.eliminado = 0
		';

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_trabajador", $remuneracion->id_trabajador);
			$statement->bindParam("id_familiar", $remuneracion->id_familiar);

			$sql->ejecutar();
			$sql->cerrar();

			if($registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$remuneracion->familiar_nombre_completo	= $registro["familiar_nombre_completo"];
				$remuneracion->familiar_parentesco		= $registro["familiar_parentesco"];
			}
		}

		return $remuneracion;
	}

	private function fncGuardarBD(RemuneracionFamiliar $remuneracion)
	{
		$sql = cls_control::get_instancia();

		$query = '
		INSERT INTO escalafon.remuneracion_familiar(
			id_trabajador,
			id_familiar,
			asunto,
			numero_documento,
			fecha_documento,
			archivo,
			eliminado)
		VALUES (
			:id_trabajador,
			:id_familiar,
			:asunto,
			:numero_documento,
			:fecha_documento,
			:archivo,
			0
		)
		RETURNING
			id_remuneracion_familiar,
			id_trabajador,
			id_familiar,
			asunto,
			numero_documento,
			fecha_documento,
			archivo
		';

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_trabajador", $remuneracion->id_trabajador);
			$statement->bindParam("id_familiar", $remuneracion->id_familiar);
			$statement->bindParam("asunto", $remuneracion->asunto);
			$statement->bindParam("numero_documento", $remuneracion->numero_documento);
			$statement->bindParam("fecha_documento", $remuneracion->fecha_documento);
			$statement->bindParam("archivo", $remuneracion->archivo);

			$sql->ejecutar();
			$sql->cerrar();

			if($registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$remuneracion->id_remuneracion_familiar = $registro["id_remuneracion_familiar"];
				$remuneracion->fecha_documento = $registro["fecha_documento"];
			}
			else
			{
				return false;
			}
		}

		return $remuneracion;
	}

	private function fncActualizarBD(RemuneracionFamiliar $remuneracion)
	{
		$sql = cls_control::get_instancia();

		$query = "
		UPDATE escalafon.remuneracion_familiar SET
			id_familiar=:id_familiar,
			asunto=:asunto,
			numero_documento=:numero_documento,
			fecha_documento=:fecha_documento,
			archivo=:archivo
		WHERE id_remuneracion_familiar = :id_remuneracion_familiar
		RETURNING
			id_remuneracion_familiar,
			id_trabajador,
			id_familiar,
			asunto,
			numero_documento,
			fecha_documento,
			archivo
		";

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_remuneracion_familiar", $remuneracion->id_remuneracion_familiar);
			$statement->bindParam("id_familiar", $remuneracion->id_familiar);
			$statement->bindParam("asunto", $remuneracion->asunto);
			$statement->bindParam("numero_documento", $remuneracion->numero_documento);
			$statement->bindParam("fecha_documento", $remuneracion->fecha_documento);
			$statement->bindParam("archivo", $remuneracion->archivo);

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

	private function fncEliminarBD($id_remuneracion_familiar)
	{
		$sql = cls_control::get_instancia();

		$query = "
		UPDATE escalafon.remuneracion_familiar SET
			eliminado=1
		WHERE id_remuneracion_familiar = :id_remuneracion_familiar
		RETURNING
			id_remuneracion_familiar
		";

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_remuneracion_familiar", $id_remuneracion_familiar);

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
