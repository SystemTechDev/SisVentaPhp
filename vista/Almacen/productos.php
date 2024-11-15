<?php 
include_once("../../modelo/Unidad.php");
include_once("../../modelo/Categoria.php");
include_once("../../modelo/Afectacion.php");

$objUnd = new Unidad();
$unidades = $objUnd->listarUnidad();

$objCat = new Categoria();
$categorias = $objCat->listar('%%',1);

$objAfe = new Afectacion();
$afectacion = $objAfe->listarAfectacion();
?>
<section class="content mt-2">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Productos</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Nombre</span>
                            </div>
                            <input type="text" class="form-control" 
                              placeholder="Producto" id="txtFiltroProducto" name="txtFiltroProducto"
                              >
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Estado</span>
                            </div>
                            <select class="form-control" id="cboFiltroEstado" name="cboFiltroEstado" onchange="listarProductos();">
                                <option value="">Todos</option>
                                <option value="1">Activos</option>
                                <option value="0">Inactivos</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                     <button type="button" class="btn btn-info" onclick="listarProductos();">Buscar</button> 
                     <button type="button" class="btn btn-warning" onclick="NuevoProducto()">Nuevo</button>
                    </div>
                </div>
                <div id="divListado">

                </div>
            </div>
        </div>
    </div>
</section>

<!-- /.modal -->

<div class="modal fade" id="modalProducto">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header bg-primary">
            <h4 class="modal-title">Producto</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="frmProducto" name="frmProducto">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" />
                            <input type="hidden" name="idproducto" id="idproducto" />
                        </div>
                        <div class="form-group">
                            <label>Código de Barra</label>
                            <input type="text" class="form-control" name="codigobarra" id="codigobarra" />
                        </div>
                        <div class="form-group">
                            <label>Precio de Compra</label>
                            <input type="text" class="form-control" name="pcompra" id="pcompra" />
                        </div>
                        <div class="form-group">
                            <label>Precio de Venta</label>
                            <input type="text" class="form-control" name="pventa" id="pventa" />
                        </div>
                    </div>
                    <div class="col-4">                          
                        <div class="form-group">
                            <label>Stock</label>
                            <input type="text" class="form-control" name="stock" id="stock" />
                        </div>
                        <div class="form-group">
                            <label>Stock de Seguridad</label>
                            <input type="text" class="form-control" name="stockseguridad" id="stockseguridad" />
                        </div>                        
                        <div class="form-group">
                            <label>Unidad</label>
                            <select class="form-control" name="idunidad" id="idunidad">
                                <option value="0">Seleccione uno</option>
                                <?php foreach($unidades as $k=>$v){?>
                                    <option value="<?= $v['idunidad'] ?>"><?= $v['descripcion'] ?></option>
                                <?php }?>
                            </select>
                        </div>  
                        <div class="form-group">
                            <label>Categoría</label>
                            <select class="form-control" name="idcategoria" id="idcategoria">
                                <option value="0">Seleccione uno</option>
                                <?php foreach($categorias as $k=>$v){?>
                                    <option value="<?= $v['idcategoria'] ?>"><?= $v['nombre'] ?></option>
                                <?php }?>
                            </select>
                        </div>  
                        </div>
                    <div class="col-4">
                    <div class="form-group">
                            <label>Afectación</label>
                            <select class="form-control" name="idafectacion" id="idafectacion">
                                <option value="0">Seleccione uno</option>
                                <?php foreach($afectacion as $k=>$v){?>
                                    <option value="<?= $v['idafectacion'] ?>"><?= $v['descripcion'] ?></option>
                                <?php }?>
                            </select>
                        </div>                                                                                                                                                                          
                        <div class="form-group">
                            <label>¿Afecto al ICBPER?</label>
                            <select class="form-control" name="afectoicbper" id="afectoicbper">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
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
            <button type="button" class="btn btn-primary" onclick="GuardarProducto()">Guardar</button>
        </div>
        </div>
        <!-- /.modal-content -->
    </div>
<!-- /.modal-dialog -->
</div>



<div class="modal fade" id="modalImagen">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header bg-primary">
            <h4 class="modal-title">ACTUALIZAR IMAGEN DEL PRODUCTO</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12">
                <div class="form-group">
                        <label>Producto..</label>
                        <input type="text" class="form-control" name="nombre_imagen" id="nombre_imagen" readonly />
                        <input type="hidden" name="idproducto_imagen" id="idproducto_imagen" value="0" />
                    </div>
                    <div class="form-group">
                        <label>URL Imagen</label>
                        <input type="text" class="form-control" name="urlimagen" id="urlimagen" readonly />
                    </div>
                    <form enctype="multipart/form-data">
                        <div class="form-group">
	                       <input name="uploadFile" id="uploadFile" class="file-loading" type="file" multiple data-min-file-count="1">
                        </div>
                    </form>                                               
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
           <!-- <button type="button" class="btn btn-primary" onclick="GuardarImagen()">Guardar</button>-->
        </div>
        </div>
        <!-- /.modal-content -->
    </div>
<!-- /.modal-dialog -->
</div>

<script>
function listarProductos(){
  $.ajax({
    method: "POST",
    url: "vista/Almacen/productos_listado.php",
    data: {
        filtro: $("#txtFiltroProducto").val(),
        estado: $("#cboFiltroEstado").val() 
      }
  }).done(function(resultado){
      $("#divListado").html(resultado);
  })
}

listarProductos();

function GuardarProducto(){
    if(!ValidarFormulario()){
        return 0;
    }
    var datos_formulario = $("#frmProducto").serializeArray();
    
    if($("#idproducto").val()!="" && $("#idproducto").val()!="0"){
        datos_formulario.push({name: "proceso", value:"ACTUALIZAR"});
    }else{
        datos_formulario.push({name: "proceso", value:"NUEVO"});
    }
    $.ajax({
        method: "POST",
        url: "controlador/contProducto.php",
        data: datos_formulario
    }).done(function(resultado){
       if(resultado==1){
            toastCorrecto("Registro satisfactorio");        
            $("#modalProducto").modal('hide');
            $("#frmProducto").trigger('reset');        
            listarProductos();                     
       }else{
            msjError = resultado==2?"Producto duplicado":"No se pudo registrar el producto.";
            msjError = resultado==3?"Codigo de Barra duplicado":msjError;
            toastError(msjError); 
       }
    }); 

}

function ValidarFormulario(){
    retorno = true;
    if($("#nombre").val()==""){
        toastError('Ingrese el nombre del producto.');          
    retorno = false;
    }
    return retorno;
}

function NuevoProducto(){
    $("#frmProducto").trigger('reset');
    $("#idproducto").val("");  
    $("#modalProducto").modal('show');
}

function DefinirFileInput(){
    $("#uploadFile").fileinput({
		language: 'es',
		showRemove: false,
		uploadAsync: true,
		uploadExtraData: {
            proceso: 'ACTUALIZAR_IMAGEN', 
            idproducto: $("#idproducto_imagen").val()
        },
		uploadUrl: 'controlador/contProducto.php',
		maxFileCount: 1,
		autoReplace: true, 
		allowedFileExtensions: ['jpg','png']
    }).on('fileuploaded', function(event, data, id, index) {
        $("#modalImagen").modal('hide');
        listarProductos();
        $('#uploadFile').fileinput('destroy');
    });
}

</script>