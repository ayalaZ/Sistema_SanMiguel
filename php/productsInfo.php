<?php
   require_once('connection.php');
   /**
    * Clase para capturar los datos de la solicitud
    */
   class ProductsInfo extends ConectionDB
   {
       public function ProductsInfo()
       {
           session_start();
           parent::__construct ($_SESSION['db']);
       }

        public function getProveedor()
       {
           try {
               // SQL query para traer nombre de las categorías
               $query = "SELECT IdProveedor, Nombre FROM tbl_proveedor where state = 0";
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
        public function getTipo()
       {
           try {
               // SQL query para traer nombre de las categorías
               $query = "SELECT NombreTipoProducto FROM tbl_tipoproducto where state = 0";
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
       public function getCategories()
       {
           try {
               // SQL query para traer nombre de las categorías
               $query = "SELECT NombreCategoria FROM tbl_categoria where state = 0";
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
       public function getSubCategories()
       {
           try {
               // SQL query para traer nombre de las categorías
               $query = "SELECT NombreSubCategoria FROM tbl_subcategoria where state = 0";
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
       public function getMeasurements()
       {
           try {
               // SQL query para traer nombre de las categorías
               $query = "SELECT NombreUnidadMedida FROM tbl_unidadmedida where state = 0";
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
       public function getWarehouses()
       {
           try {
               // SQL query para traer nombre de las categorías
               $query = "SELECT NombreBodega FROM tbl_bodega where state = 0";
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
       public function getDepartments()
       {
           try {
               // SQL query para traer nombre de las categorías
               $query = "SELECT NombreDepartamento FROM tbl_departamento where state = 0";
               // Preparación de sentencia
               $statement = $this->dbConnect->prepare($query);
               $statement->execute();
               $result = $statement->fetchAll(PDO::FETCH_ASSOC);

               $this->dbConnect = NULL;
               return $result;

           } catch (Exception $e) {
               print "!Error¡: " . $e->getMessage() . "</br>";
               die();
           }
       }
       public function getDepartments2()
       {
           try {
               // SQL query para traer nombre de las categorías
               $query = "SELECT NombreDepartamento FROM tbl_departamento where state = 0 and IdEmpleado=-1";
               // Preparación de sentencia
               $statement = $this->dbConnect->prepare($query);
               $statement->execute();
               $result = $statement->fetchAll(PDO::FETCH_ASSOC);

               $this->dbConnect = NULL;
               return $result;

           } catch (Exception $e) {
               print "!Error¡: " . $e->getMessage() . "</br>";
               die();
           }
       }
       public function getEmpleados()
       {
           try {
               // SQL query para traer nombre de las categorías
               $query = "SELECT e.IdEmpleado, e.Codigo, e.Nombres, e.Apellidos, d.NombreDepartamento
               from tbl_empleado as e inner join tbl_departamento as d on e.IdDepartamento=d.IdDepartamento";
               // Preparación de sentencia
               $statement = $this->dbConnect->prepare($query);
               $statement->execute();
               $result = $statement->fetchAll(PDO::FETCH_ASSOC);

               $this->dbConnect = NULL;
               return $result;

           } catch (Exception $e) {
               print "!Error¡: " . $e->getMessage() . "</br>";
               die();
           }
       }
   }
?>
