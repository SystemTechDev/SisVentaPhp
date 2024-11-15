<?php 
include_once("../../modelo/TipoDocumento.php");
$objTD = new TipoDocumento();
$documentos = $objTD->listarDocumentos();
?>
<section class="content mt-2">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Personal Empresa</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Nombres</span>
                            </div>
                            <input type="text" class="form-control" 
                              placeholder="Cliente" id="txtFiltroPersonal" name="txtFiltroPersonal"
                              >
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Estado</span>
                            </div>
                            <select class="form-control" id="cboFiltroEstado" name="cboFiltroEstado" onchange="listarPersonal();">
                                <option value="">Todos</option>
                                <option value="1">Activos</option>
                                <option value="0">Inactivos</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                     <button type="button" class="btn btn-info" onclick="listarPersonal();">Buscar</button> 
                     <button type="button" class="btn btn-warning" onclick="NuevoPersonal()">Nuevo</button>
                    </div>
                </div>
                <div id="divListado">

                </div>
            </div>
        </div>
    </div>
</section>

<!-- /.modal -->

<div class="modal fade" id="modalPersonal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header bg-info">
            <h4 class="modal-title">Personal</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="frmPersonal" name="frmPersonal">
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
                            <label>Apellidos y Nombres</label>
                            <input type="text" class="form-control" name="nombres" id="nombres" />
                            <input type="hidden" name="idpersonal" id="idpersonal" />
                        </div>
                        <div class="form-group">
                            <label>Correo</label>
                            <input type="text" class="form-control" name="correo" id="correo" />
                        </div>
                        <div class="form-group">
                            <label>Celular</label>
                            <input type="text" class="form-control" name="celular" id="celular" />
                        </div>
                        <div class="form-group">
                            <label>Sueldo</label>
                            <input type="text" class="form-control" name="sueldo" id="sueldo" />
                        </div>                              
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>N° de Documento</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="ndocumento" id="ndocumento" />
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-primary" onclick="BuscarPersonalDocumento()" >
                                        <span class="fas fa-search"></span>
                                    </button>
                                </span>
                            </div>        
                        </div> 
                        <div class="form-group">
                            <label>Facha Nac.</label>
                            <input type="date" class="form-control" name="fechanac" id="fechanac" />
                        </div>
                        <div class="form-group">
                            <label>Cargo en Empresa</label>
                            <select class="form-control" name="cargoempresa" id="cargoempresa">
                                
                                <option value="0">Seleccione..</option>
                                <option value="Administrativo">Administrativo</option>
                                <option value="Soldador">Soldador</option>
                                <option value="Operario">Operario</option>
                                <option value="Ayudante">Ayudante</option>
                                <option value="Otros">Otros</option>
                            </select>
                        </div>     
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
            <button type="button" class="btn btn-primary" onclick="GuardarPersonal()">Guardar</button>
        </div>
        </div>
        <!-- /.modal-content -->
    </div>
<!-- /.modal-dialog -->
</div>
<script>
function listarPersonal(){
  $.ajax({
    method: "POST",
    url: "vista/Personal/personal_listado.php",
    data: {
        filtro: $("#txtFiltroPersonal").val(),
        estado: $("#cboFiltroEstado").val() 
      }
  }).done(function(resultado){
      $("#divListado").html(resultado);
  })
}

listarPersonal();

function GuardarPersonal(){
    if(!ValidarFormulario()){
        return 0;
    }
    var datos_formulario = $("#frmPersonal").serializeArray();
    
    if($("#idpersonal").val()!="" && $("#idpersonal").val()!="0"){
        datos_formulario.push({name: "proceso", value:"ACTUALIZAR"});
    }else{
        datos_formulario.push({name: "proceso", value:"NUEVO"});
    }
    $.ajax({
        method: "POST",
        url: "controlador/contPersonal.php",
        data: datos_formulario
    }).done(function(resultado){
       if(resultado==1){
            toastCorrecto("Registro satisfactorio");        
            $("#modalPersonal").modal('hide');
            $("#frmPersonal").trigger('reset');        
            listarPersonal();                     
       }else{
            msjError = resultado==2?"Nro de documento duplicado":"No se pudo registrar el Personal."
            toastError(msjError); 
       }
    }); 

}

function ValidarFormulario(){
    retorno = true;
    if($("#nombres").val()==""){
        toastError('Ingrese el nombre del Trabjador.');              
        retorno = false;
    }

    if($("#idtipodocumento").val()=="1" && $("#ndocumento").val().length!=8){
        toastError("DNI debe tener 8 dígitos");
        retorno = false;
    }

    if($("#idtipodocumento").val()=="6" && $("#ndocumento").val().length!=11){
        toastError("RUC debe tener 11 dígitos");
        retorno = false;
    }
    return retorno;
}

function NuevoPersonal(){
    $("#frmPersonal").trigger('reset');  
    $("#idpersonal").val("");  
    $("#modalPersonal").modal('show');
}

function BuscarPersonalDocumento(){
    $.ajax({
        method: "POST",
        url: "controlador/contPersonal.php",
        data: {
            proceso : "CONSULTAR_WS",
            idtipodocumento : $("#idtipodocumento").val(),
            nrodocumento : $("#ndocumento").val()
        },
        dataType: "json"
    }).done(function(resultado){
       if(resultado["nombre"]!=""){
            toastCorrecto("Personal localizado");        
            $("#nombres").val(resultado['nombre']);
            $("#direccion").val(resultado['direccion']);                    
       }else{
            msjError = "No se localizó Personal."
            toastError(msjError); 
       }
    });     
}
</script>