<?php
    session_start();
    //require("../php/contenido.php");
    require("../php/getInventoryPDF.php");
    require("../php/productsInfo.php");

    $Bodega = $_GET["bodega"];

    // Trae el inventario completo de la base de datos
    $getInventory = new GetInventoryPDF();
    $recordsInfo = $getInventory->showInventoryRecords($Bodega);

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
                        <li><a href="config.php"><i class="fas fa-cog"></i> Configuraci??n</a>
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
            <div class='navbar-default sidebar' role='navigation'>
                <div class='sidebar-nav navbar-collapse'>
                    <ul class='nav' id='side-menu'>
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
                       <h1 class="page-header alert alert-info">Inventario de: <Strong>  <?php echo $Bodega ?></Strong></h1>
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
                                         Su registro <strong>fall??.</strong>
                                     </div>";
                           }
                           else if ($_GET['status'] == 'ConfirmacionExistente'){
                               echo "<div id='temporal' class='alert alert-danger alert-dismissible'>
                                         <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                         Ya Existente una Solicitud de Confirmacion en el departamento Seleccionado. Debe esperar
                                       que sea aceptada, De lo contrario no podra Asignar Articulos.
                                     </div>";
                           }
                       }
                       else {
                           echo "<div id='temporal'> </div>";
                       }
                       ?>
               </div>
               <!-- /.row -->
               <div class="row">
                   <form class="" action="resumenArticuloDepartamento.php" method="POST">
                     <a href="asignaciones.php"><button class="btn btn-success" type="button" name="regresar"><i class="fas fa-arrow-circle-left"></i> Atr??s</button></a>
                     <br>
                     <br>
                   <button id="traslados" type="submit" class="btn btn-default pull-left" disabled = "disabled" accesskey="t"><i class="fas fa-archway"></i> Asignar Articulo Seleccionado a un Departamento</button>

                   <br><br>

                       <table width="100%" class="table table-striped table-hover" id="inventario">
                           <thead>
                               <tr>
                                   <th></th>
                                   <th>C??digo</th>
                                   <th>Nombre</th>
                                   <th>Descripcion</th>
                                   <th>Tipo Producto</th>
                                   <th>Cantidad</th>
                                   <th>Categoria</th>
                                   <th>Proveedor</th>
                                   <!-- <th></th> -->
                               </tr>
                           </thead>
                           <tbody>
                               <?php
                                   foreach ($recordsInfo as $key) {
                                       echo "<tr><td>";
                                       echo "<input type='checkbox' class='form-control checkbox' name='checkTraslado[]' value='".$key['IdArticulo']."'>" . "</td><td>";

                                       echo $key["Codigo"] . "</td><td>";
                                       echo $key["NombreArticulo"] . "</td><td>";
                                       echo $key["Descripcion"] . "</td><td>";
                                       echo $key["NombreTipo"] . "</td><td>";
                                       echo $key["Cantidad"] . "</td><td>";
                                       echo $key["Categoria"] . "</td><td>";
                                       echo $key["Proveedor"] . "</td>";
                                       echo "</tr>";
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
            "lengthMenu": "Mostrar _MENU_ registros por p??gina",
            "zeroRecords": "No se encontr?? ning??n registro",
            "info": "Mostrando p??gina _PAGE_ de _PAGES_",
            "infoEmpty": "No se encontr?? ning??n registro",
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

    <script type='text/javascript'>
        // confirm record deletion
        function deleteArticle( id ){

            var answer = confirm('??Est?? seguro de borrar este registro?');
            if (answer){
                window.location = 'borrarArticulo.php?id=' + id;
            }
        }
    </script>
    <script type="text/javascript">
        function transferProduct(id) {
            window.location = "index.html?id="+id;
        }
    </script>

    <script type="text/javascript">
        $(function() {
            $(".checkbox").click(function(){
                $('#traslados').prop('disabled',$('input.checkbox:checked').length == 0);
            });
        });
    </script>

    <script type="text/javascript">
        var d = new Date();
        var month = String((parseInt(d.getMonth()+1)))
        document.getElementById("fecha").value = d.getDate()+"/"+month+"/"+d.getFullYear();
    </script>

</body>

</html>
