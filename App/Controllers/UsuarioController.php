<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/gps/App/Models/Usuario.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/gps/App/Business/BusinessUsuario.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/gps/App/Public/funciones.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/gps/App/Controllers/PersonaNaturalController.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/gps/App/Controllers/RolController.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/gps/App/Controllers/ModuloRolController.php');

class UsuarioController extends Usuario
{

	public function fncIndexView()
	{
		$clsModuloRolController = new ModuloRolController();
		$menuModulosPermisos =  $clsModuloRolController->fncListarRegistrosPermisosMenu($_SESSION['sesionIdUsuario']);
		$moduloActual = 'USUARIO';
		$menuActivo		= 'MODULO_USUARIO_GESTION';
		include('../../../../resources/views/includes/appHead.php');
		include('../../../../resources/views/content/usuario/index.php');
		include('../../../../resources/views/includes/appFooter.php');
		echo ('<script type="text/javascript" src="../../../../resources/js/usuario/scriptUsuario.js"></script>');
	}
	public function fncIndexViewPanel()
	{
		$idUsuarioSet = $_SESSION['sesionIdUsuario'];
		$clsModuloRolController = new ModuloRolController();
		$menuModulosPermisos =  $clsModuloRolController->fncListarRegistrosPermisosMenu($_SESSION['sesionIdUsuario']);
		$moduloActual = 'INICIO';
		$menuActivo		= '';

		if ($_SESSION['sesionNombreRol'] != "CLIENTE") {
			$menuActivo		= 'PANEL_ADMIN';
			include('../../../../resources/views/includes/appHead.php');
			include('../../../../resources/views/content/panel/index.php');
		} else {
			$menuActivo		= 'PANEL_CLIENTE';
			include('../../../../resources/views/includes/appHead.php');
			include('../../../../resources/views/content/panel/cliente.php');
		}
		include('../../../../resources/views/includes/appFooter.php');
		//echo ('<script type="text/javascript" src="../../../../resources/js/contrato/scriptContrato.js"></script>');
	}
	public function fncListarRegistros($id = -1)
	{
		$dtReturn = array();
		$usuario = new BusinessUsuario();
		$dtListado = $usuario->fncListarRegistrosBD($id);
		$clsPersonaNatural = new PersonaNaturalController();
		$clsRol = new RolController();

		if (fncGeneralValidarDataArray($dtListado)) {
			foreach ($dtListado as $listado) {
				$model = array();
				$model['idUsuario'] = $listado->idUsuario;
				$model['idPersonaNatural'] = $listado->idPersona;
				$model['personaNatural'] = array_shift($clsPersonaNatural->fncListarRegistros($listado->idPersona));
				$model['idRol'] 	= $listado->idRol;
				$model['rol'] 	=  array_shift($clsRol->fncListarRegistros($listado->idRol));
				$model['usuario'] = $listado->usuario;
				$model['contrasena'] = $listado->contrasena;
				$model['estado'] 	= $listado->estado;
				$model['createdAt'] = $listado->createdAt;
				$model['updatedAt'] = $listado->updatedAt;
				array_push($dtReturn, $model);
				unset($model);
			}
		}
		return $dtReturn;
	}

	public function fncListarRegistrosPorIdPersona($id = -1)
	{
		$dtReturn = array();
		$usuario = new BusinessUsuario();
		$dtListado = $usuario->fncListarRegistrosPorIdPersonaBD($id);
		$clsPersonaNatural = new PersonaNaturalController();
		$clsRol = new RolController();

		if (fncGeneralValidarDataArray($dtListado)) {
			foreach ($dtListado as $listado) {
				$model = array();
				$model['idUsuario'] = $listado->idUsuario;
				$model['idPersonaNatural'] = $listado->idPersona;
				$model['personaNatural'] = array_shift($clsPersonaNatural->fncListarRegistros($listado->idPersona));
				$model['idRol'] 	= $listado->idRol;
				$model['rol'] 	=  array_shift($clsRol->fncListarRegistros($listado->idRol));
				$model['usuario'] = $listado->usuario;
				$model['contrasena'] = $listado->contrasena;
				$model['estado'] 	= $listado->estado;
				$model['createdAt'] = $listado->createdAt;
				$model['updatedAt'] = $listado->updatedAt;
				array_push($dtReturn, $model);
				unset($model);
			}
		}
		return $dtReturn;
	}

	public function fncListarRegistrosPorNombreUsuario($nombre)
	{
		$dtReturn = array();
		$usuario = new BusinessUsuario();
		$dtListado = $usuario->fncListarRegistrosPorNombreUsuarioBD($nombre);
		$clsPersonaNatural = new PersonaNaturalController();
		$clsRol = new RolController();

		if (fncGeneralValidarDataArray($dtListado)) {
			foreach ($dtListado as $listado) {
				$model = array();
				$model['idUsuario'] = $listado->idUsuario;
				$model['idPersonaNatural'] = $listado->idPersona;
				$model['personaNatural'] = array_shift($clsPersonaNatural->fncListarRegistros($listado->idPersona));
				$model['idRol'] 	= $listado->idRol;
				$model['rol'] 	=  array_shift($clsRol->fncListarRegistros($listado->idRol));
				$model['usuario'] = $listado->usuario;
				$model['contrasena'] = $listado->contrasena;
				$model['estado'] 	= $listado->estado;
				$model['createdAt'] = $listado->createdAt;
				$model['updatedAt'] = $listado->updatedAt;
				array_push($dtReturn, $model);
				unset($model);
			}
		}
		return $dtReturn;
	}

	public function fncListarRegistrosAll($id = -1)
	{
		$dtReturn = array();
		$usuario = new BusinessUsuario();
		$dtListado = $usuario->fncListarRegistrosAllBD($id);
		$clsPersonaNatural = new PersonaNaturalController();
		$clsRol = new RolController();

		if (fncGeneralValidarDataArray($dtListado)) {
			foreach ($dtListado as $listado) {
				$model = array();
				$model['idUsuario'] = $listado->idUsuario;
				$model['idPersonaNatural'] = $listado->idPersona;
				$model['personaNatural'] = array_shift($clsPersonaNatural->fncListarRegistros($listado->idPersona));
				$model['idRol'] 	= $listado->idRol;
				$model['rol'] 	=  array_shift($clsRol->fncListarRegistros($listado->idRol));
				$model['usuario'] = $listado->usuario;
				//$model['contrasena'] = $listado->contrasena;
				$model['estado'] 	= $listado->estado;
				$model['createdAt'] = $listado->createdAt;
				$model['updatedAt'] = $listado->updatedAt;
				array_push($dtReturn, $model);
				unset($model);
			}
		}
		return $dtReturn;
	}

	public function fncObtenerAuth($input)
	{
		$dtReturn = array();
		$usuario = new BusinessUsuario();
		$dtUsuario = $usuario->fncObtenerAuthBD(strtoupper($input->user));
		if (fncGeneralValidarDataArray($dtUsuario)) {
			if (password_verify(($input->password), $dtUsuario->contrasena)) {
				$usuarioAccesos = $usuario->fncObtenerPermisosModulosBD(strtoupper($input->user));
				if ($usuarioAccesos->estadoUsuario != 1) {
					$dtReturn['auth'] = false;
					$dtReturn['authMensaje'] = 'Acceso inhabilitado autorizado';
				} else {
					$_SESSION['sesion'] = true;
					$_SESSION['sesionIdUsuario'] = $usuarioAccesos->idUsuario;
					$_SESSION['sesionNombres'] 	 = $usuarioAccesos->nombres;
					$_SESSION['sesionApellidos'] = $usuarioAccesos->apellidos;
					$_SESSION['sesionTelefono'] = $usuarioAccesos->telefono;
					$_SESSION['sesionDni'] = $usuarioAccesos->dni;
					$_SESSION['sesionDireccion'] = $usuarioAccesos->direccion;
					$_SESSION['sesionCorreo'] = $usuarioAccesos->correo;
					$_SESSION['sesionEstadoUsuario'] = $usuarioAccesos->estadoUsuario;
					$_SESSION['sesionIdPersona'] = $usuarioAccesos->idPersona;
					$_SESSION['sesionUsuario'] = $usuarioAccesos->usuario;
					$_SESSION['sesionNombreRol'] = $usuarioAccesos->nombreRol;
					$_SESSION['sesionIdModulo'] = $usuarioAccesos->idModulo;
					$permisos = json_decode(($usuarioAccesos->accesoModulos), true);
					$modulos = array();
					foreach ($permisos as $key => $value) {
						$modulos[key($value)] = array_shift($value);
					}
					$_SESSION['sesionModulos'] = $modulos;
					$dtReturn['auth'] = true;
					$dtReturn['authMensaje'] = 'Acceso autorizado';
				}
			} else {
				$dtReturn['auth'] = false;
				$dtReturn['authMensaje'] = 'Usuario o contraseña incorrecto';
			}
		}
		return $dtReturn;
	}


	public function fncGuardar($inputs)
	{

		$usuario = new Usuario();
		$businessUsuario = new BusinessUsuario();

		$usuario->idPersona = isset($inputs->idPersona) ? $inputs->idPersona : null;
		$usuario->idRol = strtoupper(isset($inputs->idRol) ? $inputs->idRol : null);
		$usuario->usuario = strtoupper(isset($inputs->usuario) ? $inputs->usuario : null);
		$usuario->contrasena = (isset($inputs->contrasena) ? password_hash($inputs->contrasena, PASSWORD_DEFAULT) : null);
		$usuario->estado = isset($inputs->estado) ? $inputs->estado : null;

		$businessUsuario = $businessUsuario->fncGuardarBD($usuario);
		if (!($businessUsuario)) {
			return false;
		}
		return $businessUsuario;
	}


	public function fncActualizar($inputs)
	{

		$usuario = new Usuario();
		$businessPersonaNatural = new BusinessUsuario();
		$usuario->idUsuario = isset($inputs->idUsuario) ? $inputs->idUsuario : null;
		$usuario->idRol = strtoupper(isset($inputs->idRol) ? $inputs->idRol : null);
		if ($inputs->contrasena != '' || !empty($inputs->contrasena)) {
			$usuario->contrasena = (isset($inputs->contrasena) ? password_hash($inputs->contrasena, PASSWORD_DEFAULT) : null);
		}
		$usuario->estado = isset($inputs->estado) ? $inputs->estado : null;
		$dtUsuario = $businessPersonaNatural->fncActualizarBD($usuario);
		if (!($dtUsuario)) {
			return false;
		}
		return $dtUsuario;
	}
}
