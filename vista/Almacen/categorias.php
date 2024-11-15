<section class="content mt-2">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Categorías</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Nombre</span>
                            </div>
                            <input type="text" class="form-control" 
                              placeholder="Categoría" id="txtFiltroCategoria" name="txtFiltroCategoria"
                              >
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Estado</span>
                            </div>
                            <select class="form-control" id="cboFiltroEstado" name="cboFiltroEstado" onchange="listarCategorias();">
                                <option value="">Todos</option>
                                <option value="1">Activos</option>
                                <option value="0">Inactivos</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                     <button type="button" class="btn btn-info" onclick="listarCategorias();">Buscar</button> 
                     <button type="button" class="btn btn-warning" onclick="NuevaCategoria()">Nuevo</button>
                    </div>
                </div>
                <div id="divListado">

                </div>
            </div>
        </div>
    </div>
</section>

<!-- /.modal -->

<div class="modal fade" id="modalCategoria">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
        <div class="modal-header bg-primary">
            <h4 class="modal-title">Categoría</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="frmCategoria" name="frmCategoria">
                <div class="row callout callout-success" >
                    <div class="col-12">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" />
                            <input type="hidden" name="idcategoria" id="idcategoria" />
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
            <button type="button" class="btn btn-primary" onclick="GuardarCategoria()">Guardar</button>
        </div>
        </div>
        <!-- /.modal-content -->
    </div>
<!-- /.modal-dialog -->
</div>
<script>
function listarCategorias(){
  $.ajax({
    method: "POST",
    url: "vista/Almacen/categorias_listado.php",
    data: {
        filtro: $("#txtFiltroCategoria").val(),
        estado: $("#cboFiltroEstado").val() 
      }
  }).done(function(resultado){
      $("#divListado").html(resultado);
  })
}

listarCategorias();

function GuardarCategoria(){
    if(!ValidarFormulario()){
        return 0;
    }
    var datos_formulario = $("#frmCategoria").serializeArray();
    
    if($("#idcategoria").val()!="" && $("#idcategoria").val()!="0"){
        datos_formulario.push({name: "proceso", value:"ACTUALIZAR"});
    }else{
        datos_formulario.push({name: "proceso", value:"NUEVO"});
    }
    $.ajax({
        method: "POST",
        url: "controlador/contCategoria.php",
        data: datos_formulario
    }).done(function(resultado){
       if(resultado==1){
            SwalCorrecto('Datos Procesados Correctamente.')
            //toastCorrecto("Registro satisfactorio");        
            $("#modalCategoria").modal('hide');
            $("#frmCategoria").trigger('reset');        
            listarCategorias();                     
       }else{
            msjError = resultado==2?"Categoria duplicada":"No se pudo registrar la categoría."
            toastError(msjError); 
       }
    }); 

}

function ValidarFormulario(){
    retorno = true;
    if($("#nombre").val()==""){
        toastError('Ingrese el nombre de la categoría.');          
    retorno = false;
    }
    return retorno;
}

function NuevaCategoria(){
    $("#frmCategoria").trigger('reset');  
    $("#idcategoria").val("");  
    $("#modalCategoria").modal('show');
}
</script>