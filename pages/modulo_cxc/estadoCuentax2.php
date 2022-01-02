<?php

if(!isset($_SESSION))
{
    session_start([
        'cookie_lifetime' => 86400,
    ]);
}

require("php/getData.php");
require("php/GetAllInfo.php");
require_once 'php/getSaldoReal.php';
$dataInfo = new GetAllInfo();
$arrMunicipios = $dataInfo->getData('tbl_municipios_cxc');
$data = new OrdersInfo();
//$client = new GetClient();
$arrayTecnicos = $data->getTecnicos();
$arrayVendedores = $data->getVendedores();
$arrayActividadesC = $data->getActividadesCable();
$arrayActividadesI = $data->getActividadesInter();
$arrayVelocidades = $data->getVelocidades();
$arrUanC = $dataInfo->getDataUanC($_GET['codigoCliente']);
$arrUanI = $dataInfo->getDataUanI($_GET['codigoCliente']);

if (isset($_POST['submit'])) {
    $desde = $_POST["desde"];
    $hasta = $_POST["hasta"];
    //var_dump("Con SUBMIT");
    $arrCargos = $dataInfo->getDataCargosBy('tbl_cargos', $_GET['codigoCliente'], 'C', $desde, $hasta);
    $arrAbonos = $dataInfo->getDataAbonosBy('tbl_abonos', $_GET['codigoCliente'], 'C', 'CANCELADA', $desde, $hasta);

    $arrCargosI = $dataInfo->getDataCargosBy('tbl_cargos', $_GET['codigoCliente'], 'I', $desde, $hasta);
    $arrAbonosI = $dataInfo->getDataAbonosBy('tbl_abonos', $_GET['codigoCliente'], 'I', 'CANCELADA', $desde, $hasta);

    $arrEstado = $dataInfo->getDataEstadoCable($_GET['codigoCliente'],'C');
    //var_dump($arrCargos);
}else {
    //var_dump("SIN submit, no legaste");
    $arrCargosCable = $dataInfo->getDataCargosGlobal($_GET['codigoCliente'], 'C', 'pendiente');
    $arrCargosInter = $dataInfo->getDataCargosGlobal($_GET['codigoCliente'], 'I', 'pendiente');
    $arrAbonosCable = $dataInfo->getDataAbonosGlobal($_GET['codigoCliente'], 'C', 'CANCELADA');
    $arrAbonosInter = $dataInfo->getDataAbonosGlobal($_GET['codigoCliente'], 'I', 'CANCELADA');

    $arrCargosI = $dataInfo->getDataCargos('tbl_cargos', $_GET['codigoCliente'], 'I');
    $arrAbonosI = $dataInfo->getDataAbonos('tbl_abonos', $_GET['codigoCliente'], 'I', 'CANCELADA');

    $arrEstadoCable = $dataInfo->getDataEstadoCable($_GET['codigoCliente'],'C');
    $arrEstadoInter = $dataInfo->getDataEstadoInter($_GET['codigoCliente'],'I');
}


$getSaldoReal = new GetSaldoReal();
$saldoRealCable = number_format(($getSaldoReal->getSaldoCable($_GET['codigoCliente'])),2);
$saldoRealInter = number_format(($getSaldoReal->getSaldoInter($_GET['codigoCliente'])),2);

$totalCobrarCable = number_format(($getSaldoReal->getTotalCobrarCable($_GET['codigoCliente'])),2);
$totalCobrarInter = number_format(($getSaldoReal->getTotalCobrarInter($_GET['codigoCliente'])),2);

//include database connection
require_once('../../php/connection.php');
$precon = new ConectionDB($_SESSION['db']);
$con = $precon->ConectionDB($_SESSION['db']);
/**************************************************/
if (isset($_GET['codigoCliente'])) {

    // get passed parameter value, in this case, the record ID
    // isset() is a PHP function used to verify if a value is there or not
    $id=isset($_GET['codigoCliente']) ? $_GET['codigoCliente'] : die('ERROR: Record no encontrado.');

    // read current record's data
    try {
        // prepare select query
        $query = "SELECT cod_cliente, nombre, direccion, telefonos, dia_cobro, fecha_ult_pago, id_municipio, prepago, saldo_actual, telefonos, dire_cable, dia_cobro, dire_internet, mactv, mac_modem, serie_modem, id_velocidad, dire_telefonia, recep_modem, trans_modem, ruido_modem, colilla, marca_modem, tecnologia, saldoCable, saldoInternet FROM clientes WHERE cod_cliente = ? LIMIT 0,1";
        $stmt = $con->prepare( $query );

        // this is the first question mark
        $stmt->bindParam(1, $id);

        // execute our query
        $stmt->execute();

        // store retrieved row to a variable
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        /****************** DATOS GENERALES ***********************/
        date_default_timezone_set('America/El_Salvador');
        //$fechaOrdenTrabajo = date_format(date_create(date('Y-m-d')), 'd/m/Y');
        //$idOrdenTrabajo = "";
        //$tipoOrden = "Técnica";
        $diaCobro = $row["dia_cobro"];
        $telefonos = $row["telefonos"];
        $codigoCliente = $row["cod_cliente"];
        $nombreCliente = $row['nombre'];
        $direccion = $row['direccion'];
        $diaCobro = $row['dia_cobro'];
        $fechaUltPago = $row['fecha_ult_pago'];
        $idMunicipio = $row["id_municipio"];
        $saldoCable = $row["saldoCable"];
        $saldoInter = $row["saldoInternet"];
        $direccionCable = $row["dire_cable"];
        $mactv = $row['mactv'];
        $direccionInter = $row["dire_internet"];
        $macModem = $row['mac_modem'];
        $serieModem = $row['serie_modem'];
        $idVelocidad = $row['id_velocidad'];
        $rx = $row['recep_modem'];
        $tx = $row['trans_modem'];
        $snr = $row['ruido_modem'];
        $velocidad = $row['id_velocidad'];
        $colilla = $row['colilla'];
        $marcaModelo = $row['marca_modem'];
        $tecnologia = $row['tecnologia'];
        $fechaTrabajo = "";
        $hora = "";
        $fechaProgramacion = "";
        $coordenadas = "";
        $observaciones = "";
        $nodo = $row['dire_telefonia'];
        $idVendedor = "";
        $recepcionTv = "";

    }

        // show error
    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Cablesat</title>
    <link rel="shortcut icon" href="../images/cablesat.png" />
    <!-- Bootstrap Core CSS -->
    <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Font awesome CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    <link rel="stylesheet" href="../dist/css/custom-principal.css">

    <!-- Morris Charts CSS -->
    <link href="../../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">


</head>

<body style="background-color:#eeeeee;">

<?php
// session_start();
if(!isset($_SESSION["user"])) {
    header('Location: ../login.php');
}
?>
<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Cablesat</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <!-- /.dropdown -->
            <li class="dropdown" style="padding:5px;">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <?php echo "<i class='far fa-user'></i>"." ".$_SESSION['nombres']." ".$_SESSION['apellidos'] ?> <i class="fas fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="perfil.php"><i class="fas fa-user-circle"></i> Perfil</a>
                    </li>
                    <li><a href="config.php"><i class="fas fa-cog"></i> Configuración</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="../../php/logout.php"><i class="fas fa-sign-out-alt"></i></i> Salir</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->
        <!-- /.navbar-static-side -->
    </nav>

    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header text-center" style="border: none;"><b>Estado de cuenta</b></h3>
                    <table class="table table-responsive table-condensed" style="border: none; font-size:12px;">
                        <tbody class="">
                        <tr>
                            <th>Código</th>
                            <td><span class="label label-primary" style="font-size: 12px;"><?php echo $_GET['codigoCliente']; ?></span></td>
                        </tr>
                        <tr>
                            <th>Nombre</th>
                            <td><?php echo $nombreCliente; ?></td>
                            <th>Fecha</th>
                            <td><?php date_default_timezone_set('America/El_Salvador'); echo date('d/m/Y H:i:s') ?></td>
                        </tr>
                        <tr>
                            <th>Domicilio</th>
                            <td><?php echo $direccion; ?></td>
                            <th>Día de cobro</th>
                            <td><?php echo $diaCobro; ?></td>
                        </tr>
                        <tr>
                            <th>Teléfonos</th>
                            <td><?php echo $telefonos?></td>
                            <th>última fecha de pago</th>
                            <td><span class="label label-danger" style="font-size:12px;"><?php echo $fechaUltPago ?></span></td>
                        </tr>
                        </tbody>
                    </table>
                    <ul class="nav nav-tabs nav-justified mt-5" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#cable" role="tab" aria-controls="pills-home" aria-selected="true"><b>CABLE</b></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#internet" role="tab" aria-controls="pills-profile" aria-selected="true"><b>INTERNET</b></a>
                        </li>
                    </ul>

                    <div class="tab-content mt-3 mb-3" id="pills-tabContent" style="font-size: 14px;">
                        <div class="tab-pane fade active" id="cable" role="tabpanel" aria-labelledby="pills-home-tab">
                            <br>
                            <div class="panel panel-primary">
                                <div class="panel-heading">Resumen estado de cuenta cable, <b>saldo actual: <?php echo $saldoRealCable; ?></b></div>
                                <div class="panel-body">
                                    <table id="tablaecc" class="table table-striped table-hover">
                                        <thead>
                                        <th>N° recibo</th>
                                        <th>Tipo servicio</th>
                                        <th>N° comprobante</th>
                                        <th>Mes de servicio</th>
                                        <th>Aplicación</th>
                                        <th>Vencimiento</th>
                                        <th>Cargo</th>
                                        <th>Abono</th>
                                        <th>CESC cargo</th>
                                        <th>CESC abono</th>
                                        <th>TOTAL</th>
                                        </thead>
                                        <tbody>
                                        <div class="row">
                                            <form class="" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'].'?codigoCliente='.$_GET['codigoCliente']); ?>" method="POST">
                                                <div class="col-md-7">
                                                    <div class="col-md-3">
                                                        <button class="btn btn-default btn-block" data-toggle="modal" data-target="#uanC" type="button" name="uan"><i class="fas fa-print"> imprimir</i></button>
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <input class="form-control" type="text" name="desde" placeholder="Desde mes/año">
                                                </div>
                                                <div class="col-md-2">
                                                    <input class="form-control" type="text" name="hasta" placeholder="Hasta mes/año">
                                                </div>
                                                <div class="col-md-1">
                                                    <input class="btn btn-info btn-block" type="submit" name="submit" value="ver">
                                                </div>
                                            </form>
                                        </div>
                                        <?php
                                        foreach ($arrAbonosCable as $abonoC) {

                                            echo "<tr><td class='text-success success'>";
                                            echo $abonoC['numeroRecibo']."</td><td class='text-success success'>";
                                            echo $abonoC['tipoServicio']."</td><td class='text-success success'>";
                                            echo $abonoC['numeroFactura']."</td><td class='text-success success'>";
                                            echo "<span class='label label-primary'>".$abonoC['mesCargo']."</span>"."</td><td class='text-success success'>";
                                            echo "<span class='label label-success'>".$abonoC['fechaAbonado']."</span>"."</td><td class='text-success success'>";
                                            echo "<span class='label label-danger'>".$abonoC['fechaVencimiento']."</span>"."</td><td class='text-success success'>";
                                            echo "0.00"."</td><td class='text-success success'>";
                                            echo $abonoC['cuotaCable']."</td><td class='text-success success'>";
                                            echo "0.00"."</td><td class='text-success success'>";
                                            echo $abonoC['totalImpuesto']."</td><td class='text-success success'>";
                                            echo number_format((doubleval($abonoC['cuotaCable'])+doubleval($abonoC['totalImpuesto'])),2)."</td></tr>";
                                            //$control = $abonoC['mesCargo'];
                                            //break;
                                        }
                                        foreach ($arrCargosCable as $cargoC) {

                                            echo "<tr><td class='text-danger danger'>";
                                            echo $cargoC['numeroRecibo']."</td><td class='text-danger danger'>";
                                            echo $cargoC['tipoServicio']."</td><td class='text-danger danger'>";
                                            echo $cargoC['numeroFactura']."</td><td class='text-danger danger'>";
                                            echo "<span class='label label-primary'>".$cargoC['mesCargo']."</span>"."</td><td class='text-danger danger'>";
                                            echo "<span class='label label-success'>".$cargoC['fechaFactura']."</span>"."</td><td class='text-danger danger'>";
                                            echo "<span class='label label-danger'>".$cargoC['fechaVencimiento']."</span>"."</td><td class='text-danger danger'>";
                                            echo $cargoC['cuotaCable']."</td><td class='text-danger danger'>";
                                            echo "0.00"."</td><td class='text-danger danger'>";
                                            echo $cargoC['totalImpuesto']."</td><td class='text-danger danger'>";
                                            echo "0.00"."</td><td class='text-danger danger'>";

                                            echo number_format((doubleval($cargoC['cuotaCable'])+doubleval($cargoC['totalImpuesto'])),2)."</td></tr>";
                                            //$control = $abonoC['mesCargo'];
                                            //break;
                                        }
                                        foreach ($arrEstadoCable as $estado){
                                            //$control = $estado['cargoAbono'];
                                            if ($estado['estadoCargo'] == 'CANCELADA' && $estado['estadoAbono'] == 'CANCELADA'){

                                                echo "<tr><td class='text-danger danger'>";
                                                echo $estado['reciboCargo']."</td><td class='text-danger danger'>";
                                                echo $estado['servicioCargo']."</td><td class='text-danger danger'>";
                                                echo $estado['facturaCargo']."</td><td class='text-danger danger'>";
                                                echo "<span class='label label-primary'>".$estado['cargoCargo']."</span>"."</td><td class='text-danger danger'>";
                                                echo "<span class='label label-success'>".$estado['fechaFacturaCargo']."</span>"."</td><td class='text-danger danger'>";
                                                echo "<span class='label label-danger'>".$estado['fechaVencimientoCargo']."</span>"."</td><td class='text-danger danger'>";
                                                echo $estado['cuotaCableCargo']."</td><td class='text-danger danger'>";
                                                echo "0.00"."</td><td class='text-danger danger'>";
                                                echo $estado['totalImpuestoCargo']."</td><td class='text-danger danger'>";

                                                echo "0.00"."</td><td class='text-danger danger'>";
                                                echo number_format((doubleval($estado['cuotaCableCargo'])+doubleval($estado['totalImpuestoCargo'])),2)."</td></tr>";
                                                /*********************************SEPARACIÓN***************************************/
                                                echo "<tr><td class='text-success success'>";
                                                echo $estado['reciboAbono']."</td><td class='text-success success'>";
                                                echo $estado['servicioAbono']."</td><td class='text-success success'>";
                                                echo $estado['facturaAbono']."</td><td class='text-success success'>";
                                                echo "<span class='label label-primary'>".$estado['cargoAbono']."</span>"."</td><td class='text-success success'>";
                                                echo "<span class='label label-success'>".$estado['fechaAbonadoAbono']."</span>"."</td><td class='text-success success'>";
                                                echo "<span class='label label-danger'>".$estado['fechaVencimientoAbono']."</span>"."</td><td class='text-success success'>";
                                                echo "0.00"."</td><td class='text-success success'>";
                                                echo $estado['cuotaCableAbono']."</td><td class='text-success success'>";
                                                echo "0.00"."</td><td class='text-success success'>";
                                                echo $estado['totalImpuestoAbono']."</td><td class='text-success success'>";
                                                echo number_format((doubleval($estado['cuotaCableAbono'])+doubleval($estado['totalImpuestoAbono'])),2)."</td></tr>";
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                    <?php echo "<div class='well pull-right'><strong>TOTAL A COBRAR: $".$totalCobrarCable."</strong></div>"; ?>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="internet" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <br>
                            <div class="panel panel-primary">
                                <div class="panel-heading">Resumen estado de cuenta internet, <b>saldo actual: <?php echo $saldoRealInter; ?></b></div>
                                <div class="panel-body">
                                    <table id="tablaeci" class="table table-striped">
                                        <thead>
                                        <th>N° recibo</th>
                                        <th>Tipo servicio</th>
                                        <th>N° comprobante</th>
                                        <th>Mes de servicio</th>
                                        <th>Aplicación</th>
                                        <th>Vencimiento</th>
                                        <th>Cargo</th>
                                        <th>Abono</th>
                                        <th>CESC cargo</th>
                                        <th>CESC abono</th>
                                        <th>TOTAL</th>

                                        </thead>
                                        <tbody>
                                        <div class="row">
                                            <form class="" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'].'?codigoCliente='.$_GET['codigoCliente']); ?>" method="POST">
                                                <div class="col-md-7">
                                                    <div class="col-md-3">
                                                        <button class="btn btn-default btn-block" data-toggle="modal" data-target="#uanI" type="button" name="uan"><i class="fas fa-print"> imprimir</i></button>
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <input class="form-control" type="text" name="desde" placeholder="Desde mes/año">
                                                </div>
                                                <div class="col-md-2">
                                                    <input class="form-control" type="text" name="hasta" placeholder="Hasta mes/año">
                                                </div>
                                                <div class="col-md-1">
                                                    <input class="btn btn-info btn-block" type="submit" name="submit" value="ver">
                                                </div>
                                            </form>
                                        </div>
                                        <?php
                                        foreach ($arrAbonosInter as $abonoI) {

                                            echo "<tr><td class='text-success success'>";
                                            echo $abonoI['numeroRecibo']."</td><td class='text-success success'>";
                                            echo $abonoI['tipoServicio']."</td><td class='text-success success'>";
                                            echo $abonoI['numeroFactura']."</td><td class='text-success success'>";
                                            echo "<span class='label label-primary'>".$abonoI['mesCargo']."</span>"."</td><td class='text-success success'>";
                                            echo "<span class='label label-success'>".$abonoI['fechaAbonado']."</span>"."</td><td class='text-success success'>";
                                            echo "<span class='label label-danger'>".$abonoI['fechaVencimiento']."</span>"."</td><td class='text-success success'>";
                                            echo "0.00"."</td><td class='text-success success'>";
                                            echo $abonoI['cuotaInternet']."</td><td class='text-success success'>";
                                            echo "0.00"."</td><td class='text-success success'>";
                                            echo $abonoI['totalImpuesto']."</td><td class='text-success success'>";
                                            echo number_format((doubleval($abonoI['cuotaInternet'])+doubleval($abonoI['totalImpuesto'])),2)."</td></tr>";
                                            //$control = $abonoC['mesCargo'];
                                            //break;
                                        }
                                        foreach ($arrCargosInter as $cargoI) {

                                            echo "<tr><td class='text-danger danger'>";
                                            echo $cargoI['numeroRecibo']."</td><td class='text-danger danger'>";
                                            echo $cargoI['tipoServicio']."</td><td class='text-danger danger'>";
                                            echo $cargoI['numeroFactura']."</td><td class='text-danger danger'>";
                                            echo "<span class='label label-primary'>".$cargoI['mesCargo']."</span>"."</td><td class='text-danger danger'>";
                                            echo "<span class='label label-success'>".$cargoI['fechaFactura']."</span>"."</td><td class='text-danger danger'>";
                                            echo "<span class='label label-danger'>".$cargoI['fechaVencimiento']."</span>"."</td><td class='text-danger danger'>";
                                            echo $cargoI['cuotaInternet']."</td><td class='text-danger danger'>";
                                            echo "0.00"."</td><td class='text-danger danger'>";
                                            echo $cargoI['totalImpuesto']."</td><td class='text-danger danger'>";
                                            echo "0.00"."</td><td class='text-danger danger'>";

                                            echo number_format((doubleval($cargoI['cuotaInternet'])+doubleval($cargoI['totalImpuesto'])),2)."</td></tr>";
                                            //$control = $abonoC['mesCargo'];
                                            //break;
                                        }
                                        foreach ($arrEstadoInter as $estado){
                                            //$control = $estado['cargoAbono'];
                                            if ($estado['estadoCargo'] == 'CANCELADA' && $estado['estadoAbono'] == 'CANCELADA'){

                                                echo "<tr><td class='text-danger danger'>";
                                                echo $estado['reciboCargo']."</td><td class='text-danger danger'>";
                                                echo $estado['servicioCargo']."</td><td class='text-danger danger'>";
                                                echo $estado['facturaCargo']."</td><td class='text-danger danger'>";
                                                echo "<span class='label label-primary'>".$estado['cargoCargo']."</span>"."</td><td class='text-danger danger'>";
                                                echo "<span class='label label-success'>".$estado['fechaFacturaCargo']."</span>"."</td><td class='text-danger danger'>";
                                                echo "<span class='label label-danger'>".$estado['fechaVencimientoCargo']."</span>"."</td><td class='text-danger danger'>";
                                                echo $estado['cuotaInterCargo']."</td><td class='text-danger danger'>";
                                                echo "0.00"."</td><td class='text-danger danger'>";
                                                echo $estado['totalImpuestoCargo']."</td><td class='text-danger danger'>";

                                                echo "0.00"."</td><td class='text-danger danger'>";
                                                echo number_format((doubleval($estado['cuotaInterCargo'])+doubleval($estado['totalImpuestoCargo'])),2)."</td></tr>";
                                                /*********************************SEPARACIÓN***************************************/
                                                echo "<tr><td class='text-success success'>";
                                                echo $estado['reciboAbono']."</td><td class='text-success success'>";
                                                echo $estado['servicioAbono']."</td><td class='text-success success'>";
                                                echo $estado['facturaAbono']."</td><td class='text-success success'>";
                                                echo "<span class='label label-primary'>".$estado['cargoAbono']."</span>"."</td><td class='text-success success'>";
                                                echo "<span class='label label-success'>".$estado['fechaAbonadoAbono']."</span>"."</td><td class='text-success success'>";
                                                echo "<span class='label label-danger'>".$estado['fechaVencimientoAbono']."</span>"."</td><td class='text-success success'>";
                                                echo "0.00"."</td><td class='text-success success'>";
                                                echo $estado['cuotaInterAbono']."</td><td class='text-success success'>";
                                                echo "0.00"."</td><td class='text-success success'>";
                                                echo $estado['totalImpuestoAbono']."</td><td class='text-success success'>";
                                                echo number_format((doubleval($estado['cuotaInterAbono'])+doubleval($estado['totalImpuestoAbono'])),2)."</td></tr>";
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                    <?php echo "<div class='well pull-right'><strong>TOTAL A COBRAR: $".$totalCobrarInter."</strong></div>"; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div id="uanC" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-lg">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Próximamente</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="datos">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Modal -->
                    <div id="uanI" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-lg">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Próximamente</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="datos">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="../../vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="../../vendor/metisMenu/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="../../dist/js/sb-admin-2.js"></script>

<!-- DataTables JavaScript -->
<script src="../../vendor/datatables/js/dataTables.bootstrap.js"></script>
<script src="../../vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="../../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="../../vendor/datatables-responsive/dataTables.responsive.js"></script>

<script>
    $(document).ready(function() {
        $('#tablaecc').DataTable({
            pageLength : 6,
            lengthMenu: [[6, 10, 20, -1], [6, 10, 20, 'Todos']],
            "searching": false,
            "ordering": false,
            responsive: false,
            "paging": true,
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontró ningún registro",
                "info": "Mostrando _TOTAL_ de _MAX_ Registros",
                "infoEmpty": "No se encontró ningún registro",
                "search": "Buscar: ",
                "searchPlaceholder": "",
                "infoFiltered": "(de un total de _MAX_ registros)",
                "paginate": {
                    "previous": "Anterior",
                    "next": "Siguiente",

                }
            }

        });

    });
</script>
<script>
    $(document).ready(function() {
        $('#tablaeci').DataTable({
            pageLength : 6,
            lengthMenu: [[6, 10, 20, -1], [6, 10, 20, 'Todos']],
            "searching": false,
            "ordering": false,
            responsive: false,
            "paging": true,
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontró ningún registro",
                "info": "Mostrando _TOTAL_ de _MAX_ Registros",
                "infoEmpty": "No se encontró ningún registro",
                "search": "Buscar: ",
                "searchPlaceholder": "",
                "infoFiltered": "(de un total de _MAX_ registros)",
                "paginate": {
                    "previous": "Anterior",
                    "next": "Siguiente",

                }
            }

        });

    });
</script>

</body>

</html>