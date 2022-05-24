<?php
error_reporting(E_ERROR | E_PARSE);
require("_core.php");
require("num2letras.php");
require('fpdf/fpdf.php');


$pdf=new fPDF('L','mm', 'Letter');
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

    $title = $nombre_a;
    $titulo = "LIBRO DE COMPRAS";
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
    $impress = "LIBRO DE COMPRAS".$fech;


    $existenas = "";
    if($min>0)
    {
      $existenas = "CANTIDAD: $min";
    }
    //$logo = "img/logo_sys.png";
    $pdf->AddPage();
    $pdf->SetFont('Arial','',10);
    //$pdf->Image($logo,8,4,30,25);
    //Encabezado General
    //Encabezado General
    $set_x=0;
    $set_y=10;
    $pdf->SetFont('Arial','',14);
    $pdf->SetXY($set_x, $set_y);
    $pdf->MultiCell(280,6,$title,0,'C',0);
    $pdf->SetXY($set_x, $set_y+5);
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(280,6,utf8_decode($direccion),0,1,'C');
    $pdf->SetXY($set_x, $set_y+10);
    $pdf->SetFont('Arial','',11);
    $pdf->Cell(280,6,utf8_decode($titulo),0,1,'C');
    $pdf->SetXY($set_x, $set_y+15);
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(280,6,$fech,0,1,'C');

    ///////////////////////////////////////////////////////////////////////

    $set_x = 5;
    $set_y = 35;

    $total_internas_exentas=0;
    $total_internas_gravadas=0;
    $total_credito_fiscal=0;
    $total_retencion=0;
    $total_compras=0;


    $pdf->SetFont('Arial','',6);
    $pdf->SetXY($set_x, $set_y);

    $pdf->Cell(5,10,utf8_decode("Nº"),1,0,'C');

    $set_x = $pdf-> GetX();
    $pdf->Cell(15,5,utf8_decode("FECHA"),"TLR",1,'C');
    $pdf->SetX($set_x);
    $pdf->Cell(15,5,utf8_decode("DE EMISION"),"BLR",0,'C');

    $set_x = $pdf-> GetX();
    $pdf->SetXY($set_x, $set_y);
    $set_x = $pdf-> GetX();
    $pdf->Cell(15,5,utf8_decode("NUMERO DE"),"TLR",1  ,'C');
    $pdf->SetX($set_x);
    $pdf->Cell(15,5,utf8_decode("DOCUMENTO"),"BLR",0,'C');
    $set_x = $pdf-> GetX();
    $pdf->SetXY($set_x, $set_y);
    $pdf->Cell(15,10,utf8_decode("NRC"),1,0,'C');

    $set_x = $pdf-> GetX();
    $pdf->Cell(20,3,utf8_decode("NIT O DUI"),"TLR",1  ,'C');
    $pdf->SetX($set_x);
    $pdf->Cell(20,3,utf8_decode("DE SUJETO"),"LR",1,'C');
    $pdf->SetX($set_x);
    $pdf->Cell(20,4,utf8_decode("EXCLUIDO"),"BLR",0,'C');

    $set_x = $pdf-> GetX();
    $pdf->SetXY($set_x, $set_y);
    $pdf->Cell(50,10,utf8_decode("NOMBRE DEL PROVEEDOR"),1,0,'C');

    $set_x = $pdf-> GetX();
    $pdf->Cell(40,3,utf8_decode("COMPRAS EXENTAS"),1,1  ,'C');
    $pdf->SetX($set_x);
    $pdf->Cell(15,7,utf8_decode("INTERNAS"),1,0,'C');
    $set_x = $pdf-> GetX();
    $pdf->SetX($set_x);
    $pdf->Cell(25,3,utf8_decode("IMPORTACIONES"),"LR",1,'C');
    $pdf->SetX($set_x);
    $pdf->Cell(25,4,utf8_decode("E INTERNACIONALES"),"BLR",0,'C');

    $set_x = $pdf-> GetX();
    $pdf->SetXY($set_x, $set_y);
    $pdf->Cell(55,3,utf8_decode("COMPRAS GRAVADAS"),1,1  ,'C');
    $pdf->SetX($set_x);
    $pdf->Cell(15,7,utf8_decode("INTERNAS"),1,0,'C');
    $set_x = $pdf-> GetX();
    $pdf->SetX($set_x);
    $pdf->Cell(25,3,utf8_decode("IMPORTACIONES"),"LR",1,'C');
    $pdf->SetX($set_x);
    $pdf->Cell(25,4,utf8_decode("E INTERNACIONALES"),"BLR",0,'C');
    $set_x = $pdf-> GetX();
    $pdf->SetXY($set_x,$pdf->GetY()-3);
    $pdf->Cell(15,3,utf8_decode("CREDITO"),"LTR",1,'C');
    $pdf->SetX($set_x);
    $pdf->Cell(15,4,utf8_decode("FISCAL"),"BLR",0,'C');

    $set_x = $pdf-> GetX();
    $pdf->SetXY($set_x, $set_y);
    $pdf->Cell(10,3,utf8_decode("RET"),"TLR",1,'C');
    $pdf->SetX($set_x);
    $pdf->Cell(10,3,utf8_decode("1%"),"LR",1,'C');
    $pdf->SetX($set_x);
    $pdf->Cell(10,4,utf8_decode("Y 2%"),"LBR",0,'C');

    $set_x = $pdf-> GetX();
    $pdf->SetXY($set_x, $set_y);
    $pdf->Cell(15,5,utf8_decode("TOTAL"),"LTR",1,'C');
    $pdf->SetX($set_x);
    $pdf->Cell(15,5,utf8_decode("COMPRAS"),"LBR",0,'C');

    $set_x = $pdf-> GetX();
    $pdf->SetXY($set_x, $set_y);
    $pdf->Cell(15,3,utf8_decode("IMPUESTO"),"LTR",1,'C');
    $pdf->SetX($set_x);
    $pdf->Cell(15,3,utf8_decode("RETENIDO A"),"LR",1,'C');
    $pdf->SetX($set_x);
    $pdf->Cell(15,4,utf8_decode("TERCEROS"),"LBR",0,'C');

    $set_x = $pdf-> GetX();
    $pdf->SetXY($set_x, $set_y);
    $pdf->Cell(15,3,utf8_decode("COMPRAS"),"LTR",1,'C');
    $pdf->SetX($set_x);
    $pdf->Cell(15,3,utf8_decode("A SUJETOS"),"LR",1,'C');
    $pdf->SetX($set_x);
    $pdf->Cell(15,4,utf8_decode("EXCLUIDOS"),"LBR",1,'C');

    $sql =_query("SELECT compra.id_compra,compra.fecha,compra.total_percepcion,compra.numero_doc,proveedor.nrc,proveedor.nombre,compra.iva,compra.total FROM compra JOIN proveedor ON proveedor.id_proveedor=compra.id_proveedor WHERE compra.fecha BETWEEN '$fini' AND '$fin' AND compra.id_sucursal=$id_sucursal ORDER BY compra.fecha ASC ");
    $nrows=_num_rows($sql);
    $i=1;
    $pa=1;
    $c=1;
    if ($nrows>0) {
      # code...

        # code...
        $pasa = 0;

      while ($row=_fetch_array($sql)) {
        # code...
        if ($c==32&&$pa==1)
        {
            # code...

          $pdf->addPage();

          $set_x=0;
          $set_y=10;
          /*$pdf->SetFont('Arial','',12);
          $pdf->SetXY($set_x, $set_y);
          $pdf->MultiCell(280,6,$title,0,'C',0);
          $pdf->SetFont('Arial','',10);
          $pdf->SetXY($set_x, $set_y+6);
          $pdf->Cell(280,6,$direccion,0,1,'C');
          $pdf->SetXY($set_x, $set_y+11);
          $pdf->Cell(280,6,$telefonos,0,1,'C');
          $pdf->SetXY($set_x, $set_y+16);
          $pdf->Cell(280,6,"NIT: ".$nit." NRC: ".$nrc,0,1,'C');
          $pdf->SetXY($set_x, $set_y+21);
          $pdf->Cell(280,6,utf8_decode($titulo),0,1,'C');
          $pdf->SetXY($set_x, $set_y+26);
          $pdf->Cell(280,6,$fech,0,1,'C');

            ///////////////////////////////////////////////////////////////////////

          $set_y = 40;*/
          $set_x = 5;
          $pdf->SetFont('Arial','',6);
          $pdf->SetXY($set_x, $set_y);

          $pa++;
          $c=1;
          $pdf->Cell(5,10,utf8_decode("Nº"),1,0,'C');
          $set_y=$pdf->GetY();
          $set_x = $pdf-> GetX();
          $pdf->Cell(15,5,utf8_decode("FECHA"),"TLR",1,'C');
          $pdf->SetX($set_x);
          $pdf->Cell(15,5,utf8_decode("DE EMISION"),"BLR",0,'C');
          $set_x = $pdf-> GetX();
          $pdf->SetXY($set_x, $set_y);
          $set_x = $pdf-> GetX();
          $pdf->Cell(15,5,utf8_decode("NUMERO DE"),"TLR",1  ,'C');
          $pdf->SetX($set_x);
          $pdf->Cell(15,5,utf8_decode("DOCUMENTO"),"BLR",0,'C');
          $set_x = $pdf-> GetX();
          $pdf->SetXY($set_x, $set_y);
          $pdf->Cell(15,10,utf8_decode("NRC"),1,0,'C');

          $set_x = $pdf-> GetX();
          $pdf->Cell(20,3,utf8_decode("NIT O DUI"),"TLR",1  ,'C');
          $pdf->SetX($set_x);
          $pdf->Cell(20,3,utf8_decode("DE SUJETO"),"LR",1,'C');
          $pdf->SetX($set_x);
          $pdf->Cell(20,4,utf8_decode("EXCLUIDO"),"BLR",0,'C');

          $set_x = $pdf-> GetX();
          $pdf->SetXY($set_x, $set_y);
          $pdf->Cell(50,10,utf8_decode("NOMBRE DEL PROVEEDOR"),1,0,'C');

          $set_x = $pdf-> GetX();
          $pdf->Cell(40,3,utf8_decode("COMPRAS EXENTAS"),1,1  ,'C');
          $pdf->SetX($set_x);
          $pdf->Cell(15,7,utf8_decode("INTERNAS"),1,0,'C');
          $set_x = $pdf-> GetX();
          $pdf->SetX($set_x);
          $pdf->Cell(25,3,utf8_decode("IMPORTACIONES"),"LR",1,'C');
          $pdf->SetX($set_x);
          $pdf->Cell(25,4,utf8_decode("E INTERNACIONALES"),"BLR",0,'C');

          $set_x = $pdf-> GetX();
          $pdf->SetXY($set_x, $set_y);
          $pdf->Cell(55,3,utf8_decode("COMPRAS GRAVADAS"),1,1  ,'C');
          $pdf->SetX($set_x);
          $pdf->Cell(15,7,utf8_decode("INTERNAS"),1,0,'C');
          $set_x = $pdf-> GetX();
          $pdf->SetX($set_x);
          $pdf->Cell(25,3,utf8_decode("IMPORTACIONES"),"LR",1,'C');
          $pdf->SetX($set_x);
          $pdf->Cell(25,4,utf8_decode("E INTERNACIONALES"),"BLR",0,'C');
          $set_x = $pdf-> GetX();
          $pdf->SetXY($set_x,$pdf->GetY()-3);
          $pdf->Cell(15,3,utf8_decode("CREDITO"),"LTR",1,'C');
          $pdf->SetX($set_x);
          $pdf->Cell(15,4,utf8_decode("FISCAL"),"BLR",0,'C');

          $set_x = $pdf-> GetX();
          $pdf->SetXY($set_x, $set_y);
          $pdf->Cell(10,3,utf8_decode("RET"),"TLR",1,'C');
          $pdf->SetX($set_x);
          $pdf->Cell(10,3,utf8_decode("1%"),"LR",1,'C');
          $pdf->SetX($set_x);
          $pdf->Cell(10,4,utf8_decode("Y 2%"),"LBR",0,'C');

          $set_x = $pdf-> GetX();
          $pdf->SetXY($set_x, $set_y);
          $pdf->Cell(15,5,utf8_decode("TOTAL"),"LTR",1,'C');
          $pdf->SetX($set_x);
          $pdf->Cell(15,5,utf8_decode("COMPRAS"),"LBR",0,'C');

          $set_x = $pdf-> GetX();
          $pdf->SetXY($set_x, $set_y);
          $pdf->Cell(15,3,utf8_decode("IMPUESTO"),"LTR",1,'C');
          $pdf->SetX($set_x);
          $pdf->Cell(15,3,utf8_decode("RETENIDO A"),"LR",1,'C');
          $pdf->SetX($set_x);
          $pdf->Cell(15,4,utf8_decode("TERCEROS"),"LBR",0,'C');

          $set_x = $pdf-> GetX();
          $pdf->SetXY($set_x, $set_y);
          $pdf->Cell(15,3,utf8_decode("COMPRAS"),"LTR",1,'C');
          $pdf->SetX($set_x);
          $pdf->Cell(15,3,utf8_decode("A SUJETOS"),"LR",1,'C');
          $pdf->SetX($set_x);
          $pdf->Cell(15,4,utf8_decode("EXCLUIDOS"),"LBR",1,'C');

          $pdf->Cell(120,5,utf8_decode("VIENEN: "),"T",0,'R');
          $pdf->Cell(15,5,utf8_decode(number_format($total_internas_exentas,2)),"T",0,'R');/*exentas internas*/
          $pdf->Cell(25,5,utf8_decode(number_format(0.00,2)),"T",0,'R');/*no*/
          $pdf->Cell(15,5,utf8_decode(number_format($total_internas_gravadas,2)),"T",0,'R');/*Internas gravadas*/
          $pdf->Cell(25,5,utf8_decode(number_format(0.00,2)),"T",0,'R');/*no*/
          $pdf->Cell(15,5,utf8_decode(number_format($total_credito_fiscal,2)),"T",0,'R');/*credito  fiscal*/
          $pdf->Cell(10,5,utf8_decode(number_format($total_retencion,2)),"T",0,'R');/*total retencion*/

          $pdf->Cell(15,5,utf8_decode(number_format($total_compras,2)),"T",0,'R');/*total compras*/
          $pdf->Cell(15,5,utf8_decode(number_format(0.00,2)),"T",0,'R');/*impuesto retenido a terceros*/
          $pdf->Cell(15,5,utf8_decode(number_format(0.00,2)),"T",1,'R');/**/

          $c++;
          $pasa = 1;
        }
        else {
          if ($c==37&&$pa>1) {
              # code...
            $pasa = 1;
            $pdf->addPage();

            $set_x=0;
            $set_y=10;
            /*$pdf->SetFont('Arial','',12);
            $pdf->SetXY($set_x, $set_y);
            $pdf->MultiCell(280,6,$title,0,'C',0);
            $pdf->SetFont('Arial','',10);
            $pdf->SetXY($set_x, $set_y+6);
            $pdf->Cell(280,6,$direccion,0,1,'C');
            $pdf->SetXY($set_x, $set_y+11);
            $pdf->Cell(280,6,$telefonos,0,1,'C');
            $pdf->SetXY($set_x, $set_y+16);
            $pdf->Cell(280,6,"NIT: ".$nit." NRC: ".$nrc,0,1,'C');
            $pdf->SetXY($set_x, $set_y+21);
            $pdf->Cell(280,6,utf8_decode($titulo),0,1,'C');
            $pdf->SetXY($set_x, $set_y+26);
            $pdf->Cell(280,6,$fech,0,1,'C');

              ///////////////////////////////////////////////////////////////////////

            $set_y = 40;*/
            $set_x = 5;
            $pdf->SetFont('Arial','',6);
            $pdf->SetXY($set_x, $set_y);

            $c=1;
            $pdf->Cell(5,10,utf8_decode("Nº"),1,0,'C');
            $set_y=$pdf->GetY();
            $set_x = $pdf-> GetX();
            $pdf->Cell(15,5,utf8_decode("FECHA"),"TLR",1,'C');
            $pdf->SetX($set_x);
            $pdf->Cell(15,5,utf8_decode("DE EMISION"),"BLR",0,'C');
            $set_x = $pdf-> GetX();
            $pdf->SetXY($set_x, $set_y);
            $set_x = $pdf-> GetX();
            $pdf->Cell(15,5,utf8_decode("NUMERO DE"),"TLR",1  ,'C');
            $pdf->SetX($set_x);
            $pdf->Cell(15,5,utf8_decode("DOCUMENTO"),"BLR",0,'C');
            $set_x = $pdf-> GetX();
            $pdf->SetXY($set_x, $set_y);
            $pdf->Cell(15,10,utf8_decode("NRC"),1,0,'C');

            $set_x = $pdf-> GetX();
            $pdf->Cell(20,3,utf8_decode("NIT O DUI"),"TLR",1  ,'C');
            $pdf->SetX($set_x);
            $pdf->Cell(20,3,utf8_decode("DE SUJETO"),"LR",1,'C');
            $pdf->SetX($set_x);
            $pdf->Cell(20,4,utf8_decode("EXCLUIDO"),"BLR",0,'C');

            $set_x = $pdf-> GetX();
            $pdf->SetXY($set_x, $set_y);
            $pdf->Cell(50,10,utf8_decode("NOMBRE DEL PROVEEDOR"),1,0,'C');

            $set_x = $pdf-> GetX();
            $pdf->Cell(40,3,utf8_decode("COMPRAS EXENTAS"),1,1  ,'C');
            $pdf->SetX($set_x);
            $pdf->Cell(15,7,utf8_decode("INTERNAS"),1,0,'C');
            $set_x = $pdf-> GetX();
            $pdf->SetX($set_x);
            $pdf->Cell(25,3,utf8_decode("IMPORTACIONES"),"LR",1,'C');
            $pdf->SetX($set_x);
            $pdf->Cell(25,4,utf8_decode("E INTERNACIONALES"),"BLR",0,'C');

            $set_x = $pdf-> GetX();
            $pdf->SetXY($set_x, $set_y);
            $pdf->Cell(55,3,utf8_decode("COMPRAS GRAVADAS"),1,1  ,'C');
            $pdf->SetX($set_x);
            $pdf->Cell(15,7,utf8_decode("INTERNAS"),1,0,'C');
            $set_x = $pdf-> GetX();
            $pdf->SetX($set_x);
            $pdf->Cell(25,3,utf8_decode("IMPORTACIONES"),"LR",1,'C');
            $pdf->SetX($set_x);
            $pdf->Cell(25,4,utf8_decode("E INTERNACIONALES"),"BLR",0,'C');
            $set_x = $pdf-> GetX();
            $pdf->SetXY($set_x,$pdf->GetY()-3);
            $pdf->Cell(15,3,utf8_decode("CREDITO"),"LTR",1,'C');
            $pdf->SetX($set_x);
            $pdf->Cell(15,4,utf8_decode("FISCAL"),"BLR",0,'C');

            $set_x = $pdf-> GetX();
            $pdf->SetXY($set_x, $set_y);
            $pdf->Cell(10,3,utf8_decode("RET"),"TLR",1,'C');
            $pdf->SetX($set_x);
            $pdf->Cell(10,3,utf8_decode("1%"),"LR",1,'C');
            $pdf->SetX($set_x);
            $pdf->Cell(10,4,utf8_decode("Y 2%"),"LBR",0,'C');

            $set_x = $pdf-> GetX();
            $pdf->SetXY($set_x, $set_y);
            $pdf->Cell(15,5,utf8_decode("TOTAL"),"LTR",1,'C');
            $pdf->SetX($set_x);
            $pdf->Cell(15,5,utf8_decode("COMPRAS"),"LBR",0,'C');

            $set_x = $pdf-> GetX();
            $pdf->SetXY($set_x, $set_y);
            $pdf->Cell(15,3,utf8_decode("IMPUESTO"),"LTR",1,'C');
            $pdf->SetX($set_x);
            $pdf->Cell(15,3,utf8_decode("RETENIDO A"),"LR",1,'C');
            $pdf->SetX($set_x);
            $pdf->Cell(15,4,utf8_decode("TERCEROS"),"LBR",0,'C');

            $set_x = $pdf-> GetX();
            $pdf->SetXY($set_x, $set_y);
            $pdf->Cell(15,3,utf8_decode("COMPRAS"),"LTR",1,'C');
            $pdf->SetX($set_x);
            $pdf->Cell(15,3,utf8_decode("A SUJETOS"),"LR",1,'C');
            $pdf->SetX($set_x);
            $pdf->Cell(15,4,utf8_decode("EXCLUIDOS"),"LBR",1,'C');

            $pdf->Cell(120,5,utf8_decode("VIENEN: "),"T",0,'R');
            $pdf->Cell(15,5,utf8_decode(number_format($total_internas_exentas,2)),"T",0,'R');/*exentas internas*/
            $pdf->Cell(25,5,utf8_decode(number_format(0.00,2)),"T",0,'R');/*no*/
            $pdf->Cell(15,5,utf8_decode(number_format($total_internas_gravadas,2)),"T",0,'R');/*Internas gravadas*/
            $pdf->Cell(25,5,utf8_decode(number_format(0.00,2)),"T",0,'R');/*no*/
            $pdf->Cell(15,5,utf8_decode(number_format($total_credito_fiscal,2)),"T",0,'R');/*credito  fiscal*/
            $pdf->Cell(10,5,utf8_decode(number_format($total_retencion,2)),"T",0,'R');/*total retencion*/

            $pdf->Cell(15,5,utf8_decode(number_format($total_compras,2)),"T",0,'R');/*total compras*/
            $pdf->Cell(15,5,utf8_decode(number_format(0.00,2)),"T",0,'R');/*impuesto retenido a terceros*/
            $pdf->Cell(15,5,utf8_decode(number_format(0.00,2)),"T",1,'R');/**/

            $c++;
          }
        }
        $pdf->Cell(5,5,utf8_decode($i),0,0,'C');
        $pdf->Cell(15,5,utf8_decode(ED($row['fecha'])),0,0,'C');
        $pdf->Cell(15,5,utf8_decode($row['numero_doc']),0,0,'C');
        $pdf->Cell(15,5,utf8_decode($row['nrc']),0,0,'C');
        $pdf->Cell(20,5,utf8_decode(""),0,0,'C');
        $pdf->Cell(50,5,utf8_decode($row['nombre']),0,0,'L');

        $sql_exento = _fetch_array(_query("SELECT SUM(detalle_compra.subtotal) as total FROM detalle_compra WHERE id_compra=$row[id_compra] AND detalle_compra.exento=1"));
        $num=$sql_exento['total'];
        $total_internas_exentas=$total_internas_exentas+$num;


        $pdf->Cell(15,5,utf8_decode(number_format($num,2)),0,0,'R');
        $pdf->Cell(25,5,utf8_decode(number_format(0.00,2)),0,0,'R');

        $sql_exento = _fetch_array(_query("SELECT SUM(detalle_compra.subtotal) as total FROM detalle_compra WHERE id_compra=$row[id_compra] AND detalle_compra.exento=0"));
        $num=$sql_exento['total'];
        $total_internas_gravadas=$total_internas_gravadas+$num;

        $pdf->Cell(15,5,utf8_decode(number_format($num,2)),0,0,'R');
        $pdf->Cell(25,5,utf8_decode(number_format(0.00,2)),0,0,'R');
        $pdf->Cell(15,5,utf8_decode(number_format($row['iva'],2)),0,0,'R');

        $total_credito_fiscal=$total_credito_fiscal+$row['iva'];

        $pdf->Cell(10,5,utf8_decode(number_format($row['total_percepcion'],2)),0,0,'R');
        $total_retencion=$total_retencion+$row['total_percepcion'];

        $pdf->Cell(15,5,utf8_decode(number_format($row['total'],2)),0,0,'R');
        $total_compras=$total_compras+$row['total'];

        $pdf->Cell(15,5,utf8_decode(number_format(0.00,2)),0,0,'R');
        $pdf->Cell(15,5,utf8_decode(number_format(0.00,2)),0,1,'R');
        $i++;
        $c++;

        if ($c==32 && $pasa==0)
        {
          // code...
          $pdf->Cell(120,5,utf8_decode("PASAN: "),"T",0,'R');
          $pdf->Cell(15,5,utf8_decode(number_format($total_internas_exentas,2)),"T",0,'R');/*exentas internas*/
          $pdf->Cell(25,5,utf8_decode(number_format(0.00,2)),"T",0,'R');/*no*/
          $pdf->Cell(15,5,utf8_decode(number_format($total_internas_gravadas,2)),"T",0,'R');/*Internas gravadas*/
          $pdf->Cell(25,5,utf8_decode(number_format(0.00,2)),"T",0,'R');/*no*/
          $pdf->Cell(15,5,utf8_decode(number_format($total_credito_fiscal,2)),"T",0,'R');/*credito  fiscal*/
          $pdf->Cell(10,5,utf8_decode(number_format($total_retencion,2)),"T",0,'R');/*total retencion*/

          $pdf->Cell(15,5,utf8_decode(number_format($total_compras,2)),"T",0,'R');/*total compras*/
          $pdf->Cell(15,5,utf8_decode(number_format(0.00,2)),"T",0,'R');/*impuesto retenido a terceros*/
          $pdf->Cell(15,5,utf8_decode(number_format(0.00,2)),"T",1,'R');/**/
        }
        if ($c==37)
        {
          // code...
          $pdf->Cell(120,5,utf8_decode("PASAN: "),"T",0,'R');
          $pdf->Cell(15,5,utf8_decode(number_format($total_internas_exentas,2)),"T",0,'R');/*exentas internas*/
          $pdf->Cell(25,5,utf8_decode(number_format(0.00,2)),"T",0,'R');/*no*/
          $pdf->Cell(15,5,utf8_decode(number_format($total_internas_gravadas,2)),"T",0,'R');/*Internas gravadas*/
          $pdf->Cell(25,5,utf8_decode(number_format(0.00,2)),"T",0,'R');/*no*/
          $pdf->Cell(15,5,utf8_decode(number_format($total_credito_fiscal,2)),"T",0,'R');/*credito  fiscal*/
          $pdf->Cell(10,5,utf8_decode(number_format($total_retencion,2)),"T",0,'R');/*total retencion*/

          $pdf->Cell(15,5,utf8_decode(number_format($total_compras,2)),"T",0,'R');/*total compras*/
          $pdf->Cell(15,5,utf8_decode(number_format(0.00,2)),"T",0,'R');/*impuesto retenido a terceros*/
          $pdf->Cell(15,5,utf8_decode(number_format(0.00,2)),"T",1,'R');/**/
        }


      }/*aca acaba el while*/


    }

    $pdf->Cell(120,5,utf8_decode("TOTALES: "),"T",0,'R');
    $pdf->Cell(15,5,utf8_decode(number_format($total_internas_exentas,2)),"T",0,'R');/*exentas internas*/
    $pdf->Cell(25,5,utf8_decode(number_format(0.00,2)),"T",0,'R');/*no*/
    $pdf->Cell(15,5,utf8_decode(number_format($total_internas_gravadas,2)),"T",0,'R');/*Internas gravadas*/
    $pdf->Cell(25,5,utf8_decode(number_format(0.00,2)),"T",0,'R');/*no*/
    $pdf->Cell(15,5,utf8_decode(number_format($total_credito_fiscal,2)),"T",0,'R');/*credito  fiscal*/
    $pdf->Cell(10,5,utf8_decode(number_format($total_retencion,2)),"T",0,'R');/*total retencion*/

    $pdf->Cell(15,5,utf8_decode(number_format($total_compras,2)),"T",0,'R');/*total compras*/
    $pdf->Cell(15,5,utf8_decode(number_format(0.00,2)),"T",0,'R');/*impuesto retenido a terceros*/
    $pdf->Cell(15,5,utf8_decode(number_format(0.00,2)),"T",1,'R');/**/

    ob_clean();
    $pdf->Output("libro_compras.pdf","I");
