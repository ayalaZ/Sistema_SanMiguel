<?php
require '../../../pdfs/fpdf.php';
require '../../../numLe/src/NumerosEnLetras.php';
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

  $query = "SELECT nombre, numero_dui, numero_nit, cuota_in, periodo_contrato_int FROM clientes WHERE cod_cliente = ".$codigo;
  $resultado = $mysqli->query($query);

  // SQL query para traer datos del servicio de cable de la tabla clientes
  $query = "SELECT valorImpuesto FROM tbl_impuestos WHERE siglasImpuesto = 'CESC'";
  // Preparación de sentencia
  $statement = $mysqli->query($query);
  //$statement->execute();
  while ($result = $statement->fetch_assoc()) {
      $cesc = floatval($result['valorImpuesto']);
  }

  // SQL query para traer datos del servicio de cable de la tabla clientes
  $query = "SELECT valorImpuesto FROM tbl_impuestos WHERE siglasImpuesto = 'IVA'";
  // Preparación de sentencia
  $statement = $mysqli->query($query);
  //$statement->execute();
  while ($result = $statement->fetch_assoc()) {
      $iva = floatval($result['valorImpuesto']);
  }

//*****************************************************************F3
  $pdf = new FPDF();
  $pdf->AliasNbPages();
  $pdf->AddPage('P','Letter');
  $pdf->Image('../../../images/logo.png',10,10, 26, 24);
  $pdf->Ln(35);
  $pdf->SetFont('Arial','B',13);
  $pdf->Cell(190,6,'F-3',0,1,'R');
  $pdf->Ln();
  $pdf->Cell(190,6,utf8_decode('PAGARÉ SIN PROTESTO'),0,1,'C');
  $pdf->Ln(10);

  $pdf->SetFont('Arial','B',12);

  date_default_timezone_set('America/El_Salvador');

  //echo strftime("El año es %Y y el mes es %B");
  putenv("LANG='es_ES.UTF-8'");
  setlocale(LC_ALL, 'es_ES.UTF-8');
  $pdf->SetFont('Arial','B',12);
  $pdf->Cell(190,6,utf8_decode("Ciudad de Usulután, ").utf8_decode(strftime('%A %e de %B de %G')),0,1,'L');
  $pdf->Ln();

  while($row = $resultado->fetch_assoc())
  {
    $imp = substr((($row['cuota_in']/(1 + floatval($iva)))*$cesc),0,4);
    $imp = str_replace(',','.', $imp);
    //var_dump($imp);

    $cantidad = doubleval((doubleval($row['cuota_in']) + doubleval($imp))*doubleval($row['periodo_contrato_int']));
    $pdf->SetFont('Arial','B',12);
    $pdf->MultiCell(190,6,'TOTAL: $'.number_format($cantidad,2),0,'L',0);
    $numeroALetras = NumerosEnLetras::convertir(number_format($cantidad,2), 'dolares', false, 'centavos');
    $pdf->SetFont('Arial','',12);
    $pdf->MultiCell(190,6,utf8_decode('Por este PAGARÉ me obligo a pagar incondicionalmente a la sociedad CABLE SAT, S.A. DE C.V., la cantidad de '.$numeroALetras.' de Estados Unidos de América, reconociendo en caso de mora el interés del 4% anual.'),0,'L',0);
    $pdf->Ln();
    $pdf->MultiCell(190,6,utf8_decode('La cantidad antes mencionada se pagará en esta ciudad, en las oficinas administrativas de la sociedad acreedora, el día _____ de ______________________ del año ___________ En caso de acción judicial, señalo la ciudad de Usulután como domicilio especial en caso de ejecución; siendo a mi cargo, cualquier gasto que la sociedad acreedora antes mencionada hiciere en el cobro de la presente obligación, inclusive los llamados personales, y faculto a la sociedad acreedora para que designe al depositario judicial de los bienes que se embarguen, a quien relevo de la obligación de rendir fianza.'),0,'L',0);
    $pdf->Ln(3);

    $pdf->Cell(190,6,utf8_decode('Nombre del cliente: '.strtoupper($row['nombre'])),0,1,'L');

    $pdf->Ln(20);

    $pdf->Cell(190,6,'Firma: _______________________________',0,1,'L');
    $pdf->Cell(190,6,'NIT: '.$row['numero_nit'],0,1,'L');
    $pdf->Cell(190,6,'DUI: '.$row['numero_dui'],0,1,'L');
  }

 //*****************************************************************F4

  $query = "SELECT nombre, numero_dui, numero_nit FROM clientes WHERE cod_cliente = ".$codigo;
    $resultado = $mysqli->query($query);


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

//*****************************************************************F5

$query = "SELECT nombre, numero_dui, numero_nit, marca_modem, serie_modem, mac_modem FROM clientes WHERE cod_cliente = ".$codigo;
  $resultado = $mysqli->query($query);


  $pdf->AddPage('P','Letter');
  $pdf->Image('../../../images/logo.png',10,10, 26, 24);
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

  $pdf->Image('../../../images/cuadrointer.png',70,111, 77, 50);
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
  $pdf->Cell(120,6,'Nombre: '.utf8_decode(strtoupper($row['nombre'])),0,0,'L');
  $pdf->Cell(70,6,utf8_decode('Nombre del técnico:'),0,1,'L');
  $pdf->Cell(95,6,'DUI: '.$row['numero_dui'],0,0,'L');

  }
  /* close connection */
  mysqli_close($mysqli);
  $pdf->Output();
?>
