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
    <script src="../herramientas/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
    <!-- AdminLTE App -->
    <script src="../herramientas/dist/js/adminlte.js"></script>
    <!-- SWEETALERT -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <style>
        .error {
            color: red;
            font-family: verdana, Helvetica;
        }
    </style>
    <!-- DataTables CSS library -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css" />
    <!-- DataTables JS library -->
    <script type="text/javascript" src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <!-- DataTables JBootstrap -->
    <script type="text/javascript" src="//cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../modulo_cxc/css/estilo_cxc.css">
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
            <li class="nav-item">
                <a class="nav-link" href="#" role="button" data-toggle="modal" data-target="#busquedaModal"><i class="fas fa-search"></i></a>
            </li>
        </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Navbar Search -->
            <li class="nav-item">
                <a href="#" class="nav-link" role="button" data-toggle="modal" data-target="#modalayuda"><i class="fas fa-question"></i></a>
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
        <a href="../index.php" class="brand-link" style="text-decoration: none;">
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
                    <a href="../index.php" style="text-decoration: none;"><?php echo $_SESSION['nombres'] ?></a>
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
        <div class="card" style="margin: 10px;">
            <div class="card-header">
                <h3>Listado de clientes</h3>
            </div>
            <div class="card-body">
                <a href="addclientes.php" class="btn btn-lg btn-outline-dark" data-toggle="tooltip" title="Nuevo Cliente" data-placement="top"><i class="fas fa-user-plus"></i></a>
                <button class="btn btn-lg btn-outline-dark" data-toggle="tooltip" title="Clientes" data-placement="top" id="cant_clientes"><i class="fas fa-users"></i>&nbsp;&nbsp;</button>
                <table class="table tabla" id="clientes">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Direccion</th>
                            <th>Dui</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
        <?php
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
    <!--MODAL BUSQUEDA -->
    <div id="busquedaModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="busquedaModallabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="background-color: #cc0000;color:#fff;">
                    <h5 class="modal-title">Buscar clientes</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="Cable">Cable</label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="busqCable" id="todosC" value="0" checked>
                                <label class="form-check-label" for="busqCable">Todos</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="busqCable" id="activosC" value="1">
                                <label class="form-check-label" for="busqCable">Activos</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="busqCable" id="suspendidosC" value="2">
                                <label class="form-check-label" for="busqCable">Suspendidos</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="busqCable" id="sinservicioC" value="3">
                                <label class="form-check-label" for="busqCable">Sin servicio</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="internet">Internet</label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="busqInternet" id="todosI" value="0" checked>
                                <label class="form-check-label" for="busqInternet">Todos</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="busqInternet" id="activosI" value="1">
                                <label class="form-check-label" for="busqInternet">Activos</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="busqInternet" id="suspendidosI" value="2">
                                <label class="form-check-label" for="busqInternet">Suspendidos</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="busqInternet" id="sinservicioI" value="3">
                                <label class="form-check-label" for="busqInternet">Sin servicio</label>
                            </div>
                        </div>
                    </div>
                    <table class="table table-hover" id="TableClientes">
                        <thead>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Direccion</th>
                            <th>Dui</th>
                        </thead>
                        <tbody>
                            <?php
                            $datos = $mysqli->query("SELECT cod_cliente,nombre,direccion,numero_dui FROM clientes");
                            while ($clientes = $datos->fetch_array()) {
                            ?>
                                <tr style="cursor: pointer;" class="busquedadClientes" codigo="<?php echo $clientes['cod_cliente'] ?>">
                                    <td style='font-weight:bold;'><?php echo $clientes['cod_cliente'] ?></td>
                                    <td><?php echo $clientes['nombre'] ?></td>
                                    <td style='width:75%;'><?php echo $clientes['direccion'] ?></td>
                                    <td><?php echo $clientes['numero_dui'] ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN MODA BUSQUEDA -->
    <!-- MODAL AYUDA -->
    <div id="modalayuda" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <h4 class="modal-title">Ayuda!</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <ul>
                        <li><input type="color" value="#FFFFFF" disabled> Cclientes sin servicio o suspendidos.</li>
                        <li><input type="color" value="#dc3545" disabled> Clientes con servicio solo de internet.</li>
                        <li><input type="color" value="#198754" disabled> Clientes con servicio solo de cable.</li>
                        <li><input type="color" value="#FFC107" disabled> Clientes con ambos servicios.</li>
                        <li><i class='fas fa-eye'></i> Al dar clic en este icono podras dirigirte a la ventana donde estar toda la informacion del cliente pero sin poder modificar.</li>
                        <li><i class='fas fa-pencil-alt'></i> Si damos clic sobre este icono podemos ir a la ventana donde podriamos modificar la informacion del cliente.</li>
                        <li><i class="fas fa-user-plus"></i> Para poder agregar un nuevo cliente damos clic en este icono y nos redireccionara a la ventana donde podremos ingresar la informacion del cliente.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </div><!-- FIN MODAL AYUDA -->
</body>
<script>
    $(document).ready(function() {
        $('#TableClientes').DataTable({
            dom: 'Pfrtip',
            pageLength: 10,
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
                [0, "asc"]
            ],
        });

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
        $("#clientes tbody").append("<tr><td colspan='5' style='text-align:center;font-weight: bold;font-size:1.6rem'>Cargando datos...</td></tr>");
        $.ajax({
            type: 'POST',
            dataType: 'Json',
            url: "php/clientes.php",
            success: function(datax) {
                $("#clientes tbody").empty();
                var filas = datax.filas;
                for (var i = 0; i < filas; i++) {
                    $CsusServido = datax.clientes[i].servicio_suspendido;
                    $CsinServicio = datax.clientes[i].sin_servicio;
                    if ($CsusServido == "T" && $CsinServicio == "F") {
                        $estadoCable = '1'; //cable suspendido
                        $letrascable = "SC";
                    }
                    if ($CsusServido != "T" && $CsinServicio == "T") {
                        $estadoCable = '2'; //sin servicio cable
                        $letrascable = "SSC";
                    }
                    if ($CsusServido != "T" && $CsinServicio == "F") {
                        $estadoCable = '3'; //cable activo
                        $letrascable = "AC";
                    }
                    $estado = datax.clientes[i].estado_cliente_in;
                    if ($estado == 2) {
                        $estadoInternet = '1'; //internet suspendido
                        $letrasInternet = "SI";
                    }
                    if ($estado == 3) {
                        $estadoInternet = '2'; //internet sin servicio
                        $letrasInternet = "SSI";
                    }
                    if ($estado == 1) {
                        $estadoInternet = '3'; //internet activo
                        $letrasInternet = "AI";
                    }
                    if ($estadoCable == 3 && $estadoInternet == 3) {
                        var nuevafila = "<tr class = 'table-warning'>";
                    }
                    if ($estadoCable == 3 && $estadoInternet != 3) {
                        var nuevafila = "<tr class = 'table-success'>";
                    }
                    if ($estadoCable != 3 && $estadoInternet == 3) {
                        var nuevafila = "<tr class = 'table-danger'>";

                    }

                    if ($estadoCable != 3 && $estadoInternet != 3) {
                        var nuevafila = "<tr>";
                    }

                    nuevafila = nuevafila + "<td style='font-weight:bold;'>" +
                        datax.clientes[i].cod_cliente + "</td><td>" +
                        datax.clientes[i].nombre + "</td><td style='width:50%;'>" +
                        datax.clientes[i].direccion + "</td><td>" +
                        datax.clientes[i].numero_dui + "</td><td><a href='ver_cliente.php?codigo=" + datax.clientes[i].cod_cliente + "' class='btn btn-default btn-sm' name='btn-ver' id='btn-ver' data-toggle='tooltip' title='Ver' data-placement='top'><i class='fas fa-eye'></i></a><a href='editar_cliente.php?codigo=" + datax.clientes[i].cod_cliente + "' class='btn btn-default btn-sm' name='btn-editar' id='btn-editar' data-toggle='tooltip' title='Editar' data-placement='top'><i class='fas fa-pencil-alt'></i></a></td></tr>";
                    $("#clientes tbody").append(nuevafila);
                }
                $("#cant_clientes").append(filas + 1);
                $('.tabla').DataTable({
                    dom: 'Pfrtip',
                    pageLength: 10,
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
                        [0, "asc"]
                    ],
                });
            }
        });
    });
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    });
    $("input:radio[name=busqInternet]").change(function() {
        $cable = $('input:radio[name=busqCable]:checked').val();
        $internet = $('input:radio[name=busqInternet]:checked').val();
        busquedad($cable, $internet);
    });
    $("input:radio[name=busqCable]").change(function() {
        $cable = $('input:radio[name=busqCable]:checked').val();
        $internet = $('input:radio[name=busqInternet]:checked').val();
        busquedad($cable, $internet);
    });

    function busquedad(ca, int) {
        $("#TableClientes").dataTable().fnDestroy();
        $.ajax({
            type: 'POST',
            dataType: 'Json',
            url: 'php/clientes2.php',
            data: {
                cable: ca,
                internet: int
            },
            success: function(datax) {
                $("#TableClientes tbody").empty();
                var filass = datax.filass;
                var nuevafila;
                for (var j = 0; j < filass; j++) {
                    nuevafila = "<tr><td style='font-weight:bold;'>" +
                        datax.clientess[j].cod_cliente + "</td><td>" +
                        datax.clientess[j].nombre + "</td><td style='width:75%;'>" +
                        datax.clientess[j].direccion + "</td><td>" +
                        datax.clientess[j].numero_dui + "</td></tr>";
                    $("#TableClientes tbody").append(nuevafila);
                }
                $('#TableClientes').DataTable({
                    dom: 'Pfrtip',
                    pageLength: 10,
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
                        [0, "asc"]
                    ],
                });
            },
            error: function() {
                swal('Error', 'Ha ocurrido un error al traer la informacion', 'error');
            }
        });
    }
</script>

</html>