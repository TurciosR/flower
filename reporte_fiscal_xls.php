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
    $direccion = utf8_decode(Mayu(utf8_decode(trim($row_emp["direccion"]))));
    $tel1 = $row_emp['telefono1'];
    $nrc = $row_emp['nrc'];
    $nit = $row_emp['nit'];
    $telefonos="TEL. ".$tel1;

    //$min = $_REQUEST["l"];
    $fini = $_REQUEST["fini"];
    $fin = $_REQUEST["ffin"];
    $fini1 = ED($_REQUEST["fini"]);
    $fin1 = ED($_REQUEST["ffin"]);
    $logo = "img/logo_sys.png";
    $impress = "Impreso: ".date("d/m/Y");
    $title = $nombre_a;
    $titulo = "REPORTE FISCAL";
    if($fini!="" && $fin!="")
    {
        list($a,$m,$d) = explode("-", $fini);
        list($a1,$m1,$d1) = explode("-", $fin);
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

    //Titulos
    $title0="REPORTE FISCAL";


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

    $objPHPExcel->getActiveSheet()->mergeCells('A1:L1');
    $objPHPExcel->getActiveSheet()->mergeCells('A2:L2');
    $objPHPExcel->getActiveSheet()->mergeCells('A3:L3');
    $objPHPExcel->getActiveSheet()->mergeCells('A4:L4');
    $objPHPExcel->getActiveSheet()->mergeCells('A5:L5');
    $objPHPExcel->getActiveSheet()->mergeCells('A6:L6');
    $objPHPExcel->getActiveSheet()->mergeCells('A7:L7');
    $objPHPExcel->getActiveSheet()->mergeCells('A8:A9');
    $objPHPExcel->getActiveSheet()->mergeCells('B8:B9');
    $objPHPExcel->getActiveSheet()->mergeCells('C8:E8');
    $objPHPExcel->getActiveSheet()->mergeCells('F8:H8');
    $objPHPExcel->getActiveSheet()->mergeCells('I8:K8');
    $objPHPExcel->getActiveSheet()->mergeCells('L8:L9');

    //altura de algunas filas
    for($j=2;$j<8;$j++)
    {
        $objPHPExcel->getActiveSheet()->getRowDimension($j)->setRowHeight(15);
    }
    //Ancho de algunas filas
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
    //  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
    //$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);

    $nin = 8;
    //Esrilo de fuentes
    $objPHPExcel->getActiveSheet()->getStyle("A1:L7")->applyFromArray($titulo);
    $objPHPExcel->getActiveSheet()->getStyle("A".$nin.":L".$nin)->applyFromArray($negrita_centrado);
    $objPHPExcel->getActiveSheet()->getStyle("A8:L9")->applyFromArray($BStyle);
    $objPHPExcel->getActiveSheet()->getStyle("A9:L9")->applyFromArray($BStyle);

    //Incluir Logo
    /*$objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('Logo');
    $objDrawing->setDescription('Logo');
    $objDrawing->setPath($logo);
    $objDrawing->setCoordinates('N2');
    //setOffsetX works properly
    $objDrawing->setOffsetX(30);
    $objDrawing->setOffsetY(50);
    //set width, height
    $objDrawing->setWidth(100);
    $objDrawing->setHeight(100);
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
    */

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $nombre_a);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', $direccion);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', $telefonos);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', $title0);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5', $fech);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A6', "NRC: ".$nrc."  NIT: ".$nit);

    //Encabezados de la tabla
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nin, "FECHA");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$nin, "SUCURSAL");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$nin, "TIQUETE");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$nin, "FACTURA");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$nin, "CREDITO FISCAL");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$nin, "TOTAL GENERAL");



    $nin = 9;
    $objPHPExcel->getActiveSheet()->getStyle("A".$nin.":L".$nin)->applyFromArray($negrita_centrado);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$nin, "INICIO");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$nin, "FIN");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$nin, "TOTAL");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$nin, "INICIO");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$nin, "FIN");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$nin, "TOTAL");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$nin, "INICIO");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$nin, "FIN");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$nin, "TOTAL");

    $nin = 10;
    $fk = $fini1;
    $fs = 1;
    $f1 = 0;
    while(strtotime($fk) <= strtotime($fin1))
    {
        $fk = MD($fk);
        $sql_efectivo = _query("SELECT * FROM factura WHERE fecha = '$fk' AND id_sucursal = '$id_sucursal'");
        $cuenta = _num_rows($sql_efectivo);
        $sql_min_max=_query("SELECT MIN(num_fact_impresa) as minimo, MAX(num_fact_impresa) as maximo FROM factura WHERE fecha = '$fk'  AND numero_doc LIKE '%TIK%' AND id_sucursal = '$id_sucursal' AND anulada = 0 UNION ALL SELECT MIN(num_fact_impresa) as minimo, MAX(num_fact_impresa) as maximo FROM factura WHERE fecha = '$fk'  AND numero_doc LIKE '%COF%' AND id_sucursal = '$id_sucursal' AND anulada = 0 UNION ALL SELECT MIN(num_fact_impresa) as minimo, MAX(num_fact_impresa) as maximo FROM factura WHERE fecha = '$fk' AND numero_doc LIKE '%CCF%' AND id_sucursal = '$id_sucursal' AND anulada = 0");
        $cuenta_min_max = _num_rows($sql_min_max);
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $total_tike_e = 0;
        $total_factura_e = 0;
        $total_credito_fiscal_e = 0;
        $total_reserva_e = 0;
        $total_dev_e = 0;
        $total_tike_g = 0;
        $total_factura_g = 0;
        $total_credito_fiscal_g = 0;
        $total_reserva_g = 0;
        $total_dev_g = 0;
        $total_tike = 0;
        $total_factura = 0;
        $total_credito_fiscal = 0;
        $tike_min = 0;
        $tike_max = 0;
        $factura_min = 0;
        $factura_max = 0;
        $credito_fiscal_min = 0;
        $credito_fiscal_max = 0;
        $dev_min = 0;
        $dev_max = 0;
        $res_min = 0;
        $res_max = 0;
        $t_tike = 0;
        $t_factuta = 0;
        $t_credito = 0;
        $t_dev = 0;
        $t_res = 0;
        $t_recerva = 0;
        $total_contado = 0;
        $total_tarjeta = 0;
        $lista_dev = "";
        if($cuenta > 0)
        {
            while ($row_corte = _fetch_array($sql_efectivo))
            {
                $id_factura = $row_corte["id_factura"];
                $anulada = $row_corte["anulada"];
                $subtotal = $row_corte["subtotal"];
                $suma = $row_corte["sumas"];
                $iva = $row_corte["iva"];
                $total = $row_corte["total"];
                $numero_doc = $row_corte["numero_doc"];
                $ax = explode("_", $numero_doc);
                $numero_co = $ax[0];
                $alias_tipodoc = $ax[1];
                $tipo_pago = $row_corte["tipo_pago"];
                $total_iva = $row_corte["total_iva"];
                $total = $row_corte["total"];

                if($alias_tipodoc == 'TIK')
                {
                    $total_tike += $total;
                }
                else if($alias_tipodoc == 'COF')
                {
                    $total_factura += $total;
                }
                else if($alias_tipodoc == 'CCF')
                {
                    $total_credito_fiscal += $total;
                }




            }
        }

        if($cuenta_min_max)
        {
            $i = 1;
            while ($row_min_max = _fetch_array($sql_min_max))
            {
                if($i == 1)
                {
                    $tike_min = $row_min_max["minimo"];
                    $tike_max = $row_min_max["maximo"];
                    if($tike_min > 0)
                    {
                        $tike_min = (int)$tike_min;
                    }
                    else
                    {
                        $tike_min = 0;
                    }

                    if($tike_max > 0)
                    {
                        $tike_max = (int)$tike_max;
                    }
                    else
                    {
                        $tike_max = 0;
                    }
                }
                if($i == 2)
                {
                    $factura_min = $row_min_max["minimo"];
                    $factura_max = $row_min_max["maximo"];
                    if($factura_min != "")
                    {
                        $factura_min = $factura_min;
                    }
                    else
                    {
                        $factura_min = 0;
                    }

                    if($factura_max != "")
                    {
                        $factura_max = $factura_max;
                    }
                    else
                    {
                        $factura_max = 0;
                    }
                }
                if($i == 3)
                {
                    $credito_fiscal_min = $row_min_max["minimo"];
                    $credito_fiscal_max = $row_min_max["maximo"];
                    if($credito_fiscal_min != "")
                    {
                        $credito_fiscal_min = $credito_fiscal_min;
                    }
                    else
                    {
                        $credito_fiscal_min = 0;
                    }

                    if($credito_fiscal_max != "")
                    {
                        $credito_fiscal_max = $credito_fiscal_max;
                    }
                    else
                    {
                        $credito_fiscal_max = 0;
                    }
                }
                $i += 1;
            }
        }
        /*$total_tike = $total_tike_e + $total_tike_g;
        $total_factura = $total_factura_e + $total_factura_g;
        $total_credito_fiscal = $total_credito_fiscal_e + $total_credito_fiscal_g;*/

        $total_general = $total_tike + $total_factura + $total_credito_fiscal;
        $fk = ED($fk);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nin, $fk);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$nin, $id_sucursal);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$nin, $tike_min);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$nin, $tike_max);
        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$nin, $total_tike);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$nin, $factura_min);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$nin, $factura_max);
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$nin, $total_factura);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$nin, $credito_fiscal_min);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$nin, $credito_fiscal_max);
        $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$nin, $total_credito_fiscal);
        $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$nin, $total_general);
        $fk = sumar_dias($fk,1);

        $nin += 1;
    }

    // Rename worksheet
    $objPHPExcel->getActiveSheet()->setTitle('Reporte fiscal');



    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);
    $archivo_salida="reporte_fiscal_".date("dmY").".xls";
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
