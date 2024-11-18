<?php 

include_once("../../modelo/TipoComprobante.php");
include_once("../../modelo/TipoDocumento.php");
include_once("../../modelo/Moneda.php");
require_once("../../modelo/Producto.php");

$objTD = new TipoDocumento();
$documentos = $objTD->listarDocumentos();

$objTC = new TipoComprobante();
$comprobantes = $objTC->listarTipoComprobantes();
$comprobantecompra = $objTC->obtenerComprobanteCompra();

$objMon = new Moneda();
$monedas = $objMon->listarMonedas();

if(isset($_GET['limpiar_sesion'])){
    if($_GET['limpiar_sesion']==1){
        $_SESSION['carritocompra']=array();
    }
}
$idcompra = 0;
$accion = "REGISTRAR";
//unset($_SESSION['carrito']);

 ?>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="text-center text-success">
              <i class="fas fa-tags"></i> INGRESO DE PRODUCTOS --COMPRAS--
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Compras</a></li>
              <li class="breadcrumb-item active">Compra</li>
            </ol>
          </div>
    </div>
  </div>
</section>

<section class="content mt-2">
  <div class="container-fluid">
    <div class="card card-info">
      <div class="card-header">
       <h3 class="card-title">Todos los Campos con (*) son Obligatorios</h3>
      </div>
      <div class="card-body">
        <form id="frmCompra" name="frmCompra">
          <input type="hidden" name="accion" id="accion" value="<?php echo $accion; ?>">
          <div class="row">
            <div class="col-sm-3">
                              <div class="form-group row">
                              <label for="ordec" class="col-sm-5 col-form-label">Fecha Ingreso:</label>
                                  <div class="col-sm-6">
                                     <input type="date" class="form-control" id="fechaingreso" name="fechaingreso" value="<?= date('Y-m-d') ?>" />
                                  
                                  </div>
                               </div>
            </div>
            <div class="col-sm-3">
                     <div class="form-group row">
                           <label  class="col-sm-5 col-form-label">Tipo ingreso:</label>
                           <div class="col-sm-6">
                                   <select class="form-control" id="idtipocomprobante" name="idtipocomprobante" onchange="obtenerSeriescompra();">
                                <option value="0">- Seleccione uno -</option>
                                <?php foreach($comprobantecompra as $k=>$v){ 
                                    $selected = "";
                                    if($idcompra>0){
                                        if($v['idtipocomprobante']==$venta['idtipocomprobante']){
                                            $selected = "selected";
                                        }
                                    }
                                    ?>
                                <option value="<?= $v['idtipocomprobante']?>" <?= $selected ?> ><?= $v['nombre'] ?></option>
                                <?php }?>
                            </select>
                            </div>
                        </div>

            </div>
            <div class="col-sm-3">
                           <div class="form-group row">
                              <label  class="col-sm-4 col-form-label">Serie :</label>
                              <div class="col-sm-6">
                              <select class="form-control" id="serie" name="serie" onchange="obtenerCorrelativocompra();">
                                <option value="0">- Seleccione uno -</option>
                               
                              </select>
                              </div>
                            </div>
            </div>
            <div class="col-sm-3"> 
                          <div class="form-group row">
                              <label class="col-sm-6 col-form-label">Correlativo :</label>
                              <div class="col-sm-6">
                              <input class="form-control" type="text" id="correlativo" name="correlativo" readonly />
                              </div>
                          </div>  
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="card card-success card-outline">
                        <h5 class="card-header border-secondary">DATOS DEL COMPROBANTE DE COMPRA</h5>
                        <div class="card-body">
                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Fecha em:</label>
                                  <div class="col-sm-9">
                                     <input type="date" class="form-control" id="fechaemision" name="fechaemision" value="<?= date('Y-m-d') ?>" />
                                  <input type="hidden" id="idcompra" name="idcompra" />
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Comprobante:</label>
                              <div class="col-sm-9">
                              <select class="form-control" id="tipocomprobantecompra" name="tipocomprobantecompra">
                                  <option value="0">- Seleccione uno -</option>
                                  <option >FACTURA</option>
                                  <option >BOLETA</option>
                                  <option >OTROS</option>
                              </select>
                              </div>
                          </div> 
                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Serie Comprobante:</label>
                              <div class="col-sm-9">
                              <input type="text" class="form-control" id="seriecomprobantecompra" name="seriecomprobantecompra" placeholder="Serie" >
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Nº Comprobante:</label>
                              <div class="col-sm-9">
                              <input type="text" class="form-control" id="numerodocumentocompra" name="numerodocumentocompra" placeholder="Nro Documento" >
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Forma Pago:</label>
                              <div class="col-sm-9">
                              <select class="form-control" id="formapagocompra" name="formapagocompra" onchange="verificarFormaPago()">
                                  <option value="C">CONTADO</option>
                                  <option value="D">CREDITO</option>
                              </select>
                              </div>
                          </div> 
              </div>
            </div>
            </div>
            <div class="col-sm-6">
              <div class="card  border-info">
                      <h5 class="card-header border-secondary">DATOS DEL PROVEEDOR</h5>
                      <div class="card-body">                      
                          <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Proveedor:</label>
                              <div class="col-sm-9">
                               <input type="hidden" class="form-control" id="persona_id" name="persona_id" >
                               <input type="text" class="form-control" id="nombreproveedor" name="nombreproveedor" placeholder="Click Aqui Para Seleccionar Proveedor" onclick="listarproveedores();">
                              </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Tipo Doc:</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="idtipodocumentoproveedor" name="idtipodocumentoproveedor" readonly />
                              <!--
                              <select class="form-control" name="idtipodocumento" id="idtipodocumento">
                                  <?php foreach($documentos as $k=>$v){ ?>
                                  <option value="<?= $v['idtipodocumento'];?>"><?= $v['nombre'] ?></option>                                
                                  <?php }?>
                              </select> -->
                            </div>
                          </div>
                          <div class="form-group row">
                             <label class="col-sm-3 col-form-label">Numero Doc:</label>
                             <div class="col-sm-9">
                                  <input type="text" class="form-control" id="nrodocumentoproveedor" name="nrodocumentoproveedor" readonly />
                              </div>        
                          </div>
                          <div class="form-group row">
                             <label class="col-sm-3 col-form-label">Direccion:</label>
                             <div class="col-sm-9">
                                  <input type="text" class="form-control" id="direccionproveedor" name="direccionproveedor" readonly />
                              </div>
                          </div>
                      </div>
              </div>
            </div>
           <!-- <div class="col-sm-4">
            </div> -->
          </div>
        </form>
      </div>
    </div>

    <div class="card card-info">
      <div class="card-header">
       <h3 class="card-title">DETALLE DE INGRESO DE PRODUCTOS </h3>
      </div>
      <div class="card-body">
      <div class="row">
          <div class="col-6">
              <div class="card  border-secondary ">
                        <h5 class="card-header border-secondary">Listado de Productos Disponibles</h5>
                        <div class="card-body ">
                            <?php 
                            
                            //$nombre = $_GET['nombre'];
                            //$categoriaproducto_id = $_GET['categoriaproducto_id'];
                            $nombre = "";
                            $categoriaproducto_id = null;
                            $objproducto = new Producto();
                            $data = $objproducto->listar("%%",1);
                            //$productos = $objPro->listar("%%",1);
                            if ($data->rowCount() > 0) {
                            ?>
                        <div class="card-body table-responsive p-0" style="height: 300px;">
                          <table id="tablaProducto" class="table table-bordered table-hover table-responsive table-head-fixed table-sm text-sm table-striped">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Producto</th>
                              <th>P.C.</th>
                              <th>Cant</th>
                              <th>Stock Actual</th>
                              <th>Agregar</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              $i=0;  
                              //for ($i=0; $i < count($lista) ; $i++) { 
                              while($dato = $data->fetch(PDO::FETCH_NAMED)){ 
                                $class=""; $stockactual = 0;
                                if($dato['estado']=='A'){
                                  $class="text-red";
                                }
                                
                                $datastock = $objproducto->consultarStockProductoById($dato['idproducto']);
                                $datostock = $datastock->fetch(PDO::FETCH_NAMED);
                                if ($datostock['stockactual'] ?? null) {
                                  $stockactual = $datostock['stockactual'];
                                }
                            ?>
                              <tr class="<?php echo $class;?>">
                                <td><?php echo ($i+1); ?><input type="hidden" name="id<?php echo $i; ?>" id="id<?php echo $i; ?>" value="<?php echo $dato['idproducto']; ?>">
                                </td>
                                <td><?php echo $dato['nombre']; ?><input type="hidden" name="nombreproducto<?php echo $i; ?>" id="nombreproducto<?php echo $i; ?>" value="<?php echo $dato['nombre']; ?>">
                                </td>
                                <td><input type="text" name="preciocompra<?php echo $i; ?>" id="preciocompra<?php echo $i; ?>" value="<?php echo $dato['pcompra']; ?>" size="3">
                                </td>
                                <td><input type="text" name="cantidad<?php echo $i; ?>" id="cantidad<?php echo $i; ?>" size="2">
                                </td>
                                <td><?php echo $dato['stock']; ?></td>
                                <td><button type="button" class="btn btn-xs bg-maroon" onclick="seleccionarProducto(<?php echo $i; ?>);"><i class="fa fa-plus-circle"></i> Agregar</button>
                                </td>
                              </tr>
                              <?php 
                                $i++; 
                                }
                              ?>
                            </tbody>
                          </table>
                        </div>
                            <?php 
                            }else{
                            ?>
                            <h3 class="text-center text-warning">NO SE ENCONTRARON REGISTROS</h3>
                            <?php }?>
                        </div>
              </div>
          </div>
          <div class="col-6">
            <div class="card  border-secondary">
                <h5 class="card-header border-secondary">Productos a ingresar</h5>
                <div class="card-body">
                  <div id="divProduct" class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                          <div id="divDetail" class="table-responsive" style="overflow:auto; height:300px; padding-right:10px; border:1px outset">
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
                  <div class="row">
                    <div class="col-6">
                      
                    </div>
                      <div class="col-6" id="divtotalescompra">
                        <div class="form-group row">
                            <label for="subtotal" class="col-sm-5 col-form-label">SubTotal: S/.</label>
                            <div class="col-sm-7">
                            <input type="text" class="form-control" id="subtotal" name="subtotal" value="0.00" >
                            </div>
                        </div>
                        <div class="form-group row">
                             <label for="igv" class="col-sm-5 col-form-label">IGV(18%): S/.</label>
                             <div class="col-sm-7">
                             <input type="text" class="form-control" id="igv" name="igv" value="0.00" >
                             </div>
                        </div>
                        <div class="form-group row">
                             <label for="total" class="col-sm-5 col-form-label">Total: S/.</label>
                             <div class="col-sm-7">
                             <input type="number" class="form-control" id="total" name="total" value="0.00" readonly>
                             </div>
                        </div>

                      </div>
                  </div>
                </div>

                    
              </div>

              <div class="text-center">
                  <button type="button" class="btn btn-danger" onclick="CancelarCompra()"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</button>
                   <button type="button"  id="btnGuardar" class="btn btn-primary"><i class="fa fa-fw fa-lg fa-check-circle"></i>Guardar Compra</button>
              </div>
            </div>
          </div>
      </div>
    </div>

  </div>
</section>


<script type="text/javascript">

  $("#btnGuardar").click(function(){
      guardarCompra();  
    });

  function listarproveedores() {
    ViewModal('vista/Compra/adminProveedorselect.php?accion=REGISTRAR','divlibre','Seleccionar Proveedor');
  }

  function listarproductos() {
    ViewModal('vista/Compra/adminProductoselect.php?accion=REGISTRAR','divlibre','Seleccionar Producto');
  }

  function obtenerSeriescompra(idtipocomprobante=0){
    $.ajax({
        method: "POST",
        url: "controlador/contCompra.php",
        data:{
            'accion': "SERIES",
            'idtipocomprobante': $("#idtipocomprobante").val()
        },
        dataType: 'json'
    }).done(function(resultado){
        series = "";
        for(i=0;i<resultado.length;i++){
            series = series + "<option value='"+resultado[i].serie+"'>"+resultado[i].serie+"</option>"; 
        }
        $("#serie").html(series);
        if(idtipocomprobante>0){
            <?php if($idcompra>0){?>
            $("#serie").val('<?= $venta['serie'] ?>');
            $("#correlativo").val('<?= $venta['correlativo'] ?>');
            <?php }?>
        }else{
            obtenerCorrelativocompra();
        }
        
    });
}

$('#tablaProducto').DataTable({
      "paging": false,
      "lengthChange": true,
      "searching": true,
      "ordering": false,
      "order":[[1,'asc']],
      "info": true,
      "autoWidth": false,
      "responsive": true
    });

function obtenerCorrelativocompra(){
    $.ajax({
        method: "POST",
        url: "controlador/contCompra.php",
        data:{
            'accion': "OBTENER_CORRELATIVO",
            'idtipocomprobante': $("#idtipocomprobante").val(),
            'serie': $("#serie").val()
        }
    }).done(function(resultado){
        $("#correlativo").val(resultado);
    });    
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
      $("#igv").val(dato.igv);
      $("#subtotal").val(dato.subtotall);
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

  function guardarCompra() {
        if(!ValidarFormulario()){
        return 0;
    }

      var datos_formulario = $("#frmCompra").serializeArray();
      datos_formulario.push({name: "subtotal", value:$('#subtotal').val()});
      datos_formulario.push({name: "igv", value:$('#igv').val()});
      datos_formulario.push({name: "total", value:$('#total').val()});
    $.ajax({
      url:'controlador/contCompra.php',
      type: 'POST',
      //data: $('#frmCompra').serialize()
      data: datos_formulario
    }).done(function (respuesta) {
      //alert(respuesta); 
      if (respuesta == 'OK') {
       toastCorrecto("Datos Procesados Correctamente..!");
       CancelarCompra(); 
       // buscarCompra();
        //$("#divMantCompra").hide();
       // CloseModal('divModalMediano');
      }else{
        alert(respuesta);
      }
        
    })
  }

  function CancelarCompra(){
    <?php if($idcompra>0){ ?>
        AbrirPagina('vista/Compra/adminCompra.php');    
    <?php }else{ ?>
        AbrirPagina('vista/Compra/compras.php?limpiar_sesion=1');
    <?php }?>
}

function ValidarFormulario(){
    retorno = true;
    if($("#idtipocomprobante").val()=="" || $("#idtipocomprobante").val()=="0"){
        toastError('Seleccione Tipo Ingreso.');          
        retorno = false;
    }
    
    if($("#persona_id").val()=="" || $("#persona_id").val()=="0"){
       toastError('Seleccione un Proveedor.');          
        retorno = false;
    }

    return retorno;
}

</script>


