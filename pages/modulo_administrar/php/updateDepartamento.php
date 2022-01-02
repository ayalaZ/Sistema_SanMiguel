<?php
 session_start();
    require('../../../php/connection.php');

    class updateDepartamento extends ConectionDB
    {
        public function updateDepartamento()
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

                     $query = "SELECT count(*) from tbl_departamento where IdDepartamento='".$Id."' and State=1";
                    $statement = $this->dbConnect->query($query);
                    if($statement->fetchColumn() >= 1)
                    {
                         $State = 0;
                        $query = " UPDATE tbl_departamento set State=:State where IdDepartamento=:IdDepartamento";
                         $statement = $this->dbConnect->prepare($query);
                         $statement->execute(array(
                          ':IdDepartamento' => $Id,
                          ':State' => $State
                      ));
                      $this->dbConnect = NULL;
                        header('Location: ../departamentos.php?status=Actualizar');
                    }
                    else
                      {
                        $State = 1;
                       $query = "UPDATE tbl_departamento set State=:State where IdDepartamento=:IdDepartamento";
                        $statement = $this->dbConnect->prepare($query);
                        $statement->execute(array(
                         ':IdDepartamento' => $Id,
                         ':State' => $State
                     ));
                     $this->dbConnect = NULL;
                       header('Location: ../departamentos.php?status=Actualizar');
                      }
                  }
                    catch (Exception $e)
                    {
                        print "!Error¡: " . $e->getMessage() . "</br>";
                        die();
                        header('Location: ../departamentos.php?status=failed');
                   }

        }
    }
    $enter = new updateDepartamento();
    $enter->Actualizar();
?>
