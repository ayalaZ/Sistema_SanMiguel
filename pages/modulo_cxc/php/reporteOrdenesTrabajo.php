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

//$codigo = $_GET['id'];
$desde = $_POST['lDesde'];
$hasta = $_POST['lHasta'];
$codigoCobrador = $_POST['lCobrador'];
$colonia = $_POST['lColonia'];

if ($_POST['lActividad'] == "todas"){
    $actividad = '%';
}else{
    $actividad = '%'.$_POST['lActividad'].'%';
}

$tipoServicio = $_POST['lServicio'];

$tipoReporte = ["tipoReporte"];

if (isset($_POST['soloAnuladas'])){
    $anulada = $_POST['soloAnuladas'];
}else{
    $anulada = 0;
}

if (isset($_POST['soloExentas'])){
    $exenta = $_POST['soloExentas'];
}

if (isset($_POST["filtro"])){
    if ($_POST["filtro"] == "1"){
        $fechaFiltro = 'fechaOrdenTrabajo';
    }else{
        $fechaFiltro = 'fechaTrabajo';
    }
}

if (isset($_POST["ordenar"])){
    if ($_POST["ordenar"] == "1"){
        $ordenarFiltro = 'codigoCliente';
    }elseif($_POST["ordenar"] == "2"){
        $ordenarFiltro = 'idColonia';
    }else{
        $ordenarFiltro = 'numeroFactura';
    }
}

if (isset($_POST["lTipoLista"])){
    if ($_POST["lTipoLista"] == "2"){
        $tipoComprobante = '2';
    }elseif($_POST["lTipoLista"] == "1"){
        $tipoComprobante = '1';
    }else{
        $tipoComprobante = '';
    }
}

/*if (isset($_POST["todosDias"])){
    if ($_POST["todosDias"] == "1"){
        $diaCobroFiltro = '%';
    }
}else{
    $diaCobroFiltro = '%'.$_POST["diaCobro"].'%';
}*/

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

$totalConIvaCable = 0;
$totalConIvaInter = 0;
$totalSoloIvaCable = 0;
$totalSoloIvaInter = 0;
$totalConCescInter = 0;
$totalSoloCescInter = 0;


function abonos()
{
    global $desde, $hasta, $codigoCobrador, $colonia, $tipoServicio, $iva, $cesc, $tipoReporte, $actividad, $mysqli /*$statement1*/ ;
    global $totalSoloIvaCable, $totalSoloIvaInter, $totalConIvaCable, $totalConIvaInter, $totalConCescInter, $totalSoloCescInter, $totalConCescCable, $totalSoloCescCable;
    global $totalSoloCable, $totalCable, $totalImpuestoC, $totalSoloInter, $totalInter, $totalImpuestoI, $anulada, $exenta, $fechaFiltro, $ordenarFiltro, $diaCobroFiltro, $tipoComprobante;

    $pdf = new FPDF();

    $pdf->AddPage('L', 'Letter');
    $pdf->SetFont('Arial', '', 6);
    $pdf->Cell(260, 6, utf8_decode("Página " . str_pad($pdf->pageNo(), 4, "0", STR_PAD_LEFT)), 0, 1, 'R');
    $pdf->Image('../../../images/logo.png', 10, 10, 20, 18);

    $pdf->Ln(15);

    $pdf->SetFont('Arial', 'B', 11);

    date_default_timezone_set('America/El_Salvador');

    //echo strftime("El año es %Y y el mes es %B");
    putenv("LANG='es_ES.UTF-8'");
    setlocale(LC_ALL, 'es_ES.UTF-8');
    $pdf->SetFont('Arial', 'B', 6.5);


    $pdf->Cell(10, 5, utf8_decode('N°'), 1, 0, 'L');
    $pdf->Cell(20, 5, utf8_decode('N° de orden'), 1, 0, 'L');
    //$pdf->Cell(20, 5, utf8_decode('Fecha'), 1, 0, 'L');
    $pdf->Cell(65, 5, utf8_decode('Cliente'), 1, 0, 'L');
    //$pdf->Cell(16, 5, utf8_decode('Mensualidad'), 1, 0, 'L');
    $pdf->Cell(16, 5, utf8_decode('Día de cobro'), 1, 0, 'L');
    $pdf->Cell(20, 5, utf8_decode('Fecha elaborada'), 1, 0, 'L');
    $pdf->Cell(20, 5, utf8_decode('Fecha finalizada'), 1, 0, 'L');
    $pdf->Cell(22, 5, utf8_decode('Trabajo realizado'), 1, 0, 'L');
    $pdf->Cell(20, 5, utf8_decode('Tipo de servicio'), 1, 0, 'L');
    $pdf->Cell(10, 5, utf8_decode('Hora'), 1, 0, 'L');
    $pdf->Cell(60, 5, utf8_decode('Dirección'), 1, 1, 'L');
    $pdf->Ln(3);

    if ($codigoCobrador === "todos") {
        $contador = 1;
        $query1 = "SELECT idTecnico, nombreTecnico FROM tbl_tecnicos_cxc";
        // Preparación de sentencia
        $statement1 = $mysqli->query($query1);
        $controlCobrador = "";

        $query2 = "SELECT idColonia, nombreColonia FROM tbl_colonias_cxc";
        // Preparación de sentencia
        $statement2 = $mysqli->query($query2);
        $controlColonia = "";

        while ($cobradores = $statement1->fetch_assoc()) {//RECORRIDO DE TODOS LOS COBRADORES
            $cobradorR = $cobradores["idTecnico"];
            //var_dump("cobrador: ".$cobradorR);
            //var_dump($fechaFiltro);
            if ($tipoServicio == "A") {
                //SQL para todas las zonas de cobro
                if ($_POST["lCobrador"] === "todos" && $_POST["lColonia"] === "todas") {
                    $query = "SELECT * FROM tbl_ordenes_trabajo WHERE (actividadCable LIKE '" . $actividad . "' OR actividadInter LIKE '" . $actividad . "') AND idTecnico= '" . $cobradorR . "' AND $fechaFiltro BETWEEN '" . $desde . "' AND '" . $hasta . "' ORDER BY idOrdenTrabajo ASC";
                    //var_dump($query."<br>");
                    $resultado = $mysqli->query($query);
                } elseif ($_POST["lCobrador"] === "todos" && $_POST["lColonia"] != "todas") {
                    $query = "SELECT * FROM tbl_ordenes_trabajo WHERE (actividadCable LIKE '" . $actividad . "' OR actividadInter LIKE '" . $actividad . "') AND idColonia= '" . $colonia . "' AND idTecnico= '" . $cobradorR . "' AND $fechaFiltro BETWEEN '" . $desde . "' AND '" . $hasta . "' ORDER BY idOrdenTrabajo ASC";
                    $resultado = $mysqli->query($query);
                    //var_dump($query."<br>");
                }
            } elseif ($tipoServicio == "C") {
                if ($_POST["lCobrador"] === "todos" && $_POST["lColonia"] === "todas") {
                    $query = "SELECT * FROM tbl_ordenes_trabajo WHERE actividadCable LIKE '" . utf8_decode($actividad) . "' AND tipoServicio= '" . $tipoServicio . "' AND idTecnico= '" . $cobradorR . "' AND $fechaFiltro BETWEEN '" . $desde . "' AND '" . $hasta . "' ORDER BY idOrdenTrabajo ASC";
                    $resultado = $mysqli->query($query);
                    //var_dump($query."<br>");
                } elseif ($_POST["lCobrador"] == "todos" && $_POST["lColonia"] != "todas") {
                    $query = "SELECT * FROM tbl_ordenes_trabajo WHERE actividadCable LIKE '" . utf8_decode($actividad) . "' AND  idColonia= '" . $colonia . "' AND idTecnico= '" . $cobradorR . "' AND tipoServicio= '" . $tipoServicio . "' AND $fechaFiltro BETWEEN '" . $desde . "' AND '" . $hasta . "' ORDER BY idOrdenTrabajo ASC";
                    $resultado = $mysqli->query($query);
                    //var_dump($query."<br>");
                }
            } elseif ($tipoServicio == "I") {
                if ($_POST["lCobrador"] === "todos" && $_POST["lColonia"] === "todas") {
                    $query = "SELECT * FROM tbl_ordenes_trabajo WHERE actividadInter LIKE '" . utf8_decode($actividad) . "' AND tipoServicio= '" . $tipoServicio . "' AND idTecnico= '" . $cobradorR . "' AND $fechaFiltro BETWEEN '" . $desde . "' AND '" . $hasta . "' ORDER BY idOrdenTrabajo ASC";
                    $resultado = $mysqli->query($query);
                } elseif ($_POST["lCobrador"] === "todos" && $_POST["lColonia"] != "todas") {
                    $query = "SELECT * FROM tbl_ordenes_trabajo WHERE actividadInter LIKE '" . utf8_decode($actividad) . "' AND idColonia= '" . $colonia . "' AND idTecnico= '" . $cobradorR . "' AND tipoServicio= '" . $tipoServicio . "' AND $fechaFiltro BETWEEN '" . $desde . "' AND '" . $hasta . "' ORDER BY idOrdenTrabajo ASC";
                    $resultado = $mysqli->query($query);
                }
            }
            var_dump($query);
            while ($row = $resultado->fetch_assoc()) {

                if ($tipoReporte = '1'){
                    if ($row["idTecnico"] == $cobradores["idTecnico"] && $controlCobrador != $cobradores["idTecnico"]) {
                        $pdf->SetFont('Arial', 'B', 8);
                        $pdf->Cell(250, 3, utf8_decode($cobradores['nombreTecnico']), "B", 1, 'L');
                        $controlCobrador = $cobradores['idTecnico'];
                    }
                }

                if ($ordenarFiltro == 'idColonia'){
                    // SQL query para traer datos del servicio de cable de la tabla impuestos
                    $queryCol = "SELECT nombreColonia FROM tbl_colonias_cxc WHERE idColonia = ".$row["idColonia"];
                    // Preparación de sentencia
                    $statementCol = $mysqli->query($queryCol);
                    //$statement->execute();
                    while ($resultCol = $statementCol->fetch_assoc()) {
                        $nCol = utf8_decode(strtoupper($resultCol['nombreColonia']));
                    }

                    if ($row["idColonia"] != $controlColonia) {
                        $pdf->Ln(2);
                        $pdf->SetFont('Arial', 'B', 6);
                        $pdf->Cell(190, 3, $nCol, 0, 1, 'L');
                        $controlColonia = $row['idColonia'];
                    }
                }


                if ($row["tipoServicio"] == "C") {
                    $query3 = "SELECT dia_cobro FROM clientes WHERE cod_cliente= " . $row['codigoCliente'];
                    // Preparación de sentencia
                    $statement3 = $mysqli->query($query3);
                    //$statement->execute();
                    while ($result2 = $statement3->fetch_assoc()) {
                        $diaCobro = $result2['dia_cobro'];
                    }
                } elseif ($row["tipoServicio"] == "I") {
                    $query3 = "SELECT dia_corbo_in FROM clientes WHERE cod_cliente= " . $row['codigoCliente'];
                    // Preparación de sentencia
                    $statement3 = $mysqli->query($query3);
                    //$statement->execute();
                    while ($result2 = $statement3->fetch_assoc()) {
                        $diaCobro = $result2['dia_corbo_in'];
                    }
                }

                $pdf->Ln(3);

                $pdf->SetFont('Arial', '', 6.7);
                $pdf->Cell(10, 1, utf8_decode($contador), 0, 0, 'L');
                //$pdf->Cell(15, 1, utf8_decode($row['idFactura']), 0, 0, 'L');
                $pdf->Cell(20, 1, utf8_decode($row['idOrdenTrabajo']), 0, 0, 'L');
                $pdf->Cell(65, 1, utf8_decode(strtoupper($row['codigoCliente'] . "  " . $row['nombreCliente'])), 0, 0, 'L');
                $pdf->Cell(16, 1, utf8_decode($diaCobro), 0, 0, 'L');
                $pdf->Cell(20, 1, utf8_decode($row['fechaOrdenTrabajo']), 0, 0, 'L');
                if (strlen($row['fechaTrabajo'] < 5)){
                    $pdf->Cell(20, 1, utf8_decode("No finalizada"), 0, 0, 'L');
                }
                else{
                    $pdf->Cell(20, 1, utf8_decode($row['fechaTrabajo']), 0, 0, 'L');
                }
                if ($row["tipoServicio"] == "C"){
                    $pdf->Cell(22, 1, utf8_decode($row["actividadCable"]), 0, 0, 'L');
                }elseif ($row["tipoServicio"] == "I"){
                    $pdf->Cell(22, 1, utf8_decode($row["actividadInter"]), 0, 0, 'L');
                }

                $pdf->Cell(20, 1, utf8_decode($row['tipoServicio']), 0, 0, 'L');
                $pdf->Cell(10, 1, utf8_decode($row['hora']), 0, 0, 'L');
                if ($row['tipoServicio'] == "C"){
                    $pdf->MultiCell(60,3,utf8_decode($row['direccionCable']),0,'L');
                }elseif($row['tipoServicio'] == "I"){
                    $pdf->MultiCell(60,3,utf8_decode($row['direccionInter']),0,'L');
                }

                $contador++;
            }
            $pdf->Ln(1);
        }
    }
    if ($codigoCobrador != "todos") {

        $query1 = "SELECT idTecnico, nombreTecnico FROM tbl_tecnicos_cxc where idTecnico=" . $codigoCobrador;
        $contador = 1;

        // Preparación de sentencia
        $statement1 = $mysqli->query($query1);
        $controlCobrador = "";

        $query2 = "SELECT idColonia, nombreColonia FROM tbl_colonias_cxc";
        // Preparación de sentencia
        $statement2 = $mysqli->query($query2);
        $controlColonia = "";

        while ($cobradores = $statement1->fetch_assoc()) {//RECORRIDO DE TODOS LOS COBRADORES
            $cobradorR = $cobradores["idTecnico"];
            //var_dump("cobrador: ".$cobradorR);

            if ($tipoServicio == "A") {
                //SQL para todas las zonas de cobro
                if ($_POST["lCobrador"] != "todos" && $_POST["lColonia"] === "todas") {
                    $query = "SELECT * FROM tbl_ordenes_trabajo WHERE (actividadCable LIKE '" . $actividad . "' OR actividadInter LIKE '" . $actividad . "') AND idTecnico= '" . $cobradorR . "' AND $fechaFiltro BETWEEN '" . $desde . "' AND '" . $hasta . "' ORDER BY idOrdenTrabajo ASC";
                    //var_dump($query."<br>");
                    $resultado = $mysqli->query($query);
                } elseif ($_POST["lCobrador"] != "todos" && $_POST["lColonia"] != "todas") {
                    $query = "SELECT * FROM tbl_ordenes_trabajo WHERE (actividadCable LIKE '" . $actividad . "' OR actividadInter LIKE '" . $actividad . "') AND idColonia= '" . $colonia . "' AND idTecnico= '" . $cobradorR . "' AND $fechaFiltro BETWEEN '" . $desde . "' AND '" . $hasta . "' ORDER BY idOrdenTrabajo ASC";
                    $resultado = $mysqli->query($query);
                    //var_dump($query."<br>");
                }
            } elseif ($tipoServicio == "C") {
                if ($_POST["lCobrador"] != "todos" && $_POST["lColonia"] === "todas") {
                    $query = "SELECT * FROM tbl_ordenes_trabajo WHERE actividadCable LIKE '" . str_replace(" (CABLE)","",utf8_decode($actividad)) . "' AND tipoServicio= '" . $tipoServicio . "' AND idTecnico= '" . $cobradorR . "' AND $fechaFiltro BETWEEN '" . $desde . "' AND '" . $hasta . "' ORDER BY idOrdenTrabajo ASC";
                    $resultado = $mysqli->query($query);
                    //var_dump($query."<br>");
                } elseif ($_POST["lCobrador"] != "todos" && $_POST["lColonia"] != "todas") {
                    $query = "SELECT * FROM tbl_ordenes_trabajo WHERE actividadCable LIKE '" . str_replace(" (CABLE)","",utf8_decode($actividad)) . "' AND  idColonia= '" . $colonia . "' AND idTecnico= '" . $cobradorR . "' AND tipoServicio= '" . $tipoServicio . "' AND $fechaFiltro BETWEEN '" . $desde . "' AND '" . $hasta . "' ORDER BY idOrdenTrabajo ASC";
                    $resultado = $mysqli->query($query);
                    //var_dump($query."<br>");
                }
            } elseif ($tipoServicio == "I") {
                if ($_POST["lCobrador"] != "todos" && $_POST["lColonia"] === "todas") {
                    $query = "SELECT * FROM tbl_ordenes_trabajo WHERE actividadInter LIKE '" . str_replace(" (INTERNET)","",utf8_decode($actividad)) . "' AND tipoServicio= '" . $tipoServicio . "' AND idTecnico= '" . $cobradorR . "' AND $fechaFiltro BETWEEN '" . $desde . "' AND '" . $hasta . "' ORDER BY idOrdenTrabajo ASC";
                    $resultado = $mysqli->query($query);
                } elseif ($_POST["lCobrador"] != "todos" && $_POST["lColonia"] != "todas") {
                    $query = "SELECT * FROM tbl_ordenes_trabajo WHERE actividadInter LIKE '" . str_replace(" (INTERNET)","",utf8_decode($actividad)) . "' AND idColonia= '" . $colonia . "' AND idTecnico= '" . $cobradorR . "' AND tipoServicio= '" . $tipoServicio . "' AND $fechaFiltro BETWEEN '" . $desde . "' AND '" . $hasta . "' ORDER BY idOrdenTrabajo ASC";
                    $resultado = $mysqli->query($query);
                }
            }
            //var_dump($query);
            while ($row = $resultado->fetch_assoc()) {

                if ($tipoReporte = '1'){
                    if ($row["idTecnico"] == $cobradores["idTecnico"] && $controlCobrador != $cobradores["idTecnico"]) {
                        $pdf->SetFont('Arial', 'B', 8);
                        $pdf->Cell(250, 3, utf8_decode($cobradores['nombreTecnico']), "B", 1, 'L');
                        $controlCobrador = $cobradores['idTecnico'];
                    }
                }

                if ($ordenarFiltro == 'idColonia'){
                    // SQL query para traer datos del servicio de cable de la tabla impuestos
                    $queryCol = "SELECT nombreColonia FROM tbl_colonias_cxc WHERE idColonia = ".$row["idColonia"];
                    // Preparación de sentencia
                    $statementCol = $mysqli->query($queryCol);
                    //$statement->execute();
                    while ($resultCol = $statementCol->fetch_assoc()) {
                        $nCol = utf8_decode(strtoupper($resultCol['nombreColonia']));
                    }

                    if ($row["idColonia"] != $controlColonia) {
                        $pdf->Ln(2);
                        $pdf->SetFont('Arial', 'B', 6);
                        $pdf->Cell(190, 3, $nCol, 0, 1, 'L');
                        $controlColonia = $row['idColonia'];
                    }
                }


                if ($row["tipoServicio"] == "C") {
                    $query3 = "SELECT dia_cobro FROM clientes WHERE cod_cliente= " . $row['codigoCliente'];
                    // Preparación de sentencia
                    $statement3 = $mysqli->query($query3);
                    //$statement->execute();
                    while ($result2 = $statement3->fetch_assoc()) {
                        $diaCobro = $result2['dia_cobro'];
                    }
                } elseif ($row["tipoServicio"] == "I") {
                    $query3 = "SELECT dia_corbo_in FROM clientes WHERE cod_cliente= " . $row['codigoCliente'];
                    // Preparación de sentencia
                    $statement3 = $mysqli->query($query3);
                    //$statement->execute();
                    while ($result2 = $statement3->fetch_assoc()) {
                        $diaCobro = $result2['dia_corbo_in'];
                    }
                }

                $pdf->Ln(3);

                $pdf->SetFont('Arial', '', 6.7);
                $pdf->Cell(10, 1, utf8_decode($contador), 0, 0, 'L');
                //$pdf->Cell(15, 1, utf8_decode($row['idFactura']), 0, 0, 'L');
                $pdf->Cell(20, 1, utf8_decode($row['idOrdenTrabajo']), 0, 0, 'L');
                $pdf->Cell(65, 1, utf8_decode(strtoupper($row['codigoCliente'] . "  " . $row['nombreCliente'])), 0, 0, 'L');
                $pdf->Cell(16, 1, utf8_decode($diaCobro), 0, 0, 'L');
                $pdf->Cell(20, 1, utf8_decode($row['fechaOrdenTrabajo']), 0, 0, 'L');
                if (strlen($row['fechaTrabajo'] < 5)){
                    $pdf->Cell(20, 1, utf8_decode("No finalizada"), 0, 0, 'L');
                }
                else{
                    $pdf->Cell(20, 1, utf8_decode($row['fechaTrabajo']), 0, 0, 'L');
                }
                if ($row["tipoServicio"] == "C"){
                    $pdf->Cell(22, 1, utf8_decode($row["actividadCable"]), 0, 0, 'L');
                }elseif ($row["tipoServicio"] == "I"){
                    $pdf->Cell(22, 1, utf8_decode($row["actividadInter"]), 0, 0, 'L');
                }

                $pdf->Cell(20, 1, utf8_decode($row['tipoServicio']), 0, 0, 'L');
                $pdf->Cell(10, 1, utf8_decode($row['hora']), 0, 0, 'L');
                if ($row['tipoServicio'] == "C"){
                    $pdf->MultiCell(60,3,utf8_decode($row['direccionCable']),0,'L');
                }elseif($row['tipoServicio'] == "I"){
                    $pdf->MultiCell(60,3,utf8_decode($row['direccionInter']),0,'L');
                }

                $contador++;
            }
            $pdf->Ln(1);
        }
    }

    $pdf->Cell(260, 6, utf8_decode("Página " . str_pad($pdf->pageNo(), 4, "0", STR_PAD_LEFT)), 0, 1, 'R');
    $pdf->Cell(185, 5, utf8_decode(''), 0, 0, 'R');
    $pdf->Cell(75, 5, utf8_decode(''), "", 1, 'R');

    //$pdf->AddPage('L','Letter');
    /*$pdf->SetFont('Arial', 'B', 8);

    //ENCABEZADOS
    $pdf->Cell(170, 5, utf8_decode(''), 0, 0, 'R');
    $pdf->Cell(20, 5, utf8_decode('IVA'), "", 0, 'L');
    $pdf->Cell(20, 5, utf8_decode('GRAVADO'), "", 0, 'L');
    $pdf->Cell(20, 5, utf8_decode('CESC'), "", 0, 'L');
    $pdf->Cell(20, 5, utf8_decode('TOTAL'), "", 1, 'L');

    //TOTAL INTERNET
    $pdf->Cell(170, 5, utf8_decode('TOTAL INTERNET: '), 0, 0, 'R');
    $pdf->Cell(20, 5, number_format($totalSoloIvaInter, 2), "T", 0, 'L');
    $pdf->Cell(20, 5, number_format($totalConIvaInter, 2), "T", 0, 'L');

    $pdf->Cell(20, 5, number_format($totalSoloCescInter, 2), "T", 0, 'L');
    $pdf->Cell(20, 5, number_format($totalConCescInter, 2), "T", 1, 'L');


    //TOTAL CABLE
    $pdf->Cell(170, 5, utf8_decode('TOTAL CABLE: '), 0, 0, 'R');
    $pdf->Cell(20, 5, number_format($totalSoloIvaCable, 2), "T", 0, 'L');
    $pdf->Cell(20, 5, number_format($totalConIvaCable, 2), "T", 0, 'L');
    $pdf->Cell(20, 5, number_format($totalSoloCescCable, 2), "T", 0, 'L');
    $pdf->Cell(20, 5, number_format($totalConCescCable, 2), "T", 1, 'L');


    //TOTAL IMPUESTO
    $pdf->Cell(170, 5, utf8_decode('TOTAL GENERAL: '), "", 0, 'R');
    $pdf->Cell(20, 5, number_format(($totalSoloIvaCable + $totalSoloIvaInter), 2), "T", 0, 'L');
    $pdf->Cell(20, 5, number_format(($totalConIvaCable + $totalConIvaInter), 2), "T", 0, 'L');
    $pdf->Cell(20, 5, number_format(($totalSoloCescCable + $totalSoloCescInter), 2), "T", 0, 'L');
    $pdf->Cell(20, 5, number_format(($totalConCescCable + $totalConCescInter), 2), "T", 1, 'L');
    */

    mysqli_close($mysqli);
    $pdf->Output();

}

abonos();