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

  $codigo = $_GET['id'];

  function getVelocidadById($idVelocidad)
  {
      try {
          global $mysqli;
          // SQL query para traer nombre de las categorÃ­as
          $query = "SELECT nombreVelocidad FROM tbl_velocidades WHERE idVelocidad=".$idVelocidad;
          // PreparaciÃ³n de sentencia
          $statement = $mysqli->query($query);
          while ($result = $statement->fetch_assoc()) {
    		  $velocidad = $result['nombreVelocidad'];
    	  }
          return $velocidad;

      } catch (Exception $e) {
          print "!Error¡: " . $e->getMessage() . "</br>";
          die();
      }
  }

  function contratoInter(){
	  global $codigo, $mysqli;
	  $query = "SELECT cod_cliente, nombre, direccion, numero_dui, cuota_in, num_registro, telefonos, lugar_exp, nacionalidad, fecha_nacimiento, tipo_comprobante, id_tipo_cliente, lugar_trabajo, tel_trabajo, numero_nit, nombre_conyuge, valor_cuota, tipo_servicio, periodo_contrato_ca, periodo_contrato_int, costo_instalacion_in, mac_modem, serie_modem, id_velocidad, tecnologia, entrega_calidad FROM clientes WHERE cod_cliente = ".$codigo;
	  $resultado = $mysqli->query($query);

	  // SQL query para traer datos del servicio de cable de la tabla clientes
	  $query = "SELECT valorImpuesto FROM tbl_impuestos WHERE siglasImpuesto = 'CESC'";
	  // PreparaciÃ³n de sentencia
	  $statement = $mysqli->query($query);
	  //$statement->execute();
	  while ($result = $statement->fetch_assoc()) {
		  $cesc = floatval($result['valorImpuesto']);
	  }

	  // SQL query para traer datos del servicio de cable de la tabla clientes
	  $query = "SELECT valorImpuesto FROM tbl_impuestos WHERE siglasImpuesto = 'IVA'";
	  // PreparaciÃ³n de sentencia
	  $statement = $mysqli->query($query);
	  //$statement->execute();
	  while ($result = $statement->fetch_assoc()) {
		  $iva = floatval($result['valorImpuesto']);
	  }


	  $pdf = new FPDF();
	  $pdf->AliasNbPages();
	  $pdf->AddPage('P','Letter');
      $pdf->Ln(12);
	  $tecnologia = "";
	  while($row = $resultado->fetch_assoc())
	  {
          if ($row['tipo_comprobante'] == 2) {
              $pdf->Image('../../../images/check.png',31,21, 5, 5);
          }

          if ($row['tecnologia'] == 1) {
              $tecnologia = "DOCSIS";
          }
          elseif ($row['tecnologia'] == 2) {
              $tecnologia = "FTTH";
          }
          elseif ($row['tecnologia'] == 3) {
              $tecnologia = "INALAMBRICO";
          }

    	  $pdf->SetFont('Courier','',10);

		  $pdf->Ln(-4);
          $pdf->Cell(130,6,'',0,0,'L');
    	  $pdf->Cell(80,6,$row['cod_cliente'],0,1,'L');
    	  $pdf->Ln(0);

    	  date_default_timezone_set('America/El_Salvador');

    	  //echo strftime("El aÃ±o es %Y y el mes es %B");
		  putenv("LANG='es_ES.UTF-8'");
	      setlocale(LC_ALL, 'es_ES.UTF-8');
    	  $pdf->SetFont('Courier','',10);
    	  $pdf->Cell(25,6,'',0,0,'L');
          $pdf->Cell(70,6,strtoupper(utf8_decode($row['nombre'])),0,1,'L');
          $pdf->Cell(23,6,'',0,0,'L');
          $pdf->Cell(150,6,'',0,0,'L');
          $pdf->Cell(40,6,strtoupper($row['num_registro']),0,1,'L');

          $pdf->Cell(80,6,'',0,0,'L');
          $pdf->Cell(74,6,$row['numero_dui'],0,0,'L');
          $pdf->Cell(70,6,$row['lugar_exp'],0,1,'L');
          $pdf->Cell(12,6,'',0,0,'L');
          $pdf->Cell(63,3,$row['numero_nit'],0,0,'L');
          $pdf->Cell(84,3,$row['telefonos'],0,0,'L');
          $pdf->Cell(40,6,utf8_decode($row['nacionalidad']),0,1,'L');

          $pdf->Cell(94,6,'',0,0,'L');
          $pdf->Cell(70,6,strtoupper($row['nombre_conyuge']),0,1,'L');
          $pdf->Ln(15);
          $pdf->SetFont('Courier','',7);

          $pdf->Cell(30,6,'',0,0,'L');
          $pdf->MultiCell(150,6,strtoupper(utf8_decode($row['direccion'])),0,'L',0);

          $pdf->Cell(30,6,'',0,0,'L');
          $pdf->MultiCell(150,6,strtoupper(utf8_decode($row['direccion'])),0,'L',0);
          $pdf->SetFont('Courier','',10);
          if (strlen($row['direccion']) <=100){
              $pdf->Ln(19);
          }else{
              $pdf->Ln(7);
          }

          $pdf->Image('../../../images/check.png',56,96, 5, 5);

          if ($row['id_tipo_cliente'] == 0001 || $row['id_tipo_cliente'] == 0002) {
              $pdf->Image('../../../images/check.png',56,101, 5, 5);
          }
          elseif ($row['id_tipo_cliente'] == 0003){
              $pdf->Image('../../../images/check.png',153,101, 5, 5);
          }

          $pdf->Ln(6.5);
          $pdf->Cell(22,6,'',0,0,'L');
          $pdf->Cell(70,6,strtoupper('INTERNET'),0,0,'L');
          if ($row['id_velocidad'] <= '0'){
              $pdf->Cell(68,6,strtoupper("Velocidad no espeficicada"),0,0,'L');
          }else{
              $pdf->Cell(68,6,strtoupper(getVelocidadById($row['id_velocidad'])),0,0,'L');
          }
          $pdf->Cell(70,6,strtoupper($tecnologia),0,1,'L');

          $pdf->Cell(22,6,'',0,0,'L');
          $pdf->Cell(75,6,strtoupper($row['mac_modem']),0,0,'L');
          $pdf->Cell(70,6,strtoupper($row['serie_modem']),0,0,'L');
          $pdf->Cell(70,6,strtoupper($row['entrega_calidad']),0,0,'L');
          $pdf->Ln(3);
          $pdf->Cell(49,6,'',0,0,'L');
          //$pdf->Cell(115,6,utf8_decode($tipoServicio),0,0,'L');


	    $imp = substr((($row['cuota_in']/(1 + floatval($iva)))*$cesc),0,4);
  	    $imp = str_replace(',','.', $imp);
  	    //var_dump($imp);

  	    $cantidad = (doubleval($row['cuota_in']) + doubleval($imp));
        $pdf->Ln(1);
        $pdf->Cell(68,6,'',0,0,'L');
        $pdf->Cell(74,6,$row['periodo_contrato_int']." MESES",0,0,'L');
        $pdf->Cell(20,6,"$".$row['costo_instalacion_in'],0,1,'L');

        $pdf->Cell(60,6,'',0,0,'L');
        $pdf->Cell(78,6,'$'.number_format($cantidad,2),0,0,'L');
        $pdf->Cell(20,6,'INTERNET ILIMITADO',0,1,'L');

	  }
	  /* close connection */
	  mysqli_close($mysqli);
	  $pdf->Output();

  }

  contratoInter();

?>
