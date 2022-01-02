<<<<<<< HEAD
<?php
require '../../../pdfs/fpdf.php';
require_once("../../../php/config.php");
require '../../../numLe/src/NumerosEnLetras.php';
if (!isset($_SESSION)) {
    session_start();
}
$host = DB_HOST;
$user = DB_USER;
$password = DB_PASSWORD;
$database = $_SESSION['db'];
$mysqli = new mysqli($host, $user, $password, $database);
$inicio = $_POST['inicio'];
$fin = $_POST['fin'];

$query = "SELECT * FROM tbl_ordenes_suspension WHERE idOrdenSuspension BETWEEN $inicio AND $fin";
$resultado = $mysqli->query($query);
$pdf = new FPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P', 'Letter');
date_default_timezone_set('America/El_Salvador');
putenv("LANG='es_ES.UTF-8'");
setlocale(LC_ALL, 'es_ES.UTF-8');
$pdf->Ln(13);


while ($datos = $resultado->fetch_array()) {
    if ($datos["tipoServicio"] == "I") {
        // SQL query para traer datos del servicio de cable de la tabla clientes
        $query1 = "SELECT nombreTecnico FROM tbl_tecnicos_cxc WHERE idTecnico = ".$datos['idTecnico'];
        // Preparación de sentencia
        $statement1 = $mysqli->query($query1);
        //$statement->execute();
        while ($result1 = $statement1->fetch_assoc()) {
            $tecnico = $result1['nombreTecnico'];
        }

      // SQL query para traer datos del servicio de cable de la tabla clientes
      $query2 = "SELECT nombreVelocidad FROM tbl_velocidades WHERE idVelocidad= ".$datos['velocidad'];
      // Preparación de sentencia
      $statement2 = $mysqli->query($query2);
      //$statement->execute();
      while ($result2 = $statement2->fetch_assoc()) {
          $velocidad = $result2['nombreVelocidad'];
      }

      // SQL query para traer datos del servicio de cable de la tabla clientes
      $query3 = "SELECT nombreActividad FROM tbl_actividades_susp WHERE idActividadSusp= ".$datos["actividadInter"];
      // Preparación de sentencia
      $statement3 = $mysqli->query($query3);
      //$statement->execute();
      while ($result3 = $statement3->fetch_assoc()) {
          $actividadInter = $result3['nombreActividad'];
      }
        // SQL query para traer datos del servicio de cable de la tabla clientes
        $query3 = "SELECT dire_telefonia FROM clientes WHERE cod_cliente= ".$datos["codigoCliente"];
        // Preparación de sentencia
        $statement3 = $mysqli->query($query3);
        //$statement->execute();
        while ($result3 = $statement3->fetch_assoc()) {
            $nodo = $result3['dire_telefonia'];
        }
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(190,6,'SUSPENSION DE SERVICIO',0,1,'C');
        $pdf->Cell(190,6,$nodo,0,1,'C');
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(175,6,'Dia de cobro: '.$datos["diaCobro"],0,0,'L');
        $pdf->Cell(20,6,utf8_decode('N° ').$datos["idOrdenSuspension"],1,1,'C');
        $pdf->Ln(8);
        $pdf->SetFont('Arial','UB',9);
        $pdf->Cell(40,3,'Fecha: '.$datos["fechaOrden"],0,0,'L');
        $pdf->Cell(50,3,'Codigo de cliente: '.$datos["codigoCliente"],0,0,'L');
        $pdf->Cell(120,3,'Nombre: '.utf8_decode($datos["nombreCliente"]),0,1,'L');
        $pdf->Ln(3);
        //$pdf->Cell(190,3,'Direccion: '.$datos["direccionCable"],0,1,'L');
        $pdf->MultiCell(190,6,'Direccion: '.utf8_decode($datos["direccion"]),0,'L',0);
        $pdf->Cell(70,3,'Coordenadas: '.$datos["coordenadas"],0,0,'L');
        $pdf->Cell(70,3,'Tecnico: '.$tecnico,0,1,'L');
        $pdf->Ln(3);
        $pdf->Cell(40,3,'MAC: '.$datos["macModem"],0,0,'L');
        $pdf->Cell(40,3,'Colilla: '.$datos["colilla"],0,1,'L');
        $pdf->Ln(3);
        $pdf->Cell(190,3,'Motivo de la suspension: '.$actividadInter,0,1,'L');
        $pdf->Ln(3);
        $pdf->SetFont('Arial','B',9);
        if ($datos["ordenaSuspension"] == "administracion") {
            $pdf->Cell(35,3,'Ordena suspension: ',0,0,'L');
            $pdf->Cell(25,3,'Administracion',0,0,'L');
            $pdf->Cell(20,3,'X',1,0,'L');
            $pdf->Cell(20,3,'Oficina',0,0,'R');
            $pdf->Cell(20,3,'',1,0,'L');
            $pdf->Cell(20,3,'El cliente',0,0,'R');
            $pdf->Cell(20,3,'',1,1,'L');
        }elseif ($datos["ordenaSuspension"] == "oficina") {
            $pdf->Cell(35,3,'Ordena suspension: ',0,0,'L');
            $pdf->Cell(25,3,'Administracion',0,0,'L');
            $pdf->Cell(20,3,'',1,0,'L');
            $pdf->Cell(20,3,'Oficina',0,0,'R');
            $pdf->Cell(20,3,'X',1,0,'C');
            $pdf->Cell(20,3,'El cliente',0,0,'R');
            $pdf->Cell(20,3,'',1,1,'L');
        }elseif ($datos["ordenaSuspension"] == "cliente") {
            $pdf->Cell(35,3,'Ordena suspension: ',0,0,'L');
            $pdf->Cell(25,3,'Administracion',0,0,'L');
            $pdf->Cell(20,3,'',1,0,'L');
            $pdf->Cell(20,3,'Oficina',0,0,'R');
            $pdf->Cell(20,3,'',1,0,'C');
            $pdf->Cell(20,3,'El cliente',0,0,'R');
            $pdf->Cell(20,3,'X',1,1,'L');
        }
        $pdf->Ln(3);
        $pdf->MultiCell(190,6,'Observaciones: '.utf8_decode($datos["observaciones"]),0,'L',0);
        $pdf->Ln(3);
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(70,6,'Fecha de realizacion: ',1,1,'L');
        $pdf->Ln(3);
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(60,6,'Cliente: ',1,0,'L');
        $pdf->Cell(70,6,'Tecnico: ',1,0,'L');
        $pdf->Cell(65,6,'Autorizacion: ',1,1,'L');

        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(95,8,'Creado por: '.utf8_decode($datos["creadoPor"]),0,0,'L');
        $pdf->Cell(95,8,'Tipo de servicio: '.$datos["tipoServicio"],0,1,'R');

    }elseif($datos["tipoServicio"] == "C") {
        // SQL query para traer datos del servicio de cable de la tabla clientes
        $query1 = "SELECT nombreTecnico FROM tbl_tecnicos_cxc WHERE idTecnico = ".$datos['idTecnico'];
        // Preparación de sentencia
        $statement1 = $mysqli->query($query1);
        //$statement->execute();
        while ($result1 = $statement1->fetch_assoc()) {
            $tecnico = $result1['nombreTecnico'];
        }

      // SQL query para traer datos del servicio de cable de la tabla clientes
      $query3 = "SELECT nombreActividad FROM tbl_actividades_susp WHERE idActividadSusp= ".$datos["actividadCable"];
      // Preparación de sentencia
      $statement3 = $mysqli->query($query3);
      //$statement->execute();
      while ($result3 = $statement3->fetch_assoc()) {
          $actividadCable = $result3['nombreActividad'];
      }
        // SQL query para traer datos del servicio de cable de la tabla clientes
        $query3 = "SELECT dire_telefonia FROM clientes WHERE cod_cliente= ".$datos["codigoCliente"];
        // Preparación de sentencia
        $statement3 = $mysqli->query($query3);
        //$statement->execute();
        while ($result3 = $statement3->fetch_assoc()) {
            $nodo = $result3['dire_telefonia'];
        }
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(190,6,'SUSPENSION DE SERVICIO',0,1,'C');
        $pdf->Cell(190,6,$nodo,0,1,'C');
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(175,6,'Dia de cobro: '.$datos["diaCobro"],0,0,'L');
        $pdf->Cell(20,6,utf8_decode('N° ').$datos["idOrdenSuspension"],1,1,'C');
        $pdf->Ln(8);
        $pdf->SetFont('Arial','UB',9);
        $pdf->Cell(40,3,'Fecha: '.$datos["fechaOrden"],0,0,'L');
        $pdf->Cell(50,3,'Codigo de cliente: '.$datos["codigoCliente"],0,0,'L');
        $pdf->Cell(120,3,'Nombre: '.utf8_decode($datos["nombreCliente"]),0,1,'L');
        $pdf->Ln(3);
        //$pdf->Cell(190,3,'Direccion: '.$datos["direccionCable"],0,1,'L');
        $pdf->MultiCell(190,6,'Direccion: '.utf8_decode($datos["direccion"]),0,'L',0);
        $pdf->Ln(3);
        $pdf->Cell(70,3,'Coordenadas: '.$datos["coordenadas"],0,0,'L');
        $pdf->Cell(70,3,'Tecnico: '.$tecnico,0,1,'L');
        $pdf->Ln(5);
        $pdf->Cell(50,3,'MACTV: '.$datos["mactv"],0,0,'L');
        $pdf->Cell(50,3,'Colilla: '.$datos["colilla"],0,1,'L');

        $pdf->Ln(3);
        $pdf->Cell(190,3,'Motivo de la suspension: '.$actividadCable,0,1,'L');
        $pdf->Ln(3);
        $pdf->SetFont('Arial','B',9);
        if ($datos["ordenaSuspension"] == "administracion") {
            $pdf->Cell(35,3,'Ordena suspension: ',0,0,'L');
            $pdf->Cell(25,3,'Administracion',0,0,'L');
            $pdf->Cell(20,3,'X',1,0,'L');
            $pdf->Cell(20,3,'Oficina',0,0,'R');
            $pdf->Cell(20,3,'',1,0,'L');
            $pdf->Cell(20,3,'El cliente',0,0,'R');
            $pdf->Cell(20,3,'',1,1,'L');
        }elseif ($datos["ordenaSuspension"] == "oficina") {
            $pdf->Cell(35,3,'Ordena suspension: ',0,0,'L');
            $pdf->Cell(25,3,'Administracion',0,0,'L');
            $pdf->Cell(20,3,'',1,0,'L');
            $pdf->Cell(20,3,'Oficina',0,0,'R');
            $pdf->Cell(20,3,'X',1,0,'C');
            $pdf->Cell(20,3,'El cliente',0,0,'R');
            $pdf->Cell(20,3,'',1,1,'L');
        }elseif ($datos["ordenaSuspension"] == "cliente") {
            $pdf->Cell(35,3,'Ordena suspension: ',0,0,'L');
            $pdf->Cell(25,3,'Administracion',0,0,'L');
            $pdf->Cell(20,3,'',1,0,'L');
            $pdf->Cell(20,3,'Oficina',0,0,'R');
            $pdf->Cell(20,3,'',1,0,'C');
            $pdf->Cell(20,3,'El cliente',0,0,'R');
            $pdf->Cell(20,3,'X',1,1,'L');
        }
        $pdf->Ln(3);
        $pdf->SetFont('Arial','Bu',9);
        $pdf->MultiCell(190,6,'Observaciones: '.utf8_decode($datos["observaciones"]),0,'L',0);
        $pdf->Ln(3);
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(70,6,'Fecha de realizacion: ',1,1,'L');
        $pdf->Ln(3);
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(60,6,'Cliente: ',1,0,'L');
        $pdf->Cell(70,6,'Tecnico: ',1,0,'L');
        $pdf->Cell(65,6,'Autorizacion: ',1,1,'L');

        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(95,8,'Creado por: '.$datos["creadoPor"],0,0,'L');
        $pdf->Cell(95,8,'Tipo de servicio: '.$datos["tipoServicio"],0,1,'R');
    }
    $pdf->AddPage('P','Letter');
}


mysqli_close($mysqli);
$pdf->Output();
=======
<?php
require '../../../pdfs/fpdf.php';
require_once("../../../php/config.php");
require '../../../numLe/src/NumerosEnLetras.php';
if (!isset($_SESSION)) {
    session_start();
}
$host = DB_HOST;
$user = DB_USER;
$password = DB_PASSWORD;
$database = $_SESSION['db'];
$mysqli = new mysqli($host, $user, $password, $database);
$inicio = $_POST['inicio'];
$fin = $_POST['fin'];

$query = "SELECT * FROM tbl_ordenes_suspension WHERE idOrdenSuspension BETWEEN $inicio AND $fin";
$resultado = $mysqli->query($query);
$pdf = new FPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P', 'Letter');
date_default_timezone_set('America/El_Salvador');
putenv("LANG='es_ES.UTF-8'");
setlocale(LC_ALL, 'es_ES.UTF-8');
$pdf->Ln(13);


while ($datos = $resultado->fetch_array()) {
    if ($datos["tipoServicio"] == "I") {
        // SQL query para traer datos del servicio de cable de la tabla clientes
        $query1 = "SELECT nombreTecnico FROM tbl_tecnicos_cxc WHERE idTecnico = ".$datos['idTecnico'];
        // Preparación de sentencia
        $statement1 = $mysqli->query($query1);
        //$statement->execute();
        while ($result1 = $statement1->fetch_assoc()) {
            $tecnico = $result1['nombreTecnico'];
        }

      // SQL query para traer datos del servicio de cable de la tabla clientes
      $query2 = "SELECT nombreVelocidad FROM tbl_velocidades WHERE idVelocidad= ".$datos['velocidad'];
      // Preparación de sentencia
      $statement2 = $mysqli->query($query2);
      //$statement->execute();
      while ($result2 = $statement2->fetch_assoc()) {
          $velocidad = $result2['nombreVelocidad'];
      }

      // SQL query para traer datos del servicio de cable de la tabla clientes
      $query3 = "SELECT nombreActividad FROM tbl_actividades_susp WHERE idActividadSusp= ".$datos["actividadInter"];
      // Preparación de sentencia
      $statement3 = $mysqli->query($query3);
      //$statement->execute();
      while ($result3 = $statement3->fetch_assoc()) {
          $actividadInter = $result3['nombreActividad'];
      }
        // SQL query para traer datos del servicio de cable de la tabla clientes
        $query3 = "SELECT dire_telefonia FROM clientes WHERE cod_cliente= ".$datos["codigoCliente"];
        // Preparación de sentencia
        $statement3 = $mysqli->query($query3);
        //$statement->execute();
        while ($result3 = $statement3->fetch_assoc()) {
            $nodo = $result3['dire_telefonia'];
        }
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(190,6,'SUSPENSION DE SERVICIO',0,1,'C');
        $pdf->Cell(190,6,$nodo,0,1,'C');
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(175,6,'Dia de cobro: '.$datos["diaCobro"],0,0,'L');
        $pdf->Cell(20,6,utf8_decode('N° ').$datos["idOrdenSuspension"],1,1,'C');
        $pdf->Ln(8);
        $pdf->SetFont('Arial','UB',9);
        $pdf->Cell(40,3,'Fecha: '.$datos["fechaOrden"],0,0,'L');
        $pdf->Cell(50,3,'Codigo de cliente: '.$datos["codigoCliente"],0,0,'L');
        $pdf->Cell(120,3,'Nombre: '.utf8_decode($datos["nombreCliente"]),0,1,'L');
        $pdf->Ln(3);
        //$pdf->Cell(190,3,'Direccion: '.$datos["direccionCable"],0,1,'L');
        $pdf->MultiCell(190,6,'Direccion: '.utf8_decode($datos["direccion"]),0,'L',0);
        $pdf->Cell(70,3,'Coordenadas: '.$datos["coordenadas"],0,0,'L');
        $pdf->Cell(70,3,'Tecnico: '.$tecnico,0,1,'L');
        $pdf->Ln(3);

        $pdf->Cell(40,3,'MAC: '.$datos["macModem"],0,0,'L');
        $pdf->Cell(40,3,'Colilla: '.$datos["colilla"],0,1,'L');
        $pdf->Ln(3);
        $pdf->Cell(190,3,'Motivo de la suspension: '.$actividadInter,0,1,'L');
        $pdf->Ln(3);
        $pdf->SetFont('Arial','B',9);
        if ($datos["ordenaSuspension"] == "administracion") {
            $pdf->Cell(35,3,'Ordena suspension: ',0,0,'L');
            $pdf->Cell(25,3,'Administracion',0,0,'L');
            $pdf->Cell(20,3,'X',1,0,'L');
            $pdf->Cell(20,3,'Oficina',0,0,'R');
            $pdf->Cell(20,3,'',1,0,'L');
            $pdf->Cell(20,3,'El cliente',0,0,'R');
            $pdf->Cell(20,3,'',1,1,'L');
        }elseif ($datos["ordenaSuspension"] == "oficina") {
            $pdf->Cell(35,3,'Ordena suspension: ',0,0,'L');
            $pdf->Cell(25,3,'Administracion',0,0,'L');
            $pdf->Cell(20,3,'',1,0,'L');
            $pdf->Cell(20,3,'Oficina',0,0,'R');
            $pdf->Cell(20,3,'X',1,0,'C');
            $pdf->Cell(20,3,'El cliente',0,0,'R');
            $pdf->Cell(20,3,'',1,1,'L');
        }elseif ($datos["ordenaSuspension"] == "cliente") {
            $pdf->Cell(35,3,'Ordena suspension: ',0,0,'L');
            $pdf->Cell(25,3,'Administracion',0,0,'L');
            $pdf->Cell(20,3,'',1,0,'L');
            $pdf->Cell(20,3,'Oficina',0,0,'R');
            $pdf->Cell(20,3,'',1,0,'C');
            $pdf->Cell(20,3,'El cliente',0,0,'R');
            $pdf->Cell(20,3,'X',1,1,'L');
        }
        $pdf->Ln(3);
        $pdf->MultiCell(190,6,'Observaciones: '.utf8_decode($datos["observaciones"]),0,'L',0);
        $pdf->Ln(3);
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(70,6,'Fecha de realizacion: ',1,1,'L');
        $pdf->Ln(3);
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(60,6,'Cliente: ',1,0,'L');
        $pdf->Cell(70,6,'Tecnico: ',1,0,'L');
        $pdf->Cell(65,6,'Autorizacion: ',1,1,'L');

        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(95,8,'Creado por: '.utf8_decode($datos["creadoPor"]),0,0,'L');
        $pdf->Cell(95,8,'Tipo de servicio: '.$datos["tipoServicio"],0,1,'R');

    }elseif($datos["tipoServicio"] == "C") {
        // SQL query para traer datos del servicio de cable de la tabla clientes
        $query1 = "SELECT nombreTecnico FROM tbl_tecnicos_cxc WHERE idTecnico = ".$datos['idTecnico'];
        // Preparación de sentencia
        $statement1 = $mysqli->query($query1);
        //$statement->execute();
        while ($result1 = $statement1->fetch_assoc()) {
            $tecnico = $result1['nombreTecnico'];
        }

      // SQL query para traer datos del servicio de cable de la tabla clientes
      $query3 = "SELECT nombreActividad FROM tbl_actividades_susp WHERE idActividadSusp= ".$datos["actividadCable"];
      // Preparación de sentencia
      $statement3 = $mysqli->query($query3);
      //$statement->execute();
      while ($result3 = $statement3->fetch_assoc()) {
          $actividadCable = $result3['nombreActividad'];
      }
        // SQL query para traer datos del servicio de cable de la tabla clientes
        $query3 = "SELECT dire_telefonia FROM clientes WHERE cod_cliente= ".$datos["codigoCliente"];
        // Preparación de sentencia
        $statement3 = $mysqli->query($query3);
        //$statement->execute();
        while ($result3 = $statement3->fetch_assoc()) {
            $nodo = $result3['dire_telefonia'];
        }
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(190,6,'SUSPENSION DE SERVICIO',0,1,'C');
        $pdf->Cell(190,6,$nodo,0,1,'C');
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(175,6,'Dia de cobro: '.$datos["diaCobro"],0,0,'L');
        $pdf->Cell(20,6,utf8_decode('N° ').$datos["idOrdenSuspension"],1,1,'C');
        $pdf->Ln(8);
        $pdf->SetFont('Arial','UB',9);
        $pdf->Cell(40,3,'Fecha: '.$datos["fechaOrden"],0,0,'L');
        $pdf->Cell(50,3,'Codigo de cliente: '.$datos["codigoCliente"],0,0,'L');
        $pdf->Cell(120,3,'Nombre: '.utf8_decode($datos["nombreCliente"]),0,1,'L');
        $pdf->Ln(3);
        //$pdf->Cell(190,3,'Direccion: '.$datos["direccionCable"],0,1,'L');
        $pdf->MultiCell(190,6,'Direccion: '.utf8_decode($datos["direccion"]),0,'L',0);
        $pdf->Ln(3);
        $pdf->Cell(70,3,'Coordenadas: '.$datos["coordenadas"],0,0,'L');
        $pdf->Cell(70,3,'Tecnico: '.$tecnico,0,1,'L');
        $pdf->Ln(5);
        $pdf->Cell(50,3,'MACTV: '.$datos["mactv"],0,0,'L');
        $pdf->Cell(50,3,'Colilla: '.$datos["colilla"],0,1,'L');

        $pdf->Ln(3);
        $pdf->Cell(190,3,'Motivo de la suspension: '.$actividadCable,0,1,'L');
        $pdf->Ln(3);
        $pdf->SetFont('Arial','B',9);
        if ($datos["ordenaSuspension"] == "administracion") {
            $pdf->Cell(35,3,'Ordena suspension: ',0,0,'L');
            $pdf->Cell(25,3,'Administracion',0,0,'L');
            $pdf->Cell(20,3,'X',1,0,'L');
            $pdf->Cell(20,3,'Oficina',0,0,'R');
            $pdf->Cell(20,3,'',1,0,'L');
            $pdf->Cell(20,3,'El cliente',0,0,'R');
            $pdf->Cell(20,3,'',1,1,'L');
        }elseif ($datos["ordenaSuspension"] == "oficina") {
            $pdf->Cell(35,3,'Ordena suspension: ',0,0,'L');
            $pdf->Cell(25,3,'Administracion',0,0,'L');
            $pdf->Cell(20,3,'',1,0,'L');
            $pdf->Cell(20,3,'Oficina',0,0,'R');
            $pdf->Cell(20,3,'X',1,0,'C');
            $pdf->Cell(20,3,'El cliente',0,0,'R');
            $pdf->Cell(20,3,'',1,1,'L');
        }elseif ($datos["ordenaSuspension"] == "cliente") {
            $pdf->Cell(35,3,'Ordena suspension: ',0,0,'L');
            $pdf->Cell(25,3,'Administracion',0,0,'L');
            $pdf->Cell(20,3,'',1,0,'L');
            $pdf->Cell(20,3,'Oficina',0,0,'R');
            $pdf->Cell(20,3,'',1,0,'C');
            $pdf->Cell(20,3,'El cliente',0,0,'R');
            $pdf->Cell(20,3,'X',1,1,'L');
        }
        $pdf->Ln(3);
        $pdf->SetFont('Arial','Bu',9);
        $pdf->MultiCell(190,6,'Observaciones: '.utf8_decode($datos["observaciones"]),0,'L',0);
        $pdf->Ln(3);
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(70,6,'Fecha de realizacion: ',1,1,'L');
        $pdf->Ln(3);
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(60,6,'Cliente: ',1,0,'L');
        $pdf->Cell(70,6,'Tecnico: ',1,0,'L');
        $pdf->Cell(65,6,'Autorizacion: ',1,1,'L');

        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(95,8,'Creado por: '.$datos["creadoPor"],0,0,'L');
        $pdf->Cell(95,8,'Tipo de servicio: '.$datos["tipoServicio"],0,1,'R');
    }
    $pdf->AddPage('P','Letter');
}


mysqli_close($mysqli);
$pdf->Output();
>>>>>>> 8404f3d80dcbc2494a76c11cd1ac9cae57de7f40
