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
      //$pdf = new FPDF('L','mm',array(215,370));
      $pdf = new FPDF('L','mm','Letter');
      //$pdf = new FPDF('L','mm','A4');
      #Establecemos los márgenes arriba:
      $pdf->SetTopMargin(0.5);
      #Establecemos los márgenes izquierda:
      $pdf->SetLeftMargin(10.5);
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
        $query = "SELECT coordenadas FROM clientes WHERE cod_cliente=".$row['codigoCliente'];
        // Preparación de sentencia
        $statement = $mysqli->query($query);
        //$statement->execute();
        while ($result = $statement->fetch_assoc()) {
            $coordenadas = $result['coordenadas'];
        }

        $pdf->AliasNbPages();
        $pdf->AddPage();
        //$pdf->Image('../../../images/contrato/factu-nueva.jpg',-0.5,-1.5,281, 217);
        $pdf->Image('../../../images/comp.png',175,58, 45, 10);//120
        if ($row["anulada"] == 1){
            //$pdf->Image('../../../images/anulada.png',155,120);
            $pdf->Image('../../../images/anulada.png',135,70);
            $pdf->Image('../../../images/anulada.png',20,70);
        }
        if ($row['tipoServicio'] == "C") {
            $pdf->Image('../../../images/cable.png',55,73, 15, 17);//100
            $pdf->Image('../../../images/cable.png',190,73, 15, 17);//100
            $pdf->Image('../../../images/cable.png',187,183, 15, 13);//100
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
        }
        elseif ($row['tipoServicio'] == "I") {
            $pdf->Image('../../../images/inter.png',55,73, 15, 17);//100
            $pdf->Image('../../../images/inter.png',190,73, 15, 17);//100
            $pdf->Image('../../../images/inter.png',187,183, 15, 13);//100
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
        }
        if (strlen($row['direccion']) > 180) {
            $direccion = substr($row['direccion'], 0, 180);
        }else {
           $direccion = $row['direccion'];
        }
    ///////////////////////////////////////////////////////////////////////////////////////////
        $pdf->Ln(17);
        $pdf->Cell(95,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(80,6,utf8_decode(strtoupper($row['numeroFactura'])),0,0,'L');
        $pdf->Cell(57,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,6,utf8_decode(strtoupper($row['numeroFactura'])),0,1,'L');
        //$pdf->Cell(95,6,utf8_decode(''),0,0,'L');
        //$pdf->Cell(70,6,utf8_decode(strtoupper($row['numeroFactura'])),0,1,'L');//70,-5

        //DATOS DEL CLIENTE
        $pdf->Ln(5.5);//29.5
        $pdf->Cell(10,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(85,6,utf8_decode($row['codigoCliente']),0,0,'L');
        $pdf->Cell(70,6,utf8_decode(strftime('%d', strtotime($row['fechaFactura']))." de ".strftime('%B', strtotime($row['fechaFactura'])). " de ".strftime('%G', strtotime($row['fechaFactura']))),0,0,'L');

        //DUPLICADO 1
        $pdf->Cell(-17,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,6,utf8_decode($row['codigoCliente']),0,0,'L');
        $pdf->Cell(14,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,6,utf8_decode(strftime('%d', strtotime($row['fechaFactura']))." de ".strftime('%B', strtotime($row['fechaFactura'])). " de ".strftime('%G', strtotime($row['fechaFactura']))),0,0,'L');
        $pdf->Cell(5,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,15,utf8_decode(''),0,1,'L');
        //$pdf->Cell(70,15,utf8_decode(strftime('%d', strtotime($row['fechaFactura']))." de ".strftime('%B', strtotime($row['fechaFactura'])). " de ".strftime('%G', strtotime($row['fechaFactura']))),0,1,'L');
        $pdf->Ln(-11);
        $pdf->Cell(12,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,6,utf8_decode($row['nombre']),0,0,'L');
        $pdf->Cell(68,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,6,utf8_decode($row['nombre']),0,1,'L');
        $pdf->Ln(-1.5);

        $pdf->Cell(15,6,utf8_decode(''),0,0,'L');
        $current_y = $pdf->GetY();
        $current_x = $pdf->GetX();
        $cell_width = 100;
        $pdf->MultiCell(100,3,utf8_decode($direccion),0,'J');
        $pdf->SetXY($current_x + $cell_width, $current_y);
        //$pdf->Cell(42,6,utf8_decode($direccion),0,0,'L');
        $pdf->Cell(37,6,utf8_decode(''),0,0,'L');
        //$pdf->Cell(70,6,utf8_decode($direccion),0,1,'L');
        $current_y = $pdf->GetY();
        $current_x = $pdf->GetX();
        $cell_width = 100;
        $pdf->MultiCell(100,3,utf8_decode($direccion),0,'J');
        $pdf->SetXY($current_x + $cell_width, $current_y);
        $pdf->Cell(5,6,utf8_decode(''),0,1,'L');
        $pdf->Ln(-11);
        $pdf->Cell(265,6,utf8_decode(''),0,0,'L');
        //COD CLIENTE 3RA COLUMNA
        $pdf->Cell(70,12,utf8_decode(''),0,1,'L');
        $pdf->Ln(14);
        $pdf->Cell(15,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,-20,utf8_decode($municipio),0,0,'L');
        $pdf->Cell(67,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,-20,utf8_decode($municipio),0,0,'L');
        $pdf->Cell(45,6,utf8_decode(''),0,0,'L');

        $pdf->Cell(70,-20,utf8_decode(''),0,1,'L');
        $pdf->Ln(10);
        //TELEFONO
        $pdf->Cell(60,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(110,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,20,utf8_decode(''),0,1,'L');
        $pdf->Ln(4.5);

    //////////////////////////////FIN FRANJA 1///////////////////////////////////
        $pdf->Cell(23,6,utf8_decode('1'),0,0,'R');
        $pdf->Cell(13,6,utf8_decode(''),0,0,'R');

        $pdf->Cell(39,6,utf8_decode("Pendiente ".strftime('%B', strtotime($row['fechaCobro'])). " de ".strftime('%Y', strtotime($row['fechaCobro']))),0,0,'L');

        if ($row['exento'] != "T") {
            $pdf->Cell(36,6,utf8_decode("$".$unitario),0,0,'L');
            $pdf->Cell(87,6,utf8_decode("$".number_format($unitario,2)),0,0,'L');
        }
        else {
            $pdf->Cell(36,6,utf8_decode("$".$unitario),0,0,'L');
            $pdf->Cell(87,6,utf8_decode("$".number_format($unitario,2)),0,0,'L');
        }

        $pdf->Cell(-37,6,utf8_decode('1'),0,0,'R');
        $pdf->Cell(13,6,utf8_decode(''),0,0,'R');
        $pdf->Cell(38,6,utf8_decode("Pendiente ".strftime('%B', strtotime($row['fechaCobro'])). " de ".strftime('%Y', strtotime($row['fechaCobro']))),0,0,'L');
       
        if ($row['exento'] != "T") {
            $pdf->Cell(36,6,utf8_decode("$".$unitario),0,0,'L');
            $pdf->Cell(87,6,utf8_decode("$".number_format($unitario,2)),0,1,'L');
        }
        else {
            $pdf->Cell(36,6,utf8_decode("$".$unitario),0,0,'L');
            $pdf->Cell(87,6,utf8_decode("$".number_format($unitario,2)),0,1,'L');
        }
         /////////// coordenadas en primer factura
        $pdf->Ln(5);
        $pdf->Cell(161,6,utf8_decode('*'),0,0,'R');
        $pdf->Cell(6,6,utf8_decode(''),0,0,'R');
        $pdf->Cell(38,6,utf8_decode("Coordenadas ".$coordenadas),0,0,'L');
        ///////////
        $pdf->Cell(260,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,-30,utf8_decode(''),0,1,'L');
        $pdf->Ln(5);

    //////////////////////////////INICIO FRANJA 2 ///////////////////////////////
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(2,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,6,utf8_decode(strtoupper(strftime('%B', strtotime($row['fechaCobro'])))),0,0,'L');
        $pdf->Cell(67,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,6,utf8_decode(strtoupper(strftime('%B', strtotime($row['fechaCobro'])))),0,1,'L');

        //var_dump($monto, $row['codigoCliente']);
        $pdf->Ln(3);
        $pdf->Cell(2,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,6,utf8_decode("$".number_format($unitario + $row['totalImpuesto'],2)),0,0,'L');
        $pdf->Cell(67,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,6,utf8_decode("$".number_format($unitario + $row['totalImpuesto'],2)),0,1,'L');
        $pdf->Cell(285,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,-20,utf8_decode(''),0,1,'L');

        $pdf->Ln(24);
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(2,6,utf8_decode(''),0,0,'L');
        $thisMonth=date_create($row['fechaCobro']);
        date_sub($thisMonth,date_interval_create_from_date_string("1 month"));
        $earlierMonth = date_format($thisMonth,"Y-m-d");
        $pdf->Cell(70,6,utf8_decode(strtoupper(strftime('%B', strtotime($earlierMonth)))),0,0,'L'); //MES ANTERIOR / ANTICIPO
        $pdf->Cell(67,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,6,utf8_decode(strtoupper(strftime('%B', strtotime($earlierMonth)))),0,1,'L'); //MES ANTERIOR / ANTICIPO
        $pdf->Ln(3);
        $pdf->Cell(2,6,utf8_decode(''),0,0,'L');
        if ($dataInfo->getBeforeSM('tbl_cargos', $row['codigoCliente'], $row['tipoServicio'], 0, $row['fechaFactura']) == "VACIA") {
            $ant = doubleval(0.00) + doubleval(0.00);
            $pdf->Cell(70,6,utf8_decode("$".number_format($ant,2)),0,0,'L');
        }else {
            $ant = $dataInfo->getBeforeSM('tbl_cargos', $row['codigoCliente'], $row['tipoServicio'], 0, $row['fechaFactura']);
            $pdf->Cell(70,6,utf8_decode("$".number_format($ant,2)),0,0,'L');
        }

        $pdf->Cell(67,6,utf8_decode(''),0,0,'L');
        if ($dataInfo->getBeforeSM('tbl_cargos', $row['codigoCliente'], $row['tipoServicio'], 0, $row['fechaFactura']) == "VACIA") {
            $ant = doubleval(0.00) + doubleval(0.00);
            $pdf->Cell(60,6,utf8_decode("$".number_format($ant,2)),0,1,'L');
        }else {
            $ant = $dataInfo->getBeforeSM('tbl_cargos', $row['codigoCliente'], $row['tipoServicio'], 0, $row['fechaFactura']);
            $pdf->Cell(60,6,utf8_decode("$".number_format($ant,2)),0,1,'L');
        }
////////////////////////////////////
        //por aqui voy
///////////////////////////////////
        ////lado que se elimina
        $pdf->SetFont('Arial','B',10);
        $totalFactura = number_format((doubleval($unitario) + doubleval($row['totalImpuesto'])+doubleval($ant)),2);//(doubleval($unitario) + doubleval($row['totalImpuesto']) + doubleval($ant)),2); // ACA SE CALCULA MONTO TOTAL
        $pdf->Cell(285,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,-45,utf8_decode(''),0,1,'L'); // MONTO TOTAL QUE APARECE EN COLUMNA 3
        $pdf->Cell(285,6,utf8_decode(''),0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(70,63,utf8_decode(''),0,1,'L');
        //$pdf->Ln(55);
        ////lado que se elimina//////
        $pdf->SetFont('Arial','B',10);
        $pdf->Ln(-7.5);
        $pdf->Cell(1,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,6,utf8_decode("$".$totalFactura),0,0,'L'); //MONTO TOTAL GRANDE
        $pdf->Cell(67,6,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,6,utf8_decode("$$".$totalFactura),0,1,'L'); //MONTO TOTAL GRANDE
        $pdf->SetFont('Arial','',7);

        //$pdf->Ln();
        if ($row['exento'] != "T") {
            $pdf->Ln(-20);
            $pdf->Cell(110,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".number_format($unitario,2)),0,0,'L');
            $pdf->Cell(68,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".number_format($unitario,2)),0,1,'L');
            $pdf->Ln(-2);
            $pdf->Cell(110,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".'0.00'),0,0,'L');
            $pdf->Cell(68,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".'0.00'),0,1,'L');
            $pdf->Ln(-0);
            $pdf->Cell(16,6,utf8_decode(''),0,0,'L');
            $numeroALetras = NumerosEnLetras::convertir(number_format((doubleval($unitario) + doubleval($row['totalImpuesto'])),2), 'dólares', false, 'centavos');
            $current_y = $pdf->GetY();
            $current_x = $pdf->GetX();
            $cell_width = 45;
            //$pdf->Cell(45,6,utf8_decode($numeroALetras),0,0,'C');
            $pdf->MultiCell(45,3,utf8_decode($numeroALetras),0,'C');
            $pdf->SetXY($current_x + $cell_width, $current_y);
            //$pdf->Cell(44,6,utf8_decode(""),0,0,'L'); //IMPUESTO SEGURIDAD
            //$pdf->Cell(70,6,utf8_decode("$".number_format($row['totalImpuesto'],2)),0,0,'L');
            $pdf->Cell(93,6,utf8_decode(''),0,0,'L');
            //$numeroALetras = NumerosEnLetras::convertir(number_format($monto,2), 'dólares', false, 'centavos');
            $current_y = $pdf->GetY();
            $current_x = $pdf->GetX();
            $cell_width = 45;
            //$pdf->Cell(45,6,utf8_decode($numeroALetras),0,0,'C');
            $pdf->MultiCell(45,3,utf8_decode($numeroALetras),0,'C');
            $pdf->SetXY($current_x + $cell_width, $current_y);
            //$pdf->Cell(40,6,utf8_decode(""),0,0,'L'); //IMPUESTO SEGURIDAD
            //$pdf->Cell(70,6,utf8_decode("$".number_format($row['totalImpuesto'],2)),0,1,'L');
            $pdf->Ln(-1);
            $pdf->Cell(110,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".'0.00'),0,0,'L');
            $pdf->Cell(68,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".'0.00'),0,1,'L');
            $pdf->Ln(-2);
            $pdf->Cell(110,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".number_format(doubleval($unitario) + doubleval($row['totalImpuesto']),2)),0,0,'L');
            $pdf->Cell(68,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".number_format(doubleval($unitario) + doubleval($row['totalImpuesto']),2)),0,1,'L');

            //COBRADOR
            $pdf->Ln(3);
            $pdf->Cell(38,6,utf8_decode(""),0,0,'L');
            $pdf->Cell(40,6,utf8_decode($dataInfo->getCobrador('tbl_cobradores',$row['codigoCobrador'])),0,0,'L');
            $pdf->Cell(97,6,utf8_decode(""),0,0,'L');
            $pdf->Cell(40,6,utf8_decode($dataInfo->getCobrador('tbl_cobradores',$row['codigoCobrador'])),0,1,'L');

            $pdf->Ln(-1.5);
            $pdf->Cell(-3,1,utf8_decode(""),0,0,'L');
            $pdf->Cell(20,1,utf8_decode("".date_format(date_create($row['fechaVencimiento']), 'd/m/Y')),0,0,'C');
            $pdf->Ln(14);
            $pdf->Cell(18,1,utf8_decode(""),0,0,'L');
            $pdf->MultiCell(80,3,utf8_decode($mensaje),0,'C',0);
            $pdf->Ln(-20);
            $pdf->Cell(135,1,utf8_decode(""),0,0,'L');
            $pdf->Cell(20,1,utf8_decode("".date_format(date_create($row['fechaVencimiento']), 'd/m/Y')),0,0,'C');
            $pdf->Ln(14);
            $pdf->Cell(160,1,utf8_decode(""),0,0,'L');
            $pdf->MultiCell(80,3,utf8_decode($mensaje),0,'C',0);
        }
        else {
            $pdf->Ln(-20);
            $pdf->Cell(110,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".number_format($unitario,2)),0,0,'L');
            $pdf->Cell(68,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".number_format($unitario,2)),0,1,'L');
            $pdf->Ln(-2);
            $pdf->Cell(110,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".'0.00'),0,0,'L');
            $pdf->Cell(68,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".'0.00'),0,1,'L');
            $pdf->Ln(-2);
            $pdf->Cell(16,6,utf8_decode(''),0,0,'L');
            $numeroALetras = NumerosEnLetras::convertir(number_format((doubleval($unitario) + doubleval($row['totalImpuesto'])),2), 'dólares', false, 'centavos');
            $pdf->Cell(45,6,utf8_decode($numeroALetras),0,0,'C');
            //$pdf->Cell(20,6,utf8_decode(""),0,0,'L'); //IMPUESTO SEGURIDAD
            //$pdf->Cell(70,6,utf8_decode("$".number_format($row['totalImpuesto'],2)),0,0,'L');

            $pdf->Cell(95,6,utf8_decode(''),0,0,'L');
            //$numeroALetras = NumerosEnLetras::convertir(number_format($monto,2), 'dólares', false, 'centavos');
            $pdf->Cell(40,6,utf8_decode($numeroALetras),0,0,'C');
            //$pdf->Cell(20,6,utf8_decode(""),0,0,'L'); //IMPUESTO SEGURIDAD
            //$pdf->Cell(70,6,utf8_decode("$".number_format($row['totalImpuesto'],2)),0,1,'L');

            $pdf->Ln(0.5);
            $pdf->Cell(110,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".'0.00'),0,0,'L');
            $pdf->Cell(68,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".'0.00'),0,1,'L');
            $pdf->Ln(-2);
            $pdf->Cell(110,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".number_format(doubleval($unitario) + doubleval($row['totalImpuesto']),2)),0,0,'L');
            $pdf->Cell(68,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".number_format(doubleval($unitario) + doubleval($row['totalImpuesto']),2)),0,1,'L');

            //COBRADOR
            $pdf->Ln(3);
            $pdf->Cell(38,6,utf8_decode(""),0,0,'L');
            $pdf->Cell(40,6,utf8_decode($dataInfo->getCobrador('tbl_cobradores',$row['codigoCobrador'])),0,0,'L');
            $pdf->Cell(97,6,utf8_decode(""),0,0,'L');
            $pdf->Cell(40,6,utf8_decode($dataInfo->getCobrador('tbl_cobradores',$row['codigoCobrador'])),0,1,'L');

            $pdf->Ln(-0.5);
            $pdf->Cell(-3,1,utf8_decode(""),0,0,'L');
            $pdf->Cell(20,1,utf8_decode("".date_format(date_create($row['fechaVencimiento']), 'd/m/Y')),0,0,'C');
            $pdf->Ln(14);
            $pdf->Cell(18,1,utf8_decode(""),0,0,'L');
            $pdf->MultiCell(80,3,utf8_decode($mensaje),0,'C',0);
            $pdf->Ln(-20);
            $pdf->Cell(135,1,utf8_decode(""),0,0,'L');
            $pdf->Cell(20,1,utf8_decode("".date_format(date_create($row['fechaVencimiento']), 'd/m/Y')),0,0,'C');
            $pdf->Ln(14);
            $pdf->Cell(160,1,utf8_decode(""),0,0,'L');
            $pdf->MultiCell(80,3,utf8_decode($mensaje),0,'C',0);

        }
        $pdf->Ln(17.5);
        $pdf->Cell(231,1,utf8_decode(""),0,0,'L');
        $pdf->Cell(70,6,utf8_decode(strtoupper($row['numeroFactura'])),0,1,'L');//70,-5
        $pdf->Ln(-1);
        $pdf->Cell(155,1,utf8_decode(""),0,0,'L');
        $pdf->Cell(70,15,utf8_decode(strftime('%d', strtotime($row['fechaFactura']))." de ".strftime('%B', strtotime($row['fechaFactura'])). " de ".strftime('%G', strtotime($row['fechaFactura']))),0,1,'L');
        $pdf->Ln(-10);
        $pdf->Cell(150,1,utf8_decode(""),0,0,'L');
        $pdf->Cell(70,12,utf8_decode($row['codigoCliente']),0,1,'L');
        $pdf->Ln(7);
        $pdf->Cell(150,1,utf8_decode(""),0,0,'L');
        $pdf->Cell(70,-20,utf8_decode($row['nombre']),0,1,'L');
        $pdf->Ln(9);
        $pdf->Cell(150,1,utf8_decode(""),0,0,'L');
        
        $pdf->Ln(5);
        $pdf->Cell(150,1,utf8_decode(""),0,0,'L');
        $current_y = $pdf->GetY();
        $current_x = $pdf->GetX();
        $cell_width = 100;
        $pdf->MultiCell(100,3,utf8_decode($direccion),0,'J');
        $pdf->SetXY($current_x + $cell_width, $current_y);
        //$pdf->Cell(70,20,utf8_decode($direccion),0,1,'L');
        $pdf->Cell(5,1,utf8_decode(""),0,1,'L');
        $pdf->Ln(7);
        $pdf->Cell(150,6,utf8_decode(""),0,0,'L');
        $pdf->Cell(70,6,utf8_decode($municipio),0,1,'L');
        
        $pdf->SetFont('Arial','B',12);
        $pdf->Ln(10);
        //$totalFactura = number_format((doubleval($unitario) + doubleval($row['totalImpuesto'])+doubleval($ant)),2);//(doubleval($unitario) + doubleval($row['totalImpuesto']) + doubleval($ant)),2); // ACA SE CALCULA MONTO TOTAL
        $pdf->Cell(175,-15,utf8_decode(''),0,0,'L');

        $pdf->Cell(70,-8,utf8_decode(strtoupper("Hasta: ".strftime('%B', strtotime($row['fechaCobro']))).'  $'.utf8_decode($totalFactura)),0,1,'L');
        $pdf->SetFont('Arial','B',8);
        $pdf->SetAutoPageBreak(false);
        $pdf->SetXY(175, 202);
        $pdf->Cell(50,3,utf8_decode(date_format(date_create($row['fechaVencimiento']), 'd/m/Y')),0,1,'L');

      }

    /* close connection */
    mysqli_close($mysqli);
    $pdf->Output();
}
// CREDITO FISCAL
elseif ($tipoComprobante == 1) {
    //INICIO IMPRESIÓN DE FACTURACIÓN NORMAL
    //*******************************FACTURA CRÉDITO FISCAL********************************
      $pdf = new FPDF('L','mm',array(217,356));
      //$pdf = new FPDF();
      #Establecemos los márgenes arriba:
      $pdf->SetTopMargin(9);
      #Establecemos los márgenes izquierda:
      $pdf->SetLeftMargin(8);

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
        $query = "SELECT id_departamento, numero_nit, num_registro, telefonos, nombre_comercial, giro FROM clientes WHERE cod_cliente =".$row['codigoCliente'];
        // Preparación de sentencia
        $statement = $mysqli->query($query);
        //$statement->execute();
        while ($result = $statement->fetch_assoc()) {
            $idDepartamento = $result['id_departamento'];
            $nNit = $result['numero_nit'];
            $nRegistro = $result['num_registro'];
            $telefonos = $result['telefonos'];
            $nombre_comercial = $result['nombre_comercial'];
            $giro = $result['giro'];
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
        
        //$pdf->Image('../../../images/contrato/factu-nueva2.jpg',1.5,-2.1,355, 216);
        $pdf->Image('../../../images/comp.png',150,143, 45, 10);

          if ($row["anulada"] == 1){
              //$pdf->Image('../../../images/anulada.png',155,120);
              $pdf->Image('../../../images/anulada.png',135,70);
              $pdf->Image('../../../images/anulada.png',20,70);
          }
        if ($row['tipoServicio'] == "C") {
            $pdf->Image('../../../images/cable.png',40,95, 15, 16);
            $pdf->Image('../../../images/cable.png',160,95, 15, 16);
            $pdf->Image('../../../images/cable.png',285,95, 15, 16);
            $unitario = $row['cuotaCable'];
            $separado = (floatval($unitario)/(1 + floatval($iva)));
            $totalIva = floatval($separado) * floatval($iva);
            $totalIva = round($totalIva,2);
            $retenIva =  floatval($separado) * 0.01;
            $retenIva = round($retenIva,2);

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

            if (strlen($row['direccion']) > 60) {
                $direccion = substr($row['direccion'], 0, 60);
            }else {
                $direccion = $row['direccion'];
            }
        }
        elseif ($row['tipoServicio'] == "I") {
            $pdf->Image('../../../images/inter.png',40,95, 15, 16);
            $pdf->Image('../../../images/inter.png',160,95, 15, 16);
            $pdf->Image('../../../images/inter.png',285,95, 15, 16);
            $unitario = $row['cuotaInternet'];
            $separado = (floatval($unitario)/(1 + floatval($iva)));
            $totalIva = floatval($separado) * floatval($iva);
            $totalIva = round($totalIva,2);
            $retenIva =  number_format((floatval($separado) * 0.01),2);
            // no usar
            //$retenIva = round($retenIva,2);
            //$retenIva =floatval(0);
            // no usar
            $monto = $dataInfo->getTotalCobrarInterImp('tbl_cargos', $row['codigoCliente'], 'pendiente', 0, $row['fechaCobro'], 'i');
            $montoSinImpuestos = $dataInfo->getTotalCobrarInterImp('tbl_cargos', $row['codigoCliente'], 'pendiente', 0, $row['fechaCobro'], 's');
            $montoSoloImpuestos = $dataInfo->getTotalCobrarInterImp('tbl_cargos', $row['codigoCliente'], 'pendiente', 0, $row['fechaCobro'], 'si');
            $cantidadMeses = $dataInfo->getDeudaUnitariaI('tbl_cargos', $row['codigoCliente'], 'pendiente', 0, $row['fechaCobro']);
            if ($monto <= 0) {
                $mensaje = 'EL RECIBO DEL PRESENTE MES YA HA SIDO CANCELADO.';
            }else {
                $mensaje = 'CANCELE SU SALDO PENDIENTE ANTES DEL VENCIMIENTO, PARA EVITAR SUSPENSIÓN DE SERVICIOS.';
            }
        }
        if (strlen($row['direccion']) > 60) {
            $direccion = substr($row['direccion'], 0, 60);
        }else {
            $direccion = $row['direccion'];
        }
    ///////////////////////////////////////////////////////////////////////////////////////////
        //$pdf->Ln(5);
        $pdf->Ln(4);///// cambio aqui
        $pdf->Cell(70,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(50,0,utf8_decode(strtoupper($row['numeroFactura'])),0,0,'L');
        $pdf->Cell(70,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(40,0,utf8_decode(strtoupper($row['numeroFactura'])),0,0,'L');
        $pdf->Cell(80,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(30,0,utf8_decode(strtoupper($row['numeroFactura'])),0,1,'L');
        //DATOS DEL CLIENTE
        $pdf->Ln(25.5);
        $pdf->SetFont('Arial','',6);
        $pdf->Cell(11,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(72.5,0,utf8_decode($row['codigoCliente']),0,0,'L');
        $pdf->Cell(29,0,utf8_decode(strftime('%d', strtotime($row['fechaFactura']))." de ".strftime('%B', strtotime($row['fechaFactura'])). " de ".strftime('%G', strtotime($row['fechaFactura']))),0,0,'L');
        //DUPLICADO1
        $pdf->Cell(17,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(72,0,utf8_decode($row['codigoCliente']),0,0,'L');
        $pdf->Cell(34,0,utf8_decode(strftime('%d', strtotime($row['fechaFactura']))." de ".strftime('%B', strtotime($row['fechaFactura'])). " de ".strftime('%G', strtotime($row['fechaFactura']))),0,0,'L');
        //DUPLICADO2
        $pdf->Cell(12,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(72,0,utf8_decode($row['codigoCliente']),0,0,'L');
        $pdf->Cell(30,0,utf8_decode(strftime('%d', strtotime($row['fechaFactura']))." de ".strftime('%B', strtotime($row['fechaFactura'])). " de ".strftime('%G', strtotime($row['fechaFactura']))),0,1,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4);
        //NOMBRE DE CLIENTE

        $pdf->Cell(12,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(60,0,utf8_decode($row['nombre']),0,0,'L');
        //DUPLICADO1
        $pdf->Cell(59,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(55,0,utf8_decode($row['nombre']),0,0,'L');
        //DUPLICADO2
        $pdf->Cell(63,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(55,0,utf8_decode($row['nombre']),0,1,'L');
        $pdf->Ln(4.5);
        //DIRECCIÓN

        $pdf->Cell(15,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(60,0,utf8_decode($direccion),0,0,'L');
        //DUPLICADO1
        $pdf->Cell(59,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(55,0,utf8_decode($direccion),0,0,'L');
        //DUPLICADO2
        $pdf->Cell(63,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(55,0,utf8_decode($direccion),0,1,'L');
        $pdf->Ln(4.5);
///
        //DEPTO - MUNICIPIO
        $pdf->Cell(11,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(63,0,utf8_decode($departamento),0,0,'L');
        $pdf->Cell(30,0,utf8_decode($municipio),0,0,'L');
        //DUPLICADO1
        $pdf->Cell(25,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(63,0,utf8_decode($departamento),0,0,'L');
        $pdf->Cell(30,0,utf8_decode($municipio),0,0,'L');
        //DUPLICADO2
        $pdf->Cell(26,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(63,0,utf8_decode($departamento),0,0,'L');
        $pdf->Cell(30,0,utf8_decode($municipio),0,1,'L');

        $pdf->Ln(4);

        //NIT - TELEFONO
        $pdf->Cell(7,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(59,0,utf8_decode($nNit),0,0,'L');
        $pdf->Cell(30,0,utf8_decode($telefonos),0,0,'L');
        //DUPLICADO1
        $pdf->Cell(29,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(60,0,utf8_decode($nNit),0,0,'L');
        $pdf->Cell(30,0,utf8_decode($telefonos),0,0,'L');
        //DUPLICADO2
        $pdf->Cell(28,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(61,0,utf8_decode($nNit),0,0,'L');
        $pdf->Cell(30,0,utf8_decode($telefonos),0,1,'L');

        $pdf->Ln(3.5);

        //NRC - GIRO
        $pdf->Cell(14,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(38,0,utf8_decode($nRegistro),0,0,'L');
        $pdf->Cell(53,0,utf8_decode($giro),0,0,'L');
        //DUPLICADO1
        $pdf->Cell(29,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(36,0,utf8_decode($nRegistro),0,0,'L');
        $pdf->Cell(30,0,utf8_decode($giro),0,0,'L');
        //DUPLICADO2
        $pdf->Cell(52,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(36,0,utf8_decode($nRegistro),0,0,'L');
        $pdf->Cell(30,0,utf8_decode($giro),0,1,'L');

        $pdf->Ln(4);

        //NOMBRE COMERCIAL
        $pdf->Cell(27,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(60,0,utf8_decode($nombre_comercial),0,0,'L');
        $pdf->Cell(30,0,utf8_decode(''),0,0,'L');
        //DUPLICADO1
        $pdf->Cell(29,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(55,0,utf8_decode($nombre_comercial),0,0,'L');
        $pdf->Cell(30,0,utf8_decode(''),0,0,'L');
        //DUPLICADO2
        $pdf->Cell(33,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(55,0,utf8_decode($nombre_comercial),0,0,'L');
        $pdf->Cell(30,0,utf8_decode(''),0,1,'L');

        $pdf->Ln(14.5);
    //////////////////////////////FIN FRANJA 1///////////////////////////////////
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(9,0,utf8_decode(''),0,0,'L');
    $pdf->Cell(10,0,utf8_decode('1'),0,0,'R');
    $pdf->Cell(3,0,utf8_decode(''),0,0,'L');
    //////////////quitar al tirar cel
    
    $pdf->Cell(47.5,0,utf8_decode("Pendiente ".strftime('%B', strtotime($row['fechaCobro'])). " de ".strftime('%Y', strtotime($row['fechaCobro']))),0,0,'L');
    
    ////////////////////////////// fin quitar al tirar cel
    ///cel
    //$pdf->Cell(47.3,0,utf8_decode(''),0,0,'L');
    ///fin cel
    /////////////////////////////
    if ($row['exento'] != "T") {
        $pdf->Cell(24,0,utf8_decode("$".number_format($separado,2)),0,0,'L');
        $pdf->Cell(70,0,utf8_decode("$".number_format($separado,2)),0,0,'L');
    }
    else {
        $pdf->Cell(23,0,utf8_decode("$".number_format($separado,2)),0,0,'L');
        $pdf->Cell(70,0,utf8_decode("$".number_format($separado,2)),0,0,'L');
    }

    $pdf->Cell(31,0,utf8_decode(''),0,0,'L');
    $pdf->Cell(-57,0,utf8_decode('1'),0,0,'R');
    $pdf->Cell(3,0,utf8_decode(''),0,0,'L');
    //////////quitar al tirar cel
    
    $pdf->Cell(48,0,utf8_decode("Pendiente ".strftime('%B', strtotime($row['fechaCobro'])). " de ".strftime('%Y', strtotime($row['fechaCobro']))),0,0,'L');
    
    ////////////////////////////// fin quitar al tirar cel
    ///cel
    //$pdf->Cell(48.3,0,utf8_decode(''),0,0,'L');
    ///fin cel
    /////////////////////////////
    if ($row['exento'] != "T") {
        $pdf->Cell(23,0,utf8_decode("$".number_format($separado,2)),0,0,'L');
        $pdf->Cell(70,0,utf8_decode("$".number_format($separado,2)),0,0,'L');
    }
    else {
        $pdf->Cell(23,0,utf8_decode("$".number_format($separado,2)),0,0,'L');
        $pdf->Cell(70,0,utf8_decode("$".number_format($separado,2)),0,0,'L');
    }

    $pdf->Cell(20,0,utf8_decode(''),0,0,'L');
    $pdf->Cell(-46,0,utf8_decode('1'),0,0,'R');
    $pdf->Cell(3,0,utf8_decode(''),0,0,'L');
    /////// quitar al tirar cel
    
    $pdf->Cell(48.5,0,utf8_decode("Pendiente ".strftime('%B', strtotime($row['fechaCobro'])). " de ".strftime('%Y', strtotime($row['fechaCobro']))),0,0,'L');
    
    ////////////////////////////// fin quitar al tirar cel
    $pdf->Cell(48,0,utf8_decode(''),0,0,'L');
    /////////////////////////////
    if ($row['exento'] != "T") {
        $pdf->Cell(23.5,0,utf8_decode("$".number_format($separado,2)),0,0,'L');
        $pdf->Cell(70,0,utf8_decode("$".number_format($separado,2)),0,1,'L');
    }
    else {
        $pdf->Cell(23.5,0,utf8_decode("$".number_format($separado,2)),0,0,'L');
        $pdf->Cell(70,0,utf8_decode("$".number_format($separado,2)),0,1,'L');
    }
    //////////////////////////////INICIO FRANJA 2 DONDE ESTAN LOS MESES ///////////////////////////////
        $pdf->Ln(3);

        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(-1,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,0,utf8_decode(strtoupper(strftime('%B', strtotime($row['fechaCobro'])))),0,0,'L');
        $pdf->Cell(48.5,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(65,0,utf8_decode(strtoupper(strftime('%B', strtotime($row['fechaCobro'])))),0,0,'L');
        $pdf->Cell(54,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,0,utf8_decode(strtoupper(strftime('%B', strtotime($row['fechaCobro'])))),0,1,'L');

        $pdf->Ln(3);

        $pdf->Cell(-1,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,0,utf8_decode("$".number_format($unitario + $row['totalImpuesto'],2)),0,0,'L');
        $pdf->Cell(48.5,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(65,0,utf8_decode("$".number_format($unitario + $row['totalImpuesto'],2)),0,0,'L');
        $pdf->Cell(54,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,0,utf8_decode("$".number_format($unitario + $row['totalImpuesto'],2)),0,1,'L');

        $pdf->Ln(11);

        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(-1,0,utf8_decode(''),0,0,'L');
        $thisMonth=date_create($row['fechaCobro']);
        date_sub($thisMonth,date_interval_create_from_date_string("1 month"));
        $earlierMonth = date_format($thisMonth,"Y-m-d");
        $pdf->Cell(70,0,utf8_decode(strtoupper(strftime('%B', strtotime($earlierMonth)))),0,0,'L'); //MES ANTERIOR / ANTICIPO
        $pdf->Cell(48.5,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(65,0,utf8_decode(strtoupper(strftime('%B', strtotime($earlierMonth)))),0,0,'L'); //MES ANTERIOR / ANTICIPO
        $pdf->Cell(54,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,0,utf8_decode(strtoupper(strftime('%B', strtotime($earlierMonth)))),0,1,'L'); //MES ANTERIOR / ANTICIPO

        $pdf->Ln(3);

        $pdf->Cell(-1,0,utf8_decode(''),0,0,'L');
        if ($dataInfo->getBeforeSM('tbl_cargos', $row['codigoCliente'], $row['tipoServicio'], 0, $row['fechaFactura']) == "VACIA") {
            $ant = doubleval(0.00) + doubleval(0.00);
            $pdf->Cell(73,0,utf8_decode("$".number_format($ant,2)),0,0,'L');
        }else {
            $ant = $dataInfo->getBeforeSM('tbl_cargos', $row['codigoCliente'], $row['tipoServicio'], 0, $row['fechaFactura']);
            $pdf->Cell(73,0,utf8_decode("$".number_format($ant,2)),0,0,'L');
        }

        $pdf->Cell(45.5,6,utf8_decode(''),0,0,'L');
        if ($dataInfo->getBeforeSM('tbl_cargos', $row['codigoCliente'], $row['tipoServicio'], 0, $row['fechaFactura']) == "VACIA") {
            $ant = doubleval(0.00) + doubleval(0.00);
            $pdf->Cell(74,0,utf8_decode("$".number_format($ant,2)),0,0,'L');
        }else {
            $ant = $dataInfo->getBeforeSM('tbl_cargos', $row['codigoCliente'], $row['tipoServicio'], 0, $row['fechaFactura']);
            $pdf->Cell(74,0,utf8_decode("$".number_format($ant,2)),0,0,'L');
        }

        $pdf->Cell(45,0,utf8_decode(''),0,0,'L');
        if ($dataInfo->getBeforeSM('tbl_cargos', $row['codigoCliente'], $row['tipoServicio'], 0, $row['fechaFactura']) == "VACIA") {
            $ant = doubleval(0.00) + doubleval(0.00);
            $pdf->Cell(60,0,utf8_decode("$".number_format($ant,2)),0,1,'L');
        }else {
            $ant = $dataInfo->getBeforeSM('tbl_cargos', $row['codigoCliente'], $row['tipoServicio'], 0, $row['fechaFactura']);
            $pdf->Cell(60,0,utf8_decode("$".number_format($ant,2)),0,1,'L');
        }

        $pdf->Ln(15);

        $pdf->SetFont('Arial','B',8);
        $totalFactura = number_format($separado+$totalIva,2);
        $retenIva2 = floatval($monto) * 0.01;
        $pdf->Cell(-1,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,0,utf8_decode("$".$totalFactura),0,0,'L'); //MONTO TOTAL GRANDE
        $pdf->Cell(48.5,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(65,0,utf8_decode("$".$totalFactura),0,0,'L'); //MONTO TOTAL GRANDE
        $pdf->Cell(54,0,utf8_decode(''),0,0,'L');
        $pdf->Cell(70,0,utf8_decode("$".$totalFactura),0,1,'L'); //MONTO TOTAL GRANDE
        /////////////////////MESES EN GRANDE TERMINA ACÁ
        ///CORTE 2 *******************************************************************************
        $pdf->Ln(-2);
    //////////////////////////////INICIO FRANJA 2 DONDE ESTAN LOS MESES ///////////////////////////////

        $pdf->SetFont('Arial','',7);

        //$pdf->Ln();
        if ($row['exento'] != "T") {
            $pdf->Cell(92.5,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".number_format($separado,2)),0,0,'L');
            $pdf->Cell(49,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(50,0,utf8_decode("$".number_format($separado,2)),0,0,'L');
            $pdf->Cell(69,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".number_format($separado,2)),0,1,'L');
            $pdf->Ln(4.35);
            $pdf->Cell(92.5,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".number_format($totalIva,2)),0,0,'L');
            $pdf->Cell(49,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(50,0,utf8_decode("$".number_format($totalIva,2)),0,0,'L');
            $pdf->Cell(69,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".number_format($totalIva,2)),0,1,'L');
            $pdf->Ln(4.5);
            $pdf->Cell(76,0,utf8_decode(''),0,0,'L');
            //// Quitar al tirar CEL
            $numeroALetras = NumerosEnLetras::convertir(number_format(((doubleval($unitario) + $row['totalImpuesto'])),2), 'dólares', false, 'centavos');
            /// Fin quitar al tirar CEL
            ///// CEL
             //$numeroALetras = NumerosEnLetras::convertir(number_format(((doubleval($unitario) + $row['totalImpuesto'] - $retenIva)),2), 'dólares', false, 'centavos');
            //// Fin CEL
            //$pdf->Cell(60,0,utf8_decode($numeroALetras),0,0,'C');
            $pdf->Cell(16.5,0,utf8_decode(""),0,0,'L'); //IMPUESTO SEGURIDAD
            $pdf->Cell(70,0,utf8_decode("$".number_format($row['totalImpuesto'],2)),0,0,'L');
            $pdf->Cell(-20,0,utf8_decode(''),0,0,'L');
            //$numeroALetras = NumerosEnLetras::convertir(number_format($monto,2), 'dólares', false, 'centavos');
            //$pdf->Cell(30,0,utf8_decode($numeroALetras),0,0,'C');
            $pdf->Cell(69,0,utf8_decode(""),0,0,'L'); //IMPUESTO SEGURIDAD
            $pdf->Cell(65,0,utf8_decode("$".number_format($row['totalImpuesto'],2)),0,0,'L');

            //$pdf->Cell(20,0,utf8_decode($numeroALetras),0,0,'C');
            $pdf->Cell(54,0,utf8_decode(""),0,0,'L'); //IMPUESTO SEGURIDAD
            $pdf->Cell(70,0,utf8_decode("$".number_format($row['totalImpuesto'],2)),0,1,'L');
            $pdf->Ln(4);
            $pdf->Cell(92.5,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".number_format($separado+$totalIva,2)),0,0,'L');
            $pdf->Cell(49,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(60,0,utf8_decode("$".number_format($separado+$totalIva,2)),0,0,'L');
            $pdf->Cell(59,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".number_format($separado+$totalIva,2)),0,1,'L');

            $pdf->Ln(4.5);
            ////// Cel
            /*
            $pdf->Cell(92.5,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".$retenIva),0,0,'L');//IVA RETENIDO
            $pdf->Cell(49,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".$retenIva),0,0,'L');//IVA RETENIDO
            $pdf->Cell(49,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".$retenIva),0,0,'L');//IVA RETENIDO
            */
            ////// fin Cel
            //////// quitar al tirar cel
            
            $pdf->Cell(92.5,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".'0.00'),0,0,'L');//IVA RETENIDO
            $pdf->Cell(49,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".'0.00'),0,0,'L');//IVA RETENIDO
            $pdf->Cell(49,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".'0.00'),0,1,'L');//IVA RETENIDO
            
            //////// fin quitar al tirar cel
            $pdf->Ln(4);
            $pdf->Cell(92.5,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".'0.00'),0,0,'L');//VENTAS NO SUJETAS
            $pdf->Cell(49,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".'0.00'),0,0,'L');//VENTAS NO SUJETAS
            $pdf->Cell(49,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".'0.00'),0,1,'L');//VENTAS NO SUJETAS
            $pdf->Ln(4.5);
            $pdf->Cell(92.5,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".'0.00'),0,0,'L');//VENTAS EXENTAS
            $pdf->Cell(49,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".'0.00'),0,0,'L');//VENTAS EXENTAS
            $pdf->Cell(49,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".'0.00'),0,1,'L');//VENTAS EXENTAS
            $pdf->Ln(4);
            /////// CEL
            /*
            $pdf->Cell(92.5,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".number_format(doubleval($unitario) + doubleval($row['totalImpuesto'] - $retenIva),2)),0,0,'L');
            $pdf->Cell(49,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".number_format(doubleval($unitario) + doubleval($row['totalImpuesto'] - $retenIva),2)),0,0,'L');
            $pdf->Cell(49,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".number_format(doubleval($unitario) + doubleval($row['totalImpuesto'] - $retenIva),2)),0,1,'L');
            */
            /////// Fin CEL
            ///////////// quitar al tirar cel
            
            $pdf->Cell(92.5,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".number_format(doubleval($unitario) + doubleval($row['totalImpuesto']),2)),0,0,'L');
            $pdf->Cell(49,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".number_format(doubleval($unitario) + doubleval($row['totalImpuesto']),2)),0,0,'L');
            $pdf->Cell(49,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".number_format(doubleval($unitario) + doubleval($row['totalImpuesto']),2)),0,1,'L');
            
            ///////////// fin quitar al tirar cel
            //COBRADOR
            $pdf->Cell(60,6,utf8_decode(""),0,0,'L');
            $pdf->Cell(40,6,utf8_decode(''/*$dataInfo->getCobrador('tbl_cobradores',$row['codigoCobrador'])*/),0,0,'L');
            $pdf->Cell(80,6,utf8_decode(""),0,0,'L');
            $pdf->Cell(40,6,utf8_decode(''/*$dataInfo->getCobrador('tbl_cobradores',$row['codigoCobrador'])*/),0,1,'L');

            $pdf->Ln(7);
            $pdf->SetFont('Arial','',7);
            //$pdf->MultiCell(50,3,utf8_decode($mensaje),0,'C',0);
            $pdf->Cell(-2.5,1,utf8_decode(""),0,0,'L');
            $pdf->Cell(-1,1,utf8_decode(""),0,0,'L');
            $pdf->Cell(20,1,utf8_decode(date_format(date_create($row['fechaVencimiento']), 'd/m/Y')),0,0,'C');
            //$pdf->MultiCell(80,3,utf8_decode($mensaje),0,'C',0);

            $pdf->Cell(98.5,1,utf8_decode(""),0,0,'L');
            $pdf->Cell(20,1,utf8_decode(date_format(date_create($row['fechaVencimiento']), 'd/m/Y')),0,0,'C');
            //$pdf->MultiCell(80,3,utf8_decode($mensaje),0,'C',0);

            $pdf->Cell(98,1,utf8_decode(""),0,0,'L');
            $pdf->Cell(20,1,utf8_decode(date_format(date_create($row['fechaVencimiento']), 'd/m/Y')),0,1,'C');
            $pdf->SetXY(17, 111);
            $pdf->Cell(11,1,utf8_decode(""),0,0,'L');
            $current_y = $pdf->GetY();
            $current_x = $pdf->GetX();
            $cell_width = 45;
            //$pdf->Cell(45,6,utf8_decode($numeroALetras),0,0,'C');
            $pdf->MultiCell(45,3,utf8_decode($numeroALetras),0,'J');
            $pdf->SetXY($current_x + $cell_width, $current_y);
            $pdf->Cell(74,1,utf8_decode(""),0,0,'L');
            $current_y = $pdf->GetY();
            $current_x = $pdf->GetX();
            $cell_width = 45;
            //$pdf->Cell(45,6,utf8_decode($numeroALetras),0,0,'C');
            $pdf->MultiCell(45,3,utf8_decode($numeroALetras),0,'J');
            $pdf->SetXY($current_x + $cell_width, $current_y);
            $pdf->Cell(74,1,utf8_decode(""),0,0,'L');
            $current_y = $pdf->GetY();
            $current_x = $pdf->GetX();
            $cell_width = 45;
            //$pdf->Cell(45,6,utf8_decode($numeroALetras),0,0,'C');
            $pdf->MultiCell(45,3,utf8_decode($numeroALetras),0,'J');
            $pdf->SetXY($current_x + $cell_width, $current_y);
            
            //CORTE 3****************************************************************************************
            $pdf->SetAutoPageBreak(false);
            $pdf->Ln(67);
            $pdf->Cell(291,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode($row['numeroFactura']),0,1,'L');
            $pdf->Ln(9.5);
            $pdf->SetAutoPageBreak(false);
            $pdf->Cell(136,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode($row['codigoCliente']),0,1,'L');
            $pdf->Ln(4.5);
            $pdf->Cell(264,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode(date_format(date_create($row['fechaFactura']), 'd/m/Y')),0,0,'L');
            $pdf->Ln(0);
            $pdf->Cell(136.5,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode($row['nombre']),0,0,'L');
            $pdf->Ln(2.5);
            $pdf->Cell(139.5,0,utf8_decode(''),0,0,'L');
            $current_y = $pdf->GetY();
            $current_x = $pdf->GetX();
            $cell_width = 90;
            //$pdf->Cell(45,6,utf8_decode($numeroALetras),0,0,'C');
            $pdf->MultiCell(90,4,utf8_decode($row['direccion']),0,'J');
            $pdf->SetXY($current_x + $cell_width, $current_y);
            $pdf->Ln(1.5);
            $pdf->Cell(252,0,utf8_decode(''),0,0,'L');
            if ($row['tipoServicio'] == "C") {
                $pdf->Cell(70,0,utf8_decode('CABLE'),0,1,'L');
            }else {
                $pdf->Cell(70,0,utf8_decode('INTERNET'),0,1,'L');
            }
            $pdf->SetXY(18, 200.3);
            $pdf->Cell(273,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode("$".$totalFactura),0,0,'L');
            $pdf->Ln(4.5);
            $pdf->Cell(140,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode($municipio),0,0,'L');
            $pdf->Cell(59,0,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,0,utf8_decode(date_format(date_create($row['fechaVencimiento']), 'd/m/Y')),0,0,'L');
        }
        else {
            $pdf->Cell(90,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".number_format($unitario,2)),0,0,'L');
            $pdf->Cell(55,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".number_format($unitario,2)),0,1,'L');
            $pdf->Ln(-2);
            $pdf->Cell(90,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(70,6,utf8_decode("$".'0.00'),0,0,'L');
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
        ///////////////////////////////////////////////////////////////////////////////
        /////////////primer apartado facturas Cell - EEO
        ///////////////////////////////////////////////////////////////////////////////
        /*
            $pdf->SetXY(28, 76);
    $mensajecel1='Cap. 7  Item 1.2 Un enlace dedicado a la red internet simétrico con ancho de banda de 4 Mbps.';
    $mensajecel2='Periodo 1 al 30 de Noviembre 2021.';
    $mensajecel3='Contrato CEL 6209-S.';
            $current_y = $pdf->GetY();
            $current_x = $pdf->GetX();
            $cell_width = 45;
            $pdf->MultiCell(45,3,utf8_decode($mensajecel1),0,'J');
            $pdf->SetXY($current_x + $cell_width, $current_y);
            $pdf->Cell(140,1,utf8_decode(""),0,1,'L');

            $pdf->Ln(10);
            $pdf->Cell(20,1,utf8_decode(""),0,0,'L');
            $current_y = $pdf->GetY();
            $current_x = $pdf->GetX();
            $cell_width = 45;
            $pdf->MultiCell(45,3,utf8_decode($mensajecel2),0,'J');
            $pdf->SetXY($current_x + $cell_width, $current_y);
            $pdf->Cell(140,1,utf8_decode(""),0,1,'L');

            $pdf->Ln(8);
            $pdf->Cell(20,1,utf8_decode(""),0,0,'L');
            $current_y = $pdf->GetY();
            $current_x = $pdf->GetX();
            $cell_width = 45;
            $pdf->MultiCell(45,3,utf8_decode($mensajecel3),0,'J');
            $pdf->SetXY($current_x + $cell_width, $current_y);
            ///////////////////////////////////////////////////////////////////////////////

            ///////////////////////////////////////////////////////////////////////////////
        /////////////segndo apartado
        ///////////////////////////////////////////////////////////////////////////////
            $pdf->SetXY(148, 76);
            $current_y = $pdf->GetY();
            $current_x = $pdf->GetX();
            $cell_width = 45;
            $pdf->MultiCell(45,3,utf8_decode($mensajecel1),0,'J');
            $pdf->SetXY($current_x + $cell_width, $current_y);
            $pdf->Cell(140,1,utf8_decode(""),0,1,'L');

            $pdf->Ln(10);
            $pdf->Cell(140,1,utf8_decode(""),0,0,'L');
            $current_y = $pdf->GetY();
            $current_x = $pdf->GetX();
            $cell_width = 45;
            $pdf->MultiCell(45,3,utf8_decode($mensajecel2),0,'J');
            $pdf->SetXY($current_x + $cell_width, $current_y);
            $pdf->Cell(140,1,utf8_decode(""),0,1,'L');

            $pdf->Ln(8);
            $pdf->Cell(140,1,utf8_decode(""),0,0,'L');
            $current_y = $pdf->GetY();
            $current_x = $pdf->GetX();
            $cell_width = 45;
            $pdf->MultiCell(45,3,utf8_decode($mensajecel3),0,'J');
            $pdf->SetXY($current_x + $cell_width, $current_y);
            ///////////////////////////////////////////////////////////////////////////////

            ///////////////////////////////////////////////////////////////////////////////
        /////////////tercer apartado
        ///////////////////////////////////////////////////////////////////////////////
            $pdf->SetXY(265, 76);
            $current_y = $pdf->GetY();
            $current_x = $pdf->GetX();
            $cell_width = 45;
            $pdf->MultiCell(45,3,utf8_decode($mensajecel1),0,'J');
            $pdf->SetXY($current_x + $cell_width, $current_y);
            $pdf->Cell(140,1,utf8_decode(""),0,1,'L');

            $pdf->Ln(10);
            $pdf->Cell(257,1,utf8_decode(""),0,0,'L');
            $current_y = $pdf->GetY();
            $current_x = $pdf->GetX();
            $cell_width = 45;
            $pdf->MultiCell(45,3,utf8_decode($mensajecel2),0,'J');
            $pdf->SetXY($current_x + $cell_width, $current_y);
            $pdf->Cell(140,1,utf8_decode(""),0,1,'L');

            $pdf->Ln(8);
            $pdf->Cell(257,1,utf8_decode(""),0,0,'L');
            $current_y = $pdf->GetY();
            $current_x = $pdf->GetX();
            $cell_width = 45;
            $pdf->MultiCell(45,3,utf8_decode($mensajecel3),0,'J');
            $pdf->SetXY($current_x + $cell_width, $current_y);
            ///////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////////////////////////////////////////////////
            //fin apartado cel
*/
      }

    /* close connection */
    mysqli_close($mysqli);
    $pdf->Output();
}
?>
