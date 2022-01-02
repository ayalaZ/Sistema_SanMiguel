<?php
require '../../../pdfs/fpdf.php';
require_once("../../../php/config.php");
require '../../../numLe/src/NumerosEnLetras.php';
require_once('../../../php/connection.php');
if (!isset($_SESSION)) {
    session_start();
}
$host = DB_HOST;
$user = DB_USER;
$password = DB_PASSWORD;
$database = $_SESSION['db'];
$cobrador = $_POST["susCobrador"];
$servicio = $_POST["susServicio"];
$mysqli = new mysqli($host, $user, $password, $database);
$codigos = array();
if ($cobrador == "todos") {
    if ($servicio == 'C') {
        $query = "SELECT * FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND fechaVencimiento < now() AND tipoServicio='C' AND codigoCliente NOT IN (SELECT cod_Cliente FROM clientes WHERE servicio_suspendido='T' OR colilla NOT LIKE 'V%') group by `codigoCliente` HAVING COUNT(*) >= 2";
    } elseif ($servicio == 'I') {
        $query = "SELECT * FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND fechaVencimiento < now() AND tipoServicio='I' AND codigoCliente NOT IN (SELECT cod_Cliente FROM clientes WHERE servicio_suspendido='T' OR colilla NOT LIKE 'R%' OR estado_cliente_in = 2) group by `codigoCliente` HAVING COUNT(*) >= 2";
    } elseif ($servicio == 'P') {
        $query = "SELECT * FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND fechaVencimiento < now()  AND codigoCliente NOT IN (SELECT cod_Cliente FROM clientes WHERE servicio_suspendido='T' OR colilla NOT LIKE 'A%' OR estado_cliente_in = 2 OR sin_servicio='T' OR estado_cliente_in = 3) group by `codigoCliente` HAVING COUNT(*) >= 4";
    }
} else {
    if ($servicio == 'C') {
        $query = "SELECT * FROM tbl_cargos WHERE codigoCobrador='$cobrador' AND estado ='pendiente' AND anulada=0 AND fechaVencimiento < now() AND tipoServicio='C' AND codigoCliente NOT IN (SELECT cod_Cliente FROM clientes WHERE servicio_suspendido='T' OR colilla NOT LIKE 'V%') group by `codigoCliente` HAVING COUNT(*) >= 2";
    } elseif ($servicio == 'I') {
        $query = "SELECT * FROM tbl_cargos WHERE codigoCobrador='$cobrador' AND estado ='pendiente' AND anulada=0 AND fechaVencimiento < now() AND tipoServicio='I' AND codigoCliente NOT IN (SELECT cod_Cliente FROM clientes WHERE servicio_suspendido='T' OR colilla NOT LIKE 'R%' OR estado_cliente_in = 2) group by `codigoCliente` HAVING COUNT(*) >= 2";
    } elseif ($servicio == 'P') {
        $query = "SELECT * FROM tbl_cargos WHERE codigoCobrador='$cobrador' AND estado ='pendiente' AND anulada=0 AND fechaVencimiento < now()  AND codigoCliente NOT IN (SELECT cod_Cliente FROM clientes WHERE servicio_suspendido='T' OR colilla NOT LIKE 'A%' OR estado_cliente_in = 2 OR sin_servicio='T' OR estado_cliente_in = 3) group by `codigoCliente` HAVING COUNT(*) >= 4";
    }
}

if (isset($query)) {
    $resultado = $mysqli->query($query);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Suspensiones automáticas</title>
    <link rel="shortcut icon" href="../images/Cablesat.png" />
    <!-- Bootstrap Core CSS -->
    <link href="../../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="../../../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    <!-- Font awesome CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <!-- Custom CSS -->
    <link href="../../dist/css/sb-admin-2.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../dist/css/custom-principal.css">
    <link rel="stylesheet" href="../../js/menu.css">
    <!-- Morris Charts CSS -->
    <link href="../../vendor/morrisjs/morris.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>

<body style="background-color: #EEEEEE;">
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="page-header">
                <h1 class="text-center"><b>Suspensiones Automaticas</b></h1>
            </div>
            <a class="btn btn-danger pull-right" href="#" data-toggle="modal" data-target="#automaticas">Suspender</a>
            <table id="facturacion" style="background-color:white; border:1px solid #BDBDBD" class="table table-responsive table-hover">
                <thead>
                    <th>#</th>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Direccion</th>
                    <th>Vencimiento</th>
                    <th>Servicio</th>
                </thead>
                <tbody>
                    <?php
                    $contador = 1;
                    while ($row = $resultado->fetch_array()) {
                        array_push($codigos, $row['codigoCliente']);
                    ?>
                        <tr>
                            <td><?php echo $contador;
                                $contador++; ?></td>
                            <td><span style='font-size:13px;' class='label label-primary'><?php echo $row['codigoCliente'] ?></span></td>
                            <td><?php echo $row['nombre'] ?></td>
                            <td><?php echo $row['direccion'] ?></td>
                            <td><?php echo $row['fechaVencimiento'] ?></td>
                            <td><?php
                                if ($row['tipoServicio'] == 'C') {
                                    echo "<span style='font-size:13px;' class='label label-primary'>" . $row['tipoServicio'] . "</span></td></tr>";
                                } else {
                                    echo "<span style='font-size:13px;' class='label label-success'>" . $row['tipoServicio'] . "</span></td></tr>";
                                }
                                ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal automatica -->
    <div id="automaticas" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #b71c1c; color:white;" class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Suspensiones automáticas</h4>
                </div>
                <form id="frmAutomaticas" action="automaticas.php" method="POST" target="_blank">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="fechaElaborada">Fecha elaborada</label>
                                <input class="form-control" type="text" id="fechaElaborada" name="fechaElaborada" value="<?php echo date(" Y-m-d") ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="motivo">Motivo</label>
                                <select class="form-control" type="text" id="motivo" name="motivo" required>
                                    <option value="2" selected>Por mora de 2 meses</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="ordena">Ordena suspensión</label>
                                <select class="form-control" type="text" id="ordena" name="ordena" required>
                                    <option value="oficina" selected>Oficina</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="observaciones">Observaciones</label>
                                <input class="form-control" type="text" id="observaciones" name="observaciones">
                                <input class="form-control" type="hidden" id="serial" name="serial" value='<?php echo serialize($codigos)?>'>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="submit" class="btn btn-danger btn-md btn-block" name="submit" value="SUSPENDER TODOS">
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-md btn-block" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</body>
<!-- jQuery -->
<script src="../../../vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../../../vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="../../../vendor/metisMenu/metisMenu.min.js"></script>

<!-- DataTables JavaScript -->
<script src="../../../vendor/datatables/js/dataTables.bootstrap.js"></script>
<script src="../../../vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="../../../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="../../../vendor/datatables-responsive/dataTables.responsive.js"></script>
<!-- Custom Theme JavaScript -->
<script src="../../dist/js/sb-admin-2.js"></script>
<!-- Page-Level Demo Scripts - Tables - Use for reference -->

<script>
    $(document).ready(function() {
        $("#facturacion").DataTable({
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

</html>