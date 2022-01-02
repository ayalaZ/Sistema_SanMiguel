<?php
   require_once('connection.php');
   /**
    * Clase para capturar los datos de la solicitud
    */
   class ActualizarDatos2 extends ConectionDB
   {
       public function ActualizarDatos2()
       {
           session_start();
           parent::__construct ($_SESSION['db']);
       }

        public function actualizar()
       {
           try {
               date_default_timezone_set('America/El_Salvador');

                   $query = "SELECT cod_cliente, fecha_primer_factura FROM tbl_clientes";
                   // Preparación de sentencia
                   $statement = $this->dbConnect->prepare($query);
                   $statement->execute();
                   $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                       foreach ($result as $i) {
                           if ($i['fecha_primer_factura'] < 10) {
                               $fechapfi = "";
                           }
                           else {
                               $str = $i['fecha_primer_factura'];
                               $date = DateTime::createFromFormat('d/m/Y', $str);
                               $fechapfi = $date->format('Y-m-d');
                           }

                           $qry = "UPDATE tbl_clientes SET fecha_primer_factura=:fechaPrimerFactura WHERE cod_cliente=:codCliente";

                           $stmt = $this->dbConnect->prepare($qry);
                           $stmt->execute(
                               array(
                                     ':codCliente' => $i["cod_cliente"],
                                     ':fechaPrimerFactura' => $fechapfi
                                    ));
                       }
                   }

            catch (Exception $e) {
               print "!Error¡: " . $e->getMessage() . "</br>";
               die();
           }
       }
   }

   $generar = new ActualizarDatos2();
   $generar->actualizar();
?>
