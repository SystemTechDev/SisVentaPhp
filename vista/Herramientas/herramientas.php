<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Bienes Materiales de la Empresa</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Herramientas</a></li>
              <li class="breadcrumb-item active">Herramientas</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
  </section>

<section class="content mt-2">
    <div class="container-fluid">
        <div class="card card-info ">
            <div class="card-header ">
                <h3 class="card-title">Listado de toda las Herramientas</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Nombre Material</span>
                            </div>
                            <input type="text" class="form-control" 
                              placeholder="Buscar" id="txtFiltroHerramienta" name="txtFiltroHerramienta"
                              >
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Estado</span>
                            </div>
                            <select class="form-control" id="cboFiltroEstado" name="cboFiltroEstado" onchange="listarHerramientas();">
                                <option value="">Todos</option>
                                <option value="1">Activos</option>
                                <option value="0">Inactivos</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                     <button type="button" class="btn btn-info" onclick="listarHerramientas();"><i class="fas fa-search"></i> Buscar</button> 
                     <button type="button" class="btn btn-success" onclick="NuevaHerramienta();"><i class="fas fa-file"></i> Nuevo Registro</button>
                    </div>
                </div>
                <div id="divListado">

                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="modalHerramienta" tabindex="-1" role="dialog">
    <div class="modal-dialog ">
        <div class="modal-content ">
        <div class="modal-header bg-info">
            <h4 class="modal-title">Herramienta</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="frmHerramienta" name="frmHerramienta">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>Nombre del Bien Material</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" />
                            <input type="hidden" name="idherramienta" id="idherramienta" />
                        </div>                       
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Marca</label>
                            <input type="text" class="form-control" name="marca" id="marca" />
                        </div>
                         <div class="form-group">
                            <label>Nº Serie</label>
                            <input type="text" class="form-control" name="serie" id="serie" />
                        </div>
                        <div class="form-group">
                            <label>Color</label>
                            <input type="text" class="form-control" name="color" id="color" />
                        </div>                        
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Modelo</label>
                            <input type="text" class="form-control" name="modelo" id="modelo" />
                        </div>
                         <div class="form-group">
                            <label>Descripcion</label>
                            <input type="text" class="form-control" name="descripcion" id="descripcion" />
                        </div>
                         <div class="form-group">
                            <label>Cantidad</label>
                            <input type="text" class="form-control" name="cantidad" id="cantidad" />
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
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
            <button type="button" class="btn btn-primary" onclick="GuardarHerramienta()"><i class="fas fa-save"></i> Guardar</button>
        </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>


<script>
 function listarHerramientas(){
  $.ajax({
    method: "POST",
    url: "vista/Herramientas/herramientas_listado.php",
    data: {
        filtro: $("#txtFiltroHerramienta").val(),
        estado: $("#cboFiltroEstado").val() 
      }
  }).done(function(resultado){
      $("#divListado").html(resultado);
  })
}

 listarHerramientas();

 function GuardarHerramienta(){
    if(!ValidarFormulario()){
        return 0;
    }
    var datos_formulario = $("#frmHerramienta").serializeArray();
    
    if($("#idherramienta").val()!="" && $("#idherramienta").val()!="0"){
        datos_formulario.push({name: "proceso", value:"ACTUALIZAR"});
    }else{
        datos_formulario.push({name: "proceso", value:"NUEVO"});
    }
    $.ajax({
        method: "POST",
        url: "controlador/contHerramienta.php",
        data: datos_formulario
    }).done(function(resultado){
       if(resultado==1){
            SwalCorrecto("Datos Procesados Correctamente");        
            $("#modalHerramienta").modal('hide');
            $("#frmHerramienta").trigger('reset');        
            listarHerramientas();                     
       }else{
            msjError = resultado==2?"Herramienta duplicada":"No se pudo registrar la Herramienta."
            SwalError(msjError); 
       }
    }); 

 }

 function ValidarFormulario(){
    retorno = true;
    if($("#nombre").val()==""){
        toastError('Ingrese el nombre de la Herramienta.');          
    retorno = false;
    }
    return retorno;
 }

 function NuevaHerramienta(){
    $("#frmHerramienta").trigger('reset');  
    $("#idherramienta").val("");  
    $("#modalHerramienta").modal('show');
 }


</script>

<div id="toastsContainerTopRight" class="toasts-top-right fixed"></div>