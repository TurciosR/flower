<?php
require('_core.php');
require('fpdf/fpdf.php');


if (isset($_REQUEST['id_movimiento'])) {
  $id_movimiento=$_REQUEST['id_movimiento'];

  $sql_date=_fetch_array(_query("SELECT * FROM movimiento_producto WHERE id_movimiento=$id_movimiento"));
  $fm=$sql_date['fecha'];
  # code...
class PDF extends FPDF
{
    var $a;
    var $b;
    var $c;
    var $d;
    var $e;
    var $f;
    // Cabecera de página\
    public function Header()
    {

        // Logo
        $this->Image('img/finanzas.jpg', 10, 10, 33);
        $this->AddFont('latin','','latin.php');
        $this->SetFont('latin', '', 10);
        // Movernos a la derecha
        // Título
        $this->SetX(43);
        $this->Cell(130, 4, 'REPORTE AJUSTE INVENTARIO ', 0, 1, 'C');
        $this->SetX(43);
        $this->Cell(130, 4, '', 0, 1, 'C');
        $this->SetX(43);
        $this->Cell(130, 4, '', 0, 1, 'C');
        $this->SetX(43);
        $this->Cell(130, 4, 'FECHA: '.$this->a, 0, 1, 'C');
        // Salto de línea
        $this->Ln(5);
        $set_y=$this->GetY();
        $set_x=$this->GetX();
        $this->SetXY($set_x, $set_y);
        $this->AddFont('latin','','latin.php');
        $this->SetFont('latin', '', 9);
        $this->Cell(91, 5, 'PRODUCTO', 1, 0, 'L');
        $this->Cell(40, 5, utf8_decode('PRESENTACIÓN'), 1, 0, 'L');
        $this->Cell(20, 5, 'UNIDADES', 1, 0, 'L');
        $this->Cell(20, 5, 'SISTEMA', 1, 0, 'L');
        $this->Cell(20, 5, 'REAL', 1, 1, 'L');
    }

    public function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página requiere $pdf->AliasNbPages();
        //utf8_decode() de php que convierte nuestros caracteres a ISO-8859-1
        $this-> Cell(40, 10, utf8_decode('Fecha de impresión: '.date('Y-m-d')), 0, 0, 'L');
        $this->Cell(156, 10, utf8_decode('Página ').$this->PageNo().'/{nb}', 0, 0, 'R');
    }
    public function setear($a,$b,$c,$d,$e,$f)
    {
      # code...
      $this->a=$a;
      $this->b=$b;
      $this->c=$c;
      $this->d=$d;
      $this->e=$e;
      $this->f=$f;
    }
}

$pdf = new PDF('P', 'mm', 'letter');

$pdf->setear($fm,0,0,0,0,0);
$pdf->SetMargins(10, 10);
$pdf->SetLeftMargin(10);
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 15);
$pdf->AliasNbPages();
$pdf->AddPage();


$sql_ip=_query("SELECT DISTINCT movimiento_stock_ubicacion.id_producto,producto.descripcion FROM movimiento_stock_ubicacion JOIN producto ON producto.id_producto=movimiento_stock_ubicacion.id_producto WHERE movimiento_stock_ubicacion.id_mov_prod=$id_movimiento ORDER BY producto.descripcion ");
$i=0;

while ($row1=_fetch_array($sql_ip)) {
  # code...
  $sql_pr=_query("SELECT presentacion_producto.id_pp as id_presentacion,presentacion.nombre,presentacion_producto.unidad FROM presentacion_producto JOIN presentacion ON presentacion_producto.id_presentacion=presentacion.id_presentacion WHERE id_producto=$row1[id_producto]  ORDER BY presentacion_producto.unidad DESC ");

  $npres = _num_rows($sql_pr);
  $ex=_fetch_array(_query("SELECT sum(movimiento_stock_ubicacion.cantidad) as existencia FROM movimiento_stock_ubicacion WHERE movimiento_stock_ubicacion.id_producto=$row1[id_producto] AND movimiento_stock_ubicacion.id_mov_prod=$id_movimiento AND movimiento_stock_ubicacion.id_destino=0"));

  $existencia=$ex['existencia'];
  $r=1;
  while ($row2=_fetch_array($sql_pr)) {

    $pdf->Cell(10, 5, ($i+1), 1, 0, 'C');
    $pdf->Cell(81, 5, utf8_decode($row1['descripcion']), 1, 0, 'L');
    $pdf->Cell(40, 5, utf8_decode($row2['nombre']), 1, 0, 'L');

    $pdf->Cell(20, 5, $row2['unidad'], 1, 0, 'R');

    $unidadp= $row2['unidad'];
    if($existencia >= $unidadp)
    {
      if ($existencia>0&& $npres == $r) {
        // code...
        $exis = round($existencia/$unidadp,4);
      }
      else {
        $exis = intdiv($existencia, $unidadp);
        $existencia = $existencia - ($exis *$unidadp);
      }
    }
    else
    {
      if ($existencia>0&& $npres == $r) {
        // code...
        $exis = round($existencia/$unidadp,4);
      }
      else {
        // code...

        $exis =  0;
      }
    }

    $a=$exis;

    $pdf->Cell(20, 5, $a, 1, 0, 'R');

    $j=_query("SELECT movimiento_stock_ubicacion.cantidad as existencia FROM movimiento_stock_ubicacion WHERE movimiento_stock_ubicacion.id_producto=$row1[id_producto] AND movimiento_stock_ubicacion.id_mov_prod=$id_movimiento AND movimiento_stock_ubicacion.id_origen=0 AND id_presentacion=$row2[id_presentacion]");
    $real=0;
    $num_rows=_num_rows($j);
    if ($num_rows==0) {
      # code...

    }
    else {
      # code..
      $z=_fetch_array($j);
      $real=$z['existencia'];
      $real=$real/$row2['unidad'];
    }

    $pdf->Cell(20, 5, $real, 1, 1, 'R');
    $r++;
  }
  $i++;

}


$ylinea=$pdf->GetY();
if ($ylinea<255) {
    # code...
    $pdf->SetY(-20);
    $set_x = 20;
    $ylinea=$pdf->GetY();
    $pdf->Line(70, $ylinea, 146, $ylinea);
    $set_y=$pdf->GetY();
    $pdf->SetXY($set_x+49, $set_y-5);
    $pdf->MultiCell(78, 5, "F.", 0, 'J', 0);

    $set_y=$pdf->GetY();
    $pdf->SetXY($set_x+49, $set_y);
    $pdf->MultiCell(78, 5, 'N'.".", 0, 'F', 0);
} else {
    # code...
    $pdf->AddPage();
    $pdf->SetY(-20);
    $set_x = 20;
    $ylinea=$pdf->GetY();
    $pdf->Line(69, $ylinea, 147, $ylinea);
    $set_y=$pdf->GetY();
    $pdf->SetXY($set_x+49, $set_y-5);
    $pdf->MultiCell(78, 5, "F.", 0, 'J', 0);

    $set_y=$pdf->GetY();
    $pdf->SetXY($set_x+49, $set_y);
    $pdf->MultiCell(78, 5, 'N'.".", 0, 'F', 0);
}
$pdf->Output("hoja de conteo.pdf", "I");

}
else {
  # code...
  echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
}
