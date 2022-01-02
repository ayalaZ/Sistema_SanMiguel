<?php
    require('connection.php');
    /**
     * Clase para ingresar productos al inventario
     */
    class EnterProduct extends ConectionDB
    {
        public function EnterProduct()
        {
            session_start();
            parent::__construct ($_SESSION['db']);
        }
        public function enter()
        {
            try {

                $velocidad = $_POST["velocidad"];

                $query = "INSERT INTO prueba VALUES (:velocidad)";
                $statement = $this->dbConnect->prepare($query);

                $statement->execute(array(':velocidad' => $velocidad));
                $this->dbConnect = null;

            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
            }
        }
    }
    $enter = new EnterProduct();
    $enter->enter();
?>
