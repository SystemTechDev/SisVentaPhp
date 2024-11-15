<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
              <i class="fas fa-peaple"></i> COMPRA DE PRODUCTOS
              <button type="button" id="btnNuevo" class="btn bg-olive" onclick="nuevoCompra();"> Nueva Compra <i class="fas fa-plus"></i></button> 
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Compras</a></li>
              <li class="breadcrumb-item active">Ingreso </li>
            </ol>
          </div>
    </div>
  </div>
</section>

<div class="card">
  <div class="card-body" >
      <div class="row">
          <div class="col-4">
             <div class="input-group mb-3">
            <input type="text" class="form-control" id="busquedanombre" name="busquedanombre" placeholder="Nombre Proveedor" onkeyUp="if(event.keyCode=='13'){buscarCompra(); }"> 
            </div>
          </div>
          <div class="col-4">
             <div class="input-group mb-3">
            <button type="button" id="btnBuscar" class="btn btn-success" onclick="buscarCompra();"><i class="fa fa-search"></i>Buscar</button>
          </div>
        </div>
          
       </div>
           <div  id="divListadoCompra">
              
          </div>
           <div  id="divMantCompra">
              
          </div>
  </div>
</div>

<script type="text/javascript">
  function buscarCompra() {
    let nombre = $("#busquedanombre").val();
    cargar('divListadoCompra','vista/Compra/listadoCompra.php?nombre='+nombre);
  }

function nuevoCompra(){
    $.ajax({
        method: "POST",
        url: "vista/Compra/compras.php"
    }).done(function(resultado){
        $("#divPrincipal").html(resultado);
    });
}
  //function nuevoCompra() {
    //$("#divMantCompra").show();
    //cargar('divMantCompra','presentacion/mantCompra.php?accion=REGISTRAR');
   // ViewModal('vista/Compra/mantCompra.php?accion=REGISTRAR','divModalMediano','Registro de Nueva Compra');
  //}
/*
  function guardarCompra() {
    $.ajax({
      url:'controlador/contCompra.php',
      type: 'POST',
      data: $('#frmCompra').serialize()
    }).done(function (respuesta) {
      //alert(respuesta); 
      if (respuesta == 'OK') {
       toastCorrecto("Datos Procesados Correctamente..!"); 
        buscarCompra();
        //$("#divMantCompra").hide();
        CloseModal('divModalMediano');
      }else{
        alert(respuesta);
      }
        
    })
  } */

  buscarCompra();
</script>