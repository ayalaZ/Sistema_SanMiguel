<?php
require '../../../pdfs/fpdf.php';
require '../../../numLe/src/NumerosEnLetras.php';
require_once("../../../php/config.php");
//require_once("GetAllInfo.php");
//use Luecano\NumeroALetras\NumeroALetras;

require_once("getTodo.php");
if(!isset($_SESSION))
{
    session_start();
}
$host = DB_HOST;
$user = DB_USER;
$password = DB_PASSWORD;
$database = $_SESSION['db'];
$mysqli = new mysqli($host, $user, $password, $database);

$cobrador = $_POST['cobradorImp'];
$diaCobro = $_POST['diaImp'];
$fechaGenerada = $_POST['fechaImp'];
$tipoServicio = $_POST['tipoServicioImp'];
$tipoComprobante = $_POST['tipoComprobanteImp'];
$dataInfo = new GetAllInfo();
$nDesde = $_POST['desdeImp'];
$nHasta = $_POST['hastaImp'];
//$codigo = $_GET['id'];

if (!empty($nDesde) && !empty($nHasta)){
    
    if ($cobrador == 'todos') {
      if ($tipoServicio == 'T') {
        $query = "SELECT * FROM tbl_cargos WHERE SUBSTRING(fechaCobro, 9, 10) = '$diaCobro'  AND fechaFactura = '$fechaGenerada' AND tipoFactura ='$tipoComprobante' AND numeroFactura >= '$nDesde' AND numeroFactura <= '$nHasta'";
      }else{
        $query = "SELECT * FROM tbl_cargos WHERE SUBSTRING(fechaCobro, 9, 10) = '$diaCobro'  AND fechaFactura = '$fechaGenerada' AND tipoFactura ='$tipoComprobante' AND tipoServicio = '$tipoServicio' AND numeroFactura BETWEEN '$nDesde' AND '$nHasta'";
      }
      ////// contrario a todos los cobradores
    }else{
      if ($tipoServicio == 'T') {
        $query = "SELECT * FROM tbl_cargos WHERE SUBSTRING(fechaCobro, 9, 10) = '$diaCobro'  AND fechaFactura = '$fechaGenerada' AND tipoFactura ='$tipoComprobante' AND codigoCobrador = '$cobrador' AND numeroFactura >= '$nDesde' AND numeroFactura <= '$nHasta'";
      }else{
        $query = "SELECT * FROM tbl_cargos WHERE SUBSTRING(fechaCobro, 9, 10) = '$diaCobro'  AND fechaFactura = '$fechaGenerada' AND tipoFactura ='$tipoComprobante' AND tipoServicio = '$tipoServicio' AND codigoCobrador = '$cobrador' AND numeroFactura BETWEEN '$nDesde' AND '$nHasta'";
      }

    }
/////// contrario a especificacion desde hasta de numero de facturas
}else{
  if ($cobrador == 'todos') {
      if ($tipoServicio == 'T') {
        $query = "SELECT * FROM tbl_cargos WHERE SUBSTRING(fechaCobro, 9, 10) = '$diaCobro'  AND fechaFactura = '$fechaGenerada' AND tipoFactura ='$tipoComprobante'";
      }else{
        $query = "SELECT * FROM tbl_cargos WHERE SUBSTRING(fechaCobro, 9, 10) = '$diaCobro'  AND fechaFactura = '$fechaGenerada' AND tipoFactura ='$tipoComprobante' AND tipoServicio = '$tipoServicio'";
      }
      ////// contrario a todos los cobradores
    }else{
      if ($tipoServicio == 'T') {
        $query = "SELECT * FROM tbl_cargos WHERE SUBSTRING(fechaCobro, 9, 10) = '$diaCobro'  AND fechaFactura = '$fechaGenerada' AND tipoFactura ='$tipoComprobante' AND codigoCobrador = '$cobrador'";
      }else{
        $query = "SELECT * FROM tbl_cargos WHERE SUBSTRING(fechaCobro, 9, 10) = '$diaCobro'  AND fechaFactura = '$fechaGenerada' AND tipoFactura ='$tipoComprobante' AND tipoServicio = '$tipoServicio' AND codigoCobrador = '$cobrador'";
      }

    }

}

$resultado = $mysqli->query($query);

if ($tipoComprobante == 2) {
    //INICIO IMPRESIÓN DE FACTURACIÓN NORMAL
    //*******************************FACTURA NORMAL**********************************
      //$pdf = new FPDF();
      $pdf = new FPDF('L','mm',array(215,330));
      date_default_timezone_set('America/El_Salvador');

      setlocale(LC_ALL,"es_ES");
      $pdf->SetFont('Arial','',7);
      while($row = $resultado->fetch_assoc())
      {    //if ($row['idMunicipio'] != "0301"){var_dump($row["codigoCliente"]." ".$row["idMunicipio"]);}

        // SQL query para traer nombre del municipio
        $query = "SELECT nombreMunicipio FROM tbl_municipios_cxc WHERE idMunicipio=".$row['idMunicipio'];
        // Preparación de sentencia
        $statement = $mysqli->query($query);
        //$statement->execute();
        while ($result = $statement->fetch_assoc()) {
            $municipio = $result['nombreMunicipio'];
        }

        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->Image('../../../images/comp.png',155,120, 45, 10);
        if ($row["anulada"] == 1){
            //$pdf->Image('../../../images/anulada.png',155,120);
            $pdf->Image('../../../images/anulada.png',135,70);
            $pdf->Image('../../../images/anulada.png',20,70);
        }
        if ($row['tipoServicio'] == "C") {
            $prepago_cargos = $row['prepago_cargos'];
            $pdf->Image('../../../images/cable.png',45,100, 15, 17);
            
            $pdf->Image('../../../images/cable.png',160,100, 15, 17);
            $pdf->Image('../../../images/cable.png',290,100, 15, 17);
            $unitario = $row['cuotaCable'];
            $monto = $dataInfo->getTotalCobrarCableImp('tbl_cargos', $row['codigoCliente'], 'pendiente', 0, $row['fechaCobro'], 'i');
            $montoSinImpuestos = $dataInfo->getTotalCobrarCableImp('tbl_cargos', $row['codigoCliente'], 'pendiente', 0, $row['fechaCobro'], 's');
            $montoSoloImpuestos = $dataInfo->getTotalCobrarCableImp('tbl_cargos', $row['codigoCliente'], 'pendiente', 0, $row['fechaCobro'], 'si');
            $cantidadMeses = $dataInfo->getDeudaUnitariaC('tbl_cargos', $row['codigoCliente'], 'pendiente', 0, $row['fechaCobro']);
            if ($monto <= 0) {
                $mensaje = 'EL RECIBO DEL PRESENTE MES YA HA SIDO CANCELADO.';
            }else {
                $mensaje = 'CANCELE SU SALDO PENDIENTE ANTES DEL VENCIMIENTO, PARA EVITAR SUSPENSIÓN DE SERVICIOS.';
            }

            if (strlen($row['direccion']) > 65) {
                $direccion = substr($row['direccion'], 0, 65);
            }else {
                $direccion = $row['direccion'];
            }
            /////// nuevo valor prepago con 3% extra por eliminacion de Cess
            $prepago_cargos = $row['prepago_cargos'];
            $nuevo_precio = number_format($prepago_cargos,2);
        }
        elseif ($row['tipoServicio'] == "I") {
            $pdf->Image('../../../images/inter.png',45,100, 15, 17);
            $pdf->Image('../../../images/inter.png',160,100, 15, 17);
            $pdf->Image('../../../images/inter.png',290,100, 15, 17);
            $unitario = $row['cuotaInternet'];
            $monto = $dataInfo->getTotalCobrarInterImp('tbl_cargos', $row['codigoCliente'], 'pendiente', 0, $row['fechaFactura'], 'i');
            $montoSinImpuestos = $dataInfo->getTotalCobrarInterImp('tbl_cargos', $row['codigoCliente'], 'pendiente', 0, $row['fechaFactura'], 's');
            $montoSoloImpuestos = $dataInfo->getTotalCobrarInterImp('tbl_cargos', $row['codigoCliente'], 'pendiente', 0, $row['fechaCobro'], 'si');
            $cantidadMeses = $dataInfo->getDeudaUnitariaI('tbl_cargos', $row['codigoCliente'], 'pendiente', 0, $row['fechaCobro']);
            if ($monto <= 0) {
                $mensaje = 'EL RECIBO DEL PRESENTE MES YA HA SIDO CANCELADO.';
            }else {
                $mensaje = 'CANCELE SU SALDO PENDIENTE ANTES DEL VENCIMIENTO, PARA EVITAR SUSPENSIÓN DE SERVICIOS.';
            }
            /////// nuevo valor prepago con 3% extra por eliminacion de Cess
            $prepago_cargos = $row['prepago_cargos'];
            $nuevo_precio = number_format($prepago_cargos,2);
        }
        if (strlen($row['direccion']) > 65) {
            $direccion = substr($row['direccion'], 0, 65);
        }else {
            $direccion = $row['direccion'];
        }
    ///////////////////////////////////////////////////////////////////////////////////////////
        $pdf->Ln(4);
        $pdf->Cell(70,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,6,utf8_decode(strtoupper($row['numeroFactura'])),0,0,'L');
        $pdf->Cell(50,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,6,utf8_decode(strtoupper($row['numeroFactura'])),0,0,'L');
        $pdf->Cell(25,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,-5,utf8_decode(strtoupper($row['numeroFactura'])),0,1,'L');

        //DATOS DEL CLIENTE
        $pdf->Ln(29.5);
        $pdf->Cell(10,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,6,utf8_decode($row['codigoCliente']),0,0,'L');
        $pdf->Cell(70,6,utf8_decode(strftime('%d', strtotime($row['fechaFactura']))." de ".strftime('%B', strtotime($row['fechaFactura'])). " de ".strftime('%G', strtotime($row['fechaFactura']))),0,0,'L');

        //DUPLICADO 1
        $pdf->Cell(-15,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,6,utf8_decode($row['codigoCliente']),0,0,'L');
        $pdf->Cell(-13,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,6,utf8_decode(strftime('%d', strtotime($row['fechaFactura']))." de ".strftime('%B', strtotime($row['fechaFactura'])). " de ".strftime('%G', strtotime($row['fechaFactura']))),0,0,'L');
        $pdf->Cell(5,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,15,utf8_decode(strftime('%d', strtotime($row['fechaFactura']))." de ".strftime('%B', strtotime($row['fechaFactura'])). " de ".strftime('%G', strtotime($row['fechaFactura']))),0,1,'L');
        $pdf->Ln(-10);
        $pdf->Cell(10,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,6,utf8_decode($row['nombre']),0,0,'L');
        $pdf->Cell(55,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,6,utf8_decode($row['nombre']),0,1,'L');
        $pdf->Cell(10,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(30,6,utf8_decode($direccion),0,0,'L');
        $pdf->Cell(95,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,6,utf8_decode($direccion),0,1,'L');

        $pdf->Ln(-10);
        $pdf->Cell(265,6,utf8_decode(''),0,0,'L');
        //COD CLIENTE 3RA COLUMNA
        $pdf->Cell(70,12,utf8_decode($row['codigoCliente']),0,1,'L');
        $pdf->Ln(10);
        $pdf->Cell(15,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,-20,utf8_decode($municipio),0,0,'L');
        $pdf->Cell(55,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,-20,utf8_decode($municipio),0,0,'L');
        $pdf->Cell(45,6,utf8_decode(''),0,0,'L');

        $pdf->Cell(70,-20,utf8_decode($row['nombre']),0,1,'L');
        $pdf->Ln(10);
        //TELEFONO
        $pdf->Cell(60,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(110,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,20,utf8_decode($direccion),0,1,'L');
        $pdf->Ln(15);
    //////////////////////////////FIN FRANJA 1///////////////////////////////////
        $pdf->Cell(30,6,utf8_decode('1'),0,0,'R');
        $pdf->Cell(35,6,utf8_decode("Pendiente ".strftime('%B', strtotime($row['fechaCobro'])). " de ".strftime('%Y', strtotime($row['fechaCobro']))),0,0,'L');

        if ($row['exento'] != "T") {
            $pdf->Cell(30,6,utf8_decode("$".$unitario),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".number_format($unitario,2)),0,0,'L');
        }
        else {
            $pdf->Cell(20,6,utf8_decode("$".$unitario),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".number_format($unitario,2)),0,0,'L');
        }


        $pdf->Cell(-15,6,utf8_decode('1'),0,0,'R');
        $pdf->Cell(35,6,utf8_decode("Pendiente ".strftime('%B', strtotime($row['fechaCobro'])). " de ".strftime('%Y', strtotime($row['fechaCobro']))),0,0,'L');

        if ($row['exento'] != "T") {
            $pdf->Cell(30,6,utf8_decode("$".$unitario),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".number_format($unitario,2)),0,1,'L');
        }
        else {
            $pdf->Cell(35,6,utf8_decode("$".$unitario),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".number_format($unitario,2)),0,1,'L');
        }
        /////// ingreso nuevo valor prepago con 3% extra por eliminacion de Cess en la factura
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(58,3,utf8_decode(""),0,0,'R');
        $pdf->Cell(40,2,utf8_decode("$".$nuevo_precio),0,0,'R');
        $pdf->Cell(115,2,utf8_decode("$".$nuevo_precio),0,0,'R');
        $pdf->Cell(100,2,utf8_decode("Nueva cuota a partir de Noviembre $".$nuevo_precio),0,0,'R');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(260,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,-30,utf8_decode($municipio),0,1,'L');
        $pdf->Ln(10);
    //////////////////////////////INICIO FRANJA 2 ///////////////////////////////
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(5,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,6,utf8_decode(strtoupper(strftime('%B', strtotime($row['fechaCobro'])))),0,0,'L');
        $pdf->Cell(45,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,6,utf8_decode(strtoupper(strftime('%B', strtotime($row['fechaCobro'])))),0,1,'L');

        //var_dump($monto, $row['codigoCliente']);
        $pdf->Cell(5,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,6,utf8_decode("$".number_format($unitario + $row['totalImpuesto'],2)),0,0,'L');
        $pdf->Cell(45,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,6,utf8_decode("$".number_format($unitario + $row['totalImpuesto'],2)),0,1,'L');
        $pdf->Cell(285,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,-20,utf8_decode(strtoupper("Hasta: ".strftime('%B', strtotime($row['fechaCobro'])))),0,1,'L');

        $pdf->Ln(25);
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(5,6,utf8_decode(''),0,0,'L');
        $thisMonth=date_create($row['fechaCobro']);
        date_sub($thisMonth,date_interval_create_from_date_string("1 month"));
        $earlierMonth = date_format($thisMonth,"Y-m-d");
        $pdf->Cell(70,6,utf8_decode(strtoupper(strftime('%B', strtotime($earlierMonth)))),0,0,'L'); //MES ANTERIOR / ANTICIPO
        $pdf->Cell(45,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,6,utf8_decode(strtoupper(strftime('%B', strtotime($earlierMonth)))),0,1,'L'); //MES ANTERIOR / ANTICIPO

        $pdf->Cell(5,6,utf8_decode(''),0,0,'L');
        if ($dataInfo->getBeforeSM('tbl_cargos', $row['codigoCliente'], $row['tipoServicio'], 0, $row['fechaFactura']) == "VACIA") {
            $ant = doubleval(0.00) + doubleval(0.00);
            $pdf->Cell(70,6,utf8_decode("$".number_format($ant,2)),0,0,'L');
        }else {
            $ant = $dataInfo->getBeforeSM('tbl_cargos', $row['codigoCliente'], $row['tipoServicio'], 0, $row['fechaFactura']);
            $pdf->Cell(70,6,utf8_decode("$".number_format($ant,2)),0,0,'L');
        }

        $pdf->Cell(45,6,utf8_decode(''),0,0,'L');
        if ($dataInfo->getBeforeSM('tbl_cargos', $row['codigoCliente'], $row['tipoServicio'], 0, $row['fechaFactura']) == "VACIA") {
            $ant = doubleval(0.00) + doubleval(0.00);
            $pdf->Cell(60,6,utf8_decode("$".number_format($ant,2)),0,1,'L');
        }else {
            $ant = $dataInfo->getBeforeSM('tbl_cargos', $row['codigoCliente'], $row['tipoServicio'], 0, $row['fechaFactura']);
            $pdf->Cell(60,6,utf8_decode("$".number_format($ant,2)),0,1,'L');
        }

        $pdf->SetFont('Arial','B',10);
        $totalFactura = number_format((doubleval($unitario) + doubleval($row['totalImpuesto'])+doubleval($ant)),2);//(doubleval($unitario) + doubleval($row['totalImpuesto']) + doubleval($ant)),2); // ACA SE CALCULA MONTO TOTAL
        $pdf->Cell(285,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,-45,utf8_decode($totalFactura),0,1,'L'); // MONTO TOTAL QUE APARECE EN COLUMNA 3
        $pdf->Cell(285,6,utf8_decode(''),0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(70,60,utf8_decode('VENCE: '.date_format(date_create($row['fechaVencimiento']), 'd/m/Y')),0,1,'L');
        //$pdf->Ln(55);
        $pdf->SetFont('Arial','B',10);

        $pdf->Cell(5,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,6,utf8_decode("$".$totalFactura),0,0,'L'); //MONTO TOTAL GRANDE
        $pdf->Cell(45,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,6,utf8_decode("$".$totalFactura),0,1,'L'); //MONTO TOTAL GRANDE
         //$pdf->Cell(70,5,utf8_decode("PRUEBAAAAAA"),0,1,'L'); //MONTO TOTAL GRANDE
        $pdf->SetFont('Arial','',7);

        //$pdf->Ln();
        if ($row['exento'] != "T") {
            $pdf->Cell(96,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".number_format($unitario,2)),0,0,'L');
            $pdf->Cell(50,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".number_format($unitario,2)),0,1,'L');
            $pdf->Ln(-2);
            $pdf->Cell(96,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".'0.00'),0,0,'L');
            $pdf->Cell(50,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".'0.00'),0,1,'L');
            $pdf->Ln(-2);
            $pdf->Cell(21,6,utf8_decode(''),0,0,'L');
            $numeroALetras = NumerosEnLetras::convertir(number_format((doubleval($unitario) + doubleval($row['totalImpuesto'])),2), 'dólares', false, 'centavos');
            $pdf->Cell(45,6,utf8_decode($numeroALetras),0,0,'C');
            $pdf->Cell(30,6,utf8_decode(""),0,0,'L'); //IMPUESTO SEGURIDAD
            $pdf->Cell(70,6,utf8_decode("$".number_format($row['totalImpuesto'],2)),0,0,'L');
            $pdf->Cell(-25,6,utf8_decode(''),0,0,'L');
            //$numeroALetras = NumerosEnLetras::convertir(number_format($monto,2), 'dólares', false, 'centavos');
            $pdf->Cell(45,6,utf8_decode($numeroALetras),0,0,'C');
            $pdf->Cell(30,6,utf8_decode(""),0,0,'L'); //IMPUESTO SEGURIDAD
            $pdf->Cell(70,6,utf8_decode("$".number_format($row['totalImpuesto'],2)),0,1,'L');
            $pdf->Ln(-2);
            $pdf->Cell(96,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".'0.00'),0,0,'L');
            $pdf->Cell(50,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".'0.00'),0,1,'L');
            $pdf->Ln(-2);
            $pdf->Cell(96,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".number_format(doubleval($unitario) + doubleval($row['totalImpuesto']),2)),0,0,'L');
            $pdf->Cell(50,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".number_format(doubleval($unitario) + doubleval($row['totalImpuesto']),2)),0,1,'L');

            //COBRADOR
            $pdf->Cell(35,6,utf8_decode(""),0,0,'L');
            $pdf->Cell(40,6,utf8_decode($dataInfo->getCobrador('tbl_cobradores',$row['codigoCobrador'])),0,0,'L');
            $pdf->Cell(80,6,utf8_decode(""),0,0,'L');
            $pdf->Cell(40,6,utf8_decode($dataInfo->getCobrador('tbl_cobradores',$row['codigoCobrador'])),0,1,'L');

            $pdf->Ln(25);
            $pdf->Cell(1,1,utf8_decode(""),0,0,'L');
            $pdf->Cell(20,1,utf8_decode("VENCE: ".date_format(date_create($row['fechaVencimiento']), 'd/m/Y')),0,0,'C');

            $pdf->MultiCell(80,3,utf8_decode($mensaje),0,'C',0);

            $pdf->Cell(120,1,utf8_decode(""),0,0,'L');
            $pdf->Cell(20,1,utf8_decode("VENCE: ".date_format(date_create($row['fechaVencimiento']), 'd/m/Y')),0,0,'C');

            $pdf->MultiCell(80,3,utf8_decode($mensaje),0,'C',0);
        }
        else {
            $pdf->Cell(85,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".number_format($unitario,2)),0,0,'L');
            $pdf->Cell(55,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".number_format($unitario,2)),0,1,'L');
            $pdf->Ln(-2);
            $pdf->Cell(85,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".'0.00'),0,0,'L');
            $pdf->Cell(55,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".'0.00'),0,1,'L');
            $pdf->Ln(-2);
            $pdf->Cell(20,6,utf8_decode(''),0,0,'L');
            $numeroALetras = NumerosEnLetras::convertir(number_format((doubleval($unitario) + doubleval($row['totalImpuesto'])),2), 'dólares', false, 'centavos');
            $pdf->Cell(45,6,utf8_decode($numeroALetras),0,0,'C');
            $pdf->Cell(20,6,utf8_decode(""),0,0,'L'); //IMPUESTO SEGURIDAD
            $pdf->Cell(70,6,utf8_decode("$".number_format($row['totalImpuesto'],2)),0,0,'L');

            $pdf->Cell(-5,6,utf8_decode(''),0,0,'L');
            //$numeroALetras = NumerosEnLetras::convertir(number_format($monto,2), 'dólares', false, 'centavos');
            $pdf->Cell(40,6,utf8_decode($numeroALetras),0,0,'C');
            $pdf->Cell(20,6,utf8_decode(""),0,0,'L'); //IMPUESTO SEGURIDAD
            $pdf->Cell(70,6,utf8_decode("$".number_format($row['totalImpuesto'],2)),0,1,'L');

            $pdf->Ln(-2);
            $pdf->Cell(85,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".'0.00'),0,0,'L');
            $pdf->Cell(55,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".'0.00'),0,1,'L');
            $pdf->Ln(-2);
            $pdf->Cell(85,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".number_format(doubleval($unitario) + doubleval($row['totalImpuesto']),2)),0,0,'L');
            $pdf->Cell(55,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".number_format(doubleval($unitario) + doubleval($row['totalImpuesto']),2)),0,1,'L');

            //COBRADOR
            $pdf->Cell(35,6,utf8_decode(""),0,0,'L');
            $pdf->Cell(40,6,utf8_decode($dataInfo->getCobrador('tbl_cobradores',$row['codigoCobrador'])),0,0,'L');
            $pdf->Cell(85,6,utf8_decode(""),0,0,'L');
            $pdf->Cell(40,6,utf8_decode($dataInfo->getCobrador('tbl_cobradores',$row['codigoCobrador'])),0,1,'L');

            $pdf->Ln(10);
            $pdf->Cell(1,1,utf8_decode(""),0,0,'L');
            $pdf->Cell(20,1,utf8_decode("VENCE: ".date_format(date_create($row['fechaVencimiento']), 'd/m/Y')),0,0,'C');

            $pdf->MultiCell(80,3,utf8_decode($mensaje),0,'C',0);

            $pdf->Cell(120,1,utf8_decode(""),0,0,'L');
            $pdf->Cell(20,1,utf8_decode("VENCE: ".date_format(date_create($row['fechaVencimiento']), 'd/m/Y')),0,0,'C');

            $pdf->MultiCell(80,3,utf8_decode($mensaje),0,'C',0);

        }

      }

    /* close connection */
    mysqli_close($mysqli);
    $pdf->Output();
}
// CREDITO FISCAL
elseif ($tipoComprobante == 1) {
    //INICIO IMPRESIÓN DE FACTURACIÓN NORMAL
    //*******************************FACTURA CRÉDITO FISCAL********************************
      $pdf = new FPDF('L','mm',array(216,356));
      //$pdf = new FPDF();
      date_default_timezone_set('America/El_Salvador');

      setlocale(LC_ALL,"es_ES");
      $pdf->SetFont('Arial','',7);
      while($row = $resultado->fetch_assoc())
      {

        // SQL query para traer datos del IVA
        $query = "SELECT valorImpuesto FROM tbl_impuestos WHERE siglasImpuesto = 'IVA'";
        // Preparación de sentencia
        $statement = $mysqli->query($query);
        //$statement->execute();
        while ($result = $statement->fetch_assoc()) {
            $iva = floatval($result['valorImpuesto']);
        }

        // SQL query para traer nombre del municipio
        $query = "SELECT nombreMunicipio FROM tbl_municipios_cxc WHERE idMunicipio='' OR idMunicipio=".$row['idMunicipio'];
        // Preparación de sentencia
        $statement = $mysqli->query($query);
        //$statement->execute();
        while ($result = $statement->fetch_assoc()) {
            $municipio = $result['nombreMunicipio'];
        }

        // SQL query para traer nombre del municipio
        $query = "SELECT id_departamento, numero_nit, num_registro FROM clientes WHERE cod_cliente =".$row['codigoCliente'];
        // Preparación de sentencia
        $statement = $mysqli->query($query);
        //$statement->execute();
        while ($result = $statement->fetch_assoc()) {
            $idDepartamento = $result['id_departamento'];
            $nNit = $result['numero_nit'];
            $nRegistro = $result['num_registro'];
        }

        // SQL query para traer nombre del municipio
        $query = "SELECT nombreDepartamento FROM tbl_departamentos_cxc WHERE idDepartamento='' OR idDepartamento =".$idDepartamento;
        // Preparación de sentencia
        $statement = $mysqli->query($query);
        //$statement->execute();
        while ($result = $statement->fetch_assoc()) {
            $departamento = $result['nombreDepartamento'];
        }

        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->Image('../../../images/comp.png',150,100, 45, 10);

          if ($row["anulada"] == 1){
              //$pdf->Image('../../../images/anulada.png',155,120);
              $pdf->Image('../../../images/anulada.png',135,70);
              $pdf->Image('../../../images/anulada.png',20,70);
          }
        if ($row['tipoServicio'] == "C") {
            $pdf->Image('../../../images/cable.png',40,90, 15, 17);
            $pdf->Image('../../../images/cable.png',160,88, 15, 17);
            $pdf->Image('../../../images/cable.png',285,90, 15, 17);
            $unitario = $row['cuotaCable'];
            $separado = (floatval($unitario)/(1 + floatval($iva)));
            $totalIva = floatval($separado) * floatval($iva);
            $totalIva = round($totalIva,2);

            //$totalIva = doubleval(str_replace(',' , '.' , $totalIva));
            $monto = $dataInfo->getTotalCobrarCableImp('tbl_cargos', $row['codigoCliente'], 'pendiente', 0, $row['fechaCobro'], 'i');
            $montoSinImpuestos = $dataInfo->getTotalCobrarCableImp('tbl_cargos', $row['codigoCliente'], 'pendiente', 0, $row['fechaCobro'], 's');
            $montoSoloImpuestos = $dataInfo->getTotalCobrarCableImp('tbl_cargos', $row['codigoCliente'], 'pendiente', 0, $row['fechaCobro'], 'si');
            $cantidadMeses = $dataInfo->getDeudaUnitariaC('tbl_cargos', $row['codigoCliente'], 'pendiente', 0, $row['fechaCobro']);
            if ($monto <= 0) {
                $mensaje = 'EL RECIBO DEL PRESENTE MES YA HA SIDO CANCELADO.';
            }else {
                $mensaje = 'CANCELE SU SALDO PENDIENTE ANTES DEL VENCIMIENTO, PARA EVITAR SUSPENSIÓN DE SERVICIOS.';
            }

            if (strlen($row['direccion']) > 65) {
                $direccion = substr($row['direccion'], 0, 65);
            }else {
                $direccion = $row['direccion'];
            }
            /////// nuevo valor prepago con 3% extra por eliminacion de Cess
            $prepago_cargos = $row['prepago_cargos'];
            $nuevo_precio = number_format($prepago_cargos,2);
        }
        elseif ($row['tipoServicio'] == "I") {
            $pdf->Image('../../../images/inter.png',40,90, 15, 17);
            $pdf->Image('../../../images/inter.png',160,88, 15, 17);
            $pdf->Image('../../../images/inter.png',285,90, 15, 17);
            $unitario = $row['cuotaInternet'];
            $separado = (floatval($unitario)/(1 + floatval($iva)));
            $totalIva = floatval($separado) * floatval($iva);
            $totalIva = round($totalIva,2);
            $monto = $dataInfo->getTotalCobrarInterImp('tbl_cargos', $row['codigoCliente'], 'pendiente', 0, $row['fechaCobro'], 'i');
            $montoSinImpuestos = $dataInfo->getTotalCobrarInterImp('tbl_cargos', $row['codigoCliente'], 'pendiente', 0, $row['fechaCobro'], 's');
            $montoSoloImpuestos = $dataInfo->getTotalCobrarInterImp('tbl_cargos', $row['codigoCliente'], 'pendiente', 0, $row['fechaCobro'], 'si');
            $cantidadMeses = $dataInfo->getDeudaUnitariaI('tbl_cargos', $row['codigoCliente'], 'pendiente', 0, $row['fechaCobro']);
            if ($monto <= 0) {
                $mensaje = 'EL RECIBO DEL PRESENTE MES YA HA SIDO CANCELADO.';
            }else {
                $mensaje = 'CANCELE SU SALDO PENDIENTE ANTES DEL VENCIMIENTO, PARA EVITAR SUSPENSIÓN DE SERVICIOS.';
            }
            /////// nuevo valor prepago con 3% extra por eliminacion de Cess
            $prepago_cargos = $row['prepago_cargos'];
            $nuevo_precio = number_format($prepago_cargos,2);
        }
        if (strlen($row['direccion']) > 65) {
            $direccion = substr($row['direccion'], 0, 65);
        }else {
            $direccion = $row['direccion'];
        }
    ///////////////////////////////////////////////////////////////////////////////////////////
        $pdf->Ln(5);
        $pdf->Cell(75,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(50,0,utf8_decode(strtoupper($row['numeroFactura'])),0,0,'L');
        $pdf->Cell(70,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(40,0,utf8_decode(strtoupper($row['numeroFactura'])),0,0,'L');
        $pdf->Cell(75,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(30,0,utf8_decode(strtoupper($row['numeroFactura'])),0,1,'L');
        //DATOS DEL CLIENTE
        $pdf->Ln(24.5);
        $pdf->SetFont('Arial','',6);
        $pdf->Cell(10,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,0,utf8_decode($row['codigoCliente']),0,0,'L');
        $pdf->Cell(30,0,utf8_decode(strftime('%d', strtotime($row['fechaFactura']))." de ".strftime('%B', strtotime($row['fechaFactura'])). " de ".strftime('%G', strtotime($row['fechaFactura']))),0,0,'L');
        //DUPLICADO1
        $pdf->Cell(30,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(60,0,utf8_decode($row['codigoCliente']),0,0,'L');
        $pdf->Cell(35,0,utf8_decode(strftime('%d', strtotime($row['fechaFactura']))." de ".strftime('%B', strtotime($row['fechaFactura'])). " de ".strftime('%G', strtotime($row['fechaFactura']))),0,0,'L');
        //DUPLICADO2
        $pdf->Cell(30,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(55,0,utf8_decode($row['codigoCliente']),0,0,'L');
        $pdf->Cell(30,0,utf8_decode(strftime('%d', strtotime($row['fechaFactura']))." de ".strftime('%B', strtotime($row['fechaFactura'])). " de ".strftime('%G', strtotime($row['fechaFactura']))),0,1,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Ln(5);
        //NOMBRE DE CLIENTE

        $pdf->Cell(15,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(60,0,utf8_decode($row['nombre']),0,0,'L');
        //DUPLICADO1
        $pdf->Cell(55,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(55,0,utf8_decode($row['nombre']),0,0,'L');
        //DUPLICADO2
        $pdf->Cell(65,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(55,0,utf8_decode($row['nombre']),0,1,'L');
        $pdf->Ln(3);
        //DIRECCIÓN

         

        $pdf->Cell(20,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(60,0,utf8_decode($direccion),0,0,'L');
        //DUPLICADO1
        $pdf->Cell(55,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(55,0,utf8_decode($direccion),0,0,'L');
        //DUPLICADO2
        $pdf->Cell(65,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(55,0,utf8_decode($direccion),0,1,'L');
        $pdf->Ln(4);

        //DEPTO - MUNICIPIO
        $pdf->Cell(15,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(60,0,utf8_decode($departamento),0,0,'L');
        $pdf->Cell(30,0,utf8_decode($municipio),0,0,'L');
        //DUPLICADO1
        $pdf->Cell(30,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(55,0,utf8_decode($departamento),0,0,'L');
        $pdf->Cell(30,0,utf8_decode($municipio),0,0,'L');
        //DUPLICADO2
        $pdf->Cell(35,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(55,0,utf8_decode($departamento),0,0,'L');
        $pdf->Cell(30,0,utf8_decode($municipio),0,1,'L');

        $pdf->Ln(5);

        //NIT - TELEFONO
        $pdf->Cell(10,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(60,0,utf8_decode($nNit),0,0,'L');
        $pdf->Cell(30,0,utf8_decode('Telefono'),0,0,'L');
        //DUPLICADO1
        $pdf->Cell(25,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(55,0,utf8_decode($nNit),0,0,'L');
        $pdf->Cell(30,0,utf8_decode('Telefono'),0,0,'L');
        //DUPLICADO2
        $pdf->Cell(40,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(55,0,utf8_decode($nNit),0,0,'L');
        $pdf->Cell(30,0,utf8_decode('Telefono'),0,1,'L');

        $pdf->Ln(3);

        //NIT - TELEFONO
        $pdf->Cell(15,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(60,0,utf8_decode($nRegistro),0,0,'L');
        $pdf->Cell(30,0,utf8_decode('Giro'),0,0,'L');
        //DUPLICADO1
        $pdf->Cell(30,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(55,0,utf8_decode($nRegistro),0,0,'L');
        $pdf->Cell(30,0,utf8_decode('Giro'),0,0,'L');
        //DUPLICADO2
        $pdf->Cell(35,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(55,0,utf8_decode($nRegistro),0,0,'L');
        $pdf->Cell(30,0,utf8_decode('Giro'),0,1,'L');

        $pdf->Ln(4);

        //NOMBRE COMERCIAL
        $pdf->Cell(25,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(60,0,utf8_decode('Nombre comercial'),0,0,'L');
        $pdf->Cell(30,0,utf8_decode(''),0,0,'L');
        //DUPLICADO1
        $pdf->Cell(30,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(55,0,utf8_decode('Nombre comercial'),0,0,'L');
        $pdf->Cell(30,0,utf8_decode(''),0,0,'L');
        //DUPLICADO2
        $pdf->Cell(35,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(55,0,utf8_decode('Nombre comercial'),0,0,'L');
        $pdf->Cell(30,0,utf8_decode(''),0,1,'L');

        $pdf->Ln(24);
    //////////////////////////////FIN FRANJA 1///////////////////////////////////
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(9,0,utf8_decode(''),0,0,'L');
    $pdf->Cell(10,0,utf8_decode('1'),0,0,'R');
    $pdf->Cell(55,0,utf8_decode("Pendiente ".strftime('%B', strtotime($row['fechaCobro'])). " de ".strftime('%Y', strtotime($row['fechaCobro']))),0,0,'L');

    if ($row['exento'] != "T") {
        $pdf->Cell(15,0,utf8_decode("$".number_format($separado,2)),0,0,'L');
        $pdf->Cell(70,0,utf8_decode("$".number_format($separado,2)),0,0,'L');
    }
    else {
        $pdf->Cell(20,0,utf8_decode("$".number_format($separado,2)),0,0,'L');
        $pdf->Cell(70,0,utf8_decode("$".number_format($separado,2)),0,0,'L');
    }

    $pdf->Cell(34,0,utf8_decode(''),0,0,'L');
    $pdf->Cell(-57,0,utf8_decode('1'),0,0,'R');
    $pdf->Cell(52,0,utf8_decode("Pendiente ".strftime('%B', strtotime($row['fechaCobro'])). " de ".strftime('%Y', strtotime($row['fechaCobro']))),0,0,'L');

    

    if ($row['exento'] != "T") {
        $pdf->Cell(25,0,utf8_decode("$".number_format($separado,2)),0,0,'L');
        $pdf->Cell(70,0,utf8_decode("$".number_format($separado,2)),0,0,'L');
    }
    else {
        $pdf->Cell(35,0,utf8_decode("$".number_format($separado,2)),0,0,'L');
        $pdf->Cell(70,0,utf8_decode("$".number_format($separado,2)),0,0,'L');
    }

    $pdf->Cell(21,0,utf8_decode(''),0,0,'L');
    $pdf->Cell(-46,0,utf8_decode('1'),0,0,'R');
    $pdf->Cell(55,0,utf8_decode("Pendiente ".strftime('%B', strtotime($row['fechaCobro'])). " de ".strftime('%Y', strtotime($row['fechaCobro']))),0,0,'L');
   

    if ($row['exento'] != "T") {
        $pdf->Cell(17,0,utf8_decode("$".number_format($separado,2)),0,0,'L');
        $pdf->Cell(70,0,utf8_decode("$".number_format($separado,2)),0,1,'L');
    }
    else {
        $pdf->Cell(32,0,utf8_decode("$".number_format($separado,2)),0,0,'L');
        $pdf->Cell(70,0,utf8_decode("$".number_format($separado,2)),0,1,'L');
    }
    //////////////////////////////INICIO FRANJA 2 DONDE ESTAN LOS MESES ///////////////////////////////
      /////// ingreso nuevo valor prepago con 3% extra por eliminacion de Cess en la factura
    
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(80,2,utf8_decode(""),0,1,'R');
        $pdf->Cell(99,2,utf8_decode("$".$nuevo_precio),0,0,'R');
        $pdf->Cell(124,2,utf8_decode("$".$nuevo_precio),0,0,'R');
        $pdf->Cell(92,2,utf8_decode("Nueva cuota a partir de Noviembre $".$nuevo_precio),0,0,'R');
        $pdf->SetFont('Arial','',7);
    
        $pdf->Ln(-3);

        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(-3,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,0,utf8_decode(strtoupper(strftime('%B', strtotime($row['fechaCobro'])))),0,0,'L');
        $pdf->Cell(48,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(65,0,utf8_decode(strtoupper(strftime('%B', strtotime($row['fechaCobro'])))),0,0,'L');
        $pdf->Cell(58,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,0,utf8_decode(strtoupper(strftime('%B', strtotime($row['fechaCobro'])))),0,1,'L');

        $pdf->Ln(3);

        $pdf->Cell(-3,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,0,utf8_decode("$".number_format($unitario + $row['totalImpuesto'],2)),0,0,'L');
        $pdf->Cell(48,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(65,0,utf8_decode("$".number_format($unitario + $row['totalImpuesto'],2)),0,0,'L');
        $pdf->Cell(58,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,0,utf8_decode("$".number_format($unitario + $row['totalImpuesto'],2)),0,1,'L');

        $pdf->Ln(8);

        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(-3,0,utf8_decode(''),0,0,'L');
        $thisMonth=date_create($row['fechaCobro']);
        date_sub($thisMonth,date_interval_create_from_date_string("1 month"));
        $earlierMonth = date_format($thisMonth,"Y-m-d");
        $pdf->Cell(70,0,utf8_decode(strtoupper(strftime('%B', strtotime($earlierMonth)))),0,0,'L'); //MES ANTERIOR / ANTICIPO
        $pdf->Cell(48,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(65,0,utf8_decode(strtoupper(strftime('%B', strtotime($earlierMonth)))),0,0,'L'); //MES ANTERIOR / ANTICIPO
        $pdf->Cell(58,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,0,utf8_decode(strtoupper(strftime('%B', strtotime($earlierMonth)))),0,1,'L'); //MES ANTERIOR / ANTICIPO

        $pdf->Ln(3);

        $pdf->Cell(-3,0,utf8_decode(''),0,0,'L');
        if ($dataInfo->getBeforeSM('tbl_cargos', $row['codigoCliente'], $row['tipoServicio'], 0, $row['fechaFactura']) == "VACIA") {
            $ant = doubleval(0.00) + doubleval(0.00);
            $pdf->Cell(73,0,utf8_decode("$".number_format($ant,2)),0,0,'L');
        }else {
            $ant = $dataInfo->getBeforeSM('tbl_cargos', $row['codigoCliente'], $row['tipoServicio'], 0, $row['fechaFactura']);
            $pdf->Cell(73,0,utf8_decode("$".number_format($ant,2)),0,0,'L');
        }

        $pdf->Cell(45,6,utf8_decode(''),0,0,'L');
        if ($dataInfo->getBeforeSM('tbl_cargos', $row['codigoCliente'], $row['tipoServicio'], 0, $row['fechaFactura']) == "VACIA") {
            $ant = doubleval(0.00) + doubleval(0.00);
            $pdf->Cell(74,0,utf8_decode("$".number_format($ant,2)),0,0,'L');
        }else {
            $ant = $dataInfo->getBeforeSM('tbl_cargos', $row['codigoCliente'], $row['tipoServicio'], 0, $row['fechaFactura']);
            $pdf->Cell(74,0,utf8_decode("$".number_format($ant,2)),0,0,'L');
        }

        $pdf->Cell(49,0,utf8_decode(''),0,0,'L');
        if ($dataInfo->getBeforeSM('tbl_cargos', $row['codigoCliente'], $row['tipoServicio'], 0, $row['fechaFactura']) == "VACIA") {
            $ant = doubleval(0.00) + doubleval(0.00);
            $pdf->Cell(60,0,utf8_decode("$".number_format($ant,2)),0,1,'L');
        }else {
            $ant = $dataInfo->getBeforeSM('tbl_cargos', $row['codigoCliente'], $row['tipoServicio'], 0, $row['fechaFactura']);
            $pdf->Cell(60,0,utf8_decode("$".number_format($ant,2)),0,1,'L');
        }

        $pdf->Ln(15);

        $pdf->SetFont('Arial','B',8);
        $totalFactura = number_format($monto/*+doubleval($ant)*/,2);
        $pdf->Cell(-3,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,0,utf8_decode("$".$totalFactura),0,0,'L'); //MONTO TOTAL GRANDE
        $pdf->Cell(48,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(65,0,utf8_decode("$".$totalFactura),0,0,'L'); //MONTO TOTAL GRANDE
        $pdf->Cell(58,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,0,utf8_decode("$".$totalFactura),0,1,'L'); //MONTO TOTAL GRANDE
        /////////////////////MESES EN GRANDE TERMINA ACÁ
        ///CORTE 2 *******************************************************************************
        $pdf->Ln(-2);
    //////////////////////////////INICIO FRANJA 2 DONDE ESTAN LOS MESES ///////////////////////////////

        $pdf->SetFont('Arial','',7);

        //$pdf->Ln();
        if ($row['exento'] != "T") {
            $pdf->Cell(90,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".number_format($separado,2)),0,0,'L');
            $pdf->Cell(53,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(50,0,utf8_decode("$".number_format($separado,2)),0,0,'L');
            $pdf->Cell(68,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".number_format($separado,2)),0,1,'L');
            $pdf->Ln(4);
            $pdf->Cell(90,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".number_format($totalIva,2)),0,0,'L');
            $pdf->Cell(53,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(50,0,utf8_decode("$".number_format($totalIva,2)),0,0,'L');
            $pdf->Cell(68,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".number_format($totalIva,2)),0,1,'L');
            $pdf->Ln(4);
            $pdf->Cell(15,0,utf8_decode(''),0,0,'L');
            $numeroALetras = NumerosEnLetras::convertir(number_format(((doubleval($unitario) + $row['totalImpuesto'])),2), 'dólares', false, 'centavos');
            $pdf->Cell(60,0,utf8_decode($numeroALetras),0,0,'C');
            $pdf->Cell(15,0,utf8_decode(""),0,0,'L'); //IMPUESTO SEGURIDAD
            $pdf->Cell(70,0,utf8_decode("$".number_format($row['totalImpuesto'],2)),0,0,'L');
            $pdf->Cell(-20,0,utf8_decode(''),0,0,'L');
            //$numeroALetras = NumerosEnLetras::convertir(number_format($monto,2), 'dólares', false, 'centavos');
            $pdf->Cell(30,0,utf8_decode($numeroALetras),0,0,'C');
            $pdf->Cell(43,0,utf8_decode(""),0,0,'L'); //IMPUESTO SEGURIDAD
            $pdf->Cell(65,0,utf8_decode("$".number_format($row['totalImpuesto'],2)),0,0,'L');

            $pdf->Cell(20,0,utf8_decode($numeroALetras),0,0,'C');
            $pdf->Cell(33,0,utf8_decode(""),0,0,'L'); //IMPUESTO SEGURIDAD
            $pdf->Cell(70,0,utf8_decode("$".number_format($row['totalImpuesto'],2)),0,1,'L');
            $pdf->Ln(4);
            $pdf->Cell(90,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".number_format($separado,2)),0,0,'L');
            $pdf->Cell(53,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(60,0,utf8_decode("$".number_format($separado,2)),0,0,'L');
            $pdf->Cell(58,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".number_format($separado,2)),0,1,'L');

            $pdf->Ln(4);
            $pdf->Cell(90,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".'0.00'),0,0,'L');//IVA RETENIDO
            $pdf->Cell(53,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".'0.00'),0,0,'L');//IVA RETENIDO
            $pdf->Cell(48,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".'0.00'),0,1,'L');//IVA RETENIDO
            $pdf->Ln(4);
            $pdf->Cell(90,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".'0.00'),0,0,'L');//VENTAS NO SUJETAS
            $pdf->Cell(53,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".'0.00'),0,0,'L');//VENTAS NO SUJETAS
            $pdf->Cell(48,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".'0.00'),0,1,'L');//VENTAS NO SUJETAS
            $pdf->Ln(4);
            $pdf->Cell(90,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".'0.00'),0,0,'L');//VENTAS EXENTAS
            $pdf->Cell(53,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".'0.00'),0,0,'L');//VENTAS EXENTAS
            $pdf->Cell(48,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".'0.00'),0,1,'L');//VENTAS EXENTAS
            $pdf->Ln(4);
            $pdf->Cell(90,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".number_format(doubleval($unitario) + doubleval($row['totalImpuesto']),2)),0,0,'L');
            $pdf->Cell(53,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".number_format(doubleval($unitario) + doubleval($row['totalImpuesto']),2)),0,0,'L');
            $pdf->Cell(48,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".number_format(doubleval($unitario) + doubleval($row['totalImpuesto']),2)),0,1,'L');

            //COBRADOR
            $pdf->Cell(60,6,utf8_decode(""),0,0,'L');
            $pdf->Cell(40,6,utf8_decode(''/*$dataInfo->getCobrador('tbl_cobradores',$row['codigoCobrador'])*/),0,0,'L');
            $pdf->Cell(80,6,utf8_decode(""),0,0,'L');
            $pdf->Cell(40,6,utf8_decode(''/*$dataInfo->getCobrador('tbl_cobradores',$row['codigoCobrador'])*/),0,1,'L');

            $pdf->Ln(10);
            $pdf->SetFont('Arial','',7);
            //$pdf->MultiCell(50,3,utf8_decode($mensaje),0,'C',0);
            $pdf->Cell(-3.5,1,utf8_decode(""),0,0,'L');
            $pdf->Cell(-2,1,utf8_decode(""),0,0,'L');
            $pdf->Cell(20,1,utf8_decode(date_format(date_create($row['fechaVencimiento']), 'd/m/Y')),0,0,'C');
            //$pdf->MultiCell(80,3,utf8_decode($mensaje),0,'C',0);

            $pdf->Cell(100,1,utf8_decode(""),0,0,'L');
            $pdf->Cell(20,1,utf8_decode(date_format(date_create($row['fechaVencimiento']), 'd/m/Y')),0,0,'C');
            //$pdf->MultiCell(80,3,utf8_decode($mensaje),0,'C',0);

            $pdf->Cell(100,1,utf8_decode(""),0,0,'L');
            $pdf->Cell(20,1,utf8_decode(date_format(date_create($row['fechaVencimiento']), 'd/m/Y')),0,1,'C');
            //CORTE 3****************************************************************************************
            $pdf->SetAutoPageBreak(false);
            $pdf->Ln(20);
            $pdf->Cell(305,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode($row['numeroFactura']),0,1,'L');
            $pdf->Ln(16);
            $pdf->SetAutoPageBreak(false);
            $pdf->Cell(140,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode($row['codigoCliente']),0,1,'L');
            $pdf->Cell(270,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode(date_format(date_create($row['fechaFactura']), 'd/m/Y')),0,0,'L');
            $pdf->Ln(5);
            $pdf->Cell(140,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode($row['nombre']),0,0,'L');
            $pdf->Cell(60,0,utf8_decode(''),0,0,'L');
            if ($row['tipoServicio'] == "C") {
                $pdf->Cell(70,0,utf8_decode('CABLE'),0,0,'L');
            }else {
                $pdf->Cell(70,0,utf8_decode('INTERNET'),0,0,'L');
            }
            $pdf->Ln(5);
            $pdf->Cell(140,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode($row['direccion']),0,0,'L');
            $pdf->Cell(80,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".$totalFactura),0,0,'L');
            $pdf->Ln(5);
            $pdf->Cell(140,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode($municipio),0,0,'L');
            $pdf->Cell(65,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode(date_format(date_create($row['fechaVencimiento']), 'd/m/Y')),0,0,'L');
        }
        else {
            $pdf->Cell(90,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".number_format($unitario,2)),0,0,'L');
            $pdf->Cell(55,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".number_format($unitario,2)),0,1,'L');
            $pdf->Ln(-2);
            $pdf->Cell(90,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".'0.00'.'hola'),0,0,'L');
            $pdf->Cell(55,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".'0.00'),0,1,'L');
            $pdf->Ln(-2);
            $pdf->Cell(45,6,utf8_decode(''),0,0,'L');
            $numeroALetras = NumerosEnLetras::convertir(number_format(doubleval($unitario) + doubleval($row['totalImpuesto']),2), 'dólares', false, 'centavos');
            $pdf->Cell(45,6,utf8_decode($numeroALetras),0,0,'C');
            $pdf->Cell(20,6,utf8_decode(""),0,0,'L'); //IMPUESTO SEGURIDAD
            $pdf->Cell(70,6,utf8_decode("$".number_format($row['totalImpuesto'],2)),0,0,'L');

            $pdf->Cell(-5,6,utf8_decode(''),0,0,'L');
            //$numeroALetras = NumerosEnLetras::convertir(number_format($monto,2), 'dólares', false, 'centavos');
            $pdf->Cell(40,6,utf8_decode($numeroALetras),0,0,'C');
            $pdf->Cell(20,6,utf8_decode(""),0,0,'L'); //IMPUESTO SEGURIDAD
            $pdf->Cell(70,6,utf8_decode("$".number_format($row['totalImpuesto'],2)),0,1,'L');

            $pdf->Ln(-2);
            $pdf->Cell(90,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".'0.00'),0,0,'L');
            $pdf->Cell(55,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".'0.00'),0,1,'L');
            $pdf->Ln(-2);
            $pdf->Cell(90,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".number_format(doubleval($unitario) + doubleval($row['totalImpuesto']),2)),0,0,'L');
            $pdf->Cell(55,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".number_format(doubleval($unitario) + doubleval($row['totalImpuesto']),2)),0,1,'L');

            //COBRADOR
            $pdf->Cell(60,6,utf8_decode(""),0,0,'L');
            $pdf->Cell(40,6,utf8_decode($dataInfo->getCobrador('tbl_cobradores',$row['codigoCobrador'])),0,0,'L');
            $pdf->Cell(85,6,utf8_decode(""),0,0,'L');
            $pdf->Cell(40,6,utf8_decode($dataInfo->getCobrador('tbl_cobradores',$row['codigoCobrador'])),0,1,'L');

            $pdf->Ln(10);
            $pdf->Cell(25,1,utf8_decode(""),0,0,'L');
            $pdf->Cell(20,1,utf8_decode("VENCIMIENTO: ".date_format(date_create($row['fechaVencimiento']), 'd/m/Y')),0,0,'C');

            $pdf->MultiCell(80,3,utf8_decode($mensaje),0,'C',0);

            $pdf->Cell(140,1,utf8_decode(""),0,0,'L');
            $pdf->Cell(20,1,utf8_decode("VENCIMIENTO: ".date_format(date_create($row['fechaVencimiento']), 'd/m/Y')),0,0,'C');

            $pdf->MultiCell(80,3,utf8_decode($mensaje),0,'C',0);

           

        }

      }

    /* close connection */
    mysqli_close($mysqli);
    $pdf->Output();
}
?>
