<?php
require_once '../../App/Escalafon/Models/NivelEducativo.php';
require_once '../../App/Config/control.php';
require_once '../../App/Public/archivo.php';
require_once '../../App/Public/rutas.php';
require_once '../../App/Escalafon/Controllers/AuditoriaController.php';
require_once '../../App/Escalafon/Controllers/TipoCondicionNivelEducativoController.php';
require_once '../../App/Escalafon/Controllers/TipoCentroEstudioController.php';
require_once '../../App/Escalafon/Controllers/TipoNivelEducativoController.php';
require_once '../../App/General/Controllers/PersonaNaturalController.php';

class NivelEducativoController extends NivelEducativo
{
	//=======================================================================================
	//FUNCIONES LOGICA
	//=======================================================================================

	public function fncListarRegistros($id = -1)
	{

		$dtReturn = array();
		$dataRetorno = array();
		$dtListado = $this->fncListarRegistrosBD($id);
		$clsPersonaNaturalController = new PersonaNaturalController();
		$clsAuditoriaController = new AuditoriaController();

		$clsTipoCondicionNivelEducativoController = new TipoCondicionNivelEducativoController();
		$clsTipoCentroEstudioController = new TipoCentroEstudioController();
		$clsTipoNivelEducativoController = new TipoNivelEducativoController();
	
		

		if( fncGeneralValidarDataArray($dtListado) ){

			$accion=4;
			$listaAuditoria=array();
			$fecha_hora = '';
			foreach( $dtListado as $listado ){
				$dtAuditoria 	= $clsAuditoriaController->fncBuscarCampoAuditoria('nivel_educativo', 'id_nivel_educativo', $listado->idNivelEducativo);
				if (fncGeneralValidarDataArray($dtAuditoria)) {
					$Auditoria = array_shift($dtAuditoria);
					$fecha_hora = fncObtenerValorArray($Auditoria, 'fecha_hora', true);
					//$idUsuario = (Int) fncObtenerValorArray($Auditoria, 'id_usuario', true);
				}
				$model = array();
				
				$model['idNivelEducativo']	=$listado->idNivelEducativo;
				$model['idTrabajador'] 		=$listado->idTrabajador;				
				$model['nombreCentroEstudios']=$listado->nombreCentroEstudios;
				$model['tituloObtenido'] 		=$listado->tituloObtenido;
				$model['idTipoCondicionNivelEducativo'] 		=$listado->idTipoCondicionNivelEducativo;
				$model['tipoCondicionNivelEducativo'] 		= array_shift($clsTipoCondicionNivelEducativoController->fncListarRegistros($listado->idTipoCondicionNivelEducativo));
				$model['fecha'] 				=$listado->fecha;
				$model['archivo'] 				=$listado->archivo;
				$model['persona'] 				=array_shift($clsPersonaNaturalController->fncListarRegistros($listado->idTrabajador));
				$model['auditoriaFecha'] 		= $fecha_hora;

				$model['idTipoCentroEstudio'] 		=$listado->idTipoCentroEstudio;
				$model['tipoCentroEstudio'] 					= array_shift($clsTipoCentroEstudioController->fncListarRegistros($listado->idTipoCentroEstudio));
				$model['idTipoNivelEducativo'] 		=$listado->idTipoNivelEducativo;
				$model['tipoNivelEducativo'] 		= array_shift($clsTipoNivelEducativoController->fncListarRegistros( $listado->idTipoNivelEducativo));
				

				array_push($dtReturn, $model);
				array_push($listaAuditoria, $model);
			}
			$dataRetorno=array_shift($model);
			
			$auditorioController = new AuditoriaController();	
			$auditoria = $auditorioController->fncGuardar($accion, 'nivel_educativo','id_nivel_educativo', null, json_encode($listaAuditoria) );
		}
		return array_shift(reemplazarNullPorVacioNivelEducativo($dtReturn));
	}


	public function fncListarRegistroAuditoria($id)
	{

		$dtReturn = array();
		$dtListado = $this->fncListarRegistroAuditoriaBD($id);
		$clsPersonaNaturalController = new PersonaNaturalController();
		$clsTipoCondicionNivelEducativoController = new TipoCondicionNivelEducativoController();
		$clsTipoCentroEstudioController = new TipoCentroEstudioController();
		$clsTipoNivelEducativoController = new TipoNivelEducativoController();

		if (fncGeneralValidarDataArray($dtListado)) {

			$accion = 4;
			$listaAuditoria = array();
			foreach ($dtListado as $listado) {

				$model = array();

				$model['id_nivel_educativo']	= $listado->idNivelEducativo;
				$model['id_trabajador'] 		= $listado->idTrabajador;
				$model['nombre_centro_estudios'] = $listado->nombreCentroEstudios;
				$model['titulo_obtenido'] 		= $listado->tituloObtenido;
				$model['idTipoCondicionNivelEducativo'] 		= $listado->idTipoCondicionNivelEducativo;
				$model['fecha'] 				= $listado->fecha;
				$model['archivo'] 				= $listado->archivo;
				$model['eliminado'] 			= $listado->eliminado;
				
				$model['idTipoCentroEstudio'] 		= $listado->idTipoCentroEstudio;
				$model['idTipoNivelEducativo'] 		= $listado->idTipoCondicionNivelEducativo;


				array_push($dtReturn, $model);
				array_push($listaAuditoria, $model['id_nivel_educativo']);
			}

			//$auditorioController = new AuditoriaController();	
			//$auditoria = $auditorioController->fncGuardar($accion, 'nivel_educativo','id_nivel_educativo', null, json_encode($listaAuditoria) );
		}
		return ($dtReturn);
	}

	public function fncListarRegistrosPorIdTrabajador($id = -1)
	{

		$dtReturn = array();
		$dataRetorno = array();
		$dtListado = $this->fncListarRegistrosPorIdTrabajadorBD($id);
		$clsPersonaNaturalController = new PersonaNaturalController();
		$clsAuditoriaController = new AuditoriaController();
		$clsTipoCondicionNivelEducativoController = new TipoCondicionNivelEducativoController();
		$clsTipoCentroEstudioController = new TipoCentroEstudioController();
		$clsTipoNivelEducativoController = new TipoNivelEducativoController();

		if (fncGeneralValidarDataArray($dtListado)) {

			$accion = 4;
			$listaAuditoria = array();
			$fecha_hora = '';
			foreach ($dtListado as $listado) {
				$dtAuditoria 	= $clsAuditoriaController->fncBuscarCampoAuditoria('nivel_educativo', 'id_nivel_educativo', $listado->idNivelEducativo);
				if (fncGeneralValidarDataArray($dtAuditoria)) {
					$Auditoria = array_shift($dtAuditoria);
					$fecha_hora = fncObtenerValorArray($Auditoria, 'fecha_hora', true);
					//$idUsuario = (Int) fncObtenerValorArray($Auditoria, 'id_usuario', true);
				}

				$model = array();

				$model['idNivelEducativo']	= $listado->idNivelEducativo;
				$model['idTrabajador'] 		= $listado->idTrabajador;
				$model['nombreCentroEstudios'] = $listado->nombreCentroEstudios;
				$model['tituloObtenido'] 		= $listado->tituloObtenido;
				$model['idTipoCondicionNivelEducativo'] 		=$listado->idTipoCondicionNivelEducativo;
				$model['tipoCondicionNivelEducativo'] 		= array_shift($clsTipoCondicionNivelEducativoController->fncListarRegistros($listado->idTipoCondicionNivelEducativo));
				$model['fecha'] 				=$listado->fecha;
				$model['archivo'] 				=$listado->archivo;
				$model['persona'] 				=array_shift($clsPersonaNaturalController->fncListarRegistros($listado->idTrabajador));
				$model['auditoriaFecha'] 		= $fecha_hora;

				$model['idTipoCentroEstudio'] 		=$listado->idTipoCentroEstudio;
				$model['tipoCentroEstudio'] 					= array_shift($clsTipoCentroEstudioController->fncListarRegistros($listado->idTipoCentroEstudio));
				$model['idTipoNivelEducativo'] 		=$listado->idTipoNivelEducativo;
				$model['tipoNivelEducativo'] 		= array_shift($clsTipoNivelEducativoController->fncListarRegistros( $listado->idTipoNivelEducativo));



				array_push($dtReturn, $model);
				array_push($listaAuditoria, $model['idNivelEducativo']);
			}
			//$dataRetorno=($dtReturn);
			$dataRetorno=($dtReturn);
			$auditorioController = new AuditoriaController();
			$auditoria = $auditorioController->fncGuardar($accion, 'nivel_educativo', 'id_nivel_educativo', null, json_encode($listaAuditoria));
		}
		return reemplazarNullPorVacioNivelEducativo($dataRetorno);
	}

	public function fncListarRegistrosPorDniTrabajador($arrayInputs = '')
	{
		$dataRetorno = array();
		$dtReturn = array();
		$dni=fncObtenerValorArray($arrayInputs, 'dni', true);
		$dtListado = $this->fncListarRegistrosPorDniTrabajadorBD($dni);
		$clsPersonaNaturalController = new PersonaNaturalController();
		$clsAuditoriaController = new AuditoriaController();
		$clsTipoCondicionNivelEducativoController = new TipoCondicionNivelEducativoController();
		$clsTipoCentroEstudioController = new TipoCentroEstudioController();
		$clsTipoNivelEducativoController = new TipoNivelEducativoController();

		if (fncGeneralValidarDataArray($dtListado)) {

			$accion = 4;
			$listaAuditoria = array();
			$fecha_hora = '';
			foreach ($dtListado as $listado) {
			
				$model = array();

				$model['idNivelEducativo']	= $listado->idNivelEducativo;
				$model['idTrabajador'] 		= $listado->idTrabajador;
				//$model['trabajadorSuspendido'] = $listado->trabajadorSuspendido;
				$model['nombreCentroEstudios'] = $listado->nombreCentroEstudios;
				$model['tituloObtenido'] 		= $listado->tituloObtenido;
				$model['tipoCondicionNivelEducativo'] 		= array_shift( $clsTipoCondicionNivelEducativoController->fncListarRegistros($listado->idTipoCondicionNivelEducativo));
				$model['fecha'] 				= $listado->fecha;
				$model['archivo'] 				= $listado->archivo;	
				$model['persona'] 				= array_shift( $clsPersonaNaturalController->fncListarRegistros($listado->idTrabajador));	
				//$model['eliminado'] 			= $listado->eliminado;		
				$model['auditoria_fecha'] 		= $listado->fechaHoraAuditoria;
				//$model['auditoria_usuario'] 	= $listado->usuarioAuditoria;
				$model['tipoCentroEstudio'] 					= array_shift($clsTipoCentroEstudioController->fncListarRegistros($listado->idTipoCentroEstudio));
				$model['tipoNivelEducativo'] 		= array_shift($clsTipoNivelEducativoController->fncListarRegistros( $listado->idTipoCondicionNivelEducativo));
			

				array_push($dtReturn, $model);
				array_push($listaAuditoria, $model['idNivelEducativo']);
			}
			$dataRetorno=($dtReturn);
			$auditorioController = new AuditoriaController();
			$auditoria = $auditorioController->fncGuardar($accion, 'nivel_educativo', 'id_nivel_educativo', null, json_encode($listaAuditoria));
		}
		return reemplazarNullPorVacioNivelEducativo($dataRetorno);
	}

	public function fncGuardarDocumento($archivoInput = '')
	{
		$optArchivo = "";

		$dtReturn = array();
		if (!empty($archivoInput)) {
			if ($archivoInput["name"] <> "") {
				$optRutaArchivo = cls_rutas::get('nivelEducativoPdf');
				//$rutas=fncObtenerRuta();
				$nombreArchivo = fncConstruirNombreDocumentoNivelEdcuativo($archivoInput);
				$obj_arc = new archivo($archivoInput, $optRutaArchivo, "pdf_" . $nombreArchivo, 0);
				$fgfg = 546;
				if ($obj_arc->subir()) {
					$optArchivo = $obj_arc->get_nombre_archivo();
					//$optArchivo = $obj_arc->get_nombre_archivo();
					$objArrayDocumento = array(
						"Nombre" => $optRutaArchivo.$obj_arc->get_nombre_archivo(),
						"NombreOriginal" => $archivoInput["name"],
						"Ruta" => $optRutaArchivo . $obj_arc->get_nombre_archivo(),
						"Tamanio" => $archivoInput["size"],

					);
					array_push($dtReturn, $objArrayDocumento);
				}
			}
		}

		return $dtReturn;
	}

	public function fncGuardarDocumentoNivelEducativo($arrayInputs = '', $archivo = '')
	{

		$dtReturn = array();
		$accion = 2;
		$dtGuardar = array();
		$idNivelEducativo 	= (int) fncObtenerValorArray($arrayInputs, 'idNivelEducativo', true);
		$dtNivelEducativo = new NivelEducativo;

		if (!empty($idNivelEducativo)) {
			$dtNivelEducativo->setIdNivelEducativo($idNivelEducativo);
		}
		if (fncGeneralValidarDataArray($dtNivelEducativo)) {
			$dtDocuemento = $this->fncGuardarDocumento($archivo);
			if (fncGeneralValidarDataArray($dtDocuemento)) {
				$nombreArchivo = fncObtenerValorArray(array_shift($dtDocuemento), 'Nombre', true);
				if (!empty($idNivelEducativo)) {
					$dtNivelEducativo->setArchivo($nombreArchivo);
				}
				$dtGuardar = $this->fncActualizaDocumentoBD($dtNivelEducativo);
			}
		}

		if (fncGeneralValidarDataArray($dtGuardar)) {

			$dtListado = $this->fncListarRegistroAuditoria($idNivelEducativo);
			$returnNivelEducativo['nivel_educativo'] = array_shift($dtListado);
			$auditorioController = new AuditoriaController();
			$auditoria = $auditorioController->fncGuardar($accion, 'nivel_educativo', 'id_nivel_educativo', $dtNivelEducativo->getIdNivelEducativo(), json_encode($dtListado));
			array_push($dtReturn,$returnNivelEducativo);
		}

		return array_shift( $dtReturn);
	}


	public function fncGuardar($arrayInputs){

		//$dtReturn = array();
		$accion ="";
		
		$idNivelEducativo 	= (Int) fncObtenerValorArray( $arrayInputs, 'idNivelEducativo', true);
		$idTrabajador 		= fncObtenerValorArray( $arrayInputs, 'idTrabajador', true);
		$nombreCentroEstudios = fncObtenerValorArray( $arrayInputs, 'nombreCentroEstudios', true);
		$tituloObtenido 	= fncObtenerValorArray( $arrayInputs, 'tituloObtenido', true);
	
		$fecha 				= fncObtenerValorArray( $arrayInputs, 'fecha', true);

		$InputIdTipoCondicionNivelEducativo = (Int)fncObtenerValorArray( $arrayInputs, 'idTipoCondicionNivelEducativo', true);
		$InputIdTipoNivelEducativo = (Int)fncObtenerValorArray( $arrayInputs, 'idTipoNivelEducativo', true);
		$InputIdTipoCentroEstudio = (Int)fncObtenerValorArray( $arrayInputs, 'idTipoCentroEstudio', true);


		$dtNivelEducativo = new NivelEducativo;



		if( !empty($idNivelEducativo) )  { $dtNivelEducativo->setIdNivelEducativo($idNivelEducativo); }
		if( !empty($idTrabajador) ) 		{ $dtNivelEducativo->setIdTrabajador($idTrabajador); }
		if( !empty($nombreCentroEstudios) ) 			{ $dtNivelEducativo->setNombreCentroEstudios($nombreCentroEstudios); }
		if( !empty($tituloObtenido) ) 	{ $dtNivelEducativo->setTituloObtenido($tituloObtenido); }
		if( !empty($InputIdTipoCondicionNivelEducativo) ) 		{ $dtNivelEducativo->setIdTipoCondicionNivelEducativo($InputIdTipoCondicionNivelEducativo); }
		if( !empty($fecha) ) 			{ $dtNivelEducativo->setFecha($fecha); }

		if( !empty($InputIdTipoNivelEducativo) ) 			{ $dtNivelEducativo->setIdTipoNivelEducativo($InputIdTipoNivelEducativo); }
		if( !empty($InputIdTipoCentroEstudio) ) 			{ $dtNivelEducativo->setIdTipoCentroEstudio($InputIdTipoCentroEstudio); }
		


		if (fncGeneralValidarDataArray($dtNivelEducativo)) {
			$accion = '';
			$dtGuardar = array();
			if ($idNivelEducativo == 0) {
				$accion = 1;
				$dtNivelEducativo->setEliminado(0);
				$dtGuardar = $this->fncRegistrarBD($dtNivelEducativo);
			} else {

				$accion = 2;
				$dtNivelEducativo->setEliminado(0);
				$dtGuardar = $this->fncActualizarBD($dtNivelEducativo);
			}
		}


		if (fncGeneralValidarDataArray($dtGuardar)) {
			$clsTipoCondicionNivelEducativoController = new TipoCondicionNivelEducativoController();
			$clsTipoCentroEstudioController = new TipoCentroEstudioController();
			$clsTipoNivelEducativoController = new TipoNivelEducativoController();
			$clsPersonaNaturalController = new PersonaNaturalController();
			$clsAuditoriaController = new AuditoriaController();
			$fecha_hora = '';
			
			//$di = (Int)($dtGuardar->getIdNivelEducativo());
			$auditorioController = new AuditoriaController();
			$auditoria = $auditorioController->fncGuardar($accion, 'nivel_educativo', 'id_nivel_educativo', $dtNivelEducativo->getIdNivelEducativo(), json_encode($dtGuardar));
			$dtAuditoria 	= $clsAuditoriaController->fncBuscarCampoAuditoria('nivel_educativo', 'id_nivel_educativo', $dtGuardar->getIdNivelEducativo());
				if (fncGeneralValidarDataArray($dtAuditoria)) {
					$Auditoria = array_shift($dtAuditoria);
					$fecha_hora = fncObtenerValorArray($Auditoria, 'fecha_hora', true);
					//$idUsuario = (Int) fncObtenerValorArray($Auditoria, 'id_usuario', true);
				}
			$model = array();
			$model['idNivelEducativo']	= $dtGuardar->getIdNivelEducativo();
			$model['idTrabajador'] 		= $dtGuardar->getIdIrabajador();
			$model['nombreCentroEstudios'] = $dtGuardar->getNombreCentroEstudios();
			$model['tituloObtenido'] 		= $dtGuardar->getTituloObtenido();
			$model['tipoCondicionNivelEducativo'] 		= array_shift($clsTipoCondicionNivelEducativoController->fncListarRegistros($dtGuardar->getIdTipoCondicionNivelEducativo()));
			$model['fecha'] 				= $dtGuardar->fecha;
			$model['archivo'] 				= $dtGuardar->archivo;
			$model['persona'] 				= array_shift( $clsPersonaNaturalController->fncListarRegistros($dtGuardar->getIdIrabajador()));
			$model['auditoriaFecha'] 		= $fecha_hora;
			$model['tipoCentroEstudio'] 					= array_shift($clsTipoCentroEstudioController->fncListarRegistros($dtGuardar->getIdTipoNivelEducativo()));
			$model['tipoNivelEducativo'] 		= array_shift($clsTipoNivelEducativoController->fncListarRegistros( $dtGuardar->getIdTipoCentroEstudio()));



		

			

			$dtNivelEducativo->getIdNivelEducativo($dtNivelEducativo->getIdNivelEducativo());
			$returnNivelEducativo ['nivel_educativo'] = $dtNivelEducativo;
			$dtGuardar = $returnNivelEducativo;
			//$dataRetorno = $this->fncListarRegistros($dtNivelEducativo->getIdNivelEducativo());
			$dtGuardar = $model;
			unset($model);
		}

		  return $dtGuardar;

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

				$dtNivelEducativo  = $this->fncListarRegistroAuditoria($id);
				$returnNivelEducativo['nvel_educatico'] = array_shift( $dtNivelEducativo );
				$bolReturn = $returnNivelEducativo;

				$auditorioController = new AuditoriaController();
				$auditoria = $auditorioController->fncGuardar(2, 'nivel_educativo', 'id_nivel_educativo', $id, json_encode($dtNivelEducativo));
			}
		}
		return $bolReturn;
	}


	//=======================================================================================
	//FUNCIONES BASE DE DATOS
	//=======================================================================================

	private function fncListarRegistrosBD($id = -1)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			ne.id_nivel_educativo,
			ne.id_trabajador,
			ne.id_tipo_nivel_educativo,
			ne.id_tipo_condicion_nivel_educativo,
			ne.id_tipo_centro_estudio,
			ne.nombre_centro_estudios,
			ne.titulo_obtenido,
			ne.condicion_actual,
			ne.fecha,
			ne.eliminado,
			ne.archivo
			
		FROM
			escalafon.nivel_educativo AS ne
		WHERE 
			(:id_nivel_educativo = -1 OR id_nivel_educativo = :id_nivel_educativo)  AND ne.eliminado = 0
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_nivel_educativo', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new NivelEducativo;
				$temp->idNivelEducativo 		= $datos['id_nivel_educativo'];
				$temp->idTrabajador 			= $datos['id_trabajador'];
				$temp->nombreCentroEstudios 	= $datos['nombre_centro_estudios'];
				$temp->tituloObtenido			= $datos['titulo_obtenido'];
				
				$temp->fecha					= $datos['fecha'];
				$temp->archivo					= $datos['archivo'];
				$temp->idTipoNivelEducativo					= $datos['id_tipo_nivel_educativo'];
				$temp->idTipoCentroEstudio					= $datos['id_tipo_centro_estudio'];
				$temp->idTipoCondicionNivelEducativo			= $datos['id_tipo_condicion_nivel_educativo'];



				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}


	private function fncListarRegistroAuditoriaBD($id)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			ne.id_nivel_educativo,
			ne.id_trabajador,
			ne.id_tipo_nivel_educativo,
			ne.id_tipo_condicion_nivel_educativo,
			ne.id_tipo_centro_estudio,
			ne.nombre_centro_estudios,
			ne.titulo_obtenido,
			ne.condicion_actual,
			ne.fecha,
			ne.eliminado,
			ne.archivo	
		FROM
			escalafon.nivel_educativo AS ne
		WHERE 
			(:id_nivel_educativo = -1 OR id_nivel_educativo = :id_nivel_educativo) 
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_nivel_educativo', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new NivelEducativo;
				$temp->idNivelEducativo 		= $datos['id_nivel_educativo'];
				$temp->idTrabajador 			= $datos['id_trabajador'];
				$temp->nombreCentroEstudios 	= $datos['nombre_centro_estudios'];
				$temp->tituloObtenido			= $datos['titulo_obtenido'];
				
				$temp->fecha					= $datos['fecha'];
				$temp->archivo					= $datos['archivo'];
				$temp->idTipoNivelEducativo					= $datos['id_tipo_nivel_educativo'];
				$temp->idTipoCentroEstudio					= $datos['id_tipo_centro_estudio'];
				$temp->idTipoCondicionNivelEducativo			= $datos['id_tipo_condicion_nivel_educativo'];


				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}

	private function fncListarRegistrosPorDniTrabajadorBD($dni)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
		pn.nombre_completo,
		ne.id_nivel_educativo,
		ne.id_trabajador,
		t.suspendido,
		ne.nombre_centro_estudios,
		ne.titulo_obtenido,
		ne.id_tipo_nivel_educativo,
		ne.id_tipo_condicion_nivel_educativo,
		ne.id_tipo_centro_estudio,
		ne.fecha,
		ne.eliminado,
		ne.archivo,
			(SELECT	a.fecha_hora FROM escalafon.auditoria  AS a WHERE ( a.id_operacion = 1 OR a.id_operacion = 2 )
				AND a.tabla = \'nivel_educativo\' AND a.objeto_id_nombre = \'id_nivel_educativo\' AND a.objeto_id_valor = ne.id_nivel_educativo
				ORDER BY a.id_auditoria DESC LIMIT 1 ),
			(SELECT
						 pn.nombre_completo  AS usuario_auditoria
					FROM adm.usuario u
					LEFT JOIN public.persona_natural pn ON pn.id_persona = u.id_persona
					WHERE u.id_usuario = (SELECT	aa.id_usuario	FROM escalafon.auditoria  AS aa WHERE ( aa.id_operacion = 1 OR aa.id_operacion = 2 )
					AND aa.tabla = \'nivel_educativo\' AND aa.objeto_id_nombre = \'id_nivel_educativo\' AND aa.objeto_id_valor = ne.id_nivel_educativo
					ORDER BY aa.id_auditoria DESC LIMIT 1))
	FROM
		escalafon.nivel_educativo AS ne
		INNER JOIN escalafon.trabajador AS t ON t.id_trabajador = ne.id_trabajador
		INNER JOIN public.persona_natural AS pn ON pn.id_persona = t.id_trabajador
		INNER JOIN public.persona AS p ON p.id_persona = pn.id_persona
	WHERE 
			(documento_identidad = :documento_identidad)  AND ne.eliminado = 0
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('documento_identidad', $dni);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new NivelEducativo;
				$temp->idNivelEducativo 		= $datos['id_nivel_educativo'];
				$temp->idTrabajador 			= $datos['id_trabajador'];
				$temp->trabajadorSuspendido		= $datos['suspendido'];
				$temp->nombreCentroEstudios 	= $datos['nombre_centro_estudios'];
				$temp->tituloObtenido			= $datos['titulo_obtenido'];
			
				$temp->fecha					= $datos['fecha'];
				$temp->archivo					= $datos['archivo'];
				$temp->eliminado				= $datos['eliminado'];
				$temp->fechaHoraAuditoria		= $datos['fecha_hora'];
				$temp->usuarioAuditoria			= $datos['usuario_auditoria'];
				$temp->idTipoNivelEducativo					= $datos['id_tipo_nivel_educativo'];
				$temp->idTipoCentroEstudio					= $datos['id_tipo_centro_estudio'];
				$temp->idTipoCondicionNivelEducativo			= $datos['id_tipo_condicion_nivel_educativo'];
			


				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}

	private function fncListarRegistrosPorIdTrabajadorBD($id = -1)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			ne.id_nivel_educativo,
			ne.id_trabajador,
			ne.id_tipo_nivel_educativo,
			ne.id_tipo_condicion_nivel_educativo,
			ne.id_tipo_centro_estudio,
			ne.nombre_centro_estudios,
			ne.titulo_obtenido,
			ne.condicion_actual,
			ne.fecha,
			ne.eliminado,
			ne.archivo			
		FROM
			escalafon.nivel_educativo AS ne
		WHERE 
			(id_trabajador = :id_trabajador)  AND ne.eliminado = 0
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_trabajador', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new NivelEducativo;
				$temp->idNivelEducativo 		= $datos['id_nivel_educativo'];
				$temp->idTrabajador 			= $datos['id_trabajador'];
				$temp->nombreCentroEstudios 	= $datos['nombre_centro_estudios'];
				$temp->tituloObtenido			= $datos['titulo_obtenido'];
				
				$temp->fecha					= $datos['fecha'];
				$temp->archivo					= $datos['archivo'];
				$temp->idTipoNivelEducativo					= $datos['id_tipo_nivel_educativo'];
				$temp->idTipoCentroEstudio					= $datos['id_tipo_centro_estudio'];
				$temp->idTipoCondicionNivelEducativo			= $datos['id_tipo_condicion_nivel_educativo'];
				


				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}

	private function fncRegistrarBD($dtNivelEducativo)
	{

		$id_trabajador			= $dtNivelEducativo->getIdIrabajador();
		$nombre_centro_estudios	= $dtNivelEducativo->getNombreCentroEstudios();
		$titulo_obtenido		= $dtNivelEducativo->getTituloObtenido();
		$InputIdTipoCondicionNivelEducativo		= $dtNivelEducativo->getIdTipoCondicionNivelEducativo();
		$fecha					= $dtNivelEducativo->getFecha();

		$InputIdTipoNivelEducativo					= $dtNivelEducativo->getIdTipoNivelEducativo();
		$InputIdTipoCentroEstudio					= $dtNivelEducativo->getIdTipoCentroEstudio();


		$sql = cls_control::get_instancia();
		$query = '
		INSERT INTO escalafon.nivel_educativo
		(
			-- id_nivel_educativo -- this column value is auto-generated
			id_trabajador,
			id_tipo_nivel_educativo,
			id_tipo_condicion_nivel_educativo,
			id_tipo_centro_estudio,
			nombre_centro_estudios,
			titulo_obtenido,			
			fecha,
			eliminado
			
			
		)
		VALUES
		(
			:id_trabajador,
			:id_tipo_nivel_educativo,
			:id_tipo_condicion_nivel_educativo,
			:id_tipo_centro_estudio,
			:nombre_centro_estudios,
			:titulo_obtenido,			
			:fecha,
			0
		)RETURNING id_nivel_educativo
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_trabajador', $id_trabajador);
			$statement->bindParam('nombre_centro_estudios', $nombre_centro_estudios);
			$statement->bindParam('titulo_obtenido', $titulo_obtenido);
			$statement->bindParam('id_tipo_condicion_nivel_educativo', $InputIdTipoCondicionNivelEducativo);
			$statement->bindParam('fecha', $fecha);

			$statement->bindParam('id_tipo_nivel_educativo', $InputIdTipoNivelEducativo);
			$statement->bindParam('id_tipo_centro_estudio', $InputIdTipoCentroEstudio);


			$sql->ejecutar();
			$datos = $statement->fetch(PDO::FETCH_ASSOC);
			if ($datos) {
				//_Retorno de Datos
				$dtNivelEducativo->setIdNivelEducativo($datos["id_nivel_educativo"]);

				//_Cerrar
				$sql->cerrar();
				return $dtNivelEducativo;
			} else {
				$sql->cerrar();
				return false;
			}
		} else {
			return false;
		}
	}




	private function fncActualizarBD($dtNivelEducativo)
	{
		$id_nivel_educativo	= $dtNivelEducativo->getIdNivelEducativo();
		$id_trabajador			= $dtNivelEducativo->getIdIrabajador();
		$nombre_centro_estudios	= $dtNivelEducativo->getNombreCentroEstudios();
		$titulo_obtenido		= $dtNivelEducativo->getTituloObtenido();
		$InputIdTipoCondicionNivelEducativo		= $dtNivelEducativo->getIdTipoCondicionNivelEducativo();
		$fecha					= $dtNivelEducativo->getFecha();

		$InputIdTipoNivelEducativo					= $dtNivelEducativo->getIdTipoNivelEducativo();
		$InputIdTipoCentroEstudio					= $dtNivelEducativo->getIdTipoCentroEstudio();

		$sql = cls_control::get_instancia();
		$query = '
		UPDATE escalafon.nivel_educativo
		SET
			-- id_nivel_educativo -- this column value is auto-generated
			id_trabajador 		= :id_trabajador,
			nombre_centro_estudios = :nombre_centro_estudios,
			titulo_obtenido 	= :titulo_obtenido,
			id_tipo_nivel_educativo = :id_tipo_nivel_educativo,
			id_tipo_condicion_nivel_educativo = :id_tipo_condicion_nivel_educativo,
			id_tipo_centro_estudio = :id_tipo_centro_estudio,
			fecha 				= :fecha
		
			
	
		WHERE id_nivel_educativo = :id_nivel_educativo 
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_nivel_educativo', $id_nivel_educativo);
			$statement->bindParam('id_trabajador', $id_trabajador);
			$statement->bindParam('nombre_centro_estudios', $nombre_centro_estudios);
			$statement->bindParam('titulo_obtenido', $titulo_obtenido);
			$statement->bindParam('id_tipo_condicion_nivel_educativo', $InputIdTipoCondicionNivelEducativo);
			$statement->bindParam('fecha', $fecha);
			$statement->bindParam('id_tipo_nivel_educativo', $InputIdTipoNivelEducativo);
			$statement->bindParam('id_tipo_centro_estudio', $InputIdTipoCentroEstudio);


			$sql->ejecutar();
			$rs = $statement->fetchAll(PDO::FETCH_OBJ);
			if ($rs) {
				$sql->cerrar();
				return $dtNivelEducativo;
			} else {
				$sql->cerrar();
				return false;
			}
		}
		return $arrayReturn;
	}

	private function fncActualizaDocumentoBD($dtNivelEducativo)
	{
		$archivo	= $dtNivelEducativo->getArchivo();
		$id_nivel_educativo	= $dtNivelEducativo->getIdNivelEducativo();


		$sql = cls_control::get_instancia();
		$query = '
		UPDATE escalafon.nivel_educativo
		SET
			archivo 				= :archivo

		WHERE id_nivel_educativo = :id_nivel_educativo 
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('archivo', $archivo);
			$statement->bindParam('id_nivel_educativo', $id_nivel_educativo);



			$sql->ejecutar();
			$rs = $statement->fetchAll(PDO::FETCH_OBJ);
			if ($rs) {
				$sql->cerrar();
				return $dtNivelEducativo;
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
		$consulta = 'UPDATE escalafon.nivel_educativo
		SET
		
			eliminado = 1
		WHERE id_nivel_educativo = :id_nivel_educativo';
		$statement = $sql->preparar($consulta);
		if ($statement != false) {
			$statement->bindParam('id_nivel_educativo', $id);
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


function fncConstruirNombreDocumentoNivelEdcuativo($archivo)
{
	$nombre = fncQuitarExtensionDocumentoNivelEducativo($archivo['name']) . '_' . uniqid() . '_';
	return $nombre;
}


function fncQuitarExtensionDocumentoNivelEducativo($string)
{
	$a = explode('.', $string);
	array_pop($a);
	return implode('.', $a);
}

function reemplazarNullPorVacioNivelEducativo($array)
{
	foreach ($array as $key => $value) 
	{
		if(is_array($value))
			$array[$key] = reemplazarNullPorVacioNivelEducativo($value);
		else
		{
			if (is_null($value))
				$array[$key] = "";
		}
	}
	return $array;
}
?>