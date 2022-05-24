<?php
error_reporting(E_ERROR | E_PARSE);
require('_core.php');
require('fpdf/fpdf.php');

$fecha_inicio= $_GET['fini'];
$fecha_fin= $_GET['ffin'];
$fini1 = $_REQUEST["fini"];
$fin1 = $_REQUEST["ffin"];
$fecha_ini= ed($fecha_inicio);
$fecha_fina=ed($fecha_fin);
$sql_empresa=_query("SELECT * FROM sucursal where id_sucursal=$_SESSION[id_sucursal]");
$array_empresa=_fetch_array($sql_empresa);
$nombre_empresa=$array_empresa['descripcion'];
$telefono=$array_empresa['telefono1'];
$logo_empresa=$array_empresa['logo'];

$id_user=$_SESSION["id_usuario"];
$id_sucursal=$_SESSION['id_sucursal'];

$sql_sucursal=_query("SELECT * FROM sucursal WHERE id_sucursal='$id_sucursal'");
$array_sucursal=_fetch_array($sql_sucursal);
$nombre_sucursal=$array_sucursal['descripcion'];

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
    $this->Image('img/logo_sys.png', 10, 10, 33);
    $this->AddFont('latin','','latin.php');
    $this->SetFont('latin', '', 10);
    // Movernos a la derecha
    // Título
    $this->Cell(260, 4, utf8_decode($this->d), 0, 1, 'C');
    $this->Cell(260, 4, 'REPORTE FISCAL', 0, 1, 'C');
    $this->Cell(260, 4, 'DESDE '.$this->a." HASTA ".$this->b, 0, 1, 'C');
    $this->Cell(260, 4, 'FECHA DE IMPRESION: '.$this->c, 0, 1, 'C');
    // Salto de línea

    $aSz = $this->e;

    $sh=$aSz['inicio']+$aSz['fin']+$aSz['total']+$aSz['ex']+$aSz['giv']+$aSz['ret'];
    $this->Ln(5);

    if ($this->f==0) {
      // code...
      $set_y=$this->GetY();
      $set_x=$this->GetX();
      $this->SetXY($set_x, $set_y);

      $gy = $this->GetY();
      $this->AddFont('latin','','latin.php');
      $this->SetFont('latin', '', 9);

      $this->Cell($aSz['fecha'],10,utf8_decode("FECHA"),1,0,'C',0);
      $this->Cell($aSz['sucursal'],10,utf8_decode("SUC"),1,0,'C',0);
      $this->Cell($sh,5,utf8_decode("TIQUETE"),1,0,'C',0);

      $gx = $this->GetX();
      $this->Cell($sh,5,"FACTURA",1,0,'C',0);
      $this->Cell($sh,5,"CREDITO FISCAL",1,1,'C',0);

      $this->Cell(($aSz['fecha']+$aSz['sucursal']),5,utf8_decode(""),0,0,'C',0);
      $this->Cell($aSz['inicio'],5,utf8_decode("INICIO"),1,0,'C',0);
      $this->Cell($aSz['fin'],5,utf8_decode("FIN"),1,0,'C',0);
      $this->Cell($aSz['ex'],5,utf8_decode("E"),1,0,'C',0);
      $this->Cell($aSz['giv'],5,utf8_decode("G+IVA"),1,0,'C',0);

      $this->Cell($aSz['ret'],5,utf8_decode("RET"),1,0,'C',0);

      $this->Cell($aSz['total'],5,"TOTAL",1,0,'C',0);
      $this->Cell($aSz['inicio'],5,utf8_decode("INICIO"),1,0,'C',0);
      $this->Cell($aSz['fin'],5,utf8_decode("FIN"),1,0,'C',0);
      $this->Cell($aSz['ex'],5,utf8_decode("E"),1,0,'C',0);
      $this->Cell($aSz['giv'],5,utf8_decode("G+IVA"),1,0,'C',0);

      $this->Cell($aSz['ret'],5,utf8_decode("RET"),1,0,'C',0);

      $this->Cell($aSz['total'],5,"TOTAL",1,0,'C',0);
      $this->Cell($aSz['inicio'],5,utf8_decode("INICIO"),1,0,'C',0);
      $this->Cell($aSz['fin'],5,utf8_decode("FIN"),1,0,'C',0);
      $this->Cell($aSz['ex'],5,utf8_decode("E"),1,0,'C',0);
      $this->Cell($aSz['giv'],5,utf8_decode("G+IVA"),1,0,'C',0);

      $this->Cell($aSz['ret'],5,utf8_decode("RET"),1,0,'C',0);

      $this->Cell($aSz['total'],5,"TOTAL",1,0,'C',0);



      $this->SetY($gy);
      $this->SetX($gx+$sh+$sh);
      $this->Cell($aSz['totalgen'],5,"TOTAL","TLR",1,'C',0);
      $this->SetX($gx+$sh+$sh);
      $this->Cell($aSz['totalgen'],5,"GENERAL","BLR",1,'C',0);
    }

  }

  public function Footer()
  {
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial', 'I', 8);
    // Número de página requiere $pdf->AliasNbPages();
    //utf8_decode() de php que convierte nuestros caracteres a ISO-8859-1
    $this-> Cell(100, 10, utf8_decode('Fecha de impresión: '.date('Y-m-d')), 0, 0, 'L');
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
  function array_procesor($array)
  {
    $ygg=0;
    $maxlines=1;
    $array_a_retornar=array();
    foreach ($array as $key => $value) {
      /*Descripcion*/
      $nombr=$value[0];
      /*character*/
      $longitud=$value[1];
      /*fpdf width*/
      $size=$value[2];
      /*fpdf alignt*/
      $aling=$value[3];
      if(strlen($nombr) > $longitud)
      {
        $i=0;
        $nom = divtextlin($nombr, $longitud);
        foreach ($nom as $nnon)
        {
          $array_a_retornar[$ygg]["valor"][]=$nnon;
          $array_a_retornar[$ygg]["size"][]=$size;
          $array_a_retornar[$ygg]["aling"][]=$aling;
          $i++;
        }
        $ygg++;
        if ($i>$maxlines) {
          // code...
          $maxlines=$i;
        }
      }
      else {
        // code...
        $array_a_retornar[$ygg]['valor'][]=$nombr;
        $array_a_retornar[$ygg]['size'][]=$size;
        $array_a_retornar[$ygg]["aling"][]=$aling;
        $ygg++;

      }
    }

    $ygg=0;
    foreach($array_a_retornar as $keys)
    {
      for ($i=count($keys["valor"]); $i <$maxlines ; $i++) {
        // code...
        $array_a_retornar[$ygg]["valor"][]="";
        $array_a_retornar[$ygg]["size"][]=$array_a_retornar[$ygg]["size"][0];
        $array_a_retornar[$ygg]["aling"][]=$array_a_retornar[$ygg]["aling"][0];
      }
      $ygg++;
    }

    $data=$array_a_retornar;
    $total_lineas=count($data[0]["valor"]);
    $total_columnas=count($data);

    for ($i=0; $i < $total_lineas; $i++) {
      // code...
      for ($j=0; $j < $total_columnas; $j++) {
        // code...
        $salto=0;
        $abajo=0;
        if ($i==0) {
          // code...
          $abajo="TLR";
        }
        if ($j==$total_columnas-1) {
          // code...
          $salto=1;
        }
        if ($i==$total_lineas-1) {
          // code...
          $abajo="BLR";
        }
        $this->Cell($data[$j]["size"][$i],5,utf8_decode($data[$j]["valor"][$i]),$abajo,$salto,$data[$j]["aling"][$i]);
      }

    }
    //return $array_a_retornar;

  }

}

$aSz = array(
  'fecha' => 17,
  'sucursal' => 8,
  'inicio' => 12,
  'fin' =>12,
  'ex' =>15,
  'giv' =>14,
  'ret' => 10,
  'total' => 14,
  'totalgen' => 15,
);


$fecha_impresion = date("d-m-Y")." ".hora(date("H:i:s"));
$pdf = new PDF('L', 'mm', 'letter');

$pdf->setear($fecha_ini,$fecha_fina,$fecha_impresion,$nombre_empresa,$aSz,0);
$pdf->SetMargins(10, 10);
$pdf->SetLeftMargin(4);
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 15);
$pdf->AliasNbPages();
$pdf->AddPage();
$fk = $fini1;

$tAry = array(
  'te' => 0,
  'tg' => 0,
  'tt' => 0,
  'tret' => 0,
  'fe' => 0,
  'fg' => 0,
  'ft' => 0,
  'fret' => 0,
  'ce' => 0,
  'cg' => 0,
  'ct' => 0,
  'cret' => 0,
  'ttg' => 0,
);

while(strtotime($fk) <= strtotime($fin1))
{
  $fk = ($fk);
  $sql_efectivo = _query("SELECT * FROM factura WHERE fecha = '$fk' AND finalizada=1 AND anulada=0 AND id_sucursal = '$id_sucursal'");
  $cuenta = _num_rows($sql_efectivo);
  $sql_min_max=_query("
  SELECT MIN(CAST(num_fact_impresa as UNSIGNED)) as minimo, MAX(CAST(num_fact_impresa as UNSIGNED)) as maximo FROM factura WHERE fecha = '$fk' AND numero_doc LIKE '%TIK%' AND id_sucursal = $id_sucursal UNION ALL
  SELECT MIN(CAST(num_fact_impresa as UNSIGNED)) as minimo, MAX(CAST(num_fact_impresa as UNSIGNED)) as maximo FROM factura WHERE fecha = '$fk' AND numero_doc LIKE '%COF%' AND id_sucursal = $id_sucursal UNION ALL
  SELECT MIN(CAST(num_fact_impresa as UNSIGNED)) as minimo, MAX(CAST(num_fact_impresa as UNSIGNED)) as maximo FROM factura WHERE fecha = '$fk' AND numero_doc LIKE '%CCF%' AND id_sucursal = $id_sucursal");
  $cuenta_min_max = _num_rows($sql_min_max);
  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  $total_tike = 0;
  $total_factura = 0;
  $total_credito_fiscal = 0;
  $tike_min = 0;
  $tike_max = 0;
  $factura_min = 0;
  $factura_max = 0;
  $credito_fiscal_min = 0;
  $credito_fiscal_max = 0;

  $tret = 0;
  $fret = 0;
  $cret = 0;

  $exent_t = array(
    'TIK' => 0,
    'COF' => 0,
    'CCF' => 0
  );
  if($cuenta > 0)
  {
      while ($row_corte = _fetch_array($sql_efectivo))
      {
          $id_factura = $row_corte["id_factura"];
          $anulada = $row_corte["anulada"];
          $subtotal = $row_corte["subtotal"];
          $suma = $row_corte["suma"];
          $iva = $row_corte["iva"];
          $total = $row_corte["total"];
          $numero_doc = $row_corte["numero_doc"];
          $ax = explode("_", $numero_doc);
          $numero_co = $ax[0];
          $alias_tipodoc = $ax[1];
          $tipo_pago = $row_corte["tipopago"];
          $total_iva = $row_corte["total_iva"];
          $total = $row_corte["total"];


          if($alias_tipodoc == 'TIK')
          {
            $exent_t[$alias_tipodoc]+=$row_corte['venta_exenta'];
            $total_tike += $total;
            $tret +=$row_corte['retencion'];

          }
          else if($alias_tipodoc == 'COF')
          {
            $exent_t[$alias_tipodoc]+=$row_corte['venta_exenta'];
            $total_factura += $total;
            $fret +=$row_corte['retencion'];
          }
          else if($alias_tipodoc == 'CCF')
          {
            $exent_t[$alias_tipodoc]+=$row_corte['venta_exenta'];
            $total_credito_fiscal += $total;
            $cret +=$row_corte['retencion'];
          }




      }
  }

  if($cuenta_min_max)
  {
      $i = 1;
      while ($row_min_max = _fetch_array($sql_min_max))
      {
          if($i == 1)
          {
            $tike_min = $row_min_max["minimo"];
            $tike_max = $row_min_max["maximo"];
              list($minimo_num,$ads) = explode("_", $tike_min);
              list($maximo_num,$ads) = explode("_", $tike_max);
          }
          if($i == 2)
          {
              $factura_min = $row_min_max["minimo"];
              $factura_max = $row_min_max["maximo"];
          }
          if($i == 3)
          {
              $credito_fiscal_min = $row_min_max["minimo"];
              $credito_fiscal_max = $row_min_max["maximo"];
              $mi = explode("_", $credito_fiscal_min);
              $minimo_num = $$tAry['te']+=$exent_t['TIK'];mi[0];
              $max = explode("_", $credito_fiscal_max);
              $maximo_num = $max[0];
          }
          $i += 1;
      }
  }




  $total_general = $total_tike + $total_factura + $total_credito_fiscal - $tret -  $fret -  $cret;

  $fk = ED($fk);

  $pdf->Cell($aSz['fecha'],5,utf8_decode("$fk"),1,0,'C',0);
  $pdf->Cell($aSz['sucursal'],5,utf8_decode($id_sucursal),1,0,'C',0);

  $pdf->Cell($aSz['inicio'],5,utf8_decode(intval($tike_min)),1,0,'C',0);
  $pdf->Cell($aSz['fin'],5,utf8_decode(intval($tike_max)),1,0,'C',0);
  $pdf->Cell($aSz['ex'],5,number_format($exent_t['TIK'], 2),1,0,'C',0);
  $pdf->Cell($aSz['giv'],5,number_format($total_tike-$exent_t['TIK'], 2),1,0,'C',0);
  $pdf->Cell($aSz['ret'],5,number_format($tret, 2),1,0,'C',0);
  $pdf->Cell($aSz['total'],5,number_format($total_tike-$tret, 2),1,0,'R',0);

  $pdf->Cell($aSz['inicio'],5,utf8_decode(intval($factura_min)),1,0,'C',0);
  $pdf->Cell($aSz['fin'],5,utf8_decode(intval($factura_max)),1,0,'C',0);
  $pdf->Cell($aSz['ex'],5,number_format($exent_t['COF'], 2),1,0,'C',0);
  $pdf->Cell($aSz['giv'],5,number_format($total_factura-$exent_t['COF'], 2),1,0,'C',0);
  $pdf->Cell($aSz['ret'],5,number_format($fret, 2),1,0,'C',0);
  $pdf->Cell($aSz['total'],5,number_format($total_factura-$fret, 2),1,0,'R',0);

  $pdf->Cell($aSz['inicio'],5,utf8_decode(intval($credito_fiscal_min)),1,0,'C',0);
  $pdf->Cell($aSz['fin'],5,utf8_decode(intval($credito_fiscal_max)),1,0,'C',0);
  $pdf->Cell($aSz['ex'],5,number_format($exent_t['CCF'], 2),1,0,'C',0);
  $pdf->Cell($aSz['giv'],5,number_format($total_credito_fiscal-$exent_t['CCF'], 2),1,0,'C',0);
  $pdf->Cell($aSz['ret'],5,number_format($cret, 2),1,0,'C',0);
  $pdf->Cell($aSz['total'],5,number_format($total_credito_fiscal-$cret, 2),1,0,'R',0);

  $pdf->Cell($aSz['totalgen'],5,number_format($total_general, 2),1,1,'R',0);

  $tAry['te']+=$exent_t['TIK'];
  $tAry['fe']+=$exent_t['COF'];
  $tAry['ce']+=$exent_t['CCF'];

  $tAry['tg']+=$total_tike-$exent_t['TIK'];
  $tAry['fg']+=$total_factura-$exent_t['COF'];
  $tAry['cg']+=$total_credito_fiscal-$exent_t['CCF'];

  $tAry['tt']+=$total_tike-$tret;
  $tAry['ft']+=$total_factura-$fret;
  $tAry['ct']+=$total_credito_fiscal-$cret;

  $tAry['tret']+=$tret;
  $tAry['fret']+=$fret;
  $tAry['cret']+=$cret;

  $tAry['ttg']+=$total_general;

  $fk = sumar_dias($fk,1);

  $fk = MD($fk);
}
$pdf->Cell($aSz['fecha']+$aSz['sucursal'],5,"TOTAL",1,0,'C',0);

$pdf->Cell($aSz['inicio'],5,"","BT",0,'C',0);
$pdf->Cell($aSz['fin'],5,"","BT",0,'C',0);
$pdf->Cell($aSz['ex'],5,number_format($tAry['te'], 2),1,0,'C',0);
$pdf->Cell($aSz['giv'],5,number_format($tAry['tg'], 2),1,0,'C',0);
$pdf->Cell($aSz['ret'],5,number_format($tAry['tret'], 2),1,0,'C',0);
$pdf->Cell($aSz['total'],5,number_format($tAry['tt'], 2),1,0,'R',0);

$pdf->Cell($aSz['inicio'],5,"","BT",0,'C',0);
$pdf->Cell($aSz['fin'],5,"","BT",0,'C',0);
$pdf->Cell($aSz['ex'],5,number_format($tAry['fe'], 2),1,0,'C',0);
$pdf->Cell($aSz['giv'],5,number_format($tAry['fg'], 2),1,0,'C',0);
$pdf->Cell($aSz['ret'],5,number_format($tAry['fret'], 2),1,0,'C',0);
$pdf->Cell($aSz['total'],5,number_format($tAry['ft'], 2),1,0,'R',0);

$pdf->Cell($aSz['inicio'],5,"","BT",0,'C',0);
$pdf->Cell($aSz['fin'],5,"","BT",0,'C',0);
$pdf->Cell($aSz['ex'],5,number_format($tAry['ce'], 2),1,0,'C',0);
$pdf->Cell($aSz['giv'],5,number_format($tAry['cg'], 2),1,0,'C',0);
$pdf->Cell($aSz['ret'],5,number_format($tAry['cret'], 2),1,0,'C',0);
$pdf->Cell($aSz['total'],5,number_format($tAry['ct'], 2),1,0,'R',0);

$pdf->Cell($aSz['totalgen'],5,number_format($tAry['ttg'], 2),1,1,'R',0);


$pdf->setear($fecha_ini,$fecha_fina,$fecha_impresion,$nombre_empresa,$aSz,1);
$pdf->addPage();
$pdf->Cell(263,5,"DOCUMENTOS ANULADOS","B",1,'L',0);

$fk = $fini1;
while(strtotime($fk) <= strtotime($fin1))
{
  $sql_fa = _query("SELECT * FROM factura WHERE fecha = '$fk'  AND anulada=1 AND num_fact_impresa>0 AND id_sucursal = '$id_sucursal'");
  $fk = ED($fk);
  if (_num_rows($sql_fa)>0) {
    // code...

    while ($row=_fetch_array($sql_fa)) {
      // code...
      $pdf->Cell(18,5,$fk,0,0,'L',0);
      $pdf->Cell(15,5,$row['tipo_documento'],0,0,'L',0);
      $pdf->Cell(15,5,$row['num_fact_impresa'],0,0,'L',0);
      $pdf->Cell(15,5,$row['nombre'],0,1,'L',0);

    }
  }
  $fk = sumar_dias($fk,1);
  $fk = MD($fk);
}


$pdf->Output("reporte_fiscal.pdf", "I");
