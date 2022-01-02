<?php

if(!isset($_SESSION))
{
    session_start([
        'cookie_lifetime' => 86400,
    ]);
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
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Font awesome CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    <link rel="stylesheet" href="../dist/css/custom-principal.css">
    <link rel="stylesheet" href="../dist/css/switches.css">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- DataTables CSS -->
    <!--<link rel="stylesheet" href="../vendor/datatables/css/dataTables.bootstrap.min.css"> -->
    <!--<link rel="stylesheet" href="../vendor/datatables/css/jquery.dataTables.min.css"> -->

</head>

<body>

    <?php
         // session_start();
         if(!isset($_SESSION["user"])) {
             header('Location: login.php');
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
                        <li><a href="../php/logout.php"><i class="fas fa-sign-out-alt"></i></i> Salir</a>
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
                            <a href='index.php'><i class='fas fa-home'></i> Principal</a>
                        </li>
                        <?php
                        require('../php/contenido.php');
                        require('../php/modulePermissions.php');

                        if (setMenu($_SESSION['permisosTotalesModulos'], ADMINISTRADOR)) {
                            echo "<li><a href='modulo_administrar/administrar.php'><i class='fas fa-key'></i> Administrar</a></li>";
                        }else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], CONTABILIDAD)) {
                            echo "<li><a href='modulo_contabilidad/contabilidad.php'><i class='fas fa-money-check-alt'></i> Contabilidad</a></li>";
                        }else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], PLANILLA)) {
                            echo "<li><a href='modulo_planillas/planillas.php'><i class='fas fa-file-signature'></i> Planillas</a></li>";
                        }else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], ACTIVOFIJO)) {
                            echo "<li><a href='modulo_activoFijo/activoFijo.php'><i class='fas fa-building'></i> Activo fijo</a></li>";
                        }else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], INVENTARIO)) {
                            echo "<li><a href='moduloInventario.php'><i class='fas fa-scroll'></i> Inventario</a></li>";
                        }else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], IVA)) {
                            echo "<li><a href='modulo_iva/iva.php'><i class='fas fa-file-invoice-dollar'></i> IVA</a></li>";
                        }else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], BANCOS)) {
                            echo "<li><a href='modulo_bancos/bancos.php'><i class='fas fa-university'></i> Bancos</a></li>";
                        }else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], CXC)) {
                            echo "<li><a href='modulo_cxc/cxc.php'><i class='fas fa-hand-holding-usd'></i> Cuentas por cobrar</a></li>";
                        }else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], CXP)) {
                            echo "<li><a href='modulo_cxp/cxp.php'><i class='fas fa-money-bill-wave'></i> Cuentas por pagar</a></li>";
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
        <div id="page-wrapper">
            <div class="row">
                <br>
                <div class="col-md-8">
                    <table class="table table-responsive">
                        <tr>
                            <td><button class="btn btn-danger btn-block"><i class="fas fa-sign-out-alt fa-2x"></i></button></td>
                            <td><button class="btn btn-success btn-block"><i class="fas fa-print fa-2x"></i></button></td>
                            <td><button class="btn btn-primary btn-block" data-toggle="modal" data-target="#busquedaAvanzada"><i class="fas fa-search fa-2x"></i></button></td>
                        </tr>
                        <tr>
                            <td><button class="btn btn-primary btn-block" style="font-size: 16px;">Contrato de cable</button></td>
                            <td><button class="btn btn-primary btn-block" style="font-size: 16px;">Contrato de internet</button></td>
                            <td><button class="btn btn-primary btn-block" style="font-size: 16px;">Estado de cuenta</button></td>
                        </tr>
                        <tr>
                            <td><button class="btn btn-info btn-block" style="font-size: 16px; ;">Reporte</button></td>
                            <td colspan="2"><button class="btn btn-info btn-block" style="font-size: 16px; ;">Compromiso de internet</button></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4">
                    <table class="table table-bordered table-responsive table-condensed">
                        <th></th>
                        <th>Activo</th>
                        <th>Suspendido</th>
                        <th>Sin servicio</th>
                        <tr class="info">
                            <th>TV</th>
                            <td><label class="switch"><input type="radio" name ="cable" checked disabled><span class="slider round"></span></label></td>
                            <td><label class="switch"><input type="radio" name ="cable"  disabled><span class="slider round"></span></label></td>
                            <td><label class="switch"><input type="radio" name ="cable"  disabled><span class="slider round"></span></label></td>
                        </tr>
                        <tr class="success">
                            <th>Internet</th>
                            <td><label class="switch"><input type="radio" name="internet"checked disabled><span class="slider round"></span></label></td>
                            <td><label class="switch"><input type="radio" name="internet" disabled><span class="slider round"></span></label></td>
                            <td><label class="switch"><input type="radio" name="internet" disabled><span class="slider round"></span></label></td>
                        </tr>
                        <tr class="warning">
                            <th>Teléfono</th>
                            <td><label class="switch"><input type="radio" name="telefono" disabled><span class="slider round"></span></label></td>
                            <td><label class="switch"><input type="radio" name="telefono" disabled><span class="slider round"></span></label></td>
                            <td><label class="switch"><input type="radio" name="telefono"checked disabled><span class="slider round"></span></label></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <span>05369 Diego Armando Herrera Flores</span>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-pills nav-justified">
                                <li class="active"><a href="#datos-generales" data-toggle="tab">Datos generales</a>
                                </li>
                                <li><a href="#otros-datos" data-toggle="tab">Otros datos</a>
                                </li>
                                <li><a href="#servicios" data-toggle="tab">Servicios</a>
                                </li>
                                <li><a href="#ordenes-tecnicas" data-toggle="tab">Ordenes técnicas</a>
                                </li>
                                <li><a href="#notificaciones-traslados" data-toggle="tab">Traslados</a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="datos-generales">
                                    <br>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="codigo">Código del cliente</label>
                                            <input class="form-control" type="text" name="codigo">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="contrato">Número de contrato</label>
                                            <input class="form-control" type="text" name="contrato">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="factura">Número de factura</label>
                                            <input class="form-control" type="text" name="factura">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="nombres">Nombres</label>
                                            <input class="form-control" type="text" name="nombres">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="apellidos">Apellidos</label>
                                            <input class="form-control" type="text" name="apellidos">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="empresa">Empresa</label>
                                            <input class="form-control" type="text" name="empresa">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="ncr">Número de registro</label>
                                            <input class="form-control" type="text" name="ncr">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label for="dui">DUI</label>
                                            <input class="form-control" type="text" name="dui">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="expedicion">Lugar y fecha de expedición</label>
                                            <input class="form-control" type="text" name="expedicion">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="nit">NIT</label>
                                            <input class="form-control" type="text" name="nit">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="fechaNacimiento">Fecha de nacimiento</label>
                                            <input class="form-control" type="date" name="fechaNacimiento">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="direccion">Dirección</label>
                                            <textarea class="form-control" name="direccion" rows="2" cols="40"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="departamento">Departamento</label>
                                            <select class="form-control" name="departamento">

                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="municipio">Municipio</label>
                                            <select class="form-control" name="municipio">

                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="colonia">Barrio o colonia</label>
                                            <select class="form-control" name="colonia">

                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="direccionCobro">Dirección de cobro</label>
                                            <textarea class="form-control" name="direccionCobro" rows="2" cols="40"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="telefono">Teléfono</label>
                                            <input class="form-control" type="text" name="telefono">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="telefonoTrabajo">Teléfono de trabajo</label>
                                            <input class="form-control" type="text" name="telefonoTrabajo">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="ocupacion">Ocupación</label>
                                            <input class="form-control" type="text" name="ocupacion">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="cuentaContable">Cuenta contable</label>
                                            <select class="form-control" name="cuentaContable">

                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="formaFactura">Forma al facturar</label>
                                            <select class="form-control" name="formaFactura">

                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="saldoActual">Saldo actual</label>
                                            <input class="form-control" type="text" name="saldoActual">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="limiteCredito">Días de crédito</label>
                                            <input class="form-control" type="text" name="diasCredito">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="limiteCredito">Límite de crédito</label>
                                            <input class="form-control" type="text" name="limiteCredito">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="tipoFacturacion">Tipo de facturación</label>
                                            <select class="form-control" name="tipoFacturacion">

                                            </select>
                                        </div>
                                        <div class="col-md-9">
                                            <label for="facebook">Cuenta de Facebook</label>
                                            <input class="form-control" type="text" name="facebook">
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="otros-datos">
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="cobrador">Cobrador que lo atiende</label>
                                            <input class="form-control" type="text" name="cobrador">
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="rp1_nombre">Referencia personal #1</label>
                                            <input class="form-control" type="text" name="rf1_nombre">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="rp1_telefono">Teléfono</label>
                                            <input class="form-control" type="text" name="rp1_telefono">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="rp1_direccion">Dirección</label>
                                            <input class="form-control" type="text" name="rp1_direccion">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="rp1_parentezco">Parentezco</label>
                                            <input class="form-control" type="text" name="rp1_parentezco">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="rp2_nombre">Referencia personal #2</label>
                                            <input class="form-control" type="text" name="rf2_nombre">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="rp2_telefono">Teléfono</label>
                                            <input class="form-control" type="text" name="rp2_telefono">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="rp2_direccion">Dirección</label>
                                            <input class="form-control" type="text" name="rp2_direccion">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="rp2_parentezco">Parentezco</label>
                                            <input class="form-control" type="text" name="rp2_parentezco">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="rp3_nombre">Referencia personal #3</label>
                                            <input class="form-control" type="text" name="rf3_nombre">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="rp3_telefono">Teléfono</label>
                                            <input class="form-control" type="text" name="rp3_telefono">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="rp3_direccion">Dirección</label>
                                            <input class="form-control" type="text" name="rp3_direccion">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="rp3_parentezco">Parentezco</label>
                                            <input class="form-control" type="text" name="rp3_parentezco">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade in" id="servicios">
                                    <!--Accordion wrapper-->
                                    <div class="accordion md-accordion" id="accordionEx1" role="tablist" aria-multiselectable="true">

                                      <!-- Accordion card -->
                                      <div class="card">

                                        <!-- Card header -->
                                        <div class="card-header" role="tab" id="headingTwo1">
                                          <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx1" href="#collapseTwo1"
                                            aria-expanded="false" aria-controls="collapseTwo1">
                                            <h5 class="mb-0 alert alert-info">
                                              TV POR CABLE <i class="fas fa-angle-down rotate-icon"></i>
                                            </h5>
                                          </a>
                                        </div>

                                        <!-- Card body -->
                                        <div id="collapseTwo1" class="collapse" role="tabpanel" aria-labelledby="headingTwo1" data-parent="#accordionEx1">
                                          <div class="card-body">
                                              <div class="row">
                                                  <div class="col-md-2">
                                                      <label for="fechaInstalacionCable">Fecha de instalación</label>
                                                      <input class="form-control" type="text" name="fechaInstalacionCable">
                                                  </div>
                                                  <div class="col-md-3">
                                                      <label for="fechaPrimerFacturaCable">Fecha de primer factura</label>
                                                      <input class="form-control" type="text" name="fechaPrimerFacturaCable">
                                                  </div>
                                                  <div class="col-md-2">
                                                      <label for="exento">Exento</label>
                                                      <input class="form-control" type="checkbox" name="exento">
                                                  </div>
                                                  <div class="col-md-3">
                                                      <label for="diaGenerarFacturaCable">Día para generar factura</label>
                                                      <input class="form-control" type="text" name="diaGenerarFacturaCable">
                                                  </div>
                                                  <div class="col-md-2">
                                                      <label for="cortesia">Cortesía</label>
                                                      <input class="form-control" type="checkbox" name="cortesia">
                                                  </div>
                                              </div>
                                              <div class="row">
                                                  <div class="col-md-2">
                                                      <label for="cuotaMensualCable">Cuota mensual</label>
                                                      <input class="form-control" type="text" name="cuotaMensualCable">
                                                  </div>
                                                  <div class="col-md-2">
                                                      <label for="prepago">Prepago</label>
                                                      <input class="form-control" type="text" name="prepago">
                                                  </div>
                                                  <div class="col-md-3">
                                                      <label for="tipoComprobante">Tipo de comprobante a generar</label>
                                                      <select class="form-control" name="tipoComprobante">
                                                          <option value=""></option>
                                                      </select>
                                                  </div>
                                                  <div class="col-md-2">
                                                      <label for="tipoServicio">Tipo de servicio</label>
                                                      <select class="form-control" name="tipoServicio">
                                                          <option value="basico">Básico</option>
                                                          <option value="premium">Premium</option>
                                                      </select>
                                                  </div>
                                                  <div class="col-md-3">
                                                      <label for="mesesContratoCable">Período de contrato en meses</label>
                                                      <input class="form-control" type="text" name="mesesContratoCable">
                                                  </div>
                                              </div>
                                              <div class="row">
                                                  <div class="col-md-3">
                                                      <label for="vencimientoContratoCable">Fecha de vencimiento de contrato</label>
                                                      <input class="form-control" type="text" name="vencimientoContratoCable">
                                                  </div>
                                                  <div class="col-md-3">
                                                      <label for="inicioContratoCable">Fecha de inicio de contrato</label>
                                                      <input class="form-control" type="text" name="inicioContratoCable">
                                                  </div>
                                                  <div class="col-md-2">
                                                      <label for="fechaReconexionCable">Fecha de reconexión</label>
                                                      <input class="form-control" type="text" name="fechaReconexionCable">
                                                  </div>
                                                  <div class="col-md-4">
                                                      <label for="encargadoInstalacionCable"> Técnico que realizó la instalación</label>
                                                      <select class="form-control" name="encargadoInstalacionCable">
                                                          <option value=""></option>
                                                      </select>
                                                  </div>
                                              </div>
                                              <div class="row">
                                                  <div class="col-md-10">
                                                      <label for="direccionCable">Dirección</label>
                                                      <input class="form-control" type="text" name="direccionCable">
                                                  </div>
                                                  <div class="col-md-2">
                                                      <label for="derivaciones">N° de derivaciones</label>
                                                      <input class="form-control" type="text" name="derivaciones">
                                                  </div>
                                              </div>
                                          </div>
                                        </div>

                                      </div>
                                      <!-- Accordion card -->

                                      <!-- Accordion card -->
                                      <div class="card">

                                        <!-- Card header -->
                                        <div class="card-header" role="tab" id="headingTwo2">
                                          <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx1" href="#collapseTwo21"
                                            aria-expanded="false" aria-controls="collapseTwo21">
                                            <h5 class="mb-0 alert alert-success">
                                              INTERNET <i class="fas fa-angle-down rotate-icon"></i>
                                            </h5>
                                          </a>
                                        </div>

                                        <!-- Card body -->
                                        <div id="collapseTwo21" class="collapse" role="tabpanel" aria-labelledby="headingTwo21" data-parent="#accordionEx1">
                                          <div class="card-body">
                                              <div class="row">
                                                  <div class="col-md-2">
                                                      <label for="fechaInstalacionInternet">Fecha de instalación</label>
                                                      <input class="form-control" type="text" name="fechaInstalacionInternet">
                                                  </div>
                                                  <div class="col-md-3">
                                                      <label for="fechaPrimerFacturaInternet">Fecha de primer factura</label>
                                                      <input class="form-control" type="text" name="fechaPrimerFacturaInternet">
                                                  </div>
                                                  <div class="col-md-2">
                                                      <label for="tipoServicioInternet">Tipo de servicio</label>
                                                      <select class="form-control" name="tipoServicioInternet">
                                                          <option value="prepago">Prepago</option>
                                                          <option value="pospago">Pospago</option>
                                                      </select>
                                                  </div>
                                                  <div class="col-md-3">
                                                      <label for="mesesContratoInternet">Período de contrato en meses</label>
                                                      <input class="form-control" type="text" name="mesesContratoInternet">
                                                  </div>
                                                  <div class="col-md-2">
                                                      <label for="diaGenerarFacturaInternet">Día para generar factura</label>
                                                      <input class="form-control" type="text" name="diaGenerarFacturaInternet">
                                                  </div>
                                              </div>
                                              <div class="row">
                                                  <div class="col-md-3">
                                                      <label for="velocidadInternet">Velocidad</label>
                                                      <select class="form-control" name="velocidadInternet">
                                                          <option value=""></option>
                                                      </select>
                                                  </div>
                                                  <div class="col-md-3">
                                                      <label for="cuotaMensualInternet">Cuota mensual</label>
                                                      <input class="form-control" type="text" name="cuotaMensualInternet">
                                                  </div>
                                                  <div class="col-md-3">
                                                      <label for="tipoCliente">Tipo de cliente</label>
                                                      <select class="form-control" name="tipoCliente">
                                                          <option value=""></option>
                                                      </select>
                                                  </div>
                                                  <div class="col-md-3">
                                                      <label for="tecnologia">Tecnología</label>
                                                      <select class="form-control" name="tecnologia">
                                                          <option value=""></option>
                                                      </select>
                                                  </div>
                                              </div>
                                              <div class="row">
                                                  <div class="col-md-3">
                                                      <label for="nContratoVigente">N° de contrato vigente</label>
                                                      <input class="form-control" type="text" name="nContratoVigente">
                                                  </div>
                                                  <div class="col-md-3">
                                                      <label for="vencimientoContratoInternet">Vencimiento de contrato</label>
                                                      <input class="form-control" type="text" name="vencimientoContratoInternet">
                                                  </div>
                                                  <div class="col-md-2">
                                                      <label for="ultimaRenovacionInternet">Última renovación</label>
                                                      <input class="form-control" type="text" name="ultimaRenovacionInternet">
                                                  </div>
                                                  <div class="col-md-2">
                                                      <label for="fechaSuspencionInternet">Fecha de suspención</label>
                                                      <input class="form-control" type="text" name="fechaSuspencionInternet">
                                                  </div>
                                                  <div class="col-md-2">
                                                      <label for="fechaReconexionInternet">Fecha de reconexión</label>
                                                      <input class="form-control" type="text" name="fechaReconexionInternet">
                                                  </div>
                                              </div>
                                              <div class="row">
                                                  <div class="col-md-5">
                                                      <label for="promocion">Promoción</label>
                                                      <select class="form-control" name="promocion">
                                                          <option value=""></option>
                                                      </select>
                                                  </div>
                                                  <div class="col-md-2">
                                                      <label for="promocionDesde">Desde</label>
                                                      <input class="form-control" type="text" name="promocionDesde">
                                                  </div>
                                                  <div class="col-md-2">
                                                      <label for="promocionHasta">Hasta</label>
                                                      <input class="form-control" type="text" name="promocionHasta">
                                                  </div>
                                                  <div class="col-md-3">
                                                      <label for="cuotaPromocion">Cuota de la promoción</label>
                                                      <input class="form-control" type="text" name="cuotaPromocion">
                                                  </div>
                                              </div>
                                              <div class="row">
                                                  <div class="col-md-12">
                                                      <label for="direccionInternet">Dirección</label>
                                                      <input class="form-control" type="text" name="direccionInternet">
                                                  </div>
                                              </div>
                                              <hr style="border-top: 1px solid red;">
                                              <div class="row">
                                                  <div class="col-md-3">
                                                      <div class="row">
                                                          <div class="col-md-12">
                                                              <label for="colilla">Colilla</label>
                                                              <input class="form-control" type="text" name="colilla">
                                                          </div>
                                                          <div class="col-md-12">
                                                              <label for="wanip">WAN IP</label>
                                                              <input class="form-control" type="text" name="wanip">
                                                          </div>
                                                          <div class="col-md-12">
                                                              <label for="coordenadas">Coordenadas</label>
                                                              <input class="form-control" type="text" name="coordenadas">
                                                          </div>
                                                          <div class="col-md-12">
                                                              <label for="nodo">Nodo/Ap/Path</label>
                                                              <input class="form-control" type="text" name="nodo">
                                                          </div>
                                                      </div>
                                                  </div>
                                                  <div class="col-md-9">
                                                      <div class="row">
                                                          <div class="col-md-8">
                                                              <label for="modelo">Modelo</label>
                                                              <input class="form-control" type="text" name="modelo">
                                                          </div>
                                                          <div class="col-md-4">
                                                              <label for="recepcion">Recepción</label>
                                                              <input class="form-control" type="text" name="recepcion">
                                                          </div>
                                                          <div class="col-md-8">
                                                              <label for="mac">MAC</label>
                                                              <input class="form-control" type="text" name="mac">
                                                          </div>
                                                          <div class="col-md-4">
                                                              <label for="transmicion">Transmición</label>
                                                              <input class="form-control" type="text" name="transmicion">
                                                          </div>
                                                          <div class="col-md-8">
                                                              <label for="serie">Serie</label>
                                                              <input class="form-control" type="text" name="serie">
                                                          </div>
                                                          <div class="col-md-4">
                                                              <label for="ruido">Ruido</label>
                                                              <input class="form-control" type="text" name="ruido">
                                                          </div>
                                                          <div class="col-md-12">
                                                              <label for="claveWifi">Clave WIFI</label>
                                                              <input class="form-control" type="text" name="claveWifi">
                                                          </div>
                                                      </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                      <br>
                                                      <button class="btn btn-success btn-block" type="button" name="activarServicio" style="font-size:16px">Activar servicio</button>
                                                  </div>
                                                  <div class="col-md-6">
                                                      <br>
                                                      <button class="btn btn-danger btn-block" type="button" name="desactivarServicio" style="font-size:16px">Desactivar servicio</button>
                                                  </div>
                                              </div>
                                              <hr style="border-top: 1px solid red;">
                                          </div>
                                        </div>

                                      </div>
                                      <!-- Accordion card -->

                                      <!-- Accordion card -->
                                      <div class="card">

                                        <!-- Card header -->
                                        <div class="card-header" role="tab" id="headingThree31">
                                          <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx1" href="#collapseThree31"
                                            aria-expanded="false" aria-controls="collapseThree31">
                                            <h5 class="mb-0 alert alert-warning">
                                              TELEFONIA <i class="fas fa-angle-down rotate-icon"></i>
                                            </h5>
                                          </a>
                                        </div>

                                        <!-- Card body -->
                                        <div id="collapseThree31" class="collapse" role="tabpanel" aria-labelledby="headingThree31" data-parent="#accordionEx1">
                                          <div class="card-body">
                                            <h4>Servicio no disponible</h4>
                                          </div>
                                        </div>

                                      </div>
                                      <!-- Accordion card -->

                                    </div>
                                    <!-- Accordion wrapper -->
                                </div>
                                <div class="tab-pane fade" id="ordenes-tecnicas">
                                    <h4 class="alert alert-success"><strong>Historial de ordenes de trabajo</strong></h4>
                                    <div class="ordenes">
                                        <div class="col-md-12">
                                            <button class="btn btn-danger pull-right" type="button" name="button" data-toggle="modal" data-target="#ordenesTrabajo"><i class="fas fa-search"></i></button>
                                            <br><br>
                                        </div>
                                        <table class="table table-bordered table-hover">
                                                <tr class="info">
                                                    <th>N° de orden</th>
                                                    <th>Tipo de orden</th>
                                                    <th>Fecha de orden</th>
                                                    <th>Actividad realizada</th>
                                                    <th>Fecha de trabajo</th>
                                                    <th>Actividad internet</th>
                                                </tr>
                                                <tr>
                                                    <td>99947</td>
                                                    <td>Técnica</td>
                                                    <td>12/10/2019</td>
                                                    <td>Revisión de mala señal</td>
                                                    <td>25/7/2018</td>
                                                    <td>Cambio de contraseña de WIFI</td>
                                                </tr>
                                                <tr>
                                                    <td>99947</td>
                                                    <td>Técnica</td>
                                                    <td>12/10/2019</td>
                                                    <td>Revisión de mala señal</td>
                                                    <td>25/7/2018</td>
                                                    <td>Cambio de contraseña de WIFI</td>
                                                </tr>
                                        </table>
                                    </div>
                                    <h4 class="alert alert-success"><strong>Historial de ordenes de suspensión</strong></h4>
                                    <div class="ordenes">
                                        <div class="col-md-12">
                                            <button class="btn btn-danger pull-right" type="button" name="button" data-toggle="modal" data-target="#ordenesSuspension"><i class="fas fa-search"></i></button>
                                            <br><br>
                                        </div>
                                        <table class="table table-bordered table-hover">
                                                <tr class="info">
                                                    <th>N° de orden</th>
                                                    <th>Tipo de orden</th>
                                                    <th>Fecha de orden</th>
                                                    <th>Actividad realizada</th>
                                                    <th>Fecha de trabajo</th>
                                                    <th>Actividad internet</th>
                                                </tr>
                                                <tr>
                                                    <td>99947</td>
                                                    <td>Técnica</td>
                                                    <td>12/10/2019</td>
                                                    <td>Revisión de mala señal</td>
                                                    <td>25/7/2018</td>
                                                    <td>Cambio de contraseña de WIFI</td>
                                                </tr>
                                                <tr>
                                                    <td>99947</td>
                                                    <td>Técnica</td>
                                                    <td>12/10/2019</td>
                                                    <td>Revisión de mala señal</td>
                                                    <td>25/7/2018</td>
                                                    <td>Cambio de contraseña de WIFI</td>
                                                </tr>
                                        </table>
                                    </div>
                                    <h4 class="alert alert-success"><strong>Historial de ordenes de reconexión</strong></h4>
                                    <div class="ordenes">
                                        <div class="col-md-12">
                                            <button class="btn btn-danger pull-right" type="button" name="button" data-toggle="modal" data-target="#ordenesReconexion"><i class="fas fa-search"></i></button>
                                            <br><br>
                                        </div>
                                        <table class="table table-bordered table-hover">
                                                <tr class="info">
                                                    <th>N° de orden</th>
                                                    <th>Tipo de orden</th>
                                                    <th>Fecha de orden</th>
                                                    <th>Actividad realizada</th>
                                                    <th>Fecha de trabajo</th>
                                                    <th>Actividad internet</th>
                                                </tr>
                                                <tr>
                                                    <td>99947</td>
                                                    <td>Técnica</td>
                                                    <td>12/10/2019</td>
                                                    <td>Revisión de mala señal</td>
                                                    <td>25/7/2018</td>
                                                    <td>Cambio de contraseña de WIFI</td>
                                                </tr>
                                                <tr>
                                                    <td>99947</td>
                                                    <td>Técnica</td>
                                                    <td>12/10/2019</td>
                                                    <td>Revisión de mala señal</td>
                                                    <td>25/7/2018</td>
                                                    <td>Cambio de contraseña de WIFI</td>
                                                </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="notificaciones-traslados">
                                    <h4 class="alert alert-success"><strong>Historial de traslados</strong></h4>
                                    <div class="ordenes">
                                        <div class="col-md-12">
                                            <button class="btn btn-danger pull-right" type="button" name="button" data-toggle="modal" data-target="#traslados"><i class="fas fa-search"></i></button>
                                            <br><br>
                                        </div>
                                        <table class="table table-bordered table-hover">
                                                <tr class="info">
                                                    <th>N° de orden</th>
                                                    <th>Tipo de orden</th>
                                                    <th>Fecha de orden</th>
                                                    <th>Actividad realizada</th>
                                                    <th>Fecha de trabajo</th>
                                                    <th>Actividad internet</th>
                                                </tr>
                                                <tr>
                                                    <td>99947</td>
                                                    <td>Técnica</td>
                                                    <td>12/10/2019</td>
                                                    <td>Revisión de mala señal</td>
                                                    <td>25/7/2018</td>
                                                    <td>Cambio de contraseña de WIFI</td>
                                                </tr>
                                                <tr>
                                                    <td>99947</td>
                                                    <td>Técnica</td>
                                                    <td>12/10/2019</td>
                                                    <td>Revisión de mala señal</td>
                                                    <td>25/7/2018</td>
                                                    <td>Cambio de contraseña de WIFI</td>
                                                </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- Modal Ordenes de Trabajo -->
                <div id="ordenesTrabajo" class="modal fade" role="dialog">
                  <div class="modal-dialog modal-sm">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Buscar orden de trabajo</h4>
                      </div>
                      <div class="modal-body">
                        <form class="" action="#" method="post">
                            <input class="form-control" type="text" name="buscarOrdenTrabajo" placeholder="Número de orden">
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                          <button type="button" class="btn btn-primary" data-dismiss="modal">Buscar</button>
                        </form>
                      </div>
                    </div>

                  </div>
                </div>
                <!-- Modal Ordenes de Suspension -->
                <div id="ordenesSuspension" class="modal fade" role="dialog">
                  <div class="modal-dialog modal-sm">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Buscar orden de suspensión</h4>
                      </div>
                      <div class="modal-body">
                        <form class="" action="#" method="post">
                            <input class="form-control" type="text" name="buscarOrdenSuspension" placeholder="Número de orden">
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                          <button type="button" class="btn btn-primary" data-dismiss="modal">Buscar</button>
                        </form>
                      </div>
                    </div>

                  </div>
                </div>
                <!-- Modal Ordenes de Reconexion -->
                <div id="ordenesReconexion" class="modal fade" role="dialog">
                  <div class="modal-dialog modal-sm">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Buscar orden de suspensión</h4>
                      </div>
                      <div class="modal-body">
                        <form class="" action="#" method="post">
                            <input class="form-control" type="text" name="buscarOrdenReconexion" placeholder="Número de orden">
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                          <button type="button" class="btn btn-primary" data-dismiss="modal">Buscar</button>
                        </form>
                      </div>
                    </div>

                  </div>
                </div>
                <!-- Modal Ordenes de Traslados -->
                <div id="traslados" class="modal fade" role="dialog">
                  <div class="modal-dialog modal-sm">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Buscar traslado</h4>
                      </div>
                      <div class="modal-body">
                        <form class="" action="#" method="post">

                            <input class="form-control" type="text" name="buscarTraslado" placeholder="Número de orden">
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                          <button type="button" class="btn btn-primary" data-dismiss="modal">Buscar</button>
                        </form>
                      </div>
                    </div>

                  </div>
                </div>
                <!-- INICIO DEL MODAL DE BUSQUEDA -->
                <!-- Modal -->
                <div id="busquedaAvanzada" class="modal fade" role="dialog">
                  <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Búsqueda avanzada</h4>
                      </div>
                      <div class="modal-body">
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- FINAL MODAL DE BUSQUEDA -->
        </div><!-- /.row -->
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/dataTables.bootstrap.js"></script>
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
