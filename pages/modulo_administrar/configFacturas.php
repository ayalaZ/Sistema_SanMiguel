<?php
if(!isset($_SESSION))
{
    session_start([
        'cookie_lifetime' => 86400,
    ]);
}
    require_once "php/getFacturaConfig.php";
    $config = new getFacturaConfig();
    $arrConfig = $config->getConfig();

    $prefijoFactura = $arrConfig['prefijoFactura'];
    $prefijoFiscal = $arrConfig['prefijoFiscal'];
    $prefijoFacturaPeque = $arrConfig['prefijoFacturaPeque'];

    $ultimaFactura = $arrConfig['ultimaFactura'];
    $ultimaFiscal = $arrConfig['ultimaFiscal'];
    $ultimaPeque = $arrConfig['ultimaPeque'];

    $rangoDesdeFactura = $arrConfig['rangoDesdeFactura'];
    $rangoHastaFactura = $arrConfig['rangoHastaFactura'];
    $rangoDesdeFiscal = $arrConfig['rangoDesdeFiscal'];
    $rangoHastaFiscal = $arrConfig['rangoHastaFiscal'];
    $rangoDesdePeque = $arrConfig['rangoDesdePeque'];
    $rangoHastaPeque = $arrConfig['rangoHastaPeque'];
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
             if ($_SESSION["rol"] != "administracion") {
                 echo "<script>
                            alert('No tienes permisos para ingresar a esta área');
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
                   <h1 class="page-header"><b>Configuración general</b></h1>
                   <div class="panel panel-primary">
                      <div class="panel-heading">Configuración de facturas</div>
                      <div class="panel-body">
                          <?php
                          if (isset($_GET['gen'])) {
                              if ($_GET['gen'] == "continuecre") {
                                  echo '
                                  <div class="alert alert-warning">
                                  <b><i>Nota:</i></b> No hay rango disponible de facturas con el prefijo actual. Por favor actualice el prefijo y rango nuevo de <b>CREDITO FISCAL</b> y posteriormente vuelva a generar las facturas de la misma fecha en la que se quedó. La generación continuará donde se quedó y comenzará con el nuevo prefijo.
                                  </div>
                                  ';
                              }elseif ($_GET['gen'] == "continuecon") {
                                  echo '
                                  <div class="alert alert-warning">
                                  <b><i>Nota:</i></b> No hay rango disponible de facturas con el prefijo actual. Por favor actualice el prefijo y rango nuevo de <b>CONSUMIDOR FINAL</b> y posteriormente vuelva a generar las facturas de la misma fecha en la que se quedó. La generación continuará donde se quedó y comenzará con el nuevo prefijo.
                                  </div>
                                  ';
                              }
                          }
                          ?>
                      <form class="" action="php/setFacturaConfig.php" method="POST">
                          <table class="table table-bordered table-striped">
                              <thead>
                                  <th></th>
                                  <th>Prefijo/serie</th>
                                  <th>Prefijo fact peq</th>
                                  <th>Último N°</th>
                                  <th>Últ N° fact peq</th>
                                  <th>Rango desde</th>
                                  <th>Rango hasta</th>
                              </thead>
                              <tbody>

                                  <tr>
                                      <th>Crédito fiscal</th>
                                      <td><input class="form-control" type="text" name="prefijoFiscal" value="<?php echo $prefijoFiscal ?>"></td>
                                      <td><input class="form-control" type="text" name="prefijoFacturaPeque" value="<?php echo $prefijoFacturaPeque ?>"></td>
                                      <td><input class="form-control" type="text" name="ultimaFiscal" value="<?php echo $ultimaFiscal ?>"></td>
                                      <td><input class="form-control" type="text" name="ultimaPeque" value="<?php echo $ultimaPeque ?>"></td>
                                      <td><input class="form-control" type="text" name="rangoDesdeFiscal" value="<?php echo $rangoDesdeFiscal ?>"></td>
                                      <td><input class="form-control" type="text" name="rangoHastaFiscal" value="<?php echo $rangoHastaFiscal ?>"></td>
                                  </tr>
                                  <tr>
                                      <th>Fact cons final</th>
                                      <td><input class="form-control" type="text" name="prefijoFactura" value="<?php echo $prefijoFactura ?>"></td>
                                      <td><input class="form-control" type="text" name="" value=""></td>
                                      <td><input class="form-control" type="text" name="ultimaFactura" value="<?php echo $ultimaFactura?>"></td>
                                      <td><input class="form-control" type="text" name="" value=""></td>
                                      <td><input class="form-control" type="text" name="rangoDesdeFactura" value="<?php echo $rangoDesdeFactura ?>"></td>
                                      <td><input class="form-control" type="text" name="rangoHastaFactura" value="<?php echo $rangoHastaFactura ?>"></td>
                                  </tr>
                              </tbody>
                          </table>
                          <button class="btn btn-danger btn-block btn-lg" type="submit" name="submit">Guardar configuración</button>
                      </form>
                      </div>
                   </div>
               </div>
           </div>
           <!-- /.row -->
        </div>


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

</body>

</html>
