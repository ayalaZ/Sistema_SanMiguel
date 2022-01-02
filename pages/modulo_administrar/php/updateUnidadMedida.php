<?php
 session_start();
    require('../../../php/connection.php');

    class updateUnidadMedida extends ConectionDB
    {
        public function updateUnidadMedida()
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
                     $query = "SELECT count(*) from tbl_unidadmedida where IdUnidadMedida='".$Id."' and State=1";
                    $statement = $this->dbConnect->query($query);
                    if($statement->fetchColumn() >= 1)
                    {
                         $State = 0;
                        $query = "UPDATE tbl_unidadmedida set state=:State where IdUnidadMedida=:IdUnidadMedida";
                         $statement = $this->dbConnect->prepare($query);
                         $statement->execute(array(
                          ':IdUnidadMedida' => $Id,
                          ':State' => $State
                      ));
                      $this->dbConnect = NULL;
                        header('Location: ../unidadMedidas.php?status=Actualizar');
                    }
                    else
                      {
                        $State = 1;
                       $query = "UPDATE tbl_unidadmedida set state=:State where IdUnidadMedida=:IdUnidadMedida";
                        $statement = $this->dbConnect->prepare($query);
                        $statement->execute(array(
                          ':IdUnidadMedida' => $Id,
                          ':State' => $State
                     ));
                     $this->dbConnect = NULL;
                       header('Location: ../unidadMedidas.php?status=Actualizar');
                      }
                  }
                    catch (Exception $e)
                    {
                        print "!Error¡: " . $e->getMessage() . "</br>";
                        die();
                        header('Location: ../unidadMedidas.php?status=failed');
                   }
        }
    }
    $enter = new updateUnidadMedida();
    $enter->Actualizar();
?>
