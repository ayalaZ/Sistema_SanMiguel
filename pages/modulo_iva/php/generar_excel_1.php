<?php
require_once("../../../php/config.php");
require_once("../getDatos.php");
$ex = new GetDatos();
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
        $objPHPExcel->getActiveSheet()->getStyle('A3:N5')->getFont()->setBold(TRUE)->setName('ARIAL')->setSize(10)->getColor()->setRGB('000000');
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
                $sql = "SELECT *, (SELECT num_registro FROM clientes WHERE clientes.cod_cliente=tbl_cargos.codigoCliente) AS nRegistro FROM tbl_cargos WHERE fechaFactura BETWEEN '$desde' AND '$hasta' AND tipoFactura =1";
            }

            $query = $mysqli->query($sql);
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
                    } else {
                        $monto = $datos['cuotaInternet'];
                        $montoCancelado = $datos['cuotaInternet'];
                        $separado = ($montoCancelado / 1.13);
                        $iva = ($separado * 0.13);
                        $internasGravadas = 0.00;
                        $debitoFiscal = 0.00;
                        $internasGravadas2 = 0;
                        $debitoFiscal2 = 0;
                    }
                } else {
                    if ($datos['tipoServicio'] == 'C') {
                        $monto = $datos['cuotaCable'];
                        $montoCancelado = 0.00;
                        $separado = ($datos['cuotaCable'] / 1.13);
                        $iva = ($separado * 0.13);
                        $internasGravadas = ($datos['cuotaCable'] - $iva);
                        $debitoFiscal = $datos['totalIva'];
                        $internasGravadas2 = 0;
                        $debitoFiscal2 = 0;
                    } else {
                        $monto = $datos['cuotaInternet'];
                        $montoCancelado = 0.00;
                        $separado = ($datos['cuotaInternet'] / 1.13);
                        $iva = ($separado * 0.13);
                        $internasGravadas = ($datos['cuotaInternet'] - $iva);
                        $debitoFiscal = $datos['totalIva'];
                        $internasGravadas2 = 0;
                        $debitoFiscal2 = 0;
                    }
                }


                $TotalA = $TotalA + $montoCancelado;
                $objPHPExcel->getActiveSheet()->getStyle($g)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle($g)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue($g, $montoCancelado);
                $objPHPExcel->getActiveSheet()->getStyle($g)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->getStyle($g)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

                $TotalB = $TotalB + $internasGravadas;
                $objPHPExcel->getActiveSheet()->getStyle($h)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle($h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue($h, $internasGravadas);
                $objPHPExcel->getActiveSheet()->getStyle($h)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->getStyle($h)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

                $TotalC = $TotalC + $debitoFiscal;
                $objPHPExcel->getActiveSheet()->getStyle($i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle($i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue($i, $debitoFiscal);
                $objPHPExcel->getActiveSheet()->getStyle($i)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->getStyle($i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

                $TotalD = $TotalD + $montoCancelado;
                $objPHPExcel->getActiveSheet()->getStyle($j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle($j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue($j, $montoCancelado);
                $objPHPExcel->getActiveSheet()->getStyle($j)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->getStyle($j)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

                $TotalE = $TotalE + $internasGravadas2;
                $objPHPExcel->getActiveSheet()->getStyle($k)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle($k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue($k, $internasGravadas2);
                $objPHPExcel->getActiveSheet()->getStyle($k)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->getStyle($k)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

                $TotalF = $TotalF + $debitoFiscal2;
                $objPHPExcel->getActiveSheet()->getStyle($l)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle($l)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue($l, $debitoFiscal2);
                $objPHPExcel->getActiveSheet()->getStyle($l)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->getStyle($l)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

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
                $objPHPExcel->getActiveSheet()->getStyle($m)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

                $TotalH = $TotalH + $monto;
                $objPHPExcel->getActiveSheet()->getStyle($n)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle($n)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue($n, $monto);
                $objPHPExcel->getActiveSheet()->getStyle($n)->applyFromArray($style_array);
                $objPHPExcel->getActiveSheet()->getStyle($n)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);


                $celda += 1;
                $contador += 1;
            }
            $celda += 1;
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

            $objPHPExcel->getActiveSheet()->getStyle("G".$celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("G".$celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->setCellValue("G".$celda, $TotalA);
            $objPHPExcel->getActiveSheet()->getStyle("G".$celda)->applyFromArray($style_array);
            $objPHPExcel->getActiveSheet()->getStyle("G".$celda)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

            $objPHPExcel->getActiveSheet()->getStyle("H".$celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("H".$celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->setCellValue("H".$celda, $TotalB);
            $objPHPExcel->getActiveSheet()->getStyle("H".$celda)->applyFromArray($style_array);
            $objPHPExcel->getActiveSheet()->getStyle("H".$celda)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

            $objPHPExcel->getActiveSheet()->getStyle("I".$celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("I".$celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->setCellValue("I".$celda, $TotalC);
            $objPHPExcel->getActiveSheet()->getStyle("I".$celda)->applyFromArray($style_array);
            $objPHPExcel->getActiveSheet()->getStyle("I".$celda)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

            $objPHPExcel->getActiveSheet()->getStyle("J".$celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("J".$celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->setCellValue("J".$celda, $TotalD);
            $objPHPExcel->getActiveSheet()->getStyle("J".$celda)->applyFromArray($style_array);
            $objPHPExcel->getActiveSheet()->getStyle("J".$celda)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

            $objPHPExcel->getActiveSheet()->getStyle("K".$celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("K".$celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->setCellValue("K".$celda, $TotalE);
            $objPHPExcel->getActiveSheet()->getStyle("K".$celda)->applyFromArray($style_array);
            $objPHPExcel->getActiveSheet()->getStyle("K".$celda)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

            $objPHPExcel->getActiveSheet()->getStyle("L".$celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("L".$celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->setCellValue("L".$celda, $TotalF);
            $objPHPExcel->getActiveSheet()->getStyle("L".$celda)->applyFromArray($style_array);
            $objPHPExcel->getActiveSheet()->getStyle("L".$celda)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

            $objPHPExcel->getActiveSheet()->getStyle("M".$celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("M".$celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->setCellValue("M".$celda, $TotalG);
            $objPHPExcel->getActiveSheet()->getStyle("M".$celda)->applyFromArray($style_array);
            $objPHPExcel->getActiveSheet()->getStyle("M".$celda)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

            $objPHPExcel->getActiveSheet()->getStyle("N".$celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("N".$celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->setCellValue("N".$celda, $TotalH);
            $objPHPExcel->getActiveSheet()->getStyle("N".$celda)->applyFromArray($style_array);
            $objPHPExcel->getActiveSheet()->getStyle("N".$celda)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
            
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
