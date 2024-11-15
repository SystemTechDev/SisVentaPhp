<section class="content mt-2">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Reportes</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Desde</span>
                            </div>
                            <input type="date" class="form-control" id="txtFechaDesde" name="txtFechaDesde" value="<?= date('Y-01-01') ?>"/>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Hasta</span>
                            </div>
                            <input type="date" class="form-control" id="txtFechaHasta" name="txtFechaHasta" value="<?= date('Y-m-d')?>"/>
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
                     <button type="button" class="btn btn-info" onclick="mostrarReporte();">Ver Reporte</button> 
                     <button type="button" class="btn btn-info" onclick="verReportePdf();">PDF</button> 
                    </div>
                </div>
                <div id="divListado">

                </div>
            </div>
        </div>
    </div>
</section>
<script>

function mostrarReporte(){
  $.ajax({
    method: "POST",
    url: "vista/Reporte/reportes_resultado.php",
    data: {
        desde: $("#txtFechaDesde").val(),
        hasta: $("#txtFechaHasta").val(),
        cliente: $("#txtFiltroCliente").val() 
      }
  }).done(function(resultado){
      $("#divListado").html(resultado);
  })
}

mostrarReporte();

function verReportePdf(){
    desde = $("#txtFechaDesde").val();
    hasta = $("#txtFechaHasta").val();
    cliente = $("#txtFiltroCliente").val();     
    window.open("vista/Reporte/pdfReporte.php?desde="+desde+"&hasta="+hasta+"&cliente="+cliente,"_blank");    
}

</script>