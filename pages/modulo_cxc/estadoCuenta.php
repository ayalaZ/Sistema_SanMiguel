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
require_once("../../php/config.php");
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
//megas
$host = DB_HOST;
$user = DB_USER;
$password = DB_PASSWORD;
$database = $_SESSION['db'];
$mysqli = new mysqli($host, $user, $password, $database);
$codigo = $_GET['codigoCliente'];
$query = "SELECT tbl_velocidades.nombreVelocidad FROM clientes INNER JOIN tbl_velocidades ON clientes.id_velocidad = tbl_velocidades.idVelocidad WHERE cod_cliente = '$codigo'";
$resultado = $mysqli->query($query);
$datos = $resultado->fetch_array();

if (isset($_POST['submit'])) {
    $desde = $_POST["desde"];
    $hasta = $_POST["hasta"];
    //var_dump("Con SUBMIT");
    //$arrCargos = $dataInfo->getDataCargosBy('tbl_cargos', $_GET['codigoCliente'], 'C', $desde, $hasta);
    //$arrAbonos = $dataInfo->getDataAbonosBy('tbl_abonos', $_GET['codigoCliente'], 'C', 'CANCELADA', $desde, $hasta);
    $arrCargosCable = $dataInfo->getDataCargosGlobalF($_GET['codigoCliente'], 'C', 'pendiente', $desde, $hasta);
    $arrCargosInter = $dataInfo->getDataCargosGlobalF($_GET['codigoCliente'], 'I', 'pendiente', $desde, $hasta);
    $arrAbonosCable = $dataInfo->getDataAbonosGlobalF($_GET['codigoCliente'], 'C', 'CANCELADA', $desde, $hasta);
    $arrAbonosInter = $dataInfo->getDataAbonosGlobalF($_GET['codigoCliente'], 'I', 'CANCELADA', $desde, $hasta);
    //$arrCargosI = $dataInfo->getDataCargosBy('tbl_cargos', $_GET['codigoCliente'], 'I', $desde, $hasta);
    //$arrAbonosI = $dataInfo->getDataAbonosBy('tbl_abonos', $_GET['codigoCliente'], 'I', 'CANCELADA', $desde, $hasta);
    $arrEstadoCable = $dataInfo->getDataEstadoCableF($_GET['codigoCliente'],'C', $desde, $hasta);
    $arrEstadoInter = $dataInfo->getDataEstadoInterF($_GET['codigoCliente'],'I', $desde, $hasta);
    //$arrEstado = $dataInfo->getDataEstadoCable($_GET['codigoCliente'],'C');
    //var_dump($arrCargos);
}else {
    //var_dump("SIN submit, no legaste");
    $arrCargosCable = $dataInfo->getDataCargosGlobal($_GET['codigoCliente'], 'C', 'pendiente');
    $arrCargosInter = $dataInfo->getDataCargosGlobal($_GET['codigoCliente'], 'I', 'pendiente');
    $arrAbonosCable = $dataInfo->getDataAbonosGlobal($_GET['codigoCliente'], 'C', 'CANCELADA');
    $arrAbonosInter = $dataInfo->getDataAbonosGlobal($_GET['codigoCliente'], 'I', 'CANCELADA');

    //$arrCargosI = $dataInfo->getDataCargos('tbl_cargos', $_GET['codigoCliente'], 'I');
    //$arrAbonosI = $dataInfo->getDataAbonos('tbl_abonos', $_GET['codigoCliente'], 'I', 'CANCELADA');

    $arrEstadoCable = $dataInfo->getDataEstadoCable($_GET['codigoCliente'],'C');
    $arrEstadoInter = $dataInfo->getDataEstadoInter($_GET['codigoCliente'],'I');
}


$getSaldoReal = new GetSaldoReal();
$saldoRealCable = number_format(($getSaldoReal->getSaldoCable($_GET['codigoCliente'])),2);
$saldoRealInter = number_format(($getSaldoReal->getSaldoInter($_GET['codigoCliente'])),2);

$totalCobrarCable = number_format(($getSaldoReal->getTotalCobrarCable($_GET['codigoCliente'])),2);
$totalCobrarInter = number_format(($getSaldoReal->getTotalCobrarInter($_GET['codigoCliente'])),2);

$totalCobrarCable = number_format(($getSaldoReal->getTotalCobrarCable($_GET['codigoCliente'])),2);
$totalCobrarInter = number_format(($getSaldoReal->getTotalCobrarInter($_GET['codigoCliente'])),2);

$servicioC = $getSaldoReal->detServC($_GET['codigoCliente']);
$servicioI = $getSaldoReal->detServI($_GET['codigoCliente']);

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
        $query = "SELECT cod_cliente, nombre, direccion, telefonos, dia_cobro, fecha_ult_pago, id_municipio, prepago, saldo_actual, telefonos, dire_cable, dia_cobro, dire_internet, mactv, mac_modem, serie_modem, id_velocidad, dire_telefonia, recep_modem, trans_modem, ruido_modem, colilla, marca_modem, tecnologia, saldoCable, saldoInternet, M1, M2, M3, Pago1, Pago2, Pago3, Pago4, Pago5, Pago6 FROM clientes WHERE cod_cliente = ? LIMIT 0,1";
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
        $m1 = $row['M1'];
        $m2 = $row['M2'];
        $m3 = $row['M3'];
        $pago1 = $row['Pago1'];
        $pago2 = $row['Pago2'];
        $pago3 = $row['Pago3'];
        $pago4 = $row['Pago4'];
        $pago5 = $row['Pago5'];
        $pago6 = $row['Pago6'];

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

    <!-- Morris Charts CSS -->
    <link href="../../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <style media="screen">
        .form-control {
            color: #212121;
            font-size: 15px;
            font-weight: bold;

        }
        .nav>li>a {
            color: #fff;
        }
        .nav>li>a:hover {
            color: #2b2b2b;
        }
        .dark{
            color: #fff;
            background-color: #212121;
        }

        .nav-tabs.nav-justified>li>a {
                border-bottom: 1px solid #ddd;
                border-radius: 20px 20px 0 0;
                background-color: #d32f2f;
            }
        .danger .success{
            background-color: #F5F5F5;
        }
    </style>

    <style media="screen">
        .nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover {
            color: #fff;
            background-color: #d32f2f;
        }

        .nav-pills>li>a{
             color: #d32f2f;

         }

        .btn-danger {
            color: #fff;
            background-color: #d32f2f;
            border-color: #d43f3a;
        }
        .label-danger {
            background-color: #d32f2f;
        }

        .panel-danger>.panel-heading {
            color: #fff;
            background-color: #212121;
            border-color: #212121;
        }
        .panel{
            border-color: #212121;
        }
        .pagination>.active>a{
            background-color: #d32f2f;
            border-color: #d32f2f;
        }
        .pagination>.active>a:hover{
            background-color: #d32f2f;
            border-color: #d32f2f;
        }
        .pagination>li>a, .pagination>li>a:hover{
            color: #2b2b2b;
        }
    </style>
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
                <h3 class="page-header text-center" style="border: none; padding: 0; margin: 0; margin-top: 5px;"><b>Estado de cuenta</b></h3>
                <button onclick="history.back()" class="btn btn-danger pull-right"><i class="fas fa-arrow-alt-circle-left"></i> Regresar</button>
                    <div class="col-md-9">
                        <tr>
                            <b>Código</b>
                            <td><span class="label label-danger" style="font-size: 12px;"><?php echo $_GET['codigoCliente']; ?></span></td>
                            <br>
                        </tr>
                        <tr>
                            <b>Nombre</b>
                            <td><?php echo $nombreCliente; ?></td>
                            <br>
                        </tr>
                        <tr>
                            <b>Domicilio</b>
                            <td><?php echo substr($direccion, 0, 135); ?></td>
                            <br>
                        </tr>
                        <tr>
                            <b>Teléfonos</b>
                            <td><?php echo $telefonos?></td>
                            <br>
                        </tr>
                        <tr>
                            <b>Megas</b>
                            <td><?php echo $datos['nombreVelocidad'] ?></td>
                        </tr>
                        <form action="php/editarEstadoCuenta.php?codigoCliente=<?php echo $_GET['codigoCliente'] ?>" method="POST">
                            <tr>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <b>C</b>&nbsp;&nbsp;
                                <b>I</b>
                                <br>
                            </tr>
                            <tr>
                                <b>MARZO </b>&nbsp;
                                <?php
                                if ($m1 === "T"){
                                    echo '<td><input type="checkbox" name="m1" value="T" checked>&nbsp;</td>';
                                }else{
                                    echo '<td><input type="checkbox" name="m1" value="T">&nbsp;</td>';
                                }
                                if ($pago1 === "T"){
                                    echo '<td><input type="checkbox" name="pago1" value="T" checked>&nbsp;</td>';
                                }else{
                                    echo '<td><input type="checkbox" name="pago1" value="T">&nbsp;</td>';
                                }
                                if ($pago4 === "T"){
                                    echo '<td><input type="checkbox" name="pago4" value="T" checked>&nbsp;</td>';
                                }else{
                                    echo '<td><input type="checkbox" name="pago4" value="T">&nbsp;</td>';
                                }
                                ?>
                                <br>
                            </tr>
                            <tr>
                                <b>ABRIL </b>&nbsp;&nbsp;&nbsp;
                                <?php
                                if ($m2 === "T"){
                                    echo '<td><input type="checkbox" name="m2" value="T" checked>&nbsp;</td>';
                                }else{
                                    echo '<td><input type="checkbox" name="m2" value="T">&nbsp;</td>';
                                }
                                if ($pago2 === "T"){
                                    echo '<td><input type="checkbox" name="pago2" value="T" checked>&nbsp;</td>';
                                }else{
                                    echo '<td><input type="checkbox" name="pago2" value="T">&nbsp;</td>';
                                }
                                if ($pago5 === "T"){
                                    echo '<td><input type="checkbox" name="pago5" value="T" checked>&nbsp;</td>';
                                }else{
                                    echo '<td><input type="checkbox" name="pago5" value="T">&nbsp;</td>';
                                }
                                ?>
                                <br>
                            </tr>
                            <tr>
                                <b>MAYO </b>&nbsp;&nbsp;&nbsp;&nbsp;
                                <?php
                                if ($m3 === "T"){
                                    echo '<td><input type="checkbox" name="m3" value="T" checked>&nbsp;</td>';
                                }else{
                                    echo '<td><input type="checkbox" name="m3" value="T">&nbsp;</td>';
                                }
                                if ($pago3 === "T"){
                                    echo '<td><input type="checkbox" name="pago3" value="T" checked>&nbsp;</td>';
                                }else{
                                    echo '<td><input type="checkbox" name="pago3" value="T">&nbsp;</td>';
                                }
                                if ($pago6 === "T"){
                                    echo '<td><input type="checkbox" name="pago6" value="T" checked>&nbsp;</td>';
                                }else{
                                    echo '<td><input type="checkbox" name="pago6" value="T">&nbsp;</td>';
                                }
                                ?>
                                <br>
                            </tr>
                            <tr>
                                <td colspan="3"><input class="btn btn-default" type="submit" value="actualizar"></td>
                            </tr>
                        </form>
                    </div><!--ACA TERMINA COLUMNA 9-->
                    <div class="col-md-3">
                        <table class="table table-responsive table-condensed" style="border: none; font-size:12px;">
                            <tbody class="">
                            <tr>
                                <?php
                                if ($servicioC == "Activo"){
                                    echo '<td>CABLE: <span class="label label-success" style="font-size: 12px;">Activo</span></td>';
                                }elseif ($servicioC == "Sin servicio"){
                                    echo '<td>CABLE: <span class="label label-default" style="font-size: 12px;">Sin servicio</span></td>';
                                }elseif ($servicioC == "Suspendido"){
                                    echo '<td>CABLE: <span class="label label-danger" style="font-size: 12px;">Suspendido</span></td>';
                                }
                                ?>

                                <?php
                                if ($servicioI == "Activo"){
                                    echo '<td>INTERNET: <span class="label label-success" style="font-size: 12px;">Activo</span></td>';
                                }elseif ($servicioI == "Sin servicio"){
                                    echo '<td>INTERNET: <span class="label label-default" style="font-size: 12px;">Sin servicio</span></td>';
                                }elseif ($servicioI == "Suspendido"){
                                    echo '<td>INTERNET: <span class="label label-danger" style="font-size: 12px;">Suspendido</span></td>';
                                }
                                ?>
                            </tr>
                            <tr>
                                <th>Fecha</th>
                                <td><?php date_default_timezone_set('America/El_Salvador'); echo date('d/m/Y H:i:s') ?></td>
                                <br>
                            </tr>
                            <tr>
                                <th>Día de cobro</th>
                                <td><?php echo $diaCobro; ?></td>
                                <br>
                            </tr>
                            <tr>
                                <th>último mes cancelado</th>
                                <td><span class="label label-danger" style="font-size:12px;"><?php echo $fechaUltPago ?></span></td>
                            </tr>
                            </tbody>
                        </table>
                    </div><!--ACA TERMINA COLUMNA 3-->

                <div class="col-lg-12">
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
                            <div class="panel panel-danger">
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
                                                    <input class="btn btn-danger btn-block" type="submit" name="submit" value="ver">
                                                </div>
                                            </form>
                                        </div>
                                        <?php
                                        foreach ($arrAbonosCable as $abonoC) {
                                            echo "<tr><td class='text'>";
                                            echo $abonoC['numeroRecibo']."</td><td class='text'>";
                                            echo $abonoC['tipoServicio']."</td><td class='text'>";
                                            echo $abonoC['numeroFactura']."</td><td class='text'>";
                                            echo "<span class='label label-success'>".$abonoC['mesCargo']."</span>"."</td><td class='text'>";
                                            echo "<span class='label label-default'>".$abonoC['fechaAbonado']."</span>"."</td><td class='text'>";
                                            echo "<span class='label label-default'>".$abonoC['fechaVencimiento']."</span>"."</td><td class='text'>";
                                            echo "0.00"."</td><td class='text'>";
                                            echo number_format($abonoC['cuotaCable'],2)."</td><td class='text'>";
                                            echo "0.00"."</td><td class='text'>";
                                            echo number_format($abonoC['totalImpuesto'],2)."</td><td class='text'>";
                                            echo number_format((doubleval($abonoC['cuotaCable'])+doubleval($abonoC['totalImpuesto'])),2)."</td></tr>";
                                            //$control = $abonoC['mesCargo'];
                                            //break;
                                        }
                                        foreach ($arrCargosCable as $cargoC) {
                                            echo "<tr><td class='text-danger'>";
                                            echo $cargoC['numeroRecibo']."</td><td class='text-danger'>";
                                            echo $cargoC['tipoServicio']."</td><td class='text-danger'>";
                                            echo $cargoC['numeroFactura']."</td><td class='text-danger'>";
                                            echo "<span class='label label-danger'>".$cargoC['mesCargo']."</span>"."</td><td class='text-danger'>";
                                            echo "<span class='label label-default'>".$cargoC['fechaFactura']."</span>"."</td><td class='text-danger'>";
                                            echo "<span class='label label-default'>".$cargoC['fechaVencimiento']."</span>"."</td><td class='text-danger'>";
                                            echo number_format($cargoC['cuotaCable'],2)."</td><td class='text-danger'>";
                                            echo "0.00"."</td><td class='text-danger'>";
                                            echo number_format($cargoC['totalImpuesto'],2)."</td><td class='text-danger'>";
                                            echo "0.00"."</td><td class='text-danger'>";

                                            echo number_format((doubleval($cargoC['cuotaCable'])+doubleval($cargoC['totalImpuesto'])),2)."</td></tr>";
                                            //$control = $abonoC['mesCargo'];
                                            //break;
                                        }
                                        foreach ($arrEstadoCable as $estado){
                                            //$control = $estado['cargoAbono'];
                                            if ($estado['estadoCargo'] == 'CANCELADA' && $estado['estadoAbono'] == 'CANCELADA'){
                                                echo "<tr><td class='text-danger'>";
                                                echo $estado['reciboCargo']."</td><td class='text-danger'>";
                                                echo $estado['servicioCargo']."</td><td class='text-danger'>";
                                                echo $estado['facturaCargo']."</td><td class='text-danger'>";
                                                echo "<span class='label label-danger'>".$estado['cargoCargo']./*" "."<i class='fas fa-arrow-down'></i>".*/"</span>"."</td><td class='text-danger'>";
                                                echo "<span class='label label-default'>".$estado['fechaFacturaCargo']."</span>"."</td><td class='text-danger'>";
                                                echo "<span class='label label-default'>".$estado['fechaVencimientoCargo']."</span>"."</td><td class='text-danger'>";
                                                echo number_format($estado['cuotaCableCargo'],2)."</td><td class='text-danger'>";
                                                echo "0.00"."</td><td class='text-danger'>";
                                                echo number_format($estado['totalImpuestoCargo'],2)."</td><td class='text-danger'>";

                                                echo "0.00"."</td><td class='text-danger'>";
                                                echo number_format((doubleval($estado['cuotaCableCargo'])+doubleval($estado['totalImpuestoCargo'])),2)."</td></tr>";
                                                /*********************************SEPARACIÓN***************************************/
                                                echo "<tr><td class='text'>";
                                                echo $estado['reciboAbono']."</td><td class='text'>";
                                                echo $estado['servicioAbono']."</td><td class='text'>";
                                                echo $estado['facturaAbono']."</td><td class='text'>";
                                                echo "<span class='label label-success'>".$estado['cargoAbono']./*" "."<i class='fas fa-arrow-up'></i>".*/"</span>"."</td><td class='text'>";
                                                echo "<span class='label label-default'>".$estado['fechaAbonadoAbono']."</span>"."</td><td class='text'>";
                                                echo "<span class='label label-default'>".$estado['fechaVencimientoAbono']."</span>"."</td><td class='text'>";
                                                echo "0.00"."</td><td class='text'>";
                                                echo number_format($estado['cuotaCableAbono'],2)."</td><td class='text'>";
                                                echo "0.00"."</td><td class='text'>";
                                                echo number_format($estado['totalImpuestoAbono'],2)."</td><td class='text'>";
                                                echo number_format((doubleval($estado['cuotaCableAbono'])+doubleval($estado['totalImpuestoAbono'])),2)."</td></tr>";
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                    <?php echo "<div class='alert alert-danger pull-right'><strong>TOTAL A COBRAR: $".$totalCobrarCable."</strong></div>"; ?>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="internet" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <br>
                            <div class="panel panel-danger">
                                <div class="panel-heading">Resumen estado de cuenta internet, <b>saldo actual: <?php echo $saldoRealInter; ?></b></div>
                                <div class="panel-body">
                                    <table id="tablaeci" class="table table-striped table-hover">
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
                                                    <input class="btn btn-danger btn-block" type="submit" name="submit" value="ver">
                                                </div>
                                            </form>
                                        </div>
                                        <?php
                                        foreach ($arrAbonosInter as $abonoI) {
                                            echo "<tr><td class='text'>";
                                            echo $abonoI['numeroRecibo']."</td><td class='text'>";
                                            echo $abonoI['tipoServicio']."</td><td class='text'>";
                                            echo $abonoI['numeroFactura']."</td><td class='text'>";
                                            echo "<span class='label label-success'>".$abonoI['mesCargo']."</span>"."</td><td class='text'>";
                                            echo "<span class='label label-default'>".$abonoI['fechaAbonado']."</span>"."</td><td class='text'>";
                                            echo "<span class='label label-default'>".$abonoI['fechaVencimiento']."</span>"."</td><td class='text'>";
                                            echo "0.00"."</td><td class='text'>";
                                            echo number_format($abonoI['cuotaInternet'],2)."</td><td class='text'>";
                                            echo "0.00"."</td><td class='text'>";
                                            echo number_format($abonoI['totalImpuesto'],2)."</td><td class='text'>";
                                            echo number_format((doubleval($abonoI['cuotaInternet'])+doubleval($abonoI['totalImpuesto'])),2)."</td></tr>";
                                            //$control = $abonoC['mesCargo'];
                                            //break;
                                        }
                                        foreach ($arrCargosInter as $cargoI) {
                                            echo "<tr><td class='text-danger'>";
                                            echo $cargoI['numeroRecibo']."</td><td class='text-danger'>";
                                            echo $cargoI['tipoServicio']."</td><td class='text-danger'>";
                                            echo $cargoI['numeroFactura']."</td><td class='text-danger'>";
                                            echo "<span class='label label-danger'>".$cargoI['mesCargo']."</span>"."</td><td class='text-danger'>";
                                            echo "<span class='label label-default'>".$cargoI['fechaFactura']."</span>"."</td><td class='text-danger'>";
                                            echo "<span class='label label-default'>".$cargoI['fechaVencimiento']."</span>"."</td><td class='text-danger'>";
                                            echo number_format($cargoI['cuotaInternet'],2)."</td><td class='text-danger'>";
                                            echo "0.00"."</td><td class='text-danger'>";
                                            echo number_format($cargoI['totalImpuesto'],2)."</td><td class='text-danger'>";
                                            echo "0.00"."</td><td class='text-danger'>";

                                            echo number_format((doubleval($cargoI['cuotaInternet'])+doubleval($cargoI['totalImpuesto'])),2)."</td></tr>";
                                            //$control = $abonoC['mesCargo'];
                                            //break;
                                        }
                                        foreach ($arrEstadoInter as $estado){
                                            //$control = $estado['cargoAbono'];
                                            if ($estado['estadoCargo'] == 'CANCELADA' && $estado['estadoAbono'] == 'CANCELADA'){
                                                echo "<tr><td class='text-danger'>";
                                                echo $estado['reciboCargo']."</td><td class='text-danger'>";
                                                echo $estado['servicioCargo']."</td><td class='text-danger'>";
                                                echo $estado['facturaCargo']."</td><td class='text-danger'>";
                                                echo "<span class='label label-danger'>".$estado['cargoCargo']."</span>"."</td><td class='text-danger'>";
                                                echo "<span class='label label-default'>".$estado['fechaFacturaCargo']."</span>"."</td><td class='text-danger'>";
                                                echo "<span class='label label-default'>".$estado['fechaVencimientoCargo']."</span>"."</td><td class='text-danger'>";
                                                echo number_format($estado['cuotaInterCargo'],2)."</td><td class='text-danger'>";
                                                echo "0.00"."</td><td class='text-danger'>";
                                                echo number_format($estado['totalImpuestoCargo'],2)."</td><td class='text-danger'>";

                                                echo "0.00"."</td><td class='text-danger'>";
                                                echo number_format((doubleval($estado['cuotaInterCargo'])+doubleval($estado['totalImpuestoCargo'])),2)."</td></tr>";
                                                /*********************************SEPARACIÓN***************************************/
                                                echo "<tr><td class='text'>";
                                                echo $estado['reciboAbono']."</td><td class='text'>";
                                                echo $estado['servicioAbono']."</td><td class='text'>";
                                                echo $estado['facturaAbono']."</td><td class='text'>";
                                                echo "<span class='label label-success'>".$estado['cargoAbono']."</span>"."</td><td class='text'>";
                                                echo "<span class='label label-default'>".$estado['fechaAbonadoAbono']."</span>"."</td><td class='text'>";
                                                echo "<span class='label label-default'>".$estado['fechaVencimientoAbono']."</span>"."</td><td class='text'>";
                                                echo "0.00"."</td><td class='text'>";
                                                echo number_format($estado['cuotaInterAbono'],2)."</td><td class='text'>";
                                                echo "0.00"."</td><td class='text'>";
                                                echo number_format($estado['totalImpuestoAbono'],2)."</td><td class='text'>";
                                                echo number_format((doubleval($estado['cuotaInterAbono'])+doubleval($estado['totalImpuestoAbono'])),2)."</td></tr>";
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                    <?php echo "<div class='alert alert-danger pull-right'><strong>TOTAL A COBRAR: $".$totalCobrarInter."</strong></div>"; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div id="uanC" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-xs">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Imprimir estado de cuenta</h4>
                                </div>
                                <div class="modal-body">
                                <form action="php/estadoCuentaImp.php?codigoCliente=<?php echo $_GET['codigoCliente'];?>" method="POST">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="ecDesde">Desde</label>
                                            <input class="form-control" type="text" name="ecDesde" value="<?php echo date('Y-m-d', strtotime("-1 years", strtotime(date('Y-m-01')))); ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="ecHasta">Hasta</label>
                                            <input class="form-control" type="text" name="ecHasta" value="<?php echo date('Y-m-30'); ?>">
                                            <input class="form-control" type="hidden" name="tipoServicio" value="<?php echo 'C'; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">Generar</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div id="uanI" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-xs">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Imprimir estado de cuenta</h4>
                                </div>
                                <div class="modal-body">
                                <form action="php/estadoCuentaImp.php?codigoCliente=<?php echo $_GET['codigoCliente'];?>" method="POST">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="ecDesde">Desde</label>
                                            <input class="form-control" type="text" name="ecDesde" value="<?php echo date('Y-m-d', strtotime("-1 years", strtotime(date('Y-m-01')))); ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="ecHasta">Hasta</label>
                                            <input class="form-control" type="text" name="ecHasta" value="<?php echo date('Y-m-30'); ?>">
                                            <input class="form-control" type="hidden" name="tipoServicio" value="<?php echo 'I'; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">Generar</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                </div>
                                </form>
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