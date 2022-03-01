<?php
require_once '../../App/Escalafon/Models/TipoCentroEstudio.php';
require_once '../../App/Config/control.php';

class TipoCentroEstudioController extends TipoCentroEstudio
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
				
				$model['idTipoCentroEstudio'] = $listado->idTipoCentroEstudio;
				$model['tipoCentroEstudio'] =$listado->tipoCentroEstudio;
		
	
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

			$temp = new TipoCentroEstudio;

			$temp->idTipoCentroEstudio 	= 1;
			$temp->tipoCentroEstudio 	= 'PUBLICO';	
			array_push( $arrayReturn, $temp );

			$temp = new TipoCentroEstudio;			
			$temp->idTipoCentroEstudio 	= 2;
			$temp->tipoCentroEstudio 	= 'PRIVADO';	
			array_push( $arrayReturn, $temp );
	

		if( $id==-1 ){
		
			return $arrayReturn;
			
		}else{
			
			foreach ($arrayReturn as $tipo) {
				if ($tipo->idTipoCentroEstudio == $id) {
					array_push( $dtReturn, $tipo );					
				}
			}
			return $dtReturn;
		}
		
	}


} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom

?>