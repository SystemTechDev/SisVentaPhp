<?php 
include_once("../../modelo/Unidad.php");
$objUnidad = new Unidad();
$filtro = $_POST['filtro'];
$estado = $_POST['estado'];
$listado = $objUnidad->listar("%".$filtro."%",$estado);
?>
<table id="tablaUnidad" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Unidad Medida</th>
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
                <td><?= $v['idunidad'] ?></td>
                <td><?= $v['descripcion'] ?></td>
                <td><?= $v['estado']==1?"ACTIVO":"INACTIVO"; ?></td>
                <td>
             <!--   <button onclick="EditarUnidad(<?= $v['idunidad'] ?>)" class="btn bg-info btn-sm">Editar</button> -->
                <button onclick="EditarUnidad(<?= "'".$v['idunidad']."'" ?>)" class="btn bg-info btn-sm">Editar</button>
                </td>
                <td><button onclick="CambiarEstadoUnidad(<?= "'".$v['idunidad']."'" ?>,<?= $estado ?>,'<?= $v['descripcion'] ?>')" class="btn <?= $bgclass ?> btn-sm"><?= $texto ?></button></td>
                <td><button onclick="CambiarEstadoUnidad(<?= "'".$v['idunidad']."'" ?>,2,'<?= $v['descripcion'] ?>')" class="btn bg-danger btn-sm">Eliminar</button></td>
            </tr>
        <?php }?>
    </tbody>
</table>
<script>
$('#tablaUnidad').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#tablaUnidad_wrapper .col-md-6:eq(0)');

function EditarUnidad(idunidad){
    //01) primero obtengo los datos de la categoria
    $.ajax({
        method: "POST",
        url: "controlador/contUnidad.php",
        data:{
            'proceso': "CONSULTAR",
            'idunidad': idunidad
        },
        dataType: "json"
    }).done(function(resultado){
        //02) completo el formulario con los datos de la cateogoría
        $("#nombre").val(resultado.descripcion);
        $("#estado").val(resultado.estado);
        $("#idunidad").val(resultado.idunidad);
        $("#id").val(resultado.idunidad);
        //03) muestro el modal
        $("#modalUnidad").modal('show');
    });
}

function CambiarEstadoUnidad(idunidad, estado, nombre){
    proceso = estado==0?"ANULAR":(estado==1?"ACTIVAR":"ELIMINAR");
    mensaje = "¿Esta seguro de <b>"+proceso+"</B> Unidad <b>"+nombre+"</b>?";
    accion = "EjecutarCambiarEstadoUnidad('"+idunidad+"','"+proceso+"')";
    mostrarModalConfirmacion(mensaje, accion);
}

function EjecutarCambiarEstadoUnidad(idunidad,proceso){    
    $.ajax({
        method: "POST",
        url: "controlador/contUnidad.php",
        data: {
            'proceso': proceso,
            'idunidad': idunidad
        }
    }).done(function(resultado){
        if(resultado==1){
            toastCorrecto("Cambio de estado satisfactorio.");
            listarUnidad();
        }else{
            toastError("Problemas en la actualización de estado. Inténtelo nuevamente.");
        }
    });
}
</script>