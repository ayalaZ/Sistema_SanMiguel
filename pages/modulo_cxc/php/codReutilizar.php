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
$codigo = $_POST['cod'];
$actualizar = "UPDATE clientes SET nombre='CODIGO A REUTILIZAR',
                                    nombre_comercial='',
                                    numero_nit='',
                                    numero_dui='',
                                    lugar_exp='',
                                    direccion_cobro='',
                                    telefonos='',
                                    correo_electronico='',
                                    nacionalidad='',
                                    profesion='',
                                    fecha_instalacion='',
                                    fecha_nacimiento='',
                                    fecha_primer_factura='',
                                    fecha_instalacion_in='',
                                    fecha_primer_factura_in='',
                                    dia_corbo_in='',
                                    estado_cliente_in='3',
                                    mac_modem='',
                                    serie_modem='',
                                    sin_servicio='T',
                                    dire_cable='',
                                    dire_internet='',
                                    marca_modem='',
                                    coordenadas='',
                                    direccion='',
                                    observaciones='' WHERE cod_cliente='$codigo'";
$resultadoActualizar = $mysqli->query($actualizar);

if ($resultadoActualizar) {
    $borrarOrdenes = "DELETE FROM tbl_ordenes_trabajo WHERE codigoCliente='$codigo'";
    $resultadoBorrarOrdenes = $mysqli->query($borrarOrdenes);
    if ($resultadoBorrarOrdenes) {
        $xdatos['typeinfo'] = 'success';
        $xdatos['msg'] = 'Codigo en modo de reutilizar y ordenes borradas';
    }else{
        $xdatos['typeinfo'] = 'warning';
        $xdatos['msg'] = 'Codigo en modo de reutilizar, pero no se borraron las ordenes';
    }
}else{
    $xdatos['typeinfo'] = 'error';
    $xdatos['msg'] = 'No se ha podido eliminar correctamente' . _error();
}

echo json_encode($xdatos);