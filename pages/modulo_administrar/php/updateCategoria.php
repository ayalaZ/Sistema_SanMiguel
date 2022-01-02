<?php
 session_start();
    require('../../../php/connection.php');

    class updateCategoria extends ConectionDB
    {
        public function updateCategoria()
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
                     $query = "SELECT count(*) from tbl_categoria where IdCategoria='".$Id."' and State=1";
                    $statement = $this->dbConnect->query($query);
                    if($statement->fetchColumn() >= 1)
                    {
                         $State = 0;
                        $query = " UPDATE tbl_categoria set State=:State where IdCategoria=:IdCategoria";
                         $statement = $this->dbConnect->prepare($query);
                         $statement->execute(array(
                          ':IdCategoria' => $Id,
                          ':State' => $State
                      ));
                      $this->dbConnect = NULL;
                        header('Location: ../categorias.php?status=Actualizar');
                    }
                    else
                      {
                        $State = 1;
                       $query = "UPDATE tbl_categoria set State=:State where IdCategoria=:IdCategoria";
                        $statement = $this->dbConnect->prepare($query);
                        $statement->execute(array(
                          ':IdCategoria' => $Id,
                          ':State' => $State
                     ));
                     $this->dbConnect = NULL;
                       header('Location: ../categorias.php?status=Actualizar');
                      }
                  }
                    catch (Exception $e)
                    {
                        print "!Error¡: " . $e->getMessage() . "</br>";
                        die();
                        header('Location: ../categorias.php?status=failed');
                   }

        }
    }
    $enter = new updateCategoria();
    $enter->Actualizar();
?>
