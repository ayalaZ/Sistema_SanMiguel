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
            $xdatos['cuota'] = round($arreglodatosclientes['cuota_in'],2);
            $xdatos['cambio'] = 'true';
            $tabla = $mysqli->query("SELECT * FROM tbl_cargos WHERE codigoCliente='$codigo' AND estado='pendiente' AND tipoServicio='I' AND anulada='0'");
            $contador = 0;
            while ($datos = $tabla->fetch_assoc()) {
                $xdatos['tabla'][$contador] = [
                    'numeroFactura'=>$datos['numeroFactura'],
                    'mesCargo'=>$datos['mesCargo'],
                    'cuotaInternet'=>$datos['cuotaInternet'],
                    'fechaVencimiento'=>$datos['fechaVencimiento'],
                ];
                $contador +=1;
            }
            $xdatos['filas'] =$tabla->num_rows; 
        }else{
            $xdatos['dia'] = $arreglodatosclientes['dia_cobro'];
            $xdatos['cuota'] = round($arreglodatosclientes['valor_cuota'], 2);
            $xdatos['cambio'] = 'false';
            $tabla = $mysqli->query("SELECT * FROM tbl_cargos WHERE codigoCliente='$codigo' AND estado='pendiente' AND tipoServicio='C' AND anulada='0'");
            $contador = 0;
            while ($datos = $tabla->fetch_assoc()) {
                $xdatos['tabla'][$contador] = [
                    'numeroFactura'=>$datos['numeroFactura'],
                    'mesCargo'=>$datos['mesCargo'],
                    'cuotaCable'=>$datos['cuotaCable'],
                    'fechaVencimiento'=>$datos['fechaVencimiento'],
                ];
                $contador +=1;
            }
            $xdatos['filas'] =$tabla->num_rows; 
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
            $xdatos['cuota'] = round($arreglodatosclientes['cuota_in'],2);
            $tabla = $mysqli->query("SELECT * FROM tbl_cargos WHERE codigoCliente='$codigo' AND estado='pendiente' AND tipoServicio='I' AND anulada='0'");
            $contador = 0;
            while ($datos = $tabla->fetch_assoc()) {
                $xdatos['tabla'][$contador] = [
                    'numeroFactura'=>$datos['numeroFactura'],
                    'mesCargo'=>$datos['mesCargo'],
                    'cuotaInternet'=>$datos['cuotaInternet'],
                    'fechaVencimiento'=>$datos['fechaVencimiento'],
                ];
                $contador +=1;
            }
            $xdatos['filas'] =$tabla->num_rows;
        } else {
            $xdatos['cuota'] = round($arreglodatosclientes['valor_cuota'],2);
            $tabla = $mysqli->query("SELECT * FROM tbl_cargos WHERE codigoCliente='$codigo' AND estado='pendiente' AND tipoServicio='C' AND anulada='0'");
            $contador = 0;
            while ($datos = $tabla->fetch_assoc()) {
                $xdatos['tabla'][$contador] = [
                    'numeroFactura'=>$datos['numeroFactura'],
                    'mesCargo'=>$datos['mesCargo'],
                    'cuotaCable'=>$datos['cuotaCable'],
                    'fechaVencimiento'=>$datos['fechaVencimiento'],
                ];
                $contador +=1;
            }
            $xdatos['filas'] =$tabla->num_rows;
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
                $xdatos['meses'] = $mesPendiente3.",".$mesPendiente2 . "," . $mes;
                break;
            case '4':
                $mesPendiente2 = date('Y-m-d', strtotime("+1 month", strtotime($date)));
                $mesPendiente2 = date_format(date_create($mesPendiente2), 'm/Y');
                $mesPendiente3 = date('Y-m-d', strtotime("+2 month", strtotime($date)));
                $mesPendiente3 = date_format(date_create($mesPendiente3), 'm/Y');
                $mesPendiente4 = date('Y-m-d', strtotime("+3 month", strtotime($date)));
                $mesPendiente4 = date_format(date_create($mesPendiente4), 'm/Y');
                $xdatos['meses'] = $mesPendiente4.",".$mesPendiente3.",".$mesPendiente2 . "," . $mes;
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
                $xdatos['meses'] = $mesPendiente5.",".$mesPendiente4.",".$mesPendiente3.",".$mesPendiente2 . "," . $mes;
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
                $xdatos['meses'] = $mesPendiente6.",".$mesPendiente5.",".$mesPendiente4.",".$mesPendiente3.",".$mesPendiente2 . "," . $mes;
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
                $xdatos['meses'] = $mesPendiente7.",".$mesPendiente6.",".$mesPendiente5.",".$mesPendiente4.",".$mesPendiente3.",".$mesPendiente2 . "," . $mes;
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
                $xdatos['meses'] = $mesPendiente8.",".$mesPendiente7.",".$mesPendiente6.",".$mesPendiente5.",".$mesPendiente4.",".$mesPendiente3.",".$mesPendiente2 . "," . $mes;
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
                $xdatos['meses'] = $mesPendiente9.",".$mesPendiente8.",".$mesPendiente7.",".$mesPendiente6.",".$mesPendiente5.",".$mesPendiente4.",".$mesPendiente3.",".$mesPendiente2 . "," . $mes;
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
                $xdatos['meses'] = $mesPendiente10.",".$mesPendiente9.",".$mesPendiente8.",".$mesPendiente7.",".$mesPendiente6.",".$mesPendiente5.",".$mesPendiente4.",".$mesPendiente3.",".$mesPendiente2 . "," . $mes;
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
                $xdatos['meses'] = $mesPendiente11.",".$mesPendiente10.",".$mesPendiente9.",".$mesPendiente8.",".$mesPendiente7.",".$mesPendiente6.",".$mesPendiente5.",".$mesPendiente4.",".$mesPendiente3.",".$mesPendiente2 . "," . $mes;
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
                $xdatos['meses'] = $mesPendiente12.",".$mesPendiente11.",".$mesPendiente10.",".$mesPendiente9.",".$mesPendiente8.",".$mesPendiente7.",".$mesPendiente6.",".$mesPendiente5.",".$mesPendiente4.",".$mesPendiente3.",".$mesPendiente2 . "," . $mes;
                break;
        }
        echo json_encode($xdatos);
        break;
}
