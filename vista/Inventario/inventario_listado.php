<?php 
include_once("../../modelo/Producto.php");
$objPro = new Producto();
$filtro = $_POST['filtro'];
$estado = $_POST['estado'];
$listado = $objPro->listar("%".$filtro."%","",$estado);
?>
<table id="tablaProducto" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th class="bg-maroon">Stock</th>
            <th class="bg-yellow">Seguridad</th>
            <th>Estado</th>
            <th>Edit</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($listado as $k=>$v){ 
            $bgclasstr = $v['estado']==0?"text-danger":"";
            $bgclass_seg = ($v['stock']>=$v['stockseguridad'])?"text-green":"text-red";
            ?>
            <tr class="<?= $bgclasstr ?>">
                <td><?= $v['idproducto'] ?></td>
                <td><?= $v['nombre'] ?></td>
                <td class="bg-maroon"><?= $v['stock'] ?></td>
                <td class="bg-yellow"><?= $v['stockseguridad'] ?></td>
                <td><span class="fas fa-circle <?= $bgclass_seg; ?>"></span></td>
                <td><button onclick="VerMovimientos(<?= $v['idproducto'] ?>)" class="btn bg-info btn-sm">Movimiento</button></td>
            </tr>
        <?php }?>
    </tbody>
</table>
<script>
$('#tablaProducto').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "order":[[1,'asc']],
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#tablaProducto_wrapper .col-md-6:eq(0)');

function VerMovimientos(idproducto){
    $.ajax({
        method: "POST",
        url: "controlador/contProducto.php",
        data:{
            'proceso': "DETALLE_INVENTARIO",
            'idproducto': idproducto
        }
    }).done(function(resultado){
        $("#detalle_inventario").html(resultado);
        $("#modalProducto").modal('show');
        $('#tabla_detalle_movimiento').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "order":[],
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "buttons": ["copy", "csv", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#tabla_detalle_movimiento_wrapper .col-md-6:eq(0)');
    });
}
</script>