<?php 
require_once("../modelo/clsProveedor.php");
$accion = '';
if (isset($_POST['accion'])) {
	$accion = $_POST['accion'];
}
$objproveedor = new clsProveedor();

switch ($accion) {
	case 'REGISTRAR':
		try{
			$nombres = $_POST['nombres'];
			$apellidos = $_POST['apellidos'];
			$dni = $_POST['dni'];
			$ruc = $_POST['ruc'];
			$razon_social = $_POST['razon_social'];
			$tipopersona = $_POST['tipopersona'];
			$direccion = $_POST['direccion'];
			$telefono = $_POST['telefono'];
			$objproveedor->insertar(strtoupper($nombres),strtoupper($apellidos),$dni,$ruc,strtoupper($razon_social),$tipopersona,$direccion,$telefono);
			echo "OK";
		}catch(Exception $e){
			echo 'No se pudieron Registar los datos'.$e;
		}
		break;
	case 'ACTUALIZAR':
		try{
			$id = $_POST['id'];
			$nombres = $_POST['nombres'];
			$apellidos = $_POST['apellidos'];
			$dni = $_POST['dni'];
			$ruc = $_POST['ruc'];
			$razon_social = $_POST['razon_social'];
			$tipopersona = $_POST['tipopersona'];
			$direccion = $_POST['direccion'];
			$telefono = $_POST['telefono'];
			$objproveedor->actualizar($id,strtoupper($nombres),strtoupper($apellidos),$dni,$ruc,strtoupper($razon_social),$tipopersona,$direccion,$telefono);
			echo "OK";
		}catch(Exception $e){
			echo 'No se pudieron Actualizar los datos'.$e;
		}
		break;
	case 'CAMBIAR_ESTADO_CATEGORIA':
		try{
			$id = $_POST['id'];
			$estado = $_POST['estado'];
			$objproveedor->cambiarEstado($id,$estado);
			echo "OK";
		}catch(Exception $e){
			echo 'No se pudo Cambiar el Estado del Registro'.$e;
		}
		break;
	case 'CONSULTAR_PERSONA_ID':
		try{
			$id = $_POST['id'];
			$data = $objproveedor->consultarById($id);
			$dato = $data->fetch(PDO::FETCH_NAMED);
			$datos = array("nombres"=>$dato['nombres'],"apellidos"=>$dato['apellidos'],"dni"=>$dato['dni'],"ruc"=>$dato['ruc'],"razon_social"=>$dato['razon_social'],"tipopersona"=>$dato['tipopersona'],"direccion"=>$dato['direccion'],"telefono"=>$dato['telefono'], "estado" => $dato['estado'], "id" => $dato['id']);
			echo json_encode($datos);
		}catch(Exception $e){
			echo 'No se pudo Eliminar el Registro'.$e;
		}
		break;
	
	default:
		echo '*** NO SE ESPECIFICO ACCION';
		break;
}
?>