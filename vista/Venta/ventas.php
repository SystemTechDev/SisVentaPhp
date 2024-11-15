<?php 
if(isset($_GET['limpiar_sesion'])){
    if($_GET['limpiar_sesion']==1){
        $_SESSION['carrito']=array();
    }
}
 ?>
<section class="content mt-2">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Listado de Comprobantes Emitidos</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Desde</span>
                            </div>
                            <input type="date" class="form-control" id="txtFechaDesde" name="txtFechaDesde"/>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Hasta</span>
                            </div>
                            <input type="date" class="form-control" id="txtFechaHasta" name="txtFechaHasta"/>
                        </div>
                    </div>                    
                    <div class="col-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Cliente</span>
                                <input type="text" class="form-control" id="txtFiltroCliente" name="txtFiltroCliente"/>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-3">
                     <button type="button" class="btn btn-info" onclick="listarVentas();">Buscar</button> 
                     <button type="button" class="btn btn-warning" onclick="NuevaVenta()">Nuevo</button>
                    </div>
                </div>
                <div id="divListado">

                </div>
            </div>
        </div>
    </div>
</section>
</div>
<script>
function listarVentas(){
  $.ajax({
    method: "POST",
    url: "vista/Venta/ventas_listado.php",
    data: {
        desde: $("#txtFechaDesde").val(),
        hasta: $("#txtFechaHasta").val(),
        cliente: $("#txtFiltroCliente").val() 
      }
  }).done(function(resultado){
      $("#divListado").html(resultado);
  })
}

listarVentas();

function NuevaVenta(){
    $.ajax({
        method: "POST",
        url: "vista/Venta/frmVentas.php",
        data:{
            'proceso': "NUEVO"
        }
    }).done(function(resultado){
        $("#divPrincipal").html(resultado);
    });
}
</script>