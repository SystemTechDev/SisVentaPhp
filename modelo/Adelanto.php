<?php
include_once("conexion.php");

class Adelanto{

    function listar(){
         $sql = "SELECT ap.*, p.nombres FROM adelanto ap INNER JOIN personal p ON p.idpersonal=ap.personal_id";
        global $cnx;
        $resultado = $cnx->query($sql);
        return $resultado;
    }

     function listar2($nombres,$fecha){
         $sql = "SELECT ap.*, p.nombres FROM adelanto ap INNER JOIN personal p ON p.idpersonal=ap.personal_id WHERE ap.estado<2 AND p.nombres LIKE :nombres";
        //$sql = "SELECT * FROM adelanto WHERE estado<2  ";
        $parametros = array(':nombres'=>$nombres);
       // if($nombres!=""){
          //  $sql.=" AND p.nombres LIKE :nombres";
          //  $parametros = array(':nombres'=>$nombres, ':fecha'=>$fecha);
        //}
        
        if($fecha!=""){
            $sql.=" AND ap.fecha =:fecha";
            $parametros[':fecha']=$fecha;
        }
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function consultarAdelanto($idadelanto){
        $sql = "SELECT * FROM adelanto WHERE idadelanto=? ";
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute(array($idadelanto));
        return $pre;
    }

    function consultarAdelantoPersonal($fecha, $personal_id, $idadelanto=0){
        $sql = "SELECT * FROM adelanto WHERE personal_id=? AND idadelanto<>?";
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute(array($nrodocumento,$idadelanto));
        return $pre;
    }

    function insertar( $personal_id,$fecha, $monto, $estado){
        $sql = "INSERT INTO adelanto 
                VALUES (NULL,:personal_id,:fecha, :monto, :estado)";
        global $cnx;
        $parametros = array(
                        ":personal_id"=>$personal_id,
                        ":fecha"=>$fecha,
                        ":monto"=>$monto,
                        ":estado"=>$estado
                    );
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function actualizar($idadelanto, $personal_id,$fecha, $monto, $estado){
        $sql = "UPDATE adelanto 
                SET 
                    personal_id=:personal_id,
                    fecha=:fecha, 
                    monto=:monto,
                    estado=:estado 
                WHERE idadelanto=:idadelanto";
        global $cnx;
        $parametros = array(
                        ":idadelanto"=>$idadelanto,
                        ":personal_id"=>$personal_id,
                        ":fecha"=>$fecha,
                        ":monto"=>$monto,
                        ":estado"=>$estado
                    );
        $pre= $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function actualizarEstado($idadelanto, $estado){
        $sql = "UPDATE adelanto SET estado=:estado WHERE idadelanto=:idadelanto";
        global $cnx;
        $parametros = array(":idadelanto"=>$idadelanto, ":estado"=>$estado);
        $pre= $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
   
}

?>