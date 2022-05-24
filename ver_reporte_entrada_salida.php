<?php
require('_core.php');
require('fpdf/fpdf.php');

$fecha_inicio= $_GET['fecha_inicio'];
$fecha_fin= $_GET['fecha_fin'];
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
    /*$this->Cell(260, 4, utf8_decode('NEGOCIOS LA MONTEQUEÑA SUPER TIENDA'), 0, 1, 'C');*/
    $this->Cell(260, 4, 'REPORTE DE COMPRAS Y VENTAS POR RANGO DE FECHA', 0, 1, 'C');
    $this->Cell(260, 4, 'DESDE '.$this->a." HASTA ".$this->b, 0, 1, 'C');
    $this->Cell(260, 4, 'FECHA DE IMPRESION: '.$this->c, 0, 1, 'C');
    // Salto de línea
    $this->Ln(5);
    $set_y=$this->GetY();
    $set_x=$this->GetX();
    $this->SetXY($set_x, $set_y);
    $this->AddFont('latin','','latin.php');
    $this->SetFont('latin', '', 9);
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

$fecha_impresion = date("d-m-Y")." ".hora(date("H:i:s"));
$pdf = new PDF('L', 'mm', 'letter');

$pdf->setear($fecha_ini,$fecha_fina,$fecha_impresion,0,0,0);
$pdf->SetMargins(10, 10);
$pdf->SetLeftMargin(10);
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 15);
$pdf->AliasNbPages();
$pdf->AddPage();


$total_compras_ante= "SELECT  ROUND(SUM(movimiento_producto_detalle.costo*movimiento_producto_detalle.cantidad/presentacion_producto.unidad), 2) as total_adquirido_dinero,
ROUND(SUM(cantidad), 2) as total_producto_adquirido
FROM movimiento_producto JOIN movimiento_producto_detalle ON movimiento_producto.id_movimiento=movimiento_producto_detalle.id_movimiento
JOIN presentacion_producto ON movimiento_producto_detalle.id_presentacion=presentacion_producto.id_pp
WHERE movimiento_producto_detalle.costo>0
AND movimiento_producto_detalle.cantidad>0
AND tipo='ENTRADA'
AND movimiento_producto.id_sucursal='$id_sucursal'
AND DATE( movimiento_producto.fecha )< '$fecha_inicio'
";

$exec_sql_compras_ante=_query($total_compras_ante);


$total_compras_rango= "SELECT  ROUND(SUM(movimiento_producto_detalle.costo*movimiento_producto_detalle.cantidad/presentacion_producto.unidad), 2) as total_adquirido_dinero,
ROUND(SUM(cantidad), 2) as total_producto_adquirido
FROM movimiento_producto JOIN movimiento_producto_detalle ON movimiento_producto.id_movimiento=movimiento_producto_detalle.id_movimiento
JOIN presentacion_producto ON movimiento_producto_detalle.id_presentacion=presentacion_producto.id_pp
WHERE movimiento_producto_detalle.costo>0
AND movimiento_producto_detalle.cantidad>0
AND tipo='ENTRADA'
AND movimiento_producto.id_sucursal='$id_sucursal'
AND DATE(movimiento_producto.fecha) BETWEEN '$fecha_inicio' AND '$fecha_fin'
";
$exec_sql_compras_rango=_query($total_compras_rango);

$total_ventas_ante="
SELECT ROUND(SUM(factura_detalle.subtotal), 2) as total_vendido, ROUND(SUM(cantidad), 2) as total_producto
FROM factura,factura_detalle
WHERE  factura.id_factura=factura_detalle.id_factura
AND factura_detalle.tipo_prod_serv='PRODUCTO'
AND factura.anulada=0
AND factura.finalizada=1
AND  factura.id_sucursal='$id_sucursal'
AND DATE( factura.fecha ) < '$fecha_inicio'
";
$exec_sql_ventas_ante=_query($total_ventas_ante);

$total_ventas="
SELECT ROUND(SUM(factura_detalle.subtotal), 2) as total_vendido, ROUND(SUM(cantidad), 2) as total_producto
FROM factura,factura_detalle
WHERE  factura.id_factura=factura_detalle.id_factura
AND factura_detalle.tipo_prod_serv='PRODUCTO'
AND factura.anulada=0
AND factura.finalizada=1
AND  factura.id_sucursal='$id_sucursal'
AND DATE( factura.fecha ) BETWEEN '$fecha_inicio' AND '$fecha_fin'
";
$exec_sql_ventas_rango=_query($total_ventas);

//inicia consolidado
$row_total_compras_ante=_fetch_array($exec_sql_compras_ante);
$row_total_compras_rango=_fetch_array($exec_sql_compras_rango);
$row_total_ventas_ante=_fetch_array($exec_sql_ventas_ante);
$row_total_ventas_rango=_fetch_array($exec_sql_ventas_rango);

$total_compras_dinero_ante=$row_total_compras_ante['total_adquirido_dinero'];
$total_producto_adquirido_ante=$row_total_compras_ante['total_producto_adquirido'];

$total_compras_dinero_rango=$row_total_compras_rango['total_adquirido_dinero'];
$total_producto_adquirido_rango=$row_total_compras_rango['total_producto_adquirido'];

$total_ventas_dinero_ante=$row_total_ventas_ante['total_vendido'];
$total_producto_vendido_ante=$row_total_ventas_ante['total_producto'];

$total_ventas_dinero_rango=$row_total_ventas_rango['total_vendido'];
$total_producto_vendido_rango=$row_total_ventas_rango['total_producto'];

$array_data = array(
  0 => array(strtoupper("Total existencias producto adquirido anteriormente"),42,90,"L"),
  1 => array($total_producto_adquirido_ante,150,40,"R"),
  2 => array(strtoupper("Total en dinero adquirido anteriormente"),42,90,"L"),
  3 => array($total_compras_dinero_ante,150,40,"R"),
);
$data=$pdf->array_procesor($array_data);

$array_data = array(
  0 => array(strtoupper("Total existencias producto adquirido desde:"),42,90,"L"),
  1 => array($total_producto_adquirido_rango,150,40,"R"),
  2 => array(strtoupper("Total en dinero adquirido periodo desde: "),42,90,"L"),
  3 => array($total_compras_dinero_rango,150,40,"R"),
);
$data=$pdf->array_procesor($array_data);

$array_data = array(
  0 => array(strtoupper("Total cantidad  de producto vendido desde: ".$fecha_ini." hasta ".$fecha_fina),42,90,"L"),
  1 => array($total_producto_vendido_rango,150,40,"R"),
  2 => array(strtoupper("Total en dinero producto vendido desde: ".$fecha_ini." hasta ".$fecha_fina),42,90,"L"),
  3 => array($total_ventas_dinero_rango,150,40,"R"),
);
$data=$pdf->array_procesor($array_data);



$pdf->Output("reporte_entrada_salida.pdf", "I");
