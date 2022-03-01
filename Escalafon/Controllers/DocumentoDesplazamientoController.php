<?php
require_once '../../App/Escalafon/Models/DocumentoDesplazamiento.php';
require_once '../../App/Config/control.php';
require_once '../../App/Escalafon/Controllers/DocumentoController.php';
require_once '../../App/Escalafon/Controllers/AuditoriaController.php';
require_once '../../App/Escalafon/Controllers/DesplazamientoController.php';
require_once '../../App/Escalafon/Controllers/TipoDocumentoDesplazamientoController.php';



class DocumentoDesplazamientoController extends DocumentoDesplazamiento
{
	//=======================================================================================
	//FUNCIONES LOGICA
	//=======================================================================================

	public function fncListarRegistrosPorIdDesplazamiento($id = -1)
	{

		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosPorIdDesplazamientoBD($id);
		$clsDocumentoController = new DocumentoController();
		$clsTipoDocumentoDesplazamiento = new TipoDocumentoDesplazamientoController();
	//	$clsAuditoriaController = new AuditoriaController();
		if( fncGeneralValidarDataArray($dtListado) ){


			foreach( $dtListado as $listado ){
			/*	$dtAuditoria 	= $clsAuditoriaController->fncBuscarCampoAuditoria('documento','id_documento',$listado->$listado->idDocumento);
				if(fncGeneralValidarDataArray($dtAuditoria)){
					$Auditoria=array_shift($dtAuditoria);
				//	$fecha_hora = fncObtenerValorArray($Auditoria, 'fecha_hora', true);
				//	$idUsuario = (Int) fncObtenerValorArray($Auditoria, 'id_usuario', true);
					$idUsuario = fncObtenerValorArray($Auditoria, 'usuario', true);
				}*/
				$model = array();
				
				$model['idDocumentoDesplazamiento'] 	= $listado->idDocumentoDesplazamiento;
				$model['idDocumento'] 					=$listado->idDocumento;
				$model['documento'] 					= array_shift( $clsDocumentoController->fncListarRegistros($listado->idDocumento));
				$model['idDesplazamiento'] 				=$listado->idDesplazamiento;
				$model['idTipoDocumentoDesplazamiento'] = array_shift( $clsTipoDocumentoDesplazamiento->fncListarRegistros($listado->idTipoDocumentoDesplazamiento));

				

				array_push($dtReturn, $model);
			}
		}
		return $dtReturn;
	}


	public function fncRegistrosPorIdDesplazamiento($id , $idDoc = -1)
	{

		$dtReturn = array();
		$dtAuditoria = array();
		$dtListado = $this->fncRegistrosPorIdDesplazamientoBD($id,$idDoc);
		$clsDocumentoController = new DocumentoController();
		$clsTipoDocumentoDesplazamiento = new TipoDocumentoDesplazamientoController();
		
	//	$clsAuditoriaController = new AuditoriaController();
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){			
				$model = array();				
				$model['idDocumentoDesplazamiento'] 	= $listado->idDocumentoDesplazamiento;
				$model['idDocumento'] 					=$listado->idDocumento;
				$model['documento'] 					= array_shift( $clsDocumentoController->fncListarRegistros($listado->idDocumento));
				$model['idDesplazamiento'] 				=$listado->idDesplazamiento;
				$model['idTipoDocumentoDesplazamiento'] = $listado->idTipoDocumentoDesplazamiento;
				$model['tipoDocumentoDesplazamiento'] = array_shift( $clsTipoDocumentoDesplazamiento->fncListarRegistros($listado->idTipoDocumentoDesplazamiento));
				$model['fechaHoraAuditoria'] 			=$listado->fechaHoraAuditoria;
				$model['usuarioAuditoria'] 				=$listado->usuarioAuditoria;		
				array_push($dtReturn, $model);
				array_push($dtAuditoria,$model['idDocumentoDesplazamiento']);
			}
			$auditorioController = new AuditoriaController();
			$auditoria = $auditorioController->fncGuardar(4, 'documento_desplazamiento','id_documento_desplazamiento', null, json_encode($dtAuditoria) );
		}

		if ($idDoc != -1 && $idDoc != '') {
			return array_shift($dtReturn);
		} else {
			return $dtReturn;
		}
		
	}

	public function fncGuardarDocumentoDesplazamiento($arrayInputs)
	{
	
		$id_desplazamiento = (Int) fncObtenerValorArray( $arrayInputs, 'idDesplazamiento', true);
		$id_documento = (Int) fncObtenerValorArray( $arrayInputs, 'idDocumento', true);
		$id_tipo_documento_desplazamiento = (Int) fncObtenerValorArray( $arrayInputs, 'idTipoDocumentoDesplazamiento', true);
				
		$documentoDesplazamiento  = new DocumentoDesplazamiento();

		if( !empty($id_desplazamiento) ) { $documentoDesplazamiento->setIdDesplazamiento($id_desplazamiento); }
		if( !empty($id_documento) ) { $documentoDesplazamiento->setIdDocumento($id_documento); }
		if( !empty($id_tipo_documento_desplazamiento) ) { $documentoDesplazamiento->setIdTipoDocumentoDesplazamiento($id_tipo_documento_desplazamiento); }

		if( fncGeneralValidarDataArray($documentoDesplazamiento) ){
			$dtGuardar = $this->fncGuardarDocumentoDesplazamientoBD($documentoDesplazamiento);
		}
		if (fncGeneralValidarDataArray($dtGuardar)) {
			$documentoDesplazamiento->setIdDocumentoDesplazamiento($dtGuardar->getIdDocumentoDesplazamiento());

			$auditorioController = new AuditoriaController();	
			$auditoria = $auditorioController->fncGuardar(1, 'documento_desplazamiento','id_documento_desplazamiento', $dtGuardar->getIdDocumentoDesplazamiento(), json_encode($documentoDesplazamiento) );
			
		}
		//$bolReturn = $this->fncCambiarTareaCumplidaBD( $dtTareaNueva, $inputIdTarea, $optArchivo );
		return $documentoDesplazamiento;
	}


	public function fncGuardarSoloDocumentoAlDesplazamiento($arrayInputs, $archivoInput = "")
	{

		$dtReturn = array();
		$dtRetorno = array();
		$dtMensaje = "";

		$idDesplazamiento = (int) fncObtenerValorArray($arrayInputs, 'idDesplazamiento', true);
		$idTipoDocumentoDesplazamiento = (int) fncObtenerValorArray($arrayInputs, 'idTipoDocumentoDesplazamiento', true);

		$clsDesplazamiento = new DesplazamientoController();
		$documentoDesplazamiento  = new DocumentoDesplazamiento();

		$dtDesplazamiento = $clsDesplazamiento->fncListarRegistros($idDesplazamiento);
		if (fncGeneralValidarDataArray($dtDesplazamiento)) {
			if ($dtDesplazamiento[0]['id_tipo_accion'] != 9) {
				$idTipoDocumentoDesplazamiento = 1;
			}
			if (!empty($idDesplazamiento)) {
				$documentoDesplazamiento->setIdDesplazamiento($idDesplazamiento);
			}
			if (!empty($idTipoDocumentoDesplazamiento)) {
				$documentoDesplazamiento->setIdTipoDocumentoDesplazamiento($idTipoDocumentoDesplazamiento);
			}

			if (fncGeneralValidarDataArray($documentoDesplazamiento)) {

				$dtDocumentoController = new DocumentoController();
				$dtReturnDocumento = $dtDocumentoController->fncGuardarDocumentoArray($arrayInputs, $archivoInput);
				if (fncGeneralValidarDataArray($documentoDesplazamiento)) {
					foreach ($dtReturnDocumento as $documento) {
						$dtGuardar = array();
						$documentoDesplazamiento->setIdDocumento($documento["IdDocumento"]);
						$dtGuardar = $this->fncGuardarDocumentoDesplazamientoBD($documentoDesplazamiento);
						$dtDocumento['Documentos'] = $documento;
						$dtDocumentoDesplazamiento['DocumentosDesplazamiento'] = $dtGuardar;
						$returnDocumentoDesplazamiento = array(
							"Documento"=> $documento,
							"DocumentoDesplazamiento"=> $dtGuardar
						);
						array_push($dtReturn, ( $returnDocumentoDesplazamiento));
						//array_push($dtReturn, ( $dtDocumento));
					}
					$dtMensaje = "Registro Exitoso";
				}
			}
			if (fncGeneralValidarDataArray($dtGuardar)) {
				$documentoDesplazamiento->setIdDocumentoDesplazamiento($dtGuardar->getIdDocumentoDesplazamiento());

				$auditorioController = new AuditoriaController();
				$auditoria = $auditorioController->fncGuardar(1, 'documento_desplazamiento', 'id_documento_desplazamiento', $dtGuardar->getIdDocumentoDesplazamiento(), json_encode($documentoDesplazamiento));
				$dtReturn = array_shift($clsDesplazamiento->fncObtenerRegistro($documentoDesplazamiento->getIdDesplazamiento()));
			}
		}

		$dtRetorno = array();
		array_push($dtRetorno, $dtReturn);
		array_push($dtRetorno, $dtMensaje);
		return $dtRetorno;
	}


	public function fncGuardarDocumentoAlDesplazamiento($arrayInputs, $archivoInput = "")
	{

		$dtReturn = array();
		$dtRetorno = array();
		$dtMensaje = "";
		$idDocumento =0;

		$idDesplazamiento = (int) fncObtenerValorArray($arrayInputs, 'idDesplazamiento', true);
		$idTipoDocumentoDesplazamiento = (int) fncObtenerValorArray($arrayInputs, 'idTipoDocumentoDesplazamiento', true);
		$edit = 0;
		if (isset($arrayInputs->idDocumento)) {
			$edit = 1;

			$idDocumento = (Int)$arrayInputs->idDocumento;
		} 
		

		$clsDesplazamiento = new DesplazamientoController();
		$documentoDesplazamiento  = new DocumentoDesplazamiento();

		$dtDesplazamiento = $clsDesplazamiento->fncListarRegistros($idDesplazamiento);
		if (fncGeneralValidarDataArray($dtDesplazamiento)) {
			if ($dtDesplazamiento[0]['idTipoAccion'] != 9) {
				$idTipoDocumentoDesplazamiento = 1;
			}
			if (!empty($idDesplazamiento)) {
				$documentoDesplazamiento->setIdDesplazamiento($idDesplazamiento);
			}
			if (!empty($idTipoDocumentoDesplazamiento)) {
				$documentoDesplazamiento->setIdTipoDocumentoDesplazamiento($idTipoDocumentoDesplazamiento);
			}

			if (fncGeneralValidarDataArray($documentoDesplazamiento)) {

				$dtDocumentoController = new DocumentoController();
				
				if ($edit!=1) {
					$dtReturnDocumento = $dtDocumentoController->fncGuardarDocumento($arrayInputs, $archivoInput);
					if (fncGeneralValidarDataArray($documentoDesplazamiento)) {
						foreach ($dtReturnDocumento as $documento) {
							$dtGuardar = array();
							$documentoDesplazamiento->setIdDocumento($documento["IdDocumento"]);
							$dtGuardar = $this->fncGuardarDocumentoDesplazamientoBD($documentoDesplazamiento);
							$dtDocumento['Documentos'] = $documento;
							$dtDocumentoDesplazamiento['DocumentosDesplazamiento'] = $dtGuardar;
							$returnDocumentoDesplazamiento = array(
								"Documento"=> $documento,
								"DocumentoDesplazamiento"=> $dtGuardar
							);
							array_push($dtReturn, ( $returnDocumentoDesplazamiento));
							//array_push($dtReturn, ( $dtDocumento));
						}
						$dtMensaje = "Registro Exitoso";
					}
				} else {
					$dtReturnDocumento = $dtDocumentoController->fncGuardarDocumento($arrayInputs, $archivoInput);
					if (fncGeneralValidarDataArray($documentoDesplazamiento)) {
						foreach ($dtReturnDocumento as $documento) {
							$dtGuardar = array();
							$documentoDesplazamiento->setIdDocumento($documento["IdDocumento"]);
							$dtGuardar = $this->fncModificarDocumentoDesplazamientoBD($documentoDesplazamiento , $idDocumento);
							$dtDocumento['Documentos'] = $documento;
							$dtDocumentoDesplazamiento['DocumentosDesplazamiento'] = $dtGuardar;
							$returnDocumentoDesplazamiento = array(
								"Documento"=> $documento,
								"DocumentoDesplazamiento"=> $dtGuardar
							);
							array_push($dtReturn, ( $returnDocumentoDesplazamiento));
							//array_push($dtReturn, ( $dtDocumento));
						}
						$dtMensaje = "Registro Exitoso";
					}
				}
				
				
			}
			if (fncGeneralValidarDataArray($dtGuardar)) {
				$documentoDesplazamiento->setIdDocumentoDesplazamiento($dtGuardar->getIdDocumentoDesplazamiento());

				$auditorioController = new AuditoriaController();
				$auditoria = $auditorioController->fncGuardar(1, 'documento_desplazamiento', 'id_documento_desplazamiento', $dtGuardar->getIdDocumentoDesplazamiento(), json_encode($documentoDesplazamiento));
				$dtReturn = array_shift($clsDesplazamiento->fncObtenerRegistro($documentoDesplazamiento->getIdDesplazamiento()));
			}
		}

		$dtRetorno = array();
		array_push($dtRetorno, $dtReturn);
		array_push($dtRetorno, $dtMensaje);
		return $dtRetorno;
	}




	public function fncEliminarRegistro($id = 0)
	{

		$bolReturn = array();
		if ($id > 0) {
			$bolValidarEliminar = $this->fncEliminarBD($id);
			if ($bolValidarEliminar) {
				/*//_Elminamos la foto
				$dtPersonaNatural = new PersonaNatural;
				$dtPersonaNatural = $this->fncListarRegistrosBD($id);
				//$dtPersonaNatural = $this->fncSetear($dtPersonaNatural);
				$optFoto = $dtPersonaNatural->getFoto();
				$optRutaFoto = cls_rutas::get('personaImg'); //$optRutaFoto = '../../img/Admin/persona/';
				if(!empty($optFoto) && file_exists($optRutaFoto.$optFoto)){ unlink($optRutaFoto.$optFoto); }
			//_Eliminamos el registro
				$bolReturn = $this->fncEliminarBD( $id );  */

				$dtDocumentoDesplazamiento  = new DocumentoDesplazamiento();

				$returnDocumentoDesplazamiento['documento_desplazamiento'] = array_shift ( $this->fncListarRegistrosAuditoria($id));
				$bolReturn = $returnDocumentoDesplazamiento;
				$auditorioController = new AuditoriaController();
				$auditoria = $auditorioController->fncGuardar(2, 'documento_desplazamiento', 'id_documento_desplazamiento', $id, json_encode($bolReturn));
			}
		}
		return $bolReturn;
	}

	//=======================================================================================
	//FUNCIONES BASE DE DATOS
	//=======================================================================================

	private function fncListarRegistrosPorIdDesplazamientoBD($id = -1)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			dd.id_documento_desplazamiento,
			dd.id_documento,
			dd.id_desplazamiento,
			dd.eliminado,
			dd.id_tipo_documento_desplazamiento
		FROM
			escalafon.documento_desplazamiento AS dd
		WHERE (:id_desplazamiento = -1 OR id_desplazamiento = :id_desplazamiento) AND dd.eliminado = 0
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_desplazamiento', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new DocumentoDesplazamiento;
				$temp->idDocumentoDesplazamiento 	= $datos['id_documento_desplazamiento'];
				$temp->idDocumento 				= $datos['id_documento'];
				$temp->idDesplazamiento 			= $datos['id_desplazamiento'];
				$temp->idTipoDocumentoDesplazamiento = $datos['id_tipo_documento_desplazamiento'];

				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}


	private function fncRegistrosPorIdDesplazamientoBD($id = -1 ,$idDoc)
	{
		$sql = cls_control::get_instancia();
		$queryDocumentoDesplazamiento = '';
		if ($idDoc != -1 && $idDoc != '') {
			$queryDocumentoDesplazamiento = ' (id_documento_desplazamiento = :id_documento_desplazamiento)';
		} else {
			$queryDocumentoDesplazamiento = ' (id_desplazamiento = :id_desplazamiento)';
		}
		
		$query = '
		SELECT
			dd.id_documento_desplazamiento,
			dd.id_documento,
			(SELECT d.ruta FROM escalafon.documento AS d WHERE d.id_documento = dd.id_documento ) AS ruta_documento,
			dd.id_desplazamiento,
			dd.eliminado,
			dd.id_tipo_documento_desplazamiento,
			(SELECT tdd.tipo_documento_desplazamiento  FROM escalafon.tipo_documento_desplazamiento AS tdd WHERE tdd.id_tipo_documento_desplazamiento = dd.id_tipo_documento_desplazamiento  ) AS tipo_documento_desplazamiento,
			(SELECT	a.fecha_hora AS fecha_hora_auditoria FROM escalafon.auditoria  AS a WHERE ( a.id_operacion = 1 OR a.id_operacion = 2 )
					AND a.tabla = \'documento_desplazamiento\' AND a.objeto_id_nombre = \'id_documento_desplazamiento\' AND a.objeto_id_valor = dd.id_documento_desplazamiento
					ORDER BY a.id_auditoria DESC LIMIT 1 ),
			(SELECT
							pn.nombre_completo  AS usuario_auditoria
						FROM adm.usuario u
						LEFT JOIN public.persona_natural pn ON pn.id_persona = u.id_persona
						WHERE u.id_usuario = (SELECT	aa.id_usuario	FROM escalafon.auditoria  AS aa WHERE ( aa.id_operacion = 1 OR aa.id_operacion = 2 )
						AND aa.tabla = \'documento_desplazamiento\' AND aa.objeto_id_nombre = \'id_documento_desplazamiento\' AND aa.objeto_id_valor = dd.id_documento_desplazamiento
						ORDER BY aa.id_auditoria DESC LIMIT 1))
		FROM
			escalafon.documento_desplazamiento AS dd
		WHERE '.$queryDocumentoDesplazamiento.' AND dd.eliminado = 0
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			if ($idDoc != -1 && $idDoc != '') {
				$statement->bindParam('id_documento_desplazamiento', $idDoc);
			} else {
				$statement->bindParam('id_desplazamiento', $id);
			}

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new DocumentoDesplazamiento;
				$temp->idDocumentoDesplazamiento 	= $datos['id_documento_desplazamiento'];
				$temp->idDocumento 					= $datos['id_documento'];
				$temp->rutaDocumento 				= $datos['ruta_documento'];
				$temp->idDesplazamiento 			= $datos['id_desplazamiento'];
				$temp->idTipoDocumentoDesplazamiento = $datos['id_tipo_documento_desplazamiento'];
				$temp->tipoDocumentoDesplazamiento = $datos['tipo_documento_desplazamiento'];				
				$temp->fechaHoraAuditoria 			= $datos['fecha_hora_auditoria'];
				$temp->usuarioAuditoria 			= $datos['usuario_auditoria'];

				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}

	private function fncListarRegistrosAuditoria($id = -1)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			dd.id_documento_desplazamiento,
			dd.id_documento,
			dd.id_desplazamiento,
			dd.id_tipo_documento_desplazamiento,
			dd.eliminado
		FROM
			escalafon.documento_desplazamiento AS dd
		WHERE (:id_documento_desplazamiento = -1 OR id_documento_desplazamiento = :id_documento_desplazamiento)
		';
		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_documento_desplazamiento', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new DocumentoDesplazamiento;
				$temp->idDocumentoDesplazamiento 	= $datos['id_documento_desplazamiento'];
				$temp->idDocumento 					= $datos['id_documento'];
				$temp->idDesplazamiento 			= $datos['id_desplazamiento'];
				$temp->idTipoDocumentoDesplazamiento = $datos['id_tipo_documento_desplazamiento'];
				
				$temp->eliminado 					= $datos['eliminado'];

				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}

	private function fncGuardarDocumentoDesplazamientoBD( $dtDocumentoDesplazamiento )
	{
		$sql = cls_control::get_instancia();
		
		$id_desplazamiento 	= $dtDocumentoDesplazamiento->getIdDesplazamiento();
		$id_documento 		= $dtDocumentoDesplazamiento->getIdDocumento();
		$id_tipo_documento_desplazamiento 	= $dtDocumentoDesplazamiento->getIdTipoDocumentoDesplazamiento();
		$eliminado 	= 0;
	

		$consulta = "			
		INSERT INTO escalafon.documento_desplazamiento
		(
			-- id_documento_desplazamiento -- this column value is auto-generated
			id_documento,
			id_desplazamiento,
			eliminado,
			id_tipo_documento_desplazamiento
		)
		VALUES
		(
			:id_documento,
			:id_desplazamiento,
			:eliminado,
			:id_tipo_documento_desplazamiento
		)
		RETURNING id_documento_desplazamiento
		";
		
		$statement = $sql->preparar( $consulta );
		//var_dump($consulta);
		if ( $statement!=false) {
			$statement->bindParam('id_documento',$id_documento);
			$statement->bindParam('id_desplazamiento',$id_desplazamiento);
			$statement->bindParam('eliminado',$eliminado);
			$statement->bindParam('id_tipo_documento_desplazamiento',$id_tipo_documento_desplazamiento);
		
			$sql->ejecutar();
			$datos = $statement->fetch(PDO::FETCH_ASSOC);

			if( $datos ){

				$dtDocumentoDesplazamiento->setIdDocumentoDesplazamiento($datos["id_documento_desplazamiento"]);
				

				$sql->cerrar();
				return $dtDocumentoDesplazamiento;
			} else {
				$sql->cerrar();
				return false;
			}
		}
	}


	private function fncModificarDocumentoDesplazamientoBD( $dtDocumentoDesplazamiento , $idDocumentoDes )
	{
		$sql = cls_control::get_instancia();
		
		$idDesplazamiento 	= $dtDocumentoDesplazamiento->getIdDesplazamiento();
		$idDocumento 		= $dtDocumentoDesplazamiento->getIdDocumento();
		$idTipoDocumentoDesplazamiento 	= $dtDocumentoDesplazamiento->getIdTipoDocumentoDesplazamiento();
		$eliminado 	= 0;
	

		$consulta = "			
		
		UPDATE escalafon.documento_desplazamiento
		SET
			-- id_documento_desplazamiento -- this column value is auto-generated
			id_documento = :id_documento,
			--id_desplazamiento = :id_desplazamiento,
			id_tipo_documento_desplazamiento = :id_tipo_documento_desplazamiento
			
		WHERE id_documento = :id_documento_des
		";
		
		$statement = $sql->preparar($consulta);
		$arrayReturn = array();

		if ($statement != false) {
			//$statement->bindParam('id_documento_desplazamiento', $idDesplazamiento);
			$statement->bindParam('id_documento', $idDocumento);
			$statement->bindParam('id_documento_des', $idDocumentoDes);
			$statement->bindParam('id_tipo_documento_desplazamiento', $idTipoDocumentoDesplazamiento);
	

			$sql->ejecutar();
			$rs = $statement->fetchAll(PDO::FETCH_OBJ);
			if ($rs) {
				$sql->cerrar();
				return $dtDocumentoDesplazamiento;
			} else {
				$sql->cerrar();
				return false;
			}
		}
		return $arrayReturn;
	}



	private function fncEliminarBD($id)
	{
		$bolReturn = false;
		$sql = cls_control::get_instancia();
		$consulta = '
		UPDATE escalafon.documento_desplazamiento
		SET
			-- id_documento_desplazamiento -- this column value is auto-generated
		
			eliminado = 1
		WHERE id_documento_desplazamiento = :id_documento_desplazamiento';
		$statement = $sql->preparar($consulta);
		if ($statement != false) {
			$statement->bindParam('id_documento_desplazamiento', $id);
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

?>