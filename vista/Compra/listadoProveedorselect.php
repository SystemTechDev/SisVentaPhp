<?php 
require_once("../../modelo/clsProveedor.php");
$nombre = $_GET['nombre'];
$nombre="%".str_replace(' ','%',$nombre)."%";
$objproveedor = new clsProveedor();
$data = $objproveedor->consultar($nombre);
if ($data->rowCount() > 0) {
?>
<table class="table table-bordered table-hover ">
	<thead>
		<tr>
			<th>#</th>
			<th>Nombres y Apellidos / Razon Social</th>
			<th>DNI / RUC</th>
			<th>Direccion</th>
			<th>Telefono</th>
			<th colspan="3">Operaciones</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$i=0;  
			//for ($i=0; $i < count($lista) ; $i++) { 
			while($dato = $data->fetch(PDO::FETCH_NAMED)){ 
				$class=""; $nombre = ''; $nrodocumento = ''; $tipodoc = '';
				if($dato['estado']=='A'){
					$class="text-red";
				}
				if ($dato['tipopersona']=='P') {
					$nombre = $dato['nombres'].' '.$dato['apellidos'];
					$nrodocumento = $dato['dni'];
					$tipodoc = 'DNI';
				}elseif ($dato['tipopersona']=='E') {
					$nombre = $dato['razon_social'];
					$nrodocumento = $dato['ruc'];
					$tipodoc = 'RUC';
				}
		?>
			<tr class="<?php echo $class;?>">
				<td><?php echo ($i+1); ?></td>
				<td><?php echo $nombre; ?></td>
				<td><?php echo $nrodocumento; ?></td>
				<td><?php echo $dato['direccion']; ?></td>
				<td><?php echo $dato['telefono']; ?></td>
				<td><button type="button" class="btn btn-primary btn-xs" onclick="seleccionarProveedor(<?php echo $dato['id']; ?>,'<?php echo $nombre; ?>','<?php echo $tipodoc; ?>','<?php echo $nrodocumento; ?>','<?php echo $dato['direccion']; ?>');">Seleccionar</button></td>
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