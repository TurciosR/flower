<?php
require('_core.php');
require('fpdf/fpdf.php');
$params="";


$fini = $_REQUEST["fini"];
$fin = $_REQUEST["fin"];


$sql_empresa = "SELECT * FROM sucursal WHERE id_sucursal=$_SESSION[id_sucursal]";

$resultado_emp=_query($sql_empresa);
$row_emp=_fetch_array($resultado_emp);
$nombre_a = utf8_decode(Mayu(utf8_decode(trim($row_emp["descripcion"]))));
$tel1 = $row_emp['telefono1'];
$n_sucursal = $row_emp['n_sucursal'];
$tel2 = $row_emp['telefono2'];
$direccion = $row_emp['direccion'];
$telefonos="TEL. ".$tel1." y ".$tel2;



class PDF extends FPDF
{
    var $a;
    var $b;
    var $c;
    var $d;
    var $e;
    var $f;
    var $w;
    // Cabecera de página\
    public function Header()
    {

        // Logo
        $this->Image('img/logo_sys.png', 10, 10, 33);
        $this->AddFont('latin','','latin.php');
        $this->SetFont('latin', '', 10);
        // Movernos a la derecha
        // Título
        //$this->SetX(43);
        //$this->Cell(130, 4, 'HOJA DE CONTEO ', 0, 1, 'C');

        $this->Cell(195,6,$this->a,0,1,'C');
        $this->SetFont('Latin','',10);
        $this->SetX(40);
        $this->MultiCell(140,5,utf8_decode((Mayu(utf8_decode("Sucursal ".$this->e.": ".$this->c)))),0,'C',0);
        $this->Cell(195,6,$this->b,0,1,'C');
        $this->Cell(195,6,utf8_decode("REPORTE DE PRODUCTOS PARA REPOSICIÓN"),0,1,'C');
        $this->Cell(195,6,$this->d." ".hora($this->w),0,1,'C');
        // Salto de línea
        $this->Ln(5);
        $set_y=$this->GetY();
        $set_x=$this->GetX();
        $this->SetXY($set_x, $set_y);
        $this->AddFont('latin','','latin.php');
        $this->SetFont('latin', '', 9);
        $this->Cell(10, 5, 'ID', 1, 0, 'L');
        $this->Cell(85, 5, 'PRODUCTO', 1, 0, 'L');
        $this->Cell(40, 5, utf8_decode('PRESENTACIÓN'), 1, 0, 'L');
        $this->Cell(20, 5, 'UNIDAD', 1, 0, 'L');
        $this->Cell(20, 5, 'CANTIDAD', 1, 0, 'L');
        $this->Cell(20, 5, 'FACTURA', 1, 1, 'L');
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
    public function setear($a,$b,$c,$d,$e,$f,$g,$w)
    {
      # code...
      $this->a=$a;
      $this->b=$b;
      $this->c=$c;
      $this->d=$d;
      $this->e=$e;
      $this->f=$f;
      $this->g=$g;
      $this->w=$w;
    }
}

$pdf = new PDF('P', 'mm', 'letter');
$fech =  "DEL ".ED($fini)." AL ".ED($fin);
$pdf->setear($nombre_a,$telefonos,$direccion,$fech,$n_sucursal,$id_traslado,$destino,$ho);
$pdf->SetMargins(10, 10);
$pdf->SetLeftMargin(10);
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 15);
$pdf->AliasNbPages();
$pdf->AddPage();

$sqlp=_query("SELECT factura.tipo_documento, factura.num_fact_impresa,producto.id_producto, producto.descripcion,presentacion.nombre,presentacion_producto.unidad,factura_detalle.cantidad
FROM factura_detalle
JOIN factura ON factura.id_factura=factura_detalle.id_factura
JOIN producto ON producto.id_producto=factura_detalle.id_prod_serv
JOIN presentacion_producto ON presentacion_producto.id_presentacion=factura_detalle.id_presentacion
JOIN presentacion ON presentacion.id_presentacion=presentacion_producto.presentacion WHERE factura_detalle.precio_venta='0' AND factura.fecha BETWEEN '$fini' AND '$fin'");

while ($row=_fetch_array($sqlp)) {
  # code...,traslado_detalle_recibido.recibido
  $pdf->Cell(10, 5,$row['id_producto'], 1, 0, 'C');
  $pdf->Cell(85, 5, utf8_decode($row['descripcion']), 1, 0, 'L');
  $pdf->Cell(40, 5, utf8_decode($row['nombre']), 1, 0, 'L');
  $pdf->Cell(20, 5, $row['unidad'], 1, 0, 'R');
  $pdf->Cell(20, 5,"".($row['cantidad']/$row['unidad']), 1, 0, 'R');
  $pdf->Cell(20, 5,$row['tipo_documento']." ".$row['num_fact_impresa'], 1, 1, 'R');
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
$pdf->Output("traslado_recibido.pdf", "I");
