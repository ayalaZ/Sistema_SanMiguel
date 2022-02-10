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
    <link rel="stylesheet" href="../modulo_cxc/css/estilo_cxc.css">
    <!-- SWEETALERT -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.css" />
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.js"></script>
    <style>
        .error{
            color: red;
            font-family:verdana, Helvetica;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="../herramientas/dist/img/logo.png" alt="Cabesat" height="60" width="60">
    </div>
    <!-- Menu superior -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
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
    <!-- menu lateral -->
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
        <?php
        if ($_SESSION["rol"] != "administracion" && $_SESSION["rol"] != "subgerencia" && $_SESSION["rol"] != "jefatura" && $_SESSION["rol"] != "contabilidad") {
            echo "<script>
                            swal('Error', 'No tienes permisos para ingresar a esta área. Att: Don Manuel.', 'error');
                       </script>";
        } else {
        ?>
            <div class="card" style="margin: 10px;">
                <div class="card-header">
                    <h3>Libro Contribuyentes</h3>
                </div>
                <div class="card-body">
                    <form action="php/generar_excel_1.php" method="POST" id="primer_formulario" name="primer_formulario" target="_blank">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="puntoVentaGenerar">Punto de venta:</label>
                                <select name="puntoVentaGenerar" id="puntoVentaGenerar" class="form-control form-control-lg">
                                    <option value="1" selected>Cable sat</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="mes">Mes a generar</label>
                                <select name="mesGenerar" id="mesGenerar" class="form-control form-control-lg">
                                    <option value="1" selected>Enero</option>
                                    <option value="2">Febrero</option>
                                    <option value="3">Marzo</option>
                                    <option value="4">Abril</option>
                                    <option value="5">Mayo</option>
                                    <option value="6">Junio</option>
                                    <option value="7">Julio</option>
                                    <option value="8">Agosto</option>
                                    <option value="9">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="año">Año</label>
                                <input type="number" class="form-control form-control-lg" name="anoGenerar" min="1" max="2500" value="<?php echo date("Y"); ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group clearfix">
                                    <div class="form-check form-check-inline">
                                        <div class="icheck-danger d-inline">
                                            <input type="checkbox" name="encabezados" id="encabezados">
                                            <label for="encabezados">Encabezados</label>
                                        </div>&nbsp;&nbsp;
                                        <div class="icheck-danger d-inline">
                                            <input type="checkbox" name="numPag" id="numPag">
                                            <label for="numPag">Numero de paginas</label>
                                        </div>&nbsp;&nbsp;
                                        <div class="icheck-danger d-inline">
                                            <input type="checkbox" name="libroDetallado" id="libroDetallado" checked>
                                            <label for="libroDetallado">Detalles</label>
                                        </div>&nbsp;&nbsp;
                                        <div class="icheck-danger d-inline">
                                            <input type="checkbox" name="libroResumen" id="libroResumen" checked>
                                            <label for="libroResumen">Resumen</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group clearfix">
                                    <div class="form-check form-check-inline">
                                        <div class="icheck-danger d-inline">
                                            <input class="form-check-input" type="radio" name="facturas" id="facturas" value="1" checked>
                                            <label class="form-check-label" for="facturas">Facturas</label>
                                        </div>&nbsp;&nbsp;
                                        <div class="icheck-danger d-inline">
                                            <input class="form-check-input" type="radio" name="facturas" id="anuladas" value="2">
                                            <label class="form-check-label" for="anuladas">Anuladas</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group clearfix">
                                    <div class="form-check form-check-inline">
                                        <div class="icheck-danger d-inline">
                                            <input class="form-check-input" type="radio" name="documento" id="pdf" value='1' checked>
                                            <label class="form-check-label" for="pdf">PDF</label>
                                        </div>&nbsp;&nbsp;
                                        <div class="icheck-danger d-inline">
                                            <input class="form-check-input" type="radio" name="documento" id="excel" value='2'>
                                            <label class="form-check-label" for="excel">EXCEL</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" name="generar" class="btn btn-danger btn-lg">Generar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card" style="margin: 10px;">
                <div class="card-header">
                    <h3>Libro consumidor final</h3>
                </div>
                <div class="card-body">
                    <form action="php/pdfConsumidorFinal.php" method="POST" target="_blank">
                        <div class="row">
                            <div class="form-group col-md-4 col-xs-4">
                                <label for="codigo">Punto de Venta:</label>
                                <select class="form-control form-control-lg" name="puntoVentaGenerar2" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="1" selected>CABLESAT</option>;
                                </select>
                            </div>
                            <div class="form-group col-md-4 col-xs-4">
                                <label for="nombre">Mes a generar</label>
                                <select class="form-control form-control-lg" name="mesGenerar2" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="1">Enero</option>;
                                    <option value="2">Febrero</option>;
                                    <option value="3">Marzo</option>;
                                    <option value="4">Abril</option>;
                                    <option value="5">Mayo</option>;
                                    <option value="6">Junio</option>;
                                    <option value="7">Julio</option>;
                                    <option value="8">Agosto</option>;
                                    <option value="9">Septiembre</option>;
                                    <option value="10">Octubre</option>;
                                    <option value="11">Noviembre</option>;
                                    <option value="12">Diciembre</option>;
                                </select>
                            </div>
                            <div class="form-group col-md-4 col-xs-4">
                                <label for="nombre">Año:</label>
                                <input type="number" class="form-control form-control-lg" name="anoGenerar2" min="1" max="2500" value="<?php echo date("Y"); ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group clearfix">
                                    <div class="form-check form-check-inline">
                                        <div class="icheck-danger d-inline">
                                            <input type="checkbox" name="encabezados" id="encabezados">
                                            <label for="encabezados">Encabezados</label>
                                        </div>&nbsp;&nbsp;
                                        <div class="icheck-danger d-inline">
                                            <input type="checkbox" name="numPag" id="numPag">
                                            <label for="numPag">Incluir numero de paginas</label>
                                        </div>&nbsp;&nbsp;
                                        <div class="icheck-danger d-inline">
                                            <input type="checkbox" name="libroDetallado" id="libroDetallado">
                                            <label for="libroDetallado">Imprimir libro con detalles</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group clearfix">
                                    <div class="form-check form-check-inline">
                                        <div class="icheck-danger d-inline">
                                            <input class="form-check-input" type="radio" name="Cfacturas" id="recibosN" value="1">
                                            <label class="form-check-label" for="recibosN">Recibos</label>
                                        </div>&nbsp;&nbsp;
                                        <div class="icheck-danger d-inline">
                                            <input class="form-check-input" type="radio" name="Cfacturas" id="facturasN" value="2">
                                            <label class="form-check-label" for="facturasN">Facturas</label>
                                        </div>&nbsp;&nbsp;
                                        <div class="icheck-danger d-inline">
                                            <input class="form-check-input" type="radio" name="Cfacturas" id="anuladasN" value="3">
                                            <label class="form-check-label" for="anuladasN">Anuladas</label>
                                        </div>&nbsp;&nbsp;
                                        <div class="icheck-danger d-inline">
                                            <input class="form-check-input" type="radio" name="Cfacturas" id="todasN" value="4">
                                            <label class="form-check-label" for="todasN">Todas</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group clearfix">
                                    <div class="form-check form-check-inline">
                                        <div class="icheck-danger d-inline">
                                            <input class="form-check-input" type="radio" name="documento2" id="pdf2" value="1">
                                            <label class="form-check-label" for="pdf2">PDF</label>
                                        </div>&nbsp;&nbsp;
                                        <div class="icheck-danger d-inline">
                                            <input class="form-check-input" type="radio" name="documento2" id="excel2" value="2">
                                            <label class="form-check-label" for="excel2">EXCEL</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" name="generar" class="btn btn-danger btn-lg">Generar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
    <!-- extensiones -->
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
</body>
<script src="../herramientas/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../herramientas/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../herramientas/dist/js/adminlte.js"></script>
<script src="js/iva.js"></script>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
</html>