<?php
include_once("../../modelo/Adelanto.php");
$objPer = new Adelanto();
$nombre= $_POST['filtro'];
$fecha= $_POST['fecha'];
$listado = $objPer->listar2("%".$nombre."%", $fecha); 
?>
<table id="tablaPerfil" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Trabajador</th>
            <th>Fecha</th>
            <th>Monto</th>
            <th>Estado</th>
            <th>Aciones</th>
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
                <td><?= $v['idadelanto'] ?></td>
                <td><?= $v['nombres'] ?></td>
                <td><?= $v['fecha'] ?></td>
                <td><?= $v['monto'] ?></td>
                <td><?= $v['estado']==1?"ACTIVO":"INACTIVO"; ?></td>
                <td>
                <button onclick="EditarAdelanto(<?= $v['idadelanto'] ?>)" class="btn bg-info btn-sm">Editar</button>
                <button onclick="CambiarEstadoAdelanto(<?= $v['idadelanto'] ?>,<?= $estado ?>,'<?= $v['nombres'] ?>')" class="btn <?= $bgclass ?> btn-sm"><?= $texto ?></button>
                <button onclick="CambiarEstadoAdelanto(<?= $v['idadelanto'] ?>,2,'<?= $v['nombres'] ?>')" class="btn bg-danger btn-sm">Eliminar</button>
                </td>
            </tr>
        <?php }?>
    </tbody>
</table>
<script>
$('#tablaPerfil').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "order":[[1,'asc']],
      "info": true,
      "autoWidth": false,
      "responsive": true,
      
    }).buttons().container().appendTo('#tablaPerfil_wrapper .col-md-6:eq(0)');

function EditarAdelanto(idadelanto){
    $.ajax({
        method: "POST",
        url: "controlador/contAdelanto.php",
        data:{
            'proceso': "CONSULTAR",
            'idadelanto': idadelanto
        },
        dataType: "json"
    }).done(function(resultado){
        $("#personal_id").val(resultado.personal_id);
        $("#fecha").val(resultado.fecha);
        $("#monto").val(resultado.monto);
        $("#estado").val(resultado.estado);
        $("#idadelanto").val(resultado.idadelanto);
        $("#modalAdelanto").modal('show');
    });
}

function CambiarEstadoAdelanto(idadelanto, estado, nombre){
    proceso = estado==0?"ANULAR":(estado==1?"ACTIVAR":"ELIMINAR");
    mensaje = "¿Esta seguro de <b>"+proceso+"</B> el Adelanto de <b>"+nombre+"</b>?";
    accion = "EjecutarCambiarEstadoAdelanto("+idadelanto+",'"+proceso+"')";
    mostrarModalConfirmacion(mensaje, accion);
}

function EjecutarCambiarEstadoAdelanto(idadelanto,proceso){    
    $.ajax({
        method: "POST",
        url: "controlador/contAdelanto.php",
        data: {
            'proceso': proceso,
            'idadelanto': idadelanto
        }
    }).done(function(resultado){
        if(resultado==1){
            toastCorrecto("Cambio de estado satisfactorio.");
            listarAdelantos();
        }else{
            toastError("Problemas en la actualización de estado. Inténtelo nuevamente.");
        }
    });
}

</script>