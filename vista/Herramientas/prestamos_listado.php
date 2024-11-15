<?php
include_once("../../modelo/Prestamo.php");
$objPer = new Prestamo();
$nombre= $_POST['filtro'];
$fecha= $_POST['fecha'];
$listado = $objPer->listar2("%".$nombre."%", $fecha); 
?>
<table id="tablaPrestamo" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Trabajador</th>
            <th>Cant</th>
            <th>Material</th>
            <th>F.H Entrega</th>
            <th>Estado</th>
            <th>Fecha Dev</th>
            <th>Accion</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($listado as $k=>$v){ 
            $bgclass = $v['estado']==1?"bg-maroon":"bg-success";
            $texto = $v['estado']==1?"Anular":"Activar";
            $estado = $v['estado']==1?0:1;
            $iconi = $v['estado']==1?"fa-window-close":"fa-check-circle";
            $bgclasstr = $v['estado']==0?"text-danger":"";
            ?>
            <tr class="<?= $bgclasstr ?>">
                <td><?= $v['idprestamo'] ?></td>
                <td><?= $v['nombres'] ?></td>
                <td><?= $v['cantidad'] ?></td>
                <td><?= $v['nombre'] ?></td>
                <td><?= $v['fechaentrega'] ?></td>
                <td >
                    <span class="<?= $v['estadoprestamo']=="Devuelto"?"badge badge-success":"badge badge-danger"; ?>"><?= $v['estadoprestamo'] ?></span>
                    <button onclick="ActualizarDevolucion(<?= $v['idprestamo'] ?>)" class="btn btn-warning btn-sm" title="Devolucion">
                        <i class="fas fa-reply" aria-hidden="true"></i></button>
                </td>
                <td><?= $v['fechadevuelto'] ?></td>
                <td class="text-center">
                    <button onclick="EditarPrestamo(<?= $v['idprestamo'] ?>)" class="btn btn-info btn-sm" title="Editar Registro">
                        <i class="fas fa-edit" aria-hidden="true"></i>
                    </button>
                    <button onclick="CambiarEstadoPrestamo(<?= $v['idprestamo'] ?>,<?= $estado ?>,'<?= $v['nombres'] ?>')" class="btn <?= $bgclass ?> btn-sm" title="<?= $texto ?> Registro">
                    <i class="fas <?= $iconi ?>"></i>
                    </button>
                 <!--<button onclick="CambiarEstadoHerramienta(<?= $v['idprestamo'] ?>,2,'<?= $v['nombres'] ?>')" class="btn bg-danger btn-sm" title="Eliminar Registro">
                        <i class="far fa-trash-alt" aria-hidden="true"></i>
                    </button> -->
                </td>
            </tr>
        <?php }?>
    </tbody>
</table>
<script>
$('#tablaPrestamo').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      
    }).buttons().container().appendTo('#tablaPrestamo_wrapper .col-md-6:eq(0)');

function ActualizarDevolucion(idprestamo){
    $.ajax({
        method: "POST",
        url: "controlador/contPrestamo.php",
        data:{
            'proceso': "CONSULTAR",
            'idprestamo': idprestamo
        },
        dataType: "json"
    }).done(function(resultado){
        $("#fechadevuelto").val(resultado.fechadevuelto);
        $("#estadoprestamo").val(resultado.estadoprestamo);
        $("#observacion_devolucion").val(resultado.observaciondev);
        $("#idprestamodev").val(resultado.idprestamo);
        $("#modalPrestamoDevolucion").modal('show');
    });
}

function EditarPrestamo(idprestamo){
    $.ajax({
        method: "POST",
        url: "controlador/contPrestamo.php",
        data:{
            'proceso': "CONSULTAR",
            'idprestamo': idprestamo
        },
        dataType: "json"
    }).done(function(resultado){
        $("#personal_id").val(resultado.personal_id);
        $("#herramienta_id").val(resultado.herramienta_id);
        $("#fechaentrega").val(resultado.fechaentrega);
        $("#fechadevolucion").val(resultado.fechadevolucion);
        $("#cantidad").val(resultado.cantidad);
        $("#estado").val(resultado.estado);
        $("#observacion_entrega").val(resultado.observacion);
        $("#idprestamo").val(resultado.idprestamo);
        $("#modalPrestamo").modal('show');
        $('.select2bs4').select2({
        theme: 'bootstrap4'
        })
    });
}

function CambiarEstadoPrestamo(idprestamo, estado, nombre){
    proceso = estado==0?"ANULAR":(estado==1?"ACTIVAR":"ELIMINAR");
    mensaje = "¿Esta seguro de <b>"+proceso+"</B> el Prestamo de <b>"+nombre+"</b>?";
    accion = "EjecutarCambiarEstadoPrestamo("+idprestamo+",'"+proceso+"')";
    mostrarModalConfirmacion(mensaje, accion);
}

function EjecutarCambiarEstadoPrestamo(idprestamo,proceso){    
    $.ajax({
        method: "POST",
        url: "controlador/contPrestamo.php",
        data: {
            'proceso': proceso,
            'idprestamo': idprestamo
        }
    }).done(function(resultado){
        if(resultado==1){
            SwalCorrecto("Cambio de estado satisfactorio.");
            listarPrestamos();
        }else{
            SwalError("Problemas en la actualización de estado. Inténtelo nuevamente.");
        }
    });
}

</script>