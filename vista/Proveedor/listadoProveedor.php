<?php 
include_once("../../modelo/clsProveedor.php");
$nombre = $_GET['nombre'];
$nombre="%".str_replace(' ','%',$nombre)."%";
$objproveedor = new clsProveedor();
$data = $objproveedor->consultar($nombre);
if ($data->rowCount() > 0) {
?>
<div class="table-responsive">
 <table class="table table-hover table-bordered" id="sampleTable">
	<thead>
		<tr>
			<th>#</th>
			<th>Nombres y Apellidos / Razon Social</th>
			<th>DNI / RUC</th>
			<th>Direccion</th>
			<th>Telefono</th>
			<th>Estado</th>
			<th >Operaciones</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$i=0;  
			//for ($i=0; $i < count($lista) ; $i++) { 
			while($dato = $data->fetch(PDO::FETCH_NAMED)){ 
				$class=""; $nombre = ''; $nrodocumento = '';
				$classestado="";
				$estado="";
				if($dato['estado']=='A'){
					$classestado="badge badge-danger";
					$estado="Inactivo";
				}else{
					$classestado="badge badge-success";
					$estado="Activo";
				}
				if ($dato['tipopersona']=='P') {
					$nombre = $dato['nombres'].' '.$dato['apellidos'];
					$nrodocumento = $dato['dni'];
				}elseif ($dato['tipopersona']=='E') {
					$nombre = $dato['razon_social'];
					$nrodocumento = $dato['ruc'];
				}
		?>
			<tr class="<?php echo $class;?>">
				<td><?php echo ($i+1); ?></td>
				<td><?php echo $nombre; ?></td>
				<td><?php echo $nrodocumento; ?></td>
				<td><?php echo $dato['direccion']; ?></td>
				<td><?php echo $dato['telefono']; ?></td>
				<td ><span class="<?php echo $classestado;?>"><?php echo $estado; ?></span></td>
				<td>
                 <div class="text-center">
	                <button class="btn btn-primary  btn-sm" onclick="editarProveedor(<?php echo $dato['id']; ?>);" title="Editar Proveedor"><i class="fas fa-pencil-alt" aria-hidden="true"></i></button>
	                        <?php if($dato['estado']=='A'){ ?> 
	                <button class="btn btn-warning btn-sm" onclick="cambiarEstadoProveedor(<?php echo $dato['id']; ?>,'N');" title="Activar Proveedor"><i class="fa-solid fa-ban"></i></button> 
	                        <?php }else{ ?>
	                <button class="btn btn-success btn-sm" onclick="cambiarEstadoProveedor(<?php echo $dato['id']; ?>,'A');" title="Anular Proveedor"><i class="fa-solid fa-toggle-on"></i></button>
	                        <?php } ?>
	                <button class="btn btn-danger btn-sm" onclick="cambiarEstadoProveedor(<?php echo $dato['id']; ?>,'E');" title="Eliminar Proveedor"><i class="far fa-trash-alt" aria-hidden="true"></i></button>
                 </div>
                </td> 
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