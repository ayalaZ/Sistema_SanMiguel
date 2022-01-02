<?php
 session_start();
    require('../../../php/connection.php');

    class updateProveedor extends ConectionDB
    {
        public function updateProveedor()
        {
            if(!isset($_SESSION))
            {
                session_start();
            }
            parent::__construct ($_SESSION['db']);
        }
        public function Actualizar()
        {
                try {
                    //Capturar datos
                     $Id = $_GET["Id"];

                     $query = "SELECT count(*) from tbl_proveedor where IdProveedor='".$Id."' and State=1";
                    $statement = $this->dbConnect->query($query);
                    if($statement->fetchColumn() >= 1)
                    {
                         $State = 0;
                        $query = " UPDATE tbl_proveedor set State=:State where IdProveedor=:IdProveedor";
                         $statement = $this->dbConnect->prepare($query);
                         $statement->execute(array(
                          ':IdProveedor' => $Id,
                          ':State' => $State
                      ));
                      $this->dbConnect = NULL;
                        header('Location: ../proveedores.php?status=Actualizar');
                    }
                    else
                      {
                        $State = 1;
                       $query = " UPDATE tbl_proveedor set State=:State where IdProveedor=:IdProveedor";
                        $statement = $this->dbConnect->prepare($query);
                        $statement->execute(array(
                         ':IdProveedor' => $Id,
                         ':State' => $State
                     ));
                     $this->dbConnect = NULL;
                       header('Location: ../proveedores.php?status=Actualizar');
                      }
                  }
                    catch (Exception $e)
                    {
                        print "!Error¡: " . $e->getMessage() . "</br>";
                        die();
                        header('Location: ../proveedores.php?status=failed');
                   }

        }
    }
    $enter = new updateProveedor();
    $enter->Actualizar();
?>
