
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
$cobrador = $_POST['cobradorImp'];
$diaCobro = $_POST['diaImp'];
$fechaGenerada = $_POST['fechaImp'];
$tipoServicio = $_POST['tipoServicioImp'];
$tipoComprobante = $_POST['tipoComprobanteImp'];
$nDesde = $_POST['desdeImp'];
$nHasta = $_POST['hastaImp'];

//$codigo = $_GET['id'];

class FPDF1 extends FPDF
{
  /// cabezera
function Header(){
 
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
  $this->Cell(260,6,utf8_decode("INFORME DE FACTURACION GENERADA"),0,1,'C');
  $this->SetFont('Arial','',6);
  $this->Ln(2);

 putenv("LANG='es_ES.UTF-8'");
      setlocale(LC_ALL, 'es_ES.UTF-8');
      $this->SetFont('Arial','B',8);
      $this->Ln(3);
      $this->Cell(10,6,utf8_decode('N°'),1,0,'L');
      $this->Cell(55,6,utf8_decode('Cliente'),1,0,'L');
      $this->Cell(97,6,utf8_decode('Direccion'),1,0,'L');

      $this->Cell(24,6,utf8_decode('Fecha cobro'),1,0,'C');

      $this->Cell(15,6,utf8_decode('Servicio'),1,0,'C');
      $this->Cell(28,6,utf8_decode('N° Factura'),1,0,'C');
      $this->Cell(15,6,utf8_decode('Saldo'),1,0,'C');
      $this->Ln(8);


}
}
$contadorDeFilas=1;

$pdf = new FPDF1();
/*
$cobrador = 'todos';
$diaCobro = '26';
$fechaGenerada = '2020-09-26';
$tipoServicio = 'C';
$tipoComprobante = '2';
*/
/*
if (isset($_POST['desdeImp']) && isset($_POST['hastaImp'])) {
    $nDesde = $_POST['desdeImp'];
    $nHasta = $_POST['hastaImp'];

    switch ($cobrador) {
        case 'todos':
       if ($tipoServicio == 'T'){
            $query = "SELECT * FROM tbl_cargos WHERE SUBSTRING(fechaCobro, 9, 10) = '".$diaCobro."' AND fechaFactura = '".$fechaGenerada."' AND tipoFactura = '".$tipoComprobante."' AND numeroFactura BETWEEN '".$nDesde."' AND '".$nHasta."'";
            break;
             }
        
        default:
            $query = "SELECT * FROM tbl_cargos WHERE SUBSTRING(fechaCobro, 9, 10) = '".$diaCobro."' AND codigoCobrador = '".$cobrador."' AND fechaFactura = '".$fechaGenerada."' AND tipoFactura = '".$tipoComprobante."' AND tipoServicio = '".$tipoServicio."' AND numeroFactura BETWEEN '".$nDesde."' AND '".$nHasta."'";
            break;
            
    }
}
else {
    switch ($cobrador) {
        case 'todos':
       if ($tipoServicio == 'T'){
            $query = "SELECT * FROM tbl_cargos WHERE SUBSTRING(fechaCobro, 9, 10) = '".$diaCobro."' AND fechaFactura = '".$fechaGenerada."' AND tipoFactura = '".$tipoComprobante."'";
            break;
          }
        
        default:
            $query = "SELECT * FROM tbl_cargos WHERE SUBSTRING(fechaCobro, 9, 10) = '".$diaCobro."' AND codigoCobrador = '".$cobrador."' AND fechaFactura = '".$fechaGenerada."' AND tipoFactura = '".$tipoComprobante."' AND tipoServicio = '".$tipoServicio."'";
            break;
            
    }
}
*/
/*
var_dump($nDesde);
var_dump($nHasta);
*/
/// de momento no funciona la especificacion de rango de facturas
if (!empty($nDesde) && !empty($nHasta)){
    
    if ($cobrador == 'todos') {
      if ($tipoServicio == 'T') {
        $sql = "SELECT * FROM tbl_cargos WHERE SUBSTRING(fechaCobro, 9, 10) = '$diaCobro'  AND fechaFactura = '$fechaGenerada' AND tipoFactura ='$tipoComprobante' AND numeroFactura >= '$nDesde' AND numeroFactura <= '$nHasta'";
      }else{
        $sql = "SELECT * FROM tbl_cargos WHERE SUBSTRING(fechaCobro, 9, 10) = '$diaCobro'  AND fechaFactura = '$fechaGenerada' AND tipoFactura ='$tipoComprobante' AND tipoServicio = '$tipoServicio' AND numeroFactura BETWEEN '$nDesde' AND '$nHasta'";
      }
      ////// contrario a todos los cobradores
    }else{
      if ($tipoServicio == 'T') {
        $sql = "SELECT * FROM tbl_cargos WHERE SUBSTRING(fechaCobro, 9, 10) = '$diaCobro'  AND fechaFactura = '$fechaGenerada' AND tipoFactura ='$tipoComprobante' AND codigoCobrador = '$cobrador' AND numeroFactura >= '$nDesde' AND numeroFactura <= '$nHasta'";
      }else{
        $sql = "SELECT * FROM tbl_cargos WHERE SUBSTRING(fechaCobro, 9, 10) = '$diaCobro'  AND fechaFactura = '$fechaGenerada' AND tipoFactura ='$tipoComprobante' AND tipoServicio = '$tipoServicio' AND codigoCobrador = '$cobrador' AND numeroFactura BETWEEN '$nDesde' AND '$nHasta'";
      }

    }
/////// contrario a especificacion desde hasta de numero de facturas
}else{
  if ($cobrador == 'todos') {
      if ($tipoServicio == 'T') {
        $sql = "SELECT * FROM tbl_cargos WHERE SUBSTRING(fechaCobro, 9, 10) = '$diaCobro'  AND fechaFactura = '$fechaGenerada' AND tipoFactura ='$tipoComprobante'";
      }else{
        $sql = "SELECT * FROM tbl_cargos WHERE SUBSTRING(fechaCobro, 9, 10) = '$diaCobro'  AND fechaFactura = '$fechaGenerada' AND tipoFactura ='$tipoComprobante' AND tipoServicio = '$tipoServicio'";
      }
      ////// contrario a todos los cobradores
    }else{
      if ($tipoServicio == 'T') {
        $sql = "SELECT * FROM tbl_cargos WHERE SUBSTRING(fechaCobro, 9, 10) = '$diaCobro'  AND fechaFactura = '$fechaGenerada' AND tipoFactura ='$tipoComprobante' AND codigoCobrador = '$cobrador'";
      }else{
        $sql = "SELECT * FROM tbl_cargos WHERE SUBSTRING(fechaCobro, 9, 10) = '$diaCobro'  AND fechaFactura = '$fechaGenerada' AND tipoFactura ='$tipoComprobante' AND tipoServicio = '$tipoServicio' AND codigoCobrador = '$cobrador'";
      }

    }

}
/*
  $sql = "SELECT * FROM tbl_cargos WHERE SUBSTRING(fechaCobro, 9, 10) = '$diaCobro'  AND fechaFactura = '$fechaGenerada' AND tipoFactura ='$tipoComprobante' AND tipoServicio = '$tipoServicio'";
*/
 $resultado = $mysqli->query($sql);

/// orientacion de pagina P vertical L horizontal
$pdf->AddPage('L','Letter');


      date_default_timezone_set('America/El_Salvador');

        while ($row = $resultado->fetch_assoc()){
         $pdf->Ln(4);
        $pdf->SetFont('Arial','',6);
        $pdf->Cell(10,6,utf8_decode($contadorDeFilas),0,0,'L');
        $contadorDeFilas++;
        $pdf->SetFont('Arial','',5);
        $current_y = $pdf->GetY();
        $current_x = $pdf->GetX();
        $cell_width = 55;
        $pdf->MultiCell(55,6,utf8_decode(strtoupper(str_pad($row['codigoCliente'], 5, "0", STR_PAD_LEFT)."  ".$row['nombre'])),0,'L');
        $pdf->SetXY($current_x + $cell_width, $current_y);

        $current_y = $pdf->GetY();
        $current_x = $pdf->GetX();
        $cell_width = 97;
        $pdf->SetFont('Arial','',5);
        $pdf->MultiCell(97,2,utf8_decode($row['direccion']),0,'J');
        $pdf->SetXY($current_x + $cell_width, $current_y);
      
        $pdf->SetFont('Arial','',6);
        $pdf->Cell(24,6,utf8_decode($row['fechaCobro']),0,0,'C');
        $pdf->Cell(13,6,utf8_decode($row['tipoServicio']),0,0,'C');

        $current_y = $pdf->GetY();
        $current_x = $pdf->GetX();
        $cell_width = 28;
        $pdf->MultiCell(28,6,utf8_decode($row['numeroFactura']),0,'C');
        $pdf->SetXY($current_x + $cell_width, $current_y);
        ////// consulta de saldo y seleccion del tipo de servicio
if ($row['tipoServicio']=='I') {
  if ($row['saldoInternet'] =='0') {
    $pdf->Cell(15,6,utf8_decode('$'.$row['cuotaInternet']),0,0,'C');
  }else{
    $pdf->Cell(15,6,utf8_decode('Cancelada'),0,0,'C');
  }
  ////////////////// consulta de saldo en factura
}elseif ($row['tipoServicio']=='C') {
  if ($row['saldoCable'] =='0') {
    $pdf->Cell(15,6,utf8_decode('$'.$row['cuotaCable']),0,0,'C');
  }else{
    $pdf->Cell(15,6,utf8_decode('Cancelada'),0,0,'C');
  }
}
        

        
        $pdf->Ln(4);
        

       }
        $pdf->Ln(7);
        $pdf->SetFont('Arial','',10);
 
        
             mysqli_close($mysqli);
             $pdf->Output();
  ?>