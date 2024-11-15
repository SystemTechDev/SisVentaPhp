<?php 
include_once("../modelo/Herramienta.php");

controlador($_POST['proceso']);

function controlador($proceso){
    $objHerramienta = new Herramienta();

    switch($proceso){
        case "NUEVO":
            try{
                $duplicado = $objHerramienta->consultarHerramientaDuplicado($_POST['serie']);
                if($duplicado->rowCount()==0){
                    $resultado = $objHerramienta->insertar(
                                                            $_POST['cantidad'],
                                                            $_POST['nombre'],
                                                            $_POST['marca'],
                                                            $_POST['modelo'],
                                                            $_POST['serie'],
                                                            $_POST['descripcion'],
                                                            $_POST['color'],
                                                            $_POST['estado']);                        
                    echo 1;
                }else{
                    echo 2;
                }
            }catch(Exception $ex){
                echo 0;
            }
            break;
        case "ACTUALIZAR":            
            try{
                $duplicado = $objHerramienta->consultarHerramientaDuplicado($_POST['nrodocumento'], $_POST['idherramienta']);
                if($duplicado->rowCount()==0){
                    $resultado = $objHerramienta->actualizar(
                                                             $_POST['idherramienta'],
                                                             $_POST['cantidad'],
                                                             $_POST['nombre'],
                                                             $_POST['marca'],
                                                             $_POST['modelo'],
                                                             $_POST['serie'],
                                                             $_POST['descripcion'],
                                                             $_POST['color'],
                                                             $_POST['estado']);  
                    echo 1;
                }else{
                    echo 2;
                }
            }catch(Exception $ex){
                echo 0;
            }
            break;
        case "ELIMINAR":
            try{
                $resultado = $objHerramienta->actualizarEstado($_POST['idherramienta'],2);
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break;
        case "ANULAR":
            try{
                $resultado = $objHerramienta->actualizarEstado($_POST['idherramienta'],0);
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break;
        case "ACTIVAR":
            try{
                $resultado = $objHerramienta->actualizarEstado($_POST['idherramienta'],1);
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break;  
        case "CONSULTAR":
            $retorno = array();
            try{
                $resultado = $objHerramienta->consultarHerramienta($_POST['idherramienta']);
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