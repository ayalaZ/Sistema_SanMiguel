<?php
    require('connection.php');
    /**
     * Clase para ingresar productos al inventario
     */
    class UpdateArticle extends ConectionDB
    {
        public function UpdateArticle()
        {
            session_start();
            parent::__construct ($_SESSION['db']);
        }
        public function assign()
        {
            try {
                // SQL query para ingresar producto
                $IdArticulo = $_POST["Id"];
                $cantidad = $_POST["NCant"];
                $bodega = $_POST["Bdg"];

                $query = "UPDATE tbl_articulo set Cantidad=Cantidad + '".$cantidad."' where IdArticulo='".$IdArticulo."'";
                // Preparación de sentencia
                $statement = $this->dbConnect->prepare($query);
                $statement->execute();

                //GUARDAMOS EL TIPO DE MOVIMIENTO REALIZADO
                $Nombre = $_POST["NOMBRE"];
                $Apellido = $_POST["APELLIDO"];
                date_default_timezone_set('America/El_Salvador');

                 //GUARDAMOS EL HISTORIAL DE LA ENTRADA
                 date_default_timezone_set('America/El_Salvador');
                 $idHistorial = $this->dbConnect->lastInsertId();
                 $nombreArticuloHistorial = $_POST['Nmb'];
                 $nombreEmpleadoHistorial = $_POST['nombreEmpleadoHistorial'];
                 $nombreBodegaHistorial = $_POST['Bdg'];
                 $cantidadHistorial = $cantidad;
                 $tipoMovimientoHistorial = "Devolución de producto a bodega";

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
                 $this->dbConnect = NULL;
                header('Location: ../pages/inventarioBodegas.php?status=success&bodega='.$bodega);

            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
                header('Location: ../pages/inventarioBodegas.php?status=ErrorGrave&bodega='.$bodega);
            }
        }
    }
    $assign = new UpdateArticle();
    $assign->assign();
?>
