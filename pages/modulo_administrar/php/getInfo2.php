<?php
    require_once('../../../php/connection.php');
    /**
     * Clase para tarer los datos de reportes de la base de datos
     */
    class GetInfo2 extends ConectionDB
    {
        public function GetInfo2()
        {
            if(!isset($_SESSION))
            {
                session_start();
            }
            parent::__construct ($_SESSION['db']);
        }

        public function getColonia($idColonia)
        {
            try {

                  $query = "SELECT nombreColonia FROM tbl_colonias_cxc where idColonia = :idColonia";
                          $statement = $this->dbConnect->prepare($query);
                          $statement->bindValue(':idColonia', $idColonia);
                          $statement->execute();
                          $result = $statement->fetch(PDO::FETCH_ASSOC);
                          return $result["nombreColonia"];
            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
            }
        }
    }
?>
