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
        $clavepro = $_POST['clave'];
        $clave = password_hash($clavepro, PASSWORD_DEFAULT);
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
        $clavepro = $_POST['clave2'];
        $clave = password_hash($clavepro, PASSWORD_DEFAULT);
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
        $eliminarPermisos = $mysqli->query("DELETE FROM tbl_permisosglobal WHERE IdUsuario='$codigo'");
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
    case '6':
        $id = $_POST['id2'];
        $estado = $_POST['estado'];
        $admin = $_POST['admin'];
        $cont = $_POST['cont'];
        $pla = $_POST['pla'];
        $act = $_POST['act'];
        $inv = $_POST['inv'];
        $iva = $_POST['iva'];
        $banc = $_POST['banc'];
        $cxc = $_POST['cxc'];
        $cxp = $_POST['cxp'];
        $ag = $_POST['ag'];
        $mod = $_POST['mod'];
        $eli = $_POST['eli'];
        $genc = $_POST['genC'];
        $impc = $_POST['impC'];
        $updateEstado = $mysqli->query("UPDATE tbl_usuario SET state='$estado' WHERE idUsuario='$id'");
        $updatePermisos = $mysqli->query("UPDATE tbl_permisosglobal SET Madmin='$admin', Mcont='$cont', Mplan='$pla', Macti='$act', Minve='$inv', Miva='$iva', Mbanc='$banc', Mcxc='$cxc', Mcxp='$cxp', Ag='$ag', Ed='$mod', El='$eli', GenCont='$genc', ImpCont='$impc' WHERE IdUsuario='$id'");
        if ($updatePermisos) {
            $xdatos['msg'] = "Permisos modificados";
            $xdatos['typeinfo'] = "success";
        } else {
            $xdatos['msg'] = "No se pudo modificar los permisos";
            $xdatos['typeinfo'] = "error";
        }
        echo json_encode($xdatos);
        break;
}
