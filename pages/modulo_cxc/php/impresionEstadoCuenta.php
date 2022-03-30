<?php
require_once("../../../php/config.php");
require '../PHPExcel/Classes/PHPExcel.php';
$host = DB_HOST;
$user = DB_USER;
$password = DB_PASSWORD;
$usuario = $_SESSION['nombres'] . ' ' . $_SESSION['apellidos'];
if (!isset($_SESSION)) {
    session_start([
        'cookie_lifetime' => 86400,
    ]);
}
if (!isset($_SESSION["user"])) {
    header('Location: ../../login.php');
}

$database = $_SESSION['db'];
$mysqli = new mysqli($host, $user, $password, $database);
$desde = $_POST['desde'];
$hasta = $_POST['hasta'];
$codigo = $_POST['codigo'];
$servicio = $_POST['servicio'];
$documento = $_POST['documento'];
switch ($documento) {
    case 'true':
        require '../../../pdfs/fpdf.php';

        class PDF extends FPDF
        {
            // Cabecera de página
            function Header()
            {
                $this->SetFont('Arial', '', 7);
                $this->Cell(260, 6, utf8_decode("Página " . str_pad($this->pageNo(), 4, "0", STR_PAD_LEFT)), 0, 1, 'R');
                $this->Cell(260, 4, utf8_decode("GENERADO POR: " . strtoupper($_SESSION['nombres']) . " " . strtoupper($_SESSION['apellidos']) . " " . date('d/m/Y h:i:s')), "", 1, 'R');
                $this->Image('../../../images/logo.png', 10, 10, 20, 18);
                $this->Ln(10);
                $this->SetFont('Arial', 'B', 9);
                $this->Cell(190, 4, utf8_decode('CABLE VISION POR SATELITE, S.A DE C.V.'), 0, 1, 'L');
                $this->SetFont('Arial', 'B', 7.5);
                $this->Cell(190, 4, utf8_decode('ESTADO DE CUENTA'), 0, 1, 'L');
                if ($_SESSION['db'] == 'satpro_sm') {
                    $this->Cell(190, 4, utf8_decode('SUCURSAL SAN MIGUEL'), 0, 1, 'L');
                } elseif ($_SESSION['db'] == 'satpro') {
                    $this->Cell(190, 4, utf8_decode('SUCURSAL USULUTÁN'), 0, 1, 'L');
                } else {
                    $this->Cell(190, 4, utf8_decode('SUCURSAL DE PRUEBA'), 0, 1, 'L');
                }
            }
        }

        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage("L", 'Letter');
        $cliente = $mysqli->query("SELECT nombre, direccion, estado_cliente_in, servicio_suspendido, sin_servicio FROM clientes WHERE cod_cliente='$codigo'");
        $datos = $cliente->fetch_array();
        $CsusServido = $datos['servicio_suspendido'];
        $CsinServicio = $datos['sin_servicio'];
        if ($CsusServido == "T" && $CsinServicio == "F") {
            $estadoCable = 'Suspendido';
        } elseif ($CsusServido != "T" && $CsinServicio == "T") {
            $estadoCable = 'Sin Servicio';
        } elseif ($CsusServido != "T" && $CsinServicio == "F") {
            $estadoCable = 'Activo';
        }
        $estado = $datos["estado_cliente_in"];
        if ($estado == 2) {
            $estadoInternet = 'Suspendido';
        } elseif ($estado == 3) {
            $estadoInternet = 'Sin servicio';
        } elseif ($estado == 1) {
            $estadoInternet = 'Activo';
        }
        $pdf->SetFont('Arial', '', 7.5);
        $pdf->Cell(130, 4, utf8_decode("CLIENTE: " . $codigo . " " . $datos['nombre']), 0, 0, 'L');
        $pdf->Cell(130, 4, utf8_decode(strtoupper("CABLE: " . $estadoCable)), 0, 1, 'R');
        $pdf->Cell(130, 4, utf8_decode("DIRECCIÓN: " . substr($datos['direccion'], 0, 130)), 0, 0, 'L');
        $pdf->Cell(130, 4, utf8_decode(strtoupper("INTERNET: " . $estadoInternet)), 0, 1, 'R');
        $pdf->SetFont('Arial', '', 7.5);
        $pdf->Cell(190, 4, utf8_decode('DESDE ' . $desde . ' HASTA ' . $hasta), 0, 1, 'L');
        $pdf->Ln(2);
        $pdf->SetFont('Arial', 'B', 9);
        //$pdf->Cell(20,5,utf8_decode('N°'),1,0,'L');
        $pdf->Cell(25, 5, utf8_decode('N° de recibo'), 'B', 0, 'L');
        $pdf->Cell(25, 5, utf8_decode('Tipo servicio'), 'B', 0, 'L');
        $pdf->Cell(30, 5, utf8_decode('N° comprobante'), 'B', 0, 'L');
        $pdf->Cell(30, 5, utf8_decode('Mes de servicio'), 'B', 0, 'L');
        $pdf->Cell(20, 5, utf8_decode('Aplicación'), 'B', 0, 'L');
        $pdf->Cell(25, 5, utf8_decode('Vencimiento'), 'B', 0, 'L');
        $pdf->Cell(20, 5, utf8_decode('Cargo'), 'B', 0, 'L');
        $pdf->Cell(20, 5, utf8_decode('Abono'), 'B', 0, 'L');
        $pdf->Cell(25, 5, utf8_decode('CESC cargo'), 'B', 0, 'L');
        $pdf->Cell(25, 5, utf8_decode('CESC abono'), 'B', 0, 'L');
        $pdf->Cell(20, 5, utf8_decode('TOTAL'), 'B', 1, 'L');
        $pdf->Cell(265, 1, utf8_decode(''), 'B', 1, 'L');
        $pdf->Ln(3);
        $pdf->SetFont('Helvetica', '', 9);
        $soloCargos = $mysqli->query("SELECT * FROM tbl_cargos WHERE codigoCliente='$codigo' AND tipoServicio='$servicio' AND anulada='0' AND tbl_cargos.mesCargo NOT IN(SELECT mesCargo FROM tbl_abonos WHERE codigoCliente='$codigo' AND tipoServicio='$servicio' AND anulada='0') AND fechaFactura BETWEEN '$desde' AND '$hasta' ORDER BY mesCargo DESC");
        $cantidadCargos = $soloCargos->num_rows;
        if ($cantidadCargos > 0) {
            while ($datosCargos = $soloCargos->fetch_array()) {
                $pdf->Cell(25, 5, utf8_decode($datosCargos['numeroRecibo']), 'B', 0, 'L');
                $pdf->Cell(25, 5, utf8_decode($datosCargos['tipoServicio']), 'B', 0, 'C');
                $pdf->Cell(30, 5, utf8_decode($datosCargos['numeroFactura']), 'B', 0, 'L');
                $pdf->Cell(30, 5, utf8_decode($datosCargos['mesCargo']), 'B', 0, 'C');
                $pdf->Cell(20, 5, utf8_decode($datosCargos['fechaFactura']), 'B', 0, 'L');
                $pdf->Cell(25, 5, utf8_decode($datosCargos['fechaVencimiento']), 'B', 0, 'L');
                if ($servicio == 'C') {
                    $cuota = $datosCargos['cuotaCable'];
                } else {
                    $cuota = $datosCargos['cuotaInternet'];
                }
                $pdf->Cell(20, 5, number_format($cuota, 2), 'B', 0, 'L');
                $pdf->Cell(20, 5, utf8_decode('0.00'), 'B', 0, 'L');
                $pdf->Cell(25, 5, number_format($datosCargos['totalImpuesto'], 2), 'B', 0, 'L');
                $pdf->Cell(25, 5, utf8_decode('0.00'), 'B', 0, 'L');
                $total = $datosCargos['totalImpuesto'] + $cuota;
                $pdf->Cell(20, 5, number_format($total, 2), 'B', 1, 'L');
                $totalCargos = $totalCargos + $total;
            }
        }
        $soloAbonos = $mysqli->query("SELECT * FROM tbl_abonos WHERE codigoCliente='$codigo' AND tipoServicio='$servicio' AND anulada='0' AND tbl_abonos.mesCargo NOT IN(SELECT mesCargo FROM tbl_cargos WHERE codigoCliente='$codigo' AND tipoServicio='$servicio' AND annulada='0') AND fechaAbonado BETWEEN '$desde' AND '$hasta' ORDER BY mesCargo DESC");
        $cantidadAbonos = $soloAbonos->num_rows;
        if ($cantidadAbono > 0) {
            while ($datosAbonos = $soloAbonos->fetch_array()) {
                $pdf->Cell(25, 5, utf8_decode($datosAbonos['numeroRecibo']), 'B', 0, 'L');
                $pdf->Cell(25, 5, utf8_decode($datosAbonos['tipoServicio']), 'B', 0, 'C');
                $pdf->Cell(30, 5, utf8_decode($datosAbonos['numeroFactura']), 'B', 0, 'L');
                $pdf->Cell(30, 5, utf8_decode($datosAbonos['mesCargo']), 'B', 0, 'C');
                $pdf->Cell(20, 5, utf8_decode($datosAbonos['fechaAbonado']), 'B', 0, 'L');
                $pdf->Cell(25, 5, utf8_decode($datosAbonos['fechaVencimiento']), 'B', 0, 'L');
                if ($servicio == 'C') {
                    $cuota = $datosAbonos['cuotaCable'];
                } else {
                    $cuota = $datosAbonos['cuotaInternet'];
                }
                $pdf->Cell(20, 5, utf8_decode('0.00'), 'B', 0, 'L');
                $pdf->Cell(20, 5, number_format($cuota, 2), 'B', 0, 'L');
                $pdf->Cell(25, 5, utf8_decode('0.00'), 'B', 0, 'L');
                $pdf->Cell(25, 5, number_format($datosAbonos['totalImpuesto'], 2), 'B', 0, 'L');
                $total = $datosAbonos['totalImpuesto'] + $cuota;
                $pdf->Cell(20, 5, number_format($total, 2), 'B', 1, 'L');
                $totalAbonos = $totalAbonos + $total;
            }
        }
        $todo = $mysqli->query("SELECT c.estado as estadoCargo, c.numeroFactura as facturaCargo, c.numeroRecibo as reciboCargo, c.mesCargo as cargoCargo, c.tipoServicio as servicioCargo, c.fechaFactura as fechaFacturaCargo, c.fechaVencimiento as fechaVencimientoCargo, c.cuotaCable as cuotaCableCargo, c.cuotaInternet as cuotaInterCargo, c.totalImpuesto as totalImpuestoCargo, a.estado as estadoAbono, a.numeroFactura as facturaAbono, a.numeroRecibo as reciboAbono, a.mesCargo as cargoAbono, a.tipoServicio as servicioAbono, a.fechaAbonado as fechaAbonadoAbono, a.fechaVencimiento as fechaVencimientoAbono, a.cuotaCable as cuotaCableAbono, a.cuotaInternet as cuotaInterAbono, a.totalImpuesto as totalImpuestoAbono
                                 FROM tbl_cargos AS c INNER JOIN tbl_abonos AS a ON (c.codigoCliente=a.codigoCliente) WHERE c.tipoServicio='$servicio' AND a.tipoServicio='$servicio' AND (c.mesCargo=a.mesCargo) AND c.codigoCliente='$codigo' AND a.codigoCliente='$codigo' AND c.anulada='0' AND a.anulada='0' AND c.fechaFactura BETWEEN '$desde' AND '$hasta' AND a.fechaAbonado BETWEEN '$desde' AND '$hasta' ORDER BY CAST(CONCAT(substring(c.mesCargo,4,4), '-', substring(c.mesCargo,1,2),'-', '01') AS DATE) DESC");
        $cantidad = $todo->num_rows;
        if ($cantidad > 0) {
            while ($datos = $todo->fetch_array()) {
                $pdf->Cell(25, 5, utf8_decode($datos['reciboCargo']), 'B', 0, 'L');
                $pdf->Cell(25, 5, utf8_decode($datos['servicioCargo']), 'B', 0, 'C');
                $pdf->Cell(30, 5, utf8_decode($datos['facturaCargo']), 'B', 0, 'L');
                $pdf->Cell(30, 5, utf8_decode($datos['cargoCargo']), 'B', 0, 'C');
                $pdf->Cell(20, 5, utf8_decode($datos['fechaFacturaCargo']), 'B', 0, 'L');
                $pdf->Cell(25, 5, utf8_decode($datos['fechaVencimientoCargo']), 'B', 0, 'L');
                if ($servicio == 'C') {
                    $cuota = $datos['cuotaCableCargo'];
                } else {
                    $cuota = $datos['cuotaInterCargo'];
                }
                $pdf->Cell(20, 5, number_format($cuota, 2), 'B', 0, 'L');
                $pdf->Cell(20, 5, utf8_decode('0.00'), 'B', 0, 'L');
                $pdf->Cell(25, 5, number_format($datos['totalImpuestoCargo'], 2), 'B', 0, 'L');
                $pdf->Cell(25, 5, utf8_decode('0.00'), 'B', 0, 'L');
                $total = $datos['totalImpuestoCargo'] + $cuota;
                $pdf->Cell(20, 5, number_format($total, 2), 'B', 1, 'L');
                $totalCargos = $totalCargos + $total;
                ///////////////////////////////////////////////////////////////////////////////////////////////////////////
                $pdf->Cell(25, 5, utf8_decode($datos['reciboAbono']), 'B', 0, 'L');
                $pdf->Cell(25, 5, utf8_decode($datos['servicioAbono']), 'B', 0, 'C');
                $pdf->Cell(30, 5, utf8_decode($datos['facturaAbono']), 'B', 0, 'L');
                $pdf->Cell(30, 5, utf8_decode($datos['cargoAbono']), 'B', 0, 'C');
                $pdf->Cell(20, 5, utf8_decode($datos['fechaAbonadoAbono']), 'B', 0, 'L');
                $pdf->Cell(25, 5, utf8_decode($datos['fechaVencimientoAbono']), 'B', 0, 'L');
                if ($servicio == 'C') {
                    $cuota = $datos['cuotaCableAbono'];
                } else {
                    $cuota = $datos['cuotaInterAbono'];
                }
                $pdf->Cell(20, 5, utf8_decode('0.00'), 'B', 0, 'L');
                $pdf->Cell(20, 5, number_format($cuota, 2), 'B', 0, 'L');
                $pdf->Cell(25, 5, utf8_decode('0.00'), 'B', 0, 'L');
                $pdf->Cell(25, 5, number_format($datos['totalImpuestoAbono'], 2), 'B', 0, 'L');
                $total = $datos['totalImpuestoAbono'] + $cuota;
                $pdf->Cell(20, 5, number_format($total, 2), 'B', 1, 'L');
                $totalAbonos = $totalAbonos + $total;
            }
        }
        $totaldetotal = $totalCargos - $totalAbonos;
        $pdf->SetFont('Helvetica', 'B', 9);
        $pdf->Cell(235, 5, utf8_decode(""), "", 0, 'R');
        $pdf->Cell(29, 5, utf8_decode("TOTAL A COBRAR"), "B", 1, 'R');
        $pdf->Cell(235, 5, utf8_decode(""), "", 0, 'R');
        $pdf->Cell(29, 5, utf8_decode($totaldetotal), 1, 1, 'C');
        $pdf->SetFont('Helvetica', '', 9);
        $pdf->Output();
        break;
    case 'false':
        $cliente = $mysqli->query("SELECT nombre, direccion, estado_cliente_in, servicio_suspendido, sin_servicio FROM clientes WHERE cod_cliente='$codigo'");
        $datos = $cliente->fetch_array();
        $CsusServido = $datos['servicio_suspendido'];
        $CsinServicio = $datos['sin_servicio'];
        if ($CsusServido == "T" && $CsinServicio == "F") {
            $estadoCable = 'Suspendido';
        } elseif ($CsusServido != "T" && $CsinServicio == "T") {
            $estadoCable = 'Sin Servicio';
        } elseif ($CsusServido != "T" && $CsinServicio == "F") {
            $estadoCable = 'Activo';
        }
        $estado = $datos["estado_cliente_in"];
        if ($estado == 2) {
            $estadoInternet = 'Suspendido';
        } elseif ($estado == 3) {
            $estadoInternet = 'Sin servicio';
        } elseif ($estado == 1) {
            $estadoInternet = 'Activo';
        }
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()
            ->setCreator($usuario)
            ->setTitle('Reporte')
            ->setDescription('Estado de cuenta')
            ->setKeywords('excel cable sat cliente')
            ->setCategory('Reporte');

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Hoja1");
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.5);
        $objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.25);
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

        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(12)->setBold(false)->setName('ARIAL');
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getAlignment()->setWrapText(true);

        $objPHPExcel->getActiveSheet()->mergeCells('A1:K1');
        $objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'CABLE VISION POR SATELITE, S.A. DE C.V');
        $objPHPExcel->getActiveSheet()->mergeCells('A2:K2');
        $objPHPExcel->getActiveSheet()->getStyle('A2:K2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'ESTADO DE CUENTA');
        if ($_SESSION['db'] == 'satpro_sm') {
            $sucursal = "SUCURSAL SAN MIGUEL";
        } elseif ($_SESSION['db'] == 'satpro') {
            $sucursal = "SUCURSAL USULUTAN";
        } else {
            $sucursal = "SUCURSAL DE PRUEBA";
        }
        $objPHPExcel->getActiveSheet()->mergeCells('A3:K3');
        $objPHPExcel->getActiveSheet()->getStyle('A3:K3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('A3', $sucursal);

        $objPHPExcel->getActiveSheet()->mergeCells('A4:E4');
        $objPHPExcel->getActiveSheet()->setCellValue('A4', "CLIENTE: " . $codigo . " " . $datos['nombre']);

        $objPHPExcel->getActiveSheet()->mergeCells('A5:I6');
        $objPHPExcel->getActiveSheet()->setCellValue('A5', "DIRECCIÓN: " . $datos['direccion']);
        $objPHPExcel->getActiveSheet()->getStyle('A5:I6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $objPHPExcel->getActiveSheet()->mergeCells('J5:K5');
        $objPHPExcel->getActiveSheet()->setCellValue('J5', "CABLE: " . $estadoCable);

        $objPHPExcel->getActiveSheet()->mergeCells('J6:K6');
        $objPHPExcel->getActiveSheet()->setCellValue('J6', "INTERNET: " . $estadoInternet);

        $objPHPExcel->getActiveSheet()->mergeCells('A7:D7');
        $objPHPExcel->getActiveSheet()->setCellValue('A7', 'DESDE ' . $desde . ' HASTA ' . $hasta);
        $objPHPExcel->getActiveSheet()->getStyle('A7:D7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);

        $objPHPExcel->getActiveSheet()->setCellValue('A8', "N° de recibo");
        $objPHPExcel->getActiveSheet()->getStyle('A8')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B8', "Tipo de servicio");
        $objPHPExcel->getActiveSheet()->getStyle('B8')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('C8', "N° comprobante");
        $objPHPExcel->getActiveSheet()->getStyle('C8')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('D8', "Mes de servicio");
        $objPHPExcel->getActiveSheet()->getStyle('D8')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('E8', "Aplicacion");
        $objPHPExcel->getActiveSheet()->getStyle('E8')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('F8', "Vencimiento");
        $objPHPExcel->getActiveSheet()->getStyle('F8')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('G8', "Cargo");
        $objPHPExcel->getActiveSheet()->getStyle('G8')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('H8', "Abono");
        $objPHPExcel->getActiveSheet()->getStyle('H8')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('I8', "CESC Cargo");
        $objPHPExcel->getActiveSheet()->getStyle('I8')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('J8', "CESC Abono");
        $objPHPExcel->getActiveSheet()->getStyle('J8')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('K8', "TOTAL");
        $objPHPExcel->getActiveSheet()->getStyle('K8')->getFont()->setBold(true);

        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download; charset='utf-8'");
        header("Content-Type: application/octet-stream; charset='utf-8'");
        header("Content-Type: application/download; charset='utf-8'");;
        header("Content-Disposition: attachment;filename=Estado_de_cuenta.xls"); //Nombre del archivo
        header("Content-Transfer-Encoding: binary ");
        // $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        // $objWriter->setOffice2003Compatibility(true);

        $objWritter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWritter->save('php://output');
        break;
}
