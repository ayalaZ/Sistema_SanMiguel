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
date_default_timezone_set('America/El_Salvador');
$database = $_SESSION['db'];
$mysqli = new mysqli($host, $user, $password, $database);
$codigo = $_POST['cod'];
$numeroRecibo = $mysqli->query("SELECT numeroAsignador FROM tbl_cobradores WHERE codigoCobrador='$codigo'");
$arregloNumeroRecibo = $numeroRecibo->fetch_array();
$nuevoNumero = $arregloNumeroRecibo['numeroAsignador'] + 1;
$xdatos['valor'] = substr(str_repeat(0, 6).$nuevoNumero, - 6);
if ($codigo == '002' || $codigo == '020') {
    $xdatos['fecha'] = date('Y-m-d');
}
echo json_encode($xdatos);