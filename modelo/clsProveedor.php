<?php 
require_once('conexion.php');
class clsProveedor
{
	function insertar($nombres,$apellidos,$dni,$ruc,$razon_social,$tipopersona,$direccion,$telefono)
	{
		$sql = "INSERT INTO persona(id,nombres,apellidos,dni,ruc,razon_social,tipopersona,direccion,telefono,tipocliente,tipoproveedor,estado) VALUES(null,:nombres,:apellidos,:dni,:ruc,:razon_social,:tipopersona,:direccion,:telefono,'N','S',1)";
		global $cnx;
		$parametros = array(":nombres"=>$nombres,":apellidos"=>$apellidos,":dni"=>$dni,":ruc"=>$ruc,":razon_social"=>$razon_social,":tipopersona"=>$tipopersona,":direccion"=>$direccion,":telefono"=>$telefono);
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
	}

	function actualizar($id,$nombres,$apellidos,$dni,$ruc,$razon_social,$tipopersona,$direccion,$telefono)
	{
		$sql = "UPDATE persona SET nombres=:nombres, apellidos=:apellidos, dni=:dni, ruc=:ruc, razon_social=:razon_social, tipopersona=:tipopersona, direccion=:direccion, telefono=:telefono WHERE id=:id";
		global $cnx;
		$parametros = array(":nombres"=>$nombres,":apellidos"=>$apellidos,":dni"=>$dni,":ruc"=>$ruc,":razon_social"=>$razon_social,":tipopersona"=>$tipopersona,":direccion"=>$direccion,":telefono"=>$telefono,":id"=>$id);
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
	}

	function cambiarEstado($id,$estado)
	{
		$sql = "UPDATE persona SET estado=:estado WHERE id=:id";
		global $cnx;
		$parametros = array(":id"=>$id,":estado"=>$estado);
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
	}

	function consultar($nombre)
	{
		$sql = "SELECT id,nombres,apellidos,dni,ruc,razon_social,tipopersona,direccion,telefono,estado 
				FROM persona WHERE estado <> 2 AND tipoproveedor = 'S' ";
		$parametros = array();
		if($nombre!=''){
			$sql.=" AND CONCAT_WS(' ',nombres, apellidos, razon_social) LIKE :nombre ";
			$parametros[':nombre'] = $nombre;
		}
		
		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		//echo var_dump($datos);
		return $pre;
	}

	function consultarById($id)
	{
		$sql = "SELECT id,nombres,apellidos,dni,ruc,razon_social,tipopersona,direccion,telefono,estado FROM persona WHERE id = :id";
		global $cnx;
		$parametros = array(":id"=>$id);
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		//echo var_dump($datos);
		return $pre;
	}
}
?>