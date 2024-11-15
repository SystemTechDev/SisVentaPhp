<?php
include_once("../../modelo/Asistencia.php");
include_once("../../modelo/Personal.php");

$objAsistencia = new Asistencia();
$opciones = $objAsistencia->listar(); 

$objPersonal = new Personal();
$personallista = $objPersonal->listartodos();
?>
<section class="content mt-2">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Asistencia de Personales de la Empresa</h3>
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
                     <button type="button" class="btn btn-info" onclick="listarAsistencias();"><i class="fas fa-search"></i> Buscar</button> 
                     <button type="button" class="btn btn-success" onclick="NuevoAsistencia();"><i class="fas fa-file-alt"></i> Nuevo</button>
                    </div>
                </div>
                <div id="divListado">

                </div>
            </div>
        </div>
    </div>
</section>

<!-- /.modal -->

<div class="modal fade" id="modalAsistencia">
    <div class="modal-dialog ">
        <div class="modal-content">
        <div class="modal-header bg-primary">
            <h4 class="modal-title">Registrar Asistencia</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="frmAsistencia" name="frmAsistencia">
                <div class="row">
                    <div class="col-12">
                        <input type="hidden" name="idasistencia" id="idasistencia" />
                        <div class="form-group">
                            <label>Trabajador Empresa</label>
                            <select class="form-control" name="personal_id" id="personal_id">
                                <option value="0">---Seleccione un Personal---</option>
                                <?php foreach($personallista as $k=>$v){?>
                                    <option value="<?= $v['idpersonal'] ?>"><?= $v['nombres'] ?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>  
                    <div class="col-6">    
                        <div class="form-group">
                            <label>Fecha</label>
                            <input type="date" class="form-control" name="fecha" id="fecha" />
                        </div>
                        <div class="form-group">
                            <label>Jornada Trabjado</label>
                            <select class="form-control" name="tiempo" id="tiempo">
                                <option value="0">--Seleccione--</option>
                                <option value="Completo">Completo</option>
                                <option value="Mediodia">Medio Dia</option>
                            </select>
                        </div>
                                           
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Asistio?</label>
                            <select class="form-control" name="asistio" id="asistio">
                                <option value="0">--Seleccione--</option>
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Estado</label>
                            <select class="form-control" name="estado" id="estado" readonly>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </div>    
                    <div class="col-12">         
                        <div class="form-group">
                            <label>Justificacion</label>
                            <textarea name="justificacion" id="justificacion" class="form-control" placeholder="Escriba aqui detalle que justifica el trabajo del Dia"></textarea>
                        </div>                        
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="GuardarAsistencia()"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
<!-- /.modal-dialog -->
</div>

<script>
function listarAsistencias(){
  $.ajax({
    method: "POST",
    url: "vista/Personal/asistencia_listado.php",
    data: {
        filtro: $("#txtFiltronombre").val(),
        fecha: $("#cboFiltrofecha").val() 
      }
  }).done(function(resultado){
      $("#divListado").html(resultado);
  })
}

listarAsistencias();

function GuardarAsistencia(){
    if(!ValidarFormulario()){
        return 0;
    }
    var datos_formulario = $("#frmAsistencia").serializeArray();
    
    if($("#idasistencia").val()!="" && $("#idasistencia").val()!="0"){
        datos_formulario.push({name: "proceso", value:"ACTUALIZAR"});
    }else{
        datos_formulario.push({name: "proceso", value:"NUEVO"});
    }
    $.ajax({
        method: "POST",
        url: "controlador/contAsistencia.php",
        data: datos_formulario
    }).done(function(resultado){
       if(resultado==1){
            SwalCorrecto("Datos Procesados Satisfactoriamente..");        
            $("#modalAsistencia").modal('hide');
            $("#frmAsistencia").trigger('reset');        
            listarAsistencias();                     
       }else{
            msjError = resultado==2?"Asistencia duplicado":"No se pudo registrar el Asistencia."
            SwalError(msjError); 
       }
    }); 

}

function ValidarFormulario(){
    retorno = true;
    if($("#personal_id").val()==""){
        toastError('Seleccione un Personal.');          
    retorno = false;
    }

    if($("#asistio").val()=="0"){
    toastError('Seleccione si el Personal Asistio .');          
    retorno = false;
    }
    return retorno;
}

function NuevoAsistencia(){
    $("#frmAsistencia").trigger('reset');  
    $("#idasistencia").val("");  
    $("#modalAsistencia").modal('show');
}
</script>