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
                header('Location: ../bodegas.php');
            }
            else if(isset($_POST['Action2']))
            {
                try {
                    //Capturar datos
                  //  $a = "Bodega ";
                    $Nombre = $_POST["Nombre"];
                     $Direccion = $_POST["Direccion"];
                     $State = 0;
                     //Validar que no exista
                     $query = "SELECT count(*) from tbl_bodega where NombreBodega='".$Nombre."'";
                    $statement = $this->dbConnect->query($query);

                    if($statement->fetchColumn() >= 1)
                    {
                           header('Location: ../bodegas.php?status=failed');
                    }
                    else
                    {
                            $query = "INSERT INTO tbl_bodega(NombreBodega,Direccion,State) VALUES(:NombreBodega, :Direccion, :State)";
                               $statement = $this->dbConnect->prepare($query);
                               $statement->execute(array(
                                ':NombreBodega' => $Nombre,
                                ':Direccion' => $Direccion,
                                ':State' => $State
                            ));
                            $this->dbConnect = NULL;
                            header('Location: ../bodegas.php?status=success');
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
    }
    $enter = new saveInfo();
    $enter->Guardar();
?>
