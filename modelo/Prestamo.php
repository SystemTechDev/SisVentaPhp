<?php
include_once("conexion.php");

class Prestamo{

    function listar(){
         $sql = "SELECT ap.*, p.nombres FROM adelanto ap 
         INNER JOIN personal p ON p.idpersonal=ap.personal_id
         INNER JOIN herramienta p ON p.idpersonal=ap.personal_id";
        global $cnx;
        $resultado = $cnx->query($sql);
        return $resultado;
    }

     function listar2($nombres,$fecha){
         $sql = "SELECT ph.*, p.nombres, h.nombre FROM prestamo ph 
         INNER JOIN personal p ON p.idpersonal=ph.personal_id 
         INNER JOIN herramienta h ON h.idherramienta=ph.herramienta_id
         WHERE ph.estado<2 AND p.nombres LIKE :nombres";
        //$sql = "SELECT * FROM adelanto WHERE estado<2  ";
        $parametros = array(':nombres'=>$nombres);
       // if($nombres!=""){
          //  $sql.=" AND p.nombres LIKE :nombres";
          //  $parametros = array(':nombres'=>$nombres, ':fecha'=>$fecha);
        //}
        
        if($fecha!=""){
            $sql.=" AND ph.fechaentrega =:fecha";
            $parametros[':fecha']=$fecha;
        }
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function consultarPrestamo($idprestamo){
        $sql = "SELECT * FROM prestamo WHERE idprestamo=? ";
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute(array($idprestamo));
        return $pre;
    }

    function consultarAdelantoPersonal($fecha, $personal_id, $idadelanto=0){
        $sql = "SELECT * FROM prestamo WHERE personal_id=? AND idadelanto<>?";
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute(array($nrodocumento,$idadelanto));
        return $pre;
    }

    function insertar($personal_id, $herramienta_id, $fechaentrega, $fechadevolucion, $cantidad, $observacion, $estadoprestamo, $estado){
        $sql = "INSERT INTO prestamo 
                VALUES (NULL, :personal_id, :herramienta_id, :fechaentrega, :fechadevolucion, :cantidad,:observacion,:estadoprestamo,NULL,NULL, :estado)";
        global $cnx;
        $parametros = array(
                        ":personal_id"=>$personal_id,
                        ":herramienta_id"=>$herramienta_id,
                        ":fechaentrega"=>$fechaentrega,
                        ":fechadevolucion"=>$fechadevolucion,
                        ":cantidad"=>$cantidad,
                        ":observacion"=>$observacion,
                        ":estadoprestamo"=>$estadoprestamo,
                        ":estado"=>$estado
                    );
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
        //var_dump($pre);
        
    }


    function insertar2($personal_id, $estado){
        $sql = "INSERT INTO prestamo 
                VALUES (NULL, :personal_id, :estado)";
        global $cnx;
        $parametros = array(":personal_id"=>$personal_id,":estado"=>$estado );
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function actualizar($idprestamo, $personal_id, $herramienta_id, $fechaentrega, $fechadevolucion, $cantidad, $observacion, $estado){
        $sql = "UPDATE prestamo 
                SET 
                    personal_id=:personal_id,
                    herramienta_id=:herramienta_id,
                    fechaentrega=:fechaentrega,
                    fechadevolucion=:fechadevolucion,
                    cantidad=:cantidad, 
                    observacion=:observacion,
                    estado=:estado 
                WHERE idprestamo=:idprestamo";
        global $cnx;
        $parametros = array(
                        ":idprestamo"=>$idprestamo,
                        ":personal_id"=>$personal_id,
                        ":herramienta_id"=>$herramienta_id,
                        ":fechaentrega"=>$fechaentrega,
                        ":fechadevolucion"=>$fechadevolucion,
                        ":cantidad"=>$cantidad,
                        ":observacion"=>$observacion,
                        ":estado"=>$estado
                        );
        $pre= $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function actualizardevolucion($idprestamo, $fechadevuelto, $estadoprestamo, $observaciondev){
        $sql = "UPDATE prestamo 
                SET 
                    fechadevuelto=:fechadevuelto, 
                    estadoprestamo=:estadoprestamo,
                    observaciondev=:observaciondev 
                WHERE idprestamo=:idprestamo";
        global $cnx;
        $parametros = array(
                        ":idprestamo"=>$idprestamo,
                        ":fechadevuelto"=>$fechadevuelto,
                        ":estadoprestamo"=>$estadoprestamo,
                        ":observaciondev"=>$observaciondev
                        );
        $pre= $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function actualizarEstado($idprestamo, $estado){
        $sql = "UPDATE adelanto SET estado=:estado WHERE idprestamo=:idprestamo";
        global $cnx;
        $parametros = array(":idprestamo"=>$idprestamo, ":estado"=>$estado);
        $pre= $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
   
}

?>