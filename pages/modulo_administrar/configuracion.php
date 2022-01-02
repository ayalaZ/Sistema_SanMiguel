<?php
if(!isset($_SESSION))
{
    session_start([
        'cookie_lifetime' => 86400,
    ]);
}
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
                   <h1 class="page-header">Administrar</h1>
                   <div class="row">
                       <div class="row">
                           <div class="col-lg-6">
                               <a href="administrar.php"><button class="btn btn-success" type="button" name="regresar"><i class="fas fa-arrow-circle-left"></i> Atrás</button></a>
                           </div>
                           <br><br><br>
                       </div>
                           <a class="" href="empresaInfo.php"><div class="col-lg-12 btn btn-default">
                               <div class="stat-icon">
                                   <i class="fas fa-database fa-3x"></i>
                               </div>
                               <div class="stat-values">
                                   <br>
                                   <div class="name">datos de la empresa</b></div>
                               </div>
                           </div></a>
                         <a class="" href="configFacturas.php"><div class="col-lg-6 btn btn-default">
                             <div class="stat-icon">
                                 <i class="fas fa-file-invoice fa-3x"></i>
                             </div>
                             <div class="stat-values">
                                 <br>
                                 <div class="name">Facturación</b></div>
                             </div>
                         </div></a>
                         <a href=""><div class="col-lg-6 btn btn-default">
                             <div class="stat-icon">
                                <i class="fas fa-align-left fa-3x"></i>
                             </div>
                             <div class="stat-values">
                               <br>
                                 <div class="name">Por asignar</div>
                             </div>
                         </div></a>
                       <a class="" href="bodegas.php" ><div class="col-lg-6 btn btn-default">
                           <div class="stat-icon">
                               <i class="fas fa-project-diagram fa-3x"></i>
                           </div>
                           <div class="stat-values">
                               <br>
                               <div class="name">Bodegas</b></div>
                           </div>
                       </div></a>
                       <a href="proveedores.php"><div class="col-lg-6 btn btn-default">
                           <div class="stat-icon">
                               <i class="fas fa-dolly fa-3x"></i>
                           </div>
                           <div class="stat-values">
                               <br>
                               <div class="name" >Proveedores</b></div>
                           </div>
                       </div></a>
                   </div>
                   <div class="row">
                     <a class="" href="categorias.php"><div class="col-lg-6 btn btn-default">
                         <div class="stat-icon">
                             <i class="far fa-check-square fa-3x"></i>
                         </div>
                         <div class="stat-values">
                             <br>
                             <div class="name">Categorias</b></div>
                         </div>
                     </div></a>
                     <a href="tipoProductos.php"><div class="col-lg-6 btn btn-default">
                         <div class="stat-icon">
                            <i class="fas fa-align-left fa-3x"></i>
                         </div>
                         <div class="stat-values">
                           <br>
                             <div class="name">Tipo de Productos</div>
                         </div>
                     </div></a>
                   </div>
                   <div class="row">
                     <a class="" href="unidadMedidas.php"><div class="col-lg-6 btn btn-default">
                         <div class="stat-icon">
                             <i class="fas fa-ruler-combined fa-3x"></i>
                         </div>
                         <div class="stat-values">
                             <br>
                             <div class="name">Unidades de Medida</b></div>
                         </div>
                     </div></a>
                     <a class="" href="departamentos.php"><div class="col-lg-6 btn btn-default">
                         <div class="stat-icon">
                             <i class="fas fa-grip-vertical fa-3x"></i>
                         </div>
                         <div class="stat-values">
                             <br>
                             <div class="name">Departamentos de la Empresa</b></div>
                         </div>
                     </div></a>
                   </div>
                   <div class="row">
                     <a class="" href="impuestos.php"><div class="col-lg-6 btn btn-default">
                         <div class="stat-icon">
                             <i class="fas fa-percent fa-3x"></i>
                         </div>
                         <div class="stat-values">
                             <br>
                             <div class="name">Impuestos y porcentajes</b></div>
                         </div>
                     </div></a>
                     <a class="" href="plazas.php"><div class="col-lg-6 btn btn-default">
                         <div class="stat-icon">
                             <i class="fas fa-users fa-3x"></i>
                         </div>
                         <div class="stat-values">
                             <br>
                             <div class="name">Plazas</b></div>
                         </div>
                     </div></a>
                   </div>
                   <div class="row">
                     <a class="" href="afp.php"><div class="col-lg-6 btn btn-default">
                         <div class="stat-icon">
                             <i class="fas fa-money-check-alt fa-3x"></i>
                         </div>
                         <div class="stat-values">
                             <br>
                             <div class="name">AFP</b></div>
                         </div>
                     </div></a>
                     <a class="" href="bancos.php"><div class="col-lg-6 btn btn-default">
                         <div class="stat-icon">
                           <i class="fas fa-university fa-3x"></i>
                         </div>
                         <div class="stat-values">
                             <br>
                             <div class="name">Bancos</b></div>
                         </div>
                     </div></a>
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
