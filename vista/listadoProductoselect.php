<?php 
require_once("../modelo/Producto.php");
$nombre = $_GET['nombre'];
$categoriaproducto_id = $_GET['categoriaproducto_id'];
$objproducto = new Producto();
$data = $objproducto->listar("","");
if ($data->rowCount() > 0) {
?>
<table class="table table-bordered table-hover ">
	<thead>
		<tr>
			<th>#</th>
			<th>Categoria</th>
			<th>Nombre</th>
			<th>Precio Compra</th>
			<th>Cantidad</th>
			<th>Stock</th>
			<th>Stock Minimo</th>
			<th>Operaciones</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$i=0;  
			//for ($i=0; $i < count($lista) ; $i++) { 
			while($dato = $data->fetch(PDO::FETCH_NAMED)){ 
				$class=""; $stockactual = 0;
				if($dato['estado']=='A'){
					$class="text-red";
				}
				$datastock = $objproducto->consultarStockProductoById($dato['idproducto']);
				$datostock = $datastock->fetch(PDO::FETCH_NAMED);
				if ($datostock['stock'] ?? null) {
					$stockactual = $datostock['stock'];
				}
		?>
			<tr class="<?php echo $class;?>">
				<td><?php echo ($i+1); ?><input type="hidden" name="id<?php echo $i; ?>" id="id<?php echo $i; ?>" value="<?php echo $dato['id']; ?>"></td>
				<td><?php echo $dato['nombrecategoria']; ?></td>
				<td><?php echo $dato['nombre']; ?><input type="hidden" name="nombre<?php echo $i; ?>" id="nombreproducto<?php echo $i; ?>" value="<?php echo $dato['nombre']; ?>"></td>
				<td><input type="text" name="pcompra<?php echo $i; ?>" id="pcompra<?php echo $i; ?>" value="<?php echo $dato['pcompra']; ?>" size="3"></td>
				<td><input type="text" name="cantidad<?php echo $i; ?>" id="cantidad<?php echo $i; ?>" size="2"></td>
				<td><?php echo $stockactual; ?></td>
				<td><?php echo $dato['stock']; ?></td>
				<td><button type="button" class="btn btn-primary btn-xs" onclick="seleccionarProducto(<?php echo $i; ?>);">Seleccionar</button></td>
			</tr>
		<?php	
			$i++;	
			}
		?>
	</tbody>
</table>
<?php 
}else{
?>
<h3 class="text-center text-warning">NO SE ENCONTRARON REGISTROS</h3>
<?php	
}
?>