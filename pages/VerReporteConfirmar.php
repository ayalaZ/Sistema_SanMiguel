<?php
    session_start();
 ?>
<?php
    require("../php/reportsPDF.php");
    $reports = new Reports();
    $a=$_GET['v'];
    $showInventoryTranslateReport = $reports->getB($a);
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
            <form action="../php/ReporteConfirmar.php" method="POST">
      <br> <br>
            <table class="table table-striped" >
              <tr>
                  <td colspan="12" align="center"><img src="../images/Cablesat.png" HEIGHT="100" /></td>
              </tr>
              <tr>
                  <td colspan="12" HEIGHT="35" align="center" font >REPORTE DE TRASLADO DE PRODUCTOS</td>
              </tr>
              <?php
        $salir = false;
        foreach($showInventoryTranslateReport as $res)
          {
            ?>
             <tr>
                 <td COLSPAN="2" width="150" HEIGHT="20" >Nombre de Empleado:</td>
                 <td colspan="4" width="250"><?php echo $res["NombreEmpleadoOrigen"] ?> </td>
                 <td COLSPAN="2" width="100">C??digo Empleado:</td>
                 <td colspan="4" width="100"><?php echo $res["CodigoEmpleadoOrigen"] ?> </td>
              </tr>
                <tr>
                  <td COLSPAN="2" width="150" HEIGHT="20">Bodega Origen:</td>
                  <td colspan="4" width="250"><?php echo $res["BodegaOrigen"]?></td>
                  <input type="hidden" name="BodegaOrigen" value='<?php echo $res["BodegaOrigen"] ;?>'>
                  <td COLSPAN="2" width="100">Fecha y Hora De Env??o:</td>
                  <td colspan="4" width="100"><?php echo $res["FechaOrigen"]?></td>
              </tr>

               <tr>
                  <td COLSPAN="2" width="150" HEIGHT="20">Bodega Destino:</td>
                  <td colspan="4" width="250"><?php echo $res["BodegaDestino"]?> </td>
                    <input type="hidden" name="BodegaDestino" value='<?php echo $res["BodegaDestino"] ;?>'>
                  <td COLSPAN="2" width="100"></td>
                  <td colspan="4" width="100"></td>
              </tr>
              <tr>
                <td COLSPAN="12" width="630" HEIGHT="15" align="center">Comentario:</td>
           </tr>
           <tr>
                <td COLSPAN="12" width="600" HEIGHT="50" ><?php echo $res["Razon"] ?></td>
           </tr>
             <?php
           $salir = true;
            if($salir==true){  break; }
            }
            ?>
            </table>

             <table class="table table-striped">
              <tr>
                  <td colspan="12" HEIGHT="15" align="center" font >DESCRIPCION</td>
              </tr>
              <tr>
                  <td COLSPAN="2" width="100" HEIGHT="5" align="center">Codigo Producto</td>
                  <td colspan="4" width="410" HEIGHT="5" >Nombre Producto </td>
                  <td COLSPAN="6" width="100" HEIGHT="5" align="center" >Cantidad</td>
              </tr>
            <?php
                 $CodigoArticulo = array();
                 $CantidadArticulo = array();
            foreach( $showInventoryTranslateReport as $res)
            {
            ?>
                <tr>
                   <td COLSPAN="2" width="100" HEIGHT="10" align="center"><?php echo $res["CodigoArticulo"] ?></td>
                    <td colspan="4" width="410" ><?php echo $res["NombreArticulo"] ?></td>
                    <td COLSPAN="6" width="100" align="center"><?php echo $res["cantidad"] ?></td>
                </tr>
       <?php
                array_push($CodigoArticulo,$res["CodigoArticulo"]);
                array_push($CantidadArticulo,$res["cantidad"]);
            }
            ?>
                </table>
             <br/>


             <table class="table table-striped">
                 <?php

            foreach( $showInventoryTranslateReport as $res)
            {
            ?>
                    <!-- <tr>
                      <td COLSPAN="12" width="630" HEIGHT="15" align="center">Comentario:</td>
                 </tr>
                 <tr>
                      <td COLSPAN="12" width="630" HEIGHT="100" ><?php echo $res["Razon"] ?></td>
                 </tr> -->
            <?php
            break;
            }
            ?>
            </table>
                    <input type="hidden" name="CodigoArticulo" value='<?php echo serialize($CodigoArticulo);?>'>
                    <input type="hidden" name="CantidadArticulo" value='<?php echo serialize($CantidadArticulo);?>'>

                    <input type="hidden" name="NOMBRE" value='<?php echo $_SESSION['nombres']  ?>'>
                    <input type="hidden" name="APELLIDO" value='<?php echo $_SESSION['apellidos']  ?>'>

                    <a href="ReportesTraslados.php"><button class="btn btn-default" type="button" name="regresar"><i class="fas fa-arrow-circle-left"></i> Regresar</button></a>
                    <button type="submit" name="Action1" class="btn btn-primary">Confirmar Traslado</button>
                    <input type="hidden" name="IdReporte" value="<?php echo $a; ?>">
            </form>
        </div><!-- /.row -->
        <!-- /#page-wrapper -->

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
