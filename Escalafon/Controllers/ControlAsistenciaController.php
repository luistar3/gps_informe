<?php
require_once __DIR__.'/../../../vendor/autoload.php';
require_once '../../App/Escalafon/Models/ControlAsistencia.php';
require_once '../../App/Escalafon/Controllers/AuditoriaController.php';
require_once '../../App/Config/control.php';
require_once '../../App/Public/archivo.php';
require_once '../../App/Public/rutas.php';
require_once("../../vendor/excel/simplexlsx/SimpleXLSX.php");
require_once("../../vendor/excel/simplexls/SimpleXLS.php");
require_once('../../vendor/PHPExcel/PHPExcel.php');
require_once('../../App/Public/sistema.php');

//require_once('../../vendor/Dompdf/Dompdf/src/Autoloader.php');
use Dompdf\Dompdf;

class ControlAsistenciaController extends ControlAsistencia
{
	//=======================================================================================
	//FUNCIONES LOGICA
	//=======================================================================================

	public function fncGenerarReporteInformeRemuneracionVista($arrayInputs)
	{

		$dtReturn = array();
		$dataExcel = array();
		$dataTotales = array();
		$dtListadoContarLicencias = array();
		$inputIdTipoTrabajador = (Int)fncObtenerValorArray($arrayInputs, 'idTipotrabajador', true);
		$inputAnio = fncObtenerValorArray($arrayInputs, 'anio', true);
		$inputMes = fncObtenerValorArray($arrayInputs, 'mes', true);
		$dtListado = $this->fncGenerarReporteExcelInformeRemuneracionBD($inputIdTipoTrabajador,$inputAnio,$inputMes);
		$sumaLicenciaVacaciones=$sumaLicenciaPersonal=$sumaLicenciaParticular=$sumaNoMarcoEntrada=$sumaNoMarcoSalida=$suma30m=0;
		$sumaDiasLicParticular=$sumaDiasLicPersonal=$sumaDiasLicVacaciones=0;
		if (fncGeneralValidarDataArray($dtListado)) {
			
			foreach ($dtListado as $listado) {
				$dtListadoContarLicencias = array_shift($this->fncBuscarCantarLicenciasMesTrabajadorBD($inputAnio,$inputMes,$listado->idTrabajador));
				$cantidadLicEnfermedad=$fechaLicVacacion=$fechaLicPersonal=$fechaLicParticular=$diaInicioTermino=$particular=$personal=$vacaciones='';

				$licEnDiasVacacion = $licEnDiasParticular = $licEnDiasEnfermedad = '';
				if (count($dtListadoContarLicencias)>0) {
					//$diaInicioTermino=$dtListadoContarLicencias->diaInicioTermino;


					$primerDia = date("Y-m-01", strtotime("$inputAnio-$inputMes"));
					$ultimoDia= date('Y-m-t', strtotime("$inputAnio-$inputMes"));

					$dtDiasLicencias = array_shift($this->fncBuscarLicenciasDiaslBD($listado->idTrabajador,$primerDia,$ultimoDia));
					$licEnDiasVacacion = $dtDiasLicencias->diasVacacion;
					$licEnDiasParticular = $dtDiasLicencias->diasParticular;
					$licEnDiasEnfermedad = $dtDiasLicencias->diasEnfermedad;


					$particular=$dtListadoContarLicencias->particular;
					$personal=$dtListadoContarLicencias->personal;
					$vacaciones=$dtListadoContarLicencias->vacaciones;

					$sumaDiasLicParticular=$dtListadoContarLicencias->diasLicParticular;
					$sumaDiasLicPersonal=$dtListadoContarLicencias->diasLicPersonal;
					$sumaDiasLicVacaciones=$dtListadoContarLicencias->diasLicVacacion;

					$fechaLicParticular=implode(',',(array_filter(json_decode( $dtListadoContarLicencias->fechaLicParticular))));
					$fechaLicPersonal=implode(',',(array_filter(json_decode( $dtListadoContarLicencias->fechaLicPersonal))));
					$fechaLicVacacion=implode(',',(array_filter(json_decode( $dtListadoContarLicencias->fechaLicVacacion))));

				}
				$cantidadDentroDelos30Min = ($this->fncContarLlegadaDentroDeLos30MinBD($listado->idTrabajador,$inputAnio,$inputMes) );
				$cantidadDentroDelos30Min = array_shift($cantidadDentroDelos30Min);
				$model = array();

				$model["idTrabajador"]        			= $listado->idTrabajador;
				$model["nombreApellido"]  				= $listado->nombreApellido;

				$model["diasLicParticular"]  		= $sumaDiasLicParticular;
				$model["diasLicPersonal"]  			= 0;
				$dtLicenciaEnfermedad = ($this->fncBuscarContarLicenciaEnfermedadTrabajadorBD( $inputAnio,$inputMes,$listado->idTrabajador));				
				if (count($dtLicenciaEnfermedad)>0) {
					$dtLicenciaEnfermedad = array_shift($dtLicenciaEnfermedad);
					$fechaLicEnfermedad=implode(',',(array_filter(json_decode( $dtLicenciaEnfermedad->fechaLicenciaParticular))));
					$cantidadLicEnfermedad=$dtLicenciaEnfermedad->cantidadLic;

				}
				$model["diasLicVacaciones"]  		= $sumaDiasLicVacaciones;

				$model["fechaTardanza"]         		= implode(',',(array_filter(json_decode( $listado->fechaTardanza))));
				$model["fechaNoMarcoEntrada"]   		= implode(',',(array_filter(json_decode( $listado->fechaNoMarcoEntrada))));
				$model["fechaNoMarcoSalida"]   			= implode(',',(array_filter(json_decode( $listado->fechaNoMarcoSalida))));
				$model["noMarcoEntrada"]  				= (Int)$listado->noMarcoEntrada;
				$model["noMarcoSalida"]              	= (Int)$listado->noMarcoSalida;
				$model["+30m"]							= $listado->cantidadTardanza; //supero los 30 min de tolerancia
				//$model["cantidadTardanza"]              = $listado->cantidadTardanza;
				$model["dentro30Min"]            		= $cantidadDentroDelos30Min->llegadaDentroDelos30Min;
				
				$model["cantidadTardanzaEnHoras"]       = $listado->cantidadTardanzaEnHoras;
				$model["diaInicioTermino"]				= $diaInicioTermino;
				$model["licenciaParticular"]			= (Int)$licEnDiasParticular;
				$model["licenciaPersonal"]				= (Int)$licEnDiasEnfermedad;
				$model["licenciaVacacion"]				= (Int)$licEnDiasVacacion;
				$model["totalLicencias"]				= $model["licenciaParticular"]+$model["licenciaPersonal"]+$model["licenciaVacacion"];

				$model["fechaLicParticular"]			= $fechaLicParticular;
				$model["fechaLicPersonal"]				= $fechaLicEnfermedad;
				$model["fechaLicVacacion"]				= $fechaLicVacacion;

				$dtSueldo = array_shift($this->fncBuscarSueldoTrabajador($listado->idTrabajador));
				$sueldo = 0;
				if (count($dtSueldo)>0) {
					$sueldo = floatval ( $dtSueldo->sueldo);
				}				
				$model["sueldo"]						= $sueldo;


				/* calcular sueldos */ /* datos calculados */

				$tardanzaEnHoras = calcularTardanzaEnHoras($model["dentro30Min"]);

				$model["nuevoTardanzaEnHoras"]		= $tardanzaEnHoras;
				$remuneracionPorDia = 0;
				if($model["sueldo"]>0){ 
				$remuneracionPorDia=	round(($model["sueldo"]/31), 2);
				}
				$model["remuneracionPorDia"]		= $remuneracionPorDia;
				$model["des+30NmeNms"]				= ($remuneracionPorDia*$model["licenciaParticular"])+($remuneracionPorDia*($model["+30m"]+$model["noMarcoSalida"] +$model["noMarcoEntrada"]));
				$descuentoTardanza = 0;
				
				$model["desTardanza"]				= ($model["nuevoTardanzaEnHoras"]*$model["remuneracionPorDia"])/8;
				$model["totalCalculadoDesc"]				= $model["des+30NmeNms"]+$model["desTardanza"];


				array_push($dataExcel, $model);

				$sumaLicenciaVacaciones+=$model["licenciaVacacion"];
				$sumaLicenciaPersonal+=$model["licenciaPersonal"]; // valor real lic enfermedad
				$sumaLicenciaParticular+=$model["licenciaParticular"];
				$sumaNoMarcoEntrada+=$model["noMarcoEntrada"];
				$sumaNoMarcoSalida+=$model["noMarcoSalida"];
				$suma30m+=$model["+30m"];

				


			}
			$dtReturn = $dataExcel;
			$dataTotales["sumaLicenciaVacaciones"] = $sumaLicenciaVacaciones;
			$dataTotales["sumaLicenciaPersonal"] = $sumaLicenciaPersonal;
			$dataTotales["sumaLicenciaParticular"] = $sumaLicenciaParticular;
			$dataTotales["sumaNoMarcoEntrada"] = $sumaNoMarcoEntrada;
			$dataTotales["sumaNoMarcoSalida"] = $sumaNoMarcoSalida;
			$dataTotales["suma30m"] = $suma30m;
			//$dtReturn = $this->fncReporteRemuneracionPdf($dataExcel);
		}
		return $dtReturn;
	}
	


	public function fncReporteAsistenciaIndividual($arrayInputs)
	{

		$dtReturn = array();
		$dataExcel = array();
		$dataTotales = array();
		$dtListadoContarLicencias = array();
		$inputIdTrabajador = (Int)fncObtenerValorArray($arrayInputs, 'idTrabajador', true);
		$inputFechaInicio = fncObtenerValorArray($arrayInputs, 'fechaInicio', true);
		$inputFechaTermino = fncObtenerValorArray($arrayInputs, 'fechaTermino', true);

		$dtListado = $this->fncReporteAsistenciaIndividualBD($inputIdTrabajador,$inputFechaInicio,$inputFechaTermino);
		//$sumaLicenciaVacaciones=$sumaLicenciaPersonal=$sumaLicenciaParticular=$sumaNoMarcoEntrada=$sumaNoMarcoSalida=$suma30m=0;
		//$sumaDiasLicParticular=$sumaDiasLicPersonal=$sumaDiasLicVacaciones=0;
		if (fncGeneralValidarDataArray($dtListado)) {
			$aux = fncObtenerFechaRango($inputFechaInicio,$inputFechaTermino);

			foreach ($aux as $key => $value) {
				$model = array();
				$modelAux = array();
				$existe = 0;
				foreach ($dtListado as $listado) {			
					
					$fechaTabla= $value;
					$fechaConsulta=$listado->fecha;
					if($fechaTabla === $fechaConsulta){	
						$existe=1;									
					}
					if($existe==1){						
						$model["idTrabajador"]        			= $listado->idTrabajador;
						$model["fecha"]  						= $listado->fecha;
						//$model["dia"]  							= dia($listado->fecha);
						$model["horaIngreso"]        			= $listado->horaIngreso;
						$model["horarioEntrada"]  				= $listado->horarioEntrada;
						$model["tardanzaEnMinutos"]        		= $listado->tardanzaEnMinutos;
						$model["horaSalida"]  					= $listado->horaSalida;
						$model["horarioSalida"]        			= $listado->horarioSalida;
						$model["horasExtrasEnMinutos"]  		= $listado->horasExtrasEnMinutos;
						$model["horasExtra"]  					= '';
						//$model["horaExtra"]  					= '';
						$model["noMarcoEntrada"]        		= $listado->noMarcoEntrada;
						$model["noMarcoSalida"]  				= $listado->noMarcoSalida;
						$model["dentroTolerancia"]      		= $listado->dentroTolerancia;				
						
						$model["vacaciones"]  					= $listado->vacaciones;
						$model["inacistencia"]  				= '';
						$model["licenciaEnfermedad"]  			= '';
						$model["licenciaParticular"]        	= $listado->licenciaParticular;
						$model["licenciaVacacion"]  			= '';
					break;
					}else{
						$existe =0;
						$modelAux["idTrabajador"]        			= $listado->idTrabajador;
						$modelAux["fecha"]  						= $value;
						//$modelAux["dia"]  							= dia($listado->fecha);
						$modelAux["horaIngreso"]        			= '';
						$modelAux["horarioEntrada"]  				= $listado->horarioEntrada;
						$modelAux["tardanzaEnMinutos"]        		= '';
						$modelAux["horaSalida"]  					= '';
						$modelAux["horarioSalida"]        			= $listado->horarioSalida;
						$modelAux["horasExtrasEnMinutos"]  			= '';
						$modelAux["horasExtra"]  					= '';
						//$modelAux["horaExtra"]  					= '';
						$modelAux["noMarcoEntrada"]        			= 'x';
						$modelAux["noMarcoSalida"]  				= 'x';
						$modelAux["dentroTolerancia"]      			= '';	
						
						$modelAux["vacaciones"]  					= $listado->vacaciones;
						$modelAux["inacistencia"]  					= 'x';
						$modelAux["licenciaEnfermedad"]  			= '';
						$modelAux["licenciaParticular"]        		= $listado->licenciaParticular;
						$modelAux["licenciaVacacion"]  				= '';
					}
						
				}
				if($existe==0){
					array_push($dataExcel, $modelAux);
				}else{
					array_push($dataExcel, $model);
				}
				
				
			}
		
			foreach ($dataExcel as $key => $dtAsistencia) {
				//$inacistencia =$dtAsistencia['inacistencia'];
				//if ($inacistencia!='') {
					$dataExcel[$key]['dia'] = dia($dtAsistencia['fecha']);
					$dtLicEnfermedad = $this->fncBuscarLicenciaEnfermedadReporteIndividualBD($inputIdTrabajador,$inputFechaInicio,$inputFechaTermino,$dtAsistencia['fecha']);
					$dtLicParticular = $this->fncBuscarLicenciaParticularReporteIndividualBD($inputIdTrabajador,$inputFechaInicio,$inputFechaTermino,$dtAsistencia['fecha']);
					$dtLicVacacion = $this->fncBuscarLicenciaVacacionReporteIndividualBD($inputIdTrabajador,$inputFechaInicio,$inputFechaTermino,$dtAsistencia['fecha']);
					
					if (count($dtLicEnfermedad)>0) {
						$dataExcel[$key]['licenciaEnfermedad'] = 'Lic. Registrada';
					}
					else{
						$dataExcel[$key]['licenciaEnfermedad'] = '';
					}
					if (count($dtLicParticular)>0) {
						$dataExcel[$key]['licenciaParticular'] = 'Lic. Registrada';
					}
					else{
						$dataExcel[$key]['licenciaParticular'] = '';
					}
					if (count($dtLicVacacion)>0) {
						$dataExcel[$key]['licenciaVacacion'] = 'Lic. Registrada';
					}
					else{
						$dataExcel[$key]['licenciaVacacion'] = '';
					}

					if ((Int)$dtAsistencia['horasExtrasEnMinutos']>=60) {
						$horasExtra =$dtAsistencia['horasExtrasEnMinutos'];
						$hours = floor($horasExtra / 60);
						$min = $horasExtra - ($hours * 60);
						//$tiempos = $hours.":".$min;
						$tiempo = date("H:i", strtotime("$hours:$min"));
						//$sumaTiempoMinutos=$horasExtra+$sumaTiempoMinutos;
						$dataExcel[$key]['horasExtra'] = $tiempo;
						//$dataExcel[$key]['horaExtra'] = $tiempos;
					}
						
				//}
			}

			$dtReturn = $dataExcel;
			
			//$dtReturn = $this->fncReporteExcel($dataExcel,$dataTotales);
		

		
		}

		

		return $dtReturn;
	}
	


	public function fncReporteAsistenciaIndividualExcel($arrayInputs)
	{

		$dtReturn = array();
		$dataExcel = array();
		$dataTotales = array();
		$dtListadoContarLicencias = array();
		$inputIdTrabajador = (Int)fncObtenerValorArray($arrayInputs, 'idTrabajador', true);
		$inputFechaInicio = fncObtenerValorArray($arrayInputs, 'fechaInicio', true);
		$inputFechaTermino = fncObtenerValorArray($arrayInputs, 'fechaTermino', true);

		$dtListado = $this->fncReporteAsistenciaIndividualBD($inputIdTrabajador,$inputFechaInicio,$inputFechaTermino);
		//$sumaLicenciaVacaciones=$sumaLicenciaPersonal=$sumaLicenciaParticular=$sumaNoMarcoEntrada=$sumaNoMarcoSalida=$suma30m=0;
		//$sumaDiasLicParticular=$sumaDiasLicPersonal=$sumaDiasLicVacaciones=0;
		$dtTrabajador = $this->fncDatostrabajadorDB($inputIdTrabajador);
		if (fncGeneralValidarDataArray($dtListado)) {
			
			foreach ($dtListado as $listado) {
				
				$model = array();

				$model["idTrabajador"]        			= $listado->idTrabajador;
				$model["fecha"]  						= $listado->fecha;
				$model["horaIngreso"]        			= $listado->horaIngreso;
				$model["horarioEntrada"]  				= $listado->horarioEntrada;
				$model["tardanzaEnMinutos"]        		= $listado->tardanzaEnMinutos;
				$model["horaSalida"]  					= $listado->horaSalida;
				$model["horarioSalida"]        			= $listado->horarioSalida;
				$model["horasExtrasEnMinutos"]  		= $listado->horasExtrasEnMinutos;
				$model["noMarcoEntrada"]        		= $listado->noMarcoEntrada;
				$model["noMarcoSalida"]  				= $listado->noMarcoSalida;
				$model["dentroTolerancia"]      		= $listado->dentroTolerancia;				
				$model["licenciaParticular"]        	= $listado->licenciaParticular;
				$model["vacaciones"]  					= $listado->vacaciones;
				$model["inacistencia"]  				= $listado->falta;


				array_push($dataExcel, $model);

			}
			//$dtReturn = $dataExcel;
			
			$dtReturn = $this->fncAsistenciaIndividualExcel($dataExcel,$dtTrabajador,$inputFechaInicio,$inputFechaTermino);
		}
		return $dtReturn;
	}
	public function fncAsistenciaIndividualExcel($dataReporte,$dtTrabajador,$inputFechaInicio,$inputFechaTermino)  {
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
		//$objPHPExcel->getActiveSheet()->getStyle('B2:G2')->applyFromArray($estiloTituloReporte);
		//$objPHPExcel->getActiveSheet()->getStyle('B3:G3')->applyFromArray($estiloSubTituloReporte);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:W2');
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(28.43);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(39.29);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(46.57);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10.71);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15.71);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2','REPORTE HORAS EXTRA');
		//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H2','=ALEATORIO.ENTRE(4, 9)');
		
		
		/* merge cabeceras */
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B4:B6');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C4:E6');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('F4:F6');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('G4:H6');

		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4','TRABAJADOR');
		$nombre='';
		$documentoIdentidad = '';
		foreach ($dtTrabajador as $value) {
			$nombre = $value->nombreApellido;
			$documentoIdentidad = $value->documentoIdentidad;
		}
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4',$nombre);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4','DNI');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G4',$documentoIdentidad);

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C7:D7');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('F7:H7');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B7','FECHA INICIO');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C7',$inputFechaInicio);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E7','FECHA TERMINO');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F7',$inputFechaTermino);
		
		
		$fila = 9;
		
		$filaContador = 0;
		if( fncGeneralValidarDataArray($dataReporte) ){
	
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B8','FECHA');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C8','DIA');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D8','HORA ENTRADA');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E8','HORA SALIDA');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F8','HORA EXTRA');
	
		/*	
			$objPHPExcel->getActiveSheet()->getStyle('X16:Z22')->applyFromArray($estiloTodoLosBordes); 
	
	
			
			$objPHPExcel->getActiveSheet()->getStyle('B4:W6')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('B4:W6')->applyFromArray($estiloTarea); 
			$objPHPExcel->getActiveSheet()->getStyle('B4:W6')->applyFromArray($estiloTodoLosBordes); 
			
	
		
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
	
			
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
	*/
			$reg =1;
			$sumaTiempoMinutos = 0;
			foreach ($dataReporte as $listado) {
	
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,$listado['fecha']);

				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$fila, dia($listado['fecha']) );
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$fila,$listado['horaIngreso']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,$listado['horaSalida']);
				$tiempoFormato = $tiempo=$horasExtra = '00:00';  /*  contar mas de  los  >=60 min*/
				
				
				if ((Int)$listado['horasExtrasEnMinutos']>=60) {
					$horasExtra =$listado['horasExtrasEnMinutos'];
					$hours = floor($horasExtra / 60);
					$min = $horasExtra - ($hours * 60);
					$tiempo = $hours.":".$min;
					$tiempoFormato = date("H:i", strtotime("$hours:$min"));
					$sumaTiempoMinutos=$horasExtra+$sumaTiempoMinutos;
				}
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$fila,$tiempoFormato);
	
			$fila++;
				
			}

	
			$horas = floor($sumaTiempoMinutos / 60);
			$minutos = $sumaTiempoMinutos - ($horas * 60);
			$tiempoTotal = $horas.":".$minutos;
			$dias = round($horas / 8);
			
			 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$fila,$tiempoTotal );
			 $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D'.$fila.':E'.$fila);
			 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$fila,'TOTAL HORAS(hh/mm)' );

			 
			 $objPHPExcel->getActiveSheet()->getStyle('B4:H8')->applyFromArray($estiloTodoLosBordes); 
			 $objPHPExcel->getActiveSheet()->getStyle('B4:H8')->applyFromArray($estiloTarea); 
			 $objPHPExcel->getActiveSheet()->getStyle('B4:H8')->getFont()->setBold(true);
			 /* TABLA  DE RESUMEN DEL REPORTE */
			 $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.($fila+1).':C'.($fila+1));
			 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($fila+1),'RESUMEN' );
			 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($fila+2),'DIAS:' );
			 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($fila+3),'HORAS:' );
			 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($fila+4),'MINUTOS:' );
			

			 $resumenArray = convertirSegundos($sumaTiempoMinutos);

			 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($fila+2),$resumenArray['dias'] );
			 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($fila+3),$resumenArray['horas'] );
			 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($fila+4),$resumenArray['minutos'] );

			 $objPHPExcel->getActiveSheet()->getStyle('B'.($fila+1).':C'.($fila+4))->applyFromArray($estiloTodoLosBordes);  
			 
			 $objPHPExcel->getActiveSheet()->getStyle('B'.($fila+1).':C'.($fila+4))->applyFromArray($estiloTarea); 
			 $objPHPExcel->getActiveSheet()->getStyle('B'.($fila+1).':C'.($fila+4))->getFont()->setBold(true);
		}
	
		$objPHPExcel->setActiveSheetIndex(0);
		
		try{
	
			
	
		  $optArchivo = cls_rutas::get('reporteControlAsistenciaIndividualExcel')."reporte_general.xlsx";
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

	  public function fncGenerarReporteInformeRemuneracionPdf($arrayInputs)
	{

		$dtReturn = array();
		$dataExcel = array();
		$dataTotales = array();
		$dtListadoContarLicencias = array();
		$inputIdTipoTrabajador = (Int)fncObtenerValorArray($arrayInputs, 'idTipotrabajador', true);
		$inputAnio = fncObtenerValorArray($arrayInputs, 'anio', true);
		$inputMes = fncObtenerValorArray($arrayInputs, 'mes', true);
		$dtListado = $this->fncGenerarReporteExcelInformeRemuneracionBD($inputIdTipoTrabajador,$inputAnio,$inputMes);
		$sumaLicenciaVacaciones=$sumaLicenciaPersonal=$sumaLicenciaParticular=$sumaNoMarcoEntrada=$sumaNoMarcoSalida=$suma30m=0;
		$sumaDiasLicParticular=$sumaDiasLicPersonal=$sumaDiasLicVacaciones=0;
		if (fncGeneralValidarDataArray($dtListado)) {
			
			foreach ($dtListado as $listado) {
				$dtListadoContarLicencias = array_shift($this->fncBuscarCantarLicenciasMesTrabajadorBD($inputAnio,$inputMes,$listado->idTrabajador));
				$cantidadLicEnfermedad=$fechaLicVacacion=$fechaLicPersonal=$fechaLicParticular=$diaInicioTermino=$particular=$personal=$vacaciones='';

				$licEnDiasVacacion = $licEnDiasParticular = $licEnDiasEnfermedad = '';
				if (count($dtListadoContarLicencias)>0) {
					//$diaInicioTermino=$dtListadoContarLicencias->diaInicioTermino;


					$primerDia = date("Y-m-01", strtotime("$inputAnio-$inputMes"));
					$ultimoDia= date('Y-m-t', strtotime("$inputAnio-$inputMes"));

					$dtDiasLicencias = array_shift($this->fncBuscarLicenciasDiaslBD($listado->idTrabajador,$primerDia,$ultimoDia));
					$licEnDiasVacacion = $dtDiasLicencias->diasVacacion;
					$licEnDiasParticular = $dtDiasLicencias->diasParticular;
					$licEnDiasEnfermedad = $dtDiasLicencias->diasEnfermedad;


					$particular=$dtListadoContarLicencias->particular;
					$personal=$dtListadoContarLicencias->personal;
					$vacaciones=$dtListadoContarLicencias->vacaciones;

					$sumaDiasLicParticular=$dtListadoContarLicencias->diasLicParticular;
					$sumaDiasLicPersonal=$dtListadoContarLicencias->diasLicPersonal;
					$sumaDiasLicVacaciones=$dtListadoContarLicencias->diasLicVacacion;

					$fechaLicParticular=implode(',',(array_filter(json_decode( $dtListadoContarLicencias->fechaLicParticular))));
					$fechaLicPersonal=implode(',',(array_filter(json_decode( $dtListadoContarLicencias->fechaLicPersonal))));
					$fechaLicVacacion=implode(',',(array_filter(json_decode( $dtListadoContarLicencias->fechaLicVacacion))));

				}
				$cantidadDentroDelos30Min = ($this->fncContarLlegadaDentroDeLos30MinBD($listado->idTrabajador,$inputAnio,$inputMes) );
				$cantidadDentroDelos30Min = array_shift($cantidadDentroDelos30Min);
				$model = array();

				$model["idTrabajador"]        			= $listado->idTrabajador;
				$model["nombreApellido"]  				= $listado->nombreApellido;

				$model["diasLicParticular"]  		= $sumaDiasLicParticular;
				$model["diasLicPersonal"]  			= 0;
				$dtLicenciaEnfermedad = ($this->fncBuscarContarLicenciaEnfermedadTrabajadorBD( $inputAnio,$inputMes,$listado->idTrabajador));				
				if (count($dtLicenciaEnfermedad)>0) {
					$dtLicenciaEnfermedad = array_shift($dtLicenciaEnfermedad);
					$fechaLicEnfermedad=implode(',',(array_filter(json_decode( $dtLicenciaEnfermedad->fechaLicenciaParticular))));
					$cantidadLicEnfermedad=$dtLicenciaEnfermedad->cantidadLic;

				}
				$model["diasLicVacaciones"]  		= $sumaDiasLicVacaciones;

				$model["fechaTardanza"]         		= implode(',',(array_filter(json_decode( $listado->fechaTardanza))));
				$model["fechaNoMarcoEntrada"]   		= implode(',',(array_filter(json_decode( $listado->fechaNoMarcoEntrada))));
				$model["fechaNoMarcoSalida"]   			= implode(',',(array_filter(json_decode( $listado->fechaNoMarcoSalida))));
				$model["noMarcoEntrada"]  				= (Int)$listado->noMarcoEntrada;
				$model["noMarcoSalida"]              	= (Int)$listado->noMarcoSalida;
				$model["+30m"]							= $listado->cantidadTardanza; //supero los 30 min de tolerancia
				//$model["cantidadTardanza"]              = $listado->cantidadTardanza;
				$model["dentro30Min"]            		= $cantidadDentroDelos30Min->llegadaDentroDelos30Min;
				
				$model["cantidadTardanzaEnHoras"]       = $listado->cantidadTardanzaEnHoras;
				$model["diaInicioTermino"]				= $diaInicioTermino;
				$model["licenciaParticular"]			= (Int)$licEnDiasParticular;
				$model["licenciaPersonal"]				= (Int)$licEnDiasEnfermedad;
				$model["licenciaVacacion"]				= (Int)$licEnDiasVacacion;
				$model["totalLicencias"]				= $model["licenciaParticular"]+$model["licenciaPersonal"]+$model["licenciaVacacion"];

				$model["fechaLicParticular"]			= $fechaLicParticular;
				$model["fechaLicPersonal"]				= $fechaLicEnfermedad;
				$model["fechaLicVacacion"]				= $fechaLicVacacion;

				$dtSueldo = array_shift($this->fncBuscarSueldoTrabajador($listado->idTrabajador));
				$sueldo = 0;
				if (count($dtSueldo)>0) {
					$sueldo = floatval ( $dtSueldo->sueldo);
				}				
				$model["sueldo"]						= $sueldo;


				/* calcular sueldos */ /* datos calculados */

				$tardanzaEnHoras = calcularTardanzaEnHoras($model["dentro30Min"]);

				$model["nuevoTardanzaEnHoras"]		= $tardanzaEnHoras;
				$remuneracionPorDia = 0;
				if($model["sueldo"]>0){ 
				$remuneracionPorDia=	round(($model["sueldo"]/31), 2);
				}
				$model["remuneracionPorDia"]		= $remuneracionPorDia;
				$model["des+30NmeNms"]				= ($remuneracionPorDia*$model["licenciaParticular"])+($remuneracionPorDia*($model["+30m"]+$model["noMarcoSalida"] +$model["noMarcoEntrada"]));
				$descuentoTardanza = 0;
				
				$model["desTardanza"]				= ($model["nuevoTardanzaEnHoras"]*$model["remuneracionPorDia"])/8;
				$model["totalCalculadoDesc"]				= $model["des+30NmeNms"]+$model["desTardanza"];


				array_push($dataExcel, $model);

				$sumaLicenciaVacaciones+=$model["licenciaVacacion"];
				$sumaLicenciaPersonal+=$model["licenciaPersonal"]; // valor real lic enfermedad
				$sumaLicenciaParticular+=$model["licenciaParticular"];
				$sumaNoMarcoEntrada+=$model["noMarcoEntrada"];
				$sumaNoMarcoSalida+=$model["noMarcoSalida"];
				$suma30m+=$model["+30m"];

				


			}
			$dtReturn = $dataExcel;
			$dataTotales["sumaLicenciaVacaciones"] = $sumaLicenciaVacaciones;
			$dataTotales["sumaLicenciaPersonal"] = $sumaLicenciaPersonal;
			$dataTotales["sumaLicenciaParticular"] = $sumaLicenciaParticular;
			$dataTotales["sumaNoMarcoEntrada"] = $sumaNoMarcoEntrada;
			$dataTotales["sumaNoMarcoSalida"] = $sumaNoMarcoSalida;
			$dataTotales["suma30m"] = $suma30m;
			$dtReturn = $this->fncReporteRemuneracionPdf($dataExcel);
		}
		return $dtReturn;
	}

	public function fncReporteRemuneracionPdf($dataExcel)
  {
    if(fncGeneralValidarDataArray($dataExcel)){
     
      if( fncGeneralValidarDataArray($dataExcel) ){
        //_Obtenemos los parametros de la TABLA
        $parametrosReporte = $dataExcel;
        //_Titulo del Reporte
        
          $reporteTitulo = "Reporte Pedido Compra";
      
        //_Manda al TEMPLATE
        ob_start();
        require('../../Templates/Escalafon/ReporteRemuneracion.php');
        $plantilla = ob_get_contents();
        ob_get_clean();
        //_Salida al PDF
        try{
          $optArchivo = "";
       
          $optArchivo = cls_rutas::get('reporteRemuneracionPdf')."Reporte_Remuneracion.pdf";
         
          $dompdf = new Dompdf();
          $dompdf->set_option('defaultFont', 'Calibri');
          $dompdf->set_paper('A4', 'landscape'); // portrait, landscape
          $dompdf->loadHtml($plantilla);
          $dompdf->render();
          $output = $dompdf->output();
          file_put_contents($optArchivo, $output);
          return $optArchivo;
        } catch (Exception $e) {
          return false;
        }
      }else{
        return false;
      }
    }else{
      return false;
    }
  }

	public function fncGenerarReporteExcelInformeRemuneracion($arrayInputs)
	{

		$dtReturn = array();
		$dataExcel = array();
		$dataTotales = array();
		$dtListadoContarLicencias = array();
		$inputIdTipoTrabajador = (Int)fncObtenerValorArray($arrayInputs, 'idTipotrabajador', true);
		$inputAnio = fncObtenerValorArray($arrayInputs, 'anio', true);
		$inputMes = fncObtenerValorArray($arrayInputs, 'mes', true);
		$dtListado = $this->fncGenerarReporteExcelInformeRemuneracionBD($inputIdTipoTrabajador,$inputAnio,$inputMes);
		$sumaLicenciaVacaciones=$sumaLicenciaPersonal=$sumaLicenciaParticular=$sumaNoMarcoEntrada=$sumaNoMarcoSalida=$suma30m=0;
		$sumaDiasLicParticular=$sumaDiasLicPersonal=$sumaDiasLicVacaciones=0;

		if (fncGeneralValidarDataArray($dtListado)) {
			
			foreach ($dtListado as $listado) {
				$dtListadoContarLicencias = array_shift($this->fncBuscarCantarLicenciasMesTrabajadorBD($inputAnio,$inputMes,$listado->idTrabajador));
				$cantidadLicEnfermedad=$fechaLicVacacion=$fechaLicPersonal=$fechaLicParticular=$diaInicioTermino=$particular=$personal=$vacaciones='';

				$licEnDiasVacacion = $licEnDiasParticular = $licEnDiasEnfermedad = '';
				if (count($dtListadoContarLicencias)>0) {
					//$diaInicioTermino=$dtListadoContarLicencias->diaInicioTermino;


					$primerDia = date("Y-m-01", strtotime("$inputAnio-$inputMes"));
					$ultimoDia= date('Y-m-t', strtotime("$inputAnio-$inputMes"));

					$dtDiasLicencias = array_shift($this->fncBuscarLicenciasDiaslBD($listado->idTrabajador,$primerDia,$ultimoDia));
					$licEnDiasVacacion = $dtDiasLicencias->diasVacacion;
					$licEnDiasParticular = $dtDiasLicencias->diasParticular;
					$licEnDiasEnfermedad = $dtDiasLicencias->diasEnfermedad;


					$particular=$dtListadoContarLicencias->particular;
					$personal=$dtListadoContarLicencias->personal;
					$vacaciones=$dtListadoContarLicencias->vacaciones;

					$sumaDiasLicParticular=$dtListadoContarLicencias->diasLicParticular;
					$sumaDiasLicPersonal=$dtListadoContarLicencias->diasLicPersonal;
					$sumaDiasLicVacaciones=$dtListadoContarLicencias->diasLicVacacion;

					$fechaLicParticular=implode(',',(array_filter(json_decode( $dtListadoContarLicencias->fechaLicParticular))));
					$fechaLicPersonal=implode(',',(array_filter(json_decode( $dtListadoContarLicencias->fechaLicPersonal))));
					$fechaLicVacacion=implode(',',(array_filter(json_decode( $dtListadoContarLicencias->fechaLicVacacion))));

				}
				$cantidadDentroDelos30Min = ($this->fncContarLlegadaDentroDeLos30MinBD($listado->idTrabajador,$inputAnio,$inputMes) );
				$cantidadDentroDelos30Min = array_shift($cantidadDentroDelos30Min);
				$model = array();

				$model["idTrabajador"]        			= $listado->idTrabajador;
				$model["nombreApellido"]  				= $listado->nombreApellido;

				$model["diasLicParticular"]  		= $sumaDiasLicParticular;
				$model["diasLicPersonal"]  			= 0;
				$dtLicenciaEnfermedad = ($this->fncBuscarContarLicenciaEnfermedadTrabajadorBD( $inputAnio,$inputMes,$listado->idTrabajador));				
				if (count($dtLicenciaEnfermedad)>0) {
					$dtLicenciaEnfermedad = array_shift($dtLicenciaEnfermedad);
					$fechaLicEnfermedad=implode(',',(array_filter(json_decode( $dtLicenciaEnfermedad->fechaLicenciaParticular))));
					$cantidadLicEnfermedad=$dtLicenciaEnfermedad->cantidadLic;

				}
				$model["diasLicVacaciones"]  		= $sumaDiasLicVacaciones;

				$model["fechaTardanza"]         		= implode(',',(array_filter(json_decode( $listado->fechaTardanza))));
				$model["fechaNoMarcoEntrada"]   		= implode(',',(array_filter(json_decode( $listado->fechaNoMarcoEntrada))));
				$model["fechaNoMarcoSalida"]   			= implode(',',(array_filter(json_decode( $listado->fechaNoMarcoSalida))));
				$model["noMarcoEntrada"]  				= (Int)$listado->noMarcoEntrada;
				$model["noMarcoSalida"]              	= (Int)$listado->noMarcoSalida;
				$model["+30m"]							= $listado->cantidadTardanza; //supero los 30 min de tolerancia
				//$model["cantidadTardanza"]              = $listado->cantidadTardanza;
				$model["dentro30Min"]            		= $cantidadDentroDelos30Min->llegadaDentroDelos30Min;
				
				$model["cantidadTardanzaEnHoras"]       = $listado->cantidadTardanzaEnHoras;
				$model["diaInicioTermino"]				= $diaInicioTermino;
				$model["licenciaParticular"]			= (Int)$licEnDiasParticular;
				$model["licenciaPersonal"]				= (Int)$licEnDiasEnfermedad;
				$model["licenciaVacacion"]				= (Int)$licEnDiasVacacion;
				$model["totalLicencias"]				= $model["licenciaParticular"]+$model["licenciaPersonal"]+$model["licenciaVacacion"];

				$model["fechaLicParticular"]			= $fechaLicParticular;
				$model["fechaLicPersonal"]				= $fechaLicEnfermedad;
				$model["fechaLicVacacion"]				= $fechaLicVacacion;

				$dtSueldo = array_shift($this->fncBuscarSueldoTrabajador($listado->idTrabajador));
				$sueldo = 0;
				if (count($dtSueldo)>0) {
					$sueldo = floatval ( $dtSueldo->sueldo);
				}

				$model["sueldo"]						= $sueldo;
				array_push($dataExcel, $model);

				$sumaLicenciaVacaciones+=$model["licenciaVacacion"];
				$sumaLicenciaPersonal+=$model["licenciaPersonal"];
				$sumaLicenciaParticular+=$model["licenciaParticular"];
				$sumaNoMarcoEntrada+=$model["noMarcoEntrada"];
				$sumaNoMarcoSalida+=$model["noMarcoSalida"];
				$suma30m+=$model["+30m"];
			}
			$dtReturn = $dataExcel;
			$dataTotales["sumaLicenciaVacaciones"] = $sumaLicenciaVacaciones;
			$dataTotales["sumaLicenciaPersonal"] = $sumaLicenciaPersonal;
			$dataTotales["sumaLicenciaParticular"] = $sumaLicenciaParticular;
			$dataTotales["sumaNoMarcoEntrada"] = $sumaNoMarcoEntrada;
			$dataTotales["sumaNoMarcoSalida"] = $sumaNoMarcoSalida;
			$dataTotales["suma30m"] = $suma30m;
			$dtReturn = $this->fncReporteExcel($dataExcel,$dataTotales);
		}
		return $dtReturn;
	}
	public function fncReporteExcel($dataReporte,$totalesReporte)  {
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
    //$objPHPExcel->getActiveSheet()->getStyle('B2:G2')->applyFromArray($estiloTituloReporte);
    //$objPHPExcel->getActiveSheet()->getStyle('B3:G3')->applyFromArray($estiloSubTituloReporte);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:W2');
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10.71);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(28.43);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(39.29);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(46.57);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10.71);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10.71);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15.71);
    
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2','REPORTE DE REMUNERACION');
	//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H2','=ALEATORIO.ENTRE(4, 9)');
	
	
	/* merge cabeceras */
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B4:B6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C4:C6');

	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D4:F4');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D5:D6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E5:E6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('F5:F6');

	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('G4:J4');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('G5:G6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('H5:H6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('I5:I6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('J5:J6');

	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('K4:L4');

	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('M4:M6');

	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('N4:P4');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('N5:N6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('O5:O6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('P5:P6');


	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('Q4:S4');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('Q5:Q6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('R5:R6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('S5:S6');

	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('T4:T6');

	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('U4:V4');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('U5:U6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('V5:V6');

	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('W4:W6');

	
	
	$fila = 7;
	
	$filaContador = 0;
	if( fncGeneralValidarDataArray($dataReporte) ){


		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4','REG');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4','APELLIDOS Y NOMBRES');

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D4','LICENCIA EN DIAS');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D5','VACACIONES');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E5','ENFERMEDAD');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F5','POR PARTICULAR');

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G4','FALTA POR MARCACION');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G5','NUMERO NME');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H5','NUMERO NMS');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I5','NUMERO +30M');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J5','TOTAL');

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K4','TARDANZAS');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K6','NUM. TARDANZAS');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L6','TARDANZAS EN HORAS');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M4','REMUNERACION POR DIA');

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N4','LICENCIAS');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N5','FECH. LIC. VACACIONES');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O5','FECH. LIC. ENFERMEDAD');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P5','FECH. LIC. PARTICUALARES');

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q4','FALTAS POR MARCACION');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q5','FECH. FALT. NO MARCO ENTRADA');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R5','FECH. FALT. NO MARCO SALIDA');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S5','FECH. FALT. MAS DE 30 MIN');

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T4','REMUNERACION');

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U4','DESCUENTOS');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U5','DESC. +30/NME/NMS');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V5','DESC. TARDANZA');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W4','TOTAL');

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('X16:Y16');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('Z16:Z17');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X16','TARDANZA');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X17','DESDE');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y17','HASTA');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z16','TARDANZA EN HORAS');
		$objPHPExcel->getActiveSheet()->getStyle('Z16') ->getAlignment()->setWrapText(true); 

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X18',0);

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X18',0);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X19',6);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X20',12);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X21',18);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X22',30);
	
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y18',5);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y19',11);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y20',17);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y21',24);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y22',60);

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z18',0);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z19',2);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z20',4);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z21',6);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z22',8);
		$objPHPExcel->getActiveSheet()->getStyle('X16:Z22')->applyFromArray($estiloTodoLosBordes); 


		/**cabecera en negrita */
		$objPHPExcel->getActiveSheet()->getStyle('B4:W6')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B4:W6')->applyFromArray($estiloTarea); 
		$objPHPExcel->getActiveSheet()->getStyle('B4:W6')->applyFromArray($estiloTodoLosBordes); 
		

		/* DISMUNUIR DIMENSION COLUMAN D */
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);

		/* DISMUNUIR DIMENSION COLUMAN B */
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);

		$reg =1;
		foreach ($dataReporte as $listado) {

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$fila,$reg++);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$fila,($listado['nombreApellido']));

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$fila,$listado['licenciaVacacion']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,$listado['licenciaPersonal']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$fila,$listado['licenciaParticular']);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$fila,$listado['noMarcoEntrada']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$fila,$listado['noMarcoSalida']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$fila,$listado['+30m']);

			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$fila,$listado['noMarcoEntrada']+$listado['noMarcoSalida']+$listado['+30m']);

			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$fila,$listado['dentro30Min']); // hora entre el horaio de ingreso y antes de 30 min
			$tardanzaEnhoras = '=IF(K'.$fila.'=0,0,INDIRECT("Z"&SUMPRODUCT(--($X$18:$X$22<=K'.$fila.')*($Y$18:$Y$22>=K'.$fila.'), ROW($Z$18:$Z$22))))';
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$fila,$tardanzaEnhoras);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$fila,'=ROUND(T'.$fila.'/31,2)');//remuneracion x dia
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$fila,$listado['fechaLicVacacion']);//listado de fechas de licencias por vacaciones
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$fila,$listado['fechaLicPersonal']);//listado de fechas de licencias personales
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$fila,$listado['fechaLicParticular']);//listado de fechas de licencias particulares

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$fila,$listado['fechaNoMarcoEntrada']);//listado de fechas donde el trabajador no marco la entrada
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$fila,$listado['fechaNoMarcoSalida']);//listado de fechas donde el trabajador no marco la salida
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$fila,$listado['fechaTardanza']);//listado de fechas donde le trabajador llego tarde
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$fila,$listado['sueldo']); //REMUNERACION

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$fila,'=(M'.$fila.'*J'.$fila.')+(M'.$fila.'*F'.$fila.')');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$fila,'=IFERROR( (M'.$fila.'*L'.$fila.'/8),0)');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.$fila,'=U'.$fila.'+V'.$fila);

		$fila++;
			
		}

		$totalesReporte;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$fila,$totalesReporte['sumaLicenciaVacaciones']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$fila,$totalesReporte['sumaLicenciaPersonal']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$fila,$totalesReporte['sumaLicenciaParticular']);

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$fila,$totalesReporte['sumaNoMarcoEntrada']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$fila,$totalesReporte['sumaNoMarcoSalida']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$fila,$totalesReporte['suma30m']);

		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$fila,'=SUM(J7:J'.($fila-1).')');

		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$fila,'=SUM(k7:k'.($fila-1).')'); // hora entre el horaio de ingreso y antes de 30 min
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$fila,'=SUM(L7:L'.($fila-1).')');

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$fila,$listado['fechaTardanza']);//listado de fechas donde le trabajador llego tarde
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$fila,'TOTAL S/.'); //REMUNERACION

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$fila,'=SUM(U7:U'.($fila-1).')');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$fila,'=SUM(V7:V'.($fila-1).')');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.$fila,'=SUM(W7:W'.($fila-1).')');

		
		

		  $objPHPExcel->getActiveSheet()->getStyle('B'.$fila.':W'.$fila)->applyFromArray($estiloTodoLosBordes); 

	}

    $objPHPExcel->setActiveSheetIndex(0);
    
    try{

		

      $optArchivo = cls_rutas::get('reporteControlAsistenciaRemuneracionExcel')."reporte_general.xlsx";
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
	public function fncBuscarPorDocumento($arrayInputs)
	{

		$dtReturn = array();
		$listaAuditoria = array();
		$documentoIdentidad = fncObtenerValorArray($arrayInputs, 'documento_identidad', true);
		$dtListado = $this->fncBuscarPorDocumentoBD($documentoIdentidad);
		$accion = 4;

		if (fncGeneralValidarDataArray($dtListado)) {

			foreach ($dtListado as $listado) {


				$model = array();
				$model["idMerito"]        			= $listado->idMerito;
				$model["idTrabajador"]         	= $listado->idTrabajador;
				$model["nombreCompleto"]        	= $listado->nombreCompleto;
				$model["idTipoDocumentoMerito"]  = $listado->idTipoDocumentoMerito;
				$model["tipoDocumentoMerito"]  	= $listado->tipoDocumentoMerito;				
				$model["fechaDocumento"]   		= fncFormatearFecha($listado->fechaDocumento);
				$model["dias"]  					= $listado->dias;
				$model["documento"]              	= $listado->documento;
				$model["fechaEvento"]              = fncFormatearFecha($listado->fechaEvento);
				$model["archivo"]		            = $listado->archivo;
				$model["eliminado"]		            = $listado->eliminado;
				$model["fechaHoraAuditoria"]		= ($listado->fechaHoraAuditoria);
				$model["usuarioAuditoria"]			= $listado->usuarioAuditoria;


				array_push($dtReturn, $model);
				array_push($listaAuditoria, $model['id_merito']);
			}

			$auditorioController = new AuditoriaController();
			$auditoria = $auditorioController->fncGuardar($accion, 'merito', 'id_merito', null, json_encode($listaAuditoria));
		}
		return $dtReturn;
	}
	

	public function fncGuardarCsv( $archivoInput = '')
	{

		$dtParaModelo=$dataExcel=$dataBusqueda=$dtRetorno=$dtHorarios=array();
		$file = $archivoInput['tmp_name'];
		$registros = parse_csv_file($file);	
		$dtReturn = $registros;	
		
		foreach ($dtReturn as  $value) {			
			$registro = array(
				'fecha'=>$value['Fecha'],
				'id'=> str_replace(' ','',$value['ID']),
				'nombreUsuario'=>$value['Nombre Usuario'],
				'departamento'=>$value['Departamento'],
				'entraSale1'=>$value['Entra-Sale 1'],
				'entraSale2'=>$value['Entra-Sale 2'],
				'entraSale3'=>$value['Entra-Sale 3'],
				'entraSale4'=>$value['Entra-Sale 4'],
				'entraSale5'=>$value['Entra-Sale 5'],
				'entraSale6'=>$value['Entra-Sale 6'],
				'entraSale7'=>$value['Entra-Sale 7'],
				'entraSale8'=>$value['Entra-Sale 8'],
				'descanso'=>$value['Descanso'],
				'trabajo'=>$value['Trabajado']
			);
			array_push($dataExcel,$registro);
		}
		$agruparIdreloj = _group_by($dataExcel,'id');		
		$cadenaId = strval(fncObtenerIndices($agruparIdreloj));//id de  horarios para consulta
		$dataBusqueda = $this->fncBuscarIdHorarioTrabajadorRelojBD($cadenaId);
		if (fncGeneralValidarDataArray($dataBusqueda)) {
			foreach ($dataBusqueda as $listado) {

				$model = array();
				$model["idHorarioTrabajador"]        		= $listado->idHorarioTrabajador;
				$model["idTrabajador"]        	= $listado->idTrabajador;
				$model["idTrabajadorReloj"] 		= $listado->idTrabajadorReloj;
				$model["horaIngreso"]         		= $listado->horaIngreso;
				$model["horaSalida"]   			= $listado->horaSalida;
			
				array_push($dtHorarios, $model);
				//array_push($listaAuditoria, $model['id_merito']);
			}
			$registroProcesados=array();//aquellos registro que tengan al menos una entradam (aceptado=que se insertaran, no aceptado= que no se encontro el horario de trabajador creado)
			foreach ($dataExcel as $value) {
				$model=array();				
				$entrada=$salida=$entradaSalidaCadena=$entradaSalida='';
				if ($value['entraSale1']!='00:00') {$entradaSalidaCadena.=$value['entraSale1'].',';}
				if ($value['entraSale2']!='00:00') {$entradaSalidaCadena.=$value['entraSale2'].',';}
				if ($value['entraSale3']!='00:00') {$entradaSalidaCadena.=$value['entraSale3'].',';}
				if ($value['entraSale4']!='00:00') {$entradaSalidaCadena.=$value['entraSale4'].',';}
				if ($value['entraSale5']!='00:00') {$entradaSalidaCadena.=$value['entraSale5'].',';}
				if ($value['entraSale6']!='00:00') {$entradaSalidaCadena.=$value['entraSale6'].',';}
				if ($value['entraSale7']!='00:00') {$entradaSalidaCadena.=$value['entraSale7'].',';}
				if ($value['entraSale8']!='00:00') {$entradaSalidaCadena.=$value['entraSale8'].',';}
				$entradaSalida = explode(',',$entradaSalidaCadena);
				$contarMarcaciones = count($entradaSalida)-1;				
				if ($contarMarcaciones>0) {
					if ($contarMarcaciones ==1) {
						$entrada = $entradaSalida[0];
						//$salida = $entradaSalida[0];
						$salida = '';
					}
					else{
						$entrada = $entradaSalida[0];
						$salida = $entradaSalida[$contarMarcaciones-1];
					}
				}
				$idTrabajador = array_search($value['id'], array_column($dtHorarios, 'idTrabajadorReloj'));
				if ($idTrabajador!==false &&$contarMarcaciones>0) {
					$model['idTrabajador']	= (Int)$dtHorarios[$idTrabajador]['idTrabajador'];
					$model['idTrabajadorReloj']	= (Int)$value['id'];
					$model['fecha']			= $value['fecha'];
					$model['entrada']		= $entrada;
					$model['salida']		= $salida;
					$model['insertado']		= 1;
					array_push($registroProcesados,$model);
				}
				else{
					$model['idTrabajador']	= 0;
					$model['idTrabajadorReloj']	= (Int)$value['id'];
					$model['fecha']				= $value['fecha'];
					$model['entrada']			= $entrada;
					$model['insertado']		= 0;
					array_push($registroProcesados,$model);
				}
				 
			}


			
		}

		
		$dtRetorno=$registroProcesados;
		$dtGuardar = $this->fncGuardar($registroProcesados);

		return $dtRetorno;
	}

	public function fncProcesarXlsXlsx($archivoInput = ''){

		$array = explode('.', $archivoInput['name']);
		$extension = end($array);

		$dtReturn = array();

		switch ($extension) {
			case 'csv':
				$dtReturn = $this->fncGuardarCsv($archivoInput);
				break;
			case 'xls':
				$dtReturn = $this->fncGuardarXls($archivoInput);
				break;
			case 'xlsx':
				$dtReturn = $this->fncGuardarXlsx($archivoInput);
				break;
		
		}

		return $dtReturn;
	}

	

	public function fncGuardarXls( $archivoInput = '')
	{
		$dtReturn = array();
		$dtReturna = array();
		$dtHorarios=array();
		$file = $archivoInput['tmp_name'];
	/*	if ( $xlsx = SimpleXLSX::parse($file) ) {
			$dtReturn = ( $xlsx->rows() );
		} else {
			echo SimpleXLSX::parseError();
		}*/


		if ( $xls = SimpleXLS::parse($file) ) {
			$dtReturn = (( $xls->rows()) );
		} else {
			echo SimpleXLS::parseError();
		}
		$primero =1;
	
		foreach ($dtReturn as  $value) {
			if ($primero==1) {
				
			}else{

				$registros = array(
					'no'=>$value[0],
					'ac'=>$value[1],
					'cedula'=>$value[2],
					'nombre'=> fncLimpiarString(utf8_decode($value[3])) ,
					'AutoAsigna'=>$value[4],
					'fecha'=>$value[5],
					'horario'=>$value[6],
					'horaEnt'=>$value[7],
					'horaSal'=>$value[8],
					'marcEnt'=>$value[9],
					'marcSal'=>$value[10],
					'normal'=>$value[11],
					'tiempoReal'=>$value[12],
					'tardanza'=>$value[13],
					'salioTempr'=>$value[14],
					'falta'=>$value[15],
					'horaExtra'=>$value[16],
					'workTime'=>$value[17],
					'excepcion'=>$value[18],
					'debeIn'=>$value[19],
					'debeSal'=>$value[20],
					'depto'=>$value[21],
					'nDays'=>$value[22],
					'finSemana'=>$value[23],
					'feriado'=>$value[24],
					'tiemAsist'=>$value[25],
					'nDiasOt'=>$value[26],
					'finSemanaOt'=>$value[27],
					'feriadoOt'=>$value[28]
				  );	
		
				  array_push($dtReturna,$registros);
			}
		  
		$primero++;
		}
		$agruparIdreloj = _group_by($dtReturna,'ac');
		$cadenaId = strval(fncObtenerIndices($agruparIdreloj));
		$dataBusqueda = $this->fncBuscarIdHorarioTrabajadorRelojBD($cadenaId);

		if (fncGeneralValidarDataArray($dataBusqueda)) {
			foreach ($dataBusqueda as $listado) {

				$model = array();
				$model["idHorarioTrabajador"]        		= $listado->idHorarioTrabajador;
				$model["idTrabajador"]        	= $listado->idTrabajador;
				$model["idTrabajadorReloj"] 		= $listado->idTrabajadorReloj;
				$model["horaIngreso"]         		= $listado->horaIngreso;
				$model["horaSalida"]   			= $listado->horaSalida;
			
				array_push($dtHorarios, $model);
				//array_push($listaAuditoria, $model['id_merito']);
			}
			$registroProcesados=array();//aquellos registro que tengan al menos una entradam (aceptado=que se insertaran, no aceptado= que no se encontro el horario de trabajador creado)
			foreach ($dtReturna as $value) {
				$model=array();				
				$entrada=$salida=$entradaSalidaCadena=$entradaSalida='';
			
				$idTrabajador = array_search($value['ac'], array_column($dtHorarios, 'idTrabajadorReloj'));
				if ($value['marcEnt']!='') {$entrada=$value['marcEnt'];}
				if ($value['marcSal']!='') {$salida=$value['marcSal'];}
				$contarMarcaciones=0;
				if ($entrada==''&&$salida=='') {
					
				}else{
					$contarMarcaciones =1;
				}
				
				if ($idTrabajador!==false && $contarMarcaciones==1) {
					$model['idTrabajador']	= (Int)$dtHorarios[$idTrabajador]['idTrabajador'];
					$model['idTrabajadorReloj']	= (Int)$value['ac'];
					$model['fecha']			= $value['fecha'];
					$model['entrada']		= $entrada;
					$model['salida']		= $salida;
					$model['insertado']		= 1;
					array_push($registroProcesados,$model);
				}
				else{
					$model['idTrabajador']	= 0;
					$model['idTrabajadorReloj']	= (Int)$value['ac'];
					$model['fecha']				= $value['fecha'];
					$model['entrada']			= $entrada;
					$model['salida']			= $salida;
					$model['insertado']		= 0;
					array_push($registroProcesados,$model);
				}
				 
			}

			$dtRetorno=$registroProcesados;
			$dtGuardar = $this->fncGuardar($registroProcesados);
			$dtReturna = $dtRetorno;
		}
	
		return ( $dtReturna);
	}

	public function fncGuardarXlsx( $archivoInput = '')
	{
		$dataBusqueda=$dtReturn =$dtReturna= array();
		$dtHorarios=array();
		$file = $archivoInput['tmp_name'];
		if ( $xlsx = SimpleXLSX::parse($file) ) {
			$dataExcel = ( $xlsx->rows() );
		} else {
			echo SimpleXLSX::parseError();
		}

		$primero =1;
	
		foreach ($dataExcel as  $value) {
			if ($primero==1) {
				
			}else{

				$registros = array(
					'no'=>$value[0],
					'ac'=>$value[1],
					'cedula'=>$value[2],
					'nombre'=> fncLimpiarString(utf8_decode($value[3])) ,
					'AutoAsigna'=>$value[4],
					'fecha'=>$value[5],
					'horario'=>$value[6],
					'horaEnt'=>$value[7],
					'horaSal'=>$value[8],
					'marcEnt'=>$value[9],
					'marcSal'=>$value[10],
					'normal'=>$value[11],
					'tiempoReal'=>$value[12],
					'tardanza'=>$value[13],
					'salioTempr'=>$value[14],
					'falta'=>$value[15],
					'horaExtra'=>$value[16],
					'workTime'=>$value[17],
					'excepcion'=>$value[18],
					'debeIn'=>$value[19],
					'debeSal'=>$value[20],
					'depto'=>$value[21],
					'nDays'=>$value[22],
					'finSemana'=>$value[23],
					'feriado'=>$value[24],
					'tiemAsist'=>$value[25],
					'nDiasOt'=>$value[26],
					'finSemanaOt'=>$value[27],
					'feriadoOt'=>$value[28]
				  );	
		
				  array_push($dtReturna,$registros);
			}
		  
		$primero++;
		}
		$agruparIdreloj = _group_by($dtReturna,'ac');
		$cadenaId = strval(fncObtenerIndices($agruparIdreloj));
		$dataBusqueda = $this->fncBuscarIdHorarioTrabajadorRelojBD($cadenaId);

		if (fncGeneralValidarDataArray($dataBusqueda)) {
			foreach ($dataBusqueda as $listado) {

				$model = array();
				$model["idHorarioTrabajador"]        		= $listado->idHorarioTrabajador;
				$model["idTrabajador"]        	= $listado->idTrabajador;
				$model["idTrabajadorReloj"] 		= $listado->idTrabajadorReloj;
				$model["horaIngreso"]         		= $listado->horaIngreso;
				$model["horaSalida"]   			= $listado->horaSalida;
			
				array_push($dtHorarios, $model);
				//array_push($listaAuditoria, $model['id_merito']);
			}
			$registroProcesados=array();//aquellos registro que tengan al menos una entradam (aceptado=que se insertaran, no aceptado= que no se encontro el horario de trabajador creado)
			foreach ($dtReturna as $value) {
				$model=array();				
				$entradaSalidaCadena=$entradaSalida='';
				$entrada='';
				$salida='';
				$idTrabajador = array_search($value['ac'], array_column($dtHorarios, 'idTrabajadorReloj'));
				if ($value['marcEnt']!='') {$entrada=$value['marcEnt'];}
				if ($value['marcSal']!='') {$salida=$value['marcSal'];}
				$contarMarcaciones=0;
				if ($entrada==''&&$salida=='') {
					
				}else{
					$contarMarcaciones =1;
				}
				
				if ($idTrabajador!==false && $contarMarcaciones==1) {
					$model['idTrabajador']	= (Int)$dtHorarios[$idTrabajador]['idTrabajador'];
					$model['idTrabajadorReloj']	= (Int)$value['ac'];
					$model['fecha']			= $value['fecha'];
					$model['entrada']		= $entrada;
					$model['salida']		= $salida;
					$model['insertado']		= 1;
					array_push($registroProcesados,$model);
				}
				else{
					$model['idTrabajador']	= 0;
					$model['idTrabajadorReloj']	= (Int)$value['ac'];
					$model['fecha']				= $value['fecha'];
					$model['entrada']			= $entrada;
					$model['salida']			= $salida;
					$model['insertado']		= 0;
					array_push($registroProcesados,$model);
				}
				 
			}

			$dtRetorno=$registroProcesados;
			$dtGuardar = $this->fncGuardar($registroProcesados);
			
			$dtReturna = $dtRetorno;
		}
	
		return ( $dtReturna);
	}

	public function fncGuardar($registroProcesados)
	{
		$dtReturn = array();
		$accion = 0;
	
		
		foreach ($registroProcesados as $value) {
			$dtControlAsistencia = new ControlAsistencia;
			if ($value['insertado']==1) {
				$idTrabajador	=$value['idTrabajador'];	
				$fecha			=fncFormatearFecha($value['fecha']);
				$horaIngreso	=$value['entrada'];
				$horaSalida		=$value['salida'];

				if (!empty($idTrabajador)) {$dtControlAsistencia->setIdTrabajador($idTrabajador);}
				if (!empty($fecha)) {$dtControlAsistencia->setFecha($fecha);}
				if (!empty($horaIngreso)) {	$dtControlAsistencia->setHoraIngreso($horaIngreso);}
				if (!empty($horaSalida)) {$dtControlAsistencia->setHoraSalida($horaSalida);}
				
				if (fncGeneralValidarDataArray($dtControlAsistencia)) {
					$dtGuardar = array();
					$dtGuardar = $this->fncRegistrarBD($dtControlAsistencia);
					$accion = 1;
					
					if (fncGeneralValidarDataArray($dtGuardar)) {
						/*$model = array();
						$model["idControlAsistencia"]   = $dtGuardar->getIdControlAsistencia();
						$model["idTrabajador"]        	= $dtGuardar->getIdTrabajador();
						$model["fecha"]  				= $dtGuardar->getFecha();
						$model["horaIngreso"]         	= $dtGuardar->getHoraIngreso();
						$model["horaIalida"]   		= $dtGuardar->getHoraSalida();
						array_push($dtReturn, $model);
						$auditorioController = new AuditoriaController();
						$auditoria = $auditorioController->fncGuardar($accion, 'control_asistencia', 'id_control_asistencia', $model["idControlAsistencia"], json_encode($model));
						unset($model);*/
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

				$dtMerito = $this->fncListarRegistroMeritoAuditoria($id);
				$bolReturn = $dtMerito;

				$auditorioController = new AuditoriaController();
				$auditoria = $auditorioController->fncGuardar(2, 'merito', 'id_merito', $id, json_encode($dtMerito));
			}
		}
		return $bolReturn;
	}



	public function fncGenerarReporteInformeRemuneracionPruebaVista($arrayInputs)  // para prueba en el servidor
	{
		$dtReturn = array();
		$dataExcel = array();
		$dataTotales = array();
		$dtListadoContarLicencias = array();
		$inputIdTipoTrabajador = (Int)fncObtenerValorArray($arrayInputs, 'idTipotrabajador', true);
		$inputAnio = fncObtenerValorArray($arrayInputs, 'anio', true);
		$inputMes = fncObtenerValorArray($arrayInputs, 'mes', true);
		//$dtListado = $this->fncGenerarReporteExcelInformeRemuneracionBD($inputIdTipoTrabajador,$inputAnio,$inputMes);
		$sumaLicenciaVacaciones=$sumaLicenciaPersonal=$sumaLicenciaParticular=$sumaNoMarcoEntrada=$sumaNoMarcoSalida=$suma30m=0;
		$sumaDiasLicParticular=$sumaDiasLicPersonal=$sumaDiasLicVacaciones=0;
		$primerDia = date("Y-m-01", strtotime("$inputAnio-$inputMes"));
		$ultimoDia= date('Y-m-t', strtotime("$inputAnio-$inputMes"));

		$dtDiasLicencias = ($this->fncPruebaBD($inputIdTipoTrabajador,$primerDia,$ultimoDia));
		if (fncGeneralValidarDataArray($dtDiasLicencias)) {

		$dtReturn = $dtDiasLicencias;
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
		WHERE (:id_merito = -1 OR m.id_merito = :id_merito) AND m.eliminado = 0
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



	private function fncBuscarLicenciaEnfermedadReporteIndividualBD($inputIdTrabajador,$inputFechaInicio,$inputFechaTermino,$fechaBuscar)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			le.id_licencia_enfermedad,
			--le.id_trabajador,
			--le.id_servicio,
			--le.id_tipo_atencion,
			--le.id_contingencia,
			--le.citt,
			le.fecha_inicio,
			le.fecha_termino
			--le.dias,
			--le.archivo,
			--le.eliminado
		FROM
			escalafon.licencia_enfermedad AS le
		WHERE le.eliminado = 0 AND le.id_trabajador = :id_trabajador  
		--AND ((le.fecha_inicio >= :fecha_inicio AND le.fecha_inicio <= :fecha_termino)AND (le.fecha_termino >= :fecha_inicio AND le.fecha_termino <= :fecha_termino) )
		AND (le.fecha_inicio <= :fecha_buscar AND le.fecha_termino >= :fecha_buscar)
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_trabajador', $inputIdTrabajador);
			//$statement->bindParam('fecha_inicio', $inputFechaInicio);
//$statement->bindParam('fecha_termino', $inputFechaTermino);
			$statement->bindParam('fecha_buscar', $fechaBuscar);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new ControlAsistencia;
				$temp->idLicenciaEnfermedad = $datos['id_licencia_enfermedad'];
				$temp->fechaInicio 		= $datos['fecha_inicio'];
				$temp->fechaTermino 		= $datos['fecha_termino'];
			
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}


	private function fncBuscarLicenciasDiaslBD($inputIdTrabajador,$inputFechaInicio,$inputFechaTermino)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT 
			SUM(de.vacacion)AS dias_vacacion,
			SUM(de.particular) AS dias_particular,
			SUM(de.enfermedad) AS dias_enfermedad
		FROM(		
				
		SELECT 

		(SELECT
			CASE
			WHEN COUNT(*)>0 THEN 1
			ELSE 0
			END   
			
		FROM escalafon.licencia_trabajador AS lt 
		WHERE lt.eliminado = 0 and lt.id_trabajador = :id_trabajador  AND lt.id_tipo_licencia = 3
		AND (lt.fecha_inicio <= se.fecha AND lt.fecha_termino >= se.fecha) ) AS vacacion,
		
		(SELECT  
			CASE
			WHEN COUNT(*)>0 THEN 1
			ELSE 0
			END 
		FROM escalafon.licencia_trabajador AS lt 
		WHERE lt.eliminado = 0 and lt.id_trabajador = :id_trabajador  AND lt.id_tipo_licencia = 1
		AND (lt.fecha_inicio <= se.fecha AND lt.fecha_termino >= se.fecha) ) AS particular,
		
		(SELECT  
			CASE
			WHEN COUNT(*)>0 THEN 1
			ELSE 0
			END 
			FROM escalafon.licencia_enfermedad AS le 
		WHERE le.eliminado = 0 and le.id_trabajador = :id_trabajador 
		AND (le.fecha_inicio <= se.fecha AND le.fecha_termino >= se.fecha) ) AS enfermedad
		FROM(		
		SELECT (date_trunc(\'day\', dd):: DATE) AS fecha
		FROM generate_series
				( :fecha_inicio ::timestamp 
				, :fecha_termino ::timestamp
				, \'1 day\'::interval) dd
		) AS se) AS de
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_trabajador', $inputIdTrabajador);
			$statement->bindParam('fecha_inicio', $inputFechaInicio);
			$statement->bindParam('fecha_termino', $inputFechaTermino);
			//$statement->bindParam('fecha_buscar', $fechaBuscar);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new ControlAsistencia;
				$temp->diasVacacion 		= $datos['dias_vacacion'];
				$temp->diasParticular 		= $datos['dias_particular'];
				$temp->diasEnfermedad 		= $datos['dias_enfermedad'];
			
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}


	private function fncPruebaBD($inputIdTrabajador,$inputFechaInicio,$inputFechaTermino)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT 
			*
		FROM(		
				
		SELECT 

		(SELECT
			CASE
			WHEN COUNT(*)>0 THEN 1
			ELSE 9
			END   
			
		FROM escalafon.licencia_trabajador AS lt 
		WHERE lt.eliminado = 0 and lt.id_trabajador = :id_trabajador  AND lt.id_tipo_licencia = 3
		AND (lt.fecha_inicio <= se.fecha AND lt.fecha_termino >= se.fecha) ) AS vacacion,
		
		(SELECT  
			CASE
			WHEN COUNT(*)>0 THEN 1
			ELSE 9
			END 
		FROM escalafon.licencia_trabajador AS lt 
		WHERE lt.eliminado = 0 and lt.id_trabajador = :id_trabajador  AND lt.id_tipo_licencia = 1
		AND (lt.fecha_inicio <= se.fecha AND lt.fecha_termino >= se.fecha) ) AS particular,
		
		(SELECT  
			CASE
			WHEN COUNT(*)>0 THEN 1
			ELSE 9
			END 
			FROM escalafon.licencia_enfermedad AS le 
		WHERE le.eliminado = 0 and le.id_trabajador = :id_trabajador 
		AND (le.fecha_inicio <= se.fecha AND le.fecha_termino >= se.fecha) ) AS enfermedad
		FROM(		
		SELECT (date_trunc(\'day\', dd):: DATE) AS fecha
		FROM generate_series
				( :fecha_inicio ::timestamp 
				, :fecha_termino ::timestamp
				, \'1 day\'::interval) dd
		) AS se) AS de
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_trabajador', $inputIdTrabajador);
			$statement->bindParam('fecha_inicio', $inputFechaInicio);
			$statement->bindParam('fecha_termino', $inputFechaTermino);
			//$statement->bindParam('fecha_buscar', $fechaBuscar);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new ControlAsistencia;
				$temp->diasVacacion 		= $datos['vacacion'];
				$temp->diasParticular 		= $datos['particular'];
				$temp->diasEnfermedad 		= $datos['enfermedad'];
			
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}
	private function fncBuscarLicenciaParticularReporteIndividualBD($inputIdTrabajador,$inputFechaInicio,$inputFechaTermino,$fechaBuscar)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			lt.id_licencia_trabajador,
			lt.id_trabajador,
			lt.id_tipo_accion,
			lt.id_tipo_documento,
			lt.id_tipo_licencia,
			(SELECT tl.tipo_licencia FROM escalafon.tipo_licencia AS tl WHERE tl.id_tipo_licencia = lt.id_tipo_licencia),
			lt.documento,
			lt.resolucion,
			lt.fecha_inicio,
			lt.fecha_termino,
			lt.dias,
			lt.archivo,
			lt.eliminado
		FROM
			escalafon.licencia_trabajador AS lt
		WHERE (lt.eliminado = 0 AND lt.id_trabajador = :id_trabajador AND lt.id_tipo_licencia IN (1))
		--AND ((lt.fecha_inicio >= :fecha_inicio AND lt.fecha_inicio <= :fecha_termino)AND (lt.fecha_termino >= :fecha_inicio AND lt.fecha_termino <= :fecha_termino) )
		AND (lt.fecha_inicio <= :fecha_buscar AND lt.fecha_termino >= :fecha_buscar)
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_trabajador', $inputIdTrabajador);
			//$statement->bindParam('fecha_inicio', $inputFechaInicio);
			//$statement->bindParam('fecha_termino', $inputFechaTermino);
			$statement->bindParam('fecha_buscar', $fechaBuscar);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new ControlAsistencia;
				$temp->idLicenciaTrabajador = $datos['id_licencia_trabajador'];
				$temp->fechaInicio 		= $datos['fecha_inicio'];
				$temp->fechaTermino 		= $datos['fecha_termino'];
			
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}


	private function fncBuscarLicenciaVacacionReporteIndividualBD($inputIdTrabajador,$inputFechaInicio,$inputFechaTermino,$fechaBuscar)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			lt.id_licencia_trabajador,
			lt.id_trabajador,
			lt.id_tipo_accion,
			lt.id_tipo_documento,
			lt.id_tipo_licencia,
			(SELECT tl.tipo_licencia FROM escalafon.tipo_licencia AS tl WHERE tl.id_tipo_licencia = lt.id_tipo_licencia),
			lt.documento,
			lt.resolucion,
			lt.fecha_inicio,
			lt.fecha_termino,
			lt.dias,
			lt.archivo,
			lt.eliminado
		FROM
			escalafon.licencia_trabajador AS lt
		WHERE (lt.eliminado = 0 AND lt.id_trabajador = :id_trabajador AND lt.id_tipo_licencia IN (3))
		--AND ((lt.fecha_inicio >= :fecha_inicio AND lt.fecha_inicio <= :fecha_termino)AND (lt.fecha_termino >= :fecha_inicio AND lt.fecha_termino <= :fecha_termino) )
		AND (lt.fecha_inicio <= :fecha_buscar AND lt.fecha_termino >= :fecha_buscar)
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_trabajador', $inputIdTrabajador);
			//$statement->bindParam('fecha_inicio', $inputFechaInicio);
			//$statement->bindParam('fecha_termino', $inputFechaTermino);
			$statement->bindParam('fecha_buscar', $fechaBuscar);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new ControlAsistencia;
				$temp->idLicenciaTrabajador = $datos['id_licencia_trabajador'];
				$temp->fechaInicio 		= $datos['fecha_inicio'];
				$temp->fechaTermino 		= $datos['fecha_termino'];
			
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}

	private function fncReporteAsistenciaIndividualBD($idTrabajador,$fechaInicio,$fechaTermino)
	{
		$sql = cls_control::get_instancia();
		$query = '
		
			select 
			hx.id_trabajador,
			hx.fecha,
			hx.hora_ingreso,
			hx.horario_entrada,
			DATE_PART(\'hour\', hx.hora_ingreso ::time - hx.horario_entrada::time)*60 +DATE_PART(\'minute\',hx.hora_ingreso::time - hx.horario_entrada::time) AS  tardanza_en_minutos,
			hx.hora_salida,
			hx.horario_salida,
			DATE_PART(\'hour\', hx.hora_salida ::time - hx.horario_salida::time)*60 +DATE_PART(\'minute\',hx.hora_salida::time - hx.horario_salida::time) AS  h_extras_en_minutos,
			CASE 
				WHEN hx.hora_ingreso ISNULL   THEN  \'x\' 
				ELSE \'\'
			END AS no_marco_entrada,
			CASE 
				WHEN hx.hora_salida ISNULL   THEN  \'x\' 
				ELSE \'\'
			END AS no_marco_salida,
			CASE 
			WHEN DATE_PART(\'hour\',hx.hora_ingreso::time - hx.horario_entrada::time)*60 +DATE_PART(\'minute\',hx.hora_ingreso::time - hx.horario_entrada::time)<=30  
				 AND DATE_PART(\'hour\',hx.hora_ingreso::time - hx.horario_entrada::time)*60 +DATE_PART(\'minute\',hx.hora_ingreso::time - hx.horario_entrada::time)>0
			THEN \'x\'
			ELSE \'\'
			END AS dentro_tolerancia,
			CASE 
			WHEN DATE_PART(\'hour\',hx.hora_ingreso::time - hx.horario_entrada::time)*60 +DATE_PART(\'minute\',hx.hora_ingreso::time - hx.horario_entrada::time)>30  THEN \'x\'
			ELSE \'\'
			END AS falta,
			CASE 
				WHEN  ( SELECT	count(lt.id_licencia_trabajador)    
					FROM	escalafon.licencia_trabajador AS lt 
				    WHERE (lt.eliminado = 0 AND lt.id_trabajador = hx.id_trabajador AND lt.id_tipo_licencia =1) 
					 AND (lt.fecha_inicio <= hx.fecha AND lt.fecha_termino >= hx.fecha) )>0 
					 THEN \'Licencia Registrada\'
				ELSE \'\'
			END AS licencia_particular,
			(SELECT	 COUNT(	pv.id_programacion_vacaciones) FROM 	escalafon.programacion_vacaciones AS pv WHERE pv.eliminado = 0 AND pv.anio= date_part(\'YEAR\',hx.fecha) AND pv.mes_efectividad =date_part(\'MONTH\',hx.fecha) ) AS vacaciones 
				FROM (SELECT
			ca.id_control_asistencia,
			ca.id_trabajador,
			ca.id_trabajador_reloj,
			ca.fecha,
			ca.hora_ingreso,
			
			(SELECT	 	ht.hora_ingreso AS horario_ingreso
			FROM 	escalafon.horario_trabajador AS ht 
			WHERE ht.id_trabajador = ca.id_trabajador AND ht.eliminado = 0 AND ht.actual = 1 
			) AS horario_entrada,
			ca.hora_salida,
			(SELECT	 	htr.hora_salida AS horario_ingreso
			FROM 	escalafon.horario_trabajador AS htr 
			WHERE htr.id_trabajador = ca.id_trabajador AND htr.eliminado = 0 AND htr.actual = 1
			) AS horario_salida
			--DATE_PART(\'hour\',rdn.hora_ingreso::time - rdn.horario_ingreso::time)*60 +DATE_PART(\'minute\',rdn.hora_ingreso::time - rdn.horario_ingreso::time)
		FROM
			escalafon.control_asistencia AS ca WHERE ca.id_trabajador = :idTrabajador AND ( ca.fecha >= :fecha_inicio AND ca.fecha <= :fecha_termino)
			) AS hx  ORDER BY hx.fecha ASC

		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('idTrabajador', $idTrabajador);
			$statement->bindParam('fecha_inicio', $fechaInicio);
			$statement->bindParam('fecha_termino', $fechaTermino);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new ControlAsistencia;
				$temp->idTrabajador 	        	= $datos['id_trabajador'];
				$temp->fecha 				= $datos['fecha'];
				$temp->horaIngreso 				= $datos['hora_ingreso'];
				$temp->horarioEntrada			= $datos['horario_entrada'];
				$temp->tardanzaEnMinutos			= $datos['tardanza_en_minutos'];
				$temp->horaSalida				= $datos['hora_salida'];
				$temp->horarioSalida				= $datos['horario_salida'];
				$temp->horasExtrasEnMinutos				= $datos['h_extras_en_minutos'];
				$temp->noMarcoEntrada		= $datos['no_marco_entrada'];
				$temp->noMarcoSalida		= $datos['no_marco_salida'];
				$temp->dentroTolerancia		= $datos['dentro_tolerancia'];
				$temp->falta		= $datos['falta'];
				$temp->licenciaParticular		= $datos['licencia_particular'];
				$temp->vacaciones		= $datos['vacaciones'];
			
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}

	private function fncGenerarReporteExcelInformeRemuneracionBD($idTipoTrabajador,$anio,$mes)
	{
		$sql = cls_control::get_instancia();
		$query = '
		
				SELECT 
				ddn.id_trabajador,
				ddn.nombre_apellido,
				array_to_json(array_agg(ddn.fecha)) AS fecha_tardanza ,
				array_to_json(array_agg(ddn.fecha_no_marco_salida)) AS fecha_no_marco_salida ,
				array_to_json(array_agg(ddn.fecha_no_marco_entrada)) AS fecha_no_marco_entrada ,
				SUM(ddn.no_marco_entrada)AS no_marco_entrada,
				SUM(ddn.no_marco_salida)AS no_marco_salida,
				SUM(ddn.tardanza)AS cantidad_tardanza,
				SUM(ddn.tardanza_en_horas)AS tardanza_en_horas
				FROM(
				SELECT 
				rdn.id_trabajador,
				rdn.nombre_apellido,
				CASE 
					WHEN 
					DATE_PART(\'hour\',rdn.hora_ingreso::time - rdn.horario_ingreso::time)*60 +
					DATE_PART(\'minute\',rdn.hora_ingreso::time - rdn.horario_ingreso::time)>30   THEN to_char(rdn.fecha, \'DD/MM\')
					ELSE \'\'
				END AS fecha ,
				CASE 
					WHEN rdn.no_marco_salida =1  THEN to_char(rdn.fecha, \'DD/MM\')
					ELSE \'\'
				END AS fecha_no_marco_salida ,
				CASE 
					WHEN rdn.no_marco_entrada =1  THEN to_char(rdn.fecha, \'DD/MM\')
					ELSE \'\'
				END AS fecha_no_marco_entrada ,
				rdn.no_marco_entrada,
				rdn.no_marco_salida,
				rdn.hora_ingreso,
				rdn.horario_ingreso,
				--DATE_PART(\'hour\',rdn.hora_ingreso::time - rdn.horario_ingreso::time)*60 +DATE_PART(\'minute\',rdn.hora_ingreso::time - rdn.horario_ingreso::time),
				CASE 
					WHEN DATE_PART(\'hour\',rdn.hora_ingreso::time - rdn.horario_ingreso::time)*60 +DATE_PART(\'minute\',rdn.hora_ingreso::time - rdn.horario_ingreso::time)>30  THEN 1
					ELSE 0
				END AS tardanza,
				CASE 
				WHEN DATE_PART(\'hour\',rdn.hora_ingreso::time - rdn.horario_ingreso::time)*60 +DATE_PART(\'minute\',rdn.hora_ingreso::time - rdn.horario_ingreso::time)>30  
					THEN DATE_PART(\'hour\', hora_ingreso::time - rdn.horario_ingreso::time)
				ELSE 0
			END AS tardanza_en_horas

					FROM(
					SELECT

						pn.apellidos ||\', \'||pn.nombres AS nombre_apellido,
						\' \' AS nro_tardanza,
						CASE 
							WHEN ca.hora_ingreso ISNULL  THEN 1
							ELSE 0
						END AS no_marco_entrada ,
						CASE 
							WHEN ca.hora_salida ISNULL  THEN 1
							ELSE 0
						END AS no_marco_salida,
						--ca.id_trabajador,
						--ca.id_trabajador_reloj,
						ca.fecha,
						ca.hora_ingreso,
						ca.hora_salida,
						t.id_trabajador,
						(SELECT	ht.hora_ingreso	FROM escalafon.horario_trabajador AS ht WHERE ht.id_trabajador = ca.id_trabajador AND ht.actual = 1  AND ht.eliminado =0 LIMIT 1) AS horario_ingreso
					FROM
						escalafon.control_asistencia AS ca
					INNER JOIN escalafon.trabajador AS t ON t.id_trabajador = ca.id_trabajador
					INNER JOIN PUBLIC.persona_natural AS pn ON pn.id_persona = t.id_trabajador
					INNER JOIN "public".persona AS p ON p.id_persona = pn.id_persona
					WHERE t.id_tipo_trabajador = :id_tipo_trabajador AND date_part(\'YEAR\',ca.fecha)= :anio AND date_part(\'MONTH\',ca.fecha)= :mes

					) AS rdn
				) AS ddn

				GROUP BY ddn.id_trabajador,ddn.nombre_apellido

		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_tipo_trabajador', $idTipoTrabajador);
			$statement->bindParam('anio', $anio);
			$statement->bindParam('mes', $mes);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new ControlAsistencia;
				$temp->idTrabajador 	        	= $datos['id_trabajador'];
				$temp->nombreApellido 				= $datos['nombre_apellido'];
				$temp->fechaTardanza 				= $datos['fecha_tardanza'];
				$temp->fechaNoMarcoEntrada			= $datos['fecha_no_marco_entrada'];
				$temp->fechaNoMarcoSalida			= $datos['fecha_no_marco_salida'];
				$temp->noMarcoEntrada				= $datos['no_marco_entrada'];
				$temp->noMarcoSalida				= $datos['no_marco_salida'];
				$temp->cantidadTardanza				= $datos['cantidad_tardanza'];
				$temp->cantidadTardanzaEnHoras		= $datos['tardanza_en_horas'];
				
			
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

	private function fncContarLlegadaDentroDeLos30MinBD($idTrabajador , $anio , $mes)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT 
			sum(CASE 
				WHEN fda.tardanza_en_minutos < 30 AND fda.tardanza_en_minutos >0  THEN 1
				ELSE 0
			END) AS llego_entre_30 
		
		from(
			select 
			hx.id_trabajador,
			hx.fecha,
			--hx.hora_salida,
			hx.hora_ingreso,
			hx.horario_entrada,
			DATE_PART(\'hour\', hx.hora_ingreso ::time - hx.horario_entrada::time)*60 +DATE_PART(\'minute\',hx.hora_ingreso::time - hx.horario_entrada::time) AS  tardanza_en_minutos
			FROM (SELECT
			ca.id_control_asistencia,
			ca.id_trabajador,
			ca.id_trabajador_reloj,
			ca.fecha,
			ca.hora_ingreso,
			ca.hora_salida,
			(SELECT	 	ht.hora_ingreso AS horario_ingreso
				FROM 	escalafon.horario_trabajador AS ht 
			WHERE ht.id_trabajador = ca.id_trabajador AND ht.eliminado = 0 AND ht.actual = 1
			) AS horario_entrada
			--DATE_PART(\'hour\',rdn.hora_ingreso::time - rdn.horario_ingreso::time)*60 +DATE_PART(\'minute\',rdn.hora_ingreso::time - rdn.horario_ingreso::time)
		FROM
			escalafon.control_asistencia AS ca WHERE ca.id_trabajador = :id_trabajador AND ( date_part(\'YEAR\',ca.fecha)= :anio AND date_part(\'MONTH\',ca.fecha)= :mes )
			) AS hx
		) AS fda
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_trabajador', $idTrabajador);
			$statement->bindParam('anio', $anio);
			$statement->bindParam('mes', $mes);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new ControlAsistencia;
				$temp->llegadaDentroDelos30Min 	        	= $datos['llego_entre_30'];
			
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}
	private function fncBuscarPorDocumentoBD($documentoIdentidad)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			ht.id_horario_trabajador,
			pn.nombres||\' \'||pn.apellidos AS nombre_completo,
			p.documento_identidad,
			ht.id_trabajador,
			ht.id_trabajador_reloj,
			ht.hora_ingreso,
			ht.hora_salida,
				(SELECT	a.fecha_hora AS fecha_hora_auditoria FROM escalafon.auditoria  AS a WHERE ( a.id_operacion = 1 OR a.id_operacion = 2 )
					AND a.tabla = \'horario_trabajador\' AND a.objeto_id_nombre = \'id_horario_trabajador\' AND a.objeto_id_valor = ht.id_horario_trabajador
					ORDER BY a.id_auditoria DESC LIMIT 1 ),
				(SELECT
							pn.nombre_completo  AS usuario_auditoria
						FROM adm.usuario u
						LEFT JOIN public.persona_natural pn ON pn.id_persona = u.id_persona
						WHERE u.id_usuario = (SELECT	aa.id_usuario	FROM escalafon.auditoria  AS aa WHERE ( aa.id_operacion = 1 OR aa.id_operacion = 2 )
						AND aa.tabla = \'horario_trabajador\' AND aa.objeto_id_nombre = \'id_horario_trabajador\' AND aa.objeto_id_valor = ht.id_horario_trabajador
						ORDER BY aa.id_auditoria DESC LIMIT 1)),
			ht.eliminado
		FROM
			escalafon.horario_trabajador AS ht
			INNER JOIN escalafon.trabajador AS t ON t.id_trabajador = ht.id_trabajador 
			INNER JOIN "public".persona AS p ON p.id_persona = t.id_trabajador
			INNER JOIN "public".persona_natural AS pn ON pn.id_persona = p.id_persona
		WHERE (p.documento_identidad = :documento_identidad AND ht.eliminado = 0 ) 
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('documento_identidad', $documentoIdentidad);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new ControlAsistencia;
				$temp->documentoIdentidad      	= $datos['documento_identidad'];
				$temp->nombreCompleto     		= $datos['nombre_completo'];
				$temp->idMerito 	        	= $datos['id_merito'];
				$temp->idTrabajador 			= $datos['id_trabajador'];
				$temp->idTipoDocumentoMerito 	= $datos['id_tipo_documento_merito'];
				$temp->tipoDocumentoMerito 		= $datos['tipo_documento_merito'];
				$temp->fechaDocumento			= $datos['fecha_documento'];
				$temp->dias						= $datos['dias'];
				$temp->documento				= $datos['documento'];
				$temp->fechaEvento				= $datos['fecha_evento'];
				$temp->archivo					= $datos['archivo'];
				$temp->eliminado				= $datos['eliminado'];
				$temp->fechaHoraAuditoria		= $datos['fecha_hora'];
				$temp->usuarioAuditoria			= $datos['usuario_auditoria'];


				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}

	private function fncBuscarCantarLicenciasMesTrabajadorBD($anio,$mes,$idTrabajador)
	{
		$sql = cls_control::get_instancia();

		
		$query = '
		
		SELECT
		ttr.id_trabajador, 
		--array_to_json(array_agg(ttr.dia_inicio ||\'-\'|| ttr.dia_termino)) AS dia_inicio_termino,
		array_to_json(array_agg(ttr.fecha_lic_particular)) AS fecha_lic_particular,
		array_to_json(array_agg(ttr.fecha_lic_personal)) AS fecha_lic_personal,
		array_to_json(array_agg(ttr.fecha_lic_vacacion)) AS fecha_lic_vacacion,
		SUM((ttr.dias_lic_particular)) AS dias_lic_particular,
		SUM((ttr.dias_lic_personal)) AS dias_lic_personal,
		SUM((ttr.dias_lic_vacacion)) AS dias_lic_vacacion,
		SUM(ttr.particular) AS particular,
		SUM(ttr.personal)AS personal,
		SUM(ttr.vacacion) AS vacaciones
		FROM (
		SELECT
			--lt.id_licencia_trabajador,
			lt.id_trabajador,
			--lt.id_tipo_licencia,
			date_part(\'day\',lt.fecha_inicio)AS dia_inicio,
			--lt.fecha_termino,
			CASE 
				WHEN lt.fecha_termino>(date_trunc(\'month\', fecha_inicio) + interval \'1 month -1 day\')::DATE  THEN date_part(\'day\',(date_trunc(\'month\', fecha_inicio) + interval \'1 month -1 day\')::DATE)	
				ELSE date_part(\'day\',lt.fecha_termino)
			END AS dia_termino ,
			CASE 
				WHEN id_tipo_licencia=1   THEN 1
				ELSE 0
			END AS particular ,
			CASE 
				WHEN id_tipo_licencia=2  THEN 1
				ELSE 0
			END AS personal ,
			CASE 
				WHEN id_tipo_licencia=3  THEN 1
				ELSE 0
			END AS vacacion,
			CASE 
				WHEN id_tipo_licencia=1   THEN  to_char(lt.fecha_inicio, \'DD/MM\') ||\'-\'|| to_char(lt.fecha_termino, \'DD/MM\') 
				ELSE \'\'
			END AS fecha_lic_particular,
			CASE 
				WHEN id_tipo_licencia=2  THEN  to_char(lt.fecha_inicio, \'DD/MM\') ||\'-\'|| to_char(lt.fecha_termino, \'DD/MM\') 
				ELSE \'\'
			END AS fecha_lic_personal,
			CASE 
				WHEN id_tipo_licencia=3   THEN  to_char(lt.fecha_inicio, \'DD/MM\') ||\'-\'|| to_char(lt.fecha_termino, \'DD/MM\') 
				ELSE \'\'
			END AS fecha_lic_vacacion,
			CASE 
				WHEN id_tipo_licencia=1   THEN  lt.fecha_termino - lt.fecha_inicio
				ELSE 0
			END AS dias_lic_particular,
			CASE 
				WHEN id_tipo_licencia=2  THEN  lt.fecha_termino - lt.fecha_inicio
				ELSE 0
			END AS dias_lic_personal,
			CASE 
				WHEN id_tipo_licencia=3  THEN  lt.fecha_termino - lt.fecha_inicio
				ELSE 0
			END AS dias_lic_vacacion,
			--lt.archivo,
			DATE_PART(\'days\', 
				DATE_TRUNC(\'month\', fecha_inicio) 
				+ \'1 MONTH\'::INTERVAL 
				- \'1 DAY\'::INTERVAL
			)dias_mes			
			
		FROM
			escalafon.licencia_trabajador AS lt
		WHERE lt.eliminado = 0 and lt.id_trabajador = :id_trabajador AND ( date_part(\'YEAR\',lt.fecha_inicio) = :anio AND date_part(\'MONTH\',lt.fecha_inicio) = :mes)
		ORDER BY lt.fecha_inicio ASC
		) AS ttr
		GROUP BY ttr.id_trabajador, ttr.dias_mes
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('anio', $anio);
			$statement->bindParam('mes', $mes);
			$statement->bindParam('id_trabajador', $idTrabajador);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new ControlAsistencia;
				$temp->idTrabajador      		= $datos['id_trabajador'];
				//$temp->diaInicioTermino     	= $datos['dia_inicio_termino'];
				$temp->particular 	    		= $datos['particular'];
				$temp->personal 				= $datos['personal'];
				$temp->vacaciones			 	= $datos['vacaciones'];
				$temp->fechaLicParticular		= $datos['fecha_lic_particular'];
				$temp->fechaLicPersonal			= $datos['fecha_lic_personal'];
				$temp->fechaLicVacacion			= $datos['fecha_lic_vacacion'];
				$temp->diasLicParticular		= $datos['dias_lic_particular'];
				$temp->diasLicPersonal			= $datos['dias_lic_personal'];
				$temp->diasLicVacacion			= $datos['dias_lic_vacacion'];
		
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}

	private function fncBuscarContarLicenciaEnfermedadTrabajadorBD($anio,$mes,$idTrabajador)
	{
		$sql = cls_control::get_instancia();

		$anio =(Int)$anio;
		$mes=(Int)$mes;
	
		$query = 'SELECT
			count(le.id_licencia_enfermedad) AS cantidad_lic,
			le.id_trabajador,
			array_to_json(array_agg(to_char(le.fecha_inicio, \'DD/MM\') ||\'-\'|| to_char(le.fecha_termino, \'DD/MM\'))) AS fecha_lic_particular
		FROM
			escalafon.licencia_enfermedad AS le
		WHERE le.eliminado = 0 and le.id_trabajador = :id_trabajador AND ( date_part(\'YEAR\',le.fecha_inicio) = :anio AND date_part(\'MONTH\',le.fecha_inicio) = :mes)
		GROUP BY le.id_trabajador';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('anio', $anio);
			$statement->bindParam('mes', $mes);
			$statement->bindParam('id_trabajador', $idTrabajador);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new ControlAsistencia;
				$temp->idTrabajador      		= $datos['id_trabajador'];
				$temp->cantidadLic      		= $datos['cantidad_lic'];
				$temp->fechaLicenciaParticular      		= $datos['fecha_lic_particular'];
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}

	private function fncBuscarIdHorarioTrabajadorRelojBD($cadenaId)
	{
		$sql = cls_control::get_instancia();

		$in = "IN(".$cadenaId.")";
		$query = "
		SELECT
			ht.id_horario_trabajador,
			ht.id_trabajador,
			ht.id_trabajador_reloj,
			ht.hora_ingreso,
			ht.hora_salida,
			ht.eliminado
		FROM
			escalafon.horario_trabajador AS ht
			
		WHERE ht.actual = 1 and ht.id_trabajador_reloj" . " " . $in;

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			//$statement->bindParam('nombre_completo', $nombre);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new ControlAsistencia;
				$temp->idHorarioTrabajador      = $datos['id_horario_trabajador'];
				$temp->idTrabajador     		= $datos['id_trabajador'];
				$temp->idTrabajadorReloj 	    = $datos['id_trabajador_reloj'];
				$temp->horaIngreso 				= $datos['hora_ingreso'];
				$temp->horaSalida			 	= $datos['hora_salida'];
				$temp->eliminado		= $datos['eliminado'];
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}


	private function fncBuscarSueldoTrabajador($idTrabajador)
	{
		$sql = cls_control::get_instancia();

		
		$query = "
		SELECT
			COALESCE(st.sueldo,0) AS sueldo
		FROM
			escalafon.sueldo_trabajador AS st
		WHERE st.id_trabajador = :id_trabajador AND st.actual = 1
		ORDER BY st.id_sueldo desc LIMIT 1";

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_trabajador', $idTrabajador);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new ControlAsistencia;
				$temp->sueldo      = $datos['sueldo'];
				
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}


	private function fncDatostrabajadorDB($idTrabajador)
	{
		$sql = cls_control::get_instancia();

		
		$query = "
		SELECT
			pn.nombres || ' ' ||	pn.apellidos AS nombre_apellido,
			p.documento_identidad

		FROM
			persona_natural AS pn
			INNER JOIN persona AS p ON p.id_persona = pn.id_persona
			WHERE pn.id_persona = :id_persona" ;

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_persona', $idTrabajador);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new ControlAsistencia;
				$temp->nombreApellido      = $datos['nombre_apellido'];
				$temp->documentoIdentidad     		= $datos['documento_identidad'];
		
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}


	public function fncRegistrarBD($dtModel)
	{
		//$idMerito = $dtModel->getIdMerito();
		$idTrabajador	= $dtModel->getIdTrabajador();
		$fecha 			= $dtModel->getFecha();
		$horaIngreso 	= $dtModel->getHoraIngreso();
		$horaSalida 	= $dtModel->getHoraSalida();
	
		$sql = cls_control::get_instancia();
	/*	$consulta = "INSERT INTO escalafon.control_asistencia
					(
						-- id_control_asistencia -- this column value is auto-generated
						id_trabajador,						
						fecha,
						hora_ingreso,
						hora_salida
					)
					VALUES
					(
						:id_trabajador,						
						:fecha,
						:hora_ingreso,
						:hora_salida
					)
				   RETURNING id_control_asistencia";
*/

		$consulta = '
		INSERT INTO escalafon.control_asistencia
		(
			-- id_control_asistencia -- this column value is auto-generated
				id_trabajador,
				
				fecha,
				hora_ingreso,
				hora_salida
		)
		SELECT :id_trabajador,:fecha,:hora_ingreso,:hora_salida
		WHERE NOT EXISTS (
				SELECT 1 FROM escalafon.control_asistencia  WHERE id_trabajador = :id_trabajador AND fecha = :fecha
			)RETURNING id_control_asistencia ';


		$statement = $sql->preparar($consulta);
		if ($statement != false) {
			$statement->bindParam("id_trabajador", $idTrabajador);
			$statement->bindParam("fecha", $fecha);
			$statement->bindParam("hora_ingreso", $horaIngreso);
			$statement->bindParam("hora_salida", $horaSalida);

			$sql->ejecutar();
			$datos = $statement->fetch(PDO::FETCH_ASSOC);
			if ($datos) {
				//_Retorno de Datos
				$dtModel->setIdControlAsistencia($datos["id_control_asistencia"]);
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


function calcularTardanzaEnHoras($numTardanzas = 0){

	$desde[0]=0;	$hasta[0]=5;	$tardanzaEn[0]=0;
	$desde[1]=6;	$hasta[1]=11;	$tardanzaEn[1]=2;
	$desde[2]=12;	$hasta[2]=17;	$tardanzaEn[2]=4;
	$desde[3]=18;	$hasta[3]=24;	$tardanzaEn[3]=6;
	$desde[4]=30;	$hasta[4]=60;	$tardanzaEn[4]=8;

	$calDesde = array();
	$calHasta = array();
	$calTardanzaEn = array();
	$numTardanzas = (Int)$numTardanzas;
	for ($i=0; $i <5 ; $i++) { 
		if($numTardanzas >= $desde[$i]){$calDesde[$i] = 1;}else{$calDesde[$i] = 0;}
		if($numTardanzas <= $hasta[$i]){$calHasta[$i] = 1;}else{$calHasta[$i] = 0;}
	}
	$valorElejido = 0;
	for ($i=0; $i <5 ; $i++) { 
		if(($calDesde[$i]*$calHasta[$i])==1){$valorElejido= $tardanzaEn[$i];}	
	}

	return $valorElejido;

}

function parse_csv_file($csvfile) {
    $csv = Array();
    $rowcount = 0;
    if (($handle = fopen($csvfile, "r")) !== FALSE) {
        $max_line_length = defined('MAX_LINE_LENGTH') ? MAX_LINE_LENGTH : 10000;
        $header = fgetcsv($handle, $max_line_length);
        $header_colcount = count($header);
        while (($row = fgetcsv($handle, $max_line_length)) !== FALSE) {
            $row_colcount = count($row);
            if ($row_colcount == $header_colcount) {
                $entry = array_combine($header, $row);
                $csv[] = $entry;
            }
            else {
                error_log("csvreader: Invalid number of columns at line " . ($rowcount + 2) . " (row " . ($rowcount + 1) . "). Expected=$header_colcount Got=$row_colcount");
                return null;
            }
            $rowcount++;
        }
        //echo "Totally $rowcount rows found\n";
        fclose($handle);
    }
    else {
        error_log("csvreader: Could not read CSV \"$csvfile\"");
        return null;
    }
    return $csv;
}


function fncLimpiarString($str) {
	
		return strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
}


function fncLimpiarStringCsv($str) {
	$str = preg_replace('/[áàãâä]/ui', 'a', $str);
    $str = preg_replace('/[éèêë]/ui', 'e', $str);
    $str = preg_replace('/[íìîï]/ui', 'i', $str);
    $str = preg_replace('/[óòõôö]/ui', 'o', $str);
    $str = preg_replace('/[úùûü]/ui', 'u', $str);
    $str = preg_replace('/[ç]/ui', 'c', $str);
    $str = preg_replace('/[^a-z0-9]/i', '_', $str);
    $str = preg_replace('/_+/', '_', $str);

    return $str;
}
function _group_by($array, $key) {
    $return = array();
    foreach($array as $val) {
        $return[$val[$key]][] = $val;
    }
    return $return;
}
function fncObtenerIndices($lista){
	$cadena='';
	$contar = count($lista);
	$incrementador =1;
	foreach ($lista as $key => $value) {
		if ($contar==$incrementador) {
			$cadena.=$key;
		}else{
			$cadena.=$key.',';
		}
		$incrementador++;		
	}
	return $cadena;
}


function convertirSegundos($minutos) {
	$segundos = $minutos*60;
    $segundosEnMinutos = 60;
    $segundosEnHoras = 60 * $segundosEnMinutos;
    $segundosEnDias = 8 * $segundosEnHoras;

    // Extract days
    $dias = floor($segundos / $segundosEnDias);

    // Extract hours
    $horasSegundos = $segundos % $segundosEnDias;
    $horas = floor($horasSegundos / $segundosEnHoras);

    // Extract minutes
    $minutosSegunfos = $horasSegundos % $segundosEnHoras;
    $minutos = floor($minutosSegunfos / $segundosEnMinutos);

    // Extract the remaining seconds
    $remainingSeconds = $minutosSegunfos % $segundosEnMinutos;
    $segundos = ceil($remainingSeconds);

    // Format and return
    $timeParts = [];
    $array = [
        'dias' => (int)$dias,
        'horas' => (int)$horas,
        'minutos' => (int)$minutos,
        'segundos' => (int)$segundos,
    ];

    foreach ($array as $name => $value){
        if ($value > 0){
            $timeParts[] = $value. ' '.$name.($value == 1 ? '' : 's');
        }
    }

    return $array;
}


function fncObtenerFechaRango($incio, $fin, $format = 'Y-m-d') {
    $array = array();
    $intervalo = new DateInterval('P1D');

    $realEnd = new DateTime($fin);
    $realEnd->add($intervalo);

    $periodo = new DatePeriod(new DateTime($incio), $intervalo, $realEnd);

    foreach($periodo as $fecha) { 
        $array[] = $fecha->format($format); 
    }

    return $array;
}