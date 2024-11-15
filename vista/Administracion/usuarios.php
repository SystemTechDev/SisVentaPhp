<?php 
include_once("../../modelo/Perfil.php");
$objPer = new Perfil();
$perfiles = $objPer->listar("%%",1);
?>
<section class="content mt-2">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Usuario</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Nombre</span>
                            </div>
                            <input type="text" class="form-control" 
                              placeholder="Nombre" id="txtFiltroUsuario" name="txtFiltroUsuario"
                              >
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Estado</span>
                            </div>
                            <select class="form-control" id="cboFiltroEstado" name="cboFiltroEstado" onchange="listarUsuarios();">
                                <option value="">Todos</option>
                                <option value="1">Activos</option>
                                <option value="0">Inactivos</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                     <button type="button" class="btn btn-info" onclick="listarUsuarios();">Buscar</button> 
                     <button type="button" class="btn btn-warning" onclick="NuevoUsuario()">Nuevo</button>
                    </div>
                </div>
                <div id="divListado">

                </div>
            </div>
        </div>
    </div>
</section>

<!-- /.modal -->

<div class="modal fade" id="modalUsuario">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
        <div class="modal-header bg-primary">
            <h4 class="modal-title">Usuario</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="frmUsuario" name="frmUsuario">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" />
                            <input type="hidden" name="idusuario" id="idusuario" />
                        </div>
                        <div class="form-group">
                            <label>Usuario</label>
                            <input type="text" class="form-control" name="usuario" id="usuario" />
                        </div>  
                        <div class="form-group">
                            <label>Clave</label>
                            <input type="password" class="form-control" name="clave" id="clave" />
                        </div>
 
                        <div class="form-group">
                            <label>Perfil</label>
                            <select class="form-control" id="idperfil" name="idperfil">
                                <option value="0">Seleccione uno</option>
                                <?php foreach($perfiles as $k=>$v){ ?>
                                <option value="<?= $v["idperfil"] ?>"><?= $v["nombre"] ?></option>
                                <?php }?>
                            </select>
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
            <button type="button" class="btn btn-primary" onclick="GuardarUsuario()">Guardar</button>
        </div>
        </div>
        <!-- /.modal-content -->
    </div>
<!-- /.modal-dialog -->
</div>
<script>
function listarUsuarios(){
  $.ajax({
    method: "POST",
    url: "vista/Administracion/usuarios_listado.php",
    data: {
        filtro: $("#txtFiltroUsuario").val(),
        estado: $("#cboFiltroEstado").val() 
      }
  }).done(function(resultado){
      $("#divListado").html(resultado);
  })
}

listarUsuarios();

function GuardarUsuario(){
    if(!ValidarFormulario()){
        return 0;
    }
    var datos_formulario = $("#frmUsuario").serializeArray();
    
    if($("#idusuario").val()!="" && $("#idusuario").val()!="0"){
        datos_formulario.push({name: "proceso", value:"ACTUALIZAR"});
    }else{
        datos_formulario.push({name: "proceso", value:"NUEVO"});
    }
    $.ajax({
        method: "POST",
        url: "controlador/contUsuario.php",
        data: datos_formulario
    }).done(function(resultado){
       if(resultado==1){
            toastCorrecto("Registro satisfactorio");        
            $("#modalUsuario").modal('hide');
            $("#frmUsuario").trigger('reset');        
            listarUsuarios();                     
       }else{
            msjError = resultado==2?"Usuario duplicado":"No se pudo registrar el usuario."
            toastError(msjError); 
       }
    }); 

}

function ValidarFormulario(){
    retorno = true;
    if($("#nombre").val()==""){
        toastError('Ingrese el nombre del usuario.');          
    retorno = false;
    }
    if($("#usuario").val()==""){
        toastError('Ingrese el usuario.');          
    retorno = false;
    }    
    return retorno;
}

function NuevoUsuario(){
    $("#frmUsuario").trigger('reset');  
    $("#idusuario").val("");  
    $("#modalUsuario").modal('show');
}
</script>