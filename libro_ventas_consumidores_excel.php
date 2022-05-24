<?php
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

if (PHP_SAPI == 'cli')
die('Error Inesperado');
/** Include PHPExcel */
require_once dirname(__FILE__) . '/php_excel/Classes/PHPExcel.php';
include('_core.php');

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
// Set document properties
$objPHPExcel->getProperties()->setCreator("Open Solutions Systems")
->setLastModifiedBy("Open Solutions Systems")
->setTitle("Office 2007 XLSX")
->setSubject("Office 2007 XLSX")
->setDescription("Documento compatible con Office 2007 XLSX")
->setKeywords("office 2007 openxml php")
->setCategory("Reportes");

$id_sucursal = $_SESSION["id_sucursal"];
$sql_empresa = "SELECT * FROM sucursal WHERE id_sucursal='$id_sucursal'";

$resultado_emp=_query($sql_empresa);
$row_emp=_fetch_array($resultado_emp);
$nombre_a = utf8_decode(Mayu(utf8_decode(trim($row_emp["descripcion"]))));
$direccion = utf8_decode(Mayu(utf8_decode(trim($row_emp["direccion"]))));
$tel1 = $row_emp['telefono1'];
$nrc = $row_emp['nrc'];
$nit = $row_emp['nit'];
$telefonos="TEL. ".$tel1;

//Titulos
$title0="LIBRO DE COMPRAS";
list($a,$m,$d) = explode("-", ($_REQUEST["fini"]));
list($a1,$m1,$d1) = explode("-", ($_REQUEST["ffin"]));

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

//style border
$BStyle = array(
  'borders' => array(
    'outline' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    ),
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
//Center table
$titulo = array(
  'alignment' => array(
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
  ),
  'font'  => array(
    'bold'  => true,
    'color' => array('rgb' => '00000'),
    'size'  => 10,
    'name'  => 'Arial'
  )
);
$titulo2 = array(
  'alignment' => array(
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
  ),
  'font'  => array(
    'bold'  => true,
    'color' => array('rgb' => '00000'),
    'size'  => 14,
    'name'  => 'Arial'
  )
);
$negrita_centrado = array(
  'alignment' => array(
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
  ),
  'font'  => array(
    'bold'  => true,
    'color' => array('rgb' => '000000'),
    'size'  => 6,
    'name'  => 'Arial'
  )
);
$centrado = array(
  'alignment' => array(
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
  ),
  'font'  => array(
    'bold'  => false,
    'color' => array('rgb' => '000000'),
    'size'  => 10,
    'name'  => 'Arial'
  )
);

$objPHPExcel->getActiveSheet()->mergeCells('A1:L1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:L2');
$objPHPExcel->getActiveSheet()->mergeCells('A3:L3');
$objPHPExcel->getActiveSheet()->mergeCells('A4:L4');
$objPHPExcel->getActiveSheet()->mergeCells('A5:L5');
$objPHPExcel->getActiveSheet()->mergeCells('A6:L6');
$objPHPExcel->getActiveSheet()->mergeCells('A7:L7');

//altura de algunas filas
for($j=2;$j<8;$j++)
{
  $objPHPExcel->getActiveSheet()->getRowDimension($j)->setRowHeight(15);
}

//  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
//$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);

$nin = 8;
//Esrilo de fuentes
$objPHPExcel->getActiveSheet()->getStyle("A1:O7")->applyFromArray($titulo);
$objPHPExcel->getActiveSheet()->getStyle("A1:O1")->applyFromArray($titulo2);
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(23);
$objPHPExcel->getActiveSheet()->getStyle("A".$nin.":O"."9")->applyFromArray($negrita_centrado);



$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $nombre_a);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', $direccion);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', $telefonos);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', $title0);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5',"NIT: ".$nit." NRC: ".$nrc);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A6', $fech);

//Ancho de algunas filas
/*$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);*/

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(12);
//Encabezados de la tabla






$objPHPExcel->getActiveSheet()->getRowDimension('9')->setRowHeight(40);
$objPHPExcel->getActiveSheet()->getStyle('A1:O9')->getAlignment()->setWrapText(true);

$objPHPExcel->getActiveSheet()->mergeCells('A8:A9');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A8', "FECHA");

$objPHPExcel->getActiveSheet()->mergeCells('B8:B9');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B8', "TIPO DOC");

$objPHPExcel->getActiveSheet()->mergeCells('C8:C9');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C8',"DEL NO.");

$objPHPExcel->getActiveSheet()->mergeCells('D8:D9');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D8', "AL NO.");

$objPHPExcel->getActiveSheet()->mergeCells('E8:E9');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E8', "NO. MAQUINA O CAJA REGISTRADORA");

$objPHPExcel->getActiveSheet()->mergeCells('F8:J8');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F8', "VENTAS POR CUENTA PROPIA");

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F9', "VENTAS NO SUJETAS");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G9', "VENTAS EXENTAS");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H9', "VENTAS GRAVADAS LOCALES");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I9', "EXPORTACIONES");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J9', "VENTAS TOTALES");

$objPHPExcel->getActiveSheet()->mergeCells('K8:K9');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K8', "VENTAS POR CUENTA DE TERCEROS");

$objPHPExcel->getActiveSheet()->mergeCells('L8:L9');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L8',"1% RETENCIÓN");

$fini=($_REQUEST["fini"]);
$fin=($_REQUEST["ffin"]);
$sql=_query("SELECT DISTINCT factura.fecha FROM factura WHERE factura.fecha BETWEEN '$fini' AND '$fin' AND factura.id_sucursal=$id_sucursal ");

$nrows=_num_rows($sql);

$total_ventas_internas_gravadas=0;
$total_retencion=0;

$i=1;
$pa=1;
$c=1;
$sp=10;
if ($nrows>0) {
  while ($row=_fetch_array($sql)) {

      $sql_min_max = _query("SELECT MIN(CONVERT(num_fact_impresa,UNSIGNED INTEGER)) as minimo, MAX(CONVERT(num_fact_impresa,UNSIGNED INTEGER)) as maximo FROM factura WHERE  numero_doc LIKE '%COF%' AND id_sucursal = '$id_sucursal' AND fecha = '$row[fecha]'");
      $nrowstik=_num_rows($sql_min_max);
      if ($nrowstik>0) {
        # code...

        $rowt2=_fetch_array($sql_min_max);
        if ($rowt2['minimo']!=""&&$rowt2['maximo']!="") {

          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$sp,ED($row['fecha']));
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$sp,utf8_decode("CF"));
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$sp,utf8_decode($rowt2['minimo']));
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$sp,utf8_decode($rowt2['maximo']));
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$sp,utf8_decode(""));

          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$sp,0.00);
          $objPHPExcel->setActiveSheetIndex(0)->getStyle("F".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$sp,0.00);
          $objPHPExcel->setActiveSheetIndex(0)->getStyle("G".$sp)->getNumberFormat()->setFormatCode('#,##0.00');

          $sql_tcof=_fetch_array(_query("SELECT SUM(factura.total) AS venta FROM factura WHERE factura.fecha='$row[fecha]' AND factura.tipo_documento='COF' AND factura.id_sucursal=$id_sucursal AND factura.anulada=0"));

          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$sp,$sql_tcof['venta']);
          $objPHPExcel->setActiveSheetIndex(0)->getStyle("H".$sp)->getNumberFormat()->setFormatCode('#,##0.00');

          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$sp,0.00);
          $objPHPExcel->setActiveSheetIndex(0)->getStyle("I".$sp)->getNumberFormat()->setFormatCode('#,##0.00');

          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$sp,$sql_tcof['venta']);
          $objPHPExcel->setActiveSheetIndex(0)->getStyle("J".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
          $total_ventas_internas_gravadas=$total_ventas_internas_gravadas+$sql_tcof['venta'];

          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$sp,0.00);
          $objPHPExcel->setActiveSheetIndex(0)->getStyle("K".$sp)->getNumberFormat()->setFormatCode('#,##0.00');

          $sql_tcof=_fetch_array(_query("SELECT SUM(factura.retencion) AS retencion FROM factura WHERE factura.fecha='$row[fecha]' AND factura.tipo_documento='COF' AND factura.id_sucursal=$id_sucursal AND factura.anulada=0"));

          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$sp,$sql_tcof['retencion']);
          $objPHPExcel->setActiveSheetIndex(0)->getStyle("L".$sp)->getNumberFormat()->setFormatCode('#,##0.00');

          $total_retencion=$total_retencion+$sql_tcof['retencion'];

          $c++;
          $sp++;

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

              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$sp,ED($row['fecha']));
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$sp,utf8_decode("TK"));
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$sp,str_pad($rowt2['minimo'],10,"0",STR_PAD_LEFT));
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$sp,str_pad($rowt2['maximo'],10,"0",STR_PAD_LEFT));
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$sp,utf8_decode($rnc['caja']));

              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$sp,0.00);
              $objPHPExcel->setActiveSheetIndex(0)->getStyle("F".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$sp,0.00);
              $objPHPExcel->setActiveSheetIndex(0)->getStyle("G".$sp)->getNumberFormat()->setFormatCode('#,##0.00');

              $sql_tcof=_fetch_array(_query("SELECT SUM(factura.total) AS venta FROM factura WHERE factura.fecha='$row[fecha]' AND factura.tipo_documento='TIK' AND factura.id_sucursal=$id_sucursal AND factura.anulada=0 AND caja=$rnc[caja]"));

              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$sp,$sql_tcof['venta']);
              $objPHPExcel->setActiveSheetIndex(0)->getStyle("H".$sp)->getNumberFormat()->setFormatCode('#,##0.00');

              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$sp,0.00);
              $objPHPExcel->setActiveSheetIndex(0)->getStyle("I".$sp)->getNumberFormat()->setFormatCode('#,##0.00');

              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$sp,$sql_tcof['venta']);
              $objPHPExcel->setActiveSheetIndex(0)->getStyle("J".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
              $total_ventas_internas_gravadas=$total_ventas_internas_gravadas+$sql_tcof['venta'];

              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$sp,0.00);
              $objPHPExcel->setActiveSheetIndex(0)->getStyle("K".$sp)->getNumberFormat()->setFormatCode('#,##0.00');

              $sql_tcof=_fetch_array(_query("SELECT SUM(factura.retencion) AS retencion FROM factura WHERE factura.fecha='$row[fecha]' AND factura.tipo_documento='TIK' AND factura.id_sucursal=$id_sucursal AND factura.anulada=0 AND caja=$rnc[caja]"));

              $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$sp,$sql_tcof['retencion']);
              $objPHPExcel->setActiveSheetIndex(0)->getStyle("L".$sp)->getNumberFormat()->setFormatCode('#,##0.00');

              $total_retencion=$total_retencion+$sql_tcof['retencion'];

              $c++;
              $sp++;
            }
          }

        }
      }
  }
}

$objPHPExcel->getActiveSheet()->mergeCells("A$sp:E$sp");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$sp,"TOTALES");

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$sp,0.00);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("F".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$sp,0.00);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("G".$sp)->getNumberFormat()->setFormatCode('#,##0.00');


$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$sp,$total_ventas_internas_gravadas);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("H".$sp)->getNumberFormat()->setFormatCode('#,##0.00');

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$sp,0.00);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("I".$sp)->getNumberFormat()->setFormatCode('#,##0.00');

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$sp,$total_ventas_internas_gravadas);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("J".$sp)->getNumberFormat()->setFormatCode('#,##0.00');

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$sp,0.00);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("K".$sp)->getNumberFormat()->setFormatCode('#,##0.00');

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$sp,$total_retencion);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("L".$sp)->getNumberFormat()->setFormatCode('#,##0.00');

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('LIBRO CONSUMIDORES');

//estilo para hacer borde a cada celda de datos
$objPHPExcel->getActiveSheet()->getStyle('A'.'8'.':L'.$sp)->applyFromArray($BStyle);
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
$archivo_salida="libro_consumidores_".date("dmY").".xls";
// Redirect output to a client’s web browser (Excel7)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$archivo_salida.'"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 07:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
function ver_celda($mes)
{
  $celda = ["C","D","E","F","G","H","I","J","K","L","M","N"];
  return $celda[$mes];
}
?>
