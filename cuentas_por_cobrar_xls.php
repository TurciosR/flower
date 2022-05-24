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
    //$direccion = Mayu(utf8_decode($row_emp["direccion_empresa"]));
    $direccion = (((($row_emp["direccion"]))));
    $tel1 = $row_emp['telefono1'];
    $nrc = $row_emp['nrc'];
    $nit = $row_emp['nit'];
    $telefonos="TEL. ".$tel1;


    $logo = "img/logo_sys.png";
    $impress = "Impreso: ".date("d/m/Y");
    $title = $nombre_a;
    $titulo = "REPORTE CUENTAS POR COBRAR ";

    //Titulos
    $title0="REPORTE CUENTAS POR COBRAR";


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
	$negrita_centrado = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        ),
        'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '000000'),
            'size'  => 10,
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

    $objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
    $objPHPExcel->getActiveSheet()->mergeCells('A2:E2');
    $objPHPExcel->getActiveSheet()->mergeCells('A3:E3');
    $objPHPExcel->getActiveSheet()->mergeCells('A4:E4');
    $objPHPExcel->getActiveSheet()->mergeCells('A5:E5');
    $objPHPExcel->getActiveSheet()->mergeCells('A6:E6');
    $objPHPExcel->getActiveSheet()->mergeCells('A7:E7');

    //altura de algunas filas
    for($j=2;$j<8;$j++)
    {
        $objPHPExcel->getActiveSheet()->getRowDimension($j)->setRowHeight(15);
    }
    //Ancho de algunas filas
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
    //  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
    //$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);

    $nin = 9;
    //Esrilo de fuentes
    $objPHPExcel->getActiveSheet()->getStyle("A1:L7")->applyFromArray($titulo);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $nombre_a);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', $direccion);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', $telefonos);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', $title0);
    //$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5', $fech);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5', "NRC: ".$nrc."  NIT: ".$nit);


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A8', "Descripción");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B8', "Facturas Pendientes");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C8', "Deuda Total");

    $sql1="SELECT factura.tipo_documento,cliente.nombre,factura.num_fact_impresa, credito.total,credito.abono,credito.saldo FROM credito JOIN factura ON factura.id_factura=credito.id_factura JOIN cliente ON cliente.id_cliente=factura.id_cliente WHERE credito.saldo>0";
    $result1=_query($sql1);


  	$deuda_total=0;
    while($row=_fetch_array($result1))
  	{
      $deuda2 = $row['saldo'];

      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nin, $row['nombre']);

      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$nin,  $row['tipo_documento']." ".$row['num_fact_impresa']);

      $objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$nin,  round($row['total'],4));

      $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$nin,  round($row['abono'],4));

      $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$nin,  round($row['saldo'],4));
  		$deuda_total+=$deuda2;

      $nin += 1;
    }

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nin, "TOTALES");

    $objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$nin,  round($deuda_total,4));

    // Rename worksheet
    $objPHPExcel->getActiveSheet()->setTitle('cuentas_por_pagar');



    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);
    $archivo_salida="cuentas_por_pagar".date("dmY").".xls";
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
?>
