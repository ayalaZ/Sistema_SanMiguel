<?php
require_once("../../../../php/config.php");
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
    case 'descargar':
        $archivo = fopen("listado.txt","a") or die ("ERROR AL CREAR EL ARCHIVO");
        fwrite($archivo,"PRUEBA");
        fwrite($archivo,"\n");
        $xdatos['msg'] = "SE CREO ARCHIVO .txt bien";
        $xdatos['typeinfo'] = "success";
        echo json_encode($xdatos);
        break;
}