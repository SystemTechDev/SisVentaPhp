<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
              <i class="fas fa-car"></i> Proveedores
              <button type="button" id="btnNuevo" class="btn btn-success" onclick="nuevoProveedor();"><i class="fas fa-plus"></i> Nuevo Proveedor</button> 
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Compras</a></li>
              <li class="breadcrumb-item active">Proveedor</li>
            </ol>
          </div>
    </div>
  </div>
</section>

<div class="card">
  <div class="card-body">
      <div class="row">
            <div class="col-4">
              <div class="input-group mb-3">
            <input type="text" class="form-control" id="busquedanombre" name="busquedanombre" placeholder="Nombre" onkeyUp="if(event.keyCode=='13'){buscarProveedor(); }"> 
            </div>
          </div>
            <div class="col-4">
              <div class="input-group mb-3">
              <button type="button" id="btnBuscar" class="btn btn-success" onclick="buscarProveedor();"><i class="fa fa-search"></i>Buscar</button>
            </div> 
          </div>
        </div>
        <div class="row text-center" id="divMantProveedor">
        
    </div>
    <div class="tile-body" id="divListadoProveedor">
        
    </div>
   
</div>
</div>

<script type="text/javascript">

  function buscarProveedor(){
    let nombre = $("#busquedanombre").val();
  $.ajax({
    method: "POST",
    url: 'vista/Proveedor/listadoProveedor.php?nombre='+nombre,
    data: {
        filtro: $("#busquedanombre").val(),
        
      }
  }).done(function(resultado){
      $("#divListadoProveedor").html(resultado);
  })
}
  function buscarProveedorr() {
    let nombre = $("#busquedanombre").val();
    cargar('divListadoProveedor','vista/Proveedor/listadoProveedor.php?nombre='+nombre);
  }

  function nuevoProveedor() {
    //$("#divMantProveedor").show();
    //cargar('divMantProveedor','presentacion/mantProveedor.php?accion=REGISTRAR');
    ViewModal('vista/Proveedor/mantProveedor.php?accion=REGISTRAR','divModalMediano','Registro de Nuevo Proveedor');
  }

  function editarProveedor(id) {
    //$("#divMantProveedor").show();
    //cargar('divMantProveedor','presentacion/mantProveedor.php?accion=ACTUALIZAR&id='+id);
    ViewModal('vista/Proveedor/mantProveedor.php?accion=ACTUALIZAR&id='+id,'divModalMediano','Actualizar Proveedor');
  }

  function guardarProveedor() {
    $.ajax({
      url:'controlador/contProveedor.php',
      type: 'POST',
      data: $('#frmProveedor').serialize()
    }).done(function (respuesta) {
      //alert(respuesta); 
      if (respuesta == 'OK') {
        toastCorrecto("Datos Procesados Correctamente..!"); 
        buscarProveedor();
        //$("#divMantProveedor").hide();
        CloseModal('divModalMediano');
      }else{
        alert(respuesta);
      }
        
    })
  }

  function cambiarEstadoProveedor(id, estado){
    msj="";
    if(estado=="A"){msj="¿Esta seguro de anular proveedor?";}
    if(estado=="N"){msj="¿Esta seguro de activar proveedor?";}
    if(estado=="E"){msj="¿Esta seguro de eliminar proveedor?";}
    
    //confirm(msj,"ProcesoCambiarEstadoCategoriaproduct('"+id+"','"+estado+"')"); 
    NuevoConfirmar(msj,"ProcesoCambiarEstadoProveedor('"+id+"','"+estado+"')");
  }
  function ProcesoCambiarEstadoProveedor(id, estado){
    //CloseModal('divConfirmar');
      $.ajax({
      method: "POST",
      url: 'controlador/contProveedor.php',
      data: {accion: "CAMBIAR_ESTADO_CATEGORIA",
        'id': id,
        'estado': estado
        }
      })
      .done(function( respuesta ) {
        if (respuesta == 'OK') {
         toastCorrecto("Datos Procesados Correctamente..!"); 
          buscarProveedor();
          //$("#divMantProveedor").hide();
          //CloseModal('divModalMediano');
        }else{
          alert(respuesta);
        }
      })
  }

  buscarProveedor();
</script>