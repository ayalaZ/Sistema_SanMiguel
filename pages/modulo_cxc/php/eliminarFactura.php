<?php
   require_once('../../../php/connection.php');
   /**
    * Clase para capturar los datos de la solicitud
    */
   class EliminarFactura extends ConectionDB
   {
       public function EliminarFactura()
       {
           if(!isset($_SESSION))
           {
               session_start();
           }
           parent::__construct ($_SESSION['db']);
       }

        public function eliminar()
       {
           try {
               $numeroFactura = $_GET['numeroFactura'];
               $codigoCliente = $_GET['codigoCliente'];
               $tipoServicio = $_GET['tipoServicio'];
               $mesCargo = $_GET['mesCargo'];
               $this->dbConnect->beginTransaction();
               $query = "DELETE FROM tbl_cargos WHERE numeroFactura=:numeroFactura AND codigoCliente=:codigoCliente AND tipoServicio=:tipoServicio AND mesCargo=:mesCargo";
               //$query = "UPDATE tbl_cargos SET anulada=1, cuotaCable=0, cuotaInternet=0, saldoCable=0, saldoInternet=0, cargoImpuesto=0, totalImpuesto=0 WHERE idFactura=:id";
               $statement = $this->dbConnect->prepare($query);
               //$statement->bindValue(':mes', $mensualidad);
               $statement->bindValue(':numeroFactura', $numeroFactura);
               $statement->bindValue(':codigoCliente', $codigoCliente);
               $statement->bindValue(':tipoServicio', $tipoServicio);
               $statement->bindValue(':mesCargo', $mesCargo);
               $statement->execute();
               sleep(0.5);
               $this->dbConnect->commit();

               $this->dbConnect = null;

               //echo "<h2>Factura eliminada con exito</h2>";
              //header('Location: ../facturacionGenerada.php');

           } catch (Exception $e) {
               print "!Error¡: " . $e->getMessage() . "</br>";
               die();
           }
       }
   }
   $anular = new EliminarFactura();
   $anular->eliminar();
?>
