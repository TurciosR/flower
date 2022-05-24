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
$id_pedido = $_REQUEST["id_pedido"];
$sql_empresa = "SELECT * FROM sucursal WHERE id_sucursal='$id_sucursalr'";
$fini = $_REQUEST["fini"];
$ffin = $_REQUEST["ffin"];
$tipo = $_REQUEST["tipo"];
$resultado_emp=_query($sql_empresa);
$row_emp=_fetch_array($resultado_emp);
$nombre_a = utf8_decode(Mayu(utf8_decode(trim($row_emp["descripcion"]))));
$tel1 = $row_emp['telefono1'];
$n_sucursal = $row_emp['n_sucursal'];
$tel2 = $row_emp['telefono2'];
$direccion = $row_emp['direccion'];
$telefonos="TEL. ".$tel1." y ".$tel2;

    $id_sucursal = $_REQUEST["id_sucursal"];
    $logo = "img/logo_sys.png";
    $impress = "Impreso: ".date("d/m/Y");
    $titulo = "REPORTE DE PEDIDOS";
    $fech =date("d")." DE ".utf8_decode(Mayu(utf8_decode(meses(date("m")))))." DEL ".date("Y");
    $pdf->AddPage();
    $pdf->SetFont('Latin','',10);
    $pdf->Image($logo,9,4,50,18);
    //$pdf->Image($logob,160,4,50,15);
    $set_x = 0;
    $set_y = 6;

    //Encabezado General
    $pdf->SetFont('Latin','',12);
    $pdf->SetXY($set_x, $set_y);
    $pdf->Cell(220,6,$nombre_a,0,1,'C');
    $pdf->SetFont('Latin','',10);
    $pdf->SetXY($set_x, $set_y+5);
    $pdf->Cell(220,6,"SUCURSAL ".$n_sucursal.": ".$direccion,0,1,'C');
    $pdf->SetXY($set_x, $set_y+10);
    $pdf->Cell(220,6,utf8_decode($telefonos),0,1,'C');
    $pdf->SetXY($set_x, $set_y+15);
    $pdf->Cell(220,6,$titulo,0,1,'C');
    $pdf->SetXY($set_x, $set_y+25);
    $pdf->Cell(220,6,$fech,0,1,'C');
//Finaliza el encabezado
    $set_y = 45;
    $set_x = 13;
    //$pdf->SetFillColor(195, 195, 195);
    //$pdf->SetTextColor(255,255,255);
    $pdf->SetFont('Latin','',10);
    $pdf->SetXY($set_x, $set_y);
    $pdf->Cell(10,5,utf8_decode("Id"),1,1,'C',0);
    $pdf->SetXY($set_x+10, $set_y);
    $pdf->Cell(55,5,"Cliente",1,1,'L',0);
    $pdf->SetXY($set_x+65, $set_y);
    $pdf->Cell(23,5,utf8_decode("Fecha"),1,1,'C',0);
    $pdf->SetXY($set_x+88, $set_y);
    $pdf->Cell(24,5,utf8_decode("Fecha Entrega"),1,1,'L',0);
    $pdf->SetXY($set_x+112, $set_y);
    $pdf->Cell(21,5,"Lug. Entrega",1,1,'L',0);
    $pdf->SetXY($set_x+133, $set_y);
    $pdf->Cell(19,5,"Num. Doc",1,1,'C',0);
    $pdf->SetXY($set_x+152, $set_y);
    $pdf->Cell(22,5,"Estado",1,1,'C',0);
    $pdf->SetXY($set_x+174, $set_y);
    $pdf->Cell(16,5,"Total ",1,1,'C',0);
    //$pdf->SetTextColor(0,0,0);
    $set_y = 40;
    $page = 0;
    $j=0;
    $mm = 0;
    $i = 1;
    if($tipo=="todos")
    {
    $sql1 =_query("SELECT  *FROM pedido JOIN cliente ON (pedido.id_cliente=cliente.id_cliente) WHERE pedido.fecha BETWEEN '$fini' AND '$ffin' AND pedido.id_sucursal='$id_sucursalr'");
  }else if($tipo=="finalizado"){
    $sql1 =_query("SELECT  *FROM pedido JOIN cliente ON (pedido.id_cliente=cliente.id_cliente) WHERE pedido.fecha BETWEEN '$fini' AND '$ffin' AND pedido.estado='$tipo' AND pedido.id_sucursal='$id_sucursalr'");

  }else if($tipo=="pendiente"){
    $sql1 =_query("SELECT  *FROM pedido JOIN cliente ON (pedido.id_cliente=cliente.id_cliente) WHERE pedido.fecha BETWEEN '$fini' AND '$ffin' AND pedido.estado='$tipo' AND pedido.id_sucursal='$id_sucursalr'");
  }else if($tipo=="anulado"){
    $sql1 =_query("SELECT  *FROM pedido JOIN cliente ON (pedido.id_cliente=cliente.id_cliente) WHERE pedido.fecha BETWEEN '$fini' AND '$ffin' AND pedido.estado='$tipo' AND pedido.id_sucursal='$id_sucursalr'");
  }

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
                $pdf->Image($logo,9,4,50,18);
                //$pdf->Image($logo1,245,8,24.5,24.5);
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
            $set_y = 45;
            $set_x = 13;
            $id_pedido = $row["id_pedido"];
            $cliente = $row["nombre"];
            $fecha = utf8_decode(ucwords(strtolower($row["fecha"])));
            $fecha_e = $row["fecha_entrega"];
            $lugar_e = $row["lugar_entrega"];
            $numero = $row["numero"];
            $estado = $row["estado"];
            $total = $row["total"];
            $pdf->SetFont('Latin','',10);
            $pdf->SetXY($set_x, $set_y+$m);
            $pdf->Cell(10,5,$id_pedido,1,1,'L',0);
            $pdf->SetXY($set_x+10, $set_y+$m);
            $pdf->Cell(55,5,utf8_decode(ucwords(strtolower($cliente))),1,1,'L',0);
            $pdf->SetXY($set_x+65, $set_y+$m);
            $pdf->Cell(23,5,$fecha,1,1,'C',0);
            $pdf->SetXY($set_x+88, $set_y+$m);
            $pdf->Cell(24,5,utf8_decode($fecha_e),1,1,'C',0);
            $pdf->SetXY($set_x+112, $set_y+$m);
            $pdf->Cell(21,5,$lugar_e,1,1,'L',0);
            $pdf->SetXY($set_x+133, $set_y+$m);
            $pdf->Cell(19,5,$numero,1,1,'C',0);
            $pdf->SetXY($set_x+152, $set_y+$m);
            $pdf->Cell(22,5,strtolower($estado),1,1,'C',0);
            $pdf->SetXY($set_x+174, $set_y+$m);
            $pdf->Cell(16,5,"$".number_format($total,2,".",","),1,1,'C',0);
            $mm += 5;
            $m+=5;
            $i++;
            $j++;
            if($j==1)
            {
                //Fecha de impresion y numero de pagina
                $pdf->SetXY(4, 270);
                $pdf->Cell(10, 0.4,$impress, 0, 0, 'L');
                $pdf->SetXY(193, 270);
                $pdf->Cell(20, 0.4, 'Pag. '.$pdf->PageNo().' de {nb}', 0, 0, 'R');
            }
        }
    }
ob_clean();
$pdf->Output("reporte_pedido.pdf","I");
