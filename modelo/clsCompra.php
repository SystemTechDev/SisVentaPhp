<?php 
require_once('conexion.php');
class clsCompra
{
	function insertar($fecha,$serie,$correlativo,$fechaemision,$comprobantecompra,$seriecomprobante,$numerodocumento,$formapagocompra,$persona_id,$subtotal,$igv,$total,$idtipocomprobante)
	{
		$sql = "INSERT INTO movimiento(id,fecha,serie,correlativo,fechaemision,comprobantecompra,seriecomprobante,numerodocumento,formapagocompra,persona_id,subtotal,igv,total,idtipocomprobante,estado) VALUES(null,:fecha,:serie,:correlativo,:fechaemision,:comprobantecompra,:seriecomprobante,:numerodocumento,:formapagocompra,:persona_id,:subtotal,:igv,:total,:idtipocomprobante,'N')";
		global $cnx;
		$parametros = array(":fecha"=>$fecha,
							":serie"=>$serie,
							":correlativo"=>$correlativo,
							":fechaemision"=>$fechaemision,
							":comprobantecompra"=>$comprobantecompra,
							":seriecomprobante"=>$seriecomprobante,
							":numerodocumento"=>$numerodocumento,
							":formapagocompra"=>$formapagocompra,
							":persona_id"=>$persona_id,
							":subtotal"=>$subtotal,
							":igv"=>$igv,
							":total"=>$total,
							":idtipocomprobante"=>$idtipocomprobante);
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
	}

	function insertardetalle($cantidad,$preciounitario,$subtotal,$producto_id,$movimiento_id)
	{
		$sql = "INSERT INTO detallemovimiento(id,cantidad,preciounitario,subtotal,producto_id,movimiento_id,estado) VALUES(null,:cantidad,:preciounitario,:subtotal,:producto_id,:movimiento_id,'N')";
		global $cnx;
		$parametros = array(":cantidad"=>$cantidad,":preciounitario"=>$preciounitario,":subtotal"=>$subtotal,":producto_id"=>$producto_id,":movimiento_id"=>$movimiento_id);
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
	}

	function insertarkardex($fecha,$tipo,$cantidad,$stockanterior,$stockactual,$producto_id,$detallemovimiento_id)
	{
		$sql = "INSERT INTO kardex(id,fecha,tipo,cantidad,stockanterior,stockactual,producto_id,detallemovimiento_id,estado) VALUES(null,:fecha,:tipo,:cantidad,:stockanterior,:stockactual,:producto_id,:detallemovimiento_id,'N')";
		global $cnx;
		$parametros = array(":fecha"=>$fecha,":tipo"=>$tipo,":cantidad"=>$cantidad,":stockanterior"=>$stockanterior,":stockactual"=>$stockactual,":producto_id"=>$producto_id,":detallemovimiento_id"=>$detallemovimiento_id);
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
	}

	function consultar($nombre)
	{
		$sql = "SELECT m.* , p.nombres, p.apellidos, p.razon_social, p.tipopersona 
			FROM movimiento m
			INNER JOIN persona p on m.persona_id = p.id
			WHERE m.idtipocomprobante = 05 AND m.estado <> 'E' ";
		$parametros = array();
		if($nombre!=''){
			$sql.=" AND CONCAT_WS(' ',p.nombres, p.apellidos, p.razon_social) LIKE :nombre ";
			$parametros[':nombre'] = $nombre;
		}

		$sql .= ' ORDER BY m.fecha DESC';
		
		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		//echo var_dump($datos);
		return $pre;
	}

	function consultarProforma($id)
	{
		$sql = "SELECT m.id,m.fecha,m.total, m.serie, m.numerodocumento,dm.cantidad,dm.preciounitario,dm.producto_id,dm.subtotal, m.persona_id, m.estado, p.nombres, p.apellidos, p.razon_social, p.tipopersona 
			FROM movimiento m
            INNER JOIN detallemovimiento dm on dm.id=m.tipomovimiento_id
			INNER JOIN persona p on m.persona_id = p.id
			WHERE m.tipomovimiento_id = 1 AND m.estado <> 'E' and m.id = :id ";
		$parametros = array(":id"=>$id);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		//echo var_dump($datos);
		return $pre;
	}

	function consultarUltimoIdMovimiento()
	{
		$sql = "SELECT id FROM movimiento ORDER BY id DESC LIMIT 1";
		global $cnx;
		$parametros = array();
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		//echo var_dump($datos);
		return $pre;
	}

	function consultarUltimoIdDetallemovimiento()
	{
		$sql = "SELECT id FROM detallemovimiento ORDER BY id DESC LIMIT 1";
		global $cnx;
		$parametros = array();
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		//echo var_dump($datos);
		return $pre;
	}

	 function consultarSeries($idtipocomprobante){
        $sql = "SELECT * FROM serie WHERE idtipocomprobante=? AND estado=1";
        global $cnx;
        $pre= $cnx->prepare($sql);
        $pre->execute(array($idtipocomprobante));
        return $pre;        
    }

	function obtenerCorrelativo($idtipocomprobante, $serie){
        $sql = "SELECT correlativo FROM serie WHERE idtipocomprobante=? AND serie=? AND estado=1";
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute(array($idtipocomprobante,$serie));
        if($pre->rowCount()>0){
            $pre = $pre->fetch(PDO::FETCH_NUM);
            $pre = $pre[0]+1;
        }else{
            $pre = 0;
        }
        return $pre;
    }

    function actualizarCorrelativo($idtipocomprobante, $serie, $correlativo){
        $sql = "UPDATE serie SET correlativo=? WHERE idtipocomprobante=? AND serie=? AND estado=1";
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute(array($correlativo, $idtipocomprobante,$serie));
        return $pre;
    }

}
?>