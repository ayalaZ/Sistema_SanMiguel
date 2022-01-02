<?php

    require_once('connection.php');
    /**
     * Clase para traer los datos de los productos seleccionados
     */
    class TranslateProcess extends ConectionDB
    {
        public function TranslateProcess()
        {
            session_start();
            parent::__construct ($_SESSION['db']);
        }
        public function getProductsTranslated()
        {
            try {
                $checkValues = $_POST['checkTraslado'];
                $values = array();
                foreach ($checkValues as $key) {
                    array_push($values, $key);
                }
                $queryResults = array();
                for ($i=0; $i < count($values) ; $i++) {
                    // SQL query para traer los datos de los productos
                    //(SELECT Nombre FROM tbl_bodega WHERE tbl_bodega.IdBodega = tbl_articulo.IdBodega)
                    $query = "SELECT IdArticulo, NombreArticulo, NombreBodega, Cantidad FROM tbl_articulo, tbl_bodega WHERE IdArticulo = $values[$i] AND tbl_articulo.IdBodega = tbl_bodega.IdBodega";
                    // Preparación de sentencia
                    $statement = $this->dbConnect->prepare($query);
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    array_push($queryResults, $result);
                }
                return $queryResults;
            } catch (Exception $e) {
                print "!Error¡: " . $e->getMessage() . "</br>";
                die();
            }
        }
        public function getProductsTranslated2()
        {
          try {
              $checkValues = $_POST['checkTraslado'];
              $values = array();
              foreach ($checkValues as $key)
               {
                array_push($values, $key);
              }
              $queryResults = array();
              for($i=0; $i < count($values); $i++)
              {
                $query = "SELECT IdArticuloDepartamento, Codigo, NombreArticulo, Cantidad, NombreDepartamento as Departamento FROM tbl_articulodepartamento, tbl_departamento where IdArticuloDepartamento = $values[$i] and tbl_articulodepartamento.IdDepartamento=tbl_departamento.IdDepartamento";
                $statement = $this->dbConnect->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                array_push($queryResults, $result);
              }
              return $queryResults;
          } catch (Exception $e) {
            print "!Error¡:" . $e->getMessage() . "</br>";
            die();
          }

        }
        public function geEmpleadosAsignacion()
        {
          try {
              $checkValues = $_POST['checkTraslado'];
              $values = array();
              foreach ($checkValues as $key)
               {
                array_push($values, $key);
              }
              $queryResults = array();
              for($i=0; $i < count($values); $i++)
              {
                $query = "SELECT e.IdEmpleado, e.Codigo, e.Nombres, e.Apellidos, d.NombreDepartamento from tbl_empleado as e left join tbl_departamento as d on e.IdDepartamento=d.IdDepartamento
                where e.IdEmpleado = '".$values[$i]."'";
                $statement = $this->dbConnect->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                array_push($queryResults, $result);
              }
              return $queryResults;
          } catch (Exception $e) {
            print "!Error¡:" . $e->getMessage() . "</br>";
            die();
          }

        }
    }
?>
