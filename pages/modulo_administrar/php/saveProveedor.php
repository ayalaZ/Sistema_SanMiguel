<?php
 session_start();
    require('../../../php/connection.php');

    class saveProveedor extends ConectionDB
    {
        public function saveProveedor()
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
                header('Location: ../proveedores.php');
            }
            else if(isset($_POST['Action2']))
            {
                try {
                    //Capturar datos

                    $Nombre = $_POST["Nombre"];
                     $Representante = $_POST["Representante"];
                     $Telefono = $_POST["Telefono"];
                     $Correo = $_POST["Correo"];
                     $NRC = $_POST["NRC"];
                     $NIT = $_POST["NIT"];
                     $Nacionalidad = $_POST["Nacionalidad"];
                     $State = 0;
                     //Validar que no exista
                     $query = "SELECT count(*) from tbl_proveedor where Nombre = '".$Nombre."'";
                    $statement = $this->dbConnect->query($query);

                    if($statement->fetchColumn() >= 1)
                    {
                           header('Location: ../proveedores.php?status=failed');
                    }
                    else
                    {
                            $query = " INSERT INTO tbl_proveedor(Nombre,Representante,Telefono,Correo,NRC,NIT,Nacionalidad,State)
                             VALUES(:Nombre, :Representate, :Telefono, :Correo,:NRC, :NIT,:Nacionalidad, :State)";
                               $statement = $this->dbConnect->prepare($query);
                               $statement->execute(array(
                                ':Nombre' => $Nombre,
                                ':Representate' => $Representante,
                                ':Telefono' => $Telefono,
                                ':Correo' => $Correo,
                                ':NRC' => $NRC,
                                ':NIT' => $NIT,
                                ':Nacionalidad' => $Nacionalidad,
                                ':State' => $State
                            ));
                            $this->dbConnect = NULL;
                          header('Location: ../proveedores.php?status=success');
                    }
                    }
                    catch (Exception $e)
                    {
                        print "!Error¡: " . $e->getMessage() . "</br>";
                        die();
                        header('Location: ../proveedores.php?status=failed');
                   }
            }
        }
    }
    $enter = new saveProveedor();
    $enter->Guardar();
?>
