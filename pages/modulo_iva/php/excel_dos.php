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
$style_array = [
    'borders' => [
        'allborders' => [
            'style' => \PHPExcel_Style_Border::BORDER_MEDIUM
        ]
    ]
];
$style2_array = [
    'borders' => [
        'bottom' => [
            'style' => \PHPExcel_Style_Border::BORDER_MEDIUM
        ]
    ]
];
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(45);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);

$objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(8)->setBold(false)->setName('ARIAL');
$objPHPExcel->getActiveSheet()->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getDefaultStyle()->getAlignment()->setWrapText(true);



if ($detallado == 1) {
    $objPHPExcel->getActiveSheet()->getStyle('A3:B4')->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->mergeCells('A3:B4');
    $objPHPExcel->getActiveSheet()->setCellValue('A3', '');

    $objPHPExcel->getActiveSheet()->getStyle('A5')->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->setCellValue('A5', 'DIA');

    $objPHPExcel->getActiveSheet()->getStyle('B5')->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->setCellValue('B5', 'N° DE FACTURA');

    $objPHPExcel->getActiveSheet()->getStyle('C3:C5')->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->mergeCells('C3:C5');
    $objPHPExcel->getActiveSheet()->setCellValue('C3', 'N° DE FORMULARIO UNICO');

    $objPHPExcel->getActiveSheet()->getStyle('D3:D4')->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->mergeCells('D3:D4');
    $objPHPExcel->getActiveSheet()->setCellValue('D3', '');

    $objPHPExcel->getActiveSheet()->getStyle('D5')->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->setCellValue('D5', 'NOMBRE DEL CLIENTE');

    $objPHPExcel->getActiveSheet()->getStyle('E3:G3')->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->mergeCells('E3:G3');
    $objPHPExcel->getActiveSheet()->setCellValue('E3', 'VENTAS');

    $objPHPExcel->getActiveSheet()->getStyle('E4:E5')->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->mergeCells('E4:E5');
    $objPHPExcel->getActiveSheet()->setCellValue('E4', 'EXENTAS');

    $objPHPExcel->getActiveSheet()->getStyle('F4:G4')->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->mergeCells('F4:G4');
    $objPHPExcel->getActiveSheet()->setCellValue('F4', 'GRAVADAS');

    $objPHPExcel->getActiveSheet()->getStyle('F5')->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->setCellValue('F5', 'LOCALES');

    $objPHPExcel->getActiveSheet()->getStyle('G5')->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->setCellValue('G5', 'SERVICIO');

    $objPHPExcel->getActiveSheet()->getStyle('H3:J4')->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->mergeCells('H3:J4');
    $objPHPExcel->getActiveSheet()->setCellValue('H3', '');

    $objPHPExcel->getActiveSheet()->getStyle('H5')->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->setCellValue('H5', 'SUB-TOTAL');

    $objPHPExcel->getActiveSheet()->getStyle('I5')->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->setCellValue('I5', 'CESC');

    $objPHPExcel->getActiveSheet()->getStyle('J5')->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->setCellValue('J5', 'VENTAS TOTALES');
    switch ($tiposComprobantes) {
        case '1':
            $desde = $years . '-' . $mes . '-01';
            if ($mes == 2) {
                $hasta = $years . '-' . $mes . '-28';
            } else {
                $hasta = $years . '-' . $mes . '-31';
            }
            $desde = date('Y-m-d', strtotime($desde));
            $hasta = date('Y-m-d', strtotime($hasta));
            $sql = "SELECT * FROM tbl_cargos WHERE fechaFactura BETWEEN '$desde' AND '$hasta' AND tipoFactura = 2 AND anulada=0;";
            $contador = 1;
            $contador2 = 1;
            $query = $mysqli->query($sql);
            $celda = 6;
            while ($datos = $query->fetch_Array()) {
                if ($datos["tipoServicio"] == "C") {
                    $montoCancelado = doubleval($datos["cuotaCable"]);
                    $tipoServ = 'CABLE';
                } elseif ($datos["tipoServicio"] == "I") {
                    $montoCancelado = doubleval($datos["cuotaInternet"]);
                    $tipoServ = 'INTERNET';
                }
                $a = 'A' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($a)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($a, date("d", strtotime($datos['fechaFactura'])));

                $b = 'B' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($b)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($b, $datos['numeroFactura']);

                $c = 'C' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($c)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($c, '0');

                $d = 'D' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($d)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($d, $datos["nombre"]);

                if ($ex->isExento($datos["codigoCliente"])) {
                    $e = 'E' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($e)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($e, $montoCancelado);
                    $objPHPExcel->getActiveSheet()->getStyle($e)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                    $f = 'F' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($f)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($f, '0');
                    $objPHPExcel->getActiveSheet()->getStyle($f)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                    $g = 'G' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($g)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($g, $tipoServ);
                    $total1 = $total1 + $montoCancelado;
                    $total2 = $total2 + 0;
                } else {
                    $e = 'E' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($e)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($e, '0');
                    $objPHPExcel->getActiveSheet()->getStyle($e)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                    $f = 'F' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($f)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($f, $montoCancelado);
                    $objPHPExcel->getActiveSheet()->getStyle($f)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                    $g = 'G' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($g)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($g, $tipoServ);
                    $total1 = $total1 + 0;
                    $total2 = $total2 + $montoCancelado;
                }
                $h = 'H' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($h)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($h, $montoCancelado);
                $objPHPExcel->getActiveSheet()->getStyle($h)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                $i = 'I' . $celda;
                $impuesto = $datos["totalImpuesto"];
                $objPHPExcel->getActiveSheet()->getStyle($i)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($i, $impuesto);
                $objPHPExcel->getActiveSheet()->getStyle($i)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                $j = 'J' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($j)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($j, $montoCancelado + $impuesto);
                $objPHPExcel->getActiveSheet()->getStyle($j)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                $total3 = $total3 + $montoCancelado;
                $total4 = $total4 + $impuesto;
                $total5 = $total5 + $montoCancelado + $impuesto;

                $celda += 1;
            }
            break;
        case '2':
            $desde = $years . '-' . $mes . '-01';
            if ($mes == 2) {
                $hasta = $years . '-' . $mes . '-28';
            } else {
                $hasta = $years . '-' . $mes . '-31';
            }
            $desde = date('Y-m-d', strtotime($desde));
            $hasta = date('Y-m-d', strtotime($hasta));
            $sql = "SELECT * FROM tbl_ventas_manuales WHERE fechaComprobante BETWEEN '$desde' AND '$hasta' AND tipoComprobante = 2 ORDER BY idVenta ASC";
            $contador = 1;
            $contador2 = 1;
            $query = $mysqli->query($sql);
            $celda = 6;
            while ($datos = $query->fetch_Array()) {
                if ($datos["montoCable"] > 0 && is_numeric($datos["montoCable"])) {
                    $tipoServ = 'CABLE';
                    $montoCancelado = doubleval($datos["montoCable"]);
                } elseif ($datos["montoInternet"] > 0 && is_numeric($datos["montoInternet"])) {
                    $tipoServ = 'INTERNET';
                    $montoCancelado = doubleval($datos["montoInternet"]);
                } else {
                    $montoCancelado = 0;
                }
                $a = 'A' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($a)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($a, date("d", strtotime($datos['fechaComprobante'])));

                $b = 'B' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($b)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($b, $datos['prefijo'] . $datos['numeroComprobante']);

                $c = 'C' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($c)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($c, '0');

                $d = 'D' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($d)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($d, $datos["nombreCliente"]);

                if ($ex->isExento($datos["codigoCliente"])) {
                    $e = 'E' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($e)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($e, $montoCancelado);
                    $objPHPExcel->getActiveSheet()->getStyle($e)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                    $f = 'F' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($f)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($f, '0');
                    $objPHPExcel->getActiveSheet()->getStyle($f)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                    $g = 'G' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($g)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($g, $tipoServ);
                    $total1 = $total1 + $montoCancelado;
                    $total2 = $total2 + 0;
                } else {
                    $e = 'E' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($e)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($e, '0');
                    $objPHPExcel->getActiveSheet()->getStyle($e)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                    $f = 'F' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($f)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($f, $montoCancelado);
                    $objPHPExcel->getActiveSheet()->getStyle($f)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                    $g = 'G' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($g)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($g, $tipoServ);
                    $total1 = $total1 + 0;
                    $total2 = $total2 + $montoCancelado;
                }
                $h = 'H' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($h)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($h, $montoCancelado);
                $objPHPExcel->getActiveSheet()->getStyle($h)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                $i = 'I' . $celda;
                $impuesto = $datos["impuesto"];
                $objPHPExcel->getActiveSheet()->getStyle($i)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($i, $datos["impuesto"]);
                $objPHPExcel->getActiveSheet()->getStyle($i)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                $j = 'J' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($j)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($j, $montoCancelado + $impuesto);
                $objPHPExcel->getActiveSheet()->getStyle($j)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                $total3 = $total3 + $montoCancelado;
                $total4 = $total4 + $impuesto;
                $total5 = $total5 + $montoCancelado + $impuesto;

                $celda += 1;
            }
            break;
        case '3':
            $desde = $years . '-' . $mes . '-01';
            if ($mes == 2) {
                $hasta = $years . '-' . $mes . '-28';
            } else {
                $hasta = $years . '-' . $mes . '-31';
            }
            $desde = date('Y-m-d', strtotime($desde));
            $hasta = date('Y-m-d', strtotime($hasta));
            $sql = "SELECT * FROM tbl_ventas_anuladas WHERE fechaComprobante BETWEEN '$desde' AND '$hasta' AND tipoComprobante = 2 ORDER BY numeroComprobante ASC";
            $contador = 1;
            $contador2 = 1;
            $query = $mysqli->query($sql);
            $celda = 6;
            while ($datos = $query->fetch_Array()) {
                if ($datos["totalComprobante"] > 0 && is_numeric($datos["totalComprobante"])) {
                    $montoCancelado = doubleval($datos["totalComprobante"]);
                } else {
                    $montoCancelado = 0;
                }
                if ($datos["tipoServicio"] == 'C') {
                    $tipoServ = 'CABLE';
                } else {
                    $tipoServ = 'INTERNET';
                }
                $a = 'A' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($a)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($a, date("d", strtotime($datos['fechaComprobante'])));

                $b = 'B' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($b)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($b, $datos['prefijo'] . $datos['numeroComprobante']);

                $c = 'C' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($c)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($c, '0');

                $d = 'D' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($d)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($d, $datos["nombreCliente"]);

                if ($ex->isExento($datos["codigoCliente"])) {
                    $e = 'E' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($e)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($e, $montoCancelado);
                    $objPHPExcel->getActiveSheet()->getStyle($e)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                    $f = 'F' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($f)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($f, '0');
                    $objPHPExcel->getActiveSheet()->getStyle($f)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                    $g = 'G' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($g)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($g, $tipoServ);
                    $total1 = $total1 + $montoCancelado;
                    $total2 = $total2 + 0;
                } else {
                    $e = 'E' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($e)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($e, '0');
                    $objPHPExcel->getActiveSheet()->getStyle($e)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                    $f = 'F' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($f)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($f, $montoCancelado);
                    $objPHPExcel->getActiveSheet()->getStyle($f)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                    $g = 'G' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($g)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($g, $tipoServ);
                    $total1 = $total1 + 0;
                    $total2 = $total2 + $montoCancelado;
                }
                $h = 'H' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($h)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($h, $montoCancelado);
                $objPHPExcel->getActiveSheet()->getStyle($h)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                $i = 'I' . $celda;
                if ($datos['impuesto'] == NULL) {
                    $impuesto = 0;
                } else {
                    $impuesto = $datos['impuesto'];
                }
                $objPHPExcel->getActiveSheet()->getStyle($i)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($i, $impuesto);
                $objPHPExcel->getActiveSheet()->getStyle($i)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                $j = 'J' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($j)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($j, $montoCancelado + $impuesto);
                $objPHPExcel->getActiveSheet()->getStyle($j)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                $total3 = $total3 + $montoCancelado;
                $total4 = $total4 + $impuesto;
                $total5 = $total5 + $montoCancelado + $impuesto;

                $celda += 1;
            }
            break;
        case '4':
            $desde = $years . '-' . $mes . '-01';
            if ($mes == 2) {
                $hasta = $years . '-' . $mes . '-28';
            } else {
                $hasta = $years . '-' . $mes . '-31';
            }
            $desde = date('Y-m-d', strtotime($desde));
            $hasta = date('Y-m-d', strtotime($hasta));
            $sql = "SELECT * FROM tbl_cargos WHERE fechaFactura BETWEEN '$desde' AND '$hasta' AND tipoFactura = 2 AND anulada=0;";
            $contador = 1;
            $contador2 = 1;
            $query = $mysqli->query($sql);
            $celda = 6;
            while ($datos = $query->fetch_Array()) {
                if ($datos["tipoServicio"] == "C") {
                    $montoCancelado = doubleval($datos["cuotaCable"]);
                    $tipoServ = 'CABLE';
                } elseif ($datos["tipoServicio"] == "I") {
                    $montoCancelado = doubleval($datos["cuotaInternet"]);
                    $tipoServ = 'INTERNET';
                }
                $a = 'A' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($a)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($a, date("d", strtotime($datos['fechaFactura'])));

                $b = 'B' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($b)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($b, $datos['numeroFactura']);

                $c = 'C' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($c)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($c, '0');

                $d = 'D' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($d)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($d, $datos["nombre"]);

                if ($ex->isExento($datos["codigoCliente"])) {
                    $e = 'E' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($e)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($e, $montoCancelado);
                    $objPHPExcel->getActiveSheet()->getStyle($e)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                    $f = 'F' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($f)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($f, '0');
                    $objPHPExcel->getActiveSheet()->getStyle($f)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                    $g = 'G' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($g)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($g, $tipoServ);
                    $total1 = $total1 + $montoCancelado;
                    $total2 = $total2 + 0;
                } else {
                    $e = 'E' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($e)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($e, '0');
                    $objPHPExcel->getActiveSheet()->getStyle($e)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                    $f = 'F' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($f)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($f, $montoCancelado);
                    $objPHPExcel->getActiveSheet()->getStyle($f)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                    $g = 'G' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($g)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($g, $tipoServ);
                    $total1 = $total1 + 0;
                    $total2 = $total2 + $montoCancelado;
                }
                $h = 'H' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($h)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($h, $montoCancelado);
                $objPHPExcel->getActiveSheet()->getStyle($h)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                $i = 'I' . $celda;
                $impuesto = $datos["totalImpuesto"];
                $objPHPExcel->getActiveSheet()->getStyle($i)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($i, $impuesto);
                $objPHPExcel->getActiveSheet()->getStyle($i)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                $j = 'J' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($j)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($j, $montoCancelado + $impuesto);
                $objPHPExcel->getActiveSheet()->getStyle($j)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                $total3 = $total3 + $montoCancelado;
                $total4 = $total4 + $impuesto;
                $total5 = $total5 + $montoCancelado + $impuesto;

                $celda += 1;
            }
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            $desde = $years . '-' . $mes . '-01';
            if ($mes == 2) {
                $hasta = $years . '-' . $mes . '-28';
            } else {
                $hasta = $years . '-' . $mes . '-31';
            }
            $desde = date('Y-m-d', strtotime($desde));
            $hasta = date('Y-m-d', strtotime($hasta));
            $sql = "SELECT * FROM tbl_ventas_manuales WHERE fechaComprobante BETWEEN '$desde' AND '$hasta' AND tipoComprobante = 2 ORDER BY idVenta ASC";
            $contador = 1;
            $contador2 = 1;
            $query = $mysqli->query($sql);
            while ($datos = $query->fetch_Array()) {
                if ($datos["montoCable"] > 0 && is_numeric($datos["montoCable"])) {
                    $tipoServ = 'CABLE';
                    $montoCancelado = doubleval($datos["montoCable"]);
                } elseif ($datos["montoInternet"] > 0 && is_numeric($datos["montoInternet"])) {
                    $tipoServ = 'INTERNET';
                    $montoCancelado = doubleval($datos["montoInternet"]);
                } else {
                    $montoCancelado = 0;
                }
                $a = 'A' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($a)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($a, date("d", strtotime($datos['fechaComprobante'])));

                $b = 'B' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($b)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($b, $datos['prefijo'] . $datos['numeroComprobante']);

                $c = 'C' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($c)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($c, '0');

                $d = 'D' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($d)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($d, $datos["nombreCliente"]);

                if ($ex->isExento($datos["codigoCliente"])) {
                    $e = 'E' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($e)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($e, $montoCancelado);
                    $objPHPExcel->getActiveSheet()->getStyle($e)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                    $f = 'F' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($f)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($f, '0');
                    $objPHPExcel->getActiveSheet()->getStyle($f)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                    $g = 'G' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($g)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($g, $tipoServ);
                    $total1 = $total1 + $montoCancelado;
                    $total2 = $total2 + 0;
                } else {
                    $e = 'E' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($e)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($e, '0');
                    $objPHPExcel->getActiveSheet()->getStyle($e)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                    $f = 'F' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($f)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($f, $montoCancelado);
                    $objPHPExcel->getActiveSheet()->getStyle($f)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                    $g = 'G' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($g)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($g, $tipoServ);
                    $total1 = $total1 + 0;
                    $total2 = $total2 + $montoCancelado;
                }
                $h = 'H' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($h)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($h, $montoCancelado);
                $objPHPExcel->getActiveSheet()->getStyle($h)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                $i = 'I' . $celda;
                $impuesto = $datos["impuesto"];
                $objPHPExcel->getActiveSheet()->getStyle($i)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($i, $datos["impuesto"]);
                $objPHPExcel->getActiveSheet()->getStyle($i)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                $j = 'J' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($j)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($j, $montoCancelado + $impuesto);
                $objPHPExcel->getActiveSheet()->getStyle($j)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                $total3 = $total3 + $montoCancelado;
                $total4 = $total4 + $impuesto;
                $total5 = $total5 + $montoCancelado + $impuesto;

                $celda += 1;
            }
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            $desde = $years . '-' . $mes . '-01';
            if ($mes == 2) {
                $hasta = $years . '-' . $mes . '-28';
            } else {
                $hasta = $years . '-' . $mes . '-31';
            }
            $desde = date('Y-m-d', strtotime($desde));
            $hasta = date('Y-m-d', strtotime($hasta));
            $sql = "SELECT * FROM tbl_ventas_anuladas WHERE fechaComprobante BETWEEN '$desde' AND '$hasta' AND tipoComprobante = 2 ORDER BY numeroComprobante ASC";
            $contador = 1;
            $contador2 = 1;
            $query = $mysqli->query($sql);
            while ($datos = $query->fetch_Array()) {
                if ($datos["totalComprobante"] > 0 && is_numeric($datos["totalComprobante"])) {
                    $montoCancelado = doubleval($datos["totalComprobante"]);
                } else {
                    $montoCancelado = 0;
                }
                if ($datos["tipoServicio"] == 'C') {
                    $tipoServ = 'CABLE';
                } else {
                    $tipoServ = 'INTERNET';
                }
                $a = 'A' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($a)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($a, date("d", strtotime($datos['fechaComprobante'])));

                $b = 'B' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($b)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($b, $datos['prefijo'] . $datos['numeroComprobante']);

                $c = 'C' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($c)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($c, '0');

                $d = 'D' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($d)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($d, $datos["nombreCliente"]);

                if ($ex->isExento($datos["codigoCliente"])) {
                    $e = 'E' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($e)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($e, $montoCancelado);
                    $objPHPExcel->getActiveSheet()->getStyle($e)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                    $f = 'F' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($f)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($f, '0');
                    $objPHPExcel->getActiveSheet()->getStyle($f)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                    $g = 'G' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($g)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($g, $tipoServ);
                    $total1 = $total1 - $montoCancelado;
                    $total2 = $total2 - 0;
                } else {
                    $e = 'E' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($e)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($e, '0');
                    $objPHPExcel->getActiveSheet()->getStyle($e)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                    $f = 'F' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($f)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($f, $montoCancelado);
                    $objPHPExcel->getActiveSheet()->getStyle($f)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                    $g = 'G' . $celda;
                    $objPHPExcel->getActiveSheet()->getStyle($g)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue($g, $tipoServ);
                    $total1 = $total1 - 0;
                    $total2 = $total2 - $montoCancelado;
                }
                $h = 'H' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($h)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($h, $montoCancelado);
                $objPHPExcel->getActiveSheet()->getStyle($h)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                $i = 'I' . $celda;
                if ($datos['impuesto'] == NULL) {
                    $impuesto = 0;
                } else {
                    $impuesto = $datos['impuesto'];
                }
                $objPHPExcel->getActiveSheet()->getStyle($i)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($i, $impuesto);
                $objPHPExcel->getActiveSheet()->getStyle($i)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                $j = 'J' . $celda;
                $objPHPExcel->getActiveSheet()->getStyle($j)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue($j, $montoCancelado + $impuesto);
                $objPHPExcel->getActiveSheet()->getStyle($j)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                $total3 = $total3 - $montoCancelado;
                $total4 = $total4 - $impuesto;
                $total5 = $total5 - $montoCancelado - $impuesto;

                $celda += 1;
            }
            break;
    }
    $a = 'A' . $celda;
    $d = 'D' . $celda;
    $objPHPExcel->getActiveSheet()->mergeCells($a . ':' . $d);
    $objPHPExcel->getActiveSheet()->getStyle($a . ':' . $d)->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->setCellValue($a, 'TOTALES DEL MES');

    $e = 'E' . $celda;
    $objPHPExcel->getActiveSheet()->getStyle($e)->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->setCellValue($e, $total1);
    $objPHPExcel->getActiveSheet()->getStyle($e)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

    $f = 'F' . $celda;
    $objPHPExcel->getActiveSheet()->getStyle($f)->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->setCellValue($f, $total2);
    $objPHPExcel->getActiveSheet()->getStyle($f)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

    $g = 'G' . $celda;
    $objPHPExcel->getActiveSheet()->getStyle($g)->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->setCellValue($g, '-');

    $h = 'H' . $celda;
    $objPHPExcel->getActiveSheet()->getStyle($h)->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->setCellValue($h, $total3);
    $objPHPExcel->getActiveSheet()->getStyle($h)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

    $i = 'I' . $celda;
    $objPHPExcel->getActiveSheet()->getStyle($i)->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->setCellValue($i, $total4);
    $objPHPExcel->getActiveSheet()->getStyle($i)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

    $j = 'J' . $celda;
    $objPHPExcel->getActiveSheet()->getStyle($j)->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->setCellValue($j, $total5);
    $objPHPExcel->getActiveSheet()->getStyle($j)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

    if ($resumen == 1) {
        $celda += 2;
        $a = 'A' . $celda;
        $c = 'C' . $celda;
        $objPHPExcel->getActiveSheet()->mergeCells($a . ':' . $c);
        $objPHPExcel->getActiveSheet()->getStyle($a . ':' . $c)->applyFromArray($style2_array);
        $objPHPExcel->getActiveSheet()->setCellValue($a, 'RESUMEN');
        $objPHPExcel->getActiveSheet()->getStyle($a . ':' . $c)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->getStyle('D' . $celda)->applyFromArray($style2_array);

        $celda += 1;
        $a = 'A' . $celda;
        $c = 'C' . $celda;
        $objPHPExcel->getActiveSheet()->mergeCells($a . ':' . $c);
        $objPHPExcel->getActiveSheet()->setCellValue($a, 'Ventas exentas');
        $objPHPExcel->getActiveSheet()->getStyle($a . ':' . $c)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $celda, $total1);
        $objPHPExcel->getActiveSheet()->getStyle('D' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

        $celda += 1;
        $a = 'A' . $celda;
        $c = 'C' . $celda;
        $resumen2 = $total2 / 1.13;
        $objPHPExcel->getActiveSheet()->mergeCells($a . ':' . $c);
        $objPHPExcel->getActiveSheet()->setCellValue($a, 'Ventas netas gravadas');
        $objPHPExcel->getActiveSheet()->getStyle($a . ':' . $c)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $celda, $resumen2);
        $objPHPExcel->getActiveSheet()->getStyle('D' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

        $celda += 1;
        $a = 'A' . $celda;
        $c = 'C' . $celda;
        $resumen3 = $resumen2 * 0.13;
        $objPHPExcel->getActiveSheet()->mergeCells($a . ':' . $c);
        $objPHPExcel->getActiveSheet()->setCellValue($a, '13% IVA');
        $objPHPExcel->getActiveSheet()->getStyle($a . ':' . $c)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $celda, $resumen3);
        $objPHPExcel->getActiveSheet()->getStyle('D' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

        $celda += 1;
        $a = 'A' . $celda;
        $c = 'C' . $celda;
        $objPHPExcel->getActiveSheet()->mergeCells($a . ':' . $c);
        $objPHPExcel->getActiveSheet()->setCellValue($a, '5% CESC');
        $objPHPExcel->getActiveSheet()->getStyle($a . ':' . $c)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $celda, $total4);
        $objPHPExcel->getActiveSheet()->getStyle('D' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

        $celda += 1;
        $a = 'A' . $celda;
        $c = 'C' . $celda;
        $objPHPExcel->getActiveSheet()->mergeCells($a . ':' . $c);
        $objPHPExcel->getActiveSheet()->setCellValue($a, 'Exportaciones');
        $objPHPExcel->getActiveSheet()->getStyle($a . ':' . $c)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->getStyle($a . ':' . $c)->applyFromArray($style2_array);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $celda, '0');
        $objPHPExcel->getActiveSheet()->getStyle('D' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
        $objPHPExcel->getActiveSheet()->getStyle('D' . $celda)->applyFromArray($style2_array);

        $celda += 1;
        $a = 'A' . $celda;
        $c = 'C' . $celda;
        $objPHPExcel->getActiveSheet()->mergeCells($a . ':' . $c);
        $objPHPExcel->getActiveSheet()->setCellValue($a, 'VENTAS TOTALES');
        $objPHPExcel->getActiveSheet()->getStyle($a . ':' . $c)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $celda, $total1 + $resumen2 + $resumen3 + $total4);
        $objPHPExcel->getActiveSheet()->getStyle('D' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
    }
} else {
    //ENCABEZADO DE LA TABLA
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);

    $objPHPExcel->getActiveSheet()->getStyle('A3:D4')->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->mergeCells('A3:D4');
    $objPHPExcel->getActiveSheet()->setCellValue('A3', '');

    $objPHPExcel->getActiveSheet()->getStyle('E3:G3')->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->mergeCells('E3:G3');
    $objPHPExcel->getActiveSheet()->setCellValue('E3', 'VENTAS');

    $objPHPExcel->getActiveSheet()->getStyle('H3:J4')->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->mergeCells('H3:J4');
    $objPHPExcel->getActiveSheet()->setCellValue('H3', '');

    $objPHPExcel->getActiveSheet()->getStyle('A5')->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->setCellValue('A5', 'DIA');

    $objPHPExcel->getActiveSheet()->getStyle('B5')->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->setCellValue('B5', 'DEL N° DE FACTURA');

    $objPHPExcel->getActiveSheet()->getStyle('C5')->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->setCellValue('C5', 'AL N° DE FACTURA');

    $objPHPExcel->getActiveSheet()->getStyle('D5')->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->setCellValue('D5', 'N° CAJA REGISTRADORA');

    $objPHPExcel->getActiveSheet()->getStyle('E4:E5')->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->mergeCells('E4:E5');
    $objPHPExcel->getActiveSheet()->setCellValue('E4', 'EXENTAS');

    $objPHPExcel->getActiveSheet()->getStyle('F4:G4')->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->mergeCells('F4:G4');
    $objPHPExcel->getActiveSheet()->setCellValue('F4', 'GRAVADAS');

    $objPHPExcel->getActiveSheet()->getStyle('F5')->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->setCellValue('F5', 'LOCALES');

    $objPHPExcel->getActiveSheet()->getStyle('G5')->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->setCellValue('G5', 'EXPORTACIONES');

    $objPHPExcel->getActiveSheet()->getStyle('H5')->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->setCellValue('H5', 'SUB-TOTAL');

    $objPHPExcel->getActiveSheet()->getStyle('I5')->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->setCellValue('I5', 'CESC');

    $objPHPExcel->getActiveSheet()->getStyle('J5')->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->setCellValue('J5', 'VENTAS TOTALES');
    //FIN DE EL ENCABEZADO DE LA TABLA
    //INICIO DE CONTENIDO DE LA TABLA
    $numero = 1;
    $counter = 1;
    $celda = 6;
    $totalConIvaEx = 0;
    $totalConIvaEx2 = 0;
    $totalConIvaEx3 = 0;
    $totalSinIva = 0;
    $totalSinIva2 = 0;
    $totalSinIva3 = 0;
    $totalSoloIva = 0;
    $totalSoloIva2 = 0;
    $totalSoloIva3 = 0;
    $totalSoloCesc = 0;
    $totalSoloCesc2 = 0;
    $totalSoloCesc3 = 0;
    for ($i = 0; $i < 31; $i++) {
        switch ($tiposComprobantes) {
            case '1':
                $desde = $years . '-' . $mes . '-01';
                if ($mes == 2) {
                    $hasta = $years . '-' . $mes . '-28';
                } else {
                    $hasta = $years . '-' . $mes . '-31';
                }
                $desde = date('Y-m-d', strtotime($desde));
                $hasta = date('Y-m-d', strtotime($hasta));
                $sql = $mysqli->query("SELECT
                (SELECT SUM(cuotaCable) from tbl_cargos where tipoServicio='C' and DAY(fechaFactura) =" . $counter . " AND MONTH(fechaFactura)=" . $mes . " AND YEAR(fechaFactura)=" . $years . " AND tipoFactura = 2 AND anulada=0) as totalCuotaCable,
                (SELECT SUM(cuotaInternet) from tbl_cargos where tipoServicio='I' and DAY(fechaFactura) =" . $counter . " AND MONTH(fechaFactura)=" . $mes . " AND YEAR(fechaFactura)=" . $years . " AND tipoFactura = 2 AND anulada=0) as totalCuotaInter, SUM(totalImpuesto) as totalImp, MIN(numeroFactura) as inFact, MAX(numeroFactura) as finFact, DAY(fechaFactura) as dia FROM tbl_cargos
                WHERE DAY(fechaFactura) =" . $counter . " AND MONTH(fechaFactura)=" . $mes . " AND YEAR(fechaFactura)=" . $years . " AND tipoFactura = 2 AND anulada=0");

                $datos = $sql->fetch_Array();

                $objPHPExcel->getActiveSheet()->getStyle('A' . $celda)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $celda, $counter);

                $objPHPExcel->getActiveSheet()->getStyle('B' . $celda)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $celda, $datos["inFact"]);

                $objPHPExcel->getActiveSheet()->getStyle('C' . $celda)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $celda, $datos["finFact"]);

                $objPHPExcel->getActiveSheet()->getStyle('D' . $celda)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $celda, '');

                $montoCancelado = doubleval($datos["totalCuotaCable"]) + doubleval($datos["totalCuotaInter"]);
                //IVA
                $separado = $montoCancelado / 1.13;
                //var_dump($separado);
                $totalIva = $separado * 0.13;
                $sinIva = $montoCancelado - $totalIva;
                if ($ex->isExento("")) {
                    $objPHPExcel->getActiveSheet()->getStyle('E' . $celda)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $celda, $montoCancelado);
                    $objPHPExcel->getActiveSheet()->getStyle('E' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                    $objPHPExcel->getActiveSheet()->getStyle('F' . $celda)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $celda, '0');
                    $objPHPExcel->getActiveSheet()->getStyle('F' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                    $objPHPExcel->getActiveSheet()->getStyle('G' . $celda)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $celda, '0');
                    $objPHPExcel->getActiveSheet()->getStyle('G' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                    $totalConIvaEx = $totalConIvaEx + $montoCancelado;
                } else {
                    $objPHPExcel->getActiveSheet()->getStyle('E' . $celda)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $celda, '0');
                    $objPHPExcel->getActiveSheet()->getStyle('E' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                    $objPHPExcel->getActiveSheet()->getStyle('F' . $celda)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $celda, $montoCancelado);
                    $objPHPExcel->getActiveSheet()->getStyle('F' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                    $objPHPExcel->getActiveSheet()->getStyle('G' . $celda)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $celda, '0');
                    $objPHPExcel->getActiveSheet()->getStyle('G' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                    $totalSinIva = $totalSinIva + $montoCancelado;
                    $totalSoloIva = $totalSoloIva + $totalIva;
                }

                $totalSoloCesc = $totalSoloCesc + doubleval($datos["totalImp"]);
                $impuesto = $datos['totalImp'];
                $total = $impuesto + $montoCancelado;
                $objPHPExcel->getActiveSheet()->getStyle('H' . $celda)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $celda, $montoCancelado);
                $objPHPExcel->getActiveSheet()->getStyle('H' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                $objPHPExcel->getActiveSheet()->getStyle('I' . $celda)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $celda, $impuesto);
                $objPHPExcel->getActiveSheet()->getStyle('I' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                $objPHPExcel->getActiveSheet()->getStyle('J' . $celda)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $celda, $total);
                $objPHPExcel->getActiveSheet()->getStyle('J' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                break;
            case '2':
                $desde = $years . '-' . $mes . '-01';
                if ($mes == 2) {
                    $hasta = $years . '-' . $mes . '-28';
                } else {
                    $hasta = $years . '-' . $mes . '-31';
                }
                $desde = date('Y-m-d', strtotime($desde));
                $hasta = date('Y-m-d', strtotime($hasta));
                $sql = $mysqli->query("SELECT SUM(montoCable) as totalCable, SUM(montoInternet) as totalInter, SUM(impuesto) as totalImp, MIN(numeroComprobante) as inFact, MAX(numeroComprobante) as finFact, DAY(fechaComprobante) as dia FROM tbl_ventas_manuales
                WHERE DAY(fechaComprobante) =" . $counter . " AND MONTH(fechaComprobante)=" . $mes . " AND YEAR(fechaComprobante)=" . $years . " AND tipoComprobante = 2");

                $datos = $sql->fetch_Array();

                $objPHPExcel->getActiveSheet()->getStyle('A' . $celda)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $celda, $counter);

                $objPHPExcel->getActiveSheet()->getStyle('B' . $celda)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $celda, $datos["inFact"]);

                $objPHPExcel->getActiveSheet()->getStyle('C' . $celda)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $celda, $datos["finFact"]);

                $objPHPExcel->getActiveSheet()->getStyle('D' . $celda)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $celda, '');

                $montoCancelado2 = doubleval($datos["totalCable"]) + doubleval($datos["totalInter"]);
                //IVA
                $separado = $montoCancelado2 / 1.13;
                //var_dump($separado);
                $totalIva = $separado * 0.13;
                $sinIva = $montoCancelado2 - $totalIva;
                if ($ex->isExento("")) {
                    $objPHPExcel->getActiveSheet()->getStyle('E' . $celda)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $celda, $montoCancelado2);
                    $objPHPExcel->getActiveSheet()->getStyle('E' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                    $objPHPExcel->getActiveSheet()->getStyle('F' . $celda)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $celda, '0');
                    $objPHPExcel->getActiveSheet()->getStyle('F' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                    $objPHPExcel->getActiveSheet()->getStyle('G' . $celda)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $celda, '0');
                    $objPHPExcel->getActiveSheet()->getStyle('G' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                    $totalConIvaEx2 = $totalConIvaEx2 + $montoCancelado2;
                } else {
                    $objPHPExcel->getActiveSheet()->getStyle('E' . $celda)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $celda, '0');
                    $objPHPExcel->getActiveSheet()->getStyle('E' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                    $objPHPExcel->getActiveSheet()->getStyle('F' . $celda)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $celda, $montoCancelado2);
                    $objPHPExcel->getActiveSheet()->getStyle('F' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                    $objPHPExcel->getActiveSheet()->getStyle('G' . $celda)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $celda, '0');
                    $objPHPExcel->getActiveSheet()->getStyle('G' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                    $totalSinIva2 = $totalSinIva2 + $montoCancelado2;
                    $totalSoloIva2 = $totalSoloIva2 + $totalIva;
                }

                $totalSoloCesc2 = $totalSoloCesc2 + doubleval($datos["totalImp"]);
                $impuesto = $datos['totalImp'];
                $total = $impuesto + $montoCancelado2;
                $objPHPExcel->getActiveSheet()->getStyle('H' . $celda)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $celda, $montoCancelado2);
                $objPHPExcel->getActiveSheet()->getStyle('H' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                $objPHPExcel->getActiveSheet()->getStyle('I' . $celda)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $celda, $impuesto);
                $objPHPExcel->getActiveSheet()->getStyle('I' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                $objPHPExcel->getActiveSheet()->getStyle('J' . $celda)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $celda, $total);
                $objPHPExcel->getActiveSheet()->getStyle('J' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                break;
            case '3':
                $desde = $years . '-' . $mes . '-01';
                if ($mes == 2) {
                    $hasta = $years . '-' . $mes . '-28';
                } else {
                    $hasta = $years . '-' . $mes . '-31';
                }
                $desde = date('Y-m-d', strtotime($desde));
                $hasta = date('Y-m-d', strtotime($hasta));
                $sql = $mysqli->query("SELECT SUM(totalComprobante) as totalComprobante, MIN(numeroComprobante) as inFact, MAX(numeroComprobante) as finFact, DAY(fechaComprobante) as dia FROM tbl_ventas_anuladas
                WHERE DAY(fechaComprobante) =" . $counter . " AND MONTH(fechaComprobante)=" . $mes . " AND YEAR(fechaComprobante)=" . $years . " AND tipoComprobante = 2");

                $datos = $sql->fetch_Array();

                $objPHPExcel->getActiveSheet()->getStyle('A' . $celda)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $celda, $counter);

                $objPHPExcel->getActiveSheet()->getStyle('B' . $celda)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $celda, $datos["inFact"]);

                $objPHPExcel->getActiveSheet()->getStyle('C' . $celda)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $celda, $datos["finFact"]);

                $objPHPExcel->getActiveSheet()->getStyle('D' . $celda)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $celda, '');

                if (doubleval($datos["totalComprobante"]) > 0 && is_numeric(doubleval($datos["totalComprobante"]))) {
                    $montoCancelado3 = doubleval($datos["totalComprobante"]);
                } else {
                    $montoCancelado3 = 0;
                }
                //IVA
                $separado = $montoCancelado3 / 1.13;
                //var_dump($separado);
                $totalIva = $separado * 0.13;
                $sinIva = $montoCancelado3 - $totalIva;
                if ($ex->isExento("")) {
                    $objPHPExcel->getActiveSheet()->getStyle('E' . $celda)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $celda, $montoCancelado3);
                    $objPHPExcel->getActiveSheet()->getStyle('E' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                    $objPHPExcel->getActiveSheet()->getStyle('F' . $celda)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $celda, '0');
                    $objPHPExcel->getActiveSheet()->getStyle('F' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                    $objPHPExcel->getActiveSheet()->getStyle('G' . $celda)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $celda, '0');
                    $objPHPExcel->getActiveSheet()->getStyle('G' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                    $totalConIvaEx3 = $totalConIvaEx3 + $montoCancelado3;
                } else {
                    $objPHPExcel->getActiveSheet()->getStyle('E' . $celda)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $celda, '0');
                    $objPHPExcel->getActiveSheet()->getStyle('E' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                    $objPHPExcel->getActiveSheet()->getStyle('F' . $celda)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $celda, $montoCancelado3);
                    $objPHPExcel->getActiveSheet()->getStyle('F' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                    $objPHPExcel->getActiveSheet()->getStyle('G' . $celda)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $celda, '0');
                    $objPHPExcel->getActiveSheet()->getStyle('G' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                    $totalSinIva3 = $totalSinIva3 + $montoCancelado3;
                    $totalSoloIva3 = $totalSoloIva3 + $totalIva;
                }

                $totalSoloCesc3 = $totalSoloCesc3 + doubleval($datos["totalImp"]);
                $impuesto = $datos['totalImp'];
                $total = $impuesto + $montoCancelado3;
                $objPHPExcel->getActiveSheet()->getStyle('H' . $celda)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $celda, $montoCancelado3);
                $objPHPExcel->getActiveSheet()->getStyle('H' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                $objPHPExcel->getActiveSheet()->getStyle('I' . $celda)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $celda, $impuesto);
                $objPHPExcel->getActiveSheet()->getStyle('I' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                $objPHPExcel->getActiveSheet()->getStyle('J' . $celda)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $celda, $total);
                $objPHPExcel->getActiveSheet()->getStyle('J' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                break;
            case '4':
                $desde = $years . '-' . $mes . '-01';
                if ($mes == 2) {
                    $hasta = $years . '-' . $mes . '-28';
                } else {
                    $hasta = $years . '-' . $mes . '-31';
                }
                $desde = date('Y-m-d', strtotime($desde));
                $hasta = date('Y-m-d', strtotime($hasta));
                $sql = $mysqli->query("SELECT
                (SELECT SUM(cuotaCable) from tbl_cargos where tipoServicio='C' and DAY(fechaFactura) =" . $counter . " AND MONTH(fechaFactura)=" . $mes . " AND YEAR(fechaFactura)=" . $years . " AND tipoFactura = 2 AND anulada=0) as totalCuotaCable,
                (SELECT SUM(cuotaInternet) from tbl_cargos where tipoServicio='I' and DAY(fechaFactura) =" . $counter . " AND MONTH(fechaFactura)=" . $mes . " AND YEAR(fechaFactura)=" . $years . " AND tipoFactura = 2 AND anulada=0) as totalCuotaInter, SUM(totalImpuesto) as totalImp, MIN(numeroFactura) as inFact, MAX(numeroFactura) as finFact, DAY(fechaFactura) as dia FROM tbl_cargos
                WHERE DAY(fechaFactura) =" . $counter . " AND MONTH(fechaFactura)=" . $mes . " AND YEAR(fechaFactura)=" . $years . " AND tipoFactura = 2 AND anulada=0");

                $datos = $sql->fetch_Array();

                $objPHPExcel->getActiveSheet()->getStyle('A' . $celda)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $celda, $counter);

                $objPHPExcel->getActiveSheet()->getStyle('B' . $celda)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $celda, $datos["inFact"]);

                $objPHPExcel->getActiveSheet()->getStyle('C' . $celda)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $celda, $datos["finFact"]);

                $objPHPExcel->getActiveSheet()->getStyle('D' . $celda)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $celda, '');

                $montoCancelado = doubleval($datos["totalCuotaCable"]) + doubleval($datos["totalCuotaInter"]);
                //IVA
                $separado = $montoCancelado / 1.13;
                //var_dump($separado);
                $totalIva = $separado * 0.13;
                $sinIva = $montoCancelado - $totalIva;
                if ($ex->isExento("")) {
                    $objPHPExcel->getActiveSheet()->getStyle('E' . $celda)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $celda, $montoCancelado);
                    $objPHPExcel->getActiveSheet()->getStyle('E' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                    $objPHPExcel->getActiveSheet()->getStyle('F' . $celda)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $celda, '0');
                    $objPHPExcel->getActiveSheet()->getStyle('F' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                    $objPHPExcel->getActiveSheet()->getStyle('G' . $celda)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $celda, '0');
                    $objPHPExcel->getActiveSheet()->getStyle('G' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                    $totalConIvaEx = $totalConIvaEx + $montoCancelado;
                } else {
                    $objPHPExcel->getActiveSheet()->getStyle('E' . $celda)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $celda, '0');
                    $objPHPExcel->getActiveSheet()->getStyle('E' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                    $objPHPExcel->getActiveSheet()->getStyle('F' . $celda)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $celda, $montoCancelado);
                    $objPHPExcel->getActiveSheet()->getStyle('F' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                    $objPHPExcel->getActiveSheet()->getStyle('G' . $celda)->applyFromArray($style_array);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $celda, '0');
                    $objPHPExcel->getActiveSheet()->getStyle('G' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                    $totalSinIva = $totalSinIva + $montoCancelado;
                    $totalSoloIva = $totalSoloIva + $totalIva;
                }

                $totalSoloCesc = $totalSoloCesc + doubleval($datos["totalImp"]);
                $impuesto = $datos['totalImp'];
                $total = $impuesto + $montoCancelado;
                $objPHPExcel->getActiveSheet()->getStyle('H' . $celda)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $celda, $montoCancelado);
                $objPHPExcel->getActiveSheet()->getStyle('H' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                $objPHPExcel->getActiveSheet()->getStyle('I' . $celda)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $celda, $impuesto);
                $objPHPExcel->getActiveSheet()->getStyle('I' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

                $objPHPExcel->getActiveSheet()->getStyle('J' . $celda)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $celda, $total);
                $objPHPExcel->getActiveSheet()->getStyle('J' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $desde = $years . '-' . $mes . '-01';
                if ($mes == 2) {
                    $hasta = $years . '-' . $mes . '-28';
                } else {
                    $hasta = $years . '-' . $mes . '-31';
                }
                $desde = date('Y-m-d', strtotime($desde));
                $hasta = date('Y-m-d', strtotime($hasta));
                $sql = $mysqli->query("SELECT SUM(montoCable) as totalCable, SUM(montoInternet) as totalInter, SUM(impuesto) as totalImp, MIN(numeroComprobante) as inFact, MAX(numeroComprobante) as finFact, DAY(fechaComprobante) as dia FROM tbl_ventas_manuales
                WHERE DAY(fechaComprobante) =" . $counter . " AND MONTH(fechaComprobante)=" . $mes . " AND YEAR(fechaComprobante)=" . $years . " AND tipoComprobante = 2");

                $datos = $sql->fetch_Array();
                $montoCancelado2 = doubleval($datos["totalCable"]) + doubleval($datos["totalInter"]);
                //IVA
                $separado = $montoCancelado2 / 1.13;
                //var_dump($separado);
                $totalIva = $separado * 0.13;
                $sinIva = $montoCancelado2 - $totalIva;
                if ($ex->isExento("")) {
                    $totalConIvaEx2 = $totalConIvaEx2 + $montoCancelado2;
                } else {
                    $totalSinIva2 = $totalSinIva2 + $montoCancelado2;
                    $totalSoloIva2 = $totalSoloIva2 + $totalIva;
                }

                $totalSoloCesc2 = $totalSoloCesc2 + doubleval($datos["totalImp"]);
                $impuesto = $datos['totalImp'];
                $total = $impuesto + $montoCancelado2;
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $desde = $years . '-' . $mes . '-01';
                if ($mes == 2) {
                    $hasta = $years . '-' . $mes . '-28';
                } else {
                    $hasta = $years . '-' . $mes . '-31';
                }
                $desde = date('Y-m-d', strtotime($desde));
                $hasta = date('Y-m-d', strtotime($hasta));
                $sql = $mysqli->query("SELECT SUM(totalComprobante) as totalComprobante, MIN(numeroComprobante) as inFact, MAX(numeroComprobante) as finFact, DAY(fechaComprobante) as dia FROM tbl_ventas_anuladas
                WHERE DAY(fechaComprobante) =" . $counter . " AND MONTH(fechaComprobante)=" . $mes . " AND YEAR(fechaComprobante)=" . $years . " AND tipoComprobante = 2");

                $datos = $sql->fetch_Array();
                if (doubleval($datos["totalComprobante"]) > 0 && is_numeric(doubleval($datos["totalComprobante"]))) {
                    $montoCancelado3 = doubleval($datos["totalComprobante"]);
                } else {
                    $montoCancelado3 = 0;
                }
                //IVA
                $separado = $montoCancelado3 / 1.13;
                //var_dump($separado);
                $totalIva = $separado * 0.13;
                $sinIva = $montoCancelado3 - $totalIva;
                if ($ex->isExento("")) {
                    $totalConIvaEx3 = $totalConIvaEx3 + $montoCancelado3;
                } else {
                    $totalSinIva3 = $totalSinIva3 + $montoCancelado3;
                    $totalSoloIva3 = $totalSoloIva3 + $totalIva;
                }

                $totalSoloCesc3 = $totalSoloCesc3 + doubleval($datos["totalImp"]);
                $impuesto = $datos['totalImp'];
                $total = $impuesto + $montoCancelado3;
                break;
        }
        $celda += 1;
        $counter += 1;
    }

    if ($resumen == 1) {
        $celda += 1;
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $celda . ':B' . $celda);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $celda . ':B' . $celda)->applyFromArray($style2_array);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $celda . ':B' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $celda, 'RESUMEN');

        $objPHPExcel->getActiveSheet()->mergeCells('C' . $celda . ':D' . $celda);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $celda . ':D' . $celda)->applyFromArray($style2_array);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $celda . ':D' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $celda, 'FACTURAS GENERADAS');

        $objPHPExcel->getActiveSheet()->mergeCells('E' . $celda . ':F' . $celda);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $celda . ':F' . $celda)->applyFromArray($style2_array);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $celda . ':F' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $celda, 'FACTURAS MANUALES');

        $objPHPExcel->getActiveSheet()->mergeCells('G' . $celda . ':H' . $celda);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $celda . ':H' . $celda)->applyFromArray($style2_array);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $celda . ':H' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $celda, 'FACTURAS ANULADAS');

        $objPHPExcel->getActiveSheet()->mergeCells('I' . $celda . ':J' . $celda);
        $objPHPExcel->getActiveSheet()->getStyle('I' . $celda . ':J' . $celda)->applyFromArray($style2_array);
        $objPHPExcel->getActiveSheet()->getStyle('I' . $celda . ':J' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $celda, 'TOTALES');
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $celda += 1;
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $celda . ':B' . $celda);;
        $objPHPExcel->getActiveSheet()->getStyle('A' . $celda . ':B' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $celda, 'Ventas exentas');

        $objPHPExcel->getActiveSheet()->mergeCells('C' . $celda . ':D' . $celda);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $celda . ':D' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $celda, $totalConIvaEx);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

        $objPHPExcel->getActiveSheet()->mergeCells('E' . $celda . ':F' . $celda);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $celda . ':F' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $celda, $totalConIvaEx2);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

        $objPHPExcel->getActiveSheet()->mergeCells('G' . $celda . ':H' . $celda);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $celda . ':H' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $celda, $totalConIvaEx3);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

        if ($tiposComprobantes == 3) {
            $totalA = $totalConIvaEx + $totalConIvaEx2 + $totalConIvaEx3;
        } else {
            $totalA = $totalConIvaEx + $totalConIvaEx2 - $totalConIvaEx3;
        }

        $objPHPExcel->getActiveSheet()->mergeCells('I' . $celda . ':J' . $celda);
        $objPHPExcel->getActiveSheet()->getStyle('I' . $celda . ':J' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $celda, $totalA);
        $objPHPExcel->getActiveSheet()->getStyle('I' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $celda += 1;
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $celda . ':B' . $celda);;
        $objPHPExcel->getActiveSheet()->getStyle('A' . $celda . ':B' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $celda, 'Ventas netas gravadas');

        $objPHPExcel->getActiveSheet()->mergeCells('C' . $celda . ':D' . $celda);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $celda . ':D' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $celda, $totalSinIva);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

        $objPHPExcel->getActiveSheet()->mergeCells('E' . $celda . ':F' . $celda);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $celda . ':F' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $celda, $totalSinIva2);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

        $objPHPExcel->getActiveSheet()->mergeCells('G' . $celda . ':H' . $celda);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $celda . ':H' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $celda, $totalSinIva3);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

        if ($tiposComprobantes == 3) {
            $totalB = $totalSinIva + $totalSinIva2 + $totalSinIva3;
        } else {
            $totalB = $totalSinIva + $totalSinIva2 - $totalSinIva3;
        }

        $objPHPExcel->getActiveSheet()->mergeCells('I' . $celda . ':J' . $celda);
        $objPHPExcel->getActiveSheet()->getStyle('I' . $celda . ':J' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $celda, $totalB);
        $objPHPExcel->getActiveSheet()->getStyle('I' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $celda += 1;
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $celda . ':B' . $celda);;
        $objPHPExcel->getActiveSheet()->getStyle('A' . $celda . ':B' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $celda, '13% de IVA');

        $objPHPExcel->getActiveSheet()->mergeCells('C' . $celda . ':D' . $celda);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $celda . ':D' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $celda, $totalSoloIva);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

        $objPHPExcel->getActiveSheet()->mergeCells('E' . $celda . ':F' . $celda);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $celda . ':F' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $celda, $totalSoloIva2);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

        $objPHPExcel->getActiveSheet()->mergeCells('G' . $celda . ':H' . $celda);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $celda . ':H' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $celda, $totalSoloIva3);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

        if ($tiposComprobantes == 3) {
            $totalC = $totalSoloIva + $totalSoloIva2 + $totalSoloIva3;
        } else {
            $totalC = $totalSoloIva + $totalSoloIva2 - $totalSoloIva3;
        }

        $objPHPExcel->getActiveSheet()->mergeCells('I' . $celda . ':J' . $celda);
        $objPHPExcel->getActiveSheet()->getStyle('I' . $celda . ':J' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $celda, $totalC);
        $objPHPExcel->getActiveSheet()->getStyle('I' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $celda += 1;
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $celda . ':B' . $celda);;
        $objPHPExcel->getActiveSheet()->getStyle('A' . $celda . ':B' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $celda, '5% CESC');

        $objPHPExcel->getActiveSheet()->mergeCells('C' . $celda . ':D' . $celda);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $celda . ':D' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $celda, $totalSoloCesc);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

        $objPHPExcel->getActiveSheet()->mergeCells('E' . $celda . ':F' . $celda);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $celda . ':F' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $celda, $totalSoloCesc2);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

        $objPHPExcel->getActiveSheet()->mergeCells('G' . $celda . ':H' . $celda);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $celda . ':H' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $celda, $totalSoloCesc3);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

        if ($tiposComprobantes == 3) {
            $totalD = $totalSoloCesc + $totalSoloCesc2 + $totalSoloCesc3;
        } else {
            $totalD = $totalSoloCesc + $totalSoloCesc2 - $totalSoloCesc3;
        }

        $objPHPExcel->getActiveSheet()->mergeCells('I' . $celda . ':J' . $celda);
        $objPHPExcel->getActiveSheet()->getStyle('I' . $celda . ':J' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $celda, $totalD);
        $objPHPExcel->getActiveSheet()->getStyle('I' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $celda += 1;
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $celda . ':B' . $celda);;
        $objPHPExcel->getActiveSheet()->getStyle('A' . $celda . ':B' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->getStyle('A' . $celda . ':B' . $celda)->applyFromArray($style2_array);
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $celda, 'Exportaciones');

        $objPHPExcel->getActiveSheet()->mergeCells('C' . $celda . ':D' . $celda);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $celda . ':D' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->getStyle('C' . $celda . ':D' . $celda)->applyFromArray($style2_array);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $celda, '0');
        $objPHPExcel->getActiveSheet()->getStyle('C' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

        $objPHPExcel->getActiveSheet()->mergeCells('E' . $celda . ':F' . $celda);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $celda . ':F' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->getStyle('E' . $celda . ':F' . $celda)->applyFromArray($style2_array);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $celda, '0');
        $objPHPExcel->getActiveSheet()->getStyle('E' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

        $objPHPExcel->getActiveSheet()->mergeCells('G' . $celda . ':H' . $celda);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $celda . ':H' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->getStyle('G' . $celda . ':H' . $celda)->applyFromArray($style2_array);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $celda, '0');
        $objPHPExcel->getActiveSheet()->getStyle('G' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

        $objPHPExcel->getActiveSheet()->mergeCells('I' . $celda . ':J' . $celda);
        $objPHPExcel->getActiveSheet()->getStyle('I' . $celda . ':J' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->getStyle('I' . $celda . ':J' . $celda)->applyFromArray($style2_array);
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $celda, '0');
        $objPHPExcel->getActiveSheet()->getStyle('I' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $celda += 1;
        $total1 = $totalConIvaEx + $totalSinIva + $totalSoloIva + $totalSoloCesc;
        $total2 = $totalConIvaEx2 + $totalSinIva2 + $totalSoloIva2 + $totalSoloCesc2;
        $total3 = $totalConIvaEx3 + $totalSinIva3 + $totalSoloIva3 + $totalSoloCesc3;

        $objPHPExcel->getActiveSheet()->mergeCells('A' . $celda . ':B' . $celda);;
        $objPHPExcel->getActiveSheet()->getStyle('A' . $celda . ':B' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $celda, '');

        $objPHPExcel->getActiveSheet()->mergeCells('C' . $celda . ':D' . $celda);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $celda . ':D' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $celda, $total1);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

        $objPHPExcel->getActiveSheet()->mergeCells('E' . $celda . ':F' . $celda);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $celda . ':F' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $celda, $total2);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

        $objPHPExcel->getActiveSheet()->mergeCells('G' . $celda . ':H' . $celda);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $celda . ':H' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $celda, $total3);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

        if ($tiposComprobantes == 3) {
            $totalE = $total1 + $total2 + $total3;
        } else {
            $totalE = $total1 + $total2 - $total3;
        }

        $objPHPExcel->getActiveSheet()->mergeCells('I' . $celda . ':J' . $celda);
        $objPHPExcel->getActiveSheet()->getStyle('I' . $celda . ':J' . $celda)->getFont()->setSize(10)->setBold(true)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $celda, $totalE);
        $objPHPExcel->getActiveSheet()->getStyle('I' . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
    }
}
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
