<?php
   require_once('../../php/connection.php');
   /**
    * Clase para capturar los datos de la solicitud
    */
   class GetSaldoReal extends ConectionDB
   {
       public function GetSaldoReal()
       {
           if(!isset($_SESSION))
           {
               session_start();
           }
           parent::__construct ($_SESSION['db']);
       }

        public function getSaldoCable($id)
       {
           try {
               /*******INICIO DE INSTRUCCIONES PARA SACAR EL SALDO REAL DEL CLIENTE**********/
               // prepare select query
               $anulada = 0;
               $this->dbConnect->beginTransaction();
               $query = "SELECT SUM(cuotaCable) FROM tbl_cargos WHERE codigoCliente=:codigo AND anulada=:anulada AND tipoServicio='C'";
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
               $query = "SELECT SUM(cuotaCable) FROM tbl_abonos WHERE codigoCliente=:codigo AND anulada=:anulada AND tipoServicio='C'";
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
              $query = "SELECT SUM(cuotaInternet) FROM tbl_cargos WHERE codigoCliente=:codigo AND anulada=:anulada AND tipoServicio='I'";
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
              $query = "SELECT SUM(cuotaInternet) FROM tbl_abonos WHERE codigoCliente=:codigo AND anulada=:anulada AND tipoServicio='I'";
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

      public function getTotalCobrarCable($id)
     {
         try {
             /*******INICIO DE INSTRUCCIONES PARA SACAR EL SALDO REAL DEL CLIENTE**********/
             // prepare select query
             $anulada = 0;
             $estado = "pendiente";
             $this->dbConnect->beginTransaction();
             $query = "SELECT SUM(cuotaCable + totalImpuesto) FROM tbl_cargos WHERE codigoCliente=:codigo AND anulada=:anulada AND tipoServicio='C'";
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
             $query = "SELECT SUM(cuotaCable + totalImpuesto) FROM tbl_abonos WHERE codigoCliente=:codigo AND anulada=:anulada AND tipoServicio='C'";
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

     public function getTotalCobrarInter($id)
    {
        try {
            /*******INICIO DE INSTRUCCIONES PARA SACAR EL SALDO REAL DEL CLIENTE**********/
            $anulada = 0;
            $this->dbConnect->beginTransaction();
            // prepare select query
            $query = "SELECT SUM(cuotaInternet + totalImpuesto) FROM tbl_cargos WHERE codigoCliente=:codigo AND anulada=:anulada AND tipoServicio='I'";
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
            $query = "SELECT SUM(cuotaInternet + totalImpuesto) FROM tbl_abonos WHERE codigoCliente=:codigo AND anulada=:anulada AND tipoServicio='I'";
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

       public function detServC($id)
       {
           try {
               //$estado = "pendiente";
               $query = "SELECT servicio_suspendido, sin_servicio from clientes where cod_cliente = :codigoCliente";

               $statement = $this->dbConnect->prepare($query);
               $statement->bindValue(':codigoCliente', $id);
               $statement->execute();
               $result = $statement->fetch(PDO::FETCH_ASSOC);
               $servSusp = $result["servicio_suspendido"];
               $sinServ = $result["sin_servicio"];
               if ($servSusp == "T" && $sinServ == "F"){
                   return "Suspendido";
               }elseif($servSusp != "T" && $sinServ == "T"){
                   return "Sin servicio";
               }elseif($servSusp != "T" && $sinServ == "F"){
                   return "Activo";
               }


           } catch (Exception $e) {
               print "!Error¡: " . $e->getMessage() . "</br>";
               die();
           }
       }

       public function detServI($id)
       {
           try {
               //$estado = "pendiente";
               $query = "SELECT estado_cliente_in from clientes where cod_cliente = :codigoCliente";

               $statement = $this->dbConnect->prepare($query);
               $statement->bindValue(':codigoCliente', $id);
               $statement->execute();
               $result = $statement->fetch(PDO::FETCH_ASSOC);
               $estado = $result["estado_cliente_in"];
               if ($estado == 2){
                   return "Suspendido";
               }elseif($estado == 3){
                   return "Sin servicio";
               }elseif($estado == 1){
                   return "Activo";
               }


           } catch (Exception $e) {
               print "!Error¡: " . $e->getMessage() . "</br>";
               die();
           }
       }
   }
?>
