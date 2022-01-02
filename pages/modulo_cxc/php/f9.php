<?php
	require '../../../pdfs/fpdf.php';
  require_once("../../../php/config.php");
  if(!isset($_SESSION))
  {
  	session_start();
  }
  $host = DB_HOST;
  $user = DB_USER;
  $password = DB_PASSWORD;
  $database = $_SESSION['db'];
  $mysqli = new mysqli($host, $user, $password, $database);

  $codigo = $_GET['id'];
  function f9(){
      global $codigo, $mysqli;
      $query = "SELECT cod_cliente, nombre, numero_dui, numero_nit, marca_modem, serie_modem, mac_modem FROM clientes WHERE cod_cliente = ".$codigo;
      $resultado = $mysqli->query($query);

      $query = "SELECT * FROM tbl_cargos WHERE codigoCliente = ".$codigo." AND tipoServicio = 'I' AND estado = 'pendiente' AND anulada = 0";
      $facturasInter = $mysqli->query($query);

      $query = "SELECT * FROM tbl_cargos WHERE codigoCliente = ".$codigo." AND tipoServicio = 'C' AND estado = 'pendiente' AND anulada = 0";
      $facturasCable = $mysqli->query($query);

      $pdf = new FPDF();
      $pdf->AliasNbPages();
      $pdf->AddPage('P','Letter');
      $pdf->Image('../../../images/logo.png',10,10, 26, 24);
      $pdf->Ln(15);
      $pdf->SetFont('Arial','B',11);
      $pdf->Cell(190,6,'F-9',0,1,'R');
      $pdf->Ln();
      $pdf->Ln(10);

      $pdf->SetFont('Arial','B',11);

      date_default_timezone_set('America/El_Salvador');

      //echo strftime("El año es %Y y el mes es %B");
	  putenv("LANG='es_ES.UTF-8'");
	  setlocale(LC_ALL, 'es_ES.UTF-8');
      $pdf->SetFont('Arial','B',11);
      $pdf->Cell(190,6,utf8_decode("Ciudad de Usulután, ").utf8_decode(strftime('%A %e de %B de %G')),0,1,'L');
      $pdf->Ln();
      $pdf->Cell(190,6,utf8_decode('Cable Visión por Satélite S.A. DE C.V.'),0,1,'L');
      $pdf->Ln();
    	while($row = $resultado->fetch_assoc())
    	{
        $pdf->SetFont('Arial','',11);
        $pdf->Cell(190,6,'Estimado(a) Sr(a)(ita): '.$row['nombre'].' ('.$row['cod_cliente'].')',0,1,'L');
        $pdf->Ln();

        $pdf->MultiCell(190,6,utf8_decode('Mediante la presente se le informa sobre el retraso en el pago de su facturación sobre los servicios contratados con la empresa Cable Sat. De acuerdo a las clausulas de contratación de servicio, debe realizar las cancelaciones en nuestras oficinas.'),0,'L',0);
        $pdf->Ln();
        $pdf->MultiCell(190,6,utf8_decode('Se recomienda a nuestros clientes en su condición, realizar la reconexión de su respectivo servicio, para que su pago sea por el beneficio de su consumo.'),0,'L',0);
        $pdf->Ln();
        $pdf->MultiCell(190,6,utf8_decode('De hacer caso omiso a las notificaciones, se hará uso de los documentos y garantías como lo establece:'),0,'L',0);
        $pdf->Ln();
        $pdf->MultiCell(190,6,'Clausula 8:',0,'L',0);

        $pdf->Ln(3);
        $pdf->SetFont('Arial','B',11);
        $pdf->MultiCell(190,6,utf8_decode('Suscribe un pagaré por el valor del servicio, durante el plazo contratado. Este valor será utilizado como garantía de los compromisos económicos que adquiero mediante la suscripción del presente contrato, el cuál será utilizado en caso de acción judicial.'),0,'L',0);

        $pdf->Ln();
        $pdf->SetFont('Arial','',11);
        $pdf->MultiCell(190,6,utf8_decode('Además de hacer valer la autorización firmada para compartir la información crediticia, afectando su récord como cliente de otras entidades.'),0,'L',0);

        $pdf->Ln();

    	}
        $pdf->Cell(95,6,'INTERNET:',1,0,'L');
        $pdf->Cell(95,6,'CABLE:',1,1,'L');
        $totalCable = 0;
        $totalInter = 0;
		$fechaVencimiento = "";
        while (($pendientesInter = $facturasInter->fetch_assoc() && $pendientesCable = $facturasCable->fetch_assoc()) || ($pendientesInter = $facturasInter->fetch_assoc() || $pendientesCable = $facturasCable->fetch_assoc())) {
            $totalCable += doubleval($pendientesCable['cuotaCable'] + doubleval($pendientesCable['totalImpuesto']));
            $totalInter += doubleval($pendientesInter['cuotaInternet'] + doubleval($pendientesInter['totalImpuesto']));
			if (isset($pendientesCable['fechaVencimiento'])) {
				$fechaVencimiento = $pendientesCable['fechaVencimiento'];
			}

            $pdf->Cell(95,6,'$'.$pendientesInter['cuotaInternet'],1,0,'L');
            $pdf->Cell(95,6,'$'.$pendientesCable['cuotaCable'],1,1,'L');
        }

        $pdf->Cell(95,6,'$5.00 por mora',1,0,'L');
        $pdf->Cell(95,6,'$3.00 por mora',1,1,'L');
        $pdf->Cell(95,6,utf8_decode('$5.22 de reconexión'),1,0,'L');
        $pdf->Cell(95,6,utf8_decode('$3.13 de reconexión'),1,1,'L');
        $pdf->SetFont('Arial','B',11);
        //var_dump($totalCable);
        //var_dump($totalInter);
        if ($totalInter == 0) {
            $totalInter = number_format($totalInter,2);
            $pdf->Cell(95,6,'TOTAL: $'.$totalInter,1,0,'L');
        }else {
            $totalInter = number_format($totalInter + 5.00 + 5.22, 2);
            $pdf->Cell(95,6,'TOTAL: $'.$totalInter,1,0,'L');
        }

        if ($totalCable == 0) {
            $totalCable = number_format($totalCable,2);
            $pdf->Cell(95,6,'TOTAL: $'.$totalCable,1,1,'L');
        }else {
            $totalCable = number_format($totalCable + 3.00 + 3.13, 2);
            $pdf->Cell(95,6,'TOTAL: $'.$totalCable,1,1,'L');
        }
        $pdf->Cell(95,6,'MONTO TOTAL: $'.(number_format(doubleval($totalCable) + doubleval($totalInter),2)),0,0,'L');
        $pdf->Ln(10);
        $pdf->Cell(95,6,'Un saludo afectuoso, atentamente',0,0,'L');
    	$pdf->Cell(95,6,utf8_decode('Válido hasta '.$fechaVencimiento),0,1,'R');
        $pdf->Ln(3);

    	$pdf->Cell(120,6,'____________________________________',0,0,'L');
    	$pdf->Cell(70,6,'',0,1,'L');
        $pdf->Cell(95,6,'Departamento de cobro de mora, CableSat.',0,1,'L');
        //$pdf->Cell(95,6,utf8_decode('TOTAL: $'.$totalInter),1,0,'L');
        //$pdf->Cell(95,6,utf8_decode('TOTAL: $'.$totalCable),1,1,'L');

		/* close connection */
  	  	mysqli_close($mysqli);
    	$pdf->Output();
  }

  f9();

?>
