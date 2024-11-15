<?php
include_once("conexion.php");

class Cliente{

    function listar($nombre, $estado){
        $sql = "SELECT * FROM cliente WHERE estado<2 AND nombre LIKE :nombre ";
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

    function consultarCliente($idcliente){
        $sql = "SELECT * FROM cliente WHERE idcliente=? ";
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute(array($idcliente));
        return $pre;
    }

    function consultarClienteDocumento($nrodocumento, $idcliente=0){
        $sql = "SELECT * FROM cliente WHERE nrodocumento=? AND idcliente<>?";
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute(array($nrodocumento,$idcliente));
        return $pre;
    }

    function insertar($nombre,$idtipodocumento, $nrodocumento, $direccion, $estado){
        $sql = "INSERT INTO cliente 
                VALUES (NULL,:nombre, :idtipodocumento, :nrodocumento,:direccion, :estado)";
        global $cnx;
        $parametros = array(
                        ":nombre"=>$nombre,
                        ":idtipodocumento"=>$idtipodocumento,
                        ":nrodocumento"=>$nrodocumento,
                        ":direccion"=>$direccion, 
                        ":estado"=>$estado
                    );
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function actualizar($idcliente, $nombre,$idtipodocumento, $nrodocumento, $direccion, $estado){
        $sql = "UPDATE cliente 
                SET nombre=:nombre, 
                    idtipodocumento=:idtipodocumento,
                    nrodocumento=:nrodocumento,
                    direccion=:direccion,
                    estado=:estado 
                WHERE idcliente=:idcliente";
        global $cnx;
        $parametros = array(
                        ":idcliente"=>$idcliente, 
                        ":nombre"=>$nombre,
                        ":idtipodocumento"=>$idtipodocumento,
                        ":nrodocumento"=>$nrodocumento,
                        ":direccion"=>$direccion, 
                        ":estado"=>$estado
                    );
        $pre= $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function actualizarEstado($idcliente, $estado){
        $sql = "UPDATE cliente SET estado=:estado WHERE idcliente=:idcliente";
        global $cnx;
        $parametros = array(":idcliente"=>$idcliente, ":estado"=>$estado);
        $pre= $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
}

?>