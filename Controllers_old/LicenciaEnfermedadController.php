<?php
require_once '../../App/Escalafon/Models/LicenciaEnfermedad.php';
require_once '../../App/General/Models/Persona.php';
require_once '../../App/Escalafon/Controllers/AuditoriaController.php';
require_once '../../App/Config/control.php';
require_once '../../App/Public/archivo.php';
require_once '../../App/Public/rutas.php';


class LicenciaEnfermedadController extends LicenciaEnfermedad
{
	//=======================================================================================
	//FUNCIONES LOGICA
	//=======================================================================================


	public function fncObtenerRegistro($id)
	{

		$dtReturn = array();
		$dtListado = $this->fncObtenerRegistroBD($id);
		$clsAuditoriaController = new AuditoriaController();
		$accion =4;
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){		
				$model = array();				
				$model["documentoIdentidad"]        = $listado->documentoIdentidad;
				$model["nombreCompleto"]        	= $listado->nombreCompleto;
				$model["idLicenciaEnfermedad"]  	= $listado->idLicenciaEnfermedad;
				$model["idTrabajador"]         		= $listado->idTrabajador;
				$model["idServicio"]         		= $listado->idServicio;
				$model["servicio"]         			= $listado->servicio;
				$model["idTipoAtencion"]   			= $listado->idTipoAtencion;
				$model["tipoAtencion"]   			= $listado->tipoAtencion;
				$model["idContingencia"]  			= $listado->idContingencia;
				$model["contingencia"]  			= $listado->contingencia;
				$model["citt"]         				= $listado->citt;
				$model["fechaInicio"]            	= $listado->fechaInicio;
				$model["fechaTermino"]          	= $listado->fechaTermino;
				$model["dias"]         				= $listado->dias;
				$model["archivo"]		            = $listado->archivo;
				$model["eliminado"]		            = $listado->eliminado;
				$model["fechaHoraAuditoria"]		= $listado->fechaHoraAuditoria;
				$model["usuarioAuditoria"]		    = $listado->usuarioAuditoria;	
				array_push($dtReturn, $model);				
			}

	

			$auditorioController = new AuditoriaController();	
			$auditoria = $auditorioController->fncGuardar($accion, 'licencia_enfermedad','id_licencia_enfermedad',$model["idLicenciaEnfermedad"], json_encode($model) );

		}
		return array_shift($dtReturn);

	}


	public function fncObtenerRegistroAuditoria($id)
	{

		$dtReturn = array();
		$dtListado = $this->fncObtenerRegistroAuditoriaBD($id);
		$clsAuditoriaController = new AuditoriaController();
		$accion =4;
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){		
				$model = array();				
				$model["documentoIdentidad"]        = $listado->documentoIdentidad;
				$model["nombreCompleto"]        	= $listado->nombreCompleto;
				$model["idLicenciaEnfermedad"]  	= $listado->idLicenciaEnfermedad;
				$model["idTrabajador"]         		= $listado->idTrabajador;
				$model["idServicio"]         		= $listado->idServicio;
				$model["servicio"]         			= $listado->servicio;
				$model["idTipoAtencion"]   			= $listado->idTipoAtencion;
				$model["tipoAtencion"]   			= $listado->tipoAtencion;
				$model["idContingencia"]  			= $listado->idContingencia;
				$model["contingencia"]  			= $listado->contingencia;
				$model["citt"]         				= $listado->citt;
				$model["fechaInicio"]            	= $listado->fechaInicio;
				$model["fechaTermino"]          	= $listado->fechaTermino;
				$model["dias"]         				= $listado->dias;
				$model["archivo"]		            = $listado->archivo;
				$model["eliminado"]		            = $listado->eliminado;
				$model["fechaHoraAuditoria"]		= $listado->fechaHoraAuditoria;
				$model["usuarioAuditoria"]		    = $listado->usuarioAuditoria;	
				array_push($dtReturn, $model);				
			}


		}
		return array_shift($dtReturn);

    }
    
    public function fncObtenerRegistroPorDniTrabajador($dni)
    {
		$dtReturn = array();
        $dtTrabajador = $this->fncObtenerTrabajadorPorDniBD($dni);

		if(fncGeneralValidarDataArray($dtTrabajador)){
			
			$model_persona = array();
			$model_persona["id_persona"] 		  = $dtTrabajador[0]->idPersona;
	        $model_persona["id_tipo_documento_identidad"]   = $dtTrabajador[0]->idTipoDocumentoIdentidad;
	        $model_persona["id_ubigeo"] 		  = $dtTrabajador[0]->idUbigeo;
	        $model_persona["tipo"] 				  = $dtTrabajador[0]->tipo;     
	        $model_persona["documento_identidad"] = $dtTrabajador[0]->documentoIdentidad;  
	        $model_persona["domicilio"] 		  = $dtTrabajador[0]->domicilio;  
	        $model_persona["telefono"] 			  = $dtTrabajador[0]->telefono;  
	        $model_persona["correo_electronico"]  = $dtTrabajador[0]->correoElectronico;  
	        $model_persona["fecha_creacion"] 	  = $dtTrabajador[0]->fechaCreacion;  
	        $model_persona["fecha_modificacion"]  = $dtTrabajador[0]->fechaModificacion;

			$dtListado = $this->fncListarRegistroPorIdTrabajador($dtTrabajador[0]->idPersona);
			$dtReturn['persona'] = $model_persona;
			$dtReturn['licencias'] = $dtListado;
			
		}
		return $dtReturn;
    }

	public function fncObtenerRegistroPorNombreTrabajador($nombreCompleto)
    {
		$dtReturn = array();
        $dtTrabajador = $this->fncObtenerTrabajadorPorNombreBD($nombreCompleto);
		if(fncGeneralValidarDataArray($dtTrabajador)){
			$model_persona = array();
			$model_persona["id_persona"] 		  = $dtTrabajador[0]->idPersona;
	        $model_persona["id_tipo_documento_identidad"]   = $dtTrabajador[0]->idTipoDocumentoIdentidad;
	        $model_persona["id_ubigeo"] 		  = $dtTrabajador[0]->idUbigeo;
	        $model_persona["tipo"] 				  = $dtTrabajador[0]->tipo;     
	        $model_persona["documento_identidad"] = $dtTrabajador[0]->documentoIdentidad;  
	        $model_persona["domicilio"] 		  = $dtTrabajador[0]->domicilio;  
	        $model_persona["telefono"] 			  = $dtTrabajador[0]->telefono;  
	        $model_persona["correo_electronico"]  = $dtTrabajador[0]->correoElectronico;  
	        $model_persona["fecha_creacion"] 	  = $dtTrabajador[0]->fechaCreacion;  
	        $model_persona["fecha_modificacion"]  = $dtTrabajador[0]->fechaModificacion;


			$dtListado = $this->fncListarRegistroPorIdTrabajador($dtTrabajador[0]->idPersona);

			$dtReturn['persona'] = $model_persona;
			$dtReturn['licencias'] = $dtListado;
		}
		return ($dtReturn);
    }

	public function fncListarRegistroPorIdTrabajador($id)
	{

		$dtReturn = array();
		$listaAuditoria = array();
		$dtListado = $this->fncListarRegistroPorIdTrabajadorBD($id);
		
		$accion =4;
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){		
				$model = array();				
				$model["documentoIdentidad"]        = $listado->documentoIdentidad;
				$model["nombreCompleto"]        	= $listado->nombreCompleto;
				$model["idLicenciaEnfermedad"]  	= $listado->idLicenciaEnfermedad;
				$model["idTrabajador"]         		= $listado->idTrabajador;
				$model["idServicio"]         		= $listado->idServicio;
				$model["servicio"]         			= $listado->servicio;
				$model["idTipoAtencion"]   			= $listado->idTipoAtencion;
				$model["tipoAtencion"]   			= $listado->tipoAtencion;
				$model["idContingencia"]  			= $listado->idContingencia;
				$model["contingencia"]  			= $listado->contingencia;
				$model["citt"]         				= $listado->citt;
				$model["fechaInicio"]            	= $listado->fechaInicio;
				$model["fechaTermino"]          	= $listado->fechaTermino;
				$model["dias"]         				= $listado->dias;
				$model["archivo"]		            = $listado->archivo;
				$model["eliminado"]		            = $listado->eliminado;
				$model["fechaHoraAuditoria"]		= $listado->fechaHoraAuditoria;
				$model["usuarioAuditoria"]		    = $listado->usuarioAuditoria;	
				array_push($dtReturn, $model);
				array_push($listaAuditoria, $model["documentoIdentidad"]);				
			}

	

			$auditorioController = new AuditoriaController();	
			$auditoria = $auditorioController->fncGuardar($accion, 'licencia_enfermedad','id_licencia_enfermedad',null, json_encode($listaAuditoria) );

		}
		return ($dtReturn);

	}

	public function fncGuardar($arrayInputs, $archivoInput = '')
	{
		$dtReturn = array();
		$accion = 0;
		$inputIdLicenciaEnfermedad = (Int)fncObtenerValorArray($arrayInputs, 'idLicenciaEnfermedad', true);
		$inputIdTrabajador = (Int)fncObtenerValorArray($arrayInputs, 'idTrabajador', true);
		$inputIdServicio = (Int)fncObtenerValorArray($arrayInputs, 'idServicio', true);
		$inputIdTipoAtencion = (Int)fncObtenerValorArray($arrayInputs, 'idTipoAtencion', true);
		$inputIdContingencia = (Int)fncObtenerValorArray($arrayInputs, 'idContingencia', true);
		$inputCitt	= fncObtenerValorArray($arrayInputs, 'citt', true);
		$inputFechaInicio	= fncObtenerValorArray($arrayInputs, 'fechaInicio', true);
		$inputFechaTermino	= fncObtenerValorArray($arrayInputs, 'fechaTermino', true);
		$inputDias	= fncObtenerValorArray($arrayInputs, 'dias', true);
		$inputArchivo		=  fncObtenerValorArray($arrayInputs, 'archivo', true);
		


		$dtLicenciaEnfermedad = new LicenciaEnfermedad;


		if (!empty($inputIdLicenciaEnfermedad)) {
			$dtLicenciaEnfermedad->setIdLicenciaEnfermedad($inputIdLicenciaEnfermedad);
		}
		if (!empty($inputIdTrabajador)) {
			$dtLicenciaEnfermedad->setIdTrabajador($inputIdTrabajador);
		}
		if (!empty($inputIdServicio)) {
			$dtLicenciaEnfermedad->setIdServicio($inputIdServicio);
		}
		if (!empty($inputIdTipoAtencion)) {
			$dtLicenciaEnfermedad->setIdTipoAtencion($inputIdTipoAtencion);
		}
		if (!empty($inputIdContingencia)) {
			$dtLicenciaEnfermedad->setIdContingencia($inputIdContingencia);
		}
		if (!empty($inputCitt)) {
			$dtLicenciaEnfermedad->setCitt($inputCitt);
		}
		if (!empty($inputFechaInicio)) {
			$dtLicenciaEnfermedad->setFechaInicio($inputFechaInicio);
		}
		if (!empty($inputFechaTermino)) {
			$dtLicenciaEnfermedad->setFechaTermino($inputFechaTermino);
		}
		if (!empty($inputDias)) {
			$dtLicenciaEnfermedad->setDias($inputDias);
		}
		if (!empty($inputArchivo)) {
			$dtLicenciaEnfermedad->setArchivo($inputArchivo);
		}
	

		if (fncGeneralValidarDataArray($dtLicenciaEnfermedad)) {
			$dtGuardar = array();
			$optArchivo = "";
			if ($inputIdLicenciaEnfermedad == 0 && $inputIdTrabajador != 0) {
				if (!empty($archivoInput)) {
					if ($archivoInput["name"] <> "") {
						$optRutaArchivo = cls_rutas::get('licenciaEnfermedadPdf');
						//$rutas=fncObtenerRuta();
						$nombreArchivo = fncConstruirNombreDocumentoLicenciaEnfermedad($archivoInput);
						$obj_arc = new archivo($archivoInput, $optRutaArchivo, "pdf_" . $nombreArchivo, 0);
						if ($obj_arc->subir()) {
							$optArchivo = $obj_arc->get_nombre_archivo();
							$dtLicenciaEnfermedad->setArchivo($optRutaArchivo.$obj_arc->get_nombre_archivo());
						}
					}
				}
				$dtGuardar = $this->fncRegistrarBD($dtLicenciaEnfermedad);
				$accion = 1;
			} else {

				if (!empty($archivoInput)) {
					if ($archivoInput["name"] <> "") {
						$optRutaArchivo = cls_rutas::get('licenciaEnfermedadPdf');
						//$rutas=fncObtenerRuta();
						$nombreArchivo = fncConstruirNombreDocumentoLicenciaEnfermedad($archivoInput);
						$obj_arc = new archivo($archivoInput, $optRutaArchivo, "pdf_" . $nombreArchivo, 0);
						if ($obj_arc->subir()) {
							$optArchivo = $obj_arc->get_nombre_archivo();
							$dtLicenciaEnfermedad->setArchivo($optRutaArchivo.$obj_arc->get_nombre_archivo());
						}
					}
				}
				$dtGuardar = $this->fncActualizarBD($dtLicenciaEnfermedad);
				$accion = 2;
			}

			if (fncGeneralValidarDataArray($dtGuardar)) {
				$model = array();
				$model["id_licencia_enfermedad"]        	= $dtGuardar->getIdLicenciaEnfermedad();
				$model["id_trabajador"]        				= $dtGuardar->getIdTrabajador();
				$model["id_servicio"]  						= $dtGuardar->getIdServicio();
				$model["id_tipo_atencion"]         			= $dtGuardar->getIdTipoAtencion();
				$model["id_tipo_contingencia"]   			= $dtGuardar->getIdContingencia();
				$model["citt"]  							= $dtGuardar->getCitt();
				$model["fecha_inicio"]              		= $dtGuardar->getFechaInicio();
				$model["fecha_termino"]              		= $dtGuardar->getFechaTermino();
				$model["dias"]              				= $dtGuardar->getDias();
				$model["archivo"]              				= $dtGuardar->getArchivo();
				$model["eliminado"]              			= $dtGuardar->getEliminado();
				

				$auditorioController = new AuditoriaController();
				$auditoria = $auditorioController->fncGuardar($accion, 'licencia_enfermedad', 'id_licencia_enfermedad', $model["id_licencia_enfermedad"], json_encode($model));

				array_push($dtReturn, $this->fncObtenerRegistro($dtLicenciaEnfermedad->getIdLicenciaEnfermedad()));
				unset($model);
			}
		}
		return array_shift($dtReturn);
	}


	public function fncEliminarRegistro($id = 0)
	{

		$bolReturn = array();
		if ($id > 0) {
			$bolValidarEliminar = $this->fncEliminarBD($id);
			if ($bolValidarEliminar) {
				$returProcesoJudicial= ($this->fncObtenerRegistroAuditoria($id));
				$auditorioController = new AuditoriaController();
				$auditoria = $auditorioController->fncGuardar(2, 'licencia_enfermedad', 'id_licencia_enfermedad', $id, json_encode($returProcesoJudicial));
				$bolReturn = $auditoria;
			}
		}
		return $bolReturn;
	}


	//=======================================================================================
	//FUNCIONES BASE DE DATOS
	//=======================================================================================

	private function fncEliminarBD($id)
	{
		$bolReturn = false;
		$sql = cls_control::get_instancia();
		$consulta = 'UPDATE escalafon.licencia_enfermedad
		SET		
			eliminado = 1
		WHERE id_licencia_enfermedad = :id_licencia_enfermedad';
		$statement = $sql->preparar($consulta);
		if ($statement != false) {
			$statement->bindParam('id_licencia_enfermedad', $id);
			$sql->ejecutar();
			$datos = $statement->fetchAll(PDO::FETCH_OBJ);
			if ($datos) {
				$bolReturn = true;
			}
			$sql->cerrar();
		}
		return $bolReturn;
	}

	public function fncRegistrarBD($dtModel)
	{
		//$idLicenciaTrabajador = $dtModel->getIdLicenciaTrabajador();
		$idTrabajador = $dtModel->getIdTrabajador();
		$idServicio = $dtModel->getIdServicio();
		$idTipoAtencion = $dtModel->getIdTipoAtencion();
		$idContingencia = $dtModel->getIdContingencia();
		$citt = $dtModel->getCitt();
		$fechaInicio = $dtModel->getFechaInicio();
		$fechaTermino = $dtModel->getFechaTermino();
		$dias = $dtModel->getDias();
		$archivo = $dtModel->getArchivo();
		if ($archivo == '') {
			$archivo = NULL;
		}

	
		$sql = cls_control::get_instancia();
		$consulta = "INSERT INTO escalafon.licencia_enfermedad
					(
						-- id_licencia_enfermedad -- this column value is auto-generated
						id_trabajador,
						id_servicio,
						id_tipo_atencion,
						id_contingencia,
						citt,
						fecha_inicio,
						fecha_termino,
						dias,
						archivo,
						eliminado
					)
					VALUES
					(
						:id_trabajador,
						:id_servicio,
						:id_tipo_atencion,
						:id_contingencia,
						
						:citt,
						:fecha_inicio,
						:fecha_termino,
						:dias,
						:archivo,
						0
					)
				   RETURNING id_licencia_enfermedad";
		$statement = $sql->preparar($consulta);
		if ($statement != false) {
			$statement->bindParam("id_trabajador", $idTrabajador);
			$statement->bindParam("id_servicio", $idServicio);
			$statement->bindParam("id_tipo_atencion", $idTipoAtencion);
			$statement->bindParam("id_contingencia", $idContingencia);
			$statement->bindParam("citt", $citt);
			$statement->bindParam("fecha_inicio", $fechaInicio);
			$statement->bindParam("fecha_termino", $fechaTermino);
			$statement->bindParam("dias", $dias);
			$statement->bindParam("archivo", $archivo);
	
			$sql->ejecutar();
			$datos = $statement->fetch(PDO::FETCH_ASSOC);
			if ($datos) {
				//_Retorno de Datos
				$dtModel->setIdLicenciaEnfermedad($datos["id_licencia_enfermedad"]);

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
		$idLicenciaEnfermedad 	= $dtModel ->getIdLicenciaEnfermedad();
		$idTrabajador 			= $dtModel->getIdTrabajador();
		$idServicio 			= $dtModel->getIdServicio();
		$idTipoAtencion 		= $dtModel->getIdTipoAtencion();
		$idContingencia 		= $dtModel->getIdContingencia();
		$citt 					= $dtModel->getCitt();
		$fechaInicio			= $dtModel->getFechaInicio();
		$fechaTermino 			= $dtModel->getFechaTermino();
		$dias 					= $dtModel->getDias();
		$archivo 				= $dtModel->getArchivo();
		$modificarArchivoScript = '';
		if ($archivo != '') {
			$modificarArchivoScript = ',archivo = :archivo';
		}

		$sql = cls_control::get_instancia();
		$query = "UPDATE escalafon.licencia_enfermedad
		SET
			-- id_licencia_enfermedad -- this column value is auto-generated
			id_trabajador = :id_trabajador ,
			id_servicio = :id_servicio,
			id_tipo_atencion = :id_tipo_atencion,
			id_contingencia = :id_contingencia,
			citt = :citt ,
			fecha_inicio = :fecha_inicio,
			fecha_termino = :fecha_termino,
			dias = :dias" . $modificarArchivoScript . "
				WHERE id_licencia_enfermedad = :id_licencia_enfermedad";
		$statement = $sql->preparar($query);
		if ($statement != false) {
			$statement->bindParam("id_licencia_enfermedad", $idLicenciaEnfermedad);
			$statement->bindParam("id_trabajador", $idTrabajador);
			$statement->bindParam("id_servicio", $idServicio);
			$statement->bindParam("id_tipo_atencion", $idTipoAtencion);
			$statement->bindParam("id_contingencia", $idContingencia);
			$statement->bindParam("citt", $citt);
			$statement->bindParam("fecha_inicio", $fechaInicio);
			$statement->bindParam("fecha_termino", $fechaTermino);
			$statement->bindParam("dias", $dias);
			
			if ($archivo != '') {
				$statement->bindParam("archivo", $archivo);
			}

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

	private function fncObtenerRegistroBD($id)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			pn.nombres ||\' \'||pn.apellidos nombre_completo ,
			p.documento_identidad,
			le.id_licencia_enfermedad,
			le.id_trabajador,
			le.id_servicio,
			(SELECT	s.servicio	 FROM 	escalafon.servicio AS s WHERE s.id_servicio = le.id_servicio),
			le.id_tipo_atencion,
			(SELECT	ta.tipo_atencion	 FROM 	escalafon.tipo_atencion AS ta WHERE ta.id_tipo_atencion = le.id_tipo_atencion),
			le.id_contingencia,
			(SELECT	co.contingencia	 FROM 	escalafon.contingencia AS co WHERE co.id_contigencia = le.id_contingencia),
			le.citt,
			le.fecha_inicio,
			le.fecha_termino,
			le.dias,
			le.archivo,
			le.eliminado,
			(SELECT	a.fecha_hora FROM escalafon.auditoria  AS a WHERE ( a.id_operacion = 1 OR a.id_operacion = 2 )
			AND a.tabla = \'licencia_enfermedad\' AND a.objeto_id_nombre = \'id_licencia_enfermedad\' AND a.objeto_id_valor = le.id_licencia_enfermedad
			ORDER BY a.id_auditoria DESC LIMIT 1 ),
			(SELECT
			pn.nombre_completo  AS usuario_auditoria
			FROM adm.usuario u
			LEFT JOIN public.persona_natural pn ON pn.id_persona = u.id_persona
			WHERE u.id_usuario = (SELECT	aa.id_usuario	FROM escalafon.auditoria  AS aa WHERE ( aa.id_operacion = 1 OR aa.id_operacion = 2 )
			AND aa.tabla = \'licencia_enfermedad\' AND aa.objeto_id_nombre = \'id_licencia_enfermedad\' AND aa.objeto_id_valor = le.id_licencia_enfermedad
			ORDER BY aa.id_auditoria DESC LIMIT 1))
		FROM
			escalafon.licencia_enfermedad AS le
			INNER JOIN escalafon.trabajador AS t ON t.id_trabajador = le.id_trabajador
			INNER JOIN "public".persona AS p ON p.id_persona = t.id_trabajador
			INNER JOIN "public".persona_natural AS pn ON pn.id_persona = p.id_persona
			
		WHERE le.eliminado = 0 AND le.id_licencia_enfermedad = :id_licencia_enfermedad
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_licencia_enfermedad', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new LicenciaEnfermedad;
				$temp->documentoIdentidad      	= $datos['documento_identidad'];
				$temp->nombreCompleto     		= $datos['nombre_completo'];
				$temp->idLicenciaEnfermedad	 	= $datos['id_licencia_enfermedad'];
				$temp->idTrabajador 			= $datos['id_trabajador'];
				$temp->idServicio				= $datos['id_servicio'];
				$temp->servicio					= $datos['servicio'];
				$temp->idTipoAtencion 			= $datos['id_tipo_atencion'];
				$temp->tipoAtencion 			= $datos['tipo_atencion'];
				$temp->idContingencia 			= $datos['id_contingencia'];
				$temp->contingencia 			= $datos['contingencia'];
				$temp->citt 					= $datos['citt'];
				$temp->fechaInicio 				= $datos['fecha_inicio'];
				$temp->fechaTermino 			= $datos['fecha_termino'];				
				$temp->dias						= $datos['dias'];
				$temp->archivo					= $datos['archivo'];
				$temp->eliminado				= $datos['eliminado'];
				$temp->fechaHoraAuditoria		= $datos['fecha_hora'];
				$temp->usuarioAuditoria			= $datos['usuario_auditoria'];

				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}

	private function fncObtenerRegistroAuditoriaBD($id)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			pn.nombres ||\' \'||pn.apellidos nombre_completo ,
			p.documento_identidad,
			le.id_licencia_enfermedad,
			le.id_trabajador,
			le.id_servicio,
			(SELECT	s.servicio	 FROM 	escalafon.servicio AS s WHERE s.id_servicio = le.id_servicio),
			le.id_tipo_atencion,
			(SELECT	ta.tipo_atencion	 FROM 	escalafon.tipo_atencion AS ta WHERE ta.id_tipo_atencion = le.id_tipo_atencion),
			le.id_contingencia,
			(SELECT	co.contingencia	 FROM 	escalafon.contingencia AS co WHERE co.id_contigencia = le.id_contingencia),
			le.citt,
			le.fecha_inicio,
			le.fecha_termino,
			le.dias,
			le.archivo,
			le.eliminado,
			(SELECT	a.fecha_hora FROM escalafon.auditoria  AS a WHERE ( a.id_operacion = 1 OR a.id_operacion = 2 )
			AND a.tabla = \'licencia_enfermedad\' AND a.objeto_id_nombre = \'id_licencia_enfermedad\' AND a.objeto_id_valor = le.id_licencia_enfermedad
			ORDER BY a.id_auditoria DESC LIMIT 1 ),
			(SELECT
			pn.nombre_completo  AS usuario_auditoria
			FROM adm.usuario u
			LEFT JOIN public.persona_natural pn ON pn.id_persona = u.id_persona
			WHERE u.id_usuario = (SELECT	aa.id_usuario	FROM escalafon.auditoria  AS aa WHERE ( aa.id_operacion = 1 OR aa.id_operacion = 2 )
			AND aa.tabla = \'licencia_enfermedad\' AND aa.objeto_id_nombre = \'id_licencia_enfermedad\' AND aa.objeto_id_valor = le.id_licencia_enfermedad
			ORDER BY aa.id_auditoria DESC LIMIT 1))
		FROM
			escalafon.licencia_enfermedad AS le
			INNER JOIN escalafon.trabajador AS t ON t.id_trabajador = le.id_trabajador
			INNER JOIN "public".persona AS p ON p.id_persona = t.id_trabajador
			INNER JOIN "public".persona_natural AS pn ON pn.id_persona = p.id_persona
			
		WHERE le.id_licencia_enfermedad = :id_licencia_enfermedad
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_licencia_enfermedad', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new LicenciaEnfermedad;
				$temp->documentoIdentidad      	= $datos['documento_identidad'];
				$temp->nombreCompleto     		= $datos['nombre_completo'];
				$temp->idLicenciaEnfermedad	 	= $datos['id_licencia_enfermedad'];
				$temp->idTrabajador 			= $datos['id_trabajador'];
				$temp->idServicio				= $datos['id_servicio'];
				$temp->servicio					= $datos['servicio'];
				$temp->idTipoAtencion 			= $datos['id_tipo_atencion'];
				$temp->tipoAtencion 			= $datos['tipo_atencion'];
				$temp->idContingencia 			= $datos['id_contingencia'];
				$temp->contingencia 			= $datos['contingencia'];
				$temp->citt 					= $datos['citt'];
				$temp->fechaInicio 				= $datos['fecha_inicio'];
				$temp->fechaTermino 			= $datos['fecha_termino'];				
				$temp->dias						= $datos['dias'];
				$temp->archivo					= $datos['archivo'];
				$temp->eliminado				= $datos['eliminado'];
				$temp->fechaHoraAuditoria		= $datos['fecha_hora'];
				$temp->usuarioAuditoria			= $datos['usuario_auditoria'];

				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}


    private function fncObtenerTrabajadorPorDniBD($dni)
    {
		$query = "
			SELECT * 
			FROM  public.persona as pe
			WHERE pe.tipo = 'N'
			AND pe.documento_identidad = :documento_identidad
			";
		
		$sql = cls_control::get_instancia();
		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('documento_identidad', $dni);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new stdClass; 
				$temp->idPersona 		  		= $datos["id_persona"];
				$temp->idTipoDocumentoIdentidad	= $datos["id_tipo_documento_identidad"];
				$temp->idUbigeo 		  		= $datos["id_ubigeo"];
				$temp->tipo 			  		= $datos["tipo"];
				$temp->documentoIdentidad 		= $datos["documento_identidad"];
				$temp->domicilio		  		= $datos["domicilio"];
				$temp->telefono 		  		= $datos["telefono"];
				$temp->correoElectronico  		= $datos["correo_electronico"];
				$temp->fechaCreacion 	  		= $datos["fecha_creacion"];
				$temp->fechaModificacion  		= $datos["fecha_modificacion"];
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
    }

	private function fncObtenerTrabajadorPorNombreBD($nombreCompleto)
    {
        $sql = cls_control::get_instancia();
		$query = "
					SELECT pe.* 
					FROM  public.persona as pe
					INNER JOIN public.persona_natural as pn
					ON pe.id_persona = pn.id_persona
					WHERE pe.tipo = 'N' 
					AND UPPER(pn.nombre_completo) = UPPER(:nombre_completo)
				";

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('nombre_completo', $nombreCompleto);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new stdClass; 
				$temp->idPersona 		  		= $datos["id_persona"];
				$temp->idTipoDocumentoIdentidad	= $datos["id_tipo_documento_identidad"];
				$temp->idUbigeo 		  		= $datos["id_ubigeo"];
				$temp->tipo 			  		= $datos["tipo"];
				$temp->documentoIdentidad 		= $datos["documento_identidad"];
				$temp->domicilio		  		= $datos["domicilio"];
				$temp->telefono 		  		= $datos["telefono"];
				$temp->correoElectronico  		= $datos["correo_electronico"];
				$temp->fechaCreacion 	  		= $datos["fecha_creacion"];
				$temp->fechaModificacion  		= $datos["fecha_modificacion"];
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
    }

	
	private function fncListarRegistroPorIdTrabajadorBD($id)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			pn.nombres ||\' \'||pn.apellidos nombre_completo ,
			p.documento_identidad,
			le.id_licencia_enfermedad,
			le.id_trabajador,
			le.id_servicio,
			(SELECT	s.servicio	 FROM 	escalafon.servicio AS s WHERE s.id_servicio = le.id_servicio),
			le.id_tipo_atencion,
			(SELECT	ta.tipo_atencion	 FROM 	escalafon.tipo_atencion AS ta WHERE ta.id_tipo_atencion = le.id_tipo_atencion),
			le.id_contingencia,
			(SELECT	co.contingencia	 FROM 	escalafon.contingencia AS co WHERE co.id_contigencia = le.id_contingencia),
			le.citt,
			le.fecha_inicio,
			le.fecha_termino,
			le.dias,
			le.archivo,
			le.eliminado,
			(SELECT	a.fecha_hora FROM escalafon.auditoria  AS a WHERE ( a.id_operacion = 1 OR a.id_operacion = 2 )
			AND a.tabla = \'licencia_enfermedad\' AND a.objeto_id_nombre = \'id_licencia_enfermedad\' AND a.objeto_id_valor = le.id_licencia_enfermedad
			ORDER BY a.id_auditoria DESC LIMIT 1 ),
			(SELECT
			pn.nombre_completo  AS usuario_auditoria
			FROM adm.usuario u
			LEFT JOIN public.persona_natural pn ON pn.id_persona = u.id_persona
			WHERE u.id_usuario = (SELECT	aa.id_usuario	FROM escalafon.auditoria  AS aa WHERE ( aa.id_operacion = 1 OR aa.id_operacion = 2 )
			AND aa.tabla = \'licencia_enfermedad\' AND aa.objeto_id_nombre = \'id_licencia_enfermedad\' AND aa.objeto_id_valor = le.id_licencia_enfermedad
			ORDER BY aa.id_auditoria DESC LIMIT 1))
		FROM
			escalafon.licencia_enfermedad AS le
			INNER JOIN escalafon.trabajador AS t ON t.id_trabajador = le.id_trabajador
			INNER JOIN "public".persona AS p ON p.id_persona = t.id_trabajador
			INNER JOIN "public".persona_natural AS pn ON pn.id_persona = p.id_persona
			
		WHERE le.eliminado = 0 AND le.id_trabajador = :id_trabajador
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_trabajador', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new LicenciaEnfermedad;
				$temp->documentoIdentidad      	= $datos['documento_identidad'];
				$temp->nombreCompleto     		= $datos['nombre_completo'];
				$temp->idLicenciaEnfermedad	 	= $datos['id_licencia_enfermedad'];
				$temp->idTrabajador 			= $datos['id_trabajador'];
				$temp->idServicio				= $datos['id_servicio'];
				$temp->servicio					= $datos['servicio'];
				$temp->idTipoAtencion 			= $datos['id_tipo_atencion'];
				$temp->tipoAtencion 			= $datos['tipo_atencion'];
				$temp->idContingencia 			= $datos['id_contingencia'];
				$temp->contingencia 			= $datos['contingencia'];
				$temp->citt 					= $datos['citt'];
				$temp->fechaInicio 				= $datos['fecha_inicio'];
				$temp->fechaTermino 			= $datos['fecha_termino'];				
				$temp->dias						= $datos['dias'];
				$temp->archivo					= $datos['archivo'];
				$temp->eliminado				= $datos['eliminado'];
				$temp->fechaHoraAuditoria		= $datos['fecha_hora'];
				$temp->usuarioAuditoria			= $datos['usuario_auditoria'];

				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}



} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom
function fncConstruirNombreDocumentoLicenciaEnfermedad($archivo)
{
	$nombre = fncQuitarExtensionDocumentoLicenciaEnfermedad($archivo['name']) . '_' . uniqid() . '_';
	return $nombre;
}
function fncQuitarExtensionDocumentoLicenciaEnfermedad($string)
{
	$a = explode('.', $string);
	array_pop($a);
	return implode('.', $a);
}