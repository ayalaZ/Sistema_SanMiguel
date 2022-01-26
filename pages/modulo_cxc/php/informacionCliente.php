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
        $xdatos['comprobante'] = $arreglodatosclientes['tipo_comprobante'];
        $xdatos['estado_cable'] = $arreglodatosclientes['servicio_suspendido'];
        $xdatos['estado_internet'] = $arreglodatosclientes['estado_cliente_in'];
        $cuotaAenviar = $arreglodatosclientes['valor_cuota'];
        if ($cuotaAenviar == 0) {
            $xdatos['dia'] = $arreglodatosclientes['dia_corbo_in'];
            $xdatos['cuota'] = round($arreglodatosclientes['cuota_in'], 2);
            $xdatos['cambio'] = 'true';
            $tabla = $mysqli->query("SELECT * FROM tbl_cargos WHERE codigoCliente='$codigo' AND estado='pendiente' AND tipoServicio='I' AND anulada='0'");
            $contador = 0;
            while ($datos = $tabla->fetch_assoc()) {
                $xdatos['tabla'][$contador] = [
                    'numeroFactura' => $datos['numeroFactura'],
                    'mesCargo' => $datos['mesCargo'],
                    'cuotaInternet' => $datos['cuotaInternet'],
                    'fechaVencimiento' => $datos['fechaVencimiento'],
                ];
                $contador += 1;
            }
            $xdatos['filas'] = $tabla->num_rows;
        } else {
            $xdatos['dia'] = $arreglodatosclientes['dia_cobro'];
            $xdatos['cuota'] = round($arreglodatosclientes['valor_cuota'], 2);
            $xdatos['cambio'] = 'false';
            $tabla = $mysqli->query("SELECT * FROM tbl_cargos WHERE codigoCliente='$codigo' AND estado='pendiente' AND tipoServicio='C' AND anulada='0'");
            $contador = 0;
            while ($datos = $tabla->fetch_assoc()) {
                $xdatos['tabla'][$contador] = [
                    'numeroFactura' => $datos['numeroFactura'],
                    'mesCargo' => $datos['mesCargo'],
                    'cuotaCable' => $datos['cuotaCable'],
                    'fechaVencimiento' => $datos['fechaVencimiento'],
                ];
                $contador += 1;
            }
            $xdatos['filas'] = $tabla->num_rows;
        }
        $meses = $mysqli->query("SELECT mesCargo FROM tbl_abonos WHERE codigoCliente='$codigo' ORDER BY idAbono DESC LIMIT 1");
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
        $xdatos['servicio'] = $servicio;
        $datoscliente = $mysqli->query("SELECT * FROM clientes WHERE cod_cliente='$codigo'");
        $arreglodatosclientes = $datoscliente->fetch_array();
        if ($servicio == 'i') {
            $xdatos['cuota'] = round($arreglodatosclientes['cuota_in'], 2);
            $tabla = $mysqli->query("SELECT * FROM tbl_cargos WHERE codigoCliente='$codigo' AND estado='pendiente' AND tipoServicio='I' AND anulada='0'");
            $contador = 0;
            while ($datos = $tabla->fetch_assoc()) {
                $xdatos['tabla'][$contador] = [
                    'numeroFactura' => $datos['numeroFactura'],
                    'mesCargo' => $datos['mesCargo'],
                    'cuotaInternet' => $datos['cuotaInternet'],
                    'fechaVencimiento' => $datos['fechaVencimiento'],
                ];
                $contador += 1;
            }
            $xdatos['filas'] = $tabla->num_rows;
        } else {
            $xdatos['cuota'] = round($arreglodatosclientes['valor_cuota'], 2);
            $tabla = $mysqli->query("SELECT * FROM tbl_cargos WHERE codigoCliente='$codigo' AND estado='pendiente' AND tipoServicio='C' AND anulada='0'");
            $contador = 0;
            while ($datos = $tabla->fetch_assoc()) {
                $xdatos['tabla'][$contador] = [
                    'numeroFactura' => $datos['numeroFactura'],
                    'mesCargo' => $datos['mesCargo'],
                    'cuotaCable' => $datos['cuotaCable'],
                    'fechaVencimiento' => $datos['fechaVencimiento'],
                ];
                $contador += 1;
            }
            $xdatos['filas'] = $tabla->num_rows;
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
        $codigo = $_POST['cod'];
        $cuota = $_POST['cuota'];
        $meses = $_POST['meses'];
        $porcentaje = $_POST['porcentaje'];
        $totalApagar = $cuota * $meses;
        $impuesto = $totalApagar * $porcentaje;
        $total = $totalApagar + $impuesto;
        $xdatos['cuota'] = round($totalApagar, 2);
        $xdatos['impuesto'] = round($impuesto, 2);
        $xdatos['total'] = round($total, 2);


        $querymeses = $mysqli->query("SELECT mesCargo FROM tbl_abonos WHERE codigoCliente='$codigo' ORDER BY idAbono DESC LIMIT 1");
        $arregloMeses = $querymeses->fetch_array();
        if ($arregloMeses['mesCargo']) {
            $mesTabla = '01/' . $arregloMeses['mesCargo'];
            $date = str_replace('/', '-', $mesTabla);
            $date = date('Y-m-d', strtotime($date));
            $mesTabla = date('Y-m-d', strtotime("+1 month", strtotime($date)));
            $mesTabla = date_format(date_create($mesTabla), 'm/Y');
            $mes = $mesTabla;
        } elseif ($arregloMeses['mesCargo'] == NULL) {
            $mesTabla = $arreglodatosclientes['fecha_primer_factura'];
            $mesTabla = date_format(date_create($mesTabla), 'm/Y');
            $mes = $mesTabla;
        }

        $fechaCompleta = "01/" . $mes;
        $date = str_replace('/', '-', $fechaCompleta);
        $date = date('Y-m-d', strtotime($date));

        switch ($meses) {
            case '1':
                $xdatos['meses'] = $mes;
                break;
            case '2':
                $mesPendiente2 = date('Y-m-d', strtotime("+1 month", strtotime($date)));
                $mesPendiente2 = date_format(date_create($mesPendiente2), 'm/Y');
                $xdatos['meses'] = $mesPendiente2 . "," . $mes;
                break;
            case '3':
                $mesPendiente2 = date('Y-m-d', strtotime("+1 month", strtotime($date)));
                $mesPendiente2 = date_format(date_create($mesPendiente2), 'm/Y');
                $mesPendiente3 = date('Y-m-d', strtotime("+2 month", strtotime($date)));
                $mesPendiente3 = date_format(date_create($mesPendiente3), 'm/Y');
                $xdatos['meses'] = $mesPendiente3 . "," . $mesPendiente2 . "," . $mes;
                break;
            case '4':
                $mesPendiente2 = date('Y-m-d', strtotime("+1 month", strtotime($date)));
                $mesPendiente2 = date_format(date_create($mesPendiente2), 'm/Y');
                $mesPendiente3 = date('Y-m-d', strtotime("+2 month", strtotime($date)));
                $mesPendiente3 = date_format(date_create($mesPendiente3), 'm/Y');
                $mesPendiente4 = date('Y-m-d', strtotime("+3 month", strtotime($date)));
                $mesPendiente4 = date_format(date_create($mesPendiente4), 'm/Y');
                $xdatos['meses'] = $mesPendiente4 . "," . $mesPendiente3 . "," . $mesPendiente2 . "," . $mes;
                break;
            case '5':
                $mesPendiente2 = date('Y-m-d', strtotime("+1 month", strtotime($date)));
                $mesPendiente2 = date_format(date_create($mesPendiente2), 'm/Y');
                $mesPendiente3 = date('Y-m-d', strtotime("+2 month", strtotime($date)));
                $mesPendiente3 = date_format(date_create($mesPendiente3), 'm/Y');
                $mesPendiente4 = date('Y-m-d', strtotime("+3 month", strtotime($date)));
                $mesPendiente4 = date_format(date_create($mesPendiente4), 'm/Y');
                $mesPendiente5 = date('Y-m-d', strtotime("+4 month", strtotime($date)));
                $mesPendiente5 = date_format(date_create($mesPendiente5), 'm/Y');
                $xdatos['meses'] = $mesPendiente5 . "," . $mesPendiente4 . "," . $mesPendiente3 . "," . $mesPendiente2 . "," . $mes;
                break;
            case '6':
                $mesPendiente2 = date('Y-m-d', strtotime("+1 month", strtotime($date)));
                $mesPendiente2 = date_format(date_create($mesPendiente2), 'm/Y');
                $mesPendiente3 = date('Y-m-d', strtotime("+2 month", strtotime($date)));
                $mesPendiente3 = date_format(date_create($mesPendiente3), 'm/Y');
                $mesPendiente4 = date('Y-m-d', strtotime("+3 month", strtotime($date)));
                $mesPendiente4 = date_format(date_create($mesPendiente4), 'm/Y');
                $mesPendiente5 = date('Y-m-d', strtotime("+4 month", strtotime($date)));
                $mesPendiente5 = date_format(date_create($mesPendiente5), 'm/Y');
                $mesPendiente6 = date('Y-m-d', strtotime("+5 month", strtotime($date)));
                $mesPendiente6 = date_format(date_create($mesPendiente6), 'm/Y');
                $xdatos['meses'] = $mesPendiente6 . "," . $mesPendiente5 . "," . $mesPendiente4 . "," . $mesPendiente3 . "," . $mesPendiente2 . "," . $mes;
                break;
            case '7':
                $mesPendiente2 = date('Y-m-d', strtotime("+1 month", strtotime($date)));
                $mesPendiente2 = date_format(date_create($mesPendiente2), 'm/Y');
                $mesPendiente3 = date('Y-m-d', strtotime("+2 month", strtotime($date)));
                $mesPendiente3 = date_format(date_create($mesPendiente3), 'm/Y');
                $mesPendiente4 = date('Y-m-d', strtotime("+3 month", strtotime($date)));
                $mesPendiente4 = date_format(date_create($mesPendiente4), 'm/Y');
                $mesPendiente5 = date('Y-m-d', strtotime("+4 month", strtotime($date)));
                $mesPendiente5 = date_format(date_create($mesPendiente5), 'm/Y');
                $mesPendiente6 = date('Y-m-d', strtotime("+5 month", strtotime($date)));
                $mesPendiente6 = date_format(date_create($mesPendiente6), 'm/Y');
                $mesPendiente7 = date('Y-m-d', strtotime("+6 month", strtotime($date)));
                $mesPendiente7 = date_format(date_create($mesPendiente7), 'm/Y');
                $xdatos['meses'] = $mesPendiente7 . "," . $mesPendiente6 . "," . $mesPendiente5 . "," . $mesPendiente4 . "," . $mesPendiente3 . "," . $mesPendiente2 . "," . $mes;
                break;
            case '8':
                $mesPendiente2 = date('Y-m-d', strtotime("+1 month", strtotime($date)));
                $mesPendiente2 = date_format(date_create($mesPendiente2), 'm/Y');
                $mesPendiente3 = date('Y-m-d', strtotime("+2 month", strtotime($date)));
                $mesPendiente3 = date_format(date_create($mesPendiente3), 'm/Y');
                $mesPendiente4 = date('Y-m-d', strtotime("+3 month", strtotime($date)));
                $mesPendiente4 = date_format(date_create($mesPendiente4), 'm/Y');
                $mesPendiente5 = date('Y-m-d', strtotime("+4 month", strtotime($date)));
                $mesPendiente5 = date_format(date_create($mesPendiente5), 'm/Y');
                $mesPendiente6 = date('Y-m-d', strtotime("+5 month", strtotime($date)));
                $mesPendiente6 = date_format(date_create($mesPendiente6), 'm/Y');
                $mesPendiente7 = date('Y-m-d', strtotime("+6 month", strtotime($date)));
                $mesPendiente7 = date_format(date_create($mesPendiente7), 'm/Y');
                $mesPendiente8 = date('Y-m-d', strtotime("+7 month", strtotime($date)));
                $mesPendiente8 = date_format(date_create($mesPendiente8), 'm/Y');
                $xdatos['meses'] = $mesPendiente8 . "," . $mesPendiente7 . "," . $mesPendiente6 . "," . $mesPendiente5 . "," . $mesPendiente4 . "," . $mesPendiente3 . "," . $mesPendiente2 . "," . $mes;
                break;
            case '9':
                $mesPendiente2 = date('Y-m-d', strtotime("+1 month", strtotime($date)));
                $mesPendiente2 = date_format(date_create($mesPendiente2), 'm/Y');
                $mesPendiente3 = date('Y-m-d', strtotime("+2 month", strtotime($date)));
                $mesPendiente3 = date_format(date_create($mesPendiente3), 'm/Y');
                $mesPendiente4 = date('Y-m-d', strtotime("+3 month", strtotime($date)));
                $mesPendiente4 = date_format(date_create($mesPendiente4), 'm/Y');
                $mesPendiente5 = date('Y-m-d', strtotime("+4 month", strtotime($date)));
                $mesPendiente5 = date_format(date_create($mesPendiente5), 'm/Y');
                $mesPendiente6 = date('Y-m-d', strtotime("+5 month", strtotime($date)));
                $mesPendiente6 = date_format(date_create($mesPendiente6), 'm/Y');
                $mesPendiente7 = date('Y-m-d', strtotime("+6 month", strtotime($date)));
                $mesPendiente7 = date_format(date_create($mesPendiente7), 'm/Y');
                $mesPendiente8 = date('Y-m-d', strtotime("+7 month", strtotime($date)));
                $mesPendiente8 = date_format(date_create($mesPendiente8), 'm/Y');
                $mesPendiente9 = date('Y-m-d', strtotime("+8 month", strtotime($date)));
                $mesPendiente9 = date_format(date_create($mesPendiente9), 'm/Y');
                $xdatos['meses'] = $mesPendiente9 . "," . $mesPendiente8 . "," . $mesPendiente7 . "," . $mesPendiente6 . "," . $mesPendiente5 . "," . $mesPendiente4 . "," . $mesPendiente3 . "," . $mesPendiente2 . "," . $mes;
                break;
            case '10':
                $mesPendiente2 = date('Y-m-d', strtotime("+1 month", strtotime($date)));
                $mesPendiente2 = date_format(date_create($mesPendiente2), 'm/Y');
                $mesPendiente3 = date('Y-m-d', strtotime("+2 month", strtotime($date)));
                $mesPendiente3 = date_format(date_create($mesPendiente3), 'm/Y');
                $mesPendiente4 = date('Y-m-d', strtotime("+3 month", strtotime($date)));
                $mesPendiente4 = date_format(date_create($mesPendiente4), 'm/Y');
                $mesPendiente5 = date('Y-m-d', strtotime("+4 month", strtotime($date)));
                $mesPendiente5 = date_format(date_create($mesPendiente5), 'm/Y');
                $mesPendiente6 = date('Y-m-d', strtotime("+5 month", strtotime($date)));
                $mesPendiente6 = date_format(date_create($mesPendiente6), 'm/Y');
                $mesPendiente7 = date('Y-m-d', strtotime("+6 month", strtotime($date)));
                $mesPendiente7 = date_format(date_create($mesPendiente7), 'm/Y');
                $mesPendiente8 = date('Y-m-d', strtotime("+7 month", strtotime($date)));
                $mesPendiente8 = date_format(date_create($mesPendiente8), 'm/Y');
                $mesPendiente9 = date('Y-m-d', strtotime("+8 month", strtotime($date)));
                $mesPendiente9 = date_format(date_create($mesPendiente9), 'm/Y');
                $mesPendiente10 = date('Y-m-d', strtotime("+9 month", strtotime($date)));
                $mesPendiente10 = date_format(date_create($mesPendiente10), 'm/Y');
                $xdatos['meses'] = $mesPendiente10 . "," . $mesPendiente9 . "," . $mesPendiente8 . "," . $mesPendiente7 . "," . $mesPendiente6 . "," . $mesPendiente5 . "," . $mesPendiente4 . "," . $mesPendiente3 . "," . $mesPendiente2 . "," . $mes;
                break;
            case '11':
                $mesPendiente2 = date('Y-m-d', strtotime("+1 month", strtotime($date)));
                $mesPendiente2 = date_format(date_create($mesPendiente2), 'm/Y');
                $mesPendiente3 = date('Y-m-d', strtotime("+2 month", strtotime($date)));
                $mesPendiente3 = date_format(date_create($mesPendiente3), 'm/Y');
                $mesPendiente4 = date('Y-m-d', strtotime("+3 month", strtotime($date)));
                $mesPendiente4 = date_format(date_create($mesPendiente4), 'm/Y');
                $mesPendiente5 = date('Y-m-d', strtotime("+4 month", strtotime($date)));
                $mesPendiente5 = date_format(date_create($mesPendiente5), 'm/Y');
                $mesPendiente6 = date('Y-m-d', strtotime("+5 month", strtotime($date)));
                $mesPendiente6 = date_format(date_create($mesPendiente6), 'm/Y');
                $mesPendiente7 = date('Y-m-d', strtotime("+6 month", strtotime($date)));
                $mesPendiente7 = date_format(date_create($mesPendiente7), 'm/Y');
                $mesPendiente8 = date('Y-m-d', strtotime("+7 month", strtotime($date)));
                $mesPendiente8 = date_format(date_create($mesPendiente8), 'm/Y');
                $mesPendiente9 = date('Y-m-d', strtotime("+8 month", strtotime($date)));
                $mesPendiente9 = date_format(date_create($mesPendiente9), 'm/Y');
                $mesPendiente10 = date('Y-m-d', strtotime("+9 month", strtotime($date)));
                $mesPendiente10 = date_format(date_create($mesPendiente10), 'm/Y');
                $mesPendiente11 = date('Y-m-d', strtotime("+10 month", strtotime($date)));
                $mesPendiente11 = date_format(date_create($mesPendiente11), 'm/Y');
                $xdatos['meses'] = $mesPendiente11 . "," . $mesPendiente10 . "," . $mesPendiente9 . "," . $mesPendiente8 . "," . $mesPendiente7 . "," . $mesPendiente6 . "," . $mesPendiente5 . "," . $mesPendiente4 . "," . $mesPendiente3 . "," . $mesPendiente2 . "," . $mes;
                break;
            case '12':
                $mesPendiente2 = date('Y-m-d', strtotime("+1 month", strtotime($date)));
                $mesPendiente2 = date_format(date_create($mesPendiente2), 'm/Y');
                $mesPendiente3 = date('Y-m-d', strtotime("+2 month", strtotime($date)));
                $mesPendiente3 = date_format(date_create($mesPendiente3), 'm/Y');
                $mesPendiente4 = date('Y-m-d', strtotime("+3 month", strtotime($date)));
                $mesPendiente4 = date_format(date_create($mesPendiente4), 'm/Y');
                $mesPendiente5 = date('Y-m-d', strtotime("+4 month", strtotime($date)));
                $mesPendiente5 = date_format(date_create($mesPendiente5), 'm/Y');
                $mesPendiente6 = date('Y-m-d', strtotime("+5 month", strtotime($date)));
                $mesPendiente6 = date_format(date_create($mesPendiente6), 'm/Y');
                $mesPendiente7 = date('Y-m-d', strtotime("+6 month", strtotime($date)));
                $mesPendiente7 = date_format(date_create($mesPendiente7), 'm/Y');
                $mesPendiente8 = date('Y-m-d', strtotime("+7 month", strtotime($date)));
                $mesPendiente8 = date_format(date_create($mesPendiente8), 'm/Y');
                $mesPendiente9 = date('Y-m-d', strtotime("+8 month", strtotime($date)));
                $mesPendiente9 = date_format(date_create($mesPendiente9), 'm/Y');
                $mesPendiente10 = date('Y-m-d', strtotime("+9 month", strtotime($date)));
                $mesPendiente10 = date_format(date_create($mesPendiente10), 'm/Y');
                $mesPendiente11 = date('Y-m-d', strtotime("+10 month", strtotime($date)));
                $mesPendiente11 = date_format(date_create($mesPendiente11), 'm/Y');
                $mesPendiente12 = date('Y-m-d', strtotime("+11 month", strtotime($date)));
                $mesPendiente12 = date_format(date_create($mesPendiente12), 'm/Y');
                $xdatos['meses'] = $mesPendiente12 . "," . $mesPendiente11 . "," . $mesPendiente10 . "," . $mesPendiente9 . "," . $mesPendiente8 . "," . $mesPendiente7 . "," . $mesPendiente6 . "," . $mesPendiente5 . "," . $mesPendiente4 . "," . $mesPendiente3 . "," . $mesPendiente2 . "," . $mes;
                break;
        }
        echo json_encode($xdatos);
        break;
    case 'abonar':
        $idCobrador = $_POST['cobrador'];
        $querycobrador = $mysqli->query("SELECT * FROM tbl_cobradores WHERE codigoCobrador='$idCobrador'");
        $cobrador = $querycobrador->fetch_array();
        $recibo = $cobrador['prefijoCobro'] . "-" . $_POST['ultimoRecibo'];
        $queryrecibo = $mysqli->query("SELECT * FROM tbl_abonos WHERE numeroRecibo='$recibo'");
        $numerorecibos = $queryrecibo->num_rows;
        if ($numerorecibos > 0) {
            $xdatos['msg'] = "Esta intentando ingresar un numero de recibo duplicado";
            $xdatos['typeinfo'] = "error";
        } else {
            if (!empty($_POST['anularComp'])) {
                $meses = $_POST['xmeses'];
                $codigo = $_POST['codigo'];
                $nombre = '[Recibo anulado]';
                $direccion = $_POST['direccion'];
                $municipio = $_POST['municipio'];
                $colonia = $_POST['colonia'];
                $cobrador = $_POST['cobrador'];
                $fecha = $_POST['fechaAbono'];
                $queryprefijoCobrador = $mysqli->query("SELECT prefijoCobro FROM tbl_cobradores WHERE codigoCobrador='$cobrador'");
                $prefijocobrador = $queryprefijoCobrador->fetch_array();
                $numerorecibo = $_POST['ultimoRecibo'];
                $recibo = $prefijocobrador['prefijoCobro']."-".$numerorecibo;
                if (!empty($_POST['consumidorfinal'])) {
                    $tipocomprobante = 2;
                }else{
                    $tipocomprobante = 1;
                }
                $servicio = strtoupper($_POST['servicio']);
                $cuenta = 1;
                for ($i = 0; $i < $meses; $i++) {
                    if ($arregloMeses['mesCargo']) {
                        $mesTabla = '01/' . $arregloMeses['mesCargo'];
                        $date = str_replace('/', '-', $mesTabla);
                        $date = date('Y-m-d', strtotime($date));
                        $mesTabla = date('Y-m-d', strtotime("+" . $cuenta . " month", strtotime($date)));
                        $mesTabla = date_format(date_create($mesTabla), 'm/Y');
                        $mes = $mesTabla;
                    } elseif ($arregloMeses['mesCargo'] == NULL) {
                        $mesTabla = $arreglodatosclientes['fecha_primer_factura'];
                        $mesTabla = date_format(date_create($mesTabla), 'm/Y');
                        $mes = $mesTabla;
                    }
                    $queryCargos = $mysqli->query("SELECT * FROM tbl_cargos WHERE codigoCliente='$codigo' AND mesCargo='$mes' AND tipoServicio='$servicio'");
                    $cargos = $queryCargos->fetch_array();
                    $cantidadCargos = $queryCargos->num_rows;
                    if ($cantidadCargos > 0) {
                        $factura = $cargos['numeroFactura'];
                    }else{
                        $factura = 'NULL';
                    }
                    $anularRecibo = $mysqli->query("INSERT INTO tbl_abonos(nombre, direccion, idMunicipio, idColonia, numeroFactura, tipoFactura, numeroRecibo, codigoCliente, codigoCobrador, cobradoPor, cuotaCable, cuotaInternet, saldoCable, saldoInternet, fechaCobro, fechaFactura, fechaVencimiento, fechaAbonado, mesCargo, anticipo, formaPago, tipoServicio, estado, anticipado, cargoImpuesto, totalImpuesto, cargoIva, totalIva, recargo, exento, anulada, idFactura, creadoPor)
                     VALUES ('$nombre','$direccion','$municipio','$colonia','$factura','$tipocomprobante','$recibo','$codigo','$cobrador','$cobrador','0.00','0.00','0.00','0.00','NULL','NULL','NULL','$fecha','$mes','0','efectivo','$servicio','CANCELADA','0','0.00','0.00','0.00','0.00','0.00','NULL','1','NULL','NULL')");
                    if ($anularRecibo) {
                        $cuenta +=1;
                    }else{
                        break;
                    }
                }
                if ($cuenta == $meses +1) {
                    $aumentanumerorecibo = $mysqli->query("UPDATE tbl_cobradores SET numeroAsignador=numeroAsignador+1 WHERE codigoCobrador='$cobrador'");
                    if ($aumentanumerorecibo) {
                        session_start();
                        $_SESSION['cobrador'] = $cobrador;
                        $xdatos['msg'] = "Recibo anulado";
                        $xdatos['typeinfo'] = "success";
                    }else{
                        $xdatos['msg'] = "Error Anu-02";
                        $xdatos['typeinfo'] = "error";
                    }
                }else{
                        $xdatos['msg'] = "Error Anu-01";
                        $xdatos['typeinfo'] = "error";
                }
            } else {
                $servicio = $_POST['servicio'];
                $servicio = ucwords($servicio);
                $codigo = $_POST['codigo'];
                $meses = $mysqli->query("SELECT mesCargo FROM tbl_abonos WHERE codigoCliente='$codigo' ORDER BY idAbono DESC LIMIT 1");
                $arregloMeses = $meses->fetch_array();
                $datoscliente = $mysqli->query("SELECT * FROM clientes WHERE cod_cliente='$codigo'");
                $arreglodatosclientes = $datoscliente->fetch_array();
                $meses = $_POST['xmeses'];
                $cuenta = 1;
                for ($i = 0; $i < $meses; $i++) {
                    if ($arregloMeses['mesCargo']) {
                        $mesTabla = '01/' . $arregloMeses['mesCargo'];
                        $date = str_replace('/', '-', $mesTabla);
                        $date = date('Y-m-d', strtotime($date));
                        $mesTabla = date('Y-m-d', strtotime("+" . $cuenta . " month", strtotime($date)));
                        $mesTabla = date_format(date_create($mesTabla), 'm/Y');
                        $mes = $mesTabla;
                    } elseif ($arregloMeses['mesCargo'] == NULL) {
                        $mesTabla = $arreglodatosclientes['fecha_primer_factura'];
                        $mesTabla = date_format(date_create($mesTabla), 'm/Y');
                        $mes = $mesTabla;
                    }
                    $queryCargos = $mysqli->query("SELECT * FROM tbl_cargos WHERE codigoCliente='$codigo' AND mesCargo='$mes' AND tipoServicio='$servicio'");
                    $cargos = $queryCargos->fetch_array();
                    $cantidadCargos = $queryCargos->num_rows;


                    $cuenta += 1;
                }

                $xdatos['msg'] = "Se cancelara " . $cantidadCargos . " ya generadas";
                $xdatos['typeinfo'] = "success";
            }
        }
        echo json_encode($xdatos);
        break;
}
