<?php
    require_once('../../php/connection.php');
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
        public function getUsersRecords()
        {
            try {
                // SQL query para traer datos de los empleados
                $query = "SELECT * FROM tbl_usuario";
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
