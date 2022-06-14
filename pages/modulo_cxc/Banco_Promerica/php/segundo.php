<?php
require_once("../../../../php/config.php");
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

$fecha = date("Y/m/d");
$downloadfile = "listado" . $fecha . ".txt";
$clientes = $mysqli->query("SELECT codigoCliente,nombre,idMunicipio,mesCargo,sum(cuotaCable),sum(cuotaInternet),fechaVencimiento FROM tbl_cargos WHERE estado='pendiente' AND nombre!='<<< Comprobante anulado >>>' AND tbl_cargos.codigoCliente NOT IN(SELECT cod_cliente FROM clientes WHERE (servicio_suspendido!='F' OR sin_servicio!='F') AND estado_cliente_in!='1')  GROUP BY codigoCliente");
while ($datos = $clientes->fetch_array()) {
    $codigo = $datos['codigoCliente'];
    $mescargo = $mysqli->query("SELECT idAbono,mesCargo FROM tbl_abonos WHERE codigoCliente='$codigo' ORDER BY idAbono DESC LIMIT 1;");
    $datosMes = $mescargo->fetch_array();
    $mesPendiente = '01/' . $datosMes['mesCargo'];
    $date = str_replace('/', '-', $mesPendiente);
    $date = date('Y-m-d', strtotime($date));
    $mesPendiente = date('Y-m-d', strtotime("+1 month", strtotime($date)));
    $mesPendiente = date_format(date_create($mesPendiente), 'm/Y');
    if ($datos['mesCargo'] == $mesPendiente) {
        $idmunicipio = $datos['idMunicipio'];
        $municipio = $mysqli->query("SELECT nombreMunicipio FROM tbl_municipios_cxc WHERE idMunicipio='$idmunicipio'");
        $datosmunicipio = $municipio->fetch_array();
        $valor = $datos['sum(cuotaCable)'] + $datos['sum(cuotaInternet)'];
        $valor = number_format($valor, 2);
        $extra = $mysqli->query("SELECT servicio_suspendido,sin_servicio,estado_cliente_in,valor_cuota,cuota_in FROM clientes WHERE cod_cliente='$codigo'");
        $datosExtras = $extra->fetch_array();
        if ($datosExtras['servicio_suspendido'] != 'T' && $datosExtras['sin_servicio'] != 'T') {
            $cable = 1;
        } else {
            $cable = 0;
        }
        if ($datosExtras['estado_cliente_in'] == '1') {
            $internet = 1;
        } else {
            $internet = 0;
        }
        if ($cable == 1 && $internet == 1) {
            $servicio = 'P';
            if ($datos['sum(cuotaCable)'] > 0) {
                $meses = number_format($datos['sum(cuotaCable)'], 2) / number_format($datosExtras['valor_cuota'], 2);
            } else {
                $meses = number_format($datos['sum(cuotaInternet)'], 2) / number_format($datosExtras['cuota_in'], 2);
            }
        } elseif ($cable == 1 && $internet == 0) {
            $servicio = 'C';
            $meses = number_format($datos['sum(cuotaCable)'], 2) / number_format($datosExtras['valor_cuota'], 2);
        } elseif ($cable == 0 && $internet == 1) {
            $servicio = 'I';
            $meses = number_format($datos['sum(cuotaInternet)'], 2) / number_format($datosExtras['cuota_in'], 2);
        }
        $hoy = date('Y-m-d');
        if ($meses == 1 && $datos['fechaVencimiento'] < $hoy) {
            $valor = $valor + 3;
        } elseif ($meses == 2) {
            $vencimieto = $datos['fechaVencimiento'];
            $date = str_replace('/', '-', $vencimieto);
            $date = date('Y-m-d', strtotime($date));
            $FV = date('Y-m-d', strtotime("+1 month", strtotime($date)));
            if ($FV < $hoy) {
                $valor = $valor + 5;
            }else{
                $valor = $valor + 3;
            }
            
        }
        $filecontent = $filecontent . $datos['codigoCliente'] . "," . $datos['nombre'] . "," . $datosmunicipio['nombreMunicipio'] . "," . $datos['mesCargo'] . ",$" . $valor . "," . $servicio . "," . $meses . "\n";
    }
}
header("Content-disposition: attachment; filename=$downloadfile");
header("Content-Type: application/force-download");
header("Content-Transfer-Encoding: binary");
header("Content-Length: " . strlen($filecontent));
header("Pragma: no-cache");
header("Expires: 0");

echo $filecontent;
