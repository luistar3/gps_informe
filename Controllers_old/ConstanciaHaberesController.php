<?php

require_once '../../App/Config/control.php';
require_once '../../App/Public/archivo.php';
require_once '../../App/Public/rutas.php';
require_once '../../App/Escalafon/Controllers/AuditoriaController.php';
require_once '../../App/Escalafon/Models/ConstanciaHaberes.php';
require_once '../../App/Escalafon/Models/AuditoriaArchivo.php';

class ConstanciaHaberesController extends ConstanciaHaberes
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
		$constancias = $this->fncListarBD($id_trabajador);

		foreach ($constancias as $constancia)
		{
			$constancia = $this->fncObtenerDatosRegistroBD($constancia);
		}

		$auditoriaController = new AuditoriaController;
		$auditoria = $auditoriaController->fncGuardar(4, 'constancia_haberes');

		return $constancias;
	}

	public function fncObtener($id_trabajador, $id_constancia_haberes)
	{
		if (!$constancia = $this->fncObtenerBD($id_trabajador, $id_constancia_haberes))
		{
			return false;
		}

		$constancia = $this->fncObtenerDatosRegistroBD($constancia);

		$auditoriaController = new AuditoriaController;
		$auditoria = $auditoriaController->fncGuardar(4, 'constancia_haberes', 'id_constancia_haberes', $constancia->id_constancia_haberes);

		return $constancia;
	}

	public function fncGuardar($inputs, $files)
	{
		$constancia = new ConstanciaHaberes;

		$constancia->id_trabajador = $inputs->id_trabajador;
		$constancia->id_tipo_accion = $inputs->id_tipo_accion;
		$constancia->id_tipo_documento = $inputs->id_tipo_documento;
		$constancia->numero_documento = isset($inputs->numero_documento)? $inputs->numero_documento : null;
		$constancia->fecha_documento = isset($inputs->fecha_documento)? $inputs->fecha_documento : null;
		$constancia->lugar = isset($inputs->lugar)? $inputs->lugar : null;
		$constancia->nivel = isset($inputs->nivel)? $inputs->nivel : null;
		$constancia->cargo = isset($inputs->cargo)? $inputs->cargo : null;
		$constancia->anios = isset($inputs->anios)? $inputs->anios : null;
		$constancia->meses = isset($inputs->meses)? $inputs->meses : null;
		$constancia->dias = isset($inputs->dias)? $inputs->dias : null;
		$constancia->fecha_retiro = isset($inputs->fecha_retiro)? $inputs->fecha_retiro : null;
		$constancia->fecha_inicio = isset($inputs->fecha_inicio)? $inputs->fecha_inicio : null;
		$constancia->fecha_termino = isset($inputs->fecha_termino)? $inputs->fecha_termino : null;
		$constancia->devengado = isset($inputs->devengado)? $inputs->devengado : null;
		$constancia->reintegro = isset($inputs->reintegro)? $inputs->reintegro : null;
		$constancia->total = isset($inputs->total)? $inputs->total : null;
		$constancia->observacion = isset($inputs->observacion)? $inputs->observacion : null;

		$constancia->archivo = null;
		$aud_archivo = null;

		if (isset($files->archivo) && $files->archivo->name != '')
		{
			$ruta =  cls_rutas::get('constanciaHaberesPdf');
			$archivo = new archivo((array) $files->archivo, $ruta, "pdf_", 0, 1);
			if ($archivo->subir())
			{
				$constancia->archivo = $ruta.$archivo->get_nombre_archivo();

				$aud_archivo = new AuditoriaArchivo;
				$aud_archivo->setNombre($archivo->get_nombre_archivo());
				$aud_archivo->setNombreOriginal($files->archivo->name);
				$aud_archivo->setRuta($constancia->archivo);
				$aud_archivo->setTamano($files->archivo->size);
			}
		}

		if (!$constancia = $this->fncGuardarBD($constancia))
		{
			return false;
		}

		$auditoriaController = new AuditoriaController;
		$aud_constancia = clone $constancia;
		$aud_constancia->archivo = $aud_archivo;
		$auditoria = $auditoriaController->fncGuardar(1, 'constancia_haberes', 'id_constancia_haberes', $aud_constancia->id_constancia_haberes, json_encode($aud_constancia));

		$constancia->fecha_registro = $auditoria->getFecha();
		$constancia->hora_registro = $auditoria->getHora();
		$constancia->usuario_registro = $auditoria->getUsuario();

		return $constancia;
	}

	public function fncActualizar($inputs, $files)
	{
		if (!$constancia = $this->fncObtenerBD($inputs->id_trabajador, $inputs->id_constancia_haberes))
		{
			return false;
		}

		$constancia = $this->fncObtenerDatosRegistroBD($constancia);

		$constancia->id_tipo_accion = $inputs->id_tipo_accion;
		$constancia->id_tipo_documento = $inputs->id_tipo_documento;
		$constancia->numero_documento = isset($inputs->numero_documento)? $inputs->numero_documento : null;
		$constancia->fecha_documento = isset($inputs->fecha_documento)? $inputs->fecha_documento : null;
		$constancia->lugar = isset($inputs->lugar)? $inputs->lugar : null;
		$constancia->nivel = isset($inputs->nivel)? $inputs->nivel : null;
		$constancia->cargo = isset($inputs->cargo)? $inputs->cargo : null;
		$constancia->anios = isset($inputs->anios)? $inputs->anios : null;
		$constancia->meses = isset($inputs->meses)? $inputs->meses : null;
		$constancia->dias = isset($inputs->dias)? $inputs->dias : null;
		$constancia->fecha_retiro = isset($inputs->fecha_retiro)? $inputs->fecha_retiro : null;
		$constancia->fecha_inicio = isset($inputs->fecha_inicio)? $inputs->fecha_inicio : null;
		$constancia->fecha_termino = isset($inputs->fecha_termino)? $inputs->fecha_termino : null;
		$constancia->devengado = isset($inputs->devengado)? $inputs->devengado : null;
		$constancia->reintegro = isset($inputs->reintegro)? $inputs->reintegro : null;
		$constancia->total = isset($inputs->total)? $inputs->total : null;
		$constancia->observacion = isset($inputs->observacion)? $inputs->observacion : null;

		$aud_archivo = $constancia->archivo;

		if (isset($files->archivo) && $files->archivo->name != '')
		{
			$ruta =  cls_rutas::get('constanciaHaberesPdf');
			$archivo = new archivo((array) $files->archivo, $ruta, "pdf_", 0, 1);
			if ($archivo->subir())
			{
				if(file_exists($constancia->archivo)) { unlink($constancia->archivo); }

				$constancia->archivo = $ruta.$archivo->get_nombre_archivo();

				$aud_archivo = new AuditoriaArchivo;
				$aud_archivo->setNombre($archivo->get_nombre_archivo());
				$aud_archivo->setNombreOriginal($files->archivo->name);
				$aud_archivo->setRuta($constancia->archivo);
				$aud_archivo->setTamano($files->archivo->size);
			}
		}

		$constancia = $this->fncActualizarBD($constancia);


		$auditoriaController = new AuditoriaController;
		$aud_constancia = clone $constancia;
		$aud_constancia->archivo = $aud_archivo;
		$auditoria = $auditoriaController->fncGuardar(2, 'constancia_haberes', 'id_constancia_haberes', $aud_constancia->id_constancia_haberes, json_encode($aud_constancia));

		return $constancia;
	}

	public function fncEliminar($id_trabajador, $id_constancia_haberes)
	{
		if (!$constancia = $this->fncObtenerBD($id_trabajador, $id_constancia_haberes))
		{
			return false;
		}

		$aux_constancia = clone $constancia;

		$constancia = $this->fncEliminarBD($constancia->id_constancia_haberes);

		if(file_exists($aux_constancia->archivo)) { unlink($aux_constancia->archivo); }

		$auditoriaController = new AuditoriaController;
		$auditoria = $auditoriaController->fncGuardar(3, 'constancia_haberes', 'id_constancia_haberes', $id_constancia_haberes);

		return $constancia;
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
			ch.id_constancia_haberes,
			ch.id_trabajador,
			ch.id_tipo_accion,
			ch.id_tipo_documento,
			ch.numero_documento,
			ch.fecha_documento,
			ch.lugar,
			ch.nivel,
			ch.cargo,
			ch.anios,
			ch.meses,
			ch.dias,
			ch.fecha_retiro,
			ch.fecha_inicio,
			ch.fecha_termino,
			ch.devengado,
			ch.reintegro,
			ch.total,
			ch.observacion,
			ch.archivo
		FROM escalafon.constancia_haberes ch
		WHERE
			ch.id_trabajador = :id_trabajador AND
			ch.eliminado = 0
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
				$constancia = new ConstanciaHaberes;

				$constancia->id_constancia_haberes	= $registro["id_constancia_haberes"];
				$constancia->id_trabajador			= $registro["id_trabajador"];
				$constancia->id_tipo_accion			= $registro["id_tipo_accion"];
				$constancia->id_tipo_documento		= $registro["id_tipo_documento"];
				$constancia->numero_documento		= $registro["numero_documento"];
				$constancia->fecha_documento		= $registro["fecha_documento"];
				$constancia->lugar					= $registro["lugar"];
				$constancia->nivel					= $registro["nivel"];
				$constancia->cargo					= $registro["cargo"];
				$constancia->anios					= $registro["anios"];
				$constancia->meses					= $registro["meses"];
				$constancia->dias					= $registro["dias"];
				$constancia->fecha_retiro			= $registro["fecha_retiro"];
				$constancia->fecha_inicio			= $registro["fecha_inicio"];
				$constancia->fecha_termino			= $registro["fecha_termino"];
				$constancia->devengado				= $registro["devengado"];
				$constancia->reintegro				= $registro["reintegro"];
				$constancia->total					= $registro["total"];
				$constancia->observacion			= $registro["observacion"];
				$constancia->archivo				= $registro["archivo"];

				$data[] = $constancia;
			}
		}

		return $data;
	}

	private function fncObtenerBD($id_trabajador, $id_constancia_haberes)
	{
		$sql = cls_control::get_instancia();

		$query = '
		SELECT
			ch.id_constancia_haberes,
			ch.id_trabajador,
			ch.id_tipo_accion,
			ch.id_tipo_documento,
			ch.numero_documento,
			ch.fecha_documento,
			ch.lugar,
			ch.nivel,
			ch.cargo,
			ch.anios,
			ch.meses,
			ch.dias,
			ch.fecha_retiro,
			ch.fecha_inicio,
			ch.fecha_termino,
			ch.devengado,
			ch.reintegro,
			ch.total,
			ch.observacion,
			ch.archivo
		FROM escalafon.constancia_haberes ch
		WHERE
			ch.id_trabajador = :id_trabajador AND
			ch.id_constancia_haberes = :id_constancia_haberes AND
			ch.eliminado = 0
		';

		$statement = $sql->preparar($query);
		$constancia = new ConstanciaHaberes;

		if ($statement)
		{
			$statement->bindParam("id_constancia_haberes", $id_constancia_haberes);
			$statement->bindParam("id_trabajador", $id_trabajador);

			$sql->ejecutar();
			$sql->cerrar();

			if(!$registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				return false;
			}

			$constancia->id_constancia_haberes	= $registro["id_constancia_haberes"];
			$constancia->id_trabajador			= $registro["id_trabajador"];
			$constancia->id_tipo_accion			= $registro["id_tipo_accion"];
			$constancia->id_tipo_documento		= $registro["id_tipo_documento"];
			$constancia->numero_documento		= $registro["numero_documento"];
			$constancia->fecha_documento		= $registro["fecha_documento"];
			$constancia->lugar					= $registro["lugar"];
			$constancia->nivel					= $registro["nivel"];
			$constancia->cargo					= $registro["cargo"];
			$constancia->anios					= $registro["anios"];
			$constancia->meses					= $registro["meses"];
			$constancia->dias					= $registro["dias"];
			$constancia->fecha_retiro			= $registro["fecha_retiro"];
			$constancia->fecha_inicio			= $registro["fecha_inicio"];
			$constancia->fecha_termino			= $registro["fecha_termino"];
			$constancia->devengado				= $registro["devengado"];
			$constancia->reintegro				= $registro["reintegro"];
			$constancia->total					= $registro["total"];
			$constancia->observacion			= $registro["observacion"];
			$constancia->archivo				= $registro["archivo"];
		}

		return $constancia;
	}

	private function fncObtenerDatosRegistroBD(ConstanciaHaberes $constancia)
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
			a.tabla = \'constancia_haberes\' AND
			a.objeto_id_valor = :id_constancia_haberes AND
			a.id_operacion = 1
		';

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_constancia_haberes", $constancia->id_constancia_haberes);

			$sql->ejecutar();
			$sql->cerrar();

			if($registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$constancia->fecha_registro		= $registro["fecha_registro"];
				$constancia->hora_registro		= $registro["hora_registro"];
				$constancia->usuario_registro	= $registro["usuario_registro"];
			}
		}

		return $constancia;
	}

	private function fncGuardarBD(ConstanciaHaberes $constancia)
	{
		$sql = cls_control::get_instancia();

		$query = '
		INSERT INTO escalafon.constancia_haberes(
			id_trabajador,
			id_tipo_accion,
			id_tipo_documento,
			numero_documento,
			fecha_documento,
			lugar,
			nivel,
			cargo,
			anios,
			meses,
			dias,
			fecha_retiro,
			fecha_inicio,
			fecha_termino,
			devengado,
			reintegro,
			total,
			observacion,
			archivo,
			eliminado)
		VALUES (
			:id_trabajador,
			:id_tipo_accion,
			:id_tipo_documento,
			:numero_documento,
			:fecha_documento,
			:lugar,
			:nivel,
			:cargo,
			:anios,
			:meses,
			:dias,
			:fecha_retiro,
			:fecha_inicio,
			:fecha_termino,
			:devengado,
			:reintegro,
			:total,
			:observacion,
			:archivo,
			0
		)
		RETURNING
			id_constancia_haberes,
			id_trabajador,
			id_tipo_accion,
			id_tipo_documento,
			numero_documento,
			fecha_documento,
			lugar,
			nivel,
			cargo,
			anios,
			meses,
			dias,
			fecha_retiro,
			fecha_inicio,
			fecha_termino,
			devengado,
			reintegro,
			total,
			observacion,
			archivo
		';

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_trabajador", $constancia->id_trabajador);
			$statement->bindParam("id_tipo_accion", $constancia->id_tipo_accion);
			$statement->bindParam("id_tipo_documento", $constancia->id_tipo_documento);
			$statement->bindParam("numero_documento", $constancia->numero_documento);
			$statement->bindParam("fecha_documento", $constancia->fecha_documento);
			$statement->bindParam("lugar", $constancia->lugar);
			$statement->bindParam("nivel", $constancia->nivel);
			$statement->bindParam("cargo", $constancia->cargo);
			$statement->bindParam("anios", $constancia->anios);
			$statement->bindParam("meses", $constancia->meses);
			$statement->bindParam("dias", $constancia->dias);
			$statement->bindParam("fecha_retiro", $constancia->fecha_retiro);
			$statement->bindParam("fecha_inicio", $constancia->fecha_inicio);
			$statement->bindParam("fecha_termino", $constancia->fecha_termino);
			$statement->bindParam("devengado", $constancia->devengado);
			$statement->bindParam("reintegro", $constancia->reintegro);
			$statement->bindParam("total", $constancia->total);
			$statement->bindParam("observacion", $constancia->observacion);
			$statement->bindParam("archivo", $constancia->archivo);

			$sql->ejecutar();
			$sql->cerrar();

			if($registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$constancia->id_constancia_haberes = $registro["id_constancia_haberes"];
				$constancia->fecha_documento = $registro["fecha_documento"];
				$constancia->fecha_retiro = $registro["fecha_retiro"];
				$constancia->fecha_inicio = $registro["fecha_inicio"];
				$constancia->fecha_termino = $registro["fecha_termino"];
			}
			else
			{
				return false;
			}
		}

		return $constancia;
	}

	private function fncActualizarBD(ConstanciaHaberes $constancia)
	{
		$sql = cls_control::get_instancia();

		$query = "
		UPDATE escalafon.constancia_haberes SET
			id_tipo_accion=:id_tipo_accion,
			id_tipo_documento=:id_tipo_documento,
			numero_documento=:numero_documento,
			fecha_documento=:fecha_documento,
			lugar=:lugar,
			nivel=:nivel,
			cargo=:cargo,
			anios=:anios,
			meses=:meses,
			dias=:dias,
			fecha_retiro=:fecha_retiro,
			fecha_inicio=:fecha_inicio,
			fecha_termino=:fecha_termino,
			devengado=:devengado,
			reintegro=:reintegro,
			total=:total,
			observacion=:observacion,
			archivo=:archivo
		WHERE id_constancia_haberes = :id_constancia_haberes
		RETURNING
			id_constancia_haberes,
			id_trabajador,
			id_tipo_accion,
			id_tipo_documento,
			numero_documento,
			fecha_documento,
			lugar,
			nivel,
			cargo,
			anios,
			meses,
			dias,
			fecha_retiro,
			fecha_inicio,
			fecha_termino,
			devengado,
			reintegro,
			total,
			observacion,
			archivo
		";

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_constancia_haberes", $constancia->id_constancia_haberes);
			$statement->bindParam("id_tipo_accion", $constancia->id_tipo_accion);
			$statement->bindParam("id_tipo_documento", $constancia->id_tipo_documento);
			$statement->bindParam("numero_documento", $constancia->numero_documento);
			$statement->bindParam("fecha_documento", $constancia->fecha_documento);
			$statement->bindParam("lugar", $constancia->lugar);
			$statement->bindParam("nivel", $constancia->nivel);
			$statement->bindParam("cargo", $constancia->cargo);
			$statement->bindParam("anios", $constancia->anios);
			$statement->bindParam("meses", $constancia->meses);
			$statement->bindParam("dias", $constancia->dias);
			$statement->bindParam("fecha_retiro", $constancia->fecha_retiro);
			$statement->bindParam("fecha_inicio", $constancia->fecha_inicio);
			$statement->bindParam("fecha_termino", $constancia->fecha_termino);
			$statement->bindParam("devengado", $constancia->devengado);
			$statement->bindParam("reintegro", $constancia->reintegro);
			$statement->bindParam("total", $constancia->total);
			$statement->bindParam("observacion", $constancia->observacion);
			$statement->bindParam("archivo", $constancia->archivo);

			$sql->ejecutar();
			$sql->cerrar();

			if($registro = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$constancia->id_constancia_haberes = $registro["id_constancia_haberes"];
				$constancia->fecha_documento = $registro["fecha_documento"];
				$constancia->fecha_retiro = $registro["fecha_retiro"];
				$constancia->fecha_inicio = $registro["fecha_inicio"];
				$constancia->fecha_termino = $registro["fecha_termino"];
			}
			else
			{
				return false;
			}
		}

		return $constancia;
	}

	private function fncEliminarBD($id_constancia_haberes)
	{
		$sql = cls_control::get_instancia();

		$query = "
		UPDATE escalafon.constancia_haberes SET
			eliminado=1
		WHERE id_constancia_haberes = :id_constancia_haberes
		RETURNING
			id_constancia_haberes
		";

		$statement = $sql->preparar($query);

		if ($statement)
		{
			$statement->bindParam("id_constancia_haberes", $id_constancia_haberes);

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