<?php 
include_once("../modelo/Producto.php");
include_once("../modelo/Venta.php");

controlador($_POST['proceso']);

function controlador($proceso){
    $objPro = new Producto();
    $objVen = new Venta();

    switch($proceso){
        case "NUEVO":
            try{
                $duplicado = $objPro->consultarProductoNombre($_POST['nombre'],$_POST['codigobarra']);
                if($duplicado->rowCount()==0){
                    $producto= array(
                        "nombre"        =>$_POST['nombre'], 
                        "codigobarra"   =>$_POST['codigobarra'], 
                        "pventa"        =>$_POST['pventa'], 
                        "pcompra"       =>$_POST['pcompra'],  
                        "stock"         =>$_POST['stock'], 
                        "idunidad"      =>$_POST['idunidad'], 
                        "idcategoria"   =>$_POST['idcategoria'], 
                        "idafectacion"  =>$_POST['idafectacion'],
                        "afectoicbper"  =>$_POST['afectoicbper'], 
                        "estado"        =>$_POST['estado'],
                        "stockseguridad"=>$_POST['stockseguridad']                                                    
                    );
                    $resultado = $objPro->insertar($producto);                        
                    echo 1;
                }else{
                    $duplicado = $duplicado->fetch();
                    if($duplicado['nombre']==$_POST['nombre']){
                        echo 2;
                    }else if($duplicado['codigobarra']==$_POST['codigobarra']){
                        echo 3;
                    }

                }
            }catch(Exception $ex){
                echo 0;
            }
            break;
        case "ACTUALIZAR":            
            try{
                $duplicado = $objPro->consultarProductoNombre($_POST['nombre'],$_POST['codigobarra'], $_POST['idproducto']);
                if($duplicado->rowCount()==0){
                    $producto= array(
                        "idproducto"    =>$_POST['idproducto'],
                        "nombre"        =>$_POST['nombre'], 
                        "codigobarra"   =>$_POST['codigobarra'], 
                        "pventa"        =>$_POST['pventa'], 
                        "pcompra"       =>$_POST['pcompra'],  
                        "stock"         =>$_POST['stock'], 
                        "idunidad"      =>$_POST['idunidad'], 
                        "idcategoria"   =>$_POST['idcategoria'], 
                        "idafectacion"  =>$_POST['idafectacion'], 
                        "afectoicbper"  =>$_POST['afectoicbper'], 
                        "estado"        =>$_POST['estado'],
                        "stockseguridad"=>$_POST['stockseguridad']                                                    
                    ); 
                    $resultado = $objPro->actualizar($producto);
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
                $resultado = $objPro->actualizarEstado($_POST['idproducto'],2);
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break;
        case "ANULAR":
            try{
                $resultado = $objPro->actualizarEstado($_POST['idproducto'],0);
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break;
        case "ACTIVAR":
            try{
                $resultado = $objPro->actualizarEstado($_POST['idproducto'],1);
                echo 1;
            }catch(Exception $ex){
                echo 0;
            }
            break; 
        case "ACTUALIZAR_IMAGEN":
                try{
                    if(empty($_FILES)){
                        throw new Exception("No se encontraron archivos para cargar.", 123);
                    }
                    
                    $archivo = $_FILES['uploadFile'];
                    $ruta = "imagenes/productos/IMG_".$_POST['idproducto']."_".$archivo["name"];

                    move_uploaded_file($archivo["tmp_name"], "../".$ruta);

                    $resultado = $objPro->actualizarUrlimagen($_POST['idproducto'],$ruta);
                    echo '[]';
                }catch(Exception $ex){
                    echo $ex->getMessage();
                }
            break;              
        case "CONSULTAR":
            $retorno = array();
            try{
                $resultado = $objPro->consultarProducto($_POST['idproducto']);
                if($resultado->rowCount()>0){
                    $retorno = $resultado->fetch(PDO::FETCH_NAMED);
                }
            }catch(Exception $ex){
                $retorno = array();
            }
            echo json_encode($retorno);
            break; 
        case "DETALLE_INVENTARIO":
            try{
                $idproducto = $_POST['idproducto'];
                $desde = "";
                $hasta = "";
                $movimientos = $objVen->listarVentasPorProducto($idproducto, $desde, $hasta);

                $tabla = "<table class='table table-sm table-hover table-bordered text-sm' id='tabla_detalle_movimiento'>";
                $tabla .= "<thead><tr>
                        <th>Fecha</th>
                        <th>Documento</th>
                        <th>Cliente</th>
                        <th class='bg-olive'>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>    
                        </tr></thead>";
                $tabla.= "<tbody>";
                $cantidad_total = 0;
                foreach($movimientos as $k=>$v){
                    $tabla.="<tr>
                    <td>".$v['fecha']."</td>
                    <td>".$v['comprobante']." ".$v['serie']."-".$v['correlativo']."</td>
                    <td>".$v['cliente']."</td>
                    <td class='bg-olive'>".$v['cantidad']."</td>
                    <td>".$v['pventa']."</td>
                    <td>".$v['total']."</td>    
                    </tr>";
                    $cantidad_total += $v['cantidad']; 
                }
                $tabla.= "</tbody>";
                $tabla .= "</table>";
                $tabla .= "<div align='center'><h4>CANTIDAD TOTAL VENDIDA: ".$cantidad_total."</h4></div>";
                echo $tabla;
            }catch(Exception $ex){
                echo $ex->getMessage();
            }
            break;
        default:
            echo "No se ha definido proceso";
            break;                                  
    }

}

?>