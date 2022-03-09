<?php
//FILA 1
$pdf->Cell(25,6,utf8_decode(''),"TL",0,'C');
$pdf->SetFont('Times','B',5);
$pdf->SetFont('Times','B',10);
$pdf->Cell(75,6,utf8_decode(''),"TR",0,'C');
$pdf->Cell(60,6,utf8_decode('VENTAS'),1,0,'C');
$pdf->Cell(40,6,utf8_decode(''),"TLR",1,'C');

//FILA 2
$pdf->Cell(25,6,utf8_decode(''),"L",0,'C');
$pdf->SetFont('Times','B',5);
$pdf->SetFont('Times','B',10);
$pdf->Cell(75,6,utf8_decode(''),"R",0,'C');
$pdf->Cell(20,6,utf8_decode(''),"LRT",0,'C');
$pdf->Cell(40,6,utf8_decode('GRAVADAS'),1,0,'C');
$pdf->Cell(40,6,utf8_decode(''),"BLR",1,'C');

//FILA 3
$pdf->SetFont('Times','B',5);
$pdf->Cell(5,6,utf8_decode('DIA'),1,0,'C');
$pdf->SetFont('Times','B',7);
$pdf->Cell(30,6,utf8_decode('DEL N° DE FACTURA'),1,0,'C');
$pdf->Cell(30,6,utf8_decode('AL N° DE FACTURA'),1,0,'C');
$pdf->Cell(35,6,utf8_decode('N° CAJA REGISTRADORA'),1,0,'C');
$pdf->Cell(20,6,utf8_decode('EXENTAS'),"BLR",0,'C');
$pdf->Cell(20,6,utf8_decode('LOCALES'),1,0,'C');
$pdf->Cell(20,6,utf8_decode('EXPORTACION'),1,0,'C');
$pdf->SetFont('Times','B',5);
$pdf->Cell(15,6,utf8_decode('SUB-TOTAL'),1,0,'C');
$pdf->Cell(10,6,utf8_decode('CESC'),1,0,'C');
$pdf->SetFont('Times','B',4);
$pdf->Cell(15,6,utf8_decode('VENTAS TOTALES'),1,1,'C');
$pdf->SetFont('Times','B',5);
$pdf->ln(2);
