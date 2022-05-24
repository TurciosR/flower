<?php
error_reporting(E_ERROR | E_PARSE);
require("_core.php");
require("num2letras.php");
require('fpdf/fpdf.php');


$pdf=new fPDF('P','mm', 'Letter');
$pdf->SetMargins(10,5);
$pdf->SetTopMargin(2);
$pdf->SetLeftMargin(10);
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,1);
$pdf->AddFont("latin","","latin.php");
$id_sucursal = $_SESSION["id_sucursal"];
$sql_empresa = "SELECT * FROM sucursal WHERE id_sucursal='$id_sucursal'";

$resultado_emp=_query($sql_empresa);
$row_emp=_fetch_array($resultado_emp);
$nombre_a = utf8_decode(Mayu(utf8_decode(trim($row_emp["descripcion"]))));
//$direccion = Mayu(utf8_decode($row_emp["direccion_empresa"]));
$direccion = utf8_decode(Mayu(utf8_decode(trim($row_emp["direccion"]))));
$nrc = $row_emp['nrc'];
$nit = $row_emp['nit'];
$whatsapp=$row_emp["whatsapp"];
$email=$row_emp["email"];
$depa = $row_emp["id_departamento"];
$muni = $row_emp["id_municipio"];
$telefono1 = $row_emp["telefono1"];
$telefono2 = $row_emp["telefono2"];

$sql2 = _query("SELECT dep.* FROM departamento as dep WHERE dep.id_departamento='$depa'");
$row2 = _fetch_array($sql2);
$departamento = $row2["nombre_departamento"];

$sql3 = _query("SELECT mun.* FROM municipio as mun WHERE dep.id_municipio='$muni'");
$row3 = _fetch_array($sql3);
$municipio = $row3["nombre_municipio"];

$iftike = $_REQUEST["tiket"];
if($iftike == 1)
{
  $extra = "";
}
else
{
    $extra = " AND tipo_documento != 'TIK'";
}
$min = $_REQUEST["l"];
$fini = ($_REQUEST["fini"]);
$fin = ($_REQUEST["fecha"]);
$fini1 = $_REQUEST["fini"];
$fin1 = $_REQUEST["fecha"];
$logo = "img/logo_sys.png";

$title = $nombre_a;
$titulo = "REPORTE DE COSTOS UTILIDAD";
if($fini!="" && $fin!="")
{
    list($a,$m,$d) = explode("-", $fini);
    list($a1,$m1,$d1) = explode("-", $fin);
    if($a ==$a1)
    {
        if($m==$m1)
        {
            $fech="DEL $d AL $d1 DE ".meses($m)." DE $a";
        }
        else
        {
            $fech="DEL $d DE ".meses($m)." AL $d1 DE ".meses($m1)." DE $a";
        }
    }
    else
    {
        $fech="DEL $d DE ".meses($m)." DEL $a AL $d1 DE ".meses($m1)." DE $a1";
    }
}
$impress = "REPORTE DE COSTO UTILIDAD ".$fech;


$existenas = "";
if($min>0)
{
    $existenas = "CANTIDAD: $min";
}

$pdf->AddPage();
$pdf->SetFont('latin','',10);
//$pdf->Image($logo,8,4,30,25);
$set_x = 5;
$set_y = 6;

    //Encabezado General
    //Encabezado General
$pdf->SetFont('latin','',16);
$pdf->SetXY($set_x, $set_y);
$pdf->MultiCell(220,6,$title,0,'C',0);
$pdf->SetXY($set_x, $set_y+11);
$pdf->SetFont('latin','',8);
$pdf->Cell(220,5,utf8_decode(ucwords(("Depto. ".utf8_decode($departamento)))),0,1,'C');
$pdf->SetXY($set_x+68, $set_y+5);
$pdf->MultiCell(85,3.5,str_replace(" Y ", " y ",ucwords(utf8_decode(($direccion)))).", San Miguel",0,'C',0);
$pdf->SetXY($set_x, $set_y+14);
$pdf->Cell(220,5,Mayu("PBX: ".$telefono1." / ".$telefono2),0,1,'C');
$plus = 0;
$pdf->SetXY($set_x, $set_y+17-$plus);
$pdf->Cell(220,5,utf8_decode(ucwords("WhatsApp: ").$whatsapp),0,1,'C');
$pdf->SetXY($set_x, $set_y+20-$plus);
$pdf->Cell(220,5,utf8_decode("E-mail: ".$email),0,1,'C');
$pdf->SetXY($set_x, $set_y+23);
$pdf->Cell(220,6,utf8_decode($titulo),0,1,'C');
$pdf->SetXY($set_x, $set_y+26);
$pdf->Cell(220,6,$fech,0,1,'C');

    ///////////////////////////////////////////////////////////////////////

$set_x = 5;
$set_y = 45;

$n=1;
$pdf->SetFont('latin','',8);
$pdf->SetXY($set_x, $set_y);

$pdf->Cell(20,5,utf8_decode("Nº"),0,1,'C',0);
$pdf->SetXY($set_x+20,$set_y);
$pdf->Cell(77,5,utf8_decode("FECHA"),0,1,'C',0);
$pdf->SetXY($set_x+115,$set_y);
$pdf->Cell(18,5,utf8_decode("COSTO"),0,1,'C',0);
$pdf->SetXY($set_x+133,$set_y);
$pdf->Cell(18,5,utf8_decode("VENTA"),0,1,'C',0);
$pdf->SetXY($set_x+151,$set_y);
$pdf->Cell(18,5,utf8_decode("UTILIDAD"),0,1,'C',0);
$pdf->SetXY($set_x+169,$set_y);
$pdf->Cell(18,5,utf8_decode("% UTIL."),0,1,'C',0);
$pdf->SetXY($set_x+187,$set_y);
$pdf->Cell(18,5,utf8_decode("MARGEN"),0,1,'C',0);
$pdf->Line($set_x,$set_y+5,$set_x+205,$set_y+5);
    //$pdf->SetTextColor(0,0,0);
$set_y = 50;
$linea = 0;
$j = 0;

$total_costo=0;
$total_venta=0;
$total_utilidad=0;

$sql_producto = _query("SELECT SUM(fd.costo*fd.cantidad/pre.unidad)  as cost, fd.fecha FROM movimiento_producto_detalle as fd JOIN movimiento_producto as f ON f.id_movimiento=fd.id_movimiento JOIN presentacion_producto  AS pre ON pre.id_pp = fd.id_presentacion WHERE f.id_factura IN  (SELECT f.id_factura FROM factura as f WHERE f.anulada=0 AND f.finalizada=1 AND f.tipo_documento!='DEV' AND f.tipo_documento!='NC' AND f.id_sucursal=$id_sucursal  AND f.fecha BETWEEN '$fini' AND '$fin') GROUP BY f.fecha ASC");

$cuenta = _num_rows($sql_producto);
if($cuenta > 0)
{
  while ($row = _fetch_array($sql_producto))
  {
    if($page==0)
    {
        $salto = 43;
    }
    else
    {
        $salto = 51; //33 42
    }
    if($j==$salto)
    {

      $pdf->AddPage();
      $set_x = 5;
      $set_y = 5;
      $pdf->SetXY($set_x, $set_y);
      $pdf->Cell(20,5,utf8_decode("Nº"),0,1,'C',0);
      $pdf->SetXY($set_x+20,$set_y);
      $pdf->Cell(77,5,utf8_decode("FECHA"),0,1,'C',0);
      $pdf->SetXY($set_x+115,$set_y);
      $pdf->Cell(18,5,utf8_decode("COSTO"),0,1,'C',0);
      $pdf->SetXY($set_x+133,$set_y);
      $pdf->Cell(18,5,utf8_decode("VENTA"),0,1,'C',0);
      $pdf->SetXY($set_x+151,$set_y);
      $pdf->Cell(18,5,utf8_decode("UTILIDAD"),0,1,'C',0);
      $pdf->SetXY($set_x+169,$set_y);
      $pdf->Cell(18,5,utf8_decode("% UTIL."),0,1,'C',0);
      $pdf->SetXY($set_x+187,$set_y);
      $pdf->Cell(18,5,utf8_decode("MARGEN"),0,1,'C',0);
      $pdf->Line($set_x,$set_y+5,$set_x+205,$set_y+5);

      $page++;
      $set_y = 10;
      $set_x = 5;
          //Encabezado General
      $linea=0;
      $j = 0;
            //$pdf->SetFont('Latin','',8);
  }

  $sql_query = _fetch_array(_query("SELECT SUM(factura.total) as venta FROM factura WHERE factura.fecha='$row[fecha]' AND anulada = 0 AND finalizada=1 AND tipo_documento!='DEV' AND tipo_documento!='NC' "));

  $precio = round ($sql_query["venta"],4);
  $costo = round($row["cost"], 4);

  if ($costo==0) {
    // code...
    $costo=0.00001;
  }
  $utilidad = round(($precio - $costo), 4);
  $por_utilidad = round(($utilidad/$costo),4)*100;
  $margen = round($utilidad/($costo / 1.13), 4)*100;

  $total_costo=$total_costo+ $costo;
  $total_venta=$total_venta+ $precio;
  $total_utilidad=$total_utilidad+$utilidad;


  $pdf->SetXY($set_x, $set_y+$linea);
  $pdf->Cell(20,5,utf8_decode($n),0,1,'C',0);
  $n++;
  $pdf->SetXY($set_x+20,$set_y+$linea);

  $fecha=$row['fecha'];
  list($a,$m,$d) = explode("-", $fecha);

  $fec="$d DE ".meses($m)." DE $a";

  $pdf->Cell(77,5,utf8_decode($fec),0,1,'C',0);
  $pdf->SetXY($set_x+97,$set_y+$linea);
  $pdf->Cell(18,5,utf8_decode($cantidad),0,1,'C',0);
  $pdf->SetXY($set_x+115,$set_y+$linea);
  $pdf->Cell(18,5,utf8_decode(number_format($costo,2)),0,1,'C',0);
  $pdf->SetXY($set_x+133,$set_y+$linea);
  $pdf->Cell(18,5,utf8_decode(number_format($precio, 2)),0,1,'C',0);
  $pdf->SetXY($set_x+151,$set_y+$linea);
  $pdf->Cell(18,5,utf8_decode(number_format($utilidad, 2)),0,1,'C',0);
  $pdf->SetXY($set_x+169,$set_y+$linea);
  $pdf->Cell(18,5,utf8_decode(number_format($por_utilidad,2)),0,1,'C',0);
  $pdf->SetXY($set_x+187,$set_y+$linea);
  $pdf->Cell(18,5,utf8_decode(number_format($margen, 2)),0,1,'C',0);
  $linea += 5;
  $j++;

  if($j == 1)
  {
      $pdf->SetXY(4, 270);
      $pdf->Cell(10, 0.4,$impress, 0, 0, 'L');
      $pdf->SetXY(195, 270);
      $pdf->Cell(20, 0.4, 'Pag. '.$pdf->PageNo().' de {nb}', 0, 0, 'R');
  }
}
}

if($page==0)
{
    $salto = 43;
}
else
{
    $salto = 51; //33 42
}
if($j==$salto)
{

  $pdf->AddPage();
  $set_x = 5;
  $set_y = 5;
  $pdf->SetXY($set_x, $set_y);
  $pdf->Cell(20,5,utf8_decode("Nº"),0,1,'C',0);
  $pdf->SetXY($set_x+20,$set_y);
  $pdf->Cell(77,5,utf8_decode("FECHA"),0,1,'C',0);
  $pdf->SetXY($set_x+115,$set_y);
  $pdf->Cell(18,5,utf8_decode("COSTO"),0,1,'C',0);
  $pdf->SetXY($set_x+133,$set_y);
  $pdf->Cell(18,5,utf8_decode("VENTA"),0,1,'C',0);
  $pdf->SetXY($set_x+151,$set_y);
  $pdf->Cell(18,5,utf8_decode("UTILIDAD"),0,1,'C',0);
  $pdf->SetXY($set_x+169,$set_y);
  $pdf->Cell(18,5,utf8_decode("% UTIL."),0,1,'C',0);
  $pdf->SetXY($set_x+187,$set_y);
  $pdf->Cell(18,5,utf8_decode("MARGEN"),0,1,'C',0);
  $pdf->Line($set_x,$set_y+5,$set_x+205,$set_y+5);

  $page++;
  $set_y = 10;
  $set_x = 5;
      //Encabezado General
  $linea=0;
  $j = 0;
        //$pdf->SetFont('Latin','',8);
}

$pdf->SetXY($set_x, $set_y+$linea);
$pdf->Cell(20,5,utf8_decode(""),"T",1,'C',0);
$pdf->SetXY($set_x+20,$set_y+$linea);
$pdf->Cell(77,5,utf8_decode("TOTALES"),"T",1,'C',0);
$pdf->SetXY($set_x+97,$set_y+$linea);
$pdf->Cell(18,5,utf8_decode(""),"T",1,'C',0);
$pdf->SetXY($set_x+115,$set_y+$linea);
$pdf->Cell(18,5,utf8_decode(number_format($total_costo,2)),"T",1,'C',0);
$pdf->SetXY($set_x+133,$set_y+$linea);
$pdf->Cell(18,5,utf8_decode(number_format($total_venta, 2)),"T",1,'C',0);
$pdf->SetXY($set_x+151,$set_y+$linea);
$pdf->Cell(18,5,utf8_decode(number_format($total_utilidad, 2)),"T",1,'C',0);
$pdf->SetXY($set_x+169,$set_y+$linea);
$pdf->Cell(18,5,utf8_decode(""),"T",1,'C',0);
$pdf->SetXY($set_x+187,$set_y+$linea);
$pdf->Cell(18,5,utf8_decode(""),"T",1,'C',0);


ob_clean();
$pdf->Output("reporte_costos_utilidades_diarias.pdf","I");
