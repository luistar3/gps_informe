<?php
require_once '../../App/Escalafon/Models/NivelEspecializacion.php';
require_once '../../App/Config/control.php';
require_once '../../App/Public/archivo.php';
require_once '../../App/Public/rutas.php';
require_once '../../App/Escalafon/Controllers/AuditoriaController.php';
require_once '../../App/Escalafon/Controllers/TipoNivelEspecializacionController.php';
require_once '../../App/General/Controllers/PersonaNaturalController.php';

class NivelEspecializacionController extends NivelEspecializacion
{
	//=======================================================================================
	//FUNCIONES LOGICA
	//=======================================================================================

	public function fncListarRegistros($id = -1)
	{

		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosBD($id);
		$clsPersonaNaturalController = new PersonaNaturalController();
		$clsTipoNivelEspecializacion = new TipoNivelEspecializacionController();
		$fecha_hora='';
		$clsAuditoriaController = new AuditoriaController();
		if( fncGeneralValidarDataArray($dtListado) ){

			$accion=4;
			$listaAuditoria=array();
			foreach( $dtListado as $listado ){
				$dtAuditoria 	= $clsAuditoriaController->fncBuscarCampoAuditoria('nivel_especializacion','id_nivel_especializacion',$listado->idNivelEspecializacion);
				if(fncGeneralValidarDataArray($dtAuditoria)){
					$Auditoria=array_shift($dtAuditoria);
					$fecha_hora = fncObtenerValorArray($Auditoria, 'fecha_hora', true);
					//$idUsuario = (Int) fncObtenerValorArray($Auditoria, 'id_usuario', true);
				}
				$model = array();
				
				$model['idNivelEspecializacion']	=$listado->idNivelEspecializacion;
				$model['idTrabajador'] 			=$listado->idTrabajador;
				$model['idTipoNivelEspecializacion'] 			=$listado->idTipoNivelEspecializacion;					
				$model["tipoNivelEspecializacion"]    = array_shift($clsTipoNivelEspecializacion->fncListarRegistros($listado->idTipoNivelEspecializacion));
                $model['anio'] 						=$listado->anio;
				$model['nombreEspecializacion'] 	=$listado->nombreEspecializacion;
				$model['procedencia'] 				=$listado->procedencia;
				$model['persona'] 					=array_shift($clsPersonaNaturalController->fncListarRegistros($listado->idTrabajador));
				$model['archivo'] 					=$listado->archivo;
				$model['auditoriaFecha'] 			=$fecha_hora;

				array_push($dtReturn, $model);
				array_push($listaAuditoria, $model['idNivelEspecializacion']);
			}

			$auditorioController = new AuditoriaController();	
			$auditoria = $auditorioController->fncGuardar($accion, 'nivel_especializacion','id_nivel_especializacion', null, json_encode($listaAuditoria) );
		}
		return array_shift(reemplazarNullPorVacioNivelEspecializacion($dtReturn));
	}


	public function fncListarRegistroAuditoria($id)
	{

		$dtReturn = array();
		$dtListado = $this->fncListarRegistroAuditoriaBD($id);
		$clsPersonaNaturalController = new PersonaNaturalController();

		

		if( fncGeneralValidarDataArray($dtListado) ){

			$accion=4;
			$listaAuditoria=array();
			foreach( $dtListado as $listado ){
		
				$model = array();
				
				$model['id_nivel_especializacion']	=$listado->idNivelEspecializacion;
				$model['id_trabajador'] 			=$listado->idTrabajador;
				
				$model['id_tipo_nivel_especializacion']=$listado->idTipoNivelEspecializacion;
                $model['anio'] 						=$listado->anio;
				$model['nombre_especializacion'] 	=$listado->nombreEspecializacion;
				$model['procedencia'] 				=$listado->procedencia;
				$model['eliminado'] 				=$listado->eliminado;
				$model['archivo'] 					=$listado->archivo;
				

				array_push($dtReturn, $model);
				array_push($listaAuditoria, $model['id_nivel_especializacion']);
			}

			//$auditorioController = new AuditoriaController();	
			//$auditoria = $auditorioController->fncGuardar($accion, 'nivel_especializacion','id_nivel_especializacion', null, json_encode($listaAuditoria) );
		}
		return $dtReturn;
	}

	public function fncListarRegistrosPorIdTrabajador($id = -1)
	{

		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosPorIdTrabajadorBD($id);
		$clsPersonaNaturalController = new PersonaNaturalController();
		$clsTipoNivelEspecializacion = new TipoNivelEspecializacionController();
		$clsAuditoriaController = new AuditoriaController();
		$fecha_hora='';
		if( fncGeneralValidarDataArray($dtListado) ){
			
			$accion=4;
			$listaAuditoria=array();
			foreach( $dtListado as $listado ){
				$dtAuditoria 	= $clsAuditoriaController->fncBuscarCampoAuditoria('nivel_especializacion','id_nivel_especializacion',$listado->idNivelEspecializacion);
				if(fncGeneralValidarDataArray($dtAuditoria)){
					$Auditoria=array_shift($dtAuditoria);
					$fecha_hora = fncObtenerValorArray($Auditoria, 'fecha_hora', true);
					//$idUsuario = (Int) fncObtenerValorArray($Auditoria, 'id_usuario', true);
				}
		
		
				$model = array();
				
				$model['idNivelEspecializacion']	=$listado->idNivelEspecializacion;
				$model['idTrabajador'] 			=$listado->idTrabajador;
				$model['idTipoNivelEspecializacion'] =$listado->idTipoNivelEspecializacion;					
				$model["tipoNivelEspecializacion"]    = array_shift($clsTipoNivelEspecializacion->fncListarRegistros($listado->idTipoNivelEspecializacion));
                $model['anio'] 						=$listado->anio;
				$model['nombreEspecializacion'] 	=$listado->nombreEspecializacion;
				$model['procedencia'] 				=$listado->procedencia;
				$model['persona'] 					= array_shift($clsPersonaNaturalController->fncListarRegistros($listado->idTrabajador));
				$model['archivo'] 					=$listado->archivo;
				$model['auditoriaFecha'] 			=$fecha_hora;

				array_push($dtReturn, $model);
				array_push($listaAuditoria, $model['id_nivel_especializacion']);
			}

			$auditorioController = new AuditoriaController();	
			$auditoria = $auditorioController->fncGuardar($accion, 'nivel_especializacion','id_nivel_especializacion', null, json_encode($listaAuditoria) );
		}
		return (reemplazarNullPorVacioNivelEspecializacion($dtReturn));
	}



	public function fncListarRegistrosPorDniTrabajador($arrayInputs)
	{

		$dtReturn = array();
		$dni = fncObtenerValorArray( $arrayInputs, 'dni', true);
		$dtListado = $this->fncListarRegistrosPorDniTrabajadorBD($dni);
		$clsPersonaNaturalController = new PersonaNaturalController();
		$clsTipoNivelEspecializacion = new TipoNivelEspecializacionController();
		$clsAuditoriaController = new AuditoriaController();
		$fecha_hora='';
		if( fncGeneralValidarDataArray($dtListado) ){
			
			$accion=4;
			$listaAuditoria=array();
			foreach( $dtListado as $listado ){
						
				$model = array();
				
				$model['idNivelEspecializacion']	=$listado->idNivelEspecializacion;
				//$model['nombre_completo']			=$listado->nombreCompleto;
				$model['idTrabajador'] 			=$listado->idTrabajador;				
				$model["TipoNivelEspecializacion"]    = array_shift($clsTipoNivelEspecializacion->fncListarRegistros($listado->idTipoNivelEspecializacion));
                $model['anio'] 						=$listado->anio;
				$model['nombre_especializacion'] 	=$listado->nombreEspecializacion;
				$model['procedencia'] 				=$listado->procedencia;	
				$model['persona'] 					  = array_shift( $clsPersonaNaturalController->fncListarRegistros($listado->idTrabajador));			
				$model['archivo'] 					=$listado->archivo;
				//$model['eliminado'] 					=$listado->eliminado;
				$model['auditoriaFecha'] 			=$listado->fechaHoraAuditoria;
			//	$model['usuario_auditoria'] 			=$listado->usuarioAuditoria;



			


				array_push($dtReturn, $model);
				array_push($listaAuditoria, $model['id_nivel_especializacion']);
			}

			$auditorioController = new AuditoriaController();	
			$auditoria = $auditorioController->fncGuardar($accion, 'nivel_especializacion','id_nivel_especializacion', null, json_encode($listaAuditoria) );
		}
		return reemplazarNullPorVacioNivelEspecializacion($dtReturn);
	}

	public function fncGuardar($arrayInputs){

		$dtReturn = array();
		$accion ="";
		
		$idNivelEspecializacion = (Int) fncObtenerValorArray( $arrayInputs, 'idNivelEspecializacion', true);
		$idTrabajador = fncObtenerValorArray( $arrayInputs, 'idTrabajador', true);
		$idTipoNivelEspecializacion = fncObtenerValorArray( $arrayInputs, 'idTipoNivelEspecializacion', true);
		$anio = fncObtenerValorArray( $arrayInputs, 'anio', true);
		$nombreEspecializacion = fncObtenerValorArray( $arrayInputs, 'nombreEspecializacion', true);
		$procedencia = fncObtenerValorArray( $arrayInputs, 'procedencia', true);

		$dtNivelEspecializacion = new NivelEspecializacion;



		if( !empty($idNivelEspecializacion) )  { $dtNivelEspecializacion->setIdNivelEspecializacion($idNivelEspecializacion); }
		if( !empty($idTrabajador) ) 		{ $dtNivelEspecializacion->setIdTrabajador($idTrabajador); }
		if( !empty($idTipoNivelEspecializacion) ) 			{ $dtNivelEspecializacion->setIdTipoNivelEspecializacion($idTipoNivelEspecializacion); }
		if( !empty($anio) ) 	{ $dtNivelEspecializacion->setAnio($anio); }
		if( !empty($nombreEspecializacion) ) 		{ $dtNivelEspecializacion->setNombreEspecializacion($nombreEspecializacion); }
		if( !empty($procedencia) ) 			{ $dtNivelEspecializacion->setProcedencia( $procedencia); }

		if( fncGeneralValidarDataArray($dtNivelEspecializacion) ){
			$accion='';
			$dtGuardar=array();
			if( $idNivelEspecializacion == 0 ){
				$accion=1;
				$dtNivelEspecializacion->setEliminado(0);
				$dtGuardar = $this->fncRegistrarBD($dtNivelEspecializacion);
								
			} else{

				$accion=2;
				$dtNivelEspecializacion->setEliminado(0);
				$dtGuardar = $this->fncActualizarBD($dtNivelEspecializacion);
				
			}
		}
		
		
		if(fncGeneralValidarDataArray($dtGuardar) ){
			$fecha_hora = '';
			$clsAuditoriaController = new AuditoriaController();
			$auditorioController = new AuditoriaController();
			$clsPersonaNaturalController = new PersonaNaturalController();	
			$clsTipoNivelEspecializacion = new TipoNivelEspecializacionController();
			$auditoria = $auditorioController->fncGuardar($accion, 'nivel_especializacion','id_nivel_especializacion', $dtNivelEspecializacion->getIdNivelEspecializacion(), json_encode($dtGuardar) );
			$dtAuditoria 	= $clsAuditoriaController->fncBuscarCampoAuditoria('nivel_especializacion', 'id_nivel_especializacion', $dtGuardar->getIdNivelEspecializacion());
			if (fncGeneralValidarDataArray($dtAuditoria)) {
				$Auditoria = array_shift($dtAuditoria);
				$fecha_hora = fncObtenerValorArray($Auditoria, 'fecha_hora', true);
				//$idUsuario = (Int) fncObtenerValorArray($Auditoria, 'id_usuario', true);
			}
			$model = array();
			$model["idNivelEspecializacion"]      = $dtGuardar->getIdNivelEspecializacion();	
			$model["idTrabajador"]         		  = $dtGuardar->getIdTrabajador();
			$model["tipoNivelEspecializacion"]    = array_shift($clsTipoNivelEspecializacion->fncListarRegistros($dtGuardar->getIdTipoNivelEspecializacion()));
			//$model["fechaDocumento"]   			  = fncFormatearFecha($dtGuardar->getFechaDocumento());
			$model["anio"]  					  = $dtGuardar->getAnio();
			$model["nombreEspecializacion"]      = $dtGuardar->getNombreEspecializacion();
			$model["procedencia"]              	  = ($dtGuardar->getProcedencia());
			$model['persona'] 					  = array_shift( $clsPersonaNaturalController->fncListarRegistros($dtGuardar->getIdTrabajador()));
			$model["archivo"]		              = $dtGuardar->getArchivo();
			$model['auditoriaFecha'] 			  = $fecha_hora;
\

			array_push($dtReturn, $model);

			$dataRetorno = array_shift($dtReturn);
			$dtNivelEspecializacion->getIdNivelEspecializacion($dtNivelEspecializacion->getIdNivelEspecializacion());			
			$returnNivelEspecializacion  = $dtNivelEspecializacion;
			$dtGuardar = $returnNivelEspecializacion;
			
			unset($model);

		}

		  return reemplazarNullPorVacioNivelEspecializacion($dataRetorno);

	}



	public function fncEliminarRegistro($id = 0)
	{

		$bolReturn = array();
		if( $id > 0 ){
		$bolValidarEliminar = $this->fncEliminarBD( $id );
		if($bolValidarEliminar){
		/*//_Elminamos la foto
			$dtPersonaNatural = new PersonaNatural;
			$dtPersonaNatural = $this->fncListarRegistrosBD($id);
			//$dtPersonaNatural = $this->fncSetear($dtPersonaNatural);
			$optFoto = $dtPersonaNatural->getFoto();
			$optRutaFoto = cls_rutas::get('personaImg'); //$optRutaFoto = '../../img/Admin/persona/';
			if(!empty($optFoto) && file_exists($optRutaFoto.$optFoto)){ unlink($optRutaFoto.$optFoto); }
		//_Eliminamos el registro
			$bolReturn = $this->fncEliminarBD( $id );  */
		
			$dtNivelEspecializacion  = $this ->fncListarRegistroAuditoria($id);
			$returnNicelEspecializacion = array_shift( $dtNivelEspecializacion);
			$bolReturn=$returnNicelEspecializacion;
			
			$auditorioController = new AuditoriaController();	
			$auditoria = $auditorioController->fncGuardar(2, 'nivel_especializacion','id_nivel_especializacion', $id, json_encode($dtNivelEspecializacion) );
		}
		}
		return $bolReturn;
	}


	public function fncGuardarDocumento($archivoInput='')
	{
		$optArchivo="";
		$dtReturn = array();
			if(!empty($archivoInput)){
				if($archivoInput["name"]<>""){
					$optRutaArchivo = cls_rutas::get('nivelEspecializacionPdf');
					//$rutas=fncObtenerRuta();
					$nombreArchivo = fncConstruirNombreDocumentoNivelEspecializacion($archivoInput);
					$obj_arc = new archivo($archivoInput,$optRutaArchivo,"pdf_".$nombreArchivo,0);
					if ($obj_arc->subir()) {
						$optArchivo = $obj_arc->get_nombre_archivo();
						//$optArchivo = $obj_arc->get_nombre_archivo();
						$objArrayDocumento = array(
							"Nombre"=>$optRutaArchivo.$obj_arc->get_nombre_archivo(),
							"NombreOriginal"=>$archivoInput["name"],
							"Ruta"=>$optRutaArchivo.$obj_arc->get_nombre_archivo(),
							"Tamanio" =>$archivoInput["size"],
						
						);
						array_push($dtReturn,$objArrayDocumento);

					}
				}
			}

		return $dtReturn;
	}

	public function fncGuardarDocumentoNivelEspecializacion($arrayInputs='', $archivo=''){

		$dtReturn = array();
		$accion =2;
		
		$idNivelEspecializacion 	= (Int) fncObtenerValorArray( $arrayInputs, 'idNivelEspecializacion', true);
		$dtNivelEspecializacion = new NivelEspecializacion;

		if( !empty($idNivelEspecializacion) )  { $dtNivelEspecializacion->setIdNivelEspecializacion($idNivelEspecializacion); }
		if( fncGeneralValidarDataArray($dtNivelEspecializacion) ){
			$dtDocumento = $this->fncGuardarDocumento($archivo);
			if( fncGeneralValidarDataArray($dtDocumento) ){
				$nombreArchivo = fncObtenerValorArray( array_shift($dtDocumento), 'Nombre', true);
				if( !empty($idNivelEspecializacion) )  { $dtNivelEspecializacion->setArchivo($nombreArchivo); }
				$dtGuardar = $this->fncActualizaDocumentoBD($dtNivelEspecializacion);

			}
		
		}
		
		if(fncGeneralValidarDataArray($dtGuardar) ){

			$dtListado = $this->fncListarRegistros($idNivelEspecializacion);
			$returnNivelEspecializacion = ( $dtListado);
			$auditorioController = new AuditoriaController();	
			$auditoria = $auditorioController->fncGuardar($accion, 'nivel_especializacion','id_nivel_especializacion', $dtNivelEspecializacion->getIdNivelEspecializacion(), json_encode($dtListado) );
			array_push($dtReturn ,( $returnNivelEspecializacion));
			


		}

		  return reemplazarNullPorVacioNivelEspecializacion(array_shift($dtReturn));

	}
	//=======================================================================================
	//FUNCIONES BASE DE DATOS
	//=======================================================================================

	private function fncListarRegistrosBD( $id = -1 )
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			ne.id_nivel_especializacion,
			ne.id_trabajador,
			ne.id_tipo_nivel_especializacion,
			ne.anio,
			ne.nombre_especializacion,
			ne.procedencia,
			ne.archivo,
			ne.eliminado
		FROM
			escalafon.nivel_especializacion AS ne
		WHERE 
			(:id_nivel_especializacion = -1 OR id_nivel_especializacion = :id_nivel_especializacion)  AND ne.eliminado = 0
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_nivel_especializacion', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new NivelEspecializacion;
			$temp->idNivelEspecializacion = $datos['id_nivel_especializacion'];
			$temp->idTrabajador 			= $datos['id_trabajador'];
			$temp->idTipoNivelEspecializacion 					= $datos['id_tipo_nivel_especializacion'];
            $temp->anio						= $datos['anio'];
			$temp->nombreEspecializacion	= $datos['nombre_especializacion'];
			$temp->procedencia				= $datos['procedencia'];
			$temp->archivo					= $datos['archivo'];
	

			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}


	private function fncListarRegistroAuditoriaBD( $id  )
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			ne.id_nivel_especializacion,
			ne.id_trabajador,
			ne.id_tipo_nivel_especializacion,
			ne.anio,
			ne.nombre_especializacion,
			ne.procedencia,
			ne.archivo,
			ne.eliminado
		FROM
			escalafon.nivel_especializacion AS ne
		WHERE 
			(:id_nivel_especializacion = -1 OR id_nivel_especializacion = :id_nivel_especializacion) 
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_nivel_especializacion', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new NivelEspecializacion;
			$temp->idNivelEspecializacion = $datos['id_nivel_especializacion'];
			$temp->idTrabajador 			= $datos['id_trabajador'];
			$temp->tipo 					= $datos['id_tipo_nivel_especializacion'];
            $temp->anio						= $datos['anio'];
			$temp->nombreEspecializacion	= $datos['nombre_especializacion'];
			$temp->procedencia				= $datos['procedencia'];
			$temp->eliminado				= $datos['eliminado'];
			$temp->archivo					= $datos['archivo'];
	

			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}

	private function fncListarRegistrosPorIdTrabajadorBD( $id = -1 )
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			ne.id_nivel_especializacion,
			ne.id_trabajador,
			ne.id_tipo_nivel_especializacion,
			ne.anio,
			ne.nombre_especializacion,
			ne.procedencia,
			ne.archivo,
			ne.eliminado
		FROM
			escalafon.nivel_especializacion AS ne
		WHERE 
			(id_trabajador = :id_trabajador)  AND ne.eliminado = 0
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_trabajador', $id);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new NivelEspecializacion;
			$temp->idNivelEspecializacion = $datos['id_nivel_especializacion'];
			$temp->idTrabajador 			= $datos['id_trabajador'];
			$temp->idTipoNivelEspecializacion 					= $datos['id_tipo_nivel_especializacion'];
            $temp->anio						= $datos['anio'];
			$temp->nombreEspecializacion	= $datos['nombre_especializacion'];
			$temp->procedencia				= $datos['procedencia'];
			$temp->archivo					= $datos['archivo'];
	

			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}


	private function fncListarRegistrosPorDniTrabajadorBD( $dni )
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			pn.nombre_completo,
			ne.id_nivel_especializacion,
			ne.id_trabajador,
			ne.id_tipo_nivel_especializacion,
			ne.anio,
			ne.nombre_especializacion,
			ne.procedencia,
			ne.eliminado,
			ne.archivo,
				(SELECT	a.fecha_hora FROM escalafon.auditoria  AS a WHERE ( a.id_operacion = 1 OR a.id_operacion = 2 )
					AND a.tabla = \'nivel_especializacion\' AND a.objeto_id_nombre = \'id_nivel_especializacion\' AND a.objeto_id_valor = ne.id_nivel_especializacion
					ORDER BY a.id_auditoria DESC LIMIT 1 ),
				(SELECT
							pn.nombre_completo  AS usuario_auditoria
						FROM adm.usuario u
						LEFT JOIN public.persona_natural pn ON pn.id_persona = u.id_persona
						WHERE u.id_usuario = (SELECT	aa.id_usuario	FROM escalafon.auditoria  AS aa WHERE ( aa.id_operacion = 1 OR aa.id_operacion = 2 )
						AND aa.tabla = \'nivel_especializacion\' AND aa.objeto_id_nombre = \'id_nivel_especializacion\' AND aa.objeto_id_valor = ne.id_nivel_especializacion
						ORDER BY aa.id_auditoria DESC LIMIT 1))
		FROM
			escalafon.nivel_especializacion AS ne
		INNER JOIN escalafon.trabajador AS t ON t.id_trabajador = ne.id_trabajador
		INNER JOIN public.persona_natural AS pn ON pn.id_persona = t.id_trabajador
		INNER JOIN public.persona AS p ON p.id_persona = pn.id_persona
		
		WHERE 
			(documento_identidad = :documento_identidad)  AND ne.eliminado = 0
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('documento_identidad', $dni);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new NivelEspecializacion;
			$temp->idNivelEspecializacion 	= $datos['id_nivel_especializacion'];
			$temp->nombreCompleto 			= $datos['nombre_completo'];
			$temp->idTrabajador 			= $datos['id_trabajador'];
			$temp->idTipoNivelEspecializacion 					= $datos['id_tipo_nivel_especializacion'];
            $temp->anio						= $datos['anio'];
			$temp->nombreEspecializacion	= $datos['nombre_especializacion'];
			$temp->procedencia				= $datos['procedencia'];
			$temp->eliminado				= $datos['eliminado'];
			$temp->archivo					= $datos['archivo'];
			$temp->fechaHoraAuditoria		= $datos['fecha_hora'];
			$temp->usuarioAuditoria			= $datos['usuario_auditoria'];
	

			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}


	private function fncRegistrarBD($dtNivelEspecializacion)
	{

		
		$idTrabajador				=$dtNivelEspecializacion->getIdTrabajador();
		$idTipoNivelEspecializacion	=$dtNivelEspecializacion->getIdTipoNivelEspecializacion();
		$anio						=$dtNivelEspecializacion->getAnio();
		$nombreEspecializacion		=$dtNivelEspecializacion->getNombreEspecializacion();
		$procedencia				=$dtNivelEspecializacion->getProcedencia();

	
	

		$sql = cls_control::get_instancia();
		$query = '
		INSERT INTO escalafon.nivel_especializacion
		(
			-- id_nivel_especializacion -- this column value is auto-generated
			id_trabajador,
			id_tipo_nivel_especializacion,
			anio,
			nombre_especializacion,
			procedencia
			
		)
		VALUES
		(
			:id_trabajador,
			:id_tipo_nivel_especializacion,
			:anio,
			:nombre_especializacion,
			:procedencia 
		
		) RETURNING id_nivel_especializacion
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_trabajador', $idTrabajador);
			$statement->bindParam('id_tipo_nivel_especializacion', $idTipoNivelEspecializacion);
			$statement->bindParam('anio', $anio);
			$statement->bindParam('nombre_especializacion', $nombreEspecializacion);
			$statement->bindParam('procedencia', $procedencia);
	

			$sql->ejecutar();
		$datos = $statement->fetch(PDO::FETCH_ASSOC);
		if($datos){
		//_Retorno de Datos
		  $dtNivelEspecializacion->setIdNivelEspecializacion($datos["id_nivel_especializacion"]);
		
		//_Cerrar
		  $sql->cerrar();
		  return $dtNivelEspecializacion; 
		}else{
		  $sql->cerrar();
		  return false;
		}
	  }else{
		return false;
	  }
	}




	private function fncActualizarBD($dtNivelEspecializacion)
	{
		$idNivelEspecializacion	=$dtNivelEspecializacion->getIdNivelEspecializacion();
		$idTrabajador			=$dtNivelEspecializacion->getIdTrabajador();
		$idTipoNivelEspecializacion	=$dtNivelEspecializacion->getIdTipoNivelEspecializacion();
		$anio					=$dtNivelEspecializacion->getAnio();
		$nombreEspecializacion	=$dtNivelEspecializacion->getNombreEspecializacion();
		$procedencia			=$dtNivelEspecializacion->getProcedencia();


	
		$sql = cls_control::get_instancia();
		$query = '
		UPDATE escalafon.nivel_especializacion
		SET
			-- id_nivel_especializacion -- this column value is auto-generated
			id_trabajador 	= :id_trabajador,
			id_tipo_nivel_especializacion 			= :id_tipo_nivel_especializacion,
			anio 			= :anio,
			nombre_especializacion = :nombre_especializacion,
			procedencia 	= :procedencia
			
	
		WHERE id_nivel_especializacion = :id_nivel_especializacion 
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_nivel_especializacion', $idNivelEspecializacion);
			$statement->bindParam('id_trabajador', $idTrabajador);
			$statement->bindParam('id_tipo_nivel_especializacion', $idTipoNivelEspecializacion);
			$statement->bindParam('anio', $anio);
			$statement->bindParam('nombre_especializacion', $nombreEspecializacion);
			$statement->bindParam('procedencia', $procedencia);
			
	
			$sql->ejecutar();
			$rs = $statement->fetchAll(PDO::FETCH_OBJ);
			if($rs){
			$sql->cerrar();
			return $dtNivelEspecializacion;
			}else{
			$sql->cerrar();
			return false;
			}
		}
		return $arrayReturn;
	}


	private function fncEliminarBD( $id )
	{
    $bolReturn = false;
		$sql = cls_control::get_instancia();
		$consulta = 'UPDATE escalafon.nivel_especializacion
		SET
		
			eliminado = 1
		WHERE id_nivel_especializacion = :id_nivel_especializacion';
		$statement = $sql->preparar( $consulta );
		if( $statement!=false ){
			$statement->bindParam('id_nivel_especializacion', $id);
			$sql->ejecutar();
			$datos = $statement->fetchAll(PDO::FETCH_OBJ); 
			if($datos){
				$bolReturn = true;
      }
      $sql->cerrar();
    }
    return $bolReturn;
	  }
	  

	  private function fncActualizaDocumentoBD($dtNivelEspecializacion)
	  {
		  $archivo	=$dtNivelEspecializacion->getArchivo();
		  $id_nivel_educativo	=$dtNivelEspecializacion->getIdNivelEspecializacion();
  
	  
		  $sql = cls_control::get_instancia();
		  $query = '
		  UPDATE escalafon.nivel_especializacion
		  SET
			
			  archivo = :archivo
  
		  WHERE id_nivel_especializacion = :id_nivel_especializacion 
		  ';
  
		  $statement = $sql->preparar( $query );
		  $arrayReturn = array();
  
		  if( $statement!=false ){
			  $statement->bindParam('archivo', $archivo);
			  $statement->bindParam('id_nivel_especializacion', $id_nivel_educativo);
	  
			  
	  
			  $sql->ejecutar();
			  $rs = $statement->fetchAll(PDO::FETCH_OBJ);
			  if($rs){
			  $sql->cerrar();
			  return $dtNivelEspecializacion;
			  }else{
			  $sql->cerrar();
			  return false;
			  }
		  }
		  return $arrayReturn;
	  }



} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom
function fncConstruirNombreDocumentoNivelEspecializacion($archivo){
	$nombre = fncQuitarExtensionDocumentoNivelEspecializacion($archivo['name']).'_'.uniqid().'_';
	return $nombre;
}


function fncQuitarExtensionDocumentoNivelEspecializacion($string){
    $a = explode('.', $string);
    array_pop($a);
    return implode('.', $a);
}

function reemplazarNullPorVacioNivelEspecializacion($array)
{
	foreach ($array as $key => $value) 
	{
		if(is_array($value))
			$array[$key] = reemplazarNullPorVacioNivelEspecializacion($value);
		else
		{
			if (is_null($value))
				$array[$key] = "";
		}
	}
	return $array;
}

?>