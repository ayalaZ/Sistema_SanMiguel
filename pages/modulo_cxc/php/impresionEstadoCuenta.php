<?php
require_once("../../../php/config.php");

$host = DB_HOST;
$user = DB_USER;
$password = DB_PASSWORD;
$usuario = $_SESSION['nombres'] . ' ' . $_SESSION['apellidos'];
if (!isset($_SESSION)) {
    session_start([
        'cookie_lifetime' => 86400,
    ]);
}

$database = $_SESSION['db'];
$mysqli = new mysqli($host, $user, $password, $database);

$desde = $_POST['desde'];
$hasta = $_POST['hasta'];
$codigo = $_POST['codigo'];
$servicio = $_POST['servicio'];
$documento = $_POST['documento'];
switch ($documento) {
    case 'true':
        include('pdf_estado.php');
        break;
    case 'false':
        echo 'HOLA 2';
        break;

}
