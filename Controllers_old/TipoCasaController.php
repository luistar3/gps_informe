<?php
require_once '../../App/Escalafon/Models/TipoCasa.php';
require_once '../../App/Config/control.php';

class TipoCasaController extends TipoCasa
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
				
				$model['idTipoCasa'] = $listado->idTipoCasa;
				$model['tipoCasa'] =$listado->tipoCasa;
		
	
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

			$temp = new TipoCasa;
			$temp->idTipoCasa 	= 1;
			$temp->tipoCasa 		= 'Propia';	
			array_push( $arrayReturn, $temp );
			$temp = new TipoCasa;
			
			$temp->idTipoCasa 	= 2;
			$temp->tipoCasa 		= 'Alquilada';	
			array_push( $arrayReturn, $temp );
	
		if( $id==-1 ){
		
			return $arrayReturn;
			
		}else{
			
			foreach ($arrayReturn as $tipo) {
				if ($tipo->idTipoCasa == $id) {
					array_push( $dtReturn, $tipo );					
				}
			}
			return $dtReturn;
		}
		
	}


} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom

?>