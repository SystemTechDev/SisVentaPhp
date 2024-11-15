<?php
include_once("conexion.php");

class Personal{

    function listar($nombres, $estado){
        $sql = "SELECT * FROM personal WHERE estado<2 AND nombres LIKE :nombres ";
        $parametros = array(':nombres'=>$nombres);
        if($estado!=""){
            $sql.=" AND estado=:estado ";
            $parametros[':estado']=$estado;
        }
        $sql.=" ORDER BY nombres ASC";
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

     function listartodos(){
         $sql = "SELECT * FROM personal WHERE estado=1";
        global $cnx;
        $resultado = $cnx->query($sql);
        return $resultado;
    }

    function consultarPersonal($idpersonal){
        $sql = "SELECT * FROM Personal WHERE idpersonal=? ";
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute(array($idpersonal));
        return $pre;
    }

    function consultarPersonalDocumento($nrodocumento, $idpersonal=0){
        $sql = "SELECT * FROM personal WHERE ndocumento=? AND idpersonal<>?";
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute(array($nrodocumento,$idpersonal));
        return $pre;
    }

 function insertar($idtipodocumento, $nrodocumento,$nombres,$fechan,$correo,$cargo,$celular, $direccion,$sueldo, $estado){
        $sql = "INSERT INTO personal 
                VALUES (NULL, :idtipodocumento, :nrodocumento,:nombres,:fechan,:correo,:cargo,:celular, :direccion,:sueldo,:estado)";
        global $cnx;
        $parametros = array(  
                        ":idtipodocumento"=>$idtipodocumento,
                        ":nrodocumento"=>$nrodocumento,
                        ":nombres"=>$nombres,
                        ":fechan"=>$fechan,
                        ":correo"=>$correo,
                        ":cargo"=>$cargo,
                        ":celular"=>$celular,
                        ":direccion"=>$direccion,
                        ":sueldo"=>$sueldo,
                        ":estado"=>$estado
                    );
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
/*
   function actualizar($idpersonal,$idtipodocumento, $ndocumento, $nombres, $direccion){
        $sql = "UPDATE personal SET tipodocumento_id=:idtipodocumento,ndocumento=:ndocumento, nombres=:nombres, direccion=:direccion  WHERE idpersonal=:idpersonal";
        global $cnx;
        $parametros = array( ":idpersonal"=>$idpersonal,":idtipodocumento"=>$idtipodocumento, ":ndocumento"=>$ndocumento, ":nombres"=>$nombres, ":direccion"=>$direccion );

        $pre= $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    } */

    function actualizar($idpersonal, $idtipodocumento, $ndocumento, $nombres, $fechan, $correo, $cargo, $celular, $direccion, $sueldo, $estado){
        $sql = "UPDATE personal 
        SET tipodocumento_id=:idtipodocumento,
        ndocumento=:ndocumento, 
        nombres=:nombres, 
        fechan=:fechan, 
        correo=:correo,  
        cargo=:cargo,  
        celular=:celular, 
         direccion=:direccion, 
         sueldo=:sueldo,
         estado=:estado 
         WHERE idpersonal=:idpersonal";
        global $cnx;
        $parametros = array(
                        ":idpersonal"=>$idpersonal, 
                        ":idtipodocumento"=>$idtipodocumento,
                        ":ndocumento"=>$ndocumento,
                        ":nombres"=>$nombres,
                        ":fechan"=>$fechan,
                        ":correo"=>$correo,
                        ":cargo"=>$cargo,
                        ":celular"=>$celular,
                        ":direccion"=>$direccion,
                        ":sueldo"=>$sueldo,
                        ":estado"=>$estado
                    );
 
        $pre= $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    } 


    function actualizarEstado($idpersonal, $estado){
        $sql = "UPDATE personal SET estado=:estado WHERE idpersonal=:idpersonal";
        global $cnx;
        $parametros = array(":idpersonal"=>$idpersonal, ":estado"=>$estado);
        $pre= $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
}

?>