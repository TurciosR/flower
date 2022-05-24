<?php
require('fpdf.php');

class PDF extends FPDF
{
  // Cabecera de página
  function Header()
  {
      // Logo
      $this->Image('tutorial/logo.png',10,8,33);
      // Arial bold 15
      $this->SetFont('Arial','B',15);
      // Movernos a la derecha
      $this->Cell(80);
      // Título
      $this->Cell(30,10,'Title',1,0,'C');
      // Salto de línea
      $this->Ln(20);
  }
  function Footer()
  {
      // Posición a 1,5 cm del final
      $this->SetY(-15);
      // Arial itálica 8
      $this->SetFont('Arial','I',8);
      // Color del texto en gris
      $this->SetTextColor(128);
      // Número de página
      //utf8_decode() de php que convierte nuestros caracteres a ISO-8859-1
      $this->Cell(0,10,utf8_decode('Página ').$this->PageNo(),0,0,'C');
  }
}

$pdf = new PDF('P','mm','letter');
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->Cell(40,10,'Hola, Mundo!');
$pdf->AddPage();
$pdf->SetFont('Times','BI',14);
$pdf->Cell(40,10,'Hola, Mundo!');
$pdf->Output();

 ?>
