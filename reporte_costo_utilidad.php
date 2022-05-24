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
$fini = ($_REQUEST["fecha"]);
$fin = ($_REQUEST["ffin"]);
$fini1 = $_REQUEST["fini"];
$fin1 = $_REQUEST["ffin"];
$logo = "img/logo_sys.png";

$title = $nombre_a;
$titulo = "REPORTE DE INGRESOS Y EGRESOS";
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

      $this->Cell(100,6,utf8_decode($this->b),0,0,'L');
      $this->MultiCell(100,6,$this->a,0,'R',0);
      $this->SetFont('Latin','',12);
      $this->Cell(100,6,$this->c,0,0,'L');
      $this->SetFont('Latin','',10);
      $this->Cell(100,6,$this->d,0,1,'R');
      $this->SetFont('latin','',8);
      $this->Cell(20,5,"",0,1,'C',0);
      // //$pdf->SetXY($set_x, $set_y);
      // $this->Cell(20,5,utf8_decode("CODIGO"),0,0,'L',0);
      // //$pdf->SetXY($set_x+20,$set_y);
      // $this->Cell(147,5,utf8_decode("PRODUCTO"),0,0,'C',0);
      // //$pdf->SetXY($set_x+97,$set_y);
      // $this->Cell(18,5,utf8_decode("CANTIDAD"),0,0,'C',0);
      // //$pdf->SetXY($set_x+115,$set_y);
      // //$pdf->Cell(18,5,utf8_decode("COSTO"),0,0,'C',0);
      // //$pdf->SetXY($set_x+133,$set_y);
      // $this->Cell(18,5,utf8_decode("VENTA"),0,1,'C',0);
      // $set_x = $this->GetX();
      // $set_y = $this->GetY();
      // $this->Line($set_x,$set_y,$set_x+205,$set_y);
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
    public function setear($a,$b,$c,$d,$e,$f,$g)
    {
      # code...
      $this->a=$a;
      $this->b=$b;
      $this->c=$c;
      $this->d=$d;
      $this->e=$e;
      $this->f=$f;
      $this->g=$g;
    }
}

$pdf=new PDF('P','mm', 'Letter');
$pdf->setear($title,$empresa,$titulo,$fech,$n_sucursal,$id_traslado,$destino);
$pdf->SetMargins(10,5);
$pdf->SetTopMargin(8);
$pdf->SetLeftMargin(8);
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,20);
$pdf->AddFont("latin","","latin.php");
$pdf->AddPage();

//$pdf->AddPage();
$pdf->SetFont('latin','',9);
$pdf->Cell(20,5,utf8_decode("INGRESOS POR VENTA AL CONTADO"),0,1,'L',0);
$set_x = $pdf->GetX();
$set_y = $pdf->GetY();
$pdf->Line($set_x,$set_y,$set_x+205,$set_y);
$pdf->SetFont('latin','',8);
//$pdf->Cell(20,5,"",0,1,'C',0);
//$pdf->SetXY($set_x, $set_y);
$pdf->Cell(20,5,utf8_decode("CODIGO"),0,0,'L',0);
//$pdf->SetXY($set_x+20,$set_y);
$pdf->Cell(147,5,utf8_decode("PRODUCTO"),0,0,'C',0);
//$pdf->SetXY($set_x+97,$set_y);
$pdf->Cell(18,5,utf8_decode("CANTIDAD"),0,0,'C',0);
//$pdf->SetXY($set_x+115,$set_y);
//$pdf->Cell(18,5,utf8_decode("COSTO"),0,0,'C',0);
//$pdf->SetXY($set_x+133,$set_y);
$pdf->Cell(18,5,utf8_decode("VENTA"),0,1,'C',0);
//$pdf->SetXY($set_x+151,$set_y);
////$pdf->SetXY($set_x+169,$set_y);
//$pdf->Cell(18,5,utf8_decode("% UTIL."),0,0,'C',0);
//$pdf->SetXY($set_x+187,$set_y);
//$pdf->Cell(18,5,utf8_decode("MARGEN"),0,1,'C',0);

$set_x = $pdf->GetX();
$set_y = $pdf->GetY();
$pdf->Line($set_x,$set_y,$set_x+205,$set_y);




if($cuenta_egreso > 0)
{
  $row_eg = _fetch_array($sql_egreso);
  $egreso = $row_eg['egreso'];
}
else
{
  $ingreso = 0;
}
    //$pdf->SetTextColor(0,0,0);
$set_y = 50;
$linea = 0;
$j = 0;
$sum_cantidad = 0;
$sum_costo = 0;
$sum_venta = 0;
$sum_utilidad = 0;
$sum_porcentaje = 0;
$sum_margen = 0;
$sql_producto = _query("SELECT SUM(fd.cantidad) as cant, SUM(fd.precio_venta*fd.cantidad/pre.unidad) as precio, SUM(pre.costo*fd.cantidad/pre.unidad) as cost, p.descripcion, p.barcode, fd.id_prod_serv as idfd, p.id_producto as idp
  FROM factura_detalle as fd, presentacion_producto as pre, producto as p, factura as f
  WHERE p.id_producto = fd.id_prod_serv AND pre.id_pp = fd.id_presentacion AND f.id_factura=fd.id_factura AND f.tipo_documento!='DEV' AND f.tipo_documento!='NC' AND f.credito=0 AND f.anulada=0 AND f.finalizada=1 AND fd.fecha = '$fini' GROUP BY fd.id_prod_serv");
$cuenta = _num_rows($sql_producto);
if($cuenta > 0)
{

  while ($row = _fetch_array($sql_producto))
  {
    $barcode = $row["barcode"];
    $descripcion = $row["descripcion"];
    $costo = round($row["cost"], 4);
    $precio = round($row["precio"], 4);
    $cantidad = $row["cant"];

    $costo_final = $costo * $cantidad;
    $precio_final = $precio * $cantidad;
    $utilidad = round(($precio - $costo), 4);
    $por_utilidad = round(($utilidad/$costo),4)*100;
    $margen = round($utilidad/($costo / 1.13), 4)*100;
    //$pdf->SetXY($set_x, $set_y+$linea);
    $pdf->Cell(20,5,utf8_decode($barcode),0,0,'L',0);
    //$pdf->SetXY($set_x+20,$set_y+$linea);
    $pdf->Cell(147,5,utf8_decode($descripcion),0,0,'L',0);
    //$pdf->SetXY($set_x+97,$set_y+$linea);
    $pdf->Cell(18,5,utf8_decode(number_format($cantidad,0)),0,0,'C',0);
    //$pdf->SetXY($set_x+115,$set_y+$linea);
    //$pdf->Cell(18,5,utf8_decode(number_format($costo,2)),0,0,'C',0);
    //$pdf->SetXY($set_x+133,$set_y+$linea);
    $pdf->Cell(18,5,utf8_decode(number_format($precio, 2)),0,1,'C',0);
    //$pdf->SetXY($set_x+151,$set_y+$linea);
    //$pdf->Cell(18,5,utf8_decode(number_format($utilidad, 2)),0,0,'C',0);
    //$pdf->SetXY($set_x+169,$set_y+$linea);
    //$pdf->Cell(18,5,utf8_decode(number_format($por_utilidad,2)),0,0,'C',0);
    //$pdf->SetXY($set_x+187,$set_y+$linea);
    //$pdf->Cell(18,5,utf8_decode(number_format($margen, 2)),0,1,'C',0);
    $linea += 5;

    $sum_cantidad += $cantidad;
    $sum_costo += $costo;
    $sum_venta += $precio;
    $sum_utilidad += $utilidad;
    $sum_porcentaje += $por_utilidad;
    $sum_margen += $margen;
  }
}
$set_x = $pdf->GetX();
$set_y = $pdf->GetY();
$pdf->Line($set_x,$set_y,$set_x+205,$set_y);
//$pdf->SetXY($set_x, $set_y+$linea);
//$pdf->Cell(20,5,"",0,0,'L',0);
//$pdf->SetXY($set_x+20,$set_y+$linea);
$pdf->Cell(167,5,"TOTAL INGRESOS POR VENTA AL CONTADO",0,0,'L',0);
//$pdf->SetXY($set_x+97,$set_y+$linea);
$pdf->Cell(18,5,utf8_decode($sum_cantidad),0,0,'C',0);
//$pdf->SetXY($set_x+115,$set_y+$linea);
//$pdf->Cell(18,5,utf8_decode(number_format($sum_costo,2)),0,0,'C',0);
//$pdf->SetXY($set_x+133,$set_y+$linea);

$sql_query = _fetch_array(_query("SELECT SUM(factura.total) as venta FROM factura WHERE factura.fecha='$fini' AND credito=0 AND anulada = 0 AND finalizada=1 AND tipo_documento!='DEV' AND tipo_documento!='NC' "));

$sum_venta = round ($sql_query["venta"],4);

$pdf->Cell(18,5,utf8_decode(number_format($sum_venta, 2)),0,1,'C',0);
//$pdf->SetXY($set_x+151,$set_y+$linea);
//$pdf->Cell(18,5,utf8_decode(number_format($sum_utilidad, 2)),0,0,'C',0);
//$pdf->SetXY($set_x+169,$set_y+$linea);
//$pdf->Cell(18,5,utf8_decode(number_format($sum_porcentaje,2)),0,0,'C',0);
//$pdf->SetXY($set_x+187,$set_y+$linea);
//$pdf->Cell(18,5,utf8_decode(number_format($sum_margen, 2)),0,1,'C',0);
$ingreso = 0;
$sql_ingreso = _query("SELECT * FROM `mov_caja` WHERE entrada = 1 AND fecha = '$fini'");
$cuenta_ingreso = _num_rows($sql_ingreso);
if($cuenta_ingreso > 0)
{
  $pdf->Cell(20,5,"",0,1,'C',0);
  $pdf->SetFont('latin','',9);
  $pdf->Cell(20,5,utf8_decode("INGRESOS"),0,1,'L',0);
  $set_x = $pdf->GetX();
  $set_y = $pdf->GetY();
  $pdf->Line($set_x,$set_y,$set_x+205,$set_y);
  $pdf->SetFont('latin','',8);

  //$pdf->SetXY($set_x, $set_y);
  $pdf->Cell(20,5,utf8_decode("N°"),0,0,'L',0);
  //$pdf->SetXY($set_x+20,$set_y);
  $pdf->Cell(147,5,utf8_decode("DETALLE"),0,0,'L',0);
  //$pdf->SetXY($set_x+97,$set_y);
  $pdf->Cell(36,5,utf8_decode("TOTAL"),0,1,'R',0);
  //$pdf->SetXY($set_x+115,$set_y);
  //$pdf->Cell(18,5,utf8_decode("COSTO"),0,0,'C',0);
  //$pdf->SetXY($set_x+133,$set_y);
  //$pdf->Cell(18,5,utf8_decode("VENTA"),0,1,'C',0);
  //$pdf->SetXY($set_x+151,$set_y);
  ////$pdf->SetXY($set_x+169,$set_y);
  //$pdf->Cell(18,5,utf8_decode("% UTIL."),0,0,'C',0);
  //$pdf->SetXY($set_x+187,$set_y);
  //$pdf->Cell(18,5,utf8_decode("MARGEN"),0,1,'C',0);

  $set_x = $pdf->GetX();
  $set_y = $pdf->GetY();
  $pdf->Line($set_x,$set_y,$set_x+205,$set_y);
  $n = 1;
  while ($row_in = _fetch_array($sql_ingreso))
  {
    $valor = $row_in["valor"];
    $concepto = $row_in["concepto"];
    $pdf->Cell(20,5,utf8_decode($n),0,0,'L',0);
    //$pdf->SetXY($set_x+20,$set_y);
    $pdf->Cell(147,5,utf8_decode($concepto),0,0,'L',0);
    //$pdf->SetXY($set_x+97,$set_y);
    $pdf->Cell(36,5,utf8_decode(number_format($valor, 2)),0,1,'R',0);
    $ingreso += $valor;
    $n+=1;
  }
  $set_x = $pdf->GetX();
  $set_y = $pdf->GetY();
  $pdf->Line($set_x,$set_y,$set_x+205,$set_y);
  $pdf->Cell(167,5,"TOTAL INGRESOS",0,0,'L',0);
  //$pdf->SetXY($set_x+97,$set_y+$linea);
  $pdf->Cell(36,5,utf8_decode(number_format($ingreso, 2)),0,1,'R',0);
}

/////////////////////////////////////////Egresos

$egreso= 0;
$sql_egreso = _query("SELECT * FROM `mov_caja` WHERE salida = 1 AND fecha = '$fini'");
$cuenta_egreso = _num_rows($sql_egreso);
if($cuenta_egreso > 0)
{
  $pdf->Cell(20,5,"",0,1,'C',0);
  $pdf->SetFont('latin','',9);
  $pdf->Cell(20,5,utf8_decode("EGRESOS"),0,1,'L',0);
  $set_x = $pdf->GetX();
  $set_y = $pdf->GetY();
  $pdf->Line($set_x,$set_y,$set_x+205,$set_y);
  $pdf->SetFont('latin','',8);

  //$pdf->SetXY($set_x, $set_y);
  $pdf->Cell(20,5,utf8_decode("N°"),0,0,'L',0);
  //$pdf->SetXY($set_x+20,$set_y);
  $pdf->Cell(147,5,utf8_decode("DETALLE"),0,0,'L',0);
  //$pdf->SetXY($set_x+97,$set_y);
  $pdf->Cell(36,5,utf8_decode("TOTAL"),0,1,'R',0);
  //$pdf->SetXY($set_x+115,$set_y);
  //$pdf->Cell(18,5,utf8_decode("COSTO"),0,0,'C',0);
  //$pdf->SetXY($set_x+133,$set_y);
  //$pdf->Cell(18,5,utf8_decode("VENTA"),0,1,'C',0);
  //$pdf->SetXY($set_x+151,$set_y);
  ////$pdf->SetXY($set_x+169,$set_y);
  //$pdf->Cell(18,5,utf8_decode("% UTIL."),0,0,'C',0);
  //$pdf->SetXY($set_x+187,$set_y);
  //$pdf->Cell(18,5,utf8_decode("MARGEN"),0,1,'C',0);

  $set_x = $pdf->GetX();
  $set_y = $pdf->GetY();
  $pdf->Line($set_x,$set_y,$set_x+205,$set_y);
  $n = 1;
  while ($row_eg = _fetch_array($sql_egreso))
  {
    $valor = $row_eg["valor"];
    $concepto = $row_eg["concepto"];
    $pdf->Cell(20,5,utf8_decode($n),0,0,'L',0);
    //$pdf->SetXY($set_x+20,$set_y);
    $pdf->Cell(147,5,utf8_decode($concepto),0,0,'L',0);
    //$pdf->SetXY($set_x+97,$set_y);
    $pdf->Cell(36,5,utf8_decode(number_format($valor, 2)),0,1,'R',0);
    $egreso += $valor;
    $n+=1;
  }
  $set_x = $pdf->GetX();
  $set_y = $pdf->GetY();
  $pdf->Line($set_x,$set_y,$set_x+205,$set_y);
  $pdf->Cell(167,5,"TOTAL EGRESO",0,0,'L',0);
  //$pdf->SetXY($set_x+97,$set_y+$linea);
  $pdf->Cell(36,5,utf8_decode(number_format($egreso, 2)),0,1,'R',0);
}

//////////////Devoluciones
$devolucion = 0;
$sql_dev = _query("SELECT factura.numero_doc,factura.total,f.tipo_documento,f.numero_doc as doc FROM factura JOIN factura AS f ON f.id_factura=factura.afecta WHERE factura.tipo_documento IN ('DEV','NC') AND factura.fecha = '$fini'");
$cuenta_dev = _num_rows($sql_dev);
if($cuenta_dev > 0)
{
  $pdf->Cell(20,5,"",0,1,'C',0);
  $pdf->SetFont('latin','',9);
  $pdf->Cell(20,5,utf8_decode("DEVOLUCIONES"),0,1,'L',0);
  $set_x = $pdf->GetX();
  $set_y = $pdf->GetY();
  $pdf->Line($set_x,$set_y,$set_x+205,$set_y);
  $pdf->SetFont('latin','',8);

  //$pdf->SetXY($set_x, $set_y);
  $pdf->Cell(20,5,utf8_decode("N°"),0,0,'L',0);
  //$pdf->SetXY($set_x+20,$set_y);
  $pdf->Cell(50,5,utf8_decode("N° DOCUMENTO"),0,0,'L',0);
  $pdf->Cell(45,5,utf8_decode("DOC AFECTA"),0,0,'L',0);
  $pdf->Cell(45,5,utf8_decode("N° AFECTA"),0,0,'L',0);
  //$pdf->SetXY($set_x+97,$set_y);
  $pdf->Cell(45,5,utf8_decode("TOTAL"),0,1,'R',0);
  //$pdf->SetXY($set_x+115,$set_y);
  //$pdf->Cell(18,5,utf8_decode("COSTO"),0,0,'C',0);
  //$pdf->SetXY($set_x+133,$set_y);
  //$pdf->Cell(18,5,utf8_decode("VENTA"),0,1,'C',0);
  //$pdf->SetXY($set_x+151,$set_y);
  ////$pdf->SetXY($set_x+169,$set_y);
  //$pdf->Cell(18,5,utf8_decode("% UTIL."),0,0,'C',0);
  //$pdf->SetXY($set_x+187,$set_y);
  //$pdf->Cell(18,5,utf8_decode("MARGEN"),0,1,'C',0);

  $set_x = $pdf->GetX();
  $set_y = $pdf->GetY();
  $pdf->Line($set_x,$set_y,$set_x+205,$set_y);
  $n = 1;
  while ($row_dev = _fetch_array($sql_dev))
  {
    list($doca,$sa)=explode("_",$row_dev['numero_doc']);

    list($docb,$sb)=explode("_",$row_dev['doc']);
    $valor = $row_dev['total'];
    $pdf->Cell(20,5,utf8_decode($n),0,0,'L',0);
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
  $pdf->Line($set_x,$set_y,$set_x+205,$set_y);
  $pdf->Cell(167,5,"TOTAL DEVOLUCION",0,0,'L',0);
  //$pdf->SetXY($set_x+97,$set_y+$linea);
  $pdf->Cell(36,5,utf8_decode(number_format($devolucion, 2)),0,1,'R',0);
}


$set_x = $pdf->GetX();
$set_y = $pdf->GetY();
$pdf->SetXY($set_x,$set_y);
$pdf->Cell(185,5,"",0,1,'R',0);
$pdf->SetFont('latin','',10);
//$pdf->SetXY($set_x+169,$set_y+$linea);
$pdf->Cell(185,5,utf8_decode("(+) Ingresos por venta contado"),0,0,'R',0);
//$pdf->SetXY($set_x+187,$set_y+$linea);
$pdf->Cell(18,5,"$".utf8_decode(number_format($sum_venta, 2)),0,1,'R',0);

$pdf->Cell(185,5,utf8_decode("(+) Apertura de caja"),0,0,'R',0,0,'R',0);
//$pdf->SetXY($set_x+187,$set_y+$linea+5);
$sw=_fetch_array(_query("SELECT SUM(monto_apertura) as a,SUM(monto_ch) as b FROM apertura_caja WHERE fecha='$fini' AND id_sucursal=$id_sucursal"));
$apertura= round($sw['a']+$sw['b'],2);
$pdf->Cell(18,5,"$".utf8_decode(number_format($apertura, 2)),0,1,'R',0);

$pdf->Cell(185,5,utf8_decode("(=) Sub. Total"),0,0,'R',0,0,'R',0);
//$pdf->SetXY($set_x+187,$set_y+$linea+5);
$pdf->Cell(18,5,"$".utf8_decode(number_format($apertura+$sum_venta, 2)),0,1,'R',0);



$pdf->SetFont('latin','',10);
//$pdf->SetXY($set_x+169,$set_y+$linea+5);
$pdf->Cell(185,5,utf8_decode("(+) Ingresos"),0,0,'R',0,0,'R',0);
//$pdf->SetXY($set_x+187,$set_y+$linea+5);
$pdf->Cell(18,5,"$".utf8_decode(number_format($ingreso, 2)),0,1,'R',0);



$pdf->SetFont('latin','',10);
//$pdf->SetXY($set_x+169,$set_y+$linea+10);
$pdf->Cell(185,5,utf8_decode("(-) Egresos"),0,0,'R',0);
//$pdf->SetXY($set_x+187,$set_y+$linea+10);
$pdf->Cell(18,5,"$".utf8_decode(number_format($egreso, 2)),0,1,'R',0);

$pdf->SetFont('latin','',10);
//$pdf->SetXY($set_x+169,$set_y+$linea+10);
$pdf->Cell(185,5,utf8_decode("(-) Devoluciones"),0,0,'R',0);
//$pdf->SetXY($set_x+187,$set_y+$linea+10);
$pdf->Cell(18,5,"$".utf8_decode(number_format($devolucion, 2)),0,1,'R',0);


$sum_final = $sum_venta+$ingreso-$egreso - $devolucion+$apertura;
$set_x = $pdf->GetX();
$set_y = $pdf->GetY();
$pdf->Line($set_x+155,$set_y,$set_x+205,$set_y);
$pdf->SetFont('latin','',10);
//$pdf->SetXY($set_x+169,$set_y+$linea+15);
$pdf->Cell(185,5,utf8_decode("(=) Total"),0,0,'R',0);
//$pdf->SetXY($set_x+187,$set_y+$linea+15);
$pdf->Cell(18,5,"$".utf8_decode(number_format($sum_final, 2)),0,1,'R',0);

ob_clean();
$pdf->Output("reporte_valoracion_inventario.pdf","I");
