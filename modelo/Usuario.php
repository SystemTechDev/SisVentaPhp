<?php 
include_once("conexion.php");

class Usuario{

    function listar($nombre, $estado){
        $sql = "SELECT u.*,p.nombre perfil FROM usuario u 
                LEFT JOIN perfil p ON u.idperfil=p.idperfil
                WHERE u.estado<2 AND u.nombre LIKE :nombre ";
        $parametros = array(':nombre'=>$nombre);
        if($estado!=""){
            $sql.=" AND u.estado=:estado ";
            $parametros[':estado']=$estado;
        }
        $sql.=" ORDER BY u.nombre ASC";
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function consultarUsuario($idusuario){
        $sql = "SELECT * FROM usuario WHERE idusuario=? ";
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute(array($idusuario));
        return $pre;
    }

    function consultarUsuarioNombre($usuario, $idusuario=0){
        $sql = "SELECT * FROM usuario WHERE usuario=? AND idusuario<>?";
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute(array($usuario,$idusuario));
        return $pre;
    }

    function insertar($nombre, $usuario, $clave, $idperfil, $estado){
        $sql = "INSERT INTO usuario VALUES (NULL,:nombre,:usuario, SHA1(:clave),:idperfil, :estado)";
        global $cnx;
        $parametros = array(":nombre"=>$nombre, 
                            ":usuario"=>$usuario,
                            ":clave"=>$clave,
                            ":idperfil"=>$idperfil,
                            ":estado"=>$estado);
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function actualizar($idusuario, $nombre, $usuario, $clave, $idperfil, $estado){
        $sql = "UPDATE usuario 
                SET nombre=:nombre, 
                    usuario=:usuario,";
        
        $parametros = array(":idusuario"=>$idusuario, 
                            ":nombre"=>$nombre, 
                            ":usuario"=>$usuario,
                            ":idperfil"=>$idperfil,
                            ":estado"=>$estado);
 
        if($clave!=""){
            $sql.=" clave=SHA1(:clave), ";
            $parametros[':clave']=$clave;
        }
        $sql.=" idperfil=:idperfil,
                    estado=:estado 
                WHERE idusuario=:idusuario";
        global $cnx;
        $pre= $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function actualizarEstado($idusuario, $estado){
        $sql = "UPDATE usuario SET estado=:estado WHERE idusuario=:idusuario";
        global $cnx;
        $parametros = array(":idusuario"=>$idusuario, ":estado"=>$estado);
        $pre= $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function verificarUsuario($usuario, $clave){
        $sql = "SELECT * FROM usuario 
                WHERE usuario=:usuario AND clave=SHA1(:clave)
                        AND estado=1";
        global $cnx;
        $parametros = array(':usuario'=>$usuario, ':clave'=>$clave);
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function totalUsuariosActivos(){
        $sql = "SELECT count(*) FROM usuario WHERE estado=1";
        global $cnx;
        $resultado = $cnx->query($sql);
        return $resultado;
    }
}
?>