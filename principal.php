<?php
include_once("modelo/Perfil.php");
include_once("modelo/Venta.php");
include_once("modelo/Usuario.php");

if(!isset($_SESSION['idusuario'])){
  header("Location: index.php");
}

$objPer = new Perfil();
$opciones = $objPer->obtenerAcceso($_SESSION['idperfil']);

$objVenta = new Venta();
$ventasDia = $objVenta->obtenerVentasDelDia(date("Y-m-d"));
if($ventasDia->rowCount()>0){
  $ventasDia = $ventasDia->fetch(PDO::FETCH_NUM);
  $ventasDia = $ventasDia[0];
}else{
  $ventasDia = 0;
}

$ventasDelMes = $objVenta->obtenerVentasDelMes(date('Y'), date('m'));
if($ventasDelMes->rowCount()>0){
  $ventasDelMes = $ventasDelMes->fetch(PDO::FETCH_NUM);
  $ventasDelMes = $ventasDelMes[0];
}else{
  $ventasDelMes = 0;
}

$objUsu = new Usuario();

$usuariosActivos = $objUsu->totalUsuariosActivos();
if($usuariosActivos->rowCount()>0){
  $usuariosActivos = $usuariosActivos->fetch(PDO::FETCH_NUM);
  $usuariosActivos = $usuariosActivos[0];  
}else{
  $usuariosActivos = 0;
}

$cantidadVentaDia = $objVenta->cantidadVentasDelDia(date("Y-m-d"));
if($cantidadVentaDia->rowCount()>0){
  $cantidadVentaDia = $cantidadVentaDia->fetch(PDO::FETCH_NUM);
  $cantidadVentaDia = $cantidadVentaDia[0];
}else{
  $cantidadVentaDia = 0;
}

$ventasPorMes = $objVenta->obtenerReporteVentas(date('Y-01-01'), date('Y-m-d'),"%%");
$meses = array('1'=>"Ene", "2"=>"Feb","3"=>"Mar","4"=>"Abr","5"=>"May","6"=>"Jun",
                "7"=>"Jul","8"=>"Ago","9"=>"Set","10"=>"Oct","11"=>"Nov","12"=>"Dic");
$labels = array();
$datos = array();
foreach($ventasPorMes as $k=>$v){
  $labels[]=$meses[$v['mes']]."-".substr($v['anio'],2,2);
  $datos[] = $v['total'];
}                
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistema Integrado | SERVICE/METAL</title>

  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Google Font: Source Sans Pro -->
  <!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> -->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <!--<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">

  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
  <!-- fileinput -->
  <link rel="stylesheet" href="plugins/fileinput/css/fileinput.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="imagenes/logo_systemtech.jpg" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-teal navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="principal.php" class="nav-link">Inicio</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php" class="nav-link">Salir</a>
      </li>
    </ul>

  <ul class="navbar-nav ml-auto">

    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
      <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>
 
</ul>
</nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="imagenes/logo_systemtech.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Sistema Integrado</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?= $_SESSION['nombre'];?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->

   <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <?php $categoriamenu_id = '';
            while($dato = $opciones->fetch(PDO::FETCH_NAMED))
            { 
              if ($categoriamenu_id != $dato['categoriamenu_id'])
              {
                  if ($categoriamenu_id != '')
                    { ?>
      </ul>
      </li>
              <?php } ?>
                <li id="navlinkmenu" class="nav-item">
                  <a href="#" class="nav-link ">
                    <i class="<?php echo $dato['icono']; ?>"></i>
                    <p>
                      <?php echo $dato['nombre']; ?>
                      <i class="right fas fa-angle-left"></i>
                     <!-- <span class="badge badge-info right">6</span> -->
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a  href="#" id="navlinksubmenu" onclick="AbrirPagina('<?php echo $dato['url']; ?>');" class="nav-link ">
                        <i class="far fa-circle nav-icon"></i>
                        <p><?php echo $dato['descripcion']; ?></p>
                      </a>
                    </li>
                <?php
                $categoriamenu_id = $dato['categoriamenu_id'];
              }else{
                ?>
                  <li class="nav-item">
                    <a href="#" id="anavitem" onclick="AbrirPagina('<?php echo $dato['url']; ?>');" class="nav-link ">
                      <i class="far fa-circle nav-icon"></i>
                      <p><?php echo $dato['descripcion']; ?></p>
                    </a>
                  </li>
                <?php
              }
            }

            if ($categoriamenu_id != '') {
          ?>
                  </ul>
                </li>
              <?php
            }
          ?>
        </ul>
      </nav>
    
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="divPrincipal">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= $ventasDia;?></h3>

                <p>Ventas del Día</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer" onclick="AbrirPagina('vista/ventas.php')">Más info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?= $ventasDelMes ?></h3>

                <p>Ventas del Mes</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer" onclick="AbrirPagina('vista/ventas.php')">Más info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?= $usuariosActivos ?></h3>

                <p>Usuarios Activos</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer" onclick="AbrirPagina('vista/usuarios.php')">Más info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?= $cantidadVentaDia ?></h3>

                <p>Cantidad de Ventas</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer" onclick="AbrirPagina('vista/ventas.php')">Más info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- BAR CHART -->
        <div class="card card-success">
            <div class="card-header">
            <h3 class="card-title">Ventas Mensual del <?= date('Y'); ?></h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
                </button>
            </div>
            </div>
            <div class="card-body">
            <div class="chart">
                <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            </div>
            <!-- /.card-body -->
        <!-- /.card -->          
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
  <strong>Copyright &copy; 2018-2022 <a href="https://systemtech.net">SystemTech </a>.</strong>
    Todo los Derechos Reservados.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.2.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- /.modal de confirmacion-->
<div class="modal fade" id="modalConfirmacion">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
        <div class="modal-header bg-info">
            <h4 class="modal-title">Confirmar</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="mensaje_confirmacion">
            ¿Está seguro de Anular la categoría?
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            <div id="boton_confirmacion">
                
            </div>
        </div>
        </div>
        <!-- /.modal-content -->
    </div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- MODALES PARA EL PROVEEDOR Y COMPRAS -->

<div class="modal fade bs-example-modal-sm" id="divModalMediano" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          
          <h4 class="modal-title" id="divModalMedianoTitulo">Título</h4>
          <button tabindex="12222" type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body" id="divModalMedianoContenido">
          ...
        </div>
        <!--
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary">Guardar</button>
        </div>-->
      </div>
    </div>
</div>

<div class="modal fade bs-example-modal-lg" id="divlibre" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="divlibreTitulo">Título</h4>
          <button tabindex="10000" type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
        </div>
        <div class="modal-body" id="divlibreContenido">
      ...
        </div>
      </div>
    </div>
</div>

<div class="modal fade bs-example-modal-sm" id="divConfirmar" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" >
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="divConfirmarTitulo">Título</h4>
          <button tabindex="10000" type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
        </div>
        <div class="modal-body" id="divConfirmarContenido">
          ...
        </div>
        <div class="modal-footer" id="divConfirmarFooter">
          <button type="button" class="btn btn-primary" id="divConfirmarAceptar">Aceptar</button>
          <button type="button" class="btn btn-danger" id="divConfirmarCancelar" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>    
</div>
<!-- FIN DE LOS MODALES PARA EL PROVEEDOR Y COMPRAS-->



<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- File Input-->
<script src="plugins/fileinput/js/fileinput.js"></script>
<script src="plugins/fileinput/js/fileinput_locale_es.js"></script>

<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<script>
  function AbrirPagina(urlx){
      $.ajax({
        method: 'POST',
        url: urlx
      }).done(function(retorno){
          
          $("#divPrincipal").html(retorno);
      });
      
  }

    $("a.nav-link").click(function(){
      $('a.nav-link').removeClass("active");
      $(this).addClass("active");
    });

  function mostrarModalConfirmacion(mensaje, accion){
      $("#mensaje_confirmacion").html(mensaje);

      btn_html = '<button type="button" class="btn btn-primary" onclick="CerrarModalConfirmacion();'+accion+'">Confirmar</button>';

      $("#boton_confirmacion").html(btn_html);
      $("#modalConfirmacion").modal("show");
  }

  function CerrarModalConfirmacion(){
    $("#modalConfirmacion").modal("hide");
  }

   function SwalCorrecto(title) {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true
    });

    Toast.fire({
      icon: 'success',
      title: title
    })
  };

     function SwalError(title) {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true
    });

    Toast.fire({
      icon: 'error',
      title: title
    })
  };

  function toastCorrecto(mensaje){
    $(document).Toasts('create', {
        title: 'Correcto',
        class: 'bg-success',
        autohide: true,
        delay: 3000,
        body: mensaje
    });
  }

  function toastError(mensaje){
    $(document).Toasts('create', {
        title: 'Error',
        class: 'bg-danger',
        autohide: true,
        delay: 3000,
        body: mensaje
    });
  }


  //FUNCIONES DEL PROVEEDOR Y COMPRAS

  function cargar(div,url) {
    $('#'+div).load(url);
  }

  function ViewModal(page,divmodal,title){
    $('#'+divmodal).on('show.bs.modal', function(e) {
      document.getElementById(divmodal+"Titulo").innerHTML=title;
      cargar(divmodal+'Contenido',page);
      $(e.currentTarget).unbind();
      $('#'+divmodal).on('hidden.bs.modal', function (e) {
        document.getElementById(divmodal+"Titulo").innerHTML='';
        document.getElementById(divmodal+'Contenido').innerHTML="...";
        $("#"+divmodal+"Aceptar").prop("onclick",'');
        $(e.currentTarget).unbind();
      });
    }).modal({
      keyboard: false,
      backdrop: 'static'
    });
  }

  function CloseModal(divmodal){
    $('#'+divmodal).modal('hide');  
  }

  function NuevoConfirmar(text,accionOk){
    var divmodal='divConfirmar';
    var icon="fa-question-circle";
    
    $('#'+divmodal).on('hidden.bs.modal', function (e) {
      $(e.currentTarget).unbind();
      document.getElementById(divmodal+"Titulo").innerHTML='';
      document.getElementById(divmodal+'Contenido').innerHTML="...";    
    }).on('show.bs.modal', function(e) {
      document.getElementById(divmodal+"Titulo").innerHTML='<i class="fa '+icon+'"></i> Confirmar';
      document.getElementById(divmodal+"Contenido").innerHTML=text;
      $("#"+divmodal+"Aceptar").attr("onclick",accionOk+';CloseModal("'+divmodal+'");');
    }).modal("show"); 
  }


var areaChartData = {
labels  : [<?= "'".implode("','",$labels)."'" ?>],
datasets: [
    {
        label               : 'Ventas',
        backgroundColor     : 'rgba(60,141,188,0.9)',
        borderColor         : 'rgba(60,141,188,0.8)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        data                : [<?= implode(",",$datos) ?>]
    }
    /*,
    {
        label               : 'Electronics',
        backgroundColor     : 'rgba(210, 214, 222, 1)',
        borderColor         : 'rgba(210, 214, 222, 1)',
        pointRadius         : false,
        pointColor          : 'rgba(210, 214, 222, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(220,220,220,1)',
        data                : [65, 59, 80, 81, 56, 55, 40]
    },*/
    ]
}

//-------------
//- BAR CHART -
//-------------
var barChartCanvas = $('#barChart').get(0).getContext('2d')
var barChartData = $.extend(true, {}, areaChartData)
var temp0 = areaChartData.datasets[0]
//var temp1 = areaChartData.datasets[1]
barChartData.datasets[0] = temp0
//barChartData.datasets[1] = temp1

var barChartOptions = {
    responsive              : true,
    maintainAspectRatio     : false,
    datasetFill             : false
}

new Chart(barChartCanvas, {
    type: 'bar',
    data: barChartData,
    options: barChartOptions
})


</script>
</body>
</html>
