<?php
require('_core.php');
require('fpdf/fpdf.php');
require('num2letras.php');

$id_sucursal = $_SESSION["id_sucursal"];
$sql_empresa = "SELECT * FROM sucursal WHERE id_sucursal='$id_sucursal'";

$pr=_fetch_array(_query("SELECT empresa.razonsocial FROM empresa"));
$propietario=Mayu($pr['razonsocial']);

$resultado_emp=_query($sql_empresa);
$row_emp=_fetch_array($resultado_emp);
$nombre_a = utf8_decode(Mayu(utf8_decode(trim($row_emp["descripcion"]))));
//$direccion = Mayu(utf8_decode($row_emp["direccion_empresa"]));
$direccion = utf8_decode(Mayu(utf8_decode(trim($row_emp["direccion"]))));

$id_movimiento=$_REQUEST['id_movimiento'];

$id_row_p=_fetch_array(_query("SELECT cxp.id_proveedor FROM mov_cta_banco JOIN facturas_mov ON facturas_mov.id_movimiento=mov_cta_banco.id_movimiento JOIN cxp ON cxp.idtransace=facturas_mov.idtransace WHERE mov_cta_banco.id_movimiento=$id_movimiento LIMIT 1 "));
$id_proveedor=$id_row_p['id_proveedor'];



$sql_banco=_query("SELECT mov_cta_banco.numero_doc, bancos.nombre,cuenta_bancos.numero_cuenta FROM mov_cta_banco JOIN bancos ON mov_cta_banco.id_cuenta=bancos.id_banco JOIN cuenta_bancos ON cuenta_bancos.id_cuenta=mov_cta_banco.id_cuenta WHERE  mov_cta_banco.id_movimiento=$id_movimiento");
$rvc=_fetch_array($sql_banco);
$banco=$rvc['nombre'];
$numero_de_cuenta=$rvc['numero_cuenta'];
$numero_voucher=$rvc['numero_doc'];


$sql_abonos=_query("SELECT * FROM cheque WHERE id_movimiento=$id_movimiento");

$sql_pro=_query("SELECT proveedores.nombreche,proveedores.contacto FROM proveedores WHERE id_proveedor=$id_proveedor");
$rp=_fetch_array($sql_pro);
$proveedor=$rp['nombreche'];
$contacto=$rp['contacto'];

$sql_total=_query("SELECT salida,fecha FROM mov_cta_banco WHERE mov_cta_banco.id_movimiento=$id_movimiento");
$rt=_fetch_array($sql_total);
$total=$rt['salida'];
$total=number_format($total,2,'.','');
$fecha2=$rt['fecha'];
list($y,$m,$d)=explode('-',$fecha2);
$fechaLetras='FECHA:  SAN MIGUEL '.$d.'  DE '.Mayu(meses(intval($m))).utf8_decode(' DEl AÑO ').$y;



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

        // Arial bold 15
        $this->SetMargins(10, 10);
        $this->AddFont('latin','','latin.php');
        $this->SetFont('latin', '', 12);
        // Movernos a la derecha
        // Título
        $this->Cell(130, 6, ''.$this->a, 0, 0, 'L');/*.$this->a*/
        $this->Cell(33,6,"VOUCHER  NO:    ",0,0,'L');
        $this->Cell(33,6,$this->b,0,1,'L');

        // Salto de línea
        $this->Ln(5);
    }

    public function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->AddFont('latin','','latin.php');
        $this->SetFont('latin', '', 8);
        // Número de página requiere $pdf->AliasNbPages();
        //utf8_decode() de php que convierte nuestros caracteres a ISO-8859-1
        $this-> Cell(40, 10, utf8_decode('Fecha de impresión: '.date('Y-m-d')), 0, 0, 'L');
        $this->Cell(156, 10, utf8_decode('Página ').$this->PageNo().'/{nb}', 0, 0, 'R');
    }
    public function setear($a,$b)
    {
      # code...
      $this->a=$a;
      $this->b=$b;
    }
}

$pdf = new PDF('P', 'mm', 'letter');
$pdf->setear($banco,$numero_voucher);
$pdf->SetMargins(10, 10);
$pdf->SetLeftMargin(10);
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 15);
$pdf->AliasNbPages();
$pdf->AddPage();
$set_y=$pdf->GetY();
$set_x=$pdf->GetX();
$pdf->SetXY($set_x, $set_y);
$pdf->AddFont('latin','','latin.php');
$pdf->SetFont('latin', '', 12);
$pdf->Cell(196, 5,'', "TLR", 1, 'L');
$pdf->Cell(130, 6,''.$propietario, "L", 0, 'L');/*.$this->a*/
$pdf->Cell(33,6,"CUENTA  NO:    ",0,0,'L');
$pdf->Cell(33,6,''.$numero_de_cuenta,"R",1,'L');
$pdf->Cell(196, 5,'', "LR", 1, 'L');
$pdf->SetFont('latin', '', 8);
$pdf->Cell(130, 5,''.$fechaLetras.'   ', "L", 0, 'L');
$pdf->Cell(33,5,"SALDO USDD$   ",0,0,'L');
$total2=number_format($total,2);
$pdf->Cell(33, 5,$total2, "R", 1, 'L');
$pdf->Cell(196, 5,'', "LR", 1, 'L');
$pdf->Cell(196, 5,'PAGUESE A LA ORDEN DE:   '.utf8_decode($proveedor), "LR", 1, 'L');
list($e,$d)=explode('.',$total);
$pdf->Cell(196, 5,'', "LR", 1, 'L');
$pdf->Cell(160, 5,'LA SUMA DE:    '.Mayu( num2letras($e)).' CON '.$d.'/100'." USD DOLARES", "L", 0, 'L');
$pdf->Cell(33, 5,'', "B", 0, 'R');
$pdf->Cell(3, 5,'', "R", 1, 'R');

$pdf->Cell(160, 5,'', "L", 0, 'L');
$pdf->Cell(33, 5,'FIRMA', "", 0, 'C');
$pdf->Cell(3, 5,'', "R", 1, 'R');
$pdf->Cell(196, 5,'', "BLR", 1, 'L');
$pdf->Ln(5);

$pdf->SetFillColor(221, 221, 221);
$pdf->Cell(21, 5,'FECHA', 0, 0, 'R',true);
$pdf->Cell(28, 5,'NUMERO', 0, 0, 'R',true);
$pdf->Cell(21, 5,'CARGO', 0, 0, 'R',true);
$pdf->Cell(21, 5,'DESC', 0, 0, 'R',true);
$pdf->Cell(21, 5,'DEVOL', 0, 0, 'R',true);
$pdf->Cell(21, 5,'BONIF', 0, 0, 'R',true);
$pdf->Cell(21, 5,'RETEN', 0, 0, 'R',true);
$pdf->Cell(21, 5,'VINET', 0, 0, 'R',true);
$pdf->Cell(21, 5,'SALDO', 0, 1, 'R',true);

$rs=_query("SELECT * FROM facturas_mov WHERE id_movimiento=$id_movimiento");
while ($row2=_fetch_array($rs)) {
  $i=1;
  $cargo=0;
  $result=_query("SELECT * FROM det_fac_mov WHERE idtransace=$row2[idtransace] ORDER BY id_dfm ASC");

  while ($row=_fetch_array($result)) {
    # code...
    $numero=$row['numero'];

    $cargo=$row['cargo'];
    if($cargo!='')
    {
      $cargo=number_format($cargo,2);
    }
    $descuento=$row['descuento'];
    if($descuento!='')
    {
      $descuento=number_format($descuento,2);
    }
    $devolucion=$row['devolucion'];
    if($devolucion!='')
    {
      $devolucion=number_format($devolucion,2);
    }
    $bonificacion=$row['bonificacion'];
    if($bonificacion!='')
    {
      $bonificacion=number_format($bonificacion,2);
    }
    $retencion=$row['retencion'];
    if($retencion!='')
    {
      $retencion=number_format($retencion,2);
    }
    $vin=$row['vin'];
    if($vin!='')
    {
      $vin=number_format($vin,2);
    }

    $pdf->Cell(21, 5,$row['fecha'], 0, 0, 'R');
    $pdf->Cell(28, 5,trim($numero), 0, 0, 'R');
    $pdf->Cell(21, 5,$cargo, 0, 0, 'R');
    $pdf->Cell(21, 5,$descuento, 0, 0, 'R');
    $pdf->Cell(21, 5,$devolucion, 0, 0, 'R');
    $pdf->Cell(21, 5,$bonificacion, 0, 0, 'R');
    $pdf->Cell(21, 5,$retencion, 0, 0, 'R');
    $pdf->Cell(21, 5,$vin, 0, 0, 'R');
    $pdf->Cell(21, 5,number_format($row['saldo'],2), 0, 1, 'R');
  }
}

$i=1;

$pdf->Ln(5);
$pdf->Cell(196, 5, utf8_decode($contacto), 0, 1, 'L');
$pdf->Cell(10, 5, utf8_decode('N.'), 0, 0, 'C',true);
$pdf->Cell(80, 5, 'BANCO', 0, 0, 'L',true);
$pdf->Cell(36, 5, 'CUENTA.', 0, 0, 'L',true);
$pdf->Cell(36, 5, 'CHEQUE', 0, 0, 'L',true);
$pdf->Cell(34, 5, 'MONTO (USD)', 0, 1, 'L',true);
$i=1;

while ($row=_fetch_array($sql_abonos)) {
  # code...
  $pdf->Cell(10, 5, ''.$i, 0, 0, 'C');
  $pdf->Cell(80, 5, ''.$banco, 0, 0, 'L');
  $pdf->Cell(36, 5, ''.$numero_de_cuenta, 0, 0, 'L');
  $pdf->Cell(36, 5, ''.$row['cheque'], 0, 0, 'L');
  $pdf->Cell(34, 5, ''.number_format($row['monto'],2), 0, 1, 'R');
  $i=$i+1;
}
$pdf->Cell(162, 5, 'TOTAL', 0, 0, 'L');
$pdf->Cell(34, 5, ''.number_format($total,2), 0, 1, 'R');

$pdf->SetFont('latin', '', 10);
$ylinea=$pdf->GetY();
if ($ylinea<225) {/*255*/
    # code...

} else {
    # code...
    $pdf->AddPage();
}

$pdf->SetY(-46);
$set_x = 10;
$set_y=$pdf->GetY();
$pdf->SetXY($set_x, $set_y);
$pdf->Cell(49, 5, "AUTORIZADO", 0,0, 'C');
$pdf->SetXY($set_x, $set_y-5);
$pdf->Cell(49, 5, "N._________________", 0,0, 'C');

$pdf->SetXY($set_x+49, $set_y);
$pdf->Cell(49, 5, "HECHO POR", 0,0, 'C');
$pdf->SetXY($set_x+49, $set_y-5);
$pdf->Cell(49, 5, "N._________________", 0,0, 'C');

$pdf->SetXY($set_x+98, $set_y);
$pdf->Cell(49, 5, "REVISADO", 0,0, 'C');
$pdf->SetXY($set_x+98, $set_y-5);
$pdf->Cell(49, 5, "N._________________", 0,0, 'C');

$pdf->SetXY($set_x+147, $set_y);
$pdf->Cell(49, 5, "F._________________", 0,0, 'C');
$pdf->SetXY($set_x+147, $set_y-5);
$pdf->Cell(49, 5, "N._________________", 0,0, 'C');
$pdf->SetXY($set_x+147, $set_y+5);
$pdf->Cell(49, 5, "DUI:_______________", 0,0, 'C');
$pdf->SetXY($set_x+147, $set_y+10);
$pdf->Cell(49, 5, "TEL:_______________", 0,0, 'C');
$pdf->SetXY($set_x+147, $set_y+15);
$pdf->Cell(49, 5, "RECIBI CONFORME", 0,0, 'C');


$pdf->Output("voucher.pdf", "I");
