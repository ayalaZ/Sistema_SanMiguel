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
$mysqliCobrador = new mysqli($host, $user, $password, $database);
$mysqliCableDePaquete = new mysqli($host, $user, $password, $database);
$mysqliInternetDePaquete = new mysqli($host, $user, $password, $database);
$mysqliFacturasPendientes  = new mysqli($host, $user, $password, $database);
$mysqliColonias  = new mysqli($host, $user, $password, $database);
$sumarftth = 0;
$sumarinalam = 0;
$sumardocsis = 0;
$sumartodo = 0;

//Verificamos el tipo de técología
/*
if ($tecnologia == "0"){
  $tec = "TODAS";
  $tecnoHelper = '%';
}elseif($tecnologia == '1'){
  $tec = "DOCSIS";
  $tecnoHelper = '%'.'DOCSIS'.'%';
}elseif($tecnologia == '2'){
  $tec = "FTTH";
  $tecnoHelper = '%'.'FTTH'.'%';
}elseif($tecnologia == '3'){
  $tec = "INALAMBRICA";
  $tecnoHelper = '%'.'INALAMBRICO'.'%';
}
*/


class FPDF1 extends FPDF
{
  /// cabezera
function Header(){
 
  $this->SetFont('Arial','',6);
  $this->Cell(200,3,utf8_decode("Página ".str_pad($this->pageNo(),4,"0",STR_PAD_LEFT)),0,1,'R');
  $this->Ln(0);
  date_default_timezone_set('America/El_Salvador');
 $this->Cell(200,4,utf8_decode("GENERADO POR: ".strtoupper($_SESSION['nombres'])." ".strtoupper($_SESSION['apellidos']). " ".date('d/m/Y h:i:s')),"",1,'R');
  $this->SetFont('Arial','B',12);
  $this->Cell(200,3,utf8_decode("CABLE VISION POR SATELITE, S.A DE C.V "),0,1,'C');
  $this->Image('../../../images/logo.png',10,10, 20, 18);

  $this->Ln(1);
  $this->SetFont('Arial','',8);
  $this->Cell(200,6,utf8_decode("INFORME GENERAL DE MEGAS VENDIDOS. "),0,1,'C');
  $this->SetFont('Arial','',6);
  $this->Ln(2);

 putenv("LANG='es_ES.UTF-8'");
      setlocale(LC_ALL, 'es_ES.UTF-8');
      $this->SetFont('Arial','B',8);
      $this->Ln(3);
      $this->Cell(10,6,utf8_decode('N°'),1,0,'L');
      $this->Cell(55,6,utf8_decode('Cliente'),1,0,'L');
      $this->Cell(97,6,utf8_decode('Direccion de cobro'),1,0,'L');

      $this->Cell(13,6,utf8_decode('Megas'),1,0,'C');

      $this->Cell(15,6,utf8_decode('Telefono'),1,0,'C');
      $this->Ln(8);

}
/*
function Footer(){
  $this->SetY(-15);
  $this->SetFont('Arial','C',6);
  $this->Cell(0,10,utf8_decode("Página ").$this->PageNo().'/{nb}',0,0,'C');
}
*/
}
$contadorDeFilas=1;

$pdf = new FPDF1();

$query = "SELECT * FROM clientes WHERE (servicio_suspendido='F' or servicio_suspendido is null or servicio_suspendido='') AND estado_cliente_in = 1 AND cod_cliente<>'00000'";

  $resultado = $mysqli->query($query);
/// orientacion de pagina P vertical L horizontal
$pdf->AddPage('P','Letter');
/*
  $pdf->AddPage('L','Letter');
  $pdf->SetFont('Arial','',6);
  $pdf->Cell(260,3,utf8_decode("Página ".str_pad($pdf->pageNo(),4,"0",STR_PAD_LEFT)),0,1,'R');
  $pdf->Ln(0);
  date_default_timezone_set('America/El_Salvador');
 $pdf->Cell(260,4,utf8_decode("GENERADO POR: ".strtoupper($_SESSION['nombres'])." ".strtoupper($_SESSION['apellidos']). " ".date('d/m/Y h:i:s')),"",1,'R');
  $pdf->SetFont('Arial','B',12);
  $pdf->Cell(260,3,utf8_decode("CABLE VISION POR SATELITE, S.A DE C.V "),0,1,'C');
  $pdf->Image('../../../images/logo.png',10,10, 20, 18);

  $pdf->Ln(1);
  $pdf->SetFont('Arial','',8);
  $pdf->Cell(260,6,utf8_decode("INFORME GENERAL DE CLIENTES CATV. "),0,1,'C');
  $pdf->SetFont('Arial','',6);
  $pdf->Ln(5);
 */


   //$pdf->SetFont('Arial','B',11);

      date_default_timezone_set('America/El_Salvador');

      //echo strftime("El año es %Y y el mes es %B");
      /*
      putenv("LANG='es_ES.UTF-8'");
      setlocale(LC_ALL, 'es_ES.UTF-8');
      $pdf->SetFont('Arial','B',8);
      $pdf->Ln(3);
      $pdf->Cell(10,6,utf8_decode('N°'),1,0,'L');
      $pdf->Cell(70,6,utf8_decode('Cliente'),1,0,'L');
      $pdf->Cell(97,6,utf8_decode('Direccion de cobro'),1,0,'L');

      $current_y = $pdf->GetY();
      $current_x = $pdf->GetX();
      $cell_width = 12;
      $pdf->MultiCell(12,3,utf8_decode('Dia Cobro'),1,'C');
      $pdf->SetXY($current_x + $cell_width, $current_y);

      $current_y = $pdf->GetY();
      $current_x = $pdf->GetX();
      $cell_width = 13;
      $pdf->MultiCell(13,3,utf8_decode('Tipo Servicio'),1,'C');
      $pdf->SetXY($current_x + $cell_width, $current_y);

      $pdf->Cell(15,6,utf8_decode('Telefono'),1,0,'C');

      $current_y = $pdf->GetY();
      $current_x = $pdf->GetX();
      $cell_width = 15;
      $pdf->MultiCell(15,3,utf8_decode('Cuota de Servicio'),1,'C');
      $pdf->SetXY($current_x + $cell_width, $current_y);

      $current_y = $pdf->GetY();
      $current_x = $pdf->GetX();
      $cell_width = 15;
      $pdf->MultiCell(15,3,utf8_decode('F. Instalac.'),1,'C');
      $pdf->SetXY($current_x + $cell_width, $current_y);
      $pdf->Ln(5);
      */
/*
      $pdf->SetFont('Arial','',6);
      $fechaActualParaCondicion=date('Y-m-d');
*/
      
       while($row = $resultado->fetch_assoc()){
        $pdf->Ln(4);
        $pdf->SetFont('Arial','',6);
        $pdf->Cell(10,3,utf8_decode($contadorDeFilas),0,0,'L');
        $contadorDeFilas++;
        $pdf->SetFont('Arial','',5);
        $current_y = $pdf->GetY();
        $current_x = $pdf->GetX();
        $cell_width = 55;
        $pdf->MultiCell(55,3,utf8_decode(strtoupper(str_pad($row['cod_cliente'], 5, "0", STR_PAD_LEFT)."  ".$row['nombre'])),0,'L');
        $pdf->SetXY($current_x + $cell_width, $current_y);

        $current_y = $pdf->GetY();
        $current_x = $pdf->GetX();
        $cell_width = 97;
        $pdf->SetFont('Arial','',5);
        $pdf->MultiCell(97,2,utf8_decode($row['direccion_cobro']),0,'L');
        $pdf->SetXY($current_x + $cell_width, $current_y);

       
/*
        $pdf->Cell(26,3,utf8_decode($colonia->getColonia($row['id_colonia'])),0,0,'L');
*/
        $pdf->SetFont('Arial','',6);
        $tecnolog = $row['tecnologia'];
        $megas = $row['id_velocidad'];
             if ($megas =='0001') {
            $velocidad = "Transmision 4x4";
        }elseif ($megas =='0002') {
            $velocidad = "0.25";
        }elseif ($megas =='0003') {
            $velocidad = "0.50";
        }elseif ($megas =='0004') {
            $velocidad = "1";
        }elseif ($megas =='0005') {
            $velocidad = "2";
        }elseif ($megas =='0006') {
            $velocidad = "3";
        }elseif ($megas =='0007') {
            $velocidad = "4";
        }elseif ($megas =='0008') {
            $velocidad = "5";
        }elseif ($megas =='0009') {
            $velocidad = "6";
        }elseif ($megas =='0010') {
            $velocidad = "7";
        }elseif ($megas =='0011') {
            $velocidad = "8";
        }elseif ($megas =='0012') {
            $velocidad = "9";
        }elseif ($megas =='0013') {
            $velocidad = "10";
        }elseif ($megas =='0014') {
            $velocidad = "11";
        }elseif ($megas =='0015') {
            $velocidad = "12";
        }elseif ($megas =='0016') {
            $velocidad = "20";
        }elseif ($megas =='0017') {
            $velocidad = "15";
        }elseif ($megas =='0018') {
            $velocidad = "30";
        }elseif ($megas =='0019') {
            $velocidad = "50";
        }else{
            $velocidad = "0";
        }

        $sumartodo= $sumartodo + $velocidad;
        if ($tecnolog =='FTTH') {
            $sumarftth= $sumarftth + $velocidad;
        }elseif ($tecnolog =='INALAMBRICO') {
            $sumarinalam= $sumarinalam + $velocidad;
        }elseif ($tecnolog =='DOCSIS') {
            $sumardocsis= $sumardocsis + $velocidad;
        }
        $pdf->Cell(13,3,utf8_decode($velocidad).' Megas',0,0,'C');

        $current_y = $pdf->GetY();
        $current_x = $pdf->GetX();
        $cell_width = 15;
        $pdf->MultiCell(15,2,utf8_decode($row['telefonos']),0,'C');
        $pdf->SetXY($current_x + $cell_width, $current_y);

       
        $pdf->Ln(3);

        

       }
        $pdf->Ln(7);
        $pdf->SetFont('Arial','',10);
        //$totalgig = $sumari / 1000;
        /*
        $pdf->Cell(285,3,utf8_decode('Total megas vendidos FTTH '). $sumari. ' Megas',0,1,'C');
        $pdf->Ln(1);
        $pdf->Cell(300,3,utf8_decode('Total megas vendidos INALAMBRICO'). $sumari. ' Megas',0,0,'C');
        */
        $pdf->Cell(116,3,utf8_decode('FTTH'),0,0,'R');
        $pdf->Cell(48,3,utf8_decode($sumarftth).' Megas',0,1,'R');
        $pdf->Ln(1);
        $pdf->Cell(131,3,utf8_decode('INALAMBRICO'),0,0,'R');
        $pdf->Cell(33,3,utf8_decode($sumarinalam).' Megas',0,1,'R');
        $pdf->Ln(1);
        $pdf->Cell(141,3,utf8_decode('Total megas vendidos'),0,0,'R');
        $pdf->Cell(23,3,utf8_decode($sumartodo).' Megas',1,1,'R');
        $pdf->Ln(1);
        
        
             mysqli_close($mysqli);
             $pdf->Output();
  ?>