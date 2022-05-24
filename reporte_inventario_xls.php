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

    //$min = $_REQUEST["l"];

    $impress = "Impreso: ".date("d/m/Y");
    $title = $nombre_a;
    $titulo = "REPORTE FISCAL";
    $fini = date("Y-m-d");
    if($fini!="")
    {
        list($a,$m,$d) = explode("-", $fini);

        $fech="AL $d DE ".meses($m)." DE $a";

    }

    //Titulos
    $title0="REPORTE INVENTARIO";


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

    $objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
    $objPHPExcel->getActiveSheet()->mergeCells('A2:I2');
    $objPHPExcel->getActiveSheet()->mergeCells('A3:I3');
    $objPHPExcel->getActiveSheet()->mergeCells('A4:I4');

    //altura de algunas filas
    for($j=2;$j<4;$j++)
    {
        $objPHPExcel->getActiveSheet()->getRowDimension($j)->setRowHeight(15);
    }
    //Ancho de algunas filas
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
    //  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
    //$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);

    $nin = 5;
    //Esrilo de fuentes
    $objPHPExcel->getActiveSheet()->getStyle("A1:I4")->applyFromArray($titulo);
    $objPHPExcel->getActiveSheet()->getStyle("A".$nin.":I".$nin)->applyFromArray($negrita_centrado);
    $objPHPExcel->getActiveSheet()->getStyle("A5:I5")->applyFromArray($BStyle);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $nombre_a);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', $direccion);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', $title0);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', $fech);

    //Encabezados de la tabla
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nin, "CODIGO");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$nin, "PRODUCTO");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$nin, "PRESENTACION");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$nin, "DESCRIPCION");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$nin, "UBICACION");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$nin, "COSTO");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$nin, "PRECIO");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$nin, "EXISTENCIA");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$nin, "TOTAL($)");

    $nin = 6;
    $nin1 = 6;
    ///////////////Inicio///////////////

    $total_general = 0;
    $sql_stock = _query("SELECT pr.id_producto,pr.descripcion, pr.barcode, c.nombre_cat as cat, SUM(su.stock) as cantidad
                         FROM producto AS pr
                         LEFT JOIN categoria AS c ON pr.id_categoria=c.id_categoria
                         JOIN stock AS su ON pr.id_producto=su.id_producto
                         WHERE su.stock>0 AND su.id_sucursal='1' GROUP BY su.id_producto ORDER BY pr.descripcion");
    $contar = _num_rows($sql_stock);
    if($contar > 0)
    {
      while ($row = _fetch_array($sql_stock))
      {
        $id_producto = $row['id_producto'];
        $descripcion=$row["descripcion"];
        $cat = $row['cat'];
        $barcode = $row['barcode'];
        $existencias = $row['cantidad'];
        $estante='NO ASIGNADO';
        $posicion='';

        $sql_pres = _query("SELECT pp.*, p.nombre as descripcion_pr FROM presentacion_producto as pp, presentacion as p WHERE pp.id_presentacion=p.id_presentacion AND pp.id_producto='$id_producto' ORDER BY pp.unidad DESC");
        $npres = _num_rows($sql_pres);

          $exis = 0;
          $s = 0;
          $y = 0;
          while ($rowb = _fetch_array($sql_pres))
          {
            $unidad = $rowb["unidad"];
            $costo = $rowb["costo"];
            $precio = $rowb["precio"];
            $descripcion_pr = $rowb["descripcion"];
            $presentacion = $rowb["descripcion_pr"];
            if($existencias >= $unidad)
            {
              $exis = intdiv($existencias, $unidad);
              $existencias = $existencias%$unidad;
            }
            else
            {
              $exis =  0;
            }
            $total_costo = round(($costo/1.13) * $exis, 4);
            $total_general += $total_costo;

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$nin, $presentacion);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$nin, $descripcion_pr);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$nin, "$estante"." "."$posicion");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$nin, $costo);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$nin, $precio);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$nin, $exis);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$nin, $total_costo);

            $y =$y+1;
            if($y <= ($npres-1))
            {
              $nin=$nin+1;
              $s=$s+1;
            }
          }
          $pri = $nin - $s;

          $objPHPExcel->getActiveSheet()->mergeCells('A'.$pri.':A'.$nin);
          $objPHPExcel->getActiveSheet()->mergeCells('B'.$pri.':B'.$nin);
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$pri,$barcode, PHPExcel_Cell_DataType::TYPE_STRING );
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$pri, $descripcion);

          $nin +=1;

        }
    }
    ////////////FIN/////////////////////////////
    $objPHPExcel->getActiveSheet()->getStyle("A".$nin1.":I".$nin."")->applyFromArray($BStyle);
    $objPHPExcel->getActiveSheet()->mergeCells('A'.$nin.':H'.$nin.'');
    $objPHPExcel->getActiveSheet()->getStyle("A".$nin)->applyFromArray($negrita_centrado);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$nin, "TOTALES");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$nin, $total_general);

    // Rename worksheet
    $objPHPExcel->getActiveSheet()->setTitle('Reporte inventario');


    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);
    $archivo_salida="reporte_inventario_".date("dmY").".xls";
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
