<?php
require('_core.php');
require('fpdf/fpdf.php');
$params="";

if (isset($_REQUEST['id_traslado'])) {
  # code...
$id_traslado=$_REQUEST['id_traslado'];


$sql_suc=_fetch_array(_query("SELECT CONCAT('Sucursal ',sucursal.n_sucursal,' ',sucursal.direccion) as destino,traslado.id_sucursal_origen,traslado.fecha,traslado.hora  FROM traslado JOIN sucursal ON traslado.id_sucursal_destino=sucursal.id_sucursal WHERE traslado.id_traslado=$id_traslado"));


$sql_empresa = "SELECT * FROM sucursal WHERE id_sucursal=$sql_suc[id_sucursal_origen]";

$destino=$sql_suc['destino'];
$ho=$sql_suc['hora'];
$resultado_emp=_query($sql_empresa);
$row_emp=_fetch_array($resultado_emp);
$nombre_a = utf8_decode(Mayu(utf8_decode(trim($row_emp["descripcion"]))));
$tel1 = $row_emp['telefono1'];
$n_sucursal = $row_emp['n_sucursal'];
$tel2 = $row_emp['telefono2'];
$direccion = $row_emp['direccion'];
$telefonos="TEL. ".$tel1." y ".$tel2;

list($y,$m,$d)=explode('-',$sql_suc['fecha']);
$fech =$d." DE ".utf8_decode(Mayu(utf8_decode(meses($m))))." DEL ".$y."";

$cabebera=utf8_decode("HOJA DE CONTEO");

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
        $this->Cell(195,6,utf8_decode((Mayu(utf8_decode("Sucursal ".$this->e.": ".$this->c)))),0,1,'C');
        $this->Cell(195,6,$this->b,0,1,'C');
        $this->Cell(195,6,"REPORTE DE TRASLADO",0,1,'C');
        $this->Cell(195,6,"TRASLADO: ".str_pad($this->f,7,"0",STR_PAD_LEFT),0,1,'C');
        $this->Cell(195,6,"DESTINO: ".utf8_decode((Mayu(utf8_decode($this->g)))),0,1,'C');
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
        $this->Cell(30, 5, 'UNIDAD', 1, 0, 'L');
        $this->Cell(30, 5, 'CANTIDAD', 1, 1, 'L');
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

$pdf->setear($nombre_a,$telefonos,$direccion,$fech,$n_sucursal,$id_traslado,$destino,$ho);
$pdf->SetMargins(10, 10);
$pdf->SetLeftMargin(10);
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 15);
$pdf->AliasNbPages();
$pdf->AddPage();

$sqlp=_query("SELECT  producto.id_producto, producto.descripcion,presentacion.nombre,presentacion_producto.unidad,traslado_detalle.cantidad
FROM traslado_detalle
JOIN producto ON producto.id_producto=traslado_detalle.id_producto
JOIN presentacion_producto ON presentacion_producto.id_pp=traslado_detalle.id_presentacion
JOIN presentacion ON presentacion.id_presentacion=presentacion_producto.id_presentacion WHERE traslado_detalle.id_traslado=$id_traslado");

while ($row=_fetch_array($sqlp)) {
  # code...
  $pdf->Cell(10, 5,$row['id_producto'], 1, 0, 'C');
  $pdf->Cell(85, 5, utf8_decode($row['descripcion']), 1, 0, 'L');
  $pdf->Cell(40, 5, utf8_decode($row['nombre']), 1, 0, 'L');
  $pdf->Cell(30, 5, $row['unidad'], 1, 0, 'R');
  $pdf->Cell(30, 5,"".($row['cantidad']/$row['unidad']), 1, 1, 'R');
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
$pdf->Output("traslado_enviado.pdf", "I");

}
else {
  # code...
  echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
}
