<?php
require_once('../../php/connection.php');

/**
 * Clase para traer toda la información de los clientes de la BD
 */
class Impagos extends ConectionDB
{

    function Impagos()
    {
        if(!isset($_SESSION))
        {
            session_start();
        }
        parent::__construct ($_SESSION['db']);
    }

    public function getImpagosI(){
        try {
                //$c = "C";
                // Total servicio CABLE
                $query = "SELECT codigoCliente, nombre, tipoServicio FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='I' group by `codigoCliente` HAVING COUNT(*) >= 2";
                $statement = $this->dbConnect->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                return $result;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }
    public function getImpagosC(){
        try {
                //$c = "C";
                // Total servicio CABLE
                $query = "SELECT codigoCliente, nombre, tipoServicio FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='C' group by `codigoCliente` HAVING COUNT(*) >= 2";
                $statement = $this->dbConnect->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                return $result;

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }
    public function getImpagosCI(){
        try {
                //$c = "C";
                // Total servicio CABLE
                $query = "SELECT codigoCliente, nombre FROM tbl_cargos WHERE estado ='pendiente' AND anulada=0 AND tipoServicio='Cssss' group by `codigoCliente` HAVING COUNT(*) >= 2";
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
