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
if (isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'];
    $cliente = $mysqli->query("SELECT * FROM clientes WHERE cod_cliente='$codigo'");
    $arrayCliente = $cliente->fetch_array();
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
    <style>
        .accordion-button {
            outline: none !important;
            color: #000 !important;
            outline-width: 0 !important;
            box-shadow: none;
            -moz-box-shadow: none;
            -webkit-box-shadow: none;
            background-color: transparent !important;
            border-bottom: 1px solid #b71c1c;

        }

        .accordion-button:focus {
            border-color: none;
            box-shadow: none;
            outline: 0 none;
            color: #000;
            border-bottom: 1px solid #b71c1c;
        }

        input,
        select,
        textarea {
            color: #CC0000 !important;
            font-size: large !important;
            font-weight: bold;
        }

        .codigo {
            text-align: center;
            border: 1px solid #000;
        }

        .codigo input {
            color: #CC0000;
            background-color: transparent !important;
            border: none;
            text-align: center;
            font-size: x-large !important;
        }
    </style>
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
            <form id="addcliente" method="POST">
                <div class="card-header">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item"><a href="#datos-generales" data-toggle="tab" class="nav-link active" style="text-decoration: none;color:#000;">DATOS GENERALES</a></li>
                        <li class="nav-item"><a href="#otros-datos" data-toggle="tab" class="nav-link" style="text-decoration: none;color:#000;">OTROS DATOS</a></li>
                        <li class="nav-item"><a href="#servicios" data-toggle="tab" class="nav-link" style="text-decoration: none;color:#000;">SERVICIOS</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="datos-generales" role="tabpanel" aria-labelledby="nav-home-tab">
                            <div class="row">
                                <div class="col-md-3 codigo">
                                    <label for="codigo">Código del cliente</label>
                                    <input class="form-control form-control-sm" type="text" name="codigo" id="codigo" value="<?php echo $codigo ?>" style="font-weight: bold;">
                                </div>
                                <div class="col-md-3">
                                    <label for="contrato">N° de contrato (CABLE)</label>
                                    <input class="form-control form-control-sm" type="text" name="contrato" readonly value="<?php echo $arrayCliente['numero_contrato'] ?>">
                                </div>
                                <div class="col-md-3">
                                    <label for="factura">Número de factura</label>
                                    <input class="form-control form-control-sm" type="text" name="factura" readonly value="<?php echo $arrayCliente['numero_factura'] ?>">
                                </div>
                                <div class="col-md-3">
                                    <label for="nAnexo">Número de anexo</label>
                                    <input class="form-control form-control-sm" type="text" name="nAnexo" readonly value="<?php echo $arrayCliente['Anexo'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9 caja">
                                    <label for="nombre">Nombre</label>
                                    <input class="form-control form-control-sm" type="text" name="nombre" value="<?php echo $arrayCliente['nombre'] ?>">
                                </div>
                                <div class="col-md-3">
                                    <label for="ncr">Número de registro</label>
                                    <input class="form-control form-control-sm" type="text" id="nrc" name="nrc" value="<?php echo $arrayCliente['num_registro'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <label for="nombre">Nombre Comercial</label>
                                    <input class="form-control form-control-sm" type="text" name="nombre_comercial" value="<?php echo $arrayCliente['nombre_comercial'] ?>">
                                </div>
                                <div class="col-md-3">
                                    <label for="nacionalidad">Nacionalidad</label>
                                    <input class="form-control form-control-sm" type="text" id="nacionalidad" name="nacionalidad" value="<?php echo $arrayCliente['nacionalidad'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="saldoCable">Saldo actual cable</label>
                                    <input class="form-control form-control-sm" type="text" name="saldoCable" value="<?php echo $arrayCliente['saldoCable'] ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="saldoInternet">Saldo actual internet</label>
                                    <input class="form-control form-control-sm" type="text" name="saldoInternet" value="<?php echo $arrayCliente['sadoInternet'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="dui">DUI</label>
                                    <input class="form-control form-control-sm" type="text" id="dui" name="dui" value="<?php echo $arrayCliente['numero_dui'] ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="expedicion">Lugar y fecha de expedición</label>
                                    <input class="form-control form-control-sm" type="text" name="expedicion" value="<?php echo $arrayCliente['lugar_exp'] ?>">
                                </div>
                                <div class="col-md-3">
                                    <label for="nit">NIT</label>
                                    <input class="form-control form-control-sm" type="text" id="nit" name="nit" value="<?php echo $arrayCliente['numero_nit'] ?>">
                                </div>
                                <div class="col-md-3">
                                    <label for="fechaNacimiento">Fecha de nacimiento</label>
                                    <input class="form-control form-control-sm" type="date" id="fechaNacimiento" name="fechaNacimiento" value="<?php echo $arrayCliente['fecha_nacimiento'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="direccion">Dirección</label>
                                    <textarea class="form-control form-control-sm" name="direccion" rows="2" cols="40" id="direccion"><?php echo $arrayCliente['direccion'] ?></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="departamento">Departamento</label>
                                    <?php
                                    $idDepartamento = $arrayCliente['id_departamento'];
                                    $departamento = $mysqli->query("SELECT * FROM tbl_departamentos_cxc WHERE idDepartamento='$idDepartamento'");
                                    $arrayDepartamento = $departamento->fetch_array();
                                    ?>
                                    <input type="text" class="form-control form-control-sm" id="departamento" name="departamento" value="<?php echo $arrayDepartamento['nombreDepartamento']; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="municipio">Municipio</label>
                                    <?php
                                    $idMunicipio = $arrayCliente['id_municipio'];
                                    $municipio = $mysqli->query("SELECT * FROM tbl_municipios_cxc WHERE idMunicipio='$idMunicipio'");
                                    $arraymunicipio = $municipio->fetch_array();
                                    ?>
                                    <input type="text" class="form-control form-control-sm" id="municipio" name="municipio" value="<?php echo $arraymunicipio['nombreMunicipio']; ?>">
                                </div>
                                <div class="col-md-5">
                                    <label for="colonia">Barrio o colonia</label>
                                    <?php
                                    $idColonia = $arrayCliente['id_colonia'];
                                    $colonia = $mysqli->query("SELECT * FROM tbl_colonias_cxc WHERE idColonia='$idColonia'");
                                    $arraycolonia = $colonia->fetch_array();
                                    ?>
                                    <input type="text" class="form-control form-control-sm" id="colonia" name="colonia" value="<?php echo $arraycolonia['nombreColonia']; ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="direccionCobro">Dirección de cobro</label>
                                    <textarea class="form-control form-control-sm" name="direccionCobro" rows="2" cols="40" id="direccionCobro"><?php echo $arrayCliente['direccion_cobro'] ?></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="telefono">Teléfono</label>
                                    <input class="form-control form-control-sm" type="text" name="telefono" value="<?php echo $arrayCliente['telefonos'] ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="telefonoTrabajo">Teléfono de trabajo</label>
                                    <input class="form-control form-control-sm" type="text" name="telefonoTrabajo" <?php echo $arrayCliente['tel_trabajo'] ?>>
                                </div>
                                <div class="col-md-4">
                                    <label for="ocupacion">Ocupación</label>
                                    <input class="form-control form-control-sm" type="text" name="ocupacion" <?php echo $arrayCliente['profesion'] ?>>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="cuentaContable">Cuenta contable</label>
                                    <input class="form-control form-control-sm" type="text" name="cuentaContable" readonly value="<?php echo $arrayCliente['id_cuenta'] ?>">
                                </div>
                                <div class="col-md-3">
                                    <label for="formaFacturar">Forma al facturar</label>
                                    <?php
                                    $idforma = $arrayCliente['forma_pago'];
                                    $formaPago = $mysqli->query("SELECT * FROM tbl_forma_pago WHERE idFormaPago='$idforma'");
                                    $arrayForma = $formaPago->fetch_array();
                                    ?>
                                    <input type="text" class="form-control form-control-sm" id="FormaPago" name="FormaPago" value="<?php echo $arrayForma['nombreFormaPago']; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="tipoComprobante">Tipo de comprobante</label>
                                    <?php
                                    $idComprobante = $arrayCliente['tipo_comprobante'];
                                    $tipo_comprobante = $mysqli->query("SELECT * FROM tbl_tipo_comprobante WHERE idComprobante='$idComprobante'");
                                    $arrayComprobante = $tipo_comprobante->fetch_array();
                                    $queryComprobante = $mysqli->query("SELECT * FROM tbl_tipo_comprobante");
                                    ?>
                                    <input type="text" class="form-control form-contro-sm" id="tipoComprobante" name="tipoComprobante" value="<?php echo $arrayComprobante['nombreComprobante'] ?>">
                                </div>
                                <div class="col-md-2">
                                    <label for="saldoActual">Saldo actual</label>
                                    <input class="form-control form-control-sm" type="text" name="saldoActual" value="<?php echo $arrayCliente['saldo_actual'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="facebook">Cuenta de Facebook</label>
                                    <input class="form-control form-control-sm" type="text" name="facebook" value="<?php echo $arrayCliente['facebook'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="correo">Correo electrónico</label>
                                    <input class="form-control form-control-sm" type="text" name="correo" value="<?php echo $arrayCliente['correo_electronico'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="otros-datos" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="cobrador">Cobrador que lo atiende</label>
                                    <?php
                                    $idCobrador = $arrayCliente['cod_cobrador'];
                                    $cobrador = $mysqli->query("SELECT * FROM tbl_cobradores WHERE codigoCobrador='$idCobrador'");
                                    $arrayCobrador = $cobrador->fetch_array();
                                    ?>
                                    <input type="text" class="form-control form-control-sm" value="<?php echo $arrayCobrador['nombreCobrador'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="rp1_nombre">Referencia personal #1</label>
                                    <input class="form-control form-control-sm" type="text" name="rf1_nombre" value="<?php echo $arrayCliente['contactos'] ?>">
                                </div>
                                <div class="col-md-2">
                                    <label for="rp1_telefono">Teléfono</label>
                                    <input class="form-control form-control-sm" type="text" name="rp1_telefono" value="<?php echo $arrayCliente['telcon1'] ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="rp1_direccion">Dirección</label>
                                    <input class="form-control form-control-sm" type="text" name="rp1_direccion" value="<?php echo $arrayCliente['dir1'] ?>">
                                </div>
                                <div class="col-md-2">
                                    <label for="rp1_parentezco">Parentezco</label>
                                    <input class="form-control form-control-sm" type="text" name="rp1_parentezco" value="<?php echo $arrayCliente['paren1'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="rp2_nombre">Referencia personal #2</label>
                                    <input class="form-control form-control-sm" type="text" name="rf2_nombre" value="<?php echo $arrayCliente['contacto2'] ?>">
                                </div>
                                <div class="col-md-2">
                                    <label for="rp2_telefono">Teléfono</label>
                                    <input class="form-control form-control-sm" type="text" name="rp2_telefono" value="<?php echo $arrayCliente['telcon2'] ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="rp2_direccion">Dirección</label>
                                    <input class="form-control form-control-sm" type="text" name="rp2_direccion" value="<?php echo $arrayCliente['dir2'] ?>">
                                </div>
                                <div class="col-md-2">
                                    <label for="rp2_parentezco">Parentezco</label>
                                    <input class="form-control form-control-sm" type="text" name="rp2_parentezco" value="<?php echo $arrayCliente['paren2'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="rp3_nombre">Referencia personal #3</label>
                                    <input class="form-control form-control-sm" type="text" name="rf3_nombre" value="<?php echo $arrayCliente['contacto3'] ?>">
                                </div>
                                <div class="col-md-2">
                                    <label for="rp3_telefono">Teléfono</label>
                                    <input class="form-control form-control-sm" type="text" name="rp3_telefono" value="<?php echo $arrayCliente['telcon3'] ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="rp3_direccion">Dirección</label>
                                    <input class="form-control form-control-sm" type="text" name="rp3_direccion" value="<?php echo $arrayCliente['dir3'] ?>">
                                </div>
                                <div class="col-md-2">
                                    <label for="rp3_parentezco">Parentezco</label>
                                    <input class="form-control form-control-sm" type="text" name="rp3_parentezco" value="<?php echo $arrayCliente['paren3'] ?>">
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="servicios" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="accordion" id="accordio-servicios">
                                <div class="accordion-item">
                                    <!--CABLE -->
                                    <h2 class="accordion-header" id="item1">
                                        <button class="accordion-button" type="button" data-bs-toggle='collapse' data-bs-target='#collapse1' aria-expanded="true" aria-controls="collapse1">TV POR CABLE</button>
                                    </h2>
                                    <div class="accordion-collapse collapse" id="collapse1" aria-labelledby="item1" data-bs-parent='#accordio-servicios'>
                                        <div class="accordion-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="fechaInstalacionCable">Fecha de instalación</label>
                                                    <input class="form-control form-control-sm" type="date" id="fechaInstalacionCable" name="fechaInstalacionCable" value="<?php echo $arrayCliente['fecha_instalacion'] ?>">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="fechaPrimerFacturaCable">Fecha primer factura</label>
                                                    <input class="form-control form-control-sm" type="date" id="fechaPrimerFacturaCable" name="fechaPrimerFacturaCable" value="<?php echo $arrayCliente['fecha_primer_factura'] ?>">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="mesesContratoCable">Meses de contrato</label>
                                                    <input class="form-control form-control-sm" type="number" id="mesesContratoCable" name="mesesContratoCable" value="<?php echo $arrayCliente['periodo_contrato_ca'] ?>">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="exento">Exento</label>
                                                    <?php
                                                    if ($arrayCliente['exento'] == 'T') {
                                                    ?>
                                                        <input type="checkbox" name="exento" id="exento" class="form-check-input" value="T" style="margin-top: 10%; width:35px;height:35px;" disabled checked>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <input type="checkbox" name="exento" id="exento" class="form-check-input" value="T" style="margin-top: 10%; width:35px;height:35px;" disabled>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="cortesia">Cortesía</label>
                                                    <?php
                                                    if ($arrayCliente['servicio_cortesia'] == 'T') {
                                                    ?>
                                                        <input type="checkbox" name="cortesia" id="cortesia" class="form-check-input" value="T" style="margin-top: 10%; width:35px;height:35px;" disabled checked>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <input type="checkbox" name="cortesia" id="cortesia" class="form-check-input" value="T" style="margin-top: 10%; width:35px;height:35px;" disabled>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label for="cuotaMensualCable">Cuota mensual</label>
                                                    <input class="form-control form-control-sm" type="text" name="cuotaMensualCable" value="<?php echo number_format($arrayCliente['valor_cuota'], 2) ?>">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="prepago">Prepago</label>
                                                    <input class="form-control form-control-sm" type="text" name="prepago" value="<?php echo number_format($arrayCliente['prepago'], 2) ?>">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="tipoServicio">Tipo de servicio</label>
                                                    <?php
                                                    $idTipoServicio = $arrayCliente['tipo_servicio'];
                                                    $TipoServicio = $mysqli->query("SELECT * FROM tbl_servicios_cable WHERE idServicioCable='$idTipoServicio'");
                                                    $arrayTipoServicio = $TipoServicio->fetch_array();
                                                    ?>
                                                    <input type="text" class="form-control form-control-sm" id="tipoServicioCable" name="tipoServicioCable" value="<?php echo $arrayTipoServicio['nombreServicioCable'] ?>">
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="diaGenerarFacturaCable">Día cobro</label>
                                                    <input class="form-control form-control-sm" type="number" name="diaGenerarFacturaCable" value="<?php echo $arrayCliente['dia_cobro'] ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="inicioContratoCable">Inicio de contrato</label>
                                                    <input class="form-control form-control-sm" type="date" id="inicioContratoCable" name="inicioContratoCable" value="<?php echo $arrayCliente['fecha_instalacion'] ?>">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="vencimientoContratoCable">Vence contrato</label>
                                                    <input class="form-control form-control-sm" type="date" id="vencimientoContratoCable" name="vencimientoContratoCable" value="<?php echo $arrayCliente['vencimiento_ca'] ?>">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="fechaSuspensionCable">Fecha suspension</label>
                                                    <input class="form-control form-control-sm" style="color: #b71c1c;" type="date" id="fechaSuspensionCable" name="fechaSuspensionCable" value="<?php echo $arrayCliente['fecha_suspension'] ?>">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="fechaReconexionCable">Fecha de reconexión</label>
                                                    <input class="form-control form-control-sm" type="date" id="fechaReconexionCable" name="fechaReconexionCable" value="<?php echo $arrayCliente['fecha_reinstalacion'] ?>">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="derivaciones">N° de derivaciones</label>
                                                    <input class="form-control form-control-sm" type="number" name="derivaciones" value="<?php echo $arrayCliente['numero_derivaciones'] ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="encargadoInstalacionCable">Técnico que realizó la instalación</label>
                                                    <?php
                                                    $idTecnicoCable = $arrayCliente['id_tecnico'];
                                                    $tecnicoCable = $mysqli->query("SELECT * FROM tbl_tecnicos_cxc WHERE idTecnico='$idTecnicoCable'");
                                                    $arrayTecnico = $tecnicoCable->fetch_array();
                                                    ?>
                                                    <input type="text" class="form-control form-control-sm" id="encargadoInstalacionCable" name="encargadoInstalacionCable" value="<?php echo $arrayTecnico['nombreTecnico'] ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label style="color: #CC0000" for="cuotaCovidC">Cuota COVID-19</label>
                                                    <input class="form-control form-control-sm " type="text" id="cuotaCovidC" name="cuotaCovidC" value="<?php echo $arrayCliente['cuotaCovidC'] ?>">
                                                </div>
                                                <div class="col-md-4">
                                                    <label style="color: #CC0000" for="covidDesdeC">Desde</label>
                                                    <input class="form-control form-control-sm " type="date" id="covidDesdeC" name="covidDesdeC" value="<?php echo $arrayCliente['covidDesdeC'] ?>">
                                                </div>
                                                <div class="col-md-4">
                                                    <label style="color: #CC0000" for="covidHastaC">Hasta</label>
                                                    <input class="form-control form-control-sm" type="date" id="covidHastaC" name="covidHastaC" value="<?php echo $arrayCliente['covidHastaC'] ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="direccionCable">Dirección</label>
                                                    <input class="form-control form-control-sm" type="text" name="direccionCable" id="direccionCable" value="<?php echo $arrayCliente['dire_cable'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--INTERNET -->
                                    <h2 class="accordion-header" id="item2">
                                        <button class="accordion-button" type="button" data-bs-toggle='collapse' data-bs-target='#collapse2' aria-expanded="true" aria-controls="collapse2">INTERNET</button>
                                    </h2>
                                    <div class="accordion-collapse collapse" id="collapse2" aria-labelledby="item2" data-bs-parent='#accordio-servicios'>
                                        <div class="accordion-body">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label for="fechaInstalacionInternet">Fecha de instalación</label>
                                                    <input class="form-control form-control-sm" type="date" id="fechaInstalacionInternet" name="fechaInstalacionInternet" value="<?php echo $arrayCliente['fecha_instalacion_in'] ?>">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="fechaPrimerFacturaInternet">Fecha primer factura</label>
                                                    <input class="form-control form-control-sm" type="date" id="fechaPrimerFacturaInternet" name="fechaPrimerFacturaInternet" value="<?php echo $arrayCliente['fecha_primer_factura_in'] ?>">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="mesesContratoInternet">Meses de contrato</label>
                                                    <input class="form-control form-control-sm" type="number" id="mesesContratoInternet" name="mesesContratoInternet" value="<?php echo $arrayCliente['periodo_contrato_int'] ?>">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="tipoServicioInternet">Tipo de servicio</label>
                                                    <?php
                                                    $idTipoServicioInternet = $arrayCliente['tipo_servicio_in'];
                                                    $servicio_in = $mysqli->query("SELECT * FROM tbl_servicios_inter WHERE idServicioInter='$idTipoServicioInternet'");
                                                    $arrayServicioIn = $servicio_in->fetch_array();
                                                    ?>
                                                    <input type="text" class="form-control form-control-sm" id="tipoServicioInternet" name="tipoServicioInternet" value="<?php echo $arrayServicioIn['nombreServicioInter'] ?>">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="diaGenerarFacturaInternet">Día para generar factura</label>
                                                    <input class="form-control form-control-sm" type="number" name="diaGenerarFacturaInternet" value="<?php echo $arrayCliente['dia_corbo_in'] ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="velocidadInternet">Velocidad</label>
                                                    <?php
                                                    $idVelocidad = $arrayCliente['id_velocidad'];
                                                    $velocidad = $mysqli->query("SELECT * FROM tbl_velocidades WHERE idVelocidad='$idVelocidad'");
                                                    $arrayVelocidad = $velocidad->fetch_array();
                                                    ?>
                                                    <input type="text" class="form-control form-control-sm" id="velocidadInternet" name="velocidadInternet" value="<?php echo $arrayVelocidad['nombreVelocidad'] ?>">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="cuotaMensualInternet">Cuota mensual</label>
                                                    <input class="form-control form-control-sm internet" type="text" name="cuotaMensualInternet" value="<?php echo number_format($arrayCliente['cuota_in'],2) ?>">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="prepago_in">Prepago</label>
                                                    <input class="form-control form-control-sm" type="text" name="prepago_in" value="<?php echo number_format($arrayCliente['prepago_in'],2) ?>">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="tipoCliente">Tipo de cliente</label>
                                                        <?php
                                                        $idTipoCliente = $arrayCliente['id_tipo_cliente'];
                                                        $tipoCliente = $mysqli->query("SELECT * FROM tbl_tipos_clientes WHERE idTipoCliente='$idTipoCliente'");
                                                        $arrayTipoCliente = $tipoCliente->fetch_array();
                                                        ?>
                                                    <input type="text" class="form-control form-control-sm" id="tipoCliente" name="tipoCliente" value="<?php echo $arrayTipoCliente['nombreTipoCliente'] ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="tecnologia">Tecnología</label>
                                                    <input type="text" class="form-control form-control-sm" id="tecnologia" name="tecnologia" value="<?php echo $arrayCliente['tecnologia'] ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="enCalidad">En calidad de</label>
                                                    <input class="form-control form-control-sm" type="text" name="enCalidad" value="<?php echo $arrayCliente['entrega_calidad'] ?>">
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="tipo_de_contrato">Tipo de contrato</label>
                                                    <select class="form-control form-control-sm" name="tipo_de_contrato">
                                                        <option value="">Seleccione</option>
                                                        <option value="Nuevo">Nuevo</option>
                                                        <option value="Reconexion">Reconexión</option>
                                                        <option value="Renovacion">Renovación</option>
                                                    </select>
                                                    <input type="text" class="form-control form-control-sm" id="tipo_de_contrato" name="tipo_de_contrato" value="<?php echo $arrayCliente['tipo_de_contrato'] ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="nContratoVigente">N° de contrato (INTERNET)</label>
                                                    <input class="form-control form-control-sm" type="text" name="nContratoVigente" value="<?php echo $arrayCliente['no_contrato_inter'] ?>">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="vencimientoContratoInternet">Vencimiento de contrato</label>
                                                    <input class="form-control form-control-sm" type="date" id="vencimientoContratoInternet" name="vencimientoContratoInternet" value="<?php echo $arrayCliente['vencimiento_in'] ?>">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="ultimaRenovacionInternet">Última renovación</label>
                                                    <input class="form-control form-control-sm" type="date" id="ultimaRenovacionInternet" name="ultimaRenovacionInternet" <?php echo $arrayCliente['ult_ren_in'] ?>>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="fechaSuspencionInternet">Fecha de suspensión</label>
                                                    <input class="form-control form-control-sm" style="color: #b71c1c;" type="date" id="fechaSuspencionInternet" name="fechaSuspencionInternet" value="<?php echo $arrayCliente['ultima_suspencion_in'] ?>">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="fechaReconexionInternet">Fecha de reconexión</label>
                                                    <input class="form-control form-control-sm" type="date" id="fechaReconexionInternet" name="fechaReconexionInternet" value="<?php echo $arrayCliente['fecha_reconexion_in'] ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label for="promocion">Promoción</label>
                                                    <input class="form-control form-control-sm" type="text" name="promocion" value="<?php echo $arrayCliente['id_promocion'] ?>">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="promocionDesde">Desde</label>
                                                    <input class="form-control form-control-sm" type="date" name="promocionDesde" value="<?php echo $arrayCliente['dese_promocion_in'] ?>">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="promocionHasta">Hasta</label>
                                                    <input class="form-control form-control-sm" type="date" name="promocionHasta" value="<?php echo $arrayCliente['hasta_promocion_in'] ?>">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="cuotaPromocion">Cuota de la promoción</label>
                                                    <input class="form-control form-control-sm" type="text" name="cuotaPromocion" value="<?php echo $arrayCliente['cuota_promocion'] ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <label for="encargadoInstalacionInter">Técnico que realizó la instalación</label>
                                                    <?php
                                                    $idTecnicoInter = $arrayCliente['id_tecnico_in'];
                                                    $tecnicoInter = $mysqli->query("SELECT * FROM tbl_tecnicos_cxc WHERE idTecnico='$idTecnicoInter'");
                                                    $arrayTecnico = $tecnicoInter->fetch_array();
                                                    ?>
                                                    <input type="text" class="form-control form-control-sm" id="encargadoInstalacionInter" name="encargadoInstalacionInter" value="<?php echo $arrayTecnico['nombreTecnico'] ?>">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="costoInstalacionIn">Costo de instalación</label>
                                                    <input class="form-control form-control-sm" type="text" name="costoInstalacionIn" value="<?php echo $arrayCliente['costo_instalacion_in'] ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label style="color: #CC0000" for="cuotaCovidI">Cuota COVID-19</label>
                                                    <input class="form-control form-control-sm" type="text" id="cuotaCovidI" name="cuotaCovidI" value="<?php echo $arrayCliente['cuotaCovidI'] ?>">
                                                </div>
                                                <div class="col-md-4">
                                                    <label style="color: #CC0000" for="covidDesdeI">Desde</label>
                                                    <input class="form-control form-control-sm" type="date" id="covidDesdeI" name="covidDesdeI" value="<?php echo $arrayCliente['covidDesdeI'] ?>">
                                                </div>
                                                <div class="col-md-4">
                                                    <label style="color: #CC0000" for="covidHastaI">Hasta</label>
                                                    <input class="form-control form-control-sm" type="date" id="covidHastaI" name="covidHastaI" value="<?php echo $arrayCliente['covidHastaI'] ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="direccionInternet">Dirección</label>
                                                    <input class="form-control form-control-sm" type="text" name="direccionInternet" id="direccionInternet" value="<?php echo $arrayCliente['dire_internet'] ?>">
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="colilla">Colilla</label>
                                                            <input class="form-control form-control-sm" type="text" name="colilla" value="<?php echo $arrayCliente['colilla'] ?>">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label for="wanip">WAN IP</label>
                                                            <input class="form-control form-control-sm" type="text" id="wanip" name="wanip" value="<?php echo $arrayCliente['wanip'] ?>">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label for="coordenadas">Coordenadas</label>
                                                            <input class="form-control form-control-sm" type="text" name="coordenadas" value="<?php echo $arrayCliente['coordenadas'] ?>">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label for="nodo">Nodo/Ap/Path</label>
                                                            <input class="form-control form-control-sm" type="text" name="nodo" value="<?php echo $arrayCliente['dire_telefonia'] ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <label for="modelo">Modelo</label>
                                                            <input class="form-control form-control-sm" type="text" name="modelo" value="<?php echo $arrayCliente['marca_modem'] ?>">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="recepcion">Recepción</label>
                                                            <input class="form-control form-control-sm" type="text" name="recepcion" value="<?php echo $arrayCliente['recep_modem'] ?>">
                                                        </div>
                                                        <div class="col-md-8">
                                                            <label for="mac">MAC</label>
                                                            <input class="form-control form-control-sm" type="text" id="mac" name="mac" value="<?php echo $arrayCliente['mac_modem'] ?>">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="transmicion">Transmisión</label>
                                                            <input class="form-control form-control-sm" type="text" name="transmision" value="<?php echo $arrayCliente['trans_modem'] ?>">
                                                        </div>
                                                        <div class="col-md-8">
                                                            <label for="serie">Serie</label>
                                                            <input class="form-control form-control-sm" type="text" name="serie" value="<?php echo $arrayCliente['serie_modem'] ?>">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="ruido">Ruido</label>
                                                            <input class="form-control form-control-sm" type="text" name="ruido" value="<?php echo $arrayCliente['ruido_modem'] ?>">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label for="claveWifi">Clave WIFI</label>
                                                            <input class="form-control form-control-sm" type="text" name="claveWifi" value="<?php echo $arrayCliente['clave_modem'] ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--TELEFONIA-->
                                    <h2 class="accordion-header" id="item3">
                                        <button class="accordion-button" type="button" data-bs-toggle='collapse' data-bs-target='#collapse3' aria-expanded="true" aria-controls="collapse3">TELEFONIA</button>
                                    </h2>
                                    <div class="accordion-collapse collapse" id="collapse3" aria-labelledby="item3" data-bs-parent='#accordio-servicios'>
                                        <div class="accordion-body">
                                            <h5>Servicio no disponible</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
<script>
    $(document).ready(function() {
        $("input").prop('readonly', true);
        $("textarea").prop('readonly', true);
        $("select").prop('disabled', true);
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
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>

</html>