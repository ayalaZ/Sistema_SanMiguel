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
$codigo = $_POST['cod'];
$datoscliente = $mysqli->query("SELECT * FROM clientes WHERE cod_cliente='$codigo'");
$arreglodatosclientes = $datoscliente->fetch_array();
$servicio = $_POST['serv'];
$sservicio = strtoupper($servicio);
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
        $sservicio = strtoupper($servicio);
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
            $querymeses = $mysqli->query("SELECT mesCargo FROM tbl_abonos WHERE codigoCliente='$codigo' AND tipoServicio='I' ORDER BY idAbono DESC LIMIT 1");
            $arregloMeses = $querymeses->fetch_array();
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
            $querymeses = $mysqli->query("SELECT mesCargo FROM tbl_abonos WHERE codigoCliente='$codigo' AND tipoServicio='C' ORDER BY idAbono DESC LIMIT 1");
            $arregloMeses = $querymeses->fetch_array();
        }
        if ($arregloMeses['mesCargo']) { //si el cargo esta generado 
            $mesTabla = '01/' . $arregloMeses['mesCargo'];
            $date = str_replace('/', '-', $mesTabla);
            $date = date('Y-m-d', strtotime($date));
            $mesTabla = date('Y-m-d', strtotime("+1 month", strtotime($date)));
            $mesTabla = date_format(date_create($mesTabla), 'm/Y');
            $mes = $mesTabla;
        } elseif ($arregloMeses['mesCargo'] == NULL) { //en caso de que el mes aun no se habra generado
            $mesTabla = $arreglodatosclientes['fecha_primer_factura']; //el mes que se canceara es el indicado en la fecha de primer factura
            $mesTabla = date_format(date_create($mesTabla), 'm/Y');
            $mes = $mesTabla;
        }
        $xdatos['nuevomes'] = $mes;
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
        $servicio = $_POST['serv'];
        $sservicio = strtoupper($servicio);
        $mes = "";
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
        if ($_POST['mover'] == 0) {
            if ($sservicio == 'I') {
                $querymeses = $mysqli->query("SELECT mesCargo FROM tbl_abonos WHERE codigoCliente='$codigo' AND tipoServicio='I' ORDER BY idAbono DESC LIMIT 1");
                $arregloMeses = $querymeses->fetch_array();
            } else {
                $querymeses = $mysqli->query("SELECT mesCargo FROM tbl_abonos WHERE codigoCliente='$codigo' AND tipoServicio='C' ORDER BY idAbono DESC LIMIT 1");
                $arregloMeses = $querymeses->fetch_array();
            }
        } else {
            $arregloMeses['merCargo'] == NULL;
        }
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
        $idCobrador = $_POST['cobrador']; //obteniendo id del cobrador
        $querycobrador = $mysqli->query("SELECT * FROM tbl_cobradores WHERE codigoCobrador='$idCobrador'");
        $cobrador = $querycobrador->fetch_array();
        $recibo = $cobrador['prefijoCobro'] . "-" . $_POST['ultimoRecibo']; //obteniendo el numero de recibo que se va abonar
        $queryrecibo = $mysqli->query("SELECT * FROM tbl_abonos WHERE numeroRecibo='$recibo'"); //verificando si el recibo ya existe
        $numerorecibos = $queryrecibo->num_rows; //obteniendo cantidad de recibos
        if ($numerorecibos > 0) { //en caso de que habran recibos ingresador
            $xdatos['msg'] = "Esta intentando ingresar un numero de recibo duplicado"; //devolver este mensaje para que aparezca en pantalla
            $xdatos['typeinfo'] = "error"; //tipo de mensaje
        } else { //en caso contrario que no se encuentre el mismo recibo previamente ingresado
            if (!empty($_POST['anularComp'])) { //en caso que el usuario marco la opcion de anular el recibo
                $meses = $_POST['xmeses'];
                $codigo = $_POST['codigo'];
                $nombre = '[Recibo anulado]';
                $cobrador = $_POST['cobrador'];
                $fecha = $_POST['fechaAbono'];
                $queryprefijoCobrador = $mysqli->query("SELECT prefijoCobro FROM tbl_cobradores WHERE codigoCobrador='$cobrador'"); //obteniendo el prefijo para el recibo
                $prefijocobrador = $queryprefijoCobrador->fetch_array();
                $numerorecibo = $_POST['ultimoRecibo'];
                $recibo = $prefijocobrador['prefijoCobro'] . "-" . $numerorecibo; //uniendo prefijo con numero de recibo
                if (!empty($_POST['consumidorfinal'])) { //en caso que el cliente de tipo consumidor final
                    $tipocomprobante = 2; //tipo de comprobante sera el 2
                } else { //en caso contrario el cliente es de tipo credito fiscal
                    $tipocomprobante = 1; //y el tipo de comprobante sera 1
                }
                $servicio = strtoupper($_POST['servicio']); //obteniendo el servicio que cancelara
                $querycliente = $mysqli->query("SELECT * FROM clientes WHERE cod_cliente='$codigo'"); //obteniendo datos del cliente
                $datoscliente = $querycliente->fetch_array();
                $direccion = $datoscliente['direccion'];
                $municipio = $datoscliente['id_municipio'];
                $colonia = $datoscliente['id_colonia'];
                $creadoPor = $_SESSION['nombres'] . ' ' . $_SESSION['apellidos'];
                $cuenta = 1; //variable para llevar la cuenta de los meses que cancelara 
                for ($i = 0; $i < $meses; $i++) { //recorriendo si los cargos ya estan generados
                    if (empty($_POST['mover'])) {
                        if ($servicio == 'I') {
                            $querymeses = $mysqli->query("SELECT mesCargo FROM tbl_abonos WHERE codigoCliente='$codigo' AND tipoServicio='I' ORDER BY idAbono DESC LIMIT 1");
                            $arregloMeses = $querymeses->fetch_array();
                        } else {
                            $querymeses = $mysqli->query("SELECT mesCargo FROM tbl_abonos WHERE codigoCliente='$codigo' AND tipoServicio='C' ORDER BY idAbono DESC LIMIT 1");
                            $arregloMeses = $querymeses->fetch_array();
                        }
                    }
                    if ($arregloMeses['mesCargo']) { //si el cargo esta generado 
                        $mesTabla = '01/' . $arregloMeses['mesCargo'];
                        $date = str_replace('/', '-', $mesTabla);
                        $date = date('Y-m-d', strtotime($date));
                        $mesTabla = date('Y-m-d', strtotime("+1 month", strtotime($date)));
                        $mesTabla = date_format(date_create($mesTabla), 'm/Y');
                        $mes = $mesTabla;
                    } elseif ($arregloMeses['mesCargo'] == NULL) { //en caso de que el mes aun no se habra generado
                        $mesTabla = $arreglodatosclientes['fecha_primer_factura']; //el mes que se canceara es el indicado en la fecha de primer factura
                        $mesTabla = date_format(date_create($mesTabla), 'm/Y');
                        $mes = $mesTabla;
                    }
                    $queryCargos = $mysqli->query("SELECT * FROM tbl_cargos WHERE codigoCliente='$codigo' AND mesCargo='$mes' AND tipoServicio='$servicio'"); //obtener los datos del mes que se cancelara
                    $cargos = $queryCargos->fetch_array();
                    $cantidadCargos = $queryCargos->num_rows; //cantidad de cargos 
                    if ($cantidadCargos > 0) { //en caso que existan cargos ya generados
                        $factura = $cargos['numeroFactura']; //el numero de factura que se almacenara sera el de la fatura ya generada
                    } else {
                        $factura = $mes; //en caso contrario el numero de factura se reemplazara por el mes que se esta cancelando
                    }
                    if ($i == 0) {
                        $desde = $mes;
                    }
                    if ($i == $meses - 1) {
                        $hasta = $mes;
                    }
                    //ingresar el abono
                    $anularRecibo = $mysqli->query("INSERT INTO tbl_abonos(nombre, direccion, idMunicipio, idColonia, numeroFactura, tipoFactura, numeroRecibo, codigoCliente, codigoCobrador, cobradoPor, cuotaCable, cuotaInternet, saldoCable, saldoInternet, fechaCobro, fechaFactura, fechaVencimiento, fechaAbonado, mesCargo, anticipo, formaPago, tipoServicio, estado, anticipado, cargoImpuesto, totalImpuesto, cargoIva, totalIva, recargo, exento, anulada, idFactura, creadoPor)
                    VALUES ('$nombre','$direccion','$municipio','$colonia','$factura','$tipocomprobante','$recibo','$codigo','$cobrador','$cobrador','NULL','0.00','0.00','0.00','NULL','NULL','NULL','$fecha','$mes','0','efectivo','$servicio','CANCELADA','0','0.00','0.00','0.00','0.00','0.00','NULL','1','NULL','$creadoPor')");
                    $xdatos['Crecibo'] = $recibo;
                    $xdatos['Ccodigo'] = $codigo;
                    $xdatos['Cservicio'] = $servicio;
                    $xdatos['Cdesde'] = $desde;
                    $xdatos['Chasta'] = $hasta;
                    if ($anularRecibo) {
                        $cuenta += 1; //aunmentar en 1 si el abono se ingreso
                    } else {
                        break; //en caso contrario salir del ciclo
                    }
                }
                if ($cuenta == $meses + 1) { //verificar si la variable cuenta ya es igual que la cantidad de meses a abonar
                    //aumentar el numero de recio que se va a utilizar
                    $aumentanumerorecibo = $mysqli->query("UPDATE tbl_cobradores SET numeroAsignador=$numerorecibo WHERE codigoCobrador='$cobrador'");
                    if ($aumentanumerorecibo) { //si el aumento se hace efectivo
                        session_start();
                        $_SESSION['cobrador'] = $cobrador; //crear la variable de sesion cobrador
                        if ($cobrador != '002' || $cobrador != '020') {
                            $_SESSION['fecha'] = $fechaAbono;
                        }
                        $xdatos['msg'] = "Recibo anulado"; //enviar este mensaje para que aparezca en pantalla
                        $xdatos['typeinfo'] = "success"; //tipo de alerta
                    } else { //en caso contrario
                        $xdatos['msg'] = "Error Anu-02"; //monstrar en pantalla este mensaje 
                        $xdatos['typeinfo'] = "error"; //tipo de alerta 
                    }
                } else {
                    $xdatos['msg'] = "Error Anu-01";
                    $xdatos['typeinfo'] = "error";
                }
            } else { //en caso que el usuario no habara marcado la opcion de anular recibo
                $servicio = $_POST['servicio'];
                $servicio = ucwords($servicio);
                $codigo = $_POST['codigo'];
                $cobrador = $_POST['cobrador'];
                $numeroRecibo = $_POST['ultimoRecibo'];
                $estado = "CANCELADA";
                //obtener el ultimo mes abonado
                $datoscliente = $mysqli->query("SELECT * FROM clientes WHERE cod_cliente='$codigo'"); //obtener datos del cliente que esta cancelando
                $arreglodatosclientes = $datoscliente->fetch_array();
                $meses = $_POST['xmeses'];
                $cuota = doubleval($_POST['valorCuota']);
                $fechaAbono = $_POST['fechaAbono'];
                $nombre = $arreglodatosclientes['nombre'];
                $direccion = $arreglodatosclientes['direccion'];
                $municipio = $arreglodatosclientes['id_municipio'];
                $colonia = $arreglodatosclientes['id_colonia'];
                $creadoPor = $_SESSION['nombres'] . ' ' . $_SESSION['apellidos'];
                $cargoImpuesto = $_POST['porImp'];
                $totaImpuesto = $_POST['impSeg'];
                $cero = doubleval(0);
                $iva = doubleval(0.13);
                $totalIva = round(doubleval((doubleval($cuota) / 1.13) * 0.13), 2);
                $formaPago = $_POST['formaPago'];
                if (!empty($_POST['consumidorfinal'])) { //en caso que el cliente de tipo consumidor final
                    $tipocomprobante = 2; //tipo de comprobante sera el 2
                } else { //en caso contrario el cliente es de tipo credito fiscal
                    $tipocomprobante = 1; //y el tipo de comprobante sera 1
                }
                $queryprefijoCobrador = $mysqli->query("SELECT prefijoCobro FROM tbl_cobradores WHERE codigoCobrador='$cobrador'"); //obteniendo el prefijo para el recibo
                $prefijocobrador = $queryprefijoCobrador->fetch_array();
                $recibo = $prefijocobrador['prefijoCobro'] . "-" . $numeroRecibo; //uniendo prefijo con numero de recibo
                $cuenta = 1;
                for ($i = 0; $i < $meses; $i++) { //ciclo para obtener los meses ya generados del cliente
                    if (empty($_POST['mover'])) {
                        if ($servicio == 'I') {
                            $querymeses = $mysqli->query("SELECT mesCargo FROM tbl_abonos WHERE codigoCliente='$codigo' AND tipoServicio='I' ORDER BY idAbono DESC LIMIT 1");
                            $arregloMeses = $querymeses->fetch_array();
                        } else {
                            $querymeses = $mysqli->query("SELECT mesCargo FROM tbl_abonos WHERE codigoCliente='$codigo' AND tipoServicio='C' ORDER BY idAbono DESC LIMIT 1");
                            $arregloMeses = $querymeses->fetch_array();
                        }
                    }
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
                    $queryCargos = $mysqli->query("SELECT * FROM tbl_cargos WHERE codigoCliente='$codigo' AND mesCargo='$mes' AND tipoServicio='$servicio'"); //obtener datos de los meses generados 
                    $cargos = $queryCargos->fetch_array();
                    $cantidadCargos = $queryCargos->num_rows; //cantidad de cargos

                    if ($cantidadCargos > 0) { //si existen cargos ya generados 
                        $factura = $cargos['numeroFactura'];
                        $fechaCobro = date_format(date_create($cargos['fechaCobro']), "Y-m-d");
                        $fechaFactura = date_format(date_create($cargos['fechaFactura']), "Y-m-d");
                        $fechaVencimiento = date_format(date_create($cargos['fechaVencimiento']), "Y-m-d");
                        $idcargo = $cargos['idFactura'];
                        $Eanticipado = 1;
                    } else {
                        $factura = $mes;
                        $fechaCobro = '';
                        $fechaFactura = '';
                        $fechaVencimiento = '';
                        $idcargo = '';
                        $Eanticipado = 0;
                    }
                    if ($i == 0) {
                        $desde = $mes;
                    }
                    if ($i == $meses - 1) {
                        $hasta = $mes;
                    }

                    if ($servicio == 'C') {
                        $queryIngresarAbono = "INSERT INTO tbl_abonos(nombre, direccion, idMunicipio, idColonia, numeroFactura, tipoFactura, numeroRecibo, codigoCliente, codigoCobrador, cobradoPor, cuotaCable, cuotaInternet, saldoCable, saldoInternet, fechaCobro, fechaFactura, fechaVencimiento, fechaAbonado, mesCargo, anticipo, formaPago, tipoServicio, estado, anticipado, cargoImpuesto, totalImpuesto, cargoIva, totalIva, recargo, exento, anulada, idFactura, creadoPor) VALUES ('$nombre','$direccion','$municipio','$colonia','$factura','$tipocomprobante','$recibo','$codigo','$cobrador','$cobrador','$cuota','$cero','$cero','$cero','$fechaCobro','$fechaFactura','$fechaVencimiento','$fechaAbono','$mes','$cero','$formaPago','$servicio','$estado','$Eanticipado','$cargoImpuesto','$totaImpuesto','$iva','$totalIva','$cero','s','$cero','$idcargo','$creadoPor')";
                        $queryActualizarCargo = "UPDATE tbl_cargos SET saldoCable=saldoCable - $cuota, fechaCobro='$fechaCobro', fechaAbonado='$fechaAbono', estado='CANCELADA' WHERE idFactura='$idcargo'"; //actualizar datos del cargo ya generado si el servicido que cancelara es cable
                        $actualizarCliente = "UPDATE clientes SET saldoCable = saldoCable - $cuota, fecha_ult_pago=$mes WHERE cod_cliente='$codigo'";
                    } else {
                        $queryIngresarAbono = "INSERT INTO tbl_abonos(nombre, direccion, idMunicipio, idColonia, numeroFactura, tipoFactura, numeroRecibo, codigoCliente, codigoCobrador, cobradoPor, cuotaCable, cuotaInternet, saldoCable, saldoInternet, fechaCobro, fechaFactura, fechaVencimiento, fechaAbonado, mesCargo, anticipo, formaPago, tipoServicio, estado, anticipado, cargoImpuesto, totalImpuesto, cargoIva, totalIva, recargo, exento, anulada, idFactura, creadoPor) VALUES ('$nombre','$direccion','$municipio','$colonia','$factura','$tipocomprobante','$recibo','$codigo','$cobrador','$cobrador','$cero','$cuota','$cero','$cero','$fechaCobro','$fechaFactura','$fechaVencimiento','$fechaAbono','$mes','$cero','$formaPago','$servicio','$estado','$Eanticipado','$cargoImpuesto','$totaImpuesto','$iva','$totalIva','$cero','s','$cero','$idcargo','$creadoPor')";
                        $queryActualizarCargo = "UPDATE tbl_cargos SET saldoInternet=saldoInternet - $cuota, fechaCobro='$fechaCobro', fechaAbonado='$fechaAbono', estado='CANCELADA' WHERE idFactura='$idcargo'"; //actualizar datos del cargo ya generado si el servicio que cancelara es internet
                        $actualizarCliente = "UPDATE clientes SET saldoInternet = saldoInternet - $cuota, fecha_ult_pago=$mes WHERE cod_cliente='$codigo'";
                    }
                    $aumentanumerorecibo = "UPDATE tbl_cobradores SET numeroAsignador=$numeroRecibo WHERE codigoCobrador='$cobrador'";

                    $verificarNumeroAsignador = $mysqli->query("SELECT * FROM tbl_cobradores WHERE ('$numeroRecibo' Between desdeNumero And hastaNumero) AND codigoCobrador='$cobrador'");
                    $CantidadNumeroAsignador = $verificarNumeroAsignador->num_rows;
                    if ($CantidadNumeroAsignador > 0) {
                        $ingresarAbono = $mysqli->query($queryIngresarAbono);
                        if ($ingresarAbono) {
                            if ($cantidadCargos > 0) {
                                $actualizarCargo = $mysqli->query($queryActualizarCargo);
                            }
                            $QueryactualizarCliente = $mysqli->query($actualizarCliente);
                            if ($QueryactualizarCliente) {
                                $cuenta += 1;
                            } else {
                                $xdatos['msg'] = "Error al ingresar abono 0003";
                                $xdatos['typeinfo'] = "error";
                            }
                        } else {
                            $xdatos['msg'] = "Error al ingresar abono 0001";
                            $xdatos['typeinfo'] = "error";
                        }
                    } else {
                        $xdatos['msg'] = "Error al ingresar abono 0002";
                        $xdatos['typeinfo'] = "error";
                    }
                }

                if ($cuenta == $meses + 1) {
                    $queryNumeroAsigandor = $mysqli->query($aumentanumerorecibo);
                    if ($queryNumeroAsigandor) {
                        session_start();
                        $_SESSION['cobrador'] = $cobrador; //crear la variable de sesion cobrador
                        $_SESSION['codigoCobro'] = $codigo;
                        if ($cobrador != '002' || $cobrador != '020') {
                            $_SESSION['fecha'] = $fechaAbono;
                        }
                        $xdatos['Crecibo'] = $recibo;
                        $xdatos['Ccodigo'] = $codigo;
                        $xdatos['Cservicio'] = $servicio;
                        $xdatos['Cdesde'] = $desde;
                        $xdatos['Chasta'] = $hasta;
                        $xdatos['msg'] = "Recibo ingresado correctamente";
                        $xdatos['typeinfo'] = "success";
                    } else {
                        $xdatos['msg'] = "Error al ingresar abono 0004";
                        $xdatos['typeinfo'] = "error";
                    }
                }
            }
        }
        echo json_encode($xdatos);
        break;
    case 'mover':
        $codigo = $_POST['codigo'];
        $datoscliente = $mysqli->query("SELECT * FROM clientes WHERE cod_cliente='$codigo'"); //obtener datos del cliente que esta cancelando
        $arreglodatosclientes = $datoscliente->fetch_array();
        $mesTabla = $arreglodatosclientes['fecha_primer_factura'];
        $mesTabla = date_format(date_create($mesTabla), 'm/Y');
        $mes = $mesTabla;
        $xdatos['meses'] = $mes;
        echo json_encode($xdatos);
        break;
}
