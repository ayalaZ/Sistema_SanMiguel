<?php
    session_start();
    require("../php/connection.php");
 ?>
<?php
    $obj = new ConectionDB($_SESSION['db']);
    $con = $obj->ConectionDB($_SESSION['db']);
      try {
          $checkValues = $_GET['checkTraslado'];
          $values = array();
          foreach ($checkValues as $key)
           {
            array_push($values, $key);
          }
          $queryResults = array();

          for($i=0; $i < count($values); $i++)
          {
            $query = "SELECT IdArticuloDepartamento, Codigo, NombreArticulo, Cantidad, NombreDepartamento as Departamento FROM tbl_articulodepartamento, tbl_departamento where IdArticuloDepartamento = $values[$i] and tbl_articulodepartamento.IdDepartamento=tbl_departamento.IdDepartamento";
            $statement = $con->prepare($query);

            $statement->execute();

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            array_push($queryResults, $result);
          }
           $queryResults;
      } catch (Exception $e) {
        print "!Error¡:" . $e->getMessage() . "</br>";
        die();
      }
      if($_POST)
      {
              try{
                 $ch = $_POST['check'];
                  // write update query
                  // in this case, it seemed like we have so many fields to pass and
                  // it is better to label them and not use question marks
                  $query = "SELECT e.Codigo, e.Nombres, e.Apellidos
                  from tbl_empleado as e inner join tbl_departamento as d on e.IdDepartamento=d.IdDepartamento where e.IdEmpleado='".$ch."'";
                  // prepare query for excecution
                  $stmt = $con->prepare($query);
                  $stmt->execute();
                  $row = $stmt->fetch(PDO::FETCH_ASSOC);
                  $Codigo = $row["Codigo"];
                  $Nombre = $row["Nombres"];
              }
              // show errors
              catch(PDOException $exception){
                  die('ERROR: ' . $exception->getMessage());
              }
            }

    require("../php/productsInfo.php");
    $Emple = new ProductsInfo();
    $Empleados = $Emple->getEmpleados();
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
  <!-- <script language="JavaScript" type="text/javascript">
    alert("ESTE APARTADO ES EXCLUSIVAMENTE PARA MANTENER UN REGISTRO DE LOS ARTICULOS ASIGNADOS A LOS EMPLEADOS POR DEPARTAMENTO. EL EMPLEADO NO TENDRA QUE ACEPTAR NINGUNA CONFIRMACION DE RECIBIDO EN EL SISTEMA.");
  </script> -->
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
        <!-- Page Content -->
            <div id="page-wrapper">
                <div class="container-fluid">
                    <form class="" action="../php/saveDetailsEmpleado.php" method="POST">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">Asignacion de Articulos a Empleados</h1>
                        </div>
                        <!-- /.col-lg-12 -->
                        <div class="row">
                            <div class="col-lg-12">

                              <TABLE class="table table-striped">
                                <tr>
                                  <td colspan="12" align="center" width="50" Height="50"><b>INFORMACION DEL EMPLEADO</b></td>
                                </tr>
                                <tr>
                                  <td colspan="3"><b>Codigo:</b></td>
                                  <td colspan="3"><input type="text" name="Codigo" size="50" value="<?php echo htmlspecialchars(@$Codigo, ENT_QUOTES); ?>" placeholder="Codido Empleado"   required/></td>
                                  <td colspan="3"><b>Nombre:</b></td>
                                  <td colspan="3"><input type="text" name="Nombre" size="50" value="<?php echo htmlspecialchars(@$Nombre, ENT_QUOTES); ?>" placeholder="Nombre Empleado"  required/></td>
                                </tr>
                                <tr>
                                  <td colspan="12" align="center" width="50" Height="50"><b><button id="btn_agregar0" class="btn btn-primary" type="button" name="button" data-toggle="modal" data-target="#BuscarEmpleado" accesskey="a"><i class="fas fa-search"></i> Buscar Empleado</button></b></td>
                                </tr>
                              </TABLE>

                                <table class="table table-striped">
                                    <th>Id</th>
                                    <th>Artículo</th>
                                    <th>Bodega</th>
                                    <th>Existencias</th>
                                    <!-- <th>Cantidad a trasladar</th> -->
                                    <th><center>Descripcion del Articulo</center></th>
                                    <?php
                                    $Id = array();
                                    $Departamento = array();
                                        foreach ($queryResults as $article) {
                                            $i = 0;
                                            echo "<tr><td>";
                                            echo $article[$i]["IdArticuloDepartamento"]. "</td><td>";
                                            echo $article[$i]["NombreArticulo"]. "</td><td>";
                                            echo $article[$i]["Departamento"]. "</td><td align='center'>";
                                            echo $article[$i]["Cantidad"]. "</td><td>";

                                            echo "<center><textarea class='' rows='2' cols='70' name='Comentario[]' title='Ejemplo: Nº 12345 ó #2' placeholder='Ingresar Nº ó identificativo del Articulo' required ></textarea></center>" . "</td><tr>";
                                            array_push($Id,$article[$i]["IdArticuloDepartamento"]);
                                            array_push($Departamento,$article[$i]["Departamento"]);
                                            $i++;
                                        }
                                    ?>
                                </table>
                            </div>
                        </div><!-- /.row -->
                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <input type="hidden" name="array" value='<?php echo serialize($Id);?>'>
                        <input type="hidden" name="Departamento" value='<?php echo serialize($Departamento);?>'>
                        <a href="asignarArticuloEmpleado.php"><button class="btn btn-default" type="button" name="regresar"><i class="fas fa-arrow-circle-left"></i> Volver a inventario</button></a>
                        <button type="submit" name="Action2" class="btn btn-primary">Realizar Asignación</button>
                        <br>
                        <br>
                        <p style="color:#0000FF"; align="justify";>	NOTA: ESTE APARTADO ES EXCLUSIVAMENTE PARA MANTENER UN REGISTRO DE LOS ARTICULOS ASIGNADOS A LOS EMPLEADOS POR DEPARTAMENTO.
                       <B>EL EMPLEADO NO TENDRA QUE ACEPTAR NINGUNA CONFIRMACION DE RECIBIDO EN EL SISTEMA.
                        </b></p>
                    </div>
                    </form>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->


    <div class="modal fade" id="BuscarEmpleado" tabindex="-1" role="dialog" aria-labelledby="BuscarEmpleado">
          <div class="modal-dialog" role="document">
                <div class="modal-content">
                      <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="nuevoProducto">Listado de Empleados</h4>
                      </div>
                    <form action="<?php //echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$idArticulo}");?>" method="POST">
                      <div class="modal-body">
                                  <div class="form-row">
                                  </div>
                                      <table width="100%" class="table table-striped table-hover" id="inventario">
                                          <thead>
                                              <tr>

                                                  <th> </th>
                                                  <!-- <th>Id artículo</th> -->
                                                  <th>Código</th>
                                                  <th>Nombre</th>
                                                  <th>Departamento</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                            <?php
                                                 foreach ($Empleados as $key) {
                                                     echo "<tr><td>";
                                                     echo "<input type='checkbox' class='form-control checkbox' name='check' value='".$key['IdEmpleado']."'>" . "</td><td>";
                                                     echo $key["Codigo"] . "</td><td>";
                                                     echo $key["Nombres"] . "</td><td>";
                                                     echo $key["NombreDepartamento"] ."</td></tr>";
                                                         }
                                                     ?>
                                          </tbody>
                                      </table>
                      </div>
                      <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <a href="resumenArticuloEmpleado.php?bodega=:$"> <input type='submit' value='Seleccionar' onclick="clic()" class='btn btn-primary' />  </a>
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
            "paging": false,
            "order": [[ 1, "desc" ]],
            "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No se encontró ningún registro",
            "info": "Mostrando _TOTAL_ de _MAX_ Artículos",
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

    <script type='text/javascript'>
        // confirm record deletion
        function deleteArticle(id){

            var answer = confirm('¿Está seguro de borrar este registro?');
            if (answer){
                window.location = 'borrarArticulo.php?id=' + id;
            }
        }
    </script>
</body>
</html>
