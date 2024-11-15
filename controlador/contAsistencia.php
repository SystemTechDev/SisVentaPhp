<?php 
include_once("../modelo/Asistencia.php");

controlador($_POST['proceso']);

function controlador($proceso){
    $objAsistencia = new Asistencia();

    switch($proceso){
        case "NUEVO":
            try{
                //$duplicado = $objAsistencia->consultarClienteDocumento($_POST['fecha']);
                //if($duplicado->rowCount()==0){
                    $resultado = $objAsistencia->insertar(
                                            $_POST['personal_id'],
                                            $_POST['fecha'],
                                            $_POST['asistio'],
                                            $_POST['tiempo'],
                                            $_POST['justificacion'],
                                            $_POST['estado']);                        
                    echo 1;
                //}
                //else{
                   // echo 2;
                //}
            }catch(Exception $ex){
                echo 0;
            }
            break;
        case "ACTUALIZAR":            
            try{
                //$duplicado = $objAsistencia->consultarClienteDocumento($_POST['fecha'], $_POST['idasistencia']);
                //if($duplicado->rowCount()==0){
                    $resultado = $objAsistencia->actualizar(
                                    $_POST['idasistencia'],
                                    $_POST['personal_id'],
                                    $_POST['fecha'],
                                    $_POST['asistio'],
                                    $_POST['tiempo'],
                                    $_POST['justificacion'],
                                    $_POST['estado']); 
                    echo 1;
               // }else{
                   // echo 2;
               // }
            }catch(Exception $ex){
                echo 0;
            }
            break;
        case "ELIMINAR":
            try{
                $resultado = $objAsistencia->actualizarEstado($_POST['idasistencia'],2);
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break;
        case "ANULAR":
            try{
                $resultado = $objAsistencia->actualizarEstado($_POST['idasistencia'],0);
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break;
        case "ACTIVAR":
            try{
                $resultado = $objAsistencia->actualizarEstado($_POST['idasistencia'],1);
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break;  
        case "CONSULTAR":
            $retorno = array();
            try{
                $resultado = $objAsistencia->consultarAsistencias($_POST['idasistencia']);
                if($resultado->rowCount()>0){
                    $retorno = $resultado->fetch(PDO::FETCH_NAMED);
                }
            }catch(Exception $ex){
                $retorno = array();
            }
            echo json_encode($retorno);
            break; 
        
        default:
            echo "No se ha definido proceso";
            break;                                  
    }

}

?>