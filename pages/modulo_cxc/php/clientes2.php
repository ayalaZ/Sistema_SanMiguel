<?php
require_once("../../../php/config.php");
if (!isset($_SESSION)) {
    session_start([
        'cookie_lifetime' => 86400,
    ]);
}
if (!isset($_SESSION["user"])) {
    header('Location: ../login.php');
}
$host = DB_HOST;
$user = DB_USER;
$password = DB_PASSWORD;
$database = $_SESSION['db'];
$mysqli = new mysqli($host, $user, $password, $database);
$cable = $_POST['variable1'];
$internet = $_POST['variable2'];
if ($cable == 1) {
    $servicioSuspendido = 'F';
    $sinServicio = 'F';
}elseif ($cable == 2) {
    $servicioSuspendido = 'T';
    $sinServicio = 'F';
}elseif ($cable == 3) {
    $servicioSuspendido = 'F';
    $sinServicio = 'T';
}


if ($cable == 0 && $internet == 0) {
    $query = "SELECT cod_cliente,nombre,direccion,numero_dui,servicio_suspendido,sin_servicio,estado_cliente_in FROM clientes ORDER BY cod_cliente";
}elseif ($cable != 1 && $internert == 0) {
    $query = "SELECT cod_cliente,nombre,direccion,numero_dui,servicio_suspendido,sin_servicio,estado_cliente_in FROM clientes WHERE servicio_suspendido='$servicioSuspendido' AND sin_servicio='$sinServicio' ORDER BY cod_cliente";
}elseif ($cable == 0 && $internet != 0) {
    $query = "SELECT cod_cliente,nombre,direccion,numero_dui,servicio_suspendido,sin_servicio,estado_cliente_in FROM clientes WHERE estado_cliente_in='$internert' ORDER BY cod_cliente";
}elseif ($cable != 0 && $internet != 0) {
    $query = "SELECT cod_cliente,nombre,direccion,numero_dui,servicio_suspendido,sin_servicio,estado_cliente_in FROM clientes WHERE servicio_suspendido='$servicioSuspendido' AND sin_servicio='$sinServicio' AND estado_cliente_in='$internert' ORDER BY cod_cliente";
}

$clientes = $mysqli->query($query);
$xdatos['filas'] = $clientes->num_rows;
$i=0;
while ($row = $clientes->fetch_assoc()) {
    $xdatos['clientes'][$i] = [
        'cod_cliente' => $row['cod_cliente'],
        'nombre' => $row['nombre'],
        'direccion' => $row['direccion'],
        'numero_dui' => $row['numero_dui'],
        'servicio_suspendido' => $row['servicio_suspendido'],
        'sin_servicio' => $row['sin_servicio'],
        'estado_cliente_in' => $row['estado_cliente_in']
    ];
    $i+=1;
}

echo json_encode($xdatos);