<?php
require_once '../../App/Escalafon/Models/Documento.php';
require_once '../../App/Config/control.php';
require_once '../../App/Public/archivo.php';
require_once '../../App/Public/rutas.php';
require_once '../../App/Escalafon/Models/AuditoriaArchivo.php';


class DocumentoController extends Documento
{
	//=======================================================================================
	//FUNCIONES LOGICA
	//=======================================================================================

	public function fncListarRegistros($id = -1)
	{

		$dtReturn = array();
		$dtListado = $this->fncListarRegistrosBD($id);
		$clsAuditoriaController = new AuditoriaController();
		$usuario = '';
		if (fncGeneralValidarDataArray($dtListado)) {
			foreach ($dtListado as $listado) {
				$dtAuditoria 	= $clsAuditoriaController->fncBuscarCampoAuditoria('documento', 'id_documento', $listado->idDocumento);
				if (fncGeneralValidarDataArray($dtAuditoria)) {
					$Auditoria = array_shift($dtAuditoria);
					//	$fecha_hora = fncObtenerValorArray($Auditoria, 'fecha_hora', true);
					//	$idUsuario = (Int) fncObtenerValorArray($Auditoria, 'id_usuario', true);
					$usuario = fncObtenerValorArray($Auditoria, 'usuario', true);
				}
				$model = array();

				$model['idDocumento'] 		= $listado->idDocumento;
				$model['ruta'] 				= $listado->ruta;
				$model['fecha_creacion']	= $listado->fechaCreacion;
				$model['usuario'] 			= $usuario;

				array_push($dtReturn, $model);
			}
		}
		return $dtReturn;
	}

	public function fncGuardarDocumentoArray($arrayInputs, $archivo = "")
	{

		$dtReturn = array();
		$accion = 1;

		$idDesplazamiento = (int) fncObtenerValorArray($arrayInputs, 'id_desplazamiento', true);
		$documento  = new Documento();
		$optArchivo = "";

		$archivoInput = fncReordenarArrayMultiplesArchivosDocumento($archivo);
		$archivoInputs = fncReordenarArrayMultiplesArchivosDocumento($archivo);

		if (!empty($archivoInput)) {

			$auditorioController = new AuditoriaController();
			foreach ($archivoInputs as $file) {
				if ($file["name"] <> "") {
					$optRutaArchivo = cls_rutas::get('desplazamientoPdf');

					$nombreArchivo = fncConstruirNombreDocumento($file);
					$obj_arc = new archivo($file, $optRutaArchivo, "pdf_" . $nombreArchivo, 0);
					if ($obj_arc->subir()) {
						$optArchivo = $obj_arc->get_nombre_archivo();
						$documento->setRuta($optRutaArchivo.$obj_arc->get_nombre_archivo());
						$dtGuardar = $this->fncGuardarDocumentoBD($documento);
						$documento->setIdDocumento($dtGuardar->getIdDocumento());


						$auditoria = $auditorioController->fncGuardar($accion, 'documento', 'id_documento', $documento->getIdDocumento(), json_encode($documento));
						$objArrayDocumento = array(
							"Nombre" => $optRutaArchivo.$obj_arc->get_nombre_archivo(),
							"NombreOriginal" => $file["name"],
							"Ruta" => $optRutaArchivo.$obj_arc->get_nombre_archivo(),
							"Tamanio" => $file["size"],
							"IdDocumento" => $documento->getIdDocumento(),
							"FechaCreacion" =>	$documento->getFechaCreacion()

						);


						array_push($dtReturn, $objArrayDocumento);
					}
				}
			}
		}

		//$bolReturn = $this->fncCambiarTareaCumplidaBD( $dtTareaNueva, $inputIdTarea, $optArchivo );
		return $dtReturn;
	}


	public function fncGuardarDocumento($arrayInputs, $archivo = "")
	{

		$dtReturn = array();
		$accion = 1;

		$idDesplazamiento = (int) fncObtenerValorArray($arrayInputs, 'id_desplazamiento', true);
		$documento  = new Documento();
		$optArchivo = "";

	
		if (!empty($arrayInputs)) {

			$auditorioController = new AuditoriaController();
			$file = $archivo;
				if ($file["name"] <> "") {
					$optRutaArchivo = cls_rutas::get('desplazamientoPdf');

					$nombreArchivo = fncConstruirNombreDocumento($file);
					$obj_arc = new archivo($file, $optRutaArchivo, "pdf_" . $nombreArchivo, 0);
					if ($obj_arc->subir()) {
						$optArchivo = $obj_arc->get_nombre_archivo();
						$documento->setRuta($optRutaArchivo.$obj_arc->get_nombre_archivo());
						$dtGuardar = $this->fncGuardarDocumentoBD($documento);
						$documento->setIdDocumento($dtGuardar->getIdDocumento());


						$auditoria = $auditorioController->fncGuardar($accion, 'documento', 'id_documento', $documento->getIdDocumento(), json_encode($documento));
						$objArrayDocumento = array(
							"Nombre" => $optRutaArchivo.$obj_arc->get_nombre_archivo(),
							"NombreOriginal" => $file["name"],
							"Ruta" => $optRutaArchivo . $obj_arc->get_nombre_archivo(),
							"Tamanio" => $file["size"],
							"IdDocumento" => $documento->getIdDocumento(),
							"FechaCreacion" =>	$documento->getFechaCreacion()

						);


						array_push($dtReturn, $objArrayDocumento);
					}
				}
			
		}

		//$bolReturn = $this->fncCambiarTareaCumplidaBD( $dtTareaNueva, $inputIdTarea, $optArchivo );
		return $dtReturn;
	}
	//=======================================================================================
	//FUNCIONES BASE DE DATOS
	//=======================================================================================

	private function fncListarRegistrosBD($id = -1)
	{
		$sql = cls_control::get_instancia();
		$query = '
		SELECT
			d.id_documento,
			d.ruta,
			d.fecha_creacion
		FROM
			escalafon.documento AS d
		WHERE (:id_documento = -1 OR id_documento = :id_documento)
		';

		$statement = $sql->preparar($query);
		$arrayReturn = array();

		if ($statement != false) {
			$statement->bindParam('id_documento', $id);

			$sql->ejecutar();

			while ($datos = $statement->fetch(PDO::FETCH_ASSOC)) {
				$temp = new Documento;
				$temp->idDocumento 		= $datos['id_documento'];
				$temp->ruta 			= $datos['ruta'];
				$temp->fechaCreacion 	= $datos['fecha_creacion'];



				array_push($arrayReturn, $temp);
			}
		}
		return $arrayReturn;
	}



	private function fncGuardarDocumentoBD($dtDocumento)
	{
		$sql = cls_control::get_instancia();
		$ruta 	= $dtDocumento->getRuta();
		$consulta = "
	
		INSERT INTO escalafon.documento
		(
			-- id_documento -- this column value is auto-generated
			ruta,
			fecha_creacion
		)
		VALUES
		(
			 :ruta ,
			 now()
		)
		RETURNING id_documento,fecha_creacion
		";

		$statement = $sql->preparar($consulta);
		//var_dump($consulta);
		if ($statement != false) {
			$statement->bindParam('ruta', $ruta);

			$sql->ejecutar();
			$datos = $statement->fetch(PDO::FETCH_ASSOC);

			if ($datos) {
				$dtDocumento->setIdDocumento($datos["id_documento"]);
				$dtDocumento->setFechaCreacion($datos["fecha_creacion"]);
				$sql->cerrar();
				return $dtDocumento;
			} else {
				$sql->cerrar();
				return false;
			}
		}
	}


}
///////////////////////////////////////////////////////////////////////////////Funciones Custom


function fncConstruirNombreDocumento($archivo)
{
	$nombre = fncQuitarExtensionDocumento($archivo['name']) . '_' . uniqid() . '_';
	return $nombre;
}
function fncReordenarArrayMultiplesArchivosDocumento($archivo)
{
	$archivo_array = array();
	$file_countar = count($archivo['name']);
	$file_key = array_keys($archivo);

	for ($i = 0; $i < $file_countar; $i++) {
		foreach ($file_key as $val) {
			$archivo_array[$i][$val] = $archivo[$val][$i];
		}
	}
	return $archivo_array;
}

function fncQuitarExtensionDocumento($string)
{
	$a = explode('.', $string);
	array_pop($a);
	return implode('.', $a);
}
?>