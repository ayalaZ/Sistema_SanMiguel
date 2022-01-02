<?php
   require_once('../../../php/connection.php');
   /**
    * Clase para capturar los datos de la solicitud
    */
   class EliminarAbono extends ConectionDB
   {
       public function EliminarAbono()
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

               $estado = "pendiente";
               $numeroFactura = $_GET['numeroFactura'];
               $numeroRecibo = $_GET['numeroRecibo'];
               $codigoCliente = $_GET['codigoCliente'];
               $tipoServicio = $_GET['tipoServicio'];
               $mesCargo = $_GET['mesCargo'];

               if (strlen($numeroFactura) < 15) {
                   $this->dbConnect->beginTransaction();
                   $query = "UPDATE tbl_abonos SET nombre='[Recibo anulado]', cuotaCable=0.00, cuotaInternet=0.00, saldoCable=0.00, saldoInternet=0.00, /*mesCargo=:mes,*/ cargoImpuesto=0.00, totalImpuesto=0.00, anulada=1 WHERE /*numeroFactura=:numeroFactura AND */numeroRecibo=:numeroRecibo AND codigoCliente=:codigoCliente AND tipoServicio=:tipoServicio AND mesCargo=:mesCargo";
                   //$query = "UPDATE tbl_cargos SET anulada=1, cuotaCable=0, cuotaInternet=0, saldoCable=0, saldoInternet=0, cargoImpuesto=0, totalImpuesto=0 WHERE idFactura=:id";
                   $statement = $this->dbConnect->prepare($query);
                   //$statement->bindValue(':mes', $mensualidad);
                   //$statement->bindValue(':numeroFactura', $numeroFactura);
                   $statement->bindValue(':numeroRecibo', $numeroRecibo);
                   $statement->bindValue(':codigoCliente', $codigoCliente);
                   $statement->bindValue(':tipoServicio', $tipoServicio);
                   $statement->bindValue(':mesCargo', $mesCargo);
                   $statement->execute();
                   sleep(0.5);

                   $query = "UPDATE tbl_cargos SET estado=:estado WHERE /*numeroFactura=:numeroFactura AND */numeroRecibo=:numeroRecibo AND codigoCliente=:codigoCliente AND tipoServicio=:tipoServicio AND mesCargo=:mesCargo";
                   //$query = "UPDATE tbl_cargos SET anulada=1, cuotaCable=0, cuotaInternet=0, saldoCable=0, saldoInternet=0, cargoImpuesto=0, totalImpuesto=0 WHERE idFactura=:id";
                   $statement = $this->dbConnect->prepare($query);
                   //$statement->bindValue(':mes', $mensualidad);
                   $statement->bindValue(':estado', $estado);
                   //$statement->bindValue(':numeroFactura', $numeroFactura);
                   $statement->bindValue(':numeroRecibo', $numeroRecibo);
                   $statement->bindValue(':codigoCliente', $codigoCliente);
                   $statement->bindValue(':tipoServicio', $tipoServicio);
                   $statement->bindValue(':mesCargo', $mesCargo);
                   $statement->execute();
                   sleep(0.5);
                   $this->dbConnect->commit();

                   $this->dbConnect = null;
                   echo '<script>window.close()</script>';
                   //echo "<h2>Factura eliminada con exito</h2>";
                  //header('Location: ../cxc.php');

              }else {
                  $this->dbConnect->beginTransaction();
                  $estado = "pendiente";
                  $query = "UPDATE tbl_abonos SET nombre='[Recibo anulado]', cuotaCable=0.00, cuotaInternet=0.00, saldoCable=0.00, saldoInternet=0.00, /*mesCargo=:mes,*/ cargoImpuesto=0.00, totalImpuesto=0.00, anulada=1 WHERE numeroFactura=:numeroFactura AND numeroRecibo=:numeroRecibo AND codigoCliente=:codigoCliente AND tipoServicio=:tipoServicio AND mesCargo=:mesCargo";
                  //$query = "UPDATE tbl_cargos SET anulada=1, cuotaCable=0, cuotaInternet=0, saldoCable=0, saldoInternet=0, cargoImpuesto=0, totalImpuesto=0 WHERE idFactura=:id";
                  $statement = $this->dbConnect->prepare($query);
                  //$statement->bindValue(':mes', $mensualidad);
                  $statement->bindValue(':numeroFactura', $numeroFactura);
                  $statement->bindValue(':numeroRecibo', $numeroRecibo);
                  $statement->bindValue(':codigoCliente', $codigoCliente);
                  $statement->bindValue(':tipoServicio', $tipoServicio);
                  $statement->bindValue(':mesCargo', $mesCargo);
                  $statement->execute();
                  sleep(0.5);

                  $query = "UPDATE tbl_cargos SET estado=:estado WHERE numeroFactura=:numeroFactura AND /*numeroRecibo=:numeroRecibo AND */codigoCliente=:codigoCliente AND tipoServicio=:tipoServicio AND mesCargo=:mesCargo";
                  //$query = "UPDATE tbl_cargos SET anulada=1, cuotaCable=0, cuotaInternet=0, saldoCable=0, saldoInternet=0, cargoImpuesto=0, totalImpuesto=0 WHERE idFactura=:id";
                  $statement = $this->dbConnect->prepare($query);
                  //$statement->bindValue(':mes', $mensualidad);
                  $statement->bindValue(':estado', $estado);
                  $statement->bindValue(':numeroFactura', $numeroFactura);
                  //$statement->bindValue(':numeroRecibo', $numeroRecibo);
                  $statement->bindValue(':codigoCliente', $codigoCliente);
                  $statement->bindValue(':tipoServicio', $tipoServicio);
                  $statement->bindValue(':mesCargo', $mesCargo);
                  $statement->execute();
                  sleep(0.5);
                  $this->dbConnect->commit();

                  $this->dbConnect = null;
                  echo '<script>window.close()</script>';
                  //echo "<h2>Factura eliminada con exito</h2>";
                 //header('Location: ../cxc.php');
              }


           } catch (Exception $e) {
               print "!Error¡: " . $e->getMessage() . "</br>";
               die();
           }
       }
   }
   $anular = new EliminarAbono();
   $anular->eliminar();
?>
