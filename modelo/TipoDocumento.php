<?php
require_once("conexion.php");

class TipoDocumento{
    function listarDocumentos(){
        $sql = "SELECT * FROM tipodocumento";
        global $cnx;
        $resultado = $cnx->query($sql);
        return $resultado;
    }
}
?>