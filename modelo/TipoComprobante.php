<?php
require_once("conexion.php");

class TipoComprobante{
    function listarTipoComprobantes(){
        $sql = "SELECT * FROM tipocomprobante";
        global $cnx;
        $resultado = $cnx->query($sql);
        return $resultado;
    }

    function obtenerComprobanteCompra(){
        $sql = "SELECT * FROM tipocomprobante WHERE idtipocomprobante=05";
        global $cnx;
        $resultado = $cnx->query($sql);
        return $resultado;
    }
}
?>