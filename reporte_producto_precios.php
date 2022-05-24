<?php
require('fpdf/fpdf.php');
require '_conexion.php';

class PDF extends FPDF
{
  public function Header()
  {
    //Logo
    //$this->Image('logo_pb.png',10,8,33);
    //Arial bold 15
    $this->SetFont('Arial', 'B', 10);

    $this->Cell(100, 5, 'PRODUCTO '.$this->a, "B", 0, 'L');
    $this->Cell(20, 5, 'UNIDADES', "B", 0, 'L');
    $vals = 80;
    $dis = $vals/$this->b;
    for ($i=0; $i < $this->b; $i++) {
      // code...
      $this->Cell($dis, 5, "Precio".($i+1), "B", 0, 'C');
    }
    $this->Ln(5);
  }

  public function Footer()
  {
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial', 'I', 8);
    $this->Cell(0, 10, 'Pag. '.$this->PageNo().'/{nb}', 0, 0, 'C');
  }

  public function array_procesor($array)
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
      if (strlen($nombr) > $longitud) {
        $i=0;
        $nom = divtextlin($nombr, $longitud);
        foreach ($nom as $nnon) {
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
      } else {
        // code...
        $array_a_retornar[$ygg]['valor'][]=$nombr;
        $array_a_retornar[$ygg]['size'][]=$size;
        $array_a_retornar[$ygg]["aling"][]=$aling;
        $ygg++;
      }
    }

    $ygg=0;
    foreach ($array_a_retornar as $keys) {
      for ($i=count($keys["valor"]); $i <$maxlines ; $i++) {
        // code...
        $array_a_retornar[$ygg]["valor"][]="";
        $array_a_retornar[$ygg]["size"][]=$array_a_retornar[$ygg]["size"][0];
        $array_a_retornar[$ygg]["aling"][]=$array_a_retornar[$ygg]["aling"][0];
      }
      $ygg++;
    }
    return $array_a_retornar;
  }
  public function setear($a,$b,$c,$d,$e,$f)
  {
    # code...
    if ($a==1) {
      // code...
      $this->a="EXENTO";
    }
    else {
      // code...
      $this->a="GRAVADO";
    }

    $this->b=$b;
    $this->c=$c;
    $this->d=$d;
    $this->e=$e;
    $this->f=$f;
  }
}

$pdf=new PDF();

$precios = 1;

if (isset($_REQUEST['precios'])) {
  if ($_REQUEST['precios']!="") {
    // code...
    $precios=$_REQUEST['precios'];
  }
}

if (isset($_REQUEST['exento'])) {
  $tipo = $_REQUEST['exento'];
  $pdf->setear($tipo,$precios,0,0,0,0);
  $pdf->AliasNbPages();
  $pdf->SetLeftMargin(5);
  $pdf->SetTopMargin(10);
  $pdf->SetAutoPageBreak(true, 15);
  $pdf->AddPage();
  $pdf->SetFont('Times', '', 10);



  $producto = _query("SELECT producto.descripcion, producto.id_producto FROM producto WHERE producto.exento=$tipo");

  while ($rp = _fetch_array($producto)) {
    // code...

    $pr = _query("SELECT presentacion_producto.*,presentacion.nombre as ps FROM presentacion_producto join presentacion on presentacion.id_presentacion=presentacion_producto.id_presentacion WHERE id_producto = $rp[id_producto] AND presentacion_producto.unidad=1");

    while ($row = _fetch_array($pr)) {
      // code...

      switch ($precios) {
        case '1':
        $array_data = array(
          0 => array($rp['descripcion'],49,100,"L"),
          1 => array($row['unidad'],28,20,"C"),
          2 => array("".number_format($row['precio'], 2),150,80,"C"),
        );
          break;
        case '2':
        $array_data = array(
          0 => array($rp['descripcion'],49,100,"L"),
          1 => array($row['unidad'],28,20,"C"),
          2 => array("".number_format($row['precio'], 2),150,40,"C"),
          3 => array("".number_format($row['precio1'], 2),150,40,"C"),
        );
          break;
        case '3':
        $array_data = array(
          0 => array($rp['descripcion'],49,100,"L"),
          1 => array($row['unidad'],28,20,"C"),
          2 => array("".number_format($row['precio'], 2),150,(80/3),"C"),
          3 => array("".number_format($row['precio1'], 2),150,(80/3),"C"),
          4 => array("".number_format($row['precio2'], 2),150,(80/3),"C"),
        );
          break;
        case '4':
        $array_data = array(
          0 => array($rp['descripcion'],49,100,"L"),
          1 => array($row['unidad'],28,20,"C"),
          2 => array("".number_format($row['precio'], 2),150,20,"C"),
          3 => array("".number_format($row['precio1'], 2),150,20,"C"),
          4 => array("".number_format($row['precio2'], 2),150,20,"C"),
          5 => array("".number_format($row['precio3'], 2),150,20,"C"),
        );
          break;
        default:
          // code...
          break;
      }

      $data=$pdf->array_procesor($array_data);
      $total_lineas=count($data[0]["valor"]);
      $total_columnas=count($data);

      for ($i=0; $i < $total_lineas; $i++) {
        // code...
        for ($j=0; $j < $total_columnas; $j++) {
          // code...
          $salto=0;
          $abajo=0;
          if ($j==$total_columnas-1) {
            // code...
            $salto=1;
          }
          if ($i==$total_lineas-1) {
            // code...
            $abajo="B";
          }
          $pdf->Cell($data[$j]["size"][$i], 5, utf8_decode($data[$j]["valor"][$i]), $abajo, $salto, $data[$j]["aling"][$i]);
        }
      }

    }

  }
}
else {
  $pdf->AddPage();
}
ob_clean();
$pdf->Output("reporte_productos.pdf", "I");
