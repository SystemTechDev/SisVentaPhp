<?php
include_once("conexion.php");

class ModeloPruebas{
/*
    $personal_id=1;
    $herramienta_id=2;
    $fechaentrega="";
    $fechadevolucion="";
    $cantidad=2;
    $observacion="";
    $estadoprestamo="";
    $observaciondev="";
    $fechadevuelto="";
    $estado=1; */

    function insertar($personal_id, $herramienta_id, $fechaentrega, $fechadevolucion, $cantidad, $observacion, $estadoprestamo, $observaciondev,$fechadevuelto, $estado){
        $sql = "INSERT INTO prestamo VALUES (NULL, :personal_id, :herramienta_id, :fechaentrega, :fechadevolucion, :cantidad,:observacion,:estadoprestamo, :observaciondev,:fechadevuelto, :estado)";
        global $cnx;
        $parametros = array(
                        ":personal_id"=>$personal_id,
                        ":herramienta_id"=>$herramienta_id,
                        ":fechaentrega"=>$fechaentrega,
                        ":fechadevolucion"=>$fechadevolucion,
                        ":cantidad"=>$cantidad,
                        ":observacion"=>$observacion,
                        ":estadoprestamo"=>$estadoprestamo,
                        ":observaciondev"=>$observaciondev,
                        ":fechadevuelto"=>$fechadevuelto,
                        ":estado"=>$estado
                    );
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
        //var_dump($pre);
        
    }

function insertar2($personal_id, $herramienta_id, $cantidad,$observacion,$estadoprestamo,$observaciondev, $estado){
        $sql = "INSERT INTO prestamo VALUES (NULL, :personal_id, :herramienta_id, :cantidad,:observacion,:estadoprestamo,:observaciondev, :estado)";
        global $cnx;
        $parametros = array(
                        ":personal_id"=>$personal_id,
                        ":herramienta_id"=>$herramienta_id,
                        ":cantidad"=>$cantidad,
                        ":observacion"=>$observacion,
                        ":estadoprestamo"=>$estadoprestamo,
                        ":observaciondev"=>$observaciondev,
                        ":estado"=>$estado
                    );
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
        //var_dump($pre);
        
    }

    function insertar3($personal_id, $herramienta_id, $cantidad, $estado){
        $sql = "INSERT INTO prestamo VALUES (NULL, :personal_id, :herramienta_id, :cantidad, :estado)";
        global $cnx;
        $parametros = array(
                        ":personal_id"=>$personal_id,
                        ":herramienta_id"=>$herramienta_id,
                        ":cantidad"=>$cantidad,
                        ":estado"=>$estado
                    );
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
        //var_dump($pre);
        
    }
     
    
}
$objPrueba= new ModeloPruebas;
$resultado=$objPrueba->insertar(1,1,"2022-12-17","2022-12-18",5,"observacion_entrega","Prestado","sin observacion","2022-12-18", 1);
//$resultado=$objPrueba->insertar2(3,4,5,"so","Prestado","na", 1);
//$resultado=$objPrueba->insertar3(3,4,5,1);
if ($resultado) {
    echo "Registrado con exito";
}

?>