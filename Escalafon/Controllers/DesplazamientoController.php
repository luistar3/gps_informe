<?php

use phpDocumentor\Reflection\Types\This;

require_once '../../App/Escalafon/Models/Desplazamiento.php';
require_once '../../App/Config/control.php';
require_once '../../App/Escalafon/Controllers/AuditoriaController.php';
require_once '../../App/Escalafon/Controllers/DocumentoController.php';
require_once '../../App/Escalafon/Controllers/DocumentoDesplazamientoController.php';
require_once '../../App/Escalafon/Controllers/TrabajadorController.php';
require_once '../../App/Escalafon/Controllers/TipoAccionController.php';
require_once '../../App/Escalafon/Controllers/TipoDocumentoController.php';
require_once '../../App/Escalafon/Controllers/AreaController.php';
require_once '../../App/Escalafon/Controllers/CargoController.php';


class DesplazamientoController extends Desplazamiento
{
	//=======================================================================================
	//FUNCIONES LOGICA
	//=======================================================================================

	public function fncListarRegistros($id = -1)
	{

		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosBD($id);

		if( fncGeneralValidarDataArray($dtListado) ){

			$accion=4;
			$listaAuditoria=array();
			foreach( $dtListado as $listado ){		
				$model = array();				
		
				$model['idDesplazamiento'] =$listado->idDesplazamiento;
				//$model['id_equipo_trabajo'] =$listado->idEquipoTrabajo ;
				$model['idTipoAccion'] 	=$listado->idTipoAccion;
				$model['tipoAccion'] 	=$listado->tipoAccion;
				$model['idTipoDocumento'] =$listado->idTipoDocumento;
				$model['tipoDocumento'] =$listado->tipoDocumento;
				$model['idCargo'] 			=$listado->idCargo;
				$model['cargo'] 			=$listado->cargo;
				$model['idArea'] 			=$listado->idArea;
				$model['area'] 			=$listado->area;
				$model['idTrabajador'] 	=$listado->idTrabajador;
				$model['numeroDocumento'] 	=$listado->numeroDocumento;
				$model['direccionOficina'] =$listado->direccionOficina;
				$model['oficina'] 			=$listado->oficina;
				$model['division'] 			=$listado->division;
				$model['denominacionCargo']=$listado->denominacionCargo;
				$model['fechaInicio'] 		=$listado->fechaInicio;
				$model['fechaTermino'] 	=$listado->fechaTermino;
				$model['fechaEfectividad'] =$listado->fechaEfectividad;
				$model['observacion'] 		=$listado->observacion;
				$model['expedienteJudicial'] =$listado->expedienteJudicial;
				$model['actual'] 			=$listado->actual;
				$model['anulado']			=$listado->anulado;
			
				array_push($dtReturn, $model);
				array_push($listaAuditoria, $model['idDesplazamiento']);
			}
			$auditorioController = new AuditoriaController();	
			$auditoria = $auditorioController->fncGuardar($accion, 'desplazamiento','id_desplazamiento', null, json_encode($listaAuditoria) );
		}
		return $dtReturn;
	}

	public function fncListarFtoFteRegistros($id = -1)
	{

		$dtReturn = array();
		$dtListado = $this->fncListarFteFtoRegistrosBD($id);

		if( fncGeneralValidarDataArray($dtListado) ){

			$accion=4;
			$listaAuditoria=array();
			foreach( $dtListado as $listado ){		
				$model = array();				
		
				$model['idFteFto'] =$listado->idFteFto;
				$model['codigo'] =$listado->codigo ;
				$model['nombre'] 	=$listado->nombre;
				
				array_push($dtReturn, $model);
			}
			
		}
		return $dtReturn;
	}
	public function fncObtenerRegistro($id)
	{

		$dtReturn = array();
		$dtTrabajador =array();
		$dtDesplazamiento = array();
		$dtListado = $this->fncObtenerRegistrosBD($id);
		$clsTipoAccionController = new TipoAccionController();
		$clsTipoDocumentoController = new TipoDocumentoController();
		$clsTrabajadorController = new TrabajadorController();
		$clsAreaController 	= new AreaController();
		$clsCargoController = new CargoController();	
		$clsDocumentoDesplazamiento =  new DocumentoDesplazamientoController();
		
		if( fncGeneralValidarDataArray($dtListado) ){

			$listaAuditoria=array();
			foreach( $dtListado as $listado ){		
				$model = array();				
		
				$model['idDesplazamiento'] =$listado->idDesplazamiento;
				$model['idTipoAccion'] 	=$listado->idTipoAccion;
				$model['tipoAccion']		=array_shift( $clsTipoAccionController->fncListarRegistros($listado->idTipoAccion));
				$model['idTipoDocumento'] =$listado->idTipoDocumento;
				$model['tipoDocumento'] 	=array_shift($clsTipoDocumentoController->fncListarRegistrosDes($listado->idTipoDocumento));
				$model['idCargo'] 			=$listado->idCargo;
				$model['cargo'] 			=array_shift($clsCargoController->fncListarRegistros($listado->idCargo));
				$model['idArea'] 			=$listado->idArea;
				$model['area'] 				=array_shift($clsAreaController->fncListarRegistrosDesplazamiento($listado->idArea));
				$model['idTrabajador'] 	=$listado->idTrabajador;
				$model['numeroDocumento'] 	=$listado->numeroDocumento;
				$model['direccionOficina'] =$listado->direccionOficina;
				$model['oficina'] 			=$listado->oficina;
				$model['division'] 			=$listado->division;
				$model['denominacionAargo']=$listado->denominacionCargo;
				$model['fechaInicio'] 		=$listado->fechaInicio;
				$model['fechaTermino'] 	=$listado->fechaTermino;
				$model['fechaEfectividad'] =$listado->fechaEfectividad;
				$model['observacion'] 		=$listado->observacion;
				$model['expedienteJudicial'] =$listado->expedienteJudicial;
				$model['actual'] 			=$listado->actual;
				$model['anulado']			=$listado->anulado;
				$model['DocumentoDesplazamiento'] = $clsDocumentoDesplazamiento ->fncListarRegistrosPorIdDesplazamiento ($listado->idDesplazamiento);

				$model['numeroResolucionInicio']	=$listado->numeroResolucionInicio;
				$model['numeroResolucionTermino']	=$listado->numeroResolucionTermino;
				$model['tipoVinculoLaboral']		=$listado->tipoVinculoLaboral;
				$model['renuncia']					=$listado->renuncia;
				$model['inicioRenovacionCas']		=$listado->inicioRenovacionCas;
				$model['terminoRenovacionCas']		=$listado->terminoRenovacionCas;
				$model['metaPeriodo']				=$listado->metaPeriodo;
				$model['numeroConvocatoria']		=$listado->numeroConvocatoria;
				$model['idFteFto']					=$listado->idFteFto;
				$model['fteFto']					=$listado->fteFto;

				
				array_push($dtReturn, $model);

			}

			$dtReturn['trabajador'] =$clsTrabajadorController->fncListarRegistrosAuditoria($listado->idTrabajador);
			$dtReturn['desplazamiento'] = $dtDesplazamiento;
		
		}
		return $dtReturn;
	}

	public function fncListarAreaDisponibles($id = -1)
	{

		$dtReturn = array();
		$dtListado = $this->fncListarAreaDisponiblesBD($id);

		if( fncGeneralValidarDataArray($dtListado) ){

			$accion=4;
			$listaAuditoria=array();
			foreach( $dtListado as $listado ){		
				$model = array();				
		
				$model['idArea'] 			=$listado->idArea;
				//$model['id_equipo_trabajo'] =$listado->idEquipoTrabajo ;
				$model['idPadre'] 			=$listado->idPadre;
				$model['idTipoArea'] 		=$listado->idTipoArea;
				$model['nombreArea'] 		=$listado->nombreArea;
				$model['sigla'] 			=$listado->sigla;
				$model['nivel'] 			=$listado->nivel;
				$model['descripcion'] 		=$listado->descripcion;
				$model['estado'] 			=$listado->estado;
				$model['fechaCreacion'] 	=$listado->fechaCreacion;
				$model['fechaModificacion']=$listado->fechaModificacion;
		
				array_push($dtReturn, $model);
				//array_push($listaAuditoria, $model['id_desplazamiento']);
			}
			//$auditorioController = new AuditoriaController();	
			//$auditoria = $auditorioController->fncGuardar($accion, 'desplazamiento','id_desplazamiento', null, json_encode($listaAuditoria) );
		}
		return $dtReturn;
	}


	public function fncBuscarRegistrosPorId($arrayInputs) //no nombramiento
	{
		$dtReturn = array();
		$dtTrabajador = array();
		$dtRetorno = array();
		$dtDesplazamiento =array();
	
		$clsTrabajadorController = new TrabajadorController();
		$clsTipoAccionController = new TipoAccionController();
		$clsTipoDocumentoController = new TipoDocumentoController();
		$clsAreaController 	= new AreaController();
		$clsCargoController = new CargoController();
		$dtMensaje = '';
		$idTrabajador = (Int)fncObtenerValorArray( $arrayInputs, 'idTrabajador', true);
		$dtIdPersona = $this->fncBuscarIdTrabajadorDB($idTrabajador);
		if( fncGeneralValidarDataArray($dtIdPersona) ){
			$id = $idTrabajador;
		}
		else{
			$dtMensaje = 'Trabajador No Registrado';
			$dtRetorno[2]=true;
		}
		
		$dtListado = $this->fncListarRegistrosPorIdTrabajadorBD($id);
		$clsDocumentoDesplazamiento =  new DocumentoDesplazamientoController();
		if( fncGeneralValidarDataArray($dtListado) ){

			$accion=4;
			$listaAuditoria=array();
			foreach( $dtListado as $listado ){		
				$model = array();				
		
				$model['idDesplazamiento'] =$listado->idDesplazamiento;
				//$model['id_equipo_trabajo'] =$listado->idEquipoTrabajo ;
				$model['idTipoAccion'] 	=$listado->idTipoAccion;
				$model['tipoAccion']		=array_shift( $clsTipoAccionController->fncListarRegistros($listado->idTipoAccion));
				$model['idTipoDocumento'] =$listado->idTipoDocumento;
				$model['tipoDocumento'] 	=array_shift($clsTipoDocumentoController->fncListarRegistrosDes($listado->idTipoDocumento));
				$model['idCargo'] 			=$listado->idCargo;
				$model['cargo'] 			=array_shift($clsCargoController->fncListarRegistros($listado->idCargo));
				$model['idArea'] 			=$listado->idArea;
				$model['area'] 				=array_shift($clsAreaController->fncListarRegistrosDesplazamiento($listado->idArea));
				$model['idTrabajador'] 	=$listado->idTrabajador;
				$model['numeroDocumento'] 	=$listado->numeroDocumento;
				$model['direccionOficina'] =$listado->direccionOficina;
				$model['oficina'] 			=$listado->oficina;
				$model['division'] 			=$listado->division;
				$model['denominacionCargo']=$listado->denominacionCargo;
				$model['fechaInicio'] 		=$listado->fechaInicio;
				$model['fechaTermino'] 	=$listado->fechaTermino;
				$model['fechaEfectividad'] =$listado->fechaEfectividad;
				$model['observacion'] 		=$listado->observacion;
				$model['expedienteJudicial'] =$listado->expedienteJudicial;
				$model['actual'] 			=$listado->actual;
				$model['anulado']			=$listado->anulado;

				$model['DocumentoDesplazamiento'] = $clsDocumentoDesplazamiento ->fncListarRegistrosPorIdDesplazamiento ($listado->idDesplazamiento);
			
				$model['numeroResolucionInicio']	=$listado->numeroResolucionInicio;
				$model['numeroResolucionTermino']	=$listado->numeroResolucionTermino;
				$model['tipoVinculoLaboral']		=$listado->tipoVinculoLaboral;
				$model['renuncia']					=$listado->renuncia;
				$model['inicioRenovacionCas']		=$listado->inicioRenovacionCas;
				$model['terminoRenovacionCas']		=$listado->terminoRenovacionCas;
				$model['metaPeriodo']				=$listado->metaPeriodo;
				$model['numeroConvocatoria']		=$listado->numeroConvocatoria;
				$model['idFteFto']					=$listado->idFteFto;
				$model['fteFto']					=$listado->fteFto;

				array_push($dtDesplazamiento, $model);
				array_push($listaAuditoria, $model['idDesplazamiento']);
				$dtMensaje = 'Registros Listado con éxito';
			}
			$auditorioController = new AuditoriaController();	
			$auditoria = $auditorioController->fncGuardar($accion, 'desplazamiento','id_desplazamiento', null, json_encode($listaAuditoria) );
			$dtReturn['trabajador'] =array_shift($clsTrabajadorController->fncListarRegistrosAuditoria($listado->idTrabajador));
			$dtReturn['desplazamiento'] =$dtDesplazamiento;
			$dtRetorno[2]=false;
		}
		else{
			if ($id>0) {
				$dtMensaje = 'No se encontraron Desplazameintos';
				$dtReturn=$clsTrabajadorController->fncListarRegistros($id);
				$dtRetorno[2]=true;
			}
		}
		$dtRetorno[0]= $dtReturn;
		$dtRetorno[1]=$dtMensaje;
		return $dtRetorno;
	}


	public function fncListarRegistrosPorDni($dni) //no nombramiento
	{
		$dtReturn = array();
		$dtTrabajador = array();
		$dtRetorno = array();
		$dtDesplazamiento =array();
		$id=0;
		$clsTrabajadorController = new TrabajadorController();
		$clsTipoAccionController = new TipoAccionController();
		$clsTipoDocumentoController = new TipoDocumentoController();
		$clsAreaController 	= new AreaController();
		$clsCargoController = new CargoController();
		$dtMensaje = '';
		$dtIdPersona = $clsTrabajadorController->fncBuscarIdPorDni( $dni);
		if( fncGeneralValidarDataArray($dtIdPersona) ){
			$id = (Int)$dtIdPersona[0]["id_trabajador"];
		}
		else{
			$dtMensaje = 'Dni no existe';
			$dtRetorno[2]=true;
		}
		
		$dtListado = $this->fncListarRegistrosPorIdTrabajadorBD($id);
		$clsDocumentoDesplazamiento =  new DocumentoDesplazamientoController();
		if( fncGeneralValidarDataArray($dtListado) ){

			$accion=4;
			$listaAuditoria=array();
			foreach( $dtListado as $listado ){		
				$model = array();				
		
				$model['id_desplazamiento'] =$listado->idDesplazamiento;
				//$model['id_equipo_trabajo'] =$listado->idEquipoTrabajo ;
				$model['id_tipo_accion'] 	=$listado->idTipoAccion;
				$model['tipo_accion']		=array_shift( $clsTipoAccionController->fncListarRegistros($listado->idTipoAccion));
				$model['id_tipo_documento'] =$listado->idTipoDocumento;
				$model['tipo_documento'] 	=array_shift($clsTipoDocumentoController->fncListarRegistros($listado->idTipoDocumento));
				$model['id_cargo'] 			=$listado->idCargo;
				$model['cargo'] 			=array_shift($clsCargoController->fncListarRegistros($listado->idCargo));
				$model['id_area'] 			=$listado->idArea;
				$model['area'] 				=array_shift($clsAreaController->fncListarRegistros($listado->idArea));
				//$model['id_trabajador'] 	=$listado->idTrabajador;
				$model['numero_documento'] 	=$listado->numeroDocumento;
				$model['direccion_oficina'] =$listado->direccionOficina;
				$model['oficina'] 			=$listado->oficina;
				$model['division'] 			=$listado->division;
				$model['denominacion_cargo']=$listado->denominacionCargo;
				$model['fecha_inicio'] 		=$listado->fechaInicio;
				$model['fecha_termino'] 	=$listado->fechaTermino;
				$model['fecha_efectividad'] =$listado->fechaEfectividad;
				$model['observacion'] 		=$listado->observacion;
				$model['expediente_judicial'] =$listado->expedienteJudicial;
				$model['actual'] 			=$listado->actual;
				$model['anulado']			=$listado->anulado;

				$model['DocumentoDesplazamiento'] = $clsDocumentoDesplazamiento ->fncListarRegistrosPorIdDesplazamiento ($listado->idDesplazamiento);
			
				$model['numeroResolucionInicio']	=$listado->numeroResolucionInicio;
				$model['numeroResolucionTermino']	=$listado->numeroResolucionTermino;
				$model['tipoVinculoLaboral']		=$listado->tipoVinculoLaboral;
				$model['renuncia']					=$listado->renuncia;
				$model['inicioRenovacionCas']		=$listado->inicioRenovacionCas;
				$model['terminoRenovacionCas']		=$listado->terminoRenovacionCas;
				$model['metaPeriodo']				=$listado->metaPeriodo;
				$model['numeroConvocatoria']		=$listado->numeroConvocatoria;
				$model['idFteFto']					=$listado->idFteFto;
				$model['fteFto']					=$listado->fteFto;
				array_push($dtDesplazamiento, $model);
				array_push($listaAuditoria, $model['id_desplazamiento']);
				$dtMensaje = 'Registros Listado con éxito';
			}
			$auditorioController = new AuditoriaController();	
			$auditoria = $auditorioController->fncGuardar($accion, 'desplazamiento','id_desplazamiento', null, json_encode($listaAuditoria) );
			$dtReturn['trabajador'] =array_shift($clsTrabajadorController->fncListarRegistrosAuditoria($listado->idTrabajador));
			$dtReturn['desplazamiento'] =$dtDesplazamiento;
			$dtRetorno[2]=false;
		}
		else{
			if ($id>0) {
				$dtMensaje = 'No se encontraron Desplazameintos';
				$dtReturn=$clsTrabajadorController->fncListarRegistros($id);
				$dtRetorno[2]=true;
			}
		}
		$dtRetorno[0]= $dtReturn;
		$dtRetorno[1]=$dtMensaje;
		return $dtRetorno;
	}

	public function fncListarRegistrosNombramientoPorDni($dni)//nombramiento
	{
		$dtReturn = array();
		$dtTrabajador = array();
		$dtRetorno = array();
		$dtDesplazamiento =array();
		$id=0;
		$clsTrabajadorController = new TrabajadorController();
		$clsTipoAccionController = new TipoAccionController();
		$clsTipoDocumentoController = new TipoDocumentoController();
		$clsAreaController 	= new AreaController();
		$clsCargoController = new CargoController();
		$dtIdPersona = $clsTrabajadorController->fncBuscarIdPorDni( $dni);
		if( fncGeneralValidarDataArray($dtIdPersona) ){
			$id = (Int)$dtIdPersona[0]["id_trabajador"];
		}
		else{
			$dtMensaje = 'Dni no existe';
			$dtRetorno[2]=true;
		}
		
		$dtListado = $this->fncListarNombramientoRegistrosPorIdTrabajadorBD($id);
		$clsDocumentoDesplazamiento =  new DocumentoDesplazamientoController();
		if( fncGeneralValidarDataArray($dtListado) ){

			$accion=4;
			$listaAuditoria=array();
			foreach( $dtListado as $listado ){
		
				$model = array();
				
		
				$model['id_desplazamiento'] =$listado->idDesplazamiento;
				//$model['id_equipo_trabajo'] =$listado->idEquipoTrabajo ;
				$model['id_tipo_accion'] 	=$listado->idTipoAccion;
				$model['tipo_accion']		=array_shift($clsTipoAccionController->fncListarRegistros($listado->idTipoAccion));
				$model['id_tipo_documento'] =$listado->idTipoDocumento;
				$model['tipo_documento'] 	=array_shift($clsTipoDocumentoController->fncListarRegistros($listado->idTipoDocumento));
				$model['idCargo'] 			=$listado->idCargo;
				$model['cargo'] 			=array_shift($clsCargoController->fncListarRegistros($listado->idCargo));
				$model['idArea'] 			=$listado->idArea;
				$model['area'] 				=array_shift($clsAreaController->fncListarRegistros($listado->idArea));
				//$model['id_trabajador'] 	=$listado->idTrabajador;
				$model['numero_documento'] 	=$listado->numeroDocumento;
				$model['direccion_oficina'] =$listado->direccionOficina;
				$model['oficina'] 			=$listado->oficina;
				$model['division'] 			=$listado->division;
				$model['denominacion_cargo']=$listado->denominacionCargo;
				$model['fecha_inicio'] 		=$listado->fechaInicio;
				$model['fecha_termino'] 	=$listado->fechaTermino;
				$model['fecha_efectividad'] =$listado->fechaEfectividad;
				$model['observacion'] 		=$listado->observacion;
				$model['expediente_judicial'] =$listado->expedienteJudicial;
				$model['actual'] 			=$listado->actual;
				$model['anulado']			=$listado->anulado;

				$model['DocumentoDesplazamiento'] = $clsDocumentoDesplazamiento ->fncListarRegistrosPorIdDesplazamiento ($listado->idDesplazamiento);
			
		
				//array_push($dtReturn, $model);
				//array_push($listaAuditoria, $model['id_desplazamiento']);				
				array_push($dtDesplazamiento, $model);
				array_push($listaAuditoria, $model['id_desplazamiento']);
				$dtMensaje = 'Registros Listado con éxito';
			}
			$auditorioController = new AuditoriaController();	
			$auditoria = $auditorioController->fncGuardar($accion, 'desplazamiento','id_desplazamiento', null, json_encode($listaAuditoria) );
			$dtReturn['trabajador'] =array_shift($clsTrabajadorController->fncListarRegistrosAuditoria($listado->idTrabajador));
			$dtReturn['desplazamiento'] =$dtDesplazamiento;
			$dtRetorno[2]=false;
		}
		else{
			if ($id>0) {
				$dtMensaje = 'No se encontraron Nombramiento';
				$dtReturn=$clsTrabajadorController->fncListarRegistros($id);
				$dtRetorno[2]=true;
			}
		}
		$dtRetorno[0]= $dtReturn;
		$dtRetorno[1]=$dtMensaje;
		return $dtRetorno;
	}

	public function fncListarRegistrosNombramientoPoridTrabajador($arrayInputs)//nombramiento
	{
		$dtReturn = array();
		$dtTrabajador = array();
		$dtRetorno = array();
		$dtDesplazamiento =array();
		$id=0;
		$idTrabajador = (Int)fncObtenerValorArray( $arrayInputs, 'idTrabajador', true);
		$clsTrabajadorController = new TrabajadorController();
		$clsTipoAccionController = new TipoAccionController();
		$clsTipoDocumentoController = new TipoDocumentoController();
		$clsAreaController 	= new AreaController();
		$clsCargoController = new CargoController();
		$dtIdPersona = $this->fncBuscarIdTrabajadorDB( $idTrabajador);
		if( fncGeneralValidarDataArray($dtIdPersona) ){
			$id = $idTrabajador;
		}
		else{
			$dtMensaje = 'Trabajador no Registrado';
			$dtRetorno[2]=true;
		}
		
		$dtListado = $this->fncListarNombramientoRegistrosPorIdTrabajadorBD($id);
		$clsDocumentoDesplazamiento =  new DocumentoDesplazamientoController();
		if( fncGeneralValidarDataArray($dtListado) ){

			$accion=4;
			$listaAuditoria=array();
			foreach( $dtListado as $listado ){
		
				$model = array();
				
		
				$model['idDesplazamiento'] =$listado->idDesplazamiento;
				//$model['id_equipo_trabajo'] =$listado->idEquipoTrabajo ;
				$model['idTipoAccion'] 	=$listado->idTipoAccion;
				$model['tipoAccion']		=array_shift($clsTipoAccionController->fncListarRegistros($listado->idTipoAccion));
				$model['idTipoDocumento'] =$listado->idTipoDocumento;
				$model['tipoDocumento'] 	=array_shift($clsTipoDocumentoController->fncListarRegistrosDes($listado->idTipoDocumento));
				$model['idCargo'] 			=$listado->idCargo;
				$model['cargo'] 			=array_shift($clsCargoController->fncListarRegistros($listado->idCargo));
				$model['idArea'] 			=$listado->idArea;
				$model['area'] 				=array_shift($clsAreaController->fncListarRegistrosDesplazamiento($listado->idArea));
				//$model['id_trabajador'] 	=$listado->idTrabajador;
				$model['numeroDocumento'] 	=$listado->numeroDocumento;
				$model['direccion_oficina'] =$listado->direccionOficina;
				$model['oficina'] 			=$listado->oficina;
				$model['division'] 			=$listado->division;
				$model['denominacion_cargo']=$listado->denominacionCargo;
				$model['fechaInicio'] 		=$listado->fechaInicio;
				$model['fechaTermino'] 	=$listado->fechaTermino;
				$model['fechaEfectividad'] =$listado->fechaEfectividad;
				$model['observacion'] 		=$listado->observacion;
				$model['expedienteJudicial'] =$listado->expedienteJudicial;
				$model['actual'] 			=$listado->actual;
				$model['anulado']			=$listado->anulado;

				$model['DocumentoDesplazamiento'] = $clsDocumentoDesplazamiento ->fncListarRegistrosPorIdDesplazamiento ($listado->idDesplazamiento);
			
		
				//array_push($dtReturn, $model);
				//array_push($listaAuditoria, $model['id_desplazamiento']);				
				array_push($dtDesplazamiento, $model);
				array_push($listaAuditoria, $model['idDesplazamiento']);
				$dtMensaje = 'Registros Listado con éxito';
			}
			$auditorioController = new AuditoriaController();	
			$auditoria = $auditorioController->fncGuardar($accion, 'desplazamiento','id_desplazamiento', null, json_encode($listaAuditoria) );
			$dtReturn['trabajador'] =array_shift($clsTrabajadorController->fncListarRegistrosAuditoria($listado->idTrabajador));
			$dtReturn['desplazamiento'] =$dtDesplazamiento;
			$dtRetorno[2]=false;
		}
		else{
			if ($id>0) {
				$dtMensaje = 'No se encontraron Nombramiento';
				$dtReturn=$clsTrabajadorController->fncListarRegistros($id);
				$dtRetorno[2]=true;
			}
		}
		$dtRetorno[0]= $dtReturn;
		$dtRetorno[1]=$dtMensaje;
		return $dtRetorno;
	}

	public function fncListarRegistrosPorNombrePersona($arrayInputs) // nombramiento y no nombramientos
	{
		$dtReturn = array();
	
		$nombre = fncObtenerValorArray( $arrayInputs, 'nombre', true);
		$dtTrabajador = $this->fncBuscarDniPorNombreBD($nombre);

		if (fncGeneralValidarDataArray($dtTrabajador)) {
			//$inputs = array_shift($dtTrabajador);
			//$dtReturn = $this->fncListarRegistrosPorDni($inputs);			

			foreach( $dtTrabajador as $listado ){
				$model = array();
				$model['dni'] 	=$listado->dni;
				$model['nombreCompleto']		=$listado->nombreCompleto;
				$model['idTrabajador']			=$listado->idTrabajador;
				array_push($dtReturn, $model);

			}

		}
		
		return $dtReturn;
	}

	public function fncListarCargos($id = -1) // nombramiento y no nombramientos
	{
		$dtReturn = array();
	

		$dtTrabajador = $this->fncListarCargosBD($id);

		if (fncGeneralValidarDataArray($dtTrabajador)) {
			//$inputs = array_shift($dtTrabajador);
			//$dtReturn = $this->fncListarRegistrosPorDni($inputs);			

			foreach( $dtTrabajador as $listado ){
				$model = array();
				$model['idCargo'] 	=$listado->idCargo;
				$model['nombreCargo']		=$listado->nombreCargo;
				$model['salarioMinimo']			=$listado->salarioMinimo;
				$model['salarioMaximo']			=$listado->salarioMaximo;
				array_push($dtReturn, $model);

			}

		}
		
		return $dtReturn;
	}

	



	public function fncListarRegistrosPorIdTrabajador($id)
	{
		$dtReturn = array();

		$clsTipoAccionController = new TipoAccionController();
		$clsTipoDocumentoController = new TipoDocumentoController();
		$clsAreaController 	= new AreaController();
		$clsCargoController = new CargoController();	
		
		$dtListado = $this->fncListarRegistrosPorIdTrabajadorBD($id);
		$clsDocumentoDesplazamiento =  new DocumentoDesplazamientoController();
		if( fncGeneralValidarDataArray($dtListado) ){

			$accion=4;
			$listaAuditoria=array();
			foreach( $dtListado as $listado ){
		
				$model = array();
				
		
				$model['idDesplazamiento'] =$listado->idDesplazamiento;
				//$model['id_equipo_trabajo'] =$listado->idEquipoTrabajo ;
				$model['idTipoAccion'] 	=$listado->idTipoAccion;
				$model['tipoAccion']		=array_shift($clsTipoAccionController->fncListarRegistros($listado->idTipoAccion));
				$model['idTipoDocumento'] =$listado->idTipoDocumento;
				$model['tipoDocumento'] 	=array_shift($clsTipoDocumentoController->fncListarRegistros($listado->idTipoDocumento));
				$model['idCargo'] 			=$listado->idCargo;
				$model['cargo'] 			=array_shift($clsCargoController->fncListarRegistros($listado->idCargo));
				$model['idArea'] 			=$listado->idArea;
				$model['area'] 				=array_shift($clsAreaController->fncListarRegistros($listado->idArea));
				$model['idTrabajador'] 	=$listado->idTrabajador;
				$model['numeroDocumento'] 	=$listado->numeroDocumento;
				$model['direccionOficina'] =$listado->direccionOficina;
				$model['oficina'] 			=$listado->oficina;
				$model['division'] 			=$listado->division;
				$model['denominacionCargo']=$listado->denominacionCargo;
				$model['fechaInicio'] 		=$listado->fechaInicio;
				$model['fechaTermino'] 	=$listado->fechaTermino;
				$model['fechaEfectividad'] =$listado->fechaEfectividad;
				$model['observacion'] 		=$listado->observacion;
				$model['expedienteJudicial'] =$listado->expedienteJudicial;
				$model['actual'] 			=$listado->actual;
				$model['anulado']			=$listado->anulado;

				$model['DocumentoDesplazamiento'] = $clsDocumentoDesplazamiento ->fncListarRegistrosPorIdDesplazamiento ($listado->idDesplazamiento);
			
				$model['numeroResolucionInicio']	=$listado->numeroResolucionInicio;
				$model['numeroResolucionTermino']	=$listado->numeroResolucionTermino;
				$model['tipoVinculoLaboral']		=$listado->tipoVinculoLaboral;
				$model['renuncia']					=$listado->renuncia;
				$model['inicioRenovacionCas']		=$listado->inicioRenovacionCas;
				$model['terminoRenovacionCas']		=$listado->terminoRenovacionCas;
				$model['metaPeriodo']				=$listado->metaPeriodo;
				$model['numeroConvocatoria']		=$listado->numeroConvocatoria;
				$model['idFteFto']					=$listado->idFteFto;
				$model['fteFto']					=$listado->fteFto;
		
				array_push($dtReturn, $model);
				array_push($listaAuditoria, $model['idDesplazamiento']);
			}
			$auditorioController = new AuditoriaController();	
			$auditoria = $auditorioController->fncGuardar($accion, 'desplazamiento','id_desplazamiento', null, json_encode($listaAuditoria) );
		}
		return $dtReturn;
	}


	public function fncListarRegistrosActualPorIdTrabajador($id)
	{
		$dtReturn = array();
		//$id=0;
		
		$clsTipoAccionController = new TipoAccionController();
		$clsTipoDocumentoController = new TipoDocumentoController();
		$clsAreaController 	= new AreaController();
		$clsCargoController = new CargoController();
	
		
	
		$dtListado = $this->fncListarRegistrosActualPorIdTrabajadorBD($id);
		$clsDocumentoDesplazamiento =  new DocumentoDesplazamientoController();
		if( fncGeneralValidarDataArray($dtListado) ){

			$accion=4;
			$listaAuditoria=array();
			foreach( $dtListado as $listado ){
		
				$model = array();
				
		
				$model['idDesplazamiento'] =$listado->idDesplazamiento;
				//$model['id_equipo_trabajo'] =$listado->idEquipoTrabajo ;
				$model['idTipoAccion'] 	=$listado->idTipoAccion;
				$model['tipoAccion']		=array_shift($clsTipoAccionController->fncListarRegistros($listado->idTipoAccion));
				$model['idTipoDocumento'] =$listado->idTipoDocumento;
				$model['tipoDocumento'] 	=array_shift($clsTipoDocumentoController->fncListarRegistros($listado->idTipoDocumento));
				$model['idCargo'] 			=$listado->idCargo;
				$model['cargo'] 			=array_shift($clsCargoController->fncListarRegistros($listado->idCargo));
				$model['idArea'] 			=$listado->idArea;
				$model['area'] 				=array_shift($clsAreaController->fncListarRegistros($listado->idArea));
				$model['idTrabajador'] 	=$listado->idTrabajador;
				$model['numeroDocumento'] 	=$listado->numeroDocumento;
				$model['direccionOficina'] =$listado->direccionOficina;
				$model['oficina'] 			=$listado->oficina;
				$model['division'] 			=$listado->division;
				$model['denominacion_cargo']=$listado->denominacionCargo;
				$model['fechaInicio'] 		=$listado->fechaInicio;
				$model['fechaTermino'] 	=$listado->fechaTermino;
				$model['fechaEfectividad'] =$listado->fechaEfectividad;
				$model['observacion'] 		=$listado->observacion;
				$model['expedienteJudicial'] =$listado->expedienteJudicial;
				$model['actual'] 			=$listado->actual;
				$model['anulado']			=$listado->anulado;

				$model['DocumentoDesplazamiento'] = $clsDocumentoDesplazamiento ->fncListarRegistrosPorIdDesplazamiento ($listado->idDesplazamiento);
			
		
				array_push($dtReturn, $model);
				array_push($listaAuditoria, $model['idDesplazamiento']);
			}
			$auditorioController = new AuditoriaController();	
			$auditoria = $auditorioController->fncGuardar($accion, 'desplazamiento','id_desplazamiento', null, json_encode($listaAuditoria) );
		}
		return $dtReturn;
	}





	public function fncGuardar($arrayInputs, $archivoInput = ""){

		$dtReturn = array();
		$dtValidarNombramiento= array();		
		$dtDesplazamientoDocumento = array();
		$accion ="";	
		$dtMensaje="";	
		$idDesplazamiento = (Int)fncObtenerValorArray( $arrayInputs, 'idDesplazamiento', true);
		//$idEquipo_trabajo = (Int)fncObtenerValorArray( $arrayInputs, 'idEquipo_trabajo', true);
		$idTipoAccion = (Int)fncObtenerValorArray( $arrayInputs, 'idTipoAccion', true);
		$idTipoDocumento = (Int)fncObtenerValorArray( $arrayInputs, 'idTipoDocumento', true);
		$idCargo = (Int)fncObtenerValorArray( $arrayInputs, 'idCargo', true);
		$idArea = (Int)fncObtenerValorArray( $arrayInputs, 'idArea', true);
		$idTrabajador= (Int)fncObtenerValorArray( $arrayInputs, 'idTrabajador', true);
			
		$numeroDocumento= fncObtenerValorArray( $arrayInputs, 'numeroDocumento', true);
		$direccionOficina= fncObtenerValorArray( $arrayInputs, 'direccionOficina', true);
		$oficina= fncObtenerValorArray( $arrayInputs, 'oficina', true);
		$division= fncObtenerValorArray( $arrayInputs, 'division', true);
		$denominacionCargo= fncObtenerValorArray( $arrayInputs, 'denominacionCargo', true);
		$fechaInicio= fncObtenerValorArray( $arrayInputs, 'fechaInicio', true);		
		$fechaTermino= fncObtenerValorArray( $arrayInputs, 'fechaTermino', true);
		$fechaEfectividad= fncObtenerValorArray( $arrayInputs, 'fechaEfectividad', true);
		$observacion= fncObtenerValorArray( $arrayInputs, 'observacion', true);
		$expedienteJudicial= fncObtenerValorArray( $arrayInputs, 'expedienteJudicial', true);


		$numeroResolucionInicio= fncObtenerValorArray( $arrayInputs, 'numeroResolucionInicio', true);
		$numeroResolucionTermino= fncObtenerValorArray( $arrayInputs, 'numeroResolucionTermino', true);
		$tipoVinculoLaboral= fncObtenerValorArray( $arrayInputs, 'tipoVinculoLaboral', true);	
		$inicioRenovacionCas= fncObtenerValorArray( $arrayInputs, 'inicioRenovacionCas', true);
		$terminoRenovacionCas= fncObtenerValorArray( $arrayInputs, 'terminoRenovacionCas', true);
		$metaPeriodo= fncObtenerValorArray( $arrayInputs, 'metaPeriodo', true);
		$numeroConvocatoria= fncObtenerValorArray( $arrayInputs, 'numeroConvocatoria', true);
		$idFteFto=(Int) fncObtenerValorArray( $arrayInputs, 'idFteFto', true);
	

		$idTipoDocumentoDesplazamiento= (Int)fncObtenerValorArray( $arrayInputs, 'idTipoDocumentoDesplazamiento', true);	
		
		$dtDesplazamiento = new Desplazamiento;
		
		if ($idTipoAccion!=9) {
			$idTipoDocumentoDesplazamiento = 1;
		}


		if( !empty($idDesplazamiento) )  { $dtDesplazamiento->setIdDesplazamiento($idDesplazamiento); }
		//if( !empty($idEquipo_trabajo) ) 		{ $dtDesplazamiento->setIdEquipoTrabajo($idEquipo_trabajo); }
		if( !empty($idTipoAccion) ) 			{ $dtDesplazamiento->setIdTipoAccion($idTipoAccion); }
		if( !empty($idTipoDocumento) ) 	{ $dtDesplazamiento->setIdTipoDocumento($idTipoDocumento); }
		if( !empty($idCargo) ) 	{ $dtDesplazamiento->setIdCargo($idCargo); }
		if( !empty($idArea) ) { $dtDesplazamiento->setIdArea($idArea); }
		if( !empty($idTrabajador) ) { $dtDesplazamiento->setIdTrabajador($idTrabajador); }
		if( !empty($numeroDocumento) ) { $dtDesplazamiento->setNumeroDocumento($numeroDocumento); }
		if( !empty($direccionOficina) ) 		{ $dtDesplazamiento->setDireccionOficina($direccionOficina); }
		if( !empty($oficina) ) 			{ $dtDesplazamiento->setOficina($oficina); }
		if( !empty($division) ) 	{ $dtDesplazamiento->setDivision($division); }
		if( !empty($denominacionCargo) ) 		{ $dtDesplazamiento->setDenominacionCargo($denominacionCargo); }
		if( !empty($fechaInicio) ) 	{ $dtDesplazamiento->setFechaInicio($fechaInicio); }
		if( !empty($fechaTermino) ) 	{ $dtDesplazamiento->setFechaTermino($fechaTermino); }
		if( !empty($fechaEfectividad) ) 	{ $dtDesplazamiento->setFechaEfectividad($fechaEfectividad); }
		if( !empty($observacion) ) { $dtDesplazamiento->setObservacion($observacion); }
		if( !empty($expedienteJudicial) ) 		{ $dtDesplazamiento->setExpedienteJudicial($expedienteJudicial); }

		if( !empty($numeroResolucionInicio) ) 		{ $dtDesplazamiento->setNumeroResolucionInicio ($numeroResolucionInicio); }
		if( !empty($numeroResolucionTermino) ) 		{ $dtDesplazamiento->setNumeroResolucionTermino ($numeroResolucionTermino); }
		if( !empty($tipoVinculoLaboral) ) 		{ $dtDesplazamiento->setTipoVinculoLaboral($tipoVinculoLaboral); }
		if( !empty($inicioRenovacionCas) ) 		{ $dtDesplazamiento->setInicioRenovacionCas($inicioRenovacionCas); }
		if( !empty($terminoRenovacionCas) ) 		{ $dtDesplazamiento->setTerminoRenovacionCas($terminoRenovacionCas); }
		if( !empty($metaPeriodo) ) 		{ $dtDesplazamiento->setMetaPeriodo($metaPeriodo); }
		if( !empty($numeroConvocatoria) ) 		{ $dtDesplazamiento->setNumeroConvocatoria($numeroConvocatoria); }
		if( !empty($idFteFto) ) 		{ $dtDesplazamiento->setIdFteFto($idFteFto); }

		
		
		$dtDesplazamiento->setActual(1);
		$dtDesplazamiento->setAnulado(0);
		
		$dtGuardar=array();
		$dtReturnDocumento = array();
		$objDesplazamientoDocumento = array();
		
		$dtValidarNombramiento = $this->fncBuscarValidarNombramiento($idTrabajador);
		if ($idTipoAccion == 9) {
			if (count($dtValidarNombramiento)>0) {	
				$dtMensaje = "Ya existe un nombramiento para el trabajador";
			}else {//nombramiento permitido
				if (fncGeneralValidarDataArray($dtDesplazamiento)) {

					$dtGuardar = array();
					if ($idDesplazamiento == 0) {
						if (!empty($idTrabajador)) {
							$lstDesplazamiento = $this->fncValidarDesplazamientoCrearNombramiento($idTrabajador, $idCargo, $idArea);		
							if (count($lstDesplazamiento) == 0) {
								$accion = 1;
								//$this->fncDesactivarActualDesplazamiento($idTrabajador);// !!!
								$dtGuardar = $this->fncRegistrarBD($dtDesplazamiento);		
								/*if (fncGeneralValidarDataArray($dtGuardar)) {
									$dtDocumentoController = new DocumentoController();
									$dtReturnDocumento = $dtDocumentoController->fncGuardarDocumento($dtGuardar, $archivoInput);		
									if (fncGeneralValidarDataArray($dtReturnDocumento)) {
										$dtDocumentoDesplazamiento = new DocumentoDesplazamientoController();		
										foreach ($dtReturnDocumento as $archivo) {
											$objArrayInputs = array(
												"id_desplazamiento" => $dtGuardar->getIdDesplazamiento(),
												"id_documento" => $archivo["IdDocumento"],
												"id_tipo_documento_desplazamiento" => $idTipoDocumentoDesplazamiento
											);
											$dtDocumentoDesplazamientoReturn = $dtDocumentoDesplazamiento->fncGuardarDocumentoDesplazamiento($objArrayInputs);
											array_push($objDesplazamientoDocumento, $dtDocumentoDesplazamientoReturn);
										}
									}
								}*/
							} else {
								$dtMensaje = "El Trabajador ya se encuentra en el Area y Cargo";
							}
						}
					}
				}
			}			
		}else{
			$dtGuardar = array();
			if ($idDesplazamiento == 0) {
				if (!empty($idTrabajador)) {
					$lstDesplazamiento = $this->fncValidarDesplazamientoCrear($idTrabajador, $idCargo, $idArea);		
					if (count($lstDesplazamiento) == 0) {
						$accion = 1;
						$this->fncDesactivarActualDesplazamiento($idTrabajador);
						$dtGuardar = $this->fncRegistrarBD($dtDesplazamiento);		
						if (fncGeneralValidarDataArray($dtGuardar)) {
							$dtDocumentoController = new DocumentoController();
							//$dtReturnDocumento = $dtDocumentoController->fncGuardarDocumento($dtGuardar, $archivoInput);		
							/*if (fncGeneralValidarDataArray($dtReturnDocumento)) {
								$dtDocumentoDesplazamiento = new DocumentoDesplazamientoController();		
								foreach ($dtReturnDocumento as $archivo) {
									$objArrayInputs = array(
										"idDesplazamiento" => $dtGuardar->getIdDesplazamiento(),
										"idDocumento" => $archivo["IdDocumento"],
										"idTipoDocumentoDesplazamiento" => $idTipoDocumentoDesplazamiento
									);
									$dtDocumentoDesplazamientoReturn = $dtDocumentoDesplazamiento->fncGuardarDocumentoDesplazamiento($objArrayInputs);
									array_push($objDesplazamientoDocumento, $dtDocumentoDesplazamientoReturn);
								}
							}*/
						}
					} else {
						$dtMensaje = "El Trabajador ya se encuentra en el Area y Cargo";
					}
				}
			} 
		}
		

	
		


		if (fncGeneralValidarDataArray($dtGuardar)) {

			$auditorioController = new AuditoriaController();
			
			$dtAuditoria = array(
				"desplazamiento" => $dtGuardar,
				"documento_desplazamiento" => $dtReturnDocumento
			);

			$dtDesplazamientoDocumento = array_shift($this->fncObtenerRegistro($dtGuardar->getIdDesplazamiento()));

			$auditoria = $auditorioController->fncGuardar($accion, 'desplazamiento', 'id_familiar', $dtGuardar->getIdDesplazamiento(), json_encode($dtAuditoria));
			$dtReturn = $dtAuditoria;
		}
			$dtRetorno = array();
			array_push($dtRetorno, $dtDesplazamientoDocumento);
			array_push($dtRetorno, $dtMensaje);
		
		  return $dtRetorno;
	}


	public function fncModificar($arrayInputs){

		$dtReturn = array();		
		$accion ="";		
		$idDesplazamiento = (Int)fncObtenerValorArray( $arrayInputs, 'idDesplazamiento', true);
		//$idEquipo_trabajo = (Int)fncObtenerValorArray( $arrayInputs, 'idEquipo_trabajo', true);
		//$idTipo_accion = (Int)fncObtenerValorArray( $arrayInputs, 'idTipo_accion', true);
		$idTipo_documento = (Int)fncObtenerValorArray( $arrayInputs, 'idTipoDocumento', true);
		$idCargo = (Int)fncObtenerValorArray( $arrayInputs, 'idCargo', true);
		$idArea = (Int)fncObtenerValorArray( $arrayInputs, 'idArea', true);
		$idTrabajador= (Int)fncObtenerValorArray( $arrayInputs, 'idTrabajador', true);
		$numeroDocumento= fncObtenerValorArray( $arrayInputs, 'numeroDocumento', true);
		$direccionOficina= fncObtenerValorArray( $arrayInputs, 'direccionOficina', true);
		$oficina= fncObtenerValorArray( $arrayInputs, 'oficina', true);
		$division= fncObtenerValorArray( $arrayInputs, 'division', true);
		$denominacionCargo= fncObtenerValorArray( $arrayInputs, 'denominacionCargo', true);
		$fechaInicio= fncObtenerValorArray( $arrayInputs, 'fechaInicio', true);		
		$fechaTermino= fncObtenerValorArray( $arrayInputs, 'fechaTermino', true);
		$fechaEfectividad= fncObtenerValorArray( $arrayInputs, 'fechaEfectividad', true);
		$observacion= fncObtenerValorArray( $arrayInputs, 'observacion', true);
		$expedienteJudicial= fncObtenerValorArray( $arrayInputs, 'expedienteJudicial', true);
	
		$numeroResolucionInicio= fncObtenerValorArray( $arrayInputs, 'numeroResolucionInicio', true);
		$numeroResolucionTermino= fncObtenerValorArray( $arrayInputs, 'numeroResolucionTermino', true);
		$tipoVinculoLaboral= fncObtenerValorArray( $arrayInputs, 'tipoVinculoLaboral', true);	
		$inicioRenovacionCas= fncObtenerValorArray( $arrayInputs, 'inicioRenovacionCas', true);
		$terminoRenovacionCas= fncObtenerValorArray( $arrayInputs, 'terminoRenovacionCas', true);
		$metaPeriodo= fncObtenerValorArray( $arrayInputs, 'metaPeriodo', true);
		$numeroConvocatoria= fncObtenerValorArray( $arrayInputs, 'numeroConvocatoria', true);
		$idFteFto=(Int) fncObtenerValorArray( $arrayInputs, 'idFteFto', true);
		
		

		$dtDesplazamiento = new Desplazamiento;

		if( !empty($idDesplazamiento) )  { $dtDesplazamiento->setIdDesplazamiento($idDesplazamiento); }
		//if( !empty($idEquipo_trabajo) ) 		{ $dtDesplazamiento->setIdEquipoTrabajo($idEquipo_trabajo); }
		//if( !empty($idTipo_accion) ) 			{ $dtDesplazamiento->setIdTipoAccion($idTipo_accion); }
		if( !empty($idTipo_documento) ) 	{ $dtDesplazamiento->setIdTipoDocumento($idTipo_documento); }
		if( !empty($idCargo) ) 	{ $dtDesplazamiento->setIdCargo($idCargo); }
		if( !empty($idArea) ) { $dtDesplazamiento->setIdArea($idArea); }
		if( !empty($idTrabajador) ) { $dtDesplazamiento->setIdTrabajador($idTrabajador); }
		if( !empty($numeroDocumento) ) { $dtDesplazamiento->setNumeroDocumento($numeroDocumento); }
		if( !empty($direccionOficina) ) 		{ $dtDesplazamiento->setDireccionOficina($direccionOficina); }
		if( !empty($oficina) ) 			{ $dtDesplazamiento->setOficina($oficina); }
		if( !empty($division) ) 	{ $dtDesplazamiento->setDivision($division); }
		if( !empty($denominacionCargo) ) 		{ $dtDesplazamiento->setDenominacionCargo($denominacionCargo); }
		if( !empty($fechaInicio) ) 	{ $dtDesplazamiento->setFechaInicio($fechaInicio); }
		if( !empty($fechaTermino) ) 	{ $dtDesplazamiento->setFechaTermino($fechaTermino); }
		if( !empty($fechaEfectividad) ) 	{ $dtDesplazamiento->setFechaEfectividad($fechaEfectividad); }
		if( !empty($observacion) ) { $dtDesplazamiento->setObservacion($observacion); }
		if( !empty($expedienteJudicial) ) 		{ $dtDesplazamiento->setExpedienteJudicial($expedienteJudicial); }
		

		if( !empty($numeroResolucionInicio) ) 		{ $dtDesplazamiento->setNumeroResolucionInicio ($numeroResolucionInicio); }
		if( !empty($numeroResolucionTermino) ) 		{ $dtDesplazamiento->setNumeroResolucionTermino ($numeroResolucionTermino); }
		if( !empty($tipoVinculoLaboral) ) 		{ $dtDesplazamiento->setTipoVinculoLaboral($tipoVinculoLaboral); }
		if( !empty($inicioRenovacionCas) ) 		{ $dtDesplazamiento->setInicioRenovacionCas($inicioRenovacionCas); }
		if( !empty($terminoRenovacionCas) ) 		{ $dtDesplazamiento->setTerminoRenovacionCas($terminoRenovacionCas); }
		if( !empty($metaPeriodo) ) 		{ $dtDesplazamiento->setMetaPeriodo($metaPeriodo); }
		if( !empty($numeroConvocatoria) ) 		{ $dtDesplazamiento->setNumeroConvocatoria($numeroConvocatoria); }
		if( !empty($idFteFto) ) 		{ $dtDesplazamiento->setIdFteFto($idFteFto); }

		$dtDesplazamiento->setActual(1);
		$dtDesplazamiento->setAnulado(0);
		
		$dtGuardar=array();
		$desplazamiento = array();

		if (fncGeneralValidarDataArray($dtDesplazamiento)) {



			if ($idDesplazamiento != 0) {
				if (!empty($idTrabajador)) {
					$lstDesplazamiento = $this->fncValidarDesplazamientoModificar($idDesplazamiento, $idDesplazamiento, $idCargo, $idArea);

					if (count($lstDesplazamiento) == 0) {
						$accion = 2;
						$desplazamiento = $this->fncActualizarBD($dtDesplazamiento);
						if (fncGeneralValidarDataArray($desplazamiento) && $desplazamiento != false) {
							$dtGuardar = $desplazamiento;
							$auditorioController = new AuditoriaController();
							$dtAuditoria = array(
								"desplazamiento" => $dtGuardar//,
								//"documento"=>$dtReturnDocumento,
								//"documento_desplazamiento" =>$objDesplazamientoDocumento,
							);

							$auditoria = $auditorioController->fncGuardar($accion, 'desplazamiento', 'id_desplazamiento', $dtGuardar->getIdDesplazamiento(), json_encode($dtAuditoria));
							$dtReturn = array_shift($this->fncObtenerRegistro($dtGuardar->getIdDesplazamiento()));
						}
						/*	if (fncGeneralValidarDataArray($dtGuardar)) {
							$dtDocumentoController= new DocumentoController();
							$dtReturnDocumento = $dtDocumentoController->fncGuardarDocumento($dtGuardar,$archivoInput);

							if (fncGeneralValidarDataArray($dtReturnDocumento)) {
								$dtDocumentoDesplazamiento = new DocumentoDesplazamientoController();
								foreach ($dtReturnDocumento as $archivo) {
									$objArrayInputs = array(
										"id_desplazamiento" =>$dtGuardar->getIdDesplazamiento(),
										"id_documento"=> $archivo["IdDocumento"]
									);
									$dtDocumentoDesplazamientoReturn = $dtDocumentoDesplazamiento -> fncGuardarDocumentoDesplazamiento($objArrayInputs);
									array_push($objDesplazamientoDocumento,$dtDocumentoDesplazamientoReturn);
								}
							}
						}*/
					}
				}
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

				$trabajadorFamiliar  = new Desplazamiento();
				$returnDesplazamiento['desplazamiento'] = array_shift($this->fncListarRegistrosAuditoria($id));
				$bolReturn =$returnDesplazamiento;
				$auditorioController = new AuditoriaController();
				$auditoria = $auditorioController->fncGuardar(2, 'desplazamiento', 'id_desplazamiento', $id, json_encode($bolReturn));
			}
		}
		return $bolReturn;
	}

	public function fncDesactivarActual($id = 0)
	{

		$bolReturn = array();
		if ($id > 0) {
			$bolValidarEliminar = $this->fncEliminarBD($id);
			if ($bolValidarEliminar) {

				$trabajadorFamiliar  = new Desplazamiento();

				$bolReturn = $this->fncListarRegistrosAuditoria($id);
				$auditorioController = new AuditoriaController();
				$auditoria = $auditorioController->fncGuardar(2, 'desplazamiento', 'id_desplazamiento', $id, json_encode($bolReturn));
			}
		}
		return $bolReturn;
	}

	public function fncAnularDesplazamiento($id = 0)
	{

		$bolReturn = array();
		if ($id > 0) {
			$bolValidarEliminar = $this->fncAnularDesplazamientoBD($id);
			if ($bolValidarEliminar) {

				$trabajadorFamiliar  = new Desplazamiento();

				$returnDesplazamiento['desplazamiento'] = array_shift($this->fncListarRegistrosAuditoria($id));
				$bolReturn =$returnDesplazamiento;
				$auditorioController = new AuditoriaController();
				$auditoria = $auditorioController->fncGuardar(2, 'desplazamiento', 'id_desplazamiento', $id, json_encode($bolReturn));
			}
		}
		return $bolReturn;
	}


	public function fncDesactivarActualDesplazamiento($id = 0)
	{

		$bolReturn = array();
		if ($id > 0) {
			$bolValidarEliminar = $this->fncDesactivarActualBD($id);
			if ($bolValidarEliminar) {

				$trabajadorFamiliar  = new Desplazamiento();

				$bolReturn = $this->fncListarRegistrosAuditoria($id);
				$auditorioController = new AuditoriaController();
				$auditoria = $auditorioController->fncGuardar(2, 'desplazamiento', 'id_desplazamiento', $id, json_encode($bolReturn));
			}
		}
		return $bolReturn;
	}

	//=======================================================================================
	//FUNCIONES BASE DE DATOS
	//=======================================================================================
	private function fncValidarDesplazamientoCrear($idTrabajador = -1, $idCargo = -1, $idArea = -1)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			d.id_desplazamiento,
			
			d.id_tipo_accion,
			d.id_tipo_documento,
			d.id_cargo,
			d.id_area,
			d.id_trabajador,
			d.numero_documento,
			d.direccion_oficina,
			d.oficina,
			d.division,
			d.denominacion_cargo,
			d.fecha_inicio,
			d.fecha_termino,
			d.fecha_efectividad,
			d.observacion,
			d.expediente_judicial,
			d.actual,
			d.anulado
		
		FROM
			escalafon.desplazamiento AS d
			
		WHERE (d.actual=1 AND d.eliminado = 0 AND d.anulado = 0) AND
			   (d.id_trabajador = :id_trabajador  AND d.id_cargo= :id_cargo  AND d.id_area = :id_area )
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_trabajador', $idTrabajador);
			$statement->bindParam('id_cargo', $idCargo);
			$statement->bindParam('id_area', $idArea);


			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new Desplazamiento;
				$temp->idDesplazamiento 	        = $datos['id_desplazamiento'];

				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}

	private function fncValidarDesplazamientoCrearNombramiento($idTrabajador = -1, $idCargo = -1, $idArea = -1)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			d.id_desplazamiento,
			
			d.id_tipo_accion,
			d.id_tipo_documento,
			d.id_cargo,
			d.id_area,
			d.id_trabajador,
			d.numero_documento,
			d.direccion_oficina,
			d.oficina,
			d.division,
			d.denominacion_cargo,
			d.fecha_inicio,
			d.fecha_termino,
			d.fecha_efectividad,
			d.observacion,
			d.expediente_judicial,
			d.actual,
			d.anulado
		
		FROM
			escalafon.desplazamiento AS d
			
		WHERE (d.eliminado = 0 AND d.anulado = 0) AND
			   (d.id_trabajador = :id_trabajador  AND d.id_tipo_accion = 9 )
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_trabajador', $idTrabajador);
		


			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new Desplazamiento;
				$temp->idDesplazamiento 	        = $datos['id_desplazamiento'];

				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}

	private function fncValidarDesplazamientoModificar($idDesplazamiento = 1, $idTrabajador = -1, $idCargo = -1, $idArea = -1)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			d.id_desplazamiento,
			
			d.id_tipo_accion,
			d.id_tipo_documento,
			d.id_cargo,
			d.id_area,
			d.id_trabajador,
			d.numero_documento,
			d.direccion_oficina,
			d.oficina,
			d.division,
			d.denominacion_cargo,
			d.fecha_inicio,
			d.fecha_termino,
			d.fecha_efectividad,
			d.observacion,
			d.expediente_judicial,
			d.actual,
			d.anulado
		
		FROM
			escalafon.desplazamiento AS d
			
		WHERE (d.actual=1 AND d.eliminado = 0 AND d.anulado = 0) AND
			(d.id_trabajador = :id_trabajador  AND d.id_cargo= :id_cargo  AND d.id_area = :id_area ) AND d.id_desplazamiento NOT IN( :id_desplazamiento )
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_desplazamiento', $idDesplazamiento);
			$statement->bindParam('id_trabajador', $idTrabajador);
			$statement->bindParam('id_cargo', $idCargo);
			$statement->bindParam('id_area', $idArea);


			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new Desplazamiento;
				$temp->idDesplazamiento 	        = $datos['id_desplazamiento'];

				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}

	
	private function fncBuscarIdTrabajadorDB($id)
	{
		$sql = cls_control::get_instancia();
		$idTrabajador = $id;
		$query = '
		SELECT
			t.id_trabajador

		FROM
			escalafon.trabajador AS t
		WHERE t.id_trabajador = :id_trabajador
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_trabajador',$idTrabajador);
	
			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new Desplazamiento;
				$temp->idTrabajador 	        = $datos['id_trabajador'];

				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}


	private function fncRegistrarBD($dtDesplazamiento)
	{

		//$idEquipo_trabajo	= $dtDesplazamiento->getIdEquipoTrabajo();
		$idTipo_accion		= $dtDesplazamiento->getIdTipoAccion();
		$idTipo_documento	= $dtDesplazamiento->getIdTipoDocumento();
		$idCargo			= $dtDesplazamiento->getIdCargo();
		$idArea				= $dtDesplazamiento->getIdArea();
		$idTrabajador		= $dtDesplazamiento->getIdTrabajador();
		//$idTipoDocumentoDesplazamiento		=$dtDesplazamiento->getTipoDocumentoDesplazamiento();

		$numeroDocumento	= $dtDesplazamiento->getNumeroDocumento();
		$direccionOficina	= $dtDesplazamiento->getDireccionOficina();
		$oficina			= $dtDesplazamiento->getOficina();
		$division			= $dtDesplazamiento->getDivision();
		$denominacionCargo	= $dtDesplazamiento->getDenominacionCargo();
		$fechaInicio		= $dtDesplazamiento->getFechaInicio();
		$fechaTermino		= $dtDesplazamiento->getFechaTermino();
		$fechaEfectividad	= $dtDesplazamiento->getFechaEfectividad();
		$observacion		= $dtDesplazamiento->getObservacion();
		$expedienteJudicial	= $dtDesplazamiento->getExpedienteJudicial();
		$actual 			= $dtDesplazamiento->getActual();
		$anulado 			= $dtDesplazamiento->getAnulado();
		



		$numeroResolucionInicio =$dtDesplazamiento->getNumeroResolucionInicio();
		$numeroResolucionTermino=$dtDesplazamiento->getNumeroResolucionTermino();
		$tipoVinculoLaboral		=$dtDesplazamiento->getTipoVinculoLaboral();
		$inicioRenovacionCas	=$dtDesplazamiento->getInicioRenovacionCas();
		$terminoRenovacionCas	=$dtDesplazamiento->getTerminoRenovacionCas();
		$metaPeriodo			=$dtDesplazamiento->getMetaPeriodo();
		$numeroConvocatoria		=$dtDesplazamiento->getNumeroConvocatoria();
		$idFteFto				=$dtDesplazamiento->getIdFteFto();


		$sql = cls_control::get_instancia();
		$query = '
		INSERT INTO escalafon.desplazamiento
		(
			-- id_desplazamiento -- this column value is auto-generated
			
			id_tipo_accion,
			id_tipo_documento,
			id_cargo,
			id_area,
			id_trabajador,
			numero_documento,
			direccion_oficina,
			oficina,
			division,
			denominacion_cargo,
			fecha_inicio,
			fecha_termino,
			fecha_efectividad,
			observacion,
			expediente_judicial,
			actual,
			anulado,
			numero_resolucion_inicio,
			numero_resolucion_termino,
			tipo_vinculo_laboral,			
			inicio_renovacion_cas,
			termino_renovacion_cas,
			meta_periodo,
			numero_convocatoria,
			id_fte_fto		
		)
		VALUES
		(
			
			:id_tipo_accion,
			:id_tipo_documento,
			:id_cargo,
			:id_area,
			:id_trabajador,
			:numero_documento,
			:direccion_oficina,
			:oficina,
			:division,
			:denominacion_cargo,
			:fecha_inicio,
			:fecha_termino,
			:fecha_efectividad,
			:observacion,
			:expediente_judicial,
			:actual,
			:anulado,
			:numero_resolucion_inicio,
			:numero_resolucion_termino,
			:tipo_vinculo_laboral,			
			:inicio_renovacion_cas,
			:termino_renovacion_cas,
			:meta_periodo,
			:numero_convocatoria,
			:id_fte_fto	
		
		) RETURNING id_desplazamiento
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			//$statement->bindParam('id_equipo_trabajo', $idEquipo_trabajo);
			$statement->bindParam('id_tipo_accion', $idTipo_accion);
			$statement->bindParam('id_tipo_documento', $idTipo_documento);
			$statement->bindParam('id_cargo', $idCargo);
			$statement->bindParam('id_area', $idArea);
			$statement->bindParam('id_trabajador', $idTrabajador);
			$statement->bindParam('numero_documento', $numeroDocumento);
			$statement->bindParam('direccion_oficina', $direccionOficina);
			$statement->bindParam('oficina', $oficina);
			$statement->bindParam('division', $division);
			$statement->bindParam('denominacion_cargo', $denominacionCargo);
			$statement->bindParam('fecha_inicio', $fechaInicio);
			$statement->bindParam('fecha_termino', $fechaEfectividad);
			$statement->bindParam('fecha_efectividad', $fechaTermino);
			$statement->bindParam('observacion', $observacion);
			$statement->bindParam('expediente_judicial', $expedienteJudicial);
			$statement->bindParam('actual', $actual);
			$statement->bindParam('anulado', $anulado);
			
			$statement->bindParam('numero_resolucion_inicio', $numeroResolucionInicio);
			$statement->bindParam('numero_resolucion_termino', $numeroResolucionTermino);
			$statement->bindParam('tipo_vinculo_laboral', $tipoVinculoLaboral);
			$statement->bindParam('inicio_renovacion_cas', $inicioRenovacionCas);
			$statement->bindParam('termino_renovacion_cas', $terminoRenovacionCas);
			$statement->bindParam('meta_periodo', $metaPeriodo);
			$statement->bindParam('numero_convocatoria', $numeroConvocatoria);
			$statement->bindParam('id_fte_fto', $idFteFto);



			$sql->ejecutar();
			$datos = $statement->fetch(PDO::FETCH_ASSOC);
			if ($datos) {
				//_Retorno de Datos
				$dtDesplazamiento->setIdDesplazamiento($datos["id_desplazamiento"]);

				//_Cerrar
				$sql->cerrar();
				return $dtDesplazamiento;
			} else {
				$sql->cerrar();
				return false;
			}
		} else {
			return false;
		}
	}



	private function fncActualizarBD($dtDesplazamiento)
	{
		
		$idDesplazamiento	=$dtDesplazamiento->getIdDesplazamiento();
		//$idEquipo_trabajo	=$dtDesplazamiento->getIdEquipoTrabajo();
		//$idTipo_accion		=$dtDesplazamiento->getIdTipoAccion();
		$idTipo_documento	=$dtDesplazamiento->getIdTipoDocumento();
		$idCargo			=$dtDesplazamiento->getIdCargo();
		$idArea				=$dtDesplazamiento->getIdArea();
		$idTrabajador		=$dtDesplazamiento->getIdTrabajador();
		$numeroDocumento	=$dtDesplazamiento->getNumeroDocumento();
		$direccionOficina	=$dtDesplazamiento->getDireccionOficina();
		$oficina			=$dtDesplazamiento->getOficina();
		$division			=$dtDesplazamiento->getDivision();
		$denominacionCargo	=$dtDesplazamiento->getDenominacionCargo();
		$fechaInicio		=$dtDesplazamiento->getFechaInicio();
		$fechaTermino		=$dtDesplazamiento->getFechaTermino();
		$fechaEfectividad	=$dtDesplazamiento->getFechaEfectividad();
		$observacion		=$dtDesplazamiento->getObservacion();
		$expedienteJudicial	=$dtDesplazamiento->getExpedienteJudicial();
		$actual 			=$dtDesplazamiento->getActual();
		$anulado 			=$dtDesplazamiento->getAnulado();


		$numeroResolucionInicio =$dtDesplazamiento->getNumeroResolucionInicio();
		$numeroResolucionTermino=$dtDesplazamiento->getNumeroResolucionTermino();
		$tipoVinculoLaboral		=$dtDesplazamiento->getTipoVinculoLaboral();
		$inicioRenovacionCas	=$dtDesplazamiento->getInicioRenovacionCas();
		$terminoRenovacionCas	=$dtDesplazamiento->getTerminoRenovacionCas();
		$metaPeriodo			=$dtDesplazamiento->getMetaPeriodo();
		$numeroConvocatoria		=$dtDesplazamiento->getNumeroConvocatoria();
		$idFteFto				=$dtDesplazamiento->getIdFteFto();
		
		$sql = cls_control::get_instancia();
		$consulta = "UPDATE escalafon.desplazamiento
		SET
			
			
			
			id_tipo_documento	= :id_tipo_documento,
			id_cargo 			= :id_cargo,
			id_area 			= :id_area,
			id_trabajador 		= :id_trabajador,
			numero_documento 	= :numero_documento,
			direccion_oficina 	= :direccion_oficina,
			oficina 			= :oficina,
			division 			= :division,
			denominacion_cargo 	= :denominacion_cargo,
			fecha_inicio 		= :fecha_inicio,
			fecha_termino 		= :fecha_termino,
			fecha_efectividad 	= :fecha_efectividad,
			observacion 		= :observacion,
			expediente_judicial = :expediente_judicial,		

			numero_resolucion_inicio 	= :numero_resolucion_inicio,
			numero_resolucion_termino 	= :numero_resolucion_termino,
			tipo_vinculo_laboral 		= :tipo_vinculo_laboral,			
			inicio_renovacion_cas 		= :inicio_renovacion_cas,
			termino_renovacion_cas 		= :termino_renovacion_cas,
			meta_periodo 				= :meta_periodo,
			numero_convocatoria 		= :numero_convocatoria,
			id_fte_fto					= :id_fte_fto	
			
		WHERE id_desplazamiento = :id_desplazamiento";

		$statement=$sql->preparar($consulta);

		if( $statement!=false ){
			$statement->bindParam('id_desplazamiento', $idDesplazamiento);
			
		
			$statement->bindParam('id_tipo_documento', $idTipo_documento);
			$statement->bindParam('id_cargo', $idCargo);
			$statement->bindParam('id_area', $idArea);
			$statement->bindParam('id_trabajador', $idTrabajador);
			$statement->bindParam('numero_documento', $numeroDocumento);
			$statement->bindParam('direccion_oficina', $direccionOficina);
			$statement->bindParam('oficina', $oficina);
			$statement->bindParam('division', $division);
			$statement->bindParam('denominacion_cargo', $denominacionCargo);
			$statement->bindParam('fecha_inicio', $fechaInicio);
			$statement->bindParam('fecha_termino', $fechaEfectividad);
			$statement->bindParam('fecha_efectividad', $fechaTermino);
			$statement->bindParam('observacion', $observacion);
			$statement->bindParam('expediente_judicial', $expedienteJudicial);

			$statement->bindParam('numero_resolucion_inicio', $numeroResolucionInicio);
			$statement->bindParam('numero_resolucion_termino', $numeroResolucionTermino);
			$statement->bindParam('tipo_vinculo_laboral', $tipoVinculoLaboral);
			$statement->bindParam('inicio_renovacion_cas', $inicioRenovacionCas);
			$statement->bindParam('termino_renovacion_cas', $terminoRenovacionCas);
			$statement->bindParam('meta_periodo', $metaPeriodo);
			$statement->bindParam('numero_convocatoria', $numeroConvocatoria);
			$statement->bindParam('id_fte_fto', $idFteFto);
			
			$sql->ejecutar();
			$datos = $statement->fetchAll(PDO::FETCH_OBJ);
			$dfdfdf= 'sd';
			if( $datos ){
				$sql->cerrar();
				return $dtDesplazamiento;
			} else {
				$sql->cerrar();
				return false;
			}
		}
		else{
			return false;
		  }
	}

	private function fncListarRegistrosBD( $id = -1 )
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			d.id_desplazamiento,			
			d.id_tipo_accion,
			(SELECT ta.tipo   FROM escalafon.tipo_accion AS ta WHERE ta.id_tipo_accion = d.id_tipo_accion) AS tipo_accion,
			d.id_tipo_documento,
			(SELECT td.tipo_documento FROM escalafon.tipo_documento AS td WHERE td.id_tipo_documento = d.id_tipo_documento) AS tipo_documento,
			d.id_cargo,
			(SELECT c.nombre_cargo  FROM escalafon.cargo AS c WHERE c.id_cargo = d.id_cargo) AS cargo,
			d.id_area,
			(SELECT a.nombre_area FROM escalafon.area AS a WHERE a.id_area = d.id_area) AS area,
			d.id_trabajador,
			d.numero_documento,
			d.direccion_oficina,
			d.oficina,
			d.division,
			d.denominacion_cargo,
			d.fecha_inicio,
			d.fecha_termino,
			d.fecha_efectividad,
			d.observacion,
			d.expediente_judicial,
			d.actual,
			d.anulado,
			d.eliminado
		FROM
			escalafon.desplazamiento AS d
		WHERE (:id_desplazamiento = -1 OR d.id_desplazamiento = :id_desplazamiento) AND d.eliminado = 0
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_desplazamiento', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new Desplazamiento;
			$temp->idDesplazamiento 	= $datos['id_desplazamiento'];
		//	$temp->idEquipoTrabajo  	= $datos['id_equipo_trabajo'];
			$temp->idTipoAccion 		= $datos['id_tipo_accion'];
			$temp->tipoAccion 			= $datos['tipo_accion'];
			$temp->idTipoDocumento		= $datos['id_tipo_documento'];
			$temp->tipoDocumento		= $datos['tipo_documento'];
			$temp->idCargo				= $datos['id_cargo'];
			$temp->cargo				= $datos['cargo'];
			$temp->idArea				= $datos['id_area'];
			$temp->area					= $datos['area'];
			$temp->idTrabajador			= $datos['id_trabajador'];
			$temp->numeroDocumento		= $datos['numero_documento'];
			$temp->direccionOficina		= $datos['direccion_oficina'];
			$temp->oficina				= $datos['oficina'];
			$temp->division				= $datos['division'];
			$temp->denominacionCargo	= $datos['denominacion_cargo'];
			$temp->fechaInicio			= $datos['fecha_inicio'];
			$temp->fechaTermino			= $datos['fecha_termino'];
			$temp->fechaEfectividad		= $datos['fecha_efectividad'];
			$temp->observacion			= $datos['observacion'];
			$temp->expedienteJudicial	= $datos['expediente_judicial'];
			$temp->actual				= $datos['actual'];
			$temp->anulado				= $datos['anulado'];
        
			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}


	private function fncListarFteFtoRegistrosBD( $id = -1 )
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			ff.id_fte_fto,
			ff.codigo,
			ff.nombre
		FROM
			escalafon.fte_fto AS ff
		WHERE (:id_fte_fto = -1 OR ff.id_fte_fto = :id_fte_fto)
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_fte_fto', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new Desplazamiento;
			$temp->idFteFto = $datos['id_fte_fto'];
			$temp->codigo  	= $datos['codigo'];
			$temp->nombre  	= $datos['nombre'];
		
        
			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}


	private function fncObtenerRegistrosBD( $id = -1 )
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			d.id_desplazamiento,			
			d.id_tipo_accion,
			d.id_tipo_documento,
			d.id_cargo,
			d.id_area,
			d.id_trabajador,
			d.numero_documento,
			d.direccion_oficina,
			d.oficina,
			d.division,
			d.denominacion_cargo,
			d.fecha_inicio,
			d.fecha_termino,
			d.fecha_efectividad,
			d.observacion,
			d.expediente_judicial,
			d.actual,
			d.anulado,
			d.eliminado,

			d.numero_resolucion_inicio,
			d.numero_resolucion_termino,
			d.tipo_vinculo_laboral,
			d.renuncia,
			d.inicio_renovacion_cas,
			d.termino_renovacion_cas,
			d.meta_periodo,
			d.numero_convocatoria,
			d.id_fte_fto,
			(SELECT ff.codigo  FROM escalafon.fte_fto AS ff WHERE ff.id_fte_fto = d.id_fte_fto)AS fte_fto
		FROM
			escalafon.desplazamiento AS d
		WHERE (d.id_desplazamiento = :id_desplazamiento) AND d.eliminado = 0
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_desplazamiento', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new Desplazamiento;
			$temp->idDesplazamiento 	= $datos['id_desplazamiento'];
		//	$temp->idEquipoTrabajo  	= $datos['id_equipo_trabajo'];
			$temp->idTipoAccion 		= $datos['id_tipo_accion'];
			$temp->idTipoDocumento		= $datos['id_tipo_documento'];
			$temp->idCargo				= $datos['id_cargo'];
			$temp->idArea				= $datos['id_area'];
			$temp->idTrabajador			= $datos['id_trabajador'];
			$temp->numeroDocumento		= $datos['numero_documento'];
			$temp->direccionOficina		= $datos['direccion_oficina'];
			$temp->oficina				= $datos['oficina'];
			$temp->division				= $datos['division'];
			$temp->denominacionCargo	= $datos['denominacion_cargo'];
			$temp->fechaInicio			= $datos['fecha_inicio'];
			$temp->fechaTermino			= $datos['fecha_termino'];
			$temp->fechaEfectividad		= $datos['fecha_efectividad'];
			$temp->observacion			= $datos['observacion'];
			$temp->expedienteJudicial	= $datos['expediente_judicial'];
			$temp->actual				= $datos['actual'];
			$temp->anulado				= $datos['anulado'];

			$temp->numeroResolucionInicio		= $datos['numero_resolucion_inicio'];
			$temp->numeroResolucionTermino	= $datos['numero_resolucion_termino'];
			$temp->tipoVinculoLaboral		= $datos['tipo_vinculo_laboral'];
			$temp->renuncia					= $datos['renuncia'];
			$temp->inicioRenovacionCas		= $datos['inicio_renovacion_cas'];
			$temp->terminoRenovacionCas		= $datos['termino_renovacion_cas'];
			$temp->metaPeriodo				= $datos['meta_periodo'];
			$temp->numeroConvocatoria		= $datos['numero_convocatoria'];
			$temp->idFteFto					= $datos['id_fte_fto'];
			$temp->fteFto					= $datos['fte_fto'];
        
			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}



	private function fncListarAreaDisponiblesBD( $id = -1 )
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			a.id_area,
			a.id_padre,
			a.id_tipo_area,
			a.nombre_area,
			a.sigla,
			a.nivel,
			a.descripcion,
			a.estado,
			a.fecha_creacion,
			a.fecha_modificacion
		FROM
			escalafon.area AS a
		WHERE 
		(:id_area = -1 OR a.id_area = :id_area)
		AND a.id_tipo_area NOT IN (1) AND a.estado = \'A\'
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_area', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new Desplazamiento;
			$temp->idArea 				= $datos['id_area'];
		//	$temp->idEquipoTrabajo  	= $datos['id_equipo_trabajo'];
			$temp->idPadre 				= $datos['id_padre'];
			$temp->idTipoArea			= $datos['id_tipo_area'];
			$temp->nombreArea			= $datos['nombre_area'];
			$temp->sigla				= $datos['sigla'];
			$temp->nivel				= $datos['nivel'];
			$temp->descripcion			= $datos['descripcion'];
			$temp->estado				= $datos['estado'];
			$temp->fechaCreacion		= $datos['fecha_creacion'];
			$temp->fechaModificacion	= $datos['fecha_modificacion'];
		
        
			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}



	private function fncListarRegistrosPorIdTrabajadorBD( $id = -1 )
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			d.id_desplazamiento,
		
			d.id_tipo_accion,
			d.id_tipo_documento,
			d.id_cargo,
			d.id_area,
			d.id_trabajador,
			d.numero_documento,
			d.direccion_oficina,
			d.oficina,
			d.division,
			d.denominacion_cargo,
			d.fecha_inicio,
			d.fecha_termino,
			d.fecha_efectividad,
			d.observacion,
			d.expediente_judicial,
			d.actual,
			d.anulado,
			d.eliminado,

			d.numero_resolucion_inicio,
			d.numero_resolucion_termino,
			d.tipo_vinculo_laboral,
			d.renuncia,
			d.inicio_renovacion_cas,
			d.termino_renovacion_cas,
			d.meta_periodo,
			d.numero_convocatoria,
			d.id_fte_fto,
			(SELECT ff.codigo  FROM escalafon.fte_fto AS ff WHERE ff.id_fte_fto = d.id_fte_fto)AS fte_fto
		FROM
			escalafon.desplazamiento AS d
		WHERE (:id_trabajador = -1 OR d.id_trabajador = :id_trabajador) AND d.eliminado = 0 
		--AND d.id_tipo_accion NOT IN(9)  
		ORDER BY d.actual
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_trabajador', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new Desplazamiento;
			$temp->idDesplazamiento 	= $datos['id_desplazamiento'];
			//$temp->idEquipoTrabajo  	= $datos['id_equipo_trabajo'];
			$temp->idTipoAccion 		= $datos['id_tipo_accion'];
			$temp->idTipoDocumento		= $datos['id_tipo_documento'];
			$temp->idCargo				= $datos['id_cargo'];
			$temp->idArea				= $datos['id_area'];
			$temp->idTrabajador			= $datos['id_trabajador'];
			$temp->numeroDocumento		= $datos['numero_documento'];
			$temp->direccionOficina	= $datos['direccion_oficina'];
			$temp->oficina				= $datos['oficina'];
			$temp->division				= $datos['division'];
			$temp->denominacionCargo	= $datos['denominacion_cargo'];
			$temp->fechaInicio			= $datos['fecha_inicio'];
			$temp->fechaTermino		= $datos['fecha_termino'];
			$temp->fechaEfectividad	= $datos['fecha_efectividad'];
			$temp->observacion			= $datos['observacion'];
			$temp->expedienteJudicial	= $datos['expediente_judicial'];
			$temp->actual				= $datos['actual'];
			$temp->anulado				= $datos['anulado'];
		
			$temp->numeroResolucionInicio		= $datos['numero_resolucion_inicio'];
			$temp->numeroResolucionTermino	= $datos['numero_resolucion_termino'];
			$temp->tipoVinculoLaboral		= $datos['tipo_vinculo_laboral'];
			$temp->renuncia					= $datos['renuncia'];
			$temp->inicioRenovacionCas		= $datos['inicio_renovacion_cas'];
			$temp->terminoRenovacionCas		= $datos['termino_renovacion_cas'];
			$temp->metaPeriodo				= $datos['meta_periodo'];
			$temp->numeroConvocatoria		= $datos['numero_convocatoria'];
			$temp->idFteFto					= $datos['id_fte_fto'];
			$temp->fteFto					= $datos['fte_fto'];
			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}

	private function fncListarRegistrosActualPorIdTrabajadorBD( $id = -1 )
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			d.id_desplazamiento,
		
			d.id_tipo_accion,
			d.id_tipo_documento,
			d.id_cargo,
			d.id_area,
			d.id_trabajador,
			d.numero_documento,
			d.direccion_oficina,
			d.oficina,
			d.division,
			d.denominacion_cargo,
			d.fecha_inicio,
			d.fecha_termino,
			d.fecha_efectividad,
			d.observacion,
			d.expediente_judicial,
			d.actual,
			d.anulado,
			d.eliminado
		FROM
			escalafon.desplazamiento AS d
		WHERE (:id_trabajador = -1 OR d.id_trabajador = :id_trabajador) AND d.eliminado = 0 AND d.actual = 1 
		ORDER BY d.id_desplazamiento DESC LIMIT 1
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_trabajador', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new Desplazamiento;
			$temp->idDesplazamiento 	= $datos['id_desplazamiento'];
			//$temp->idEquipoTrabajo  	= $datos['id_equipo_trabajo'];
			$temp->idTipoAccion 		= $datos['id_tipo_accion'];
			$temp->idTipoDocumento	= $datos['id_tipo_documento'];
			$temp->idCargo				= $datos['id_cargo'];
			$temp->idArea				= $datos['id_area'];
			$temp->idTrabajador		= $datos['id_trabajador'];
			$temp->numeroDocumento		= $datos['numero_documento'];
			$temp->direccionOficina	= $datos['direccion_oficina'];
			$temp->oficina				= $datos['oficina'];
			$temp->division				= $datos['division'];
			$temp->denominacionCargo	= $datos['denominacion_cargo'];
			$temp->fechaInicio			= $datos['fecha_inicio'];
			$temp->fechaTermino		= $datos['fecha_termino'];
			$temp->fechaEfectividad	= $datos['fecha_efectividad'];
			$temp->observacion			= $datos['observacion'];
			$temp->expedienteJudicial	= $datos['expediente_judicial'];
			$temp->actual				= $datos['actual'];
			$temp->anulado				= $datos['anulado'];
        
			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}
	private function fncListarNombramientoRegistrosPorIdTrabajadorBD( $id = -1 )
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			*
		FROM
			escalafon.desplazamiento AS d
		WHERE (:id_trabajador = -1 OR d.id_trabajador = :id_trabajador) AND d.eliminado = 0 AND d.id_tipo_accion = 9  
		ORDER BY d.actual
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_trabajador', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new Desplazamiento;
			$temp->idDesplazamiento 	= $datos['id_desplazamiento'];
			//$temp->idEquipoTrabajo  	= $datos['id_equipo_trabajo'];
			$temp->idTipoAccion 		= $datos['id_tipo_accion'];
			$temp->idTipoDocumento	= $datos['id_tipo_documento'];
			$temp->idCargo				= $datos['id_cargo'];
			$temp->idArea				= $datos['id_area'];
			$temp->idTrabajador		= $datos['id_trabajador'];
			$temp->numeroDocumento		= $datos['numero_documento'];
			$temp->direccionOficina	= $datos['direccion_oficina'];
			$temp->oficina				= $datos['oficina'];
			$temp->division				= $datos['division'];
			$temp->denominacionCargo	= $datos['denominacion_cargo'];
			$temp->fechaInicio			= $datos['fecha_inicio'];
			$temp->fechaTermino		= $datos['fecha_termino'];
			$temp->fechaEfectividad	= $datos['fecha_efectividad'];
			$temp->observacion			= $datos['observacion'];
			$temp->expedienteJudicial	= $datos['expediente_judicial'];
			$temp->actual				= $datos['actual'];
			$temp->anulado				= $datos['anulado'];
        
			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}

	private function fncListarRegistrosAuditoria( $id = -1 )
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			d.id_desplazamiento,
		
			d.id_tipo_accion,
			d.id_tipo_documento,
			d.id_cargo,
			d.id_area,
			d.id_trabajador,
			d.numero_documento,
			d.direccion_oficina,
			d.oficina,
			d.division,
			d.denominacion_cargo,
			d.fecha_inicio,
			d.fecha_termino,
			d.fecha_efectividad,
			d.observacion,
			d.expediente_judicial,
			d.actual,
			d.anulado,
			d.eliminado
		FROM
			escalafon.desplazamiento AS d
		WHERE (:id_desplazamiento = -1 OR d.id_desplazamiento = :id_desplazamiento)
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_desplazamiento', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new Desplazamiento;
			$temp->idDesplazamiento 	= $datos['id_desplazamiento'];
			//$temp->idEquipoTrabajo  	= $datos['id_equipo_trabajo'];
			$temp->idTipoAccion 		= $datos['id_tipo_accion'];
			$temp->idTipoDocumento	= $datos['id_tipo_documento'];
			$temp->idCargo				= $datos['id_cargo'];
			$temp->idArea				= $datos['id_area'];
			$temp->idTrabajador		= $datos['id_trabajador'];
			$temp->numeroDocumento		= $datos['numero_documento'];
			$temp->direccionOficina	= $datos['direccion_oficina'];
			$temp->oficina				= $datos['oficina'];
			$temp->division				= $datos['division'];
			$temp->denominacionCargo	= $datos['denominacion_cargo'];
			$temp->fechaInicio			= $datos['fecha_inicio'];
			$temp->fechaTermino		= $datos['fecha_termino'];
			$temp->fechaEfectividad	= $datos['fecha_efectividad'];
			$temp->observacion			= $datos['observacion'];
			$temp->expedienteJudicial	= $datos['expediente_judicial'];
			$temp->actual				= $datos['actual'];
			$temp->anulado				= $datos['anulado'];
			$temp->eliminado				= $datos['eliminado'];
        
			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}

	private function fncListarCargosBD( $id = -1 )
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			c.id_cargo,
			c.nombre_cargo,
			c.salario_minimo,
			c.salario_maximo
		FROM
			escalafon.cargo AS c
		WHERE (:id_cargo = -1 OR c.id_cargo = :id_cargo)
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_cargo', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new Desplazamiento;
			$temp->idCargo 	= $datos['id_cargo'];
			//$temp->idEquipoTrabajo  	= $datos['id_equipo_trabajo'];
			$temp->nombreCargo 		= $datos['nombre_cargo'];
			$temp->salarioMinimo	= $datos['salario_minimo'];
			$temp->salarioMaximo	= $datos['salario_maximo'];
		        
			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}
	private function fncEliminarBD( $id )
	{
    $bolReturn = false;
		$sql = cls_control::get_instancia();
		$consulta = '
		UPDATE escalafon.desplazamiento
		SET
		
			eliminado = 1
		WHERE id_desplazamiento = :id_desplazamiento';
		$statement = $sql->preparar( $consulta );
		if( $statement!=false ){
			$statement->bindParam('id_desplazamiento', $id);
			$sql->ejecutar();
			$datos = $statement->fetchAll(PDO::FETCH_OBJ); 
			if($datos){
				$bolReturn = true;
     		 }
     	 $sql->cerrar();
   		 }
    return $bolReturn;
	}

	private function fncAnularDesplazamientoBD( $id )
	{
    $bolReturn = false;
		$sql = cls_control::get_instancia();
		$consulta = '
		UPDATE escalafon.desplazamiento
		SET
		
			anulado = 1
		WHERE id_desplazamiento = :id_desplazamiento';
		$statement = $sql->preparar( $consulta );
		if( $statement!=false ){
			$statement->bindParam('id_desplazamiento', $id);
			$sql->ejecutar();
			$datos = $statement->fetchAll(PDO::FETCH_OBJ); 
			if($datos){
				$bolReturn = true;
      }
      $sql->cerrar();
    }
    return $bolReturn;
	}
	

	private function fncDesactivarActualBD( $idTrabajador )
	{
    $bolReturn = false;
		$sql = cls_control::get_instancia();
		$consulta = '
		UPDATE escalafon.desplazamiento
		SET
		
			actual = 0
		WHERE id_trabajador = :id_trabajador';
		$statement = $sql->preparar( $consulta );
		if( $statement!=false ){
			$statement->bindParam('id_trabajador', $idTrabajador);
			$sql->ejecutar();
			$datos = $statement->fetchAll(PDO::FETCH_OBJ); 
			if($datos){
				$bolReturn = true;
      }
      $sql->cerrar();
    }
    return $bolReturn;
	}

	  
	private function fncDesactivarDesplazamientoBD( $id )
	{
    $bolReturn = false;
		$sql = cls_control::get_instancia();
		$consulta = '
		UPDATE escalafon.desplazamiento
		SET
		
			actual = 0
		WHERE id_desplazamiento = :id_desplazamiento';
		$statement = $sql->preparar( $consulta );
		if( $statement!=false ){
			$statement->bindParam('id_desplazamiento', $id);
			$sql->ejecutar();
			$datos = $statement->fetchAll(PDO::FETCH_OBJ); 
			if($datos){
				$bolReturn = true;
      }
      $sql->cerrar();
    }
    return $bolReturn;
	  }



	private function fncBuscarDniPorNombreBD($nombre)
	{
		$bolReturn = false;
		$sql = cls_control::get_instancia();
		$consulta = "
		
		SELECT
			t.id_trabajador,
			pn.nombres,
			pn.apellidos,
			pn.nombre_completo,
			p.documento_identidad
		FROM
			escalafon.trabajador AS t
			INNER JOIN persona_natural AS pn ON pn.id_persona = t.id_trabajador
			INNER JOIN persona AS p ON p.id_persona = pn.id_persona
		WHERE
			LOWER(translate(pn.nombre_completo,'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU'))  LIKE '%' || :nombre_completo || '%'
		
		";
		$statement = $sql->preparar($consulta);
		$arrayReturn = array();
		if ($statement != false) {
			$statement->bindParam('nombre_completo', $nombre);


			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new Desplazamiento;
				$temp->dni 	= $datos['documento_identidad'];
				$temp->nombreCompleto 	= $datos['nombre_completo'];
				$temp->idTrabajador 	= $datos['id_trabajador'];
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}

	private function fncBuscarValidarNombramiento($idTrabajador)
	{
		$bolReturn = false;
		$sql = cls_control::get_instancia();
		$consulta = "
		SELECT
			d.id_desplazamiento

		FROM
			escalafon.desplazamiento AS d
			
		WHERE d.id_trabajador = :id_trabajador AND d.id_tipo_accion = 9 AND d.eliminado = 0
		
		";
		$statement = $sql->preparar($consulta);
		$arrayReturn = array();
		if ($statement != false) {
			$statement->bindParam('id_trabajador', $idTrabajador);


			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new Desplazamiento;
				$temp->idDesplazamiento 	= $datos['id_desplazamiento'];
				
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}
	  
	  
	  


} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom

?>