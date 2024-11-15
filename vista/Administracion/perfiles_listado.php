<?php 
include_once("../../modelo/Perfil.php");
$objPer = new Perfil();
$filtro = $_POST['filtro'];
$estado = $_POST['estado'];
$listado = $objPer->listar("%".$filtro."%",$estado);
?>
<table id="tablaPerfil" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Estado</th>
            <th>Permisos</th>
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
                <td><?= $v['idperfil'] ?></td>
                <td><?= $v['nombre'] ?></td>
                <td><?= $v['estado']==1?"ACTIVO":"INACTIVO"; ?></td>
                <td><button onclick="VerPermisosPerfil(<?= $v['idperfil'] ?>,'<?= $v['nombre'] ?>')" class="btn bg-navy btn-sm"><span class="fas fa-lock"></span></button></td>
                <td><button onclick="EditarPerfil(<?= $v['idperfil'] ?>)" class="btn bg-info btn-sm">Editar</button></td>
                <td><button onclick="CambiarEstadoPerfil(<?= $v['idperfil'] ?>,<?= $estado ?>,'<?= $v['nombre'] ?>')" class="btn <?= $bgclass ?> btn-sm"><?= $texto ?></button></td>
                <td><button onclick="CambiarEstadoPerfil(<?= $v['idperfil'] ?>,2,'<?= $v['nombre'] ?>')" class="btn bg-danger btn-sm">Eliminar</button></td>
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
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#tablaPerfil_wrapper .col-md-6:eq(0)');

function EditarPerfil(idperfil){
    $.ajax({
        method: "POST",
        url: "controlador/contPerfil.php",
        data:{
            'proceso': "CONSULTAR",
            'idperfil': idperfil
        },
        dataType: "json"
    }).done(function(resultado){
        $("#nombre").val(resultado.nombre);
        $("#estado").val(resultado.estado);
        $("#idperfil").val(resultado.idperfil);
        $("#modalPerfil").modal('show');
    });
}

function CambiarEstadoPerfil(idperfil, estado, nombre){
    proceso = estado==0?"ANULAR":(estado==1?"ACTIVAR":"ELIMINAR");
    mensaje = "¿Esta seguro de <b>"+proceso+"</B> el perfil <b>"+nombre+"</b>?";
    accion = "EjecutarCambiarEstadoPerfil("+idperfil+",'"+proceso+"')";
    mostrarModalConfirmacion(mensaje, accion);
}

function EjecutarCambiarEstadoPerfil(idperfil,proceso){    
    $.ajax({
        method: "POST",
        url: "controlador/contPerfil.php",
        data: {
            'proceso': proceso,
            'idperfil': idperfil
        }
    }).done(function(resultado){
        if(resultado==1){
            toastCorrecto("Cambio de estado satisfactorio.");
            listarPerfiles();
        }else{
            toastError("Problemas en la actualización de estado. Inténtelo nuevamente.");
        }
    });
}


function VerPermisosPerfil(idperfil,nombre){
    $("#frmAcceso").trigger('reset');
    $("#idperfilacceso").val(idperfil); 
    $("#spanNombrePerfil").html(nombre);

    $.ajax({
        method: "POST",
        url: "controlador/contPerfil.php",
        data:{
            'proceso': "CONSULTAR_ACCESO",
            'idperfil': idperfil
        },
        dataType: "json"
    }).done(function(resultado){
        if(resultado.length>0){
            for(i=0; i<resultado.length; i++){
                document.getElementById("cb"+resultado[i].idopcion).checked=true;
            }
        }          
        $("#modalAcceso").modal('show');
    });
}

function VerificarAcceso(idopcion){
    proceso = "ACTIVAR_ACCESO";
    if(!document.getElementById("cb"+idopcion).checked){
        proceso = "DESACTIVAR_ACCESO";
    }

    $.ajax({
        method : "POST",
        url: "controlador/contPerfil.php",
        data:{
                'proceso' : proceso,
                'idopcion': idopcion,
                'idperfil': $("#idperfilacceso").val()
            }
    }).done(function(resultado){
        if(resultado==1){
            toastCorrecto("Cambio de estado satisfactorio.");
        }else{
            toastError("Problemas en la actualización de estado. Inténtelo nuevamente.");
        }
    });
}
</script>