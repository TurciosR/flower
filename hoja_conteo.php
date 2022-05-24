<?php
require('_core.php');
require('fpdf/fpdf.php');
$params="";
$cu="";

if (isset($_POST['params'])) {
  # code...
  if ($_POST['cu']) {
    # code...
    $params=$_POST['params'];
    $cu=$_POST['cu'];

if (isset($_POST['categoria']))
{
  $params="";
  $cu=0;
  $categoria=$_POST['categoria'];
  $origen=$_POST['destino'];

  $id_categoria=$categoria;
  $id_ubicacion=$origen;


  $sql_ids="";
  if ($categoria=="") {
    # code...
    $sql_ids=_query("SELECT DISTINCT stock_ubicacion.id_producto,producto.descripcion  FROM stock_ubicacion JOIN producto  ON  producto.id_producto=stock_ubicacion.id_producto WHERE stock_ubicacion.id_ubicacion=$id_ubicacion");

  }
  else {
    # code...
    $sql_ids=_query("SELECT DISTINCT stock_ubicacion.id_producto,producto.descripcion  FROM stock_ubicacion JOIN producto  ON  producto.id_producto=stock_ubicacion.id_producto WHERE producto.id_categoria=$id_categoria AND stock_ubicacion.id_ubicacion=$id_ubicacion");

  }


  $i=_num_rows($sql_ids);

  while ($rowa=_fetch_array($sql_ids))
  {


    $id_producto =   $rowa['id_producto'];;
    $id_sucursal=$_SESSION['id_sucursal'];

    $sql_existencia = _query("SELECT sum(cantidad) as existencia FROM stock_ubicacion WHERE id_producto='$id_producto' AND stock_ubicacion.id_ubicacion='$origen'");
    $dt_existencia = _fetch_array($sql_existencia);
    $existencia = $dt_existencia["existencia"];

    $sql_p=_query("SELECT presentacion.nombre, prp.descripcion,prp.id_pp as id_presentacion,prp.unidad,prp.costo,prp.precio FROM presentacion_producto AS prp JOIN presentacion ON presentacion.id_presentacion=prp.id_presentacion WHERE prp.id_producto=$id_producto AND prp.activo=1  ORDER BY prp.unidad DESC");

    while ($row=_fetch_array($sql_p))
    {
      $select="<select class='sel form-control'>";
      $costop=$row['costo'];
      $unidadp=$row['unidad'];
      $preciop=$row['precio'];
      $descripcionp=$row['descripcion'];

      $a=intdiv($existencia,$row['unidad']);
      $array_e[$i]=$a;
      $existencia=$existencia-($a*$row['unidad']);
      $params.=$id_producto."|".$costop."|".$preciop."|"."0"."|".$unidadp."|".$a."|".$row['id_presentacion']."#";

      $cu++;

    }
  }

}



$lista=explode('#',$params);

$cabebera=utf8_decode("HOJA DE CONTEO");

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
        //$this->Image('img/finanzas.jpg', 10, 10, 33);
        $this->AddFont('latin','','latin.php');
        $this->SetFont('latin', '', 10);
        // Movernos a la derecha
        // Título
        $this->SetX(10);
        $this->Cell(40, 4, 'HOJA DE CONTEO ', 0, 0, 'L');
        $this->Cell(155, 4, 'FECHA: '.utf8_decode("____/_____/________"), 0, 1, 'R');
        // Salto de línea
        $this->Ln(5);
        $set_y=$this->GetY();
        $set_x=$this->GetX();
        $this->SetXY($set_x, $set_y);
        $this->AddFont('latin','','latin.php');
        $this->SetFont('latin', '', 9);
        $this->Cell(91, 5, 'PRODUCTO', "B", 0, 'L');
        $this->Cell(40, 5, utf8_decode('PRESENTACIÓN'), "B", 0, 'L');
        $this->Cell(20, 5, 'UNIDADES', "B", 0, 'L');
        $this->Cell(20, 5, 'VIRTUAL', "B", 0, 'L');
        $this->Cell(20, 5, 'REAL', "B", 1, 'L');
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

$pdf->setear($cu,0,0,0,0,0);
$pdf->SetMargins(10, 10);
$pdf->SetLeftMargin(10);
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 15);
$pdf->AliasNbPages();
$pdf->AddPage();

for ($i=0;$i<$cu ;$i++)
{
  list($id_producto,$precio_compra,$precio_venta,$cantidad,$unidades,$existencia,$id_presentacion)=explode('|',$lista[$i]);
  $sql=_fetch_array(_query("SELECT producto.descripcion,presentacion.nombre FROM producto JOIN presentacion_producto ON presentacion_producto.id_producto=producto.id_producto JOIN presentacion ON presentacion.id_presentacion=presentacion_producto.id_presentacion WHERE presentacion_producto.id_producto=$id_producto AND presentacion_producto.id_pp=$id_presentacion"));
  $pdf->Cell(10, 6, ($i+1), 0, 0, 'C');
  $pdf->Cell(81, 6, utf8_decode($sql['descripcion']), 0, 0, 'L');
  $pdf->Cell(35, 6, utf8_decode($sql['nombre']), 0, 0, 'L');
  $pdf->Cell(20, 6, $unidades, 0, 0, 'R');
  $pdf->Cell(20, 6, $existencia, 0, 0, 'R');
  $pdf->Cell(5, 6, "", 0, 0, 'L');
  $pdf->Cell(20, 6, "", "B", 1, 'L');
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
$pdf->Output("hoja_conteo.pdf", "I");

}
else {
  # code...
  echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
}
}
else {
  # code...
  echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
}
