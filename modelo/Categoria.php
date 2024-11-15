<?php
include_once("conexion.php");

class Categoria{

    function listar($nombre, $estado){
        $sql = "SELECT * FROM categoria WHERE estado<2 AND nombre LIKE :nombre ";
        $parametros = array(':nombre'=>$nombre);
        if($estado!=""){
            $sql.=" AND estado=:estado ";
            $parametros[':estado']=$estado;
        }
        $sql.=" ORDER BY nombre ASC";
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function consultarCategoria($idcategoria){
        $sql = "SELECT * FROM categoria WHERE idcategoria=? ";
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute(array($idcategoria));
        return $pre;
    }

    function consultarCategoriaNombre($nombre, $idcategoria=0){
        $sql = "SELECT * FROM categoria WHERE nombre=? AND idcategoria<>?";
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute(array($nombre,$idcategoria));
        return $pre;
    }

    function insertar($nombre, $estado){
        $sql = "INSERT INTO categoria VALUES (NULL,:nombre, :estado)";
        //$sql = "INSERT INTO categoria(nombre, estado) VALUES (:nombre, :estado)";
        global $cnx;
        $parametros = array(":nombre"=>$nombre, ":estado"=>$estado);
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function actualizar($idcategoria, $nombre, $estado){
        $sql = "UPDATE categoria 
                SET nombre=:nombre, estado=:estado 
                WHERE idcategoria=:idcategoria";
        global $cnx;
        $parametros = array(":idcategoria"=>$idcategoria, ":nombre"=>$nombre, ":estado"=>$estado);
        $pre= $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function actualizarEstado($idcategoria, $estado){
        $sql = "UPDATE categoria SET estado=:estado WHERE idcategoria=:idcategoria";
        global $cnx;
        $parametros = array(":idcategoria"=>$idcategoria, ":estado"=>$estado);
        $pre= $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
}

?>