<?php
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
    $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(12);      //tamaño de fuente
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
$style2_array = [
    'borders' => [
        'bottom' => [
            'style' => \PHPExcel_Style_Border::BORDER_MEDIUM
        ]
    ]
];
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(45);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);

$objPHPExcel->getActiveSheet()->getStyle('A3:N1000')->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
$objPHPExcel->getActiveSheet()->getStyle('A3:N5')->getFont()->setBold(TRUE)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
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

if ($detallado == 1) {
    $contador = 1;
    $celda = 6;
    if ($tiposComprobantes == 1) {
        $desde = $years . '-' . $mes . '-01';
        $hasta = $years . '-' . $mes . '-31';
        $desde = date('Y-m-d', strtotime($desde));
        $hasta = date('Y-m-d', strtotime($hasta));
        $sql = "SELECT *, (SELECT num_registro FROM clientes WHERE clientes.cod_cliente=tbl_cargos.codigoCliente) AS nRegistro FROM tbl_cargos WHERE fechaFactura BETWEEN '$desde' AND '$hasta' AND tipoFactura =1 ORDER BY idFactura";
        $sql2 = "SELECT * FROM tbl_ventas_manuales WHERE fechaComprobante BETWEEN '$desde' AND '$hasta'  AND tipoComprobante = 2 ORDER BY idVenta ASC";
        $sql3 = "SELECT * FROM tbl_cargos WHERE fechaFactura BETWEEN '$desde' AND '$hasta' AND tipoFactura = 2 AND anulada=0";
        $sql4 = "SELECT * FROM tbl_ventas_anuladas WHERE fechaComprobante BETWEEN '$desde' AND '$hasta' AND tipoComprobante = 2 ORDER BY idVenta ASC";
    }

    $query = $mysqli->query($sql);
    $query2 = $mysqli->query($sql2);
    $query3 = $mysqli->query($sql3);
    $query4 = $mysqli->query($sql4);

    $totalExentosSinIva = 0;
    $totalGravadasSinIva = 0;
    $totalExentoSinIvaAnulados = 0;
    $totalGravadasSinIvaAnulados = 0;
    while ($datos = $query->fetch_array()) {
        $a = 'A' . $celda;
        $b = 'B' . $celda;
        $c = 'C' . $celda;
        $d = 'D' . $celda;
        $e = 'E' . $celda;
        $f = 'F' . $celda;
        $g = 'G' . $celda;
        $h = 'H' . $celda;
        $i = 'I' . $celda;
        $j = 'J' . $celda;
        $k = 'K' . $celda;
        $l = 'L' . $celda;
        $m = 'M' . $celda;
        $n = 'N' . $celda;

        $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue($a, $contador);
        $objPHPExcel->getActiveSheet()->getStyle($a)->applyFromArray($style_array);

        $fechaFactura = $datos['fechaFactura'];
        $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle($b)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue($b, $fechaFactura);
        $objPHPExcel->getActiveSheet()->getStyle($b)->applyFromArray($style_array);

        $correlativo = substr($datos['numeroFactura'], 9, 7);
        $objPHPExcel->getActiveSheet()->getStyle($c)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle($c)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue($c, $correlativo);
        $objPHPExcel->getActiveSheet()->getStyle($c)->applyFromArray($style_array);

        $objPHPExcel->getActiveSheet()->getStyle($d)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle($d)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue($d, '0');
        $objPHPExcel->getActiveSheet()->getStyle($d)->applyFromArray($style_array);

        $nombre = $datos['nombre'];
        $objPHPExcel->getActiveSheet()->getStyle($e)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle($e)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue($e, $nombre);
        $objPHPExcel->getActiveSheet()->getStyle($e)->applyFromArray($style_array);
        $objPHPExcel->getActiveSheet()->getStyle($e)->getAlignment()->setWrapText(true);

        if ($nombre == '<<< Comprobante anulado >>>') {
            $nrc = '';
        } else {
            $nrc = $datos['nRegistro'];
        }
        $objPHPExcel->getActiveSheet()->getStyle($f)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle($f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue($f, $nrc);
        $objPHPExcel->getActiveSheet()->getStyle($f)->applyFromArray($style_array);

        if ($ex->isExento($datos['codigoCliente'])) {
            if ($datos['tipoServicio'] == 'C') {
                $monto = $datos['cuotaCable'];
                $montoCancelado = $datos['cuotaCable'];
                $separado = ($montoCancelado / 1.13);
                $iva = ($separado * 0.13);
                $internasGravadas = 0.00;
                $debitoFiscal = 0.00;
                $internasGravadas2 = 0;
                $debitoFiscal2 = 0;
                $totalExentosSinIva = $totalExentosSinIva + $monto;
                $totalIvaCredito = $totalIvaCredito + $debitoFiscal;
                $totalCESCcredito = $totalCESCcredito + $datos['totalImpuesto'];
            } else {
                $monto = $datos['cuotaInternet'];
                $montoCancelado = $datos['cuotaInternet'];
                $separado = ($montoCancelado / 1.13);
                $iva = ($separado * 0.13);
                $internasGravadas = 0.00;
                $debitoFiscal = 0.00;
                $internasGravadas2 = 0;
                $debitoFiscal2 = 0;
                $totalExentosSinIva = $totalExentosSinIva + $monto;
                $totalIvaCredito = $totalIvaCredito + $debitoFiscal;
                $totalCESCcredito = $totalCESCcredito + $datos['totalImpuesto'];
            }
        } else {
            if ($datos['tipoServicio'] == 'C') {
                $monto = $datos['cuotaCable'];
                $montoCancelado = 0.00;
                $separado = ($datos['cuotaCable'] / 1.13);
                $iva = ($separado * 0.13);
                $internasGravadas = ($datos['cuotaCable'] - $iva);
                $debitoFiscal = $iva;
                $internasGravadas2 = 0;
                $debitoFiscal2 = 0;
                $totalGravadasSinIva = $totalGravadasSinIva + $internasGravadas;
                $totalIvaCredito = $totalIvaCredito + $debitoFiscal;
                $totalCESCcredito = $totalCESCcredito + $datos['totalImpuesto'];
            } else {
                $monto = $datos['cuotaInternet'];
                $montoCancelado = 0.00;
                $separado = ($datos['cuotaInternet'] / 1.13);
                $iva = ($separado * 0.13);
                $internasGravadas = ($datos['cuotaInternet'] - $iva);
                $debitoFiscal = $iva;
                $internasGravadas2 = 0;
                $debitoFiscal2 = 0;
                $totalGravadasSinIva = $totalGravadasSinIva + $internasGravadas;
                $totalIvaCredito = $totalIvaCredito + $debitoFiscal;
                $totalCESCcredito = $totalCESCcredito + $datos['totalImpuesto'];
            }
        }


        $TotalA = $TotalA + $montoCancelado;
        $objPHPExcel->getActiveSheet()->getStyle($g)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle($g)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue($g, $montoCancelado);
        $objPHPExcel->getActiveSheet()->getStyle($g)->applyFromArray($style_array);
        $objPHPExcel->getActiveSheet()->getStyle($g)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

        $TotalB = $TotalB + $internasGravadas;
        $objPHPExcel->getActiveSheet()->getStyle($h)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle($h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue($h, $internasGravadas);
        $objPHPExcel->getActiveSheet()->getStyle($h)->applyFromArray($style_array);
        $objPHPExcel->getActiveSheet()->getStyle($h)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

        $TotalC = $TotalC + $debitoFiscal;
        $objPHPExcel->getActiveSheet()->getStyle($i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle($i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue($i, $debitoFiscal);
        $objPHPExcel->getActiveSheet()->getStyle($i)->applyFromArray($style_array);
        $objPHPExcel->getActiveSheet()->getStyle($i)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

        $TotalD = $TotalD + $montoCancelado;
        $objPHPExcel->getActiveSheet()->getStyle($j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle($j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue($j, $montoCancelado);
        $objPHPExcel->getActiveSheet()->getStyle($j)->applyFromArray($style_array);
        $objPHPExcel->getActiveSheet()->getStyle($j)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

        $TotalE = $TotalE + $internasGravadas2;
        $objPHPExcel->getActiveSheet()->getStyle($k)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle($k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue($k, $internasGravadas2);
        $objPHPExcel->getActiveSheet()->getStyle($k)->applyFromArray($style_array);
        $objPHPExcel->getActiveSheet()->getStyle($k)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

        $TotalF = $TotalF + $debitoFiscal2;
        $objPHPExcel->getActiveSheet()->getStyle($l)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle($l)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue($l, $debitoFiscal2);
        $objPHPExcel->getActiveSheet()->getStyle($l)->applyFromArray($style_array);
        $objPHPExcel->getActiveSheet()->getStyle($l)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

        $idcliente = $datos["codigoCliente"];
        $granContribuyente = $mysqli->query("SELECT id_tipo_cliente FROM clientes WHERE cod_cliente='$idcliente'");
        $datoscontribuyente = $granContribuyente->fetch_array();
        if ($datoscontribuyente['id_tipo_cliente'] == '0003') {
            $ivaretenido = $internasGravadas * 0.01;
            $totalivaretenido = $totalivaretenido + $ivaretenido;
            $monto = $monto - $ivaretenido;
        } else {
            $ivaretenido = 0.00;
        }

        $TotalG = $TotalG + $ivaretenido;
        $objPHPExcel->getActiveSheet()->getStyle($m)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle($m)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue($m, $ivaretenido);
        $objPHPExcel->getActiveSheet()->getStyle($m)->applyFromArray($style_array);
        $objPHPExcel->getActiveSheet()->getStyle($m)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

        $TotalH = $TotalH + $monto;
        $objPHPExcel->getActiveSheet()->getStyle($n)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle($n)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue($n, $monto);
        $objPHPExcel->getActiveSheet()->getStyle($n)->applyFromArray($style_array);
        $objPHPExcel->getActiveSheet()->getStyle($n)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");


        $celda += 1;
        $contador += 1;
    }
    $unir1 = "A" . $celda;
    $unir2 = "F" . $celda;
    $final = "N" . $celda;

    $objPHPExcel->getActiveSheet()->getStyle($unir1 . ':' . $final)->getFont()->setBold(TRUE)->setName('ARIAL')->setSize(10)->getColor()->setRGB('000000');
    $objPHPExcel->getActiveSheet()->mergeCells($unir1 . ':' . $unir2);
    $objPHPExcel->getActiveSheet()->getStyle($unir1 . ':' . $unir2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle($unir1 . ':' . $unir2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->setCellValue($unir1, 'TOTAL');
    $objPHPExcel->getActiveSheet()->getStyle($unir1 . ':' . $unir2)->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->getStyle($unir1 . ':' . $unir2)->getAlignment()->setWrapText(true);

    $objPHPExcel->getActiveSheet()->getStyle("G" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("G" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->setCellValue("G" . $celda, $TotalA);
    $objPHPExcel->getActiveSheet()->getStyle("G" . $celda)->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->getStyle("G" . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

    $objPHPExcel->getActiveSheet()->getStyle("H" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("H" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->setCellValue("H" . $celda, $TotalB);
    $objPHPExcel->getActiveSheet()->getStyle("H" . $celda)->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->getStyle("H" . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

    $objPHPExcel->getActiveSheet()->getStyle("I" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("I" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->setCellValue("I" . $celda, $TotalC);
    $objPHPExcel->getActiveSheet()->getStyle("I" . $celda)->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->getStyle("I" . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

    $objPHPExcel->getActiveSheet()->getStyle("J" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("J" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->setCellValue("J" . $celda, $TotalD);
    $objPHPExcel->getActiveSheet()->getStyle("J" . $celda)->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->getStyle("J" . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

    $objPHPExcel->getActiveSheet()->getStyle("K" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("K" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->setCellValue("K" . $celda, $TotalE);
    $objPHPExcel->getActiveSheet()->getStyle("K" . $celda)->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->getStyle("K" . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

    $objPHPExcel->getActiveSheet()->getStyle("L" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("L" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->setCellValue("L" . $celda, $TotalF);
    $objPHPExcel->getActiveSheet()->getStyle("L" . $celda)->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->getStyle("L" . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

    $objPHPExcel->getActiveSheet()->getStyle("M" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("M" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->setCellValue("M" . $celda, $TotalG);
    $objPHPExcel->getActiveSheet()->getStyle("M" . $celda)->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->getStyle("M" . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

    $objPHPExcel->getActiveSheet()->getStyle("N" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("N" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->setCellValue("N" . $celda, $TotalH);
    $objPHPExcel->getActiveSheet()->getStyle("N" . $celda)->applyFromArray($style_array);
    $objPHPExcel->getActiveSheet()->getStyle("N" . $celda)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

    if ($resumen == 1) {
        while ($datos2 = $query2->fetch_array()) {
            if ($datos2["montoCable"] > 0 && is_numeric($datos2["montoCable"])) {
                $montoVentasManuales = doubleval($datos2["montoCable"]);
            } else {
                if ($datos2["montoInternet"] > 0 && is_numeric($datos2["montoInternet"])) {
                    $montoVentasManuales = doubleval($datos2["montoInternet"]);
                } else {
                    $montoVentasManuales = 0;
                }
            }

            $ivaVentasManuales = ($montoVentasManuales / 1.13) * 0.13;
            $sinIvaVentasManuales = $montoVentasManuales - $ivaVentasManuales;
            $totalIvaVentasManuales = $totalIvaVentasManuales + $ivaVentasManuales;
            $totalCESCventasManuales = $totalCESCventasManuales + $datos2['impuesto'];
            if ($ex->isExento($datos2['codigoCliente'])) {
                $totalExentoSinIvaVentasManuales = $totalExentoSinIvaVentasManuales + $montoVentasManuales;
            } else {
                $totalGravadasSinIvaVentasManuales = $totalGravadasSinIvaVentasManuales + $sinIvaVentasManuales;
            }
        }

        while ($datos3 = $query3->fetch_array()) {
            if ($datos3["tipoServicio"] == "C") {
                $montoVentasManuales2 = doubleval($datos3["cuotaCable"]);
            } else {
                if ($datos3["tipoServicio"] == "I") {
                    $montoVentasManuales2 = doubleval($datos3["cuotaInternet"]);
                }
            }

            $ivaVentasManuales2 = ($montoVentasManuales2 / 1.13) * 0.13;
            $sinIvaVentasManuales2 = $montoVentasManuales2 - $ivaVentasManuales2;
            $totalIvaVentasManuales2 = $totalIvaVentasManuales2 + $ivaVentasManuales2;
            $totalCESCventasManuales2 = $totalCESCventasManuales2 + $datos3['totalImpuesto'];
            if ($ex->isExento($datos3['codigoCliente'])) {
                $totalExentoSinIvaVentasManuales2 = $totalExentoSinIvaVentasManuales2 + $montoVentasManuales2;
            } else {
                $totalGravadasSinIvaVentasManuales2 = $totalGravadasSinIvaVentasManuales2 + $sinIvaVentasManuales2;
            }
        }


        while ($datos4 = $query4->fetch_array()) {
            if ($datos4["totalComprobante"] > 0 && is_numeric($datos4["totalComprobante"])) {
                $montoAnulados = doubleval($datos4["totalComprobante"]);
            } else {
                $montoAnulados = 0;
            }
            $IvaAnulados = ($montoAnulados / 1.13) * 0.13;
            $sinIvaAnulados = $montoAnulados - $IvaAnulados;
            $totalIvaAnulados = $totalIvaAnulados + $IvaAnulados;
            $totalCESCanulados = $totalCESCanulados + $datos4['impuesto'];
            if ($ex->isExento($datos4['codigoCliente'])) {
                $totalExentoSinIvaAnulados = $totalExentoSinIvaAnulados + $sinIvaAnulados;
            } else {
                $totalGravadasSinIvaAnulados = $totalGravadasSinIvaAnulados + $sinIvaAnulados;
            }
        }

        $celda += 2;
        //encabezado del resumen
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->mergeCells("A" . $celda . ":" . "F" . $celda);
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->setCellValue("A" . $celda, 'RESUMEN');
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->getAlignment()->setWrapText(false);
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->applyFromArray($style2_array);

        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->mergeCells("G" . $celda . ":" . "H" . $celda);
        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue("G" . $celda, 'RESUMEN DE VENTAS (CCF)');
        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->getAlignment()->setWrapText(false);
        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->applyFromArray($style2_array);

        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->mergeCells("I" . $celda . ":" . "K" . $celda);
        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue("I" . $celda, 'RESUMEN DE VENTAS A CONSUMIDOR FINAL');
        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->getAlignment()->setWrapText(false);
        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->applyFromArray($style2_array);

        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->mergeCells("L" . $celda . ":" . "N" . $celda);
        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue("L" . $celda, 'RESUMEN A CONSUMIDOR FINAL ANULADAS');
        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->getAlignment()->setWrapText(false);
        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->applyFromArray($style2_array);

        //VENTAS EXENTAS
        $celda += 1;
        $fin = $celda + 6;
        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "N" . $fin)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->mergeCells("A" . $celda . ":" . "F" . $celda);
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->setCellValue("A" . $celda, 'VENTAS EXENTAS');
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->getAlignment()->setWrapText(false);

        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->mergeCells("G" . $celda . ":" . "H" . $celda);
        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue("G" . $celda, $totalExentosSinIva);
        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->getAlignment()->setWrapText(false);


        $totalExentoSinIvaVentasManualesCompleto = $totalExentoSinIvaVentasManuales + $totalExentoSinIvaVentasManuales2;
        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->mergeCells("I" . $celda . ":" . "K" . $celda);
        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue("I" . $celda, $totalExentoSinIvaVentasManualesCompleto);
        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->getAlignment()->setWrapText(false);


        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->mergeCells("L" . $celda . ":" . "N" . $celda);
        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue("L" . $celda, $totalExentoSinIvaAnulados);
        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->getAlignment()->setWrapText(false);


        //ventas netas gravadas
        $celda += 1;
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->mergeCells("A" . $celda . ":" . "F" . $celda);
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->setCellValue("A" . $celda, 'VENTAS NETAS GRAVADAS');
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->getAlignment()->setWrapText(false);

        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->mergeCells("G" . $celda . ":" . "H" . $celda);
        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue("G" . $celda, $totalGravadasSinIva);
        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->getAlignment()->setWrapText(false);


        $totalGravadasSinIvaVentasManualesCompleto = $totalGravadasSinIvaVentasManuales + $totalGravadasSinIvaVentasManuales2;
        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->mergeCells("I" . $celda . ":" . "K" . $celda);
        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue("I" . $celda, $totalGravadasSinIvaVentasManualesCompleto);
        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->getAlignment()->setWrapText(false);


        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->mergeCells("L" . $celda . ":" . "N" . $celda);
        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue("L" . $celda, $totalGravadasSinIvaAnulados);
        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->getAlignment()->setWrapText(false);


        //debito Fiscal
        $celda += 1;
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->mergeCells("A" . $celda . ":" . "F" . $celda);
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->setCellValue("A" . $celda, 'DEBITO FISCAL 13%');
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->getAlignment()->setWrapText(false);

        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->mergeCells("G" . $celda . ":" . "H" . $celda);
        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue("G" . $celda, $totalIvaCredito);
        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->getAlignment()->setWrapText(false);


        $totalIvaVentasManualesCompleto = $totalIvaVentasManuales + $totalIvaVentasManuales2;
        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->mergeCells("I" . $celda . ":" . "K" . $celda);
        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue("I" . $celda, $totalIvaVentasManualesCompleto);
        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->getAlignment()->setWrapText(false);


        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->mergeCells("L" . $celda . ":" . "N" . $celda);
        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue("L" . $celda, $totalIvaAnulados);
        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->getAlignment()->setWrapText(false);


        //CESC
        $celda += 1;
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->mergeCells("A" . $celda . ":" . "F" . $celda);
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->setCellValue("A" . $celda, 'CESC 5%');
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->getAlignment()->setWrapText(false);

        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->mergeCells("G" . $celda . ":" . "H" . $celda);
        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue("G" . $celda, $totalCESCcredito);
        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->getAlignment()->setWrapText(false);


        $totalCESCventasmanualesCompleto = $totalCESCventasManuales + $totalCESCventasManuales2;
        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->mergeCells("I" . $celda . ":" . "K" . $celda);
        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue("I" . $celda, $totalCESCventasmanualesCompleto);
        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->getAlignment()->setWrapText(false);


        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->mergeCells("L" . $celda . ":" . "N" . $celda);
        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue("L" . $celda, $totalCESCanulados);
        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->getAlignment()->setWrapText(false);


        //exportaciones
        $celda += 1;
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->mergeCells("A" . $celda . ":" . "F" . $celda);
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->setCellValue("A" . $celda, 'EXPORTACIONES');
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->getAlignment()->setWrapText(false);

        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->mergeCells("G" . $celda . ":" . "H" . $celda);
        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue("G" . $celda, '0');
        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->getAlignment()->setWrapText(false);


        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->mergeCells("I" . $celda . ":" . "K" . $celda);
        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue("I" . $celda, '0');
        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->getAlignment()->setWrapText(false);


        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->mergeCells("L" . $celda . ":" . "N" . $celda);
        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue("L" . $celda, '0');
        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->getAlignment()->setWrapText(false);


        //IVA RETENIDO
        $celda += 1;
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->mergeCells("A" . $celda . ":" . "F" . $celda);
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->setCellValue("A" . $celda, 'IVA RETENIDO 1%');
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->getAlignment()->setWrapText(false);
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->applyFromArray($style2_array);

        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->mergeCells("G" . $celda . ":" . "H" . $celda);
        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue("G" . $celda, $totalivaretenido);
        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->getAlignment()->setWrapText(false);
        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->applyFromArray($style2_array);

        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->mergeCells("I" . $celda . ":" . "K" . $celda);
        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue("I" . $celda, '0');
        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->getAlignment()->setWrapText(false);
        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->applyFromArray($style2_array);

        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->mergeCells("L" . $celda . ":" . "N" . $celda);
        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue("L" . $celda, '0');
        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->getAlignment()->setWrapText(false);
        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->applyFromArray($style2_array);

        //exportaciones
        $celda += 1;
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->mergeCells("A" . $celda . ":" . "F" . $celda);
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->setCellValue("A" . $celda, 'TOTAL');
        $objPHPExcel->getActiveSheet()->getStyle("A" . $celda . ":" . "F" . $celda)->getAlignment()->setWrapText(false);

        $totalUNO = $totalExentosSinIva + $totalGravadasSinIva + $totalIvaCredito + $totalCESCcredito + 0 - $totalivaretenido;
        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->mergeCells("G" . $celda . ":" . "H" . $celda);
        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue("G" . $celda, $totalUNO);
        $objPHPExcel->getActiveSheet()->getStyle("G" . $celda . ":" . "H" . $celda)->getAlignment()->setWrapText(false);


        $totalDOS = $totalExentoSinIvaVentasManualesCompleto + $totalGravadasSinIvaVentasManualesCompleto + $totalIvaVentasManualesCompleto + $totalCESCventasmanualesCompleto;
        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->mergeCells("I" . $celda . ":" . "K" . $celda);
        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue("I" . $celda, $totalDOS);
        $objPHPExcel->getActiveSheet()->getStyle("I" . $celda . ":" . "K" . $celda)->getAlignment()->setWrapText(false);


        $totalTRES = $totalExentoSinIvaAnulados + $totalGravadasSinIvaAnulados + $totalIvaAnulados + $totalCESCanulados;
        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->getFont()->setBold(false)->setName('ARIAL')->setSize(8)->getColor()->setRGB('000000');
        $objPHPExcel->getActiveSheet()->mergeCells("L" . $celda . ":" . "N" . $celda);
        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue("L" . $celda, $totalTRES);
        $objPHPExcel->getActiveSheet()->getStyle("L" . $celda . ":" . "N" . $celda)->getAlignment()->setWrapText(false);
    }
} else {
    //espacio para reporto no detallado
    $numero = 6;
    $counter = 1;
    $objPHPExcel->getActiveSheet()->getStyle("A6:N36")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("A6:N36")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("A6:N36")->applyFromArray($style_array);
    for ($i = 0; $i < 31; $i++) {
        $primero = "A" . $numero;
        $segundo = "B" . $numero;
        $tercero = "C" . $numero;
        $cuarto = "D" . $numero;
        $quinto = "E" . $numero;
        $sexto = "F" . $numero;
        $septimo = "G" . $numero;
        $octavo = "H" . $numero;
        $noveno = "I" . $numero;
        $decimo = "J" . $numero;
        $once = "K" . $numero;
        $doce = "L" . $numero;
        $trece = "M" . $numero;
        $catorce = "N" . $numero;

        if ($tiposComprobantes == 1) {
            $desde = $years . '-' . $mes . '-01';
            $hasta = $years . '-' . $mes . '-31';
            $desde = date('Y-m-d', strtotime($desde));
            $hasta = date('Y-m-d', strtotime($hasta));
            $sql = "SELECT
                            (SELECT SUM(cuotaCable) from tbl_cargos where tipoServicio='C' and DAY(fechaFactura) =" . $counter . " AND MONTH(fechaFactura)=" . $mes . " AND YEAR(fechaFactura)=" . $years . " AND tipoFactura = 1 AND anulada=0) as totalCuotaCable,
                            (SELECT SUM(cuotaInternet) from tbl_cargos where tipoServicio='I' and DAY(fechaFactura) =" . $counter . " AND MONTH(fechaFactura)=" . $mes . " AND YEAR(fechaFactura)=" . $years . " AND tipoFactura = 1 AND anulada=0) as totalCuotaInter,
                            SUM(totalImpuesto) as totalImp,
                            MIN(numeroFactura) as inFact,
                            MAX(numeroFactura) as finFact,
                            DAY(fechaFactura) as dia FROM tbl_cargos
                            WHERE DAY(fechaFactura) =" . $counter . " AND MONTH(fechaFactura)=" . $mes . " AND YEAR(fechaFactura)=" . $years . " AND tipoFactura = 1 AND anulada=0";
        }


        $query = $mysqli->query($sql);


        //COLUMNA A
        $objPHPExcel->getActiveSheet()->setCellValue($primero, $i + 1);
        //COLUMNA B
        while ($datos = $query->fetch_array()) {
            if (strlen($datos["inFact"]) == 0) {
                $objPHPExcel->getActiveSheet()->setCellValue($segundo, "-");
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue($segundo, $mes . "/" . $years);
            }
            //COLUMNA C
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $objPHPExcel->getActiveSheet()->setCellValue($tercero, substr($datos['inFact'], 9, 7) . "-" . substr($datos['finFact'], 9, 7));
            //COLUMNA D
            $objPHPExcel->getActiveSheet()->setCellValue($cuarto, "0");
            //COLUMNA E
            $objPHPExcel->getActiveSheet()->setCellValue($quinto, "-");
            //COLUMNA F
            $objPHPExcel->getActiveSheet()->setCellValue($sexto, "-");
            $montoCancelado = doubleval($datos["totalCuotaCable"]) + doubleval($datos["totalCuotaInter"]);
            //IVA
            $separado = $montoCancelado / 1.13;
            //var_dump($separado);
            $totalIva = $separado * 0.13;
            $totalSoloIva = $totalSoloIva + $totalIva;
            $sinIva = doubleval($montoCancelado) - doubleval($totalIva);
            if ($ex->isExento("")) {
                //COLUMNA G
                $objPHPExcel->getActiveSheet()->setCellValue($septimo, $montoCancelado);
                $objPHPExcel->getActiveSheet()->getStyle($septimo)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                //COLUMNA H
                $objPHPExcel->getActiveSheet()->setCellValue($octavo, "0");
                $objPHPExcel->getActiveSheet()->getStyle($octavo)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                //COLUMNA I
                $objPHPExcel->getActiveSheet()->setCellValue($noveno, "0");
                $objPHPExcel->getActiveSheet()->getStyle($noveno)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
            } else {
                //COLUMNA G
                $objPHPExcel->getActiveSheet()->setCellValue($septimo, "0");
                $objPHPExcel->getActiveSheet()->getStyle($septimo)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                //COLUMNA H
                $objPHPExcel->getActiveSheet()->setCellValue($octavo, $sinIva);
                $objPHPExcel->getActiveSheet()->getStyle($octavo)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                //COLUMNA I
                if ($datos["totalImp"]) {
                    $objPHPExcel->getActiveSheet()->setCellValue($noveno, $totalSoloIva);
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue($noveno, "0");
                }
                $objPHPExcel->getActiveSheet()->getStyle($noveno)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
            }
            $totalSoloCesc = $totalSoloCesc + doubleval($datos["totalImp"]);
            $objPHPExcel->getActiveSheet()->setCellValue($decimo, "0");
            $objPHPExcel->getActiveSheet()->getStyle($decimo)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
            $objPHPExcel->getActiveSheet()->setCellValue($once, "0");
            $objPHPExcel->getActiveSheet()->getStyle($once)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
            $objPHPExcel->getActiveSheet()->setCellValue($doce, "0");
            $objPHPExcel->getActiveSheet()->getStyle($doce)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
            $objPHPExcel->getActiveSheet()->setCellValue($trece, "0");
            $objPHPExcel->getActiveSheet()->getStyle($trece)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
            $total = $montoCancelado + doubleval($datos["totalImp"]);
            $objPHPExcel->getActiveSheet()->setCellValue($catorce, $total);
            $objPHPExcel->getActiveSheet()->getStyle($catorce)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
        }

        $numero += 1;
        $counter += 1;
    }
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
