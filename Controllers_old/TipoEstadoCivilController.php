<?php
require_once '../../App/Escalafon/Models/TipoEstadoCivil.php';
require_once '../../App/Config/control.php';

class TipoEstadoCivilController extends TipoEstadoCivil
{
	//=======================================================================================
	//FUNCIONES LOGICA
	//=======================================================================================

	public function fncListarRegistros($id=0)
	{
		//$inputIdTrabajador = (Int) fncObtenerValorArray( $arrayInputs, 'idTipoEstadoCivil', true);
		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosBD($id);

		if( fncGeneralValidarDataArray($dtListado) ){
			foreach( $dtListado as $listado ){
		
				$model = array();
				
				$model['idEstadoCivil'] = $listado->idTipoEstadoCivil;
				$model['estadoCivil'] =$listado->tipoEstadoCivil;
			
	
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

			$temp = new TipoEstadoCivil;
			$temp->idTipoEstadoCivil 	= 1;
			$temp->tipoEstadoCivil 		= 'Soltero';	
			array_push( $arrayReturn, $temp );
			$temp = new TipoEstadoCivil;
			
			$temp->idTipoEstadoCivil 	= 2;
			$temp->tipoEstadoCivil 		= 'Concubino';	
			array_push( $arrayReturn, $temp );
			$temp = new TipoEstadoCivil;
			
			$temp->idTipoEstadoCivil 	= 3;
			$temp->tipoEstadoCivil 		= 'Casado';	
			array_push( $arrayReturn, $temp );
			$temp = new TipoEstadoCivil;
			$temp->idTipoEstadoCivil 	= 4;
			$temp->tipoEstadoCivil 		= 'Divorsiado';	
			array_push( $arrayReturn, $temp );

			$temp = new TipoEstadoCivil;
			$temp->idTipoEstadoCivil 	= 5;
			$temp->tipoEstadoCivil 		= 'Viudo';	
			array_push( $arrayReturn, $temp );

		if( $id==-1 ){
		
			return $arrayReturn;
			
		}else{
			
			foreach ($arrayReturn as $estado) {
				if ($estado->idTipoEstadoCivil == $id) {
					array_push( $dtReturn, $estado );					
				}
			}
			return $dtReturn;
		}
		
	}


} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom

?>