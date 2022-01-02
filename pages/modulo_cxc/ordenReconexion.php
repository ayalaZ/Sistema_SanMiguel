<?php

if(!isset($_SESSION))
{
    session_start([
        'cookie_lifetime' => 86400,
    ]);
}
    require("php/getData.php");
    require("php/GetAllInfo.php");
    require($_SERVER['DOCUMENT_ROOT'].'/satpro'.'/php/permissions.php');
    $permisos = new Permissions();
    $permisosUsuario = $permisos->getPermissions($_SESSION['id_usuario']);
    $dataInfo = new GetAllInfo();
    $arrMunicipios = $dataInfo->getData('tbl_municipios_cxc');
    $data = new OrdersInfo();
    //$client = new GetClient();
    $arrayTecnicos = $data->getTecnicos();
    $arrayActividadesSusp = $data->getActividadesSusp();
    $arrayVelocidades = $data->getVelocidades();

    //include database connection
    require_once('../../php/connection.php');
    $precon = new ConectionDB($_SESSION['db']);
    $con = $precon->ConectionDB($_SESSION['db']);
    /**************************************************/
    if (isset($_GET['codigoCliente'])) {

        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id=isset($_GET['codigoCliente']) ? $_GET['codigoCliente'] : die('ERROR: Record no encontrado.');

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT cod_cliente, nombre, telefonos, direccion, saldoCable, mactv, saldoInternet, id_municipio, saldo_actual, telefonos, dire_cable, dia_cobro, dire_internet, mactv, fecha_suspencion, fecha_suspencion_in, mac_modem, serie_modem, id_velocidad, recep_modem, trans_modem, ruido_modem, colilla, marca_modem, tecnologia, coordenadas FROM clientes WHERE cod_cliente = ? LIMIT 0,1";
            $stmt = $con->prepare( $query );

            // this is the first question mark
            $stmt->bindParam(1, $id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            /****************** DATOS GENERALES ***********************/
            date_default_timezone_set('America/El_Salvador');
            $fechaOrden = date_format(date_create(date('Y-m-d')), 'd/m/Y');
            $idOrdenReconex = "";
            $tipoOrden = "Reconexion";
            $diaCobro = $row["dia_cobro"];
            //$ordenaSuspensionCable = "";
            //$ordenaSuspensionInter = "";

            $codigoCliente = $row["cod_cliente"];
            $nombreCliente = $row['nombre'];
            $direccion = $row["direccion"];
            $telefonos = $row["telefonos"];
            //$idMunicipio = $row["id_municipio"];
            $saldoCable = $row["saldoCable"];
            if (strlen($row["fecha_suspencion"]) < 10) {
                $ultSuspCable = "";
            }else {
                $ultSuspCable = date_format(date_create($row["fecha_suspencion"]), 'd/m/Y');
            }

            if (strlen($row["fecha_suspencion_in"]) < 10) {
                $ultSuspInter = "";
            }else {
                $ultSuspInter = date_format(date_create($row["fecha_suspencion_in"]), 'd/m/Y');
            }

            $mactv = $row["mactv"];
            $saldoInter = $row["saldoInternet"];
            $macModem = $row['mac_modem'];
            $serieModem = $row['serie_modem'];
            $idVelocidad = $row['id_velocidad'];
            $rx = $row['recep_modem'];
            $tx = $row['trans_modem'];
            $snr = $row['ruido_modem'];
            $velocidad = $row['id_velocidad'];
            $colilla = $row['colilla'];
            $marcaModelo = $row['marca_modem'];
            $tecnologia = $row['tecnologia'];
            $fechaReconexCable = "";
            $fechaReconexInter = "";
            $hora = "";
            $fechaProgramacion = "";
            $coordenadas = $row['coordenadas'];
            $observaciones = "";
            $nodo = "";
            $idVendedor = "";
            $recepcionTv = "";
          

        }

        // show error
        catch(PDOException $exception){
            die('ERROR: ' . $exception->getMessage());
        }
    }else if(isset($_GET['nOrden'])){
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id=isset($_GET['nOrden']) ? $_GET['nOrden'] : die('ERROR: Record no encontrado.');

        // read current record's data
        try {
            // prepare select query

            $query = "SELECT idOrdenReconex, codigoCliente, fechaOrden, tipoOrden, tipoReconexCable, tipoReconexInter, diaCobro, telefonos, nombreCliente, direccion, fechaReconexCable, saldoCable, fechaReconexInter, saldoInter, ultSuspCable, ultSuspInter, macModem, serieModem, velocidad, colilla, fechaReconex, idTecnico, mactv, observaciones, tipoServicio,coordenadas, creadoPor, servRecox  FROM tbl_ordenes_reconexion WHERE idOrdenReconex = ? LIMIT 0,1";

            $query = "SELECT idOrdenReconex, codigoCliente, fechaOrden, tipoOrden, tipoReconexCable, tipoReconexInter, diaCobro, telefonos, nombreCliente, direccion, fechaReconexCable, saldoCable, fechaReconexInter, saldoInter, ultSuspCable, ultSuspInter, macModem, serieModem, velocidad, colilla, fechaReconex, idTecnico, mactv, observaciones, tipoServicio,coordenadas, creadoPor  FROM tbl_ordenes_reconexion WHERE idOrdenReconex = ? LIMIT 0,1";

            $stmt = $con->prepare( $query );

            // this is the first question mark
            $stmt->bindParam(1, $id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            /****************** DATOS GENERALES ***********************/
            $idOrdenReconex = $row["idOrdenReconex"];
            $fechaOrden = date_format(date_create($row["fechaOrden"]), 'd/m/Y');
            $tipoOrden = $row["tipoOrden"];
            $tipoReconexCable = $row["tipoReconexCable"];
            $tipoReconexInter = $row["tipoReconexInter"];
            $diaCobro = $row["diaCobro"];
            $codigoCliente = $row["codigoCliente"];
            if ($codigoCliente === "00000") {
                $codigoCliente = "SC";
            }
            $nombreCliente = $row['nombreCliente'];
            $telefonos = $row["telefonos"];
            //$idMunicipio = $row["idMunicipio"];
            if (empty($row["ultSuspCable"])) {
                $ultSuspCable = "";
            }else {
                $ultSuspCable = date_format(date_create($row["ultSuspCable"]), 'd/m/Y');
            }

            $saldoCable = $row["saldoCable"];
            $direccion = $row["direccion"];
            $saldoInter = $row["saldoInter"];
            if (empty($row["ultSuspInter"])) {
                $ultSuspInter = "";
            }else {
                $ultSuspInter = date_format(date_create($row["ultSuspInter"]), 'd/m/Y');
            }
            $macModem = $row['macModem'];
            $serieModem = $row['serieModem'];
            $velocidad = $row['velocidad'];
            $colilla = $row['colilla'];
            if (empty($row["fechaReconexCable"])) {
                $fechaReconexCable = "";
            }else {
                $fechaReconexCable = date_format(date_create($row["fechaReconexCable"]), 'd/m/Y');
            }

            if (empty($row["fechaReconexInter"])) {
                $fechaReconexInter = "";
            }else {
                $fechaReconexInter = date_format(date_create($row["fechaReconexInter"]), 'd/m/Y');
            }

            //$hora = $row['hora'];
            $idTecnico = $row['idTecnico'];
            $mactv = $row['mactv'];
            $observaciones = $row['observaciones'];
            $coordenadas = $row['coordenadas'];
            //$nodo = $row['nodo'];
            $tipoServicio = $row['tipoServicio'];
            $creadoPor = $row['creadoPor'];
            
            //creadoPor
        }
        catch(PDOException $exception){
            die('ERROR: ' . $exception->getMessage());
        }
    }else {
        $fechaOrden = "";
        $idOrdenReconex = "";
        $codigoCliente = "";
        $nombreCliente = "";
        $diaCobro = "";
        $telefonos = "";
        //$idMunicipio = "";
        $saldoCable = "";
        $direccion = "";
        $saldoCable = "";
        $saldoInter = "";
        $mactv = "";
        $macModem = "";
        $serieModem = "";
        $velocidad = "";
        $colilla = "";
        $ultSuspCable = "";
        $ultSuspInter = "";
        $tipoReconexCable = "";
        $tipoReconexInter = "";
        $fechaReconexCable = "";
        $fechaReconexInter = "";
        //$hora="";
        $observaciones="";
        $coordenadas="";
        

        //$tipoServicio = "";
        //$creadoPor = "";
        //$nodo="";
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
<link rel="shortcut icon" href="../../images/cablesat.png" />
    <!-- Bootstrap Core CSS -->
    <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Font awesome CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

    <!-- Custom CSS -->

    <link rel="stylesheet" href="../../dist/css/custom-principal.css">

    <!-- Morris Charts CSS -->
    <link href="../../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <style media="screen">
        .form-control {
            color: #212121;
            font-size: 15px;
            font-weight: bold;

        }
        .nav>li>a {
            color: #fff;
        }
        .dark{
            color: #fff;
            background-color: #212121;
        }
    </style>

    <style media="screen">
        .nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover {
            color: #fff;
            background-color: #d32f2f;
        }

        .nav-pills>li>a{
            color: #d32f2f;

        }

        .btn-danger {
            color: #fff;
            background-color: #d32f2f;
            border-color: #d43f3a;
        }
        .label-danger {
            background-color: #d32f2f;
        }

        .panel-danger>.panel-heading {
            color: #fff;
            background-color: #212121;
            border-color: #212121;
        }
        .panel{
            border-color: #212121;
        }

    </style>
</head>

<body>

    <?php
         // session_start();
         if(!isset($_SESSION["user"])) {
             header('Location: ../login.php');
         }
     ?>
    <div id="wrapper">

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="panel panel-danger">
                          <div class="panel-heading"><b>Orden de Reconexión</b> <span id="nombreOrden" class="label label-danger"></span></div>
                          <form id="ordenReconexion" action="" method="POST">
                          <div class="panel-body">
                              <div class="col-md-12">
                                  <button class="btn btn-default btn-sm" id="nuevaOrdenId" onclick="nuevaOrden()" type="button" name="btn_nuevo" data-toggle="tooltip" data-placement="bottom" title="Nueva orden"><i class="far fa-file"></i></button>
                                  <button class="btn btn-default btn-sm" id="editar" onclick="editarOrden()" type="button" name="btn_nuevo" data-toggle="tooltip" data-placement="bottom" title="Editar orden"><i class="far fa-edit"></i></button>
                                  <button class="btn btn-default btn-sm" type="button" name="btn_nuevo" data-toggle="tooltip" data-placement="bottom" title="Ver cliente"><i class="far fa-eye"></i></button>
                                  <button class="btn btn-default btn-sm" type="button" id="guardar" name="btn_nuevo" onclick="guardarOrden()" data-toggle="tooltip" data-placement="bottom" title="Guardar orden" disabled><i class="far fa-save"></i></button>
                                  <?php echo '<input style="display: none;" type="submit" id="guardar2" value="">'; ?>
                                  <button class="btn btn-default btn-sm" type="button" name="btn_nuevo" data-placement="bottom" title="Buscar orden" data-toggle="modal" data-target="#buscarOrden"><i class="fas fa-search"></i></button>
                                  <button class="btn btn-default btn-sm" id="imprimir" onclick="imprimirOrden()" type="button" name="btn_nuevo" data-toggle="tooltip" data-placement="bottom" title="Imprimir orden" ><i class="fas fa-print"></i></button>

                                  <button class="btn btn-danger input-sm" type="button" id="btn-reconexion" name="btn_nuevo" onclick="reactServicio()" data-toggle="tooltip" data-placement="bottom" title="Para Activar llenar fecha reconexión primero" disabled><i class="fas fa-file-alt"></i></button>





                                  <div class="pull-right">

                                      <button class="btn btn-default btn-sm" onclick="estadoCuenta();" type="button" name="btn_nuevo" data-toggle="tooltip" data-placement="bottom" title="Estado de cuenta"><i class="far fa-file-alt"></i></button>
                                      <button id="btn-cable" class="btn btn-default btn-sm" onclick="ordenCable()" type="button" name="btn_nuevo" data-toggle="tooltip" data-placement="bottom" title="Orden de cable" disabled><i class="fas fa-tv"></i></button>
                                      <button id="btn-internet" class="btn btn-default btn-sm" onclick="ordenInternet()" type="button" name="btn_nuevo" data-toggle="tooltip" data-placement="bottom" title="Orden de internet" disabled><i class="fas fa-wifi"></i></button>
                                  </div>
                              </div>
                              <div class="form-row">
                                  <div class="col-md-2">

                                      <?php
                                      if (isset($_GET['nOrden'])) {
                                         echo "<input id='creadoPor' class='form-control input-sm' type='hidden' name='creadoPor' value='{$creadoPor}'>";
                                         echo "<input id='tipoServicio' class='form-control input-sm' type='hidden' name='tipoServicio' value='{$tipoServicio}' readonly>";
                                      }
                                      else{
                                         echo '<input id="creadoPor" class="form-control input-sm" type="hidden" name="creadoPor" value="'.$_SESSION['nombres'] . " " . $_SESSION['apellidos'].'"' . '>';
                                         echo '<input id="tipoServicio" class="form-control input-sm" type="hidden" name="tipoServicio" value="" readonly>';
                                      }
                                      ?>
                                      <label for="numeroReconexion  ">N° de reconexión</label>
                                      <input id="numeroReconexion" class="form-control input-sm" type="text" name="numeroReconexion" value="<?php echo $idOrdenReconex; ?>" readonly>
                                  </div>
                                  <div class="col-md-2">

                                      <label for="fechaElaborada">Fecha elaborada</label>
                                      <input id="fechaOrden" class="form-control input-sm" type="text" name="fechaOrden" value="<?php echo $fechaOrden; ?>" readonly>
                                  </div>
                                  <div class="col-md-2">

                                      <label for="codigoCliente">Código del cliente</label>
                                      <input id="codigoCliente" class="form-control input-sm" type="text" name="codigoCliente" value="<?php echo $codigoCliente; ?>" readonly>
                                  </div>
                                  <div class="col-md-5">

                                      <label for="nombreCliente">Nombre del cliente</label>
                                      <input id="nombreCliente" class="form-control input-sm" type="text" name="nombreCliente" value="<?php echo $nombreCliente; ?>" readonly>
                                  </div>
                                  <div class="col-md-1">

                                      <label for="diaCobro">Día c</label>
                                      <input class="form-control input-sm" type="text" name="diaCobro" value="<?php echo $diaCobro; ?>" readonly>
                                  </div>
                              </div>
                              <div class="form-row">
                                  <div class="col-md-6 col-xs-6">
                                      <label for="telefonos">Telefonos</label>
                                      <input id="telefonos" class="form-control input-sm" type="text" name="telefonos" value="<?php echo $telefonos; ?>" readonly>
                                  </div>
                                  <div class="col-md-6 col-xs-6">
                                      <label for="coordenadas">coordenadas</label>
                                      <input id="coordenadas" class="form-control input-sm" type="text" name="coordenadas" value="<?php echo $coordenadas; ?>" readonly>
                                  </div>
                              </div>
                              <div class="form-row">
                                  <div class="col-md-12">
                                      <label for="direccionCliente">Dirección</label>
                                      <textarea class="form-control input-sm" name="direccionCliente" rows="2" cols="40" readonly><?php echo $direccion; ?></textarea>
                                  </div>
                              </div>
                              <div class="form-row">
                                  <div id="divCable" class="col-md-12">
                                      <h4 class="alert btn-danger cable">Cable</h4>
                                      <div class="row">
                                          <div class="col-md-2">
                                              <label for="fechaReconexCable">Fecha reconexión</label>
                                              <input id="fechaReconexCable" class="form-control input-sm cable" type="text" name="fechaReconexCable" value="<?php echo $fechaReconexCable ?>" readonly>
                                          </div>
                                          <div class="col-md-2">
                                              <label for="ultSusp">última suspensión</label>
                                              <input id="ultSuspCable" class="form-control input-sm cable" type="text" name="ultSuspCable" value="<?php echo $ultSuspCable ?>" readonly>
                                          </div>
                                          <div class="col-md-3">
                                              <label for="mactv">MAC TV</label>
                                              <input id="mactv" class="form-control input-sm cable" type="text" name="mactv" value="<?php echo $mactv ?>" readonly>
                                          </div>
                                          <div class="col-md-2">
                                              <label for="saldoCable">Saldo</label>
                                              <input id="saldoCable" class="form-control input-sm cable" type="text" name="saldoCable" value="<?php echo $saldoCable ?>" readonly>
                                          </div>
                                          <div class="col-md-3">
                                              <label for="tipoReconexCable">Tipo de reconexión</label>
                                              <select id="tipoReconexCable" class="form-control input-sm cable" name="tipoReconexCable" disabled>
                                                  <option value="" selected>Seleccionar</option>
                                                  <?php
                                                  if ($tipoReconexCable == 'con contrato') {
                                                      echo '<option value="con contrato" selected>Con contrato</option>';
                                                      echo '<option value="menor a 5 dias">Reconexión menor a 5 días</option>';
                                                  }else if ($tipoReconexCable == 'menor a 5 dias') {
                                                      echo '<option value="con contrato">Con contrato</option>';
                                                      echo '<option value="menor a 5 dias" selected>Reconexión menor a 5 días</option>';
                                                  }else {
                                                      echo '<option value="con contrato">Con contrato</option>';
                                                      echo '<option value="menor a 5 dias">Reconexión menor a 5 días</option>';
                                                  }
                                                  ?>
                                              </select>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-md-12">
                                      <h4 class="alert btn-danger">Internet</h4>
                                      <div class="row">
                                          <div class="col-md-2">
                                              <label for="fechaReconexInter">Fecha reconexión</label>
                                              <input id="fechaReconexInter" class="form-control input-sm internet" type="text" name="fechaReconexInter" value="<?php echo $fechaReconexInter ?>" readonly>
                                          </div>
                                          <div class="col-md-2">
                                              <label for="ultSusp">última suspensión</label>
                                              <input id="ultSuspInter" class="form-control input-sm internet" type="text" name="ultSuspInter" value="<?php echo $ultSuspInter ?>" readonly>
                                          </div>
                                          <div class="col-md-4">
                                              <label for="saldoInternet">Saldo</label>
                                              <input id="saldoInternet" class="form-control input-sm internet" type="text" name="saldoInternet" value="<?php echo $saldoInter ?>" readonly>
                                          </div>
                                          <div class="col-md-4">
                                              <label for="tipoReconexInter">Tipo de reconexión</label>
                                              <select id="tipoReconexInter" class="form-control input-sm internet" name="tipoReconexInter" disabled>
                                                  <option value="" selected>Seleccionar</option>
                                                  <?php
                                                  if ($tipoReconexInter == 'con contrato') {
                                                      echo '<option value="con contrato" selected>Con contrato</option>';
                                                      echo '<option value="menor a 5 dias">Reconexión menor a 5 días</option>';
                                                  }else if ($tipoReconexInter == 'menor a 5 dias') {
                                                      echo '<option value="con contrato">Con contrato</option>';
                                                      echo '<option value="menor a 5 dias" selected>Reconexión menor a 5 días</option>';
                                                  }else {
                                                      echo '<option value="con contrato">Con contrato</option>';
                                                      echo '<option value="menor a 5 dias">Reconexión menor a 5 días</option>';
                                                  }
                                                  ?>
                                              </select>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="form-row">
                                  <div class="col-md-4">
                                      <label for="macModem">MAC del modem</label>
                                      <input id="macModem" class="form-control input-sm internet" type="text" name="macModem" value="<?php echo $macModem ?>" readonly>
                                  </div>
                                  <div class="col-md-4">
                                      <label for="serieModem">Serie del modem</label>
                                      <input id="serieModem" class="form-control input-sm internet" type="text" name="serieModem" value="<?php echo $serieModem ?>" readonly>
                                  </div>
                                  <div class="col-md-4">
                                      <label for="velocidad">Velocidad</label>
                                      <select id="velocidad" class="form-control input-sm internet" name="velocidad" disabled>
                                          <option value="" selected>Seleccionar</option>
                                          <?php
                                          foreach ($arrayVelocidades as $key) {
                                              if ($key['idVelocidad'] == $velocidad) {
                                                  echo "<option value=".$key['idVelocidad']." selected>".strtoupper($key['nombreVelocidad'])."</option>";
                                              }else {
                                                  echo "<option value=".$key['idVelocidad'].">".strtoupper($key['nombreVelocidad'])."</option>";
                                              }

                                          }
                                          ?>
                                      </select>

                                  </div>

                              </div>
                              <div class="form-row">
                                  <div class="col-md-8">
                                      <label for="tecnico">Técnico</label>
                                      <select class="form-control input-sm" name="responsable" disabled required>
                                          <option value="" selected>Seleccionar</option>
                                          <?php
                                          foreach ($arrayTecnicos as $key) {
                                              if ($key['idTecnico'] == $idTecnico) {
                                                  echo "<option value=".$key['idTecnico']." selected>".strtoupper($key['nombreTecnico'])."</option>";
                                              }else{
                                                  echo "<option value=".$key['idTecnico'].">".strtoupper($key['nombreTecnico'])."</option>";
                                              }

                                          }
                                          ?>
                                      </select>
                                  </div>
                                  <div class="col-md-4">
                                      <label for="colilla">Colilla</label>
                                      <input id="colilla" class="form-control input-sm" type="text" name="colilla" value="<?php echo $colilla; ?>" readonly>
                                  </div>
                              </div>
                              <div class="form-row">
                                  <div class="col-md-12">
                                      <label for="observaciones">Observaciones</label>
                                      <textarea class="form-control input-sm" name="observaciones" rows="2" cols="40" readonly><?php echo $observaciones; ?></textarea>
                                  </div>
                              </div>
                          </div>
                          </form>
                        </div>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
        <!-- Modal -->
        <div id="buscarOrden" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Buscar orden de suspensión</h4>
              </div>
              <div class="modal-body">
                  <div class="row">
                      <div class="col-md-12">
                          <input class="form-control" type="text" name="caja_busqueda" id="caja_busqueda" placeholder="N°Reconexión, Fecha orden, Código cliente, Nombre cliente, Dirección, Observaciones, Mac, Serial">
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12">
                          <div id="datos">

                          </div>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              </div>
            </div>

          </div>
        </div>
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../vendor/metisMenu/metisMenu.min.js"></script>

    <script src="../../vendor/jQuery-Mask-Plugin-master/dist/jquery.mask.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>
    <script src="js/ordenReconexion.js"></script>
    <script src="js/searchor.js"></script>
    <script type="text/javascript">
        var permisos = '<?php echo $permisosUsuario;?>'
    </script>
    <script src="../modulo_administrar/js/permisos.js"></script>
    <script type="text/javascript">
        // Get the input field
        var cod = document.getElementById("codigoCliente");

        $('#ordenReconexion').on('keyup keypress', function(e) {
          var keyCode = e.keyCode || e.which;
          if (keyCode === 13) {
            e.preventDefault();
            return false;
          }
        });

        // Execute a function when the user releases a key on the keyboard
        cod.addEventListener("keyup", function(event) {
        // Number 13 is the "Enter" key on the keyboard
        if (event.keyCode === 13) {
        // Cancel the default action, if needed
        event.preventDefault();
        var codValue = document.getElementById("codigoCliente").value
        // Trigger the button element with a click
        window.location="ordenReconexion.php?codigoCliente="+codValue;
        }
        });
    </script>
    <?php
    if (isset($_GET['codigoCliente'])) {
        echo "<script>
            token = false;
            document.getElementById('ordenReconexion').action = 'php/nuevaOrdenReconex.php';
            document.getElementById('btn-cable').disabled = false;
            document.getElementById('btn-internet').disabled = false;
            document.getElementById('guardar').disabled = false;
            document.getElementById('editar').disabled = true;
            document.getElementById('imprimir').disabled = true;
            var inputs = document.getElementsByClassName('input-sm');
            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].readOnly == true) {
                    inputs[i].readOnly = false;
                }
                else if (inputs[i].disabled == true) {
                    inputs[i].disabled = false;
                }
            }
            var time = new Date();

            var seconds = time.getSeconds();
            var minutes = time.getMinutes();
            var hour = time.getHours();
            time = hour + ':' + minutes + ':' + seconds;
            document.getElementById('hora').value = time;
        </script>";
    }
    if (isset($_GET['nOrden'])) {
        echo "<script>
        token = true;
        var tipoServicio = document.getElementById('tipoServicio').value
        if (tipoServicio == 'C') {
            document.getElementById('nombreOrden').innerHTML = 'CABLE';
        }else if (tipoServicio == 'I') {
            document.getElementById('nombreOrden').innerHTML = 'INTERNET';
        }
        </script>";

    }
    ?>
    <script>
        $(document).ready(function(){
            $('#fechaReconexCable').mask("00/00/0000", {placeholder: "dd/mm/yyyy"});
            $('#fechaReconexInter').mask("00/00/0000", {placeholder: "dd/mm/yyyy"});
            $('#ultSuspCable').mask("00/00/0000", {placeholder: "dd/mm/yyyy"});
            $('#ultSuspInter').mask("00/00/0000", {placeholder: "dd/mm/yyyy"});
            //$('#fechaPrimerFacturaCable').mask("00/00/0000", {placeholder: "dd/mm/yyyy"});
        });
    </script>

</body>

</html>
