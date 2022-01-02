<?php
require_once("../php/config.php");
if(!isset($_SESSION))
{
    session_start([
        'cookie_lifetime' => 86400,
    ]);
}
if (!isset($_SESSION["user"])) {
    header('Location: login.php');
}
const ADMINISTRADOR = 1;
const CONTABILIDAD = 2;
const PLANILLA = 4;
const ACTIVOFIJO = 8;
const INVENTARIO = 16;
const IVA = 32;
const BANCOS = 64;
const CXC = 128;
const CXP = 256;

$host = DB_HOST;
$user = DB_USER;
$password = DB_PASSWORD;
$database = $_SESSION['db'];
$mysqli = new mysqli($host, $user, $password, $database);
function asDollars($value)
{
    return '$' . number_format($value, 2);
}
function setMenu($permisosActuales, $permisoRequerido)
{
    return ((intval($permisosActuales) & intval($permisoRequerido)) == 0) ? false : true;
}
//obtener cantidad de clientes
$clientesCable = "SELECT count(*) AS TOTAL FROM clientes WHERE (servicio_suspendido='F' or servicio_suspendido is null or servicio_suspendido='') AND sin_servicio='F' AND estado_cliente_in = 3 AND cod_cliente<>'00000'";
$resultadoCable = $mysqli->query($clientesCable);
$CantidadCable = $resultadoCable->fetch_array();
$clientesInternet = "SELECT count(*) AS TOTAL FROM clientes WHERE (servicio_suspendido='F' or servicio_suspendido is null or servicio_suspendido='') and sin_servicio='T' AND estado_cliente_in = 1 AND cod_cliente<>'00000'";
$resultadoInternet = $mysqli->query($clientesInternet);
$cantidadInternet = $resultadoInternet->fetch_array();
$clientePaquetes = "SELECT count(*) AS TOTAL FROM clientes WHERE (servicio_suspendido='F' or servicio_suspendido is null or servicio_suspendido='') and sin_servicio='F' AND estado_cliente_in = 1 AND cod_cliente<>'00000'";
$resultadoPaquete = $mysqli->query($clientePaquetes);
$cantidadPaquete = $resultadoPaquete->fetch_array();
$totalClientes = $CantidadCable['TOTAL'] + $cantidadInternet['TOTAL'] + $cantidadPaquete['TOTAL'];
//OBTENER CANTIDAD DE INGRESOS DIARIOS
date_default_timezone_set('America/El_Salvador');
$date = date("Y-m-d");
$abonosCables = "SELECT SUM(cuotaCable + totalImpuesto) AS TOTAL FROM tbl_abonos WHERE anulada='0' AND fechaAbonado='$date'";
$resultadoAbonoCable = $mysqli->query($abonosCables);
$cantidadAbonoCable = $resultadoAbonoCable->fetch_array();
$abonosInternet = "SELECT SUM(cuotaInternet + totalImpuesto) AS TOTAL FROM tbl_abonos WHERE anulada='0' AND fechaAbonado='$date'";
$resultadoAbonoInternet = $mysqli->query($abonosInternet);
$cantidadAbonoInternet = $resultadoAbonoInternet->fetch_array();
$ventasManuales = "SELECT SUM(montoCable + montoInternet + impuesto) AS TOTAL FROM tbl_ventas_manuales WHERE anulada = 0 AND fechaComprobante='$date'";
$resultadoVentasManuales = $mysqli->query($ventasManuales);
$cantidadVentasManuales = $resultadoVentasManuales->fetch_array();
$totalIngresosDiarios = $cantidadAbonoCable['TOTAL'] + $cantidadAbonoInternet['TOTAL'] + $cantidadVentasManuales['TOTAL'];
//OBTENER CANTIDAD DE ORDENES
$mes = date('m');
$año = date('Y');
$ordenesTrabajo = "SELECT COUNT(*) AS TOTAL FROM tbl_ordenes_trabajo WHERE MONTH(fechaOrdenTrabajo) = '$mes' AND YEAR(fechaOrdenTrabajo) = '$año'";
$resultadoOrdenesTrabajo = $mysqli->query($ordenesTrabajo);
$cantidadOrdenesTrabajo = $resultadoOrdenesTrabajo->fetch_array();
//OBTENER CANTIDAD DE INGRESOS MENSUAL
$abonosCablesMes = "SELECT SUM(cuotaCable + totalImpuesto) AS TOTAL FROM tbl_abonos WHERE anulada='0' AND MONTH(fechaAbonado) = '$mes' AND YEAR(fechaAbonado) = '$año'";
$resultadoAbonoCableMes = $mysqli->query($abonosCablesMes);
$cantidadAbonoCableMes = $resultadoAbonoCableMes->fetch_array();
$abonosInternetMes = "SELECT SUM(cuotaInternet + totalImpuesto) AS TOTAL FROM tbl_abonos WHERE anulada='0' AND MONTH(fechaAbonado) = '$mes' AND YEAR(fechaAbonado) = '$año'";
$resultadoAbonoInternetMes = $mysqli->query($abonosInternetMes);
$cantidadAbonoInternetMes = $resultadoAbonoInternetMes->fetch_array();
$ventasManualesMes = "SELECT SUM(montoCable + montoInternet + impuesto) AS TOTAL FROM tbl_ventas_manuales WHERE anulada = 0 AND MONTH(fechaComprobante)='$mes' AND YEAR(fechaComprobante) = '$año'";
$resultadoVentasManualesMes = $mysqli->query($ventasManualesMes);
$cantidadVentasManualesMes = $resultadoVentasManualesMes->fetch_array();
$totalIngresosMes = $cantidadAbonoCableMes['TOTAL'] + $cantidadAbonoInternetMes['TOTAL'] + $cantidadVentasManualesMes['TOTAL'];
//OBTENER CANTIDAD DE INSTALACIONES
$instalaciones = "SELECT count(*) AS TOTAL FROM tbl_ordenes_trabajo WHERE (actividadCable ='Instalación' OR actividadInter ='Instalación') AND MONTH(fechaTrabajo)='$mes' AND YEAR(fechaTrabajo) = '$año'";
$resultadoinstalaciones = $mysqli->query($instalaciones);
$cantidadinstalaciones = $resultadoinstalaciones->fetch_array();
//OBTENER CANTIDAD DE RENOVACIONES
$renovaciones = "SELECT count(*) AS TOTAL FROM tbl_ordenes_trabajo WHERE (actividadCable ='Renovacion de contrato' OR actividadInter ='Renovacion de contrato') AND MONTH(fechaTrabajo)='$mes' AND YEAR(fechaTrabajo) = '$año'";
$resultadorenovaciones = $mysqli->query($renovaciones);
$cantidadrenovaciones = $resultadorenovaciones->fetch_array();
//OBTENER SUSPENSIONES
$suspensiones = "SELECT COUNT(*) AS TOTAL FROM tbl_ordenes_suspension WHERE MONTH(fechaSuspension)='$mes' AND YEAR(fechaSuspension) = '$año' AND servSusp = '1'";
$resultadosuspensiones = $mysqli->query($suspensiones);
$cantidadsuspensiones = $resultadosuspensiones->fetch_array();
//OBTENER RECONEXIONES
$reconexiones = "SELECT COUNT(*) AS TOTAL FROM tbl_ordenes_reconexion WHERE MONTH(fechaReconexCable)='$mes' AND YEAR(fechaReconexCable) = '$año' OR MONTH(fechaReconexInter)='$mes' AND YEAR(fechaReconexInter) = '$año'";
$resultadoreconexiones = $mysqli->query($reconexiones);
$cantidadreconexiones = $resultadoreconexiones->fetch_array();
//OBTENER CANTIDAD DE MODEMS
$modems = "SELECT COUNT(*) AS TOTAL FROM tbl_articulointernet";
$resultadoModems = $mysqli->query($modems);
$cantidadmodems = $resultadoModems->fetch_array();
//OBTENER CANTIDAD DE EMPLEADOS
$empleados = "SELECT COUNT(*) AS TOTAL FROM tbl_empleados";
$resultadoEmpleados = $mysqli->query($empleados);
$cantidadEmpleados = $resultadoEmpleados->fetch_array();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cablesat</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="herramientas/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="herramientas/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="herramientas/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="herramientas/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="herramientas/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="herramientas/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="herramientas/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="herramientas/plugins/summernote/summernote-bs4.min.css">
     <!-- SWEETALERT -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.css" />
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.js"></script>
    <style>
        .badge{
            position: relative;
            padding: 8px;
            border-radius: 50%;
            background-color: transparent;
            color: #fff;
            font-size: 21px;
        }
        .info{
            padding-top: 10px!important;
        }
    </style>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="herramientas/dist/img/logo.png" alt="Cabesat" height="60" width="60">
    </div>
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="index.php" class="nav-link">Inicio</a>
            </li>
        </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Navbar Search -->
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <i class="fas fa-search"></i>
                </a>
                <div class="navbar-search-block">
                    <form class="form-inline">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
                    <i class="fas fa-phone-alt"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link salir" role="button">
                    <i class="fas fa-power-off"></i>
                </a>
            </li>
        </ul>
    </nav>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="index.php" class="brand-link">
            <img src="herramientas/dist/img/logo.png" alt="Cable sat" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Cable Sat</span>
        </a>
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <span class="badge bg-danger"><i class="fas fa-user-tie"></i></span>
                    <!--<img src="herramientas/dist/img/avatar.png" class="img-circle elevation-2" alt="User Image">-->
                </div>
                <div class="info">
                    <a href="#" ><?php echo $_SESSION['nombres'] ?></a>
                </div>
            </div>
            <!-- menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <?php
                    if (setMenu($_SESSION['permisosTotalesModulos'], ADMINISTRADOR)) {
                    ?>
                        <li class="nav-item">
                            <a href="modulo_administrar/administrar.php" class="nav-link"><i class='fas fa-key'></i>
                                <p> Administrar</p>
                            </a>
                        </li>
                    <?php
                    }
                    if (setMenu($_SESSION['permisosTotalesModulos'], CONTABILIDAD)) {
                    ?>
                        <li class="nav-item">
                            <a href="modulo_contabilidad/contabilidad.php" class="nav-link"><i class='fas fa-money-check-alt'></i>
                                <p> Contabilidad</p>
                            </a>
                        </li>
                    <?php
                    }
                    if (setMenu($_SESSION['permisosTotalesModulos'], PLANILLA)) {
                    ?>
                        <li class="nav-item">
                            <a href="modulo_planillas/planillas.php" class="nav-link"><i class='fas fa-file-signature'></i>
                                <p> Planilla</p>
                            </a>
                        </li>
                    <?php
                    }
                    if (setMenu($_SESSION['permisosTotalesModulos'], ACTIVOFIJO)) {
                    ?>
                        <li class="nav-item">
                            <a href="modulo_activoFijo/activoFijo.php" class="nav-link"><i class='fas fa-building'></i>
                                <p> Activo fijo</p>
                            </a>
                        </li>
                    <?php
                    }
                    if (setMenu($_SESSION['permisosTotalesModulos'], INVENTARIO)) {
                    ?>
                        <li class="nav-item">
                            <a href="moduloInventario.php" class="nav-link"><i class='fas fa-scroll'></i>
                                <p> Inventario</p>
                            </a>
                        </li>
                    <?php
                    }
                    if (setMenu($_SESSION['permisosTotalesModulos'], IVA)) {
                    ?>
                        <li class="nav-item">
                            <a href="modulo_iva/iva.php" class="nav-link"><i class='fas fa-file-invoice-dollar'></i>
                                <p> Iva</p>
                            </a>
                        </li>
                    <?php
                    }
                    if (setMenu($_SESSION['permisosTotalesModulos'], BANCOS)) {
                    ?>
                        <li class="nav-item">
                            <a href="modulo_bancos/bancos.php" class="nav-link"><i class='fas fa-university'></i>
                                <p> Bancos</p>
                            </a>
                        </li>
                    <?php
                    }
                    if (setMenu($_SESSION['permisosTotalesModulos'], CXC)) {
                    ?>
                        <li class="nav-item">
                            <a href="modulo_cxc/cxc.php" class="nav-link"><i class='fas fa-hand-holding-usd'></i>
                                <p> Cuentas por cobrar</p>
                            </a>
                        </li>
                    <?php
                    }
                    if (setMenu($_SESSION['permisosTotalesModulos'], CXP)) {
                    ?>
                        <li class="nav-item">
                            <a href="modulo_cxp/cxp.php" class="nav-link"><i class='fas fa-money-bill-wave'></i>
                                <p> Cuentas por pagar</p>
                            </a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </aside>
    <?php
    switch ($_SESSION["rol"]) {
        case 'administracion':
            $rol = "administracion";
            break;

        case 'subgerencia':
            $rol = "subgerencia";
            $texto = "SUBGERENCIA";
            break;

        case 'jefatura':
            $rol = "jefatura";
            $texto = "JEFATURA DE ÁREA";
            break;

        case 'contabilidad':
            $rol = "contabilidad";
            $texto = "CONTABILIDAD";
            break;

        case 'atencion':
            $rol = "atencion";
            $texto = "ATENCIÓN AL CLIENTE";
            break;

        case 'practicante':
            $rol = "practicante";
            $texto = "PRACTICANTE";
            break;
        case 'invitado':
            $rol = "invitado";
            $texto = "INVITADO";
            break;
        case 'informatica':
            $rol = 'informatica';
            $texto = 'Informatica';
        default:
            break;
    }
    ?>
    <div class="content-wrapper">
        <?php
        if ($rol == "administracion") {
        ?>
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Estadisticas</h1>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Clientes Activos</span>
                                    <span class="info-box-number">
                                        <?php echo $totalClientes ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-dollar-sign"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Ingreso Diario</span>
                                    <span class="info-box-number">
                                        <?php echo asDollars($totalIngresosDiarios) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-file-alt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Ordenes de trabajo</span>
                                    <span class="info-box-number">
                                        <?php echo $cantidadOrdenesTrabajo['TOTAL'] ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-chart-line"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Ingresos de este mes</span>
                                    <span class="info-box-number">
                                        <?php echo asDollars($totalIngresosMes) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-warehouse"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Modems</span>
                                    <span class="info-box-number">
                                        <?php echo  $cantidadmodems['TOTAL'] ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user-tie"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Empleados</span>
                                    <span class="info-box-number">
                                        <?php echo $cantidadEmpleados['TOTAL'] ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card col-md-6 collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title">Actividades</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="chart-responsive">
                                            <canvas id="Grafica" height="150"></canvas>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer p-0">
                                <ul class="nav nav-pills flex-column">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">Suspensiones <span class="float-right text-danger"><?php echo $cantidadsuspensiones['TOTAL'] ?></span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">Renovaciones <span class="float-right text-success"><?php echo $cantidadrenovaciones['TOTAL'] ?></span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">Reconexiones <span class="float-right text-warning"><?php echo $cantidadreconexiones['TOTAL'] ?></span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">Instalaciones <span class="float-right text-info"><?php echo $cantidadinstalaciones['TOTAL'] ?></span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-12 col-sm-6 col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-tv"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Cable</span>
                                    <span class="info-box-number">
                                        <?php echo $CantidadCable['TOTAL'] ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-wifi"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Internet</span>
                                    <span class="info-box-number">
                                        <?php echo $cantidadInternet['TOTAL'] ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-network-wired"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Paquete</span>
                                    <span class="info-box-number">
                                        <?php echo $cantidadPaquete['TOTAL'] ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php
        } else {
        ?>
            <div class='row'>
                <div class='col-lg-12'>
                <br>
                <br>
                    <div class='page-header'>
                        <h2 class='text-center'>BIENVENIDO A CSAT WEB</h2>
                        <h4 class='text-center'><strong><?php echo $texto ?></strong></h4>
                    </div>
                    <img src='../images/logo.png' alt='Smiley face' height='300' width='320' style="margin-left: 37%;">
                </div>
            </div>
    </div>
<?php
        }
?>
</div>
<!-- Control Sidebar -->
<?php
$atencion = [
    ['Colecturia', '8412'],
    ['Atencion1', '8400/8403'],
    ['Atencion2', '8401'],
    ['Atencion3', '8415'],
];
$contabilidad = [
    ['Edgar/Fernando', '8409'],
];
$informatica = [
    ['Xiomara', '8402'],
    ['Carolina', '8416'],
    ['Rafael Moreira', '8419 (7859-2403)'],
    ['Kerin Aparicio', '8421 (413)'],
    ['Adalberto Machado', '8422 (410)'],
    ['Melvin Diaz', '8418 (402)'],
];
$renovaciones = [
    ['Noe Vargas', '8414'],
    ['Marcela', '8437'],
];
$facturacion = [
    ['Sarita', '8406'],
];
$administrativa = [
    ['Jenifer Zelaya', '8404 (401)'],
    ['Susana Reyes', '8435 (409)'],
    ['Manuel Mejia', '8408 (407)'],
    ['Roberto Milla', '8405 (408)'],
    ['Osmar Milla', '8424'],
];
$cobros = [
    ['Janice', '8411 (412)'],
];
$call = [
    ['Angelica', '8407'],
    ['Esmeralda', '8428'],
    ['Elsy Duran', '8410'],
    ['Vacia', '8423'],
    ['Durjan', '8427'],
    ['Anita', '8433'],
    ['Julio', '8434'],
];
$sanmiguel = [
    ['Manuel', '8451 (7860-7367)'],
    ['Julissa', '8452'],
    ['Vanessa', '8450'],
    ['Omar', '8453'],
];
$santiago = [
    ['Julio Giron', '8430'],
    ['Edith Cisnero', '8431'],
    ['Zenon Ayala', '(414)'],
];
$tecnicos = [
    ['Planta Santa Maria', '8420'],
    ['Gerson Argueta', '7861-5406 (102)'],
    ['Don Wilfredo', '7803-2388 (104)'],
    ['Hugo Ganuza', '7861-5410 (105)'],
    ['Julio Baires', '7856-4985 (106)'],
    ['Orlando Castillo', '7600-8199 (108)'],
    ['Luis Campillo', '7852-6451 (110)'],
    ['Osmar Milla', '7856-7295 (111)'],
    ['Carlos Alexander', '7803-2688 (112)'],
    ['Ramon Marin', '7731-7464/7259-6128 (114)'],
    ['Victor', '7084-5629'],
    ['Ever', '7986-6103/7211-3128'],
    ['Rolando', '7915-0673/7556-4182'],
    ['Franklin', '7541-0343'],
    ['Willian Dominguez', '7893-6483'],
    ['Jorge', '7745-2856'],
    ['Francisco', '6062-9228/7199-9229'],
    ['Gonzalo', '7860-6874'],
    ['Efrain', '6311-6237'],
    ['Dimas', '7790-6157 (109)'],
    ['Antonio', '7084-9663/6300-7910'],
    ['Willian', '7552-4683'],
    ['Alfredo', '7859-8739'],
    ['Nain', '7644-1328'],
    ['Ramon Alvarez', '7856-4592'],
    ['Mauricio', '7965-6890'],
    ['Francisco Miranda', '7049-9913/7600-8199'],
    ['Luis Gonzalez', '7583-2565'],
    ['Alberto', '7134-2982'],
    ['Miguel', '7120-7850'],
    ['Alexis', '7604-8428 (113)'],
    ['Dennis', '7084-6548'],
    ['Anibal', '7712-9463']
];
?>
<aside class="control-sidebar control-sidebar-dark">
    <div class="p-3 control-sidebar-content">
        <h5>Telefonos y Extensiones</h5>
        <hr class="mb-2">
        <table>
            <tr>
                <th colspan="2">ATENCION AL CLIENTE</th>
            </tr>
            <?php
            foreach ($atencion as list($area, $extension)) {
            ?>
                <tr>
                    <td><?php echo $area ?></td>
                    <td><?php echo $extension ?></td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <th colspan="2">ATENCION DE CONTABILIDAD</th>
            </tr>
            <?php
            foreach ($contabilidad as list($area, $extension)) {
            ?>
                <tr>
                    <td><?php echo $area ?></td>
                    <td><?php echo $extension ?></td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <th colspan="2">INFORMATICA</th>
            </tr>
            <?php
            foreach ($informatica as list($area, $extension)) {
            ?>
                <tr>
                    <td><?php echo $area ?></td>
                    <td><?php echo $extension ?></td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <th colspan="2">RENOVACIONES</th>
            </tr>
            <?php
            foreach ($renovaciones as list($area, $extension)) {
            ?>
                <tr>
                    <td><?php echo $area ?></td>
                    <td><?php echo $extension ?></td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <th colspan="2">FACTURACION</th>
            </tr>
            <?php
            foreach ($facturacion as list($area, $extension)) {
            ?>
                <tr>
                    <td><?php echo $area ?></td>
                    <td><?php echo $extension ?></td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <th colspan="2">AREA ADMINISTRATIVA</th>
            </tr>
            <?php
            foreach ($administrativa as list($area, $extension)) {
            ?>
                <tr>
                    <td><?php echo $area ?></td>
                    <td><?php echo $extension ?></td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <th colspan="2">JEFA DE COBROS</th>
            </tr>
            <?php
            foreach ($cobros as list($area, $extension)) {
            ?>
                <tr>
                    <td><?php echo $area ?></td>
                    <td><?php echo $extension ?></td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <th colspan="2">CALL CENTER</th>
            </tr>
            <?php
            foreach ($call as list($area, $extension)) {
            ?>
                <tr>
                    <td><?php echo $area ?></td>
                    <td><?php echo $extension ?></td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <th colspan="2">OFICINA SAN MIGUEL</th>
            </tr>
            <?php
            foreach ($sanmiguel as list($area, $extension)) {
            ?>
                <tr>
                    <td><?php echo $area ?></td>
                    <td><?php echo $extension ?></td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <th colspan="2">OFICINA SANTIAGO DE MARIA</th>
            </tr>
            <?php
            foreach ($santiago as list($area, $extension)) {
            ?>
                <tr>
                    <td><?php echo $area ?></td>
                    <td><?php echo $extension ?></td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <th colspan="2">AREA TECNICA</th>
            </tr>
            <?php
            foreach ($tecnicos as list($area, $extension)) {
            ?>
                <tr>
                    <td><?php echo $area ?></td>
                    <td><?php echo $extension ?></td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>
</aside>
<!-- /.control-sidebar -->
<!-- scripts -->
<!-- jQuery -->
<script src="herramientas/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="herramientas/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="herramientas/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="herramientas/plugins/sparklines/sparkline.js"></script>
<!-- jQuery Knob Chart -->
<script src="herramientas/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="herramientas/plugins/moment/moment.min.js"></script>
<script src="herramientas/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="herramientas/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="herramientas/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="herramientas/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="herramientas/dist/js/adminlte.js"></script>
<script>
    //-------------
    // - PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#Grafica').get(0).getContext('2d')
    var pieData = {
        labels: [
            'Suspensiones',
            'Renovaciones',
            'Reconexiones',
            'Instalaciones',
        ],
        datasets: [{
            data: [<?php echo $cantidadsuspensiones['TOTAL'] ?>, <?php echo $cantidadrenovaciones['TOTAL'] ?>, <?php echo $cantidadreconexiones['TOTAL'] ?>, <?php echo $cantidadinstalaciones['TOTAL'] ?>],
            backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', ]
        }]
    }
    var pieOptions = {
        legend: {
            display: false
        }
    }
    // Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    // eslint-disable-next-line no-unused-vars
    var pieChart = new Chart(pieChartCanvas, {
        type: 'doughnut',
        data: pieData,
        options: pieOptions
    })
</script>
<script>
    $(document).ready(function(){
        $(".salir").on("click", function(e){
            e.preventDefault();
            swal({
            title: "SALIR",
            text: "Seguro deseas salir de CSATWEB",
            type: "warning",
            showCancelButton: true,
            cancelButtonText: "No",
            confirmButtonText: "Continuar",
            closeOnConfirm: false,
            closeOnCancel: true
        }).then(function() {
            window.location.replace("../php/logout.php");
        });
        });
    });
</script>
</body>

</html>