<?php

error_reporting(E_ERROR | E_PARSE);
require("_core.php");
require("num2letras.php");
require('fpdf/fpdf.php');


$pdf=new fPDF('L','mm', 'Letter');
$pdf->SetMargins(10,5);
$pdf->SetTopMargin(2);
$pdf->SetLeftMargin(10);
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,5);
$pdf->AddFont("latin","","latin.php");
$id_sucursal = $_SESSION["id_sucursal"];
$sql_empresa = "SELECT * FROM sucursal WHERE id_sucursal='$id_sucursal'";

$resultado_emp=_query($sql_empresa);
$row_emp=_fetch_array($resultado_emp);
$nombre_a = utf8_decode(Mayu(utf8_decode(trim($row_emp["descripcion"]))));
//$direccion = Mayu(utf8_decode($row_emp["direccion_empresa"]));
$direccion = utf8_decode(Mayu(utf8_decode(trim($row_emp["direccion"]))));
$tel1 = $row_emp['telefono'];
$telefonos="TEL. ".$tel1;

    $fini = $_REQUEST["fini"];
    $ffin = $_REQUEST["fin"];
    $id_cuenta = $_REQUEST["id_cuenta"];
    $logo = "img/logo_sys.jpg";
    $impress = "Impreso: ".date("d/m/Y");
    if($fini!="" && $ffin!="")
    {
        list($a,$m,$d) = explode("-", $fini);
        list($a1,$m1,$d1) = explode("-", $ffin);
        if($a ==$a1)
        {
            if($m==$m1)
            {
                $fech="DEL $d AL $d1 DE ".meses($m)." DE $a";
            }
            else
            {
                $fech="DEL $d DE ".meses($m)." AL $d1 DE ".meses($m1)." DE $a";
            }
        }
        else
        {
            $fech="DEL $d DE ".meses($m)." DEL $a AL $d1 DE ".meses($m1)." DE $a1";
        }
    }
    $title = "";
    $titulo = "LIBRO DE BANCO";


    $sql_c = _query("SELECT b.nombre, b.logo, cb.nombre_cuenta, cb.numero_cuenta FROM bancos as b, cuenta_bancos as cb WHERE b.id_banco=cb.id_banco AND cb.id_cuenta='$id_cuenta'");
    $datsc = _fetch_array($sql_c);
    $banco = $datsc["nombre_cuenta"].": ".$datsc["numero_cuenta"];
    $bnc = $datsc["nombre"];
    $logob = $datsc["logo"];
    $pdf->AddPage();
    $pdf->SetFont('Latin','',10);
    $pdf->Image($logo,9,4,50,18);
    //$pdf->Image($logob,220,4,50,15);
    $set_x = 0;
    $set_y = 6;

    //Encabezado General
    $pdf->SetFont('Latin','',12);
    $pdf->SetXY($set_x, $set_y);
    $pdf->Cell(280,6,$title,0,1,'C');
    $pdf->SetFont('Latin','',10);
    $pdf->SetXY($set_x, $set_y+6);
    $pdf->Cell(280,6,$nombre_a." ".$direccion,0,1,'C');
    $pdf->SetXY($set_x, $set_y+11);
    $pdf->Cell(280,6,$telefonos,0,1,'C');
    $pdf->SetXY($set_x, $set_y+16);
    $pdf->Cell(280,6,utf8_decode($titulo),0,1,'C');
    $pdf->SetXY($set_x, $set_y+20);
    $pdf->Cell(280,6,$banco,0,1,'C');
    $pdf->SetXY($set_x, $set_y+24);
    $pdf->Cell(280,6,$bnc,0,1,'C');
    $pdf->SetXY($set_x, $set_y+28);
    $pdf->Cell(280,6,$fech,0,1,'C');

    $set_y = 42;
    $set_x = 10;

    $pdf->SetXY($set_x, $set_y);
    $pdf->Cell(30,5,"FECHA",1,1,'C',0);
    $pdf->SetXY($set_x+30, $set_y);
    $pdf->Cell(40,5,"RESPONSABLE",1,1,'C',0);
    $pdf->SetXY($set_x+70, $set_y);
    $pdf->Cell(80,5,"CONCEPTO",1,1,'C',0);
    $pdf->SetXY($set_x+150, $set_y);
    $pdf->Cell(35,5,"REFERENCIA",1,1,'C',0);
    $pdf->SetXY($set_x+185, $set_y);
    $pdf->Cell(25,5,"ENTADA",1,1,'C',0);
    $pdf->SetXY($set_x+210, $set_y);
    $pdf->Cell(25,5,"SALIDA",1,1,'C',0);
    $pdf->SetXY($set_x+235, $set_y);
    $pdf->Cell(25,5,"SALDO",1,1,'C',0);

    $mm = 0;
    $i = 1;
    $set_y = 47;
    $set_x = 10;
    $page = 0;
    $countt = 0;
    $tot = "";
    $pdf->SetFont('Latin','',10);

    $sql_ini = _query("SELECT MIN(id_movimiento) as primero FROM mov_cta_banco WHERE id_cuenta='$id_cuenta' AND fecha BETWEEN '$fini' AND '$ffin'");
    $dta = _fetch_array($sql_ini);
    $primero = $dta["primero"];
    $sql_sa = _query("SELECT saldo FROM mov_cta_banco WHERE id_cuenta='$id_cuenta' AND id_movimiento<'$primero' ORDER BY id_movimiento DESC LIMIT 1");
    $saldo_a = _fetch_array($sql_sa)["saldo"];
    $sql = _query("SELECT * FROM mov_cta_banco WHERE id_cuenta='$id_cuenta' AND fecha BETWEEN '$fini' AND '$ffin' ORDER BY id_movimiento ASC");
    $lh = 0;
    $pdf->SetXY($set_x, $set_y+$lh);
    $pdf->Cell(235,5,"Saldo Anterior",1,1,'C',0);
    $pdf->SetXY($set_x+235, $set_y+$lh);
    $pdf->Cell(25,5,"$".number_format($saldo_a,2,".",","),1,1,'R',0);
    $lh = 5;
    $tot_s = 0;
    $tot_e = 0;
    while ($row = _fetch_array($sql))
    {
        $responsable = $row["responsable"];
        $concepto = $row["concepto"];
        $fecha = $row["fecha"];
        $entrada = $row["entrada"];
        $salida = $row["salida"];
        $saldo = $row["saldo"];
        $numero_doc = $row["numero_doc"];
        $alias_tipodoc = $row["alias_tipodoc"];
        $tot_e += $entrada;
        $tot_s += $salida;
        $val_e = 32;
        if(!$page)
        {
            $val_e = 30;
        }
        if($countt >= $val_e)
        {

            $page = 1;
            $pdf->AddPage();
            $pdf->SetFont('Latin','',10);
            $pdf->Image($logo,9,4,20,20);
            $set_x = 0;
            $set_y = 8;

                //Encabezado General
            $pdf->SetFont('Latin','',12);
            $pdf->SetXY($set_x, $set_y);
            $pdf->Cell(280,6,$title,0,1,'C');
            $pdf->SetFont('Latin','',10);
            $pdf->SetXY($set_x, $set_y+6);
            $pdf->Cell(280,6,$nombre_a." ".$direccion,0,1,'C');
            $pdf->SetXY($set_x, $set_y+11);
            $pdf->Cell(280,6,$telefonos,0,1,'C');
            $pdf->SetXY($set_x, $set_y+16);
            $pdf->Cell(280,6,utf8_decode($titulo),0,1,'C');
            $pdf->SetXY($set_x, $set_y+20);
            $pdf->Cell(280,6,$banco,0,1,'C');
            $pdf->SetXY($set_x, $set_y+24);
            $pdf->Cell(280,6,$bnc,0,1,'C');
            $pdf->SetXY($set_x, $set_y+28);
            $pdf->Cell(280,6,$fech,0,1,'C');

            $set_y = 42;
            $set_x = 10;
            $countt = 0;
            $mm = 0;
            $lh = 0;

        }
        if($salida > 0)
            $salida = "$".number_format($salida, 2 ,".",",");
        else
            $salida = "-";
        if($entrada > 0)
            $entrada = "$".number_format($entrada, 2 ,".",",");
        else
            $entrada = "-";
        if($saldo > 0)
            $saldo = "$".number_format($saldo, 2 ,".",",");
        else
            $saldo = "-";
        $pdf->SetXY($set_x, $set_y+$lh);
        $pdf->Cell(30,5,ED($fecha),1,1,'C',0);
        $pdf->SetXY($set_x+30, $set_y+$lh);
        $pdf->Cell(40,5,$responsable,1,1,'L',0);
        $pdf->SetXY($set_x+70, $set_y+$lh);
        $pdf->Cell(80,5,$concepto,1,1,'L',0);
        $pdf->SetXY($set_x+150, $set_y+$lh);
        $pdf->Cell(35,5,$alias_tipodoc." ".$numero_doc,1,1,'L',0);
        $pdf->SetXY($set_x+185, $set_y+$lh);
        $pdf->Cell(25,5,$entrada,1,1,'R',0);
        $pdf->SetXY($set_x+210, $set_y+$lh);
        $pdf->Cell(25,5,$salida,1,1,'R',0);
        $pdf->SetXY($set_x+235, $set_y+$lh);
        $pdf->Cell(25,5,$saldo,1,1,'R',0);
        $lh += 5;
        $i++;
        $countt ++;
        if($countt ==1)
        {
            $pdf->SetXY(15, 205);
            $pdf->Cell(10, 0.4,"", 0, 0, 'L');
            $pdf->SetXY(15, 205);
            $pdf->Cell(0, 0.4, 'Pag. '.$pdf->PageNo().' de {nb}', 0, 0, 'R');
        }

    }
    $val_e = 32;
    if(!$page)
    {
        $val_e = 31;
    }
    if($countt >= $val_e)
    {

        $page = 1;
        $pdf->AddPage();
        $pdf->SetFont('Latin','',10);
        $pdf->Image($logo,9,4,20,20);
        $set_x = 0;
        $set_y = 8;
        //Encabezado General
        $pdf->SetFont('Latin','',12);
        $pdf->SetXY($set_x, $set_y);
        $pdf->Cell(280,6,$title,0,1,'C');
        $pdf->SetFont('Latin','',10);
        $pdf->SetXY($set_x, $set_y+6);
        $pdf->Cell(280,6,$nombre_a." ".$direccion,0,1,'C');
        $pdf->SetXY($set_x, $set_y+11);
        $pdf->Cell(280,6,$telefonos,0,1,'C');
        $pdf->SetXY($set_x, $set_y+16);
        $pdf->Cell(280,6,utf8_decode($titulo),0,1,'C');
        $pdf->SetXY($set_x, $set_y+20);
        $pdf->Cell(280,6,$banco,0,1,'C');
        $pdf->SetXY($set_x, $set_y+24);
        $pdf->Cell(280,6,$bnc,0,1,'C');
        $pdf->SetXY($set_x, $set_y+28);
        $pdf->Cell(280,6,$fech,0,1,'C');

        $set_y = 42;
        $set_x = 10;
        $countt = 0;
        $mm = 0;
        $lh = 0;

    }

    $pdf->SetFont("Latin","",10);
    $pdf->SetXY($set_x, $set_y+$lh);
    $pdf->Cell(185,5,"Total",1,1,'C',0);
    $pdf->SetXY($set_x+185, $set_y+$lh);
    $pdf->Cell(25,5,"$".number_format($tot_e,2,".",","),1,1,'R',0);
    $pdf->SetXY($set_x+210, $set_y+$lh);
    $pdf->Cell(25,5,"$".number_format($tot_s,2,".",","),1,1,'R',0);
    $pdf->SetXY($set_x+235, $set_y+$lh);
    $pdf->Cell(25,5,"",1,1,'C',0);

    $countt ++;
    if($countt ==1)
    {
        $pdf->SetXY(15, 205);
        $pdf->Cell(10, 0.4,"", 0, 0, 'L');
        $pdf->SetXY(15, 205);
        $pdf->Cell(0, 0.4, 'Pag. '.$pdf->PageNo().' de {nb}', 0, 0, 'R');
    }
ob_clean();
$pdf->Output("libro_banco.pdf","I");
?>
