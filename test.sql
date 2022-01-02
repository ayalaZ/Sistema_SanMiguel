<?php
    require('connection.php');
    /**
     * Clase para actualizar existencias a la hora del traslado
     */
    class translateSuccess extends ConectionDB
    {
        public function TranslateSuccess()
        {
            parent::__construct ();
        }
        public function updateWarehouses()
        {
            try {

                // SQL query para traslado de producto
                $fecha = date('Y-m-d');
                $bodegaOrigen = $_POST["bodegaOrigen"];
                $bodegaDestino = $_POST["bodegaDestino"];

                $id = $_POST["id"];
                $nombreArticulo = $_POST["nombreArticulo"];
                $nombreBodega = $_POST["nombreBodega"];
                $cantidad = $_POST["cantidad"];

                if (mysql_query("SELECT nombreArticulo FROM tbl_articulo WHERE IdBodega = (SELECT IdBodega from tbl_Bodega WHERE NombreBodega = '$bodegaDestino')") == true) {

                    $query = "UPDATE tbl_articulo SET cantidad =  (SELECT cantidad FROM tbl_articulo WHERE IdArticulo = :id) - :cantidad WHERE IdArticulo = :id";

                    // Preparación de sentencia
                    $statement = $this->dbConnect->prepare($query);
                    $statement->execute(array(
                    ':id' => $id,
                    ':cantidad' => $cantidad
                    ));

                }
                else{
                    $query = "INSERT INTO tbl_articulo (Codigo, NombreArticulo, Descripcion, Cantidad, PrecioCompra, PrecioVenta, FechaEntrada, IdUnidadMedida, IdTipoProducto, IdCategoria, IdSubCategoria, IdProveedor, IdBodega) VALUES((SELECT Codigo FROM tbl_articulo WHERE IdArticulo = :id), (SELECT NombreArticulo FROM tbl_articulo WHERE IdArticulo = :id), (SELECT Descripcion FROM tbl_articulo WHERE IdArticulo = :id), (SELECT Cantidad FROM tbl_articulo WHERE IdArticulo = :id), (SELECT PrecioCompra FROM tbl_articulo WHERE IdArticulo = :id), (SELECT PrecioVenta FROM tbl_articulo WHERE IdArticulo = :id), :fechaEntrada, (SELECT IdUnidadMedida FROM tbl_articulo WHERE IdArticulo = :id), (SELECT IdTipoProducto FROM tbl_articulo WHERE IdArticulo = :id), (SELECT IdCategoria FROM tbl_articulo WHERE IdArticulo = :id), (SELECT IdSubCategoria FROM tbl_articulo WHERE IdArticulo = :id), (SELECT IdProveedor FROM tbl_articulo WHERE IdArticulo = :id), (SELECT IdBodega FROM tbl_bodega WHERE NombreBodega = :bodegaDestino))";
                }
              
                $query = " ";

                // Preparación de sentencia
                $statement = $this->dbConnect->prepare($query);
                $statement->execute(array(
                ':codigo' => $codigo,
                ':nombre' => $nombre,
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

?>