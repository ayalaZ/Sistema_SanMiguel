<?php
require_once("../../../php/config.php");
$host = DB_HOST;
$user = DB_USER;
$password = DB_PASSWORD;

if (!isset($_SESSION)) {
    session_start([
        'cookie_lifetime' => 86400,
    ]);
}

$database = $_SESSION['db'];
$mysqli = new mysqli($host, $user, $password, $database);
$proceso = $_POST['proceso'];

switch ($proceso) {
    case 'codigo':
        $codigo = $_POST['cod'];
        $datoscliente = $mysqli->query("SELECT * FROM clientes WHERE cod_cliente='$codigo'");
        $arreglodatosclientes = $datoscliente->fetch_array();
        $idColonia = $arreglodatosclientes['id_colonia'];
        $idMunicipio = $arreglodatosclientes['id_municipio'];
        $Colonia = $mysqli->query("SELECT * FROM tbl_colonias_cxc WHERE idColonia='$idColonia'");
        $arreglocolonia = $Colonia->fetch_array();
        $municipio = $mysqli->query("SELECT * FROM tbl_municipios_cxc WHERE idMunicipio='$idMunicipio'");
        $arreglomunicipio = $municipio->fetch_array();
        $xdatos['colonia'] = $arreglocolonia['nombreColonia'];
        $xdatos['municipio'] = $arreglomunicipio['nombreMunicipio'];
        $xdatos['nombre'] = $arreglodatosclientes['nombre'];
        $xdatos['nrc'] = $arreglodatosclientes['num_registro'];
        $xdatos['direccion'] = $arreglodatosclientes['direccion_cobro'];
        $xdatos['dia'] = $arreglodatosclientes['dia_cobro'];
        $xdatos['cuota'] = round($arreglodatosclientes['valor_cuota'], 2);
        $meses = $mysqli->query("SELECT mesCargo FROM tbl_abonos WHERE codigoCliente='$codigo' ORDER BY mesCargo DESC LIMIT 1");
        $arregloMeses = $meses->fetch_array();
        if ($arregloMeses['mesCargo']) {
            $mesPendiente = '01/' . $arregloMeses['mesCargo'];
            $date = str_replace('/', '-', $mesPendiente);
            $date = date('Y-m-d', strtotime($date));
            $mesPendiente = date('Y-m-d', strtotime("+1 month", strtotime($date)));
            $mesPendiente = date_format(date_create($mesPendiente), 'm/Y');
            $xdatos['meses'] = $mesPendiente;
        } elseif ($arregloMeses['mesCargo'] == NULL) {
            $mesPendiente = $arreglodatosclientes['fecha_primer_factura'];
            $mesPendiente = date_format(date_create($mesPendiente), 'm/Y');
            $xdatos['meses'] = $mesPendiente;
        }
        echo json_encode($xdatos);
        break;
    case 'servicio':
        $servicio = $_POST['serv'];
        $codigo = $_POST['cod'];
        $datoscliente = $mysqli->query("SELECT * FROM clientes WHERE cod_cliente='$codigo'");
        $arreglodatosclientes = $datoscliente->fetch_array();
        if ($servicio == 'i') {
            $xdatos['cuota'] = $arreglodatosclientes['cuota_in'];
        } else {
            $xdatos['cuota'] = $arreglodatosclientes['valor_cuota'];
        }
        echo json_encode($xdatos);
        break;
    case 'impuesto':
        $valor = $_POST['valor'];
        $cuota = $_POST['cuota'];
        if ($valor = '0.05') {
            $impuesto = $cuota * 0.05;
            $xdatos['impuesto'] = round($impuesto, 2);
            $xdatos['total'] = round($cuota + $impuesto, 2);
            $xdatos['cesc'] = '0.05';
        }
        echo json_encode($xdatos);
        break;
    case 'Sinimpuesto':
        $cuota = $_POST['cuota'];
        $impuesto = 0.00;
        $xdatos['impuesto'] = round($impuesto, 2);
        $xdatos['total'] = round($cuota + $impuesto, 2);
        $xdatos['cesc'] = '0.00';
        echo json_encode($xdatos);
        break;
    case 'meses':
        $cuota = $_POST['cuota'];
        $meses = $_POST['meses'];
        $porcentaje = $_POST['porcentaje'];
        $mes = $_POST['mes'];
        $totalApagar = $cuota * $meses;
        $impuesto = $totalApagar * $porcentaje;
        $total = $totalApagar + $impuesto;
        $xdatos['cuota'] = round($totalApagar, 2);
        $xdatos['impuesto'] = round($impuesto, 2);
        $xdatos['total'] = round($total, 2);
        if ($meses == 2) {
            $mespendiente2 = date("m/Y", strtotime($mes."+1 month"));
            $mesPendiente2 = date_format(date_create($mesPendiente2), 'm/Y');
            $xdatos['meses'] = $mes.",".$mesPendiente2;
        }
        echo json_encode($xdatos);
        break;
}
