<?php
/*
 * Clase PHP para llamar a todos los registros de plazas en la BD
 */
    require_once('../../php/connection.php');
    /**
     * Clase para tarer los datos de plazas de la base de datos
     */
    class GetAllPlazas extends ConectionDB
    {
        public function GetAllPlazas()
        {
            if(!isset($_SESSION))
            {
                session_start();
            }
            parent::__construct ($_SESSION['db']);
        }
        public function getPlazas()
        {
            try {
                    $query = "SELECT * FROM tbl_plazas";
                    $statement = $this->dbConnect->prepare($query);
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    return $result;

            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
            }
        }
    }
?>
