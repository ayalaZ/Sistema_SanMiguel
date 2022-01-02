<?php
    session_start();
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
    <link rel="shortcut icon" href="../../images/Cablesat.png" />
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

</head>

<body>

    <?php
         // session_start();
         if(isset($_SESSION["user"])) {
             if ($_SESSION["rol"] != "administracion" && $_SESSION["rol"] != "subgerencia" && $_SESSION["rol"] != "jefatura" && $_SESSION["rol"] != "contabilidad") {
                 echo "<script>
                            alert('No tienes permisos para ingresar a esta área. Att: Don Manuel.');
                            window.location.href='../index.php';
                       </script>";
             }
         } else {
             header('Location: ../../php/logout.php');
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
                        <li><a href="php/logout.php"><i class="fas fa-sign-out-alt"></i></i> Salir</a>
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
                            <a href='../index.php'><i class='fas fa-home active'></i> Principal</a>
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
                            echo "<li><a href='../modulo_cxc/cxc.php'><i class='fas fa-hand-holding-usd'></i> Cuentas por cobrar</a></li>";
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
        <div id="page-wrapper">
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><b>Módulo Iva</b></h1>
                    <div class="row">
                          <a data-toggle="modal" data-target="#VerLibroContri" ><div class="col-lg-6 btn btn-default">
                            <div class="stat-icon">
                                <i class="fas fa-book fa-3x" style="color: #d32f2f;"></i>
                            </div>
                            <div class="stat-values">
                                <br>
                                <div class="name">Libro Contribuyentes</div>
                            </div>
                        </div></a>
                        <a data-toggle="modal" data-target="#VerLibroConsuFinal"><div class="col-lg-6 btn btn-default">
                            <div class="stat-icon">
                                <i class="fas fa-book fa-3x" style="color: #d32f2f;"></i>
                            </div>
                            <div class="stat-values">
                                <br>
                                <div class="name">Libro Consumidor Final</div>
                            </div>
                        </div></a>
                    </div>

                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->


    <!-- Add modal -->
    <div class="modal fade" id="VerLibroContri" tabindex="-1" role="dialog" aria-labelledby="VerLibroContri">
          <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                      <div class="modal-header" style="background-color: #d32f2f; color: white;">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="Balance Comprobación">Generación de libro de ventas a contribuyentes</h4>
                      </div>
                      <form action="php/pdfCreditoFiscal.php" method="POST" target="_blank">
                      <div class="modal-body">
                                  <div class="row">
                                      <div class="form-group col-md-4 col-xs-4">
                                          <label for="codigo">Punto de Venta:</label>
                                          <select class="form-control form-control-lg" name="puntoVentaGenerar" required>
                                             <option value="">Seleccionar...</option>
                                              <option value="1" selected>CABLESAT</option>;
                                         </select>
                                      </div>
                                      <div class="form-group col-md-4 col-xs-4">
                                          <label for="nombre">Mes a generar</label>
                                          <select class="form-control form-control-lg" name="mesGenerar" required>
                                             <option value="">Seleccionar...</option>
                                              <option value="1" >Enero</option>;
                                              <option value="2" >Febrero</option>;
                                              <option value="3" >Marzo</option>;
                                              <option value="4" >Abril</option>;
                                              <option value="5" >Mayo</option>;
                                              <option value="6" >Junio</option>;
                                              <option value="7" >Julio</option>;
                                              <option value="8" >Agosto</option>;
                                              <option value="9" >Septiembre</option>;
                                              <option value="10" >Octubre</option>;
                                              <option value="11" >Noviembre</option>;
                                              <option value="12" >Diciembre</option>;
                                         </select>
                                      </div>

                                      <div class="form-group col-md-4 col-xs-4">
                                          <label for="nombre">Año:</label>
                                          <input type="number" class="form-control form-control-lg" name="anoGenerar" min="1" max="2500" value="<?php echo date("Y"); ?>" required>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="form-group col-md-8 col-xs-8">
                                        <input type='checkbox' class='' name="encabezados" value="">
                                          <label for="encabezados">Encabezados en el libro</label><br>
                                        <input type='checkbox' class='' name="numPag" value="">
                                          <label for="codigo">Incluir números de página</label><br>
                                        <input type='checkbox' class='' name="libroDetallado" value="" checked>
                                          <label for="libroDetallado">Imprimir libro detallado</label>
                                      </div>
                                      <div class="form-group col-md-4 col-xs-4">
                                          <input class="" type="radio" name="facturas" value="1" checked>
                                          <label for="facturas">Factura normal</label>
                                          <!--<input class="" type="radio" name="facturas" value="2">
                                         <label for="facturas">Factura pequeña</label>-->
                                          <input class="" type="radio" name="facturas" value="3">
                                         <label for="facturas">Anuladas</label>
                                            <!--<input class="" type="radio" name="facturas" value="4" checked>
                                           <label for="facturas">Todas</label>-->
                                      </div>
                                  </div>

                      </div>
                      <div class="modal-footer">
                            <!--<button type="submit" name="excel" class="btn btn-default" data-dismiss="modal"><i class="fas fa-file-excel" style="color: green;"></i></button>-->
                            <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <input type="submit" name="generar" class="btn btn-danger" value="Generar">
                      </div>
                      </form>
                </div>
          </div>
    </div><!-- /Add modal -->


    <!-- Add modal -->
    <div class="modal fade" id="VerLibroConsuFinal" tabindex="-1" role="dialog" aria-labelledby="VerLibroConsuFinal">
          <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                      <div class="modal-header" style="background-color: #d32f2f;; color: white;">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="Balance Comprobación">Generación de libro de ventas a consumidor final</h4>
                      </div>
                      <form action="php/pdfConsumidorFinal.php" method="POST" target="_blank">
                      <div class="modal-body">
                                  <div class="row">
                                      <div class="form-group col-md-4 col-xs-4">
                                          <label for="codigo">Punto de Venta:</label>
                                          <select class="form-control form-control-lg" name="puntoVentaGenerar" required>
                                             <option value="">Seleccionar...</option>
                                              <option value="1" selected>CABLESAT</option>;
                                         </select>
                                      </div>
                                      <div class="form-group col-md-4 col-xs-4">
                                          <label for="nombre">Mes a generar</label>
                                          <select class="form-control form-control-lg" name="mesGenerar" required>
                                             <option value="">Seleccionar...</option>
                                              <option value="1" >Enero</option>;
                                              <option value="2" >Febrero</option>;
                                              <option value="3" >Marzo</option>;
                                              <option value="4" >Abril</option>;
                                              <option value="5" >Mayo</option>;
                                              <option value="6" >Junio</option>;
                                              <option value="7" >Julio</option>;
                                              <option value="8" >Agosto</option>;
                                              <option value="9" >Septiembre</option>;
                                              <option value="10" >Octubre</option>;
                                              <option value="11" >Noviembre</option>;
                                              <option value="12" >Diciembre</option>;
                                         </select>
                                      </div>
                                      <div class="form-group col-md-4 col-xs-4">
                                          <label for="nombre">Año:</label>
                                          <input type="number" class="form-control form-control-lg" name="anoGenerar" min="1" max="2500" value="<?php echo date("Y"); ?>" required>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="form-group col-md-6 col-xs-6">
                                        <input type='checkbox' class='' name="encabezados" value="1">
                                          <label for="encabezados">Encabezados en el libro</label><br>
                                        <input type='checkbox' class='' name="numPag" value="1">
                                          <label for="codigo">Incluir números de página</label><br>
                                        <input type='checkbox' class='' name="libroDetallado" value="1">
                                          <label for="libroDetallado">Imprimir libro detallado</label>
                                      </div>
                                      <div class="form-group col-md-6 col-xs-6">
                                        <input class="" type="radio" name="facturas" value="1">
                                        <label for="facturas">Factura normal</label>
                                         <input class="" type="radio" name="facturas" value="2">
                                        <label for="facturas">Factura pequeña</label>
                                        <input class="" type="radio" name="facturas" value="3">
                                       <label for="facturas">Anuladas</label>
                                       <input class="" type="radio" name="facturas" value="4" checked>
                                      <label for="facturas">Todas</label>
                                      </div>
                                  </div>

                      </div>
                      <div class="modal-footer">
                            <!--<button type="submit" name="excel" class="btn btn-default" data-dismiss="modal"><i class="fas fa-file-excel" style="color: green;"></i></button>-->
                            <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <input type="submit" name="generar" class="btn btn-danger" value="Generar">
                      </div>
                      </form>
                </div>
          </div>
    </div><!-- /Add modal -->

    <!-- jQuery -->
    <script src="../../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>
</body>
</html>
