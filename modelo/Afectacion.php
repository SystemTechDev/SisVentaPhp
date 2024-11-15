<?php
require_once("conexion.php");

class Afectacion{
    function listarAfectacion(){
        $sql = "SELECT * FROM afectacion";
        global $cnx;
        $resultado = $cnx->query($sql);
        return $resultado;
    }
}
?>