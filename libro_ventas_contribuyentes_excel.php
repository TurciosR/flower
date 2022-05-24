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

$objPHPExcel->getActiveSheet()->mergeCells('A1:O1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:O2');
$objPHPExcel->getActiveSheet()->mergeCells('A3:O3');
$objPHPExcel->getActiveSheet()->mergeCells('A4:O4');
$objPHPExcel->getActiveSheet()->mergeCells('A5:O5');
$objPHPExcel->getActiveSheet()->mergeCells('A6:O6');
$objPHPExcel->getActiveSheet()->mergeCells('A7:O7');

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
$objPHPExcel->getActiveSheet()->getStyle("A".$nin.":P"."10")->applyFromArray($negrita_centrado);



$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $nombre_a);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', $direccion);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', $telefonos);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', $title0);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5', "NIT: ".$nit." NRC: ".$nrc);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A6', $fech);

//Ancho de algunas filas

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(45);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
//Encabezados de la tabla






$objPHPExcel->getActiveSheet()->getRowDimension('10')->setRowHeight(40);
$objPHPExcel->getActiveSheet()->getStyle('A1:P10')->getAlignment()->setWrapText(true);

$objPHPExcel->getActiveSheet()->mergeCells('A8:A10');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A8', "No.");

$objPHPExcel->getActiveSheet()->mergeCells('B8:B10');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B8', "FECHA DE EMISIÓN");

$objPHPExcel->getActiveSheet()->mergeCells('C8:C10');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C8',"NUMERO DE CORRELATIVO IMPRESO");

$objPHPExcel->getActiveSheet()->mergeCells('D8:D10');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D8', "PREIJO O SERIE");

$objPHPExcel->getActiveSheet()->mergeCells('E8:E10');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E8', "NUMERO DE CONTROL INTERNO");

$objPHPExcel->getActiveSheet()->mergeCells('F8:F10');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F8', "NOMBRE DEL CLIENTE");

$objPHPExcel->getActiveSheet()->mergeCells('G8:G10');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G8', "NRC");

$objPHPExcel->getActiveSheet()->mergeCells('H8:O8');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H8', "OPERACIONES DE VENTAS PROPIAS Y A CUENTA DE TERCEROS");

$objPHPExcel->getActiveSheet()->mergeCells('H9:K9');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H9', "PROPIAS");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H10', "NO SUJETAS");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I10', "EXENTAS");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J10', "INTERNAS GRAVADAS");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K10', "DÉBITO FISCAL");

$objPHPExcel->getActiveSheet()->mergeCells('L9:N9');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L9', "A CUENTA DE TERCEROS");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L10', "EXENTAS");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M10', "INTERNAS GRABADAS");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N10', "DÉBITO FISCAL");

$objPHPExcel->getActiveSheet()->mergeCells('O9:O10');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O9', "IVA RETENIDO");

$objPHPExcel->getActiveSheet()->mergeCells('P8:P10');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P8', "TOTAL");
$fini=($_REQUEST["fini"]);
$fin=($_REQUEST["ffin"]);
$sql=_query("SELECT factura.id_factura,factura.tipo_documento,factura.fecha,factura.num_fact_impresa,factura.serie,cliente.nombre,cliente.nrc,factura.iva as total_iva,factura.retencion AS total_retencion,factura.total,factura.anulada FROM factura JOIN cliente ON cliente.id_cliente=factura.id_cliente WHERE factura.fecha BETWEEN '$fini' AND '$fin' AND tipo_documento='CCF' AND factura.id_sucursal=$id_sucursal  ");
$nrows=_num_rows($sql);
$i=1;
$pa=1;
$c=1;
$sp=11;
$total_internas_gravadas=0;
$total_debito_fiscal=0;
$total_retencion=0;
$total_ventas=0;

if ($nrows>0) {
  while ($row=_fetch_array($sql)) {
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$sp,$i);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$sp,ED($row['fecha']));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$sp,$row['num_fact_impresa']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$sp,$row['serie']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$sp,$row['id_factura']);

    if ($row['anulada']==1) {
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$sp,"<<COMPROBANTE ANULADO>");
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$sp,"");
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$sp,0.00);
      $objPHPExcel->setActiveSheetIndex(0)->getStyle("H".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$sp,0.00);
      $objPHPExcel->setActiveSheetIndex(0)->getStyle("I".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$sp,0.00);
      $objPHPExcel->setActiveSheetIndex(0)->getStyle("J".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$sp,0.00);
      $objPHPExcel->setActiveSheetIndex(0)->getStyle("K".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$sp,0.00);
      $objPHPExcel->setActiveSheetIndex(0)->getStyle("L".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$sp,0.00);
      $objPHPExcel->setActiveSheetIndex(0)->getStyle("M".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$sp,0.00);
      $objPHPExcel->setActiveSheetIndex(0)->getStyle("N".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$sp,0.00);
      $objPHPExcel->setActiveSheetIndex(0)->getStyle("O".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$sp,0.00);
      $objPHPExcel->setActiveSheetIndex(0)->getStyle("O".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
    }
    else {
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$sp,$row['nombre']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$sp,$row['nrc']);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$sp,0.00);
      $objPHPExcel->setActiveSheetIndex(0)->getStyle("H".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$sp,0.00);
      $objPHPExcel->setActiveSheetIndex(0)->getStyle("I".$sp)->getNumberFormat()->setFormatCode('#,##0.00');

      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$sp,number_format(($row['total']-$row['total_iva']),2));
      $objPHPExcel->setActiveSheetIndex(0)->getStyle("J".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
      $total_internas_gravadas=$total_internas_gravadas+(round(($row['total']-$row['total_iva']),2));

      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$sp,$row['total_iva']);
      $objPHPExcel->setActiveSheetIndex(0)->getStyle("K".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
      $total_debito_fiscal=$total_debito_fiscal+$row['total_iva'];


      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$sp,0.00);
      $objPHPExcel->setActiveSheetIndex(0)->getStyle("L".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$sp,0.00);
      $objPHPExcel->setActiveSheetIndex(0)->getStyle("M".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$sp,0.00);
      $objPHPExcel->setActiveSheetIndex(0)->getStyle("N".$sp)->getNumberFormat()->setFormatCode('#,##0.00');

      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$sp,$row['total_retencion']);
      $objPHPExcel->setActiveSheetIndex(0)->getStyle("O".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
      $total_retencion=$total_retencion+$row['total_retencion'];

      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$sp,$row['total']);
      $objPHPExcel->setActiveSheetIndex(0)->getStyle("P".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
      $total_ventas=$total_ventas+$row['total'];
    }




    $sp++;
    $i++;
  }


}

$objPHPExcel->getActiveSheet()->mergeCells("A$sp:G$sp");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$sp,"TOTALES");

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$sp,0.00);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("H".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$sp,0.00);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("I".$sp)->getNumberFormat()->setFormatCode('#,##0.00');

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$sp,$total_internas_gravadas);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("J".$sp)->getNumberFormat()->setFormatCode('#,##0.00');

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$sp,$total_debito_fiscal);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("K".$sp)->getNumberFormat()->setFormatCode('#,##0.00');

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$sp,0.00);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("L".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$sp,0.00);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("M".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$sp,0.00);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("N".$sp)->getNumberFormat()->setFormatCode('#,##0.00');

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$sp,$total_retencion);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("O".$sp)->getNumberFormat()->setFormatCode('#,##0.00');

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$sp,$total_ventas);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("P".$sp)->getNumberFormat()->setFormatCode('#,##0.00');



// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('LIBRO CONTRIBUYENTES');


//estilo para hacer borde a cada celda de datos
$objPHPExcel->getActiveSheet()->getStyle('A'.'8'.':P'.$sp)->applyFromArray($BStyle);
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
$archivo_salida="ventas_contribuyentes_".date("dmY").".xls";
// Redirect output to a client’s web browser (Excel7)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$archivo_salida.'"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 07:00:00 GMT'); // Date in the past
header ('Last-Modified: '.Date('D, d M Y H:i:s').' GMT'); // always modified
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
