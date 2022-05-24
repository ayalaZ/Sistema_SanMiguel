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
    case 'ingresar':
        $departamento = $_POST['departamento'];
        $municipio = $_POST['municipio'];
        $zona = $_POST['zona'];
        $cobrador = $_POST['cobrador'];
        $buscarZona = $mysqli->query("SELECT * FROM tbl_colonias_cxc WHERE nombreColonia='$zona'");
        $cantidadZona = $buscarZona->num_rows;
        if ($cantidadZona > 0) {
            $xdatos['msg'] = "Error zona ya existe";
            $xdatos['typeinfo'] = "error";
        } else {
            $insertZona = $mysqli->query("INSERT INTO tbl_colonias_cxc(nombreColonia,idMuni,cobrador) VALUES('$zona','$municipio','$cobrador')");
            if ($insertZona) {
                $xdatos['msg'] = "Ingresado Correctamente";
                $xdatos['typeinfo'] = "success";
            } else {
                $xdatos['msg'] = "Error en la base de datos" . $mysqli->error;
                $xdatos['typeinfo'] = "error";
            }
        }
        echo json_encode($xdatos);
        break;
    case 'zonas':
        $codigo = $_POST['id'];
        $zonas = $mysqli->query("SELECT * FROM  tbl_colonias_cxc WHERE idColonia='$codigo'");
        $arrayZonas = $zonas->fetch_array();
        $xdatos['nombreZona'] = $arrayZonas['nombreColonia'];
        echo json_encode($xdatos);
        break;
    case 'editar':
        $codigo = $_POST['codigo'];
        $municipio = $_POST['municipio'];
        $zona = $_POST['zona'];
        $cobrador = $_POST['cobrador'];

        $buscarZona = $mysqli->query("SELECT * FROM tbl_colonias_cxc WHERE nombreColonia='$zona' AND idColonia!='$codigo'");
        $cantidadZona = $buscarZona->num_rows;
        if ($cantidadZona > 0) {
            $xdatos['msg'] = "Error zona ya existe";
            $xdatos['typeinfo'] = "error";
        } else {
            $editarZona = $mysqli->query("UPDATE tbl_colonias_cxc SET nombreColonia='$zona', idMuni='$municipio', cobrador='$cobrador' WHERE idColonia='$codigo'");
            if ($editarZona) {
                $xdatos['msg'] = "Editado Correctamente";
                $xdatos['typeinfo'] = "success";
            } else {
                $xdatos['msg'] = "Error en la base de datos" . $mysqli->error;
                $xdatos['typeinfo'] = "error";
            }
        }
        echo json_encode($xdatos);
        break;
}
