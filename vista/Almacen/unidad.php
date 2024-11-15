<section class="content mt-2">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Unidad de Medida</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Descripcion</span>
                            </div>
                            <input type="text" class="form-control" 
                              placeholder="Descripcion U.M" id="txtFiltroUnidad" name="txtFiltroUnidad"
                              >
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Estado</span>
                            </div>
                            <select class="form-control" id="cboFiltroEstado" name="cboFiltroEstado" onchange="listarUnidad();">
                                <option value="">Todos</option>
                                <option value="1">Activos</option>
                                <option value="0">Inactivos</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                     <button type="button" class="btn btn-info" onclick="listarUnidad();">Buscar</button> 
                     <button type="button" class="btn btn-warning" onclick="NuevaUnidad()">Nuevo</button>
                    </div>
                </div>
                <div id="divListado">

                </div>
            </div>
        </div>
    </div>
</section>

<!-- /.modal -->

<div class="modal fade" id="modalUnidad">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
        <div class="modal-header bg-primary">
            <h4 class="modal-title">Unidad Medida</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="frmUnidad" name="frmUnidad">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>U.M</label>
                            <input type="text" class="form-control" name="idunidad" id="idunidad" />
                            <input type="hidden"  class="form-control" name="id" id="id" />
                        </div>
                        <div class="form-group">
                            <label>Descripcion</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" />
                            
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
            <button type="button" class="btn btn-primary" onclick="GuardarUnidad()">Guardar</button>
        </div>
        </div>
        <!-- /.modal-content -->
    </div>
<!-- /.modal-dialog -->
</div>
<script>
function listarUnidad(){
  $.ajax({
    method: "POST",
    url: "vista/Almacen/unidad_listado.php",
    data: {
        filtro: $("#txtFiltroUnidad").val(),
        estado: $("#cboFiltroEstado").val() 
      }
  }).done(function(resultado){
      $("#divListado").html(resultado);
  })
}

listarUnidad();

function GuardarUnidad(){
    if(!ValidarFormulario()){
        return 0;
    }
    var datos_formulario = $("#frmUnidad").serializeArray();
    
    if($("#id").val()!="" && $("#id").val()!="0"){
        datos_formulario.push({name: "proceso", value:"ACTUALIZAR"});
    }else{
        datos_formulario.push({name: "proceso", value:"NUEVO"});
    }
    $.ajax({
        method: "POST",
        url: "controlador/contUnidad.php",
        data: datos_formulario
    }).done(function(resultado){
       if(resultado==1){
            toastCorrecto("Registro satisfactorio");        
            $("#modalUnidad").modal('hide');
            $("#frmUnidad").trigger('reset');        
            listarUnidad();                     
       }else{
            msjError = resultado==2?"Unidad duplicada":"No se pudo registrar la Unidad."
            toastError(msjError); 
       }
    }); 

}

function ValidarFormulario(){
    retorno = true;
    if($("#nombre").val()==""){
        toastError('Ingrese el nombre de la Unidad.');          
    retorno = false;
    }
    return retorno;
}

function NuevaUnidad(){
    $("#frmUnidad").trigger('reset');  
    $("#id").val("");  
    $("#modalUnidad").modal('show');
}
</script>