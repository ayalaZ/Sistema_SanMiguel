<?php
    session_start();

    require("../php/translateProcess.php");
    $tp = new TranslateProcess();
    $tpArray = $tp->getProductsTranslated();
    require("../php/productsInfo.php");
    // Métodos para traer la información de los productos
    $productsInfo = new ProductsInfo();
    $departaments = $productsInfo->getDepartments();

    //$Bodega=json_decode($_COOKIE['bdgSelec'], true);
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
                 <form class="" action="../php/saveDetailsAssign.php" method="POST">
                 <div class="row">
                     <div class="col-lg-12">
                         <h1 class="page-header">Resumen Asignación</h1>
                     </div>
                     <!-- /.col-lg-12 -->
                     <div class="row">
                       <center>  <div class="col-md-6">
                             <label for="bodegaOrigen">Departamento al cual se Asignará: </label>
                            <center> <select class="form-control" name="Departamento" required>
                                 <option value="" selected="selected" required>Seleccionar...</option>
                                 <?php
                                   foreach ($departaments as $key) {
                                       echo "<option value='".strtolower($key['NombreDepartamento'])."'>".$key['NombreDepartamento']."</option>";
                                   }
                                 ?>
                             </select></center>
                         </div></center>
                         <div class="col-lg-12">
                             <br>
                             <table class="table table-striped">
                                 <th>Id</th>
                                 <th>Artículo</th>
                                 <th>Bodega</th>
                                 <th>Existencias</th>
                                 <th>Cantidad a trasladar</th>
                                 <?php
                                 $Id = array();
                                 $Bodega ="";
                                     foreach ($tpArray as $article) {
                                         $i = 0;
                                         echo "<tr><td>";
                                         echo $article[$i]["IdArticulo"]. "</td><td>";
                                         echo $article[$i]["NombreArticulo"]. "</td><td>";
                                         echo $article[$i]["NombreBodega"]. "</td><td>";
                                         echo $article[$i]["Cantidad"]. "</td><td>";
                                         echo "<input type='number' min='0' max='".$article[$i]["Cantidad"] ."' class='form-control' name='articleToBeTraslated[]' value='' placeholder='Ingresar cantidad a trasladar' required>" . "</td><tr>";
                                         array_push($Id,$article[$i]["IdArticulo"]);
                                         $Bodega = $article[$i]["NombreBodega"];

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
                     <input type="hidden" name="Bodega" value='<?php echo $Bodega; ?>'>

                     <input type="hidden" name="NOMBRE" value='<?php echo $_SESSION['nombres'];  ?>'>
                     <input type="hidden" name="APELLIDO" value='<?php echo $_SESSION['apellidos'];  ?>'>

                     <input type="hidden" name="nombreEmpleadoHistorial" value="<?php echo $_SESSION['nombres'].' '.$_SESSION['apellidos'] ?>">

                     <h5><strong>Descripción o Comentario acerca de la Asignación:</strong></h5>
                     <textarea class="" name="Comentario" rows="5" cols="80" required></textarea><br>
                    <!-- <a href="AsignarArticuloDepartamento.php"><button class="btn btn-default" type="button" name="regresar"><i class="fas fa-arrow-circle-left"></i> Volver a inventario</button></a> -->
                     <button type="submit" name="Action2" class="btn btn-primary">Realizar traslado</button>
                     <form name="form" method="get">

                        <a href="asignarArticuloDepartamento.php?bodega=<?php echo $Bodega; ?>"><button class="btn btn-default" type="button" name="regresar"><i class="fas fa-arrow-circle-left"></i> Volver a inventario</button></a>

                     </form>
                 </div>

                 </form>
             </div>
             <!-- /.container-fluid -->
         </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
</body>
</html>
