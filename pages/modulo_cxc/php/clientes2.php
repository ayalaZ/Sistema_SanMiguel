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
$cable = $_POST['cable'];
$internet = $_POST['internet'];
if ($cable == 0){
   $cable = " AND (servicio_suspendido IS NULL OR servicio_suspendido = 'F' OR servicio_suspendido = '' OR servicio_suspendido = 'T') AND (sin_servicio = 'F' OR sin_servicio='T' OR sin_servicio='')";
}elseif ($cable == 1){
   $cable = " AND (servicio_suspendido IS NULL OR servicio_suspendido = 'F' OR servicio_suspendido = '') AND (sin_servicio = 'F')";
}elseif ($cable == 2){
   $cable = " AND (servicio_suspendido = 'T') AND (sin_servicio = 'F')";
}elseif ($cable == 3){
   $cable = " AND (sin_servicio = 'T')";
}

if ($internet == 0){
    $internet = " AND (estado_cliente_in = 1 OR estado_cliente_in = 2 OR estado_cliente_in = 3)";
}elseif($internet == 1){
    $internet = " AND (estado_cliente_in = 1)";
}elseif($internet == 2){
    $internet = " AND (estado_cliente_in = 2)";
}elseif($internet == 3){
    $internet = " AND (estado_cliente_in = 3)";
}

$clientes = $mysqli->query("SELECT cod_cliente, numero_dui, nombre, direccion, servicio_suspendido, sin_servicio, estado_cliente_in FROM clientes WHERE cod_cliente != '00000' ".$cable." ".$internet." ORDER BY cod_cliente");
$xdatos['filass'] = $clientes->num_rows;
$i=0;
while($row = $clientes->fetch_assoc()) {
    $xdatos['clientess'][$i] = [
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