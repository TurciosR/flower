<?php
//error_reporting(E_ERROR | E_PARSE);
require("_core.php");
require("num2letras.php");
require('fpdf/fpdf.php');

$fini = $_REQUEST["fini"];
$fin = $_REQUEST["ffin"];


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
        $this->MultiCell(140,5,utf8_decode((Mayu(utf8_decode("Sucursal ".": ".$this->c)))),0,'C',0);
        $this->Cell(195,6,$this->b,0,1,'C');
        $this->Cell(195,6,utf8_decode("REPORTE DE VENTAS POR TIPO DE DOCUMENTO"),0,1,'C');
        $this->Cell(195,6,utf8_decode("SOLO DOCUMENTOS FINALIZADOS, NO ANULADOS, NO TOMANDO EN CUENTA DEVOLUCIONES SOBRE VENTAS"),0,1,'C');
        $this->Cell(195,6,$this->d,0,1,'C');
        // Salto de línea
        $this->Ln(5);
        $set_y=$this->GetY();
        $set_x=$this->GetX();
        $this->SetXY($set_x, $set_y);
        $this->AddFont('latin','','latin.php');
        $this->SetFont('latin', '', 9);

        $this->Cell(45,5,"FECHA",1,0,'L',0);
        $this->Cell(50,5,"CREDITO FISCAL",1,0,'L',0);
        $this->Cell(50,5,"FACTURA CONSUMIDOR",1,0,'L',0);
        $this->Cell(50,5,"TICKET",1,1,'L',0);
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
$pdf->setear($nombre_a,$telefonos,$direccion,$fech,$n_sucursal,"","","");
$pdf->SetMargins(10, 10);
$pdf->SetLeftMargin(10);
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 15);
$pdf->AliasNbPages();
$pdf->AddPage();
$fk=$fini;
$empleados = array();

$arrayt = array(
  'TIK' => 0,
  'CCF' => 0,
  'COF' => 0,
);
while(strtotime($fk) <= strtotime($fin))
{
  $fecha_actual = $fk;
  $sql=_query("SELECT SUM(total_menos_retencion) as total ,tipo_documento FROM factura  WHERE factura.fecha='$fecha_actual' AND finalizada=1 AND anulada=0 AND tipo_documento!='DEV' AND tipo_documento!='NC' GROUP BY tipo_documento");

  if(_num_rows($sql)>0)
  {

    $pdf->Cell(45,5,ED($fecha_actual),1,0,'C',0);

    $array = array(
      'TIK' => 0,
      'CCF' => 0,
      'COF' => 0,
    );

    while ($row = _fetch_array($sql)) {
      switch ($row['tipo_documento']) {
        case 'TIK':
          $array['TIK'] = $row['total'];
          $arrayt['TIK'] = $arrayt['TIK'] + number_format($row['total'],2,".","");
          break;
        case 'CCF':
          $array['CCF'] = $row['total'];
          $arrayt['CCF'] = $arrayt['CCF'] + number_format($row['total'],2,".","");
          break;
        case 'COF':
          $array['COF'] = $row['total'];
          $arrayt['COF'] = $arrayt['COF'] + number_format($row['total'],2,".","");
          break;
        default:
          break;
      }
    }

    $pdf->Cell(50,5,"$ ".number_format(($array['CCF']),2,".",""),1,0,'R',0);
    $pdf->Cell(50,5,"$ ".number_format(($array['COF']),2,".",""),1,0,'R',0);
    $pdf->Cell(50,5,"$ ".number_format(($array['TIK']),2,".",""),1,1,'R',0);

  }

  $fk = sumar_dias(ED($fk),1);
  $fk = MD($fk);
}

$pdf->Cell(45,5,"TOTALES",1,0,'L',0);
$pdf->Cell(50,5,"$ ".number_format(($arrayt['CCF']),2,".",""),1,0,'R',0);
$pdf->Cell(50,5,"$ ".number_format(($arrayt['COF']),2,".",""),1,0,'R',0);
$pdf->Cell(50,5,"$ ".number_format(($arrayt['TIK']),2,".",""),1,1,'R',0);


ob_clean();
$pdf->Output("REPORTES_VENTAS_DOCUMENTO.pdf","I");
