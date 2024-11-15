<?php 
include_once("../modelo/Unidad.php");

controlador($_POST['proceso']);

function controlador($proceso){
    $objUnd = new Unidad();

    switch($proceso){
        case "NUEVO": 
            try{
                $duplicado = $objUnd->consultarUnidadNombre($_POST['nombre']);
                if($duplicado->rowCount()==0){
                    $resultado = $objUnd->insertar($_POST['idunidad'],$_POST['nombre'], $_POST['estado']);                        
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
                $duplicado = $objUnd->consultarUnidadNombre($_POST['nombre'], $_POST['idunidad']);
                if($duplicado->rowCount()==0){
                    $resultado = $objUnd->actualizar($_POST['idunidad'],$_POST['nombre'], $_POST['estado']);
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
                $resultado = $objUnd->actualizarEstado($_POST['idunidad'],2);
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break;
        case "ANULAR":
            try{
                $resultado = $objUnd->actualizarEstado($_POST['idunidad'],0);
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break;
        case "ACTIVAR":
            try{
                $resultado = $objUnd->actualizarEstado($_POST['idunidad'],1);
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break;  
        case "CONSULTAR":
            $retorno = array();
            try{
                $resultado = $objUnd->consultarUnidad($_POST['idunidad']);
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