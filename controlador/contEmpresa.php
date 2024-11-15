<?php 
include_once("../modelo/Empresa.php");

controlador($_POST['proceso']);

function controlador($proceso){
    $objEmpresa = new Empresa();

    switch($proceso){
        case "NUEVO":
            try{
                //$duplicado = $objAsistencia->consultarClienteDocumento($_POST['fecha']);
                //if($duplicado->rowCount()==0){
                    $resultado = $objEmpresa->insertar(
                                            $_POST['personal_id'],
                                            $_POST['fecha'],
                                            $_POST['asistio'],
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
                    $resultado = $objEmpresa->actualizar(
                                    $_POST['idemisor'],
                                    $_POST['tipo_doc'],
                                    $_POST['numero_doc'],
                                    $_POST['razon_social'],
                                    $_POST['nombre_comercial'],
                                    $_POST['correo'],
                                    $_POST['telefono'],
                                    $_POST['direccion'],
                                    $_POST['otro']); 
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
                $resultado = $objEmpresa->actualizarEstado($_POST['idasistencia'],2);
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break;
        case "ANULAR":
            try{
                $resultado = $objEmpresa->actualizarEstado($_POST['idasistencia'],0);
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break;
        case "ACTIVAR":
            try{
                $resultado = $objEmpresa->actualizarEstado($_POST['idasistencia'],1);
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break;  
        case "CONSULTAR":
            $retorno = array();
            try{
                $resultado = $objEmpresa->consultarEmpresa($_POST['idemisor']);
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