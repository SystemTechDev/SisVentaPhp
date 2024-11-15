<?php
include_once("conexion.php");

class Herramienta{

    function listar($nombre, $estado){
        $sql = "SELECT * FROM herramienta WHERE estado<2 AND nombre LIKE :nombre ";
        $parametros = array(':nombre'=>$nombre);
        if($estado!=""){
            $sql.=" AND estado=:estado ";
            $parametros[':estado']=$estado;
        }
        //$sql.=" ORDER BY nombre ASC";
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function listartodos(){
        $sql = "SELECT * FROM herramienta WHERE estado=1";
        global $cnx;
        $resultado = $cnx->query($sql);
        return $resultado;
    }

    function consultarHerramienta($idherramienta){
        $sql = "SELECT * FROM herramienta WHERE idherramienta=? ";
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute(array($idherramienta));
        return $pre;
    }

    function consultarHerramientaDuplicado($serie, $idherramienta=0){
        $sql = "SELECT * FROM herramienta WHERE serie=? AND idherramienta<>?";
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute(array($serie,$idherramienta));
        return $pre;
    }

    function insertar($cantidad, $nombre, $marca, $modelo, $serie, $descripcion, $color, $estado){
        $sql = "INSERT INTO herramienta 
                VALUES (NULL,:cantidad, :nombre, :marca, :modelo, :serie, :descripcion, :color, :estado)";
        global $cnx;
        $parametros = array(
                        ":cantidad"=>$cantidad,
                        ":nombre"=>$nombre,
                        ":marca"=>$marca,
                        ":modelo"=>$modelo,
                        ":serie"=>$serie,
                        ":descripcion"=>$descripcion,
                        ":color"=>$color, 
                        ":estado"=>$estado
                    );
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function actualizar($idherramienta, $cantidad, $nombre, $marca, $modelo, $serie, $descripcion, $color, $estado){
        $sql = "UPDATE herramienta 
                SET cantidad=:cantidad,
                    nombre=:nombre, 
                    marca=:marca,
                    modelo=:modelo,
                    serie=:serie,
                    descripcion=:descripcion,
                    color=:color,
                    estado=:estado 
                WHERE idherramienta=:idherramienta";
        global $cnx;
        $parametros = array(
                        ":idherramienta"=>$idherramienta, 
                        ":cantidad"=>$cantidad,
                        ":nombre"=>$nombre,
                        ":marca"=>$marca,
                        ":modelo"=>$modelo,
                        ":serie"=>$serie,
                        ":descripcion"=>$descripcion,
                        ":color"=>$color, 
                        ":estado"=>$estado
                    );
        $pre= $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function actualizarEstado($idherramienta, $estado){
        $sql = "UPDATE herramienta SET estado=:estado WHERE idherramienta=:idherramienta";
        global $cnx;
        $parametros = array(":idherramienta"=>$idherramienta, ":estado"=>$estado);
        $pre= $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
}

?>