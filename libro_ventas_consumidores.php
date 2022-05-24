<?php
error_reporting(E_ERROR | E_PARSE);
require("_core.php");
require("num2letras.php");
require('fpdf/fpdf.php');


$pdf=new fPDF('P','mm', 'Letter');
$pdf->SetMargins(10,5);
$pdf->SetTopMargin(5);
$pdf->SetLeftMargin(5);
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,1);
$pdf->AddFont("latin","","latin.php");
$id_sucursal = $_SESSION["id_sucursal"];
$sql_empresa = "SELECT * FROM sucursal WHERE id_sucursal='$id_sucursal'";

$resultado_emp=_query($sql_empresa);
$row_emp=_fetch_array($resultado_emp);
$nombre_a = utf8_decode(Mayu(utf8_decode(trim($row_emp["descripcion"]))));
//$direccion = Mayu(utf8_decode($row_emp["direccion_empresa"]));
$direccion = utf8_decode(Mayu(utf8_decode(trim($row_emp["direccion"]))));


    $fini = ($_REQUEST["fini"]);//date("Y-m-d");
    $fin = ($_REQUEST["ffin"]);
    $fini1 = $_REQUEST["fini"];
    $fin1 = $_REQUEST["ffin"];
    $logo = "img/logo_sys.png";

    $title = $nombre_a;
    $titulo = "LIBRO DE VENTAS A CONSUMIDORES";
    if($fini!="")
    {
      list($a,$m,$d) = explode("-", ($_REQUEST["fini"]));
      list($a1,$m1,$d1) = explode("-", ($_REQUEST["ffin"]));

      if($a ==$a1)
      {
        if($m==$m1)
        {
          if($d == $d1)
          {
            $fech="AL $d1 DE ".meses($m)." DE $a";
          }
          else
          {
            $fech="DEL $d AL $d1 DE ".meses($m)." DE $a";
          }
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
    $impress = "LIBRO DE VENTAS A CONSUMIDORES".$fech;

    $pdf->AddPage();
    //$pdf->Image($logo,8,4,30,25);
    $pdf->SetFont('Arial','',10);

    //Encabezado General
    //Encabezado General
    $set_x=0;
    $set_y=5;
    $pdf->SetFont('Arial','',14);
    $pdf->SetXY($set_x, $set_y);
    $pdf->MultiCell(216,6,$title,0,'C',0);
    $pdf->SetXY($set_x, $set_y+5);
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(216,6,utf8_decode($direccion),0,1,'C');
    $pdf->SetXY($set_x, $set_y+10);
    $pdf->Cell(216,6,utf8_decode($titulo),0,1,'C');
    $pdf->SetXY($set_x, $set_y+15);
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(216,6,$fech,0,1,'C');

    ///////////////////////////////////////////////////////////////////////

    $total_internas_gravadas=0;
    $total_debito_fiscal=0;
    $total_retencion=0;
    $total_ventas=0;

    $set_x = 5;
    $set_y = 30;

    $pdf->SetFont('Arial','',6);
    $pdf->SetXY($set_x, $set_y);

    $set_x = $pdf-> GetX();
    $pdf->Cell(15,7,utf8_decode("FECHA"),"TLR",1,'C');
    $pdf->SetX($set_x);
    $pdf->Cell(15,8,utf8_decode("DE EMISION"),"BLR",0,'C');

    $set_x = $pdf-> GetX();
    $pdf->SetXY($set_x, $set_y);
    $pdf->Cell(10,15,utf8_decode("TIPO"),1,0,'C');

    $set_x = $pdf-> GetX();
    $pdf->SetXY($set_x, $set_y);
    $pdf->Cell(15,15,utf8_decode("DEL Nº."),1,0,'C');

    $set_x = $pdf-> GetX();
    $pdf->SetXY($set_x, $set_y);
    $set_x = $pdf-> GetX();
    $pdf->Cell(15,15,utf8_decode("AL Nº."),1,0,'C');

    $set_x = $pdf-> GetX();
    $pdf->SetXY($set_x, $set_y);
    $pdf->Cell(20,3,utf8_decode("NUMERO DE"),"TLR",1,'C');
    $pdf->SetX($set_x);
    $pdf->Cell(20,4,utf8_decode("MAQUINA O"),"LR",1,'C');
    $pdf->SetX($set_x);
    $pdf->Cell(20,4,utf8_decode("CAJA"),"LR",1,'C');
    $pdf->SetX($set_x);
    $pdf->Cell(20,4,utf8_decode("REGISTRADORA"),"LBR",0,'C');

    $set_x = $pdf-> GetX();
    $pdf->SetXY($set_x, $set_y);
    $pdf->Cell(100,5,utf8_decode("VENTAS POR CUENTA PROPIA"),1,1  ,'C');
    $pdf->SetX($set_x);
    $pdf->Cell(20,5,utf8_decode("VENTAS"),"LR",1,'C');
    $pdf->SetX($set_x);
    $pdf->Cell(20,5,utf8_decode("NO SUJETAS"),"BLR",0 ,'C');

    $set_x = $pdf-> GetX();
    $pdf->SetXY($set_x,$pdf->GetY()-5);
    $pdf->Cell(20,5,utf8_decode("VENTAS"),"LR",1,'C');
    $pdf->SetX($set_x);
    $pdf->Cell(20,5,utf8_decode("EXENTAS"),"BLR",0 ,'C');

    $set_x = $pdf-> GetX();
    $pdf->SetXY($set_x,$pdf->GetY()-5);
    $pdf->Cell(20,3,utf8_decode("VENTAS"),"LTR",1,'C');
    $pdf->SetX($set_x);
    $pdf->Cell(20,3,utf8_decode("INTERNAS"),"LR",1,'C');
    $pdf->SetX($set_x);
    $pdf->Cell(20,4,utf8_decode("GRABADAS"),"BLR",0,'C');
    $set_x = $pdf-> GetX();
    $pdf->SetXY($set_x,$pdf->GetY()-6);
    $pdf->Cell(20,10,utf8_decode("EXPORTACIONES"),1,0,'C');

    $set_x = $pdf-> GetX();
    $pdf->SetX($set_x);
    $pdf->Cell(20,5,utf8_decode("VENTAS"),"TLR",1,'C');
    $pdf->SetX($set_x);
    $pdf->Cell(20,5,utf8_decode("TOTALES"),"BLR",0,'C');



    $set_x = $pdf-> GetX();
    $pdf->SetXY($set_x, $set_y);
    $pdf->Cell(15,5,utf8_decode("VENTAS POR"),"TLR",1,'C');
    $pdf->SetX($set_x);
    $pdf->Cell(15,5,utf8_decode("CUENTA DE"),"RL",1,'C');
    $pdf->SetX($set_x);
    $pdf->Cell(15,5,utf8_decode("TERCEROS"),"LBR",0,'C');

    $set_x = $pdf-> GetX();
    $pdf->SetXY($set_x, $set_y);
    $pdf->Cell(15,7,utf8_decode("1% DE"),"LTR",1,'C');
    $pdf->SetX($set_x);
    $pdf->Cell(15,8,utf8_decode("RETENCIÓN"),"LBR",1,'C');
    $pdf->SetFont('Arial','',6);

    $sql=_query("SELECT DISTINCT factura.fecha FROM factura WHERE factura.fecha BETWEEN '$fini' AND '$fin' AND factura.id_sucursal=$id_sucursal ORDER BY factura.fecha ASC");

    $nrows=_num_rows($sql);

    $total_ventas_internas_gravadas=0;
    $total_retencion=0;

    $i=1;
    $pa=1;
    $c=1;
    if ($nrows>0) {
      while ($row=_fetch_array($sql)) {

       $sql_min_max = _query("SELECT MIN(CONVERT(num_fact_impresa,UNSIGNED INTEGER)) as minimo, MAX(CONVERT(num_fact_impresa,UNSIGNED INTEGER)) as maximo FROM factura WHERE  numero_doc LIKE '%COF%' AND id_sucursal = '$id_sucursal' AND fecha = '$row[fecha]'");
       $nrowstik=_num_rows($sql_min_max);
       if ($nrowstik>0) {
            # code...

        $rowt2=_fetch_array($sql_min_max);
        if ($rowt2['minimo']!=""&&$rowt2['maximo']!="") {


          $pdf->Cell(15,5,utf8_decode(ED($row['fecha'])),0,0,'C');
          $pdf->Cell(10,5,utf8_decode("FAC"),0,0,'C');
          $pdf->Cell(15,5,utf8_decode($rowt2['minimo']),0,0,'C');
          $pdf->Cell(15,5,utf8_decode($rowt2['maximo']),0,0,'C');
          $pdf->Cell(20,5,utf8_decode(""),0,0,'C');
          $pdf->Cell(20,5,utf8_decode(number_format(0.00,2)),0,0,'R');
          $pdf->Cell(20,5,utf8_decode(number_format(0.00,2)),0,0,'R');

          $sql_tcof=_fetch_array(_query("SELECT SUM(factura.total) AS venta FROM factura WHERE factura.fecha='$row[fecha]' AND factura.tipo_documento='COF' AND factura.id_sucursal=$id_sucursal AND factura.anulada=0"));
          $pdf->Cell(20,5,utf8_decode(number_format($sql_tcof['venta'],2)),0,0,'R');
          $pdf->Cell(20,5,utf8_decode(number_format(0.00,2)),0,0,'R');
          $pdf->Cell(20,5,utf8_decode(number_format($sql_tcof['venta'],2)),0,0,'R');
          $total_ventas_internas_gravadas=$total_ventas_internas_gravadas+$sql_tcof['venta'];
          $pdf->Cell(15,5,utf8_decode(number_format(0.00,2)),0,0,'R');

          $sql_tcof=_fetch_array(_query("SELECT SUM(factura.retencion) AS retencion FROM factura WHERE factura.fecha='$row[fecha]' AND factura.tipo_documento='COF' AND factura.id_sucursal=$id_sucursal AND factura.anulada=0"));
          $pdf->Cell(15,5,utf8_decode(number_format(round($sql_tcof['retencion'],2),2)),0,1,'R');
          $total_retencion=$total_retencion+$sql_tcof['retencion'];

          $c++;

          if ($c==44) {
                // code...
            $pdf->Cell(75,5,utf8_decode("PASAN: "),"T",0,'R');
            $pdf->Cell(20,5,utf8_decode(number_format(0.00,2)),"T",0,'R');
            $pdf->Cell(20,5,utf8_decode(number_format(0.00,2)),"T",0,'R');
            $pdf->Cell(20,5,utf8_decode(number_format($total_ventas_internas_gravadas,2)),"T",0,'R');
            $pdf->Cell(20,5,utf8_decode(number_format(0.00,2)),"T",0,'R');
            $pdf->Cell(20,5,utf8_decode(number_format($total_ventas_internas_gravadas,2)),"T",0,'R');
            $pdf->Cell(15,5,utf8_decode(number_format(0.00,2)),"T",0,'R');
            $pdf->Cell(15,5,utf8_decode(number_format($total_retencion,2)),"T",1,'R');
          }

          if ($c==44&&$pa==1) {
                # code...
            $pdf->addPage();
            $set_x=0;
            $set_y=10;

            $pa++;
            $c=1;

            $set_x = 5;

            $pdf->SetFont('Arial','',6);
            $pdf->SetXY($set_x, $set_y);

            $pdf->SetFont('Arial','',6);
            $pdf->Cell(15,7,utf8_decode("FECHA"),"TLR",1,'C');
            $set_x = $pdf-> GetX();
            $set_y = $pdf-> GetY();
            $pdf->SetXY($set_x,$set_y);
            $pdf->Cell(15,8,utf8_decode("DE EMISION"),"BLR",0,'C');

            $set_y=$set_y-7;
            $set_x = $pdf-> GetX();
            $pdf->SetXY($set_x, $set_y);
            $pdf->Cell(10,15,utf8_decode("TIPO"),1,0,'C');

            $set_x = $pdf-> GetX();
            $pdf->SetXY($set_x, $set_y);
            $pdf->Cell(15,15,utf8_decode("DEL Nº."),1,0,'C');

            $set_x = $pdf-> GetX();
            $pdf->SetXY($set_x, $set_y);
            $set_x = $pdf-> GetX();
            $pdf->Cell(15,15,utf8_decode("AL Nº."),1,0,'C');

            $set_x = $pdf-> GetX();
            $pdf->SetXY($set_x, $set_y);
            $pdf->Cell(20,3,utf8_decode("NUMERO DE"),"TLR",1,'C');
            $pdf->SetX($set_x);
            $pdf->Cell(20,4,utf8_decode("MAQUINA O"),"LR",1,'C');
            $pdf->SetX($set_x);
            $pdf->Cell(20,4,utf8_decode("CAJA"),"LR",1,'C');
            $pdf->SetX($set_x);
            $pdf->Cell(20,4,utf8_decode("REGISTRADORA"),"LBR",0,'C');

            $set_x = $pdf-> GetX();
            $pdf->SetXY($set_x, $set_y);
            $pdf->Cell(100,5,utf8_decode("VENTAS POR CUENTA PROPIA"),1,1  ,'C');
            $pdf->SetX($set_x);
            $pdf->Cell(20,5,utf8_decode("VENTAS"),"LR",1,'C');
            $pdf->SetX($set_x);
            $pdf->Cell(20,5,utf8_decode("NO SUJETAS"),"BLR",0 ,'C');

            $set_x = $pdf-> GetX();
            $pdf->SetXY($set_x,$pdf->GetY()-5);
            $pdf->Cell(20,5,utf8_decode("VENTAS"),"LR",1,'C');
            $pdf->SetX($set_x);
            $pdf->Cell(20,5,utf8_decode("EXENTAS"),"BLR",0 ,'C');

            $set_x = $pdf-> GetX();
            $pdf->SetXY($set_x,$pdf->GetY()-5);
            $pdf->Cell(20,3,utf8_decode("VENTAS"),"LTR",1,'C');
            $pdf->SetX($set_x);
            $pdf->Cell(20,3,utf8_decode("INTERNAS"),"LR",1,'C');
            $pdf->SetX($set_x);
            $pdf->Cell(20,4,utf8_decode("GRABADAS"),"BLR",0,'C');
            $set_x = $pdf-> GetX();
            $pdf->SetXY($set_x,$pdf->GetY()-6);
            $pdf->Cell(20,10,utf8_decode("EXPORTACIONES"),1,0,'C');

            $set_x = $pdf-> GetX();
            $pdf->SetX($set_x);
            $pdf->Cell(20,5,utf8_decode("VENTAS"),"TLR",1,'C');
            $pdf->SetX($set_x);
            $pdf->Cell(20,5,utf8_decode("TOTALES"),"BLR",0,'C');



            $set_x = $pdf-> GetX();
            $pdf->SetXY($set_x, $set_y);
            $pdf->Cell(15,5,utf8_decode("VENTAS POR"),"TLR",1,'C');
            $pdf->SetX($set_x);
            $pdf->Cell(15,5,utf8_decode("CUENTA DE"),"RL",1,'C');
            $pdf->SetX($set_x);
            $pdf->Cell(15,5,utf8_decode("TERCEROS"),"LBR",0,'C');

            $set_x = $pdf-> GetX();
            $pdf->SetXY($set_x, $set_y);
            $pdf->Cell(15,7,utf8_decode("1% DE"),"LTR",1,'C');
            $pdf->SetX($set_x);
            $pdf->Cell(15,8,utf8_decode("RETENCIÓN"),"LBR",1,'C');

            $pdf->Cell(75,5,utf8_decode("VIENEN: "),"T",0,'R');
            $pdf->Cell(20,5,utf8_decode(number_format(0.00,2)),"T",0,'R');
            $pdf->Cell(20,5,utf8_decode(number_format(0.00,2)),"T",0,'R');
            $pdf->Cell(20,5,utf8_decode(number_format($total_ventas_internas_gravadas,2)),"T",0,'R');
            $pdf->Cell(20,5,utf8_decode(number_format(0.00,2)),"T",0,'R');
            $pdf->Cell(20,5,utf8_decode(number_format($total_ventas_internas_gravadas,2)),"T",0,'R');
            $pdf->Cell(15,5,utf8_decode(number_format(0.00,2)),"T",0,'R');
            $pdf->Cell(15,5,utf8_decode(number_format($total_retencion,2)),"T",1,'R');
            $c++;

          }
          else {
                # code...
            if ($c==44&&$pa>1) {
                  # code...
              $pdf->addPage();
              $set_x=0;

              $pa++;
              $c=1;

              $set_x = 5;
              $set_y = 10;

              $pdf->SetFont('Arial','',6);
              $pdf->SetXY($set_x, $set_y);

              $pdf->SetFont('Arial','',6);
              $pdf->Cell(15,7,utf8_decode("FECHA"),"TLR",1,'C');
              $set_x = $pdf-> GetX();
              $set_y = $pdf-> GetY();
              $pdf->SetXY($set_x,$set_y);
              $pdf->Cell(15,8,utf8_decode("DE EMISION"),"BLR",0,'C');

              $set_y=$set_y-7;
              $set_x = $pdf-> GetX();
              $pdf->SetXY($set_x, $set_y);
              $pdf->Cell(10,15,utf8_decode("TIPO"),1,0,'C');

              $set_x = $pdf-> GetX();
              $pdf->SetXY($set_x, $set_y);
              $pdf->Cell(15,15,utf8_decode("DEL Nº."),1,0,'C');

              $set_x = $pdf-> GetX();
              $pdf->SetXY($set_x, $set_y);
              $set_x = $pdf-> GetX();
              $pdf->Cell(15,15,utf8_decode("AL Nº."),1,0,'C');

              $set_x = $pdf-> GetX();
              $pdf->SetXY($set_x, $set_y);
              $pdf->Cell(20,3,utf8_decode("NUMERO DE"),"TLR",1,'C');
              $pdf->SetX($set_x);
              $pdf->Cell(20,4,utf8_decode("MAQUINA O"),"LR",1,'C');
              $pdf->SetX($set_x);
              $pdf->Cell(20,4,utf8_decode("CAJA"),"LR",1,'C');
              $pdf->SetX($set_x);
              $pdf->Cell(20,4,utf8_decode("REGISTRADORA"),"LBR",0,'C');

              $set_x = $pdf-> GetX();
              $pdf->SetXY($set_x, $set_y);
              $pdf->Cell(100,5,utf8_decode("VENTAS POR CUENTA PROPIA"),1,1  ,'C');
              $pdf->SetX($set_x);
              $pdf->Cell(20,5,utf8_decode("VENTAS"),"LR",1,'C');
              $pdf->SetX($set_x);
              $pdf->Cell(20,5,utf8_decode("NO SUJETAS"),"BLR",0 ,'C');

              $set_x = $pdf-> GetX();
              $pdf->SetXY($set_x,$pdf->GetY()-5);
              $pdf->Cell(20,5,utf8_decode("VENTAS"),"LR",1,'C');
              $pdf->SetX($set_x);
              $pdf->Cell(20,5,utf8_decode("EXENTAS"),"BLR",0 ,'C');

              $set_x = $pdf-> GetX();
              $pdf->SetXY($set_x,$pdf->GetY()-5);
              $pdf->Cell(20,3,utf8_decode("VENTAS"),"LTR",1,'C');
              $pdf->SetX($set_x);
              $pdf->Cell(20,3,utf8_decode("INTERNAS"),"LR",1,'C');
              $pdf->SetX($set_x);
              $pdf->Cell(20,4,utf8_decode("GRABADAS"),"BLR",0,'C');
              $set_x = $pdf-> GetX();
              $pdf->SetXY($set_x,$pdf->GetY()-6);
              $pdf->Cell(20,10,utf8_decode("EXPORTACIONES"),1,0,'C');

              $set_x = $pdf-> GetX();
              $pdf->SetX($set_x);
              $pdf->Cell(20,5,utf8_decode("VENTAS"),"TLR",1,'C');
              $pdf->SetX($set_x);
              $pdf->Cell(20,5,utf8_decode("TOTALES"),"BLR",0,'C');



              $set_x = $pdf-> GetX();
              $pdf->SetXY($set_x, $set_y);
              $pdf->Cell(15,5,utf8_decode("VENTAS POR"),"TLR",1,'C');
              $pdf->SetX($set_x);
              $pdf->Cell(15,5,utf8_decode("CUENTA DE"),"RL",1,'C');
              $pdf->SetX($set_x);
              $pdf->Cell(15,5,utf8_decode("TERCEROS"),"LBR",0,'C');

              $set_x = $pdf-> GetX();
              $pdf->SetXY($set_x, $set_y);
              $pdf->Cell(15,7,utf8_decode("1% DE"),"LTR",1,'C');
              $pdf->SetX($set_x);
              $pdf->Cell(15,8,utf8_decode("RETENCIÓN"),"LBR",1,'C');

              $pdf->Cell(75,5,utf8_decode("VIENEN: "),"T",0,'R');
              $pdf->Cell(20,5,utf8_decode(number_format(0.00,2)),"T",0,'R');
              $pdf->Cell(20,5,utf8_decode(number_format(0.00,2)),"T",0,'R');
              $pdf->Cell(20,5,utf8_decode(number_format($total_ventas_internas_gravadas,2)),"T",0,'R');
              $pdf->Cell(20,5,utf8_decode(number_format(0.00,2)),"T",0,'R');
              $pdf->Cell(20,5,utf8_decode(number_format($total_ventas_internas_gravadas,2)),"T",0,'R');
              $pdf->Cell(15,5,utf8_decode(number_format(0.00,2)),"T",0,'R');
              $pdf->Cell(15,5,utf8_decode(number_format($total_retencion,2)),"T",1,'R');
              $c++;

            }

          }
        }


      }

      $sql_nc=_query("SELECT DISTINCT factura.caja FROM factura WHERE factura.fecha='$row[fecha]' AND factura.id_sucursal=$id_sucursal");
      $nrsqlnc=_num_rows($sql_nc);

      if ($nrsqlnc>0) {
        while ($rnc=_fetch_array($sql_nc)) {
              # code...

          $sql_min_max = _query("SELECT MIN(CONVERT(num_fact_impresa,UNSIGNED INTEGER)) as minimo, MAX(CONVERT(num_fact_impresa,UNSIGNED INTEGER)) as maximo FROM factura WHERE  numero_doc LIKE '%TIK%' AND id_sucursal = '$id_sucursal' AND fecha = '$row[fecha]' AND caja=$rnc[caja]");
          $nrowstik=_num_rows($sql_min_max);
          if ($nrowstik>0) {
                # code...
            $rowt2=_fetch_array($sql_min_max);
            if ($rowt2['minimo']!=""&&$rowt2['maximo']!="") {
                  # code...
              $pdf->Cell(15,5,utf8_decode(ED($row['fecha'])),0,0,'C');
              $pdf->Cell(10,5,utf8_decode("TIK"),0,0,'C');
              $pdf->Cell(15,5,utf8_decode(str_pad($rowt2['minimo'],10,"0",STR_PAD_LEFT)),0,0,'C');
              $pdf->Cell(15,5,utf8_decode(str_pad($rowt2['maximo'],10,"0",STR_PAD_LEFT)),0,0,'C');
              $pdf->Cell(20,5,utf8_decode($rnc['caja']),0,0,'C');
              $pdf->Cell(20,5,utf8_decode(number_format(0.00,2)),0,0,'R');
              $pdf->Cell(20,5,utf8_decode(number_format(0.00,2)),0,0,'R');

              $sql_tcof=_fetch_array(_query("SELECT SUM(factura.total) AS venta FROM factura WHERE factura.fecha='$row[fecha]' AND factura.tipo_documento='TIK' AND factura.id_sucursal=$id_sucursal AND factura.anulada=0 AND caja=$rnc[caja]"));
              $pdf->Cell(20,5,utf8_decode(number_format($sql_tcof['venta'],2)),0,0,'R');
              $pdf->Cell(20,5,utf8_decode(number_format(0.00,2)),0,0,'R');
              $pdf->Cell(20,5,utf8_decode(number_format($sql_tcof['venta'],2)),0,0,'R');
              $total_ventas_internas_gravadas=$total_ventas_internas_gravadas+$sql_tcof['venta'];
              $pdf->Cell(15,5,utf8_decode(number_format(0.00,2)),0,0,'R');

              $sql_tcof=_fetch_array(_query("SELECT SUM(factura.retencion) AS retencion FROM factura WHERE factura.fecha='$row[fecha]' AND factura.tipo_documento='TIK' AND factura.id_sucursal=$id_sucursal AND factura.anulada=0 AND caja=$rnc[caja]"));
              $pdf->Cell(15,5,utf8_decode(number_format($sql_tcof['retencion'],2)),0,1,'R');
              $total_retencion=$total_retencion+$sql_tcof['retencion'];

              $c++;

              if ($c==44) {
                    // code...
                $pdf->Cell(75,5,utf8_decode("PASAN: "),"T",0,'R');
                $pdf->Cell(20,5,utf8_decode(number_format(0.00,2)),"T",0,'R');
                $pdf->Cell(20,5,utf8_decode(number_format(0.00,2)),"T",0,'R');
                $pdf->Cell(20,5,utf8_decode(number_format($total_ventas_internas_gravadas,2)),"T",0,'R');
                $pdf->Cell(20,5,utf8_decode(number_format(0.00,2)),"T",0,'R');
                $pdf->Cell(20,5,utf8_decode(number_format($total_ventas_internas_gravadas,2)),"T",0,'R');
                $pdf->Cell(15,5,utf8_decode(number_format(0.00,2)),"T",0,'R');
                $pdf->Cell(15,5,utf8_decode(number_format($total_retencion,2)),"T",1,'R');
              }

              if ($c==44&&$pa==1) {
                    # code...
                $pdf->addPage();
                $set_x=0;
                $pa++;
                $c=1;

                $set_x = 5;
                $set_y = 10;
                $pdf->SetFont('Arial','',6);
                $pdf->SetXY($set_x, $set_y);

                $pdf->SetFont('Arial','',6);
                $pdf->Cell(15,7,utf8_decode("FECHA"),"TLR",1,'C');
                $set_x = $pdf-> GetX();
                $set_y = $pdf-> GetY();
                $pdf->SetXY($set_x,$set_y);
                $pdf->Cell(15,8,utf8_decode("DE EMISION"),"BLR",0,'C');

                $set_y=$set_y-7;
                $set_x = $pdf-> GetX();
                $pdf->SetXY($set_x, $set_y);
                $pdf->Cell(10,15,utf8_decode("TIPO"),1,0,'C');

                $set_x = $pdf-> GetX();
                $pdf->SetXY($set_x, $set_y);
                $pdf->Cell(15,15,utf8_decode("DEL Nº."),1,0,'C');

                $set_x = $pdf-> GetX();
                $pdf->SetXY($set_x, $set_y);
                $set_x = $pdf-> GetX();
                $pdf->Cell(15,15,utf8_decode("AL Nº."),1,0,'C');

                $set_x = $pdf-> GetX();
                $pdf->SetXY($set_x, $set_y);
                $pdf->Cell(20,3,utf8_decode("NUMERO DE"),"TLR",1,'C');
                $pdf->SetX($set_x);
                $pdf->Cell(20,4,utf8_decode("MAQUINA O"),"LR",1,'C');
                $pdf->SetX($set_x);
                $pdf->Cell(20,4,utf8_decode("CAJA"),"LR",1,'C');
                $pdf->SetX($set_x);
                $pdf->Cell(20,4,utf8_decode("REGISTRADORA"),"LBR",0,'C');

                $set_x = $pdf-> GetX();
                $pdf->SetXY($set_x, $set_y);
                $pdf->Cell(100,5,utf8_decode("VENTAS POR CUENTA PROPIA"),1,1  ,'C');
                $pdf->SetX($set_x);
                $pdf->Cell(20,5,utf8_decode("VENTAS"),"LR",1,'C');
                $pdf->SetX($set_x);
                $pdf->Cell(20,5,utf8_decode("NO SUJETAS"),"BLR",0 ,'C');

                $set_x = $pdf-> GetX();
                $pdf->SetXY($set_x,$pdf->GetY()-5);
                $pdf->Cell(20,5,utf8_decode("VENTAS"),"LR",1,'C');
                $pdf->SetX($set_x);
                $pdf->Cell(20,5,utf8_decode("EXENTAS"),"BLR",0 ,'C');

                $set_x = $pdf-> GetX();
                $pdf->SetXY($set_x,$pdf->GetY()-5);
                $pdf->Cell(20,3,utf8_decode("VENTAS"),"LTR",1,'C');
                $pdf->SetX($set_x);
                $pdf->Cell(20,3,utf8_decode("INTERNAS"),"LR",1,'C');
                $pdf->SetX($set_x);
                $pdf->Cell(20,4,utf8_decode("GRABADAS"),"BLR",0,'C');
                $set_x = $pdf-> GetX();
                $pdf->SetXY($set_x,$pdf->GetY()-6);
                $pdf->Cell(20,10,utf8_decode("EXPORTACIONES"),1,0,'C');

                $set_x = $pdf-> GetX();
                $pdf->SetX($set_x);
                $pdf->Cell(20,5,utf8_decode("VENTAS"),"TLR",1,'C');
                $pdf->SetX($set_x);
                $pdf->Cell(20,5,utf8_decode("TOTALES"),"BLR",0,'C');



                $set_x = $pdf-> GetX();
                $pdf->SetXY($set_x, $set_y);
                $pdf->Cell(15,5,utf8_decode("VENTAS POR"),"TLR",1,'C');
                $pdf->SetX($set_x);
                $pdf->Cell(15,5,utf8_decode("CUENTA DE"),"RL",1,'C');
                $pdf->SetX($set_x);
                $pdf->Cell(15,5,utf8_decode("TERCEROS"),"LBR",0,'C');

                $set_x = $pdf-> GetX();
                $pdf->SetXY($set_x, $set_y);
                $pdf->Cell(15,7,utf8_decode("1% DE"),"LTR",1,'C');
                $pdf->SetX($set_x);
                $pdf->Cell(15,8,utf8_decode("RETENCIÓN"),"LBR",1,'C');

                $pdf->Cell(75,5,utf8_decode("VIENEN: "),"T",0,'R');
                $pdf->Cell(20,5,utf8_decode(number_format(0.00,2)),"T",0,'R');
                $pdf->Cell(20,5,utf8_decode(number_format(0.00,2)),"T",0,'R');
                $pdf->Cell(20,5,utf8_decode(number_format($total_ventas_internas_gravadas,2)),"T",0,'R');
                $pdf->Cell(20,5,utf8_decode(number_format(0.00,2)),"T",0,'R');
                $pdf->Cell(20,5,utf8_decode(number_format($total_ventas_internas_gravadas,2)),"T",0,'R');
                $pdf->Cell(15,5,utf8_decode(number_format(0.00,2)),"T",0,'R');
                $pdf->Cell(15,5,utf8_decode(number_format($total_retencion,2)),"T",1,'R');
                $c++;

              }
              else {
                    # code...
                if ($c==44&&$pa>1) {
                      # code...
                  $pdf->addPage();
                  $set_x=0;

                  $pa++;
                  $c=1;

                  $set_x = 5;
                  $set_y = 10;

                  $pdf->SetFont('Arial','',6);
                  $pdf->SetXY($set_x, $set_y);

                  $pdf->SetFont('Arial','',6);
                  $pdf->Cell(15,7,utf8_decode("FECHA"),"TLR",1,'C');
                  $set_x = $pdf-> GetX();
                  $set_y = $pdf-> GetY();
                  $pdf->SetXY($set_x,$set_y);
                  $pdf->Cell(15,8,utf8_decode("DE EMISION"),"BLR",0,'C');

                  $set_y=$set_y-7;
                  $set_x = $pdf-> GetX();
                  $pdf->SetXY($set_x, $set_y);
                  $pdf->Cell(10,15,utf8_decode("TIPO"),1,0,'C');

                  $set_x = $pdf-> GetX();
                  $pdf->SetXY($set_x, $set_y);
                  $pdf->Cell(15,15,utf8_decode("DEL Nº."),1,0,'C');

                  $set_x = $pdf-> GetX();
                  $pdf->SetXY($set_x, $set_y);
                  $set_x = $pdf-> GetX();
                  $pdf->Cell(15,15,utf8_decode("AL Nº."),1,0,'C');

                  $set_x = $pdf-> GetX();
                  $pdf->SetXY($set_x, $set_y);
                  $pdf->Cell(20,3,utf8_decode("NUMERO DE"),"TLR",1,'C');
                  $pdf->SetX($set_x);
                  $pdf->Cell(20,4,utf8_decode("MAQUINA O"),"LR",1,'C');
                  $pdf->SetX($set_x);
                  $pdf->Cell(20,4,utf8_decode("CAJA"),"LR",1,'C');
                  $pdf->SetX($set_x);
                  $pdf->Cell(20,4,utf8_decode("REGISTRADORA"),"LBR",0,'C');

                  $set_x = $pdf-> GetX();
                  $pdf->SetXY($set_x, $set_y);
                  $pdf->Cell(100,5,utf8_decode("VENTAS POR CUENTA PROPIA"),1,1  ,'C');
                  $pdf->SetX($set_x);
                  $pdf->Cell(20,5,utf8_decode("VENTAS"),"LR",1,'C');
                  $pdf->SetX($set_x);
                  $pdf->Cell(20,5,utf8_decode("NO SUJETAS"),"BLR",0 ,'C');

                  $set_x = $pdf-> GetX();
                  $pdf->SetXY($set_x,$pdf->GetY()-5);
                  $pdf->Cell(20,5,utf8_decode("VENTAS"),"LR",1,'C');
                  $pdf->SetX($set_x);
                  $pdf->Cell(20,5,utf8_decode("EXENTAS"),"BLR",0 ,'C');

                  $set_x = $pdf-> GetX();
                  $pdf->SetXY($set_x,$pdf->GetY()-5);
                  $pdf->Cell(20,3,utf8_decode("VENTAS"),"LTR",1,'C');
                  $pdf->SetX($set_x);
                  $pdf->Cell(20,3,utf8_decode("INTERNAS"),"LR",1,'C');
                  $pdf->SetX($set_x);
                  $pdf->Cell(20,4,utf8_decode("GRABADAS"),"BLR",0,'C');
                  $set_x = $pdf-> GetX();
                  $pdf->SetXY($set_x,$pdf->GetY()-6);
                  $pdf->Cell(20,10,utf8_decode("EXPORTACIONES"),1,0,'C');

                  $set_x = $pdf-> GetX();
                  $pdf->SetX($set_x);
                  $pdf->Cell(20,5,utf8_decode("VENTAS"),"TLR",1,'C');
                  $pdf->SetX($set_x);
                  $pdf->Cell(20,5,utf8_decode("TOTALES"),"BLR",0,'C');



                  $set_x = $pdf-> GetX();
                  $pdf->SetXY($set_x, $set_y);
                  $pdf->Cell(15,5,utf8_decode("VENTAS POR"),"TLR",1,'C');
                  $pdf->SetX($set_x);
                  $pdf->Cell(15,5,utf8_decode("CUENTA DE"),"RL",1,'C');
                  $pdf->SetX($set_x);
                  $pdf->Cell(15,5,utf8_decode("TERCEROS"),"LBR",0,'C');

                  $set_x = $pdf-> GetX();
                  $pdf->SetXY($set_x, $set_y);
                  $pdf->Cell(15,7,utf8_decode("1% DE"),"LTR",1,'C');
                  $pdf->SetX($set_x);
                  $pdf->Cell(15,8,utf8_decode("RETENCIÓN"),"LBR",1,'C');

                  $pdf->Cell(75,5,utf8_decode("VIENEN: "),"T",0,'R');
                  $pdf->Cell(20,5,utf8_decode(number_format(0.00,2)),"T",0,'R');
                  $pdf->Cell(20,5,utf8_decode(number_format(0.00,2)),"T",0,'R');
                  $pdf->Cell(20,5,utf8_decode(number_format($total_ventas_internas_gravadas,2)),"T",0,'R');
                  $pdf->Cell(20,5,utf8_decode(number_format(0.00,2)),"T",0,'R');
                  $pdf->Cell(20,5,utf8_decode(number_format($total_ventas_internas_gravadas,2)),"T",0,'R');
                  $pdf->Cell(15,5,utf8_decode(number_format(0.00,2)),"T",0,'R');
                  $pdf->Cell(15,5,utf8_decode(number_format($total_retencion,2)),"T",1,'R');
                  $c++;

                }

              }
            }
          }

        }
      }
    }
  }

  $pdf->Cell(75,5,utf8_decode("TOTALES: "),"T",0,'R');
  $pdf->Cell(20,5,utf8_decode(number_format(0.00,2)),"T",0,'R');
  $pdf->Cell(20,5,utf8_decode(number_format(0.00,2)),"T",0,'R');
  $pdf->Cell(20,5,utf8_decode(number_format($total_ventas_internas_gravadas,2)),"T",0,'R');
  $pdf->Cell(20,5,utf8_decode(number_format(0.00,2)),"T",0,'R');
  $pdf->Cell(20,5,utf8_decode(number_format($total_ventas_internas_gravadas,2)),"T",0,'R');
  $pdf->Cell(15,5,utf8_decode(number_format(0.00,2)),"T",0,'R');
  $pdf->Cell(15,5,utf8_decode(number_format($total_retencion,2)),"T",0,'R');



  ob_clean();
  $pdf->Output("libro_consumidores.pdf","I");
