<?php
require("php/facturasGeneradas.php");
if(!isset($_SESSION))
{
    session_start([
        'cookie_lifetime' => 86400,
    ]);
}
if ($_SESSION['rol'] != "contabilidad" && $_SESSION["rol"] != "jefatura") {
    header("Location:../../../php/logut.php");
}

$tipoFactura = $_POST["tipoComprobanteGen"];
//$cobrador = $_POST["cobradorGen"];
//$diaCobro = $_POST["diaGen"];
$fechaGeneracion = $_POST["fechaGen"];
$tipoServicio = $_POST["tipoServicioGen"];

$fac = new FacturasGeneradas();
$facArray = $fac->verFacturas($tipoFactura, /*$cobrador, $diaCobro,*/ $fechaGeneracion, $tipoServicio);
?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Facturación generada</title>
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
                    <h1 class="text-center"><b>Facturación generada</b></h1>
                </div>
                <table id="facturacion" style="background-color:white; border:1px solid #BDBDBD" class="table table-responsive table-hover">
                    <thead>
                        <th>N° factura</th>
                        <th>Cód cliente</th>
                        <th>Cuota cable</th>
                        <th>Cuota internet</th>
                        <th>Mensualidad</th>
                        <th>Fecha cobro</th>
                        <th>Fecha factura</th>
                        <th>Fecha vencimiento</th>
                        <th>Tipo servicio</th>
                        <th>Estado</th>
                        <th>Situación</th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($facArray as $key) {
                            echo "<tr><td>";
                            echo "<span style='font-size:13px;' class='label label-info'>".$key['numeroFactura']."</span></td><td>";
                            echo "<span style='font-size:13px;' class='label label-primary'>".$key['codigoCliente']."</span></td><td>";
                            echo "$".$key['cuotaCable']."</td><td>";
                            echo "$".$key['cuotaInternet']."</td><td>";
                            echo "<span style='font-size:13px;' class='label label-success'>".$key['mesCargo']."</span></td><td>";
                            echo $key['fechaCobro']."</td><td>";
                            echo $key['fechaFactura']."</td><td>";
                            echo $key['fechaVencimiento']."</td><td>";
                            if ($key['tipoServicio'] == 'C') {
                                echo "<span style='font-size:13px;' class='label label-primary'>".$key['tipoServicio']."</span></td><td>";
                            }else {
                                echo "<span style='font-size:13px;' class='label label-success'>".$key['tipoServicio']."</span></td><td>";
                            }
                            if ($key['estado'] == 'CANCELADA') {
                                echo "<span style='font-size:13px;' class='label label-success'>".$key['estado']."</span></td><td>";
                            }else {
                                echo "<span style='font-size:13px;' class='label label-danger'>".strtoupper($key['estado'])."</span></td><td>";
                            }
                            if ($key['anulada'] == 1) {
                               echo "<span style='font-size:13px;' class='label label-danger'>".'Anulada'."</span></td></tr>";
                            }else {
                               echo "<span style='font-size:13px;' class='label label-success'>".'Sin anular'."</span></td></tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal VENTAS MANUALES -->
        <div id="anularFacturaf" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
              <div style="background-color: #1565C0; color:white;" class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Anulación de facturas</h4>
              </div>
              <form id="frmAnularFactura" action="php/anularFactura.php" method="POST" target="_blank">
              <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <label for="idPunto">Punto de venta</label>
                        <select class="form-control" type="text" id="idPunto" name="idPunto" required readonly>
                            <option value="1" selected>CABLESAT</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="tipoServicio">Tipo de servicio</label>
                        <input class="form-control" type="text" id="tipoServicio" name="tipoServicio" required readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label for="prefijo">prefijo</label>
                        <input class="form-control" type="text" id="prefijo" name="prefijo" required readonly>
                    </div>
                    <div class="col-md-5">
                        <label for="nFactura">Número de factura</label>
                        <input class="form-control" type="text" id="nFactura" name="nFactura" required readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="codigoCiente">Código de cliente</label>
                        <input class="form-control" type="text" id="codigoCliente" name="codigoCliente" required readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="aIva">Enviar a libro de IVA</label>
                        <input class="form-control pull-left" type="checkbox" id="aIva" name="aIva" value="1">
                    </div>
                    <div class="col-md-4">
                        <label for="mensu">Mensualidad</label>
                        <input class="form-control" type="text" id="mensu" name="mensu" value="" required readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="fechaComprobante">Fecha del comprobante</label>
                        <?php
                        if (isset($_SESSION["fecha"])) {
                            $fechaComprobante = $_SESSION["fecha"];
                        }else {
                            $fechaComprobante = "";
                        }
                        ?>
                        <input class="form-control" type="text" id="fechaComprobante" name="fechaComprobante" value="<?php $fechaComprobante ?>" required>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                  <div class="row">
                      <div class="col-md-6">
                          <input type="submit" class="btn btn-danger btn-md btn-block" name="submit" value="Anular factura">
                      </div>
                      <div class="col-md-6">
                          <button type="button" class="btn btn-default btn-md btn-block" data-dismiss="modal">Cancelar</button>
                      </div>
                  </div>
              </form>
              </div>
            </div>
          </div>
      </div><!-- Fin Modal VENTAS MANUALES -->
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

            function anularFactura(numeroFactura, codigoCliente, tipoServicio, mesCargo){

                var answer = confirm('¿Está seguro de anular esta factura?');
                if (answer){
                    //window.location = 'php/anularFactura.php?numeroFactura=' + numeroFactura+'&codigoCliente=' + codigoCliente+'&tipoServicio=' + tipoServicio+'&mesCargo=' + mesCargo;
                    window.open('php/anularFactura.php?numeroFactura=' + numeroFactura+'&codigoCliente=' + codigoCliente+'&tipoServicio=' + tipoServicio+'&mesCargo=' + mesCargo, '_blank');
                }
            }

            function anularFacturaModal(numeroFactura, codigoCliente, tipoServicio, mesCargo){
                document.getElementById("tipoServicio").value=tipoServicio;
                document.getElementById("prefijo").value=numeroFactura.substr(0,8);
                document.getElementById("nFactura").value=numeroFactura.substr(9,15);
                document.getElementById("codigoCliente").value=codigoCliente;
                document.getElementById("mensu").value=mesCargo;
            }
        </script>
        <script type='text/javascript'>

            function eliminarFactura(numeroFactura, codigoCliente, tipoServicio, mesCargo){

                var answer = confirm('¿Está seguro de ELIMINAR esta factura?');
                if (answer){
                    //window.location = 'php/eliminarFactura.php?numeroFactura=' + numeroFactura+'&codigoCliente=' + codigoCliente+'&tipoServicio=' + tipoServicio+'&mesCargo=' + mesCargo;
                    window.open('php/eliminarFactura.php?numeroFactura=' + numeroFactura+'&codigoCliente=' + codigoCliente+'&tipoServicio=' + tipoServicio+'&mesCargo=' + mesCargo, '_blank');
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
