<?php
    session_start();
    require("../php/getViewA_D.php");

    $Inv = new GetViewA_D();
    $Empleados = $Inv->getEncargado();
    $Emple = $Inv->MostrarEmpleados();

    require("../php/productsInfo.php");
    $productsInfo = new ProductsInfo();
    $depar = $productsInfo->getDepartments2();
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

    <!-- DataTables CSS -->
    <!--<link rel="stylesheet" href="../vendor/datatables/css/dataTables.bootstrap.min.css"> -->
    <!--<link rel="stylesheet" href="../vendor/datatables/css/jquery.dataTables.min.css"> -->

</head>
<body>
    <?php
         require("../php/permisosGerencias.php");
         setPermisos();
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
                        <li><a href="config.php"><i class="fas fa-cog"></i> Configuración</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="../php/logout.php"><i class="fas fa-sign-out-alt"></i>Salir</a>
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
                            <a href="index.php"><i class="fas fa-home"></i> Principal</a>
                        </li>
                        <li>
                            <a href="infoCliente.php"><i class="fas fa-users"></i> Clientes</a>
                        </li>
                        <li>
                            <a class="" href="moduloInventario.php" d><i class="fas fa-scroll"></i> Inventario</a>
                        </li>
                        <li>
                            <a href="planillas.php"><i class="fas fa-file-signature"></i> Planillas</a>
                        </li>
                        <li>
                            <a href="contabilidad.php"><i class="fas fa-money-check-alt"></i> Contabilidad</a>
                        </li>
                        <li>
                            <a href="bancos.php"><i class="fas fa-university"></i> Bancos</a>
                        </li>
                        <li>
                            <a href="cxc.php"><i class="fas fa-hand-holding-usd"></i> Cuentas por cobrar</a>
                        </li>
                        <li>
                            <a href="#"><i class="fas fa-money-bill-wave"></i> Cuentas por pagar</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                    <h1 class="page-header alert alert-info">Asignar Encargados a Departamentos</Strong></h1>

                    <?php
                    if (isset($_GET['status'])) {
                        if ($_GET['status'] == 'success') {
                            echo "<div id='temporal' class='alert alert-warning alert-dismissible'>
                                      <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                      Se <strong>Proceso</strong> con exito.
                                  </div>";
                        }
                        else if ($_GET['status'] == 'failed'){
                            echo "<div id='temporal' class='alert alert-danger alert-dismissible'>
                                      <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                      Ya Existe esa Asignacion
                                  </div>";
                        }
                        else if ($_GET['status'] == 'UserNoExiste'){
                            echo "<div id='temporal' class='alert alert-danger alert-dismissible'>
                                      <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                      No existe empleado
                                  </div>";
                        }

                    }
                    else {
                        echo "<div id='temporal'> </div>";
                    }
                    ?>
            </div>
            <div class="col-lg-12">

            </div>
            <!-- /.row -->
            <div class="row">

                <form class="" action="" method="POST">
                  <a href="asignaciones.php"><button class="btn btn-success" type="button" name="regresar"><i class="fas fa-arrow-circle-left"></i> Atrás</button></a>
                <button id="btn_agregarr" class="btn btn-primary pull-right" type="button" name="button" data-toggle="modal" data-target="#AsignarEmpleado" accesskey="a"><i class="fas fa-plus-circle"></i> Asignar Nuevo Encargado</button>
                <br>
                <br>
                    <table width="100%" class="table table-striped table-hover" id="inventario">
                        <thead>
                            <tr>
                                <th>Codigo Departamento</th>
                                <th>Nombre Departamento</th>
                                <th>Codigo Encargado</th>
                                <th>Nombre Encargado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($Empleados as $key) {
                                    echo "<tr><td>";

                                    echo $key["CodigoDepartamento"] . "</td><td>";
                                    echo $key["NombreDepartamento"] . "</td><td>";
                                    echo $key["Codigo"] . "</td><td>";
                                    echo $key["Nombre"] ." ".  $key["Apellido"] . "</td><td>";

                                    echo "<div class='btn-group pull-right'>
                                                <button type='button' class='btn btn-default'>Opciones</button>
                                                <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                  <span class='caret'></span>
                                                  <span class='sr-only'>Toggle Dropdown</span>
                                                </button>
                                                <ul class='dropdown-menu'>";
                                                if($key["Emple"] == -1)
                                                {
                                                echo   "<li class='eliminar'><a href='#' onclick='return false'> No Hay Asignacion </a>
                                                  </li>";
                                                }
                                                else {
                                                  echo "<li class='eliminar'><a href='../php/DeleteAsignacionEncargado.php?Id={$key["IdDepartamento"]} '><i class='fas fa-trash-alt'></i> Quitar Asignacion</a>
                                                  </li>";
                                                }
                                                  "<li class='divider'></li>
                                                </ul>
                                            </div>" . "</td></tr>";
                                        }
                                    ?>
                        </tbody>
                    </table>
                    </form>
                </div>
                <!-- /.col-lg-12 -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    <div class="modal fade" id="AsignarEmpleado" tabindex="-1" role="dialog" aria-labelledby="AsignarEmpleado">
          <div class="modal-dialog" role="document">
                <div class="modal-content">
                      <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="nuevoProducto">Asignar Encargado a Departamento</h4>
                      </div>
                      <form action="../php/saveDetailsEncargadoDepartamento.php" method="POST">
                      <div class="modal-body">
                                  <div class="form-row">
                                      <div class="form-group col-md-6 col-xs-6">
                                          <label for="codigo">Código:</label>
                              <input type="text" class="form-control" name="CodEmpleado" id="CodEmpleado" placeholder="Código del Empleado" pattern="[0-9]{2}-[0-9]{2}-[0-9]{3}" title="DEBE AGREGAR SOLAMENTE NÚMEROS" required />
                                      </div>
                                      <div class="form-group col-md-6 col-xs-6">
                                          <label for="departamento">Nombre:</label>
                                          <input type="text" class="form-control" name="NomEmpleado" id="NomEmpleado" placeholder="Nombre del Empleado" />
                                      </div>
                                  </div>
                                  <div class="form-row">
                                      <div class="form-group col-md-12 col-xs-12">
                                          <label for="codigo">Departamento:</label>
                                          <select class="form-control form-control-lg" name="Departamento" required>
                                              <option value="" selected="selected">Seleccionar...</option>";
                                              <?php
                                                foreach ($depar as $key) {
                                                    echo "<option value='".strtolower($key['NombreDepartamento'])."'>".$key['NombreDepartamento']."</option>";
                                                }
                                              ?>
                                    </select>
                                          <hr>
                                      </div>
                                  </div>

                                  <table width="100%" class="table table-striped table-hover" id="tbl1">
                                      <thead>
                                          <tr>

                                              <!-- <th>Id artículo</th> -->
                                              <th>Código</th>
                                              <th>Nombre</th>
                                              <th>Dui</th>
                                              <th></th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <?php
                                              foreach ($Emple as $key) {
                                                  echo "<tr><td>";
                                                  echo $key["Codigo"] . "</td><td>";
                                                  echo $key["Nombres"] ." " . $key["Apellidos"] ."</td><td>";
                                                  echo $key["Dui"] . "</td><td>";
                                                  echo "<input type='button' class='btn btn-success' onclick='Cargar(\"{$key["Codigo"]}\",\"{$key["Nombres"]}\",\"{$key["Apellidos"]}\")' name='Seleccion' value='Seleccionar'>" . "</td></tr>";
                                                      }
                                                  ?>
                                      </tbody>
                                  </table>
                      </div>
                      <div class="modal-footer">
                            <button type="button" class="btn btn-default" name="Action1" data-dismiss="modal">Cancelar</button>
                            <input type="submit" class="btn btn-primary" name="Action2" value="Realizar Asignación">
                      </div>
                           </form>
                </div>
          </div>
    </div><!-- /Add modal -->
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
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#inventario').DataTable({
            responsive: true,
            "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No se encontró ningún registro",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No se encontró ningún registro",
            "search": "Buscar: ",
            "searchPlaceholder": "",
            "infoFiltered": "(de un total de _MAX_ total registros)",
            "paginate": {
             "previous": "Anterior",
             "next": "Siguiente"
            }
        }
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        $('#tbl1').DataTable({
            responsive: true,
            "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No se encontró ningún registro",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No se encontró ningún registro",
            "search": "Buscar: ",
            "searchPlaceholder": "",
            "infoFiltered": "(de un total de _MAX_ total registros)",
            "paginate": {
             "previous": "Anterior",
             "next": "Siguiente"
            }
        }
        });
    });
    </script>
    <script type="text/javascript">
      function Cargar(Codigo,Nombre,Apellido)
       {
      //var Valor = id
      //var Nombre = Nombre;
      $('#AsignarEmpleado').modal('show');

      document.getElementById("CodEmpleado").value = String(Codigo);
      document.getElementById("NomEmpleado").value = String(Nombre + " " + Apellido);

      //document.getElementById("nombre").value = Nombre;
      }
    </script>

    <script type="text/javascript">
        var d = new Date();
        var month = String((parseInt(d.getMonth()+1)))
        document.getElementById("fecha").value = d.getDate()+"/"+month+"/"+d.getFullYear();
    </script>

</body>

</html>
