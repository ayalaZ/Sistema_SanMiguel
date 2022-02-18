<?php
require_once("../../../php/config.php");
require_once("../getDatos.php");
$ex = new GetDatos();
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

$puntoVenta = $_POST['puntoVentaGenerar2'];
$mes = $_POST['mesGenerar2'];
$years = $_POST['anoGenerar2'];

date_default_timezone_set('America/El_Salvador');
putenv("LANG='es_ES.UTF-8'");
setlocale(LC_ALL, 'es_ES.UTF-8');
$monthName = strftime('%B', mktime(0, 0, 0, $mes));
$monthName = ucwords($monthName);
if (!empty($_POST['encabezados2'])) {
    $encabezados = 1;
} else {
    $encabezados = 0;
}
if (!empty($_POST['numPag2'])) {
    $numerodePagina = 1;
} else {
    $numerodePagina = 0;
}
if (!empty($_POST['libroDetallado2'])) {
    $detallado = 1;
} else {
    $detallado = 0;
}
if (!empty($_POST['resumen2'])) {
    $resumen = 1;
} else {
    $resumen = 0;
}
$tiposComprobantes = $_POST['Cfacturas'];
$documento = $_POST['documento2'];

switch ($documento) {
    case '1':
        include('pdf_dos.php');
        break;
    case '2':
       
        break;
}