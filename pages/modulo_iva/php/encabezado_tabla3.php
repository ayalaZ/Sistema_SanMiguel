<?php


function celdas($datos){
    $objPHPExcel = new PHPExcel();
    $style_array = [
        'borders' => [
            'allborders' => [
                'style' => \PHPExcel_Style_Border::BORDER_MEDIUM
            ]
        ]
    ];
    $objPHPExcel->getActiveSheet()->getStyle($datos)->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
    $objPHPExcel->getActiveSheet()->getStyle($datos)->applyFromArray($style_array);

    $objPHPExcel->getActiveSheet()->getStyle($datos)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle($datos)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
}

celdas('A3:B4');

$objPHPExcel->getActiveSheet()->setCellValue('A3', '');
