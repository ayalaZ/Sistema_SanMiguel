<?php
    require('connection.php');
    /**
     * Clase para actualizar existencias a la hora del traslado
     */
    class translateSuccess extends ConectionDB
    {
        public function TranslateSuccess()
        {
            session_start();
            parent::__construct ($_SESSION['db']);
        }
        public function updateWarehouses()
        {
            try {

                // SQL query para traslado de producto
                $fecha = date('Y-m-d');
                $bodegaOrigen = $_POST["bodegaOrigen"];
                $bodegaDestino = $_POST["bodegaDestino"];

                $id = $_POST["idArticulo"];
                $nombreArticulo = $_POST["nombreArticulo"];
                $nombreBodega = $_POST["nombreBodega"];
                $existencias = $_POST["existencias"];
                $cantidadATrasladar = $_POST["cantidadATrasladar"];

                $values = array();
                foreach ($cantidadATrasladar as $key) {
                    array_push($values, $key);
                }

                $idArray = array();
                foreach ($id as $idKeys) {
                    array_push($idArray, $idKeys);
                }

                $existenciasArray = array();
                foreach ($existencias as $existenciasKey) {
                    array_push($existenciasArray, $existenciasKey);
                }

                $cantidadATrasladarArray = array();
                foreach ($cantidadATrasladar as $cantidadATrasladarKey) {
                    array_push($cantidadATrasladarArray, $cantidadATrasladarKey);
                }

                $qry = $this->dbConnect->prepare("SELECT nombreArticulo FROM tbl_articulo WHERE IdBodega = (SELECT IdBodega from tbl_bodega WHERE NombreBodega = :bodegaDestino)");
                $qry->execute(array(
                ':bodegaDestino' => $bodegaDestino
                ));
                $test = $qry->rowCount();

                for ($i=0; $i < count($values) ; $i++) {
                    if ($test >= 1) {

                        $query = "UPDATE tbl_articulo SET cantidad = $existenciasArray[$i] - $cantidadATrasladarArray[$i] WHERE IdArticulo = $idArray[$i]";

                        // Preparación de sentencia
                        $statement = $this->dbConnect->prepare($query);
                        $statement->execute();
                    }
                    else{

                        $query = "INSERT INTO tbl_articulo (Codigo, NombreArticulo, Descripcion, Cantidad, PrecioCompra, PrecioVenta, FechaEntrada, IdUnidadMedida, IdTipoProducto, IdCategoria, IdSubCategoria, IdProveedor, IdBodega)
                                  VALUES((SELECT Codigo FROM tbl_articulo WHERE IdArticulo = $idKeys[$i]), (SELECT NombreArticulo FROM tbl_articulo WHERE IdArticulo = $idKeys[$i]), (SELECT Descripcion FROM tbl_articulo WHERE IdArticulo = $idKeys[$i]), (SELECT Cantidad FROM tbl_articulo WHERE IdArticulo = $idKeys[$i]), (SELECT PrecioCompra FROM tbl_articulo WHERE IdArticulo = $idKeys[$i]),
                                  (SELECT PrecioVenta FROM tbl_articulo WHERE IdArticulo = $idKeys[$i]),
                                  :fechaEntrada, (SELECT IdUnidadMedida FROM tbl_articulo WHERE IdArticulo = $idKeys[$i]), (SELECT IdTipoProducto FROM tbl_articulo WHERE IdArticulo = $idKeys[$i]), (SELECT IdCategoria FROM tbl_articulo WHERE IdArticulo = $idKeys[$i]), (SELECT IdSubCategoria FROM tbl_articulo WHERE IdArticulo = $idKeys[$i]), (SELECT IdProveedor FROM tbl_articulo WHERE IdArticulo = $idKeys[$i]),
                                  (SELECT IdBodega FROM tbl_bodega WHERE NombreBodega = :bodegaDestino))";

                        // Preparación de sentencia
                        $statement = $this->dbConnect->prepare($query);
                        $statement->execute(array(
                        ':fechaEntrada' => $fecha,
                        ':bodegaDestino' => $bodegaDestino
                        ));
                    }

                }
                $this->dbConnect = NULL;
                header('Location: ../pages/inventario.php?status=success');

            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
                header('Location: ../pages/inventario.php?status=failed');
            }
        }
    }
    $translateSuccess = new TranslateSuccess();
    $translateSuccess->updateWarehouses();

?>
