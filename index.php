<?php 
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistema POS</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page" style="background-image: url('imagenes/wallpaper10.jpg'); background-size:cover">
<div class="text-center">
  <img src="imagenes/logo.png" height="150px" width="150px">
</div>
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <img src="imagenes/logo_systemtech.jpg" class="img-md" >
      <a href="#" class="h1"><b>SYSTEM</b>TECH</a>
    </div>
    <div class="card-body">
      <h5 class="login-box-msg text-info">Acceso al Sistema</h5>

      <form name="frmLogin" id="frmLogin" action="" method="POST">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Usuario" name="usuario" id="usuario">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Clave" name="clave" id="clave">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row" id="cuadrado">
          <div class="col-12">
            <button type="button" class="btn btn-primary btn-block" onclick="IngresarSistema()"><i class="fas fa-sign-in-alt"></i> Ingresar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <!-- /.social-auth-links -->
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script>
    function IngresarSistema(){
        usuario = $('#usuario').val();
        clave = $('#clave').val();
        
        $.ajax({
          method: "POST",
          url: "controlador/contUsuario.php",
          data: {
                'proceso'  : 'LOGIN',
                'usuario' : usuario,
                'clave'   : clave
              }
        }).done(function(resultado){
            if(resultado=="1"){
                window.open("principal.php","_self");
            }else{
              alert("Usuario o clave incorrecta");
            }
        });
    }
</script>
</body>
</html>
