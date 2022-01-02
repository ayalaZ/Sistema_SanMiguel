<?php
    require('../../php/connection.php');
    /**
     * Clase para tarer los datos de reportes de la base de datos
     */
    class GetUsers extends ConectionDB
    {
        public function GetUsers()
        {
            if(!isset($_SESSION))
            {
                session_start();
            }
            parent::__construct ($_SESSION['db']);
        }
        public function getUserRecords()
        {
            try {
                // SQL query para traer datos de los productos
                $query = "SELECT * FROM tbl_usuario, tbl_empleado WHERE tbl_usuario.IdUsuario = tbl_empleado.IdUsuario";
                // Preparación de sentencia
                $statement = $this->dbConnect->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                $this->dbConnect = NULL;
                return $result;

            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
            }
        }
    }
?>
