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
$pdf->SetFont('Courier', 'B', 10);
$pdf->SetTextColor(194, 8, 8);
$pdf->Cell(18, 2, utf8_decode($prefijocontrato.$result_NC), 0, 1, 'L');
$pdf->Ln(3);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Courier', 'B', 10);
$pdf->Cell(110, 2, 'SECCION PRIMERA: DATOS GENERALES DEL CLIENTE', 0, 0, 'L');
$pdf->Cell(40, 2, utf8_decode('CÓDIGO: '), 0, 0, 'R');
$pdf->SetTextColor(0,0,0);
$pdf->Cell(10,2,$codigo,0,1,'R');
$pdf->SetFont('Courier', '', 10);
$pdf->Ln(3);
$pdf->Cell(180, 2, 'Persona Natural:',0,0,'L');
mysqli_close($mysqli);
$pdf->Output();
