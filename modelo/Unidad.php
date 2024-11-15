<?php
require_once("conexion.php");

class Unidad{
    function listarUnidad(){
        $sql = "SELECT * FROM unidad WHERE estado=1";
        global $cnx;
        $resultado = $cnx->query($sql);
        return $resultado;
    }

    function listar($nombre, $estado){
        $sql = "SELECT * FROM unidad WHERE estado<2 AND descripcion LIKE :nombre ";
        $parametros = array(':nombre'=>$nombre);
        if($estado!=""){
            $sql.=" AND estado=:estado ";
            $parametros[':estado']=$estado;
        }
        $sql.=" ORDER BY descripcion ASC";
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function consultarUnidad($idunidad){
        $sql = "SELECT * FROM unidad WHERE idunidad=? ";
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute(array($idunidad));
        return $pre;
    }

    function consultarUnidadNombre($nombre, $idunidad=0){
        $sql = "SELECT * FROM unidad WHERE descripcion=? AND idunidad<>?";
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute(array($nombre,$idunidad));
        return $pre;
    }

    function insertar($idunidad,$nombre, $estado){
        $sql = "INSERT INTO unidad VALUES (:idunidad, :nombre, :estado)";
        //$sql = "INSERT INTO categoria(nombre, estado) VALUES (:nombre, :estado)";
        global $cnx;
        $parametros = array(":idunidad"=>$idunidad,":nombre"=>$nombre, ":estado"=>$estado);
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function actualizar($idunidad, $nombre, $estado){
        $sql = "UPDATE unidad 
                SET descripcion=:nombre, estado=:estado 
                WHERE idunidad=:idunidad";
        global $cnx;
        $parametros = array(":idunidad"=>$idunidad, ":nombre"=>$nombre, ":estado"=>$estado);
        $pre= $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function actualizarEstado($idunidad, $estado){
        $sql = "UPDATE unidad SET estado=:estado WHERE idunidad=:idunidad";
        global $cnx;
        $parametros = array(":idunidad"=>$idunidad, ":estado"=>$estado);
        $pre= $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
}
?>