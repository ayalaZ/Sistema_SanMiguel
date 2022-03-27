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
$valor = $_POST['valor'];

if ($valor == 'false') {
    $servicio = 'I';
}else{
    $servicio = 'C';
}

switch ($proceso) {
    case 'servicio':
        $cargos = $mysqli->query("SELECT * FROM tbl_cargos WHERE codigoCliente='$codigo' AND tipoServicio='$servicio' AND anulada='0' ORDER BY mesCargo");
        $contador = 0;
        while ($datos = $cargos->fetch_assoc()) {
            $mesTabla = '01/' . $datos['mesCargo'];
            $date = str_replace('/', '-', $mesTabla);
            $date = date('Ymd', strtotime($date));
            if ($servicio == 'C') {
                $cuota = $datos['cuotaCable'];
            }else{
                $cuota = $datos['cuotaInternet'];
            }
            $xdatos['tabla'][$contador] = [
                'numeroRecibo' => $datos['numeroRecibo'],
                'tipoServicio' => $datos['tipoServicio'],
                'numeroFactura' => $datos['numeroFactura'],
                'mesCargo' => $datos['mesCargo'],
                'fecha' => $date,
                'fechaFactura' => $datos['fechaFactura'],
                'fechaVencimiento' => $datos['fechaVencimiento'],
                'cuota' => $cuota,
                'totalImpuesto' => $datos['totalImpuesto']
            ];
            $contador +=1;
        }
        $xdatos['filas'] = $cargos->num_rows;
        /////////////////////////////////////////////////////////////////////////////////////////
        $abonos = $mysqli->query("SELECT * FROM tbl_abonos WHERE codigoCliente='$codigo' AND tipoServicio='$servicio' AND anulada='0' ORDER BY mesCargo");
        $contador2 = 0;
        while ($datos2 = $abonos->fetch_assoc()) {
            $mesTabla = '01/' . $datos2['mesCargo'];
            $date2 = str_replace('/', '-', $mesTabla);
            $date2 = date('Ymd', strtotime($date2));
            if ($servicio == 'C') {
                $cuota = $datos2['cuotaCable'];
            }else{
                $cuota = $datos2['cuotaInternet'];
            }
            $xdatos['tabla2'][$contador2] = [
                'numeroRecibo' => $datos2['numeroRecibo'],
                'tipoServicio' => $datos2['tipoServicio'],
                'numeroFactura' => $datos2['numeroFactura'],
                'mesCargo' => $datos2['mesCargo'],
                'fecha' => $date2,
                'fechaAbonado' => $datos2['fechaAbonado'],
                'fechaVencimiento' => $datos2['fechaVencimiento'],
                'cuota' => $cuota,
                'totalImpuesto' => $datos2['totalImpuesto']
            ];
            $contador2 +=1;
        }
        $xdatos['filas2'] = $abonos->num_rows;
        echo json_encode($xdatos);
        break;
}