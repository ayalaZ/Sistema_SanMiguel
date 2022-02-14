<?php
require '../../../pdfs/fpdf.php';

define("titulo", $encabezados);
define("numeros", $numerodePagina);
define("mes", $monthName);
define("año", $years);

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        if (titulo == 1) {
            // Arial bold 15
            $this->SetFont('Times', 'B', 12);
            // Título
            $this->Cell(260, 6, utf8_decode('LIBRO O REGISTRO DE OPERACIONES CON EMISION DE CREDITO FISCAL'), 0, 0, 'C');
            // Salto de línea
            $this->Ln(5);
            $this->Cell(260, 6, utf8_decode(mes." ".año." (VALORES EXPRESADOS EN US DOLARES)"), 0, 0, 'C');
            $this->Ln(10);
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
$pdf->AddPage("L",'Letter');
$pdf->SetFont('Times', '', 10);
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
  //CUERPO DE TABLA 
  if ($detallado == 1) {
    $desde = $years . '-' . $mes . '-01';
    $hasta = $years . '-' . $mes . '-31';
    $desde = date('Y-m-d', strtotime($desde));
    $hasta = date('Y-m-d', strtotime($hasta));
    $sql = "SELECT *, (SELECT num_registro FROM clientes WHERE clientes.cod_cliente=tbl_cargos.codigoCliente) AS nRegistro FROM tbl_cargos WHERE fechaFactura BETWEEN '$desde' AND '$hasta' AND tipoFactura =1 ORDER BY idFactura";
  }
  $contador = 1;
  $query = $mysqli->query($sql);
  while($datos = $query->fetch_Array()){
    $pdf->SetFont('Times', '', 8);
    $pdf->Cell(10, 6, utf8_decode($contador), 0, 0, 'C');
    $pdf->Cell(20, 6, utf8_decode($datos['fechaFactura']), 0, 0, 'C');
    $pdf->Cell(20, 6, utf8_decode(substr($datos['numeroFactura'], 9, 7)), 0, 0, 'C');
    $pdf->Cell(15, 6, utf8_decode('0'), 0, 0, 'C');
    $pdf->SetFont('Times', '', 5.8);
    $caracteres = strlen($datos["nombre"]);
    if ($caracteres >= 47) {
        $recortado = substr($datos["nombre"], 0, 47);
        $pdf->Cell(60, 6, utf8_decode($recortado), 0, 0, 'L');
    }else{
        $pdf->Cell(60, 6, utf8_decode($datos['nombre']), 0, 0, 'L');
    }
    $pdf->SetFont('Times', '', 8);
    if ($datos['nombre'] == '<<< Comprobante anulado >>>') {
        $nrc = '';
    } else {
        $nrc = $datos['nRegistro'];
    }
    $pdf->Cell(15, 6, utf8_decode($nrc), 0, 0, 'C');

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

    $pdf->Cell(10, 6, utf8_decode($montoCancelado), 0, 0, 'C');
    $pdf->Cell(20, 6, utf8_decode(round($internasGravadas,2)), 0, 0, 'C');

    $pdf->Ln(5);
    $contador +=1;
  }

$pdf->Output();
