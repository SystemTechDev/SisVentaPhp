<?php 
include_once("../../modelo/Venta.php");
$objVen = new Venta();
$desde = $_POST['desde'];
$hasta = $_POST['hasta'];
$cliente = $_POST['cliente'];
$listado = $objVen->obtenerReporteVentas($desde, $hasta,"%".$cliente."%");

$meses = array('1'=>"Ene", "2"=>"Feb","3"=>"Mar","4"=>"Abr","5"=>"May","6"=>"Jun",
                "7"=>"Jul","8"=>"Ago","9"=>"Set","10"=>"Oct","11"=>"Nov","12"=>"Dic");
$colores = array('1'=>'#f56954','2'=>'#00a65a', '3'=>'#f39c12', '4'=>'#00c0ef', 
                '5'=>'#3c8dbc','6'=>'#d2d6de','7'=>'#f56954','8'=>'#00a65a', '9'=>'#f39c12', 
                '10'=>'#00c0ef','11'=>'#3c8dbc','12'=>'#d2d6de');

$labels = array();
$datos = array();
$background = array();

foreach($listado as $k=>$v){
    $labels[]=$meses[$v['mes']]."-".substr($v['anio'],2,2);
    $datos[] = $v['total'];
    $background[] = $colores[$v['mes']];
}
?>
<!-- BAR CHART -->
<div class="card card-success">
    <div class="card-header">
    <h3 class="card-title">Reporte de Ventas</h3>

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
</div>
<!-- /.card -->


<!-- PIE CHART -->
<div class="card card-danger">
    <div class="card-header">
    <h3 class="card-title">Porcentaje de Ventas</h3>

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
    <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->

<script>
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


//-------------
//- PIE CHART -
//-------------

var donutData        = {
      labels: [<?= "'".implode("','",$labels)."'" ?>],
      datasets: [
        {
          data: [<?= implode(",",$datos) ?>],
          backgroundColor : [<?= "'".implode("','",$background)."'" ?>],
        }
      ]
    }


// Get context with jQuery - using jQuery's .get() method.
var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
var pieData        = donutData;
var pieOptions     = {
    maintainAspectRatio : false,
    responsive : true,
}
//Create pie or douhnut chart
// You can switch between pie and douhnut using the method below.
new Chart(pieChartCanvas, {
    type: 'pie',
    data: pieData,
    options: pieOptions
})



</script>