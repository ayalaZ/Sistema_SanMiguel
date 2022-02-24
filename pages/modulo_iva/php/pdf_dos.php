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
            $this->Cell(200, 6, utf8_decode('LIBRO O REGISTRO DE OPERACIONES CON EMISION DE FACTURAS'), 0, 0, 'C');
            // Salto de línea
            $this->Ln(5);
            $this->Cell(200, 6, utf8_decode(mes . " " . año . " (VALORES EXPRESADOS EN US DOLARES)"), 0, 0, 'C');
            $this->Ln(10);
        } else {
            $this->Ln(15);
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

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage("", 'Letter');
$pdf->SetFont('Times', '', 10);
include('encabezado_tabla2.php');
if ($detallado == 1) {
    switch ($tiposComprobantes) {
        case '1':
            $desde = $years . '-' . $mes . '-01';
            $hasta = $years . '-' . $mes . '-31';
            $desde = date('Y-m-d', strtotime($desde));
            $hasta = date('Y-m-d', strtotime($hasta));
            $sql = "SELECT * FROM tbl_cargos WHERE fechaFactura BETWEEN '$desde' AND '$hasta' AND tipoFactura = 2 AND anulada=0;";
            $contador = 1;
            $contador2 = 1;
            $query = $mysqli->query($sql);
            while ($datos = $query->fetch_Array()) {
                if ($datos["tipoServicio"] == "C") {
                    $montoCancelado1 = doubleval($datos["cuotaCable"]);
                    $tipoServ = 'CABLE';
                } elseif ($datos["tipoServicio"] == "I") {
                    $montoCancelado1 = doubleval($datos["cuotaInternet"]);
                    $tipoServ = 'INTERNET';
                }


                $pdf->SetFont('Times', '', 6.4);
                $pdf->Cell(5, 1, utf8_decode(date("d", strtotime($datos['fechaFactura']))), 0, 0, 'L');
                $pdf->Cell(20, 1, utf8_decode($datos['numeroFactura']), 0, 0, 'L');
                $pdf->SetFont('Times', '', 8);
                $pdf->Cell(15, 1, utf8_decode(0), 0, 0, 'C');
                $pdf->SetFont('Times', '', 7);
                $pdf->Cell(60, 1, utf8_decode($datos["nombre"]), 0, 0, 'L');
                if ($ex->isExento($datos["codigoCliente"])) {
                    $pdf->Cell(20, 1, utf8_decode(number_format($montoCancelado1, 2)), 0, 0, 'C');
                    $pdf->Cell(20, 1, utf8_decode("0.00"), 0, 0, 'C');
                    $pdf->Cell(20, 1, utf8_decode($tipoServ), 0, 0, 'C');
                    $total1 = $total1 + $montoCancelado1;
                    $total2 = $total2 + 0;
                } else {
                    $pdf->Cell(20, 1, utf8_decode("0.00"), 0, 0, 'C');
                    $pdf->Cell(20, 1, utf8_decode(number_format($montoCancelado1, 2)), 0, 0, 'C');
                    $pdf->Cell(20, 1, utf8_decode($tipoServ), 0, 0, 'C');
                    $total1 = $total1 + 0;
                    $total2 = $total2 + $montoCancelado1;
                }
                $pdf->Cell(15, 1, utf8_decode(number_format($montoCancelado1, 2)), 0, 0, 'C');
                $pdf->Cell(10, 1, utf8_decode(number_format($datos["totalImpuesto"], 2)), 0, 0, 'C');
                $pdf->Cell(15, 1, utf8_decode(number_format(doubleval($montoCancelado1) + doubleval($datos["totalImpuesto"]), 2)), 0, 0, 'C');
                $total3 = $total3 + $montoCancelado1;
                $total4 = $total4 + $datos['totalImpuesto'];
                $total5 = $total5 + $montoCancelado1 + $datos['totalImpuesto'];
                $pdf->Ln(5);
                $contador += 1;
                $contador2 += 1;
                if ($contador % 43 == 0) {
                    $pdf->AddPage("", 'Letter');
                    include('encabezado_tabla2.php');
                    $contador2 = 1;
                }
            }
            break;
        case '2':
            $desde = $years . '-' . $mes . '-01';
            $hasta = $years . '-' . $mes . '-31';
            $desde = date('Y-m-d', strtotime($desde));
            $hasta = date('Y-m-d', strtotime($hasta));
            $sql = "SELECT * FROM tbl_ventas_manuales WHERE fechaComprobante BETWEEN '$desde' AND '$hasta' AND tipoComprobante = 2 ORDER BY idVenta ASC";
            $contador = 1;
            $contador2 = 1;
            $query = $mysqli->query($sql);
            while ($datos = $query->fetch_Array()) {
                if ($datos["montoCable"] > 0 && is_numeric($datos["montoCable"])) {
                    $tipoServ='CABLE';
                    $montoCancelado1 = doubleval($datos["montoCable"]);
                }elseif ($datos["montoInternet"] > 0 && is_numeric($datos["montoInternet"])) {
                    $tipoServ='INTERNET';
                    $montoCancelado1 = doubleval($datos["montoInternet"]);
                }else {
                    $montoCancelado1 = 0;
                }


                $pdf->SetFont('Times', '', 6.4);
                $pdf->Cell(5, 1, utf8_decode(date("d", strtotime($datos['fechaComprobante']))), 0, 0, 'L');
                $pdf->Cell(20,1,utf8_decode($datos['prefijo'] . $datos['numeroComprobante']),0,0,'L');
                $pdf->SetFont('Times', '', 8);
                $pdf->Cell(15, 1, utf8_decode(0), 0, 0, 'C');
                $pdf->SetFont('Times', '', 7);
                $pdf->Cell(60, 1, utf8_decode($datos["nombreCliente"]), 0, 0, 'L');
                if ($ex->isExento($datos["codigoCliente"])) {
                    $pdf->Cell(20, 1, utf8_decode(number_format($montoCancelado1, 2)), 0, 0, 'C');
                    $pdf->Cell(20, 1, utf8_decode("0.00"), 0, 0, 'C');
                    $pdf->Cell(20, 1, utf8_decode($tipoServ), 0, 0, 'C');
                    $total1 = $total1 + $montoCancelado1;
                    $total2 = $total2 + 0;
                } else {
                    $pdf->Cell(20, 1, utf8_decode("0.00"), 0, 0, 'C');
                    $pdf->Cell(20, 1, utf8_decode(number_format($montoCancelado1, 2)), 0, 0, 'C');
                    $pdf->Cell(20, 1, utf8_decode($tipoServ), 0, 0, 'C');
                    $total1 = $total1 + 0;
                    $total2 = $total2 + $montoCancelado1;
                }
                $pdf->Cell(15, 1, utf8_decode(number_format($montoCancelado1, 2)), 0, 0, 'C');
                $pdf->Cell(10, 1, utf8_decode(number_format($datos["totalImpuesto"], 2)), 0, 0, 'C');
                $pdf->Cell(15, 1, utf8_decode(number_format(doubleval($montoCancelado1) + doubleval($datos["totalImpuesto"]), 2)), 0, 0, 'C');
                $total3 = $total3 + $montoCancelado1;
                $total4 = $total4 + $datos['totalImpuesto'];
                $total5 = $total5 + $montoCancelado1 + $datos['totalImpuesto'];
                $pdf->Ln(5);
                $contador += 1;
                $contador2 += 1;
                if ($contador % 43 == 0) {
                    $pdf->AddPage("", 'Letter');
                    include('encabezado_tabla2.php');
                    $contador2 = 1;
                }
            }
            break;
        case '3':
            $desde = $years . '-' . $mes . '-01';
            $hasta = $years . '-' . $mes . '-31';
            $desde = date('Y-m-d', strtotime($desde));
            $hasta = date('Y-m-d', strtotime($hasta));
            $sql = "SELECT * FROM tbl_ventas_anuladas WHERE fechaComprobante BETWEEN '$desde' AND '$hasta' AND tipoComprobante = 2 ORDER BY numeroComprobante ASC";
            $contador = 1;
            $contador2 = 1;
            $query = $mysqli->query($sql);
            while ($datos = $query->fetch_Array()) {
                if ($datos["totalComprobante"] > 0 && is_numeric($datos["totalComprobante"])) {
                    $montoCancelado1 = doubleval($datos["totalComprobante"]);
                }else {
                    $montoCancelado1 = 0;
                }
                if ($datos["tipoServicio"] == 'C'){
                    $tipoServ='CABLE';
                }else{
                    $tipoServ='INTERNET';
                }

                $pdf->SetFont('Times', '', 6.4);
                $pdf->Cell(5, 1, utf8_decode(date("d", strtotime($datos['fechaComprobante']))), 0, 0, 'L');
                $pdf->Cell(20,1,utf8_decode($datos['prefijo'] . $datos['numeroComprobante']),0,0,'L');
                $pdf->SetFont('Times', '', 8);
                $pdf->Cell(15, 1, utf8_decode(0), 0, 0, 'C');
                $pdf->SetFont('Times', '', 7);
                $pdf->Cell(60, 1, utf8_decode($datos["nombreCliente"]), 0, 0, 'L');
                if ($ex->isExento($datos["codigoCliente"])) {
                    $pdf->Cell(20, 1, utf8_decode(number_format($montoCancelado1, 2)), 0, 0, 'C');
                    $pdf->Cell(20, 1, utf8_decode("0.00"), 0, 0, 'C');
                    $pdf->Cell(20, 1, utf8_decode($tipoServ), 0, 0, 'C');
                    $total1 = $total1 + $montoCancelado1;
                    $total2 = $total2 + 0;
                } else {
                    $pdf->Cell(20, 1, utf8_decode("0.00"), 0, 0, 'C');
                    $pdf->Cell(20, 1, utf8_decode(number_format($montoCancelado1, 2)), 0, 0, 'C');
                    $pdf->Cell(20, 1, utf8_decode($tipoServ), 0, 0, 'C');
                    $total1 = $total1 + 0;
                    $total2 = $total2 + $montoCancelado1;
                }
                $pdf->Cell(15, 1, utf8_decode(number_format($montoCancelado1, 2)), 0, 0, 'C');
                $pdf->Cell(10, 1, utf8_decode(number_format($datos["totalImpuesto"], 2)), 0, 0, 'C');
                $pdf->Cell(15, 1, utf8_decode(number_format(doubleval($montoCancelado1) + doubleval($datos["totalImpuesto"]), 2)), 0, 0, 'C');
                $total3 = $total3 + $montoCancelado1;
                $total4 = $total4 + $datos['totalImpuesto'];
                $total5 = $total5 + $montoCancelado1 + $datos['totalImpuesto'];
                $pdf->Ln(5);
                $contador += 1;
                $contador2 += 1;
                if ($contador % 43 == 0) {
                    $pdf->AddPage("", 'Letter');
                    include('encabezado_tabla2.php');
                    $contador2 = 1;
                }
            }
            break;
        case '4':
            $desde = $years . '-' . $mes . '-01';
            $hasta = $years . '-' . $mes . '-31';
            $desde = date('Y-m-d', strtotime($desde));
            $hasta = date('Y-m-d', strtotime($hasta));
            $sql = "SELECT * FROM tbl_cargos WHERE fechaFactura BETWEEN '$desde' AND '$hasta' AND tipoFactura = 2 AND anulada=0;";
            $contador = 1;
            $contador2 = 1;
            $query = $mysqli->query($sql);
            while ($datos = $query->fetch_Array()) {
                if ($datos["tipoServicio"] == "C") {
                    $montoCancelado1 = doubleval($datos["cuotaCable"]);
                    $tipoServ = 'CABLE';
                } elseif ($datos["tipoServicio"] == "I") {
                    $montoCancelado1 = doubleval($datos["cuotaInternet"]);
                    $tipoServ = 'INTERNET';
                }


                $pdf->SetFont('Times', '', 6.4);
                $pdf->Cell(5, 1, utf8_decode(date("d", strtotime($datos['fechaFactura']))), 0, 0, 'L');
                $pdf->Cell(20, 1, utf8_decode($datos['numeroFactura']), 0, 0, 'L');
                $pdf->SetFont('Times', '', 8);
                $pdf->Cell(15, 1, utf8_decode(0), 0, 0, 'C');
                $pdf->SetFont('Times', '', 7);
                $pdf->Cell(60, 1, utf8_decode($datos["nombre"]), 0, 0, 'L');
                if ($ex->isExento($datos["codigoCliente"])) {
                    $pdf->Cell(20, 1, utf8_decode(number_format($montoCancelado1, 2)), 0, 0, 'C');
                    $pdf->Cell(20, 1, utf8_decode("0.00"), 0, 0, 'C');
                    $pdf->Cell(20, 1, utf8_decode($tipoServ), 0, 0, 'C');
                    $total1 = $total1 + $montoCancelado1;
                    $total2 = $total2 + 0;
                } else {
                    $pdf->Cell(20, 1, utf8_decode("0.00"), 0, 0, 'C');
                    $pdf->Cell(20, 1, utf8_decode(number_format($montoCancelado1, 2)), 0, 0, 'C');
                    $pdf->Cell(20, 1, utf8_decode($tipoServ), 0, 0, 'C');
                    $total1 = $total1 + 0;
                    $total2 = $total2 + $montoCancelado1;
                }
                $pdf->Cell(15, 1, utf8_decode(number_format($montoCancelado1, 2)), 0, 0, 'C');
                $pdf->Cell(10, 1, utf8_decode(number_format($datos["totalImpuesto"], 2)), 0, 0, 'C');
                $pdf->Cell(15, 1, utf8_decode(number_format(doubleval($montoCancelado1) + doubleval($datos["totalImpuesto"]), 2)), 0, 0, 'C');
                $total3 = $total3 + $montoCancelado1;
                $total4 = $total4 + $datos['totalImpuesto'];
                $total5 = $total5 + $montoCancelado1 + $datos['totalImpuesto'];
                $pdf->Ln(5);
                $contador += 1;
                $contador2 += 1;
                if ($contador2 == 44) {
                    $pdf->AddPage("", 'Letter');
                    include('encabezado_tabla2.php');
                    $contador2 = 1;
                }
            }
            ////////////////////////////////////////////////////////////
            $desde = $years . '-' . $mes . '-01';
            $hasta = $years . '-' . $mes . '-31';
            $desde = date('Y-m-d', strtotime($desde));
            $hasta = date('Y-m-d', strtotime($hasta));
            $sql = "SELECT * FROM tbl_ventas_manuales WHERE fechaComprobante BETWEEN '$desde' AND '$hasta' AND tipoComprobante = 2 ORDER BY idVenta ASC";
            $query = $mysqli->query($sql);
            while ($datos = $query->fetch_Array()) {
                if ($datos["montoCable"] > 0 && is_numeric($datos["montoCable"])) {
                    $tipoServ='CABLE';
                    $montoCancelado1 = doubleval($datos["montoCable"]);
                }elseif ($datos["montoInternet"] > 0 && is_numeric($datos["montoInternet"])) {
                    $tipoServ='INTERNET';
                    $montoCancelado1 = doubleval($datos["montoInternet"]);
                }else {
                    $montoCancelado1 = 0;
                }


                $pdf->SetFont('Times', '', 6.4);
                $pdf->Cell(5, 1, utf8_decode(date("d", strtotime($datos['fechaComprobante']))), 0, 0, 'L');
                $pdf->Cell(20,1,utf8_decode($datos['prefijo'] . $datos['numeroComprobante']),0,0,'L');
                $pdf->SetFont('Times', '', 8);
                $pdf->Cell(15, 1, utf8_decode(0), 0, 0, 'C');
                $pdf->SetFont('Times', '', 7);
                $pdf->Cell(60, 1, utf8_decode($datos["nombreCliente"]), 0, 0, 'L');
                if ($ex->isExento($datos["codigoCliente"])) {
                    $pdf->Cell(20, 1, utf8_decode(number_format($montoCancelado1, 2)), 0, 0, 'C');
                    $pdf->Cell(20, 1, utf8_decode("0.00"), 0, 0, 'C');
                    $pdf->Cell(20, 1, utf8_decode($tipoServ), 0, 0, 'C');
                    $total1 = $total1 + $montoCancelado1;
                    $total2 = $total2 + 0;
                } else {
                    $pdf->Cell(20, 1, utf8_decode("0.00"), 0, 0, 'C');
                    $pdf->Cell(20, 1, utf8_decode(number_format($montoCancelado1, 2)), 0, 0, 'C');
                    $pdf->Cell(20, 1, utf8_decode($tipoServ), 0, 0, 'C');
                    $total1 = $total1 + 0;
                    $total2 = $total2 + $montoCancelado1;
                }
                $pdf->Cell(15, 1, utf8_decode(number_format($montoCancelado1, 2)), 0, 0, 'C');
                $pdf->Cell(10, 1, utf8_decode(number_format($datos["totalImpuesto"], 2)), 0, 0, 'C');
                $pdf->Cell(15, 1, utf8_decode(number_format(doubleval($montoCancelado1) + doubleval($datos["totalImpuesto"]), 2)), 0, 0, 'C');
                $total3 = $total3 + $montoCancelado1;
                $total4 = $total4 + $datos['totalImpuesto'];
                $total5 = $total5 + $montoCancelado1 + $datos['totalImpuesto'];
                $pdf->Ln(5);
                $contador += 1;
                $contador2 += 1;
                if ($contador2 == 44) {
                    $pdf->AddPage("", 'Letter');
                    include('encabezado_tabla2.php');
                    $contador2 = 1;
                }
            }
            ///////////////////////////////////////////////////////////////////////
            $desde = $years . '-' . $mes . '-01';
            $hasta = $years . '-' . $mes . '-31';
            $desde = date('Y-m-d', strtotime($desde));
            $hasta = date('Y-m-d', strtotime($hasta));
            $sql = "SELECT * FROM tbl_ventas_anuladas WHERE fechaComprobante BETWEEN '$desde' AND '$hasta' AND tipoComprobante = 2 ORDER BY numeroComprobante ASC";
            $query = $mysqli->query($sql);
            while ($datos = $query->fetch_Array()) {
                if ($datos["totalComprobante"] > 0 && is_numeric($datos["totalComprobante"])) {
                    $montoCancelado1 = doubleval($datos["totalComprobante"]);
                }else {
                    $montoCancelado1 = 0;
                }
                if ($datos["tipoServicio"] == 'C'){
                    $tipoServ='CABLE';
                }else{
                    $tipoServ='INTERNET';
                }

                $pdf->SetFont('Times', '', 6.4);
                $pdf->Cell(5, 1, utf8_decode(date("d", strtotime($datos['fechaComprobante']))), 0, 0, 'L');
                $pdf->Cell(20,1,utf8_decode($datos['prefijo'] . $datos['numeroComprobante']),0,0,'L');
                $pdf->SetFont('Times', '', 8);
                $pdf->Cell(15, 1, utf8_decode(0), 0, 0, 'C');
                $pdf->SetFont('Times', '', 7);
                $pdf->Cell(60, 1, utf8_decode($datos["nombreCliente"]), 0, 0, 'L');
                if ($ex->isExento($datos["codigoCliente"])) {
                    $pdf->Cell(20, 1, utf8_decode(number_format($montoCancelado1, 2)), 0, 0, 'C');
                    $pdf->Cell(20, 1, utf8_decode("0.00"), 0, 0, 'C');
                    $pdf->Cell(20, 1, utf8_decode($tipoServ), 0, 0, 'C');
                    $total1 = $total1 - $montoCancelado1;
                    $total2 = $total2 - 0;
                } else {
                    $pdf->Cell(20, 1, utf8_decode("0.00"), 0, 0, 'C');
                    $pdf->Cell(20, 1, utf8_decode(number_format($montoCancelado1, 2)), 0, 0, 'C');
                    $pdf->Cell(20, 1, utf8_decode($tipoServ), 0, 0, 'C');
                    $total1 = $total1 - 0;
                    $total2 = $total2 - $montoCancelado1;
                }
                $pdf->Cell(15, 1, utf8_decode(number_format($montoCancelado1, 2)), 0, 0, 'C');
                $pdf->Cell(10, 1, utf8_decode(number_format($datos["totalImpuesto"], 2)), 0, 0, 'C');
                $pdf->Cell(15, 1, utf8_decode(number_format(doubleval($montoCancelado1) + doubleval($datos["totalImpuesto"]), 2)), 0, 0, 'C');
                $total3 = $total3 - $montoCancelado1;
                $total4 = $total4 - $datos['totalImpuesto'];
                $total5 = $total5 - $montoCancelado1 + $datos['totalImpuesto'];
                $pdf->Ln(5);
                $contador += 1;
                $contador2 += 1;
                if ($contador2 == 44) {
                    $pdf->AddPage("", 'Letter');
                    include('encabezado_tabla2.php');
                    $contador2 = 1;
                }
            }
            break;
    }

    $pdf->SetFont('Times', 'B', 7);
    $pdf->Cell(40, 6, utf8_decode(''), 0, 0, 'C');
    $pdf->Cell(60, 6, utf8_decode('TOTALES DEL MES'), "T", 0, 'C');
    $pdf->Cell(20, 6, utf8_decode(number_format($$total1, 2)), "T", 0, 'C');
    $pdf->Cell(20, 6, utf8_decode(number_format($total2, 2)), "T", 0, 'C');
    $pdf->Cell(20, 6, utf8_decode('-'), "T", 0, 'C');
    $pdf->Cell(15, 6, utf8_decode(number_format($total3, 2)), "T", 0, 'C');
    $pdf->Cell(10, 6, utf8_decode(number_format($total4, 2)), "T", 0, 'C');
    $pdf->Cell(15, 6, utf8_decode(number_format($total5, 2)), "T", 0, 'C');

    if ($resumen == 1) {
        if ($contador2 > 21) {
            $pdf->AddPage("", 'Letter');
            $pdf->SetFont('Times', '', 10);
        } else {
            $pdf->ln(5);
        }

        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(40, 3.5, utf8_decode('RESUMEN'), 0, 1, 'L');
        $pdf->Cell(40, 3.5, utf8_decode('Ventas exentas'), 0, 0, 'L');
        $pdf->Cell(40, 3.5, utf8_decode(number_format($total1, 2)), 0, 1, 'L');
        $pdf->Cell(40, 3.5, utf8_decode('Ventas netas gravadas'), 0, 0, 'L');
        $resumen2 = $total2 / 1.13;
        $pdf->Cell(40, 3.5, utf8_decode(number_format($resumen2, 2)), 0, 1, 'L');
        $pdf->Cell(40, 3.5, utf8_decode('13% de IVA'), 0, 0, 'L');
        $resumen3 = $resumen2 * 0.13;
        $pdf->Cell(40, 3.5, utf8_decode(number_format($resumen3, 2)), 0, 1, 'L');
        $pdf->Cell(40, 3.5, utf8_decode('5% CESC'), 0, 0, 'L');
        $pdf->Cell(40, 3.5, utf8_decode(number_format($total4, 2)), 0, 1, 'L');
        $pdf->Cell(40, 3.5, utf8_decode('Exportaciones'), 0, 0, 'L');
        $pdf->Cell(40, 3.5, utf8_decode('0.00'), 0, 1, 'L');
        $pdf->Cell(60, 3.5, utf8_decode(''), "T", 1, 'C');
        $pdf->Cell(40, 3.5, utf8_decode("VENTAS TOTALES:"), "", 0, 'L');
        $pdf->Cell(20, 3.5, utf8_decode(number_format(($total1 + $resumen2 + $resumen3 + $total4), 2)), "", 1, 'L');
        $pdf->Ln(20);
        $pdf->Cell(70, 3, utf8_decode(''), "T", 1, 'C');
        $pdf->Cell(40, 1, utf8_decode("Nombre y firma del contador"), "", 0, 'L');
    }
}
$pdf->Output();
