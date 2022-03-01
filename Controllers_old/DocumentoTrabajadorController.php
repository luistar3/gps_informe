<?php
require_once '../../App/Escalafon/Models/DocumentoTrabajador.php';
require_once '../../App/Config/control.php';
require_once '../../App/Public/archivo.php';
require_once '../../App/Public/rutas.php';

require_once '../../App/Escalafon/Controllers/AuditoriaController.php';
require_once '../../App/Escalafon/Controllers/TipoDocumentoTrabajadorController.php';

class DocumentoTrabajadorController extends DocumentoTrabajador
{
	//=======================================================================================
	//FUNCIONES LOGICA
	//=======================================================================================

	public function fncListarRegistros($id = -1)
	{
		$clsTipoDocumentoTrabajadorController = new TipoDocumentoTrabajadorController();
		$clsAuditoriaController = new AuditoriaController();
		$dtReturn = array();
		$listadoIdAuditoria = array();
		$dtListado = $this->fncListarRegistrosBD($id);

		if (fncGeneralValidarDataArray($dtListado)) {

			foreach ($dtListado as $listado) {

				$dtAuditoria 	= $clsAuditoriaController->fncBuscarCampoAuditoria('documento_trabajador', 'id_documento_trabajador', $listado->idDocumentoTrabajador);
				if (fncGeneralValidarDataArray($dtAuditoria)) {
					$Auditoria = array_shift($dtAuditoria);
					$fecha_hora = fncObtenerValorArray($Auditoria, 'fecha_hora', true);
					$idUsuario = (int) fncObtenerValorArray($Auditoria, 'id_usuario', true);
					$nombreUsuario 	= $this->fncObtenerNombreCompletoUsuarioDocumentoBD($idUsuario);
				}
				$model = array();

				$model['idDocumentoTrabajador'] 		= $listado->idDocumentoTrabajador;
				$model['idTipoDocumentoTrabajador']  = $listado->idTipoDocumentoTrabajador;
				$model['tipoDocumentoTrabajador']     = array_shift( $clsTipoDocumentoTrabajadorController->fncListarRegistros($listado->idTipoDocumentoTrabajador));
				$model['idTrabajador'] 				= $listado->idTrabajador;
				$model['descripcion'] 					= $listado->descripcion;
				$model['ruta'] 							= $listado->ruta;
				$model['AuditoriaFecha']				= $fecha_hora;
				$model['AuditoriaUsuario']				= $nombreUsuario;
				$model['eliminado']						= $listado->eliminado;


				//	$model['tipoTrabajador'] =  $clsTipoTrabajador->fncListarRegistros($listado->idTipoTrabajador);

				array_push($dtReturn, $model);
				array_push($listadoIdAuditoria, $model['idDocumentoTrabajador']);
			}
		}

		$auditorioController = new AuditoriaController();
		$auditoria = $auditorioController->fncGuardar(4, 'documento_trabajador', 'id_documento_trabajador', $id, json_encode($listadoIdAuditoria));
		return $dtReturn;
	}

	public function fncListarPorId($id = 0)
	{
		$clsTipoDocumentoTrabajadorController = new TipoDocumentoTrabajadorController();
		$dtReturn = array();
		$listadoIdAuditoria = array();
		$dtListado = $this->fncListarRegistrosPorIdBD($id);

		if (fncGeneralValidarDataArray($dtListado)) {

			foreach ($dtListado as $listado) {

				$model = array();

				$model['idDocumentoTrabajador'] 		= $listado->idDocumentoTrabajador;
				$model['idTipoDocumentoTrabajador']  = $listado->idTipoDocumentoTrabajador;
				$model['tipoDocumentoTrabajador']     = array_shift( $clsTipoDocumentoTrabajadorController->fncListarRegistros($listado->idTipoDocumentoTrabajador));
				$model['idTrabajador'] 				= $listado->idTrabajador;
				$model['descripcion'] 					= $listado->descripcion;
				$model['ruta'] 							= $listado->ruta;
				$model['eliminado']						= $listado->eliminado;


				//	$model['tipoTrabajador'] =  $clsTipoTrabajador->fncListarRegistros($listado->idTipoTrabajador);

				array_push($dtReturn, $model);
				array_push($listadoIdAuditoria, $model['id_documento_trabajador']);
			}
		}

		$auditorioController = new AuditoriaController();
		$auditoria = $auditorioController->fncGuardar(4, 'documento_trabajador', 'id_documento_trabajador', $id, json_encode($listadoIdAuditoria));
		return $dtReturn;
	}


	public function fncObtenerRegistro($id = 0)
	{
		$clsTipoDocumentoTrabajadorController = new TipoDocumentoTrabajadorController();
		$dtReturn = array();
		$listadoIdAuditoria = array();
		$dtListado = $this->fncObtenerRegistroBD($id);

		if (fncGeneralValidarDataArray($dtListado)) {

			foreach ($dtListado as $listado) {

				$model = array();

				$model['idDocumentoTrabajador'] 		= $listado->idDocumentoTrabajador;
				$model['idTipoDocumentoTrabajador']  = $listado->idTipoDocumentoTrabajador;
				$model['tipoDocumentoTrabajador']     = $listado->tipoDocumentoTrabajador;
				$model['idTrabajador'] 				= $listado->idTrabajador;
				$model['descripcion'] 					= $listado->descripcion;
				$model['ruta'] 							= $listado->ruta;
				//$model['eliminado']						= $listado->eliminado;
				$model["fechaHoraAuditoria"]		= ($listado->fechaHoraAuditoria);
				$model["usuarioAuditoria"]			= $listado->usuarioAuditoria;


				//	$model['tipoTrabajador'] =  $clsTipoTrabajador->fncListarRegistros($listado->idTipoTrabajador);

				array_push($dtReturn, $model);
				array_push($listadoIdAuditoria, $model['idDocumentoTrabajador']);
			}
		}

		$auditorioController = new AuditoriaController();
		$auditoria = $auditorioController->fncGuardar(4, 'documento_trabajador', 'id_documento_trabajador', $id, json_encode($listadoIdAuditoria));
		return array_shift($dtReturn);
	}

	public function fncEliminarRegistro($id = -1)
	{

		$bolReturn = false;
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

				$documentoTrabajador  = $this->fncListarPorId($id);
				$returnDocumento['documento_trabajador'] = array_shift( $documentoTrabajador);
				$bolReturn = $returnDocumento;

				$auditorioController = new AuditoriaController();
				$auditoria = $auditorioController->fncGuardar(2, 'documento_trabajador', 'id_documento_trabajador', $id, json_encode($documentoTrabajador));
			}
		}
		return $bolReturn;
	}


	public function fncGuardarDocumento($arrayInputs, $archivoInput = '')
	{

		$dtReturn = array();
		$idDocumentoTrabajador = (int) fncObtenerValorArray($arrayInputs, 'idDocumentoTrabajador', true);
		$inputIdTipoDocumentoTrabajador = (int) fncObtenerValorArray($arrayInputs, 'idTipoDocumentoTrabajador', true);
		$inputIdTrabajador = (int) fncObtenerValorArray($arrayInputs, 'idTrabajador', true);
		$inputDescripcion = fncObtenerValorArray($arrayInputs, 'descripcion', true);

		$documentoTrabajador  = new DocumentoTrabajador();
		if (!empty($idDocumentoTrabajador)) {
			$documentoTrabajador->setIdDocumentoTrabajador($idDocumentoTrabajador);
		}
		if (!empty($inputIdTipoDocumentoTrabajador)) {
			$documentoTrabajador->setIdTipoDocumentoTrabajador($inputIdTipoDocumentoTrabajador);
		}
		if (!empty($inputIdTrabajador)) {
			$documentoTrabajador->setIdTrabajador($inputIdTrabajador);
		}
		if (!empty($inputDescripcion)) {
			$documentoTrabajador->setDescripcion($inputDescripcion);
		}
		$optArchivo = "";
		if (fncGeneralValidarDataArray($documentoTrabajador)) {
			/*if (!empty($archivoInput)) {
				if ($archivoInput["name"] <> "") {
					$optRutaArchivo = cls_rutas::get('trabajadorPdf');
					//$rutas=fncObtenerRuta();
					$nombreArchivo = fncConstruirNombreDocumentoTrabajador($archivoInput);
					$obj_arc = new archivo($archivoInput, $optRutaArchivo, "pdf_" . $nombreArchivo, 0);
					if ($obj_arc->subir()) {
						$optArchivo = $obj_arc->get_nombre_archivo();
						$documentoTrabajador->setRuta($obj_arc->get_nombre_archivo());
					}
				}
			}
*/


			if ($idDocumentoTrabajador == 0 && $inputIdTrabajador != 0) {
				if (!empty($archivoInput)) {
					if ($archivoInput["name"] <> "") {
						$optRutaArchivo = cls_rutas::get('trabajadorPdf');
						//$rutas=fncObtenerRuta();
						$nombreArchivo = fncConstruirNombreDocumentoTrabajador($archivoInput);
						$obj_arc = new archivo($archivoInput, $optRutaArchivo, "pdf_" . $nombreArchivo, 0);
						if ($obj_arc->subir()) {
							$optArchivo = $obj_arc->get_nombre_archivo();
							$documentoTrabajador->setRuta($optRutaArchivo.$obj_arc->get_nombre_archivo());
						}
					}
				}
				$dtGuardar = $this->fncGuardarDocumentoTrabajador($documentoTrabajador);
				$accion = 1;
			} else {

				if (!empty($archivoInput)) {
					if ($archivoInput["name"] <> "") {
						$optRutaArchivo = cls_rutas::get('trabajadorPdf');
						//$rutas=fncObtenerRuta();
						$nombreArchivo = fncConstruirNombreDocumentoTrabajador($archivoInput);
						$obj_arc = new archivo($archivoInput, $optRutaArchivo, "pdf_" . $nombreArchivo, 0);
						if ($obj_arc->subir()) {
							$optArchivo = $obj_arc->get_nombre_archivo();
							$documentoTrabajador->setRuta($optRutaArchivo.$obj_arc->get_nombre_archivo());
						}
					}
				}
				$dtGuardar = $this->fncModificarDocumentoTrabajador($documentoTrabajador);
				$accion = 2;
			}


			if (fncGeneralValidarDataArray($dtGuardar)) {

				$model = array();
				$model["idDocumentoTrabajador"]        	= $dtGuardar->getIdDocumentoTrabajador();
				$model["idTipoDocumentoTrabajador"]     = $dtGuardar->getIdTipoDocumentoTrabajador();
				$model["idTrabajador"] 					= $dtGuardar->getIdTrabajador();
				$model["descripcion"]         			= $dtGuardar->getDescripcion();
				$model["archivo"]         				= $dtGuardar->getRuta();
			

				//array_push($dtReturn, $model);


				$returnDocumento = array();
				$returnDocumento['documento_trabajador'] =$documentoTrabajador;
				//$dtReturn = $returnDocumento;
				$auditorioController = new AuditoriaController();
				$auditoria = $auditorioController->fncGuardar($accion, 'documento_trabajador', 'id_documento_trabajador', $dtGuardar->getIdDocumentoTrabajador(), json_encode($documentoTrabajador));
				array_push($dtReturn, $this->fncObtenerRegistro($dtGuardar->getIdDocumentoTrabajador()));
				unset($model);
			}

		}
		
		//$bolReturn = $this->fncCambiarTareaCumplidaBD( $dtTareaNueva, $inputIdTarea, $optArchivo );
		return (array_shift($dtReturn));
	}


	//=======================================================================================
	//FUNCIONES BASE DE DATOS
	//=======================================================================================

	private function fncListarRegistrosBD($id = -1)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			dt.id_documento_trabajador,
			dt.id_tipo_documento_trabajador,
			dt.id_trabajador,
			dt.descripcion,
			dt.ruta,
			dt.eliminado
		FROM
			escalafon.documento_trabajador AS dt
		WHERE (:id_trabajador = -1 OR id_trabajador = :id_trabajador) and
			  (dt.eliminado=0)	
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_trabajador', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new DocumentoTrabajador;
				$temp->idDocumentoTrabajador 	        = $datos['id_documento_trabajador'];
				$temp->idTipoDocumentoTrabajador 		= $datos['id_tipo_documento_trabajador'];
				$temp->idTrabajador 					= $datos['id_trabajador'];
				$temp->descripcion 						= $datos['descripcion'];
				$temp->ruta								= $datos['ruta'];
				$temp->eliminado						= $datos['eliminado'];



				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}
	private function fncListarRegistrosPorIdBD($id = 0)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			dt.id_documento_trabajador,
			dt.id_tipo_documento_trabajador,
			dt.id_trabajador,
			dt.descripcion,
			dt.ruta,
			dt.eliminado
		FROM
			escalafon.documento_trabajador AS dt
		WHERE (dt.id_documento_trabajador = 0 OR dt.id_documento_trabajador = :id_documento_trabajador)
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_documento_trabajador', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new DocumentoTrabajador;
				$temp->idDocumentoTrabajador 	        = $datos['id_documento_trabajador'];
				$temp->idTipoDocumentoTrabajador 		= $datos['id_tipo_documento_trabajador'];
				$temp->idTrabajador 					= $datos['id_trabajador'];
				$temp->descripcion 						= $datos['descripcion'];
				$temp->ruta								= $datos['ruta'];
				$temp->eliminado						= $datos['eliminado'];



				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}

	private function fncObtenerRegistroBD($id = 0)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			dt.id_documento_trabajador,
			dt.id_tipo_documento_trabajador,
			(SELECT tdt.tipo_documento
			FROM escalafon.tipo_documento_trabajador AS tdt WHERE tdt.id_tipo_documento_trabajador = dt.id_tipo_documento_trabajador),
			dt.id_trabajador,
			dt.descripcion,
			dt.ruta,
			dt.eliminado,
			(SELECT	a.fecha_hora AS fecha_hora_auditoria FROM escalafon.auditoria  AS a WHERE ( a.id_operacion = 1 OR a.id_operacion = 2 )
								AND a.tabla = \'documento_trabajador\' AND a.objeto_id_nombre = \'id_documento_trabajador\' AND a.objeto_id_valor = dt.id_documento_trabajador
								ORDER BY a.id_auditoria DESC LIMIT 1 ),
							(SELECT
										pn.nombre_completo  AS usuario_auditoria
									FROM adm.usuario u
									LEFT JOIN public.persona_natural pn ON pn.id_persona = u.id_persona
									WHERE u.id_usuario = (SELECT	aa.id_usuario	FROM escalafon.auditoria  AS aa WHERE ( aa.id_operacion = 1 OR aa.id_operacion = 2 )
									AND aa.tabla = \'documento_trabajador\' AND aa.objeto_id_nombre = \'id_documento_trabajador\' AND aa.objeto_id_valor = dt.id_documento_trabajador
									ORDER BY aa.id_auditoria DESC LIMIT 1))
		FROM
			escalafon.documento_trabajador AS dt
		WHERE ( dt.id_documento_trabajador = :id_documento_trabajador)
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_documento_trabajador', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new DocumentoTrabajador;
				$temp->idDocumentoTrabajador 	        = $datos['id_documento_trabajador'];
				$temp->idTipoDocumentoTrabajador 		= $datos['id_tipo_documento_trabajador'];
				$temp->tipoDocumentoTrabajador 			= $datos['tipo_documento'];
				$temp->idTrabajador 					= $datos['id_trabajador'];
				$temp->descripcion 						= $datos['descripcion'];
				$temp->ruta								= $datos['ruta'];
				$temp->fechaHoraAuditoria				= $datos['fecha_hora_auditoria'];
				$temp->usuarioAuditoria					= $datos['usuario_auditoria'];
				//$temp->eliminado						= $datos['eliminado'];



				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}

	private function fncGuardarDocumentoTrabajador($dtModel)
	{
		$sql = cls_control::get_instancia();

		$id_tipo_documento_trabajador 	= $dtModel->getIdTipoDocumentoTrabajador();
		$id_trabajador				 	= $dtModel->getIdTrabajador();
		$descripcion					= $dtModel->getDescripcion();
		$ruta							= $dtModel->getRuta();
		$eliminado						= $dtModel->getEliminado();

		$consulta = "INSERT INTO escalafon.documento_trabajador
		(
			-- id_documento_trabajador -- this column value is auto-generated
			id_tipo_documento_trabajador,
			id_trabajador,
			descripcion,
			ruta,
			eliminado
		)
		VALUES
		(
			 :id_tipo_documento_trabajador,
			 :id_trabajador,
			 :descripcion,
			 :ruta,
			 :eliminado
		)
		RETURNING id_documento_trabajador";

		$statement = $sql->preparar($consulta);
		//var_dump($consulta);
		if ($statement != false) {
			$statement->bindParam('id_tipo_documento_trabajador', $id_tipo_documento_trabajador);
			$statement->bindParam('id_trabajador', $id_trabajador);
			$statement->bindParam('descripcion', $descripcion);
			$statement->bindParam('ruta', $ruta);
			$statement->bindParam('eliminado', $eliminado);
			$sql->ejecutar();
			$datos = $statement->fetch(PDO::FETCH_ASSOC);

			if ($datos) {

				$dtModel->setIdDocumentoTrabajador($datos["id_documento_trabajador"]);

				$sql->cerrar();
				return $dtModel;
			} else {
				$sql->cerrar();
				return false;
			}
		}
	}



	private function fncModificarDocumentoTrabajador($dtModel)
	{
		$sql = cls_control::get_instancia();
		$id_documento_trabajador 		= $dtModel->getIdDocumentoTrabajador();
		$id_tipo_documento_trabajador 	= $dtModel->getIdTipoDocumentoTrabajador();
		$id_trabajador				 	= $dtModel->getIdTrabajador();
		$descripcion					= $dtModel->getDescripcion();
		$ruta							= $dtModel->getRuta();
		$eliminado						= $dtModel->getEliminado();
		if ($ruta != '') {
			$modificarArchivoScript = ',ruta = :ruta';
		}
		$consulta = "
		
		UPDATE escalafon.documento_trabajador
		SET
			-- id_documento_trabajador -- this column value is auto-generated
			id_tipo_documento_trabajador = :id_tipo_documento_trabajador,
			descripcion = :descripcion". $modificarArchivoScript . "
		WHERE  id_documento_trabajador = :id_documento_trabajador
		";
			$statement = $sql->preparar($consulta);
		if ($statement != false) {
			$statement->bindParam('id_documento_trabajador', $id_documento_trabajador);
			$statement->bindParam('id_tipo_documento_trabajador', $id_tipo_documento_trabajador);
			//$statement->bindParam('id_trabajador', $id_trabajador);
			$statement->bindParam('descripcion', $descripcion);
			if ($ruta != '') {
				$statement->bindParam("ruta", $ruta);
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


	private function fncEliminarBD($id)
	{
		$bolReturn = false;
		$sql = cls_control::get_instancia();
		$consulta = 'UPDATE escalafon.documento_trabajador
		SET
			-- id_documento_trabajador -- this column value is auto-generated
			
			eliminado = 1
		WHERE id_documento_trabajador = :id_documento_trabajador';
		$statement = $sql->preparar($consulta);
		if ($statement != false) {
			$statement->bindParam('id_documento_trabajador', $id);
			$sql->ejecutar();
			$datos = $statement->fetchAll(PDO::FETCH_OBJ);
			if ($datos) {
				$bolReturn = true;
			}
			$sql->cerrar();
		}
		return $bolReturn;
	}

	private function fncObtenerNombreCompletoUsuarioDocumentoBD($id_usuario)
	{
		$sql = cls_control::get_instancia();

		$query = '
		SELECT
			pn.nombres || \' \' || pn.apellidos AS nombre_completo
		FROM adm.usuario u
		LEFT JOIN public.persona_natural pn ON pn.id_persona = u.id_persona
		WHERE u.id_usuario = :id_usuario
		';

		$statement = $sql->preparar($query);
		$nombreCompleto = "";

		if ($statement) {
			$statement->bindParam("id_usuario", $id_usuario);
			$sql->ejecutar();

			$registro = $statement->fetch(PDO::FETCH_ASSOC);

			$nombreCompleto = $registro["nombre_completo"];
		}

		return $nombreCompleto;
	}


} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom

function fncObtenerRuta(){
	return"../../archivos/escalafon/trabajador";
}

function fncConstruirNombreDocumentoTrabajador($archivo){
	$nombre =fncQuitarExtensionDocumentoTrabajador($archivo['name']).'_'.uniqid().'_';
	return $nombre;
}
function fncQuitarExtensionDocumentoTrabajador($string){
    $a = explode('.', $string);
    array_pop($a);
    return implode('.', $a);
}

?>