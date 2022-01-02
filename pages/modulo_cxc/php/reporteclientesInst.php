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

$desde = $_POST['lDesde'];
$hasta = $_POST['lHasta'];
$tipoServicio = $_POST['lServicio'];

class FPDF1 extends FPDF
{
  /// cabezera
function Header(){


  global $desde, $hasta, $tipoServicio;

  $this->SetFont('Arial','',6);
  $this->Cell(260,3,utf8_decode("Página ".str_pad($this->pageNo(),4,"0",STR_PAD_LEFT)),0,1,'R');
  $this->Ln(0);
  date_default_timezone_set('America/El_Salvador');
 $this->Cell(260,4,utf8_decode("GENERADO POR: ".strtoupper($_SESSION['nombres'])." ".strtoupper($_SESSION['apellidos']). " ".date('d/m/Y h:i:s')),"",1,'R');
  $this->SetFont('Arial','B',12);
  $this->Cell(260,3,utf8_decode("CABLE VISION POR SATELITE, S.A DE C.V "),0,1,'C');
  $this->Image('../../../images/logo.png',10,10, 20, 18);

  $this->Ln(1);
  $this->SetFont('Arial','',8);
  $this->Cell(260,6,utf8_decode("INFORME GENERAL DE CLIENTES CON SERVICIO DE ".$tipoServicio." DESDE FECHA ".$desde." HASTA ".$hasta),0,1,'C');
  $this->SetFont('Arial','',6);
  $this->Ln(2);

  putenv("LANG='es_ES.UTF-8'");
      setlocale(LC_ALL, 'es_ES.UTF-8');
      $this->SetFont('Arial','B',8);
      $this->Ln(3);
      $this->Cell(10,6,utf8_decode('N°'),1,0,'L');
      $this->Cell(70,6,utf8_decode('Cliente'),1,0,'L');
      $this->Cell(97,6,utf8_decode('Direccion de cobro'),1,0,'L');

      $current_y = $this->GetY();
      $current_x = $this->GetX();
      $cell_width = 12;
      $this->MultiCell(12,3,utf8_decode('Dia Cobro'),1,'C');
      $this->SetXY($current_x + $cell_width, $current_y);

      $current_y = $this->GetY();
      $current_x = $this->GetX();
      $cell_width = 13;
      $this->MultiCell(13,3,utf8_decode('Tipo Servicio'),1,'C');
      $this->SetXY($current_x + $cell_width, $current_y);

      $this->Cell(15,6,utf8_decode('Telefono'),1,0,'C');

      $current_y = $this->GetY();
      $current_x = $this->GetX();
      $cell_width = 15;
      $this->MultiCell(15,3,utf8_decode('Cuota de Servicio'),1,'C');
      $this->SetXY($current_x + $cell_width, $current_y);

      $current_y = $this->GetY();
      $current_x = $this->GetX();
      $cell_width = 15;
      $this->MultiCell(15,3,utf8_decode('F. Instalac.'),1,'C');
      $this->SetXY($current_x + $cell_width, $current_y);
      $this->Ln(10);

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
if ($tipoServicio == "CABLE TV") {
  $query = "SELECT * FROM clientes WHERE (servicio_suspendido='F' or servicio_suspendido is null or servicio_suspendido='') AND sin_servicio='F' AND estado_cliente_in = 3 AND fecha_instalacion BETWEEN '$desde' AND '$hasta' ORDER BY fecha_instalacion ASC ";
  $resultado = $mysqli->query($query);

} elseif ($tipoServicio == "INTERNET") {
  $query = "SELECT * FROM clientes WHERE (servicio_suspendido='F' or servicio_suspendido is null or servicio_suspendido='') and sin_servicio='T' AND estado_cliente_in = 1 AND fecha_instalacion_in BETWEEN '$desde' AND '$hasta' ORDER BY fecha_instalacion ASC";
  $resultado = $mysqli->query($query);

} elseif ($tipoServicio == "PAQUETE") {
  $query = "SELECT * FROM clientes WHERE (servicio_suspendido='F' or servicio_suspendido is null or servicio_suspendido='') and sin_servicio='F' AND estado_cliente_in = 1 AND fecha_instalacion_in BETWEEN '$desde' AND '$hasta' AND fecha_instalacion BETWEEN '$desde' AND '$hasta' ORDER BY fecha_instalacion ASC";
  $resultado = $mysqli->query($query);
}


$pdf->AddPage('L','Letter');
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
        $cell_width = 70;
        $pdf->MultiCell(70,3,utf8_decode(strtoupper(str_pad($row['cod_cliente'], 5, "0", STR_PAD_LEFT)."  ".$row['nombre'])),0,'L');
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
if ($tipoServicio == "CABLE TV") {
  $cobro = $row['valor_cuota'];
  $fecha_instalacion = $row['fecha_instalacion'];
  
} elseif ($tipoServicio == "INTERNET") {
  $cobro = $row['cuota_in'];
  $fecha_instalacion = $row['fecha_instalacion_in'];

} elseif ($tipoServicio == "PAQUETE") {
  $cobro = $row['valor_cuota'] + $row['cuota_in'];
  $fecha_instalacion = $row['fecha_instalacion_in'];
}

        $pdf->SetFont('Arial','',6);
        $pdf->Cell(12,3,utf8_decode($row['dia_cobro']),0,0,'C');
        $pdf->Cell(13,3,utf8_decode($tipoServicio),0,0,'C');

        $current_y = $pdf->GetY();
        $current_x = $pdf->GetX();
        $cell_width = 15;
        $pdf->MultiCell(15,2,utf8_decode($row['telefonos']),0,'C');
        $pdf->SetXY($current_x + $cell_width, $current_y);

        $pdf->Cell(15,3,utf8_decode($cobro),0,0,'C');

        $pdf->Cell(15,3,utf8_decode($fecha_instalacion),0,0,'C');
        $pdf->Ln(3);

       }


       $pdf->Output();
  ?>