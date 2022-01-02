<?php
require '../../../pdfs/fpdf.php';
require_once("../../../php/config.php");
require_once("../getDatos.php");
require '../../../numLe/src/NumerosEnLetras.php';
if (!isset($_SESSION)) {
    session_start();
}
$host = DB_HOST;
$user = DB_USER;
$password = DB_PASSWORD;
$database = $_SESSION['db'];
$mysqli = new mysqli($host, $user, $password, $database);

$mesGenerar = $_POST['mesGenerar']; //NECESARIO PARA LA CONSULTA
$anoGenerar = $_POST['anoGenerar']; //NECESARIO PARA LA CONSULTA
$tipoFacturaGenerar = $_POST['facturas']; //1Normal, 2Pequeñas, 3Anuladas, 4Todas
$encabezados = null;
$numPag = null;
$libroDetallado = null;
// SQL query para traer datos del servicio de cable de la tabla impuestos
$query = "SELECT valorImpuesto FROM tbl_impuestos WHERE siglasImpuesto = 'IVA'";
// Preparación de sentencia
$statement = $mysqli->query($query);
//$statement->execute();
while ($result = $statement->fetch_assoc()) {
    $iva = floatval($result['valorImpuesto']);
}
// SQL query para traer datos del servicio de cable de la tabla impuestos
$query = "SELECT valorImpuesto FROM tbl_impuestos WHERE siglasImpuesto = 'CESC'";
// Preparación de sentencia
$statement = $mysqli->query($query);
//$statement->execute();
while ($result = $statement->fetch_assoc()) {
    $cesc = floatval($result['valorImpuesto']);
}

if (isset($_POST["encabezados"])) {
    $encabezados = 1;
}
if (isset($_POST["numPag"])) {
    $numPag = 1;
}
if (isset($_POST["libroDetallado"])) {
    $libroDetallado = 1;
}

$mesGenerarLetra = null;
switch ($mesGenerar) {
    case '1':
        $mesGenerarLetra = "ENERO";
        break;
    case '2':
        $mesGenerarLetra = "FEBRERO";
        break;
    case '3':
        $mesGenerarLetra = "MARZO";
        break;
    case '4':
        $mesGenerarLetra = "ABRIL";
        break;
    case '5':
        $mesGenerarLetra = "MAYO";
        break;
    case '6':
        $mesGenerarLetra = "JUNIO";
        break;
    case '7':
        $mesGenerarLetra = "JULIO";
        break;
    case '8':
        $mesGenerarLetra = "AGOSTO";
        break;
    case '9':
        $mesGenerarLetra = "SEPTIEMBRE";
        break;
    case '10':
        $mesGenerarLetra = "OCTUBRE";
        break;
    case '11':
        $mesGenerarLetra = "NOVIEMBRE";
        break;
    case '12':
        $mesGenerarLetra = "DICIEMBRE";
        break;
    default:
        $mesGenerarLetra = "N/A";
}

function libroConsumidorFinal()
{
    global $encabezados, $mysqli, $numPag, $mesGenerarLetra, $anoGenerar, $libroDetallado;
    global $counter, $counter2, $counterLine, $tipoFacturaGenerar, $stmt, $iva, $mesGenerar;
    global $totalConIvaExento, $totalSinIvaExento, $totalSinIva, $totalConIva, $totalesCable;
    global $totalSoloIva, $totalSoloCesc, $totalesCescCable;
    global $totalConIvaExentoConsumidor, $totalConIvaExentonConsumidor2, $totalConIvaExentoFacturaFinal, $totalSinIvaConsumidor, $totalSinIvaConsumidor2, $totalSinIvaFacturaFinal;
    global $totalSoloIvaConsumidor, $totalSoloIvaConsumidor2, $totalSoloIvaFacturaFinal, $totalSoloCescConsumidor, $totalSoloCescConsumidor2, $totalSoloCescFacturaFinal;
    global $totalConIvaConsumidor, $totalSinIvaExentoConsumidor, $totalConIvaExentoConsumidor2, $totalConIvaConsumidor2, $totalSinIvaExentoConsumidor2;

    $pdf = new FPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('L', 'Letter');
    date_default_timezone_set('America/El_Salvador');
    if ($encabezados == 1) {
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(260, 6, utf8_decode('LIBRO O REGISTRO DE OPERACIONES CON EMISION DE CREDITO FISCAL'), 0, 0, 'C');
        $pdf->Ln(5);
    }
    if ($numPag == 1) {
        $pdf->Cell(260, 6, utf8_decode("Página " . str_pad($pdf->pageNo(), 4, "0", STR_PAD_LEFT)), 0, 1, 'R');
    }
    $pdf->SetFont('Times', 'B', 8);
    //####################################################################################################
    $pdf->Ln(6);
    $pdf->Cell(260, 6, utf8_decode($mesGenerarLetra . " " . $anoGenerar . " " . '( VALORES EXPRESADOS EN US DOLARES )'), 0, 1, 'C');
    $pdf->SetFont('Times', 'B', 10);
    //FILA 1
    $pdf->Cell(50, 6, utf8_decode(''), "TLR", 0, 'C');
    $pdf->SetFont('Times', 'B', 5);
    $pdf->Cell(15, 6, utf8_decode('N° DE'), "T", 0, 'C');
    $pdf->SetFont('Times', 'B', 6);
    $pdf->Cell(60, 6, utf8_decode(''), "TLR", 0, 'C');
    $pdf->Cell(15, 6, utf8_decode(''), 'TLR', 0, 'C');
    $pdf->Cell(110, 6, utf8_decode('OPERACIONES DE VENTAS PROPIAS Y A CUENTA DE TERCEROS'), 'TBLR', 0, 'C');
    $pdf->Cell(15, 6, utf8_decode(''), 'TLR', 1, 'C');

    //FILA 2
    $pdf->Cell(50, 6, utf8_decode(''), "LR", 0, 'C');
    $pdf->SetFont('Times', 'B', 5);
    $pdf->Cell(15, 6, utf8_decode('FORMULARIO'), "LR", 0, 'C');
    $pdf->SetFont('Times', 'B', 6);
    $pdf->Cell(60, 6, utf8_decode(''), "LR", 0, 'C');
    $pdf->Cell(15, 6, utf8_decode(''), 'LR', 0, 'C');
    $pdf->Cell(47.5, 6, utf8_decode('PROPIAS'), "LRTB", 0, 'C');
    $pdf->Cell(47.5, 6, utf8_decode('A CUENTA DE TERCEROS'), 1, 0, 'C');
    $pdf->Cell(15, 6, utf8_decode('IVA'), "TLR", 0, 'C');
    $pdf->Cell(15, 6, utf8_decode('TOTAL'), 'LR', 1, 'C');

    //FILA 3
    $pdf->SetFont('Times', 'B', 5);
    $pdf->Cell(10, 6, utf8_decode('N°'), 1, 0, 'C');
    $pdf->SetFont('Times', 'B', 4.5);
    $pdf->Cell(20, 6, utf8_decode('FECHA DE EMISION'), 1, 0, 'C');
    $pdf->SetFont('Times', 'B', 4.5);
    $pdf->Cell(20, 6, utf8_decode('CORRELATIVO'), 1, 0, 'C');
    $pdf->SetFont('Times', 'B', 5);
    $pdf->Cell(15, 6, utf8_decode('UNICO'), "BLR", 0, 'C');
    $pdf->SetFont('Times', 'B', 5);

    $pdf->Cell(60, 6, utf8_decode('NOMBRE DEL CLIENTE'), 1, 0, 'C');
    $pdf->Cell(15, 6, utf8_decode('NRC'), 'LRB', 0, 'C');
    $pdf->SetFont('Times', 'B', 4.5);
    $pdf->Cell(12.5, 6, utf8_decode('EXENTAS'), "BLR", 0, 'C');
    $pdf->Cell(20, 6, utf8_decode('INTERNAS GRAVADAS'), 1, 0, 'C');
    $pdf->Cell(15, 6, utf8_decode('DÉBITO FISCAL'), 1, 0, 'C');
    $pdf->SetFont('Times', 'B', 4.5);
    $pdf->Cell(10, 6, utf8_decode('EXENTAS'), "BLR", 0, 'C');
    $pdf->Cell(20, 6, utf8_decode('INTERNAS GRAVADAS'), 1, 0, 'C');
    $pdf->Cell(17.5, 6, utf8_decode('DÉBITO FISCAL'), 1, 0, 'C');
    $pdf->SetFont('Times', 'B', 5);
    $pdf->Cell(15, 6, utf8_decode('RETENIDO'), "BLR", 0, 'C');
    $pdf->Cell(15, 6, utf8_decode(''), 'BLR', 1, 'C');
    $pdf->SetFont('Times', 'B', 5);

    //LIBRO DETALLADO
    if ($libroDetallado == 1) {
        $pdf->Ln(3);
        $pdf->SetFont('Times', '', 7);
        $counter = 1;
        $counter2 = 1;
        $counterLine = 1;
        $inicio = $anoGenerar . "-" . $mesGenerar . "-01";
        $fin = $anoGenerar . "-" . $mesGenerar . "-31";
        if ($tipoFacturaGenerar == 1) {
            $sql =  "SELECT *, (SELECT num_registro FROM clientes WHERE clientes.cod_cliente=tbl_cargos.codigoCliente) AS nRegistro FROM tbl_cargos WHERE (fechaFactura BETWEEN '$inicio' AND '$fin') AND tipoFactura = 1";
            $stmt = $mysqli->query($sql);
            while ($result = $stmt->fetch_assoc()) {
                if ($result["tipoServicio"] == "C") {
                    $montoCancelado = doubleval($result["cuotaCable"]);
                } elseif ($result["tipoServicio"] == "I") {
                    $montoCancelado = doubleval($result["cuotaInternet"]);
                }

                $separado = (doubleval($montoCancelado) / (1 + doubleval($iva)));
                $totaliva = substr(doubleval($separado) * doubleval($iva), 0, 7);

                $pdf->Cell(10, 1, utf8_decode($counterLine), 0, 0, 'L');
                $pdf->Cell(20, 1, utf8_decode($result['fechaFactura']), 0, 0, 'L');
                $pdf->Cell(20, 1, utf8_decode(substr($result['numeroFactura'], 9, 7)), 0, 0, 'L');
                $pdf->Cell(15, 1, utf8_decode(0), 0, 0, 'L');
                $pdf->SetFont('Times', '', 5.8);
                $caracteres = strlen($result["nombre"]);
                if ($caracteres >= 47) {
                    $recortado = substr($result["nombre"], 0, 46);
                    $pdf->Cell(60, 1, utf8_decode($recortado), 0, 0, 'L');
                } else {
                    $pdf->Cell(60, 1, utf8_decode($result["nombre"]), 0, 0, 'L');
                }

                if ($result["nombre"] == "<<< Comprobante anulado >>>") {
                    $pdf->Cell(15, 1, "", 0, 0, 'L');
                } else {
                    $pdf->Cell(15, 1, utf8_decode($result["nRegistro"]), 0, 0, 'L');
                }
                $pdf->SetFont('Times', '', 7);

                $sinIva = doubleval($montoCancelado) - doubleval($totaliva);
                $codigo = $result["codigoCliente"];
                $sql2 = "SELECT * FROM clientes WHERE cod_cliente='$codigo' AND exento='T'";
                $resultado = $mysqli->query($sql2);
                $resultado = mysqli_num_rows($resultado);
                if ($resultado > 0) {
                    $pdf->Cell(12.5, 1, utf8_decode($montoCancelado), 0, 0, 'L');
                    $pdf->Cell(20, 1, utf8_decode("0.00"), 0, 0, 'L');
                    $pdf->Cell(15, 1, utf8_decode("0.00"), 0, 0, 'L');
                    $totalSinIvaExento = $totalSinIvaExento + $sinIva;
                    $totalConIvaExento = $totalConIvaExento + $montoCancelado;
                } else {
                    $pdf->Cell(12.5, 1, utf8_decode("0.00"), 0, 0, 'L');
                    $pdf->Cell(20, 1, utf8_decode(number_format($sinIva, 2)), 0, 0, 'L');
                    $pdf->Cell(15, 1, utf8_decode(number_format($result['totalIva'], 2)), 0, 0, 'L');
                    $totalSinIva = $totalSinIva + $sinIva;
                    $totalConIva = $totalConIva + $montoCancelado;
                    $totalesCable = $totalesCable + $montoCancelado;
                }

                if ($resultado > 0) {
                    $pdf->Cell(10, 1, utf8_decode($montoCancelado), 0, 0, 'L');
                    $pdf->Cell(20, 1, utf8_decode("0.00"), 0, 0, 'L');
                    $pdf->Cell(17.5, 1, utf8_decode("0.00"), 0, 0, 'L');
                } else {
                    $pdf->Cell(10, 1, utf8_decode("0.00"), 0, 0, 'L');
                    $pdf->Cell(20, 1, utf8_decode(number_format(0, 2)), 0, 0, 'L');
                    $pdf->Cell(17.5, 1, utf8_decode("0.00"), 0, 0, 'L');
                }
                $totalSoloIva = $totalSoloIva + $totaliva;
                $totalSoloCesc = $totalSoloCesc + doubleval($result["totalImpuesto"]);
                $totalesCescCable = $totalesCescCable + doubleval($result["totalImpuesto"]);
                //$pdf->Cell(20,1,utf8_decode($montoCancelado),0,1,'L');
                $pdf->Cell(15, 1, utf8_decode('0.00'), 0, 0, 'L');
                //$pdf->Cell(15,1,utf8_decode(number_format($result["totalImpuesto"],2)),0,0,'L');
                $pdf->Cell(15, 1, utf8_decode(number_format(doubleval($montoCancelado)/*+doubleval($result["totalImpuesto"])*/, 2)), 0, 1, 'L');
                $pdf->Ln(3);
                $counterLine++;

                if ($counter2 > 50) {
                    $pdf->AddPage('L', 'Letter');

                    $pdf->SetFont('Times', 'B', 10);
                    $pdf->Cell(260, 6, utf8_decode('LIBRO O REGISTRO DE OPERACIONES CON EMISION DE CREDITO FISCAL'), 0, 0, 'C');
                    $pdf->Ln(5);
                    $pdf->SetFont('Times', 'B', 8);
                    $pdf->Cell(260, 6, utf8_decode('VALORES EXPRESADOS EN US DOLARES'), 0, 1, 'C');
                    $pdf->Cell(260, 3, utf8_decode($mesGenerarLetra . " " . $anoGenerar), 0, 0, 'C');
                    $pdf->Ln(6);

                    $pdf->SetFont('Times', 'B', 10);
                    //FILA 1
                    $pdf->Cell(50, 6, utf8_decode(''), "TLR", 0, 'C');
                    $pdf->SetFont('Times', 'B', 5);
                    $pdf->Cell(15, 6, utf8_decode('N° DE'), "T", 0, 'C');
                    $pdf->SetFont('Times', 'B', 6);
                    $pdf->Cell(60, 6, utf8_decode(''), "TLR", 0, 'C');
                    $pdf->Cell(15, 6, utf8_decode(''), 'TLR', 0, 'C');
                    $pdf->Cell(110, 6, utf8_decode('OPERACIONES DE VENTAS PROPIAS Y A CUENTA DE TERCEROS'), 'TBLR', 0, 'C');
                    $pdf->Cell(15, 6, utf8_decode(''), 'TLR', 1, 'C');
                    //$pdf->Cell(25,6,utf8_decode(''),"TRB",1,'C');

                    //FILA 2
                    $pdf->Cell(50, 6, utf8_decode(''), "LR", 0, 'C');
                    $pdf->SetFont('Times', 'B', 5);
                    $pdf->Cell(15, 6, utf8_decode('FORMULARIO'), "LR", 0, 'C');
                    $pdf->SetFont('Times', 'B', 6);
                    $pdf->Cell(60, 6, utf8_decode(''), "LR", 0, 'C');
                    $pdf->Cell(15, 6, utf8_decode(''), 'LR', 0, 'C');
                    $pdf->Cell(47.5, 6, utf8_decode('PROPIAS'), "LRTB", 0, 'C');
                    $pdf->Cell(47.5, 6, utf8_decode('A CUENTA DE TERCEROS'), 1, 0, 'C');
                    $pdf->Cell(15, 6, utf8_decode('IVA'), "TLR", 0, 'C');
                    //$pdf->Cell(40,6,utf8_decode(''),"LR",0,'C');
                    $pdf->Cell(15, 6, utf8_decode('TOTAL'), 'LR', 1, 'C');

                    //FILA 3
                    $pdf->SetFont('Times', 'B', 5);
                    $pdf->Cell(10, 6, utf8_decode('N°'), 1, 0, 'C');
                    $pdf->SetFont('Times', 'B', 4.5);
                    $pdf->Cell(20, 6, utf8_decode('FECHA DE EMISION'), 1, 0, 'C');
                    $pdf->SetFont('Times', 'B', 4.5);
                    $pdf->Cell(20, 6, utf8_decode('CORRELATIVO'), 1, 0, 'C');
                    $pdf->SetFont('Times', 'B', 5);
                    $pdf->Cell(15, 6, utf8_decode('UNICO'), "BLR", 0, 'C');
                    $pdf->SetFont('Times', 'B', 5);

                    $pdf->Cell(60, 6, utf8_decode('NOMBRE DEL CLIENTE'), 1, 0, 'C');
                    $pdf->Cell(15, 6, utf8_decode('NRC'), 'LRB', 0, 'C');
                    $pdf->SetFont('Times', 'B', 4.5);
                    $pdf->Cell(12.5, 6, utf8_decode('EXENTAS'), "BLR", 0, 'C');
                    $pdf->Cell(20, 6, utf8_decode('INTERNAS GRAVADAS'), 1, 0, 'C');
                    $pdf->Cell(15, 6, utf8_decode('DÉBITO FISCAL'), 1, 0, 'C');
                    $pdf->SetFont('Times', 'B', 4.5);
                    $pdf->Cell(10, 6, utf8_decode('EXENTAS'), "BLR", 0, 'C');
                    $pdf->Cell(20, 6, utf8_decode('INTERNAS GRAVADAS'), 1, 0, 'C');
                    $pdf->Cell(17.5, 6, utf8_decode('DÉBITO FISCAL'), 1, 0, 'C');
                    $pdf->SetFont('Times', 'B', 5);
                    $pdf->Cell(15, 6, utf8_decode('RETENIDO'), "BLR", 0, 'C');
                    $pdf->Cell(15, 6, utf8_decode(''), 'BLR', 1, 'C');
                    $pdf->SetFont('Times', 'B', 5);
                    $counter2++;
                    $pdf->Ln(3);
                    $pdf->SetFont('Times', '', 7);
                }
            }
            $sql = "SELECT * FROM tbl_ventas_manuales WHERE (fechaComprobante BETWEEN '$inicio' AND '$fin') AND tipoComprobante = 2";
            $stmt = $mysqli->query($sql);
            while ($resultado = $stmt->fetch_assoc()) {
                $montoCanceladoConsumidor = 0;
                if ($resultado["montoCable"] > 0 && is_numeric($resultado["montoCable"]) ) {
                    $montoCanceladoConsumidor = doubleval($resultado["montoCable"]);
                    $separadoConsumidor = (floatval($montoCanceladoConsumidor)/(1 + floatval($iva)));
                $totalIvaConsumidor = substr(floatval($separadoConsumidor) * floatval($iva),0,7);
                $sinIvaConsumidor = doubleval($montoCanceladoConsumidor)-doubleval($totalIvaConsumidor);
                $sql2 = "SELECT * FROM clientes WHERE cod_cliente='$codigo' AND exento='T'";
                $resultado2 = $mysqli->query($sql2);
                $resultado2 = mysqli_num_rows($resultado2);
                if ($resultado2 > 0) {
                    $totalSinIvaExentoConsumidor = $totalSinIvaExentoConsumidor + $sinIvaConsumidor;
                    $totalConIvaExentoConsumidor = $totalConIvaExentoConsumidor + $montoCanceladoConsumidor;
                }

                else {

                    $totalSinIvaConsumidor = $totalSinIvaConsumidor +$sinIvaConsumidor;
                    $totalConIvaConsumidor = $totalConIvaConsumidor + $montoCanceladoConsumidor;
                }

                $totalSoloIvaConsumidor = $totalSoloIvaConsumidor + $totalIvaConsumidor;
                $totalSoloCescConsumidor = $totalSoloCescConsumidor + doubleval($resultado["impuesto"]);
                }
                
                if ($resultado["montoInternet"] > 0 && is_numeric($resultado["montoInternet"])) {
                    $montoCanceladoConsumidor = doubleval($resultado["montoInternet"]);
                    $separadoConsumidor = (floatval($montoCanceladoConsumidor)/(1 + floatval($iva)));
                $totalIvaConsumidor = substr(floatval($separadoConsumidor) * floatval($iva),0,7);
                $sinIvaConsumidor = doubleval($montoCanceladoConsumidor)-doubleval($totalIvaConsumidor);
                $sql2 = "SELECT * FROM clientes WHERE cod_cliente='$codigo' AND exento='T'";
                $resultado2 = $mysqli->query($sql2);
                $resultado2 = mysqli_num_rows($resultado2);
                if ($resultado2 > 0) {
                    $totalSinIvaExentoConsumidor = $totalSinIvaExentoConsumidor + $sinIvaConsumidor;
                    $totalConIvaExentoConsumidor = $totalConIvaExentoConsumidor + $montoCanceladoConsumidor;
                }

                else {

                    $totalSinIvaConsumidor = $totalSinIvaConsumidor +$sinIvaConsumidor;
                    $totalConIvaConsumidor = $totalConIvaConsumidor + $montoCanceladoConsumidor;
                }

                $totalSoloIvaConsumidor = $totalSoloIvaConsumidor + $totalIvaConsumidor;
                $totalSoloCescConsumidor = $totalSoloCescConsumidor + doubleval($resultado["impuesto"]);
                }
                
            }

            


        }
        //otro else

        $pdf->Ln(1);
        $pdf->SetFont('Times', 'B', 7);
        $pdf->Cell(60, 6, utf8_decode(''), 'T', 0, 'C');
        $pdf->Cell(60, 6, utf8_decode('TOTALES DEL MES'), "T", 0, 'C');
        $pdf->Cell(20, 6, utf8_decode(''), "T", 0, 'L');
        $pdf->Cell(12.5, 6, utf8_decode(number_format($totalSinIvaExento, 2)), "T", 0, 'L');
        $pdf->Cell(20, 6, utf8_decode(number_format($totalSinIva, 2)), "T", 0, 'L');
        $pdf->Cell(15, 6, utf8_decode(number_format($totalSoloIva, 2)), "T", 0, 'L');
        $pdf->Cell(10, 6, utf8_decode(number_format(0, 2)), "T", 0, 'L');
        $pdf->Cell(20, 6, utf8_decode(number_format(0, 2)), "T", 0, 'L');
        $pdf->Cell(17.5, 6, utf8_decode(number_format((0), 2)), "T", 0, 'L');
        $pdf->Cell(15, 6, utf8_decode(number_format((0), 2)), "T", 0, 'L');
        $pdf->Cell(15, 6, utf8_decode(number_format(($totalConIva + $totalSoloCesc), 2)), "T", 0, 'L');


        //RESUMEN
        $pdf->AddPage('L', 'Letter');
        date_default_timezone_set('America/El_Salvador');
        if ($encabezados == 1) {
            $pdf->SetFont('Times', 'B', 10);
            $pdf->Cell(260, 6, utf8_decode('LIBRO O REGISTRO DE OPERACIONES CON EMISION DE CREDITO FISCAL'), 0, 0, 'C');
            $pdf->Ln(5);
        }
        if ($numPag == 1) {
            $pdf->Cell(260, 6, utf8_decode("Página " . str_pad($pdf->pageNo(), 4, "0", STR_PAD_LEFT)), 0, 1, 'R');
        }
        $pdf->SetFont('Times', 'B', 7);
        $pdf->Cell(40, 6, utf8_decode('RESUMEN'), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('RESUMEN DE VENTAS (CCF)'), 0, 0, 'L');
        $pdf->Cell(65, 6, utf8_decode('RESUMEN DE VENTAS A CONSUMIDOR FINAL'), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('FACTURAS A CONSUMIDOR FINAL ANULADAS'), 0, 1, 'L');
        $pdf->Cell(210, 1, utf8_decode(''), "T", 1, 'L');
        $pdf->SetFont('Times', 'B', 7);
        $pdf->Cell(40, 6, utf8_decode('Ventas exentas'), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format($totalConIvaExento, 2)), 0, 0, 'L');
        $pdf->Cell(65, 6, utf8_decode(number_format(($totalConIvaExentoConsumidor + $totalConIvaExentoConsumidor2), 2)), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format($totalConIvaExentoFacturaFinal, 2)), 0, 1, 'L');
        $pdf->Cell(40, 6, utf8_decode('Ventas netas gravadas'), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format($totalSinIva, 2)), 0, 0, 'L');
        $pdf->Cell(65, 6, utf8_decode(number_format(($totalSinIvaConsumidor + $totalSinIvaConsumidor2), 2)), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format($totalSinIvaFacturaFinal, 2)), 0, 1, 'L');
        $pdf->Cell(40, 6, utf8_decode('DEBITO FISCAL 13%'), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format($totalSoloIva, 2)), 0, 0, 'L');
        $pdf->Cell(65, 6, utf8_decode(number_format(($totalSoloIvaConsumidor + $totalSoloIvaConsumidor2), 2)), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format($totalSoloIvaFacturaFinal, 2)), 0, 1, 'L');
        $pdf->Cell(40, 6, utf8_decode('5% CESC'), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format($totalSoloCesc, 2)), 0, 0, 'L');
        $pdf->Cell(65, 6, utf8_decode(number_format(($totalSoloCescConsumidor + $totalSoloCescConsumidor2), 2)), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format($totalSoloCescFacturaFinal, 2)), 0, 1, 'L');
        $pdf->Cell(40, 6, utf8_decode('Exportaciones'), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format(0, 2)), 0, 0, 'L');
        $pdf->Cell(65, 6, utf8_decode(number_format(0, 2)), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format(0, 2)), 0, 1, 'L');
        $pdf->Cell(210,1,utf8_decode(''),"T",1,'L');

        $pdf->Cell(40,6,utf8_decode(""),0,0,'L');
        $pdf->Cell(45,6,utf8_decode(number_format(($totalConIvaExento + $totalSinIva + $totalSoloIva + $totalSoloCesc),2)),0,0,'L');
        $pdf->Cell(65,6,utf8_decode(number_format(($totalConIvaExentoConsumidor + $totalConIvaExentonConsumidor2 + $totalSinIvaConsumidor + $totalSinIvaConsumidor2 + $totalSoloIvaConsumidor + $totalSoloIvaConsumidor2 + $totalSoloCescConsumidor + $totalSoloCescConsumidor2),2)),0,0,'L');
        $pdf->Cell(45,6,utf8_decode(number_format(($totalConIvaExentoFacturaFinal + $totalSinIvaFacturaFinal + $totalSoloIvaFacturaFinal + $totalSoloCescFacturaFinal),2)),0,1,'L');

        $pdf->Ln(20);
        $pdf->Cell(70,3,utf8_decode(''),"T",1,'C');
        $pdf->Cell(40,1,utf8_decode("Nombre y firma del contador:"),"",0,'L');
    }
    /* close connection */
    mysqli_close($mysqli);
    $pdf->Output();
}
libroConsumidorFinal();
