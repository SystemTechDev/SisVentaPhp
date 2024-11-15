<?php 
include_once("../../modelo/TipoDocumento.php");
$objTD = new TipoDocumento();
$documentos = $objTD->listarDocumentos();
?>
<section class="content mt-2">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Clientes</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Nombre</span>
                            </div>
                            <input type="text" class="form-control" 
                              placeholder="Cliente" id="txtFiltroCliente" name="txtFiltroCliente"
                              >
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Estado</span>
                            </div>
                            <select class="form-control" id="cboFiltroEstado" name="cboFiltroEstado" onchange="listarClientes();">
                                <option value="">Todos</option>
                                <option value="1">Activos</option>
                                <option value="0">Inactivos</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                     <button type="button" class="btn btn-info" onclick="listarClientes();">Buscar</button> 
                     <button type="button" class="btn btn-warning" onclick="NuevoCliente()">Nuevo</button>
                    </div>
                </div>
                <div id="divListado">

                </div>
            </div>
        </div>
    </div>
</section>

<!-- /.modal -->

<div class="modal fade" id="modalCliente">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header bg-primary">
            <h4 class="modal-title">Cliente</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="frmCliente" name="frmCliente">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Tipo de Documento</label>
                            <select class="form-control" name="idtipodocumento" id="idtipodocumento">
                                <?php foreach($documentos as $k=>$v){ ?>
                                <option value="<?= $v['idtipodocumento'];?>"><?= $v['nombre'] ?></option>                                
                                <?php }?>
                            </select>
                        </div>    
                        <div class="form-group">
                            <label>N° de Documento</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="nrodocumento" id="nrodocumento" />
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-primary" onclick="BuscarClienteDocumento()" >
                                        <span class="fas fa-search"></span>
                                    </button>
                                </span>
                            </div>        
                        </div> 
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" />
                            <input type="hidden" name="idcliente" id="idcliente" />
                        </div>                        
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Direccion</label>
                            <textarea rows="6" class="form-control" name="direccion" id="direccion"></textarea>
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
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" onclick="GuardarCliente()">Guardar</button>
        </div>
        </div>
        <!-- /.modal-content -->
    </div>
<!-- /.modal-dialog -->
</div>
<script>
function listarClientes(){
  $.ajax({
    method: "POST",
    url: "vista/Venta/clientes_listado.php",
    data: {
        filtro: $("#txtFiltroCliente").val(),
        estado: $("#cboFiltroEstado").val() 
      }
  }).done(function(resultado){
      $("#divListado").html(resultado);
  })
}

listarClientes();

function GuardarCliente(){
    if(!ValidarFormulario()){
        return 0;
    }
    var datos_formulario = $("#frmCliente").serializeArray();
    
    if($("#idcliente").val()!="" && $("#idcliente").val()!="0"){
        datos_formulario.push({name: "proceso", value:"ACTUALIZAR"});
    }else{
        datos_formulario.push({name: "proceso", value:"NUEVO"});
    }
    $.ajax({
        method: "POST",
        url: "controlador/contCliente.php",
        data: datos_formulario
    }).done(function(resultado){
       if(resultado==1){
            toastCorrecto("Registro satisfactorio");        
            $("#modalCliente").modal('hide');
            $("#frmCliente").trigger('reset');        
            listarClientes();                     
       }else{
            msjError = resultado==2?"Nro de documento duplicado":"No se pudo registrar el cliente."
            toastError(msjError); 
       }
    }); 

}

function ValidarFormulario(){
    retorno = true;
    if($("#nombre").val()==""){
        toastError('Ingrese el nombre del cliente.');              
        retorno = false;
    }

    if($("#idtipodocumento").val()=="1" && $("#nrodocumento").val().length!=8){
        toastError("DNI debe tener 8 dígitos");
        retorno = false;
    }

    if($("#idtipodocumento").val()=="6" && $("#nrodocumento").val().length!=11){
        toastError("RUC debe tener 11 dígitos");
        retorno = false;
    }
    return retorno;
}

function NuevoCliente(){
    $("#frmCliente").trigger('reset');  
    $("#idcliente").val("");  
    $("#modalCliente").modal('show');
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
            $("#nombre").val(resultado['nombre']);
            $("#direccion").val(resultado['direccion']);                    
       }else{
            msjError = "No se localizó cliente."
            toastError(msjError); 
       }
    });     
}
</script>