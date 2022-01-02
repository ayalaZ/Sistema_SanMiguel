<?php
   require_once('connection.php');
   /**
    * Clase para capturar los datos de la solicitud
    */
   class ActualizarDatos extends ConectionDB
   {
       public function ActualizarDatos()
       {
           session_start();
           parent::__construct ($_SESSION['db']);
       }

        public function actualizar()
       {
           try {
               date_default_timezone_set('America/El_Salvador');

                   $query = "SELECT cod_cliente, fecha_primer_factura_in FROM tbl_clientes WHERE char_length(fecha_primer_factura_in) = 10 and fecha_primer_factura_in like '%-%' and fecha_primer_factura_in like '%/%'";
                   // Preparación de sentencia
                   $statement = $this->dbConnect->prepare($query);
                   $statement->execute();
                   $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                       foreach ($result as $i) {
                           if (strlen($i['fecha_primer_factura_in']) < 10 || strlen($i['fecha_primer_factura_in']) > 10) {
                               $fechapfi = "n/a";
                           }
                           else if (strlen($i['fecha_primer_factura_in']) == 10){
                               $str = $i['fecha_primer_factura_in'];
                               $date = DateTime::createFromFormat('d/m/Y', $str);
                               $fechapfi = $date->format('Y-m-d');
                           }

                           $qry = "UPDATE tbl_clientes SET fecha_primer_factura_in=:fechaPrimerFacturaIn WHERE cod_cliente=:codCliente";

                           $stmt = $this->dbConnect->prepare($qry);
                           $stmt->execute(
                               array(
                                     ':codCliente' => $i["cod_cliente"],
                                     ':fechaPrimerFacturaIn' => $fechapfi
                                    ));
                       }
                   }

            catch (Exception $e) {
               print "!Error¡: " . $e->getMessage() . "</br>";
               die();
           }
       }
   }

   $generar = new ActualizarDatos();
   $generar->actualizar();
?>
