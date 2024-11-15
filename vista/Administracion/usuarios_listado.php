<?php 
include_once("../../modelo/Usuario.php");
$objUsu = new Usuario();
$filtro = $_POST['filtro'];
$estado = $_POST['estado'];
$listado = $objUsu->listar("%".$filtro."%",$estado);
?>
<table id="tablaUsuario" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Usuario</th>
            <th>Perfil</th>
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
                <td><?= $v['idusuario'] ?></td>
                <td><?= $v['nombre'] ?></td>
                <td><?= $v['usuario'] ?></td>
                <td><?= $v['perfil'] ?></td>
                <td><?= $v['estado']==1?"ACTIVO":"INACTIVO"; ?></td>
                <td><button onclick="EditarUsuario(<?= $v['idusuario'] ?>)" class="btn bg-info btn-sm">Editar</button></td>
                <td><button onclick="CambiarEstadoUsuario(<?= $v['idusuario'] ?>,<?= $estado ?>,'<?= $v['nombre'] ?>')" class="btn <?= $bgclass ?> btn-sm"><?= $texto ?></button></td>
                <td><button onclick="CambiarEstadoUsuario(<?= $v['idusuario'] ?>,2,'<?= $v['nombre'] ?>')" class="btn bg-danger btn-sm">Eliminar</button></td>
            </tr>
        <?php }?>
    </tbody>
</table>
<script>
$('#tablaUsuario').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "order":[[1,'asc']],
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#tablaUsuario_wrapper .col-md-6:eq(0)');

function EditarUsuario(idusuario){
    $.ajax({
        method: "POST",
        url: "controlador/contUsuario.php",
        data:{
            'proceso': "CONSULTAR",
            'idusuario': idusuario
        },
        dataType: "json"
    }).done(function(resultado){
        $("#nombre").val(resultado.nombre);
        $("#usuario").val(resultado.usuario);
        $("#idperfil").val(resultado.idperfil);
        $("#estado").val(resultado.estado);
        $("#idusuario").val(resultado.idusuario);
        $("#modalUsuario").modal('show');
    });
}

function CambiarEstadoUsuario(idusuario, estado, nombre){
    proceso = estado==0?"ANULAR":(estado==1?"ACTIVAR":"ELIMINAR");
    mensaje = "¿Esta seguro de <b>"+proceso+"</B> usuario <b>"+nombre+"</b>?";
    accion = "EjecutarCambiarEstadoUsuario("+idusuario+",'"+proceso+"')";
    mostrarModalConfirmacion(mensaje, accion);
}

function EjecutarCambiarEstadoUsuario(idusuario,proceso){    
    $.ajax({
        method: "POST",
        url: "controlador/contUsuario.php",
        data: {
            'proceso': proceso,
            'idusuario': idusuario
        }
    }).done(function(resultado){
        if(resultado==1){
            toastCorrecto("Cambio de estado satisfactorio.");
            listarUsuarios();
        }else{
            toastError("Problemas en la actualización de estado. Inténtelo nuevamente.");
        }
    });
}
</script>