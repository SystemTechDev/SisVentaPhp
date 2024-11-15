<?php 
include_once("../modelo/Cliente.php");

controlador($_POST['proceso']);

function controlador($proceso){
    $objClie = new Cliente();

    switch($proceso){
        case "NUEVO":
            try{
                $duplicado = $objClie->consultarClienteDocumento($_POST['nrodocumento']);
                if($duplicado->rowCount()==0){
                    $resultado = $objClie->insertar(
                                            $_POST['nombre'],
                                            $_POST['idtipodocumento'],
                                            $_POST['nrodocumento'],
                                            $_POST['direccion'],
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
                $duplicado = $objClie->consultarClienteDocumento($_POST['nrodocumento'], $_POST['idcliente']);
                if($duplicado->rowCount()==0){
                    $resultado = $objClie->actualizar(
                                    $_POST['idcliente'],
                                    $_POST['nombre'],
                                    $_POST['idtipodocumento'],
                                    $_POST['nrodocumento'],
                                    $_POST['direccion'],
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
                $resultado = $objClie->actualizarEstado($_POST['idcliente'],2);
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break;
        case "ANULAR":
            try{
                $resultado = $objClie->actualizarEstado($_POST['idcliente'],0);
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break;
        case "ACTIVAR":
            try{
                $resultado = $objClie->actualizarEstado($_POST['idcliente'],1);
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break;  
        case "CONSULTAR":
            $retorno = array();
            try{
                $resultado = $objClie->consultarCliente($_POST['idcliente']);
                if($resultado->rowCount()>0){
                    $retorno = $resultado->fetch(PDO::FETCH_NAMED);
                }
            }catch(Exception $ex){
                $retorno = array();
            }
            echo json_encode($retorno);
            break; 
        case "CONSULTAR_WS":
                $retorno = array();
                try{
                    $idtipodoc = $_POST['idtipodocumento'];
                    $nrodocumento =  $_POST['nrodocumento'];
                    $retorno = array(
                            "idtipodocumento"=>$_POST['idtipodocumento'],
                            "nombre"=>"",
                            "direccion"=>""
                        );
                    
                    $existe = $objClie->consultarClienteDocumento($_POST['nrodocumento']);
                    $consultarws = true;
                    if($existe->rowCount()>0){
                        $cliente = $existe->fetch(PDO::FETCH_NAMED);
                        $retorno = array(
                            "idtipodocumento"=>$cliente["idtipodocumento"],
                            "nombre"=>$cliente['nombre'],
                            "direccion"=>$cliente['direccion']
                        );
                        $consultarws = false;
                    }   

                    if($idtipodoc==1 && $consultarws){
                        $ws = "https://dniruc.apisperu.com/api/v1/dni/".$nrodocumento."?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6Imx1aXN0aW1hbmFnb256YWdhQGhvdG1haWwuY29tIn0.IxAceLS9puCS0LdM3yLtHZwzsstZAX6ot6RZdTVAiZc";
                        $datos = file_get_contents($ws);
                        $datos = json_decode($datos,true);
                        if(isset($datos['nombres'])){
                            $retorno["nombre"]=$datos['nombres'].' '.$datos['apellidoPaterno'].' '.$datos['apellidoMaterno'];
                        }
                    }

                    if($idtipodoc==6 && $consultarws){
                        $ws = "http://www.vfpsteambi.solutions/vfpsapiruc/vfpsapiruc.php?ruc=$nrodocumento";
                        $datos = file_get_contents($ws);
                        $datos = json_decode($datos,true);
                        if(isset($datos['nombre'])){
                            $retorno['nombre'] = $datos['nombre'];
                            $retorno['direccion'] = $datos['domicilio'];
                        }
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