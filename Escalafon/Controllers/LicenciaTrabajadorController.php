<?php
require_once '../../App/Escalafon/Models/LicenciaTrabajador.php';
require_once '../../App/Escalafon/Controllers/AuditoriaController.php';
require_once '../../App/Config/control.php';
require_once '../../App/Public/archivo.php';
require_once '../../App/Public/rutas.php';

class LicenciaTrabajadorController extends LicenciaTrabajador
{
	//=======================================================================================
	//FUNCIONES LOGICA
	//=======================================================================================

	public function fncListarRegistros($id = -1)
	{

		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosBD($id);

		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){		
				$model = array();				
				$model["idLicenciaTrabajador"]        = $listado->getIdLicenciaTrabajador();
				$model["idTrabajador"]        			= $listado->getIdTrabajador();
				$model["idTipoAccion"]  				= $listado->getIdTipoAccion();
				$model["idTipoDocumento"]         	= $listado->getIdTipoDocumento();
				$model["idTipoLicencia"]   			= $listado->getIdTipoLicencia();
				$model["documento"]  					= $listado->getDocumento();
				$model["resolucion"]              		= $listado->getResolucion();
				$model["fechaInicio"]              	= $listado->getFechaInicio();
				$model["fechaTermino"]		            = $listado->getFechaTermino();
				$model["dias"]		            		= $listado->getDias();
				$model["archivo"]		            	= $listado->getArchivo();
	
				array_push($dtReturn, $model);
			}
		}
		return $dtReturn;
	}

	public function fncListarLicenciasPorTrabajadorTipoLicencia($arrayInputs){
		$dtReturn = array();
		$dtListado = array();

		if(!$idTrabajador = fncObtenerValorArray($arrayInputs, 'idTrabajador', true)){
			$idTrabajador = -1;
		}
		if(!$idTipoLicencia = fncObtenerValorArray($arrayInputs, 'idTipoLicencia', true)){
			$idTipoLicencia = -1;
		}
		if(!$idLicenciaTrabajador = fncObtenerValorArray($arrayInputs, 'idLicenciaTrabajador', true)){
			$idLicenciaTrabajador = -1;
		}
		$dtListado = $this->fncListarLicenciasPorTrabajadorTipoLicenciaBD($idTrabajador, $idTipoLicencia, $idLicenciaTrabajador);

		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){		
				$model = array();				
				$model["idLicenciaTrabajador"]        	= $listado->getIdLicenciaTrabajador();
				$model["idTipoAccion"]  				= $listado->getIdTipoAccion();
				$model["idTrabajador"]  				= $listado->getIdTrabajador();
				$model["idTipoLicencia"]  				= $listado->getIdTipoLicencia();
				$model["tipoAccion"]  					= $listado->getTipoAccion();
				$model["idTipoDocumento"]         		= $listado->getIdTipoDocumento();
				$model["tipoDocumento"]         		= $listado->getTipoDocumento();
				$model["documento"]  					= $listado->getDocumento();
				$model["resolucion"]              		= $listado->getResolucion();
				$model["fechaInicio"]              		= $listado->getFechaInicio();
				$model["fechaTermino"]		            = $listado->getFechaTermino();
				$model["dias"]		            		= $listado->getDias();
				$model["archivo"]		            	= $listado->getArchivo();
				
				array_push($dtReturn, $model);
			}
		}
		return $dtReturn;
	}


	public function fncListarTiposLicencia($id = -1)
	{

		$dtReturn = array();
		$dtListado = $this->fncListarTiposLicenciaBD($id);

		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){		
				$model = array();				
				$model["idTipoLicencia"]        = $listado->idTipoLicencia;
				$model["idTrabajador"]        	= $listado->tipoLicencia;
		
	
				array_push($dtReturn, $model);
			}
		}
		return $dtReturn;
	}


	public function fncObtenerRegistro($id)
	{

		$dtReturn = array();
		$dtListado = $this->fncObtenerRegistroBD($id);

		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){		
				$model = array();				
				$model["documentoIdentidad"]       = $listado->documentoIdentidad;
				$model["nombreCompleto"]        	= $listado->nombreCompleto;
				$model["idLicenciaTrabajador"]  	= $listado->idLicenciaTrabajador;
				$model["idTrabajador"]         	= $listado->idTrabajador;
				$model["idTipoAccion"]   			= $listado->idTipoAccion;
				$model["tipoAccion"]  				= $listado->tipoAccion;
				$model["idTipoDocumento"]         = $listado->idTipoDocumento;
				$model["tipoDocumento"]            = $listado->tipoDocumento;
				$model["idTipoLicencia"]          = $listado->idTipoLicencia;
				$model["tipoLicencia"]         		 = $listado->tipoLicencia;
				$model["documento"]		            = $listado->documento;
				$model["resolucion"]		        = $listado->resolucion;
				$model["fechaInicio"]		        = ($listado->fechaInicio);
				$model["fechaTermino"]		        = ($listado->fechaTermino);
				$model["dias"]		            	= $listado->dias;
				$model["archivo"]		            = $listado->archivo;
				$model["eliminado"]		            = $listado->eliminado;
				$model["fechaHoraAuditoria"]		        = $listado->fechaHoraAuditoria;
				$model["usuarioAuditoria"]		    = $listado->usuarioAuditoria;
	
				array_push($dtReturn, $model);
			}
		}
		return array_shift($dtReturn);
	}

	public function fncListarPorIdTrabajador($id)
	{

		$dtReturn = array();
		$listaAuditoria = array();
		//$inputIdTrabajador = (Int)fncObtenerValorArray($arrayInputs, 'idTrabajador', true);
		$dtListado = $this->fncListarPorIdTrabajadorBD((Int)($id));
		$accion = 4;

		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){		
				$model = array();				
				$model["documentoIdentidad"]       = $listado->documentoIdentidad;
				$model["nombreCompleto"]        	= $listado->nombreCompleto;
				$model["idLicenciaTrabajador"]  	= $listado->idLicenciaTrabajador;
				$model["idTrabajador"]         	= $listado->idTrabajador;
				$model["idTipoAccion"]   			= $listado->idTipoAccion;
				$model["tipoAccion"]  				= $listado->tipoAccion;
				$model["idTipoDocumento"]         = $listado->idTipoDocumento;
				$model["tipoDocumento"]            = $listado->tipoDocumento;
				$model["idTipoLicencia"]          = $listado->idTipoLicencia;
				$model["documento"]		            = $listado->documento;
				$model["resolucion"]		        = $listado->resolucion;
				$model["fechaInicio"]		        = ($listado->fechaInicio);
				$model["fechaTermino"]		        = ($listado->fechaTermino);
				$model["dias"]		            	= $listado->dias;
				$model["archivo"]		            = $listado->archivo;
				$model["eliminado"]		            = $listado->eliminado;
				$model["fechaHoraAuditoria"]		        = $listado->fechaHoraAuditoria;
				$model["usuarioAuditoria"]		    = $listado->usuarioAuditoria;

				array_push($dtReturn, $model);
				array_push($listaAuditoria, $model['idLicenciaTrabajador']);
			}

			$auditorioController = new AuditoriaController();
			$auditoria = $auditorioController->fncGuardar($accion, 'licencia_trabajador', 'id_licencia_trabajador', null, json_encode($listaAuditoria));
		}
		return $dtReturn;
	}

	public function fncListarRegistrosAuditoria($id = -1)
	{

		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosAuditoriaBD($id);

		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){		
				$model = array();				
				$model["idLicenciaTrabajador"]        = $listado->getIdLicenciaTrabajador();
				$model["idTrabajador"]        			= $listado->getIdTrabajador();
				$model["idTipoAccion"]  				= $listado->getIdTipoAccion();
				$model["idTipoDocumento"]         	= $listado->getIdTipoDocumento();
				$model["idTipoLicencia"]   			= $listado->getIdTipoLicencia();
				$model["documento"]  					= $listado->getDocumento();
				$model["resolucion"]              		= $listado->getResolucion();
				$model["fechaInicio"]              	= $listado->getFechaInicio();
				$model["fechaTermino"]		            = $listado->getFechaTermino();
				$model["dias"]		            		= $listado->getDias();
				$model["archivo"]		            	= $listado->getArchivo();
	
				array_push($dtReturn, $model);
			}
		}
		return array_shift($dtReturn);
	}


	public function fncGuardar($arrayInputs, $archivoInput = '')
	{
		$dtReturn = array();
		$accion = 0;
		$inputIdLicenciaTrabajador = (Int)fncObtenerValorArray($arrayInputs, 'idLicenciaTrabajador', true);
		$inputIdTrabajador = (Int)fncObtenerValorArray($arrayInputs, 'idTrabajador', true);
		$inputIdTipoAccion = (Int)fncObtenerValorArray($arrayInputs, 'idTipoAccion', true);
		$inputIdTipoDocumento = (Int)fncObtenerValorArray($arrayInputs, 'idTipoDocumento', true);
		$inputIdTipoLicencia = (Int)fncObtenerValorArray($arrayInputs, 'idTipoLicencia', true);
		$inputDocumento		=  fncObtenerValorArray($arrayInputs, 'documento', true);
		$inputResolucion	= fncObtenerValorArray($arrayInputs, 'resolucion', true);
		$inputFechaInicio = fncObtenerValorArray($arrayInputs, 'fechaInicio', true);
		$inputFechaTermino = fncObtenerValorArray($arrayInputs, 'fechaTermino', true);
		$inputDias = (Int)fncObtenerValorArray($arrayInputs, 'dias', true);

		$dtLicenciaTrabajador = new LicenciaTrabajador;


		if (!empty($inputIdLicenciaTrabajador)) {
			$dtLicenciaTrabajador->setIdLicenciaTrabajador($inputIdLicenciaTrabajador);
		}
		if (!empty($inputIdTrabajador)) {
			$dtLicenciaTrabajador->setIdTrabajador($inputIdTrabajador);
		}
		if (!empty($inputIdTipoAccion)) {
			$dtLicenciaTrabajador->setIdTipoAccion($inputIdTipoAccion);
		}
		if (!empty($inputIdTipoDocumento)) {
			$dtLicenciaTrabajador->setIdTipoDocumento($inputIdTipoDocumento);
		}
		if (!empty($inputIdTipoLicencia)) {
			$dtLicenciaTrabajador->setIdTipoLicencia($inputIdTipoLicencia);
		}
		if (!empty($inputDocumento)) {
			$dtLicenciaTrabajador->setDocumento($inputDocumento);
		}
		if (!empty($inputResolucion)) {
			$dtLicenciaTrabajador->setResolucion($inputResolucion);
		}
		if (!empty($inputFechaInicio)) {
			$dtLicenciaTrabajador->setFechaInicio($inputFechaInicio);
		}
		if (!empty($inputFechaTermino)) {
			$dtLicenciaTrabajador->setFechaTermino($inputFechaTermino);
		}
		if (!empty($inputDias)) {
			$dtLicenciaTrabajador->setDias($inputDias);
		}
	

		if (fncGeneralValidarDataArray($dtLicenciaTrabajador)) {
			$dtGuardar = array();
			$optArchivo = "";
			if ($inputIdLicenciaTrabajador == 0 && $inputIdTrabajador != 0) {
				if (!empty($archivoInput)) {
					if ($archivoInput["name"] <> "") {
						$optRutaArchivo = cls_rutas::get('licenciaTrabajadorPdf');
						//$rutas=fncObtenerRuta();
						$nombreArchivo = fncConstruirNombreDocumentoLicencia($archivoInput);
						$obj_arc = new archivo($archivoInput, $optRutaArchivo, "pdf_" . $nombreArchivo, 0);
						if ($obj_arc->subir()) {
							$optArchivo = $obj_arc->get_nombre_archivo();
							$dtLicenciaTrabajador->setArchivo($optRutaArchivo.$obj_arc->get_nombre_archivo());
						}
					}
				}
				$dtGuardar = $this->fncRegistrarBD($dtLicenciaTrabajador);
				$accion = 1;
			} else {

				if (!empty($archivoInput)) {
					if ($archivoInput["name"] <> "") {
						$optRutaArchivo = cls_rutas::get('licenciaTrabajadorPdf');
						//$rutas=fncObtenerRuta();
						$nombreArchivo = fncConstruirNombreDocumentoLicencia($archivoInput);
						$obj_arc = new archivo($archivoInput, $optRutaArchivo, "pdf_" . $nombreArchivo, 0);
						if ($obj_arc->subir()) {
							$optArchivo = $obj_arc->get_nombre_archivo();
							$dtLicenciaTrabajador->setArchivo($optRutaArchivo.$obj_arc->get_nombre_archivo());
						}
					}
				}
				$dtGuardar = $this->fncActualizarBD($dtLicenciaTrabajador);
				$accion = 2;
			}

			if (fncGeneralValidarDataArray($dtGuardar)) {
				$model = array();
				$model["id_licencia_trabajador"]        = $dtGuardar->getIdLicenciaTrabajador();
				$model["id_trabajador"]        			= $dtGuardar->getIdTrabajador();
				$model["id_tipo_accion"]  				= $dtGuardar->getIdTipoAccion();
				$model["id_tipo_documento"]         	= $dtGuardar->getIdTipoDocumento();
				$model["id_tipo_licencia"]   			= $dtGuardar->getIdTipoLicencia();
				$model["documento"]  					= $dtGuardar->getDocumento();
				$model["resolucion"]              		= $dtGuardar->getResolucion();
				$model["fecha_inicio"]              	= $dtGuardar->getFechaInicio();
				$model["fecha_termino"]		            = $dtGuardar->getFechaTermino();
				$model["dias"]		            		= $dtGuardar->getDias();
				$model["archivo"]		            	= $dtGuardar->getArchivo();


				$auditorioController = new AuditoriaController();
				$auditoria = $auditorioController->fncGuardar($accion, 'licencia_trabajador', 'id_licencia_trabajador', $model["id_licencia_trabajador"], json_encode($model));

				array_push($dtReturn, $this->fncObtenerRegistro($dtLicenciaTrabajador->getIdLicenciaTrabajador()));
				unset($model);
			}
		}
		return array_shift($dtReturn);
	}

	public function fncEliminarRegistro($id = 0)
	{

		$bolReturn = array();
		$accion = 3;
		if ($id > 0) {
			$bolValidarEliminar = $this->fncEliminarBD($id);
			if ($bolValidarEliminar) {

				$dtLicenciaTrabajador = $this->fncListarRegistrosAuditoria($id);
				$bolReturn = $dtLicenciaTrabajador;

				$auditorioController = new AuditoriaController();
				$auditoria = $auditorioController->fncGuardar($accion, 'licencia_trabajador', 'id_licencia_trabajador', $id, json_encode($dtLicenciaTrabajador));
			}
		}
		return $bolReturn;
	}

	//=======================================================================================
	//FUNCIONES BASE DE DATOS
	//=======================================================================================

	private function fncListarRegistrosBD( $id = -1 )
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			lt.id_licencia_trabajador,
			lt.id_trabajador,
			lt.id_tipo_accion,
			lt.id_tipo_documento,
			lt.id_tipo_licencia,
			lt.documento,
			lt.resolucion,
			lt.fecha_inicio,
			lt.fecha_termino,
			lt.dias,
			lt.archivo
		FROM
			escalafon.licencia_trabajador AS lt
		WHERE (:id_licencia_trabajador = -1 OR id_licencia_trabajador = :id_licencia_trabajador) AND lt.eliminado = 0
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_licencia_trabajador', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
				$temp = new LicenciaTrabajador;
				$temp->idLicenciaTrabajador = $datos['id_licencia_trabajador'];
				$temp->idTrabajador 		= $datos['id_trabajador'];
				$temp->idTipoAccion 		= $datos['id_tipo_accion'];
				$temp->idTipoDocumento		= $datos['id_tipo_documento'];
				$temp->idTipoLicencia		= $datos['id_tipo_licencia'];
				$temp->documento			= $datos['documento'];
				$temp->resolucion			= $datos['resolucion'];
				$temp->fechaInicio			= $datos['fecha_inicio'];
				$temp->fechaTermino			= $datos['fecha_termino'];
				$temp->dias					= $datos['dias'];
				$temp->archivo				= $datos['archivo'];
		
				array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}

	private function fncListarLicenciasPorTrabajadorTipoLicenciaBD($idTrabajador = -1 , $idTipoLicencia  = -1, $idLicenciaTrabajador = -1){
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			lt.id_licencia_trabajador,
			lt.id_tipo_accion,
			lt.id_trabajador,
			lt.id_tipo_licencia,
			ta.tipo,
			lt.id_tipo_documento,
			td.tipo_documento,
			lt.documento,
			lt.resolucion,
			lt.fecha_inicio,
			lt.fecha_termino,
			lt.dias,
			lt.archivo
		FROM
			escalafon.licencia_trabajador AS lt
		INNER JOIN escalafon.tipo_accion AS ta ON ta.id_tipo_accion = lt.id_tipo_accion
		INNER JOIN escalafon.tipo_documento AS td ON td.id_tipo_documento = lt.id_tipo_documento 
		WHERE (id_licencia_trabajador = :id_licencia_trabajador OR :id_licencia_trabajador = -1) 
		AND ( lt.id_tipo_licencia = :id_tipo_licencia OR :id_tipo_licencia = -1)
		AND ( lt.id_trabajador = :id_trabajador OR  :id_trabajador = -1 )
		AND lt.eliminado = 0
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_licencia_trabajador', $idLicenciaTrabajador);
			$statement->bindParam('id_trabajador', $idTrabajador);
			$statement->bindParam('id_tipo_licencia', $idTipoLicencia);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
				$temp = new LicenciaTrabajador;
				$temp->idLicenciaTrabajador = $datos['id_licencia_trabajador'];
				$temp->idTrabajador  		= $datos['id_trabajador'];
				$temp->idTipoLicencia  		= $datos['id_tipo_licencia'];
				$temp->idTipoAccion 		= $datos['id_tipo_accion'];
				$temp->tipoAccion 			= $datos['tipo'];
				$temp->idTipoDocumento		= $datos['id_tipo_documento'];
				$temp->tipoDocumento		= $datos['tipo_documento'];
				$temp->documento			= $datos['documento'];
				$temp->resolucion			= $datos['resolucion'];
				$temp->fechaInicio			= $datos['fecha_inicio'];
				$temp->fechaTermino			= $datos['fecha_termino'];
				$temp->dias					= $datos['dias'];
				$temp->archivo				= $datos['archivo'];
				array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}



	private function fncListarTiposLicenciaBD( $id = -1 )
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
		tl.id_tipo_licencia,
		tl.tipo_licencia
		FROM
		escalafon.tipo_licencia AS tl
		WHERE (:id_tipo_licencia = -1 OR id_tipo_licencia = :id_tipo_licencia)
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_tipo_licencia', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
				$temp = new LicenciaTrabajador;
				$temp->idTipoLicencia = $datos['id_tipo_licencia'];
				$temp->tipoLicencia   = $datos['tipo_licencia'];
				
				array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}

	private function fncObtenerRegistroBD($id)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			pn.nombre_completo,
			p.documento_identidad,
			lt.id_licencia_trabajador,
			lt.id_trabajador,
			lt.id_tipo_accion,
			( SELECT ta.tipo AS tipo_accion  FROM escalafon.tipo_accion AS ta WHERE ta.id_tipo_accion = lt.id_tipo_accion ),
			lt.id_tipo_documento,
			( SELECT td.tipo_documento  FROM escalafon.tipo_documento AS td WHERE td.id_tipo_documento = lt.id_tipo_documento ),
			lt.id_tipo_licencia,
			( SELECT tl.tipo_licencia  FROM 	escalafon.tipo_licencia AS tl WHERE tl.id_tipo_licencia = lt.id_tipo_licencia ),
			lt.documento,
			lt.resolucion,
			lt.fecha_inicio,
			lt.fecha_termino,
			lt.dias,
			lt.archivo,
			lt.eliminado,
				(SELECT	a.fecha_hora FROM escalafon.auditoria  AS a WHERE ( a.id_operacion = 1 OR a.id_operacion = 2 )
					AND a.tabla = \'licencia_trabajador\' AND a.objeto_id_nombre = \'id_licencia_trabajador\' AND a.objeto_id_valor = lt.id_licencia_trabajador
					ORDER BY a.id_auditoria DESC LIMIT 1 ),
				(SELECT
							pn.nombre_completo  AS usuario_auditoria
						FROM adm.usuario u
						LEFT JOIN public.persona_natural pn ON pn.id_persona = u.id_persona
						WHERE u.id_usuario = (SELECT	aa.id_usuario	FROM escalafon.auditoria  AS aa WHERE ( aa.id_operacion = 1 OR aa.id_operacion = 2 )
						AND aa.tabla = \'licencia_trabajador\' AND aa.objeto_id_nombre = \'id_licencia_trabajador\' AND aa.objeto_id_valor = lt.id_licencia_trabajador
						ORDER BY aa.id_auditoria DESC LIMIT 1))
		FROM
			escalafon.licencia_trabajador AS lt
			INNER JOIN escalafon.trabajador AS t ON t.id_trabajador = lt.id_trabajador
			INNER JOIN "public".persona AS p ON p.id_persona = t.id_trabajador
			INNER JOIN "public".persona_natural AS pn ON pn.id_persona = p.id_persona
		WHERE lt.id_licencia_trabajador = :id_licencia_trabajador AND lt.eliminado = 0
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_licencia_trabajador', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new LicenciaTrabajador;
				$temp->documentoIdentidad      	= $datos['documento_identidad'];
				$temp->nombreCompleto     		= $datos['nombre_completo'];
				$temp->idLicenciaTrabajador 	= $datos['id_licencia_trabajador'];
				$temp->idTrabajador 			= $datos['id_trabajador'];
				$temp->idTipoAccion 			= $datos['id_tipo_accion'];
				$temp->tipoAccion 				= $datos['tipo_accion'];
				$temp->idTipoDocumento 			= $datos['id_tipo_documento'];
				$temp->tipoDocumento 			= $datos['tipo_documento'];
				$temp->idTipoLicencia 			= $datos['id_tipo_licencia'];
				$temp->tipoLicencia 			= $datos['tipo_licencia'];				
				$temp->documento				= $datos['documento'];
				$temp->resolucion				= $datos['resolucion'];
				$temp->fechaInicio				= $datos['fecha_inicio'];
				$temp->fechaTermino				= $datos['fecha_termino'];
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

	private function fncListarRegistrosAuditoriaBD( $id = -1 )
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			lt.id_licencia_trabajador,
			lt.id_trabajador,
			lt.id_tipo_accion,
			lt.id_tipo_documento,
			lt.id_tipo_licencia,
			lt.documento,
			lt.resolucion,
			lt.fecha_inicio,
			lt.fecha_termino,
			lt.dias,
			lt.archivo,
			lt.eliminado
		FROM
			escalafon.licencia_trabajador AS lt
		WHERE (:id_licencia_trabajador = -1 OR lt.id_licencia_trabajador = :id_licencia_trabajador)
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_licencia_trabajador', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
				$temp = new LicenciaTrabajador;
				$temp->idLicenciaTrabajador = $datos['id_licencia_trabajador'];
				$temp->idTrabajador 		= $datos['id_trabajador'];
				$temp->idTipoAccion 		= $datos['id_tipo_accion'];
				$temp->idTipoDocumento		= $datos['id_tipo_documento'];
				$temp->idTipoLicencia		= $datos['id_tipo_licencia'];
				$temp->documento			= $datos['documento'];
				$temp->resolucion			= $datos['resolucion'];
				$temp->fechaInicio			= $datos['fecha_inicio'];
				$temp->fechaTermino			= $datos['fecha_termino'];
				$temp->dias					= $datos['dias'];
				$temp->archivo				= $datos['archivo'];
				$temp->eliminado			= $datos['eliminado'];

				array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}

	public function fncRegistrarBD($dtModel)
	{
		//$idLicenciaTrabajador = $dtModel->getIdLicenciaTrabajador();
		$idTrabajador = $dtModel->getIdTrabajador();
		$idTipoAccion = $dtModel->getIdTipoAccion();
		$idTipoDocumento = $dtModel->getIdTipoDocumento();
		$tipoLicencia = $dtModel->getIdTipoLicencia();
		$documento = $dtModel->getDocumento();
		$resolucion = $dtModel->getResolucion();
		$fechaInicio = $dtModel->getFechaInicio();
		$fechaTermino = $dtModel->getFechaTermino();
		$dias = $dtModel->getDias();
		$archivo = $dtModel->getArchivo();
		if ($archivo == '') {
			$archivo = NULL;
		}
		$sql = cls_control::get_instancia();
		$consulta = "INSERT INTO escalafon.licencia_trabajador
					(
						-- id_licencia_trabajador -- this column value is auto-generated
						id_trabajador,
						id_tipo_accion,
						id_tipo_documento,
						id_tipo_licencia,
						documento,
						resolucion,
						fecha_inicio,
						fecha_termino,
						dias,
						archivo,
						eliminado
					)
					VALUES
					(
						:id_trabajador,
						:id_tipo_accion,
						:id_tipo_documento,
						:id_tipo_licencia,
						:documento,
						:resolucion,
						:fecha_inicio,
						:fecha_termino,
						:dias,
						:archivo,
						0
					)
				   RETURNING id_licencia_trabajador";
		$statement = $sql->preparar($consulta);
		if ($statement != false) {
			$statement->bindParam("id_trabajador", $idTrabajador);
			$statement->bindParam("id_tipo_accion", $idTipoAccion);
			$statement->bindParam("id_tipo_documento", $idTipoDocumento);
			$statement->bindParam("id_tipo_licencia", $tipoLicencia);
			$statement->bindParam("documento", $documento);
			$statement->bindParam("resolucion", $resolucion);
			$statement->bindParam("fecha_inicio", $fechaInicio);
			$statement->bindParam("fecha_termino", $fechaTermino);
			$statement->bindParam("dias", $dias);
			$statement->bindParam("archivo", $archivo);
	
			$sql->ejecutar();
			$datos = $statement->fetch(PDO::FETCH_ASSOC);
			if ($datos) {
				//_Retorno de Datos
				$dtModel->setIdLicenciaTrabajador($datos["id_licencia_trabajador"]);

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
		$idLicenciaTrabajador = $dtModel->getIdLicenciaTrabajador();
		$idTrabajador = $dtModel->getIdTrabajador();
		$idTipoAccion = $dtModel->getIdTipoAccion();
		$idTipoDocumento = $dtModel->getIdTipoDocumento();
		$tipoLicencia = $dtModel->getIdTipoLicencia();
		$documento = $dtModel->getDocumento();
		$resolucion = $dtModel->getResolucion();
		$fechaInicio = $dtModel->getFechaInicio();
		$fechaTermino = $dtModel->getFechaTermino();
		$dias = $dtModel->getDias();
		$archivo = $dtModel->getArchivo();
		$modificarArchivoScript = '';
		if ($archivo != '') {
			$modificarArchivoScript = ',archivo = :archivo';
		}
		$sql = cls_control::get_instancia();
		$query = "UPDATE escalafon.licencia_trabajador
				SET
					-- id_licencia_trabajador -- this column value is auto-generated
					id_trabajador = :id_trabajador ,
					id_tipo_accion = :id_tipo_accion ,
					id_tipo_documento = :id_tipo_documento ,
					id_tipo_licencia = :id_tipo_licencia ,
					documento = :documento ,
					resolucion = :resolucion ,
					fecha_inicio = :fecha_inicio ,
					fecha_termino = :fecha_termino ,
					dias = :dias " . $modificarArchivoScript . "
				WHERE id_licencia_trabajador = :id_licencia_trabajador";
		$statement = $sql->preparar($query);
		if ($statement != false) {
			$statement->bindParam("id_licencia_trabajador", $idLicenciaTrabajador);
			$statement->bindParam("id_trabajador", $idTrabajador);
			$statement->bindParam("id_tipo_accion", $idTipoAccion);
			$statement->bindParam("id_tipo_documento", $idTipoDocumento);
			$statement->bindParam("id_tipo_licencia", $tipoLicencia);
			$statement->bindParam("documento", $documento);
			$statement->bindParam("resolucion", $resolucion);
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


	private function fncListarPorIdTrabajadorBD($idTrabajador)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			pn.nombre_completo,
			p.documento_identidad,
			lt.id_licencia_trabajador,
			lt.id_trabajador,
			lt.id_tipo_accion,
			( SELECT ta.tipo AS tipo_accion  FROM escalafon.tipo_accion AS ta WHERE ta.id_tipo_accion = lt.id_tipo_accion ),
			lt.id_tipo_documento,
			( SELECT td.tipo_documento  FROM escalafon.tipo_documento AS td WHERE td.id_tipo_documento = lt.id_tipo_documento ),
			lt.id_tipo_licencia,
			( SELECT tl.tipo_licencia  FROM 	escalafon.tipo_licencia AS tl WHERE tl.id_tipo_licencia = lt.id_tipo_licencia ),
			lt.documento,
			lt.resolucion,
			lt.fecha_inicio,
			lt.fecha_termino,
			lt.dias,
			lt.archivo,
			lt.eliminado,
				(SELECT	a.fecha_hora FROM escalafon.auditoria  AS a WHERE ( a.id_operacion = 1 OR a.id_operacion = 2 )
					AND a.tabla = \'licencia_trabajador\' AND a.objeto_id_nombre = \'id_licencia_trabajador\' AND a.objeto_id_valor = lt.id_licencia_trabajador
					ORDER BY a.id_auditoria DESC LIMIT 1 ),
				(SELECT
							pn.nombre_completo  AS usuario_auditoria
						FROM adm.usuario u
						LEFT JOIN public.persona_natural pn ON pn.id_persona = u.id_persona
						WHERE u.id_usuario = (SELECT	aa.id_usuario	FROM escalafon.auditoria  AS aa WHERE ( aa.id_operacion = 1 OR aa.id_operacion = 2 )
						AND aa.tabla = \'licencia_trabajador\' AND aa.objeto_id_nombre = \'id_licencia_trabajador\' AND aa.objeto_id_valor = lt.id_licencia_trabajador
						ORDER BY aa.id_auditoria DESC LIMIT 1))
		FROM
			escalafon.licencia_trabajador AS lt
			INNER JOIN escalafon.trabajador AS t ON t.id_trabajador = lt.id_trabajador
			INNER JOIN "public".persona AS p ON p.id_persona = t.id_trabajador
			INNER JOIN "public".persona_natural AS pn ON pn.id_persona = p.id_persona
		WHERE (lt.id_trabajador = :id_trabajador AND lt.eliminado = 0 )
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_trabajador', $idTrabajador);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new LicenciaTrabajador;
				$temp->documentoIdentidad      	= $datos['documento_identidad'];
				$temp->nombreCompleto     		= $datos['nombre_completo'];
				$temp->idLicenciaTrabajador 	= $datos['id_licencia_trabajador'];
				$temp->idTrabajador 			= $datos['id_trabajador'];
				$temp->idTipoAccion 			= $datos['id_tipo_accion'];
				$temp->tipoAccion 				= $datos['tipo_accion'];
				$temp->idTipoDocumento 			= $datos['id_tipo_documento'];
				$temp->tipoDocumento 			= $datos['tipo_documento'];
				$temp->idTipoLicencia 			= $datos['id_tipo_licencia'];
				$temp->tipoLicencia 			= $datos['tipo_licencia'];				
				$temp->documento				= $datos['documento'];
				$temp->resolucion				= $datos['resolucion'];
				$temp->fechaInicio				= $datos['fecha_inicio'];
				$temp->fechaTermino				= $datos['fecha_termino'];
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

	private function fncEliminarBD($id)
	{
		$bolReturn = false;
		$sql = cls_control::get_instancia();
		$consulta = 'UPDATE escalafon.licencia_trabajador
		SET		
			eliminado = 1
		WHERE id_licencia_trabajador = :id_licencia_trabajador';
		$statement = $sql->preparar($consulta);
		if ($statement != false) {
			$statement->bindParam('id_licencia_trabajador', $id);
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
function fncConstruirNombreDocumentoLicencia($archivo)
{
	$nombre = fncQuitarExtensionDocumentoLicencia($archivo['name']) . '_' . uniqid() . '_';
	return $nombre;
}
function fncQuitarExtensionDocumentoLicencia($string)
{
	$a = explode('.', $string);
	array_pop($a);
	return implode('.', $a);
}