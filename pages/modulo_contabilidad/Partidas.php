<?php
    session_start();
    require("php/getDatos.php");
    $get = new getInfo();
    $Partidas = $get-> getPartidas();
 ?>
<!DOCTYPE html>
<html lang="es">
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
  </head>

  <body>
      <?php
           // session_start();
           if(!isset($_SESSION["user"])) {
               header('Location: ../login.php');
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
                      <div class="col-lg-12">
                          <div class="page-header">
                              <h1><b>Partidas</b></h1>
                          </div>
                          <a href="contabilidad.php"><button class="btn btn-success pull-left" type="button" name="button"><i class="fas fa-arrow-left"></i> Atrás</button></a>
                          <a href="nuevaPartida.php"><button id="btn_agregar" class="btn btn-success pull-right" type="button" name="button" ><i class="fas fa-plus-circle"></i> Nuevo Partida</button></a>
                          <br><br><br>
                              <table width="100%" class="table table-striped table-hover" id="clientes5">
                                  <thead class="bg-primary">
                                      <tr>
                                          <th WIDTH="140">Código Partida</th>
                                          <th>Tipo Partida</th>
                                          <th>Fecha Partida</th>
                                          <th>Concepto Partida</th>
                                          <th></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php

                                          foreach ($Partidas as $key) {
                                              echo "<tr><td class='badge' WIDTH='100'>";
                                              echo $key["idPartida"] . "</td><td>";
                                              echo $key["tipoPartida"] . "</td><td>";
                                              echo $key["fechaPartida"] . "</td><td>";
                                              echo $key["conceptoPartida"] . "</td><td>";
                                              echo "<div class='btn-group pull-right'>
                                                          <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                            <i class='fas fa-ellipsis-v'></i>
                                                            <span class='sr-only'>Toggle Dropdown</span>
                                                          </button>
                                                          <ul class='dropdown-menu'>
                                                              <li><a href='actualizarPartida.php?id={$key["idPartida"]}' ><i class='fas fa-eye'></i> Ver Detalle</a>
                                                              </li>
                                                              <li class='eliminar'><a href='#' onclick='deleteCliente();'><i class='fas fa-trash-alt'></i> Eliminar</a>
                                                              </li>
                                                          </ul>
                                                      </div>" . "</td></tr>";
                                                  }
                                              ?>
                                  </tbody>
                              </table>
                              <!-- /.table-responsive -->
                      </div>
                  </div>
                  <!-- /.row -->
              </div>
              <!-- /.container-fluid -->
          </div>
          <!-- /#page-wrapper -->
      </div>
      <!-- /#wrapper -->

      <!-- jasQuery -->
      <script src="../../vendor/jquery/jquery.min.js"></script>
      <!-- Bootstrap Core JavaScript -->
      <script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>
      <!-- Metis Menu Plugin JavaScript -->
      <script src="../../vendor/metisMenu/metisMenu.min.js"></script>
      <!-- Custom Theme JavaScript -->
      <script src="../../dist/js/sb-admin-2.js"></script>
      <!-- DataTables JavaScript -->
      <script src="../../vendor/datatables/js/dataTables.bootstrap.js"></script>
      <script src="../../vendor/datatables/js/jquery.dataTables.min.js"></script>
      <script src="../../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
      <script src="../../vendor/datatables-responsive/dataTables.responsive.js"></script>
      <script>
          $(document).ready(function() {
              $('#clientes5').DataTable({
                  responsive: true,
                  "paging": true,
                  "order": [[ 1, "desc" ]],
                  "language": {
                  "lengthMenu": "Mostrar _MENU_ registros por página",
                  "zeroRecords": "No se encontró ningún registro",
                  "info": "Mostrando _TOTAL_ de _MAX_ clientes",
                  "infoEmpty": "No se encontró ningún registro",
                  "search": "Buscar: ",
                  "searchPlaceholder": "",
                  "infoFiltered": "(de un total de _MAX_ registros)",
                  "paginate": {
                   "previous": "Anterior",
                   "next": "Siguiente",
                  }
              }
              });
          });
      </script>
  </body>
</html>
