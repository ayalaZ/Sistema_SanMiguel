<?php

   require_once('../../php/connection.php');
 
   class GetSaldoReal extends ConectionDB
   {
       public function GetSaldoReal()
       {
           parent::__construct ();
       }

        public function getSaldoCable($id)
       {
           try {
               /*******INICIO DE INSTRUCCIONES PARA SACAR EL SALDO REAL DEL CLIENTE**********/
               // prepare select query
               $anulada = 0;
               $this->dbConnect->beginTransaction();
               $query = "SELECT SUM(cuotaCable) FROM tbl_cargos WHERE codigoCliente=:codigo AND anulada=:anulada";
               $stmt = $this->dbConnect->prepare( $query );
               // this is the first question mark
               $stmt->bindParam(':codigo', $id);
               $stmt->bindParam(':anulada', $anulada);
               // execute our query
               $stmt->execute();
               // store retrieved row to a variable
               $totalCargosCable = $stmt->fetchColumn();
               /***  ABONOS  ***/
               // prepare select query
               $query = "SELECT SUM(cuotaCable) FROM tbl_abonos WHERE codigoCliente=:codigo AND anulada=:anulada";
               $stmt = $this->dbConnect->prepare( $query );

               $stmt->bindParam(':codigo', $id);
               $stmt->bindParam(':anulada', $anulada);
               // execute our query
               $stmt->execute();
               // store retrieved row to a variable
               $totalAbonosCable = $stmt->fetchColumn();
               $saldoRealCable = floatVal($totalCargosCable) - floatVal($totalAbonosCable);
               sleep(0.25);
               $this->dbConnect->commit();
               return $saldoRealCable;

           } catch (Exception $e) {
               print "!Error¡: " . $e->getMessage() . "</br>";
               die();
           }
       }

       public function getSaldoInter($id)
      {
          try {
              /*******INICIO DE INSTRUCCIONES PARA SACAR EL SALDO REAL DEL CLIENTE**********/
              $anulada = 0;
              $this->dbConnect->beginTransaction();
              // prepare select query
              $query = "SELECT SUM(cuotaInternet) FROM tbl_cargos WHERE codigoCliente=:codigo AND anulada=:anulada";
              $stmt = $this->dbConnect->prepare( $query );
              // this is the first question mark
              $stmt->bindParam(':codigo', $id);
              $stmt->bindParam(':anulada', $anulada);
              // execute our query
              $stmt->execute();
              // store retrieved row to a variable
              $totalCargosInter = $stmt->fetchColumn();
              /***  ABONOS  ***/
              // prepare select query
              $query = "SELECT SUM(cuotaInternet) FROM tbl_abonos WHERE codigoCliente=:codigo AND anulada=:anulada";
              $stmt = $this->dbConnect->prepare( $query );
              // this is the first question mark
              $stmt->bindParam(':codigo', $id);
              $stmt->bindParam(':anulada', $anulada);
              // execute our query
              $stmt->execute();

              // store retrieved row to a variable
              $totalAbonosInter = $stmt->fetchColumn();
              $saldoRealInter = floatVal($totalCargosInter) - floatVal($totalAbonosInter);
              /*******FINAL DE INSTRUCCIONES PARA SACAR EL SALDO REAL DEL CLIENTE**********/
              sleep(0.25);
              $this->dbConnect->commit();
              return $saldoRealInter;

          } catch (Exception $e) {
              print "!Error¡: " . $e->getMessage() . "</br>";
              die();
          }
      }
   }




$getSaldoReal = new GetSaldoReal();
$saldoRealCable = $getSaldoReal->getSaldoCable($_GET['codigoCliente']);
$saldoRealInter = $getSaldoReal->getSaldoInter($_GET['codigoCliente']);
?>
