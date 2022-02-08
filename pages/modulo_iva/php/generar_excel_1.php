<?php
require_once("../../../php/config.php");
$host = DB_HOST;
$user = DB_USER;
$password = DB_PASSWORD;
$usuario = $_SESSION['nombres'] . ' ' . $_SESSION['apellidos'];
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

date_default_timezone_set('America/El_Salvador');
putenv("LANG='es_ES.UTF-8'");
setlocale(LC_ALL, 'es_ES.UTF-8');
$monthName = strftime('%B', mktime(0, 0, 0, $mes));
$monthName = ucwords($monthName);
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
            ->setCreator($usuario)
            ->setTitle('Reporte')
            ->setDescription('Reporte libro de contribuyentes')
            ->setKeywords('excel cable sat contabilidad')
            ->setCategory('Reporte');

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Hoja1");
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.5);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.25);
        if ($encabezados == 1) {
            $objPHPExcel->getActiveSheet()->mergeCells('A1:N1');
            $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(14);      //tamaño de fuente
            $objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true)->setName('ARIAL'); //Si la segunda línea está en negrita
            // establecer centro vertical
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'LIBRO O REGISTRO DE OPERACIONES CON EMISION DE CREDITOS FISCAL');
        }
        $objPHPExcel->getActiveSheet()->mergeCells('A2:N2');
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('A2:N2')->getFont()->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A2:N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('A2', $monthName . ' ' . $years . ' (VALORES EXPRESADOS EN US DOLARES)');
        $style_array = [
            'borders' => [
                'allborders' => [
                    'style' => \PHPExcel_Style_Border::BORDER_MEDIUM
                ]
            ]
        ];
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);

        $objPHPExcel->getActiveSheet()->getStyle('A3:N1000')->getFont()->setBold(false)->setName('ARIAL')->setSize(10)->getColor()->setRGB('000000');

        $objPHPExcel->getActiveSheet()->mergeCells('A3:C4');
        $objPHPExcel->getActiveSheet()->getStyle('A3:C4')->applyFromArray($style_array);

        $objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('A5', 'N°');
        $objPHPExcel->getActiveSheet()->getStyle('A5')->applyFromArray($style_array);

        $objPHPExcel->getActiveSheet()->getStyle('B5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('B5', 'FECHA DE EMISION');
        $objPHPExcel->getActiveSheet()->getStyle('B5')->applyFromArray($style_array);

        $objPHPExcel->getActiveSheet()->getStyle('C5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('C5', 'CORRELATIVO');
        $objPHPExcel->getActiveSheet()->getStyle('C5')->applyFromArray($style_array);

        $objPHPExcel->getActiveSheet()->mergeCells('D3:D5');
        $objPHPExcel->getActiveSheet()->getStyle('D3:D5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D3:D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('D3', 'N° DE FORMULARIO UNICO');
        $objPHPExcel->getActiveSheet()->getStyle('D3:D5')->applyFromArray($style_array);
        $objPHPExcel->getActiveSheet()->getStyle('D3:D5')->getAlignment()->setWrapText(true);

        $objPHPExcel->getActiveSheet()->mergeCells('E3:E4');
        $objPHPExcel->getActiveSheet()->getStyle('E3:E4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E3:E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E3:E4')->applyFromArray($style_array);

        $objPHPExcel->getActiveSheet()->getStyle('E5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('E5', 'NOMBRE DEL CLIENTE');
        $objPHPExcel->getActiveSheet()->getStyle('E5')->applyFromArray($style_array);

        $objPHPExcel->getActiveSheet()->mergeCells('F3:F5');
        $objPHPExcel->getActiveSheet()->getStyle('F3:F5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('F3:F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('F3', 'NRC');
        $objPHPExcel->getActiveSheet()->getStyle('F3:F5')->applyFromArray($style_array);
        $objPHPExcel->getActiveSheet()->getStyle('F3:F5')->getAlignment()->setWrapText(true);

        $objPHPExcel->getActiveSheet()->mergeCells('G3:M3');
        $objPHPExcel->getActiveSheet()->getStyle('G3:M3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('G3:M3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('G3', 'OPERACIONES DE VENTAS PROPIAS Y A CUENTA DE TERCEROS');
        $objPHPExcel->getActiveSheet()->getStyle('G3:M3')->applyFromArray($style_array);

        $objPHPExcel->getActiveSheet()->mergeCells('G4:I4');
        $objPHPExcel->getActiveSheet()->getStyle('G4:I4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('G4:I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('G4', 'PROPIAS');
        $objPHPExcel->getActiveSheet()->getStyle('G4:I4')->applyFromArray($style_array);

        $objPHPExcel->getActiveSheet()->getStyle('G5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('G5', 'EXENTAS');
        $objPHPExcel->getActiveSheet()->getStyle('G5')->applyFromArray($style_array);

        $objPHPExcel->getActiveSheet()->getStyle('H5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('H5', 'INTERNAS GRAVADAS');
        $objPHPExcel->getActiveSheet()->getStyle('H5')->applyFromArray($style_array);

        $objPHPExcel->getActiveSheet()->getStyle('I5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('I5', 'DEBITO FISCAL');
        $objPHPExcel->getActiveSheet()->getStyle('I5')->applyFromArray($style_array);

        $objPHPExcel->getActiveSheet()->mergeCells('J4:L4');
        $objPHPExcel->getActiveSheet()->getStyle('J4:L4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('J4:L4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('J4', 'A CUENTA DE TERCEROS');
        $objPHPExcel->getActiveSheet()->getStyle('J4:L4')->applyFromArray($style_array);

        $objPHPExcel->getActiveSheet()->getStyle('J5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('J5', 'EXENTAS');
        $objPHPExcel->getActiveSheet()->getStyle('J5')->applyFromArray($style_array);

        $objPHPExcel->getActiveSheet()->getStyle('K5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('K5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('K5', 'INTERNAS GRAVADAS');
        $objPHPExcel->getActiveSheet()->getStyle('K5')->applyFromArray($style_array);

        $objPHPExcel->getActiveSheet()->getStyle('L5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('L5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('L5', 'DEBITO FISCAL');
        $objPHPExcel->getActiveSheet()->getStyle('L5')->applyFromArray($style_array);

        $objPHPExcel->getActiveSheet()->mergeCells('M4:M5');
        $objPHPExcel->getActiveSheet()->getStyle('M4:M5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('M4:M5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('M4', 'IVA RETENIDO');
        $objPHPExcel->getActiveSheet()->getStyle('M4:M5')->applyFromArray($style_array);
        $objPHPExcel->getActiveSheet()->getStyle('M4:M5')->getAlignment()->setWrapText(true);

        $objPHPExcel->getActiveSheet()->mergeCells('N3:N5');
        $objPHPExcel->getActiveSheet()->getStyle('N3:N5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('N3:N5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('N3', 'TOTAL');
        $objPHPExcel->getActiveSheet()->getStyle('N3:N5')->applyFromArray($style_array);
        $objPHPExcel->getActiveSheet()->getStyle('N3:N5')->getAlignment()->setWrapText(true);

        $contador = 1;
        $celda = 6;
        if ($tiposComprobantes == 1) {
            $desde = $years.'-'.$mes.'-01';
            $hasta = $years.'-'.$mes.'-31';
            $sql = "SELECT *, (SELECT num_registro FROM clientes WHERE clientes.cod_cliente=tbl_cargos.codigoCliente) AS nRegistro FROM tbl_cargos WHERE fechaFactura BETWEEN '$desde' AND '$hasta' AND tipoFactura =1";
        }
        $query = $mysqli->query($sql);
        while ($datos = $query->fetch_array()) {
            $a = 'A'.$celda;
            $b = 'B'.$celda;
            $c = 'C'.$celda;
            $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->setCellValue($a, $contador);
            $objPHPExcel->getActiveSheet()->getStyle($a)->applyFromArray($style_array);

            $fechaFactura = $datos['fechaFactura']; 
            $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->setCellValue($b, $fechaFactura);
            $objPHPExcel->getActiveSheet()->getStyle($b)->applyFromArray($style_array);

            $correlativo = substr($datos['numeroFactura'],9,7); 
            $objPHPExcel->getActiveSheet()->getStyle($c)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle($c)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->setCellValue($c, $correlativo);
            $objPHPExcel->getActiveSheet()->getStyle($c)->applyFromArray($style_array);

            $celda +=1;
            $contador +=1;
        }
        
        
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download; charset='utf-8'");
        header("Content-Type: application/octet-stream; charset='utf-8'");
        header("Content-Type: application/download; charset='utf-8'");;
        header("Content-Disposition: attachment;filename=ReporteContribuyentes.xls"); //Nombre del archivo
        header("Content-Transfer-Encoding: binary ");
        // $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        // $objWriter->setOffice2003Compatibility(true);

        $objWritter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWritter->save('php://output');
        break;
}
