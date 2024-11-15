<?php 
include_once("../modelo/Perfil.php");

controlador($_POST['proceso']);

function controlador($proceso){
    $objPer = new Perfil();

    switch($proceso){
        case "NUEVO":
            try{
                $duplicado = $objPer->consultarPerfilNombre($_POST['nombre']);
                if($duplicado->rowCount()==0){
                    $resultado = $objPer->insertar($_POST['nombre'], $_POST['estado']);                        
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
                $duplicado = $objPer->consultarPerfilNombre($_POST['nombre'], $_POST['idperfil']);
                if($duplicado->rowCount()==0){
                    $resultado = $objPer->actualizar($_POST['idperfil'],$_POST['nombre'], $_POST['estado']);
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
                $resultado = $objPer->actualizarEstado($_POST['idperfil'],2);
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break;
        case "ANULAR":
            try{
                $resultado = $objPer->actualizarEstado($_POST['idperfil'],0);
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break;
        case "ACTIVAR":
            try{
                $resultado = $objPer->actualizarEstado($_POST['idperfil'],1);
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break;  
        case "CONSULTAR":
            $retorno = array();
            try{
                $resultado = $objPer->consultarPerfil($_POST['idperfil']);
                if($resultado->rowCount()>0){
                    $retorno = $resultado->fetch(PDO::FETCH_NAMED);
                }
            }catch(Exception $ex){
                $retorno = array();
            }
            echo json_encode($retorno);
            break; 
        case "ACTIVAR_ACCESO":
            try{
                $existe = $objPer->verificarAcceso($_POST['idperfil'], $_POST['idopcion']);
                if($existe->rowCount()>0){
                    $objPer->activarAcceso($_POST['idperfil'], $_POST['idopcion']);
                }else{
                    $objPer->insertarAcceso($_POST['idperfil'], $_POST['idopcion']);
                }
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break;

        case "DESACTIVAR_ACCESO":
                try{
                    $objPer->desactivarAcceso($_POST['idperfil'], $_POST['idopcion']);
                    echo 1;
                }catch(Exception $ex){
                    echo 0;
                } 
            break;
        case "CONSULTAR_ACCESO":
                $retorno = array();
                try{
                    $resultado = $objPer->obtenerAcceso($_POST['idperfil']);
                    $retorno = $resultado->fetchAll(PDO::FETCH_NAMED);
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