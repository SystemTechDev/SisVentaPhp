<?php 
include_once("conexion.php");

class Perfil{

    function listar($nombre, $estado){
        $sql = "SELECT * FROM perfil WHERE estado<2 AND nombre LIKE :nombre ";
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

    function consultarPerfil($idperfil){
        $sql = "SELECT * FROM perfil WHERE idperfil=? ";
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute(array($idperfil));
        return $pre;
    }

    function consultarPerfilNombre($nombre, $idperfil=0){
        $sql = "SELECT * FROM perfil WHERE nombre=? AND idperfil<>?";
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute(array($nombre,$idperfil));
        return $pre;
    }

    function insertar($nombre, $estado){
        $sql = "INSERT INTO perfil VALUES (NULL,:nombre, :estado)";
        global $cnx;
        $parametros = array(":nombre"=>$nombre, ":estado"=>$estado);
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function actualizar($idperfil, $nombre, $estado){
        $sql = "UPDATE perfil 
                SET nombre=:nombre, estado=:estado 
                WHERE idperfil=:idperfil";
        global $cnx;
        $parametros = array(":idperfil"=>$idcategoria, ":nombre"=>$nombre, ":estado"=>$estado);
        $pre= $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function actualizarEstado($idperfil, $estado){
        $sql = "UPDATE perfil SET estado=:estado WHERE idperfil=:idperfil";
        global $cnx;
        $parametros = array(":idperfil"=>$idperfil, ":estado"=>$estado);
        $pre= $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }    

    function obtenerAcceso($idperfil){
        //$sql = "SELECT t2.* FROM acceso t1 
               // INNER JOIN opcion t2 ON t1.idopcion=t2.idopcion
               // WHERE t1.idperfil=? AND t1.estado=1 AND t2.estado=1";

                $sql = "SELECT t2.* , ct.* FROM acceso t1 
                INNER JOIN opcion t2 ON t1.idopcion=t2.idopcion
                INNER JOIN categoriamenu ct ON t2.categoriamenu_id = ct.id
                WHERE t1.idperfil=? AND t1.estado=1 AND t2.estado=1 ORDER BY ct.orden ASC, t2.orden ASC  ";

        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute(array($idperfil));
        return $pre;
    }

    function insertarAcceso($idperfil, $idopcion){
        $sql = "INSERT INTO acceso VALUES(:idperfil, :idopcion, 1)";
        global $cnx;
        $parametros = array(
                        ':idperfil' => $idperfil,
                        ':idopcion' => $idopcion
                    );
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function desactivarAcceso($idperfil, $idopcion){
        $sql = "UPDATE acceso SET estado=0 WHERE idperfil=:idperfil AND idopcion=:idopcion";
        global $cnx;
        $parametros = array(
                        ':idperfil' => $idperfil,
                        ':idopcion' => $idopcion
                    );
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;        
    }

    function activarAcceso($idperfil, $idopcion){
        $sql = "UPDATE acceso SET estado=1 WHERE idperfil=:idperfil AND idopcion=:idopcion";
        global $cnx;
        $parametros = array(
                        ':idperfil' => $idperfil,
                        ':idopcion' => $idopcion
                    );
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;        
    } 

    function verificarAcceso($idperfil, $idopcion){
        $sql = "SELECT * FROM acceso WHERE idperfil=:idperfil AND idopcion=:idopcion";
        global $cnx;
        $parametros = array(
                        ':idperfil' => $idperfil,
                        ':idopcion' => $idopcion
                    );
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;        
    } 

    function listarOpciones(){
        $sql = "SELECT * FROM opcion WHERE estado=1";
        global $cnx;
        $resultado = $cnx->query($sql);
        return $resultado;
    }
}

?>