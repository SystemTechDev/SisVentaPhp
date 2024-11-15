<?php 
session_start();
$accion = $_GET['accion'];
unset($_SESSION['carrito']);
?>

<div class="col-md-12">
<form id="frmCompra" name="frmCompra">
<input type="hidden" name="accion" id="accion" value="<?php echo $accion; ?>">
<div class="card-body">
  <div class="form-group">
    <label for="fecha" >Fecha</label>
    <input type="date" class="form-control" id="fecha" name="fecha" placeholder="Ingrese Fecha" >
  </div>
  <div class="form-group">
    <label for="fecha" >Documento</label>
    <div class="row">
    	<div class="col-lg-5 col-md-5 col-sm-5">
	    	<input type="text" class="form-control" id="serie" name="serie" placeholder="Serie" >
	    </div>
	    <div class="col-lg-7 col-md-7 col-sm-7">
	    	<input type="text" class="form-control" id="numerodocumento" name="numerodocumento" placeholder="Nro Documento" >
	    </div>
    </div>
  </div>
  <div class="form-group">
    <label for="persona_id" >Proveedor</label>
    <input type="hidden" class="form-control" id="persona_id" name="persona_id" >
    <input type="text" class="form-control" id="nombreproveedor" name="nombreproveedor" placeholder="Proveedor" onclick="listarproveedores();">
  </div>
  <div class="form-group">
    <label for="total" >Total</label>
    <input type="text" class="form-control" id="total" name="total" value="0" readonly="readonly">
  </div>
  <div id="divProduct" class="row">
		<div class="col-lg-12 col-md-12 col-sm-12">
			<div id="divDetail" class="table-responsive" style="overflow:auto; height:150px; padding-right:10px; border:1px outset">
		        <table style="width: 100%;" class="table-condensed table-striped table-bordered">
		            <thead>
		                <tr>
		                    <th class='text-center'>Producto</th>
		                    <th class='text-center'>Cantidad</th>
		                    <th class="text-center">Precio</th>
		                    <th class="text-center">Subtotal</th>
		                    <th class='text-center'>Quitar</th>                            
		                </tr>
		            </thead>
		           
		        </table>
		    </div>
		</div>
	 </div>
	 <br>
	 <div class="text-center" align="center">
	 	<button type="button" id="btnAgregar" class="btn btn-success" onclick="listarproductos();">Agregar</button>
	 </div>
</div>
<!-- /.card-body -->

<div class="card-footer text-center">
	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
  <button type="button" id="btnGuardar" class="btn btn-primary">Guardar</button>
</div>
</form>
</div>
<script type="text/javascript">
	$("#btnGuardar").click(function(){
      guardarCompra();  
    });
	function listarproveedores() {
    ViewModal('vista/adminProveedorselect.php?accion=REGISTRAR','divlibre','Seleccionar Proveedor');
  }
  function listarproductos() {
    ViewModal('vista/adminProductoselect.php?accion=REGISTRAR','divlibre','Seleccionar Producto');
  }

  function seleccionarProducto(posicion) {
  	let producto_id = $('#id'+posicion).val();
  	let preciocompra = $('#preciocompra'+posicion).val();
  	let cantidad = $('#cantidad'+posicion).val();
  	let nombreproducto = $('#nombreproducto'+posicion).val();
  	//alert(producto_id+'-'+preciocompra+'-'+cantidad);
    $.ajax({
      url:'controlador/contCompra.php',
      type: 'POST',
      data: {producto_id:producto_id,preciocompra:preciocompra,cantidad:cantidad,nombreproducto:nombreproducto,accion:"AGREGAR_CARRITO"}
    }).done(function (respuesta) {
      //alert(respuesta); 
      /*if (respuesta == 'OK') {
        alert("DATOS PROCESADOS CORRECTAMENTE");
        buscarProducto();
        //$("#divMantProducto").hide();
        CloseModal('divModalMediano');
      }else{
        alert(respuesta);
      }*/
      var dato = JSON.parse(respuesta);
      $("#total").val(dato.total);
      $("#divDetail").html(dato.lista);
    })
  }

  function quitarProducto(producto_id) {

  	//alert(producto_id+'-'+preciocompra+'-'+cantidad);
    $.ajax({
      url:'controlador/contCompra.php',
      type: 'POST',
      data: {producto_id:producto_id,accion:"QUITAR_CARRITO"}
    }).done(function (respuesta) {
      //alert(respuesta); 
      /*if (respuesta == 'OK') {
        alert("DATOS PROCESADOS CORRECTAMENTE");
        buscarProducto();
        //$("#divMantProducto").hide();
        CloseModal('divModalMediano');
      }else{
        alert(respuesta);
      }*/
      var dato = JSON.parse(respuesta);
      $("#total").val(dato.total);
      $("#divDetail").html(dato.lista);
    })
  }
</script>