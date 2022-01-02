<?php
   require_once('../../../php/connection.php');
   /**
    * Clase para capturar los datos de la solicitud
    */
   class GetDatos extends ConectionDB
   {
       public function GetDatos()
       {
           if(!isset($_SESSION))
           {
               session_start();
           }
           parent::__construct ($_SESSION['db']);
       }

        public function isExento($codigoCliente)
       {
           try {
               // SQL query para traer nombre de las categorías
               $query = "SELECT COUNT(*) FROM clientes WHERE cod_cliente = :codigoCliente AND exento = 'T'";
               // Preparación de sentencia
               $statement = $this->dbConnect->prepare($query);
               $statement->bindParam(':codigoCliente', $codigoCliente);
               $statement->execute();
               $result = $statement->fetchColumn();
               if ($result > 0) {
                   return true;
               }else {
                   return false;
               }

           } catch (Exception $e) {
               print "!Error¡: " . $e->getMessage() . "</br>";
               die();
           }
       }
   }
?>
