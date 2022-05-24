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

$id_corte = $_REQUEST["id_corte"];
$sql_corte = _query("SELECT cc.*, u.nombre AS nombre_empleado, c.nombre AS nombre_caja
  FROM controlcaja as cc
  LEFT JOIN usuario as u ON cc.id_empleado = u.id_usuario
  LEFT JOIN caja as c ON cc.caja = c.id_caja
  WHERE cc.id_corte = '$id_corte'");
$cuenta = _num_rows($sql_corte);
if($cuenta > 0)
{
  $row = _fetch_array($sql_corte);
  $turno = $row["turno"];
  $total_cobro = $row["total_cobro"];
  $total_mora = $row["total_mora"];
  $vales = $row["vales"];
  $ingresos = $row["ingresos"];
  $id_apertura = $row["id_apertura"];
  $monto_apertura = $row["cashinicial"];
  $fecha_corte = $row["fecha_corte"];
  $hora_corte = $row["hora_corte"];
  $saldo_caja = $row["saldo_caja"];
  $faltante = $row["faltante"];
  $sobrante = $row["sobrante"];
  $nombre_empleado = $row["nombre_empleado"];
  $nombre_caja = $row["nombre_caja"];

  $totalt = $row["totalt"];
  $totalf = $row["totalf"];
  $totalcf = $row["totalcf"];

  $total_doc = number_format($totalt+$totalf+$totalcf, 2,'.','');

  $total_cm = $total_cobro + $total_mora;
  $total_mcaja = $ingresos - $vales;
}
$min = $_REQUEST["l"];
$fini = $fecha_corte;
$fin = ($_REQUEST["ffin"]);
$fini1 = $_REQUEST["fini"];
$fin1 = $_REQUEST["ffin"];
$logo = "img/logo_sys.png";

$title = "CORTE CAJA";
$empresa = "";
$titulo = "";
if($fini!="")
{
    list($a,$m,$d) = explode("-", $fini);

    $fech="AL $d DE ".meses($m)." DE $a";

}
$impress = "REPORTE DE COSTO UTILIDAD ".$fech;


$existenas = "";
if($min>0)
{
    $existenas = "CANTIDAD: $min";
}


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
      $this->SetFont('Latin','',12);

      $this->Cell(100,6,utf8_decode($this->a),0,0,'L');
      $this->MultiCell(100,6,$this->d,0,'R',0);
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
      $this->Cell(160, 10, utf8_decode('Página ').$this->PageNo().'/{nb}', 0, 0, 'R');
    }
    public function setear($a,$b,$c,$d)
    {
      # code...
      $this->a=$a;
      $this->b=$b;
      $this->c=$c;
      $this->d=$d;
    }
}
$sql_ncob = _query("SELECT * FROM prestamo_detalle WHERE fecha_pago='$fecha_corte' AND apertura='$id_apertura' AND refinanciado=0 GROUP BY referencia");
//$dats_ncob = _fetch_array($sql_ncob);
$ncobros = _num_rows($sql_ncob);//$dats_ncob["ncobros"];

$sql_ndesem = _query("SELECT count(id_prestamo) AS ndesembolso, SUM(monto) as monto FROM prestamo WHERE fecha_desembolso='$fecha_corte'");
$dats_ndesem = _fetch_array($sql_ndesem);
$ndesembolsos = $dats_ndesem["ndesembolso"];
$total_desembolso = $dats_ndesem["monto"];

$sql_ref = _query("SELECT count(id_movimiento) AS nmov, SUM(valor) as monto FROM mov_caja WHERE fecha='$fecha_corte' AND turno='$turno' AND id_apertura='$id_apertura' AND concepto LIKE '%CANCELACION DE PRESTAMO POR REFINANCIAMIENTO%'");
$dats_ref = _fetch_array($sql_ref);
$nrefi = $dats_ref["nmov"];
$total_refi = $dats_ref["monto"];

$pdf=new PDF('P','mm', 'Letter');
$pdf->setear($title,$empresa,$titulo,$fech);
$pdf->SetMargins(10,5);
$pdf->SetTopMargin(8);
$pdf->SetLeftMargin(8);
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,20);
$pdf->AddFont("latin","","latin.php");
$pdf->AddPage();

//$pdf->AddPage();
$pdf->SetFont('latin','',10);
//$pdf->Image($logo,8,4,30,25);



$pdf->SetFont('latin','',10);
$pdf->Cell(20,5,"",0,1,'C',0);
//$pdf->SetXY($set_x, $set_y);
$pdf->Cell(20,5,utf8_decode("TURNO N° ".$turno),0,1,'L',0);
//$pdf->SetXY($set_x+20,$set_y);
$pdf->Cell(77,5,utf8_decode("CAJERO: ".Mayu($nombre_empleado)),0,1,'L',0);

$pdf->Cell(20,5,"",0,1,'C',0);
//$pdf->SetXY($set_x, $set_y);
$pdf->Cell(200,5,utf8_decode("DOCUMENTOS"),0,1,'C',0);
$set_x = $pdf->GetX();
$set_y = $pdf->GetY();

$pdf->Line($set_x,$set_y,$set_x+200,$set_y);
$pdf->Cell(150,5,utf8_decode("TIQUETE"),0,0,'L',0);
$pdf->Cell(50,5,number_format($totalt, 2, '.', ','),0,1,'R',0);

$pdf->Line($set_x,$set_y,$set_x+200,$set_y);
$pdf->Cell(150,5,utf8_decode("FACTURA"),0,0,'L',0);
$pdf->Cell(50,5,number_format($totalf, 2, '.', ','),0,1,'R',0);

$pdf->Line($set_x,$set_y,$set_x+200,$set_y);
$pdf->Cell(150,5,utf8_decode("CREDITO FISCAL"),0,0,'L',0);
$pdf->Cell(50,5,number_format($totalcf, 2, '.', ','),0,1,'R',0);

$set_x = $pdf->GetX();
$set_y = $pdf->GetY();
$pdf->Line($set_x,$set_y,$set_x+200,$set_y);
$pdf->Cell(150,5,utf8_decode("TOTAL"),0,0,'L',0);
$pdf->Cell(50,5,number_format($total_doc, 2, '.', ','),0,1,'R',0);

$pdf->Cell(20,5,"",0,1,'C',0);
$pdf->Cell(200,5,utf8_decode("COBROS CREDITO"),0,1,'C',0);
$set_x = $pdf->GetX();
$set_y = $pdf->GetY();

$pdf->Line($set_x,$set_y,$set_x+200,$set_y);
$pdf->Cell(150,5,utf8_decode("CLIENTE"),0,0,'L',0);
$pdf->Cell(50,5,"MONTO",0,1,'R',0);

$set_x = $pdf->GetX();
$set_y = $pdf->GetY();
$pdf->Line($set_x,$set_y,$set_x+200,$set_y);

$sql_cuenta = _query("SELECT mc.*, f.numero_doc, f.id_cliente, f.nombre AS nombre_f, c.nombre AS nombre_c
  FROM mov_caja AS mc
  join abono_credito on abono_credito.id_abono_credito = mc.idtransace
  join credito on credito.id_credito = abono_credito.id_credito
  JOIN factura AS f ON credito.id_factura = f.id_factura
  JOIN cliente AS c ON f.id_cliente = c.id_cliente
  WHERE mc.id_apertura = '$id_apertura' AND mc.numero_doc != ''");
$cuenta_cuenta = _num_rows($sql_cuenta);
$total_cobros = 0;
if($cuenta_cuenta > 0)
{
  while ($row_cuenta = _fetch_array($sql_cuenta))
  {
    $monto = $row_cuenta["valor"];
    $entrada = $row_cuenta["entrada"];
    $salida = $row_cuenta["salida"];
    $numero_doc = $row_cuenta['numero_doc'];
    $idtransace = $row_cuenta['idtransace'];
    $nombre_c = $row_cuenta['nombre_c'];
    $nombre_f = $row_cuenta['nombre_f'];

    if($nombre_c == "")
    {
      $nombre_text = $nombre_f;
    }
    else
    {
        $nombre_text = $nombre_c;
    }

    $pdf->Line($set_x,$set_y,$set_x+200,$set_y);
    $pdf->Cell(150,5,utf8_decode($nombre_text),0,0,'L',0);
    $pdf->Cell(50,5,number_format($monto, 2, '.', ','),0,1,'R',0);

    $total_cobros += $monto;
  }
  $set_x = $pdf->GetX();
  $set_y = $pdf->GetY();
  $pdf->Line($set_x,$set_y,$set_x+200,$set_y);
  $pdf->Line($set_x,$set_y,$set_x+200,$set_y);
  $pdf->Cell(150,5,utf8_decode("TOTAL"),0,0,'L',0);
  $pdf->Cell(50,5,number_format($total_cobros, 2, '.', ','),0,1,'R',0);
}

//////////////////////MOVIMIENTO caja
$pdf->Cell(20,5,"",0,1,'C',0);
//$pdf->SetXY($set_x, $set_y);
$pdf->Cell(200,5,utf8_decode("MOVIMIENTOS DE CAJA"),0,1,'C',0);
$set_x = $pdf->GetX();
$set_y = $pdf->GetY();
$pdf->Line($set_x,$set_y,$set_x+200,$set_y);
$pdf->Cell(150,5,utf8_decode("INGRESOS"),0,0,'L',0);
$pdf->Cell(50,5,number_format($ingresos, 2, '.', ','),0,1,'R',0);

$pdf->Cell(150,5,utf8_decode("VALES"),0,0,'L',0);
$pdf->Cell(50,5,number_format($vales, 2, '.', ','),0,1,'R',0);
$set_x = $pdf->GetX();
$set_y = $pdf->GetY();
$pdf->Line($set_x,$set_y,$set_x+200,$set_y);
$pdf->Cell(150,5,utf8_decode("TOTAL"),0,0,'L',0);
$pdf->Cell(50,5,number_format($total_mcaja, 2, '.', ','),0,1,'R',0);


////////////////////////Cobros externos

$sql_vendedores = _query("SELECT p.id_cobrador, u.nombre FROM prestamo_detalle as p JOIN usuario as u ON p.id_cobrador=u.id_usuario WHERE p.fecha_pago BETWEEN '$fecha_corte' AND '$fecha_corte' AND pagado='1' AND p.apertura = 0 AND p.cajero = 0 AND p.turno = 0 GROUP BY id_cobrador");
$cuenta = _num_rows($sql_vendedores);

if($cuenta > 0)
{
  $pdf->Cell(20,5,"",0,1,'C',0);
  //$pdf->SetXY($set_x, $set_y);
  $pdf->Cell(200,5,utf8_decode("COBROS EXTERNOS"),0,1,'C',0);
  $set_x = $pdf->GetX();
  $set_y = $pdf->GetY();
  //$pdf->Line($set_x,$set_y,$set_x+200,$set_y);
  $pdf->Cell(100,5,utf8_decode("COBRADOR"),0,0,'L',0);
  $pdf->Cell(25,5,utf8_decode("N° COBROS"),0,0,'C',0);
  $pdf->Cell(25,5,utf8_decode("MONTO"),0,0,'R',0);
  $pdf->Cell(25,5,utf8_decode("MORA"),0,0,'R',0);
  $pdf->Cell(25,5,utf8_decode("TOTAL"),0,1,'R',0);

  $total_general =0;
  $total_generalf =0;
  $total_general_plus =0;
  while ($row = _fetch_array($sql_vendedores))
  {
    $id_cobrador = $row["id_cobrador"];
    $nombre = Mayu(utf8_decode($row["nombre"]));
    $set_x = $pdf->GetX();
    $set_y = $pdf->GetY();
    //$pdf->Line($set_x,$set_y,$set_x+200,$set_y);
    $pdf->Line($set_x,$set_y-5,$set_x+200,$set_y-5);
    $sql_aux = _query("SELECT COUNT(*) AS n_cobros, SUM(pd.monto) AS total, SUM(pd.mora) AS total_mora FROM prestamo_detalle as pd
    JOIN prestamo AS p ON pd.id_prestamo=p.id_prestamo JOIN cliente as c ON c.id_cliente = p.id_cliente
    WHERE pd.id_cobrador = '$id_cobrador' AND pd.pagado=1 AND pd.fecha_pago BETWEEN '$fecha_corte' AND '$fecha_corte' AND pd.apertura = 0 AND pd.cajero = 0 AND pd.turno = 0
    GROUP BY pd.id_cobrador ORDER BY c.nombre ASC");
    $cuenta_aux = _num_rows($sql_aux);
    if($cuenta_aux)
    {
      $set_x = $pdf->GetX();
      $set_y = $pdf->GetY();
      $pdf->Line($set_x,$set_y,$set_x+200,$set_y);
      $i = 1;
      $tot = 0;
      $totf = 0;
      $row_aux = _fetch_array($sql_aux);
      $mora = $row_aux["total_mora"];
      $monto = $row_aux["total"];
      $n_cobros = $row_aux["n_cobros"];

      $total_plus = $monto + $mora;


      $pdf->Cell(100,5,utf8_decode($nombre),0,0,'L',0);
      $pdf->Cell(25,5,utf8_decode($n_cobros),0,0,'C',0);
      $pdf->Cell(25,5,utf8_decode(number_format($monto, 2, '.',',')),0,0,'R',0);
      $pdf->Cell(25,5,utf8_decode(number_format($mora, 2, '.',',')),0,0,'R',0);
      $pdf->Cell(25,5,utf8_decode(number_format($total_plus, 2, '.',',')),0,1,'R',0);

      $total_general += $monto;
      $total_generalf += $mora;
      $total_general_plus += $total_plus;

    }
  }
  $set_x = $pdf->GetX();
  $set_y = $pdf->GetY();
  $pdf->Line($set_x,$set_y,$set_x+200,$set_y);
  $pdf->Cell(125,5,utf8_decode("TOTAL"),0,0,'L',0);
  $pdf->Cell(25,5,utf8_decode(number_format($total_general, 2, '.',',')),0,0,'R',0);
  $pdf->Cell(25,5,utf8_decode(number_format($total_generalf, 2, '.',',')),0,0,'R',0);
  $pdf->Cell(25,5,utf8_decode(number_format($total_general_plus, 2, '.',',')),0,1,'R',0);
}

//////////////Devoluciones
$devolucion = 0;
$sql_dev = _query("SELECT factura.numero_doc,factura.total,f.tipo_documento,f.numero_doc as doc FROM factura JOIN factura AS f ON f.id_factura=factura.afecta WHERE factura.tipo_documento IN ('DEV','NC') AND factura.id_apertura_pagada = $id_apertura");
$cuenta_dev = _num_rows($sql_dev);
if($cuenta_dev > 0)
{
  $pdf->Cell(20,5,"",0,1,'C',0);
  $pdf->Cell(20,5,utf8_decode("DEVOLUCIONES"),0,1,'L',0);
  $set_x = $pdf->GetX();
  $set_y = $pdf->GetY();
  $pdf->Line($set_x,$set_y,$set_x+200,$set_y);

  //$pdf->SetXY($set_x, $set_y);
  $pdf->Cell(15,5,utf8_decode("N°"),0,0,'L',0);
  $pdf->Cell(50,5,utf8_decode("N° DOCUMENTO"),0,0,'L',0);
  $pdf->Cell(45,5,utf8_decode("DOC AFECTA"),0,0,'L',0);
  $pdf->Cell(45,5,utf8_decode("N° AFECTA"),0,0,'L',0);
  $pdf->Cell(45,5,utf8_decode("TOTAL"),0,1,'R',0);

  $set_x = $pdf->GetX();
  $set_y = $pdf->GetY();
  $pdf->Line($set_x,$set_y,$set_x+200,$set_y);
  $n = 1;
  while ($row_dev = _fetch_array($sql_dev))
  {
    list($doca,$sa)=explode("_",$row_dev['numero_doc']);

    list($docb,$sb)=explode("_",$row_dev['doc']);
    $valor = $row_dev['total'];
    $pdf->Cell(15,5,utf8_decode($n),0,0,'L',0);
    //$pdf->SetXY($set_x+20,$set_y);
    $pdf->Cell(50,5,utf8_decode($doca),0,0,'L',0);
    $pdf->Cell(45,5,utf8_decode($row_dev['tipo_documento']),0,0,'L',0);
    $pdf->Cell(45,5,utf8_decode($docb),0,0,'L',0);
    //$pdf->SetXY($set_x+97,$set_y);
    $pdf->Cell(45,5,utf8_decode(number_format($valor, 2)),0,1,'R',0);
    $devolucion += $valor;
    $n+=1;
  }
  $set_x = $pdf->GetX();
  $set_y = $pdf->GetY();
  $pdf->Line($set_x,$set_y,$set_x+200,$set_y);
  $pdf->Cell(164,5,"TOTAL DEVOLUCION",0,0,'L',0);
  //$pdf->SetXY($set_x+97,$set_y+$linea);
  $pdf->Cell(36,5,utf8_decode(number_format($devolucion, 2)),0,1,'R',0);
}

//DESGLOSE DE OTROS PAGOS REALIZADOS EN CAJA
$pdf->Cell(20,5,"",0,1,'C',0);
  //$pdf->SetXY($set_x, $set_y);
$pdf->Cell(200,5,utf8_decode("OTROS PAGOS"),0,1,'C',0);

//------------pagos con tarjeta
$sumatoria_tarjeta = 0;
$sql_tarjeta = _query("SELECT * FROM factura WHERE factura.id_apertura = '$id_apertura' AND credito = 2");
$cuenta_tarjeta = _num_rows($sql_tarjeta);
if($cuenta_tarjeta > 0){
  //$pdf->SetXY($set_x, $set_y);
  $set_x = $pdf->GetX();
  $set_y = $pdf->GetY();
  $pdf->Line($set_x,$set_y,$set_x+200,$set_y);
  $pdf->Cell(150,5,utf8_decode("TOTAL PAGOS CON TARJETA"),0,0,'L',0);

  while ($row_tarjeta = _fetch_array($sql_tarjeta))
  {
    $valor = $row_tarjeta['total'];
    $sumatoria_tarjeta += $valor;
  }

  $pdf->Cell(50,5,number_format($sumatoria_tarjeta, 2, '.', ','),0,1,'R',0);
}else {
  $set_x = $pdf->GetX();
  $set_y = $pdf->GetY();
  $pdf->Line($set_x,$set_y,$set_x+200,$set_y);
  $pdf->Cell(150,5,utf8_decode("TOTAL PAGOS CON TARJETA"),0,0,'L',0);
  $pdf->Cell(50,5,number_format(0, 2, '.', ','),0,1,'R',0);
}


//------------pagos con bitcoin
$sumatoria_bitcoin = 0;
$sql_btc = _query("SELECT * FROM factura WHERE factura.id_apertura = '$id_apertura' AND credito = 3");
$cuenta_btc = _num_rows($sql_btc);
if($cuenta_btc > 0){
  //$pdf->SetXY($set_x, $set_y);
  $pdf->Cell(150,5,utf8_decode("TOTAL PAGOS CON BITCOIN"),0,0,'L',0);

  while ($row_btc = _fetch_array($sql_btc))
  {
    $valor = $row_btc['total'];
    $sumatoria_bitcoin += $valor;
  }

  $pdf->Cell(50,5,number_format($sumatoria_bitcoin, 2, '.', ','),0,1,'R',0);
}else {
  $pdf->Cell(150,5,utf8_decode("TOTAL PAGOS CON BITCOIN"),0,0,'L',0);
  $pdf->Cell(50,5,number_format(0, 2, '.', ','),0,1,'R',0);
}

//------------pagos con transferencia
$sumatoria_tranferencia = 0;
$sql_transf = _query("SELECT * FROM factura WHERE factura.id_apertura = '$id_apertura' AND credito = 4");
$cuenta_transf = _num_rows($sql_transf);
if($cuenta_transf > 0){
  //$pdf->SetXY($set_x, $set_y);
  $pdf->Cell(150,5,utf8_decode("TOTAL PAGOS POR MEDIO DE TRANSFERENCIA"),0,0,'L',0);

  while ($row_transf = _fetch_array($sql_transf))
  {
    $valor = $row_transf['total'];
    $sumatoria_transferencia += $valor;
  }

  $pdf->Cell(50,5,number_format($sumatoria_transferencia, 2, '.', ','),0,1,'R',0);
}else {
  $pdf->Cell(150,5,utf8_decode("TOTAL PAGOS POR MEDIO DE TRANSFERENCIA"),0,0,'L',0);
  $pdf->Cell(50,5,number_format(0, 2, '.', ','),0,1,'R',0);
}

/////////////////Saldo caja

$pdf->Cell(20,5,"",0,1,'C',0);
//$pdf->SetXY($set_x, $set_y);
$pdf->Cell(200,5,utf8_decode("SALDO CAJA"),0,1,'C',0);
$set_x = $pdf->GetX();
$set_y = $pdf->GetY();
$pdf->Line($set_x,$set_y,$set_x+200,$set_y);
$pdf->Cell(150,5,utf8_decode("APERTURA DE CAJA"),0,0,'L',0);
$pdf->Cell(50,5,number_format($monto_apertura, 2, '.', ','),0,1,'R',0);

$pdf->Cell(150,5,utf8_decode("INGRESOS DEL DIA"),0,0,'L',0);
$pdf->Cell(50,5,number_format($total_doc, 2, '.', ','),0,1,'R',0);

$pdf->Cell(150,5,utf8_decode("COBROS CREDITO"),0,0,'L',0);
$pdf->Cell(50,5,number_format($total_cobros, 2, '.', ','),0,1,'R',0);


$pdf->Cell(150,5,utf8_decode("SALDO CAJA"),0,0,'L',0);
$pdf->Cell(50,5,number_format($total_mcaja, 2, '.', ','),0,1,'R',0);

$pdf->Cell(150,5,utf8_decode("DEVOLUCIONES"),0,0,'L',0);
$pdf->Cell(50,5,"-".number_format($devolucion, 2, '.', ','),0,1,'R',0);

$set_x = $pdf->GetX();
$set_y = $pdf->GetY();
$pdf->Line($set_x,$set_y,$set_x+200,$set_y);

$general = $monto_apertura + $total_doc + $total_mcaja + $total_cobros-$devolucion;
$pdf->Cell(150,5,utf8_decode("TOTAL"),0,0,'L',0);
$pdf->Cell(50,5,number_format($general, 2, '.', ','),0,1,'R',0);


ob_clean();
$pdf->Output("reporte_corte_caja.pdf","I");
