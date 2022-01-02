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

  function f3(){
      if (isset($_GET['uaid1']) && !isset($_GET['uaid2'])) {

          // get passed parameter value, in this case, the record ID
          // isset() is a PHP function used to verify if a value is there or not
          $id=isset($_GET['uaid1']) ? $_GET['uaid1'] : die('ERROR: Record no encontrado.');
          $cod=isset($_GET['cod']) ? $_GET['cod'] : die('ERROR: Record no encontrado.');
          $desde=isset($_GET['desde']) ? $_GET['desde'] : die('ERROR: Record no encontrado.');
          $hasta=isset($_GET['hasta']) ? $_GET['hasta'] : die('ERROR: Record no encontrado.');
          $tipoServicio=isset($_GET['tipoServicio']) ? $_GET['tipoServicio'] : die('ERROR: Record no encontrado.');
              //var_dump($id);
        	  $pdf = new FPDF();
        	  $pdf->AliasNbPages();
        	  $pdf->AddPage('P','Letter');
        	  //$pdf->Image('../../../images/logo.png',10,10, 26, 24);
              date_default_timezone_set('America/El_Salvador');

              putenv("LANG='es_ES.UTF-8'");
              setlocale(LC_ALL, 'es_ES.UTF-8');

              $pdf->Ln(25);
              if ($tipoServicio == "i") {
                  global $mysqli, $data;
                  $tipoServicio = strtoupper($tipoServicio);
                  $query = "SELECT * FROM tbl_abonos WHERE numeroRecibo= '".$id."' AND codigoCliente= '".$cod."' AND tipoServicio= '".$tipoServicio."'";
                  //var_dump($query);
            	  $resultado = $mysqli->query($query);
                  $count = mysqli_num_rows($resultado);
                  $subtotal = 0;
                  $totalImpuesto = 0;
                  $total = 0;
                  while($row = $resultado->fetch_assoc())
                  {

                      $numRecibo = $row["numeroRecibo"];

                      $cliente = $row["codigoCliente"]."  ".$row["nombre"];
                      $concepto = "CONCEPTO: ".$count." mes/es de servicio de INTERNET correspondiente/s de";
                      $fechaAbonado = $row["fechaAbonado"];
                      $subtotal = $subtotal + $row["cuotaInternet"];
                      $totalImpuesto = $totalImpuesto + $row["totalImpuesto"];
                      $total = $total + $row["cuotaInternet"]+$row["totalImpuesto"];

                  }
                  $pdf->SetFont('Arial','B',10);
                  $pdf->Cell(150,3,/*utf8_decode("Ciudad de Usulután, ").*/utf8_decode(strftime('%A %e de %B de %G', strtotime($fechaAbonado))),"B",0,'L');
                  $pdf->Cell(40,3,utf8_decode("Recibo N°: ".$numRecibo),0,1,'L');
                  $pdf->Ln(7);
                  $pdf->Cell(190,3,utf8_decode("Cliente: ".$cliente),0,1,'L');
                  $pdf->SetFont('Arial','B',10);
                  $pdf->Ln(5);
                  $pdf->Cell(140,20,$concepto,1,0,'C');
                  if ($desde == $hasta){
                      $pdf->Cell(50,20,$desde,1,1,'C');
                  }else{
                      $pdf->Cell(50,20,$desde." a ".$hasta,1,1,'C');
                  }
                  $pdf->Ln(5);
                  $pdf->Cell(140,3,'No COMPROBANTE: '." ","B",0,'L');
                  $pdf->Cell(50,3,'VALOR ',"B",1,'L');
                  $pdf->Ln(5);
                  $pdf->Cell(140,4,'',"",0,'L');
                  $pdf->Cell(25,4,'Subtotal:',"",0,'R');
                  $pdf->Cell(25,4,number_format($subtotal,2),"",1,'L');
                  $pdf->Cell(140,4,'',"",0,'L');
                  $pdf->Cell(25,4,'Mora:',"",0,'R');
                  $pdf->Cell(25,4,"0.00","",1,'L');
                  $pdf->Cell(140,4,'',"",0,'L');
                  $pdf->Cell(25,4,'Imp. seguridad:',"",0,'R');
                  $pdf->Cell(25,5,number_format($totalImpuesto,2),"",1,'L');
                  $pdf->Cell(140,5,'',"",0,'L');
                  $pdf->Cell(25,5,'Total:',"TBL",0,'R');
                  $pdf->Cell(25,5,(number_format($total,2)),"TBR",1,'L');
                  $pdf->Ln(7);
                  $pdf->Cell(140,5,'',"",0,'L');
                  $pdf->Cell(10,5,'F:',"",0,'R');
                  $pdf->Cell(40,5,"","B",1,'L');
                  $pdf->Cell(140,5,'',"",0,'L');
                  $pdf->SetFont('Arial','B',6);
                  $pdf->Cell(50,5,utf8_decode("CABLEVISIÓN POR SATÉLITE S.A. DE. C.V."),"",1,'R');
                  //$pdf->Ln(7);
                  $pdf->Cell(190,5,utf8_decode("Nota: el presente recibo no tendrá validéz alguna sin su correspondiente firma y sello"),"",1,'C');

              }elseif ($tipoServicio == "c") {
                  global $mysqli, $data;
                  $tipoServicio = strtoupper($tipoServicio);
                  $query = "SELECT * FROM tbl_abonos WHERE numeroRecibo= '".$id."' AND codigoCliente= '".$cod."' AND tipoServicio= '".$tipoServicio."'";
                  //var_dump($query);
            	  $resultado = $mysqli->query($query);
                  $count = mysqli_num_rows($resultado);
                  $subtotal = 0;
                  $totalImpuesto = 0;
                  $total = 0;
                  while($row = $resultado->fetch_assoc())
            	  {

                      $numRecibo = $row["numeroRecibo"];
                      $fechaAbonado = $row["fechaAbonado"];
                      $cliente = $row["codigoCliente"]."  ".$row["nombre"];
                      $concepto = "CONCEPTO: ".$count." mes/es de servicio de CABLE TV correspondiente/s de";
                      $subtotal = $subtotal + $row["cuotaCable"];
                      $totalImpuesto = $totalImpuesto + $row["totalImpuesto"];
                      $total = $total + $row["cuotaCable"]+$row["totalImpuesto"];

                  }
                  $pdf->SetFont('Arial','B',10);
                  $pdf->Cell(150,3,/*utf8_decode("Ciudad de Usulután, ").*/utf8_decode(strftime('%A %e de %B de %G',strtotime($fechaAbonado))),"B",0,'L');
                  $pdf->Cell(40,3,utf8_decode("Recibo N°: ".$numRecibo),0,1,'L');
                  $pdf->Ln(7);
                  $pdf->Cell(190,3,utf8_decode("Cliente: ".$cliente),0,1,'L');
                  $pdf->SetFont('Arial','B',10);
                  $pdf->Ln(5);
                  $pdf->Cell(140,20,$concepto,1,0,'C');
                  if ($desde == $hasta){
                      $pdf->Cell(50,20,$desde,1,1,'C');
                  }else{
                      $pdf->Cell(50,20,$desde." a ".$hasta,1,1,'C');
                  }
                  $pdf->Ln(5);
                  $pdf->Cell(140,3,'No COMPROBANTE: '." ","B",0,'L');
                  $pdf->Cell(50,3,'VALOR ',"B",1,'L');
                  $pdf->Ln(5);
                  $pdf->Cell(140,4,'',"",0,'L');
                  $pdf->Cell(25,4,'Subtotal:',"",0,'R');
                  $pdf->Cell(25,4,number_format($subtotal,2),"",1,'L');
                  $pdf->Cell(140,4,'',"",0,'L');
                  $pdf->Cell(25,4,'Mora:',"",0,'R');
                  $pdf->Cell(25,4,"0.00","",1,'L');
                  $pdf->Cell(140,4,'',"",0,'L');
                  $pdf->Cell(25,4,'Imp. seguridad:',"",0,'R');
                  $pdf->Cell(25,5,number_format($totalImpuesto,2),"",1,'L');
                  $pdf->Cell(140,5,'',"",0,'L');
                  $pdf->Cell(25,5,'Total:',"TBL",0,'R');
                  $pdf->Cell(25,5,(number_format($total,2)),"TBR",1,'L');
                  $pdf->Ln(7);
                  $pdf->Cell(140,5,'',"",0,'L');
                  $pdf->Cell(10,5,'F:',"",0,'R');
                  $pdf->Cell(40,5,"","B",1,'L');
                  $pdf->Cell(140,5,'',"",0,'L');
                  $pdf->SetFont('Arial','B',6);
                  $pdf->Cell(50,5,utf8_decode("CABLEVISIÓN POR SATÉLITE S.A. DE. C.V."),"",1,'R');
                  //$pdf->Ln(7);
                  $pdf->Cell(190,5,utf8_decode("Nota: el presente recibo no tendrá validéz alguna sin su correspondiente firma y sello"),"",1,'C');

              }
              /* close connection */
        	  mysqli_close($mysqli);
        	  $pdf->Output();
        }

  }

  f3();

?>
