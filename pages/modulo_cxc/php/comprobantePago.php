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

        	  global $mysqli, $data;
        	  $query = "SELECT * FROM tbl_abonos WHERE idAbono = ".$id;
        	  $resultado = $mysqli->query($query);
              //var_dump($id);
        	  $pdf = new FPDF();
        	  $pdf->AliasNbPages();
        	  $pdf->AddPage('P','Letter');
        	  //$pdf->Image('../../../images/logo.png',10,10, 26, 24);
              date_default_timezone_set('America/El_Salvador');

              putenv("LANG='es_ES.UTF-8'");
              setlocale(LC_ALL, 'es_ES.UTF-8');

              $pdf->Ln(25);
        	  while($row = $resultado->fetch_assoc())
        	  {

                if ($row["tipoServicio"] == "I") {

                    $pdf->SetFont('Arial','B',10);
                    $pdf->Cell(150,3,/*utf8_decode("Ciudad de Usulután, ").*/utf8_decode(strftime('%A %e de %B de %G',$row["fechaAbonado"])),"B",0,'L');
                    $pdf->Cell(40,3,utf8_decode("Recibo N°: ".$row["numeroRecibo"]),0,1,'L');
                    $pdf->Ln(7);
                    $pdf->Cell(190,3,utf8_decode("Cliente: ".$row["codigoCliente"]."  ".$row["nombre"]),0,1,'L');
                    $pdf->SetFont('Arial','B',10);
                    $pdf->Ln(5);
                    $pdf->Cell(140,20,'CONCEPTO: 1 mes de servicio de INTERNET correspondiente a',1,0,'C');
                    $pdf->Cell(50,20,$row["mesCargo"],1,1,'C');
                    $pdf->Ln(5);
                    $pdf->Cell(140,3,'No COMPROBANTE: '.$row["numeroFactura"],"B",0,'L');
                    $pdf->Cell(50,3,'VALOR ',"B",1,'L');
                    $pdf->Ln(5);
                    $pdf->Cell(140,4,'',"",0,'L');
                    $pdf->Cell(25,4,'Subtotal:',"",0,'R');
                    $pdf->Cell(25,4,$row["cuotaInternet"],"",1,'L');
                    $pdf->Cell(140,4,'',"",0,'L');
                    $pdf->Cell(25,4,'Mora:',"",0,'R');
                    $pdf->Cell(25,4,"0.00","",1,'L');
                    $pdf->Cell(140,4,'',"",0,'L');
                    $pdf->Cell(25,4,'Imp. seguridad:',"",0,'R');
                    $pdf->Cell(25,5,$row["totalImpuesto"],"",1,'L');
                    $pdf->Cell(140,5,'',"",0,'L');
                    $pdf->Cell(25,5,'Total:',"TBL",0,'R');
                    $pdf->Cell(25,5,(number_format($row["cuotaInternet"]+$row["totalImpuesto"],2)),"TBR",1,'L');
                    $pdf->Ln(7);
                    $pdf->Cell(140,5,'',"",0,'L');
                    $pdf->Cell(10,5,'F:',"",0,'R');
                    $pdf->Cell(40,5,"","B",1,'L');
                    $pdf->Cell(140,5,'',"",0,'L');
                    $pdf->SetFont('Arial','B',6);
                    $pdf->Cell(50,5,utf8_decode("CABLEVISIÓN POR SATÉLITE S.A. DE. C.V."),"",1,'R');
                    //$pdf->Ln(7);
                    $pdf->Cell(190,5,utf8_decode("Nota: el presente recibo no tendrá validéz alguna sin su correspondiente firma y sello"),"",1,'C');
                    /*$pdf->MultiCell(190,6,'Direccion: '.utf8_decode($row["direccionInter"]),0,'L',0);
                    $pdf->Ln(3);
                    $pdf->Cell(30,3,'Hora: '.$row["hora"],0,0,'L');
                    $pdf->Cell(50,3,'Telefono: '.$row["telefonos"],0,0,'L');
                    $pdf->Cell(60,3,'Trabajo a realizar: '.utf8_decode($row["actividadInter"]),0,0,'L');
                    $pdf->Cell(70,3,'Tecnico: '.utf8_decode($tecnico),0,1,'L');
                    $pdf->Ln(3);
                    $pdf->Cell(30,3,'SNR: '.$row["snr"],0,0,'L');
                    $pdf->Cell(50,3,'TX: '.$row["tx"],0,0,'L');
                    $pdf->Cell(60,3,'RX: '.$row["rx"],0,0,'L');
                    $pdf->Cell(70,3,'Velocidad: '.$velocidad,0,1,'L');
                    $pdf->Ln(3);
                    $pdf->Cell(40,3,'MAC: '.$row["macModem"],0,0,'L');
                    $pdf->Cell(40,3,'Colilla: '.$row["colilla"],0,0,'L');
                    $pdf->Cell(60,3,'Tecnologia: '.$row["tecnologia"],0,0,'L');
                    $pdf->Cell(60,3,'Marca/Modelo: '.$row["marcaModelo"],0,1,'L');
                    $pdf->Ln(3);
                    $pdf->Cell(190,3,'Coordenadas: '.$row["coordenadas"],0,1,'L');
                    $pdf->Ln(3);

                    $pdf->MultiCell(190,6,'Observaciones: '.utf8_decode($row["observaciones"]),0,'L',0);
                    $pdf->Ln(3);
                    $pdf->SetFont('Arial','B',9);
                    $pdf->Cell(70,6,'Fecha de realizacion: ',1,1,'L');
                    $pdf->Ln(3);
                    $pdf->SetFont('Arial','B',9);
                    $pdf->Cell(60,6,'Cliente: ',1,0,'L');
                    $pdf->Cell(70,6,'Tecnico: ',1,0,'L');
                    $pdf->Cell(65,6,'Autorizacion: ',1,1,'L');

                    $pdf->SetFont('Arial','B',9);
                    $pdf->Cell(95,8,'Creado por: '.utf8_decode($row["creadoPor"]),0,0,'L');
                    $pdf->Cell(95,8,'Tipo de servicio: '.$row["tipoServicio"],0,1,'R');*/

                }elseif($row["tipoServicio"] == "C") {

                    $pdf->SetFont('Arial','B',10);
                    $pdf->Cell(150,3,/*utf8_decode("Ciudad de Usulután, ").*/utf8_decode(strftime('%A %e de %B de %G',$row["fechaAbonado"])),"B",0,'L');
                    $pdf->Cell(40,3,utf8_decode("Recibo N°: ".$row["numeroRecibo"]),0,1,'L');
                    $pdf->Ln(7);
                    $pdf->Cell(190,3,utf8_decode("Cliente: ".$row["codigoCliente"]."  ".$row["nombre"]),0,1,'L');
                    $pdf->SetFont('Arial','B',10);
                    $pdf->Ln(5);
                    $pdf->Cell(140,20,'CONCEPTO: 1 mes de servicio de CABLE TV correspondiente a',1,0,'C');
                    $pdf->Cell(50,20,$row["mesCargo"],1,1,'C');
                    $pdf->Ln(5);
                    $pdf->Cell(140,3,'No COMPROBANTE: '.$row["numeroFactura"],"B",0,'L');
                    $pdf->Cell(50,3,'VALOR ',"B",1,'L');
                    $pdf->Ln(5);
                    $pdf->Cell(140,4,'',"",0,'L');
                    $pdf->Cell(25,4,'Subtotal:',"",0,'R');
                    $pdf->Cell(25,4,$row["cuotaCable"],"",1,'L');
                    $pdf->Cell(140,4,'',"",0,'L');
                    $pdf->Cell(25,4,'Mora:',"",0,'R');
                    $pdf->Cell(25,4,"0.00","",1,'L');
                    $pdf->Cell(140,4,'',"",0,'L');
                    $pdf->Cell(25,4,'Imp. seguridad:',"",0,'R');
                    $pdf->Cell(25,5,$row["totalImpuesto"],"",1,'L');
                    $pdf->Cell(140,5,'',"",0,'L');
                    $pdf->Cell(25,5,'Total:',"TBL",0,'R');
                    $pdf->Cell(25,5,(number_format($row["cuotaCable"]+$row["totalImpuesto"],2)),"TBR",1,'L');
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


        	  }

        	  /* close connection */
        	  mysqli_close($mysqli);
        	  $pdf->Output();

      }
      elseif (isset($_GET['uaid1']) && isset($_GET['uaid2'])) {

          // get passed parameter value, in this case, the record ID
          // isset() is a PHP function used to verify if a value is there or not
          $id=isset($_GET['uaid1']) ? $_GET['uaid1'] : die('ERROR: Record no encontrado.');
          $id2=isset($_GET['uaid2']) ? $_GET['uaid2'] : die('ERROR: Record no encontrado.');


        	  global $mysqli, $data;
        	  $query = "SELECT * FROM tbl_abonos WHERE idAbono = ".$id;
        	  $resultado = $mysqli->query($query);

        	  $pdf = new FPDF();
        	  $pdf->AliasNbPages();
        	  $pdf->AddPage('P','Letter');
        	  //$pdf->Image('../../../images/logo.png',10,10, 26, 24);
              date_default_timezone_set('America/El_Salvador');

              putenv("LANG='es_ES.UTF-8'");
              setlocale(LC_ALL, 'es_ES.UTF-8');

              $pdf->Ln(25);
        	  while($row = $resultado->fetch_assoc())
        	  {

                if ($row["tipoServicio"] == "I") {

                    $query1 = "SELECT numeroFactura, numeroRecibo, cuotaInternet, fechaAbonado, totalImpuesto, mesCargo FROM tbl_abonos WHERE idAbono = ".$id2;
                	  // Preparación de sentencia
                	  $statement1 = $mysqli->query($query1);
                	  //$statement->execute();
                	  while ($result1 = $statement1->fetch_assoc()) {
                		  $nFactura2 = $result1['numeroFactura'];
                        $nRecibo2 = $result1['numeroRecibo'];
                        $cInter2 = $result1['cuotaInternet'];
                        $imp2 = $result1['totalImpuesto'];
                        $mes2 = $result1['mesCargo'];
                	  }

                    $pdf->SetFont('Arial','B',10);
                    $pdf->Cell(150,3,/*utf8_decode("Ciudad de Usulután, ").*/utf8_decode(strftime('%A %e de %B de %G',$row["fechaAbonado"])),"B",0,'L');
                    $pdf->Cell(40,3,utf8_decode("Recibos N°: ".$row["numeroRecibo"]),0,1,'L');
                    $pdf->Ln(7);
                    $pdf->Cell(190,3,"Cliente: ".$row["codigoCliente"]."  ".utf8_decode($row["nombre"]),0,1,'L');
                    $pdf->SetFont('Arial','B',10);
                    $pdf->Ln(5);
                    $pdf->Cell(140,20,'CONCEPTO: 2 meses de servicio de INTERNET correspondientes de',1,0,'C');
                    $pdf->Cell(50,20,$row["mesCargo"]." a ".$mes2,1,1,'C');
                    $pdf->Ln(5);
                    $pdf->Cell(140,3,'No COMPROBANTE: '.$row["numeroFactura"].", ".$nFactura2,"B",0,'L');
                    $pdf->Cell(50,3,'VALOR ',"B",1,'L');
                    $pdf->Ln(5);
                    $pdf->Cell(140,4,'',"",0,'L');
                    $pdf->Cell(25,4,'Subtotal:',"",0,'R');
                    $pdf->Cell(25,4,number_format($row["cuotaInternet"]+$cInter2,2),"",1,'L');
                    $pdf->Cell(140,4,'',"",0,'L');
                    $pdf->Cell(25,4,'Mora:',"",0,'R');
                    $pdf->Cell(25,4,"0.00","",1,'L');
                    $pdf->Cell(140,4,'',"",0,'L');
                    $pdf->Cell(25,4,'Imp. seguridad:',"",0,'R');
                    $pdf->Cell(25,5,number_format($row["totalImpuesto"]+$imp2,2),"",1,'L');
                    $pdf->Cell(140,5,'',"",0,'L');
                    $pdf->Cell(25,5,'Total:',"TBL",0,'R');
                    $pdf->Cell(25,5,(number_format($row["cuotaInternet"]+$row["totalImpuesto"]+$cInter2+$imp2,2)),"TBR",1,'L');
                    $pdf->Ln(7);
                    $pdf->Cell(140,5,'',"",0,'L');
                    $pdf->Cell(10,5,'F:',"",0,'R');
                    $pdf->Cell(40,5,"","B",1,'L');
                    $pdf->Cell(140,5,'',"",0,'L');
                    $pdf->SetFont('Arial','B',6);
                    $pdf->Cell(50,5,utf8_decode("CABLEVISIÓN POR SATÉLITE S.A. DE. C.V."),"",1,'R');
                    //$pdf->Ln(7);
                    $pdf->Cell(190,5,utf8_decode("Nota: el presente recibo no tendrá validéz alguna sin su correspondiente firma y sello"),"",1,'C');


                }elseif($row["tipoServicio"] == "C") {

                    $query1 = "SELECT numeroFactura, numeroRecibo, cuotaCable, fechaAbonado, totalImpuesto, mesCargo FROM tbl_abonos WHERE idAbono = ".$id2;
                	  // Preparación de sentencia
                	  $statement1 = $mysqli->query($query1);
                	  //$statement->execute();
                	  while ($result1 = $statement1->fetch_assoc()) {
                		  $nFactura2 = $result1['numeroFactura'];
                        $nRecibo2 = $result1['numeroRecibo'];
                        $cInter2 = $result1['cuotaCable'];
                        $imp2 = $result1['totalImpuesto'];
                        $mes2 = $result1['mesCargo'];
                	  }

                    $pdf->SetFont('Arial','B',10);
                    $pdf->Cell(150,3,/*utf8_decode("Ciudad de Usulután, ").*/utf8_decode(strftime('%A %e de %B de %G',$row["fechaAbonado"])),"B",0,'L');
                    $pdf->Cell(40,3,utf8_decode("Recibos N°: ".$row["numeroRecibo"]),0,1,'L');
                    $pdf->Ln(7);
                    $pdf->Cell(190,3,"Cliente: ".$row["codigoCliente"]."  ".utf8_decode($row["nombre"]),0,1,'L');
                    $pdf->SetFont('Arial','B',10);
                    $pdf->Ln(5);
                    $pdf->Cell(140,20,'CONCEPTO: 2 meses de servicio de CABLE correspondientes de',1,0,'C');
                    $pdf->Cell(50,20,$row["mesCargo"]." a ".$mes2,1,1,'C');
                    $pdf->Ln(5);
                    $pdf->Cell(140,3,'No COMPROBANTE: '.$row["numeroFactura"].", ".$nFactura2,"B",0,'L');
                    $pdf->Cell(50,3,'VALOR ',"B",1,'L');
                    $pdf->Ln(5);
                    $pdf->Cell(140,4,'',"",0,'L');
                    $pdf->Cell(25,4,'Subtotal:',"",0,'R');
                    $pdf->Cell(25,4,number_format($row["cuotaCable"]+$cInter2,2),"",1,'L');
                    $pdf->Cell(140,4,'',"",0,'L');
                    $pdf->Cell(25,4,'Mora:',"",0,'R');
                    $pdf->Cell(25,4,"0.00","",1,'L');
                    $pdf->Cell(140,4,'',"",0,'L');
                    $pdf->Cell(25,4,'Imp. seguridad:',"",0,'R');
                    $pdf->Cell(25,5,number_format($row["totalImpuesto"]+$imp2,2),"",1,'L');
                    $pdf->Cell(140,5,'',"",0,'L');
                    $pdf->Cell(25,5,'Total:',"TBL",0,'R');
                    $pdf->Cell(25,5,(number_format($row["cuotaCable"]+$row["totalImpuesto"]+$cInter2+$imp2,2)),"TBR",1,'L');
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


        	  }

        	  /* close connection */
        	  mysqli_close($mysqli);
        	  $pdf->Output();

      }
  }

  f3();

?>
