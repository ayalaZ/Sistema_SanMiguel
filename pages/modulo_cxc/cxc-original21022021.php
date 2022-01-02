<?php
if(!isset($_SESSION))
{
    session_start([
        'cookie_lifetime' => 86400,
    ]);
}
 ?>
<!DOCTYPE html>
<div lang="en">

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
    <link href="../../dist/css/sb-admin-2.css" rel="stylesheet">
    <link rel="stylesheet" href="../../dist/css/custom-principal.css">

    <!-- Morris Charts CSS -->
    <link href="../../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <style media="screen">
    .form-control {
        color: #01579B;
        font-size: 15px;
        font-weight: bold;

    }
    .nav>li>a {
        color: #fff;
    }
    </style>
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

<div>

    <?php
         // session_start();
         if(!isset($_SESSION["user"])) {
             header('Location: ../login.php');
         }

         if (isset($_GET['gen'])) {
             if ($_GET['gen'] == "no") {
                 echo "<script>alert('No se encontraron datos para generar facturación')</script>";
             }elseif ($_GET['gen'] == "yes") {
                 echo "<script>alert('Facturación generada con exito.')</script>";
             }
         }

         if (isset($_GET['ordenes'])) {
             $ordenes = unserialize(stripslashes($_GET["ordenes"]));
             echo "<script>alert('ORDENES DE SUSPENSION GENERADAS: ".str_pad($ordenes[0],5,"0", STR_PAD_LEFT)."-".str_pad(end($ordenes),5,"0", STR_PAD_LEFT)."')</script>";
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

            <ul class="nav navbar-top-links navbar-left">
                <li class="dropdown archivo">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        Archivo <i class="fas fa-caret-down"></i>
                    </a>
                    <?php
                    if(!isset($_SESSION["user"])) {
                        header('Location: ../login.php');
                    }elseif (isset($_SESSION["user"])) {
                        if ($_SESSION["rol"] == 'contabilidad') {
                            echo
                            '<ul class="dropdown-menu dropdown-user">
                                <li><a href="#" data-toggle="modal" data-target="#totalClientes">Listado de cobros</a>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#reporteOrdenesTrabajo">Reporte de ordenes</a>
                                </li>
                                <li><a href="cobradores.php">Cobradores</a>
                                </li>
                                <li><a href="vendedores.php">Vendedores</a>
                                </li>
                                <li><a href="zonas.php">Zonas</a>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#abonosAplicados">Abonos aplicados</a>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#anticiposLiquidados">Anticipos liquidados</a>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#reporteVentasManuales">Ventas manuales</a>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#clientesInstalados">Clientes Instalados</a>
                                </li>
                            </ul>';
                        }elseif ($_SESSION["rol"] == 'jefatura') {
                            echo
                            '<ul class="dropdown-menu dropdown-user">
                                <li><a href="#" data-toggle="modal" data-target="#totalClientesAdmin">Clientes totales</a>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#totalClientes">Listado de cobros</a>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#reporteOrdenesTrabajo">Reporte de ordenes</a>
                                </li>
                                <li><a href="cobradores.php">Cobradores</a>
                                </li>
                                <li><a href="vendedores.php">Vendedores</a>
                                </li>
                                <li><a href="zonas.php">Zonas</a>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#abonosAplicados">Abonos aplicados</a>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#anticiposLiquidados">Anticipos liquidados</a>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#reporteVentasManuales">Ventas manuales</a>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#clientesInstalados">Clientes Instalados</a>
                                </li>
                            </ul>';
                        }elseif ($_SESSION["rol"] == 'administracion' || $_SESSION["rol"] == 'subgerencia') {
                            echo
                            '<ul class="dropdown-menu dropdown-user">
                                <li><a href="#" data-toggle="modal" data-target="#totalClientesAdmin">Clientes totales</a>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#totalClientes">Listado de cobros</a>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#reporteOrdenesTrabajo">Reporte de ordenes</a>
                                </li>
                                <li><a href="cobradores.php">Cobradores</a>
                                </li>
                                <li><a href="vendedores.php">Vendedores</a>
                                </li>
                                <li><a href="zonas.php">Zonas</a>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#abonosAplicados">Abonos aplicados</a>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#anticiposLiquidados">Anticipos liquidados</a>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#reporteVentasManuales">Ventas manuales</a>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#clientesInstalados">Clientes Instalados</a>
                                </li>
                            </ul>';
                        }
                    }
                    ?>
                    <!-- /.dropdown-user -->
                </li>
                <li class="dropdown procesos">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        Procesos <i class="fas fa-caret-down"></i>
                    </a>
                    <?php
                    if(!isset($_SESSION["user"])) {
                        header('Location: ../login.php');
                    }elseif (isset($_SESSION["user"])) {
                        if ($_SESSION["rol"] == 'administracion' || $_SESSION["rol"] == 'subgerencia' || $_SESSION["rol"] == 'jefatura' || $_SESSION["rol"] == 'informatica') {
                            echo
                            '<ul class="dropdown-menu dropdown-user">
                                <li><a href="impagos.php" target="_blank">Gestión de impagos</a>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#listaSuspensiones1">Listado de vencidos(1 mes)</a>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#listaSuspensiones">Listado de vencidos(2 meses)</a>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#listaGeneradas">Listado de facturas generadas(1 mes)</a>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#listaGeneradas2Meses">Listado de facturas generadas(2 meses)</a>
                                </li>
                                <!--<li><a href="#" data-toggle="modal" data-target="#listado2">Listado de facturas a entregar</a>
                                </li>-->
                                <li><a href="#" data-toggle="modal" data-target="#suspensionesAutomaticas">Suspensiones automáticas</a>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#generarCompromisos">Generación de compromisos</a>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#analisisSuspensiones">Analisis de cartera de clientes</a>
                                </li>
                            </ul>';
                        }
                    }
                    ?>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown transacciones">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        Transacciones <i class="fas fa-caret-down"></i>
                    </a>
                    <?php
                    if(!isset($_SESSION["user"])) {
                        header('Location: ../login.php');
                    }elseif (isset($_SESSION["user"])) {
                        if ($_SESSION["rol"] == 'administracion' || $_SESSION["rol"] == 'subgerencia') {
                            echo
                            '<ul class="dropdown-menu dropdown-user">
                                <li><a href="#" data-toggle="modal" data-target="#facturacionDiaria" accesskey="a">Facturación automática (Alt+A)</a>
                                </li>
                                <li><a href="facturacionManual.php">Facturación manual</a>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#verFacturasGeneradas">Ver facturas generadas</a>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#eliminarAbonos">Administrar abonos</a>
                                </li>
                                <li><a href="gestionCobros.php">Gestion de cobros</a>
                                </li>
                                <li><a href="ventasManuales.php">Ventas manuales</a>
                                </li>
                                <li><a href="imprimirFacturas.php" data-toggle="modal" data-target="#imprimirFacturas" accesskey="i">Imprimir facturas (Alt+I)</a>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#facturasEmitidas">Facturas emitidas (a detalle)</a>
                                </li>
                            </ul>';
                        }elseif ($_SESSION["rol"] == 'informatica' || $_SESSION["rol"] == 'atencion') {
                            echo
                            '<ul class="dropdown-menu dropdown-user">
                                <!--<li><a href="#" data-toggle="modal" data-target="#eliminarAbonos">Administrar abonos</a>
                                </li>-->
                                <li><a href="gestionCobros.php">Gestion de cobros</a>
                                </li>
                                <li><a href="ventasManuales.php">Ventas manuales</a>
                                </li>
                                <!--<li><a href="imprimirFacturas.php" data-toggle="modal" data-target="#imprimirFacturas" accesskey="i">Imprimir facturas (Alt+I)</a>
                                </li>-->
                            </ul>';
                        }
                        elseif ($_SESSION["rol"] == 'jefatura') {
                            echo
                            '<ul class="dropdown-menu dropdown-user">
                                <li><a href="#" data-toggle="modal" data-target="#eliminarAbonos">Administrar abonos</a>
                                </li>
                                <li><a href="gestionCobros.php">Gestion de cobros</a>
                                </li>
                                <li><a href="ventasManuales.php">Ventas manuales</a>
                                </li>
                                <li><a href="imprimirFacturas.php" data-toggle="modal" data-target="#imprimirFacturas" accesskey="i">Imprimir facturas (Alt+I)</a>
                                </li>
                               <li><a href="#" data-toggle="modal" data-target="#facturasEmitidas">Facturas emitidas (a detalle)</a>
                                </li>
                            </ul>';
                        }
                        elseif ($_SESSION["rol"] == 'contabilidad') {
                            echo
                            '<ul class="dropdown-menu dropdown-user">
                                <li><a href="#" data-toggle="modal" data-target="#eliminarAbonos">Administrar abonos</a>
                                </li>
                                <li><a href="ventasManuales.php">Ventas manuales</a>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#facturasEmitidas">Facturas emitidas (a detalle)</a>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#verFacturasGeneradasC">Ver facturas generadas</a>
                                </li>
                            </ul>';
                        }
                    }
                    ?>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            


            <!-- Reportes -->

                            <li class="dropdown procesos">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        Reportes <i class="fas fa-caret-down"></i>
                    </a>
                    <?php
                    if(!isset($_SESSION["user"])) {
                        header('Location: ../login.php');
                    }elseif (isset($_SESSION["user"])) {
                        if ($_SESSION["rol"] == 'administracion' || $_SESSION["rol"] == 'subgerencia') {
                            echo
                            '<ul class="dropdown-menu dropdown-user">
                                <li><a href="#" data-toggle="modal" data-target="#ReporteProporcional" accesskey="p">Reporte Proporcional(Alt+P)</a>
                                </li>
                                <li><a href="reporteFacturas.php" data-toggle="modal" data-target="#reporteFacturas" accesskey="i">Reporte de facturas generadas</a>
                                </li>
                                <li><a href="reportePendiente2m.php" data-toggle="modal" data-target="#reportePendiente2m" accesskey="i">Reporte de facturas pendientes de 2 meses</a>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#ReporteOrdenesPend" accesskey="o">Reporte de Ordenes(Alt+O)</a>
                                </li>
                            </ul>';
                        }elseif ($_SESSION["rol"] == 'jefatura') {
                            echo
                            '<ul class="dropdown-menu dropdown-user">
                                <li><a href="#" data-toggle="modal" data-target="#ReporteProporcional" accesskey="p">Reporte Proporcional(Alt+P)</a>
                                </li>
                                <li><a href="reporteFacturas.php" data-toggle="modal" data-target="#reporteFacturas" accesskey="i">Reporte de facturas generadas</a>
                                </li>
                                <li><a href="reportePendiente2m.php" data-toggle="modal" data-target="#reportePendiente2m" accesskey="i">Reporte de facturas pendientes de 2 meses</a>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#ReporteOrdenesPend" accesskey="o">Reporte de Ordenes(Alt+O)</a>
                                </li>
                            </ul>';
                        }
                        elseif ($_SESSION["rol"] == 'contabilidad') {
                            echo
                            '<ul class="dropdown-menu dropdown-user">
                                <li><a href="#" data-toggle="modal" data-target="#ReporteProporcional" accesskey="p">Reporte Proporcional(Alt+P)</a>
                                </li>
                                <li><a href="reporteFacturas.php" data-toggle="modal" data-target="#reporteFacturas" accesskey="i">Reporte de facturas generadas</a>
                                </li>
                                <li><a href="reportePendiente2m.php" data-toggle="modal" data-target="#reportePendiente2m" accesskey="i">Reporte de facturas pendientes de 2 meses</a>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#ReporteOrdenesPend" accesskey="o">Reporte Proporcional(Alt+O)</a>
                                </li>
                            </ul>';
                        }elseif ($_SESSION["rol"] == 'informatica' || $_SESSION["rol"] == 'atencion') {
                             echo
                            '<ul class="dropdown-menu dropdown-user">
                                <li><a href="#" data-toggle="modal" data-target="#ReporteOrdenesPend" accesskey="o">Reporte de Ordenes(Alt+O)</a>
                                </li>
                                </ul>';
                        }
                    }
                    ?>
                    <!-- /.dropdown-user -->
                </li>

           <!-- cierre -->
</ul>
            <!-- /.navbar-top-links -->


            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <?php echo "<i class='far fa-user'></i>"." ".$_SESSION['nombres']." ".$_SESSION['apellidos'] ?> <i class="fas fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="perfil.php"><i class="fas fa-user-circle"></i> Perfil</a>
                        </li>
                        <li><a href="config.php"><i class="fas fa-cog"></i> Configuración</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="../../php/logout.php"><i class="fas fa-sign-out-alt"></i> Salir</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href='../index.php'><i class='fas fa-home'></i> Principal</a>
                        </li>
                        <?php
                        require('../../php/contenido.php');
                        require('../../php/modulePermissions.php');

                        if (setMenu($_SESSION['permisosTotalesModulos'], ADMINISTRADOR)) {
                            echo "<li><a href='../modulo_administrar/administrar.php'><i class='fas fa-key'></i> Administrar</a></li>";
                        }else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], CONTABILIDAD)) {
                            echo "<li><a href='../modulo_contabilidad/contabilidad.php'><i class='fas fa-money-check-alt'></i> Contabilidad</a></li>";
                        }else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], PLANILLA)) {
                            echo "<li><a href='../modulo_planillas/planillas.php'><i class='fas fa-file-signature'></i> Planillas</a></li>";
                        }else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], ACTIVOFIJO)) {
                            echo "<li><a href='../modulo_activoFijo/activoFijo.php'><i class='fas fa-building'></i> Activo fijo</a></li>";
                        }else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], INVENTARIO)) {
                            echo "<li><a href='../moduloInventario.php'><i class='fas fa-scroll'></i> Inventario</a></li>";
                        }else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], IVA)) {
                            echo "<li><a href='../modulo_iva/iva.php'><i class='fas fa-file-invoice-dollar'></i> IVA</a></li>";
                        }else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], BANCOS)) {
                            echo "<li><a href='../modulo_bancos/bancos.php'><i class='fas fa-university'></i> Bancos</a></li>";
                        }else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], CXC)) {
                            echo "<li><a href='cxc.php'><i class='fas fa-hand-holding-usd'></i> Cuentas por cobrar</a></li>";
                        }else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], CXP)) {
                            echo "<li><a href='../modulo_cxp/cxp.php'><i class='fas fa-money-bill-wave'></i> Cuentas por pagar</a></li>";
                        }else {
                            echo "";
                        }
                        ?>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- /.row -->
                <div class="row">
                    <?php
                    //var_dump($_SESSION["rol"]);
                    if ($_SESSION["rol"] != "jefatura" && $_SESSION["rol"] != "administracion" && $_SESSION["rol"] != "subgerencia" && $_SESSION["rol"] != "atencion" && $_SESSION["rol"] != "informatica") {
                        echo '<div class="col-lg-12">
                            <h1 class="page-header"><b>Módulo de cuentas por cobrar</b></h1>
                            <div class="row">
                                <a class="" href="infoCliente.php?id=00001"><div class="col-lg-6 btn btn-default">
                                    <div class="stat-icon">
                                        <i class="fas fa-users fa-3x"></i>
                                    </div>
                                    <div class="stat-values">
                                        <br>
                                        <div class="name">Clientes</div>
                                    </div>
                                </div></a>';
                    }else if ($_SESSION["rol"] == "administracion" || $_SESSION["rol"] == "subgerencia" || $_SESSION["rol"] == "jefatura" || $_SESSION["rol"] == "atencion" || $_SESSION["rol"] == "informatica") {

                        echo '<div class="col-lg-12">
                            <h1 class="page-header"><b>Módulo de cuentas por cobrar</b></h1>
                            <div class="row">
                                <a class="" href="infoCliente.php?id=00001"><div class="col-lg-6 btn btn-default">
                                    <div class="stat-icon">
                                        <i class="fas fa-users fa-3x"></i>
                                    </div>
                                    <div class="stat-values">
                                        <br>
                                        <div class="name">Clientes</div>
                                    </div>
                                </div></a>
                                <a class="" href="abonos.php"><div class="col-lg-6 btn btn-default">
                                    <div class="stat-icon">
                                        <i class="fas fa-money-bill-alt fa-3x"></i>
                                    </div>
                                    <div class="stat-values">
                                        <br>
                                        <div class="name">Abonos</div>
                                    </div>
                                </div></a>';
                    }
                    ?>

                        <!--<div class="row">
                            <a href="reportes.php"><div class="col-lg-6 btn btn-default">
                                <div class="stat-icon">
                                    <i class="fas fa-file-alt fa-3x"></i>
                                </div>
                                <div class="stat-values">
                                    <br>
                                    <div class="name">Reportes Inventario</div>
                                </div>
                            </div></a>
                            <a href="HistorialArticulo.php"><div class="col-lg-6 btn btn-default">
                                <div class="stat-icon">
                                    <i class="fas fa-scroll fa-3x"></i>
                                </div>
                                  <div class="stat-values">
                                    <br>
                                    <div class="name">Detalle de Ingresos de Articulos</div>
                                </div>
                            </div></a>
                        </div>-->

                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
            <!-- Modal Facturación diaria -->
            <div id="facturacionDiaria" class="modal fade" role="dialog">
              <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                  <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Generar facturas</h4>
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
                                <!--<option value="ambos">Ambos</option>-->
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
                              <input type="submit" class="btn btn-danger btn-lg btn-block" name="submit" value="Generar Facturas">
                          </div>
                          <div class="col-md-6">
                              <button type="button" class="btn btn-default btn-lg btn-block" data-dismiss="modal">Cancelar</button>
                          </div>
                      </div>
                  </form>
                  </div>
                </div>
              </div>
            </div><!-- Fin Modal Facturación diaria -->
            <!-- Modal Consultar/Eliminar abonos -->
            <div id="eliminarAbonos" class="modal fade" role="dialog">
              <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                  <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Administrador de abonos</h4>
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
                              <button type="button" class="btn btn-default btn-lg btn-block" data-dismiss="modal">Cancelar</button>
                          </div>
                      </div>
                  </form>
                  </div>
                </div>
              </div>
          </div><!-- Fin Modal ABONOS -->

          <!-- Modal VERFACTURAS GENERADAS -->
          <div id="verFacturasGeneradas" class="modal fade" role="dialog">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Ver facturas generadas</h4>
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
                            <input type="submit" class="btn btn-danger btn-md btn-block" name="submit" value="Ver facturas">
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-default btn-md btn-block" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </form>
                </div>
              </div>
            </div>
        </div><!-- Fin Modal VER FACTURAS GENERADAS para contabilidad-->

        <!-- Modal VERFACTURAS GENERADAS -->
          <div id="verFacturasGeneradasC" class="modal fade" role="dialog">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Ver facturas generadas</h4>
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
                            <input type="submit" class="btn btn-danger btn-md btn-block" name="submit" value="Ver facturas">
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-default btn-md btn-block" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </form>
                </div>
              </div>
            </div>
        </div><!-- Fin Modal VER FACTURAS GENERADAS Contabilidad-->

          <!-- Modal imprimir facturas -->
          <div id="imprimirFacturas" class="modal fade" role="dialog">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Imprimir facturas</h4>
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
                          <input class="form-control"  type="text" id="desdeImp" name="desdeImp"  placeholder="Número de factura">
                      </div>
                      <div class="col-md-6">
                          <label for="hastaImp"></label>
                          <input class="form-control"  type="text" id="hastaImp" name="hastaImp"  placeholder="Número de factura">
                      </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="submit" class="btn btn-danger btn-md btn-block" name="submit" value="Imprimir facturas">
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-default btn-md btn-block" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </form>
                </div>
              </div>
            </div>
        </div><!-- Fin Modal IMPRIMIR FACTURAS -->

<!-- Modal para reporte de facturas generadas -->
          <div id="reporteFacturas" class="modal fade" role="dialog">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Reporte de facturacion generada</h4>
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
                          <input class="form-control"  type="text" id="desdeImp" name="desdeImp"  placeholder="Número de factura inicial">
                      </div>
                      <div class="col-md-6">
                          <label for="hastaImp"></label>
                          <input class="form-control"  type="text" id="hastaImp" name="hastaImp"  placeholder="Número de factura terminal">
                      </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="submit" class="btn btn-danger btn-md btn-block" name="submit" value="Generar">
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-default btn-md btn-block" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </form>
                </div>
              </div>
            </div>
        </div><!-- Final de Modal para reporte de facturas generadas -->




    <!-- Modal VENTAS X COMPROBANTE -->
    <div id="facturasEmitidas" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Lista de facturas emitidas</h4>
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
                                        echo '<option value="'.$key['codigoCobrador'].'">'.$key['nombreCobrador'].'</option>';
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
                                        echo '<option value="'.$key['idColonia'].'">'.$key['nombreColonia'].'</option>';
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
                                <input type="submit" class="btn btn-danger btn-md btn-block" name="submit" value="Ver reporte">
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-md btn-block" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div><!-- Fin Modal VENTAS X COMPROBANTE -->

    <!-- Modal GENERACION DE COMPROMISOS -->
    <div id="generarCompromisos" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Generación de compromisos</h4>
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
                                        echo '<option value="'.$key['codigoCobrador'].'">'.$key['nombreCobrador'].'</option>';
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
                                        echo '<option value="'.$key['idColonia'].'">'.$key['nombreColonia'].'</option>';
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
                                    <!--<option value="A">Ambos</option>-->
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="diaCobro">Día cobro</label>
                                <input class="form-control" type="number" name="diaCobro" value="1" required>
                            </div>
                        </div>
                        <div class="row">
                            <!--<div class="col-md-3">
                                <label for="lTipoLista">Tipo de Factura</label>
                                <select class="form-control" type="text" id="lTipoLista" name="lTipoLista" required>
                                    <option value="2" selected>Consumidor final</option>
                                    <option value="1">Crédito fiscal</option>
                                    <option value="3">Ambas</option>
                                </select>
                            </div>-->
                            <div class="col-md-4">
                                <br>
                                <!--<label for="filtro">Fecha de cobro</label>
                                <input type="radio" type="text" id="filtroFechaCob" name="filtro" value="1">-->
                                <label for="filtro">Fecha de comprobante</label>
                                <input type="radio" type="text" id="filtroFechaComp" name="filtro" value="2" checked>
                            </div>
                            <div class="col-md-4">
                                <br>
                                <label for="todosDias">Todos los días de cobro</label>
                                <input type="checkbox" type="text" id="todosDias" name="todosDias" value="1">
                                <!--<label for="soloAnuladas">Solo facturas anuladas</label>
                                <input type="checkbox" type="text" id="soloAnuladas" name="soloAnuladas" value="1">
                                <label for="soloExentas">Solo facturas exentas</label>
                                <input type="checkbox" type="text" id="soloExentas" name="soloExentas" value="T">-->
                            </div>
                            <div class="col-md-4">
                                <br>
                                <label for="ordenamiento">Ordenar por código</label>
                                <input type="radio" type="text" id="ordenarCodigo" name="ordenamiento" value="1" checked>
                                <label for="ordenamiento">Ordenar por cobrador</label>
                                <input type="radio" type="text" id="ordenarColonia" name="ordenamiento" value="2">
                                <!--<label for="ordenar">Ordenar por factura</label>
                                <input type="radio" type="text" id="ordenarFactura" name="ordenar" value="3" checked>-->
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
                                <input type="submit" class="btn btn-danger btn-md btn-block" name="submit" value="Generar compromisos">
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-md btn-block" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    <!-- Modal REPORTEORDENES DE TRBAJO -->
    <div id="reporteOrdenesTrabajo" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Reporte de ordenes de trabajo</h4>
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
                                        echo '<option value="'.$key['idTecnico'].'">'.$key['nombreTecnico'].'</option>';
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
                                        echo '<option value="'.$key['idColonia'].'">'.$key['nombreColonia'].'</option>';
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
                                            echo '<option value="'.utf8_decode($key['nombreActividad']).'">'.utf8_decode($key['nombreActividad']).'</option>';
                                        }
                                        ?>
                                    </optgroup>
                                    <optgroup label="____INTERNET____">
                                        <?php
                                        $arrActividadesInter = $data->getDataActI('tbl_actividades_inter');

                                        foreach ($arrActividadesInter as $key) {
                                            echo '<option value="'.utf8_decode($key['nombreActividad']).'">'.utf8_decode($key['nombreActividad']).'</option>';
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
                            <!--<div class="col-md-4">
                                <br>
                                <label for="ordenar">Ordenar por código</label>
                                <input type="radio" type="text" id="ordenarCodigo" name="ordenar" value="1">
                                <label for="ordenar">Ordenar por colonia</label>
                                <input type="radio" type="text" id="ordenarColonia" name="ordenar" value="2">
                                <label for="ordenar">Ordenar por factura</label>
                                <input type="radio" type="text" id="ordenarFactura" name="ordenar" value="3" checked>
                            </div>-->
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
                                <input type="submit" class="btn btn-danger btn-md btn-block" name="submit" value="Ver reporte">
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-md btn-block" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div><!-- Fin Modal REPORTEORDENES DE TRBAJO -->
    </div>
        <!-- Modal abonos Aplicados -->
    <div id="abonosAplicados" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
          <div style="background-color: #d32f2f; color:white;" class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Lista de Abonos ingresados</h4>
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
                            echo '<option value="'.$key['codigoCobrador'].'">'.$key['nombreCobrador'].'</option>';
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
                            echo '<option value="'.$key['idColonia'].'">'.$key['nombreColonia'].'</option>';
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
                    <input class="form-control" type="checkbox" id="lDetallado" name="lDetallado" value="1" checked>
                </div>
            </div>
          </div>
          <div class="modal-footer">
              <div class="row">
                  <div class="col-md-6">
                      <input type="submit" class="btn btn-danger btn-md btn-block" name="submit" value="Ver abonos">
                  </div>
                  <div class="col-md-6">
                      <button type="button" class="btn btn-default btn-md btn-block" data-dismiss="modal">Cancelar</button>
                  </div>
              </div>
          </form>
          </div>
        </div>
      </div><!-- Fin Modal ABONOS APLICADOS -->
    </div>

            <!-- Modal ANTICIPOS LIQUIDADOS 3 -->
    <div id="anticiposLiquidados" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
          <div style="background-color: #d32f2f; color:white;" class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Detalle de Anticipos Liquidados</h4>
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
                    <label for="lDesde">Fecha de generación desde</label>
                    <input class="form-control" type="text" id="lDesde" name="lDesde" placeholder="Aplicación de anticipo desde" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <div class="col-md-3">
                    <label for="lHasta">Fecha de generación hasta</label>
                    <input class="form-control" type="text" id="lHasta" name="lHasta" placeholder="Aplicación de anticipo hasta" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <div class="col-md-2">
                    <label for="lDetallado">Reporte detallado</label>
                    <input class="form-control" type="checkbox" id="lDetallado" name="lDetallado" value="1" checked>
                </div>
            </div>
          </div>
          <div class="modal-footer">
              <div class="row">
                  <div class="col-md-6">
                      <input type="submit" class="btn btn-danger btn-md btn-block" name="submit" value="Ver abonos">
                  </div>
                  <div class="col-md-6">
                      <button type="button" class="btn btn-default btn-md btn-block" data-dismiss="modal">Cancelar</button>
                  </div>
              </div>
          </form>
          </div>
        </div>
      </div><!-- Fin Modal ANTICIPOS LIQUIDADOS 3 -->
    </div>

    <div id="listaSuspensiones1" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

          <!-- Modal content-->
          <div class="modal-content">
            <div style="background-color: #d32f2f; color:white;" class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Lista de clientes de 1 factura vencida</h4>
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
                              echo '<option value="'.$key['codigoCobrador'].'">'.$key['nombreCobrador'].'</option>';
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
                        <input type="submit" class="btn btn-danger btn-md btn-block" name="submit" value="Ver listado">
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-default btn-md btn-block" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
            </div>
          </div>
        </div>
    </div><!-- Fin Modal LISTA DE SUSPENSIONES 1 mes -->
      <!-- Modal LISTA SUSPENSIONES -->
      <div id="listaSuspensiones" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

          <!-- Modal content-->
          <div class="modal-content">
            <div style="background-color: #d32f2f; color:white;" class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Lista de clientes 2 facturas vencidas</h4>
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
                              echo '<option value="'.$key['codigoCobrador'].'">'.$key['nombreCobrador'].'</option>';
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
                        <input type="submit" class="btn btn-danger btn-md btn-block" name="submit" value="Ver listado">
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-default btn-md btn-block" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
            </div>
          </div>
        </div>
    </div><!-- Fin Modal LISTA DE SUSPENSIONES -->
    <!-- Modal SUSPENSIONES AUTOMATICAS -->
    <div id="suspensionesAutomaticas" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
          <div style="background-color: #d32f2f; color:white;" class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Lista de clientes a suspender</h4>
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
                            echo '<option value="'.$key['codigoCobrador'].'">'.$key['nombreCobrador'].'</option>';
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
                      <input type="submit" class="btn btn-danger btn-md btn-block" name="submit" value="Ver suspensiones">
                  </div>
                  <div class="col-md-6">
                      <button type="button" class="btn btn-default btn-md btn-block" data-dismiss="modal">Cancelar</button>
                  </div>
              </div>
          </form>
          </div>
        </div>
      </div>
  </div><!-- Fin Modal SUSPENSIONES AUTOMATICAS -->
      <!-- Modal VENTAS MANUALES -->
      <div id="reporteVentasManuales" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

          <!-- Modal content-->
          <div class="modal-content">
            <div style="background-color: #d32f2f; color:white;" class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Reporte de ventas manuales</h4>
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
                        <input type="submit" class="btn btn-danger btn-md btn-block" name="submit" value="Ver reporte">
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-default btn-md btn-block" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
            </div>
          </div>
        </div>
    </div><!-- Fin Modal VENTAS MANUALES -->
    <!-- Modal LISTADO 2 -->
    <div id="listado2" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Lista de facturas a entregar</h4>
          </div>
          <form id="frmListado2" action="php/listado2.php" method="POST">
          <div class="modal-body">
            <div class="row">
                <div class="col-md-4">
                    <label for="l2Cobrador">Cobrador</label>
                    <select class="form-control" type="text" id="l2Cobrador" name="l2Cobrador" required>
                        <option value="">Seleccione cobrador</option>
                        <option value="todos" selected>Todos los cobradores</option>
                        <?php
                        require_once 'php/GetAllInfo.php';
                        $data = new GetAllInfo();
                        $arrCobradores = $data->getData('tbl_cobradores');
                        foreach ($arrCobradores as $key) {
                            echo '<option value="'.$key['codigoCobrador'].'">'.$key['nombreCobrador'].'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="l2Zonas">Zonas</label>
                    <select class="form-control" type="text" id="l2Zonas" name="l2Zonas" required>
                        <option value="">Seleccione una zona</option>
                        <option value="todas">Todas las zonas</option>
                        <?php
                        $arrDeptos = $data->getData('tbl_colonias_cxc');
                        foreach ($arrDeptos as $key) {
                            echo '<option value="'.$key['idColonia'].'">'.$key['nombreColonia'].'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="l2Servicio">Tipo de servicio</label>
                    <select class="form-control" type="text" id="l2Servicio" name="l2Servicio" required>
                        <option value="">Seleccione tipo de servicio</option>
                        <option value="C" selected>Cable</option>
                        <option value="I">Internet</option>
                        <option value="P">Paquete</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="l2Fecha">Fecha en que se generó</label>
                    <input class="form-control" type="text" id="l2Fecha" name="l2Fecha" value="<?php echo date("Y-m-d"); ?>" required>
                </div>
            </div>
          </div>
          <div class="modal-footer">
              <div class="row">
                  <div class="col-md-6">
                      <input type="submit" class="btn btn-danger btn-md btn-block" name="submit" value="Ver listado">
                  </div>
                  <div class="col-md-6">
                      <button type="button" class="btn btn-default btn-md btn-block" data-dismiss="modal">Cancelar</button>
                  </div>
              </div>
          </form>
          </div>
        </div>
      </div>
  </div><!-- Fin Modal LISTADO2 -->
  <!-- Modal LISTA FACTURAS GNERADAS-->
  <div id="listaGeneradas" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div style="background-color: #d32f2f; color:white;" class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Lista de clientes de 1 factura generada</h4>
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
                                    echo '<option value="'.$key['codigoCobrador'].'">'.$key['nombreCobrador'].'</option>';
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
                                <option value="A">Todos</option><!--All services-->
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="submit" class="btn btn-danger btn-md btn-block" name="submit" value="Ver listado">
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-default btn-md btn-block" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
  </div>
    </div><!-- Fin Modal LISTA DE FACTURAS GENERADAS -->
      </div>
    </div>
</div><!-- Fin Modal LISTA DE FACTURAS GENERADAS -->
    <!-- Modal LISTA FACTURAS GNERADAS 2meses-->
    <div id="listaGeneradas2Meses" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Lista de clientes de 2 facturas generadas</h4>
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
                                        echo '<option value="'.$key['codigoCobrador'].'">'.$key['nombreCobrador'].'</option>';
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
                                <input type="submit" class="btn btn-danger btn-md btn-block" name="submit" value="Ver listado">
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-md btn-block" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div><!-- Fin Modal LISTA DE FACTURAS GENERADAS 2 meses -->

    <!-- Modal LISTA TOTAL CLEINTES-->
    <div id="totalClientes" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Reporte de todos los clientes</h4>
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
                                        echo '<option value="'.$key['codigoCobrador'].'">'.$key['nombreCobrador'].'</option>';
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
                                        echo '<option value="'.$key['idColonia'].'">'.$key['nombreColonia'].'</option>';
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
                            <br>
                            <div class="col-md-6">
                                <label class="pull-right" for="todosLosDias">Ordenar Por Colonia</label>
                                <input class="pull-right" type="checkbox" name="ordenarPorColonias" value="1">
                            </div>
                            <div class="col-md-5">
                                <?php
                                if ($_SESSION["rol"] == 'administracion' || $_SESSION["rol"] == 'subgerencia'){
                                    echo '<input class="pull-right" type="checkbox" name="todosLosDias" value="1">';
                                    echo '<label class="pull-right" for="todosLosDias">Mostrar todos los días de cobro</label>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="submit" class="btn btn-danger btn-md btn-block" name="submit" value="Ver clientes">
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-md btn-block" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div><!-- Fin Modal LISTA DE TOTAL CLIENTES -->

    <!-- Modal LISTA TOTAL CLEINTES PARA ADMIN-->
    <div id="totalClientesAdmin" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Reporte de todos los clientes</h4>
                </div>
                <form id="frmtodosClientes" action="php/listaDeClientes.php" method="POST">
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
                                        echo '<option value="'.$key['codigoCobrador'].'">'.$key['nombreCobrador'].'</option>';
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
                                        echo '<option value="'.$key['idColonia'].'">'.$key['nombreColonia'].'</option>';
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
                                    <option value="T" selected>TODOS</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="cldiaCobro">Dia de cobro</label>
                                <input class="form-control" type="number" name="cldiaCobro" value="1">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <br>
                                <label class="pull-right" for="todosLosDias">Ordenar Por Colonia</label>
                                <input class="pull-right" type="checkbox" name="ordenarPorColonias" value="1">
                            </div>
                            <div class="col-md-4">
                                <br>
                                <label class="pull-right" for="todosLosDias">Todos los días de cobro</label>
                                <input class="pull-right" type="checkbox" name="todosLosDias" value="1">
                            </div>
                            <div class="col-md-3">
                                <label class="pull-right" for="ultimoMesCancelado">Último mes cancelado</label>
                                <select class="form-control" name="ultimoMesCancelado" id="ultimoMesCancelado">
                                    <option value="0" selected>Todos los meses</option>
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
                            <div class="col-md-2">
                                <label class="pull-right" for="ultimoAnioCancelado">Año</label>
                                <input class="form-control" type="number" name="ultimoAnioCancelado" id="ultimoAnioCancelado" value="<?php echo date('Y')?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4">

                            </div>
                            <div class="col-md-4">
                                <label class="pull-right" for="ultimoMesCancelado">Técnología</label>
                                <select class="form-control" name="tecnologia" id="tecnologia">
                                    <option value="0" selected>Todas</option>
                                    <option value="1">DOCSIS</option>
                                    <option value="2">FTTH</option>
                                    <option value="3">INALÁMBRICA</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="submit" class="btn btn-danger btn-md btn-block" name="submit" value="Ver clientes">
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-md btn-block" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div><!-- Fin Modal LISTA DE TOTAL CLIENTES ADMINISTRACION -->

    <!-- Modal ANALISIS DE SUSPENSIONES -->
    <div id="analisisSuspensiones" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Analisis de cartera de clientes</h4>
                </div>
                <form id="frmanalisisSuspensiones" action="php/analisisSuspensiones.php" method="POST">
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
                                        echo '<option value="'.$key['codigoCobrador'].'">'.$key['nombreCobrador'].'</option>';
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
                                        echo '<option value="'.$key['idColonia'].'">'.$key['nombreColonia'].'</option>';
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
                                    <option value="T" selected>TODOS</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="cldiaCobro">Dia de cobro</label>
                                <input class="form-control" type="number" name="cldiaCobro" value="1">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <br>
                                <label class="pull-right" for="todosLosDias">Ordenar Por Colonia</label>
                                <input class="pull-right" type="checkbox" name="ordenarPorColonias" value="1">
                            </div>
                            <div class="col-md-3">
                                <br>
                                <label class="pull-right" for="todosLosDias">Todos los días de cobro</label>
                                <input class="pull-right" type="checkbox" name="todosLosDias" value="1">
                            </div>
                            <div class="col-md-3">
                                <label for="desde">Desde</label>
                                <input class="form-control" type="text" name="desde" value="<?php echo date('Y-m-d', strtotime(date('Y-m-d').'- 1 month')) ?>">
                            </div>
                            <div class="col-md-3">
                                <label for="hasta">Desde</label>
                                <input class="form-control" type="text" name="hasta" value="<?php echo date('Y-m-d') ?>">
                            </div>
                            <!--<div class="col-md-2">
                                <label class="pull-right" for="ultimoAnioCancelado">Año</label>
                                <input class="form-control" type="number" name="ultimoAnioCancelado" id="ultimoAnioCancelado" value="<?php echo date('Y')?>">
                            </div>-->
                        </div>
                        <div class="row">
                            <div class="col-md-4">

                            </div>
                            <div class="col-md-4">

                            </div>
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
                                <input type="submit" class="btn btn-danger btn-md btn-block" name="submit" value="Ver clientes suspendidos">
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-md btn-block" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div><!-- Fin Modal ANALISIS DE SUSPENSIONES-->
</div>
<!-- Modal Lista de clientes instalado por fecha activos -->
    <div id="clientesInstalados" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
          <div style="background-color: #d32f2f; color:white;" class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Listado de clientes instalados</h4>
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
                      <input type="submit" class="btn btn-danger btn-md btn-block" name="submit" value="Generar Reporte">
                  </div>
                  <div class="col-md-6">
                      <button type="button" class="btn btn-default btn-md btn-block" data-dismiss="modal">Cancelar</button>
                  </div>
              </div>
          </form>
          </div>
        </div>
      </div><!-- Fin Modal Listado de clientes instalados por fecha -->
    </div>


    <!-- Modal Reporte Proporcional -->
    <div id="ReporteProporcional" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
          <div style="background-color: #d32f2f; color:white;" class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Reporte detallado de proporciones</h4>
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
                    <input class="form-control" type="text" id="propor" name="propor" placeholder="Año Proporcional" pattern="[0-9]{4}" value="<?php echo date('Y', strtotime(date('Y').'- 1 Year')) ?>" required>
                </div>
                <div class="col-md-2">
                    <label for="lDetallado">Reporte detallado</label>
                    <input class="form-control" type="checkbox" id="lDetallado" name="lDetallado" value="1" checked>
                </div>
            </div>
          </div>
          <div class="modal-footer">
              <div class="row">
                  <div class="col-md-6">
                      <input type="submit" class="btn btn-danger btn-md btn-block" name="submit" value="Generar reporte proporcional">
                  </div>
                  <div class="col-md-6">
                      <button type="button" class="btn btn-default btn-md btn-block" data-dismiss="modal">Cancelar</button>
                  </div>
              </div>
          </form>
          </div>
        </div>
      </div><!-- Fin Modal ANTICIPOS LIQUIDADOS 3 -->
    </div>

     <!-- Modal Reporte de ordenes -->
    <div id="ReporteOrdenesPend" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
          <div style="background-color: #d32f2f; color:white;" class="modal-header">
            <h4 class="modal-title">Listado de clientes instalados</h4>
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
                      <input type="submit" class="btn btn-danger btn-md btn-block" name="submit" value="Generar Reporte">
                  </div>
                  <div class="col-md-6">
                      <button type="button" class="btn btn-default btn-md btn-block" data-dismiss="modal">Cancelar</button>
                  </div>
              </div>
          </form>
          </div>
        </div>
      </div><!-- Fin Modal Listado de Reporte de ordenes por fecha -->
    </div>


    <li><a href="#" data-toggle="modal" data-target="#ReporteOrdenesPend" accesskey="o">Reporte Proporcional(Alt+O)</a>
                                </li>


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

        var fechaComprobante = new Date(mesGenerar+"-"+diaGenerar+"-"+anoGenerar);
        console.log(fechaComprobante.setMonth(fechaComprobante.getMonth()+1));
        document.getElementById("fechaComprobante").value = fechaComprobante.toLocaleDateString();
        console.log(fechaComprobante.setDate(fechaComprobante.getDate()+8));
        document.getElementById("fechaVencimiento").value = fechaComprobante.toLocaleDateString();
        }
        });
    </script>
    <script type="text/javascript">
        function anularAbono(id){
            var r = confirm("Realmente desea anular este abono?!");
            if (r == true) {
              window.open("php/anularAbono.php?idAbono="+id);
            }
        }
    </script>

    <script type="text/javascript">
        function hastaImpFunc(){
            document.getElementById('hastaImp').required = true;
            document.getElementById('desdeImp').required = true;
        }
        function desdeImpFunc(){
            document.getElementById('hastaImp').required = true;
            document.getElementById('desdeImp').required = true;
        }
    </script>

</body>

</html>
