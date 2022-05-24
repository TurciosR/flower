<?php
require('_core.php');
require('fpdf/fpdf.php');


class PDF extends FPDF
{
  var $a = array();
  // Cabecera de página\
  public function Header()
  {
    //Encabezado General
    $this->SetFont('Latin','',12);
    $this->Cell(195,6,$this->a['empresa'],0,1,'C');
    $this->SetFont('Latin','',10);
    $this->Cell(195,6,$this->a['sucursal'],0,1,'C');
    $this->Cell(195,6,$this->a['telefonos'],0,1,'C');

    $logo = "img/logo_sys.jpg";
    $this->Image($logo,9,6,25,18);


    $this->Cell(220,5,$this->a['titulo'],0,1,'L');
    $this->Cell(220,5,"CLIENTE: ".utf8_decode(Mayu(utf8_decode($this->a['cliente']))),0,1,'L');
    $this->Cell(220,5,"FECHA: ".ED($this->a['fecha']),0,1,'L');

      // Logo
      $this->AddFont('latin','','latin.php');
      $this->SetFont('latin', '', 8);

      $this->SetFont('Latin','',8);
      $this->Cell(20,5,"CANTIDAD",1,0,'C',0);
      $this->Cell(70,5,"DETALLE",1,0,'C',0);
      $this->Cell(30,5,utf8_decode("PRESENTACIÓN"),1,0,'C',0);
      $this->Cell(30,5,utf8_decode("DESCRIPCIÓN"),1,0,'C',0);
      $this->Cell(20,5,"PRECIO",1,0,'C',0);
      $this->Cell(25,5,"SUBTOTAL",1,1,'C',0);

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
      $this->Cell(150, 10, utf8_decode('Página ').$this->PageNo().'/{nb}', 0, 0, 'R');
  }
  public function setear($a)
  {
    # code...
    $this->a=$a;
  }

  public function LineWrite($array)
  {
    $ygg=0;
    $maxlines=1;
    $array_a_retornar=array();
    $array_max= array();
    foreach ($array as $key => $value) {
      // /Descripcion/
      $nombr=$value[0];
      // /fpdf width/
      $size=$value[1];
      // /fpdf alignt/
      $aling=$value[2];
      $jk=0;
      $w = $size;
      $h  = 0;
      $txt=$nombr;
      $border=0;
      if(!isset($this->CurrentFont))
        $this->Error('No font has been set');
      $cw = &$this->CurrentFont['cw'];
      if($w==0)
        $w = $this->w-$this->rMargin-$this->x;
      $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
      $s = str_replace("\r",'',$txt);
      $nb = strlen($s);
      if($nb>0 && $s[$nb-1]=="\n")
        $nb--;
      $b = 1;

      $sep = -1;
      $i = 0;
      $j = 0;
      $l = 0;
      $ns = 0;
      $nl = 1;
      while($i<$nb)
      {
        // Get next character
        $c = $s[$i];
        if($c=="\n")
        {
          $array_a_retornar[$ygg]["valor"][]=substr($s,$j,$i-$j);
          $array_a_retornar[$ygg]["size"][]=$size;
          $array_a_retornar[$ygg]["aling"][]=$aling;
          $jk++;

          $i++;
          $sep = -1;
          $j = $i;
          $l = 0;
          $ns = 0;
          $nl++;
          if($border && $nl==2)
            $b = $b2;
          continue;
        }
        if($c==' ')
        {
          $sep = $i;
          $ls = $l;
          $ns++;
        }
        $l += $cw[$c];
        if($l>$wmax)
        {
          // Automatic line break
          if($sep==-1)
          {
            if($i==$j)
              $i++;
            $array_a_retornar[$ygg]["valor"][]=substr($s,$j,$i-$j);
            $array_a_retornar[$ygg]["size"][]=$size;
            $array_a_retornar[$ygg]["aling"][]=$aling;
            $jk++;
          }
          else
          {
            $array_a_retornar[$ygg]["valor"][]=substr($s,$j,$sep-$j);
            $array_a_retornar[$ygg]["size"][]=$size;
            $array_a_retornar[$ygg]["aling"][]=$aling;
            $jk++;

            $i = $sep+1;
          }
          $sep = -1;
          $j = $i;
          $l = 0;
          $ns = 0;
          $nl++;
          if($border && $nl==2)
            $b = $b2;
        }
        else
          $i++;
      }
      // Last chunk
      if($this->ws>0)
      {
        $this->ws = 0;
      }
      if($border && strpos($border,'B')!==false)
        $b .= 'B';
      $array_a_retornar[$ygg]["valor"][]=substr($s,$j,$i-$j);
      $array_a_retornar[$ygg]["size"][]=$size;
      $array_a_retornar[$ygg]["aling"][]=$aling;
      $jk++;
      $ygg++;
      if ($jk>$maxlines) {
        // code...
        $maxlines=$jk;
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
        $abajo="LR";
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
        if ($i==$total_lineas-1&&$i==0) {
          // code...
          $abajo="1";
        }

        $abajo="0";

        $str = $data[$j]["valor"][$i];
        $this->Cell($data[$j]["size"][$i],4,$str,$abajo,$salto,$data[$j]["aling"][$i]);
      }

    }
  }

  public function LineWriteB($array)
  {
    $ygg=0;
    $maxlines=1;
    $array_a_retornar=array();
    $array_max= array();
    foreach ($array as $key => $value) {
      // /Descripcion/
      $nombr=$value[0];
      // /fpdf width/
      $size=$value[1];
      // /fpdf alignt/
      $aling=$value[2];
      $jk=0;
      $w = $size;
      $h  = 0;
      $txt=$nombr;
      $border=0;
      if(!isset($this->CurrentFont))
        $this->Error('No font has been set');
      $cw = &$this->CurrentFont['cw'];
      if($w==0)
        $w = $this->w-$this->rMargin-$this->x;
      $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
      $s = str_replace("\r",'',$txt);
      $nb = strlen($s);
      if($nb>0 && $s[$nb-1]=="\n")
        $nb--;
      $b = 1;

      $sep = -1;
      $i = 0;
      $j = 0;
      $l = 0;
      $ns = 0;
      $nl = 1;
      while($i<$nb)
      {
        // Get next character
        $c = $s[$i];
        if($c=="\n")
        {
          $array_a_retornar[$ygg]["valor"][]=substr($s,$j,$i-$j);
          $array_a_retornar[$ygg]["size"][]=$size;
          $array_a_retornar[$ygg]["aling"][]=$aling;
          $jk++;

          $i++;
          $sep = -1;
          $j = $i;
          $l = 0;
          $ns = 0;
          $nl++;
          if($border && $nl==2)
            $b = $b2;
          continue;
        }
        if($c==' ')
        {
          $sep = $i;
          $ls = $l;
          $ns++;
        }
        $l += $cw[$c];
        if($l>$wmax)
        {
          // Automatic line break
          if($sep==-1)
          {
            if($i==$j)
              $i++;
            $array_a_retornar[$ygg]["valor"][]=substr($s,$j,$i-$j);
            $array_a_retornar[$ygg]["size"][]=$size;
            $array_a_retornar[$ygg]["aling"][]=$aling;
            $jk++;
          }
          else
          {
            $array_a_retornar[$ygg]["valor"][]=substr($s,$j,$sep-$j);
            $array_a_retornar[$ygg]["size"][]=$size;
            $array_a_retornar[$ygg]["aling"][]=$aling;
            $jk++;

            $i = $sep+1;
          }
          $sep = -1;
          $j = $i;
          $l = 0;
          $ns = 0;
          $nl++;
          if($border && $nl==2)
            $b = $b2;
        }
        else
          $i++;
      }
      // Last chunk
      if($this->ws>0)
      {
        $this->ws = 0;
      }
      if($border && strpos($border,'B')!==false)
        $b .= 'B';
      $array_a_retornar[$ygg]["valor"][]=substr($s,$j,$i-$j);
      $array_a_retornar[$ygg]["size"][]=$size;
      $array_a_retornar[$ygg]["aling"][]=$aling;
      $jk++;
      $ygg++;
      if ($jk>$maxlines) {
        // code...
        $maxlines=$jk;
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
        $abajo="LR";
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
        if ($i==$total_lineas-1&&$i==0) {
          // code...
          $abajo="1";
        }


        $str = $data[$j]["valor"][$i];

        $fill=0;

        if ($str=="VENCIDO")
        {
          $fill=1;
        }

        $this->Cell($data[$j]["size"][$i],4,$str,$abajo,$salto,$data[$j]["aling"][$i],$fill);
      }

    }
  }
}

$pdf=new PDF('P','mm', 'Letter');
$pdf->SetMargins(10,5);
$pdf->SetTopMargin(10);
$pdf->SetLeftMargin(10);
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,15);
$pdf->AddFont("latin","","latin.php");
$id_sucursalr = $_SESSION["id_sucursal"];
$sql_empresa = "SELECT * FROM sucursal WHERE id_sucursal='$id_sucursalr'";
$resultado_emp=_query($sql_empresa);
$row_emp=_fetch_array($resultado_emp);
$empresa = utf8_decode(Mayu(utf8_decode(trim($row_emp["descripcion"]))));
$sucursal = utf8_decode(Mayu(utf8_decode(trim($row_emp["direccion"]))));
$tel1 = $row_emp['telefono1'];
$tel2 = $row_emp['telefono2'];
if($tel1 != "")
{
  if($tel2 !="")
  {
    $telefonos="TEL. ".$tel1.", ".$tel2;
  }
  else
  {
    $telefonos="TEL. ".$tel1;
  }
}
else
{
  if($tel2 !="")
  {
    $telefonos="TEL. ".$tel2;
  }
  else
  {
    $telefonos="";
  }
}
$logo = "img/logo_sys.jpg";
$impress = date("d/m/Y");

$id_cotizacion=$_REQUEST['id_cotizacion'];
$sql="SELECT co.fecha, co.total, co.numero_doc, co.vigencia, c.nombre as cliente, u.nombre as empleado
FROM cotizacion AS co
JOIN cliente AS c ON c.id_cliente=co.id_cliente
JOIN usuario AS u ON u.id_usuario=co.id_empleado
WHERE co.id_cotizacion='$id_cotizacion'";
$up = array('impresa' => 1);
_update("cotizacion", $up, "id_cotizacion='$id_cotizacion'");
$result=_query($sql);
$row=_fetch_array($result);

$fecha=$row['fecha'];
$total=$row['total'];
$numero_doc=$row['numero_doc'];
$cliente=$row['cliente'];
$empleado=$row['empleado'];
$vigencia=$row['vigencia'];

$titulo=utf8_decode("COTIZACIÓN: ").$numero_doc;


$array_datas = array(
  'titulo' => $titulo,
  'empresa' => $empresa,
  'sucursal' => $sucursal,
  'telefonos' => $telefonos,
  'cliente' => $cliente,
  'fecha' => $fecha
);

$pdf->setear($array_datas);
$pdf->AddPage();
//$pdf->Image($logo,9,4,50,18);
$set_x = 0;
$set_y = 10;

$mm = 0;
$i = 0;
$subtt = 0;
$result1 = _query("SELECT dc.id_prod_serv, pr.descripcion, dc.cantidad, dc.precio_venta, dc.id_presentacion, dc.subtotal FROM cotizacion_detalle as dc, producto as pr WHERE pr.id_producto=dc.id_prod_serv AND dc.id_cotizacion='$id_cotizacion'");
if(_num_rows($result1)>0)
{
  while($row = _fetch_array($result1))
  {
    $id_producto = $row["id_prod_serv"];
    $cantidad_s = $row["cantidad"];
    $subt_mostrar = $row["subtotal"];
    $subtt += $subt_mostrar;
    $precio_venta = $row["precio_venta"];
    $id_presentacion = $row["id_presentacion"];
    $descripcion = utf8_decode(Mayu(utf8_decode($row["descripcion"])));

    $sql_p=_query("SELECT presentacion.nombre, presentacion_producto.descripcion,presentacion_producto.id_pp as id_presentacion,presentacion_producto.unidad,presentacion_producto.precio FROM presentacion_producto JOIN presentacion ON presentacion.id_presentacion=presentacion_producto.id_presentacion WHERE presentacion_producto.id_pp ='$id_presentacion' AND presentacion_producto.activo=1");
    $row2=_fetch_array($sql_p);
    $presentacion = utf8_decode(Mayu(utf8_decode($row2['nombre'])));
    $descripcionp = utf8_decode(Mayu(utf8_decode($row2['descripcion'])));

    $array_data = array(
        array($cantidad_s,20,"C"),
        array($descripcion,70,"L"),

        array($presentacion,30,"C"),
        array($descripcionp,30,"C"),
        array("$".number_format($precio_venta,2,".",","),20,"R"),

        array("$".number_format($subt_mostrar,2,".",","),25,"R"),
      );
    $pdf->LineWriteB($array_data);
    }

      $pdf->SetFont('Latin','',8);
      $pdf->Cell(170,5,"TOTAL",1,0,'C',0);
      $pdf->Cell(25,5,"$".number_format($subtt,2,".",","),1,1,'R',0);

      $pdf->SetFont('Latin','',10);
      $pdf->Cell(195,5,"Precios Incluyen IVA",0,1,'L',0);
      $pdf->Cell(195,5,"**** Oferta valida por ".$vigencia." dias ****",0,0,'L',0);

  }
ob_clean();
$pdf->Output($numero_doc.".pdf", "I");
