<?php
    require('connection.php');
    /**
     * Clase para tarer los datos de reportes de la base de datos
     */
    class Reports extends ConectionDB
    {
        public function Reports()
        {
            session_start();
            parent::__construct ($_SESSION['db']);
        }
        public function getInventoryTranslateReport()
        {
            try {
                // SQL query para traer datos de los productos
                $query = "SELECT * FROM tbl_articulo";
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
<?php
    //ESTO LO VAS A NECESITAR EN DONDE QUIERAS UTILIZAR ESTA CLASE
        require("../php/reports.php");
        $reports = new Reports();
        $showInventoryTranslateReport = $reports->getInventoryTranslateReport();
?>
