<?php
require_once("../../php/config.php");
if (!isset($_SESSION)) {
    session_start([
        'cookie_lifetime' => 86400,
    ]);
}
if (!isset($_SESSION["user"])) {
    header('Location: ../login.php');
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
function setMenu($permisosActuales, $permisoRequerido)
{
    return ((intval($permisosActuales) & intval($permisoRequerido)) == 0) ? false : true;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cablesat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../herramientas/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../herramientas/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../herramientas/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="css/estilo_cxc.css">
    <link rel="stylesheet" href="css/calendario.css">
    <!-- SWEETALERT -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.css" />
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="../herramientas/dist/img/logo.png" alt="Cabesat" height="60" width="60">
    </div>
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item  dropdown">
                <a id="archivo" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Archivo </a>
                <ul aria-labelledby="archivo" class="dropdown-menu border-0 shadow">
                    <?php
                    if ($_SESSION["rol"] == 'contabilidad' || $_SESSION["rol"] == 'jefatura' || $_SESSION["rol"] == 'administracion' || $_SESSION["rol"] == 'subgerencia' || $_SESSION["rol"] == 'atencion') {
                    ?>
                        <li><a href="cobradores.php" class="dropdown-item">Cobradores </a></li>
                        <li><a href="vendedores.php" class="dropdown-item">Vendedores </a></li>
                        <li><a href="zonas.php" class="dropdown-item">Zonas </a></li>
                    <?php
                    }
                    ?>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a id="procesos" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Procesos </a>
                <ul aria-labelledby="procesos" class="dropdown-menu border-0 shadow">
                    <?php
                    if ($_SESSION["rol"] == 'administracion' || $_SESSION["rol"] == 'subgerencia' || $_SESSION["rol"] == 'jefatura' || $_SESSION["rol"] == 'atencion') {
                    ?>
                        <li><a href="#" data-toggle="modal" data-target="#suspensionesAutomaticas" class="dropdown-item">Suspensiones automáticas</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#imprimirSuspensiones" class="dropdown-item">Imprimir Suspensiones</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#generarCompromisos" class="dropdown-item">Generación de compromisos</a></li>

                    <?php
                    } elseif ($_SESSION["rol"] == 'administracion') {
                    ?>
                        <li><a href="#" data-toggle="modal" data-target="#suspensionadmin" class="dropdown-item">Gestiones de clientes a suspender</a></li>
                    <?php
                    }
                    ?>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a id="gestion" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Gestion </a>
                <ul aria-labelledby="gestion" class="dropdown-menu border-0 shadow">
                    <?php
                    if ($_SESSION["rol"] == 'administracion' || $_SESSION["rol"] == 'subgerencia' || $_SESSION["rol"] == 'jefatura' || $_SESSION["rol"] == 'atencion') {
                    ?>
                        <li><a href="#" data-toggle="modal" data-target="#listaSuspensiones1" class="dropdown-item">Listado de vencidos(1 mes)</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#listaSuspensiones" class="dropdown-item">Listado de vencidos(2 meses)</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#listaGeneradas" class="dropdown-item">Listado de facturas generadas(1 mes)</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#listaGeneradas2Meses" class="dropdown-item">Listado de facturas generadas(2 meses)</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#analisisSuspensiones" class="dropdown-item">Analisis de cartera de clientes</a></li>
                        <li><a href="gestionCobros.php" class="dropdown-item">Gestion de cobros</a></li>
                        <li><a href="impagos.php" target="_blank" class="dropdown-item">Gestión de impagos</a></li>
                    <?php
                    }
                    ?>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a id="facturacion" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Facturacion </a>
                <ul aria-labelledby="facturacion" class="dropdown-menu border-0 shadow">
                    <?php
                    if ($_SESSION["rol"] == 'administracion' || $_SESSION["rol"] == 'subgerencia') {
                    ?>
                        <li><a href="#" data-toggle="modal" data-target="#facturacionDiaria" accesskey="a" class="dropdown-item">Facturación automática (Alt+A)</a></li>
                        <li><a href="facturacionManual.php" class="dropdown-item">Facturación manual</a></li>
                        <li><a href="imprimirFacturas.php" data-toggle="modal" data-target="#imprimirFacturas" accesskey="i" class="dropdown-item">Imprimir facturas (Alt+I)</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#verFacturasGeneradas" class="dropdown-item">Ver facturas generadas</a></li>
                    <?php
                    } elseif ($_SESSION["rol"] == 'jefatura' || $_SESSION["rol"] == 'contabilidad') {
                    ?>
                        <li><a href="imprimirFacturas.php" data-toggle="modal" data-target="#imprimirFacturas" accesskey="i" class="dropdown-item">Imprimir facturas (Alt+I)</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#verFacturasGeneradasC" class="dropdown-item">Ver facturas generadas</a></li>
                    <?php
                    } elseif ($_SESSION["rol"] == 'atencion') {
                    ?>
                        <li><a href="#" data-toggle="modal" data-target="#verFacturasGeneradasC" class="dropdown-item">Ver facturas generadas</a></li>
                    <?php
                    }
                    ?>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a id="transacciones" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Transacciones </a>
                <ul aria-labelledby="transacciones" class="dropdown-menu border-0 shadow">
                    <?php
                    if ($_SESSION["rol"] == 'administracion' || $_SESSION["rol"] == 'subgerencia' || $_SESSION["rol"] == 'jefatura' || $_SESSION["rol"] == 'contabilidad') {
                    ?>
                        <li><a href="#" data-toggle="modal" data-target="#eliminarAbonos" class="dropdown-item">Administrar abonos</a></li>
                        <li><a href="ventasManuales.php" class="dropdown-item">Ventas manuales</a></li>
                    <?php
                    } else {
                    ?>
                        <li><a href="ventasManuales.php" class="dropdown-item">Ventas manuales</a></li>
                    <?php
                    }
                    ?>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a id="reportes" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Reportes </a>
                <ul aria-labelledby="reportes" class="dropdown-menu border-0 shadow">
                    <?php
                    if ($_SESSION["rol"] == 'administracion' || $_SESSION["rol"] == 'subgerencia' || $_SESSION["rol"] == 'jefatura' || $_SESSION["rol"] == 'contabilidad') {
                    ?>
                        <li><a href="#" data-toggle="modal" data-target="#ReporteProporcional" accesskey="p" class="dropdown-item">Reporte Proporcional(Alt+P)</a></li>
                        <li><a href="reporteFacturas.php" data-toggle="modal" data-target="#reporteFacturas" accesskey="i" class="dropdown-item">Reporte de facturas generadas</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#reportePendiente2m" accesskey="i" class="dropdown-item">Reporte de facturas pendientes de 2 meses</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#reportePendiente3m" class="dropdown-item">Reporte de facturas pendientes por año</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#ReporteOrdenesPend" accesskey="o" class="dropdown-item">Reporte de ordenes (Alt+O)</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#totalClientes" class="dropdown-item">Listado de cobros</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#reporteOrdenesTrabajo" class="dropdown-item">Reporte de ordenes</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#reporteVentasManuales" class="dropdown-item">Ventas manuales</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#clientesInstalados" class="dropdown-item">Clientes Instalados</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#abonosAplicados" class="dropdown-item">Abonos aplicados</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#anticiposLiquidados" class="dropdown-item">Anticipos liquidados</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#facturasEmitidas" class="dropdown-item">Facturas emitidas (a detalle)</a></li>
                    <?php
                    } elseif ($_SESSION["rol"] == 'informatica') {
                    ?>
                        <li><a href="#" data-toggle="modal" data-target="#ReporteOrdenesPend" accesskey="o" class="dropdown-item">Reporte de ordenes (Alt+O)</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#abonosAplicados" class="dropdown-item">Abonos aplicados</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#reportePendiente2m" accesskey="i" class="dropdown-item">Reporte de facturas pendientes de 2 meses</a></li>
                    <?php
                    } elseif ($_SESSION["rol"] == 'atencion') {
                    ?>
                        <li><a href="reporteFacturas.php" data-toggle="modal" data-target="#reporteFacturas" accesskey="i" class="dropdown-item">Reporte de facturas generadas</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#reportePendiente2m" accesskey="i" class="dropdown-item">Reporte de facturas pendientes de 2 meses</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#ReporteOrdenesPend" accesskey="o" class="dropdown-item">Reporte de Ordenes(Alt+O)</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#totalClientes" class="dropdown-item">Listado de cobros</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#reporteOrdenesTrabajo" class="dropdown-item">Reporte de ordenes</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#reporteVentasManuales" class="dropdown-item">Ventas manuales</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#clientesInstalados" class="dropdown-item">Clientes Instalados</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#abonosAplicados" class="dropdown-item">Abonos aplicados</a></li>
                    <?php
                    }
                    ?>
                </ul>
            </li>
            <li class="nav-item">
                <a href="infoCliente.php?id=00001" class="nav-link">Clientes</a>
            </li>
            <li class="nav-item">
                <a href="abonos.php" class="nav-link">Abonos</a>
            </li>
        </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Navbar Search -->
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
        <a href="../index.php" class="brand-link">
            <img src="../herramientas/dist/img/logo.png" alt="Cable sat" class="brand-image img-circle elevation-3" style="opacity: .8">
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
                    <a href="../index.php"><?php echo $_SESSION['nombres'] ?></a>
                </div>
            </div>
            <!-- menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <?php
                    if (setMenu($_SESSION['permisosTotalesModulos'], ADMINISTRADOR)) {
                    ?>
                        <li class="nav-item">
                            <a href="../modulo_administrar/administrar.php" class="nav-link"><i class='fas fa-key'></i>
                                <p> Administrar</p>
                            </a>
                        </li>
                    <?php
                    }
                    if (setMenu($_SESSION['permisosTotalesModulos'], CONTABILIDAD)) {
                    ?>
                        <li class="nav-item">
                            <a href="../modulo_contabilidad/contabilidad.php" class="nav-link"><i class='fas fa-money-check-alt'></i>
                                <p> Contabilidad</p>
                            </a>
                        </li>
                    <?php
                    }
                    if (setMenu($_SESSION['permisosTotalesModulos'], PLANILLA)) {
                    ?>
                        <li class="nav-item">
                            <a href="../modulo_planillas/planillas.php" class="nav-link"><i class='fas fa-file-signature'></i>
                                <p> Planilla</p>
                            </a>
                        </li>
                    <?php
                    }
                    if (setMenu($_SESSION['permisosTotalesModulos'], ACTIVOFIJO)) {
                    ?>
                        <li class="nav-item">
                            <a href="../modulo_activoFijo/activoFijo.php" class="nav-link"><i class='fas fa-building'></i>
                                <p> Activo fijo</p>
                            </a>
                        </li>
                    <?php
                    }
                    if (setMenu($_SESSION['permisosTotalesModulos'], INVENTARIO)) {
                    ?>
                        <li class="nav-item">
                            <a href="../moduloInventario.php" class="nav-link"><i class='fas fa-scroll'></i>
                                <p> Inventario</p>
                            </a>
                        </li>
                    <?php
                    }
                    if (setMenu($_SESSION['permisosTotalesModulos'], IVA)) {
                    ?>
                        <li class="nav-item">
                            <a href="../modulo_iva/iva.php" class="nav-link"><i class='fas fa-file-invoice-dollar'></i>
                                <p> Iva</p>
                            </a>
                        </li>
                    <?php
                    }
                    if (setMenu($_SESSION['permisosTotalesModulos'], BANCOS)) {
                    ?>
                        <li class="nav-item">
                            <a href="../modulo_bancos/bancos.php" class="nav-link"><i class='fas fa-university'></i>
                                <p> Bancos</p>
                            </a>
                        </li>
                    <?php
                    }
                    if (setMenu($_SESSION['permisosTotalesModulos'], CXC)) {
                    ?>
                        <li class="nav-item">
                            <a href="../modulo_cxc/cxc.php" class="nav-link"><i class='fas fa-hand-holding-usd'></i>
                                <p> Cuentas por cobrar</p>
                            </a>
                        </li>
                    <?php
                    }
                    if (setMenu($_SESSION['permisosTotalesModulos'], CXP)) {
                    ?>
                        <li class="nav-item">
                            <a href="../modulo_cxp/cxp.php" class="nav-link"><i class='fas fa-money-bill-wave'></i>
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
    <div class="content-wrapper">
        <div id='wrap'>
            <div id='calendar'></div>
            <div style='clear:both'></div>
        </div>
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
    <!-- modales -->
    <!-- Modal SUSPENSIONES AUTOMATICAS -->
    <div id="suspensionesAutomaticas" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <h4 class="modal-title">Lista de clientes a suspender</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="frmSuspensionesAutomaticas" action="php/suspensionesAutomaticas.php" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="susCobrador">Cobrador</label>
                                <select class="form-control" type="text" id="susCobrador" name="susCobrador" required>
                                    <option value="">Seleccione cobrador</option>
                                    <option value="todos" selected>Todos los cobradores</option>
                                    <?php
                                    require_once 'php/GetAllInfo.php';
                                    $data = new GetAllInfo();
                                    $arrCobradores = $data->getData('tbl_cobradores');
                                    foreach ($arrCobradores as $key) {
                                        echo '<option value="' . $key['codigoCobrador'] . '">' . $key['nombreCobrador'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="susServicio">Tipo de servicio</label>
                                <select class="form-control" type="text" id="susServicio" name="susServicio" required>
                                    <option value="C" selected>Cable</option>
                                    <option value="I">Internet</option>
                                    <option value="P">Paquete</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-danger btn-sm" name="submit">Suspensiones</button>&nbsp;
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div><!-- Fin Modal SUSPENSIONES AUTOMATICAS -->
    <!-- Modal GENERACION DE COMPROMISOS -->
    <div id="generarCompromisos" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <h4 class="modal-title">Generación de compromisos</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="frmGenerarCompromisos" action="php/generarCompromisos.php" method="POST" target="_blank">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="lCobrador">Cobrador</label>
                                <select class="form-control" type="text" id="lCobrador" name="lCobrador" required>
                                    <option value="">Seleccione cobrador</option>
                                    <option value="todos" selected>Todos los cobradores</option>
                                    <?php
                                    require_once 'php/GetAllInfo.php';
                                    $data = new GetAllInfo();
                                    $arrCobradores = $data->getData('tbl_cobradores');
                                    foreach ($arrCobradores as $key) {
                                        echo '<option value="' . $key['codigoCobrador'] . '">' . $key['nombreCobrador'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="lColonia">Brarrio/Colonia</label>
                                <select class="form-control" type="text" id="lColonia" name="lColonia" required>
                                    <option value="todas" selected>Todas las zonas</option>
                                    <?php
                                    $arrColonias = $data->getData('tbl_colonias_cxc');
                                    foreach ($arrColonias as $key) {
                                        echo '<option value="' . $key['idColonia'] . '">' . $key['nombreColonia'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="lServicio">Tipo de servicio</label>
                                <select class="form-control" type="text" id="lServicio" name="lServicio" required>
                                    <option value="">Seleccione tipo de servicio</option>
                                    <option value="C" selected>Cable</option>
                                    <option value="I">Internet</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="diaCobro">Día cobro</label>
                                <input class="form-control" type="number" name="diaCobro" value="1" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <br>
                                <label for="filtro">Fecha de comprobante</label>
                                <input type="radio" type="text" id="filtroFechaComp" name="filtro" value="2" checked>
                            </div>
                            <div class="col-md-4">
                                <br>
                                <label for="todosDias">Todos los días de cobro</label>
                                <input type="checkbox" type="text" id="todosDias" name="todosDias" value="1">
                            </div>
                            <div class="col-md-4">
                                <br>
                                <label for="ordenamiento">Ordenar por código</label>
                                <input type="radio" type="text" id="ordenarCodigo" name="ordenamiento" value="1" checked>
                                <label for="ordenamiento">Ordenar por cobrador</label>
                                <input type="radio" type="text" id="ordenarColonia" name="ordenamiento" value="2">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-2">
                                <label for="lDesde">Desde</label>
                                <input class="form-control" type="number" id="lDesde" name="lDesde" placeholder="Fecha en que se generaron las facturas" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" value="<?php echo date('d'); ?>" required>
                            </div>
                            <div class="col-md-2">
                                <label for="lHasta">Hasta</label>
                                <input class="form-control" type="number" id="lHasta" name="lHasta" placeholder="Fecha en que se generaron las facturas" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" value="<?php echo date('d'); ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="submit" class="btn btn-danger btn-sm" name="submit" value="Generar">
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div><!-- fin modal generacion de compromisos -->
    <!-- Modal gestion de clientes a suspender -->
    <div id="suspensionadmin" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <h4 class="modal-title">Clientes gestionados para suspensión desde oficina</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="frmsuspensionadmin" action="suspendercliente.php" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="fechaImp">Fecha ha suspender</label>
                                <input class="form-control" type="text" id="fechaGen" name="fechaGen" placeholder="Fecha en que se generaron las facturas" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="submit" class="btn btn-danger btn-sm" name="submit" value="Gestiones">
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div><!-- fin de modal gestion de clientes a suspender -->
    <!-- Gestion #1 -->
    <div id="listaSuspensiones1" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <h4 class="modal-title">Lista de clientes de 1 factura vencida</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="frmListaSuspendidos1" action="php/listaDeClientesConFacturasVencidas.php" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="susCobrador">Cobrador</label>
                                <select class="form-control" type="text" id="susCobrador" name="susCobrador" required>
                                    <option value="">Seleccione cobrador</option>
                                    <option value="todos" selected>Todos los cobradores</option>
                                    <?php
                                    require_once 'php/GetAllInfo.php';
                                    $data = new GetAllInfo();
                                    $arrCobradores = $data->getData('tbl_cobradores');
                                    foreach ($arrCobradores as $key) {
                                        echo '<option value="' . $key['codigoCobrador'] . '">' . $key['nombreCobrador'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="susServicio">Tipo de servicio</label>
                                <select class="form-control" type="text" id="susServicio" name="susServicio" required>
                                    <option value="">Seleccione tipo de servicio</option>
                                    <option value="C" selected>Cable</option>
                                    <option value="I">Internet</option>
                                    <option value="P">Paquete</option>
                                    <option value="A">Todos</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="submit" class="btn btn-danger btn-sm" name="submit" value="Listado">
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div><!-- Fin de gestion #1 -->
    <!-- Modal Gestion #2 -->
    <div id="listaSuspensiones" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <h4 class="modal-title">Lista de clientes 2 facturas vencidas</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="frmListaSuspendidos" action="php/listaSuspensiones.php" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="susCobrador">Cobrador</label>
                                <select class="form-control" type="text" id="susCobrador" name="susCobrador" required>
                                    <option value="">Seleccione cobrador</option>
                                    <option value="todos" selected>Todos los cobradores</option>
                                    <?php
                                    require_once 'php/GetAllInfo.php';
                                    $data = new GetAllInfo();
                                    $arrCobradores = $data->getData('tbl_cobradores');
                                    foreach ($arrCobradores as $key) {
                                        echo '<option value="' . $key['codigoCobrador'] . '">' . $key['nombreCobrador'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="susServicio">Tipo de servicio</label>
                                <select class="form-control" type="text" id="susServicio" name="susServicio" required>
                                    <option value="">Seleccione tipo de servicio</option>
                                    <option value="C" selected>Cable</option>
                                    <option value="I">Internet</option>
                                    <option value="P">Paquete</option>
                                    <option value="A">Todos</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="submit" class="btn btn-danger btn-sm" name="submit" value="Listado">
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div><!-- Fin Modal Gestion #2 -->
    <!-- Modal Generada #3-->
    <div id="listaGeneradas" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <h4 class="modal-title">Lista de clientes de 1 factura generada</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="frmListaGeneradas1" action="php/listaDeClientesConFacturasGeneradas.php" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="susCobrador">Cobrador</label>
                                <select class="form-control" type="text" id="susCobrador" name="susCobrador" required>
                                    <option value="">Seleccione cobrador</option>
                                    <option value="todos" selected>Todos los cobradores</option>
                                    <?php
                                    require_once 'php/GetAllInfo.php';
                                    $data = new GetAllInfo();
                                    $arrCobradores = $data->getData('tbl_cobradores');
                                    foreach ($arrCobradores as $key) {
                                        echo '<option value="' . $key['codigoCobrador'] . '">' . $key['nombreCobrador'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="susServicio">Tipo de servicio</label>
                                <select class="form-control" type="text" id="susServicio" name="susServicio" required>
                                    <option value="">Seleccione tipo de servicio</option>
                                    <option value="C" selected>Cable</option>
                                    <option value="I">Internet</option>
                                    <option value="P">Paquete</option>
                                    <option value="A">Todos</option>
                                    <!--All services-->
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="submit" class="btn btn-danger btn-sm" name="submit" value="Listado">
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div><!-- Fin Modal Generada #3 -->
    <!-- Modal Gestion #4-->
    <div id="listaGeneradas2Meses" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <h4 class="modal-title">Lista de clientes de 2 facturas generadas</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="frmListaGeneradas1" action="php/lista_dos_meses_facturas_no_vencidos.php" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="susCobrador">Cobrador</label>
                                <select class="form-control" type="text" id="susCobrador" name="susCobrador" required>
                                    <option value="">Seleccione cobrador</option>
                                    <option value="todos" selected>Todos los cobradores</option>
                                    <?php
                                    require_once 'php/GetAllInfo.php';
                                    $data = new GetAllInfo();
                                    $arrCobradores = $data->getData('tbl_cobradores');
                                    foreach ($arrCobradores as $key) {
                                        echo '<option value="' . $key['codigoCobrador'] . '">' . $key['nombreCobrador'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="susServicio">Tipo de servicio</label>
                                <select class="form-control" type="text" id="susServicio" name="susServicio" required>
                                    <option value="">Seleccione tipo de servicio</option>
                                    <option value="C" selected>Cable</option>
                                    <option value="I">Internet</option>
                                    <option value="P">Paquete</option>
                                    <option value="A">Todos</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="submit" class="btn btn-danger btn-sm" name="submit" value="Listado">
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div><!-- Fin Modal Gestion #4 -->
    <!-- Modal Gestion #5 -->
    <div id="analisisSuspensiones" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <h4 class="modal-title">Analisis de cartera de clientes</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="frmanalisisSuspensiones" action="php/analisisSuspensiones.php" method="POST" target="_blank">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <label for="clCobrador">Cobrador</label>
                                <select class="form-control" type="text" id="clCobrador" name="clCobrador" required>
                                    <option value="">Seleccione cobrador</option>
                                    <option value="todos" selected>Todos</option>
                                    <?php
                                    $cobradores = $mysqli->query("SELECT * FROM tbl_cobradores");
                                    while ($datos = $cobradores->fetch_array()) {
                                    ?>
                                        <option value="<?php echo $datos['codigoCobrador'] ?>"><?php echo $datos['nombreCobrador'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="cldiaCobro">Dia de cobro</label>
                                <input class="form-control" type="number" name="cldiaCobro" value="1">
                            </div>
                            <div class="col-md-2">
                                <label for="clServicio">Tipo de servicio</label>
                                <select class="form-control" type="text" id="clServicio" name="clServicio" required>
                                    <option value="">Seleccione tipo de servicio</option>
                                    <option value="C" selected>Cable</option>
                                    <option value="I">Internet</option>
                                    <option value="A">Paquete</option>
                                    <option value="T" selected>TODOS</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="clColonia">Brarrio/Colonia</label>
                                <select class="form-control buscador" id="clColonia" name="clColonia" required style="width: 100%!important;">
                                    <option value="todas" selected>Todas las zonas</option>
                                    <?php
                                    $colonias = $mysqli->query("SELECT * FROM tbl_colonias_cxc");
                                    while ($datos = $colonias->fetch_array()) {
                                    ?>
                                        <option value="<?php echo $datos['idColonia'] ?>"><?php echo $datos['nombreColonia'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="desde">Desde</label>
                                <input class="form-control" type="date" name="desde" value="<?php echo date('Y-m-d', strtotime(date('Y-m-d') . '- 1 month')) ?>">
                            </div>
                            <div class="col-md-3">
                                <label for="hasta">Desde</label>
                                <input class="form-control" type="date" name="hasta" value="<?php echo date('Y-m-d') ?>">
                            </div>
                            <div class="col-md-3" style="padding-top: 10px;">
                                <br>
                                <input type="checkbox" class="btn-check" name="ordenarPorColonias" id="ordenarPorColonias" autocomplete="off" value="1">
                                <label class="btn btn-outline-danger" for="ordenarPorColonias">Ordenar Por Colonias</label>
                            </div>
                            <div class="col-md-3" style="padding-top: 10px;">
                                <br>
                                <input type="checkbox" class="btn-check" name="todosLosDias" id="todosLosDias" autocomplete="off" value="1">
                                <label class="btn btn-outline-danger" for="todosLosDias">Todos los dias</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="tipoAnalisis">Tipo de análisis</label>
                                <select class="form-control" type="text" id="tipoAnalisis" name="tipoAnalisis" required>
                                    <option value="in" selected>Instalaciones</option>
                                    <option value="su">Suspensiones</option>
                                    <option value="re">Renovaciones</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="submit" class="btn btn-danger btn-sm" name="submit" value="Analisis">
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div><!-- Fin Modal Gestion #5-->
    <!-- Modal Facturación #1 -->
    <div id="facturacionDiaria" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <h4 class="modal-title">Generar facturas</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="generarFacturas" action="php/generarFacturas.php?" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-warning">
                                    <b><i>Nota:</i></b> Antes de generar la facturación favor verificar si tiene suficiente rango disposible <a href="../modulo_administrar/configFacturas.php" target="_blank">aquí</a>
                                </div>
                                <select class="form-control" name="tipoComprobante" required>
                                    <option value="2">Factura consumidor final</option>
                                    <option value="1">Crédito fiscal</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <label for=""></label>
                                <select id="mesGenerar" class="form-control" name="mesGenerar" required>
                                    <option value="" selected>Mes a generar</option>
                                    <option value="01">Enero</option>
                                    <option value="02">Febrero</option>
                                    <option value="03">Marzo</option>
                                    <option value="04">Abril</option>
                                    <option value="05">Mayo</option>
                                    <option value="06">Junio</option>
                                    <option value="07">Julio</option>
                                    <option value="08">Agosto</option>
                                    <option value="09">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for=""></label>
                                <select id="diaGenerar" class="form-control" name="diaGenerar" required>
                                    <option value="" selected>Día a generar</option>
                                    <option value="01">1</option>
                                    <option value="02">2</option>
                                    <option value="03">3</option>
                                    <option value="04">4</option>
                                    <option value="05">5</option>
                                    <option value="06">6</option>
                                    <option value="07">7</option>
                                    <option value="08">8</option>
                                    <option value="09">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for=""></label>
                                <input id="anoGenerar" class="form-control" type="number" name="anoGenerar" placeholder="Año a generar" value="<?php echo date('Y') ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for=""></label>
                                <input id="fechaComprobante" class="form-control" type="text" name="fechaComprobante" placeholder="Fecha de comprobante Eje: año-mes-dia" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" required>
                            </div>
                            <div class="col-md-6">
                                <label for=""></label>
                                <input id="fechaVencimiento" class="form-control" type="text" name="vencimiento" placeholder="Fecha de vencimiento Eje: año-mes-dia" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="correlativo"></label>
                                <input class="form-control alert-danger" type="hidden" name="correlativo" value="25899" required>
                            </div>
                            <div class="col-md-4">
                                <label for=""></label>
                                <select class="form-control" name="tipoServicio" required>
                                    <option value="" selected>Tipo de servicio</option>
                                    <option value="cable">Cable</option>
                                    <option value="internet">Internet</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label style="color:#2E7D32;" for="cesc">CESC</label>
                                <input type="checkbox" name="cesc" value="1" checked>
                                <br><br>
                                <label style="color: #FF0000;" for="covid19">COVID-19</label>
                                <input type="checkbox" name="covid19" value="1" checked>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="submit" class="btn btn-danger btn-sm" name="submit" value="Generar">
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div><!-- Fin Modal Facturación #1 -->
    <!-- Modal Facturacion #2 -->
    <div id="imprimirFacturas" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <h4 class="modal-title">Imprimir facturas</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="frmImprimirFacturas" action="php/imprimirFacturas.php" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="tipoComprobanteImp">Tipo de factura</label>
                                <select class="form-control" type="text" id="tipoComprobanteImp" name="tipoComprobanteImp" required>
                                    <option value="">Seleccione tipo de factura</option>
                                    <option value="2">Factura normal</option>
                                    <option value="1">Crédito fiscal</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <label for="cobradorImp">Cobrador</label>
                                <select class="form-control" type="text" id="cobradorImp" name="cobradorImp" required>
                                    <option value="todos" selected>Todos</option>
                                </select>
                            </div>
                            <div class="col-md-4">

                                <label for="diaImp">Día de cobro</label>
                                <select id="diaImp" class="form-control" id="diaImp" name="diaImp" required>
                                    <option value="">Día de cobro</option>
                                    <option value="01">1</option>
                                    <option value="02">2</option>
                                    <option value="03">3</option>
                                    <option value="04">4</option>
                                    <option value="05">5</option>
                                    <option value="06">6</option>
                                    <option value="07">7</option>
                                    <option value="08">8</option>
                                    <option value="09">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <label for="fechaImp">Fecha en que se generó</label>
                                <input class="form-control" type="text" id="fechaImp" name="fechaImp" placeholder="Fecha en que se generaron las facturas" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="tipoServicioImp">Tipo de servicio</label>
                                <select class="form-control" type="text" id="tipoServicioImp" name="tipoServicioImp" required>
                                    <option value="C" selected>Cable</option>
                                    <option value="I">Internet</option>
                                    <option value="T">Ambas</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="desdeImp"></label>
                                <input class="form-control" type="text" id="desdeImp" name="desdeImp" placeholder="Número de factura">
                            </div>
                            <div class="col-md-6">
                                <label for="hastaImp"></label>
                                <input class="form-control" type="text" id="hastaImp" name="hastaImp" placeholder="Número de factura">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="submit" class="btn btn-danger btn-sm" name="submit" value="Imprimir">
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div><!-- Fin Modal Facturacion #2 -->
    <!-- Modal Facturacion #3 -->
    <div id="verFacturasGeneradas" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <h4 class="modal-title">Ver facturas generadas</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="frmVerFacturas" action="facturacionGenerada.php" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="tipoComprobanteImp">Tipo de factura</label>
                                <select class="form-control" type="text" id="tipoComprobanteGen" name="tipoComprobanteGen" required>
                                    <option value="">Seleccione tipo de factura</option>
                                    <option value="2">Factura normal</option>
                                    <option value="1">Crédito fiscal</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <label for="cobradorImp">Cobrador</label>
                                <select class="form-control" type="text" id="cobradorGen" name="cobradorGen" required>
                                    <option value="todos" selected>Todos</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="diaImp">Día de cobro</label>
                                <select id="diaImp" class="form-control" id="diaGen" name="diaGen" required>
                                    <option value="">Día de cobro</option>
                                    <option value="01">1</option>
                                    <option value="02">2</option>
                                    <option value="03">3</option>
                                    <option value="04">4</option>
                                    <option value="05">5</option>
                                    <option value="06">6</option>
                                    <option value="07">7</option>
                                    <option value="08">8</option>
                                    <option value="09">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <label for="fechaImp">Fecha en que se generó</label>
                                <input class="form-control" type="text" id="fechaGen" name="fechaGen" placeholder="Fecha en que se generaron las facturas" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="tipoServicioImp">Tipo de servicio</label>
                                <select class="form-control" type="text" id="tipoServicioGen" name="tipoServicioGen" required>
                                    <option value="C" selected>Cable</option>
                                    <option value="I">Internet</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="submit" class="btn btn-danger btn-sm" name="submit" value="Ver">
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div><!-- Fin Modal Facturacion #3-->
    <!-- Modal Facturacion #4 -->
    <div id="verFacturasGeneradasC" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <h4 class="modal-title">Ver facturas generadas</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="frmVerFacturasC" action="facturacionGeneradaConta.php" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="tipoComprobanteImp">Tipo de factura</label>
                                <select class="form-control" type="text" id="tipoComprobanteGen" name="tipoComprobanteGen" required>
                                    <option value="">Seleccione tipo de factura</option>
                                    <option value="2">Factura normal</option>
                                    <option value="1">Crédito fiscal</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <label for="cobradorImp">Cobrador</label>
                                <select class="form-control" type="text" id="cobradorGen" name="cobradorGen" required>
                                    <option value="todos" selected>Todos</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="diaImp">Día de cobro</label>
                                <select id="diaImp" class="form-control" id="diaGen" name="diaGen" required>
                                    <option value="">Día de cobro</option>
                                    <option value="01">1</option>
                                    <option value="02">2</option>
                                    <option value="03">3</option>
                                    <option value="04">4</option>
                                    <option value="05">5</option>
                                    <option value="06">6</option>
                                    <option value="07">7</option>
                                    <option value="08">8</option>
                                    <option value="09">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <label for="fechaImp">Fecha en que se generó</label>
                                <input class="form-control" type="text" id="fechaGen" name="fechaGen" placeholder="Fecha en que se generaron las facturas" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="tipoServicioImp">Tipo de servicio</label>
                                <select class="form-control" type="text" id="tipoServicioGen" name="tipoServicioGen" required>
                                    <option value="C" selected>Cable</option>
                                    <option value="I">Internet</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="submit" class="btn btn-danger btn-sm" name="submit" value="Ver">
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div><!-- Fin Modal Facturacion #4 C-->
    <!-- Modal Transaccion #1 -->
    <div id="eliminarAbonos" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <h4 class="modal-title">Administrador de abonos</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="eliminarAbonos" action="php/eliminarAbonos.php?" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input class="form-control" type="text" id="caja_busqueda" name="caja_busqueda" value="" placeholder="Número de recibo, Código del cliente, Fecha del abono, Código del cobrador">

                                <div class="" id="datos">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div><!-- Fin Modal Transacciones #1 -->
    <!-- Modal Reporte #1 -->
    <div id="ReporteProporcional" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <h4 class="modal-title">Reporte detallado de proporciones</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="frmReporteProporcional" action="php/reporteproporcional.php" method="POST" target="_blank">
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-3">
                                <label for="lServicio">Tipo de servicio</label>
                                <select class="form-control" type="text" id="lServicio" name="lServicio" required>
                                    <option value="">Seleccion de servicio</option>
                                    <option value="C">Cable</option>
                                    <option value="I">Internet</option>
                                    <option value="A" selected>Ambos</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="lDesde">Fecha desde</label>
                                <input class="form-control" type="text" id="lDesde" name="lDesde" placeholder="Aplicación de anticipo desde" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="col-md-2">
                                <label for="lHasta">Fecha hasta</label>
                                <input class="form-control" type="text" id="lHasta" name="lHasta" placeholder="Aplicación de anticipo hasta" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="col-md-2">
                                <label for="lDesde">Año proporción</label>
                                <input class="form-control" type="text" id="propor" name="propor" placeholder="Año Proporcional" pattern="[0-9]{4}" value="<?php echo date('Y', strtotime(date('Y') . '- 1 Year')) ?>" required>
                            </div>
                            <div class="col-md-2">
                                <label for="lDetallado">Datallado</label>
                                <input class="form-control" type="checkbox" id="lDetallado" name="lDetallado" value="1" checked>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="submit" class="btn btn-danger btn-sm" name="submit" value="Generar">
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div><!-- Fin Modal Reporte #1 -->
    <!-- Modal para Reportes #2 -->
    <div id="reporteFacturas" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <h4 class="modal-title">Reporte de facturacion generada</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="frmreporteFacturas" action="php/reporteFacturas.php" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="tipoComprobanteImp">Tipo de factura</label>
                                <select class="form-control" type="text" id="tipoComprobanteImp" name="tipoComprobanteImp" required>
                                    <option value="">Seleccione tipo de factura</option>
                                    <option value="2">Factura normal</option>
                                    <option value="1">Crédito fiscal</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <label for="cobradorImp">Cobrador</label>
                                <select class="form-control" type="text" id="cobradorImp" name="cobradorImp" required>
                                    <option value="todos" selected>Todos</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="diaImp">Día de cobro</label>
                                <select id="diaImp" class="form-control" id="diaImp" name="diaImp" required>
                                    <option value="">Día de cobro</option>
                                    <option value="01">1</option>
                                    <option value="02">2</option>
                                    <option value="03">3</option>
                                    <option value="04">4</option>
                                    <option value="05">5</option>
                                    <option value="06">6</option>
                                    <option value="07">7</option>
                                    <option value="08">8</option>
                                    <option value="09">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <label for="fechaImp">Fecha en que se generó</label>
                                <input class="form-control" type="text" id="fechaImp" name="fechaImp" placeholder="Fecha en que se generaron las facturas" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="tipoServicioImp">Tipo de servicio</label>
                                <select class="form-control" type="text" id="tipoServicioImp" name="tipoServicioImp" required>
                                    <option value="C" selected>Cable</option>
                                    <option value="I">Internet</option>
                                    <option value="T">Ambas</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="desdeImp"></label>
                                <input class="form-control" type="text" id="desdeImp" name="desdeImp" placeholder="Número de factura inicial">
                            </div>
                            <div class="col-md-6">
                                <label for="hastaImp"></label>
                                <input class="form-control" type="text" id="hastaImp" name="hastaImp" placeholder="Número de factura terminal">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="submit" class="btn btn-danger btn-sm" name="submit" value="Generar">
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div><!-- Final de Modal Reportes #2 -->
    <!-- Modal Reporte #3 -->
    <div id="reportePendiente2m" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <h4 class="modal-title">Reporte detallado de facturas pendientes</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="frmreportePendiente2m" action="php/reportePendiente2m.php" method="POST" target="_blank">
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-6">
                                <label for="lServicio">Tipo de servicio</label>
                                <select class="form-control" type="text" id="lServicio" name="lServicio" required>
                                    <option value="A">Ambos</option>
                                    <option value="C">Cable</option>
                                    <option value="I">Internet</option>
                                    <option value="T" selected>Paquete</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="Fpendiente">Cantidad de meses</label>
                                <input class="form-control" type="number" id="fpendiente" name="fpendiente" placeholder="Nº" pattern="(0-9)" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="susCobrador">Cobrador</label>
                                <select class="form-control" type="text" id="susCobrador" name="susCobrador" required>
                                    <option value="">Seleccione cobrador</option>
                                    <option value="todos" selected>Todos los cobradores</option>
                                    <?php
                                    require_once 'php/GetAllInfo.php';
                                    $data = new GetAllInfo();
                                    $arrCobradores = $data->getData('tbl_cobradores');
                                    foreach ($arrCobradores as $key) {
                                        echo '<option value="' . $key['codigoCobrador'] . '">' . $key['nombreCobrador'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="submit" class="btn btn-danger btn-sm" name="submit" value="Generar">
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div><!-- Fin Modal Reportes #3 -->
    <!-- Fin Modal Reporte #4 -->
    <div id="reportePendiente3m" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <h4 class="modal-title">Reporte detallado de facturas pendientes por año</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="frmreportePendiente3m" action="php/reportePendiente3m.php" method="POST" target="_blank">
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-6">
                                <label for="lServicio">Tipo de servicio</label>
                                <select class="form-control" type="text" id="lServicio" name="lServicio" required>
                                    <option value="A">Ambos</option>
                                    <option value="C">Cable</option>
                                    <option value="I">Internet</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="lDesde">Año a consultar</label>
                                <input class="form-control" type="text" id="lDesde" name="lDesde" placeholder="Aplicación de anticipo desde" minlength="4" maxlength="4" value="<?php echo date('Y'); ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="lServicio">Mes desde</label>
                                <select class="form-control" type="text" id="mdesde" name="mdesde" required>
                                    <option value="01">Enero</option>
                                    <option value="02">Febrero</option>
                                    <option value="03">Marzo</option>
                                    <option value="04">Abril</option>
                                    <option value="05">Mayo</option>
                                    <option value="06">Junio</option>
                                    <option value="07">Julio</option>
                                    <option value="08">Agosto</option>
                                    <option value="09">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="lServicio">Mes hasta</label>
                                <select class="form-control" type="text" id="mhasta" name="mhasta" required>
                                    <option value="01">Enero</option>
                                    <option value="02">Febrero</option>
                                    <option value="03">Marzo</option>
                                    <option value="04">Abril</option>
                                    <option value="05">Mayo</option>
                                    <option value="06">Junio</option>
                                    <option value="07">Julio</option>
                                    <option value="08">Agosto</option>
                                    <option value="09">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="submit" class="btn btn-danger btn-sm" name="submit" value="Generar">
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div><!-- Fin Modal Reporte #4 -->
    <!-- Modal Reporte #5 -->
    <div id="ReporteOrdenesPend" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <h4 class="modal-title">Reporte de Ordenes</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="frmReporteOrdenesPend" action="php/reporteOrdenesPend.php" method="POST" target="_blank">
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-4">
                                <label for="lServicio">Seleccione tipo de reporte</label>
                                <select class="form-control" type="text" id="tiporeporte" name="tiporeporte" required>
                                    <option value="1" selected>Soporte</option>
                                    <option value="2">Cobro</option>
                                    <option value="3">Renovación</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="lDesde">Fecha de reporte desde</label>
                                <input class="form-control" type="text" id="lDesde" name="lDesde" placeholder="Aplicación de anticipo desde" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="lHasta">Fecha de reporte hasta</label>
                                <input class="form-control" type="text" id="lHasta" name="lHasta" placeholder="Aplicación de anticipo hasta" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="submit" class="btn btn-danger btn-sm" name="submit" value="Generar">
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div><!-- Fin Modal Reporte #5 -->
    <!-- Modal Reportes #6-->
    <div id="totalClientes" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <h4 class="modal-title">Reporte de todos los clientes</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="frmtodosClientes" action="php/reporteClientes.php" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="clCobrador">Cobrador</label>
                                <select class="form-control" type="text" id="clCobrador" name="clCobrador" required>
                                    <option value="">Seleccione cobrador</option>
                                    <option value="todos" selected>Todos los cobradores</option>
                                    <?php
                                    require_once 'php/GetAllInfo.php';
                                    $data = new GetAllInfo();
                                    $arrCobradores = $data->getData('tbl_cobradores');
                                    foreach ($arrCobradores as $key) {
                                        echo '<option value="' . $key['codigoCobrador'] . '">' . $key['nombreCobrador'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="clColonia">Brarrio/Colonia</label>
                                <select class="form-control" type="text" id="clColonia" name="clColonia" required>
                                    <option value="todas" selected>Todas las zonas</option>
                                    <?php
                                    $arrColonias = $data->getData('tbl_colonias_cxc');
                                    foreach ($arrColonias as $key) {
                                        echo '<option value="' . $key['idColonia'] . '">' . $key['nombreColonia'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="clServicio">Tipo de servicio</label>
                                <select class="form-control" type="text" id="clServicio" name="clServicio" required>
                                    <option value="">Seleccione tipo de servicio</option>
                                    <option value="C" selected>Cable</option>
                                    <option value="I">Internet</option>
                                    <option value="A">Paquete</option>
                                    <option value="T">TODOS</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="cldiaCobro">Dia de cobro</label>
                                <input class="form-control" type="number" name="cldiaCobro" value="1">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label for="lDesde">Fecha desde</label>
                                <input class="form-control" type="text" id="lDesde" name="lDesde" placeholder="Aplicación de anticipo desde" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="col-md-2">
                                <label for="lHasta">Fecha hasta</label>
                                <input class="form-control" type="text" id="lHasta" name="lHasta" placeholder="Aplicación de anticipo hasta" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="col-md-3">
                                <label for="clmeses">Meses pendientes</label>
                                <select class="form-control" type="text" id="clmeses" name="clmeses" required>
                                    <option value="1">1 Mes pendiente</option>
                                    <option value="2">2 Meses pendiente</option>
                                    <option value="3">1 Mes o mas pendientes</option>
                                    <option value="4">2 Meses o mas pendientes</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input class="pull-right" type="checkbox" name="ordenarPorColonias" value="1">
                                <label class="pull-right" for="todosLosDias">Ordenar Por Colonia</label><br>
                                <?php
                                if ($_SESSION["rol"] == 'administracion' || $_SESSION["rol"] == 'subgerencia') {
                                    echo '<input class="pull-right" type="checkbox" name="todosLosDias" value="1"><label class="pull-right" for="todosLosDias">Mostrar todos los días de cobro</label>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="submit" class="btn btn-danger btn-sm" name="submit" value="Ver clientes">
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div><!-- Fin Modal Reportes #6 -->
    <!-- Modal Reporte #7 -->
    <div id="reporteOrdenesTrabajo" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <h4 class="modal-title">Reporte de ordenes de trabajo</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="frmReporteOrdenes" action="php/reporteOrdenesTrabajo.php" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="lCobrador">Cobrador</label>
                                <select class="form-control" type="text" id="lCobrador" name="lCobrador" required>
                                    <option value="">Seleccione un técnico</option>
                                    <option value="todos" selected>Todos los técnicos</option>
                                    <?php
                                    require_once 'php/GetAllInfo.php';
                                    $data = new GetAllInfo();
                                    $arrTecnicos = $data->getData('tbl_tecnicos_cxc');
                                    foreach ($arrTecnicos as $key) {
                                        echo '<option value="' . $key['idTecnico'] . '">' . $key['nombreTecnico'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="lColonia">Brarrio/Colonia</label>
                                <select class="form-control" type="text" id="lColonia" name="lColonia" required>
                                    <option value="todas" selected>Todas las zonas</option>
                                    <?php
                                    $arrColonias = $data->getDataCols('tbl_colonias_cxc');
                                    foreach ($arrColonias as $key) {
                                        echo '<option value="' . $key['idColonia'] . '">' . $key['nombreColonia'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="lServicio">Tipo de servicio</label>
                                <select class="form-control" type="text" id="lServicio" name="lServicio" required>
                                    <option value="">Seleccione tipo de servicio</option>
                                    <option value="C" selected>Cable</option>
                                    <option value="I">Internet</option>
                                    <option value="A">Ambos</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="lActividad">Tipo de actividad</label>
                                <select class="form-control" type="text" id="lActividad" name="lActividad" required>
                                    <option value="todas" selected>Todas las actividades</option>
                                    <optgroup label="____CABLE_____">
                                        <?php
                                        $arrActividadesCable = $data->getDataActC('tbl_actividades_cable');

                                        foreach ($arrActividadesCable as $key) {
                                            echo '<option value="' . utf8_decode($key['nombreActividad']) . '">' . utf8_decode($key['nombreActividad']) . '</option>';
                                        }
                                        ?>
                                    </optgroup>
                                    <optgroup label="____INTERNET____">
                                        <?php
                                        $arrActividadesInter = $data->getDataActI('tbl_actividades_inter');

                                        foreach ($arrActividadesInter as $key) {
                                            echo '<option value="' . utf8_decode($key['nombreActividad']) . '">' . utf8_decode($key['nombreActividad']) . '</option>';
                                        }
                                        ?>
                                    </optgroup>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <br>
                                <label for="filtro">Fecha de elaborada</label>
                                <input type="radio" type="text" id="filtroFechaEl" name="filtro" value="1">
                                <label for="filtro">Fecha de finalizada</label>
                                <input type="radio" type="text" id="filtroFechaTer" name="filtro" value="2" checked>
                            </div>
                            <div class="col-md-3">
                                <br>
                                <label for="ordenar">Reporte detallado</label>
                                <input type="radio" type="text" id="detallado" name="tipoReporte" value="1">
                                <label for="ordenar">Reporte general</label>
                                <input type="radio" type="text" id="general" name="tipoReporte" value="2" checked>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="lDesde">Desde fecha</label>
                                <input class="form-control" type="text" id="lDesde" name="lDesde" placeholder="Fecha en que se generaron las facturas" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="lHasta">Hasta fecha</label>
                                <input class="form-control" type="text" id="lHasta" name="lHasta" placeholder="Fecha en que se generaron las facturas" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="submit" class="btn btn-danger btn-sm" name="submit" value="Ver Reporte">
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div><!-- Fin Modal Reporte #7 -->
    <!-- Modal Reportes #8 -->
    <div id="reporteVentasManuales" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <h4 class="modal-title">Reporte de ventas manuales</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="frmVentasManuales" action="php/reporteVentasManuales.php" method="POST" target="_blank">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-7">
                                <label for="idPunto">Punto de venta</label>
                                <select class="form-control" type="text" id="idPunto" name="idPunto" required>
                                    <option value="1" selected>CABLESAT</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label for="lServicio">Tipo de servicio</label>
                                <select class="form-control" type="text" id="lServicio" name="lServicio" required>
                                    <option value="A">Todo</option>
                                    <option value="C" selected>Cable</option>
                                    <option value="I">Internet</option>

                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="lDesde">Desde fecha</label>
                                <input class="form-control" type="text" id="lDesde" name="lDesde" placeholder="Fecha en que se generaron las facturas" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="lHasta">Hasta fecha</label>
                                <input class="form-control" type="text" id="lHasta" name="lHasta" placeholder="Fecha en que se generaron las facturas" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="ordenamiento">Ordenar por fecha</label>
                                <input type="radio" id="ordenamiento" name="ordenamiento" value="fechaComprobante">
                            </div>
                            <div class="col-md-6">
                                <label for="ordenamiento">Ordenar por correlativo</label>
                                <input type="radio" id="ordenamiento" name="ordenamiento" value="numeroComprobante" checked="checked">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="tipoVenta">Tipo de venta</label>
                                <select class="form-control" type="text" id="tipoVenta" name="tipoVenta" required>
                                    <option value="0" selected>Todas</option>
                                    <option value="1">Anulada</option>
                                    <option value="2">Cable extra</option>
                                    <option value="3">Decodificador</option>
                                    <option value="4">Derivacion</option>
                                    <option value="5">Instalación temporal</option>
                                    <option value="6">Pagotardío</option>
                                    <option value="7">Reconexión</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="submit" class="btn btn-danger btn-sm" name="submit" value="Ver reporte">
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div><!-- Fin Modal Reporte #8 -->
    <!-- Modal Reporte #9 -->
    <div id="clientesInstalados" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <h4 class="modal-title">Listado de clientes instalados</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="frmclientesInstalados" action="php/reporteclientesInst.php" method="POST" target="_blank">
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-4">
                                <label for="lServicio">Tipo de servicio</label>
                                <select class="form-control" type="text" id="lServicio" name="lServicio" required>
                                    <option value="">Seleccione tipo de servicio</option>
                                    <option value="CABLE TV">Cable</option>
                                    <option value="INTERNET">Internet</option>
                                    <option value="PAQUETE" selected>Paquete</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="lDesde">Fecha de instalación desde</label>
                                <input class="form-control" type="text" id="lDesde" name="lDesde" placeholder="Aplicación de anticipo desde" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="lHasta">Fecha de instalación hasta</label>
                                <input class="form-control" type="text" id="lHasta" name="lHasta" placeholder="Aplicación de anticipo hasta" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="submit" class="btn btn-danger btn-sm" name="submit" value="Generar">
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div><!-- Fin Modal Reportes #9 -->
    <!-- Modal Reporte #10 -->
    <div id="abonosAplicados" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <h4 class="modal-title">Lista de Abonos ingresados</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="frmAbonosAplicados" action="php/abonosAplicados.php" method="POST" target="_blank">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="lCobrador">Cobrador</label>
                                <select class="form-control" type="text" id="lCobrador" name="lCobrador" required>
                                    <option value="">Seleccione cobrador</option>
                                    <option value="todos" selected>Todos los cobradores</option>
                                    <?php
                                    require_once 'php/GetAllInfo.php';
                                    $data = new GetAllInfo();
                                    $arrCobradores = $data->getData('tbl_cobradores');
                                    foreach ($arrCobradores as $key) {
                                        echo '<option value="' . $key['codigoCobrador'] . '">' . $key['nombreCobrador'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="lColonia">Brarrio/Colonia</label>
                                <select class="form-control" type="text" id="lColonia" name="lColonia" required>
                                    <option value="todas" selected>Todas las zonas</option>
                                    <?php
                                    $arrColonias = $data->getData('tbl_colonias_cxc');
                                    foreach ($arrColonias as $key) {
                                        echo '<option value="' . $key['idColonia'] . '">' . $key['nombreColonia'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="lServicio">Tipo de servicio</label>
                                <select class="form-control" type="text" id="lServicio" name="lServicio" required>
                                    <option value="">Seleccione tipo de servicio</option>
                                    <option value="C">Cable</option>
                                    <option value="I">Internet</option>
                                    <option value="A" selected>Ambos</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="lDesde">Desde fecha</label>
                                <input class="form-control" type="text" id="lDesde" name="lDesde" placeholder="Fecha en que se generaron las facturas" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="lHasta">Hasta fecha</label>
                                <input class="form-control" type="text" id="lHasta" name="lHasta" placeholder="Fecha en que se generaron las facturas" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="lDetallado">Ver reporte detallado</label>
                                <input type="checkbox" name="lDetallado" id="lDetallado" class="form-check-input" value="1" style="margin-top: 10%; width:35px;height:35px;" checked>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="submit" class="btn btn-danger btn-sm" name="submit" value="Ver abonos">
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div><!-- Fin Modal Reporte 10 -->
    <!-- Modal Reporte #11 -->
    <div id="anticiposLiquidados" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <h4 class="modal-title">Detalle de Anticipos Liquidados</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="frmAbonosAplicados" action="php/anticiposLiquidados.php" method="POST" target="_blank">
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-4">
                                <label for="lServicio">Tipo de servicio</label>
                                <select class="form-control" type="text" id="lServicio" name="lServicio" required>
                                    <option value="">Seleccione tipo de servicio</option>
                                    <option value="C">Cable</option>
                                    <option value="I">Internet</option>
                                    <option value="A" selected>Ambos</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="lDesde">Desde</label>
                                <input class="form-control" type="text" id="lDesde" name="lDesde" placeholder="Aplicación de anticipo desde" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="col-md-3">
                                <label for="lHasta">Hasta</label>
                                <input class="form-control" type="text" id="lHasta" name="lHasta" placeholder="Aplicación de anticipo hasta" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="col-md-2">
                                <label for="lDetallado">Detallado</label>
                                <input class="form-control" type="checkbox" id="lDetallado" name="lDetallado" value="1" checked>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="submit" class="btn btn-danger btn-sm" name="submit" value="Ver abonos">
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div><!-- Fin Modal Reporte #11 -->
    <!-- Modal Reporte #12 -->
    <div id="facturasEmitidas" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <h4 class="modal-title">Lista de facturas emitidas</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="frmFacturasEmitidas" action="php/facturasEmitidas.php" method="POST" target="_blank">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="lCobrador">Cobrador</label>
                                <select class="form-control" type="text" id="lCobrador" name="lCobrador" required>
                                    <option value="">Seleccione cobrador</option>
                                    <option value="todos" selected>Todos los cobradores</option>
                                    <?php
                                    require_once 'php/GetAllInfo.php';
                                    $data = new GetAllInfo();
                                    $arrCobradores = $data->getData('tbl_cobradores');
                                    foreach ($arrCobradores as $key) {
                                        echo '<option value="' . $key['codigoCobrador'] . '">' . $key['nombreCobrador'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="lColonia">Brarrio/Colonia</label>
                                <select class="form-control" type="text" id="lColonia" name="lColonia" required>
                                    <option value="todas" selected>Todas las zonas</option>
                                    <?php
                                    $arrColonias = $data->getData('tbl_colonias_cxc');
                                    foreach ($arrColonias as $key) {
                                        echo '<option value="' . $key['idColonia'] . '">' . $key['nombreColonia'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="lServicio">Tipo de servicio</label>
                                <select class="form-control" type="text" id="lServicio" name="lServicio" required>
                                    <option value="">Seleccione tipo de servicio</option>
                                    <option value="C" selected>Cable</option>
                                    <option value="I">Internet</option>
                                    <option value="A">Ambos</option>
                                </select>
                            </div>
                            <div class="col-md-2">

                                <label for="diaCobro">Día cobro</label>
                                <input class="form-control" type="number" name="diaCobro" value="1" required>


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="lTipoLista">Tipo de Factura</label>
                                <select class="form-control" type="text" id="lTipoLista" name="lTipoLista" required>
                                    <option value="2" selected>Consumidor final</option>
                                    <option value="1">Crédito fiscal</option>
                                    <option value="3">Ambas</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <br>
                                <label for="filtro">Fecha de cobro</label>
                                <input type="radio" type="text" id="filtroFechaCob" name="filtro" value="1">
                                <label for="filtro">Fecha de comprobante</label>
                                <input type="radio" type="text" id="filtroFechaComp" name="filtro" value="2" checked>
                            </div>
                            <div class="col-md-3">
                                <br>
                                <label for="todosDias">Todos los días de cobro</label>
                                <input type="checkbox" type="text" id="todosDias" name="todosDias" value="1">
                                <label for="soloAnuladas">Solo facturas anuladas</label>
                                <input type="checkbox" type="text" id="soloAnuladas" name="soloAnuladas" value="1">
                                <label for="soloExentas">Solo facturas exentas</label>
                                <input type="checkbox" type="text" id="soloExentas" name="soloExentas" value="T">
                            </div>
                            <div class="col-md-3">
                                <br>
                                <label for="ordenar">Ordenar por código</label>
                                <input type="radio" type="text" id="ordenarCodigo" name="ordenar" value="1">
                                <label for="ordenar">Ordenar por colonia</label>
                                <input type="radio" type="text" id="ordenarColonia" name="ordenar" value="2">
                                <label for="ordenar">Ordenar por factura</label>
                                <input type="radio" type="text" id="ordenarFactura" name="ordenar" value="3" checked>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="lDesde">Desde fecha</label>
                                <input class="form-control" type="text" id="lDesde" name="lDesde" placeholder="Fecha en que se generaron las facturas" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="lHasta">Hasta fecha</label>
                                <input class="form-control" type="text" id="lHasta" name="lHasta" placeholder="Fecha en que se generaron las facturas" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="submit" class="btn btn-danger btn-sm" name="submit" value="Ver reporte">
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div><!-- Fin Modal Reporte #12 -->
    <div class="modal" id="imprimirSuspensiones">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #d32f2f; color:white;">
                    <h5 class="modal-title">Imprimir Suspensiones por Lote</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="php/SuspensionesXlote.php" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="Inicio">Primero numero de suspension</label>
                                <input type="number" name="inicio" id="inicio" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="Fin">Ultimo numero de suspension</label>
                                <input type="number" name="fin" id="fin" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-danger btn-sm">Imprimir</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="../herramientas/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../herramientas/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../herramientas/dist/js/adminlte.js"></script>

    <script src="js/calendario.js"></script>
    <script>
        $(document).ready(function() {
            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();
            var calendar = $('#calendar').fullCalendar({
                header: {
                    left: 'title',
                    center: 'agendaDay,agendaWeek,month',
                    right: 'prev,next today'
                },
                editable: true,
                firstDay: 0, //  1(Monday) this can be changed to 0(Sunday) for the USA system
                selectable: true,
                defaultView: 'month',
                axisFormat: 'h:mm',
                columnFormat: {
                    month: 'ddd', // Mon
                    week: 'ddd d', // Mon 7
                    day: 'dddd M/d', // Monday 9/7
                    agendaDay: 'dddd d'
                },
                titleFormat: {
                    month: 'MMMM yyyy', // September 2009
                    week: "MMMM yyyy", // September 2009
                    day: 'MMMM yyyy' // Tuesday, Sep 8, 2009
                },
                allDaySlot: false,
                selectHelper: true,
                events: [{
                        title: 'San Miguel, Berlin',
                        start: new Date(y, m, 26),
                        allDay: true,
                    },
                    {
                        title: 'Generacion de suspensiones San Miguel',
                        start: new Date(y, m, 4),
                        allDay: true,
                    },
                    {
                        title: 'Concepcion Batres, El transito, Placitas',
                        start: new Date(y, m, 1),
                        allDay: true,
                    },
                    {
                        title: 'Continental, Ojo de agua, Chinameca',
                        start: new Date(y, m, 2),
                        allDay: true,
                    },
                    {
                        title: 'Alegria',
                        start: new Date(y, m, 3),
                        allDay: true,
                    },
                    {
                        title: 'Santiago de Maria',
                        start: new Date(y, m, 4),
                        allDay: true,
                    },
                    {
                        title: 'Berlin',
                        start: new Date(y, m, 5),
                        allDay: true,
                    },
                    {
                        title: 'Jucuapa',
                        start: new Date(y, m, 6),
                        allDay: true,
                    },
                    {
                        title: 'Ciudad El triunfo',
                        start: new Date(y, m, 8),
                        allDay: true,
                    },
                    {
                        title: 'Jiquilisco, Tecapan, California',
                        start: new Date(y, m, 10),
                        allDay: true,
                    },
                    {
                        title: 'Nueva Guadalupe, Quelepa',
                        start: new Date(y, m, 11),
                        allDay: true,
                    },
                    {
                        title: 'Continental, Ojo de agua, Las charcas, El palmital, Las trancas',
                        start: new Date(y, m, 12),
                        allDay: true,
                    },
                    {
                        title: 'Jucuaran',
                        start: new Date(y, m, 13),
                        allDay: true,
                    },
                    {
                        title: 'Moncagua',
                        start: new Date(y, m, 14),
                        allDay: true,
                    },
                    {
                        title: 'Las trancas, Santiago de maria',
                        start: new Date(y, m, 15),
                        allDay: true,
                    },
                    {
                        title: 'Concepcion Batres, El transito, Chinameca',
                        start: new Date(y, m, 16),
                        allDay: true,
                    },
                    {
                        title: 'Berlin, San Buenaventura',
                        start: new Date(y, m, 17),
                        allDay: true,
                    },
                    {
                        title: 'Nueva Granada, Volcan',
                        start: new Date(y, m, 18),
                        allDay: true,
                    },
                    {
                        title: 'Palo Galan',
                        start: new Date(y, m, 19),
                        allDay: true,
                    },
                    {
                        title: 'Ojo de agua, Las charcas, Analco, Los encuentros, Gualache',
                        start: new Date(y, m, 20),
                        allDay: true,
                    },
                    {
                        title: 'Nueva Guadalupe',
                        start: new Date(y, m, 21),
                        allDay: true,
                    },
                    {
                        title: 'Primavera, Montefresco, Porvenir, Llano el coyol, Los zelayas',
                        start: new Date(y, m, 22),
                        allDay: true,
                    },
                    {
                        title: 'Ojo de agua',
                        start: new Date(y, m, 24),
                        allDay: true,
                    },
                    {
                        title: 'Jiquilisco',
                        start: new Date(y, m, 25),
                        allDay: true,
                    },
                    {
                        title: 'Jucuapa',
                        start: new Date(y, m, 27),
                        allDay: true,
                    },
                    {
                        title: 'San Jorge',
                        start: new Date(y, m, 28),
                        allDay: true,
                    },
                    {
                        title: 'Palo Galan, El milagro, Jocote dulce, Puerto el triunfo,',
                        start: new Date(y, m, 29),
                        allDay: true,
                    },
                    {
                        title: 'Las trancas, Santiago de maria',
                        start: new Date(y, m, 30),
                        allDay: true,
                    },
                ],
            });
        });
    </script>
    <!--<script src="../../dist/js/sb-admin-2.js"></script>-->
    <script src="js/searchab.js"></script>
    <script type="text/javascript">
        // Get the input field
        var mes = document.getElementById("mesGenerar");
        var dia = document.getElementById("diaGenerar");
        var ano = document.getElementById("anoGenerar");

        $('#generarFacturas').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        // Execute a function when the user releases a key on the keyboard
        ano.addEventListener("keyup", function(event) {
            // Number 13 is the "Enter" key on the keyboard
            if (event.keyCode === 13) {
                // Cancel the default action, if needed
                event.preventDefault();
                // Trigger the button element with a click
                var mesGenerar = document.getElementById("mesGenerar").value;
                var diaGenerar = document.getElementById("diaGenerar").value;
                var anoGenerar = document.getElementById("anoGenerar").value;
                ///prueba de subida
                var fechaComprobante = new Date(mesGenerar + "-" + diaGenerar + "-" + anoGenerar);
                console.log(fechaComprobante.setMonth(fechaComprobante.getMonth() + 1));
                document.getElementById("fechaComprobante").value = fechaComprobante.toLocaleDateString();
                console.log(fechaComprobante.setDate(fechaComprobante.getDate() + 8));
                document.getElementById("fechaVencimiento").value = fechaComprobante.toLocaleDateString();
            }
        });
    </script>
    <script type="text/javascript">
        function anularAbono(id) {
            var r = confirm("Realmente desea anular este abono?!");
            if (r == true) {
                window.open("php/anularAbono.php?idAbono=" + id);
            }
        }
    </script>

    <script type="text/javascript">
        function hastaImpFunc() {
            document.getElementById('hastaImp').required = true;
            document.getElementById('desdeImp').required = true;
        }

        function desdeImpFunc() {
            document.getElementById('hastaImp').required = true;
            document.getElementById('desdeImp').required = true;
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.buscador').select2();
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".salir").on("click", function(e) {
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
                    window.location.replace("../../php/logout.php");
                });
            });
        });
    </script>
</body>

</html>