<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-8">
            <h1>PRESTAMOS DE BIENES MATERIALES DE LA EMPRESA</h1>
          </div>
          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Herramientas</a></li>
              <li class="breadcrumb-item active">Prestamos</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
  </section>

<section class="content mt-2">
    <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="callout callout-info">
              <h5><i class="fas fa-info"></i> Nota:</h5>
              Toda Herramienta Saldra con firma del prestante y sera devuelto con firma de recepcion.
            </div>


            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> Servic, Metal.
                    <small class="float-right">Fecha: <?= date("d-m-Y") ?></small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  Empresa
                  <address>
                    <strong>Servic, Metal.</strong><br>
                    795 Folsom Ave, Suite 600<br>
                    San Francisco, CA 94107<br>
                    Phone: (804) 123-5432<br>
                    Email: info@almasaeedstudio.com
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  Prestante
                  <address>
                    <select class="form-control" name="cbotrabajador" id="cbotrabajador">
                        <option value="0">--Seleccione un Personal--</option>
                        <option value="0">Kelvin Rivadneira Fabian</option>
                        <option value="0">Kelvin Rivadneira Fabian</option>
                    </select>
                    <strong>John Doe</strong><br>
                    795 Folsom Ave, Suite 600<br>
                    San Francisco, CA 94107<br>
                    Phone: (555) 539-1037<br>
                    Email: john.doe@example.com
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>Invoice #007612</b><br>
                  <br>
                  <b>Order ID:</b> 4F3S8J<br>
                  <b>Payment Due:</b> 2/22/2014<br>
                  <b>Account:</b> 968-34567
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>Cant</th>
                      <th>Producto</th>
                      <th>Color</th>
                      <th>Descripcion</th>
                      <th>Marca Modelo Serie</th>
                      <th class="text-center">Quitar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <td>1</td>
                      <td>AMOLADORA</td>
                      <td>AZUL</td>
                      <td>Amoladora con pernos unicos</td>
                      <td>TRUPER-TRUPER-10203040</td>
                      <td class="text-center"><button class="btn btn-danger btn-sm"><i class="fas fa-times-circle"></i></button></td>
                    </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                  <p class="lead">Payment Methods:</p>
                  <img src="../../sistema/dist/img/credit/visa.png" alt="Visa">
                  <img src="../../sistema/dist/img/credit/mastercard.png" alt="Mastercard">
                  <img src="../../sistema/dist/img/credit/american-express.png" alt="American Express">
                  <img src="../../sistema/dist/img/credit/paypal2.png" alt="Paypal">

                  <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                    plugg
                    dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                  </p>
                </div>
                <!-- /.col -->
                <div class="col-6">
                  <p class="lead">Amount Due 2/22/2014</p>

                  <div class="table-responsive">
                    <table class="table">
                      <tbody><tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>$250.30</td>
                      </tr>
                      <tr>
                        <th>Tax (9.3%)</th>
                        <td>$10.34</td>
                      </tr>
                      <tr>
                        <th>Shipping:</th>
                        <td>$5.80</td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td>$265.24</td>
                      </tr>
                    </tbody></table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                  <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                    Payment
                  </button>
                  <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fas fa-download"></i> Generate PDF
                  </button>
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div>
    </div>
</section>

<div class="modal fade" id="modalHerramienta" tabindex="-1" role="dialog">
    <div class="modal-dialog ">
        <div class="modal-content ">
        <div class="modal-header bg-info">
            <h4 class="modal-title">Herramienta</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="frmHerramienta" name="frmHerramienta">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>Nombre del Bien Material</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" />
                            <input type="hidden" name="idherramienta" id="idherramienta" />
                        </div>                       
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Marca</label>
                            <input type="text" class="form-control" name="marca" id="marca" />
                        </div>
                         <div class="form-group">
                            <label>Nº Serie</label>
                            <input type="text" class="form-control" name="serie" id="serie" />
                        </div>
                        <div class="form-group">
                            <label>Color</label>
                            <input type="text" class="form-control" name="color" id="color" />
                        </div>                        
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Modelo</label>
                            <input type="text" class="form-control" name="modelo" id="modelo" />
                        </div>
                         <div class="form-group">
                            <label>Descripcion</label>
                            <input type="text" class="form-control" name="descripcion" id="descripcion" />
                        </div>
                        <div class="form-group">
                            <label>Estado</label>
                            <select class="form-control" name="estado" id="estado">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>                        
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
            <button type="button" class="btn btn-primary" onclick="GuardarHerramienta()"><i class="fas fa-save"></i> Guardar</button>
        </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>


<script>
 function listarHerramientas(){
  $.ajax({
    method: "POST",
    url: "vista/Herramientas/herramientas_listado.php",
    data: {
        filtro: $("#txtFiltroHerramienta").val(),
        estado: $("#cboFiltroEstado").val() 
      }
  }).done(function(resultado){
      $("#divListado").html(resultado);
  })
}

 listarHerramientas();

 function GuardarHerramienta(){
    if(!ValidarFormulario()){
        return 0;
    }
    var datos_formulario = $("#frmHerramienta").serializeArray();
    
    if($("#idherramienta").val()!="" && $("#idherramienta").val()!="0"){
        datos_formulario.push({name: "proceso", value:"ACTUALIZAR"});
    }else{
        datos_formulario.push({name: "proceso", value:"NUEVO"});
    }
    $.ajax({
        method: "POST",
        url: "controlador/contHerramienta.php",
        data: datos_formulario
    }).done(function(resultado){
       if(resultado==1){
            SwalCorrecto("Registro satisfactorio");        
            $("#modalHerramienta").modal('hide');
            $("#frmHerramienta").trigger('reset');        
            listarHerramientas();                     
       }else{
            msjError = resultado==2?"Herramienta duplicada":"No se pudo registrar la Herramienta."
            SwalError(msjError); 
       }
    }); 

 }

 function ValidarFormulario(){
    retorno = true;
    if($("#nombre").val()==""){
        toastError('Ingrese el nombre de la Herramienta.');          
    retorno = false;
    }
    return retorno;
 }

 function NuevaHerramienta(){
    $("#frmHerramienta").trigger('reset');  
    $("#idherramienta").val("");  
    $("#modalHerramienta").modal('show');
 }

</script>
