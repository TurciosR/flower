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
list($a,$m,$d) = explode("-", $_REQUEST["fini"]);
list($a1,$m1,$d1) = explode("-", $_REQUEST["ffin"]);

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
//Encabezados de la tabla






$objPHPExcel->getActiveSheet()->getRowDimension('9')->setRowHeight(40);
$objPHPExcel->getActiveSheet()->getStyle('A1:O9')->getAlignment()->setWrapText(true);

$objPHPExcel->getActiveSheet()->mergeCells('A8:A9');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A8', "No.");

$objPHPExcel->getActiveSheet()->mergeCells('B8:B9');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B8', "FECHA DE EMISIÓN");

$objPHPExcel->getActiveSheet()->mergeCells('C8:C9');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C8',"NUMERO DE DOCUMENTO");

$objPHPExcel->getActiveSheet()->mergeCells('D8:D9');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D8', "NRC");

$objPHPExcel->getActiveSheet()->mergeCells('E8:E9');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E8', "NIT O DUI DE SUJETO EXCLUIDO");

$objPHPExcel->getActiveSheet()->mergeCells('F8:F9');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F8', "NOMBRE DEL PROVEEDOR");

$objPHPExcel->getActiveSheet()->mergeCells('G8:H8');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G8', "COMPRAS EXENTAS");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G9', "INTERNAS");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H9', "IMPORTACIONES E INTERNACIONALES");

$objPHPExcel->getActiveSheet()->mergeCells('I8:k8');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I8', "COMPRAS GRAVADAS");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I9', "INTERNAS");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J9', "IMPORTACIONES E INTERNACIONALES");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K9', "CRÉDITO FISCAL");

$objPHPExcel->getActiveSheet()->mergeCells('L8:L9');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L8', "RET. 1% Y 2% A/C");

$objPHPExcel->getActiveSheet()->mergeCells('M8:M9');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M8',"TOTAL COMPRAS");

$objPHPExcel->getActiveSheet()->mergeCells('N8:N9');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N8',"IMPUESTO RETENIDO A TERCEROS");

$objPHPExcel->getActiveSheet()->mergeCells('O8:O9');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O8', "COMPRAS A SUJETOS EXCLUIDOS");



    $total_internas_exentas=0;
    $total_internas_gravadas=0;
    $total_credito_fiscal=0;
    $total_retencion=0;
    $total_compras=0;


$sql =_query("SELECT compra.id_compra,compra.fecha,compra.total_percepcion,compra.numero_doc,proveedor.nrc,proveedor.nombre,compra.iva,compra.total FROM compra JOIN proveedor ON proveedor.id_proveedor=compra.id_proveedor WHERE compra.fecha BETWEEN '$_REQUEST[fini]' AND '$_REQUEST[ffin]' AND compra.id_sucursal=$id_sucursal ORDER BY compra.fecha ASC  ");
$nrows=_num_rows($sql);
$i=1;
$pa=1;
$c=1;

$sp=10;
if ($nrows>0) {
  # code...

    # code...

  while ($row=_fetch_array($sql)) {


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$sp,$i);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$sp,ED($row['fecha']));
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$sp, $row['numero_doc'],PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$sp,$row['nrc']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$sp,"");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$sp,$row['nombre']);


    $sql_exento = _fetch_array(_query("SELECT SUM(detalle_compra.subtotal) as total FROM detalle_compra WHERE id_compra=$row[id_compra] AND detalle_compra.exento=1"));
    $num=$sql_exento['total'];
    $total_internas_exentas=$total_internas_exentas+$num;

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$sp,number_format($num,2,".",""));
    $objPHPExcel->setActiveSheetIndex(0)->getStyle("G".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$sp,0.00);
    $objPHPExcel->setActiveSheetIndex(0)->getStyle("H".$sp)->getNumberFormat()->setFormatCode('#,##0.00');


    /*$pdf->Cell(15,5,utf8_decode(number_format($num,2)),0,0,'R');
    $pdf->Cell(25,5,utf8_decode(number_format(0.00,2)),0,0,'R');*/

    $sql_exento = _fetch_array(_query("SELECT SUM(detalle_compra.subtotal) as total FROM detalle_compra WHERE id_compra=$row[id_compra] AND detalle_compra.exento=0"));
    $num=$sql_exento['total'];
    $total_internas_gravadas=$total_internas_gravadas+$num;

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$sp,$num);
    $objPHPExcel->setActiveSheetIndex(0)->getStyle("I".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$sp,0.00);
    $objPHPExcel->setActiveSheetIndex(0)->getStyle("J".$sp)->getNumberFormat()->setFormatCode('#,##0.00');

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$sp,$row['iva']);
    $objPHPExcel->setActiveSheetIndex(0)->getStyle("K".$sp)->getNumberFormat()->setFormatCode('#,##0.00');

    $total_credito_fiscal=$total_credito_fiscal+$row['iva'];

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$sp,$row['total_percepcion']);
    $objPHPExcel->setActiveSheetIndex(0)->getStyle("L".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
    $total_retencion=$total_retencion+$row['total_percepcion'];

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$sp,$row['total']);
    $objPHPExcel->setActiveSheetIndex(0)->getStyle("M".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
    $total_compras=$total_compras+$row['total'];

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$sp,0.00);
    $objPHPExcel->setActiveSheetIndex(0)->getStyle("N".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$sp,0.00);
    $objPHPExcel->setActiveSheetIndex(0)->getStyle("O".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
    $i++;
    $c++;
    $sp++;

  }
}

$objPHPExcel->getActiveSheet()->mergeCells("A$sp:F$sp");

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$sp,"TOTALES");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$sp,$total_internas_exentas);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("G".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$sp,0.00);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("H".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$sp,$total_internas_gravadas);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("I".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$sp,0.00);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("J".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$sp,$total_credito_fiscal);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("K".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$sp,$total_retencion);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("L".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$sp,$total_compras);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("M".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$sp,0.00);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("N".$sp)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$sp,0.00);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("O".$sp)->getNumberFormat()->setFormatCode('#,##0.00');





// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('LIBRO COMPRAS');


//estilo para hacer borde a cada celda de datos
$objPHPExcel->getActiveSheet()->getStyle('A'.'8'.':O'.$sp)->applyFromArray($BStyle);
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
$archivo_salida="libro_compras_".date("dmY").".xls";
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
