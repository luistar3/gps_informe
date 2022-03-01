<?php
require_once '../../App/Escalafon/Models/TrabajadorFamiliar.php';
require_once '../../App/Config/control.php';
require_once '../../App/Escalafon/Controllers/FamiliarController.php';
require_once '../../App/Escalafon/Controllers/TrabajadorController.php';
require_once '../../App/Escalafon/Controllers/TipoFamiliarController.php';

class TrabajadorFamiliarController extends TrabajadorFamiliar
{
	//=======================================================================================
	//FUNCIONES LOGICA
	//=======================================================================================

	public function fncListarRegistros($id = -1)
	{

		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosBD($id);

		if (fncGeneralValidarDataArray($dtListado)) {
			$listadoIdAuditoria = array();
			$clsFamiliar	 	= new FamiliarController();
			$clsTrabajador 		= new TrabajadorController();
			$clsTipoFamiliar 	= new TipoFamiliarController();
			foreach ($dtListado as $listado) {

				$model = array();

				$model['idTrabajadorFamiliar']	= $listado->idTrabajadorFamiliar;
				$model['idTrabajador']				= $listado->idTrabajador;
				$model['trabajador']				= array_shift($this->fncListarDatosTrabajador( $listado->idTrabajador));
				//$model['trabajador']				= array_shift( $clsTrabajador->fncListarRegistros($listado->idTrabajador));
				$model['idTipoFamiliar']			= $listado->idTipoFamiliar;
				$model['tipoFamiliar']				= array_shift( $clsTipoFamiliar->fncListarRegistros($listado->idTipoFamiliar));
				$model['idFamiliar']				= $listado->idFamiliar;
				$model['familiar']					= array_shift( $clsFamiliar->fncListarRegistros($listado->idFamiliar));
				//$model['eliminado']					=$listado->eliminado;

				array_push($dtReturn, $model);
				array_push($listadoIdAuditoria, $model['idTrabajadorFamiliar']);
			}
			$dataRetorno=($model);
			$auditorioController = new AuditoriaController();
			$auditoria = $auditorioController->fncGuardar(4, 'trabajador_familiar', 'id_trabajador_familiar', null, json_encode($listadoIdAuditoria));
		}
		return $dtReturn;
	}
	public function fncListarRegistrosPorId($id = -1)
	{

		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosBD($id);
		$dataRetorno=array();
		if (fncGeneralValidarDataArray($dtListado)) {
			$listadoIdAuditoria = array();
			$clsFamiliar	 	= new FamiliarController();
			$clsTrabajador 		= new TrabajadorController();
			$clsTipoFamiliar 	= new TipoFamiliarController();
			foreach ($dtListado as $listado) {

				$model = array();

				$model['idTrabajadorFamiliar']	= $listado->idTrabajadorFamiliar;
				$model['idTrabajador']				= $listado->idTrabajador;
				$model['trabajador']				= array_shift($this->fncListarDatosTrabajador( $listado->idTrabajador));
				//$model['trabajador']				= array_shift( $clsTrabajador->fncListarRegistros($listado->idTrabajador));
				$model['idTipoFamiliar']			= $listado->idTipoFamiliar;
				$model['tipoFamiliar']				= array_shift( $clsTipoFamiliar->fncListarRegistros($listado->idTipoFamiliar));
				$model['idFamiliar']				= $listado->idFamiliar;
				$model['familiar']					= array_shift( $clsFamiliar->fncListarRegistros($listado->idFamiliar));
				//$model['eliminado']					=$listado->eliminado;

				array_push($dtReturn, $model);
				array_push($listadoIdAuditoria, $model['idTrabajadorFamiliar']);
			}
			$dataRetorno=($model);
			$auditorioController = new AuditoriaController();
			$auditoria = $auditorioController->fncGuardar(4, 'trabajador_familiar', 'id_trabajador_familiar', null, json_encode($listadoIdAuditoria));
		}
		return  ( $dataRetorno);
	}

	public function fncValidarParentesco($arrayInputs)
	{

		$dtReturn = array();
		$dtRetorno = array();
		$idTrabajadorFamiliar = (int) fncObtenerValorArray($arrayInputs, 'idTrabajadorFamiliar', true);
		$idTrabajador = (int) fncObtenerValorArray($arrayInputs, 'idTrabajador', true);
		$idFamiliar = (int) fncObtenerValorArray($arrayInputs, 'idFamiliar', true);
		$dtListado = $this->fncValidarParentescoBD($idTrabajadorFamiliar,$idTrabajador,$idFamiliar);

		if (fncGeneralValidarDataArray($dtListado)) {
		
			foreach ($dtListado as $listado) {

				$model = array();

				$model['campo']	 = $listado->campo;
				$model['existe'] = $listado->existe;
			

				array_push($dtReturn, $model);
			
			}
			$dtRetorno = $model;
			$dtReturn = array_shift($dtReturn);
		}
		return $dtReturn;
	}

	public function fncListarPorIdTrabajador($id = 0)
	{

		$dtReturn = array();
		$dtListado = $this->fncListarPorIdTrabajadorBD($id);

		if (fncGeneralValidarDataArray($dtListado)) {
			$listadoIdAuditoria = array();
			$clsFamiliar	 	= new FamiliarController();
			$clsTrabajador 		= new TrabajadorController();
			$clsTipoFamiliar 	= new TipoFamiliarController();
			foreach ($dtListado as $listado) {

				$model = array();

				$model['idTrabajadorFamiliar']	= $listado->idTrabajadorFamiliar;
				$model['idTrabajador']				= $listado->idTrabajador;
				$model['trabajador']				= array_shift($this->fncListarDatosTrabajador( $listado->idTrabajador));
				//$model['trabajador']				= array_shift( $clsTrabajador->fncListarRegistros($listado->idTrabajador));
				$model['idTipoFamiliar']			= $listado->idTipoFamiliar;
				$model['tipoFamiliar']				= array_shift( $clsTipoFamiliar->fncListarRegistros($listado->idTipoFamiliar));
				$model['idFamiliar']				= $listado->idFamiliar;
				$model['familiar']					= array_shift( $clsFamiliar->fncListarRegistros($listado->idFamiliar));
				//$model['eliminado']					=$listado->eliminado;

				array_push($dtReturn, $model);
				array_push($listadoIdAuditoria, $model['idTrabajadorFamiliar']);
			}

			$auditorioController = new AuditoriaController();
			$auditoria = $auditorioController->fncGuardar(4, 'trabajador_familiar', 'id_trabajador_familiar', null, json_encode($listadoIdAuditoria));
		}
		return $dtReturn;
	}


	public function fncListarDatosTrabajador($id = 0)//lista algunos datos del trabajador
	{

		$dtReturn = array();
		$dtListado = $this->fncListarDatosTrabajadorBD($id);

		if (fncGeneralValidarDataArray($dtListado)) {
			$listadoIdAuditoria = array();
	
			foreach ($dtListado as $listado) {

				$model = array();

				$model['documentoIdentidad']	= $listado->documentoIdentidad;
				$model['nombre']				= $listado->nombre;
			

				array_push($dtReturn, $model);
				unset($model);
				
			}

		
		}
		return $dtReturn;
	}




	public function fncListarTrabajadoresFamiliar($arrayInputs)
	{
		$dni =  fncObtenerValorArray($arrayInputs, 'dni', true);
		$dtReturn = array();
		$dtListado = $this->fncListarTrabajadoresFamiliarBD($dni);
		$clsFamiliar	 	= new FamiliarController();
		$clsTrabajador 		= new TrabajadorController();
		$clsTipoFamiliar 	= new TipoFamiliarController();
		if (fncGeneralValidarDataArray($dtListado)) {
			$listadoIdAuditoria = array();
			$clsFamiliar	 	= new FamiliarController();
			$clsTrabajador 		= new TrabajadorController();
			$clsTipoFamiliar 	= new TipoFamiliarController();
			foreach ($dtListado as $listado) {

				$model = array();

				/*$model['idTrabajadorFamiliar']		= $listado->idTrabajadorFamiliar;
				$model['nombreFamiliar']				= $listado->nombreFamiliar;
				$model['documentoIdentidadFamiliar']	= $listado->dniFamiliar;
				$model['idFamiliar']					= $listado->idFamiliar;
				$model['idTipoFamiliar']				= $listado->idTipoFamiliar;
				$model['tipoFamiliar']					= $listado->tipoFamiliar;
				$model['idTrabajador']					= $listado->idTrabajador;
				$model['idTipoFamiliar']				= $listado->idTipoFamiliar;
				$model['nombreCompletoTrabajador']	= $listado->nombreCompletoTrabajador;
				$model['documentoIdentidadTrabajador']= $listado->dniTrabajador;
				$model['eliminado']						= $listado->eliminado;*/  /* ANTERIOR FORMATO */


				$model['idTrabajadorFamiliar']	= $listado->idTrabajadorFamiliar;
				$model['idTrabajador']				= $listado->idTrabajador;
				$model['trabajador']				= array_shift($this->fncListarDatosTrabajador( $listado->idTrabajador));
				//$model['trabajador']				= array_shift( $clsTrabajador->fncListarRegistros($listado->idTrabajador));
				$model['idTipoFamiliar']			= $listado->idTipoFamiliar;
				$model['tipoFamiliar']				= array_shift( $clsTipoFamiliar->fncListarRegistros($listado->idTipoFamiliar));
				$model['idFamiliar']				= $listado->idFamiliar;
				$model['familiar']					= array_shift( $clsFamiliar->fncListarRegistros($listado->idFamiliar));
				//$model['eliminado']					=$listado->eliminado;

				array_push($dtReturn, $model);
				array_push($listadoIdAuditoria, $model['idTrabajadorFamiliar']);
			}

			$auditorioController = new AuditoriaController();
			$auditoria = $auditorioController->fncGuardar(4, 'trabajador_familiar', 'id_trabajador_familiar', null, json_encode($listadoIdAuditoria));
		}
		return $dtReturn;
	}


	

	public function fncGuardar($arrayInputs)
	{

		$dtReturn = array();
		$accion = "";
		$idTrabajadorFamiliar = (int) fncObtenerValorArray($arrayInputs, 'idTrabajadorFamiliar', true);
		$idTrabajador = (int) fncObtenerValorArray($arrayInputs, 'idTrabajador', true);
		$idTipoFamiliar = (int) fncObtenerValorArray($arrayInputs, 'idTipoFamiliar', true);
		$idFamiliar = (int) fncObtenerValorArray($arrayInputs, 'idFamiliar', true);

		$dtTrabajadorFamiliar = new TrabajadorFamiliar;

		if (!empty($idTrabajadorFamiliar)) {
			$dtTrabajadorFamiliar->setIdTrabajadorFamiliar($idTrabajadorFamiliar);
		}
		if (!empty($idTrabajador)) {
			$dtTrabajadorFamiliar->setIdTrabajador($idTrabajador);
		}
		if (!empty($idTipoFamiliar)) {
			$dtTrabajadorFamiliar->setIdTipoFamiliar($idTipoFamiliar);
		}
		if (!empty($idFamiliar)) {
			$dtTrabajadorFamiliar->setIdFamiliar($idFamiliar);
		}

		if (fncGeneralValidarDataArray($dtTrabajadorFamiliar)) {
			$accion = '';
			$dtGuardar = array();
			if ($idTrabajadorFamiliar == 0) {
				$trabajadorFamiliar = $this->fncValidarRelacionFamiliar($idTrabajadorFamiliar, $idTrabajador, $idFamiliar);
				if (count($trabajadorFamiliar) == 0) {
					$accion = 1;
					$dtGuardar = $this->fncRegistrarBD($dtTrabajadorFamiliar);
				}
			} else {
				$trabajadorFamiliar = $this->fncValidarRelacionFamiliar($idTrabajadorFamiliar, $idTrabajador, $idFamiliar);
				if (count($trabajadorFamiliar) == 0) {
					$accion = 2;
					$dtGuardar = $this->fncActualizarBD($dtTrabajadorFamiliar);
				}
			}
		}

		if (fncGeneralValidarDataArray($dtGuardar)) {

			//$auditorioController = new AuditoriaController();

			//$auditoria = $auditorioController->fncGuardar('familiar',$dtGuardar->getIdFamiliar(),$dtGuardar,$accion);
			$auditorioController = new AuditoriaController();
			$auditoria = $auditorioController->fncGuardar($accion, 'trabajador_familiar', 'id_trabajador_familiar', $dtTrabajadorFamiliar->getIdTrabajadorFamiliar(), json_encode($dtGuardar));

			$dtTrabajadorFamiliar->setEliminado(0);
			$dtTrabajadorFamiliar->getIdTrabajadorFamiliar($dtTrabajadorFamiliar->getIdTrabajadorFamiliar());
			$dtGuardar = $dtTrabajadorFamiliar;
			unset($model);
			$dataRelacion = $this->fncListarRegistros($dtTrabajadorFamiliar->getIdTrabajadorFamiliar());
			$dtGuardar = array_shift($dataRelacion);
		}

		return $dtGuardar;
	}

	public function fncGuardarFamiliarTrabajadorFamiliar($arrayInputs)
	{
 
		$dtReturn = array();
		$dtReturnTmp = array();
		$dtRetorno = array();
		$accion = "";
		$idTrabajadorFamiliar = (int) fncObtenerValorArray($arrayInputs, 'idTrabajadorFamiliar', true);
		$idTrabajador = (int) fncObtenerValorArray($arrayInputs, 'idTrabajador', true);
		$idTipoFamiliar = (int) fncObtenerValorArray($arrayInputs, 'idTipoFamiliar', true);
		$idFamiliar = (int) fncObtenerValorArray($arrayInputs, 'idFamiliar', true);

		$clsFamiliar	 	= new FamiliarController();
		$validarFamiliar = array_shift($this->fncValidarRegistrosDni($idFamiliar,fncObtenerValorArray($arrayInputs, 'dni', true)));
		if (count($validarFamiliar)==0) {
			$dtFamiliar = $clsFamiliar->fncGuardar($arrayInputs);
			//$dtFamiliar = $clsFamiliar->fncGuardar($arrayInputs);
			$dtRetorno[1] = '';
			if (fncGeneralValidarDataArray($dtFamiliar[0])) {
				$dtReturnTmp['familiar_tmp'] =array_shift( $dtFamiliar[0]);
				//$dtFamiliarAux = $dtReturn['Familiar'];
				//$idFamiliar = (int) fncObtenerValorArray($dtReturnTmp['familiar_tmp'], 'idFamiliar', true);
				$idFamiliar = (int)$dtReturnTmp['familiar_tmp'];
				$inputs = array(

					"idTrabajadorFamiliar" => "0",
					"idTrabajador" => $idTrabajador,
					"idTipoFamiliar" => $idTipoFamiliar,
					"idFamiliar" => $idFamiliar

				);
				$dtTrabajadorFamiliar = $this->fncGuardar($inputs);
				$idTrabajadorFamiliar =(int) fncObtenerValorArray($dtTrabajadorFamiliar, 'idTrabajadorFamiliar', true);
				if (fncGeneralValidarDataArray($dtTrabajadorFamiliar)) {
					$dataRelacion = $this->fncListarRegistros($idTrabajadorFamiliar);
					$dtReturn = array_shift($dataRelacion);
				}
				
				//$dtReturn = ($dataRelacion);
			}
		}else{
			
				$inputs = array(

					"idTrabajadorFamiliar" => "0",
					"idTrabajador" => $idTrabajador,
					"idTipoFamiliar" => $idTipoFamiliar,
					"idFamiliar" =>$validarFamiliar->idFamiliar

				);
				$trabajadorFamiliar = ($this->fncValidarRelacionFamiliar(0, $idTrabajador, $validarFamiliar->idFamiliar));
				if (count($trabajadorFamiliar)>0) {
					$auxTrabajadorFamiliar = array_shift($trabajadorFamiliar);
					$dtRetorno[1]='El parentesco ya existe';
					$dataRelacion = $this->fncListarRegistros($auxTrabajadorFamiliar->idTrabajadorFamiliar);
						$dtReturn = array();
				}else{
					$dtTrabajadorFamiliar = $this->fncGuardar($inputs);
					$idTrabajadorFamiliar =(int) fncObtenerValorArray($dtTrabajadorFamiliar, 'idTrabajadorFamiliar', true);
					if (fncGeneralValidarDataArray($dtTrabajadorFamiliar)) {
						
						$dataRelacion = $this->fncListarRegistros($idTrabajadorFamiliar);
						$dtReturn = array_shift($dataRelacion);
				}
				}
				
			
		}
		$dtRetorno[0] = $dtReturn;
		//$dtRetorno[1] = $dtFamiliar[1];

		return $dtRetorno;
	}



	public function fncEliminarRegistro($id = 0)
	{

		$bolReturn = array();
		if ($id > 0) {
			$bolValidarEliminar = $this->fncEliminarBD($id);
			if ($bolValidarEliminar) {
				/*//_Elminamos la foto
				$dtPersonaNatural = new PersonaNatural;
				$dtPersonaNatural = $this->fncListarRegistrosBD($id);
				//$dtPersonaNatural = $this->fncSetear($dtPersonaNatural);
				$optFoto = $dtPersonaNatural->getFoto();
				$optRutaFoto = cls_rutas::get('personaImg'); //$optRutaFoto = '../../img/Admin/persona/';
				if(!empty($optFoto) && file_exists($optRutaFoto.$optFoto)){ unlink($optRutaFoto.$optFoto); }
			//_Eliminamos el registro
				$bolReturn = $this->fncEliminarBD( $id );  */

				$trabajadorFamiliar  = new TrabajadorFamiliar();

				$bolReturn = $this->fncListarRegistrosAuditoria($id);
				$returnTrabajadorFamiliar['trabajador_familiar'] = array_shift($bolReturn);
				$auditorioController = new AuditoriaController();
				$auditoria = $auditorioController->fncGuardar(2, 'trabajador_familiar', 'id_trabajador_familiar', $id, json_encode($bolReturn));
			}
		}
		return $returnTrabajadorFamiliar;
	}




	//=======================================================================================
	//FUNCIONES BASE DE DATOS
	//=======================================================================================

	private function fncListarRegistrosBD($id = -1)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			tf.id_trabajador_familiar,
			tf.id_trabajador,
			tf.id_tipo_familiar,
			tf.id_familiar
		FROM
			escalafon.trabajador_familiar AS tf
		WHERE 
			(:id_trabajador_familiar = -1 OR id_trabajador_familiar = :id_trabajador_familiar)
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_trabajador_familiar', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new TrabajadorFamiliar;
				$temp->idTrabajadorFamiliar 	= $datos['id_trabajador_familiar'];
				$temp->idTrabajador 		= $datos['id_trabajador'];
				$temp->idTipoFamiliar 	= $datos['id_tipo_familiar'];
				$temp->idFamiliar	= $datos['id_familiar'];
				//$temp->eliminad	= $datos['orden'];

				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}


	private function fncValidarRegistrosDni($id_familiar,$dni)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			f.id_familiar,
			f.sexo,
			f.dni,
			f.primer_nombre,
			f.segundo_nombre,
			f.apellido_paterno,
			f.apellido_materno,
			f.fecha_nacimiento,
			f.ubigeo_nacimiento,
			f.pais_nacimiento,
			f.nro_certificado_medico,
			f.grado_instruccion,
			f.domicilio,
			f.ubigeo_residencia,
		
			f.pais,
			f.telefono,
			f.celular,
			f.fecha_matrimonio,
			f.nro_partida,
			f.situacion
		FROM
			escalafon.familiar AS f
		WHERE rtrim(f.dni)= :dni AND f.id_familiar NOT IN (:id_familiar)
		';

		$statement = $sql->preparar( $query );
		$arrayReturn = array();

		if( $statement!=false ){
			$statement->bindParam('id_familiar', $id_familiar);
			$statement->bindParam('dni', $dni);

			$sql->ejecutar();

			while( $datos = $statement->fetch(PDO::FETCH_ASSOC) ){
			$temp = new TrabajadorFamiliar;
			$temp->idFamiliar 	        = $datos['id_familiar'];
			$temp->dni 		= $datos['dni'];
			
	


			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}

	private function fncListarDatosTrabajadorBD($id = -1)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			p.documento_identidad,
			CONCAT(pn.nombres ,\' \',pn.apellidos)AS nombre
		FROM
			escalafon.trabajador AS t
			INNER JOIN "public".persona_natural AS pn ON pn.id_persona = t.id_trabajador
			INNER JOIN "public".persona AS p ON p.id_persona = pn.id_persona
		WHERE 
			(t.id_trabajador = :id_trabajador)
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_trabajador', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new TrabajadorFamiliar;
			
				$temp->documentoIdentidad 		= $datos['documento_identidad'];
				$temp->nombre 	= $datos['nombre'];
		

				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}


	private function fncListarRegistrosAuditoria($id = 0)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			tf.id_trabajador_familiar,
			tf.id_trabajador,
			tf.id_tipo_familiar,
			tf.id_familiar,
			tf.eliminado
		FROM
			escalafon.trabajador_familiar AS tf
		WHERE 
			(:id_trabajador_familiar = -1 OR id_trabajador_familiar = :id_trabajador_familiar)
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_trabajador_familiar', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new TrabajadorFamiliar;
				$temp->idTrabajadorFamiliar 	= $datos['id_trabajador_familiar'];
				$temp->idTrabajador 		= $datos['id_trabajador'];
				$temp->idTipoFamiliar 	= $datos['id_tipo_familiar'];
				$temp->idFamiliar	= $datos['id_familiar'];
				$temp->eliminado	= $datos['eliminado'];
				//$temp->eliminad	= $datos['orden'];





				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}



	private function fncListarPorIdTrabajadorBD($id = 0)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			tf.id_trabajador_familiar,
			tf.id_trabajador,
			tf.id_tipo_familiar,
			tf.id_familiar
		FROM
			escalafon.trabajador_familiar AS tf
		WHERE 
			(:id_trabajador = -1 OR id_trabajador = :id_trabajador) AND
			eliminado = 0
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_trabajador', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new TrabajadorFamiliar;
				$temp->idTrabajadorFamiliar 	= $datos['id_trabajador_familiar'];
				$temp->idTrabajador 		= $datos['id_trabajador'];
				$temp->idTipoFamiliar 	= $datos['id_tipo_familiar'];
				$temp->idFamiliar	= $datos['id_familiar'];
				//$temp->eliminad	= $datos['orden'];





				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}



	private function fncListarTrabajadoresFamiliarBD($dni)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			tf.id_trabajador_familiar,
			f.primer_nombre || \' \' || f.apellido_paterno AS nombre_familiar,		
			f.dni AS documento_identidad_familiar,
			tf.id_familiar,
			tf.id_tipo_familiar,
			tf2.tipo_familiar,
			tf.id_trabajador,
			pn.nombre_completo AS nombre_completo_trabajador,
			p.documento_identidad AS documento_identidad_trabajador,
			tf.eliminado
		FROM
			escalafon.trabajador_familiar AS tf
			INNER JOIN escalafon.trabajador AS t ON t.id_trabajador = tf.id_trabajador
			INNER JOIN escalafon.familiar AS f ON f.id_familiar = tf.id_familiar
			INNER JOIN escalafon.tipo_familiar AS tf2 ON tf2.id_tipo_familiar = tf.id_tipo_familiar
			INNER JOIN PUBLIC.persona_natural AS pn ON pn.id_persona = t.id_trabajador
			INNER JOIN PUBLIC.persona AS p ON p.id_persona = t.id_trabajador
			
		WHERE 

			(tf.eliminado=0) AND (f.dni = :dni)
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('dni', strval($dni));

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new TrabajadorFamiliar;
				$temp->idTrabajadorFamiliar 	= $datos['id_trabajador_familiar'];
				$temp->nombreFamiliar 			= $datos['nombre_familiar'];
				$temp->dniFamiliar 				= $datos['documento_identidad_familiar'];
				$temp->idFamiliar				= $datos['id_familiar'];
				$temp->idTipoFamiliar 			= $datos['id_tipo_familiar'];
				$temp->tipoFamiliar 			= $datos['tipo_familiar'];
				$temp->idTrabajador 			= $datos['id_trabajador'];
				$temp->nombreCompletoTrabajador = $datos['nombre_completo_trabajador'];
				$temp->dniTrabajador 			= $datos['documento_identidad_trabajador'];
				$temp->eliminado 				= $datos['eliminado'];
				
			
				//$temp->eliminad	= $datos['orden'];





				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}

	private function fncValidarRelacionFamiliar($idTrabajadorFamiliar = 0, $idTrabajador = 0, $idFamiliar = 0)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			tf.id_trabajador_familiar,
			tf.id_trabajador,
			tf.id_tipo_familiar,
			tf.id_familiar,
			tf.eliminado
		FROM
			escalafon.trabajador_familiar AS tf
		WHERE  
			tf.id_trabajador_familiar NOT IN (:id_trabajador_familiar) AND
			(tf.id_trabajador = :id_trabajador AND		
			tf.id_familiar	= :id_familiar) AND 
			tf.eliminado = 0
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_trabajador_familiar', $idTrabajadorFamiliar);
			$statement->bindParam('id_trabajador', $idTrabajador);
			$statement->bindParam('id_familiar', $idFamiliar);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new Nivel;
				$temp->idTrabajadorFamiliar 	= $datos['id_trabajador_familiar'];
				$temp->idTrabajador 			= $datos['id_trabajador'];
				$temp->idTipoFamiliar 		= $datos['id_tipo_familiar'];
				$temp->idFamiliar 				= $datos['id_familiar'];

				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}


	private function fncValidarParentescoBD($idTrabajadorFamiliar = 0, $idTrabajador = 0, $idFamiliar = 0)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
		\'parentesco\' AS campo,			
		count(tf.id_trabajador_familiar)AS existe
			
		FROM
					escalafon.trabajador_familiar AS tf
		WHERE  
			tf.id_trabajador_familiar NOT IN (:id_trabajador_familiar) AND
			(tf.id_trabajador = :id_trabajador AND		
			tf.id_familiar	= :id_familiar) AND 
			tf.eliminado = 0
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_trabajador_familiar', $idTrabajadorFamiliar);
			$statement->bindParam('id_trabajador', $idTrabajador);
			$statement->bindParam('id_familiar', $idFamiliar);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new Nivel;
				$temp->campo 	= $datos['campo'];
				$temp->existe 	= $datos['existe'];
				

				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}



	private function fncRegistrarBD($dtTrabajadorFamiliar)
	{

		$idTrabajador	= $dtTrabajadorFamiliar->getIdTrabajador();
		$idTipoFamiliar	= $dtTrabajadorFamiliar->getIdTipoFamiliar();
		$idFamiliar	= $dtTrabajadorFamiliar->getIdFamiliar();


		$sql = cls_control::get_instancia();
		$query = '
		INSERT INTO escalafon.trabajador_familiar
		(
			-- id_trabajador_familiar -- this column value is auto-generated
			id_trabajador,
			id_tipo_familiar,
			id_familiar
		)
		VALUES
		(
			:id_trabajador,
			:id_tipo_familiar,
			:id_familiar
		) RETURNING id_trabajador_familiar
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_trabajador', $idTrabajador);
			$statement->bindParam('id_tipo_familiar', $idTipoFamiliar);
			$statement->bindParam('id_familiar', $idFamiliar);


			$sql->ejecutar();
			$datos = $statement->fetch(PDO::FETCH_ASSOC);
			if ($datos) {
				//_Retorno de Datos
				$dtTrabajadorFamiliar->setIdTrabajadorFamiliar($datos["id_trabajador_familiar"]);

				//_Cerrar
				$sql->cerrar();
				return $dtTrabajadorFamiliar;
			} else {
				$sql->cerrar();
				return false;
			}
		} else {
			return false;
		}
	}


	private function fncActualizarBD($dtTrabajadorFamiliar)
	{
		$idTrabajadorFamiliar	= $dtTrabajadorFamiliar->getIdTrabajadorFamiliar();
		$idTrabajador	= $dtTrabajadorFamiliar->getIdTrabajador();
		$idTipoFamiliar	= $dtTrabajadorFamiliar->getIdTipoFamiliar();
		$idFamiliar	= $dtTrabajadorFamiliar->getIdFamiliar();


		$sql = cls_control::get_instancia();
		$query = '
		UPDATE escalafon.trabajador_familiar
		SET
			
			id_trabajador 		= :id_trabajador,
			id_tipo_familiar 	= :id_tipo_familiar,
			id_familiar 		= :id_familiar
		WHERE id_trabajador_familiar = :id_trabajador_familiar AND eliminado = 0
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_trabajador_familiar', $idTrabajadorFamiliar);
			$statement->bindParam('id_trabajador', $idTrabajador);
			$statement->bindParam('id_tipo_familiar', $idTipoFamiliar);
			$statement->bindParam('id_familiar', $idFamiliar);


			$sql->ejecutar();
			$rs = $statement->fetchAll(PDO::FETCH_OBJ);
			if ($rs) {
				$sql->cerrar();
				return $dtTrabajadorFamiliar;
			} else {
				$sql->cerrar();
				return false;
			}
		}
		return $arrayReturn;
	}

	private function fncEliminarBD($id)
	{
		$bolReturn = false;
		$sql = cls_control::get_instancia();
		$consulta = '
		UPDATE escalafon.trabajador_familiar
		SET
			eliminado = 1
		WHERE id_trabajador_familiar = :id_trabajador_familiar';
		$statement = $sql->preparar($consulta);
		if ($statement != false) {
			$statement->bindParam('id_trabajador_familiar', $id);
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

?>