<?php
//SECCION PARA REPORTE EN EXCEL
require '../PHPExcel/Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()
    ->setCreator($usuario)
    ->setTitle('Reporte')
    ->setDescription('Reporte libro de consumidor final')
    ->setKeywords('excel cable sat contabilidad')
    ->setCategory('Reporte');

$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle("Hoja1");
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.5);
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.25);
if ($encabezados == 1) {
    $objPHPExcel->getActiveSheet()->mergeCells('A1:J1');
    $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(12);      //tamaño de fuente
    $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true)->setName('ARIAL'); //Si la segunda línea está en negrita
    // establecer centro vertical
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'LIBRO O REGISTRO DE OPERACIONES CON EMISION DE FACTURAS');
}
$objPHPExcel->getActiveSheet()->mergeCells('A2:J2');
$objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getStyle('A2:J2')->getFont()->setBold(true)->setName('ARIAL');
$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A2:J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->setCellValue('A2', $monthName . ' ' . $years . ' (VALORES EXPRESADOS EN US DOLARES)');

header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download; charset='utf-8'");
header("Content-Type: application/octet-stream; charset='utf-8'");
header("Content-Type: application/download; charset='utf-8'");;
header("Content-Disposition: attachment;filename=ReporteConsumidor.xls"); //Nombre del archivo
header("Content-Transfer-Encoding: binary ");
// $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
// $objWriter->setOffice2003Compatibility(true);

$objWritter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWritter->save('php://output');