<?php
/*
 * Clase PHP para llamar a todos los registros de clientes en la BD
 */
    require_once('../../php/connection.php');
    /**
     * Clase para tarer los datos de reportes de la base de datos
     */
    class GetOrdenTrabajo extends ConectionDB
    {
        public function GetOrdenTrabajo()
        {
            if(!isset($_SESSION))
            {
          	  session_start();
            }
            parent::__construct ($_SESSION['db']);
        }
        public function getOrden()
        {
            try {
                    $query = "SELECT * FROM tbl_ordenes_trabajo";
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
