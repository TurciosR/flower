<?php
require('../fpdf.php');

class PDF extends FPDF
{
protected $col = 0; // Columna actual
protected $y0;      // Ordenada de comienzo de la columna

function Header()
{
	// Cabacera
	global $title;

	$this->SetFont('Arial','B',15);
	$w = $this->GetStringWidth($title)+6;
	$this->SetX((210-$w)/2);
	$this->SetDrawColor(0,80,180);
	$this->SetFillColor(230,230,0);
	$this->SetTextColor(220,50,50);
	$this->SetLineWidth(1);
	$this->Cell($w,9,$title,1,1,'C',true);
	$this->Ln(10);
	// Guardar ordenada
	$this->y0 = $this->GetY();
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
    $this->Cell(0,10,utf8_decode('Página. ').$this->PageNo(),0,0,'C');
}


function SetCol($col)
{
	// Establecer la posicion de una columna dada
	$this->col = $col;
	$x = 10+$col*65;
	$this->SetLeftMargin($x);
	$this->SetX($x);
}

function AcceptPageBreak()
{
	// Motodo que acepta o no el salto automatico de pagina
	if($this->col<2)
	{
		// Ir a la siguiente columna
		$this->SetCol($this->col+1);
		// Establecer la ordenada al principio
		$this->SetY($this->y0);
		// Seguir en esta pagina
		return false;
	}
	else
	{
		// Volver a la primera columna
		$this->SetCol(0);
		// Salto de pagina
		return true;
	}
}

function ChapterTitle($num, $label)
{
	// Titulo
	$this->SetFont('Arial','',12);
	$this->SetFillColor(200,220,255);
	$this->Cell(0,6,"Capitulo $num : $label",0,1,'L',true);
	$this->Ln(4);
	// Guardar ordenada
	$this->y0 = $this->GetY();
}

function ChapterBody($file)
{
	// Abrir fichero de texto
	$txt = file_get_contents($file);
	// Fuente
	$this->SetFont('Times','',12);
	// Imprimir texto en una columna de 6 cm de ancho
	$this->MultiCell(60,5,$txt);
	$this->Ln();

}

function PrintChapter($num, $title, $file)
{
	// Add capitulo
	$this->AddPage();
	$this->ChapterTitle($num,$title);
	$this->ChapterBody($file);
}
function printImage()
{
	# code...
	//Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])
	$this->Image('logo.png',null,null,60,0,'PNG');
}
function end()
{
	# code...
	// Cita en italica
	$this->SetFont('','I');
	$this->Cell(0,5,'(fin del extracto)');
	// Volver a la primera columna
	$this->SetCol(0);

}
}

$pdf = new PDF();
$title = '20000 Leguas de Viaje Submarino';
$pdf->SetTitle($title);
$pdf->SetAuthor('Julio Verne');
$pdf->PrintChapter(377,'Ejecucion','tate.txt');
$pdf->printImage();
$pdf->ChapterBody('20k_c1.txt');
$pdf->end();
$pdf->PrintChapter(2,'LOS PROS Y LOS CONTRAS','20k_c2.txt');
$pdf->Output('I','Generate.pdf',true);
?>
