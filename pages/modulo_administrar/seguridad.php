<?php
    require("php/getUsers.php");
    $allUsers = new GetUsers();
    $allUsersRecords = $allUsers->getUserRecords();
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
                        <li><a href="config.php"><i class="fas fa-cog"></i> Configuraci??n</a>
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
                            <a href='../index.php'><i class='fas fa-home'></i> Principal</a>
                        </li>
                        <?php
                        require('../../php/contenido.php');
                        require('../../php/modulePermissions.php');

                        if (setMenu($_SESSION['permisosTotalesModulos'], ADMINISTRADOR)) {
                            echo "<li><a href='administrar.php'><i class='fas fa-key'></i> Administrar</a></li>";
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

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Gesti??n de usuarios</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <a href="administrar.php"><button class="btn btn-success" type="button" name="regresar"><i class="fas fa-arrow-circle-left"></i> Atr??s</button></a>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <br>
                            <?php
                                if (isset($_GET['status'])) {
                                    if ($_GET['status'] == "success") {
                                        echo "<div id='temporal' class='alert alert-success alert-dismissible'>
                                                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                                  Su registro <strong>ingres??</strong> con exito.
                                              </div>";
                                    }
                                    else if ($_GET['status'] == 'failed'){
                                        echo "<div id='temporal' class='alert alert-danger alert-dismissible'>
                                                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                                  Su registro <strong>fall??.</strong>
                                              </div>";
                                    }
                                }
                                else {
                                    echo "";
                                }
                             ?>
                            <button id="btn_agregar" class="btn btn-primary pull-right" type="button" name="button" data-toggle="modal" data-target="#usuarioNuevo"><i class="fas fa-plus-circle"></i> Usuario nuevo</button>
                            <br><br>

                                <table width="100%" class="table table-striped table-hover" id="nuevoUsuario">
                                    <thead>
                                        <tr>
                                            <th>Id usuario</th>
                                            <th>C??digo empleado</th>
                                            <th>Nombre</th>
                                            <th>Apellido</th>
                                            <th>Usuario</th>
                                            <th>Tipo de usuario</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($allUsersRecords as $key) {
                                                echo "<tr><td>";
                                                echo $key["IdUsuario"] . "</td><td>";
                                                echo $key["Codigo"] . "</td><td>";
                                                echo $key["Nombres"] . "</td><td>";
                                                echo $key["Apellidos"] . "</td><td>";
                                                echo $key["Usuario"] . "</td><td>";
                                                echo $key["Rol"] . "</td><td>";
                                                echo "<div class='btn-group pull-right'>
                                                            <button type='button' class='btn btn-default'>Opciones</button>
                                                            <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                              <span class='caret'></span>
                                                              <span class='sr-only'>Toggle Dropdown</span>
                                                            </button>
                                                            <ul class='dropdown-menu'>
                                                                <li><a href='verUsuario.php?id={$key['IdUsuario']}'><i class='fas fa-eye'></i> Ver</a>
                                                                </li>
                                                                <li class='editar'><a href='editarUsuario.php'><i class='fas fa-edit'></i> Editar</a>
                                                                </li>
                                                                <li class='eliminar'><a href='#' onclick='eliminarUsuario()'><i class='fas fa-trash-alt'></i> Eliminar</a>
                                                                </li>
                                                            </ul>
                                                        </div>" . "</td></tr>";
                                                    }
                                                ?>
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->


        <!-- Add modal -->

        <div class="modal fade" id="usuarioNuevo" tabindex="-1" role="dialog" aria-labelledby="nuevoUsuario">
              <div class="modal-dialog" role="document">
                    <div class="modal-content">
                          <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Nuevo usuario</h4>
                          </div>
                    <form action="php/setUser.php" method="POST">
                          <div class="modal-body">
                              <div class="form-row">
                                  <div class="form-group col-md-12 col-xs-12">
                                      <label for="usuario">Nombre de usuario:</label>
                                      <input type="text" class="form-control" name="usuario"  placeholder="Escriba el nombre de usuario" pattern="[a-zA-Z??????????]+\s?[a-zA-Z??????????]+?\s?[a-zA-Z??????????]+\s?[a-zA-Z??????????]+?" title="Escribir solamente letras" required>
                                  </div>
                              </div>

                              <div class="form-row">
                                <div class="form-group col-md-12 col-xs-12">
                                    <label for="clave">Contrase??a</label>
                                    <input type="text" class="form-control" name="clave" placeholder="Escriba la contrase??a" title="Puede escribir combinaci??n de letras y n??meros" required>
                                </div>
                              </div>
                              <div class="form-row">
                                <div class="form-group col-md-12 col-xs-12">
                                    <label for="rol">Rol:</label>
                                    <select class="form-control" name="rol" required>
                                        <option value="administrador" selected>...</option>
                                        <option value="administrador">Administrador</option>
                                        <option value="subgerente">Subgerente</option>
                                        <option value="subgerente">jefatura</option>
                                        <option value="subgerente">contabilidad</option>
                                        <option value="subgerente">atencion</option>
                                    </select>
                                </div>
                              </div>
                          </div>
                          <div class="modal-footer">
                            <div class="form-row">
                              <div class="form-group col-md-12 col-xs-12">
                                <button type="button" name="Action1" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <input type="submit" name="Action2" class="btn btn-primary" value="Guardar">
                              </div>
                            </div>
                          </div>
                    </form>
                    </div>
              </div>
        </div><!-- /Add modal -->

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
