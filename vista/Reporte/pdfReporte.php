<?php 
define('FPDF_FONTPATH','font/'); 
require_once('../../fpdf/fpdf.php');
require_once('../../modelo/Venta.php');

$objVenta = new Venta();

$desde = $_GET['desde'];
$hasta = $_GET['hasta'];
$cliente = $_GET['cliente'];
$listado = $objVenta->obtenerReporteVentas($desde, $hasta,"%".$cliente."%");

$meses = array('1'=>"Ene", "2"=>"Feb","3"=>"Mar","4"=>"Abr","5"=>"May","6"=>"Jun",
                "7"=>"Jul","8"=>"Ago","9"=>"Set","10"=>"Oct","11"=>"Nov","12"=>"Dic");

$pdf = new FPDF();
$pdf->AddPage('P','A4');
$pdf->SetFont('Arial','B',12);

$pdf->Cell(80,6,utf8_decode("AÑO - MES"),1,0,'C',0);
$pdf->Cell(80,6,"TOTAL DE VENTAS",1,1,'C',0);

foreach($listado as $k=>$v){
    $aniomes = $meses[$v['mes']]."-".substr($v['anio'],2,2);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(80,6,$aniomes,1,0,'C',0);
    $pdf->Cell(80,6,$v['total'],1,1,'C',0);
}

$pdf->Output('I','ReporteVenta.pdf');
?>