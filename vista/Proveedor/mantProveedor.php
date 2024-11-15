<?php 
$accion = $_GET['accion'];
$id = ''; $tipopersona = ''; $nombres = ''; $apellidos = ''; $dni = ''; $ruc = ''; $razon_social = ''; $direccion = ''; $telefono = '';
if ($accion == 'ACTUALIZAR') {
	$id = $_GET['id'];
	require_once('../../modelo/clsProveedor.php');
	$objproveedor = new clsProveedor();
	$data = $objproveedor->consultarById($id);
	$dato = $data->fetch(PDO::FETCH_NAMED);
	$id = $dato['id'];
	$tipopersona = $dato['tipopersona'];
	$nombres = $dato['nombres'];
	$apellidos = $dato['apellidos'];
	$dni = $dato['dni'];
	$ruc = $dato['ruc'];
	$razon_social = $dato['razon_social'];
	$direccion = $dato['direccion'];
	$telefono = $dato['telefono'];
}
?>

<div class="col-md-12">
<form id="frmProveedor" name="frmProveedor">
<input type="hidden" name="accion" id="accion" value="<?php echo $accion; ?>">
<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
<div class="card-body">
	<div class="form-group">
  	<label for="tipopersona" >Tipo Persona</label>
  	<select class="form-control" id="tipopersona" name="tipopersona" onchange="cambiartipopersona();">
      <option value="P" <?php if( ($tipopersona != '') && ($tipopersona == 'P') ){ echo 'selected="selected"'; } ?> >PERSONA</option>
      <option value="E" <?php if( ($tipopersona != '') && ($tipopersona == 'E') ){ echo 'selected="selected"'; } ?> >EMPRESA</option>
    </select>
  </div>
  <div class="form-group" id="divNombres">
    <label for="nombres" >Nombres</label>
    <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Ingrese Nombres" value="<?php echo $nombres; ?>">
  </div>
  <div class="form-group"  id="divApellidos">
    <label for="apellidos" >Apellidos</label>
    <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Ingrese apellidos" value="<?php echo $apellidos; ?>">
  </div>
  <div class="form-group" id="divRazon_social">
    <label for="razon_social" >Razon Social</label>
    <input type="text" class="form-control" id="razon_social" name="razon_social" placeholder="Ingrese Razon Social" value="<?php echo $razon_social; ?>">
  </div>
  <div class="form-group" id="divDni">
    <label for="dni" >DNI</label>
    <input type="text" class="form-control" id="dni" name="dni" placeholder="Ingrese DNI" value="<?php echo $dni; ?>">
  </div>
  <div class="form-group" id="divRuc">
    <label for="ruc" >RUC</label>
    <input type="text" class="form-control" id="ruc" name="ruc" placeholder="Ingrese RUC" value="<?php echo $ruc; ?>">
  </div>
  <div class="form-group">
    <label for="direccion" >Direccion</label>
    <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Ingrese Direccion" value="<?php echo $direccion; ?>">
  </div>
  <div class="form-group">
    <label for="telefono" >Telefono</label>
    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Ingrese Telefono" value="<?php echo $telefono; ?>">
  </div>
  	
</div>
<!-- /.card-body -->

<div class="card-footer text-center">
	<button type="button" id="btnGuardar" class="btn btn-info"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
	<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa-solid fa-xmark"></i> Cerrar</button>
  
</div>
</form>
</div>
<script type="text/javascript">
	$(document).ready(function() {
    cambiartipopersona();
	});

	$("#btnGuardar").click(function(){
			if(validar_proveedor() == true){
				guardarProveedor();
			}
    });

	function cambiartipopersona() {
		let tipopersona = $("#tipopersona").val();
		if (tipopersona == 'P') {
			$("#divNombres").show();
			$("#divApellidos").show();
			$("#divDni").show();
			$("#divRuc").hide();
			$("#divRazon_social").hide();
		}else if(tipopersona == 'E'){
			$("#divNombres").hide();
			$("#divApellidos").hide();
			$("#divDni").hide();
			$("#divRuc").show();
			$("#divRazon_social").show();
		}
	}

	function validar_proveedor() {
		let mensaje = 'Corregir los siguientes errores: \n';
		let respuesta = true;

		let tipopersona = $("#tipopersona").val();

		if (tipopersona == 'P') {
			if($("#nombres").val() == ''){
				mensaje = mensaje + '\t Debe Ingresar un nombres \n';
				respuesta = false;
			}
			if($("#apellidos").val() == ''){
				mensaje = mensaje + '\t Debe Ingresar un apellidos \n';
				respuesta = false;
			}
			if($("#dni").val() == ''){
				mensaje = mensaje + '\t Debe Ingresar un dni \n';
				respuesta = false;
			}
		}else if(tipopersona == 'E'){
			if($("#razon_social").val() == ''){
				mensaje = mensaje + '\t Debe Ingresar una Razon Social \n';
				respuesta = false;
			}
			if($("#ruc").val() == ''){
				mensaje = mensaje + '\t Debe Ingresar un ruc \n';
				respuesta = false;
			}
		}	

		if($("#direccion").val() == ''){
			mensaje = mensaje + '\t Debe Ingresar una direccion \n';
			respuesta = false;
		}

		if($("#telefono").val() == ''){
			mensaje = mensaje + '\t Debe Ingresar un telefono \n';
			respuesta = false;
		}

		if(respuesta == false){
			alert(mensaje);
		}

		return respuesta;
	}
</script>