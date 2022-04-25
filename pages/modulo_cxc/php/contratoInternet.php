<?php
require '../../../pdfs/fpdf.php';
require_once("../../../php/config.php");
require '../../../numLe/src/NumerosEnLetras.php';

if (!isset($_SESSION)) {
    session_start();
}

$host = DB_HOST;
$user = DB_USER;
$password = DB_PASSWORD;
$database = $_SESSION['db'];
$mysqli = new mysqli($host, $user, $password, $database);
$codigo = $_GET['id'];
$cliente = $mysqli->query("SELECT * FROM  clientes WHERE cod_cliente='$codigo'");
$datosCliente = $cliente->fetch_array();
//TRAER NUMERO DE CONTRATO
$NumeroContrato = $mysqli->query("SELECT MAX(num_contrato) AS n_contrato FROM tbl_contrato WHERE tipo_servicio='I'");
while ($nuev_NC = $NumeroContrato->fetch_assoc()) {
    $result_NC1 = $nuev_NC["n_contrato"];
    if ($result_NC1 == 'NULL') {
        $result_NC = '1';
    } else {
        $result_NC = $result_NC1 + 1;
    }
    $prefijocontrato = "SM-I";
}

//EMPEZAR PDF
date_default_timezone_set('America/El_Salvador');
$fecha = date('Y-m-d');
$pdf = new FPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P', 'Letter');
$pdf->SetFont('Courier', 'B', 12);
//MARCO
$pdf->SetFillColor(80, 150, 200);
$pdf->Rect(5, 5, 205, 270, 'D');
$pdf->SetXY(10, 10);
//FIN DE MARCO

$pdf->Cell(180, 6, utf8_decode('CONTRATO PARA LA PRESTACION DE SERVICIOS DE INTERNET'), 0, 1, 'C');
$pdf->Image('../../../images/logo.png', 180, 7, 26, 24);
$pdf->Ln(2);
$pdf->Cell(52, 2, 'Numero de contrato: ', 0, 0, 'L');
$pdf->SetFont('Courier', 'B', 8);
$pdf->SetTextColor(194, 8, 8);
$pdf->Cell(18, 2, utf8_decode($prefijocontrato . $result_NC), 0, 1, 'L');
$pdf->Ln(3);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Courier', 'B', 8);
$pdf->Cell(100, 2, 'SECCION PRIMERA: DATOS GENERALES DEL CLIENTE', 0, 0, 'L');
$pdf->Cell(40, 2, utf8_decode('CÓDIGO: '), 0, 0, 'R');
$pdf->SetTextColor(194, 8, 8);
$pdf->Cell(10, 2, $codigo, 0, 1, 'R');
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Courier', '', 8);
$pdf->Ln(2);
$pdf->Cell(30, 3, 'Persona Natural:', 0, 0, 'L');
function checkbox($pdf, $checked)
{
    if ($checked == TRUE) {
        $check = 4;
    } else {
        $check = '';
    }
    $pdf->SetFont('ZapfDingbats', '', 15);
    $pdf->SetTextColor(194, 8, 8);
    $pdf->Cell(3, 3, $check, 1, 1, 'L');
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Courier', '', 8);
}
checkbox($pdf,TRUE);
$pdf->Ln(2);
$pdf->Cell(28, 2, 'Nombre Completo:', 0, 0, 'L');
$pdf->Cell(152, 3, $datosCliente['nombre'], 'B', 1, 'L');
$pdf->Ln(2);
$pdf->Cell(30, 2, 'Nombre Comercial:', 0, 0, 'L');
$pdf->Cell(100, 3, $datosCliente['nombre_comercial'], 'B', 0, 'L');
$pdf->Cell(8, 2, 'NRC:', 0, 0, 'L');
$pdf->Cell(42, 3, $datosCliente['num_registro'], 'B', 1, 'L');
$pdf->Ln(2);
$pdf->Cell(27, 2, 'Email Contacto:', 0, 0, 'L');
$pdf->Cell(50, 3, $datosCliente['correo_electronico'], 'B', 0, 'L');
$pdf->Cell(8, 2, 'DUI:', 0, 0, 'L');
$pdf->Cell(20, 3, $datosCliente['numero_dui'], 'B', 0, 'L');
$pdf->Cell(36, 2, 'Fecha y lugar de exp:', 0, 0, 'L');
$pdf->Cell(39, 3, $datosCliente['lugar_exp'], 'B', 1, 'L');
$pdf->Ln(2);
$pdf->Cell(8, 2, 'NIT:', 0, 0, 'L');
$pdf->Cell(48, 3, $datosCliente['numero_nit'], 'B', 0, 'L');
$pdf->Cell(18, 2, 'Telefonos:', 0, 0, 'L');
$pdf->Cell(50, 3, $datosCliente['telefonos'], 'B', 0, 'L');
$pdf->Cell(23, 2, 'Nacionalidad:', 0, 0, 'L');
$pdf->Cell(33, 3, utf8_decode($datosCliente['nacionalidad']), 'B', 1, 'L');
$pdf->Ln(2);
$pdf->Cell(23, 2, 'Estado civil:', 0, 0, 'L');
$pdf->Cell(33, 3,'', 'B', 0, 'L');
$pdf->Cell(35, 2, 'Nombre del conyugue:', 0, 0, 'L');
$pdf->Cell(89, 3,'', 'B', 1, 'L');
$pdf->Ln(2);
$pdf->Cell(18, 2, 'Ocupacion:', 0, 0, 'L');
$pdf->Cell(30, 3, '', 'B', 0, 'L');
$pdf->Cell(30, 2, 'Lugar de trabajo:', 0, 0, 'L');
$pdf->Cell(60, 3, '', 'B', 0, 'L');
$pdf->Cell(12, 2, 'Cargo:', 0, 0, 'L');
$pdf->Cell(30, 3, '', 'B', 1, 'L');
$pdf->Ln(2);
$pdf->Cell(28, 2, 'Ingreso mensual:', 0, 0, 'L');
$pdf->Cell(30, 3, '', 'B', 0, 'L');
$pdf->Cell(27, 2, 'Jefe inmediato:', 0, 0, 'L');
$pdf->Cell(33, 3, '', 'B', 0, 'L');
$pdf->Cell(24, 2, 'Tel. trabajo:', 0, 0, 'L');
$pdf->Cell(38, 3, $datosCliente['tel_trabajo'], 'B', 1, 'L');
$pdf->Ln(2);
$pdf->Cell(38, 2, 'Direccion del trabajo:', 0, 0, 'L');
$pdf->Cell(142, 3, '', 'B', 1, 'L');
$pdf->Ln(2);
$pdf->Cell(180, 3, '', 'B', 1, 'L');
$pdf->Ln(2);
$pdf->Cell(45, 2, 'Direccion del instalacion:', 0, 0, 'L');
$pdf->MultiCell(135,3,strtoupper($datosCliente['direccion']),'B','L',0);
mysqli_close($mysqli);
$pdf->Output();
