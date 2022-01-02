<?php
require_once('../../../php/connection.php');

/**
 * Clase para traer toda la información de los clientes de la BD
 */
class GetDeuda extends ConectionDB
{

    function GetDeuda()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        parent::__construct($_SESSION['db']);
    }

    public function getTotalCobrarCableImp2($tabla, $codigoCliente, $estado, $anulada)
    {
        try {
            $c = "C";

            // Total servicio CABLE
            $query = "SELECT SUM(cuotaCable) AS sumaCable, SUM(totalImpuesto) AS sumaImpuestosCable FROM $tabla WHERE codigoCliente = :codigoCliente AND tipoServicio=:tipoServicio AND estado=:estado AND anulada=:anulada";
            $statement = $this->dbConnect->prepare($query);
            $statement->bindValue(':codigoCliente', $codigoCliente);
            $statement->bindValue(':tipoServicio', $c);
            $statement->bindValue(':estado', $estado);
            $statement->bindValue(':anulada', $anulada);
            $statement->execute();
            $result1 = $statement->fetch(PDO::FETCH_ASSOC);
            $sumaCable = $result1["sumaCable"];
            $sumaImpuestosCable = $result1["sumaImpuestosCable"];

            $number = floatval($sumaCable) + floatval($sumaImpuestosCable);
            $total = number_format($number, 2);
            return $total;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getTotalCuentasC($tabla, $codigoCliente, $estado, $anulada)
    {
        try {
            $c = "C";

            // Total servicio CABLE
            $query = "SELECT COUNT(*) FROM $tabla WHERE codigoCliente = :codigoCliente AND tipoServicio=:tipoServicio AND estado=:estado AND anulada=:anulada";
            $statement = $this->dbConnect->prepare($query);
            $statement->bindValue(':codigoCliente', $codigoCliente);
            $statement->bindValue(':tipoServicio', $c);
            $statement->bindValue(':estado', $estado);
            $statement->bindValue(':anulada', $anulada);
            $statement->execute();
            $result1 = $statement->fetchColumn();
            return $result1;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getTotalCuentasI($tabla, $codigoCliente, $estado, $anulada)
    {
        try {
            $c = "I";

            // Total servicio CABLE
            $query = "SELECT COUNT(*) FROM $tabla WHERE codigoCliente = :codigoCliente AND tipoServicio=:tipoServicio AND estado=:estado AND anulada=:anulada";
            $statement = $this->dbConnect->prepare($query);
            $statement->bindValue(':codigoCliente', $codigoCliente);
            $statement->bindValue(':tipoServicio', $c);
            $statement->bindValue(':estado', $estado);
            $statement->bindValue(':anulada', $anulada);
            $statement->execute();
            $result1 = $statement->fetchColumn();

            return $result1;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getTotalCobrarInterImp2($tabla, $codigoCliente, $estado, $anulada)
    {
        try {
            // Total servicio INTERNET
            $i = "I";
            $query = "SELECT SUM(cuotaInternet) AS sumaInter, SUM(totalImpuesto) AS sumaImpuestosInter FROM $tabla WHERE codigoCliente = :codigoCliente AND tipoServicio=:tipoServicio AND estado=:estado AND anulada=:anulada";
            $statement = $this->dbConnect->prepare($query);
            $statement->bindValue(':codigoCliente', $codigoCliente);
            $statement->bindValue(':tipoServicio', $i);
            $statement->bindValue(':estado', $estado);
            $statement->bindValue(':anulada', $anulada);
            $statement->execute();
            $result2 = $statement->fetch(PDO::FETCH_ASSOC);
            $sumaInter = $result2["sumaInter"];
            $sumaImpuestosInter = $result2["sumaImpuestosInter"];

            $number = floatval($sumaInter) + floatval($sumaImpuestosInter);
            $total = number_format($number, 2);
            return $total;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }
}


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
$tipoServicio = $_POST['lServicio'];
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
        $fechaFiltro = 'fechaCobro';
    }else{
        $fechaFiltro = 'fechaFactura';
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

if (isset($_POST["ordenamiento"])){
    if ($_POST["ordenamiento"] == "1"){
        $filtroOrden = 'codigoCliente';
    }elseif($_POST["ordenamiento"] == "2"){
        $filtroOrden = 'codigoCobrador';
    }else{
        $filtroOrden = 'numeroFactura';
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

if (isset($_POST["todosDias"])){
    if ($_POST["todosDias"] == "1"){
        $diaCobroFiltro = '%';
    }
}else{
    $diaCobroFiltro = '%'.$_POST["diaCobro"].'%';
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

$totalConIvaCable = 0;
$totalConIvaInter = 0;
$totalSoloIvaCable = 0;
$totalSoloIvaInter = 0;
$totalConCescInter = 0;
$totalSoloCescInter = 0;
$deuda = new GetDeuda();


function abonos()
{
    global $desde, $hasta, $codigoCobrador, $colonia, $tipoServicio, $iva, $cesc, $mysqli, $deuda /*$statement1*/ ;
    global $totalSoloIvaCable, $totalSoloIvaInter, $totalConIvaCable, $totalConIvaInter, $totalConCescInter, $totalSoloCescInter, $totalConCescCable, $totalSoloCescCable;
    global $totalSoloCable, $totalCable, $totalImpuestoC, $totalSoloInter, $totalInter, $totalImpuestoI, $anulada, $exenta, $fechaFiltro, $ordenarFiltro, $filtroOrden, $diaCobroFiltro, $tipoComprobante;

    $pdf = new FPDF();

    $pdf->AddPage('P', 'Letter');
    $pdf->SetAutoPageBreak(false, 10);
    $pdf->SetFont('Arial', '', 6);
    //$pdf->Cell(260, 6, utf8_decode("Página " . str_pad($pdf->pageNo(), 4, "0", STR_PAD_LEFT)), 0, 1, 'R');
    //$pdf->Image('../../../images/logo.png', 98.5, 5, 20, 18);

    $pdf->Ln(0);

    /*$pdf->SetFont('Arial','B',13);
    $pdf->Cell(190,6,utf8_decode('F-3'),0,1,'R');
    $pdf->Ln();
    $pdf->Cell(190,6,utf8_decode('PAGARÉ SIN PROTESTO'),0,1,'C');
    $pdf->Ln(10);*/

    $pdf->SetFont('Arial', 'B', 11);

    date_default_timezone_set('America/El_Salvador');

    //echo strftime("El año es %Y y el mes es %B");
    putenv("LANG='es_ES.UTF-8'");
    setlocale(LC_ALL, 'es_ES.UTF-8');

    /*$pdf->SetFont('Arial', '', 7);
    $pdf->Cell(190, 4, utf8_decode('DESDE '.$desde.' HASTA '.$hasta), 0, 1, 'L');*/
    //$pdf->Ln(1);

        $contador2 = 1;

            if ($tipoServicio == "A") {
                //SQL para todas las zonas de cobro
                if ($_POST["lCobrador"] === "todos" && $_POST["lColonia"] === "todas") {
                    $query = "SELECT * FROM tbl_cargos WHERE anulada= '" . $anulada . "' AND tipoFactura LIKE '" . $tipoComprobante."%" . "' AND DAY(fechaFactura) BETWEEN '" . $desde . "' AND '" . $hasta . "' AND DAY(fechaFactura) LIKE '" . $diaCobroFiltro . "' AND estado = 'pendiente' GROUP BY codigoCliente HAVING COUNT(*) >= 1";
                    //var_dump($query."<br>");
                    $resultado = $mysqli->query($query);
                } elseif ($_POST["lCobrador"] === "todos" && $_POST["lColonia"] != "todas") {
                    $query = "SELECT * FROM tbl_cargos WHERE idColonia= '" . $colonia . "' AND anulada= '" . $anulada . "' AND DAY(fechaFactura) BETWEEN '" . $desde . "' AND '" . $hasta . "' AND DAY(fechaFactura) LIKE '" . $diaCobroFiltro . "' AND estado = 'pendiente' GROUP BY codigoCliente HAVING COUNT(*) >= 1";
                    $resultado = $mysqli->query($query);
                }
            } elseif ($tipoServicio == "C") {
                if ($_POST["lCobrador"] === "todos" && $_POST["lColonia"] === "todas") {
                    $query = "SELECT * FROM tbl_cargos WHERE anulada= '" . $anulada . "' AND tipoServicio= '" . $tipoServicio . "' AND DAY(fechaFactura) BETWEEN '" . $desde . "' AND '" . $hasta . "' AND DAY(fechaFactura) LIKE '" . $diaCobroFiltro . "' AND estado = 'pendiente' GROUP BY codigoCliente HAVING COUNT(*) >= 1 ORDER BY $filtroOrden ASC";
                    $resultado = $mysqli->query($query);
                } elseif ($_POST["lCobrador"] == "todos" && $_POST["lColonia"] != "todas") {
                    $query = "SELECT * FROM tbl_cargos WHERE idColonia= '" . $colonia . "' AND tipoServicio= '" . $tipoServicio . "' AND anulada= '" . $anulada . "' AND diaCobro BETWEEN '" . $desde . "' AND '" . $hasta . "' AND DAY(fechaFactura) LIKE '" . $diaCobroFiltro . "' AND estado = 'pendiente' GROUP BY codigoCliente HAVING COUNT(*) >= 1 ORDER BY $filtroOrden ASC";
                    $resultado = $mysqli->query($query);
                }
            } elseif ($tipoServicio == "I") {
                if ($_POST["lCobrador"] === "todos" && $_POST["lColonia"] === "todas") {
                    $query = "SELECT * FROM tbl_cargos WHERE anulada= '" . $anulada . "' AND tipoServicio= '" . $tipoServicio . "' AND DAY(fechaFactura) BETWEEN '" . $desde . "' AND '" . $hasta . "' AND DAY(fechaFactura) LIKE '" . $diaCobroFiltro . "' AND estado = 'pendiente' GROUP BY codigoCliente HAVING COUNT(*) >= 1 ORDER BY $filtroOrden ASC";
                    $resultado = $mysqli->query($query);
                } elseif ($_POST["lCobrador"] === "todos" && $_POST["lColonia"] != "todas") {
                    $query = "SELECT * FROM tbl_cargos WHERE idColonia= '" . $colonia . "' AND tipoServicio= '" . $tipoServicio . "' AND anulada= '" . $anulada . "' AND DAY(fechaFactura) BETWEEN '" . $desde . "' AND '" . $hasta . "' AND DAY(fechaFactura) LIKE '" . $diaCobroFiltro . "' AND estado = 'pendiente' GROUP BY codigoCliente HAVING COUNT(*) >= 1 ORDER BY $filtroOrden ASC";
                    $resultado = $mysqli->query($query);
                }
            }
            //$salto = 12;
            //var_dump($query);
            while ($row = $resultado->fetch_assoc()) {
                $query3 = "SELECT nombreCobrador FROM tbl_cobradores WHERE codigoCobrador = " . $row['codigoCobrador'];
                // Preparación de sentencia
                $statement3 = $mysqli->query($query3);
                //$statement->execute();
                while ($result2 = $statement3->fetch_assoc()) {
                    $asignado = $result2['nombreCobrador'];
                }
                /*INICIO DE LA COMPROBACIÓN*/
                if ($row["tipoServicio"] == "C"){
                    $query3 = "SELECT servicio_suspendido FROM clientes WHERE cod_cliente = " . $row['codigoCliente'];
                    // Preparación de sentencia
                    $statement3 = $mysqli->query($query3);
                    //$statement->execute();
                    while ($result2 = $statement3->fetch_assoc()) {
                        $suspendido = $result2['servicio_suspendido'];
                    }
                }elseif ($row["tipoServicio"] == "I"){
                    $query3 = "SELECT estado_cliente_in FROM clientes WHERE cod_cliente = " . $row['codigoCliente'];
                    // Preparación de sentencia
                    $statement3 = $mysqli->query($query3);
                    //$statement->execute();
                    while ($result2 = $statement3->fetch_assoc()) {
                        $suspendido = $result2['estado_cliente_in'];
                    }
                }
                /*FIN DE LA COMPROBACIÓN*/

                if ($row["tipoServicio"] == "C" AND $suspendido != 'T'){
                    //$pdf->Image('../../../images/logo.png', 12, $salto, 20, 18);
                    if($contador2 > 3){
                        $pdf->AddPage('P', 'Letter');
                        $pdf->SetAutoPageBreak(false, 10);

                        $contador2=1;
                        //$salto = 12;
                    }else{
                        //$salto = $salto + 66;
                    }
                    $contador2++;
                    /*if ($row["codigoCobrador"] == $cobradores["codigoCobrador"] && $controlCobrador != $cobradores["codigoCobrador"]) {
                        $pdf->Ln(1);
                        $pdf->SetFont('Arial', 'B', 8);
                        $pdf->Cell(250, 3, utf8_decode($cobradores['nombreCobrador']), "B", 1, 'L');
                        $controlCobrador = $cobradores['codigoCobrador'];
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
                    }*/

                    $pdf->SetFont('Arial', 'B', 11);
                    $pdf->Cell(196, 4.5, utf8_decode(''), "TLR", 1, 'C');
                    $pdf->Cell(196, 4.5, utf8_decode('NOTIFICACIÓN DE COBRO'), "LR", 1, 'C');
                    $pdf->SetFont('Arial', '', 9);
                    $pdf->Cell(196, 4.5, utf8_decode('CABLE VISION POR SATELITE, S.A DE C.V.'), "LR", 1, 'C');
                    if ($_SESSION['db'] == 'satpro_sm'){
                        $pdf->Cell(196, 4.5, utf8_decode('SUCURSAL SAN MIGUEL'), "LR", 1, 'C');

                    }elseif ($_SESSION['db'] == 'satpro'){
                        $pdf->Cell(196, 4.5, utf8_decode('SUCURSAL USULUTÁN'), "LR", 1, 'C');
                    }

                    if ($row["tipoServicio"] == "C") {
                        $query3 = "SELECT dia_cobro FROM clientes WHERE cod_cliente= " . $row['codigoCliente'];
                        // Preparación de sentencia
                        $statement3 = $mysqli->query($query3);
                        //$statement->execute();
                        while ($result2 = $statement3->fetch_assoc()) {
                            $diaCobro = $result2['dia_cobro'];
                        }
                        $totalCuenta = $deuda->getTotalCobrarCableImp2('tbl_cargos',$row['codigoCliente'],'pendiente',0);
                        $numeroCuentas = $deuda->getTotalCuentasC('tbl_cargos',$row['codigoCliente'],'pendiente',0);

                    } elseif ($row["tipoServicio"] == "I") {
                        $query3 = "SELECT dia_corbo_in FROM clientes WHERE cod_cliente= " . $row['codigoCliente'];
                        // Preparación de sentencia
                        $statement3 = $mysqli->query($query3);
                        //$statement->execute();
                        while ($result2 = $statement3->fetch_assoc()) {
                            $diaCobro = $result2['dia_corbo_in'];
                        }
                        $totalCuenta = $deuda->getTotalCobrarInterImp2('tbl_cargos',$row['codigoCliente'],'pendiente',0);
                        $numeroCuentas = $deuda->getTotalCuentasI('tbl_cargos',$row['codigoCliente'],'pendiente',0);
                    }

                    //$pdf->Ln(2);
                    $pdf->Cell(196, 1, utf8_decode(""), "LR", 1, 'C');
                    $pdf->SetFont('Arial', 'B', 9);
                    //$pdf->Cell(15, 1, utf8_decode($contador), 0, 0, 'L');
                    //$pdf->Cell(15, 1, utf8_decode($row['idFactura']), 0, 0, 'L');
                    //$pdf->Cell(30, 1, utf8_decode($row['numeroFactura']), 0, 0, 'L');
                    //$pdf->Cell(20, 1, utf8_decode($row['fechaFactura']), 0, 0, 'L');
                    $pdf->Cell(196, 5, utf8_decode(strtoupper($row['nombre']). "  " ."CÓDIGO: ".$row['codigoCliente']), "LR", 1, 'C');
                    //$pdf->Cell(16, 1, utf8_decode($row['mesCargo']), 0, 0, 'L');
                    //$pdf->Cell(10, 1, utf8_decode($diaCobro), 0, 0, 'L');
                    //$pdf->Cell(15, 1, utf8_decode($row['tipoServicio']), 0, 0, 'L');
                    $pdf->SetFont('Arial', '', 9);

                    if ($row['tipoServicio'] == "C") {
                        $recargo = '$3';
                        $pdf->Cell(196, 5, utf8_decode("Usuario(a) del servicio de CABLE TV en la dirección:"), "LR", 1, 'C');
                        $pdf->MultiCell(196, 5, utf8_decode(strtoupper($row['direccion'])), "LR", 'C', 0);

                    } elseif ($row['tipoServicio'] == "I") {
                        $recargo = '$5';
                        $pdf->Cell(196, 5, utf8_decode("Usuario(a) del servicio de INTERNET en la dirección:"), "LR", 1, 'C');
                        $pdf->MultiCell(196, 5, utf8_decode(strtoupper($row['direccion'])), "LR", 'C', 0);
                    }
                    $pdf->Cell(196, 5, utf8_decode("Este día fue visitado por el cobrador asignado a su zona para gestionar la cancelación de ".$numeroCuentas." cuotas pendientes de su servicio"), "LR", 1, 'C');
                    $pdf->Cell(196, 5, utf8_decode("por un monto total de ".$totalCuenta.". El monto de su factura después de vencida genera un recargo de ".$recargo." En concepto de mora."), "LR", 1, 'C');
                    $pdf->Cell(196, 1, utf8_decode(""), "LR", 1, 'C');
                    $pdf->SetFont('Arial', 'B', 9);
                    $pdf->MultiCell(196, 5, utf8_decode(strtoupper("PUEDE REALIZAR SUS PAGOS EN OFICINAS DE CABLESAT O AL COBRADOR ASIGNADO A SU ZONA")), "LR", 'C', 0);
                    $pdf->Cell(196, 3, utf8_decode(strtoupper("cobrador: ".$asignado)), "LR", 1, 'C');
                    $pdf->SetFont('Arial', '', 9);
                    date_default_timezone_set('America/El_Salvador');

                    //echo strftime("El año es %Y y el mes es %B");
                    putenv("LANG='es_ES.UTF-8'");
                    setlocale(LC_ALL, 'es_ES.UTF-8');
                    $pdf->Cell(196,6,utf8_decode("Ciudad de San Miguel, ").utf8_decode(strftime('%A %e de %B de %G')),"LR",1,'C');
                    $pdf->SetFont('Arial', 'B', 9);
                    $pdf->MultiCell(196, 10, utf8_decode("Le recordamos que la suspensión de su servicio no le exime del pago de su deuda."), "LRB", 'C', 0);
                    $pdf->Ln(10);
                    //$pdf->Cell(196,1,utf8_decode("-  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -"),"",1,'C');
                    $pdf->Ln(10);
                }elseif($row["tipoServicio"] == "I" AND $suspendido != 2){
                    //$pdf->Image('../../../images/logo.png', 12, $salto, 20, 18);
                    if($contador2 > 3){
                        $pdf->AddPage('P', 'Letter');
                        $pdf->SetAutoPageBreak(false, 10);

                        $contador2=1;
                        //$salto = 12;
                    }else{
                        //$salto = $salto + 66;
                    }
                    $contador2++;
                    /*if ($row["codigoCobrador"] == $cobradores["codigoCobrador"] && $controlCobrador != $cobradores["codigoCobrador"]) {
                        $pdf->Ln(1);
                        $pdf->SetFont('Arial', 'B', 8);
                        $pdf->Cell(250, 3, utf8_decode($cobradores['nombreCobrador']), "B", 1, 'L');
                        $controlCobrador = $cobradores['codigoCobrador'];
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
                    }*/

                    $pdf->SetFont('Arial', 'B', 11);
                    $pdf->Cell(196, 4.5, utf8_decode(''), "TLR", 1, 'C');
                    $pdf->Cell(196, 4.5, utf8_decode('NOTIFICACIÓN DE COBRO'), "LR", 1, 'C');
                    $pdf->SetFont('Arial', '', 9);
                    $pdf->Cell(196, 4.5, utf8_decode('CABLE VISION POR SATELITE, S.A DE C.V.'), "LR", 1, 'C');
                    if ($_SESSION['db'] == 'satpro_sm'){
                        $pdf->Cell(196, 4.5, utf8_decode('SUCURSAL SAN MIGUEL'), "LR", 1, 'C');

                    }elseif ($_SESSION['db'] == 'satpro'){
                        $pdf->Cell(196, 4.5, utf8_decode('SUCURSAL USULUTÁN'), "LR", 1, 'C');
                    }

                    if ($row["tipoServicio"] == "C") {
                        $query3 = "SELECT dia_cobro FROM clientes WHERE cod_cliente= " . $row['codigoCliente'];
                        // Preparación de sentencia
                        $statement3 = $mysqli->query($query3);
                        //$statement->execute();
                        while ($result2 = $statement3->fetch_assoc()) {
                            $diaCobro = $result2['dia_cobro'];
                        }
                        $totalCuenta = $deuda->getTotalCobrarCableImp2('tbl_cargos',$row['codigoCliente'],'pendiente',0);
                        $numeroCuentas = $deuda->getTotalCuentasC('tbl_cargos',$row['codigoCliente'],'pendiente',0);

                    } elseif ($row["tipoServicio"] == "I") {
                        $query3 = "SELECT dia_corbo_in FROM clientes WHERE cod_cliente= " . $row['codigoCliente'];
                        // Preparación de sentencia
                        $statement3 = $mysqli->query($query3);
                        //$statement->execute();
                        while ($result2 = $statement3->fetch_assoc()) {
                            $diaCobro = $result2['dia_corbo_in'];
                        }
                        $totalCuenta = $deuda->getTotalCobrarInterImp2('tbl_cargos',$row['codigoCliente'],'pendiente',0);
                        $numeroCuentas = $deuda->getTotalCuentasI('tbl_cargos',$row['codigoCliente'],'pendiente',0);
                    }

                    //$pdf->Ln(2);
                    $pdf->Cell(196, 1, utf8_decode(""), "LR", 1, 'C');
                    $pdf->SetFont('Arial', 'B', 9);
                    //$pdf->Cell(15, 1, utf8_decode($contador), 0, 0, 'L');
                    //$pdf->Cell(15, 1, utf8_decode($row['idFactura']), 0, 0, 'L');
                    //$pdf->Cell(30, 1, utf8_decode($row['numeroFactura']), 0, 0, 'L');
                    //$pdf->Cell(20, 1, utf8_decode($row['fechaFactura']), 0, 0, 'L');
                    $pdf->Cell(196, 5, utf8_decode(strtoupper($row['nombre']). "  " ."CÓDIGO: ".$row['codigoCliente']), "LR", 1, 'C');
                    //$pdf->Cell(16, 1, utf8_decode($row['mesCargo']), 0, 0, 'L');
                    //$pdf->Cell(10, 1, utf8_decode($diaCobro), 0, 0, 'L');
                    //$pdf->Cell(15, 1, utf8_decode($row['tipoServicio']), 0, 0, 'L');
                    $pdf->SetFont('Arial', '', 9);

                    if ($row['tipoServicio'] == "C") {
                        $recargo = '$3';
                        $pdf->Cell(196, 5, utf8_decode("Usuario(a) del servicio de CABLE TV en la dirección:"), "LR", 1, 'C');
                        $pdf->MultiCell(196, 5, utf8_decode(strtoupper($row['direccion'])), "LR", 'C', 0);

                    } elseif ($row['tipoServicio'] == "I") {
                        $recargo = '$5';
                        $pdf->Cell(196, 5, utf8_decode("Usuario(a) del servicio de INTERNET en la dirección:"), "LR", 1, 'C');
                        $pdf->MultiCell(196, 5, utf8_decode(strtoupper($row['direccion'])), "LR", 'C', 0);
                    }
                    $pdf->Cell(196, 5, utf8_decode("Este día fue visitado por el cobrador asignado a su zona para gestionar la cancelación de ".$numeroCuentas." cuotas pendientes de su servicio"), "LR", 1, 'C');
                    $pdf->Cell(196, 5, utf8_decode("por un monto total de ".$totalCuenta.". El monto de su factura después de vencida genera un recargo de ".$recargo." En concepto de mora."), "LR", 1, 'C');
                    $pdf->Cell(196, 1, utf8_decode(""), "LR", 1, 'C');
                    $pdf->SetFont('Arial', 'B', 9);
                    $pdf->MultiCell(196, 5, utf8_decode(strtoupper("PUEDE REALIZAR SUS PAGOS EN OFICINAS DE CABLESAT O AL COBRADOR ASIGNADO A SU ZONA")), "LR", 'C', 0);
                    $pdf->Cell(196, 3, utf8_decode(strtoupper("cobrador: ".$asignado)), "LR", 1, 'C');
                    $pdf->SetFont('Arial', '', 9);
                    date_default_timezone_set('America/El_Salvador');

                    //echo strftime("El año es %Y y el mes es %B");
                    putenv("LANG='es_ES.UTF-8'");
                    setlocale(LC_ALL, 'es_ES.UTF-8');
                    $pdf->Cell(196,6,utf8_decode("Ciudad de San Miguel, ").utf8_decode(strftime('%A %e de %B de %G')),"LR",1,'C');
                    $pdf->SetFont('Arial', 'B', 9);
                    $pdf->MultiCell(196, 10, utf8_decode("Le recordamos que la suspensión de su servicio no le exime del pago de su deuda."), "LRB", 'C', 0);
                    $pdf->Ln(20);
                }

            }
            $pdf->Ln(2);

    if ($codigoCobrador != "todos") {

        $query1 = "SELECT codigoCobrador, nombreCobrador FROM tbl_cobradores where codigoCobrador=" . $codigoCobrador;
        $contador = 1;

        // Preparación de sentencia
        $statement1 = $mysqli->query($query1);
        $controlCobrador = "";

        $query2 = "SELECT idColonia, nombreColonia FROM tbl_colonias_cxc";
        // Preparación de sentencia
        $statement2 = $mysqli->query($query2);
        $controlColonia = "";
        $contador2=1;
        while ($cobradores = $statement1->fetch_assoc()) {//RECORRIDO DE TODOS LOS COBRADORES
            $cobradorR = $cobradores["codigoCobrador"];
            //var_dump("cobrador: ".$cobradorR);

            if ($tipoServicio == "A") {
                //SQL para todas las zonas de cobro
                if ($_POST["lCobrador"] != "todos" && $_POST["lColonia"] === "todas") {
                    $query = "SELECT * FROM tbl_cargos WHERE anulada= '" . $anulada . "' AND tipoFactura LIKE '" . $tipoComprobante."%" . "' AND codigoCobrador= '" . $cobradorR . "' AND $fechaFiltro BETWEEN '" . $desde . "' AND '" . $hasta . "' AND DAY(fechaFactura) LIKE '" . $diaCobroFiltro . "' ORDER BY $ordenarFiltro ASC";
                    //var_dump($query."<br>");
                    $resultado = $mysqli->query($query);
                } elseif ($_POST["lCobrador"] != "todos" && $_POST["lColonia"] != "todas") {
                    $query = "SELECT * FROM tbl_cargos WHERE idColonia= '" . $colonia . "' AND codigoCobrador= '" . $cobradorR . "' AND anulada= '" . $anulada . "' AND $fechaFiltro BETWEEN '" . $desde . "' AND '" . $hasta . "' AND DAY(fechaFactura) LIKE '" . $diaCobroFiltro . "' ORDER BY $ordenarFiltro ASC";
                    $resultado = $mysqli->query($query);
                    //var_dump($query."<br>");
                }
            } elseif ($tipoServicio == "C") {
                if ($_POST["lCobrador"] != "todos" && $_POST["lColonia"] === "todas") {
                    $query = "SELECT * FROM tbl_cargos WHERE anulada= '" . $anulada . "' AND tipoServicio= '" . $tipoServicio . "' AND codigoCobrador= '" . $cobradorR . "' AND $fechaFiltro BETWEEN '" . $desde . "' AND '" . $hasta . "' AND DAY(fechaFactura) LIKE '" . $diaCobroFiltro . "' ORDER BY $ordenarFiltro ASC";
                    $resultado = $mysqli->query($query);
                } elseif ($_POST["lCobrador"] != "todos" && $_POST["lColonia"] != "todas") {
                    $query = "SELECT * FROM tbl_cargos WHERE idColonia= '" . $colonia . "' AND codigoCobrador= '" . $cobradorR . "' AND tipoServicio= '" . $tipoServicio . "' AND anulada= '" . $anulada . "' AND $fechaFiltro BETWEEN '" . $desde . "' AND '" . $hasta . "' AND DAY(fechaFactura) LIKE '" . $diaCobroFiltro . "' ORDER BY $ordenarFiltro ASC";
                    $resultado = $mysqli->query($query);
                }
            } elseif ($tipoServicio == "I") {
                if ($_POST["lCobrador"] != "todos" && $_POST["lColonia"] === "todas") {
                    $query = "SELECT * FROM tbl_cargos WHERE anulada= '" . $anulada . "' AND tipoServicio= '" . $tipoServicio . "' AND codigoCobrador= '" . $cobradorR . "' AND $fechaFiltro BETWEEN '" . $desde . "' AND '" . $hasta . "' AND DAY(fechaFactura) LIKE '" . $diaCobroFiltro . "' ORDER BY $ordenarFiltro ASC";
                    $resultado = $mysqli->query($query);
                } elseif ($_POST["lCobrador"] != "todos" && $_POST["lColonia"] != "todas") {
                    $query = "SELECT * FROM tbl_cargos WHERE idColonia= '" . $colonia . "' AND codigoCobrador= '" . $cobradorR . "' AND tipoServicio= '" . $tipoServicio . "' AND anulada= '" . $anulada . "' AND $fechaFiltro BETWEEN '" . $desde . "' AND '" . $hasta . "' AND DAY(fechaFactura) LIKE '" . $diaCobroFiltro . "' ORDER BY $ordenarFiltro ASC";
                    $resultado = $mysqli->query($query);
                }
            }
            //var_dump($query);
            while ($row = $resultado->fetch_assoc()) {
                if ($row["codigoCobrador"] == $cobradores["codigoCobrador"] && $controlCobrador != $cobradores["codigoCobrador"]) {
                    $pdf->Ln(1);
                    $pdf->SetFont('Arial', 'B', 8);
                    $pdf->Cell(250, 3, utf8_decode($cobradores['nombreCobrador']), "B", 1, 'L');
                    $controlCobrador = $cobradores['codigoCobrador'];
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

                $pdf->Ln(2);
                $pdf->SetFont('Arial', '', 6.7);
                $pdf->Cell(15, 1, utf8_decode($contador), 0, 0, 'L');
                //$pdf->Cell(15, 1, utf8_decode($row['idFactura']), 0, 0, 'L');
                $pdf->Cell(30, 1, utf8_decode($row['numeroFactura']), 0, 0, 'L');
                $pdf->Cell(20, 1, utf8_decode($row['fechaFactura']), 0, 0, 'L');
                $pdf->Cell(75, 1, utf8_decode(strtoupper($row['codigoCliente'] . "  " . $row['nombre'])), 0, 0, 'L');
                $pdf->Cell(16, 1, utf8_decode($row['mesCargo']), 0, 0, 'L');
                $pdf->Cell(10, 1, utf8_decode($diaCobro), 0, 0, 'L');
                $pdf->Cell(15, 1, utf8_decode($row['tipoServicio']), 0, 0, 'L');

                if ($row['tipoServicio'] == "C") {
                    //Calculando IVA
                    $separado = (doubleval($row['cuotaCable'])/(1 + doubleval($iva)));
                    $totalIvaCable = (doubleval($separado) * doubleval($iva));
                    $totalSoloIvaCable = doubleval($totalSoloIvaCable) + doubleval($totalIvaCable);
                    $totalConIvaCable = doubleval($totalConIvaCable) + doubleval($row["cuotaCable"]);
                    $totalSoloCescCable = doubleval($totalSoloCescCable) + doubleval($row['totalImpuesto']);
                    $totalConCescCable = doubleval($totalConCescCable) + doubleval($row["cuotaCable"]) + doubleval($row['totalImpuesto']);

                    $pdf->Cell(15, 1, utf8_decode(number_format($separado, 2)), 0, 0, 'L');
                    $pdf->Cell(10, 1, utf8_decode(number_format($row["cuotaCable"]-$separado, 2)), 0, 0, 'L');
                    $pdf->Cell(15, 1, utf8_decode($row['cuotaCable']), 0, 0, 'L');
                    $pdf->Cell(15, 1, utf8_decode(number_format($row['totalImpuesto'],2)), 0, 0, 'L');
                    $pdf->Cell(15, 1, utf8_decode(number_format(doubleval($row['cuotaCable']) + doubleval($row['totalImpuesto']), 2)), 0, 1, 'L');
                    //$totalAnticipoSoloCable = doubleval($totalAnticipoSoloCable) + doubleval($row['cuotaCable']);
                    //$totalAnticipoCable = doubleval($totalAnticipoCable) + doubleval($row['cuotaCable']) + doubleval($row['totalImpuesto']);
                    //$totalAnticipoImpuestoC = doubleval($totalAnticipoImpuestoC) + doubleval($row['totalImpuesto']);
                } elseif ($row['tipoServicio'] == "I") {
                    //Calculando IVA REVISARLO
                    $separado = (doubleval($row['cuotaInternet'])/(1 + doubleval($iva)));
                    $totalIva = (doubleval($separado) * doubleval($iva));
                    //var_dump($row["cuotaInternet"]-$separado);
                    //var_dump($totalIva);

                    $totalSoloIvaInter = doubleval($totalSoloIvaInter) + doubleval($totalIva);
                    //var_dump($totalIva);
                    //var_dump($totalSoloIvaInter);
                    $totalConIvaInter = doubleval($totalConIvaInter) + doubleval($row["cuotaInternet"]);
                    $totalSoloCescInter = doubleval($totalSoloCescInter) + doubleval($row['totalImpuesto']);
                    $totalConCescInter = doubleval($totalConCescInter) + doubleval($row["cuotaInternet"]) + doubleval($row['totalImpuesto']);

                    $pdf->Cell(15, 1, utf8_decode(number_format($separado,2)), 0, 0, 'L');
                    $pdf->Cell(10, 1, utf8_decode(number_format(doubleval($totalIva), 2)), 0, 0, 'L');
                    $pdf->Cell(15, 1, utf8_decode($row['cuotaInternet']), 0, 0, 'L');
                    $pdf->Cell(15, 1, utf8_decode(number_format($row['totalImpuesto'],2)), 0, 0, 'L');
                    $pdf->Cell(15, 1, utf8_decode(number_format(doubleval($row['cuotaInternet']) + doubleval($row['totalImpuesto']), 2)), 0, 1, 'L');
                    //$totalAnticipoSoloInter = doubleval($totalAnticipoSoloInter) + doubleval($row['cuotaInternet']);
                    //$totalAnticipoInter = doubleval($totalAnticipoInter) + doubleval($row['cuotaInternet']) + doubleval($row['totalImpuesto']);
                    //$totalAnticipoImpuestoI = doubleval($totalAnticipoImpuestoI) + doubleval($row['totalImpuesto']);
                }
                $contador++;

                if($contador2 > 44){
                    $pdf->AddPage('L', 'Letter');
                    $pdf->SetAutoPageBreak(false, 10);
                    $pdf->SetFont('Arial', '', 6);
                    $pdf->Cell(260, 6, utf8_decode("Página " . str_pad($pdf->pageNo(), 4, "0", STR_PAD_LEFT)), 0, 1, 'R');
                    $pdf->Image('../../../images/logo.png', 10, 10, 20, 18);

                    $pdf->Ln(15);

                    $pdf->SetFont('Arial', 'B', 11);

                    date_default_timezone_set('America/El_Salvador');

                    //echo strftime("El año es %Y y el mes es %B");
                    putenv("LANG='es_ES.UTF-8'");
                    setlocale(LC_ALL, 'es_ES.UTF-8');
                    $pdf->SetFont('Arial', 'B', 9);
                    $pdf->Cell(190, 4, utf8_decode('CABLE VISION POR SATELITE, S.A DE C.V.'), 0, 1, 'L');
                    $pdf->SetFont('Arial', 'B', 7);
                    $pdf->Cell(190, 4, utf8_decode('LISTADO DE CRÉDITOS FISCALES Y FACTURAS EMITIDAS'), 0, 1, 'L');
                    if ($_SESSION['db'] == 'satpro_sm'){
                        $pdf->Cell(190, 4, utf8_decode('SUCURSAL SAN MIGUEL'), 0, 1, 'L');

                    }elseif ($_SESSION['db'] == 'satpro'){
                        $pdf->Cell(190, 4, utf8_decode('SUCURSAL USULUTÁN'), 0, 1, 'L');
                    }
                    $pdf->SetFont('Arial', '', 7);
                    $pdf->Cell(190, 4, utf8_decode('DESDE '.$desde.' HASTA '.$hasta), 0, 1, 'L');
                    $pdf->Ln(2);

                    $pdf->SetFont('Arial', 'B', 6.5);
                    $pdf->Cell(15, 5, utf8_decode('N°'), 1, 0, 'L');
                    $pdf->Cell(30, 5, utf8_decode('N° de factura'), 1, 0, 'L');
                    $pdf->Cell(20, 5, utf8_decode('Fecha'), 1, 0, 'L');
                    $pdf->Cell(75, 5, utf8_decode('Cliente'), 1, 0, 'L');
                    $pdf->Cell(16, 5, utf8_decode('Mensualidad'), 1, 0, 'L');
                    $pdf->Cell(10, 5, utf8_decode('Día cob'), 1, 0, 'L');
                    $pdf->Cell(15, 5, utf8_decode('Servicio'), 1, 0, 'L');
                    $pdf->Cell(15, 5, utf8_decode('Gravado'), 1, 0, 'L');
                    $pdf->Cell(10, 5, utf8_decode('IVA'), 1, 0, 'L');
                    $pdf->Cell(15, 5, utf8_decode('Neto'), 1, 0, 'L');
                    $pdf->Cell(15, 5, utf8_decode('CESC'), 1, 0, 'L');
                    $pdf->Cell(15, 5, utf8_decode('Total factura'), 1, 1, 'L');
                    $contador2=1;
                }
                $contador2++;

            }
            //$pdf->Ln(2);
        }
    }

    /* close connection */
    mysqli_close($mysqli);
    $pdf->Output();

}

abonos();