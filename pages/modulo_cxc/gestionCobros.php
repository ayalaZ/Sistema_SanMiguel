<?php

if(!isset($_SESSION))
{
    session_start([
        'cookie_lifetime' => 86400,
    ]);
}
    require_once "php/getData.php";
    require_once "php/GetAllInfo.php";
    require_once "php/getSaldoReal.php";

    require($_SERVER['DOCUMENT_ROOT'].'/satpro'.'/php/permissions.php');
    $permisos = new Permissions();
    $permisosUsuario = $permisos->getPermissions($_SESSION['id_usuario']);
    $dataInfo = new GetAllInfo();
    $arrMunicipios = $dataInfo->getData('tbl_municipios_cxc');
    $data = new OrdersInfo();

    $saldos = new GetSaldoReal();

    //var_dump($getSaldoCable);
    //$client = new GetClient();
    $arrayTecnicos = $data->getTecnicos();
    $arrayActividadesSusp = $data->getActividadesSusp();
    $arrayVelocidades = $data->getVelocidades();
    $arrCobradores = $dataInfo->getData('tbl_cobradores');
    if (isset($_GET["idGestion"])) {
        $idGestion = $_GET["idGestion"];
    }else {
        $idGestion = 0;
    }

    $arrGestion = $dataInfo->getDataGestion('tbl_gestion_clientes', $idGestion);
    //include database connection
    require_once('../../php/connection.php');
    $precon = new ConectionDB($_SESSION['db']);
    $con = $precon->ConectionDB($_SESSION['db']);
    /**************************************************/
    if (isset($_GET['codigoCliente'])) {
        $getSaldoCable = $saldos->getSaldoCable($_GET['codigoCliente']);
        $getSaldoInter = $saldos->getSaldoInter($_GET['codigoCliente']);
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id=isset($_GET['codigoCliente']) ? $_GET['codigoCliente'] : die('ERROR: Record no encontrado.');

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT cod_cliente, nombre, telefonos, direccion, saldoCable, mactv, saldoInternet, id_municipio, saldo_actual, telefonos, dire_cable, dia_cobro, cod_cobrador, dire_internet, mactv, fecha_suspencion, fecha_suspencion_in, mac_modem, serie_modem, id_velocidad, recep_modem, trans_modem, ruido_modem, colilla, marca_modem, tecnologia FROM clientes WHERE cod_cliente = ? LIMIT 0,1";
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
            $tipoOrden = "Reconexion";
            $diaCobro = $row["dia_cobro"];
            $cobrador = $row["cod_cobrador"];
            //$ordenaSuspensionCable = "";
            //$ordenaSuspensionInter = "";

            $codigoCliente = $row["cod_cliente"];
            $nombreCliente = $row['nombre'];
            $direccion = $row["direccion"];
            $telefonos = $row["telefonos"];
            //$idMunicipio = $row["id_municipio"];
            $saldoCable = $row["saldoCable"];
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
            $coordenadas = "";
            $observaciones = "";
            $nodo = "";
            $idVendedor = "";
            $recepcionTv = "";

        }

        // show error
        catch(PDOException $exception){
            die('ERROR: ' . $exception->getMessage());
        }
    }else if(isset($_GET['idGestion'])){
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id=isset($_GET['idGestion']) ? $_GET['idGestion'] : die('ERROR: Record no encontrado.');

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT idGestionGeneral, codigoCliente, saldoCable, saldoInternet, diaCobro, idCobrador, nombreCliente, direccion, telefonos, creadoPor FROM tbl_gestion_general WHERE idGestionGeneral = ? LIMIT 0,1";
            $stmt = $con->prepare( $query );

            // this is the first question mark
            $stmt->bindParam(1, $id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            /****************** DATOS GENERALES ***********************/
            $idGestion = $row["idGestionGeneral"];
            $diaCobro = $row["diaCobro"];
            $cobrador = $row["idCobrador"];
            $codigoCliente = $row["codigoCliente"];
            if ($codigoCliente === "00000") {
                $codigoCliente = "SC";
            }
            $nombreCliente = $row['nombreCliente'];
            $telefonos = $row["telefonos"];

            //$saldoCable = $row["saldoCable"];
            //$saldoInter = $row["saldoInternet"];
            $direccion = $row["direccion"];
            $creadoPor = $row["creadoPor"];

            $query = "SELECT saldoCable,saldoInternet FROM clientes WHERE cod_cliente = ? LIMIT 0,1";
            $stmt = $con->prepare( $query );
            // this is the first question mark
            $stmt->bindParam(1, $codigoCliente);
            // execute our query
            $stmt->execute();
            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            //var_dump($codigoCliente);
            $saldos = new GetSaldoReal();
            $getSaldoCable = $saldos->getSaldoCable($codigoCliente);
            $getSaldoInter = $saldos->getSaldoInter($codigoCliente);

            $saldoCable = $row["saldoCable"];
            $saldoInter = $row["saldoInternet"];

        }
        catch(PDOException $exception){
            die('ERROR: ' . $exception->getMessage());
        }
    }else {
        /****************** DATOS GENERALES ***********************/
        $idGestion = "";
        $diaCobro = "";
        $codigoCliente = "";
        $codigoCliente = "";
        $nombreCliente = "";
        $telefonos = "";

        $saldoCable = "";
        $saldoInter = "";
        $direccion = "";
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
    <link href="../../dist/css/sb-admin-2.css" rel="stylesheet">
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
        a:hover {
            text-decoration: none;
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
                        <li><a href="../../php/logout.php"><i class="fas fa-sign-out-alt"></i></i> Salir</a>
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
                            <a href='../index.php'><i class='fas fa-home'></i> Principal</a>
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
                            echo "<li><a href='cxc.php'><i class='fas fa-hand-holding-usd'></i> Cuentas por cobrar</a></li>";
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

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <br>
                        <div class="panel panel-danger">
                          <div class="panel-heading"><b>Gestión de cobro </b> <span id="nombreOrden" class="label label-danger"></span></div>
                          <form id="gestionCobros" action="" method="POST">
                          <div class="panel-body" style="background-color:#E0E0E0;">
                              <div class="col-md-12">
                                  <button class="btn btn-default btn-sm" id="nuevaOrdenId" onclick="nuevaOrden()" type="button" name="btn_nuevo" data-toggle="tooltip" data-placement="bottom" title="Nueva gestión"><i class="far fa-file"></i></button>
                                  <button class="btn btn-default btn-sm" id="editar" onclick="editarOrden()" type="button" name="btn_nuevo" data-toggle="tooltip" data-placement="bottom" title="Editar gestión"><i class="far fa-edit"></i></button>
                                  <button class="btn btn-default btn-sm" id="verClient" type="button" name="btn_nuevo" onclick="verCliente();" data-toggle="tooltip" data-placement="bottom" title="Ver cliente"><i class="far fa-eye"></i></button>
                                  <button class="btn btn-default btn-sm" type="button" id="guardar" name="btn_nuevo" onclick="guardarOrden()" data-toggle="tooltip" data-placement="bottom" title="Guardar gestión" disabled><i class="far fa-save"></i></button>
                                  <?php echo '<input style="display: none;" type="submit" id="guardar2" value="">'; ?>
                                  <button class="btn btn-default btn-sm" type="button" name="btn_nuevo" data-placement="bottom" title="Buscar orden" data-toggle="modal" data-target="#buscarGestion"><i class="fas fa-search"></i></button>
                                  <button class="btn btn-default btn-sm" id="imprimir" onclick="imprimirOrden()" type="button" name="btn_nuevo" data-toggle="tooltip" data-placement="bottom" title="Imprimir orden" ><i class="fas fa-print"></i></button>
                                  <div class="pull-right">

                                      <!--<button class="btn btn-default btn-sm" type="button" name="btn_nuevo" data-toggle="tooltip" data-placement="bottom" title="Estado de cuenta"><i class="far fa-file-alt"></i></button>
                                      <button id="btn-cable" class="btn btn-default btn-sm" onclick="ordenCable()" type="button" name="btn_nuevo" data-toggle="tooltip" data-placement="bottom" title="Orden de cable" disabled><i class="fas fa-tv"></i></button>
                                      <button id="btn-internet" class="btn btn-default btn-sm" onclick="ordenInternet()" type="button" name="btn_nuevo" data-toggle="tooltip" data-placement="bottom" title="Orden de internet" disabled><i class="fas fa-wifi"></i></button>-->
                                      <button class="btn btn-danger btn-circle btn-md pull-right" type="button" id="agregarGestion" name="agregarGestion" data-toggle="modal" data-target="#agregarGestionForm" disabled><i class="fas fa-plus"></i></button>
                                  </div>
                              </div>
                              <div class="form-row">
                                  <div class="col-md-2">
                                      <br>
                                      <?php
                                      if (isset($_GET['idGestion'])) {
                                         echo "<input id='creadoPor' class='form-control input-sm' type='hidden' name='creadoPor' value='{$creadoPor}'>";
                                         //echo "<input id='tipoServicio' class='form-control input-sm' type='hidden' name='tipoServicio' value='{$tipoServicio}' readonly>";
                                      }
                                      else{
                                         echo '<input id="creadoPor" class="form-control input-sm" type="hidden" name="creadoPor" value="'.$_SESSION['nombres'] . " " . $_SESSION['apellidos'].'"' . '>';
                                         //echo '<input id="tipoServicio" class="form-control input-sm" type="hidden" name="tipoServicio" value="" readonly>';
                                      }
                                      ?>
                                      <label for="codigoCliente">Código Cliente</label>
                                      <input id="codigoCliente" class="form-control input-sm" type="text" name="codigoCliente" value="<?php echo $codigoCliente; ?>" readonly>
                                  </div>
                                  <div class="col-md-2 col-sm-2">
                                      <br>
                                      <label for="fechaElaborada">Día cobro</label>
                                      <input id="diaCobro" class="form-control input-sm" type="text" name="diaCobro" value="<?php echo $diaCobro; ?>" readonly>
                                  </div>
                                  <div class="col-md-2 col-sm-2">
                                      <br>
                                      <label for="codigoCliente">Saldo cable</label>
                                      <input id="saldoCable" class="form-control input-sm" type="text" name="saldoCable" value="<?php echo $getSaldoCable; ?>" readonly>
                                  </div>
                                  <div class="col-md-2 col-sm-2">
                                      <br>
                                      <label for="codigoCliente">Saldo internet</label>
                                      <input id="saldoInter" class="form-control input-sm" type="text" name="saldoInter" value="<?php echo $getSaldoInter; ?>" readonly>
                                  </div>
                                  <div class="col-md-4 col-sm-4">
                                      <br>
                                      <label for="nombreCliente">Nombre del cliente</label>
                                      <input id="nombreCliente" class="form-control input-sm" type="text" name="nombreCliente" value="<?php echo $nombreCliente; ?>" readonly>
                                  </div>
                              </div>
                              <div class="form-row">
                                  <div class="col-md-4 col-sm-4">
                                      <label for="telefonos">Telefonos</label>
                                      <input id="telefonos" class="form-control input-sm" type="text" name="telefonos" value="<?php echo $telefonos; ?>" readonly>
                                  </div>
                                  <div class="col-md-8 col-sm-8">
                                      <label for="telefonos">Cobrador</label>
                                      <select class="form-control input-sm" name="cobrador" disabled>
                                          <option value="" selected>Seleccionar</option>
                                          <?php
                                          foreach ($arrCobradores as $key) {
                                              if ($key['codigoCobrador'] == $cobrador) {
                                                  echo "<option value=".$key['codigoCobrador']." selected>".$key['nombreCobrador']."</option>";
                                              }
                                              else {
                                                  echo "<option value=".$key['codigoCobrador'].">".$key['nombreCobrador']."</option>";
                                              }

                                          }
                                           ?>
                                      </select>
                                  </div>
                                  <!--<div class="col-md-3 col-sm-3">
                                      <label for="tipoServicio">Servicio</label>
                                      <select class="form-control input-sm" name="tipoServicio" disabled>
                                          <option value="" selected>Seleccionar</option>
                                          <option value="C">Cable</option>
                                          <option value="I">Internet</option>
                                      </select>
                                  </div>-->
                              </div>
                              <div class="form-row">
                                  <div class="col-md-12 col-sm-12">
                                      <label for="direccionCliente">Dirección</label>
                                      <textarea class="form-control input-sm" name="direccionCliente" rows="2" cols="40" readonly><?php echo $direccion; ?></textarea>
                                  </div>

                              </div>
                              <div class="form-row">
                                  <div class="col-md-14 col-sm-12">
                                      <br>
                                      <table class="table table-bordered table-responsive">
                                          <thead>
                                              <th class="active">Fecha</th>
                                              <th class="active">Descripción</th>
                                              <th class="active">Gestión</th>
                                              <th class="active">Fecha final</th>
                                              <th class="active">Usuario</th>
                                              <th class="active">Servicio</th>
                                          </thead>
                                          <tbody>
                                              <?php
                                              foreach ($arrGestion as $gestion) {
                                                 if ($gestion['gestion'] == "0") {
                                                    $gestionrealizada = "Suspender";
                                                 }elseif ($gestion['gestion'] == "1") {
                                                      $gestionrealizada = "Prórroga de 1 día";
                                                 }elseif ($gestion['gestion'] == "2") {
                                                      $gestionrealizada = "Prórroga de 2 días";
                                                 }elseif ($gestion['gestion'] == "3") {
                                                      $gestionrealizada = "Prórroga de 3 días";
                                                 }elseif ($gestion['gestion'] == "4") {
                                                      $gestionrealizada = "Prórroga de 4 días";
                                                 }elseif ($gestion['gestion'] == "5") {
                                                      $gestionrealizada = "Prórroga de 5 días";
                                                 }elseif ($gestion['gestion'] == "6") {
                                                      $gestionrealizada = "Suspendido";
                                                 }elseif ($gestion['gestion'] == "7") {
                                                      $gestionrealizada = "Enviar cobrador";
                                                 }elseif ($gestion['gestion'] == "8") {
                                                      $gestionrealizada = "Cliente pago";
                                                 }elseif ($gestion['gestion'] == "9") {
                                                      $gestionrealizada = "No localizado";
                                                 }else{
                                                    $gestionrealizada = "Sin asignar";
                                                 }
                                                  if ($gestion['tipoServicio'] == "C") {
                                                      echo '<tr class="success">'.
                                                          '<td width="150px"><input class="form-control input-sm" type="text" value="'.$gestion['fechaGestion'].'" readOnly disabled></td>'.
                                                          '<td><textarea cols="40" rows="2" class="form-control input-sm" type="text" readOnly disabled>'.$gestion['descripcion'].'</textarea></td>'.

                                                          '<td width="170px"><input class="form-control input-sm" type="text" value="'.$gestionrealizada.'" readOnly disabled></td>'.
                                                          '<td width="120px"><input class="form-control input-sm" type="text" value="'.$gestion['fechaSuspension'].'" readOnly disabled></td>'.

                                                          '<td width="150px"><input class="form-control input-sm" type="text" value="'.$gestion['creadoPor'].'" readOnly disabled></td>'.
                                                          '<td width="100px"><input class="form-control input-sm" type="text" value="'.$gestion['tipoServicio'].'" readOnly disabled></td>'.
                                                      '</tr>';
                                                  }elseif ($gestion['tipoServicio'] == "I") {
                                                      echo '<tr class="info">'.
                                                          '<td width="150px"><input class="form-control input-sm" type="text" value="'.$gestion['fechaGestion'].'" readOnly disabled></td>'.
                                                          '<td><textarea cols="40" rows="2" class="form-control input-sm" type="text" readOnly disabled>'.$gestion['descripcion'].'</textarea></td>'.

                                                          '<td width="170px"><input class="form-control input-sm" type="text" value="'.$gestionrealizada.'" readOnly disabled></td>'.
                                                          '<td width="120px"><input class="form-control input-sm" type="text" value="'.$gestion['fechaSuspension'].'" readOnly disabled></td>'.

                                                          '<td width="150px"><input class="form-control input-sm" type="text" value="'.$gestion['creadoPor'].'" readOnly disabled></td>'.
                                                          '<td width="100px"><input class="form-control input-sm" type="text" value="'.$gestion['tipoServicio'].'" readOnly disabled></td>'.
                                                      '</tr>';
                                                  }else{
                                                    echo '<tr class="danger">'.
                                                          '<td width="150px"><input class="form-control input-sm" type="text" value="'.$gestion['fechaGestion'].'" readOnly disabled></td>'.
                                                          '<td><textarea cols="40" rows="2" class="form-control input-sm" type="text" readOnly disabled>'.$gestion['descripcion'].'</textarea></td>'.

                                                          '<td width="170px"><input class="form-control input-sm" type="text" value="'.$gestionrealizada.'" readOnly disabled></td>'.
                                                          '<td width="120px"><input class="form-control input-sm" type="text" value="'.$gestion['fechaSuspension'].'" readOnly disabled></td>'.

                                                          '<td width="150px"><input class="form-control input-sm" type="text" value="'.$gestion['creadoPor'].'" readOnly disabled></td>'.
                                                          '<td width="100px"><input class="form-control input-sm" type="text" value="'.$gestion['tipoServicio'].'" readOnly disabled></td>'.
                                                      '</tr>';

                                                  }
                                              }
                                              ?>
                                          </tbody>
                                      </table>
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
        <div id="agregarGestionForm" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Agregar gestión para este cliente (Para prórroga solicitar a jefatura)</h4>
              </div>
              <div class="modal-body">
                  <form class="" action="<?php echo 'php/nuevaGestionCliente.php?idGestion='.$_GET['idGestion'];?>" method="POST">
                  <div class="row">
                      <div class="col-md-4">
                          <label for="fechaGestion">Fecha de la gestión</label>
                          <input class="form-control" type="text" name="fechaGestion" value="<?php echo date('Y-m-d'); ?>" readonly>
                      </div>
                      <div class="col-md-4">
                          <?php  
                     if ($_SESSION["rol"] == 'administracion' || $_SESSION["rol"] == 'subgerencia' || $_SESSION["rol"] == 'jefatura') {
                        echo '<label for="tipoGestion">Tipo de gestión</label>
                          <select class="form-control input-sm" name="tipogestion" required>
                              <option value="" selected>Seleccionar</option>
                              <option value="0">Suspender servicio</option>
                              <option value="1">Prórroga de 1 día</option>
                              <option value="2">Prórroga de 2 días</option>
                              <option value="3">Prórroga de 3 días</option>
                              <option value="4">Prórroga de 4 días</option>
                              <option value="5">Prórroga de 5 días</option>
                              <option value="6">Cliente suspendido</option>
                              <option value="7">Enviar cobrador</option>
                              <option value="8">Pago</option>
                              <option value="9">No localizado</option>
                          </select>';
                    }else{
                        echo '<label for="tipoGestion">Tipo de gestión</label>
                          <select class="form-control input-sm" name="tipogestion" required>
                              <option value="" selected>Seleccionar</option>
                              <option value="0">Suspender servicio</option>
                              <option value="6">Cliente suspendido</option>
                              <option value="7">Enviar cobrador</option>
                              <option value="8">Pago</option>
                               <option value="9">No localizado</option>
                          </select>';
                    }
                        ?>
                      </div>
                      <div class="col-md-4">
                          <label for="tipoServicio">Tipo servicio</label>
                          <select class="form-control input-sm" name="tipoServicio" required>
                              <option value="" selected>Seleccionar</option>
                              <option value="C">Cable</option>
                              <option value="I">Internet</option>
                              <option value="P">Paquete</option>
                          </select>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12">
                          <label for="descripcion">Descripción</label>
                          <input class="form-control input-sm" type="text" name="descripcion" value="" required>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <input type="submit" class="btn btn-success" value="Guardar">
              </div>
              </form>
            </div>

          </div>
        </div>

        <div id="buscarGestion" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Buscar cliente</h4>
              </div>
              <div class="modal-body">
                  <div class="row">
                      <div class="col-md-12">
                          <input class="form-control" type="text" name="caja_busqueda" id="caja_busqueda" placeholder="Código, Nombre, direccion, Teléfono">
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

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>
    <script src="js/gestionCobros.js"></script>
    <script src="js/searchgb.js"></script>
    <!--<script src="js/searchges.js"></script>-->
    <script type="text/javascript">
        var permisos = '<?php echo $permisosUsuario;?>'
    </script>
    <script src="../modulo_administrar/js/permisos.js"></script>
    <script type="text/javascript">
        // Get the input field
        var cod = document.getElementById("codigoCliente");

        $('#gestionCobros').on('keyup keypress', function(e) {
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
        window.location="gestionCobros.php?codigoCliente="+codValue;
        }
        });
    </script>
    <?php
    if (isset($_GET['codigoCliente'])) {
        echo "<script>
            token = false;
            document.getElementById('gestionCobros').action = 'php/nuevaGestionCobros.php';

            document.getElementById('guardar').disabled = false;
            document.getElementById('editar').disabled = true;
            document.getElementById('agregarGestion').disabled = false;
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

        </script>";
    }
    /*if (isset($_GET['idGestion'])) {
        echo "<script>
        token = true;
        var tipoServicio = document.getElementById('tipoServicio').value
        if (tipoServicio == 'C') {
            document.getElementById('nombreOrden').innerHTML = 'CABLE';
        }else if (tipoServicio == 'I') {
            document.getElementById('nombreOrden').innerHTML = 'INTERNET';
        }
        </script>";

    }*/
    ?>
    echo "<script>
        function verCliente(){
            var cod = document.getElementById("codigoCliente").value;
            window.open("ver_cliente.php?codigo="+cod);
        }

    </script>";

</body>

</html>