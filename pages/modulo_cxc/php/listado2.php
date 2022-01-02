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
  $fechaGenerada = $_POST['l2Fecha'];
  $codigoCobrador = $_POST['l2Cobrador'];
  $colonia = $_POST['l2Zonas'];
  $tipoServicio = $_POST['l2Servicio'];

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

  function abonos(){
	  global $codigoCobrador, $colonia, $tipoServicio, $mysqli,$fechaGenerada,/*$statement1*/$anulada;

	  $pdf = new FPDF();

	  $pdf->AddPage('L','Letter');
      $pdf->SetFont('Arial','',6.5);
      $pdf->Cell(260,6,utf8_decode("Página ".str_pad($pdf->pageNo(),4,"0",STR_PAD_LEFT)),0,1,'R');
	  $pdf->Image('../../../images/logo.png',10,10, 20, 18);

	  $pdf->Ln(15);

	  $pdf->SetFont('Arial','B',11);

	  date_default_timezone_set('America/El_Salvador');

	  //echo strftime("El año es %Y y el mes es %B");
      putenv("LANG='es_ES.UTF-8'");
      setlocale(LC_ALL, 'es_ES.UTF-8');
	  $pdf->SetFont('Arial','B',6.5);


      $pdf->Cell(10,5,utf8_decode('Código'),1,0,'L');
      $pdf->Cell(60,5,utf8_decode('Nombre'),1,0,'L');
      $pdf->Cell(150,5,utf8_decode('Dirección'),1,0,'L');
      $pdf->Cell(50,5,utf8_decode('Colonia'),1,1,'L');
      //$pdf->Cell(30,5,utf8_decode('Teléfonos'),1,1,'L');
      $pdf->Ln(3);

      if ($codigoCobrador === "todos") {

          $query1 = "SELECT codigoCobrador, nombreCobrador FROM tbl_cobradores";
          // Preparación de sentencia
          $statement1 = $mysqli->query($query1);
          $controlCobrador="";
          while ($cobradores = $statement1->fetch_assoc()) {//RECORRIDO DE TODOS LOS COBRADORES
              $cobradorR = $cobradores["codigoCobrador"];

              if($tipoServicio == "P") {

                  //SQL para todas las zonas de cobro
                  if ($_POST["l2Cobrador"] === "todos" && $_POST["l2Zonas"] === "todas") {
                      $query = "SELECT codigoCliente, nombre, direccion, codigoCobrador, t2.nombreColonia from tbl_cargos t1
                      inner join tbl_colonias_cxc t2 on (t1.`idColonia` = t2.`idColonia`) where fechaFactura= '".$fechaGenerada."' AND anulada= '".$anulada."' AND codigoCobrador= '".$cobradorR."' order by t1.`idColonia` ASC";
                	  $resultado = $mysqli->query($query);
                  }elseif ($_POST["l2Cobrador"] === "todos" && $_POST["l2Zonas"] != "todas") {
                      $query = "SELECT distinct codigoCliente, nombre, direccion, codigoCobrador, tipoServicio, t2.nombreColonia from tbl_cargos t1
                      inner join tbl_colonias_cxc t2 on (t1.`idColonia` = t2.`idColonia`) where idColonia= '".$colonia."' AND fechaFactura= '".$fechaGenerada."' AND anulada= '".$anulada."' AND codigoCobrador= '".$cobradorR."' order by t1.`idColonia` ASC";
                	  $resultado = $mysqli->query($query);
                  }
              }elseif ($tipoServicio == "C") {
                  if ($_POST["l2Cobrador"] === "todos" && $_POST["l2Zonas"] === "todas") {
                      $query = "SELECT distinct codigoCliente, nombre, direccion, codigoCobrador, tipoServicio, t2.nombreColonia from tbl_cargos t1
                      inner join tbl_colonias_cxc t2 on (t1.`idColonia` = t2.`idColonia`) where fechaFactura= '".$fechaGenerada."' AND anulada= '".$anulada."' AND codigoCobrador= '".$cobradorR."' order by t1.`idColonia` ASC";
                	  $resultado = $mysqli->query($query);
                  }elseif ($_POST["l2Cobrador"] === "todos" && $_POST["l2Zonas"] != "todas") {
                      $query = "SELECT distinct codigoCliente, nombre, direccion, codigoCobrador, tipoServicio, t2.nombreColonia from tbl_cargos t1
                      inner join tbl_colonias_cxc t2 on (t1.`idColonia` = t2.`idColonia`) where idColonia= '".$colonia."' AND fechaFactura= '".$fechaGenerada."' AND anulada= '".$anulada."' AND codigoCobrador= '".$cobradorR."' order by t1.`idColonia` ASC";
                	  $resultado = $mysqli->query($query);
                  }
              }elseif ($tipoServicio == "I") {
                  if ($_POST["l2Cobrador"] === "todos" && $_POST["l2Zonas"] === "todas") {
                      $query = "SELECT distinct codigoCliente, nombre, direccion, codigoCobrador, tipoServicio, t2.nombreColonia from tbl_cargos t1
                      inner join tbl_colonias_cxc t2 on (t1.`idColonia` = t2.`idColonia`) where fechaFactura= '".$fechaGenerada."' AND anulada= '".$anulada."' AND codigoCobrador= '".$cobradorR."' order by t1.`idColonia` ASC";
                	  $resultado = $mysqli->query($query);
                  }elseif ($_POST["l2Cobrador"] === "todos" && $_POST["l2Zonas"] != "todas") {
                      $query = "SELECT distinct codigoCliente, nombre, direccion, codigoCobrador, tipoServicio, t2.nombreColonia from tbl_cargos t1
                      inner join tbl_colonias_cxc t2 on (t1.`idColonia` = t2.`idColonia`) where idColonia= '".$colonia."' AND fechaFactura= '".$fechaGenerada."' AND anulada= '".$anulada."' AND codigoCobrador= '".$cobradorR."' order by t1.`idColonia` ASC";
                	  $resultado = $mysqli->query($query);
                  }
              }


              while($row = $resultado->fetch_assoc())
        	  {
                  if ($row["codigoCobrador"]==$cobradores["codigoCobrador"] && $controlCobrador != $cobradores["codigoCobrador"]) {
                      $pdf->SetFont('Arial','B',7);
                      $pdf->Cell(190,3,utf8_decode($cobradores['nombreCobrador']),0,1,'L');
                      $controlCobrador=$cobradores['codigoCobrador'];
                  }

                    $pdf->Ln(3);
                    $pdf->SetFont('Arial','',6.5);
                    $pdf->Cell(10,1,utf8_decode($row["codigoCliente"]),0,0,'L');
                    $pdf->Cell(60,1,utf8_decode(strtoupper($row["nombre"])),0,0,'L');
                    $pdf->Cell(150,1,utf8_decode(strtoupper($row["direccion"])),0,0,'L');
                    $pdf->Cell(50,1,utf8_decode(strtoupper($row["nombreColonia"])),0,1,'L');
                    //$pdf->Cell(30,5,utf8_decode(strtoupper($row["telefonos"])),1,1,'L');
        	  }
              $pdf->Ln(2);
          }

      }
      if ($codigoCobrador != "todos") {

          $query1 = "SELECT codigoCobrador, nombreCobrador FROM tbl_cobradores where codigoCobrador=".$codigoCobrador;
          // Preparación de sentencia
          $statement1 = $mysqli->query($query1);
          $controlCobrador="";
          while ($cobradores = $statement1->fetch_assoc()) {//RECORRIDO DE TODOS LOS COBRADORES
              $cobradorR = $cobradores["codigoCobrador"];
              //var_dump($cobradorR);
              //var_dump($colonia);
              if($tipoServicio == "P") {
                  //SQL para todas las zonas de cobro
                  if ($_POST["l2Cobrador"] != "todos" && $_POST["l2Colonia"] === "todas") {
                      $query = "SELECT * FROM tbl_cargos WHERE anulada= '".$anulada."' AND cobradoPor= '".$cobradorR."' AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                	  $resultado = $mysqli->query($query);
                  }elseif ($_POST["l2Cobrador"] != "todos" && $_POST["l2Colonia"] != "todas") {
                      $query = "SELECT * FROM tbl_cargos WHERE idColonia= '".$colonia."' AND codigoCobrador= '".$cobradorR."' AND anulada= '".$anulada."' AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                	  $resultado = $mysqli->query($query);
                  }
              }elseif ($tipoServicio == "C") {
                  if ($_POST["l2Cobrador"] != "todos" && $_POST["l2Colonia"] === "todas") {
                      $query = "SELECT * FROM tbl_cargos WHERE anulada= '".$anulada."' AND tipoServicio= '".$tipoServicio."' AND cobradoPor= '".$cobradorR."' AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                	  $resultado = $mysqli->query($query);
                  }elseif ($_POST["l2Cobrador"] != "todos" && $_POST["l2Colonia"] != "todas") {
                      $query = "SELECT * FROM tbl_cargos WHERE idColonia= '".$colonia."' AND cobradoPor= '".$cobradorR."' AND tipoServicio= '".$tipoServicio."' AND anulada= '".$anulada."' AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                	  $resultado = $mysqli->query($query);
                  }
              }elseif ($tipoServicio == "I") {
                  if ($_POST["l2Cobrador"] != "todos" && $_POST["l2Colonia"] === "todas") {
                      $query = "SELECT * FROM tbl_cargos WHERE anulada= '".$anulada."' AND tipoServicio= '".$tipoServicio."' AND cobradoPor= '".$cobradorR."' AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                	  $resultado = $mysqli->query($query);
                  }elseif ($_POST["l2Cobrador"] != "todos" && $_POST["l2Colonia"] != "todas") {
                      $query = "SELECT * FROM tbl_cargos WHERE idColonia= '".$colonia."' AND cobradoPor= '".$cobradorR."' AND tipoServicio= '".$tipoServicio."' AND anulada= '".$anulada."' AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
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
                    $pdf->Cell(10,1,utf8_decode(''),0,0,'L');
                    $pdf->Cell(10,1,utf8_decode($row['idAbono']),0,0,'L');
              		$pdf->Cell(20,1,utf8_decode($row['numeroRecibo']),0,0,'L');
              		$pdf->Cell(20,1,utf8_decode($row['fechaAbonado']),0,0,'L');
                    $pdf->Cell(70,1,utf8_decode(strtoupper($row['codigoCliente']."  ".$row['nombre'])),0,0,'L');
              		$pdf->Cell(20,1,utf8_decode($row['mesCargo']),0,0,'L');
              		$pdf->Cell(10,1,utf8_decode($diaCobro),0,0,'L');
                    $pdf->Cell(20,1,utf8_decode($row['tipoServicio']),0,0,'L');
                    if ($row['anticipado'] == "1" || $row['anticipado'] == "T") {
                        if ($row['tipoServicio'] == "C") {
                            $pdf->Cell(20,1,utf8_decode('0.00'),0,0,'L');
                      		$pdf->Cell(20,1,utf8_decode($row['cuotaCable']),0,0,'L');
                            $pdf->Cell(15,1,utf8_decode($row['totalImpuesto']),0,0,'L');
                      		$pdf->Cell(20,1,utf8_decode(number_format(doubleval($row['cuotaCable'])+doubleval($row['totalImpuesto']),2)),0,1,'L');
                            $totalAnticipoSoloCable = doubleval($totalAnticipoSoloCable) + doubleval($row['cuotaCable']);
                            $totalAnticipoCable = doubleval($totalAnticipoCable) + doubleval($row['cuotaCable'])+doubleval($row['totalImpuesto']);
                            $totalAnticipoImpuestoC = doubleval($totalAnticipoImpuestoC) + doubleval($row['totalImpuesto']);
                        }elseif ($row['tipoServicio'] == "I") {
                            $pdf->Cell(20,1,utf8_decode('0.00'),0,0,'L');
                      		$pdf->Cell(20,1,utf8_decode($row['cuotaInternet']),0,0,'L');
                            $pdf->Cell(15,1,utf8_decode($row['totalImpuesto']),0,0,'L');
                      		$pdf->Cell(20,1,utf8_decode(number_format(doubleval($row['cuotaInternet'])+doubleval($row['totalImpuesto']),2)),0,1,'L');
                            $totalAnticipoSoloInter = doubleval($totalAnticipoSoloInter) + doubleval($row['cuotaInternet']);
                            $totalAnticipoInter = doubleval($totalAnticipoInter) + doubleval($row['cuotaInternet'])+doubleval($row['totalImpuesto']);
                            $totalAnticipoImpuestoI = doubleval($totalAnticipoImpuestoI) + doubleval($row['totalImpuesto']);
                        }

                    }else {
                        if ($row['tipoServicio'] == "C") {
                            $pdf->Cell(20,1,utf8_decode($row['cuotaCable']),0,0,'L');
                      		$pdf->Cell(20,1,utf8_decode("0.00"),0,0,'L');
                            $pdf->Cell(15,1,utf8_decode($row['totalImpuesto']),0,0,'L');
                      		$pdf->Cell(20,1,utf8_decode(number_format(doubleval($row['cuotaCable'])+doubleval($row['totalImpuesto']),2)),0,1,'L');
                            $totalSoloCable = doubleval($totalSoloCable) + doubleval($row['cuotaCable']);
                            $totalCable = doubleval($totalCable) + doubleval($row['cuotaCable'])+doubleval($row['totalImpuesto']);
                            $totalImpuestoC = doubleval($totalImpuestoC) + doubleval($row['totalImpuesto']);
                        }elseif ($row['tipoServicio'] == "I") {
                            $pdf->Cell(20,1,utf8_decode($row['cuotaInternet']),0,0,'L');
                      		$pdf->Cell(20,1,utf8_decode("0.00"),0,0,'L');
                            $pdf->Cell(15,1,utf8_decode($row['totalImpuesto']),0,0,'L');
                      		$pdf->Cell(20,1,utf8_decode(number_format(doubleval($row['cuotaInternet'])+doubleval($row['totalImpuesto']),2)),0,1,'L');
                            $totalSoloInter = doubleval($totalSoloInter) + doubleval($row['cuotaInternet']);
                            $totalInter = doubleval($totalInter) + doubleval($row['cuotaInternet'])+doubleval($row['totalImpuesto']);
                            $totalImpuestoI = doubleval($totalImpuestoI) + doubleval($row['totalImpuesto']);
                        }

                    }

        	  }
              $pdf->Ln(2);
          }

      }

      /*$pdf->Cell(185,5,utf8_decode(''),0,0,'R');
      $pdf->Cell(75,5,utf8_decode(''),"",1,'R');

      //$pdf->AddPage('L','Letter');
      $pdf->SetFont('Arial','',8);

      //TOTAL INTERNET
      $pdf->Cell(190,5,utf8_decode('TOTAL INTERNET: '),0,0,'R');
      $pdf->Cell(20,5,number_format($totalSoloInter,2),"T",0,'L');
      $pdf->Cell(20,5,number_format($totalAnticipoSoloInter,2),"T",0,'L');
      $pdf->Cell(15,5,number_format(($totalAnticipoImpuestoI+$totalImpuestoI),2),"T",0,'L');
      $pdf->Cell(20,5,number_format(($totalSoloInter+$totalAnticipoSoloInter+$totalAnticipoImpuestoI+$totalImpuestoI),2),"T",1,'L');

      //TOTAL CABLE
      $pdf->Cell(190,5,utf8_decode('TOTAL CABLE: '),0,0,'R');
      $pdf->Cell(20,5,number_format($totalSoloCable,2),"T",0,'L');
      $pdf->Cell(20,5,number_format($totalAnticipoSoloCable,2),"T",0,'L');
      $pdf->Cell(15,5,number_format(($totalAnticipoImpuestoC+$totalImpuestoC),2),"T",0,'L');
      $pdf->Cell(20,5,number_format(($totalSoloCable+$totalAnticipoSoloCable+$totalAnticipoImpuestoC+$totalImpuestoC),2),"T",1,'L');

      //TOTAL IMPUESTO
      $pdf->Cell(190,5,utf8_decode('TOTAL GENERAL: '),"",0,'R');
      $pdf->Cell(20,5,number_format(($totalSoloCable+$totalSoloInter),2),"T",0,'L');
      $pdf->Cell(20,5,number_format(($totalAnticipoSoloCable+$totalAnticipoSoloInter),2),"T",0,'L');
      $pdf->Cell(15,5,utf8_decode(number_format(($totalAnticipoImpuestoC+$totalImpuestoC+$totalAnticipoImpuestoI+$totalImpuestoI),2)),"T",0,'L');
      $pdf->Cell(20,5,number_format(($totalSoloCable+$totalSoloInter+$totalAnticipoSoloCable+$totalAnticipoSoloInter+$totalAnticipoImpuestoC+$totalImpuestoC+$totalAnticipoImpuestoI+$totalImpuestoI),2),"T",1,'L');*0

	  /* close connection */
	  mysqli_close($mysqli);
	  $pdf->Output();

  }

  abonos();

?>
