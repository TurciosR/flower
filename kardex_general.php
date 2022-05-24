<?php
error_reporting(E_ERROR | E_PARSE);
require('_core.php');
require('fpdf/fpdf.php');

class PDF extends FPDF
{
    var $a;
    var $b;
    var $c;
    var $d;
    var $e;
    var $f;
    var $w;
    // Cabecera de página\
    public function Header()
    {

      //Encabezado General
      $this->SetFont('Arial', '', 11);
      if($this->PageNo()==1)
      {
        $this->MultiCell(280, 6, $this->a, 0, 'C', 0);
        $this->SetFont('Arial', '', 10);
        $this->Cell(280, 4, utf8_decode($this->b), 0, 1, 'C');
        $this->Cell(280, 4, utf8_decode($this->c), 0, 1, 'C');
        $this->Cell(280, 4, utf8_decode($this->d), 0, 1, 'C');
      }
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(100,5,"PRODUCTO: ".utf8_decode($this->e),0,1,'L',0);

      $this->SetFont('Arial', '', 8);

      $save_y = $this->GetY();
      $this->Cell(18,10,"FECHA",1,0,'C',0);
      $this->Cell(18,10,"TIPO DOC",1,0,'C',0);
      $this->Cell(18,10,"NUM. DOC",1,0,'C',0);


      $this->Cell(55,10,"CONCEPTO",1,0,'C',0);

      $save_x = $this->GetX();
      $this->Cell(54,5,"ENTRADA",1,1,'C',0);
      $this->SetX($save_x);
      $this->Cell(18,5,"CANTIDAD",1,0,'C',0);
      $this->Cell(18,5,"COSTO",1,0,'C',0);
      $this->Cell(18,5,"SUBTOTAL",1,0,'C',0);



      $save_x = $this->GetX();
      $this->SetXY($save_x,$save_y);
      $this->Cell(54,5,"SALIDA",1,1,'C',0);
      $this->SetX($save_x);
      $this->Cell(18,5,"CANTIDAD",1,0,'C',0);
      $this->Cell(18,5,"COSTO",1,0,'C',0);
      $this->Cell(18,5,"SUBTOTAL",1,0,'C',0);


      $save_x = $this->GetX();
      $this->SetXY($save_x,$save_y);
      $this->Cell(54,5,"SALDO",1,1,'C',0);
      $this->SetX($save_x);
      $this->Cell(18,5,"CANTIDAD",1,0,'C',0);
      $this->Cell(18,5,"COSTO",1,0,'C',0);
      $this->Cell(18,5,"SUBTOTAL",1,1,'C',0);


      $this->SetFont('Arial', '', 8);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this-> Cell(40, 10, utf8_decode('Fecha de impresión: '.date('Y-m-d')), 0, 0, 'L');
        $this->Cell(220, 10, utf8_decode('Página ').$this->PageNo().'/{nb}', 0,0, 'R');
    }
    public function setear($a,$b,$c,$d,$e,$f,$g,$w)
    {
      # code...
      $this->a=$a;
      $this->b=$b;
      $this->c=$c;
      $this->d=$d;
      $this->e=$e;
      $this->f=$f;
      $this->g=$g;
      $this->w=$w;
    }

    public function LineWriteB($array)
    {
      $ygg=0;
      $maxlines=1;
      $array_a_retornar=array();
      $array_max= array();
      foreach ($array as $key => $value) {
        // /Descripcion/
        $nombr=$value[0];
        // /fpdf width/
        $size=$value[1];
        // /fpdf alignt/
        $aling=$value[2];
        $jk=0;
        $w = $size;
        $h  = 0;
        $txt=$nombr;
        $border=0;
        if(!isset($this->CurrentFont))
          $this->Error('No font has been set');
        $cw = &$this->CurrentFont['cw'];
        if($w==0)
          $w = $this->w-$this->rMargin-$this->x;
        $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
        $s = str_replace("\r",'',$txt);
        $nb = strlen($s);
        if($nb>0 && $s[$nb-1]=="\n")
          $nb--;
        $b = 1;

        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $ns = 0;
        $nl = 1;
        while($i<$nb)
        {
          // Get next character
          $c = $s[$i];
          if($c=="\n")
          {
            $array_a_retornar[$ygg]["valor"][]=substr($s,$j,$i-$j);
            $array_a_retornar[$ygg]["size"][]=$size;
            $array_a_retornar[$ygg]["aling"][]=$aling;
            $jk++;

            $i++;
            $sep = -1;
            $j = $i;
            $l = 0;
            $ns = 0;
            $nl++;
            if($border && $nl==2)
              $b = $b2;
            continue;
          }
          if($c==' ')
          {
            $sep = $i;
            $ls = $l;
            $ns++;
          }
          $l += $cw[$c];
          if($l>$wmax)
          {
            // Automatic line break
            if($sep==-1)
            {
              if($i==$j)
                $i++;
              $array_a_retornar[$ygg]["valor"][]=substr($s,$j,$i-$j);
              $array_a_retornar[$ygg]["size"][]=$size;
              $array_a_retornar[$ygg]["aling"][]=$aling;
              $jk++;
            }
            else
            {
              $array_a_retornar[$ygg]["valor"][]=substr($s,$j,$sep-$j);
              $array_a_retornar[$ygg]["size"][]=$size;
              $array_a_retornar[$ygg]["aling"][]=$aling;
              $jk++;

              $i = $sep+1;
            }
            $sep = -1;
            $j = $i;
            $l = 0;
            $ns = 0;
            $nl++;
            if($border && $nl==2)
              $b = $b2;
          }
          else
            $i++;
        }
        // Last chunk
        if($this->ws>0)
        {
          $this->ws = 0;
        }
        if($border && strpos($border,'B')!==false)
          $b .= 'B';
        $array_a_retornar[$ygg]["valor"][]=substr($s,$j,$i-$j);
        $array_a_retornar[$ygg]["size"][]=$size;
        $array_a_retornar[$ygg]["aling"][]=$aling;
        $jk++;
        $ygg++;
        if ($jk>$maxlines) {
          // code...
          $maxlines=$jk;
        }
      }

      $ygg=0;
      foreach($array_a_retornar as $keys)
      {
        for ($i=count($keys["valor"]); $i <$maxlines ; $i++) {
          // code...
          $array_a_retornar[$ygg]["valor"][]="";
          $array_a_retornar[$ygg]["size"][]=$array_a_retornar[$ygg]["size"][0];
          $array_a_retornar[$ygg]["aling"][]=$array_a_retornar[$ygg]["aling"][0];
        }
        $ygg++;
      }



      $data=$array_a_retornar;
      $total_lineas=count($data[0]["valor"]);
      $total_columnas=count($data);

      for ($i=0; $i < $total_lineas; $i++) {
        // code...
        for ($j=0; $j < $total_columnas; $j++) {
          // code...
          $salto=0;
          //$abajo="LR";
          $abajo=0;
          if ($i==0) {
            // code...
            //$abajo="TLR";
          }
          if ($j==$total_columnas-1) {
            // code...
            $salto=1;
          }
          if ($i==$total_lineas-1) {
            // code...
            $abajo="B";
          }
          if ($i==$total_lineas-1&&$i==0) {
            // code...
            $abajo="B";
          }

          $abajo=0;
          $str = $data[$j]["valor"][$i];
          $this->Cell($data[$j]["size"][$i],4,$str,$abajo,$salto,$data[$j]["aling"][$i]);
        }

      }
    }
}

$id_sucursal = $_SESSION["id_sucursal"];
$sql_empresa = "SELECT * FROM sucursal WHERE id_sucursal='$id_sucursal'";
$resultado_emp=_query($sql_empresa);
$row_emp=_fetch_array($resultado_emp);
$nombre_a = utf8_decode(Mayu((trim($row_emp["descripcion"]))));
//$direccion = Mayu(utf8_decode($row_emp["direccion_empresa"]));
$direccion = utf8_decode(Mayu((trim($row_emp["direccion"]))));
$logo = "img/logo_sys.png";
$title = $nombre_a;
$fech = "";

$id_producto = $_REQUEST["id_producto"];
$fini = $_REQUEST["fini"];
$fin = $_REQUEST["fin"];
$logo = "img/logo_sys.jpg";
$impress = "Impreso: ".date("d/m/Y");

$titulo = "KARDEX DE PRODUCTO";
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


  $pdf = new PDF('L', 'mm', 'letter');
  $pdf->SetMargins(10, 10);
  $pdf->SetLeftMargin(5);
  $pdf->AliasNbPages();
  $pdf->SetAutoPageBreak(true, 15);
  $pdf->AliasNbPages();

$sqla=_query("SELECT id_producto FROM producto where id_producto IN (SELECT DISTINCT id_producto FROM movimiento_producto_detalle as md, movimiento_producto as m
        WHERE md.id_movimiento=m.id_movimiento AND CAST(m.fecha AS DATE) BETWEEN '$fini' AND '$fin')  ORDER by id_producto ASC");
//$pdf->SetTextColor(0,0,0);
while ($ra=_fetch_array($sqla)) {


  $id_producto=$ra['id_producto'];

  $sql = "SELECT * FROM movimiento_producto_detalle as md, movimiento_producto as m
          WHERE md.id_movimiento=m.id_movimiento
          AND m.id_sucursal='$id_sucursal'
          AND md.id_producto='$id_producto'
          AND m.tipo!='ASIGNACION'
          AND m.tipo!='TRANSFERENCIA'
          AND CAST(m.fecha AS DATE) BETWEEN '$fini' AND '$fin' ORDER BY md.id_movimiento ASC";

  $sql_aux = _query("SELECT descripcion FROM producto  WHERE id_producto='$id_producto'");
  $dats_aux = _fetch_array($sql_aux);

  $pdf->setear($nombre_a,$direccion,$titulo,$fech,$dats_aux["descripcion"],"","","");
  $pdf->AddPage();

  $result = _query($sql);
  $stock_anterior=0;
  $stock_actual=0;
  if(_num_rows($result)>0)
  {
      $entrada = 0;
      $salida = 0;
      $init = 1;
      while($row = _fetch_array($result))
      {
          $fechadoc = ED($row["fecha"]);
          if($row["tipo"] == "ENTRADA" || $row["proceso"] =="TRR")
          {
            $csal = -1;
            $centr = $row["cantidad"];
            $entrada += $centr;
          }
          else if($row["tipo"] == "SALIDA" || $row["proceso"] =="TRE")
          {
            $centr = -1;
            $csal = $row["cantidad"];
            $salida += $csal;
          }

          $extra="";
          $id_presentacion = $row["id_presentacion"];
          $sql_pres = _query("SELECT unidad,costo FROM presentacion_producto WHERE id_pp  ='$id_presentacion'");
          $dats_pres = _fetch_array($sql_pres);
          $uniades = $dats_pres["unidad"];
          $cost = $dats_pres["costo"];
          $id_compra = $row["id_compra"];
          $id_factura = $row["id_factura"];
          if($id_factura > 0)
          {
            $sql_comp = _query("SELECT tipo_documento, num_fact_impresa,nombre FROM factura WHERE id_factura='$id_factura'");
            $dats_comp = _fetch_array($sql_comp);
            $alias_tipodoc = $dats_comp["tipo_documento"];
            $numero_doc = $dats_comp["num_fact_impresa"];
            $extra.=" ".$dats_comp['nombre'];
          }
          if($id_compra > 0)
          {
            $sql_comp = _query("SELECT alias_tipodoc, numero_doc FROM compra WHERE id_compra='$id_compra'");
            $dats_comp = _fetch_array($sql_comp);
            $alias_tipodoc = $dats_comp["alias_tipodoc"];
            $numero_doc = $dats_comp["numero_doc"];
          }
          if($id_compra == 0 && $id_factura == 0)
          {
            $alias_tipodoc = $row['tipo'];
            $numero_doc = $row['correlativo'];
          }


          if($row["tipo"] == "AJUSTE"&& $row['id_presentacion']!=0)
          {
            //valor del movimiento antes de la descarga
            $dif=0;
            //entrada de ajuste menos salida de ajuste
            $dif = round(($stock_anterior - $row["stock_actual"]),4);

            if($dif>=0)
            {
              $centr = -1;
              $csal = abs($dif);
              $salida += $csal;

            }
            else
            {
              $csal = -1;
              $centr = abs($dif);
              $entrada += $centr;
            }

          }
          else
          {
            if($row["tipo"] == "AJUSTE")
            {
              //no mostrar el ajuste de salida
              $centr = -1;
              $csal = -1;
            }
            $stock_anterior = $row["stock_anterior"];
          }

          $ultcosto = $row["costo"]/$uniades;
          $stock_actual = $row["stock_actual"];

          $id_proveedor = $row["id_proveedor"];
          if($init)
          {
            if($stock_anterior > 0)
            {
              $array_data = array(
                array(utf8_decode(""),54,"R"),
                array(utf8_decode("INVENTARIO INICIAL"),55,"L"),
                array(utf8_decode(""),108,"R"),
                array(utf8_decode($stock_anterior),18,"R"),
                array(utf8_decode(number_format($ultcosto,2,".",",")),18,"R"),
                array(utf8_decode(number_format(($stock_anterior * $ultcosto),2)),18,"R"),
              );
              $pdf->LineWriteB($array_data);
            }
            $init=0;
          }

          if($centr >= 0)
          {
            $array_data = array(
              array(utf8_decode($fechadoc),18,"R"),
              array(utf8_decode($alias_tipodoc),18,"C"),
              array(utf8_decode($numero_doc),18,"C"),
              array(utf8_decode($row['concepto']." ".mb_strtoupper($extra)),55,"L"),
              array(utf8_decode($centr),18,"R"),
              array(utf8_decode(number_format($ultcosto,2,".",",")),18,"R"),
              array(utf8_decode(number_format(($centr * $ultcosto),2)),18,"R"),
              array(utf8_decode(""),54,"R"),
              array(utf8_decode($stock_actual),18,"R"),
              array(utf8_decode(number_format($ultcosto,2,".",",")),18,"R"),
              array(utf8_decode(number_format(($stock_actual * $ultcosto),2)),18,"R"),
            );
            $pdf->LineWriteB($array_data);
          }
          else
          {
            if($csal >= 0)
            {
              $array_data = array(
                array(utf8_decode($fechadoc),18,"R"),
                array(utf8_decode($alias_tipodoc),18,"C"),
                array(utf8_decode($numero_doc),18,"C"),
                array(utf8_decode($row['concepto']." ".mb_strtoupper($extra)),55,"L"),
                array(utf8_decode(""),54,"R"),
                array(utf8_decode($csal),18,"R"),
                array(utf8_decode(number_format($ultcosto,2,".",",")),18,"R"),
                array(utf8_decode(number_format(($csal * $ultcosto),2)),18,"R"),
                array(utf8_decode($stock_actual),18,"R"),
                array(utf8_decode(number_format($ultcosto,2,".",",")),18,"R"),
                array(utf8_decode(number_format(($stock_actual * $ultcosto),2)),18,"R"),
              );
              $pdf->LineWriteB($array_data);

            }
          }
      }

      $pdf->Line(5,$pdf->GetY(),275,$pdf->GetY());

      $pdf->Cell(74,6,"",0,0,'C',0);
      $pdf->Cell(36,6,"TOTAL ENTRADA",0,0,'L',0);
      $pdf->Cell(18,6,$entrada,0,0,'R',0);
      $pdf->Cell(36,6,"TOTAL SALIDA",0,0,'C',0);
      $pdf->Cell(18,6,$salida,0,0,'R',0);
      $pdf->Cell(146,6,"",0,0,'C',0);
  }

}


$pdf->Output("reporte_kardex.pdf", "I");
