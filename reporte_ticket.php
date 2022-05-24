<?php
error_reporting(E_ERROR | E_PARSE);
require("_conexion.php");
require("num2letras.php");
require('fpdf/fpdf.php');

$fecha = ($_REQUEST["fecha"]);
$id_sucursal = $_REQUEST["id_sucursal"];
$exento = $_REQUEST['tipo'];
$n = 1;
$sql_cabezera = _query("SELECT * FROM sucursal WHERE id_sucursal = '$id_sucursal'");
$cue = _num_rows($sql_cabezera);
$row_cabe = _fetch_array($sql_cabezera);

  $nite=$row_cabe['nit'];
  $nrce=$row_cabe['nrc'];
  $empresa1=$row_cabe['descripcion'];
  $razonsocial1=$row_cabe['razonsocial'];
  $giro1=$row_cabe['giro'];
  $direccion = $row_cabe['direccion'];



$condicion="";
$condicion2="";


$sql_lista = _query("SELECT * FROM factura WHERE fecha = '$fecha' $condicion AND id_sucursal = '$id_sucursal'  AND tipo_documento = 'TIK'  and finalizada=1 ORDER BY CAST(num_fact_impresa as UNSIGNED) ASC");
$cuenta = _num_rows($sql_lista);

if($cuenta > 0)
{
  $pdf=new fPDF('P','mm');
  $pdf->SetMargins(10,5);
  $pdf->SetTopMargin(2);
  $pdf->SetLeftMargin(2);
  $pdf->AliasNbPages();
  $pdf->SetAutoPageBreak(true,1);
  $pdf->AddFont("courier new","","courier.php");

  while ($row = _fetch_array($sql_lista))
  {
    //$numero_docx = $rrr["numero_doc"];
    $id_factura = $row["id_factura"];
    $caja = $row["caja"];
    $descuento = $row["descuento"];
    $porcentaje = $row["porcentaje"];
    $turno = $row["turno"];
    $nulo = $row["anulada"];

    $direccio=divtextlin($direccion,35);
    $empress= divtextlin($empresa1, 35);
    $giros = divtextlin($giro1, 35);

    $sql_caja = _query("SELECT * FROM caja WHERE id_caja='$caja'");
    $dats_caja = _fetch_array($sql_caja);

      $fehca = ED($dats_caja["fecha"]);
      $resolucion = $dats_caja["resolucion"];
      $serie = $dats_caja["serie"];
      $desde = $dats_caja["desde"];
      $hasta = $dats_caja["hasta"];
      $nombre_c = $dats_caja["nombre"];


    $sql_detalles = _query("SELECT * FROM factura_detalle WHERE id_factura = '$id_factura' ");
    $cuen_ss = _num_rows($sql_detalles);
    $ff = 8 * $cuen_ss;
    $nn = $ff+120+count($direccion)*5+count($empress)*5+count($giros)*5;

    //$id_sucursal = $_SESSION["id_sucursal"];
    $pdf->AddPage('P', array(85, $nn));

    //$pdf->Image($logob,160,4,50,15);
    $set_x = 0;
    $set_y = 0;

    //Encabezado General
    $pdf->SetFont('courier new','',9.5);
    $pdf->SetXY($set_x, $set_y);
    //$pdf->Cell(80,5,utf8_decode($empresa1),0,1,'C');
    //$pdf->SetXY($set_x, $set_y+5);


    $g = 0;

    foreach ($empress as $nnona)
    {
      $pdf->SetXY($set_x, $set_y+10+$g);
      $pdf->Cell(85,5,($nnona),0,1,'C');
      $g+=5;
    }
    foreach ($direccio as $nnona)
    {
      $pdf->SetXY($set_x, $set_y+10+$g);
      $pdf->Cell(85,5,($nnona),0,1,'C');
      $g+=5;
    }

    foreach ($giros as $nnon)
    {
      $pdf->SetXY($set_x, $set_y+10+$g);
      $pdf->Cell(85,5,utf8_decode($nnon),0,1,'C');
      $g+=5;
    }

    $pdf->SetXY($set_x, $set_y+10+$g);
    $pdf->Cell(85,5,utf8_decode("NIT: ".$nite."  NRC: ".$nrce),0,1,'C');
    $pdf->SetXY($set_x, $set_y+15+$g);
    $pdf->Cell(85,5,utf8_decode("RESOLUCIÓN: ".$resolucion),0,1,'C');
    $pdf->SetXY($set_x, $set_y+20+$g);
    $pdf->Cell(85,5,utf8_decode("DEL: ".$desde." AL: ".$hasta),0,1,'C');
    $pdf->SetXY($set_x, $set_y+25+$g);
    $pdf->Cell(85,5,utf8_decode("SERIE: ".$serie),0,1,'C');
    $pdf->SetXY($set_x, $set_y+30+$g);
    $pdf->Cell(85,5,utf8_decode("FECHA RESOLUCIÓN: ".$fehca),0,1,'C');

    $set_y = 35+$g;
    $set_x = 2;
    if ($exento==0) {
      // code...
      $numero_doc = $row["numero_doc"];
    }
    else {
      // code...
      $numero_doc = $row["numero_doc_e"];
    }
    $numero_doc = str_pad($row["num_fact_impresa"],8,"0",STR_PAD_LEFT)."_TIK";

    list($numm,$ads) = explode("_", $numero_doc);
    $hora = $row["hora"];
    $id_cliente = $row["id_cliente"];
    $id_empleado = $row["id_empleado"];
    $total_exento = $row["venta_exenta"];
    $total_gravado = $row["suma_gravado"];
    $total = $row["total"];
    $descuento = $row["descuento"];
    $total_pago = $total;
    $id_vendedor = $row["id_empleado"];
    $sql_vendedor = _query("SELECT * FROM empleado  LEFT JOIN usuario on usuario.id_empleado=empleado.id_empleado where id_usuario = '$id_vendedor'");
    $row_ven = _fetch_array($sql_vendedor);
    $nombre_ven = $row_ven["nombre"];
    $nv = explode(" ", $nombre_ven);
    $codv = count($nv);
    if($codv > 2)
    {
      $nv1 = $nv[0]." ".$nv[2];
    }
    else
    {
      $nv1 = $nv[0]." ".$nv[1];
    }
    $efectivo = $row["efectivo"];
    $cambio = $row["cambio"];

    $sql_cliente = _query("SELECT * FROM cliente WHERE id_cliente = '$id_cliente'");
    $row_cliente = _fetch_array($sql_cliente);
    $nombre_cli = $row_cliente["nombre"];

    $sql_empleado = _query("SELECT empleado.* FROM empleado  LEFT JOIN usuario on usuario.id_empleado=empleado.id_empleado where id_usuario = '$id_vendedor'");

    $row_empleado = _fetch_array($sql_empleado);
    $nombre_em = $row_empleado["nombre"];
    $ne = explode(" ", $nombre_em);
    $code = count($ne);
    if ($code > 2)
    {
      $ne1 = $ne[0]." ".$ne[2];
    }
    else
    {
      $ne1 = $ne[0]." ".$ne[1];
    }

    $pdf->SetXY($set_x, $set_y);
    if($nulo)
    {
      $pdf->Cell(81,5,utf8_decode("TIQUETE # ".$numm ."(ANULADO)"),0,1,'C');
    }
    else {
      $pdf->Cell(81,5,utf8_decode("TIQUETE # ".$numm),0,1,'C');
    }

    $pdf->Line(2,$pdf->GetY(),82,$pdf->GetY());
    $pdf->SetFont('courier new','',8.5);
    $pdf->SetXY($set_x, $set_y+5);
    $pdf->Cell(70,5,utf8_decode("FECHA: ".ED($fecha)."  ".hora($hora)),0,1,'L');
    $pdf->SetXY($set_x, $set_y+9);
    $pdf->Cell(70,5,utf8_decode("VENDEDOR: ".$nombre_em),0,1,'L');
    $pdf->SetXY($set_x, $set_y+13);
    $pdf->Cell(70,5,utf8_decode("CAJA: ".$nombre_c." TURNO: ".$turno),0,1,'L');
    $pdf->SetXY($set_x, $set_y+17);
    $pdf->Cell(70,5,utf8_decode("CLIENTE: ".$nombre_cli),0,1,'L');

    $set_y = 55+$g;
    $set_x = 2;
    $pdf->SetFont('courier new','',8);
    $pdf->Cell(8,5,utf8_decode("CANT"),0,0,'L');
    $pdf->Cell(46,5,utf8_decode("DESCRIPCION."),0,0,'L');
    $pdf->Cell(12,5,utf8_decode("P.V."),0,0,'R');
    $pdf->Cell(15,5,utf8_decode("SUBT."),0,1,'R');

    $set_y = 65+$g;
    $pdf->Line(2,$pdf->GetY(),82,$pdf->GetY());
    $dd = 0;
    if($cuen_ss > 0)
    {
      while ($row_detalle = _fetch_array($sql_detalles))
      {
        $id_producto = $row_detalle["id_prod_serv"];
        $cantidad = $row_detalle["cantidad"];
        $precio = $row_detalle["precio_venta"];
        $gravado = $row_detalle["subtotal"];
        $exento = $row_detalle["exento"];
        $presentacion = $row_detalle["id_presentacion"];

        if($presentacion!=-9999)
        {
          $sql_pres = _query("SELECT p.nombre, pp.descripcion,pp.unidad FROM presentacion_producto as pp , presentacion as p WHERE pp.id_pp = '$presentacion' AND pp.id_presentacion = p.id_presentacion ");
          $cue = _num_rows($sql_pres);
          $row_press = _fetch_array($sql_pres);
          $nombre_des = $row_press["nombre"];
          $descrip_des = $row_press["descripcion"];
          $des = $nombre_des."(".$descrip_des.")";
          $cantidad = $cantidad/$row_press['unidad'];
        }
        else
        {
          $nombre_des = '';
          $descrip_des = "";
          $des = '';
          $row_press['unidad'] = 1;
          $cantidad = 1;
        }




        if($exento == 0)
        {
          $lee = "G";
        }
        else
        {
          $lee = "E";
        }

        $sub = $precio * $cantidad;
        if($id_producto!=-9999)
        {
          $sql_producto = _query("SELECT * FROM producto WHERE id_producto = '$id_producto'");
          $r_p = _fetch_array($sql_producto);
          $nombre = $r_p["descripcion"];
        }
        else
        {
          $nombre = $row_detalle['description'];
        }

        $pdf->SetFont('courier new','',7);

        $pdf->Cell(8,5,utf8_decode(round($cantidad,2)),0,0,'R');
        $pdf->Cell(46,5,utf8_decode(text_espacios($nombre,33)),0,0,'L');
        $pdf->Cell(12,5,utf8_decode(number_format($precio,2)),0,0,'R');
        $pdf->Cell(15,5,utf8_decode(number_format($sub,2)).$lee,0,1,'R');
        //$pdf->Cell(46,5,utf8_decode($des.$lee),0,1,'L');

        $dd += 4;
      }
    }

    $pdf->Line(2,$pdf->GetY(),82,$pdf->GetY());
      $pdf->SetFont('courier new','',10);
      $pdf->Cell(40,5,utf8_decode("TOTAL GRAVADO"),0,0,'L');
      $pdf->Cell(15,5,utf8_decode("$    ".number_format((round($total_gravado,2)),2)),0,1,'L');
      $pdf->Cell(40,5,utf8_decode("TOTAL EXENTO"),0,0,'L');
      $pdf->Cell(15,5,utf8_decode("$    ".number_format((round($total_exento, 2)),2)),0,1,'L');
      $pdf->Cell(40,5,utf8_decode("TOTAL"),0,0,'L');
      $pdf->Cell(15,5,utf8_decode("$    ".number_format((round($total_pago,2)),2)),0,1,'L');

    $pdf->SetFont('courier new','',7.5);
    $pdf->Cell(80,5,utf8_decode("E = EXENTO G = GRAVADO"),0,1,'C');
    $pdf->Cell(80,5,utf8_decode("GRACIAS POR SU COMPRA, VUELVA PRONTO....."),0,1,'C');
    $pdf->Cell(80,5,utf8_decode("**NO SE ACEPTAN DEVOLUCIONES DESPUES DE 30 DIAS"),0,1,'C');
    $mm += 5;
  }
}
else
{
  $pdf=new fPDF('P','mm');
  $pdf->SetMargins(10,5);
  $pdf->SetTopMargin(2);
  $pdf->SetLeftMargin(10);
  $pdf->AliasNbPages();
  $pdf->SetAutoPageBreak(true,1);
  $pdf->AddFont("courier new","","courier.php");
  $pdf->AddPage('P', array(80, 80));
  $set_x = 0;
  $set_y = 12;

  //Encabezado General
  $pdf->SetFont('courier new','',9);
  $pdf->SetXY($set_x, $set_y);
  $pdf->Cell(80,5,utf8_decode("NO SE HA ENCONTRADO NINGUN TIQUETE"),0,1,'C');
}

ob_clean();
$pdf->Output(ED($fecha).".pdf","I");
