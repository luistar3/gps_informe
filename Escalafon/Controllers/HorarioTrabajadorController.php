<?php
require_once '../../App/Escalafon/Models/HorarioTrabajador.php';
require_once '../../App/Escalafon/Controllers/AuditoriaController.php';
require_once '../../App/Config/control.php';
require_once '../../App/Public/archivo.php';
require_once '../../App/Public/rutas.php';

class HorarioTrabajadorController extends HorarioTrabajador
{
	//=======================================================================================
	//FUNCIONES LOGICA
	//=======================================================================================

	public function fncListarRegistros($id = -1)
	{

		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosBD($id);

		if (fncGeneralValidarDataArray($dtListado)) {
			foreach ($dtListado as $listado) {

				$model = array();

				$model["idHorarioTrabajador"]   = $listado->idHorarioTrabajador;
				$model["idTrabajador"]  		= $listado->idTrabajador;
				$model["horaIngreso"]         	= $listado->horaIngreso;
				$model["horaSalida"]   			= $listado->horaSalida;
				$model["idTrabajadorReloj"]  	= $listado->idTrabajadorReloj;
				$model["eliminado"]             = $listado->eliminado;
	

				array_push($dtReturn, $model);
			}
		}
		return $dtReturn;
	}


	public function fncObtenerRegistro($id )
	{
	
		$dtReturn = array();
		$dtListado = $this->fncObtenerRegistroBD($id);
		
		if (fncGeneralValidarDataArray($dtListado)) {
			
			foreach ($dtListado as $listado) {

				$model = array();
				$model["idHorarioTrabajador"]       = $listado->idHorarioTrabajador;
				$model["nombreCompleto"]         	= $listado->nombreCompleto;
				$model["documentoIdentidad"]        = $listado->documentoIdentidad;
				$model["idTrabajador"] 				= $listado->idTrabajador;
				$model["horaIngreso"]  				= '2020-07-15 '.$listado->horaIngreso;				
				$model["horaSalida"]   				= '2020-07-15 '.$listado->horaSalida;
				$model["horasTrabajo"]   				= $listado->horasTrabajo;
				$model["idTrabajadorReloj"]  		= $listado->idTrabajadorReloj;	
				$model["eliminado"]		            = $listado->eliminado;
				$model["actual"]		            = (Int)$listado->actual;
				$model["fechahoraAuditoria"]		= ($listado->fechahoraAuditoria);
				$model["usuarioAuditoria"]			= $listado->usuarioAuditoria;	

				
				array_push($dtReturn, $model);
			}
		}

		
		return array_shift($dtReturn);
	}

	public function fncListarRegistroHorarioTrabajadorAuditoria($id = -1)
	{

		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosAuditoriaBD($id);

		if (fncGeneralValidarDataArray($dtListado)) {
			foreach ($dtListado as $listado) {

				$model = array();
				$model["idHorarioTrabajador"]   = $listado->idHorarioTrabajador;
				$model["idTrabajador"]  		= $listado->idTrabajador;
				$model["horaIngreso"]         	= $listado->horaIngreso;
				$model["horaSalida"]   			= $listado->horaSalida;
				$model["idTrabajadorReloj"]  	= $listado->idTrabajadorReloj;
				$model["eliminado"]             = $listado->eliminado;
	
				array_push($dtReturn, $model);
			}
		}
		return $dtReturn;
	}
	public function fncBuscarPorIdTrabajador($id)
	{

		$dtReturn = array();
		$listaAuditoria = array();
	//	$inputIdTrabajador = fncObtenerValorArray($arrayInputs, 'idTrabajador', true);
		$dtListado = $this->fncBuscarPorIdTrabajadorBD((Int)$id);
		$accion = 4;

		if (fncGeneralValidarDataArray($dtListado)) {

			foreach ($dtListado as $listado) {


				$model = array();
				$model["idHorarioTrabajador"]       = $listado->idHorarioTrabajador;
				$model["nombreCompleto"]         	= $listado->nombreCompleto;
				$model["documentoIdentidad"]        = $listado->documentoIdentidad;
				$model["idTrabajador"] 				= $listado->idTrabajador;
				$model["horaIngreso"]  				= '2020-07-15 '.$listado->horaIngreso;				
				$model["horaSalida"]   				= '2020-07-15 '.$listado->horaSalida;
				$model["horasTrabajo"]   				= $listado->horasTrabajo;
				$model["idTrabajadorReloj"]  		= $listado->idTrabajadorReloj;	
				$model["eliminado"]		            = $listado->eliminado;
				$model["actual"]		            = (Int)$listado->actual;
				$model["fechahoraAuditoria"]		= ($listado->fechahoraAuditoria);
				$model["usuarioAuditoria"]			= $listado->usuarioAuditoria;

				array_push($dtReturn, $model);
				array_push($listaAuditoria, $model['idHorarioTrabajador']);
			}

			$auditorioController = new AuditoriaController();
			$auditoria = $auditorioController->fncGuardar($accion, 'horario_trabajador', 'id_horario_trabajador', null, json_encode($listaAuditoria));

			//$dtReturnHorarioTrabajador = $model;
			//$dtReturn = $dtReturnHorarioTrabajador;
		}
		return $dtReturn;
	}

	public function fncGuardar($arrayInputs)
	{
		$dtReturn = array();
		$accion = 0;
		$inputIdHorarioTrabajador = (int) fncObtenerValorArray($arrayInputs, 'idHorarioTrabajador', true);
		$inputIdTrabajador = (int) fncObtenerValorArray($arrayInputs, 'idTrabajador', true);
		$inputIdTrabajadorReloj = (int) fncObtenerValorArray($arrayInputs, 'idTrabajadorReloj', true);
		$inputHoraIngreso = fncObtenerValorArray($arrayInputs, 'horaIngreso', true); //7:00
		$inputHoraSalida = fncObtenerValorArray($arrayInputs, 'horaSalida', true); //15:00
		$inputActual = fncObtenerValorArray($arrayInputs,'actual',true);

		$dtHorarioTrabajador = new HorarioTrabajador;


		$dt='';
		if(!empty($inputHoraIngreso)){
			$fecha = new DateTime($inputHoraIngreso);
			$horaIngreso = $fecha->format('H:i');
			$dtHorarioTrabajador->setHoraIngreso($horaIngreso);
		}
		if(!empty($inputHoraSalida)){
			$fecha = new DateTime($inputHoraSalida);
			$horaSalida = $fecha->format('H:i');
			$dtHorarioTrabajador->setHoraSalida($horaSalida);
			
		}



		if (!empty($inputIdHorarioTrabajador)) {
			$dtHorarioTrabajador->setIdHorarioTrabajador($inputIdHorarioTrabajador);
		}
		if (!empty($inputIdTrabajador)) {
			$dtHorarioTrabajador->setIdTrabajador($inputIdTrabajador);
		}
		if (!empty($inputIdTrabajadorReloj)) {
			$dtHorarioTrabajador->setIdTrabajadorReloj($inputIdTrabajadorReloj);
		}
		/*if (!empty($inputHoraIngreso)) {
			$dtHorarioTrabajador->setHoraIngreso($inputHoraIngreso);
		}
		if (!empty($inputHoraSalida)) {
			$dtHorarioTrabajador->setHoraSalida($inputHoraSalida);
		}*/
		
		
		

		if (fncGeneralValidarDataArray($dtHorarioTrabajador)) {
			$dtGuardar = array();
			$optArchivo = "";
			if ($inputIdHorarioTrabajador == 0 ) {
				$dtVerificarIdTrabajador = $this->fncBuscarRegistroTrabajadorHorarioBD($dtHorarioTrabajador->getIdTrabajador());
				$dtVerificarIdTrabajadorReloj = $this->fncBuscarRegistroTrabajadorHorarioRelojBD($dtHorarioTrabajador->getIdTrabajadorReloj());
				$dtActualizarActual = $this->fncActualizarActualBD($dtHorarioTrabajador);	
				if ( (count($dtVerificarIdTrabajador) == 0) && (count($dtVerificarIdTrabajadorReloj) == 0)) {
					$dtHorarioTrabajador->setActual(1);
									
					$dtGuardar = $this->fncRegistrarBD($dtHorarioTrabajador);
					
					$accion = 1;
				}
				else{
					$accion = 1;
					$dtHorarioTrabajador->setActual(1);
					$dtGuardar = $this->fncRegistrarBD($dtHorarioTrabajador);
					$mensaje='';
					if (count($dtVerificarIdTrabajador)>0) {
						$mensaje.=' Trabajador ya fue Registrado ';
					}
					if (count($dtVerificarIdTrabajadorReloj)>0) {
						$mensaje.=' Id reloj ya fue registrado ';
					}
					$dtReturn[1] =$mensaje;
					$dtReturn[0] =$dtGuardar;
				}
			
			} else {
				$dtVerificarIdTrabajadorReloj = $this->fncBuscarRegistroTrabajadorHorarioRelojActualizarBD($dtHorarioTrabajador->getIdTrabajadorReloj(),$dtHorarioTrabajador->getIdHorarioTrabajador());
				if ( (count($dtVerificarIdTrabajadorReloj) == 0)) {
					if (!empty($inputActual)) {
						$dtHorarioTrabajador->setActual($inputActual);
					}
					$dtGuardar = $this->fncActualizarBD($dtHorarioTrabajador);
					$accion = 2;
				}
				else{
					$mensaje='';					
					if (count($dtVerificarIdTrabajadorReloj)>0) {
						$mensaje.=' Id reloj ya fue registrado ';
					}
					$dtReturn[1] =$mensaje;
					$dtReturn[0] =$dtGuardar;
				}
				
			}

			if (fncGeneralValidarDataArray($dtGuardar)) {

				$model = array();
				$model["idHorarioTrabajador"]        	= $dtGuardar->getIdHorarioTrabajador();
				$model["idTrabajador"]  				= $dtGuardar->getIdTrabajador();
				$model["idTrabajadorReloj"]         	= $dtGuardar->getIdTrabajadorReloj();
				$model["horaIngreso"]   				= $dtGuardar->getHoraIngreso();
				$model["horaSalida"]  					= $dtGuardar->getHoraSalida();
			
				

				$auditorioController = new AuditoriaController();
				$auditoria = $auditorioController->fncGuardar($accion, 'horario_trabajador', 'id_horario_trabajador', $model["idHorarioTrabajador"], json_encode($model));
				//array_push($dtReturn, $this->fncObtenerRegistro($dtHorarioTrabajador->getIdHorarioTrabajador()));
				$dtReturn[0] = $this->fncObtenerRegistro($dtHorarioTrabajador->getIdHorarioTrabajador());
				unset($model);
			}
		}
		return $dtReturn;
	}

	public function fncEliminarRegistro($id = 0)
	{

		$bolReturn = array();
		if ($id > 0) {
			$bolValidarEliminar = $this->fncEliminarBD($id);
			if ($bolValidarEliminar) {

				$dtHorarioTrabajador = $this->fncListarRegistroHorarioTrabajadorAuditoria($id);
				$bolReturn = $dtHorarioTrabajador;

				$auditorioController = new AuditoriaController();
				$auditoria = $auditorioController->fncGuardar(2, 'horario_trabajador', 'id_horario_trabajador', $id, json_encode($dtHorarioTrabajador));
			}
		}
		return array_shift($bolReturn);
	}

	//=======================================================================================
	//FUNCIONES BASE DE DATOS
	//=======================================================================================

	private function fncBuscarRegistroTrabajadorHorarioBD($id = -1)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT	ht.id_trabajador 
		FROM escalafon.horario_trabajador AS ht
		WHERE (ht.id_trabajador = :id_trabajador) AND ht.eliminado = 0
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_trabajador', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new HorarioTrabajador;
				$temp->idTrabajador 	        	= $datos['id_trabajador'];
			
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}


	private function fncObtenerRegistroBD($id)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			ht.id_horario_trabajador,
			pn.nombres||\' \'||pn.apellidos AS nombre_completo,
			p.documento_identidad,
			ht.id_trabajador,
			ht.id_trabajador_reloj,
			ht.hora_ingreso,
			ht.hora_salida,
			ht.hora_salida - ht.hora_ingreso AS horas_trabajo,
				(SELECT	a.fecha_hora AS fecha_hora_auditoria FROM escalafon.auditoria  AS a WHERE ( a.id_operacion = 1 OR a.id_operacion = 2 )
					AND a.tabla = \'horario_trabajador\' AND a.objeto_id_nombre = \'id_horario_trabajador\' AND a.objeto_id_valor = ht.id_horario_trabajador
					ORDER BY a.id_auditoria DESC LIMIT 1 ),
				(SELECT
							pn.nombre_completo  AS usuario_auditoria
						FROM adm.usuario u
						LEFT JOIN public.persona_natural pn ON pn.id_persona = u.id_persona
						WHERE u.id_usuario = (SELECT	aa.id_usuario	FROM escalafon.auditoria  AS aa WHERE ( aa.id_operacion = 1 OR aa.id_operacion = 2 )
						AND aa.tabla = \'horario_trabajador\' AND aa.objeto_id_nombre = \'id_horario_trabajador\' AND aa.objeto_id_valor = ht.id_horario_trabajador
						ORDER BY aa.id_auditoria DESC LIMIT 1)),
			ht.eliminado,
			ht.actual
		FROM
			escalafon.horario_trabajador AS ht
			INNER JOIN escalafon.trabajador AS t ON t.id_trabajador = ht.id_trabajador 
			INNER JOIN "public".persona AS p ON p.id_persona = t.id_trabajador
			INNER JOIN "public".persona_natural AS pn ON pn.id_persona = p.id_persona
		WHERE (ht.id_horario_trabajador = :id_horario_trabajador AND ht.eliminado = 0 ) 
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_horario_trabajador', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new HorarioTrabajador;
				$temp->idHorarioTrabajador 	    = $datos['id_horario_trabajador'];
				$temp->nombreCompleto 	    	= $datos['nombre_completo'];
				$temp->documentoIdentidad 	    = $datos['documento_identidad'];
				$temp->idTrabajador 			= $datos['id_trabajador'];
				$temp->horaIngreso 				= $datos['hora_ingreso'];
				$temp->horaSalida				= $datos['hora_salida'];
				$temp->horasTrabajo				= $datos['horas_trabajo'];
				$temp->eliminado				= $datos['eliminado'];
				$temp->actual					= $datos['actual'];
				$temp->idTrabajadorReloj		= $datos['id_trabajador_reloj'];
				$temp->fechahoraAuditoria		= $datos['fecha_hora_auditoria'];
				$temp->usuarioAuditoria			= $datos['usuario_auditoria'];
			
				
				
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}

	
	private function fncBuscarRegistroTrabajadorHorarioRelojBD($id = -1)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			ht.id_trabajador_reloj
		FROM
			escalafon.horario_trabajador AS ht
		WHERE (ht.id_trabajador_reloj = :id_trabajador_reloj) AND ht.eliminado = 0
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_trabajador_reloj', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new HorarioTrabajador;
				$temp->idTrabajadorReloj 	        	= $datos['id_trabajador_reloj'];
			
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}

	private function fncBuscarRegistroTrabajadorHorarioRelojActualizarBD($id = -1,$idHorarioTrabajador =-1)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			ht.id_trabajador_reloj
		FROM
			escalafon.horario_trabajador AS ht
		WHERE (ht.id_trabajador_reloj = :id_trabajador_reloj) AND ht.eliminado = 0 AND ht.id_horario_trabajador NOT IN(:id_horario_trabajador) and ht.actual = 1
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_trabajador_reloj', $id);
			$statement->bindParam('id_horario_trabajador', $idHorarioTrabajador);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new HorarioTrabajador;
				$temp->idTrabajadorReloj 	        	= $datos['id_trabajador_reloj'];
			
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}

	private function fncListarRegistrosBD($id = -1)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			ht.id_horario_trabajador,
			ht.id_trabajador,
			ht.hora_ingreso,
			ht.hora_salida,
			ht.eliminado,
			ht.id_trabajador_reloj
		FROM
			escalafon.horario_trabajador AS ht
		WHERE (:id_horario_trabajador = -1 OR ht.id_horario_trabajador = :id_horario_trabajador) AND ht.eliminado = 0
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_horario_trabajador', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new HorarioTrabajador;
				$temp->idHorarioTrabajador 	    = $datos['id_horario_trabajador'];
				$temp->idTrabajador 			= $datos['id_trabajador'];
				$temp->horaIngreso 				= $datos['hora_ingreso'];
				$temp->horaSalida				= $datos['hora_salida'];
				$temp->eliminado				= $datos['eliminado'];
				$temp->idTrabajadorReloj		= $datos['id_trabajador_reloj'];
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}
	
	private function fncListarRegistrosAuditoriaBD($id = -1)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			ht.id_horario_trabajador,
			ht.id_trabajador,
			ht.hora_ingreso,
			ht.hora_salida,
			ht.eliminado,
			ht.id_trabajador_reloj
		FROM
			escalafon.horario_trabajador AS ht
		WHERE (:id_horario_trabajador = -1 OR ht.id_horario_trabajador = :id_horario_trabajador)
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_horario_trabajador', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new HorarioTrabajador;
				$temp->idHorarioTrabajador 	    = $datos['id_horario_trabajador'];
				$temp->idTrabajador 			= $datos['id_trabajador'];
				$temp->horaIngreso 				= $datos['hora_ingreso'];
				$temp->horaSalida				= $datos['hora_salida'];
				$temp->eliminado				= $datos['eliminado'];
				$temp->idTrabajadorReloj		= $datos['id_trabajador_reloj'];
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}
	private function fncBuscarPorIdTrabajadorBD($idTrabajador)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			ht.id_horario_trabajador,
			pn.nombres||\' \'||pn.apellidos AS nombre_completo,
			p.documento_identidad,
			ht.id_trabajador,
			ht.id_trabajador_reloj,
			ht.hora_ingreso,
			ht.hora_salida,
			ht.hora_salida - ht.hora_ingreso AS horas_trabajo,
				(SELECT	a.fecha_hora AS fecha_hora_auditoria FROM escalafon.auditoria  AS a WHERE ( a.id_operacion = 1 OR a.id_operacion = 2 )
					AND a.tabla = \'horario_trabajador\' AND a.objeto_id_nombre = \'id_horario_trabajador\' AND a.objeto_id_valor = ht.id_horario_trabajador
					ORDER BY a.id_auditoria DESC LIMIT 1 ),
				(SELECT
							pn.nombre_completo  AS usuario_auditoria
						FROM adm.usuario u
						LEFT JOIN public.persona_natural pn ON pn.id_persona = u.id_persona
						WHERE u.id_usuario = (SELECT	aa.id_usuario	FROM escalafon.auditoria  AS aa WHERE ( aa.id_operacion = 1 OR aa.id_operacion = 2 )
						AND aa.tabla = \'horario_trabajador\' AND aa.objeto_id_nombre = \'id_horario_trabajador\' AND aa.objeto_id_valor = ht.id_horario_trabajador
						ORDER BY aa.id_auditoria DESC LIMIT 1)),
			ht.eliminado,
			ht.actual
		FROM
			escalafon.horario_trabajador AS ht
			INNER JOIN escalafon.trabajador AS t ON t.id_trabajador = ht.id_trabajador 
			INNER JOIN "public".persona AS p ON p.id_persona = t.id_trabajador
			INNER JOIN "public".persona_natural AS pn ON pn.id_persona = p.id_persona
		WHERE (ht.id_trabajador = :id_trabajador AND ht.eliminado = 0 ) 
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_trabajador', $idTrabajador);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new HorarioTrabajador;
				$temp->idHorarioTrabajador 	    = $datos['id_horario_trabajador'];
				$temp->nombreCompleto 	    	= $datos['nombre_completo'];
				$temp->documentoIdentidad 	    = $datos['documento_identidad'];
				$temp->idTrabajador 			= $datos['id_trabajador'];
				$temp->horaIngreso 				= $datos['hora_ingreso'];
				$temp->horaSalida				= $datos['hora_salida'];
				$temp->horasTrabajo				= $datos['horas_trabajo'];
				$temp->eliminado				= $datos['eliminado'];
				$temp->actual					= $datos['actual'];
				$temp->idTrabajadorReloj		= $datos['id_trabajador_reloj'];
				$temp->fechahoraAuditoria		= $datos['fecha_hora_auditoria'];
				$temp->usuarioAuditoria			= $datos['usuario_auditoria'];
				
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}



	public function fncRegistrarBD($dtModel)
	{
		//$idMerito = $dtModel->setIdHorarioTrabajador();
		$idTrabajador 			= $dtModel->getIdTrabajador();
		$idTrabajadorReloj 		= $dtModel->getIdTrabajadorReloj();
		$horaIngreso 			= $dtModel->getHoraIngreso();
		$horaSalida 			= $dtModel->getHoraSalida();


		$sql = cls_control::get_instancia();
		$consulta = "INSERT INTO escalafon.horario_trabajador
					(
						-- id_horario_trabajador -- this column value is auto-generated
						id_trabajador,
						hora_ingreso,
						hora_salida,
						eliminado,
						id_trabajador_reloj,
						actual
					)
					VALUES
					(
						:id_trabajador,
						:hora_ingreso,
						:hora_salida,
						0,
						:id_trabajador_reloj,
						1
					)
				   RETURNING id_horario_trabajador";
		$statement = $sql->preparar($consulta);
		if ($statement != false) {
			$statement->bindParam("id_trabajador", $idTrabajador);
			$statement->bindParam("hora_ingreso", $horaIngreso);
			$statement->bindParam("hora_salida", $horaSalida);
			$statement->bindParam("id_trabajador_reloj", $idTrabajadorReloj);
			$sql->ejecutar();
			$datos = $statement->fetch(PDO::FETCH_ASSOC);
			if ($datos) {
				//_Retorno de Datos
				$dtModel->setIdHorarioTrabajador($datos["id_horario_trabajador"]);

				//_Cerrar
				$sql->cerrar();
				return $dtModel;
			} else {
				$sql->cerrar();
				return false;
			}
		} else {
			return false;
		}
	}

	public function fncActualizarBD($dtModel)
	{
		$idHorarioTrabajador 	= $dtModel->getIdHorarioTrabajador();
		//$idTrabajador 			= $dtModel->getIdTrabajador();
		$idTrabajadorReloj 		= $dtModel->getIdTrabajadorReloj();
		$horaIngreso 			= $dtModel->getHoraIngreso();
		$horaSalida 			= $dtModel->getHoraSalida();
	
	
		$sql = cls_control::get_instancia();
		$query = "
				UPDATE escalafon.horario_trabajador
				SET
					
					hora_ingreso = :hora_ingreso ,
					hora_salida = :hora_salida ,
					id_trabajador_reloj = :id_trabajador_reloj
				WHERE id_horario_trabajador = :id_horario_trabajador";
		$statement = $sql->preparar($query);
		if ($statement != false) {
			$statement->bindParam("id_horario_trabajador", $idHorarioTrabajador);
			$statement->bindParam("hora_ingreso", $horaIngreso);
			$statement->bindParam("hora_salida", $horaSalida);
			$statement->bindParam("id_trabajador_reloj", $idTrabajadorReloj);
		

			$sql->ejecutar();
			$rs = $statement->fetchAll(PDO::FETCH_OBJ);
			if ($rs) {
				$sql->cerrar();
				return $dtModel;
			} else {
				$sql->cerrar();
				return false;
			}
		}
	}



	public function fncActualizarActualBD($dtModel)
	{
		$idTrabajador 	= $dtModel->getIdTrabajador();
	
		$sql = cls_control::get_instancia();
		$query = "					
				UPDATE escalafon.horario_trabajador
				SET				
					actual = 0
				WHERE id_trabajador = :id_trabajador";
		$statement = $sql->preparar($query);
		if ($statement != false) {
			$statement->bindParam('id_trabajador', $idTrabajador);
			$sql->ejecutar();
			$rs = $statement->fetchAll(PDO::FETCH_OBJ);
			if ($rs) {
				$sql->cerrar();
				return $dtModel;
			} else {
				$sql->cerrar();
				return false;
			}
		}
	}


	private function fncEliminarBD($id)
	{
		$bolReturn = false;
		$sql = cls_control::get_instancia();
		$consulta = 'UPDATE escalafon.horario_trabajador
		SET		
			eliminado = 1
		WHERE id_horario_trabajador = :id_horario_trabajador';
		$statement = $sql->preparar($consulta);
		if ($statement != false) {
			$statement->bindParam('id_horario_trabajador', $id);
			$sql->ejecutar();
			$datos = $statement->fetchAll(PDO::FETCH_OBJ);
			if ($datos) {
				$bolReturn = true;
			}
			$sql->cerrar();
		}
		return $bolReturn;
	}
}
///////////////////////////////////////////////////////////////////////////////Funciones Custom
