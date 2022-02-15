<?php 
    //FILA 1
    $pdf->Cell(50, 6, utf8_decode(''), "TLR", 0, 'C');
    $pdf->SetFont('Times', 'B', 5);
    $pdf->Cell(15, 6, utf8_decode('N° DE'), "T", 0, 'C');
    $pdf->SetFont('Times', 'B', 6);
    $pdf->Cell(60, 6, utf8_decode(''), "TLR", 0, 'C');
    $pdf->Cell(15, 6, utf8_decode(''), 'TLR', 0, 'C');
    $pdf->Cell(110, 6, utf8_decode('OPERACIONES DE VENTAS PROPIAS Y A CUENTA DE TERCEROS'), 'TBLR', 0, 'C');
    $pdf->Cell(15, 6, utf8_decode(''), 'TLR', 1, 'C');
    //FILA 2
    $pdf->Cell(50, 6, utf8_decode(''), "LR", 0, 'C');
    $pdf->SetFont('Times', 'B', 5);
    $pdf->Cell(15, 6, utf8_decode('FORMULARIO'), "LR", 0, 'C');
    $pdf->SetFont('Times', 'B', 6);
    $pdf->Cell(60, 6, utf8_decode(''), "LR", 0, 'C');
    $pdf->Cell(15, 6, utf8_decode(''), 'LR', 0, 'C');
    $pdf->Cell(47.5, 6, utf8_decode('PROPIAS'), "LRTB", 0, 'C');
    $pdf->Cell(47.5, 6, utf8_decode('A CUENTA DE TERCEROS'), 1, 0, 'C');
    $pdf->Cell(15, 6, utf8_decode('IVA'), "TLR", 0, 'C');
    $pdf->Cell(15, 6, utf8_decode('TOTAL'), 'LR', 1, 'C');
    //FILA 3
    $pdf->SetFont('Times', 'B', 5);
    $pdf->Cell(10, 6, utf8_decode('N°'), 1, 0, 'C');
    $pdf->SetFont('Times', 'B', 4.5);
    $pdf->Cell(20, 6, utf8_decode('FECHA DE EMISION'), 1, 0, 'C');
    $pdf->SetFont('Times', 'B', 4.5);
    $pdf->Cell(20, 6, utf8_decode('CORRELATIVO'), 1, 0, 'C');
    $pdf->SetFont('Times', 'B', 5);
    $pdf->Cell(15, 6, utf8_decode('UNICO'), "BLR", 0, 'C');
    $pdf->SetFont('Times', 'B', 5);
    $pdf->Cell(60, 6, utf8_decode('NOMBRE DEL CLIENTE'), 1, 0, 'C');
    $pdf->Cell(15, 6, utf8_decode('NRC'), 'LRB', 0, 'C');
    $pdf->SetFont('Times', 'B', 4.5);
    $pdf->Cell(12.5, 6, utf8_decode('EXENTAS'), "BLR", 0, 'C');
    $pdf->Cell(20, 6, utf8_decode('INTERNAS GRAVADAS'), 1, 0, 'C');
    $pdf->Cell(15, 6, utf8_decode('DÉBITO FISCAL'), 1, 0, 'C');
    $pdf->SetFont('Times', 'B', 4.5);
    $pdf->Cell(10, 6, utf8_decode('EXENTAS'), "BLR", 0, 'C');
    $pdf->Cell(20, 6, utf8_decode('INTERNAS GRAVADAS'), 1, 0, 'C');
    $pdf->Cell(17.5, 6, utf8_decode('DÉBITO FISCAL'), 1, 0, 'C');
    $pdf->SetFont('Times', 'B', 5);
    $pdf->Cell(15, 6, utf8_decode('RETENIDO'), "BLR", 0, 'C');
    $pdf->Cell(15, 6, utf8_decode(''), 'BLR', 1, 'C');
?>