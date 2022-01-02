<?php
    session_start();
    require("../php/connection.php");
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

<?php
    // get passed parameter value, in this case, the record ID
    // isset() is a PHP function used to verify if a value is there or not
    $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Registro no encontrado.');

    //include database connection
        $obj = new ConectionDB($_SESSION['db']);
        $con = $obj->ConectionDB($_SESSION['db']);

    // read current record's data
    try {
        // prepare select query
        $query = "SELECT * FROM tbl_articulointernet WHERE IdArticulo = ? LIMIT 0,1";
        $stmt = $con->prepare( $query );

        // this is the first question mark
        $stmt->bindParam(1, $id);

        // execute our query
        $stmt->execute();

        // store retrieved row to a variable
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // values to fill up our form
        $mac = $row['Mac'];
        $serie = $row['Serie'];
        $estado = $row['Estado'];
        $bodega = $_GET['Bdg'];
        $marca = $row['Marca'];
        $modelo = $row['Modelo'];
        $descripcion = $row['Descripcion'];
        $Proveedor = $row['Proveedor'];
        $Fabricante = $row['Fabricante'];
        $Categoria = $row['Categoria'];
        $Tecnologia = $row['Tecnologia'];
        $fechaEntrada = $row['fecha'];
        $fechaSalida = $row['fechaSalida'];
        $fechaRecuperado = $row['fechaRecuperado'];
        $condicion = $row['condicion'];
        $Garantia = $row['Garantia'];
    }

    // show error
    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }
?>
    <div class="page-header">

                    <h1 class="page-header alert alert-info">Producto MAC: <?php echo htmlspecialchars($mac, ENT_QUOTES);  ?></h1>
                    <?php
                    if (isset($_GET['status'])) {
                        if ($_GET['status'] == 'success') {
                            echo "<div id='temporal' class='alert alert-warning alert-dismissible'>
                                      <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                      Su registro <strong>ingresó</strong> con exito.
                                  </div>";
                        }
                        else if ($_GET['status'] == 'failed'){
                            echo "<div id='temporal' class='alert alert-danger alert-dismissible'>
                                      <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                      Su registro <strong>falló.</strong>
                                  </div>";
                        }
                    }
                    else {
                        echo "<div id='temporal'> </div>";
                    }
                    ?>
    </div>
    <!--we have our html table here where the record will be displayed-->
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Marca</td>
            <td><?php echo htmlspecialchars($marca, ENT_QUOTES);  ?></td>
        </tr>
        <tr>
            <td>Modelo</td>
            <td><?php echo htmlspecialchars($modelo, ENT_QUOTES);  ?></td>
        </tr>
        <tr>
            <td>Mac</td>
            <td><?php echo htmlspecialchars($mac, ENT_QUOTES);  ?></td>
        </tr>
        <tr>
            <td>Serie</td>
            <td><?php echo htmlspecialchars($serie, ENT_QUOTES);  ?></td>
        </tr>
        <tr>
            <td>Estado</td>
            <td><?php
            $state = "";
            if($estado == 0)
            {
              $state = "Bueno";
            }
            else if($estado == 1)
            {
              $state = "Regular";
            }
            else if($estado == 2)
            {
              $state = "Quemado";
            }
            else if($estado == 3)
            {
              $state = "Defectuoso";
            }
            echo htmlspecialchars($state, ENT_QUOTES);  ?></td>
        </tr>
        <tr>
            <td>Descripción</td>
            <td><?php echo htmlspecialchars($descripcion, ENT_QUOTES);  ?></td>
        </tr>
        <tr>
            <td>Proveedor</td>
            <td><?php echo htmlspecialchars($Proveedor, ENT_QUOTES);  ?></td>
        </tr>
        <tr>
            <td>Fabricante</td>
            <td><?php echo htmlspecialchars($Fabricante, ENT_QUOTES);  ?></td>
        </tr>
        <tr>
            <td>Categoría</td>
            <td><?php echo htmlspecialchars($Categoria, ENT_QUOTES);  ?></td>
        </tr>
        <tr>
            <td>Tecnología</td>
            <td><?php echo htmlspecialchars($Tecnologia, ENT_QUOTES);  ?></td>
        </tr>
        <tr>
            <td>Fecha de ingreso</td>
            <td class="info"><?php echo htmlspecialchars($fechaEntrada, ENT_QUOTES);  ?></td>
        </tr>
        <tr>
            <td>Fecha de salida</td>
            <td class="success"><?php echo htmlspecialchars($fechaSalida, ENT_QUOTES);  ?></td>
        </tr>
        <tr>
            <td>Fecha de recuperación</td>
            <td class="danger"><?php echo htmlspecialchars($fechaRecuperado, ENT_QUOTES);  ?></td>
        </tr>
        <tr>
          <td>Condición</td>
          <td><?php echo htmlspecialchars($condicion, ENT_QUOTES);  ?></td>
        </tr>
        <tr>
          <td>Meses de garantía</td>
          <td><?php echo htmlspecialchars($Garantia, ENT_QUOTES);  ?></td>
        </tr>
        <tr>
            <td></td>
            <td>
              <form name="Bog" action="#" method="GET">
                <?php $Bodega = $_GET["Bdg"]; ?>
                <a href='inventarioInternet.php?bodega=<?php echo $Bodega; ?>' class='btn btn-danger'>Regresar a inventario</a>
              </form>
            </td>
        </tr>
    </table>
            </div>

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
