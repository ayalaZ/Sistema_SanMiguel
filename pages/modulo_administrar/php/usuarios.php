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
$proceso = $_POST['proceso'];

switch ($proceso) {
    case '1':
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $usuario = $_POST['usuario'];
        $rol = $_POST['rol'];
        $clave = $_POST['clave'];
        $clave = hash('sha512', strtolower($_POST["clave"]));
        $buscar = $mysqli->query("SELECT * FROM tbl_usuario WHERE usuario='$usuario'");
        $cantidad = $buscar->num_rows;
        if ($cantidad > 0) {
            $xdatos['msg'] = "Usuario ya existe";
            $xdatos['typeinfo'] = "error";
        } else {
            $insert = $mysqli->query("INSERT INTO tbl_usuario(nombre,apellido, usuario, clave, rol, state) VALUES('$nombre','$apellido','$usuario','$clave','$rol','1')");
            if ($insert) {
                $xdatos['msg'] = "Usuario ingresado correctamente";
                $xdatos['typeinfo'] = "success";
            } else {
                $xdatos['msg'] = "No se pudo ingresar el usuario";
                $xdatos['typeinfo'] = "error";
            }
        }
        echo json_encode($xdatos);
        break;
    case '2':
        break;
    case '3':
        $codigo = $_POST['cod'];
        $datos = $mysqli->query("SELECT * FROM tbl_usuario WHERE idUsuario='$codigo'");
        $datosUsuario = $datos->fetch_array();
        $xdatos['id'] = $datosUsuario['idUsuario'];
        $xdatos['nombre'] = $datosUsuario['nombre'];
        $xdatos['apellido'] = $datosUsuario['apellido'];
        $xdatos['usuario'] = $datosUsuario['usuario'];
        echo json_encode($xdatos); 
        break;
}
