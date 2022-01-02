<?php
require("../php/facturasGeneradas.php");
session_start();
if ($_SESSION['rol'] != "administracion") {
    header("Location:../php/logut.php");
}
$fac = new FacturasGeneradas();
$facArray = $fac->verFacturas();
?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Facturación generada</title>
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
        <link rel="stylesheet" href="js/menu.css">

        <!-- Morris Charts CSS -->
        <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    </head>
    <body style="background-color: #EEEEEE;">
        <div class="row-fluid">
            <div class="col-md-12">
                <div class="page-header">
                    <h1 class="text-center"><b>Facturación generada</b></h1>
                </div>
                <table id="facturacion" style="background-color:white; border:1px solid #BDBDBD" class="table table-responsive table-hover">
                    <thead>
                        <th>N° factura</th>
                        <th>Cód cliente</th>
                        <th>Cuota cable</th>
                        <th>Cuota internet</th>
                        <th>Fecha cobro</th>
                        <th>Fecha factura</th>
                        <th>Fecha vencimiento</th>
                        <th>Tipo servicio</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($facArray as $key) {
                            echo "<tr><td>";
                            echo "<span style='font-size:13px;' class='label label-info'>".$key['numeroFactura']."</span></td><td>";
                            echo "<span style='font-size:13px;' class='label label-primary'>".$key['codigoCliente']."</span></td><td>";
                            echo "$".$key['cuotaCable']."</td><td>";
                            echo "$".$key['cuotaInternet']."</td><td>";
                            echo $key['fechaCobro']."</td><td>";
                            echo $key['fechaFactura']."</td><td>";
                            echo $key['fechaVencimiento']."</td><td>";
                            if ($key['tipoServicio'] == 'C') {
                                echo "<span style='font-size:13px;' class='label label-primary'>".$key['tipoServicio']."</span></td><td>";
                            }else {
                                echo "<span style='font-size:13px;' class='label label-success'>".$key['tipoServicio']."</span></td><td>";
                            }
                            if ($key['anulada'] == 1) {
                                echo "<a class='btn btn-danger'>Anulada</a>"."</td></tr>";
                            }else {
                                echo "<a onclick='anularFactura( {$key['idFactura']} );' class='btn btn-warning'>Anular</a>"."</td></tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
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
        <!-- Page-Level Demo Scripts - Tables - Use for reference -->
        <script type='text/javascript'>
            // confirm record deletion
            function anularFactura(id){

                var answer = confirm('¿Está seguro de anular esta factura?');
                if (answer){
                    window.location = '../php/anularFactura.php?id=' + id;
                }
            }
        </script>
        <script>
            $(document).ready(function() {
                $('#facturacion').DataTable({
                    responsive: true,
                    "paging": true,
                    "language": {
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "zeroRecords": "No se encontró ningún registro",
                    "info": "Mostrando _TOTAL_ de _MAX_ Registros",
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
    </body>
</html>
