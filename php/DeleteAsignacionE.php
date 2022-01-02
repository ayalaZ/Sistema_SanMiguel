<?php
    require('connection.php');
    /**
     * Clase para ingresar productos al inventario
     */
    class DeleteAsignacionE extends ConectionDB
    {
        public function DeleteAsignacionE()
        {
            session_start();
            parent::__construct ($_SESSION['db']);
        }
        public function enter()
        {
            try {
                  $Id = $_GET['Id'];
                  $Id1 = $_GET['Id1'];
                    $query = "DELETE from tbl_articuloempleado where IdArticuloEmpleado='".$Id."'";
                    // Preparación de sentencia
                    $statement = $this->dbConnect->prepare($query);
                    $statement->execute();
                    $query = "UPDATE tbl_articulodepartamento set Cantidad = Cantidad + 1 where IdArticuloDepartamento='".$Id1."'";
                       $statement = $this->dbConnect->prepare($query);
                       $statement->execute();
                    header('Location: ../pages/inventarioEmpleado.php?status=success');
            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
                header('Location: ../pages/inventario.php?status=failed');
            }
        }
    }
    $enter = new DeleteAsignacionE();
    $enter->enter();
?>
