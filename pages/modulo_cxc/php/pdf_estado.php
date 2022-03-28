<?php
require '../../../pdfs/fpdf.php';

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
            $this->SetFont('Arial','',7);
            $this->Cell(260,6,utf8_decode("Página ".str_pad($this->pageNo(),4,"0",STR_PAD_LEFT)),0,1,'R');
            $this->Cell(260,4,utf8_decode("GENERADO POR: ".strtoupper($_SESSION['nombres'])." ".strtoupper($_SESSION['apellidos']). " ".date('d/m/Y h:i:s')),"",1,'R');
            $this->Image('../../../images/logo.png',10,10, 20, 18);
    }

    // Pie de página
    function Footer()
    {
            $this->SetY(-15);
            $this->SetFont('Times', 'B', 10);
            // Número de página
            $this->Cell(250, 6, utf8_decode("Página " . str_pad($this->pageNo(), 2, "0", STR_PAD_LEFT)), 0, 1, 'R');
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage("L", 'Letter');
$pdf->SetFont('Times', '', 12);
$pdf->Cell(260, 6, utf8_decode(" (VALORES EXPRESADOS EN US DOLARES)"), 0, 0, 'C');
$pdf->Ln(5);
$pdf->SetFont('Times', '', 10);