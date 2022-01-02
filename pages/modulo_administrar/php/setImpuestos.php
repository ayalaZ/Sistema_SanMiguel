<?php
   require_once('../../../php/connection.php');
   /**
    * Clase para capturar los datos de la solicitud
    */
   class SetImpuestos extends ConectionDB
   {
       public function SetImpuestos()
       {
           if(!isset($_SESSION))
           {
               session_start();
           }
           parent::__construct ($_SESSION['db']);
       }

        public function establecerImpuestos()
       {
           try {
               $idIva = $_POST['idIva'];
               $idCesc = $_POST['idCesc'];
               $iva = $_POST['iva'] / 100;
               $cesc = $_POST['cesc'] / 100;
               // SQL query
               $query = "UPDATE tbl_impuestos SET valorImpuesto=:valorImpuesto WHERE idImpuesto = :idImpuesto";
               // Preparación de sentencia
               $statement = $this->dbConnect->prepare($query);
               $statement->execute(array(':valorImpuesto' => $iva, ':idImpuesto' => $idIva ));

               // SQL query
               $query = "UPDATE tbl_impuestos SET valorImpuesto=:valorImpuesto WHERE idImpuesto = :idImpuesto";
               // Preparación de sentencia
               $statement = $this->dbConnect->prepare($query);
               $statement->execute(array(':valorImpuesto' => $cesc, ':idImpuesto' => $idCesc ));

               header('Location: ../impuestos.php?state=success');

           } catch (Exception $e) {
               print "!Error¡: " . $e->getMessage() . "</br>";
               die();
           }
       }
   }
   $si = new SetImpuestos();
   $si->establecerImpuestos();
?>
