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
$proceso = $_POST['opcion'];
switch ($proceso) {
    case 'municipios':
        $id = $_POST['id'];
        $codigo = $_POST['codigo'];
        $queryMunicipios = $mysqli->query("SELECT * FROM tbl_municipios_cxc WHERE idDepto='$id'");
        $contador = 0;
        while($datos = $queryMunicipios->fetch_array()) {
            $xdatos['municipios'][$contador] = [
                'idMunicipio' => $datos['idMunicipio'],
                'nombreMunicipio' => $datos['nombreMunicipio']
            ];
            $contador+=1;
        } 
        $xdatos['filas'] = $queryMunicipios->num_rows;
        echo json_encode($xdatos);
        break;
    case 'colonia':
        $id = $_POST['id'];
        $queryColonias = $mysqli->query("SELECT * FROM tbl_colonias_cxc WHERE idMuni='$id'");
        $contador = 0;
        while($datos = $queryColonias->fetch_array()) {
            $xdatos['colonias'][$contador] = [
                'idColonia' => $datos['idColonia'],
                'nombreColonia' => $datos['nombreColonia']
            ];
            $contador+=1;
        } 
        $xdatos['filas'] = $queryColonias->num_rows;
        echo json_encode($xdatos);
        break;
    case 'vencimiento1':
        $meses = $_POST['meses'];
        $primerMes = $_POST['primermes'];
        $primerMes = date('Y-m-d', strtotime("+".$meses."month", strtotime($primerMes)));
        $xdatos['fechaFinal'] = $primerMes;
        echo json_encode($xdatos);
        break;
}
