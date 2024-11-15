<?php
include_once("conexion.php");

class Asistencia{

    function listar(){
         $sql = "SELECT ap.*, p.nombres FROM asistencia ap INNER JOIN personal p ON p.idpersonal=ap.personal_id WHERE ap.asistio='NO' ";
        global $cnx;
        $resultado = $cnx->query($sql);
        return $resultado;
    }

    function listar2($nombres,$fecha){
         $sql = "SELECT ap.*, p.nombres FROM asistencia ap INNER JOIN personal p ON p.idpersonal=ap.personal_id WHERE ap.estado<2 AND p.nombres LIKE :nombres";
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

    function consultarAsistencias($idasistencia){
        $sql = "SELECT * FROM asistencia WHERE idasistencia=? ";
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute(array($idasistencia));
        return $pre;
    }

    function consultarAsistenciaPersonal($fecha, $personal_id, $idasistencia=0){
        $sql = "SELECT * FROM asistencia WHERE personal_id=? AND idasistencia<>?";
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute(array($nrodocumento,$idasistencia));
        return $pre;
    }

    function insertar( $personal_id,$fecha, $asistio, $tiempo, $justificacion, $estado){
        $sql = "INSERT INTO asistencia 
                VALUES (NULL,:personal_id, :fecha, :asistio, :tiempo, :justificacion, :estado)";
        global $cnx;
        $parametros = array(
                        ":personal_id"=>$personal_id,
                        ":fecha"=>$fecha,
                        ":asistio"=>$asistio,
                        ":tiempo"=>$tiempo,
                        ":justificacion"=>$justificacion,
                        ":estado"=>$estado
                    );
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function actualizar($idasistencia, $personal_id,$fecha, $asistio, $tiempo, $justificacion, $estado){
        $sql = "UPDATE asistencia 
                SET 
                    personal_id=:personal_id,
                    fecha=:fecha, 
                    asistio=:asistio,
                    tiempo=:tiempo,
                    justificacion=:justificacion,
                    estado=:estado 
                WHERE idasistencia=:idasistencia";
        global $cnx;
        $parametros = array(
                        ":idasistencia"=>$idasistencia,
                        ":personal_id"=>$personal_id,
                        ":fecha"=>$fecha,
                        ":asistio"=>$asistio,
                        ":tiempo"=>$tiempo,
                        ":justificacion"=>$justificacion,
                        ":estado"=>$estado
                    );
        $pre= $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    function actualizarEstado($idasistencia, $estado){
        $sql = "UPDATE asistencia SET estado=:estado WHERE idasistencia=:idasistencia";
        global $cnx;
        $parametros = array(":idasistencia"=>$idasistencia, ":estado"=>$estado);
        $pre= $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

    
}

?>