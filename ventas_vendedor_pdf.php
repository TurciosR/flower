<?php
error_reporting(E_ERROR | E_PARSE);
require("_core.php");
require("num2letras.php");
require('fpdf/fpdf.php');

$fini = $_REQUEST["fini"];
$fin = $_REQUEST["ffin"];


$sql_empresa = "SELECT * FROM sucursal WHERE id_sucursal=$_SESSION[id_sucursal]";

$resultado_emp=_query($sql_empresa);
$row_emp=_fetch_array($resultado_emp);
$nombre_a = utf8_decode(Mayu(utf8_decode(trim($row_emp["descripcion"]))));
$tel1 = $row_emp['telefono1'];
$n_sucursal = $row_emp['n_sucursal'];
$tel2 = $row_emp['telefono2'];
$direccion = $row_emp['direccion'];
$telefonos="TEL. ".$tel1." y ".$tel2;



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

        // Logo
        $this->Image('img/logo_sys.png', 10, 10, 33);
        $this->AddFont('latin','','latin.php');
        $this->SetFont('latin', '', 10);
        // Movernos a la derecha
        // Título
        //$this->SetX(43);
        //$this->Cell(130, 4, 'HOJA DE CONTEO ', 0, 1, 'C');

        $this->Cell(195,6,$this->a,0,1,'C');
        $this->SetFont('Latin','',10);
        $this->SetX(40);
        $this->MultiCell(140,5,utf8_decode((Mayu(utf8_decode("Sucursal ".": ".$this->c)))),0,'C',0);
        $this->Cell(195,6,$this->b,0,1,'C');
        $this->Cell(195,6,utf8_decode("REPORTE DE VENTAS POR VENDEDOR"),0,1,'C');
        $this->Cell(195,6,$this->d,0,1,'C');
        // Salto de línea
        $this->Ln(5);
        $set_y=$this->GetY();
        $set_x=$this->GetX();
        $this->SetXY($set_x, $set_y);
        $this->AddFont('latin','','latin.php');
        $this->SetFont('latin', '', 9);
    }

    public function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página requiere $pdf->AliasNbPages();
        //utf8_decode() de php que convierte nuestros caracteres a ISO-8859-1
        $this-> Cell(40, 10, utf8_decode('Fecha de impresión: '.date('Y-m-d')), 0, 0, 'L');
        $this->Cell(156, 10, utf8_decode('Página ').$this->PageNo().'/{nb}', 0, 0, 'R');
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
}

$pdf = new PDF('P', 'mm', 'letter');
$fech =  "DEL ".ED($fini)." AL ".ED($fin);
$pdf->setear($nombre_a,$telefonos,$direccion,$fech,$n_sucursal,"","","");
$pdf->SetMargins(10, 10);
$pdf->SetLeftMargin(10);
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 15);
$pdf->AliasNbPages();
$pdf->AddPage();
$fk=$fini;
$empleados = array();
while(strtotime($fk) <= strtotime($fin))
{

$fecha_actual = $fk;
$sql="SELECT DISTINCT factura.id_empleado,usuario.usuario, empleado.nombre FROM factura JOIN usuario ON usuario.id_usuario=factura.id_empleado LEFT JOIN empleado ON empleado.id_empleado=usuario.id_empleado WHERE factura.fecha='$fecha_actual'";


$result=_query($sql);
$cuenta = _num_rows($result);
if($cuenta > 0)
{
  //$pdf->Cell(195,5,ED($fk),"B",1,'L',0);
  while ($row = _fetch_array($result))
  {
    $id_empleado = $row["id_empleado"];
    $nombre = $row["nombre"];

    if ($nombre=='') {
      // code...
      $nombre=$row["usuario"];
    }
    $sql_monto = _query("SELECT SUM(total) as total FROM factura WHERE id_empleado = '$id_empleado' AND fecha = '$fecha_actual' AND anulada = 0 AND finalizada = 1 AND caja!=0 AND credito=0");
    //echo "SELECT SUM(subtotal) as monto FROM factura_detalle WHERE id_empleado = '$id_empleado' AND fecha = '$fecha_actual'";

    $row_monto = _fetch_array($sql_monto);
    $monto_total = $row_monto["total"];
    if($monto_total > 0)
    {
      $monto_total = number_format(($monto_total),2,".","");
    }
    else
    {
      $monto_total = "0.00";
    }

    if (!array_key_exists($id_empleado,$empleados)) {
      // code...
      $empleados[$id_empleado]['nombre']=$nombre." (".($row["usuario"]).")";
      $empleados[$id_empleado]['total']=$monto_total;
    }
    else
    {
      $empleados[$id_empleado]['nombre']=$nombre." (".($row["usuario"]).")";
      $empleados[$id_empleado]['total']= $empleados[$id_empleado]['total'] + $monto_total;
    }

      //$pdf->Cell(30,5,$nombre,0,0,'L',0);
      //$pdf->Cell(50,5,"$ ".$monto_total,0,1,'R',0);
  }
}

$fk = sumar_dias(ED($fk),1);
$fk = MD($fk);
}

$pdf->Cell(10,5,utf8_decode("Nº"),"B",0,'L',0);
$pdf->Cell(140,5,"Nombre","B",0,'L',0);
$pdf->Cell(45,5,"Total vendido","B",1,'L',0);
//print_r($empleados);
$i=1;
foreach ($empleados as $key ) {
  $pdf->Cell(10,5,$i,0,0,'L',0);
  $pdf->Cell(140,5,$key['nombre'],0,0,'L',0);
  $pdf->Cell(45,5,"$ ".number_format(($key['total']),2,".",""),0,1,'R',0);
  $i++;
}

ob_clean();
$pdf->Output("reporte_costos_utilidades_diarias.pdf","I");
