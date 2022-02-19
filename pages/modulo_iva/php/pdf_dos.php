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
if($detallado == 1){
    if ($tiposComprobantes == 1) {
        $desde = $years . '-' . $mes . '-01';
        $hasta = $years . '-' . $mes . '-31';
        $desde = date('Y-m-d', strtotime($desde));
        $hasta = date('Y-m-d', strtotime($hasta));
        $sql = "SELECT * FROM tbl_cargos WHERE fechaFactura BETWEEN $desde AND $hasta AND tipoFactura = 2 AND anulada=0";
    }
    $contador = 1;
    $contador2 = 1;
    $query = $mysqli->query($sql);

    while($datos = $query->fetch_Array()){
        $pdf->SetFont('Times', '', 8);
        $pdf->Cell(5,1,utf8_decode(date("d", strtotime($result['fechaFactura']))),0,0,'L');
    }
}
$pdf->Output();