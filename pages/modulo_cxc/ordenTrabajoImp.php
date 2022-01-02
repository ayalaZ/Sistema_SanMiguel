<?php
require_once('../../php/connection.php');
require("php/getData.php");
$data = new OrdersInfo();
$precon = new ConectionDB($_SESSION['db']);
$con = $precon->ConectionDB($_SESSION['db']);
/**************************************************/
if (isset($_GET['nOrden'])) {

    // get passed parameter value, in this case, the record ID
    // isset() is a PHP function used to verify if a value is there or not
    $id=isset($_GET['nOrden']) ? $_GET['nOrden'] : die('ERROR: Record no encontrado.');

    // read current record's data
    try {
        // prepare select query
        $query = "SELECT * FROM tbl_ordenes_trabajo WHERE idOrdenTrabajo = ? LIMIT 0,1";
        $stmt = $con->prepare( $query );

        // this is the first question mark
        $stmt->bindParam(1, $id);

        // execute our query
        $stmt->execute();

        // store retrieved row to a variable
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        /****************** DATOS GENERALES ***********************/
        date_default_timezone_set('America/El_Salvador');
        $fechaOrdenTrabajo = $row["fechaOrdenTrabajo"];
        $idOrdenTrabajo = $row["idOrdenTrabajo"];
        $tipoOrden = $row["tipoOrdenTrabajo"];
        $diaCobro = $row["diaCobro"];
        $telefonos = $row["telefonos"];
        $codigoCliente = $row["codigoCliente"];
        $nombreCliente = $row['nombreCliente'];
        $idMunicipio = $row["idMunicipio"];
        $idActividadCable = $row["actividadCable"];
        $idActividadInter = $row["actividadInter"];
        $saldoCable = $row["saldoCable"];
        $saldoInter = $row["saldoInter"];
        $direccionCable = $row["direccionCable"];
        $direccionInter = $row["direccionInter"];
        $mactv = $row["mactv"];
        $macModem = $row['macModem'];
        $serieModem = $row['serieModem'];
        $rx = $row['rx'];
        $tx = $row['tx'];
        $snr = $row['snr'];
        $velocidad = $row['velocidad'];
        $colilla = $row['colilla'];
        $fechaTrabajo = $row['fechaOrdenTrabajo'];
        $hora = $row['hora'];
        $fechaProgramacion = $row['fechaProgramacion'];
        $idTecnico = $row['idTecnico'];
        $observaciones = $row['observaciones'];
        $nodo = $row['nodo'];
        $tecnologia = $row['tecnologia'];
        $observaciones = $row['observaciones'];
        $coordenadas = $row['coordenadas'];
        $marcaModelo = $row['marcaModelo'];
        $idVendedor = $row['idVendedor'];
        $recepcionTv = $row['recepcionTv'];
        $tipoServicio = $row['tipoServicio'];
        $creadoPor = strtoupper($row['creadoPor']);

    }
    // show error
    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Ordenes de trabajo</title>
        <link rel="shortcut icon" href="../../images/Cablesat.png" />
        <!-- Bootstrap Core CSS -->
        <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="../../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

        <!-- Font awesome CSS -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

        <!-- Custom CSS -->
        <link href="../../dist/css/sb-admin-2.css" rel="stylesheet">
        <link rel="stylesheet" href="../dist/css/custom-principal.css">
        <link rel="stylesheet" href="js/menu.css">

        <!-- Morris Charts CSS -->
        <link href="../../vendor/morrisjs/morris.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    </head>
    <body style="background-color: #FAFAFA; font-size:12px;">
        <div class="row-fluid">
            <div class="col-md-12">
                <div class="panel panel-danger">
                  <div class="panel-heading"><h4 style="padding:0; margin:0;" class="text-center"><b>Orden de trabajo</b></h4><h5 style="padding:0; margin:0;" class="text-center"><b><?php echo $nodo; ?></b></h5></div>
                  <div class="panel-body">
                      <?php
                      if (isset($_GET['nOrden'])) {
                          if ($tipoServicio == "I") {
                                echo"<div class='row'>
                                    <div class='col-md-6'>
                                        <h6 class='label label-danger pull-left' style='font-size:13px;' class='text-left'>N°{$idOrdenTrabajo}</h6>
                                    </div>
                                    <div class='col-md-6'>
                                        <h6 class='label label-danger pull-right' style='font-size:13px;' class='text-right'>Día de cobro {$diaCobro}</h6>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-3 col-xs-3'>
                                        <label for='fecha'>Fecha</label>
                                        <input class='form-control input-sm' type='text' name='fecha' value='{$fechaOrdenTrabajo}'>
                                    </div>
                                    <div class='col-md-2 col-xs-2'>
                                        <label for='fecha'>Código</label>
                                        <input class='form-control input-sm' type='text' name='codigo' value='{$codigoCliente}'>
                                    </div>
                                    <div class='col-md-7 col-xs-7'>
                                        <label for='nombre'>Nombre</label>
                                        <input class='form-control input-sm' type='text' name='nombre' value='{$nombreCliente}'>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-12 col-xs-12'>
                                        <label for='direccion'>Dirección</label>
                                        <input class='form-control input-sm' type='text' name='direccion' value='{$direccionInter}'>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-1 col-xs-1'>
                                        <label for='hora'>Hora</label>
                                        <input class='form-control input-sm' type='text' name='hora' value='{$hora}'>
                                    </div>
                                    <div class='col-md-3 col-xs-3'>
                                        <label for='telefono'>Teléfono</label>
                                        <input class='form-control input-sm' type='text' name='telefono' value='{$telefonos}'>
                                    </div>
                                    <div class='col-md-4 col-xs-4'>
                                        <label for='trabajo'>Trabajo a relizar</label>
                                        <input class='form-control input-sm' type='text' name='trabajo' value='{$idActividadInter}'>
                                    </div>
                                    <div class='col-md-4 col-xs-4'>
                                        <label for='tecnico'>Técnico</label>
                                        <input class='form-control input-sm' type='text' name='tecnico' value='{$data->getTecnicoById($idTecnico)}'>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-4 col-xs-4'>
                                        <label for='snr'>SNR</label>
                                        <input class='form-control input-sm' type='text' name='snr' value='{$snr}'>
                                    </div>
                                    <div class='col-md-4 col-xs-4'>
                                        <label for='tx'>TX</label>
                                        <input class='form-control input-sm' type='text' name='tx' value='{$tx}'>
                                    </div>
                                    <div class='col-md-4 col-xs-4'>
                                        <label for='rx'>RX</label>
                                        <input class='form-control input-sm' type='text' name='rx' value='{$rx}'>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-2 col-xs-2'>
                                        <label for='velocidad'>Velocidad</label>
                                        <input class='form-control input-sm' type='text' name='velocidad' value='{$data->getVelocidadById($velocidad)}'>
                                    </div>
                                    <div class='col-md-2 col-xs-2'>
                                        <label for='marca'>Marca/Modelo</label>
                                        <input class='form-control input-sm' type='text' name='marca' value='{$marcaModelo}'>
                                    </div>
                                    <div class='col-md-3 col-xs-3'>
                                        <label for='mac'>MAC</label>
                                        <input class='form-control input-sm' type='text' name='mac' value='{$macModem}'>
                                    </div>
                                    <div class='col-md-2 col-xs-2'>
                                        <label for='colilla'>Colilla</label>
                                        <input class='form-control input-sm' type='text' name='colilla' value='{$colilla}'>
                                    </div>
                                    <div class='col-md-3 col-xs-3'>
                                        <label for='tecnologia'>Tecnología</label>
                                        <input class='form-control input-sm' type='text' name='tecnologia' value='{$tecnologia}'>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-12 col-xs-12'>
                                        <label for='coordenadas'>coordenadas/otros datos</label>
                                        <input class='form-control input-sm' type='text' name='coordenadas' value='{$coordenadas}'>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-lg-12 col-xs-12'>
                                        <label for='observaciones'>Observaciones</label>
                                        <textarea class='form-control input-sm' name='observaciones' rows='2' cols='40'>{$observaciones}</textarea>
                                    </div>

                                </div>
                                <br>
                                <div class='row'>
                                    <div class='col-md-4 col-xs-4'>

                                        <input class='form-control input-sm alert-danger' type='text' name='cliente' value=''>
                                    </div>
                                    <div class='col-md-4 col-xs-4'>

                                        <input class='form-control input-sm alert-danger' type='text' name='tecnico' value=''>
                                    </div>
                                    <div class='col-md-4 col-xs-4'>

                                        <input class='form-control input-sm alert-danger' type='text' name='autorizacion' value=''>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-4 col-xs-4'>
                                        <label class='pull-center' for=''>CLIENTE</label>
                                    </div>
                                    <div class='col-md-4 col-xs-4'>
                                        <label for=''>TECNICO</label>
                                    </div>
                                    <div class='col-md-4 col-xs-4'>
                                        <label for=''>AUTORIZACION</label>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-4 col-xs-4'>
                                        <label style='border:dotted;' class='label label-danger' for=''>CREADO POR: {$creadoPor}</label>
                                    </div>
                                    <div class='col-md-4 col-xs-4'>

                                    </div>
                                    <div class='col-md-4 col-xs-4'>
                                        <label style='border:dotted; font-size:16px;' class='label label-info pull-right' for=''>{$tipoServicio}</label>
                                    </div>
                                </div>";
                          }
                          else if($tipoServicio == "C") {
                              echo"<div class='row'>
                                  <div class='col-md-6'>
                                      <h6 class='label label-danger pull-left' style='font-size:13px;' class='text-left'>{$idOrdenTrabajo}</h6>
                                  </div>
                                  <div class='col-md-6'>
                                      <h6 class='label label-danger pull-right' style='font-size:13px;' class='text-right'>Día de cobro {$diaCobro}</h6>
                                  </div>
                              </div>
                              <div class='row'>
                                  <div class='col-md-3 col-xs-3'>
                                      <label for='fecha'>Fecha</label>
                                      <input class='form-control input-sm' type='text' name='fecha' value='{$fechaOrdenTrabajo}'>
                                  </div>
                                  <div class='col-md-2 col-xs-2'>
                                      <label for='fecha'>Código</label>
                                      <input class='form-control input-sm' type='text' name='codigo' value='{$codigoCliente}'>
                                  </div>
                                  <div class='col-md-7 col-xs-7'>
                                      <label for='nombre'>Nombre</label>
                                      <input class='form-control input-sm' type='text' name='nombre' value='{$nombreCliente}'>
                                  </div>
                              </div>
                              <div class='row'>
                                  <div class='col-md-12 col-xs-12'>
                                      <label for='direccion'>Dirección</label>
                                      <textarea class='form-control input-sm' type='text' name='direccion' cols='40' rows='2'>{$direccionCable}</textarea>
                                  </div>
                              </div>
                              <div class='row'>
                                  <div class='col-md-2 col-xs-2'>
                                      <label for='hora'>Hora</label>
                                      <input class='form-control input-sm' type='text' name='hora' value='{$hora}'>
                                  </div>
                                  <div class='col-md-3 col-xs-3'>
                                      <label for='telefono'>Teléfono</label>
                                      <input class='form-control input-sm' type='text' name='telefono' value='{$telefonos}'>
                                  </div>
                                  <div class='col-md-3 col-xs-3'>
                                      <label for='trabajo'>Trabajo a relizar</label>
                                      <input class='form-control input-sm' type='text' name='trabajo' value='{$idActividadCable}'>
                                  </div>
                                  <div class='col-md-4 col-xs-4'>
                                      <label for='tecnico'>Técnico</label>
                                      <input class='form-control input-sm' type='text' name='tecnico' value='{$data->getTecnicoById($idTecnico)}'>
                                  </div>
                              </div>
                              <div class='row'>
                                  <div class='col-md-4 col-xs-4'>
                                      <label for='mactv'>MAC TV</label>
                                      <input class='form-control input-sm' type='text' name='mactv' value='{$mactv}'>
                                  </div>
                                  <div class='col-md-4 col-xs-4'>
                                      <label for='hora'>Colilla</label>
                                      <input class='form-control input-sm' type='text' name='colilla' value='{$colilla}'>
                                  </div>
                                  <div class='col-md-4 col-xs-4'>
                                      <label for='tecnologia'>Tecnología</label>
                                      <input class='form-control input-sm' type='text' name='tecnologia' value='{$tecnologia}'>
                                  </div>
                              </div>
                              <div class='row'>
                                  <div class='col-lg-12 col-xs-12'>
                                      <label for='observaciones'>Observaciones</label>
                                      <textarea class='form-control input-sm' name='observaciones' rows='2' cols='40'>{$observaciones}</textarea>
                                  </div>

                              </div>
                              <br>
                              <div class='row'>
                                  <div class='col-md-4 col-xs-4'>

                                      <input class='form-control input-sm alert-danger' type='text' name='cliente' value=''>
                                  </div>
                                  <div class='col-md-4 col-xs-4'>

                                      <input class='form-control input-sm alert-danger' type='text' name='tecnico' value=''>
                                  </div>
                                  <div class='col-md-4 col-xs-4'>

                                      <input class='form-control input-sm alert-danger' type='text' name='autorizacion' value=''>
                                  </div>
                              </div>
                              <div class='row'>
                                  <div class='col-md-4 col-xs-4'>
                                      <label class='pull-center' for=''>CLIENTE</label>
                                  </div>
                                  <div class='col-md-4 col-xs-4'>
                                      <label for=''>TECNICO</label>
                                  </div>
                                  <div class='col-md-4 col-xs-4'>
                                      <label for=''>AUTORIZACION</label>
                                  </div>
                              </div>
                              <div class='row'>
                                  <div class='col-md-4 col-xs-4'>
                                      <label style='border:dotted;' class='label label-danger' for=''>CREADO POR: {$creadoPor}</label>
                                  </div>
                                  <div class='col-md-4 col-xs-4'>

                                  </div>
                                  <div class='col-md-4 col-xs-4'>
                                      <label style='border:dotted;font-size:16px;' class='label label-info pull-right' for=''>{$tipoServicio}</label>
                                  </div>
                              </div>";
                          }
                      }
                      ?>
                  </div>
                </div>
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
    </body>
</html>
