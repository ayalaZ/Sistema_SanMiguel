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
    global $desde, $hasta, $codigoCobrador, $colonia, $tipoServicio,$cesc,$iva, $mysqli /*$statement1*/;
      global $totalAnticipoSoloCable,$totalAnticipoCable,$totalAnticipoImpuestoC,$totalAnticipoSoloInter,$totalAnticipoInter,$totalAnticipoImpuestoI;
      global $totalSoloCable,$totalCable,$totalImpuestoC,$totalSoloInter,$totalInter,$totalImpuestoI,$anulada,$detallado,$anticipado,$recibo_anulado;

        if (isset($detallado)){
          if ($detallado == 1){

            $pdf = new FPDF();

              $pdf->AddPage('L','Letter');
              $pdf->SetAutoPageBreak(false, 10);
              $pdf->SetFont('Arial','',6);
              date_default_timezone_set('America/El_Salvador');
              $pdf->Cell(260,6,utf8_decode("Página ".str_pad($pdf->pageNo(),4,"0",STR_PAD_LEFT)),0,1,'R');
              $pdf->Cell(260,4,utf8_decode("IMPRESO POR: ".strtoupper($_SESSION['nombres'])." ".strtoupper($_SESSION['apellidos']). " ".date('d/m/Y h:i:s')),"",1,'R');
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
              $pdf->Cell(190, 4, utf8_decode('DETALLE DE ANTICIPOS LIQUIDADOS'), 0, 1, 'L');
              if ($_SESSION['db'] == 'satpro_sm'){
                  $pdf->Cell(190, 4, utf8_decode('SUCURSAL SAN MIGUEL'), 0, 1, 'L');

              }elseif ($_SESSION['db'] == 'satpro'){
                  $pdf->Cell(190, 4, utf8_decode('SUCURSAL USULUTÁN'), 0, 1, 'L');
              }else{
                  $pdf->Cell(190, 4, utf8_decode('SUCURSAL DE PRUEBA'), 0, 1, 'L');
              }
              $pdf->SetFont('Arial', '', 7);
              $pdf->Cell(190, 4, utf8_decode('FECHA DE GENERACIÓN DESDE '.$desde.' HASTA '.$hasta), 0, 1, 'L');
              $pdf->Ln(2);

              $pdf->SetFont('Arial','B',6.5);
              $pdf->Cell(20,5,utf8_decode('N°'),1,0,'L');
              $pdf->Cell(20,5,utf8_decode('N° de recibo'),1,0,'L');
              $pdf->Cell(20,5,utf8_decode('Fecha'),1,0,'L');
              $pdf->Cell(70,5,utf8_decode('Cliente'),1,0,'L');
              $pdf->Cell(20,5,utf8_decode('Mes que abonó'),1,0,'L');
              $pdf->Cell(12,5,utf8_decode('Día cobro'),1,0,'L');
              $pdf->Cell(20,5,utf8_decode('Tipo servicio'),1,0,'L');
              $pdf->Cell(25,5,utf8_decode('N° Factura'),1,0,'L');
              $pdf->Cell(20,5,utf8_decode('Generación'),1,0,'L');
              $pdf->Cell(20,5,utf8_decode('Valor Liquidado'),1,0,'L');
              $pdf->Ln(8);

              $counter2=1;
              $counter3=1;
              if($tipoServicio === "A") {
                $query10 = "SELECT mesCargo, codigoCliente, tipoServicio, fechaFactura FROM tbl_cargos WHERE fechaFactura BETWEEN '".$desde."' AND '".$hasta."' AND anulada = '0' ORDER BY numeroFactura";
                $resultado10 = $mysqli->query($query10);
                while($row1 = $resultado10->fetch_assoc())
                            {
                              $query = "SELECT * FROM tbl_abonos WHERE anticipado= '".$anticipado."' AND mesCargo= '".$row1['mesCargo']."' AND codigoCliente= '".$row1['codigoCliente']."' AND tipoServicio= '".$row1['tipoServicio']."' AND fechaAbonado < '".$row1['fechaFactura']."' AND anulada='0'";
                              $resultado = $mysqli->query($query);

            /////////////////////////////////////////////
            // inicio de la consulta
            /////////////////////////////////////////////
        while($row = $resultado->fetch_assoc())
        {
                                  if ($row["tipoServicio"] == "C") {
                              $query2 = "SELECT dia_cobro FROM clientes WHERE cod_cliente= ".$row['codigoCliente'];
                              // Preparación de sentencia
                              $statement2 = $mysqli->query($query2);
                              //$statement->execute();
                              while ($result2 = $statement2->fetch_assoc()) {
                                  $diaCobro = $result2['dia_cobro'];
                              }
                                }elseif ($row["tipoServicio"]  == "I") {
                              $query2 = "SELECT dia_corbo_in FROM clientes WHERE cod_cliente= ".$row['codigoCliente'];
                              // Preparación de sentencia
                              $statement2 = $mysqli->query($query2);
                              //$statement->execute();
                              while ($result2 = $statement2->fetch_assoc()) {
                                  $diaCobro = $result2['dia_corbo_in'];
                              }
                          }
                          /////////////////////////////////////////////////////////////////
                          /*
                          INICIO
                          */
                          /////////////////////////////////////////////////////////////////
                          $pdf->Ln(3);
                          $pdf->SetFont('Arial','',6.5);
                          $pdf->Cell(10,0,utf8_decode($counter3),0,0,'L');
                          /////////////////////////////////////////////////////////////////
                        
                            # code... CONDICIONAL PARA ESTABLECER SI ES ANULADO MOSTRAR UNA SERIE DE DATOS DIFERENTES
                          //var_dump($row['mesCargo']);
                              //var_dump($row['codigoCliente']);
                          $pdf->Cell(10,0,utf8_decode($row['idAbono']),0,0,'L');
                          $pdf->Cell(20,0,utf8_decode($row['numeroRecibo']),0,0,'L');
                          $pdf->Cell(20,0,utf8_decode($row['fechaAbonado']),0,0,'L');
                          $pdf->Cell(75,0,utf8_decode(strtoupper($row['codigoCliente']."  ".$row['nombre'])),0,0,'L');
                          $pdf->Cell(18,0,utf8_decode($row['mesCargo']),0,0,'L');
                          $pdf->Cell(18,0,utf8_decode($diaCobro),0,0,'L');
                          $pdf->Cell(12,0,utf8_decode($row['tipoServicio']),0,0,'L');

                          $query5 = "SELECT numeroFactura, fechaFactura, mesCargo FROM tbl_cargos WHERE codigoCliente='".$row['codigoCliente']."' AND mesCargo='".$row['mesCargo']."' AND tipoServicio='".$row['tipoServicio']."' AND anulada='".$anulada."'";
                                    $resultado5 = $mysqli->query($query5);
                                    while ($row5 = $resultado5->fetch_assoc())
                                    {
                                      $pdf->Cell(27,0,utf8_decode($row5['numeroFactura']),0,0,'L');
                                      $pdf->Cell(20,0,utf8_decode($row5['fechaFactura']),0,0,'L');
                                      //var_dump($row5['numeroFactura']);
                                      //var_dump($row5['fechaFactura']);
                                      
                                    }
                          //$totalTotalCobrador = 0;
                          if ($row['anticipado'] == "1" || $row['anticipado'] == "T") {
                              if ($row['tipoServicio'] == "C") {
                                 
                                  $pdf->Cell(20,0,'$ '.utf8_decode(number_format($row['cuotaCable'],2)),0,0,'L');
                                  $totalAnticipoSoloCable = doubleval($totalAnticipoSoloCable) + doubleval($row['cuotaCable']);
                                  //$totalAnticipoCobradorCable = $totalAnticipoCobradorCable + doubleval($row['cuotaCable']);
                                  $totalAnticipoCable = doubleval($totalAnticipoCable) + doubleval($row['cuotaCable'])+doubleval($row['totalImpuesto']);
                                  $totalAnticipoImpuestoC = doubleval($totalAnticipoImpuestoC) + doubleval($row['totalImpuesto']);
                                  //$totalAnticipoImpuestoCobradorC = $totalAnticipoImpuestoCobradorC + doubleval($row['totalImpuesto']);
                              }elseif ($row['tipoServicio'] == "I") {
                                  $pdf->Cell(20,0,'$ '.utf8_decode(number_format($row['cuotaInternet'],2)),0,0,'L');
                                  $totalAnticipoSoloInter = doubleval($totalAnticipoSoloInter) + doubleval($row['cuotaInternet']);
                                  //$totalAnticipoCobradorInter = $totalAnticipoCobradorInter + doubleval($row['cuotaInternet']);
                                  $totalAnticipoInter = doubleval($totalAnticipoInter) + doubleval($row['cuotaInternet'])+doubleval($row['totalImpuesto']);
                                  $totalAnticipoImpuestoI = doubleval($totalAnticipoImpuestoI) + doubleval($row['totalImpuesto']);
                                  //$totalAnticipoImpuestoCobradorI = $totalAnticipoImpuestoCobradorI + doubleval($row['totalImpuesto']);
                              }

                          }else {
                              if ($row['tipoServicio'] == "C") {
                                  $pdf->Cell(20,0,'%*/ '.utf8_decode(number_format($row['cuotaCable'],2)),0,0,'L');
                                  $pdf->Cell(20,0,utf8_decode("PASA AQUI"),0,0,'L');
                                  $pdf->Cell(15,0,utf8_decode(number_format($row['totalImpuesto'],2)),0,0,'L');
                              //    $pdf->Cell(20,0,utf8_decode('PRUEBA'),0,0,'L'); //// prueba para ingresar comision banco
                                  $pdf->Cell(20,0,utf8_decode(number_format(doubleval($row['cuotaCable'])+doubleval($row['totalImpuesto']),2)),0,1,'L');
                                  $totalSoloCable = doubleval($totalSoloCable) + doubleval($row['cuotaCable']);
                                  //$totalCobradorCable = $totalCobradorCable + doubleval($row['cuotaCable']);
                                  $totalCable = doubleval($totalCable) + doubleval($row['cuotaCable'])+doubleval($row['totalImpuesto']);
                                  $totalImpuestoC = doubleval($totalImpuestoC) + doubleval($row['totalImpuesto']);
                                  //$totalImpuestoCobradorC = $totalImpuestoCobradorC + doubleval($row['totalImpuesto']);
                              }elseif ($row['tipoServicio'] == "I") {
                                  $pdf->Cell(20,0,'%*/ '.utf8_decode(number_format($row['cuotaInternet'],2)),0,0,'L');
                                  $pdf->Cell(20,0,utf8_decode("PASA AQUI"),0,0,'L');
                                  $pdf->Cell(15,0,utf8_decode(number_format($row['totalImpuesto'],2)),0,0,'L');
                                  $pdf->Cell(20,0,utf8_decode(number_format(doubleval($row['cuotaInternet'])+doubleval($row['totalImpuesto']),2)),0,1,'L');
                                  $totalSoloInter = doubleval($totalSoloInter) + doubleval($row['cuotaInternet']);
                                  $totalInter = doubleval($totalInter) + doubleval($row['cuotaInternet'])+doubleval($row['totalImpuesto']);
                                  //$totalCobradorInter = $totalCobradorInter + doubleval($row['cuotaInternet']);
                                  $totalImpuestoI = doubleval($totalImpuestoI) + doubleval($row['totalImpuesto']);
                                  //$totalImpuestoCobradorI = $totalImpuestoCobradorI + doubleval($row['totalImpuesto']);
                              }


                          }
                       
                          /////////////////////////////////////////////////////////////////
                          if ($counter2 > 35){
                              $pdf->AddPage('L','Letter');
                              $pdf->SetAutoPageBreak(false, 10);
                              $pdf->SetFont('Arial','',6);
                              date_default_timezone_set('America/El_Salvador');
                              $pdf->Cell(260,6,utf8_decode("Página ".str_pad($pdf->pageNo(),4,"0",STR_PAD_LEFT)),0,1,'R');
                              $pdf->Cell(260,4,utf8_decode("IMPRESO POR: ".strtoupper($_SESSION['nombres'])." ".strtoupper($_SESSION['apellidos']). " ".date('d/m/Y h:i:s')),"",1,'R');
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
                              $pdf->Cell(190, 4, utf8_decode('DETALLE DE ANTICIPOS LIQUIDADOS'), 0, 1, 'L');
                              if ($_SESSION['db'] == 'satpro_sm'){
                                  $pdf->Cell(190, 4, utf8_decode('SUCURSAL SAN MIGUEL'), 0, 1, 'L');

                              }elseif ($_SESSION['db'] == 'satpro'){
                                  $pdf->Cell(190, 4, utf8_decode('SUCURSAL USULUTÁN'), 0, 1, 'L');
                              }else{
                                  $pdf->Cell(190, 4, utf8_decode('SUCURSAL DE PRUEBA'), 0, 1, 'L');
                              }
                              $pdf->SetFont('Arial', '', 7);
                              $pdf->Cell(190, 4, utf8_decode('FECHA DE GENERACIÓN DESDE '.$desde.' HASTA '.$hasta), 0, 1, 'L');
                              $pdf->Ln(2);

                              $pdf->SetFont('Arial','B',6.5);
                              $pdf->Cell(20,5,utf8_decode('N°'),1,0,'L');
                              $pdf->Cell(20,5,utf8_decode('N° de recibo'),1,0,'L');
                              $pdf->Cell(20,5,utf8_decode('Fecha'),1,0,'L');
                              $pdf->Cell(70,5,utf8_decode('Cliente'),1,0,'L');
                              $pdf->Cell(20,5,utf8_decode('Mes que abonó'),1,0,'L');
                              $pdf->Cell(12,5,utf8_decode('Día cobro'),1,0,'L');
                              $pdf->Cell(20,5,utf8_decode('Tipo servicio'),1,0,'L');
                              $pdf->Cell(25,5,utf8_decode('N° Factura'),1,0,'L');
                              $pdf->Cell(20,5,utf8_decode('Generación'),1,0,'L');
                              $pdf->Cell(20,5,utf8_decode('Valor Liquidado'),1,0,'L');
                              $pdf->Ln(8);
                              $counter2=1;
                          }
                          $counter2++;
                          $counter3++;

                      }
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
                              
                            }
                            
            }elseif ($tipoServicio == "C") {
                 $query10 = "SELECT mesCargo, codigoCliente, tipoServicio, fechaFactura FROM tbl_cargos WHERE fechaFactura BETWEEN '".$desde."' AND '".$hasta."' AND anulada = '0' AND tipoServicio= '".$tipoServicio."' ORDER BY numeroFactura";
                $resultado10 = $mysqli->query($query10);
                while($row1 = $resultado10->fetch_assoc())
                            {
                              $query = "SELECT * FROM tbl_abonos WHERE anticipado= '".$anticipado."' AND mesCargo= '".$row1['mesCargo']."' AND codigoCliente= '".$row1['codigoCliente']."' AND tipoServicio= '".$row1['tipoServicio']."' AND fechaAbonado < '".$row1['fechaFactura']."' AND anulada='0'";
                              $resultado = $mysqli->query($query);

            /////////////////////////////////////////////
            // inicio de la consulta
            /////////////////////////////////////////////
        while($row = $resultado->fetch_assoc())
        {
                                  if ($row["tipoServicio"] == "C") {
                              $query2 = "SELECT dia_cobro FROM clientes WHERE cod_cliente= ".$row['codigoCliente'];
                              // Preparación de sentencia
                              $statement2 = $mysqli->query($query2);
                              //$statement->execute();
                              while ($result2 = $statement2->fetch_assoc()) {
                                  $diaCobro = $result2['dia_cobro'];
                              }
                                }elseif ($row["tipoServicio"]  == "I") {
                              $query2 = "SELECT dia_corbo_in FROM clientes WHERE cod_cliente= ".$row['codigoCliente'];
                              // Preparación de sentencia
                              $statement2 = $mysqli->query($query2);
                              //$statement->execute();
                              while ($result2 = $statement2->fetch_assoc()) {
                                  $diaCobro = $result2['dia_corbo_in'];
                              }
                          }
                          /////////////////////////////////////////////////////////////////
                          /*
                          INICIO
                          */
                          /////////////////////////////////////////////////////////////////
                          $pdf->Ln(3);
                          $pdf->SetFont('Arial','',6.5);
                          $pdf->Cell(10,0,utf8_decode($counter3),0,0,'L');
                          /////////////////////////////////////////////////////////////////
                        
                            # code... CONDICIONAL PARA ESTABLECER SI ES ANULADO MOSTRAR UNA SERIE DE DATOS DIFERENTES
                          //var_dump($row['mesCargo']);
                              //var_dump($row['codigoCliente']);
                          $pdf->Cell(10,0,utf8_decode($row['idAbono']),0,0,'L');
                          $pdf->Cell(20,0,utf8_decode($row['numeroRecibo']),0,0,'L');
                          $pdf->Cell(20,0,utf8_decode($row['fechaAbonado']),0,0,'L');
                          $pdf->Cell(75,0,utf8_decode(strtoupper($row['codigoCliente']."  ".$row['nombre'])),0,0,'L');
                          $pdf->Cell(18,0,utf8_decode($row['mesCargo']),0,0,'L');
                          $pdf->Cell(18,0,utf8_decode($diaCobro),0,0,'L');
                          $pdf->Cell(12,0,utf8_decode($row['tipoServicio']),0,0,'L');

                          $query5 = "SELECT numeroFactura, fechaFactura, mesCargo FROM tbl_cargos WHERE codigoCliente='".$row['codigoCliente']."' AND mesCargo='".$row['mesCargo']."' AND tipoServicio='".$row['tipoServicio']."' AND anulada='".$anulada."'";
                                    $resultado5 = $mysqli->query($query5);
                                    while ($row5 = $resultado5->fetch_assoc())
                                    {
                                      $pdf->Cell(27,0,utf8_decode($row5['numeroFactura']),0,0,'L');
                                      $pdf->Cell(20,0,utf8_decode($row5['fechaFactura']),0,0,'L');
                                      //var_dump($row5['numeroFactura']);
                                      //var_dump($row5['fechaFactura']);
                                      
                                    }
                          //$totalTotalCobrador = 0;
                          if ($row['anticipado'] == "1" || $row['anticipado'] == "T") {
                              if ($row['tipoServicio'] == "C") {
                                 
                                  $pdf->Cell(20,0,'$ '.utf8_decode(number_format($row['cuotaCable'],2)),0,0,'L');
                                  $totalAnticipoSoloCable = doubleval($totalAnticipoSoloCable) + doubleval($row['cuotaCable']);
                                  //$totalAnticipoCobradorCable = $totalAnticipoCobradorCable + doubleval($row['cuotaCable']);
                                  $totalAnticipoCable = doubleval($totalAnticipoCable) + doubleval($row['cuotaCable'])+doubleval($row['totalImpuesto']);
                                  $totalAnticipoImpuestoC = doubleval($totalAnticipoImpuestoC) + doubleval($row['totalImpuesto']);
                                  //$totalAnticipoImpuestoCobradorC = $totalAnticipoImpuestoCobradorC + doubleval($row['totalImpuesto']);
                              }elseif ($row['tipoServicio'] == "I") {
                                  $pdf->Cell(20,0,'$ '.utf8_decode(number_format($row['cuotaInternet'],2)),0,0,'L');
                                  $totalAnticipoSoloInter = doubleval($totalAnticipoSoloInter) + doubleval($row['cuotaInternet']);
                                  //$totalAnticipoCobradorInter = $totalAnticipoCobradorInter + doubleval($row['cuotaInternet']);
                                  $totalAnticipoInter = doubleval($totalAnticipoInter) + doubleval($row['cuotaInternet'])+doubleval($row['totalImpuesto']);
                                  $totalAnticipoImpuestoI = doubleval($totalAnticipoImpuestoI) + doubleval($row['totalImpuesto']);
                                  //$totalAnticipoImpuestoCobradorI = $totalAnticipoImpuestoCobradorI + doubleval($row['totalImpuesto']);
                              }

                          }else {
                              if ($row['tipoServicio'] == "C") {
                                  $pdf->Cell(20,0,'%*/ '.utf8_decode(number_format($row['cuotaCable'],2)),0,0,'L');
                                  $pdf->Cell(20,0,utf8_decode("PASA AQUI"),0,0,'L');
                                  $pdf->Cell(15,0,utf8_decode(number_format($row['totalImpuesto'],2)),0,0,'L');
                              //    $pdf->Cell(20,0,utf8_decode('PRUEBA'),0,0,'L'); //// prueba para ingresar comision banco
                                  $pdf->Cell(20,0,utf8_decode(number_format(doubleval($row['cuotaCable'])+doubleval($row['totalImpuesto']),2)),0,1,'L');
                                  $totalSoloCable = doubleval($totalSoloCable) + doubleval($row['cuotaCable']);
                                  //$totalCobradorCable = $totalCobradorCable + doubleval($row['cuotaCable']);
                                  $totalCable = doubleval($totalCable) + doubleval($row['cuotaCable'])+doubleval($row['totalImpuesto']);
                                  $totalImpuestoC = doubleval($totalImpuestoC) + doubleval($row['totalImpuesto']);
                                  //$totalImpuestoCobradorC = $totalImpuestoCobradorC + doubleval($row['totalImpuesto']);
                              }elseif ($row['tipoServicio'] == "I") {
                                  $pdf->Cell(20,0,'%*/ '.utf8_decode(number_format($row['cuotaInternet'],2)),0,0,'L');
                                  $pdf->Cell(20,0,utf8_decode("PASA AQUI"),0,0,'L');
                                  $pdf->Cell(15,0,utf8_decode(number_format($row['totalImpuesto'],2)),0,0,'L');
                                  $pdf->Cell(20,0,utf8_decode(number_format(doubleval($row['cuotaInternet'])+doubleval($row['totalImpuesto']),2)),0,1,'L');
                                  $totalSoloInter = doubleval($totalSoloInter) + doubleval($row['cuotaInternet']);
                                  $totalInter = doubleval($totalInter) + doubleval($row['cuotaInternet'])+doubleval($row['totalImpuesto']);
                                  //$totalCobradorInter = $totalCobradorInter + doubleval($row['cuotaInternet']);
                                  $totalImpuestoI = doubleval($totalImpuestoI) + doubleval($row['totalImpuesto']);
                                  //$totalImpuestoCobradorI = $totalImpuestoCobradorI + doubleval($row['totalImpuesto']);
                              }


                          }
                       
                          /////////////////////////////////////////////////////////////////
                          if ($counter2 > 35){
                              $pdf->AddPage('L','Letter');
                              $pdf->SetAutoPageBreak(false, 10);
                              $pdf->SetFont('Arial','',6);
                              date_default_timezone_set('America/El_Salvador');
                              $pdf->Cell(260,6,utf8_decode("Página ".str_pad($pdf->pageNo(),4,"0",STR_PAD_LEFT)),0,1,'R');
                              $pdf->Cell(260,4,utf8_decode("IMPRESO POR: ".strtoupper($_SESSION['nombres'])." ".strtoupper($_SESSION['apellidos']). " ".date('d/m/Y h:i:s')),"",1,'R');
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
                              $pdf->Cell(190, 4, utf8_decode('DETALLE DE ANTICIPOS LIQUIDADOS'), 0, 1, 'L');
                              if ($_SESSION['db'] == 'satpro_sm'){
                                  $pdf->Cell(190, 4, utf8_decode('SUCURSAL SAN MIGUEL'), 0, 1, 'L');

                              }elseif ($_SESSION['db'] == 'satpro'){
                                  $pdf->Cell(190, 4, utf8_decode('SUCURSAL USULUTÁN'), 0, 1, 'L');
                              }else{
                                  $pdf->Cell(190, 4, utf8_decode('SUCURSAL DE PRUEBA'), 0, 1, 'L');
                              }
                              $pdf->SetFont('Arial', '', 7);
                              $pdf->Cell(190, 4, utf8_decode('FECHA DE GENERACIÓN DESDE '.$desde.' HASTA '.$hasta), 0, 1, 'L');
                              $pdf->Ln(2);

                              $pdf->SetFont('Arial','B',6.5);
                              $pdf->Cell(20,5,utf8_decode('N°'),1,0,'L');
                              $pdf->Cell(20,5,utf8_decode('N° de recibo'),1,0,'L');
                              $pdf->Cell(20,5,utf8_decode('Fecha'),1,0,'L');
                              $pdf->Cell(70,5,utf8_decode('Cliente'),1,0,'L');
                              $pdf->Cell(20,5,utf8_decode('Mes que abonó'),1,0,'L');
                              $pdf->Cell(12,5,utf8_decode('Día cobro'),1,0,'L');
                              $pdf->Cell(20,5,utf8_decode('Tipo servicio'),1,0,'L');
                              $pdf->Cell(25,5,utf8_decode('N° Factura'),1,0,'L');
                              $pdf->Cell(20,5,utf8_decode('Generación'),1,0,'L');
                              $pdf->Cell(20,5,utf8_decode('Valor Liquidado'),1,0,'L');
                              $pdf->Ln(8);
                              $counter2=1;
                          }
                          $counter2++;
                          $counter3++;

                      }
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
                              
                            }
            }elseif ($tipoServicio == "I") {
                $query10 = "SELECT mesCargo, codigoCliente, tipoServicio, fechaFactura FROM tbl_cargos WHERE fechaFactura BETWEEN '".$desde."' AND '".$hasta."' AND anulada = '0' AND tipoServicio= '".$tipoServicio."' ORDER BY numeroFactura";
                $resultado10 = $mysqli->query($query10);
                while($row1 = $resultado10->fetch_assoc())
                            {
                              $query = "SELECT * FROM tbl_abonos WHERE anticipado= '".$anticipado."' AND mesCargo= '".$row1['mesCargo']."' AND codigoCliente= '".$row1['codigoCliente']."' AND tipoServicio= '".$row1['tipoServicio']."' AND fechaAbonado < '".$row1['fechaFactura']."' AND anulada='0'";
                              $resultado = $mysqli->query($query);

            /////////////////////////////////////////////
            // inicio de la consulta
            /////////////////////////////////////////////
        while($row = $resultado->fetch_assoc())
        {
                                  if ($row["tipoServicio"] == "C") {
                              $query2 = "SELECT dia_cobro FROM clientes WHERE cod_cliente= ".$row['codigoCliente'];
                              // Preparación de sentencia
                              $statement2 = $mysqli->query($query2);
                              //$statement->execute();
                              while ($result2 = $statement2->fetch_assoc()) {
                                  $diaCobro = $result2['dia_cobro'];
                              }
                                }elseif ($row["tipoServicio"]  == "I") {
                              $query2 = "SELECT dia_corbo_in FROM clientes WHERE cod_cliente= ".$row['codigoCliente'];
                              // Preparación de sentencia
                              $statement2 = $mysqli->query($query2);
                              //$statement->execute();
                              while ($result2 = $statement2->fetch_assoc()) {
                                  $diaCobro = $result2['dia_corbo_in'];
                              }
                          }
                          /////////////////////////////////////////////////////////////////
                          /*
                          INICIO
                          */
                          /////////////////////////////////////////////////////////////////
                          $pdf->Ln(3);
                          $pdf->SetFont('Arial','',6.5);
                          $pdf->Cell(10,0,utf8_decode($counter3),0,0,'L');
                          /////////////////////////////////////////////////////////////////
                        
                            # code... CONDICIONAL PARA ESTABLECER SI ES ANULADO MOSTRAR UNA SERIE DE DATOS DIFERENTES
                          //var_dump($row['mesCargo']);
                              //var_dump($row['codigoCliente']);
                          $pdf->Cell(10,0,utf8_decode($row['idAbono']),0,0,'L');
                          $pdf->Cell(20,0,utf8_decode($row['numeroRecibo']),0,0,'L');
                          $pdf->Cell(20,0,utf8_decode($row['fechaAbonado']),0,0,'L');
                          $pdf->Cell(75,0,utf8_decode(strtoupper($row['codigoCliente']."  ".$row['nombre'])),0,0,'L');
                          $pdf->Cell(18,0,utf8_decode($row['mesCargo']),0,0,'L');
                          $pdf->Cell(18,0,utf8_decode($diaCobro),0,0,'L');
                          $pdf->Cell(12,0,utf8_decode($row['tipoServicio']),0,0,'L');

                          $query5 = "SELECT numeroFactura, fechaFactura, mesCargo FROM tbl_cargos WHERE codigoCliente='".$row['codigoCliente']."' AND mesCargo='".$row['mesCargo']."' AND tipoServicio='".$row['tipoServicio']."' AND anulada='".$anulada."'";
                                    $resultado5 = $mysqli->query($query5);
                                    while ($row5 = $resultado5->fetch_assoc())
                                    {
                                      $pdf->Cell(27,0,utf8_decode($row5['numeroFactura']),0,0,'L');
                                      $pdf->Cell(20,0,utf8_decode($row5['fechaFactura']),0,0,'L');
                                      //var_dump($row5['numeroFactura']);
                                      //var_dump($row5['fechaFactura']);
                                      
                                    }
                          //$totalTotalCobrador = 0;
                          if ($row['anticipado'] == "1" || $row['anticipado'] == "T") {
                              if ($row['tipoServicio'] == "C") {
                                 
                                  $pdf->Cell(20,0,'$ '.utf8_decode(number_format($row['cuotaCable'],2)),0,0,'L');
                                  $totalAnticipoSoloCable = doubleval($totalAnticipoSoloCable) + doubleval($row['cuotaCable']);
                                  //$totalAnticipoCobradorCable = $totalAnticipoCobradorCable + doubleval($row['cuotaCable']);
                                  $totalAnticipoCable = doubleval($totalAnticipoCable) + doubleval($row['cuotaCable'])+doubleval($row['totalImpuesto']);
                                  $totalAnticipoImpuestoC = doubleval($totalAnticipoImpuestoC) + doubleval($row['totalImpuesto']);
                                  //$totalAnticipoImpuestoCobradorC = $totalAnticipoImpuestoCobradorC + doubleval($row['totalImpuesto']);
                              }elseif ($row['tipoServicio'] == "I") {
                                  $pdf->Cell(20,0,'$ '.utf8_decode(number_format($row['cuotaInternet'],2)),0,0,'L');
                                  $totalAnticipoSoloInter = doubleval($totalAnticipoSoloInter) + doubleval($row['cuotaInternet']);
                                  //$totalAnticipoCobradorInter = $totalAnticipoCobradorInter + doubleval($row['cuotaInternet']);
                                  $totalAnticipoInter = doubleval($totalAnticipoInter) + doubleval($row['cuotaInternet'])+doubleval($row['totalImpuesto']);
                                  $totalAnticipoImpuestoI = doubleval($totalAnticipoImpuestoI) + doubleval($row['totalImpuesto']);
                                  //$totalAnticipoImpuestoCobradorI = $totalAnticipoImpuestoCobradorI + doubleval($row['totalImpuesto']);
                              }

                          }else {
                              if ($row['tipoServicio'] == "C") {
                                  $pdf->Cell(20,0,'%*/ '.utf8_decode(number_format($row['cuotaCable'],2)),0,0,'L');
                                  $pdf->Cell(20,0,utf8_decode("PASA AQUI"),0,0,'L');
                                  $pdf->Cell(15,0,utf8_decode(number_format($row['totalImpuesto'],2)),0,0,'L');
                              //    $pdf->Cell(20,0,utf8_decode('PRUEBA'),0,0,'L'); //// prueba para ingresar comision banco
                                  $pdf->Cell(20,0,utf8_decode(number_format(doubleval($row['cuotaCable'])+doubleval($row['totalImpuesto']),2)),0,1,'L');
                                  $totalSoloCable = doubleval($totalSoloCable) + doubleval($row['cuotaCable']);
                                  //$totalCobradorCable = $totalCobradorCable + doubleval($row['cuotaCable']);
                                  $totalCable = doubleval($totalCable) + doubleval($row['cuotaCable'])+doubleval($row['totalImpuesto']);
                                  $totalImpuestoC = doubleval($totalImpuestoC) + doubleval($row['totalImpuesto']);
                                  //$totalImpuestoCobradorC = $totalImpuestoCobradorC + doubleval($row['totalImpuesto']);
                              }elseif ($row['tipoServicio'] == "I") {
                                  $pdf->Cell(20,0,'%*/ '.utf8_decode(number_format($row['cuotaInternet'],2)),0,0,'L');
                                  $pdf->Cell(20,0,utf8_decode("PASA AQUI"),0,0,'L');
                                  $pdf->Cell(15,0,utf8_decode(number_format($row['totalImpuesto'],2)),0,0,'L');
                                  $pdf->Cell(20,0,utf8_decode(number_format(doubleval($row['cuotaInternet'])+doubleval($row['totalImpuesto']),2)),0,1,'L');
                                  $totalSoloInter = doubleval($totalSoloInter) + doubleval($row['cuotaInternet']);
                                  $totalInter = doubleval($totalInter) + doubleval($row['cuotaInternet'])+doubleval($row['totalImpuesto']);
                                  //$totalCobradorInter = $totalCobradorInter + doubleval($row['cuotaInternet']);
                                  $totalImpuestoI = doubleval($totalImpuestoI) + doubleval($row['totalImpuesto']);
                                  //$totalImpuestoCobradorI = $totalImpuestoCobradorI + doubleval($row['totalImpuesto']);
                              }


                          }
                       
                          /////////////////////////////////////////////////////////////////
                          if ($counter2 > 35){
                              $pdf->AddPage('L','Letter');
                              $pdf->SetAutoPageBreak(false, 10);
                              $pdf->SetFont('Arial','',6);
                              date_default_timezone_set('America/El_Salvador');
                              $pdf->Cell(260,6,utf8_decode("Página ".str_pad($pdf->pageNo(),4,"0",STR_PAD_LEFT)),0,1,'R');
                              $pdf->Cell(260,4,utf8_decode("IMPRESO POR: ".strtoupper($_SESSION['nombres'])." ".strtoupper($_SESSION['apellidos']). " ".date('d/m/Y h:i:s')),"",1,'R');
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
                              $pdf->Cell(190, 4, utf8_decode('DETALLE DE ANTICIPOS LIQUIDADOS'), 0, 1, 'L');
                              if ($_SESSION['db'] == 'satpro_sm'){
                                  $pdf->Cell(190, 4, utf8_decode('SUCURSAL SAN MIGUEL'), 0, 1, 'L');

                              }elseif ($_SESSION['db'] == 'satpro'){
                                  $pdf->Cell(190, 4, utf8_decode('SUCURSAL USULUTÁN'), 0, 1, 'L');
                              }else{
                                  $pdf->Cell(190, 4, utf8_decode('SUCURSAL DE PRUEBA'), 0, 1, 'L');
                              }
                              $pdf->SetFont('Arial', '', 7);
                              $pdf->Cell(190, 4, utf8_decode('FECHA DE GENERACIÓN DESDE '.$desde.' HASTA '.$hasta), 0, 1, 'L');
                              $pdf->Ln(2);

                              $pdf->SetFont('Arial','B',6.5);
                              $pdf->Cell(20,5,utf8_decode('N°'),1,0,'L');
                              $pdf->Cell(20,5,utf8_decode('N° de recibo'),1,0,'L');
                              $pdf->Cell(20,5,utf8_decode('Fecha'),1,0,'L');
                              $pdf->Cell(70,5,utf8_decode('Cliente'),1,0,'L');
                              $pdf->Cell(20,5,utf8_decode('Mes que abonó'),1,0,'L');
                              $pdf->Cell(12,5,utf8_decode('Día cobro'),1,0,'L');
                              $pdf->Cell(20,5,utf8_decode('Tipo servicio'),1,0,'L');
                              $pdf->Cell(25,5,utf8_decode('N° Factura'),1,0,'L');
                              $pdf->Cell(20,5,utf8_decode('Generación'),1,0,'L');
                              $pdf->Cell(20,5,utf8_decode('Valor Liquidado'),1,0,'L');
                              $pdf->Ln(8);
                              $counter2=1;
                          }
                          $counter2++;
                          $counter3++;

                      }
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
                              
                            }
            }




                      $pdf->Ln(1);
              $pdf->Cell(185,4,utf8_decode(''),0,0,'R');
              $pdf->Cell(75,4,utf8_decode(''),"",1,'R');
              $pdf->SetFont('Arial','B',8);

              $pdf->Cell(200,4,utf8_decode('TOTALES GENERALES'),'',1,'R');
              $pdf->SetFont('Arial','',8);
              //TOTAL INTERNET
              $pdf->Cell(180,4,utf8_decode('TOTAL INTERNET: '),0,0,'R');
              $pdf->Cell(20,4,"+ ".'$'.number_format($totalAnticipoSoloInter,2),"T",1,'L');
              //TOTAL CABLE
              $pdf->Cell(180,4,utf8_decode('TOTAL CABLE: '),0,0,'R');
              $pdf->Cell(20,4,"+ ".'$'.number_format($totalAnticipoSoloCable,2),"T",1,'L');
              //TOTAL GENERAL
              $pdf->Cell(180,4,utf8_decode('TOTAL GENERAL: '),"",0,'R');
              $pdf->Cell(20,4,"= ".'$'.number_format(($totalAnticipoSoloCable+$totalAnticipoSoloInter),2),"T",1,'L');
              $pdf->Cell(180,4,utf8_decode(''),"",0,'R');
              $pdf->Cell(20,4,utf8_decode(''),"T",1,'L');
              $pdf->Ln(15);
          }
/*

///////////////////////////////////////////////////////
codigo no revisado
///////////////////////////////////////////////////////

*/

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
            $pdf->Cell(190, 4, utf8_decode('ANTICIPOS LIQUIDADOS'), 0, 1, 'L');
            if ($_SESSION['db'] == 'satpro_sm'){
                $pdf->Cell(190, 4, utf8_decode('SUCURSAL SAN MIGUEL'), 0, 1, 'L');

            }elseif ($_SESSION['db'] == 'satpro'){
                $pdf->Cell(190, 4, utf8_decode('SUCURSAL USULUTÁN'), 0, 1, 'L');
            }
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(190, 4, utf8_decode('FECHA DE GENERACIÓN DESDE '.$desde.' HASTA '.$hasta), 0, 1, 'L');

            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(200,5,utf8_decode('RESUMEN GENERAL DE ANTICIPOS LIQUIDADOS DE FACTURACION CON FECHA DESDE '.$desde.' HASTA '.$hasta),'B',1,'C');
            $pdf->Ln(6);

            if($tipoServicio === "A") {
                $query10 = "SELECT mesCargo, codigoCliente, tipoServicio, fechaFactura FROM tbl_cargos WHERE fechaFactura BETWEEN '".$desde."' AND '".$hasta."' AND anulada = '0' ORDER BY numeroFactura";
                $resultado10 = $mysqli->query($query10);
                while($row1 = $resultado10->fetch_assoc())
                            {
                              $query = "SELECT * FROM tbl_abonos WHERE anticipado= '".$anticipado."' AND mesCargo= '".$row1['mesCargo']."' AND codigoCliente= '".$row1['codigoCliente']."' AND tipoServicio= '".$row1['tipoServicio']."' AND fechaAbonado < '".$row1['fechaFactura']."' AND anulada='0'";
                              $resultado = $mysqli->query($query);

                while($row = $resultado->fetch_assoc())
                {
                        if ($row["tipoServicio"] == "C") {
                              $query2 = "SELECT dia_cobro FROM clientes WHERE cod_cliente= ".$row['codigoCliente'];
                              // Preparación de sentencia
                              $statement2 = $mysqli->query($query2);
                              //$statement->execute();
                              while ($result2 = $statement2->fetch_assoc()) {
                                  $diaCobro = $result2['dia_cobro'];
                              }
                        }elseif ($row["tipoServicio"]  == "I") {
                              $query2 = "SELECT dia_corbo_in FROM clientes WHERE cod_cliente= ".$row['codigoCliente'];
                              // Preparación de sentencia
                              $statement2 = $mysqli->query($query2);
                              //$statement->execute();
                              while ($result2 = $statement2->fetch_assoc()) {
                                  $diaCobro = $result2['dia_corbo_in'];
                              }
                        }
                        if ($row['anticipado'] == "1" || $row['anticipado'] == "T") {
                            if ($row['tipoServicio'] == "C") {

                                $totalAnticipoSoloCable = doubleval($totalAnticipoSoloCable) + doubleval($row['cuotaCable']);
 
                            }elseif ($row['tipoServicio'] == "I") {

                                $totalAnticipoSoloInter = doubleval($totalAnticipoSoloInter) + doubleval($row['cuotaInternet']);
 
                            }

                        }else {
                            if ($row['tipoServicio'] == "C") {

                                $totalSoloCable = doubleval($totalSoloCable) + doubleval($row['cuotaCable']);
 
                            }elseif ($row['tipoServicio'] == "I") {

                                $totalSoloInter = doubleval($totalSoloInter) + doubleval($row['cuotaInternet']);

                            }

                        }

                        
                }
//////////////////////////
            ////////////////
//////////////////////////
                          }

            }elseif ($tipoServicio == "C") {
                 $query10 = "SELECT mesCargo, codigoCliente, tipoServicio, fechaFactura FROM tbl_cargos WHERE fechaFactura BETWEEN '".$desde."' AND '".$hasta."' AND anulada = '0' AND tipoServicio= '".$tipoServicio."' ORDER BY numeroFactura";
                $resultado10 = $mysqli->query($query10);
                while($row1 = $resultado10->fetch_assoc())
                            {
                              $query = "SELECT * FROM tbl_abonos WHERE anticipado= '".$anticipado."' AND mesCargo= '".$row1['mesCargo']."' AND codigoCliente= '".$row1['codigoCliente']."' AND tipoServicio= '".$row1['tipoServicio']."' AND fechaAbonado < '".$row1['fechaFactura']."' AND anulada='0'";
                              $resultado = $mysqli->query($query);

                while($row = $resultado->fetch_assoc())
                {
                        if ($row["tipoServicio"] == "C") {
                              $query2 = "SELECT dia_cobro FROM clientes WHERE cod_cliente= ".$row['codigoCliente'];
                              // Preparación de sentencia
                              $statement2 = $mysqli->query($query2);
                              //$statement->execute();
                              while ($result2 = $statement2->fetch_assoc()) {
                                  $diaCobro = $result2['dia_cobro'];
                              }
                        }elseif ($row["tipoServicio"]  == "I") {
                              $query2 = "SELECT dia_corbo_in FROM clientes WHERE cod_cliente= ".$row['codigoCliente'];
                              // Preparación de sentencia
                              $statement2 = $mysqli->query($query2);
                              //$statement->execute();
                              while ($result2 = $statement2->fetch_assoc()) {
                                  $diaCobro = $result2['dia_corbo_in'];
                              }
                        }
                        if ($row['anticipado'] == "1" || $row['anticipado'] == "T") {
                            if ($row['tipoServicio'] == "C") {

                                $totalAnticipoSoloCable = doubleval($totalAnticipoSoloCable) + doubleval($row['cuotaCable']);

                            }elseif ($row['tipoServicio'] == "I") {

                                $totalAnticipoSoloInter = doubleval($totalAnticipoSoloInter) + doubleval($row['cuotaInternet']);

                            }

                        }else {
                            if ($row['tipoServicio'] == "C") {

                                $totalSoloCable = doubleval($totalSoloCable) + doubleval($row['cuotaCable']);

                            }elseif ($row['tipoServicio'] == "I") {

                                $totalSoloInter = doubleval($totalSoloInter) + doubleval($row['cuotaInternet']);

                            }

                        }

                }
//////////////////////////
            ////////////////
//////////////////////////
                          }
            }elseif ($tipoServicio == "I") {
                $query10 = "SELECT mesCargo, codigoCliente, tipoServicio, fechaFactura FROM tbl_cargos WHERE fechaFactura BETWEEN '".$desde."' AND '".$hasta."' AND anulada = '0' AND tipoServicio= '".$tipoServicio."' ORDER BY numeroFactura";
                $resultado10 = $mysqli->query($query10);
                while($row1 = $resultado10->fetch_assoc())
                            {
                              $query = "SELECT * FROM tbl_abonos WHERE anticipado= '".$anticipado."' AND mesCargo= '".$row1['mesCargo']."' AND codigoCliente= '".$row1['codigoCliente']."' AND tipoServicio= '".$row1['tipoServicio']."' AND fechaAbonado < '".$row1['fechaFactura']."' AND anulada='0'";
                              $resultado = $mysqli->query($query);

                while($row = $resultado->fetch_assoc())
                {
                        if ($row["tipoServicio"] == "C") {
                              $query2 = "SELECT dia_cobro FROM clientes WHERE cod_cliente= ".$row['codigoCliente'];
                              // Preparación de sentencia
                              $statement2 = $mysqli->query($query2);
                              //$statement->execute();
                              while ($result2 = $statement2->fetch_assoc()) {
                                  $diaCobro = $result2['dia_cobro'];
                              }
                        }elseif ($row["tipoServicio"]  == "I") {
                              $query2 = "SELECT dia_corbo_in FROM clientes WHERE cod_cliente= ".$row['codigoCliente'];
                              // Preparación de sentencia
                              $statement2 = $mysqli->query($query2);
                              //$statement->execute();
                              while ($result2 = $statement2->fetch_assoc()) {
                                  $diaCobro = $result2['dia_corbo_in'];
                              }
                        }
                        if ($row['anticipado'] == "1" || $row['anticipado'] == "T") {
                            if ($row['tipoServicio'] == "C") {

                                $totalAnticipoSoloCable = doubleval($totalAnticipoSoloCable) + doubleval($row['cuotaCable']);

                            }elseif ($row['tipoServicio'] == "I") {

                                $totalAnticipoSoloInter = doubleval($totalAnticipoSoloInter) + doubleval($row['cuotaInternet']);

                            }

                        }else {
                            if ($row['tipoServicio'] == "C") {

                                $totalSoloCable = doubleval($totalSoloCable) + doubleval($row['cuotaCable']);

                            }elseif ($row['tipoServicio'] == "I") {

                                $totalSoloInter = doubleval($totalSoloInter) + doubleval($row['cuotaInternet']);

                            }

                        }

                      
                }
//////////////////////////
            ////////////////
//////////////////////////
                          }
            }
                        $pdf->Ln(8);
                        $pdf->SetFont('Arial','B',8);
                        $pdf->Cell(40,4,utf8_decode('SERVICIO'),0,0,'L');
                        $pdf->Cell(50,4,utf8_decode('TOTAL ANTICIPO'),0,1,'L');
                        $pdf->SetFont('Arial','',8);
                        $pdf->Cell(40,4,utf8_decode('CABLE'),"T",0,'L');
                        $pdf->Cell(50,4,'$ '.number_format($totalAnticipoSoloCable,2),"T",1,'L');
                        $pdf->Ln(1);
                        $pdf->Cell(40,4,utf8_decode('INTERNET'),"T",0,'L');
                        $pdf->Cell(50,4,'$ '.number_format($totalAnticipoSoloInter,2),"T",1,'L');
                        $pdf->Ln(1);
                        $pdf->SetFont('Arial','I',8);
                        $pdf->SetFillColor(207,216,220);
                        $pdf->Cell(40,5,utf8_decode('TOTAL LIQUIDADO '.":"),"BTL",0,'R',1);
                        $pdf->Cell(20,5,'$ '.number_format(($totalAnticipoSoloCable+$totalAnticipoSoloInter),2),"BTR",1,'L',1);
                        $pdf->Ln(40);
                        $pdf->Cell(200,5,utf8_decode(''),'B',1,'C');

}
    /* close connection */
    mysqli_close($mysqli);
    $pdf->Output();

                      
                }

  abonos();

?>