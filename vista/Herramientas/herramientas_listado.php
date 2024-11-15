<?php 
include_once("../../modelo/Herramienta.php");
$objHerramienta = new Herramienta();
$filtro = $_POST['filtro'];
$estado = $_POST['estado'];
$listado = $objHerramienta->listar("%".$filtro."%",$estado);
?>
<table id="tablaHerramienta" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Cantidad</th>
            <th>Descripcion</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>NºSerie</th>
            <th>Color</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($listado as $k=>$v){

            $bgclass = $v['estado']==1?"bg-maroon":"bg-success";
            $texto = $v['estado']==1?"Anular":"Activar";
            $estado = $v['estado']==1?0:1;
            $iconi = $v['estado']==1?"fa-ban":"fa-check-circle";
            $bgclasstr = $v['estado']==0?"text-danger":"";
            ?>
            <tr class="<?= $bgclasstr ?>">
                <td><?= $v['idherramienta'] ?></td>
                <td><?= $v['nombre'] ?></td>
                <td><?= $v['cantidad'] ?></td>
                <td><?= $v['descripcion'] ?></td>
                <td><?= $v['marca'] ?></td>
                <td><?= $v['modelo'] ?></td>
                <td><?= $v['serie'] ?></td>
                <td><?= $v['color'] ?></td>
                <td ><span class="<?= $v['estado']==1?"badge badge-success":"badge badge-danger"; ?>"><?= $v['estado']==1?"Activo":"Inactivo"; ?></span></td>
                <td class="text-center">
                    <button onclick="EditarHerramienta(<?= $v['idherramienta'] ?>)" class="btn btn-info btn-sm" title="Editar Registro">
                        <i class="fas fa-edit" aria-hidden="true"></i>
                    </button>
                    <button onclick="CambiarEstadoHerramienta(<?= $v['idherramienta'] ?>,<?= $estado ?>,'<?= $v['nombre'] ?>')" class="btn <?= $bgclass ?> btn-sm" title="<?= $texto ?> Registro">
                    <i class="fas <?= $iconi ?>"></i>
                    </button>
                    <button onclick="CambiarEstadoHerramienta(<?= $v['idherramienta'] ?>,2,'<?= $v['nombre'] ?>')" class="btn bg-danger btn-sm" title="Eliminar Registro">
                        <i class="far fa-trash-alt" aria-hidden="true"></i>
                    </button>
                </td>
             
            </tr>
        <?php }?>
    </tbody>
</table>
<script>
$('#tablaHerramienta').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": false,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#tabla_wrapper .col-md-6:eq(0)');

function EditarHerramienta(idherramienta){
    $.ajax({
        method: "POST",
        url: "controlador/contHerramienta.php",
        data:{
            'proceso': "CONSULTAR",
            'idherramienta': idherramienta
        },
        dataType: "json"
    }).done(function(resultado){
        $("#nombre").val(resultado.nombre);
        $("#marca").val(resultado.marca);
        $("#cantidad").val(resultado.cantidad);
        $("#modelo").val(resultado.modelo);
        $("#serie").val(resultado.serie);
        $("#descripcion").val(resultado.descripcion);
        $("#color").val(resultado.color);
        $("#estado").val(resultado.estado);
        $("#idherramienta").val(resultado.idherramienta);
        $("#modalHerramienta").modal('show');
    });
}

function CambiarEstadoHerramienta(idherramienta, estado, nombre){
    proceso = estado==0?"ANULAR":(estado==1?"ACTIVAR":"ELIMINAR");
    mensaje = "¿Esta seguro de <b>"+proceso+"</B> al Herramienta <b>"+nombre+"</b>?";
    accion = "EjecutarCambiarEstadoHerramienta("+idherramienta+",'"+proceso+"')";
    mostrarModalConfirmacion(mensaje, accion);
}

function EjecutarCambiarEstadoHerramienta(idherramienta,proceso){    
    $.ajax({
        method: "POST",
        url: "controlador/contHerramienta.php",
        data: {
            'proceso': proceso,
            'idherramienta': idherramienta
        }
    }).done(function(resultado){
        if(resultado==1){
            SwalCorrecto("Cambio de estado satisfactorio.");
            listarHerramientas();
        }else{
            SwaltError("Problemas en la actualización de estado. Inténtelo nuevamente.");
        }
    });
}
</script>