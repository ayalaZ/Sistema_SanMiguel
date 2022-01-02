<?php
   require_once('../../php/connection.php');
   /**
    * Clase para capturar los datos de la solicitud
    */
   class FacturasGeneradas extends ConectionDB
   {
       public function FacturasGeneradas()
       {
           if(!isset($_SESSION))
           {
            session_start();
           }
           parent::__construct ($_SESSION['db']);
       }

        public function verFacturas($tipoFactura, /*$cobrador, $diaCobro,*/ $fechaGeneracion, $tipoServicio)
       {
           try {
               // SQL query para traer datos del servicio de cable de la tabla clientes
               $query = "SELECT * FROM tbl_cargos WHERE tipoFactura=:tipoFactura AND /*codigoCobrador=:cobrador AND diaCobro=:diaCobro AND*/ fechaFactura=:fechaGeneracion AND tipoServicio=:tipoServicio";
               // Preparación de sentencia
               $statement = $this->dbConnect->prepare($query);
               $statement->bindParam(':tipoFactura', $tipoFactura);
               //$statement->bindParam(':cobrador', $cobrador);
               //$statement->bindParam(':diaCobro', $diaCobro);
               $statement->bindParam(':fechaGeneracion', $fechaGeneracion);
               $statement->bindParam(':tipoServicio', $tipoServicio);
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
