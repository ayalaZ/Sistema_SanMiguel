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
  $codigoCobrador = $_POST['lCobrador'];
  $colonia = $_POST['lColonia'];
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
      global $totalAnticipoSoloCable,$totalAnticipoCable,$totalAnticipoImpuestoC,$totalAnticipoSoloInter,$totalAnticipoInter,$totalAnticipoImpuestoI /*$mesCargof*/;
      global $totalSoloCable,$totalCable,$totalImpuestoC,$totalSoloInter,$totalInter,$totalImpuestoI,$anulada,$detallado,$anticipado,$recibo_anulado;
/*
$query = "SELECT codigoCliente, mesCargo FROM tbl_cargos WHERE fechaFactura ='".$hasta."'";
                      $resultado = $mysqli->query($query);
                       while($row = $resultado->fetch_assoc())
                       {
                        $codigoCliente = $row['codigoCliente'];
                        $mesCargof = $row['mesCargo'];
                        }
*/
 ///// Comprobacion si el resultado de mesCargof trae un valor, si no lo trae cambiara a 0000-00-00 para no salir con error el resultado
                      
if (!isset($mesCargof)) {
  $mesCargof = '0000-00-00';
}

        if (isset($detallado)){
          if ($detallado == 1){

              if ($tipoServicio == "C") {
                ///// inicio de obtenencion de datos de la tabla cargos para liquidar los abonos
                /*
                $query = "SELECT codigoCliente, mesCargo FROM tbl_cargos WHERE fechaFactura ='".$hasta."' AND tipoServicio= '".$tipoServicio."'";
                      $resultado = $mysqli->query($query);
                       while($row = $resultado->fetch_assoc())
                       {
                        $codigoCliente = $row['codigoCliente'];
                        $mesCargof = $row['mesCargo'];
                        }
                */
                        ///// finalizacion de obtenencion de datos de la tabla cargos para liquidar los abonos
                  //SQL para todas las zonas de cobro
                  if ($_POST["lCobrador"] === "todos" && $_POST["lColonia"] === "todas") {
                      $query = "SELECT * FROM tbl_abonos WHERE tipoServicio= '".$tipoServicio."' AND anticipado= '".$anticipado."' AND codigoCliente!= '".$recibo_anulado."' AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                      $resultado = $mysqli->query($query);

                  }elseif ($_POST["lCobrador"] === "todos" && $_POST["lColonia"] != "todas") {
                      $query = "SELECT * FROM tbl_abonos WHERE idColonia= '".$colonia."' AND tipoServicio= '".$tipoServicio."' AND anticipado= '".$anticipado."' AND codigoCliente!= '".$recibo_anulado."'  AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                      $resultado = $mysqli->query($query);
                  }elseif ($_POST["lCobrador"] != "todos" && $_POST["lColonia"] === "todas") {
                      $query = "SELECT * FROM tbl_abonos WHERE cobradoPor= '".$codigoCobrador."' AND tipoServicio= '".$tipoServicio."' AND anticipado= '".$anticipado."' AND codigoCliente!= '".$recibo_anulado."'  AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                      $resultado = $mysqli->query($query);
                  }else {
                      $query = "SELECT * FROM tbl_abonos WHERE cobradoPor= '".$codigoCobrador."' AND idColonia= '".$colonia."' AND tipoServicio= '".$tipoServicio."' AND anticipado= '".$anticipado."' AND codigoCliente!= '".$recibo_anulado."' AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                      $resultado = $mysqli->query($query);
                  }
              }elseif ($tipoServicio == "I") {
                                ///// inicio de obtenencion de datos de la tabla cargos para liquidar los abonos
                /*
                $query = "SELECT codigoCliente, mesCargo FROM tbl_cargos WHERE fechaFactura ='".$hasta."' AND tipoServicio= '".$tipoServicio."'";
                      $resultado = $mysqli->query($query);
                       while($row = $resultado->fetch_assoc())
                       {
                        $codigoCliente = $row['codigoCliente'];
                        $mesCargof = $row['mesCargo'];
                        }
                */
                        ///// finalizacion de obtenencion de datos de la tabla cargos para liquidar los abonos
                  //SQL para todas las zonas de cobro
                  if ($_POST["lCobrador"] === "todos" && $_POST["lColonia"] === "todas") {
                      $query = "SELECT * FROM tbl_abonos WHERE tipoServicio= '".$tipoServicio."' AND anticipado= '".$anticipado."' AND codigoCliente!= '".$recibo_anulado."' AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                      $resultado = $mysqli->query($query);
                  }elseif ($_POST["lCobrador"] === "todos" && $_POST["lColonia"] != "todas") {
                      $query = "SELECT * FROM tbl_abonos WHERE idColonia= '".$colonia."' AND tipoServicio= '".$tipoServicio."' AND anticipado= '".$anticipado."' AND codigoCliente!= '".$recibo_anulado."' AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                      $resultado = $mysqli->query($query);
                  }elseif ($_POST["lCobrador"] != "todos" && $_POST["lColonia"] === "todas") {
                      $query = "SELECT * FROM tbl_abonos WHERE cobradoPor= '".$codigoCobrador."' AND tipoServicio= '".$tipoServicio."' AND anticipado= '".$anticipado."' AND codigoCliente!= '".$recibo_anulado."' AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                      $resultado = $mysqli->query($query);
                  }else {
                      $query = "SELECT * FROM tbl_abonos WHERE cobradoPor= '".$codigoCobrador."' AND idColonia= '".$colonia."' AND tipoServicio= '".$tipoServicio."' AND anticipado= '".$anticipado."' AND codigoCliente!= '".$recibo_anulado."' AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                      $resultado = $mysqli->query($query);
                  }
              }
/*
              $query3 = "SELECT SUM(montoCable + montoInternet + impuesto) AS totalManuales FROM tbl_ventas_manuales WHERE anulada = 0 AND fechaComprobante BETWEEN '".$desde."' AND '".$hasta."'";
              $statement3 = $mysqli->query($query3);

              while ($tManuales = $statement3->fetch_assoc()) {
                  $result3 = $tManuales["totalManuales"];
              }
*/
              $pdf = new FPDF();

              $pdf->AddPage('L','Letter');
              $pdf->SetAutoPageBreak(false, 10);
              $pdf->SetFont('Arial','',6);
              date_default_timezone_set('America/El_Salvador');
              $pdf->Cell(260,6,utf8_decode("Página ".str_pad($pdf->pageNo(),4,"0",STR_PAD_LEFT)),0,1,'R');
              $pdf->Cell(260,4,utf8_decode("IMPRESO POR: ".strtoupper($_SESSION['nombres'])." ".strtoupper($_SESSION['apellidos']). " ".date('d/m/Y h:i:s')),"",1,'R');
              $pdf->Image('../../../images/logo.png',10,10, 20, 18);

              $pdf->Ln(15);

              /*$pdf->SetFont('Arial','B',13);
              $pdf->Cell(190,6,utf8_decode('F-3'),0,1,'R');
              $pdf->Ln();
              $pdf->Cell(190,6,utf8_decode('PAGARÉ SIN PROTESTO'),0,1,'C');
              $pdf->Ln(10);*/

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
              $pdf->Cell(190, 4, utf8_decode('FECHA DE GENERACIÓN '.$hasta), 0, 1, 'L');
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
              $pdf->Cell(20,5,utf8_decode('Valor Liquidado'),1,0,'L');/*
              $pdf->Cell(15,5,utf8_decode('Impuesto'),1,0,'L');
              $pdf->Cell(15,5,utf8_decode('Total recibo'),1,1,'L');*/
              $pdf->Ln(8);
/*
              $pdf->Cell(35,1,utf8_decode('TOTAL VENTAS MANUALES:'),0,0,'L');
              $pdf->Cell(18,1,utf8_decode(number_format($result3,2)),0,1,'L');
              $pdf->Ln(3);
              */
              if ($codigoCobrador === "todos") {

                  $query1 = "SELECT codigoCobrador, nombreCobrador FROM tbl_cobradores";
                  // Preparación de sentencia
                  $statement1 = $mysqli->query($query1);
                  $controlCobrador="";
                  $counter2=1;
                  $counter3=1;
                  while ($cobradores = $statement1->fetch_assoc()) {//RECORRIDO DE TODOS LOS COBRADORES
                      $cobradorR = $cobradores["codigoCobrador"];
                      //var_dump($cobradores["codigoCobrador"]);
                      $totalCobradorCable = 0;
                      $totalImpuestoCobradorC = 0;
                      $totalCobradorInter = 0;
                      $totalImpuestoCobradorI = 0;
                      $totalAnticipoCobradorCable = 0;
                      $totalAnticipoCobradorInter = 0;
                      $totalAnticipoImpuestoCobradorC = 0;
                      $totalAnticipoImpuestoCobradorI = 0;
                      //var_dump($detallado."ENTRAMOS");
                      if($tipoServicio === "A") {
                                        ///// inicio de obtenencion de datos de la tabla cargos para liquidar los abonos
                /*
                $query = "SELECT codigoCliente, mesCargo FROM tbl_cargos WHERE fechaFactura ='".$hasta."'";
                      $resultado = $mysqli->query($query);
                       while($row = $resultado->fetch_assoc())
                       {
                        $codigoCliente = $row['codigoCliente'];
                        $mesCargof = $row['mesCargo'];
                        }
                        //
                *//// finalizacion de obtenencion de datos de la tabla cargos para liquidar los abonos
                          //var_dump($detallado."ENTRAMOS");
                          //SQL para todas las zonas de cobro
                          if ($_POST["lCobrador"] === "todos" && $_POST["lColonia"] === "todas") {
                              $query = "SELECT * FROM tbl_abonos WHERE codigoCliente!= '".$recibo_anulado."' AND cobradoPor= '".$cobradorR."' AND anticipado= '".$anticipado."' AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                              $resultado = $mysqli->query($query);
                              
                          }elseif ($_POST["lCobrador"] === "todos" && $_POST["lColonia"] != "todas") {
                              $query = "SELECT * FROM tbl_abonos WHERE idColonia= '".$colonia."' AND codigoCobrador= '".$cobradorR."' AND anticipado= '".$anticipado."' AND codigoCliente!= '".$recibo_anulado."' AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                              $resultado = $mysqli->query($query);
                          }
                      }elseif ($tipoServicio == "C") {
                                        ///// inicio de obtenencion de datos de la tabla cargos para liquidar los abonos
                /*
                $query = "SELECT codigoCliente, mesCargo FROM tbl_cargos WHERE fechaFactura ='".$hasta."' AND tipoServicio= '".$tipoServicio."'";
                      $resultado = $mysqli->query($query);
                       while($row = $resultado->fetch_assoc())
                       {
                        $codigoCliente = $row['codigoCliente'];
                        $mesCargof = $row['mesCargo'];
                        }
                */
                        ///// finalizacion de obtenencion de datos de la tabla cargos para liquidar los abonos
                          if ($_POST["lCobrador"] === "todos" && $_POST["lColonia"] === "todas") {
                              $query = "SELECT * FROM tbl_abonos WHERE codigoCliente!= '".$recibo_anulado."' AND tipoServicio= '".$tipoServicio."' AND anticipado= '".$anticipado."' AND cobradoPor= '".$cobradorR."'  AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                              $resultado = $mysqli->query($query);
                          }elseif ($_POST["lCobrador"] == "todos" && $_POST["lColonia"] != "todas") {
                              $query = "SELECT * FROM tbl_abonos WHERE idColonia= '".$colonia."' AND cobradoPor= '".$cobradorR."' AND tipoServicio= '".$tipoServicio."' AND anticipado= '".$anticipado."' AND codigoCliente!= '".$recibo_anulado."'  AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                              $resultado = $mysqli->query($query);
                          }
                      }elseif ($tipoServicio == "I") {
                                        ///// inicio de obtenencion de datos de la tabla cargos para liquidar los abonos
                /*
                $query = "SELECT codigoCliente, mesCargo FROM tbl_cargos WHERE fechaFactura ='".$hasta."' AND tipoServicio= '".$tipoServicio."'";
                      $resultado = $mysqli->query($query);
                       while($row = $resultado->fetch_assoc())
                       {
                        $codigoCliente = $row['codigoCliente'];
                        $mesCargof = $row['mesCargo'];
                        }
                */
                        ///// finalizacion de obtenencion de datos de la tabla cargos para liquidar los abonos
                          if ($_POST["lCobrador"] === "todos" && $_POST["lColonia"] === "todas") {
                              $query = "SELECT * FROM tbl_abonos WHERE codigoCliente!= '".$recibo_anulado."' AND tipoServicio= '".$tipoServicio."' AND anticipado= '".$anticipado."' AND cobradoPor= '".$cobradorR."'  AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                              $resultado = $mysqli->query($query);
                          }elseif ($_POST["lCobrador"] === "todos" && $_POST["lColonia"] != "todas") {
                              $query = "SELECT * FROM tbl_abonos WHERE idColonia= '".$colonia."' AND cobradoPor= '".$cobradorR."' AND tipoServicio= '".$tipoServicio."' AND anticipado= '".$anticipado."' AND codigoCliente!= '".$recibo_anulado."'  AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                              $resultado = $mysqli->query($query);
                          }
                      }

                      while($row = $resultado->fetch_assoc())
                      {
                        
                          if ($row["cobradoPor"]==$cobradores["codigoCobrador"] && $controlCobrador != $cobradores["codigoCobrador"]) {
                              $pdf->SetFont('Arial','B',7);
                              $pdf->Cell(190,3,utf8_decode($cobradores['nombreCobrador']),0,1,'L');
                              $controlCobrador=$cobradores['codigoCobrador'];
                          }
                          if ($row["tipoServicio"] == "C") {
                              $query2 = "SELECT dia_cobro FROM clientes WHERE cod_cliente= ".$row['codigoCliente'];
                              // Preparación de sentencia
                              $statement2 = $mysqli->query($query2);
                              //$statement->execute();
                              while ($result2 = $statement2->fetch_assoc()) {
                                  $diaCobro = $result2['dia_cobro'];
                              }
                          }
                          elseif ($row["tipoServicio"]  == "I") {
                              $query2 = "SELECT dia_corbo_in FROM clientes WHERE cod_cliente= ".$row['codigoCliente'];
                              // Preparación de sentencia
                              $statement2 = $mysqli->query($query2);
                              //$statement->execute();
                              while ($result2 = $statement2->fetch_assoc()) {
                                  $diaCobro = $result2['dia_corbo_in'];
                              }
                          }

                          $pdf->Ln(3);
                         $pdf->SetFont('Arial','',6.5);
                          $pdf->Cell(10,0,utf8_decode($counter3),0,0,'L');
                          /////////////////////////////////////////////////////////////////
                        
                            # code... CONDICIONAL PARA ESTABLECER SI ES ANULADO MOSTRAR UNA SERIE DE DATOS DIFERENTES
                          
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
                                 // $pdf->Cell(20,0,utf8_decode('0.00'),0,0,'L');
                                  $pdf->Cell(20,0,'$ '.utf8_decode(number_format($row['cuotaCable'],2)),0,0,'L');
                               //   $pdf->Cell(15,0,utf8_decode(number_format($row['totalImpuesto'],2)),0,0,'L');
                         //         $pdf->Cell(20,0,utf8_decode('PRUEBA'),0,0,'L'); //// prueba para ingresar comision banco
                               //   $pdf->Cell(20,0,utf8_decode(number_format(doubleval($row['cuotaCable'])+doubleval($row['totalImpuesto']),2)),0,1,'L');
                                  $totalAnticipoSoloCable = doubleval($totalAnticipoSoloCable) + doubleval($row['cuotaCable']);
                                  $totalAnticipoCobradorCable = $totalAnticipoCobradorCable + doubleval($row['cuotaCable']);
                                  $totalAnticipoCable = doubleval($totalAnticipoCable) + doubleval($row['cuotaCable'])+doubleval($row['totalImpuesto']);
                                  $totalAnticipoImpuestoC = doubleval($totalAnticipoImpuestoC) + doubleval($row['totalImpuesto']);
                                  $totalAnticipoImpuestoCobradorC = $totalAnticipoImpuestoCobradorC + doubleval($row['totalImpuesto']);
                              }elseif ($row['tipoServicio'] == "I") {
                                 // $pdf->Cell(20,0,utf8_decode('0.00'),0,0,'L');
                                  $pdf->Cell(20,0,'$ '.utf8_decode(number_format($row['cuotaInternet'],2)),0,0,'L');
                                //  $pdf->Cell(15,0,utf8_decode(number_format($row['totalImpuesto'],2)),0,0,'L');
                                 // $pdf->Cell(20,0,utf8_decode(number_format(doubleval($row['cuotaInternet'])+doubleval($row['totalImpuesto']),2)),0,1,'L');
                                  $totalAnticipoSoloInter = doubleval($totalAnticipoSoloInter) + doubleval($row['cuotaInternet']);
                                  $totalAnticipoCobradorInter = $totalAnticipoCobradorInter + doubleval($row['cuotaInternet']);
                                  $totalAnticipoInter = doubleval($totalAnticipoInter) + doubleval($row['cuotaInternet'])+doubleval($row['totalImpuesto']);
                                  $totalAnticipoImpuestoI = doubleval($totalAnticipoImpuestoI) + doubleval($row['totalImpuesto']);
                                  $totalAnticipoImpuestoCobradorI = $totalAnticipoImpuestoCobradorI + doubleval($row['totalImpuesto']);
                              }

                          }else {
                              if ($row['tipoServicio'] == "C") {
                                  $pdf->Cell(20,0,'$ '.utf8_decode(number_format($row['cuotaCable'],2)),0,0,'L');
                                  $pdf->Cell(20,0,utf8_decode("PASA AQUI"),0,0,'L');
                                  $pdf->Cell(15,0,utf8_decode(number_format($row['totalImpuesto'],2)),0,0,'L');
                              //    $pdf->Cell(20,0,utf8_decode('PRUEBA'),0,0,'L'); //// prueba para ingresar comision banco
                                  $pdf->Cell(20,0,utf8_decode(number_format(doubleval($row['cuotaCable'])+doubleval($row['totalImpuesto']),2)),0,1,'L');
                                  $totalSoloCable = doubleval($totalSoloCable) + doubleval($row['cuotaCable']);
                                  $totalCobradorCable = $totalCobradorCable + doubleval($row['cuotaCable']);
                                  $totalCable = doubleval($totalCable) + doubleval($row['cuotaCable'])+doubleval($row['totalImpuesto']);
                                  $totalImpuestoC = doubleval($totalImpuestoC) + doubleval($row['totalImpuesto']);
                                  $totalImpuestoCobradorC = $totalImpuestoCobradorC + doubleval($row['totalImpuesto']);
                              }elseif ($row['tipoServicio'] == "I") {
                                  $pdf->Cell(20,0,'$ '.utf8_decode(number_format($row['cuotaInternet'],2)),0,0,'L');
                                  $pdf->Cell(20,0,utf8_decode("PASA AQUI"),0,0,'L');
                                  $pdf->Cell(15,0,utf8_decode(number_format($row['totalImpuesto'],2)),0,0,'L');
                                  $pdf->Cell(20,0,utf8_decode(number_format(doubleval($row['cuotaInternet'])+doubleval($row['totalImpuesto']),2)),0,1,'L');
                                  $totalSoloInter = doubleval($totalSoloInter) + doubleval($row['cuotaInternet']);
                                  $totalInter = doubleval($totalInter) + doubleval($row['cuotaInternet'])+doubleval($row['totalImpuesto']);
                                  $totalCobradorInter = $totalCobradorInter + doubleval($row['cuotaInternet']);
                                  $totalImpuestoI = doubleval($totalImpuestoI) + doubleval($row['totalImpuesto']);
                                  $totalImpuestoCobradorI = $totalImpuestoCobradorI + doubleval($row['totalImpuesto']);
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
                              $pdf->Cell(190, 4, utf8_decode('FECHA DE GENERACIÓN '.$hasta), 0, 1, 'L');
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
                              $pdf->Cell(20,5,utf8_decode('Valor Liquidado'),1,0,'L');/*
                              $pdf->Cell(15,5,utf8_decode('Impuesto'),1,0,'L');
                              $pdf->Cell(15,5,utf8_decode('Total recibo'),1,1,'L');*/
                              $pdf->Ln(8);
/*
                              $pdf->Cell(35,1,utf8_decode('TOTAL VENTAS MANUALES:'),0,0,'L');
                              $pdf->Cell(18,1,utf8_decode(number_format($result3,2)),0,1,'L');
                              */
                              $counter2=1;
                              //$pdf->Ln(3);
                          }
                          $counter2++;
                          $counter3++;

                      }
                      $pdf->Ln(1);
                      if ($controlCobrador == $cobradores["codigoCobrador"] && $controlCobrador != $row["cobradoPor"]) {

                          $totalCobrador = $totalCobradorCable+$totalCobradorInter;
                          $totalAnticipoCobrador = $totalAnticipoCobradorCable+$totalAnticipoCobradorInter;
                          $totalImpuestosCobrador = $totalAnticipoImpuestoCobradorI+$totalAnticipoImpuestoCobradorC+$totalImpuestoCobradorI+$totalImpuestoCobradorC;
                          $totalTotalCobrador = $totalCobrador+$totalAnticipoCobrador+$totalImpuestosCobrador;
                          $pdf->SetFont('Arial','B',6.5);
                          $pdf->Cell(180,5,utf8_decode('TOTAL: '.$cobradores["nombreCobrador"]),0,0,'R');
                          //$pdf->Cell(20,5,number_format($totalCobrador,2),"T",0,'L');
                          $pdf->Cell(20,5,'$ '.number_format($totalAnticipoCobrador,2),"T",1,'L');
                         // $pdf->Cell(15,5,number_format(($totalImpuestosCobrador),2),"T",0,'L');
                          //$pdf->Cell(20,5,number_format(($totalTotalCobrador),2),"T",1,'L');
                          $pdf->Ln(-4);
                      }
                  }

              }
              if ($codigoCobrador != "todos") {

                  $query1 = "SELECT codigoCobrador, nombreCobrador FROM tbl_cobradores where codigoCobrador=".$codigoCobrador;
                  // Preparación de sentencia
                  $statement1 = $mysqli->query($query1);
                  $controlCobrador="";
                  $counter2=1;
                  $counter3=1;
                  while ($cobradores = $statement1->fetch_assoc()) {//RECORRIDO DE TODOS LOS COBRADORES
                      $cobradorR = $cobradores["codigoCobrador"];
                      $totalCobradorCable = 0;
                      $totalImpuestoCobradorC = 0;
                      $totalCobradorInter = 0;
                      $totalImpuestoCobradorI = 0;
                      $totalAnticipoCobradorCable = 0;
                      $totalAnticipoCobradorInter = 0;
                      $totalAnticipoImpuestoCobradorC = 0;
                      $totalAnticipoImpuestoCobradorI = 0;
                      if($tipoServicio == "A") {
                                        ///// inicio de obtenencion de datos de la tabla cargos para liquidar los abonos
                /*
                $query = "SELECT codigoCliente, mesCargo FROM tbl_cargos WHERE fechaFactura ='".$hasta."'";
                      $resultado = $mysqli->query($query);
                       while($row = $resultado->fetch_assoc())
                       {
                        $codigoCliente = $row['codigoCliente'];
                        $mesCargof = $row['mesCargo'];
                        }
                        //
                *//// finalizacion de obtenencion de datos de la tabla cargos para liquidar los abonos
                          //SQL para todas las zonas de cobro
                          if ($_POST["lCobrador"] != "todos" && $_POST["lColonia"] === "todas") {
                              $query = "SELECT * FROM tbl_abonos WHERE codigoCliente!= '".$recibo_anulado."' AND cobradoPor= '".$cobradorR."' AND anticipado= '".$anticipado."'  AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                              $resultado = $mysqli->query($query);
                          }elseif ($_POST["lCobrador"] != "todos" && $_POST["lColonia"] != "todas") {
                              $query = "SELECT * FROM tbl_abonos WHERE idColonia= '".$colonia."' AND cobradoPor= '".$cobradorR."' AND anticipado= '".$anticipado."' AND codigoCliente!= '".$recibo_anulado."'  AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                              $resultado = $mysqli->query($query);
                          }
                      }elseif ($tipoServicio == "C") {
                                        ///// inicio de obtenencion de datos de la tabla cargos para liquidar los abonos
                /*
                $query = "SELECT codigoCliente, mesCargo FROM tbl_cargos WHERE fechaFactura ='".$hasta."' AND tipoServicio= '".$tipoServicio."'";
                      $resultado = $mysqli->query($query);
                       while($row = $resultado->fetch_assoc())
                       {
                        $codigoCliente = $row['codigoCliente'];
                        $mesCargof = $row['mesCargo'];
                        }
                */
                        ///// finalizacion de obtenencion de datos de la tabla cargos para liquidar los abonos
                          if ($_POST["lCobrador"] != "todos" && $_POST["lColonia"] === "todas") {
                              $query = "SELECT * FROM tbl_abonos WHERE codigoCliente!= '".$recibo_anulado."' AND tipoServicio= '".$tipoServicio."' AND anticipado= '".$anticipado."' AND cobradoPor= '".$cobradorR."'  AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                              $resultado = $mysqli->query($query);
                          }elseif ($_POST["lCobrador"] != "todos" && $_POST["lColonia"] != "todas") {
                              $query = "SELECT * FROM tbl_abonos WHERE idColonia= '".$colonia."' AND cobradoPor= '".$cobradorR."' AND tipoServicio= '".$tipoServicio."' AND anticipado= '".$anticipado."' AND codigoCliente!= '".$recibo_anulado."'  AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                              $resultado = $mysqli->query($query);
                          }
                      }elseif ($tipoServicio == "I") {
                                        ///// inicio de obtenencion de datos de la tabla cargos para liquidar los abonos
                /*
                $query = "SELECT codigoCliente, mesCargo FROM tbl_cargos WHERE fechaFactura ='".$hasta."' AND tipoServicio= '".$tipoServicio."'";
                      $resultado = $mysqli->query($query);
                       while($row = $resultado->fetch_assoc())
                       {
                        $codigoCliente = $row['codigoCliente'];
                        $mesCargof = $row['mesCargo'];
                        }
                */
                        ///// finalizacion de obtenencion de datos de la tabla cargos para liquidar los abonos
                          if ($_POST["lCobrador"] != "todos" && $_POST["lColonia"] === "todas") {
                              $query = "SELECT * FROM tbl_abonos WHERE codigoCliente!= '".$recibo_anulado."' AND tipoServicio= '".$tipoServicio."' AND anticipado= '".$anticipado."' AND cobradoPor= '".$cobradorR."'  AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                              $resultado = $mysqli->query($query);
                          }elseif ($_POST["lCobrador"] != "todos" && $_POST["lColonia"] != "todas") {
                              $query = "SELECT * FROM tbl_abonos WHERE idColonia= '".$colonia."' AND cobradoPor= '".$cobradorR."' AND tipoServicio= '".$tipoServicio."' AND anticipado= '".$anticipado."' AND codigoCliente!= '".$recibo_anulado."'  AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                              $resultado = $mysqli->query($query);
                          }
                      }

                      while($row = $resultado->fetch_assoc())
                      {
                          if ($row["cobradoPor"]==$cobradores["codigoCobrador"] && $controlCobrador != $cobradores["codigoCobrador"]) {
                              $pdf->SetFont('Arial','B',7);
                              $pdf->Cell(190,3,utf8_decode($cobradores['nombreCobrador']),0,1,'L');
                              $controlCobrador=$cobradores['codigoCobrador'];
                          }
                          if ($row["tipoServicio"] == "C") {
                              $query2 = "SELECT dia_cobro FROM clientes WHERE cod_cliente= ".$row['codigoCliente'];
                              // Preparación de sentencia
                              $statement2 = $mysqli->query($query2);
                              //$statement->execute();
                              while ($result2 = $statement2->fetch_assoc()) {
                                  $diaCobro = $result2['dia_cobro'];
                              }
                          }
                          elseif ($row["tipoServicio"]  == "I") {
                              $query2 = "SELECT dia_corbo_in FROM clientes WHERE cod_cliente= ".$row['codigoCliente'];
                              // Preparación de sentencia
                              $statement2 = $mysqli->query($query2);
                              //$statement->execute();
                              while ($result2 = $statement2->fetch_assoc()) {
                                  $diaCobro = $result2['dia_corbo_in'];
                              }
                          }

                          $pdf->Ln(3);
                          $pdf->SetFont('Arial','',6.5);
                          $pdf->Cell(10,0,utf8_decode($counter3),0,0,'L');
                          //$pdf->Cell(10,0,utf8_decode($counter3),0,0,'L');
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
                                 // $pdf->Cell(20,0,utf8_decode('0.00'),0,0,'L');
                                  $pdf->Cell(20,0,'$ '.utf8_decode(number_format($row['cuotaCable'],2)),0,0,'L');
                               //   $pdf->Cell(15,0,utf8_decode(number_format($row['totalImpuesto'],2)),0,0,'L');
                         //         $pdf->Cell(20,0,utf8_decode('PRUEBA'),0,0,'L'); //// prueba para ingresar comision banco
                               //   $pdf->Cell(20,0,utf8_decode(number_format(doubleval($row['cuotaCable'])+doubleval($row['totalImpuesto']),2)),0,1,'L');
                                  $totalAnticipoSoloCable = doubleval($totalAnticipoSoloCable) + doubleval($row['cuotaCable']);
                                  $totalAnticipoCobradorCable = $totalAnticipoCobradorCable + doubleval($row['cuotaCable']);
                                  $totalAnticipoCable = doubleval($totalAnticipoCable) + doubleval($row['cuotaCable'])+doubleval($row['totalImpuesto']);
                                  $totalAnticipoImpuestoC = doubleval($totalAnticipoImpuestoC) + doubleval($row['totalImpuesto']);
                                  $totalAnticipoImpuestoCobradorC = $totalAnticipoImpuestoCobradorC + doubleval($row['totalImpuesto']);
                              }elseif ($row['tipoServicio'] == "I") {
                                 // $pdf->Cell(20,0,utf8_decode('0.00'),0,0,'L');
                                  $pdf->Cell(20,0,'$ '.utf8_decode(number_format($row['cuotaInternet'],2)),0,0,'L');
                                //  $pdf->Cell(15,0,utf8_decode(number_format($row['totalImpuesto'],2)),0,0,'L');
                                 // $pdf->Cell(20,0,utf8_decode(number_format(doubleval($row['cuotaInternet'])+doubleval($row['totalImpuesto']),2)),0,1,'L');
                                  $totalAnticipoSoloInter = doubleval($totalAnticipoSoloInter) + doubleval($row['cuotaInternet']);
                                  $totalAnticipoCobradorInter = $totalAnticipoCobradorInter + doubleval($row['cuotaInternet']);
                                  $totalAnticipoInter = doubleval($totalAnticipoInter) + doubleval($row['cuotaInternet'])+doubleval($row['totalImpuesto']);
                                  $totalAnticipoImpuestoI = doubleval($totalAnticipoImpuestoI) + doubleval($row['totalImpuesto']);
                                  $totalAnticipoImpuestoCobradorI = $totalAnticipoImpuestoCobradorI + doubleval($row['totalImpuesto']);
                              }

                          }else {
                              if ($row['tipoServicio'] == "C") {
                                  $pdf->Cell(20,0,'$ '.utf8_decode(number_format($row['cuotaCable'],2)),0,0,'L');
                                  $pdf->Cell(20,0,utf8_decode("PASA AQUI"),0,0,'L');
                                  $pdf->Cell(15,0,utf8_decode(number_format($row['totalImpuesto'],2)),0,0,'L');
                              //    $pdf->Cell(20,0,utf8_decode('PRUEBA'),0,0,'L'); //// prueba para ingresar comision banco
                                  $pdf->Cell(20,0,utf8_decode(number_format(doubleval($row['cuotaCable'])+doubleval($row['totalImpuesto']),2)),0,1,'L');
                                  $totalSoloCable = doubleval($totalSoloCable) + doubleval($row['cuotaCable']);
                                  $totalCobradorCable = $totalCobradorCable + doubleval($row['cuotaCable']);
                                  $totalCable = doubleval($totalCable) + doubleval($row['cuotaCable'])+doubleval($row['totalImpuesto']);
                                  $totalImpuestoC = doubleval($totalImpuestoC) + doubleval($row['totalImpuesto']);
                                  $totalImpuestoCobradorC = $totalImpuestoCobradorC + doubleval($row['totalImpuesto']);
                              }elseif ($row['tipoServicio'] == "I") {
                                  $pdf->Cell(20,0,'$ '.utf8_decode(number_format($row['cuotaInternet'],2)),0,0,'L');
                                  $pdf->Cell(20,0,utf8_decode("PASA AQUI"),0,0,'L');
                                  $pdf->Cell(15,0,utf8_decode(number_format($row['totalImpuesto'],2)),0,0,'L');
                                  $pdf->Cell(20,0,utf8_decode(number_format(doubleval($row['cuotaInternet'])+doubleval($row['totalImpuesto']),2)),0,1,'L');
                                  $totalSoloInter = doubleval($totalSoloInter) + doubleval($row['cuotaInternet']);
                                  $totalInter = doubleval($totalInter) + doubleval($row['cuotaInternet'])+doubleval($row['totalImpuesto']);
                                  $totalCobradorInter = $totalCobradorInter + doubleval($row['cuotaInternet']);
                                  $totalImpuestoI = doubleval($totalImpuestoI) + doubleval($row['totalImpuesto']);
                                  $totalImpuestoCobradorI = $totalImpuestoCobradorI + doubleval($row['totalImpuesto']);
                              }


                          }
                          if ($counter2 > 35){
                              $pdf->AddPage('L','Letter');
                              $pdf->SetAutoPageBreak(false, 10);
                              $pdf->SetFont('Arial','',6);
                              $pdf->Cell(260,6,utf8_decode("Página ".str_pad($pdf->pageNo(),4,"0",STR_PAD_LEFT)),0,1,'R');
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
                              $pdf->Cell(190, 4, utf8_decode('FECHA DE GENERACIÓN '.$hasta), 0, 1, 'L');
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
/*
                              $pdf->Cell(35,1,utf8_decode('TOTAL VENTAS MANUALES:'),0,0,'L');
                              $pdf->Cell(18,1,utf8_decode(number_format($result3,2)),0,1,'L');
                              */
                              $counter2=1;
                              //$pdf->Ln(3);
                          }
                          $counter2++;
                          $counter3++;

                      }
                      $pdf->Ln(1);
                      if ($controlCobrador == $cobradores["codigoCobrador"] && $controlCobrador != $row["cobradoPor"]) {

                          $totalCobrador = $totalCobradorCable+$totalCobradorInter;
                          $totalAnticipoCobrador = $totalAnticipoCobradorCable+$totalAnticipoCobradorInter;
                          $totalImpuestosCobrador = $totalAnticipoImpuestoCobradorI+$totalAnticipoImpuestoCobradorC+$totalImpuestoCobradorI+$totalImpuestoCobradorC;
                          $totalTotalCobrador = $totalCobrador+$totalAnticipoCobrador+$totalImpuestosCobrador;
                          $pdf->SetFont('Arial','B',6.5);
                          $pdf->Cell(180,5,utf8_decode('TOTAL: '.$cobradores["nombreCobrador"]),0,0,'R');
                          //$pdf->Cell(20,5,number_format($totalCobrador,2),"T",0,'L');
                          $pdf->Cell(20,5,'$ '.number_format($totalAnticipoCobrador,2),"T",1,'L');
                          //$pdf->Cell(15,5,number_format(($totalImpuestosCobrador),2),"T",0,'L');
                          //$pdf->Cell(20,5,number_format(($totalTotalCobrador),2),"T",1,'L');
                          $pdf->Ln(-4);
                      }
                  }

              }
              $pdf->Ln(1);
              $pdf->Cell(185,4,utf8_decode(''),0,0,'R');
              $pdf->Cell(75,4,utf8_decode(''),"",1,'R');

              //$pdf->AddPage('L','Letter');
              $pdf->SetFont('Arial','B',8);

              $pdf->Cell(200,4,utf8_decode('TOTALES GENERALES'),'',1,'R');
              $pdf->SetFont('Arial','',8);
              //TOTAL INTERNET
              $pdf->Cell(180,4,utf8_decode('TOTAL INTERNET: '),0,0,'R');
              //$pdf->Cell(20,4,number_format($totalSoloInter,2),"T",0,'L');
              $pdf->Cell(20,4,"+ ".'$'.number_format($totalAnticipoSoloInter,2),"T",1,'L');
              //$pdf->Cell(15,4,number_format(($totalAnticipoImpuestoI+$totalImpuestoI),2),"T",0,'L');
              //$pdf->Cell(25,4,"+ ".number_format(($totalSoloInter+$totalAnticipoSoloInter+$totalAnticipoImpuestoI+$totalImpuestoI),2),"T",1,'L');

              //TOTAL CABLE
              $pdf->Cell(180,4,utf8_decode('TOTAL CABLE: '),0,0,'R');
              //$pdf->Cell(20,4,number_format($totalSoloCable,2),"T",0,'L');
              $pdf->Cell(20,4,"+ ".'$'.number_format($totalAnticipoSoloCable,2),"T",1,'L');
              //$pdf->Cell(15,4,number_format(($totalAnticipoImpuestoC+$totalImpuestoC),2),"T",0,'L');
              //$pdf->Cell(25,4,"+ ".number_format(($totalSoloCable+$totalAnticipoSoloCable+$totalAnticipoImpuestoC+$totalImpuestoC),2),"T",1,'L');

              //TOTAL IMPUESTO
              $pdf->Cell(180,4,utf8_decode('TOTAL GENERAL: '),"",0,'R');
              //$pdf->Cell(20,4,number_format(($totalSoloCable+$totalSoloInter),2),"T",0,'L');
              $pdf->Cell(20,4,"= ".'$'.number_format(($totalAnticipoSoloCable+$totalAnticipoSoloInter),2),"T",1,'L');
              $pdf->Cell(180,4,utf8_decode(''),"",0,'R');
              $pdf->Cell(20,4,utf8_decode(''),"T",1,'L');
              //$pdf->Cell(15,4,utf8_decode(number_format(($totalAnticipoImpuestoC+$totalImpuestoC+$totalAnticipoImpuestoI+$totalImpuestoI),2)),"T",0,'L');
              //$pdf->SetFont('Arial','B',8);
              //$pdf->Cell(25,4,"= ".number_format(($totalSoloCable+$totalSoloInter+$totalAnticipoSoloCable+$totalAnticipoSoloInter+$totalAnticipoImpuestoC+$totalImpuestoC+$totalAnticipoImpuestoI+$totalImpuestoI),2),"T",1,'L');

              //TOTAL MANUAL
              /*
              $pdf->SetFont('Arial','',8);
              $pdf->Cell(180,4,utf8_decode('TOTAL MANUALES: '),"",0,'R');
              $pdf->Cell(20,4,'',"T",0,'L');
              $pdf->Cell(20,4,'',"T",0,'L');
              $pdf->Cell(15,4,'',"T",0,'L');
              $pdf->Cell(25,4,"+ ".number_format(($result3),2),"T",1,'L');

              //TOTAL
              $pdf->Cell(180,4,utf8_decode('TOTAL GENERAL + MANUALES: '),"",0,'R');
              $pdf->Cell(20,4,'',"T",0,'L');
              $pdf->Cell(20,4,'',"T",0,'L');
              $pdf->Cell(15,4,'',"T",0,'L');
              $pdf->SetFont('Arial','B',8);
              $pdf->Cell(25,4,"= ".number_format(($totalSoloCable+$totalSoloInter+$totalAnticipoSoloCable+$totalAnticipoSoloInter+$totalAnticipoImpuestoC+$totalImpuestoC+$totalAnticipoImpuestoI+$totalImpuestoI+$result3),2),"T",1,'L');
              */
              $pdf->Ln(15);
              //$pdf->Cell(190,4,utf8_decode("IMPRESO POR: ".strtoupper($_SESSION['nombres'])." ".strtoupper($_SESSION['apellidos']). "EN LA FECHA"." ".date('d/m/Y h:i:s')),"",1,'L');
          }


      }elseif ($detallado == null){ //EN ESTA CONDICION SE EVALUA SI EL REPORTE SE MOSTRARÁ GENERAL
            //************************************************************************************************************************
            //************************************************************************************************************************
            //************************************************************************************************************************
            //************************************************************************************************************************
            if ($tipoServicio == "C") {
                              ///// inicio de obtenencion de datos de la tabla cargos para liquidar los abonos
              /*
                $query = "SELECT codigoCliente, mesCargo FROM tbl_cargos WHERE fechaFactura BETWEEN '".$desde."' AND '".$hasta."' AND tipoServicio= '".$tipoServicio."'";
                      $resultado = $mysqli->query($query);
                       while($row = $resultado->fetch_assoc())
                       {
                        $codigoCliente = $row['codigoCliente'];
                        $mesCargof = $row['mesCargo'];
                        }
                        */
                        ///// finalizacion de obtenencion de datos de la tabla cargos para liquidar los abonos
                //SQL para todas las zonas de cobro
                if ($_POST["lCobrador"] === "todos" && $_POST["lColonia"] === "todas") {
                    $query = "SELECT * FROM tbl_abonos WHERE tipoServicio= '".$tipoServicio."' AND anticipado= '".$anticipado."' AND codigoCliente!= '".$recibo_anulado."'  AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                    $resultado = $mysqli->query($query);
                }elseif ($_POST["lCobrador"] === "todos" && $_POST["lColonia"] != "todas") {
                    $query = "SELECT * FROM tbl_abonos WHERE idColonia= '".$colonia."' AND tipoServicio= '".$tipoServicio."' AND anticipado= '".$anticipado."' AND codigoCliente!= '".$recibo_anulado."'  AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                    $resultado = $mysqli->query($query);
                }elseif ($_POST["lCobrador"] != "todos" && $_POST["lColonia"] === "todas") {
                    $query = "SELECT * FROM tbl_abonos WHERE cobradoPor= '".$codigoCobrador."' AND tipoServicio= '".$tipoServicio."' AND anticipado= '".$anticipado."' AND codigoCliente!= '".$recibo_anulado."'  AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                    $resultado = $mysqli->query($query);
                }else {
                    $query = "SELECT * FROM tbl_abonos WHERE cobradoPor= '".$codigoCobrador."' AND idColonia= '".$colonia."' AND tipoServicio= '".$tipoServicio."' AND anticipado= '".$anticipado."' AND codigoCliente!= '".$recibo_anulado."'  AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                    $resultado = $mysqli->query($query);
                }
            }elseif ($tipoServicio == "I") {
                              ///// inicio de obtenencion de datos de la tabla cargos para liquidar los abonos
              /*
                $query = "SELECT codigoCliente, mesCargo FROM tbl_cargos WHERE fechaFactura BETWEEN '".$desde."' AND '".$hasta."' AND tipoServicio= '".$tipoServicio."'";
                      $resultado = $mysqli->query($query);
                       while($row = $resultado->fetch_assoc())
                       {
                        $codigoCliente = $row['codigoCliente'];
                        $mesCargof = $row['mesCargo'];
                        }
                        */
                        ///// finalizacion de obtenencion de datos de la tabla cargos para liquidar los abonos
                //SQL para todas las zonas de cobro
                if ($_POST["lCobrador"] === "todos" && $_POST["lColonia"] === "todas") {
                    $query = "SELECT * FROM tbl_abonos WHERE tipoServicio= '".$tipoServicio."' AND anticipado= '".$anticipado."' AND codigoCliente!= '".$recibo_anulado."'  AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                    $resultado = $mysqli->query($query);
                }elseif ($_POST["lCobrador"] === "todos" && $_POST["lColonia"] != "todas") {
                    $query = "SELECT * FROM tbl_abonos WHERE idColonia= '".$colonia."' AND tipoServicio= '".$tipoServicio."' AND anticipado= '".$anticipado."' AND codigoCliente!= '".$recibo_anulado."'  AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                    $resultado = $mysqli->query($query);
                }elseif ($_POST["lCobrador"] != "todos" && $_POST["lColonia"] === "todas") {
                    $query = "SELECT * FROM tbl_abonos WHERE cobradoPor= '".$codigoCobrador."' AND tipoServicio= '".$tipoServicio."' AND anticipado= '".$anticipado."' AND codigoCliente!= '".$recibo_anulado."'  AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                    $resultado = $mysqli->query($query);
                }else {
                    $query = "SELECT * FROM tbl_abonos WHERE cobradoPor= '".$codigoCobrador."' AND idColonia= '".$colonia."' AND tipoServicio= '".$tipoServicio."' AND anticipado= '".$anticipado."' AND codigoCliente!= '".$recibo_anulado."'  AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                    $resultado = $mysqli->query($query);
                }
            }

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

            $query3 = "SELECT SUM(montoCable) AS totalManualesC, SUM(impuesto) AS totalImpC FROM tbl_ventas_manuales WHERE anulada = 0 AND fechaComprobante BETWEEN '".$desde."' AND '".$hasta."' AND montoCable > 0";
            $statement3 = $mysqli->query($query3);

            while ($tManualesC = $statement3->fetch_assoc()) {
                $tmc = $tManualesC["totalManualesC"];
                $tic = $tManualesC["totalImpC"];

                $separadoC = (floatval($tmc)/(1 + floatval($iva)));
                $totalIvaC= (doubleval($separadoC) * doubleval($iva));
            }

            $query3 = "SELECT SUM(montoInternet) AS totalManualesI, SUM(impuesto) AS totalImpI FROM tbl_ventas_manuales WHERE anulada = 0 AND fechaComprobante BETWEEN '".$desde."' AND '".$hasta."' AND montoInternet > 0";
            $statement3 = $mysqli->query($query3);

            while ($tManualesI = $statement3->fetch_assoc()) {
                $tmi = $tManualesI["totalManualesI"];
                $tii = $tManualesI["totalImpI"];

                $separadoI = (floatval($tmi)/(1 + floatval($iva)));
                $totalIvaI = (doubleval($separadoI) * doubleval($iva));
            }

            $pdf = new FPDF();

            $pdf->AddPage('P','Letter');
            $pdf->SetFont('Arial','',6);
            date_default_timezone_set('America/El_Salvador');
            $pdf->Cell(200,6,utf8_decode("Página ".str_pad($pdf->pageNo(),4,"0",STR_PAD_LEFT)),0,1,'R');
            $pdf->Cell(200,4,utf8_decode("IMPRESO POR: ".strtoupper($_SESSION['nombres'])." ".strtoupper($_SESSION['apellidos']). " ".date('d/m/Y h:i:s')),"",1,'R');
            $pdf->Image('../../../images/logo.png',10,10, 20, 18);

            $pdf->Ln(15);

            /*$pdf->SetFont('Arial','B',13);
            $pdf->Cell(190,6,utf8_decode('F-3'),0,1,'R');
            $pdf->Ln();
            $pdf->Cell(190,6,utf8_decode('PAGARÉ SIN PROTESTO'),0,1,'C');
            $pdf->Ln(10);*/
            $pdf->SetFont('Arial','B',8);

            //$pdf->SetFont('Arial','B',11);

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
            }
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(190, 4, utf8_decode('FECHA DE GENERACIÓN '.$hasta), 0, 1, 'L');

            $pdf->SetFont('Arial','B',9);
            /*$pdf->Cell(20,5,utf8_decode('N°'),1,0,'L');
            $pdf->Cell(20,5,utf8_decode('N° de recibo'),1,0,'L');
            $pdf->Cell(20,5,utf8_decode('Fecha'),1,0,'L');
            $pdf->Cell(70,5,utf8_decode('Cliente'),1,0,'L');
            $pdf->Cell(20,5,utf8_decode('Mes que abonó'),1,0,'L');
            $pdf->Cell(10,5,utf8_decode('Día cob'),1,0,'L');
            $pdf->Cell(20,5,utf8_decode('Tipo serv'),1,0,'L');
            $pdf->Cell(20,5,utf8_decode('Abonado'),1,0,'L');*/
            $pdf->Cell(200,5,utf8_decode('RESUMEN GENERAL DE INGRESOS DE FACTURACION POR GENERACIÓN '.$hasta),'B',1,'C');
            $pdf->Ln(6);
            /*$pdf->SetFont('Arial','B',6.5);
            $pdf->Cell(35,1,utf8_decode('TOTAL VENTAS MANUALES:'),0,0,'L');
            $pdf->Cell(18,1,utf8_decode(number_format($result3,2)),0,1,'L');
            $pdf->Ln(3);*/
            /*
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(200,4,utf8_decode('VM VENTAS MANUALES'),0,1,'L');
            $pdf->Cell(40,4,utf8_decode('SERVICIO'),0,0,'L');
            $pdf->Cell(30,4,utf8_decode('TOTAL'),0,0,'L');
            $pdf->Cell(50,4,utf8_decode('TOTAL NETO'),0,0,'L');
            $pdf->Cell(30,4,utf8_decode('IVA'),0,0,'L');
            $pdf->Cell(30,4,utf8_decode('CESC'),0,1,'L');

            $pdf->SetFont('Arial','',8);
            $pdf->Cell(40,4,utf8_decode('CABLE'),"T",0,'L');
            $pdf->Cell(30,4,number_format($tmc,2),"T",0,'L');
            $pdf->Cell(50,4,number_format($separadoC,2),"T",0,'L');
            $pdf->Cell(30,4,number_format(($totalIvaC),2),"T",0,'L');
            $pdf->Cell(30,4,number_format(($tic),2),"T",1,'L');
            $pdf->Ln(1);

            $pdf->Cell(40,4,utf8_decode('INTERNET'),"T",0,'L');
            $pdf->Cell(30,4,number_format($tmi,2),"T",0,'L');
            $pdf->Cell(50,4,number_format($separadoI,2),"T",0,'L');
            $pdf->Cell(30,4,number_format(($totalIvaI),2),"T",0,'L');
            $pdf->Cell(30,4,number_format(($tii),2),"T",1,'L');
            $pdf->Ln(1);
            $pdf->SetFont('Arial','I',8);
            $pdf->SetFillColor(207,216,220);
            $pdf->Cell(60,5,utf8_decode('TOTAL '."VENTAS MANUALES".":"),"BTL",0,'R',1);
            /*$pdf->Cell(20,5,number_format($totalCobrador,2),"T",0,'L');
            $pdf->Cell(20,5,'$ '.number_format($totalAnticipoCobrador,2),"T",1,'L');
            $pdf->Cell(15,5,number_format(($totalImpuestosCobrador),2),"T",0,'L');*/
           // $pdf->Cell(20,5,number_format(($tmc+$tic+$tmi+$tii),2),"BTR",1,'L',1);
            //$pdf->Ln(3);

            if ($codigoCobrador === "todos") {

                $query1 = "SELECT codigoCobrador, nombreCobrador FROM tbl_cobradores";
                // Preparación de sentencia
                $statement1 = $mysqli->query($query1);
                $controlCobrador="";
                $counter2=1;
                while ($cobradores = $statement1->fetch_assoc()) {//RECORRIDO DE TODOS LOS COBRADORES
                    $cobradorR = $cobradores["codigoCobrador"];
                    $totalCobradorCable = 0;
                    $totalIvaCable = 0;
                    $totalIvaInter = 0;
                    $totalImpuestoCobradorC = 0;
                    $totalCobradorInter = 0;
                    $totalImpuestoCobradorI = 0;
                    $totalAnticipoCobradorCable = 0;
                    $totalAnticipoCobradorInter = 0;
                    $totalAnticipoImpuestoCobradorC = 0;
                    $totalAnticipoImpuestoCobradorI = 0;

                    if($tipoServicio == "A") {
                                      ///// inicio de obtenencion de datos de la tabla cargos para liquidar los abonos
                      /*
                $query = "SELECT codigoCliente, mesCargo FROM tbl_cargos WHERE fechaFactura BETWEEN '".$desde."' AND '".$hasta."'";
                      $resultado = $mysqli->query($query);
                       while($row = $resultado->fetch_assoc())
                       {
                        $codigoCliente = $row['codigoCliente'];
                        $mesCargof = $row['mesCargo'];
                        }
                        */
                        ///// finalizacion de obtenencion de datos de la tabla cargos para liquidar los abonos
                        //SQL para todas las zonas de cobro
                        if ($_POST["lCobrador"] === "todos" && $_POST["lColonia"] === "todas") {
                            $query = "SELECT * FROM tbl_abonos WHERE codigoCliente!= '".$recibo_anulado."' AND cobradoPor= '".$cobradorR."' AND anticipado= '".$anticipado."'  AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                            $resultado = $mysqli->query($query);
                        }elseif ($_POST["lCobrador"] === "todos" && $_POST["lColonia"] != "todas") {
                            $query = "SELECT * FROM tbl_abonos WHERE idColonia= '".$colonia."' AND codigoCobrador= '".$cobradorR."' AND anticipado= '".$anticipado."' AND codigoCliente!= '".$recibo_anulado."'  AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                            $resultado = $mysqli->query($query);
                        }
                    }elseif ($tipoServicio == "C") {
                                      ///// inicio de obtenencion de datos de la tabla cargos para liquidar los abonos
                      /*
                $query = "SELECT codigoCliente, mesCargo FROM tbl_cargos WHERE fechaFactura BETWEEN '".$desde."' AND '".$hasta."' AND tipoServicio= '".$tipoServicio."'";
                      $resultado = $mysqli->query($query);
                       while($row = $resultado->fetch_assoc())
                       {
                        $codigoCliente = $row['codigoCliente'];
                        $mesCargof = $row['mesCargo'];
                        }
                        */
                        ///// finalizacion de obtenencion de datos de la tabla cargos para liquidar los abonos
                        if ($_POST["lCobrador"] === "todos" && $_POST["lColonia"] === "todas") {
                            $query = "SELECT * FROM tbl_abonos WHERE codigoCliente!= '".$recibo_anulado."' AND tipoServicio= '".$tipoServicio."' AND anticipado= '".$anticipado."' AND cobradoPor= '".$cobradorR."'  AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                            $resultado = $mysqli->query($query);
                        }elseif ($_POST["lCobrador"] == "todos" && $_POST["lColonia"] != "todas") {
                            $query = "SELECT * FROM tbl_abonos WHERE idColonia= '".$colonia."' AND cobradoPor= '".$cobradorR."' AND tipoServicio= '".$tipoServicio."' AND anticipado= '".$anticipado."' AND codigoCliente!= '".$recibo_anulado."'  AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                            $resultado = $mysqli->query($query);
                        }
                    }elseif ($tipoServicio == "I") {
                                      ///// inicio de obtenencion de datos de la tabla cargos para liquidar los abonos
                      /*
                $query = "SELECT codigoCliente, mesCargo FROM tbl_cargos WHERE fechaFactura BETWEEN '".$desde."' AND '".$hasta."' AND tipoServicio= '".$tipoServicio."'";
                      $resultado = $mysqli->query($query);
                       while($row = $resultado->fetch_assoc())
                       {
                        $codigoCliente = $row['codigoCliente'];
                        $mesCargof = $row['mesCargo'];
                        }
                        */
                        ///// finalizacion de obtenencion de datos de la tabla cargos para liquidar los abonos
                        if ($_POST["lCobrador"] === "todos" && $_POST["lColonia"] === "todas") {
                            $query = "SELECT * FROM tbl_abonos WHERE codigoCliente!= '".$recibo_anulado."' AND tipoServicio= '".$tipoServicio."' AND anticipado= '".$anticipado."' AND cobradoPor= '".$cobradorR."'  AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                            $resultado = $mysqli->query($query);
                        }elseif ($_POST["lCobrador"] === "todos" && $_POST["lColonia"] != "todas") {
                            $query = "SELECT * FROM tbl_abonos WHERE idColonia= '".$colonia."' AND cobradoPor= '".$cobradorR."' AND tipoServicio= '".$tipoServicio."' AND anticipado= '".$anticipado."' AND codigoCliente!= '".$recibo_anulado."'  AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                            $resultado = $mysqli->query($query);
                        }
                    }

                    while($row = $resultado->fetch_assoc())
                    {
                        if ($row["cobradoPor"]==$cobradores["codigoCobrador"] && $controlCobrador != $cobradores["codigoCobrador"]) {
                            $pdf->SetFont('Arial','B',8);
                            $pdf->Cell(190,3,utf8_decode($cobradores["codigoCobrador"]." ".$cobradores['nombreCobrador']),0,1,'L');
                            $controlCobrador=$cobradores['codigoCobrador'];
                        }
                        if ($row["tipoServicio"] == "C") {
                            $query2 = "SELECT dia_cobro FROM clientes WHERE cod_cliente= ".$row['codigoCliente'];
                            // Preparación de sentencia
                            $statement2 = $mysqli->query($query2);
                            //$statement->execute();
                            while ($result2 = $statement2->fetch_assoc()) {
                                $diaCobro = $result2['dia_cobro'];
                            }
                        }
                        elseif ($row["tipoServicio"]  == "I") {
                            $query2 = "SELECT dia_corbo_in FROM clientes WHERE cod_cliente= ".$row['codigoCliente'];
                            // Preparación de sentencia
                            $statement2 = $mysqli->query($query2);
                            //$statement->execute();
                            while ($result2 = $statement2->fetch_assoc()) {
                                $diaCobro = $result2['dia_corbo_in'];
                            }
                        }

                        //$pdf->Ln(3);
                        $pdf->SetFont('Arial','',6.5);
                        /*$pdf->Cell(10,1,utf8_decode(''),0,0,'L');
                        $pdf->Cell(10,1,utf8_decode($row['idAbono']),0,0,'L');
                        $pdf->Cell(20,1,utf8_decode($row['numeroRecibo']),0,0,'L');
                        $pdf->Cell(20,1,utf8_decode($row['fechaAbonado']),0,0,'L');
                        $pdf->Cell(70,1,utf8_decode(strtoupper($row['codigoCliente']."  ".$row['nombre'])),0,0,'L');
                        $pdf->Cell(20,1,utf8_decode($row['mesCargo']),0,0,'L');
                        $pdf->Cell(10,1,utf8_decode($diaCobro),0,0,'L');
                        $pdf->Cell(20,1,utf8_decode($row['tipoServicio']),0,0,'L');*/


                        //$totalTotalCobrador = 0;
                        if ($row['anticipado'] == "1" || $row['anticipado'] == "T") {
                            if ($row['tipoServicio'] == "C") {
                                $separado = (doubleval($row['cuotaCable'])/(1 + doubleval($iva)));
                                $totalIva = (doubleval($separado) * doubleval($iva));
                                $totalIvaCable = doubleval($totalIvaCable) + doubleval($totalIva);

                                $totalAnticipoSoloCable = doubleval($totalAnticipoSoloCable) + doubleval($row['cuotaCable']);
                                $totalAnticipoCobradorCable = $totalAnticipoCobradorCable + doubleval($row['cuotaCable']);
                                $totalAnticipoCable = doubleval($totalAnticipoCable) + doubleval($row['cuotaCable'])+doubleval($row['totalImpuesto']);
                                $totalAnticipoImpuestoC = doubleval($totalAnticipoImpuestoC) + doubleval($row['totalImpuesto']);
                                $totalAnticipoImpuestoCobradorC = $totalAnticipoImpuestoCobradorC + doubleval($row['totalImpuesto']);
                            }elseif ($row['tipoServicio'] == "I") {
                                $separado = (doubleval($row['cuotaInternet'])/(1 + doubleval($iva)));
                                $totalIva = (doubleval($separado) * doubleval($iva));
                                $totalIvaInter = doubleval($totalIvaInter) + doubleval($totalIva);
                                /*$pdf->Cell(20,1,utf8_decode('0.00'),0,0,'L');
                                $pdf->Cell(20,1,utf8_decode($row['cuotaInternet']),0,0,'L');
                                $pdf->Cell(15,1,utf8_decode($row['totalImpuesto']),0,0,'L');
                                $pdf->Cell(20,1,utf8_decode(number_format(doubleval($row['cuotaInternet'])+doubleval($row['totalImpuesto']),2)),0,1,'L');*/
                                $totalAnticipoSoloInter = doubleval($totalAnticipoSoloInter) + doubleval($row['cuotaInternet']);
                                $totalAnticipoCobradorInter = $totalAnticipoCobradorInter + doubleval($row['cuotaInternet']);
                                $totalAnticipoInter = doubleval($totalAnticipoInter) + doubleval($row['cuotaInternet'])+doubleval($row['totalImpuesto']);
                                $totalAnticipoImpuestoI = doubleval($totalAnticipoImpuestoI) + doubleval($row['totalImpuesto']);
                                $totalAnticipoImpuestoCobradorI = $totalAnticipoImpuestoCobradorI + doubleval($row['totalImpuesto']);
                            }

                        }else {
                            if ($row['tipoServicio'] == "C") {
                                $separado = (doubleval($row['cuotaCable'])/(1 + doubleval($iva)));
                                $totalIva = (doubleval($separado) * doubleval($iva));
                                $totalIvaCable = doubleval($totalIvaCable) + doubleval($totalIva);
                                /*$pdf->Cell(20,1,utf8_decode($row['cuotaCable']),0,0,'L');
                                $pdf->Cell(20,1,utf8_decode("0.00"),0,0,'L');
                                $pdf->Cell(15,1,utf8_decode($row['totalImpuesto']),0,0,'L');
                                $pdf->Cell(20,1,utf8_decode(number_format(doubleval($row['cuotaCable'])+doubleval($row['totalImpuesto']),2)),0,1,'L');*/
                                $totalSoloCable = doubleval($totalSoloCable) + doubleval($row['cuotaCable']);
                                $totalCobradorCable = $totalCobradorCable + doubleval($row['cuotaCable']);
                                $totalCable = doubleval($totalCable) + doubleval($row['cuotaCable'])+doubleval($row['totalImpuesto']);
                                $totalImpuestoC = doubleval($totalImpuestoC) + doubleval($row['totalImpuesto']);
                                $totalImpuestoCobradorC = $totalImpuestoCobradorC + doubleval($row['totalImpuesto']);
                            }elseif ($row['tipoServicio'] == "I") {
                                $separado = (doubleval($row['cuotaInternet'])/(1 + doubleval($iva)));
                                $totalIva = (doubleval($separado) * doubleval($iva));
                                $totalIvaInter = doubleval($totalIvaInter) + doubleval($totalIva);
                                /*$pdf->Cell(20,1,utf8_decode($row['cuotaInternet']),0,0,'L');
                                $pdf->Cell(20,1,utf8_decode("0.00"),0,0,'L');
                                $pdf->Cell(15,1,utf8_decode($row['totalImpuesto']),0,0,'L');
                                $pdf->Cell(20,1,utf8_decode(number_format(doubleval($row['cuotaInternet'])+doubleval($row['totalImpuesto']),2)),0,1,'L');*/
                                $totalSoloInter = doubleval($totalSoloInter) + doubleval($row['cuotaInternet']);
                                $totalInter = doubleval($totalInter) + doubleval($row['cuotaInternet'])+doubleval($row['totalImpuesto']);
                                $totalCobradorInter = $totalCobradorInter + doubleval($row['cuotaInternet']);
                                $totalImpuestoI = doubleval($totalImpuestoI) + doubleval($row['totalImpuesto']);
                                $totalImpuestoCobradorI = $totalImpuestoCobradorI + doubleval($row['totalImpuesto']);
                            }

                        }

                    }
                    $pdf->Ln(1);
                    if ($controlCobrador == $cobradores["codigoCobrador"] && $controlCobrador != $row["cobradoPor"]) {

                        $totalCobrador = $totalCobradorCable+$totalCobradorInter;
                        $totalAnticipoCobrador = $totalAnticipoCobradorCable+$totalAnticipoCobradorInter;
                        $totalImpuestosCobrador = $totalAnticipoImpuestoCobradorI+$totalAnticipoImpuestoCobradorC+$totalImpuestoCobradorI+$totalImpuestoCobradorC;
                        $totalTotalCobrador = $totalCobrador+$totalAnticipoCobrador+$totalImpuestosCobrador;

                        $pdf->SetFont('Arial','B',8);
                        $pdf->Cell(40,4,utf8_decode('SERVICIO'),0,0,'L');
                        //$pdf->Cell(30,4,utf8_decode('TOTAL'),0,0,'L');
                        $pdf->Cell(50,4,utf8_decode('TOTAL ANTICIPO'),0,1,'L');
                        //$pdf->Cell(30,4,utf8_decode('IVA'),0,0,'L');
                        //$pdf->Cell(30,4,utf8_decode('CESC'),0,1,'L');

                        $pdf->SetFont('Arial','',8);
                        $pdf->Cell(40,4,utf8_decode('CABLE'),"T",0,'L');
                        //$pdf->Cell(30,4,number_format($totalCobradorCable,2),"T",0,'L');
                        $pdf->Cell(50,4,number_format($totalAnticipoCobradorCable,2),"T",1,'L');
                        //$pdf->Cell(30,4,number_format(($totalIvaCable),2),"T",0,'L');
                        //$pdf->Cell(30,4,number_format(($totalAnticipoImpuestoCobradorC+$totalImpuestoCobradorC),2),"T",1,'L');
                        $pdf->Ln(1);

                        $pdf->Cell(40,4,utf8_decode('INTERNET'),"T",0,'L');
                        //$pdf->Cell(30,4,number_format($totalCobradorInter,2),"T",0,'L');
                        $pdf->Cell(50,4,number_format($totalAnticipoCobradorInter,2),"T",1,'L');
                        //$pdf->Cell(30,4,number_format(($totalIvaInter),2),"T",0,'L');
                        //$pdf->Cell(30,4,number_format(($totalAnticipoImpuestoCobradorI+$totalImpuestoCobradorI),2),"T",1,'L');
                        $pdf->Ln(1);

                        $pdf->SetFont('Arial','I',8);
                        $pdf->SetFillColor(207,216,220);
                        $pdf->Cell(60,5,utf8_decode('TOTAL '.$cobradores["nombreCobrador"].":"),"BTL",0,'R',1);
                        /*$pdf->Cell(20,5,number_format($totalCobrador,2),"T",0,'L');
                        $pdf->Cell(20,5,'$ '.number_format($totalAnticipoCobrador,2),"T",1,'L');
                        $pdf->Cell(15,5,number_format(($totalImpuestosCobrador),2),"T",0,'L');*/
                        $pdf->Cell(20,5,number_format(($totalAnticipoCobrador),2),"BTR",1,'L',1);
                        $pdf->Ln(3);

                        if ($counter2 > 6){
                            $pdf->AddPage('P','Letter');
                            $pdf->SetFont('Arial','',6);
                            date_default_timezone_set('America/El_Salvador');
                            $pdf->Cell(190,6,utf8_decode("Página ".str_pad($pdf->pageNo(),4,"0",STR_PAD_LEFT)),0,1,'R');
                            $pdf->Cell(190,4,utf8_decode("IMPRESO POR: ".strtoupper($_SESSION['nombres'])." ".strtoupper($_SESSION['apellidos']). " ".date('d/m/Y h:i:s')),"",1,'R');
                            $pdf->Image('../../../images/logo.png',10,10, 20, 18);

                            $pdf->Ln(15);

                            date_default_timezone_set('America/El_Salvador');

                            //echo strftime("El año es %Y y el mes es %B");
                            putenv("LANG='es_ES.UTF-8'");
                            setlocale(LC_ALL, 'es_ES.UTF-8');

                            $pdf->SetFont('Arial', 'B', 9);
                            $pdf->Cell(190, 4, utf8_decode('CABLE VISION POR SATELITE, S.A DE C.V.'), 0, 1, 'L');
                            $pdf->SetFont('Arial', 'B', 7);
                            $pdf->Cell(190, 4, utf8_decode('LISTADO DE ABONOS ANTICIPADOS'), 0, 1, 'L');
                            if ($_SESSION['db'] == 'satpro_sm'){
                                $pdf->Cell(190, 4, utf8_decode('SUCURSAL SAN MIGUEL'), 0, 1, 'L');

                            }elseif ($_SESSION['db'] == 'satpro'){
                                $pdf->Cell(190, 4, utf8_decode('SUCURSAL USULUTÁN'), 0, 1, 'L');
                            }
                            $pdf->SetFont('Arial', '', 7);
                            $pdf->Cell(190, 4, utf8_decode('FECHA DE GENERACIÓN '.$hasta), 0, 1, 'L');

                            $pdf->SetFont('Arial','B',9);
                            $counter2=1;
                            $pdf->Cell(200,5,utf8_decode('RESUMEN GENERAL DE INGRESOS DE FACTURACION POR GENERACIÓN '.$hasta),'B',1,'C');
                            $pdf->Ln(3);

                        }
                        $counter2++;
                    }
                }

            }
            if ($codigoCobrador != "todos") {

                $query1 = "SELECT codigoCobrador, nombreCobrador FROM tbl_cobradores where codigoCobrador=".$codigoCobrador;
                // Preparación de sentencia
                $statement1 = $mysqli->query($query1);
                $controlCobrador="";
                $counter2=1;
                while ($cobradores = $statement1->fetch_assoc()) {//RECORRIDO DE TODOS LOS COBRADORES
                    $cobradorR = $cobradores["codigoCobrador"];
                    $totalCobradorCable = 0;
                    $totalIvaCable = 0;
                    $totalIvaInter = 0;
                    $totalImpuestoCobradorC = 0;
                    $totalCobradorInter = 0;
                    $totalImpuestoCobradorI = 0;
                    $totalAnticipoCobradorCable = 0;
                    $totalAnticipoCobradorInter = 0;
                    $totalAnticipoImpuestoCobradorC = 0;
                    $totalAnticipoImpuestoCobradorI = 0;

                    if($tipoServicio == "A") {
                                      ///// inicio de obtenencion de datos de la tabla cargos para liquidar los abonos
                      /*
                $query = "SELECT codigoCliente, mesCargo FROM tbl_cargos WHERE fechaFactura BETWEEN '".$desde."' AND '".$hasta."'";
                      $resultado = $mysqli->query($query);
                       while($row = $resultado->fetch_assoc())
                       {
                        $codigoCliente = $row['codigoCliente'];
                        $mesCargof = $row['mesCargo'];
                        }
                        */
                        ///// finalizacion de obtenencion de datos de la tabla cargos para liquidar los abonos
                        //SQL para todas las zonas de cobro
                        if ($_POST["lCobrador"] != "todos" && $_POST["lColonia"] === "todas") {
                            $query = "SELECT * FROM tbl_abonos WHERE codigoCliente!= '".$recibo_anulado."' AND cobradoPor= '".$cobradorR."' AND anticipado= '".$anticipado."'  AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                            $resultado = $mysqli->query($query);
                        }elseif ($_POST["lCobrador"] != "todos" && $_POST["lColonia"] != "todas") {
                            $query = "SELECT * FROM tbl_abonos WHERE idColonia= '".$colonia."' AND codigoCobrador= '".$cobradorR."' AND anticipado= '".$anticipado."' AND codigoCliente!= '".$recibo_anulado."'  AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                            $resultado = $mysqli->query($query);
                        }
                    }elseif ($tipoServicio == "C") {
                                      ///// inicio de obtenencion de datos de la tabla cargos para liquidar los abonos
                      /*
                $query = "SELECT codigoCliente, mesCargo FROM tbl_cargos WHERE fechaFactura BETWEEN '".$desde."' AND '".$hasta."' AND tipoServicio= '".$tipoServicio."'";
                      $resultado = $mysqli->query($query);
                       while($row = $resultado->fetch_assoc())
                       {
                        $codigoCliente = $row['codigoCliente'];
                        $mesCargof = $row['mesCargo'];
                        }
                        */
                        ///// finalizacion de obtenencion de datos de la tabla cargos para liquidar los abonos
                        if ($_POST["lCobrador"] != "todos" && $_POST["lColonia"] === "todas") {
                            $query = "SELECT * FROM tbl_abonos WHERE codigoCliente!= '".$recibo_anulado."' AND tipoServicio= '".$tipoServicio."' AND anticipado= '".$anticipado."' AND cobradoPor= '".$cobradorR."'  AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                            $resultado = $mysqli->query($query);
                        }elseif ($_POST["lCobrador"] != "todos" && $_POST["lColonia"] != "todas") {
                            $query = "SELECT * FROM tbl_abonos WHERE idColonia= '".$colonia."' AND cobradoPor= '".$cobradorR."' AND tipoServicio= '".$tipoServicio."' AND anticipado= '".$anticipado."' AND codigoCliente!= '".$recibo_anulado."'  AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                            $resultado = $mysqli->query($query);
                        }
                    }elseif ($tipoServicio == "I") {
                                      ///// inicio de obtenencion de datos de la tabla cargos para liquidar los abonos
                      /*
                $query = "SELECT codigoCliente, mesCargo FROM tbl_cargos WHERE fechaFactura BETWEEN '".$desde."' AND '".$hasta."' AND tipoServicio= '".$tipoServicio."'";
                      $resultado = $mysqli->query($query);
                       while($row = $resultado->fetch_assoc())
                       {
                        $codigoCliente = $row['codigoCliente'];
                        $mesCargof = $row['mesCargo'];
                        }
                        */
                        ///// finalizacion de obtenencion de datos de la tabla cargos para liquidar los abonos
                        if ($_POST["lCobrador"] != "todos" && $_POST["lColonia"] === "todas") {
                            $query = "SELECT * FROM tbl_abonos WHERE codigoCliente!= '".$recibo_anulado."' AND tipoServicio= '".$tipoServicio."' AND anticipado= '".$anticipado."' AND cobradoPor= '".$cobradorR."'  AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                            $resultado = $mysqli->query($query);
                        }elseif ($_POST["lCobrador"] != "todos" && $_POST["lColonia"] != "todas") {
                            $query = "SELECT * FROM tbl_abonos WHERE idColonia= '".$colonia."' AND cobradoPor= '".$cobradorR."' AND tipoServicio= '".$tipoServicio."' AND anticipado= '".$anticipado."' AND codigoCliente!= '".$recibo_anulado."'  AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                            $resultado = $mysqli->query($query);
                        }
                    }

                    while($row = $resultado->fetch_assoc())
                    {
                        if ($row["cobradoPor"]==$cobradores["codigoCobrador"] && $controlCobrador != $cobradores["codigoCobrador"]) {
                            $pdf->SetFont('Arial','B',8);
                            $pdf->Cell(190,3,utf8_decode($cobradores["codigoCobrador"]." ".$cobradores['nombreCobrador']),0,1,'L');
                            $controlCobrador=$cobradores['codigoCobrador'];
                        }
                        if ($row["tipoServicio"] == "C") {
                            $query2 = "SELECT dia_cobro FROM clientes WHERE cod_cliente= ".$row['codigoCliente'];
                            // Preparación de sentencia
                            $statement2 = $mysqli->query($query2);
                            //$statement->execute();
                            while ($result2 = $statement2->fetch_assoc()) {
                                $diaCobro = $result2['dia_cobro'];
                            }
                        }
                        elseif ($row["tipoServicio"]  == "I") {
                            $query2 = "SELECT dia_corbo_in FROM clientes WHERE cod_cliente= ".$row['codigoCliente'];
                            // Preparación de sentencia
                            $statement2 = $mysqli->query($query2);
                            //$statement->execute();
                            while ($result2 = $statement2->fetch_assoc()) {
                                $diaCobro = $result2['dia_corbo_in'];
                            }
                        }

                        //$pdf->Ln(3);
                        $pdf->SetFont('Arial','',6.5);
                        /*$pdf->Cell(10,1,utf8_decode(''),0,0,'L');
                        $pdf->Cell(10,1,utf8_decode($row['idAbono']),0,0,'L');
                        $pdf->Cell(20,1,utf8_decode($row['numeroRecibo']),0,0,'L');
                        $pdf->Cell(20,1,utf8_decode($row['fechaAbonado']),0,0,'L');
                        $pdf->Cell(70,1,utf8_decode(strtoupper($row['codigoCliente']."  ".$row['nombre'])),0,0,'L');
                        $pdf->Cell(20,1,utf8_decode($row['mesCargo']),0,0,'L');
                        $pdf->Cell(10,1,utf8_decode($diaCobro),0,0,'L');
                        $pdf->Cell(20,1,utf8_decode($row['tipoServicio']),0,0,'L');*/


                        //$totalTotalCobrador = 0;
                        if ($row['anticipado'] == "1" || $row['anticipado'] == "T") {
                            if ($row['tipoServicio'] == "C") {
                                $separado = (doubleval($row['cuotaCable'])/(1 + doubleval($iva)));
                                $totalIva = (doubleval($separado) * doubleval($iva));
                                $totalIvaCable = doubleval($totalIvaCable) + doubleval($totalIva);

                                $totalAnticipoSoloCable = doubleval($totalAnticipoSoloCable) + doubleval($row['cuotaCable']);
                                $totalAnticipoCobradorCable = $totalAnticipoCobradorCable + doubleval($row['cuotaCable']);
                                $totalAnticipoCable = doubleval($totalAnticipoCable) + doubleval($row['cuotaCable'])+doubleval($row['totalImpuesto']);
                                $totalAnticipoImpuestoC = doubleval($totalAnticipoImpuestoC) + doubleval($row['totalImpuesto']);
                                $totalAnticipoImpuestoCobradorC = $totalAnticipoImpuestoCobradorC + doubleval($row['totalImpuesto']);
                            }elseif ($row['tipoServicio'] == "I") {
                                $separado = (doubleval($row['cuotaInternet'])/(1 + doubleval($iva)));
                                $totalIva = (doubleval($separado) * doubleval($iva));
                                $totalIvaInter = doubleval($totalIvaInter) + doubleval($totalIva);
                                /*$pdf->Cell(20,1,utf8_decode('0.00'),0,0,'L');
                                $pdf->Cell(20,1,utf8_decode($row['cuotaInternet']),0,0,'L');
                                $pdf->Cell(15,1,utf8_decode($row['totalImpuesto']),0,0,'L');
                                $pdf->Cell(20,1,utf8_decode(number_format(doubleval($row['cuotaInternet'])+doubleval($row['totalImpuesto']),2)),0,1,'L');*/
                                $totalAnticipoSoloInter = doubleval($totalAnticipoSoloInter) + doubleval($row['cuotaInternet']);
                                $totalAnticipoCobradorInter = $totalAnticipoCobradorInter + doubleval($row['cuotaInternet']);
                                $totalAnticipoInter = doubleval($totalAnticipoInter) + doubleval($row['cuotaInternet'])+doubleval($row['totalImpuesto']);
                                $totalAnticipoImpuestoI = doubleval($totalAnticipoImpuestoI) + doubleval($row['totalImpuesto']);
                                $totalAnticipoImpuestoCobradorI = $totalAnticipoImpuestoCobradorI + doubleval($row['totalImpuesto']);
                            }

                        }else {
                            if ($row['tipoServicio'] == "C") {
                                $separado = (doubleval($row['cuotaCable'])/(1 + doubleval($iva)));
                                $totalIva = (doubleval($separado) * doubleval($iva));
                                $totalIvaCable = doubleval($totalIvaCable) + doubleval($totalIva);
                                /*$pdf->Cell(20,1,utf8_decode($row['cuotaCable']),0,0,'L');
                                $pdf->Cell(20,1,utf8_decode("0.00"),0,0,'L');
                                $pdf->Cell(15,1,utf8_decode($row['totalImpuesto']),0,0,'L');
                                $pdf->Cell(20,1,utf8_decode(number_format(doubleval($row['cuotaCable'])+doubleval($row['totalImpuesto']),2)),0,1,'L');*/
                                $totalSoloCable = doubleval($totalSoloCable) + doubleval($row['cuotaCable']);
                                $totalCobradorCable = $totalCobradorCable + doubleval($row['cuotaCable']);
                                $totalCable = doubleval($totalCable) + doubleval($row['cuotaCable'])+doubleval($row['totalImpuesto']);
                                $totalImpuestoC = doubleval($totalImpuestoC) + doubleval($row['totalImpuesto']);
                                $totalImpuestoCobradorC = $totalImpuestoCobradorC + doubleval($row['totalImpuesto']);
                            }elseif ($row['tipoServicio'] == "I") {
                                $separado = (doubleval($row['cuotaInternet'])/(1 + doubleval($iva)));
                                $totalIva = (doubleval($separado) * doubleval($iva));
                                $totalIvaInter = doubleval($totalIvaInter) + doubleval($totalIva);
                                /*$pdf->Cell(20,1,utf8_decode($row['cuotaInternet']),0,0,'L');
                                $pdf->Cell(20,1,utf8_decode("0.00"),0,0,'L');
                                $pdf->Cell(15,1,utf8_decode($row['totalImpuesto']),0,0,'L');
                                $pdf->Cell(20,1,utf8_decode(number_format(doubleval($row['cuotaInternet'])+doubleval($row['totalImpuesto']),2)),0,1,'L');*/
                                $totalSoloInter = doubleval($totalSoloInter) + doubleval($row['cuotaInternet']);
                                $totalInter = doubleval($totalInter) + doubleval($row['cuotaInternet'])+doubleval($row['totalImpuesto']);
                                $totalCobradorInter = $totalCobradorInter + doubleval($row['cuotaInternet']);
                                $totalImpuestoI = doubleval($totalImpuestoI) + doubleval($row['totalImpuesto']);
                                $totalImpuestoCobradorI = $totalImpuestoCobradorI + doubleval($row['totalImpuesto']);
                            }

                        }


                    }
                    $pdf->Ln(1);
                    if ($controlCobrador == $cobradores["codigoCobrador"] && $controlCobrador != $row["cobradoPor"]) {

                        $totalCobrador = $totalCobradorCable+$totalCobradorInter;
                        $totalAnticipoCobrador = $totalAnticipoCobradorCable+$totalAnticipoCobradorInter;
                        $totalImpuestosCobrador = $totalAnticipoImpuestoCobradorI+$totalAnticipoImpuestoCobradorC+$totalImpuestoCobradorI+$totalImpuestoCobradorC;
                        $totalTotalCobrador = $totalCobrador+$totalAnticipoCobrador+$totalImpuestosCobrador;

                        $pdf->SetFont('Arial','B',8);
                        $pdf->Cell(40,4,utf8_decode('SERVICIO'),0,0,'L');
                        //$pdf->Cell(30,4,utf8_decode('TOTAL'),0,0,'L');
                        $pdf->Cell(50,4,utf8_decode('TOTAL ANTICIPO'),0,1,'L');
                        //$pdf->Cell(30,4,utf8_decode('IVA'),0,0,'L');
                        //$pdf->Cell(30,4,utf8_decode('CESC'),0,1,'L');

                        $pdf->SetFont('Arial','',8);
                        $pdf->Cell(40,4,utf8_decode('CABLE'),"T",0,'L');
                        //$pdf->Cell(30,4,number_format($totalCobradorCable,2),"T",0,'L');
                        $pdf->Cell(50,4,number_format($totalAnticipoCobradorCable,2),"T",1,'L');
                        //$pdf->Cell(30,4,number_format(($totalIvaCable),2),"T",0,'L');
                        //$pdf->Cell(30,4,number_format(($totalAnticipoImpuestoCobradorC+$totalImpuestoCobradorC),2),"T",1,'L');
                        $pdf->Ln(1);

                        $pdf->Cell(40,4,utf8_decode('INTERNET'),"T",0,'L');
                        //$pdf->Cell(30,4,number_format($totalCobradorInter,2),"T",0,'L');
                        $pdf->Cell(50,4,number_format($totalAnticipoCobradorInter,2),"T",1,'L');
                        //$pdf->Cell(30,4,number_format(($totalIvaInter),2),"T",0,'L');
                        //$pdf->Cell(30,4,number_format(($totalAnticipoImpuestoCobradorI+$totalImpuestoCobradorI),2),"T",1,'L');
                        $pdf->Ln(1);

                        $pdf->SetFont('Arial','I',8);
                        $pdf->SetFillColor(207,216,220);
                        $pdf->Cell(60,5,utf8_decode('TOTAL '.$cobradores["nombreCobrador"].":"),"BTL",0,'R',1);
                        /*$pdf->Cell(20,5,number_format($totalCobrador,2),"T",0,'L');
                        $pdf->Cell(20,5,'$ '.number_format($totalAnticipoCobrador,2),"T",1,'L');
                        $pdf->Cell(15,5,number_format(($totalImpuestosCobrador),2),"T",0,'L');*/
                        $pdf->Cell(20,5,number_format(($totalAnticipoCobrador),2),"BTR",1,'L',1);
                        $pdf->Ln(3);

                        if ($counter2 > 6){
                            $pdf->AddPage('P','Letter');
                            $pdf->SetFont('Arial','',6);
                            date_default_timezone_set('America/El_Salvador');
                            $pdf->Cell(190,6,utf8_decode("Página ".str_pad($pdf->pageNo(),4,"0",STR_PAD_LEFT)),0,1,'R');
                            $pdf->Cell(190,4,utf8_decode("IMPRESO POR: ".strtoupper($_SESSION['nombres'])." ".strtoupper($_SESSION['apellidos']). " ".date('d/m/Y h:i:s')),"",1,'R');
                            $pdf->Image('../../../images/logo.png',10,10, 20, 18);

                            $pdf->Ln(15);

                            date_default_timezone_set('America/El_Salvador');

                            //echo strftime("El año es %Y y el mes es %B");
                            putenv("LANG='es_ES.UTF-8'");
                            setlocale(LC_ALL, 'es_ES.UTF-8');

                            $pdf->SetFont('Arial', 'B', 9);
                            $pdf->Cell(190, 4, utf8_decode('CABLE VISION POR SATELITE, S.A DE C.V.'), 0, 1, 'L');
                            $pdf->SetFont('Arial', 'B', 7);
                            $pdf->Cell(190, 4, utf8_decode('LISTADO DE ABONOS ANTICIPADOS'), 0, 1, 'L');
                            if ($_SESSION['db'] == 'satpro_sm'){
                                $pdf->Cell(190, 4, utf8_decode('SUCURSAL SAN MIGUEL'), 0, 1, 'L');

                            }elseif ($_SESSION['db'] == 'satpro'){
                                $pdf->Cell(190, 4, utf8_decode('SUCURSAL USULUTÁN'), 0, 1, 'L');
                            }
                            $pdf->SetFont('Arial', '', 7);
                            $pdf->Cell(190, 4, utf8_decode('FECHA DE GENERACIÓN '.$hasta), 0, 1, 'L');

                            $pdf->SetFont('Arial','B',9);
                            $counter2=1;
                            $pdf->Cell(200,5,utf8_decode('RESUMEN GENERAL DE INGRESOS DE FACTURACION POR GENERACIÓN '.$hasta),'B',1,'C');
                            $pdf->Ln(3);

                        }
                        $counter2++;
                    }
                }

            }

            $pdf->Cell(185,4,utf8_decode(''),0,0,'R');
            $pdf->Cell(115,4,utf8_decode(''),"",1,'R');

            //$pdf->AddPage('L','Letter');
            $pdf->SetFont('Arial','B',8);

            $pdf->Cell(130,4,utf8_decode('TOTALES GENERALES'),'',1,'R');
            $pdf->SetFont('Arial','',8);
            //TOTAL INTERNET
            $pdf->Cell(115,4,utf8_decode('TOTAL INTERNET: '),0,0,'R');
            //$pdf->Cell(20,4,number_format($totalSoloInter,2),"T",0,'L');
            $pdf->Cell(20,4,'+ '.number_format($totalAnticipoSoloInter,2),"T",1,'L');
            //$pdf->Cell(15,4,number_format(($totalAnticipoImpuestoI+$totalImpuestoI),2),"T",0,'L');
            //$pdf->Cell(25,4,"+ ".number_format(($totalSoloInter+$totalAnticipoSoloInter+$totalAnticipoImpuestoI+$totalImpuestoI),2),"T",1,'L');

            //TOTAL CABLE
            $pdf->Cell(115,4,utf8_decode('TOTAL CABLE: '),0,0,'R');
            //$pdf->Cell(20,4,number_format($totalSoloCable,2),"T",0,'L');
            $pdf->Cell(20,4,'+ '.number_format($totalAnticipoSoloCable,2),"T",1,'L');
            //$pdf->Cell(15,4,number_format(($totalAnticipoImpuestoC+$totalImpuestoC),2),"T",0,'L');
            //$pdf->Cell(25,4,"+ ".number_format(($totalSoloCable+$totalAnticipoSoloCable+$totalAnticipoImpuestoC+$totalImpuestoC),2),"T",1,'L');

            //TOTAL IMPUESTO
            $pdf->Cell(115,4,utf8_decode('TOTAL GENERAL: '),"",0,'R');
            //$pdf->Cell(20,4,number_format(($totalSoloCable+$totalSoloInter),2),"T",0,'L');
            $pdf->Cell(20,4,'= '.number_format(($totalAnticipoSoloCable+$totalAnticipoSoloInter),2),"T",1,'L');
            $pdf->Cell(115,4,utf8_decode(''),"",0,'R');
            $pdf->Cell(20,4,utf8_decode(''),"T",1,'L');
            //$pdf->Cell(15,4,utf8_decode(number_format(($totalAnticipoImpuestoC+$totalImpuestoC+$totalAnticipoImpuestoI+$totalImpuestoI),2)),"T",0,'L');
            $pdf->SetFont('Arial','B',8);
            //$pdf->Cell(25,4,"= ".number_format(($totalSoloCable+$totalSoloInter+$totalAnticipoSoloCable+$totalAnticipoSoloInter+$totalAnticipoImpuestoC+$totalImpuestoC+$totalAnticipoImpuestoI+$totalImpuestoI),2),"T",1,'L');
/*
            //TOTAL MANUAL
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(75,4,utf8_decode('TOTAL MANUALES: '),"",0,'R');
            $pdf->Cell(20,4,'',"T",0,'L');
            $pdf->Cell(20,4,'',"T",0,'L');
            $pdf->Cell(15,4,'',"T",0,'L');
            $pdf->Cell(25,4,"+ ".number_format(($tmc+$tic+$tmi+$tii),2),"T",1,'L');

            //TOTAL
            $pdf->Cell(75,4,utf8_decode('TOTAL GENERAL + MANUALES: '),"",0,'R');
            $pdf->Cell(20,4,'',"T",0,'L');
            $pdf->Cell(20,4,'',"T",0,'L');
            $pdf->Cell(15,4,'',"T",0,'L');
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(25,4,"= ".number_format(($totalSoloCable+$totalSoloInter+$totalAnticipoSoloCable+$totalAnticipoSoloInter+$totalAnticipoImpuestoC+$totalImpuestoC+$totalAnticipoImpuestoI+$totalImpuestoI+$tmc+$tic+$tmi+$tii),2),"T",1,'L');
*/
            //$pdf->Ln(15);

        }

    /* close connection */
    mysqli_close($mysqli);
    $pdf->Output();

  }

  abonos();

?>