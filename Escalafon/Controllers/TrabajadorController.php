<?php
require_once '../../App/Escalafon/Models/Trabajador.php';
require_once '../../App/Config/control.php';
require_once '../../App/Escalafon/Controllers/AuditoriaController.php';


require_once '../../App/Escalafon/Controllers/TipoRegimenPensionController.php';
require_once '../../App/Escalafon/Controllers/TipoAfpController.php';
require_once '../../App/Escalafon/Controllers/TipoTrabajadorController.php';
require_once '../../App/Escalafon/Controllers/UnidadEjecutoraController.php';
require_once '../../App/Escalafon/Controllers/TipoCondicionController.php';
require_once '../../App/Escalafon/Controllers/NivelController.php';
require_once '../../App/General/Controllers/PersonaNaturalController.php';
require_once '../../App/General/Controllers/PersonaController.php';
require_once '../../App/Escalafon/Controllers/DesplazamientoController.php';
require_once '../../App/Escalafon/Controllers/DocumentoTrabajadorController.php';
require_once '../../App/Escalafon/Controllers/TipoRegimenLaboralController.php';
require_once '../../App/Escalafon/Controllers/TipoEstadoCivilController.php';
require_once '../../App/Escalafon/Controllers/TipoCasaController.php';
require_once '../../App/Escalafon/Controllers/SituacionLaboralController.php';
require_once '../../App/Escalafon/Controllers/TipoBreveteController.php';
class TrabajadorController extends Trabajador
{
//=======================================================================================
//FUNCIONES LOGICA
//=======================================================================================
	public function fncListarRegistros($id = -1)
	{
		
		$clsTipoRegimenPension 	= new TipoRegimenPensionController();
		$clsTipoAfp 			= new TipoAfpController();
		$clsTipoTrabajador 		= new TipoTrabajadorController();
		$clsUnidadEjecutora 	= new UnidadEjecutoraController();
		$clsTipoCondicion 		= new TipoCondicionController();
		$clsNivel 				= new NivelController();
		$clsPersonaNatural 		= new PersonaNaturalController();
		$clsDesplazamientoController = new DesplazamientoController();
		$clsDocumentoTrabajador =  new DocumentoTrabajadorController();
		$clsTipoRegimenLaboral	= new TipoRegimenLaboralController();
		$clsTipoCasa			= new TipoCasaController();
		$clsTipoEstadoCivil		= new TipoEstadoCivilController();
		$clsSituacionLaboralController	= new SituacionLaboralController();


		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosBD($id);

		if (fncGeneralValidarDataArray($dtListado)) {
			$listadoIdAuditoria = array();
			foreach ($dtListado as $listado) {
				
				$model = array();

								
				//$model['id_trabajador'] 			= $listado->idTrabajador;
				$model['idTrabajador'] 			= $listado->idTrabajador;
				$model['idTipoRegimenPension'] 	= $listado->idTipoRegimenPension;
				$model['tipoRegimenPension'] 	= array_shift($clsTipoRegimenPension->fncListarRegistros($listado->idTipoRegimenPension));
				$model['idTipoAfp'] 			= $listado->idTipoAfp;
				$model['tipoAfp'] 				= array_shift( $clsTipoAfp->fncListarRegistros($listado->idTipoAfp));
				$model['idTipoRegimenLaboral'] 	= $listado->idTipoRegimenLaboral;
				$model['tipoRegimenLaboral'] 	= array_shift( $clsTipoRegimenLaboral->fncListarRegistros($listado->idTipoRegimenLaboral));
				$model['idTipoTrabajador'] 		= $listado->idTipoTrabajador;
				$model['tipoTrabajador'] 		= array_shift( $clsTipoTrabajador->fncListarRegistros($listado->idTipoTrabajador));
				$model['idUnidadEjecutora'] 	= $listado->idUnidadEjecutora;
				$model['unidadEjecutora'] 		= array_shift( $clsUnidadEjecutora->fncListarRegistros( $listado->idUnidadEjecutora));
				$model['idTipoCondicion'] 		= $listado->idTipoCondicion;
				$model['tipoCondicion'] 		= array_shift( $clsTipoCondicion->fncListarRegistros($listado->idTipoCondicion));
				$model['idNivel'] 				= $listado->idNivel;
				$model['nivel'] 				= array_shift( $clsNivel->fncListarRegistros($listado->idNivel));
				$model['libretaMilitar'] 		= $listado->libretaMilitar;
				$model['nroBrevete'] 			= $listado->nroBrevete;
				$model['idTipoBrevete'] 		= $listado->idTipoBrevete;
				$model['codigoUnico'] 			= $listado->codigoUnico;
				$model['idEstadoCivil'] 		= $listado->estadoCivil;
				$model['estadoCivil'] 			= array_shift($clsTipoEstadoCivil->fncListarRegistros($listado->estadoCivil));
				$model['idCasa'] 				= ($listado->casa) ? array_shift( $this->fncListarUbigeo($listado->casa) ) : '' ;
				$model['casa'] 					= array_shift($clsTipoCasa->fncListarRegistros($listado->casa));
				$model['idSituacionLaboral'] 	= $listado->idSituacionLaboral;
				$model['situacionLaboral'] 		= array_shift($clsSituacionLaboralController->fncListarRegistros( $listado->idSituacionLaboral));
				$model['suspendido'] 			= $listado->suspendido;
				$model['sexo'] 					= $listado->sexo;				
				$model['grupoSanguineo'] 		= $listado->grupoSanguineo;
				$model['ubigeoResidencia'] 		= array_shift( $this->fncListarUbigeo($listado->idUbigeo) ) ;
				$model['ubigeoNacimiento'] 		= array_shift( $this->fncListarUbigeo($listado->ubigeo) );
				$model['pais'] 					= $listado->pais;
				$model['persona'] 				= array_shift( $this->fncBuscarIdListadoBD($listado->idTrabajador));

				array_push($dtReturn, $model);
				array_push($listadoIdAuditoria, $model['idTrabajador']);
			}

				$gg = $model['persona'] ;

				
				$input_dni=$gg->documentoIdentidad;
			
			$dtPerson = $clsPersonaNatural->fncBuscarPorDocumento($input_dni);
			if (fncGeneralValidarDataArray($dtPerson)) {
				
				$datos['trabajador'] = array_shift( $dtReturn);
				$datos['trabajador']['persona'] = array_shift($dtPerson);
				
				
			}
			$dniTrabajador  = array('dni' => $input_dni);
			$idArray 		= $this->fncBuscarIdPorDni($dniTrabajador);
			$id 			= fncObtenerValorArray($idArray[0], "id_trabajador", true);
			$dtDesplazamiento = $clsDesplazamientoController->fncListarRegistrosActualPorIdTrabajador($id);
			if (fncGeneralValidarDataArray($dtDesplazamiento)) {
				$datos['trabajador']['desplazamiento'] =array_shift($dtDesplazamiento);
		
				
			} else {
				$datos['trabajador']['desplazamiento'] = array();
		
			}
			$dtDocumentoTrabajador = $clsDocumentoTrabajador->fncListarRegistros($id);
			if (fncGeneralValidarDataArray($dtDocumentoTrabajador)) {
				$datos['trabajador']['documentoTrabajador'] = ($dtDocumentoTrabajador);
			
			} else {
				$datos['trabajador']['documentoTrabajador'] = array();
				
			}

			$auditorioController = new AuditoriaController();	
			$auditoria = $auditorioController->fncGuardar(4, 'trabajador','id_trabajador', null, json_encode($listadoIdAuditoria) );
		}
		return reemplazarNullPorVacioTrabajador($datos);
	}


	public function fncListarRegistrosV2($id = -1)
	{
		
		$clsTipoRegimenPension 	= new TipoRegimenPensionController();
		$clsTipoAfp 			= new TipoAfpController();
		$clsTipoTrabajador 		= new TipoTrabajadorController();
		$clsUnidadEjecutora 	= new UnidadEjecutoraController();
		$clsTipoCondicion 		= new TipoCondicionController();
		$clsNivel 				= new NivelController();
		$clsPersonaNatural 		= new PersonaNaturalController();
		$clsDesplazamientoController = new DesplazamientoController();
		$clsDocumentoTrabajador =  new DocumentoTrabajadorController();
		$clsTipoRegimenLaboral	= new TipoRegimenLaboralController();
		$clsTipoCasa			= new TipoCasaController();
		$clsTipoEstadoCivil		= new TipoEstadoCivilController();
		$clsSituacionLaboralController	= new SituacionLaboralController();


		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosBD($id);

		if (fncGeneralValidarDataArray($dtListado)) {
			$listadoIdAuditoria = array();
			foreach ($dtListado as $listado) {
				
				$model = array();

								
				//$model['id_trabajador'] 			= $listado->idTrabajador;
				$model['idTrabajador'] 			= $listado->idTrabajador;
				$model['idTipoRegimenPension'] 	= $listado->idTipoRegimenPension;
				$model['tipoRegimenPension'] 	= array_shift($clsTipoRegimenPension->fncListarRegistros($listado->idTipoRegimenPension));
				$model['idTipoAfp'] 			= $listado->idTipoAfp;
				$model['tipoAfp'] 				= array_shift( $clsTipoAfp->fncListarRegistros($listado->idTipoAfp));
				$model['idTipoRegimenLaboral'] 	= $listado->idTipoRegimenLaboral;
				$model['tipoRegimenLaboral'] 	= array_shift( $clsTipoRegimenLaboral->fncListarRegistros($listado->idTipoRegimenLaboral));
				$model['idTipoTrabajador'] 		= $listado->idTipoTrabajador;
				$model['tipoTrabajador'] 		= array_shift( $clsTipoTrabajador->fncListarRegistros($listado->idTipoTrabajador));
				$model['idUnidadEjecutora'] 	= $listado->idUnidadEjecutora;
				$model['unidadEjecutora'] 		= array_shift( $clsUnidadEjecutora->fncListarRegistros( $listado->idUnidadEjecutora));
				$model['idTipoCondicion'] 		= $listado->idTipoCondicion;
				$model['tipoCondicion'] 		= array_shift( $clsTipoCondicion->fncListarRegistros($listado->idTipoCondicion));
				$model['idNivel'] 				= $listado->idNivel;
				$model['nivel'] 				= array_shift( $clsNivel->fncListarRegistros($listado->idNivel));
				$model['libretaMilitar'] 		= $listado->libretaMilitar;
				$model['nroBrevete'] 			= $listado->nroBrevete;
				$model['idTipoBrevete'] 		= $listado->idTipoBrevete;
				$model['codigoUnico'] 			= $listado->codigoUnico;
				$model['idEstadoCivil'] 		= $listado->estadoCivil;
				$model['estadoCivil'] 			= array_shift($clsTipoEstadoCivil->fncListarRegistros($listado->estadoCivil));
				$model['idCasa'] 				= ($listado->casa) ? array_shift( $this->fncListarUbigeo($listado->casa) ) : '' ;
				$model['casa'] 					= array_shift($clsTipoCasa->fncListarRegistros($listado->casa));
				$model['idSituacionLaboral'] 	= $listado->idSituacionLaboral;
				$model['situacionLaboral'] 		= array_shift($clsSituacionLaboralController->fncListarRegistros( $listado->idSituacionLaboral));
				$model['suspendido'] 			= $listado->suspendido;
				$model['sexo'] 					= $listado->sexo;				
				$model['grupoSanguineo'] 		= $listado->grupoSanguineo;
				$model['ubigeoResidencia'] 		= array_shift( $this->fncListarUbigeo($listado->idUbigeo) ) ;
				$model['ubigeoNacimiento'] 		= array_shift( $this->fncListarUbigeo($listado->ubigeo) );
				$model['pais'] 					= $listado->pais;
				$model['persona'] 				= array_shift( $this->fncBuscarIdListadoBD($listado->idTrabajador));

				array_push($dtReturn, $model);
				array_push($listadoIdAuditoria, $model['idTrabajador']);
			}


			$auditorioController = new AuditoriaController();	
			$auditoria = $auditorioController->fncGuardar(4, 'trabajador','id_trabajador', null, json_encode($listadoIdAuditoria) );
		}
		return reemplazarNullPorVacioTrabajador($dtReturn);
	}



	public function fncTrabajadorObtenerPorId($id = -1)
	{
		
		$clsTipoRegimenPension 	= new TipoRegimenPensionController();
		$clsTipoAfp 			= new TipoAfpController();
		$clsTipoTrabajador 		= new TipoTrabajadorController();
		$clsUnidadEjecutora 	= new UnidadEjecutoraController();
		$clsTipoCondicion 		= new TipoCondicionController();
		$clsNivel 				= new NivelController();
		$clsPersonaNatural 		= new PersonaNaturalController();
		$clsDesplazamientoController = new DesplazamientoController();
		$clsDocumentoTrabajador =  new DocumentoTrabajadorController();
		$clsTipoRegimenLaboral	= new TipoRegimenLaboralController();
		$clsTipoCasa			= new TipoCasaController();
		$clsTipoEstadoCivil		= new TipoEstadoCivilController();
		$clsSituacionLaboralController	= new SituacionLaboralController();
		$clsTipoBreveteController	= new TipoBreveteController();
		
		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosBD($id);

		if (fncGeneralValidarDataArray($dtListado)) {
			$listadoIdAuditoria = array();
			foreach ($dtListado as $listado) {
				
				$model = array();

								
				//$model['id_trabajador'] 			= $listado->idTrabajador;
				$model['idTrabajador'] 			= $listado->idTrabajador;
				$model['idTipoRegimenPension'] 	= $listado->idTipoRegimenPension;
				$model['tipoRegimenPension'] 	= array_shift($clsTipoRegimenPension->fncListarRegistros($listado->idTipoRegimenPension));
				$model['idTipoAfp'] 			= $listado->idTipoAfp;
				$model['tipoAfp'] 				= array_shift( $clsTipoAfp->fncListarRegistros($listado->idTipoAfp));
				$model['idTipoRegimenLaboral'] 	= $listado->idTipoRegimenLaboral;
				$model['tipoRegimenLaboral'] 	= array_shift( $clsTipoRegimenLaboral->fncListarRegistros($listado->idTipoRegimenLaboral));
				$model['idTipoTrabajador'] 		= $listado->idTipoTrabajador;
				$model['tipoTrabajador'] 		= array_shift( $clsTipoTrabajador->fncListarRegistros($listado->idTipoTrabajador));
				$model['idUnidadEjecutora'] 	= $listado->idUnidadEjecutora;
				$model['unidadEjecutora'] 		= array_shift( $clsUnidadEjecutora->fncListarRegistros( $listado->idUnidadEjecutora));
				$model['idTipoCondicion'] 		= $listado->idTipoCondicion;
				$model['tipoCondicion'] 		= array_shift( $clsTipoCondicion->fncListarRegistros($listado->idTipoCondicion));
				$model['idNivel'] 				= $listado->idNivel;
				$model['nivel'] 				= array_shift( $clsNivel->fncListarRegistros($listado->idNivel));
				$model['libretaMilitar'] 		= $listado->libretaMilitar;
				$model['nroBrevete'] 			= $listado->nroBrevete;	
				$model['idTipoBrevete'] 		= $listado->idTipoBrevete;
				$model['tipoBrevete'] 			= array_shift($clsTipoBreveteController->fncListarRegistros($listado->idTipoBrevete));
				$model['codigoUnico'] 			= $listado->codigoUnico;
				$model['idEstadoCivil'] 		= $listado->estadoCivil;
				$model['estadoCivil'] 			= array_shift($clsTipoEstadoCivil->fncListarRegistros($listado->estadoCivil));
				$model['idCasa'] 				= ($listado->casa) ? array_shift( $this->fncListarUbigeo($listado->casa) ) : '' ;
				$model['casa'] 					= array_shift($clsTipoCasa->fncListarRegistros($listado->casa));
				$model['idSituacionLaboral'] 	= $listado->idSituacionLaboral;
				$model['situacionLaboral'] 		= array_shift($clsSituacionLaboralController->fncListarRegistros( $listado->idSituacionLaboral));
				$model['suspendido'] 			= $listado->suspendido;
				//$model['sexo'] 					= $listado->sexo;				
				$model['grupoSanguineo'] 		= $listado->grupoSanguineo;
				$model['ubigeoResidencia'] 		= array_shift( $this->fncListarUbigeo($listado->idUbigeo) ) ;
				$model['ubigeoNacimiento'] 		= array_shift( $this->fncListarUbigeo($listado->ubigeo) );
				$model['pais'] 					= $listado->pais;
				$model['persona'] 				= array_shift( $this->fncBuscarIdListadoBD($listado->idTrabajador));

				
				$model['numeroContratoCas'] 	= $listado->numeroContratoCas;
				$model['inicioContrato'] 		= $listado->inicioContrato;
				$model['terminoContrato'] 		= $listado->terminoContrato;
				$model['metaPeriodo'] 			= $listado->metaPeriodo;
				$model['numeroConvocatoria'] 	= $listado->numeroConvocatoria;

				array_push($dtReturn, $model);
				array_push($listadoIdAuditoria, $model);
			}

				$gg = $model['persona'] ;

				
				$input_dni=$gg->documentoIdentidad;
			
			$dtPerson = $clsPersonaNatural->fncBuscarPorDocumento($input_dni);
			if (fncGeneralValidarDataArray($dtPerson)) {
				
				$datos = array_shift( $dtReturn);
			//	$datos['trabajador']['persona'] = array_shift($dtPerson);
				
				
			}

		//	$dniTrabajador  = array('dni' => $input_dni);
			//$idArray 		= $this->fncBuscarIdPorDni($dniTrabajador);
			//$id 			= fncObtenerValorArray($idArray[0], "id_trabajador", true);
		/*	$dtDesplazamiento = $clsDesplazamientoController->fncListarRegistrosActualPorIdTrabajador($id);
			if (fncGeneralValidarDataArray($dtDesplazamiento)) {
				$datos['trabajador']['desplazamiento'] =array_shift($dtDesplazamiento);
		
				
			} else {
				$datos['trabajador']['desplazamiento'] = array();
		
			}
			$dtDocumentoTrabajador = $clsDocumentoTrabajador->fncListarRegistros($id);
			if (fncGeneralValidarDataArray($dtDocumentoTrabajador)) {
				$datos['trabajador']['documentoTrabajador'] = ($dtDocumentoTrabajador);
			
			} else {
				$datos['trabajador']['documentoTrabajador'] = array();
				
			}
	*/
			$auditorioController = new AuditoriaController();	
			$auditoria = $auditorioController->fncGuardar(4, 'trabajador','id_trabajador', null, json_encode($listadoIdAuditoria) );
		}
		return reemplazarNullPorVacioTrabajador($datos);
	}

	public function fncListarRegistrosAuditoria($id = -1)
	{

		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosBD($id);

		if (fncGeneralValidarDataArray($dtListado)) {
			$listadoIdAuditoria = array();
			$dtReturnTrabajador = array();
			foreach ($dtListado as $listado) {

				$model = array();

				$model['id_trabajador'] 	= $listado->idTrabajador;
				$model['id_tipo_regimen_pension'] = $listado->idTipoRegimenPension;
				$model['id_tipo_afp'] 		= $listado->idTipoAfp;
				$model['id_tipo_regimen_laboral'] = $listado->idTipoRegimenLaboral;
				$model['id_tipo_trabajador'] = $listado->idTipoTrabajador;
				$model['id_unidad_ejecutora'] = $listado->idUnidadEjecutora;
				$model['id_tipo_condicion']	= $listado->idTipoCondicion;
				$model['id_nivel'] 			= $listado->idNivel;
				$model['libreta_militar'] 	= $listado->libretaMilitar;
				$model['nro_brevete'] 		= $listado->nroBrevete;
				$model['id_tipo_brevete'] 	= $listado->idTipoBrevete;
				$model['codigo_unico'] 		= $listado->codigoUnico;
				$model['estado_civil']		= $listado->estadoCivil;
				$model['casa'] 				= $listado->casa;
				$model['suspendido'] 		= $listado->suspendido;

				array_push($dtReturn, $model);

				array_push($listadoIdAuditoria, $model['id_trabajador']);
			}
			$dtReturnTrabajador['trabajador']=array_shift($dtReturn) ;
		}
		return $dtReturnTrabajador;
	}


	public function fncListarTrabajadorPorArea($arrayInputs)
	{

		$dtReturn = array();
		$inputIdArea = (Int)$arrayInputs;
		$dtListado = $this->fncListarTrabajadorPorAreaBD($inputIdArea);

		if (fncGeneralValidarDataArray($dtListado)) {
		
			$dtReturnTrabajador = array();
			foreach ($dtListado as $listado) {

				$model = array();

				$model['idTrabajador'] 	= $listado->idTrabajador;
				$model['nombreTrabajador'] 	= $listado->nombreTrabajador;
				$model['idTipoRegimenPension'] 	= $listado->idTipoRegimenPension;
				$model['idTipoRegimenLaboral'] 	= $listado->idTipoRegimenLaboral;
				$model['idTipoTrabajador'] 	= $listado->idTipoTrabajador;
				$model['idUnidadEjecutora'] 	= $listado->idUnidadEjecutora;
				$model['idTipoCondicion'] 	= $listado->idTipoCondicion;
				$model['idNivel'] 	= $listado->idNivel;
				$model['idTipoBrevete'] 	= $listado->idTipoBrevete;
				$model['idSituacionLaboral'] 	= $listado->idSituacionLaboral;
				$model['nroBrevete'] 	= $listado->nroBrevete;
				$model['libretaMilitar'] 	= $listado->libretaMilitar;
				$model['codigoUnico'] 	= $listado->codigoUnico;
				$model['estadoCivil'] 	= $listado->estadoCivil;
				$model['casa'] 	= $listado->casa;
				$model['grupoSanguineo'] 	= $listado->grupoSanguineo;
				$model['ubigeo'] 	= $listado->ubigeo;
				$model['idArea'] = $listado->idArea;
				$model['idDesplazamiento'] 		= $listado->idDesplazamiento;
				$model['nombreArea'] = $listado->nombreArea;
				$model['trabajadorSuspendido'] = $listado->trabajadorSuspendido;
		

				array_push($dtReturn, $model);

			
			}
			
		}
		return $dtReturn;
	}

	public function fncListarTrabajadorPanel($arrayInputs='')
	{
		$dtReturn = array();
		$dtMensaje = '';
		$dtRetorno = array();
		$dtDesplazamiento =array();
		$id=0;
		$clsTrabajadorController = new TrabajadorController();
		$inputDni = fncObtenerValorArray($arrayInputs, "dni", true);		
		$dtListado = $this->fncListarTrabajadorPanelBD( str_replace(' ','',$inputDni) );
		if( count($dtListado)>0 ){
			
		}
		else{
			$dtMensaje = 'No está registrado como trabajador';
			$dtRetorno[2]=true;
		}
		$clsDocumentoDesplazamiento =  new DocumentoDesplazamientoController();
		if( fncGeneralValidarDataArray($dtListado) ){

			$listaAuditoria=array();
			foreach( $dtListado as $listado ){
		
				$model = array();
				$model['idTrabajador'] 		=$listado->idTrabajador;
				$model['documentoIdentidad'] =$listado->documentoIdentidad;
				$model['nombreApellido'] 			=$listado->nombreApellido;
				$model['cargo']			=$listado->cargo;
				$model['nivel']			=$listado->nivel;
				$model['fechaInicio']			=$listado->fechaInicio;
				$model['codigoUnico']			=$listado->codigoUnico;
				$model['suspendido']			=$listado->suspendido;
			
				array_push($dtDesplazamiento, $model);

				$dtMensaje = 'Registros Listado con éxito';
			}

			$dtReturn =array_shift( $dtDesplazamiento);
			$dtMensaje = 'Trabajador encontrado satisfactoriamente';
			$dtRetorno[2]=false;
		}
		
		$dtRetorno[0]= $dtReturn;
		$dtRetorno[1]=$dtMensaje;
		return $dtRetorno;
	}


	


	public function fncListarPais($id = -1)
	{

		$dtReturn = array();
		$dtListado = $this->fncListarPaisBD($id);
		$dtReturnTrabajador = array();

		if (fncGeneralValidarDataArray($dtListado)) {
			$listadoIdAuditoria = array();
			
			foreach ($dtListado as $listado) {

				$model = array();

				$model['idPais'] 	= $listado->idPais;
				$model['nombrePais'] = $listado->idNombrePais;

				array_push($dtReturn, $model);
				
				
			}
			
		}
		return $dtReturn;
	}


	
	public function fncListarUbigeo($id)
	{

		$dtReturn = array();
		$dtListado = $this->fncListarUbigeoBD($id);
		$dtReturnTrabajador = array();

		if (fncGeneralValidarDataArray($dtListado)) {
			$listadoIdAuditoria = array();
			
			foreach ($dtListado as $listado) {

				$model = array();

				$model['ubigeo'] 	= $listado->ubigeo;
				$model['region'] = $listado->region;
				$model['provincia'] = $listado->provincia;
				$model['distrito'] = $listado->distrito;
				$model['idRegion'] = $listado->idRegion;
				$model['idProvincia'] = $listado->idProvincia;
				$model['idDistrito'] = $listado->idDistrito;


				array_push($dtReturn, $model);
				
				
			}
			
		}
		return $dtReturn;
	}

	public function fncListarRegistrosPorDni($arrayInputs)
	{
		$dtReturn = array();
		//$data = array();
		$datos = array();
		//$trabajador = array();
		//$desplazamiento = array();
		//$Documento = array();
		$clsTipoRegimenPension 	= new TipoRegimenPensionController();
		$clsTipoAfp 			= new TipoAfpController();
		$clsTipoTrabajador 		= new TipoTrabajadorController();
		$clsUnidadEjecutora 	= new UnidadEjecutoraController();
		$clsTipoCondicion 		= new TipoCondicionController();
		$clsNivel 				= new NivelController();
		$clsPersonaNatural 		= new PersonaNaturalController();
		$clsDesplazamientoController = new DesplazamientoController();
		$clsDocumentoTrabajador =  new DocumentoTrabajadorController();
		$clsTipoRegimenLaboral	= new TipoRegimenLaboralController();
		$clsTipoCasa			= new TipoCasaController();
		$clsTipoEstadoCivil		= new TipoEstadoCivilController();
		$clsSituacionLaboralController	= new SituacionLaboralController();
		$input_dni = fncObtenerValorArray($arrayInputs, "dni", true );		
		$dtListado = $this->fncListarRegistrosDniBD($input_dni);
		
		if( fncGeneralValidarDataArray($dtListado) ){
			$listadoIdAuditoria = array();
			foreach( $dtListado as $listado ){
							
				$model = array();
				
				$model['idTrabajador'] 			= $listado->idTrabajador;
				$model['idTipoRegimenPension'] 	= $listado->idTipoRegimenPension;
				$model['tipoRegimenPension'] 	= array_shift($clsTipoRegimenPension->fncListarRegistros($listado->idTipoRegimenPension));
				$model['idTipoAfp'] 			= $listado->idTipoAfp;
				$model['tipoAfp'] 				= array_shift( $clsTipoAfp->fncListarRegistros($listado->idTipoAfp));
				$model['idTipoRegimenLaboral'] 	= $listado->idTipoRegimenLaboral;
				$model['tipoRegimenLaboral'] 	= array_shift( $clsTipoRegimenLaboral->fncListarRegistros($listado->idTipoRegimenLaboral));
				$model['idTipoTrabajador'] 		= $listado->idTipoTrabajador;
				$model['tipoTrabajador'] 		= array_shift( $clsTipoTrabajador->fncListarRegistros($listado->idTipoTrabajador));
				$model['idUnidadEjecutora'] 	= $listado->idUnidadEjecutora;
				$model['unidadEjecutora'] 		= array_shift( $clsUnidadEjecutora->fncListarRegistros( $listado->idUnidadEjecutora));
				$model['idTipoCondicion'] 		= $listado->idTipoCondicion;
				$model['tipoCondicion'] 		= array_shift( $clsTipoCondicion->fncListarRegistros($listado->idTipoCondicion));
				$model['idNivel'] 				= $listado->idNivel;
				$model['nivel'] 				= array_shift( $clsNivel->fncListarRegistros($listado->idNivel));
				$model['libretaMilitar'] 		= $listado->libretaMilitar;
				$model['nroBrevete'] 			= $listado->nroBrevete;
				$model['idTipoBrevete'] 		= $listado->idTipoBrevete;
				$model['codigoUnico'] 			= $listado->codigoUnico;
				$model['idEstadoCivil'] 		= $listado->estadoCivil;
				$model['codigoPlaza'] 		= $listado->codigoPlaza;
				$model['estadoCivil'] 			= array_shift($clsTipoEstadoCivil->fncListarRegistros($listado->estadoCivil));
				$model['idCasa'] 				= ($listado->casa) ? array_shift( $this->fncListarUbigeo($listado->casa) ) : '' ;
				$model['casa'] 					= array_shift($clsTipoCasa->fncListarRegistros($listado->casa));

				$model['idSituacionLaboral'] 	= $listado->idSituacionLaboral;
				$model['situacionLaboral'] 		= array_shift($clsSituacionLaboralController->fncListarRegistros( $listado->idSituacionLaboral));
				$model['suspendido'] 			= $listado->suspendido;
				$model['sexo'] 					= $listado->sexo;
				
				$model['grupoSanguineo'] 		= $listado->grupoSanguineo;
				$model['ubigeoResidencia'] 		= array_shift( $this->fncListarUbigeo($listado->idUbigeo) ) ;
				$model['ubigeoNacimiento'] 		= array_shift( $this->fncListarUbigeo($listado->ubigeo) );
				$model['pais'] 					= $listado->pais;
				$model['persona'] 				= array_shift( $this->fncBuscarIdListadoBD($listado->idTrabajador));


				$model['numeroContratoCas'] 	= $listado->numeroContratoCas;
				$model['inicioContrato'] 		= $listado->inicioContrato;
				$model['terminoContrato'] 		= $listado->terminoContrato;
				$model['metaPeriodo'] 			= $listado->metaPeriodo;
				$model['numeroConvocatoria'] 	= $listado->numeroConvocatoria;

			

				array_push($dtReturn, $model);
				array_push($listadoIdAuditoria, $model['idTrabajador']);
			}
			$dtPerson = $clsPersonaNatural->fncBuscarPorDocumento($input_dni);
			if (fncGeneralValidarDataArray($dtPerson)) {
				
				$datos['trabajador'] = array_shift( $dtReturn);
				$datos['trabajador']['persona'] = array_shift($dtPerson);
				
				
			}
			$dniTrabajador  = array('dni' => $input_dni);
			$idArray 		= $this->fncBuscarIdPorDni($dniTrabajador);
			$id 			= fncObtenerValorArray($idArray[0], "id_trabajador", true);
			$dtDesplazamiento = $clsDesplazamientoController->fncListarRegistrosActualPorIdTrabajador($id);
			if (fncGeneralValidarDataArray($dtDesplazamiento)) {
				$datos['trabajador']['desplazamiento'] =array_shift($dtDesplazamiento);
		
				
			} else {
				$datos['trabajador']['desplazamiento'] = array();
		
			}
			$dtDocumentoTrabajador = $clsDocumentoTrabajador->fncListarRegistros($id);
			if (fncGeneralValidarDataArray($dtDocumentoTrabajador)) {
				$datos['trabajador']['documentoTrabajador'] = ($dtDocumentoTrabajador);
			
			} else {
				$datos['trabajador']['documentoTrabajador'] = array();
				
			}

			$auditorioController = new AuditoriaController();	
			$auditoria = $auditorioController->fncGuardar(4, 'trabajador','id_trabajador', null, json_encode($listadoIdAuditoria) );
		}
		return reemplazarNullPorVacioTrabajador($datos);
	}

	public function fncBuscarIdPorDni($arrayInputs)
	{
		$dtReturn = array();
		$input_dni = fncObtenerValorArray($arrayInputs, "dni", true);
		$dtListado = $this->fncListarRegistrosDniBD($input_dni);
		if (fncGeneralValidarDataArray($dtListado)) {
			foreach ($dtListado as $listado) {
				$model = array();
				$model['id_trabajador'] = $listado->idTrabajador;
				array_push($dtReturn, $model);
				unset($model);
			}
		}
		return $dtReturn;
	}

	public function fncBuscarPorNombrePersonasNoRegistradasComoTrabajador($arrayInputs)
	{
		$inputNombre = fncObtenerValorArray($arrayInputs, "nombre", true);
		$dtReturn = array();
		$dtListado = $this->fncBuscarPorNombrePersonasNoRegistradasComoTrabajadorBD($inputNombre);
		if (fncGeneralValidarDataArray($dtListado)) {
			$listadoIdAuditoria = array();
			foreach ($dtListado as $listado) {
				$model = array();
				$model['idPersona'] = $listado->idPersona;
				$model['id_tipo_documento_identidad'] = $listado->idTipoDocumentoIdentidad;
				$model['id_ubigeo'] = $listado->idUbigeo;
				$model['tipo'] = $listado->tipo;
				$model['documento_identidad'] = $listado->documentoIdentidad;
				$model['apellidos'] = $listado->apellidos;
				//$model['id_tipo_condicion'] = $listado->idTipoCondicion;
				$model['nombre_completo'] = $listado->nombreCompleto;

				array_push($dtReturn, $model);
			}
		}
		return $dtReturn;
	}

	public function fncModificarBreveteTrabajador($arrayInputs)
	{
		$dtReturn = array();
		$accion =1;

		$dtRetorno=array();

		$idTrabajador = fncObtenerValorArray( $arrayInputs, 'idTrabajador', true);
		$idTipoBrevete = fncObtenerValorArray( $arrayInputs, 'idTipoBrevete', true);
		$nroBrevete = fncObtenerValorArray( $arrayInputs, 'nroBrevete', true);
	
		$dtTrabajador = new Trabajador;	

		if( !empty($idTrabajador) ) { $dtTrabajador->setIdTrabajador($idTrabajador); }
		if( !empty($nroBrevete) ) { $dtTrabajador->setNroBrevete($nroBrevete); }
		if( !empty($idTipoBrevete) ) { $dtTrabajador->setIdTipoBrevete($idTipoBrevete); }

		$mensaje = '';
		if (fncGeneralValidarDataArray($dtTrabajador)) {
			$dtGuardar = array();
			$dtGuardar = $this->fncActualizarBreveteBD($dtTrabajador);
			if (fncGeneralValidarDataArray($dtGuardar) && $dtGuardar!=false) {
			//_Cargamos el modelo que será devuelto
				$trabajador = $this->fncListarRegistrosAuditoria($dtTrabajador->getIdTrabajador());
				array_push($dtReturn, $trabajador);
				$auditorioController = new AuditoriaController();
				$auditoria = $auditorioController->fncGuardar($accion, 'trabajador', 'id_trabajador', $dtTrabajador->getIdTrabajador(), json_encode($dtReturn));

				$dtRetorno[0]= $dtReturn;
				$dtRetorno[1]= $mensaje;
			}
		}
		
		return $dtRetorno;
	}


	public function fncValidarDatosGuardar($arrayInputs)
	{
		error_reporting(0);
		$dtReturn = array();
		$accion =1;
		
		$inputIdTrabajador = (Int) fncObtenerValorArray( $arrayInputs, 'idTrabajador', true);	
		$inputDocumentoIdentidad = fncObtenerValorArray( $arrayInputs, 'documentoIdentidad', true);
		$inputCorreoelectronico = fncObtenerValorArray( $arrayInputs, 'correoElectronico', true);
		$inputNroBrevete = fncObtenerValorArray( $arrayInputs, 'nroBrevete', true);
	
	
		$dtTrabajador = new Trabajador;
		$valido=true;
		if( empty($inputDocumentoIdentidad) ) { $valido=false; }
		if( empty($inputCorreoelectronico) ) { $valido=false; }
		if( empty($inputNroBrevete) ) { $valido=false; }

		if( $valido ){
			$modelPersona = array();
					
			$dtListado = $this->fncValidarDatosGuardarBD($inputIdTrabajador,$inputDocumentoIdentidad,$inputCorreoelectronico,$inputNroBrevete);
		
			if (fncGeneralValidarDataArray($dtListado)) {
				$listadoIdAuditoria = array();
				foreach ($dtListado as $listado) {	
					$model = array();									
					$model['campo'] 	= $listado->campo;
					$model['existe'] 	= $listado->existe;
					array_push($dtReturn, $model);
					
				}
				$dtRetorno = $validad['validar'] = $dtReturn;
			
			}
		
			
		}	

		return $dtReturn;
		
	}

	public function fncGuardar($arrayInputs,$dtGuardar=array())
	{
		error_reporting(0);
		$dtReturn = array();
		$accion =1;
		$dtGuardarArray = $dtGuardar;
		if (count($dtGuardar)>0) {
			$inputIdTrabajador = (Int) fncObtenerValorArray( $dtGuardar, 'id_persona', true);		
		}else{
			$inputIdTrabajador = (Int) fncObtenerValorArray( $arrayInputs, 'idTrabajador', true);
		}
		$inputIdTipoRegimenPension = fncObtenerValorArray( $arrayInputs, 'idTipoRegimenPension', true);
		$inputIdTipoAfp = fncObtenerValorArray( $arrayInputs, 'idTipoAfp', true);
		$inputIdTipoRegimenLaboral = fncObtenerValorArray( $arrayInputs, 'idTipoRegimenLaboral', true);
		$inputIdTipoTrabajador = fncObtenerValorArray( $arrayInputs, 'idTipoTrabajador', true);
		$inputIdUnidadEjecutora = fncObtenerValorArray( $arrayInputs, 'idUnidadEjecutora', true);
		$inputIdTipoCondicion= fncObtenerValorArray( $arrayInputs, 'idTipoCondicion', true);
		$inputIdNivel= fncObtenerValorArray( $arrayInputs, 'idNivel', true);
		$inputLibretaMilitar= fncObtenerValorArray( $arrayInputs, 'libretaMilitar', true);
		$inputNroBrevete= fncObtenerValorArray( $arrayInputs, 'nroBrevete', true);
		$inputidTipoBrevete=(Int) fncObtenerValorArray( $arrayInputs, 'idTipoBrevete', true);
		$inputEstadoCivil=(Int) fncObtenerValorArray( $arrayInputs, 'estadoCivil', true);
		$inputCasa= (Int)fncObtenerValorArray( $arrayInputs, 'casa', true);

		$inputSexo= fncObtenerValorArray( $arrayInputs, 'sexo', true);

		$inputUbigeo= fncObtenerValorArray( $arrayInputs, 'ubigeo', true);
		$inputIdSituacionLaboral= fncObtenerValorArray( $arrayInputs, 'idSituacionLaboral', true);
		$inputGrupoSanguineo= fncObtenerValorArray( $arrayInputs, 'grupoSanguineo', true);
		$inputPais= fncObtenerValorArray( $arrayInputs, 'pais', true);

		$inputTelefonoCelular= fncObtenerValorArray( $arrayInputs, 'telefonoCelular', true);
		$inputCodigoPlaza= fncObtenerValorArray( $arrayInputs, 'codigoPlaza', true);

		$inputNumeroContratoCas= fncObtenerValorArray( $arrayInputs, 'numeroContratoCas', true);
		$inputInicioContrato= fncObtenerValorArray( $arrayInputs, 'inicioContrato', true);
		$inputTerminoContrato= fncObtenerValorArray( $arrayInputs, 'terminoContrato', true);
		$inputMetaPeriodo= fncObtenerValorArray( $arrayInputs, 'metaPeriodo', true);
		$inputNumeroConvocatoria= fncObtenerValorArray( $arrayInputs, 'numeroConvocatoria', true);




	
		$dtTrabajador = new Trabajador;

		if( !empty($inputIdTrabajador) ) { $dtTrabajador->setIdTrabajador($inputIdTrabajador); }
		if( !empty($inputIdTipoRegimenPension) ) { $dtTrabajador->setIdTipoRegimenPension($inputIdTipoRegimenPension); }
		if( !empty($inputIdTipoAfp) ) { $dtTrabajador->setIdTipoAfp($inputIdTipoAfp); }
		if( !empty($inputIdTipoRegimenLaboral) ) { $dtTrabajador->setIdTipoRegimenLaboral($inputIdTipoRegimenLaboral); }
		if( !empty($inputIdTipoTrabajador) ) { $dtTrabajador->setIdTipoTrabajador($inputIdTipoTrabajador); }
		if( !empty($inputIdUnidadEjecutora) ) { $dtTrabajador->setIdUnidadEjecutora($inputIdUnidadEjecutora); }
		if( !empty($inputIdTipoCondicion) ) { $dtTrabajador->setIdTipoCondicion($inputIdTipoCondicion); }
		if( !empty($inputIdNivel) ) { $dtTrabajador->setIdNivel($inputIdNivel); }
		if( !empty($inputLibretaMilitar) ) { $dtTrabajador->setLibretaMilitar($inputLibretaMilitar); }
		if( !empty($inputNroBrevete) ) { $dtTrabajador->setNroBrevete($inputNroBrevete); }
		if( !empty($inputEstadoCivil) ) { $dtTrabajador->setEstadoCivil($inputEstadoCivil); }
		if( !empty($inputCasa) ) { $dtTrabajador->setCasa($inputCasa); }
		if( !empty($inputidTipoBrevete) ) { $dtTrabajador->setIdTipoBrevete($inputidTipoBrevete); }

		//if( !empty($inputidTipoBrevete) ) { $dtTrabajador->setIdTipoBrevete($inputidTipoBrevete); }

		if( !empty($inputUbigeo) ) { $dtTrabajador->setUbigeo($inputUbigeo); }
		if( !empty($inputIdSituacionLaboral) ) { $dtTrabajador->setIdSituacionLaboral($inputIdSituacionLaboral); }
		if( !empty($inputGrupoSanguineo) ) { $dtTrabajador->setGrupoSanguineo($inputGrupoSanguineo); }
		if( !empty($inputPais) ) { $dtTrabajador->setPais($inputPais); }
		if( !empty($inputCodigoPlaza) ) { $dtTrabajador->setCodigoPlaza($inputCodigoPlaza); }


		if( !empty($inputNumeroContratoCas) ) { $dtTrabajador->setNumeroContratoCas($inputNumeroContratoCas); }
		if( !empty($inputInicioContrato) ) { $dtTrabajador->setInicioContrato($inputInicioContrato); }
		if( !empty($inputTerminoContrato) ) { $dtTrabajador->setTerminoContrato($inputTerminoContrato); }
		if( !empty($inputMetaPeriodo) ) { $dtTrabajador->setMetaPeriodo($inputMetaPeriodo); }
		if( !empty($inputNumeroConvocatoria) ) { $dtTrabajador->setNumeroConvocatoria($inputNumeroConvocatoria); }


	
		$dtTrabajador->setCodigoUnico(fncCodigoUnico($inputIdTrabajador));
		$dtTrabajador->setSuspendido(0);

		if( $inputIdTrabajador > 0 ){
			$trabajador = $this->fncListarRegistrosBD($inputIdTrabajador);
			if (count($trabajador)==0) {
				$accion=1;
			}else{
				$accion=2;
			}
		}
		$mensaje='';
		if( fncGeneralValidarDataArray($dtTrabajador) ){
			$modelPersona = array();
			$dtGuardar = array();
			if( $accion == 1){
				$dtPersonanaBrevete = $this->fncBuscarLibretaMilitar($dtTrabajador->getNroBrevete());
				if (fncGeneralValidarDataArray($dtPersonanaBrevete)) {
					$mensaje ='Nro Brevete Ya Existe';
			  }else{
					$dtGuardar = $this->fncRegistrarBD($dtTrabajador);
					$dtSexoPersona  = $this->fncActualizarSexoPersonaBD($inputIdTrabajador,$inputSexo);
			  } 
			}else{
				$dtGuardar = $this->fncActualizarBD($dtTrabajador);
				$dtSexoPersona  = $this->fncActualizarSexoPersonaBD($inputIdTrabajador,$inputSexo);
			}

			if( fncGeneralValidarDataArray($dtGuardar) ) {
			//_Cargamos el modelo que será devuelto
			  $model = array();
			  $model["idTrabajador"]          	= $dtGuardar->getIdTrabajador();
			  $model["idTipoRegimenPension"] 	= $dtGuardar->getIdTipoRegimenPension();
			  $model["idTipoAfp"]             	= $dtGuardar->getIdTipoAfp();
			  $model["idTipoRegimenLaboral"]	= $dtGuardar->getIdTipoRegimenLaboral();
			  $model["idTipoTrabajador"]     	= $dtGuardar->getIdTipoTrabajador();
			  $model["idUnidadEjecutora"]    	= $dtGuardar->getIdUnidadEjecutora();
			  $model["idTipoCondicion"]      	= $dtGuardar->getIdTipoCondicion();
			  $model["idNivel"]           		= $dtGuardar->getIdNivel();
			  $model["libretaMilitar"]         	= $dtGuardar->getLibretaMilitar();
			  $model["nroBrevete"]           	= $dtGuardar->getNroBrevete();
			  $model["idTipoBrevete"]         	= $dtGuardar->getIdTipoBrevete();
			  $model["estadoCivil"]           	= $dtGuardar->getEstadoCivil();
			  $model["casa"]           			= $dtGuardar->getCasa();			 
			  $model["codigoUnico"]           	= $dtGuardar->getCodigoUnico();
			  

			  $model["ubigeo"]           		= $dtGuardar->getUbigeo();
			  $model["situacionLaboral"]        = $dtGuardar->getIdSituacionLaboral();
			  $model["grupoSanguineo"]          = $dtGuardar->getGrupoSanguineo();
			  $model["pais"]           			= $dtGuardar->getPais();
			  $model["codigoPlaza"]           			= $dtGuardar->getCodigoPlaza();

			  $model["numeroContratoCas"]     = $dtGuardar->getNumeroContratoCas();
			  $model["inicioContrato"]         = $dtGuardar->getInicioContrato();
			  $model["terminoContrato"]        = $dtGuardar->getTerminoContrato();
			  $model["metaPeriodo"]           	= $dtGuardar->getMetaPeriodo();
			  $model["numeroConvocatoria"]     = $dtGuardar->getNumeroConvocatoria();


			
	  

			  array_push($dtReturn, $model);
			  //unset($model);
			  $auditorioController = new AuditoriaController();	
			  $auditoria = $auditorioController->fncGuardar($accion, 'trabajador','id_trabajador', $dtGuardar->getIdTrabajador(), json_encode($dtReturn) );
			}
			$dtDniTrabajadorBuscar = $this->fncBuscarDniPersonaPorId($dtGuardar->getIdTrabajador());
			$arrayBusqueda = array(
				'dni'=> $dtDniTrabajadorBuscar
			);
			$dtReturnTrabajador = $this->fncListarRegistrosPorDni($arrayBusqueda);
			$modelPersona = $dtReturnTrabajador ;
		}

	

		$dtRetorno[0]= ( $modelPersona );
		$dtRetorno[1]= $mensaje;
		return $dtRetorno;
		
	}

	public function fncBuscarLibretaMilitar($brevete)
	{
		$dtListado = $this->fncListarRegistrosbreveteBD(str_replace(' ','',$brevete) );
		return $dtListado;
	}

	public function fncSuspenderTrabajador($id = 0)
	{
		$bolReturn = false;
		if ($id > 0) {
			$bolValidarEliminar = $this->fncSuspenderBD($id);
			if ($bolValidarEliminar) {
				$dtAuditoria = $this->fncListarRegistrosAuditoria((int) $id);
				$auditorioController = new AuditoriaController();
				$auditoria = $auditorioController->fncGuardar(2, 'trabajador', 'id_trabajador', $id, json_encode($dtAuditoria));
			}
		}
		return $dtAuditoria;
	}

//=======================================================================================
//FUNCIONES BASE DE DATOS
//=======================================================================================
	private function fncListarRegistrosBD($id = -1)
	{
		$sql = cls_control::get_instancia();
		$query = 'SELECT
				*
			FROM
				escalafon.trabajador AS t 
				INNER JOIN "public".persona_natural ON "public".persona_natural.id_persona = t.id_trabajador
				INNER JOIN "public".persona ON "public".persona.id_persona = "public".persona_natural.id_persona
		WHERE (:id_trabajador = -1 OR id_trabajador = :id_trabajador)';
		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_trabajador', $id);
			$sql->ejecutar();
			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				
				$temp = new Trabajador;
				$temp->idTrabajador = $datos['id_trabajador'];
				$temp->idTipoRegimenPension	= $datos['id_tipo_regimen_pension'];
				$temp->idTipoAfp = $datos['id_tipo_afp'];
				$temp->idTipoRegimenLaboral = $datos['id_tipo_regimen_laboral'];
				$temp->idTipoTrabajador = $datos['id_tipo_trabajador'];
				$temp->idUnidadEjecutora = $datos['id_unidad_ejecutora'];
				$temp->idTipoCondicion = $datos['id_tipo_condicion'];
				$temp->idNivel = $datos['id_nivel'];

				$temp->libretaMilitar = $datos['libreta_militar'];
				$temp->nroBrevete = $datos['nro_brevete'];
				$temp->idTipoBrevete = $datos['id_tipo_brevete'];
				$temp->codigoUnico = $datos['codigo_unico'];
				$temp->estadoCivil = $datos['estado_civil'];
				$temp->casa = $datos['casa'];
				$temp->domicilio = $datos['domicilio'];
				$temp->correo_electronico = $datos['correo_electronico'];
				$temp->foto = $datos['foto'];

				$temp->idSituacionLaboral = $datos['id_situacion_laboral'];
				$temp->grupoSanguineo = $datos['grupo_sanguineo'];
				$temp->idUbigeo = $datos['id_ubigeo'];
				$temp->ubigeo = $datos['ubigeo'];
				$temp->pais = $datos['pais'];
				$temp->sexo = $datos['sexo'];

				$temp->numeroContratoCas = $datos['numero_contrato_cas'];
				$temp->inicioContrato = $datos['inicio_contrato'];
				$temp->terminoContrato = $datos['termino_contrato'];
				$temp->metaPeriodo = $datos['meta_periodo'];
				$temp->numeroConvocatoria = $datos['numero_convocatoria'];

				array_push($arrayReturn, $temp);
				unset($temp);
			}
		}
		return $arrayReturn;
	}


	private function fncListarTrabajadorPorAreaBD($idArea)
	{
		$sql = cls_control::get_instancia();
		$query = '
		
		SELECT 
		ta.id_trabajador,
		ta.nombre_trabajador,
		ta.id_tipo_regimen_pension,
		ta.id_tipo_afp,
		ta.id_tipo_regimen_laboral,
		ta.id_tipo_trabajador,
		ta.id_unidad_ejecutora,
		ta.id_tipo_condicion,
		ta.id_nivel,
		ta.id_tipo_brevete,
		ta.id_situacion_laboral,
		ta.nro_brevete,
		ta.libreta_militar,
		ta.codigo_unico,
		ta.estado_civil,
		ta.casa,
		ta.grupo_sanguineo,
		ta.ubigeo,

		ta.nombre_trabajador,
		ta.id_area,
		ta.id_desplazamiento,
	  
		CASE 
			WHEN ta.id_area ISNULL	THEN \'sin area asignada\'
			ELSE (SELECT     	a.nombre_area	      FROM escalafon.area AS a WHERE a.id_area = ta.id_area)
		END AS nombre_area,
		ta.suspendido AS trabajador_suspendido
		FROM (
		SELECT
			t.id_trabajador,
			
			t.id_tipo_regimen_pension,
			t.id_tipo_afp,
			t.id_tipo_regimen_laboral,
			t.id_tipo_trabajador,
			t.id_unidad_ejecutora,
			t.id_tipo_condicion,
			t.id_nivel,
			t.id_tipo_brevete,
			t.id_situacion_laboral,
			t.nro_brevete,
			t.libreta_militar,
			t.codigo_unico,
			t.estado_civil,
			t.casa,
			t.grupo_sanguineo,
			t.ubigeo,
			t.suspendido,
			--pn.nombres ||\' \'|| pn.apellidos AS nombre_apellido,
			(SELECT 	pn.nombres ||\' \'||pn.apellidos
		  
			 FROM
				"public".persona_natural AS pn  WHERE pn.id_persona = t.id_trabajador ) AS nombre_trabajador ,
			(SELECT
				d.id_area
	  
			 FROM
				escalafon.desplazamiento AS d
			INNER JOIN escalafon.area AS a ON a.id_area = d.id_area WHERE d.id_trabajador = t.id_trabajador AND d.anulado = 0 AND d.eliminado =0 ORDER BY d.id_desplazamiento DESC LIMIT 1),
				(SELECT
				d.id_desplazamiento
	  
			 FROM
				escalafon.desplazamiento AS d
			INNER JOIN escalafon.area AS a ON a.id_area = d.id_area WHERE d.id_trabajador = t.id_trabajador AND d.anulado = 0 AND d.eliminado =0 ORDER BY d.id_desplazamiento DESC LIMIT 1)
		  
		FROM
			escalafon.trabajador AS t ) AS ta WHERE ta.id_area = :id_area
		
		
		';
		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_area', $idArea);
			$sql->ejecutar();
			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				
				$temp = new Trabajador;
				$temp->idTrabajador = $datos['id_trabajador'];
				$temp->nombreTrabajador = $datos['nombre_trabajador'];
				$temp->idTipoRegimenPension = $datos['id_tipo_regimen_pension'];
				$temp->idTipoRegimenLaboral = $datos['id_tipo_regimen_laboral'];
				$temp->idTipoTrabajador = $datos['id_tipo_trabajador'];
				$temp->idUnidadEjecutora = $datos['id_unidad_ejecutora'];
				$temp->idTipoCondicion = $datos['id_tipo_condicion'];
				$temp->idNivel = $datos['id_nivel'];
				$temp->idTipoBrevete = $datos['id_tipo_brevete'];
				$temp->idSituacionLaboral = $datos['id_situacion_laboral'];
				$temp->nroBrevete = $datos['nro_brevete'];
				$temp->libretaMilitar = $datos['libreta_militar'];
				$temp->codigoUnico = $datos['codigo_unico'];
				$temp->estadoCivil = $datos['estado_civil'];
				$temp->casa = $datos['casa'];
				$temp->grupoSanguineo = $datos['grupo_sanguineo'];
				$temp->ubigeo = $datos['ubigeo'];

				$temp->idArea	= $datos['id_area'];
				$temp->idDesplazamiento = $datos['id_desplazamiento'];
				$temp->nombreArea = $datos['nombre_area'];
				$temp->trabajadorSuspendido = $datos['trabajador_suspendido'];
			

				array_push($arrayReturn, $temp);
				unset($temp);
			}
		}
		return $arrayReturn;
	}

	private function fncListarPaisBD($id = -1)
	{
		$sql = cls_control::get_instancia();
		$query = 'SELECT
					p.id_pais,
					p.nombre_pais
				FROM
					"public".pais AS p
				WHERE (:id_pais = -1 OR id_pais = :id_pais)';
		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_pais', ($id) );
			$sql->ejecutar();
			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new Trabajador;
				$temp->idPais 			= $datos['id_pais'];
				$temp->idNombrePais		= $datos['nombre_pais'];
			
				array_push($arrayReturn, $temp);
				unset($temp);
			}
		}
		return $arrayReturn;
	}

	private function fncBuscarDniPersonaPorId($id = -1)
	{
		$sql = cls_control::get_instancia();
		$query = 'SELECT
			p.documento_identidad
			
			FROM
				"public".persona AS p
			WHERE p.id_persona = :id_persona';
		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_persona', ($id) );
			$sql->ejecutar();
			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new Trabajador;
				$temp->documentoIdentidad 			= $datos['documento_identidad'];
				$arrayReturn = $datos['documento_identidad'];
			
				//array_push($arrayReturn, $temp);
				unset($temp);
			}
		}
		return $arrayReturn;
	}


	
	private function fncListarUbigeoBD($ubigeo)
	{
		$sql = cls_control::get_instancia();
		$query = 'SELECT
					u.ubigeo,
					u.region,
					u.provincia,
					u.distrito,
					u.id_region,
					u.id_provincia,
					u.id_distrito
				FROM
					"public".ubigeo AS u
					WHERE u.ubigeo = :ubigeo';
		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('ubigeo', ($ubigeo) );
			$sql->ejecutar();
			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new Trabajador;
				$temp->ubigeo 			= $datos['ubigeo'];
				$temp->region 			= $datos['region'];
				$temp->provincia 		= $datos['provincia'];
				$temp->distrito 		= $datos['distrito'];
				$temp->idRegion 		= $datos['id_region'];
				$temp->idProvincia 		= $datos['id_provincia'];
				$temp->idDistrito 		= $datos['id_distrito'];
							
				array_push($arrayReturn, $temp);
				unset($temp);
			}
		}
		return $arrayReturn;
	}


	private function fncListarTrabajadorPanelBD($dni)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
		t.id_trabajador,
		p.documento_identidad,
		pn.nombres ||\' \'|| pn.apellidos AS nombre_apellido,
		COALESCE((SELECT c.nombre_cargo  FROM escalafon.desplazamiento
					 AS d INNER JOIN escalafon.cargo AS c ON c.id_cargo = d.id_cargo 
					 WHERE d.id_trabajador = t.id_trabajador AND d.actual=1 LIMIT 1 ),\'Sin Cargo Designado\')AS cargo,
		(SELECT	 n.denom	 FROM 	escalafon.nivel AS n WHERE n.id_nivel = t.id_nivel) AS nivel,
		COALESCE((SELECT d.fecha_inicio FROM escalafon.desplazamiento AS d 
				   WHERE d.id_trabajador = t.id_trabajador 
				   ORDER BY d.fecha_inicio ASC LIMIT 1 ),to_date(\'00010000\',\'YYYYMMDD\'))AS fecha_inicio,
		t.codigo_unico,
		t.suspendido
		
	FROM
		escalafon.trabajador AS t
		INNER JOIN "public".persona_natural AS pn ON pn.id_persona = t.id_trabajador
		INNER JOIN "public".persona AS p ON p.id_persona = pn.id_persona
	WHERE p.documento_identidad = :dni ';
		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('dni', ($dni) );
			$sql->ejecutar();
			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new Trabajador;
				$temp->idTrabajador 		= $datos['id_trabajador'];
				$temp->documentoIdentidad	= $datos['documento_identidad'];
				$temp->nombreApellido 		= $datos['nombre_apellido'];
				$temp->cargo 			= $datos['cargo'];
				$temp->nivel 			= $datos['nivel'];
				$temp->fechaInicio 		= $datos['fecha_inicio'];
				$temp->codigoUnico 		= $datos['codigo_unico'];
				$temp->suspendido 		= $datos['suspendido'];
							
				array_push($arrayReturn, $temp);
				unset($temp);
			}
		}
		return $arrayReturn;
	}

	private function fncListarRegistrosbreveteBD($brevete)
	{
		$sql = cls_control::get_instancia();
		$query = 'SELECT		
								t.id_tipo_brevete,
								t.nro_brevete	
							FROM
								escalafon.trabajador AS t
							WHERE (t.nro_brevete = :nro_brevete)';
		$statement = $sql->preparar($query);
		$arrayReturn = array();
		if ($statement != false) {
			$statement->bindParam('nro_brevete', $brevete);
			$sql->ejecutar();
			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new Trabajador;
				$temp->nroBrevete 		= $datos['nro_brevete'];
				$temp->idTipoBrevete 	= $datos['id_tipo_brevete'];
				array_push($arrayReturn, $temp);
				unset($temp);
			}
		}
		return $arrayReturn;
	}

	private function fncListarRegistrosDniBD($dni)
	{
		$sql = cls_control::get_instancia();
		$query = 'SELECT * FROM escalafon.trabajador
								INNER JOIN "public".persona_natural ON "public".persona_natural.id_persona = escalafon.trabajador.id_trabajador
								INNER JOIN "public".persona ON "public".persona.id_persona = "public".persona_natural.id_persona
							WHERE public.persona.documento_identidad = :dni_trabajador';
		$statement = $sql->preparar($query);
		$arrayReturn = array();
		if ($statement != false) {
			$statement->bindParam('dni_trabajador', $dni);
			$sql->ejecutar();
			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new Trabajador;
				$temp->idTrabajador = $datos['id_trabajador'];
				$temp->idTipoRegimenPension	= $datos['id_tipo_regimen_pension'];
				$temp->idTipoAfp = $datos['id_tipo_afp'];
				$temp->idTipoRegimenLaboral = $datos['id_tipo_regimen_laboral'];
				$temp->idTipoTrabajador = $datos['id_tipo_trabajador'];
				$temp->idUnidadEjecutora = $datos['id_unidad_ejecutora'];
				$temp->idTipoCondicion = $datos['id_tipo_condicion'];
				$temp->idNivel = $datos['id_nivel'];

				$temp->libretaMilitar = $datos['libreta_militar'];
				$temp->nroBrevete = $datos['nro_brevete'];
				$temp->idTipoBrevete = $datos['id_tipo_brevete'];
				$temp->codigoUnico = $datos['codigo_unico'];
				$temp->estadoCivil = $datos['estado_civil'];
				$temp->casa = $datos['casa'];
				$temp->domicilio = $datos['domicilio'];
				$temp->correo_electronico = $datos['correo_electronico'];
				$temp->foto = $datos['foto'];

				$temp->idSituacionLaboral = $datos['id_situacion_laboral'];
				$temp->grupoSanguineo = $datos['grupo_sanguineo'];
				$temp->idUbigeo = $datos['id_ubigeo'];
				$temp->ubigeo = $datos['ubigeo'];
				$temp->pais = $datos['pais'];
				$temp->sexo = $datos['sexo'];
				$temp->codigoPlaza = $datos['codigo_plaza'];



				$temp->numeroContratoCas = $datos['numero_contrato_cas'];
				$temp->inicioContrato = $datos['inicio_contrato'];
				$temp->terminoContrato = $datos['termino_contrato'];
				$temp->metaPeriodo = $datos['meta_periodo'];
				$temp->numeroConvocatoria = $datos['numero_convocatoria'];

				array_push($arrayReturn, $temp);
				unset($temp);
			}
		}
		return $arrayReturn;
	}

	private function fncBuscarPorNombrePersonasNoRegistradasComoTrabajadorBD($nombre)
	{
		$sql = cls_control::get_instancia();
		$query = "SELECT	
								p.id_persona,
								p.id_tipo_documento_identidad,
								p.id_ubigeo,
								p.tipo,
								p.documento_identidad,
								p.domicilio,
								p.telefono,
								p.correo_electronico,
								p.fecha_creacion,
								p.fecha_modificacion,
								pn.nombres,
								pn.apellidos,
								pn.nombre_completo,
								pn.fecha_nacimiento,
								pn.foto
							FROM
								public.persona_natural AS pn
								INNER JOIN public.persona AS p ON p.id_persona = pn.id_persona
								LEFT JOIN escalafon.trabajador AS t ON t.id_trabajador = pn.id_persona		
							WHERE (t.id_trabajador IS NULL) AND ((LOWER(translate(pn.nombre_completo,'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU')) LIKE '%' || :nombre || '%'))
							ORDER BY p.id_persona";
		$statement = $sql->preparar($query);
		$arrayReturn = array();
		if ($statement != false) {
			$statement->bindParam('nombre', $nombre);
			$sql->ejecutar();
			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new Trabajador;
				$temp->idPersona = $datos['id_persona'];
				$temp->idTipoDocumentoIdentidad	= $datos['id_tipo_documento_identidad'];
				$temp->idUbigeo	= $datos['id_ubigeo'];
				$temp->tipo = $datos['tipo'];
				$temp->documentoIdentidad = $datos['documento_identidad'];
				$temp->apellidos = $datos['apellidos'];
				$temp->nombreCompleto = $datos['nombre_completo'];
				array_push($arrayReturn, $temp);
				unset($temp);
			}
		}
		return $arrayReturn;
	}
	private function fncValidarDatosGuardarBD($id,$documentoIdentidad, $correoElectronico, $nroBrevete)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT \'documentoIdentidad\' AS campo,	count(p.documento_identidad) AS existe FROM	PUBLIC.persona AS p WHERE p.documento_identidad = :documento_identidad AND p.id_persona NOT IN (:id)
		UNION ALL
		SELECT \'correoElectronico\' AS campo,	count(p.correo_electronico) FROM	PUBLIC.persona AS p WHERE p.correo_electronico = :correo_electronico AND p.id_persona NOT IN (:id)
		UNION ALL
		SELECT \'nroBrevete\' AS campo,	count(t.nro_brevete) FROM escalafon.trabajador AS t WHERE t.nro_brevete = :nro_brevete AND t.id_trabajador NOT IN (:id)
		';
		$statement = $sql->preparar($query);
		$arrayReturn = array();
		if ($statement != false) {
			$statement->bindParam('id', $id);
			$statement->bindParam('documento_identidad', $documentoIdentidad);
			$statement->bindParam('correo_electronico', $correoElectronico);
			$statement->bindParam('nro_brevete', $nroBrevete);
			$sql->ejecutar();
			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new Trabajador;
				$temp->campo = $datos['campo'];
				$temp->existe	= $datos['existe'];

				array_push($arrayReturn, $temp);
				unset($temp);
			}
		}
		return $arrayReturn;
	}

	private function fncBuscarIdListadoBD($id = '')
  {
    $sql = cls_control::get_instancia();
    $where = "";
    if(trim($id)<>""){ $where="AND ( p.id_persona = :id_persona )"; }
    $query = "SELECT 
                pn.id_persona, 
				pn.sexo,
                t.alias_tipo_documento_identidad AS tipo_documento, 
                t.id_tipo_documento_identidad AS id_tipo_documento, 
                u.id_region,
                u.id_provincia,
				COALESCE( p.id_ubigeo,'')AS id_ubigeo,
                p.documento_identidad,
                pn.nombres, 
                pn.apellidos, 
                p.correo_electronico, 
                p.domicilio, 
                p.telefono, 
                pn.fecha_nacimiento, 
                p.fecha_creacion, 
				COALESCE(pn.foto,'')AS foto
              FROM public.persona p
                   INNER JOIN public.persona_natural pn ON pn.id_persona = p.id_persona
                   INNER JOIN public.tipo_documento_identidad t ON t.id_tipo_documento_identidad = p.id_tipo_documento_identidad 
                   INNER JOIN public.ubigeo u ON p.id_ubigeo=u.ubigeo
              WHERE p.tipo='N' ".$where;
    $statement = $sql->preparar($query);
    $arrayReturn = array();
    if($statement!=false) {    
      if(trim($id)<>""){ $statement->bindParam("id_persona",$id, PDO::PARAM_STR); }
      $sql->ejecutar();
      while($datos = $statement->fetch(PDO::FETCH_ASSOC)){
        $temp = new PersonaNatural;
		$temp->idPersona                = $datos["id_persona"];
		$temp->sexo                		= $datos["sexo"];
        $temp->idTipoDocumentoIdentidad = $datos["id_tipo_documento"];
        $temp->idRegion                 = $datos["id_region"];
        $temp->idProvincia              = $datos["id_provincia"];
        $temp->idUbigeo                 = $datos["id_ubigeo"];
        $temp->tipoDocumento            = $datos["tipo_documento"];
        $temp->documentoIdentidad       = $datos["documento_identidad"];
        $temp->nombres                  = $datos["nombres"]; 	
        $temp->apellidos                = $datos["apellidos"];
        $temp->correoElectronico        = $datos["correo_electronico"]; 
        $temp->domicilio                = $datos["domicilio"];
        $temp->telefono                 = $datos["telefono"]; 
        $temp->fechaNacimiento          = $datos["fecha_nacimiento"]; 
        $temp->fechaCreacion            = $datos["fecha_creacion"]; 
        $temp->foto                     = $datos["foto"];	
        array_push($arrayReturn,$temp);
        unset($temp);
      }
    }
    return $arrayReturn;
  }

	public function fncRegistrarBD($dtModel)
	{
		$id_trabajador = $dtModel->getIdTrabajador();
		$id_tipo_regimen_pension =	$dtModel->getIdTipoRegimenPension();
		$id_tipo_afp = $dtModel->getIdTipoAfp();
		$id_tipo_regimen_laboral = $dtModel->getIdTipoRegimenLaboral();
		$id_tipo_trabajador = $dtModel->getIdTipoTrabajador();
		$id_unidad_ejecutora = $dtModel->getIdUnidadEjecutora();
		$id_tipo_condicion = $dtModel->getIdTipoCondicion();
		$id_nivel = $dtModel->getIdNivel();

		$libreta_militar = $dtModel->getLibretaMilitar();
		$nro_brevete = $dtModel->getNroBrevete();
		$codigo_unico = $dtModel->getCodigoUnico();
		$estado_civil = $dtModel->getEstadoCivil();
		$casa = $dtModel->getCasa();
		$idTipoBrevete = $dtModel->getIdTipoBrevete();


		$ubigeo = $dtModel->getUbigeo();
		$idSituacionLaboral = $dtModel->getIdSituacionLaboral();
		$grupoSanguineo = $dtModel->getGrupoSanguineo();
		$pais = $dtModel->getPais();
		$codigoPlaza = $dtModel->getCodigoPlaza();


		$numeroContratoCas = $dtModel->getNumeroContratoCas();
		$inicioContrato = $dtModel->getInicioContrato();
		$terminoContrato = $dtModel->getTerminoContrato();
		$metaPeriodo = $dtModel->getMetaPeriodo();
		$numeroConvocatoria = $dtModel->getNumeroConvocatoria();


		$suspendido = 0;

		$sql = cls_control::get_instancia();
		$query = "INSERT INTO escalafon.trabajador
							(
								id_trabajador, 
								id_tipo_regimen_pension,
								id_tipo_afp,  
								id_tipo_regimen_laboral, 
								id_tipo_trabajador, 
								id_unidad_ejecutora, 
								id_tipo_condicion,
								id_nivel,
								id_tipo_brevete,
								libreta_militar,
								nro_brevete,
								codigo_unico,
								estado_civil,
								casa,
								suspendido,

								id_situacion_laboral,
								grupo_sanguineo,
								ubigeo,
								pais,
								codigo_plaza,

								numero_contrato_cas,
								inicio_contrato,
								termino_contrato,
								meta_periodo,
								numero_convocatoria
							) VALUES (
								:id_trabajador, 
								:id_tipo_regimen_pension,
								:id_tipo_afp,  
								:id_tipo_regimen_laboral, 
								:id_tipo_trabajador, 
								:id_unidad_ejecutora, 
								:id_tipo_condicion,
								:id_nivel,
								:id_tipo_brevete,
								:libreta_militar,
								:nro_brevete,
								:codigo_unico,
								:estado_civil,
								:casa,
								:suspendido,

								:id_situacion_laboral,
								:grupo_sanguineo,
								:ubigeo,
								:pais,
								:codigo_plaza,
								
								:numero_contrato_cas,
								:inicio_contrato,
								:termino_contrato,
								:meta_periodo,
								:numero_convocatoria
						) RETURNING id_trabajador";
		$statement = $sql->preparar($query);
		if ($statement != false) {
			$statement->bindParam("id_trabajador", $id_trabajador);
			$statement->bindParam("id_tipo_regimen_pension", $id_tipo_regimen_pension);
			$statement->bindParam("id_tipo_afp", $id_tipo_afp);
			$statement->bindParam("id_tipo_regimen_laboral", $id_tipo_regimen_laboral);
			$statement->bindParam("id_tipo_trabajador", $id_tipo_trabajador);
			$statement->bindParam("id_unidad_ejecutora", $id_unidad_ejecutora);
			$statement->bindParam("id_tipo_condicion", $id_tipo_condicion);
			$statement->bindParam("id_nivel", $id_nivel);
			$statement->bindParam("libreta_militar", $libreta_militar);
			$statement->bindParam("nro_brevete", $nro_brevete);
			$statement->bindParam("codigo_unico", $codigo_unico);
			$statement->bindParam("estado_civil", $estado_civil);
			$statement->bindParam("casa", $casa);
			$statement->bindParam("id_tipo_brevete", $idTipoBrevete);
			$statement->bindParam("suspendido", $suspendido);

			$statement->bindParam("id_situacion_laboral", $idSituacionLaboral);
			$statement->bindParam("grupo_sanguineo", $grupoSanguineo);
			$statement->bindParam("ubigeo", $ubigeo);
			$statement->bindParam("pais", $pais);
			$statement->bindParam("codigo_plaza", $codigoPlaza);

			$statement->bindParam("numero_contrato_cas", $numeroContratoCas);
			$statement->bindParam("inicio_contrato", $inicioContrato);
			$statement->bindParam("termino_contrato", $terminoContrato);
			$statement->bindParam("meta_periodo", $metaPeriodo);
			$statement->bindParam("numero_convocatoria", $numeroConvocatoria);

			$sql->ejecutar();
			$datos = $statement->fetch(PDO::FETCH_ASSOC);
			if ($datos) {
				//_Retorno de Datos
				$dtModel->setIdTrabajador($datos["id_trabajador"]);
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
		$id_trabajador = $dtModel->getIdTrabajador();
		$id_tipo_regimen_pension = $dtModel->getIdTipoRegimenPension();
		$id_tipo_afp = $dtModel->getIdTipoAfp();
		$id_tipo_regimen_laboral = $dtModel->getIdTipoRegimenLaboral();
		$id_tipo_trabajador = $dtModel->getIdTipoTrabajador();
		$id_unidad_ejecutora = $dtModel->getIdUnidadEjecutora();
		$id_tipo_condicion = $dtModel->getIdTipoCondicion();
		$id_nivel = $dtModel->getIdNivel();

		$libreta_militar = $dtModel->getLibretaMilitar();
		$nro_brevete = $dtModel->getNroBrevete();
		$codigo_unico = $dtModel->getCodigoUnico();
		$estado_civil = $dtModel->getEstadoCivil();
		$casa = $dtModel->getCasa();
		$idTipoBrevete = $dtModel->getIdTipoBrevete();

		$ubigeo = $dtModel->getUbigeo();
		$idSituacionLaboral = $dtModel->getIdSituacionLaboral();
		$grupoSanguineo = $dtModel->getGrupoSanguineo();
		$pais = $dtModel->getPais();
		$codigoPlaza = $dtModel->getCodigoPlaza();

		$numeroContratoCas = $dtModel->getNumeroContratoCas();
		$inicioContrato = $dtModel->getInicioContrato();
		$terminoContrato = $dtModel->getTerminoContrato();
		$metaPeriodo = $dtModel->getMetaPeriodo();
		$numeroConvocatoria = $dtModel->getNumeroConvocatoria();

		$sql = cls_control::get_instancia();
		$query = "UPDATE escalafon.trabajador
							SET
									id_tipo_regimen_pension = :id_tipo_regimen_pension,
									id_tipo_afp			=   :id_tipo_afp,
									id_tipo_regimen_laboral = :id_tipo_regimen_laboral,
									id_tipo_trabajador =  :id_tipo_trabajador,
									id_unidad_ejecutora =  :id_unidad_ejecutora,
									id_tipo_condicion = :id_tipo_condicion,
									id_nivel			= :id_nivel,
									libreta_militar = :libreta_militar,
									nro_brevete = :nro_brevete,
									estado_civil = :estado_civil,
									casa = :casa,
									id_tipo_brevete = :id_tipo_brevete,

									id_situacion_laboral = :id_situacion_laboral,
									grupo_sanguineo = :grupo_sanguineo,
									ubigeo = :ubigeo,
									pais = :pais,
									codigo_plaza = :codigo_plaza,

									numero_contrato_cas = :numero_contrato_cas,
									inicio_contrato = :inicio_contrato,
									termino_contrato = :termino_contrato,
									meta_periodo = :meta_periodo,
									numero_convocatoria = :numero_convocatoria
							WHERE id_trabajador = :id_trabajador";
		$statement = $sql->preparar($query);
		if ($statement != false) {
			$statement->bindParam("id_trabajador", $id_trabajador);
			$statement->bindParam("id_tipo_regimen_pension", $id_tipo_regimen_pension);
			$statement->bindParam("id_tipo_afp", $id_tipo_afp);
			$statement->bindParam("id_tipo_regimen_laboral", $id_tipo_regimen_laboral);
			$statement->bindParam("id_tipo_trabajador", $id_tipo_trabajador);
			$statement->bindParam("id_unidad_ejecutora", $id_unidad_ejecutora);
			$statement->bindParam("id_tipo_condicion", $id_tipo_condicion);
			$statement->bindParam("id_nivel", $id_nivel);
			$statement->bindParam("libreta_militar", $libreta_militar);
			$statement->bindParam("nro_brevete", $nro_brevete);
			$statement->bindParam("estado_civil", $estado_civil);
			$statement->bindParam("casa", $casa);
			$statement->bindParam("id_tipo_brevete", $idTipoBrevete);

			$statement->bindParam("id_situacion_laboral", $idSituacionLaboral);
			$statement->bindParam("grupo_sanguineo", $grupoSanguineo);
			$statement->bindParam("ubigeo", $ubigeo);
			$statement->bindParam("pais", $pais);
			$statement->bindParam("codigo_plaza", $codigoPlaza);

			$statement->bindParam("numero_contrato_cas", $numeroContratoCas);
			$statement->bindParam("inicio_contrato", $inicioContrato);
			$statement->bindParam("termino_contrato", $terminoContrato);
			$statement->bindParam("meta_periodo", $metaPeriodo);
			$statement->bindParam("numero_convocatoria", $numeroConvocatoria);

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

	public function fncActualizarSexoPersonaBD($idPersona,$sexo)
	{
		
	

		$sql = cls_control::get_instancia();
		$query = "UPDATE PUBLIC.persona_natural
					SET
						
						sexo = :sexo
				WHERE id_persona = :id_persona";
		$statement = $sql->preparar($query);
		if ($statement != false) {
			$statement->bindParam("id_persona", $idPersona);
			$statement->bindParam("sexo", $sexo);
	
			$sql->ejecutar();
			$rs = $statement->fetchAll(PDO::FETCH_OBJ);
			if ($rs) {
				$sql->cerrar();
				return $sexo;
			} else {
				$sql->cerrar();
				return false;
			}
		}
	}

	public function fncActualizarBreveteBD($dtModel)
	{
		$id_trabajador = $dtModel->getIdTrabajador();
		$nro_brevete = $dtModel->getNroBrevete();
		$idTipoBrevete = $dtModel->getIdTipoBrevete();

		$sql = cls_control::get_instancia();
		$query = "UPDATE escalafon.trabajador
							SET					  
									nro_brevete = :nro_brevete,					  
									id_tipo_brevete = :id_tipo_brevete
							WHERE id_trabajador = :id_trabajador ";
		$statement = $sql->preparar($query);
		if ($statement != false) {
			$statement->bindParam("id_trabajador", $id_trabajador);
			$statement->bindParam("nro_brevete", $nro_brevete);
			$statement->bindParam("id_tipo_brevete", $idTipoBrevete);
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

	private function fncSuspenderBD($id)
	{
		$bolReturn = false;
		$sql = cls_control::get_instancia();
		$query = 'UPDATE escalafon.trabajador
							SET suspendido = 1
							WHERE id_trabajador = :id_trabajador';
		$statement = $sql->preparar($query);
		if ($statement != false) {
			$statement->bindParam('id_trabajador', $id);
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
function fncCodigoUnico($idTrabajador)
{
	$anio = date("Y");
	$numeroCuerpo = 1000000;
	$codigoCuerpo = substr(strval($numeroCuerpo + $idTrabajador), -6);
	$codigoUnico = $anio . '.' . ($codigoCuerpo);
	return $codigoUnico;
}

function reemplazarNullPorVacioTrabajador($array)
{
	foreach ($array as $key => $value) 
	{
		if(is_array($value))
			$array[$key] = reemplazarNullPorVacioTrabajador($value);
		else
		{
			if (is_null($value))
				$array[$key] = "";
		}
	}
	return $array;
}
?>