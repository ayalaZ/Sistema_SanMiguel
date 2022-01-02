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

$numBox = $_POST['NumeroBox'];
$cast = $_POST['cast'];
$serialBox = $_POST['serie'];
$codigoCliente = $_POST['codigo'];
$idBox = $_POST['idBox'];

$sqlcomprobar = "SELECT COUNT(*) AS TOTAL FROM tbl_tv_box WHERE  cast='$cast' AND idBox!='$idBox'";
$resultado = $mysqli->query($sqlcomprobar);
$datos = $resultado->fetch_array();
if ($datos['TOTAL'] <= 0) {
    $sqlupdate = "UPDATE tbl_tv_box SET boxNum='$numBox', cast='$cast', serialBox='$serialBox' WHERE idBox='$idBox' AND clientCode='$codigoCliente'";
    $resultadoUpdate = $mysqli->query($sqlupdate);
    if ($resultadoUpdate) {
        $estado = 'EXITO';
        header("Location: ../infoCliente.php?id=" . $codigoCliente . "&estado=" . $estado);
        exit;
    } else {
        $estado = "ERROR";
        header("Location: ../infoCliente.php?id=" . $codigoCliente . "&estado=" . $estado);
        exit;
    }
} else {
    $estado = "ERROR";
    header("Location: ../infoCliente.php?id=" . $codigoCliente . "&estado=" . $estado);
    exit;
}
