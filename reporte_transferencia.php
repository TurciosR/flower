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
$fini = ($_REQUEST["fini"]);
$fin = ($_REQUEST["ffin"]);
$logo = "img/logo_sys.png";
$impress = "Impreso: ".date("d/m/Y");
$title = $nombre_a;
$titulo = "REPORTE DE TRANSFERENCIA";
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
if($fini=="" && $fin!=""){
  list($a1,$m1,$d1) = explode("-", $fin);
  $fech="AL $d1 DE ".meses($m1)." DE $a1";
}
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$pdf->Image($logo,8,4,30,25);
$set_x = 0;
$set_y = 6;
//Encabezado General
//Encabezado General
$pdf->SetFont('Arial','',16);
$pdf->SetXY($set_x, $set_y);
$pdf->MultiCell(220,6,$title,0,'C',0);
$pdf->SetXY($set_x, $set_y+11);
$pdf->SetFont('Arial','',8);
$pdf->Cell(220,5,utf8_decode(ucwords(Minu("Depto. ".utf8_decode($departamento)))),0,1,'C');
$pdf->SetXY($set_x+68, $set_y+5);
$pdf->MultiCell(85,3.5,str_replace(" Y ", " y ",ucwords(utf8_decode(Minu($direccion))))."",0,'C',0);
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

$set_y = 45;
$set_x = 5;
//$pdf->SetFillColor(195, 195, 195);
//$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial','',8);
$pdf->SetXY($set_x, $set_y);
$pdf->Cell(10,5,utf8_decode("N°"),B,1,'L',0);
$pdf->SetXY($set_x+10, $set_y);
$pdf->Cell(60,5,"PRODUCTO",B,1,'L',0);
$pdf->SetXY($set_x+70, $set_y);
$pdf->Cell(40,5,"ORIGEN",B,1,'L',0);
$pdf->SetXY($set_x+110, $set_y);
$pdf->Cell(40,5,"DESTINO",B,1,'L',0);
$pdf->SetXY($set_x+150, $set_y);
$pdf->Cell(18,5,"PRESENTA.",B,1,'C',0);
$pdf->SetXY($set_x+168, $set_y);
$pdf->Cell(19,5,"CANTIDAD",B,1,'C',0);
$pdf->SetXY($set_x+187, $set_y);
$pdf->Cell(19,5,"FECHA",B,1,'C',0);
$set_y = 50;
$linea = 0;
$lista = 0;
$page = 0;
$pie=1;
$mm = 0;
$fecha_hoy=date("Y-m-n");
$sql_transferencia = _query("SELECT producto.descripcion, ubicacion.descripcion as origen,est.descripcion as eo ,pos.posicion as po,ubi.descripcion as destino,estante.descripcion as ed,posicion.posicion as pd,movimiento_stock_ubicacion.cantidad,movimiento_stock_ubicacion.fecha,presentacion_producto.unidad,presentacion.nombre
  FROM movimiento_stock_ubicacion JOIN producto ON producto.id_producto=movimiento_stock_ubicacion.id_producto
  INNER JOIN stock_ubicacion ON stock_ubicacion.id_su=movimiento_stock_ubicacion.id_origen
  LEFT JOIN ubicacion ON stock_ubicacion.id_ubicacion = ubicacion.id_ubicacion
  INNER JOIN stock_ubicacion AS su ON su.id_su=movimiento_stock_ubicacion.id_destino
  LEFT JOIN ubicacion as ubi ON ubi.id_ubicacion=su.id_ubicacion
  LEFT JOIN estante ON estante.id_estante=su.id_estante
  LEFT JOIN posicion ON posicion.id_posicion=su.id_posicion
  LEFT JOIN estante AS est ON est.id_estante=stock_ubicacion.id_estante
  LEFT JOIN posicion as pos ON stock_ubicacion.id_posicion=pos.id_posicion
  JOIN presentacion_producto ON movimiento_stock_ubicacion.id_presentacion=presentacion_producto.id_pp
  JOIN presentacion ON presentacion.id_presentacion=presentacion_producto.id_presentacion
  WHERE movimiento_stock_ubicacion.id_sucursal='$id_sucursal' AND movimiento_stock_ubicacion.fecha BETWEEN '$fini' AND '$fin'");
$cuenta = _num_rows($sql_transferencia);
if($cuenta > 0)
{
  $count=1;
  while($fila=_fetch_array($sql_transferencia)){
      if($page==0)
      $salto = 43;
      else
      $salto = 50;
      if($linea>=$salto)
      {
        $page++;
        $pdf->AddPage();
        $set_y = 6;
        $set_x = 5;
        $linea = 0;
        $mm=0;
        //Encabezado General
        $pdf->SetFont('Arial','',8);
        $pdf->SetXY($set_x, $set_y);
        $pdf->Cell(10,5,utf8_decode("N°"),B,1,'L',0);
        $pdf->SetXY($set_x+10, $set_y);
        $pdf->Cell(60,5,"PRODUCTO",B,1,'L',0);
        $pdf->SetXY($set_x+70, $set_y);
        $pdf->Cell(40,5,"ORIGEN",B,1,'L',0);
        $pdf->SetXY($set_x+110, $set_y);
        $pdf->Cell(40,5,"DESTINO",B,1,'L',0);
        $pdf->SetXY($set_x+150, $set_y);
        $pdf->Cell(18,5,"PRESENTA.",B,1,'C',0);
        $pdf->SetXY($set_x+168, $set_y);
        $pdf->Cell(19,5,"CANTIDAD",B,1,'C',0);
        $pdf->SetXY($set_x+187, $set_y);
        $pdf->Cell(19,5,"FECHA",B,1,'C',0);
        $pie=1;
        $set_y = 11;
        //$pdf->SetFont('Latin','',8);
      }
      $descripcion=$fila["descripcion"];
      $cantidad=$fila["cantidad"];
      $fecha=$fila["fecha"];
      $origen=$fila["origen"];
      $eo=$fila["eo"];
      $po=$fila["po"];
      $destino=$fila["destino"];
      $ed=$fila["ed"];
      $pd=$fila["pd"];
      $fecha=$fila["fecha"];
      $presentacion=$fila["nombre"];
      $pdf->SetXY($set_x, $set_y+$mm);
      $pdf->Cell(10,5,$count,0,1,'L',0);
      $pdf->SetXY($set_x+10, $set_y+$mm);
      $pdf->Cell(60,5,ucFirst(strtolower(utf8_decode($descripcion))),0,1,'L',0);
      $pdf->SetXY($set_x+70, $set_y+$mm);
      $pdf->Cell(40,5,utf8_decode($origen),0,1,'L',0);
      $pdf->SetXY($set_x+110, $set_y+$mm);
      $pdf->Cell(40,5,utf8_decode($destino),0,1,'L',0);
      $pdf->SetXY($set_x+150, $set_y+$mm);
      $pdf->Cell(18,5,$presentacion,0,1,'C',0);
      $pdf->SetXY($set_x+168, $set_y+$mm);
      $pdf->Cell(19,5,$cantidad,0,1,'C',0);
      $pdf->SetXY($set_x+187, $set_y+$mm);
      $pdf->Cell(19,5,ED($fecha),0,1,'C',0);
      $count++;
      $mm+=5;
      $linea++;
    if($pie == 1)
    {
      $pdf->SetXY(100, 270);
      $pdf->Cell(10, 0.4,$impress, 0, 0, 'L');
      $pdf->SetXY(4, 270);
      $pdf->Cell(10, 0.4,$titulo.".", 0, 0, 'L');
      $pdf->SetXY(193, 270);
      $pdf->Cell(20, 0.4, 'Pag. '.$pdf->PageNo().' de {nb}', 0, 0, 'R');
      $pie=0;
    }

}
}
ob_clean();
$pdf->Output("reporte_transferencia.pdf","I");
