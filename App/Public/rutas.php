<?php
require_once("../Config/rutas.php");
require_once("../Public/funciones.php");
$_oRutas = cls_rutas::get_rutas();
// ---------------------------------------------------------------------------------------------
// RUTA BASE
// ---------------------------------------------------------------------------------------------
	//$_oRutas->setRutaBase(fncAveriguaUrlRaiz());
	$_oRutas->setRutaBase("../../");
// ---------------------------------------------------------------------------------------------
// Rutas de las PERSONAS
// ---------------------------------------------------------------------------------------------
	$_oRutas->set('personaImg', 'img/Admin/persona/');
// ---------------------------------------------------------------------------------------------
// Rutas del SISTEMA DE TRAMITE DOCUMENTARIO
// ---------------------------------------------------------------------------------------------
	$_oRutas->set('documentoPdf', 'archivos/Tramite/documento/');
	$_oRutas->set('adjuntoPdf', 'archivos/Tramite/adjunto/');
	$_oRutas->set('reporteTramite', 'archivos/Tramite/reporte/');
// ---------------------------------------------------------------------------------------------
// Rutas de la INTRANET
// ---------------------------------------------------------------------------------------------
	$_oRutas->set('archivoPdf', 'archivos/Intranet/archivo/');
// ---------------------------------------------------------------------------------------------
// Rutas del SISTEMA DE METAS
// ---------------------------------------------------------------------------------------------
	$_oRutas->set('tareasPdf', 'archivos/Metas/tareas/');
	$_oRutas->set('metasReporteExcel', 'archivos/Metas/reportes/');
// ---------------------------------------------------------------------------------------------
// Rutas del SISTEMA ESCALAFON
// ---------------------------------------------------------------------------------------------
	$_oRutas->set('constanciaHaberesPdf', 'archivos/Escalafon/constancia_haberes/');
	$_oRutas->set('subsidioPdf', 'archivos/Escalafon/subsidio/');
	$_oRutas->set('remuneracionFamiliarPdf', 'archivos/Escalafon/remuneracion_familiar/');
	$_oRutas->set('evaluacionPdf', 'archivos/Escalafon/evaluacion/');
	$_oRutas->set('procesoAdministrativoDisciplinarioPdf', 'archivos/Escalafon/proceso_administrativo_disciplinario/');
	$_oRutas->set('recursoImpugnativoPdf', 'archivos/Escalafon/recurso_impugnativo/');
	$_oRutas->set('inasistenciaPdf', 'archivos/Escalafon/inasistencia/');

	$_oRutas->set('trabajadorPdf', 'archivos/Escalafon/trabajador/');
	$_oRutas->set('desplazamientoPdf', 'archivos/Escalafon/desplazamiento/');
	$_oRutas->set('capacitacionPdf', 'archivos/Escalafon/capacitacion/');
	$_oRutas->set('nivelEducativoPdf', 'archivos/Escalafon/nivel_educativo/');
	$_oRutas->set('nivelEspecializacionPdf', 'archivos/Escalafon/nivel_especializacion/');

	$_oRutas->set('meritoPdf', 'archivos/Escalafon/merito/');
	$_oRutas->set('licenciaTrabajadorPdf', 'archivos/Escalafon/licencia_trabajador/');	
	$_oRutas->set('programacionVacacionesPdf', 'archivos/Escalafon/programacion_vacaciones/');	
	$_oRutas->set('reporteControlAsistenciaRemuneracionExcel', 'archivos/Escalafon/reporte_control_asistencia_remuneracion/');	//ruta de archivo Variable
	$_oRutas->set('reporteControlAsistenciaIndividualExcel', 'archivos/Escalafon/reporte_control_asistencia_individual/');	//ruta de archivo Variable
	$_oRutas->set('reporteProgramacionVacacionesExcel', 'archivos/Escalafon/reporte_programacion_vaciones/');	//ruta de archivo Variable

	$_oRutas->set('procesoJudicial', 'archivos/Escalafon/proceso_judicial/');	//ruta de archivo Variable
	$_oRutas->set('licenciaEnfermedadPdf', 'archivos/Escalafon/licencia_enfermedad/');	//ruta de archivo Variable
// ---------------------------------------------------------------------------------------------
// Rutas del SISTEMA INTEGRADOR SIGA Y SIAF
// ---------------------------------------------------------------------------------------------
  $_oRutas->set('cuentaContableExcel', 'archivos/IntegradorSigaSiaf/cuenta_contable/');
	$_oRutas->set('saldoCertificadoExcel', 'archivos/IntegradorSigaSiaf/saldo_certificado/');
	$_oRutas->set('pedidoSigaExcel', 'archivos/IntegradorSigaSiaf/pedido_siga/');
	$_oRutas->set('pedidoServicioCompraSigaExcel', 'archivos/IntegradorSigaSiaf/pedido_servicio_compra_siga/');
	$_oRutas->set('pedidoOrdenRegistroSiafExcel', 'archivos/IntegradorSigaSiaf/pedido_orden_registro_siaf/');
	$_oRutas->set('notaModificatoriaSiafExcel', 'archivos/IntegradorSigaSiaf/nota_modificatoria_siaf/');
	$_oRutas->set('cuentaPagarSiafExcel', 'archivos/IntegradorSigaSiaf/cuenta_pagar_siaf/');
	$_oRutas->set('certificadoCompromisoAnualSigaExcel', 'archivos/IntegradorSigaSiaf/certificado_compromiso_anual_siga/');
	$_oRutas->set('avanceEjecucionCantidadContratoSigaExcel', 'archivos/IntegradorSigaSiaf/avance_ejecucion_cantidad_contrato_siga/');
	$_oRutas->set('integradorSigaSiafReportes', 'archivos/IntegradorSigaSiaf/reportes/');
// ---------------------------------------------------------------------------------------------
// Rutas del SISTEMA GERENCIAL
// ---------------------------------------------------------------------------------------------
	$_oRutas->set('archivosPdf', 'archivos/Gerencial/pdf/');
// ---------------------------------------------------------------------------------------------
// Rutas del SISTEMA DE INSPECCIONES SANITARIAS
// ---------------------------------------------------------------------------------------------
	$_oRutas->set('sanitariasReportes', 'archivos/Sanitarias/reportes/');
	$_oRutas->set('sanitariasInspecciones', 'archivos/Sanitarias/excel/');
// ---------------------------------------------------------------------------------------------
// Rutas del SISTEMA INTEGRADOR DE RRHH
// ---------------------------------------------------------------------------------------------
	$_oRutas->set('reporteIntegradorRRHHWord', 'archivos/IntegradorRRHH/reporte/');
// ---------------------------------------------------------------------------------------------
// Rutas del SISTEMA DE AULA VIRTUAL
// ---------------------------------------------------------------------------------------------
	$_oRutas->set('recursosAulaVitual', 'archivos/Aula/recursos/');
// ---------------------------------------------------------------------------------------------
// Rutas del SISTEMA DE DIGITALIZACIÓN DE ARCHIVO
// ---------------------------------------------------------------------------------------------
	$_oRutas->set('imagenesDigitales', 'img/Archivo/digitales/');
	$_oRutas->set('archivosDigitales', 'archivos/Archivo/digitales/');
	$_oRutas->set('archivosReportes', 'archivos/Archivo/reportes/');
?>