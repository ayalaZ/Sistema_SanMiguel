<?php
 session_start();
    require('../../../php/connection.php');

    class saveCategoria extends ConectionDB
    {
        public function saveCategoria()
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
                header('Location: ../categorias.php');
            }
            else if(isset($_POST['Action2']))
            {
                try {
                    //Capturar datos
                    $Nombre = $_POST["NombreCategoria"];
                     $Descripcion = $_POST["Descripcion"];
                     $State = 0;
                     //Validar que no exista
                     $query = "SELECT count(*) from tbl_categoria where NombreCategoria='".$Nombre."'";
                    $statement = $this->dbConnect->query($query);

                    if($statement->fetchColumn() >= 1)
                    {
                           header('Location: ../categorias.php?status=failed');
                    }
                    else
                    {
                            $query = " INSERT INTO tbl_categoria(NombreCategoria,Descripcion,State) VALUES(:NombreCategoria, :Descripcion, :State)";
                               $statement = $this->dbConnect->prepare($query);
                               $statement->execute(array(
                                ':NombreCategoria' => $Nombre,
                                ':Descripcion' => $Descripcion,
                                ':State' => $State
                            ));
                            $this->dbConnect = NULL;
                          header('Location: ../categorias.php?status=success');
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
    }
    $enter = new saveCategoria();
    $enter->Guardar();
?>
