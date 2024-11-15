<?php 
include_once("../../modelo/Personal.php");
$objClie = new Personal();
$filtro = $_POST['filtro'];
$estado = $_POST['estado'];
$listado = $objClie->listar("%".$filtro."%",$estado);
?>
<table id="tablaPersonal" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>N° Doc</th>
            <th>Dirección</th>
            <th>Estado</th>
            <th>Accion</th>
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
                <td><?= $v['idpersonal'] ?></td>
                <td><?= $v['nombres'] ?></td>
                <td><?= $v['ndocumento'] ?></td>
                <td><?= $v['direccion'] ?></td>
                <td><?= $v['estado']==1?"ACTIVO":"INACTIVO"; ?></td>
                <td>
                <button onclick="EditarPersonal(<?= $v['idpersonal'] ?>)" class="btn bg-info btn-sm">Editar</button>
                <button onclick="CambiarEstadoPersonal(<?= $v['idpersonal'] ?>,<?= $estado ?>,'<?= $v['nombres'] ?>')" class="btn <?= $bgclass ?> btn-sm"><?= $texto ?></button>
                <button onclick="CambiarEstadoPersonal(<?= $v['idpersonal'] ?>,2,'<?= $v['nombres'] ?>')" class="btn bg-danger btn-sm">Eliminar</button>
                </td>
            </tr>
        <?php }?>
    </tbody>
</table>
<script>
$('#tablaPersonal').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "order":[[1,'asc']],
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#tablaPersonal_wrapper .col-md-6:eq(0)');

function EditarPersonal(idpersonal){
    $.ajax({
        method: "POST",
        url: "controlador/contPersonal.php",
        data:{
            'proceso': "CONSULTAR",
            'idpersonal': idpersonal
        },
        dataType: "json"
    }).done(function(resultado){       
        $("#idtipodocumento").val(resultado.tipodocumento_id);
        $("#ndocumento").val(resultado.ndocumento);
        $("#nombres").val(resultado.nombres);
        $("#fechanac").val(resultado.fechan);
        $("#correo").val(resultado.correo);
        $("#cargoempresa").val(resultado.cargo);
        $("#celular").val(resultado.celular);
        $("#direccion").val(resultado.direccion);
        $("#sueldo").val(resultado.sueldo);
        $("#estado").val(resultado.estado);
        $("#idpersonal").val(resultado.idpersonal);
        $("#modalPersonal").modal('show');
    });
}

function CambiarEstadoPersonal(idpersonal, estado, nombres){
    proceso = estado==0?"ANULAR":(estado==1?"ACTIVAR":"ELIMINAR");
    mensaje = "¿Esta seguro de <b>"+proceso+"</B> al Personal <b>"+nombres+"</b>?";
    accion = "EjecutarCambiarEstadoPersonal("+idpersonal+",'"+proceso+"')";
    mostrarModalConfirmacion(mensaje, accion);
}

function EjecutarCambiarEstadoPersonal(idpersonal,proceso){    
    $.ajax({
        method: "POST",
        url: "controlador/contPersonal.php",
        data: {
            'proceso': proceso,
            'idpersonal': idpersonal
        }
    }).done(function(resultado){
        if(resultado==1){
            toastCorrecto("Cambio de estado satisfactorio.");
            listarPersonal();
        }else{
            toastError("Problemas en la actualización de estado. Inténtelo nuevamente.");
        }
    });
}
</script>