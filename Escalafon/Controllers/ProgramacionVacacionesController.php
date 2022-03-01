<?php
require_once '../../App/Escalafon/Models/ProgramacionVacaciones.php';
require_once '../../App/Escalafon/Controllers/AuditoriaController.php';
require_once '../../App/Config/control.php';
require_once '../../App/Public/archivo.php';
require_once '../../App/Public/rutas.php';
require_once '../../App/Escalafon/Controllers/CondicionController.php';
require_once('../../vendor/PHPExcel/PHPExcel.php');


class ProgramacionVacacionesController extends ProgramacionVacaciones
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
				
				$model['id_programacion_vacaciones'] 			=$listado->idProgramacionVacaciones;
				$model['id_trabajador'] 		=$listado->idTrabajador;
				$model['id_area'] 	=$listado->idArea;
                $model['condicion'] 	=$listado->condicion;
				$model['anio'] 			=$listado->anio;
				$model['mes_programacion'] 			=$listado->mesProgramacion;
				$model['mes_efectividad'] 			=$listado->mesEfectividad;
				$model['archivo'] 			=$listado->archivo;
				$model['observacion'] 			=$listado->observacion;

	
				array_push($dtReturn, $model);
			}
		}
		return $dtReturn;
	}

	public function fncObtenerRegistro($id)
	{

		$dtReturn = array();
		$dtListado = $this->fncObtenerRegistroBD($id);
		$clsCondicionController = new CondicionController();
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
		
				$model = array();
				
				$model['idProgramacionCacaciones'] 	=$listado->idProgramacionVacaciones;
				$model['idTrabajador'] 				=$listado->idTrabajador;
				$model['nombreCompleto'] 				=$listado->nombreCompleto;
				$model['documentoIdentidad'] 			=$listado->documentoIdentidad;
				$model['idArea'] 					=$listado->idArea;
				$model['nombreArea'] 				=$listado->nombreArea;	
				$model['idCondicion']					=$listado->condicion;
                $model['condicion'] 				= fncObtenerValorArray( array_shift( $clsCondicionController -> fncListarRegistros($listado->condicion)),'condicion',true );
				$model['anio'] 						=$listado->anio;
				$model['mesProgramacion'] 			=$listado->mesProgramacion;
				$model['mesEfectividad'] 			=$listado->mesEfectividad;
				$model['archivo'] 					=$listado->archivo;
				$model['observacion'] 				=$listado->observacion;
				$model['fechaAuditoria'] 			=$listado->fechaAuditoria;
				$model['usuarioAuditoria'] 		=$listado->usuarioAuditoria;

	
				array_push($dtReturn, $model);
			}
		}
		
		return array_shift($dtReturn);
	}

	public function fncListarRegistrosAuditoria($id = -1)
	{

		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosAuditoriaBD($id);

		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
		
				$model = array();
				
				$model['id_programacion_vacaciones'] 			=$listado->idProgramacionVacaciones;
				$model['id_trabajador'] 				=$listado->idTrabajador;
				$model['id_area'] 						=$listado->idArea;
                $model['condicion'] 					=$listado->condicion;
				$model['anio'] 							=$listado->anio;
				$model['mes_programacion'] 				=$listado->mesProgramacion;
				$model['mes_efectividad'] 				=$listado->mesEfectividad;
				$model['archivo'] 						=$listado->archivo;
				$model['observacion'] 					=$listado->observacion;

	
				array_push($dtReturn, $model);
			}
		}
		return $dtReturn;
	}

	public function fncListarRegistrosPorIdTrabajador($arrayInputs)
	{

		$dtReturn = array();
		//$inputIdTrabajador =  (Int)fncObtenerValorArray($arrayInputs, 'idTrabajador', true);
		$dtListado = $this->fncListarRegistrosPorIdTrabajadorDB($arrayInputs);
		$accion = 4;
		$clsCondicionController = new CondicionController();
		$listaAuditoria = array();
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
		
				$model = array();
				
				$model['idProgramacionCacaciones'] 	=$listado->idProgramacionVacaciones;
				$model['idTrabajador'] 				=$listado->idTrabajador;
				$model['nombreCompleto'] 				=$listado->nombreCompleto;
				$model['documentoIdentidad'] 			=$listado->documentoIdentidad;
				$model['idArea'] 					=$listado->idArea;
				$model['nombreArea'] 				=$listado->nombreArea;	
				$model['idCondicion']					=$listado->condicion;
                $model['condicion'] 				= fncObtenerValorArray( array_shift( $clsCondicionController -> fncListarRegistros($listado->condicion)),'condicion',true );
				$model['anio'] 						=$listado->anio;
				$model['mesProgramacion'] 			=$listado->mesProgramacion;
				$model['mesEfectividad'] 			=$listado->mesEfectividad;
				$model['archivo'] 					=$listado->archivo;
				$model['observacion'] 				=$listado->observacion;
				$model['fechaAuditoria'] 			=$listado->fechaAuditoria;
				$model['usuarioAuditoria'] 		=$listado->usuarioAuditoria;
	
				array_push($dtReturn, $model);
				array_push($listaAuditoria, $model['idProgramacionCacaciones']);
			}

			$auditorioController = new AuditoriaController();
			$auditoria = $auditorioController->fncGuardar($accion, 'programacion_vacaciones', 'id_programacion_vacaciones', null, json_encode($listaAuditoria));
		}
		return $dtReturn;
	}


	


	public function fncGuardar($arrayInputs, $archivoInput = '')
	{
		$dtReturn = array();
		$accion = 0;
		$inputIdProgramacionVacaciones = (int) fncObtenerValorArray($arrayInputs, 'idProgramacionVaciones', true);
		$inputIdTrabajador = (int) fncObtenerValorArray($arrayInputs, 'idTrabajador', true);
		//$inputIdArea = (Int) fncObtenerValorArray($arrayInputs, 'idArea', true);
		$inputCondicion = (Int)fncObtenerValorArray($arrayInputs, 'condicion', true);
		$inputAnio			= (int) fncObtenerValorArray($arrayInputs, 'anio', true);
		$inputMesProgramacion		= (Int)fncObtenerValorArray($arrayInputs, 'mesProgramacion', true);
		$inputMesEfectividad = (Int)fncObtenerValorArray($arrayInputs, 'mesEfectividad', true);
		//$inputArchivo = fncObtenerValorArray($arrayInputs, 'archivo', true);
		$inputObservacion = fncObtenerValorArray($arrayInputs, 'observacion', true);




		$dtProgramacionVacaciones = new ProgramacionVacaciones;


		if (!empty($inputIdProgramacionVacaciones)) {
			$dtProgramacionVacaciones->setIdProgramacionVacaciones($inputIdProgramacionVacaciones);
		}
		if (!empty($inputIdTrabajador)) {
			$dtProgramacionVacaciones->setIdTrabajador($inputIdTrabajador);
		}
		/*if (!empty($inputIdArea)) {
			$dtProgramacionVacaciones->setIdArea($inputIdArea);
		}*/
		if (!empty($inputCondicion)) {
			$dtProgramacionVacaciones->setCondicion($inputCondicion);
		}
		if (!empty($inputAnio)) {
			$dtProgramacionVacaciones->setAnio($inputAnio);
		}
		if (!empty($inputMesProgramacion)) {
			$dtProgramacionVacaciones->setMesProgramacion($inputMesProgramacion);
		}
		if (!empty($inputMesEfectividad)) {
			$dtProgramacionVacaciones->setMesEfectividad($inputMesEfectividad);
		}
		// if (!empty($inputArchivo)) {
		// 	$dtProgramacionVacaciones->setArchivo($inputArchivo);
		// }
		if (!empty($inputObservacion)) {
			$dtProgramacionVacaciones->setObservacion($inputObservacion);
		}

		if (fncGeneralValidarDataArray($dtProgramacionVacaciones)) {
			$dtGuardar = array();
			$optArchivo = "";
			if ($inputIdProgramacionVacaciones == 0 && $inputIdTrabajador != 0) {
				if (!empty($archivoInput)) {
					if ($archivoInput["name"] <> "") {
						$optRutaArchivo = cls_rutas::get('programacionVacacionesPdf');
						//$rutas=fncObtenerRuta();
						$nombreArchivo = fncConstruirNombreDocumentoProgramacionVacaciones($archivoInput);
						$obj_arc = new archivo($archivoInput, $optRutaArchivo, "pdf_" . $nombreArchivo, 0);
						if ($obj_arc->subir()) {
							$optArchivo = $obj_arc->get_nombre_archivo();
							$dtProgramacionVacaciones->setArchivo($optRutaArchivo.$obj_arc->get_nombre_archivo());
						}
					}
				}
				$dtGuardar = $this->fncRegistrarBD($dtProgramacionVacaciones);
				$accion = 1;
			} else {

				if (!empty($archivoInput)) {
					if ($archivoInput["name"] <> "") {
						$optRutaArchivo = cls_rutas::get('programacionVacacionesPdf');
						//$rutas=fncObtenerRuta();
						$nombreArchivo = fncConstruirNombreDocumentoProgramacionVacaciones($archivoInput);
						$obj_arc = new archivo($archivoInput, $optRutaArchivo, "pdf_" . $nombreArchivo, 0);
						if ($obj_arc->subir()) {
							$optArchivo = $obj_arc->get_nombre_archivo();
							$dtProgramacionVacaciones->setArchivo($optRutaArchivo.$obj_arc->get_nombre_archivo());
						}
					}
				}
				$dtGuardar = $this->fncActualizarBD($dtProgramacionVacaciones);
				$accion = 2;
			}

			if (fncGeneralValidarDataArray($dtGuardar)) {

				$model = array();
				$model["id_programacion_vacaciones"]    = $dtGuardar->getIdProgramacionVacaciones();
				$model["id_trabajador"]        			= $dtGuardar->getIdTrabajador();
				//$model["idArea"]  						= $dtGuardar->getIdArea();
				$model["condicion"]         			= $dtGuardar->getCondicion();
				$model["anio"]   						= $dtGuardar->getAnio();
				$model["mesProgramacion"]  				= $dtGuardar->getMesProgramacion();
				$model["mesEfectividad"]              	= $dtGuardar->getMesEfectividad();
				$model["observacion"]              		= $dtGuardar->getObservacion();
				$model["archivo"]		            	= $dtGuardar->getArchivo();

		
				//($dtReturn, $returnProgramacionVacaciones);
				//array_push($dtReturn, $model);
				$auditorioController = new AuditoriaController();
				$auditoria = $auditorioController->fncGuardar($accion, 'programacion_vacaciones', 'id_programacion_vacaciones', $model["id_programacion_vacaciones"], json_encode($model));

				$returnProgramacionVacaciones['programacion_vacaciones'] = ($model);
				$dtReturn = $this->fncObtenerRegistro($dtProgramacionVacaciones->getIdProgramacionVacaciones());
				unset($model);
			}
		}
		return $dtReturn;
	}

	public function fncEliminarRegistro($id = 0)
	{

		$bolReturn = array();
		$accion = 3;
		if ($id > 0) {
			$bolValidarEliminar = $this->fncEliminarBD($id);
			if ($bolValidarEliminar) {

				$dtProgramacionVacaciones = $this->fncListarRegistrosAuditoria($id);
				//$bolReturn = $dtProgramacionVacaciones;

				$auditorioController = new AuditoriaController();
				$auditoria = $auditorioController->fncGuardar($accion, 'programacion_vacaciones', 'id_programacion_vacaciones', $id, json_encode($dtProgramacionVacaciones));

				$returnProgramacionVacaciones = array_shift( $dtProgramacionVacaciones);
				$bolReturn = $returnProgramacionVacaciones;
			}
		}
		return $bolReturn;
	}



	
	public function fncGenerarReporteProgramacionVacaciones($arrayInputs)
	{

		$dtReturn = array();
		$dtListado = array();
		$inputAnio =  (Int)fncObtenerValorArray($arrayInputs, 'anio', true);
		$inputIdArea =  (Int)fncObtenerValorArray($arrayInputs, 'idArea', true);
		if ($inputIdArea == 0) {
			$dtListado = $this->fncGenerarReporteProgramacionVacacionesBD($inputAnio);
		} else {
			$dtListado = $this->fncGenerarReporteProgramacionVacacionesBD($inputAnio, $inputIdArea);
		}
		
		$accion = 4;
		$clsCondicionController = new CondicionController();
		$listaAuditoria = array();
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
		
				$model = array();
				
				$model['idProgramacionVacaciones'] 	=$listado->idProgramacionVacaciones;
				$model['nombreApellido'] 			=$listado->nombreApellido;
				$model['fechaIngreso'] 				=$listado->fechaIngreso;
				$model['detalleGrupo'] 				=$listado->detalleGrupo;
				$model['idTrabajador'] 				=$listado->idTrabajador;
				$model['nombreArea'] 				=$listado->nombreArea;	
				
                $model['condicion'] 				= fncObtenerValorArray( array_shift( $clsCondicionController -> fncListarRegistros($listado->condicion)),'condicion',true );
				$model['anio'] 						=$listado->anio;
				$model['mesProgramacion'] 			=nombre_mes($listado->mesProgramacion);
				$model['mesEfectividad'] 			=nombre_mes($listado->mesEfectividad);
			
				$model['observacion'] 				=$listado->observacion;

	
				array_push($dtReturn, $model);
				array_push($listaAuditoria, $model['idProgramacionVacaciones']);
			}

			$auditorioController = new AuditoriaController();
			//$auditoria = $auditorioController->fncGuardar($accion, 'programacion_vacaciones', 'id_programacion_vacaciones', null, json_encode($listaAuditoria));
		}
		return fncReemplazarNullPorVacioProgramacionVacaciones($dtReturn);
	}


	public function fncGenerarReporteProgramacionVacacionesExcel($arrayInputs)
	{

		$dtReturn = array();
		$dtListado = array();
		$inputAnio =  (Int)fncObtenerValorArray($arrayInputs, 'anio', true);
		$inputIdArea =  (Int)fncObtenerValorArray($arrayInputs, 'idArea', true);
		if ($inputIdArea == 0) {
			$dtListado = $this->fncGenerarReporteProgramacionVacacionesBD($inputAnio);
		} else {
			$dtListado = $this->fncGenerarReporteProgramacionVacacionesBD($inputAnio, $inputIdArea);
		}
		
		$accion = 4;
		$clsCondicionController = new CondicionController();
		$listaAuditoria = array();
		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
		
				$model = array();
				
				$model['idProgramacionVacaciones'] 	=$listado->idProgramacionVacaciones;
				$model['nombreApellido'] 			=$listado->nombreApellido;
				$model['fechaIngreso'] 				=$listado->fechaIngreso;
				$model['detalleGrupo'] 				=$listado->detalleGrupo;
				$model['idTrabajador'] 				=$listado->idTrabajador;
				$model['nombreArea'] 				=$listado->nombreArea;	
				
                $model['condicion'] 				= fncObtenerValorArray( array_shift( $clsCondicionController -> fncListarRegistros($listado->condicion)),'condicion',true );
				$model['anio'] 						=$listado->anio;
				$model['mesProgramacion'] 			=nombre_mes($listado->mesProgramacion);
				$model['mesEfectividad'] 			=nombre_mes($listado->mesEfectividad);
			
				$model['observacion'] 				=$listado->observacion;

	
				array_push($dtReturn, $model);
				array_push($listaAuditoria, $model['idProgramacionVacaciones']);
			}
			$dtReturn = $this->fncReporteProgramacionVacacionesExcel($dtReturn,$inputAnio);
			$auditorioController = new AuditoriaController();
			//$auditoria = $auditorioController->fncGuardar($accion, 'programacion_vacaciones', 'id_programacion_vacaciones', null, json_encode($listaAuditoria));
		}
		return ($dtReturn);
	}

	public function fncReporteProgramacionVacacionesExcel($dataReporte ,$anio)  {
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
		
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B5:J5');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B6:J6');

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B1:D1');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:D2');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B3:D3');
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(28.43);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(39.29);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(46.57);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15.71);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B5','RELACION DE PERSONAL PARA  LA PROGRAMACION DE VACACIONES EN '.$anio);
	

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B7','REG');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C7','NOMBRES Y APELLIDOS');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D7','DETALLE GRUPO');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E7','FECHA INGRESO');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F7','PROGRAMACION  AÑO '.$anio);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G7','EFECTIVIDAD  AÑO '.$anio);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H7','PROGRAMACION  AÑO '.($anio+1));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I7','OBS');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J7','AREA');
	
		
		
		$fila = 8;
		
		$filaContador = 0;
		if( fncGeneralValidarDataArray($dataReporte) ){
	
		

			$reg =1;
			$sumaTiempoMinutos = 0;
			foreach ($dataReporte as $listado) {
	
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,$reg++);

				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$fila, ($listado['nombreApellido']) );
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$fila,$listado['detalleGrupo']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,$listado['fechaIngreso']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$fila,$listado['mesProgramacion']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$fila,$listado['mesEfectividad']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$fila,'');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$fila,$listado['observacion']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$fila,$listado['nombreArea']);
	
			$fila++;
				
			}

			$objPHPExcel->getActiveSheet()->getStyle('B5:J7')->applyFromArray($estiloTodoLosBordes); 
			 $objPHPExcel->getActiveSheet()->getStyle('B5:J7')->applyFromArray($estiloTarea); 
			 $objPHPExcel->getActiveSheet()->getStyle('B5:J7')->getFont()->setBold(true);

			 $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn('B')->setAutoSize(false);
			 $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);

			 $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn('B')->setAutoSize(false);
			 $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);

			 $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn('I')->setAutoSize(false);
			 $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(40);

			 $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn('J')->setAutoSize(false);
			 $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(40);
		}
	
		$objPHPExcel->setActiveSheetIndex(0);
		
		try{
	
			
	
		  $optArchivo = cls_rutas::get('reporteProgramacionVacacionesExcel')."reporte_general.xlsx";
		  /*$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');	 
		  $objWriter->save($optArchivo);*/
		  
		  $writer = new PHPExcel_Writer_Excel2007($objPHPExcel);
		  $writer->setPreCalculateFormulas(false); 
		  $writer->save($optArchivo);
		  return $optArchivo;
	   } catch (Exception $e) {
		  return false;
		}
	  }

	//=======================================================================================
	//FUNCIONES BASE DE DATOS
	//=======================================================================================

	private function fncListarRegistrosBD( $id = -1 )
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			pv.id_programacion_vacaciones,
			pv.id_trabajador,
			pv.id_area,
			pv.condicion,
			pv.anio,
			pv.mes_programacion,
			pv.mes_efectividad,
			pv.archivo,
			pv.observacion,
			pv.eliminado
		FROM
			escalafon.programacion_vacaciones AS pv
		WHERE (:id_programacion_vacaciones = -1 OR id_programacion_vacaciones = :id_programacion_vacaciones) AND pv.eliminado = 0
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_programacion_vacaciones', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
				$temp = new ProgramacionVacaciones;
				$temp->idProgramacionVacaciones 	= $datos['id_programacion_vacaciones'];
				$temp->idTrabajador 				= $datos['id_trabajador'];
				$temp->idArea 						= $datos['id_area'];
				$temp->condicion					= $datos['condicion'];
				$temp->anio							= $datos['anio'];
				$temp->mesProgramacion				= $datos['mes_programacion'];
				$temp->mesEfectividad				= $datos['mes_efectividad'];
				$temp->archivo						= $datos['archivo'];
				$temp->observacion					= $datos['observacion'];

				array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}
	private function fncObtenerRegistroBD( $id = -1 )
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			pv.id_programacion_vacaciones,
			pv.id_trabajador,
			pn.nombre_completo,
			p.documento_identidad,
			COALESCE((SELECT a.id_area AS id_area FROM escalafon.desplazamiento AS d 
			INNER JOIN escalafon.area AS a ON a.id_area = d.id_area
			 WHERE d.id_trabajador = pv.id_trabajador AND d.eliminado = 0 AND d.anulado =0 AND d.actual=1 
			),0) AS id_area ,
			COALESCE((SELECT a.nombre_area AS nombre_are FROM escalafon.desplazamiento AS d 
			INNER JOIN escalafon.area AS a ON a.id_area = d.id_area
			 WHERE d.id_trabajador = pv.id_trabajador AND d.eliminado = 0 AND d.anulado =0 AND d.actual=1 
			),\'Sin Area Designada\') AS nombre_area,			
			pv.condicion,
			pv.anio,
			pv.mes_programacion,
			pv.mes_efectividad,
			pv.archivo,
			pv.observacion,
			
				(SELECT	a.fecha_hora FROM escalafon.auditoria  AS a WHERE ( a.id_operacion = 1 OR a.id_operacion = 2 )
					AND a.tabla = \'programacion_vacaciones\' AND a.objeto_id_nombre = \'id_programacion_vacaciones\' AND a.objeto_id_valor = pv.id_programacion_vacaciones
					ORDER BY a.id_auditoria DESC LIMIT 1 ),
				(SELECT
							pn.nombre_completo  AS usuario_auditoria
						FROM adm.usuario u
						LEFT JOIN public.persona_natural pn ON pn.id_persona = u.id_persona
						WHERE u.id_usuario = (SELECT	aa.id_usuario	FROM escalafon.auditoria  AS aa WHERE ( aa.id_operacion = 1 OR aa.id_operacion = 2 )
						AND aa.tabla = \'programacion_vacaciones\' AND aa.objeto_id_nombre = \'id_programacion_vacaciones\' AND aa.objeto_id_valor = pv.id_programacion_vacaciones
						ORDER BY aa.id_auditoria DESC LIMIT 1)),
			pv.eliminado
		FROM
			escalafon.programacion_vacaciones AS pv
			INNER JOIN escalafon.trabajador AS t ON t.id_trabajador = pv.id_trabajador
			INNER JOIN PUBLIC.persona_natural AS pn ON pn.id_persona = t.id_trabajador
			INNER JOIN PUBLIC.persona AS p on p.id_persona = pn.id_persona
		WHERE (pv.id_programacion_vacaciones = :id_programacion_vacaciones) AND  pv.eliminado = 0
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_programacion_vacaciones', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
				$temp = new ProgramacionVacaciones;
				$temp->idProgramacionVacaciones 	= $datos['id_programacion_vacaciones'];
				$temp->idTrabajador 				= $datos['id_trabajador'];
				$temp->nombreCompleto 				= $datos['nombre_completo'];
				$temp->documentoIdentidad 			= $datos['documento_identidad'];
				$temp->idArea 						= $datos['id_area'];
				$temp->nombreArea 					= $datos['nombre_area'];
				$temp->condicion					= $datos['condicion'];
				$temp->anio							= $datos['anio'];
				$temp->mesProgramacion				= $datos['mes_programacion'];
				$temp->mesEfectividad				= $datos['mes_efectividad'];
				$temp->archivo						= $datos['archivo'];
				$temp->observacion					= $datos['observacion'];
				$temp->fechaAuditoria				= $datos['fecha_hora'];
				$temp->usuarioAuditoria				= $datos['usuario_auditoria'];

				array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}
	private function fncListarRegistrosAuditoriaBD( $id = -1 )
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			pv.id_programacion_vacaciones,
			pv.id_trabajador,
			--pv.id_area,
			pv.condicion,
			pv.anio,
			pv.mes_programacion,
			pv.mes_efectividad,
			pv.archivo,
			pv.observacion,
			pv.eliminado
		FROM
			escalafon.programacion_vacaciones AS pv
		WHERE (:id_programacion_vacaciones = -1 OR id_programacion_vacaciones = :id_programacion_vacaciones)
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_programacion_vacaciones', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
				$temp = new ProgramacionVacaciones;
				$temp->idProgramacionVacaciones 	= $datos['id_programacion_vacaciones'];
				$temp->idTrabajador 				= $datos['id_trabajador'];
				//$temp->idArea 						= $datos['id_area'];
				$temp->condicion					= $datos['condicion'];
				$temp->anio							= $datos['anio'];
				$temp->mesProgramacion				= $datos['mes_programacion'];
				$temp->mesEfectividad				= $datos['mes_efectividad'];
				$temp->archivo						= $datos['archivo'];
				$temp->observacion					= $datos['observacion'];

				array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}

	private function fncListarRegistrosPorIdTrabajadorDB( $idTrabajador )
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			pv.id_programacion_vacaciones,
			pv.id_trabajador,
			pn.nombre_completo,
			p.documento_identidad,
			COALESCE((SELECT a.id_area AS id_area FROM escalafon.desplazamiento AS d 
			INNER JOIN escalafon.area AS a ON a.id_area = d.id_area
			 WHERE d.id_trabajador = pv.id_trabajador AND d.eliminado = 0 AND d.anulado =0 AND d.actual=1 
			),0) AS id_area ,
			COALESCE((SELECT a.nombre_area AS nombre_are FROM escalafon.desplazamiento AS d 
			INNER JOIN escalafon.area AS a ON a.id_area = d.id_area
			 WHERE d.id_trabajador = pv.id_trabajador AND d.eliminado = 0 AND d.anulado =0 AND d.actual=1 
			),\'Sin Area Designada\') AS nombre_area,
			pv.condicion,
			pv.anio,
			pv.mes_programacion,
			pv.mes_efectividad,
			pv.archivo,
			pv.observacion,
			
				(SELECT	a.fecha_hora FROM escalafon.auditoria  AS a WHERE ( a.id_operacion = 1 OR a.id_operacion = 2 )
					AND a.tabla = \'programacion_vacaciones\' AND a.objeto_id_nombre = \'id_programacion_vacaciones\' AND a.objeto_id_valor = pv.id_programacion_vacaciones
					ORDER BY a.id_auditoria DESC LIMIT 1 ),
				(SELECT
							pn.nombre_completo  AS usuario_auditoria
						FROM adm.usuario u
						LEFT JOIN public.persona_natural pn ON pn.id_persona = u.id_persona
						WHERE u.id_usuario = (SELECT	aa.id_usuario	FROM escalafon.auditoria  AS aa WHERE ( aa.id_operacion = 1 OR aa.id_operacion = 2 )
						AND aa.tabla = \'programacion_vacaciones\' AND aa.objeto_id_nombre = \'id_programacion_vacaciones\' AND aa.objeto_id_valor = pv.id_programacion_vacaciones
						ORDER BY aa.id_auditoria DESC LIMIT 1)),
			pv.eliminado
		FROM
			escalafon.programacion_vacaciones AS pv
			INNER JOIN escalafon.trabajador AS t ON t.id_trabajador = pv.id_trabajador
			INNER JOIN PUBLIC.persona_natural AS pn ON pn.id_persona = t.id_trabajador
			INNER JOIN PUBLIC.persona AS p on p.id_persona = pn.id_persona
		WHERE (pv.id_trabajador = :id_trabajador) AND  pv.eliminado = 0
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_trabajador', $idTrabajador);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
				$temp = new ProgramacionVacaciones;
				$temp->idProgramacionVacaciones 	= $datos['id_programacion_vacaciones'];
				$temp->idTrabajador 				= $datos['id_trabajador'];
				$temp->nombreCompleto 				= $datos['nombre_completo'];
				$temp->documentoIdentidad 			= $datos['documento_identidad'];
				$temp->idArea 						= $datos['id_area'];
				$temp->nombreArea 					= $datos['nombre_area'];
				$temp->condicion					= $datos['condicion'];
				$temp->anio							= $datos['anio'];
				$temp->mesProgramacion				= $datos['mes_programacion'];
				$temp->mesEfectividad				= $datos['mes_efectividad'];
				$temp->archivo						= $datos['archivo'];
				$temp->observacion					= $datos['observacion'];
				$temp->fechaAuditoria				= $datos['fecha_hora'];
				$temp->usuarioAuditoria				= $datos['usuario_auditoria'];

				array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}

	


	public function fncRegistrarBD($dtModel)
	{
	
		//$idProgramacionVacaciones = $dtModel->getIdTrabajador();
		$idTrabajador = $dtModel->getIdTrabajador();
		//$idArea = $dtModel->getIdArea();
		$condicion = $dtModel->getCondicion();
		$anio = $dtModel->getAnio();
		$mesProgramacion = $dtModel->getMesProgramacion();
		$mesEfectividad = $dtModel->getMesEfectividad();
		$observacion = $dtModel->getObservacion();
		$archivo = $dtModel->getArchivo();
		if ($archivo == '') {
			$archivo = NULL;
		}

		$sql = cls_control::get_instancia();
		$consulta = "INSERT INTO escalafon.programacion_vacaciones
					(
						-- id_programacion_vacaciones -- this column value is auto-generated
						id_trabajador,
						--id_area,
						condicion,
						anio,						
						mes_programacion,
						mes_efectividad,
						archivo,
						observacion,
						eliminado
					)
					VALUES
					(
						:id_trabajador ,
						
						:condicion,
						:anio ,
						:mes_programacion ,
						:mes_efectividad ,
						:archivo ,
						:observacion ,
						0
					)
				   RETURNING id_programacion_vacaciones";
		$statement = $sql->preparar($consulta);
		if ($statement != false) {
			$statement->bindParam("id_trabajador", $idTrabajador);
			//$statement->bindParam("id_area", $idArea);
			$statement->bindParam("condicion", $condicion);
			$statement->bindParam("anio", $anio);
			$statement->bindParam("mes_programacion", $mesProgramacion);
			$statement->bindParam("mes_efectividad", $mesEfectividad);
			$statement->bindParam("archivo", $archivo);
			$statement->bindParam("observacion", $observacion);
			$sql->ejecutar();
			$datos = $statement->fetch(PDO::FETCH_ASSOC);
			if ($datos) {
				//_Retorno de Datos
				$dtModel->setIdProgramacionVacaciones($datos["id_programacion_vacaciones"]);

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
		$idProgramacionVacaciones = $dtModel->getIdProgramacionVacaciones();
		$idTrabajador = $dtModel->getIdTrabajador();
		//$idArea = $dtModel->getIdArea();
		$condicion = $dtModel->getCondicion();
		$anio = $dtModel->getAnio();
		$mesProgramacion = $dtModel->getMesProgramacion();
		$mesEfectividad = $dtModel->getMesEfectividad();
		$observacion = $dtModel->getObservacion();
		$archivo = $dtModel->getArchivo();
		$modificarArchivoScript = '';
		if ($archivo != '') {
			$modificarArchivoScript = ',archivo = :archivo';
		}
		$sql = cls_control::get_instancia();
		$query = "UPDATE escalafon.programacion_vacaciones
					SET
						-- id_programacion_vacaciones -- this column value is auto-generated
						id_trabajador =:id_trabajador,
						--id_area =:id_area,
						anio =:anio,
						mes_programacion =:mes_programacion,
						mes_efectividad =:mes_efectividad,
					
						observacion =:observacion,						
						condicion =:condicion " . $modificarArchivoScript . "
				WHERE id_programacion_vacaciones = :id_programacion_vacaciones";
		$statement = $sql->preparar($query);
		if ($statement != false) {
			$statement->bindParam("id_programacion_vacaciones", $idProgramacionVacaciones);
			$statement->bindParam("id_trabajador", $idTrabajador);
			//$statement->bindParam("id_area", $idArea);
			$statement->bindParam("condicion", $condicion);
			$statement->bindParam("anio", $anio);
			$statement->bindParam("mes_programacion", $mesProgramacion);
			$statement->bindParam("mes_efectividad", $mesEfectividad);			
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

	private function fncEliminarBD($id)
	{
		$bolReturn = false;
		$sql = cls_control::get_instancia();
		$consulta = 'UPDATE escalafon.programacion_vacaciones
		SET		
			eliminado = 1
		WHERE id_programacion_vacaciones = :id_programacion_vacaciones';
		$statement = $sql->preparar($consulta);
		if ($statement != false) {
			$statement->bindParam('id_programacion_vacaciones', $id);
			$sql->ejecutar();
			$datos = $statement->fetchAll(PDO::FETCH_OBJ);
			if ($datos) {
				$bolReturn = true;
			}
			$sql->cerrar();
		}
		return $bolReturn;
	}


	private function fncGenerarReporteProgramacionVacacionesBD($anio, $idArea = -1)
	{
		
		$sql = cls_control::get_instancia();
	
		$query = '
		SELECT * FROM(
			SELECT
					--DISTINCT ON (
					--pv.id_trabajador,
					--pv.condicion,
					--pv.anio,
					--pv.mes_programacion,
					--pv.mes_efectividad)
					pv.id_programacion_vacaciones,
					(SELECT
						pn.nombres||\' \'|| pn.apellidos
						
					 FROM
						"public".persona_natural AS pn WHERE pn.id_persona = pv.id_trabajador ) AS nombre_apellido,
							
					 (SELECT d.fecha_inicio  FROM escalafon.desplazamiento AS d  WHERE d.id_trabajador = pv.id_trabajador AND d.eliminado = 0 AND d.anulado = 0 ORDER BY d.fecha_inicio ASC LIMIT 1 ) AS fecha_ingreso,
					(SELECT tt.tipo_trabajador
					   FROM 	 	escalafon.trabajador AS t INNER JOIN escalafon.tipo_trabajador AS tt ON tt.id_tipo_trabajador = t.id_tipo_trabajador WHERE t.id_trabajador = pv.id_trabajador ) AS detalle_grupo,
					pv.id_trabajador,
					COALESCE((SELECT a.id_area AS id_area FROM escalafon.desplazamiento AS d 
					INNER JOIN escalafon.area AS a ON a.id_area = d.id_area
					 WHERE d.id_trabajador = pv.id_trabajador AND d.eliminado = 0 AND d.anulado =0 AND d.actual=1 
					),0) AS id_area ,
					COALESCE((SELECT a.nombre_area AS nombre_are FROM escalafon.desplazamiento AS d 
					INNER JOIN escalafon.area AS a ON a.id_area = d.id_area
					 WHERE d.id_trabajador = pv.id_trabajador AND d.eliminado = 0 AND d.anulado =0 AND d.actual=1 
					),\'Sin Area Designada\') AS nombre_area,
					pv.condicion,
					pv.anio,
					pv.mes_programacion,
					pv.mes_efectividad,
					pv.archivo,
					pv.observacion
					  
					   
					FROM
					escalafon.programacion_vacaciones AS pv 
					
				  
					WHERE pv.eliminado = 0 AND pv.anio = :anio
					ORDER BY pv.id_trabajador
					
			) AS spv
			WHERE (:id_area = -1 OR id_area = :id_area)		
					
			
	  
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('anio', $anio);
			$statement->bindParam('id_area', $idArea);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new ProgramacionVacaciones;
				$temp->idProgramacionVacaciones 	    = $datos['id_programacion_vacaciones'];
				$temp->nombreApellido 					= $datos['nombre_apellido'];
				$temp->fechaIngreso 					= $datos['fecha_ingreso'];
				$temp->detalleGrupo						= $datos['detalle_grupo'];
				$temp->idTrabajador						= $datos['id_trabajador'];
				$temp->idArea							= $datos['id_area'];
				$temp->nombreArea						= $datos['nombre_area'];
				$temp->condicion						= $datos['condicion'];
				$temp->anio								= $datos['anio'];
				$temp->mesProgramacion					= $datos['mes_programacion'];
				$temp->mesEfectividad					= $datos['mes_efectividad'];
				$temp->observacion						= $datos['observacion'];
			
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}





} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom
function fncConstruirNombreDocumentoProgramacionVacaciones($archivo)
{
	$nombre = fncQuitarExtensionDocumentoProgramacionVacaciones($archivo['name']) . '_' . uniqid() . '_';
	return $nombre;
}
function fncQuitarExtensionDocumentoProgramacionVacaciones($string)
{
	$a = explode('.', $string);
	array_pop($a);
	return implode('.', $a);
}
function fncReemplazarNullPorVacioProgramacionVacaciones($array)
{
	foreach ($array as $key => $value) 
	{
		if(is_array($value))
			$array[$key] = fncReemplazarNullPorVacioProgramacionVacaciones($value);
		else
		{
			if (is_null($value))
				$array[$key] = "";
		}
	}
	return $array;
}