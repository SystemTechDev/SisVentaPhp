<section class="content mt-2">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Inventario</h3>
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
                                <option value="1">Con problemas de stock</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                     <button type="button" class="btn btn-info" onclick="listarProductos();">Buscar</button> 
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
            <h4 class="modal-title">Movimientos de Producto</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="detalle_inventario">
            
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
function listarProductos(){
  $.ajax({
    method: "POST",
    url: "vista/Inventario/inventario_listado.php",
    data: {
        filtro: $("#txtFiltroProducto").val(),
        estado: $("#cboFiltroEstado").val() 
      }
  }).done(function(resultado){
      $("#divListado").html(resultado);
  })
}

listarProductos();

</script>