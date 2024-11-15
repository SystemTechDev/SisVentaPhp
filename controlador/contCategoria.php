<?php 
include_once("../modelo/Categoria.php");

controlador($_POST['proceso']);

function controlador($proceso){
    $objCat = new Categoria();

    switch($proceso){
        case "NUEVO":
            try{
                $duplicado = $objCat->consultarCategoriaNombre($_POST['nombre']);
                if($duplicado->rowCount()==0){
                    $resultado = $objCat->insertar($_POST['nombre'], $_POST['estado']);                        
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
                $duplicado = $objCat->consultarCategoriaNombre($_POST['nombre'], $_POST['idcategoria']);
                if($duplicado->rowCount()==0){
                    $resultado = $objCat->actualizar($_POST['idcategoria'],$_POST['nombre'], $_POST['estado']);
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
                $resultado = $objCat->actualizarEstado($_POST['idcategoria'],2);
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break;
        case "ANULAR":
            try{
                $resultado = $objCat->actualizarEstado($_POST['idcategoria'],0);
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break;
        case "ACTIVAR":
            try{
                $resultado = $objCat->actualizarEstado($_POST['idcategoria'],1);
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break;  
        case "CONSULTAR":
            $retorno = array();
            try{
                $resultado = $objCat->consultarCategoria($_POST['idcategoria']);
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