<?php
    require('connection.php');
    /**
     * Clase para ingresar productos al inventario
     */
    class DeleteAsignacionEncargado extends ConectionDB
    {
        public function DeleteAsignacionEncargado()
        {
            session_start();
            parent::__construct ($_SESSION['db']);
        }
        public function enter()
        {
            try {
                  $Id = $_GET['Id'];

                    $query = "UPDATE tbl_departamento set IdEmpleado = -1 where IdDepartamento='".$Id."'";
                       $statement = $this->dbConnect->prepare($query);
                       $statement->execute();
                    header('Location: ../pages/asignarEncargadoDepartamento.php?status=success');
            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
                header('Location: ../pages/asignarEncargadoDepartamento.php?status=failed');
            }
        }
    }
    $enter = new DeleteAsignacionEncargado();
    $enter->enter();
?>
