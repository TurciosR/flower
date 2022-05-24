<?php
error_reporting(E_ERROR | E_PARSE);
require("_core.php");
require("num2letras.php");
require('fpdf/fpdf.php');


$pdf=new fPDF('L', 'mm', 'Letter');
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
$titulo = "REPORTE DE INVENTARIO";

$impress = "REPORTE DE INVENTARIO ".$fech;

$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
//$pdf->Image($logo,9,4,45,18);
$set_x = 5;
$set_y = 10;

    //Encabezado General
    //Encabezado General
$pdf->SetFont('Arial', '', 14);
$pdf->SetXY($set_x, $set_y);
$pdf->MultiCell(280, 6, $title, 0, 'C', 0);
$pdf->SetXY($set_x, $set_y+5);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(280, 6, utf8_decode($direccion), 0, 1, 'C');
$pdf->SetXY($set_x, $set_y+10);
$pdf->Cell(280, 6, utf8_decode($titulo), 0, 1, 'C');

    ///////////////////////////////////////////////////////////////////////

$set_x = 10;
$set_y = 28;
$pdf->SetFont('Arial', '', 8);
$pdf->SetXY($set_x, $set_y);
$pdf->Cell(20, 5, utf8_decode("CODIGO"), 0, 1, 'L', 0);
$pdf->SetXY($set_x+25, $set_y);
$pdf->Cell(80, 5, utf8_decode("PRODUCTO"), 0, 1, 'L', 0);
$pdf->SetXY($set_x+100, $set_y);
$pdf->Cell(35, 5, utf8_decode("PRESENTACIÓN"), 0, 1, 'L', 0);
$pdf->SetXY($set_x+135, $set_y);
$pdf->Cell(35, 5, utf8_decode("DESCRIPCIÓN"), 0, 1, 'L', 0);
$pdf->SetXY($set_x+170, $set_y);
$pdf->Cell(25, 5, utf8_decode("UBICACIÓN"), 0, 1, 'C', 0);
$pdf->SetXY($set_x+195, $set_y);
$pdf->Cell(15, 5, utf8_decode("COSTO"), 0, 1, 'C', 0);
$pdf->SetXY($set_x+210, $set_y);
$pdf->Cell(15, 5, utf8_decode("PRECIO"), 0, 1, 'C', 0);
$pdf->SetXY($set_x+225, $set_y);
$pdf->Cell(15, 5, utf8_decode("EXISTENCIA"), 0, 1, 'C', 0);
$pdf->SetXY($set_x+240, $set_y);
$pdf->Cell(20, 5, utf8_decode("TOTAL($)"), 0, 1, 'R', 0);
$pdf->Line($set_x, $set_y+5, $set_x+260, $set_y+5);
    //$pdf->SetTextColor(0,0,0);
$set_y = 33;
$linea = 0;
$linea_acumulada = 0;
$page = 0;
$j = 0;
$total_general = 0;
$sql_stock = _query("SELECT pr.id_producto,pr.descripcion, pr.barcode, c.nombre_cat as cat, SUM(su.stock) as cantidad
                     FROM producto AS pr
                     LEFT JOIN categoria AS c ON pr.id_categoria=c.id_categoria
                     JOIN stock AS su ON pr.id_producto=su.id_producto
                     WHERE su.stock>0 AND su.id_sucursal='1' GROUP BY su.id_producto ORDER BY pr.descripcion");
$contar = _num_rows($sql_stock);
if ($contar > 0) {
    while ($row = _fetch_array($sql_stock)) {
        $id_producto = $row['id_producto'];
        $descripcion=$row["descripcion"];
        $cat = $row['cat'];
        $barcode = $row['barcode'];
        $existencias = $row['cantidad'];
        $estante='NO ASIGNADO';
        $posicion='';

        $sql_pres = _query("SELECT pp.*, p.nombre as descripcion_pr FROM presentacion_producto as pp, presentacion as p WHERE pp.id_presentacion=p.id_presentacion AND pp.id_producto='$id_producto' ORDER BY pp.unidad DESC");
        $npres = _num_rows($sql_pres);

        $exis = 0;
        $n=0;
        $p = 0;
        $s = 0;
        while ($rowb = _fetch_array($sql_pres)) {
            if ($page==0) {
                $salto = 170;
            } else {
                $salto = 190;
            }
            if ($linea>=$salto) {
                $pdf->SetXY($set_x, $set_y+$linea-5);
                $pdf->Cell(260, 5, "", "B", 1, 'L', 0);
                $page++;
                $pdf->AddPage();
                $set_y = 10;
                $set_x = 10;
                $pdf->SetFont('Arial', '', 8);
                $pdf->SetXY($set_x, $set_y);
                $pdf->Cell(20, 5, utf8_decode("CODIGO"), 0, 1, 'L', 0);
                $pdf->SetXY($set_x+25, $set_y);
                $pdf->Cell(80, 5, utf8_decode("PRODUCTO"), 0, 1, 'L', 0);
                $pdf->SetXY($set_x+100, $set_y);
                $pdf->Cell(35, 5, utf8_decode("PRESENTACIÓN"), 0, 1, 'L', 0);
                $pdf->SetXY($set_x+135, $set_y);
                $pdf->Cell(35, 5, utf8_decode("DESCRIPCIÓN"), 0, 1, 'L', 0);
                $pdf->SetXY($set_x+170, $set_y);
                $pdf->Cell(25, 5, utf8_decode("UBICACIÓN"), 0, 1, 'C', 0);
                $pdf->SetXY($set_x+195, $set_y);
                $pdf->Cell(15, 5, utf8_decode("COSTO"), 0, 1, 'C', 0);
                $pdf->SetXY($set_x+210, $set_y);
                $pdf->Cell(15, 5, utf8_decode("PRECIO"), 0, 1, 'C', 0);
                $pdf->SetXY($set_x+225, $set_y);
                $pdf->Cell(15, 5, utf8_decode("EXISTENCIA"), 0, 1, 'C', 0);
                $pdf->SetXY($set_x+240, $set_y);
                $pdf->Cell(20, 5, utf8_decode("TOTAL($)"), 0, 1, 'R', 0);
                $pdf->Line($set_x, $set_y+5, $set_x+260, $set_y+5);
                //$pdf->SetTextColor(0,0,0);
                $set_y = 15;
                //Encabezado General
                $linea=0;
                $j = 0;
                //$pdf->SetFont('Latin','',8);
            }
            $unidad = $rowb["unidad"];
            $costo = $rowb["costo"];
            $precio = $rowb["precio"];


            $descripcion_pr = $rowb["descripcion"];
            $presentacion = $rowb["descripcion_pr"];
            if ($existencias >= $unidad) {
                $exis = intdiv($existencias, $unidad);
                $existencias = $existencias%$unidad;
            } else {
                $exis =  0;
            }
            $total_costo = round(($costo) * $exis, 4);
            $total_general += $total_costo;
            $pdf->SetXY($set_x+100, $set_y+$linea+$p);
            $pdf->Cell(35, 5, utf8_decode($presentacion), 0, 1, 'L', 0);
            $pdf->SetXY($set_x+135, $set_y+$linea+$p);
            $pdf->Cell(35, 5, utf8_decode($descripcion_pr), 0, 1, 'L', 0);
            $pdf->SetXY($set_x+170, $set_y+$linea+$p);
            $pdf->Cell(25, 5, utf8_decode("$estante"." "."$posicion"), 0, 1, 'C', 0);
            $pdf->SetXY($set_x+195, $set_y+$linea+$p);
            $pdf->Cell(15, 5, utf8_decode(number_format($costo, 2)), 0, 1, 'C', 0);
            $pdf->SetXY($set_x+210, $set_y+$linea+$p);
            $pdf->Cell(15, 5, utf8_decode(number_format($precio, 2)), 0, 1, 'C', 0);
            $pdf->SetXY($set_x+225, $set_y+$linea+$p);
            $pdf->Cell(15, 5, utf8_decode($exis), 0, 1, 'C', 0);
            $pdf->SetXY($set_x+240, $set_y+$linea+$p);
            $pdf->Cell(20, 5, utf8_decode(number_format($total_costo, 4)), 0, 1, 'R', 0);
            $p += 5;
            $s += 1;
        }
        $j++;
        $pdf->SetXY($set_x, $set_y+$linea);
        $pdf->Cell(20, 5*$s, utf8_decode($barcode), 0, 1, 'L', 0);
        $pdf->SetXY($set_x+24, $set_y+$linea);
        $pdf->Cell(80, 5*$s, utf8_decode($descripcion), 0, 1, 'L', 0);
        $cc = (5 * $s);
        $linea += (5*$s);
        $linea_acumulada += $linea;
        if ($j == 1) {
            $ny = 207;
            if ($page==0) {
                $ny = 205;
            }
            $pdf->SetXY(10, $ny);
            $pdf->Cell(10, 0.4, $impress, 0, 0, 'L');
            $pdf->SetXY(254, $ny);
            $pdf->Cell(20, 0.4, 'Pag. '.$pdf->PageNo().' de {nb}', 0, 0, 'R');
        }
    }
    $pdf->Line($set_x, $set_y+$linea, $set_x+270, $set_y+$linea);
    $pdf->SetXY($set_x, $set_y+$linea);
    $pdf->Cell(245, 5, utf8_decode("TOTAL"), 0, 1, 'L', 0);
    $pdf->SetXY($set_x+235, $set_y+$linea);
    $pdf->Cell(25, 5, utf8_decode("$".number_format($total_general, 4)), 0, 1, 'R', 0);
}





ob_clean();
$pdf->Output("reporte_inventario.pdf", "I");
