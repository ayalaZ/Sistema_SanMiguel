<?php
 session_start();
    require('../../../php/connection.php');
    class updateInfo extends ConectionDB
    {
        public function updateInfo()
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

                     $query = "SELECT count(*) from tbl_bodega where IdBodega='".$Id."' and State=1";
                    $statement = $this->dbConnect->query($query);
                    if($statement->fetchColumn() >= 1)
                    {
                         $State = 0;
                        $query = " UPDATE tbl_bodega set State=:State where IdBodega=:IdBodega";
                         $statement = $this->dbConnect->prepare($query);
                         $statement->execute(array(
                          ':IdBodega' => $Id,
                          ':State' => $State
                      ));
                      $this->dbConnect = NULL;
                        header('Location: ../bodegas.php?status=Actualizar');
                    }
                    else
                      {
                        $State = 1;
                       $query = " UPDATE tbl_bodega set State=:State where IdBodega=:IdBodega";
                        $statement = $this->dbConnect->prepare($query);
                        $statement->execute(array(
                         ':IdBodega' => $Id,
                         ':State' => $State
                     ));
                     $this->dbConnect = NULL;
                       header('Location: ../bodegas.php?status=Actualizar');
                      }
                  }
                    catch (Exception $e)
                    {
                        print "!Error¡: " . $e->getMessage() . "</br>";
                        die();
                        header('Location: ../bodegas.php?status=failed');
                   }

        }
    }
    $enter = new updateInfo();
    $enter->Actualizar();
?>
