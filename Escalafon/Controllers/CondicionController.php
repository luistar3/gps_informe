<?php
require_once '../../App/Escalafon/Models/Condicion.php';
require_once '../../App/Config/control.php';

class CondicionController extends Condicion
{
	//=======================================================================================
	//FUNCIONES LOGICA
	//=======================================================================================

	public function fncListarRegistros($id=0)
	{
		//$inputIdTrabajador = (Int) fncObtenerValorArray( $arrayInputs, 'idTipoCasa', true);
		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosBD($id);

		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
		
				$model = array();
				
				$model['id_condicion'] = $listado->idCondicion;
				$model['condicion'] =$listado->condicion;
		
	
				array_push($dtReturn, $model);
			}
		}
		return $dtReturn;
	}

	//=======================================================================================
	//FUNCIONES BASE DE DATOS
	//=======================================================================================

	private function fncListarRegistrosBD( $id = 0 )
	{	$dtReturn =array();
		$arrayReturn=array();

			$temp = new Condicion;
			$temp->idCondicion 	= 1;
			$temp->condicion 	= 'EFECTUADO';	
			array_push( $arrayReturn, $temp );
			$temp = new Condicion;
			
			$temp->idCondicion 	= 2;
			$temp->condicion 	= 'SIN PROGRAMAR';	
			array_push( $arrayReturn, $temp );
	
		if( $id==-1 ){
		
			return $arrayReturn;
			
		}else{
			
			foreach ($arrayReturn as $tipo) {
				if ($tipo->idCondicion == $id) {
					array_push( $dtReturn, $tipo );					
				}
			}
			return $dtReturn;
		}
		
	}


} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom

?>