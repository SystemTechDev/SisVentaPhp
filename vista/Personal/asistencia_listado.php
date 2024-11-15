<?php
include_once("../../modelo/Asistencia.php");
$objPer = new Asistencia();
$nombre= $_POST['filtro'];
$fecha= $_POST['fecha'];
$listado = $objPer->listar2("%".$nombre."%", $fecha); 
?>
<table id="tablaAsistencia" class="table table-bordered table-hover">
    <thead>
        <tr class="text-center">
            <th>ID</th>
            <th>Trabajador</th>
            <th>Fecha</th>
            <th>Asistio</th>
            <th>Tiempo</th>
            <th>Justificacion</th>
            <th>Estado</th>
            <th>Aciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($listado as $k=>$v){ 
            $bgclass = $v['estado']==1?"bg-danger":"bg-success";
            $texto = $v['estado']==1?"Anular":"Activar";
            $estado = $v['estado']==1?0:1;
            $iconi = $v['estado']==1?"fa-window-close":"fa-check-circle";
            $bgclasstr = $v['estado']==0?"text-danger":"";
            ?>
            <tr class="<?= $bgclasstr ?> text-center">
                <td><?= $v['idasistencia'] ?></td>
                <td><?= $v['nombres'] ?></td>
                <td><?= $v['fecha'] ?></td>
                <td><?= $v['asistio'] ?></td>
                <td> <span class="<?= $v['tiempo']=="Completo"?"badge badge-success":"badge badge-warning"; ?>"><?= $v['tiempo'] ?></span>
                </td>
                <td><?= $v['justificacion'] ?></td>
                <td><?= $v['estado']==1?"Activo":"Inactivo"; ?></td>
           
                <td>
                    <button onclick="EditarAsistencia(<?= $v['idasistencia'] ?>)" class="btn btn-info btn-sm" title="Editar Registro">
                        <i class="fas fa-edit" aria-hidden="true"></i>
                    </button>
                    <button onclick="CambiarEstadoAsistencia(<?= $v['idasistencia'] ?>,<?= $estado ?>,'<?= $v['nombres'] ?>')" class="btn <?= $bgclass ?> btn-sm" title="<?= $texto ?> Registro">
                    <i class="fas <?= $iconi ?>"></i>
                    </button>
                 <!--<button onclick="CambiarEstadoAsistencia(<?= $v['idasistencia'] ?>,2,'<?= $v['nombres'] ?>')" class="btn bg-danger btn-sm" title="Eliminar Registro">
                        <i class="far fa-trash-alt" aria-hidden="true"></i>
                    </button> -->
                </td>
            </tr>
        <?php }?>
    </tbody>
</table>
<script>
$('#tablaAsistencia').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      
    }).buttons().container().appendTo('#tablaAsistencia_wrapper .col-md-6:eq(0)');

function EditarAsistencia(idasistencia){
    $.ajax({
        method: "POST",
        url: "controlador/contAsistencia.php",
        data:{
            'proceso': "CONSULTAR",
            'idasistencia': idasistencia
        },
        dataType: "json"
    }).done(function(resultado){
        $("#personal_id").val(resultado.personal_id);
        $("#fecha").val(resultado.fecha);
        $("#asistio").val(resultado.asistio);
        $("#tiempo").val(resultado.tiempo);
        $("#justificacion").val(resultado.justificacion);
        $("#estado").val(resultado.estado);
        $("#idasistencia").val(resultado.idasistencia);
        $("#modalAsistencia").modal('show');
    });
}

function CambiarEstadoAsistencia(idasistencia, estado, nombre){
    proceso = estado==0?"ANULAR":(estado==1?"ACTIVAR":"ELIMINAR");
    mensaje = "¿Esta seguro de <b>"+proceso+"</B> el Asistencia de <b>"+nombre+"</b>?";
    accion = "EjecutarCambiarEstadoAsistencia("+idasistencia+",'"+proceso+"')";
    mostrarModalConfirmacion(mensaje, accion);
}

function EjecutarCambiarEstadoAsistencia(idasistencia,proceso){    
    $.ajax({
        method: "POST",
        url: "controlador/contAsistencia.php",
        data: {
            'proceso': proceso,
            'idasistencia': idasistencia
        }
    }).done(function(resultado){
        if(resultado==1){
            toastCorrecto("Cambio de estado satisfactorio.");
            listarAsistencias();
        }else{
            toastError("Problemas en la actualización de estado. Inténtelo nuevamente.");
        }
    });
}
</script>