<?php
include_once("../../modelo/Adelanto.php");
include_once("../../modelo/Personal.php");
$objAdelanto = new Adelanto();
$opciones = $objAdelanto->listar(); 


$objPersonal = new Personal();
$personallista = $objPersonal->listartodos();
?>
<section class="content mt-2">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Adelanto Sueldo</h3>
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
                     <button type="button" class="btn btn-info" onclick="listarAdelantos();">Buscar</button> 
                     <button type="button" class="btn btn-warning" onclick="NuevoAdelanto()">Nuevo</button>
                    </div>
                </div>
                <div id="divListado">

                </div>
            </div>
        </div>
    </div>
</section>

<!-- /.modal -->

<div class="modal fade" id="modalAdelanto">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
        <div class="modal-header bg-primary">
            <h4 class="modal-title">Adelantos</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="frmAdelanto" name="frmAdelanto">
                <div class="row">
                    <div class="col-12">
                        <input type="hidden" name="idadelanto" id="idadelanto" />
                        <div class="form-group">
                            <label>Trabajador</label>
                            <select class="form-control" name="personal_id" id="personal_id">
                                <option value="0">Seleccione un Personal</option>
                                <?php foreach($personallista as $k=>$v){?>
                                    <option value="<?= $v['idpersonal'] ?>"><?= $v['nombres'] ?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Fecha</label>
                            <input type="date" class="form-control" name="fecha" id="fecha" />
                        </div>
                        <div class="form-group">
                            <label>Monto?</label>
                            <input type="text" class="form-control" name="monto" id="monto" />
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
            <button type="button" class="btn btn-primary" onclick="GuardarAdelanto()">Guardar</button>
        </div>
        </div>
        <!-- /.modal-content -->
    </div>
<!-- /.modal-dialog -->
</div>


<script>
function listarAdelantos(){
  $.ajax({
    method: "POST",
    url: "vista/Personal/adelanto_listado.php",
    data: {
        filtro: $("#txtFiltronombre").val(),
        fecha: $("#cboFiltrofecha").val() 
      }
  }).done(function(resultado){
      $("#divListado").html(resultado);
  })
}

listarAdelantos();

function GuardarAdelanto(){
    if(!ValidarFormulario()){
        return 0;
    }
    var datos_formulario = $("#frmAdelanto").serializeArray();
    
    if($("#idadelanto").val()!="" && $("#idadelanto").val()!="0"){
        datos_formulario.push({name: "proceso", value:"ACTUALIZAR"});
    }else{
        datos_formulario.push({name: "proceso", value:"NUEVO"});
    }
    $.ajax({
        method: "POST",
        url: "controlador/contAdelanto.php",
        data: datos_formulario
    }).done(function(resultado){
       if(resultado==1){
            toastCorrecto("Registro satisfactorio");        
            $("#modalAdelanto").modal('hide');
            $("#frmAdelanto").trigger('reset');        
            listarAdelantos();                     
       }else{
            msjError = resultado==2?"Adelanto duplicado":"No se pudo registrar el Adelanto."
            toastError(msjError); 
       }
    }); 

}

function ValidarFormulario(){
    retorno = true;
    if($("#personal_id").val()==""){
        toastError('Ingrese Personal.');          
    retorno = false;
    }
    return retorno;
}

function NuevoAdelanto(){
    $("#frmAdelanto").trigger('reset');  
    $("#idadelanto").val("");  
    $("#modalAdelanto").modal('show');
}
</script>