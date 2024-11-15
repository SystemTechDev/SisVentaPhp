<?php
include_once("../../modelo/Adelanto.php");
include_once("../../modelo/Personal.php");
include_once("../../modelo/Herramienta.php");

$objAdelanto = new Adelanto();
$opciones = $objAdelanto->listar(); 

$objPersonal = new Personal();
$personallista = $objPersonal->listartodos();

$objHerramienta = new Herramienta();
$herramientalista = $objHerramienta->listartodos();
?>
<section class="content mt-2">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Prestamo de Materiales</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Nombre</span>
                            </div>
                            <input type="text" class="form-control" id="txtFiltronombre" name="txtFiltronombre"
                              >
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Fecha</span>
                            </div>
                            <input type="date" class="form-control" id="cboFiltrofecha" name="cboFiltrofecha"
                              >
                        </div>
                    </div>
                    <div class="col-4">
                     <button type="button" class="btn btn-info" onclick="listarPrestamos();"><i class="fas fa-search"></i> Buscar</button> 
                     <button type="button" class="btn btn-success" onclick="NuevoPrestamo();"><i class="fas fa-file-alt"></i> Nuevo</button>
                    </div>
                </div>
                <div id="divListado">

                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modalPrestamo">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title">Prestamos de Materiales</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmPrestamo" name="frmPrestamo">
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" name="idprestamo" id="idprestamo" />
                            <div class="form-group">
                                <label>Trabajador Responsable</label>
                                <select class="form-control" name="personal_id" id="personal_id">
                                    <option value="0">---Seleccione un Personal---</option>
                                    <?php foreach($personallista as $k=>$v){?>
                                        <option value="<?= $v['idpersonal'] ?>"><?= $v['nombres'] ?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Bien Material</label>
                                <select class=" form-control select2bs4" style="width: 100%; " name="herramienta_id" id="herramienta_id">
                                    <?php foreach($herramientalista as $k=>$v){?>
                                        <option value="<?= $v['idherramienta'] ?>"><?= $v['nombre']."-".$v['descripcion'] ?></option>
                                    <?php }?>
                                </select>
                            </div>                   
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Fecha Entrega</label>
                                <input type="date" class="form-control" name="fechaentrega" id="fechaentrega" value="<?= date('Y-m-d') ?>" />
                            </div>
                            <div class="form-group">
                                <label>Cantidad?</label>
                                <input type="text" class="form-control" name="cantidad" id="cantidad" />
                            </div>                          
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Fecha Devolucion </label>
                                <input type="date" class="form-control" name="fechadevolucion" id="fechadevolucion" value="<?= date('Y-m-d') ?>" />
                            </div>
                            <div class="form-group">
                                <label>Estado</label>
                                <select class="form-control" name="estado" id="estado">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>                           
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Observacion de Prestamo del Material</label>
                                <input type="text" class="form-control" name="observacion_entrega" id="observacion_entrega" />
                            </div>                           
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="GuardarPrestamo()"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPrestamoDevolucion">
    <div class="modal-dialog modal-sm ">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title">Devolucion</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmPrestamoDevolucion" name="frmPrestamoDevolucion">
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" name="idprestamodev" id="idprestamodev" />
                            <div class="form-group">
                                <label>Fecha Devolucion</label>
                                <input type="datetime" class="form-control" name="fechadevuelto" id="fechadevuelto" />
                            </div>
                            <!--<div class="form-group">
                                <label>Hora Devolucion</label>
                                <input type="time" value="<?= date("H:i:s") ?>" class="form-control" name="horadevuelto" id="horadevuelto" />
                            </div> -->
                            <div class="form-group">
                                <label>Observacion de la Devolucion</label>
                                <textarea class="form-control" name="observacion_devolucion" id="observacion_devolucion"> </textarea>
                                
                            </div>                           
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="GuardarDevolucion()"><i class="fas fa-reply-all"></i> Devolucion</button>
            </div>
        </div>
    </div>
</div>

<script>
function listarPrestamos(){
  $.ajax({
    method: "POST",
    url: "vista/Herramientas/prestamos_listado.php",
    data: {
        filtro: $("#txtFiltronombre").val(),
        fecha: $("#cboFiltrofecha").val() 
      }
  }).done(function(resultado){
      $("#divListado").html(resultado);
  })
}

listarPrestamos();

function GuardarPrestamo(){
    if(!ValidarFormulario()){
        return 0;
    }
    var datos_formulario = $("#frmPrestamo").serializeArray();
    
    if($("#idprestamo").val()!="" && $("#idprestamo").val()!="0"){
        datos_formulario.push({name: "proceso", value:"ACTUALIZAR"});
    }else{
        datos_formulario.push({name: "proceso", value:"NUEVO"});
    }
    $.ajax({
        method: "POST",
        url: "controlador/contPrestamo.php",
        data: datos_formulario
    }).done(function(resultado){
       if(resultado==1){
            SwalCorrecto("Datos Procesados Con Exito..!");        
            $("#modalPrestamo").modal('hide');
            $("#frmPrestamo").trigger('reset');        
            listarPrestamos();                     
       }else{
            msjError = resultado==2?"Prestamo duplicado":"No se pudo registrar el Prestamo."
            SwalError(msjError); 
       }
    }); 

}

function GuardarDevolucion(){
    if(!ValidarFormulario()){
        return 0;
    }
    var datos_formulario = $("#frmPrestamoDevolucion").serializeArray();
    
    if($("#idprestamodev").val()!="" && $("#idprestamodev").val()!="0"){
        datos_formulario.push({name: "proceso", value:"ACTUALIZAR_DEVOLUCION"});
    }else{
        datos_formulario.push({name: "proceso", value:"NUEVO"});
    }
    $.ajax({
        method: "POST",
        url: "controlador/contPrestamo.php",
        data: datos_formulario
    }).done(function(resultado){
       if(resultado==1){
            SwalCorrecto("Datos Procesados Con Exito..!");        
            $("#modalPrestamoDevolucion").modal('hide');
            $("#frmPrestamoDevolucion").trigger('reset');        
            listarPrestamos();                     
       }else{
            msjError = resultado==2?"Prestamo duplicado":"No se pudo registrar el Prestamo."
            SwalError(msjError); 
       }
    }); 

}

function ValidarFormulario(){
    retorno = true;
    if($("#personal_id").val()==""){
        SwalError('Seleccione un Personal.');          
    retorno = false;
    }
    if($("#herramienta_id").val()==""){
        SwalError('Seleccione Herramienta.');          
    retorno = false;
    }
    return retorno;
}

function NuevoPrestamo(){
    $("#frmPrestamo").trigger('reset');  
    $("#idprestamo").val("");  
    $("#modalPrestamo").modal('show');
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
}
/*
  $(function () {
    //Initialize Select2 Elements
    //$('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

  })*/
</script>

