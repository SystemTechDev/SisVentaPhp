<?php 
require_once('../../modelo/clsCompra.php');
$nombre = $_GET['nombre'];
$nombre="%".str_replace(' ','%',$nombre)."%";
$objcompra = new clsCompra();
$data = $objcompra->consultar($nombre);
if ($data->rowCount() > 0) {
?> 
<div class="table-responsive">
 <table class="table table-hover table-bordered" id="sampleTable">
	<thead>
		<tr>
			<th>#</th>
			<th>Fecha Ing</th>
			<th>Nº Registro</th>
			<th>Comprobante</th>
			<th>Proveedor</th>
			<th>SubT</th>
			<th>IGV</th>
			<th>Total</th>
			<th colspan="3">Accion</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$i=0;  
			//for ($i=0; $i < count($lista) ; $i++) { 
			while($dato = $data->fetch(PDO::FETCH_NAMED)){ 
				$class="";$proveedor = '';
				if($dato['estado']=='A'){
					$class="text-red";
				}
				if ($dato['tipopersona']=='P') {
					$proveedor = $dato['nombres'].' '.$dato['apellidos'];
				}elseif ($dato['tipopersona']=='E') {
					$proveedor = $dato['razon_social'];
				}
		?>
			<tr class="<?php echo $class;?>">
				<td><?php echo ($i+1); ?></td>
				<td><?php echo date('d/m/Y',strtotime($dato['fecha'])) ; ?></td>
				<td> <?php echo $dato['serie'].'-'.$dato['correlativo']; ?> </td>
				<td><?php echo $dato['comprobantecompra'].'-'.$dato['seriecomprobante'].'-'.$dato['numerodocumento']; ?></td>
				<td><?php echo $proveedor; ?></td>
				<td><?php echo $dato['subtotal']; ?></td>
				<td><?php echo $dato['igv']; ?></td>
				<td><?php echo $dato['total']; ?></td>
				<td><button class="btn btn-outline-dark">Imp</button></td>
			</tr>
		<?php	
			$i++;	
			}
		?>
	</tbody>
</table>
</div>
<?php 
}else{
?>
<h3 class="text-center text-warning">NO SE ENCONTRARON REGISTROS</h3>
<?php	
}
?>
<script type="text/javascript">$('#sampleTable').DataTable();</script>