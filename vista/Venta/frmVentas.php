<?php 
include_once("../../modelo/TipoComprobante.php");
include_once("../../modelo/TipoDocumento.php");
include_once("../../modelo/Moneda.php");
include_once("../../modelo/Producto.php");
include_once("../../modelo/Venta.php");
include_once("../../modelo/Cliente.php");

$objVenta = new Venta();
$objClie = new Cliente();

$objTD = new TipoDocumento();
$documentos = $objTD->listarDocumentos();

$objTC = new TipoComprobante();
$comprobantes = $objTC->listarTipoComprobantes();

$objMon = new Moneda();
$monedas = $objMon->listarMonedas();

$objPro = new Producto();
$productos = $objPro->listar("%%",1);

if(isset($_GET['limpiar_sesion'])){
    if($_GET['limpiar_sesion']==1){
        $_SESSION['carrito']=array();
    }
}

$idventa = 0;
if(isset($_POST['idventa'])){
    $idventa = $_POST['idventa'];
}

$textoBoton = "Guardar Comprobante";
$venta = NULL;
$cliente = NULL;
$idcliente = 0;
if($idventa>0){
    $textoBoton = "Actualizar Comprobante";
    $venta = $objVenta->consultarVenta($idventa);
    if($venta->rowCount()>0){
        $venta = $venta->fetch(PDO::FETCH_NAMED);
        $idcliente = $venta['idcliente'];
    }
    $cliente = $objClie->consultarCliente($idcliente);
    if($cliente->rowCount()>0){
        $cliente = $cliente->fetch(PDO::FETCH_NAMED);
    }else{
        $cliente = NULL;
    }
}

?>
<section class="content mt-2">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">FORMULARIO DE EMISION DE COMPROBANTES</h3>
            </div>
            <div class="card-body">
                <form id="frmVenta" name="frmVenta">
                    <div class="row">
                        <div class="col-sm-4">
                    <div class="card  ">
                      <h5 class="card-header ">COMPROBANTE</h5>
                      <div class="card-body border border-info">
                        <div class="form-group row">
                            <label  class="col-sm-3 col-form-label">Fecha:</label>
                                <div class="col-sm-9">
                                   <input type="date" class="form-control" id="fecha" name="fecha" value="<?= date('Y-m-d') ?>" />
                                <input type="hidden" id="idventa" name="idventa" value="<?= $idventa ?>"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-sm-3 col-form-label">Comprobante:</label>
                            <div class="col-sm-9">
                            <select class="form-control" id="idtipocomprobante" name="idtipocomprobante" onchange="obtenerSeries();">
                                <option value="0">- Seleccione uno -</option>
                                <?php foreach($comprobantes as $k=>$v){ 
                                    $selected = "";
                                    if($idventa>0){
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
                        <div class="form-group row">
                            <label  class="col-sm-3 col-form-label">Serie:</label>
                            <div class="col-sm-9">
                            <select class="form-control" id="serie" name="serie" onchange="obtenerCorrelativo()">
                                <option value="0">- Seleccione uno -</option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Correlativo:</label>
                            <div class="col-sm-9">
                            <input class="form-control" type="text" id="correlativo" name="correlativo" readonly />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-sm-3 col-form-label">Forma Pago:</label>
                            <div class="col-sm-9">
                            <select class="form-control" id="formapago" name="formapago" onchange="verificarFormaPago()">
                                <option value="C">CONTADO</option>
                                <option value="D">CREDITO</option>
                            </select>
                            </div>
                        </div> 
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="card  border-info">
                      <h5 class="card-header ">DATOS DEL CLIENTE</h5>
                      <div class="card-body border border-info">
                        <div class="form-group row">
                          <label  class="col-sm-3 col-form-label">Tipo Doc:</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="idtipodocumento" id="idtipodocumento">
                                <?php foreach($documentos as $k=>$v){ ?>
                                <option value="<?= $v['idtipodocumento'];?>"><?= $v['nombre'] ?></option>                                
                                <?php }?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group row">
                           <label  class="col-sm-3 col-form-label">Numero Doc:</label>
                           <div class="col-sm-7">
                                <input type="text" class="form-control" id="nrodocumento" name="nrodocumento" onblur="BuscarClienteDocumento()"/>
                            </div>
                            <div class="col-sm-1">
                                    <button type="button" class="btn btn-primary" onclick="BuscarClienteDocumento()" >
                                        <span class="fas fa-search"></span>
                                    </button>
                            </div>         
                        </div>
                        <div class="form-group row">
                            <label  class="col-sm-3 col-form-label">Cliente:</label>
                            <div class="col-sm-9">
                            <input type="text" class="form-control" id="nombre" name="nombre"/>
                            </div>
                        </div>
                        <div class="form-group row">
                           <label  class="col-sm-3 col-form-label">Direccion:</label>
                           <div class="col-sm-9">
                                <input type="text" class="form-control" id="direccion" name="direccion"/>
                            </div>
                        </div>
                        <div class="form-group row d-none" id="divVencimiento">
                            <label  class="col-sm-3 col-form-label">Vencimiento:</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" id="vencimiento" name="vencimiento"/>
                            </div>                            
                        </div> 
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="card  border-secondary">
                      <h5 class="card-header ">DATOS DE REFERENCIA</h5>
                      <div class="card-body border border-info">
                        <div class="form-group row">
                            <label  class="col-sm-3 col-form-label">Moneda:</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="moneda" name="moneda">
                                        <?php foreach($monedas as $k=>$v){ ?>
                                            <option value="<?= $v["idmoneda"] ?>"><?= $v["nombre"]?></option>
                                        <?php }?>
                                </select>
                            </div>                           
                        </div>
                       
                        <div class="form-group row">
                            <label  class="col-sm-3 col-form-label">Guia Remision:</label>
                            <div class="col-sm-9">
                               <input type="text" class="form-control" id="guiaremision" name="guiaremision"/>
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label for="ordec" class="col-sm-3 col-form-label">Orden Compra:</label>
                            <div class="col-sm-9">
                               <input type="text" class="form-control" id="ordencompra" name="ordencompra"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-sm-3 col-form-label">Modalidad:</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="modalidad" id="modalidad">
                                    <option value="0">--Seleccione--</option>
                                    <option value="TODO COSTO">Todo Costo</option>
                                    <option value="MANO DE OBRA">Mano de Obra</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-sm-3 col-form-label">Tipo Contrato:</label>
                            <div class="col-sm-9">
                            <select class="form-control" id="tipocontrato" name="tipocontrato" onchange="verificarTipoContrato()">
                                <option value="0">--Seleccione--</option>
                                <option value="CUOTAS">CUOTAS</option>
                                <option value="SALDO CONTRA ENTREGA">SALDO CONTRA ENTREGA</option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group row d-none" id="divtiempocuotas">
                            <label  class="col-sm-3 col-form-label">Tiempo Cuotas:</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="tiempocuotas" name="tiempocuotas">
                                    <option value="0">--Seleccione--</option>
                                    <option value="SEMANAL">SEMANAL</option>
                                    <option value="QUINCENAL">QUINCENAL</option>
                                    <option value="MENSUAL">MENSUAL</option>
                                </select>
                            </div>                            
                        </div> 
                        <div class="form-group row">
                            <label for="ordec" class="col-sm-3 col-form-label">Tiempo Entrega:</label>
                            <div class="col-sm-9">
                               <input type="text" class="form-control" id="tiempoentrega" name="tiempoentrega"/>
                            </div>
                        </div>         
                      </div>
                    </div>
                  </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-6 mt-3">
                        <table class="table table-bordered table-hover table-sm text-sm table-striped table-responsive"
                                id="tablaProducto">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th>Stock</th>
                                    <th>Precio</th>
                                    <th>Agregar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($productos as $k=>$v){?>
                                <tr>
                                    <td><?= $v['codigobarra'] ?></td>
                                    <td><?= $v['nombre'] ?></td>
                                    <td><?= $v['stock'] ?></td>
                                    <td><?= $v['pventa'] ?></td>
                                    <td>
                                        <button 
                                        type="button" 
                                        class="btn btn-xs btn-success"
                                        onclick="AgregarProducto(<?= $v['idproducto'] ?>)"
                                        >Agregar</button>
                                    </td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-6">
                        <div id="divCarritoVenta">

                        </div>
                        <div align="right">
                            <button type="button" class="btn bg-maroon" onclick="LimpiarDetalleSesion()" >Limpiar Detalle</button>
                        </div>
                    </div>
                    <div class="col-12" align="center">
                        <button type="button" class="btn btn-primary" onclick="GuardarVenta()"><?= $textoBoton ?></button> 
                        <button type="button" class="btn btn-danger" onclick="CancelarVenta()">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- /.modal -->
<div class="modal fade" id="modalItem">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
        <div class="modal-header bg-primary">
            <h4 class="modal-title">Categoría</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="frmItem" name="frmItem">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group d-none">
                            <label>Código</label>
                            <input type="text" class="form-control" name="item_codigo" id="item_codigo" readonly />
                            <input type="hidden" name="item" id="item" />
                        </div>
                        <div class="form-group">
                            <label>Producto</label>
                            <input type="text" class="form-control" name="item_nombre" id="item_nombre" readonly />
                        </div>
                        <div class="form-group">
                            <label>Precio</label>
                            <input type="text" class="form-control" name="item_pventa" id="item_pventa" />
                        </div>
                        <div class="form-group">
                            <label>Cantidad (Stock <span id='spanStock'></span>)</label>
                            <input type="text" class="form-control" name="item_cantidad" id="item_cantidad" />
                        </div>
                        <div class="form-group">
                            <label>Descuento</label>
                            <input type="text" class="form-control" name="item_descuento" id="item_descuento" />
                        </div>                                                                                                                        
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" onclick="ActualizarItem()">Aceptar</button>
        </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div> 

<script>


<?php if($idventa>0){?>
    obtenerSeries(<?= $venta['idtipocomprobante']?>);
    $("#formapago").val('<?= $venta['formapago']?>');
    $("#vencimiento").val('<?= $venta['vencimiento']?>');
    $("#moneda").val('<?= $venta['idmoneda']?>');
    $("#guiaremision").val('<?= $venta['guiaremision']?>');
    $("#ordencompra").val('<?= $venta['ordencompra']?>');
    $("#modalidad").val('<?= $venta['modalidad']?>');
    $("#tipocontrato").val('<?= $venta['tipocontrato']?>');
    $("#tiempocuotas").val('<?= $venta['tiempocuotas']?>');
    $("#tiempoentrega").val('<?= $venta['tiempoentrega']?>');

    <?php if($cliente){ ?>
        $("#idtipodocumento").val("<?= $cliente['idtipodocumento'] ?>");
        $("#nrodocumento").val("<?= $cliente['nrodocumento'] ?>");
        $("#nombre").val("<?= $cliente['nombre'] ?>");
        $("#direccion").val("<?= $cliente['direccion'] ?>");
    <?php }?>

<?php }?>
function obtenerSeries(idtipocomprobante=0){
    $.ajax({
        method: "POST",
        url: "controlador/contVenta.php",
        data:{
            'proceso': "SERIES",
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
            <?php if($idventa>0){?>
            $("#serie").val('<?= $venta['serie'] ?>');
            $("#correlativo").val('<?= $venta['correlativo'] ?>');
            <?php }?>
        }else{
            obtenerCorrelativo();
        }
        
    });
}

function obtenerCorrelativo(){
    $.ajax({
        method: "POST",
        url: "controlador/contVenta.php",
        data:{
            'proceso': "OBTENER_CORRELATIVO",
            'idtipocomprobante': $("#idtipocomprobante").val(),
            'serie': $("#serie").val()
        }
    }).done(function(resultado){
        $("#correlativo").val(resultado);
    });    
}

function verificarFormaPago(){
    if($("#formapago").val()=="C"){
        $("#divVencimiento").addClass("d-none");
    }else{
        $("#divVencimiento").removeClass("d-none");
    }
}

function verificarTipoContrato(){
    if($("#tipocontrato").val()=="CUOTAS"){
        $("#divtiempocuotas").removeClass("d-none");
    }else{
        $("#divtiempocuotas").addClass("d-none");
    }
}

function BuscarClienteDocumento(){
    $.ajax({
        method: "POST",
        url: "controlador/contCliente.php",
        data: {
            proceso : "CONSULTAR_WS",
            idtipodocumento : $("#idtipodocumento").val(),
            nrodocumento : $("#nrodocumento").val()
        },
        dataType: "json"
    }).done(function(resultado){
       if(resultado["nombre"]!=""){
            toastCorrecto("Cliente localizado");        
            $("#idtipodocumento").val(resultado['idtipodocumento']);
            $("#nombre").val(resultado['nombre']);
            $("#direccion").val(resultado['direccion']);                    
       }else{
            msjError = "No se localizó cliente."
            toastError(msjError); 
       }
    });     
}

$('#tablaProducto').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "order":[[1,'asc']],
      "info": true,
      "autoWidth": false,
      "responsive": true
    });

function AgregarProducto(idproducto){
    $.ajax({
        method: "POST",
        url: "controlador/contVenta.php",
        data: {
            "proceso" : "AGREGAR_PRODUCTO",
            "idproducto": idproducto 
        }
    }).done(function(resultado){
       verCarrito();
    });  
}

function verCarrito(idventa=0){
    $.ajax({
            method: "POST",
            url: "controlador/contVenta.php",
            data: {
                "proceso" : "VER_CARRITO",
                "idventa" : idventa 
        }
    }).done(function(resultado){
        $("#divCarritoVenta").html(resultado);
    }); 
}

verCarrito(<?= $idventa ?>);

function LimpiarDetalleSesion(){
    $.ajax({
            method: "POST",
            url: "controlador/contVenta.php",
            data: {
                "proceso" : "ELIMINAR_CARRITO" 
        }
    }).done(function(resultado){
        verCarrito();
    });     
}

function ActualizarItem(){
    $.ajax({
            method: "POST",
            url: "controlador/contVenta.php",
            data: {
                "proceso" : "ACTUALIZAR_ITEM",
                "item"    : $("#item").val(),
                "pventa"  : $("#item_pventa").val(),
                "cantidad": $("#item_cantidad").val(),
                "descuento": $("#item_descuento").val()
        }
    }).done(function(resultado){        
        verCarrito();
        $("#modalItem").modal('hide');
    });  
}

function EliminarItem(item){
    $.ajax({
            method: "POST",
            url: "controlador/contVenta.php",
            data: {
                "proceso" : "ELIMINAR_ITEM",
                "item"    : item
        }
    }).done(function(resultado){
        verCarrito();
    });  
}

function EditarItem(item){
    $.ajax({
            method: "POST",
            url: "controlador/contVenta.php",
            data: {
                "proceso" : "OBTENER_ITEM",
                "item"    : item
            },
            dataType: "json"
    }).done(function(resultado){
            $("#item").val(item);
            $("#item_codigo").val(resultado.codigo);
            $("#item_nombre").val(resultado.nombre);
            $("#item_pventa").val(resultado.pventa);
            $("#item_cantidad").val(resultado.cantidad);
            $("#item_descuento").val(resultado.descuento);
            $("#spanStock").html(resultado.stock);
            $("#modalItem").modal('show');
    });  
}

function CancelarVenta(){
    <?php if($idventa>0){ ?>
        AbrirPagina('vista/ventas.php?limpiar_sesion=1');    
    <?php }else{ ?>
        AbrirPagina('vista/frmVentas.php?limpiar_sesion=1');
    <?php }?>
}

function GuardarVenta(){
    if(!ValidarFormulario()){
        return 0;
    }

    var datos_formulario = $("#frmVenta").serializeArray();
    
    if($("#idventa").val()!="" && $("#idventa").val()!="0"){
        datos_formulario.push({name: "proceso", value:"ACTUALIZAR"});
    }else{
        datos_formulario.push({name: "proceso", value:"NUEVO"});
    }

    $.ajax({
        method: "POST",
        url: "controlador/contVenta.php",
        data: datos_formulario,
        dataType: 'json'
    }).done(function(resultado){
        if(resultado.codigoError==1){
            window.open("vista/Venta/pdfProforma.php?id="+resultado.idventa,"_blank");
            toastCorrecto("Registro satisfactorio");                
            CancelarVenta();
        }else if(resultado.codigoError==99){
            toastError("Existe problemas de stock de algunos productos");  
            for(i=0;i<resultado.problemasStock.length;i++){
                $("#trcarrito"+resultado.problemasStock[i].item).addClass("bg-danger");
            }                   
       }else{
            msjError = resultado==2?"Venta duplicada":"No se pudo registrar la venta.";
            toastError(msjError); 
       }                
    });
}


function ValidarFormulario(){
    retorno = true;
    if($("#idtipocomprobante").val()=="" || $("#idtipocomprobante").val()=="0"){
        toastError('Especifique un documento de venta.');          
        retorno = false;
    }
    
    if($("#idtipocomprobante").val()=="01" && $("#idtipodocumento").val()!="6"){
        toastError('En las facturas debe especificar RUC.');          
        retorno = false;
    }

    if($("#idtipodocumento").val()==""){
        toastError('Seleccione Tipo de Docmuento Cliente.');          
        retorno = false;
    }

    if($("#nrodocumento").val()=="" || $("#nrodocumento").val()=="0"){
        toastError('Especifique un numero de Documneto .');          
        retorno = false;
    }

    if($("#modalidad").val()=="" || $("#modalidad").val()=="0"){
        toastError('Seleccione Modalidad de Trabjao .');          
        retorno = false;
    }

    if($("#tipocontrato").val()=="" || $("#tipocontrato").val()=="0"){
        toastError('Seleccione el Tipo de Contrato.');          
        retorno = false;
    }

    if($("#tipocontrato").val()=="" || $("#tipocontrato").val()=="0"){
        toastError('Seleccione el Tipo de Contrato.');          
        retorno = false;
    }


    return retorno;
}
</script>