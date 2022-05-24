<?php
require("_core.php");
require("num2letras.php");
require('fpdf/fpdf.php');


$pdf=new fPDF('P', 'mm', 'Letter');
$pdf->SetMargins(10, 5);
$pdf->SetTopMargin(2);
$pdf->SetLeftMargin(10);
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 1);
$pdf->AddFont("latin", "", "latin.php");

$id_sucursal = $_SESSION["id_sucursal"];
$sql_empresa = "SELECT * FROM sucursal WHERE id_sucursal='$id_sucursal'";
$resultado_emp=_query($sql_empresa);
$row_emp=_fetch_array($resultado_emp);
$nombre_a = utf8_decode(Mayu(utf8_decode(trim($row_emp["descripcion"]))));
//$direccion = Mayu(utf8_decode($row_emp["direccion_empresa"]));
$direccion = utf8_decode(Mayu(utf8_decode(trim($row_emp["direccion"]))));

$logo = "img/logo_sys.png";

$title = $nombre_a;
$fech = date("d/m/Y");
$titulo = "REPORTE DE PRODUCTOS PARA REPOSICION";

$impress = "REPORTE DE PRODUCTOS PARA REPOSICION ".$fech;

$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
//$pdf->Image($logo,9,4,45,18);
$set_x = 5;
$set_y = 10;

//Encabezado General
//Encabezado General
$pdf->SetFont('Arial', '', 14);
$pdf->SetXY($set_x, $set_y);
$pdf->MultiCell(215, 6, $title, 0, 'C', 0);
$pdf->SetXY($set_x, $set_y+5);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(215, 6, utf8_decode($direccion), 0, 1, 'C');
$pdf->SetXY($set_x, $set_y+10);
$pdf->Cell(215, 6, utf8_decode($titulo), 0, 1, 'C');

///////////////////////////////////////////////////////////////////////

$set_x = 10;
$set_y = 28;
$pdf->SetFont('Arial', '', 8);
$pdf->SetXY($set_x, $set_y);
$pdf->Cell(20, 5, utf8_decode("CODIGO"), 0, 1, 'L', 0);
$pdf->SetXY($set_x+25, $set_y);
$pdf->Cell(145, 5, utf8_decode("PRODUCTO"), 0, 1, 'L', 0);
$pdf->SetXY($set_x+165, $set_y);
$pdf->Cell(15, 5, utf8_decode("MINIMO"), 0, 1, 'L', 0);
$pdf->SetXY($set_x+180, $set_y);
$pdf->Cell(15, 5, utf8_decode("EXISTENCIA"), 0, 1, 'L', 0);
$pdf->SetXY($set_x, $set_y);
$pdf->Cell(200, 5, "", "B", 1, 'L', 0);
//$pdf->SetTextColor(0,0,0);
$set_y = 33;
$linea = 0;
$linea_acumulada = 0;
$page = 0;
$j = 0;
$total_general = 0;

$sql_stock = _query("SELECT producto.id_producto, producto.barcode,producto.descripcion,producto.minimo,stock.stock FROM stock JOIN producto WHERE stock.id_producto=producto.id_producto AND stock.stock<producto.minimo");
$contar = _num_rows($sql_stock);
if ($contar > 0) {
  while ($row = _fetch_array($sql_stock))
  {
    $id_producto = $row['id_producto'];
    $descripcion=$row["descripcion"];
    $barcode = $row['barcode'];
    $existencias = $row['stock'];
    $minimo = $row['minimo'];

    $exis = 0;
      if ($page==0)
      {
        $salto = 230;
      } else {
        $salto = 250;
      }
      if ($linea>=$salto)
      {
        $pdf->SetXY($set_x, $set_y+$linea-5);
        $pdf->Cell(200, 5, "", "B", 1, 'L', 0);
        $page++;
        $pdf->AddPage();
        $set_y = 10;
        $set_x = 10;
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY($set_x, $set_y);
        $pdf->Cell(20, 5, utf8_decode("CODIGO"), 0, 1, 'L', 0);
        $pdf->SetXY($set_x+25, $set_y);
        $pdf->Cell(145, 5, utf8_decode("PRODUCTO"), 0, 1, 'L', 0);
        $pdf->SetXY($set_x+165, $set_y);
        $pdf->Cell(15, 5, utf8_decode("MINIMO"), 0, 1, 'L', 0);
        $pdf->SetXY($set_x+180, $set_y);
        $pdf->Cell(15, 5, utf8_decode("EXISTENCIA"), 0, 1, 'L', 0);
        $pdf->SetXY($set_x, $set_y);
        $pdf->Cell(200, 5, "", "B", 1, 'L', 0);
        //$pdf->SetTextColor(0,0,0);
        $set_y = 15;
        //Encabezado General
        $linea=0;
        $j = 0;
        //$pdf->SetFont('Latin','',8);
      }
      $pdf->SetXY($set_x, $set_y+$linea);
      $pdf->Cell(20, 5, utf8_decode($barcode), 0, 1, 'L', 0);
      $pdf->SetXY($set_x+24, $set_y+$linea);
      $pdf->Cell(145, 5, utf8_decode($descripcion), 0, 1, 'L', 0);
      $pdf->SetXY($set_x+155, $set_y+$linea);
      $pdf->Cell(15, 5, utf8_decode(number_format($minimo,0)), 0, 1, 'R', 0);
      $pdf->SetXY($set_x+180, $set_y+$linea);
      $pdf->Cell(15, 5, utf8_decode(number_format($existencias,0)), 0, 1, 'R', 0);
      $linea += 5;
      $linea_acumulada += $linea;
      if($linea == 5)
      {
        $pdf->SetXY(10, 270);
        $pdf->Cell(10, 0.4, $impress, 0, 0, 'L');
        $pdf->SetXY(190, 270);
        $pdf->Cell(20, 0.4, 'Pag. '.$pdf->PageNo().' de {nb}', 0, 0, 'R');
      }
    }
    $pdf->SetXY($set_x, $set_y+$linea-5);
    $pdf->Cell(200, 5, "", "B", 1, 'L', 0);
}
ob_clean();
$pdf->Output("reporte_inventario.pdf", "I");
