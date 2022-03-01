<?php
require_once '../../App/Escalafon/Models/Capacitacion.php';
require_once '../../App/Config/control.php';
require_once '../../App/Config/control.php';
require_once '../../App/Public/archivo.php';
require_once '../../App/Public/rutas.php';
require_once '../../App/Escalafon/Controllers/AuditoriaController.php';
require_once '../../App/Escalafon/Controllers/TrabajadorController.php';
require_once '../../App/Escalafon/Controllers/DesplazamientoController.php';
require_once '../../App/Escalafon/Controllers/TipoModalidadController.php';
require_once '../../App/Escalafon/Controllers/TipoActividadEducativaController.php';
require_once '../../App/Escalafon/Controllers/TipoCategoriaController.php';
require_once '../../App/General/Controllers/PersonaNaturalController.php';
require_once '../../App/General/Controllers/PersonaController.php';
//require_once '../../App/Escalafon/Controllers/EquipotrabajoController.php';
require_once '../../App/Escalafon/Controllers/DireccionController.php';
require_once('../../vendor/PHPExcel/PHPExcel.php');


class CapacitacionController extends Capacitacion
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
				
				$model['id_capacitacion'] 		= $listado->idCapacitacion;
				$model['id_trabajador'] 		= $listado->idTrabajador;
				$model['id_tipo_modalidad'] 	= $listado->idTipoModalidad;
				$model['id_tipo_actividad_educativa'] = $listado->idTipoActividadEducativa;
				$model['id_tipo_categoria'] 	= $listado->idTipoCategoria;
				$model['id_curso'] 				= $listado->idCurso;
				$model['tomo'] 					= $listado->tomo;
				$model['folio'] 				= $listado->folio;
				$model['nro_registro'] 			= $listado->nroRegistro;
				$model['organiza'] 				= $listado->organiza;
				$model['curso'] 				= $listado->curso;
				$model['fecha_inicio'] 			= $listado->fechaInicio;
				$model['fecha_termino'] 		= $listado->fechaTermino;
				$model['horas'] 				= $listado->horas;
				$model['creditos'] 				= $listado->creditos;
				$model['nota'] 					= $listado->nota;
				$model['archivo'] 				= $listado->archivo;
				$model['activo'] 				= $listado->activo;

		
	
				array_push($dtReturn, $model);
			}
		}
		return $dtReturn;
	}


	public function fncObtenerCapacitacion($id)
	{

		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosBD($id);
		$clsTipoCategoriaController = new TipoCategoriaController();
		$clsTipoActividadEducativa = new TipoActividadEducativaController();
		$clsTipoModalidadController = new TipoModalidadController();
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
		
				$model = array();
				
				$model['idCapacitacion'] 		= $listado->idCapacitacion;
				$model['idTrabajador'] 		= $listado->idTrabajador;
				$model['idTipoModalidad'] 	= $listado->idTipoModalidad;
				$model['tipoModalidad'] 	= array_shift($clsTipoModalidadController->fncListarRegistros(	$listado->idTipoModalidad));
				$model['idTipoActividadEducativa'] = $listado->idTipoActividadEducativa;
				$model['tipoActividadEducativa'] = array_shift($clsTipoActividadEducativa->fncListarRegistros( $listado->idTipoActividadEducativa));
				$model['idTipoCategoria'] 	= $listado->idTipoCategoria;
				$model['tipoCategoria'] 	= array_shift( $clsTipoCategoriaController->fncListarRegistros( $listado->idTipoCategoria));
				$model['idCurso'] 				= $listado->idCurso;
				$model['tomo'] 					= $listado->tomo;
				$model['folio'] 				= $listado->folio;
				$model['nroRegistro'] 			= $listado->nroRegistro;
				$model['organiza'] 				= $listado->organiza;
				$model['curso'] 				= $listado->curso;
				$model['fechaInicio'] 			= $listado->fechaInicio;
				$model['fechaTermino'] 			= $listado->fechaTermino;
				$model['horas'] 				= $listado->horas;
				$model['creditos'] 				= $listado->creditos;
				$model['nota'] 					= $listado->nota;
				$model['archivo'] 				= $listado->archivo;
				$model['activo'] 				= $listado->activo;

				array_push($dtReturn, $model);
			}
		}
		return array_shift($dtReturn);
	}

	public function fncListarCapacitacionIdTrabajadorIdModalidad($id=-1, $id_det=-1)
	{

		$dtReturn = array();
		$accion = 4;
		$dtListado = $this->fncListarCapacitacionIdTrabajadorIdModalidadBD($id, $id_det);
		$clsTipoCategoriaController = new TipoCategoriaController();
		$clsTipoActividadEducativa = new TipoActividadEducativaController();
		$clsTipoModalidadController = new TipoModalidadController();

		$listaAuditoria = array();
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
		
				$model = array();
				
				$model['idCapacitacion'] 		= $listado->idCapacitacion;
				$model['idTrabajador'] 		= $listado->idTrabajador;
				$model['idTipoModalidad'] 	= $listado->idTipoModalidad;
				$model['tipoModalidad'] 	= array_shift($clsTipoModalidadController->fncListarRegistros(	$listado->idTipoModalidad));
				$model['idTipoActividadEducativa'] = $listado->idTipoActividadEducativa;
				$model['tipoActividadEducativa'] = array_shift($clsTipoActividadEducativa->fncListarRegistros( $listado->idTipoActividadEducativa));
				$model['idTipoCategoria'] 	= $listado->idTipoCategoria;
				$model['tipoCategoria'] 	= array_shift( $clsTipoCategoriaController->fncListarRegistros( $listado->idTipoCategoria));
				$model['idCurso'] 				= $listado->idCurso;
				$model['curso'] 				= $listado->curso;
				$model['tomo'] 					= $listado->tomo;
				$model['folio'] 				= $listado->folio;
				$model['nroRegistro'] 			= $listado->nroRegistro;
				$model['organiza'] 				= $listado->organiza;
			
				$model['fechaInicio'] 			= $listado->fechaInicio;
				$model['fechaTermino'] 			= $listado->fechaTermino;
				$model['horas'] 				= $listado->horas;
				$model['creditos'] 				= $listado->creditos;
				$model['nota'] 					= $listado->nota;
				$model['archivo'] 				= $listado->archivo;
				$model['activo'] 				= $listado->activo;

				$model['fechaHoraAuditoria'] 				= $listado->fechaHoraAuditoria;
				$model['usuarioAuditoria'] 				= $listado->usuarioAuditoria;

				array_push($dtReturn, $model);
				array_push($listaAuditoria, $model['idCapacitacion']);
			}
			$auditorioController = new AuditoriaController();
			$auditoria = $auditorioController->fncGuardar($accion, 'capacitacion', 'id_capacitacion', null, json_encode($listaAuditoria));
		}
		return ($dtReturn);
	}



	public function fncListarRegistrosModalidadExternaVista($id = -1)
	{

		$dtReturn = array();
		$idtipoModalidadCapacitacion=2;
		$dtListado = $this->fncListarRegistrosExcelModalidadExternaBD($id,$idtipoModalidadCapacitacion);
		//$clsAuditoriaController = new AuditoriaController();
		$clsTrabajadorController = new TrabajadorController();
		//$clsPersonaNaturalController = new PersonaNaturalController();
		$clsDesplazamientoController = new DesplazamientoController();
		$clsTipoCategoriaController = new TipoCategoriaController();
		$clsTipoActividadEducativa = new TipoActividadEducativaController();
	

		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){

				$dtTrabajador		= $clsTrabajadorController->fncListarRegistros($listado->idTrabajador);
				$dtDesplazamiento	= $clsDesplazamientoController->fncListarRegistrosActualPorIdTrabajador($listado->idTrabajador);
				$dtTipoCategoria	= $clsTipoCategoriaController->fncListarRegistros($listado->idTipoCategoria);
				$dtTipoActividadEducativa	= $clsTipoActividadEducativa->fncListarRegistros($listado->idTipoActividadEducativa);
			

				$fecha_hora = $nombres = $apellidos = $profesion = $condision = $centroTrabajo = $categoria = $detalle = $tipoDocumento= $registrador = '';
			

				if (fncGeneralValidarDataArray($dtTrabajador)) {
					$dtArrayTipoTrabajador 		=array_shift($dtTrabajador)['tipoTrabajador'];
			
					$condision	= fncObtenerValorArray($dtArrayTipoTrabajador, 'tipoTrabajador', true);
				//	$centroTrabajo	= fncObtenerValorArray($dtArrayUnidadEjecutora, 'unidad_ejecutora', true);
				}
				if (fncGeneralValidarDataArray($dtDesplazamiento)) {  //posible cambio por prafesion

					$dtArrayCargo 	=$dtDesplazamiento[0]['cargo'];
					$dtArrayArea 	=$dtDesplazamiento[0]['area'];
		
					$cargo 	= fncObtenerValorArray($dtArrayCargo, 'nombreCargo', true);
					$area 	= fncObtenerValorArray($dtArrayArea, 'nombre_area', true);
					$profesion = $cargo.'/'.$area;

				}
				if (fncGeneralValidarDataArray($dtTipoCategoria)) {
					$categoria = fncObtenerValorArray(array_shift($dtTipoCategoria), 'tipoCategoria', true);  // Local  - Nacional - Internacional
				}

				if (fncGeneralValidarDataArray($dtTipoActividadEducativa)) {
					$tipoDocumento = fncObtenerValorArray(array_shift($dtTipoActividadEducativa), 'tipoActividadEducativa', true);  
				}


				$model = array();
				
				$model['fecha'] 				= $listado->fechaHoraAuditoria;
				$model['apellidos'] 			= $listado->apellidos;
				$model['nombres'] 				= $listado->nombres;
				$model['profesion'] 			= $listado->profesion;
				$model['cargoArea'] 			= $profesion;
				$model['condision'] 			= $condision;
				$model['centroTrabajo'] 		= $listado->centroTrabajo;
				$model['categoria'] 			= $categoria; //L-N-i
				$model['detalle'] 				= $listado->organiza; //dato original "organiza"
				$model['actividadCapacitacion'] = $listado->curso;
				$model['folio'] 				= $listado->folio;
				$model['horas'] 				= $listado->horas;
				$model['creditos'] 				= $listado->creditos;
				$model['fechaInicio'] 			= $listado->fechaInicio;
				$model['fechaTermino'] 		= $listado->fechaTermino;
				$model['nota'] 					= $listado->nota;
				$model['tipoDocumento'] 		= $tipoDocumento;
				$model['folio'] 				= $listado->folio;	
				$model['tomo'] 					= $listado->tomo;		
				$model['diferenciaAnios'] 		= number_format((float)$listado->diferencia, 2, '.', '');
				$model['documentoValido'] 		= fncDocumentoValido($model['diferenciaAnios'],$listado->idTipoActividadEducativa,$listado->horas);
				$model['registrador'] 				= $listado->usuarioAuditoria;
				$model['observacion'] 				= '';
				$model['fechaHoraAuditoria'] 	= $listado->fechaHoraAuditoria;
				$model['usuarioAuditoria'] 		= $listado->usuarioAuditoria;

			
				array_push($dtReturn, $model);
			}

			$auditorioController = new AuditoriaController();	
			$auditoria = $auditorioController->fncGuardar(4, 'capacitacion','id_capacitacion', $id );
		}
		return $dtReturn;
	}


	public function fncListarRegistrosModalidadExternaExcel($id = -1)
	{

		$dtReturn = array();
		$idtipoModalidadCapacitacion=2;
		$dtListado = $this->fncListarRegistrosExcelModalidadExcelBD($id,$idtipoModalidadCapacitacion);
		//$clsAuditoriaController = new AuditoriaController();
		$clsTrabajadorController = new TrabajadorController();
		//$clsPersonaNaturalController = new PersonaNaturalController();
		$clsDesplazamientoController = new DesplazamientoController();
		$clsTipoCategoriaController = new TipoCategoriaController();
		$clsTipoActividadEducativa = new TipoActividadEducativaController();
	

		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){

				$dtTrabajador		= $clsTrabajadorController->fncListarRegistros($listado->idTrabajador);
				$dtDesplazamiento	= $clsDesplazamientoController->fncListarRegistrosActualPorIdTrabajador($listado->idTrabajador);
				$dtTipoCategoria	= $clsTipoCategoriaController->fncListarRegistros($listado->idTipoCategoria);
				$dtTipoActividadEducativa	= $clsTipoActividadEducativa->fncListarRegistros($listado->idTipoActividadEducativa);
			

				$fecha_hora = $nombres = $apellidos = $profesion = $condision = $centroTrabajo = $categoria = $detalle = $tipoDocumento= $registrador = '';
			

				if (fncGeneralValidarDataArray($dtTrabajador)) {
					$dtArrayTipoTrabajador 		=array_shift($dtTrabajador)['tipoTrabajador'];
			
					$condision	= fncObtenerValorArray($dtArrayTipoTrabajador, 'tipoTrabajador', true);
				//	$centroTrabajo	= fncObtenerValorArray($dtArrayUnidadEjecutora, 'unidad_ejecutora', true);
				}
				if (fncGeneralValidarDataArray($dtDesplazamiento)) {  //posible cambio por prafesion

					$dtArrayCargo 	=$dtDesplazamiento[0]['cargo'];
					$dtArrayArea 	=$dtDesplazamiento[0]['area'];
		
					$cargo 	= fncObtenerValorArray($dtArrayCargo, 'nombreCargo', true);
					$area 	= fncObtenerValorArray($dtArrayArea, 'nombre_area', true);
					$profesion = $cargo.'/'.$area;

				}
				if (fncGeneralValidarDataArray($dtTipoCategoria)) {
					$categoria = fncObtenerValorArray(array_shift($dtTipoCategoria), 'tipoCategoria', true);  // Local  - Nacional - Internacional
				}

				if (fncGeneralValidarDataArray($dtTipoActividadEducativa)) {
					$tipoDocumento = fncObtenerValorArray(array_shift($dtTipoActividadEducativa), 'tipoActividadEducativa', true);  
				}


				$model = array();
				
				$model['fecha'] 				= $listado->fechaHoraAuditoriaInsert;
				$model['apellidos'] 			= $listado->apellidos;
				$model['nombres'] 				= $listado->nombres;
				$model['profesion'] 			= $listado->profesion;
				$model['cargoArea'] 			= $profesion;
				$model['condision'] 			= $condision;
				$model['centroTrabajo'] 		= $listado->centroTrabajo;
				$model['categoria'] 			= $categoria; //L-N-i
				$model['detalle'] 				= $listado->organiza; //dato original "organiza"
				$model['actividadCapacitacion'] = $listado->curso;
				$model['horas'] 				= $listado->horas;
				$model['creditos'] 				= $listado->creditos;
				$model['fechaInicio'] 			= $listado->fechaInicio;
				$model['fechaTermino'] 		= $listado->fechaTermino;
				$model['nota'] 					= $listado->nota;
				$model['tipoDocumento'] 		= $tipoDocumento;
				$model['folio'] 				= $listado->folio;	
				$model['tomo'] 					= $listado->tomo;		
				$model['diferenciaAnios'] 		= number_format((float)$listado->diferencia, 2, '.', '');
				$model['documentoValido'] 		= fncDocumentoValido($model['diferenciaAnios'],$listado->idTipoActividadEducativa,$listado->horas);
				$model['registrador'] 				= $listado->usuarioAuditoriaInsert;
				$model['observacion'] 				= '';
				
				$model['fechaHoraAuditoria'] 	= $listado->fechaHoraAuditoria;
				$model['usuarioAuditoria'] 		= $listado->usuarioAuditoria;
				$model['usuarioAuditoriaInsert'] = $listado->usuarioAuditoriaInsert;


			
			
				array_push($dtReturn, $model);
			}

			$auditorioController = new AuditoriaController();	
			$auditoria = $auditorioController->fncGuardar(7, 'capacitacion','id_capacitacion', $id );
			$dtReturn = $this->fncListarRegistrosModalidadExternaExcelArchivo($dtReturn);
		}
		return $dtReturn;
	}

	public function fncListarRegistrosModalidadExternaExcelArchivo($dataReporte)  {
		//$fechainicio = fncValidarFormatearFecha($fechainicio, "Y-m-d"); //-> Importante darle el MISMO FORMATO que a la BD
		//$fechafinal = fncValidarFormatearFecha($fechafinal, "Y-m-d"); //---> Importante darle el MISMO FORMATO que a la BD
		   //$dtListado = $this->fncObtenerAreaBD($idArea);
		   
		   //ini_set('memory_limit', '512M');
		$objPHPExcel = new PHPExcel();
		$estiloTituloReporte = array(
		  'font' => array(
			'name' => 'Calibri', 
			'bold' => true,
			'size' => 18
		  ),
		  'fill' => array(),
		  'borders' => array(), 
		  'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			'rotation' => 0,
			'wrap' => TRUE
		  )
		);
		$estiloSubTituloReporte = array(
		  'font' => array(
			'name' => 'Calibri', 
			'bold' => true,
			'size' => 16
		  ),
		  'fill' => array(),
		  'borders' => array(), 
		  'alignment' =>  array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			'rotation' => 0,
			'wrap' => TRUE
		  )
		);
		$estiloSubTitulo2Reporte = array(
		  'font' => array(
			'name' => 'Calibri', 
			'bold' => true,
			'size' => 11
		  ),
		  'fill' => array(),
		  'borders' => array(), 
		  'alignment' =>  array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			'rotation' => 0,
			'wrap' => TRUE
		  )
		);
		$estiloSubTitulo3Reporte = array(
		  'font' => array(
			'name' => 'Calibri', 
			'size' => 11
		  ),
		  'fill' => array(),
		  'borders' => array(), 
		  'alignment' =>  array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			'rotation' => 0,
			'wrap' => TRUE
		  )
		);
		$estiloTituloMP = array(
		  'font' => array(
			'name' => 'Calibri', 
			'bold' => true,
			'size' => 14,
			'color' => array('rgb' => 'FFFFFF'),
		  ),
		  'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => '808080')
		  ),
		  'borders' => array(), 
		  'alignment' =>  array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			'rotation' => 0,
			'wrap' => TRUE
		  )
		);
		$estiloFechaMP = array(
		  'font' => array(
			'name' => 'Calibri', 
			'bold' => true,
			'size' => 11,
			'color' => array('rgb' => 'FFFFFF'),
		  ),
		  'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => '808080')
		  ),
		  'borders' => array(), 
		  'alignment' =>  array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			'rotation' => 0,
			'wrap' => TRUE
		  )
		);
		$estiloTituloTarea = array(
		  'font' => array(
			'name' => 'Bahnschrift Light', 
			'size' => 11,
			'color' => array('rgb' => 'FFFFFF'),
		  ),
		  'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => '0070C0')
		  ),
		  'borders' => array(), 
		  'alignment' =>  array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			'rotation' => 0,
			'wrap' => TRUE
		  )
		);
		$estiloTarea = array(
		  'font' => array(
			'name' => 'Arial', 
			'size' => 9
		  ),
		  'fill' => array(),
		  'borders' => array(), 
		  'alignment' =>  array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			'rotation' => 0,
			'wrap' => TRUE
		  )
		);
		
		$estiloTodoLosBordes = array(
			'borders' => array(
			  'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN
			  )
			)
		  );
		$objPHPExcel->getActiveSheet()->getStyle('B4:U4')->applyFromArray($estiloTarea);
		//$objPHPExcel->getActiveSheet()->getStyle('B3:G3')->applyFromArray($estiloSubTituloReporte);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:W2');
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10.43);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10.29);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30.57);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(40.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(40.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(40.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(20.71);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2','REPORTE DE CAPACITACIONES EXTERNAS');
		//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H2','=ALEATORIO.ENTRE(4, 9)');
		
		
		/* merge cabeceras */
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B4:B6');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C4:C6');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D4:D6');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E4:E6');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('F4:F6');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('G4:H5');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('I4:I5');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('J4:K5');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('L4:L6');

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('M4:M6');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('N4:N6');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('O4:O6');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('P4:P6');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('Q4:Q6');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('R4:R6');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('S4:S6');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('T4:T6');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('U4:U6');

		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4','FECHA');
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4','REGISTRO-Nº');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D4','APELLIDOS');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E4','NOMBRES');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4','PROFESIÓN');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G4','CONDICIÓN');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G6','N');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H6','C');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I4','CENTRO DE TRABAJA');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J4','LUGAR DE CAPACITACIÓN');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J6','L/N/I');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K6','DETALLE');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L4','ACTIVIDAD DE CAPACITACIÓN');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M4','HORAS ACADÉMICAS');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N4','CRÉDITOS');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O4','FECHA DE INICIO');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P4','FECHA DE TÉRMINO');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q4','NOTA');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R4','TIPO DE DOCUMENTO');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S4','OBSERVACIONES');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T4','REGISTRADOR');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U4','TOMO III');
		
		
		$fila = 7;
		
		$filaContador = 0;
		if( fncGeneralValidarDataArray($dataReporte) ){
	/*
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B8','FECHA');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C8','DIA');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D8','HORA ENTRADA');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E8','HORA SALIDA');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F8','HORA EXTRA');
	*/
			
			//$objPHPExcel->getActiveSheet()->getStyle('X16:Z22')->applyFromArray($estiloTodoLosBordes); 
	
			
			$objPHPExcel->getActiveSheet()->getStyle('B4:U6')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('B4:U6')->applyFromArray($estiloTarea); 
			$objPHPExcel->getActiveSheet()->getStyle('B4:U6')->applyFromArray($estiloTodoLosBordes);
		
			//$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
			//$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
	
			
			//$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
			//$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
	
			$reg =1;
			$sumaTiempoMinutos = 0;
			foreach ($dataReporte as $listado) {
	
				if($listado['fecha']!=''){
					$fecha = explode(" ", $listado['fecha']);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,$fecha[0]);
				}else{
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.'');
				}
			
								
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$fila, $fila );
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$fila,$listado['apellidos']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,$listado['nombres']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$fila,$listado['profesion']);

				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$fila,$listado['condision']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$fila,$listado['condision']);

				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$fila,$listado['centroTrabajo']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$fila,$listado['categoria']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$fila,$listado['detalle']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$fila,$listado['actividadCapacitacion']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$fila,$listado['horas']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$fila,$listado['creditos']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$fila,$listado['fechaInicio']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$fila,$listado['fechaTermino']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$fila,$listado['nota']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$fila,$listado['tipoDocumento']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$fila,'');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$fila,$listado['registrador']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$fila,'');
				
	
			$fila++;
				
			}

	
		}
		
		$objPHPExcel->getActiveSheet()->getStyle('B4:U4')->getAlignment()->setWrapText(true);
		$objPHPExcel->setActiveSheetIndex(0);
		
		try{			
	
		  $optArchivo = cls_rutas::get('capacitacionExternaExcel')."reporte_capacitacion_externa.xlsx";

		  $writer = new PHPExcel_Writer_Excel2007($objPHPExcel);
		  $writer->setPreCalculateFormulas(false); 
		  $writer->save($optArchivo);
		  return $optArchivo;
	   } catch (Exception $e) {
		  return false;
		}
	  }


	public function fncListarRegistrosModalidadInternaVista($id = -1)
	{

		$dtReturn = array();
		$idtipoModalidadCapacitacion=1;
		$dtListado = $this->fncListarRegistrosExcelModalidadExternaBD($id,$idtipoModalidadCapacitacion);
		$clsAuditoriaController = new AuditoriaController();
		$clsTrabajadorController = new TrabajadorController();
		$clsPersonaNaturalController = new PersonaNaturalController();
		$clsDesplazamientoController = new DesplazamientoController();
		$clsTipoCategoriaController = new TipoCategoriaController();
		$clsTipoActividadEducativa = new TipoActividadEducativaController();
		$clsPersonaController = new PersonaController();
		//$clsEquipoTrabajoController = new EquipoTrabajoController();
	

		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){

			
				$dtTrabajador		= $clsTrabajadorController->fncListarRegistros($listado->idTrabajador);
				$dtDesplazamiento	= $clsDesplazamientoController->fncListarRegistrosActualPorIdTrabajador($listado->idTrabajador);
				$dtTipoCategoria	= $clsTipoCategoriaController->fncListarRegistros($listado->idTipoCategoria);
				$dtTipoActividadEducativa	= $clsTipoActividadEducativa->fncListarRegistros($listado->idTipoActividadEducativa);
				$dtPersona 			= $clsPersonaController->fncListarRegistros($listado->idTrabajador);
				
			

				$soloCargo=$telefono = $correoElectronico = $equipoTrabajo = $documentoIdentidad = $codigoUnico =  $nombres = $apellidos = $profesion = $condision = $centroTrabajo = $categoria = $detalle = $tipoDocumento= $registrador = '';


				if (fncGeneralValidarDataArray($dtPersona)) {	
					$persona= array_shift($dtPersona);
					$documentoIdentidad = fncObtenerValorArray($persona, 'documento_identidad', true);
					$correoElectronico = fncObtenerValorArray($persona, 'correo_electronico', true);
					$telefono = fncObtenerValorArray($persona, 'telefono', true);
					
				}

				if (fncGeneralValidarDataArray($dtTrabajador)) {
					
					$dtTrabajador = array_shift($dtTrabajador);
					$dtArrayTipoTrabajador 		=$dtTrabajador['tipoTrabajador'];
					$dtArrayUnidadEjecutora 	=$dtTrabajador['unidadEjecutora'];
					$codigoUnico = $dtTrabajador['codigoUnico'];

					$condision	= fncObtenerValorArray($dtArrayTipoTrabajador, 'tipoTrabajador', true);
					$centroTrabajo	= fncObtenerValorArray($dtArrayUnidadEjecutora, 'unidadEjecutora', true);
				}
				if (fncGeneralValidarDataArray($dtDesplazamiento)) {  //posible cambio por prafesion

					$dtArrayCargo 	=$dtDesplazamiento[0]['cargo'];
					$dtArrayArea 	=$dtDesplazamiento[0]['area'];

					$cargo 	= fncObtenerValorArray($dtArrayCargo, 'nombreCargo', true);
					$area 	= fncObtenerValorArray($dtArrayArea, 'nombre_area', true);
					$profesion = $cargo.'/'.$area;

				}
			
				if (fncGeneralValidarDataArray($dtTipoActividadEducativa)) {
					$tipoDocumento = fncObtenerValorArray(array_shift($dtTipoActividadEducativa), 'tipoActividadEducativa', true);  
				}

				$model = array();
				
				$model['idCurso'] 				= $listado->idCurso;
				$model['codigoParicipante'] 	= $codigoUnico;
				$model['nombres'] 				= $listado->nombres;
				$model['apellidos'] 			= $listado->apellidos;
				$model['documentoIdentidad'] 	= $listado->documentoIdentidad;				
				$model['centroTrabajado'] 		= $centroTrabajo;
				$model['area'] 					= $listado->nombreArea;
				$model['folio'] 				= $listado->folio;
				$model['cargoResponsabilidad'] 	= $profesion;
				$model['condicion'] 			= $condision;
				$model['tipoLabor'] 			= $soloCargo;
				$model['grupoOcupacional'] 		= "-";
				$model['actividadCapacitacion'] = $listado->curso;
				$model['profesion'] 			= $listado->profesion;
				$model['correo']				= $correoElectronico;
				$model['telefono']				= $telefono;
				$model['tipoParticipante']				= "-";
				$model['nota'] 					= $listado->nota;
				$model['tipoDocumento'] 		= $tipoDocumento;
				
				$model['diferenciaAnios'] 		= number_format((float)$listado->diferencia, 2, '.', '');
				$model['documentoValido'] 		= fncDocumentoValido($model['diferenciaAnios'],$listado->idTipoActividadEducativa,$listado->horas);
				$model['fechaHoraAuditoria'] 	= $listado->fechaHoraAuditoria;
				$model['usuarioAuditoria'] 		= $listado->usuarioAuditoria;

			
				array_push($dtReturn, $model);
			}

			$auditorioController = new AuditoriaController();	
			$auditoria = $auditorioController->fncGuardar(4, 'capacitacion','id_capacitacion', $id );
			
		}
		return $dtReturn;
	}

	public function fncListarRegistrosModalidadInternaExcel($id = -1)
	{

		$dtReturn = array();
		$idtipoModalidadCapacitacion=1;
		$dtListado = $this->fncListarRegistrosExcelModalidadExternaBD($id,$idtipoModalidadCapacitacion);
		$clsAuditoriaController = new AuditoriaController();
		$clsTrabajadorController = new TrabajadorController();
		$clsPersonaNaturalController = new PersonaNaturalController();
		$clsDesplazamientoController = new DesplazamientoController();
		$clsTipoCategoriaController = new TipoCategoriaController();
		$clsTipoActividadEducativa = new TipoActividadEducativaController();
		$clsPersonaController = new PersonaController();
		//$clsEquipoTrabajoController = new EquipoTrabajoController();
	

		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){

			
				$dtTrabajador		= $clsTrabajadorController->fncListarRegistros($listado->idTrabajador);
				$dtDesplazamiento	= $clsDesplazamientoController->fncListarRegistrosActualPorIdTrabajador($listado->idTrabajador);
				$dtTipoCategoria	= $clsTipoCategoriaController->fncListarRegistros($listado->idTipoCategoria);
				$dtTipoActividadEducativa	= $clsTipoActividadEducativa->fncListarRegistros($listado->idTipoActividadEducativa);
				$dtPersona 			= $clsPersonaController->fncListarRegistros($listado->idTrabajador);
				
			

				$soloCargo=$telefono = $correoElectronico = $equipoTrabajo = $documentoIdentidad = $codigoUnico =  $nombres = $apellidos = $profesion = $condision = $centroTrabajo = $categoria = $detalle = $tipoDocumento= $registrador = '';


				if (fncGeneralValidarDataArray($dtPersona)) {	
					$persona= array_shift($dtPersona);
					$documentoIdentidad = fncObtenerValorArray($persona, 'documento_identidad', true);
					$correoElectronico = fncObtenerValorArray($persona, 'correo_electronico', true);
					$telefono = fncObtenerValorArray($persona, 'telefono', true);
					
				}

				if (fncGeneralValidarDataArray($dtTrabajador)) {
					
					$dtTrabajador = array_shift($dtTrabajador);
					$dtArrayTipoTrabajador 		=$dtTrabajador['tipoTrabajador'];
					$dtArrayUnidadEjecutora 	=$dtTrabajador['unidadEjecutora'];
					$codigoUnico = $dtTrabajador['codigoUnico'];

					$condision	= fncObtenerValorArray($dtArrayTipoTrabajador, 'tipoTrabajador', true);
					$centroTrabajo	= fncObtenerValorArray($dtArrayUnidadEjecutora, 'unidadEjecutora', true);
				}
				if (fncGeneralValidarDataArray($dtDesplazamiento)) {  //posible cambio por prafesion

					$dtArrayCargo 	=$dtDesplazamiento[0]['cargo'];
					$dtArrayArea 	=$dtDesplazamiento[0]['area'];

					$cargo 	= fncObtenerValorArray($dtArrayCargo, 'nombreCargo', true);
					$area 	= fncObtenerValorArray($dtArrayArea, 'nombre_area', true);
					$profesion = $cargo.'/'.$area;
					$soloCargo = $cargo;

				}
			
				if (fncGeneralValidarDataArray($dtTipoActividadEducativa)) {
					$tipoDocumento = fncObtenerValorArray(array_shift($dtTipoActividadEducativa), 'tipoActividadEducativa', true);  
				}

				$model = array();
				
				$model['idCurso'] 				= $listado->idCurso;
				$model['codigoParticipante'] 	= $codigoUnico;
				$model['nombres'] 				= $listado->nombres;
				$model['apellidos'] 			= $listado->apellidos;
				$model['documentoIdentidad'] 	= $listado->documentoIdentidad;				
				$model['centroTrabajado'] 		= $centroTrabajo;
				$model['area'] 					= $listado->nombreArea;
				$model['cargoResponsabilidad'] 	= $profesion;
				$model['folio'] 				= $listado->folio;

				$model['condicion'] 			= $condision;
				$model['tipoLabor'] 			= $soloCargo;
				$model['grupoOcupacional'] 		= "-";
				$model['actividadCapacitacion'] = $listado->curso;
				$model['profesion'] 			= $listado->profesion;
				$model['correo']				= $correoElectronico;
				$model['telefono']				= $telefono;
				$model['tipoParticipante']				= "-";
				$model['nota'] 					= $listado->nota;
				$model['tipoDocumento'] 		= $tipoDocumento;
				
				$model['diferenciaAnios'] 		= number_format((float)$listado->diferencia, 2, '.', '');
				$model['documentoValido'] 		= fncDocumentoValido($model['diferenciaAnios'],$listado->idTipoActividadEducativa,$listado->horas);
				$model['fechaHoraAuditoria'] 	= $listado->fechaHoraAuditoria;
				$model['usuarioAuditoria'] 		= $listado->usuarioAuditoria;

			
				array_push($dtReturn, $model);
			}

			$auditorioController = new AuditoriaController();	
			$auditoria = $auditorioController->fncGuardar(7, 'capacitacion','id_capacitacion', $id );

			$dtReturn = $this->fncListarRegistrosModalidadInternaExcelArchivo($dtReturn);
			
		}
		return $dtReturn;
	}

	public function fncListarRegistrosModalidadInternaExcelArchivo($dataReporte)  {
		//$fechainicio = fncValidarFormatearFecha($fechainicio, "Y-m-d"); //-> Importante darle el MISMO FORMATO que a la BD
		//$fechafinal = fncValidarFormatearFecha($fechafinal, "Y-m-d"); //---> Importante darle el MISMO FORMATO que a la BD
		   //$dtListado = $this->fncObtenerAreaBD($idArea);
		   
		   //ini_set('memory_limit', '512M');
		$objPHPExcel = new PHPExcel();
		$estiloTituloReporte = array(
		  'font' => array(
			'name' => 'Calibri', 
			'bold' => true,
			'size' => 18
		  ),
		  'fill' => array(),
		  'borders' => array(), 
		  'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			'rotation' => 0,
			'wrap' => TRUE
		  )
		);
		$estiloSubTituloReporte = array(
		  'font' => array(
			'name' => 'Calibri', 
			'bold' => true,
			'size' => 16
		  ),
		  'fill' => array(),
		  'borders' => array(), 
		  'alignment' =>  array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			'rotation' => 0,
			'wrap' => TRUE
		  )
		);
		$estiloSubTitulo2Reporte = array(
		  'font' => array(
			'name' => 'Calibri', 
			'bold' => true,
			'size' => 11
		  ),
		  'fill' => array(),
		  'borders' => array(), 
		  'alignment' =>  array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			'rotation' => 0,
			'wrap' => TRUE
		  )
		);
		$estiloSubTitulo3Reporte = array(
		  'font' => array(
			'name' => 'Calibri', 
			'size' => 11
		  ),
		  'fill' => array(),
		  'borders' => array(), 
		  'alignment' =>  array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			'rotation' => 0,
			'wrap' => TRUE
		  )
		);
		$estiloTituloMP = array(
		  'font' => array(
			'name' => 'Calibri', 
			'bold' => true,
			'size' => 14,
			'color' => array('rgb' => 'FFFFFF'),
		  ),
		  'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => '808080')
		  ),
		  'borders' => array(), 
		  'alignment' =>  array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			'rotation' => 0,
			'wrap' => TRUE
		  )
		);
		$estiloFechaMP = array(
		  'font' => array(
			'name' => 'Calibri', 
			'bold' => true,
			'size' => 11,
			'color' => array('rgb' => 'FFFFFF'),
		  ),
		  'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => '808080')
		  ),
		  'borders' => array(), 
		  'alignment' =>  array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			'rotation' => 0,
			'wrap' => TRUE
		  )
		);
		$estiloTituloTarea = array(
		  'font' => array(
			'name' => 'Bahnschrift Light', 
			'size' => 11,
			'color' => array('rgb' => 'FFFFFF'),
		  ),
		  'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => '0070C0')
		  ),
		  'borders' => array(), 
		  'alignment' =>  array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			'rotation' => 0,
			'wrap' => TRUE
		  )
		);
		$estiloTarea = array(
		  'font' => array(
			'name' => 'Arial', 
			'size' => 9
		  ),
		  'fill' => array(),
		  'borders' => array(), 
		  'alignment' =>  array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			'rotation' => 0,
			'wrap' => TRUE
		  )
		);
		
		$estiloTodoLosBordes = array(
			'borders' => array(
			  'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN
			  )
			)
		  );
		$objPHPExcel->getActiveSheet()->getStyle('B4:U4')->applyFromArray($estiloTarea);
		//$objPHPExcel->getActiveSheet()->getStyle('B3:G3')->applyFromArray($estiloSubTituloReporte);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:W2');
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10.43);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10.29);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30.57);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(40.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(40.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(40.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(20.71);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2','REPORTE DE CAPACITACIONES INTERNAS');
		//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H2','=ALEATORIO.ENTRE(4, 9)');
		
		
		/* merge cabeceras */
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B4:B7');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C4:C7');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D4:D7');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E4:E7');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('F4:F7');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('G4:G7');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('H4:H7');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('I4:I7');

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('J4:J7');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('K4:K7');
	
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('L4:L7');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('M4:M7');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('N4:N7');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('O4:O7');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('P4:P7');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('Q4:Q7');

	
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4','ID CURSO');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4','CÓDIGO PARTICIPANTE');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D4','NOMBRES');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E4','APELLIDOS');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4','CENTRO DE TRABAJO');
	
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G4','ÁREA');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H4','CARGO RESPONSABILIDAD');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I4','CONDICIÓN lABORAL');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J4','SERUMS');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K4','TIPO LABOR ');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L4','GRUPO OCUPACIONAL ');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M4','PROFESIÓN');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N4','CORREO ELECTRÓNICO');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O4','TELÉFONO');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P4','TIPO DE PARTICIPANTE');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q4','NOTA FINAL');
		


		
		$fila = 8;
		
		$filaContador = 0;
		if( fncGeneralValidarDataArray($dataReporte) ){
	/*
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B8','FECHA');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C8','DIA');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D8','HORA ENTRADA');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E8','HORA SALIDA');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F8','HORA EXTRA');
	*/
			
			//$objPHPExcel->getActiveSheet()->getStyle('X16:Z22')->applyFromArray($estiloTodoLosBordes); 
	
			
			$objPHPExcel->getActiveSheet()->getStyle('B4:Q7')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('B4:Q7')->applyFromArray($estiloTarea); 
			$objPHPExcel->getActiveSheet()->getStyle('B4:Q7')->applyFromArray($estiloTodoLosBordes);
		
			//$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
			//$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
	
			
			//$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
			//$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
	
			$reg =1;
			$sumaTiempoMinutos = 0;
			foreach ($dataReporte as $listado) {
	
		
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,$listado['idCurso'] );				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$fila,$listado['codigoParticipante']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$fila,$listado['nombres']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,$listado['apellidos']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$fila,$listado['documentoIdentidad']);

				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$fila,$listado['centroTrabajo']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$fila,$listado['area']);

				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$fila,$listado['cargoResponsabilidad']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$fila,$listado['condision']);
				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('k'.$fila,$listado['tipoLabor']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('l'.$fila,$listado['grupoOcupacional']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$fila,$listado['profesion']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$fila,$listado['correo']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$fila,$listado['telefono']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$fila,$listado['tipoParticipante']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$fila,$listado['nota']);
							
	
			$fila++;
				
			}

	
		}
		
		$objPHPExcel->getActiveSheet()->getStyle('B4:U4')->getAlignment()->setWrapText(true);
		$objPHPExcel->setActiveSheetIndex(0);
		
		try{			
	
		  $optArchivo = cls_rutas::get('capacitacionInternaExcel')."reporte_capacitacion_interna.xlsx";

		  $writer = new PHPExcel_Writer_Excel2007($objPHPExcel);
		  $writer->setPreCalculateFormulas(false); 
		  $writer->save($optArchivo);
		  return $optArchivo;
	   } catch (Exception $e) {
		  return false;
		}
	  }
	public function fncListarRegistrosTipoModalidadInterna($arrayInputs)
	{
		$idTrabajador = (Int) fncObtenerValorArray( $arrayInputs, 'idTrabajador', true);
		$idCurso = (Int) fncObtenerValorArray( $arrayInputs, 'idCurso', true);
		$dtReturn = array();
		$modadidad='I';

		if($idCurso==0){
			$dtListado = $this->fncListarRegistrosModalidadInternaBD($idTrabajador);
		}else {
			$dtListado = $this->fncListarRegistrosModalidadInternaBD($idTrabajador,$idCurso);
		}
		
		$clsTipoModalidadController = new TipoModalidadController();
		$clsPersonaNaturalController = new PersonaNaturalController();
		$clsTipoCategoriaController = new TipoCategoriaController();
		$clsTipoActividadEducativa = new TipoActividadEducativaController();
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
		
				$model = array();
				
				$model['id_capacitacion'] 		= $listado->idCapacitacion;
				$model['id_trabajador'] 		= $listado->idTrabajador;
				$model['trabajador'] 			= array_shift($clsPersonaNaturalController->fncListarRegistros($listado->idTrabajador));
				$model['id_tipo_modalidad'] 	= $listado->idTipoModalidad;
				$model['tipo_modalidad'] 	= array_shift($clsTipoModalidadController->fncListarRegistros($listado->idTipoModalidad));
				$model['id_tipo_actividad_educativa'] = $listado->idTipoActividadEducativa;
				$model['tipo_actividad_educativa'] = array_shift($clsTipoActividadEducativa->fncListarRegistros($listado->idTipoActividadEducativa));
				$model['id_tipo_categoria'] 	= $listado->idTipoCategoria;
				$model['tipo_categoria'] 		= array_shift($clsTipoCategoriaController->fncListarRegistros($listado->idTipoCategoria));
				$model['id_curso'] 				= $listado->idCurso;
				$model['tomo'] 					= $listado->tomo;
				$model['folio'] 				= $listado->folio;
				$model['nro_registro'] 			= $listado->nroRegistro;
				$model['organiza'] 				= $listado->organiza;
				$model['curso'] 				= $listado->curso;
				$model['fechaInicio'] 			= $listado->fechaInicio;
				$model['fechaRermino'] 		= $listado->fechaTermino;
				$model['horas'] 				= $listado->horas;
				$model['creditos'] 				= $listado->creditos;
				$model['nota'] 					= $listado->nota;
				$model['archivo'] 				= $listado->archivo;
				$model['activo'] 				= $listado->activo;
				$model['difencia_anios'] 		= number_format((float)$listado->diferencia, 2, '.', '');
				$model['documento_valido'] 		= fncDocumentoValido($model['difencia_anios'],$model['id_tipo_actividad_educativa'],$model['horas']);

		
	
				array_push($dtReturn, $model);
			}
			
	
		}
		return $dtReturn;
	}
	public function fncListarRegistrosTipoModalidadExterna($arrayInputs){
		$idTrabajador = (Int) fncObtenerValorArray( $arrayInputs, 'idTrabajador', true);
		$anio = (Int) fncObtenerValorArray( $arrayInputs, 'anio', true);
		$mes = (Int) fncObtenerValorArray( $arrayInputs, 'mes', true);
		$dtReturn = array();
		
		if($anio==0){
			$dtListado = $this->fncListarRegistrosModalidaExternaBD($idTrabajador);
		}else {
			$dtListado = $this->fncListarRegistrosModalidaExternaBD($idTrabajador,$anio,$mes);
		}
		
		$clsTipoModalidadController = new TipoModalidadController();
		$clsPersonaNaturalController = new PersonaNaturalController();
		$clsTipoCategoriaController = new TipoCategoriaController();
		$clsTipoActividadEducativa = new TipoActividadEducativaController();
		
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
		
				$model = array();
				
				$model['id_capacitacion'] 		= $listado->idCapacitacion;
				$model['id_trabajador'] 		= $listado->idTrabajador;
				$model['trabajador'] 			= array_shift($clsPersonaNaturalController->fncListarRegistros($listado->idTrabajador));
				$model['id_tipo_modalidad'] 	= $listado->idTipoModalidad;
				$model['tipo_modalidad'] 	= array_shift($clsTipoModalidadController->fncListarRegistros($listado->idTipoModalidad));
				$model['id_tipo_actividad_educativa'] = $listado->idTipoActividadEducativa;
				$model['tipo_actividad_educativa'] = array_shift($clsTipoActividadEducativa->fncListarRegistros($listado->idTipoActividadEducativa));
				$model['id_tipo_categoria'] 	= $listado->idTipoCategoria;
				$model['tipo_categoria'] 		= array_shift($clsTipoCategoriaController->fncListarRegistros($listado->idTipoCategoria));
				$model['id_curso'] 				= $listado->idCurso;
				$model['tomo'] 					= $listado->tomo;
				$model['folio'] 				= $listado->folio;
				$model['nro_registro'] 			= $listado->nroRegistro;
				$model['organiza'] 				= $listado->organiza;
				$model['curso'] 				= $listado->curso;
				$model['fecha_inicio'] 			= $listado->fechaInicio;
				$model['fecha_termino'] 		= $listado->fechaTermino;
				$model['horas'] 				= $listado->horas;
				$model['creditos'] 				= $listado->creditos;
				$model['nota'] 					= $listado->nota;
				$model['archivo'] 				= $listado->archivo;
				$model['activo'] 				= $listado->activo;
				$model['difencia_anios'] 		= number_format((float)$listado->diferencia, 2, '.', '');
				$model['documento_valido'] 		= fncDocumentoValido($model['difencia_anios'],$model['id_tipo_actividad_educativa'],$model['horas']);

		
	
				array_push($dtReturn, $model);
			}
			
	
		}
		return $dtReturn;
	}


	public function fncListarRegistrosPorDni($arrayInputs)
	{
		//$dni =fncObtenerValorArray( $arrayInputs, 'dni', true);
		$dtCapacitacion = array();
		$dtRetorno = array();
		$clsTrabajadorController = new TrabajadorController();
		$clsDesplazamientoController = new DesplazamientoController();
		$clsTipoModalidadController = new TipoModalidadController();
		$clsTipoActividadEducativaController = new TipoActividadEducativaController();
		$clsTipoCategoriaController = new TipoCategoriaController();
		$id = 0;
		$dtIdPersona = $clsTrabajadorController->fncBuscarIdPorDni($arrayInputs);
		if( fncGeneralValidarDataArray($dtIdPersona) ){
			$id = (Int)$dtIdPersona[0]["id_trabajador"];
		}
		if (!empty($id)) {
			$dtListado = $this->fncListarRegistrosPorIdTrabajadorBD($id);
			$dtTrabajador = $clsTrabajadorController->fncListarRegistros($id);
			$data['Persona']= $dtTrabajador[0];
			$dtDesplazamiento = $clsDesplazamientoController->fncListarRegistrosActualPorIdTrabajador($id);
			$data['Desplazamiento']= $dtDesplazamiento;
		}
		

		if( fncGeneralValidarDataArray($dtListado) ){
			$fecha_hora = $usuario = '';
			$clsAuditoriaController = new AuditoriaController();
			
			foreach( $dtListado as $listado ){
				$dtAuditoria 	= $clsAuditoriaController->fncBuscarCampoAuditoria('capacitacion','id_capacitacion',$listado->idCapacitacion);
				if(fncGeneralValidarDataArray($dtAuditoria)){
					$Auditoria = array_shift($dtAuditoria);
					$fecha_hora = fncObtenerValorArray($Auditoria, 'fecha_hora', true);
					//	$idUsuario = (Int) fncObtenerValorArray($Auditoria, 'id_usuario', true);
					$usuario = fncObtenerValorArray($Auditoria, 'usuario', true);
				}
				$model = array();
				$model = array();
				
				$model['id_capacitacion'] 		= $listado->idCapacitacion;
				$model['id_trabajador'] 		= $listado->idTrabajador;	
				$model['id_tipo_modalidad'] 	= $listado->idTipoModalidad;			
				$model['tipo_modalidad'] 	= array_shift($clsTipoModalidadController->fncListarRegistros($listado->idTipoModalidad));
				$model['id_tipo_actividad_educativa'] =$listado->idTipoActividadEducativa;
				$model['tipo_actividad_educativa'] =array_shift($clsTipoActividadEducativaController->fncListarRegistros($listado->idTipoActividadEducativa));
				$model['id_tipo_categoria'] 	= array_shift($clsTipoCategoriaController->fncListarRegistros($listado->idTipoCategoria));
				$model['tipo_categoria'] 		= $listado->idTipoCategoria;
				$model['id_curso'] 				= $listado->idCurso;
				$model['tomo'] 					= $listado->tomo;
				$model['folio'] 				= $listado->folio;
				$model['nro_registro'] 			= $listado->nroRegistro;
				$model['organiza'] 				= $listado->organiza;
				$model['curso'] 				= $listado->curso;
				$model['fecha_inicio'] 			= fncValidarFormatearFecha($listado->fechaInicio);
				$model['fecha_termino'] 		= fncValidarFormatearFecha( $listado->fechaTermino);
				$model['horas'] 				= $listado->horas;
				$model['creditos'] 				= $listado->creditos;
				$model['nota'] 					= $listado->nota;
				$model['archivo'] 				= $listado->archivo;
				$model['activo'] 				= $listado->activo;
				$model['difencia_anios'] 		= number_format((float)$listado->diferencia, 2, '.', '');
				$model['documento_valido'] 		= fncDocumentoValido($model['difencia_anios'],$model['id_tipo_actividad_educativa'],$model['horas']);
				$model['auditoriaFecha'] 		= $fecha_hora;
				$model['aduditoriaUsuario'] 	= $usuario;
				

		
	
				array_push($dtCapacitacion, $model);
			}
		
			
		}
		$data['capacitaciones']=$dtCapacitacion;
		$dtRetorno = $data;
		return $dtRetorno;
	}
	public function fncBuscarNombreArchivo($id = -1)
	{

		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosBD($id);

		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
		
				$model = array();
				
				$model['id_capacitacion'] = $listado->idCapacitacion;
				/*$model['id_trabajador'] = $listado->idTrabajador;
				$model['id_tipo_modalidad'] = $listado->idTipoModalidad;
				$model['id_tipo_actividad_educativa'] = $listado->idTipoActividadEducativa;
				$model['id_tipo_categoria'] = $listado->idTipoCategoria;
				$model['id_curso'] = $listado->idCurso;
				$model['tomo'] = $listado->tomo;
				$model['folio'] = $listado->folio;
				$model['nro_registro'] = $listado->nroRegistro;
				$model['organiza'] = $listado->organiza;
				$model['curso'] = $listado->curso;
				$model['fecha_inicio'] = $listado->fechaInicio;
				$model['fecha_termino'] = $listado->fechaTermino;
				$model['horas'] = $listado->horas;
				$model['creditos'] = $listado->creditos;
				$model['nota'] = $listado->nota;*/
				$model['archivo'] = $listado->archivo;
				$model['activo'] = $listado->activo;

		
	
				array_push($dtReturn, $model);
			}
		}
		return $dtReturn;
	}


	public function fncGuardarCapacitacion($arrayInputs,$archivo=""){

		$dtReturn = array();
		$accion ="";
		
		$idCapacitacion 	= (Int) fncObtenerValorArray( $arrayInputs, 'idCapacitacion', true);
		$idTrabajador 		= (Int)fncObtenerValorArray( $arrayInputs, 'idTrabajador', true);
		$idTipoModalidad 	= (Int)fncObtenerValorArray( $arrayInputs, 'idTipoModalidad', true);
		$idTipoActividadEducativa = (Int)fncObtenerValorArray( $arrayInputs, 'idTipoActividadEducativa', true);
		$idTipoCategoria 	= (Int)fncObtenerValorArray( $arrayInputs, 'idTipoCategoria', true);
		$idCurso 			= fncObtenerValorArray( $arrayInputs, 'idCurso', true);
		$tomo				= fncObtenerValorArray( $arrayInputs, 'tomo', true);
		$folio				= fncObtenerValorArray( $arrayInputs, 'folio', true);
		$nroRegistro		= fncObtenerValorArray( $arrayInputs, 'nroRegistro', true);
		$organiza			= fncObtenerValorArray( $arrayInputs, 'organiza', true);
		$curso				= fncObtenerValorArray( $arrayInputs, 'curso', true);
		$fechaInicio		= fncObtenerValorArray( $arrayInputs, 'fechaInicio', true);
		$fechaTermino		= fncObtenerValorArray( $arrayInputs, 'fechaTermino', true);		
		$horas				= fncObtenerValorArray( $arrayInputs, 'horas', true);
		$creditos			= fncObtenerValorArray( $arrayInputs, 'creditos', true);
		$nota				= fncObtenerValorArray( $arrayInputs, 'nota', true);
	
		$dtCapacitacion = new Capacitacion;

		if( !empty($idCapacitacion) )  	{ $dtCapacitacion->setIdCapacitacion($idCapacitacion); }
		if( !empty($idTrabajador) ) 	{ $dtCapacitacion->setIdTrabajador($idTrabajador); }
		if( !empty($idTipoModalidad) ) 			{ $dtCapacitacion->setIdTipoModalidad($idTipoModalidad); }
		if( !empty($idTipoActividadEducativa) ) 	{ $dtCapacitacion->setIdTipoActividadEducativa($idTipoActividadEducativa); }
		if( !empty($idTipoCategoria) ) 	{ $dtCapacitacion->setIdTipoCategoria($idTipoCategoria); }
		if( !empty($idCurso) ) 	{ $dtCapacitacion->setIdCurso($idCurso); }
		if( !empty($tomo) ) 	{ $dtCapacitacion->setTomo($tomo); }
		if( !empty($folio) ) 	{ $dtCapacitacion->setFolio($folio); }
		if( !empty($nroRegistro) ) 	{ $dtCapacitacion->setNroRegistro($nroRegistro); }
		if( !empty($organiza) ) 	{ $dtCapacitacion->setOrganiza($organiza); }
		if( !empty($curso) ) 		{ $dtCapacitacion->setCurso($curso); }
		if( !empty($fechaInicio) ) 	{ $dtCapacitacion->setFechaInicio($fechaInicio); }
		if( !empty($fechaTermino) ) { $dtCapacitacion->setFechaTermino($fechaTermino); }
		if( !empty($horas) ) 	{ $dtCapacitacion->setHoras($horas); }
		if( !empty($creditos) ) 	{ $dtCapacitacion->setCreditos($creditos); }
		if( !empty($nota) ) { $dtCapacitacion->setNota($nota); }
		
		$accion='';
		$dtDocumento=array();
		$dtGuardar=array();
		if (fncGeneralValidarDataArray($dtCapacitacion)) {

			if ($idCapacitacion == 0) {
				if (!empty($archivo)) {
					$dtDocumento = $this->fncGuardarDocumentoCapacitacion($archivo);
					$dtCapacitacion->setArchivo($dtDocumento[0]['Nombre']);
				}
				$dtCapacitacion->setActivo(1);
				$accion = 1;
				$dtGuardar = $this->fncRegistrarBD($dtCapacitacion);
			} else {
				if ($archivo['error'] == 0) {
					$dtDocumento = $this->fncGuardarDocumentoCapacitacion($archivo);
					$dtCapacitacion->setArchivo($dtDocumento[0]['Nombre']);
				} else {
					$archivoBD = $this->fncBuscarNombreArchivo($idCapacitacion);
					$dtCapacitacion->setArchivo($archivoBD[0]['archivo']);
				}
				$accion = 2;
				$dtGuardar = $this->fncActualizarBD($dtCapacitacion);
			}
		}


		if (fncGeneralValidarDataArray($dtGuardar)) {

			$dtCapacitacion->setIdCapacitacion($dtGuardar->getIdCapacitacion());
			if (fncGeneralValidarDataArray($dtDocumento)) {
				$dtCapacitacion->setArchivo($dtDocumento[0]);
			}

			//$auditorioController = new AuditoriaController();

			//$auditoria = $auditorioController->fncGuardar('familiar',$dtGuardar->getIdFamiliar(),$dtGuardar,$accion);
			$auditorioController = new AuditoriaController();
			$auditoria = $auditorioController->fncGuardar($accion, 'capacitacion', 'id_capacitacion', $dtCapacitacion->getIdCapacitacion(), json_encode($dtCapacitacion));

			if (fncGeneralValidarDataArray($dtDocumento)) {
				$dtCapacitacion->setArchivo($dtDocumento[0]["Nombre"]);
			}
			$returnCapacitacion['capacitacion'] = ($dtCapacitacion);
			$dtGuardar = $returnCapacitacion;

			$dtGuardar=($this->fncObtenerCapacitacion($dtCapacitacion->getIdCapacitacion()));
		}

		  return $dtGuardar;

	}

	public function fncGuardarDocumentoCapacitacion($archivoInput = '')
	{
		$optArchivo = "";
		$dtReturn = array();
		if (!empty($archivoInput)) {
			if ($archivoInput["name"] <> "") {
				$optRutaArchivo = cls_rutas::get('capacitacionPdf');
				//$rutas=fncObtenerRuta();
				$nombreArchivo = fncConstruirNombreCapacitacion($archivoInput);
				$obj_arc = new archivo($archivoInput, $optRutaArchivo, "pdf_" . $nombreArchivo, 0);
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


	public function fncEliminarRegistro($id = 0)
	{

		$bolReturn = true;
		if ($id > 0) {
			$bolValidarEliminar = $this->fncEliminarBD($id);
			if ($bolValidarEliminar) {
				$bolReturn = $bolValidarEliminar;
				$auditorioController = new AuditoriaController();
				$auditoria = $auditorioController->fncGuardar(2, 'capacitacion', 'id_capacitacion', $id);
			}
		}else {
			return false;
		}
		return $bolReturn;
	}

	//=======================================================================================
	//FUNCIONES BASE DE DATOS
	//=======================================================================================

	private function fncEliminarBD( $id )
	{
    $bolReturn = false;
		$sql = cls_control::get_instancia();
		$consulta = '
		UPDATE escalafon.capacitacion
		SET		
			activo = 0
		WHERE id_capacitacion = :id_capacitacion';
		$statement = $sql->preparar( $consulta );
		if( $statement!=false ){
			$statement->bindParam('id_capacitacion', $id);
			$sql->ejecutar();
			$datos = $statement->fetchAll(PDO::FETCH_OBJ); 
			if($datos){
				$bolReturn = true;
     		 }
     	 $sql->cerrar();
   		 }
    return $bolReturn;
	}

	private function fncListarRegistrosBD( $id = -1 )
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			c.id_capacitacion,
			c.id_trabajador,
			c.id_tipo_modalidad,
			c.id_tipo_actividad_educativa,
			c.id_tipo_categoria,
			c.id_curso,
			c.tomo,
			c.folio,
			c.nro_registro,
			c.organiza,
			c.curso,
			c.fecha_inicio,
			c.fecha_termino,
			c.horas,
			c.creditos,
			c.nota,
			c.archivo,
			((DATE_PART(\'year\', now()) - DATE_PART(\'year\', c.fecha_termino)) * 12 +
			(DATE_PART(\'month\', now()) - DATE_PART(\'month\', c.fecha_termino)))/12 AS diferencia_anios,
			c.activo
		FROM
			escalafon.capacitacion AS c
		WHERE (:id_capacitacion = -1 OR id_capacitacion = :id_capacitacion)
		ORDER BY c.fecha_termino DESC
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_capacitacion', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new Capacitacion;
			$temp->idCapacitacion 	        = $datos['id_capacitacion'];
			$temp->idTrabajador 	        = $datos['id_trabajador'];
			$temp->idTipoModalidad 	        = $datos['id_tipo_modalidad'];
			$temp->idTipoActividadEducativa = $datos['id_tipo_actividad_educativa'];
			$temp->idTipoCategoria 	        = $datos['id_tipo_categoria'];
			$temp->idCurso 	        		= $datos['id_curso'];
			$temp->tomo 	        		= $datos['tomo'];
			$temp->folio 	        		= $datos['folio'];
			$temp->nroRegistro 	        	= $datos['nro_registro'];
			$temp->organiza 	        	= $datos['organiza'];
			$temp->curso 	        		= $datos['curso'];
			$temp->fechaInicio 	        	= $datos['fecha_inicio'];
			$temp->fechaTermino 	        = $datos['fecha_termino'];
			$temp->horas 	        		= $datos['horas'];
			$temp->creditos 	        	= $datos['creditos'];
			$temp->nota 	        		= $datos['nota'];
			$temp->archivo 	        		= $datos['archivo'];
			$temp->activo 	        		= $datos['activo'];
			$temp->diferencia 	        	= $datos['diferencia_anios'];

			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}


	private function fncListarCapacitacionIdTrabajadorIdModalidadBD( $id = -1,$id_det=-1 )
	{
		$sql = cls_control::get_instancia();
		$queryTipoModalidad='';
		if ($id_det!=0) {
			$queryTipoModalidad = "AND c.id_tipo_modalidad = :id_tipo_modalidad";
		}

		$query = '
		SELECT
			c.id_capacitacion,
			c.id_trabajador,
			c.id_tipo_modalidad,
			c.id_tipo_actividad_educativa,
			c.id_tipo_categoria,
			coalesce(c.id_curso,0)as id_curso,
			coalesce(c.tomo,\'\') AS tomo,
			coalesce(c.folio,\'\') AS folio,
			coalesce(c.nro_registro,\'\') AS nro_registro,
			c.organiza,
			coalesce(c.curso,\'\'),
			c.fecha_inicio,
			c.fecha_termino,
			c.horas,
			c.creditos,
			c.nota,
			c.curso,
			coalesce(c.archivo,\'\') AS archivo,
			c.activo,
			(SELECT	a.fecha_hora AS fecha_hora_auditoria FROM escalafon.auditoria  AS a WHERE ( a.id_operacion = 1 OR a.id_operacion = 2 )
							AND a.tabla = \'capacitacion\' AND a.objeto_id_nombre = \'id_capacitacion\' AND a.objeto_id_valor = c.id_capacitacion
							ORDER BY a.id_auditoria DESC LIMIT 1 ),
						(SELECT
									pn.nombre_completo  AS usuario_auditoria
								FROM adm.usuario u
								LEFT JOIN public.persona_natural pn ON pn.id_persona = u.id_persona
								WHERE u.id_usuario = (SELECT	aa.id_usuario	FROM escalafon.auditoria  AS aa WHERE ( aa.id_operacion = 1 OR aa.id_operacion = 2 )
								AND aa.tabla = \'capacitacion\' AND aa.objeto_id_nombre = \'id_capacitacion\' AND aa.objeto_id_valor = c.id_capacitacion
								ORDER BY aa.id_auditoria DESC LIMIT 1))
				
		FROM
			escalafon.capacitacion AS c
		WHERE c.activo = 1 AND c.id_trabajador = :id_trabajador '.$queryTipoModalidad;

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_trabajador', $id);
			if ($id_det != 0) {
				$statement->bindParam('id_tipo_modalidad', $id_det);
			}
			

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new Capacitacion;
			$temp->idCapacitacion 	        = $datos['id_capacitacion'];
			$temp->idTrabajador 	        = $datos['id_trabajador'];
			$temp->idTipoModalidad 	        = $datos['id_tipo_modalidad'];
			$temp->idTipoActividadEducativa = $datos['id_tipo_actividad_educativa'];
			$temp->idTipoCategoria 	        = $datos['id_tipo_categoria'];
			$temp->idCurso 	        		= $datos['id_curso'];
			$temp->curso 	        		= $datos['curso'];
			$temp->tomo 	        		= $datos['tomo'];
			$temp->folio 	        		= $datos['folio'];
			$temp->nroRegistro 	        	= $datos['nro_registro'];
			$temp->organiza 	        	= $datos['organiza'];
			$temp->fechaInicio 	        	= $datos['fecha_inicio'];
			$temp->fechaTermino 	        = $datos['fecha_termino'];
			$temp->horas 	        		= $datos['horas'];
			$temp->creditos 	        	= $datos['creditos'];
			$temp->nota 	        		= $datos['nota'];
			$temp->archivo 	        		= $datos['archivo'];
			$temp->activo 	        		= $datos['activo'];
			
		
			$temp->fechaHoraAuditoria 	    = $datos['fecha_hora_auditoria'];
			$temp->usuarioAuditoria 	    = $datos['usuario_auditoria'];


			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}



	private function fncListarRegistrosExcelModalidadExternaBD( $id = -1,$idTipoModalidadCapacitacion )
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			c.id_capacitacion,
			c.id_trabajador,
			(SELECT	p.documento_identidad FROM	"public".persona AS p WHERE p.id_persona = c.id_trabajador ),
			(SELECT pn.nombres FROM 	"public".persona_natural AS pn WHERE pn.id_persona = c.id_trabajador),
			(SELECT pn.apellidos FROM 	"public".persona_natural AS pn WHERE pn.id_persona = c.id_trabajador),
			COALESCE( (SELECT
	
				ne.titulo_obtenido

			FROM
				escalafon.nivel_educativo AS ne	WHERE ne.id_trabajador = c.id_trabajador AND ne.eliminado = 0
			ORDER BY ne.fecha ASC LIMIT 1),\'Sin nivel educativo registrado\') AS profesion,
			c.id_tipo_modalidad,
			c.id_tipo_actividad_educativa,
			c.id_tipo_categoria,

			COALESCE(  
				CASE 
					   WHEN 
						 (SELECT COUNT(*) FROM escalafon.desplazamiento AS d
						  INNER JOIN escalafon.area AS a ON a.id_area = d.id_area
						 WHERE d.eliminado=0 AND d.id_trabajador = c.id_trabajador AND d.id_tipo_accion = 9 LIMIT 1) >0
					   THEN 
						   (SELECT a.nombre_area FROM escalafon.desplazamiento AS d
						  INNER JOIN escalafon.area AS a ON a.id_area = d.id_area
						   WHERE d.eliminado=0 AND d.id_trabajador = c.id_trabajador AND d.id_tipo_accion = 9 LIMIT 1)
					   
					   ELSE (SELECT a.nombre_area FROM escalafon.desplazamiento AS d
							INNER JOIN escalafon.area AS a ON a.id_area = d.id_area
							 WHERE d.actual=1 AND d.eliminado=0 AND d.id_trabajador = c.id_trabajador AND d.id_tipo_accion NOT IN(9) LIMIT 1)
				 
			   END,NULL,\'Sin area asignada\')AS nombre_are,

			  COALESCE((SELECT ue.unidad_ejecutora FROM escalafon.trabajador AS t
			INNER JOIN escalafon.unidad_ejecutora AS ue ON ue.id_unidad_ejecutora = t.id_unidad_ejecutora
			 WHERE t.id_trabajador = c.id_trabajador  LIMIT 1 ),NULL,\'Sin Asignar\') AS centro_trabajo,
			c.id_curso,
			c.tomo,
			c.folio,
			c.nro_registro,
			c.organiza,
			c.curso,
			c.fecha_inicio,
			c.fecha_termino,
			c.horas,
			c.creditos,
			c.nota,
			c.archivo,
			((DATE_PART(\'year\', now()) - DATE_PART(\'year\', c.fecha_termino)) * 12 +
			(DATE_PART(\'month\', now()) - DATE_PART(\'month\', c.fecha_termino)))/12 AS diferencia_anios,
			c.activo,
			(SELECT	a.fecha_hora AS fecha_hora_auditoria FROM escalafon.auditoria  AS a WHERE ( a.id_operacion = 1 OR a.id_operacion = 2 )
					AND a.tabla = \'capacitacion\' AND a.objeto_id_nombre = \'id_capacitacion\' AND a.objeto_id_valor = c.id_capacitacion
					ORDER BY a.id_auditoria DESC LIMIT 1 ),
				(SELECT
							pn.nombre_completo  AS usuario_auditoria
						FROM adm.usuario u
						LEFT JOIN public.persona_natural pn ON pn.id_persona = u.id_persona
						WHERE u.id_usuario = (SELECT	aa.id_usuario	FROM escalafon.auditoria  AS aa WHERE ( aa.id_operacion = 1 OR aa.id_operacion = 2 )
						AND aa.tabla = \'capacitacion\' AND aa.objeto_id_nombre = \'id_capacitacion\' AND aa.objeto_id_valor = c.id_capacitacion
						ORDER BY aa.id_auditoria DESC LIMIT 1))
		FROM
			escalafon.capacitacion AS c
		WHERE (id_trabajador = :id_trabajador OR -1 = :id_trabajador ) AND  c.id_tipo_modalidad = :id_tipo_modalidad AND c.activo = 1 
		ORDER BY c.id_trabajador , c.fecha_termino DESC
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_trabajador', $id);
			$statement->bindParam('id_tipo_modalidad', $idTipoModalidadCapacitacion);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new Capacitacion;
			$temp->idCapacitacion 	        = $datos['id_capacitacion'];
			$temp->documentoIdentidad 	    = $datos['documento_identidad'];
			$temp->nombres 	        		= $datos['nombres'];
			$temp->nombreArea 	        	= $datos['nombre_are'];
			$temp->centroTrabajo 	        = $datos['centro_trabajo']; // no definido  observar
			
			$temp->apellidos 	        	= $datos['apellidos'];
			$temp->profesion 	       		= $datos['profesion'];
			$temp->idTrabajador 	        = $datos['id_trabajador'];
			$temp->idTipoModalidad 	        = $datos['id_tipo_modalidad'];
			$temp->idTipoActividadEducativa = $datos['id_tipo_actividad_educativa'];
			$temp->idTipoCategoria 	        = $datos['id_tipo_categoria'];
			$temp->idCurso 	        		= $datos['id_curso'];
			$temp->tomo 	        		= $datos['tomo'];
			$temp->folio 	        		= $datos['folio'];
			$temp->nroRegistro 	        	= $datos['nro_registro'];
			$temp->organiza 	        	= $datos['organiza'];
			$temp->curso 	        		= $datos['curso'];
			$temp->fechaInicio 	        	= $datos['fecha_inicio'];
			$temp->fechaTermino 	        = $datos['fecha_termino'];
			$temp->horas 	        		= $datos['horas'];
			$temp->creditos 	        	= $datos['creditos'];
			$temp->nota 	        		= $datos['nota'];
			$temp->archivo 	        		= $datos['archivo'];
			$temp->activo 	        		= $datos['activo'];
			$temp->diferencia 	        	= $datos['diferencia_anios'];
			$temp->fechaHoraAuditoria      	= $datos['fecha_hora_auditoria'];
			$temp->usuarioAuditoria      	= $datos['usuario_auditoria'];
			

			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}


	private function fncListarRegistrosExcelModalidadExcelBD( $id = -1,$idTipoModalidadCapacitacion )
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			c.id_capacitacion,
			c.id_trabajador,
			(SELECT	p.documento_identidad FROM	"public".persona AS p WHERE p.id_persona = c.id_trabajador ),
			(SELECT pn.nombres FROM 	"public".persona_natural AS pn WHERE pn.id_persona = c.id_trabajador),
			(SELECT pn.apellidos FROM 	"public".persona_natural AS pn WHERE pn.id_persona = c.id_trabajador),
			COALESCE( (SELECT
	
				ne.titulo_obtenido

			FROM
				escalafon.nivel_educativo AS ne	WHERE ne.id_trabajador = c.id_trabajador AND ne.eliminado = 0
			ORDER BY ne.fecha ASC LIMIT 1),\'Sin nivel educativo registrado\') AS profesion,
			c.id_tipo_modalidad,
			c.id_tipo_actividad_educativa,
			c.id_tipo_categoria,

			COALESCE(  
				CASE 
					   WHEN 
						 (SELECT COUNT(*) FROM escalafon.desplazamiento AS d
						  INNER JOIN escalafon.area AS a ON a.id_area = d.id_area
						 WHERE d.eliminado=0 AND d.id_trabajador = c.id_trabajador AND d.id_tipo_accion = 9 LIMIT 1) >0
					   THEN 
						   (SELECT a.nombre_area FROM escalafon.desplazamiento AS d
						  INNER JOIN escalafon.area AS a ON a.id_area = d.id_area
						   WHERE d.eliminado=0 AND d.id_trabajador = c.id_trabajador AND d.id_tipo_accion = 9 LIMIT 1)
					   
					   ELSE (SELECT a.nombre_area FROM escalafon.desplazamiento AS d
							INNER JOIN escalafon.area AS a ON a.id_area = d.id_area
							 WHERE d.actual=1 AND d.eliminado=0 AND d.id_trabajador = c.id_trabajador AND d.id_tipo_accion NOT IN(9) LIMIT 1)
				 
			   END,NULL,\'Sin area asignada\')AS nombre_are,

			  COALESCE((SELECT ue.unidad_ejecutora FROM escalafon.trabajador AS t
			INNER JOIN escalafon.unidad_ejecutora AS ue ON ue.id_unidad_ejecutora = t.id_unidad_ejecutora
			 WHERE t.id_trabajador = c.id_trabajador  LIMIT 1 ),NULL,\'Sin Asignar\') AS centro_trabajo,
			c.id_curso,
			c.tomo,
			c.folio,
			c.nro_registro,
			c.organiza,
			c.curso,
			c.fecha_inicio,
			c.fecha_termino,
			c.horas,
			c.creditos,
			c.nota,
			c.archivo,
			((DATE_PART(\'year\', now()) - DATE_PART(\'year\', c.fecha_termino)) * 12 +
			(DATE_PART(\'month\', now()) - DATE_PART(\'month\', c.fecha_termino)))/12 AS diferencia_anios,
			c.activo,
			(SELECT	a.fecha_hora AS fecha_hora_auditoria_insert FROM escalafon.auditoria  AS a WHERE ( a.id_operacion = 1)
					AND a.tabla = \'capacitacion\' AND a.objeto_id_nombre = \'id_capacitacion\' AND a.objeto_id_valor = c.id_capacitacion
					ORDER BY a.id_auditoria DESC LIMIT 1 ),
			(SELECT	a.fecha_hora AS fecha_hora_auditoria FROM escalafon.auditoria  AS a WHERE ( a.id_operacion = 2 )
					AND a.tabla = \'capacitacion\' AND a.objeto_id_nombre = \'id_capacitacion\' AND a.objeto_id_valor = c.id_capacitacion
					ORDER BY a.id_auditoria DESC LIMIT 1 ),
			(SELECT
						pn.nombre_completo  AS usuario_auditoria_insert
						FROM adm.usuario u
						LEFT JOIN public.persona_natural pn ON pn.id_persona = u.id_persona
						WHERE u.id_usuario = (SELECT	aa.id_usuario	FROM escalafon.auditoria  AS aa WHERE ( aa.id_operacion = 1 OR aa.id_operacion = 2 )
						AND aa.tabla = \'capacitacion\' AND aa.objeto_id_nombre = \'id_capacitacion\' AND aa.objeto_id_valor = c.id_capacitacion
						ORDER BY aa.id_auditoria DESC LIMIT 1))
		FROM
			escalafon.capacitacion AS c
		WHERE (id_trabajador = :id_trabajador OR :id_trabajador = -1) AND  c.id_tipo_modalidad = :id_tipo_modalidad AND c.activo = 1 
		ORDER BY c.id_trabajador , c.fecha_termino DESC
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_trabajador', $id);
			$statement->bindParam('id_tipo_modalidad', $idTipoModalidadCapacitacion);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new Capacitacion;
			$temp->idCapacitacion 	        = $datos['id_capacitacion'];
			$temp->documentoIdentidad 	    = $datos['documento_identidad'];
			$temp->nombres 	        		= $datos['nombres'];
			$temp->nombreArea 	        	= $datos['nombre_are'];
			$temp->centroTrabajo 	        = $datos['centro_trabajo']; // no definido  observar
			
			$temp->apellidos 	        	= $datos['apellidos'];
			$temp->profesion 	       		= $datos['profesion'];
			$temp->idTrabajador 	        = $datos['id_trabajador'];
			$temp->idTipoModalidad 	        = $datos['id_tipo_modalidad'];
			$temp->idTipoActividadEducativa = $datos['id_tipo_actividad_educativa'];
			$temp->idTipoCategoria 	        = $datos['id_tipo_categoria'];
			$temp->idCurso 	        		= $datos['id_curso'];
			$temp->tomo 	        		= $datos['tomo'];
			$temp->folio 	        		= $datos['folio'];
			$temp->nroRegistro 	        	= $datos['nro_registro'];
			$temp->organiza 	        	= $datos['organiza'];
			$temp->curso 	        		= $datos['curso'];
			$temp->fechaInicio 	        	= $datos['fecha_inicio'];
			$temp->fechaTermino 	        = $datos['fecha_termino'];
			$temp->horas 	        		= $datos['horas'];
			$temp->creditos 	        	= $datos['creditos'];
			$temp->nota 	        		= $datos['nota'];
			$temp->archivo 	        		= $datos['archivo'];
			$temp->activo 	        		= $datos['activo'];
			$temp->diferencia 	        	= $datos['diferencia_anios'];
			$temp->fechaHoraAuditoriaInsert = $datos['fecha_hora_auditoria_insert'];
			$temp->fechaHoraAuditoria      	= $datos['fecha_hora_auditoria'];
			$temp->usuarioAuditoria      	= $datos['usuario_auditoria'];
			$temp->usuarioAuditoriaInsert     	= $datos['usuario_auditoria_insert'];
			

			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}


	private function fncListarRegistrosModalidaExternaBD( $id=-1,$anio=-1,$mes=-1 )
	{
		$sql = cls_control::get_instancia();
	
		$query = '
		SELECT
			c.id_capacitacion,
			c.id_trabajador,
			c.id_tipo_modalidad,
			c.id_tipo_actividad_educativa,
			c.id_tipo_categoria,
			c.id_curso,
			c.tomo,
			c.folio,
			c.nro_registro,
			c.organiza,
			c.curso,
			c.fecha_inicio,
			c.fecha_termino,
			c.horas,
			c.creditos,
			c.nota,
			c.archivo,
			((DATE_PART(\'year\', now()) - DATE_PART(\'year\', c.fecha_termino)) * 12 +
			(DATE_PART(\'month\', now()) - DATE_PART(\'month\', c.fecha_termino)))/12 AS diferencia_anios,
			c.activo
		FROM
			escalafon.capacitacion AS c
		WHERE
			  (:id_trabajador = -1 OR id_trabajador = :id_trabajador ) AND
			  ((:anio = -1 OR EXTRACT(YEAR FROM  c.fecha_inicio)= :anio ) AND ( :mes = -1 OR EXTRACT(MONTH FROM  c.fecha_inicio) = :mes )) 

		AND c.id_tipo_modalidad = 2
		
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_trabajador', $id);
			$statement->bindParam('anio', $anio);
			$statement->bindParam('mes', $mes);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new Capacitacion;
			$temp->idCapacitacion 	        = $datos['id_capacitacion'];
			$temp->idTrabajador 	        = $datos['id_trabajador'];
			$temp->idTipoModalidad 	        = $datos['id_tipo_modalidad'];
			$temp->idTipoActividadEducativa = $datos['id_tipo_actividad_educativa'];
			$temp->idTipoCategoria 	        = $datos['id_tipo_categoria'];
			$temp->idCurso 	        		= $datos['id_curso'];
			$temp->tomo 	        		= $datos['tomo'];
			$temp->folio 	        		= $datos['folio'];
			$temp->nroRegistro 	        	= $datos['nro_registro'];
			$temp->organiza 	        	= $datos['organiza'];
			$temp->curso 	        		= $datos['curso'];
			$temp->fechaInicio 	        	= $datos['fecha_inicio'];
			$temp->fechaTermino 	        = $datos['fecha_termino'];
			$temp->horas 	        		= $datos['horas'];
			$temp->creditos 	        	= $datos['creditos'];
			$temp->nota 	        		= $datos['nota'];
			$temp->archivo 	        		= $datos['archivo'];
			$temp->activo 	        		= $datos['activo'];
			$temp->diferencia 	        	= $datos['diferencia_anios'];

			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}

	private function fncListarRegistrosModalidadInternaBD( $id=-1,$idCurso=-1 )
	{
		$sql = cls_control::get_instancia();
	
		$query = '
		SELECT
			c.id_capacitacion,
			c.id_trabajador,
			c.id_tipo_modalidad,
			c.id_tipo_actividad_educativa,
			c.id_tipo_categoria,
			c.id_curso,
			c.tomo,
			c.folio,
			c.nro_registro,
			c.organiza,
			c.curso,
			c.fecha_inicio,
			c.fecha_termino,
			c.horas,
			c.creditos,
			c.nota,
			c.archivo,
			((DATE_PART(\'year\', now()) - DATE_PART(\'year\', c.fecha_termino)) * 12 +
			(DATE_PART(\'month\', now()) - DATE_PART(\'month\', c.fecha_termino)))/12 AS diferencia_anios,
			c.activo
		FROM
			escalafon.capacitacion AS c
		WHERE (:id_trabajador = -1 OR id_trabajador = :id_trabajador) 
			AND (:id_curso = -1 OR id_curso = :id_curso) AND c.id_tipo_modalidad = 1
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_trabajador', $id);
			$statement->bindParam('id_curso', $idCurso);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new Capacitacion;
			$temp->idCapacitacion 	        = $datos['id_capacitacion'];
			$temp->idTrabajador 	        = $datos['id_trabajador'];
			$temp->idTipoModalidad 	        = $datos['id_tipo_modalidad'];
			$temp->idTipoActividadEducativa = $datos['id_tipo_actividad_educativa'];
			$temp->idTipoCategoria 	        = $datos['id_tipo_categoria'];
			$temp->idCurso 	        		= $datos['id_curso'];
			$temp->tomo 	        		= $datos['tomo'];
			$temp->folio 	        		= $datos['folio'];
			$temp->nroRegistro 	        	= $datos['nro_registro'];
			$temp->organiza 	        	= $datos['organiza'];
			$temp->curso 	        		= $datos['curso'];
			$temp->fechaInicio 	        	= $datos['fecha_inicio'];
			$temp->fechaTermino 	        = $datos['fecha_termino'];
			$temp->horas 	        		= $datos['horas'];
			$temp->creditos 	        	= $datos['creditos'];
			$temp->nota 	        		= $datos['nota'];
			$temp->archivo 	        		= $datos['archivo'];
			$temp->activo 	        		= $datos['activo'];
			$temp->diferencia 	        	= $datos['diferencia_anios'];

			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}

	private function fncListarRegistrosTipoModalidadBD( $id = -1 )
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			c.id_capacitacion,
			c.id_trabajador,
			c.id_tipo_modalidad,
			c.id_tipo_actividad_educativa,
			c.id_tipo_categoria,
			c.id_curso,
			c.tomo,
			c.folio,
			c.nro_registro,
			c.organiza,
			c.curso,
			c.fecha_inicio,
			c.fecha_termino,
			c.horas,
			c.creditos,
			c.nota,
			c.archivo,
			c.activo
		FROM
			escalafon.capacitacion AS c
		WHERE (:id_capacitacion = -1 OR id_capacitacion = :id_capacitacion)
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_capacitacion', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new Capacitacion;
			$temp->idCapacitacion 	        = $datos['id_capacitacion'];
			$temp->idTrabajador 	        = $datos['id_trabajador'];
			$temp->idTipoModalidad 	        = $datos['id_tipo_modalidad'];
			$temp->idTipoActividadEducativa = $datos['id_tipo_actividad_educativa'];
			$temp->idTipoCategoria 	        = $datos['id_tipo_categoria'];
			$temp->idCurso 	        		= $datos['id_curso'];
			$temp->tomo 	        		= $datos['tomo'];
			$temp->folio 	        		= $datos['folio'];
			$temp->nroRegistro 	        	= $datos['nro_registro'];
			$temp->organiza 	        	= $datos['organiza'];
			$temp->curso 	        		= $datos['curso'];
			$temp->fechaInicio 	        	= $datos['fecha_inicio'];
			$temp->fechaTermino 	        = $datos['fecha_termino'];
			$temp->horas 	        		= $datos['horas'];
			$temp->creditos 	        	= $datos['creditos'];
			$temp->nota 	        		= $datos['nota'];
			$temp->archivo 	        		= $datos['archivo'];
			$temp->activo 	        		= $datos['activo'];

			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}

	private function fncListarRegistrosPorIdTrabajadorBD( $id)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
		c.id_capacitacion,
		c.id_trabajador,
		c.id_tipo_modalidad,
		c.id_tipo_actividad_educativa,
		c.id_tipo_categoria,
		c.id_curso,
		c.tomo,
		c.folio,
		c.nro_registro,
		c.organiza,
		c.curso,
		c.fecha_inicio,
		c.fecha_termino,
	
		c.horas,
		c.creditos,
		c.nota,
		c.archivo,
		((DATE_PART(\'year\', now()) - DATE_PART(\'year\', c.fecha_termino)) * 12 +
		(DATE_PART(\'month\', now()) - DATE_PART(\'month\', c.fecha_termino)))/12 AS diferencia_anios,
		c.activo
		FROM
			escalafon.capacitacion AS c
		WHERE (:id_trabajador = -1 OR id_trabajador = :id_trabajador)
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_trabajador', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new Capacitacion;
			$temp->idCapacitacion 	        	= $datos['id_capacitacion'];
			$temp->idTrabajador 	        	= $datos['id_trabajador'];
			$temp->idTipoModalidad 	        	= $datos['id_tipo_modalidad'];
			$temp->idTipoActividadEducativa 	= $datos['id_tipo_actividad_educativa'];
			$temp->idTipoCategoria 	        	= $datos['id_tipo_categoria'];
			$temp->idCurso 	        			= $datos['id_curso'];
			$temp->tomo 	        			= $datos['tomo'];
			$temp->folio 	        			= $datos['folio'];
			$temp->nroRegistro 	        		= $datos['nro_registro'];
			$temp->organiza 	        		= $datos['organiza'];
			$temp->curso 	        			= $datos['curso'];
			$temp->fechaInicio 	        		= $datos['fecha_inicio'];
			$temp->fechaTermino 	        	= $datos['fecha_termino'];
			$temp->horas 	        			= $datos['horas'];
			$temp->creditos 	        		= $datos['creditos'];
			$temp->nota 	        			= $datos['nota'];
			$temp->archivo 	        			= $datos['archivo'];
			$temp->activo 	        			= $datos['activo'];

			$temp->diferencia 	        		= $datos['diferencia_anios'];

			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}

	public function fncRegistrarBD($dtModel)
	{

			$id_capacitacion	= $dtModel->getIdCapacitacion();
			$id_trabajador		= $dtModel->getIdTrabajador();
			$id_tipo_modalidad	= $dtModel->getIdTipoModalidad();
			$id_tipo_actividad_educativa 	= $dtModel->getIdTipoActividadEducativa();
			$id_tipo_categoria 	= $dtModel->getIdTipoCategoria();
			$id_curso 			= $dtModel->getIdCurso();
			$tomo 				= $dtModel->getTomo();
			$folio 				= $dtModel->getFolio();			
			$nro_registro 		= $dtModel->getNroRegistro();
			$organiza 			= $dtModel->getOrganiza();
			$curso 				= $dtModel->getCurso();
			$fecha_inicio 		= $dtModel->getFechaInicio();
			$fecha_termino 		= $dtModel->getFechaTermino();
			$horas 				= $dtModel->getHoras();
			$creditos 			= $dtModel->getCreditos();
			$nota 				= $dtModel->getNota();
			$archivo 			= $dtModel->getArchivo();

  
	  $sql = cls_control::get_instancia();
	  $consulta = "
	  INSERT INTO escalafon.capacitacion
	  (
		  -- id_capacitacion -- this column value is auto-generated
		  id_trabajador,
		  id_tipo_modalidad,
		  id_tipo_actividad_educativa,
		  id_tipo_categoria,
		  id_curso,
		  tomo,
		  folio,
		  nro_registro,
		  organiza,
		  curso,
		  fecha_inicio,
		  fecha_termino,
		  horas,
		  creditos,
		  nota,
		  archivo,
		  activo
	  )
	  VALUES
	  (
		  :id_trabajador,
		  :id_tipo_modalidad,
		  :id_tipo_actividad_educativa,
		  :id_tipo_categoria,
		  :id_curso,
		  :tomo,
		  :folio,
		  :nro_registro,
		  :organiza,
		  :curso,
		  :fecha_inicio,
		  :fecha_termino,
		  :horas,
		  :creditos,
		  :nota,
		  :archivo,
		  1
	  )	 RETURNING id_capacitacion";
	  $statement=$sql->preparar($consulta);
	  if($statement!=false){
		$statement->bindParam("id_trabajador", $id_trabajador);
		$statement->bindParam("id_tipo_modalidad", $id_tipo_modalidad); 
		$statement->bindParam("id_tipo_actividad_educativa", $id_tipo_actividad_educativa); 
		$statement->bindParam("id_tipo_categoria", $id_tipo_categoria); 
		$statement->bindParam("id_curso", $id_curso);
		$statement->bindParam("folio", $folio); 
		$statement->bindParam("tomo", $tomo); 
		$statement->bindParam("nro_registro", $nro_registro); 
		$statement->bindParam("organiza", $organiza); 
		$statement->bindParam("curso", $curso); 
		$statement->bindParam("fecha_inicio", $fecha_inicio); 
		$statement->bindParam("fecha_termino", $fecha_termino); 
		$statement->bindParam("horas", $horas); 
		$statement->bindParam("creditos", $creditos); 
		$statement->bindParam("nota", $nota); 
		$statement->bindParam("archivo", $archivo); 
	
		$sql->ejecutar();
		$datos = $statement->fetch(PDO::FETCH_ASSOC);
		if($datos){
		//_Retorno de Datos
		  $dtModel->setIdCapacitacion($datos["id_capacitacion"]);
		
		//_Cerrar
		  $sql->cerrar();
		  return $dtModel; 
		}else{
		  $sql->cerrar();
		  return false;
		}
	  }else{
		return false;
	  }
	}

	private function fncActualizarBD($dtModel)
	{
			$id_capacitacion	= $dtModel->getIdCapacitacion();
			$id_trabajador		= $dtModel->getIdTrabajador();
			$id_tipo_modalidad	= $dtModel->getIdTipoModalidad();
			$id_tipo_actividad_educativa 	= $dtModel->getIdTipoActividadEducativa();
			$id_tipo_categoria 	= $dtModel->getIdTipoCategoria();
			$id_curso 			= $dtModel->getIdCurso();
			$tomo 				= $dtModel->getTomo();
			$folio 				= $dtModel->getFolio();			
			$nro_registro 		= $dtModel->getNroRegistro();
			$organiza 			= $dtModel->getOrganiza();
			$curso 				= $dtModel->getCurso();
			$fecha_inicio 		= $dtModel->getFechaInicio();
			$fecha_termino 		= $dtModel->getFechaTermino();
			$horas 				= $dtModel->getHoras();
			$creditos 			= $dtModel->getCreditos();
			$nota 				= $dtModel->getNota();
			$archivo 			= $dtModel->getArchivo();
		$qrActualizarArchivo = '';	
			if ($archivo!="") {
				$qrActualizarArchivo=', archivo = :archivo';
			}

		$sql = cls_control::get_instancia();
		$query = '
		UPDATE escalafon.capacitacion
		SET
			-- id_capacitacion -- this column value is auto-generated
			id_trabajador 		= :id_trabajador,
			id_tipo_modalidad 	= :id_tipo_modalidad,
			id_tipo_actividad_educativa = :id_tipo_actividad_educativa,
			id_tipo_categoria 	= :id_tipo_categoria,
			id_curso 			= :id_curso,
			tomo 				= :tomo,
			folio 				= :folio,
			nro_registro 		= :nro_registro,
			organiza 			= :organiza,
			curso 				= :curso,
			fecha_inicio 		= :fecha_inicio,
			fecha_termino 		= :fecha_termino,
			horas 				= :horas,
			creditos 			= :creditos,
			nota 				= :nota '.$qrActualizarArchivo.'
			
		WHERE id_capacitacion = :id_capacitacion
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam("id_capacitacion", $id_capacitacion);
			$statement->bindParam("id_trabajador", $id_trabajador);
			$statement->bindParam("id_tipo_modalidad", $id_tipo_modalidad); 
			$statement->bindParam("id_tipo_actividad_educativa", $id_tipo_actividad_educativa); 
			$statement->bindParam("id_tipo_categoria", $id_tipo_categoria); 
			$statement->bindParam("id_curso", $id_curso);
			$statement->bindParam("folio", $folio); 
			$statement->bindParam("tomo", $tomo); 
			$statement->bindParam("nro_registro", $nro_registro); 
			$statement->bindParam("organiza", $organiza); 
			$statement->bindParam("curso", $curso); 
			$statement->bindParam("fecha_inicio", $fecha_inicio); 
			$statement->bindParam("fecha_termino", $fecha_termino); 
			$statement->bindParam("horas", $horas); 
			$statement->bindParam("creditos", $creditos); 
			$statement->bindParam("nota", $nota); 
			if ($archivo!="") {
				$statement->bindParam("archivo", $archivo);
			}
			 
		

			$sql->ejecutar();
			$rs = $statement->fetchAll(PDO::FETCH_OBJ);
			if($rs){
			$sql->cerrar();
			return $dtModel;
			}else{
			$sql->cerrar();
			return false;
			}
		}
		return $arrayReturn;
	}



} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom

function fncConstruirNombreCapacitacion($archivo){
	$nombre = fncQuitarExtensionCapacitacion($archivo['name']).'_'.uniqid().'_';
	return $nombre;
}
function fncQuitarExtensionCapacitacion($string){
    $a = explode('.', $string);
    array_pop($a);
    return implode('.', $a);
}
function fncDocumentoValido($tiempoTranscurido,$tipoCertificado, $horas){

	$dtReturn=false;
	$tiempoNoMenor=5;
	$horasMinimas=100;
	
	switch ((Int)$tipoCertificado) {
		case 1:
			$dtReturn=true;
			break;
		case 2:
			if (floatval($tiempoTranscurido)<$tiempoNoMenor) {
				$dtReturn=true;
			}
			break;
		case 3:
			if (floatval($tiempoTranscurido)<$tiempoNoMenor) {
			$dtReturn=true;
			}else{
				if ($horas>$horasMinimas) {
					$dtReturn=true;
				}
			}
			break;
		case 4:
			if (floatval($tiempoTranscurido)<$tiempoNoMenor) {
				$dtReturn=true;
				}else{
					if ($horas>$horasMinimas) {
						$dtReturn=true;
					}
				}
			break;
		default : 
			if ($tiempoTranscurido<$tiempoNoMenor) {
				$dtReturn = true;
			}
			
	}
	return $dtReturn;

}


?>