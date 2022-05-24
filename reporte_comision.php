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

    $sql_empresa1 = "SELECT * FROM configuracion WHERE id_configuracion='1'";
    $resultado_emp1=_query($sql_empresa1);
    $row_emp1=_fetch_array($resultado_emp1);
    $nombre_e = utf8_decode(Mayu(utf8_decode(trim($row_emp1["nombre_empresa"]))));
    $direccion_e = utf8_decode(Mayu(utf8_decode(trim($row_emp1["direccion_empresa"]))));
    $dara = $direccion;

    $mes = $_REQUEST["mes"];
    $anio = $_REQUEST["anio"];
    $id_cliente = $_REQUEST["id_cliente"];
    //$logo = "img/logoopenpyme.jpg";
    $impress = "Impreso: ".date("d/m/Y");
    //$title = "CALZADO MAYORGA";
    $titulo = "REPORTE DE COMISIONES PENDIENTES DE COBRO";
    $sql="SELECT cliente.id_cliente, cliente.nombre, producto.mes_venta, producto.anio_venta  FROM producto JOIN cliente ON producto.id_cliente=cliente.id_cliente
    WHERE producto.vendido=1 AND producto.cobrado=0 AND producto.mes_venta='$mes' AND producto.anio_venta='$anio'";
    $and = "";
    if($id_cliente != "GENERAL")
    {
    	$and .= " AND producto.id_cliente='$id_cliente' ";
    }
    $sql.=$and." GROUP BY producto.id_cliente ORDER BY cliente.nombre ASC, producto.anio_venta DESC, producto.mes_venta DESC";
    $pdf->AddPage();
    $pdf->SetFont('Latin','',10);
    //$pdf->Image($logo,9,4,50,18);
    //$pdf->Image($logob,160,4,50,15);
    $set_x = 0;
    $set_y = 6;

    //Encabezado General
    $pdf->SetFont('Latin','',12);
    $pdf->SetXY($set_x, $set_y);
    $pdf->MultiCell(220,6,$title,0,'C',0);
    $pdf->SetFont('Latin','',10);
    $pdf->SetXY($set_x, $set_y+5);
    $pdf->Cell(220,6,$nombre_e,0,1,'C');
    $pdf->SetXY($set_x, $set_y+10);
    $pdf->Cell(220,6,$direccion_e,0,1,'C');
    $pdf->SetXY($set_x, $set_y+15);
    $pdf->Cell(220,6,utf8_decode($titulo),0,1,'C');
    $pdf->SetXY($set_x, $set_y+20);
    $pdf->Cell(220,6,meses($mes)." ".$anio,0,1,'C');

    $set_y = 35;
    $set_x = 7.5;
    //$pdf->SetFillColor(195, 195, 195);
    //$pdf->SetTextColor(255,255,255);
    $pdf->SetFont('Latin','',8);
    $pdf->SetXY($set_x, $set_y);
    $pdf->Cell(10,5,utf8_decode("N°"),1,1,'C',0);
    $pdf->SetXY($set_x+10, $set_y);
    $pdf->Cell(110,5,"CLIENTE",1,1,'C',0);
    $pdf->SetXY($set_x+120, $set_y);
    $pdf->Cell(30,5,utf8_decode("COMISIÓN"),1,1,'C',0);
    $pdf->SetXY($set_x+150, $set_y);
    $pdf->Cell(30,5,"DESCUENTO",1,1,'C',0);
    $pdf->SetXY($set_x+180, $set_y);
    $pdf->Cell(20,5,"A PAGAR",1,1,'C',0);
    //$pdf->SetTextColor(0,0,0);
    $set_y = 40;
    $page = 0;
    $j=0;
    $mm = 0;
    $i = 1;
    $result = _query($sql);
    if(_num_rows($result)>0)
    {
        while($row = _fetch_array($result))
        {
            if($page==0)
                $salto = 44;
            else
                $salto = 45;
            if($j==$salto)
            {
                $page++;
                //Encabezado General
                $pdf->SetFont('Latin','',12);
                $pdf->SetXY($set_x, $set_y);
                $pdf->MultiCell(220,6,$title,0,'C',0);
                $pdf->SetFont('Latin','',10);
                $pdf->SetXY($set_x, $set_y+5);
                $pdf->Cell(220,6,$nombre_e,0,1,'C');
                $pdf->SetXY($set_x, $set_y+10);
                $pdf->Cell(220,6,$direccion_e,0,1,'C');
                $pdf->SetXY($set_x, $set_y+15);
                $pdf->Cell(220,6,utf8_decode($titulo),0,1,'C');
                $pdf->SetXY($set_x, $set_y+20);
                $pdf->Cell(220,6,meses($mes)." ".$anio,0,1,'C');

                $set_y = 35;
                $set_x = 5;
            }
            $id_client = $row["id_cliente"];

            $sql_clip = _query("SELECT sum(comision) as comision FROM producto JOIN cliente ON producto.id_cliente=cliente.id_cliente WHERE producto.id_cliente='$id_client' AND producto.vendido=1 AND producto.cobrado=0 AND producto.mes_venta='$mes' AND producto.anio_venta='$anio' GROUP BY producto.id_cliente");
        		$sql_clig = _query("SELECT sum(comision) as comision FROM producto JOIN cliente ON producto.id_cliente=cliente.id_cliente WHERE producto.id_cliente='$id_client' AND producto.garantia=1 AND producto.descuento=0 GROUP BY producto.id_cliente");
        		$datos_clip = _fetch_array($sql_clip);
        		$datos_clig = _fetch_array($sql_clig);
        		$pagar = $datos_clip["comision"];
        		$descuento = $datos_clig["comision"];
            $nombre = utf8_decode($row["nombre"]);
            $pdf->SetXY($set_x, $set_y+$mm);
            $pdf->Cell(10,5,$i,1,1,'C',0);
            $pdf->SetXY($set_x+10, $set_y+$mm);
            $pdf->Cell(110,5,$nombre,1,1,'L',0);
            $pdf->SetXY($set_x+120, $set_y+$mm);
            $pdf->Cell(30,5,"$".number_format($pagar,2,".",","),1,1,'R',0);
            $pdf->SetXY($set_x+150, $set_y+$mm);
            $pdf->Cell(30,5,"$".number_format($descuento,2,".",","),1,1,'R',0);
            $pdf->SetXY($set_x+180, $set_y+$mm);
            $pdf->Cell(20,5,"$".number_format(($pagar-$descuento),2,".",","),1,1,'R',0);
            $mm += 5;
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
$pdf->Output("reporte_stock.pdf","I");
