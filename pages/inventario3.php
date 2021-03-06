<?php
session_start();
require("../php/contenido.php");
//include 'SelecBodega.php';
require("../php/productsInfo.php");
$productsInfo = new ProductsInfo();
$warehouses = $productsInfo->getWarehouses();

// Setcookie ("bdgSelec","0",time()-100);
// $Bodega = array();
// foreach ($warehouses as $key)
// {
// array_push($Bodega,$key["NombreBodega"]);
// }
// setcookie('bdg', json_encode($Bodega), 0);
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
  <link rel="shortcut icon" href="../images/Cablesat.png" />
  <!-- Bootstrap Core CSS -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- MetisMenu CSS -->
  <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

  <!-- Font awesome CSS -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

  <!-- Custom CSS -->
  <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
  <link rel="stylesheet" href="../dist/css/custom-principal.css">

  <!-- Morris Charts CSS -->
  <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

  <!-- Custom Fonts -->
  <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>

<body>

  <?php
         // session_start();
         if (!isset($_SESSION["user"])) {
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
        <a class="navbar-brand" href="index.html">Cablesat</a>
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
            <li><a href="config.php"><i class="fas fa-cog"></i> Configuraci??n</a>
            </li>
            <li class="divider"></li>
            <li><a href="../php/logout.php"><i class="fas fa-sign-out-alt"></i> Salir</a>
            </li>
          </ul>
          <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
      </ul>
      <!-- /.navbar-top-links -->

      <div class='navbar-default sidebar' role='navigation'>
        <div class='sidebar-nav navbar-collapse'>
          <ul class='nav' id='side-menu'>
            <li>
              <a href='index.php'><i class='fas fa-home'></i> Principal</a>
            </li>
            <?php
                    //    require('../php/contenido.php');
                    //    require('../php/modulePermissions.php');

                        if (setMenu($_SESSION['permisosTotalesModulos'], ADMINISTRADOR)) {
                            echo "<li><a href='modulo_administrar/administrar.php'><i class='fas fa-key'></i> Administrar</a></li>";
                        } else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], CONTABILIDAD)) {
                            echo "<li><a href='modulo_contabilidad/contabilidad.php'><i class='fas fa-money-check-alt'></i> Contabilidad</a></li>";
                        } else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], PLANILLA)) {
                            echo "<li><a href='modulo_planillas/planillas.php'><i class='fas fa-file-signature'></i> Planillas</a></li>";
                        } else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], ACTIVOFIJO)) {
                            echo "<li><a href='modulo_activoFijo/activoFijo.php'><i class='fas fa-building'></i> Activo fijo</a></li>";
                        } else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], INVENTARIO)) {
                            echo "<li><a href='moduloInventario.php'><i class='fas fa-scroll'></i> Inventario</a></li>";
                        } else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], IVA)) {
                            echo "<li><a href='modulo_iva/iva.php'><i class='fas fa-file-invoice-dollar'></i> IVA</a></li>";
                        } else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], BANCOS)) {
                            echo "<li><a href='modulo_bancos/bancos.php'><i class='fas fa-university'></i> Bancos</a></li>";
                        } else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], CXC)) {
                            echo "<li><a href='modulo_cxc/cxc.php'><i class='fas fa-hand-holding-usd'></i> Cuentas por cobrar</a></li>";
                        } else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], CXP)) {
                            echo "<li><a href='modulo_cxp/cxp.php'><i class='fas fa-money-bill-wave'></i> Cuentas por pagar</a></li>";
                        } else {
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
          <h1 class="page-header"><b>INVENTARIO</b></h1>
          <div class="row">
            <div class="row">
              <div class="col-lg-12">
                <a href="moduloInventario.php"><button class="btn btn-success" type="button" name="regresar"><i class="fas fa-arrow-circle-left"></i> Atr??s</button></a>
              </div>
              <br><br><br>
            </div>
            <a class="" href="" data-toggle="modal" data-target="#SeleccioneBodega">
              <div class="col-lg-6 btn btn-default">
                <div class="stat-icon">
                  <i class="fas fa-building fa-3x"></i>
                </div>
                <div class="stat-values">
                  <br>
                  <div class="name">Inventario <b>Bodegas</b></div>
                </div>
              </div>
            </a>
            <a class="" href="" data-toggle="modal" data-target="#SeleccioneBodegaI">
              <div class="col-lg-6 btn btn-default">
                <div class="stat-icon">
                  <i class="fas fa-box-open fa-3x"></i>
                </div>
                <div class="stat-values">
                  <br>
                  <div class="name">Inventario <b>Internet</b></div>
                </div>
              </div>
            </a>
          </div>
          <div class="row">

            <a class="" href="inventarioEmpleado.php">
              <div class="col-lg-6 btn btn-default">
                <div class="stat-icon">
                  <i class="fas fa-address-book fa-3x"></i>
                </div>
                <div class="stat-values">
                  <br>
                  <div class="name">Art??culos asignados a <b>empleados</b></div>
                </div>
              </div>
            </a>
            <a href="inventarioDepartamento.php">
              <div class="col-lg-6 btn btn-default">
                <div class="stat-icon">
                  <i class="fas fa-book fa-3x"></i>
                </div>
                <div class="stat-values">
                  <br>
                  <div class="name">Art??culos asignados a <b>departamentos</b></div>
                </div>
              </div>
            </a>
          </div>

        </div>
      </div>
      <!-- /.row -->
    </div>

    <!-- /#page-wrapper -->
  </div>
  <!-- /#wrapper -->
  <?php
            echo  "<div class='modal fade' id='SeleccioneBodega' tabindex='-1' role='dialog' aria-labelledby='SeleccioneBodega'>
                  <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                              <div class='modal-header'>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                                    <h4 class='modal-title' id='nuevoProducto'>Selecci??n</h4>
                            </div>
                            <form action='inventarioBodegas.php' method='GET'>
                              <div class='modal-body'>
                                          <div class='form-row'>
                                                  <label for='bodega'>Seleccion Bodega</label>
                                                  <select class='form-control form-control-lg' name='bodega' required>
                                                      <option value='' selected='selected'>Seleccionar...</option>";
                                                      foreach ($warehouses as $key) {
                                                          echo "<option value='".strtolower($key['NombreBodega'])."'>".$key['NombreBodega']."</option>";
                                                      }
                                            echo "</select>
                                          </div>
                              </div>
                              <div class='modal-footer'>
                                    <button type='button' class='btn btn-default' data-dismiss='modal'>Cancelar</button>
                                     <input type='submit' class='btn btn-primary' value='Ver Inventario'>
                              </div>
                                  </form>
                        </div>
                  </div>
            </div>
            <div class='modal fade' id='SeleccioneBodegaI' tabindex='-1' role='dialog' aria-labelledby='SeleccioneBodegaI'>
                  <div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                              <div class='modal-header'>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                                    <h4 class='modal-title' id='nuevoProducto'>Selecci??n</h4>
                            </div>
                            <form action='inventarioInternet.php' method='GET'>
                              <div class='modal-body'>
                                          <div class='form-row'>
                                                  <label for='bodega'>Seleccion Bodega</label>
                                                  <select class='form-control form-control-lg' name='bodega' required>
                                                      <option value='' selected='selected'>Seleccionar...</option>";
                                                      foreach ($warehouses as $key) {
                                                          echo "<option value='".strtolower($key['NombreBodega'])."'>".$key['NombreBodega']."</option>";
                                                      }
                                            echo "</select>
                                          </div>
                              </div>
                              <div class='modal-footer'>
                                    <button type='button' class='btn btn-default' data-dismiss='modal'>Cancelar</button>
                                     <input type='submit' class='btn btn-primary' value='Ver Inventario'>
                              </div>
                                  </form>
                        </div>
                  </div>
            </div>"
        ?>
  <!-- jQuery -->
  <script src="../vendor/jquery/jquery.min.js"></script>

  <!-- Bootstrap Core JavaScript -->
  <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

  <!-- Metis Menu Plugin JavaScript -->
  <script src="../vendor/metisMenu/metisMenu.min.js"></script>

  <!-- Morris Charts JavaScript -->
  <script src="../vendor/raphael/raphael.min.js"></script>
  <script src="../vendor/morrisjs/morris.min.js"></script>
  <script src="../data/morris-data.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
</body>

</html>
