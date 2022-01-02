<?php
require '../../../pdfs/fpdf.php';
require_once("../../../php/config.php");
require '../../../numLe/src/NumerosEnLetras.php';
require_once('../../../php/connection.php');
require_once('../../modulo_administrar/php/getInfo2.php');
if(!isset($_SESSION))
{
  if(!isset($_SESSION))
  {
    session_start([
        'cookie_lifetime' => 86400,
    ]);
  }
}
$host = DB_HOST;
$user = DB_USER;
$password = DB_PASSWORD;
$database = $_SESSION['db'];
$mysqli = new mysqli($host, $user, $password, $database);
$tipoServicio = $_POST['lServicio'];
$nDesde = $_POST['lDesde'];
$mdesde = $_POST['mdesde'];
$mhasta = $_POST['mhasta'];
$counter = 0;
$totalCable = 0;
$totalInternet = 0;
//var_dump($cobrador);
//$codigo = $_GET['id'];


$pdf = new FPDF();
 $pdf->AddPage('P','Letter');
  $pdf->SetFont('Arial','',6);
  $pdf->Cell(260,3,utf8_decode("Página ".str_pad($pdf->pageNo(),4,"0",STR_PAD_LEFT)),0,1,'R');
  $pdf->Ln(0);
  date_default_timezone_set('America/El_Salvador');
 $pdf->Cell(180,4,utf8_decode("GENERADO POR: ".strtoupper($_SESSION['nombres'])." ".strtoupper($_SESSION['apellidos']). " ".date('d/m/Y h:i:s')),"",1,'R');
  $pdf->SetFont('Arial','B',12);
  $pdf->Cell(180,3,utf8_decode("CABLE VISION POR SATELITE, S.A DE C.V "),0,1,'C');
  $pdf->Image('../../../images/logo.png',10,10, 20, 18);

  $pdf->Ln(1);
  $pdf->SetFont('Arial','',8);
  $pdf->Cell(180,6,utf8_decode("INFORME DE FACTURACION PENDIENTE POR AÑO"),0,1,'C');
  if ($tipoServicio == 'C') {
    $servicio = 'CABLE TV';
  }elseif ($tipoServicio == 'I'){
    $servicio = 'INTERNET';
  }elseif ($tipoServicio == 'A') {
    $servicio = 'TODOS LOS SERVICIOS';
  }
  $pdf->Cell(180,6,utf8_decode("SERVICIO: ".$servicio),0,1,'C');
  $pdf->SetFont('Arial','',6);
  $pdf->Ln(1);

 putenv("LANG='es_ES.UTF-8'");
      setlocale(LC_ALL, 'es_ES.UTF-8');
      $pdf->SetFont('Arial','B',8);
      $pdf->Ln(1);
      $pdf->Cell(10,6,utf8_decode('NÂ°'),1,0,'L');
      $pdf->Cell(50,6,utf8_decode('Cliente'),1,0,'L');
      $pdf->Cell(70,6,utf8_decode('Direccion de cobro'),1,0,'L');
     

      $current_y = $pdf->GetY();
      $current_x = $pdf->GetX();
      $cell_width = 13;
      $pdf->MultiCell(13,3,utf8_decode('Tipo Servicio'),1,'C');
      $pdf->SetXY($current_x + $cell_width, $current_y);
      $current_y = $pdf->GetY();
      $current_x = $pdf->GetX();
      $cell_width = 15;
      $pdf->MultiCell(15,3,utf8_decode('N° Factura'),1,'C');
      $pdf->SetXY($current_x + $cell_width, $current_y);

      $current_y = $pdf->GetY();
      $current_x = $pdf->GetX();
      $cell_width = 15;
      $pdf->MultiCell(15,3,utf8_decode('Mes Servicio'),1,'C');
      $pdf->SetXY($current_x + $cell_width, $current_y);

      $current_y = $pdf->GetY();
      $current_x = $pdf->GetX();
      $cell_width = 15;
      $pdf->MultiCell(15,3,utf8_decode('Fecha Venct.'),1,'C');
      $pdf->SetXY($current_x + $cell_width, $current_y);

      $current_y = $pdf->GetY();
      $current_x = $pdf->GetX();
      $pdf->Cell(15,6,utf8_decode('Saldo'),1,0,'C');
      $pdf->Ln(6);
      $pdf->SetFont('Arial','',6);
      $pdf->Ln(1);



$contadorDeFilas=1;
$counter1=1;


 switch ($tipoServicio) {
    case 'A':
    //TODOS LOS SERVICIOS
      $sqlf = "SELECT * FROM tbl_cargos WHERE estado='pendiente' AND mesCargo LIKE '%$nDesde%' AND MONTH(fechaCobro) >= $mdesde AND MONTH(fechaCobro) <= $mhasta AND anulada ='0'";
      break;

    case 'C':
    //LOS SERVICIOS DE CABLE
     $sqlf = "SELECT * FROM tbl_cargos WHERE estado='pendiente' AND mesCargo LIKE '%$nDesde%' AND MONTH(fechaCobro) >= $mdesde AND MONTH(fechaCobro) <= $mhasta AND tipoServicio='C' AND anulada ='0'";
      break;
    
     case 'I':
     //LOS SERVICIOS DE INTERNET
      $sqlf = "SELECT * FROM tbl_cargos WHERE estado='pendiente' AND mesCargo LIKE '%$nDesde%' AND MONTH(fechaCobro) >= $mdesde AND MONTH(fechaCobro) <= $mhasta AND tipoServicio='I' AND anulada ='0'";
      break;
  }
 $resultadof = $mysqli->query($sqlf);
/// orientacion de pagina P vertical L horizontal
      date_default_timezone_set('America/El_Salvador');
        while($row = $resultadof->fetch_assoc())
      {
        $pdf->Ln(4);
        $pdf->SetFont('Arial','',6);
        $pdf->Cell(10,6,utf8_decode($contadorDeFilas),0,0,'L');
        $contadorDeFilas++;
        $pdf->SetFont('Arial','',5);
        $current_y = $pdf->GetY();
        $current_x = $pdf->GetX();
        $cell_width = 50;
        $pdf->MultiCell(50,6,utf8_decode(strtoupper(str_pad($row['codigoCliente'], 5, "0", STR_PAD_LEFT)."  ".$row['nombre'])),0,'L');
        $pdf->SetXY($current_x + $cell_width, $current_y);

        $current_y = $pdf->GetY();
        $current_x = $pdf->GetX();
        $cell_width = 70;
        $pdf->SetFont('Arial','',5);
        $pdf->MultiCell(70,2,utf8_decode($row['direccion']),0,'J');
        $pdf->SetXY($current_x + $cell_width, $current_y);
        
        $pdf->Cell(13,6,utf8_decode($row['tipoServicio']),0,0,'C');
        
        $pdf->Cell(15,6,utf8_decode($row['numeroFactura']),0,0,'C');
        $pdf->Cell(15,6,utf8_decode($row['mesCargo']),0,0,'C');
        $pdf->Cell(15,6,utf8_decode($row['fechaVencimiento']),0,0,'C');
        
        
        if ($row['tipoServicio'] == 'C') {
          $pdf->Cell(15,6,'$'.number_format(($row['cuotaCable'] + $row['totalImpuesto']),2),0,0,'C');
          $totalCable += number_format(($row['cuotaCable'] + $row['totalImpuesto']),2);
        
        }elseif ($row['tipoServicio'] == 'I'){
       
          $pdf->Cell(15,6,'$'.number_format(($row['cuotaInternet'] + $row['totalImpuesto']),2),0,0,'C');
          $totalInternet += number_format(($row['cuotaInternet'] + $row['totalImpuesto']),2);
      }
        
        $pdf->Ln(4);
        $counter = $counter + ($row['cuotaCable'] + $row['totalImpuesto']) + ($row['cuotaInternet'] + $row['totalImpuesto']) ;
        }
        $pdf->Ln(4);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(275,6,'Total Cable: '.'$'.number_format($totalCable,2),0,1,'C');
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(275,6,'Total Internet: '.'$'.number_format($totalInternet,2),0,1,'C');
$pdf->SetFont('Arial','',10);
$pdf->Cell(275,6,'Total saldo: '.'$'.number_format($counter,2),0,1,'C');

///////////////////////////
//////////////////////////


        $pdf->Ln(7);
        $pdf->SetFont('Arial','',10);
 
        
             mysqli_close($mysqli);
             $pdf->Output();
  ?>