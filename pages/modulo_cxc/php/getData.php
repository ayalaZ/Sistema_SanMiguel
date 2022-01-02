<?php
   require_once('../../php/connection.php');
   /**
    * Clase para capturar los datos de la solicitud
    */
   class OrdersInfo extends ConectionDB
   {
       public function OrdersInfo()
       {
           if(!isset($_SESSION))
           {
               session_start();
           }
           parent::__construct ($_SESSION['db']);
       }

        public function getTecnicos()
       {
           try {
               // SQL query para traer nombre de las categorías
               $query = "SELECT idTecnico, nombreTecnico FROM tbl_tecnicos_cxc";
               // Preparación de sentencia
               $statement = $this->dbConnect->prepare($query);
               $statement->execute();
               $result = $statement->fetchAll(PDO::FETCH_ASSOC);


               return $result;

           } catch (Exception $e) {
               print "!Error¡: " . $e->getMessage() . "</br>";
               die();
           }
       }

       public function getTecnicoById($idTecnico)
      {
          try {
              // SQL query para traer nombre de las categorías
              $query = "SELECT nombreTecnico FROM tbl_tecnicos_cxc WHERE idTecnico = :idTecnico";
              // Preparación de sentencia
              $statement = $this->dbConnect->prepare($query);
              $statement->bindParam(':idTecnico', $idTecnico);
              $statement->execute();
              $result = $statement->fetch(PDO::FETCH_ASSOC);


              return $result['nombreTecnico'];

          } catch (Exception $e) {
              print "!Error¡: " . $e->getMessage() . "</br>";
              die();
          }
      }
      public function getAcById($idActividadCable)
     {
         try {
             // SQL query para traer nombre de las categorías
             $query = "SELECT nombreActividad FROM tbl_actividades_susp WHERE idActividadSusp = :idActividadCable";
             // Preparación de sentencia
             $statement = $this->dbConnect->prepare($query);
             $statement->bindParam(':idActividadCable', $idActividadCable);
             $statement->execute();
             $result = $statement->fetch(PDO::FETCH_ASSOC);


             return $result['nombreActividad'];

         } catch (Exception $e) {
             print "!Error¡: " . $e->getMessage() . "</br>";
             die();
         }
     }
     public function getAiById($idActividadInter)
    {
        try {
            // SQL query para traer nombre de las categorías
            $query = "SELECT nombreActividad FROM tbl_actividades_susp WHERE idActividadSusp = :idActividadInter";
            // Preparación de sentencia
            $statement = $this->dbConnect->prepare($query);
            $statement->bindParam(':idActividadInter', $idActividadInter);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);


            return $result['nombreActividad'];

        } catch (Exception $e) {
            print "!Error¡: " . $e->getMessage() . "</br>";
            die();
        }
    }

        public function getVendedores()
       {
           try {
               // SQL query para traer nombre de las categorías
               $query = "SELECT idVendedor, nombresVendedor, apellidosVendedor FROM tbl_vendedores";
               // Preparación de sentencia
               $statement = $this->dbConnect->prepare($query);
               $statement->execute();
               $result = $statement->fetchAll(PDO::FETCH_ASSOC);


               return $result;

           } catch (Exception $e) {
               print "!Error¡: " . $e->getMessage() . "</br>";
               die();
           }
       }
       public function getCobradores()
       {
           try {
               // SQL query para traer nombre de las categorías
               $query = "SELECT * FROM tbl_cobradores";
               // Preparación de sentencia
               $statement = $this->dbConnect->prepare($query);
               $statement->execute();
               $result = $statement->fetchAll(PDO::FETCH_ASSOC);


               return $result;

           } catch (Exception $e) {
               print "!Error¡: " . $e->getMessage() . "</br>";
               die();
           }
       }
       public function getActividadesCable()
       {
           try {
               // SQL query para traer nombre de las categorías
               $query = "SELECT idActividadCable, nombreActividad FROM tbl_actividades_cable";
               // Preparación de sentencia
               $statement = $this->dbConnect->prepare($query);
               $statement->execute();
               $result = $statement->fetchAll(PDO::FETCH_ASSOC);


               return $result;

           } catch (Exception $e) {
               print "!Error¡: " . $e->getMessage() . "</br>";
               die();
           }
       }
       public function getActividadesInter()
       {
           try {
               // SQL query para traer nombre de las categorías
               $query = "SELECT idActividadInter, nombreActividad FROM tbl_actividades_inter";
               // Preparación de sentencia
               $statement = $this->dbConnect->prepare($query);
               $statement->execute();
               $result = $statement->fetchAll(PDO::FETCH_ASSOC);
               //$statement->closeCursor();
               //$this->dbConnect = null;

               return $result;

           } catch (Exception $e) {
               print "!Error¡: " . $e->getMessage() . "</br>";
               die();
           }
       }
       public function getActividadesSusp()
       {
           try {
               // SQL query para traer nombre de las categorías
               $query = "SELECT idActividadSusp, nombreActividad FROM tbl_actividades_susp";
               // Preparación de sentencia
               $statement = $this->dbConnect->prepare($query);
               $statement->execute();
               $result = $statement->fetchAll(PDO::FETCH_ASSOC);
               //$statement->closeCursor();
               //$this->dbConnect = null;

               return $result;

           } catch (Exception $e) {
               print "!Error¡: " . $e->getMessage() . "</br>";
               die();
           }
       }

       public function getVelocidades()
       {
           try {
               // SQL query para traer nombre de las categorías
               $query = "SELECT * FROM tbl_velocidades";
               // Preparación de sentencia
               $statement = $this->dbConnect->prepare($query);
               $statement->execute();
               $result = $statement->fetchAll(PDO::FETCH_ASSOC);
               //$statement->closeCursor();
               //$this->dbConnect = null;

               return $result;

           } catch (Exception $e) {
               print "!Error¡: " . $e->getMessage() . "</br>";
               die();
           }
       }

       public function getVelocidadById($idVelocidad)
       {
           try {
               // SQL query para traer nombre de las categorías
               $query = "SELECT nombreVelocidad FROM tbl_velocidades WHERE idVelocidad=:idVelocidad";
               // Preparación de sentencia
               $statement = $this->dbConnect->prepare($query);
               $statement->bindParam(':idVelocidad', $idVelocidad);
               $statement->execute();
               $result = $statement->fetch(PDO::FETCH_ASSOC);
               //$statement->closeCursor();
               //$this->dbConnect = null;

               return $result["nombreVelocidad"];

           } catch (Exception $e) {
               print "!Error¡: " . $e->getMessage() . "</br>";
               die();
           }
       }
       public function getFormasPago()
       {
           try {
               // SQL query para traer nombre de las categorías
               /*$query = "SELECT * FROM tbl_formas_pago";
               // Preparación de sentencia
               $statement = $this->dbConnect->prepare($query);
               $statement->execute();
               $result = $statement->fetchAll(PDO::FETCH_ASSOC);

               return $result;*/

           } catch (Exception $e) {
               print "!Error¡: " . $e->getMessage() . "</br>";
               die();
           }
       }
       public function getTipoVenta()
       {
           try {
               // SQL query para traer nombre de las categorías
               /*$query = "SELECT * FROM tbl_tipos_venta";
               // Preparación de sentencia
               $statement = $this->dbConnect->prepare($query);
               $statement->execute();
               $result = $statement->fetchAll(PDO::FETCH_ASSOC);

               return $result;*/

           } catch (Exception $e) {
               print "!Error¡: " . $e->getMessage() . "</br>";
               die();
           }
       }
   }
?>
