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
$servicio = $_SESSION['servicio'];
$codigo = '03215';
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


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="../herramientas/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../herramientas/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../herramientas/dist/js/adminlte.js"></script>

    <!-- SWEETALERT -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.css" />
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.js"></script>
    <style>
        .error {
            color: red;
            font-family: verdana, Helvetica;
        }
    </style>

    <!-- DataTables CSS library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css" />
    <!-- DataTables JS library -->
    <script type="text/javascript" src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <!-- DataTables JBootstrap -->
    <script type="text/javascript" src="//cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <link rel="stylesheet" href="../modulo_cxc/css/estilo_cxc.css">
</head>

<body class="sidebar-mini layout-fixed sidebar-collapse">
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
                <a class="nav-link" data-toggle="modal" data-target="#modalayuda"><i class="fas fa-question"></i></a>
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
    <div class="content-wrapper" style="overflow: hidden;">
        <?php
        if ($_SESSION["rol"] != "administracion" && $_SESSION["rol"] != "subgerencia" && $_SESSION["rol"] != "jefatura" && $_SESSION["rol"] != "contabilidad") {
            echo "<script>
                            swal('Error', 'No tienes permisos para ingresar a esta área. Att: Don Manuel.', 'error');
                       </script>";
        } else {
            $sql = $mysqli->query("SELECT * FROM clientes WHERE cod_cliente='$codigo'");
            $query = $mysqli->query("SELECT tbl_velocidades.nombreVelocidad FROM clientes INNER JOIN tbl_velocidades ON clientes.id_velocidad = tbl_velocidades.idVelocidad WHERE cod_cliente = '$codigo'");
            $datos = $sql->fetch_array();
            $megas = $query->fetch_array();
            $CsusServido = $datos['servicio_suspendido'];
            $CsinServicio = $datos['sin_servicio'];
            if ($CsusServido == "T" && $CsinServicio == "F") {
                $estadoCable = '1';
            } elseif ($CsusServido != "T" && $CsinServicio == "T") {
                $estadoCable = '2';
            } elseif ($CsusServido != "T" && $CsinServicio == "F") {
                $estadoCable = '3';
            }
            $estado = $datos["estado_cliente_in"];
            if ($estado == 2) {
                $estadoInternet = '1';
            } elseif ($estado == 3) {
                $estadoInternet = '2';
            } elseif ($estado == 1) {
                $estadoInternet = '3';
            }
        ?>
            <h3 style="text-align: center;margin-top:5px;"><b>ESTADO DE CUENTA</b></h3>
            <div class="row">
                <div class="col-md-9">
                    <table style="margin-left: 15px; font-size:large;">
                        <tr>
                            <td><b>Codigo:</b></td>
                            <td style="color: red;"><?php echo $codigo ?></td>
                        </tr>
                        <tr>
                            <td><b>Nombre:</b></td>
                            <td style="color: red;"><?php echo $datos['nombre'] ?></td>
                        </tr>
                        <tr>
                            <td><b>Direccion:</b></td>
                            <td style="color: red;"><?php echo $datos['direccion'] ?></td>
                        </tr>
                        <tr>
                            <td><b>Telefono:</b></td>
                            <td style="color: red;"><?php echo $datos['telefonos'] ?></td>
                        </tr>
                        <tr>
                            <td><b>Megas:</b></td>
                            <td style="color: red;"><?php echo $megas['nombreVelocidad'] ?></td>
                        </tr>
                        <tr>
                            <td><b>Servicio:</b></td>
                            <td><input type="checkbox" id="servicio" checked data-toggle="toggle" data-on="Cable" data-off="Internet" data-onstyle="danger" data-offstyle="danger"></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-3">
                    <table style="margin-left: 15px; font-size:large;">
                        <tr>
                            <td><b>Cable:</b></td>
                            <?php
                            switch ($estadoCable) {
                                case '1':
                            ?>
                                    <td style="padding: 10px;font-size:x-large;"><i class="fas fa-times-circle" style="color: red;"></i></td>
                                <?php
                                    break;
                                case '2':
                                ?>
                                    <td style="padding: 10px;font-size:x-large;"><i class="fas fa-user-slash" style="color: gray;"></i></td>
                                <?php
                                    break;
                                case '3':
                                ?>
                                    <td style="padding: 10px;font-size:x-large;"><i class="fas fa-check-circle" style="color: green;"></i></td>
                            <?php
                                    break;
                            }
                            ?>
                            <td><b>Internet:</b></td>
                            <?php
                            switch ($estadoInternet) {
                                case '1':
                            ?>
                                    <td style="padding: 10px;font-size:x-large;"><i class="fas fa-times-circle" style="color: red;"></i></td>
                                <?php
                                    break;
                                case '2':
                                ?>
                                    <td style="padding: 10px;font-size:x-large;"><i class="fas fa-user-slash" style="color: gray;"></i></td>
                                <?php
                                    break;
                                case '3':
                                ?>
                                    <td style="padding: 10px;font-size:x-large;"><i class="fas fa-check-circle" style="color: green;"></i></td>
                            <?php
                                    break;
                            }
                            ?>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Fecha:</b></td>
                            <td colspan="2"><?php date_default_timezone_set('America/El_Salvador');
                                            echo date('d/m/Y H:i:s') ?></td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Dia de cobro:</b></td>
                            <td colspan="2"><?php echo $datos['dia_cobro'] ?></td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Ultimo mes cancelado:</b></td>
                            <td colspan="2"><?php echo $datos['fecha_ult_pago'] ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                <input type="hidden" name="codigo" id="codigo" value="<?php echo $codigo ?>">
                <div class="col-md-12">
                    <table class="table tabla" id="tabla_estado">
                        <thead>
                            <tr>
                                <th>N° Recibo</th>
                                <th>Tipo Servicio</th>
                                <th>N° Comprobante</th>
                                <th>Mes de servicio</th>
                                <th>Aplicacion</th>
                                <th>Vencimiento</th>
                                <th>Cargo</th>
                                <th>Abono</th>
                                <th>CESC cargo</th>
                                <th>CESC abono</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $cargos = $mysqli->query("SELECT * FROM tbl_cargos WHERE codigoCliente='$codigo' AND tipoServicio='$servicio' AND anulada='0' ORDER BY mesCargo");
                            while ($datosCargos = $cargos->fetch_array()) {
                                $mesTabla = '01/' . $datosCargos['mesCargo'];
                                $date = str_replace('/', '-', $mesTabla);
                                $date = date('Ymd', strtotime($date));
                            ?>
                                <tr class="table-danger">
                                    <td><?php echo $datosCargos['numeroRecibo'] ?></td>
                                    <td><?php echo $datosCargos['tipoServicio'] ?></td>
                                    <td><?php echo $datosCargos['numeroFactura'] ?></td>
                                    <td><span style="display: none;"><?php echo $date ?></span><?php echo $datosCargos['mesCargo'] ?></td>
                                    <td><?php echo $datosCargos['fechaFactura'] ?></td>
                                    <td><?php echo $datosCargos['fechaVencimiento'] ?></td>
                                    <td><?php echo number_format($datosCargos['cuotaCable'], 2) ?></td>
                                    <td><?php echo number_format('0.00', 2) ?></td>
                                    <td><?php echo number_format($datosCargos['totalImpuesto'], 2) ?></td>
                                    <td><?php echo number_format('0.00', 2) ?></td>
                                    <td><?php echo number_format($datosCargos['cuotaCable'], 2) ?></td>
                                </tr>
                            <?php
                            }
                            $abonos = $mysqli->query("SELECT * FROM tbl_abonos WHERE codigoCliente='$codigo' AND tipoServicio='$servicio' AND anulada='0' ORDER BY mesCargo");
                            while ($datosAbono = $abonos->fetch_array()) {
                                $mesTabla = '01/' . $datosAbono['mesCargo'];
                                $date = str_replace('/', '-', $mesTabla);
                                $date = date('Ymd', strtotime($date));
                            ?>
                                <tr class="table-success">
                                    <td><?php echo $datosAbono['numeroRecibo'] ?></td>
                                    <td><?php echo $datosAbono['tipoServicio'] ?></td>
                                    <td><?php echo $datosAbono['numeroFactura'] ?></td>
                                    <td><span style="display: none;"><?php echo $date ?></span><?php echo $datosAbono['mesCargo'] ?></td>
                                    <td><?php echo $datosAbono['fechaAbonado'] ?></td>
                                    <td><?php echo $datosAbono['fechaVencimiento'] ?></td>
                                    <td><?php echo number_format('0.00', 2) ?></td>
                                    <td><?php echo number_format($datosAbono['cuotaCable'], 2) ?></td>
                                    <td><?php echo number_format('0.00', 2) ?></td>
                                    <td><?php echo number_format($datosAbono['totalImpuesto'], 2) ?></td>
                                    <td><?php echo number_format($datosAbono['cuotaCable'], 2) ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
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
    <!-- Modal SUSPENSIONES AUTOMATICAS -->
    <div id="modalayuda" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <h4 class="modal-title">Ayuda!</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <ul>
                        <li style="font-size: x-large;"><i class="fas fa-times-circle" style="color: red;"></i> Servicio suspendido</li>
                        <li style="font-size: x-large;"><i class="fas fa-user-slash" style="color: gray;"></i> Sin servicio</li>
                        <li style="font-size: x-large;"><i class="fas fa-check-circle" style="color: green;"></i> Servicio activo</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </div><!-- Fin Modal SUSPENSIONES AUTOMATICAS -->
</body>
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
        $('.tabla').DataTable({
            dom: 'Pfrtip',
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            "order": [
                [3, "desc"]
            ],
        });
    });
    $("#servicio").change(function(){
            $valorServicio = $(this).prop('checked');
            $proceso = 'servicio';
            $codigo = $("#codigo").val();
            $.ajax({
                type : 'POST',
                url : 'php/estado.php',
                data:{proceso:$proceso,valor:$valorServicio,cod:$codigo},
                dataType:'Json',
                success:function(datax){
                    if (datax.filas !=0 && datax.filas2 !=0) {
                        $("#tabla_estado tbody").empty();
                        var filas = datax.filas;
                        for (var i = 0; i < filas; i++) {
                            var nuevafila = "<tr class='table-danger'><td>" +
                                datax.tabla[i].numeroRecibo + "</td><td>" +
                                datax.tabla[i].tipoServicio + "</td><td>" +
                                datax.tabla[i].numeroFactura + "</td><td><span style='display:none;'>" +
                                datax.tabla[i].fecha + "</span>"+datax.tabla[i].mesCargo+"</td><td>"+
                                datax.tabla[i].fechaFactura+"</td><td>"+
                                datax.tabla[i].fechaVencimiento+"</td><td>"+
                                datax.tabla[i].cuota+"</td><td>0.00</td><td>"+
                                datax.tabla[i].totalImpuesto+"</td><td>0.00</td><td>"+
                                datax.tabla[i].cuota+"</td></tr>";
                            $("#tabla_estado tbody").append(nuevafila);
                        }
                        /////////////////////////////////////////////////////////////////////////////////
                        var filas2 = datax.filas2;
                        for (var i = 0; i < filas2; i++) {
                            var nuevafila = "<tr class='table-success'><td>" +
                                datax.tabla2[i].numeroRecibo + "</td><td>" +
                                datax.tabla2[i].tipoServicio + "</td><td>" +
                                datax.tabla2[i].numeroFactura + "</td><td><span style='display:none;'>" +
                                datax.tabla2[i].fecha + "</span>"+datax.tabla2[i].mesCargo+"</td><td>"+
                                datax.tabla2[i].fechaAbonado+"</td><td>"+
                                datax.tabla2[i].fechaVencimiento+"</td><td>0.00</td><td>"+
                                datax.tabla2[i].cuota+"</td><td>0.00</td><td>"+
                                datax.tabla2[i].totalImpuesto+"</td><td>"+
                                datax.tabla2[i].cuota+"</td></tr>";
                            $("#tabla_estado tbody").append(nuevafila);
                        }
                    }
                }
            }); 
        });
</script>

</html>