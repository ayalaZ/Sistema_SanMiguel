<?php
    require('connection.php');
    /**
     * Clase para ingresar productos al inventario
     */
    class ActualizarCondicion extends ConectionDB
    {
        public function EnterProduct()
        {
            session_start();
            parent::__construct ($_SESSION['db']);
        }
        public function actualizar()
        {
            try {
                $bodega = $_GET["bodega"];
                $id = $_GET["id"];
                $condicion = $_GET["condicion"];
                $fecha = date("Y-m-d");

                if ($condicion == "Ya instalado") {
                    $query = "UPDATE tbl_articulointernet SET condicion=:condicion, fechaSalida=:fechaSalida WHERE IdArticulo=:id";
                    // Preparación de sentencia
                    $statement = $this->dbConnect->prepare($query);
                    $statement->execute(array(
                    ':id' => $id,
                    ':condicion' => $condicion,
                    ':fechaSalida' => $fecha,
                    ));
                }
                else if ($condicion == "Se recuperó") {
                    $query = "UPDATE tbl_articulointernet SET condicion=:condicion, fechaRecuperado=:fechaRecuperado WHERE IdArticulo=:id";
                    // Preparación de sentencia
                    $statement = $this->dbConnect->prepare($query);
                    $statement->execute(array(
                    ':id' => $id,
                    ':condicion' => $condicion,
                    ':fechaRecuperado' => $fecha,
                    ));
                }

                    header('Location: ../pages/inventarioInternet.php?bodega='.$bodega);

            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
                header('Location: ../pages/inventarioBodegas.php?status=failed&bodega='.$bodega);
            }
        }
    }
    $actualizar = new ActualizarCondicion();
    $actualizar->actualizar();
?>
