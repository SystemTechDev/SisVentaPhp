<?php 
require_once("../modelo/clsCompra.php");
require_once("../modelo/Producto.php");
$accion = '';
if (isset($_POST['accion'])) {
	$accion = $_POST['accion'];
}
$objcompra = new clsCompra();
$objproducto = new Producto();

switch ($accion) {
	case 'REGISTRAR':
		try{
			$correlativo = $objcompra->obtenerCorrelativo($_POST['idtipocomprobante'],$_POST['serie']);

			$fechaingreso = $_POST['fechaingreso'];
			$idtipocomprobante = $_POST['idtipocomprobante'];
			$serie = $_POST['serie'];
			$correlativo = $_POST['correlativo'];

			$fechaemision = $_POST['fechaemision'];
			$fechaemision = date('Y-m-d',strtotime($fechaemision));
			$tipocomprobantecompra = $_POST['tipocomprobantecompra'];
			$seriecomprobantecompra = $_POST['seriecomprobantecompra'];
			$numerodocumentocompra = $_POST['numerodocumentocompra'];
			$formapagocompra = $_POST['formapagocompra'];

			$persona_id = $_POST['persona_id'];

			$subtotal = $_POST['subtotal'];
			$igv = $_POST['igv'];
			$total = $_POST['total'];

			$objcompra->insertar($fechaingreso,$serie,$correlativo,$fechaemision,$tipocomprobantecompra,$seriecomprobantecompra,$numerodocumentocompra,$formapagocompra,$persona_id,$subtotal,$igv,$total,$idtipocomprobante);
			$objcompra->actualizarCorrelativo($_POST['idtipocomprobante'], $_POST['serie'], $correlativo);
			$data = $objcompra->consultarUltimoIdMovimiento();
			$dato = $data->fetch(PDO::FETCH_NAMED);
			$movimiento_id = $dato['id'];
			$lista = $_SESSION['carritocompra'];
			for ($i=0; $i < count($lista) ; $i++) {  
				$objcompra->insertardetalle($lista[$i]['cantidad'],$lista[$i]['preciocompra'],$lista[$i]['subtotal'],$lista[$i]['producto_id'],$movimiento_id);
			
              
                        
				$data = $objcompra->consultarUltimoIdDetallemovimiento();
				$dato = $data->fetch(PDO::FETCH_NAMED);
				$detallemovimiento_id = $dato['id'];
				$stockactual = 0; $stockanterior = 0;
				// consulta del ultimo stock, que seria el stock anterior
				$datastock = $objproducto->consultarStockProductoById($lista[$i]['producto_id']);
				$datostock = $datastock->fetch(PDO::FETCH_NAMED);
				if ($datostock['stockactual'] ?? null) {
					$stockanterior = $datostock['stockactual'];
				}
				// calculamos el nuevo stock
				$stockactual = $stockanterior+$lista[$i]['cantidad'];
				$objproducto->actualizarStock_precio($lista[$i]['producto_id'],$lista[$i]['preciocompra'],$lista[$i]['cantidad']);

				$objcompra->insertarkardex($fechaingreso,'I',$lista[$i]['cantidad'],$stockanterior,$stockactual,$lista[$i]['producto_id'],$detallemovimiento_id);
			}
			echo "OK";
		}catch(Exception $e){
			echo 'No se pudieron Registar los datos'.$e;
		}
		break;
	case 'AGREGAR_CARRITO':
		try{
			$producto_id = $_POST['producto_id'];
			$preciocompra = $_POST['preciocompra'];
			$cantidad = $_POST['cantidad'];
			$nombreproducto = $_POST['nombreproducto'];
			$total = 0;
			$lista = array();
			// verificamos la existencia del carrito
			if (isset($_SESSION['carritocompra'])) {
				$lista = $_SESSION['carritocompra'];
			}
			// verificar si en el carrito existe el producto seleccionado
			$posicion = -1;
			for ($i=0; $i < count($lista) ; $i++) { 
				if ($lista[$i]['producto_id'] == $producto_id) {
					$posicion = $i;
					break;
				}
			}
			//echo $posicion;
			if ($posicion >= 0) {
				$subtotal = $preciocompra*$cantidad;
				$lista[$posicion] = array('producto_id'=>$producto_id,'preciocompra'=>$preciocompra,'cantidad'=>$cantidad,'nombreproducto'=>$nombreproducto,'subtotal'=>$subtotal);
			}else{
				$subtotal = $preciocompra*$cantidad;
				$lista[] = array('producto_id'=>$producto_id,'preciocompra'=>$preciocompra,'cantidad'=>$cantidad,'nombreproducto'=>$nombreproducto,'subtotal'=>$subtotal);
			}
			$_SESSION['carritocompra'] = $lista;
			$texto = '<table style="width: 100%;" class="table-condensed table-striped table-bordered">';
			$texto .= '<thead>
		                <tr>
		                    <th class="text-center">Producto</th>
		                    <th class="text-center">Cantidad</th>
		                    <th class="text-center">Precio</th>
		                    <th class="text-center">Subtotal</th>
		                    <th class="text-center">Quitar</th>                            
		                </tr>
		            </thead>';
		    for ($i=0; $i < count($lista) ; $i++) { 
		    	$texto .= '<tr>';
		    	$texto .= '<td class="text-center">'.$lista[$i]['nombreproducto'].'</td>';
		    	$texto .= '<td class="text-center">'.$lista[$i]['cantidad'].'</td>';
		    	$texto .= '<td class="text-center">'.$lista[$i]['preciocompra'].'</td>';
		    	$texto .= '<td class="text-center">'.$lista[$i]['subtotal'].'</td>';
		    	$texto .= '<td class="text-center"><button type="button" class="btn btn-danger" onclick="quitarProducto('.$lista[$i]['producto_id'].');">Quitar</button></td>';
		    	
		    	$subtotall=0;
		    	$igv=0;
		    	$total = $total+$lista[$i]['subtotal'];
		    	$igv=$total*0.18;
		    	$subtotall=$total-$igv;
		    }
			$texto .= '</table>';
			$data = array("igv"=>$igv,"subtotall"=>$subtotall,"total"=>$total,"lista"=>$texto);
			echo json_encode($data);
		}catch(Exception $e){
			echo 'No se pudieron Registar los datos'.$e;
		}
		break;

	case 'QUITAR_CARRITO':
		try{
			$producto_id = $_POST['producto_id'];
			$total = 0;
			$lista = array();
			$listaAnterior = array();
			// verificamos la existencia del carrito
			if (isset($_SESSION['carritocompra'])) {
				$listaAnterior = $_SESSION['carritocompra'];
			}
			// generar el nuevo array sin el elemento
			for ($i=0; $i < count($listaAnterior) ; $i++) { 
				if ($listaAnterior[$i]['producto_id'] != $producto_id) {
					$lista[] = array('producto_id'=>$listaAnterior[$i]['producto_id'],'preciocompra'=>$listaAnterior[$i]['preciocompra'],'cantidad'=>$listaAnterior[$i]['cantidad'],'nombreproducto'=>$listaAnterior[$i]['nombreproducto'],'subtotal'=>$listaAnterior[$i]['subtotal']);
				}
			}

			$_SESSION['carritocompra'] = $lista;
			$texto = '<table style="width: 100%;" class="table-condensed table-striped table-bordered">';
			$texto .= '<thead>
		                <tr>
		                    <th class="text-center">Producto</th>
		                    <th class="text-center">Cantidad</th>
		                    <th class="text-center">Precio</th>
		                    <th class="text-center">Subtotal</th>
		                    <th class="text-center">Quitar</th>                            
		                </tr>
		            </thead>';
		    for ($i=0; $i < count($lista) ; $i++) { 
		    	$texto .= '<tr>';
		    	$texto .= '<td class="text-center">'.$lista[$i]['nombreproducto'].'</td>';
		    	$texto .= '<td class="text-center">'.$lista[$i]['cantidad'].'</td>';
		    	$texto .= '<td class="text-center">'.$lista[$i]['preciocompra'].'</td>';
		    	$texto .= '<td class="text-center">'.number_format($lista[$i]['subtotal'],4).'</td>';
		    	$texto .= '<td class="text-center"><button type="button" class="btn btn-danger" onclick="quitarProducto('.$lista[$i]['producto_id'].');">Quitar</button></td>';
		    	$total = $total+$lista[$i]['subtotal'];
		    }
			$texto .= '</table>';
			$data = array("total"=>$total,"lista"=>$texto);
			echo json_encode($data);
		}catch(Exception $e){
			echo 'No se pudieron Registar los datos'.$e;
		}
		break;
		case "SERIES": 
            $retorno = array();
            try{
                $resultado = $objcompra->consultarSeries($_POST['idtipocomprobante']);
                $retorno = $resultado->fetchAll(PDO::FETCH_NAMED);            
            }catch(Exception $ex){
                $retorno = array();
            }
            echo json_encode($retorno);
            break; 
		case "OBTENER_CORRELATIVO":
            try{
                $correlativo = $objcompra->obtenerCorrelativo($_POST['idtipocomprobante'],$_POST['serie']);
                echo $correlativo;
            }catch(Exception $ex){
                echo 0;
            }
            break;
	
	default:
		echo '*** NO SE ESPECIFICO ACCION';
		break;
}
?>