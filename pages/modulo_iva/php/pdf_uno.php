<?php
require '../../../pdfs/fpdf.php';

define("titulo", $encabezados);
define("numeros", $numerodePagina);
define("mes", $monthName);
define("año", $years);
setlocale(LC_MONETARY, 'es_SV');
class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        if (titulo == 1) {
            // Arial bold 15
            $this->SetFont('Times', 'B', 12);
            // Título
            $this->Ln(20);
            $this->Cell(260, 6, utf8_decode('LIBRO O REGISTRO DE OPERACIONES CON EMISION DE CREDITO FISCAL'), 0, 0, 'C');
            // Salto de línea
            $this->Ln(5);
        } else {
            $this->Ln(20);
        }
    }

    // Pie de página
    function Footer()
    {
        if (numeros == 1) {
            $this->SetY(-15);
            $this->SetFont('Times', 'B', 10);
            // Número de página
            $this->Cell(250, 6, utf8_decode("Página " . str_pad($this->pageNo(), 2, "0", STR_PAD_LEFT)), 0, 1, 'R');
        }
    }
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage("L", 'Letter');
$pdf->SetFont('Times', '', 12);
$pdf->Cell(260, 6, utf8_decode(mes . " " . año . " (VALORES EXPRESADOS EN US DOLARES)"), 0, 0, 'C');
$pdf->Ln(5);
$pdf->SetFont('Times', '', 10);
include('encabezado_tabla.php');
//CUERPO DE TABLA 

if ($detallado == 1) {
    if ($tiposComprobantes == 1) {
        $desde = $years . '-' . $mes . '-01';
        if ($mes == 2) {
            $hasta = $years . '-' . $mes . '-28';
        } else {
            $hasta = $years . '-' . $mes . '-31';
        }
        $desde = date('Y-m-d', strtotime($desde));
        $hasta = date('Y-m-d', strtotime($hasta));
        $sql = "SELECT *, (SELECT num_registro FROM clientes WHERE clientes.cod_cliente=tbl_cargos.codigoCliente) AS nRegistro FROM tbl_cargos WHERE fechaFactura BETWEEN '$desde' AND '$hasta' AND tipoFactura =1 ORDER BY idFactura";
        $sql2 = "SELECT * FROM tbl_ventas_manuales WHERE fechaComprobante BETWEEN '$desde' AND '$hasta'  AND tipoComprobante = 2 ORDER BY idVenta ASC";
        $sql3 = "SELECT * FROM tbl_cargos WHERE fechaFactura BETWEEN '$desde' AND '$hasta' AND tipoFactura = 2 AND anulada=0";
        $sql4 = "SELECT * FROM tbl_ventas_anuladas WHERE fechaComprobante BETWEEN '$desde' AND '$hasta' AND tipoComprobante = 2 ORDER BY idVenta ASC";
    }
    $contador = 1;
    $conador2 = 1;
    $query = $mysqli->query($sql);
    $query2 = $mysqli->query($sql2);
    $query3 = $mysqli->query($sql3);
    $query4 = $mysqli->query($sql4);
    while ($datos = $query->fetch_Array()) {
        $pdf->SetFont('Times', '', 8);
        $pdf->Cell(10, 5, utf8_decode($contador), 0, 0, 'C');
        $pdf->Cell(20, 5, utf8_decode($datos['fechaFactura']), 0, 0, 'C');
        $pdf->Cell(20, 5, utf8_decode(substr($datos['numeroFactura'], 9, 7)), 0, 0, 'C');
        $pdf->Cell(15, 5, utf8_decode('0'), 0, 0, 'C');
        $pdf->SetFont('Times', '', 5.8);
        $caracteres = strlen($datos["nombre"]);
        if ($caracteres >= 47) {
            $recortado = substr($datos["nombre"], 0, 47);
            $pdf->Cell(60, 5, utf8_decode($recortado), 0, 0, 'L');
        } else {
            $pdf->Cell(60, 5, utf8_decode($datos['nombre']), 0, 0, 'L');
        }
        $pdf->SetFont('Times', '', 8);
        if ($datos['nombre'] == '<<< Comprobante anulado >>>') {
            $nrc = '';
        } else {
            $nrc = $datos['nRegistro'];
        }
        $pdf->Cell(15, 5, utf8_decode($nrc), 0, 0, 'C');

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
                $separado = round(($datos['cuotaCable'] / 1.13),2,PHP_ROUND_HALF_EVEN);
                $iva = ($separado * 0.13);
                $internasGravadas = $datos['cuotaCable'] - $iva;
                $debitoFiscal = $iva;
                $internasGravadas2 = 0;
                $debitoFiscal2 = 0;
                $totalGravadasSinIva = $totalGravadasSinIva + $internasGravadas;
                $totalIvaCredito = $totalIvaCredito + $debitoFiscal;
                $totalCESCcredito = $totalCESCcredito + $datos['totalImpuesto'];
            } else {
                $monto = $datos['cuotaInternet'];
                $montoCancelado = 0.00;
                $separado = round(($datos['cuotaInternet'] / 1.13),2,PHP_ROUND_HALF_EVEN);
                $iva = ($separado * 0.13);
                $internasGravadas = $datos['cuotaInternet'] - $iva;
                $debitoFiscal = $iva;
                $internasGravadas2 = 0;
                $debitoFiscal2 = 0;
                $totalGravadasSinIva = $totalGravadasSinIva + $internasGravadas;
                $totalIvaCredito = $totalIvaCredito + $debitoFiscal;
                $totalCESCcredito = $totalCESCcredito + $datos['totalImpuesto'];
            }
        }
        $totalA = $totalA + $montoCancelado;
        $pdf->Cell(12.5, 5, utf8_decode(number_format($montoCancelado, 2)), 0, 0, 'C');
        $totalB = $totalB + $internasGravadas;
        $pdf->Cell(20, 5, utf8_decode(number_format($internasGravadas, 2)), 0, 0, 'C');
        $totalC = $totalC + $debitoFiscal;
        $pdf->Cell(15, 5, utf8_decode(number_format($debitoFiscal, 2)), 0, 0, 'C');
        $totalD = $totalD + $montoCancelado;
        $pdf->Cell(10, 5, utf8_decode(number_format($montoCancelado, 2)), 0, 0, 'C');
        $totalE = $totalE + $internasGravadas2;
        $pdf->Cell(20, 5, utf8_decode(number_format($internasGravadas2, 2)), 0, 0, 'C');
        $totalF = $totalF + $debitoFiscal2;
        $pdf->Cell(17.5, 5, utf8_decode(number_format($debitoFiscal2, 2)), 0, 0, 'C');
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
        $totalG = $totalG + $ivaretenido;
        $pdf->Cell(15, 5, utf8_decode(number_format($ivaretenido, 2)), 0, 0, 'C');
        $totalH = $totalH + $monto;
        $pdf->Cell(15, 5, utf8_decode(number_format($monto, 2)), 0, 1, 'C');
        $contador += 1;
        $contador2 += 1;
        if ($contador2 == 25) {
            $pdf->AddPage("L", 'Letter');
            $pdf->SetFont('Times', '', 12);
            $pdf->Cell(260, 6, utf8_decode(mes . " " . año . " (VALORES EXPRESADOS EN US DOLARES)"), 0, 0, 'C');
            $pdf->Ln(5);
            include('encabezado_tabla.php');
            $pdf->SetFont('Times', '', 7);
            $contador2 = 1;
        }
    }
    //NOTA DE CREDITO
    $desde = $years . '-' . $mes . '-01';
    if ($mes == 2) {
        $hasta = $years . '-' . $mes . '-28';
    } else {
        $hasta = $years . '-' . $mes . '-31';
    }
    $desde = date('Y-m-d', strtotime($desde));
    $hasta = date('Y-m-d', strtotime($hasta));
    $sqlnuevo = $mysqli->query("SELECT * FROM tbl_abonos WHERE numeroRecibo LIKE 'NC%' AND fechaAbonado BETWEEN '$desde' AND '$hasta'");
    $cantidad = $sqlnuevo->num_rows;
    $contador3 = $contador;
    if ($cantidad > 0) {
        while ($notaCredito = $sqlnuevo->fetch_Array()) {
            $pdf->SetFont('Times', '', 8);
            $pdf->Cell(10, 5, utf8_decode($contador3), 0, 0, 'C');
            $pdf->Cell(20, 5, utf8_decode($notaCredito['fechaAbonado']), 0, 0, 'C');
            $pdf->Cell(20, 5, utf8_decode($notaCredito['numeroRecibo']), 0, 0, 'C');
            $pdf->Cell(15, 5, utf8_decode('0'), 0, 0, 'C');
            $pdf->SetFont('Times', '', 5.8);
            $caracteres = strlen($notaCredito["nombre"]);
            if ($caracteres >= 47) {
                $recortado = substr($notaCredito["nombre"], 0, 47);
                $pdf->Cell(60, 5, utf8_decode($recortado), 0, 0, 'L');
            } else {
                $pdf->Cell(60, 5, utf8_decode($notaCredito['nombre']), 0, 0, 'L');
            }
            $pdf->SetFont('Times', '', 8);
            $codigoo = $notaCredito['codigoCliente'];
            $nrcquery = $mysqli->query("SELECT num_registro FROM clientes WHERE cod_cliente='$codigoo'");
            $registroo = $nrcquery->fetch_Array();
            $pdf->Cell(15, 5, utf8_decode($registroo['num_registro']), 0, 0, 'C');
            if ($ex->isExento($notaCredito['codigoCliente'])) {
                if ($notaCredito['tipoServicio'] == 'C') {
                    $monto = $notaCredito['cuotaCable'];
                    $internasGravadas = 0.00;
                    $debitoFiscal = 0.00;
                    $internasGravadas2 = 0;
                    $debitoFiscal2 = 0;
                    $totalExentosSinIva = $totalExentosSinIva - $monto;
                    $totalIvaCredito = $totalIvaCredito - $debitoFiscal;
                    $totalCESCcredito = $totalCESCcredito - $notaCredito['totalImpuesto'];
                } else {
                    $monto = $notaCredito['cuotaInternet'];
                    $internasGravadas2 = 0;
                    $debitoFiscal2 = 0;
                    $totalExentosSinIva = $totalExentosSinIva - $monto;
                    $totalIvaCredito = $totalIvaCredito - $debitoFiscal;
                    $totalCESCcredito = $totalCESCcredito - $notaCredito['totalImpuesto'];
                }
            } else {
                if ($notaCredito['tipoServicio'] == 'C') {
                    $monto = $notaCredito['cuotaCable'];
                    $montoCancelado = 0.00;
                    $iva = round(($monto / 1.13),2,PHP_ROUND_HALF_EVEN) * 0.13;
                    $internasGravadas = $monto - $iva;
                    $debitoFiscal = $iva;
                    $internasGravadas2 = 0;
                    $debitoFiscal2 = 0;
                    $totalGravadasSinIva = number_format($totalGravadasSinIva,2) - number_format($internasGravadas,2);
                    $totalIvaCredito = $totalIvaCredito - $debitoFiscal;
                    $totalCESCcredito = $totalCESCcredito - $notaCredito['totalImpuesto'];
                } else {
                    $monto = $notaCredito['cuotaInternet'];
                    $montoCancelado = 0.00;
                    $iva = round(($monto / 1.13),2,PHP_ROUND_HALF_EVEN) * 0.13;
                    $internasGravadas = $monto - $iva;
                    $debitoFiscal = $iva;
                    $internasGravadas2 = 0;
                    $debitoFiscal2 = 0;
                    $totalGravadasSinIva = number_format($totalGravadasSinIva,2) - number_format($internasGravadas,2);
                    $totalIvaCredito = $totalIvaCredito - $debitoFiscal;
                    $totalCESCcredito = $totalCESCcredito - $notaCredito['totalImpuesto'];
                }
            }
            $totalA = $totalA - $montoCancelado;
            $pdf->Cell(12.5, 5, utf8_decode(number_format($montoCancelado, 2)), 0, 0, 'C');
            $totalB = $totalB - $internasGravadas;
            $internasGravadas = number_format($internasGravadas, 2);
            $pdf->Cell(20, 5, utf8_decode("-" . $internasGravadas), 0, 0, 'C');
            $totalC = $totalC - $debitoFiscal;
            $debitoFiscal = number_format($debitoFiscal, 2);
            $pdf->Cell(15, 5, utf8_decode("-" . $debitoFiscal), 0, 0, 'C');
            $totalD = $totalD - $montoCancelado;
            $pdf->Cell(10, 5, utf8_decode(number_format($montoCancelado, 2)), 0, 0, 'C');
            $totalE = $totalE - $internasGravadas2;
            $pdf->Cell(20, 5, utf8_decode(number_format($internasGravadas2, 2)), 0, 0, 'C');
            $totalF = $totalF - $debitoFiscal2;
            $pdf->Cell(17.5, 5, utf8_decode(number_format($debitoFiscal2, 2)), 0, 0, 'C');

            $idcliente = $datos["codigoCliente"];
            $granContribuyente = $mysqli->query("SELECT id_tipo_cliente FROM clientes WHERE cod_cliente='$idcliente'");
            $datoscontribuyente = $granContribuyente->fetch_array();
            if ($datoscontribuyente['id_tipo_cliente'] == '0003') {
                $ivaretenido = $internasGravadas * 0.01;
                $totalivaretenido = $totalivaretenido - $ivaretenido;
                $monto = $monto - $ivaretenido;
            } else {
                $ivaretenido = 0.00;
            }
            $totalG = $totalG - $ivaretenido;
            $pdf->Cell(15, 5, utf8_decode(number_format($ivaretenido, 2)), 0, 0, 'C');
            $totalH = $totalH - $monto;
            $pdf->Cell(15, 5, utf8_decode(number_format('-' . $monto, 2)), 0, 1, 'C');
            if ($contador3 == 25) {
                $pdf->AddPage("L", 'Letter');
                $pdf->SetFont('Times', '', 12);
                $pdf->Cell(260, 6, utf8_decode(mes . " " . año . " (VALORES EXPRESADOS EN US DOLARES)"), 0, 0, 'C');
                $pdf->Ln(5);
                include('encabezado_tabla.php');
                $pdf->SetFont('Times', '', 7);
                $contador2 = 1;
            }
            $contador3 += 1;
        }
    }

    //FIN DE NOTA DE CREDITO
    //suma de totales
    $pdf->Cell(60, 3, utf8_decode(''), 'T', 0, 'C');
    $pdf->Cell(60, 3, utf8_decode('TOTALES DEL MES'), "T", 0, 'C');
    $pdf->Cell(20, 3, utf8_decode(''), "T", 0, 'L');
    $pdf->Cell(12.5, 3, utf8_decode(number_format($totalA, 2)), "T", 0, 'C');
    $pdf->Cell(20, 3, utf8_decode(number_format($totalB, 2)), "T", 0, 'C');
    $pdf->Cell(15, 3, utf8_decode(number_format($totalC, 2)), "T", 0, 'C');
    $pdf->Cell(10, 3, utf8_decode(number_format($totalD, 2)), "T", 0, 'C');
    $pdf->Cell(20, 3, utf8_decode(number_format($totalE, 2)), "T", 0, 'C');
    $pdf->Cell(17.5, 3, utf8_decode(number_format($totalF, 2)), "T", 0, 'C');
    $pdf->Cell(15, 3, utf8_decode(number_format($totalG, 2)), "T", 0, 'C');
    $pdf->Cell(15, 3, utf8_decode(number_format($totalH, 2)), "T", 1, 'C');
    //resumen
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
        if ($contador2 > 12) {
            $pdf->AddPage('L', 'Letter');
            $pdf->SetFont('Times', '', 12);
            $pdf->Cell(260, 6, utf8_decode(mes . " " . año . " (VALORES EXPRESADOS EN US DOLARES)"), 0, 0, 'C');
            $pdf->Ln(5);
            include('encabezado_tabla.php');
            $pdf->SetFont('Times', 'B', 8);
        } else {
            $pdf->Ln(5);
        }
        //primera fila
        $pdf->Cell(40, 6, utf8_decode('RESUMEN'), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('RESUMEN DE VENTAS (CCF)'), 0, 0, 'L');
        $pdf->Cell(65, 6, utf8_decode('RESUMEN DE VENTAS A CONSUMIDOR FINAL'), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('FACTURAS A CONSUMIDOR FINAL ANULADAS'), 0, 1, 'L');
        $pdf->Cell(210, 1, utf8_decode(''), "T", 1, 'L');
        //segunda fila
        $pdf->Cell(40, 6, utf8_decode('Ventas exentas'), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format($totalExentosSinIva, 2)), 0, 0, 'L');
        $totalExentoSinIvaVentasManualesCompleto = $totalExentoSinIvaVentasManuales + $totalExentoSinIvaVentasManuales2;
        $pdf->Cell(65, 6, utf8_decode(number_format(($totalExentoSinIvaVentasManuales), 2)), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format($totalExentoSinIvaAnulados, 2)), 0, 1, 'L');
        //tercera fila
        $pdf->Cell(40, 6, utf8_decode('Ventas netas gravadas'), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format($totalGravadasSinIva, 2)), 0, 0, 'L');
        $totalGravadasSinIvaVentasManualesCompleto = $totalGravadasSinIvaVentasManuales + $totalGravadasSinIvaVentasManuales2;
        $pdf->Cell(65, 6, utf8_decode(number_format(($totalGravadasSinIvaVentasManualesCompleto), 2)), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format($totalGravadasSinIvaAnulados, 2)), 0, 1, 'L');
        //cuarta fila
        $pdf->Cell(40, 6, utf8_decode('Debito fiscal 13%'), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format($totalIvaCredito, 2)), 0, 0, 'L');
        $totalIvaVentasManualesCompleto = $totalIvaVentasManuales + $totalIvaVentasManuales2;
        $pdf->Cell(65, 6, utf8_decode(number_format(($totalIvaVentasManualesCompleto), 2)), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format($totalIvaAnulados, 2)), 0, 1, 'L');
        //quinta fila
        $pdf->Cell(40, 6, utf8_decode('CESC 5%'), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format($totalCESCcredito, 2)), 0, 0, 'L');
        $totalCESCventasmanualesCompleto = number_format($totalCESCventasManuales,2) + number_format($totalCESCventasManuales2,2);
        $pdf->Cell(65, 6, utf8_decode(number_format(($totalCESCventasmanualesCompleto), 2)), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format($totalCESCanulados, 2)), 0, 1, 'L');
        //sexta fila
        $pdf->Cell(40, 6, utf8_decode('Exportaciones'), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format(0, 2)), 0, 0, 'L');
        $pdf->Cell(65, 6, utf8_decode(number_format(0, 2)), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format(0, 2)), 0, 1, 'L');
        //septima fila
        $pdf->Cell(40, 6, utf8_decode('Iva retenido 1%'), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format($totalivaretenido, 2)), 0, 0, 'L');
        $pdf->Cell(65, 6, utf8_decode(number_format(0, 2)), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format(0, 2)), 0, 1, 'L');
        //octava fila
        $pdf->Cell(210, 1, utf8_decode(''), "T", 1, 'L');
        $pdf->Cell(40, 6, utf8_decode('TOTAL'), 0, 0, 'L');
        $totalUNO = $totalExentosSinIva + $totalGravadasSinIva + $totalIvaCredito + $totalCESCcredito + 0 - $totalivaretenido;
        $pdf->Cell(45, 6, utf8_decode(number_format($totalUNO, 2)), 0, 0, 'L');
        $totalDOS = $totalExentoSinIvaVentasManualesCompleto + $totalGravadasSinIvaVentasManualesCompleto + $totalIvaVentasManualesCompleto + $totalCESCventasmanualesCompleto;
        $pdf->Cell(65, 6, utf8_decode(number_format($totalDOS, 2)), 0, 0, 'L');
        $totalTRES = $totalExentoSinIvaAnulados + $totalGravadasSinIvaAnulados + $totalIvaAnulados + $totalCESCanulados;
        $pdf->Cell(45, 6, utf8_decode(number_format($totalTRES, 2)), 0, 1, 'L');
    }
    $pdf->Ln(20);
    $pdf->Cell(70, 3, utf8_decode(''), "T", 1, 'C');
    $pdf->Cell(40, 1, utf8_decode("Nombre y firma del contador:"), "", 0, 'L');
}else {
    $numero = 1;
    $counter = 1;
    for ($i = 0; $i < 31; $i++) {
        if ($tiposComprobantes == 1) {
            $desde = $years . '-' . $mes . '-01';
            if ($mes == 2) {
                $hasta = $years . '-' . $mes . '-28';
            }else{
                $hasta = $years . '-' . $mes . '-31';
            }
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
        $pdf->SetFont('Times', '', 8);
        $pdf->Cell(10, 6, utf8_decode($i + 1), 0, 0, 'C');
        while ($datos = $query->fetch_array()) {
            if (strlen($datos["inFact"]) == 0) {
                $pdf->Cell(20, 5, utf8_decode("-"), 0, 0, 'C');
            } else {
                $pdf->Cell(20, 5, utf8_decode($mes . "/" . $years), 0, 0, 'C');
            }
            $pdf->Cell(20, 5, utf8_decode(substr($datos['inFact'], 9, 7) . "-" . substr($datos['finFact'], 9, 7)), 0, 0, 'C');
            $pdf->Cell(15, 5, utf8_decode('0'), 0, 0, 'C');
            $pdf->Cell(60, 5, utf8_decode("-"), 0, 0, 'C');
            $pdf->Cell(15, 5, utf8_decode("-"), 0, 0, 'C');

            $montoCancelado = doubleval($datos["totalCuotaCable"]) + doubleval($datos["totalCuotaInter"]);
            //IVA
            $separado = $montoCancelado / 1.13;
            //var_dump($separado);
            $totalIva = $separado * 0.13;
            $totalSoloIva = $totalSoloIva + $totalIva;
            $sinIva = doubleval($montoCancelado) - doubleval($totalIva);
            if ($ex->isExento("")) {
                $pdf->Cell(12.5, 5, utf8_decode(number_format($montoCancelado, 2)), 0, 0, 'C');
                $pdf->Cell(20, 5, utf8_decode(number_format("0", 2)), 0, 0, 'C');
                $pdf->Cell(15, 5, utf8_decode(number_format("0", 2)), 0, 0, 'C');
                $totalConIvaExento = $totalConIvaExento + $montoCancelado;
                $totalSinIvaExento = $totalSinIvaExento + $sinIva;
            } else {
                $pdf->Cell(12.5, 5, utf8_decode(number_format("0", 2)), 0, 0, 'C');
                $pdf->Cell(20, 5, utf8_decode(number_format($sinIva, 2)), 0, 0, 'C');
                if ($datos["totalImp"]) {
                    $pdf->Cell(15, 5, utf8_decode(number_format($totalSoloIva, 2)), 0, 0, 'C');
                } else {
                    $pdf->Cell(15, 5, utf8_decode(number_format("0", 2)), 0, 0, 'C');
                }
                $totalConIva = $totalConIva + $montoCancelado;
                $totalSinIva = $totalSinIva + $sinIva;
            }
            $totalSoloCesc = $totalSoloCesc + doubleval($datos["totalImp"]);
            $pdf->Cell(10, 5, utf8_decode(number_format("0", 2)), 0, 0, 'C');
            $pdf->Cell(20, 5, utf8_decode(number_format("0", 2)), 0, 0, 'C');
            $pdf->Cell(17.5, 5, utf8_decode(number_format("0", 2)), 0, 0, 'C');
            $pdf->Cell(15, 5, utf8_decode(number_format("0", 2)), 0, 0, 'C');
            $total = $montoCancelado + doubleval($datos["totalImp"]);
            $pdf->Cell(15, 5, utf8_decode(number_format($total, 2)), 0, 1, 'C');
        }
        $numero += 1;
        $counter += 1;
        if ($numero == 26) {
            $pdf->AddPage("L", 'Letter');
            $pdf->SetFont('Times', '', 12);
            $pdf->Cell(260, 6, utf8_decode(mes . " " . año . " (VALORES EXPRESADOS EN US DOLARES)"), 0, 0, 'C');
            $pdf->Ln(5);
            include('encabezado_tabla.php');
            $numero = 1;
        }
    }
    if ($resumen == 1) {
        if ($numero > 12) {
            $pdf->AddPage('L', 'Letter');
            include('encabezado_tabla.php');
            $pdf->SetFont('Times', 'B', 8);
        } else {
            $pdf->Ln(5);
        }
        //primera fila
        $pdf->Cell(40, 6, utf8_decode('RESUMEN'), 0, 0, 'L');
        $pdf->Cell(65, 6, utf8_decode('CREDITOS FISCAL GENERADOS'), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('FACTURAS ANULADAS'), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('TOTALES'), 0, 1, 'L');
        $pdf->Cell(210, 1, utf8_decode(''), "T", 1, 'L');

        //SEGUNDA FILA
        $pdf->Cell(40, 6, utf8_decode('Ventas exentas'), 0, 0, 'L');
        $pdf->Cell(65, 6, utf8_decode(number_format($totalConIvaExento, 2)), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format("0", 2)), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format($totalConIvaExento, 2)), 0, 1, 'L');

        //TERCERA FILA
        $pdf->Cell(40, 6, utf8_decode('Ventas netas gravadas'), 0, 0, 'L');
        $pdf->Cell(65, 6, utf8_decode(number_format($totalSinIva, 2)), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format("0", 2)), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format($totalSinIva, 2)), 0, 1, 'L');

        //CUARTA FILA
        $pdf->Cell(40, 6, utf8_decode('13% de IVA'), 0, 0, 'L');
        $pdf->Cell(65, 6, utf8_decode(number_format($totalSoloIva, 2)), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format("0", 2)), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format($totalSoloIva, 2)), 0, 1, 'L');

        //QUINTA FILA
        $pdf->Cell(40, 6, utf8_decode('5% de CESC'), 0, 0, 'L');
        $pdf->Cell(65, 6, utf8_decode(number_format($totalSoloCesc, 2)), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format("0", 2)), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format($totalSoloCesc, 2)), 0, 1, 'L');

        //SEXTA FILA
        $pdf->Cell(40, 6, utf8_decode('Exportaciones'), 0, 0, 'L');
        $pdf->Cell(65, 6, utf8_decode(number_format("0", 2)), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format("0", 2)), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format("0", 2)), 0, 1, 'L');
        $pdf->Cell(210, 1, utf8_decode(''), "T", 1, 'L');

        //SEPTIMA FILA
        $total1 = $totalConIvaExento + $totalSinIva + $totalSoloIva + $totalSoloCesc;
        $pdf->Cell(40, 6, utf8_decode('Total'), 0, 0, 'L');
        $pdf->Cell(65, 6, utf8_decode(number_format($total1, 2)), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format("0", 2)), 0, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(number_format($total1, 2)), 0, 1, 'L');
    }

    $pdf->Ln(20);
    $pdf->Cell(70, 3, utf8_decode(''), "T", 1, 'C');
    $pdf->Cell(40, 1, utf8_decode("Nombre y firma del contador:"), "", 0, 'L');
}

$pdf->Output();
