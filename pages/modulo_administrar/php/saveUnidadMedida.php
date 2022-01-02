<?php
 session_start();
    require('../../../php/connection.php');

    class saveUnidadMedida extends ConectionDB
    {
        public function saveUnidadMedida()
        {
            if(!isset($_SESSION))
            {
                session_start();
            }
            parent::__construct ($_SESSION['db']);
        }
        public function Guardar()
        {

            if(isset($_POST['Action1']))
            {
                header('Location: ../unidadMedidas.php');
            }
            else if(isset($_POST['Action2']))
            {
                try {
                    //Capturar datos

                    $NombreUnidadMedida = $_POST["NombreUnidadMedida"];
                     $Abreviatura = $_POST["Abreviatura"];
                     $State = 0;
                     //Validar que no exista
                     $query = "SELECT count(*) from tbl_unidadmedida where NombreUnidadMedida = '".$NombreUnidadMedida."'";
                    $statement = $this->dbConnect->query($query);
                    if($statement->fetchColumn() >= 1)
                    {
                           header('Location: ../unidadMedidas.php?status=failed');
                    }
                    else
                    {
                            $query = " INSERT INTO tbl_unidadmedida(NombreUnidadMedida,Abreviatura,State)
                             VALUES(:NombreUnidadMedida, :Abreviatura, :State)";
                               $statement = $this->dbConnect->prepare($query);
                               $statement->execute(array(
                                ':NombreUnidadMedida' => $NombreUnidadMedida,
                                ':Abreviatura' => $Abreviatura,
                                ':State' => $State
                            ));
                            $this->dbConnect = NULL;
                          header('Location: ../unidadMedidas.php?status=success');
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
    }
    $enter = new saveUnidadMedida();
    $enter->Guardar();
?>
