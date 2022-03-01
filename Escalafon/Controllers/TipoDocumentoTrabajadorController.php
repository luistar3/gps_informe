<?php
require_once '../../App/Escalafon/Models/TipoDocumentoTrabajador.php';
require_once '../../App/Config/control.php';
require_once '../../App/Escalafon/Controllers/AuditoriaController.php';

class TipoDocumentoTrabajadorController extends TipoDocumentoTrabajador
{
	//=======================================================================================
	//FUNCIONES LOGICA
	//=======================================================================================

	public function fncListarRegistros($id = -1)
	{

		$dtReturn = array();
		$listadoIdAuditoria = array();
		$dtListado = $this->fncListarRegistrosBD($id);
		
		if( fncGeneralValidarDataArray($dtListado) ){
		
			foreach( $dtListado as $listado ){
		
				$model = array();
				
				$model['idTipoDocumentoTrabajador'] 		=$listado->idTipoDocumentoTrabajador;
				$model['tipoDocumento']  					=$listado->tipoDocumento;
				
	
				array_push($dtReturn, $model);
				array_push($listadoIdAuditoria, $model['idTipoDocumentoTrabajador']);
			}

		}
		
		//$auditorioController = new AuditoriaController();	
		//$auditoria = $auditorioController->fncGuardar(4, 'tipo_documento_trabajador','id_tipo_documento_trabajador', $id, json_encode($listadoIdAuditoria) );
		
		return $dtReturn;
	}

	

	public function fncGuardar($arrayInputs)
	{

		$inputIdTipoDocumentoTrabajador = (Int) fncObtenerValorArray( $arrayInputs, 'idTipoDocumentoTrabajador', true);
		$inputTipoDocumento = fncObtenerValorArray( $arrayInputs, 'tipoDocumento', true);
		
		
		$tipoDocumentoTrabajador  = new TipoDocumentoTrabajador();

		if( !empty($inputIdTipoDocumentoTrabajador) ) { $tipoDocumentoTrabajador->setIdTipoDocumentoTrabajador($inputIdTipoDocumentoTrabajador); }
		if( !empty($inputTipoDocumento) ) { $tipoDocumentoTrabajador->setTipoDocumento($inputTipoDocumento); }
			
		if( fncGeneralValidarDataArray($tipoDocumentoTrabajador) ){
			$accion=2;
			$dtGuardar = array();
			if ($inputIdTipoDocumentoTrabajador>0) {
				
				$dtGuardar = $this->fncActualizarBD($tipoDocumentoTrabajador);
			}else {
				$accion=1;
				$dtGuardar = $this->fncRegistrarBD($tipoDocumentoTrabajador);
				
			}
			$tipoDocumentoTrabajador->setIdTipoDocumentoTrabajador($dtGuardar->getIdTipoDocumentoTrabajador());
			$returnDocumentoTrabajador["documento_trabajador"] = ($tipoDocumentoTrabajador);
			$auditorioController = new AuditoriaController();	
			$auditoria = $auditorioController->fncGuardar($accion, 'tipo_documento_trabajador','id_tipo_documento_trabajador',$dtGuardar->getIdTipoDocumentoTrabajador(), json_encode($tipoDocumentoTrabajador) );
		}
		
		//$bolReturn = $this->fncCambiarTareaCumplidaBD( $dtTareaNueva, $inputIdTarea, $optArchivo );
		return $returnDocumentoTrabajador;
	}


	//=======================================================================================
	//FUNCIONES BASE DE DATOS
	//=======================================================================================

	private function fncListarRegistrosBD( $id = -1 )
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			tdt.id_tipo_documento_trabajador,
			tdt.tipo_documento
		FROM
			escalafon.tipo_documento_trabajador AS tdt
		WHERE (:id_tipo_documento_trabajador = -1 OR id_tipo_documento_trabajador = :id_tipo_documento_trabajador)	
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_tipo_documento_trabajador', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new TipoDocumentoTrabajador;
			$temp->idTipoDocumentoTrabajador 	= $datos['id_tipo_documento_trabajador'];
			$temp->tipoDocumento 				= $datos['tipo_documento'];

			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}

	private function fncRegistrarBD( $dtModel )
	{
		$sql = cls_control::get_instancia();
	
		$tipo_documento 	= $dtModel->getTipoDocumento();
		$consulta = "INSERT INTO escalafon.tipo_documento_trabajador
		(
			-- id_tipo_documento_trabajador -- this column value is auto-generated
			tipo_documento
		)
		VALUES
		(
			 :tipo_documento
		)
		RETURNING id_tipo_documento_trabajador";
		
		$statement = $sql->preparar( $consulta );
		//var_dump($consulta);
		if ( $statement!=false) {
			$statement->bindParam('tipo_documento',$tipo_documento);
		
			$sql->ejecutar();
			$datos = $statement->fetch(PDO::FETCH_ASSOC);

			if( $datos ){

				$dtModel->setIdTipoDocumentoTrabajador($datos["id_tipo_documento_trabajador"]);

				$sql->cerrar();
				return $dtModel;
			} else {
				$sql->cerrar();
				return false;
			}
		}
	}


	private function fncActualizarBD( $dtModel )
	{
		$sql = cls_control::get_instancia();
		
		$tipo_documento 				= $dtModel->getTipoDocumento();
		$id_tipo_documento_trabajador 	= $dtModel->getIdTipoDocumentoTrabajador();
	

		$consulta = "UPDATE escalafon.tipo_documento_trabajador
		SET
			-- id_tipo_documento_trabajador -- this column value is auto-generated
			tipo_documento = :tipo_documento 
		WHERE id_tipo_documento_trabajador = :id_tipo_documento_trabajador
		RETURNING id_tipo_documento_trabajador";
		
		$statement = $sql->preparar( $consulta );
		//var_dump($consulta);
		if ( $statement!=false) {
			$statement->bindParam('tipo_documento',$tipo_documento);
			$statement->bindParam('id_tipo_documento_trabajador',$id_tipo_documento_trabajador);
		
			
			$sql->ejecutar();
			$datos = $statement->fetch(PDO::FETCH_ASSOC);

			if( $datos ){

				$dtModel->setIdTipoDocumentoTrabajador($datos["id_tipo_documento_trabajador"]);

				$sql->cerrar();
				return $dtModel;
			} else {
				$sql->cerrar();
				return false;
			}
		}
	}

/*	private function fncEliminarBD( $id )
	{
    $bolReturn = false;
		$sql = cls_control::get_instancia();
		$consulta = 'UPDATE escalafon.documento_trabajador
		SET
			-- id_documento_trabajador -- this column value is auto-generated
			
			eliminado = 1
		WHERE id_documento_trabajador = :id_documento_trabajador';
		$statement = $sql->preparar( $consulta );
		if( $statement!=false ){
			$statement->bindParam('id_documento_trabajador', $id);
			$sql->ejecutar();
			$datos = $statement->fetchAll(PDO::FETCH_OBJ); 
			if($datos){
				$bolReturn = true;
      }
      $sql->cerrar();
    }
    return $bolReturn;
  	}*/


} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom


?>