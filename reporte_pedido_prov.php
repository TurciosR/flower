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
$id_sucursalr = $_SESSION["id_sucursal"];
$id_pedido_prov = $_REQUEST["id_pedido_prov"];
$sql_empresa = "SELECT * FROM sucursal WHERE id_sucursal='$id_sucursalr'";

$resultado_emp=_query($sql_empresa);
$row_emp=_fetch_array($resultado_emp);
$nombre_a = utf8_decode(Mayu(utf8_decode(trim($row_emp["descripcion"]))));
$tel1 = $row_emp['telefono1'];
$n_sucursal = $row_emp['n_sucursal'];
$tel2 = $row_emp['telefono2'];
$direccion = $row_emp['direccion'];
$telefonos="TEL. ".$tel1." y ".$tel2;

    $id_sucursal = $_REQUEST["id_sucursal"];
    $min = $_REQUEST["min"];
    $max = $_REQUEST["max"];
    $logo = "img/logo_sys.png";
    $impress = "Impreso: ".date("d/m/Y");
    $titulo = "REPORTE DE PEDIDO";
    $fech =date("d")." DE ".utf8_decode(Mayu(utf8_decode(meses(date("m")))))." DEL ".date("Y");
    $pdf->AddPage();
    $pdf->SetFont('Latin','',10);
    //$pdf->Image($logo,9,4,50,18);
    ////$pdf->Image($logob,160,4,50,15);
    $set_x = 0;
    $set_y = 6;

    //Encabezado General
    $pdf->SetFont('Latin','',12);
    $pdf->SetXY($set_x, $set_y);
    $pdf->Cell(220,6,$nombre_a,0,1,'C');
    $pdf->SetFont('Latin','',10);
    $pdf->SetXY($set_x+40, $set_y+5);
    $pdf->MultiCell(140,6,"SUCURSAL ".$n_sucursal.": ".$direccion,0,"C",0);
    $pdf->SetXY($set_x, $set_y+15);
    $pdf->Cell(220,6,utf8_decode($telefonos),0,1,'C');
    $pdf->SetXY($set_x, $set_y+20);
    $pdf->Cell(220,6,$titulo,0,1,'C');
  //Finaliza el encabezado
//Comienza los datos general del pedido_prov
$total_p=_fetch_array(_query("SELECT proveedor.nombre, pedido_prov.fecha, pedido_prov.fecha_entrega,pedido_prov.numero, pedido_prov.total
  FROM pedido_prov, proveedor
  WHERE pedido_prov.id_proveedor=proveedor.id_proveedor AND pedido_prov.id_pedido_prov='$id_pedido_prov' AND pedido_prov.id_sucursal='$id_sucursalr'
  "));
  $total=$total_p['total'];
  $proveedor=$total_p['nombre'];
  $fecha=$total_p['fecha'];
  $fecha_e=$total_p['fecha_entrega'];
  $lugar=$total_p['lugar_entrega'];
  $numero_p=$total_p['numero'];
  $set_y = 23;
  $set_x = 10;
  $pdf->SetXY($set_x, $set_y+15);
  $pdf->Cell(50,5,utf8_decode("PEDIDO: ").$numero_p."",0,1,'L',0);
  $pdf->SetFont('Latin','',10);
  $pdf->SetXY($set_x, $set_y+20);
  $pdf->Cell(10,5,'Proveedor:',0,1,'L',0);
  $pdf->SetXY($set_x+26, $set_y+20);
  $pdf->Cell(35,5,utf8_decode($proveedor."."),0,1,'C',0);
  $pdf->SetXY($set_x, $set_y+25);
  $pdf->Cell(10,5,utf8_decode('Fecha Creación:'),0,1,'L',0);
  $pdf->SetXY($set_x+26, $set_y+25);
  $pdf->Cell(20,5,utf8_decode($fecha."."),0,1,'C',0);
  $pdf->SetXY($set_x, $set_y+30);
  $pdf->Cell(10,5,utf8_decode('Fecha Pedido:'),0,1,'L',0);
  $pdf->SetXY($set_x+26, $set_y+30);
  $pdf->Cell(20,5,utf8_decode($fecha_e."."),0,1,'C',0);
  $pdf->SetXY($set_x, $set_y+35);

    $set_y = 59;
    $set_x = 10;
    //$pdf->SetFillColor(195, 195, 195);
    //$pdf->SetTextColor(255,255,255);
    $pdf->SetFont('Latin','',10);
    $pdf->SetXY($set_x, $set_y);
    $pdf->Cell(10,5,utf8_decode("Id"),1,1,'C',0);
    $pdf->SetXY($set_x+10, $set_y);
    $pdf->Cell(75,5,"Producto",1,1,'L',0);
    $pdf->SetXY($set_x+85, $set_y);
    $pdf->Cell(25,5,utf8_decode("Presentación"),1,1,'C',0);
    $pdf->SetXY($set_x+110, $set_y);
    $pdf->Cell(25,5,utf8_decode("Descripción"),1,1,'C',0);
    $pdf->SetXY($set_x+135, $set_y);
    $pdf->Cell(22,5,"Precio",1,1,'C',0);
    $pdf->SetXY($set_x+157, $set_y);
    $pdf->Cell(22,5,"Cantidad",1,1,'C',0);
    $pdf->SetXY($set_x+179, $set_y);
    $pdf->Cell(22,5,"Subt.",1,1,'C',0);
    //$pdf->SetTextColor(0,0,0);
    $set_y = 40;
    $page = 0;
    $j=0;
    $mm = 0;
    $i = 1;
    $sql1 =_query("SELECT producto.id_producto, producto.descripcion AS producto, presentacion.nombre,presentacion_producto.id_presentacion ,presentacion_producto.descripcion, presentacion_producto.unidad ,pedido_prov_detalle.id_pedido_detalle,pedido_prov_detalle.precio_venta, pedido_prov_detalle.cantidad, pedido_prov_detalle.cantidad_enviar ,pedido_prov_detalle.subtotal, stock.stock
      FROM pedido_prov_detalle
      JOIN producto ON (pedido_prov_detalle.id_producto=producto.id_producto)
      JOIN presentacion_producto ON (pedido_prov_detalle.id_presentacion=presentacion_producto.id_presentacion)
      JOIN presentacion ON (presentacion_producto.presentacion=presentacion.id_presentacion)
      JOIN stock ON (pedido_prov_detalle.id_producto=stock.id_producto)
      WHERE pedido_prov_detalle.id_pedido='$id_pedido_prov'");
    if(_num_rows($sql1)>0)
    {   $m=5;
      $cantP=0;
      $total=0;
        while($row = _fetch_array($sql1))
        {
            if($page==0)
                $salto = 45;
            else
                $salto = 46;
            if($j==$salto)
            {
                $page++;
                $pdf->AddPage();
                $pdf->SetFont('Latin','',10);
                //$pdf->Image($logo,9,4,50,18);
                ////$pdf->Image($logo1,245,8,24.5,24.5);
                $set_x = 0;
                $set_y = 6;
                $mm=5;
                //Encabezado General
                $pdf->SetFont('Latin','',12);
                $pdf->SetXY($set_x, $set_y);
                $pdf->Cell(220,6,$nombre_a,0,1,'C');
                $pdf->SetFont('Latin','',10);
                $pdf->SetXY($set_x, $set_y+5);
                $pdf->Cell(220,6,$telefonos,0,1,'C');
                $pdf->SetXY($set_x, $set_y+10);
                $pdf->Cell(220,6,utf8_decode($titulo),0,1,'C');
                $pdf->SetXY($set_x, $set_y+15);
                $pdf->Cell(220,6,$direccion,0,1,'C');
                $pdf->SetXY($set_x, $set_y+20);
                $pdf->Cell(220,6,$fech,0,1,'C');
                $set_x = 5;
                $set_y = 35;
                $j=0;
                $pdf->SetFont('Latin','',8);
            }
            $set_y = 59;
            $set_x = 10;
            $id_producto = $row["id_producto"];
            $producto = utf8_decode($row["producto"]);
            $presentacion = utf8_decode(ucwords(strtolower($row["nombre"])));
            $descripcion = $row["descripcion"];
            $precio = $row["precio_venta"];
            $cantidad = $row["cantidad"];
            $cantidad_e = $row["cantidad_enviar"];
            $subtotal = $row["subtotal"];
            $pdf->SetFont('Latin','',10);
            $pdf->SetXY($set_x, $set_y+$m);
            $pdf->Cell(10,5,$i,1,1,'C',0);
            $pdf->SetXY($set_x+10, $set_y+$m);
            $pdf->Cell(75,5,substr(utf8_decode(Mayu($producto)),0,32),1,1,'L',0);
            $pdf->SetXY($set_x+85, $set_y+$m);
            $pdf->Cell(25,5,substr(utf8_decode(Mayu($presentacion)),0,10),1,1,'L',0);
            $pdf->SetXY($set_x+110, $set_y+$m);
            $pdf->Cell(25,5,substr(utf8_decode(Mayu($descripcion)),0,10),1,1,'L',0);
            $pdf->SetXY($set_x+135, $set_y+$m);
            $pdf->Cell(22,5,"$".number_format($precio,2,".",","),1,1,'R',0);
            $pdf->SetXY($set_x+157, $set_y+$m);
            $pdf->Cell(22,5,number_format($cantidad,2,".",","),1,1,'R',0);
            $pdf->SetXY($set_x+179, $set_y+$m);
            $pdf->Cell(22,5,"$".number_format($subtotal,2,".",","),1,1,'R',0);
            $mm += 5;
            $m+=5;
            $i++;
            $j++;
            $cantP+=$cantidad;
            $total+=$subtotal;
            if($j==1)
            {
                //Fecha de impresion y numero de pagina
                $pdf->SetXY(4, 270);
                $pdf->Cell(10, 0.4,$impress, 0, 0, 'L');
                $pdf->SetXY(193, 270);
                $pdf->Cell(20, 0.4, 'Pag. '.$pdf->PageNo().' de {nb}', 0, 0, 'R');
            }
        }
        $pdf->SetFont('Latin','',10);
        $pdf->SetXY($set_x, $set_y+$m);
        $pdf->Cell(157,5,"Total",1,1,'C',0);
        $pdf->SetXY($set_x+157, $set_y+$m);
        $pdf->Cell(22,5,number_format($cantP,2,".",","),1,1,'R',0);
        $pdf->SetXY($set_x+179, $set_y+$m);
        $pdf->Cell(22,5,"$".number_format($total,2,".",","),1,1,'R',0);
    }
ob_clean();
$pdf->Output("reporte_pedido_prov.pdf","I");
