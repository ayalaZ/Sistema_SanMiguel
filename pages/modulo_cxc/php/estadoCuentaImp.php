<?php

require '../../../pdfs/fpdf.php';
require_once("../../../php/config.php");
require_once("../../../php/connection.php");

if(!isset($_SESSION))
{
    session_start();
}

class GetAllInfo3 extends ConectionDB
{

    function GetAllInfo3()
    {
        if(!isset($_SESSION))
        {
            session_start();
        }
        parent::__construct ($_SESSION['db']);
    }

    public function getDataAbonosGlobal($codigoCliente, $tipoServicio, $estado, $desde, $hasta){
        try {
            //SELECT * FROM Table1 WHERE Table1.principal NOT IN (SELECT principal FROM table2)
            $query = "SELECT * FROM tbl_abonos WHERE codigoCliente = :codigoCliente AND tipoServicio=:tipoServicio AND estado=:estado AND anulada=:anulada and tbl_abonos.mesCargo NOT IN(SELECT mesCargo from tbl_cargos where anulada = 0 and codigoCliente=:codigoCliente and tipoServicio = :tipoServicio) and fechaAbonado between '{$desde}' and '{$hasta}' ORDER BY CAST(CONCAT(substring(mesCargo,4,4), '-', substring(mesCargo,1,2),'-', '01') AS DATE) DESC";
            $statement = $this->dbConnect->prepare($query);
            $statement->bindValue(':codigoCliente', $codigoCliente);
            $statement->bindValue(':tipoServicio', $tipoServicio);
            $statement->bindValue(':estado', $estado);
            $statement->bindValue(':anulada', 0);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }
    public function getDataCargosGlobal($codigoCliente, $tipoServicio, $estado, $desde, $hasta){
        try {
            //SELECT * FROM Table1 WHERE Table1.principal NOT IN (SELECT principal FROM table2)
            $query = "SELECT * FROM tbl_cargos WHERE codigoCliente = :codigoCliente AND tipoServicio=:tipoServicio AND estado=:estado AND anulada=:anulada and tbl_cargos.mesCargo NOT IN(SELECT mesCargo from tbl_abonos where anulada = 0 and codigoCliente=:codigoCliente and tipoServicio = :tipoServicio) and fechaFactura between '{$desde}' and '{$hasta}' ORDER BY CAST(CONCAT(substring(mesCargo,4,4), '-', substring(mesCargo,1,2),'-', '01') AS DATE) DESC";
            $statement = $this->dbConnect->prepare($query);
            $statement->bindValue(':codigoCliente', $codigoCliente);
            $statement->bindValue(':tipoServicio', $tipoServicio);
            $statement->bindValue(':estado', $estado);
            $statement->bindValue(':anulada', 0);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getDataEstadoCable($codigoCliente, $tipoServicio, $desde, $hasta){
        try {
            //$estado = "pendiente";
            $query = "SELECT c.estado as estadoCargo, c.numeroFactura as facturaCargo, c.numeroRecibo as reciboCargo, c.mesCargo as cargoCargo, c.tipoServicio as servicioCargo, c.fechaFactura as fechaFacturaCargo, c.fechaVencimiento as fechaVencimientoCargo, c.cuotaCable as cuotaCableCargo, c.totalImpuesto as totalImpuestoCargo, a.estado as estadoAbono, a.numeroFactura as facturaAbono, a.numeroRecibo as reciboAbono, a.mesCargo as cargoAbono, a.tipoServicio as servicioAbono, a.fechaAbonado as fechaAbonadoAbono, a.fechaVencimiento as fechaVencimientoAbono, a.cuotaCable as cuotaCableAbono, a.totalImpuesto as totalImpuestoAbono
                      FROM tbl_cargos as c inner JOIN tbl_abonos as a ON (a.`codigoCliente` = c.`codigoCliente`) WHERE c.`tipoServicio`=:tipoServicio and a.`tipoServicio`=:tipoServicio and (c.`mesCargo`=a.`mesCargo`) and c.codigoCliente=:codigoCliente and a.codigoCliente=:codigoCliente and a.anulada=:anulada and c.anulada=:anulada and a.fechaAbonado between '{$desde}' and '{$hasta}' and c.fechaFactura between '{$desde}' and '{$hasta}' order by CAST(CONCAT(substring(c.mesCargo,4,4), '-', substring(c.mesCargo,1,2),'-', '01') AS DATE) DESC";

            $statement = $this->dbConnect->prepare($query);
            $statement->bindValue(':codigoCliente', $codigoCliente);
            $statement->bindValue(':tipoServicio', $tipoServicio);
            $statement->bindValue(':anulada', 0);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }
    public function getDataEstadoInter($codigoCliente, $tipoServicio, $desde, $hasta){
        try {
            //$estado = "pendiente";
            $query = "SELECT c.estado as estadoCargo, c.numeroFactura as facturaCargo, c.numeroRecibo as reciboCargo, c.mesCargo as cargoCargo, c.tipoServicio as servicioCargo, c.fechaFactura as fechaFacturaCargo, c.fechaVencimiento as fechaVencimientoCargo, c.cuotaInternet as cuotaInterCargo, c.totalImpuesto as totalImpuestoCargo, a.estado as estadoAbono, a.numeroFactura as facturaAbono, a.numeroRecibo as reciboAbono, a.mesCargo as cargoAbono, a.tipoServicio as servicioAbono, a.fechaAbonado as fechaAbonadoAbono, a.fechaVencimiento as fechaVencimientoAbono, a.cuotaInternet as cuotaInterAbono, a.totalImpuesto as totalImpuestoAbono
                      FROM tbl_cargos as c inner JOIN tbl_abonos as a ON (a.`codigoCliente` = c.`codigoCliente`) WHERE c.`tipoServicio`=:tipoServicio and a.`tipoServicio`=:tipoServicio and (c.`mesCargo`=a.`mesCargo`) and c.codigoCliente=:codigoCliente and a.codigoCliente=:codigoCliente and a.anulada=:anulada and c.anulada=:anulada and a.fechaAbonado between '{$desde}' and '{$hasta}' and c.fechaFactura between '{$desde}' and '{$hasta}' order by CAST(CONCAT(substring(c.mesCargo,4,4), '-', substring(c.mesCargo,1,2),'-', '01') AS DATE) DESC";

            $statement = $this->dbConnect->prepare($query);
            $statement->bindValue(':codigoCliente', $codigoCliente);
            $statement->bindValue(':tipoServicio', $tipoServicio);
            $statement->bindValue(':anulada', 0);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getTotalCobrarCable($id)
    {
        try {
            /*******INICIO DE INSTRUCCIONES PARA SACAR EL SALDO REAL DEL CLIENTE**********/
            // prepare select query
            $anulada = 0;
            $estado = "pendiente";
            $this->dbConnect->beginTransaction();
            $query = "SELECT SUM(cuotaCable + totalImpuesto) FROM tbl_cargos WHERE codigoCliente=:codigo AND anulada=:anulada AND tipoServicio='C'";
            $stmt = $this->dbConnect->prepare( $query );
            // this is the first question mark
            $stmt->bindParam(':codigo', $id);
            $stmt->bindParam(':anulada', $anulada);
            // execute our query
            $stmt->execute();
            // store retrieved row to a variable
            $totalCargosCable = $stmt->fetchColumn();
            /***  ABONOS  ***/
            // prepare select query
            $query = "SELECT SUM(cuotaCable + totalImpuesto) FROM tbl_abonos WHERE codigoCliente=:codigo AND anulada=:anulada AND tipoServicio='C'";
            $stmt = $this->dbConnect->prepare( $query );

            $stmt->bindParam(':codigo', $id);
            $stmt->bindParam(':anulada', $anulada);
            // execute our query
            $stmt->execute();
            // store retrieved row to a variable
            $totalAbonosCable = $stmt->fetchColumn();
            $saldoRealCable = floatVal($totalCargosCable) - floatVal($totalAbonosCable);
            sleep(0.25);
            $this->dbConnect->commit();
            return $saldoRealCable;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function getTotalCobrarInter($id)
    {
        try {
            /*******INICIO DE INSTRUCCIONES PARA SACAR EL SALDO REAL DEL CLIENTE**********/
            $anulada = 0;
            $this->dbConnect->beginTransaction();
            // prepare select query
            $query = "SELECT SUM(cuotaInternet + totalImpuesto) FROM tbl_cargos WHERE codigoCliente=:codigo AND anulada=:anulada AND tipoServicio='I'";
            $stmt = $this->dbConnect->prepare( $query );
            // this is the first question mark
            $stmt->bindParam(':codigo', $id);
            $stmt->bindParam(':anulada', $anulada);
            // execute our query
            $stmt->execute();
            // store retrieved row to a variable
            $totalCargosInter = $stmt->fetchColumn();
            /***  ABONOS  ***/
            // prepare select query
            $query = "SELECT SUM(cuotaInternet + totalImpuesto) FROM tbl_abonos WHERE codigoCliente=:codigo AND anulada=:anulada AND tipoServicio='I'";
            $stmt = $this->dbConnect->prepare( $query );
            // this is the first question mark
            $stmt->bindParam(':codigo', $id);
            $stmt->bindParam(':anulada', $anulada);
            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $totalAbonosInter = $stmt->fetchColumn();
            $saldoRealInter = floatVal($totalCargosInter) - floatVal($totalAbonosInter);
            /*******FINAL DE INSTRUCCIONES PARA SACAR EL SALDO REAL DEL CLIENTE**********/
            sleep(0.25);
            $this->dbConnect->commit();
            return $saldoRealInter;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function detServC($id)
    {
        try {
            //$estado = "pendiente";
            $query = "SELECT servicio_suspendido, sin_servicio from clientes where cod_cliente = :codigoCliente";

            $statement = $this->dbConnect->prepare($query);
            $statement->bindValue(':codigoCliente', $id);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $servSusp = $result["servicio_suspendido"];
            $sinServ = $result["sin_servicio"];
            if ($servSusp == "T" && $sinServ == "F"){
                return "Suspendido";
            }elseif($servSusp != "T" && $sinServ == "T"){
                return "Sin servicio";
            }elseif($servSusp != "T" && $sinServ == "F"){
                return "Activo";
            }


        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

    public function detServI($id)
    {
        try {
            //$estado = "pendiente";
            $query = "SELECT estado_cliente_in from clientes where cod_cliente = :codigoCliente";

            $statement = $this->dbConnect->prepare($query);
            $statement->bindValue(':codigoCliente', $id);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $estado = $result["estado_cliente_in"];
            if ($estado == 2){
                return "Suspendido";
            }elseif($estado == 3){
                return "Sin servicio";
            }elseif($estado == 1){
                return "Activo";
            }


        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

}

$host = DB_HOST;
$user = DB_USER;
$password = DB_PASSWORD;
$database = $_SESSION['db'];
$mysqli = new mysqli($host, $user, $password, $database);

//$codigo = $_GET['id'];
$desde = $_POST['ecDesde'];
$hasta = $_POST['ecHasta'];
$codigoCliente = $_GET['codigoCliente'];
$anulada = 0;
//$detallado = $_POST['lDetallado'];
$tipoServicio = $_POST["tipoServicio"];

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

$dataInfo = new GetAllInfo3();
$arrCargosCable = $dataInfo->getDataCargosGlobal($codigoCliente, 'C', 'pendiente', $desde, $hasta);
$arrCargosInter = $dataInfo->getDataCargosGlobal($codigoCliente, 'I', 'pendiente', $desde, $hasta);
$arrAbonosCable = $dataInfo->getDataAbonosGlobal($codigoCliente, 'C', 'CANCELADA', $desde, $hasta);
$arrAbonosInter = $dataInfo->getDataAbonosGlobal($codigoCliente, 'I', 'CANCELADA', $desde, $hasta);

$arrEstadoCable = $dataInfo->getDataEstadoCable($codigoCliente,'C', $desde, $hasta);
$arrEstadoInter = $dataInfo->getDataEstadoInter($codigoCliente,'I', $desde, $hasta);

$totalCobrarCable = number_format(($dataInfo->getTotalCobrarCable($codigoCliente)),2);
$totalCobrarInter = number_format(($dataInfo->getTotalCobrarInter($codigoCliente)),2);
$servicioC = $dataInfo->detServC($codigoCliente);
$servicioI = $dataInfo->detServI($codigoCliente);

function abonos(){
    global $desde, $hasta, $codigoCliente,$tipoServicio,$anulada,$mysqli,$arrCargosCable,$arrCargosInter,$arrAbonosCable,$arrAbonosCable,$arrAbonosInter,$arrEstadoCable,$arrEstadoInter;
    global $totalCobrarCable, $totalCobrarInter, $servicioC, $servicioI;

            $pdf = new FPDF();
            date_default_timezone_set('America/El_Salvador');
            $pdf->AddPage('L','Letter');
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(260,6,utf8_decode("Página ".str_pad($pdf->pageNo(),4,"0",STR_PAD_LEFT)),0,1,'R');
            $pdf->Cell(260,4,utf8_decode("GENERADO POR: ".strtoupper($_SESSION['nombres'])." ".strtoupper($_SESSION['apellidos']). " ".date('d/m/Y h:i:s')),"",1,'R');
            $pdf->Image('../../../images/logo.png',10,10, 20, 18);

            $pdf->Ln(10);

            $pdf->SetFont('Arial','B',11);

            date_default_timezone_set('America/El_Salvador');

            // SQL query para traer nombre del cliente
            $query = "SELECT nombre, direccion, estado_cliente_in, servicio_suspendido, sin_servicio FROM clientes WHERE cod_cliente =".$codigoCliente;
            // Preparación de sentencia
            $statement = $mysqli->query($query);
            //$statement->execute();
            while ($result = $statement->fetch_assoc()) {
                $nombre = $result['nombre'];
                $direccion = $result['direccion'];
                $estadoIn = $result['estado_cliente_in'];
                $susp = $result['servicio_suspendido'];
                $sinServ = $result['sin_servicio'];
            }

            //echo strftime("El año es %Y y el mes es %B");
            putenv("LANG='es_ES.UTF-8'");
            setlocale(LC_ALL, 'es_ES.UTF-8');
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(190, 4, utf8_decode('CABLE VISION POR SATELITE, S.A DE C.V.'), 0, 1, 'L');
            $pdf->SetFont('Arial', 'B', 7.5);
            $pdf->Cell(190, 4, utf8_decode('ESTADO DE CUENTA'), 0, 1, 'L');
            if ($_SESSION['db'] == 'satpro_sm'){
                $pdf->Cell(190, 4, utf8_decode('SUCURSAL SAN MIGUEL'), 0, 1, 'L');

            }elseif ($_SESSION['db'] == 'satpro'){
                $pdf->Cell(190, 4, utf8_decode('SUCURSAL USULUTÁN'), 0, 1, 'L');
            }else{
                $pdf->Cell(190, 4, utf8_decode('SUCURSAL DE PRUEBA'), 0, 1, 'L');
            }
            $pdf->SetFont('Arial', '', 7.5);
            $pdf->Cell(130, 4, utf8_decode("CLIENTE: ".$codigoCliente." ".$nombre), 0, 0, 'L');
            $pdf->Cell(130,4,utf8_decode(strtoupper("CABLE: ".$servicioC)),0,1,'R');
            $pdf->Cell(130, 4, utf8_decode("DIRECCIÓN: ".substr($direccion,0,130)), 0, 0, 'L');
            $pdf->Cell(130,4,utf8_decode(strtoupper("INTERNET: ".$servicioI)),0,1,'R');
            $pdf->SetFont('Arial', '', 7.5);
            $pdf->Cell(190, 4, utf8_decode('DESDE '.$desde.' HASTA '.$hasta), 0, 1, 'L');

            $pdf->Ln(2);

            $pdf->SetFont('Arial','B',9);
            //$pdf->Cell(20,5,utf8_decode('N°'),1,0,'L');
            $pdf->Cell(25,5,utf8_decode('N° de recibo'),1,0,'L');
            $pdf->Cell(25,5,utf8_decode('Tipo servicio'),1,0,'L');
            $pdf->Cell(30,5,utf8_decode('N° comprobante'),1,0,'L');
            $pdf->Cell(30,5,utf8_decode('Mes de servicio'),1,0,'L');
            $pdf->Cell(20,5,utf8_decode('Aplicación'),1,0,'L');
            $pdf->Cell(25,5,utf8_decode('Vencimiento'),1,0,'L');
            $pdf->Cell(20,5,utf8_decode('Cargo'),1,0,'L');
            $pdf->Cell(20,5,utf8_decode('Abono'),1,0,'L');
            $pdf->Cell(25,5,utf8_decode('CESC cargo'),1,0,'L');
            $pdf->Cell(25,5,utf8_decode('CESC abono'),1,0,'L');
            $pdf->Cell(20,5,utf8_decode('TOTAL'),1,1,'L');
            $pdf->Ln(3);
            $pdf->SetFont('Helvetica','',9);

                    if($tipoServicio === "A") {
                        //var_dump($detallado."ENTRAMOS");
                        //SQL para todas las zonas de cobro
                        /*if ($_POST["lCobrador"] === "todos" && $_POST["lColonia"] === "todas") {
                            $query = "SELECT * FROM tbl_abonos WHERE anulada= '".$anulada."' AND cobradoPor= '".$cobradorR."' AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                            $resultado = $mysqli->query($query);

                        }elseif ($_POST["lCobrador"] === "todos" && $_POST["lColonia"] != "todas") {
                            $query = "SELECT * FROM tbl_abonos WHERE codigoCobrador= '".$cobradorR."' AND anulada= '".$anulada."' AND fechaAbonado BETWEEN '".$desde."' AND '".$hasta."' ORDER BY numeroRecibo ASC";
                            $resultado = $mysqli->query($query);
                        }*/
                    }elseif ($tipoServicio == "C") {
                        foreach ($arrAbonosCable as $abonoC) {
                            $pdf->Cell(25,5,utf8_decode($abonoC['numeroRecibo']),0,0,'L');
                            $pdf->Cell(25,5,utf8_decode($abonoC['tipoServicio']),0,0,'L');
                            $pdf->Cell(30,5,utf8_decode($abonoC['numeroFactura']),0,0,'L');
                            $pdf->Cell(30,5,utf8_decode($abonoC['mesCargo']),0,0,'L');
                            $pdf->Cell(20,5,utf8_decode($abonoC['fechaAbonado']),0,0,'L');
                            $pdf->Cell(25,5,utf8_decode($abonoC['fechaVencimiento']),0,0,'L');
                            $pdf->Cell(20,5,utf8_decode('0.00'),0,0,'L');
                            $pdf->Cell(20,5,utf8_decode($abonoC['cuotaCable']),0,0,'L');
                            $pdf->Cell(25,5,utf8_decode('0.00'),0,0,'L');
                            $pdf->Cell(25,5,number_format($abonoC['totalImpuesto'],2),0,0,'L');
                            $pdf->Cell(20,5,number_format((doubleval($abonoC['cuotaCable'])+doubleval($abonoC['totalImpuesto'])),2),0,1,'L');
                        }
                        foreach ($arrCargosCable as $cargoC) {
                            $pdf->Cell(25,5,utf8_decode($cargoC['numeroRecibo']),0,0,'L');
                            $pdf->Cell(25,5,utf8_decode($cargoC['tipoServicio']),0,0,'L');
                            $pdf->Cell(30,5,utf8_decode($cargoC['numeroFactura']),0,0,'L');
                            $pdf->Cell(30,5,utf8_decode($cargoC['mesCargo']),0,0,'L');
                            $pdf->Cell(20,5,utf8_decode($cargoC['fechaAbonado']),0,0,'L');
                            $pdf->Cell(25,5,utf8_decode($cargoC['fechaVencimiento']),0,0,'L');
                            $pdf->Cell(20,5,utf8_decode('0.00'),0,0,'L');
                            $pdf->Cell(20,5,utf8_decode($cargoC['cuotaCable']),0,0,'L');
                            $pdf->Cell(25,5,utf8_decode('0.00'),0,0,'L');
                            $pdf->Cell(25,5,number_format($cargoC['totalImpuesto'],2),0,0,'L');
                            $pdf->Cell(20,5,number_format((doubleval($cargoC['cuotaCable'])+doubleval($cargoC['totalImpuesto'])),2),0,1,'L');
                        }
                        foreach ($arrEstadoCable as $estado){
                            //$control = $estado['cargoAbono'];
                            if ($estado['estadoCargo'] == 'CANCELADA' && $estado['estadoAbono'] == 'CANCELADA'){
                                $pdf->Cell(25,5,utf8_decode($estado['reciboCargo']),0,0,'L');
                                $pdf->Cell(25,5,utf8_decode($estado['servicioCargo']),0,0,'L');
                                $pdf->Cell(30,5,utf8_decode($estado['facturaCargo']),0,0,'L');
                                $pdf->Cell(30,5,utf8_decode($estado['cargoCargo']),0,0,'L');
                                $pdf->Cell(20,5,utf8_decode($estado['fechaFacturaCargo']),0,0,'L');
                                $pdf->Cell(25,5,utf8_decode($estado['fechaVencimientoCargo']),0,0,'L');
                                $pdf->Cell(20,5,utf8_decode($estado['cuotaCableCargo']),0,0,'L');
                                $pdf->Cell(20,5,utf8_decode('0.00'),0,0,'L');
                                $pdf->Cell(25,5,number_format($estado['totalImpuestoCargo'],2),0,0,'L');
                                $pdf->Cell(25,5,utf8_decode('0.00'),0,0,'L');
                                $pdf->Cell(20,5,number_format((doubleval($estado['cuotaCableCargo'])+doubleval($estado['totalImpuestoCargo'])),2),0,1,'L');

                                /*********************************SEPARACIÓN***************************************/

                                $pdf->Cell(25,5,utf8_decode($estado['reciboAbono']),0,0,'L');
                                $pdf->Cell(25,5,utf8_decode($estado['servicioAbono']),0,0,'L');
                                $pdf->Cell(30,5,utf8_decode($estado['facturaAbono']),0,0,'L');
                                $pdf->Cell(30,5,utf8_decode($estado['cargoAbono']),0,0,'L');
                                $pdf->Cell(20,5,utf8_decode($estado['fechaAbonadoAbono']),0,0,'L');
                                $pdf->Cell(25,5,utf8_decode($estado['fechaVencimientoAbono']),0,0,'L');
                                $pdf->Cell(20,5,utf8_decode('0.00'),0,0,'L');
                                $pdf->Cell(20,5,utf8_decode($estado['cuotaCableAbono']),0,0,'L');
                                $pdf->Cell(25,5,utf8_decode('0.00'),0,0,'L');
                                $pdf->Cell(25,5,number_format($estado['totalImpuestoAbono'],2),0,0,'L');
                                $pdf->Cell(20,5,number_format((doubleval($estado['cuotaCableAbono'])+doubleval($estado['totalImpuestoAbono'])),2),0,1,'L');
                            }
                        }
                        $pdf->SetFont('Helvetica','B',9);
                        $pdf->Cell(235,5,utf8_decode(""),"",0,'R');
                        $pdf->Cell(29,5,utf8_decode("TOTAL A COBRAR"),"B",1,'R');
                        $pdf->Cell(235,5,utf8_decode(""),"",0,'R');
                        $pdf->Cell(29,5,utf8_decode($totalCobrarCable),1,1,'C');
                        $pdf->SetFont('Helvetica','',9);
                    }elseif ($tipoServicio == "I") {
                        foreach ($arrAbonosInter as $abonoI) {
                            $pdf->Cell(25,5,utf8_decode($abonoI['numeroRecibo']),0,0,'L');
                            $pdf->Cell(25,5,utf8_decode($abonoI['tipoServicio']),0,0,'L');
                            $pdf->Cell(30,5,utf8_decode($abonoI['numeroFactura']),0,0,'L');
                            $pdf->Cell(30,5,utf8_decode($abonoI['mesCargo']),0,0,'L');
                            $pdf->Cell(20,5,utf8_decode($abonoI['fechaAbonado']),0,0,'L');
                            $pdf->Cell(25,5,utf8_decode($abonoI['fechaVencimiento']),0,0,'L');
                            $pdf->Cell(20,5,utf8_decode('0.00'),0,0,'L');
                            $pdf->Cell(20,5,utf8_decode($abonoI['cuotaInternet']),0,0,'L');
                            $pdf->Cell(25,5,utf8_decode('0.00'),0,0,'L');
                            $pdf->Cell(25,5,number_format($abonoI['totalImpuesto'],2),0,0,'L');
                            $pdf->Cell(20,5,number_format((doubleval($abonoI['cuotaInternet'])+doubleval($abonoI['totalImpuesto'])),2),0,1,'L');
                        }
                        foreach ($arrCargosInter as $cargoI) {
                            $pdf->Cell(25,5,utf8_decode($cargoI['numeroRecibo']),0,0,'L');
                            $pdf->Cell(25,5,utf8_decode($cargoI['tipoServicio']),0,0,'L');
                            $pdf->Cell(30,5,utf8_decode($cargoI['numeroFactura']),0,0,'L');
                            $pdf->Cell(30,5,utf8_decode($cargoI['mesCargo']),0,0,'L');
                            $pdf->Cell(20,5,utf8_decode($cargoI['fechaAbonado']),0,0,'L');
                            $pdf->Cell(25,5,utf8_decode($cargoI['fechaVencimiento']),0,0,'L');
                            $pdf->Cell(20,5,utf8_decode('0.00'),0,0,'L');
                            $pdf->Cell(20,5,utf8_decode($cargoI['cuotaInternet']),0,0,'L');
                            $pdf->Cell(25,5,utf8_decode('0.00'),0,0,'L');
                            $pdf->Cell(25,5,number_format($cargoI['totalImpuesto'],2),0,0,'L');
                            $pdf->Cell(20,5,number_format((doubleval($cargoI['cuotaInternet'])+doubleval($cargoI['totalImpuesto'])),2),0,1,'L');
                        }
                        foreach ($arrEstadoInter as $estado){
                            //$control = $estado['cargoAbono'];
                            if ($estado['estadoCargo'] == 'CANCELADA' && $estado['estadoAbono'] == 'CANCELADA'){
                                $pdf->Cell(25,5,utf8_decode($estado['reciboCargo']),0,0,'L');
                                $pdf->Cell(25,5,utf8_decode($estado['servicioCargo']),0,0,'L');
                                $pdf->Cell(30,5,utf8_decode($estado['facturaCargo']),0,0,'L');
                                $pdf->Cell(30,5,utf8_decode($estado['cargoCargo']),0,0,'L');
                                $pdf->Cell(20,5,utf8_decode($estado['fechaFacturaCargo']),0,0,'L');
                                $pdf->Cell(25,5,utf8_decode($estado['fechaVencimientoCargo']),0,0,'L');
                                $pdf->Cell(20,5,utf8_decode($estado['cuotaInterCargo']),0,0,'L');
                                $pdf->Cell(20,5,utf8_decode('0.00'),0,0,'L');
                                $pdf->Cell(25,5,number_format($estado['totalImpuestoCargo'],2),0,0,'L');
                                $pdf->Cell(25,5,utf8_decode('0.00'),0,0,'L');
                                $pdf->Cell(20,5,number_format((doubleval($estado['cuotaInterCargo'])+doubleval($estado['totalImpuestoCargo'])),2),0,1,'L');

                                /*********************************SEPARACIÓN***************************************/

                                $pdf->Cell(25,5,utf8_decode($estado['reciboAbono']),0,0,'L');
                                $pdf->Cell(25,5,utf8_decode($estado['servicioAbono']),0,0,'L');
                                $pdf->Cell(30,5,utf8_decode($estado['facturaAbono']),0,0,'L');
                                $pdf->Cell(30,5,utf8_decode($estado['cargoAbono']),0,0,'L');
                                $pdf->Cell(20,5,utf8_decode($estado['fechaAbonadoAbono']),0,0,'L');
                                $pdf->Cell(25,5,utf8_decode($estado['fechaVencimientoAbono']),0,0,'L');
                                $pdf->Cell(20,5,utf8_decode('0.00'),0,0,'L');
                                $pdf->Cell(20,5,utf8_decode($estado['cuotaInterAbono']),0,0,'L');
                                $pdf->Cell(25,5,utf8_decode('0.00'),0,0,'L');
                                $pdf->Cell(25,5,number_format($estado['totalImpuestoAbono'],2),0,0,'L');
                                $pdf->Cell(20,5,number_format((doubleval($estado['cuotaInterAbono'])+doubleval($estado['totalImpuestoAbono'])),2),0,1,'L');
                            }
                        }
                        $pdf->SetFont('Helvetica','B',9);
                        $pdf->Cell(235,5,utf8_decode(""),"",0,'R');
                        $pdf->Cell(29,5,utf8_decode("TOTAL A COBRAR"),"B",1,'R');
                        $pdf->Cell(235,5,utf8_decode(""),"",0,'R');
                        $pdf->Cell(29,5,utf8_decode($totalCobrarInter),1,1,'C');
                        $pdf->SetFont('Helvetica','',9);
                    }

    /* close connection */
    mysqli_close($mysqli);
    $pdf->Output();

}

abonos();

?>
