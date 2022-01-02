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

$tiporeporte = $_POST['tiporeporte'];
$nDesde = $_POST['lDesde'];
$nHasta = $_POST['lHasta'];

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

  $this->Cell(200,6,utf8_decode("REPORTE DE ORDENES"),0,1,'C');
  $this->SetFont('Arial','',6);
  $this->Ln(2);

 putenv("LANG='es_ES.UTF-8'");
      setlocale(LC_ALL, 'es_ES.UTF-8');
      $this->SetFont('Arial','B',6);
      $this->Ln(3);
      $this->Cell(20,6,utf8_decode('FECHA ORDEN'),1,0,'L');
      $this->Cell(25,6,utf8_decode('NUMERO DE ORDEN'),1,0,'L');
      $this->Cell(20,6,utf8_decode('CODIGO CLIENTE'),1,0,'L');

      $this->Cell(115,6,utf8_decode('NOMBRE'),1,0,'C');

      $this->Cell(20,6,utf8_decode('HORA ORDEN'),1,0,'C');

      $this->Ln(8);

}

}
$contadorDeFilas=1;

$pdf = new FPDF1();
if (!empty($nDesde) && !empty($nHasta)){
  if ($tiporeporte==1) {
  $query = "SELECT * FROM tbl_ordenes_trabajo WHERE fechaOrdenTrabajo BETWEEN '$nDesde' AND '$nHasta' AND checksoporte=1 ORDER BY idOrdenTrabajo ASC";
  $resultado = $mysqli->query($query);
}elseif ($tiporeporte==2) {
   $query = "SELECT * FROM tbl_ordenes_trabajo WHERE fechaOrdenTrabajo BETWEEN '$nDesde' AND '$nHasta' AND checksoporte=2 ORDER BY idOrdenTrabajo ASC";
  $resultado = $mysqli->query($query);
}else{
  $query = "SELECT * FROM tbl_ordenes_trabajo WHERE fechaOrdenTrabajo BETWEEN '$nDesde' AND '$nHasta' AND checksoporte=3 ORDER BY idOrdenTrabajo ASC";
  $resultado = $mysqli->query($query);
}

  }else{

if ($tiporeporte==1) {
  $query = "SELECT * FROM tbl_ordenes_trabajo WHERE checksoporte=1 ORDER BY idOrdenTrabajo ASC";
  $resultado = $mysqli->query($query);
}elseif ($tiporeporte==2) {
   $query = "SELECT * FROM tbl_ordenes_trabajo WHERE checksoporte=2 ORDER BY idOrdenTrabajo ASC";
  $resultado = $mysqli->query($query);
}else{
  $query = "SELECT * FROM tbl_ordenes_trabajo WHERE checksoporte=3 ORDER BY idOrdenTrabajo ASC";
  $resultado = $mysqli->query($query);
}

  }


  /*
if ($tiporeporte==1) {
  $query = "SELECT * FROM tbl_ordenes_trabajo WHERE checksoporte=1 ORDER BY idOrdenTrabajo ASC";
  $resultado = $mysqli->query($query);
}elseif ($tiporeporte==2) {
   $query = "SELECT * FROM tbl_ordenes_trabajo WHERE checksoporte=2 ORDER BY idOrdenTrabajo ASC";
  $resultado = $mysqli->query($query);
}else{
  $query = "SELECT * FROM tbl_ordenes_trabajo WHERE checksoporte=3 ORDER BY idOrdenTrabajo ASC";
  $resultado = $mysqli->query($query);
}
*/
/// orientacion de pagina P vertical L horizontal
$pdf->AddPage('P','Letter');


      date_default_timezone_set('America/El_Salvador');
      
       while($row = $resultado->fetch_assoc()){
        $pdf->Ln(2);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(25,3,utf8_decode($contadorDeFilas."-".$row['fechaOrdenTrabajo']),0,0,'L');
        $contadorDeFilas++;
        $pdf->Cell(25,3,utf8_decode($row['idOrdenTrabajo']),0,0,'L');
        $pdf->Cell(20,3,utf8_decode(str_pad($row['codigoCliente'], 5, "0", STR_PAD_LEFT)),0,0,'L');
        $pdf->Cell(112,3,utf8_decode($row['nombreCliente']),0,0,'L');
        $pdf->Cell(20,3,utf8_decode($row['hora']),0,1,'L');
        $pdf->Ln(1.5);
        $pdf->Cell(200,3,utf8_decode("Descripcion: ".$row['actividadInter']),0,1,'L');
        $pdf->Ln(1.5);
        $pdf->Cell(200,3,utf8_decode("Observaciones: ".$row['observaciones']),0,1,'L');
        $pdf->Cell(200,3,utf8_decode(''),'B',1,'C');
        $pdf->Ln(2);
       }
        $pdf->Ln(1);
        
        
             mysqli_close($mysqli);
             $pdf->Output();
  ?>