<?php
require '../../../pdfs/fpdf.php';

define("titulo", $encabezados);
define("numeros", $numerodePagina);
define("mes", $monthName);
define("año", $years);
setlocale(LC_MONETARY, 'es_SV');
class PDF extends FPDF{
    // Cabecera de página
    function Header()
    {
        if (titulo == 1) {
            // Arial bold 15
            $this->SetFont('Times', 'B', 12);
            // Título
            $this->Cell(200, 6, utf8_decode('LIBRO O REGISTRO DE OPERACIONES CON EMISION DE FACTURAS'), 0, 0, 'C');
            // Salto de línea
            $this->Ln(5);
            $this->Cell(200, 6, utf8_decode(mes . " " . año . " (VALORES EXPRESADOS EN US DOLARES)"), 0, 0, 'C');
            $this->Ln(10);
        } else {
            $this->Ln(15);
        }
    }

    // Pie de página
    function Footer()
    {
        if (numeros == 1) {
            $this->SetY(-15);
            $this->SetFont('Times', 'B', 10);
            // Número de página
            $this->Cell(250, 6, utf8_decode("Página " . str_pad($this->pageNo(), 2, "0", STR_PAD_LEFT)), 0, 1, 'R');
        }
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage("", 'Letter');
$pdf->SetFont('Times', '', 10);
include('encabezado_tabla2.php');
$pdf->Output();