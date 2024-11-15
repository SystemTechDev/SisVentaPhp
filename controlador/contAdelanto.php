<?php 
include_once("../modelo/Adelanto.php");

controlador($_POST['proceso']);

function controlador($proceso){
    $objAdelanto = new Adelanto();

    switch($proceso){
        case "NUEVO":
            try{
                //$duplicado = $objAdelanto->consultarClienteDocumento($_POST['fecha']);
                //if($duplicado->rowCount()==0){
                    $resultado = $objAdelanto->insertar(
                                            $_POST['personal_id'],
                                            $_POST['fecha'],
                                            $_POST['monto'],
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
                //$duplicado = $objAdelanto->consultarClienteDocumento($_POST['fecha'], $_POST['idadelanto']);
               // if($duplicado->rowCount()==0){
                    $resultado = $objAdelanto->actualizar(
                                    $_POST['idadelanto'],
                                    $_POST['personal_id'],
                                    $_POST['fecha'],
                                    $_POST['monto'],
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
                $resultado = $objAdelanto->actualizarEstado($_POST['idadelanto'],2);
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break;
        case "ANULAR":
            try{
                $resultado = $objAdelanto->actualizarEstado($_POST['idadelanto'],0);
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break;
        case "ACTIVAR":
            try{
                $resultado = $objAdelanto->actualizarEstado($_POST['idadelanto'],1);
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break;  
        case "CONSULTAR":
            $retorno = array();
            try{
                $resultado = $objAdelanto->consultarAdelanto($_POST['idadelanto']);
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