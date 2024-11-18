<section class="content">
  <div class="container-fluid">
    <div class="card card-outline">
      <div class="card-header">
        <!--<h3 class="card-title">Icons</h3> -->
        <div class="row">
            <div class="col-sm-4">
            <input type="text" class="form-control" id="busquedanombreproveedor" name="busquedanombreproveedor" placeholder="Nombre" onkeyUp="if(event.keyCode=='13'){buscarProveedor(); }"> 
            </div>
            <div class="col-sm-4">
              <button type="button" id="btnBuscar" class="btn btn-success" onclick="buscarProveedor();"><i class="fa fa-search"></i>Buscar</button>
              <!--<button type="button" id="btnNuevo" class="btn btn-primary" onclick="nuevoProveedor();"><i class="fa  fa-plus"></i>Nuevo</button> -->
            </div> 
        </div>
        
      </div>
      <div class="row text-center" id="divMantProveedor">
        
      </div>
      <!-- /.card-body -->
      <div class="card-body" id="divListadoProveedor">
        
      </div><!-- /.card-body -->
    </div>
  </div><!-- /.container-fluid -->
</section>

<script type="text/javascript">
  function buscarProveedor() {
    let nombreproveedor = $("#busquedanombreproveedor").val();
    cargar('divListadoProveedor','vista/Compra/listadoProveedorselect.php?nombre='+nombreproveedor);
  }

  function nuevoProveedor() {
    //$("#divMantProveedor").show();
    //cargar('divMantProveedor','presentacion/mantProveedor.php?accion=REGISTRAR');
    ViewModal('vista/Compra/mantProveedor.php?accion=REGISTRAR','divModalMediano','Registro de Nuevo Proveedor');
  }

  function guardarProveedor() {
    $.ajax({
      url:'controlador/contProveedor.php',
      type: 'POST',
      data: $('#frmProveedor').serialize()
    }).done(function (respuesta) {
      //alert(respuesta); 
      if (respuesta == 'OK') {
        alert("DATOS PROCESADOS CORRECTAMENTE");
        buscarProveedor();
        //$("#divMantProveedor").hide();
        CloseModal('divModalMediano');
      }else{
        alert(respuesta);
      }
        
    })
  }

  function seleccionarProveedor(id,nombre,tipopersona,ruc,direccion) {
    $('#persona_id').val(id);
    $('#nombreproveedor').val(nombre);
    $('#idtipodocumentoproveedor').val(tipopersona);
    $('#nrodocumentoproveedor').val(ruc);
    $('#direccionproveedor').val(direccion);
    CloseModal('divlibre');
  }

  buscarProveedor();
</script>