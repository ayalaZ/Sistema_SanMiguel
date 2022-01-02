<?php
   require_once('../../php/connection.php');
   /**
    * Clase para capturar los datos de la solicitud
    */
   class Recibos extends ConectionDB
   {
       public function Recibos()
       {
           if(!isset($_SESSION))
           {
         	  session_start();
           }
           parent::__construct ($_SESSION['db']);
       }

        public function verRecibo($idAbono)
       {
           try {
               // SQL query para traer datos del servicio de cable de la tabla clientes
               $query = "SELECT * FROM tbl_abonos WHERE idAbono=:idAbono";
               // Preparación de sentencia
               $statement = $this->dbConnect->prepare($query);
               $statement->bindParam(':idAbono', $idAbono);
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
