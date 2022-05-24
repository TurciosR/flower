<?php
error_reporting(E_ERROR | E_PARSE);
require("_core.php");
require("num2letras.php");
require('fpdf/fpdf.php');


$pdf=new fPDF('L', 'mm', 'Letter');
$pdf->SetMargins(10, 5);
$pdf->SetTopMargin(5);
$pdf->SetLeftMargin(5);
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 1);
$pdf->AddFont("latin", "", "latin.php");
$id_sucursal = $_SESSION["id_sucursal"];
$sql_empresa = "SELECT * FROM sucursal WHERE id_sucursal='$id_sucursal'";

$resultado_emp=_query($sql_empresa);
$row_emp=_fetch_array($resultado_emp);
$nombre_a = utf8_decode(Mayu(utf8_decode(trim($row_emp["descripcion"]))));
//$direccion = Mayu(utf8_decode($row_emp["direccion_empresa"]));
$direccion = utf8_decode(Mayu(utf8_decode(trim($row_emp["direccion"]))));


    $fini = date("Y-m-d");
    $fin = $_REQUEST["ffin"];
    $fini1 = ($_REQUEST["fini"]);
    $fin1 = ($_REQUEST["ffin"]);


    $title = $nombre_a;
    $titulo = "LIBRO DE VENTAS A CONTRIBUYENTES";
    if ($fini!="") {
        list($a, $m, $d) = explode("-", ($_REQUEST["fini"]));
        list($a1, $m1, $d1) = explode("-", ($_REQUEST["ffin"]));

        if ($a ==$a1) {
            if ($m==$m1) {
                if ($d == $d1) {
                    $fech="AL $d1 DE ".meses($m)." DE $a";
                } else {
                    $fech="DEL $d AL $d1 DE ".meses($m)." DE $a";
                }
            } else {
                $fech="DEL $d DE ".meses($m)." AL $d1 DE ".meses($m1)." DE $a";
            }
        } else {
            $fech="DEL $d DE ".meses($m)." DEL $a AL $d1 DE ".meses($m1)." DE $a1";
        }
    }
    $impress = "LIBRO DE VENTAS A CONTRIBUYENTES".$fech;


    $existenas = "";
    if ($min>0) {
        $existenas = "CANTIDAD: $min";
    }
    $logo = "img/logo_sys.png";
    $pdf->AddPage();
    //$pdf->Image($logo,8,4,30,25);
    $pdf->SetFont('Arial', '', 10);


    //Encabezado General
    //Encabezado General
    $set_x=0;
    $set_y=10;
    $pdf->SetFont('Arial', '', 14);
    $pdf->SetXY($set_x, $set_y);
    $pdf->MultiCell(280, 6, $title, 0, 'C', 0);
    $pdf->SetXY($set_x, $set_y+5);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(280, 6, utf8_decode($direccion), 0, 1, 'C');
    $pdf->SetXY($set_x, $set_y+10);
    $pdf->Cell(280, 6, utf8_decode($titulo), 0, 1, 'C');
    $pdf->SetXY($set_x, $set_y+15);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(280, 6, $fech, 0, 1, 'C');

    ///////////////////////////////////////////////////////////////////////

    $total_internas_gravadas=0;
    $total_debito_fiscal=0;
    $total_retencion=0;
    $total_ventas=0;

    $set_x = 5;
    $set_y = 35;

    $pdf->SetFont('Latin', '', 6);
    $pdf->SetXY($set_x, $set_y);

    $pdf->Cell(6, 15, utf8_decode("Nº"), 1, 0, 'C');

    $set_x = $pdf-> GetX();
    $pdf->Cell(15, 7, utf8_decode("FECHA"), "TLR", 1, 'C');
    $pdf->SetX($set_x);
    $pdf->Cell(15, 8, utf8_decode("DE EMISION"), "BLR", 0, 'C');

    $set_x = $pdf-> GetX();
    $pdf->SetXY($set_x, $set_y);
    $set_x = $pdf-> GetX();
    $pdf->Cell(18, 5, utf8_decode("NUMERO DE"), "TLR", 1, 'C');
    $pdf->SetX($set_x);
    $pdf->Cell(18, 5, utf8_decode("CORRELATIVO"), "LR", 1, 'C');
    $pdf->SetX($set_x);
    $pdf->Cell(18, 5, utf8_decode("IMPRESO"), "BLR", 0, 'C');


    $set_x = $pdf-> GetX();
    $pdf->SetXY($set_x, $set_y);
    $pdf->Cell(14, 5, utf8_decode("PREFIJO"), "TLR", 1, 'C');
    $pdf->SetX($set_x);
    $pdf->Cell(14, 5, utf8_decode("O"), "LR", 1, 'C');
    $pdf->SetX($set_x);
    $pdf->Cell(14, 5, utf8_decode("SERIE"), "BLR", 0, 'C');

    $set_x = $pdf-> GetX();
    $pdf->SetXY($set_x, $set_y);
    $pdf->Cell(16, 5, utf8_decode("NUMERO"), "TLR", 1, 'C');
    $pdf->SetX($set_x);
    $pdf->Cell(16, 5, utf8_decode("DE CONTROL"), "LR", 1, 'C');
    $pdf->SetX($set_x);
    $pdf->Cell(16, 5, utf8_decode("INTERNO"), "BLR", 0, 'C');

    $set_x = $pdf-> GetX();
    $pdf->SetXY($set_x, $set_y);
    $pdf->Cell(67, 15, utf8_decode("NOMBRE DEL CLIENTE"), 1, 0, 'C');

    $set_x = $pdf-> GetX();
    $pdf->SetXY($set_x, $set_y);
    $pdf->Cell(10, 15, utf8_decode("NRC"), 1, 0, 'C');

    $set_x = $pdf-> GetX();
    $pdf->SetXY($set_x, $set_y);
    $pdf->Cell(99, 5, utf8_decode("OPERACIONES DE VENTAS PROPIAS Y A CUENTA DE TERCEROS"), 1, 1, 'C');
    $set_y=$set_y+5;

    $pdf->SetXY($set_x, $set_y);
    $pdf->Cell(60, 3, utf8_decode("PROPIAS"), 1, 1, 'C');
    $pdf->SetX($set_x);
    $pdf->Cell(15, 3, utf8_decode("NO"), "LR", 1, 'C');
    $pdf->SetX($set_x);
    $pdf->Cell(15, 4, utf8_decode("SUJETAS"), "BLR", 0, 'C');
    $set_x = $pdf-> GetX();
    $pdf->SetXY($set_x, $pdf->GetY()-3);
    $pdf->Cell(15, 7, utf8_decode("EXENTAS"), 1, 0, 'C');
    $set_x = $pdf-> GetX();
    $pdf->SetX($set_x);
    $pdf->Cell(15, 3, utf8_decode("INTERNAS"), "LTR", 1, 'C');
    $pdf->SetX($set_x);
    $pdf->Cell(15, 4, utf8_decode("GRABADAS"), "BLR", 0, 'C');
    $set_x = $pdf-> GetX();
    $pdf->SetXY($set_x, $pdf->GetY()-3);
    $pdf->Cell(15, 3, utf8_decode("DEBITO"), "LTR", 1, 'C');
    $pdf->SetX($set_x);
    $pdf->Cell(15, 4, utf8_decode("FISCAL"), "BLR", 0, 'C');



    $set_x = $pdf-> GetX();
    $pdf->SetXY($set_x, $set_y);
    $pdf->Cell(39, 3, utf8_decode("A CUENTA DE TERCEROS"), 1, 1, 'C');
    $pdf->SetX($set_x);
    $pdf->Cell(13, 7, utf8_decode("EXENTAS"), 1, 0, 'C');
    $set_x = $pdf-> GetX();
    $pdf->SetX($set_x);
    $pdf->Cell(13, 3, utf8_decode("INTERNAS"), "LR", 1, 'C');
    $pdf->SetX($set_x);
    $pdf->Cell(13, 4, utf8_decode("GRABADAS"), "BLR", 0, 'C');
    $set_x = $pdf-> GetX();
    $pdf->SetXY($set_x, $pdf->GetY()-3);
    $pdf->Cell(13, 3, utf8_decode("DEBITO"), "LTR", 1, 'C');
    $pdf->SetX($set_x);
    $pdf->Cell(13, 4, utf8_decode("FISCAL"), "BLR", 0, 'C');

    $set_x = $pdf-> GetX();
    $pdf->SetXY($set_x, $set_y-5);
    $pdf->Cell(10, 7, utf8_decode("IVA"), "TLR", 1, 'C');
    $pdf->SetX($set_x);
    $pdf->Cell(10, 8, utf8_decode("RET"), "LBR", 0, 'C');

    $set_x = $pdf-> GetX();
    $pdf->SetXY($set_x, $set_y-5);
    $pdf->Cell(15, 7, utf8_decode("TOTAL"), "LTR", 1, 'C');
    $pdf->SetX($set_x);
    $pdf->Cell(15, 8, utf8_decode("VENTAS"), "LBR", 1, 'C');
    $pdf->SetFont('Latin', '', 6);

    $sql=_query("SELECT factura.id_factura,factura.tipo_documento,factura.fecha,factura.num_fact_impresa,factura.serie,cliente.nombre,cliente.nrc,factura.iva as total_iva,factura.retencion AS total_retencion,factura.total,factura.anulada FROM factura JOIN cliente ON cliente.id_cliente=factura.id_cliente WHERE factura.fecha BETWEEN '".$_REQUEST[fini]."' AND '".$_REQUEST[ffin]."' AND tipo_documento='CCF' AND factura.id_sucursal=$id_sucursal  ");
    $nrows=_num_rows($sql);
    $i=1;
    $pa=1;
    $c=1;
    if ($nrows>0) {
        $pasa = 0;
        while ($row=_fetch_array($sql)) {
            if ($c==32&&$pa==1) {
                # code...
                $pdf->AddPage();
                //$pdf->Image($logo,8,4,30,25);
                $pdf->SetFont('Arial', '', 10);

                $pasa = 1;

                //Encabezado General
                //Encabezado General
                $set_x=0;
                $set_y=10;
                $pdf->SetFont('Latin', '', 6);
                $pa++;
                $c=1;
                $set_x = 5;
                $pdf->SetXY($set_x, $set_y);
                $pdf->Cell(6, 15, utf8_decode("Nº"), 1, 0, 'C');
                $set_y=$pdf->GetY();
                $set_x = $pdf-> GetX();
                $pdf->Cell(15, 7, utf8_decode("FECHA"), "TLR", 1, 'C');
                $pdf->SetX($set_x);
                $pdf->Cell(15, 8, utf8_decode("DE EMISION"), "BLR", 0, 'C');

                $set_x = $pdf-> GetX();
                $pdf->SetXY($set_x, $set_y);
                $set_x = $pdf-> GetX();
                $pdf->Cell(18, 5, utf8_decode("NUMERO DE"), "TLR", 1, 'C');
                $pdf->SetX($set_x);
                $pdf->Cell(18, 5, utf8_decode("CORRELATIVO"), "LR", 1, 'C');
                $pdf->SetX($set_x);
                $pdf->Cell(18, 5, utf8_decode("IMPRESO"), "BLR", 0, 'C');


                $set_x = $pdf-> GetX();
                $pdf->SetXY($set_x, $set_y);
                $pdf->Cell(14, 5, utf8_decode("PREFIJO"), "TLR", 1, 'C');
                $pdf->SetX($set_x);
                $pdf->Cell(14, 5, utf8_decode("O"), "LR", 1, 'C');
                $pdf->SetX($set_x);
                $pdf->Cell(14, 5, utf8_decode("SERIE"), "BLR", 0, 'C');

                $set_x = $pdf-> GetX();
                $pdf->SetXY($set_x, $set_y);
                $pdf->Cell(16, 5, utf8_decode("NUMERO"), "TLR", 1, 'C');
                $pdf->SetX($set_x);
                $pdf->Cell(16, 5, utf8_decode("DE CONTROL"), "LR", 1, 'C');
                $pdf->SetX($set_x);
                $pdf->Cell(16, 5, utf8_decode("INTERNO"), "BLR", 0, 'C');

                $set_x = $pdf-> GetX();
                $pdf->SetXY($set_x, $set_y);
                $pdf->Cell(67, 15, utf8_decode("NOMBRE DEL CLIENTE"), 1, 0, 'C');

                $set_x = $pdf-> GetX();
                $pdf->SetXY($set_x, $set_y);
                $pdf->Cell(10, 15, utf8_decode("NRC"), 1, 0, 'C');

                $set_x = $pdf-> GetX();
                $pdf->SetXY($set_x, $set_y);
                $pdf->Cell(99, 5, utf8_decode("OPERACIONES DE VENTAS PROPIAS Y A CUENTA DE TERCEROS"), 1, 1, 'C');
                $set_y=$set_y+5;

                $pdf->SetXY($set_x, $set_y);
                $pdf->Cell(60, 3, utf8_decode("PROPIAS"), 1, 1, 'C');
                $pdf->SetX($set_x);
                $pdf->Cell(15, 3, utf8_decode("NO"), "LR", 1, 'C');
                $pdf->SetX($set_x);
                $pdf->Cell(15, 4, utf8_decode("SUJETAS"), "BLR", 0, 'C');
                $set_x = $pdf-> GetX();
                $pdf->SetXY($set_x, $pdf->GetY()-3);
                $pdf->Cell(15, 7, utf8_decode("EXENTAS"), 1, 0, 'C');
                $set_x = $pdf-> GetX();
                $pdf->SetX($set_x);
                $pdf->Cell(15, 3, utf8_decode("INTERNAS"), "LTR", 1, 'C');
                $pdf->SetX($set_x);
                $pdf->Cell(15, 4, utf8_decode("GRABADAS"), "BLR", 0, 'C');
                $set_x = $pdf-> GetX();
                $pdf->SetXY($set_x, $pdf->GetY()-3);
                $pdf->Cell(15, 3, utf8_decode("DEBITO"), "LTR", 1, 'C');
                $pdf->SetX($set_x);
                $pdf->Cell(15, 4, utf8_decode("FISCAL"), "BLR", 0, 'C');



                $set_x = $pdf-> GetX();
                $pdf->SetXY($set_x, $set_y);
                $pdf->Cell(39, 3, utf8_decode("A CUENTA DE TERCEROS"), 1, 1, 'C');
                $pdf->SetX($set_x);
                $pdf->Cell(13, 7, utf8_decode("EXENTAS"), 1, 0, 'C');
                $set_x = $pdf-> GetX();
                $pdf->SetX($set_x);
                $pdf->Cell(13, 3, utf8_decode("INTERNAS"), "LR", 1, 'C');
                $pdf->SetX($set_x);
                $pdf->Cell(13, 4, utf8_decode("GRABADAS"), "BLR", 0, 'C');
                $set_x = $pdf-> GetX();
                $pdf->SetXY($set_x, $pdf->GetY()-3);
                $pdf->Cell(13, 3, utf8_decode("DEBITO"), "LTR", 1, 'C');
                $pdf->SetX($set_x);
                $pdf->Cell(13, 4, utf8_decode("FISCAL"), "BLR", 0, 'C');

                $set_x = $pdf-> GetX();
                $pdf->SetXY($set_x, $set_y-5);
                $pdf->Cell(10, 7, utf8_decode("IVA"), "TLR", 1, 'C');
                $pdf->SetX($set_x);
                $pdf->Cell(10, 8, utf8_decode("RET"), "LBR", 0, 'C');

                $set_x = $pdf-> GetX();
                $pdf->SetXY($set_x, $set_y-5);
                $pdf->Cell(15, 7, utf8_decode("TOTAL"), "LTR", 1, 'C');
                $pdf->SetX($set_x);
                $pdf->Cell(15, 8, utf8_decode("VENTAS"), "LBR", 1, 'C');

                $pdf->Cell(146, 5, utf8_decode("VIENEN: "), "T", 0, 'R');
                $pdf->Cell(15, 5, utf8_decode(number_format(0.00, 2)), "T", 0, 'R');
                $pdf->Cell(15, 5, utf8_decode(number_format(0.00, 2)), "T", 0, 'R');
                $pdf->Cell(15, 5, utf8_decode(number_format($total_internas_gravadas, 2)), "T", 0, 'R');
                $pdf->Cell(15, 5, utf8_decode(number_format($total_debito_fiscal, 2)), "T", 0, 'R');
                $pdf->Cell(13, 5, utf8_decode(number_format(0.00, 2)), "T", 0, 'R');
                $pdf->Cell(13, 5, utf8_decode(number_format(0.00, 2)), "T", 0, 'R');
                $pdf->Cell(13, 5, utf8_decode(number_format(0.00, 2)), "T", 0, 'R');
                $pdf->Cell(10, 5, utf8_decode(number_format($total_retencion, 2)), "T", 0, 'R');
                $pdf->Cell(15, 5, utf8_decode(number_format($total_ventas, 2)), "T", 1, 'R');
                $c++;
            } else {
                if ($c==37&&$pa>1) {
                    # code...
                    $pasa = 1;

                    $pdf->AddPage();
                    //$pdf->Image($logo,8,4,30,25);
                    $pdf->SetFont('Arial', '', 10);


                    //Encabezado General
                    //Encabezado General
                    $set_x=0;


                    $pdf->SetFont('Latin', '', 6);
                    $c=1;
                    $set_x = 5;
                    $set_y = 10;
                    $pdf->SetXY($set_x, $set_y);
                    $pdf->Cell(6, 15, utf8_decode("Nº"), 1, 0, 'C');
                    $set_y=$pdf->GetY();
                    $set_x = $pdf-> GetX();
                    $pdf->Cell(15, 7, utf8_decode("FECHA"), "TLR", 1, 'C');
                    $pdf->SetX($set_x);
                    $pdf->Cell(15, 8, utf8_decode("DE EMISION"), "BLR", 0, 'C');

                    $set_x = $pdf-> GetX();
                    $pdf->SetXY($set_x, $set_y);
                    $set_x = $pdf-> GetX();
                    $pdf->Cell(18, 5, utf8_decode("NUMERO DE"), "TLR", 1, 'C');
                    $pdf->SetX($set_x);
                    $pdf->Cell(18, 5, utf8_decode("CORRELATIVO"), "LR", 1, 'C');
                    $pdf->SetX($set_x);
                    $pdf->Cell(18, 5, utf8_decode("IMPRESO"), "BLR", 0, 'C');


                    $set_x = $pdf-> GetX();
                    $pdf->SetXY($set_x, $set_y);
                    $pdf->Cell(14, 5, utf8_decode("PREFIJO"), "TLR", 1, 'C');
                    $pdf->SetX($set_x);
                    $pdf->Cell(14, 5, utf8_decode("O"), "LR", 1, 'C');
                    $pdf->SetX($set_x);
                    $pdf->Cell(14, 5, utf8_decode("SERIE"), "BLR", 0, 'C');

                    $set_x = $pdf-> GetX();
                    $pdf->SetXY($set_x, $set_y);
                    $pdf->Cell(16, 5, utf8_decode("NUMERO"), "TLR", 1, 'C');
                    $pdf->SetX($set_x);
                    $pdf->Cell(16, 5, utf8_decode("DE CONTROL"), "LR", 1, 'C');
                    $pdf->SetX($set_x);
                    $pdf->Cell(16, 5, utf8_decode("INTERNO"), "BLR", 0, 'C');

                    $set_x = $pdf-> GetX();
                    $pdf->SetXY($set_x, $set_y);
                    $pdf->Cell(67, 15, utf8_decode("NOMBRE DEL CLIENTE"), 1, 0, 'C');

                    $set_x = $pdf-> GetX();
                    $pdf->SetXY($set_x, $set_y);
                    $pdf->Cell(10, 15, utf8_decode("NRC"), 1, 0, 'C');

                    $set_x = $pdf-> GetX();
                    $pdf->SetXY($set_x, $set_y);
                    $pdf->Cell(99, 5, utf8_decode("OPERACIONES DE VENTAS PROPIAS Y A CUENTA DE TERCEROS"), 1, 1, 'C');
                    $set_y=$set_y+5;

                    $pdf->SetXY($set_x, $set_y);
                    $pdf->Cell(60, 3, utf8_decode("PROPIAS"), 1, 1, 'C');
                    $pdf->SetX($set_x);
                    $pdf->Cell(15, 3, utf8_decode("NO"), "LR", 1, 'C');
                    $pdf->SetX($set_x);
                    $pdf->Cell(15, 4, utf8_decode("SUJETAS"), "BLR", 0, 'C');
                    $set_x = $pdf-> GetX();
                    $pdf->SetXY($set_x, $pdf->GetY()-3);
                    $pdf->Cell(15, 7, utf8_decode("EXENTAS"), 1, 0, 'C');
                    $set_x = $pdf-> GetX();
                    $pdf->SetX($set_x);
                    $pdf->Cell(15, 3, utf8_decode("INTERNAS"), "LTR", 1, 'C');
                    $pdf->SetX($set_x);
                    $pdf->Cell(15, 4, utf8_decode("GRABADAS"), "BLR", 0, 'C');
                    $set_x = $pdf-> GetX();
                    $pdf->SetXY($set_x, $pdf->GetY()-3);
                    $pdf->Cell(15, 3, utf8_decode("DEBITO"), "LTR", 1, 'C');
                    $pdf->SetX($set_x);
                    $pdf->Cell(15, 4, utf8_decode("FISCAL"), "BLR", 0, 'C');



                    $set_x = $pdf-> GetX();
                    $pdf->SetXY($set_x, $set_y);
                    $pdf->Cell(39, 3, utf8_decode("A CUENTA DE TERCEROS"), 1, 1, 'C');
                    $pdf->SetX($set_x);
                    $pdf->Cell(13, 7, utf8_decode("EXENTAS"), 1, 0, 'C');
                    $set_x = $pdf-> GetX();
                    $pdf->SetX($set_x);
                    $pdf->Cell(13, 3, utf8_decode("INTERNAS"), "LR", 1, 'C');
                    $pdf->SetX($set_x);
                    $pdf->Cell(13, 4, utf8_decode("GRABADAS"), "BLR", 0, 'C');
                    $set_x = $pdf-> GetX();
                    $pdf->SetXY($set_x, $pdf->GetY()-3);
                    $pdf->Cell(13, 3, utf8_decode("DEBITO"), "LTR", 1, 'C');
                    $pdf->SetX($set_x);
                    $pdf->Cell(13, 4, utf8_decode("FISCAL"), "BLR", 0, 'C');

                    $set_x = $pdf-> GetX();
                    $pdf->SetXY($set_x, $set_y-5);
                    $pdf->Cell(10, 7, utf8_decode("IVA"), "TLR", 1, 'C');
                    $pdf->SetX($set_x);
                    $pdf->Cell(10, 8, utf8_decode("RET"), "LBR", 0, 'C');

                    $set_x = $pdf-> GetX();
                    $pdf->SetXY($set_x, $set_y-5);
                    $pdf->Cell(15, 7, utf8_decode("TOTAL"), "LTR", 1, 'C');
                    $pdf->SetX($set_x);
                    $pdf->Cell(15, 8, utf8_decode("VENTAS"), "LBR", 1, 'C');

                    $pdf->Cell(146, 5, utf8_decode("VIENEN: "), "T", 0, 'R');
                    $pdf->Cell(15, 5, utf8_decode(number_format(0.00, 2)), "T", 0, 'R');
                    $pdf->Cell(15, 5, utf8_decode(number_format(0.00, 2)), "T", 0, 'R');
                    $pdf->Cell(15, 5, utf8_decode(number_format($total_internas_gravadas, 2)), "T", 0, 'R');
                    $pdf->Cell(15, 5, utf8_decode(number_format($total_debito_fiscal, 2)), "T", 0, 'R');
                    $pdf->Cell(13, 5, utf8_decode(number_format(0.00, 2)), "T", 0, 'R');
                    $pdf->Cell(13, 5, utf8_decode(number_format(0.00, 2)), "T", 0, 'R');
                    $pdf->Cell(13, 5, utf8_decode(number_format(0.00, 2)), "T", 0, 'R');
                    $pdf->Cell(10, 5, utf8_decode(number_format($total_retencion, 2)), "T", 0, 'R');
                    $pdf->Cell(15, 5, utf8_decode(number_format($total_ventas, 2)), "T", 1, 'R');
                    $c++;
                }
            }

            $pdf->Cell(6, 5, utf8_decode($i), 0, 0, 'C');
            $pdf->Cell(15, 5, utf8_decode(ED($row['fecha'])), 0, 0, 'C');
            $pdf->Cell(18, 5, utf8_decode($row['num_fact_impresa']), 0, 0, 'C');
            $pdf->Cell(14, 5, utf8_decode($row['serie']), 0, 0, 'C');
            $pdf->Cell(16, 5, utf8_decode($row['id_factura']), 0, 0, 'C');

            if ($row['anulada']==1) {
                # code...
                $pdf->Cell(67, 5, utf8_decode("<<COMPROBANTE ANULADO>>"), 0, 0, 'L');

                $pdf->Cell(10, 5, utf8_decode(""), 0, 0, 'L');

                $pdf->Cell(15, 5, utf8_decode(number_format(0.00, 2)), 0, 0, 'R');

                $pdf->Cell(15, 5, utf8_decode(number_format(0.00, 2)), 0, 0, 'R');
                $pdf->Cell(15, 5, utf8_decode(number_format(0.00, 2)), 0, 0, 'R');
                $pdf->Cell(15, 5, utf8_decode(number_format(0.00, 2)), 0, 0, 'R');

                $pdf->Cell(13, 5, utf8_decode(number_format(0.00, 2)), 0, 0, 'R');
                $pdf->Cell(13, 5, utf8_decode(number_format(0.00, 2)), 0, 0, 'R');
                $pdf->Cell(13, 5, utf8_decode(number_format(0.00, 2)), 0, 0, 'R');

                $pdf->Cell(10, 5, utf8_decode(number_format(0.00, 2)), 0, 0, 'R');
                $pdf->Cell(15, 5, utf8_decode(number_format(0.00, 2)), 0, 1, 'R');
            } else {
                # code...
                $pdf->Cell(67, 5, utf8_decode($row['nombre']), 0, 0, 'L');

                $pdf->Cell(10, 5, utf8_decode($row['nrc']), 0, 0, 'L');

                $pdf->Cell(15, 5, utf8_decode(number_format(0.00, 2)), 0, 0, 'R');

                $pdf->Cell(15, 5, utf8_decode(number_format(0.00, 2)), 0, 0, 'R');
                $pdf->Cell(15, 5, utf8_decode(number_format(($row['total']-$row['total_iva']), 2)), 0, 0, 'R');

                $total_internas_gravadas=$total_internas_gravadas+(round(($row['total']-$row['total_iva']), 2));

                $pdf->Cell(15, 5, utf8_decode(number_format(($row['total_iva']), 2)), 0, 0, 'R');
                $total_debito_fiscal=$total_debito_fiscal+$row['total_iva'];

                $pdf->Cell(13, 5, utf8_decode(number_format(0.00, 2)), 0, 0, 'R');
                $pdf->Cell(13, 5, utf8_decode(number_format(0.00, 2)), 0, 0, 'R');
                $pdf->Cell(13, 5, utf8_decode(number_format(0.00, 2)), 0, 0, 'R');

                $pdf->Cell(10, 5, utf8_decode(number_format($row['total_retencion'], 2)), 0, 0, 'R');
                $total_retencion=$total_retencion+$row['total_retencion'];

                $pdf->Cell(15, 5, utf8_decode(number_format($row['total'], 2)), 0, 1, 'R');
                $total_ventas=$total_ventas+$row['total'];
            }
            $i++;
            $c++;
            if ($c==32 && $pasa == 0) {
                // code...
                $pdf->Cell(146, 5, utf8_decode("PASAN: "), "T", 0, 'R');
                $pdf->Cell(15, 5, utf8_decode(number_format(0.00, 2)), "T", 0, 'R');
                $pdf->Cell(15, 5, utf8_decode(number_format(0.00, 2)), "T", 0, 'R');
                $pdf->Cell(15, 5, utf8_decode(number_format($total_internas_gravadas, 2)), "T", 0, 'R');
                $pdf->Cell(15, 5, utf8_decode(number_format($total_debito_fiscal, 2)), "T", 0, 'R');
                $pdf->Cell(13, 5, utf8_decode(number_format(0.00, 2)), "T", 0, 'R');
                $pdf->Cell(13, 5, utf8_decode(number_format(0.00, 2)), "T", 0, 'R');
                $pdf->Cell(13, 5, utf8_decode(number_format(0.00, 2)), "T", 0, 'R');
                $pdf->Cell(10, 5, utf8_decode(number_format($total_retencion, 2)), "T", 0, 'R');
                $pdf->Cell(15, 5, utf8_decode(number_format($total_ventas, 2)), "T", 1, 'R');
            }
            if ($c==37) {
                // code...
                $pdf->Cell(146, 5, utf8_decode("PASAN: "), "T", 0, 'R');
                $pdf->Cell(15, 5, utf8_decode(number_format(0.00, 2)), "T", 0, 'R');
                $pdf->Cell(15, 5, utf8_decode(number_format(0.00, 2)), "T", 0, 'R');
                $pdf->Cell(15, 5, utf8_decode(number_format($total_internas_gravadas, 2)), "T", 0, 'R');
                $pdf->Cell(15, 5, utf8_decode(number_format($total_debito_fiscal, 2)), "T", 0, 'R');
                $pdf->Cell(13, 5, utf8_decode(number_format(0.00, 2)), "T", 0, 'R');
                $pdf->Cell(13, 5, utf8_decode(number_format(0.00, 2)), "T", 0, 'R');
                $pdf->Cell(13, 5, utf8_decode(number_format(0.00, 2)), "T", 0, 'R');
                $pdf->Cell(10, 5, utf8_decode(number_format($total_retencion, 2)), "T", 0, 'R');
                $pdf->Cell(15, 5, utf8_decode(number_format($total_ventas, 2)), "T", 1, 'R');
            }
        }
    }

    $pdf->Cell(146, 5, utf8_decode("TOTALES: "), "T", 0, 'R');
    $pdf->Cell(15, 5, utf8_decode(number_format(0.00, 2)), "T", 0, 'R');
    $pdf->Cell(15, 5, utf8_decode(number_format(0.00, 2)), "T", 0, 'R');
    $pdf->Cell(15, 5, utf8_decode(number_format($total_internas_gravadas, 2)), "T", 0, 'R');
    $pdf->Cell(15, 5, utf8_decode(number_format($total_debito_fiscal, 2)), "T", 0, 'R');
    $pdf->Cell(13, 5, utf8_decode(number_format(0.00, 2)), "T", 0, 'R');
    $pdf->Cell(13, 5, utf8_decode(number_format(0.00, 2)), "T", 0, 'R');
    $pdf->Cell(13, 5, utf8_decode(number_format(0.00, 2)), "T", 0, 'R');
    $pdf->Cell(10, 5, utf8_decode(number_format($total_retencion, 2)), "T", 0, 'R');
    $pdf->Cell(15, 5, utf8_decode(number_format($total_ventas, 2)), "T", 0, 'R');



ob_clean();
$pdf->Output("libro_contribuyente.pdf", "I");
