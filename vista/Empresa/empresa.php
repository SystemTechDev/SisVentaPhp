<?php 
include_once("../../modelo/Empresa.php");
$objEmpresa = new Empresa();

//$venta = $objVenta->consultarVenta($_GET['id']);
//$venta = $venta->fetch(PDO::FETCH_NAMED);

$listado = $objEmpresa->consultarEmpresa(1);

if($listado->rowCount()>0){
  $listado = $listado->fetch(PDO::FETCH_NAMED);
  //$listado = $listado[0];  
}
?>

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>CONFIGURACION DATOS DE LA EMPRESA</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Configuracion</a></li>
              <li class="breadcrumb-item active">Datos de la Empresa</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
</section>

<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid " src="imagenes/logo.png" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">LOGO EMPRESA</h3>
                <p class="text-muted text-center">Solo Png, Jpg</p>
                <a href="#" class="btn btn-primary btn-block"><b>Subir Logo</b></a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Conctatos</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                
                <strong><i class="fas fa-map-marker-alt mr-1"></i> Correo</strong>
                <p class="text-muted"><?= $listado['correo']; ?> </p>
                <hr>

                <strong><i class="fas fa-book mr-1"></i>Whatsapp - Celular</strong>
                <p class="text-muted"> <?= $listado['telefono']; ?> / <?= $listado['telefono']; ?> </p>
                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Ubicacion</strong>
                <p class="text-muted"><?= $listado['direccion']; ?> </p>
               
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                 
                  <H3 class="text-info" ><?= $listado['razon_social']; ?></H3> 
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="settings">
                    <form class="form-horizontal" id="frmEmpresa" name="frmEmpresa">
                        <div class="form-group row">
                        <input type="hidden" id="idemisor" name="idemisor">
                        <label for="inputName" class="col-sm-2 col-form-label">Tipo Doc :</label>
                        <div class="col-sm-10">
                          <select class="form-control" name="tipo_doc" id="tipo_doc">
                              <option value="6">RUC</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Nº DOC :</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="numero_doc" name="numero_doc" placeholder="Numero Docmuento">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Razon Social:</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="razon_social" name="razon_social" placeholder="Razon Social">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Nom Comercial:</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="nombre_comercial" name="nombre_comercial" placeholder="Nombre Comercial de la Empresa">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Correo:</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo empresa">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Telefono:</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Telefono">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Direccion</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" id="direccion" name="direccion" placeholder="Direccion"></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Otro:</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="otro" name="otro" placeholder="Lema">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox"> Acepto los <a href="#">Terminos y Condiciones</a>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="button" class="btn btn-info" onclick="GuardarEmpresa()">Guardar Configuracion</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>

<script>

function ValidarFormulario(){
    retorno = true;
    if($("#numero_doc").val()==""){
        toastError('Ingrese el Ruc es obligatorio');          
    retorno = false;
    }
    return retorno;
}

function GuardarEmpresa(){
    if(!ValidarFormulario()){
        return 0;
    }
    var datos_formulario = $("#frmEmpresa").serializeArray();
    
    if($("#idemisor").val()!="" && $("#idemisor").val()!="0"){
        datos_formulario.push({name: "proceso", value:"ACTUALIZAR"});
    }else{
        datos_formulario.push({name: "proceso", value:"NUEVO"});
    }
    $.ajax({
        method: "POST",
        url: "controlador/contEmpresa.php",
        data: datos_formulario
    }).done(function(resultado){
       if(resultado==1){
            toastCorrecto("Datos de la Empresa se Actualizaron Correctamente");        
            //$("#modalCliente").modal('hide');
            //$("#frmCliente").trigger('reset');        
            //listarClientes();
            EditarEmpresa();                     
       }else{
            msjError = resultado==2?"Nro de documento duplicado":"No se pudo registrar el empresa."
            toastError(msjError); 
       }
    }); 

}


function EditarEmpresa(idemisor){
    $.ajax({
        method: "POST",
        url: "controlador/contEmpresa.php",
        data:{
            'proceso': "CONSULTAR",
            'idemisor': idemisor
        },
        dataType: "json"
    }).done(function(resultado){
    //alert(resultado);       
        $("#tipo_doc").val(resultado.tipodoc);
        $("#numero_doc").val(resultado.ruc);
        $("#razon_social").val(resultado.razon_social);
        $("#nombre_comercial").val(resultado.nombre_comercial);
        $("#correo").val(resultado.correo);
        $("#telefono").val(resultado.telefono);
        $("#direccion").val(resultado.direccion);
        $("#otro").val(resultado.lema);
        $("#idemisor").val(resultado.id);
    });
}

EditarEmpresa(1);
</script>