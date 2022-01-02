<?php
    require("../php/ReportsInfo.php");

    // Trae el inventario completo de la base de datos

    $reportsInfo = new ReportsInfo();
    $recordsInfo = $reportsInfo->ReportesFinales();


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
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Diego Herrera
                        <i class="far fa-user"></i> <i class="fas fa-caret-down"></i>
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
                            <a href="index.html"><i class="fas fa-home"></i> Principal</a>
                        </li>
                        <li>
                            <a class="" href="infoCliente.php"><i class="fas fa-users"></i> Clientes</a>
                        </li>
                        <li>
                            <a href="inventario.php"><i class="fas fa-scroll"></i> Inventario</a>
                        </li>
                        <li>
                            <a class="active" href="ReportesTraslados.php"><i class="fas fa-scroll"></i> Reportes de Traslados</a>
                        </li>
                        <li>
                            <a href="planillas.php"><i class="fas fa-file-signature"></i></i> Planillas</a>
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
                    <h1 class="page-header alert alert-info">Reportes de Traslado</h1>
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
            <!-- /.row -->
            <div class="row">
                <form class="" action="resumenTraslado.php" method="post">

                <div class="col-lg-12 estadistics">
                    <table width="100%" class="table table-striped table-hover" id="inventario">
                        <thead>
                            <tr>
                          
                                <th>Código</th>
                                  <th>Empleado</th>
                                <th>Fecha</th>
                               <th>Razon</th>
                                <th> Ver</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($recordsInfo as $key) {
                                    echo "<tr><td>";
                                    echo $key["IdReporte"] . "</td><td>";
                                    echo $key["NombreEmpleado"] . "</td><td>";
                                    echo $key["Fecha"] . "</td><td>";
                                    echo $key["Razon"] . "</td><td>";    
                                    echo "</td><td><a href='../php/GenerarPDF.php?v=".$key["IdReporte"] ."' target='_blank'>Ver Documento PDF</a></td>";
                    
                                        }
                                    ?>
                        </tbody>
                    </table>
                    </form>
                </div>
                <!-- /.col-lg-12 -->
            </div>
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
