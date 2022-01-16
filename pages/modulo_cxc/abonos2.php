<?php
include("../../php/config.php");
if (!isset($_SESSION)) {
    session_start([
        'cookie_lifetime' => 86400,
    ]);
}
if (!isset($_SESSION["user"])) {
    header('Location: ../login.php');
}
$host = DB_HOST;
$user = DB_USER;
$password = DB_PASSWORD;
$database = $_SESSION['db'];
$mysqli = new mysqli($host, $user, $password, $database);
$clientes = $mysqli->query("SELECT * FROM clientes");
$cobradores = $mysqli->query("SELECT * FROM tbl_cobradores");
$zonas = $mysqli->query("SELECT * FROM tbl_cobradores");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cablesat</title>
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
    <!-- SWEETALERT -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.css" />
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.js"></script>
    <link rel="stylesheet" href="css/abonos.css">
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
            <?php
            include('../controladores/menu.php')
            ?>
        </div>
    </aside>
    <div class="content-wrapper">
        <br>
        <div class="col-md-12">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Abonos</h3>
                    <button class="btn btn-danger float-right" id="estado" name="estado"><i class="fas fa-file-invoice-dollar"></i></button>
                </div>
                <div class="card-body">
                    <form id="frAbonos"  method="POST">
                        <div class="row">
                            <div class="col-md-2 recibo">
                                <input type="text" name="ultimoRecibo" id="ultimoRecibo" class="form-control" value="00000">
                                <label for="recibo">NUMERO DE RECIBO</label>
                            </div>
                            <div class="col-md-2">
                                <label for="dia">Dia de cobro</label>
                                <input type="text" name="diaCobro" id="diaCobro" class="form-control" disabled>
                            </div>
                            <div class="col-md-2">
                                <label for="fechaAbono">Fecha del abono</label>
                                <input type="date" name="fechaAbono" id="fechaAbono" class="form-control" value="<?php echo date('Y-m-d') ?>">
                            </div>
                            <div class="col-md-3">
                                <label for="zona">Zona</label>
                                <select name="zona" id="zona" class="form-control buscador">
                                    <?php
                                    while ($datos = $zonas->fetch_array()) {
                                        if ($datos['nombreCobrador'] == 'ZONA DE COBRO #1 SM') {
                                    ?>
                                            <option value="<?php echo $datos['codigoCobrador'] ?>" selected><?php echo $datos['nombreCobrador'] ?></option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="<?php echo $datos['codigoCobrador'] ?>"><?php echo $datos['nombreCobrador'] ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="cobrador">Cobrador</label>
                                <select name="cobrador" id="cobrador" class="form-control buscador">
                                    <?php
                                    while ($datos = $cobradores->fetch_array()) {
                                        if ($datos['nombreCobrador'] == 'COLECTURIA 1 SAN MIGUEL') {
                                    ?>
                                            <option value="<?php echo $datos['codigoCobrador'] ?>" selected><?php echo $datos['nombreCobrador'] ?></option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="<?php echo $datos['codigoCobrador'] ?>"><?php echo $datos['nombreCobrador'] ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="claseOrden">Codigo</label>
                                <select name="codigo" id="codigo" class="form-control buscador">
                                    <option value="">Selecciona un cliente</option>
                                    <?php
                                    while ($datos = $clientes->fetch_array()) {
                                    ?>
                                        <option value="<?php echo $datos['cod_cliente'] ?>"><?php echo $datos['cod_cliente'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="nombre">Nombre del cliente</label>
                                <input type="text" name="nombreCliente" id="nombreCliente" class="form-control" disabled>
                            </div>
                            <div class="col-md-3">
                                <label for="NRC">NRC</label>
                                <input type="text" name="nrc" id="nrc" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="municipio">Municipio</label>
                                <input type="text" name="municipio" id="municipio" class="form-control" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="colonia">Colonia</label>
                                <input type="text" name="colonia" id="colonia" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="direccion">Direccion</label>
                                <textarea class="form-control" name="direccion" id="direccion" disabled></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="servicio">Servicio</label>
                                <select name="servicio" id="servicio" class="form-control">
                                    <option value="c" id="servicioCABLE">Cable</option>
                                    <option value="i" id="servicioINTERNET">Internet</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="formadepago">Forma de Pago</label>
                                <select class="form-control" type="text" name="formaPago">
                                    <option value="efectivo">Efectivo</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="cuota/impuesto">Cuota/Solo impuesto</label>
                                <select class="form-control" type="text" name="cuotaImpuesto">
                                    <option value="cuota" selected>Cuota</option>
                                    <option value="impuesto">Solo impuesto</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="valor">Valor de la cuota</label>
                                <input type="text" name="valorCuota" id="valorCuota" class="form-control" disabled>
                            </div>
                            <div class="col-md-2">
                                <label for="cuotaapagar">Cuota a pagar</label>
                                <input type="text" name="totalPagar" id="totalPagar" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="concepto">Concepto</label>
                                <input type="text" name="concepto" id="concepto+" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label for="cesc">% CESC</label>
                                <input type="text" name="porImp" id="porImp" class="form-control" disabled>
                            </div>
                            <div class="col-md-2">
                                <label for="impuesto">Impuesto seguridad</label>
                                <input type="text" name="impSeg" id="impSeg" class="form-control" disabled>
                            </div>
                            <div class="col-md-2">
                                <label for="conimpuesto">Cuota + Impuesto</label>
                                <input type="text" name="totalAbonoImpSeg" id="totalAbonoImpSeg" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="aplicarCesc" id="pospago" value="0">
                                    <label class="form-check-label" for="aplicarCesc">Pospago</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="aplicarCesc" id="exento" value="0">
                                    <label class="form-check-label" for="aplicarCesc">Exento</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="aplicarCesc" id="aplicarCesc" value="0.05">
                                    <label class="form-check-label" for="aplicarCesc">Prepago + CESC</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="anularComp">
                                    <label class="form-check-label" for="anularComp">Anular Comprobante</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table" id="cargos">
                                    <thead>
                                        <tr>
                                            <th scope="col">N° Factura</th>
                                            <th scope="col">Mes de servicio</th>
                                            <th scope="col">Cuota</th>
                                            <th scope="col">Vencimiento</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group clearfix">
                                    <div class="icheck-danger d-inline">
                                        <input type="checkbox" name="creditofiscal" id="creditofiscal">
                                        <label for="creditofiscal">Credito Fiscal</label>
                                    </div>&nbsp;
                                    <div class="icheck-danger d-inline">
                                        <input type="checkbox" name="consumidorfinal" id="consumidorfinal">
                                        <label for="consumidorfinal">Consumidor Final</label>
                                    </div>&nbsp;
                                    <div class="icheck-danger d-inline">
                                        <input type="checkbox" name="suspendido" id="suspendido">
                                        <label for="suspendido">Servicio Suspendido</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="meses" id="meses" class="form-control" placeholder="meses">
                            </div>
                            <div class="col-md-3">
                                <select name="xmeses" id="xmeses" class="form-control">
                                    <option value="1">1 mes</option>
                                    <option value="2">2 meses</option>
                                    <option value="3">3 meses</option>
                                    <option value="4">4 meses</option>
                                    <option value="5">5 meses</option>
                                    <option value="6">6 meses</option>
                                    <option value="7">7 meses</option>
                                    <option value="8">8 meses</option>
                                    <option value="9">9 meses</option>
                                    <option value="10">10 meses</option>
                                    <option value="11">11 meses</option>
                                    <option value="12">12 meses</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="hidden" name="proceso" id="proceso" value="abonar">
                                <button type="submit" class="btn btn-danger btn-block"><i class="fas fa-check"></i> Aplicar Abono</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- telefono -->
    <?php
    include('../controladores/telefonos.php');
    ?>
    <!-- telefonos -->
    <script src="../herramientas/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../herramientas/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../herramientas/dist/js/adminlte.js"></script>
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
     <!-- jquery validate -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="js/abonos2.js"></script>

</body>

</html>