<?php
require '../../../pdfs/fpdf.php';
if(!isset($_SESSION))
{
    session_start();
}

date_default_timezone_set('America/El_Salvador');
$fecha = date('Y-m-d');
    $pdf = new FPDF();

    
   
    $pdf->AddPage('P','Letter');
       
    $pdf->Image('../../../images/contrato/contratoA2.jpg',3,3,210, 270);
 


        $pdf->AddPage('P','Letter');

       
       $pdf->Image('../../../images/contrato/contratoA2-1.jpg',3,3,210, 270);
       $pdf->Ln(-5);
        $pdf->SetFont('ARIAL','',9);
        $pdf->Cell(10,6,utf8_decode('COPIA'),0,0,'L');

    $pdf->Output();

contratoInterDigitalPosterior();


?>
