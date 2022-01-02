<?php
 session_start();
    require('../../../php/connection.php');

    class saveInfo extends ConectionDB
    {
        public function saveInfo()
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
                header('Location: ../plazas.php');
            }
            else if(isset($_POST['Action2']))
            {
                try {
                    //Capturar datos
                    $Nombre = $_POST["NombrePlaza"];
                     $Descripcion = $_POST["DescripcionPlaza"];
                     //Validar que no exista
                     $query = "SELECT count(*) from tbl_plazas where nombrePlaza='".$Nombre."'";
                    $statement = $this->dbConnect->query($query);

                    if($statement->fetchColumn() >= 1)
                    {
                           header('Location: ../plazas.php?status=failed');
                    }
                    else
                    {
                            $query = "INSERT INTO tbl_plazas(nombrePlaza,descripcionPlaza) VALUES(:nombrePlaza, :descripcionPlaza)";
                               $statement = $this->dbConnect->prepare($query);
                               $statement->execute(array(
                                ':nombrePlaza' => $Nombre,
                                ':descripcionPlaza' => $Descripcion
                            ));
                            $this->dbConnect = NULL;
                            header('Location: ../plazas.php?status=success');
                    }
                    }
                    catch (Exception $e)
                    {
                        print "!Error¡: " . $e->getMessage() . "</br>";
                        die();
                        header('Location: ../plazas.php?status=failed');
                   }
            }
        }
    }
    $enter = new saveInfo();
    $enter->Guardar();
?>
