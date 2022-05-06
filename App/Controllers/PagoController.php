<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/gps/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/gps/App/Models/Pago.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/gps/App/Business/BusinessPago.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/gps/App/Public/funciones.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/gps/App/Public/archivo.php');
class PagoController extends Pago
{
	public function mensaje()
	{
		$request = [
			"subject" => "REPORTE - PROVISIÓN CONTABLE SOFTCONSTRUCT DEL MES DE ",
			"body" => 'prueba nro 2',
			"cc" => [
				"luis.chambilla@kuraxdev.net",


			],
			"bcc" => [
				"luis.chambilla@kuraxdev.net",

			]
		];
		send_email($request);
	}

	public function fncListarRegistros($inputs)
	{
		$fechaInicio = $inputs->idContratoVehiculoFechaInicio;
		$fechaFin	= $inputs->idContratoVehiculoFechaFin;
		$idTipoPago	= $inputs->idContratoVehiculoTipoPago;
		$idContratoVehiculo	= $inputs->idContratoVehiculo;
		$idVehiculo	= $inputs->idVehiculo;
		$dtReturn = array();
		$rol = new BusinessPago();
		$dtListado = $rol->fncListarRegistrosBD($fechaInicio, $fechaFin, $idTipoPago, $idContratoVehiculo, $idVehiculo);

		if (fncGeneralValidarDataArray($dtListado)) {
			foreach ($dtListado as $listado) {
				$model = array();
				$model['idPago'] 		= $listado->idPago;
				$model['fechaPago'] 		= $listado->fechaPago;
				$model['montoPago'] 	= $listado->montoPago;
				$model['montoPagoContratoVehiculo'] 	= $listado->montoPagoContratoVehiculo;
				$model['observacion'] 		= $listado->observacion;
				$model['createdAt'] 		= $listado->createdAt;
				$model['updated_at'] 		= $listado->updated_at;
				$model['idTipoPago'] 	= $listado->idTipoPago;
				$model['tipoPago'] 	= $listado->tipoPago;
				$model['idContrato'] 	= $listado->idContrato;
				$model['idVehiculo'] 	= $listado->idVehiculo;
				$model['idContratoVehiculo'] 	= $listado->idContratoVehiculo;
				$model['nombreCliente'] 	= $listado->nombreCliente;
				$model['archivo'] 	= $listado->archivo;


				array_push($dtReturn, $model);
				unset($model);
			}
		}
		return $dtReturn;
	}

	public function fncListarPagosAnios($inputs)
	{

		$dtReturn = array();
		$idContratoVehiculo = $inputs->idContratoVehiculo;
		$pago = new BusinessPago();
		$dtListado = $pago->fncListarPagosAniosBD($idContratoVehiculo);

		if (fncGeneralValidarDataArray($dtListado)) {
			foreach ($dtListado as $listado) {
				$model = array();
				$model['anio'] 		= $listado->anio;
				$model['mes'] 		= $listado->mes;
				$model['sumaPago'] 	= $listado->sumaPago;
				$model['cantidadMes'] 	= $listado->cantidadMes;
				array_push($dtReturn, $model);
				unset($model);
			}
		}
		return $dtReturn;
	}



	public function fncGuardar($inputs, $archivo)
	{
		$pago = new Pago;
		$businessPago = new BusinessPago();
		$pago->idContratoVehiculo = $inputs->idContratoVehiculo;
		$pago->fechaPago = isset($inputs->fechaPago) ? $inputs->fechaPago : null;
		$pago->montoPago = isset($inputs->montoPago) ? $inputs->montoPago : null;
		$pago->idTipoPago = $inputs->idTipoPago;
		$pago->observacion = isset($inputs->observacion) ? $inputs->observacion : null;
		$pago->archivo = '';
		$dtReturn = array();
		if ($archivo) {
			$ruta = '../../archivos/comprovantes/';
			$nombreArchivo = ($archivo['name']) . '_' . uniqid() . '_';
			$obj_arc = new archivo($archivo, $ruta, "img_" . $nombreArchivo, 0, 9);
			if ($obj_arc->subir()) {
				$optArchivo = $obj_arc->get_nombre_archivo();
				$pago->archivo = ($ruta . $obj_arc->get_nombre_archivo());
			}
		}
		$dtReturn = $businessPago->fncGuardarBD($pago);

		// if(!$vehiculo=$businessPago->fncGuardarBD($vehiculo)){
		// 	return false;
		// }
		return $dtReturn;
	}

	public function fncEditar($inputs, $archivo)
	{
		$pago = new Pago;
		$businessPago = new BusinessPago();
		$pago->idPago = (int)$inputs->idPago;
		$pago->idContratoVehiculo = (int)$inputs->idContratoVehiculo;
		$pago->fechaPago = isset($inputs->fechaPago) ? $inputs->fechaPago : null;
		$pago->montoPago = isset($inputs->montoPago) ? $inputs->montoPago : null;
		$pago->idTipoPago = (int)$inputs->idTipoPago;
		$pago->observacion = isset($inputs->observacion) ? $inputs->observacion : null;
		$pago->archivo = '';
		$dtReturn = array();
		if ($archivo) {
			$ruta = '../../archivos/comprovantes/';
			$nombreArchivo = ($archivo['name']) . '_' . uniqid() . '_';
			$obj_arc = new archivo($archivo, $ruta, "img_" . $nombreArchivo, 0, 9);
			if ($obj_arc->subir()) {
				$optArchivo = $obj_arc->get_nombre_archivo();
				$pago->archivo = ($ruta . $obj_arc->get_nombre_archivo());
			}
		}
		$dtReturn = $businessPago->fncEditarBD($pago);

		// if(!$vehiculo=$businessPago->fncGuardarBD($vehiculo)){
		// 	return false;
		// }
		return $dtReturn;
	}
	public function fncEliminar($inputs)
	{
		$pago = new Pago;
		$businessPago = new BusinessPago();
		$pago->idPago = (int)$inputs->idPago;

		$dtReturn = $businessPago->fncEliminarBD($pago);

		// if(!$vehiculo=$businessPago->fncGuardarBD($vehiculo)){
		// 	return false;
		// }
		return $dtReturn;
	}
}
