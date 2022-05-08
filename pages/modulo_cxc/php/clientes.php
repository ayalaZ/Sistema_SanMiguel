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

$clientes = $mysqli->query("SELECT cod_cliente,nombre,direccion,numero_dui,servicio_suspendido,sin_servicio,estado_cliente_in FROM clientes ORDER BY cod_cliente");
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