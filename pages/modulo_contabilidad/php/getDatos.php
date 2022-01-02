<?php
    require('../../php/connection.php');
    /**
     * Clase para tarer los datos de reportes de la base de datos
     */
    class GetInfo extends ConectionDB
    {
        public function GetInfo()
        {
            if(!isset($_SESSION))
            {
                session_start();
            }
            parent::__construct ($_SESSION['db']);
        }


        public function getCuentaTipo()
        {
            try {

                  $query = "SELECT * from tbl_CuentaTipo";
                          $statement = $this->dbConnect->prepare($query);
                          $statement->execute();
                          $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                          return $result;
            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
            }
        }

        public function getCatalogo()
        {
            try {
                  $query = "SELECT * FROM tbl_cuentas_flujo as cf inner join tbl_CuentaTipo as ct on cf.tipo_cuenta=ct.IdCuentaTipo";
                          $statement = $this->dbConnect->prepare($query);
                          $statement->execute();
                          $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                          return $result;
            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
            }
        }


        public function getNumeroPartida()
        {
            try {

                  $query = "select count(*) + 1 as Cantidad from tbl_partidas";
                          $statement = $this->dbConnect->prepare($query);
                          $statement->execute();
                          $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                          return $result;
            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
            }
        }

        public function getPartidas()
        {
            try {

                  $query = "SELECT * FROM satpro.tbl_partidas";
                          $statement = $this->dbConnect->prepare($query);
                          $statement->execute();
                          $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                          return $result;
            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
            }
        }

        public function getBalanceComprobacion()
        {
            try {

                  $query = "SELECT * FROM satpro.tbl_balanceComprobacion as bc inner join tbl_cuentas_flujo as cf on bc.idcuenta= cf.id_cuenta";
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
