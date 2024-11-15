<?php
include_once("../../modelo/Perfil.php");
$objPer = new Perfil();
$opciones = $objPer->listarOpciones(); 
?>
<section class="content mt-2">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Perfiles</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Nombre</span>
                            </div>
                            <input type="text" class="form-control" 
                              placeholder="Perfil" id="txtFiltroPerfil" name="txtFiltroPerfil"
                              >
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Estado</span>
                            </div>
                            <select class="form-control" id="cboFiltroEstado" name="cboFiltroEstado" onchange="listarPerfiles();">
                                <option value="">Todos</option>
                                <option value="1">Activos</option>
                                <option value="0">Inactivos</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                     <button type="button" class="btn btn-info" onclick="listarPerfiles();">Buscar</button> 
                     <button type="button" class="btn btn-warning" onclick="NuevoPerfil()">Nuevo</button>
                    </div>
                </div>
                <div id="divListado">

                </div>
            </div>
        </div>
    </div>
</section>

<!-- /.modal -->

<div class="modal fade" id="modalPerfil">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
        <div class="modal-header bg-primary">
            <h4 class="modal-title">Perfil</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="frmPerfil" name="frmPerfil">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" />
                            <input type="hidden" name="idperfil" id="idperfil" />
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
            <button type="button" class="btn btn-primary" onclick="GuardarPerfil()">Guardar</button>
        </div>
        </div>
        <!-- /.modal-content -->
    </div>
<!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalAcceso">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
        <div class="modal-header bg-primary">
            <h4 class="modal-title"><span id="spanNombrePerfil"></span></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="frmAcceso">
                <div class="row">                
                    <div class="col-12">
                        <input type="hidden" id="idperfilacceso" />
                        <table class="table table-sm table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>*</th>
                                    <th>Opcion</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($opciones as $k=>$v){ ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" value="" id="cb<?= $v['idopcion']; ?>" onclick="VerificarAcceso(<?= $v['idopcion']; ?>)" />
                                        </td>
                                        <td>
                                           <?= $v['descripcion'];?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>                        
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
        </div>
        <!-- /.modal-content -->
    </div>
<!-- /.modal-dialog -->
</div>

<script>
function listarPerfiles(){
  $.ajax({
    method: "POST",
    url: "vista/Administracion/perfiles_listado.php",
    data: {
        filtro: $("#txtFiltroPerfil").val(),
        estado: $("#cboFiltroEstado").val() 
      }
  }).done(function(resultado){
      $("#divListado").html(resultado);
  })
}

listarPerfiles();

function GuardarPerfil(){
    if(!ValidarFormulario()){
        return 0;
    }
    var datos_formulario = $("#frmPerfil").serializeArray();
    
    if($("#idperfil").val()!="" && $("#idperfil").val()!="0"){
        datos_formulario.push({name: "proceso", value:"ACTUALIZAR"});
    }else{
        datos_formulario.push({name: "proceso", value:"NUEVO"});
    }
    $.ajax({
        method: "POST",
        url: "controlador/contPerfil.php",
        data: datos_formulario
    }).done(function(resultado){
       if(resultado==1){
            toastCorrecto("Registro satisfactorio");        
            $("#modalPerfil").modal('hide');
            $("#frmPerfil").trigger('reset');        
            listarPerfiles();                     
       }else{
            msjError = resultado==2?"Perfil duplicado":"No se pudo registrar el perfil."
            toastError(msjError); 
       }
    }); 

}

function ValidarFormulario(){
    retorno = true;
    if($("#nombre").val()==""){
        toastError('Ingrese el nombre del perfil.');          
    retorno = false;
    }
    return retorno;
}

function NuevoPerfil(){
    $("#frmPerfil").trigger('reset');  
    $("#idperfil").val("");  
    $("#modalPerfil").modal('show');
}
</script>