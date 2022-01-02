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
//$nDesde = $_POST['lDesde'];
//$nHasta = $_POST['lHasta'];
$fpendiente =$_POST['fpendiente'];
$cobrador = $_POST['susCobrador'];
//var_dump($cobrador);
//$codigo = $_GET['id'];
if ($cobrador != 'todos') {
  $sql = "SELECT nombreCobrador FROM tbl_cobradores WHERE codigoCobrador='$cobrador'";
$resultado = $mysqli->query($sql);
while ($row = $resultado->fetch_assoc()){
  $nombreCobrador = $row['nombreCobrador'];
}
}else{
  $nombreCobrador = 'TODOS LOS COBRADORES';
}


$pdf = new FPDF();
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
  $pdf->Cell(260,6,utf8_decode("INFORME DE FACTURACION PENDIENTE"),0,1,'C');
  if ($tipoServicio == 'C') {
    $servicio = 'CABLE TV';
  }elseif ($tipoServicio == 'I'){
    $servicio = 'INTERNET';
  }elseif ($tipoServicio == 'T'){
    $servicio = 'CABLE E INTERNET';
  }elseif ($tipoServicio == 'A') {
    $servicio = 'TODOS LOS SERVICIOS';
  }
  $pdf->Cell(260,6,utf8_decode("SERVICIO: ".$servicio),0,1,'C');
  $pdf->Cell(260,6,utf8_decode("COBRADOR: ".$nombreCobrador),0,1,'C');
  $pdf->SetFont('Arial','',6);
  $pdf->Ln(1);

 putenv("LANG='es_ES.UTF-8'");
      setlocale(LC_ALL, 'es_ES.UTF-8');
      $pdf->SetFont('Arial','B',8);
      $pdf->Ln(1);
      $pdf->Cell(10,6,utf8_decode('N°'),1,0,'L');
      $pdf->Cell(50,6,utf8_decode('Cliente'),1,0,'L');
      $pdf->Cell(80,6,utf8_decode('Direccion de cobro'),1,0,'L');

      $pdf->Cell(26,6,utf8_decode('Colonia'),1,0,'L');

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
      $pdf->MultiCell(15,3,utf8_decode('Ult. mes pagado'),1,'C');
      $pdf->SetXY($current_x + $cell_width, $current_y);

      $current_y = $pdf->GetY();
      $current_x = $pdf->GetX();
      $cell_width = 12;
      $pdf->MultiCell(12,3,utf8_decode('# Ctas. Ptes.'),1,'C');
      $pdf->SetXY($current_x + $cell_width, $current_y);

      $pdf->Cell(15,6,utf8_decode('SaldoC'),1,0,'C');
      $pdf->Cell(15,6,utf8_decode('SaldoI'),1,0,'C');
      $pdf->Ln(6);
      $pdf->SetFont('Arial','',6);
      $pdf->Ln(1);



$contadorDeFilas=1;
$counter1=1;
if ($cobrador == 'todos') {
 ////////////////////////
 //////////////////////// 
if ($tipoServicio == 'T') {
        $sql1 = "SELECT tbl_cargos.codigoCliente, COUNT(tbl_cargos.codigoCliente) FROM tbl_cargos, clientes WHERE (clientes.servicio_suspendido='F' OR clientes.servicio_suspendido is null)  AND clientes.sin_servicio='F' AND clientes.estado_cliente_in = 1 AND tbl_cargos.fechaFactura >= now()-interval '$fpendiente' month AND tbl_cargos.estado='pendiente' and tbl_cargos.anulada='0' AND tbl_cargos.codigoCliente=clientes.cod_cliente GROUP by tbl_cargos.codigoCliente HAVING COUNT(*)>=2";

$resultado1 = $mysqli->query($sql1);
 while ($row1 = $resultado1->fetch_assoc()){
  //var_dump($row1['codigoCliente']);
         $codigoValido = $row1['codigoCliente'];

  if ($row1['codigoCliente'] >= '2') {
    $codigoValido = $row1['codigoCliente'];
    }
   // var_dump($codigoValido);
 $sqlf = "SELECT tbl_cargos.codigoCliente as codigoCliente/*, COUNT(tbl_cargos.codigoCliente) AS fpendientes*/, tbl_cargos.nombre, tbl_cargos.direccion, tbl_cargos.tipoServicio/*,MAX(tbl_cargos.mesCargo) AS ult_mes,*/, SUM(tbl_cargos.cuotaCable + tbl_cargos.totalImpuesto) AS totalC, SUM(tbl_cargos.cuotaInternet + tbl_cargos.totalImpuesto) AS totalI , clientes.dia_cobro, clientes.dia_corbo_in, tbl_cargos.fechaVencimiento, tbl_colonias_cxc.nombreColonia, clientes.telefonos FROM tbl_cargos, clientes, tbl_colonias_cxc WHERE tbl_cargos.fechaFactura >= now()-interval '$fpendiente' month AND tbl_cargos.estado='pendiente' and tbl_cargos.anulada='0' AND clientes.cod_cliente=tbl_cargos.codigoCliente AND tbl_colonias_cxc.idColonia=clientes.id_colonia AND tbl_cargos.codigoCliente= '$codigoValido' group by tbl_cargos.codigoCliente";
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
        $cell_width = 80;
        $pdf->SetFont('Arial','',5);
        $pdf->MultiCell(80,2,utf8_decode($row['direccion']),0,'J');
        $pdf->SetXY($current_x + $cell_width, $current_y);
        $current_y = $pdf->GetY();
        $current_x = $pdf->GetX();
        $cell_width = 26;
        $pdf->SetFont('Arial','',5);
        $pdf->MultiCell(26,2,utf8_decode($row['nombreColonia']),0,'C');
        $pdf->SetXY($current_x + $cell_width, $current_y);
        if ($row['tipoServicio']=='C') {
        $pdf->Cell(12,6,utf8_decode($row['dia_cobro']),0,0,'C');
        ////////////////// consulta de saldo en factura
        }elseif ($row['tipoServicio']=='I') {
        $pdf->Cell(12,6,utf8_decode($row['dia_corbo_in']),0,0,'C');
        }
        $pdf->Cell(13,6,utf8_decode('C+I'),0,0,'C');
        $current_y = $pdf->GetY();
        $current_x = $pdf->GetX();
        $cell_width = 15;
        $pdf->MultiCell(15,2,utf8_decode($row['telefonos']),0,'C');
        $pdf->SetXY($current_x + $cell_width, $current_y);
        $sql3 = "SELECT MAX(mesCargo) AS ult_mes FROM tbl_abonos WHERE codigoCliente= '$codigoValido'";
        $resultado3 = $mysqli->query($sql3);
        while($row3 = $resultado3->fetch_assoc())
        {
        $pdf->Cell(15,6,utf8_decode($row3['ult_mes']),0,0,'C');
        }
        $current_y = $pdf->GetY();
        $current_x = $pdf->GetX();
        $cell_width = 12;
        $sql2 = "SELECT COUNT(codigoCliente) AS fpendientes FROM tbl_cargos WHERE estado='pendiente' and anulada='0' AND codigoCliente= '$codigoValido'";
        $resultado2 = $mysqli->query($sql2);
        while($row2 = $resultado2->fetch_assoc())
      {
        $pdf->Cell(12,6,utf8_decode($row2['fpendientes']),0,0,'C');
      }
      $sql3 = "SELECT SUM(cuotaCable + totalImpuesto) AS totalC FROM tbl_cargos WHERE estado='pendiente' and anulada='0' AND cuotaCable !='0' AND codigoCliente= '$codigoValido'";
        $resultado3 = $mysqli->query($sql3);
        while($row3 = $resultado3->fetch_assoc())
      {
        $totalizacionC = $row3['totalC'];
        
      }
      $sql4 = "SELECT SUM(cuotaInternet + totalImpuesto) AS totalI FROM tbl_cargos WHERE estado='pendiente' and anulada='0' AND cuotaInternet !='0' AND codigoCliente= '$codigoValido'";
        $resultado4 = $mysqli->query($sql4);
        while($row4 = $resultado4->fetch_assoc())
      {
       
        $totalizacionI = $row4['totalI'];
      }
        $pdf->SetXY($current_x + $cell_width, $current_y);
        $pdf->Cell(15,6,'$'.number_format($totalizacionC,2),0,0,'C');
        $pdf->Cell(15,6,'$'.number_format($totalizacionI,2),0,0,'C');
        
        $pdf->Ln(4);
        
$counter1++;
       }
       if ($counter1 > 16){
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
  $pdf->Cell(260,6,utf8_decode("INFORME DE FACTURACION PENDIENTE"),0,1,'C');
  if ($tipoServicio == 'C') {
    $servicio = 'CABLE TV';
  }elseif ($tipoServicio == 'I'){
    $servicio = 'INTERNET';
  }elseif ($tipoServicio == 'T'){
    $servicio = 'CABLE E INTERNET';
  }elseif ($tipoServicio == 'A') {
    $servicio = 'TODOS LOS SERVICIOS';
  }
  
  $pdf->Cell(260,6,utf8_decode("SERVICIO: ".$servicio),0,1,'C');
  $pdf->Cell(260,6,utf8_decode("COBRADOR: ".$nombreCobrador),0,1,'C');
  $pdf->SetFont('Arial','',6);
  $pdf->Ln(1);

  putenv("LANG='es_ES.UTF-8'");
      setlocale(LC_ALL, 'es_ES.UTF-8');
      $pdf->SetFont('Arial','B',8);
      $pdf->Ln(1);
      $pdf->Cell(10,6,utf8_decode('N°'),1,0,'L');
      $pdf->Cell(50,6,utf8_decode('Cliente'),1,0,'L');
      $pdf->Cell(80,6,utf8_decode('Direccion de cobro'),1,0,'L');

      $pdf->Cell(26,6,utf8_decode('Colonia'),1,0,'L');

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
      $pdf->MultiCell(15,3,utf8_decode('Ult. mes pagado'),1,'C');
      $pdf->SetXY($current_x + $cell_width, $current_y);

      $current_y = $pdf->GetY();
      $current_x = $pdf->GetX();
      $cell_width = 12;
      $pdf->MultiCell(12,3,utf8_decode('# Ctas. Ptes.'),1,'C');
      $pdf->SetXY($current_x + $cell_width, $current_y);

      $pdf->Cell(15,6,utf8_decode('SaldoC'),1,0,'C');
      $pdf->Cell(15,6,utf8_decode('SaldoI'),1,0,'C');
      $pdf->Ln(6);
      $pdf->SetFont('Arial','',6);
      $pdf->Ln(1);
        $counter1=1;
       }
        
       }
        //////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////
}
else {
  switch ($tipoServicio) {
    case 'C':
      $sql1 = "SELECT tbl_cargos.codigoCliente, COUNT(tbl_cargos.codigoCliente) FROM tbl_cargos, clientes WHERE (clientes.servicio_suspendido='F' OR clientes.servicio_suspendido is null)  AND clientes.sin_servicio='F' AND clientes.estado_cliente_in = 3 AND tbl_cargos.fechaFactura >= now()-interval '$fpendiente' month AND tbl_cargos.estado='pendiente' and tbl_cargos.anulada='0' AND tbl_cargos.codigoCliente=clientes.cod_cliente GROUP by tbl_cargos.codigoCliente HAVING COUNT(*)>=1";
      break;
    
     case 'I':
      $sql1 = "SELECT tbl_cargos.codigoCliente, COUNT(tbl_cargos.codigoCliente) FROM tbl_cargos, clientes WHERE (clientes.servicio_suspendido='F' or clientes.servicio_suspendido is null or clientes.servicio_suspendido='') and clientes.sin_servicio='T' AND clientes.estado_cliente_in = 1 AND tbl_cargos.fechaFactura >= now()-interval '$fpendiente' month AND tbl_cargos.estado='pendiente' and tbl_cargos.anulada='0' AND tbl_cargos.codigoCliente=clientes.cod_cliente GROUP by tbl_cargos.codigoCliente HAVING COUNT(*)>=1";
      break;
      case 'A':
      $sql1 = "SELECT tbl_cargos.codigoCliente, COUNT(tbl_cargos.codigoCliente) FROM tbl_cargos, clientes WHERE (clientes.servicio_suspendido='F' or clientes.servicio_suspendido is null or clientes.servicio_suspendido='') AND clientes.sin_servicio='F' AND clientes.estado_cliente_in = 3 OR (clientes.servicio_suspendido='F' or clientes.servicio_suspendido is null or clientes.servicio_suspendido='') and clientes.sin_servicio='T' AND clientes.estado_cliente_in = 1 OR (clientes.servicio_suspendido='F' or clientes.servicio_suspendido is null or clientes.servicio_suspendido='') and clientes.sin_servicio='F' AND clientes.estado_cliente_in = 1 AND tbl_cargos.fechaFactura >= now()-interval '$fpendiente' month AND tbl_cargos.estado='pendiente' and tbl_cargos.anulada='0' AND tbl_cargos.codigoCliente=clientes.cod_cliente GROUP by tbl_cargos.codigoCliente HAVING COUNT(*)>=1";
        break;
  }
      
$resultado1 = $mysqli->query($sql1);
 while ($row1 = $resultado1->fetch_assoc()){
  //var_dump($row1['codigoCliente']);
  if ($row1['codigoCliente'] >= '1') {
    $codigoValido = $row1['codigoCliente'];
    }
   // var_dump($codigoValido);
 $sql = "SELECT tbl_cargos.codigoCliente as codigoCliente/*, COUNT(tbl_cargos.codigoCliente) AS fpendientes*/, tbl_cargos.nombre, tbl_cargos.direccion, tbl_cargos.tipoServicio/*,MAX(tbl_cargos.mesCargo) AS ult_mes,*/, SUM(tbl_cargos.cuotaCable + tbl_cargos.totalImpuesto) AS totalC, SUM(tbl_cargos.cuotaInternet + tbl_cargos.totalImpuesto) AS totalI , clientes.dia_cobro, clientes.dia_corbo_in, tbl_cargos.fechaVencimiento, tbl_colonias_cxc.nombreColonia, clientes.telefonos FROM tbl_cargos, clientes, tbl_colonias_cxc WHERE tbl_cargos.fechaFactura >= now()-interval '$fpendiente' month AND tbl_cargos.estado='pendiente' and tbl_cargos.anulada='0' AND clientes.cod_cliente=tbl_cargos.codigoCliente AND tbl_colonias_cxc.idColonia=clientes.id_colonia AND tbl_cargos.codigoCliente= '$codigoValido' group by tbl_cargos.codigoCliente";
 $resultado = $mysqli->query($sql);
/// orientacion de pagina P vertical L horizontal

      date_default_timezone_set('America/El_Salvador');

        while($row = $resultado->fetch_assoc())
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
        $cell_width = 80;
        $pdf->SetFont('Arial','',5);
        $pdf->MultiCell(80,2,utf8_decode($row['direccion']),0,'J');
        $pdf->SetXY($current_x + $cell_width, $current_y);
        $current_y = $pdf->GetY();
        $current_x = $pdf->GetX();
        $cell_width = 26;
        $pdf->SetFont('Arial','',5);
        $pdf->MultiCell(26,2,utf8_decode($row['nombreColonia']),0,'C');
        $pdf->SetXY($current_x + $cell_width, $current_y);
        if ($row['tipoServicio']=='C') {
        $pdf->Cell(12,6,utf8_decode($row['dia_cobro']),0,0,'C');
        ////////////////// consulta de saldo en factura
        }elseif ($row['tipoServicio']=='I') {
        $pdf->Cell(12,6,utf8_decode($row['dia_corbo_in']),0,0,'C');
        }

        if (!empty($row['totalC']) && !empty($row['totalI'])){
             $pdf->Cell(13,6,utf8_decode('C+I'),0,0,'C');
        }elseif (empty($row['totalC']) && !empty($row['totalI'])){
             $pdf->Cell(13,6,utf8_decode('I'),0,0,'C');
        }elseif (!empty($row['totalC']) && empty($row['totalI'])){
             $pdf->Cell(13,6,utf8_decode('C'),0,0,'C');
        }else{
             $pdf->Cell(13,6,utf8_decode('Error'),0,0,'C');
        }
/*
        switch ($tipoServicio) {
          case 'A':
            $pdf->Cell(13,6,utf8_decode('T'),0,0,'C');
            break;
          
          case 'C':
            $pdf->Cell(13,6,utf8_decode('C'),0,0,'C');
            break;

          case 'I':
            $pdf->Cell(13,6,utf8_decode('I'),0,0,'C');
            break;
        }
*/
        $current_y = $pdf->GetY();
        $current_x = $pdf->GetX();
        $cell_width = 15;
        $pdf->MultiCell(15,2,utf8_decode($row['telefonos']),0,'C');
        $pdf->SetXY($current_x + $cell_width, $current_y);
        $sql3 = "SELECT MAX(mesCargo) AS ult_mes FROM tbl_abonos WHERE codigoCliente= '$codigoValido'";
        $resultado3 = $mysqli->query($sql3);
        while($row3 = $resultado3->fetch_assoc())
        {
        $pdf->Cell(15,6,utf8_decode($row3['ult_mes']),0,0,'C');
        }
        $sql2 = "SELECT COUNT(codigoCliente) AS fpendientes FROM tbl_cargos WHERE estado='pendiente' and anulada='0' AND codigoCliente= '$codigoValido'";
        $resultado2 = $mysqli->query($sql2);
        while($row2 = $resultado2->fetch_assoc())
      {
        $pdf->Cell(12,6,utf8_decode($row2['fpendientes']),0,0,'C');
      }
        $sql3 = "SELECT SUM(cuotaCable + totalImpuesto) AS totalC FROM tbl_cargos WHERE estado='pendiente' and anulada='0' AND cuotaCable !='0' AND codigoCliente= '$codigoValido'";
        $resultado3 = $mysqli->query($sql3);
        while($row3 = $resultado3->fetch_assoc())
      {
        $totalizacionC = $row3['totalC'];
        
      }
      $sql4 = "SELECT SUM(cuotaInternet + totalImpuesto) AS totalI FROM tbl_cargos WHERE estado='pendiente' and anulada='0' AND cuotaInternet !='0' AND codigoCliente= '$codigoValido'";
        $resultado4 = $mysqli->query($sql4);
        while($row4 = $resultado4->fetch_assoc())
      {
       
        $totalizacionI = $row4['totalI'];
      }
        
        $pdf->Cell(15,6,'$'.number_format($totalizacionC,2),0,0,'C');
        $pdf->Cell(15,6,'$'.number_format($totalizacionI,2),0,0,'C');
        

        
        $pdf->Ln(4);
        
$counter1++;
       }
       if ($counter1 > 18){
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
  $pdf->Cell(260,6,utf8_decode("INFORME DE FACTURACION PENDIENTE"),0,1,'C');
  if ($tipoServicio == 'C') {
    $servicio = 'CABLE TV';
  }elseif ($tipoServicio == 'I'){
    $servicio = 'INTERNET';
  }elseif ($tipoServicio == 'T'){
    $servicio = 'CABLE E INTERNET';
  }elseif ($tipoServicio == 'A') {
    $servicio = 'TODOS LOS SERVICIOS';
  }
  
  $pdf->Cell(260,6,utf8_decode("SERVICIO: ".$servicio),0,1,'C');
  $pdf->Cell(260,6,utf8_decode("COBRADOR: ".$nombreCobrador),0,1,'C');
  $pdf->SetFont('Arial','',6);
  $pdf->Ln(1);

  putenv("LANG='es_ES.UTF-8'");
      setlocale(LC_ALL, 'es_ES.UTF-8');
      $pdf->SetFont('Arial','B',8);
      $pdf->Ln(1);
      $pdf->Cell(10,6,utf8_decode('N°'),1,0,'L');
      $pdf->Cell(50,6,utf8_decode('Cliente'),1,0,'L');
      $pdf->Cell(80,6,utf8_decode('Direccion de cobro'),1,0,'L');

      $pdf->Cell(26,6,utf8_decode('Colonia'),1,0,'L');

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
      $pdf->MultiCell(15,3,utf8_decode('Ult. mes pagado'),1,'C');
      $pdf->SetXY($current_x + $cell_width, $current_y);

      $current_y = $pdf->GetY();
      $current_x = $pdf->GetX();
      $cell_width = 12;
      $pdf->MultiCell(12,3,utf8_decode('# Ctas. Ptes.'),1,'C');
      $pdf->SetXY($current_x + $cell_width, $current_y);

      $pdf->Cell(15,6,utf8_decode('SaldoC'),1,0,'C');
      $pdf->Cell(15,6,utf8_decode('SaldoI'),1,0,'C');
      $pdf->Ln(6);
      $pdf->SetFont('Arial','',6);
      $pdf->Ln(1);
        $counter1=1;
       }
       
       }
        //////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////
}
///////////////////////////
//////////////////////////
}else{
 
if ($tipoServicio == 'T') {
        $sql1 = "SELECT tbl_cargos.codigoCliente, COUNT(tbl_cargos.codigoCliente) FROM tbl_cargos, clientes WHERE (clientes.servicio_suspendido='F' OR clientes.servicio_suspendido is null)  AND clientes.sin_servicio='F' AND clientes.estado_cliente_in = 1 AND tbl_cargos.fechaFactura >= now()-interval '$fpendiente' month AND tbl_cargos.estado='pendiente' and tbl_cargos.anulada='0' AND tbl_cargos.codigoCobrador='$cobrador' AND tbl_cargos.codigoCliente=clientes.cod_cliente GROUP by tbl_cargos.codigoCliente HAVING COUNT(*)>=2";

$resultado1 = $mysqli->query($sql1);
 while ($row1 = $resultado1->fetch_assoc()){
  //var_dump($row1['codigoCliente']);
  if ($row1['codigoCliente'] >= '2') {
    $codigoValido = $row1['codigoCliente'];
    }
   // var_dump($codigoValido);
 $sql = "SELECT tbl_cargos.codigoCliente as codigoCliente/*, COUNT(tbl_cargos.codigoCliente) AS fpendientes*/, tbl_cargos.nombre, tbl_cargos.direccion, tbl_cargos.tipoServicio/*,MAX(tbl_cargos.mesCargo) AS ult_mes,*/, SUM(tbl_cargos.cuotaCable + tbl_cargos.totalImpuesto) AS totalC, SUM(tbl_cargos.cuotaInternet + tbl_cargos.totalImpuesto) AS totalI , clientes.dia_cobro, clientes.dia_corbo_in, tbl_cargos.fechaVencimiento, tbl_colonias_cxc.nombreColonia, clientes.telefonos FROM tbl_cargos, clientes, tbl_colonias_cxc WHERE tbl_cargos.fechaFactura >= now()-interval '$fpendiente' month AND tbl_cargos.estado='pendiente' and tbl_cargos.anulada='0' AND tbl_cargos.codigoCobrador='$cobrador' AND clientes.cod_cliente=tbl_cargos.codigoCliente AND tbl_colonias_cxc.idColonia=clientes.id_colonia AND tbl_cargos.codigoCliente= '$codigoValido' group by tbl_cargos.codigoCliente";
 $resultado = $mysqli->query($sql);
/// orientacion de pagina P vertical L horizontal
      date_default_timezone_set('America/El_Salvador');

        while($row = $resultado->fetch_assoc())
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
        $cell_width = 80;
        $pdf->SetFont('Arial','',5);
        $pdf->MultiCell(80,2,utf8_decode($row['direccion']),0,'J');
        $pdf->SetXY($current_x + $cell_width, $current_y);
        $current_y = $pdf->GetY();
        $current_x = $pdf->GetX();
        $cell_width = 26;
        $pdf->SetFont('Arial','',5);
        $pdf->MultiCell(26,2,utf8_decode($row['nombreColonia']),0,'C');
        $pdf->SetXY($current_x + $cell_width, $current_y);
        if ($row['tipoServicio']=='C') {
        $pdf->Cell(12,6,utf8_decode($row['dia_cobro']),0,0,'C');
        ////////////////// consulta de saldo en factura
        }elseif ($row['tipoServicio']=='I') {
        $pdf->Cell(12,6,utf8_decode($row['dia_corbo_in']),0,0,'C');
        }
        $pdf->Cell(13,6,utf8_decode('C+I'),0,0,'C');
        $current_y = $pdf->GetY();
        $current_x = $pdf->GetX();
        $cell_width = 15;
        $pdf->MultiCell(15,2,utf8_decode($row['telefonos']),0,'C');
        $pdf->SetXY($current_x + $cell_width, $current_y);
        $sql3 = "SELECT MAX(mesCargo) AS ult_mes FROM tbl_abonos WHERE codigoCliente= '$codigoValido'";
        $resultado3 = $mysqli->query($sql3);
        while($row3 = $resultado3->fetch_assoc())
        {
        $pdf->Cell(15,6,utf8_decode($row3['ult_mes']),0,0,'C');
        }
        $sql2 = "SELECT COUNT(codigoCliente) AS fpendientes FROM tbl_cargos WHERE estado='pendiente' and anulada='0' AND codigoCliente= '$codigoValido'";
        $resultado2 = $mysqli->query($sql2);
/// orientacion de pagina P vertical L horizontal
      date_default_timezone_set('America/El_Salvador');
        while($row2 = $resultado2->fetch_assoc())
      {
        $pdf->Cell(12,6,utf8_decode($row2['fpendientes']),0,0,'C');
      }
       $sql3 = "SELECT SUM(cuotaCable + totalImpuesto) AS totalC FROM tbl_cargos WHERE estado='pendiente' and anulada='0' AND cuotaCable !='0' AND codigoCliente= '$codigoValido'";
        $resultado3 = $mysqli->query($sql3);
        while($row3 = $resultado3->fetch_assoc())
      {
        $totalizacionC = $row3['totalC'];
        
      }
      $sql4 = "SELECT SUM(cuotaInternet + totalImpuesto) AS totalI FROM tbl_cargos WHERE estado='pendiente' and anulada='0' AND cuotaInternet !='0' AND codigoCliente= '$codigoValido'";
        $resultado4 = $mysqli->query($sql4);
        while($row4 = $resultado4->fetch_assoc())
      {
       
        $totalizacionI = $row4['totalI'];
      }
        
        $pdf->Cell(15,6,'$'.number_format($totalizacionC,2),0,0,'C');
        $pdf->Cell(15,6,'$'.number_format($totalizacionI,2),0,0,'C');
        
        
        $pdf->Ln(4);
        
$counter1++;
       }
       if ($counter1 > 16){
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
  $pdf->Cell(260,6,utf8_decode("INFORME DE FACTURACION PENDIENTE"),0,1,'C');
  if ($tipoServicio == 'C') {
    $servicio = 'CABLE TV';
  }elseif ($tipoServicio == 'I'){
    $servicio = 'INTERNET';
  }elseif ($tipoServicio == 'T'){
    $servicio = 'CABLE E INTERNET';
  }elseif ($tipoServicio == 'A') {
    $servicio = 'TODOS LOS SERVICIOS';
  }
  
  $pdf->Cell(260,6,utf8_decode("SERVICIO: ".$servicio),0,1,'C');
  $pdf->Cell(260,6,utf8_decode("COBRADOR: ".$nombreCobrador),0,1,'C');
  $pdf->SetFont('Arial','',6);
  $pdf->Ln(1);

  putenv("LANG='es_ES.UTF-8'");
      setlocale(LC_ALL, 'es_ES.UTF-8');
      $pdf->SetFont('Arial','B',8);
      $pdf->Ln(1);
      $pdf->Cell(10,6,utf8_decode('N°'),1,0,'L');
      $pdf->Cell(50,6,utf8_decode('Cliente'),1,0,'L');
      $pdf->Cell(80,6,utf8_decode('Direccion de cobro'),1,0,'L');

      $pdf->Cell(26,6,utf8_decode('Colonia'),1,0,'L');

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
      $pdf->MultiCell(15,3,utf8_decode('Ult. mes pagado'),1,'C');
      $pdf->SetXY($current_x + $cell_width, $current_y);

      $current_y = $pdf->GetY();
      $current_x = $pdf->GetX();
      $cell_width = 12;
      $pdf->MultiCell(12,3,utf8_decode('# Ctas. Ptes.'),1,'C');
      $pdf->SetXY($current_x + $cell_width, $current_y);

      $pdf->Cell(15,6,utf8_decode('SaldoC'),1,0,'C');
      $pdf->Cell(15,6,utf8_decode('SaldoI'),1,0,'C');
      $pdf->Ln(6);
      $pdf->SetFont('Arial','',6);
      $pdf->Ln(1);
        $counter1=1;
       }
        
       }
        //////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////
}else {
        switch ($tipoServicio) {
    case 'C':
      $sql1 = "SELECT tbl_cargos.codigoCliente, COUNT(tbl_cargos.codigoCliente) FROM tbl_cargos, clientes WHERE (clientes.servicio_suspendido='F' OR clientes.servicio_suspendido is null)  AND clientes.sin_servicio='F' AND clientes.estado_cliente_in = 3 AND tbl_cargos.fechaFactura >= now()-interval '$fpendiente' month AND tbl_cargos.estado='pendiente' and tbl_cargos.anulada='0' AND tbl_cargos.codigoCobrador='$cobrador' AND tbl_cargos.codigoCliente=clientes.cod_cliente GROUP by tbl_cargos.codigoCliente HAVING COUNT(*)>=1";
      break;
    
     case 'I':
      $sql1 = "SELECT tbl_cargos.codigoCliente, COUNT(tbl_cargos.codigoCliente) FROM tbl_cargos, clientes WHERE (clientes.servicio_suspendido='F' or clientes.servicio_suspendido is null or clientes.servicio_suspendido='') and clientes.sin_servicio='T' AND clientes.estado_cliente_in = 1 AND tbl_cargos.fechaFactura >= now()-interval '$fpendiente' month AND tbl_cargos.estado='pendiente' and tbl_cargos.anulada='0' AND tbl_cargos.codigoCobrador='$cobrador' AND tbl_cargos.codigoCliente=clientes.cod_cliente GROUP by tbl_cargos.codigoCliente HAVING COUNT(*)>=1";
      break;

      case 'A':
      $sql1 = "SELECT tbl_cargos.codigoCliente, COUNT(tbl_cargos.codigoCliente) FROM tbl_cargos, clientes WHERE (clientes.servicio_suspendido='F' or clientes.servicio_suspendido is null or clientes.servicio_suspendido='') AND clientes.sin_servicio='F' AND clientes.estado_cliente_in = 3 OR (clientes.servicio_suspendido='F' or clientes.servicio_suspendido is null or clientes.servicio_suspendido='') and clientes.sin_servicio='T' AND clientes.estado_cliente_in = 1 OR (clientes.servicio_suspendido='F' or clientes.servicio_suspendido is null or clientes.servicio_suspendido='') and clientes.sin_servicio='F' AND clientes.estado_cliente_in = 1 AND tbl_cargos.fechaFactura >= now()-interval '$fpendiente' month AND tbl_cargos.estado='pendiente' and tbl_cargos.anulada='0' AND tbl_cargos.codigoCliente=clientes.cod_cliente GROUP by tbl_cargos.codigoCliente HAVING COUNT(*)>=1";
        break;
  }

$resultado1 = $mysqli->query($sql1);
 while ($row1 = $resultado1->fetch_assoc()){
  //var_dump($row1['codigoCliente']);
  if ($row1['codigoCliente'] >= '1') {
    $codigoValido = $row1['codigoCliente'];
    }
   // var_dump($codigoValido);
 $sql = "SELECT tbl_cargos.codigoCliente as codigoCliente/*, COUNT(tbl_cargos.codigoCliente) AS fpendientes*/, tbl_cargos.nombre, tbl_cargos.direccion, tbl_cargos.tipoServicio/*,MAX(tbl_cargos.mesCargo) AS ult_mes,*/, SUM(tbl_cargos.cuotaCable + tbl_cargos.totalImpuesto) AS totalC, SUM(tbl_cargos.cuotaInternet + tbl_cargos.totalImpuesto) AS totalI , clientes.dia_cobro, clientes.dia_corbo_in, tbl_cargos.fechaVencimiento, tbl_colonias_cxc.nombreColonia, clientes.telefonos FROM tbl_cargos, clientes, tbl_colonias_cxc WHERE tbl_cargos.fechaFactura >= now()-interval '$fpendiente' month AND tbl_cargos.estado='pendiente' and tbl_cargos.anulada='0' AND clientes.cod_cliente=tbl_cargos.codigoCliente AND tbl_colonias_cxc.idColonia=clientes.id_colonia AND tbl_cargos.codigoCobrador='$cobrador' AND tbl_cargos.codigoCliente= '$codigoValido' group by tbl_cargos.codigoCliente";

 $resultado = $mysqli->query($sql);
/// orientacion de pagina P vertical L horizontal
      date_default_timezone_set('America/El_Salvador');
        while($row = $resultado->fetch_assoc())
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
        $cell_width = 80;
        $pdf->SetFont('Arial','',5);
        $pdf->MultiCell(80,2,utf8_decode($row['direccion']),0,'J');
        $pdf->SetXY($current_x + $cell_width, $current_y);
        $current_y = $pdf->GetY();
        $current_x = $pdf->GetX();
        $cell_width = 26;
        $pdf->SetFont('Arial','',5);
        $pdf->MultiCell(26,2,utf8_decode($row['nombreColonia']),0,'C');
        $pdf->SetXY($current_x + $cell_width, $current_y);
        if ($row['tipoServicio']=='C') {
        $pdf->Cell(12,6,utf8_decode($row['dia_cobro']),0,0,'C');
        ////////////////// consulta de saldo en factura
        }elseif ($row['tipoServicio']=='I') {
        $pdf->Cell(12,6,utf8_decode($row['dia_corbo_in']),0,0,'C');
        }

        if (!empty($row['totalC']) && !empty($row['totalI'])){
             $pdf->Cell(13,6,utf8_decode('C+I'),0,0,'C');
        }elseif (empty($row['totalC']) && !empty($row['totalI'])){
             $pdf->Cell(13,6,utf8_decode('I'),0,0,'C');
        }elseif (!empty($row['totalC']) && empty($row['totalI'])){
             $pdf->Cell(13,6,utf8_decode('C'),0,0,'C');
        }else{
             $pdf->Cell(13,6,utf8_decode('Error'),0,0,'C');
        }
/*
        switch ($tipoServicio) {
          case 'A':
            $pdf->Cell(13,6,utf8_decode('T'),0,0,'C');
            break;
          
          case 'C':
            $pdf->Cell(13,6,utf8_decode('C'),0,0,'C');
            break;

          case 'I':
            $pdf->Cell(13,6,utf8_decode('I'),0,0,'C');
            break;
        }
*/
        
        $current_y = $pdf->GetY();
        $current_x = $pdf->GetX();
        $cell_width = 15;
        $pdf->MultiCell(15,2,utf8_decode($row['telefonos']),0,'C');
        $pdf->SetXY($current_x + $cell_width, $current_y);
        $sql3 = "SELECT MAX(mesCargo) AS ult_mes FROM tbl_abonos WHERE codigoCliente= '$codigoValido'";
        $resultado3 = $mysqli->query($sql3);
        while($row3 = $resultado3->fetch_assoc())
        {
        $pdf->Cell(15,6,utf8_decode($row3['ult_mes']),0,0,'C');
        }
        $sql2 = "SELECT COUNT(codigoCliente) AS fpendientes FROM tbl_cargos WHERE estado='pendiente' and anulada='0' AND codigoCliente= '$codigoValido'";
        $resultado2 = $mysqli->query($sql2);
/// orientacion de pagina P vertical L horizontal
      date_default_timezone_set('America/El_Salvador');
        while($row2 = $resultado2->fetch_assoc())
      {
        $pdf->Cell(12,6,utf8_decode($row2['fpendientes']),0,0,'C');
      }
       $sql3 = "SELECT SUM(cuotaCable + totalImpuesto) AS totalC FROM tbl_cargos WHERE estado='pendiente' and anulada='0' AND cuotaCable !='0' AND codigoCliente= '$codigoValido'";
        $resultado3 = $mysqli->query($sql3);
        while($row3 = $resultado3->fetch_assoc())
      {
        $totalizacionC = $row3['totalC'];
        
      }
      $sql4 = "SELECT SUM(cuotaInternet + totalImpuesto) AS totalI FROM tbl_cargos WHERE estado='pendiente' and anulada='0' AND cuotaInternet !='0' AND codigoCliente= '$codigoValido'";
        $resultado4 = $mysqli->query($sql4);
        while($row4 = $resultado4->fetch_assoc())
      {
       
        $totalizacionI = $row4['totalI'];
      }
       
        $pdf->Cell(15,6,'$'.number_format($totalizacionC,2),0,0,'C');
        $pdf->Cell(15,6,'$'.number_format($totalizacionI,2),0,0,'C');
        

        
        $pdf->Ln(4);
        
$counter1++;
       }
       if ($counter1 > 18){
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
  $pdf->Cell(260,6,utf8_decode("INFORME DE FACTURACION PENDIENTE"),0,1,'C');
  if ($tipoServicio == 'C') {
    $servicio = 'CABLE TV';
  }elseif ($tipoServicio == 'I'){
    $servicio = 'INTERNET';
  }elseif ($tipoServicio == 'T'){
    $servicio = 'CABLE E INTERNET';
  }elseif ($tipoServicio == 'A') {
    $servicio = 'TODOS LOS SERVICIOS';
  }
  
  $pdf->Cell(260,6,utf8_decode("SERVICIO: ".$servicio),0,1,'C');
  $pdf->Cell(260,6,utf8_decode("COBRADOR: ".$nombreCobrador),0,1,'C');
  $pdf->SetFont('Arial','',6);
  $pdf->Ln(1);

  putenv("LANG='es_ES.UTF-8'");
      setlocale(LC_ALL, 'es_ES.UTF-8');
      $pdf->SetFont('Arial','B',8);
      $pdf->Ln(1);
      $pdf->Cell(10,6,utf8_decode('N°'),1,0,'L');
      $pdf->Cell(50,6,utf8_decode('Cliente'),1,0,'L');
      $pdf->Cell(80,6,utf8_decode('Direccion de cobro'),1,0,'L');

      $pdf->Cell(26,6,utf8_decode('Colonia'),1,0,'L');

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
      $pdf->MultiCell(15,3,utf8_decode('Ult. mes pagado'),1,'C');
      $pdf->SetXY($current_x + $cell_width, $current_y);

      $current_y = $pdf->GetY();
      $current_x = $pdf->GetX();
      $cell_width = 12;
      $pdf->MultiCell(12,3,utf8_decode('# Ctas. Ptes.'),1,'C');
      $pdf->SetXY($current_x + $cell_width, $current_y);

      $pdf->Cell(15,6,utf8_decode('SaldoC'),1,0,'C');
      $pdf->Cell(15,6,utf8_decode('SaldoI'),1,0,'C');
      $pdf->Ln(6);
      $pdf->SetFont('Arial','',6);
      $pdf->Ln(1);
        $counter1=1;
       }
       
       }
        //////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////
}
///////////////////////////
//////////////////////////

}

        $pdf->Ln(7);
        $pdf->SetFont('Arial','',10);
 
        
             mysqli_close($mysqli);
             $pdf->Output();
  ?>