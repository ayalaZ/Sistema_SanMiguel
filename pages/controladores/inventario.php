<?php
require_once("../../php/config.php");
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
    case 'Ver':
        $id = $_POST['id'];
        $articulo = $mysqli->query("SELECT * FROM tbl_articulo WHERE IdArticulo='$id'");
        $arregloArticulo = $articulo->fetch_array();
        $idproveedor = $arregloArticulo['IdProveedor'];
        $proveedores = $mysqli->query("SELECT * FROM tbl_proveedor WHERE IdProveedor='$idproveedor'");
        $nombreproveedor = $proveedores->fetch_array();
        $idTipo = $arregloArticulo['IdTipoProducto'];
        $tipo = $mysqli->query("SELECT * FROM tbl_tipoproducto WHERE IdTipoProducto='$idTipo'");
        $tipos = $tipo->fetch_array();
        $idCategoria = $arregloArticulo['IdCategoria'];
        $catergorias = $mysqli->query("SELECT * FROM tbl_categoria WHERE IdCategoria='$idCategoria'");
        $nombrecategoria = $catergorias->fetch_array();
        $idBodega = $arregloArticulo['IdBodega'];
        $bodegas=$mysqli->query("SELECT * FROM tbl_bodega WHERE IdBodega='$idBodega'");
        $nombreBodega = $bodegas->fetch_array();

        $xdatos['codigo'] = $arregloArticulo['Codigo'];
        $xdatos['nombre'] = $arregloArticulo['NombreArticulo'];
        $xdatos['descripcion'] =$arregloArticulo['Descripcion'];
        $xdatos['cantidad'] = $arregloArticulo['Cantidad'];
        $xdatos['fecha'] = $arregloArticulo['FechaEntrada'];
        $xdatos['proveedor'] = $nombreproveedor['Nombre'];
        $xdatos['tipo'] = $tipos['NombreTipoProducto'];
        $xdatos['categoria'] = $nombrecategoria['NombreCategoria'];
        $xdatos['bodega'] = $nombreBodega['NombreBodega'];

        echo json_encode($xdatos);
        break;
    case 'salidad':
        $id = $_POST['id'];
        $articulo = $mysqli->query("SELECT * FROM tbl_articulo WHERE IdArticulo='$id'");
        $datos = $articulo->fetch_array();
        $xdatos['nombre'] = $datos['NombreArticulo'];
        $xdatos['id'] = $datos['IdArticulo'];
        
        echo json_encode($xdatos);
        break;
}