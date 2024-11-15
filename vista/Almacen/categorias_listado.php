<?php 
include_once("../../modelo/Categoria.php");
$objCat = new Categoria();
$filtro = $_POST['filtro'];
$estado = $_POST['estado'];
$listado = $objCat->listar("%".$filtro."%",$estado);
?>
<table id="tablaCategoria" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
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
                <td><?= $v['idcategoria'] ?></td>
                <td><?= $v['nombre'] ?></td>
                <td><?= $v['estado']==1?"ACTIVO":"INACTIVO"; ?></td>
                <td><button onclick="EditarCategoria(<?= $v['idcategoria'] ?>)" class="btn bg-info btn-sm">Editar</button></td>
                <td><button onclick="CambiarEstadoCategoria(<?= $v['idcategoria'] ?>,<?= $estado ?>,'<?= $v['nombre'] ?>')" class="btn <?= $bgclass ?> btn-sm"><?= $texto ?></button></td>
                <td><button onclick="CambiarEstadoCategoria(<?= $v['idcategoria'] ?>,2,'<?= $v['nombre'] ?>')" class="btn bg-danger btn-sm">Eliminar</button></td>
            </tr>
        <?php }?>
    </tbody>
</table>
<script>
$('#tablaCategoria').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "order":[[1,'asc']],
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#tablaCategoria_wrapper .col-md-6:eq(0)');

function EditarCategoria(idcategoria){
    //01) primero obtengo los datos de la categoria
    $.ajax({
        method: "POST",
        url: "controlador/contCategoria.php",
        data:{
            'proceso': "CONSULTAR",
            'idcategoria': idcategoria
        },
        dataType: "json"
    }).done(function(resultado){
        //02) completo el formulario con los datos de la cateogoría
        $("#nombre").val(resultado.nombre);
        $("#estado").val(resultado.estado);
        $("#idcategoria").val(resultado.idcategoria);
        //03) muestro el modal
        $("#modalCategoria").modal('show');
    });
}

function CambiarEstadoCategoria(idcategoria, estado, nombre){
    proceso = estado==0?"ANULAR":(estado==1?"ACTIVAR":"ELIMINAR");
    mensaje = "¿Esta seguro de <b>"+proceso+"</B> categoria <b>"+nombre+"</b>?";
    accion = "EjecutarCambiarEstadoCategoria("+idcategoria+",'"+proceso+"')";
    mostrarModalConfirmacion(mensaje, accion);
}

function EjecutarCambiarEstadoCategoria(idcategoria,proceso){    
    $.ajax({
        method: "POST",
        url: "controlador/contCategoria.php",
        data: {
            'proceso': proceso,
            'idcategoria': idcategoria
        }
    }).done(function(resultado){
        if(resultado==1){
            toastCorrecto("Cambio de estado satisfactorio.");
            listarCategorias();
        }else{
            toastError("Problemas en la actualización de estado. Inténtelo nuevamente.");
        }
    });
}
</script>