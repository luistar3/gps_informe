<?php
require_once '../../App/Escalafon/Models/Familiar.php';
require_once '../../App/Config/control.php';
require_once '../../App/Escalafon/Controllers/AuditoriaController.php';

class FamiliarController extends Familiar
{
	//=======================================================================================
	//FUNCIONES LOGICA
	//=======================================================================================

	public function fncListarRegistros($id = -1)
	{

		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosBD($id);

		if( fncGeneralValidarDataArray($dtListado) ){
			$accion=4;
			$listaAuditoria=array();
			foreach( $dtListado as $listado ){

				$model = array();

				$model['idFamiliar']			=$listado->idFamiliar;
				$model['sexo']					=$listado->sexo;
				$model['dni']					=$listado->dni;
				$model['primerNombre']			=$listado->primerNombre;
				$model['segundoNombre']		=$listado->segundoNombre;
				$model['apellidoPaterno']		=$listado->apellidoPaterno;
				$model['apellidoMaterno']		=$listado->apellidoMaterno;
				$model['fechaNacimiento']		=$listado->fechaNacimiento;
				$model['ubigeoNacimiento']		=array_shift( $this->fncListarUbigeoFamiliar($listado->ubigeoNacimiento) ) ;
				$model['paisNacimiento']		=$listado->paisNacimiento;
				$model['nroCertificadoMedico']=$listado->nroCertificadoMedico;
				$model['gradoInstruccion']		=$listado->gradoInstruccion;
				$model['domicilio']				=$listado->domicilio;
				$model['ubiegoResidencia']		=array_shift( $this->fncListarUbigeoFamiliar($listado->ubigeoResidencia) ) ;
				$model['pais']					=$listado->pais;
				$model['telefono']				=$listado->telefono;
				$model['celular']				=$listado->celular;
				$model['fechaMatrimonio']		=$listado->fechaMatrimonio;
				$model['nroPartida']			=$listado->nroPartida;
				$model['situacion']				=$listado->situacion;


				array_push($dtReturn, $model);
				array_push($listaAuditoria, $model['idFamiliar']);
			}

			$auditorioController = new AuditoriaController();	
			$auditoria = $auditorioController->fncGuardar($accion, 'familiar','id_familiar', null, json_encode($listaAuditoria) );
		}
		return reemplazarNullPorVacioFamiliarController($dtReturn);
	}

	public function fncListarUbigeoFamiliar($id)
	{

		$dtReturn = array();
		$dtListado = $this->fncListarUbigeoFamiliarBD($id);
		$dtReturnTrabajador = array();

		if (fncGeneralValidarDataArray($dtListado)) {
			$listadoIdAuditoria = array();
			
			foreach ($dtListado as $listado) {

				$model = array();

				$model['ubigeo'] 	= $listado->ubigeo;
				$model['region'] = $listado->region;
				$model['provincia'] = $listado->provincia;
				$model['distrito'] = $listado->distrito;
				$model['idRegion'] = $listado->idRegion;
				$model['idProvincia'] = $listado->idProvincia;
				$model['idDistrito'] = $listado->idDistrito;


				array_push($dtReturn, $model);
				
				
			}
			
		}
		return $dtReturn;
	}



	public function fncGuardarValidadFamiliar($arrayInputs)
	{

		$dtReturn = array();
		$inputDni 		= fncObtenerValorArray($arrayInputs, "dni", true );
		$inpuIdFamiliar = fncObtenerValorArray($arrayInputs, "idFamiliar", true );
		$inputDni = str_replace(' ','',$inputDni);
		$dtListado = $this->fncGuardarValidadFamiliarBD($inpuIdFamiliar,$inputDni);
		$dtReturnTrabajador = array();

		if (fncGeneralValidarDataArray($dtListado)) {
			$listadoIdAuditoria = array();
			foreach ($dtListado as $listado) {	
				$model = array();									
				$model['campo'] 	= $listado->campo;
				$model['existe'] 	= $listado->existe;
				array_push($dtReturn, $model);
				
			}
			$dtRetorno = $validad = ($dtReturn);
		
		}
		return array_shift($dtReturn);
	}


	public function fncBuscarDni($arrayInputs)//base
	{

		$dtReturn = array();
		$dtListado = $this->fncBuscarRegistroPorDniBD(str_replace(' ','',fncObtenerValorArray($arrayInputs, "dni", true )));
		$returnFamiliar=array();
		if( fncGeneralValidarDataArray($dtListado) ){
			$accion=4;
			$listaAuditoria=array();
			foreach( $dtListado as $listado ){

				$model = array();

				$model['idFamiliar']			=$listado->idFamiliar;
				$model['sexo']					=$listado->sexo;
				$model['dni']					=$listado->dni;
				$model['primerNombre']			=$listado->primerNombre;
				$model['segundoNombre']		=$listado->segundoNombre;
				$model['apellidoPaterno']		=$listado->apellidoPaterno;
				$model['apellidoMaterno']		=$listado->apellidoMaterno;
				$model['fechaNacimiento']		=$listado->fechaNacimiento;
				$model['ubigeoNacimiento']		=array_shift( $this->fncListarUbigeoFamiliar($listado->ubigeoNacimiento) ) ;
				$model['paisNacimiento']		=$listado->paisNacimiento;
				$model['nroCertificadoMedico']=$listado->nroCertificadoMedico;
				$model['gradoInstruccion']		=$listado->gradoInstruccion;
				$model['domicilio']				=$listado->domicilio;
				$model['ubigeoResidencia']		=array_shift( $this->fncListarUbigeoFamiliar($listado->ubigeoResidencia) ) ;
				
				$model['pais']					=$listado->pais;
				$model['telefono']				=$listado->telefono;
				$model['celular']				=$listado->celular;
				$model['fechaMatrimonio']		=$listado->fechaMatrimonio;
				$model['nroPartida']			=$listado->nroPartida;
				$model['situacion']				=$listado->situacion;


				array_push($dtReturn, $model);
				array_push($listaAuditoria, $model['idFamiliar']);
			}
			$returnFamiliar= array_shift($dtReturn);

			$auditorioController = new AuditoriaController();	
			$auditoria = $auditorioController->fncGuardar($accion, 'familiar','id_familiar', null, json_encode($listaAuditoria) );
		}
		return reemplazarNullPorVacioFamiliarController($returnFamiliar);
	}

	public function fncBuscarPorNombresApellidos($arrayInputs)
	{

		$dtReturn = array();

		
		$primer_nombre 		= fncObtenerValorArray($arrayInputs, "primerNombre", true );
		$apellido_paterno 	= fncObtenerValorArray($arrayInputs, "apellidoPaterno", true );
		$apellido_materno 	= fncObtenerValorArray($arrayInputs, "apellidoMaterno", true );
		$dtListado = $this->fncBuscarRegistroPorNombreApellidos(strtolower($primer_nombre),strtolower($apellido_paterno),strtolower($apellido_materno));
		
		if( fncGeneralValidarDataArray($dtListado) ){
			$accion=4;
			$listaAuditoria=array();
			foreach( $dtListado as $listado ){

				$model = array();

				$model['idFamiliar']			=$listado->idFamiliar;
				$model['sexo']					=$listado->sexo;
				$model['dni']					=$listado->dni;
				$model['primerNombre']			=$listado->primerNombre;
				$model['segundoNombre']			=$listado->segundoNombre;
				$model['apellidoPaterno']		=$listado->apellidoPaterno;
				$model['apellido_Materno']		=$listado->apellidoMaterno;
				$model['fechaNacimiento']		=$listado->fechaNacimiento;
				$model['ubigeoNacimiento']		=array_shift( $this->fncListarUbigeoFamiliar($listado->ubigeoNacimiento) ) ;
				$model['paisNacimiento']		=$listado->paisNacimiento;
				$model['nroCertificadoMedico']=$listado->nroCertificadoMedico;
				$model['gradoInstruccion']		=$listado->gradoInstruccion;
				$model['domicilio']				=$listado->domicilio;
				$model['ubigeoResidencia'] 		=array_shift( $this->fncListarUbigeoFamiliar($listado->ubigeoResidencia) ) ;
		
				$model['pais']					=$listado->pais;
				$model['telefono']				=$listado->telefono;
				$model['celular']				=$listado->celular;
				$model['fechaMatrimonio']		=$listado->fechaMatrimonio;
				$model['nroPartida']			=$listado->nroPartida;
				$model['situacion']				=$listado->situacion;


				array_push($dtReturn, $model);
				array_push($listaAuditoria, $model['idFamiliar']);
			}

			$auditorioController = new AuditoriaController();	
			$auditoria = $auditorioController->fncGuardar($accion, 'familiar','id_familiar', null, json_encode($listaAuditoria) );
		}
		return reemplazarNullPorVacioFamiliarController($dtReturn);
	}
	public function fncGuardar($arrayInputs){

		$dtReturn = array();
		$accion ="";
		$dtRetorno = array();
		
		$id_familiar = (Int) fncObtenerValorArray( $arrayInputs, 'idFamiliar', true);
		$sexo = fncObtenerValorArray( $arrayInputs, 'sexo', true);
		$dni = fncObtenerValorArray( $arrayInputs, 'dni', true);
		$primer_nombre = fncObtenerValorArray( $arrayInputs, 'primerNombre', true);
		$segundo_nombre = fncObtenerValorArray( $arrayInputs, 'segundoNombre', true);
		$apellido_paterno = fncObtenerValorArray( $arrayInputs, 'apellidoPaterno', true);
		$apellido_materno= fncObtenerValorArray( $arrayInputs, 'apellidoMaterno', true);
		$fecha_nacimiento= fncObtenerValorArray( $arrayInputs, 'fechaNacimiento', true);
		$ubigeoNacimiento= fncObtenerValorArray( $arrayInputs, 'ubigeoNacimiento', true);
		$pais_nacimiento= fncObtenerValorArray( $arrayInputs, 'paisNacimiento', true);
		$nro_certificado_medico= fncObtenerValorArray( $arrayInputs, 'nroCertificadoMedico', true);
		$grado_instruccion= fncObtenerValorArray( $arrayInputs, 'gradoInstruccion', true);
		$domicilio= fncObtenerValorArray( $arrayInputs, 'domicilio', true);		
		$ubigeoResidencia= fncObtenerValorArray( $arrayInputs, 'ubigeoResidencia', true);	
		$pais= fncObtenerValorArray( $arrayInputs, 'pais', true);
		$telefono= fncObtenerValorArray( $arrayInputs, 'telefono', true);
		$celular= fncObtenerValorArray( $arrayInputs, 'celular', true);
		$fecha_matrimonio= fncObtenerValorArray( $arrayInputs, 'fechaMatrimonio', true);
		$nro_partida= fncObtenerValorArray( $arrayInputs, 'nroPartida', true);
		$situacion= fncObtenerValorArray( $arrayInputs, 'situacion', true);

		
		$dtFamiliar = new Familiar;


		if( !empty($id_familiar) )  { $dtFamiliar->setIdFamiliar($id_familiar); }
		if( !empty($sexo) ) 		{ $dtFamiliar->setSexo($sexo); }
		if( !empty($dni) ) 			{ $dtFamiliar->setDni( str_replace(' ','',$dni)); }
		if( !empty($primer_nombre) ) 	{ $dtFamiliar->setPrimerNombre($primer_nombre); }
		if( !empty($segundo_nombre) ) 	{ $dtFamiliar->setSegundoNombre($segundo_nombre); }
		if( !empty($apellido_paterno) ) { $dtFamiliar->setApellidoPaterno($apellido_paterno); }
		if( !empty($apellido_materno) ) { $dtFamiliar->setApellidoMaterno($apellido_materno); }
		if( !empty($fecha_nacimiento) ) { $dtFamiliar->setFechaNacimiento($fecha_nacimiento); }
		if( !empty($ubigeoNacimiento) ) 		{ $dtFamiliar->setUbigeoNacimiento($ubigeoNacimiento); }
		if( !empty($pais_nacimiento) ) 			{ $dtFamiliar->setPaisNacimiento($pais_nacimiento); }
		if( !empty($nro_certificado_medico) ) 	{ $dtFamiliar->setNroCertificadoMedico($nro_certificado_medico); }
		if( !empty($grado_instruccion) ) 		{ $dtFamiliar->setGradoInstruccion($grado_instruccion); }
		if( !empty($domicilio) ) 	{ $dtFamiliar->setDomicilio($domicilio); }
		if( !empty($ubigeoResidencia) ) 	{ $dtFamiliar->setUbigeoResidencia($ubigeoResidencia); }
		if( !empty($pais) ) 		{ $dtFamiliar->setPais($pais); }
		if( !empty($telefono) ) 	{ $dtFamiliar->setTelefono($telefono); }
		if( !empty($celular) )	 	{ $dtFamiliar->setCelular($celular); }
		if( !empty($fecha_matrimonio) ) { $dtFamiliar->setFechaMatrimonio($fecha_matrimonio); }
		if( !empty($nro_partida) ) 	{ $dtFamiliar->setNroPartida($nro_partida); }
		if( !empty($situacion) ) 	{ $dtFamiliar->setSituacion($situacion); }
	
		
		$mensaje ='';

		if (fncGeneralValidarDataArray($dtFamiliar)) {
			$accion = '';
			$dtGuardar = array();
			if ($id_familiar == 0) {
				if (!empty($dni)) {
					$trabajador = $this->fncValidarRegistrosDni($id_familiar, $dni);

					if (count($trabajador) == 0) {
						$accion = 1;

						$dtGuardar = $this->fncRegistrarBD($dtFamiliar);
					} else {

						//$mensaje = 'Ya existe ese DNI';
						$mensaje = '';
					}
				}
			} else {
				if (!empty($dni)) {
					$trabajador = $this->fncValidarRegistrosDni($id_familiar, $dni);

					if (count($trabajador) == 0) {
						$accion = 2;
						$dtGuardar = $this->fncActualizarBD($dtFamiliar);
					} else {
						//$mensaje = 'Ya existe ese DNI';
						$mensaje = '';
					}
				}
			}
		}


		if (fncGeneralValidarDataArray($dtGuardar)) {


			//$auditorioController = new AuditoriaController();

			//$auditoria = $auditorioController->fncGuardar('familiar',$dtGuardar->getIdFamiliar(),$dtGuardar,$accion);
			$auditorioController = new AuditoriaController();
			$auditoria = $auditorioController->fncGuardar($accion, 'familiar', 'id_familiar', $dtFamiliar->getIdFamiliar(), json_encode($dtGuardar));
			//_Cargamos el modelo que será devuelto
			/*$model = array();
			$model["id_trabajador"]                   = $dtGuardar->getIdTrabajador();
			$model["id_tipo_regimen_pension"]  = $dtGuardar->getIdTipoRegimenPension();
			$model["id_tipo_afp"]                    = $dtGuardar->getIdTipoAfp();
			$model["id_tipo_regimen_laboral"]                         = $dtGuardar->getIdTipoRegimenLaboral();
			$model["id_tipo_trabajador"]          = $dtGuardar->getIdTipoTrabajador();
			$model["id_unidad_ejecutora"]                    = $dtGuardar->getIdUnidadEjecutora();
			$model["id_tipo_condicion"]                     = $dtGuardar->getIdTipoCondicion();
			$model["id_nivel"]           = $dtGuardar->getIdNivel();
			$model["libreta_militar"]               = $dtGuardar->getLibretaMilitar();
			$model["nro_brevete"]           = $dtGuardar->getNroBrevete();
			$model["estado_civil"]           = $dtGuardar->getEstadoCivil();
			$model["casa"]           = $dtGuardar->getCasa();
			$model["telefono_celular"]           = $dtGuardar->getTelefono_celular();
			$model["codigo_unico"]           = $dtGuardar->getCodigoUnico();
			array_push($dtReturn, $model);*/
			$dtFamiliar->getIdFamiliar($dtFamiliar->getIdFamiliar());
			$dtGuardar = $dtFamiliar;
			$dtFamiliarPorDni = $this->fncBuscarDni($dtFamiliar);
			unset($model);
		}

		$dtRetorno[0] = $dtFamiliarPorDni;
		$dtRetorno[1] = $mensaje;
		return $dtRetorno;
	}


	//=======================================================================================
	//FUNCIONES BASE DE DATOS
	//=======================================================================================

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
			$temp = new Familiar;
			$temp->idFamiliar 	        = $datos['id_familiar'];
			$temp->dni 		= $datos['dni'];
			
	


			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}


	



	private function fncGuardarValidadFamiliarBD($id_familiar,$dni)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			\'dni\'AS campo,
			count(f.id_familiar)AS existe
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
			$temp = new Familiar;
			$temp->campo 	        = $datos['campo'];
			$temp->existe 	        = $datos['existe'];
			array_push( $arrayReturn, $temp );
			}
		}
		return $arrayReturn;
	}



	private function fncRegistrarBD($dtFamiliar)
	{

		$sexo	= $dtFamiliar->getSexo();
		$dni	= $dtFamiliar->getDni();
		$primer_nombre	= $dtFamiliar->getPrimerNombre();
		$segundo_nombre	= $dtFamiliar->getSegundoNombre();
		$apellido_paterno	= $dtFamiliar->getApellidoPaterno();
		$apellido_materno	= $dtFamiliar->getApellidoMaterno();
		$fecha_nacimiento	= $dtFamiliar->getFechaNacimiento();
		$ubigeoNacimiento	= $dtFamiliar->getUbigeoNacimiento();
		$domicilio	= $dtFamiliar->getDomicilio();
		$pais_nacimiento	= $dtFamiliar->getPaisNacimiento();
		$nro_certificado_medico	= $dtFamiliar->getNroCertificadoMedico();
		$grado_instruccion	= $dtFamiliar->getGradoInstruccion();
		$ubigeoResidencia	= $dtFamiliar->getUbigeoResidencia();
		
		$pais	= $dtFamiliar->getPais();
		$telefono	= $dtFamiliar->getTelefono();
		$celular	= $dtFamiliar->getCelular();
		$fecha_matrimonio	= $dtFamiliar->getFechaMatrimonio();
		$nro_partida	= $dtFamiliar->getNroPartida();
		$situacion	= $dtFamiliar->getSituacion();



		$sql = cls_control::get_instancia();
		$query = '
		INSERT INTO escalafon.familiar
		(
			-- id_familiar -- this column value is auto-generated
			sexo,
			dni,
			primer_nombre,
			segundo_nombre,
			apellido_paterno,
			apellido_materno,
			fecha_nacimiento,
			ubigeo_nacimiento,
			pais_nacimiento,
			nro_certificado_medico,
			grado_instruccion,
			domicilio,
			ubigeo_residencia,

			pais,
			telefono,
			celular,
			fecha_matrimonio,
			nro_partida,
			situacion
		)
		VALUES
		(
			:sexo,
			:dni,
			:primer_nombre,
			:segundo_nombre,
			:apellido_paterno,
			:apellido_materno,
			:fecha_nacimiento,
			:ubigeo_nacimiento,
			:pais_nacimiento,
			:nro_certificado_medico,
			:grado_instruccion,
			:domicilio,
			:ubigeo_residencia,
	
			:pais,
			:telefono,
			:celular,
			:fecha_matrimonio,
			:nro_partida,
			:situacion
		) RETURNING id_familiar
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('sexo', $sexo);
			$statement->bindParam('dni', $dni);
			$statement->bindParam('primer_nombre', $primer_nombre);
			$statement->bindParam('segundo_nombre', $segundo_nombre);
			$statement->bindParam('apellido_paterno', $apellido_paterno);
			$statement->bindParam('apellido_materno', $apellido_materno);
			$statement->bindParam('fecha_nacimiento', $fecha_nacimiento);
			$statement->bindParam('ubigeo_nacimiento', $ubigeoNacimiento);
			$statement->bindParam('domicilio', $domicilio);
			$statement->bindParam('pais_nacimiento', $pais_nacimiento);
			$statement->bindParam('nro_certificado_medico', $nro_certificado_medico);
			$statement->bindParam('grado_instruccion', $grado_instruccion);
			$statement->bindParam('ubigeo_residencia', $ubigeoResidencia);
	
			
			$statement->bindParam('pais', $pais);
			$statement->bindParam('telefono', $telefono);
			$statement->bindParam('celular', $celular);
			$statement->bindParam('fecha_matrimonio', $fecha_matrimonio);
			$statement->bindParam('nro_partida', $nro_partida);
			$statement->bindParam('situacion', $situacion);

			$sql->ejecutar();
			$datos = $statement->fetch(PDO::FETCH_ASSOC);
			if ($datos) {
				//_Retorno de Datos
				$dtFamiliar->setIdFamiliar($datos["id_familiar"]);

				//_Cerrar
				$sql->cerrar();
				return $dtFamiliar;
			} else {
				$sql->cerrar();
				return false;
			}
		} else {
			return false;
		}
	}
	private function fncActualizarBD($dtFamiliar)
	{
		$id_familiar	= $dtFamiliar->getIdFamiliar();
		$sexo	= $dtFamiliar->getSexo();
		$dni	= $dtFamiliar->getDni();
		$primer_nombre	= $dtFamiliar->getPrimerNombre();
		$segundo_nombre	= $dtFamiliar->getSegundoNombre();
		$apellido_paterno	= $dtFamiliar->getApellidoPaterno();
		$apellido_materno	= $dtFamiliar->getApellidoMaterno();
		$fecha_nacimiento	= $dtFamiliar->getFechaNacimiento();
		$ubigeoNacimiento	= $dtFamiliar->getUbigeoNacimiento();
		$pais_nacimiento	= $dtFamiliar->getPaisNacimiento();
		$nro_certificado_medico	= $dtFamiliar->getNroCertificadoMedico();
		$grado_instruccion	= $dtFamiliar->getGradoInstruccion();
		$domicilio	= $dtFamiliar->getDomicilio();
		$ubigeoResidencia	= $dtFamiliar->getUbigeoResidencia();

		$pais	= $dtFamiliar->getPais();
		$telefono	= $dtFamiliar->getTelefono();
		$celular	= $dtFamiliar->getCelular();
		$fecha_matrimonio	= $dtFamiliar->getFechaMatrimonio();
		$nro_partida	= $dtFamiliar->getNroPartida();
		$situacion	= $dtFamiliar->getSituacion();

		$sql = cls_control::get_instancia();
		$query = 'UPDATE escalafon.familiar
		SET
			-- id_familiar -- this column value is auto-generated
			sexo = :sexo,
			dni = :dni,
			primer_nombre = :primer_nombre,
			segundo_nombre = :segundo_nombre,
			apellido_paterno = :apellido_paterno,
			apellido_materno = :apellido_materno,
			fecha_nacimiento = :fecha_nacimiento,
			ubigeo_nacimiento = :ubigeo_nacimiento,
			pais_nacimiento = :pais_nacimiento,
			nro_certificado_medico = :nro_certificado_medico,
			grado_instruccion = :grado_instruccion,
			domicilio = :domicilio,
			ubigeo_residencia = :ubigeo_residencia,

			pais = :pais,
			telefono = :telefono,
			celular = :celular,
			fecha_matrimonio = :fecha_matrimonio,
			nro_partida = :nro_partida,
			situacion = :situacion 
		WHERE id_familiar = :id_familiar
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_familiar', $id_familiar);
			$statement->bindParam('sexo', $sexo);
			$statement->bindParam('dni', $dni);
			$statement->bindParam('primer_nombre', $primer_nombre);
			$statement->bindParam('segundo_nombre', $segundo_nombre);
			$statement->bindParam('apellido_paterno', $apellido_paterno);
			$statement->bindParam('apellido_materno', $apellido_materno);
			$statement->bindParam('fecha_nacimiento', $fecha_nacimiento);
			$statement->bindParam('ubigeo_nacimiento', $ubigeoNacimiento);
			$statement->bindParam('pais_nacimiento', $pais_nacimiento);
			$statement->bindParam('nro_certificado_medico', $nro_certificado_medico);
			$statement->bindParam('grado_instruccion', $grado_instruccion);
			$statement->bindParam('domicilio', $domicilio);
			$statement->bindParam('ubigeo_residencia', $ubigeoResidencia);
	
			$statement->bindParam('pais', $pais);
			$statement->bindParam('telefono', $telefono);
			$statement->bindParam('celular', $celular);
			$statement->bindParam('fecha_matrimonio', $fecha_matrimonio);
			$statement->bindParam('nro_partida', $nro_partida);
			$statement->bindParam('situacion', $situacion);

			$sql->ejecutar();
			$rs = $statement->fetchAll(PDO::FETCH_OBJ);
			if ($rs) {
				$sql->cerrar();
				return $dtFamiliar;
			} else {
				$sql->cerrar();
				return false;
			}
		}
		return $arrayReturn;
	}
	private function fncListarRegistrosBD($id = -1)
	{
	  $sql = cls_control::get_instancia();
	  $query = "SELECT
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
	  WHERE (:id_familiar = -1 OR f.id_familiar = :id_familiar)";
	  $statement = $sql->preparar($query);
	  $arrayReturn = array();
	  if($statement!=false) {
		$statement->bindParam("id_familiar",$id);
		$sql->ejecutar();
		while($datos = $statement->fetch(PDO::FETCH_ASSOC)){
		  $temp = new Familiar;
 
		  $temp->idFamiliar					=$datos['id_familiar'];				
		  $temp->sexo						=$datos['sexo'];
		  $temp->dni						=$datos['dni'];
		  $temp->primerNombre				=$datos['primer_nombre'];
		  $temp->segundoNombre				=$datos['segundo_nombre'];
		  $temp->apellidoPaterno			=$datos['apellido_paterno'];
		  $temp->apellidoMaterno			=$datos['apellido_materno'];
		  $temp->fechaNacimiento			=$datos['fecha_nacimiento'];
		  $temp->ubigeoNacimiento			=$datos['ubigeo_nacimiento'];
		  $temp->paisNacimiento				=$datos['pais_nacimiento'];
		  $temp->nroCertificadoMedico		=$datos['nro_certificado_medico'];
		  $temp->gradoInstruccion			=$datos['grado_instruccion'];
		  $temp->domicilio					=$datos['domicilio'];
		  $temp->ubigeoResidencia			=$datos['ubigeo_residencia'];	
		  $temp->pais						=$datos['pais'];
		  $temp->telefono					=$datos['telefono'];
		  $temp->celular					=$datos['celular'];
		  $temp->fechaMatrimonio			=$datos['fecha_matrimonio'];
		  $temp->nroPartida					=$datos['nro_partida'];
		  $temp->situacion					=$datos['situacion'];



		  array_push($arrayReturn,$temp);
		  unset($temp);
		}
	  }
	  return $arrayReturn;
	}
	private function fncBuscarRegistroPorDniBD($dni ='0')
	{
	  $sql = cls_control::get_instancia();
	  $query = "SELECT
  	f.id_familiar,
	  f.sexo,
	  f.dni,
	  f.primer_nombre,
	  f.segundo_nombre,
	  f.apellido_paterno,
	  f.apellido_materno,
	  f.fecha_nacimiento,
	  f.pais_nacimiento,
	  f.ubigeo_nacimiento,
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
	  WHERE (f.dni = :dni)";
	  $statement = $sql->preparar($query);
	  $arrayReturn = array();
	  if($statement!=false) {
		$statement->bindParam("dni",$dni);
		$sql->ejecutar();
		while($datos = $statement->fetch(PDO::FETCH_ASSOC)){
		  $temp = new Familiar;
 
		  $temp->idFamiliar					=$datos['id_familiar'];				
		  $temp->sexo						=$datos['sexo'];
		  $temp->dni						=$datos['dni'];
		  $temp->primerNombre				=$datos['primer_nombre'];
		  $temp->segundoNombre				=$datos['segundo_nombre'];
		  $temp->apellidoPaterno			=$datos['apellido_paterno'];
		  $temp->apellidoMaterno			=$datos['apellido_materno'];
		  $temp->fechaNacimiento			=$datos['fecha_nacimiento'];
		  $temp->ubigeoNacimiento			=$datos['ubigeo_nacimiento'];
		  $temp->paisNacimiento				=$datos['pais_nacimiento'];
		  $temp->nroCertificadoMedico		=$datos['nro_certificado_medico'];
		  $temp->gradoInstruccion			=$datos['grado_instruccion'];
		  $temp->domicilio					=$datos['domicilio'];
		  $temp->ubigeoResidencia			=$datos['ubigeo_residencia'];
		
		  $temp->pais						=$datos['pais'];
		  $temp->telefono					=$datos['telefono'];
		  $temp->celular					=$datos['celular'];
		  $temp->fechaMatrimonio			=$datos['fecha_matrimonio'];
		  $temp->nroPartida					=$datos['nro_partida'];
		  $temp->situacion					=$datos['situacion'];



		  array_push($arrayReturn,$temp);
		  unset($temp);
		}
	  }
	  return $arrayReturn;
	}


	private function fncListarUbigeoFamiliarBD($ubigeo)
	{
		$sql = cls_control::get_instancia();
		$query = 'SELECT
					u.ubigeo,
					u.region,
					u.provincia,
					u.distrito,
					u.id_region,
					u.id_provincia,
					u.id_distrito
				FROM
					"public".ubigeo AS u
					WHERE u.ubigeo = :ubigeo';
		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('ubigeo', ($ubigeo) );
			$sql->ejecutar();
			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new Familiar;
				$temp->ubigeo 			= $datos['ubigeo'];
				$temp->region 			= $datos['region'];
				$temp->provincia 		= $datos['provincia'];
				$temp->distrito 		= $datos['distrito'];
				$temp->idRegion 		= $datos['id_region'];
				$temp->idProvincia 		= $datos['id_provincia'];
				$temp->idDistrito 		= $datos['id_distrito'];
							
				array_push($arrayReturn, $temp);
				unset($temp);
			}
		}
		return $arrayReturn;
	}

	private function fncBuscarRegistroPorNombreApellidos($nombre='',$apellido_paterno='',$apellido_materno='')
	{
	  $sql = cls_control::get_instancia();
	  $where = "(LOWER(translate(f.primer_nombre,'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU')) LIKE '%' || :nombre || '%')
	  OR
	  (LOWER(translate(f.apellido_paterno,'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU')) LIKE '%' || :apellido_paterno || '%')
	  AND
	  (LOWER(translate(f.apellido_materno,'áéíóúÁÉÍÓÚäëïöüÄËÏÖÜ','aeiouAEIOUaeiouAEIOU')) LIKE '%' || :apellido_materno || '%')";
	  
	  $query = "SELECT 
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
	  FROM escalafon.familiar AS f
	  WHERE"." ".$where;
	  $statement = $sql->preparar($query);
	  $arrayReturn = array();
	  if($statement!=false) {
		$statement->bindParam("nombre",$nombre);
		$statement->bindParam("apellido_paterno",$apellido_paterno);
		$statement->bindParam("apellido_materno",$apellido_materno);
		$sql->ejecutar();
		while($datos = $statement->fetch(PDO::FETCH_ASSOC)){
		  $temp = new Familiar;
 
		  $temp->idFamiliar				=$datos['id_familiar'];				
		  $temp->sexo						=$datos['sexo'];
		  $temp->dni						=$datos['dni'];
		  $temp->primerNombre				=$datos['primer_nombre'];
		  $temp->segundoNombre				=$datos['segundo_nombre'];
		  $temp->apellidoPaterno			=$datos['apellido_paterno'];
		  $temp->apellidoMaterno			=$datos['apellido_materno'];
		  $temp->fechaNacimiento			=$datos['fecha_nacimiento'];
		  $temp->ubigeoNacimiento			=$datos['ubigeo_nacimiento'];
		  $temp->paisNacimiento				=$datos['pais_nacimiento'];
		  $temp->nroCertificadoMedico		=$datos['nro_certificado_medico'];
		  $temp->gradoInstruccion			=$datos['grado_instruccion'];
		  $temp->domicilio					=$datos['domicilio'];
		  $temp->ubigeoResidencia			=$datos['ubigeo_residencia'];
		 
		  $temp->pais						=$datos['pais'];
		  $temp->telefono					=$datos['telefono'];
		  $temp->celular					=$datos['celular'];
		  $temp->fechaMatrimonio			=$datos['fecha_matrimonio'];
		  $temp->nroPartida					=$datos['nro_partida'];
		  $temp->situacion					=$datos['situacion'];



		  array_push($arrayReturn,$temp);
		  unset($temp);
		}
	  }
	  return $arrayReturn;
	}

} 
///////////////////////////////////////////////////////////////////////////////Funciones Custom
function reemplazarNullPorVacioFamiliarController($array)
{
	foreach ($array as $key => $value) 
	{
		if(is_array($value))
			$array[$key] = reemplazarNullPorVacioFamiliarController($value);
		else
		{
			if (is_null($value))
				$array[$key] = "";
		}
	}
	return $array;
}
?>