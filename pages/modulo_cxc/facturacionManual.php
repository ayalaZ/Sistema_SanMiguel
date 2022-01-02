<?php

if(!isset($_SESSION))
{
    session_start([
        'cookie_lifetime' => 86400,
    ]);
}
    require("php/getData.php");
    require("php/GetAllInfo.php");
    $dataInfo = new GetAllInfo();
    $arrayDepartamentos = $dataInfo->getData('tbl_departamentos_cxc');
    $arrMunicipios = $dataInfo->getData('tbl_municipios_cxc');
    $arrColonias = $dataInfo->getData('tbl_colonias_cxc');

    $data = new OrdersInfo();
    //$client = new GetClient();
    $arrayVendedores = $data->getCobradores();
    $arrayTecnicos = $data->getTecnicos();
    $arrayActividadesSusp = $data->getActividadesSusp();
    $arrayFormasPago = $data->getFormasPago(); //Modificar
    $arrayTipoVenta = $data->getTipoVenta(); //Modificar
    $arrComprobantes = $dataInfo->getData('tbl_tipo_comprobante');
    $arrPuntosVenta = $dataInfo->getData('tbl_puntos_venta');
    $arrFormasPago = $dataInfo->getData('tbl_formas_pago');
    $arrTipoVenta = $dataInfo->getData('tbl_tipo_venta');

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
            $query = "SELECT cod_cliente, nombre, num_registro, numero_dui, telefonos, direccion, saldoCable, mactv, cod_cobrador, saldoInternet, id_departamento, id_municipio, saldo_actual, telefonos, dire_cable, dia_cobro, dire_internet, mactv, fecha_suspencion, fecha_suspencion_in, mac_modem, serie_modem, id_velocidad, recep_modem, trans_modem, ruido_modem, colilla, marca_modem, tecnologia FROM clientes WHERE cod_cliente = ? LIMIT 0,1";
            $stmt = $con->prepare( $query );

            // this is the first question mark
            $stmt->bindParam(1, $id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $query2 = "SELECT valorImpuesto FROM tbl_impuestos WHERE siglasImpuesto = 'IVA'";
            $stmt2 = $con->prepare( $query2 );

            // execute our query
            $stmt2->execute();

            // store retrieved row to a variable
            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            $iva = floatval($row2['valorImpuesto']);

            /****************** DATOS GENERALES ***********************/
            date_default_timezone_set('America/El_Salvador');
            $fechaComprobante = date_format(date_create(date('Y-m-d')), 'd/m/Y');
            $puntoVenta = "";
            $prefijo = "";
            $nComprobante = "";
            $nRegistro = $row["num_registro"];
            $codigoCliente = $row["cod_cliente"];
            $nombreCliente = $row['nombre'];
            $direccion = $row["direccion"];
            $doc = $row["numero_dui"];
            $giro = "";
            $formaPago = "";
            $vendedor = "";
            $tipoVenta = "";
            $ventaCuentaDe = "";
            $montoCable = "";
            $montoInternet = "";
            $totalExento = "";
            $totalAfecto = "";
            $impuesto = "";
            $percepcion = "";
            $total = "";
            $cobrador = $row["cod_cobrador"];

            $telefonos = $row["telefonos"];
            //$idMunicipio = $row["id_municipio"];
            $saldoCable = $row["saldoCable"];

            $saldoInter = $row["saldoInternet"];
            $velocidad = $row['id_velocidad'];
            $colilla = $row['colilla'];
            $marcaModelo = $row['marca_modem'];
            $tecnologia = $row['tecnologia'];
            $coordenadas = "";
            $observaciones = "";
            $nodo = "";
            $idVendedor = "";
            $departamento = $row['id_departamento'];
            $municipio = $row['id_municipio'];

            $exento = "";
            $cableExtra = "";
            $decodificador = "";
            $derivacion = "";
            $instalacionTemporal = "";
            $pagoTardio = "";
            $reconexion = "";
            $servicioPrestado = "";
            $traslados = "";
            $reconexionTraslado = "";
            $cambioFecha = "";
            $otros = "";
            $proporcion = "";

        }

        // show error
        catch(PDOException $exception){
            die('ERROR: ' . $exception->getMessage());
        }
    }else if(isset($_GET['idVenta'])){
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id=isset($_GET['idVenta']) ? $_GET['idVenta'] : die('ERROR: Record no encontrado.');

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT * FROM tbl_ventas_anuladas WHERE idVenta = ? LIMIT 0,1";
            $stmt = $con->prepare( $query );

            // this is the first question mark
            $stmt->bindParam(1, $id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            /****************** DATOS GENERALES ***********************/
            //$idOrdenTraslado = $row["idOrdenTraslado"];
            $fechaComprobante = $row["fechaComprobante"];
            $tipoComprobante = $row["tipoComprobante"];
            $puntoVenta = $row["idPunto"];
            $prefijo = $row["prefijo"];
            $formaPago = $row["formaPago"];
            $tipoVenta = $row["tipoVenta"];
            $nComprobante = $row["numeroComprobante"];
            $codigoCliente = $row["codigoCliente"];
            $nombreCliente = $row['nombreCliente'];
            $nRegistro = $row["numeroRegistro"];
            $giro = $row["giro"];
            $doc = $row["nit"];
            $codigoCliente = $row["codigoCliente"];
            $ventaCuentaDe = $row["ventaTitulo"];
            $montoCable = $row["montoCable"];
            $montoInternet = $row["montoInternet"];
            $totalExento = $row["ventaExenta"];
            $totalAfecto = $row["ventaAfecta"];
            $iva = $row["valorIva"];
            $impuesto = $row["impuesto"];
            $total = $row["totalComprobante"];

            if ($codigoCliente === "00000") {
                $codigoCliente = "SC";
            }
            $nombreCliente = $row['nombreCliente'];
            $direccion = $row["direccionCliente"];
            $departamento = $row['departamento'];
            $municipio = $row['municipio'];
            $vendedor = $row['codigoVendedor'];
            $percepcion = "";
            $creadoPor = $row['creadoPor'];

            /*************************CHECKBOXES*******************************/

        }
        catch(PDOException $exception){
            die('ERROR: ' . $exception->getMessage());
        }
    }else {
        $fechaComprobante = "";
        $puntoVenta = "";
        $prefijo = "";
        $nComprobante = "";
        $codigoCliente = "";
        $nombreCliente = "";
        $direccion = "";
        $nRegistro = "";
        $doc = "";
        $giro = "";
        $ventaCuentaDe = "";
        $montoCable = "";
        $montoInternet = "";
        $totalExento = "";
        $totalAfecto = "";
        $iva = "";
        $impuesto = "";
        $percepcion = "";
        $total = "";

        $telefonos = "";
        $idMunicipio = "";
        $saldoCable = "";
        $direccion = "";
        $saldoCable = "";
        $saldoInter = "";
        //$exento = "";
        $cableExtra = "";
        $decodificador = "";
        $derivacion = "";
        $instalacionTemporal = "";
        $pagoTardio = "";
        $reconexion = "";
        $servicioPrestado = "";
        $traslados = "";
        $reconexionTraslado = "";
        $cambioFecha = "";
        $otros = "";
        $proporcion = "";
        $cobrador = "";
        $iva = "";
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
    <link href="../../dist/css/sb-admin-2.css" rel="stylesheet">
    <link rel="stylesheet" href="../../dist/css/custom-principal.css">

    <!-- Morris Charts CSS -->
    <link href="../../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <style media="screen">
        .form-control {
            color: #01579B;
            font-size: 15px;
            font-weight: bold;
        }
    </style>
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
                          <div class="panel-heading"><b>Factura manual</b> <span id="nombreOrden" class="label label-danger"></span></div>
                          <form id="ventaManual" action="" method="POST">
                          <div class="panel-body">
                              <div class="col-md-12">
                                  <button class="btn btn-default btn-sm" id="" onclick="nuevaOrden()" type="button" name="btn_nuevo" data-toggle="tooltip" data-placement="bottom" title="Nueva orden"><i class="far fa-file"></i></button>
                                  <button class="btn btn-default btn-sm" id="editar" onclick="editarOrden()" type="button" name="btn_nuevo" data-toggle="tooltip" data-placement="bottom" title="Editar orden"><i class="far fa-edit"></i></button>
                                  <button class="btn btn-default btn-sm" type="button" name="btn_nuevo" data-toggle="tooltip" data-placement="bottom" title="Ver cliente"><i class="far fa-eye"></i></button>
                                  <button class="btn btn-default btn-sm" type="button" id="guardar" name="btn_nuevo" onclick="guardarOrden()" data-toggle="tooltip" data-placement="bottom" title="Guardar orden" disabled><i class="far fa-save"></i></button>
                                  <?php echo '<input style="display: none;" type="submit" id="guardar2" value="">'; ?>
                                  <button class="btn btn-default btn-sm" type="button" name="btn_nuevo" data-placement="bottom" title="Buscar orden" data-toggle="modal" data-target="#buscarVentaManual"><i class="fas fa-search"></i></button>
                                  <button class="btn btn-default btn-sm" id="imprimir" onclick="imprimirOrden()" type="button" name="btn_nuevo" data-toggle="tooltip" data-placement="bottom" title="Imprimir orden" ><i class="fas fa-print"></i></button>
                                  <div class="pull-right">
                                      <button class="btn btn-danger btn-sm" id="" onclick="clearAll()" type="button" name="" data-toggle="tooltip" data-placement="bottom" title="Limpiar"><i class="fas fa-trash-alt"></i></button>
                                  </div>
                              </div>
                              <div class="form-row">
                                  <div class="col-md-10">
                                      <label for="nombreCliente">Nombre</label>
                                      <input id="nombreCliente" class="form-control input-sm" type="text" name="nombreCliente" value="<?php echo $nombreCliente; ?>" readonly required>
                                  </div>
                                  <div class="col-md-2">
                                      <label for="codigoCliente">Código</label>
                                      <input id="codigoCliente" class="form-control input-sm alert-danger" type="text" name="codigoCliente" value="<?php echo $codigoCliente; ?>" readonly required>
                                  </div>
                              </div>
                              <div class="form-row">
                                  <div class="col-md-4">
                                      <label for="departamento">Departamento</label>
                                      <select id="departamento" class="form-control input-sm" name="departamento" disabled required>
                                          <option value="">Seleccionar</option>
                                          <?php
                                          foreach ($arrayDepartamentos as $key) {
                                              if ($key['idDepartamento'] == $departamento) {
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
                                              if ($key['idMunicipio'] == $municipio) {
                                                  echo "<option value='".$key['idMunicipio']."' selected>".$key['nombreMunicipio']."</option>";
                                              }else {
                                                  echo "<option value='".$key['idMunicipio']."'>".$key['nombreMunicipio']."</option>";
                                              }
                                          }
                                          ?>
                                      </select>
                                  </div>
                              </div>
                              <div class="form-row">
                                  <div class="col-md-4">

                                      <?php
                                      if (isset($_GET['idVenta'])) {
                                         echo "<input id='creadoPor' class='form-control input-sm' type='hidden' name='creadoPor' value='{$creadoPor}'>";
                                         echo "<input id='idVenta' class='form-control input-sm' type='hidden' name='idVenta' value='{$_GET["idVenta"]}'>";
                                      }
                                      else{
                                         echo '<input id="creadoPor" class="form-control input-sm" type="hidden" name="creadoPor" value="'.$_SESSION['nombres'] . " " . $_SESSION['apellidos'].'"' . '>';
                                      }
                                      ?>
                                      <label for="puntoVenta  ">Punto de venta</label>
                                      <select id="puntoVenta" class="form-control input-sm" name="puntoVenta" disabled required>
                                          <option value="">Seleccionar</option>
                                          <?php
                                          foreach ($arrPuntosVenta as $key) {
                                              if ($key['idPunto'] == $puntoVenta) {
                                                  echo "<option value=".$key['idPunto']." selected>".$key['nombrePuntoVenta']."</option>";
                                              }
                                              else {
                                                  echo "<option value=".$key['idPunto'].">".$key['nombrePuntoVenta']."</option>";
                                              }
                                          }
                                          ?>
                                      </select>
                                  </div>
                                  <div class="col-md-3">

                                      <label for="tipoComprobante">Tipo comprobante</label>
                                      <select id="tipoComprobante" class="form-control input-sm" onchange="tipoFactura();" id="tipoComprobante" name="tipoComprobante" disabled required>
                                          <option value="">Seleccionar</option>
                                          <?php
                                          foreach ($arrComprobantes as $key) {
                                              if ($key['idComprobante'] == $_GET['tipoComprobante']) {
                                                  echo "<option value=".$key['idComprobante']." selected>".$key['nombreComprobante']."</option>";
                                              }
                                              else {
                                                  echo "<option value=".$key['idComprobante'].">".$key['nombreComprobante']."</option>";
                                              }
                                          }

                                          ?>
                                      </select>
                                  </div>

                                  <div class="col-md-3">
                                      <label for="Prefijo">Prefijo</label>
                                      <input id="prefijo" class="form-control input-sm alert-danger" type="text" name="prefijo" value="<?php if (isset($_GET["tipoComprobante"])){echo $dataInfo->getPrefijo($_GET["tipoComprobante"]);} ?>" readonly>
                                  </div>
                                  <div class="col-md-3">

                                      <label for="nComprobante">N° de comprobante</label>
                                      <input id="nComprobante" class="form-control input-sm alert-danger" type="text" name="nComprobante" value="<?php if (isset($_GET["tipoComprobante"])){echo $dataInfo->getUltFact($_GET["tipoComprobante"]);} ?>" readonly required>
                                  </div>
                                  <div class="col-md-3">

                                      <label for="fechaComprobante">Fecha comprobrobante</label>
                                      <input class="form-control input-sm" type="text" id="fechaComprobante" name="fechaComprobante" value="<?php date_default_timezone_set('America/El_Salvador'); echo date('Y-m-d'); ?>" readonly>
                                  </div>
                              </div>

                              <div class="form-row">
                                  <div class="col-md-12">
                                      <label for="direccion">Dirección</label>
                                      <textarea class="form-control input-sm" name="direccion" rows="2" cols="40" readonly required><?php echo $direccion; ?></textarea>
                                  </div>
                              </div>
                              <div class="form-row">

                              </div>
                              <div class="form-row">
                                  <div class="col-md-2">
                                      <label for="nRegistro">N° registro</label>
                                      <input id="nRegistro" class="form-control input-sm internet" type="text" name="nRegistro" value="<?php echo $nRegistro ?>" readonly>
                                  </div>
                                  <div class="col-md-3">
                                      <label for="doc">NIT o DUI</label>
                                      <input id="doc" class="form-control input-sm internet" type="text" name="doc" value="<?php echo $doc ?>" readonly required>
                                  </div>
                                  <div class="col-md-4">
                                      <label for="giro">Giro</label>
                                      <input id="giro" class="form-control input-sm internet" type="text" name="giro" value="<?php echo $giro ?>" readonly>
                                  </div>
                                  <div class="col-md-3">
                                      <label for="formaPago">Forma de pago</label>
                                      <select id="formaPago" class="form-control input-sm internet" name="formaPago" disabled required>
                                          <option value="" selected>Seleccionar</option>
                                          <?php
                                          foreach ($arrFormasPago as $key) {
                                              if ($key['idFormaPago'] == $formaPago) {
                                                  echo "<option value=".$key['idFormaPago']." selected>".strtoupper($key['nombreFormaPago'])."</option>";
                                              }else {
                                                  echo "<option value=".$key['idFormaPago'].">".strtoupper($key['nombreFormaPago'])."</option>";
                                              }

                                          }
                                          ?>
                                      </select>

                                  </div>

                              </div>
                              <div class="form-row">
                                  <div class="col-md-4">
                                      <label for="vendedor">Vendedor</label>
                                      <select id="vendedor" class="form-control input-sm" name="vendedor" disabled>
                                          <option value="" selected>Seleccionar</option>
                                          <?php
                                          foreach ($arrayVendedores as $key) {
                                              if ($key['codigoCobrador'] == $cobrador) {
                                                  echo "<option value='".$key['codigoCobrador']."' selected>".$key['nombreCobrador']."</option>";
                                              }else {
                                                  echo "<option value='".$key['codigoCobrador']."'>".$key['nombreCobrador']."</option>";
                                              }
                                          }
                                          ?>
                                      </select>
                                  </div>
                                  <div class="col-md-3">
                                      <label for="tipoVenta">Tipo venta</label>
                                      <select id="tipoVenta" class="form-control input-sm" name="tipoVenta" disabled required>
                                          <option value="" selected>Seleccionar</option>
                                          <?php
                                          foreach ($arrTipoVenta as $key) {
                                              if ($key['idTipoVenta'] == $tipoVenta) {
                                                  echo "<option value='".$key['idTipoVenta']."' selected>".$key['nombreTipo']." "."</option>";
                                              }else {
                                                  echo "<option value='".$key['idTipoVenta']."'>".$key['nombreTipo']." "."</option>";
                                              }
                                          }
                                          ?>
                                      </select>
                                  </div>
                                  <div class="col-md-3">
                                      <label for="ventaCuentaDe">Tipo de servicio</label>
                                      <select class="form-control input-sm" name="tipoServicio" id="tipoServicio" onchange="getTipoServicio();" required>
                                          <option value="">Seleccionar</option>
                                          <option value="C">Cable</option>
                                          <option value="I">Internet</option>
                                      </select>
                                  </div>
                                  <div class="col-md-2">
                                      <label for="motivo">Motivo</label>
                                      <select class="form-control input-sm alert-danger" name="motivo" id="motivo" onchange="getMotivo();" required>
                                          <option value="">Seleccionar</option>
                                          <option value="1">Instalación</option>
                                          <option value="2">Reinstalación</option>
                                          <option value="3">Cuota mensual</option>
                                          <option value="4">Otros</option>
                                      </select>
                                  </div>
                              </div>
                              <div class="form-row">
                                  <div class="col-md-4">

                                      <label for="ventaCuentaDe">Impuesto seguridad</label>
                                      <input id="aplicarCesc" class="" onclick="getCesc()" type="radio" name="aplicarCesc" value="0.05" checked>
                                      <label for="5">5%</label>
                                      <input class="" type="radio" onclick="getCesc()" name="aplicarCesc" value="0.10">
                                      <label for="5">10%</label>
                                      <input class="" type="radio" onclick="getCesc()" name="aplicarCesc" value="0">
                                      <label for="5">Exento</label>
                                  </div>
                                  <div class="col-md-2">
                                      <label for="mesGenerar">Mes a generar</label>
                                      <select id="mesGenerar" class="form-control input-sm" name="mesGenerar" required>
                                          <option value="">Seleccionar</option>
                                          <option value="01">Enero</option>
                                          <option value="02">Febrero</option>
                                          <option value="03">Marzo</option>
                                          <option value="04">Abril</option>
                                          <option value="05">Mayo</option>
                                          <option value="06">Junio</option>
                                          <option value="07">Julio</option>
                                          <option value="08">Agosto</option>
                                          <option value="09">Septiembre</option>
                                          <option value="10">Octubre</option>
                                          <option value="11">Noviembre</option>
                                          <option value="12">Diciembre</option>
                                      </select>
                                  </div>
                                  <div class="col-md-2">
                                      <label for="anoGenerar">Año a generar</label>
                                      <input id="anoGenerar" class="form-control input-sm" type="number" name="anoGenerar" value="<?php echo date('Y') ?>" readonly>
                                  </div>
                                  <div class="col-md-2">
                                      <label for="montoCable">Monto cable</label>
                                      <input id="montoCable" class="form-control input-sm" type="text" name="montoCable" value="<?php echo $montoCable; ?>" readonly>
                                  </div>
                                  <div class="col-md-2">
                                      <label for="montoInternet">Monto internet</label>
                                      <input id="montoInternet" class="form-control input-sm" type="text" name="montoInternet" value="<?php echo $montoInternet; ?>" readonly>
                                  </div>

                              </div>

                              <div class="form-row">
                                  <div class="col-md-2">
                                      <label for="totalExento">Total exento</label>
                                      <input id="totalExento" class="form-control input-sm" type="text" id="totalExento" name="totalExento" value="<?php echo $totalExento; ?>" readonly>
                                  </div>
                                  <div class="col-md-2">
                                      <label for="totalAfecto">Total afecto</label>
                                      <input id="totalAfecto" class="form-control input-sm" type="text" id="totalAfecto" name="totalAfecto" value="<?php echo $totalAfecto; ?>" readonly>
                                  </div>
                                  <div class="col-md-2">
                                      <label for="iva">IVA</label>
                                      <input id="iva" class="form-control input-sm" type="text" id="iva" name="iva" value="<?php echo $iva; ?>" readonly>
                                  </div>
                                  <div class="col-md-2">
                                      <label for="impuesto">Impuesto</label>
                                      <input id="impuesto" class="form-control input-sm" type="text" id="impuesto" name="impuesto" value="<?php echo $impuesto; ?>" readonly>
                                  </div>
                                  <div class="col-md-2">
                                      <label for="percepcion">Percepcion</label>
                                      <input id="percepcion" class="form-control input-sm" type="text" id="percepcion" name="percepcion" value="<?php echo $percepcion; ?>" readonly>
                                  </div>
                                  <div class="col-md-2">
                                      <label for="total">Total</label>
                                      <input id="total" class="form-control input-sm alert-danger" type="text" id="total" name="total" value="<?php echo $total; ?>" readonly>
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
        <div id="buscarVentaManual" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Buscar venta anulada</h4>
              </div>
              <div class="modal-body">
                  <div class="row">
                      <div class="col-md-12">
                          <input class="form-control" type="text" name="caja_busqueda" id="caja_busqueda" placeholder="N°comprobante, Fecha comprobante, Código cliente, Nombre cliente, Dirección">
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
    <script src="js/ventasAnuladas.js"></script>
    <!--<script src="js/ordenTraslado.js"></script>-->
    <script src="js/searchvm.js"></script>
    <script type="text/javascript">
        // Get the input field
        var cod = document.getElementById("codigoCliente");

        $('#ventaManual').on('keyup keypress', function(e) {
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
        window.location="facturacionManual.php?codigoCliente="+codValue;
        }
        });
    </script>
    <script type="text/javascript">
        // Get the input field
        var montoCable = document.getElementById("montoCable");

        $('#ventaManual').on('keyup keypress', function(e) {
          var keyCode = e.keyCode || e.which;
          if (keyCode === 13) {
            e.preventDefault();
            return false;
          }
        });

        // Execute a function when the user releases a key on the keyboard
        montoCable.addEventListener("keyup", function(event) {
        // Number 13 is the "Enter" key on the keyboard
        if (event.keyCode === 13) {
        // Cancel the default action, if needed
        event.preventDefault();
        var montoCable = document.getElementById("montoCable").value;
        // Trigger the button element with a click
        totalSinIva = String(parseFloat(montoCable)/1.13).substring(0, 5);

        document.getElementById("totalExento").value = '0.00';
        var totalAfecto = document.getElementById("totalAfecto").value;
        document.getElementById("totalAfecto").value = parseFloat(totalAfecto) + parseFloat(montoCable);
        var cesc = document.getElementById("impuesto").value;
        //document.getElementById("total").value = montoCable;
        var totalImpuesto = String(parseFloat(cesc)*parseFloat(totalSinIva)).substring(0, 4);
        var total = document.getElementById("total").value;
        document.getElementById("total").value = String(parseFloat(total) + parseFloat(montoCable) + parseFloat(totalImpuesto)).substring(0, 5);
        }
        });
    </script>
    <script type="text/javascript">
        // Get the input field
        var montoInter = document.getElementById("montoInternet");

        $('#ventaManual').on('keyup keypress', function(e) {
          var keyCode = e.keyCode || e.which;
          if (keyCode === 13) {
            e.preventDefault();
            return false;
          }
        });

        // Execute a function when the user releases a key on the keyboard
        montoInter.addEventListener("keyup", function(event) {
        // Number 13 is the "Enter" key on the keyboard
        if (event.keyCode === 13) {
        // Cancel the default action, if needed
        event.preventDefault();
        var montoInter = document.getElementById("montoInternet").value;
        // Trigger the button element with a click
        totalSinIva = String(parseFloat(montoInter)/1.13).substring(0, 5);

        document.getElementById("totalExento").value = '0.00';
        var totalAfecto = document.getElementById("totalAfecto").value;
        document.getElementById("totalAfecto").value = parseFloat(totalAfecto) + parseFloat(montoInter);
        var cesc = document.getElementById("impuesto").value;
        //document.getElementById("total").value = montoInter;
        var totalImpuesto = String(parseFloat(cesc)*parseFloat(totalSinIva)).substring(0, 4);
        var total = document.getElementById("total").value;
        document.getElementById("total").value = String(parseFloat(total) + parseFloat(montoInter) + parseFloat(totalImpuesto)).substring(0, 5);
        }
        });
    </script>
    <?php
    if (isset($_GET['codigoCliente'])) {
        echo "<script>
            token = false;
            document.getElementById('ventaManual').action = 'php/generarFacturaManual.php';
            //document.getElementById('btn-cable').disabled = false;
            //document.getElementById('btn-internet').disabled = false;
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
            //document.getElementById('hora').value = time;
            document.getElementById('totalExento').value = '0.00';
            document.getElementById('totalAfecto').value = '0.00';
            document.getElementById('total').value = '0.00';
        </script>";
    }
    /*if (isset($_GET['nOrden'])) {
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

</body>

</html>
