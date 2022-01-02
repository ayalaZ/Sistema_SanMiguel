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
  function f4(){
	  global $codigo, $mysqli;

	  $query = "SELECT nombre, numero_dui, numero_nit FROM clientes WHERE cod_cliente = ".$codigo;
		$resultado = $mysqli->query($query);
	  $cantidad = 50;

		$pdf = new FPDF();
		$pdf->AliasNbPages();
		$pdf->AddPage('P','Letter');
		$pdf->Image('../../../images/logo.png',10,10, 26, 24);
	  $pdf->Ln(35);
		$pdf->SetFont('Arial','B',13);
	  $pdf->Cell(190,6,'F-4',0,1,'R');
	  $pdf->Ln();
	  $pdf->Cell(190,6,utf8_decode('AUTORIZACIÓN PARA CONSULTAR Y COMPARTIR INFORMACIÓN'),0,1,'C');
	  $pdf->Ln(10);

	  $pdf->SetFont('Arial','B',12);

	  date_default_timezone_set('America/El_Salvador');

	  //echo strftime("El año es %Y y el mes es %B");
	  //setlocale(LC_ALL,"es_ES");
	  $pdf->SetFont('Arial','B',12);
	  //$pdf->Cell(190,6,utf8_decode(strftime('Ciudad de Usulután, %A %e de %B de %G')),0,1,'L');
	  $pdf->Ln();
		while($row = $resultado->fetch_assoc())
		{
	    $pdf->SetFont('Arial','B',12);
	    $pdf->Cell(190,6,'Yo, '.utf8_decode(strtoupper($row['nombre'])),0,1,'L');

	    $pdf->SetFont('Arial','',12);
	    $pdf->MultiCell(190,6,utf8_decode('Autorizo a CABLE SAT, S.A. DE C.V., para que acceda, consulte y verifique mi información personal y crediticia, para análisis presentes y futuros, relacionados con la contratación de servicios de telecomunicaciones de CABLE SAT, S.A. DE C.V., que estuviere contenida en las bases de datos de las agencias de información con las que CABLE SAT, S.A. DE C.V. tuviese acuerdos de caracter comercial y/o contractual'),0,'L',0);
	    $pdf->Ln();
	    $pdf->MultiCell(190,6,utf8_decode('Así mismo, autorizo a CABLE SAT, S.A. DE C.V. para que recopile, transmita mi comportamiento crediticio con entidades dedicadas a recopilar, procesar e informar sobre datos crediticios personales; y/o que mis datos pasen a formar parte del historial crediticio en las bases de datos de empresas especializadas de servicios de información crediticia y buros de crédito. Así mismo doy mi consentimiento para que, CABLE SAT, S.A. DE C.V. pueda actualizar cualquiera de los datos personales en el presente documento. Declaro que la información proporcionada en este documento es veráz y faculto a CABLE SAT, S.A. DE C.V. para verificarla.'),0,'L',0);
	    $pdf->Ln(3);

	    $pdf->Cell(190,6,utf8_decode('Nombre del cliente: '.strtoupper($row['nombre'])),0,1,'L');

	    $pdf->Ln(20);

	    $pdf->Cell(190,6,'Firma: _______________________________',0,1,'L');
	    $pdf->Cell(190,6,'NIT: '.$row['numero_nit'],0,1,'L');
	    $pdf->Cell(190,6,'DUI: '.$row['numero_dui'],0,1,'L');
		}
		/* close connection */
	  	  mysqli_close($mysqli);
		$pdf->Output();
  }
  f4();

?>
