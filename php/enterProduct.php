<?php
    require('connection.php');
    /**
     * Clase para ingresar productos al inventario
     */
    class EnterProduct extends ConectionDB
    {
        public function EnterProduct()
        {
            session_start();
            parent::__construct ($_SESSION['db']);
        }
        public function enter()
        {
            try {

                $IdArticulo;
                $nombre = $_POST["nombre"];
                $proveedor = $_POST['proveedor'];
                $descripcion = $_POST['descripcion'];
                $cantidad = $_POST["cantidad"];
                $tipoProducto = $_POST["tProducto"];
                $categoria = $_POST['categoria'];
                $bodega = $_POST["bodega"];
                $pCompra = $_POST['pCompra'];
                $pVenta = $_POST["pVenta"];
                $fechaEntrada = $_POST["fecha"];
                $um = $_POST["um"];
                date_default_timezone_set('America/El_Salvador');
                $Fecha = date('Y/m/d g:i');
                $nFactura = $_POST['nFactura'];
                $pGarantia = $_POST['pGarantia'];


                //CONSULTAMOS LA CANTIDAD DE ARTICULOS EN LA CATEGORIA SELECCIONADA, PARA GENERAR UN NUEVO CODIGO CORRELATIVO
                 $query = "SELECT count(*) FROM tbl_articulo where IdCategoria=(SELECT IdCategoria FROM tbl_categoria where NombreCategoria='".$categoria."')";
                 $statement = $this->dbConnect->query($query);
                 $Cd = $statement->fetchColumn() + 1;

                 //VERIFICAMOS EL TAMAÑO DEL CORRELATIVO DEL CÓDIGO. EN CASO DE SER MENOR A 10, SE ANTEPONDRÁ UN 0 A LA IZQUIERDA.
                 if (strlen($Cd) === 1) {
                     $codigo = substr($categoria,0,1) ."0". $Cd;
                 }
                 else {
                     $codigo = substr($categoria,0,1) . $Cd;
                 }

                 //CONSULTAMOS SI EXISTE EL 'NOMBRE' DEL ARTICULO EN LA TABLA TBL_ARTICULO, SI EXISTE ENTRA A UNA VALIDACION, SI NO EXISTE LO AGREGA DIRECTAMENTE
                 $query = "SELECT count(*) FROM tbl_articulo where NombreArticulo= '".$nombre."'";
                 $statement = $this->dbConnect->query($query);
                 if($statement->fetchColumn() == 1)
                 {
                   //CONSULTAMOS SI EXISTE ESE NOMBRE EN ESA BODEGA SELECCIONADA, SI EXISTE MOSTRAMOS MENSAJE DE ARTICULO EXISTENTE.
                  //SI NO EXISTE EN LA BODEGA SELECCIONADA, PERO EN OTRA SI, HACEMOS LA CONSULTA DEL CODIGO Y LE ASIGANMOS ESE AL ARTICULO
                   $query = "SELECT count(*) from tbl_articulo where NombreArticulo='".$nombre."' and IdBodega=(SELECT tbl_bodega.IdBodega FROM tbl_bodega WHERE tbl_bodega.NombreBodega = '".$bodega."')";
                   $statement = $this->dbConnect->query($query);
                   if($statement->fetchColumn() == 1)
                   {
                     header('Location: ../pages/inventarioBodegas.php?status=failed&bodega='.$bodega);
                   }
                   else
                   {
                     //CONSULTAMOS EL CODIGO DEL ARTICULO EN LA BODEGA QUE ESTE EXISTENTE
                    $query = "SELECT Codigo, IdCategoria from tbl_articulo where NombreArticulo='".$nombre."' ";
                    $statement = $this->dbConnect->prepare($query);
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    $NCodigo = "";
                    $NCate = "";
                    foreach ($result as $key)
                    {
                       $NCodigo = $key['Codigo'];
                       $NCate = $key['IdCategoria'];
                    }
                    //AGREGAMOS EL NUEVO ARTICULO CON EL CODIGO EXISTENTE
                    $query = "INSERT INTO tbl_articulo(Codigo, NombreArticulo, Descripcion, Cantidad, PrecioCompra, PrecioVenta, FechaEntrada, nFactura, pGarantia ,IdUnidadMedida, IdTipoProducto, IdCategoria, IdProveedor, IdBodega)
                    VALUES(:codigo, :nombre, :descripcion, :cantidad, :precioCompra, :precioVenta, :fechaEntrada, :nFactura, :pGarantia ,
                    (SELECT IdUnidadMedida FROM tbl_unidadmedida WHERE NombreUnidadMedida = :idUm),
                    (SELECT tbl_tipoproducto.IdTipoProducto FROM tbl_tipoproducto WHERE tbl_tipoproducto.NombreTipoProducto = :idTip),
                    :idSubCat,
                    (SELECT tbl_proveedor.IdProveedor FROM tbl_proveedor WHERE tbl_proveedor.Nombre = :idProv),
                    (SELECT tbl_bodega.IdBodega FROM tbl_bodega WHERE tbl_bodega.NombreBodega = :idBodega))";
                    // Preparación de sentencia
                    $statement = $this->dbConnect->prepare($query);
                    $statement->execute(array(
                    ':codigo' => $NCodigo,
                    ':nombre' => $nombre,
                    ':descripcion' => $descripcion,
                    ':cantidad' => $cantidad,
                    ':precioCompra' => $pCompra,
                    ':precioVenta' => $pVenta,
                    ':fechaEntrada' => $fechaEntrada,
                    ':nFactura' => $nFactura,
                    ':pGarantia' => $pGarantia,
                    ':idUm' => $um,
                    ':idTip' => $tipoProducto,
                    ':idSubCat' => $NCate,
                    ':idProv' => $proveedor,
                    ':idBodega' => $bodega
                    ));

                    //GUARDAMOS EL HISTORIAL DE LA ENTRADA
                    $idHistorial = $this->dbConnect->lastInsertId();
                    $nombreArticuloHistorial = $nombre;
                    $nombreEmpleadoHistorial = $_POST['nombreEmpleadoHistorial'];
                    $nombreBodegaHistorial = ucwords($_POST['bodega']);
                    $cantidadHistorial = $cantidad;
                    $tipoMovimientoHistorial = "Nuevo ingreso de producto";

                    $query = "INSERT into tbl_historialentradas (nombreArticulo, nombreEmpleado, fechaHora, tipoMovimiento, cantidad, bodega)
                              VALUES(:nombreArticuloHistorial, :nombreEmpleadoHistorial, CURRENT_TIMESTAMP(), :tipoMovimientoHistorial, :cantidadHistorial, :nombreBodegaHistorial)";

                    $statement = $this->dbConnect->prepare($query);
                    $statement->execute(array(
                    ':nombreArticuloHistorial' => $nombreArticuloHistorial,
                    ':nombreEmpleadoHistorial' => $nombreEmpleadoHistorial,
                    ':tipoMovimientoHistorial' => $tipoMovimientoHistorial,
                    ':cantidadHistorial' => $cantidadHistorial,
                    ':nombreBodegaHistorial' => $nombreBodegaHistorial
                    ));
                    header('Location: ../pages/inventarioBodegas.php?status=success&bodega='.$bodega);
                   }
                 }
                 else
                  {
                    //AGREGAMOS EL NUEVO ARTICULO
                    $query = "INSERT INTO tbl_articulo(Codigo, NombreArticulo, Descripcion, Cantidad, PrecioCompra, PrecioVenta, FechaEntrada, nFactura, pGarantia , IdUnidadMedida, IdTipoProducto, IdCategoria, IdProveedor, IdBodega)
                    VALUES(:codigo, :nombre, :descripcion, :cantidad, :precioCompra, :precioVenta, :fechaEntrada, :nFactura, :pGarantia ,
                    (SELECT IdUnidadMedida FROM tbl_unidadmedida WHERE NombreUnidadMedida = :idUm),
                    (SELECT tbl_tipoproducto.IdTipoProducto FROM tbl_tipoproducto WHERE tbl_tipoproducto.NombreTipoProducto = :idTip),
                    (SELECT tbl_categoria.IdCategoria FROM tbl_categoria WHERE tbl_categoria.NombreCategoria = :idSubCat),
                    (SELECT tbl_proveedor.IdProveedor FROM tbl_proveedor WHERE tbl_proveedor.Nombre = :idProv),
                    (SELECT tbl_bodega.IdBodega FROM tbl_bodega WHERE tbl_bodega.NombreBodega = :idBodega))";
                    // Preparación de sentencia
                    $statement = $this->dbConnect->prepare($query);
                    $statement->execute(array(
                    ':codigo' => $codigo,
                    ':nombre' => $nombre,
                    ':descripcion' => $descripcion,
                    ':cantidad' => $cantidad,
                    ':precioCompra' => $pCompra,
                    ':precioVenta' => $pVenta,
                    ':fechaEntrada' => $fechaEntrada,
                    ':nFactura' => $nFactura,
                    ':pGarantia' => $pGarantia,
                    ':idUm' => $um,
                    ':idTip' => $tipoProducto,
                    ':idSubCat' => $categoria,
                    ':idProv' => $proveedor,
                    ':idBodega' => $bodega
                    ));

                    //GUARDAMOS EL HISTORIAL DE LA ENTRADA
                    $idHistorial = $this->dbConnect->lastInsertId();
                    $nombreArticuloHistorial = $nombre;
                    $nombreEmpleadoHistorial = $_POST['nombreEmpleadoHistorial'];
                    $nombreBodegaHistorial = ucwords($_POST['bodega']);
                    $cantidadHistorial = $cantidad;
                    $tipoMovimientoHistorial = "Nuevo ingreso de producto";

                    $query = "INSERT into tbl_historialentradas (nombreArticulo, nombreEmpleado, fechaHora, tipoMovimiento, cantidad, bodega)
                              VALUES(:nombreArticuloHistorial, :nombreEmpleadoHistorial, CURRENT_TIMESTAMP(), :tipoMovimientoHistorial, :cantidadHistorial, :nombreBodegaHistorial)";

                    $statement = $this->dbConnect->prepare($query);
                    $statement->execute(array(
                    ':nombreArticuloHistorial' => $nombreArticuloHistorial,
                    ':nombreEmpleadoHistorial' => $nombreEmpleadoHistorial,
                    ':tipoMovimientoHistorial' => $tipoMovimientoHistorial,
                    ':cantidadHistorial' => $cantidadHistorial,
                    ':nombreBodegaHistorial' => $nombreBodegaHistorial
                    ));
                    header('Location: ../pages/inventarioBodegas.php?status=success&bodega='.$bodega);
                 }
            }
            catch (Exception $e)
            {
                print "Error!: " . $e->getMessage() . "</br>";
                die();
                header('Location: ../pages/inventarioBodegas.php?status=ErrorGrave&bodega='.$bodega);
            }
        }
    }
    $enter = new EnterProduct();
    $enter->enter();
?>
