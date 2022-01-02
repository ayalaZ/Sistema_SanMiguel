<?php
 session_start();
    require('../../../php/connection.php');

    class updateTipoProducto extends ConectionDB
    {
        public function updateTipoProducto()
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
                     $query = "SELECT count(*) from tbl_tipoproducto where IdTipoProducto='".$Id."' and state=1";
                    $statement = $this->dbConnect->query($query);
                    if($statement->fetchColumn() >= 1)
                    {
                         $State = 0;
                        $query = " UPDATE tbl_tipoproducto set State=:State where IdTipoProducto=:IdTipoProducto";
                         $statement = $this->dbConnect->prepare($query);
                         $statement->execute(array(
                          ':IdTipoProducto' => $Id,
                          ':State' => $State
                      ));
                      $this->dbConnect = NULL;
                        header('Location: ../tipoProductos.php?status=Actualizar');
                    }
                    else
                      {
                        $State = 1;
                       $query = "UPDATE tbl_tipoproducto set State=:State where IdTipoProducto=:IdTipoProducto";
                        $statement = $this->dbConnect->prepare($query);
                        $statement->execute(array(
                          ':IdTipoProducto' => $Id,
                          ':State' => $State
                     ));
                     $this->dbConnect = NULL;
                       header('Location: ../tipoProductos.php?status=Actualizar');
                      }
                  }
                    catch (Exception $e)
                    {
                        print "!Error¡: " . $e->getMessage() . "</br>";
                        die();
                        header('Location: ../tipoProductos.php?status=failed');
                   }
        }
    }
    $enter = new updateTipoProducto();
    $enter->Actualizar();
?>
