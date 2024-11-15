<?php 
include_once("../modelo/Personal.php");

controlador($_POST['proceso']);

function controlador($proceso){
    $objPersonal = new Personal();

    switch($proceso){
        case "NUEVO":
            try{
                $duplicado = $objPersonal->consultarPersonalDocumento($_POST['ndocumento']);
                if($duplicado->rowCount()==0){
                    $resultado = $objPersonal->insertar(
                                            $_POST['idtipodocumento'],
                                            $_POST['ndocumento'],
                                            $_POST['nombres'],
                                            $_POST['fechanac'],
                                            $_POST['correo'],
                                            $_POST['cargoempresa'],
                                            $_POST['celular'],
                                            $_POST['direccion'],
                                            $_POST['sueldo'],
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
                $duplicado = $objPersonal->consultarPersonalDocumento($_POST['ndocumento'], $_POST['idpersonal']);
                if($duplicado->rowCount()==0){ 
                 $resultado = $objPersonal->actualizar(
                                            $_POST['idpersonal'],
                                            $_POST['idtipodocumento'],
                                            $_POST['ndocumento'],
                                            $_POST['nombres'],
                                            $_POST['fechanac'],
                                            $_POST['correo'],
                                            $_POST['cargoempresa'],
                                            $_POST['celular'],
                                            $_POST['direccion'],
                                            $_POST['sueldo'],
                                            $_POST['estado']);
                 //$resultado = $objPersonal->actualizar( $_POST['idpersonal'],$_POST['idtipodocumento'],$_POST['ndocumento'], $_POST['nombres'], $_POST['direccion']);  

                                           // var_dump($resultado);
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
                $resultado = $objPersonal->actualizarEstado($_POST['idpersonal'],2);
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break;
        case "ANULAR":
            try{
                $resultado = $objPersonal->actualizarEstado($_POST['idpersonal'],0);
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break;
        case "ACTIVAR":
            try{
                $resultado = $objPersonal->actualizarEstado($_POST['idpersonal'],1);
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break;  
        case "CONSULTAR":
            $retorno = array();
            try{
                $resultado = $objPersonal->consultarPersonal($_POST['idpersonal']);
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
                    $nrodocumento =  $_POST['ndocumento'];
                    $retorno = array(
                            "nombre"=>"",
                            "direccion"=>""
                        );
                    if($idtipodoc==1){
                        $ws = "https://dniruc.apisperu.com/api/v1/dni/".$nrodocumento."?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6Imx1aXN0aW1hbmFnb256YWdhQGhvdG1haWwuY29tIn0.IxAceLS9puCS0LdM3yLtHZwzsstZAX6ot6RZdTVAiZc";
                        $datos = file_get_contents($ws);
                        $datos = json_decode($datos,true);
                        if(isset($datos['nombres'])){
                            $retorno["nombre"]=$datos['nombres'].' '.$datos['apellidoPaterno'].' '.$datos['apellidoMaterno'];
                        }
                    }

                    if($idtipodoc==6){
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