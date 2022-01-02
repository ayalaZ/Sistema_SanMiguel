<?php
require("php/recibos.php");
session_start();
if ($_SESSION['rol'] != "administracion" && $_SESSION['rol'] != "jefatura" && $_SESSION['rol'] != "subgerencia" && $_SESSION['rol'] != "contabilidad" && $_SESSION['rol'] != "atencion") {
    header("Location:../../../php/logut.php");
}

$idAbono = $_GET["idAbono"];

$rec = new Recibos();
$recArray = $rec->verRecibo($idAbono);
?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Administrar abonos</title>
        <link rel="shortcut icon" href="../images/Cablesat.png" />
        <!-- Bootstrap Core CSS -->
        <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="../../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

        <!-- Font awesome CSS -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

        <!-- Custom CSS -->
        <link href="../../dist/css/sb-admin-2.css" rel="stylesheet">
        <link rel="stylesheet" href="../../dist/css/custom-principal.css">
        <link rel="stylesheet" href="../js/menu.css">

        <!-- Morris Charts CSS -->
        <link href="../../vendor/morrisjs/morris.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    </head>
    <body style="background-color: #EEEEEE;">
        <div class="row-fluid">
            <div class="col-md-12">
                <div class="page-header">
                    <h1 class="text-center"><b>Administración de abonos</b></h1>
                </div>
                <table id="facturacion" style="background-color:white; border:1px solid #BDBDBD" class="table table-responsive table-hover">
                    <thead>
                        <th>N° Recibo</th>
                        <th>Cód cliente</th>
                        <th>Cuota servicio</th>
                        <th>Mensualidad</th>
                        <th>Fecha cobro</th>
                        <th>Fecha factura</th>
                        <th>Fecha vencimiento</th>
                        <th>Fecha en que abonó</th>
                        <th>Tipo servicio</th>
                        <th>Usuario</th>                        
                        <th>Estado</th>
                        <th></th>
                        <th></th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($recArray as $key) {

                            echo "<tr><td>";
                            echo "<span style='font-size:13px;' class='label label-info'>".$key['numeroRecibo']."</span></td><td>";
                            echo "<span style='font-size:13px;' class='label label-primary'>".$key['codigoCliente']."</span></td><td>";
                           if ($key['tipoServicio'] == 'C') {
                                echo "$".(doubleval($key['cuotaCable'])+doubleval($key['totalImpuesto']))."</td><td>";
                            }elseif ($key['tipoServicio'] == 'I') {
                                echo "$".(doubleval($key['cuotaInternet'])+doubleval($key['totalImpuesto']))."</td><td>";
                            }
                            echo "<span style='font-size:13px;' class='label label-success'>".$key['mesCargo']."</span></td><td>";
                            echo $key['fechaCobro']."</td><td>";
                            echo $key['fechaFactura']."</td><td>";
                            echo $key['fechaVencimiento']."</td><td>";
                            echo $key['fechaAbonado']."</td><td>";
                            if ($key['tipoServicio'] == 'C') {
                                echo "<span style='font-size:13px;' class='label label-primary'>".$key['tipoServicio']."</span></td><td>";
                            }else {
                                echo "<span style='font-size:13px;' class='label label-success'>".$key['tipoServicio']."</span></td><td>";
                            }
                            echo $key['creadoPor']."</td><td>";
                            if ($key['estado'] == 'CANCELADA') {
                                echo "<span style='font-size:13px;' class='label label-success'>".$key['estado']."</span></td><td>";
                            }else {
                                echo "<span style='font-size:13px;' class='label label-danger'>".strtoupper($key['estado'])."</span></td><td>";
                            }
                            //////// solicitud de tipo de usuario
                            if ($_SESSION['rol'] != "administracion" && $_SESSION['rol'] != "jefatura" && $_SESSION['rol'] != "subgerencia") {
                                if ($key['anulada'] == 1) {
                              //  echo "<a class='btn btn-danger'>Anulada</a>"."</td><td>";
                                    echo "<span style='font-size:13px;' class='label label-success'>".'Anulada'."</span></td><td>";
                            }else {
                              //  echo "<a class='btn btn-danger'>Activa</a>"."</td><td>";
                                echo "<span style='font-size:13px;' class='label label-success'>".'Abonada'."</span></td><td>";
                            }
                        }else{///// para usuarios que podran anular
                            if ($key['anulada'] == 1) {
                                echo "<a class='btn btn-danger'>Anulada</a>"."</td><td>";
                            }else {
                                //echo "<a onclick=anularFactura('".$key['numeroFactura']."','".$key['codigoCliente']."','".$key['tipoServicio']."','".$key['mesCargo']."');"." class='btn btn-warning'>Anular</a>"."</td><td>";
                                echo "<a onclick=eliminarAbono('".$key['numeroFactura']."','".$key['numeroRecibo']."','".$key['codigoCliente']."','".$key['tipoServicio']."','".$key['mesCargo']."');"." class='btn btn-danger'><i class=\"fas fa-ban\"></i> Anular</a>"."</td><td>";
                            }
                            echo "<a onclick=eliminarAbonoTodo('".$key['numeroFactura']."','".$key['numeroRecibo']."','".$key['codigoCliente']."','".$key['tipoServicio']."','".$key['mesCargo']."');"." class='btn btn-danger'><i class=\"far fa-trash-alt\"></i> ELIMINAR</a>"."</td></tr>";
                            }
                            //////////////////////// finaliza estado de verificacion de tipo de usuario
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- jQuery -->
        <script src="../../vendor/jquery/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../../vendor/metisMenu/metisMenu.min.js"></script>

        <!-- DataTables JavaScript -->
        <script src="../../vendor/datatables/js/dataTables.bootstrap.js"></script>
        <script src="../../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../../vendor/datatables-responsive/dataTables.responsive.js"></script>
        <!-- Custom Theme JavaScript -->
        <script src="../../dist/js/sb-admin-2.js"></script>
        <!-- Page-Level Demo Scripts - Tables - Use for reference -->

        <script type='text/javascript'>

            function eliminarAbono(numeroFactura, numeroRecibo, codigoCliente, tipoServicio, mesCargo){

                var answer = confirm('¿Está seguro de ANULAR este abono?');
                if (answer){
                    //window.location = 'php/eliminarFactura.php?numeroFactura=' + numeroFactura+'&codigoCliente=' + codigoCliente+'&tipoServicio=' + tipoServicio+'&mesCargo=' + mesCargo;
                    window.open('php/eliminarAbono.php?numeroFactura=' + numeroFactura+'&numeroRecibo=' + numeroRecibo+'&codigoCliente=' + codigoCliente+'&tipoServicio=' + tipoServicio+'&mesCargo=' + mesCargo, '_blank');
                }
            }

            function eliminarAbonoTodo(numeroFactura, numeroRecibo, codigoCliente, tipoServicio, mesCargo){

                var answer = confirm('¿Está seguro de ELIMINAR este abono?');
                if (answer){
                    //window.location = 'php/eliminarFactura.php?numeroFactura=' + numeroFactura+'&codigoCliente=' + codigoCliente+'&tipoServicio=' + tipoServicio+'&mesCargo=' + mesCargo;
                    window.open('php/eliminarAbonoTodo.php?numeroFactura=' + numeroFactura+'&numeroRecibo=' + numeroRecibo+'&codigoCliente=' + codigoCliente+'&tipoServicio=' + tipoServicio+'&mesCargo=' + mesCargo, '_blank');
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
