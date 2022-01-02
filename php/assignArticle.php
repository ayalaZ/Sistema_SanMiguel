<?php
    require('connection.php');
    /**
     * Clase para ingresar productos al inventario
     */
    class AssignArticle extends ConectionDB
    {
        public function AssignArticle()
        {
            session_start();
            parent::__construct ($_SESSION['db']);
        }
        public function assign()
        {
            try {
                // SQL query para ingresar producto
                $codigo = $_POST["codigo"];
                $nombre = $_POST["nombre"];
                $proveedor = $_POST['proveedor'];
                $descripcion = $_POST['descripcion'];
                $cantidad = $_POST["cantidad"];
                $tipoProducto = $_POST["tProducto"];
                $categoria = $_POST['categoria'];
                $subCategoria = $_POST["subCategoria"];
                $bodega = $_POST["bodega"];
                $pCompra = $_POST['pCompra'];
                $pVenta = $_POST["pVenta"];
                $fechaEntrada = $_POST["fecha"];
                $um = $_POST["um"];

                $query = "INSERT INTO tbl_articulo(Codigo, NombreArticulo, Descripcion, Cantidad, PrecioCompra, PrecioVenta, FechaEntrada, IdUnidadMedida, IdTipoProducto, IdSubCategoria IdProveedor, IdBodega)
                          VALUES(:codigo, :nombre, :descripcion, :cantidad, :precioCompra, :precioVenta, :fechaEntrada, (SELECT tbl_unidadmedida.IdUnidadMedida FROM tbl_unidadmedida WHERE tbl_unidadmedida.NombreUnidadMedida = :idUm),
                          (SELECT tbl_tipoproducto.IdTipoProducto FROM tbl_TipoProducto WHERE tbl_tipoproducto.NombreTipoProducto = :idTip), (SELECT tbl_subcategoria.IdSubCategoria FROM tbl_subcategoria WHERE tbl_subcategoria.NombreSubCategoria = :idSubCat),
                          (SELECT tbl_proveedor.IdProveedor FROM tbl_proveedor WHERE tbl_proveedor.NombreProveedor = :idProv), (SELECT tbl_bodega.IdBodega FROM tbl_bodega WHERE tbl_bodega.NombreBodega = :idBodega))";
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
                ':idUm' => $um,
                ':idTip' => $tipoProducto,
                ':idSubCat' => $subCategoria,
                ':idProv' => $proveedor,
                ':idBodega' => $bodega
                ));

                $this->dbConnect = NULL;
                header('Location: ../pages/inventario.php?status=success');

            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
                header('Location: ../pages/inventario.php?status=failed');
            }
        }
    }
    $assign = new AssignArticle();
    $assign->assign();
?>
