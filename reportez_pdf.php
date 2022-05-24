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

$sql_cabezera = _query("SELECT * FROM sucursal WHERE id_sucursal = '$id_sucursal'");
$cue = _num_rows($sql_cabezera);
$row_cabe = _fetch_array($sql_cabezera);

$nite=$row_cabe['nit'];
$nrce=$row_cabe['nrc'];
$empresa1=$row_cabe['descripcion'];
$razonsocial1=$row_cabe['razonsocial'];
$giro1=$row_cabe['giro'];
$direccion = $row_cabe['direccion'];



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
      $this->AddFont("courier new","","courier.php");
      $this->SetFont('courier new','',9);

  }

  public function Footer()
  {
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
$pdf = new PDF('L', 'mm');

$pdf->setear($fecha_ini,$fecha_fina,$fecha_impresion,$nombre_empresa,$aSz,0);
$pdf->SetMargins(10, 4);
$pdf->SetLeftMargin(2);
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 15);
$pdf->AliasNbPages();
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

  $sql_fa = _query("SELECT * FROM factura WHERE fecha = '$fk' AND tipo_documento!='TIK'  AND anulada=1 AND num_fact_impresa>0 AND id_sucursal = '$id_sucursal'");
  $fk = ED($fk);

  if($total_general!=0)
  {

    $pdf->AddPage('P', array(85, 215+(_num_rows($sql_fa)*7)));
    $sqlcc = _fetch_array(_query("SELECT MAX(caja) as caja FROM factura WHERE fecha='".MD($fk)."'"));

    $sql_caja = _query("SELECT * FROM caja WHERE id_caja='$sqlcc[caja]'");

    $direccio=divtextlin($direccion,35);
    $empress= divtextlin($empresa1, 35);
    $giros = divtextlin($giro1, 35);
    foreach ($empress as $nnona)
    {
      $pdf->Cell(81,5,($nnona),0,1,'C');
    }
    foreach ($direccio as $nnona)
    {
      $pdf->Cell(81,5,($nnona),0,1,'C');
    }
    foreach ($giros as $nnon)
    {
      $pdf->Cell(81,5,utf8_decode($nnon),0,1,'C');
    }
    $pdf->Cell(85,5,utf8_decode("NIT: ".$nite."  NRC: ".$nrce),0,1,'C');
    if(_num_rows($sql_caja)>0)
    {

      $dats_caja = _fetch_array($sql_caja);
      $fehca = ED($dats_caja["fecha"]);
      $resolucion = $dats_caja["resolucion"];
      $serie = $dats_caja["serie"];
      $desde = $dats_caja["desde"];
      $hasta = $dats_caja["hasta"];
      $nombre_c = $dats_caja["nombre"];

      $pdf->Cell(85,5,utf8_decode("RESOLUCIÓN: ".$resolucion),0,1,'C');
      $pdf->Cell(85,5,utf8_decode("DEL: ".$desde." AL: ".$hasta),0,1,'C');
      $pdf->Cell(85,5,utf8_decode("SERIE: ".$serie),0,1,'C');
      $pdf->Cell(85,5,utf8_decode("FECHA RESOLUCIÓN: ".$fehca),0,1,'C');

    }
    $pdf->Ln(5);
    $pdf->Cell(81,4,"TIQUETE #".utf8_decode(intval($tike_max+1)),0,1,'C',0);


    $pdf->Cell(81,4,"".utf8_decode("FECHA: ".$fk),0,1,'C',0);
    $pdf->Cell(81,4,"VENTAS CON TIQUETE",0,1,'L',0);
    $pdf->Cell(41,4,"No. INICIAL:",0,0,'L',0);
    $pdf->Cell(40,4,utf8_decode(intval($tike_min)),0,1,'R',0);
    $pdf->Cell(41,4,"No. FINAL:",0,0,'L',0);
    $pdf->Cell(40,4,utf8_decode(intval($tike_max)),0,1,'R',0);

    $pdf->Cell(41,4,"VENTAS EXENTAS:",0,0,'L',0);
    $pdf->Cell(40,4,"$ ".number_format($exent_t['TIK'], 2),0,1,'R',0);
    $pdf->Cell(41,4,"VENTAS GRAVADAS:",0,0,'L',0);
    $pdf->Cell(40,4,"$ ".number_format($total_tike-$exent_t['TIK'], 2),0,1,'R',0);
    $pdf->Cell(41,4,"VENTAS NO SUJETAS:",0,0,'L',0);
    $pdf->Cell(40,4,"$ ".number_format(0, 2),0,1,'R',0);
    $pdf->Cell(41,4,"RETENCION:",0,0,'L',0);
    $pdf->Cell(40,4,"$ ".number_format($tret, 2),0,1,'R',0);
    $pdf->Cell(41,4,"TOTAL:",0,0,'L',0);
    $pdf->Cell(40,4,"$ ".number_format($total_tike-$tret, 2),0,1,'R',0);

    $pdf->Ln(5);
    $pdf->Cell(81,4,"VENTAS CON FACTURA",0,1,'L',0);
    $pdf->Cell(41,4,"No. INICIAL:",0,0,'L',0);
    $pdf->Cell(40,4,utf8_decode(intval($factura_min)),0,1,'R',0);
    $pdf->Cell(41,4,"No. FINAL:",0,0,'L',0);
    $pdf->Cell(40,4,utf8_decode(intval($factura_max)),0,1,'R',0);

    $pdf->Cell(41,4,"VENTAS EXENTAS:",0,0,'L',0);
    $pdf->Cell(40,4,"$ ".number_format($exent_t['COF'], 2),0,1,'R',0);
    $pdf->Cell(41,4,"VENTAS GRAVADAS:",0,0,'L',0);
    $pdf->Cell(40,4,"$ ".number_format($total_factura-$exent_t['COF'], 2),0,1,'R',0);
    $pdf->Cell(41,4,"VENTAS NO SUJETAS:",0,0,'L',0);
    $pdf->Cell(40,4,"$ ".number_format(0, 2),0,1,'R',0);
    $pdf->Cell(41,4,"RETENCION:",0,0,'L',0);
    $pdf->Cell(40,4,"$ ".number_format($fret, 2),0,1,'R',0);
    $pdf->Cell(41,4,"TOTAL:",0,0,'L',0);
    $pdf->Cell(40,4,"$ ".number_format($total_factura-$fret, 2),0,1,'R',0);


    $pdf->Ln(5);
    $pdf->Cell(81,4,"VENTAS CON CREDITO FISCAL",0,1,'L',0);
    $pdf->Cell(41,4,"No. INICIAL:",0,0,'L',0);
    $pdf->Cell(40,4,utf8_decode(intval($credito_fiscal_min)),0,1,'R',0);
    $pdf->Cell(41,4,"No. FINAL:",0,0,'L',0);
    $pdf->Cell(40,4,utf8_decode(intval($credito_fiscal_max)),0,1,'R',0);

    $pdf->Cell(41,4,"VENTAS EXENTAS:",0,0,'L',0);
    $pdf->Cell(40,4,"$ ".number_format($exent_t['CCF'], 2),0,1,'R',0);
    $pdf->Cell(41,4,"VENTAS GRAVADAS + IVA:",0,0,'L',0);
    $pdf->Cell(40,4,"$ ".number_format($total_credito_fiscal-$exent_t['CCF'], 2),0,1,'R',0);
    $pdf->Cell(41,4,"VENTAS NO SUJETAS:",0,0,'L',0);
    $pdf->Cell(40,4,"$ ".number_format(0, 2),0,1,'R',0);
    $pdf->Cell(41,4,"RETENCION:",0,0,'L',0);
    $pdf->Cell(40,4,"$ ".number_format($cret, 2),0,1,'R',0);
    $pdf->Cell(41,4,"TOTAL:",0,0,'L',0);
    $pdf->Cell(40,4,"$ ".number_format($total_credito_fiscal-$cret, 2),0,1,'R',0);

    $pdf->Cell(41,4,"TOTAL GENERAL:","T",0,'L',0);
    $pdf->Cell(40,4,"$ ".number_format($total_general, 2),"T",1,'R',0);

    if (_num_rows($sql_fa)>0) {
      // code...
      $pdf->Ln(4);
      $pdf->Cell(81,4,"DOC. ANULADOS (FACTURA y CREDITO FISCAL):","B",1,'L',0);
      while ($row=_fetch_array($sql_fa)) {
        // code...
        $tipo = "";

        switch ($row['tipo_documento']) {
          case 'COF':
            // code...
            $tipo = 'FACTURA';
            break;
          case 'CCF':
            // code...
            $tipo = 'CREDITO FISCAL';
            break;

          default:
            // code...
            break;
        }

        $pdf->Cell(30,4,$tipo,0,0,'L',0);
        $pdf->Cell(15,4,$row['num_fact_impresa'],0,1,'L',0);

      }
    }
  }


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

$pdf->Output("reporte_z.pdf", "I");
