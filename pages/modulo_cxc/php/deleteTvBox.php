<<<<<<< HEAD
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

$id = $_POST['id'];
$eliminar = "DELETE FROM tbl_tv_box WHERE idBox='$id'";
$resultado = $mysqli->query($eliminar);

if ($resultado) {
    $xdatos['typeinfo'] = 'success';
    $xdatos['msg'] = 'Eliminado correctamente';
}else{
    $xdatos['typeinfo'] = 'error';
    $xdatos['msg'] = 'No se ha podido eliminar correctamente' . _error();
}

echo json_encode($xdatos);
=======
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

$id = $_POST['id'];
$eliminar = "DELETE FROM tbl_tv_box WHERE idBox='$id'";
$resultado = $mysqli->query($eliminar);

if ($resultado) {
    $xdatos['typeinfo'] = 'success';
    $xdatos['msg'] = 'Eliminado correctamente';
}else{
    $xdatos['typeinfo'] = 'error';
    $xdatos['msg'] = 'No se ha podido eliminar correctamente' . _error();
}

echo json_encode($xdatos);
>>>>>>> 8404f3d80dcbc2494a76c11cd1ac9cae57de7f40
