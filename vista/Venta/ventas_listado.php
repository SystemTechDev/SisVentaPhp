<?php 
include_once("../../modelo/Venta.php");
$objVen = new Venta();
$desde = $_POST['desde'];
$hasta = $_POST['hasta'];
$cliente = $_POST['cliente'];
$listado = $objVen->listar($desde, $hasta,"%".$cliente."%");
?>
<table id="tablaVentas" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Comprobante</th>
            <th>Cliente</th>
            <th>Total</th>
            <th>Estado</th>
            <th>Editar</th>
            <th>Anular</th>
           <!-- <th>Eliminar</th>-->
            <th>PDF</th>
            <th>Ticket</th>
             <th>Proforma</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($listado as $k=>$v){ 
            $bgclass = $v['estado']==1?"bg-warning":"bg-success";
            $texto = $v['estado']==1?"Anular":"Activar";
            $estado = $v['estado']==1?0:1;

            $bgclasstr = $v['estado']==0?"text-danger":"";
            $documento = $v['comprobante'].' '.$v['serie'].'-'.$v['correlativo'];
            ?>
            <tr class="<?= $bgclasstr ?>">
                <td><?= $v['idventa'] ?></td>
                <td><?= $v['fecha'] ?></td>
                <td><?= $documento ?></td>
                <td><?= $v['cliente'] ?></td>
                <td><?= $v['total'] ?></td>
                <td><?= $v['estado']==1?"ACTIVO":"ANULADO"; ?></td>
                <td><button onclick="EditarVenta(<?= $v['idventa'] ?>)" class="btn bg-info btn-sm">Editar</button></td>
                <td><button onclick="CambiarEstadoVenta(<?= $v['idventa'] ?>,<?= $estado ?>,'<?= $documento ?>')" class="btn <?= $bgclass ?> btn-sm"><?= $texto ?></button></td>
             <!-- <td><button onclick="CambiarEstadoVenta(<?= $v['idventa'] ?>,2,'<?= $documento ?>')" class="btn bg-danger btn-sm">Eliminar</button></td> -->
                <td><a class="btn btn-sm bg-maroon" href="vista/Venta/pdfVenta.php?id=<?= $v['idventa'] ?>" target="_blank">PDF</a></td>
                <td><a class="btn btn-sm bg-maroon" href="vista/Venta/pdfTicket.php?id=<?= $v['idventa'] ?>" target="_blank">Ticket</a></td>
                <td><a class="btn btn-sm bg-maroon" href="vista/Venta/pdfProforma.php?id=<?= $v['idventa'] ?>" target="_blank">Proforma</a></td>
            </tr>
        <?php }?>
    </tbody>
</table>
<script>
$('#tablaVenta').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "order":[[1,'asc']],
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#tablaVenta_wrapper .col-md-6:eq(0)');

function EditarVenta(idventa){
    $.ajax({
        method: "POST",
        url: "vista/frmVentas.php",
        data:{
            'proceso': "EDITAR",
            'idventa': idventa
        }
    }).done(function(resultado){
        $("#divPrincipal").html(resultado);
    });
}

function CambiarEstadoVenta(idventa, estado, documento){
    proceso = estado==0?"ANULAR":(estado==1?"ACTIVAR":"ELIMINAR");
    mensaje = "¿Esta seguro de <b>"+proceso+"</B> el comprobante <b>"+documento+"</b>?";
    accion = "EjecutarCambiarEstadoVenta("+idventa+",'"+proceso+"')";
    mostrarModalConfirmacion(mensaje, accion);
}

function EjecutarCambiarEstadoVenta(idventa,proceso){    
    $.ajax({
        method: "POST",
        url: "controlador/contVenta.php",
        data: {
            'proceso': proceso,
            'idventa': idventa
        }
    }).done(function(resultado){
        if(resultado==1){
            toastCorrecto("Cambio de estado satisfactorio.");
            listarVentas();
        }else if(resultado==0){
            toastError("Problemas en la actualización de estado. Inténtelo nuevamente.");
        }else{
            toastError(resultado);
        }
    });
}
</script>