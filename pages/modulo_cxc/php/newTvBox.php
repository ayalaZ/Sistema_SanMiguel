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

$numBox = $_POST['NewNumeroBox'];
$cast = $_POST['Newcast'];
$serialBox = $_POST['Newserie'];
$codigoCliente = $_POST['codigo'];
$creadoPor = $_SESSION['nombres'] . " " . $_SESSION['apellidos'];

$sqlcomprobar = "SELECT COUNT(*) AS TOTAL FROM tbl_tv_box WHERE cast='$cast'";
$resultado = $mysqli->query($sqlcomprobar);
$datos = $resultado->fetch_array();
if ($datos['TOTAL'] <= 0) {
    $sqlinsert = "INSERT INTO tbl_tv_box (boxNum,cast,serialBox,clientCode,user) VALUES('$numBox','$cast','$serialBox','$codigoCliente','$creadoPor')";
    $resultadoInsert = $mysqli->query($sqlinsert);
    if ($resultadoInsert) {
        $estado = 'EXITO';
        header("Location: ../infoCliente.php?id=" . $codigoCliente . "&estado=" . $estado);
        exit;
    } else {
        $estado = "ERROR2";
        header("Location: ../infoCliente.php?id=" . $codigoCliente . "&estado=" . $estado);
        exit;
    }
} else {
    $estado = "ERROR";
    header("Location: ../infoCliente.php?id=" . $codigoCliente . "&estado=" . $estado);
    exit;
}
