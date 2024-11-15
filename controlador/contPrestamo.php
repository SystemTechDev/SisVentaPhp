<?php 
include_once("../modelo/Prestamo.php");

controlador($_POST['proceso']);

function controlador($proceso){
    $objPrestamo = new Prestamo();

    switch($proceso){
        case "NUEVO":
            try{
                //$duplicado = $objPrestamo->consultarClienteDocumento($_POST['fecha']);
                //if($duplicado->rowCount()==0){
                 $resultado = $objPrestamo->insertar(
                                            $_POST['personal_id'],
                                            $_POST['herramienta_id'],
                                            $_POST['fechaentrega'],
                                            $_POST['fechadevolucion'],
                                            $_POST['cantidad'],
                                             $_POST['observacion_entrega'],
                                            "Prestado",
                                            $_POST['estado']);
               // $resultado = $objPrestamo->insertar(3,4,"2022-12-17","2022-12-18",5,"observacion_entrega","Prestado","sin observacion","2022-12-18", 1);
                                      
                   if($resultado){
                     echo 1;
                 }else{
                     echo 0;
                 }
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
                //$duplicado = $objPrestamo->consultarClienteDocumento($_POST['fecha'], $_POST['idprestamo']);
               // if($duplicado->rowCount()==0){
                    $resultado = $objPrestamo->actualizar(
                                            $_POST['idprestamo'],
                                            $_POST['personal_id'],
                                            $_POST['herramienta_id'],
                                            $_POST['fechaentrega'],
                                            $_POST['fechadevolucion'],
                                            $_POST['cantidad'],
                                             $_POST['observacion_entrega'],
                                            $_POST['estado']);
                                     
                    echo 1;
               // }else{
                   // echo 2;
               // }
            }catch(Exception $ex){
                echo 0;
            }
            break;
        case "ACTUALIZAR_DEVOLUCION":            
            try{
                $resultado = $objPrestamo->actualizardevolucion(
                                            $_POST['idprestamodev'],
                                            $_POST['fechadevuelto'],
                                            "Devuelto",
                                             $_POST['observacion_devolucion']);
                                     
                    echo 1;
           
            }catch(Exception $ex){
                echo 0;
            }
            break;
        case "ELIMINAR":
            try{
                $resultado = $objPrestamo->actualizarEstado($_POST['idprestamo'],2);
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break;
        case "ANULAR":
            try{
                $resultado = $objPrestamo->actualizarEstado($_POST['idprestamo'],0);
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break;
        case "ACTIVAR":
            try{
                $resultado = $objPrestamo->actualizarEstado($_POST['idprestamo'],1);
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break;  
        case "CONSULTAR":
            $retorno = array();
            try{
                $resultado = $objPrestamo->consultarPrestamo($_POST['idprestamo']);
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