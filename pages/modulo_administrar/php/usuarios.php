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
            $insert = $mysqli->query("INSERT INTO tbl_usuario(nombre,apellido, usuario, clave, rol, state) VALUES('$nombre','$apellido','$usuario','$clave','$rol','0')");
            $datos = $mysqli->query("SELECT idUsuario FROM tbl_usuario ORDER BY idUsuario DESC LIMIT 1");
            $array = $datos->fetch_array();
            $id =  $array['idUsuario'];
            $permsos = $mysqli->query("INSERT INTO tbl_permisosglobal(Madmin,Mcont,Mplan,Macti,Minve,Miva,Mbanc,Mcxc,Mcxp,Ag,Ed,El,GenCont,ImpCont,IdUsuario) VALUES('0','0','0','0','0','0','0','0','0','0','0','0','0','0','$id')");
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
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $usuario = $_POST['usuario'];
        $rol = $_POST['rol'];
        $clave = $_POST['clave'];
        $clave = hash('sha512', strtolower($_POST["clave"]));
        $buscar = $mysqli->query("SELECT * FROM tbl_usuario WHERE usuario='$usuario' AND idUsuario!='$id'");
        $cantidad = $buscar->num_rows;
        if ($cantidad > 0) {
            $xdatos['msg'] = "Usuario ya existe";
            $xdatos['typeinfo'] = "error";
        } else {
            $insert = $mysqli->query("UPDATE tbl_usuario SET nombre='$nombre', apellido='$apellido', usuario='$usuario', clave='$clave', rol='$rol' WHERE idUsuario='$id'");
            if ($insert) {
                $xdatos['msg'] = "Usuario modificado correctamente";
                $xdatos['typeinfo'] = "success";
            } else {
                $xdatos['msg'] = "No se pudo modificar usuario";
                $xdatos['typeinfo'] = "error";
            }
        }
        echo json_encode($xdatos);
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
    case '4':
        $codigo = $_POST['cod'];
        $datos = $mysqli->query("SELECT * FROM tbl_permisosglobal WHERE IdUsuario='$codigo'");
        $estado = $mysqli->query("SELECT state FROM tbl_usuario WHERE idUsuario='$codigo'");
        $datospermisos = $datos->fetch_array();
        $datosEstado = $estado->fetch_array();
        $xdatos['admin'] = $datospermisos['Madmin'];
        $xdatos['cont'] = $datospermisos['Mcont'];
        $xdatos['plan'] = $datospermisos['Mplan'];
        $xdatos['acti'] = $datospermisos['Macti'];
        $xdatos['inve'] = $datospermisos['Minve'];
        $xdatos['iva'] = $datospermisos['Miva'];
        $xdatos['banc'] = $datospermisos['Mbanc'];
        $xdatos['cxc'] = $datospermisos['Mcxc'];
        $xdatos['cxp'] = $datospermisos['Mcxp'];
        $xdatos['ag'] = $datospermisos['Ag'];
        $xdatos['ed'] = $datospermisos['Ed'];
        $xdatos['el'] = $datospermisos['El'];
        $xdatos['gencont'] = $datospermisos['GenCont'];
        $xdatos['Impcont'] = $datospermisos['ImpCont'];
        $xdatos['id'] = $datospermisos['IdUsuario'];
        $xdatos['estado'] = $datosEstado['state'];
        echo json_encode($xdatos);
        break;
    case '5':
        $codigo = $_POST['cod'];
        $eliminar = $mysqli->query("DELETE FROM tbl_usuario WHERE idUsuario='$codigo'");
        if ($eliminar) {
            $xdatos['msg'] = "Usuario eliminado";
            $xdatos['typeinfo'] = "success";
        } else {
            $xdatos['msg'] = "No se pudo eliminar";
            $xdatos['typeinfo'] = "error";
        }
        echo json_encode($xdatos);
        break;
}
