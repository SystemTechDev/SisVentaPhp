<?php
require_once("conexion.php");

class Moneda{
    function listarMonedas(){
        $sql = "SELECT * FROM moneda";
        global $cnx;
        $resultado = $cnx->query($sql);
        return $resultado;
    }
}
?>