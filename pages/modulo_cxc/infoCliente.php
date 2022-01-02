<?php
if (!isset($_SESSION)) {
    session_start([
        'cookie_lifetime' => 86400,
    ]);
}
require_once("../../php/config.php");
$host = DB_HOST;
$user = DB_USER;
$password = DB_PASSWORD;
$database = $_SESSION['db'];
$mysqli = new mysqli($host, $user, $password, $database);

require($_SERVER['DOCUMENT_ROOT'] . '/satpro' . '/php/permissions.php');
$permisos = new Permissions();
$permisosUsuario = $permisos->getPermissions($_SESSION['id_usuario']);

// get passed parameter value, in this case, the record ID
// isset() is a PHP function used to verify if a value is there or not
if (isset($_GET['id'])) {
    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record no encontrado.');

    //include database connection
    require_once '../../php/connection.php';

    $precon = new ConectionDB($_SESSION['db']);
    $con = $precon->ConectionDB($_SESSION['db']);

    // read current record's data

    

    try {
        $usuariotipo = $_SESSION["rol"];
        // prepare select query
        $query = "SELECT * FROM clientes WHERE cod_cliente = ? LIMIT 0,1";
        $stmt = $con->prepare($query);

        // this is the first question mark
        $stmt->bindParam(1, $id);

        // execute our query
        $stmt->execute();

        // store retrieved row to a variable
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        /****************** DATOS GENERALES ***********************/
        $idCuenta = $row['id_cuenta'];
        $estado_cable = $row['servicio_suspendido']; // 0 o 1 SIN Servicio
        $sinServicio = $row['sin_servicio']; // T o F
        $estado_internet = $row['estado_cliente_in']; // 1, 2, 3
        $codigo = $row["cod_cliente"];
        $nContrato = $row["numero_contrato"];
        $nFactura = $row["num_factura"];
        $nombre = trim(ucwords(strtolower($row['nombre'])));

        $nombre_comercial = strtoupper($row['nombre_comercial']);
        $nacionalidad = $row['nacionalidad'];
        $tipo_de_contrato = $row["tipo_de_contrato"];

        //$empresa = $row["empresa"];
        $nRegistro = $row["num_registro"];
        $dui = trim(ucwords(strtolower($row['numero_dui'])));
        $lugarExp = trim(ucwords(strtolower($row['lugar_exp'])));
        $nit = trim(ucwords(strtolower($row['numero_nit'])));

        if (strlen($row['fecha_nacimiento']) < 8) {
            $fechaNacimiento = "";
        } else {
            $fechaNacimiento = DateTime::createFromFormat('Y-m-d', trim($row['fecha_nacimiento']));
            $fechaNacimiento = $fechaNacimiento->format('d/m/Y');
        }

        $direccion = $row["direccion"];
        $departamento = $row["id_departamento"];
        $municipio = $row["id_municipio"];
        $colonia = $row["id_colonia"];
        $direccionCobro = $row["direccion_cobro"];
        $telefonos = $row['telefonos'];
        $telTrabajo = $row['tel_trabajo'];
        $ocupacion = $row['profesion'];
        //$cuentaContable = $row['id_cuenta'];
        $formaFacturar = $row['forma_pago']; //Contado o al crédito
        $saldoCable = number_format($row['saldoCable'], 2);
        $saldoInter = number_format($row['saldoInternet'], 2);
        $saldoActual = number_format($row['saldo_actual'], 2);
        $diasCredito = $row['dias_credito'];
        $limiteCredito = $row['limite_credito'];
        $tipoComprobante = $row['tipo_comprobante']; //Credito fiscal o consumidor final
        $facebook = $row['facebook'];
        $correo = $row['correo_electronico'];
        $calidad = $row['entrega_calidad'];
        $observaciones = $row['observaciones'];
        //var_dump($calidad);
        $nAnexo = $row['Anexo'];

        /****************** OTROS DATOS ***********************/
        $cobrador = $row['cod_cobrador'];
        $contacto1 = $row['contactos'];
        $contacto2 = $row['contacto2'];
        $contacto3 = $row['contacto3'];
        $telCon1 = $row['telcon1'];
        $telCon2 = $row['telcon2'];
        $telCon3 = $row['telcon3'];
        $paren1 = $row['paren1'];
        $paren2 = $row['paren2'];
        $paren3 = $row['paren3'];
        $dir1 = $row['dir1'];
        $dir2 = $row['dir2'];
        $dir3 = $row['dir3'];

        /****************** DATOS CABLE ***********************/
        $fechaInstalacion = date_format(date_create($row['fecha_instalacion']), "d/m/Y");
        //var_dump($fechaInstalacion);
        $fechaPrimerFactura = date_format(date_create($row['fecha_primer_factura']), "d/m/Y");
        $exento = $row['exento'];
        $diaCobro = $row['dia_cobro'];
        if ($diaCobro == 0) {
            $diaCobro = "";
        }

        $cortesia = $row['servicio_cortesia'];
        $cuotaMensualCable = number_format($row['valor_cuota'], 2);
        if ($cuotaMensualCable == 0) {
            $cuotaMensualCable = "";
        }
        $prepago = number_format($row['prepago'], 2);
        if ($prepago == 0) {
            $prepago = "";
        }
        $prepago_in = number_format($row['prepago_in'], 2);
        if ($prepago_in == 0) {
            $prepago_in = "";
        }
        $tipoComprobante = $row['tipo_comprobante'];
        $tipoServicio = $row['tipo_servicio'];
        $mactv = $row['mactv'];
        $periodoContratoCable = trim($row['periodo_contrato_ca']);
        if ($periodoContratoCable == 0) {
            $periodoContratoCable = "";
        }
        $vencimientoCable = $row['vencimiento_ca'];
        if (strlen($row['vencimiento_ca']) < 8) {
            $vencimientoCable = "";
        } else {
            $vencimientoCable = DateTime::createFromFormat('Y-m-d', trim($row['vencimiento_ca']));
            $vencimientoCable = $vencimientoCable->format('d/m/Y');
        }
        //var_dump($row['fecha_instalacion']);
        if (strlen($row['fecha_instalacion']) < 8) {
            $fechaInstalacion = "";
        } else {
            $fechaInstalacion = DateTime::createFromFormat('Y-m-d', trim($row['fecha_instalacion']));
            $fechaInstalacion = $fechaInstalacion->format('d/m/Y');
        }

        if (strlen($row['fecha_primer_factura']) < 8) {
            $fechaPrimerFactura = "";
        } else {
            $fechaPrimerFactura = DateTime::createFromFormat('Y-m-d', trim($row['fecha_primer_factura']));
            $fechaPrimerFactura = $fechaPrimerFactura->format('d/m/Y');
        }

        if (strlen($row['fecha_suspencion']) < 8) {
            $fechaSuspensionCable = "";
        } else {
            $fechaSuspensionCable = DateTime::createFromFormat('Y-m-d', trim($row['fecha_suspencion']));
            $fechaSuspensionCable = $fechaSuspensionCable->format('d/m/Y');
        }

        if (strlen($row['fecha_reinstalacion']) < 8) {
            $fechaReinstalacionCable = "";
        } else {
            $fechaReinstalacionCable = DateTime::createFromFormat('Y-m-d', trim($row['fecha_reinstalacion']));
            $fechaReinstalacionCable = $fechaReinstalacionCable->format('d/m/Y');
        }
        $tecnicoCable = $row['id_tecnico'];
        $direccionCable = $row['dire_cable'];
        $nDerivaciones = $row['numero_derivaciones'];
        if ($nDerivaciones == 0) {
            $nDerivaciones = "";
        }

        /****************** DATOS INTERNET ***********************/
        if (strlen($row['fecha_instalacion_in']) < 8) {
            $fechaInstalacionInter = "";
        } else {
            $fechaInstalacionInter = DateTime::createFromFormat('Y-m-d', trim($row['fecha_instalacion_in']));
            $fechaInstalacionInter = $fechaInstalacionInter->format('d/m/Y');
        }

        if (strlen($row['fecha_primer_factura_in']) < 8) {
            $fechaPrimerFacturaInter = "";
        } else {
            $fechaPrimerFacturaInter = DateTime::createFromFormat('Y-m-d', trim($row['fecha_primer_factura_in']));
            $fechaPrimerFacturaInter = $fechaPrimerFacturaInter->format('d/m/Y');
        }

        $tipoServicioInternet = $row['tipo_servicio_in'];
        $periodoContratoInternet = trim($row['periodo_contrato_int']);
        if ($periodoContratoInternet == 0) {
            $periodoContratoInternet = "";
        }
        $diaCobroInter = $row['dia_corbo_in'];
        if ($diaCobroInter == 0) {
            $diaCobroInter = "";
        }
        $velocidadInter = $row['id_velocidad'];
        $cuotaMensualInter = number_format($row['cuota_in'], 2);
        if ($cuotaMensualInter == 0) {
            $cuotaMensualInter = "";
        }
        $tipoClienteInter = $row['id_tipo_cliente'];
        $tecnologia = $row['tecnologia'];
        $nContratoInter = $row['no_contrato_inter'];
        if (strlen($row['vencimiento_in']) < 8) {
            $vencimientoInternet = "";
        } else {
            $vencimientoInternet = DateTime::createFromFormat('Y-m-d', trim($row['vencimiento_in']));
            $vencimientoInternet = $vencimientoInternet->format('d/m/Y');
        }

        if (strlen($row['ult_ren_in']) < 8) {
            $ultimaRenovacionInternet = "";
        } else {
            $ultimaRenovacionInternet = DateTime::createFromFormat('Y-m-d', trim($row['ult_ren_in']));
            $ultimaRenovacionInternet = $ultimaRenovacionInternet->format('d/m/Y');
        }

        if (strlen($row['fecha_suspencion_in']) < 8) {
            $fechaSuspencionInternet = "";
        } else {
            $fechaSuspencionInternet = DateTime::createFromFormat('Y-m-d', trim($row['fecha_suspencion_in']));
            $fechaSuspencionInternet = $fechaSuspencionInternet->format('d/m/Y');
        }

        if (strlen($row['fecha_reconexion_in']) < 8) {
            $fechaReconexionInternet = "";
        } else {
            $fechaReconexionInternet = DateTime::createFromFormat('Y-m-d', trim($row['fecha_reconexion_in']));
            $fechaReconexionInternet = $fechaReconexionInternet->format('d/m/Y');
        }

        $promocion = $row['id_promocion'];
        if (strlen($row['dese_promocion_in']) < 8) {
            $promocionDesde = "";
        } else {
            $promocionDesde = DateTime::createFromFormat('Y-m-d', trim($row['dese_promocion_in']));
            $promocionDesde = $promocionDesde->format('d/m/Y');
        }

        if (strlen($row['hasta_promocion_in']) < 8) {
            $promocionHasta = "";
        } else {
            $promocionHasta = DateTime::createFromFormat('Y-m-d', trim($row['hasta_promocion_in']));
            $promocionHasta = $promocionHasta->format('d/m/Y');
        }
        $cuotaPromocion = $row['cuota_promocion'];
        $direccionInternet = $row['dire_internet'];
        $tecnicoInternet = $row['id_tecnico_in'];
        $colilla = $row['colilla'];
        $modelo = $row['marca_modem'];
        $recepcion = $row['recep_modem'];
        $wanip = $row['wanip'];
        $mac = $row['mac_modem'];
        $transmision = $row['trans_modem'];
        $coordenadas = $row['coordenadas'];
        $serie = $row['serie_modem'];
        $ruido = $row['ruido_modem'];
        $nodo = $row['dire_telefonia'];
        $wifiClave = $row['clave_modem'];
        $costoInstalacionIn = $row['costo_instalacion_in'];

        /**********************COVID19***********************/
        $cuotaCovidC = number_format($row['cuotaCovidC'], 2);

        if (strlen($row['covidDesdeC']) < 8) {
            $covidDesdeC = "";
        } else {
            $covidDesdeC = DateTime::createFromFormat('Y-m-d', trim($row['covidDesdeC']));
            $covidDesdeC = $covidDesdeC->format('d/m/Y');
        }
        if (strlen($row['covidHastaC']) < 8) {
            $covidHastaC = "";
        } else {
            $covidHastaC = DateTime::createFromFormat('Y-m-d', trim($row['covidHastaC']));
            $covidHastaC = $covidHastaC->format('d/m/Y');
        }
        //$covidDesdeC = $row['covidDesdeC'];
        //$covidHastaC = $row['covidHastaC'];

        $cuotaCovidI = number_format($row['cuotaCovidI'], 2);

        if (strlen($row['covidDesdeI']) < 8) {
            $covidDesdeI = "";
        } else {
            $covidDesdeI = DateTime::createFromFormat('Y-m-d', trim($row['covidDesdeI']));
            $covidDesdeI = $covidDesdeI->format('d/m/Y');
        }
        if (strlen($row['covidHastaI']) < 8) {
            $covidHastaI = "";
        } else {
            $covidHastaI = DateTime::createFromFormat('Y-m-d', trim($row['covidHastaI']));
            $covidHastaI = $covidHastaI->format('d/m/Y');
        }
        //$covidDesdeI = $row['covidDesdeI'];
        //$covidHastaI = $row['covidHastaI'];

    }

    // show error
    catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
    }
} elseif (isset($_GET['action'])) {
    /****************** DATOS GENERALES ***********************/
    $estado_cable = ""; // 0 o 1
    $sinServicio = ""; // 0 o 1
    $estado_internet = ""; // 1, 2, 3
    $codigo = "";
    $nContrato = "";
    $nFactura = "";
    $nombre = "";
    $nombre_comercial = "";
    $nacionalidad = "";
    $tipo_de_contrato = "";
    $empresa = "";
    $nRegistro = "";
    $dui = "";
    $lugarExp = "";
    $nit = "";
    $fechaNacimiento = "";
    $direccion = "";
    $departamento = "";
    $municipio = "";
    $colonia = "";
    $direccionCobro = "";
    $telefonos = "";
    $telTrabajo = "";
    $ocupacion = "";
    $idCuenta = "";
    $cuentaContable = "";
    $formaFacturar = ""; //Contado o al crédito
    $saldoActual = "";
    $diasCredito = "";
    $limiteCredito = "";
    $tipoFacturacion = ""; //Credito fiscal o consumidor final
    $facebook = "";
    $correo = "";

    /****************** OTROS DATOS ***********************/
    $cobrador = "";
    $contacto1 = "";
    $contacto2 = "";
    $contacto3 = "";
    $telCon1 = "";
    $telCon2 = "";
    $telCon3 = "";
    $paren1 = "";
    $paren2 = "";
    $paren3 = "";
    $dir1 = "";
    $dir2 = "";
    $dir3 = "";
    $observaciones = "";

    /****************** DATOS CABLE ***********************/
    $fechaInstalacion = "";
    $fechaPrimerFactura = "";
    $fechaSuspensionCable = "";
    $exento = "F";
    $diaCobro = "";
    $cortesia = "F";
    $cuotaMensualCable = "";
    $prepago = "";
    $prepago_in = "";
    $tipoComprobante = "";
    $tipoServicio = "";
    $mactv = "";
    $periodoContratoCable = "";
    $vencimientoCable = "";
    $fechaInstalacionCable = "";
    $fechaReinstalacionCable = "";
    $tecnicoCable = "";
    $direccionCable = "";
    $nDerivaciones = "";

    /****************** DATOS INTERNET ***********************/
    $fechaInstalacionInter = "";
    $fechaPrimerFacturaInter = "";
    $tipoServicioInternet = "";
    $nodo = "";
    $periodoContratoInternet = "";
    $diaCobroInter = "";
    $velocidadInter = "";
    $cuotaMensualInter = "";
    $tipoClienteInter = "";
    $tecnologia = "";
    $nContratoInter = "";
    $vencimientoInternet = "";
    $ultimaRenovacionInternet = "";
    $fechaSuspencionInternet = "";
    $fechaReconexionInternet = "";
    $promocion = "";
    $promocionDesde = "";
    $promocionHasta = "";
    $cuotaPromocion = "";
    $direccionInternet = "";
    $colilla = "";
    $modelo = "";
    $recepcion = "";
    $wanip = "";
    $mac = "";
    $transmision = "";
    $coordenadas = "";
    $serie = "";
    $ruido = "";
    $wifiClave = "";
    $counter = 1;
    $nAnexo = "";

    /**********************COVID19***********************/
    $cuotaCovidC = "";
    $covidDesdeC = "";
    $covidHastaC = "";
    $cuotaCovidI = "";
    $covidDesdeI = "";
    $covidHastaI = "";
}
?>
<?php
require_once 'php/GetAllInfo.php';
require_once 'php/getData.php';
require_once 'php/getAllClients.php';
$allClients = new GetAllClients();
$data = new GetAllInfo();
$data2 = new OrdersInfo();
$arrDepartamentos = $data->getData('tbl_departamentos_cxc');
$arrMunicipios = $data->getData('tbl_municipios_cxc');
$arrColonias = $data->getDataCols('tbl_colonias_cxc');
$arrMunicipiosSearch = $data->getMunSearch('tbl_municipios_cxc', $_SESSION['db']);
//$arrColoniasSearch = $data->getDataCols('tbl_colonias_cxc', $_SESSION['db']);
$arrFormaFacturar = $data->getData('tbl_forma_pago');
$arrCobradores = $data->getData('tbl_cobradores');
$arrComprobantes = $data->getData('tbl_tipo_comprobante');
$arrServicioCable = $data->getData('tbl_servicios_cable');
$arrServicioInter = $data->getData('tbl_servicios_inter');
$arrVelocidad = $data->getData('tbl_velocidades');
$arrTecnicos = $data->getData('tbl_tecnicos_cxc');
$arrTecnologias = $data->getData('tbl_tecnologias');
$arrTiposClientes = $data->getData('tbl_tipos_clientes');
//Array de ordenes de trabajo por cliente
$arrOrdenesTrabajo = $data->getDataOrders('tbl_ordenes_trabajo', $codigo, 'idOrdenTrabajo');
$arrOrdenesSuspension = $data->getDataOrders('tbl_ordenes_suspension', $codigo, 'idOrdenSuspension');
$arrOrdenesReconex = $data->getDataOrders('tbl_ordenes_reconexion', $codigo, 'idOrdenReconex');
$arrTraslados = $data->getDataOrders('tbl_ordenes_traslado', $codigo, 'idOrdenTraslado');

$alert = $data->getDataOrdersAlert('tbl_ordenes_trabajo');

if (strlen($alert) > 3) {
    echo "<script>alert('ADVERTENCIA PARA EL NODO/ANTENA " . strtoupper($alert) . "')</script>";
}
?>
<!DOCTYPE html>
<html lang="es">

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
    <link rel="stylesheet" href="../../dist/css/switches.css">

    <!-- Morris Charts CSS -->
    <link href="../../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- DataTables CSS -->
    <!--<link rel="stylesheet" href="../vendor/datatables/css/dataTables.bootstrap.min.css"> -->
    <!--<link rel="stylesheet" href="../vendor/datatables/css/jquery.dataTables.min.css"> -->
    <style media="screen">
        .form-control {
            color: #212121;
            font-size: 17px;
            font-weight: normal;

        }

        .nav>li>a {
            color: #fff;
        }

        .dark {
            color: #fff;
            background-color: #212121;
        }
    </style>

    <style media="screen">
        .nav-pills>li.active>a,
        .nav-pills>li.active>a:focus,
        .nav-pills>li.active>a:hover {
            color: #fff;
            background-color: #d32f2f;
        }

        .nav-pills>li>a {
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

        .panel {
            border-color: #212121;
        }

        .modal-dialog {
            width: 1300px;
        }

        /* Important part */
        .modal-dialog {
            overflow-y: initial !important
        }

        .modal-body {
            height: 500px;
            overflow-y: auto;
            font-size: 11px;
            font-weight: normal;
        }
    </style>

    <!-- SWEETALERT -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.css" />
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.js"></script>
</head>

<body>

    <?php
    // session_start();
    if (!isset($_SESSION["user"])) {
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

            <ul class="nav navbar-top-links navbar-left">
                <li class="dropdown procesos">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        Procesos <i class="fas fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a onclick="window.open('ordenTrabajo.php?codigoCliente=<?php echo str_pad($_GET["id"], 5, "0", STR_PAD_LEFT); ?>','','height=600,width=1000,top=-300,left=200')">Ordenes de trabajo</a>
                        </li>
                        <li><a onclick="window.open('ordenSuspension.php?codigoCliente=<?php echo str_pad($_GET["id"], 5, "0", STR_PAD_LEFT); ?>','','height=600,width=1000,top=-300,left=200')">Ordenes de suspensión</a>
                        </li>
                        <li><a onclick="window.open('ordenReconexion.php?codigoCliente=<?php echo str_pad($_GET["id"], 5, "0", STR_PAD_LEFT); ?>','','height=600,width=1000,top=-300,left=200')">Ordenes de reconexión</a>
                        </li>
                        <li><a onclick="window.open('ordenTraslado.php?codigoCliente=<?php echo str_pad($_GET["id"], 5, "0", STR_PAD_LEFT); ?>','','height=600,width=1000,top=-300,left=200')">Ordenes de traslado</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown procesos">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        Documentación <i class="fas fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a onclick="window.open('php/f3.php<?php echo "?id=" . $id; ?>','','height=600,width=1000,top=-300,left=200')">Documento F-3</a>
                        </li>
                        <li><a onclick="window.open('php/f4.php<?php echo "?id=" . $id; ?>','','height=600,width=1000,top=-300,left=200')">Documento F-4</a>
                        </li>
                        <li><a onclick="window.open('php/f5.php<?php echo "?id=" . $id; ?>','','height=600,width=1000,top=-300,left=200')">Documento F-5</a>
                        </li>
                        <li><a onclick="window.open('php/f9.php<?php echo "?id=" . $id; ?>','','height=600,width=1000,top=-300,left=200')">Documento F-9</a>
                        </li>
                        <li><a onclick="window.open('php/allDoc.php<?php echo "?id=" . $id; ?>','','height=600,width=1000,top=-300,left=200')">Documentación completa</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <?php echo "<i class='far fa-user'></i>" . " " . $_SESSION['nombres'] . " " . $_SESSION['apellidos'] ?> <i class="fas fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="perfil.php"><i class="fas fa-user-circle"></i> Perfil</a>
                        </li>
                        <li><a href="config.php"><i class="fas fa-cog"></i> Configuración</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="../../php/logout.php"><i class="fas fa-sign-out-alt"></i> Salir</a>
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
                        } else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], CONTABILIDAD)) {
                            echo "<li><a href='../modulo_contabilidad/contabilidad.php'><i class='fas fa-money-check-alt'></i> Contabilidad</a></li>";
                        } else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], PLANILLA)) {
                            echo "<li><a href='../modulo_planillas/planillas.php'><i class='fas fa-file-signature'></i> Planillas</a></li>";
                        } else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], ACTIVOFIJO)) {
                            echo "<li><a href='../modulo_activoFijo/activoFijo.php'><i class='fas fa-building'></i> Activo fijo</a></li>";
                        } else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], INVENTARIO)) {
                            echo "<li><a href='../moduloInventario.php'><i class='fas fa-scroll'></i> Inventario</a></li>";
                        } else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], IVA)) {
                            echo "<li><a href='../modulo_iva/iva.php'><i class='fas fa-file-invoice-dollar'></i> IVA</a></li>";
                        } else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], BANCOS)) {
                            echo "<li><a href='../modulo_bancos/bancos.php'><i class='fas fa-university'></i> Bancos</a></li>";
                        } else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], CXC)) {
                            echo "<li><a href='../modulo_cxc/cxc.php'><i class='fas fa-hand-holding-usd'></i> Cuentas por cobrar</a></li>";
                        } else {
                            echo "";
                        }
                        if (setMenu($_SESSION['permisosTotalesModulos'], CXP)) {
                            echo "<li><a href='../modulo_cxp/cxp.php'><i class='fas fa-money-bill-wave'></i> Cuentas por pagar</a></li>";
                        } else {
                            echo "";
                        }
                        ?>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        <div class="" id="page-wrapper">
            <div class="row">
                <div class="col-md-8">
                    <table class="table table-responsive">
                        <tr>
                            <td><button class="btn btn-danger btn-block"><i class="far fa-user fa-2x"></i> <?php echo $allClients->getLast(); ?></button></td>
                            <td><button class="btn btn-danger btn-block" data-toggle="modal" data-target="#buscarCliente"><i class="fas fa-search fa-2x"></i></button></td>
                            <td><button class="btn btn-danger btn-block" id="btn-editar" name="editar" onclick="editarCliente();" title="Editar"><i class="far fa-edit fa-2x"></i></button></td>
                            <td><button id="btn-nuevo" name="agregar" onclick="nuevoCliente();" class="btn btn-danger btn-block" title="Nuevo"><i class="fas fa-user-plus fa-2x"></i></button></td>
                        </tr>

                        <tr>
                            <td><a onclick="window.open('php/contratoCable.php<?php echo "?id=" . $id; ?>','','height=600,width=1000,top=-300,left=200')" class="btn btn-danger btn-block" style="font-size: 16px;"><i class="far fa-file-alt"></i> Gestion de Contratos C</a></td>
                            <!-- -->
                            <td><button name="gestionCont" class="btn btn-danger btn-block" data-toggle="modal" data-target="#nuevoContratoI"><i class="far fa-file-alt" style=" font-size: 20px;" disabled></i> Gestion de Contratos I</button></td>
                            <!-- -->
                            <td><a onclick="window.location='estadoCuenta.php?codigoCliente=<?php echo $codigo; ?>'"><button class="btn btn-danger btn-block" style="font-size: 16px;"><i class="fas fa-file-invoice-dollar"></i> Estado de cuenta</button></a></td>
                            <form id="formClientes" class="" action="#" method="POST">
                                <td><button id="btn-guardar" class="btn btn-danger btn-block" title="Guardar" disabled><i class="fas fa-save fa-2x"></i></button></td>
                        </tr>
                        <!-- Inicio Prueba para ingresar nuevos contratos 
                        <tr>
                            <td><a onclick="window.open('php/contratoCableDigital.php<?php echo "?id=" . $id; ?>','','height=600,width=1000,top=-300,left=200')" class="btn btn-danger btn-block" style="font-size: 16px;"><i class="far fa-file-alt"></i> Contrato N. cable</a></td>
                            <td><a onclick="window.open('php/contratoInterDigitalN-2.php<?php echo "?id=" . $id; ?>','','height=600,width=1000,top=-300,left=200')" class="btn btn-danger btn-block" style="font-size: 16px;"><i class="far fa-file-alt"></i> Contrato N. Inter P</a></td>
                        </tr>

 Fin Prueba para ingresar nuevos contratos -->
                        <tr>
                            <td colspan="8"><textarea class="form-control alert-warning input-sm" name="notas" rows="2" cols="40" placeholder="Observaciones" readOnly><?php echo $observaciones; ?></textarea></td>
                        </tr>
                        <!--<tr>
                            <td><button class="btn btn-info btn-block" style="font-size: 16px; ;">Reporte</button></td>
                            <td colspan="2"><button class="btn btn-info btn-block" style="font-size: 16px; ;">Compromiso de internet</button></td>

                        </tr>-->
                    </table>
                </div>
                <div class="col-md-4">
                    <table style="margin-top: 9px;" class="table table-responsive table-bordered table-condensed">
                        <th class="dark"></th>
                        <th class="dark">Activo</th>
                        <th class="dark">Susp</th>
                        <th class="dark">Sin serv</th>
                        <?php

                        if (($estado_cable == "F" || $estado_cable == "") && $sinServicio == "F") {
                            echo "<tr class='dark'>
                                <th>TV</th>
                                <td><label class='switch'><input id='activoCable' onchange='cableTrue()' class='switch' type='radio' name ='cable' value='activo' checked disabled><span class='slider round'></span></label></td>
                                <td><label class='switch'><input id='suspendidoCable' onchange='cableTrue()' class='switch' type='radio' name ='cable' value='suspendido' disabled><span class='slider round'></span></label></td>
                                <td><label class='switch'><input id='sinCable' onchange='cableTrue()' class='switch' type='radio' name ='cable' value='sin' disabled><span class='slider round'></span></label></td>
                            </tr>";
                        } else if ($estado_cable == "T" && $sinServicio == "F") {
                            echo "<tr class='dark'>
                                <th>TV</th>
                                <td><label class='switch'><input id='activoCable' onchange='cableTrue()' class='switch' type='radio' name ='cable' value='activo' disabled><span class='slider round'></span></label></td>
                                <td><label class='switch'><input id='suspendidoCable' onchange='cableTrue()' class='switch' type='radio' name ='cable' value='suspendido' checked disabled><span class='slider round'></span></label></td>
                                <td><label class='switch'><input id='sinCable' onchange='cableTrue()' class='switch' type='radio' name ='cable' value='sin' disabled><span class='slider round'></span></label></td>
                            </tr>";
                        } elseif (($estado_cable == "F" || $estado_cable == "") && $sinServicio == "T") {
                            echo "<tr class='dark'>
                                <th>TV</th>
                                <td><label class='switch'><input id='activoCable' onchange='cableTrue()' class='switch' type='radio' name ='cable' value='activo' disabled required><span class='slider round'></span></label></td>
                                <td><label class='switch'><input id='suspendidoCable' onchange='cableTrue()' class='switch' type='radio' name ='cable' value='suspendido' disabled required><span class='slider round'></span></label></td>
                                <td><label class='switch'><input id='sinCable' onchange='cableTrue()' class='switch' type='radio' name ='cable' value='sin' checked disabled required><span class='slider round'></span></label></td>
                            </tr>";
                        } else {
                            echo "<tr class='dark'>
                                <th>TV</th>
                                <td><label class='switch'><input id='activoCable' onchange='cableTrue()' class='switch' type='radio' name ='cable' value='activo' disabled required><span class='slider round'></span></label></td>
                                <td><label class='switch'><input id='suspendidoCable' onchange='cableTrue()' class='switch' type='radio' name ='cable' value='suspendido' disabled required><span class='slider round'></span></label></td>
                                <td><label class='switch'><input id='sinCable' onchange='cableTrue()' class='switch' type='radio' name ='cable' value='sin' checked disabled required><span class='slider round'></span></label></td>
                            </tr>";
                        }
                        if ($estado_internet == 1) {
                            echo "<tr class='dark'>
                                <th>Internet</th>
                                <td><label class='switch'><input id='activoInter' onchange='internetTrue()' class='switch' type='radio' name='internet' value='activo' checked disabled><span class='slider round'></span></label></td>
                                <td><label class='switch'><input id='suspendidoInter' onchange='internetTrue()' class='switch' type='radio' name='internet' value='suspendido' disabled><span class='slider round'></span></label></td>
                                <td><label class='switch'><input id='sinInter' onchange='internetTrue()' class='switch' type='radio' name='internet' value='sin' disabled><span class='slider round'></span></label></td>
                            </tr>";
                        } elseif ($estado_internet == 2) {
                            echo "<tr class='dark'>
                                <th>Internet</th>
                                <td><label class='switch'><input id='activoInter' onchange='internetTrue()' class='switch' type='radio' name='internet' value='activo' disabled><span class='slider round'></span></label></td>
                                <td><label class='switch'><input id='suspendidoInter' onchange='internetTrue()' class='switch' type='radio' name='internet' value='suspendido' checked disabled><span class='slider round'></span></label></td>
                                <td><label class='switch'><input id='sinInter' onchange='internetTrue()' class='switch' type='radio' name='internet' value='sin' disabled><span class='slider round'></span></label></td>
                            </tr>";
                        } else {
                            echo "<tr class='dark'>
                                <th>Internet</th>
                                <td><label class='switch'><input id='activoInter' onchange='internetTrue()' class='switch' type='radio' name='internet' value='activo' disabled required><span class='slider round'></span></label></td>
                                <td><label class='switch'><input id='suspendidoInter' onchange='internetTrue()' class='switch' type='radio' name='internet' value='suspendido' disabled required><span class='slider round'></span></label></td>
                                <td><label class='switch'><input id='sinInter' onchange='internetTrue()' class='switch' type='radio' name='internet' value='sin' checked disabled required><span class='slider round'></span></label></td>
                            </tr>";
                        }
                        echo "<tr class='dark'>
                            <th>Teléfono</th>
                            <td><label class='switch'><input class='switch' type='radio' name='telefono' value='activo' disabled><span class='slider round'></span></label></td>
                            <td><label class='switch'><input class='switch' type='radio' name='telefono' value='suspendido' disabled><span class='slider round'></span></label></td>
                            <td><label class='switch'><input class='switch' type='radio' name='telefono' value='sin' checked disabled><span class='slider round'></span></label></td>
                        </tr>";
                        ?>
                    </table>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
<<<<<<< HEAD
                            <?php 
                                if (strtoupper($nombre) == 'CODIGO A REUTILIZAR') {
                                    ?>
                                    <span style="font-size:15px;" class="label label-warning"><?php echo $codigo; ?></span> <span><?php echo strtoupper($nombre); ?></span>
                                    <?php
                                }else{
                                    ?>
                                    <span style="font-size:15px;" class="label label-danger"><?php echo $codigo; ?></span> <span><?php echo strtoupper($nombre); ?></span>
                                    <?php
                                }
                            ?>
                            
                            <?php
                            if ($idCuenta == "covid19") {
                                echo '<span style="color: #d33333 ; font-weight: bold; font-size: 20px;">COVID-19 <i class="fas fa-biohazard"></i></span> <input class="" type="checkbox" name="aplicaCovid" checked>';
                            } else {
                                echo '<span style="color: #d33333 ; font-weight: bold; font-size: 20px;">COVID-19 <i class="fas fa-biohazard"></i></span> <input class="" type="checkbox" name="aplicaCovid">';
                            }
                            $rol = $_SESSION['rol'];
                                if ($rol == 'administracion' || $rol=='jefatura' || $rol=='subgerencia') {
                            ?>
                            <button type="button" class="reu btn btn-xs btn-danger" data="<?php echo $codigo; ?>"><i class="fas fa-recycle"></i></button>
                            <?php 
                                }
                            ?>
                            <span class="pull-right"><button class="btn btn-danger btn-xs" type="button" id="todoAtras" name="todoAtras" onclick="<?php echo 'todoAtras1(' . $allClients->getFirst() . ')' ?>"><i class="fas fa-fast-backward"></i></button>&nbsp;
                            <span class="pull-right"><button class="btn btn-danger btn-xs" type="button" id="atras" name="atras" onclick="<?php echo 'atras1(' . $_GET["id"] . ')' ?>"><i class="fas fa-step-backward"></i></button>&nbsp;
                            <span class="pull-right"><button class="btn btn-danger btn-xs" type="button" id="adelante" name="adelante" onclick="<?php echo 'adelante1(' . $_GET["id"] . ')' ?>"><i class="fas fa-step-forward"></i></button>&nbsp;
                            <span class="pull-right"><button class="btn btn-danger btn-xs" type="button" id="todoAdelante" name="todoAdelante" onclick="<?php echo 'todoAdelante1(' . $allClients->getLast() . ')' ?>"><i class="fas fa-fast-forward"></i></button></span>
=======
                            <span style="font-size:15px;" class="label label-danger"><?php echo $codigo; ?></span> <span><?php echo strtoupper($nombre); ?></span>
                            <?php
                            if ($idCuenta == "covid19") {
                                echo '<span style="color: #d33333 ; font-weight: bold; font-size: 20px;">COVID-19 <i class="fas fa-biohazard"></i></span> <input class="" type="checkbox" name="aplicaCovid" checked>';
                            } else {
                                echo '<span style="color: #d33333 ; font-weight: bold; font-size: 20px;">COVID-19 <i class="fas fa-biohazard"></i></span> <input class="" type="checkbox" name="aplicaCovid">';
                            }
                            ?>
                            <span class="pull-right"><button class="btn btn-danger btn-xs" type="button" id="todoAtras" name="todoAtras" onclick="<?php echo 'todoAtras1(' . $allClients->getFirst() . ')' ?>"><i class="fas fa-fast-backward"></i></button>&nbsp;
                                <span class="pull-right"><button class="btn btn-danger btn-xs" type="button" id="atras" name="atras" onclick="<?php echo 'atras1(' . $_GET["id"] . ')' ?>"><i class="fas fa-step-backward"></i></button>&nbsp;
                                    <span class="pull-right"><button class="btn btn-danger btn-xs" type="button" id="adelante" name="adelante" onclick="<?php echo 'adelante1(' . $_GET["id"] . ')' ?>"><i class="fas fa-step-forward"></i></button>&nbsp;
                                        <span class="pull-right"><button class="btn btn-danger btn-xs" type="button" id="todoAdelante" name="todoAdelante" onclick="<?php echo 'todoAdelante1(' . $allClients->getLast() . ')' ?>"><i class="fas fa-fast-forward"></i></button>
                                        </span>
>>>>>>> 8404f3d80dcbc2494a76c11cd1ac9cae57de7f40
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">

                            <!-- Nav tabs -->
                            <ul class="nav nav-pills nav-justified red">
                                <li class="active"><a href="#datos-generales" data-toggle="tab">DATOS GENERALES</a>
                                </li>
                                <li><a href="#otros-datos" data-toggle="tab">OTROS DATOS</a>
                                </li>
                                <li><a href="#servicios" data-toggle="tab">SERVICIOS</a>
                                </li>
                                <li><a href="#ordenes-tecnicas" data-toggle="tab">ORDENES TÉCNICAS</a>
                                </li>
                                <li><a href="#notificaciones-traslados" data-toggle="tab">TRASLADOS</a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="datos-generales">
                                    <br>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="codigo">Código del cliente</label>
                                            <input class="form-control input-sm" type="text" name="codigo" value="<?php echo $codigo; ?>" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="contrato">N° de contrato (CABLE)</label>
                                            <input class="form-control input-sm alert-danger" type="text" name="contrato" value="<?php echo $nContrato; ?>" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="factura">Número de factura</label>
                                            <input class="form-control input-sm" type="text" name="factura" value="<?php echo $nFactura; ?>" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="nAnexo">Número de anexo</label>
                                            <input class="form-control input-sm alert-danger" type="text" name="nAnexo" value="<?php echo $nAnexo; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-9">
                                            <label for="nombre"><span style="color:red;font-size:18px;">**</span>Nombre</label>
                                            <input class="form-control input-sm alert-danger" type="text" name="nombre" value="<?php echo $nombre; ?>" readonly required>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="ncr">Número de registro</label>
                                            <input class="form-control input-sm" type="text" id="nrc" name="nrc" value="<?php echo $nRegistro; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-9">
                                            <label for="nombre">Nombre Comercial</label>
                                            <input class="form-control input-sm" type="text" name="nombre_comercial" value="<?php echo $nombre_comercial; ?>" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="nacionalidad"><span style="color:red;font-size:18px;">**</span>Nacionalidad</label>
                                            <input class="form-control input-sm alert-danger" type="text" id="nacionalidad" name="nacionalidad" value="<?php echo $nacionalidad; ?>" readonly required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <!--<div class="col-md-9">
                                            <label for="empresa">Empresa</label>
                                            <input class="form-control input-sm" type="text" name="empresa" value="<?php //echo $empresa; 
                                                                                                                    ?>" readonly>
                                        </div>-->
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="saldoCable">Saldo actual cable</label>
                                            <input class="form-control input-sm" type="text" name="saldoCable" value="<?php echo round($saldoCable, 2); ?>" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="saldoInternet">Saldo actual internet</label>
                                            <input class="form-control input-sm" type="text" name="saldoInternet" value="<?php echo round($saldoInter, 2); ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label for="dui"><span style="color:red;font-size:18px;">**</span>DUI</label>
                                            <input class="form-control input-sm alert-danger" type="text" id="dui" name="dui" pattern="[0-9]{8}-[0-9]{1}" value="<?php echo $dui; ?>" readonly required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="expedicion">Lugar y fecha de expedición</label>
                                            <input class="form-control input-sm" type="text" name="expedicion" value="<?php echo $lugarExp; ?>" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="nit">NIT</label>
                                            <input class="form-control input-sm" type="text" id="nit" name="nit" value="<?php echo $nit; ?>" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="fechaNacimiento">Fecha de nacimiento</label>
                                            <input class="form-control input-sm" type="text" id="fechaNacimiento" name="fechaNacimiento" value="<?php echo $fechaNacimiento; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="direccion">Dirección</label>
                                            <textarea class="form-control input-sm" name="direccion" rows="2" cols="40" readonly><?php echo htmlentities($direccion); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="departamento"><span style="color:red;font-size:18px;">**</span>Departamento</label>
                                            <select class="form-control input-sm alert-danger" id="departamento" name="departamento" disabled required>
                                                <option value="" selected>Seleccionar</option>
                                                <?php
                                                foreach ($arrDepartamentos as $key) {
                                                    if ($key['idDepartamento'] == $departamento) {
                                                        echo "<option value=" . $key['idDepartamento'] . " selected>" . $key['nombreDepartamento'] . "</option>";
                                                    } else {
                                                        echo "<option value=" . $key['idDepartamento'] . ">" . $key['nombreDepartamento'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="municipio"><span style="color:red;font-size:18px;">**</span>Municipio</label>
                                            <select class="form-control input-sm alert-danger" id="municipio" name="municipio" disabled required>
                                                <option value="" selected>Seleccionar</option>
                                                <?php
                                                foreach ($arrMunicipios as $key) {
                                                    if ($key['idMunicipio'] == $municipio) {
                                                        echo "<option value=" . $key['idMunicipio'] . " selected>" . $key['nombreMunicipio'] . "</option>";
                                                    } else {
                                                        echo "<option value=" . $key['idMunicipio'] . ">" . $key['nombreMunicipio'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <label for="colonia"><span style="color:red;font-size:18px;">**</span>Barrio o colonia</label>
                                            <select class="form-control input-sm alert-danger" id="colonia" name="colonia" disabled required>
                                                <option value="" selected>Seleccionar</option>
                                                <?php
                                                foreach ($arrColonias as $key) {
                                                    if ($key['idColonia'] == $colonia) {
                                                        echo "<option value=" . $key['idColonia'] . " selected>" . $key['nombreColonia'] . "</option>";
                                                    } else {
                                                        echo "<option value=" . $key['idColonia'] . ">" . $key['nombreColonia'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="direccionCobro">Dirección de cobro</label>
                                            <textarea class="form-control input-sm" name="direccionCobro" rows="2" cols="40" readonly><?php echo htmlentities($direccionCobro); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="telefono"><span style="color:red;font-size:18px;">**</span>Teléfono</label>
                                            <input class="form-control input-sm alert-danger" type="text" name="telefono" value="<?php echo $telefonos; ?>" readonly required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="telefonoTrabajo">Teléfono de trabajo</label>
                                            <input class="form-control input-sm" type="text" name="telefonoTrabajo" value="<?php echo $telTrabajo; ?>" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="ocupacion">Ocupación</label>
                                            <input class="form-control input-sm" type="text" name="ocupacion" value="<?php echo $ocupacion; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="cuentaContable">Cuenta contable</label>
                                            <input class="form-control input-sm" type="text" name="cuentaContable" value="<?php echo $idCuenta; ?>" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="formaFacturar">Forma al facturar</label>
                                            <select class="form-control input-sm" name="formaFacturar" disabled>
                                                <option value="" selected>Seleccionar</option>
                                                <?php
                                                foreach ($arrFormaFacturar as $key) {
                                                    if ($key['idFormaPago'] == $formaFacturar) {
                                                        echo "<option value=" . $key['idFormaPago'] . " selected>" . $key['nombreFormaPago'] . "</option>";
                                                    } else {
                                                        echo "<option value=" . $key['idFormaPago'] . ">" . $key['nombreFormaPago'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="tipoComprobante"><span style="color:red;font-size:18px;">**</span>Tipo de comprobante</label>
                                            <select class="form-control input-sm alert-danger" onchange="selectTipoComp();" id="tipoComprobante" name="tipoComprobante" disabled required>
                                                <option value="" selected>Seleccionar</option>
                                                <?php

                                                foreach ($arrComprobantes as $key) {
                                                    if ($key['idComprobante'] == $tipoComprobante) {
                                                        echo "<option value=" . $key['idComprobante'] . " selected>" . $key['nombreComprobante'] . "</option>";
                                                    } else {
                                                        echo "<option value=" . $key['idComprobante'] . ">" . $key['nombreComprobante'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="saldoActual">Saldo actual</label>
                                            <input class="form-control input-sm" type="text" name="saldoActual" value="<?php echo $saldoActual; ?>" readonly>
                                        </div>
                                        <!--<div class="col-md-2">
                                            <label for="limiteCredito">Días de crédito</label>
                                            <input class="form-control input-sm" type="text" name="diasCredito" value="<?php echo $diasCredito; ?>" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="limiteCredito">Límite de crédito</label>
                                            <input class="form-control input-sm" type="text" name="limiteCredito" value="<?php echo $limiteCredito; ?>" readonly>
                                        </div> -->
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="facebook">Cuenta de Facebook</label>
                                            <input class="form-control input-sm" type="text" name="facebook" value="<?php echo $facebook; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="correo">Correo electrónico</label>
                                            <input class="form-control input-sm" type="text" name="correo" value="<?php echo $correo; ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="otros-datos">
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="cobrador"><span style="color:red;font-size:18px;">**</span>Cobrador que lo atiende</label>
                                            <select class="form-control input-sm alert-danger" name="cobrador" disabled required>
                                                <option value="">Seleccionar</option>
                                                <?php
                                                foreach ($arrCobradores as $key) {
                                                    if ($key['codigoCobrador'] == $cobrador) {
                                                        echo "<option value=" . $key['codigoCobrador'] . " selected>" . $key['nombreCobrador'] . "</option>";
                                                    } else {
                                                        echo "<option value=" . $key['codigoCobrador'] . ">" . $key['nombreCobrador'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="rp1_nombre">Referencia personal #1</label>
                                            <input class="form-control input-sm" type="text" name="rf1_nombre" value="<?php echo $contacto1; ?>" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="rp1_telefono">Teléfono</label>
                                            <input class="form-control input-sm" type="text" name="rp1_telefono" value="<?php echo $telCon1; /*$contacto2;*/ ?>" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="rp1_direccion">Dirección</label>
                                            <input class="form-control input-sm" type="text" name="rp1_direccion" value="<?php echo $dir1; ?>" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="rp1_parentezco">Parentezco</label>
                                            <input class="form-control input-sm" type="text" name="rp1_parentezco" value="<?php echo $paren1;/*$telCon1;*/ ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="rp2_nombre">Referencia personal #2</label>
                                            <input class="form-control input-sm" type="text" name="rf2_nombre" value="<?php echo $contacto2; ?>" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="rp2_telefono">Teléfono</label>
                                            <input class="form-control input-sm" type="text" name="rp2_telefono" value="<?php echo $telCon2; ?>" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="rp2_direccion">Dirección</label>
                                            <input class="form-control input-sm" type="text" name="rp2_direccion" value="<?php echo $dir2; ?>" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="rp2_parentezco">Parentezco</label>
                                            <input class="form-control input-sm" type="text" name="rp2_parentezco" value="<?php echo $paren2; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="rp3_nombre">Referencia personal #3</label>
                                            <input class="form-control input-sm" type="text" name="rf3_nombre" value="<?php echo $contacto3; ?>" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="rp3_telefono">Teléfono</label>
                                            <input class="form-control input-sm" type="text" name="rp3_telefono" value="<?php echo $telCon3; ?>" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="rp3_direccion">Dirección</label>
                                            <input class="form-control input-sm" type="text" name="rp3_direccion" value="<?php echo $dir3; ?>" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="rp3_parentezco">Parentezco</label>
                                            <input class="form-control input-sm" type="text" name="rp3_parentezco" value="<?php echo $paren3; ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade in" id="servicios">
                                    <!--Accordion wrapper-->
                                    <div class="accordion md-accordion" id="accordionEx1" role="tablist" aria-multiselectable="true">

                                        <!-- Accordion card -->
                                        <div class="card">

                                            <!-- Card header -->
                                            <div class="card-header" role="tab" id="headingTwo1">
                                                <a style="text-decoration:none;" class="collapsed" data-toggle="collapse" data-parent="#accordionEx1" href="#collapseTwo1" aria-expanded="false" aria-controls="collapseTwo1">
                                                    <h5 class="mb-0 alert dark">
                                                        TV POR CABLE <i class="fas fa-angle-down rotate-icon"></i>
                                                    </h5>
                                                </a>
                                            </div>

                                            <!-- Card body -->
                                            <div id="collapseTwo1" class="collapse" role="tabpanel" aria-labelledby="headingTwo1" data-parent="#accordionEx1">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label for="fechaInstalacionCable">Fecha de instalación</label>
                                                            <input class="form-control input-sm cable" type="text" id="fechaInstalacionCable" name="fechaInstalacionCable" value="<?php echo $fechaInstalacion; ?>" placeholder="__/__/____" readonly>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="fechaPrimerFacturaCable">Fecha primer factura</label>
                                                            <input class="form-control input-sm cable" type="text" id="fechaPrimerFacturaCable" name="fechaPrimerFacturaCable" onchange="setVencimientoCable()" value="<?php echo $fechaPrimerFactura; ?>" readonly>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="mesesContratoCable">Meses de contrato</label>
                                                            <input class="form-control input-sm cable" type="text" id="mesesContratoCable" name="mesesContratoCable" onchange="setVencimientoCable()" value="<?php echo $periodoContratoCable; ?>" readonly>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="exento">Exento</label>
                                                            <?php
                                                            if ($exento == "F" || $exento == NULL) {
                                                                echo "<input id='exento' onchange='getExento(this)' class='form-control input-sm' type='checkbox' name='exento' value='F'>";
                                                            } else {
                                                                echo "<input id='exento' onchange='getExento(this)' class='form-control input-sm' type='checkbox' name='exento' value='T' checked>";
                                                            }
                                                            ?>

                                                        </div>

                                                        <div class="col-md-2">
                                                            <label for="cortesia">Cortesía</label>
                                                            <?php
                                                            if ($cortesia == "F") {
                                                                echo "<input id='cortesia' onchange='getCortesia(this)' class='form-control input-sm' type='checkbox' name='cortesia' value='F'>";
                                                            } else if ($cortesia == "T") {
                                                                echo "<input id='cortesia' onchange='getCortesia(this)' class='form-control input-sm' type='checkbox' name='cortesia' value='T' checked>";
                                                            } else {
                                                                echo "<input id='cortesia' onchange='getCortesia(this)' class='form-control input-sm' type='checkbox' name='cortesia' value='F'>";
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label for="cuotaMensualCable"><span style="color:red;font-size:18px;">**</span>Cuota mensual</label>
                                                            <input class="form-control input-sm alert-danger cable" type="text" name="cuotaMensualCable" value="<?php echo $cuotaMensualCable; ?>" readonly>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="prepago">Prepago</label>
                                                            <input class="form-control input-sm cable" type="text" name="prepago" value="<?php echo round($prepago, 2); ?>" readonly>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="tipoServicio">Tipo de servicio</label>
                                                            <select class="form-control input-sm cable" id="tipoServicioCable" name="tipoServicioCable" onchange="tipoServicioCabletv()" disabled>
                                                                <option value="" selected>Seleccionar</option>
                                                                <?php
                                                                foreach ($arrServicioCable as $key) {
                                                                    if ($key['idServicioCable'] == $tipoServicio) {
                                                                        echo "<option value=" . $key['idServicioCable'] . " selected>" . $key['nombreServicioCable'] . "</option>";
                                                                    } else {
                                                                        echo "<option value=" . $key['idServicioCable'] . ">" . $key['nombreServicioCable'] . "</option>";
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="mactv">TV DIGITAL</label>
                                                            <!--<input class="form-control input-sm" type="text" name="mactv" value="<?php //echo $mactv; 
                                                                                                                                        ?>" readonly>-->
                                                            <button type="button" class="btn btn-danger btn-block btn-xl" data-toggle="modal" data-target="#cas" name="button"><i class="fas fa-tv"></i> Datos de caja digital</button>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="diaGenerarFacturaCable"><span style="color:red;font-size:18px;">**</span>Día cobro</label>
                                                            <input class="form-control input-sm alert-danger cable" type="text" name="diaGenerarFacturaCable" value="<?php echo $diaCobro; ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label for="inicioContratoCable">Inicio de contrato</label>
                                                            <input class="form-control input-sm cable" type="text" id="inicioContratoCable" name="inicioContratoCable" value="<?php echo $fechaInstalacion; ?>" readonly>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="vencimientoContratoCable">Vence contrato</label>
                                                            <input class="form-control input-sm" type="text" id="vencimientoContratoCable" name="vencimientoContratoCable" value="<?php echo $vencimientoCable; ?>" readonly>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="fechaSuspensionCable">Fecha suspension</label>
                                                            <input class="form-control input-sm" style="color: #b71c1c;" type="text" id="fechaSuspensionCable" name="fechaSuspensionCable" value="<?php echo $fechaSuspensionCable; ?>" readonly>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="fechaReconexionCable">Fecha de reconexión</label>
                                                            <input class="form-control input-sm" type="text" id="fechaReconexionCable" name="fechaReconexionCable" value="<?php echo $fechaReinstalacionCable; ?>" readonly>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="derivaciones">N° de derivaciones</label>
                                                            <input class="form-control input-sm" type="text" name="derivaciones" value="<?php echo $nDerivaciones; ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="encargadoInstalacionCable"><span style="color:red;font-size:18px;">**</span>Técnico que realizó la instalación</label>
                                                            <select class="form-control input-sm alert-danger cable" name="encargadoInstalacionCable" disabled>
                                                                <option value="">Seleccionar</option>
                                                                <?php
                                                                foreach ($arrTecnicos as $key) {
                                                                    if ($key['idTecnico'] == $tecnicoCable) {
                                                                        echo "<option value=" . $key['idTecnico'] . " selected>" . $key['nombreTecnico'] . "</option>";
                                                                    } else {
                                                                        echo "<option value=" . $key['idTecnico'] . ">" . $key['nombreTecnico'] . "</option>";
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label style="color: #CC0000" for="cuotaCovidC">Cuota COVID-19</label>
                                                            <input class="form-control input-sm cable" type="text" id="cuotaCovidC" name="cuotaCovidC" value="<?php echo htmlentities($cuotaCovidC); ?>" readonly>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label style="color: #CC0000" for="covidDesdeC">Desde</label>
                                                            <input class="form-control input-sm cable" type="text" id="covidDesdeC" name="covidDesdeC" onkeyup="fechaCovidCable();" value="<?php echo htmlentities($covidDesdeC); ?>" readonly>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label style="color: #CC0000" for="covidHastaC">Hasta</label>
                                                            <input class="form-control input-sm cable" type="text" id="covidHastaC" name="covidHastaC" onkeyup="fechaCovidCable();" value="<?php echo htmlentities($covidHastaC); ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="direccionCable">Dirección</label>
                                                            <input class="form-control input-sm cable" type="text" name="direccionCable" value="<?php echo htmlentities($direccionCable); ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- Accordion card -->

                                        <!-- Accordion card -->
                                        <div class="card">

                                            <!-- Card header -->
                                            <div class="card-header" role="tab" id="headingTwo2">
                                                <a style="text-decoration:none;" class="collapsed" data-toggle="collapse" data-parent="#accordionEx1" href="#collapseTwo21" aria-expanded="false" aria-controls="collapseTwo21">
                                                    <h5 class="mb-0 alert dark">
                                                        INTERNET <i class="fas fa-angle-down rotate-icon"></i>
                                                    </h5>
                                                </a>
                                            </div>

                                            <!-- Card body -->
                                            <div id="collapseTwo21" class="collapse" role="tabpanel" aria-labelledby="headingTwo21" data-parent="#accordionEx1">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label for="fechaInstalacionInternet">Fecha de instalación</label>
                                                            <input class="form-control input-sm internet" type="text" id="fechaInstalacionInternet" name="fechaInstalacionInternet" value="<?php echo $fechaInstalacionInter; ?>" readonly>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="fechaPrimerFacturaInternet">Fecha primer factura</label>
                                                            <input class="form-control input-sm internet" type="text" id="fechaPrimerFacturaInternet" name="fechaPrimerFacturaInternet" onchange="setVencimientoInternet()" value="<?php echo $fechaPrimerFacturaInter; ?>" readonly>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="mesesContratoInternet">Meses de contrato</label>
                                                            <input class="form-control input-sm internet" type="text" id="mesesContratoInternet" name="mesesContratoInternet" onchange="setVencimientoInternet()" value="<?php echo $periodoContratoInternet; ?>" readonly>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="tipoServicioInternet">Tipo de servicio</label>
                                                            <select class="form-control input-sm internet" name="tipoServicioInternet" disabled>
                                                                <option value="" selected>Seleccionar</option>
                                                                <?php
                                                                foreach ($arrServicioInter as $key) {
                                                                    if ($key['idServicioInter'] == $tipoServicioInternet) {
                                                                        echo "<option value=" . $key['idServicioInter'] . " selected>" . $key['nombreServicioInter'] . "</option>";
                                                                    } else {
                                                                        echo "<option value=" . $key['idServicioInter'] . ">" . $key['nombreServicioInter'] . "</option>";
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="diaGenerarFacturaInternet"><span style="color:red;font-size:18px;">**</span>Día para generar factura</label>
                                                            <input class="form-control input-sm alert-danger internet" type="text" name="diaGenerarFacturaInternet" value="<?php echo $diaCobroInter; ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label for="velocidadInternet">Velocidad</label>
                                                            <select class="form-control input-sm internet" name="velocidadInternet" disabled>
                                                                <option value="" selected>Seleccionar</option>
                                                                <?php
                                                                foreach ($arrVelocidad as $key) {
                                                                    if ($key['idVelocidad'] == $velocidadInter) {
                                                                        echo "<option value=" . $key['idVelocidad'] . " selected>" . $key['nombreVelocidad'] . "</option>";
                                                                    } else {
                                                                        echo "<option value=" . $key['idVelocidad'] . ">" . $key['nombreVelocidad'] . "</option>";
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="cuotaMensualInternet"><span style="color:red;font-size:18px;">**</span>Cuota mensual</label>
                                                            <input class="form-control input-sm alert-danger internet" type="text" name="cuotaMensualInternet" value="<?php echo $cuotaMensualInter; ?>" readonly>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="prepago_in">Prepago</label>
                                                            <input class="form-control input-sm internet" type="text" name="prepago_in" value="<?php echo round($prepago_in, 2); ?>" readonly>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="tipoCliente">Tipo de cliente</label>
                                                            <select class="form-control input-sm internet" name="tipoCliente" disabled>
                                                                <option value="" selected>Seleccionar</option>
                                                                <?php
                                                                foreach ($arrTiposClientes as $key) {
                                                                    if ($key['idTipoCliente'] == $tipoClienteInter) {
                                                                        echo "<option value=" . $key['idTipoCliente'] . " selected>" . $key['nombreTipoCliente'] . "</option>";
                                                                    } else {
                                                                        echo "<option value=" . $key['idTipoCliente'] . ">" . $key['nombreTipoCliente'] . "</option>";
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label for="tecnologia">Tecnología</label>
                                                            <select class="form-control input-sm internet" name="tecnologia" disabled>
                                                                <option value="" selected>Seleccionar</option>
                                                                <?php
                                                                foreach ($arrTecnologias as $key) {
                                                                    if ($key['idTecnologia'] == $tecnologia || strtolower($key['nombreTecnologia']) == strtolower($tecnologia)) {
                                                                        echo "<option value=" . $key['nombreTecnologia'] . " selected>" . $key['nombreTecnologia'] . "</option>";
                                                                    } else {
                                                                        echo "<option value=" . $key['nombreTecnologia'] . ">" . $key['nombreTecnologia'] . "</option>";
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="enCalidad"><span style="color:red;font-size:18px;">**</span>En calidad de</label>
                                                            <input class="form-control input-sm alert-danger internet" type="text" name="enCalidad" value="<?php echo $calidad; ?>" readonly>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label for="tipo_de_contrato">Tipo de contrato</label>
                                                            <select class="form-control input-sm internet" name="tipo_de_contrato" disabled>
                                                                <option value="<?php echo $tipo_de_contrato; ?>"><?php echo $tipo_de_contrato; ?></option>
                                                                <option value="Nuevo">Nuevo</option>
                                                                <option value="Reconexion">Reconexión</option>
                                                                <option value="Renovacion">Renovación</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label for="nContratoVigente">N° de contrato (INTERNET)</label>
                                                            <input class="form-control input-sm alert-danger" type="text" name="nContratoVigente" value="<?php echo $nContratoInter; ?>" readonly>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="vencimientoContratoInternet">Vencimiento de contrato</label>
                                                            <input class="form-control input-sm" type="text" id="vencimientoContratoInternet" name="vencimientoContratoInternet" value="<?php echo $vencimientoInternet; ?>" readonly>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="ultimaRenovacionInternet">Última renovación</label>
                                                            <input class="form-control input-sm" type="text" id="ultimaRenovacionInternet" name="ultimaRenovacionInternet" value="<?php echo $ultimaRenovacionInternet; ?>" readonly>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="fechaSuspencionInternet">Fecha de suspensión</label>
                                                            <input class="form-control input-sm" style="color: #b71c1c;" type="text" id="fechaSuspencionInternet" name="fechaSuspencionInternet" value="<?php echo $fechaSuspencionInternet; ?>" readonly>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="fechaReconexionInternet">Fecha de reconexión</label>
                                                            <input class="form-control input-sm" type="text" id="fechaReconexionInternet" name="fechaReconexionInternet" value="<?php echo $fechaReconexionInternet; ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <label for="promocion">Promoción</label>
                                                            <input class="form-control input-sm" type="text" name="promocion" value="<?php echo $promocion; ?>" readonly>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="promocionDesde">Desde</label>
                                                            <input class="form-control input-sm" type="text" name="promocionDesde" value="<?php echo $promocionDesde; ?>" readonly>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="promocionHasta">Hasta</label>
                                                            <input class="form-control input-sm" type="text" name="promocionHasta" value="<?php echo $promocionHasta; ?>" readonly>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="cuotaPromocion">Cuota de la promoción</label>
                                                            <input class="form-control input-sm" type="text" name="cuotaPromocion" value="<?php echo $cuotaPromocion; ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-9">
                                                            <label for="encargadoInstalacionInter"><span style="color:red;font-size:18px;">**</span>Técnico que realizó la instalación</label>
                                                            <select class="form-control input-sm alert-danger internet" name="encargadoInstalacionInter" disabled>
                                                                <option value="">Seleccionar</option>
                                                                <?php
                                                                foreach ($arrTecnicos as $key) {
                                                                    if ($key['idTecnico'] == $tecnicoInternet) {
                                                                        echo "<option value=" . $key['idTecnico'] . " selected>" . $key['nombreTecnico'] . "</option>";
                                                                    } else {
                                                                        echo "<option value=" . $key['idTecnico'] . ">" . $key['nombreTecnico'] . "</option>";
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="costoInstalacionIn">Costo de instalación</label>
                                                            <input class="form-control input-sm" type="text" name="costoInstalacionIn" value="<?php echo $costoInstalacionIn; ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label style="color: #CC0000" for="cuotaCovidI">Cuota COVID-19</label>
                                                            <input class="form-control input-sm internet" type="text" id="cuotaCovidI" name="cuotaCovidI" value="<?php echo htmlentities($cuotaCovidI); ?>" readonly>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label style="color: #CC0000" for="covidDesdeI">Desde</label>
                                                            <input class="form-control input-sm internet" type="text" id="covidDesdeI" name="covidDesdeI" onkeyup="fechaCovidInter();" value="<?php echo htmlentities($covidDesdeI); ?>" readonly>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label style="color: #CC0000" for="covidHastaI">Hasta</label>
                                                            <input class="form-control input-sm internet" type="text" id="covidHastaI" name="covidHastaI" onkeyup="fechaCovidInter();" value="<?php echo htmlentities($covidHastaI); ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="direccionInternet">Dirección</label>
                                                            <input class="form-control input-sm internet" type="text" name="direccionInternet" value="<?php echo htmlentities($direccionInternet); ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <hr style="border-top: 1px solid #0288D1;">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label for="colilla">Colilla</label>
                                                                    <input class="form-control input-sm" type="text" name="colilla" value="<?php echo $colilla; ?>" readonly>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <label for="wanip">WAN IP</label>
                                                                    <input class="form-control input-sm" type="text" id="wanip" name="wanip" value="<?php echo $wanip; ?>" readonly>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <label for="coordenadas">Coordenadas</label>
                                                                    <input class="form-control input-sm" type="text" name="coordenadas" value="<?php if (isset($coordenadas)) echo $coordenadas; ?>" readonly>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <label for="nodo">Nodo/Ap/Path</label>
                                                                    <input class="form-control input-sm" type="text" name="nodo" value="<?php echo $nodo ?>" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <label for="modelo">Modelo</label>
                                                                    <input class="form-control input-sm" type="text" name="modelo" value="<?php echo $modelo; ?>" readonly>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="recepcion">Recepción</label>
                                                                    <input class="form-control input-sm" type="text" name="recepcion" value="<?php echo $recepcion; ?>" readonly>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <label for="mac">MAC</label>
                                                                    <input class="form-control input-sm" type="text" id="mac" name="mac" value="<?php echo $mac; ?>" readonly>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="transmicion">Transmisión</label>
                                                                    <input class="form-control input-sm" type="text" name="transmision" value="<?php echo $transmision; ?>" readonly>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <label for="serie">Serie</label>
                                                                    <input class="form-control input-sm" type="text" name="serie" value="<?php echo $serie; ?>" readonly>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="ruido">Ruido</label>
                                                                    <input class="form-control input-sm" type="text" name="ruido" value="<?php echo $ruido; ?>" readonly>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <label for="claveWifi">Clave WIFI</label>
                                                                    <input class="form-control input-sm" type="text" name="claveWifi" value="<?php echo $wifiClave; ?>" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <br>
                                                            <button class="btn btn-success btn-block" type="button" name="agregar" onclick="activarMac();" style="font-size:16px">Activar servicio</button>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <br>
                                                            <button class="btn btn-danger btn-block" type="button" name="eliminar" onclick="eliminarMac();" style="font-size:16px">Desactivar servicio</button>
                                                        </div>
                                                    </div>
                                                    <hr style="border-top: 1px solid #0288D1;">
                                                </div>
                                            </div>

                                        </div>
                                        <!-- Accordion card -->

                                        <!-- Accordion card -->
                                        <div class="card">

                                            <!-- Card header -->
                                            <div class="card-header" role="tab" id="headingThree31">
                                                <a style="text-decoration:none;" class="collapsed" data-toggle="collapse" data-parent="#accordionEx1" href="#collapseThree31" aria-expanded="false" aria-controls="collapseThree31">
                                                    <h5 class="mb-0 alert dark">
                                                        TELEFONIA <i class="fas fa-angle-down rotate-icon"></i>
                                                    </h5>
                                                </a>
                                            </div>

                                            <!-- Card body -->
                                            <div id="collapseThree31" class="collapse" role="tabpanel" aria-labelledby="headingThree31" data-parent="#accordionEx1">
                                                <div class="card-body">
                                                    <h4>Servicio no disponible</h4>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- Accordion card -->

                                    </div>

                                    </form> <!-- Accordion wrapper -->
                                </div>
                                <div class="tab-pane fade" id="ordenes-tecnicas">
                                    <h4 style="background-color: #ccc;" class="alert">Historial de ordenes de trabajo</h4>
                                    <div class="ordenes">
                                        <!-- <div class="col-md-12">
                                            <button class="btn btn-danger pull-right" type="button" name="button" data-toggle="modal" data-target="#ordenesTrabajo"><i class="fas fa-search"></i></button>
                                            <br><br>
                                        </div>-->
                                        <table class="table table-bordered table-hover">
                                            <thead class="">
                                                <tr class="dark">
                                                    <td>N° de orden</td>
                                                    <td>Tipo de orden</td>
                                                    <td>Fecha de orden</td>
                                                    <td>Fecha realizada</td>
                                                    <td>Actividad cable</td>
                                                    <td>Actividad internet</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($arrOrdenesTrabajo as $key) {
                                                    echo "<tr><td>";
                                                    echo "<a onclick=\"window.open('ordenTrabajo.php?nOrden={$key["idOrdenTrabajo"]}','','height=600,width=1000,top=-300,left=200')\" class='btn btn-danger btn-xs'>" . $key["idOrdenTrabajo"] . "</td><td>";
                                                    echo $key["tipoOrdenTrabajo"] . "</td><td>";
                                                    echo date_format(date_create($key["fechaOrdenTrabajo"]), 'd/m/Y') . "</td><td>";
                                                    echo $key["fechaTrabajo"] . "</td><td>";
                                                    echo $key["actividadCable"] . "</td><td>";
                                                    echo $key["actividadInter"] . "</td><tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <h4 style="background-color: #ccc;" class="alert">Historial de ordenes de suspensión</h4>
                                    <div class="ordenes">
                                        <!--<div class="col-md-12">
                                            <button class="btn btn-danger pull-right" type="button" name="button" data-toggle="modal" data-target="#ordenesSuspension"><i class="fas fa-search"></i></button>
                                            <br><br>
                                        </div>-->
                                        <table class="table table-bordered table-hover">
                                            <thead class="">
                                                <tr class="dark">
                                                    <td>N° de orden</td>
                                                    <td>Tipo de orden</td>
                                                    <td>Fecha de orden</td>
                                                    <td>Fecha realizada</td>
                                                    <td>Actividad cable</td>
                                                    <td>Actividad internet</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($arrOrdenesSuspension as $key) {
                                                    echo "<tr><td>";
                                                    echo "<a onclick=\"window.open('ordenSuspension.php?nOrden={$key["idOrdenSuspension"]}', '', 'height=600,width=1000,top=-300,left=200')\" class='btn btn-danger btn-xs'>" . $key["idOrdenSuspension"] . "</td><td>";
                                                    echo $key["tipoOrden"] . "</td><td>";
                                                    echo $key["fechaOrden"] . "</td><td>";
                                                    echo $key["fechaSuspension"] . "</td><td>";
                                                    echo $data2->getAcById($key["actividadCable"]) . "</td><td>";
                                                    echo $data2->getAiById($key["actividadInter"]) . "</td><tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <h4 style="background-color: #ccc;" class="alert">Historial de ordenes de reconexión</h4>
                                    <div class="ordenes">
                                        <!--<div class="col-md-12">
                                            <button class="btn btn-danger pull-right" type="button" name="button" data-toggle="modal" data-target="#ordenesReconexion"><i class="fas fa-search"></i></button>
                                            <br><br>
                                        </div>-->
                                        <table class="table table-bordered table-hover">
                                            <thead class="">
                                                <tr class="dark">
                                                    <td>N° de orden</td>
                                                    <td>Tipo de orden</td>
                                                    <td>Fecha de orden</td>
                                                    <td>Fecha realizada Cable</td>
                                                    <td>Fecha realizada Internet</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($arrOrdenesReconex as $key) {
                                                    echo "<tr><td>";
                                                    echo "<a onclick=\"window . open('ordenReconexion.php?nOrden={$key["idOrdenReconex"]}', '', 'height=600,width=1000,top=-300,left=200')\" class='btn btn-danger btn-xs'>" . $key["idOrdenReconex"] . "</td><td>";
                                                    echo $key["tipoOrden"] . "</td><td>";
                                                    echo $key["fechaOrden"] . "</td><td>";
                                                    //echo $key["fechaSuspension"] . "</td><td>";
                                                    echo $key["fechaReconexCable"] . "</td><td>";
                                                    echo $key["fechaReconexInter"] . "</td><tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="notificaciones-traslados">
                                    <h4 style="background-color: #ccc;" class="alert">Historial de traslados</h4>
                                    <div class="ordenes">
                                        <table class="table table-bordered table-hover">
                                            <thead class="info">
                                                <tr class="dark">
                                                    <td>N° de orden</td>
                                                    <td>Tipo de orden</td>
                                                    <td>Fecha de orden</td>
                                                    <td>Fecha traslado</td>
                                                    <td>Tipo servicio</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($arrTraslados as $key) {
                                                    echo "<tr><td>";
                                                    echo "<a onclick=\"window.open('ordenTraslado.php?nOrden={$key["idOrdenTraslado"]}', '', 'height=600,width=1000,top=-300,left=200')\" class='btn btn-danger btn-xs'>" . $key["idOrdenTraslado"] . "</td><td>";
                                                    echo $key["tipoOrden"] . "</td><td>";
                                                    echo $key["fechaOrden"] . "</td><td>";
                                                    echo $key["fechaTraslado"] . "</td><td>";
                                                    echo $key["tipoServicio"] . "</td><td>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- DATOS DE LAS CAJAS DIGITALES -->
                <?php
                $codigo = $_GET['id'];
                if (isset($_GET['estado'])) {
                    $estado = $_GET['estado'];
                    if ($estado == 'EXITO') {
                ?>
                        <script>
                            swal({
                                type: 'success',
                                title: 'Exito',
                                text: 'Operacion realizada con exito!',
                                showCancelButton: true,
                                confirmButtonText: "Continuar",
                                cancelButtonText: "Cancelar",
                            })
                            .then(resultado=>{
                                if(resultado.value){
                                    window.location.href = "infoCliente.php?id=<?php echo $codigo ?>";
                                }else{
                                    window.location.href = "infoCliente.php?id=<?php echo $codigo ?>";
                                }
                            });
                           
                        </script>
                    <?php
                    } if($estado == 'ERROR') { 
                    ?>
                        <script>
                            swal({
                                type: 'error',
                                title: 'Error',
                                text: 'Ingresa valores duplicados!',
                                showCancelButton: true,
                                confirmButtonText: "Continuar",
                                cancelButtonText: "Cancelar",
                            })
                            .then(resultado=>{
                                if(resultado.value){
                                    window.location.href = "infoCliente.php?id=<?php echo $codigo ?>";
                                }else{
                                    window.location.href = "infoCliente.php?id=<?php echo $codigo ?>";
                                }
                            });
                        </script>
                <?php
                    }if ($estado == 'ERROR2') {
                        ?>
                        <script>
                            swal({
                                type: 'error',
                                title: 'Error',
                                text: 'Error al ingresar los datos',
                                showCancelButton: true,
                                confirmButtonText: "Continuar",
                                cancelButtonText: "Cancelar",
                            })
                            .then(resultado=>{
                                if(resultado.value){
                                    window.location.href = "infoCliente.php?id=<?php echo $codigo ?>";
                                }else{
                                    window.location.href = "infoCliente.php?id=<?php echo $codigo ?>";
                                }
                            });
                        </script>
                <?php
                    }
                }

                $sqlTVBOX = "SELECT * FROM tbl_tv_box WHERE clientCode='$codigo'";
                $resultado = $mysqli->query($sqlTVBOX);
                ?>
                <!-- Modal TV DIGITAL -->
                <div id="cas" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div style="background-color: #d32f2f; color:white; font-size: 8px;" class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Datos de servicio digital de TV</h4>
                            </div>
                            <div class="modal-body">
                                <?php
                                while ($datos = $resultado->fetch_array()) {
                                ?>
                                    <form action="php/updateTvBox.php" method="POST">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="NumeroBox"># Caja</label>
                                                <input type="number" name="NumeroBox" id="NumeroBox" class="form-control" value="<?php echo $datos['boxNum'] ?>" min="0">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="cast"># Cast</label>
                                                <input type="text" name="cast" id="cast" class="form-control" value="<?php echo $datos['cast'] ?>" min="0">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="serialBox"># Serie</label>
                                                <input type="number" name="serie" id="serie" class="form-control" value="<?php echo $datos['serialBox'] ?>" min="0">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="editar">Editar</label>
                                                <input type="hidden" name="codigo" id="codigo" value='<?php echo $codigo ?>'>
                                                <input type="hidden" name="idBox" id="idBox" value="<?php echo $datos['idBox'] ?>">
                                                <button type="submit" class="btn btn-sm btn-warning btn-block"><i class="fas fa-edit"></i></button>
                                            </div>
                                            <div class="col-md-1">
                                                <label for="eliminar">Eliminar</label>
                                                <a href="#" data='<?php echo $datos['idBox']?>' class="delete btn btn-sm btn-danger btn-block"><i class="fas fa-trash-alt"></i></a>
                                            </div>
                                        </div>
                                    </form>
                                <?php
                                }
                                ?>
                                <form action="php/newTvBox.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="NumeroBox"># Caja</label>
                                            <input type="number" name="NewNumeroBox" id="NewNumeroBox" class="form-control" required min="0">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="cast"># Cast</label>
                                            <input type="text" name="Newcast" id="Newcast" class="form-control" required min="0">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="serialBox"># Serie</label>
                                            <input type="number" name="Newserie" id="Newserie" class="form-control" required min="0">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="Guardar">Guardar</label>
                                            <input type="hidden" name="codigo" id="codigo" value='<?php echo $codigo ?>'>
                                            <button type="submit" class="btn btn-sm btn-block btn-danger"><i class="fas fa-save"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- Fin Modal TV DIGITAL -->


            <!-- Modal Ordenes de Trabajo -->
            <div id="ordenesTrabajo" class="modal fade" role="dialog">
                <div class="modal-dialog modal-sm">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Buscar orden de trabajo</h4>
                        </div>
                        <div class="modal-body">
                            <form class="" action="#" method="POST">
                                <input class="form-control" type="text" name="buscarOrdenTrabajo" placeholder="Número de orden">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Buscar</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Modal Ordenes de Suspension -->
            <div id="ordenesSuspension" class="modal fade" role="dialog">
                <div class="modal-dialog modal-sm">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Buscar orden de suspensión</h4>
                        </div>
                        <div class="modal-body">
                            <form class="" action="#" method="POST">
                                <input class="form-control" type="text" name="buscarOrdenSuspension" placeholder="Número de orden">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Buscar</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Modal Ordenes de Reconexion -->
            <div id="ordenesReconexion" class="modal fade" role="dialog">
                <div class="modal-dialog modal-sm">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Buscar orden de suspensión</h4>
                        </div>
                        <div class="modal-body">
                            <form class="" action="#" method="post">
                                <input class="form-control" type="text" name="buscarOrdenReconexion" placeholder="Número de orden">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Buscar</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Modal Ordenes de Traslados -->
            <div id="traslados" class="modal fade" role="dialog">
                <div class="modal-dialog modal-sm">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Buscar traslado</h4>
                        </div>
                        <div class="modal-body">
                            <form class="" action="#" method="post">

                                <input class="form-control" type="text" name="buscarTraslado" placeholder="Número de orden">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Buscar</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div><!-- /.row -->
        <!-- /#page-wrapper -->
    </div>

    <!-- Modal BUSCAR CLIENTE -->
    <div id="buscarCliente" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white; padding: 10px;" class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span style=" font-size: 30px;">&times;</span></button>
                    <h4 class="modal-title">Buscar cliente</h4>
                </div>
                <div style="font-size: 11px;" class="modal-body">
                    <div class="row">
                        <ul class="nav nav-tabs red">
                            <li class="active"><a style="color: #CC0000;" href="#busquedaSimple" data-toggle="tab">Búsqueda simple</a>
                            </li>
                            <li><a style="color: #CC0000;" href="#busquedaAvanzada" data-toggle="tab">Búsqueda avanzada</a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="busquedaSimple">
                                <div class="col-md-12">
                                    <input class="form-control input-sm" type="text" name="caja_busqueda2" id="caja_busqueda2" value="" placeholder="Código, DUI, Nombre, Dirección, MAC">
                                </div>
                                <div class="col-md-12">
                                    <div id="datos2">

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade in" id="busquedaAvanzada">
                                <div class="col-md-3">
                                    <label for="municipio2">Municipio</label>
                                    <select class="form-control input-sm" id="municipio2" name="municipio2">
                                        <option value="" selected>Seleccionar</option>
                                        <?php
                                        foreach ($arrMunicipiosSearch as $key) {
                                            echo "<option value=" . $key['idMunicipio'] . ">" . $key['nombreMunicipio'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                    <br>
                                </div>
                                <div class="col-md-3">
                                    <label for="colonia2">Colonia</label>
                                    <select class="form-control input-sm" id="colonia2" name="colonia2">
                                        <option value="" selected>Seleccionar</option>

                                    </select>
                                    <br>
                                </div>
                                <div class="col-md-3">
                                    <label style="font-size: 12px;" class="label label-success" for="cable">CABLE</label>
                                    <br>
                                    <br>
                                    <fieldset>
                                        <input type="radio" name="cableSearch" value="t" checked>
                                        <label for="cableSearch">Todos</label>
                                        <input type="radio" name="cableSearch" value="a">
                                        <label for="cableSearch">Activos</label>
                                        <input type="radio" name="cableSearch" value="s">
                                        <label for="cableSearch">Suspendidos</label>
                                        <input type="radio" name="cableSearch" value="na">
                                        <label for="cableSearch">Sin servicio</label>
                                    </fieldset>
                                    <br>
                                </div>
                                <div class="col-md-3">
                                    <label style="font-size: 12px;" for="internet" class="label label-primary">INTERNET</label>
                                    <br>
                                    <br>
                                    <fieldset>
                                        <input type="radio" name="interSearch" value="t" checked>
                                        <label for="interSearch">Todos</label>
                                        <input type="radio" name="interSearch" value="a">
                                        <label for="interSearch">Activos</label>
                                        <input type="radio" name="interSearch" value="s">
                                        <label for="interSearch">Suspendidos</label>
                                        <input type="radio" name="interSearch" value="na">
                                        <label for="interSearch">Sin servicio</label>
                                    </fieldset>
                                    <br>
                                </div>
                                <div class="col-md-12">
                                    <input class="form-control input-sm" type="text" name="caja_busqueda" id="caja_busqueda" value="" placeholder="Código, DUI, Nombre, Dirección, MAC">
                                </div>
                                <div class="col-md-12">
                                    <div id="datos">

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div><!-- Fin Modal BUSCAR CLIENTE-->
    <!-- Fin Modal nuevo contrato internet-->
    <style>
        /*
Full screen Modal 
*/
        .fullscreen-modal .modal-dialog {
            margin: 0;
            margin-right: auto;
            margin-left: auto;
            width: 80%;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        /*
@media (min-width: 768px) {
  .fullscreen-modal .modal-dialog {
    width: 750px;
  }
}
@media (min-width: 992px) {
  .fullscreen-modal .modal-dialog {
    width: 970px;
  }
}
@media (min-width: 1200px) {
  .fullscreen-modal .modal-dialog {
     width: 800px;
  }
}
*/
    </style>
    <div id="nuevoContratoI" class="modal fullscreen-modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal Header -->
            <div class="modal-content">
                <div style="background-color: #d32f2f; color:white;" class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Contrato de Internet</h4>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <br><br>
                    <center>
                        <img id="logI" src="../../images/logo.png" class="img-rounded" alt="Cinque Terre" width="255" height="236" />
                    </center>
                    <br><br><br><br>
                    <div class="col-sm-14 text-left">
                        <button type="button" name="generarCont" class="btn btn-danger btn-block" style="font-size: 16px;" onclick="window.open('php/contratoInterDigitalN.php<?php echo "?id=" . $id; ?>','','height=600,width=1000,top=-300,left=200')" disabled><i class="far fa-file-alt"></i> Generar contrato parte frontal</button>
                    </div>
                    <br><br>
                    <div class="col-sm-14 text-left">
                        <button type="button" name="generarCont" class="btn btn-danger btn-block" style="font-size: 16px;" onclick="window.open('php/contratoInterDigitalN-2.php<?php echo "?id=" . $id; ?>','','height=600,width=1000,top=-300,left=200')" disabled><i class="far fa-file-alt"></i> Contrato parte posterior</button>
                    </div>


                </div>
                <!-- Modal footer -->
                <div class="modal-footer">

                    <div class="row">
                        <div class="col-sm-8 text-left">
                            <button type="button" name="imprimir" class="btn btn-success btn-block" onclick="window.open('php/contratoInterReimp.php<?php echo "?id=" . $id; ?>','','height=600,width=1000,top=-300,left=200')" disabled>Reimprimir contrato</button>
                        </div>
                        <div class="col-sm-4 text-right">
                            <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Salir</button>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal IMPRIMIR FACTURAS -->

    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <!--<script src="../../vendor/datatables/js/dataTables.bootstrap.js"></script>
    <script src="../../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../../vendor/datatables-responsive/dataTables.responsive.js"></script>-->

    <script src="../../vendor/jQuery-Mask-Plugin-master/dist/jquery.mask.min.js"></script>


    <!-- Custom Theme JavaScript -->
    <script src="js/clientes.js"></script>
    <?php
    if (isset($_GET['action'])) {
        echo '<script src="js/searchmun.js"></script>';
    } else {
    }
    ?>
    <script src="js/searchMun2.js"></script>;
    <script src="js/search.js"></script>
    <script src="js/searchSimple.js"></script>
    <script src="../../dist/js/sb-admin-2.js"></script>
    <script type="text/javascript">
        var permisos = '<?php echo $permisosUsuario; ?>'
    </script>
    <script src="../modulo_administrar/js/permisos.js"></script>

    <?php
    if (isset($_GET['action'])) {
        echo '<script>
        document.getElementById("btn-editar").disabled = true;
        document.getElementById("btn-guardar").disabled = false;
        document.getElementById("btn-guardar").disabled = false;
        var clearInputs = document.getElementsByClassName("input-sm");
        for (var i = 0; i < clearInputs.length; i++) {
            clearInputs[i].value = "";
            if (clearInputs[i].readOnly == true) {
                clearInputs[i].readOnly = false;
            }
            else if (clearInputs[i].disabled == true) {
                clearInputs[i].disabled = false;
            }
        }
        var clearSw = document.getElementsByClassName("switch");
        for (var i = 0; i < clearSw.length; i++) {
            clearSw[i].value = "";
            if (clearSw[i].readOnly == true) {
                clearSw[i].readOnly = false;
                clearSw[i].checked = false;
            }
            else if (clearSw[i].disabled == true) {
                clearSw[i].disabled = false;
                clearSw[i].checked = false;
            }
        }
        //CABLE
        document.getElementById("activoCable").value = "F";
        document.getElementById("suspendidoCable").value = "T";
        document.getElementById("sinCable").value = "S";

        //INTERNET
        document.getElementById("activoInter").value = "1";
        document.getElementById("suspendidoInter").value = "2";
        document.getElementById("sinInter").value = "3";

        //CORTESIA Y EXENTOS
        if (document.getElementById("exento").checked == true) {
            document.getElementById("exento").value = "T";
        }else if (document.getElementById("exento").checked == false) {
            document.getElementById("exento").value = "F";
        }

        function getExento(){
            if (document.getElementById("exento").checked == true) {
                document.getElementById("exento").value = "T";
            }else if (document.getElementById("exento").checked == false) {
                document.getElementById("exento").value = "F";
            }
        }

        if (document.getElementById("cortesia").checked == true) {
            document.getElementById("cortesia").value = "T";
        }else if (document.getElementById("cortesia").checked == false) {
            document.getElementById("cortesia").value = "F";
        }

        function getCortesia(){
            if (document.getElementById("cortesia").checked == true) {
                document.getElementById("cortesia").value = "T";
            }else if (document.getElementById("cortesia").checked == false) {
                document.getElementById("cortesia").value = "F";
            }
        }

        document.getElementById("formClientes").action = "php/nuevoCliente.php";
        </script>';
    }
    ?>
    <script type="text/javascript">
        document.getElementById("fechaInstalacionCable").style.color = "BlueViolet";
        document.getElementById("fechaPrimerFacturaCable").style.color = "green";
        document.getElementById("vencimientoContratoCable").style.color = "red";
        document.getElementById("fechaInstalacionInternet").style.color = "BlueViolet";
        document.getElementById("fechaPrimerFacturaInternet").style.color = "green";
        document.getElementById("vencimientoContratoInternet").style.color = "red";

        function cableTrue() {
            var reqInputs = document.getElementsByClassName("cable");
            for (var i = 0; i < reqInputs.length; i++) {
                //reqInputs[i].value = "";
                var sinCable = document.getElementById("sinCable").checked;
                var suspendidoCable = document.getElementById("suspendidoCable").checked;
                var activoCable = document.getElementById("activoCable").checked;

                if ( /*sinCable == 'S' || */ suspendidoCable == true || activoCable == true) {
                    reqInputs[i].required = true;
                } else {
                    reqInputs[i].required = false;
                }
                document.getElementById("cuotaCovidC").required = false;
                document.getElementById("covidDesdeC").required = false;
                document.getElementById("covidHastaC").required = false;
            }
        }

        function internetTrue() {
            var reqInputs = document.getElementsByClassName("internet");
            for (var i = 0; i < reqInputs.length; i++) {
                //reqInputs[i].value = "";
                var sinInter = document.getElementById("sinInter").checked;
                var suspendidoInter = document.getElementById("suspendidoInter").checked;
                var activoInter = document.getElementById("activoInter").checked;

                if ( /*sinInter == '3' || */ suspendidoInter == true || activoInter == true) {
                    reqInputs[i].required = true;
                } else {
                    reqInputs[i].required = false;
                }
                document.getElementById("cuotaCovidI").required = false;
                document.getElementById("covidDesdeI").required = false;
                document.getElementById("covidHastaI").required = false;
            }
        }

        function cableFalse() {
            var reqInputs = document.getElementsByClassName("cable");
            //alert("Holaaaaaaaaaaaa");
            for (var i = 0; i < reqInputs.length; i++) {

                reqInputs[i].required = false;
            }
        }

        function internetFalse() {
            var reqInputs = document.getElementsByClassName("internet");
            for (var i = 0; i < reqInputs.length; i++) {

                reqInputs[i].required = false;
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#fechaInstalacionCable').mask("00/00/0000", {
                placeholder: "dd/mm/yyyy"
            });
            $('#fechaPrimerFacturaCable').mask("00/00/0000", {
                placeholder: "dd/mm/yyyy"
            });
            $('#inicioContratoCable').mask("00/00/0000", {
                placeholder: "dd/mm/yyyy"
            });
            $('#vencimientoContratoCable').mask("00/00/0000", {
                placeholder: "dd/mm/yyyy"
            });
            $('#fechaReconexionCable').mask("00/00/0000", {
                placeholder: "dd/mm/yyyy"
            });
            $('#fechaSuspensionCable').mask("00/00/0000", {
                placeholder: "dd/mm/yyyy"
            });
            $('#covidDesdeC').mask("00/00/0000", {
                placeholder: "dd/mm/yyyy"
            });
            $('#covidHastaC').mask("00/00/0000", {
                placeholder: "dd/mm/yyyy"
            });

            $('#fechaInstalacionInternet').mask("00/00/0000", {
                placeholder: "dd/mm/yyyy"
            });
            $('#fechaPrimerFacturaInternet').mask("00/00/0000", {
                placeholder: "dd/mm/yyyy"
            });
            $('#vencimientoContratoInternet').mask("00/00/0000", {
                placeholder: "dd/mm/yyyy"
            });
            $('#ultimaRenovacionInternet').mask("00/00/0000", {
                placeholder: "dd/mm/yyyy"
            });
            $('#fechaSuspencionInternet').mask("00/00/0000", {
                placeholder: "dd/mm/yyyy"
            });
            $('#fechaReconexionInternet').mask("00/00/0000", {
                placeholder: "dd/mm/yyyy"
            });
            $('#covidDesdeI').mask("00/00/0000", {
                placeholder: "dd/mm/yyyy"
            });
            $('#covidHastaI').mask("00/00/0000", {
                placeholder: "dd/mm/yyyy"
            });

            //$('#wanip').mask("099.099.099.099", {placeholder: ".  .  .  ."});
            //$('#mac').mask({pattern: /[a-zA-Z0-9]/}, {placeholder: ":  :  :  :  :"});
            //$('#phone-number').mask('0000-0000');
        });
    </script>
    <script>
        function eliminarMac() {
            var con = confirm("¿Está seguro de DESACTIVAR este modem?");
            if (con == true) {
                var mac = document.getElementById("mac").value;
                if (mac.length < 17 || mac.length > 17) {
                    alert("MAC errónea");
                } else {
                    window.open("http://172.16.1.1:7637/camsys/command/deletecm.php?login=admin&pass=CableS4t&cmmac=" + mac);
                }
            } else {
                alert("Operación cancelada.");
            }
        }

        function activarMac() {
            var con = confirm("¿Está seguro de ACTIVAR este modem?");
            if (con == true) {
                var mac = document.getElementById("mac").value;
                if (mac.length < 17 || mac.length > 17) {
                    alert("MAC errónea");
                } else {
                    window.open("http://172.16.1.1:7637/camsys/command/deletecm.php?login=admin&pass=CableS4t&cmmac=" + mac);
                }
            } else {
                alert("Operación cancelada.");
            }
        }
    </script>
    <script src="js/tv_Box.js"></script>
    <script src="js/mascaras.js"></script>
</body>

</html>