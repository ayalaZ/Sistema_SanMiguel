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
        $soloCargos = $mysqli->query("SELECT * FROM tbl_cargos WHERE codigoCliente='03215' AND tipoServicio='$servicio' AND anulada='0' AND tbl_cargos.mesCargo NOT IN(SELECT mesCargo FROM tbl_abonos WHERE codigoCliente='03215' AND tipoServicio='$servicio' AND anulada='0') AND fechaFactura BETWEEN '$desde' AND '$hasta' ORDER BY mesCargo DESC");
        $cantidadCargos = $soloCargos->num_rows;
        if ($cantidadCargos > 0) {
            while ($datosCargos = $soloCargos->fetch_array()) {
                $pdf->Cell(25, 5, utf8_decode($datosCargos['numeroRecibo']), 'B', 0, 'L');
                $pdf->Cell(25, 5, utf8_decode($datosCargos['tipoServicio']), 'B', 0, 'L');
                $pdf->Cell(30, 5, utf8_decode($datosCargos['numeroFactura']), 'B', 0, 'L');
                $pdf->Cell(30, 5, utf8_decode($datosCargos['mesCargo']), 'B', 0, 'L');
                $pdf->Cell(20, 5, utf8_decode($datosCargos['fechaFactura']), 'B', 0, 'L');
                $pdf->Cell(25, 5, utf8_decode($datosCargos['fechaVencimiento']), 'B', 0, 'L');
                if ($servicio == 'C') {
                    $cuota = $datosCargos['cuotaCable'];
                }else{
                    $cuota = $datosCargos['cuotaInternet'];
                }
                $pdf->Cell(20, 5, number_format($cuota,2), 'B', 0, 'L');
                $pdf->Cell(20, 5, utf8_decode('0.00'), 'B', 0, 'L');
                $pdf->Cell(25, 5, number_format($datosCargos['totalImpuesto'], 2), 'B', 0, 'L');
                $pdf->Cell(25, 5, utf8_decode('0.00'), 'B', 0, 'L');
                $total = $datosCargos['totalImpuesto'] + $cuota;
                $pdf->Cell(20, 5, number_format($total, 2), 'B', 1, 'L');
            }
        }
        $soloAbonos = $mysqli->query();

        $pdf->Output();
        break;
    case 'false':
        echo 'HOLA 2';
        break;
}
