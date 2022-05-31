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
    case 'cobrador':
        $cod = $_POST['cod'];
        if ($cod == 'todos') {
            $zonas = $mysqli->query("SELECT * FROM tbl_colonias_cxc");
        }else{
            $zonas = $mysqli->query("SELECT * FROM tbl_colonias_cxc WHERE cobrador='$cod'");
        }
        $contador = 0;
        while ($datos = $zonas->fetch_array()) {
            $xdatos['colonias'][$contador] = [
                'idColonia' => $datos['idColonia'],
                'nombreColonia' => $datos['nombreColonia'],
            ];
            $contador+=1;
        }
        $xdatos['filas'] = $zonas->num_rows;
        echo json_encode($xdatos);
        break;
}
?>