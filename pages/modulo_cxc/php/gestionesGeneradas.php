<?php
   require_once('../../php/connection.php');
   /**
    * Clase para capturar los datos de la solicitud
    */
   class GestionesGeneradas extends ConectionDB
   {
       public function GestionesGeneradas()
       {
           if(!isset($_SESSION))
           {
         	  session_start();
           }
           parent::__construct ($_SESSION['db']);
       }

        public function verGestiones($fechaGestion)
       {
           try {
               // SQL query para traer datos del servicio de cable de la tabla clientes
               $query = "SELECT tbl_gestion_clientes.idGestionCliente, tbl_gestion_general.codigoCliente, tbl_gestion_clientes.tipoServicio, clientes.tecnologia, clientes.wanip, clientes.mac_modem, clientes.dire_telefonia FROM tbl_gestion_general, tbl_gestion_clientes, clientes where clientes.cod_cliente=tbl_gestion_general.codigoCliente AND tbl_gestion_general.idGestionGeneral=tbl_gestion_clientes.idGestionGeneral AND tbl_gestion_clientes.fechaSuspension=:fechaGestion";
               // Preparación de sentencia
               $statement = $this->dbConnect->prepare($query);
               $statement->bindParam(':fechaGestion', $fechaGestion);
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
