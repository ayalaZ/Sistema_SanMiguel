<?php
   require_once('connection.php');
   /**
    * Clase para capturar los datos de la solicitud
    */
   class FacturasGeneradas extends ConectionDB
   {
       public function FacturasGeneradas()
       {
           session_start();
           parent::__construct ($_SESSION['db']);
       }

        public function verFacturas()
       {
           try {
               // SQL query para traer datos del servicio de cable de la tabla clientes
               $query = "SELECT * FROM tbl_facturas, clientes5 WHERE codigoCliente=clientes5.cod_cliente";
               // Preparación de sentencia
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
