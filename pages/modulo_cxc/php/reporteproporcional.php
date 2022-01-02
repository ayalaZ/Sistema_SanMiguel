<?php
  require '../../../pdfs/fpdf.php';
  require_once("../../../php/config.php");
  require '../../../numLe/src/NumerosEnLetras.php';
  if(!isset($_SESSION))
  {
    session_start();
  }
  $host = DB_HOST;
  $user = DB_USER;
  $password = DB_PASSWORD;
  $database = $_SESSION['db'];
  $mysqli = new mysqli($host, $user, $password, $database);

  //$codigo = $_GET['id'];
  $desde = $_POST['lDesde'];
  $hasta = $_POST['lHasta'];
  $propor = $_POST['propor']; /// es el año que en proporcion es el año anterior
  $fechadesde = strtotime($desde);
  $fechahasta = strtotime($hasta);
  $propor2 = date("Y", $fechahasta); /// es el año que en proporcion es el año nuevo
  $mes = date("m", $fechadesde - 1); /// mes del año de propor
  $dias = cal_days_in_month(CAL_GREGORIAN, $mes, $propor); /// dias del mes del año de propor
  //$codigoCobrador = $_POST['lCobrador'];
  //$colonia = $_POST['lColonia'];
    if (isset($_POST['lDetallado'])){
        $detallado = $_POST['lDetallado'];
    }else{
        $detallado = null;
    }
    //$detallado = $_POST['lDetallado'];
  $tipoServicio = $_POST['lServicio'];

// SQL query para traer datos del servicio de cable de la tabla impuestos
$query = "SELECT valorImpuesto FROM tbl_impuestos WHERE siglasImpuesto = 'IVA'";
// Preparación de sentencia
$statement = $mysqli->query($query);
//$statement->execute();
while ($result = $statement->fetch_assoc()) {
    $iva = floatval($result['valorImpuesto']);
}

// SQL query para traer datos del servicio de cable de la tabla impuestos
$query = "SELECT valorImpuesto FROM tbl_impuestos WHERE siglasImpuesto = 'CESC'";
// Preparación de sentencia
$statement = $mysqli->query($query);
//$statement->execute();
while ($result = $statement->fetch_assoc()) {
    $cesc = floatval($result['valorImpuesto']);
}

  $totalAnticipoSoloCable = 0;
  $totalAnticipoCable = 0;
  $totalAnticipoImpuestoC = 0;
  $totalAnticipoSoloInter = 0;
  $totalAnticipoInter = 0;
  $totalAnticipoImpuestoI = 0;

  $totalSoloCable = 0;
  $totalCable = 0;
  $totalImpuestoC = 0;
  $totalSoloInter = 0;
  $totalInter = 0;
  $totalImpuestoI = 0;
  $anulada = 0;
  $anticipado = 1;
  $recibo_anulado = '00000';

  function abonos(){
    global $desde, $hasta, $propor, $propor2, $mes, $dias, $totalpropor1, $totalpropor2, $totalcuota, $totalpropor1C, $totalpropor2C, $totalpropor1I, $totalpropor2I, $totalcuotaC, $totalcuotaI, $codigoCobrador, $colonia, $tipoServicio, $cesc,$iva, $mysqli /*$statement1*/;
      global $totalAnticipoSoloCable,$totalAnticipoCable,$totalAnticipoImpuestoC,$totalAnticipoSoloInter,$totalAnticipoInter,$totalAnticipoImpuestoI;
      global $totalSoloCable,$totalCable,$totalImpuestoC,$totalSoloInter,$totalInter,$totalImpuestoI,$anulada,$detallado,$anticipado,$recibo_anulado;

        if (isset($detallado)){
          if ($detallado == 1){

            $pdf = new FPDF();

              $pdf->AddPage('P','Letter');
              $pdf->SetAutoPageBreak(false, 10);
              $pdf->SetFont('Arial','',6);
              date_default_timezone_set('America/El_Salvador');
              $pdf->Cell(200,3,utf8_decode("Página ".str_pad($pdf->pageNo(),4,"0",STR_PAD_LEFT)),0,1,'R');
              $pdf->Cell(200,4,utf8_decode("GENERADO POR: ".strtoupper($_SESSION['nombres'])." ".strtoupper($_SESSION['apellidos']). " ".date('d/m/Y h:i:s')),"",1,'R');
              $pdf->Image('../../../images/logo.png',10,10, 20, 18);

              $pdf->Ln(15);

              $pdf->SetFont('Arial','B',11);

              date_default_timezone_set('America/El_Salvador');

              //echo strftime("El año es %Y y el mes es %B");
              putenv("LANG='es_ES.UTF-8'");
              setlocale(LC_ALL, 'es_ES.UTF-8');
              $pdf->SetFont('Arial', 'B', 9);
              $pdf->Cell(190, 4, utf8_decode('CABLE VISION POR SATELITE, S.A DE C.V.'), 0, 1, 'L');
              $pdf->SetFont('Arial', 'B', 7); 
              $pdf->Cell(190, 4, utf8_decode('LISTADO DE PROPORCIÓN DE CRÉDITOS FISCALES Y FACTURAS EMITIDAS'), 0, 1, 'L');
              if ($_SESSION['db'] == 'satpro_sm'){
                  $pdf->Cell(190, 4, utf8_decode('SUCURSAL SAN MIGUEL'), 0, 1, 'L');

              }elseif ($_SESSION['db'] == 'satpro'){
                  $pdf->Cell(190, 4, utf8_decode('SUCURSAL USULUTÁN'), 0, 1, 'L');
              }else{
                  $pdf->Cell(190, 4, utf8_decode('SUCURSAL DE PRUEBA'), 0, 1, 'L');
              }
              $pdf->SetFont('Arial', '', 7);
              $pdf->Cell(190, 4, utf8_decode('FECHA DE PROPORCIÓN DESDE '.$desde.' HASTA '.$hasta), 0, 1, 'L');
              $pdf->Ln(0);

              $pdf->SetFont('Arial','B',6.5);
              $pdf->Cell(14,5,utf8_decode(''),0,0,'L');
              $pdf->Cell(25,5,utf8_decode(''),0,0,'L');
              $pdf->Cell(17,5,utf8_decode(''),0,0,'L');
              $pdf->Cell(70,5,utf8_decode(''),0,0,'L');
              $pdf->Cell(23,5,utf8_decode(''),0,0,'L');
              $pdf->Cell(20,5,utf8_decode($propor),0,0,'L');;
              $pdf->Cell(20,5,utf8_decode($propor2),0,0,'L');
              $pdf->Cell(20,5,utf8_decode(''),0,1,'L');

              $pdf->Cell(14,5,utf8_decode('N°'),1,0,'L');
              $pdf->Cell(25,5,utf8_decode('No. Comprobante'),1,0,'L');
              $pdf->Cell(17,5,utf8_decode('Fecha'),1,0,'L');
              $pdf->Cell(70,5,utf8_decode('Cliente'),1,0,'L');
              $pdf->Cell(18,5,utf8_decode('Mes Servicio'),1,0,'L');
              $pdf->Cell(20,5,utf8_decode('1° Proporción'),1,0,'L');
              $pdf->Cell(20,5,utf8_decode('2° Proporción'),1,0,'L');
              $pdf->Cell(20,5,utf8_decode('TOTAL'),1,0,'L');
              $pdf->Ln(6);

              $counter2=1;
              $counter3=1;
              if($tipoServicio === "A") {
                $query = "SELECT * FROM tbl_cargos WHERE fechaFactura BETWEEN '".$desde."' AND '".$hasta."' AND anulada = '0' ORDER BY numeroFactura";
                $resultado = $mysqli->query($query);
                while($row = $resultado->fetch_assoc())
                            {
                                  if ($row["tipoServicio"] == "C") {
                                    $cuota = $row['cuotaCable'];
                              $query2 = "SELECT dia_cobro FROM clientes WHERE cod_cliente= ".$row['codigoCliente'];
                              // Preparación de sentencia
                              $statement2 = $mysqli->query($query2);
                              //$statement->execute();
                              while ($result2 = $statement2->fetch_assoc()) {
                                  $diaCobro = $result2['dia_cobro'];
                              }
                                }elseif ($row["tipoServicio"]  == "I") {
                                  $cuota = $row['cuotaInternet'];
                              $query2 = "SELECT dia_corbo_in FROM clientes WHERE cod_cliente= ".$row['codigoCliente'];
                              // Preparación de sentencia
                              $statement2 = $mysqli->query($query2);
                              //$statement->execute();
                              while ($result2 = $statement2->fetch_assoc()) {
                                  $diaCobro = $result2['dia_corbo_in'];
                              }
                          }
                          /////////////////////////////////////////////////////////////////
                          $pdf->Ln(3);
                          $pdf->SetFont('Arial','',6.5);
                          $pdf->Cell(6,0,utf8_decode($counter3),0,0,'L');
                          /////////////////////////////////////////////////////////////////
                          $diapropor1 = ($dias - $diaCobro);
                          $totalpropor = $diapropor1 + $diaCobro;
                          $valorpropor = ($cuota/$dias);
                          $cuotapropor1 = number_format(($valorpropor*$diapropor1),2);
                          $cuotapropor2 = number_format(($valorpropor*$diaCobro),2);
                          $pdf->Cell(8,0,utf8_decode($row['idFactura']),0,0,'L');
                          $pdf->Cell(25,0,utf8_decode($row['numeroFactura']),0,0,'L');
                          $pdf->Cell(17,0,utf8_decode($row['fechaFactura']),0,0,'L');
                          $pdf->Cell(75,0,utf8_decode(strtoupper($row['codigoCliente']."  ".$row['nombre'])),0,0,'L');
                          $pdf->Cell(18,0,utf8_decode($row['mesCargo']),0,0,'L');
                          $pdf->Cell(20,0,utf8_decode($cuotapropor1),0,0,'L');
                          $pdf->Cell(20,0,utf8_decode($cuotapropor2),0,0,'L');
                          $pdf->Cell(20,0,utf8_decode($cuota),0,0,'L');

                          $totalpropor1 = $totalpropor1 + $cuotapropor1;
                          $totalpropor2 = $totalpropor2 + $cuotapropor2;
                          $totalcuota = $totalcuota + $cuota;
                          /////////////////////////////////////////////////////////////////
                          if ($counter2 > 60){
                              $pdf->AddPage('P','Letter');
                              $pdf->SetAutoPageBreak(false, 10);
                              $pdf->SetFont('Arial','',6);
                              date_default_timezone_set('America/El_Salvador');
                              $pdf->Cell(200,3,utf8_decode("Página ".str_pad($pdf->pageNo(),4,"0",STR_PAD_LEFT)),0,1,'R');
                              $pdf->Cell(200,4,utf8_decode("GENERADO POR: ".strtoupper($_SESSION['nombres'])." ".strtoupper($_SESSION['apellidos']). " ".date('d/m/Y h:i:s')),"",1,'R');
                              $pdf->Image('../../../images/logo.png',10,10, 20, 18);

                              $pdf->Ln(15);

                              $pdf->SetFont('Arial','B',11);

                              date_default_timezone_set('America/El_Salvador');

                              //echo strftime("El año es %Y y el mes es %B");
                              putenv("LANG='es_ES.UTF-8'");
                              setlocale(LC_ALL, 'es_ES.UTF-8');
                              $pdf->SetFont('Arial', 'B', 9);
                              $pdf->Cell(190, 4, utf8_decode('CABLE VISION POR SATELITE, S.A DE C.V.'), 0, 1, 'L');
                              $pdf->SetFont('Arial', 'B', 7); 
                              $pdf->Cell(190, 4, utf8_decode('LISTADO DE PROPORCIÓN DE CRÉDITOS FISCALES Y FACTURAS EMITIDAS'), 0, 1, 'L');
                              if ($_SESSION['db'] == 'satpro_sm'){
                                  $pdf->Cell(190, 4, utf8_decode('SUCURSAL SAN MIGUEL'), 0, 1, 'L');

                              }elseif ($_SESSION['db'] == 'satpro'){
                                  $pdf->Cell(190, 4, utf8_decode('SUCURSAL USULUTÁN'), 0, 1, 'L');
                              }else{
                                  $pdf->Cell(190, 4, utf8_decode('SUCURSAL DE PRUEBA'), 0, 1, 'L');
                              }
                              $pdf->SetFont('Arial', '', 7);
                              $pdf->Cell(190, 4, utf8_decode('FECHA DE PROPORCIÓN DESDE '.$desde.' HASTA '.$hasta), 0, 1, 'L');
                              $pdf->Ln(0);

                              $pdf->SetFont('Arial','B',6.5);
                              $pdf->Cell(14,5,utf8_decode(''),0,0,'L');
                              $pdf->Cell(25,5,utf8_decode(''),0,0,'L');
                              $pdf->Cell(17,5,utf8_decode(''),0,0,'L');
                              $pdf->Cell(70,5,utf8_decode(''),0,0,'L');
                              $pdf->Cell(23,5,utf8_decode(''),0,0,'L');
                              $pdf->Cell(20,5,utf8_decode($propor),0,0,'L');
                              $pdf->Cell(20,5,utf8_decode($propor2),0,0,'L');
                              $pdf->Cell(20,5,utf8_decode(''),0,1,'L');

                              $pdf->Cell(14,5,utf8_decode('N°'),1,0,'L');
                              $pdf->Cell(25,5,utf8_decode('No. Comprobante'),1,0,'L');
                              $pdf->Cell(17,5,utf8_decode('Fecha'),1,0,'L');
                              $pdf->Cell(70,5,utf8_decode('Cliente'),1,0,'L');
                              $pdf->Cell(18,5,utf8_decode('Mes Servicio'),1,0,'L');
                              $pdf->Cell(20,5,utf8_decode('1° Proporción'),1,0,'L');
                              $pdf->Cell(20,5,utf8_decode('2° Proporción'),1,0,'L');
                              $pdf->Cell(20,5,utf8_decode('TOTAL'),1,0,'L');
                              $pdf->Ln(6);
                              $counter2=1;
                          }
                          $counter2++;
                          $counter3++;

                      
///////////////////////////////////////////////////////                  
                            }
            }elseif ($tipoServicio == "C") {
                 $query = "SELECT * FROM tbl_cargos WHERE fechaFactura BETWEEN '".$desde."' AND '".$hasta."' AND anulada = '0' AND tipoServicio= '".$tipoServicio."' ORDER BY numeroFactura";
                $resultado = $mysqli->query($query);
                while($row = $resultado->fetch_assoc())           
        {
                                  if ($row["tipoServicio"] == "C") {
                                    $cuota = $row['cuotaCable'];
                              $query2 = "SELECT dia_cobro FROM clientes WHERE cod_cliente= ".$row['codigoCliente'];
                              // Preparación de sentencia
                              $statement2 = $mysqli->query($query2);
                              //$statement->execute();
                              while ($result2 = $statement2->fetch_assoc()) {
                                  $diaCobro = $result2['dia_cobro'];
                              }
                                }elseif ($row["tipoServicio"]  == "I") {
                                  $cuota = $row['cuotaInternet'];
                              $query2 = "SELECT dia_corbo_in FROM clientes WHERE cod_cliente= ".$row['codigoCliente'];
                              // Preparación de sentencia
                              $statement2 = $mysqli->query($query2);
                              //$statement->execute();
                              while ($result2 = $statement2->fetch_assoc()) {
                                  $diaCobro = $result2['dia_corbo_in'];
                              }
                          }
                          /////////////////////////////////////////////////////////////////
                          $pdf->Ln(3);
                          $pdf->SetFont('Arial','',6.5);
                          $pdf->Cell(6,0,utf8_decode($counter3),0,0,'L');
                          /////////////////////////////////////////////////////////////////
                          $diapropor1 = ($dias - $diaCobro);
                          $totalpropor = $diapropor1 + $diaCobro;
                          $valorpropor = ($cuota/$dias);
                          $cuotapropor1 = number_format(($valorpropor*$diapropor1),2);
                          $cuotapropor2 = number_format(($valorpropor*$diaCobro),2);
                          $pdf->Cell(8,0,utf8_decode($row['idFactura']),0,0,'L');
                          $pdf->Cell(25,0,utf8_decode($row['numeroFactura']),0,0,'L');
                          $pdf->Cell(17,0,utf8_decode($row['fechaFactura']),0,0,'L');
                          $pdf->Cell(75,0,utf8_decode(strtoupper($row['codigoCliente']."  ".$row['nombre'])),0,0,'L');
                          $pdf->Cell(18,0,utf8_decode($row['mesCargo']),0,0,'L');
                          $pdf->Cell(20,0,utf8_decode($cuotapropor1),0,0,'L');
                          $pdf->Cell(20,0,utf8_decode($cuotapropor2),0,0,'L');
                          $pdf->Cell(20,0,utf8_decode($cuota),0,0,'L');

                          $totalpropor1 = $totalpropor1 + $cuotapropor1;
                          $totalpropor2 = $totalpropor2 + $cuotapropor2;
                          $totalcuota = $totalcuota + $cuota;
                          /////////////////////////////////////////////////////////////////
                          if ($counter2 > 60){
                              $pdf->AddPage('P','Letter');
                              $pdf->SetAutoPageBreak(false, 10);
                              $pdf->SetFont('Arial','',6);
                              date_default_timezone_set('America/El_Salvador');
                              $pdf->Cell(200,3,utf8_decode("Página ".str_pad($pdf->pageNo(),4,"0",STR_PAD_LEFT)),0,1,'R');
                              $pdf->Cell(200,4,utf8_decode("GENERADO POR: ".strtoupper($_SESSION['nombres'])." ".strtoupper($_SESSION['apellidos']). " ".date('d/m/Y h:i:s')),"",1,'R');
                              $pdf->Image('../../../images/logo.png',10,10, 20, 18);

                              $pdf->Ln(15);

                              $pdf->SetFont('Arial','B',11);

                              date_default_timezone_set('America/El_Salvador');

                              //echo strftime("El año es %Y y el mes es %B");
                              putenv("LANG='es_ES.UTF-8'");
                              setlocale(LC_ALL, 'es_ES.UTF-8');
                              $pdf->SetFont('Arial', 'B', 9);
                              $pdf->Cell(190, 4, utf8_decode('CABLE VISION POR SATELITE, S.A DE C.V.'), 0, 1, 'L');
                              $pdf->SetFont('Arial', 'B', 7); 
                              $pdf->Cell(190, 4, utf8_decode('LISTADO DE PROPORCIÓN DE CRÉDITOS FISCALES Y FACTURAS EMITIDAS'), 0, 1, 'L');
                              if ($_SESSION['db'] == 'satpro_sm'){
                                  $pdf->Cell(190, 4, utf8_decode('SUCURSAL SAN MIGUEL'), 0, 1, 'L');

                              }elseif ($_SESSION['db'] == 'satpro'){
                                  $pdf->Cell(190, 4, utf8_decode('SUCURSAL USULUTÁN'), 0, 1, 'L');
                              }else{
                                  $pdf->Cell(190, 4, utf8_decode('SUCURSAL DE PRUEBA'), 0, 1, 'L');
                              }
                              $pdf->SetFont('Arial', '', 7);
                              $pdf->Cell(190, 4, utf8_decode('FECHA DE PROPORCIÓN DESDE '.$desde.' HASTA '.$hasta), 0, 1, 'L');
                              $pdf->Ln(0);

                              $pdf->SetFont('Arial','B',6.5);
                              $pdf->Cell(14,5,utf8_decode(''),0,0,'L');
                              $pdf->Cell(25,5,utf8_decode(''),0,0,'L');
                              $pdf->Cell(17,5,utf8_decode(''),0,0,'L');
                              $pdf->Cell(70,5,utf8_decode(''),0,0,'L');
                              $pdf->Cell(23,5,utf8_decode(''),0,0,'L');
                              $pdf->Cell(20,5,utf8_decode($propor),0,0,'L');
                              $pdf->Cell(20,5,utf8_decode($propor2),0,0,'L');
                              $pdf->Cell(20,5,utf8_decode(''),0,1,'L');

                              $pdf->Cell(14,5,utf8_decode('N°'),1,0,'L');
                              $pdf->Cell(25,5,utf8_decode('No. Comprobante'),1,0,'L');
                              $pdf->Cell(17,5,utf8_decode('Fecha'),1,0,'L');
                              $pdf->Cell(70,5,utf8_decode('Cliente'),1,0,'L');
                              $pdf->Cell(18,5,utf8_decode('Mes Servicio'),1,0,'L');
                              $pdf->Cell(20,5,utf8_decode('1° Proporción'),1,0,'L');
                              $pdf->Cell(20,5,utf8_decode('2° Proporción'),1,0,'L');
                              $pdf->Cell(20,5,utf8_decode('TOTAL'),1,0,'L');
                              $pdf->Ln(6);
                              $counter2=1;
                          }
                          $counter2++;
                          $counter3++;

                      }
///////////////////////////////////////////////////////
            }elseif ($tipoServicio == "I") {
                $query = "SELECT * FROM tbl_cargos WHERE fechaFactura BETWEEN '".$desde."' AND '".$hasta."' AND anulada = '0' AND tipoServicio= '".$tipoServicio."' ORDER BY numeroFactura";
                $resultado = $mysqli->query($query);
                while($row = $resultado->fetch_assoc())
                            
        {
                                  if ($row["tipoServicio"] == "C") {
                                    $cuota = $row['cuotaCable'];
                              $query2 = "SELECT dia_cobro FROM clientes WHERE cod_cliente= ".$row['codigoCliente'];
                              // Preparación de sentencia
                              $statement2 = $mysqli->query($query2);
                              //$statement->execute();
                              while ($result2 = $statement2->fetch_assoc()) {
                                  $diaCobro = $result2['dia_cobro'];
                              }
                                }elseif ($row["tipoServicio"]  == "I") {
                                  $cuota = $row['cuotaInternet'];
                              $query2 = "SELECT dia_corbo_in FROM clientes WHERE cod_cliente= ".$row['codigoCliente'];
                              // Preparación de sentencia
                              $statement2 = $mysqli->query($query2);
                              //$statement->execute();
                              while ($result2 = $statement2->fetch_assoc()) {
                                  $diaCobro = $result2['dia_corbo_in'];
                              }
                          }
                          /////////////////////////////////////////////////////////////////
                          $pdf->Ln(3);
                          $pdf->SetFont('Arial','',6.5);
                          $pdf->Cell(6,0,utf8_decode($counter3),0,0,'L');
                          /////////////////////////////////////////////////////////////////
                          $diapropor1 = ($dias - $diaCobro);
                          $totalpropor = $diapropor1 + $diaCobro;
                          $valorpropor = ($cuota/$dias);
                          $cuotapropor1 = number_format(($valorpropor*$diapropor1),2);
                          $cuotapropor2 = number_format(($valorpropor*$diaCobro),2);
                          $pdf->Cell(8,0,utf8_decode($row['idFactura']),0,0,'L');
                          $pdf->Cell(25,0,utf8_decode($row['numeroFactura']),0,0,'L');
                          $pdf->Cell(17,0,utf8_decode($row['fechaFactura']),0,0,'L');
                          $pdf->Cell(75,0,utf8_decode(strtoupper($row['codigoCliente']."  ".$row['nombre'])),0,0,'L');
                          $pdf->Cell(18,0,utf8_decode($row['mesCargo']),0,0,'L');
                          $pdf->Cell(20,0,utf8_decode($cuotapropor1),0,0,'L');
                          $pdf->Cell(20,0,utf8_decode($cuotapropor2),0,0,'L');
                          $pdf->Cell(20,0,utf8_decode($cuota),0,0,'L');

                          $totalpropor1 = $totalpropor1 + $cuotapropor1;
                          $totalpropor2 = $totalpropor2 + $cuotapropor2;
                          $totalcuota = $totalcuota + $cuota;
                          /////////////////////////////////////////////////////////////////
                          if ($counter2 > 60){
                              $pdf->AddPage('P','Letter');
                              $pdf->SetAutoPageBreak(false, 10);
                              $pdf->SetFont('Arial','',6);
                              date_default_timezone_set('America/El_Salvador');
                              $pdf->Cell(200,3,utf8_decode("Página ".str_pad($pdf->pageNo(),4,"0",STR_PAD_LEFT)),0,1,'R');
                              $pdf->Cell(200,4,utf8_decode("GENERADO POR: ".strtoupper($_SESSION['nombres'])." ".strtoupper($_SESSION['apellidos']). " ".date('d/m/Y h:i:s')),"",1,'R');
                              $pdf->Image('../../../images/logo.png',10,10, 20, 18);

                              $pdf->Ln(15);

                              $pdf->SetFont('Arial','B',11);

                              date_default_timezone_set('America/El_Salvador');

                              //echo strftime("El año es %Y y el mes es %B");
                              putenv("LANG='es_ES.UTF-8'");
                              setlocale(LC_ALL, 'es_ES.UTF-8');
                              $pdf->SetFont('Arial', 'B', 9);
                              $pdf->Cell(190, 4, utf8_decode('CABLE VISION POR SATELITE, S.A DE C.V.'), 0, 1, 'L');
                              $pdf->SetFont('Arial', 'B', 7); 
                              $pdf->Cell(190, 4, utf8_decode('LISTADO DE PROPORCIÓN DE CRÉDITOS FISCALES Y FACTURAS EMITIDAS'), 0, 1, 'L');
                              if ($_SESSION['db'] == 'satpro_sm'){
                                  $pdf->Cell(190, 4, utf8_decode('SUCURSAL SAN MIGUEL'), 0, 1, 'L');

                              }elseif ($_SESSION['db'] == 'satpro'){
                                  $pdf->Cell(190, 4, utf8_decode('SUCURSAL USULUTÁN'), 0, 1, 'L');
                              }else{
                                  $pdf->Cell(190, 4, utf8_decode('SUCURSAL DE PRUEBA'), 0, 1, 'L');
                              }
                              $pdf->SetFont('Arial', '', 7);
                              $pdf->Cell(190, 4, utf8_decode('FECHA DE PROPORCIÓN DESDE '.$desde.' HASTA '.$hasta), 0, 1, 'L');
                              $pdf->Ln(0);

                              $pdf->SetFont('Arial','B',6.5);
                              $pdf->Cell(14,5,utf8_decode(''),0,0,'L');
                              $pdf->Cell(25,5,utf8_decode(''),0,0,'L');
                              $pdf->Cell(17,5,utf8_decode(''),0,0,'L');
                              $pdf->Cell(70,5,utf8_decode(''),0,0,'L');
                              $pdf->Cell(23,5,utf8_decode(''),0,0,'L');
                              $pdf->Cell(20,5,utf8_decode($propor),0,0,'L');
                              $pdf->Cell(20,5,utf8_decode($propor2),0,0,'L');
                              $pdf->Cell(20,5,utf8_decode(''),0,1,'L');

                              $pdf->Cell(14,5,utf8_decode('N°'),1,0,'L');
                              $pdf->Cell(25,5,utf8_decode('No. Comprobante'),1,0,'L');
                              $pdf->Cell(17,5,utf8_decode('Fecha'),1,0,'L');
                              $pdf->Cell(70,5,utf8_decode('Cliente'),1,0,'L');
                              $pdf->Cell(18,5,utf8_decode('Mes Servicio'),1,0,'L');
                              $pdf->Cell(20,5,utf8_decode('1° Proporción'),1,0,'L');
                              $pdf->Cell(20,5,utf8_decode('2° Proporción'),1,0,'L');
                              $pdf->Cell(20,5,utf8_decode('TOTAL'),1,0,'L');
                              $pdf->Ln(6);
                              $counter2=1;
                          }
                          $counter2++;
                          $counter3++;

                      }
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
            }
            
                      $pdf->Ln(1);
              $pdf->Cell(185,4,utf8_decode(''),0,0,'R');
              $pdf->Cell(75,4,utf8_decode(''),"",1,'R');
              $pdf->SetFont('Arial','B',8);

              $pdf->Cell(200,4,utf8_decode('TOTALES GENERALES'),'',1,'R');
              $pdf->SetFont('Arial','',8);
              //TOTAL INTERNET
              $pdf->Cell(180,4,utf8_decode('TOTAL PRIMER PROPORCIÓN '.$propor.':'),0,0,'R');
              $pdf->Cell(20,4,"+ ".'$'.number_format($totalpropor1,2),"T",1,'L');
              //TOTAL CABLE
              $pdf->Cell(180,4,utf8_decode('TOTAL SEGUNDA PROPORCIÓN '.$propor2.':'),0,0,'R');
              $pdf->Cell(20,4,"+ ".'$'.number_format($totalpropor2,2),"T",1,'L');
              //TOTAL GENERAL
              $pdf->Cell(180,4,utf8_decode('TOTAL GENERAL: '),"",0,'R');
              $pdf->Cell(20,4,"= ".'$'.number_format($totalcuota,2),"T",1,'L');
              $pdf->Cell(180,4,utf8_decode(''),"",0,'R');
              $pdf->Cell(20,4,utf8_decode(''),"T",1,'L');
              $pdf->Ln(15);
          }

       }elseif ($detallado == null){ //EN ESTA CONDICION SE EVALUA SI EL REPORTE SE MOSTRARÁ GENERAL
            //************************************************************************************************************************
            //************************************************************************************************************************
            //************************************************************************************************************************
            //************************************************************************************************************************


        // SQL query para traer datos del servicio de cable de la tabla impuestos
            $query = "SELECT valorImpuesto FROM tbl_impuestos WHERE siglasImpuesto = 'IVA'";
            // Preparación de sentencia
            $statement = $mysqli->query($query);
            //$statement->execute();
            while ($result = $statement->fetch_assoc()) {
                $iva = floatval($result['valorImpuesto']);
            }

            // SQL query para traer datos del servicio de cable de la tabla impuestos
            $query = "SELECT valorImpuesto FROM tbl_impuestos WHERE siglasImpuesto = 'CESC'";
            // Preparación de sentencia
            $statement = $mysqli->query($query);
            //$statement->execute();
            while ($result = $statement->fetch_assoc()) {
                $cesc = floatval($result['valorImpuesto']);
            }


            $pdf = new FPDF();

            $pdf->AddPage('P','Letter');
            $pdf->SetFont('Arial','',6);
            date_default_timezone_set('America/El_Salvador');
            $pdf->Cell(200,6,utf8_decode("Página ".str_pad($pdf->pageNo(),4,"0",STR_PAD_LEFT)),0,1,'R');
            $pdf->Cell(200,4,utf8_decode("IMPRESO POR: ".strtoupper($_SESSION['nombres'])." ".strtoupper($_SESSION['apellidos']). " ".date('d/m/Y h:i:s')),"",1,'R');
            $pdf->Image('../../../images/logo.png',10,10, 20, 18);

            $pdf->Ln(15);

           
            $pdf->SetFont('Arial','B',8);

            date_default_timezone_set('America/El_Salvador');

            //echo strftime("El año es %Y y el mes es %B");
            putenv("LANG='es_ES.UTF-8'");
            setlocale(LC_ALL, 'es_ES.UTF-8');

            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(190, 4, utf8_decode('CABLE VISION POR SATELITE, S.A DE C.V.'), 0, 1, 'L');
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(190, 4, utf8_decode('PROPORCIÓN DE FACTURACION'), 0, 1, 'L');
            if ($_SESSION['db'] == 'satpro_sm'){
                $pdf->Cell(190, 4, utf8_decode('SUCURSAL SAN MIGUEL'), 0, 1, 'L');

            }elseif ($_SESSION['db'] == 'satpro'){
                $pdf->Cell(190, 4, utf8_decode('SUCURSAL USULUTÁN'), 0, 1, 'L');
            }
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(190, 4, utf8_decode('PROPORCIÓN DE CRÉDITOS FISCALES Y FACTURAS EMITIDAS'), 0, 1, 'L');

            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(200,5,utf8_decode('RESUMEN GENERAL DE PROPORCIÓN DE FACTURACION CON FECHA DESDE '.$desde.' HASTA '.$hasta),'B',1,'C');
            $pdf->Ln(6);

           if($tipoServicio === "A") {
                $query = "SELECT * FROM tbl_cargos WHERE fechaFactura BETWEEN '".$desde."' AND '".$hasta."' AND anulada = '0' ORDER BY numeroFactura";
                $resultado = $mysqli->query($query);
                while($row = $resultado->fetch_assoc())
                            {
                                  if ($row["tipoServicio"] == "C") {
                                    $cuota = $row['cuotaCable'];
                              $query2 = "SELECT dia_cobro FROM clientes WHERE cod_cliente= ".$row['codigoCliente'];
                              // Preparación de sentencia
                              $statement2 = $mysqli->query($query2);
                              //$statement->execute();
                              while ($result2 = $statement2->fetch_assoc()) {
                                  $diaCobro = $result2['dia_cobro'];
                              }

                          $diapropor1 = ($dias - $diaCobro);
                          $totalpropor = $diapropor1 + $diaCobro;
                          $valorpropor = ($cuota/$dias);
                          $cuotapropor1 = number_format(($valorpropor*$diapropor1),2);
                          $cuotapropor2 = number_format(($valorpropor*$diaCobro),2);

                          $totalpropor1C = $totalpropor1C + $cuotapropor1;
                          $totalpropor2C = $totalpropor2C + $cuotapropor2;
                          $totalcuotaC = $totalcuotaC + $cuota;


                                }elseif ($row["tipoServicio"]  == "I") {
                                  $cuota = $row['cuotaInternet'];
                              $query2 = "SELECT dia_corbo_in FROM clientes WHERE cod_cliente= ".$row['codigoCliente'];
                              // Preparación de sentencia
                              $statement2 = $mysqli->query($query2);
                              //$statement->execute();
                              while ($result2 = $statement2->fetch_assoc()) {
                                  $diaCobro = $result2['dia_corbo_in'];
                              }

                          $diapropor1 = ($dias - $diaCobro);
                          $totalpropor = $diapropor1 + $diaCobro;
                          $valorpropor = ($cuota/$dias);
                          $cuotapropor1 = number_format(($valorpropor*$diapropor1),2);
                          $cuotapropor2 = number_format(($valorpropor*$diaCobro),2);

                          $totalpropor1I = $totalpropor1I + $cuotapropor1;
                          $totalpropor2I = $totalpropor2I + $cuotapropor2;
                          $totalcuotaI = $totalcuotaI + $cuota;

                          }
                          
                        }

            }elseif ($tipoServicio == "C") {
                 $query = "SELECT * FROM tbl_cargos WHERE fechaFactura BETWEEN '".$desde."' AND '".$hasta."' AND anulada = '0' AND tipoServicio= '".$tipoServicio."' ORDER BY numeroFactura";
                $resultado = $mysqli->query($query);
                while($row = $resultado->fetch_assoc())           
       {
                                  if ($row["tipoServicio"] == "C") {
                                    $cuota = $row['cuotaCable'];
                              $query2 = "SELECT dia_cobro FROM clientes WHERE cod_cliente= ".$row['codigoCliente'];
                              // Preparación de sentencia
                              $statement2 = $mysqli->query($query2);
                              //$statement->execute();
                              while ($result2 = $statement2->fetch_assoc()) {
                                  $diaCobro = $result2['dia_cobro'];
                              }

                          $diapropor1 = ($dias - $diaCobro);
                          $totalpropor = $diapropor1 + $diaCobro;
                          $valorpropor = ($cuota/$dias);
                          $cuotapropor1 = number_format(($valorpropor*$diapropor1),2);
                          $cuotapropor2 = number_format(($valorpropor*$diaCobro),2);

                          $totalpropor1C = $totalpropor1C + $cuotapropor1;
                          $totalpropor2C = $totalpropor2C + $cuotapropor2;
                          $totalcuotaC = $totalcuotaC + $cuota;


                                }elseif ($row["tipoServicio"]  == "I") {
                                  $cuota = $row['cuotaInternet'];
                              $query2 = "SELECT dia_corbo_in FROM clientes WHERE cod_cliente= ".$row['codigoCliente'];
                              // Preparación de sentencia
                              $statement2 = $mysqli->query($query2);
                              //$statement->execute();
                              while ($result2 = $statement2->fetch_assoc()) {
                                  $diaCobro = $result2['dia_corbo_in'];
                              }

                          $diapropor1 = ($dias - $diaCobro);
                          $totalpropor = $diapropor1 + $diaCobro;
                          $valorpropor = ($cuota/$dias);
                          $cuotapropor1 = number_format(($valorpropor*$diapropor1),2);
                          $cuotapropor2 = number_format(($valorpropor*$diaCobro),2);

                          $totalpropor1I = $totalpropor1I + $cuotapropor1;
                          $totalpropor2I = $totalpropor2I + $cuotapropor2;
                          $totalcuotaI = $totalcuotaI + $cuota;

                          }
                          
                        }
             }elseif ($tipoServicio == "I") {
                $query = "SELECT * FROM tbl_cargos WHERE fechaFactura BETWEEN '".$desde."' AND '".$hasta."' AND anulada = '0' AND tipoServicio= '".$tipoServicio."' ORDER BY numeroFactura";
                $resultado = $mysqli->query($query);
                while($row = $resultado->fetch_assoc())
                            
       {
                                  if ($row["tipoServicio"] == "C") {
                                    $cuota = $row['cuotaCable'];
                              $query2 = "SELECT dia_cobro FROM clientes WHERE cod_cliente= ".$row['codigoCliente'];
                              // Preparación de sentencia
                              $statement2 = $mysqli->query($query2);
                              //$statement->execute();
                              while ($result2 = $statement2->fetch_assoc()) {
                                  $diaCobro = $result2['dia_cobro'];
                              }

                          $diapropor1 = ($dias - $diaCobro);
                          $totalpropor = $diapropor1 + $diaCobro;
                          $valorpropor = ($cuota/$dias);
                          $cuotapropor1 = number_format(($valorpropor*$diapropor1),2);
                          $cuotapropor2 = number_format(($valorpropor*$diaCobro),2);

                          $totalpropor1C = $totalpropor1C + $cuotapropor1;
                          $totalpropor2C = $totalpropor2C + $cuotapropor2;
                          $totalcuotaC = $totalcuotaC + $cuota;


                                }elseif ($row["tipoServicio"]  == "I") {
                                  $cuota = $row['cuotaInternet'];
                              $query2 = "SELECT dia_corbo_in FROM clientes WHERE cod_cliente= ".$row['codigoCliente'];
                              // Preparación de sentencia
                              $statement2 = $mysqli->query($query2);
                              //$statement->execute();
                              while ($result2 = $statement2->fetch_assoc()) {
                                  $diaCobro = $result2['dia_corbo_in'];
                              }

                          $diapropor1 = ($dias - $diaCobro);
                          $totalpropor = $diapropor1 + $diaCobro;
                          $valorpropor = ($cuota/$dias);
                          $cuotapropor1 = number_format(($valorpropor*$diapropor1),2);
                          $cuotapropor2 = number_format(($valorpropor*$diaCobro),2);

                          $totalpropor1I = $totalpropor1I + $cuotapropor1;
                          $totalpropor2I = $totalpropor2I + $cuotapropor2;
                          $totalcuotaI = $totalcuotaI + $cuota;

                          }
                          
                        }
          }
                        $pdf->Ln(8);
                        $pdf->SetFont('Arial','B',8);
                        $pdf->Cell(40,4,utf8_decode('SERVICIO'),0,0,'L');
                        $pdf->Cell(50,4,utf8_decode('PRIMER PROPORCIÓN '.$propor.':'),0,0,'L');
                        $pdf->Cell(50,4,utf8_decode('SEGUNDA PROPORCIÓN '.$propor2.':'),0,0,'L');
                        $pdf->Cell(50,4,utf8_decode('TOTAL'),0,1,'L');
                        $pdf->SetFont('Arial','',8);
                        $pdf->Cell(40,4,utf8_decode('CABLE'),"T",0,'L');
                        $pdf->Cell(50,4,'$ '.number_format($totalpropor1C,2),"T",0,'L');
                        $pdf->Cell(50,4,'$ '.number_format($totalpropor2C,2),"T",0,'L');
                        $pdf->Cell(50,4,'$ '.number_format($totalcuotaC,2),"T",1,'L');

                        $pdf->Ln(1);
                        $pdf->Cell(40,4,utf8_decode('INTERNET'),"T",0,'L');
                        $pdf->Cell(50,4,'$ '.number_format($totalpropor1I,2),"T",0,'L');
                        $pdf->Cell(50,4,'$ '.number_format($totalpropor2I,2),"T",0,'L');
                        $pdf->Cell(50,4,'$ '.number_format($totalcuotaI,2),"T",1,'L');
                        $pdf->Ln(1);
                        $pdf->SetFont('Arial','I',8);
                        $pdf->SetFillColor(207,216,220);
                        $pdf->Cell(70,5,utf8_decode('TOTAL PRIMER PROPORCIÓN '.$propor.':'),"BTL",0,'R',1);
                        $pdf->Cell(20,5,'$ '.number_format(($totalpropor1I+$totalpropor1C),2),"BTR",1,'L',1);
                        $pdf->Ln(1);
                        $pdf->SetFont('Arial','I',8);
                        $pdf->SetFillColor(207,216,220);
                        $pdf->Cell(70,5,utf8_decode('TOTAL SEGUNDA PROPORCIÓN '.$propor2.':'),"BTL",0,'R',1);
                        $pdf->Cell(20,5,'$ '.number_format(($totalpropor2I+$totalpropor2C),2),"BTR",1,'L',1);
                        $pdf->Ln(1);
                        $pdf->SetFont('Arial','I',8);
                        $pdf->SetFillColor(207,216,220);
                        $pdf->Cell(70,5,utf8_decode('TOTAL '.":"),"BTL",0,'R',1);
                        $pdf->Cell(20,5,'$ '.number_format(($totalcuotaI+$totalcuotaC),2),"BTR",1,'L',1);
                        $pdf->Ln(40);
                        $pdf->Cell(200,5,utf8_decode(''),'B',1,'C');

}
    /* close connection */
    mysqli_close($mysqli);
    $pdf->Output();

                      
                }

  abonos();

?>