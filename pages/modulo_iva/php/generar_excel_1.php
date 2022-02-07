<?php

use PhpOffice\PhpSpreadsheet\Calculation\TextData\Concatenate;

require_once("../../../php/config.php");
$host = DB_HOST;
$user = DB_USER;
$password = DB_PASSWORD;

if (!isset($_SESSION)) {
    session_start([
        'cookie_lifetime' => 86400,
    ]);
}

$database = $_SESSION['db'];
$mysqli = new mysqli($host, $user, $password, $database);

$puntoVenta = $_POST['puntoVentaGenerar'];
$mes = $_POST['mesGenerar'];
$years = $_POST['anoGenerar'];
if (!empty($_POST['encabezados'])) {
    $encabezados = 1;
} else {
    $encabezados = 0;
}
if (!empty($_POST['numPag'])) {
    $numerodePagina = 1;
} else {
    $numerodePagina = 0;
}
if (!empty($_POST['libroDetallado'])) {
    $detallado = 1;
} else {
    $detallado = 0;
}
$tiposComprobantes = $_POST['facturas'];
$documento = $_POST['documento'];

switch ($documento) {
    case '1':
        # code...
        break;
    case '2':
        //SECCION PARA REPORTE EN EXCEL
        require '../PHPExcel/Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()
        ->setCreator('Zenon Ayala')
        ->setTitle('Excel en PHP')
        ->setDescription('Documento de prueba')
        ->setKeywords('excel cable sat contabilidad')
        ->setCategory('Ejemplo');
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Hoja1");
        $objPHPExcel->getActiveSheet()->setCellValue('A1','documento de prueba');
        $objPHPExcel->getActiveSheet()->setCellValue('A2',123.50);
        $objPHPExcel->getActiveSheet()->setCellValue('A3',TRUE);
        $objPHPExcel->getActiveSheet()->setCellValue('A4','=CONCATENATE(A1," ",A2)');

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment:filename="ReporteContribuyentes.xls"');
        header('Cache-Control: max-age=0');

        $objWritter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
        $objWritter->save('php://output');
        break;
}
