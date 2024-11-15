<?php 
include_once("../../modelo/Producto.php");
$objPro = new Producto();
$filtro = $_POST['filtro'];
$estado = $_POST['estado'];
$listado = $objPro->listar("%".$filtro."%",$estado);
?>
<table id="tablaProducto" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Img</th>
            <th>Nombre</th>
            <th>PV</th>
            <th>PC</th>
            <th>Estado</th>
            <th>Img</th>
            <th>Acción</th>
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
                <td><?= $v['idproducto'] ?></td>
                <td><img src="<?= $v['urlimagen'] ?>" width="30" height="30" /></td>
                <td><?= $v['nombre'] ?></td>
                <td><?= $v['pcompra'] ?></td>
                <td><?= $v['pventa'] ?></td>
                <td><?= $v['estado']==1?"ACTIVO":"INACTIVO"; ?></td>
                <td>
                    <button onclick="SubirImagen(<?= $v['idproducto'] ?>)" class="btn bg-navy btn-sm" ><span class="fas fa-image" ></span></button>
                </td>
                <td class="text-center">
                    <button onclick="EditarProducto(<?= $v['idproducto'] ?>)" class="btn btn-info btn-sm" title="Editar Registro">
                        <i class="fas fa-edit" aria-hidden="true"></i>
                    </button>
                    <button onclick="CambiarEstadoProducto(<?= $v['idproducto'] ?>,<?= $estado ?>,'<?= $v['nombre'] ?>')" class="btn <?= $bgclass ?> btn-sm" title="<?= $texto ?> Registro">
                    <i class="fas <?= $iconi ?>"></i>
                    </button>
                    <?php if ($_SESSION['idusuario'] == 1) { ?>
                        <button onclick="CambiarEstadoProducto(<?= $v['idproducto'] ?>,2,'<?= $v['nombre'] ?>')" class="btn bg-danger btn-sm" title="Eliminar Registro">
                        <i class="far fa-trash-alt" aria-hidden="true"></i>
                        </button>
                    <?php } ?>
                    
                </td>
            </tr>
        <?php }?>
    </tbody>
</table>
<script>
$('#tablaProducto').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#tablaProduct_wrapper .col-md-6:eq(0)');

function EditarProducto(idproducto){
    $.ajax({
        method: "POST",
        url: "controlador/contProducto.php",
        data:{
            'proceso': "CONSULTAR",
            'idproducto': idproducto
        },
        dataType: "json"
    }).done(function(resultado){
        $("#idproducto").val(resultado.idproducto);
        $("#nombre").val(resultado.nombre);
        $("#codigobarra").val(resultado.codigobarra);
        $("#pventa").val(resultado.pventa);
        $("#pcompra").val(resultado.pcompra);
        $("#stock").val(resultado.stock);
        $("#idunidad").val(resultado.idunidad);
        $("#idcategoria").val(resultado.idcategoria);
        $("#idafectacion").val(resultado.idafectacion);
        $("#afectoicbper").val(resultado.afectoicbper);
        $("#estado").val(resultado.estado);
        $("#stockseguridad").val(resultado.stockseguridad);
        $("#modalProducto").modal('show');
    });
}

function CambiarEstadoProducto(idproducto, estado, nombre){
    proceso = estado==0?"ANULAR":(estado==1?"ACTIVAR":"ELIMINAR");
    mensaje = "¿Esta seguro de <b>"+proceso+"</B> producto <b>"+nombre+"</b>?";
    accion = "EjecutarCambiarEstadoProducto("+idproducto+",'"+proceso+"')";
    mostrarModalConfirmacion(mensaje, accion);
}

function EjecutarCambiarEstadoProducto(idproducto,proceso){    
    $.ajax({
        method: "POST",
        url: "controlador/contProducto.php",
        data: {
            'proceso': proceso,
            'idproducto': idproducto
        }
    }).done(function(resultado){
        if(resultado==1){
            toastCorrecto("Cambio de estado satisfactorio.");
            listarProductos();
        }else{
            toastError("Problemas en la actualización de estado. Inténtelo nuevamente.");
        }
    });
}


function SubirImagen(idproducto){
    $.ajax({
        method: "POST",
        url: "controlador/contProducto.php",
        data:{
            'proceso': "CONSULTAR",
            'idproducto': idproducto
        },
        dataType: "json"
    }).done(function(resultado){
        $("#idproducto_imagen").val(resultado.idproducto);
        $("#nombre_imagen").val(resultado.nombre);
        $("#urlimagen").val(resultado.urlimagen);
        DefinirFileInput();
        $("#modalImagen").modal('show');
    });
}
</script>