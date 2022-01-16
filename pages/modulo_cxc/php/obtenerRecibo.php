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
$codigo = $_POST['cod'];

$numeroRecibo = $mysqli->query("SELECT numeroAsignador FROM tbl_cobradores WHERE codigoCobrador='$codigo'");
$arregloNumeroRecibo = $numeroRecibo->fetch_array();
$nuevoNumero = $arregloNumeroRecibo['numeroAsignador'] + 1;
$xdatos['valor'] = substr(str_repeat(0, 4).$nuevoNumero, - 4);

echo json_encode($xdatos);