<?php 
include_once("../../modelo/Cliente.php");
$objClie = new Cliente();
$filtro = $_POST['filtro'];
$estado = $_POST['estado'];
$listado = $objClie->listar("%".$filtro."%",$estado);
?>
<table id="tablaCliente" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>N° Doc</th>
            <th>Dirección</th>
            <th>Estado</th>
            <th>Editar</th>
            <th>Anular</th>
            <th>Eliminar</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($listado as $k=>$v){ 
            $bgclass = $v['estado']==1?"bg-warning":"bg-success";
            $texto = $v['estado']==1?"Anular":"Activar";
            $estado = $v['estado']==1?0:1;

            $bgclasstr = $v['estado']==0?"text-danger":"";
            ?>
            <tr class="<?= $bgclasstr ?>">
                <td><?= $v['idcliente'] ?></td>
                <td><?= $v['nombre'] ?></td>
                <td><?= $v['nrodocumento'] ?></td>
                <td><?= $v['direccion'] ?></td>
                <td><?= $v['estado']==1?"ACTIVO":"INACTIVO"; ?></td>
                <td><button onclick="EditarCliente(<?= $v['idcliente'] ?>)" class="btn bg-info btn-sm">Editar</button></td>
                <td><button onclick="CambiarEstadoCliente(<?= $v['idcliente'] ?>,<?= $estado ?>,'<?= $v['nombre'] ?>')" class="btn <?= $bgclass ?> btn-sm"><?= $texto ?></button></td>
                <td><button onclick="CambiarEstadoCliente(<?= $v['idcliente'] ?>,2,'<?= $v['nombre'] ?>')" class="btn bg-danger btn-sm">Eliminar</button></td>
            </tr>
        <?php }?>
    </tbody>
</table>
<script>
$('#tablaCliente').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "order":[[1,'asc']],
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#tablaCliente_wrapper .col-md-6:eq(0)');

function EditarCliente(idcliente){
    $.ajax({
        method: "POST",
        url: "controlador/contCliente.php",
        data:{
            'proceso': "CONSULTAR",
            'idcliente': idcliente
        },
        dataType: "json"
    }).done(function(resultado){
        $("#nombre").val(resultado.nombre);
        $("#idtipodocumento").val(resultado.idtipodocumento);
        $("#nrodocumento").val(resultado.nrodocumento);
        $("#direccion").val(resultado.direccion);
        $("#estado").val(resultado.estado);
        $("#idcliente").val(resultado.idcliente);
        $("#modalCliente").modal('show');
    });
}

function CambiarEstadoCliente(idcliente, estado, nombre){
    proceso = estado==0?"ANULAR":(estado==1?"ACTIVAR":"ELIMINAR");
    mensaje = "¿Esta seguro de <b>"+proceso+"</B> al cliente <b>"+nombre+"</b>?";
    accion = "EjecutarCambiarEstadoCliente("+idcliente+",'"+proceso+"')";
    mostrarModalConfirmacion(mensaje, accion);
}

function EjecutarCambiarEstadoCliente(idcliente,proceso){    
    $.ajax({
        method: "POST",
        url: "controlador/contCliente.php",
        data: {
            'proceso': proceso,
            'idcliente': idcliente
        }
    }).done(function(resultado){
        if(resultado==1){
            toastCorrecto("Cambio de estado satisfactorio.");
            listarCliente();
        }else{
            toastError("Problemas en la actualización de estado. Inténtelo nuevamente.");
        }
    });
}
</script>