<?php
require_once '../../App/Escalafon/Models/ProcesoJudicial.php';
require_once '../../App/Escalafon/Controllers/AuditoriaController.php';
require_once '../../App/Config/control.php';
require_once '../../App/Public/archivo.php';
require_once '../../App/Public/rutas.php';

class ProcesoJudicialController extends ProcesoJudicial
{
	//=======================================================================================
	//FUNCIONES LOGICA
	//=======================================================================================

	public function fncListarRegistroPorIdTrabajador($id)
	{

		$dtReturn = array();
		$listaAuditoria = array();
		$dtListado = $this->fncObtenerRegistroPoridTrabajadorBD($id);
		
		$accion =4;
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){		
				$model = array();				
				$model["documentoIdentidad"]       	= $listado->documentoIdentidad;
				$model["nombreCompleto"]        	= $listado->nombreCompleto;
				$model["idProcesoJudicial"]  		= $listado->idProcesoJudicial;
				$model["idTrabajador"]         		= $listado->idTrabajador;
				$model["idTipoAccion"]   			= $listado->idTipoAccion;
				$model["tipoAccion"]  				= $listado->tipoAccion;
				$model["idTipoDocumento"]         	= $listado->idTipoDocumento;
				$model["tipoDocumento"]            	= $listado->tipoDocumento;
				$model["asunto"]          			= $listado->asunto;
				$model["observacion"]         		= $listado->observacion;
				$model["archivo"]		            = $listado->archivo;
				$model["eliminado"]		            = $listado->eliminado;
				$model["fechaHoraAuditoria"]		= $listado->fechaHoraAuditoria;
				$model["usuarioAuditoria"]		    = $listado->usuarioAuditoria;
	
				array_push($dtReturn, $model);
				array_push($listaAuditoria, $model["documentoIdentidad"]);
			}


			$auditorioController = new AuditoriaController();	
			$auditoria = $auditorioController->fncGuardar($accion, 'proceso_judicial','id_proceso_judicial', null, json_encode($listaAuditoria) );

		}
		return ($dtReturn);
	}

	

	public function fncObtenerRegistro($id)
	{

		$dtReturn = array();
		$dtListado = $this->fncObtenerRegistroBD($id);
		$clsAuditoriaController = new AuditoriaController();
		$accion =4;
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){		
				$model = array();				
				$model["documentoIdentidad"]       = $listado->documentoIdentidad;
				$model["nombreCompleto"]        	= $listado->nombreCompleto;
				$model["idProcesoJudicial"]  	= $listado->idProcesoJudicial;
				$model["idTrabajador"]         		= $listado->idTrabajador;
				$model["idTipoAccion"]   			= $listado->idTipoAccion;
				$model["tipoAccion"]  				= $listado->tipoAccion;
				$model["idTipoDocumento"]         = $listado->idTipoDocumento;
				$model["tipoDocumento"]            = $listado->tipoDocumento;
				$model["asunto"]          			= $listado->asunto;
				$model["observacion"]         		 = $listado->observacion;
				$model["archivo"]		            = $listado->archivo;
				$model["eliminado"]		            = $listado->eliminado;
				$model["fechaHoraAuditoria"]		        = $listado->fechaHoraAuditoria;
				$model["usuarioAuditoria"]		    = $listado->usuarioAuditoria;	
				array_push($dtReturn, $model);				
			}

			$auditorioController = new AuditoriaController();	
			$auditoria = $auditorioController->fncGuardar($accion, 'proceso_judicial','id_proceso_judicial',$model["idProcesoJudicial"], json_encode($model) );

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
			$dtReturn['procesos'] = $dtListado;
			
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
			$dtReturn['procesos'] = $dtListado;
		}
		return ($dtReturn);
    }
	
	public function fncObtenerRegistroAuditoria($id)
	{

		$dtReturn = array();
		$dtListado = $this->fncObtenerRegistroAuditoriaBD($id);
	
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){		
				$model = array();				
				$model["documentoIdentidad"]       = $listado->documentoIdentidad;
				$model["nombreCompleto"]        	= $listado->nombreCompleto;
				$model["idProcesoJudicial"]  	= $listado->idProcesoJudicial;
				$model["idTrabajador"]         		= $listado->idTrabajador;
				$model["idTipoAccion"]   			= $listado->idTipoAccion;
				$model["tipoAccion"]  				= $listado->tipoAccion;
				$model["idTipoDocumento"]         = $listado->idTipoDocumento;
				$model["tipoDocumento"]            = $listado->tipoDocumento;
				$model["asunto"]          			= $listado->asunto;
				$model["observacion"]         		 = $listado->observacion;
				$model["archivo"]		            = $listado->archivo;
				$model["eliminado"]		            = $listado->eliminado;
				$model["fechaHoraAuditoria"]		        = $listado->fechaHoraAuditoria;
				$model["usuarioAuditoria"]		    = $listado->usuarioAuditoria;	
				array_push($dtReturn, $model);				
			}

			
			

		}
		return array_shift($dtReturn);

	}

	public function fncGuardar($arrayInputs, $archivoInput = '')
	{
		$dtReturn = array();
		$accion = 0;
		$inputIdProcesoJudicial = (Int)fncObtenerValorArray($arrayInputs, 'idProcesoJudicial', true);
		$inputIdTrabajador = (Int)fncObtenerValorArray($arrayInputs, 'idTrabajador', true);
		$inputIdTipoAccion = (Int)fncObtenerValorArray($arrayInputs, 'idTipoAccion', true);
		$inputIdTipoDocumento = (Int)fncObtenerValorArray($arrayInputs, 'idTipoDocumento', true);
		$inputAsunto	= fncObtenerValorArray($arrayInputs, 'asunto', true);
		$inputObservacion	= fncObtenerValorArray($arrayInputs, 'observacion', true);
		$inputArchivo		=  fncObtenerValorArray($arrayInputs, 'archivo', true);
		

		$dtProcesoJudicial = new ProcesoJudicial;


		if (!empty($inputIdProcesoJudicial)) {
			$dtProcesoJudicial->setIdProcesoJudicial($inputIdProcesoJudicial);
		}
		if (!empty($inputIdTrabajador)) {
			$dtProcesoJudicial->setIdTrabajador($inputIdTrabajador);
		}
		if (!empty($inputIdTipoAccion)) {
			$dtProcesoJudicial->setIdTipoAccion($inputIdTipoAccion);
		}
		if (!empty($inputIdTipoDocumento)) {
			$dtProcesoJudicial->setIdTipoDocumento($inputIdTipoDocumento);
		}
		if (!empty($inputAsunto)) {
			$dtProcesoJudicial->setAsunto($inputAsunto);
		}
		if (!empty($inputObservacion)) {
			$dtProcesoJudicial->setObservacion($inputObservacion);
		}
		if (!empty($inputArchivo)) {
			$dtProcesoJudicial->setArchivo($inputArchivo);
		}
	

		if (fncGeneralValidarDataArray($dtProcesoJudicial)) {
			$dtGuardar = array();
			$optArchivo = "";
			if ($inputIdProcesoJudicial == 0 && $inputIdTrabajador != 0) {
				if (!empty($archivoInput)) {
					if ($archivoInput["name"] <> "") {
						$optRutaArchivo = cls_rutas::get('procesoJudicial');
						//$rutas=fncObtenerRuta();
						$nombreArchivo = fncConstruirNombreDocumentoProcesoJudicial($archivoInput);
						$obj_arc = new archivo($archivoInput, $optRutaArchivo, "pdf_" . $nombreArchivo, 0);
						if ($obj_arc->subir()) {
							$optArchivo = $obj_arc->get_nombre_archivo();
							$dtProcesoJudicial->setArchivo($optRutaArchivo.$obj_arc->get_nombre_archivo());
						}
					}
				}
				$dtGuardar = $this->fncRegistrarBD($dtProcesoJudicial);
				$accion = 1;
			} else {

				if (!empty($archivoInput)) {
					if ($archivoInput["name"] <> "") {
						$optRutaArchivo = cls_rutas::get('procesoJudicial');
						//$rutas=fncObtenerRuta();
						$nombreArchivo = fncConstruirNombreDocumentoProcesoJudicial($archivoInput);
						$obj_arc = new archivo($archivoInput, $optRutaArchivo, "pdf_" . $nombreArchivo, 0);
						if ($obj_arc->subir()) {
							$optArchivo = $obj_arc->get_nombre_archivo();
							$dtProcesoJudicial->setArchivo($optRutaArchivo.$obj_arc->get_nombre_archivo());
						}
					}
				}
				$dtGuardar = $this->fncActualizarBD($dtProcesoJudicial);
				$accion = 2;
			}

			if (fncGeneralValidarDataArray($dtGuardar)) {
				$model = array();
				$model["id_proceso_judicial"]        	= $dtGuardar->getIdProcesoJudicial();
				$model["id_trabajador"]        			= $dtGuardar->getIdTrabajador();
				$model["id_tipo_accion"]  				= $dtGuardar->getIdTipoAccion();
				$model["id_tipo_documento"]         	= $dtGuardar->getIdTipoDocumento();
				$model["asunto"]   						= $dtGuardar->getAsunto();
				$model["observacion"]  					= $dtGuardar->getObservacion();
				$model["archivo"]              			= $dtGuardar->getArchivo();
				$model["eliminado"]              		= $dtGuardar->getEliminado();
				

				$auditorioController = new AuditoriaController();
				$auditoria = $auditorioController->fncGuardar($accion, 'proceso_judicial', 'id_proceso_judicial', $model["id_proceso_judicial"], json_encode($model));

				array_push($dtReturn, $this->fncObtenerRegistro($dtProcesoJudicial->getIdProcesoJudicial()));
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
				$auditoria = $auditorioController->fncGuardar(2, 'proceso_judicial', 'id_proceso_judicial', $id, json_encode($returProcesoJudicial));
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
		$consulta = 'UPDATE escalafon.proceso_judicial
		SET		
			eliminado = 1
		WHERE id_proceso_judicial = :id_proceso_judicial';
		$statement = $sql->preparar($consulta);
		if ($statement != false) {
			$statement->bindParam('id_proceso_judicial', $id);
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
		$idTipoAccion = $dtModel->getIdTipoAccion();
		$idTipoDocumento = $dtModel->getIdTipoDocumento();
		$asunto = $dtModel->getAsunto();
		$observacion = $dtModel->getObservacion();
		$archivo = $dtModel->getArchivo();
		if ($archivo == '') {
			$archivo = NULL;
		}

	
		$sql = cls_control::get_instancia();
		$consulta = "INSERT INTO escalafon.proceso_judicial
					(
						-- id_proceso_judicial -- this column value is auto-generated
						id_trabajador,
						id_tipo_accion,
						id_tipo_documento,
						asunto,
						observacion,
						archivo,
						eliminado
					)
					VALUES
					(
						:id_trabajador,
						:id_tipo_accion,
						:id_tipo_documento,
						:asunto,
						:observacion,
						:archivo,
						0
					)
				   RETURNING id_proceso_judicial";
		$statement = $sql->preparar($consulta);
		if ($statement != false) {
			$statement->bindParam("id_trabajador", $idTrabajador);
			$statement->bindParam("id_tipo_accion", $idTipoAccion);
			$statement->bindParam("id_tipo_documento", $idTipoDocumento);
			$statement->bindParam("asunto", $asunto);
			$statement->bindParam("observacion", $observacion);
			$statement->bindParam("archivo", $archivo);
	
			$sql->ejecutar();
			$datos = $statement->fetch(PDO::FETCH_ASSOC);
			if ($datos) {
				//_Retorno de Datos
				$dtModel->setIdProcesoJudicial($datos["id_proceso_judicial"]);

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
		$idProcesoJudicial = $dtModel->getIdProcesoJudicial();
		$idTrabajador = $dtModel->getIdTrabajador();
		$idTipoAccion = $dtModel->getIdTipoAccion();
		$idTipoDocumento = $dtModel->getIdTipoDocumento();
		$asunto = $dtModel->getAsunto();
		$observacion = $dtModel->getObservacion();
		$archivo = $dtModel->getArchivo();
		$modificarArchivoScript = '';
		if ($archivo != '') {
			$modificarArchivoScript = ',archivo = :archivo';
		}
		$sql = cls_control::get_instancia();
		$query = "UPDATE escalafon.proceso_judicial
		SET
			-- id_proceso_judicial -- this column value is auto-generated
			id_trabajador =  :id_trabajador,
			id_tipo_accion = :id_tipo_accion,
			id_tipo_documento = :id_tipo_documento,
			asunto = :asunto,
			observacion = :observacion" . $modificarArchivoScript . "
				WHERE id_proceso_judicial = :id_proceso_judicial";
		$statement = $sql->preparar($query);
		if ($statement != false) {
			$statement->bindParam("id_proceso_judicial", $idProcesoJudicial);
			$statement->bindParam("id_trabajador", $idTrabajador);
			$statement->bindParam("id_tipo_accion", $idTipoAccion);
			$statement->bindParam("id_tipo_documento", $idTipoDocumento);
			$statement->bindParam("asunto", $asunto);
			$statement->bindParam("observacion", $observacion);
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

	private function fncObtenerRegistroPorIdTrabajadorBD($id)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			pn.nombres ||\' \'||pn.apellidos nombre_completo ,
			p.documento_identidad,
			pj.id_proceso_judicial,
			pj.id_trabajador,
			pj.id_tipo_accion,
			( SELECT ta.tipo AS tipo_accion  FROM escalafon.tipo_accion AS ta WHERE ta.id_tipo_accion = pj.id_tipo_accion ),
			pj.id_tipo_documento,
			( SELECT td.tipo_documento  FROM escalafon.tipo_documento AS td WHERE td.id_tipo_documento = pj.id_tipo_documento ),
			pj.asunto,
			pj.observacion,
			pj.archivo,
			pj.eliminado,
			(SELECT	a.fecha_hora FROM escalafon.auditoria  AS a WHERE ( a.id_operacion = 1 OR a.id_operacion = 2 )
			AND a.tabla = \'proceso_judicial\' AND a.objeto_id_nombre = \'id_proceso_judicial\' AND a.objeto_id_valor = pj.id_proceso_judicial
			ORDER BY a.id_auditoria DESC LIMIT 1 ),
			(SELECT
			pn.nombre_completo  AS usuario_auditoria
			FROM adm.usuario u
			LEFT JOIN public.persona_natural pn ON pn.id_persona = u.id_persona
			WHERE u.id_usuario = (SELECT	aa.id_usuario	FROM escalafon.auditoria  AS aa WHERE ( aa.id_operacion = 1 OR aa.id_operacion = 2 )
			AND aa.tabla = \'proceso_judicial\' AND aa.objeto_id_nombre = \'id_proceso_judicial\' AND aa.objeto_id_valor = pj.id_proceso_judicial
			ORDER BY aa.id_auditoria DESC LIMIT 1))
		FROM
			escalafon.proceso_judicial AS pj
			INNER JOIN escalafon.trabajador AS t ON t.id_trabajador = pj.id_trabajador
			INNER JOIN "public".persona AS p ON p.id_persona = t.id_trabajador
			INNER JOIN "public".persona_natural AS pn ON pn.id_persona = p.id_persona
			
		WHERE pj.eliminado = 0 AND pj.id_trabajador = :id_trabajador

		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_trabajador', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new ProcesoJudicial;
				$temp->documentoIdentidad      	= $datos['documento_identidad'];
				$temp->nombreCompleto     		= $datos['nombre_completo'];
				$temp->idProcesoJudicial	 	= $datos['id_proceso_judicial'];
				$temp->idTrabajador 			= $datos['id_trabajador'];
				$temp->idTipoAccion 			= $datos['id_tipo_accion'];
				$temp->tipoAccion 				= $datos['tipo_accion'];
				$temp->idTipoDocumento 			= $datos['id_tipo_documento'];
				$temp->tipoDocumento 			= $datos['tipo_documento'];
				$temp->asunto 					= $datos['asunto'];
				$temp->observacion 				= $datos['observacion'];				
				$temp->documento				= $datos['documento'];
				$temp->archivo					= $datos['archivo'];
				$temp->eliminado				= $datos['eliminado'];
				$temp->fechaHoraAuditoria		= $datos['fecha_hora'];
				$temp->usuarioAuditoria			= $datos['usuario_auditoria'];

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
			pn.nombres ||\' \'||pn.apellidos nombre_completo ,
			p.documento_identidad,
			pj.id_proceso_judicial,
			pj.id_trabajador,
			pj.id_tipo_accion,
			( SELECT ta.tipo AS tipo_accion  FROM escalafon.tipo_accion AS ta WHERE ta.id_tipo_accion = pj.id_tipo_accion ),
			pj.id_tipo_documento,
			( SELECT td.tipo_documento  FROM escalafon.tipo_documento AS td WHERE td.id_tipo_documento = pj.id_tipo_documento ),
			pj.asunto,
			pj.observacion,
			pj.archivo,
			pj.eliminado,
			(SELECT	a.fecha_hora FROM escalafon.auditoria  AS a WHERE ( a.id_operacion = 1 OR a.id_operacion = 2 )
			AND a.tabla = \'proceso_judicial\' AND a.objeto_id_nombre = \'id_proceso_judicial\' AND a.objeto_id_valor = pj.id_proceso_judicial
			ORDER BY a.id_auditoria DESC LIMIT 1 ),
			(SELECT
			pn.nombre_completo  AS usuario_auditoria
			FROM adm.usuario u
			LEFT JOIN public.persona_natural pn ON pn.id_persona = u.id_persona
			WHERE u.id_usuario = (SELECT	aa.id_usuario	FROM escalafon.auditoria  AS aa WHERE ( aa.id_operacion = 1 OR aa.id_operacion = 2 )
			AND aa.tabla = \'proceso_judicial\' AND aa.objeto_id_nombre = \'id_proceso_judicial\' AND aa.objeto_id_valor = pj.id_proceso_judicial
			ORDER BY aa.id_auditoria DESC LIMIT 1))
		FROM
			escalafon.proceso_judicial AS pj
			INNER JOIN escalafon.trabajador AS t ON t.id_trabajador = pj.id_trabajador
			INNER JOIN "public".persona AS p ON p.id_persona = t.id_trabajador
			INNER JOIN "public".persona_natural AS pn ON pn.id_persona = p.id_persona
			
		WHERE pj.eliminado = 0 AND pj.id_proceso_judicial = :id_proceso_judicial

		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_proceso_judicial', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new ProcesoJudicial;
				$temp->documentoIdentidad      	= $datos['documento_identidad'];
				$temp->nombreCompleto     		= $datos['nombre_completo'];
				$temp->idProcesoJudicial	 	= $datos['id_proceso_judicial'];
				$temp->idTrabajador 			= $datos['id_trabajador'];
				$temp->idTipoAccion 			= $datos['id_tipo_accion'];
				$temp->tipoAccion 				= $datos['tipo_accion'];
				$temp->idTipoDocumento 			= $datos['id_tipo_documento'];
				$temp->tipoDocumento 			= $datos['tipo_documento'];
				$temp->asunto 					= $datos['asunto'];
				$temp->observacion 				= $datos['observacion'];				
				$temp->documento				= $datos['documento'];
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
			pj.id_proceso_judicial,
			pj.id_trabajador,
			pj.id_tipo_accion,
			( SELECT ta.tipo AS tipo_accion  FROM escalafon.tipo_accion AS ta WHERE ta.id_tipo_accion = pj.id_tipo_accion ),
			pj.id_tipo_documento,
			( SELECT td.tipo_documento  FROM escalafon.tipo_documento AS td WHERE td.id_tipo_documento = pj.id_tipo_documento ),
			pj.asunto,
			pj.observacion,
			pj.archivo,
			pj.eliminado,
			(SELECT	a.fecha_hora FROM escalafon.auditoria  AS a WHERE ( a.id_operacion = 1 OR a.id_operacion = 2 )
			AND a.tabla = \'proceso_judicial\' AND a.objeto_id_nombre = \'id_proceso_judicial\' AND a.objeto_id_valor = pj.id_proceso_judicial
			ORDER BY a.id_auditoria DESC LIMIT 1 ),
			(SELECT
			pn.nombre_completo  AS usuario_auditoria
			FROM adm.usuario u
			LEFT JOIN public.persona_natural pn ON pn.id_persona = u.id_persona
			WHERE u.id_usuario = (SELECT	aa.id_usuario	FROM escalafon.auditoria  AS aa WHERE ( aa.id_operacion = 1 OR aa.id_operacion = 2 )
			AND aa.tabla = \'proceso_judicial\' AND aa.objeto_id_nombre = \'id_proceso_judicial\' AND aa.objeto_id_valor = pj.id_proceso_judicial
			ORDER BY aa.id_auditoria DESC LIMIT 1))
		FROM
			escalafon.proceso_judicial AS pj
			INNER JOIN escalafon.trabajador AS t ON t.id_trabajador = pj.id_trabajador
			INNER JOIN "public".persona AS p ON p.id_persona = t.id_trabajador
			INNER JOIN "public".persona_natural AS pn ON pn.id_persona = p.id_persona
			
		WHERE pj.id_proceso_judicial = :id_proceso_judicial

		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_proceso_judicial', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new ProcesoJudicial;
				$temp->documentoIdentidad      	= $datos['documento_identidad'];
				$temp->nombreCompleto     		= $datos['nombre_completo'];
				$temp->idProcesoJudicial	 	= $datos['id_proceso_judicial'];
				$temp->idTrabajador 			= $datos['id_trabajador'];
				$temp->idTipoAccion 			= $datos['id_tipo_accion'];
				$temp->tipoAccion 				= $datos['tipo_accion'];
				$temp->idTipoDocumento 			= $datos['id_tipo_documento'];
				$temp->tipoDocumento 			= $datos['tipo_documento'];
				$temp->asunto 					= $datos['asunto'];
				$temp->observacion 				= $datos['observacion'];				
				$temp->documento				= $datos['documento'];
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


function fncConstruirNombreDocumentoProcesoJudicial($archivo)
{
	$nombre = fncQuitarExtensionDocumentoProcesoJudicial($archivo['name']) . '_' . uniqid() . '_';
	return $nombre;
}
function fncQuitarExtensionDocumentoProcesoJudicial($string)
{
	$a = explode('.', $string);
	array_pop($a);
	return implode('.', $a);
}