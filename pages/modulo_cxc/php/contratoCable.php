<?php
	require '../../../pdfs/fpdf.php';
  require_once("../../../php/config.php");
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

  function contratoCable(){
	  global $codigo, $mysqli;
	  $query = "SELECT cod_cliente, nombre, direccion, numero_dui, num_registro, telefonos, lugar_exp, fecha_nacimiento, lugar_trabajo, tel_trabajo, numero_nit, valor_cuota, tipo_servicio, periodo_contrato_ca FROM clientes WHERE cod_cliente = ".$codigo;
	  $resultado = $mysqli->query($query);
/*
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
*/

	  $pdf = new FPDF();
	  $pdf->AliasNbPages();
	  $pdf->AddPage('P','Letter');
	  //$pdf->Image('../../../images/logo.png',10,10, 26, 24);

	  while($row = $resultado->fetch_assoc())
	  {

          //$pdf->Ln(-2);
    	  $pdf->SetFont('Courier','',10);
	  $pdf->Ln(4);
    	  $pdf->Cell(190,6,$row['cod_cliente'],0,1,'R');
    	  $pdf->Ln();

    	  $pdf->Ln(5);

    	  $pdf->SetFont('Courier','B',12);

    	  date_default_timezone_set('America/El_Salvador');

    	  //echo strftime("El aÃ±o es %Y y el mes es %B");
    	  setlocale(LC_ALL,"es_ES");
    	  $pdf->SetFont('Courier','',10);
    	  $pdf->Cell(29,6,'',0,0,'L');
          $pdf->Cell(70,6,strtoupper($row['nombre']),0,1,'L');

          $pdf->Cell(20,6,'',0,0,'L');
          $pdf->Cell(70,6,$row['numero_dui'],0,0,'L');
          $pdf->Cell(75,6,$row['lugar_exp'],0,0,'L');
          $pdf->Cell(30,6,$row['fecha_nacimiento'],0,1,'R');

          $pdf->Cell(40,6,'',0,0,'L');
          $pdf->Cell(65,6,'',0,0,'L');
          $pdf->Cell(62,6,$row['num_registro'],0,0,'L');
          $pdf->Cell(40,6,$row['telefonos'],0,1,'L');

          $pdf->Cell(40,6,'',0,0,'L');
          $pdf->Cell(65,6,$row['lugar_trabajo'],0,0,'L');
          $pdf->Cell(48,6,'',0,0,'L');
          $pdf->Cell(40,6,$row['tel_trabajo'],0,1,'R');
    	  $pdf->Ln(1);
/////////////////////////////////////////////////////////////////////////////////////////
          $pdf->Cell(55,6,'',0,0,'L');
          $pdf->Cell(70,6,strtoupper($row['nombre']),0,1,'L');
          $pdf->Cell(68,6,'',0,0,'L');
          $pdf->MultiCell(130,6,strtoupper($row['direccion']),0,'L',0);

          $pdf->Ln(4);
          if ($row['tipo_servicio'] == 1) {
              $tipoServicio = "CABLE TV";
          }
          elseif ($row['tipo_servicio'] == 2){
              $tipoServicio = "TV DIGITAL";
          }
          elseif ($row['tipo_servicio'] == 3){
              $tipoServicio = "IP TV";
          }else {
              $tipoServicio = "NO ESPECIFICADO";
          }
          $pdf->Cell(49,6,'',0,0,'L');
          $pdf->Cell(115,6,$tipoServicio,0,0,'L');

/*
	    $imp = substr((($row['valor_cuota']/(1 + floatval($iva)))*$cesc),0,4);
  	    $imp = str_replace(',','.', $imp);
*/
  	    //var_dump($imp);

  	    $cantidad = (doubleval($row['valor_cuota']));

        $pdf->Cell(20,6,'$'.number_format($cantidad,2),0,1,'L');
        $pdf->Ln(10);
        $pdf->Cell(53,6,'',0,0,'L');
        $pdf->Cell(115,6,$row['periodo_contrato_ca']." MESES",0,1,'L');

	  }

	  /* close connection */
	  mysqli_close($mysqli);
	  $pdf->Output();

  }

  contratoCable();

?>
