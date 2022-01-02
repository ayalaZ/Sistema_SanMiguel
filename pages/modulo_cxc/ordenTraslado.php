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
    $arrayDepartamentos = $dataInfo->getData('tbl_departamentos_cxc');
    $arrMunicipios = $dataInfo->getData('tbl_municipios_cxc');
    $arrColonias = $dataInfo->getData('tbl_colonias_cxc');
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
            $query = "SELECT cod_cliente, nombre, telefonos, direccion, saldoCable, mactv, saldoInternet, id_municipio, saldo_actual, telefonos, dire_cable, dia_cobro, dire_internet, mactv, fecha_suspencion, fecha_suspencion_in, mac_modem, serie_modem, id_velocidad, recep_modem, trans_modem, ruido_modem, coordenadas, colilla, marca_modem, tecnologia, coordenadas, id_departamento, id_municipio, id_colonia FROM clientes WHERE cod_cliente = ? LIMIT 0,1";
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
            $idOrdenTraslado = "";
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
            $fechaTraslado = "";
            $direccionTraslado = "";
            $idDepartamento = ""/*$row["id_departamento"]*/;
            $idMunicipio = ""/*$row["id_municipio"]*/;
            $idColonia = ""/*$row["id_colonia"]*/;
            $coor = $row['coordenadas'];
            $coorNuevas = $row['coordenadas'];


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
            $query = "SELECT idOrdenTraslado, codigoCliente, fechaOrden, tipoOrden, diaCobro, telefonos, nombreCliente, direccion, direccionTraslado, idDepartamento, idMunicipio, idColonia, saldoCable, fechaTraslado, saldoInter, macModem, serieModem, velocidad, colilla, idTecnico, coordenadas, mactv, observaciones, tipoServicio, creadoPor, coordenadas, coordenadasNuevas FROM tbl_ordenes_traslado WHERE idOrdenTraslado = ? LIMIT 0,1";
            $stmt = $con->prepare( $query );

            // this is the first question mark
            $stmt->bindParam(1, $id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            /****************** DATOS GENERALES ***********************/
            $idOrdenTraslado = $row["idOrdenTraslado"];
            $fechaOrden = date_format(date_create($row["fechaOrden"]), 'd/m/Y');
            $tipoOrden = $row["tipoOrden"];
            //$tipoReconexCable = $row["tipoReconexCable"];
            //$tipoReconexInter = $row["tipoReconexInter"];
            $diaCobro = $row["diaCobro"];
            $codigoCliente = $row["codigoCliente"];
            //var_dump($fechaTraslado = $row["fechaTraslado"]);
            if (strlen($row["fechaTraslado"]) > 8){
                $fechaTraslado = date_format(date_create($row["fechaTraslado"]), 'd/m/Y');
            }else{
                $fechaTraslado = "";
            }

            $direccionTraslado = $row['direccionTraslado'];
            if ($codigoCliente === "00000") {
                $codigoCliente = "SC";
            }
            $nombreCliente = $row['nombreCliente'];
            $telefonos = $row["telefonos"];
            //$idMunicipio = $row["idMunicipio"];
            /*if (empty($row["ultSuspCable"])) {
                $ultSuspCable = "";
            }else {
                $ultSuspCable = date_format(date_create($row["ultSuspCable"]), 'd/m/Y');
            }*/

            $saldoCable = $row["saldoCable"];
            $direccion = $row["direccion"];
            $saldoInter = $row["saldoInter"];
            /*if (empty($row["ultSuspInter"])) {
                $ultSuspInter = "";
            }else {
                $ultSuspInter = date_format(date_create($row["ultSuspInter"]), 'd/m/Y');
            }*/
            $macModem = $row['macModem'];
            $serieModem = $row['serieModem'];
            $velocidad = $row['velocidad'];
            $colilla = $row['colilla'];
            $idDepartamento = $row['idDepartamento'];
            $idMunicipio = $row['idMunicipio'];
            $idColonia = $row['idColonia'];
            /*if (empty($row["fechaReconexCable"])) {
                $fechaReconexCable = "";
            }else {
                $fechaReconexCable = date_format(date_create($row["fechaReconexCable"]), 'd/m/Y');
            }

            if (empty($row["fechaReconexInter"])) {
                $fechaReconexInter = "";
            }else {
                $fechaReconexInter = date_format(date_create($row["fechaReconexInter"]), 'd/m/Y');
            }*/

            //$hora = $row['hora'];
            $idTecnico = $row['idTecnico'];
            var_dump($idTecnico);
            $mactv = $row['mactv'];
            $observaciones = $row['observaciones'];
            //$nodo = $row['nodo'];
            $tipoServicio = $row['tipoServicio'];
            $coor = $row['coordenadas'];
            $coorNuevas = $row['coordenadasNuevas'];
            $creadoPor = $row['creadoPor'];
            //creadoPor
        }
        catch(PDOException $exception){
            die('ERROR: ' . $exception->getMessage());
        }
    }else {
        $fechaOrden = "";
        $idOrdenTraslado = "";
        $codigoCliente = "";
        $nombreCliente = "";
        $fechaTraslado = "";
        $direccionTraslado = "";
        $diaCobro = "";
        $telefonos = "";
        $idMunicipio = "";
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
        $coor="";
        $coorNuevas="";
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
                          <div class="panel-heading"><b>Orden de Traslado</b> <span id="nombreOrden" class="label label-danger"></span></div>
                          <form id="ordenTraslado" action="" method="POST">
                          <div class="panel-body">
                              <div class="col-md-12">
                                  <button class="btn btn-default btn-sm" name="" id="nuevaOrdenId" onclick="nuevaOrden()" type="button" name="btn_nuevo" data-toggle="tooltip" data-placement="bottom" title="Nueva orden"><i class="far fa-file"></i></button>
                                  <button class="btn btn-default btn-sm" name="" id="editar" onclick="editarOrden()" type="button" name="btn_nuevo" data-toggle="tooltip" data-placement="bottom" title="Editar orden"><i class="far fa-edit"></i></button>
                                  <button class="btn btn-default btn-sm" type="button" name="btn_nuevo" data-toggle="tooltip" data-placement="bottom" title="Ver cliente"><i class="far fa-eye"></i></button>
                                  <button class="btn btn-default btn-sm" type="button" id="guardar" name="btn_nuevo" onclick="guardarOrden()" data-toggle="tooltip" data-placement="bottom" title="Guardar orden" disabled><i class="far fa-save"></i></button>
                                  <?php echo '<input style="display: none;" type="submit" id="guardar2" value="">'; ?>
                                  <button class="btn btn-default btn-sm" type="button" name="btn_nuevo" data-placement="bottom" title="Buscar orden" data-toggle="modal" data-target="#buscarOrden"><i class="fas fa-search"></i></button>
                                  <button class="btn btn-default btn-sm" id="imprimir" onclick="imprimirOrden()" type="button" name="btn_nuevo" data-toggle="tooltip" data-placement="bottom" title="Imprimir orden" ><i class="fas fa-print"></i></button>
                                  <div class="pull-right">

                                      <button class="btn btn-default btn-sm" type="button" name="btn_nuevo" data-toggle="tooltip" data-placement="bottom" title="Estado de cuenta"><i class="far fa-file-alt"></i></button>
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
                                      <label for="numeroReconexion  ">N° de traslado</label>
                                      <input id="numeroTraslado" class="form-control input-sm" type="text" name="numeroTraslado" value="<?php echo $idOrdenTraslado; ?>" readonly>
                                  </div>
                                  <div class="col-md-2">

                                      <label for="fechaElaborada">Fecha elaborada</label>
                                      <input id="fechaOrden" class="form-control input-sm" type="text" name="fechaOrden" value="<?php echo $fechaOrden; ?>" readonly>
                                  </div>
                                  <div class="col-md-2">

                                      <label for="codigoCliente">Código del cliente</label>
                                      <input id="codigoCliente" class="form-control input-sm" type="text" name="codigoCliente" value="<?php echo $codigoCliente; ?>" readonly required>
                                  </div>
                                  <div class="col-md-5">

                                      <label for="nombreCliente">Nombre del cliente</label>
                                      <input id="nombreCliente" class="form-control input-sm" type="text" name="nombreCliente" value="<?php echo $nombreCliente; ?>" readonly required>
                                  </div>
                                  <div class="col-md-1">

                                      <label for="diaCobro">Día c</label>
                                      <input class="form-control input-sm" type="text" name="diaCobro" value="<?php echo $diaCobro; ?>" readonly>
                                  </div>
                              </div>
                              <div class="form-row">
                                  <div class="col-md-12">
                                      <label for="direccionCliente">Dirección anterior</label>
                                      <textarea class="form-control input-sm" name="direccionCliente" rows="2" cols="40" readonly required><?php echo $direccion; ?></textarea>
                                  </div>
                              </div>
                              <div class="form-row">
                                  <div class="col-md-12">
                                      <label for="direccionTraslado">Dirección de traslado</label>
                                      <textarea class="form-control input-sm" name="direccionTraslado" rows="2" cols="40" readonly required><?php echo $direccionTraslado; ?></textarea>
                                  </div>
                                  <div class="col-md-12">
                                      <label style="font-weight: normal; text-decoration-line: underline; text-decoration-style: solid;" for="actualizarDireccion">Actualizar dirección en ficha</label>
                                      <input type="checkbox" id="actualizarDireccion" name="actualizarDireccion" value="1">
                                  </div>
                              </div>
                              <div class="form-row">
                                  <div class="col-md-6">
                                      <label for="coordenadas">Coordenadas anteriores</label>
                                      <input class="form-control input-sm" type="text" name="coordenadas" value="<?php echo $coor; ?>" readonly>
                                  </div>
                                  <div class="col-md-6">
                                      <label for="coordenadas">Nuevas coordenadas</label>
                                      <input class="form-control input-sm" type="text" name="coordenadasNuevas" value="<?php echo "*".$coorNuevas."*"; ?>" readonly>
                                  </div>
                              </div>
                              <div class="form-row">
                                  <div class="col-md-4">
                                      <label for="departamento">Departamento</label>
                                      <select id="departamento" class="form-control input-sm" name="departamento" disabled required>
                                          <option value="">Seleccionar</option>
                                          <?php
                                          foreach ($arrayDepartamentos as $key) {
                                              if ($key['idDepartamento'] == $idDepartamento) {
                                                  echo "<option value='".$key['idDepartamento']."' selected>".$key['nombreDepartamento']."</option>";
                                              }else {
                                                  echo "<option value='".$key['idDepartamento']."'>".$key['nombreDepartamento']."</option>";
                                              }
                                          }
                                          ?>
                                      </select>
                                  </div>
                                  <div class="col-md-4">
                                      <label for="municipio">Municipio</label>
                                      <select id="municipio" class="form-control input-sm" name="municipio" disabled required>
                                          <option value="">Seleccionar</option>
                                          <?php
                                          foreach ($arrMunicipios as $key) {
                                              if ($key['idMunicipio'] == $idMunicipio) {
                                                  echo "<option value='".$key['idMunicipio']."' selected>".$key['nombreMunicipio']."</option>";
                                              }else {
                                                  echo "<option value='".$key['idMunicipio']."'>".$key['nombreMunicipio']."</option>";
                                              }
                                          }
                                          ?>
                                      </select>
                                  </div>
                                  <div class="col-md-4">
                                      <label for="colonia">Barrio o colonia</label>
                                      <select id="colonia" class="form-control input-sm" name="colonia" disabled required>
                                          <option value="">Seleccionar</option>
                                          <?php
                                          foreach ($arrColonias as $key) {
                                              if ($key['idColonia'] == $idColonia) {
                                                  echo "<option value='".$key['idColonia']."' selected>".$key['nombreColonia']."</option>";
                                              }else {
                                                  echo "<option value='".$key['idColonia']."'>".$key['nombreColonia']."</option>";
                                              }
                                          }
                                          ?>
                                      </select>
                                  </div>
                              </div>
                              <div class="form-row">
                                  <div id="divCable" class="col-md-12">
                                      <!--<h4 class="alert alert-info cable"><strong>Cable</strong></h4>-->
                                      <div class="row">
                                          <div class="col-md-8">
                                              <label for="mactv">MAC TV</label>
                                              <input id="mactv" class="form-control input-sm cable" type="text" name="mactv" value="<?php echo $mactv ?>" readonly>
                                          </div>
                                          <div class="col-md-4">
                                              <label for="saldoCable">Saldo TV</label>
                                              <input id="saldoCable" class="form-control input-sm cable" type="text" name="saldoCable" value="<?php echo $saldoCable ?>" readonly>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="form-row">
                                  <div class="col-md-2">
                                      <label for="saldoInternet">Saldo Internet</label>
                                      <input id="saldoInter" class="form-control input-sm internet" type="text" name="saldoInter" value="<?php echo $saldoInter ?>" readonly>
                                  </div>
                                  <div class="col-md-3">
                                      <label for="macModem">MAC del modem</label>
                                      <input id="macModem" class="form-control input-sm internet" type="text" name="macModem" value="<?php echo $macModem ?>" readonly>
                                  </div>
                                  <div class="col-md-4">
                                      <label for="serieModem">Serie del modem</label>
                                      <input id="serieModem" class="form-control input-sm internet" type="text" name="serieModem" value="<?php echo $serieModem ?>" readonly>
                                  </div>
                                  <div class="col-md-3">
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
                                  <div class="col-md-2">
                                      <label for="fechaTraslado">Fecha traslado</label>
                                      <input id="fechaTraslado" class="form-control input-sm" type="text" name="fechaTraslado" value="<?php echo $fechaTraslado; ?>" readonly>
                                  </div>
                                  <div class="col-md-3">
                                      <label for="telefonos">Teléfono reciente</label>
                                      <input id="telefonos" class="form-control input-sm" type="text" name="telefonos" value="<?php echo $telefonos; ?>" readonly>
                                  </div>
                                  <div class="col-md-4">
                                      <label for="tecnico">Técnico</label>
                                      <select class="form-control input-sm" name="responsable" disabled required>
                                          <option value="" selected>Seleccionar</option>
                                          <?php
                                          foreach ($arrayTecnicos as $key) {
                                              if ($key['idTecnico'] == $idTecnico) {
                                                  echo "<option value=".$key['idTecnico']." selected>".strtoupper($key['nombreTecnico'])."</option>";
                                              }
                                              echo "<option value=".$key['idTecnico'].">".strtoupper($key['nombreTecnico'])."</option>";
                                          }
                                          ?>
                                      </select>
                                  </div>
                                  <div class="col-md-3">
                                      <label for="colilla">Colilla</label>
                                      <input id="colilla" class="form-control input-sm" type="text" name="colilla" value="<?php echo $colilla; ?>" readonly required>
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
                <h4 class="modal-title">Buscar orden de traslado</h4>
              </div>
              <div class="modal-body">
                  <div class="row">
                      <div class="col-md-12">
                          <input class="form-control" type="text" name="caja_busqueda" id="caja_busqueda" placeholder="N°suspensión, Fecha orden, Código cliente, Nombre cliente, Dirección">
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
    <script src="js/ordenTraslado.js"></script>
    <script src="js/searchtras.js"></script>
    <script type="text/javascript">
        var permisos = '<?php echo $permisosUsuario;?>'
    </script>
    <script src="../modulo_administrar/js/permisos.js"></script>
    <script type="text/javascript">
        // Get the input field
        var cod = document.getElementById("codigoCliente");

        $('#ordenTraslado').on('keyup keypress', function(e) {
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
        var codValue = document.getElementById("codigoCliente").value;
        // Trigger the button element with a click
        window.location="ordenTraslado.php?codigoCliente="+codValue;
        }
        });
    </script>
    <?php
    if (isset($_GET['codigoCliente'])) {
        echo "<script>
            token = false;
            document.getElementById('ordenTraslado').action = 'php/nuevaOrdenTraslado.php';
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
            $('#fechaTraslado').mask("00/00/0000", {placeholder: "dd/mm/yyyy"});
            //$('#fechaPrimerFacturaCable').mask("00/00/0000", {placeholder: "dd/mm/yyyy"});
        });
    </script>

</body>

</html>
