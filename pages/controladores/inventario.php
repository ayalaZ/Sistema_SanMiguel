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
        $bodegas = $mysqli->query("SELECT * FROM tbl_bodega WHERE IdBodega='$idBodega'");
        $nombreBodega = $bodegas->fetch_array();

        $xdatos['codigo'] = $arregloArticulo['Codigo'];
        $xdatos['nombre'] = $arregloArticulo['NombreArticulo'];
        $xdatos['descripcion'] = $arregloArticulo['Descripcion'];
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
        $xdatos['cantidad'] = $datos['Cantidad'];

        echo json_encode($xdatos);
        break;
    case 'aplicarsalidad':
        $id = $_POST['id'];
        $fecha = $_POST['salidadfecha'];
        $cantidad = $_POST['salidadcantidad'];
        $descripcion = $_POST['salidaddescripcion'];
        $resta = $mysqli->query("UPDATE tbl_articulo SET Cantidad=Cantidad-$cantidad WHERE IdArticulo='$id'");
        if ($resta) {
            $insert = $mysqli->query("INSERT INTO SalidadArticulos(fecha,cantidad,descripcion,IdArticulo) VALUES('$fecha','$cantidad','$descripcion','$id')");
            if ($insert) {
                $xdatos['msg'] = 'Operacion se realizo con exito y se registro en la tabla de salidas';
                $xdatos['typeinfo'] = 'success';
            } else {
                $xdatos['msg'] = 'Operacion se realizo con exito, pero no se registro en la tabla';
                $xdatos['typeinfo'] = 'success';
            }
        } else {
            $xdatos['msg'] = 'Operacion no se pudo realizar' . _error();
            $xdatos['typeinfo'] = 'error';
        }
        echo json_encode($xdatos);
        break;
    case 'vereditar':
        $id = $_POST['id'];
        $articulo = $mysqli->query("SELECT * FROM tbl_articulo WHERE IdArticulo='$id'");
        $datos = $articulo->fetch_array();
        $xdatos['id'] = $datos['IdArticulo'];
        $xdatos['codigo'] = $datos['Codigo'];
        $xdatos['nombre'] = $datos['NombreArticulo'];
        $xdatos['cantidad'] = $datos['Cantidad'];
        $xdatos['fecha'] = $datos['FechaEntrada'];
        $xdatos['precioc'] = $datos['PrecioCompra'];
        $xdatos['preciov'] = $datos['PrecioVenta'];
        $xdatos['descripcion'] = $datos['Descripcion'];
        $xdatos['credito'] = $datos['nFactura'];
        $xdatos['garantia'] = $datos['pGarantia'];
        $xdatos['idProveedor'] = $datos['IdProveedor'];
        $xdatos['idTipoProducto'] = $datos['IdTipoProducto'];
        $xdatos['idCategoria'] = $datos['IdCategoria'];
        $xdatos['idBodega'] = $datos['IdBodega'];
        $xdatos['idUnidad'] = $datos['IdUnidadMedida'];

        $listproveedores = $mysqli->query("SELECT * FROM tbl_proveedor");
        $contador1 = 0;
        $xdatos['filasproveedores'] = $listproveedores->num_rows;
        while ($datosproveedores = $listproveedores->fetch_array()) {
            $xdatos['listaproveedores'][$contador1] = [
                'IdProveedor' => $datosproveedores['IdProveedor'],
                'nombre' => $datosproveedores['Nombre'],
            ];
            $contador1+=1;
        }

        $listtipo = $mysqli->query("SELECT * FROM tbl_tipoproducto");
        $contador2 = 0;
        $xdatos['filastipo'] = $listtipo->num_rows;
        while ($datostipo = $listtipo->fetch_array()) {
            $xdatos['listatipo'][$contador2] = [
                'idTipo' => $datostipo['IdTipoProducto'],
                'nombre' => $datostipo['NombreTipoProducto'],
            ];
            $contador2+=1;
        }

        $listCategoria = $mysqli->query("SELECT * FROM tbl_categoria");
        $contador3 = 0;
        $xdatos['filascategoria'] = $listCategoria->num_rows;
        while ($datostipo = $listCategoria->fetch_array()) {
            $xdatos['listacategoria'][$contador3] = [
                'idCategoria' => $datostipo['IdCategoria'],
                'nombre' => $datostipo['NombreCategoria'],
            ];
            $contador3+=1;
        }

        $listbodegas = $mysqli->query("SELECT * FROM tbl_bodega");
        $contador4 = 0;
        $xdatos['filasbodegas'] = $listbodegas->num_rows;
        while ($datostipo = $listbodegas->fetch_array()) {
            $xdatos['listabodegas'][$contador4] = [
                'idBodega' => $datostipo['IdBodega'],
                'nombre' => $datostipo['NombreBodega'],
            ];
            $contador4+=1;
        }

        $listunidad = $mysqli->query("SELECT * FROM tbl_unidadmedida");
        $contador5 = 0;
        $xdatos['filasunidad'] = $listunidad->num_rows;
        while ($datostipo = $listunidad->fetch_array()) {
            $xdatos['listaunidad'][$contador5] = [
                'idUnidad' => $datostipo['IdUnidadMedida'],
                'nombre' => $datostipo['NombreUnidadMedida'],
            ];
            $contador5+=1;
        }

        echo json_encode($xdatos);
        break;
    case 'aplicaredicion':
        $id = $_POST['Editid'];
        $codigo = $_POST['Editcodigo'];
        $nombre = $_POST['Editnombre'];
        $cantidad = $_POST['Editcantidad'];
        $fecha = $_POST['Editfecha'];
        $precioc = $_POST['EditprecioC'];
        $preciov = $_POST['EditprecioV'];
        $tipo = $_POST['Edittipo'];
        $categoria = $_POST['Editcategoria'];
        $bodega = $_POST['Editbodega'];
        $unidad = $_POST['Editunidad'];
        $descripcion = $_POST['Editdescripcion'];
        $credito = $_POST['Editcredito'];
        $garantia = $_POST['Editgarantia'];
        $proveedor = $_POST['Editproveedor'];
        $editar = $mysqli->query("UPDATE tbl_articulo SET Codigo='$codigo',
                                                          NombreArticulo='$nombre',
                                                          Descripcion='$descripcion',
                                                          Cantidad='$cantidad',
                                                          PrecioCompra='$precioc',
                                                          PrecioVenta='$preciov',
                                                          FechaEntrada='$fecha',
                                                          nFactura='$credito',
                                                          pGarantia='$garantia',
                                                          IdUnidadMedida='$unidad',
                                                          IdTipoProducto='$tipo',
                                                          IdCategoria='$categoria',
                                                          IdProveedor='$proveedor',
                                                          IdBodega='$bodega' WHERE IdArticulo='$id'");
        if ($editar) {
            $xdatos['msg'] = "Operacion realizada con exito";
            $xdatos['typeinfo'] = 'success';
        } else {
            $xdatos['msg'] = "Operacion realizada con exito" . _error();
            $xdatos['typeinfo'] = 'error';
        }
        echo json_encode($xdatos);
        break;
    case 'vertrasladar':
        $id = $_POST['id'];
        $articulo = $mysqli->query("SELECT * FROM tbl_articulo WHERE IdArticulo='$id'");
        $datos = $articulo->fetch_array();
        $idBodega = $datos['IdBodega'];
        $bodega = $mysqli->query("SELECT * FROM tbl_bodega WHERE IdBodega='$idBodega'");
        $datosBodega = $bodega->fetch_array();

        $xdatos['nombre'] = $datos['NombreArticulo'];
        $xdatos['cantidad'] = $datos['Cantidad'];
        $xdatos['bodega'] = $datosBodega['NombreBodega'];
        $xdatos['id'] = $datos['IdArticulo'];
        echo json_encode($xdatos);
        break;
    case 'aplicartraslado':
        $id = $_POST['idtraslado'];
        $cantidad = $_POST['Tcantidad'];
        $bodegadestino = $_POST['TbodegaD'];
        $articulo = $mysqli->query("SELECT * FROM tbl_articulo WHERE IdArticulo='$id'");
        $datos = $articulo->fetch_array();
        $nombre = $datos['NombreArticulo'];
        $codigo = $datos['Codigo'];
        $descripcion = $datos['Descripcion'];
        $precioC = $datos['PrecioCompra'];
        $precioV = $datos['PrecioV'];
        $fecha = $datos['FechaEntrada'];
        $credito = $datos['nFactura'];
        $garantia = $datos['pGarantia'];
        $unidad = $datos['IdUnidadMedida'];
        $tipo = $datos['IdTipoProducto'];
        $categoria = $datos['IdCategoria'];
        $proveedor = $datos['IdProveedor'];
        $cantidadArticulo = $datos['Cantidad'];

        if ($cantidad == $cantidadArticulo) {
            $existeArticulo = $mysqli->query("SELECT * FROM tbl_articulo WHERE NombreArticulo='$nombre' AND Codigo='$codigo' AND IdArticulo!='$id' AND IdBodega='$bodegadestino'");
            $numerodearticulos = $mysqli->query("SELECT count(*) AS total FROM tbl_articulo WHERE NombreArticulo='$nombre' AND Codigo='$codigo' AND IdArticulo!='$id' AND IdBodega='$bodegadestino'");
            $datosotroarticulo = $existeArticulo->fetch_array();
            $datosnumeroarticulos = $numerodearticulos->fetch_array();
            $nuevoId = $datosotroarticulo['IdArticulo'];
            if ($datosnumeroarticulos['total'] > 0) {
                $sumar = $mysqli->query("UPDATE tbl_articulo SET Cantidad = Cantidad + $cantidad WHERE IdArticulo='$nuevoId'");
                if ($sumar) {
                    $restar = $mysqli->query("UPDATE tbl_articulo SET Cantidad = Cantidad - $cantidad WHERE IdArticulo='$id'");
                    $xdatos['msg'] = 'Se sumaron los articulos a la nueva bodega y se dejo en cero los articulo de la anterior bodega';
                    $xdatos['typeinfo'] = 'success';
                } else {
                    $xdatos['msg'] = 'No se pudieron sumar los articulos a la nueva bodega y los articulos de la anterior bodega se dejaron intacto' . _error();
                    $xdatos['typeinfo'] = 'error';
                }
            } else {
                $nuevaBodega = $mysqli->query("UPDATE tbl_articulo SET IdBodega='$bodegadestino' WHERE IdArticulo='$id'");
                if ($nuevaBodega) {
                    $xdatos['msg'] = 'Se traslado todos los articulos a la nueva bodega';
                    $xdatos['typeinfo'] = 'success';
                } else {
                    $xdatos['msg'] = 'No se pudo trasladar los articulos a la nueva bodega' . _error();
                    $xdatos['typeinfo'] = 'error';
                }
            }
        } else {
            $existeArticulo = $mysqli->query("SELECT * FROM tbl_articulo WHERE NombreArticulo='$nombre' AND Codigo='$codigo' AND IdArticulo!='$id' AND IdBodega='$bodegadestino'");
            $numerodearticulos = $mysqli->query("SELECT count(*) AS total FROM tbl_articulo WHERE NombreArticulo='$nombre' AND Codigo='$codigo' AND IdArticulo!='$id' AND IdBodega='$bodegadestino'");
            $datosotroarticulo = $existeArticulo->fetch_array();
            $datosnumeroarticulos = $numerodearticulos->fetch_array();
            $nuevoId = $datosotroarticulo['IdArticulo'];
            if ($datosnumeroarticulos['total'] > 0) {
                $sumar = $mysqli->query("UPDATE tbl_articulo SET Cantidad = Cantidad + $cantidad WHERE IdArticulo='$nuevoId'");
                if ($sumar) {
                    $restar = $mysqli->query("UPDATE tbl_articulo SET Cantidad = Cantidad - $cantidad WHERE IdArticulo='$id'");
                    $xdatos['msg'] = 'Se sumaron los articulos a la nueva bodega';
                    $xdatos['typeinfo'] = 'success';
                } else {
                    $xdatos['msg'] = 'No se pudieron sumar los articulos a la nueva bodega' . _error();
                    $xdatos['typeinfo'] = 'error';
                }
            } else {
                $insert = $mysqli->query("INSERT INTO tbl_articulo(Codigo, NombreArticulo, Descripcion, Cantidad, PrecioCompra, PrecioVenta, FechaEntrada, nFactura, pGarantia, IdUnidadMedida, IdTipoProducto, IdCategoria, IdProveedor, IdBodega)
                                                        VALUES ('$codigo','$nombre','$descripcion','$cantidad','$precioC','$precioV','$fecha','$credito','$garantia','$unidad','$tipo','$categoria','$proveedor','$bodegadestino')");
                if ($insert) {
                    $restar = $mysqli->query("UPDATE tbl_articulo SET Cantidad = Cantidad - $cantidad WHERE IdArticulo='$id'");
                    $xdatos['msg'] = 'Se agregaron los articulo a la nueva bodega';
                    $xdatos['typeinfo'] = 'success';
                } else {
                    $xdatos['msg'] = 'No se pudieron agregar los articulos a la nueva bodega' . _error();
                    $xdatos['typeinfo'] = 'error';
                }
            }
        }
        echo json_encode($xdatos);
        break;
    case 'Eliminar':
        $id = $_POST['id'];
        $eliminarArticulo = $mysqli->query("DELETE FROM tbl_articulo WHERE IdArticulo='$id'");
        if ($eliminarArticulo) {
            $xdatos['msg'] = "Articulo eliminado correctamente";
            $xdatos['typeinfo'] = "success";
        } else {
            $xdatos['msg'] = "Error no se pudo eliminar el articulo correctamente" . _error();
            $xdatos['typeinfo'] = "error";
        }
        echo json_encode($xdatos);
        break;
    case 'aplicaringresar':
        $codigoAdd = $_POST['Addcodigo'];
        $nombreAdd = $_POST['Addnombre'];
        $cantidadAdd = $_POST['Addcantidad'];
        $fechaAdd = $_POST['Addfecha'];
        $preciocAdd = $_POST['AddprecioC'];
        $preciovAdd = $_POST['AddprecioV'];
        $tipoAdd = $_POST['Addtipo'];
        $categoriaAdd = $_POST['Addcategoria'];
        $bodegaAdd = $_POST['Addbodega'];
        $unidadAdd = $_POST['Addunidad'];
        $descripcionAdd = $_POST['Adddescripcion'];
        $creditoAdd = $_POST['Addcredito'];
        $garantiaAdd = $_POST['Addgarantia'];
        $proveedorAdd = $_POST['Addproveedor'];
        $existencia = $mysqli->query("SELECT count(*) AS total FROM tbl_articulo WHERE Codigo='$codigoAdd' AND NombreArticulo='$nombreAdd'");
        $existencia2 = $existencia->fetch_array();
        if ($existencia2['total'] > 0) {
            $xdatos['msg'] = 'Ya existe el mismo articulo con el mismo codigo';
            $xdatos['typeinfo'] = 'error';
        } else {
            $ingresarArticulo = $mysqli->query("INSERT INTO tbl_articulo(Codigo, NombreArticulo, Descripcion, Cantidad, PrecioCompra, PrecioVenta, FechaEntrada, nFactura, pGarantia, IdUnidadMedida, IdTipoProducto, IdCategoria, IdProveedor, IdBodega)
                                         VALUES ('$codigoAdd','$nombreAdd','$descripcionAdd','$cantidadAdd','$preciocAdd','$preciovAdd','$fechaAdd','$creditoAdd','$garantiaAdd','$unidadAdd','$tipoAdd','$categoriaAdd','$proveedorAdd','$bodegaAdd')");
            if ($ingresarArticulo) {
                $xdatos['msg'] = "Se registro el articulo con exito";
                $xdatos['typeinfo'] = "success";
            } else {
                $xdatos['msg'] = "No se pudo registrar el articulo" . _error();
                $xdatos['typeinfo'] = "error";
            }
        }
        echo json_encode($xdatos);
        break;
}
