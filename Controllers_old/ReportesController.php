<?php
require_once '../../App/Escalafon/Models/Reporte.php';
require_once '../../App/Config/control.php';
require_once '../../vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php';
require_once '../../vendor/phpoffice/phpexcel/Classes/PHPExcel/Style/Border.php';
class ReportesController extends Reporte
{
	//=======================================================================================
	//FUNCIONES LOGICA
	//=======================================================================================
    public function __construct()
	{
	} 
    
    public function fncReporteSubsidiosPorEnfermedad($idTrabajador){
        $dtReturn = array();
        try{
            $datosTrabajador = $this->fncObtenerDatosTrabajadorSubsidiosBD($idTrabajador);

            $datosTrabajador['area'] = $this->fncObtenerAreaDelTrabajadorBD($idTrabajador);
    
            $datosSubsidios = $this->fncObtenerDatosSubsidiosPorTrabajadorBD($idTrabajador);
            
            $url = $this->fncGenerarReporteSubsidiosPorEnfermedadExcel($datosTrabajador,$datosSubsidios);

            $dtReturn['datos_trabajador'] = $datosTrabajador;
            $dtReturn['url'] = $url;
            return $dtReturn;
        }
        catch (Exception $e) {
            return $dtReturn;
        }
    }

    private function fncGenerarReporteSubsidiosPorEnfermedadExcel(array $datosTrabajador , array $datosSubsidios){
        $objPHPExcel = new PHPExcel;
        $styleBorderArray = array(
                                    'borders' => array(
                                        'outline' => array(
                                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                                            'color' => array('argb' => '00000000'),
                                        ),
                                    ),
                                );

        $objReader =  PHPExcel_IOFactory::createReader('Excel2007');
        
        $objPHPExcel = $objReader->load('../../files/excel/plantillas/ReporteSubsidiosPorEnfermedad.xlsx');
         
        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->setActiveSheetIndex()->SetCellValue('B5',$datosTrabajador['nombre_completo']);
        $objPHPExcel->setActiveSheetIndex()->SetCellValue('B6',$datosTrabajador['area']);
        $objPHPExcel->setActiveSheetIndex()->SetCellValue('B7',$datosTrabajador['telefono']);
        $objPHPExcel->setActiveSheetIndex()->SetCellValue('L7',$datosTrabajador['tipo_trabajador']);

        $count = 13;
        foreach($datosSubsidios as $subsidio){

            $objPHPExcel->setActiveSheetIndex()->SetCellValue('A'.$count,$subsidio['contingencia']);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$count)->applyFromArray($styleBorderArray)->applyFromArray($styleBorderArray);
            $objPHPExcel->setActiveSheetIndex()->SetCellValue('B'.$count,$subsidio['citt']);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$count)->applyFromArray($styleBorderArray)->applyFromArray($styleBorderArray);
            $objPHPExcel->setActiveSheetIndex()->SetCellValue('C'.$count,$subsidio['fecha_inicio']);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$count)->applyFromArray($styleBorderArray)->applyFromArray($styleBorderArray);
            $objPHPExcel->setActiveSheetIndex()->SetCellValue('D'.$count,$subsidio['fecha_termino']);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$count)->applyFromArray($styleBorderArray)->applyFromArray($styleBorderArray);
            
            $objPHPExcel->setActiveSheetIndex()->SetCellValue('E'.$count,$this->fncCalcularDiferenciaFechas($subsidio['fecha_inicio'],$subsidio['fecha_termino']).'dias');
            $objPHPExcel->getActiveSheet()->getStyle('E'.$count)->applyFromArray($styleBorderArray)->applyFromArray($styleBorderArray);
            // $objPHPExcel->setActiveSheetIndex()->SetCellValue('F'.$count,'meses');
            $objPHPExcel->getActiveSheet()->getStyle('F'.$count)->applyFromArray($styleBorderArray)->applyFromArray($styleBorderArray);
            // $objPHPExcel->setActiveSheetIndex()->SetCellValue('G'.$count,'dias');
            $objPHPExcel->getActiveSheet()->getStyle('G'.$count)->applyFromArray($styleBorderArray)->applyFromArray($styleBorderArray);
            // $objPHPExcel->setActiveSheetIndex()->SetCellValue('H'.$count,'meses');
            $objPHPExcel->getActiveSheet()->getStyle('H'.$count)->applyFromArray($styleBorderArray)->applyFromArray($styleBorderArray);
            // $objPHPExcel->setActiveSheetIndex()->SetCellValue('I'.$count,'RA');
            $objPHPExcel->getActiveSheet()->getStyle('I'.$count)->applyFromArray($styleBorderArray)->applyFromArray($styleBorderArray);
            // $objPHPExcel->setActiveSheetIndex()->SetCellValue('J'.$count,'dias');
            $objPHPExcel->getActiveSheet()->getStyle('J'.$count)->applyFromArray($styleBorderArray)->applyFromArray($styleBorderArray);
            // $objPHPExcel->setActiveSheetIndex()->SetCellValue('K'.$count,'meses');
            $objPHPExcel->getActiveSheet()->getStyle('K'.$count)->applyFromArray($styleBorderArray)->applyFromArray($styleBorderArray);
            // $objPHPExcel->setActiveSheetIndex()->SetCellValue('L'.$count,'monto');
            $objPHPExcel->getActiveSheet()->getStyle('L'.$count)->applyFromArray($styleBorderArray)->applyFromArray($styleBorderArray);
            // $objPHPExcel->setActiveSheetIndex()->SetCellValue('M'.$count,'mes');
            $objPHPExcel->getActiveSheet()->getStyle('M'.$count)->applyFromArray($styleBorderArray)->applyFromArray($styleBorderArray);
        
            $count++;

        }
        
        $nameFile = "archivos/Escalafon/subsidio/LicEnf-".date("Ymd")."-".$datosTrabajador['id_trabajador'].".xlsx";
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
        $objWriter->save("../../".$nameFile);
        
        return $_SERVER['HTTP_HOST'].'/'.$nameFile; 
    }
    
    public function fncListarPersonalContratadoCas($arrayInputs){

        $fechaInicio = fncObtenerValorArray( $arrayInputs, 'fechaInicio', true);
        $fechaTermino = fncObtenerValorArray( $arrayInputs, 'fechaTermino', true);

        $dtReturn = array();

        $dtListado = $this->fncListarPersonalContratadoCasBD($fechaInicio, $fechaTermino);
        if(!empty($dtListado)){
            $dtReturn = $dtListado;
        }
        return $dtReturn;
    }

    public function fncListarPersonal($arrayInputs){

        $fechaInicio = fncObtenerValorArray( $arrayInputs, 'fechaInicio', true);
        $fechaTermino = fncObtenerValorArray( $arrayInputs, 'fechaTermino', true);

        $dtReturn = array();

        $dtListado = $this->fncListarPersonalBD($fechaInicio, $fechaTermino);
        if(!empty($dtListado)){
            $dtReturn = $dtListado;
        }
        return $dtReturn;
    }

    public function fncListarPersonalAltas($arrayInputs){

        $fechaInicio = fncObtenerValorArray( $arrayInputs, 'fechaInicio', true);
        $fechaTermino = fncObtenerValorArray( $arrayInputs, 'fechaTermino', true);

        $dtReturn = array();

        $dtListado = $this->fncListarPersonalCasAltasBD($fechaInicio, $fechaTermino);
        if(!empty($dtListado)){
            $dtReturn = $dtListado;
        }
        return $dtReturn;
    }

    public function fncListarPersonalBajas($arrayInputs){

        $fechaInicio = fncObtenerValorArray( $arrayInputs, 'fechaInicio', true);
        $fechaTermino = fncObtenerValorArray( $arrayInputs, 'fechaTermino', true);

        $dtReturn = array();

        $dtListado = $this->fncListarPersonalCasBajasBD($fechaInicio, $fechaTermino);
        if(!empty($dtListado)){
            $dtReturn = $dtListado;
        }
        return $dtReturn;
    }

    public function fncListarPersonalfuncionario($arrayInputs){

        $fechaInicio = fncObtenerValorArray( $arrayInputs, 'fechaInicio', true);
        $fechaTermino = fncObtenerValorArray( $arrayInputs, 'fechaTermino', true);

        $dtReturn = array();

        $dtListado = $this->fncListarPersonalfuncionarioBD($fechaInicio, $fechaTermino);
        if(!empty($dtListado)){
            $dtReturn = $dtListado;
        }
        return $dtReturn;
    }

    private function fncCalcularDiferenciaFechas($fechaInicio,$fechaTermino){
        $fechaInicio = new DateTime($fechaInicio);
        $fechaTermino = new DateTime($fechaTermino);
        $diff = $fechaInicio->diff($fechaTermino);
        return $diff->days;
    }

    private function fncObtenerAreaDelTrabajadorBD($idTrabajador){
        $sql = cls_control::get_instancia();
		$query = "SELECT ea.nombre_area
                    from escalafon.desplazamiento ed 
                    inner join escalafon.area ea
                    on ed.id_area = ea.id_area
                    where ed.id_trabajador = :id_trabajador
                    and ed.actual = 1";
        $statement = $sql->preparar($query);
		$dataReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_trabajador', $idTrabajador);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$dataReturn = $datos['nombre_area'];
			}
		}
        return $dataReturn;
    }
    
    private function fncObtenerDatosTrabajadorSubsidiosBD($idTrabajador){
        $sql = cls_control::get_instancia();
		$query = "SELECT 
                    tr.id_trabajador,pn.nombre_completo, pe.telefono, ttp.tipo_trabajador
                    From escalafon.trabajador tr
                    INNER JOIN escalafon.tipo_trabajador ttp
                    on tr.id_tipo_trabajador = ttp.id_tipo_trabajador
                    INNER JOIN public.persona_natural pn
                    on tr.id_trabajador = pn.id_persona
                    INNER JOIN public.persona pe
                    on pn.id_persona = pe.id_persona
                    WHERE tr.id_trabajador = :id_trabajador";

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_trabajador', $idTrabajador);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$arrayReturn['id_trabajador'] = $datos['id_trabajador'];
				$arrayReturn['nombre_completo'] = $datos['nombre_completo'];
				$arrayReturn['telefono']        = $datos['telefono'];
				$arrayReturn['tipo_trabajador'] = $datos['tipo_trabajador'];
			}
		}
		return $arrayReturn;
        
    }

    private function fncObtenerDatosSubsidiosPorTrabajadorBD($idTrabajador){
        $sql = cls_control::get_instancia();
		$query = "
                SELECT 
                    ct.contingencia, 
                    le.citt,
                    le.fecha_inicio,
                    le.fecha_termino,
                    le.dias
                FROM escalafon.licencia_enfermedad le
                INNER JOIN escalafon.contingencia ct
                ON le.id_contingencia = ct.id_contigencia
                WHERE le.id_trabajador = :id_trabajador 
                AND le.eliminado = 0
                ";
		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_trabajador', $idTrabajador);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
                $temp = array();

                $temp['contingencia']   = $datos['contingencia'];
                $temp['citt']           = $datos['citt'];
                $temp['fecha_inicio']   = $datos['fecha_inicio'];
                $temp['fecha_termino']  = $datos['fecha_termino'];
                $temp['dias']           = $datos['dias'];

                array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
    }

    private function fncListarPersonalContratadoCasBD($fecha_inicio = null, $fecha_termino = null){

        $sql = cls_control::get_instancia();
		$query = '
                    SELECT 
                    pn.nombre_completo,
                    ec.nombre_cargo ,
                    ea.nombre_area , 
                    ed.numero_documento,
                    ed.fecha_inicio,
                    ed.fecha_termino,
                    ed.inicio_renovacion_cas,
                    ed.termino_renovacion_cas,
                    ed.meta_periodo,
                    ed.numero_convocatoria,
                    ed.renuncia,
                    ed.observacion,
                    pp.documento_identidad,
                    pp.telefono
                    From escalafon.desplazamiento ed 
                    inner join escalafon.area ea on ed.id_area = ea.id_area
                    inner join escalafon.cargo ec on ed.id_cargo = ec.id_cargo
                    inner join escalafon.trabajador tr on ed.id_trabajador = tr.id_trabajador
                    inner join public.persona_natural pn on pn.id_persona = tr.id_trabajador
                    inner join public.persona pp on pp.id_persona = tr.id_trabajador
                    where tr.id_tipo_trabajador = 2
                    and ( fecha_inicio >= :fecha_inicio OR :fecha_inicio IS NULL  )
                    and ( fecha_inicio <= :fecha_termino OR :fecha_termino IS NULL  )
                    and ed.eliminado = 0
                    ';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('fecha_inicio', $fecha_inicio);
			$statement->bindParam('fecha_termino', $fecha_termino);

			$sql->ejecutar();
			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = array();
                $temp['nombre_completo']    = $datos['nombre_completo'];
                $temp['nombre_cargo']       = $datos['nombre_cargo'];
                $temp['nombre_area']        = $datos['nombre_area'];
                $temp['numero_documento']	= $datos['numero_documento'];
                $temp['fecha_inicio']		= $datos['fecha_inicio'];
                $temp['fecha_termino']		= $datos['fecha_termino'];
                $temp['inicio_renovacion_cas'] = $datos['numero_resolucion_inicio'];
                $temp['termino_renovacion_cas'] = $datos['numero_resolucion_termino'];
                $temp['observacion']		= $datos['observacion'];
                $temp['meta_periodo']		= $datos['meta_periodo'];
                $temp['renuncia']			= $datos['renuncia'];
                $temp['documento_identidad']= $datos['documento_identidad'];
                $temp['telefono']			= $datos['telefono'];
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;

    }

    private function fncListarPersonalfuncionarioBD($fecha_inicio = null, $fecha_termino = null){

        $sql = cls_control::get_instancia();
		$query = "  SELECT 
                    tr.codigo_plaza,
                    pn.nombre_completo,
                    ec.nombre_cargo ,
                    tr.ubigeo,
                    ed.direccion_oficina,
                    ed.oficina,
                    ed.numero_documento,
                    ed.tipo_vinculo_laboral,
                    ed.numero_resolucion_inicio,
                    ed.numero_resolucion_termino,
                    ed.fecha_inicio,
                    ed.fecha_termino
                    ed.observacion
                    From escalafon.desplazamiento ed 
                    inner join escalafon.cargo ec on ed.id_cargo = ec.id_cargo
                    inner join escalafon.trabajador tr on ed.id_trabajador = tr.id_trabajador
                    inner join public.persona_natural pn on pn.id_persona = tr.id_trabajador
                    inner join escalafon.tipo_accion et on ed.id_tipo_accion = et.id_tipo_accion
                    and ( ed.fecha_inicio >= :fecha_inicio OR :fecha_inicio IS NULL  )
                    and ( ed.fecha_inicio <= :fecha_termino OR :fecha_termino IS NULL  )
                    and ( et.categoria = 'ASIGNACION' OR et.categoria = 'ENCARGO DE FUNCIONES')
                    and ed.eliminado = 0
                    ";
        $statement = $sql->preparar($query);
        $arrayReturn = array();

        if ($statement != false) {
            $statement->bindParam('fecha_inicio', $fecha_inicio);
            $statement->bindParam('fecha_termino', $fecha_termino);

            $sql->ejecutar();
            while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
                $temp = array();
                $temp['codigo_plaza']           = $datos['codigo_plaza'];
                $temp['nombre_completo']        = $datos['nombre_completo'];
                $temp['nombre_cargo']           = $datos['nombre_cargo'];
                $temp['ubigeo']	                = $datos['ubigeo'];
                $temp['direccion_oficina']	    = $datos['direccion_oficina'];
                $temp['oficina'] 	            = $datos['oficina'];
                $temp['numero_resolucion_inicio']		= $datos['numero_documento'];
                $temp['numero_resolucion_termino']		= $datos['numero_documento'];
                $temp['tipo_vinculo_laboral']	= $datos['tipo_vinculo_laboral'];
                $temp['fecha_inicio']	        = $datos['fecha_inicio'];
                $temp['fecha_termino']		    = $datos['fecha_termino'];
                $temp['observacion']		    = $datos['observacion'];
                array_push($arrayReturn, $temp);
            }
        }
        return $arrayReturn;
    }

    private function fncListarPersonalBD($fecha_inicio = null, $fecha_termino = null){

        $sql = cls_control::get_instancia();
		$query = "  SELECT 
                    tr.codigo_unico,
                    pn.nombre_completo,
                    en.denom,
                    ec.nombre_cargo ,
                    ed.oficina,
                    ed.observacion,
                    ed.fecha_inicio,
                    ed.fecha_termino
                    From escalafon.desplazamiento ed 
                    inner join escalafon.cargo ec on ed.id_cargo = ec.id_cargo
                    inner join escalafon.trabajador tr on ed.id_trabajador = tr.id_trabajador
                    inner join public.persona_natural pn on pn.id_persona = tr.id_trabajador
                    inner join escalafon.nivel en on en.id_nivel = tr.id_nivel
                    and ( ed.fecha_inicio >= :fecha_inicio OR :fecha_inicio IS NULL  )
                    and ( ed.fecha_inicio <= :fecha_termino OR :fecha_termino IS NULL  )
                    and ed.eliminado = 0
                    ";

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('fecha_inicio', $fecha_inicio);
			$statement->bindParam('fecha_termino', $fecha_termino);

			$sql->ejecutar();
			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = array();
                $temp['codigo_unico']       = $datos['codigo_unico'];
                $temp['nombre_completo']    = $datos['nombre_completo'];
                $temp['denom']              = $datos['denom'];
                $temp['nombre_cargo']	    = $datos['nombre_cargo'];
                $temp['oficina']	        = $datos['oficina'];
                $temp['observacion']		= $datos['observacion'];
                $temp['fecha_inicio']		= $datos['fecha_inicio'];
                $temp['fecha_termino']		= $datos['fecha_termino'];
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;

    }

    private function fncListarPersonalCasAltasBD($fecha_inicio = null, $fecha_termino = null){

        $sql = cls_control::get_instancia();
		$query = "  SELECT 
                    tr.numero_contrato_cas,
                    pp.numero_documento,
                    pn.nombre_completo,
                    ec.nombre_cargo ,
                    en.titulo_obtenido,
                    ed.oficina,
                    ed.direccion_oficina,
                    ed.fecha_inicio,
                    ed.fecha_termino,
                    es.sueldo,
                    ef.nombre,
                    ed.meta_periodo,
                    ed.observacion,
                    From escalafon.desplazamiento ed 
                    inner join escalafon.cargo ec on ed.id_cargo = ec.id_cargo
                    inner join escalafon.trabajador tr on ed.id_trabajador = tr.id_trabajador
                    inner join public.persona_natural pn on pn.id_persona = tr.id_trabajador
                    inner join public.personal pp on pp.id_persona = tr.id_trabajador
                    inner join escalafon.nivel en on en.id_nivel = tr.id_nivel
                    inner join escalafon.sueldo_trabajador es on es.id_trabajador = tr.id_trabajador
                    inner join escalafon.fte_fto ef on ef.id_fte_fto = de.id_fte_fto
                    where tr.id_tipo_trabajador = 2
                    and ( ed.fecha_inicio >= :fecha_inicio OR :fecha_inicio IS NULL  )
                    and ( ed.fecha_inicio <= :fecha_termino OR :fecha_termino IS NULL  )
                    and ed.eliminado = 0
                    ";

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('fecha_inicio', $fecha_inicio);
			$statement->bindParam('fecha_termino', $fecha_termino);

			$sql->ejecutar();
			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = array();
                $temp['numero_contrato_cas'] = $datos['numero_contrato_cas'];
                $temp['numero_documento']    = $datos['numero_documento'];
                $temp['nombre_completo']     = $datos['nombre_completo'];
                $temp['nombre_cargo']	     = $datos['nombre_cargo'];
                $temp['titulo_obtenido']	 = $datos['titulo_obtenido'];
                $temp['oficina']		     = $datos['oficina'];
                $temp['direccion_oficina']	 = $datos['direccion_oficina'];
                $temp['fecha_inicio']		 = $datos['fecha_inicio'];
                $temp['fecha_termino']		 = $datos['fecha_termino'];
                $temp['sueldo']		         = $datos['sueldo'];
                $temp['nombre']		         = $datos['nombre'];
                $temp['meta_periodo']		 = $datos['meta_periodo'];
                $temp['observacion']		 = $datos['observacion'];
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;

    }

    private function fncListarPersonalCasBajasBD($fecha_inicio = null, $fecha_termino = null){

        $sql = cls_control::get_instancia();
		$query = "  SELECT 
                    tr.numero_contrato_cas,
                    pp.numero_documento,
                    pn.nombre_completo,
                    ec.nombre_cargo ,
                    en.titulo_obtenido,
                    ed.oficina,
                    ed.direccion_oficina,
                    ed.fecha_inicio,
                    ed.fecha_termino,
                    es.sueldo,
                    ef.nombre,
                    ed.meta_periodo,
                    ed.observacion,
                    From escalafon.desplazamiento ed 
                    inner join escalafon.cargo ec on ed.id_cargo = ec.id_cargo
                    inner join escalafon.trabajador tr on ed.id_trabajador = tr.id_trabajador
                    inner join public.persona_natural pn on pn.id_persona = tr.id_trabajador
                    inner join public.personal pp on pp.id_persona = tr.id_trabajador
                    inner join escalafon.nivel en on en.id_nivel = tr.id_nivel
                    inner join escalafon.sueldo_trabajador es on es.id_trabajador = tr.id_trabajador
                    inner join escalafon.fte_fto ef on ef.id_fte_fto = de.id_fte_fto
                    where tr.id_tipo_trabajador = 2
                    and ( ed.fecha_termino >= :fecha_inicio OR :fecha_inicio IS NULL  )
                    and ( ed.fecha_termino <= :fecha_termino OR :fecha_termino IS NULL  )
                    and ed.eliminado = 0
                    ";

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('fecha_inicio', $fecha_inicio);
			$statement->bindParam('fecha_termino', $fecha_termino);

			$sql->ejecutar();
			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = array();
                $temp['numero_contrato_cas'] = $datos['numero_contrato_cas'];
                $temp['numero_documento']    = $datos['numero_documento'];
                $temp['nombre_completo']     = $datos['nombre_completo'];
                $temp['nombre_cargo']	     = $datos['nombre_cargo'];
                $temp['titulo_obtenido']	 = $datos['titulo_obtenido'];
                $temp['oficina']		     = $datos['oficina'];
                $temp['direccion_oficina']	 = $datos['direccion_oficina'];
                $temp['fecha_inicio']		 = $datos['fecha_inicio'];
                $temp['fecha_termino']		 = $datos['fecha_termino'];
                $temp['sueldo']		         = $datos['sueldo'];
                $temp['nombre']		         = $datos['nombre'];
                $temp['meta_periodo']		 = $datos['meta_periodo'];
                $temp['observacion']		 = $datos['observacion'];
				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;

    }

}