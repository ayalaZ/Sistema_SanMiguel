<?php
include("../php/config.php");
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
$bodegas = $mysqli->query("SELECT * FROM tbl_bodega");
if (isset($_POST['bodega'])) {
    $bodega = $_POST['bodega'];
    if ($bodega != "") {
        $articulos = $mysqli->query("SELECT * FROM tbl_articulo WHERE IdBodega='$bodega' ORDER BY IdBodega");
    } else {
        $articulos = $mysqli->query("SELECT * FROM tbl_articulo ORDER BY IdBodega");
    }
} else {
    $articulos = $mysqli->query("SELECT * FROM tbl_articulo ORDER BY IdBodega");
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
    <link rel="stylesheet" href="herramientas/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="herramientas/dist/css/adminlte.min.css">
    <!-- DataTables CSS library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="css/inventario.css">
    <!-- SWEETALERT -->

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="herramientas/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="herramientas/dist/js/adminlte.js"></script>
    <!-- jquery validate -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

    <!-- DataTables JS library -->
    <script type="text/javascript" src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <!-- DataTables JBootstrap -->
    <script type="text/javascript" src="//cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
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
                    <a href="index.php"><?php echo $_SESSION['nombres']; ?></a>
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
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Inventario</h3>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-info float-right"><i class="fas fa-plus"></i> Agregar Nuevo Articulo</button>&nbsp;&nbsp;
                    <form action="inventario.php" method="POST" style="display: inline">
                        <select class="form-control col-md-2 float-right" id="bodega" name='bodega' onchange="this.form.submit()">
                            <option value="">Seleccione Bodega</option>
                            <option value="">Todas</option>
                            <?php
                            while ($datos = $bodegas->fetch_array()) {
                            ?>
                                <option value="<?php echo $datos['IdBodega'] ?>"><?php echo $datos['NombreBodega'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </form>
                </div>
                <div class="card-body">
                    <table class="table tabla">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Nombre</th>
                                <th>Cantidad</th>
                                <th>Bodega</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            while ($datos = $articulos->fetch_array()) {
                                $idBodega = $datos['IdBodega'];
                                $bodega = $mysqli->query("SELECT * FROM tbl_bodega WHERE IdBodega='$idBodega'");
                                $ArregleBodegas = $bodega->fetch_array();
                            ?>
                                <tr>
                                    <td><?php echo $datos['Codigo'] ?></td>
                                    <td><?php echo $datos['NombreArticulo'] ?></td>
                                    <td><?php echo $datos['Cantidad'] ?></td>
                                    <td><?php echo $ArregleBodegas['NombreBodega'] ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-danger" type="button">Opciones</button>
                                            <button class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle='dropdown' aria-haspopup="true" aria-expanded="false">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="Ver dropdown-item" href="#" data-toggle="modal" data-target="#Verarticulo" id="Ver" data="<?php echo $datos['IdArticulo'] ?>"><i class="fas fa-eye"></i> Ver</a>
                                                <a class="editar dropdown-item" href="#" data-toggle="modal" data-target="#EditarArticulo" data="<?php echo $datos['IdArticulo'] ?>"><i class="fas fa-pencil-alt"></i> Editar</a>
                                                <a class="dropdown-item" href="#"><i class="fas fa-trash-alt"></i> Eliminar</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="trasladar dropdown-item" href="#" data-toggle="modal" data-target="#modalTrasladar" data='<?php echo $datos['IdArticulo'] ?>'><i class="fas fa-truck-moving"></i> Trasladar</a>
                                                <a class="Salidad dropdown-item" href="#" data-toggle="modal" data-target="#Salidad" data="<?php echo $datos['IdArticulo'] ?>"><i class="fas fa-undo-alt"></i> Salidas</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
    <!--TELEFONOS -->
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
    <!-- TELEFONOS -->
    <!-- Modal Ver Articulos -->
    <div class="modal fade" id="Verarticulo" tabindex="-1" role="dialog" aria-labelledby="VerarticuloLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="VerarticuloLabel">Detalles</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <td>Codigo</td>
                            <td><input type="text" name="codigo" id="codigo" class="form-control mostrar"></td>
                        </tr>
                        <tr>
                            <td>Nombre</td>
                            <td><input type="text" name="nombre" id="nombre" class="form-control mostrar"></td>
                        </tr>
                        <tr>
                            <td>Descripcion</td>
                            <td><input type="text" name="descripcion" id="descripcion" class="form-control mostrar"></td>
                        </tr>
                        <tr>
                            <td>Cantidad</td>
                            <td><input type="text" name="cantidad" id="cantidad" class="form-control mostrar"></td>
                        </tr>
                        <tr>
                            <td>Fecha</td>
                            <td><input type="text" name="fecha" id="fecha" class="form-control mostrar"></td>
                        </tr>
                        <tr>
                            <td>Proveedor</td>
                            <td><input type="text" name="proveedor" id="proveedor" class="form-control mostrar"></td>
                        </tr>
                        <tr>
                            <td>Tipo</td>
                            <td><input type="text" name="tipo" id="tipo" class="form-control mostrar"></td>
                        </tr>
                        <tr>
                            <td>Categoria</td>
                            <td><input type="text" name="categoria" id="categoria" class="form-control mostrar"></td>
                        </tr>
                        <tr>
                            <td>Bodega</td>
                            <td><input type="text" name="verbodega" id="verbodega" class="form-control mostrar"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin modal Ver articulo -->
    <!-- Modal para salidas -->
    <div class="modal fade" id="Salidad" tabindex="-1" role="dialog" aria-labelledby="SalidadLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="SalidadLabel">Especificaciones de salida</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formulario-salidas" method="POST">
                        <div class="form-group">
                            <label for="Articulo">Nombre de Articulo</label>
                            <input type="text" name="salidad-nombre" id="salidad-nombre" class="form-control mostrar" readonly>
                        </div>
                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <input type="date" name="salidadfecha" id="salidadfecha" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <input type="number" name="salidadcantidad" id="salidadcantidad" class="form-control" min='1'>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripcion</label>
                            <textarea name="salidaddescripcion" id="salidaddescripcion" cols="30" rows="5" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="proceso" id="proceso" value="aplicarsalidad">
                            <button type="submit" class="btn btn-danger btn-lg">Aplicar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin de modal para salidas -->
    <!--Inicio modal de editar -->
    <div class="modal fade" id="EditarArticulo" tabindex="-1" role="dialog" aria-labelledby="EditarArticuloLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditarArticuloLabel">Editar articulo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formularioEditar" method="POST">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="codigo">Codigo</label>
                                <input type="text" name="Editcodigo" id="EditCodigo" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="Articulo">Nombre de Articulo</label>
                                <input type="text" name="Editnombre" id="Editnombre" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="proveedor">Proveedor</label>
                                <select name="Editproveedor" id="Editproveedor" class="form-control">
                                    <option value="">Seleccione proveedor del articulo</option>
                                    <?php
                                    $tipo = $mysqli->query("SELECT * FROM tbl_proveedor");
                                    while ($datos = $tipo->fetch_array()) {
                                    ?>
                                        <option value="<?php echo $datos['IdProveedor'] ?>"><?php echo $datos['Nombre'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="cantidad">Cantidad</label>
                                <input type="number" name="Editcantidad" id="Editcantidad" class="form-control" min='1'>
                            </div>
                            <div class="col-md-6">
                                <label for="fecha">Fecha de entrada</label>
                                <input type="date" name="Editfecha" id="Editfecha" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="precioc">Precio de compra</label>
                                <input type="text" name="EditprecioC" id="EditprecioC" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="preciov">Precio de venta</label>
                                <input type="text" name="EditprecioV" id="EditprecioV" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="credito">N° Credito Fiscal</label>
                                <input type="text" name="Editcredito" id="Editcredito" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="garantia">Garantia (Meses)</label>
                                <input type="number" name="Editgarantia" id="Editgarantia" class="form-control" min='1'>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="tipo">Tipo</label>
                                <select name="Edittipo" id="Edittipo" class="form-control">
                                    <option value="">Seleccione tipo de articulo</option>
                                    <?php
                                    $tipo = $mysqli->query("SELECT * FROM tbl_tipoproducto");
                                    while ($datos = $tipo->fetch_array()) {
                                    ?>
                                        <option value="<?php echo $datos['IdTipoProducto'] ?>"><?php echo $datos['NombreTipoProducto'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="categoria">Categoria</label>
                                <select name="Editcategoria" id="Editcategoria" class="form-control">
                                    <option value="">Seleccione categoria de articulo</option>
                                    <?php
                                    $tipo = $mysqli->query("SELECT * FROM tbl_categoria");
                                    while ($datos = $tipo->fetch_array()) {
                                    ?>
                                        <option value="<?php echo $datos['IdCategoria'] ?>"><?php echo $datos['NombreCategoria'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="bodega">Bodega</label>
                                <select name="Editbodega" id="Editbodega" class="form-control">
                                    <option value="">Seleccione bodega de articulo</option>
                                    <?php
                                    $bodegas = $mysqli->query("SELECT * FROM tbl_bodega");
                                    while ($datos = $bodegas->fetch_array()) {
                                    ?>
                                        <option value="<?php echo $datos['IdBodega'] ?>"><?php echo $datos['NombreBodega'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="unidad">Unidad de medida</label>
                                <select name="Editunidad" id="Editunidad" class="form-control">
                                    <option value="">Seleccione unidad de articulo</option>
                                    <?php
                                    $tipo = $mysqli->query("SELECT * FROM tbl_unidadmedida");
                                    while ($datos = $tipo->fetch_array()) {
                                    ?>
                                        <option value="<?php echo $datos['IdUnidadMedida'] ?>"><?php echo $datos['NombreUnidadMedida'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripcion</label>
                            <textarea name="Editdescripcion" id="Editdescripcion" cols="30" rows="5" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="Editid" id="Editid">
                            <input type="hidden" name="proceso" id="proceso" value="aplicaredicion">
                            <button type="submit" class="btn btn-danger btn-lg">Aplicar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Fin de modal editar -->
    <!--Inicio de modal trasladar -->
    <div class="modal fade" id="modalTrasladar" tabindex="-1" role="dialog" aria-labelledby="modalTrasladarLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTrasladarLabel">Trasladar articulo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formularioTrasladar" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="codigo">Nombre</label>
                                <input type="text" name="Tnombre" id="Tnombre" class="form-control mostrar" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="cantidad">Cantidad</label>
                                <input type="number" name="Tcantidad" id="Tcantidad" class="form-control" min='1'>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="Articulo">Bodega origen</label>
                                <input type="text" name="TbodegaO" id="TbodegaO" class="form-control mostrar" readonly>
                            </div>
                            <div class="col-md-6">
                            <label for="bodega">Bodega destino</label>
                                <select name="TbodegaD" id="TbodegaD" class="form-control">
                                    <option value="">Seleccione bodega de articulo</option>
                                    <?php
                                    $bodegas = $mysqli->query("SELECT * FROM tbl_bodega");
                                    while ($datos = $bodegas->fetch_array()) {
                                    ?>
                                        <option value="<?php echo $datos['IdBodega'] ?>"><?php echo $datos['NombreBodega'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"></div>
                        <div class="form-group">
                            <input type="hidden" name="idtraslado" id="idtraslado">
                            <input type="hidden" name="proceso" id="proceso" value="aplicartraslado">
                            <button type="submit" class="btn btn-danger btn-lg">Aplicar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Fin de modal trasladar -->
    <script>
        $(document).ready(function() {
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
            });
        });
    </script>
    <script src="js/inventario.js"></script>
</body>

</html>