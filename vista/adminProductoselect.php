<?php 
require_once("../modelo/Categoria.php");
$objcategoriaproducto = new Categoria();
$data = $objcategoriaproducto->listar('','');
?>
<section class="content">
  <div class="container-fluid">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <!--<h3 class="card-title">Icons</h3> -->
        <div class="row">
            <div class="col-sm-4">
            <input type="text" class="form-control" id="busquedanombreproducto" name="busquedanombreproducto" placeholder="Nombre" onkeyUp="if(event.keyCode=='13'){buscarProducto(); }"> 
            </div>
            <div class="col-sm-4">
            <select class="form-control" id="busquedacategoria" name="busquedacategoria" onchange="buscarProducto();">
              <option value="">TODAS LAS CATEGORIAS</option>
              <?php 
              while($dato = $data->fetch(PDO::FETCH_NAMED)){ 
              ?>
                <option value="<?php echo $dato['idcategoria']; ?>"><?php echo $dato['nombre']; ?></option>
              <?php  
              }
              ?>
            </select> 
            </div>
            <div class="col-sm-4">
              <button type="button" id="btnBuscar" class="btn btn-success" onclick="buscarProducto();"><i class="fa fa-search"></i>Buscar</button>
              <!--<button type="button" id="btnNuevo" class="btn btn-primary" onclick="nuevoProducto();"><i class="fa  fa-plus"></i>Nuevo</button>-->
            </div>
        </div>
          
        
      </div>
      <div class="row text-center" id="divMantProducto">
        
      </div>
      <!-- /.card-body -->
      <div class="card-body" id="divListadoProducto">
        
      </div><!-- /.card-body -->
      <div class="card-footer text-center">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
 
<script type="text/javascript">
  function buscarProducto() {
    let nombre = $("#busquedanombreproducto").val();
    let categoriaproducto_id = $("#busquedacategoria").val();
    cargar('divListadoProducto','vista/listadoProductoselect.php?nombre='+nombre+'&categoriaproducto_id='+categoriaproducto_id);
  }



  function nuevoProducto() {
    //$("#divMantProducto").show();
    //cargar('divMantProducto','presentacion/mantProducto.php?accion=REGISTRAR');
    ViewModal('vista/mantProducto.php?accion=REGISTRAR','divModalMediano','Registro de Nuevo Producto');
  }

  function editarProducto(id) {
    //$("#divMantProducto").show();
    //cargar('divMantProducto','presentacion/mantProducto.php?accion=ACTUALIZAR&id='+id);
    ViewModal('vista/mantProducto.php?accion=ACTUALIZAR&id='+id,'divModalMediano','Actualizar Producto');
  }

  function guardarProducto() {
    $.ajax({
      url:'controlador/contProducto.php',
      type: 'POST',
      data: $('#frmProducto').serialize()
    }).done(function (respuesta) {
      //alert(respuesta); 
      if (respuesta == 'OK') {
        alert("DATOS PROCESADOS CORRECTAMENTE");
        buscarProducto();
        //$("#divMantProducto").hide();
        CloseModal('divModalMediano');
      }else{
        alert(respuesta);
      }
        
    })
  }

  buscarProducto();
</script>