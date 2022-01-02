<?php
if(!isset($_SESSION))
{
    session_start([
        'cookie_lifetime' => 86400,
    ]);
}
    require("../php/connection.php");
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
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
                <br>
                <div class="col-md-12">
<?php
    // get passed parameter value, in this case, the record ID
    // isset() is a PHP function used to verify if a value is there or not
    $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Registro no encontrado.');

    //include database connection
      $obj = new ConectionDB($_SESSION['db']);
      $con = $obj->ConectionDB($_SESSION['db']);
      $cantidad = 0;
    // read current record's data
    try {
        // prepare select query
        $query = "SELECT IdArticulo, Codigo, NombreArticulo, Descripcion, Cantidad, PrecioCompra, PrecioVenta, FechaEntrada, IdBodega FROM tbl_articulo WHERE IdArticulo = ? LIMIT 0,1";
        $stmt = $con->prepare( $query );

        // this is the first question mark
        $stmt->bindParam(1, $id);

        // execute our query
        $stmt->execute();

        // store retrieved row to a variable
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // values to fill up our form
        $idArticulo = $row['IdArticulo'];
        $codigo = $row['Codigo'];
        $nombreArticulo = $row['NombreArticulo'];
        $descripcion = $row['Descripcion'];
        $cantidad1 = $row['Cantidad'];
        $precioC = $row['PrecioCompra'];
        $precioV = $row['PrecioVenta'];
        $fechaEntrada = $row['FechaEntrada'];
        $IdBodega = $row['IdBodega'];
    }

    // show error
    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }


// check if form was submitted
if($_POST){

    try{
      $Nombre = htmlspecialchars(strip_tags($_POST["NOMBRE"]));
      $Apellido = htmlspecialchars(strip_tags($_POST["APELLIDO"]));
        // write update query
        // in this case, it seemed like we have so many fields to pass and
        // it is better to label them and not use question marks
        $query = "UPDATE tbl_articulo
                    SET IdArticulo=:idArticulo, Codigo=:codigo, NombreArticulo=:nombreArticulo, Descripcion=:descripcion,
                        Cantidad= Cantidad + :cantidad, PrecioCompra=:precioC, PrecioVenta=:precioV, FechaEntrada=:fechaEntrada
                    WHERE IdArticulo = :id";

        // prepare query for excecution
        $stmt = $con->prepare($query);

        // posted values
        $idArticulo=htmlspecialchars(strip_tags($_POST['idArticulo']));
        $codigo=htmlspecialchars(strip_tags($_POST['codigo']));
        $nombreArticulo=htmlspecialchars(strip_tags($_POST['nombreArticulo']));
        $descripcion=htmlspecialchars(strip_tags($_POST['descripcion']));
        $cantidad=htmlspecialchars(strip_tags($_POST['cantidad']));
        $precioC=htmlspecialchars(strip_tags($_POST['precioC']));
        $precioV=htmlspecialchars(strip_tags($_POST['precioV']));
        $fechaEntrada=htmlspecialchars(strip_tags($_POST['fechaEntrada']));
        $IdBodega = htmlspecialchars(strip_tags($_POST['IdBodega']));
        date_default_timezone_set('America/El_Salvador');

        // bind the parameters
        $stmt->bindParam(':idArticulo', $idArticulo);
        $stmt->bindParam(':codigo', $codigo);
        $stmt->bindParam(':nombreArticulo', $nombreArticulo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':precioC', $precioC);
        $stmt->bindParam(':precioV', $precioV);
        $stmt->bindParam(':fechaEntrada', $fechaEntrada);
        $stmt->bindParam(':id', $idArticulo);

        if($stmt->execute())
        {
          //GUARDAMOS EL HISTORIAL DE LA ENTRADA
          $idHistorial = $idArticulo;
          $nombreArticuloHistorial = $_POST['nombreArticulo'];
          $nombreEmpleadoHistorial = $_POST['nombreEmpleadoHistorial'];
          $nombreBodegaHistorial = ucwords($_POST['IdBodega']);
          $cantidadHistorial = $cantidad;
          $tipoMovimientoHistorial = "Actualizacion de producto";

          $query = "INSERT into tbl_historialentradas (nombreArticulo, nombreEmpleado, fechaHora, tipoMovimiento, cantidad, bodega)
                    VALUES(:nombreArticuloHistorial, :nombreEmpleadoHistorial, CURRENT_TIMESTAMP(), :tipoMovimientoHistorial, :cantidadHistorial, (select NombreBodega from tbl_bodega where IdBodega=:nombreBodegaHistorial))";

          $statement = $con->prepare($query);
          $statement->execute(array(
          ':nombreArticuloHistorial' => $nombreArticuloHistorial,
          ':nombreEmpleadoHistorial' => $nombreEmpleadoHistorial,
          ':tipoMovimientoHistorial' => $tipoMovimientoHistorial,
          ':cantidadHistorial' => $cantidadHistorial,
          ':nombreBodegaHistorial' => $nombreBodegaHistorial
          ));

          echo "<div class='alert alert-warning alert-dismissible'>Su registro <strong>ingresó</strong> con exito.</div>";
        }
    }

    // show errors
    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }
}
?>
 <h1 class="page-header alert alert-info">Actualizar Producto Codigo:  <?php echo htmlspecialchars($codigo, ENT_QUOTES);  ?></h1>
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
    <!--we have our html table here where the record will be displayed-->
    <form action="<?php //echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$idArticulo}");?>" method="POST">
        <input type="hidden" name="idArticulo" value="<?php echo htmlspecialchars($idArticulo, ENT_QUOTES);  ?>" >
        <input type="hidden" name="IdBodega" value="<?php echo htmlspecialchars($IdBodega, ENT_QUOTES);  ?>" >

        <!-- DATOS QUE SE USARÁN PARA INGRESARSE AL HISTORIAL DE ENTRADAS -->
        <input type="hidden" name="nombreEmpleadoHistorial" value="<?php echo $_SESSION['nombres'].' '.$_SESSION['apellidos'] ?>">

        <table class='table table-hover table-responsive table-bordered'>
            <tr>
                <td>Código</td>
                <td colspan="3"><input type="text" name="codigo" value="<?php echo htmlspecialchars($codigo, ENT_QUOTES);  ?>" class='form-control' disabled></td>
            </tr>
            <tr>
                <td>Nombre</td>
                <td colspan="3"><input type="text" name="nombreArticulo" value="<?php echo htmlspecialchars($nombreArticulo, ENT_QUOTES);  ?>" class='form-control'></td>
            </tr>
            <tr>
                <td>Descripción</td>
                <td colspan="3"><input type="textarea" name="descripcion" value="<?php echo htmlspecialchars($descripcion, ENT_QUOTES);  ?>" class='form-control'></td>
            </tr>
            <tr>
                <td>Cantidad a Ingresar:</td>
                <td><input type="number"  min="0" name="cantidad" id="cantidad" value="" class='form-control' placeholder="Ingrese Cantidad" required></td>

                <td align="right">Cantidad Actual:</td>
                <td><input type="text" name="cant" id="cant"  disabled value="<?php echo htmlspecialchars($cantidad1 = $cantidad1 + $cantidad, ENT_QUOTES);  ?>" class='form-control'></td>
            </tr>
            <tr>
                <td>Precio de compra</td>
                <td colspan="3"><input type="text" name="precioC" value="<?php echo htmlspecialchars($precioC, ENT_QUOTES);  ?>" class='form-control'></td>
            </tr>
            <tr>
                <td>Precio de venta</td>
                <td colspan="3"><input type="text" name="precioV" value="<?php echo htmlspecialchars($precioV, ENT_QUOTES);  ?>" class='form-control'></td>
            </tr>
            <tr>
                <td>Fecha de ingreso</td>
                <td colspan="3"><input type="text" name="fechaEntrada" value="<?php echo htmlspecialchars($fechaEntrada, ENT_QUOTES);  ?>" class='form-control'></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type='submit' value='Guardar cambios' onclick="clic()" class='btn btn-primary' />
                    <?php $Bodega = $_GET["Bdg"]; ?>
                    <a href='inventarioBodegas.php?bodega=<?php echo $Bodega; ?>' class='btn btn-danger'>Regresar a inventario</a>
                </td>
            </tr>
        </table>
    </form>

                </div>
            </div>
        <!-- /#page-wrapper -->

    </div>
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
