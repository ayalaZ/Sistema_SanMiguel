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


  function f5(){
	  global $codigo, $mysqli;
	  $query = "SELECT nombre, numero_dui, numero_nit, marca_modem, serie_modem, mac_modem FROM clientes WHERE cod_cliente = ".$codigo;
	  $resultado = $mysqli->query($query);
	  $cantidad = 50;

	$pdf = new FPDF();
	$pdf->AliasNbPages();
	$pdf->AddPage('P','Letter');
	$pdf->Image('../../../images/logo.png',10,10, 26, 24);
	$pdf->Image('../../../images/cuadrointer.png',70,111, 77, 50);
	$pdf->Ln(25);
	$pdf->SetFont('Arial','B',13);
	$pdf->Cell(190,6,'F-5',0,1,'R');
	$pdf->Ln();
	$pdf->Ln(10);

	$pdf->SetFont('Arial','B',12);

	  date_default_timezone_set('America/El_Salvador');

	  //echo strftime("El año es %Y y el mes es %B");
      putenv("LANG='es_ES.UTF-8'");
      setlocale(LC_ALL, 'es_ES.UTF-8');
	  $pdf->SetFont('Arial','B',12);
	  $pdf->Cell(190,6,utf8_decode("Ciudad de Usulután, ").utf8_decode(strftime('%A %e de %B de %G')),0,1,'L');
	  $pdf->Ln();
	  $pdf->Cell(190,6,utf8_decode('Cable Visión por Satélite S.A. DE C.V.'),0,1,'L');
	  $pdf->Ln();
		while($row = $resultado->fetch_assoc())
		{
	    $pdf->SetFont('Arial','',12);
	    $pdf->MultiCell(190,6,utf8_decode('Hace constar que hace entrega del equipo de marca '.$row['marca_modem'].' con número de serie '.$row['serie_modem'].' y MAC '.$row['mac_modem'].' en perfecto funcionamiento; al firmar esta constancia, yo, '.strtoupper($row['nombre']).' me manifiesto en conformidad con el estado del equipo que se me ha entregado, y me hago responsable de la integridad física del equipo. CableSat pierde toda responsabilidad por cualquier daño ocasionado al mismo. '),0,'L',0);
	    $pdf->Ln();


		$pdf->Ln(48);

		$pdf->Cell(190,6,utf8_decode('¿Recibió la contraseña e instrucciones para el uso de la contraseña del modem?'),0,1,'L');
		$pdf->Ln();
		$pdf->Cell(40,6,utf8_decode('SÍ:__________'),0,0,'L');
		$pdf->Cell(40,6,'NO:__________',0,1,'L');

		$pdf->Ln();
		$pdf->Cell(190,6,utf8_decode('¿Se realizó prueba en su equipo del funcionamiento del servicio de internet?'),0,1,'L');
		$pdf->Ln();
		$pdf->Cell(40,6,utf8_decode('SÍ:__________'),0,0,'L');
		$pdf->Cell(40,6,'NO:__________',0,1,'L');

	    $pdf->Ln(23);

	    $pdf->Cell(120,6,'Firma: ______________________',0,0,'L');
		$pdf->Cell(70,6,'Firma: ______________________',0,1,'L');
		$pdf->Ln();
		$pdf->Cell(120,6,utf8_decode('Nombre: '.strtoupper($row['nombre'])),0,0,'L');
		$pdf->Cell(70,6,utf8_decode('Nombre del técnico:'),0,1,'L');
	    $pdf->Cell(95,6,'DUI: '.$row['numero_dui'],0,1,'L');

		}
		/* close connection */
  	  	mysqli_close($mysqli);
		$pdf->Output();
  }

  f5();

?>
