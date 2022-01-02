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

  if (isset($_GET['nOrden'])) {

      // get passed parameter value, in this case, the record ID
      // isset() is a PHP function used to verify if a value is there or not
      $id=isset($_GET['nOrden']) ? $_GET['nOrden'] : die('ERROR: Record no encontrado.');
  }

  function f3(){


	  global $id, $mysqli, $data;
	  $query = "SELECT * FROM tbl_ordenes_trabajo WHERE idOrdenTrabajo = ".$id;
	  $resultado = $mysqli->query($query);

	  $pdf = new FPDF();
	  $pdf->AliasNbPages();
	  $pdf->AddPage('P','Letter');
	  //$pdf->Image('../../../images/logo.png',10,10, 26, 24);
      date_default_timezone_set('America/El_Salvador');

      putenv("LANG='es_ES.UTF-8'");
      setlocale(LC_ALL, 'es_ES.UTF-8');
            $pdf->SetFont('Arial','B',12);
            $pdf->Image('../../../images/logo.png',10,5, 20, 18);
            $pdf->Ln(1);
            $pdf->Cell(190,3,utf8_decode("CABLESAT EL SALVADOR"),0,1,'C');
            $pdf->Ln(1);
            $pdf->SetFont('Arial','B',8);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(95,3,utf8_decode("OFICINA CENTRAL"),0,0,'C');
             $pdf->Cell(95,3,utf8_decode("AGENCIA SAN MIGUEL"),0,1,'C');
             $pdf->SetTextColor(0,0,0);
             $pdf->SetFont('Arial','',8);
            $pdf->Cell(95,3,utf8_decode("2a. Calle Pte. No.29, Barrio La Merced"),0,0,'C');
            $pdf->Cell(95,3,utf8_decode("10a Av. Norte, Col. Esmeralda #1, #810,"),0,1,'C');
            $pdf->Cell(95,3,utf8_decode("Usulutan. tels.: 2633-8400 WhatsApp : 7841-7270"),0,0,'C');
            $pdf->Cell(95,3,utf8_decode("San Miguel, San Miguel. tels.: 2633-8450 WhatsApp : 7841-7270"),0,1,'C');
            
            $pdf->Cell(190,3,utf8_decode(""),0,1,'C');
      $pdf->Ln(0);
	  while($row = $resultado->fetch_assoc())
	  {
          //$codigoCliente = "nada";


        if ($row["tipoServicio"] == "I") {
            // SQL query para traer datos del servicio de cable de la tabla clientes
      	  $query1 = "SELECT nombreTecnico FROM tbl_tecnicos_cxc WHERE idTecnico = ".$row['idTecnico'];
      	  // Preparación de sentencia
      	  $statement1 = $mysqli->query($query1);
      	  //$statement->execute();
      	  while ($result1 = $statement1->fetch_assoc()) {
      		  $tecnico = $result1['nombreTecnico'];
      	  }
          
          // SQL query para traer datos del servicio de cable de la tabla clientes
    	  $query2 = "SELECT nombreVelocidad FROM tbl_velocidades WHERE idVelocidad= ".$row['velocidad'];
    	  // Preparación de sentencia
    	  $statement2 = $mysqli->query($query2);
    	  //$statement->execute();
    	  while ($result2 = $statement2->fetch_assoc()) {
    		  $velocidad = $result2['nombreVelocidad'];
    	  }

          if ($row["codigoCliente"] === "00000") {
              $codigoCliente = "SC";
          }else {
              $codigoCliente = $row["codigoCliente"];
          }

          if ($row["diaCobro"] === "0") {
              $diaCobro = "";
          }else {
              $diaCobro = $row["diaCobro"];
          }

            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(190,6,'ORDEN DE TRABAJO',0,1,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(190,1,$row["nodo"],0,1,'C');
            ///////////////////
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(170,6,'Dia de cobro: '.$diaCobro,0,0,'L');
            $pdf->SetTextColor(194,8,8);
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(20,6,utf8_decode('N° ').$row["idOrdenTrabajo"],0,1,'C');
            $pdf->SetTextColor(0,0,0);
            ///////////////////
            $pdf->Ln(1);
            
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(12,3,'Fecha: ',0,0,'L');
            $pdf->SetFont('Arial','U',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(30,3,$row["fechaOrdenTrabajo"],0,0,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(28,3,'Codigo de cliente: ',0,0,'L');
            $pdf->SetFont('Arial','U',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(15,3,$codigoCliente,0,0,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(15,3,'Nombre: ',0,0,'L');
            $pdf->SetFont('Arial','U',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(105,3,utf8_decode($row["nombreCliente"]),0,1,'L');
            $pdf->Ln(3);
            ///////////////////
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(17,6,'Direccion: ',0,0,'L');
            $pdf->SetFont('Arial','U',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->MultiCell(185,6,utf8_decode($row["direccionInter"]),0,'L',0);
            $pdf->Ln(3);
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(10,3,'Hora: ',0,0,'L');
            $pdf->SetFont('Arial','U',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(20,3,$row["hora"],0,0,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(16,3,'Telefono: ',0,0,'L');
            $pdf->SetFont('Arial','U',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(34,3,$row["telefonos"],0,0,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(28,3,'Trabajo a realizar: ',0,0,'L');
            $pdf->SetFont('Arial','U',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(44,3,utf8_decode($row["actividadInter"]),0,0,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(15,3,'Tecnico: ',0,0,'L');
            $pdf->SetFont('Arial','U',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(57,3,utf8_decode($tecnico),0,1,'L');
            ///////////////////
            $pdf->Ln(3);
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(8,3,'SNR: ',0,0,'L');
            $pdf->SetFont('Arial','U',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(32,3,$row["snr"],0,0,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(7,3,'TX: ',0,0,'L');
            $pdf->SetFont('Arial','U',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(33,3,$row["tx"],0,0,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(6,3,'RX: ',0,0,'L');
            $pdf->SetFont('Arial','U',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(66,3,$row["rx"],0,0,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(17,3,'Velocidad: ',0,0,'L');
            $pdf->SetFont('Arial','U',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(55,3,$velocidad,0,1,'L');
            ///////////////////
            $pdf->Ln(3);
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(10,3,'MAC: ',0,0,'L');
            $pdf->SetFont('Arial','U',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(30,3,$row["macModem"],0,0,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(12,3,'Colilla: ',0,0,'L');
            $pdf->SetFont('Arial','U',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(28,3,$row["colilla"],0,0,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(19,3,'Tecnologia: ',0,0,'L');
            $pdf->SetFont('Arial','U',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(53,3,$row["tecnologia"],0,0,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(24,3,'Marca/Modelo: ',0,0,'L');
            $pdf->SetFont('Arial','U',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(25,3,$row["marcaModelo"],0,1,'L');
            $pdf->Ln(3);
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(25,3,'Coordenadas: ',0,0,'L');
            $pdf->SetFont('Arial','U',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(55,3,$row["coordenadas"],0,0,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(15,3,'WAN IP: ',0,0,'L');
            $pdf->SetFont('Arial','U',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(80,3,$row["fechaProgramacion"],0,1,'L');
            ///////////////////
            $pdf->Ln(3);
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(23,6,'Observaciones: ',0,1,'L');
            $pdf->SetFont('Arial','U',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->MultiCell(200,6,utf8_decode($row["observaciones"]),0,'L',0);
            $pdf->Ln(3);
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(70,6,'Fecha de realizacion: ',1,1,'L');
            ///////////////////
            $pdf->Ln(3);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(60,6,'Cliente: ',1,0,'L');
            $pdf->Cell(70,6,'Tecnico: ',1,0,'L');
            $pdf->Cell(65,6,'Autorizacion: ',1,1,'L');

            $pdf->SetFont('Arial','',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(95,8,'Creado por: '.utf8_decode($row["creadoPor"]),0,0,'L');
            $pdf->Cell(95,8,'Tipo de servicio: '.$row["tipoServicio"],0,1,'R');
            $pdf->Cell(200,8,'- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -',0,1,'C');

        }elseif($row["tipoServicio"] == "C") {
            // SQL query para traer datos del servicio de cable de la tabla clientes
      	  $query1 = "SELECT nombreTecnico FROM tbl_tecnicos_cxc WHERE idTecnico = ".$row['idTecnico'];
      	  // Preparación de sentencia
      	  $statement1 = $mysqli->query($query1);
      	  //$statement->execute();
      	  while ($result1 = $statement1->fetch_assoc()) {
      		  $tecnico = $result1['nombreTecnico'];
      	  }
          if ($row["codigoCliente"] === "00000") {
              $codigoCliente = "SC";
          }else {
              $codigoCliente = $row["codigoCliente"];
          }

          if ($row["diaCobro"] == "0") {
              $diaCobro = "";
          }else {
              $diaCobro = $row["diaCobro"];
          }
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(190,6,'ORDEN DE TRABAJO',0,1,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(190,1,$row["nodo"],0,1,'C');
            ///////////////////
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(170,6,'Dia de cobro: '.$diaCobro,0,0,'L');
            $pdf->SetTextColor(194,8,8);
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(20,6,utf8_decode('N° ').$row["idOrdenTrabajo"],0,1,'C');
            $pdf->SetTextColor(0,0,0);
            ///////////////////
            $pdf->Ln(1);
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(12,3,'Fecha: ',0,0,'L');
            $pdf->SetFont('Arial','U',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(30,3,$row["fechaOrdenTrabajo"],0,0,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(28,3,'Codigo de cliente: ',0,0,'L');
            $pdf->SetFont('Arial','U',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(15,3,$codigoCliente,0,0,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(15,3,'Nombre: ',0,0,'L');
            $pdf->SetFont('Arial','U',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(105,3,utf8_decode($row["nombreCliente"]),0,1,'L');
            $pdf->Ln(3);
            //$pdf->Cell(190,3,'Direccion: '.$row["direccionCable"],0,1,'L');
             $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(17,6,'Direccion: ',0,0,'L');
            $pdf->SetFont('Arial','U',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->MultiCell(185,6,utf8_decode($row["direccionCable"]),0,'L',0);
            $pdf->Ln(3);
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(10,3,'Hora: ',0,0,'L');
            $pdf->SetFont('Arial','U',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(20,3,$row["hora"],0,0,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(16,3,'Telefono: ',0,0,'L');
            $pdf->SetFont('Arial','U',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(34,3,$row["telefonos"],0,0,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(28,3,'Trabajo a realizar: ',0,0,'L');
            $pdf->SetFont('Arial','U',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(44,3,utf8_decode($row["actividadCable"]),0,0,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(15,3,'Tecnico: ',0,0,'L');
            $pdf->SetFont('Arial','U',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(57,3,utf8_decode($tecnico),0,1,'L');
            $pdf->Ln(3);
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(10,3,'MACTV: ',0,0,'L');
            $pdf->SetFont('Arial','U',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(30,3,$row["mactv"],0,0,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(12,3,'Colilla: ',0,0,'L');
            $pdf->SetFont('Arial','U',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(28,3,$row["colilla"],0,0,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(25,3,'Coordenadas: ',0,0,'L');
            $pdf->SetFont('Arial','U',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(55,3,$row["coordenadas"],0,0,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(19,3,'Tecnologia: ',0,0,'L');
            $pdf->SetFont('Arial','U',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(53,3,$row["tecnologia"],0,0,'L');
            $pdf->Ln(3);
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(23,6,'Observaciones: ',0,1,'L');
            $pdf->SetFont('Arial','U',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->MultiCell(200,6,utf8_decode($row["observaciones"]),0,'L',0);
            $pdf->Ln(3);
            $pdf->SetFont('Arial','B',9);
            $pdf->SetTextColor(194,8,8);
            $pdf->Cell(70,6,'Fecha de realizacion: ',1,1,'L');
            ///////////////////
            $pdf->Ln(3);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(60,6,'Cliente: ',1,0,'L');
            $pdf->Cell(70,6,'Tecnico: ',1,0,'L');
            $pdf->Cell(65,6,'Autorizacion: ',1,1,'L');
            $pdf->SetFont('Arial','',9);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(95,8,'Creado por: '.utf8_decode($row["creadoPor"]),0,0,'L');
            $pdf->Cell(95,8,'Tipo de servicio: '.$row["tipoServicio"],0,1,'R');
            $pdf->Cell(200,8,'- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -',0,1,'C');
        }


	  }

	  /* close connection */
	  mysqli_close($mysqli);
	  $pdf->Output();

  }

  f3();

?>
