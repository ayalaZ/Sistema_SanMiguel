<?php
    /**
     * Clase para capturar los datos de la solicitud
     */
    class GetIdEmpleado extends ConectionDB
    {
        public function GetIdEmpleado()
        {
            if(!isset($_SESSION))
            {
                session_start();
            }
            parent::__construct ($_SESSION['db']);
        }
        public function getid()
        {
            try {
                    // SQL query para traer los datos de los productos
                    $query = "SELECT id_empleado FROM tbl_empleados";
                    // Preparación de sentencia
                    $statement = $this->dbConnect->prepare($query);
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    $valor = null;
                    foreach ($result as $key) {
                        $valor = $key['id_empleado'];
                    }
                    if (strlen($valor) == "0") {
                        $valor = 1;
                    }
                    else{
                        $valor = $valor+1;
                    }
                    $this->dbConnect = NULL;
                    return intval($valor);

            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
            }
        }
    }
?>
