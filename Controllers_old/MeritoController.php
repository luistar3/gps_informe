<?php
require_once '../../App/Escalafon/Models/Merito.php';
require_once '../../App/Escalafon/Controllers/AuditoriaController.php';
require_once '../../App/Config/control.php';
require_once '../../App/Public/archivo.php';
require_once '../../App/Public/rutas.php';

class MeritoController extends Merito
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

				$model["idMerito"]        			= $listado->idMerito;
				$model["idTrabajador"]         		= $listado->idTrabajador;
				$model["idTipoDocumentoMerito"]  	= $listado->idTipoDocumentoMerito;
				$model["tipoDocumentoMerito"]  		= $listado->tipoDocumentoMerito;				
				$model["fechaDocumento"]   			= fncFormatearFecha($listado->fechaDocumento);
				$model["dias"]  					= $listado->dias;
				$model["documento"]              	= $listado->documento;
				$model["fechaEvento"]              	= fncFormatearFecha($listado->fechaEvento);
				$model["archivo"]		            = $listado->archivo;
				$model["eliminado"]		            = $listado->eliminado;
				$model["fechaHoraAuditoria"]		= ($listado->fechaHoraAuditoria);
				$model["usuarioAuditoria"]			= $listado->usuarioAuditoria;

				array_push($dtReturn, $model);
			}
		}
		return $dtReturn;
	}

	public function fncListarTipoDocumentoMerito($id = -1)
	{

		$dtReturn = array();
		$dtListado = $this->fncListarTipoDocumentoMeritoBD($id);

		if (fncGeneralValidarDataArray($dtListado)) {
			foreach ($dtListado as $listado) {

				$model = array();

				$model["idTipoDocumentoMerito"]        			= $listado->idTipoDocumentoMerito;
				$model["tipoDocumentoMerito"]         		= $listado->tipoDocumentoMerito;
	
				array_push($dtReturn, $model);
			}
		}
		return $dtReturn;
	}
	public function fncObtenerRegistro($id = -1)
	{

		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosBD($id);

		if (fncGeneralValidarDataArray($dtListado)) {
			foreach ($dtListado as $listado) {

				$model = array();

				$model["idMerito"]        			= $listado->idMerito;
				$model["idTrabajador"]         		= $listado->idTrabajador;
				$model["idTipoDocumentoMerito"]  	= $listado->idTipoDocumentoMerito;
				$model["tipoDocumentoMerito"]  		= $listado->tipoDocumentoMerito;				
				$model["fechaDocumento"]   			= ($listado->fechaDocumento);
				$model["motivo"]  					= $listado->motivo;
				$model["dias"]  					= $listado->dias;
				$model["documento"]              	= $listado->documento;
				$model["fechaEvento"]              	= ($listado->fechaEvento);
				$model["archivo"]		            = $listado->archivo;
				$model["eliminado"]		            = $listado->eliminado;
				$model["fechaHoraAuditoria"]		= ($listado->fechaHoraAuditoria);
				$model["usuarioAuditoria"]			= $listado->usuarioAuditoria;

				array_push($dtReturn, $model);
			}
		}
		return array_shift($dtReturn);
	}
	public function fncListarRegistroMeritoAuditoria($id = -1)
	{

		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosAuditoriaBD($id);

		if (fncGeneralValidarDataArray($dtListado)) {
			foreach ($dtListado as $listado) {

				$model = array();

				$model["id_merito"]        			= $listado->idMerito;
				$model["id_tipo_documento_merito"]  = $listado->idTipoDocumentoMerito;
				$model["id_trabajador"]         	= $listado->idTrabajador;
				$model["fecha_documento"]   		= $listado->fechaDocumento;
				$model["dias"]  					= $listado->dias;
				$model["documento"]              	= $listado->documento;
				$model["fecha_evento"]              = $listado->fechaEvento;
				$model["archivo"]		            = $listado->archivo;
				$model["eliminado"]		            = $listado->eliminado;

				array_push($dtReturn, $model);
			}
		}
		return $dtReturn;
	}
	public function fncBuscarPorIdTrabajador($id)
	{

		$dtReturn = array();
		$listaAuditoria = array();
		//$idTrabajador = (Int)fncObtenerValorArray($arrayInputs, 'idTrabajador', true);
		$dtListado = $this->fncBuscarPoridTrabajadorBD((Int)($id));
		$accion = 4;

		if (fncGeneralValidarDataArray($dtListado)) {

			foreach ($dtListado as $listado) {


				$model = array();
				$model["idMerito"]        			= $listado->idMerito;
				$model["idTrabajador"]         		= $listado->idTrabajador;
				$model["idTipoDocumentoMerito"]  	= $listado->idTipoDocumentoMerito;
				$model["tipoDocumentoMerito"]  		= $listado->tipoDocumentoMerito;				
				$model["fechaDocumento"]   			= ($listado->fechaDocumento);
				$model["motivo"]  					= $listado->motivo;
				$model["dias"]  					= $listado->dias;
				$model["documento"]              	= $listado->documento;
				$model["fechaEvento"]              	= ($listado->fechaEvento);
				$model["archivo"]		            = $listado->archivo;
				$model["eliminado"]		            = $listado->eliminado;
				$model["fechaHoraAuditoria"]		= ($listado->fechaHoraAuditoria);
				$model["usuarioAuditoria"]			= $listado->usuarioAuditoria;


				array_push($dtReturn, $model);
				array_push($listaAuditoria, $model['idMerito']);
			}

			$auditorioController = new AuditoriaController();
			$auditoria = $auditorioController->fncGuardar($accion, 'merito', 'id_merito', null, json_encode($listaAuditoria));
		}
		return $dtReturn;
	}
	public function fncBuscarDniPorNombre($arrayInputs)
	{

		$dtReturn = array();
		//$listaAuditoria = array();
		$documentoIdentidad = fncObtenerValorArray($arrayInputs, 'nombre', true);
		$dtListado = $this->fncBuscarDniPorNombreBD($documentoIdentidad);
		//$accion = 4;

		if (fncGeneralValidarDataArray($dtListado)) {

			foreach ($dtListado as $listado) {


				$model = array();
				$model["idTrabajador"]        		= $listado->idTrabajador;
				$model["nombreCompleto"]        	= $listado->nombreCompleto;
				$model["documento_identidad"] 		= $listado->documentoIdentidad;
				$model["nombreCargo"]         		= $listado->nombreCargo;
				$model["nombreArea"]   			= $listado->nombreArea;
				$model["denominacionCargo"]  		= $listado->denominacionCargo;
				$model["suspendido"]              	= $listado->suspendido;
				$model["codigoUnico"]              = $listado->codigoUnico;
				$model["foto"]		            	= $listado->foto;


				array_push($dtReturn, $model);
				//array_push($listaAuditoria, $model['id_merito']);
			}

			//$auditorioController = new AuditoriaController();	
			//$auditoria = $auditorioController->fncGuardar($accion, 'merito','id_merito', null, json_encode($listaAuditoria) );
		}
		return $dtReturn;
	}

	public function fncGuardar($arrayInputs, $archivoInput = '')
	{
		$dtReturn = array();
		$accion = 0;
		$inputIdMerito = (int) fncObtenerValorArray($arrayInputs, 'idMerito', true);
		$inputTipoDocumentoMerito = (int) fncObtenerValorArray($arrayInputs, 'idTipoDocumentoMerito', true);
		$inputIdTrabajador = (int) fncObtenerValorArray($arrayInputs, 'idTrabajador', true);
		$inputFechaDocumento = fncObtenerValorArray($arrayInputs, 'fechaDocumento', true);
		$inputMotivo		= fncObtenerValorArray($arrayInputs, 'motivo', true);
		$inputDias			= (int) fncObtenerValorArray($arrayInputs, 'dias', true);
		$inputDocumento			= fncObtenerValorArray($arrayInputs, 'documento', true);
		$inputFechaEvento = fncObtenerValorArray($arrayInputs, 'fechaEvento', true);


		$dtMerito = new Merito;


		if (!empty($inputIdMerito)) {
			$dtMerito->setIdMerito($inputIdMerito);
		}
		if (!empty($inputTipoDocumentoMerito)) {
			$dtMerito->setIdTipoDocumentoMerito($inputTipoDocumentoMerito);
		}
		if (!empty($inputIdTrabajador)) {
			$dtMerito->setIdTrabajador($inputIdTrabajador);
		}
		if (!empty($inputFechaDocumento)) {
			$dtMerito->setFechaDocumento($inputFechaDocumento);
		}
		if (!empty($inputMotivo)) {
			$dtMerito->setMotivo($inputMotivo);
		}
		if (!empty($inputDias)) {
			$dtMerito->setDias($inputDias);
		}
		if (!empty($inputFechaEvento)) {
			$dtMerito->setFechaEvento($inputFechaEvento);
		}
		if (!empty($inputDocumento)) {
			$dtMerito->setDocumento($inputDocumento);
		}

		if (fncGeneralValidarDataArray($dtMerito)) {
			$dtGuardar = array();
			$optArchivo = "";
			if ($inputIdMerito == 0 && $inputIdTrabajador != 0) {
				if (!empty($archivoInput)) {
					if ($archivoInput["name"] <> "") {
						$optRutaArchivo = cls_rutas::get('meritoPdf');
						//$rutas=fncObtenerRuta();
						$nombreArchivo = fncConstruirNombreDocumentoMerito($archivoInput);
						$obj_arc = new archivo($archivoInput, $optRutaArchivo, "pdf_" . $nombreArchivo, 0);
						if ($obj_arc->subir()) {
							$optArchivo = $obj_arc->get_nombre_archivo();
							$dtMerito->setArchivo($optRutaArchivo.$obj_arc->get_nombre_archivo());
						}
					}
				}
				$dtGuardar = $this->fncRegistrarBD($dtMerito);
				$accion = 1;
			} else {

				if (!empty($archivoInput)) {
					if ($archivoInput["name"] <> "") {
						$optRutaArchivo = cls_rutas::get('meritoPdf');
						//$rutas=fncObtenerRuta();
						$nombreArchivo = fncConstruirNombreDocumentoMerito($archivoInput);
						$obj_arc = new archivo($archivoInput, $optRutaArchivo, "pdf_" . $nombreArchivo, 0);
						if ($obj_arc->subir()) {
							$optArchivo = $obj_arc->get_nombre_archivo();
							$dtMerito->setArchivo($optRutaArchivo.$obj_arc->get_nombre_archivo());
						}
					}
				}
				$dtGuardar = $this->fncActualizarBD($dtMerito);
				$accion = 2;
			}

			if (fncGeneralValidarDataArray($dtGuardar)) {

				$model = array();
				$model["idMerito"]        			= $dtGuardar->getIdMerito();
				$model["idTipoDocumentoMerito"]  = $dtGuardar->getIdTipoDocumentoMerito();
				$model["idTrabajador"]         	= $dtGuardar->getIdTrabajador();
				$model["fechaDocumento"]   		= fncFormatearFecha($dtGuardar->getFechaDocumento());
				$model["dias"]  					= $dtGuardar->getDias();
				$model["documento"]              	= $dtGuardar->getDocumento();
				$model["fechaEvento"]              = fncFormatearFecha($dtGuardar->getFechaEvento());
				$model["archivo"]		            = $dtGuardar->getArchivo();


				

				$auditorioController = new AuditoriaController();
				$auditoria = $auditorioController->fncGuardar($accion, 'merito', 'id_merito', $model["idMerito"], json_encode($model));
				array_push($dtReturn, $this->fncObtenerRegistro($dtMerito->getIdMerito()));
				unset($model);
			}
		}
		return (array_shift($dtReturn));
	}

	public function fncEliminarRegistro($id = 0)
	{

		$bolReturn = array();
		if ($id > 0) {
			$bolValidarEliminar = $this->fncEliminarBD($id);
			if ($bolValidarEliminar) {

				$dtMerito = $this->fncListarRegistroMeritoAuditoria($id);
				$bolReturn = $dtMerito;

				$auditorioController = new AuditoriaController();
				$auditoria = $auditorioController->fncGuardar(2, 'merito', 'id_merito', $id, json_encode($dtMerito));

				$bolReturn = $this->fncObtenerRegistro($id);
			}
		}
		return ($bolReturn);
	}



	public function fncListarTipoResolucion($id=-1)
	{

		$dtReturn = array();
	
		$dtListado = $this->fncListarTipoResolucionBD($id);
	

		if (fncGeneralValidarDataArray($dtListado)) {

			foreach ($dtListado as $listado) {


				$model = array();
				$model["idTipoResolucion"]        		= $listado->idTipoResolucion;
				$model["nombre"]        	= $listado->nombre;
				array_push($dtReturn, $model);
				//array_push($listaAuditoria, $model['id_merito']);
			}

			//$auditorioController = new AuditoriaController();	
			//$auditoria = $auditorioController->fncGuardar($accion, 'merito','id_merito', null, json_encode($listaAuditoria) );
		}
		return $dtReturn;
	}

	//=======================================================================================
	//FUNCIONES BASE DE DATOS
	//=======================================================================================

	private function fncListarRegistrosBD($id = -1)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
		--	(SELECT	 	p.documento_identidad	   FROM 	"public".persona AS p WHERE p.id_persona = m.id_trabajador )AS documento_identidad,
			m.id_merito,		
			m.id_trabajador,
		--	(SELECT	 	pn.nombres|| \' \'||	 	pn.apellidos	 FROM 	"public".persona_natural AS pn WHERE pn.id_persona = m.id_trabajador )AS nombre_completo,
			m.id_tipo_documento_merito,
			(SELECT	 	tdm.tipo_documento_merito	 FROM 	escalafon.tipo_documento_merito AS tdm WHERE tdm.id_tipo_documento_merito = m.id_tipo_documento_merito),
			m.fecha_documento,
			motivo,
			m.dias,
			m.documento,
			m.eliminado,
			m.fecha_evento,
			m.archivo,(SELECT	a.fecha_hora AS fecha_hora_auditoria FROM escalafon.auditoria  AS a WHERE ( a.id_operacion = 1 OR a.id_operacion = 2 )
							AND a.tabla = \'merito\' AND a.objeto_id_nombre = \'id_merito\' AND a.objeto_id_valor = m.id_merito
							ORDER BY a.id_auditoria DESC LIMIT 1 ),
						(SELECT
									pn.nombre_completo  AS usuario_auditoria
								FROM adm.usuario u
								LEFT JOIN public.persona_natural pn ON pn.id_persona = u.id_persona
								WHERE u.id_usuario = (SELECT	aa.id_usuario	FROM escalafon.auditoria  AS aa WHERE ( aa.id_operacion = 1 OR aa.id_operacion = 2 )
								AND aa.tabla = \'merito\' AND aa.objeto_id_nombre = \'id_merito\' AND aa.objeto_id_valor = m.id_merito
								ORDER BY aa.id_auditoria DESC LIMIT 1)),
			m.eliminado
		FROM
			escalafon.merito AS m WHERE m.id_merito = :id_merito
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_merito', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new Merito;
				$temp->idMerito 	        	= $datos['id_merito'];
				$temp->idTrabajador 			= $datos['id_trabajador'];
				$temp->idTipoDocumentoMerito 	= $datos['id_tipo_documento_merito'];
				$temp->tipoDocumentoMerito 		= $datos['tipo_documento_merito'];
				$temp->fechaDocumento			= $datos['fecha_documento'];
				$temp->motivo						= $datos['motivo'];
				$temp->dias						= $datos['dias'];
				$temp->documento				= $datos['documento'];
				$temp->fechaEvento				= $datos['fecha_evento'];
				$temp->archivo					= $datos['archivo'];
				$temp->eliminado				= $datos['eliminado'];
				$temp->fechaHoraAuditoria		= $datos['fecha_hora_auditoria'];
				$temp->usuarioAuditoria			= $datos['usuario_auditoria'];
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}


	private function fncListarTipoDocumentoMeritoBD($id = -1)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			tdm.id_tipo_documento_merito,
			tdm.tipo_documento_merito
		FROM
			escalafon.tipo_documento_merito AS tdm
		WHERE (:id_tipo_documento_merito = -1 OR tdm.id_tipo_documento_merito = :id_tipo_documento_merito) 
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_tipo_documento_merito', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new Merito;
				$temp->idTipoDocumentoMerito 	    = $datos['id_tipo_documento_merito'];
				$temp->tipoDocumentoMerito 			= $datos['tipo_documento_merito'];
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
			m.id_merito,
			m.id_trabajador,
			m.id_tipo_documento_merito,
			m.fecha_documento,
			m.dias,
			m.documento,
			m.fecha_evento,
			m.archivo,
			m.eliminado
		FROM
			escalafon.merito AS m
		WHERE (:id_merito = -1 OR m.id_merito = :id_merito) 
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_merito', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new Merito;
				$temp->idMerito 	        	= $datos['id_merito'];
				$temp->idTrabajador 			= $datos['id_trabajador'];
				$temp->idTipoDocumentoMerito 	= $datos['id_tipo_documento_merito'];
				$temp->fechaDocumento			= $datos['fecha_documento'];
				$temp->dias						= $datos['dias'];
				$temp->documento				= $datos['documento'];
				$temp->fechaEvento				= $datos['fecha_evento'];
				$temp->archivo					= $datos['archivo'];
				$temp->eliminado				= $datos['eliminado'];
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}
	private function fncBuscarPoridTrabajadorBD($idTrabajador)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
	--	(SELECT	 	p.documento_identidad	   FROM 	"public".persona AS p WHERE p.id_persona = m.id_trabajador )AS documento_identidad,
		m.id_merito,		
		m.id_trabajador,
	--	(SELECT	 	pn.nombres|| \' \'||	 	pn.apellidos	 FROM 	"public".persona_natural AS pn WHERE pn.id_persona = m.id_trabajador )AS nombre_completo,
		m.id_tipo_documento_merito,
		(SELECT	 	tdm.tipo_documento_merito	 FROM 	escalafon.tipo_documento_merito AS tdm WHERE tdm.id_tipo_documento_merito = m.id_tipo_documento_merito),
		m.fecha_documento,
		m.dias,
		m.motivo,
		m.documento,
		m.eliminado,
		m.fecha_evento,
		m.archivo,(SELECT	a.fecha_hora AS fecha_hora_auditoria FROM escalafon.auditoria  AS a WHERE ( a.id_operacion = 1 OR a.id_operacion = 2 )
						AND a.tabla = \'merito\' AND a.objeto_id_nombre = \'id_merito\' AND a.objeto_id_valor = m.id_merito
						ORDER BY a.id_auditoria DESC LIMIT 1 ),
					(SELECT
								pn.nombre_completo  AS usuario_auditoria
							FROM adm.usuario u
							LEFT JOIN public.persona_natural pn ON pn.id_persona = u.id_persona
							WHERE u.id_usuario = (SELECT	aa.id_usuario	FROM escalafon.auditoria  AS aa WHERE ( aa.id_operacion = 1 OR aa.id_operacion = 2 )
							AND aa.tabla = \'merito\' AND aa.objeto_id_nombre = \'id_merito\' AND aa.objeto_id_valor = m.id_merito
							ORDER BY aa.id_auditoria DESC LIMIT 1)),
		m.eliminado
	FROM
		escalafon.merito AS m WHERE m.id_trabajador = :id_trabajador AND m.eliminado = 0
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_trabajador', $idTrabajador);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new Merito;
				//$temp->documentoIdentidad      	= $datos['documento_identidad'];
				//$temp->nombreCompleto     		= $datos['nombre_completo'];
				$temp->idMerito 	        	= $datos['id_merito'];
				$temp->idTrabajador 			= $datos['id_trabajador'];
				$temp->idTipoDocumentoMerito 	= $datos['id_tipo_documento_merito'];
				$temp->tipoDocumentoMerito 		= $datos['tipo_documento_merito'];
				$temp->fechaDocumento			= $datos['fecha_documento'];
				$temp->motivo					= $datos['motivo'];
				$temp->dias						= $datos['dias'];
				$temp->documento				= $datos['documento'];
				$temp->fechaEvento				= $datos['fecha_evento'];
				$temp->archivo					= $datos['archivo'];
				$temp->eliminado				= $datos['eliminado'];
				$temp->fechaHoraAuditoria		= $datos['fecha_hora_auditoria'];
				$temp->usuarioAuditoria			= $datos['usuario_auditoria'];


				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}

	private function fncBuscarDniPorNombreBD($nombre)
	{
		$sql = cls_control::get_instancia();

		$where = "(LOWER(translate(pn.nombre_completo,'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU')) LIKE '%' || :nombre_completo || '%')";
		$query = "
		SELECT
			t.id_trabajador,
			pn.nombre_completo,
			p.documento_identidad,
			(SELECT	c.nombre_cargo FROM	escalafon.cargo AS c WHERE c.id_cargo = d.id_cargo ),
			(SELECT	a.nombre_area FROM	escalafon.area AS a WHERE a.id_area = d.id_area),
			d.denominacion_cargo,
			t.suspendido,
			t.codigo_unico,
			pn.foto
		FROM
			escalafon.desplazamiento AS d
			INNER JOIN escalafon.trabajador AS t ON t.id_trabajador = d.id_trabajador
			INNER JOIN public.persona_natural AS pn ON pn.id_persona = t.id_trabajador
			INNER JOIN public.persona AS p ON p.id_persona = pn.id_persona

		WHERE (d.actual = 1 AND d.anulado = 0 AND d.eliminado = 0) 
			  AND " . " " . $where;

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('nombre_completo', $nombre);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new Merito;
				$temp->idTrabajador      		= $datos['id_trabajador'];
				$temp->nombreCompleto     		= $datos['nombre_completo'];
				$temp->documentoIdentidad 	    = $datos['documento_identidad'];
				$temp->nombreCargo 				= $datos['nombre_cargo'];
				$temp->nombreArea			 	= $datos['nombre_area'];
				$temp->denominacionCargo		= $datos['denominacion_cargo'];
				$temp->suspendido				= $datos['suspendido'];
				$temp->codigoUnico				= $datos['codigo_unico'];
				$temp->foto						= $datos['foto'];


				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}


	private function fncListarTipoResolucionBD($id=-1)
	{
		$sql = cls_control::get_instancia();

		
		$query = "

		SELECT
			tr.id_tipo_resolucion,
			tr.nombre
		FROM
			escalafon.tipo_resolucion AS tr
		WHERE (:id_tipo_resolucion = -1 OR id_tipo_resolucion = :id_tipo_resolucion)
		 ";

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_tipo_resolucion', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new Merito;
				$temp->idTipoResolucion     = $datos['id_tipo_resolucion'];
				$temp->nombre     		= $datos['nombre'];
			


				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}



	public function fncRegistrarBD($dtModel)
	{
		//$idMerito = $dtModel->getIdMerito();
		$idTrabajador = $dtModel->getIdTrabajador();
		$tipoDocumentoMerito = $dtModel->getIdTipoDocumentoMerito();
		$fechaDocumento = $dtModel->getFechaDocumento();
		$motivo = $dtModel->getMotivo();
		$dias = $dtModel->getDias();
		$documento = $dtModel->getDocumento();
		$fechaEvento = $dtModel->getFechaEvento();
		$archivo = $dtModel->getArchivo();
		if ($archivo == '') {
			$archivo = NULL;
		}

		$sql = cls_control::get_instancia();
		$consulta = "INSERT INTO escalafon.merito
					(
						-- id_merito -- this column value is auto-generated
						id_trabajador,
						id_tipo_documento_merito,
						fecha_documento,
						motivo,
						dias,
						documento,
						fecha_evento,
						archivo,
						eliminado
					)
					VALUES
					(
						:id_trabajador,
						:id_tipo_documento_merito,
						:fecha_documento,
						:motivo,
						:dias,
						:documento,
						:fecha_evento,
						:archivo,
						0 
					)
				   RETURNING id_merito";
		$statement = $sql->preparar($consulta);
		if ($statement != false) {
			$statement->bindParam("id_trabajador", $idTrabajador);
			$statement->bindParam("id_tipo_documento_merito", $tipoDocumentoMerito);
			$statement->bindParam("fecha_documento", $fechaDocumento);
			$statement->bindParam("motivo", $motivo);
			$statement->bindParam("dias", $dias);
			$statement->bindParam("documento", $documento);
			$statement->bindParam("fecha_evento", $fechaEvento);
			$statement->bindParam("archivo", $archivo);
			$sql->ejecutar();
			$datos = $statement->fetch(PDO::FETCH_ASSOC);
			if ($datos) {
				//_Retorno de Datos
				$dtModel->setIdMerito($datos["id_merito"]);

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
		$idMerito = $dtModel->getIdMerito();
		$idTrabajador = $dtModel->getIdTrabajador();
		$tipoDocumentoMerito = $dtModel->getIdTipoDocumentoMerito();
		$fechaDocumento = $dtModel->getFechaDocumento();
		$motivo = $dtModel->getMotivo();
		$dias = $dtModel->getDias();
		$documento = $dtModel->getDocumento();
		$fechaEvento = $dtModel->getFechaEvento();
		$archivo = $dtModel->getArchivo();
		$modificarArchivoScript = '';
		if ($archivo != '') {
			$modificarArchivoScript = ',archivo = :archivo';
		}
		$sql = cls_control::get_instancia();
		$query = "UPDATE escalafon.merito
				SET
					-- id_merito -- this column value is auto-generated
					id_trabajador =  :id_trabajador,
					id_tipo_documento_merito =  :id_tipo_documento_merito,
					fecha_documento =  :fecha_documento,
					motivo =  :motivo,
					dias =  :dias,
					documento =  :documento,
					fecha_evento =  :fecha_evento " . $modificarArchivoScript . "
				WHERE id_merito = :id_merito";
		$statement = $sql->preparar($query);
		if ($statement != false) {
			$statement->bindParam("id_merito", $idMerito);
			$statement->bindParam("id_trabajador", $idTrabajador);
			$statement->bindParam("id_tipo_documento_merito", $tipoDocumentoMerito);
			$statement->bindParam("fecha_documento", $fechaDocumento);
			$statement->bindParam("motivo", $motivo);
			$statement->bindParam("dias", $dias);
			$statement->bindParam("documento", $documento);
			$statement->bindParam("fecha_evento", $fechaEvento);
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


	private function fncEliminarBD($id)
	{
		$bolReturn = false;
		$sql = cls_control::get_instancia();
		$consulta = 'UPDATE escalafon.merito
		SET		
			eliminado = 1
		WHERE id_merito = :id_merito';
		$statement = $sql->preparar($consulta);
		if ($statement != false) {
			$statement->bindParam('id_merito', $id);
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
function fncConstruirNombreDocumentoMerito($archivo)
{
	$nombre = fncQuitarExtensionDocumentoMerito($archivo['name']) . '_' . uniqid() . '_';
	return $nombre;
}
function fncQuitarExtensionDocumentoMerito($string)
{
	$a = explode('.', $string);
	array_pop($a);
	return implode('.', $a);
}
