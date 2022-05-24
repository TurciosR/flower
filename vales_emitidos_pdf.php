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
$fini = ($_REQUEST["fini"]);
$fin = ($_REQUEST["ffin"]);
$logo = "img/logo_sys.png";

$title = $nombre_a;
$titulo = "REPORTE DE VALES EMITIDOS";
if($fini!="" && $fin!="")
{
    list($a,$m,$d) = explode("-", $fin);

    list($ai,$mi,$di) = explode("-", $fini);

    $fech="DESDE EL $di ".meses($mi)." $ai AL $d DE ".meses($m)." DE $a";

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
$set_x = $pdf->GetX();
$set_y = $pdf->GetY();
$pdf->Line($set_x,$set_y,$set_x+200,$set_y);
$pdf->SetFont('latin','',8);


$tcon = "salida";
$sql_lista = _query("SELECT * FROM mov_caja WHERE  idtransace=0 AND fecha between '$fini' AND '$fin' AND id_sucursal = '$id_sucursal'  AND $tcon = '1' AND alias_tipodoc!='DEV'");
$cuenta = _num_rows($sql_lista);
if($cuenta > 0)
{
  $pdf->Cell(20,5,utf8_decode("SALIDAS"),0,1,'L',0);
  $tot = 0;
  $pdf->Cell(20,5,utf8_decode("FECHA"),0,0,'L',0);
  $pdf->Cell(20,5,utf8_decode("HORA"),0,0,'L',0);
  $pdf->Cell(140,5,utf8_decode("CONCEPTO"),0,0,'L',0);
  $pdf->Cell(20,5,utf8_decode("VALOR"),0,1,'L',0);
  while ($row = _fetch_array($sql_lista))
  {
    $numero_doc = intval($row["id_movimiento"]);
    $concepto = $row["concepto"];
    $fecha = $row["fecha"];
    $hora = hora($row["hora"]);
    $tot += $row["valor"];
    $pdf->Cell(20,5,utf8_decode(ED($fecha)),0,0,'L',0);
    $pdf->Cell(20,5,utf8_decode($hora),0,0,'R',0);
    $pdf->Cell(140,5,utf8_decode($concepto),0,0,'L',0);
    $pdf->Cell(20,5,utf8_decode(number_format($row['valor'],2)),0,1,'R',0);
  }

  $pdf->Cell(180,5,utf8_decode("TOTAL SALIDAS"),0,0,'L',0);
  $pdf->Cell(20,5,utf8_decode(number_format($tot,2)),0,1,'R',0);
  $pdf->Ln(5);
}

$tcon = "entrada";

$sql_lista = _query("SELECT * FROM mov_caja WHERE  idtransace=0 AND fecha between '$fini' AND '$fin' AND id_sucursal = '$id_sucursal'  AND $tcon = '1' AND alias_tipodoc!='DEV'");
$cuenta = _num_rows($sql_lista);
if($cuenta > 0)
{
  $pdf->Cell(20,5,utf8_decode("ENTRADAS"),0,1,'L',0);
  $tot = 0;
  $pdf->Cell(20,5,utf8_decode("FECHA"),0,0,'L',0);
  $pdf->Cell(20,5,utf8_decode("HORA"),0,0,'L',0);
  $pdf->Cell(140,5,utf8_decode("CONCEPTO"),0,0,'L',0);
  $pdf->Cell(20,5,utf8_decode("VALOR"),0,1,'L',0);
  while ($row = _fetch_array($sql_lista))
  {
    $numero_doc = intval($row["id_movimiento"]);
    $concepto = $row["concepto"];
    $fecha = $row["fecha"];
    $hora = hora($row["hora"]);
    $tot += $row["valor"];
    $pdf->Cell(20,5,utf8_decode(ED($fecha)),0,0,'L',0);
    $pdf->Cell(20,5,utf8_decode($hora),0,0,'R',0);
    $pdf->Cell(140,5,utf8_decode($concepto),0,0,'L',0);
    $pdf->Cell(20,5,utf8_decode(number_format($row['valor'],2)),0,1,'R',0);
  }

  $pdf->Cell(180,5,utf8_decode("TOTAL ENTRADAS"),0,0,'L',0);
  $pdf->Cell(20,5,utf8_decode(number_format($tot,2)),0,1,'R',0);
}


ob_clean();
$pdf->Output("vales_emitidos.pdf","I");
