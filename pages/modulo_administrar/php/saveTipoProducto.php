<?php
 session_start();
    require('../../../php/connection.php');

    class saveTipoProducto extends ConectionDB
    {
        public function saveTipoProducto()
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
                header('Location: ../tipoProductos.php');
            }
            else if(isset($_POST['Action2']))
            {
                try {
                    //Capturar datos
                    $NombreTipoProducto = $_POST["NombreTipoProducto"];
                     $State = 0;
                     //Validar que no exista
                     $query = "SELECT count(*) from tbl_tipoproducto where NombreTipoProducto='".$NombreTipoProducto."'";
                    $statement = $this->dbConnect->query($query);

                    if($statement->fetchColumn() >= 1)
                    {
                           header('Location: ../tipoProductos.php?status=failed');
                    }
                    else
                    {
                            $query = "INSERT INTO tbl_tipoproducto(NombreTipoProducto,State) VALUES(:NombreTipoProducto, :State)";
                               $statement = $this->dbConnect->prepare($query);
                               $statement->execute(array(
                                ':NombreTipoProducto' => $NombreTipoProducto,
                                ':State' => $State
                            ));
                            $this->dbConnect = NULL;
                          header('Location: ../tipoProductos.php?status=success');
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
    }
    $enter = new saveTipoProducto();
    $enter->Guardar();
?>
